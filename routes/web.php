<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', static function () {
    return view('app');
});

Route::post('post/index', [PostController::class, 'index']);
