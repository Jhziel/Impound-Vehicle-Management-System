<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImpoundSlot extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function impoundTickets(): HasMany
    {
        return $this->hasMany(ImpoundTicket::class);
    }
}
