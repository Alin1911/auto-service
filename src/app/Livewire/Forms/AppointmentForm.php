<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Service;
use App\Models\Vehicle;
use App\Models\Appointment;

class AppointmentForm extends Component
{
    public $services;
    public $appointment_type;
    public $vehicle_id;
    public $service_id;
    public $cost;
    public $appointment_time;
    public $observations;

    public function mount()
    {
        $this->services = Service::all();
    }

    public function updatedAppointmentType()
    {
        if ($this->appointment_type == 'ITP') {
            $this->cost = 150;
        }
    }

    public function submit()
    {
        $this->validate([
            'service_id' => 'required',
            'appointment_time' => 'required|date',
            'appointment_type' => 'required|string',
        ]);

        Appointment::create([
            'service_id' => $this->service_id,
            'vehicle_id' => $this->vehicle_id,
            'appointment_type' => $this->appointment_type,
            'cost' => $this->cost,
            'appointment_time' => $this->appointment_time,
            'observations' => $this->observations,
            'status' => 'registered',
            'user_id' => auth()->id(),
        ]);

        session()->flash('message', 'Programare înregistrată cu succes!');
    }

    public function render()
    {
        return view('livewire.appointment-form');
    }
}
