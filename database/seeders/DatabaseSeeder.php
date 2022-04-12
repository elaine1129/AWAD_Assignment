<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\PatientRecord;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schedule::truncate();
        Appointment::truncate();
        PatientRecord::truncate();
        Schema::enableForeignKeyConstraints();

        // set each number you wish to create
        User::factory(15)->create();
        User::create([
            'name' => 'doctor',
            'password' => bcrypt('password'),
            'email' => 'doctor@cm.com',
            'role' => 'DOCTOR',
            'data' => [
                "expertise" => 'expertise',
                "image_url" => 'https://i.pravatar.cc/150?u=doctor',
                'name' => 'doctor',
                'ic' => '123456789',
                'email' => 'doctor email',
            ]
        ]);
        User::create([
            'name' => 'admin',
            'password' => bcrypt('password'),
            'email' => 'admin@cm.com',
            'role' => 'ADMIN',
            'data' => [
                'name' => 'admin',
                'ic' => '123456789',
                'email' => 'admin email',
            ]
        ]);
        User::create([
            'name' => 'patient',
            'password' => bcrypt('password'),
            'email' => 'patient@cm.com',
            'role' => 'PATIENT',
            'data' => [
                'name' => 'patient',
                'ic' => '123456789',
                'email' => 'patient email',
                "phone" => '012345678',
                "gender" => 'male',
                "address" => 'Jalan 123',
            ]
        ]);
//        Schedule::factory(10)->create();
        $now = Carbon::today();
        $endDate = $now->clone()->addDays(10)->endOfDay();
        collect(CarbonPeriod::create($now, $endDate)->toArray())->map(function ($eachDate) {
            User::all()->each(function ($user) use ($eachDate) {
                if ($user->isDoctor()) {
                    Schedule::create([
                        'date' => $eachDate,
                        'doctor_id' => $user->id,
                        'slots' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                    ]);
                }
            });
        });

        Appointment::factory(20)->create();
        PatientRecord::factory(15)->create();
    }
}
