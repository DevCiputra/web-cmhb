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
            $table->unsignedBigInteger('reservation_id'); // Foreign key
            $table->unsignedBigInteger('doctor_id'); // Foreign key
            $table->unsignedBigInteger('zoom_account_id'); // Foreign key untuk akun Zoom

            $table->date('preferred_consultation_date')->nullable();
            $table->date('agreed_consultation_date')->nullable();
            $table->time('agreed_consultation_time')->nullable();

            $table->text('zoom_host_link')->nullable();
            $table->string('zoom_link')->nullable();
            $table->string('zoom_password')->nullable();

            $table->timestamps();
            $table->softDeletes(); // Tambah soft delete

            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('zoom_account_id')->references('id')->on('zoom_accounts')->onDelete('cascade'); // Referensi ke tabel zoom_accounts
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
