<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\OjtAssignment;
use App\Models\User;
use App\Services\OjtAssignmentCompletionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AssignmentHistoryController extends Controller
{
    /**
     * Display all Student assignments.
     */
    public function index(
        Request $request,
        OjtAssignmentCompletionService $completionService
    ): View {
        $user =
            $request->user();

        if (
            ! $user instanceof User
            || ! $user->isStudent()
        ) {
            abort(403);
        }

        $profile =
            $user->studentProfile;

        if (! $profile) {
            return view(
                'student.assignment-history.index',
                [
                    'profile' => null,

                    'assignments' =>
                        collect(),

                    'completionSummaries' =>
                        [],
                ]
            );
        }

        $assignments =
            $profile
                ->ojtAssignments()
                ->with([
                    'company',
                    'supervisor',
                    'completedBy',
                    'finalEvaluation.evaluator',
                ])
                ->latest('start_date')
                ->latest('id')
                ->get();

        $completionSummaries = [];

        foreach (
            $assignments as $assignment
        ) {
            $completionSummaries[
                $assignment->id
            ] =
                $completionService->summary(
                    $assignment
                );
        }

        return view(
            'student.assignment-history.index',
            compact(
                'profile',
                'assignments',
                'completionSummaries'
            )
        );
    }

    /**
     * Official Student completion record.
     */
    public function completion(
        Request $request,
        OjtAssignment $assignment,
        OjtAssignmentCompletionService $completionService
    ): View {
        $user =
            $request->user();

        if (
            ! $user instanceof User
            || ! $user->isStudent()
        ) {
            abort(403);
        }

        $profile =
            $user->studentProfile;

        /*
        |--------------------------------------------------------------------------
        | Student Ownership
        |--------------------------------------------------------------------------
        */

        if (
            ! $profile
            || (int) $assignment
                ->student_profile_id
                !==
                (int) $profile->id
        ) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Completed Only
        |--------------------------------------------------------------------------
        */

        if (
            $assignment->status
            !== OjtAssignment::STATUS_COMPLETED
        ) {
            abort(
                404,
                'This OJT Assignment does not yet have an official completion record.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Load Official Information
        |--------------------------------------------------------------------------
        */

        $assignment->load([
            'studentProfile.user',
            'company',
            'supervisor',
            'completedBy',
            'finalEvaluation.evaluator',
        ]);

        $attendanceRecords =
            $assignment
                ->attendanceRecords()
                ->with([
                    'validator',
                    'dailyWorkLog.validator',
                ])
                ->orderBy(
                    'attendance_date'
                )
                ->get();

        $completionSummary =
            $completionService->summary(
                $assignment
            );

        return view(
            'student.assignment-history.completion',
            compact(
                'assignment',
                'attendanceRecords',
                'completionSummary'
            )
        );
    }
}