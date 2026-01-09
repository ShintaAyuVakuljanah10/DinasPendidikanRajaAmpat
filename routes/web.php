<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\SettingController;


Route::get('/', function () {
    return view('auth.login');
});
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');
});
Route::middleware('auth')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::post('/user/tambah', [UserController::class, 'tambah'])->name('user.tambah');
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::post('/users/{id}', [UserController::class, 'update']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete'])->name('user.hapus');

    
});

Route::controller(PostController::class)->group(function () {
    Route::get('/post', [PostController::class, 'index'])->name('post');
    Route::get('/post/data', [PostController::class, 'data'])->name('post.data');
    Route::post('/post/tambah', [PostController::class, 'store'])->name('post.tambah');
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::post('/post/{id}', [PostController::class, 'update'])->name('post.update');
    Route::put('/post/{id}', [PostController::class, 'update']);
    Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('post.hapus');

});


Route::controller(PagesController::class)->group(function () {
    Route::get('/pages', [PagesController::class, 'index'])->name('pages');
    Route::get('/pages/data', [PagesController::class, 'getDatatables'])->name('backend.pages.data');
    Route::post('/pages/store', [PagesController::class, 'store'])->name('backend.pages.store');
    Route::get('/pages/{id}/edit', [PagesController::class, 'edit'])->name('backend.pages.edit');
    Route::put('/pages/{id}', [PagesController::class, 'update'])->name('backend.pages.update');
    Route::delete('/pages/{id}', [PagesController::class, 'destroy'])->name('backend.pages.destroy');
    Route::get('/pages/getparent', [PagesController::class, 'getParent'])->name('backend.pages.getparent');
});

Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::prefix('settings')->middleware('auth')->group(function () {
    Route::get('/aplikasi', [SettingController::class, 'aplikasi'])
        ->name('settings.aplikasi');

    Route::get('/banner', [SettingController::class, 'banner'])
        ->name('settings.banner');
});

