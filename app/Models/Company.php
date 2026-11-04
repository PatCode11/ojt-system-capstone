<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'contact_person',
        'contact_number',
        'email',
        'status',
    ];

    /**
     * OJT assignments belonging to this company.
     */
    public function ojtAssignments(): HasMany
    {
        return $this->hasMany(OjtAssignment::class);
    }
}