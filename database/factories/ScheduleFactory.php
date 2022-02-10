<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $doctorIds = User::query()->where('role', 'DOCTOR')->pluck('id')->toArray();
        $date = $this->faker->dateTimeBetween('+1 days', '+2 years');
        while(true){
            $doctorId = $this->faker->randomElement($doctorIds);
            $scheduledDate = Schedule::query()->where('doctor_id',$doctorId)->pluck('date')->toArray();
            if(!in_array($date, $scheduledDate))
                break;
            $date = $this->faker->dateTimeBetween('+1 days', '+2 years');
        }
        return [
            'date'=>$date,
            'doctor_id'=>$doctorId,
            'slots'=>[1,1,1,1,1,1,1,1,1,1,1,1],
        ];
    }
}
