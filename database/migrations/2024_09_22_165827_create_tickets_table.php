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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Driver::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Enforcer::class)->constrained()->cascadeOnDelete();
            $table->string('ticket_no');
            $table->string('location_of_incident');
            $table->string('status');
            $table->dateTimeTz('date_of_incident');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('ticket_violation');
    }
};
