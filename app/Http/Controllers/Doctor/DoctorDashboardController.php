<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DoctorDashboardController
{
    public function dashboard()
    {
        $doctor = Auth::user()->doctor;

        $upcomingAppointments = $doctor->appointments()->where('status', 'scheduled')->orderBy('appointment_date')->get();
        $completedAppointments = $doctor->appointments()->where('status', 'completed')->orderByDesc('appointment_date')->get();
        $canceledAppointments = $doctor->appointments()->where('status', 'canceled')->orderByDesc('appointment_date')->get();

        return view('dashboard', compact('upcomingAppointments', 'completedAppointments', 'canceledAppointments', 'doctor'));
    }

    public function confirmAppointment(Appointment $appointment)
    {
        if ($appointment->status === 'scheduled') {
            $appointment->status = 'completed';
            $appointment->save();
        }

        return back()->with('success', 'Wizyta została potwierdzona.');
    }

    public function cancelAppointment(Appointment $appointment)
    {
        if ($appointment->status !== 'completed') {
            $appointment->status = 'canceled';
            $appointment->save();
        }

        return back()->with('success', 'Wizyta została anulowana.');
    }

    public function restoreAppointment(Appointment $appointment)
    {
        if ($appointment->status === 'canceled') {
            $appointment->status = 'scheduled';
            $appointment->save();
        }

        return back()->with('success', 'Wizyta została przywrócona.');
    }

    public function rescheduleAppointment(Request $request, Appointment $appointment)
    {
        $validator = Validator::make($request->all(), [
            'new_appointment_date' => 'required|date_format:Y-m-d',
            'new_appointment_time' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dateTimeString = $request->new_appointment_date . ' ' . $request->new_appointment_time;
        $newAppointmentDate = Carbon::parse($dateTimeString);

        if ($newAppointmentDate->isBefore(Carbon::now()->subMinutes(5))) {
            return back()->withErrors(['new_appointment_date' => 'Nowa data i godzina wizyty musi być w przyszłości.'])->withInput();
        }

        if ($newAppointmentDate->hour < 9 || $newAppointmentDate->hour > 17 || $newAppointmentDate->minute !== 0) {
            return back()->withErrors(['new_appointment_time' => 'Godzina wizyty musi być pełną godziną między 09:00 a 17:00.'])->withInput();
        }

        $doctor = Auth::user()->doctor;

        $existingAppointment = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', $newAppointmentDate)
            ->where('id', '!=', $appointment->id)
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['new_appointment_time' => 'Wybrana godzina jest już zajęta w tym dniu. Proszę wybrać inny termin.'])->withInput();
        }

        $appointment->appointment_date = $newAppointmentDate;
        $appointment->save();

        return back()->with('success', 'Termin wizyty został zmieniony.');
    }

    public function addNotes(Request $request, Appointment $appointment)
    {
        Log::debug('Before update:', ['current_notes' => $appointment->notes]);

        $appointment->update([
            'notes' => $request->input('notes', '')
        ]);

        Log::debug('After update:', $appointment->fresh()->toArray());

        return redirect()->route('doctor.dashboard');
    }

    public function showNotesForm(Appointment $appointment)
    {
        if ($appointment->status !== 'completed') {
            return redirect()->route('doctor.dashboard')->with('error', 'Można dodawać notatki tylko do zakończonych wizyt.');
        }

        return view('doctor.doctor-notes', compact('appointment'));
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
