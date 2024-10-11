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
        Schema::create('payment_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id'); // Foreign key ke reservations
            $table->string('payment_method'); // Metode pembayaran yang digunakan
            $table->string('payment_proof')->nullable(); // Path ke file bukti pembayaran
            $table->timestamp('payment_confirmation_date')->nullable(); // Tanggal konfirmasi pembayaran

            $table->timestamps();

            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_records');
    }
};
