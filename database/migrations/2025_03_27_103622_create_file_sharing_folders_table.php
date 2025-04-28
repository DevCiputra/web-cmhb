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
        Schema::create('file_sharing_folders', function (Blueprint $table) {
      $table->id();
            // ID folder root di mana folder ini berada
            $table->unsignedBigInteger('root_folder_id');
            // Parent ID untuk struktur hierarkis; null jika folder langsung di dalam root
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->timestamps();

            $table->foreign('root_folder_id')->references('id')->on('file_sharing_root_folders')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('file_sharing_folders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_sharing_folders');
    }
};
