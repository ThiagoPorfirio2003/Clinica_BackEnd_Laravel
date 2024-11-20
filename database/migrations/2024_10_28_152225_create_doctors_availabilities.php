<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('specialties', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->string('name', 255)->unique();
            $table->unsignedSmallInteger('avg_appointment_minutes');
            $table->timestamp('created_at')->useCurrent();
            //$table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
        }); 
        
        Schema::create('doctor_specialities', function (Blueprint $table) {
            $table->unsignedInteger('doctor_id');
            $table->unsignedInteger('specialty_id');
            $table->timestamp('created_at')->useCurrent();

            $table->primary(['doctor_id', 'specialty_id']);
            $table->foreign('doctor_id')->references('id')->on('user_profiles');
            $table->foreign('specialty_id')->references('id')->on('specialties');
        });

        Schema::create('doctor_availabilities', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->unsignedInteger('doctor_id');
            $table->unsignedInteger('specialty_id');
            $table->enum('day_of_week', ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY']);
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('user_profiles');
            $table->foreign('specialty_id')->references('id')->on('specialties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialties');
        Schema::dropIfExists('doctor_specialities');
        Schema::dropIfExists('doctors_availabilities');
    }
};
