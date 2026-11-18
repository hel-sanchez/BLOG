<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        abort_unless($post->is_published, 404);

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $request->user()->comments()->create([
            'post_id' => $post->id,
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Comment added!');
    }

    public function destroy(Request $request, Comment $comment)
    {
        $this->authorize('delete', $comment);
    
        $comment->delete();

        return back()->with('success', 'Comment deleted!');
    }
}
