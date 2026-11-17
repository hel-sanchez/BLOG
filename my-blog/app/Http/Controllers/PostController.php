<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'message' => 'Successfully logged in.',
            'data' => $posts,
        ], 200);
    }

    // HONE FEATURES
    public function home()
    {
        $featuredPost = Post::with('user', 'category')
            ->where('is_published', true)
            ->latest()
            ->first();

        $recentPosts = Post::with('user', 'category')
            ->where('is_published', true);

        if ($featuredPost) {
            $recentPosts->where('id', '!=', $featuredPost->id);
        }

        $recentPosts = $recentPosts->latest()->paginate(6);

        return view('welcome', compact(
            'featuredPost',
            'recentPosts'
        ));
    }

    public function show(Post $post)
    {
        abort_unless($post->is_published, 404);

        $post->load(['user', 'category']);
        $post->loadCount('likes');

        $liked = auth()->check()
            && $post->likes()->where('user_id', auth()->id())->exists();

        return view('posts.show', compact('post', 'liked'));
    }

    public function category(Category $category)
    {
        $posts = $category->posts()
            ->with('user')
            ->where('is_published', true)
            ->latest()
            ->paginate(6);

        return view('categories.show', compact('category', 'posts'));
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

        return response()->json([
            'message' => 'Created successfully.',
            'data' => $post,
        ], 201);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

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

        return response()->json([
            'message' => 'Updated successfully.',
            'data' => $post,
        ], 200);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully!',
            'data' => $post,
        ], 200);
    }

    // WEB
    public function page(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = Post::with('user');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%'.$keyword.'%')
                    ->orWhere('body', 'like', '%'.$keyword.'%');
            });
        }

        $posts = $query->paginate(5);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('posts.create', compact('categories'));
    }

    public function storeWeb(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'is_published' => 'sometimes|boolean',
            'image_path' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
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

        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    public function updateWeb(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image_path' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
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

    public function search(Request $request)
    {
        $keyword = trim($request->input('keyword', ''));

        if ($keyword === '') {
            return response()->json([]);
        }

        $pattern = '(^|[^[:alnum:]_])'
                 .preg_quote($keyword, '/')
                 .'([^[:alnum:]_]|$)';

        $posts = Post::where('title', 'REGEXP', $pattern)
            ->orWhere('body', 'REGEXP', $pattern)
            ->get();

        return $posts;
    }
}
