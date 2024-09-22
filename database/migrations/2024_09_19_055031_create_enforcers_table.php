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
        Schema::create('enforcers', function (Blueprint $table) {
            $table->id();
            $table->string('badge_no')->unique();
            $table->string('status');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name_initial');
            $table->string('street_address');
            $table->string('province');
            $table->string('municipality');
            $table->string('barangay');
            $table->integer('postal_code');
            $table->integer('contact_no');
            $table->string('nationality');
            $table->string('civil_status');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enforcers');
    }
};
