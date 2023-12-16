<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Post;


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

Route::get('/', function () {
    $posts = Post::all(); // Fetch the list of posts
    return view('posts.index', compact('posts'));
})->name('index');

Route::post('/register', [RegisterController::class, 'register']);


Route::middleware(['auth', 'checkPostAccess'])->group(function () {
    // Routes that require the user to have viewed at least three posts
});

// Posts Routes
Route::resource('posts', PostController::class);
Route::get('/all-posts', [PostController::class, 'showAllPosts'])->name('all-posts');
Route::resource('posts', PostController::class);
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{id}', 'PostController@show');


// User Posts Routes
Route::resource('user-posts', UserPostController::class);

// Categories Routes
Route::resource('categories', CategoryController::class);

// Authentication Routes
Auth::routes();

// Home Route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
