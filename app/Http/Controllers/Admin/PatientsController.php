<?php

namespace App\Http\Controllers\Admin;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientsController
{
    public function index()
    {
        $patients = Patient::all();
        return view('partials.admin-dashboard', compact('patients'));
    }
}
