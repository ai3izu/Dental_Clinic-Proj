<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController  
{
    public function register(Request $request){
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password), 
            'role' => 'patient',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return match ($user -> role) {
            'admin' => redirect()->route('/admin'),
            'doctor' => redirect()->route('/doctor'),
            'patient' => redirect()->route('/patient'),
            default => redirect()->route('unauthorized'),
        };
    }
}
