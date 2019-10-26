<?php


namespace App\Laragram\Following;


use App\User;

trait Following
{

    /**
     * check if a user has followed another user.
     *
     * @param User $user
     * @return bool
     */
    public function hasRequestedFollowing(User $user)
    {
        return $this->followings()
            ->where('following', $user->id)
            ->where('status', FollowingStatusManager::STATUS_SUSPENDED)
            ->exists();
    }

    /**
     * a user may have many followings
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(
            User::class,
            'followings',
            'follower',
            'following'
        );
    }

    /**
     * a user can follow other user
     *
     * @param User $user
     */
    public function follow(User $user)
    {
        $this->followings()->attach($user, [
            'status' => FollowingStatusManager::STATUS_SUSPENDED
        ]);
    }

    /**
     * accept another user following request.
     *
     * @param User $user
     */
    public function accept(User $user)
    {
        $this->followers()->sync([
            $user->id => [
                'status' => FollowingStatusManager::STATUS_ACCEPTED
            ]
        ]);
    }

    /**
     * check if a user has followed.
     *
     * @param User $user
     * @return bool
     */
    public function isFollowing(User $user)
    {
        return $this->followings()
            ->where('following', $user->id)
            ->where('status', FollowingStatusManager::STATUS_ACCEPTED)
            ->exists();
    }
}
