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
        Schema::create('mcu_folders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('name'); // Nama Folder (MCU_TANGGAL atau NamaPasien_TanggalLahir)
            $table->enum('folder_type', ['MCU', 'Patient']); // Jenis Folder
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('mcu_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcu_folders');
    }
};
