<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = ['slots'=> 'array'];
    protected $appends = ['available'];

    const TIMESLOT_STRINGS = [
        '9:00am','9:30am','10:00am','10:30am','11:00am','11:30am',
        '12:00pm','12:30pm','1:00pm','1:30pm','2:00pm','2:30pm',
        '3:00pm','3:30pm','4:00pm','4:30pm'
    ];

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
        $date = Carbon::create($this->date);
        return $date->greaterThan(Carbon::now()) && in_array(1,$this->slots);
    }
}
