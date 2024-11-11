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
        Schema::create('screening_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_text'); // Teks soal skrining
            $table->foreignId('category_id')->nullable()->constrained('question_categories')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes(); // Menambahkan kolom deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_questions');
    }
};
