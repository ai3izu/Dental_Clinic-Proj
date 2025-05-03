<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:25',
            'last_name' => 'required|max:25',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'patient',
        ]);

        // Create a new patient record associated with the user
        Patient::create([
            'user_id' => $user->id,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        // Only patients are begin registered by default
        // Redirect to the patient dashboard
        return redirect()->route('patient.complete-profile');
    }
}
