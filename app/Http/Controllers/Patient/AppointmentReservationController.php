<?php

namespace App\Http\Controllers\Patient;

use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentReservationController
{
    public function create(Doctor $doctor)
    {
        $today = Carbon::today()->hour(9)->minute(0);
        $end = Carbon::today()->hour(17)->minute(0);
        $allSlots = CarbonPeriod::create($today, '30 minutes', $end)->toArray();

        $takenSlots = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', Carbon::today())
            ->pluck('appointment_date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('H:i');
            })
            ->toArray();

        $availableSlots = collect($allSlots)->filter(function ($slot) use ($takenSlots) {
            return !in_array($slot->format('H:i'), $takenSlots);
        })->map(function ($slot) {
            return $slot->format('H:i');
        });

        return view('patient.apointment-reservation', compact('doctor', 'availableSlots'));
    }

    public function store(Request $request)
    {
        $appointmentDate = Carbon::parse($request->date . ' ' . $request->time);
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'visit_type' => 'required|string|max:255',
        ]);

        Appointment::create([
            'patient_id' => Auth::user()->patient->id,
            'doctor_id' => $request->doctor_id,
            'visit_type' => $request->visit_type,
            'appointment_date' => $appointmentDate,
            'status' => 'scheduled',
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Wizyta została zaplanowana.');
    }
}
