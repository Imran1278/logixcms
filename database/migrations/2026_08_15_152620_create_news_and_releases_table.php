<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Press Releases Table
        Schema::create('press_releases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        // 2. Latest News Table
        Schema::create('latest_news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('news_date');
            $table->text('description');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        // 3. Upcoming News Table
        Schema::create('upcoming_news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('news_date');
            $table->text('description');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('press_releases');
        Schema::dropIfExists('latest_news');
        Schema::dropIfExists('upcoming_news');
    }
};