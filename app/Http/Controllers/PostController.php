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

        return $this->post->query()
            ->join('post_status', 'post_status.id', '=', 'posts.post_status_id')
            ->where('post_status.code', $status)
            ->select('posts.*', 'post_status.code as post_status_code', 'post_status.title as post_status_title')
            ->get();
    }

    public function destroy($id): ?bool
    {
        return $this->post->query()
            ->find($id)
            ?->delete();
    }
}
