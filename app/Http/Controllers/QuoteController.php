<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Models\Quote;
use App\Models\QuoteCategory;
use App\Support\Helpers\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class QuoteController extends Controller
{
    use Destroyable;

    // used in Destroyable Trait
    public $model = Quote::class;

    public function index(Request $request)
    {
        $categories = QuoteCategory::getItemsTree();
        $activeCategoryIDs = (array) $request->cats;
        $quotes = Quote::getItemsSummarized();

        return view('quotes.index', compact('categories', 'quotes', 'activeCategoryIDs'));
    }

    public function filter()
    {
        $quotes = Quote::getItemsSummarized($items = null, $paginationPath = 'quotes.index');

        return View::make('components.lists.quotes', compact('quotes'))->render();
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        return view('quotes.show', compact('quote'));
    }

    public function dashboardIndex()
    {
        // order parameters
        $params = Helper::getRequestParams('publish_at', 'desc');

        $items = Quote::getDashItemsFinalized($params, $onlyTrashed = false);

        // used in search & counter
        $allItems = Quote::getDashSearchItems($onlyTrashed = false);

        return view('dashboard.quotes.index', compact('params', 'items', 'allItems'));
    }

    public function dashboardTrash(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('deleted_at', 'desc');

        $items = Quote::getDashItemsFinalized($params, $onlyTrashed = true);

        // used in search & counter
        $allItems = Quote::getDashSearchItems($onlyTrashed = true);

        return view('dashboard.quotes.trash', compact('params', 'items', 'allItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Quote::getDashAuthors();
        $categories = Quote::getDashCategories();

        return view('dashboard.quotes.create', compact('authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuoteRequest $request)
    {
        $item = Quote::create($request->all());
        $item->categories()->attach($request->input('categories'));

        return redirect()->route('quotes.dashboard.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $item)
    {
        $item->load(['categories', 'author']);

        $authors = Quote::getDashAuthors();
        $categories = Quote::getDashCategories();

        return view('dashboard.quotes.edit', compact('item', 'authors', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuoteRequest $request)
    {
        $item = Quote::find($request->id);
        $item->update($request->all());
        $item->categories()->sync($request->input('categories'));

        return redirect($request->input('previous_url'));
    }
}
