<?php

namespace App\Models;

use App\Support\Helpers\Helper;
use App\Support\Traits\Favoritable;
use App\Support\Traits\Likeable;
use App\Support\Traits\Publishable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Favoritable;
    use Publishable;
    use Likeable;

    protected $guarded = ['id'];
    protected $appends = ['link', 'embed_link', 'thumbnail'];

    protected static function booted(): void
    {
        static::forceDeleting(function ($item) {
            $item->categories()->detach();
        });
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function categories()
    {
        return $this->belongsToMany(VideoCategory::class, 'category_video', 'video_id', 'category_id');
    }

    public function getLinkAttribute()
    {
        return 'https://youtu.be/' . $this->host_id;
    }

    public function getEmbedLinkAttribute()
    {
        return 'https://www.youtube.com/embed/' . $this->host_id;
    }

    public function getThumbnailAttribute()
    {
        return 'https://i.ytimg.com/vi/' . $this->host_id . '/mqdefault.jpg';
    }

    protected function hostId(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => $this->getYoutubeID($value)
        );
    }

    /**
     * Used in likes.index route
     */
    public function containsKeyword($keyword): bool
    {
        $title = mb_strtolower($this->title);
        $keyword = mb_strtolower($keyword);

        return str_contains($title, $keyword);
    }

    /**
     * Used in likes.index route
     */
    public function loadRelations()
    {
        $this->load([
            'channel:id,name,slug',
            'categories',
        ]);

        return $this;
    }

    public static function getItemsSummarized($items = null, $paginationPath = null)
    {
        $videos = $items ?: Video::query();
        $videos = self::filter($videos);
        $videos = self::summarize($videos, $paginationPath);

        return $videos;
    }

    private static function filter($videos)
    {
        $request = request();
        $keyword = $request->keyword;
        $categoryIDs = $request->cats;

        if ($keyword) {
            $videos = $videos->where('title', 'LIKE', "%{$keyword}%");
        }

        if ($categoryIDs) {
            $videos = $videos->whereHas('categories', function ($query) use ($categoryIDs) {
                $query->whereIn('id', $categoryIDs);
            });
        }

        return $videos;
    }

    private static function summarize($videos, $paginationPath = null)
    {
        $videos = $videos->with([
            'channel:id,name,slug',
            'categories',
        ])
            ->published('desc')
            ->paginate(20)
            ->appends(request()->except('page'));

        if ($paginationPath) {
            $videos->setPath(route($paginationPath));
        }

        return $videos;
    }

    public static function getDashSearchItems($onlyTrashed = false)
    {
        $items = self::query();

        if ($onlyTrashed) {
            $items = $items->onlyTrashed();
        }

        return $items->select('id', 'title')->orderBy('title')->get();
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
            ->join('channels', 'videos.channel_id', '=', 'channels.id')
            ->select('videos.*', 'channels.name as channel_name')
            ->orderBy($params['orderBy'], $params['orderType'])
            ->with('categories')
            ->paginate(30, ['*'], 'page', $params['currentPage'])
            ->appends(request()->except('page'));
    }

    public static function getDashChannels()
    {
        return Channel::orderBy('name', 'asc')
            ->select('name', 'id')
            ->get();
    }

    public static function getDashCategories()
    {
        return VideoCategory::orderBy('name', 'asc')
            ->select('name', 'id')
            ->get();
    }

    private function getYoutubeID($link)
    {
        $youtubeIdRegEx = '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

        $pregMatchOutput = [];

        $matched = preg_match($youtubeIdRegEx, $link, $pregMatchOutput);

        if ($matched && count($pregMatchOutput) === 2) {
            return $pregMatchOutput[1];
        }

        return null;
    }
}
