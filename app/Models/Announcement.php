<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Audience
    |--------------------------------------------------------------------------
    */

    public const AUDIENCE_ALL =
        'all';

    public const AUDIENCE_STUDENTS =
        'students';

    public const AUDIENCE_SUPERVISORS =
        'supervisors';


    public const AUDIENCES = [
        self::AUDIENCE_ALL,
        self::AUDIENCE_STUDENTS,
        self::AUDIENCE_SUPERVISORS,
    ];


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'title',
        'message',
        'audience',

        'published_at',
        'expires_at',

        'created_by',
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'published_at' =>
                'immutable_datetime',

            'expires_at' =>
                'immutable_datetime',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Creator
    |--------------------------------------------------------------------------
    */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        )->withTrashed();
    }


    /*
    |--------------------------------------------------------------------------
    | Published Scope
    |--------------------------------------------------------------------------
    |
    | Only announcements that have already reached their publication
    | date and have not expired are considered visible.
    |
    */

    public function scopePublished(
        Builder $query
    ): Builder {
        return $query
            ->whereNotNull(
                'published_at'
            )
            ->where(
                'published_at',
                '<=',
                now()
            )
            ->where(
                function (
                    Builder $query
                ): void {
                    $query
                        ->whereNull(
                            'expires_at'
                        )
                        ->orWhere(
                            'expires_at',
                            '>=',
                            now()
                        );
                }
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Student Audience Scope
    |--------------------------------------------------------------------------
    */

    public function scopeForStudents(
        Builder $query
    ): Builder {
        return $query->whereIn(
            'audience',
            [
                self::AUDIENCE_ALL,
                self::AUDIENCE_STUDENTS,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Supervisor Audience Scope
    |--------------------------------------------------------------------------
    */

    public function scopeForSupervisors(
        Builder $query
    ): Builder {
        return $query->whereIn(
            'audience',
            [
                self::AUDIENCE_ALL,
                self::AUDIENCE_SUPERVISORS,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Published State
    |--------------------------------------------------------------------------
    */

    public function isPublished(): bool
    {
        if (! $this->published_at) {
            return false;
        }


        if (
            $this->published_at
                ->isFuture()
        ) {
            return false;
        }


        if (
            $this->expires_at
            &&
            $this->expires_at
                ->isPast()
        ) {
            return false;
        }


        return true;
    }
}