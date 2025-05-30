<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('doctor_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');  // Foreign key ke tabel doctors
            $table->string('name');  // Nama file foto
            $table->string('mime_type');  // Tipe file (image/jpeg, image/png, dll.)
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_photos');
    }
};
