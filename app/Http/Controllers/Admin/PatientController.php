<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PatientController
{
    public function index()
    {
        // Tymczasowo wyłącz przekierowanie dla testów
        // $patients = Patient::paginate(20);
        // return view('admin.patients.index', compact('patients'));
        return redirect()->route('admin.dashboard', ['tab' => 'patients']);
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

        return redirect()->route('admin.dashboard', ['tab' => 'patients'])
            ->with('success', 'Pacjent dodany pomyślnie');
    }

    public function create()
    {
        return view('admin.patient-form');
    }
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('admin.patient-form', compact('patient'));
    }

    public function update(UpdatePatientRequest $request, $id)
    {
        Log::info('Attempting to update patient', ['id' => $id]);

        $patient = Patient::findOrFail($id);
        Log::info('Found patient:', ['patient' => $patient]);

        $validated = $request->validated();
        Log::info('Validated data:', $validated);

        $patient->user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
        ]);

        $patient->update([
            'phone_number' => $validated['phone_number'],
            'postal_code' => $validated['postal_code'],
            'city' => $validated['city'],
            'street' => $validated['street'],
            'apartment_number' => $validated['apartment_number'],
            'staircase_number' => $validated['staircase_number'],
            'birth_date' => $validated['birth_date'],
        ]);

        Log::info('Patient updated successfully');

        return redirect()->route('admin.dashboard', ['tab' => 'patients'])
            ->with('success', 'Dane pacjenta zostały zaktualizowane.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        $patient->user()->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'patients'])
            ->with('success', 'Pacjent został usunięty.');
    }
}
