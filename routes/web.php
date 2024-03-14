<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('posts.index');
});
Route::get('/home', function () {
    return redirect()->route('posts.index');
});

Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::any('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::any('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::any('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::any('/profile/show', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');





Route::get('/posts', [App\Http\Controllers\PostController::class ,'index'])->name('posts.index');
Route::get('/posts/trash',[App\Http\Controllers\PostController::class , 'trash'])->name('posts.trash');
Route::get('/post/create', [App\Http\Controllers\PostController::class , 'create'])->name('post.create');
Route::post('/post/store', [App\Http\Controllers\PostController::class ,'store'])->name('post.store');
Route::get('/post/{slug}', [App\Http\Controllers\PostController::class ,'show'])->name('post.show');
Route::get('/post/edit/{id}', [App\Http\Controllers\PostController::class ,'edit'])->name('post.edit');
Route::put('/post/update/{id}', [App\Http\Controllers\PostController::class ,'update'])->name('post.update');
Route::any('/post/destroy/{id}',[App\Http\Controllers\PostController::class ,'destroy'])->name('post.destroy');
Route::get('post/sdelete/{id}', [App\Http\Controllers\PostController::class,'sdelete'])->name('post.sdelete');
Route::get('products/restore/{id}', [App\Http\Controllers\PostController::class,'restore'])->name('post.restore');





Route::get('/tags', [App\Http\Controllers\TagController::class ,'index'])->name('tags.index');
Route::get('/tag/create', [App\Http\Controllers\TagController::class , 'create'])->name('tag.create');
Route::post('/tag/store', [App\Http\Controllers\TagController::class ,'store'])->name('tag.store');
Route::get('/tag/edit/{id}', [App\Http\Controllers\TagController::class ,'edit'])->name('tag.edit');
Route::put('/tag/update/{id}', [App\Http\Controllers\TagController::class ,'update'])->name('tag.update');
Route::any('/tag/destroy/{id}',[App\Http\Controllers\TagController::class ,'destroy'])->name('tag.destroy');



Route::get('/users', [App\Http\Controllers\UserController::class ,'index'])->name('users.index');
Route::get('/user/create', [App\Http\Controllers\UserController::class , 'create'])->name('user.create');
Route::post('/user/store', [App\Http\Controllers\UserController::class ,'store'])->name('user.store');
Route::any('/user/destroy/{id}',[App\Http\Controllers\UserController::class ,'destroy'])->name('user.destroy');



Route::resource('comments',CommentController::class);

