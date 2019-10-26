<?php


namespace App\Laragram\Following;


use App\User;

trait Follower
{

    /**
     * check if a user has a follower request from given user.
     *
     * @param User $user
     * @return mixed
     */
    public function hasRequestedFollower(User $user)
    {
        return $this->followers()
            ->where('follower', $user->id)
            ->where('status', FollowingStatusManager::STATUS_SUSPENDED)
            ->exists();
    }

    /**
     * a user may have many followers.
     *
     * @return mixed
     */
    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'followings',
            'following',
            'follower'
        );
    }

    /**
     * a user can decline a request follow
     *
     * @param User $user
     */
    public function decline(User $user)
    {
        $this->followers()
            ->sync([
                $user->id => [
                    'status' => FollowingStatusManager::STATUS_DECLINED
                ]
            ]);
    }

    /**
     * check if given user has declined.
     *
     * @param User $user
     * @return mixed
     */
    public function hasDeclined(User $user)
    {
        return $this->followers()
            ->where('follower', $user->id)
            ->where('status', FollowingStatusManager::STATUS_DECLINED)
            ->exists();
    }
}
