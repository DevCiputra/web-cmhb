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
        Schema::create('file_sharing_files', function (Blueprint $table) {
            $table->id();
            // Mengacu ke folder di mana file disimpan (folder bisa merupakan folder root atau sub-folder)
            $table->unsignedBigInteger('folder_id');
            $table->string('file_name');
            $table->string('file_path'); // Lokasi file di penyimpanan, misalnya disk 'private'
            $table->unsignedBigInteger('uploaded_by'); // ID user yang mengupload file
            $table->timestamps();

            $table->foreign('folder_id')->references('id')->on('file_sharing_folders')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_sharing_files');
    }
};
