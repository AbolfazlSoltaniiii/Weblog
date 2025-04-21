<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;

readonly class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    )
    {
    }

    public function create($data)
    {
        Validator::validate($data, [
            'username' => 'required|string|unique:users|max:200',
            'password' => 'required|string|min:8',
            'email' => 'required|string|email|unique:users'
        ]);

        return $this->userRepository->create($data);
    }
}
