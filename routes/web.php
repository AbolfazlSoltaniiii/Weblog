<?php

use App\Http\Controllers\Auth\Login\LoginController;
use App\Http\Controllers\Auth\Register\RegisterController;
use App\Http\Controllers\Auth\Logout\LogoutController;
use App\Http\Controllers\Auth\ResetPassword\ResetPasswordController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\DashboardController;

// for authentication
Route::get('register', [RegisterController::class, 'registerView'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'loginView'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::get('reset-password', [ResetPasswordController::class, 'resetPasswordView'])->name('resetPassword');
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);
Route::post('reset-password-link', [ResetPasswordController::class, 'getResetPasswordLink']);

Route::post('logout', [LogoutController::class, 'logout']);

Route::get('user', [UserController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/', static function () {
        return view('app');
    })->name('/');

    Route::post('post/index', [PostController::class, 'index']);
    Route::resource('post', PostController::class);

    Route::get('dashboard', [DashboardController::class, 'view']);
});
