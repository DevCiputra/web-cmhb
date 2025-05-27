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
            $table->string('code')->unique();
            $table->unsignedBigInteger('patient_id');

            // Bary
            $table->date('reservation_date')->nullable();
            $table->time('reservation_time')->nullable();

            // Baru
            $table->unsignedBigInteger('doctor_id')->nullable();

            // Baru
            $table->text('complaint')->nullable();

            // Baru
            $table->text('solution')->nullable();

            $table->unsignedBigInteger('reservation_status_id')->nullable();
            $table->unsignedBigInteger('service_category_id');
            $table->string('status_pembayaran')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Tambah soft delete

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('reservation_status_id')->references('id')->on('reservation_statuses');
            $table->foreign('service_category_id')->references('id')->on('service_categories');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });

        // RESERVATION STATUS
        // Konfirmasi Jadwal , Jadwal Konfirmasi , Berhasil , Batal
        // SERVICE CATEGORY ID
        // MCU , KONSULTASI, HOME Service , POLYCLINIC
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
