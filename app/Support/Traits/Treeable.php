<?php

namespace App\Support\Traits;

trait Treeable
{
    public static function getItemsTree()
    {
        $items = self::defaultOrder()->get()->toTree();

        return $items;
    }
}
