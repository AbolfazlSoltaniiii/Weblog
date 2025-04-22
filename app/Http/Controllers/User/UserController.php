<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
    public function __construct(
        protected readonly UserService $userService
    )
    {
    }

    public function index(): Collection
    {
        return $this->userService->index();
    }
}
