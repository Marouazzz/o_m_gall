<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        auth()->user()->following()->toggle($user->id);

        return response()->json([
            'following' => auth()->user()->following->contains($user->id)
        ]);
    }

}
