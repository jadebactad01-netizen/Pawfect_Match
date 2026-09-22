<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adopter_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();

            $table->string('living_environment')->nullable();
            $table->string('household')->nullable();
            $table->string('available_time')->nullable();
            $table->string('pet_care_experience')->nullable();
            $table->string('activity_level')->nullable();
            $table->string('care_ability')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adopter_profiles');
    }
};