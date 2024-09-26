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
        Schema::create('users_credentials', function (Blueprint $table)
        {
            $table->integerIncrements('id')->primary();
            $table->string('email', 255)->unique();
            $table->boolean('email_verified')->default(false);
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
        });

        
        Schema::create('users', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->integer('credential_id', false, true)->unique();
            $table->string('name', 255);
            $table->string('surname', 255);
            $table->dateTime('birthday');
            $table->integer('dni', false, true)->unique();
            $table->boolean('is_enabled')->default(true);
            $table->enum('role',['PATIENT', 'DOCTOR', 'ADMINISTRATOR']);
            $table->string('profile_img_path',255);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();

            $table->foreign('credential_id')->references('id')->on('users_credentials');
        });

        Schema::create('patients', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->integer('insurance_number', false, true)->unique();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();

            $table->foreign('id')->references('id')->on('users');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedInteger('user_id')->nullable();
            //$table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
        Schema::dropIfExists('users');
        Schema::dropIfExists('users_credentials');

        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
