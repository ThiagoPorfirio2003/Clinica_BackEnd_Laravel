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
        Schema::create('user_credentials', function (Blueprint $table)
        {
            $table->integerIncrements('id')->primary();
            $table->string('email', 255)->unique();
            $table->string('password_hash', 255);
            $table->rememberToken();
            //$table->string('remember_token', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            /*
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
            */
        });

        Schema::create('user_profiles', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->unsignedInteger('credential_id')->unique();
            $table->string('name', 255);
            $table->string('surname', 255);
            $table->date('birthdate');
            $table->unsignedInteger('dni')->unique();
            $table->boolean('is_enabled')->default(true);
            $table->enum('role',['PATIENT', 'DOCTOR', 'ADMINISTRATOR']);
            $table->string('img_name',255);
            $table->timestamps();

            $table->foreign('credential_id')->references('id')->on('user_credentials');
        });

        Schema::create('patients', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->unsignedInteger('insurance_number')->unique();
            $table->timestamps();

            $table->foreign('id')->references('id')->on('user_profiles');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
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
