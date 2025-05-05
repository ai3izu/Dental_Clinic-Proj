<?php

use App\Http\Controllers\Admin\DashboardContoller;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\DoctorUpdateController;
use App\Http\Controllers\Admin\PatientController;
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
    // Get the patient profile completion form
    Route::get('/patient/complete-profile', [ProfileCompletion::class, 'show'])->name('patient.complete-profile');
    // Post the patient profile completion form
    // This is the form that the patient fills out to complete their profile
    Route::post('/patient/complete-profile', [ProfileCompletion::class, 'update'])->name('patient.complete-profile.update');
    Route::get('/patient', function () {
        return view('dashboard');
    })->name('patient.dashboard');
});

// Routes for the admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [DashboardContoller::class, 'index'])->name('admin.dashboard');


    Route::delete('/admin/patients/{id}', [DashboardContoller::class, 'destroyPatient'])->name('admin.patient.destroy');

    Route::delete('/admin/doctors/{id}', [DashboardContoller::class, 'destroyDoctor'])->name('admin.doctors.destroy');

    // Patient update
    Route::get('/admin/patients/{id}/edit', [DashboardContoller::class, 'editPatient'])->name('admin.patients.edit');
    Route::put('/admin/patients/{id}', [PatientUpdateController::class, 'update'])->name('admin.patients.update');

    // Doctor update route
    Route::get('/admin/doctors/{id}/edit', [DashboardContoller::class, 'editDoctor'])->name('admin.doctors.edit');
    Route::put('/admin/doctors/{id}', [DoctorUpdateController::class, 'update'])->name('admin.doctors.update');
});
// Routes for the doctor
