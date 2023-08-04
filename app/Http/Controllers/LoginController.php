<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('layouts.login');
    }

    public function store()
    {
        if (Auth::attempt($this->dataValidated())) {
            request()->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return to_route('login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function destroy() {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return to_route('login');
    }

    public function dataValidated()
    {
        return request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    }
}
