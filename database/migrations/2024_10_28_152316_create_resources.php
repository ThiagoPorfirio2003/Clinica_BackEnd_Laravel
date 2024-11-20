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
        Schema::create('appointments', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->unsignedInteger('doctor_id');
            $table->unsignedInteger('specialty_id');
            $table->enum('state', ['PENDING', 'CANCELLED_BY_PATIENT', 'CANCELLED_BY_DOCTOR', 'CANCELLED_BY_ADMIN', 'REJECTED', 'ACCEPTED', 'COMPLETED']);
            $table->dateTime('scheduled_at');
            $table->datetimes();
            
            $table->foreign('doctor_id')->references('id')->on('user_profiles');
            $table->foreign('specialty_id')->references('id')->on('specialties');
        });

        Schema::create('dismissed_appointments', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->string('comment',500);
            $table->dateTime('created_at')->useCurrent();
            
            $table->foreign('id')->references('id')->on('appointments');
        });

        Schema::create('surveys', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->unsignedInteger('appointment_id')->unique();
            $table->unsignedTinyInteger('doctor_quality');
            $table->unsignedTinyInteger('waiting_area_comfort');
            $table->boolean('schedule_adherence');
            $table->enum('appointment_quality', ['VERY_BAD', 'BAD', 'GOOD', 'VERY_GOOD', 'EXCELLENT']);
            $table->enum('would_return', ['NEVER', 'PROBABLY_NOT', 'MAYBE', 'PROBABLY_YES', 'ALWAYS']);
            $table->string('comment',500);
            $table->dateTime('created_at')->useCurrent();

            $table->foreign('appointment_id')->references('id')->on('appointments');
        });

        Schema::create('diagnoses', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->unsignedInteger('appointment_id')->unique();
            $table->float('height', 5, 2);
            $table->float('weight', 5, 2);
            $table->float('temperature', 5,3);
            $table->integer('systolic_pressure');
            $table->integer('diastolic_pressure');
            $table->text('conclusion');
            $table->dateTime('created_at')->useCurrent();

            $table->foreign('appointment_id')->references('id')->on('appointments');
        });

        Schema::create('observations', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->unsignedInteger('diagnosis_id');
            $table->string('title', 100);
            $table->string('description',500);
            $table->dateTime('created_at')->useCurrent();

            $table->foreign('diagnosis_id')->references('id')->on('diagnoses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('dismissed_appointments');
        Schema::dropIfExists('surveys');
        Schema::dropIfExists('diagnoses');
        Schema::dropIfExists('observations');
    }
};
