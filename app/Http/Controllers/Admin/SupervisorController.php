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

class SupervisorController extends Controller
{
    /**
     * Display all non-archived Supervisor accounts.
     */
    public function index(): View
    {
        $supervisors = User::query()
            ->where(
                'role',
                User::ROLE_SUPERVISOR
            )
            ->with([
                'supervisedAssignments' =>
                    function ($query): void {
                        $query
                            ->with([
                                'studentProfile.user',
                                'company',
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
            'admin.supervisors.index',
            compact('supervisors')
        );
    }

    /**
     * Display archived Supervisor accounts.
     */
    public function archived(): View
    {
        $supervisors = User::onlyTrashed()
            ->where(
                'role',
                User::ROLE_SUPERVISOR
            )
            ->with([
                'supervisedAssignments' =>
                    function ($query): void {
                        $query
                            ->with([
                                'studentProfile.user',
                                'company',
                            ])
                            ->latest(
                                'start_date'
                            );
                    },
            ])
            ->latest('deleted_at')
            ->paginate(15);

        return view(
            'admin.supervisors.archived',
            compact('supervisors')
        );
    }

    /**
     * Show Supervisor creation form.
     */
    public function create(): View
    {
        return view(
            'admin.supervisors.create'
        );
    }

    /**
     * Store Supervisor account.
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

        $supervisor = User::create([
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
            | Force Role Server-Side
            |--------------------------------------------------------------------------
            */

            'role' =>
                User::ROLE_SUPERVISOR,

            'status' =>
                $validated['status'],
        ]);

        return redirect()
            ->route(
                'admin.supervisors.show',
                $supervisor
            )
            ->with(
                'success',
                'Supervisor account created successfully.'
            );
    }

    /**
     * Display one Supervisor.
     */
    public function show(
        User $supervisor
    ): View {
        $this->ensureSupervisor(
            $supervisor
        );

        $supervisor->load([
            'supervisedAssignments' =>
                function ($query): void {
                    $query
                        ->with([
                            'studentProfile.user',
                            'company',
                        ])
                        ->latest(
                            'start_date'
                        );
                },
        ]);

        return view(
            'admin.supervisors.show',
            compact('supervisor')
        );
    }

    /**
     * Show Supervisor edit form.
     */
    public function edit(
        User $supervisor
    ): View {
        $this->ensureSupervisor(
            $supervisor
        );

        return view(
            'admin.supervisors.edit',
            compact('supervisor')
        );
    }

    /**
     * Update Supervisor account.
     */
    public function update(
        Request $request,
        User $supervisor
    ): RedirectResponse {
        $this->ensureSupervisor(
            $supervisor
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
                    $supervisor->id
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
        | Protect Active Supervisor Assignments
        |--------------------------------------------------------------------------
        */

        if (
            $validated['status']
            === User::STATUS_INACTIVE
            && $supervisor->isActive()
        ) {
            $hasOpenAssignments =
                $supervisor
                    ->supervisedAssignments()
                    ->whereIn(
                        'status',
                        OjtAssignment::OPEN_STATUSES
                    )
                    ->exists();

            if ($hasOpenAssignments) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'This Supervisor still has pending or active OJT Assignments. Reassign, complete, or cancel those assignments before deactivating the account.'
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

        if (
            isset($validated['password'])
            && $validated['password'] !== ''
        ) {
            $updateData['password'] =
                Hash::make(
                    $validated['password']
                );
        }

        $supervisor->update(
            $updateData
        );

        return redirect()
            ->route(
                'admin.supervisors.show',
                $supervisor
            )
            ->with(
                'success',
                'Supervisor account updated successfully.'
            );
    }

    /**
     * Archive a Supervisor account.
     *
     * This performs a Laravel soft delete only.
     */
    public function archive(
        User $supervisor
    ): RedirectResponse {
        $this->ensureSupervisor(
            $supervisor
        );

        /*
        |--------------------------------------------------------------------------
        | Prevent Archive During Open Assignments
        |--------------------------------------------------------------------------
        */

        $hasOpenAssignments =
            $supervisor
                ->supervisedAssignments()
                ->whereIn(
                    'status',
                    OjtAssignment::OPEN_STATUSES
                )
                ->exists();

        if ($hasOpenAssignments) {
            return back()
                ->with(
                    'error',
                    'This Supervisor still has pending or active OJT Assignments. Reassign, complete, or cancel those assignments before archiving the account.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Archive Safely
        |--------------------------------------------------------------------------
        |
        | Make the account inactive first so restoring it does not
        | unexpectedly restore login access.
        |
        */

        DB::transaction(
            function () use ($supervisor): void {
                if (
                    $supervisor->status
                    !== User::STATUS_INACTIVE
                ) {
                    $supervisor->update([
                        'status' =>
                            User::STATUS_INACTIVE,
                    ]);
                }

                $supervisor->delete();
            }
        );

        return redirect()
            ->route(
                'admin.supervisors.index'
            )
            ->with(
                'success',
                'Supervisor account archived successfully. Historical OJT records were preserved.'
            );
    }

    /**
     * Restore an archived Supervisor account.
     *
     * Restored accounts remain inactive until an Administrator
     * explicitly reactivates them.
     */
    public function restore(
        string $supervisor
    ): RedirectResponse {
        $archivedSupervisor =
            User::onlyTrashed()
                ->where(
                    'role',
                    User::ROLE_SUPERVISOR
                )
                ->whereKey(
                    $supervisor
                )
                ->firstOrFail();

        DB::transaction(
            function () use ($archivedSupervisor): void {
                $archivedSupervisor->restore();

                $archivedSupervisor->update([
                    'status' =>
                        User::STATUS_INACTIVE,
                ]);
            }
        );

        return redirect()
            ->route(
                'admin.supervisors.show',
                $archivedSupervisor
            )
            ->with(
                'success',
                'Supervisor account restored successfully. The account remains inactive until you reactivate it.'
            );
    }

    /**
     * Normalize account input.
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
     * Ensure route model is really a Supervisor.
     */
    private function ensureSupervisor(
        User $supervisor
    ): void {
        if (! $supervisor->isSupervisor()) {
            abort(404);
        }
    }
}