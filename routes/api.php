<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Blog\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::middleware('auth:sanctum')->group(function () {

    // logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('/blog')->middleware('auth:sanctum')->group(function () {

    // for current user
    Route::get('/myblog', [BlogController::class, 'myBlog'])->name('blog.myblog');

    // for detail blog
    Route::get('/{id}/detail', [BlogController::class, 'detail'])->name('blog.detail');

    // create blog
    Route::post('/create', [BlogController::class, 'create'])->name('blog.create');

    // edit blog
    Route::get('/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');

    // update blog
    Route::put('/{id}/update', [BlogController::class, 'update'])->name('blog.edit');

    // delete blog
    Route::delete('/{id}/delete', [BlogController::class, 'delete'])->name('blog.delete');
});

// guest user
Route::get('/blog/allblog', [BlogController::class, 'allBlog'])->name('blog.allblog');
