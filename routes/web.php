<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PatientProfileCompletion;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/unauthorized', function () {
    return view('auth.unauthorized');
})->name('unauthorized');

Route::middleware(['auth', 'role:patient'])->group(function () {
    // Get the patient profile completion form
    Route::get('/patient/complete-profile', [PatientProfileCompletion::class, 'show'])->name('patient.complete-profile');
    // Post the patient profile completion form
    // This is the form that the patient fills out to complete their profile
    Route::post('/patient/complete-profile', [PatientProfileCompletion::class, 'update'])->name('patient.complete-profile.update');
    Route::get('/patient', function () {
        return view('dashboard');
    })->name('patient.dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('dashboard');
    })->name('admin.dashboard');
});
