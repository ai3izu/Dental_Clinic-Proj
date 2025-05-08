<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientUpdateController
{
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->user_id,
            'phone_number' => 'nullable|string|max:15',
        ]);
        $patient->user->update($request->only(['first_name', 'last_name', 'email']));
        $patient->update(['phone_number' => $request->phone_number]);

        return redirect()->route('admin.dashboard', ['tab' => 'patients'])->with('success', 'Dane pacjenta zostały zaktualizowane.');
    }

    public function create()
    {
        return view('admin.patient-create');
    }

    public function store(StorePatientRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make('password123'),
        ]);

        Patient::create([
            'user_id' => $user->id,
            'phone_number' => $validated['phone_number'],
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'patients'])->with('succes', 'Pacjent dodany pomyślnie');
    }
}
