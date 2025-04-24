<?php

namespace App\Repositories\PostStatus;

use App\PostStatus;

readonly class PostStatusRepository
{
    public function __construct(
        protected PostStatus $postStatus
    )
    {
    }

    public function getByCode(string $code)
    {
        return $this->postStatus->query()
            ->where('code', $code)
            ->sole();
    }

    public function insert(array $data): bool
    {
        return $this->postStatus->query()
            ->insert($data);
    }
}
