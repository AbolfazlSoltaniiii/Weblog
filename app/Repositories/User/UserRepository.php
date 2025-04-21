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
}
