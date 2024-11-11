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
        Schema::create('screening_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('category_name'); // Nama kategori sebagai string langsung
            $table->string('classification_name'); // Nama klasifikasi
            $table->integer('min_score')->nullable(); // Skor minimum
            $table->integer('max_score')->nullable(); // Skor maksimum
            $table->timestamps();
            $table->softDeletes(); // Menambahkan kolom deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_classifications');
    }
};
