<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePatientRequest;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorUpdateController
{
    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        $doctor->user->update($request->only(['first_name', 'last_name', 'email']));

        return redirect()->route('admin.dashboard', ['tab' => 'doctors'])->with('success', 'Dane lekarza zostały zaktualizowane.');
    }

    public function create()
    {
        return view('admin.doctor-form');
    }

    public function store(StorePatientRequest $request)
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
            'phone_number' => $validated['phone_number'],
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'doctors'])->with('success', 'Pacjent dodany pomyślnie');
    }
}
