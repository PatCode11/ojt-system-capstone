<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\OjtAssignment;
use App\Models\SupervisorEvaluation;
use App\Models\User;
use App\Services\OjtAssignmentCompletionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EvaluationController extends Controller
{
    /**
     * Display assignments available
     * to the authenticated Supervisor.
     */
    public function index(
        Request $request,
        OjtAssignmentCompletionService $completionService
    ): View {
        $supervisor =
            $this->supervisor(
                $request
            );

        $assignments =
            OjtAssignment::query()
                ->with([
                    'studentProfile.user',
                    'company',
                    'finalEvaluation.evaluator',
                ])
                ->where(
                    'supervisor_id',
                    $supervisor->id
                )
                ->whereIn(
                    'status',
                    [
                        OjtAssignment::STATUS_ACTIVE,
                        OjtAssignment::STATUS_COMPLETED,
                    ]
                )
                ->latest('start_date')
                ->latest('id')
                ->paginate(12);

        /*
        |--------------------------------------------------------------------------
        | Completion / Evaluation Status
        |--------------------------------------------------------------------------
        */

        $summaries = [];

        foreach (
            $assignments->getCollection()
            as $assignment
        ) {
            $summaries[$assignment->id] =
                $completionService->summary(
                    $assignment
                );
        }

        return view(
            'supervisor.evaluations.index',
            compact(
                'assignments',
                'summaries'
            )
        );
    }

    /**
     * Review or complete one Final Evaluation.
     */
    public function show(
        Request $request,
        OjtAssignment $assignment,
        OjtAssignmentCompletionService $completionService
    ): View {
        $supervisor =
            $this->supervisor(
                $request
            );

        $this->authorizeAssignment(
            $assignment,
            $supervisor
        );

        $assignment->load([
            'studentProfile.user',
            'company',
            'finalEvaluation.evaluator',
        ]);

        $summary =
            $completionService->summary(
                $assignment
            );

        return view(
            'supervisor.evaluations.show',
            compact(
                'assignment',
                'summary'
            )
        );
    }

    /**
     * Submit Final Evaluation.
     */
    public function store(
        Request $request,
        OjtAssignment $assignment,
        OjtAssignmentCompletionService $completionService
    ): RedirectResponse {
        $supervisor =
            $this->supervisor(
                $request
            );

        $this->authorizeAssignment(
            $assignment,
            $supervisor
        );

        $validated =
            $this->validateEvaluation(
                $request
            );

        DB::transaction(
            function () use (
                $assignment,
                $supervisor,
                $validated,
                $completionService
            ): void {
                /*
                |--------------------------------------------------------------------------
                | Lock Assignment
                |--------------------------------------------------------------------------
                */

                $lockedAssignment =
                    OjtAssignment::query()
                        ->whereKey(
                            $assignment->id
                        )
                        ->lockForUpdate()
                        ->firstOrFail();

                /*
                |--------------------------------------------------------------------------
                | Recheck Supervisor Ownership
                |--------------------------------------------------------------------------
                */

                if (
                    (int) $lockedAssignment->supervisor_id
                    !==
                    (int) $supervisor->id
                ) {
                    abort(403);
                }

                /*
                |--------------------------------------------------------------------------
                | Assignment Must Be Active
                |--------------------------------------------------------------------------
                */

                if (
                    $lockedAssignment->status
                    !== OjtAssignment::STATUS_ACTIVE
                ) {
                    throw ValidationException::withMessages([
                        'evaluation' =>
                            'A Final Evaluation can only be submitted for an Active OJT Assignment.',
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Prevent Duplicate Evaluation
                |--------------------------------------------------------------------------
                */

                if (
                    $lockedAssignment
                        ->finalEvaluation()
                        ->exists()
                ) {
                    throw ValidationException::withMessages([
                        'evaluation' =>
                            'A Final Evaluation already exists for this OJT Assignment.',
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Verify Operational Requirements
                |--------------------------------------------------------------------------
                */

                $summary =
                    $completionService->summary(
                        $lockedAssignment
                    );

                if (! $summary['evaluationReady']) {
                    throw ValidationException::withMessages([
                        'evaluation' =>
                            implode(
                                ' ',
                                $summary[
                                    'evaluationBlockers'
                                ]
                            ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Create Final Evaluation
                |--------------------------------------------------------------------------
                */

                SupervisorEvaluation::create([
                    'ojt_assignment_id' =>
                        $lockedAssignment->id,

                    'attendance_reliability' =>
                        $validated[
                            'attendance_reliability'
                        ],

                    'work_quality' =>
                        $validated[
                            'work_quality'
                        ],

                    'initiative' =>
                        $validated[
                            'initiative'
                        ],

                    'communication' =>
                        $validated[
                            'communication'
                        ],

                    'professionalism' =>
                        $validated[
                            'professionalism'
                        ],

                    'technical_competence' =>
                        $validated[
                            'technical_competence'
                        ],

                    'strengths' =>
                        $validated[
                            'strengths'
                        ] ?? null,

                    'areas_for_improvement' =>
                        $validated[
                            'areas_for_improvement'
                        ] ?? null,

                    'final_comments' =>
                        $validated[
                            'final_comments'
                        ] ?? null,

                    'recommendation' =>
                        $validated[
                            'recommendation'
                        ],

                    'evaluated_by' =>
                        $supervisor->id,

                    'evaluated_at' =>
                        now(),
                ]);
            }
        );

        return redirect()
            ->route(
                'supervisor.evaluations.show',
                $assignment
            )
            ->with(
                'success',
                'Final Supervisor Evaluation submitted successfully.'
            );
    }

    /**
     * Update an Evaluation before formal completion.
     */
    public function update(
        Request $request,
        OjtAssignment $assignment,
        OjtAssignmentCompletionService $completionService
    ): RedirectResponse {
        $supervisor =
            $this->supervisor(
                $request
            );

        $this->authorizeAssignment(
            $assignment,
            $supervisor
        );

        $validated =
            $this->validateEvaluation(
                $request
            );

        DB::transaction(
            function () use (
                $assignment,
                $supervisor,
                $validated,
                $completionService
            ): void {
                $lockedAssignment =
                    OjtAssignment::query()
                        ->whereKey(
                            $assignment->id
                        )
                        ->lockForUpdate()
                        ->firstOrFail();

                if (
                    (int) $lockedAssignment->supervisor_id
                    !==
                    (int) $supervisor->id
                ) {
                    abort(403);
                }

                /*
                |--------------------------------------------------------------------------
                | Completed Evaluation Is Locked
                |--------------------------------------------------------------------------
                */

                if (
                    $lockedAssignment->status
                    !== OjtAssignment::STATUS_ACTIVE
                ) {
                    throw ValidationException::withMessages([
                        'evaluation' =>
                            'The Final Evaluation is locked because this OJT Assignment is no longer Active.',
                    ]);
                }

                $summary =
                    $completionService->summary(
                        $lockedAssignment
                    );

                if (! $summary['evaluationReady']) {
                    throw ValidationException::withMessages([
                        'evaluation' =>
                            implode(
                                ' ',
                                $summary[
                                    'evaluationBlockers'
                                ]
                            ),
                    ]);
                }

                $evaluation =
                    $lockedAssignment
                        ->finalEvaluation()
                        ->lockForUpdate()
                        ->first();

                if (! $evaluation) {
                    throw ValidationException::withMessages([
                        'evaluation' =>
                            'No Final Evaluation exists for this assignment.',
                    ]);
                }

                $evaluation->update([
                    'attendance_reliability' =>
                        $validated[
                            'attendance_reliability'
                        ],

                    'work_quality' =>
                        $validated[
                            'work_quality'
                        ],

                    'initiative' =>
                        $validated[
                            'initiative'
                        ],

                    'communication' =>
                        $validated[
                            'communication'
                        ],

                    'professionalism' =>
                        $validated[
                            'professionalism'
                        ],

                    'technical_competence' =>
                        $validated[
                            'technical_competence'
                        ],

                    'strengths' =>
                        $validated[
                            'strengths'
                        ] ?? null,

                    'areas_for_improvement' =>
                        $validated[
                            'areas_for_improvement'
                        ] ?? null,

                    'final_comments' =>
                        $validated[
                            'final_comments'
                        ] ?? null,

                    'recommendation' =>
                        $validated[
                            'recommendation'
                        ],

                    'evaluated_by' =>
                        $supervisor->id,

                    'evaluated_at' =>
                        now(),
                ]);
            }
        );

        return redirect()
            ->route(
                'supervisor.evaluations.show',
                $assignment
            )
            ->with(
                'success',
                'Final Supervisor Evaluation updated successfully.'
            );
    }

    /**
     * Validate Evaluation input.
     */
    private function validateEvaluation(
        Request $request
    ): array {
        return $request->validate([
            'attendance_reliability' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'work_quality' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'initiative' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'communication' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'professionalism' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'technical_competence' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'strengths' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'areas_for_improvement' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'final_comments' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'recommendation' => [
                'required',

                Rule::in([
                    SupervisorEvaluation::RECOMMENDATION_RECOMMENDED,

                    SupervisorEvaluation::RECOMMENDATION_NEEDS_IMPROVEMENT,
                ]),
            ],
        ]);
    }

    /**
     * Authenticated Supervisor.
     */
    private function supervisor(
        Request $request
    ): User {
        $user =
            $request->user();

        if (
            ! $user instanceof User
            || ! $user->isSupervisor()
        ) {
            abort(403);
        }

        return $user;
    }

    /**
     * Ensure assignment belongs to Supervisor.
     */
    private function authorizeAssignment(
        OjtAssignment $assignment,
        User $supervisor
    ): void {
        if (
            (int) $assignment->supervisor_id
            !==
            (int) $supervisor->id
        ) {
            abort(403);
        }
    }
}