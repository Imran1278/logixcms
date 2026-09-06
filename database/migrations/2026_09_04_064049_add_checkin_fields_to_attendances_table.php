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
        Schema::table('attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('attendances', 'check_in_time')) {
                $table->time('check_in_time')->nullable()->after('attendance_date');
            }
            if (!Schema::hasColumn('attendances', 'check_out_time')) {
                $table->time('check_out_time')->nullable()->after('check_in_time');
            }
            if (!Schema::hasColumn('attendances', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('admission_id')->constrained('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('attendances', 'check_in_time')) $columnsToDrop[] = 'check_in_time';
            if (Schema::hasColumn('attendances', 'check_out_time')) $columnsToDrop[] = 'check_out_time';
            if (Schema::hasColumn('attendances', 'user_id')) $columnsToDrop[] = 'user_id';

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};