<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ProfileController;


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
    if(auth()->user()){
        return redirect('home');
    }
    return redirect('User');
});


Route::get('home', [HomeController::class, 'index'])->name('home');

// POSTfoto
Route::get('/posts', [PostsController::class, 'index'])->name('posts');
Route::get('/Home/posts', [PostsController::class, 'create'])->name('Home.posts');
Route::post('/posts/store', [PostsController::class, 'store'])->name('posts.store');
Route::post('/like', [HomeController::class, 'storeLike'])->name('like');
Route::get('/like-status',[HomeController::class, 'checkLikeStatus'])->name('checklike');
Route::delete('/unlike', [HomeController::class, 'unlike'])->name('unlike');
Route::post('/comment', [HomeController::class, 'storeKomentar'])->name('komentar');

Route::get('/gallery', [HomeController::class, 'gallery'])->name('Home.gallery');
Route::get('/export', [HomeController::class, 'export'])->name('export');
Route::delete('/post/delete', [HomeController::class, 'delete'])->name('post.delete');

// Route::get('/profile', [HomeController::class, 'profile'])->name('Home.profile');
// Route::get('/detail/profile', [HomeController::class, 'profile'])->name('Home.detailprofile');

// PROFILE
Route::get('/profile', [ProfileController::class, 'index'])->name('index');
Route::get('/profile/uploadprofile', [ProfileController::class, 'create'])->name('Profile.uploadprofile');
Route::post('/profile/store', [ProfileController::class, 'store'])->name('Profile.store');
Route::get('albumFoto', [ProfileController::class, 'album'])->name('albumFoto');

// ALBUMFOTO
Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
Route::get('/Home/albums', [AlbumController::class, 'index'])->name('Home.albums');
Route::post('/albums', 'App\Http\Controllers\AlbumController@store')->name('albums.store');
Route::get('/albums/{album}', 'App\Http\Controllers\AlbumController@show')->name('albums.show');
Route::get('/albums/{album}/edit', 'App\Http\Controllers\AlbumController@edit')->name('albums.edit');
Route::put('/albums/{album}', 'App\Http\Controllers\AlbumController@update')->name('albums.update');
Route::delete('/albums/{album}', 'App\Http\Controllers\AlbumController@destroy')->name('albums.destroy');

// LOGINREGISTER
Route::get('User', [UserController::class, 'index'])->name('login');
Route::post('User/login', [UserController::class, 'login'])->name('User.login');
Route::get('User/logout', [UserController::class, 'logout'])->name('logout');
Route::get('User/register', [UserController::class, 'register'])->name('User.register');
Route::post('User/register', [UserController::class, 'create'])->name('create');
Route::get('logout', [UserController::class, 'logout'])->name('logout');
