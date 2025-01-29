<?php

use App\Http\Controllers\Auth\Login\LoginController;
use App\Http\Controllers\Auth\Register\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// for authentication
Route::get('register', [RegisterController::class, 'registerView'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'loginView'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::get('/', static function () {
    return view('app');
});

Route::post('post/index', [PostController::class, 'index']);
Route::resource('post', PostController::class);
