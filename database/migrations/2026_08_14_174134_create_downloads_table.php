<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category'); // e.g., Admission, Examination, Rules, Fee
            $table->string('file_type'); // e.g., PDF, Word, Image
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->timestamps(); // Created_at date automatically handle karega
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('downloads');
    }
};