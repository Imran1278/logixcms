<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->string('course_code')->unique(); // e.g., IT, WDD, GD
            $table->integer('duration'); // e.g., 3
            $table->enum('duration_type', ['Weeks', 'Months'])->default('Months');
            $table->string('timing')->nullable(); // e.g., 10:00 AM - 12:00 PM
            $table->integer('seats')->default(30);
            $table->decimal('standard_fee', 10, 2);
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->decimal('certification_fee', 10, 2)->default(0);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->longText('objectives')->nullable(); // Rich Text / Bullets / Fee Details
            $table->text('eligibility')->nullable();
            $table->longText('reviews')->nullable(); // Reviews & Social Links
            $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};