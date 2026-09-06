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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('student')->after('email'); // 'admin', 'student'
            $table->boolean('is_profile_complete')->default(false)->after('role');
            $table->string('phone')->nullable()->after('is_profile_complete');
            $table->string('cnic')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_profile_complete', 'phone', 'cnic']);
        });
    }
};
