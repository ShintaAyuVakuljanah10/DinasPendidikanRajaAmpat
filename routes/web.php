<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\Settings\AppController;
use App\Http\Controllers\Backend\Settings\BannerController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\FileManagerController;
use App\Http\Controllers\Backend\MenuController;



Route::get('/', function () {
    return view('frontend.dashboard');
});
Route::get('/backend', function () {
    return view('auth.login');
});
Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

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

            // halaman
            Route::get('/banner', 'index')->name('settings.banner');

            // AJAX
            Route::get('/banner/data', 'data')->name('banner.data');
            Route::post('/banner', 'store')->name('banner.store');
            Route::get('/banner/{id}/edit', 'edit');
            Route::put('/banner/{id}', 'update');
            Route::delete('/banner/{id}', 'destroy');

            // urutan
            Route::post('/banner/{id}/up', 'up');
            Route::post('/banner/{id}/down', 'down');
        });


});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category');
    Route::get('/data', [CategoryController::class, 'data'])->name('category.data');
    Route::post('/', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/{id}/edit', [CategoryController::class, 'edit']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});
Route::get('/categories/list', function () {
    return \App\Models\Category::select('id','nama')->orderBy('nama')->get();
})->name('category.list');

Route::prefix('fileManager')->group(function () {
    Route::get('/', [FileManagerController::class, 'index'])->name('fileManager');
    Route::get('/data', [FileManagerController::class, 'data'])->name('fileManager.data');
    Route::post('/', [FileManagerController::class, 'store'])->name('fileManager.store');
    Route::delete('/{id}', [FileManagerController::class, 'destroy']);
});


Route::prefix('backend')->name('backend.')->group(function () {

    Route::get('/pages', [PagesController::class, 'index'])->name('pages');
    Route::get('/pages/data', [PagesController::class, 'data'])->name('pages.data');
    Route::post('/pages/store', [PagesController::class, 'store'])->name('pages.store');
    Route::get('/pages/{id}', [PagesController::class, 'show']);
    // Route::resource('pages', PagesController::class);
    Route::delete('/pages/{id}', [PagesController::class, 'destroy'])->name('pages.destroy');

}); 

Route::prefix('backend')->name('backend.')->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    Route::get('/menu/data', [MenuController::class, 'data'])->name('menu.data');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{id}', [MenuController::class, 'show']);
    Route::put('/menu/{id}', [MenuController::class, 'update']);
    Route::delete('/menu/{id}', [MenuController::class, 'destroy']);
});

