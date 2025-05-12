<?php

namespace App\Http\Controllers\Public;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorListController
{
    public function index()
    {
        $doctors = Doctor::with('user')->paginate(12);
        return view('public.doctors', compact('doctors'));
    }
}
