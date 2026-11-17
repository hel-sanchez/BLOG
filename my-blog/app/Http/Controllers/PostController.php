<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return $posts;
    }

    // JSONS
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'is_published' => 'sometimes|boolean',
            'image_path' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('posts', 'public');
        }

        $post = Post::create($validated);

        return response()->json($post, 201);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
            'is_published' => 'sometimes|boolean',
            'image_path' => 'sometimes|nullable|image|max:2048',
        ]);

        if ($request->has('is_published')) {
            $validated['is_published'] = $request->boolean('is_published');
        }

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('posts', 'public');

            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }

            $validated['image_path'] = $path;
        }

        $post->update($validated);

        return $post;
    }

    public function destroy(Post $post)
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully!']);
    }

    // WEB
    public function page()
    {
        $posts = Post::with('user')->paginate(5);

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
            'is_published' => 'sometimes|boolean',
            'image_path' => 'nullable|image|max:2048',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('posts', 'public');
            $validated['image_path'] = $path;
        }
        $request->user()->posts()->create($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function updateWeb(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image_path' => 'nullable|image|max:2048',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('posts', 'public');

            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }

            $validated['image_path'] = $path;
        }

        $post->update($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully!');
    }

    public function destroyWeb(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    public function myPosts()
    {
        $user = auth()->user();

        $status = request('status', 'all');

        $query = $user->posts();

        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'unpublished') {
            $query->where('is_published', false);
        }

        $posts = $query->paginate(5)->withQueryString();

        $totalPosts = $user->posts()->count();

        return view('users.posts', compact('posts', 'totalPosts', 'status'));
    }
}
