<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class DashboardContoller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'patients');
        $search = $request->query('search');

        $patients = $tab === 'patients' ? $this->getPatients($search) : null;
        $doctors = $tab === 'doctors' ? $this->getDoctors($search) : null;
        $appointments = $tab === 'appointments' ? $this->getAppointments($search) : null;

        return view('dashboard', compact('patients', 'doctors', 'appointments', 'tab'));
    }

    private function getPatients($search)
    {
        return Patient::with('user')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->paginate(20);
    }

    private function getDoctors($search)
    {
        return Doctor::with('user')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->paginate(20);
    }

    private function getAppointments($search)
    {
        return Appointment::with(['doctor.user', 'patient.user'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('doctor.user', function ($subQ) use ($search) {
                        $subQ->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                    })->orWhereHas('patient.user', function ($subQ) use ($search) {
                        $subQ->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                    });
                });
            })
            ->paginate(20);
    }
}
