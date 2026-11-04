<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\OjtAssignment;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the Student profile.
     */
    public function show(Request $request): View
    {
        $user = $request->user();

        if (! $user instanceof User || ! $user->isStudent()) {
            abort(403);
        }

        $profile = $user->studentProfile;

        $activeAssignment = $profile
            ? $profile->ojtAssignments()
                ->with([
                    'company',
                    'supervisor',
                ])
                ->whereIn(
                    'status',
                    OjtAssignment::OPEN_STATUSES
                )
                ->latest('start_date')
                ->first()
            : null;

        return view(
            'student.profile.show',
            compact(
                'profile',
                'activeAssignment'
            )
        );
    }

    /**
     * Display the Student profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        if (! $user instanceof User || ! $user->isStudent()) {
            abort(403);
        }

        $profile = $user->studentProfile;

        return view(
            'student.profile.edit',
            compact('profile')
        );
    }

    /**
     * Create or update the Student profile.
     */
    public function update(
        Request $request
    ): RedirectResponse {
        $user = $request->user();

        if (! $user instanceof User || ! $user->isStudent()) {
            abort(403);
        }

        $profile = $user->studentProfile;

        $validated = $request->validate([
            'student_number' => [
                'required',
                'string',
                'max:50',

                Rule::unique(
                    'student_profiles',
                    'student_number'
                )->ignore($profile?->id),
            ],

            'program' => [
                'required',
                'string',
                'max:150',
            ],

            'year_level' => [
                'required',
                'string',
                'max:30',
            ],

            'section' => [
                'nullable',
                'string',
                'max:50',
            ],

            'contact_number' => [
                'required',
                'string',
                'max:30',
            ],

            'address' => [
                'required',
                'string',
                'max:1000',
            ],

            'emergency_contact_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'emergency_contact_number' => [
                'nullable',
                'string',
                'max:30',
            ],

            /*
             * Emergency Contact Relationship
             */
            'emergency_contact_relationship' => [
                'nullable',
                'string',
                'max:100',
            ],

            /*
             * Emergency Contact Address
             */
            'emergency_contact_address' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $user->studentProfile()->updateOrCreate(
            [],
            $validated
        );

        return redirect()
            ->route('student.profile.show')
            ->with(
                'success',
                'Your Student Profile has been saved successfully.'
            );
    }
}