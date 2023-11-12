<?php

namespace App\Models;

use App\Support\Traits\Favoritable;
use App\Support\Traits\Likeable;
use App\Support\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Favoritable;
    use Publishable;
    use Likeable;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::forceDeleting(function ($item) {
            $item->categories()->detach();
        });
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function categories()
    {
        return $this->belongsToMany(QuoteCategory::class, 'category_quote', 'quote_id', 'category_id');
    }

    public static function getItemsSummarized($items = null, $paginationPath = null)
    {
        $quotes = $items ?: self::query();
        $quotes = self::filter($quotes);
        $quotes = self::summarize($quotes, $paginationPath);

        return $quotes;
    }

    private static function filter($quotes)
    {
        $request = request();
        $keyword = $request->keyword;
        $categoryIDs = $request->cats;

        if ($keyword) {
            $quotes = $quotes->where('body', 'LIKE', "%{$keyword}%");
        }

        if ($categoryIDs) {
            $quotes = $quotes->whereHas('categories', function ($query) use ($categoryIDs) {
                $query->whereIn('id', $categoryIDs);
            });
        }

        return $quotes;
    }

    private static function summarize($quotes, $paginationPath = null)
    {
        $quotes = $quotes->with([
            'author:id,name,slug',
            'categories:id,name'
        ])
            ->published('desc')
            ->paginate(20)
            ->appends(request()->except('page'));

        if ($paginationPath) {
            $quotes->setPath(route($paginationPath));
        }

        return $quotes;
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
            'author:id,name,slug',
            'categories:id,name'
        ]);

        return $this;
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
        return $items->where('quotes.body', 'LIKE', '%' . $params['keyword'] . '%');
    }

    public static function dashFinalize($items, $params)
    {
        return $items
            ->join('authors', 'quotes.author_id', '=', 'authors.id')
            ->select('quotes.*', 'authors.name as author_name')
            ->orderBy($params['orderBy'], $params['orderType'])
            ->with('categories')
            ->paginate(30, ['*'], 'page', $params['currentPage'])
            ->appends(request()->except('page'));
    }

    public static function getDashAuthors()
    {
        return Author::orderBy('name', 'asc')
            ->select('name', 'id')
            ->get();
    }

    public static function getDashCategories()
    {
        return QuoteCategory::orderBy('name', 'asc')
            ->select('name', 'id')
            ->get();
    }
}
