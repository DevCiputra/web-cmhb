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
        Schema::create('answered_screenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->integer('stress_score')->nullable();
            $table->string('stress_classification')->nullable();
            $table->integer('depression_score')->nullable();
            $table->string('depression_classification')->nullable();
            $table->integer('anxiety_score')->nullable();
            $table->string('anxiety_classification')->nullable();
            $table->integer('total_distress_score')->nullable();
            $table->string('total_distress_classification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answered_screenings');
    }
};
