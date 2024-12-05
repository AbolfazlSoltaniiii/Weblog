<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use JsonException;

class PostController extends Controller
{
    protected mixed $request;

    public function __construct(
        Request               $request,
        private readonly Post $post
    )
    {
        $this->request = $request;
    }

    /**
     * @throws JsonException
     */
    public function index(): Collection
    {
        $request = json_decode($this->request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $status = $request['status'] ?? null;

        return $this->post->with('postStatus')
            ->whereHas('postStatus', fn($query) => $query->where('code', $status))
            ->get();
    }

    /**
     * @throws JsonException
     */
    public function store()
    {
        $request = json_decode($this->request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $title = $request['title'] ?? null;

        return $this->post->query()
            ->create([
                'post_status_id' => 2,
                'title' => $title
            ]);
    }

    /**
     * @throws JsonException
     */
    public function update($id): ?bool
    {
        $request = json_decode($this->request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        return $this->post->query()
            ->find($id)
            ?->update([
                'title' => $request['title']
            ]);
    }

    public function destroy($id): ?bool
    {
        return $this->post->query()
            ->find($id)
            ?->delete();
    }
}
