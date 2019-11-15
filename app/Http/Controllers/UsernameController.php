<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsernameController extends Controller
{
    public function update(User $user)
    {
        $attribute = request()->validate([
            'username' => 'required|string|alpha_dash|min:3|max:255|unique:users,username,' . $user->id
        ]);

        $user->update($attribute);

        return back();
    }
}
