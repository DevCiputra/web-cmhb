<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDobPatientsTable extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            // Check if the column already exists before adding
            if (!Schema::hasColumn('patients', 'dob')) {
                $table->date('dob')->nullable(); // Add dob column
            }
        });
    }
    
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            // Check if the column exists before dropping
            if (Schema::hasColumn('patients', 'dob')) {
                $table->dropColumn('dob'); // Remove dob column on rollback
            }
        });
    }
    
}

