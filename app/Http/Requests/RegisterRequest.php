<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|string|unique:users|max:200',
            'password' => 'required|string|min:8|confirmed',
            'email' => 'required|string|email|unique:users'
        ];
    }
}
