<?php

namespace App\Http\Requests\Auth\ResetPassword;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                Rule::exists(User::class)
                    ->whereNull('deleted_at')
            ],
            'password' => 'required|string|min:8|confirmed'
        ];
    }
}
