<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\Company;
use App\Models\DailyWorkLog;
use App\Models\OjtAssignment;
use App\Models\SupervisorEvaluation;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display the Administrator Report Center.
     */
    public function index(
        Request $request
    ): View {
        $filters =
            $this->validateFilters(
                $request
            );

        /*
        |--------------------------------------------------------------------------
        | Companies For Filter Dropdown
        |--------------------------------------------------------------------------
        */

        $companies =
            Company::query()
                ->orderBy('name')
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Assignment Query
        |--------------------------------------------------------------------------
        */

        $assignmentQuery =
            $this->assignmentQuery(
                $filters
            );

        /*
        |--------------------------------------------------------------------------
        | Paginated Assignment Report
        |--------------------------------------------------------------------------
        */

        $assignments =
            (clone $assignmentQuery)
                ->with([
                    'studentProfile.user',
                    'company',
                    'supervisor',
                    'finalEvaluation.evaluator',
                ])
                ->withCount([
                    'attendanceRecords as validated_attendance_count' =>
                        function ($query): void {
                            $query->where(
                                'attendance_records.status',
                                AttendanceRecord::STATUS_VALIDATED
                            );
                        },

                    'attendanceRecords as pending_attendance_count' =>
                        function ($query): void {
                            $query->where(
                                'attendance_records.status',
                                AttendanceRecord::STATUS_PENDING
                            );
                        },

                    'dailyWorkLogs as validated_work_logs_count' =>
                        function ($query): void {
                            $query->where(
                                'daily_work_logs.status',
                                DailyWorkLog::STATUS_VALIDATED
                            );
                        },

                    'dailyWorkLogs as pending_work_logs_count' =>
                        function ($query): void {
                            $query->where(
                                'daily_work_logs.status',
                                DailyWorkLog::STATUS_PENDING
                            );
                        },
                ])
                ->withSum(
                    [
                        'attendanceRecords as validated_minutes_sum' =>
                            function ($query): void {
                                $query->where(
                                    'attendance_records.status',
                                    AttendanceRecord::STATUS_VALIDATED
                                );
                            },
                    ],
                    'rendered_minutes'
                )
                ->latest('start_date')
                ->latest('id')
                ->paginate(15)
                ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | General Statistics
        |--------------------------------------------------------------------------
        */

        $assignmentCount =
            (clone $assignmentQuery)
                ->count();

        $studentCount =
            (clone $assignmentQuery)
                ->distinct()
                ->count(
                    'student_profile_id'
                );

        $activeAssignmentCount =
            (clone $assignmentQuery)
                ->where(
                    'ojt_assignments.status',
                    OjtAssignment::STATUS_ACTIVE
                )
                ->count();

        $completedAssignmentCount =
            (clone $assignmentQuery)
                ->where(
                    'ojt_assignments.status',
                    OjtAssignment::STATUS_COMPLETED
                )
                ->count();

        /*
        |--------------------------------------------------------------------------
        | Attendance Statistics
        |--------------------------------------------------------------------------
        */

        $attendanceQuery =
            AttendanceRecord::query()
                ->whereHas(
                    'ojtAssignment',
                    function (Builder $query) use ($filters): void {
                        $this->applyFilters(
                            $query,
                            $filters
                        );
                    }
                );

        $totalValidatedMinutes =
            (int) (clone $attendanceQuery)
                ->where(
                    'attendance_records.status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->sum(
                    'rendered_minutes'
                );

        $pendingAttendanceCount =
            (clone $attendanceQuery)
                ->where(
                    'attendance_records.status',
                    AttendanceRecord::STATUS_PENDING
                )
                ->count();

        /*
        |--------------------------------------------------------------------------
        | Work Log Statistics
        |--------------------------------------------------------------------------
        */

        $workLogQuery =
            DailyWorkLog::query()
                ->whereHas(
                    'attendanceRecord.ojtAssignment',
                    function (Builder $query) use ($filters): void {
                        $this->applyFilters(
                            $query,
                            $filters
                        );
                    }
                );

        $pendingWorkLogCount =
            (clone $workLogQuery)
                ->where(
                    'daily_work_logs.status',
                    DailyWorkLog::STATUS_PENDING
                )
                ->count();

        /*
        |--------------------------------------------------------------------------
        | Evaluation Statistics
        |--------------------------------------------------------------------------
        */

        $evaluationQuery =
            SupervisorEvaluation::query()
                ->whereHas(
                    'ojtAssignment',
                    function (Builder $query) use ($filters): void {
                        $this->applyFilters(
                            $query,
                            $filters
                        );
                    }
                );

        $evaluationCount =
            (clone $evaluationQuery)
                ->count();

        $averageEvaluationRating =
            $this->averageEvaluationRating(
                $evaluationQuery,
                $evaluationCount
            );

        $validatedHoursLabel =
            $this->formatMinutes(
                $totalValidatedMinutes
            );

        return view(
            'admin.reports.index',
            compact(
                'companies',
                'filters',
                'assignments',
                'assignmentCount',
                'studentCount',
                'activeAssignmentCount',
                'completedAssignmentCount',
                'totalValidatedMinutes',
                'validatedHoursLabel',
                'pendingAttendanceCount',
                'pendingWorkLogCount',
                'evaluationCount',
                'averageEvaluationRating'
            )
        );
    }

    /**
     * Display a printer-friendly report.
     */
    public function print(
        Request $request
    ): View {
        $filters =
            $this->validateFilters(
                $request
            );

        $assignments =
            $this->assignmentQuery(
                $filters
            )
                ->with([
                    'studentProfile.user',
                    'company',
                    'supervisor',
                    'finalEvaluation.evaluator',
                ])
                ->withCount([
                    'attendanceRecords as validated_attendance_count' =>
                        function ($query): void {
                            $query->where(
                                'attendance_records.status',
                                AttendanceRecord::STATUS_VALIDATED
                            );
                        },

                    'dailyWorkLogs as validated_work_logs_count' =>
                        function ($query): void {
                            $query->where(
                                'daily_work_logs.status',
                                DailyWorkLog::STATUS_VALIDATED
                            );
                        },
                ])
                ->withSum(
                    [
                        'attendanceRecords as validated_minutes_sum' =>
                            function ($query): void {
                                $query->where(
                                    'attendance_records.status',
                                    AttendanceRecord::STATUS_VALIDATED
                                );
                            },
                    ],
                    'rendered_minutes'
                )
                ->latest('start_date')
                ->latest('id')
                ->get();

        $totalValidatedMinutes =
            (int) $assignments->sum(
                fn (OjtAssignment $assignment) =>
                    (int) (
                        $assignment
                            ->validated_minutes_sum
                        ?? 0
                    )
            );

        $validatedHoursLabel =
            $this->formatMinutes(
                $totalValidatedMinutes
            );

        return view(
            'admin.reports.print',
            compact(
                'assignments',
                'filters',
                'validatedHoursLabel'
            )
        );
    }

    /**
     * Export the report as an Excel-compatible CSV file.
     */
    public function exportCsv(
        Request $request
    ): StreamedResponse {
        $filters =
            $this->validateFilters(
                $request
            );

        $assignments =
            $this->assignmentQuery(
                $filters
            )
                ->with([
                    'studentProfile.user',
                    'company',
                    'supervisor',
                    'finalEvaluation',
                ])
                ->withSum(
                    [
                        'attendanceRecords as validated_minutes_sum' =>
                            function ($query): void {
                            $query->where(
                                'attendance_records.status',
                                AttendanceRecord::STATUS_VALIDATED
                            );
                        },
                    ],
                    'rendered_minutes'
                )
                ->latest('start_date')
                ->latest('id')
                ->get();

        $fileName =
            'ojt-sync-report-'
            . now()->format(
                'Y-m-d-His'
            )
            . '.csv';

        return response()->streamDownload(
            function () use ($assignments): void {
                $handle =
                    fopen(
                        'php://output',
                        'w'
                    );

                if ($handle === false) {
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | UTF-8 BOM
                |--------------------------------------------------------------------------
                |
                | Helps Microsoft Excel correctly display UTF-8 text.
                |
                */

                fwrite(
                    $handle,
                    "\xEF\xBB\xBF"
                );

                /*
                |--------------------------------------------------------------------------
                | CSV Headers
                |--------------------------------------------------------------------------
                */

                fputcsv(
                    $handle,
                    [
                        'Student Number',
                        'Student Name',
                        'Program',
                        'Company',
                        'Supervisor',
                        'Assignment Status',
                        'Required Hours',
                        'Validated Hours',
                        'Remaining Hours',
                        'Progress Percentage',
                        'Evaluation Rating',
                        'Evaluation Result',
                        'Recommendation',
                        'Start Date',
                        'End Date',
                        'Completed At',
                    ]
                );

                /*
                |--------------------------------------------------------------------------
                | CSV Rows
                |--------------------------------------------------------------------------
                */

                foreach (
                    $assignments
                    as $assignment
                ) {
                    $validatedMinutes =
                        (int) (
                            $assignment
                                ->validated_minutes_sum
                            ?? 0
                        );

                    $requiredMinutes =
                        (int) $assignment
                            ->required_hours
                        * 60;

                    $remainingMinutes = max(
                        0,
                        $requiredMinutes
                        - $validatedMinutes
                    );

                    $progress =
                        $requiredMinutes > 0
                            ? min(
                                100,
                                round(
                                    (
                                        $validatedMinutes
                                        / $requiredMinutes
                                    )
                                    * 100
                                )
                            )
                            : 0;

                    $evaluation =
                        $assignment
                            ->finalEvaluation;

                    fputcsv(
                        $handle,
                        [
                            $this->csvSafe(
                                $assignment
                                    ->studentProfile
                                    ->student_number
                            ),

                            $this->csvSafe(
                                $assignment
                                    ->studentProfile
                                    ->user
                                    ->name
                            ),

                            $this->csvSafe(
                                $assignment
                                    ->studentProfile
                                    ->program
                            ),

                            $this->csvSafe(
                                $assignment
                                    ->company
                                    ->name
                            ),

                            $this->csvSafe(
                                $assignment
                                    ->supervisor
                                    ->name
                            ),

                            ucfirst(
                                $assignment->status
                            ),

                            $assignment
                                ->required_hours,

                            $this->formatMinutes(
                                $validatedMinutes
                            ),

                            $this->formatMinutes(
                                $remainingMinutes
                            ),

                            $progress . '%',

                            $evaluation
                                ? number_format(
                                    $evaluation
                                        ->overallRating(),
                                    2
                                )
                                : '',

                            $evaluation
                                ? $evaluation
                                    ->ratingLabel()
                                : '',

                            $evaluation
                                ? $evaluation
                                    ->recommendationLabel()
                                : '',

                            $assignment
                                ->start_date
                                ?->format('Y-m-d'),

                            $assignment
                                ->end_date
                                ?->format('Y-m-d'),

                            $assignment
                                ->completed_at
                                ?->timezone(
                                    'Asia/Manila'
                                )
                                ->format(
                                    'Y-m-d H:i:s'
                                ),
                        ]
                    );
                }

                fclose($handle);
            },
            $fileName,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',

                'Cache-Control' =>
                    'private, no-store',
            ]
        );
    }

    /**
     * Build the filtered OJT Assignment query.
     */
    private function assignmentQuery(
        array $filters
    ): Builder {
        $query =
            OjtAssignment::query();

        $this->applyFilters(
            $query,
            $filters
        );

        return $query;
    }

    /**
     * Apply report filters to an OJT Assignment query.
     */
    private function applyFilters(
        Builder $query,
        array $filters
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (
            isset($filters['search'])
            && $filters['search'] !== ''
        ) {
            $search =
                $filters['search'];

            $query->where(
                function (Builder $query) use ($search): void {
                    /*
                    |--------------------------------------------------------------------------
                    | Student Account Name / Email
                    |--------------------------------------------------------------------------
                    */

                    $query
                        ->whereHas(
                            'studentProfile.user',
                            function (Builder $userQuery) use ($search): void {
                                $userQuery
                                    ->where(
                                        'name',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'email',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        )

                        /*
                        |--------------------------------------------------------------------------
                        | Student Number / Program
                        |--------------------------------------------------------------------------
                        */

                        ->orWhereHas(
                            'studentProfile',
                            function (Builder $profileQuery) use ($search): void {
                                $profileQuery
                                    ->where(
                                        'student_number',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'program',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        )

                        /*
                        |--------------------------------------------------------------------------
                        | Company
                        |--------------------------------------------------------------------------
                        */

                        ->orWhereHas(
                            'company',
                            function (Builder $companyQuery) use ($search): void {
                                $companyQuery->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                );
                            }
                        )

                        /*
                        |--------------------------------------------------------------------------
                        | Supervisor
                        |--------------------------------------------------------------------------
                        */

                        ->orWhereHas(
                            'supervisor',
                            function (Builder $supervisorQuery) use ($search): void {
                                $supervisorQuery->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                );
                            }
                        );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Company
        |--------------------------------------------------------------------------
        */

        if (
            isset($filters['company_id'])
            && $filters['company_id']
        ) {
            $query->where(
                'ojt_assignments.company_id',
                $filters['company_id']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Assignment Status
        |--------------------------------------------------------------------------
        */

        if (
            isset($filters['status'])
            && $filters['status'] !== ''
        ) {
            $query->where(
                'ojt_assignments.status',
                $filters['status']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Start Date Range
        |--------------------------------------------------------------------------
        */

        if (
            isset($filters['date_from'])
            && $filters['date_from'] !== ''
        ) {
            $query->whereDate(
                'ojt_assignments.start_date',
                '>=',
                $filters['date_from']
            );
        }

        if (
            isset($filters['date_to'])
            && $filters['date_to'] !== ''
        ) {
            $query->whereDate(
                'ojt_assignments.start_date',
                '<=',
                $filters['date_to']
            );
        }
    }

    /**
     * Validate report filters.
     */
    private function validateFilters(
        Request $request
    ): array {
        /*
        |--------------------------------------------------------------------------
        | Normalize Search
        |--------------------------------------------------------------------------
        */

        $request->merge([
            'search' =>
                trim(
                    (string) $request->input(
                        'search',
                        ''
                    )
                ),
        ]);

        return $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:150',
            ],

            'company_id' => [
                'nullable',
                'integer',
                'exists:companies,id',
            ],

            'status' => [
                'nullable',

                Rule::in([
                    OjtAssignment::STATUS_PENDING,
                    OjtAssignment::STATUS_ACTIVE,
                    OjtAssignment::STATUS_COMPLETED,
                    OjtAssignment::STATUS_CANCELLED,
                ]),
            ],

            'date_from' => [
                'nullable',
                'date',
            ],

            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],
        ]);
    }

    /**
     * Calculate the average Final Evaluation rating.
     */
    private function averageEvaluationRating(
        Builder $evaluationQuery,
        int $evaluationCount
    ): ?float {
        if ($evaluationCount === 0) {
            return null;
        }

        $criteria = [
            'attendance_reliability',
            'work_quality',
            'initiative',
            'communication',
            'professionalism',
            'technical_competence',
        ];

        $totalAverage = 0.0;

        foreach ($criteria as $criterion) {
            $totalAverage +=
                (float) (
                    (clone $evaluationQuery)
                        ->avg($criterion)
                    ?? 0
                );
        }

        return round(
            $totalAverage
            / count($criteria),
            2
        );
    }

    /**
     * Convert rendered minutes into a readable label.
     */
    private function formatMinutes(
        int $minutes
    ): string {
        $hours =
            intdiv(
                $minutes,
                60
            );

        $remainingMinutes =
            $minutes % 60;

        return sprintf(
            '%dh %02dm',
            $hours,
            $remainingMinutes
        );
    }

    /**
     * Protect exported CSV cells against spreadsheet formula injection.
     *
     * Values beginning with =, +, -, or @ may be interpreted by
     * spreadsheet applications as formulas.
     */
    private function csvSafe(
        ?string $value
    ): string {
        $value =
            (string) $value;

        if ($value === '') {
            return '';
        }

        if (
            in_array(
                $value[0],
                [
                    '=',
                    '+',
                    '-',
                    '@',
                ],
                true
            )
        ) {
            return "'"
                . $value;
        }

        return $value;
    }
}