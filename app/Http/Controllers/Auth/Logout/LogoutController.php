<?php

namespace App\Http\Controllers\Auth\Logout;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request): Application|Redirector|RedirectResponse
    {
        Auth::logout();

        // reset user session for logout
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
