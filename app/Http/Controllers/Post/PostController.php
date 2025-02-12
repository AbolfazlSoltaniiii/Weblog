<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PostStatus\PostStatusController;
use App\Http\Controllers\PostUser\PostUserController;
use App\Http\Requests\Post\PostRequest;
use App\Http\Resources\Post\PostResource;
use App\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use JsonException;
use function PHPUnit\TestFixture\func;

class PostController extends Controller
{
    protected mixed $request;

    public function __construct(
        Request                               $request,
        private readonly Post                 $post,
        private readonly PostUserController   $postUserController,
        private readonly PostStatusController $postStatusController
    )
    {
        $this->request = $request;
    }

    /**
     * @throws JsonException
     */
    public function index(): AnonymousResourceCollection
    {
        $userId = Auth::user()?->id;

        $request = json_decode($this->request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $status = $request['status'] ?? null;

        $result = $this->post->with(['postStatus', 'postUser.users'])
            ->whereHas('postStatus', fn($query) => $query->where('code', $status))
            ->when($userId !== 1, function ($q) use ($userId) {
                $q->whereHas('postUser', fn($query) => $query->where('user_id', $userId));
            })
            ->get();

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
            $postStatusId = $this->postStatusController->getByCode($postStatusCode)?->id;

            $post = $this->post->query()->create([
                'post_status_id' => $postStatusId,
                'title' => $title,
                'content' => $attributes['content'] ?? null,
            ]);

            $this->postUserController->store([
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

    public function update(PostRequest $request, $id): ?bool
    {
        $postStatusCode = $request['status'] ?? null;
        $postStatusId = $this->postStatusController->getByCode($postStatusCode)?->id;

        return $this->post->query()
            ->find($id)
            ?->update([
                'title' => $request['title'] ?? null,
                'post_status_id' => $postStatusId,
                'content' => $request['content'] ?? null,
            ]);
    }

    public function destroy($id): ?bool
    {
        return $this->post->query()
            ->find($id)
            ?->delete();
    }

    public function getCountForDashboard($status = null): string
    {
        $result = $this->post->query()
            ->select(DB::raw('count(*) as count'))
            ->when(isset($status), function ($q) use ($status) {
                $q->whereHas('postStatus', fn($query) => $query->where('code', $status));
            })
            ->first();

        return (string)$result?->count;
    }
}
