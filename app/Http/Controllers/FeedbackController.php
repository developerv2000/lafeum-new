<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Support\Helpers\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    use Destroyable;

    // used in Destroyable Trait
    public $model = Feedback::class;

    public function store(Request $request)
    {
        Feedback::create($request->all());

        return redirect()->back();
    }

    public function dashboardIndex(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('created_at', 'asc');

        $items = Feedback::getDashItemsFinalized($params);

        // used in search & counter
        $allItems = Feedback::getDashSearchItems();

        return view('dashboard.feedbacks.index', compact('params', 'items', 'allItems'));
    }
}
