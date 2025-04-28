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
        Schema::create('file_sharing_root_folders', function (Blueprint $table) {
             $table->id();
            // ID user yang membuat folder
            $table->unsignedBigInteger('created_by');
            // Role dari pembuat, sehingga folder ini dikelola oleh semua user dengan role yang sama
            $table->string('role');
            // Nama folder root, misalnya "HBD", "IT", dll.
            $table->string('name');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_sharing_root_folders');
    }
};
