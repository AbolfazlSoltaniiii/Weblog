<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\PostStatus\PostStatusResource;
use App\Http\Resources\PostUser\PostUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this?->id,
            "post_status_id" => $this?->post_status_id,
            "title" => $this?->title,
            "content" => $this?->content,
            "post_status" => new PostStatusResource($this?->postStatus),
            "post_user" => PostUserResource::collection($this?->postUser)
        ];
    }
}
