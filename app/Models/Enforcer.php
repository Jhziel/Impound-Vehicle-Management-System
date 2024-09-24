<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enforcer extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_no',
        'status',
        'first_name',
        'last_name',
        'middle_name_initial',
        'street_address',
        'province',
        'municipality',
        'barangay',
        'postal_code',
        'contact_no',
        'nationality',
        'civil_status',
        'gender',
        'date_of_birth',

    ];
    public function tickets():HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
