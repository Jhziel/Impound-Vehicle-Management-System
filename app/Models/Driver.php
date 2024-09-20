<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_no',
        'license_type',
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
}
