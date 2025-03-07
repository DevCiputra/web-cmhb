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
        Schema::create('mcu_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('name'); // Nama Pasien
            $table->date('birth_date'); // Tanggal Lahir
            $table->string('username')->unique(); // Username Autentikasi
            $table->string('password'); // Password Autentikasi
            $table->string('email')->nullable(); // Email Opsional
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('mcu_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcu_participants');
    }
};
