<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'auditable_type',
        'auditable_id',
        'metadata',
        'ip_address',
        'user_agent',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'metadata' =>
                'array',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actor
    |--------------------------------------------------------------------------
    */

    public function actor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Audited Subject
    |--------------------------------------------------------------------------
    */

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }
}