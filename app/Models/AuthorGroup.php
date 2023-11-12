<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorGroup extends Model
{
    use HasFactory;

    const PERSONS_GROUP_NAME = 'Автор';

    const MOVIES_GROUP_NAME = 'Фильмы и Сериалы';
    const MOVIES_GROUP_SLUG = 'filmy-i-serialy';
    const MOVIES_GROUP_DESCRIPTION = 'Фильмы и Сериалы. Здесь собраны лучшие высказывания и цитаты из фильмов и сериалов всех времен.';

    const PROVERBS_GROUP_NAME = 'Пословицы и поговорки';
    const PROVERBS_GROUP_SLUG = 'poslovicy-i-pogovorki';
    const PROVERBS_GROUP_DESCRIPTION = 'Пословицы и поговорки. Коллекция пословиц и поговорок народов мира. В них собраны плоды опытности народов и здравый смысл.';

    public $timestamps = false;
    protected $guarded = ['id'];

    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    /**
     * Used in Authors Show page
     */
    public function getBiographyAttribute()
    {
        return $this->description;
    }

    public static function getPersonsGroup()
    {
        return self::where('name', AuthorGroup::PERSONS_GROUP_NAME)->first();
    }

    public static function getMoviesGroup()
    {
        return self::where('name', AuthorGroup::MOVIES_GROUP_NAME)->first();
    }

    public static function getProverbsGroup()
    {
        return self::where('name', AuthorGroup::PROVERBS_GROUP_NAME)->first();
    }
}
