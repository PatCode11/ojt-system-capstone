<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalLoginController extends Controller
{
    /**
     * Display the Student / Supervisor login page.
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedUser();
        }

        return view('auth.portal-login');
    }

    /**
     * Authenticate a Student or Supervisor.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'password' => [
                'required',
                'string',
            ],

            'remember' => [
                'nullable',
                'boolean',
            ],
        ]);

        $email = strtolower(trim($validated['email']));

        $remember = $request->boolean('remember');

        /*
        |--------------------------------------------------------------------------
        | OJT Portal Authentication
        |--------------------------------------------------------------------------
        |
        | Only Student and Supervisor accounts are allowed to sign in
        | through the OJT Portal.
        |
        | Administrator accounts must use /admin/login.
        |
        */

        $authenticated = Auth::attempt(
            [
                'email' => $email,

                'password' => $validated['password'],

                'status' => User::STATUS_ACTIVE,

                function (Builder $query): void {
                    $query->whereIn('role', [
                        User::ROLE_STUDENT,
                        User::ROLE_SUPERVISOR,
                    ]);
                },
            ],
            $remember
        );

        /*
        |--------------------------------------------------------------------------
        | Invalid Login
        |--------------------------------------------------------------------------
        */

        if (! $authenticated) {
            return back()
                ->withErrors([
                    'email' => 'The provided credentials are invalid.',
                ])
                ->onlyInput('email');
        }

        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        |
        | Regenerating the session after login protects against
        | session fixation attacks.
        |
        */

        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Redirect User
        |--------------------------------------------------------------------------
        */

        return $this->redirectAuthenticatedUser();
    }

    /**
     * Logout Student or Supervisor.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }

    /**
     * Redirect an authenticated user to the correct dashboard.
     */
    private function redirectAuthenticatedUser(): RedirectResponse
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Confirm User Model Type
        |--------------------------------------------------------------------------
        |
        | Laravel types Auth::user() as a generic Authenticatable user.
        |
        | This check tells PHP and VS Code that $user is specifically
        | App\Models\User, so our custom role methods such as
        | isSupervisor(), isStudent(), and isAdmin() can be used safely.
        |
        */

        if (! $user instanceof User) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Unable to identify the authenticated account.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Supervisor
        |--------------------------------------------------------------------------
        */

        if ($user->isSupervisor()) {
            return redirect()
                ->route('supervisor.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Student
        |--------------------------------------------------------------------------
        */

        if ($user->isStudent()) {
            return redirect()
                ->route('student.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Administrator
        |--------------------------------------------------------------------------
        |
        | An administrator normally cannot log in through this controller,
        | but this protects redirects for an already authenticated admin.
        |
        */

        if ($user->isAdmin()) {
            return redirect()
                ->route('admin.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Unknown Role
        |--------------------------------------------------------------------------
        */

        Auth::logout();

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'Your account role is not recognized.',
            ]);
    }
}