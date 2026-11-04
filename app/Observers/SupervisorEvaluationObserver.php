<?php

namespace App\Observers;

use App\Models\SupervisorEvaluation;
use App\Services\AuditLogService;

class SupervisorEvaluationObserver
{
    /**
     * Final Evaluation submitted.
     */
    public function created(
        SupervisorEvaluation $evaluation
    ): void {
        app(AuditLogService::class)
            ->record(
                'evaluation.submitted',
                $evaluation,
                sprintf(
                    'Final Supervisor Evaluation #%d submitted.',
                    $evaluation->id
                ),
                [
                    'evaluation_id' =>
                        $evaluation->id,

                    'assignment_id' =>
                        $evaluation->ojt_assignment_id,

                    'overall_rating' =>
                        $evaluation->overallRating(),

                    'recommendation' =>
                        $evaluation->recommendation,

                    'evaluated_by' =>
                        $evaluation->evaluated_by,
                ]
            );
    }

    /**
     * Final Evaluation updated.
     */
    public function updated(
        SupervisorEvaluation $evaluation
    ): void {
        $changedFields =
            array_values(
                array_intersect(
                    array_keys(
                        $evaluation->getChanges()
                    ),
                    [
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
                    ]
                )
            );

        if ($changedFields === []) {
            return;
        }

        app(AuditLogService::class)
            ->record(
                'evaluation.updated',
                $evaluation,
                sprintf(
                    'Final Supervisor Evaluation #%d updated.',
                    $evaluation->id
                ),
                [
                    'evaluation_id' =>
                        $evaluation->id,

                    'assignment_id' =>
                        $evaluation->ojt_assignment_id,

                    'overall_rating' =>
                        $evaluation->overallRating(),

                    'recommendation' =>
                        $evaluation->recommendation,

                    'changed_fields' =>
                        $changedFields,

                    'evaluated_by' =>
                        $evaluation->evaluated_by,
                ]
            );
    }
}