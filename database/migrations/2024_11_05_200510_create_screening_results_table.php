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
        Schema::create('screening_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id'); // Foreign key ke patients
            $table->integer('total_score'); // Nilai total dari hasil skrining
            $table->string('classification'); // Klasifikasi hasil
            $table->timestamps();
            $table->softDeletes(); // Menambahkan kolom deleted_at

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_results');
    }
};
