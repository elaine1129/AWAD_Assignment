<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = ['slots' => 'array'];
    protected $appends = ['available'];

    const TIMESLOT_STRINGS = [
        '9:00am', '9:30am', '10:00am', '10:30am', '11:00am', '11:30am',
        '12:00pm', '12:30pm', '1:00pm', '1:30pm', '2:00pm', '2:30pm',
        '3:00pm', '3:30pm', '4:00pm', '4:30pm'
    ];

    public function setTimeslot($newTimeslot)
    {
        $temp = $this['slots'];
        $temp[$newTimeslot] = 0;
        $this['slots'] = $temp;
    }

    public function revertTimeslot($oldTimeslot)
    {
        $temp = $this['slots'];
        $temp[$oldTimeslot] = 1;
        $this['slots'] = $temp;
    }

    public static function checkIfScheduleExists($date, $doctor_id)
    {
        return Schedule::whereDoctorId($doctor_id)->whereDate('date', '==', $date)->first();
    }

    public function isSlotAvailable($index)
    {
        $availableTimeslot = $this->getAvailableTimeslot();
        if (is_numeric($index))
            return $availableTimeslot[$index] == 1;

        $index = array_search($index, self::TIMESLOT_STRINGS);
        return $availableTimeslot[$index] == 1;
    }

    public function isPendingAppointmentExist($slotIndex)
    {
        $pendingAppointment = $this->getPendingAppointments($slotIndex);
        if ($pendingAppointment->isEmpty())
            return false;
        return true;
    }

    public function getPendingAppointments($slotIndex)
    {
        return Appointment::whereScheduleId($this->id)->whereStatus('PENDING')->whereTimeslot($slotIndex)->get();
    }


    // timeslots without pending appointment and also approved appointment
    public function getAvailableTimeslot()
    {
        $availSlots = [];
        foreach ($this->slots as $index => $slot) {
            if ($slot == 0)
                array_push($availSlots, 0);
            elseif ($this->isPendingAppointmentExist($index))
                array_push($availSlots, 0);
            else
                array_push($availSlots, 1);
        }
        return $availSlots;
    }

    public function getDateAttribute($date)
    {
        return Carbon::parse($date)->format(config('clinic.date_format'));
    }

    public function getTime($timeIndex)
    {
        return self::TIMESLOT_STRINGS[$timeIndex];
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function getAvailableAttribute()
    {
        $date = Carbon::createFromFormat('d/m/Y', $this->date);
        return $date->greaterThan(Carbon::now()) && in_array(1, $this->slots);
    }
}
