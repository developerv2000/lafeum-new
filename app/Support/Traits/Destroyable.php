<?php

namespace App\Support\Traits;

use App\Support\Helpers\Helper;
use Illuminate\Http\Request;

trait Destroyable
{
    public function destroy(Request $request)
    {
        $ids = (array) $request->input('id');

        // Permanent Delete
        if ($request->has('permanently')) {
            foreach ($ids as $id) {
                $this->model::withTrashed()->find($id)->forceDelete();
            }

            return redirect()->route(Helper::getModelPrefixName() . '.dashboard.trash');
        }

        // Trash
        foreach ($ids as $id) {
            $this->model::find($id)->delete();
        }

        return redirect()->route(Helper::getModelPrefixName() . '.dashboard.index');
    }

    public function restore(Request $request)
    {
        $this->model::onlyTrashed()->find($request->input('id'))->restore();

        return redirect()->back();
    }
}
