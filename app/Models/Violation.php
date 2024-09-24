<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = [
        'violation_name',
        'violation_code',
        'fine',
        'violation_description'
    ];

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class);
    }
}
