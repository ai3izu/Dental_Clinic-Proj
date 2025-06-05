<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DashboardContoller;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Doctor\DoctorProfileUpdateController;
use App\Http\Controllers\Patient\AppointmentReservationController;
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\Patient\PatientReviewController;
use App\Http\Controllers\Public\DoctorListController;
use App\Http\Controllers\Patient\ProfileCompletion;
use App\Http\Controllers\Public\DoctorPageController;
use Illuminate\Support\Facades\Route;


// platnosci, limity przy migracjach, dokumentacja, start bat, uproszczenie seederow


// Routing ogólnodostępny
Route::get('/', function () {
    return view('landing');
})->name('landing');

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
Route::get('/doctors/{doctor}', [DoctorPageController::class, 'index'])->name('doctors.show');


// Routing dla pacjenta
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/complete-profile', [ProfileCompletion::class, 'show'])->name('patient.complete-profile');
    Route::post('/patient/complete-profile', [ProfileCompletion::class, 'update'])->name('patient.complete-profile.update');
    Route::get('/patient', [PatientDashboardController::class, 'index'])->name('patient.dashboard');

    // Appointmens
    Route::get('/appoitment/book/{doctor}', [AppointmentReservationController::class, 'create'])->name('patient.appoitment.create');
    Route::post('/appoitment/book', [AppointmentReservationController::class, 'store'])->name('patient.appoitment.store');
    Route::post('/appointment/{appointment}/pay', [PatientDashboardController::class, 'pay'])->name('patient.appointment.pay');
    Route::post('/appointment/{appointment}/cancel', [PatientDashboardController::class, 'cancel'])->name('patient.appointment.cancel');

    Route::get('/patient/appointments/available-slots', [AppointmentReservationController::class, 'getAvailableSlots'])->name('patient.appointments.available_slots');

    Route::post('/doctors/{doctor}/reviews', [PatientReviewController::class, 'storePublic'])->name('doctors.reviews.store');
});

// Routing dla administratora
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardContoller::class, 'index'])->name('dashboard');

    Route::resource('patients', PatientController::class)->except(['show']);
    Route::resource('doctors', DoctorController::class)->except(['show']);
    Route::resource('appointments', AppointmentController::class)->except(['show']);
    Route::get('/appointments/available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('appointments.available_slots');

    Route::resource('reviews', ReviewController::class)->except(['show']);
    Route::resource('transactions', TransactionController::class)->except(['show']);
});

// Routing dla dentysty
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    // dashboard
    Route::get('/dashboard', [DoctorDashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/appointments/available-slots', [DoctorDashboardController::class, 'getAvailableSlots'])->name('appointments.available_slots');

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


    // profile edit
    Route::get('/profile/edit', [DoctorProfileUpdateController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [DoctorProfileUpdateController::class, 'update'])->name('profile.update');
});
