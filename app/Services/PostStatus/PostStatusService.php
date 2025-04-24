<?php

namespace App\Services\PostStatus;

use App\Repositories\PostStatus\PostStatusRepository;

readonly class PostStatusService
{
    public function __construct(
        protected PostStatusRepository $postStatusRepository
    )
    {
    }

    public function getByCode(string $code)
    {
        return $this->postStatusRepository->getByCode($code);
    }

    public function insert(array $data): bool
    {
        return $this->postStatusRepository->insert($data);
    }
}
