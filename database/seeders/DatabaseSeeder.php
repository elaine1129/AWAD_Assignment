<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\PatientRecord;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Schedule::truncate();
        Appointment::truncate();
        PatientRecord::truncate();

        // set each number you wish to create
        User::factory(15)->create();
        Schedule::factory(5)->create();
        Appointment::factory(20)->create();
        PatientRecord::factory(10)->create();
    }
}
