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
        Schema::create('pet_recommendations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('compatibility_assessment_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('pet_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('compatibility_score');

            $table->string('classification');

            $table->text('gemini_explanation')->nullable();

            $table->timestamps();

            $table->unique([
                'compatibility_assessment_id',
                'pet_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_recommendations');
    }
};
