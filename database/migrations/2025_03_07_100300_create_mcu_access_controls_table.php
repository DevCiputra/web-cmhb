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
        Schema::create('mcu_access_controls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_id');
            $table->unsignedBigInteger('folder_id');
            $table->boolean('is_active'); // Status Aktif/Nonaktif
            $table->timestamp('expired_at'); // Tanggal Kadaluarsa
            $table->timestamps();

            $table->foreign('participant_id')->references('id')->on('mcu_participants')->onDelete('cascade');
            $table->foreign('folder_id')->references('id')->on('mcu_folders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcu_access_controls');
    }
};
