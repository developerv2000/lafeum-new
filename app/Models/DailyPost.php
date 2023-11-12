<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;
use App\Models\Quote;
use App\Models\Term;
use App\Models\Video;

class DailyPost extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public static function generate()
    {
        DailyPost::create([
            'date' => now(),
            'quote_id' => Quote::published()->inRandomOrder()->first()->id,
            'term_id' => Term::published()->inRandomOrder()->first()->id,
            'video_id' => Video::published()->inRandomOrder()->first()->id,
            'photo_id' => Photo::published()->inRandomOrder()->first()->id
        ]);
    }
}
