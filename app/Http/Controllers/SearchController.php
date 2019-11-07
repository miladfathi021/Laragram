<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show()
    {
        $search = request('q');

        $users = User::search($search)->paginate(25);

        if (\request()->wantsJson()) {
            return $users;
        }

        return view('users.index', compact('users'));
    }
}
