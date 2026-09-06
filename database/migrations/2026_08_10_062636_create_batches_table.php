<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('batch_number')->unique(); // e.g., IT-241
            $table->integer('batch_sequence_no'); // Raw integer for auto-increment logic (241)
            $table->string('batch_title')->nullable();
            $table->date('start_date');
            $table->date('end_date'); // Auto-calculated in Controller
            $table->string('class_timing')->nullable();
            $table->string('class_room')->nullable();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('capacity')->default(30);
            $table->enum('status', ['Upcoming', 'Active', 'Completed', 'Cancelled'])->default('Upcoming');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};