<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'page'])
        ->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');
    Route::post('/posts', [PostController::class, 'storeWeb'])
        ->name('posts.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'updateWeb'])
        ->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroyWeb'])
        ->name('posts.destroy');
    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');
    Route::get('/my-posts', [PostController::class, 'myPosts'])
        ->name('posts.my-posts');
});

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
