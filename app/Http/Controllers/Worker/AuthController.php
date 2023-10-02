<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView(): View
    {
        return view('views.worker.login');
    }

    public function loginHandle(Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'code' => 'string|required|size:35|exists:users',
            'password' => 'string|required'
        ]);

        if (Auth::attempt($valid)) {
            $request->session()->regenerate();

            return redirect()->route(auth()->user()->position === 'employee' ? 'staff.working' : 'staff.dashboard');
        }

        return back()->with('failed', 'Incorrect data provided');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('staff.auth.login');
    }
}
