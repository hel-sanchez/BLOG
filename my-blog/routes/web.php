<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

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