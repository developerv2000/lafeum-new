<?php

namespace App\Models;

use App\Support\Helpers\Helper;
use App\Support\Traits\Favoritable;
use App\Support\Traits\Likeable;
use App\Support\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Publishable;
    use Favoritable;
    use Likeable;

    protected $guarded = ['id'];

    const FILE_PATH = 'img/photos';
    const FILE_THUMBS_PATH = 'img/photos/thumbs';
    const FILE_THUMB_WIDTH = 420;
    const FILE_THUMB_HEIGHT = null;

    protected static function booted(): void
    {
        static::forceDeleting(function ($item) {
            $item->categories()->detach();
        });
    }

    public function categories()
    {
        return $this->belongsToMany(PhotoCategory::class, 'category_photo', 'photo_id', 'category_id');
    }

    public static function getItemsSummarized($items = null, $paginationPath = null)
    {
        $photos = $items ?: Photo::query()->distinct();
        $photos = self::filter($photos);
        $photos = self::summarize($photos, $paginationPath);

        return $photos;
    }

    /**
     * Used in likes.index route
     */
    public function containsKeyword($keyword): bool
    {
        $description = mb_strtolower($this->description);
        $keyword = mb_strtolower($keyword);

        return str_contains($description, $keyword);
    }

    /**
     * Used in likes.index route
     */
    public function loadRelations()
    {
        $this->load([
            'categories'
        ]);

        return $this;
    }

    private static function filter($photos)
    {
        $request = request();
        $keyword = $request->keyword;
        $categoryIDs = $request->cats;

        if ($keyword) {
            $photos = $photos->where('description', 'LIKE', '%' . $keyword . '%');
        }

        if ($categoryIDs) {
            $photos = $photos->whereHas('categories', function ($query) use ($categoryIDs) {
                $query->whereIn('id', $categoryIDs);
            });
        }

        return $photos;
    }

    private static function summarize($photos, $paginationPath = null)
    {
        $photos = $photos->with(['categories'])
            ->published('desc')
            ->paginate(12)
            ->appends(request()->except('page'));

        if ($paginationPath) {
            $photos->setPath(route($paginationPath));
        }

        return $photos;
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
        return $items->where('photos.description', 'LIKE', '%' . $params['keyword'] . '%');
    }

    public static function dashFinalize($items, $params)
    {
        return $items
            ->orderBy($params['orderBy'], $params['orderType'])
            ->with('categories')
            ->paginate(30, ['*'], 'page', $params['currentPage'])
            ->appends(request()->except('page'));
    }

    public static function getDashCategories()
    {
        return PhotoCategory::orderBy('name', 'asc')
            ->select('name', 'id')
            ->get();
    }

    public function uploadFiles()
    {
        Helper::uploadModelsFile($this, 'filename', $this->id, public_path(self::FILE_PATH));

        Helper::createThumb(
            public_path(self::FILE_PATH),
            $this->filename,
            self::FILE_THUMBS_PATH,
            self::FILE_THUMB_WIDTH,
            self::FILE_THUMB_HEIGHT
        );

        $this->save();
    }
}
