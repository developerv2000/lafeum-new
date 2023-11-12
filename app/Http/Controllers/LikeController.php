<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Photo;
use App\Models\Quote;
use App\Models\Term;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LikeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $items = $user->getLikedItems($request->keyword);

        // Manual Pagination
        $options = ['path' => url()->current()];
        $perPage = 20;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $items->forPage($currentPage, $perPage);

        $paginatedItems = new LengthAwarePaginator($currentItems, count($items), $perPage, $currentPage, $options);
        $subterms = Term::getJSONedSubtermsFromMixed($paginatedItems);

        return view('likes.index', compact('paginatedItems', 'subterms'));
    }

    public function toggle(Request $request)
    {
        $model = $request->model;

        $likeableModels = array(
            Quote::class,
            Term::class,
            Video::class,
            Photo::class
        );

        // escape hacks
        if (in_array($model, $likeableModels)) {
            $instance = $model::find($request->modelID);
            $userID = request()->user()->id;

            if ($instance->likedBy($userID)) {
                $instance->likes()->where('user_id', $userID)->delete();
                return 'unliked';
            } else {
                $like = new Like(['user_id' => $userID]);
                $instance->likes()->save($like);
                return 'liked';
            }
        }
    }
}
