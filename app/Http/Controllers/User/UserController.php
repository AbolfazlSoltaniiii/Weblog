<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;

class UserController extends Controller
{
    public function __construct(
        protected readonly UserService $user
    )
    {
    }
}
