<?php

namespace App\Http\Controllers;

use App\Support\Helpers\Helper;
use App\Support\Traits\NestedSetUpdateable;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use NestedSetUpdateable;

    public $model;

    public function __construct(Request $request)
    {
        $this->model = 'App\Models\\' . $request->model;
    }

    public function dashboardIndex(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('name', 'asc');

        $items = $this->model::with('parent')
            ->orderBy('name', 'asc')
            ->paginate(30)
            ->appends($request->except('page'));

        // used in search & counter
        $allItems = $this->model::select('id', 'name')->orderBy('name')->get();

        return view('dashboard.categories.index', compact('params', 'items', 'allItems'));
    }

    public function editNestedset(Request $request)
    {
        $items = $this->model::getItemsTree();

        return view('dashboard.categories.edit-structure', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roots = $this->model::whereIsRoot()->get();

        return view('dashboard.categories.create', compact('roots'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->except('parent_id');
        $this->model::create($attributes, $this->model::find($request->parent_id));

        return redirect()->route('categories.dashboard.index', ['model' => $request->model]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = $this->model::find($id);
        $roots = $this->model::whereIsRoot()->get();

        return view('dashboard.categories.edit', compact('item', 'roots'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $item = $this->model::find($request->id);
        $item->update($request->all());

        return redirect($request->input('previous_url'));
    }
}
