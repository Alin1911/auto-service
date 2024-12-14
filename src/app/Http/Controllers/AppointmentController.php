<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    use AuthorizesRequests;

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
