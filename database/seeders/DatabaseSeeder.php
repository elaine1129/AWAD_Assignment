<?php

namespace Database\Seeders;

use App\Models\Appointment;
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
//        Model::unguard();
        User::truncate();
        Schedule::truncate();
        Appointment::truncate();
         \App\Models\User::factory(10)->create();
         Schedule::factory(50)->create();
         Appointment::factory(10)->create();
//        Model::reguard();
    }
}
