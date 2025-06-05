<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DoctorController

{
    public function index()
    {
        return redirect()->route('admin.dashboard', ['tab' => 'doctors']);
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('admin.doctor-form', compact('doctor'));
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);

        if ($doctor->photo_url) {
            $oldPathOnDisk = Str::after($doctor->photo_url, 'storage/');
            if (Storage::disk('public')->exists($oldPathOnDisk)) {
                Storage::disk('public')->delete($oldPathOnDisk);
                Log::info("Usunięto zdjęcie lekarza podczas usuwania konta: " . $oldPathOnDisk);
            } else {
                Log::warning("Nie znaleziono zdjęcia do usunięcia podczas usuwania konta lekarza: " . $oldPathOnDisk);
            }
        }
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

        $updateData = [
            'specialization' => $validated['specialization'] ?? $doctor->specialization,
            'phone_number' => $validated['phone_number'] ?? $doctor->phone_number,
            'description' => $validated['description'] ?? $doctor->description,
            'photo_alt' => $validated['photo_alt'] ?? $doctor->photo_alt,
        ];

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');

            if ($doctor->photo_url) {
                $oldPathOnDisk = Str::after($doctor->photo_url, 'storage/');
                if (Storage::disk('public')->exists($oldPathOnDisk)) {
                    Storage::disk('public')->delete($oldPathOnDisk);
                    Log::info("Usunięto stary plik lekarza: " . $oldPathOnDisk);
                } else {
                    Log::warning("Stary plik lekarza nie istnieje na dysku publicznym: " . $oldPathOnDisk . " (photo_url w DB: " . $doctor->photo_url . ")");
                }
            }

            $extension = $file->getClientOriginalExtension();
            $filename = (string) Str::uuid() . '.' . $extension;
            $path = $file->storeAs('images', $filename, 'public');

            $updateData['photo_url'] = 'storage/' . $path;
        }

        $doctor->update($updateData);

        return redirect()->route('admin.dashboard', ['tab' => 'doctors'])
            ->with('success', 'Dane lekarza zostały zaktualizowane.');
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

        $photoPath = null;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = (string) Str::uuid() . '.' . $extension;

            $path = $file->storeAs('images', $filename, 'public');
            $photoPath = 'storage/' . $path;
        }

        Doctor::create([
            'user_id' => $user->id,
            'specialization' => $validated['specialization'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'photo_url' => $photoPath,
            'photo_alt' => $validated['photo_alt'] ?? 'Zdjęcie lekarza ' . $validated['first_name'] . ' ' . $validated['last_name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'doctors'])
            ->with('success', 'Lekarz dodany pomyślnie');
    }

    public function publicIndex()
    {
        $doctors = Doctor::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'doctor');
            })
            ->get()
            ->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'first_name' => $doctor->user->first_name,
                    'last_name' => $doctor->user->last_name,
                    'specialization' => $doctor->specialization,
                    'photo_url' => $doctor->photo_url,
                    'description' => $doctor->description,
                ];
            });

        return view('public.doctors', compact('doctors'));
    }
}
