<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->text('admin_reply')->nullable()->after('remarks');
            $table->timestamp('replied_at')->nullable()->after('admin_reply');
            $table->text('student_reply')->nullable()->after('replied_at');
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn(['admin_reply', 'replied_at', 'student_reply']);
        });
    }
};