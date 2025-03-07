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
        Schema::create('mcu_file_access_log_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_id'); // ID pasien yang mengakses
            $table->unsignedBigInteger('folder_id');      // ID folder yang diakses
            $table->unsignedBigInteger('file_id')->nullable(); // ID file yang diakses (opsional)
            $table->string('action');                       // Jenis aksi: view, download, open, dll.
            $table->string('user_agent');                   // User agent browser
            $table->string('ip_address');                   // IP address user
            $table->timestamp('created_at')->useCurrent();  // Waktu akses
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcu_file_access_log_activities');
    }
};
