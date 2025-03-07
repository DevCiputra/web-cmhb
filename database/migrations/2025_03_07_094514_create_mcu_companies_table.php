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
        Schema::create('mcu_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama Perusahaan
            $table->string('package_name');   // Nama Paket MCU
            $table->string('responsible_person'); // Penanggung Jawab
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcu_companies');
    }
};
