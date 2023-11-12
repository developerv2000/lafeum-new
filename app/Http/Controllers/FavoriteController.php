<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Photo;
use App\Models\Quote;
use App\Models\Term;
use App\Models\Video;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $rootFolders = request()->user()->rootFolders;

        return view('favorites.index', compact('rootFolders'));
    }

    public function toggle(Request $request)
    {
        $model = $request->model;
        $favoritableModels = array(Quote::class, Term::class, Video::class, Photo::class);

        // escape hacks
        if (in_array($model, $favoritableModels)) {
            $instance = $model::find($request->modelID);
            $folderIDs = $request->folderIDs;
            $user = request()->user();

            // Refresh Favorites
            $instance->favorites()->where('user_id', $user->id)->delete();

            foreach ($folderIDs as $id) {
                $favorite = new Favorite(['user_id' => $user->id, 'folder_id' => $id]);
                $instance->favorites()->save($favorite);
            }
        }

        return count($folderIDs) ? 'favorited' : 'unfavorited';
    }
}
