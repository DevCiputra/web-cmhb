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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id')->unique(); // Satu reservation, satu invoice
            $table->string('invoice_number')->nullable()->unique(); // Nomor invoice terisi saat pembayaran dikonfirmasi
            $table->decimal('total_amount', 10, 2)->nullable(); // Diambil dari biaya konsultasi
            $table->string('payment_status')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Tambah soft delete
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
