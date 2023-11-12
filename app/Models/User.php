<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, PasswordsCanResetPassword;

    const PHOTO_PATH = 'img/users';
    const PHOTO_WIDTH = 320;
    const PHOTO_HEIGHT = 235;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'country_id',
        'gender_id',
        'biography',
        'photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function booted(): void
    {
        static::deleting(function ($item) {
            // MUST delete quietly without eloquent events
            $item->likes()->delete();
            $item->favorites()->delete();
            $item->folders()->delete();
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role->name == Role::ADMINISTRATOR_ROLE ? true : false;
    }

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function rootFolders()
    {
        return $this->folders()->whereNull('parent_id')->orderBy('priority', 'asc');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class)->latest();
    }

    public function likes()
    {
        return $this->hasMany(Like::class)->latest();
    }

    public function getLikedItems($keyword)
    {
        $likes = $this->likes;
        $items = new Collection();

        if (!$keyword) {
            foreach ($likes as $item) {
                $instance = $item->likeable;
                $items->push($instance);
            }
        } else {
            foreach ($likes as $item) {
                $instance = $item->likeable;

                if ($instance->containsKeyword($keyword)) {
                    $instance->loadRelations();
                    $items->push($instance);
                }
            }
        }

        return $items;
    }

    public static function getPhotoPath($user)
    {
        return public_path(self::PHOTO_PATH . '/' . $user->photo);
    }

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
