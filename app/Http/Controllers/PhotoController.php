<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Models\Photo;
use App\Models\PhotoCategory;
use App\Support\Helpers\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PhotoController extends Controller
{
    use Destroyable;

    // used in Destroyable Trait
    public $model = Photo::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = PhotoCategory::getItemsTree();
        $activeCategoryIDs = (array) $request->cats;
        $photos = Photo::getItemsSummarized();

        return view('photos.index', compact('categories', 'photos', 'activeCategoryIDs'));
    }

    public function filter()
    {
        $photos = Photo::getItemsSummarized($items = null, $paginationPath = 'photos.index');

        return View::make('components.lists.photos', compact('photos'))->render();
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        return view('photos.show', compact('photo'));
    }

    public function dashboardIndex()
    {
        // order parameters
        $params = Helper::getRequestParams('publish_at', 'desc');

        $items = Photo::getDashItemsFinalized($params, $onlyTrashed = false);

        // used in search & counter
        $allItems = Photo::getDashSearchItems($onlyTrashed = false);

        return view('dashboard.photos.index', compact('params', 'items', 'allItems'));
    }

    public function dashboardTrash(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('deleted_at', 'desc');

        $items = Photo::getDashItemsFinalized($params, $onlyTrashed = true);

        // used in search & counter
        $allItems = Photo::getDashSearchItems($onlyTrashed = true);

        return view('dashboard.photos.trash', compact('params', 'items', 'allItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Photo::getDashCategories();

        return view('dashboard.photos.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhotoRequest $request)
    {
        $item = new Photo($request->except('photo'));
        $item->filename = 'uploading';
        $item->save();
        $item->uploadFiles();
        $item->categories()->attach($request->input('categories'));

        return redirect()->route('photos.dashboard.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $item)
    {
        $item->load(['categories']);
        $categories = Photo::getDashCategories();

        return view('dashboard.photos.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhotoRequest $request)
    {
        $item = Photo::find($request->id);
        $item->update($request->except('filename'));
        $item->categories()->sync($request->input('categories'));

        if ($request->file('filename')) {
            $item->uploadFiles();
        }

        return redirect($request->input('previous_url'));
    }
}
