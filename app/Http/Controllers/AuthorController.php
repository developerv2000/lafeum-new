<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\AuthorGroup;
use App\Models\Quote;
use App\Support\Helpers\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    use Destroyable;

    // used in Destroyable Trait
    public $model = Author::class;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::getItemsList();

        return view('authors.index', compact('authors'));
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $authors = Author::getItemsList();
        $author = Author::getAuthorBySlug($slug);
        $quotes = Author::getAuthorQuotes($author);

        return view('authors.show', compact('author', 'authors', 'quotes'));
    }

    public function dashboardIndex(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('name', 'asc');

        $items = Author::getDashItemsFinalized($params, $onlyTrashed = false);

        // used in search & counter
        $allItems = Author::getDashSearchItems($onlyTrashed = false);

        return view('dashboard.authors.index', compact('params', 'items', 'allItems'));
    }

    public function dashboardTrash(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('deleted_at', 'desc');

        $items = Author::getDashItemsFinalized($params, $onlyTrashed = true);

        // used in search & counter
        $allItems = Author::getDashSearchItems($onlyTrashed = true);

        return view('dashboard.authors.trash', compact('params', 'items', 'allItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = Author::getDashGroups();

        return view('dashboard.authors.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $item = new Author($request->except('photo'));
        $item->photo = 'uploading';
        $item->save();
        $item->uploadPhoto();

        return redirect()->route('authors.dashboard.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $item)
    {
        $item->load(['group']);
        $groups = Author::getDashGroups();

        return view('dashboard.authors.edit', compact('item', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request)
    {
        $item = Author::find($request->id);
        $item->fill($request->except('photo'));
        $item->save();

        if ($request->file('photo')) {
            $item->uploadPhoto();
        }

        return redirect($request->input('previous_url'));
    }
}
