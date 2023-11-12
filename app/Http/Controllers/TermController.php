<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTermRequest;
use App\Http\Requests\UpdateTermRequest;
use App\Models\Term;
use App\Models\TermCategory;
use App\Support\Helpers\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TermController extends Controller
{
    use Destroyable;

    // used in Destroyable Trait
    public $model = Term::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = TermCategory::getItemsTree();
        $activeCategoryIDs = (array) $request->cats;
        $terms = Term::getItemsSummarized();
        $subterms = Term::getJSONedSubterms($terms);

        return view('terms.index', compact('categories', 'terms', 'subterms', 'activeCategoryIDs'));
    }

    public function filter()
    {
        $terms = Term::getItemsSummarized($items = null, $paginationPath = 'terms.index');
        $subterms = Term::getJSONedSubterms($terms);

        return View::make('components.lists.terms', compact('terms', 'subterms'))->render();
    }

    /**
     * Display the specified resource.
     */
    public function show(Term $term)
    {
        return view('terms.show', compact('term'));
    }

    public function dashboardIndex(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('publish_at', 'desc');

        $items = Term::getDashItemsFinalized($params, $onlyTrashed = false);

        // used in search & counter
        $allItems = Term::getDashSearchItems($onlyTrashed = false);

        return view('dashboard.terms.index', compact('params', 'items', 'allItems'));
    }

    public function dashboardTrash(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('deleted_at', 'desc');

        $items = Term::getDashItemsFinalized($params, $onlyTrashed = true);

        // used in search & counter
        $allItems = Term::getDashSearchItems($onlyTrashed = true);

        return view('dashboard.terms.trash', compact('params', 'items', 'allItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Term::getDashTypes();
        $knowledges = Term::getDashKnowledges();
        $categories = Term::getDashCategories();

        return view('dashboard.terms.create', compact('types', 'knowledges', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTermRequest $request)
    {
        $item = Term::create($request->all());
        $item->categories()->attach($request->input('categories'));
        $item->knowledges()->attach($request->input('knowledges'));

        return redirect()->route('terms.dashboard.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Term $item)
    {
        $item->load(['categories', 'knowledges']);

        $types = Term::getDashTypes();
        $knowledges = Term::getDashKnowledges();
        $categories = Term::getDashCategories();

        return view('dashboard.terms.edit', compact('item', 'types', 'knowledges', 'categories',));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTermRequest $request)
    {
        $item = Term::find($request->id);
        $item->update($request->all());
        $item->categories()->sync($request->input('categories'));
        $item->knowledges()->sync($request->input('knowledges'));

        return redirect($request->input('previous_url'));
    }
}
