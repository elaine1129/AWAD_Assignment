<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use function Symfony\Component\Translation\t;

class Patient extends User
{
    protected $table = 'users';

    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        $user = parent::resolveRouteBindingQuery($query, $value, $field);
        if ( !$user->exists() || !$user->first()->getModel()->isPatient())
            abort('404');
        return $user;
    }

    public function getDoneAppointment()
    {
        try {
            return $this->appointments->toQuery()->whereStatus('DONE')->latest()->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getPendingAppointment()
    {
        try {
            return $this->appointments->toQuery()->whereStatus('PENDING')->latest()->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getApprovedAppointment()
    {
        try {
            return $this->appointments->toQuery()->whereStatus('APPROVED')->latest()->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function patient_records()
    {
        return $this->doctorAndPatient(PatientRecord::class);
    }

    public function appointments()
    {
        return $this->doctorAndPatient(Appointment::class);
    }
}
