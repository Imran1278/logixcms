<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->date('inquiry_date');
            $table->string('student_name');
            $table->string('mobile_number');
            $table->string('whatsapp_number')->nullable();
            $table->string('father_mobile')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('source')->default('Walk-in'); // Walk-in, Facebook, WhatsApp, etc.
            $table->enum('status', [
                'New', 'Contacted', 'Follow-up Required', 
                'Interested', 'Admission Scheduled', 'Converted', 
                'Not Interested', 'Lost'
            ])->default('New');
            $table->boolean('followed_social_media')->default(0); // Requirement #1 Social Follow check
            $table->enum('ai_lead_score', ['Hot', 'Warm', 'Cold'])->nullable(); // Requirement #2 AI Score
            $table->text('remarks')->nullable();
            $table->foreignId('assigned_counselor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};