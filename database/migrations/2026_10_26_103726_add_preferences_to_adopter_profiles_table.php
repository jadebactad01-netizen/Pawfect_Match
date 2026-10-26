<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adopter_profiles', function (Blueprint $table) {
            // Animal preferences
            $table->string('animal_preference')->nullable();
            $table->string('animal_preference_other')->nullable();
            $table->string('preferred_breed')->nullable();
            $table->string('preferred_size')->nullable();
            $table->string('preferred_age')->nullable();

            // Compatibility questionnaire answers
            $table->string('care_ability')->nullable();
            $table->string('available_time')->nullable();
            $table->string('household_compatibility')->nullable();
            $table->string('living_environment')->nullable();
            $table->string('pet_care_experience')->nullable();
            $table->string('activity_level')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('adopter_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'animal_preference',
                'animal_preference_other',
                'preferred_breed',
                'preferred_size',
                'preferred_age',
                'care_ability',
                'available_time',
                'household_compatibility',
                'living_environment',
                'pet_care_experience',
                'activity_level',
            ]);
        });
    }
};