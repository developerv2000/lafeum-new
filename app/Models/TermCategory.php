<?php

namespace App\Models;

use App\Support\Traits\Treeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class TermCategory extends Model
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
        return $this->belongsToMany(Term::class, 'category_term', 'category_id');
    }
}
