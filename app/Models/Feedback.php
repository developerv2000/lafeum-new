<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getDashItemsFinalized($params)
    {
        return self::orderBy($params['orderBy'], $params['orderType'])
            ->paginate(30, ['*'], 'page', $params['currentPage'])
            ->appends(request()->except('page'));
    }

    public static function getDashSearchItems()
    {
        return self::orderBy('name', 'asc')->select('name', 'id')->get();
    }
}
