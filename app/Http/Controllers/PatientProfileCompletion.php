<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientProfileCompletion
{
    public function show()
    {
        $patient = Auth::user()->patient;
        return view('patient.complete-profile', compact('patient'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|max:15',
            'postal_code' => 'required|max:10',
            'city' => 'required|max:50',
            'street' => 'required|max:100',
            'apartment_number' => 'nullable|max:10',
            'staircase_number' => 'nullable|max:10',
            'birth_date' => 'required|date',
        ]);

        $patitent = Auth::user()->patient;
        $patitent->update([
            'phone_number' => $request->phone_number,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'street' => $request->street,
            'apartment_number' => $request->apartment_number,
            'staircase_number' => $request->staircase_number,
            'birth_date' => $request->birth_date,
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Profile updated successfully.');
    }
}
