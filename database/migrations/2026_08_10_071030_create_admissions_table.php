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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            
            // Registration Details
            $table->string('registration_no')->unique(); // e.g. LC-241-2026-08-00001
            $table->integer('reg_sequence_no')->default(1); // For numerical sorting
            $table->date('admission_date');
            
            // Relationships
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('inquiry_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained()->onDelete('cascade');
            
            // Personal Information
            $table->string('student_name');
            $table->string('father_name');
            $table->string('cnic_bform')->nullable()->index();
            $table->enum('gender', ['Male', 'Female', 'Other'])->default('Male');
            $table->string('blood_group')->nullable();
            $table->date('dob')->nullable();
            $table->text('home_address')->nullable();
            
            // Contact Details
            $table->string('mobile_number')->index();
            $table->string('whatsapp_number')->nullable();
            $table->string('email')->nullable();
            
            // Guardian Info
            $table->string('guardian_name')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->string('guardian_mobile')->nullable();
            
            // Academic & Fee Summary
            $table->string('last_qualification')->nullable();
            $table->decimal('total_agreed_fee', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->enum('status', ['Learning', 'Freeze', 'Dropped', 'Completed'])->default('Learning')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};