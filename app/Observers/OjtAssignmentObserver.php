<?php

namespace App\Observers;

use App\Models\OjtAssignment;
use App\Services\AuditLogService;

class OjtAssignmentObserver
{
    /**
     * Assignment created.
     */
    public function created(
        OjtAssignment $assignment
    ): void {
        app(AuditLogService::class)
            ->record(
                'assignment.created',
                $assignment,
                sprintf(
                    'OJT Assignment #%d created.',
                    $assignment->id
                ),
                [
                    'assignment_id' =>
                        $assignment->id,

                    'student_profile_id' =>
                        $assignment->student_profile_id,

                    'company_id' =>
                        $assignment->company_id,

                    'supervisor_id' =>
                        $assignment->supervisor_id,

                    'required_hours' =>
                        $assignment->required_hours,

                    'status' =>
                        $assignment->status,
                ]
            );
    }

    /**
     * Assignment updated.
     */
    public function updated(
        OjtAssignment $assignment
    ): void {
        $changedFields =
            array_values(
                array_intersect(
                    array_keys(
                        $assignment->getChanges()
                    ),
                    [
                        'student_profile_id',
                        'company_id',
                        'supervisor_id',
                        'required_hours',
                        'start_date',
                        'end_date',
                        'status',
                        'notes',
                        'completed_by',
                        'completed_at',
                        'completion_remarks',
                    ]
                )
            );

        if ($changedFields === []) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Formal Completion
        |--------------------------------------------------------------------------
        */

        if (
            $assignment->wasChanged('status')
            && $assignment->status
                === OjtAssignment::STATUS_COMPLETED
        ) {
            $action =
                'assignment.completed';

            $description =
                sprintf(
                    'OJT Assignment #%d formally completed.',
                    $assignment->id
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Cancellation
        |--------------------------------------------------------------------------
        */

        elseif (
            $assignment->wasChanged('status')
            && $assignment->status
                === OjtAssignment::STATUS_CANCELLED
        ) {
            $action =
                'assignment.cancelled';

            $description =
                sprintf(
                    'OJT Assignment #%d cancelled.',
                    $assignment->id
                );
        }

        /*
        |--------------------------------------------------------------------------
        | General Update
        |--------------------------------------------------------------------------
        */

        else {
            $action =
                'assignment.updated';

            $description =
                sprintf(
                    'OJT Assignment #%d updated.',
                    $assignment->id
                );
        }

        app(AuditLogService::class)
            ->record(
                $action,
                $assignment,
                $description,
                [
                    'assignment_id' =>
                        $assignment->id,

                    'student_profile_id' =>
                        $assignment->student_profile_id,

                    'company_id' =>
                        $assignment->company_id,

                    'supervisor_id' =>
                        $assignment->supervisor_id,

                    'required_hours' =>
                        $assignment->required_hours,

                    'status' =>
                        $assignment->status,

                    'changed_fields' =>
                        $changedFields,
                ]
            );
    }
}