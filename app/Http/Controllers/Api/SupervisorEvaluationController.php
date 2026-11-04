<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\DailyWorkLog;
use App\Models\OjtAssignment;
use App\Models\SupervisorEvaluation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;


class SupervisorEvaluationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Business Timezone
    |--------------------------------------------------------------------------
    */

    private const BUSINESS_TIMEZONE =
        'Asia/Manila';


    /*
    |--------------------------------------------------------------------------
    | Show Evaluation
    |--------------------------------------------------------------------------
    |
    | GET /api/mobile/supervisor/evaluations/{assignment}
    |
    */

    public function show(
        Request $request,
        OjtAssignment $assignment
    ): JsonResponse {
        $supervisor =
            $this->authenticatedSupervisor(
                $request
            );


        if (
            $supervisor
            instanceof JsonResponse
        ) {
            return $supervisor;
        }


        if (
            ! $this->ownsAssignment(
                $assignment,
                $supervisor
            )
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'You are not authorized to evaluate this OJT assignment.',
                ],
                403
            );
        }


        $assignment->load([
            'studentProfile.user',
            'company',
            'finalEvaluation.evaluator',
        ]);


        return response()->json([
            'success' =>
                true,

            'server_time' =>
                now()
                    ->timezone(
                        self::BUSINESS_TIMEZONE
                    )
                    ->toIso8601String(),

            'evaluation_context' =>
                $this->evaluationContext(
                    $assignment
                ),

            'evaluation' =>
                $assignment
                    ->finalEvaluation
                    ? $this->evaluationPayload(
                        $assignment
                            ->finalEvaluation
                    )
                    : null,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Store Evaluation
    |--------------------------------------------------------------------------
    |
    | POST /api/mobile/supervisor/evaluations/{assignment}
    |
    */

    public function store(
        Request $request,
        OjtAssignment $assignment
    ): JsonResponse {
        $supervisor =
            $this->authenticatedSupervisor(
                $request
            );


        if (
            $supervisor
            instanceof JsonResponse
        ) {
            return $supervisor;
        }


        if (
            ! $this->ownsAssignment(
                $assignment,
                $supervisor
            )
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'You are not authorized to evaluate this OJT assignment.',
                ],
                403
            );
        }


        if (
            $assignment->status
            === OjtAssignment::STATUS_CANCELLED
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Cancelled OJT assignments cannot be evaluated.',
                ],
                409
            );
        }


        $validated =
            $this->validateEvaluation(
                $request
            );


        $result =
            DB::transaction(
                function () use (
                    $assignment,
                    $supervisor,
                    $validated
                ): array {

                    /*
                    |--------------------------------------------------------------------------
                    | Lock Assignment
                    |--------------------------------------------------------------------------
                    |
                    | Prevent two evaluation submissions from being created at the same
                    | time for the same Student assignment.
                    |
                    */

                    $lockedAssignment =
                        OjtAssignment::query()
                            ->whereKey(
                                $assignment->id
                            )
                            ->where(
                                'supervisor_id',
                                $supervisor->id
                            )
                            ->lockForUpdate()
                            ->first();


                    if (! $lockedAssignment) {
                        return [
                            'status' =>
                                403,

                            'message' =>
                                'You are not authorized to evaluate this OJT assignment.',

                            'evaluation' =>
                                null,
                        ];
                    }


                    if (
                        $lockedAssignment->status
                        === OjtAssignment::STATUS_CANCELLED
                    ) {
                        return [
                            'status' =>
                                409,

                            'message' =>
                                'Cancelled OJT assignments cannot be evaluated.',

                            'evaluation' =>
                                null,
                        ];
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Evaluation Must Not Already Exist
                    |--------------------------------------------------------------------------
                    */

                    $existingEvaluation =
                        SupervisorEvaluation::query()
                            ->where(
                                'ojt_assignment_id',
                                $lockedAssignment->id
                            )
                            ->first();


                    if ($existingEvaluation) {
                        return [
                            'status' =>
                                409,

                            'message' =>
                                'A Final Evaluation already exists for this Student. Use the update function instead.',

                            'evaluation' =>
                                null,
                        ];
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Create Evaluation
                    |--------------------------------------------------------------------------
                    */

                    $evaluation =
                        SupervisorEvaluation::query()
                            ->create([
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
                                    $this->nullableText(
                                        $validated[
                                            'strengths'
                                        ] ?? null
                                    ),

                                'areas_for_improvement' =>
                                    $this->nullableText(
                                        $validated[
                                            'areas_for_improvement'
                                        ] ?? null
                                    ),

                                'final_comments' =>
                                    $this->nullableText(
                                        $validated[
                                            'final_comments'
                                        ] ?? null
                                    ),

                                'recommendation' =>
                                    $validated[
                                        'recommendation'
                                    ],

                                'evaluated_by' =>
                                    $supervisor->id,

                                'evaluated_at' =>
                                    now(),
                            ]);


                    $evaluation->load(
                        'evaluator'
                    );


                    return [
                        'status' =>
                            201,

                        'message' =>
                            'Final Evaluation submitted successfully.',

                        'evaluation' =>
                            $evaluation,
                    ];
                }
            );


        if (
            ! $result['evaluation']
            instanceof SupervisorEvaluation
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        $result['message'],
                ],
                $result['status']
            );
        }


        return response()->json(
            [
                'success' =>
                    true,

                'message' =>
                    $result['message'],

                'evaluation' =>
                    $this->evaluationPayload(
                        $result[
                            'evaluation'
                        ]
                    ),
            ],
            $result['status']
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Evaluation
    |--------------------------------------------------------------------------
    |
    | PUT /api/mobile/supervisor/evaluations/{assignment}
    |
    */

    public function update(
        Request $request,
        OjtAssignment $assignment
    ): JsonResponse {
        $supervisor =
            $this->authenticatedSupervisor(
                $request
            );


        if (
            $supervisor
            instanceof JsonResponse
        ) {
            return $supervisor;
        }


        if (
            ! $this->ownsAssignment(
                $assignment,
                $supervisor
            )
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'You are not authorized to update this Final Evaluation.',
                ],
                403
            );
        }


        if (
            $assignment->status
            === OjtAssignment::STATUS_CANCELLED
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Cancelled OJT assignments cannot be evaluated.',
                ],
                409
            );
        }


        $validated =
            $this->validateEvaluation(
                $request
            );


        $result =
            DB::transaction(
                function () use (
                    $assignment,
                    $supervisor,
                    $validated
                ): array {

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
                            ->where(
                                'supervisor_id',
                                $supervisor->id
                            )
                            ->lockForUpdate()
                            ->first();


                    if (! $lockedAssignment) {
                        return [
                            'status' =>
                                403,

                            'message' =>
                                'You are not authorized to update this Final Evaluation.',

                            'evaluation' =>
                                null,
                        ];
                    }


                    if (
                        $lockedAssignment->status
                        === OjtAssignment::STATUS_CANCELLED
                    ) {
                        return [
                            'status' =>
                                409,

                            'message' =>
                                'Cancelled OJT assignments cannot be evaluated.',

                            'evaluation' =>
                                null,
                        ];
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Lock Evaluation
                    |--------------------------------------------------------------------------
                    */

                    $evaluation =
                        SupervisorEvaluation::query()
                            ->where(
                                'ojt_assignment_id',
                                $lockedAssignment->id
                            )
                            ->lockForUpdate()
                            ->first();


                    if (! $evaluation) {
                        return [
                            'status' =>
                                404,

                            'message' =>
                                'No Final Evaluation exists for this Student yet.',

                            'evaluation' =>
                                null,
                        ];
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Update Evaluation
                    |--------------------------------------------------------------------------
                    */

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
                            $this->nullableText(
                                $validated[
                                    'strengths'
                                ] ?? null
                            ),

                        'areas_for_improvement' =>
                            $this->nullableText(
                                $validated[
                                    'areas_for_improvement'
                                ] ?? null
                            ),

                        'final_comments' =>
                            $this->nullableText(
                                $validated[
                                    'final_comments'
                                ] ?? null
                            ),

                        'recommendation' =>
                            $validated[
                                'recommendation'
                            ],

                        'evaluated_by' =>
                            $supervisor->id,

                        'evaluated_at' =>
                            now(),
                    ]);


                    $evaluation->load(
                        'evaluator'
                    );


                    return [
                        'status' =>
                            200,

                        'message' =>
                            'Final Evaluation updated successfully.',

                        'evaluation' =>
                            $evaluation,
                    ];
                }
            );


        if (
            ! $result['evaluation']
            instanceof SupervisorEvaluation
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        $result['message'],
                ],
                $result['status']
            );
        }


        return response()->json([
            'success' =>
                true,

            'message' =>
                $result['message'],

            'evaluation' =>
                $this->evaluationPayload(
                    $result[
                        'evaluation'
                    ]
                ),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Supervisor Authentication
    |--------------------------------------------------------------------------
    */

    private function authenticatedSupervisor(
        Request $request
    ): User|JsonResponse {
        $user =
            $request->user();


        if (
            ! $user
            instanceof User
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Unauthenticated.',
                ],
                401
            );
        }


        if (
            ! $user->isSupervisor()
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Supervisor access only.',
                ],
                403
            );
        }


        if (
            ! $user->isActive()
            ||
            $user->isArchived()
        ) {
            $currentAccessToken =
                $user
                    ->currentAccessToken();


            if (
                $currentAccessToken
                instanceof PersonalAccessToken
            ) {
                $currentAccessToken
                    ->delete();
            }


            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'This account is currently unavailable.',
                ],
                403
            );
        }


        return $user;
    }


    /*
    |--------------------------------------------------------------------------
    | Assignment Ownership
    |--------------------------------------------------------------------------
    */

    private function ownsAssignment(
        OjtAssignment $assignment,
        User $supervisor
    ): bool {
        return (
            (int) $assignment
                ->supervisor_id
            ===
            (int) $supervisor->id
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Evaluation Validation
    |--------------------------------------------------------------------------
    */

    private function validateEvaluation(
        Request $request
    ): array {
        return $request->validate([
            /*
            |--------------------------------------------------------------------------
            | Rating Criteria
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | Written Feedback
            |--------------------------------------------------------------------------
            */

            'strengths' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'areas_for_improvement' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'final_comments' => [
                'nullable',
                'string',
                'max:5000',
            ],


            /*
            |--------------------------------------------------------------------------
            | Recommendation
            |--------------------------------------------------------------------------
            */

            'recommendation' => [
                'required',
                Rule::in([
                    SupervisorEvaluation::RECOMMENDATION_RECOMMENDED,
                    SupervisorEvaluation::RECOMMENDATION_NEEDS_IMPROVEMENT,
                ]),
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Evaluation Context
    |--------------------------------------------------------------------------
    |
    | Gives the mobile app useful Student progress information before the
    | Supervisor makes the final evaluation.
    |
    */

    private function evaluationContext(
        OjtAssignment $assignment
    ): array {
        $assignment->loadMissing([
            'studentProfile.user',
            'company',
        ]);


        $profile =
            $assignment
                ->studentProfile;


        $student =
            $profile
                ?->user;


        $company =
            $assignment
                ->company;


        /*
        |--------------------------------------------------------------------------
        | Validated Attendance Minutes
        |--------------------------------------------------------------------------
        */

        $validatedMinutes =
            (int) AttendanceRecord::query()
                ->where(
                    'ojt_assignment_id',
                    $assignment->id
                )
                ->where(
                    'status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->sum(
                    'rendered_minutes'
                );


        /*
        |--------------------------------------------------------------------------
        | Hours Progress
        |--------------------------------------------------------------------------
        */

        $requiredHours =
            max(
                0,
                (int) (
                    $assignment
                        ->required_hours
                    ?? 0
                )
            );


        $requiredMinutes =
            $requiredHours
            *
            60;


        $remainingMinutes =
            max(
                0,
                $requiredMinutes
                -
                $validatedMinutes
            );


        $progress =
            $requiredMinutes >
            0
                ? min(
                    100,
                    round(
                        (
                            $validatedMinutes
                            /
                            $requiredMinutes
                        )
                        *
                        100,
                        1
                    )
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | Attendance Counts
        |--------------------------------------------------------------------------
        */

        $attendanceBase =
            AttendanceRecord::query()
                ->where(
                    'ojt_assignment_id',
                    $assignment->id
                );


        $attendanceSummary = [
            'total' =>
                (clone $attendanceBase)
                    ->count(),

            'pending' =>
                (clone $attendanceBase)
                    ->where(
                        'status',
                        AttendanceRecord::STATUS_PENDING
                    )
                    ->count(),

            'validated' =>
                (clone $attendanceBase)
                    ->where(
                        'status',
                        AttendanceRecord::STATUS_VALIDATED
                    )
                    ->count(),

            'rejected' =>
                (clone $attendanceBase)
                    ->where(
                        'status',
                        AttendanceRecord::STATUS_REJECTED
                    )
                    ->count(),
        ];


        /*
        |--------------------------------------------------------------------------
        | Work Log Counts
        |--------------------------------------------------------------------------
        */

        $workLogBase =
            DailyWorkLog::query()
                ->whereHas(
                    'attendanceRecord',
                    function ($query) use (
                        $assignment
                    ): void {
                        $query->where(
                            'ojt_assignment_id',
                            $assignment->id
                        );
                    }
                );


        $workLogSummary = [
            'total' =>
                (clone $workLogBase)
                    ->count(),

            'pending' =>
                (clone $workLogBase)
                    ->where(
                        'status',
                        DailyWorkLog::STATUS_PENDING
                    )
                    ->count(),

            'validated' =>
                (clone $workLogBase)
                    ->where(
                        'status',
                        DailyWorkLog::STATUS_VALIDATED
                    )
                    ->count(),

            'rejected' =>
                (clone $workLogBase)
                    ->where(
                        'status',
                        DailyWorkLog::STATUS_REJECTED
                    )
                    ->count(),
        ];


        return [
            /*
            |--------------------------------------------------------------------------
            | Student
            |--------------------------------------------------------------------------
            */

            'student' => [
                'id' =>
                    $student?->id,

                'name' =>
                    $student?->name,

                'email' =>
                    $student?->email,

                'student_number' =>
                    $profile
                        ?->student_number,

                'program' =>
                    $profile
                        ?->program,

                'year_level' =>
                    $profile
                        ?->year_level,

                'section' =>
                    $profile
                        ?->section,
            ],


            /*
            |--------------------------------------------------------------------------
            | Assignment
            |--------------------------------------------------------------------------
            */

            'assignment' => [
                'id' =>
                    $assignment->id,

                'status' =>
                    $assignment->status,

                'required_hours' =>
                    $requiredHours,

                'start_date' =>
                    $assignment
                        ->start_date
                        ?->format(
                            'Y-m-d'
                        ),

                'end_date' =>
                    $assignment
                        ->end_date
                        ?->format(
                            'Y-m-d'
                        ),
            ],


            /*
            |--------------------------------------------------------------------------
            | Company
            |--------------------------------------------------------------------------
            */

            'company' => [
                'id' =>
                    $company?->id,

                'name' =>
                    $company?->name,

                'address' =>
                    $company?->address,
            ],


            /*
            |--------------------------------------------------------------------------
            | Progress
            |--------------------------------------------------------------------------
            */

            'progress' => [
                'required_hours' =>
                    $requiredHours,

                'validated_minutes' =>
                    $validatedMinutes,

                'validated_hours_label' =>
                    $this->minutesLabel(
                        $validatedMinutes
                    ),

                'remaining_minutes' =>
                    $remainingMinutes,

                'remaining_hours_label' =>
                    $this->minutesLabel(
                        $remainingMinutes
                    ),

                'percentage' =>
                    $progress,
            ],


            /*
            |--------------------------------------------------------------------------
            | Record Summary
            |--------------------------------------------------------------------------
            */

            'attendance' =>
                $attendanceSummary,

            'work_logs' =>
                $workLogSummary,


            /*
            |--------------------------------------------------------------------------
            | Evaluation Availability
            |--------------------------------------------------------------------------
            */

            'can_evaluate' =>
                $assignment->status
                !==
                OjtAssignment::STATUS_CANCELLED,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Evaluation JSON
    |--------------------------------------------------------------------------
    */

    private function evaluationPayload(
        SupervisorEvaluation $evaluation
    ): array {
        $evaluation->loadMissing(
            'evaluator'
        );


        return [
            'id' =>
                $evaluation->id,

            'ojt_assignment_id' =>
                $evaluation
                    ->ojt_assignment_id,


            /*
            |--------------------------------------------------------------------------
            | Ratings
            |--------------------------------------------------------------------------
            */

            'ratings' => [
                'attendance_reliability' =>
                    $evaluation
                        ->attendance_reliability,

                'work_quality' =>
                    $evaluation
                        ->work_quality,

                'initiative' =>
                    $evaluation
                        ->initiative,

                'communication' =>
                    $evaluation
                        ->communication,

                'professionalism' =>
                    $evaluation
                        ->professionalism,

                'technical_competence' =>
                    $evaluation
                        ->technical_competence,
            ],


            /*
            |--------------------------------------------------------------------------
            | Computed Result
            |--------------------------------------------------------------------------
            */

            'overall_rating' =>
                $evaluation
                    ->overallRating(),

            'rating_label' =>
                $evaluation
                    ->ratingLabel(),


            /*
            |--------------------------------------------------------------------------
            | Written Feedback
            |--------------------------------------------------------------------------
            */

            'strengths' =>
                $evaluation
                    ->strengths,

            'areas_for_improvement' =>
                $evaluation
                    ->areas_for_improvement,

            'final_comments' =>
                $evaluation
                    ->final_comments,


            /*
            |--------------------------------------------------------------------------
            | Recommendation
            |--------------------------------------------------------------------------
            */

            'recommendation' =>
                $evaluation
                    ->recommendation,

            'recommendation_label' =>
                $evaluation
                    ->recommendationLabel(),


            /*
            |--------------------------------------------------------------------------
            | Evaluator
            |--------------------------------------------------------------------------
            */

            'evaluator' =>
                $evaluation
                    ->evaluator
                    ? [
                        'id' =>
                            $evaluation
                                ->evaluator
                                ->id,

                        'name' =>
                            $evaluation
                                ->evaluator
                                ->name,
                    ]
                    : null,


            /*
            |--------------------------------------------------------------------------
            | Time
            |--------------------------------------------------------------------------
            */

            'evaluated_at' =>
                $evaluation
                    ->evaluated_at
                    ?->setTimezone(
                        self::BUSINESS_TIMEZONE
                    )
                    ->toIso8601String(),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Nullable Text
    |--------------------------------------------------------------------------
    */

    private function nullableText(
        mixed $value
    ): ?string {
        if (
            ! is_string(
                $value
            )
        ) {
            return null;
        }


        $value =
            trim(
                $value
            );


        return $value !== ''
            ? $value
            : null;
    }


    /*
    |--------------------------------------------------------------------------
    | Minutes Label
    |--------------------------------------------------------------------------
    */

    private function minutesLabel(
        int $minutes
    ): string {
        $minutes =
            max(
                0,
                $minutes
            );


        $hours =
            intdiv(
                $minutes,
                60
            );


        $remainingMinutes =
            $minutes
            %
            60;


        return sprintf(
            '%dh %02dm',
            $hours,
            $remainingMinutes
        );
    }
}