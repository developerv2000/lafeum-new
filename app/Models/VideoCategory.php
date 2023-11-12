<?php

namespace App\Models;

use App\Support\Traits\Treeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class VideoCategory extends Model
{
    use HasFactory;
    use NodeTrait;
    use Treeable;

    public $timestamps = false;
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::deleting(function ($item) {
            $item->videos()->detach();
        });
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'category_video', 'category_id');
    }
}
