<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
//        select random schedule
        $scheduleId = null;
        while (true) {
//            $doctorIds = User::query()->where('role', '=', 'DOCTOR')->pluck('id')->toArray();
//            $patientIds = User::query()->where('role', '=', 'PATIENT')->pluck('id')->toArray();
            $doctorIds = User::query()->whereRole('DOCTOR')->pluck('id')->toArray();
            $patientIds = User::query()->whereRole('PATIENT')->pluck('id')->toArray();
            $doctorId = $this->faker->randomElement($doctorIds);
            $patientId = $this->faker->randomElement($patientIds);
            $doctor = User::find($doctorId);
            $schedules = $doctor->schedulesAvailable();
//        $scheduleId = $this->faker->randomElement(Schedule::query()->where('doctor_id', '=',$doctorId)->pluck('id')->toArray());
            $scheduleId = $this->faker->randomElement(Arr::pluck($schedules->toArray(), 'id'));
            $schedule = Schedule::find($scheduleId);
            if ($schedule == null) continue;
            $slots = $schedule->slots;
            break;
        }
        $i = 0;

//        select time slot from schedule
        while (true) {
            if ($slots[$i] == 1) {
                $slots[$i] = 0;
                break;
            }
            $i++;
        }
        $schedule->slots = $slots;
        $schedule->update();
        return [
            'patient_id' => $patientId,
            'doctor_id' => $doctorId,
            'schedule_id' => $scheduleId,
            'condition' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['PENDING', 'CANCELLED', 'DONE', 'APPROVED']),
        ];
    }
}
