<?php

namespace App\Models;

use App\Support\Traits\Favoritable;
use App\Support\Traits\Likeable;
use App\Support\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Js;

class Term extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Publishable;
    use Favoritable;
    use Likeable;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::forceDeleting(function ($item) {
            $item->categories()->detach();
            $item->knowledges()->detach();
        });
    }

    public function type()
    {
        return $this->belongsTo(TermType::class, 'type_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(TermCategory::class, 'category_term', 'term_id', 'category_id');
    }

    public function knowledges()
    {
        return $this->belongsToMany(Knowledge::class);
    }

    public function scopeVocabulary($query)
    {
        return $query->where('name', '!=', '')
            ->where('show_in_vocabulary', true);
    }

    public function getSubtermsAttribute()
    {
        // get all links
        preg_match_all('/https?:\/\/(www\.)?lafeum\.ru[^\s]*/', $this->body, $links);

        // extract all ids from links path (https://domain.com/term/{id})
        $ids = array();

        foreach ($links[0] as $link) {
            $parsed = parse_url($link);
            $ids[] = substr($parsed['path'], 6);
        }

        $subterms = Term::whereIn('id', $ids)->select('id', 'body')->get();

        return $subterms;
    }

    // Used in JS on subterms popup
    public static function getJSONedSubterms($terms)
    {
        $subtermsList = array();

        foreach ($terms as $term) {
            foreach ($term->subterms as $subterm) {
                array_push($subtermsList, [
                    'id' => $subterm->id,
                    'body' => $subterm->body
                ]);
            }
        }

        return JS::from($subtermsList);
    }

    /**
     * Used in MIXED lists
     */
    public static function getJSONedSubtermsFromMixed($items)
    {
        $terms = new Collection();

        // pluck terms
        foreach ($items as $item) {
            if (get_class($item) == Term::class) {
                $terms->push($item);
            }
        }

        $subterms = self::getJSONedSubterms($terms);

        return $subterms;
    }

    public static function getItemsSummarized($items = null, $paginationPath = null)
    {
        $terms = $items ?: Term::query();
        $terms = self::filter($terms);
        $terms = self::summarize($terms, $paginationPath);

        return $terms;
    }

    public static function getVocabularyItemsSummarized($items = null)
    {
        $terms = $items ?: self::vocabulary();
        $terms = self::filterVocabulary($terms);
        $terms = self::summarizeVocabulary($terms);

        return $terms;
    }

    /**
     * Used in likes.index route
     */
    public function containsKeyword($keyword): bool
    {
        $body = mb_strtolower($this->body);
        $keyword = mb_strtolower($keyword);

        return str_contains($body, $keyword);
    }

    /**
     * Used in likes.index route
     */
    public function loadRelations()
    {
        $this->load([
            'categories',
            'type'
        ]);

        return $this;
    }

    private static function filter($terms)
    {
        $request = request();
        $keyword = $request->keyword;
        $categoryIDs = $request->cats;

        if ($keyword) {
            $terms = $terms->where('body', 'LIKE', '%' . $keyword . '%');
        }

        if ($categoryIDs) {
            $terms = $terms->whereHas('categories', function ($query) use ($categoryIDs) {
                $query->whereIn('id', $categoryIDs);
            });
        }

        return $terms;
    }

    private static function summarize($terms, $paginationPath = null)
    {
        $terms = $terms->with(['categories', 'type'])
            ->published('desc')
            ->paginate(20)
            ->appends(request()->except('page'));

        if ($paginationPath) {
            $terms->setPath(route($paginationPath));
        }

        return $terms;
    }

    private static function filterVocabulary($terms)
    {
        $request = request();
        $keyword = $request->keyword;
        $categoryIDs = $request->cats;

        if ($keyword) {
            $terms = $terms->where('name', 'LIKE', '%' . $keyword . '%');
        }

        if ($categoryIDs) {
            $terms = $terms->whereHas('categories', function ($query) use ($categoryIDs) {
                $query->whereIn('id', $categoryIDs);
            });
        }

        return $terms;
    }

    private static function summarizeVocabulary($terms)
    {
        $terms = $terms->published()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return $terms;
    }

    public static function getDashSearchItems($onlyTrashed = false)
    {
        $items = self::query();

        if ($onlyTrashed) {
            $items = $items->onlyTrashed();
        }

        return $items->select('id')->get();
    }

    public static function getDashItemsFinalized($params, $onlyTrashed = false)
    {
        $items = self::query();

        if ($onlyTrashed) {
            $items = $items->onlyTrashed();
        }

        $items = self::dashFilter($items, $params);
        $items = self::dashFinalize($items, $params);

        return $items;
    }

    public static function dashFilter($items, $params)
    {
        return $items->where('terms.body', 'LIKE', '%' . $params['keyword'] . '%');
    }

    public static function dashFinalize($items, $params)
    {
        return $items
            ->join('term_types', 'terms.type_id', '=', 'term_types.id')
            ->select('terms.*', 'term_types.name as type')
            ->orderBy($params['orderBy'], $params['orderType'])
            ->with(['knowledges', 'categories'])
            ->paginate(30, ['*'], 'page', $params['currentPage'])
            ->appends(request()->except('page'));
    }

    public static function getDashTypes()
    {
        return TermType::orderBy('name', 'asc')
            ->get();
    }

    public static function getDashKnowledges()
    {
        return Knowledge::orderBy('name', 'asc')
            ->select('name', 'id')
            ->get();
    }

    public static function getDashCategories()
    {
        return TermCategory::orderBy('name', 'asc')
            ->select('name', 'id')
            ->get();
    }
}
