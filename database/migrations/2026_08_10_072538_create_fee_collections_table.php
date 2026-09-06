<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_collections', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no')->unique(); // e.g. REC-2026-0001
            $table->foreignId('admission_id')->constrained()->onDelete('cascade');
            
            $table->decimal('amount_paid', 10, 2);
            $table->date('payment_date');
            $table->enum('payment_method', ['Cash', 'Bank Transfer', 'Easypaisa/Jazzcash', 'Cheque'])->default('Cash');
            $table->string('transaction_reference')->nullable();
            
            $table->string('received_by')->nullable(); // Admin/Staff Name
            $table->text('remarks')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_collections');
    }
};