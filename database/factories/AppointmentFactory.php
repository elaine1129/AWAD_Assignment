<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $doctorIds = User::query()->where('role','=', 'DOCTOR')->pluck('id')->toArray();
        $patientIds = User::query()->where('role','=', 'PATIENT')->pluck('id')->toArray();
        $doctorId = $this->faker->randomElement($doctorIds);
        $patientId = $this->faker->randomElement($patientIds);
//        $doctor = User::find($doctorId);
        $scheduleId = $this->faker->randomElement(Schedule::query()->where('doctor_id', '=',$doctorId)->pluck('id')->toArray());
        $schedule = Schedule::find($scheduleId);
        $slots = $schedule->slots;
        $i = 0;
        while(true){
            if($slots[$i] == 1){
                $slots[$i] = 0;
                break;
            }
            $i++;
        }
        $schedule->slots = $slots;
        $schedule->update();
        return [
            'patient_id'=>$patientId,
            'doctor_id'=>$doctorId,
            'schedule_id'=>$scheduleId,
            'condition'=>$this->faker->paragraph,
            'status'=>$this->faker->randomElement(['PENDING','CANCELLED','DONE','APPROVED']),
        ];
    }
}
