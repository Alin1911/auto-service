<?php

use App\Http\Middleware\CheckUserIsActive;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ServiceController;


Route::view('/', 'welcome');
Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');

Route::middleware(['auth', CheckUserIsActive::class])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::delete('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::resource('appointments', AppointmentController::class);
    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
});

require __DIR__ . '/auth.php';
