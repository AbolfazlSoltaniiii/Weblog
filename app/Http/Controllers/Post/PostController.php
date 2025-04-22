<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostRequest;
use App\Http\Resources\Post\PostResource;
use App\Services\Post\PostService;
use App\Services\PostStatus\PostStatusService;
use App\Services\PostUser\PostUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use JsonException;

class PostController extends Controller
{
    protected mixed $request;

    public function __construct(
        Request                              $request,
        private readonly PostService         $postService,
        protected readonly PostStatusService $postStatusService,
        protected readonly PostUserService   $postUserService
    )
    {
        $this->request = $request;
    }

    /**
     * @throws JsonException
     */
    public function index(): AnonymousResourceCollection
    {
        $request = json_decode($this->request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $status = $request['status'] ?? null;

        $result = $this->postService->index($status);

        return PostResource::collection($result);
    }

    public function store(PostRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $attributes = $request->all();

            $userId = Auth::user()?->id;

            $title = $attributes['title'] ?? null;

            $postStatusCode = $request['status'] ?? null;
            $postStatusId = $this->postStatusService->getByCode($postStatusCode)?->id;

            $post = $this->postService->create([
                'post_status_id' => $postStatusId,
                'title' => $title,
                'content' => $attributes['content'] ?? null,
            ]);

            $this->postUserService->create([
                'post_id' => $post?->id,
                'user_id' => $userId
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'post' => $post,
            ], 201);

        } catch (ValidationException $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function update(PostRequest $request, int $id): ?bool
    {
        $postStatusCode = $request['status'] ?? null;
        $postStatusId = $this->postStatusService->getByCode($postStatusCode)?->id;

        return $this->postService->update([
            'title' => $request['title'] ?? null,
            'post_status_id' => $postStatusId,
            'content' => $request['content'] ?? null,
        ], $id);
    }

    public function destroy(int $id): ?bool
    {
        return $this->postService->delete($id);
    }
}
