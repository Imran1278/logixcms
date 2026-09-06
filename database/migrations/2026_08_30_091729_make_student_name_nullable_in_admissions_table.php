<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            // student_name ko nullable banayein taake student dashboard par khud fill kar sake
            $table->string('student_name')->nullable()->change();
            
            // Safe side ke liye agar baki fields par bhi constraint ho:
            if (Schema::hasColumn('admissions', 'father_name')) {
                $table->string('father_name')->nullable()->change();
            }
            if (Schema::hasColumn('admissions', 'course_id')) {
                $table->unsignedBigInteger('course_id')->nullable()->change();
            }
            if (Schema::hasColumn('admissions', 'batch_id')) {
                $table->unsignedBigInteger('batch_id')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            $table->string('student_name')->nullable(false)->change();
        });
    }
};