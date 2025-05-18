<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index($user)
    {
        $user = User::findOrFail($user);
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postCount = $user->posts->count();
        $followersCount = $user->profile->followers->count();
        $followingCount = $user->following->count();

        return view('profiles.index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => 'sometimes|image|max:5000',
        ]);

        // Handle image upload if present
        if (request()->hasFile('image')) {
            $imagePath = request('image')->store('profile', 'public');



            $imageArray = ['image' => $imagePath];
        }

        // Update the user's username
        auth()->user()->update([
            'username' => $data['username']
        ]);

        // Update the profile data (excluding username)
        auth()->user()->profile->update(array_merge(
            [
                'title' => $data['title'],
                'description' => $data['description'],
                'url' => $data['url'],
            ],
            $imageArray ?? []
        ));

        return redirect("/profile/{$user->id}")->with('success', 'Profile updated successfully!');
    }
}
