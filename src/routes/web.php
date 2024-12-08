<?php

use App\Http\Middleware\CheckUserIsActive;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::view('/', 'welcome');
Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');

Route::middleware(['auth', CheckUserIsActive::class])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::delete('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});

require __DIR__ . '/auth.php';
