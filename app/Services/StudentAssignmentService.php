<?php

namespace App\Services;

use App\Models\OjtAssignment;
use App\Models\StudentProfile;

class StudentAssignmentService
{
    /**
     * Resolve the assignment that should
     * currently be displayed to the Student.
     */
    public function displayAssignment(
        StudentProfile $profile,
        ?int $assignmentId = null
    ): ?OjtAssignment {
        /*
        |--------------------------------------------------------------------------
        | Explicit Historical Assignment
        |--------------------------------------------------------------------------
        */

        if ($assignmentId !== null) {
            return $this->query(
                $profile
            )
                ->whereKey(
                    $assignmentId
                )
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Active
        |--------------------------------------------------------------------------
        */

        $assignment =
            $this->query(
                $profile
            )
                ->where(
                    'status',
                    OjtAssignment::STATUS_ACTIVE
                )
                ->latest('start_date')
                ->latest('id')
                ->first();

        if ($assignment) {
            return $assignment;
        }

        /*
        |--------------------------------------------------------------------------
        | Pending
        |--------------------------------------------------------------------------
        */

        $assignment =
            $this->query(
                $profile
            )
                ->where(
                    'status',
                    OjtAssignment::STATUS_PENDING
                )
                ->latest('start_date')
                ->latest('id')
                ->first();

        if ($assignment) {
            return $assignment;
        }

        /*
        |--------------------------------------------------------------------------
        | Latest Completed
        |--------------------------------------------------------------------------
        */

        $assignment =
            $this->query(
                $profile
            )
                ->where(
                    'status',
                    OjtAssignment::STATUS_COMPLETED
                )
                ->latest('completed_at')
                ->latest('start_date')
                ->latest('id')
                ->first();

        if ($assignment) {
            return $assignment;
        }

        /*
        |--------------------------------------------------------------------------
        | Historical Fallback
        |--------------------------------------------------------------------------
        */

        return $this->query(
            $profile
        )
            ->latest('start_date')
            ->latest('id')
            ->first();
    }

    /**
     * Resolve only the active assignment.
     */
    public function activeAssignment(
        StudentProfile $profile
    ): ?OjtAssignment {
        return $this->query(
            $profile
        )
            ->where(
                'status',
                OjtAssignment::STATUS_ACTIVE
            )
            ->latest('start_date')
            ->latest('id')
            ->first();
    }

    /**
     * Base Student assignment query.
     */
    private function query(
        StudentProfile $profile
    ) {
        return $profile
            ->ojtAssignments()
            ->with([
                'company',
                'supervisor',
                'completedBy',

                /*
                |--------------------------------------------------------------------------
                | Final Evaluation
                |--------------------------------------------------------------------------
                */

                'finalEvaluation.evaluator',
            ]);
    }
}