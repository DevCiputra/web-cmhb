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
        Schema::create('patient_screening_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('answered_id'); // Foreign key ke tabel answered
            $table->unsignedBigInteger('question_id'); // Foreign key ke screening_questions
            $table->unsignedBigInteger('option_id'); // Foreign key ke screening_options
            $table->timestamps();
            $table->softDeletes(); // Menambahkan kolom deleted_at

            $table->foreign('answered_id')->references('id')->on('answered_screenings')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('screening_questions')->onDelete('cascade');
            $table->foreign('option_id')->references('id')->on('screening_options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_screening_responses');
    }
};
