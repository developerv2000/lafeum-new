<?php

namespace App\Support\Traits;

use App\Models\Favorite;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function favoritedBy($userID, $folderID = null)
    {
        return $folderID ?
            $this->favorites->contains('folder_id', $folderID)
            : $this->favorites->contains('user_id', $userID);
    }
}
