<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StudentRegistrationController extends Controller
{
    /**
     * Display the Student registration page.
     */
    public function create(): View|RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Already Authenticated
        |--------------------------------------------------------------------------
        |
        | If the user is already logged in, do not show the registration
        | page again. Redirect them to the correct dashboard.
        |
        */

        if (Auth::check()) {
            return $this->redirectAuthenticatedUser();
        }

        return view('auth.student-register');
    }

    /**
     * Register a new OJT Student account.
     */
    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Prevent Logged-In Users From Creating Another Account
        |--------------------------------------------------------------------------
        */

        if (Auth::check()) {
            return $this->redirectAuthenticatedUser();
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Registration Information
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
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
        ]);

        /*
        |--------------------------------------------------------------------------
        | Normalize Student Information
        |--------------------------------------------------------------------------
        */

        $name = preg_replace(
            '/\s+/',
            ' ',
            trim($validated['name'])
        );

        $email = strtolower(
            trim($validated['email'])
        );

        /*
        |--------------------------------------------------------------------------
        | Create Student Account
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | We NEVER accept "role" or "status" from the registration form.
        |
        | This prevents somebody from modifying the HTML request and
        | registering themselves as an administrator or supervisor.
        |
        */

        $student = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make(
                $validated['password']
            ),

            'role' => User::ROLE_STUDENT,

            'status' => User::STATUS_ACTIVE,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Dispatch Laravel Registered Event
        |--------------------------------------------------------------------------
        */

        event(new Registered($student));

        /*
        |--------------------------------------------------------------------------
        | Automatically Login Student
        |--------------------------------------------------------------------------
        */

        Auth::login($student);

        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        |
        | Helps protect against session fixation.
        |
        */

        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Redirect Student
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('student.dashboard')
            ->with(
                'success',
                'Your OJT Student account has been created successfully.'
            );
    }

    /**
     * Redirect an already authenticated user
     * according to their role.
     */
    private function redirectAuthenticatedUser(): RedirectResponse
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            Auth::logout();

            return redirect()
                ->route('login');
        }

        if ($user->isAdmin()) {
            return redirect()
                ->route('admin.dashboard');
        }

        if ($user->isSupervisor()) {
            return redirect()
                ->route('supervisor.dashboard');
        }

        if ($user->isStudent()) {
            return redirect()
                ->route('student.dashboard');
        }

        Auth::logout();

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'Your account role is not recognized.',
            ]);
    }
}