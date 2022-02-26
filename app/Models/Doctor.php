<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use function Symfony\Component\Translation\t;

class Doctor extends User
{
    protected $table = 'users';

    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        $user = parent::resolveRouteBindingQuery($query, $value, $field);
        if(!$user->first()->getModel()->isDoctor()) abort('404');
        return $user;
    }

    // permission implementation v1 START
    public function permissions()
    {
        switch ($this->role) {
            case self::ADMIN:
                return ['admin.view'];
                break;
            case self::DOCTOR:
                return ['doctor.view'];
                break;
            case self::PATIENT:
                return ['patient.view'];
                break;
        }
        return [];
    }

    public function hasPermission($permit)
    {
        return in_array($this->permissions(), $permit);
    }
    // use in blade template @if ($admin->hasPermission('admin.index')) //@endif

    // permission implementation END

    //attributes START

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'doctor_id', 'id');
    }

    public function appointments()
    {
        return parent::doctorAndPatient(Appointment::class);
    }
    //attributes END

    // functions START
    // return all schedule that are not yet full
    public function schedulesAvailable()
    {
        if($this->isDoctor()){
            return $this->schedules->filter(function ($sc){
                return $sc->available;
            });
//            $schedules = $this->schedules;
//            $data = [];
//            foreach ($schedules as $i=>$schedule){
//                if($schedule->available)
//                    $data[$i] = $schedule;
//            }
//            return $data;
        }
    }
}
