<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

readonly class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    )
    {
    }

    public function index(): Collection
    {
        return $this->userRepository->index();
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

    public function updateByEmail($data, $email): false|int
    {
        if (!isset($email)) {
            return false;
        }

        return $this->userRepository->updateByEmail($data, $email);
    }
}
