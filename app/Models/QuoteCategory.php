<?php

namespace App\Models;

use App\Support\Traits\Treeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class QuoteCategory extends Model
{
    use HasFactory;
    use NodeTrait;
    use Treeable;

    public $timestamps = false;
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::deleting(function ($item) {
            $item->quotes()->detach();
        });
    }

    public function quotes()
    {
        return $this->belongsToMany(Quote::class, 'category_quote', 'category_id');
    }
}
