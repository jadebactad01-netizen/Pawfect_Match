<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('intake_type')->nullable();
            $table->date('intake_date')->nullable();

            $table->string('vaccination_type')->nullable();
            $table->date('vaccination_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn([
                'intake_type',
                'intake_date',
                'vaccination_type',
                'vaccination_date',
            ]);
        });
    }
};