<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        try {
            // ✅ Attempt Login
            if (Auth::attempt($request->only('email', 'password'))) {
                $request->session()->regenerate();
                return redirect('/dashboard');
            }

            // ❌ Invalid Credentials
            return back()->withErrors([
                'email' => 'Invalid email or password'
            ]);

        } catch (\Exception $e) {

            // 🧾 Log error
            Log::error('Login Error: '.$e->getMessage(), [
                'email' => $request->email
            ]);

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
