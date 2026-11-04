<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSession;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;


class StudentAttendanceEvidenceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Attendance Session Selfie
    |--------------------------------------------------------------------------
    |
    | GET
    |
    | /api/mobile/student/attendance/sessions/{session}/selfie/{type}
    |
    | type:
    | - time-in
    | - time-out
    |
    | The image remains on Laravel's private local disk. A Student may only
    | retrieve evidence that belongs to their own OJT Assignment.
    |
    */

    public function sessionSelfie(
        Request $request,
        AttendanceSession $session,
        string $type
    ): Response|JsonResponse {
        $student =
            $this->authenticatedStudent(
                $request
            );


        if (
            $student
            instanceof JsonResponse
        ) {
            return $student;
        }


        /*
        |--------------------------------------------------------------------------
        | Load Parent Attendance + Assignment
        |--------------------------------------------------------------------------
        */

        $session->loadMissing(
            'attendanceRecord.ojtAssignment.studentProfile'
        );


        $attendance =
            $session
                ->attendanceRecord;


        $assignment =
            $attendance
                ?->ojtAssignment;


        $profile =
            $assignment
                ?->studentProfile;


        if (
            ! $attendance
            ||
            ! $assignment
            ||
            ! $profile
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Attendance evidence could not be found.',
                ],
                404
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Student Ownership Check
        |--------------------------------------------------------------------------
        |
        | Never trust a session ID supplied by the mobile application.
        |
        */

        if (
            (int) $profile
                ->user_id
            !==
            (int) $student->id
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'You are not authorized to access this attendance selfie.',
                ],
                403
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Select Selfie
        |--------------------------------------------------------------------------
        */

        $path =
            match ($type) {
                'time-in' =>
                    $session
                        ->time_in_selfie_path,

                'time-out' =>
                    $session
                        ->time_out_selfie_path,

                default =>
                    null,
            };


        if (! $path) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Attendance selfie not found.',
                ],
                404
            );
        }


        return $this->privateImageResponse(
            $path
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Authenticated Student
    |--------------------------------------------------------------------------
    */

    private function authenticatedStudent(
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
            ! $user->isStudent()
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Student access only.',
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
    | Private Image Response
    |--------------------------------------------------------------------------
    |
    | Selfies remain private. The response is streamed through an authorized
    | Sanctum request instead of exposing a public /storage URL.
    |
    */

    private function privateImageResponse(
        string $path
    ): Response {
        $disk =
            Storage::disk(
                'local'
            );


        if (
            ! $disk->exists(
                $path
            )
        ) {
            abort(
                404,
                'Attendance selfie not found.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Determine Safe Image MIME Type
        |--------------------------------------------------------------------------
        */

        $extension =
            strtolower(
                pathinfo(
                    $path,
                    PATHINFO_EXTENSION
                )
            );


        $mimeType =
            match ($extension) {
                'jpg',
                'jpeg' =>
                    'image/jpeg',

                'png' =>
                    'image/png',

                'webp' =>
                    'image/webp',

                default =>
                    'application/octet-stream',
            };


        /*
        |--------------------------------------------------------------------------
        | Secure Inline Response
        |--------------------------------------------------------------------------
        */

        return response(
            $disk->get(
                $path
            ),
            200,
            [
                'Content-Type' =>
                    $mimeType,

                'Content-Disposition' =>
                    'inline',

                'Cache-Control' =>
                    'private, no-store, max-age=0',

                'Pragma' =>
                    'no-cache',

                'X-Content-Type-Options' =>
                    'nosniff',
            ]
        );
    }
}
