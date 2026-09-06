<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('fee_collections', function (Blueprint $table) {
            $table->foreignId('fee_allocation_id')->nullable()->after('admission_id')->constrained('fee_allocations')->onDelete('set null');
            // Support for Stripe in Payment Enum
            $table->string('payment_method')->default('Cash')->change();
        });
    }

    public function down(): void
    {
        Schema::table('fee_collections', function (Blueprint $table) {
            $table->dropForeign(['fee_allocation_id']);
            $table->dropColumn('fee_allocation_id');
        });
    }
};