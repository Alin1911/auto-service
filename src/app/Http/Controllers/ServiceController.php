<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    public function appointments(){
        $user = auth()->user();
        if(!$user->service_id){
            abort(401);
        }
        $appointments = Appointment::where('service_id', $user->service_id)->get();
        return view('services.appointments', compact('appointments'));
    }
}
