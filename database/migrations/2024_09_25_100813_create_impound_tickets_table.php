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
        Schema::create('impound_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Driver::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Enforcer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Vehicle::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\ImpoundSlot::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Ticket::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impound_tickets');
    }
};
