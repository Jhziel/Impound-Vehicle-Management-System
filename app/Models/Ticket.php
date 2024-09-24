<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_no',
        'driver_id',
        'enforcer_id',
        'status',
        'location_of_incident',
        'date_of_incident',
    ];

    public function enforcer(): BelongsTo
    {
        return $this->belongsTo(Enforcer::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function violations(): BelongsToMany
    {
        return $this->belongsToMany(Violation::class);
    }
}
