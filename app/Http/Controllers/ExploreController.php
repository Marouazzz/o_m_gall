<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ExploreController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $currentUser = Auth::user();

        // Get IDs of users the current user is following
        $followingIds = $currentUser->following()->pluck('users.id');

        // Get users not in the following list and not the current user
        $users = User::whereNotIn('id', $followingIds)
            ->where('id', '!=', $currentUser->id)
            ->with('profile')
            ->paginate(12);

        return view('explore', compact('users'));
    }

}
