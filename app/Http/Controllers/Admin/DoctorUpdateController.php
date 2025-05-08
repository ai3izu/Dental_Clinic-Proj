<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorUpdateController
{
    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        $doctor->user->update($request->only(['first_name', 'last_name', 'email']));

        return redirect()->route('admin.dashboard', ['tab' => 'doctors'])->with('success', 'Dane lekarza zostały zaktualizowane.');
    }

    public function create()
    {
        return view('admin.doctor-create');
    }

    public function store(Request $request) {}
}
