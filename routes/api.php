<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [App\Http\Controllers\API\PassportAuthController::class, 'register']);
Route::post('login', [App\Http\Controllers\API\PassportAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    //Route::resource('posts',App\Http\Controllers\API\PostController::class);
    Route::get('/posts', [App\Http\Controllers\API\PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/trash', [App\Http\Controllers\API\PostController::class, 'trash'])->name('posts.trash');
    Route::post('/post/store', [App\Http\Controllers\API\PostController::class, 'store'])->name('post.store');
    Route::get('/post/{id}', [App\Http\Controllers\API\PostController::class, 'show'])->name('post.show');
    Route::put('/post/update/{id}', [App\Http\Controllers\API\PostController::class, 'update'])->name('post.update');
    Route::delete('/post/destroy/{id}', [App\Http\Controllers\API\PostController::class, 'destroy'])->name('post.destroy');
    Route::get('post/sdelete/{id}', [App\Http\Controllers\API\PostController::class, 'sdelete'])->name('post.sdelete');
    Route::get('post/restore/{id}', [App\Http\Controllers\API\PostController::class, 'restore'])->name('post.restore');
    Route::get('posts/user', [App\Http\Controllers\API\PostController::class, 'userPosts']);




    Route::put('/profile/update', [App\Http\Controllers\API\ProfileController::class, 'update']);
    Route::get('/profile/user/{id}', [App\Http\Controllers\API\ProfileController::class, 'userProfile']);
    Route::get('/profile', [App\Http\Controllers\API\ProfileController::class, 'myProfile']);



    Route::get('/tags', [App\Http\Controllers\API\TagController::class, 'index']);
    Route::post('/tag/store', [App\Http\Controllers\API\TagController::class, 'store']);
    Route::put('/tag/update/{id}', [App\Http\Controllers\API\TagController::class, 'update']);
    Route::any('/tag/destroy/{id}', [App\Http\Controllers\API\TagController::class, 'destroy']);


    Route::get('/users', [App\Http\Controllers\API\UserController::class ,'index']);
    Route::post('/user/store', [App\Http\Controllers\API\UserController::class ,'store']);
    Route::delete('/user/destroy/{id}',[App\Http\Controllers\API\UserController::class ,'destroy']);


    Route::post('/comment/store', [App\Http\Controllers\API\CommentController::class, 'store']);
    Route::put('/comment/update/{id}', [App\Http\Controllers\API\CommentController::class, 'update']);
    Route::any('/comment/destroy/{id}', [App\Http\Controllers\API\CommentController::class, 'destroy']);
    Route::any('/comment/replies/{id}', [App\Http\Controllers\API\CommentController::class, 'replies']);
});
