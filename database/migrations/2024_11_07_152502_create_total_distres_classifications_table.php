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
        Schema::create('total_distress_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('classification_name'); // Nama klasifikasi (misalnya, Normal, Ringan, Sedang, Berat, Parah)
            $table->integer('min_score'); // Skor minimum
            $table->integer('max_score'); // Skor maksimum
            $table->timestamps();
            $table->softDeletes(); // Menambahkan kolom deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_distres_classifications');
    }
};
