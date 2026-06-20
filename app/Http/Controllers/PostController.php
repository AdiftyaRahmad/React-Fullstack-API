<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required'
        ]);

        $post = $request->user()->posts()->create($validate);

        return $post;
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function update(Request $request, Post $post)
    {
        // 🔥 Gate
        Gate::authorize('modify', $post);

        $validate = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        $post->update($validate);

        return $post;
    }

    public function destroy(Post $post)
    {
        // 🔥 Gate
        Gate::authorize('modify', $post);

        $post->delete();

        return ["message" => "Post Was Deleted!"];
    }
}