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
        Schema::create('information_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('information_id'); // Foreign key ke information
            $table->unsignedBigInteger('user_id'); // Foreign key ke users
            $table->string('action'); // CREATE, UPDATE, DELETE
            $table->text('changes')->nullable(); // Detail perubahan
            $table->timestamps();

            $table->foreign('information_id')->references('id')->on('information');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_logs');
    }
};
