<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function loginView(): View|Factory|Application
    {
        return view('login.login');
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $userName = $request->username ?? null;
        $password = $request->password ?? null;

        if (Auth::attempt(['username' => $userName, 'password' => $password])) {
            $request->session()->regenerate();

            return redirect()->route('/');
        }

        throw ValidationException::withMessages([
            'login_error' => 'نام کاربری یا رمزعبور صحیح نمی باشد.'
        ]);
    }
}
