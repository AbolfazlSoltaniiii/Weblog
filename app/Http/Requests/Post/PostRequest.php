<?php

namespace App\Http\Requests\Post;

use App\Post;
use App\PostStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::exists(PostStatus::class, 'code')
                    ->whereNull('deleted_at')
            ],
            'title' => [
                'required',
                'string',
                Rule::unique(Post::class)
                    ->whereNull('deleted_at')
                    ->ignore($this->route('post'))
            ],
            'content' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator, response()->json([
            'status' => 'error',
            'errors' => $validator->errors(),
        ], 422));
    }
}
