<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Appointment;

class AppointmentPolicy
{
    /**
     * Determină dacă un utilizator poate modifica o programare.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Appointment  $appointment
     * @return bool
     */
    public function update(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->user_id || 
               ($user->hasPermissionTo('manage_appointments') && $user->service_id === $appointment->service_id);
    }
}
