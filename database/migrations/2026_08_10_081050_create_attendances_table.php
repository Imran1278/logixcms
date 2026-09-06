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
        if (!Schema::hasTable('attendances')) {
            Schema::create('attendances', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admission_id')->nullable()->constrained('admissions')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('cascade');
                $table->date('attendance_date');
                $table->time('check_in_time')->nullable();
                $table->time('check_out_time')->nullable();
                $table->enum('status', ['Present', 'Absent', 'Late', 'Leave'])->default('Present');
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};