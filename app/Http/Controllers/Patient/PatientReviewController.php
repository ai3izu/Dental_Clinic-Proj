<?php

namespace App\Http\Controllers\Patient;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientReviewController
{
    public function storePublic(Request $request, Doctor $doctor)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        if (!Auth::check() || Auth::user()->role !== 'patient') {
            return redirect()->back()->with('error', 'Musisz być zalogowanym pacjentem, aby dodać opinię.');
        }

        $patient = Auth::user()->patient;

        $hasCompletedAppointment = Appointment::where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->where('status', 'completed')
            ->exists();

        if (!$hasCompletedAppointment) {
            return redirect()->back()->with('error', 'Możesz dodać opinię tylko po odbyciu wizyty u tego lekarza.');
        }

        $alreadyReviewed = Review::where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->back()->with('error', 'Już dodałeś opinię dla tego lekarza.');
        }

        Review::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'Twoja opinia została dodana pomyślnie!');
    }
}
