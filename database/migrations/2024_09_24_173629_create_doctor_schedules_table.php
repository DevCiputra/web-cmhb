<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');  // Foreign key ke tabel doctors
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);  // Hari praktek dokter
            $table->time('start_time');  // Jam mulai
            $table->time('end_time');  // Jam selesai
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');

            // Indeks (opsional)
            $table->index('doctor_id');
            $table->index('day_of_week');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
