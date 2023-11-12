<?php

namespace App\Support\Traits;

use Illuminate\Http\Request;

trait NestedSetUpdateable
{
    public function updateNestedset(Request $request)
    {
        // pluck all items id
        $itemIDs = collect($request->itemsArray)->pluck('id');

        // pluck all removed items id
        $removedIDs = $this->model::whereNotIn('id', $itemIDs)->pluck('id');

        // Delete items explicitly (for correct working of model events)
        // While deleting item, childs also deleted, so that Eloquent events wont work
        // Thats why first childs deleted, than parents
        $childs = array();
        $parents = array();

        foreach ($removedIDs as $id) {
            $item = $this->model::find($id);

            $item->parent_id ? array_push($parents, $item) : array_push($childs, $item);
        }

        foreach($childs as $child) {
            $child->delete();
        }

        foreach($parents as $parent) {
            $parent->delete();
        }

        $this->model::rebuildTree($request->itemsHierarchy, false);
    }
}
