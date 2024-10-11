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
        Schema::create('doctor_consultation_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id'); // Foreign key ke reservations
            $table->unsignedBigInteger('doctor_id'); // Foreign key ke doctors

            // Tanggal yang diajukan pasien untuk konsultasi
            $table->date('preferred_consultation_date')->nullable();

            // Tanggal & Waktu Konsultasi yang Disepakati
            $table->date('agreed_consultation_date')->nullable();
            $table->time('agreed_consultation_time')->nullable();

            // Link & Password Zoom untuk sesi konsultasi
            $table->string('zoom_link')->nullable();
            $table->string('zoom_password')->nullable();

            $table->timestamps();

            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_consultation_reservations');
    }
};
