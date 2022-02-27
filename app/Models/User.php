<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use function Symfony\Component\Translation\t;

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

    public function getUser()
    {
        switch ($this->role) {
            case self::ADMIN:
                return Admin::find($this->id);
                break;
            case self::DOCTOR:
                return Doctor::find($this->id);
                break;
            case self::PATIENT:
                return Patient::find($this->id);
                break;
        }
    }

    public function setDataAttribute(array $value){
        if($this->isDoctor()){
            if(!isset($value["image_url"]))
                $value["image_url"] = '/public/profile-placeholder.svg';
        }
        $this->attributes['data']=json_encode($value);
    }

    public function isDoctor()
    {
        return $this->role === self::DOCTOR;
    }

    public function isPatient()
    {
        return $this->role === self::PATIENT;
    }

    public function isAdmin()
    {
        return $this->role === self::ADMIN;
    }

    public function patient_records()
    {
//        if($this->isDoctor())
//            return $this->hasMany(PatientRecord::class, 'doctor_id', 'id');
//        if($this->isPatient())
//            return $this->hasMany(PatientRecord::class, 'patient_id', 'id');
//        return null;
        return $this->doctorAndPatient(PatientRecord::class);
    }

    protected function doctorAndPatient($modelToBeLink){
        if($this->isDoctor())
            return $this->hasMany($modelToBeLink, 'doctor_id', 'id');
        if($this->isPatient())
            return $this->hasMany($modelToBeLink, 'patient_id', 'id');
        return null;
    }
}
