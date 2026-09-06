<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_contents', function (Blueprint $table) {
            $table->id();
            // Home Page About Section
            $table->string('home_title')->nullable();
            $table->text('home_description')->nullable();
            $table->string('home_video_url')->nullable();

            // About Details Page Fields
            $table->text('our_vision')->nullable();
            $table->text('trained_professionals_info')->nullable();
            $table->string('why_logix_title')->nullable();
            $table->text('why_logix_description')->nullable();
            $table->string('why_logix_icon')->default('fa-solid fa-graduation-cap');
            
            $table->text('educational_goals')->nullable();
            $table->text('our_mission')->nullable();
            $table->text('specific_goals')->nullable();
            $table->text('college_awards')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_contents');
    }
};