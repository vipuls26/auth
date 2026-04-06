<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Blog\BlogController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login'])->name('login.api');
Route::post('/register', [AuthController::class, 'register'])->name('register.api');


// search
Route::get('/blog', [BlogController::class, 'search'])->name('blog.search');

// with middleware
Route::middleware('auth:sanctum')->group(function () {
    // logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// blog
Route::prefix('/blog')->middleware('auth:sanctum')->group(function () {
    // for login user
    Route::get('/myblogs', [BlogController::class, 'myBlog'])->name('blog.myblogs');
    // total post
    Route::get('/posts', [BlogController::class, 'postDetail'])->name('blog.posts');
    // for detail blog
    Route::get('/{id}/detail', [BlogController::class, 'detail'])->name('blog.detail');
    // create blog
    Route::post('/create', [BlogController::class, 'create'])->name('blog.create');
    // edit blog
    Route::get('/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    // update blog
    Route::put('/{id}/update', [BlogController::class, 'update'])->name('blog.edit');
    // delete blog
    Route::delete('/{id}/delete', [BlogController::class, 'delete'])->name('blog.delete.api');
});

// guest user

// all blog
Route::get('/blog/allblogs', [BlogController::class, 'allBlog'])->name('blog.allblogs');
// blog detail
Route::get('/blog/{id}/blogdetail', [BlogController::class, 'blogDetail'])->name('blog.blog_detail');
