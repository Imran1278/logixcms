<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            // Column 1: About
            $table->text('about_description')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('working_hours')->nullable();

            // Column 3: Support Links (JSON Format)
            $table->json('support_links')->nullable();

            // Column 4: Flexible Learning
            $table->string('learning_title')->default('Flexible Learning');
            $table->string('map_image')->nullable();

            // Bottom Bar Settings
            $table->string('copyright_text')->nullable();
            $table->string('bottom_phone')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('linkedin_url')->nullable();
            

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
};