<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class DashboardContoller
{
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
}
