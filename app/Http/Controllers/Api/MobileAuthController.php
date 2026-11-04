<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MobileAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Mobile Login
    |--------------------------------------------------------------------------
    */

    public function login(
        Request $request
    ): JsonResponse {
        /*
        |--------------------------------------------------------------------------
        | Normalize Email
        |--------------------------------------------------------------------------
        */

        $request->merge([
            'email' => mb_strtolower(
                trim(
                    (string) $request->input(
                        'email'
                    )
                )
            ),

            'role' => trim(
                (string) $request->input(
                    'role'
                )
            ),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'password' => [
                'required',
                'string',
                'max:255',
            ],

            'role' => [
                'required',

                Rule::in([
                    User::ROLE_STUDENT,
                    User::ROLE_SUPERVISOR,
                ]),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Find User
        |--------------------------------------------------------------------------
        |
        | Soft-deleted users are automatically excluded.
        |
        */

        $user = User::query()
            ->where(
                'email',
                $validated['email']
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Verify Credentials
        |--------------------------------------------------------------------------
        |
        | Use one generic response so the API does not reveal whether
        | the email, password or selected role was incorrect.
        |
        */

        if (
            ! $user
            || ! Hash::check(
                $validated['password'],
                $user->password
            )
            || $user->role
                !== $validated['role']
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Unable to sign in with the provided credentials.',
                ],
                422
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Mobile Roles Only
        |--------------------------------------------------------------------------
        |
        | Administrators are intentionally restricted to the web application.
        |
        */

        if (
            ! $user->isStudent()
            && ! $user->isSupervisor()
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'This account cannot access the mobile application.',
                ],
                403
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Active Accounts Only
        |--------------------------------------------------------------------------
        */

        if (! $user->isActive()) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'This account is currently inactive.',
                ],
                403
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Sanctum Token
        |--------------------------------------------------------------------------
        */

        $token = $user
            ->createToken(
                'ojt-sync-mobile',
                [
                    'mobile',
                    $user->role,
                ]
            )
            ->plainTextToken;


        /*
        |--------------------------------------------------------------------------
        | Student Profile
        |--------------------------------------------------------------------------
        */

        if ($user->isStudent()) {
            $user->load(
                'studentProfile'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Successful Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'message' =>
                'Login successful.',

            'token_type' =>
                'Bearer',

            'token' =>
                $token,

            'user' => [
                'id' =>
                    $user->id,

                'name' =>
                    $user->name,

                'email' =>
                    $user->email,

                'role' =>
                    $user->role,

                'status' =>
                    $user->status,

                'student_profile' =>
                    $user->isStudent()
                        ? $user->studentProfile
                        : null,
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Authenticated User
    |--------------------------------------------------------------------------
    */

    public function me(
        Request $request
    ): JsonResponse {
        $user =
            $request->user();


        if (! $user) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Unauthenticated.',
                ],
                401
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Block Archived / Inactive Accounts
        |--------------------------------------------------------------------------
        */

        if (
            $user->isArchived()
            || ! $user->isActive()
        ) {
            $request
                ->user()
                ?->currentAccessToken()
                ?->delete();


            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'This account is no longer available.',
                ],
                403
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Mobile Roles Only
        |--------------------------------------------------------------------------
        */

        if (
            ! $user->isStudent()
            && ! $user->isSupervisor()
        ) {
            $request
                ->user()
                ?->currentAccessToken()
                ?->delete();


            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'This account cannot access the mobile application.',
                ],
                403
            );
        }


        if ($user->isStudent()) {
            $user->load(
                'studentProfile'
            );
        }


        return response()->json([
            'success' => true,

            'user' => [
                'id' =>
                    $user->id,

                'name' =>
                    $user->name,

                'email' =>
                    $user->email,

                'role' =>
                    $user->role,

                'status' =>
                    $user->status,

                'student_profile' =>
                    $user->isStudent()
                        ? $user->studentProfile
                        : null,
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Mobile Logout
    |--------------------------------------------------------------------------
    */

    public function logout(
        Request $request
    ): JsonResponse {
        $request
            ->user()
            ?->currentAccessToken()
            ?->delete();


        return response()->json([
            'success' => true,

            'message' =>
                'Logout successful.',
        ]);
    }
}