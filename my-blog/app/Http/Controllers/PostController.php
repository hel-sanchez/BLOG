<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return $posts;
    }

    # JSONS
    public function store(Request $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'is_published' => $request->is_published,
        ]);
        return $post;
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
            'is_published' => 'sometimes|boolean',
        ]);

        $post->update($validated);

        return $post;
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully!']);
    }

    # WEB
    public function page()
    {
        $posts = Post::all();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function storeWeb(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        Post::create($validated);

        return redirect()->route('posts.index');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    public function updateWeb(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        $post->update($validated);

        return redirect()->route('posts.index');
    }

    public function destroyWeb($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return redirect()->route('posts.index');
    }
}