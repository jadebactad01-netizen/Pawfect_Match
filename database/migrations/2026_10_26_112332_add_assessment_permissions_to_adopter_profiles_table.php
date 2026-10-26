<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adopter_profiles', function (Blueprint $table) {
            $table->timestamp('assessment_locked_at')->nullable();

            $table->string('edit_request_status')->nullable();

            $table->text('edit_request_reason')->nullable();

            $table->boolean('edit_permission_granted')
                ->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('adopter_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'assessment_locked_at',
                'edit_request_status',
                'edit_request_reason',
                'edit_permission_granted',
            ]);
        });
    }
};