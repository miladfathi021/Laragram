<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FollowingsController extends Controller
{
    public function store(User $user)
    {
        auth()->user()->follow($user);
    }
}
