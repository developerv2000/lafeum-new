<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Helpers\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Destroyable;

    // used in Destroyable Trait
    public $model = User::class;

    public function dashboardIndex(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('created_at', 'asc');

        $items = User::getDashItemsFinalized($params);

        // used in search & counter
        $allItems = User::getDashSearchItems();

        return view('dashboard.users.index', compact('params', 'items', 'allItems'));
    }
}
