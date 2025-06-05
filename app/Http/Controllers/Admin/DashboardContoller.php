<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Review;
use App\Models\Transaction;
use Carbon\Carbon;
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
        $reviews = $tab === 'reviews' ? $this->getReviews($search) : null;
        $transactions = $tab === 'transactions' ? $this->getTransactions($search) : null;
        $statistics = $tab === 'statistics' ? $this->getStatistics() : null;

        return view(
            'dashboard',
            compact(
                'patients',
                'doctors',
                'appointments',
                'reviews',
                'transactions',
                'statistics',
                'tab'
            )
        );
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

    private function getReviews($search)
    {
        return Review::with(['doctor.user', 'patient.user'])
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

    private function getTransactions($search)
    {
        return Transaction::with(['appointment.doctor.user', 'appointment.patient.user'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('appointment.doctor.user', function ($subQ) use ($search) {
                        $subQ->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                    })->orWhereHas('appointment.patient.user', function ($subQ) use ($search) {
                        $subQ->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                    })->orWhereDate('payment_date', $search);
                });
            })
            ->paginate(20);
    }

    private function getStatistics()
    {
        $totalCompletedAppointments = Appointment::where('status', 'completed')->count();
        $totalRegisteredPatients = Patient::count();
        $totalRegisteredDoctors = Doctor::count();
        $totalAppointments = Appointment::count();
        $totalTransactions = Transaction::where('status', 'paid')->count();

        $appointmentsLast7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = Appointment::whereDate('appointment_date', $date)->count();
            $appointmentsLast7Days[] = [
                'date' => $date->format('Y-m-d'),
                'count' => $count,
            ];
        }

        return [
            'total_completed_appointments' => $totalCompletedAppointments,
            'total_registered_patients' => $totalRegisteredPatients,
            'total_registered_doctors' => $totalRegisteredDoctors,
            'total_appointments' => $totalAppointments,
            'total_paid_transactions' => $totalTransactions,
            'appointments_last_7_days' => $appointmentsLast7Days,
        ];
    }
}
