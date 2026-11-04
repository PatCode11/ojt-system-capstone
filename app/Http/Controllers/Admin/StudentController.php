<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OjtAssignment;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StudentController extends Controller
{
    /**
     * Display all non-archived Student accounts.
     */
    public function index(): View
    {
        $students = User::query()
            ->where(
                'role',
                User::ROLE_STUDENT
            )
            ->with([
                'studentProfile.ojtAssignments' =>
                    function ($query): void {
                        $query
                            ->with([
                                'company',
                                'supervisor',
                            ])
                            ->whereIn(
                                'status',
                                OjtAssignment::OPEN_STATUSES
                            )
                            ->latest(
                                'start_date'
                            );
                    },
            ])
            ->latest('id')
            ->paginate(15);

        return view(
            'admin.students.index',
            compact('students')
        );
    }

    /**
     * Display archived Student accounts.
     */
    public function archived(): View
    {
        $students = User::onlyTrashed()
            ->where(
                'role',
                User::ROLE_STUDENT
            )
            ->with([
                'studentProfile.ojtAssignments' =>
                    function ($query): void {
                        $query
                            ->with([
                                'company',
                                'supervisor',
                            ])
                            ->latest(
                                'start_date'
                            );
                    },
            ])
            ->latest('deleted_at')
            ->paginate(15);

        return view(
            'admin.students.archived',
            compact('students')
        );
    }

    /**
     * Show Student creation form.
     */
    public function create(): View
    {
        return view(
            'admin.students.create'
        );
    }

    /**
     * Store a Student account.
     */
    public function store(
        Request $request
    ): RedirectResponse {
        $this->normalizeInput(
            $request
        );

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',

                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],

            'status' => [
                'required',

                Rule::in([
                    User::STATUS_ACTIVE,
                    User::STATUS_INACTIVE,
                ]),
            ],
        ]);

        $student = User::create([
            'name' =>
                $validated['name'],

            'email' =>
                $validated['email'],

            'password' =>
                Hash::make(
                    $validated['password']
                ),

            /*
            |--------------------------------------------------------------------------
            | Role Is Forced Server-Side
            |--------------------------------------------------------------------------
            |
            | Never accept the Student role from the browser.
            |
            */

            'role' =>
                User::ROLE_STUDENT,

            'status' =>
                $validated['status'],
        ]);

        return redirect()
            ->route(
                'admin.students.show',
                $student
            )
            ->with(
                'success',
                'Student account created successfully.'
            );
    }

    /**
     * Display one Student account.
     */
    public function show(
        User $student
    ): View {
        $this->ensureStudent(
            $student
        );

        $student->load([
            'studentProfile.ojtAssignments' =>
                function ($query): void {
                    $query
                        ->with([
                            'company',
                            'supervisor',
                        ])
                        ->latest(
                            'start_date'
                        );
                },
        ]);

        return view(
            'admin.students.show',
            compact('student')
        );
    }

    /**
     * Show Student edit form.
     */
    public function edit(
        User $student
    ): View {
        $this->ensureStudent(
            $student
        );

        return view(
            'admin.students.edit',
            compact('student')
        );
    }

    /**
     * Update Student account.
     */
    public function update(
        Request $request,
        User $student
    ): RedirectResponse {
        $this->ensureStudent(
            $student
        );

        $this->normalizeInput(
            $request
        );

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',

                Rule::unique(
                    'users',
                    'email'
                )->ignore(
                    $student->id
                ),
            ],

            'status' => [
                'required',

                Rule::in([
                    User::STATUS_ACTIVE,
                    User::STATUS_INACTIVE,
                ]),
            ],

            'password' => [
                'nullable',
                'confirmed',

                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Protect Active OJT Workflow
        |--------------------------------------------------------------------------
        |
        | A Student with a pending/active assignment should not suddenly
        | become inactive while attendance and validation are still ongoing.
        |
        */

        if (
            $validated['status']
            === User::STATUS_INACTIVE
            && $student->isActive()
        ) {
            $profile =
                $student->studentProfile;

            $hasOpenAssignment =
                $profile
                    ? $profile
                        ->ojtAssignments()
                        ->whereIn(
                            'status',
                            OjtAssignment::OPEN_STATUSES
                        )
                        ->exists()
                    : false;

            if ($hasOpenAssignment) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'This Student has a pending or active OJT Assignment. Complete or cancel the assignment before deactivating the account.'
                    );
            }
        }

        $updateData = [
            'name' =>
                $validated['name'],

            'email' =>
                $validated['email'],

            'status' =>
                $validated['status'],
        ];

        /*
        |--------------------------------------------------------------------------
        | Optional Admin Password Reset
        |--------------------------------------------------------------------------
        */

        if (
            isset($validated['password'])
            && $validated['password'] !== ''
        ) {
            $updateData['password'] =
                Hash::make(
                    $validated['password']
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Role Is Never Changed Here
        |--------------------------------------------------------------------------
        */

        $student->update(
            $updateData
        );

        return redirect()
            ->route(
                'admin.students.show',
                $student
            )
            ->with(
                'success',
                'Student account updated successfully.'
            );
    }

    /**
     * Archive a Student account.
     *
     * This performs a Laravel soft delete only.
     * Historical OJT data is not permanently deleted.
     */
    public function archive(
        User $student
    ): RedirectResponse {
        $this->ensureStudent(
            $student
        );

        /*
        |--------------------------------------------------------------------------
        | Prevent Archive During Open OJT Assignment
        |--------------------------------------------------------------------------
        */

        $profile =
            $student->studentProfile;

        $hasOpenAssignment =
            $profile
                ? $profile
                    ->ojtAssignments()
                    ->whereIn(
                        'status',
                        OjtAssignment::OPEN_STATUSES
                    )
                    ->exists()
                : false;

        if ($hasOpenAssignment) {
            return back()
                ->with(
                    'error',
                    'This Student has a pending or active OJT Assignment. Complete or cancel the assignment before archiving the account.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Archive Safely
        |--------------------------------------------------------------------------
        |
        | The account is intentionally made inactive before being archived.
        | If restored later, it remains inactive until an Administrator
        | explicitly reactivates it.
        |
        */

        DB::transaction(
            function () use ($student): void {
                if (
                    $student->status
                    !== User::STATUS_INACTIVE
                ) {
                    $student->update([
                        'status' =>
                            User::STATUS_INACTIVE,
                    ]);
                }

                $student->delete();
            }
        );

        return redirect()
            ->route(
                'admin.students.index'
            )
            ->with(
                'success',
                'Student account archived successfully. Historical OJT records were preserved.'
            );
    }

    /**
     * Restore an archived Student account.
     *
     * Restored accounts remain inactive until an Administrator
     * intentionally reactivates them.
     */
    public function restore(
        string $student
    ): RedirectResponse {
        $archivedStudent =
            User::onlyTrashed()
                ->where(
                    'role',
                    User::ROLE_STUDENT
                )
                ->whereKey(
                    $student
                )
                ->firstOrFail();

        DB::transaction(
            function () use ($archivedStudent): void {
                $archivedStudent->restore();

                $archivedStudent->update([
                    'status' =>
                        User::STATUS_INACTIVE,
                ]);
            }
        );

        return redirect()
            ->route(
                'admin.students.show',
                $archivedStudent
            )
            ->with(
                'success',
                'Student account restored successfully. The account remains inactive until you reactivate it.'
            );
    }

    /**
     * Normalize basic account input.
     */
    private function normalizeInput(
        Request $request
    ): void {
        $request->merge([
            'name' =>
                trim(
                    (string) $request->input(
                        'name'
                    )
                ),

            'email' =>
                mb_strtolower(
                    trim(
                        (string) $request->input(
                            'email'
                        )
                    )
                ),
        ]);
    }

    /**
     * Ensure route model is really a Student.
     */
    private function ensureStudent(
        User $student
    ): void {
        if (! $student->isStudent()) {
            abort(404);
        }
    }
}