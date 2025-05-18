<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        auth()->user()->toggleLike($post);

        return response()->json([
            'likes_count' => $post->likers()->count(),
            'is_liked' => auth()->user()->hasLiked($post)
        ]);
    }
}
