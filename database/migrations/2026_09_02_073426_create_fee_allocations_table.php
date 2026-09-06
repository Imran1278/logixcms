<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fee_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained('admissions')->onDelete('cascade');
            $table->string('academic_session')->default('2026-2027'); // Session tracking
            
            $table->decimal('total_amount', 10, 2)->default(0.00);      // Total Fee sum of all items
            $table->decimal('discount_amount', 10, 2)->default(0.00);   // Concession / Scholarship
            $table->string('discount_reason')->nullable();              // Concession Reason
            $table->string('discount_approved_by')->nullable();         // Admin Approval
            
            $table->decimal('net_payable', 10, 2)->default(0.00);       // Final Fee after discount
            $table->decimal('paid_amount', 10, 2)->default(0.00);       // Total Received so far
            $table->decimal('due_amount', 10, 2)->default(0.00);        // Remaining Balance
            
            $table->enum('status', ['Unpaid', 'Partial', 'Paid'])->default('Unpaid');
            $table->string('created_by')->nullable();                   // Audit log (Admin Name)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_allocations');
    }
};