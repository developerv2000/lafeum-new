<?php

namespace App\Models;

use App\Support\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Folder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['childs'];

    protected static function booted(): void
    {
        static::deleting(function ($item) {
            $item->childs->each(function ($child) {
                $child->delete();
            });

            request()->user()->favorites()->where('folder_id', $item->id)->delete();
        });

        static::deleted(function ($item) {
            self::validatePriorities();
        });
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('priority', 'asc');
    }

    public function getItems($keyword)
    {
        $favorites = request()->user()->favorites()
            ->where('folder_id', $this->id)
            ->latest()
            ->get();

        $items = new Collection();

        if (!$keyword) {
            foreach ($favorites as $item) {
                $instance = $item->favoritable;
                $items->push($instance);
            }
        } else {
            foreach ($favorites as $item) {
                $instance = $item->favoritable;

                if ($instance->containsKeyword($keyword)) {
                    $instance->loadRelations();
                    $items->push($instance);
                }
            }
        }

        return $items;
    }

    public static function createDefaultsForNewUser($user)
    {
        $user->folders()->save(
            new Folder([
                'name' => 'Моя папка',
                'slug' => Helper::generateSlug('Моя папка'),
                'priority' => 1
            ])
        );
    }

    public static function getLevelsHighestPriority($parentID)
    {
        $folder = request()->user()->folders()
            ->where('parent_id', $parentID)
            ->orderBy('priority', 'desc')
            ->first();

        return $folder ? $folder->priority : 0;
    }

    public static function upgrade($folder)
    {
        $targetPriority = $folder->priority;

        $higherFolder = request()->user()->folders()
            ->where('id', '!=', $folder->id)
            ->where('parent_id', $folder->parent_id)
            ->where('priority', '<', $folder->priority)
            ->orderBy('priority', 'desc')
            ->first();

        if(!$higherFolder) return;

        $folder->priority = $higherFolder->priority;
        $folder->save();

        $higherFolder->priority = $targetPriority;
        $higherFolder->save();
    }

    public static function downgrade($folder)
    {
        $targetPriority = $folder->priority;

        $lowerFolder = request()->user()->folders()
            ->where('id', '!=', $folder->id)
            ->where('parent_id', $folder->parent_id)
            ->where('priority', '>', $folder->priority)
            ->orderBy('priority', 'asc')
            ->first();

        if(!$lowerFolder) return;

        $folder->priority = $lowerFolder->priority;
        $folder->save();

        $lowerFolder->priority = $targetPriority;
        $lowerFolder->save();
    }

    private static function validatePriorities()
    {
        $rootFolders = request()->user()->rootFolders;

        $rootPriority = 1;

        foreach ($rootFolders as $rootFolder) {
            $rootFolder->priority = $rootPriority;
            $rootFolder->save();
            $rootPriority++;

            $childPriority = 1;

            foreach ($rootFolder->childs as $childFolder) {
                $childFolder->priority = $childPriority;
                $childFolder->save();
                $childPriority++;
            }
        }
    }
}
