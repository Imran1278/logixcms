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
        // 1. Users table update
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'cnic')) {
                $table->string('cnic')->unique()->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'picture')) {
                $table->string('picture')->nullable()->after('cnic');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('student')->after('picture');
            }
            if (!Schema::hasColumn('users', 'profile_completed')) {
                $table->boolean('profile_completed')->default(false)->after('password');
            }
            if (!Schema::hasColumn('users', 'is_profile_complete')) {
                $table->boolean('is_profile_complete')->default(false)->after('profile_completed');
            }
        });

        // 2. Student Leaves table creation
        if (!Schema::hasTable('student_leaves')) {
            Schema::create('student_leaves', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('cascade');
                $table->date('leave_date');
                $table->text('reason');
                $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
                $table->text('admin_remarks')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_leaves');

        Schema::table('users', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('users', 'cnic')) $columnsToDrop[] = 'cnic';
            if (Schema::hasColumn('users', 'picture')) $columnsToDrop[] = 'picture';
            if (Schema::hasColumn('users', 'role')) $columnsToDrop[] = 'role';
            if (Schema::hasColumn('users', 'profile_completed')) $columnsToDrop[] = 'profile_completed';
            if (Schema::hasColumn('users', 'is_profile_complete')) $columnsToDrop[] = 'is_profile_complete';

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};