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
        $availableSlots = collect();
        return view('patient.apointment-reservation', compact('doctor', 'availableSlots'));
    }

    public function store(Request $request)
    {
        $appointmentDate = Carbon::parse($request->date . ' ' . $request->time);
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'visit_type' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
        ]);

        $doctor = Doctor::find($request->doctor_id);

        if ($appointmentDate->isBefore(Carbon::now()->subMinutes(5))) {
            return back()->withErrors(['date' => 'Wybrana data i godzina wizyty musi być w przyszłości.'])->withInput();
        }

        if ($appointmentDate->hour < 9 || $appointmentDate->hour > 17 || $appointmentDate->minute !== 0) {
            return back()->withErrors(['time' => 'Godzina wizyty musi być pełną godziną między 09:00 a 17:00.'])->withInput();
        }

        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $appointmentDate)
            ->where('status', 'scheduled')
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['time' => 'Wybrana godzina jest już zajęta w tym dniu. Proszę wybrać inny termin.'])->withInput();
        }

        Appointment::create([
            'patient_id' => Auth::user()->patient->id,
            'doctor_id' => $request->doctor_id,
            'visit_type' => $request->visit_type,
            'appointment_date' => $appointmentDate,
            'status' => 'scheduled',
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Wizyta została zaplanowana.');
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $date = Carbon::parse($request->date);
        $doctor = Doctor::find($request->doctor_id);

        $startOfDay = $date->copy()->hour(9)->minute(0)->second(0);
        $endOfDay = $date->copy()->hour(17)->minute(0)->second(0);

        $allPossibleSlots = CarbonPeriod::create($startOfDay, '60 minutes', $endOfDay)->toArray();

        $takenSlots = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $date)
            ->where('status', 'scheduled')
            ->pluck('appointment_date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('H:i');
            })
            ->toArray();

        $availableSlots = collect($allPossibleSlots)->filter(function ($slot) use ($takenSlots, $date) {
            if ($slot->isSameDay(Carbon::now())) {
                return $slot->isAfter(Carbon::now()->subMinutes(5)) && !in_array($slot->format('H:i'), $takenSlots);
            }
            return !in_array($slot->format('H:i'), $takenSlots);
        })->map(function ($slot) {
            return $slot->format('H:i');
        })->values();

        return response()->json($availableSlots);
    }
}
