<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;
use App\Models\Post;
use App\Models\Follow;

class InboxController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all Follow relationships where current user is the follower
        $follows = $user->following;

        // Extract the followed user IDs
        $followedUserIds = $follows->pluck('followed_id')->toArray();

        // Get messages between current user and followed users
        $messages = Message::where(function($query) use ($user, $followedUserIds) {
            $query->where('sender_id', $user->id)
                ->whereIn('receiver_id', $followedUserIds);
        })
            ->orWhere(function($query) use ($user, $followedUserIds) {
                $query->where('receiver_id', $user->id)
                    ->whereIn('sender_id', $followedUserIds);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get posts from followed users
        $posts = Post::whereIn('user_id', $followedUserIds)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('inbox', [
            'messages' => $messages,
            'posts' => $posts,
            'followedUsers' => User::whereIn('id', $followedUserIds)->get()
        ]);
    }
}
