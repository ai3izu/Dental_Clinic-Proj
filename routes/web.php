<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.post');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register.post');
Route::post('/logout', [App\Http\Controllers\LogoutController::class, 'logout'])->name('logout');

Route::get('/unauthorized', function () {
    return view('auth.unauthorized');
})->name('unauthorized');


Route::middleware(['auth', 'role:patient']) ->group(function () {
    Route::get('/patient', function () {
        return view('patient.dashboard');
    })->name('patient.dashboard');
});

Route::middleware(['auth', 'role:admin']) ->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});