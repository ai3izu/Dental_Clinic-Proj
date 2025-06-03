<?php

namespace App\Http\Controllers\Public;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorPageController
{
    public function index(Doctor $doctor)
    {
        $doctor->load('user', 'reviews.patient.user');
        $canAddReview = false;

        if (Auth::check() && Auth::user()->role === 'patient') {
            $patientId = Auth::user()->patient->id;

            $completedAppointment = Appointment::where('patient_id', $patientId)
                ->where('doctor_id', $doctor->id)
                ->where('status', 'completed')
                ->exists();

            if ($completedAppointment) {
                $alreadyReviewed = $doctor->reviews()->where('patient_id', $patientId)->exists();
                if (!$alreadyReviewed) {
                    $canAddReview = true;
                }
            }
        }

        $services = [
            'Dentysta ogólny' => [
                'root_canal' => 'Leczenie kanałowe',
                'orthodontics' => 'Ortodoncja'
            ],
            'Stomatolog dziecięcy' => [
                'cavity_treatment' => 'Leczenie próchnicy u dzieci'
            ],
            'Ortodonta' => [
                'orthodontics' => 'Leczenie ortodontyczne'
            ],
            'Chirurg stomatologiczny' => [
                'root_canal' => 'Leczenie kanałowe',
                'implantology' => 'Implantologia'
            ]
        ];

        $doctorServices = $services[$doctor->specialization] ?? [];

        return view('public.doctor-page', compact('doctor', 'canAddReview', 'doctorServices'));
    }
}
