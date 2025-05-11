<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DashboardContoller;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TransactionController;
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
    Route::get('/admin/patients/create', [PatientController::class, 'create'])->name('admin.patients.create');
    Route::post('/admin/patients', [PatientController::class, 'store'])->name('admin.patients.store');

    Route::delete('/admin/patients/{id}', [PatientController::class, 'destroyPatient'])->name('admin.patients.destroy');

    Route::get('/admin/patients/{id}/edit', [PatientController::class, 'editPatient'])->name('admin.patients.edit');

    Route::put('/admin/patients/{id}', [PatientController::class, 'update'])->name('admin.patients.update');

    // Doctor CRUD routes
    Route::get('/admin/doctors/create', [DoctorController::class, 'create'])->name('admin.doctors.create');

    Route::post('/admin/doctors', [DoctorController::class, 'store'])->name('admin.doctors.store');

    Route::delete('/admin/doctors/{id}', [DoctorController::class, 'destroyDoctor'])->name('admin.doctors.destroy');

    Route::get('/admin/doctors/{id}/edit', [DoctorController::class, 'editDoctor'])->name('admin.doctors.edit');

    Route::put('/admin/doctors/{id}', [DoctorController::class, 'update'])->name('admin.doctors.update');

    // Appointment CRUD routes
    Route::get('/admin/appointments/create', [AppointmentController::class, 'create'])->name('admin.appointments.create');

    Route::post('/admin/appointments', [AppointmentController::class, 'store'])->name('admin.appointments.store');

    Route::delete('/admin/appointments/{id}', [AppointmentController::class, 'destroyAppointment'])->name('admin.appointments.destroy');

    Route::get('/admin/appointments/{id}/edit', [AppointmentController::class, 'editAppointment'])->name('admin.appointments.edit');

    Route::put('/admin/appointments/{id}', [AppointmentController::class, 'update'])->name('admin.appointments.update');

    // Review CRUD routes
    Route::get('/admin/reviews/create', [ReviewController::class, 'create'])->name('admin.reviews.create');

    Route::post('/admin/reviews', [ReviewController::class, 'store'])->name('admin.reviews.store');

    Route::delete('/admin/reviews/{id}', [ReviewController::class, 'destroyReview'])->name('admin.reviews.destroy');

    Route::get('/admin/reviews/{id}/edit', [ReviewController::class, 'editReview'])->name('admin.reviews.edit');

    Route::put('/admin/reviews/{id}', [ReviewController::class, 'update'])->name('admin.reviews.update');

    // Transaction CRUD routes
    Route::get('/admin/transactions/create', [TransactionController::class, 'create'])->name('admin.transactions.create');

    Route::post('/admin/transactions', [TransactionController::class, 'store'])->name('admin.transactions.store');

    Route::delete('/admin/transactions/{id}', [TransactionController::class, 'destroyTransaction'])->name('admin.transactions.destroy');

    Route::get('/admin/transactions/{id}/edit', [TransactionController::class, 'editTransatcion'])->name('admin.transactions.edit');

    Route::put('/admin/transactions/{id}', [TransactionController::class, 'update'])->name('admin.transactions.update');
});

// Routes for the doctor
