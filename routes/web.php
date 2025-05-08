<?php

use App\Http\Controllers\Admin\DashboardContoller;
use App\Http\Controllers\Admin\DoctorUpdateController;
use App\Http\Controllers\Admin\PatientUpdateController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Patient\ProfileCompletion;
use Illuminate\Support\Facades\Route;

// Default route
Route::get('/', function () {
    return view('landing');
})->name('landing');


// Authentication routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes for the patient
Route::middleware(['auth', 'role:patient'])->group(function () {
    // Get the patient completion form view, post the data and return exclusive view for patient
    Route::get('/patient/complete-profile', [ProfileCompletion::class, 'show'])->name('patient.complete-profile');

    Route::post('/patient/complete-profile', [ProfileCompletion::class, 'update'])->name('patient.complete-profile.update');

    Route::get('/patient', function () {
        return view('dashboard');
    })->name('patient.dashboard');
});

// Routes for the admin 
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Get and return exclusive view for admin - dashboard to manage data
    Route::get('/admin', [DashboardContoller::class, 'index'])->name('admin.dashboard');

    // Patient CRUD routes
    Route::get('/admin/patients/create', [PatientUpdateController::class, 'create'])->name('admin.patients.create');

    Route::post('admin/patients', [PatientUpdateController::class, 'store'])->name('admin.patients.store');

    Route::delete('/admin/patients/{id}', [DashboardContoller::class, 'destroyPatient'])->name('admin.patient.destroy');

    Route::get('/admin/patients/{id}/edit', [DashboardContoller::class, 'editPatient'])->name('admin.patients.edit');

    Route::put('/admin/patients/{id}', [PatientUpdateController::class, 'update'])->name('admin.patients.update');



    // Doctor CRUD routes
    Route::get('/admin/doctors/create', [DoctorUpdateController::class, 'create'])->name('admin.doctors.create');

    Route::delete('/admin/doctors/{id}', [DashboardContoller::class, 'destroyDoctor'])->name('admin.doctors.destroy');

    Route::get('/admin/doctors/{id}/edit', [DashboardContoller::class, 'editDoctor'])->name('admin.doctors.edit');

    Route::put('/admin/doctors/{id}', [DoctorUpdateController::class, 'update'])->name('admin.doctors.update');
});
// Routes for the doctor
