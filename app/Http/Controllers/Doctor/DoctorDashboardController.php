<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DoctorDashboardController
{
    public function dashboard()
    {
        $doctor = Auth::user()->doctor;

        $upcomingAppointments = $doctor->appointments()->where('status', 'scheduled')->orderBy('appointment_date')->get();
        $completedAppointments = $doctor->appointments()->where('status', 'completed')->orderByDesc('appointment_date')->get();
        $canceledAppointments = $doctor->appointments()->where('status', 'canceled')->orderByDesc('appointment_date')->get();

        return view('dashboard', compact('upcomingAppointments', 'completedAppointments', 'canceledAppointments'));
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
            'appointment_date' => 'required|date|after:now',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $appointment->appointment_date = $request->appointment_date;
        $appointment->save();

        return back()->with('success', 'Termin wizyty został zmieniony.');
    }

    public function addNotes(Request $request, Appointment $appointment)
    {
        Log::debug('Before update:', ['current_notes' => $appointment->notes]);

        $appointment->update([
            'notes' => $request->input('notes', '')
        ]);

        // Debug: sprawdź zmiany
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
}
