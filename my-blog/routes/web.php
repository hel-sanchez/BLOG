<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

Route::get('/', [PostController::class, 'home'])
    ->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'page'])
        ->name('posts.index');
    Route::get('/posts/search', [PostController::class, 'search'])
        ->name('posts.search');
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');
    Route::post('/posts', [PostController::class, 'storeWeb'])
        ->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'updateWeb'])
        ->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroyWeb'])
        ->name('posts.destroy');
    Route::get('/my-posts', [PostController::class, 'myPosts'])
        ->name('posts.my-posts');
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])
        ->name('posts.like');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');
});

Route::get('/categories/{category:slug}', [PostController::class, 'category'])
    ->name('categories.show');
Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');
Route::get('/users/{user}', [ProfileController::class, 'show'])
    ->name('users.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'create'])
        ->name('users.create');
    Route::post('/register', [UserController::class, 'store'])
        ->name('users.store');
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');
    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');
});
