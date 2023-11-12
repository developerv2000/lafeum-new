<?php

namespace App\Support\Traits;

use App\Models\Like;

trait Likeable
{
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function likedBy($userID)
    {
        return $this->likes->contains('user_id', $userID);
    }

    public function likesCount()
    {
        return $this->likes()->count();
    }
}
