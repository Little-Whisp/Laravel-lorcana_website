<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Default route pointing to the index method of the PostController
Route::get('/', [PostController::class, 'index'])->name('index');

// Home Route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Users (Public) Routes
Route::get('/users/profile', [UserPostController::class, 'edit'])->name('users.edit');
Route::post('/users/{user}', [UserPostController::class, 'update'])->name('users.update');
Route::delete('/users/{user}/delete', [UserPostController::class, 'destroy'])->name('users.destroy');
Route::post('/users/{user}/verify', [UserPostController::class, 'verifyUser'])->name('users.verify-user');
Route::post('/register', [RegisterController::class, 'register']);

// Middleware group for routes that require authentication and checkPostAccess middleware
Route::middleware(['auth', 'checkPostAccess'])->group(function () {
    // Routes that require the user to have viewed at least two posts
});

// Resourceful routes for posts
Route::resource('posts', PostController::class);
Route::get('/all-posts', [PostController::class, 'showAllPosts'])->name('all-posts');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{id}/edit', 'PostController@edit')->name('posts.edit');
Route::put('/posts/{id}', 'PostController@update')->name('posts.update');
Route::get('/posts/{id}', 'PostController@show');
Route::post('/posts/search', [PostController::class, 'search'])->name('posts.search');

// User Posts Route
Route::resource('user-posts', UserPostController::class);

// Categories Routes
Route::resource('categories', CategoryController::class);

// Route to filter posts by category
Route::get('posts/category/{category}', [PostController::class, 'filterByCategory'])->name('posts.category');

// Authentication Routes
Auth::routes();
