<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AppointmentController
{
    public function index()
    {

        return redirect()->route('admin.dashboard', ['tab' => 'appointments']);
    }
    public function edit($id)
    {
        $appointment = Appointment::with(['doctor.user', 'patient.user'])->findOrFail($id);
        $doctors = Doctor::with('user')->get();
        $patients = Patient::with('user')->get();

        return view('admin.appointment-form', [
            'appointment' => $appointment,
            'doctors' => $doctors,
            'patients' => $patients
        ]);
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'appointments']);
    }
    public function update(UpdateAppointmentRequest $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $validated = $request->validated();

        $appointment->update([
            'doctor_id' => $validated['doctor_id'],
            'patient_id' => $validated['patient_id'],
            'appointment_date' => $validated['appointment_date'],
            'status' => $validated['status'],
            'visit_type' => $validated['visit_type'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'appointments'])
            ->with('success', 'Dane wizyty zostały zaktualizowane.');
    }

    public function create()
    {
        $doctors = Doctor::with('user')->get();
        $patients = Patient::with('user')->get();

        return view('admin.appointment-form', compact('doctors', 'patients'));
    }
    public function store(StoreAppointmentRequest $request)
    {

        $validated = $request->validated();
        Appointment::create([
            'doctor_id' => $validated['doctor_id'],
            'patient_id' => $validated['patient_id'],
            'appointment_date' => $validated['appointment_date'],
            'status' => $validated['status'],
            'visit_type' => $validated['visit_type'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'appointments'])
            ->with('success', 'Wizyta została dodana.');
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
