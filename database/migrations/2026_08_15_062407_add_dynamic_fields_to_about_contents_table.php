<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_contents', function (Blueprint $table) {
            $table->json('industries')->nullable()->after('specific_goals'); // Stores array of [{name, image, description}]
            $table->json('awards')->nullable()->after('industries');        // Stores array of image paths
        });
    }

    public function down(): void
    {
        Schema::table('about_contents', function (Blueprint $table) {
            $table->dropColumn(['industries', 'awards']);
        });
    }
};
