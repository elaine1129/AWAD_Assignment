<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $appends = ['time','date'];

    public function getTimeAttribute()
    {
        return ($this->schedule_id != null && $this->timeslot != null && $this->schedule != null) ? Carbon::parse($this->schedule->getTime($this->timeslot))->format(config('clinic.time_format')) : null;
    }

    public function getDateAttribute()
    {
        return $this->schedule_id ? Carbon::parse(Schedule::find($this->schedule_id)->date)->format(config('clinic.date_format')) : null;
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class,  'id','schedule_id');
    }

    public function patient_records()
    {
        return $this->hasMany(PatientRecord::class, 'appointment_id', 'id');
    }
}
