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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode unik untuk reservasi
            $table->unsignedBigInteger('patient_id'); // Foreign key ke tabel patients
            $table->unsignedBigInteger('reservation_status_id'); // Foreign key ke reservation_statuses
            $table->unsignedBigInteger('service_category_id'); // Foreign key ke service_categories
            $table->string('status_pembayaran')->default('belum bayar'); // Status pembayaran, default 'belum bayar'
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('reservation_status_id')->references('id')->on('reservation_statuses');
            $table->foreign('service_category_id')->references('id')->on('service_categories');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
