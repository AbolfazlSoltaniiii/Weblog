<?php

namespace App\Http\Requests\Auth\ResetPassword;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|exists:users',
            'password' => 'required|string|min:8|confirmed'
        ];
    }
}
