<?php

namespace App\Models;

use App\Support\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory;
    use SoftDeletes;

    const PHOTOS_PATH = 'img/authors';
    const PHOTOS_WIDTH = 320;
    const PHOTOS_HEIGHT = null;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::saving(function ($item) {
            self::resolveSlug($item);
        });

        static::deleting(function ($item) {
            $item->quotes->each(function ($quote) {
                $quote->delete();
            });
        });

        static::restored(function ($item) {
            $item->quotes()->onlyTrashed()->get()->each(function ($quote) {
                $quote->restore();
            });
        });

        static::forceDeleting(function ($item) {
            $item->quotes()->withTrashed()->get()->each(function ($quote) {
                $quote->forceDelete();
            });
        });
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function group()
    {
        return $this->belongsTo(AuthorGroup::class, 'group_id', 'id');
    }

    public function scopePersons($query)
    {
        return $query->where('group_id', AuthorGroup::getPersonsGroup()->id);
    }

    public function scopeMovies($query)
    {
        return $query->where('group_id', AuthorGroup::getMoviesGroup()->id);
    }

    public function scopeProverbs($query)
    {
        return $query->where('group_id', AuthorGroup::getProverbsGroup()->id);
    }

    public static function getItemsList()
    {
        $authors = Author::persons()
            ->orderBy('name', 'asc')
            ->select('name', 'slug')
            ->get();

        $authors->prepend(AuthorGroup::getMoviesGroup());
        $authors->prepend(AuthorGroup::getProverbsGroup());

        return $authors;
    }

    /**
     * Used in Authors Show page
     */
    public static function getAuthorBySlug($slug): \App\Models\Author|\App\Models\AuthorGroup
    {
        switch ($slug) {
                // Case MOVIES
            case AuthorGroup::MOVIES_GROUP_SLUG:
                $author = AuthorGroup::getMoviesGroup();
                break;

                // CASE PROVERBS
            case AuthorGroup::PROVERBS_GROUP_SLUG:
                $author = AuthorGroup::getProverbsGroup();
                break;

                // CASE PERSONS
            default:
                $author = Author::where('slug', $slug)->firstOrFail();
                break;
        }

        return $author;
    }

    /**
     * @param \App\Models\Author|\App\Models\AuthorGroup $author
     */
    public static function getAuthorQuotes($author)
    {
        // if $author is instance of App/Models/Author
        if ($author->group_id) {
            $quotes = $author->quotes();
            // if $author is instance of App/Models/AuthorGroup
        } else {
            switch ($author->name) {
                case AuthorGroup::MOVIES_GROUP_NAME:
                    $groupIDs = self::movies()->pluck('id');
                    break;

                case AuthorGroup::PROVERBS_GROUP_NAME:
                    $groupIDs = self::proverbs()->pluck('id');
                    break;
            }

            $quotes = Quote::whereIn('author_id', $groupIDs);
        }

        return Quote::getItemsSummarized($quotes);
    }

    public static function getDashSearchItems($onlyTrashed = false)
    {
        $items = self::query();

        if ($onlyTrashed) {
            $items = $items->onlyTrashed();
        }

        return $items->select('id', 'name')->orderBy('name')->get();
    }

    public static function getDashItemsFinalized($params, $onlyTrashed = false)
    {
        $items = self::query();

        if ($onlyTrashed) {
            $items = $items->onlyTrashed();
        }

        $items = self::dashFinalize($items, $params);

        return $items;
    }

    public static function dashFinalize($items, $params)
    {
        return $items
            ->orderBy($params['orderBy'], $params['orderType'])
            ->with(['group'])
            ->withCount('quotes')
            ->paginate(30, ['*'], 'page', $params['currentPage'])
            ->appends(request()->except('page'));
    }

    public static function getDashGroups()
    {
        return AuthorGroup::orderBy('id', 'asc')
            ->get();
    }

    public function uploadPhoto()
    {
        Helper::uploadModelsFile($this, 'photo', $this->slug, public_path(self::PHOTOS_PATH));
        Helper::resizeImage(Author::getPhotosPath($this), Author::PHOTOS_WIDTH, Author::PHOTOS_HEIGHT);
    }

    public function getPhotosPath($item)
    {
        return public_path(self::PHOTOS_PATH . '/' . $item->photo);
    }

    private static function resolveSlug($item)
    {
        if ($item->isDirty('name')) {
            $item->slug = Helper::generateUniqueSlug($item->name, self::class, $item->id);
        }
    }
}
