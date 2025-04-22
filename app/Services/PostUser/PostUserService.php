<?php

namespace App\Services\PostUser;

use App\Repositories\PostUser\PostUserRepository;

readonly class PostUserService
{
    public function __construct(
        protected PostUserRepository $postUserRepository
    )
    {
    }

    public function create(array $data)
    {
        return $this->postUserRepository->create($data);
    }
}
