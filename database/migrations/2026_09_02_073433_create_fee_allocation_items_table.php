<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fee_allocation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_allocation_id')->constrained('fee_allocations')->onDelete('cascade');
            $table->foreignId('fee_head_id')->constrained('fee_heads')->onDelete('cascade');
            
            $table->decimal('amount', 10, 2);
            $table->enum('frequency', ['Monthly', 'Quarterly', 'Half-Yearly', 'One-Time'])->default('Monthly');
            $table->date('due_date')->nullable();
            $table->decimal('late_fine', 10, 2)->default(0.00);
            $table->decimal('waived_amount', 10, 2)->default(0.00); // Admin Waive off option
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_allocation_items');
    }
};