<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'doctor' => redirect()->route('doctor.dashboard'),
                'patient' => redirect()->route('patient.dashboard'),
                default => redirect()->route('unauthorized'),
            };
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
