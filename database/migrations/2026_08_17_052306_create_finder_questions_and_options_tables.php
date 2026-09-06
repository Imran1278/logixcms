<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finder_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('icon')->nullable(); // e.g. fa-graduation-cap
            $table->string('field_name'); // e.g. education, interest
            $table->integer('step_number')->default(1);
            $table->timestamps();
        });

        Schema::create('finder_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finder_question_id')->constrained()->onDelete('cascade');
            $table->string('option_label');
            $table->string('option_value');
            $table->string('icon')->nullable(); // e.g. fa-school
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finder_options');
        Schema::dropIfExists('finder_questions');
    }
};