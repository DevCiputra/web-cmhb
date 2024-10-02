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
            $table->date('preferred_consultation_date')->nullable(); // Tanggal reservasi
            $table->time('preferred_consultation_time')->nullable(); // Waktu konsultasi
            $table->string('payment_proof')->nullable(); // Bukti pembayaran
            $table->string('zoom_link')->nullable(); // Link Zoom
            $table->string('zoom_password')->nullable(); // Password Zoom (sebaiknya terenkripsi)
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
