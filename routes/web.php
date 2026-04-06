<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


// display
Route::get('/', [BlogController::class, 'show'])->name('blog.all');
Route::post('/', [BlogController::class, 'show'])->name('blog.all');


// route with email verified
// Route::middleware('auth','verified')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// user route
Route::prefix('/user')->middleware(['auth', 'role:user'])->group(function () {
    // blog
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    // list
    Route::get('/list', [UserController::class, 'list'])->name('user.list');
});

// blog route
Route::prefix('/blog')->group(function () {
    // add
    Route::get('/add', [BlogController::class, 'add'])->name('blog.add')->middleware(['auth', 'role:user']);
    Route::post('/store', [BlogController::class, 'store'])->name('blog.store')->middleware(['auth', 'role:user']);

    // detail blog
    Route::get('/{id}/detail', [BlogController::class, 'detail'])->name('blog.detail');

    // edit
    Route::get('/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit')->middleware(['auth', 'role:user']);
    Route::post('/{id}/updateBlog', [BlogController::class, 'updateBlog'])->name('blog.updateBlog')->middleware(['auth', 'role:user']);
    Route::post('/{id}/updateyajra', [BlogController::class, 'updateyajra'])->name('blog.updateyajra')->middleware(['auth', 'role:admin']);

    // delete
    Route::delete('/{id}/delete', [BlogController::class, 'delete'])->name('blog.delete')->middleware(['auth', 'role:user']);



    // testing
    Route::post('/store', [BlogController::class, 'store'])->name('blog.store');
    Route::put('/{id}/updateBlog', [BlogController::class, 'updateBlog'])->name('blog.updateBlog');
    Route::delete('/{id}/delete', [BlogController::class, 'delete'])->name('blog.delete');

});


// admin route
Route::middleware(['auth', 'role:admin'])->prefix('/admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/yajra', [BlogController::class, 'yajra'])->name('blog.yajra');
    Route::get('/yajra-data', [BlogController::class, 'yajra'])->name('blog.yajra-data');
});

// superadmin route
Route::middleware(['auth', 'role:superadmin'])->prefix('/superadmin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/alluser', [SuperAdminController::class, 'alluser'])->name('superadmin.alluser');
    Route::get('/{id}/history', [SuperAdminController::class, 'history'])->name('superadmin.history');
    Route::get('/sendData', [SuperAdminController::class, 'sendData'])->name('superadmin.sendData');
});


// profile picture route
Route::middleware('auth')->group(function () {
    Route::put('upload', [ImageUploadController::class, 'upload'])->name('upload');
});


// error route
Route::get('/error-401', function () {
    abort(401);
});

Route::get('/error-402', function () {
    abort(402);
});

Route::get('/error-403', function () {
    abort(403);
});

Route::get('/error-404', function () {
    abort(404);
});

Route::get('/error-419', function () {
    abort(419);
});
Route::get('/error-429', function () {
    abort(429);
});
Route::get('/error-503', function () {
    abort(503);
});

require __DIR__ . '/auth.php';
