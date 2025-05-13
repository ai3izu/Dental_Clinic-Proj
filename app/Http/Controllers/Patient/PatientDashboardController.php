<?php

namespace App\Http\Controllers\Patient;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientDashboardController
{
    public function index()
    {
        $appointments = Auth::user()->patient->appointments()->with(['doctor.user', 'transaction'])->get();

        $upcoming = $appointments->where('status', 'scheduled');

        $canceled = $appointments->where('status', 'canceled');

        $completed = $appointments->where('status', 'completed');

        return view('dashboard', compact('upcoming', 'completed', 'canceled'));
    }



    public function pay(Appointment $appointment)
    {
        if ($appointment->status !== 'canceled' && $appointment->status !== 'completed') {

            $transaction = new Transaction();
            $transaction->appointment_id = $appointment->id;
            $transaction->amount = 200;
            $transaction->status = 'paid';
            $transaction->payment_date = now();
            $transaction->save();


            $appointment->status = 'completed';
            $appointment->save();


            return redirect()->route('patient.dashboard')->with('success', 'Wizyta została opłacona.');
        }

        return redirect()->route('patient.dashboard')->with('error', 'Wizyta nie może zostać opłacona.');
    }


    public function cancel(Appointment $appointment)
    {
        if ($appointment->status !== 'completed' && $appointment->status !== 'paid') {
            $appointment->status = 'canceled';
            $appointment->save();

            return redirect()->route('patient.dashboard')->with('success', 'Wizyta została anulowana.');
        }

        return redirect()->route('patient.dashboard')->with('error', 'Nie można anulować tej wizyty.');
    }
}
