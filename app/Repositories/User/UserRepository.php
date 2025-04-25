<?php

namespace App\Repositories\User;

use App\User;
use Illuminate\Database\Eloquent\Collection;

readonly class UserRepository
{
    public function __construct(
        protected User $user
    )
    {
    }

    public function index(): Collection
    {
        return $this->user->all();
    }

    public function create($data)
    {
        return $this->user->query()
            ->create($data);
    }

    public function updateByEmail($data, $email): int
    {
        // update user data by that email
        return $this->user->query()
            ->where('email', $email)
            ->update($data);
    }
}
