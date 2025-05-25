<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Appointment;
use App\Models\Transaction;

class TransactionController
{
    public function index()
    {
        return redirect()->route('admin.dashboard', ['tab' => 'transactions']);
    }
    public function edit($id)
    {
        $transaction = Transaction::with('appointment.doctor.user', 'appointment.patient.user')->findOrFail($id);
        $appointments = Appointment::with(['doctor.user', 'patient.user'])->get();

        return view('admin.transaction-form', [
            'transaction' => $transaction,
            'appointments' => $appointments
        ]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()
            ->route('admin.dashboard', ['tab' => 'transactions'])
            ->with('success', 'Transakcja została usunięta.');
    }
    public function update(UpdateTransactionRequest $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $validated = $request->validated();

        $transaction->update([
            'appointment_id' => $validated['appointment_id'],
            'amount' => $validated['amount'],
            'status' => $validated['status'],
            'payment_date' => $validated['payment_date'] ?? null,
        ]);

        return redirect()
            ->route('admin.dashboard', ['tab' => 'transactions'])
            ->with('success', 'Dane transakcji zostały zaktualizowane.');
    }

    public function create()
    {
        $appointments = Appointment::with(['doctor.user', 'patient.user'])->get();

        return view('admin.transaction-form', compact('appointments'));
    }
    public function store(StoreTransactionRequest $request)
    {
        $validated = $request->validated();

        Transaction::create([
            'appointment_id' => $validated['appointment_id'],
            'amount' => $validated['amount'],
            'status' => $validated['status'],
            'payment_date' => $validated['payment_date'] ?? null,
        ]);

        return redirect()
            ->route('admin.dashboard', ['tab' => 'transactions'])
            ->with('success', 'Transakcja została dodana.');
    }
}
