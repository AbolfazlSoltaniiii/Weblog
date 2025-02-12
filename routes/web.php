<?php

use App\Http\Controllers\Auth\Login\LoginController;
use App\Http\Controllers\Auth\Register\RegisterController;
use App\Http\Controllers\Auth\Logout\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\DashboardController;

// for authentication
Route::get('register', [RegisterController::class, 'registerView'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'loginView'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::post('logout', [LogoutController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::get('/', static function () {
        return view('app');
    })->name('/');

    Route::post('post/index', [PostController::class, 'index']);
    Route::resource('post', PostController::class);

    Route::get('dashboard', [DashboardController::class, 'view']);
});
