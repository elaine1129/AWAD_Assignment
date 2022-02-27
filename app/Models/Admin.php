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
