<?php

use App\Http\Controllers\Auth\Login\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('login', [LoginController::class, 'loginView'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::get('/', static function () {
    return view('app');
});

Route::post('post/index', [PostController::class, 'index']);
Route::resource('post', PostController::class);
