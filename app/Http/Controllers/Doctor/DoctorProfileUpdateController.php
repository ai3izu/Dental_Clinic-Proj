<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Requests\UpdateDoctorRequest; // Używamy tego samego Requestu do walidacji
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Do pobrania zalogowanego lekarza
use Illuminate\Support\Facades\Storage; // Do usuwania starych zdjęć
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // Do generowania UUID

class DoctorProfileUpdateController
{
    /**
     * Display the doctor's profile edit form.
     */
    public function edit()
    {
        $doctor = Auth::user()->doctor;
        return view('doctor.doctor-edit-profile', compact('doctor'));
    }

    /**
     * Update the doctor's profile.
     */
    public function update(UpdateDoctorRequest $request)
    {
        $doctor = Auth::user()->doctor;
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
                    Log::info("Usunięto stary plik z dysku publicznego: " . $oldPathOnDisk);
                } else {
                    Log::warning("Stary plik nie istnieje na dysku publicznym: " . $oldPathOnDisk . " (photo_url w DB: " . $doctor->photo_url . ")");
                }
            }
            $extension = $file->getClientOriginalExtension();
            $filename = (string) Str::uuid() . '.' . $extension;
            $path = $file->storeAs('images', $filename, 'public');


            $updateData['photo_url'] = 'storage/' . $path;
        }

        $doctor->update($updateData);

        return redirect()->route('doctor.dashboard')
            ->with('success', 'Twój profil został zaktualizowany.');
    }
}
