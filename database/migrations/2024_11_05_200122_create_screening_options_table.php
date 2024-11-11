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
        Schema::create('screening_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id'); // Foreign key ke screening_questions
            $table->string('option_text'); // Teks opsi
            $table->integer('weight'); // Nilai bobot untuk opsi ini
            $table->timestamps();
            $table->softDeletes(); // Menambahkan kolom deleted_at

            $table->foreign('question_id')->references('id')->on('screening_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_options');
    }
};
