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
use App\Http\Controllers\Backend\SubMenuController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\BeritaController;
use App\Http\Controllers\Frontend\FrontEndController;
// use App\Http\Controllers\Frontend\KategoriController;
// use App\Http\Controllers\Frontend\DokumenPublikController;
use App\Http\Controllers\Backend\RoleController;


// Route::get('/', function () {
//     return view('frontend.dashboard');
// });

Route::get('/', [DashboardController::class, 'index']);
Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/berita', [BeritaController::class, 'index'])
    ->name('berita.index');

Route::get('/berita/{slug}', [BeritaController::class, 'show'])
    ->name('berita.detail');

Route::get('/backend', function () {
    return view('auth.login');
});
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'log.agent'])
    ->name('home');
Route::middleware(['auth', 'log.agent'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/berita/kategori/{slug}', [BeritaController::class, 'kategori'])
    ->name('berita.kategori');
    
Route::middleware(['auth', 'log.agent'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::post('/user/tambah', [UserController::class, 'tambah'])->name('user.tambah');
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::post('/users/{id}', [UserController::class, 'update']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete'])->name('user.hapus');

    
});
Route::prefix('roles')
    ->middleware(['auth', 'log.agent'])
    ->group(function () {

        Route::get('/', [RoleController::class, 'index'])->name('roles');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('destroy');
        Route::get('/roles/data', [RoleController::class, 'data'])->name('roles.data');
    });



Route::middleware(['auth', 'log.agent'])->controller(PostController::class)->group(function () {
    Route::get('/post', 'index')->name('post');
    Route::get('/post/data', 'data')->name('post.data');
    Route::post('/post/tambah', 'store')->name('post.tambah');
    Route::get('/post/{id}/edit', 'edit')->name('post.edit');
    Route::match(['post','put'], '/post/{id}', 'update')->name('post.update');
    Route::delete('/post/{id}', 'destroy')->name('post.hapus');
});



Route::prefix('settings')
    ->middleware(['auth', 'log.agent'])
    ->group(function () {

        Route::controller(AppController::class)->group(function () {
            Route::get('/aplikasi', 'index')->name('settings.aplikasi');
            Route::post('/aplikasi', 'update')->name('settings.aplikasi.update');
        });

        Route::controller(BannerController::class)->group(function () {

            Route::get('/banner', 'index')->name('settings.banner');

            Route::get('/banner/data', 'data')->name('banner.data');
            Route::post('/banner', 'store')->name('banner.store');

            Route::get('/banner/{id}/edit', 'edit');
            Route::put('/banner/{id}', 'update');
            Route::delete('/banner/{id}', 'destroy');

            Route::post('/banner/{id}/up', 'up');
            Route::post('/banner/{id}/down', 'down');
        });



});



Route::prefix('categories')->middleware(['auth', 'log.agent'])->group(function () {
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

Route::prefix('fileManager')->middleware(['auth', 'log.agent'])->group(function () {
    Route::get('/', [FileManagerController::class, 'index'])->name('fileManager');
    Route::get('/data', [FileManagerController::class, 'data'])->name('fileManager.data');
    Route::post('/', [FileManagerController::class, 'store'])->name('fileManager.store');
    Route::delete('/{id}', [FileManagerController::class, 'destroy']);
});


Route::prefix('backend')->middleware(['auth', 'log.agent'])->name('backend.')->group(function () {

    Route::get('/pages', [PagesController::class, 'index'])->name('pages');
    Route::get('/pages/data', [PagesController::class, 'data'])->name('pages.data');
    Route::post('/pages/{id}/up', [PagesController::class, 'orderUp']);
    Route::post('/pages/{id}/down', [PagesController::class, 'orderDown']);
    Route::get('/pages/parents', [PagesController::class, 'parents'])->name('pages.parents');
    Route::post('/pages/store', [PagesController::class, 'store'])->name('pages.store');
    Route::get('/pages/{id}', [PagesController::class, 'show']);
    Route::put('/pages/{id}', [PagesController::class, 'update'])->name('pages.update');
    // Route::resource('pages', PagesController::class);
    Route::delete('/pages/{id}', [PagesController::class, 'destroy'])->name('pages.destroy');
}); 

Route::prefix('backend')->middleware(['auth', 'log.agent'])->name('backend.')->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    Route::get('/menu/data', [MenuController::class, 'data'])->name('menu.data');
    Route::post('/menu/{id}/up', [MenuController::class, 'orderUp']);
    Route::post('/menu/{id}/down', [MenuController::class, 'orderDown']);
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/parent', [MenuController::class, 'parentMenu'])->name('menu.parent');
    Route::get('/menu/route-select', [MenuController::class, 'routeSelect'])->name('menu.routeSelect');
    Route::get('/menu/{id}', [MenuController::class, 'show']);
    Route::put('/menu/{id}', [MenuController::class, 'update']);
    Route::delete('/menu/{id}', [MenuController::class, 'destroy']);
});

// Route::get('/backend/menu/routeSelect', [MenuController::class, 'routeSelect'])->name('backend.menu.routeSelect');


Route::prefix('backend')->middleware(['auth', 'log.agent'])->name('backend.')->group(function () {
    Route::get('/submenu', [SubMenuController::class, 'index'])->name('submenu');
    Route::get('submenu/data', [SubMenuController::class, 'data'])->name('submenu.data');
    Route::post('submenu', [SubMenuController::class, 'store'])->name('submenu.store');
    Route::get('submenu/{id}', [SubMenuController::class, 'show']);
    Route::put('submenu/{id}', [SubMenuController::class, 'update']);
    Route::delete('submenu/{id}', [SubMenuController::class, 'destroy']);
});

// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/dokumen-publik', [DokumenPublikController::class, 'index']);

Route::get('/{slug}', [FrontendController::class, 'show']);
Route::get('/kategori', [FrontendController::class, 'kategori']);