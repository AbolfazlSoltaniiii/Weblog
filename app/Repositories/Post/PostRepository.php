<?php

namespace App\Repositories\Post;

use App\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

readonly class PostRepository
{
    public function __construct(
        protected Post $post
    )
    {
    }

    public function index($status, $userId): Collection
    {
        return $this->post->with(['postStatus', 'postUser.users'])
            ->whereHas('postStatus', fn($query) => $query->where('code', $status))
            ->when($userId !== 1, function ($q) use ($userId) {
                $q->whereHas('postUser', fn($query) => $query->where('user_id', $userId));
            })
            ->get();
    }

    public function getCountForDashboard(string|null $status)
    {
        return $this->post->query()
            ->select(
                DB::raw('count(*) as count')
            )
            ->when(isset($status), function ($q) use ($status) {
                $q->whereHas('postStatus', fn($query) => $query->where('code', $status));
            })
            ->first();
    }

    public function create(array $data)
    {
        return $this->post->query()
            ->create($data);
    }

    public function update(array $data, int $keyId): ?bool
    {
        return $this->post->query()
            ->find($keyId)
            ?->update($data);
    }

    public function delete(int $keyId): ?bool
    {
        return $this->post->query()
            ->find($keyId)
            ?->delete();
    }
}
