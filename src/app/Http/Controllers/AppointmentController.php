<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    use AuthorizesRequests;

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

        $user = auth()->user();
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

        $services = Service::all();
        return view('appointments.show', compact('appointment', 'services'));
    }

    public function create()
    {
        $services = Service::all();

        if(auth()->check()){
            return view('appointments.create_auth')->with('services', $services);

        }
        return view('appointments.create')->with('services', $services);
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        $this->authorize('update', $appointment);
        return view('appointments.show', compact('appointment'));
    }

    public function index()
    {
        $user = auth()->user();
        $appointments = Appointment::where('user_id', $user->id)->get();
        return view('appointments.index', compact('appointments'));
    }

    public function edit($id, Request $request)
    {
        $appointment = Appointment::findOrFail($id);
        $this->authorize('update', $appointment);
        $services = Service::all();
        $fromService = $request->get('from_service', false);
        return view('appointments.edit', compact('appointment', 'services', 'fromService'));
    }

    public function destroy($id, Request $request)
    {
        $appointment = Appointment::findOrFail($id);
        $this->authorize('update', $appointment);
        $appointment->delete();
        if($request->has('from_service')){
            return redirect()->route('service.appointments')->with('success', 'Appointment deleted successfully!');
        }
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully!');
    }

    public function update($id, Request $request)
    {
        $appointment = Appointment::findOrFail($id);
        $this->authorize('update', $appointment);
    
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'appointment_type' => 'required|string',
            'appointment_time' => 'required|date',
            'status' => 'required|in:registered,processed,completed',
        ]);
    
        $appointment->service_id = $request->service_id;
        $appointment->vehicle_id = $request->vehicle_id;
        $appointment->appointment_type = $request->appointment_type;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->status = $request->status;
        $appointment->observations = $request->observations;
    
        if (!$appointment->vehicle_id && $request->has('brand')) {
            $vehicle = Vehicle::create([
                'user_id' => auth()->id(),
                'brand' => $request->brand,
                'model' => $request->model,
                'chassis_series' => $request->chassis_series,
                'manufacture_year' => $request->manufacture_year,
                'engine' => $request->engine,
            ]);
            $appointment->vehicle_id = $vehicle->id;
        }
    
        $appointment->save();
        if($request->has('from_service')){
            return redirect()->route('service.appointments')->with('success', 'Programarea a fost actualizată cu succes!');
        }
    
        return redirect()->route('appointments.index')->with('success', 'Programarea a fost actualizată cu succes!');
    }
    
}
