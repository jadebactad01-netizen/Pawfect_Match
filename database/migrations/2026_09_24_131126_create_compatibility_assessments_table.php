<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compatibility_assessments', function (Blueprint $table) {
            $table->id();

            // Each assessment belongs to one adoption application.
            $table->foreignId('adoption_application_id')
                ->constrained()
                ->cascadeOnDelete();

            // Prevent multiple assessments for the same application.
            $table->unique('adoption_application_id');


            // =========================================
            // ADOPTER'S ASSESSMENT ANSWERS
            // =========================================

            $table->string('care_ability');
            $table->string('available_time');
            $table->string('household_compatibility');
            $table->string('living_environment');
            $table->string('pet_care_experience');
            $table->string('activity_level');


            // =========================================
            // CALCULATED FACTOR SCORES
            // =========================================

            $table->unsignedInteger('care_score')->default(0);
            $table->unsignedInteger('time_score')->default(0);
            $table->unsignedInteger('household_score')->default(0);
            $table->unsignedInteger('environment_score')->default(0);
            $table->unsignedInteger('experience_score')->default(0);
            $table->unsignedInteger('activity_score')->default(0);


            // =========================================
            // FINAL RESULT
            // =========================================

            $table->unsignedInteger('total_score')->default(0);

            $table->string('classification')->nullable();


            // Gemini will fill this later.
            $table->text('gemini_explanation')->nullable();


            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('compatibility_assessments');
    }
};