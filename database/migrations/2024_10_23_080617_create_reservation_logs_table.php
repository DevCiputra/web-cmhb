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
        Schema::create('reservation_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id'); // Foreign key ke reservations
            $table->unsignedBigInteger('user_id'); // Admin yang bertindak
            $table->string('patient_name'); // Nama pasien
            $table->string('user_name'); // Nama admin
            $table->string('reason'); // Alasan
            $table->timestamps(); // Tanggal waktu aksi
            $table->softDeletes(); // Fitur soft delete

            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_logs');
    }
};
