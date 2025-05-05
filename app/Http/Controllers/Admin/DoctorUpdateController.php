<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorUpdateController
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $doctor = Doctor::findOrFail($id);
        $doctor->user->update($request->only(['first_name', 'last_name', 'email']));

        return redirect()->route('admin.dashboard', ['tab' => 'doctors'])->with('success', 'Dane lekarza zostały zaktualizowane.');
    }
}
