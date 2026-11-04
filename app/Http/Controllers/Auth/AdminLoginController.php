<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Display the administrator login page.
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedUser();
        }

        return view('auth.admin-login');
    }

    /**
     * Authenticate an administrator.
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

        $authenticated = Auth::attempt(
            [
                'email' => $email,
                'password' => $validated['password'],
                'role' => User::ROLE_ADMIN,
                'status' => User::STATUS_ACTIVE,
            ],
            $remember
        );

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
        | This helps protect the authenticated session against
        | session fixation attacks.
        |
        */

        $request->session()->regenerate();

        return redirect()
            ->route('admin.dashboard');
    }

    /**
     * Logout the administrator.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }

    /**
     * Redirect an already authenticated user
     * to the correct dashboard based on their role.
     */
    private function redirectAuthenticatedUser(): RedirectResponse
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Make Sure We Have Our App\Models\User
        |--------------------------------------------------------------------------
        |
        | Auth::user() is typed by Laravel as a generic Authenticatable user.
        | This explicit check tells PHP and VS Code that $user is our User
        | model, allowing us to safely use methods such as isAdmin(),
        | isSupervisor(), and isStudent().
        |
        */

        if (! $user instanceof User) {
            Auth::logout();

            return redirect()
                ->route('admin.login');
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
            ->route('home')
            ->with(
                'error',
                'Your account role is not recognized.'
            );
    }
}