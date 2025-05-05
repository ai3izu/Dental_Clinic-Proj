<?php

namespace App\Http\Controllers\Admin;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientUpdateController
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'nullable|string|max:15',
        ]);

        $patient = Patient::findOrFail($id);
        $patient->user->update($request->only(['first_name', 'last_name', 'email']));
        $patient->update(['phone_number' => $request->phone_number]);

        return redirect()->route('admin.dashboard', ['tab' => 'patients'])->with('success', 'Dane pacjenta zostały zaktualizowane.');
    }
}
