<?php

namespace App\Models;

use App\Support\Traits\Treeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class PhotoCategory extends Model
{
    use HasFactory;
    use NodeTrait;
    use Treeable;

    public $timestamps = false;
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::deleting(function ($item) {
            $item->photos()->detach();
        });

        static::deleted(function ($item) {
            $item->photos()->detach();
        });
    }

    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'category_photo', 'category_id');
    }
}
