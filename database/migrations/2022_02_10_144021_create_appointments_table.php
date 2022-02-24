<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(\App\Models\User::class, 'patient_id');
            $table->foreignIdFor(\App\Models\User::class, 'doctor_id');
            $table->foreignIdFor(\App\Models\Schedule::class, 'schedule_id');
            $table->longText('condition');
            $table->smallInteger('timeslot')->nullable();
            $table->enum('status',['PENDING','CANCELLED','DONE','APPROVED']);
//            $table->timestamp('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
