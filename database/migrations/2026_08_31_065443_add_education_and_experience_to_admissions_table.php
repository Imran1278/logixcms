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
        Schema::table('admissions', function (Blueprint $table) {
            if (!Schema::hasColumn('admissions', 'education_details')) {
                $table->json('education_details')->nullable();
            }

            if (!Schema::hasColumn('admissions', 'experience_details')) {
                $table->json('experience_details')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            if (Schema::hasColumn('admissions', 'education_details')) {
                $table->dropColumn('education_details');
            }

            if (Schema::hasColumn('admissions', 'experience_details')) {
                $table->dropColumn('experience_details');
            }
        });
    }
};