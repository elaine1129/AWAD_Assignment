<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $appends = ['time', 'date', 'datecalendar'];
    protected $guarded = ['id'];

    // attributes
    public function getTimeslotIndex()
    {
        return $this->timeslot;
    }

    public function getTimeAttribute()
    {
        // return ($this->schedule_id != null && $this->timeslot != null && $this->schedule != null) ? Carbon::parse($this->schedule->getTime($this->timeslot))->format(config('clinic.time_format')) : '-';
        return Carbon::parse($this->schedule->getTime($this->timeslot))->format(config('clinic.time_format')) ?? '-';
    }

    public function getDateAttribute()
    {
        return $this->schedule_id ? Carbon::createFromFormat('d/m/Y', Schedule::find($this->schedule_id)->date)->format(config('clinic.date_format')) : '-';
    }

    public function getDatecalendarAttribute()
    {
        return $this->schedule_id ? Carbon::createFromFormat('d/m/Y', Schedule::find($this->schedule_id)->date)->format('Y-m-d') : '-';
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
        return $this->hasOne(Schedule::class,  'id', 'schedule_id');
    }

    public function patient_records()
    {
        return $this->hasMany(PatientRecord::class, 'appointment_id', 'id');
    }
}
