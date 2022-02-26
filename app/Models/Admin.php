<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use function Symfony\Component\Translation\t;

class Admin extends User
{
    protected $table = 'users';

    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        $user = parent::resolveRouteBindingQuery($query, $value, $field);
        if(!$user->first()->getModel()->isAdmin()) abort('404');
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

    // functions START
    public function viewAllUser()
    {
        return User::all();
    }

    public function viewPatientAndDoctor(){
        return User::query()->where('role',  self::DOCTOR)->orWhere('role',self::DOCTOR)->get();
    }

    public function viewAllDoctor()
    {
        return User::query()->whereRole(self::DOCTOR)->get();
    }

    public function viewAllPatient()
    {
        return User::query()->whereRole(self::PATIENT)->get();
    }

    public function viewAllAppointments()
    {
        return Appointment::all();
    }


}
