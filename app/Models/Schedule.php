<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = ['slots'=> 'array'];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function isStillAvailable(){
        return in_array(1,$this->slots);
    }
}
