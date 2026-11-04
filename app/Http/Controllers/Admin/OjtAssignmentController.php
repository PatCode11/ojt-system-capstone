<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\Company;
use App\Models\OjtAssignment;
use App\Models\StudentProfile;
use App\Models\User;
use App\Services\OjtAssignmentCompletionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OjtAssignmentController extends Controller
{
    /**
     * Display all OJT assignments.
     */
    public function index(): View
    {
        $assignments = OjtAssignment::query()
            ->with([
                'studentProfile.user',
                'company',
                'supervisor',
                'completedBy',
            ])
            ->latest('start_date')
            ->latest('id')
            ->paginate(15);

        return view(
            'admin.assignments.index',
            compact('assignments')
        );
    }

    /**
     * Display the bulk assignment creation form.
     */
    public function create(): View
    {
        $students = StudentProfile::query()
            ->with('user')
            ->whereHas('user', function ($query): void {
                $query
                    ->where('role', User::ROLE_STUDENT)
                    ->where('status', User::STATUS_ACTIVE);
            })
            ->get()
            ->sortBy(
                fn (StudentProfile $profile) =>
                    mb_strtolower($profile->user->name)
            )
            ->values();

        $companies = Company::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $supervisors = User::query()
            ->where('role', User::ROLE_SUPERVISOR)
            ->where('status', User::STATUS_ACTIVE)
            ->orderBy('name')
            ->get();

        /*
         * Students with pending or active assignments
         * will appear but cannot be selected in the form.
         */
        $assignedStudentIds = OjtAssignment::query()
            ->whereIn(
                'status',
                OjtAssignment::OPEN_STATUSES
            )
            ->distinct()
            ->pluck('student_profile_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        return view(
            'admin.assignments.create',
            compact(
                'students',
                'companies',
                'supervisors',
                'assignedStudentIds'
            )
        );
    }

    /**
     * Create a separate assignment for each selected student.
     */
    public function store(Request $request): RedirectResponse
    {
        /*
         * Allow older single-student submissions for compatibility.
         */
        if (
            ! $request->has('student_profile_ids')
            && $request->filled('student_profile_id')
        ) {
            $request->merge([
                'student_profile_ids' => [
                    $request->input('student_profile_id'),
                ],
            ]);
        }

        $validated = $this->validateStore($request);

        $studentIds = collect(
            $validated['student_profile_ids']
        )
            ->map(fn ($id) => (int) $id)
            ->sort()
            ->values()
            ->all();

        /*
         * Create all assignments in a single transaction.
         * If any student fails validation, no assignment
         * from this submission will be created.
         */
        $createdIds = DB::transaction(
            function () use ($studentIds, $validated): array {
                $profiles = StudentProfile::query()
                    ->with('user')
                    ->whereIn('id', $studentIds)
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                /*
                 * Verify every selected student.
                 */
                foreach ($studentIds as $studentId) {
                    $profile = $profiles->get($studentId);

                    if (
                        ! $profile
                        || ! $profile->user
                        || $profile->user->role
                            !== User::ROLE_STUDENT
                        || $profile->user->status
                            !== User::STATUS_ACTIVE
                    ) {
                        throw ValidationException::withMessages([
                            'student_profile_ids' =>
                                'One or more selected students are not active. Refresh the page and try again.',
                        ]);
                    }
                }

                /*
                 * Validate company, supervisor, and
                 * the first student with existing rules.
                 */
                $this->ensureParticipantsAvailable([
                    'student_profile_id' => $studentIds[0],
                    'company_id' => $validated['company_id'],
                    'supervisor_id' => $validated['supervisor_id'],
                ]);

                /*
                 * Prevent conflicting open assignments.
                 */
                $conflictingIds = OjtAssignment::query()
                    ->whereIn(
                        'student_profile_id',
                        $studentIds
                    )
                    ->whereIn(
                        'status',
                        OjtAssignment::OPEN_STATUSES
                    )
                    ->pluck('student_profile_id')
                    ->unique();

                if ($conflictingIds->isNotEmpty()) {
                    $names = $conflictingIds
                        ->map(
                            fn ($id) =>
                                $profiles->get((int) $id)
                                    ?->user?->name
                                ?? 'Student #' . $id
                        )
                        ->take(5)
                        ->implode(', ');

                    throw ValidationException::withMessages([
                        'student_profile_ids' =>
                            'These students already have a pending or active OJT Assignment: '
                            . $names
                            . '. No assignments were created.',
                    ]);
                }

                /*
                 * Common placement details for all students.
                 */
                $commonDetails = $validated;

                unset(
                    $commonDetails['student_profile_ids']
                );

                $createdIds = [];

                /*
                 * Create one assignment per student.
                 */
                foreach ($studentIds as $studentId) {
                    $assignment = OjtAssignment::create(
                        array_merge(
                            $commonDetails,
                            [
                                'student_profile_id' =>
                                    $studentId,
                            ]
                        )
                    );

                    $createdIds[] = $assignment->id;
                }

                return $createdIds;
            },
            3
        );

        /*
         * Redirect to the single assignment if only
         * one student was selected.
         */
        if (count($createdIds) === 1) {
            return redirect()
                ->route(
                    'admin.assignments.show',
                    $createdIds[0]
                )
                ->with(
                    'success',
                    'OJT Assignment created successfully.'
                );
        }

        /*
         * Redirect to the list for bulk assignments.
         */
        return redirect()
            ->route('admin.assignments.index')
            ->with(
                'success',
                count($createdIds)
                . ' OJT Assignments created successfully.'
            );
    }

    /**
     * Display an individual OJT assignment.
     */
    public function show(
        OjtAssignment $assignment,
        OjtAssignmentCompletionService $completionService
    ): View {
        $assignment->load([
            'studentProfile.user',
            'company',
            'supervisor',
            'completedBy',
        ]);

        $completionSummary =
            $completionService->summary($assignment);

        return view(
            'admin.assignments.show',
            compact(
                'assignment',
                'completionSummary'
            )
        );
    }

    /**
     * Display the single-assignment edit form.
     */
    public function edit(
        OjtAssignment $assignment
    ): View|RedirectResponse {
        if (
            $assignment->status
            === OjtAssignment::STATUS_COMPLETED
        ) {
            return redirect()
                ->route(
                    'admin.assignments.show',
                    $assignment
                )
                ->with(
                    'error',
                    'Completed OJT Assignments are locked and can no longer be edited.'
                );
        }

        /*
         * Include the existing student even if their
         * account has since become inactive.
         */
        $students = StudentProfile::query()
            ->with('user')
            ->where(
                function ($query) use ($assignment): void {
                    $query
                        ->whereHas(
                            'user',
                            function ($userQuery): void {
                                $userQuery
                                    ->where(
                                        'role',
                                        User::ROLE_STUDENT
                                    )
                                    ->where(
                                        'status',
                                        User::STATUS_ACTIVE
                                    );
                            }
                        )
                        ->orWhere(
                            'student_profiles.id',
                            $assignment->student_profile_id
                        );
                }
            )
            ->get()
            ->sortBy(
                fn (StudentProfile $profile) =>
                    mb_strtolower(
                        $profile->user->name
                    )
            )
            ->values();

        /*
         * Include active companies and the current company.
         */
        $companies = Company::query()
            ->where(
                function ($query) use ($assignment): void {
                    $query
                        ->where(
                            'companies.status',
                            'active'
                        )
                        ->orWhere(
                            'companies.id',
                            $assignment->company_id
                        );
                }
            )
            ->orderBy('name')
            ->get();

        /*
         * Include active supervisors and the current supervisor.
         */
        $supervisors = User::query()
            ->where(
                'role',
                User::ROLE_SUPERVISOR
            )
            ->where(
                function ($query) use ($assignment): void {
                    $query
                        ->where(
                            'users.status',
                            User::STATUS_ACTIVE
                        )
                        ->orWhere(
                            'users.id',
                            $assignment->supervisor_id
                        );
                }
            )
            ->orderBy('name')
            ->get();

        return view(
            'admin.assignments.edit',
            compact(
                'assignment',
                'students',
                'companies',
                'supervisors'
            )
        );
    }

    /**
     * Update an individual OJT assignment.
     */
    public function update(
        Request $request,
        OjtAssignment $assignment
    ): RedirectResponse {
        if (
            $assignment->status
            === OjtAssignment::STATUS_COMPLETED
        ) {
            return redirect()
                ->route(
                    'admin.assignments.show',
                    $assignment
                )
                ->with(
                    'error',
                    'Completed OJT Assignments cannot be modified.'
                );
        }

        $validated =
            $this->validateUpdate($request);

        /*
         * Active assignments require valid participants
         * and cannot conflict with another open assignment.
         */
        if (
            in_array(
                $validated['status'],
                OjtAssignment::OPEN_STATUSES,
                true
            )
        ) {
            $this->ensureParticipantsAvailable(
                $validated
            );

            $this->preventConflictingAssignment(
                (int) $validated['student_profile_id'],
                $assignment->id
            );
        }

        /*
         * Prevent cancellation if attendance is unresolved.
         */
        if (
            $validated['status']
            === OjtAssignment::STATUS_CANCELLED
        ) {
            $hasUnresolvedAttendance =
                $assignment
                    ->attendanceRecords()
                    ->whereIn(
                        'attendance_records.status',
                        [
                            AttendanceRecord::STATUS_IN_PROGRESS,
                            AttendanceRecord::STATUS_PENDING,
                        ]
                    )
                    ->exists();

            if ($hasUnresolvedAttendance) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'This assignment has attendance records that are still in progress or pending validation. Resolve them before cancelling the assignment.'
                    );
            }
        }

        $assignment->update($validated);

        return redirect()
            ->route(
                'admin.assignments.show',
                $assignment
            )
            ->with(
                'success',
                'OJT Assignment updated successfully.'
            );
    }

    /**
     * Formally complete an eligible OJT assignment.
     */
    public function complete(
        Request $request,
        OjtAssignment $assignment,
        OjtAssignmentCompletionService $completionService
    ): RedirectResponse {
        $admin = $request->user();

        if (
            ! $admin instanceof User
            || ! $admin->isAdmin()
        ) {
            abort(403);
        }

        $validated = $request->validate([
            'completion_remarks' => [
                'nullable',
                'string',
                'max:3000',
            ],
        ]);

        DB::transaction(
            function () use (
                $assignment,
                $admin,
                $validated,
                $completionService
            ): void {
                $lockedAssignment = OjtAssignment::query()
                    ->whereKey($assignment->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $summary =
                    $completionService->summary(
                        $lockedAssignment
                    );

                if (! $summary['eligible']) {
                    throw ValidationException::withMessages([
                        'completion' =>
                            implode(
                                ' ',
                                $summary['blockers']
                            ),
                    ]);
                }

                $lockedAssignment->update([
                    'status' =>
                        OjtAssignment::STATUS_COMPLETED,

                    'completed_by' =>
                        $admin->id,

                    'completed_at' =>
                        now(),

                    'completion_remarks' =>
                        $validated[
                            'completion_remarks'
                        ] ?? null,
                ]);
            }
        );

        return redirect()
            ->route(
                'admin.assignments.show',
                $assignment
            )
            ->with(
                'success',
                'OJT Assignment formally completed successfully.'
            );
    }

    /**
     * Display printable OJT completion summary.
     */
    public function completionSummary(
        OjtAssignment $assignment,
        OjtAssignmentCompletionService $completionService
    ): View {
        $assignment->load([
            'studentProfile.user',
            'company',
            'supervisor',
            'completedBy',
        ]);

        $attendanceRecords =
            $assignment
                ->attendanceRecords()
                ->with([
                    'dailyWorkLog.validator',
                    'validator',
                ])
                ->orderBy('attendance_date')
                ->get();

        $completionSummary =
            $completionService->summary(
                $assignment
            );

        return view(
            'admin.assignments.completion-summary',
            compact(
                'assignment',
                'attendanceRecords',
                'completionSummary'
            )
        );
    }

    /**
     * Validate bulk assignment creation.
     */
    private function validateStore(
        Request $request
    ): array {
        return $request->validate([
            'student_profile_ids' => [
                'required',
                'array',
                'min:1',
                'max:500',
            ],

            'student_profile_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:student_profiles,id',
            ],

            'company_id' => [
                'required',
                'integer',
                'exists:companies,id',
            ],

            'supervisor_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'required_hours' => [
                'required',
                'integer',
                'min:1',
                'max:5000',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'status' => [
                'required',
                Rule::in([
                    OjtAssignment::STATUS_PENDING,
                    OjtAssignment::STATUS_ACTIVE,
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);
    }

    /**
     * Validate individual assignment editing.
     */
    private function validateUpdate(
        Request $request
    ): array {
        return $request->validate([
            'student_profile_id' => [
                'required',
                'integer',
                'exists:student_profiles,id',
            ],

            'company_id' => [
                'required',
                'integer',
                'exists:companies,id',
            ],

            'supervisor_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'required_hours' => [
                'required',
                'integer',
                'min:1',
                'max:5000',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'status' => [
                'required',
                Rule::in([
                    OjtAssignment::STATUS_PENDING,
                    OjtAssignment::STATUS_ACTIVE,
                    OjtAssignment::STATUS_CANCELLED,
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);
    }

    /**
     * Check Student, Company, and Supervisor availability.
     */
    private function ensureParticipantsAvailable(
        array $validated
    ): void {
        $studentAvailable = StudentProfile::query()
            ->whereKey(
                $validated['student_profile_id']
            )
            ->whereHas(
                'user',
                function ($query): void {
                    $query
                        ->where(
                            'role',
                            User::ROLE_STUDENT
                        )
                        ->where(
                            'status',
                            User::STATUS_ACTIVE
                        );
                }
            )
            ->exists();

        if (! $studentAvailable) {
            throw ValidationException::withMessages([
                'student_profile_id' =>
                    'The selected Student account is not active.',
            ]);
        }

        $companyAvailable = Company::query()
            ->whereKey(
                $validated['company_id']
            )
            ->where('status', 'active')
            ->exists();

        if (! $companyAvailable) {
            throw ValidationException::withMessages([
                'company_id' =>
                    'The selected Company is not active.',
            ]);
        }

        $supervisorAvailable = User::query()
            ->whereKey(
                $validated['supervisor_id']
            )
            ->where(
                'role',
                User::ROLE_SUPERVISOR
            )
            ->where(
                'status',
                User::STATUS_ACTIVE
            )
            ->exists();

        if (! $supervisorAvailable) {
            throw ValidationException::withMessages([
                'supervisor_id' =>
                    'The selected Supervisor account is not active.',
            ]);
        }
    }

    /**
     * Prevent more than one pending or active assignment
     * for the same student.
     */
    private function preventConflictingAssignment(
        int $studentProfileId,
        ?int $ignoreAssignmentId = null
    ): void {
        $query = OjtAssignment::query()
            ->where(
                'student_profile_id',
                $studentProfileId
            )
            ->whereIn(
                'status',
                OjtAssignment::OPEN_STATUSES
            );

        if ($ignoreAssignmentId !== null) {
            $query->where(
                'id',
                '!=',
                $ignoreAssignmentId
            );
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'student_profile_id' =>
                    'This Student already has a pending or active OJT Assignment.',
            ]);
        }
    }
}