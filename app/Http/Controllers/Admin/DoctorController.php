<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DoctorController
{
    public function editDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('admin.doctor-form', compact('doctor'));
    }
    public function destroyDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        $doctor->user()->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'doctors']);
    }

    public function update(UpdateDoctorRequest $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $validated = $request->validated();

        $userData = [
            'first_name' => $validated['first_name'] ?? $doctor->user->first_name,
            'last_name' => $validated['last_name'] ?? $doctor->user->last_name,
        ];

        if (isset($validated['email'])) {
            $userData['email'] = $validated['email'];
        }

        $doctor->user->update($userData);

        $doctor->update([
            'specialization' => $validated['specialization'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'photo_url' => $validated['photo_url'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'doctors'])->with('success', 'Dane lekarza zostały zaktualizowane.');
    }

    public function create()
    {
        return view('admin.doctor-form');
    }

    public function store(StoreDoctorRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make('password123'),
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'specialization' => $validated['specialization'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'photo_url' => $validated['photo_url'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'doctors'])->with('success', 'Pacjent dodany pomyślnie');
    }
}
