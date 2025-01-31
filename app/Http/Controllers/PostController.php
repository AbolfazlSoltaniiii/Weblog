<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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

    public function store(): JsonResponse
    {
        try {
            $attributes = $this->validateAttributes();

            $title = $attributes['title'] ?? null;

            $post = $this->post->query()->create([
                'post_status_id' => 2,
                'title' => $title,
                'content' => $attributes['content'] ?? null,
            ]);

            return response()->json([
                'status' => 'success',
                'post' => $post,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);
        }
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
                'title' => $request['title'] ?? null,
                'content' => $request['content'] ?? null,
            ]);
    }

    public function destroy($id): ?bool
    {
        return $this->post->query()
            ->find($id)
            ?->delete();
    }

    /**
     * @throws ValidationException
     * @throws JsonException
     */
    public function validateAttributes(): array
    {
        $requestData = json_decode($this->request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $validator = Validator::make($requestData, [
            'post_status_id' => 'exists:poststatus,id',
            'title' => 'required|string|unique:posts',
            'content' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
