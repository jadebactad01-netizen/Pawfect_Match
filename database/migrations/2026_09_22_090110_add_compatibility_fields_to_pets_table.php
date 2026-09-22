<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('care_requirement')->nullable();
            $table->string('time_requirement')->nullable();
            $table->string('household_compatibility')->nullable();
            $table->string('living_environment')->nullable();
            $table->string('experience_requirement')->nullable();
            $table->string('activity_level')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn([
                'care_requirement',
                'time_requirement',
                'household_compatibility',
                'living_environment',
                'experience_requirement',
                'activity_level',
            ]);
        });
    }
};