<?php

namespace App\Http\Controllers\Auth\ResetPassword;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPassword\ResetPasswordRequest;
use App\Mail\SendVerificationCode;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function resetPasswordView(): View|Factory|Application
    {
        return view('login.resetPassword.resetPassword');
    }

    public function resetPassword(ResetPasswordRequest $request): Application|Redirector|RedirectResponse
    {
        $data = $request->all();

        $email = $data['email'];
        $password = $data['password'];

        User::query()
            ->where('email', $email)
            ->update([
                'password' => Hash::make($password)
            ]);

        return redirect('/login')->with([
            'resetPassword' => true
        ]);
    }

    public function getResetPasswordLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|email|exists:users'
        ]);

        $email = $request->all()['email'];

        Mail::to($email)->send(new SendVerificationCode($email));

        return back()->with('success', 'Password changed successfully.');
    }
}
