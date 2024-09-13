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
        Schema::create('hospital_informations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('address', 255);
            $table->string('phone', 255);
            $table->string('email', 255);
            $table->string('logo')->nullable();
            $table->string('vision')->nullable();
            $table->string('mission')->nullable();
            $table->string('emergency_contact', 255);
            $table->string('customer_service_contact', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_informations');
    }
};
