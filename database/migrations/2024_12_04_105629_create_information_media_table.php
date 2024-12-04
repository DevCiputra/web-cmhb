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
        Schema::create('information_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('information_id'); // Foreign key untuk informasi terkait
            $table->string('file_name'); // Nama file yang diupload
            $table->string('mime_type'); // Mime type dari file
            $table->string('file_url'); // URL foto yang dapat diakses
            $table->timestamps();
            $table->softDeletes(); // Menambahkan kolom deleted_at untuk soft delete

            // Foreign key untuk tabel information
            $table->foreign('information_id')->references('id')->on('information')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_media');
    }
};
