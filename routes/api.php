<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Blog\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {

    // logout
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::prefix('/blog')->middleware('auth:sanctum')->group(function() {

    // for current user
    Route::get('/myBlog', [BlogController::class, 'myBlog']);

    // for detail blog
    Route::get('/{id}/detail', [BlogController::class, 'detail']);

    // create blog
    Route::post('/create', [BlogController::class, 'create']);

    // edit blog
    Route::get('/{id}/edit', [BlogController::class, 'edit']);

    // update blog
    Route::put('/{id}/update', [BlogController::class, 'update']);


    // delete blog
    Route::delete('/{id}/delete', [BlogController::class, 'delete']);
});


Route::get('/blog/allBlog', [BlogController::class, 'allBlog']);
