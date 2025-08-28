<?php

namespace App\Http\Requests\Auth\Register;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:200',
                Rule::unique(User::class)
                    ->whereNull('deleted_at')
            ],
            'password' => 'required|string|min:8|confirmed',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique(User::class)
                    ->whereNull('deleted_at')
            ]
        ];
    }
}
