<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the pets table.
     */
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {

            // Automatically creates the pet ID
            $table->id();

            // Basic pet information
            $table->string('name');
            $table->string('type');
            $table->string('sex');
            $table->string('age');

            // Current adoption status
            $table->string('status')->default('Available');

            // Longer description of the pet
            $table->text('description')->nullable();

            // Temporary placeholder until we use real pet photos
            $table->string('emoji')->nullable();

            // created_at and updated_at
            $table->timestamps();
        });
    }


    /**
     * Delete the pets table if the migration is reversed.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};