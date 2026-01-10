<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\Settings\AppController;
use App\Http\Controllers\Backend\Settings\BannerController;


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

Route::middleware(['auth'])->controller(PostController::class)->group(function () {
    Route::get('/post', 'index')->name('post');
    Route::get('/post/data', 'data')->name('post.data');
    Route::post('/post/tambah', 'store')->name('post.tambah');
    Route::get('/post/{id}/edit', 'edit')->name('post.edit');
    Route::match(['post','put'], '/post/{id}', 'update')->name('post.update');
    Route::delete('/post/{id}', 'destroy')->name('post.hapus');
});


Route::prefix('settings')
    ->middleware('auth')
    ->group(function () {

        Route::controller(AppController::class)->group(function () {
            Route::get('/aplikasi', 'index')->name('settings.aplikasi');
            Route::post('/aplikasi', 'update')->name('settings.aplikasi.update');
        });

        Route::controller(BannerController::class)->group(function () {
            Route::get('/banner', 'index')->name('settings.banner');
            Route::post('/banner', 'store')->name('settings.banner.store');
        });

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



