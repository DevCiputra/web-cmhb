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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialization_name');  // Data denormalisasi (langsung disimpan)
            $table->unsignedBigInteger('doctor_polyclinic_id');  // Foreign key ke doctor_polyclinics
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('doctor_polyclinic_id')->references('id')->on('doctor_polyclinics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
