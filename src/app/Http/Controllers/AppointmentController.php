<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'appointment_type' => 'required|string',
            'cost' => 'required|numeric',
            'appointment_time' => 'required|date',
            'status' => 'required|in:registered,processed,completed',
        ]);

        $appointment = Appointment::create([
            'service_id' => $request->service_id,
            'user_id' => auth()->id(),
            'vehicle_id' => $request->vehicle_id,
            'appointment_type' => $request->appointment_type,
            'cost' => $request->cost,
            'observations' => $request->observations,
            'appointment_time' => $request->appointment_time,
            'status' => 'registered',
        ]);

        return redirect()->route('appointments.index')->with('success', 'Programarea a fost înregistrată!');
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }
}
