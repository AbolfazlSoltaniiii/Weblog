<?php

namespace App\Repositories\PostUser;

use App\PostUser;

readonly class PostUserRepository
{
    public function __construct(
        protected PostUser $postUser
    )
    {
    }

    public function create(array $data)
    {
        return $this->postUser->query()
            ->create($data);
    }
}
