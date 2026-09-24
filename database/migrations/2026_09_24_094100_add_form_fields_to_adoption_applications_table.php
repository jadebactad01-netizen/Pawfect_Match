<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {

            // Applicant information
            $table->unsignedInteger('age')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('mobile_number')->nullable();

            // Personal reference
            $table->string('reference_name')->nullable();
            $table->string('reference_relationship')->nullable();
            $table->string('reference_phone')->nullable();

            // How the applicant heard about the shelter
            $table->string('shelter_source')->nullable();
            $table->string('shelter_source_other')->nullable();

            // Animal preference from the shelter form
            $table->string('animal_preference')->nullable();
            $table->string('animal_preference_other')->nullable();
            $table->string('preferred_breed')->nullable();
            $table->string('preferred_size')->nullable();
            $table->string('preferred_age')->nullable();

            // Filled in later by shelter staff
            $table->text('evaluator_notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->dropColumn([
                'age',
                'home_phone',
                'work_phone',
                'mobile_number',
                'reference_name',
                'reference_relationship',
                'reference_phone',
                'shelter_source',
                'shelter_source_other',
                'animal_preference',
                'animal_preference_other',
                'preferred_breed',
                'preferred_size',
                'preferred_age',
                'evaluator_notes',
            ]);
        });
    }
};