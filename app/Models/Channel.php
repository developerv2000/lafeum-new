<?php

namespace App\Models;

use App\Support\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::saving(function ($item) {
            self::resolveSlug($item);
        });

        static::deleting(function ($item) {
            $item->videos->each(function ($video) {
                $video->delete();
            });
        });

        static::restored(function ($item) {
            $item->videos()->onlyTrashed()->get()->each(function ($video) {
                $video->restore();
            });
        });

        static::forceDeleting(function ($item) {
            $item->videos()->withTrashed()->get()->each(function ($video) {
                $video->forceDelete();
            });
        });
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public static function getItemsList()
    {
        return self::select('name', 'slug')
            ->orderBy('name')
            ->get();
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
            ->withCount('videos')
            ->paginate(30, ['*'], 'page', $params['currentPage'])
            ->appends(request()->except('page'));
    }

    private static function resolveSlug($item)
    {
        if ($item->isDirty('name')) {
            $item->slug = Helper::generateUniqueSlug($item->name, self::class, $item->id);
        }
    }
}
