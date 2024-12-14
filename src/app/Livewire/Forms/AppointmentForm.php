<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\User;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentForm extends Component
{
    public $name;
    public $email;
    public $phone;
    public $service_id;
    public $vehicle_id;
    public $brand;
    public $model;
    public $chassis_series;
    public $manufacture_year;
    public $engine;
    public $appointment_type;
    public $appointment_time;
    public $observations;
    public $userVehicles = [];
    public $appointmentConfirmed = false;

    public function mount()
    {
        if (auth()->check()) {
            $this->userVehicles = auth()->user()->vehicles;
            $this->email = auth()->user()->email;
            $this->phone = auth()->user()->phone;
            $this->name = auth()->user()->name;
        }
    }

    public function submit()
    {
        if (is_null($this->vehicle_id)) {
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'service_id' => 'required|exists:services,id',
                'vehicle_id' => 'nullable|exists:vehicles,id',
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'chassis_series' => 'required|string|max:255',
                'manufacture_year' => 'required|numeric|digits:4',
                'engine' => 'required|string|max:255',
                'appointment_type' => 'required|in:ITP,Reparații',
                'appointment_time' => 'required|date|after:now',
                'observations' => 'nullable|string|max:500',
            ]);
        } else {
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'service_id' => 'required|exists:services,id',
                'vehicle_id' => 'nullable|exists:vehicles,id',
                'appointment_type' => 'required|in:ITP,Reparații',
                'appointment_time' => 'required|date|after:now',
                'observations' => 'nullable|string|max:500',
            ]);
        }

        $appointmentTime = Carbon::parse($this->appointment_time);
        $startTime = $appointmentTime->copy()->subMinutes(30);
        $endTime = $appointmentTime->copy()->addMinutes(30);

        $existingAppointment = Appointment::where('service_id', $this->service_id)
            ->whereBetween('appointment_time', [$startTime, $endTime])
            ->exists();

        if ($existingAppointment) {
            session()->flash('error', 'Există deja o programare la acest serviciu în intervalul de timp ales!');
            return;
        }

        $user = auth()->user();
        if (empty($user)) {
            $user = new User();
            $user->name = $this->name;
            $user->email = microtime() . '_' . $this->email;
            $user->phone = $this->phone;
            $user->password = rand(20, 23);
            $user->save();
        }
        $user->phone = $this->phone;
        $user->save();

        if (!$this->vehicle_id) {
            $vehicle = Vehicle::where('chassis_series', $this->chassis_series)->first();
            if (empty($vehicle)) {
                $vehicle = Vehicle::create([
                    'user_id' => $user->id,
                    'brand' => $this->brand,
                    'model' => $this->model,
                    'chassis_series' => $this->chassis_series,
                    'manufacture_year' => $this->manufacture_year,
                    'engine' => $this->engine,
                ]);
            }
            $this->vehicle_id = $vehicle->id;
        }

        $service = Service::find($this->service_id);
        Appointment::create([
            'user_id' => $user->id,
            'service_id' => $this->service_id,
            'vehicle_id' => $this->vehicle_id,
            'cost' => $service->cost,
            'appointment_type' => $this->appointment_type,
            'appointment_time' => $appointmentTime->format('Y-m-d H:i:s'),
            'observations' => $this->observations,
        ]);

        $this->appointmentConfirmed = true;

        session()->flash('message', 'Programarea a fost confirmată!');
    }



    public function render()
    {
        $services = Service::all();
        return view('livewire.appointment-form', compact('services'));
    }
}
