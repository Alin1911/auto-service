<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\VehicleController;

Route::post('/appointments', [AppointmentController::class, 'store']);

Route::middleware('auth:api')->group(function () {
    Route::get('/service/appointments', [ServiceController::class, 'index']);
});
