<?php

namespace App;

use App\Laragram\Following\Follower;
use App\Laragram\Following\Following;
use App\Laragram\Following\FollowingStatusManager;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable, Follower, Following, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (!$user->username) {
                $user->username = $user->generateUsername($user);
            }
        });
    }

    /**
     * Generate username for user.
     *
     * @param $user
     * @return string|string[]|null
     */
    function generateUsername($user)
    {
        $username = bcrypt($user->name) . time();
        $username = preg_replace('/[.\/]/', str_shuffle('abcd'), $username);
        return $username;
    }

    /**
     * Get the path of user.
     *
     * @return string
     */
    public function path()
    {
        return '/users/' . $this->id;
    }

    /**
     * a user may have many posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'owner_id');
    }

}
