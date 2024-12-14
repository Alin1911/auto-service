<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'chassis_series' => 'required|string|max:255',
            'manufacture_year' => 'required|numeric|digits:4',
            'engine' => 'required|string|max:255',
            'appointment_type' => 'required|in:ITP,Reparații',
            'appointment_time' => 'required|date|after:now',
            'observations' => 'nullable|string|max:500',
        ]);

        $appointmentTime = Carbon::parse($request->appointment_time);
        $startTime = $appointmentTime->copy()->subMinutes(30);
        $endTime = $appointmentTime->copy()->addMinutes(30);

        $existingAppointment = Appointment::where('service_id', $request->service_id)
            ->whereBetween('appointment_time', [$startTime, $endTime])
            ->exists();

        if ($existingAppointment) {
            return response()->json(['error' => 'Există deja o programare la acest serviciu în intervalul de timp ales!'], 400);
        }

        $user = Auth::user();
        if (empty($user)) {
            $user = new User();
            $user->name = $request->name;
            $user->email = microtime() . '_' . $request->email;
            $user->phone = $request->phone;
            $user->password = rand(20, 23);
            $user->save();
        }

        if (!$request->vehicle_id) {
            $vehicle = Vehicle::where('chassis_series', $request->chassis_series)->first();
            if (empty($vehicle)) {
                $vehicle = Vehicle::create([
                    'user_id' => $user->id,
                    'brand' => $request->brand,
                    'model' => $request->model,
                    'chassis_series' => $request->chassis_series,
                    'manufacture_year' => $request->manufacture_year,
                    'engine' => $request->engine,
                ]);
            }
            $vehicleId = $vehicle->id;
        } else {
            $vehicleId = $request->vehicle_id;
        }

        $service = Service::find($request->service_id);
        $appointment = Appointment::create([
            'user_id' => $user->id,
            'service_id' => $request->service_id,
            'vehicle_id' => $vehicleId,
            'cost' => $service->cost,
            'appointment_type' => $request->appointment_type,
            'appointment_time' => $appointmentTime->format('Y-m-d H:i:s'),
            'observations' => $request->observations,
            'status' => 'registered',
        ]);

        return response()->json($appointment, 201);
    }
}
