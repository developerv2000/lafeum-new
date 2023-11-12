<?php

namespace App\Models;

use App\Support\Traits\Treeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Knowledge extends Model
{
    use HasFactory;
    use NodeTrait;
    use Treeable;

    public $timestamps = false;
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::deleting(function ($item) {
            $item->terms()->detach();
        });
    }

    public function terms()
    {
        return $this->belongsToMany(Term::class);
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
            ->with('parent')
            ->withCount('terms')
            ->orderBy($params['orderBy'], $params['orderType'])
            ->paginate(30, ['*'], 'page', $params['currentPage'])
            ->appends(request()->except('page'));
    }
}
