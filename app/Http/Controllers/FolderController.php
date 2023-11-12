<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class FolderController extends Controller
{
    public function show(Request $request, $id)
    {
        $folder = $request->user()->folders()->where('id', $id)->firstOrFail();
        $items = $folder->getItems($request->keyword);

        // Manual Pagination
        $options = ['path' => url()->current()];
        $perPage = 20;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $items->forPage($currentPage, $perPage);

        $paginatedItems = new LengthAwarePaginator($currentItems, count($items), $perPage, $currentPage, $options);
        $subterms = Term::getJSONedSubtermsFromMixed($paginatedItems);

        return view('folders.show', compact('folder', 'paginatedItems', 'subterms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['string', 'max:255']
        ]);

        $highestPriority = Folder::getLevelsHighestPriority($request->parent_id);

        $request->user()->folders()->save(
            new Folder([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'priority' => ++$highestPriority
            ])
        );

        return redirect()->back();
    }

    public static function upgrade(Request $request)
    {
        $folder = $request->user()->folders()->where('id', $request->id)->firstOrFail();
        Folder::upgrade($folder);

        return redirect()->back()->withFragment('create-folder');
    }

    public static function downgrade(Request $request)
    {
        $folder = $request->user()->folders()->where('id', $request->id)->firstOrFail();
        Folder::downgrade($folder);

        return redirect()->back()->withFragment('create-folder');
    }

    public function update(Request $request)
    {
        $folder = $request->user()->folders()->where('id', $request->id)->firstOrFail();
        $folder->update($request->only('name'));

        return redirect()->back()->withFragment('create-folder');
    }

    public function remove(Request $request)
    {
        $folder = $request->user()->folders()->where('id', $request->id)->firstOrFail();
        $folder->delete();

        return redirect()->back()->withFragment('create-folder');
    }
}
