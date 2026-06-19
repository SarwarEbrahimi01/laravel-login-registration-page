<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
// use Illuminate\Support\Facades\Session;
use Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            return redirect()->intended('/')
                ->with('status', 'Login successful');
        }
        return back()->withInput()
            ->with('status', 'Invalid credentials');
    }

    public function logout(): RedirectResponse
    {
        Session::flush();

        Auth::logout();
        return redirect('/')->with('status', 'Logout successful');
    }
}
