<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->posts()->latest()->get();

        return view('posts.index', compact('posts'));
    }

    public function store()
    {
        request()->validate([
            'image' => 'required|file|image|mimes:jpeg,gif,png'
        ]);

        $filePath = request()->file('image')->storeAs('/images', request()->file('image')->hashName(), 'public');

        $post = auth()->user()->posts()->create([
            'path' => $filePath
        ]);

        if(request()->wantsJson()) {
            return $post;
        }

        return redirect('/posts');
    }

    public function destroy(Post $post)
    {
        if (auth()->id() != $post->owner_id) {
            abort(403);
        }

        $post->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'status' => 200
            ]);
        }

        return redirect(route('posts.index'));
    }
}
