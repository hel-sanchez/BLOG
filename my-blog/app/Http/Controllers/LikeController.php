<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();

        $like = $user->likes()
            ->where('post_id', $post->id)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            $user->likes()->create([
                'post_id' => $post->id,
            ]);
        }

        return back()->with('success', 'Like updated!');
    }
}