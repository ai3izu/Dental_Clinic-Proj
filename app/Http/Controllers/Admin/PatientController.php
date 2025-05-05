<?php

namespace App\Http\Controllers\Admin;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController
{
    // display the data 
    public function index(){
        $patients = Patient::with('user')->paginate(20);
        return view('dashboard', compact('patients'));
    }
}
