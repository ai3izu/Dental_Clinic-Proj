<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class DashboardContoller
{
    // Display data 
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'patients');
        $search = $request->query('search');

        $patients = Patient::with('user')
            ->when($search && $tab === 'patients', function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->paginate(20);

        $doctors = Doctor::with('user')
            ->when($search && $tab === 'doctors', function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->paginate(20);

        return view('dashboard', compact('patients', 'doctors', 'tab'));
    }

    public function destroyPatient($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        $patient->user()->delete();


        return redirect()->route('admin.dashboard', ['tab' => 'patients']);
    }

    public function destroyDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        $doctor->user()->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'doctors']);
    }

    public function editPatient($id)
    {
        $patient = Patient::findOrFail($id);
        return view('admin.patient-form', compact('patient'));
    }

    public function editDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('admin.doctor-form', compact('doctor'));
    }
}
