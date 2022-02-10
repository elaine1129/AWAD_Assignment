<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const DOCTOR = 'DOCTOR';
    const PATIENT = 'PATIENT';
    const ADMIN = 'ADMIN';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'data',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'data' => 'array'
    ];

//    public function setDataAttribute(array $value){
//        $this->attributes['data']=json_encode($value);
//    }

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

    public function isDoctor()
    {
        return $this->role === self::DOCTOR;
    }

    public function isPatient()
    {
        return $this->role === self::PATIENT;
    }

    public function schedules()
    {
        if ($this->isDoctor())
            return $this->hasMany(Schedule::class, 'doctor_id', 'id');
        return null;
    }

    public function patient_record()
    {
//        if($this->isDoctor())
//            return $this->hasMany(PatientRecord::class, 'doctor_id', 'id');
//        if($this->isPatient())
//            return $this->hasMany(PatientRecord::class, 'patient_id', 'id');
//        return null;
        return $this->doctorAndPatient(PatientRecord::class);
    }

    public function appointment()
    {
//        if($this->isDoctor())
//            return $this->hasMany(Appointment::class, 'doctor_id', 'id');
//        if($this->isPatient())
//            return $this->hasMany(Appointment::class, 'patient_id', 'id');
//        return null;
        return $this->doctorAndPatient(Appointment::class);
    }

    public function availableSchedule()
    {
        if($this->isDoctor()){
            return $this->schedules()->get()->filter(function ($schedule){
                return $schedule->isStillAvailable() || true;
            });
        }
    }

    private function doctorAndPatient($modelToBeLink){
        if($this->isDoctor())
            return $this->hasMany($modelToBeLink, 'doctor_id', 'id');
        if($this->isPatient())
            return $this->hasMany($modelToBeLink, 'patient_id', 'id');
        return null;
    }
}
