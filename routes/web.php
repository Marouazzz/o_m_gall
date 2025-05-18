<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostSaveController;
use App\Http\Controllers\ExploreController;

Auth::routes();

// Like routes
Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])
    ->name('posts.like');

// Follow routes (simplified since you're using toggle)
Route::post('/follow/{user}', [FollowsController::class, 'store'])
    ->name('follow');

// Post routes
Route::get('/', [PostsController::class, 'index'])
    ->name('posts.index');
Route::get('/p/create', [PostsController::class, 'create'])
    ->name('post.create');
Route::get('/p/{post}', [PostsController::class, 'show'])
    ->name('post.show');
Route::post('/p', [PostsController::class, 'store'])
    ->name('post.store');
Route::delete('/p/{post}', [PostsController::class, 'destroy'])
    ->name('posts.destroy');

// Save/Unsave routes
Route::post('/posts/{post}/save', [PostSaveController::class, 'save']);
Route::delete('/posts/{post}/unsave', [PostSaveController::class, 'unsave']);

// Saved posts page
Route::get('/saved-posts', [PostSaveController::class, 'savedPosts'])
    ->name('saved.posts');

// Profile routes
Route::get('/profile/{user}', [ProfilesController::class, 'index'])
    ->name('profile.show');
Route::get('/profile/{user}/edit', [ProfilesController::class, 'edit'])
    ->name('profile.edit');
Route::patch('/profile/{user}', [ProfilesController::class, 'update'])
    ->name('profile.update');

// Explore route
Route::get('/explore', [ExploreController::class, 'index'])
    ->name('explore');
