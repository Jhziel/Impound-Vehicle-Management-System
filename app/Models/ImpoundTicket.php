<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ImpoundTicket extends Model
{
    use HasFactory;

    protected $fillable = [

        'driver_id',
        'enforcer_id',
        'vehicle_id',
        'ticket_id',
        'impound_slot_id'

    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function impoundSlot(): BelongsTo
    {
        return $this->belongsTo(ImpoundSlot::class);
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }
}
