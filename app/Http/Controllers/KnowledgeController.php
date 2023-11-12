<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKnowledgeRequest;
use App\Http\Requests\UpdateKnowledgeRequest;
use App\Models\Knowledge;
use App\Models\Term;
use App\Support\Helpers\Helper;
use App\Support\Traits\NestedSetUpdateable;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    use NestedSetUpdateable;

    // used in Destroyable & NestedSetUpdateable Traits
    public $model = Knowledge::class;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $knowledges = Knowledge::getItemsTree();

        return view('knowledge.index', compact('knowledges'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Knowledge $knowledge)
    {
        $knowledges = Knowledge::getItemsTree();
        $terms = Term::getItemsSummarized($knowledge->terms());
        $subterms = Term::getJSONedSubterms($terms);

        return view('knowledge.show', compact('knowledges', 'knowledge', 'terms', 'subterms'));
    }

    public function dashboardIndex(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('name', 'asc');

        $items = Knowledge::getDashItemsFinalized($params, $onlyTrashed = false);

        // used in search & counter
        $allItems = Knowledge::getDashSearchItems($onlyTrashed = false);

        return view('dashboard.knowledge.index', compact('params', 'items', 'allItems'));
    }

    public function editNestedset(Request $request)
    {
        $items = Knowledge::getItemsTree();

        return view('dashboard.knowledge.edit-structure', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roots = Knowledge::whereIsRoot()->get();

        return view('dashboard.knowledge.create', compact('roots'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKnowledgeRequest $request)
    {
        $attributes = $request->except('parent_id');
        $attributes['slug'] = Helper::generateUniqueSlug($attributes['name'], Knowledge::class);
        Knowledge::create($attributes, Knowledge::find($request->parent_id));

        return redirect()->route('knowledge.dashboard.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Knowledge $item)
    {
        $roots = Knowledge::whereIsRoot()->get();

        return view('dashboard.knowledge.edit', compact('item', 'roots'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKnowledgeRequest $request)
    {
        $item = Knowledge::find($request->id);
        $item->update($request->all());

        return redirect($request->input('previous_url'));
    }
}
