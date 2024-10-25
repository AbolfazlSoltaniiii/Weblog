<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected mixed $request;

    public function __construct(
        Request               $request,
        private readonly Post $post
    )
    {
        $this->request = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function index(): Collection
    {
        $status = $this->request['status'] ?? null;

        return $this->post->query()
            ->whereHas('poststatus', function ($query) use ($status) {
                $query->where('code', $status);
            })
            ->get();
    }
}
