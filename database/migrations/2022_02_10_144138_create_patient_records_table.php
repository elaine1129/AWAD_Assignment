<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_records', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('patient_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('doctor_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Appointment::class, 'appointment_id')->nullable();
            $table->longText('symptoms');
            $table->longText('diagnosis');
            $table->longText('prescription');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_records');
    }
}
