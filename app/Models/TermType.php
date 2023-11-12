<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermType extends Model
{
    use HasFactory;

    const SCIENTIFIC_TERMS = 'Термины научного мира';
    const EXPERT_COMMENTS = 'Комментарии специалистов';

    public $timestamp = false;
    protected $guarded = ['id'];

    public function terms()
    {
        return $this->hasMany(Term::class);
    }
}
