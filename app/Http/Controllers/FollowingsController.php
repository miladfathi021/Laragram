<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FollowingsController extends Controller
{
    public function store(User $user)
    {
        if (auth()->user()->is($user)) {
            return redirect($user->path());
        }

        auth()->user()->follow($user);

        return back();
    }

    public function destroy(User $user)
    {
        auth()->user()->followings()->detach($user->id);

        return back();
    }
}
