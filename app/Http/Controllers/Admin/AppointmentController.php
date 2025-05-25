<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
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
}
