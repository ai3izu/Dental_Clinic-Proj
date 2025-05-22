<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DashboardContoller;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Patient\AppointmentReservationController;
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\Public\DoctorListController;
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

Route::get('/doctors', [DoctorListController::class, 'index'])->name('doctors.public');


// Routes for the patient
Route::middleware(['auth', 'role:patient'])->group(function () {

    Route::get('/patient/complete-profile', [ProfileCompletion::class, 'show'])->name('patient.complete-profile');

    Route::post('/patient/complete-profile', [ProfileCompletion::class, 'update'])->name('patient.complete-profile.update');

    Route::get('/patient', [PatientDashboardController::class, 'index'])->name('patient.dashboard');

    // Appointmens
    Route::get('/appoitment/book/{doctor}', [AppointmentReservationController::class, 'create'])->name('patient.appoitment.create');
    Route::post('/appoitment/book', [AppointmentReservationController::class, 'store'])->name('patient.appoitment.store');
    Route::post('/appointment/{appointment}/pay', [PatientDashboardController::class, 'pay'])->name('patient.appointment.pay');
    Route::post('/appointment/{appointment}/cancel', [PatientDashboardController::class, 'cancel'])->name('patient.appointment.cancel');
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
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {

    // dashboard
    Route::get('/dashboard', [DoctorDashboardController::class, 'dashboard'])->name('dashboard');

    // confirm appointpent
    Route::post('/appointment/{appointment}/confirm', [DoctorDashboardController::class, 'confirmAppointment'])->name('appointment.confirm');

    // cancel appoinpent
    Route::post('/appointment/{appointment}/cancel', [DoctorDashboardController::class, 'cancelAppointment'])->name('appointment.cancel');

    // restore appointment
    Route::post('/appointment/{appointment}/restore', [DoctorDashboardController::class, 'restoreAppointment'])->name('appointment.restore');

    // appointment date change
    Route::post('/appointment/{appointment}/reschedule', [DoctorDashboardController::class, 'rescheduleAppointment'])->name('appointment.reschedule');

    // notes for appointment
    Route::get('/notes/{appointment}', [DoctorDashboardController::class, 'showNotesForm'])->name('notes.form');
    Route::post('/appointments/{appointment}/notes', [DoctorDashboardController::class, 'addNotes'])->name('appointments.notes');
});
