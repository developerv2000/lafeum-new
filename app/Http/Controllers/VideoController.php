<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Support\Helpers\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class VideoController extends Controller
{
    use Destroyable;

    // used in Destroyable Trait
    public $model = Video::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = VideoCategory::getItemsTree();
        $activeCategoryIDs = (array) $request->cats;
        $videos = Video::getItemsSummarized();

        return view('videos.index', compact('categories',  'videos', 'activeCategoryIDs'));
    }

    public function filter()
    {
        $videos = Video::getItemsSummarized($items = null, $paginationPath = 'videos.index');

        return View::make('components.lists.videos', compact('videos'))->render();
    }

    public function show(Video $video)
    {
        return view('videos.show', compact('video'));
    }

    public function dashboardIndex()
    {
        // order parameters
        $params = Helper::getRequestParams('publish_at', 'desc');

        $items = Video::getDashItemsFinalized($params, $onlyTrashed = false);

        // used in search & counter
        $allItems = Video::getDashSearchItems($onlyTrashed = false);

        return view('dashboard.videos.index', compact('params', 'items', 'allItems'));
    }

    public function dashboardTrash(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('deleted_at', 'desc');

        $items = Video::getDashItemsFinalized($params, $onlyTrashed = true);

        // used in search & counter
        $allItems = Video::getDashSearchItems($onlyTrashed = true);

        return view('dashboard.videos.trash', compact('params', 'items', 'allItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $channels = Video::getDashChannels();
        $categories = Video::getDashCategories();

        return view('dashboard.videos.create', compact('channels', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoRequest $request)
    {
        $item = Video::create($request->all());
        $item->categories()->attach($request->input('categories'));

        return redirect()->route('videos.dashboard.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $item)
    {
        $item->load(['categories', 'channel']);

        $channels = Video::getDashChannels();
        $categories = Video::getDashCategories();

        return view('dashboard.videos.edit', compact('item', 'channels', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVideoRequest $request)
    {
        $item = Video::find($request->id);
        $item->update($request->all());
        $item->categories()->sync($request->input('categories'));

        return redirect($request->input('previous_url'));
    }
}
