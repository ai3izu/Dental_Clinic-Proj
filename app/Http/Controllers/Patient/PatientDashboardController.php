<?php

namespace App\Http\Controllers\Patient;

use App\Models\Appointment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientDashboardController
{
    private array $visitPrices = [
        'implantology' => 1500,
        'orthodontics' => 250,
        'root_canal' => 800,
        'cavity_treatment' => 300,
    ];

    public function index()
    {
        $appointments = Auth::user()->patient->appointments()->with(['doctor.user', 'transaction'])->get();

        $upcoming = $appointments->where('status', 'scheduled');

        $canceled = $appointments->where('status', 'canceled');

        $completed = $appointments->where('status', 'completed');

        $visitPrices = $this->visitPrices;

        return view('dashboard', compact('upcoming', 'completed', 'canceled', 'visitPrices'));
    }

    public function pay(Appointment $appointment)
    {
        if ($appointment->status !== 'canceled' && $appointment->status !== 'completed' && !$appointment->isPaid()) {

            $amount = $this->visitPrices[$appointment->visit_type] ?? null;

            if (is_null($amount)) {
                Log::error("Próba płatności za niezdefiniowany typ wizyty: {$appointment->visit_type} dla wizyty ID: {$appointment->id}");
                return redirect()->route('patient.dashboard')->with('error', 'Wystąpił błąd: Nie można określić ceny dla tego typu wizyty.');
            }

            $transaction = new Transaction();
            $transaction->appointment_id = $appointment->id;
            $transaction->amount = $amount;
            $transaction->status = 'paid';
            $transaction->payment_date = now();
            $transaction->save();

            return redirect()->route('patient.dashboard')->with('success', 'Wizyta została opłacona.');
        }

        return redirect()->route('patient.dashboard')->with('error', 'Wizyta nie może zostać opłacona. Sprawdź jej status lub czy już nie została opłacona.');
    }

    public function cancel(Appointment $appointment)
    {
        if ($appointment->status !== 'completed' && !$appointment->isPaid()) {
            $appointment->status = 'canceled';
            $appointment->save();

            return redirect()->route('patient.dashboard')->with('success', 'Wizyta została anulowana.');
        }

        return redirect()->route('patient.dashboard')->with('error', 'Nie można anulować tej wizyty. Być może została już opłacona lub zakończona.');
    }
}
