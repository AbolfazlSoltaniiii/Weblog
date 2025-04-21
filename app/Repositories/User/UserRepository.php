<?php

namespace App\Repositories\User;

use App\User;

readonly class UserRepository
{
    public function __construct(
        protected User $user
    )
    {
    }

    public function create($data)
    {
        return $this->user->query()
            ->create($data);
    }

    public function updateByEmail($data, $email): int
    {
        return $this->user->query()
            ->where('email', $email)
            ->update($data);
    }
}
