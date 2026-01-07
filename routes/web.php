<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\UserController;



Route::get('/', function () {
    return view('auth.login');
});
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');
});
Route::middleware('auth')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');

    // AJAX
    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::post('/user/tambah', [UserController::class, 'tambah'])->name('user.tambah');
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::post('/users/{id}', [UserController::class, 'update']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete'])->name('user.hapus');
});
Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

