<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;
use App\Models\Channel;
use App\Models\Video;
use App\Support\Helpers\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    use Destroyable;

    // used in Destroyable Trait
    public $model = Channel::class;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $channels = Channel::getItemsList();

        return view('channels.index', compact('channels'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Channel $channel)
    {
        $channels = Channel::getItemsList();
        $videos = Video::getItemsSummarized($channel->videos());

        return view('channels.show', compact('channel', 'channels', 'videos'));
    }

    public function dashboardIndex(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('name', 'asc');

        $items = Channel::getDashItemsFinalized($params, $onlyTrashed = false);

        // used in search & counter
        $allItems = Channel::getDashSearchItems($onlyTrashed = false);

        return view('dashboard.channels.index', compact('params', 'items', 'allItems'));
    }

    public function dashboardTrash(Request $request)
    {
        // order parameters
        $params = Helper::getRequestParams('deleted_at', 'desc');

        $items = Channel::getDashItemsFinalized($params, $onlyTrashed = true);

        // used in search & counter
        $allItems = Channel::getDashSearchItems($onlyTrashed = true);

        return view('dashboard.channels.trash', compact('params', 'items', 'allItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.channels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChannelRequest $request)
    {
        Channel::create($request->all());

        return redirect()->route('channels.dashboard.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Channel $item)
    {
        return view('dashboard.channels.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChannelRequest $request)
    {
        Channel::find($request->id)->update($request->all());

        return redirect($request->input('previous_url'));
    }
}
