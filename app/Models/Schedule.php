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
