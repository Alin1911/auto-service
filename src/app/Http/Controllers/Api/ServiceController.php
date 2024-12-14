<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->service_id) {
            return response()->json(['error' => 'Autentificare eșuată sau utilizatorul nu aparține unui service.'], 403);
        }

        $appointments = Appointment::where('service_id', $user->service_id)
            ->with(['user', 'vehicle'])
            ->get();

        return response()->json($appointments);
    }
}
