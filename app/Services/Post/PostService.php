<?php

namespace App\Services\Post;

use App\Repositories\Post\PostRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

readonly class PostService
{
    public function __construct(
        protected PostRepository $postRepository
    )
    {
    }

    public function index(string $status): Collection
    {
        $user = Auth::user();
        $userId = $user?->id;

        return $this->postRepository->index($status, $userId);
    }

    public function getCountForDashboard(string|null $status): string
    {
        $result = $this->postRepository->getCountForDashboard($status);

        return (string)$result?->count;
    }

    public function create(array $data)
    {
        return $this->postRepository->create($data);
    }

    public function update(array $data, int $keyId): ?bool
    {
        return $this->postRepository->update($data, $keyId);
    }

    public function delete(int $keyId): ?bool
    {
        return $this->postRepository->delete($keyId);
    }
}
