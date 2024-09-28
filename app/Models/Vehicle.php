<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_no',
        'vehicle_type',
        'driver_id',
        'ownership_type',
        'is_impounded',
        'impound_date'
    ];

    public function impoundTickets(): HasMany
    {
        return $this->hasMany(ImpoundTicket::class);
    }
}
