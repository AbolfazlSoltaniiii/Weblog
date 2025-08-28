<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Collection;

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
