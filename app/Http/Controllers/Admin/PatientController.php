<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PatientController
{

    public function editPatient($id)
    {
        $patient = Patient::findOrFail($id);
        return view('admin.patient-form', compact('patient'));
    }

    public function destroyPatient($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        $patient->user()->delete();


        return redirect()->route('admin.dashboard', ['tab' => 'patients']);
    }

    public function update(UpdatePatientRequest $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $validated = $request->validated();

        $userData = [
            'first_name' => $validated['first_name'] ?? $patient->user->first_name,
            'last_name' => $validated['last_name'] ?? $patient->user->last_name,
        ];

        if (isset($validated['email'])) {
            $userData['email'] = $validated['email'];
        }

        $patient->user->update($userData);

        $patient->update([
            'phone_number' => $validated['phone_number'] ?? $patient->phone_number,
            'postal_code' => $validated['postal_code'] ?? $patient->postal_code,
            'city' => $validated['city'] ?? $patient->city,
            'street' => $validated['street'] ?? $patient->street,
            'apartment_number' => $validated['apartment_number'] ?? $patient->apartment_number,
            'staircase_number' => $validated['staircase_number'] ?? $patient->staircase_number,
            'birth_date' => $validated['birth_date'] ?? $patient->birth_date,
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'patients'])->with('success', 'Dane pacjenta zostały zaktualizowane.');
    }

    public function create()
    {
        return view('admin.patient-form');
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
            'phone_number' => $validated['phone_number'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'city' => $validated['city'] ?? null,
            'street' => $validated['street'] ?? null,
            'apartment_number' => $validated['apartment_number'] ?? null,
            'staircase_number' => $validated['staircase_number'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'patients'])->with('success', 'Pacjent dodany pomyślnie');
    }
}
