<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupervisorEvaluation extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Recommendations
    |--------------------------------------------------------------------------
    */

    public const RECOMMENDATION_RECOMMENDED =
        'recommended';

    public const RECOMMENDATION_NEEDS_IMPROVEMENT =
        'needs_improvement';


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'ojt_assignment_id',

        'attendance_reliability',
        'work_quality',
        'initiative',
        'communication',
        'professionalism',
        'technical_competence',

        'strengths',
        'areas_for_improvement',
        'final_comments',

        'recommendation',

        'evaluated_by',
        'evaluated_at',
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'attendance_reliability' =>
                'integer',

            'work_quality' =>
                'integer',

            'initiative' =>
                'integer',

            'communication' =>
                'integer',

            'professionalism' =>
                'integer',

            'technical_competence' =>
                'integer',

            'evaluated_at' =>
                'immutable_datetime',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | OJT Assignment
    |--------------------------------------------------------------------------
    */

    public function ojtAssignment(): BelongsTo
    {
        return $this->belongsTo(
            OjtAssignment::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Evaluating Supervisor
    |--------------------------------------------------------------------------
    |
    | Preserve the Supervisor identity in historical evaluation records
    | even after the Supervisor account has been archived.
    |
    */

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'evaluated_by'
        )->withTrashed();
    }


    /*
    |--------------------------------------------------------------------------
    | Overall Rating
    |--------------------------------------------------------------------------
    */

    public function overallRating(): float
    {
        $scores = [
            $this->attendance_reliability,
            $this->work_quality,
            $this->initiative,
            $this->communication,
            $this->professionalism,
            $this->technical_competence,
        ];

        return round(
            array_sum($scores)
            / count($scores),
            2
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Rating Label
    |--------------------------------------------------------------------------
    */

    public function ratingLabel(): string
    {
        $rating =
            $this->overallRating();

        if ($rating >= 4.50) {
            return 'Outstanding';
        }

        if ($rating >= 3.50) {
            return 'Very Good';
        }

        if ($rating >= 2.50) {
            return 'Good';
        }

        if ($rating >= 1.50) {
            return 'Fair';
        }

        return 'Needs Improvement';
    }


    /*
    |--------------------------------------------------------------------------
    | Recommendation Label
    |--------------------------------------------------------------------------
    */

    public function recommendationLabel(): string
    {
        return match (
            $this->recommendation
        ) {
            self::RECOMMENDATION_RECOMMENDED =>
                'Recommended for Completion',

            self::RECOMMENDATION_NEEDS_IMPROVEMENT =>
                'Needs Improvement',

            default =>
                'Unknown',
        };
    }
}