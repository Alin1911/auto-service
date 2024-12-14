<?php

use App\Http\Middleware\CheckUserIsActive;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');

Route::middleware(['auth', CheckUserIsActive::class])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/service/appointments', [ServiceController::class, 'appointments'])->name('service.appointments');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::post('/users/{id}/permissions', [UserController::class, 'updatePermissions'])->name('users.updatePermissions');
    Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
});

require __DIR__ . '/auth.php';
