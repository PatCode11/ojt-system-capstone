@extends('layouts.app')

@section('title', 'Edit Student Account | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - EDIT STUDENT ACCOUNT
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --se-navy: #183B6B;
        --se-navy-dark: #102A4A;
        --se-navy-deep: #0B223D;

        --se-blue: #2563EB;
        --se-blue-light: #60A5FA;
        --se-blue-soft: #EAF2FF;

        --se-teal: #0F766E;
        --se-teal-soft: #E7F7F5;

        --se-green: #15803D;
        --se-green-soft: #EAF8EF;

        --se-orange: #B45309;
        --se-orange-soft: #FFF5E6;

        --se-red: #B42318;
        --se-red-soft: #FFF0EE;

        --se-purple: #6D4FC2;
        --se-purple-soft: #F2EEFF;

        --se-text: #102A4A;
        --se-body: #405872;
        --se-muted: #64778C;

        --se-white: #FFFFFF;
        --se-soft: #F8FBFE;
        --se-soft-blue: #F3F8FD;

        --se-border: #D8E3EE;
        --se-border-soft: #E7EDF4;

        --se-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --se-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --se-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .student-edit-page {
        width: 100%;

        color:
            var(--se-text);

        font-family:
            "Segoe UI",
            Arial,
            sans-serif;

        font-size: 16px;

        line-height: 1.65;
    }


    /* ================================================================
       HERO
       ================================================================ */

    .student-edit-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 30px;

        padding:
            40px
            42px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 88% 15%,
                rgba(96, 165, 250, 0.24),
                transparent 27%
            ),
            radial-gradient(
                circle at 72% 95%,
                rgba(45, 212, 191, 0.10),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 55%,
                #285F98 100%
            );

        box-shadow:
            var(--se-shadow-large);
    }


    .student-edit-hero::before {
        content: "";

        position: absolute;

        width: 380px;
        height: 380px;

        top: -225px;
        right: -145px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.06);
    }


    .student-edit-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 35px;
    }


    .student-edit-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 20px;
    }


    .student-edit-avatar {
        width: 82px;
        height: 82px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border:
            2px solid
            rgba(255, 255, 255, 0.17);

        border-radius: 23px;

        background:
            rgba(255, 255, 255, 0.11);

        color:
            #FFFFFF;

        font-size: 24px;
        font-weight: 900;
    }


    .student-edit-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 9px;

        padding:
            7px
            12px;

        border:
            1px solid
            rgba(255, 255, 255, 0.16);

        border-radius: 999px;

        background:
            rgba(255, 255, 255, 0.08);

        color:
            rgba(255, 255, 255, 0.91);

        font-size: 14px;
        font-weight: 800;
    }


    .student-edit-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background:
            var(--se-blue-light);
    }


    .student-edit-hero h1 {
        margin:
            0
            0
            6px;

        color:
            #FFFFFF;

        font-size: 36px;
        font-weight: 900;

        line-height: 1.2;

        letter-spacing:
            -0.4px;
    }


    .student-edit-hero-name {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.80);

        font-size: 16px;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .student-edit-hero-actions {
        width: 250px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .student-edit-hero-btn {
        min-height: 50px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            16px;

        border:
            1px solid
            rgba(255, 255, 255, 0.18);

        border-radius: 12px;

        font-size: 15px;
        font-weight: 850;

        text-decoration: none;

        transition:
            var(--se-transition);
    }


    .hero-btn-white {
        background:
            #FFFFFF;

        color:
            var(--se-navy);
    }


    .hero-btn-white:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;
    }


    .hero-btn-ghost {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .hero-btn-ghost:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    /* ================================================================
       FORM LAYOUT
       ================================================================ */

    .student-edit-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            330px;

        gap: 24px;

        align-items: start;
    }


    .student-edit-main,
    .student-edit-sidebar {
        display: grid;

        gap: 22px;
    }


    /* ================================================================
       PANEL
       ================================================================ */

    .student-edit-panel {
        overflow: hidden;

        border:
            1px solid
            var(--se-border);

        border-radius: 20px;

        background:
            #FFFFFF;

        box-shadow:
            var(--se-shadow);
    }


    .student-edit-panel-header {
        display: flex;
        align-items: center;

        gap: 14px;

        padding:
            22px
            23px;

        border-bottom:
            1px solid
            var(--se-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .student-edit-panel-icon {
        width: 48px;
        height: 48px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        font-size: 13px;
        font-weight: 900;
    }


    .panel-blue {
        background:
            var(--se-blue-soft);

        color:
            var(--se-blue);
    }


    .panel-purple {
        background:
            var(--se-purple-soft);

        color:
            var(--se-purple);
    }


    .panel-teal {
        background:
            var(--se-teal-soft);

        color:
            var(--se-teal);
    }


    .student-edit-panel-header h2 {
        margin:
            0
            0
            3px;

        color:
            var(--se-text);

        font-size: 23px;
        font-weight: 900;

        line-height: 1.3;
    }


    .student-edit-panel-header p {
        margin: 0;

        color:
            var(--se-muted);

        font-size: 14px;
    }


    .student-edit-panel-body {
        padding:
            24px;
    }


    /* ================================================================
       FORM GRID
       ================================================================ */

    .student-edit-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            21px
            20px;
    }


    .student-edit-field {
        display: grid;

        gap: 7px;
    }


    .student-edit-field-full {
        grid-column:
            1 / -1;
    }


    .student-edit-label {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        color:
            var(--se-text);

        font-size: 15px;
        font-weight: 850;
    }


    .student-edit-required {
        color:
            var(--se-red);

        font-size: 13px;
        font-weight: 800;
    }


    .student-edit-optional {
        color:
            var(--se-muted);

        font-size: 13px;
        font-weight: 700;
    }


    .student-edit-input,
    .student-edit-select {
        width: 100%;

        min-height: 55px;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background:
            #FBFDFF;

        color:
            var(--se-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;

        transition:
            var(--se-transition);
    }


    .student-edit-input {
        padding:
            0
            15px;
    }


    .student-edit-select {
        padding:
            0
            14px;

        cursor: pointer;
    }


    .student-edit-input:focus,
    .student-edit-select:focus {
        border-color:
            var(--se-blue);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, 0.09);
    }


    .student-edit-input.is-invalid,
    .student-edit-select.is-invalid {
        border-color:
            var(--se-red);

        background:
            #FFFDFD;
    }


    .student-edit-help {
        color:
            var(--se-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .student-edit-error {
        color:
            var(--se-red);

        font-size: 14px;
        font-weight: 750;

        line-height: 1.5;
    }


    /* ================================================================
       PASSWORD
       ================================================================ */

    .password-wrapper {
        position: relative;
    }


    .password-wrapper
    .student-edit-input {
        padding-right:
            104px;
    }


    .password-toggle {
        position: absolute;

        top: 50%;
        right: 8px;

        transform:
            translateY(-50%);

        min-width: 82px;
        height: 39px;

        border:
            1px solid
            var(--se-border);

        border-radius: 9px;

        background:
            #FFFFFF;

        color:
            var(--se-navy);

        font-family: inherit;

        font-size: 13px;
        font-weight: 850;

        cursor: pointer;
    }


    .password-toggle:hover {
        background:
            var(--se-blue-soft);
    }


    /* ================================================================
       ACCOUNT STATUS BOX
       ================================================================ */

    .status-guidance {
        margin-top: 17px;

        padding:
            16px
            17px;

        border:
            1px solid
            #D7E3EE;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #F8FBFF 0%,
                #F3F8FD 100%
            );
    }


    .status-guidance-title {
        display: block;

        margin-bottom: 5px;

        color:
            var(--se-text);

        font-size: 16px;
        font-weight: 900;
    }


    .status-guidance-text {
        margin: 0;

        color:
            var(--se-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       PASSWORD INFORMATION
       ================================================================ */

    .password-note {
        padding:
            16px
            17px;

        border:
            1px solid
            #D9D2F3;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #FBFAFF,
                #F5F2FF
            );
    }


    .password-note strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--se-purple);

        font-size: 16px;
        font-weight: 900;
    }


    .password-note p {
        margin: 0;

        color:
            var(--se-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       FORM ACTIONS
       ================================================================ */

    .student-edit-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 10px;

        margin-top: 25px;

        padding-top: 21px;

        border-top:
            1px solid
            var(--se-border-soft);
    }


    .student-edit-button {
        min-height: 50px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            18px;

        border:
            1px solid
            var(--se-border);

        border-radius: 11px;

        font-family: inherit;

        font-size: 15px;
        font-weight: 900;

        text-decoration: none;

        cursor: pointer;

        transition:
            var(--se-transition);
    }


    .student-edit-button-secondary {
        background:
            #FFFFFF;

        color:
            var(--se-navy);
    }


    .student-edit-button-secondary:hover {
        background:
            var(--se-blue-soft);
    }


    .student-edit-button-primary {
        border-color:
            var(--se-navy);

        background:
            var(--se-navy);

        color:
            #FFFFFF;
    }


    .student-edit-button-primary:hover {
        transform:
            translateY(-1px);

        background:
            var(--se-navy-dark);
    }


    /* ================================================================
       SIDEBAR INFO
       ================================================================ */

    .student-edit-sidebar-list {
        display: grid;

        gap: 12px;
    }


    .student-edit-sidebar-item {
        padding:
            14px;

        border:
            1px solid
            var(--se-border-soft);

        border-radius: 11px;

        background:
            var(--se-soft);
    }


    .student-edit-sidebar-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--se-muted);

        font-size: 13px;
        font-weight: 800;

        text-transform: uppercase;
    }


    .student-edit-sidebar-value {
        display: block;

        color:
            var(--se-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.5;

        word-break:
            break-word;
    }


    /* ================================================================
       SECURITY NOTICE
       ================================================================ */

    .security-notice {
        padding:
            18px;

        border:
            1px solid
            #CAE2D1;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #F8FCF9,
                #EFF9F2
            );
    }


    .security-notice-title {
        display: block;

        margin-bottom: 6px;

        color:
            var(--se-green);

        font-size: 17px;
        font-weight: 900;
    }


    .security-notice p {
        margin: 0;

        color:
            var(--se-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       ALERTS
       ================================================================ */

    .student-edit-alert {
        margin-bottom: 22px;

        padding:
            16px
            18px;

        border-radius: 13px;

        font-size: 15px;
        font-weight: 700;

        line-height: 1.6;
    }


    .student-edit-alert-error {
        border:
            1px solid
            #E8BEB8;

        background:
            var(--se-red-soft);

        color:
            var(--se-red);
    }


    .student-edit-alert-success {
        border:
            1px solid
            #C9E2D0;

        background:
            var(--se-green-soft);

        color:
            var(--se-green);
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1050px) {

        .student-edit-layout {
            grid-template-columns:
                1fr;
        }


        .student-edit-sidebar {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 780px) {

        .student-edit-hero {
            padding:
                32px
                26px;
        }


        .student-edit-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .student-edit-hero-actions {
            width: 100%;
        }


        .student-edit-grid {
            grid-template-columns:
                1fr;
        }


        .student-edit-field-full {
            grid-column:
                auto;
        }

    }


    @media (max-width: 650px) {

        .student-edit-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .student-edit-identity {
            align-items: flex-start;
        }


        .student-edit-avatar {
            width: 65px;
            height: 65px;

            border-radius: 18px;

            font-size: 20px;
        }


        .student-edit-hero h1 {
            font-size: 30px;
        }


        .student-edit-sidebar {
            grid-template-columns:
                1fr;
        }


        .student-edit-actions {
            display: grid;

            grid-template-columns:
                1fr;
        }


        .student-edit-button {
            width: 100%;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Initials
    |--------------------------------------------------------------------------
    */

    $initials =
        collect(
            preg_split(
                '/\s+/',
                trim(
                    (string)
                    $student->name
                )
            )
        )
            ->filter()
            ->take(2)
            ->map(
                fn ($part) =>
                    mb_strtoupper(
                        mb_substr(
                            $part,
                            0,
                            1
                        )
                    )
            )
            ->implode('')
            ?: 'ST';


    /*
    |--------------------------------------------------------------------------
    | Student Profile
    |--------------------------------------------------------------------------
    */

    $profile =
        $student->studentProfile;


    /*
    |--------------------------------------------------------------------------
    | Date Formatter
    |--------------------------------------------------------------------------
    */

    $formatDate =
        function ($date) {

            if (! $date) {
                return 'Not available';
            }

            try {

                return
                    \Illuminate\Support\Carbon::parse(
                        $date
                    )
                    ->format(
                        'M d, Y'
                    );

            } catch (\Throwable $exception) {

                return (string) $date;

            }

        };

@endphp


<div class="student-edit-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="student-edit-hero">


        <div class="student-edit-hero-inner">


            <div class="student-edit-identity">


                <div class="student-edit-avatar">

                    {{ $initials }}

                </div>


                <div>


                    <div class="student-edit-eyebrow">

                        <span class="student-edit-dot"></span>

                        Administrator · Student Account Editor

                    </div>


                    <h1>
                        Edit Student Account
                    </h1>


                    <p class="student-edit-hero-name">

                        {{ $student->name }}
                        ·
                        {{ $student->email }}

                    </p>


                </div>


            </div>


            <div class="student-edit-hero-actions">


                <a
                    href="{{ route(
                        'admin.students.show',
                        $student
                    ) }}"
                    class="
                        student-edit-hero-btn
                        hero-btn-white
                    "
                >
                    View Student Record
                </a>


                <a
                    href="{{ route(
                        'admin.students.index'
                    ) }}"
                    class="
                        student-edit-hero-btn
                        hero-btn-ghost
                    "
                >
                    Back to Students
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SESSION MESSAGES
         ================================================================== --}}

    @if (session('error'))

        <div
            class="
                student-edit-alert
                student-edit-alert-error
            "
        >

            {{ session('error') }}

        </div>

    @endif


    @if (session('success'))

        <div
            class="
                student-edit-alert
                student-edit-alert-success
            "
        >

            {{ session('success') }}

        </div>

    @endif


    {{-- ==================================================================
         FORM
         ================================================================== --}}

    <form
        method="POST"
        action="{{ route(
            'admin.students.update',
            $student
        ) }}"
        autocomplete="off"
    >

        @csrf
        @method('PUT')


        <div class="student-edit-layout">


            {{-- ==============================================================
                 MAIN
                 ============================================================== --}}

            <main class="student-edit-main">


                {{-- ==========================================================
                     ACCOUNT INFORMATION
                     ========================================================== --}}

                <section class="student-edit-panel">


                    <div class="student-edit-panel-header">


                        <div
                            class="
                                student-edit-panel-icon
                                panel-blue
                            "
                        >
                            AC
                        </div>


                        <div>


                            <h2>
                                Account Information
                            </h2>


                            <p>
                                Update the Student's name, email, and access status.
                            </p>


                        </div>


                    </div>


                    <div class="student-edit-panel-body">


                        <div class="student-edit-grid">


                            {{-- ==================================================
                                 NAME
                                 ================================================== --}}

                            <div class="student-edit-field">


                                <label
                                    for="name"
                                    class="student-edit-label"
                                >

                                    <span>
                                        Full Name
                                    </span>


                                    <span class="student-edit-required">
                                        Required
                                    </span>

                                </label>


                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old(
                                        'name',
                                        $student->name
                                    ) }}"
                                    class="
                                        student-edit-input
                                        @error('name')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                    maxlength="255"
                                    autocomplete="name"
                                >


                                <span class="student-edit-help">

                                    Enter the Student's complete
                                    name as it should appear
                                    throughout OJT Sync.

                                </span>


                                @error('name')

                                    <span class="student-edit-error">

                                        {{ $message }}

                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 EMAIL
                                 ================================================== --}}

                            <div class="student-edit-field">


                                <label
                                    for="email"
                                    class="student-edit-label"
                                >

                                    <span>
                                        Email Address
                                    </span>


                                    <span class="student-edit-required">
                                        Required
                                    </span>

                                </label>


                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old(
                                        'email',
                                        $student->email
                                    ) }}"
                                    class="
                                        student-edit-input
                                        @error('email')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                    maxlength="255"
                                    autocomplete="email"
                                >


                                <span class="student-edit-help">

                                    This email is used by the
                                    Student when signing in
                                    to the OJT Portal.

                                </span>


                                @error('email')

                                    <span class="student-edit-error">

                                        {{ $message }}

                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 STATUS
                                 ================================================== --}}

                            <div
                                class="
                                    student-edit-field
                                    student-edit-field-full
                                "
                            >


                                <label
                                    for="status"
                                    class="student-edit-label"
                                >

                                    <span>
                                        Account Status
                                    </span>


                                    <span class="student-edit-required">
                                        Required
                                    </span>

                                </label>


                                <select
                                    id="status"
                                    name="status"
                                    class="
                                        student-edit-select
                                        @error('status')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                >


                                    <option
                                        value="{{ \App\Models\User::STATUS_ACTIVE }}"
                                        @selected(
                                            old(
                                                'status',
                                                $student->status
                                            )
                                            ===
                                            \App\Models\User::STATUS_ACTIVE
                                        )
                                    >
                                        Active — Student can log in
                                    </option>


                                    <option
                                        value="{{ \App\Models\User::STATUS_INACTIVE }}"
                                        @selected(
                                            old(
                                                'status',
                                                $student->status
                                            )
                                            ===
                                            \App\Models\User::STATUS_INACTIVE
                                        )
                                    >
                                        Inactive — Student login disabled
                                    </option>


                                </select>


                                @error('status')

                                    <span class="student-edit-error">

                                        {{ $message }}

                                    </span>

                                @enderror


                                <div class="status-guidance">


                                    <span class="status-guidance-title">
                                        Account Access Guidance
                                    </span>


                                    <p class="status-guidance-text">

                                        Active Students may sign in
                                        to the OJT Portal. Inactive
                                        Students cannot sign in, but
                                        their Student profile and
                                        historical OJT records remain
                                        stored in the system.

                                        If the Student still has a
                                        pending or active OJT
                                        Assignment, the system may
                                        prevent the account from being
                                        deactivated until that placement
                                        is completed or cancelled.

                                    </p>


                                </div>


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     PASSWORD RESET
                     ========================================================== --}}

                <section class="student-edit-panel">


                    <div class="student-edit-panel-header">


                        <div
                            class="
                                student-edit-panel-icon
                                panel-purple
                            "
                        >
                            PW
                        </div>


                        <div>


                            <h2>
                                Password Reset
                            </h2>


                            <p>
                                Optionally assign a new Student password.
                            </p>


                        </div>


                    </div>


                    <div class="student-edit-panel-body">


                        <div class="password-note">


                            <strong>
                                Password changes are optional.
                            </strong>


                            <p>

                                Leave both password fields blank
                                if you do not want to change the
                                Student's current password.

                                If you enter a new password, it
                                must meet the application's
                                security requirements.

                            </p>


                        </div>


                        <div
                            class="student-edit-grid"
                            style="margin-top: 20px;"
                        >


                            {{-- ==================================================
                                 NEW PASSWORD
                                 ================================================== --}}

                            <div class="student-edit-field">


                                <label
                                    for="password"
                                    class="student-edit-label"
                                >

                                    <span>
                                        New Password
                                    </span>


                                    <span class="student-edit-optional">
                                        Optional
                                    </span>

                                </label>


                                <div class="password-wrapper">


                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="
                                            student-edit-input
                                            @error('password')
                                                is-invalid
                                            @enderror
                                        "
                                        autocomplete="new-password"
                                    >


                                    <button
                                        type="button"
                                        class="password-toggle"
                                        data-password-toggle="password"
                                    >
                                        Show
                                    </button>


                                </div>


                                <span class="student-edit-help">

                                    Use at least 8 characters
                                    with uppercase, lowercase,
                                    number, and symbol.

                                </span>


                                @error('password')

                                    <span class="student-edit-error">

                                        {{ $message }}

                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 CONFIRM PASSWORD
                                 ================================================== --}}

                            <div class="student-edit-field">


                                <label
                                    for="password_confirmation"
                                    class="student-edit-label"
                                >

                                    <span>
                                        Confirm New Password
                                    </span>


                                    <span class="student-edit-optional">
                                        Optional
                                    </span>

                                </label>


                                <div class="password-wrapper">


                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="student-edit-input"
                                        autocomplete="new-password"
                                    >


                                    <button
                                        type="button"
                                        class="password-toggle"
                                        data-password-toggle="password_confirmation"
                                    >
                                        Show
                                    </button>


                                </div>


                                <span class="student-edit-help">

                                    Re-enter the new password
                                    exactly as entered above.

                                </span>


                            </div>


                        </div>


                        {{-- ======================================================
                             ACTIONS
                             ====================================================== --}}

                        <div class="student-edit-actions">


                            <a
                                href="{{ route(
                                    'admin.students.show',
                                    $student
                                ) }}"
                                class="
                                    student-edit-button
                                    student-edit-button-secondary
                                "
                            >
                                Cancel
                            </a>


                            <button
                                type="submit"
                                class="
                                    student-edit-button
                                    student-edit-button-primary
                                "
                            >
                                Save Student Changes
                            </button>


                        </div>


                    </div>


                </section>


            </main>


            {{-- ==============================================================
                 SIDEBAR
                 ============================================================== --}}

            <aside class="student-edit-sidebar">


                {{-- ==========================================================
                     STUDENT SUMMARY
                     ========================================================== --}}

                <section class="student-edit-panel">


                    <div class="student-edit-panel-header">


                        <div
                            class="
                                student-edit-panel-icon
                                panel-teal
                            "
                        >
                            ST
                        </div>


                        <div>


                            <h2>
                                Student Summary
                            </h2>


                            <p>
                                Current record information
                            </p>


                        </div>


                    </div>


                    <div class="student-edit-panel-body">


                        <div class="student-edit-sidebar-list">


                            <div class="student-edit-sidebar-item">


                                <span class="student-edit-sidebar-label">
                                    Student Number
                                </span>


                                <span class="student-edit-sidebar-value">

                                    {{ $profile?->student_number
                                        ?? 'Not provided'
                                    }}

                                </span>


                            </div>


                            <div class="student-edit-sidebar-item">


                                <span class="student-edit-sidebar-label">
                                    Program
                                </span>


                                <span class="student-edit-sidebar-value">

                                    {{ $profile?->program
                                        ?? 'Not provided'
                                    }}

                                </span>


                            </div>


                            <div class="student-edit-sidebar-item">


                                <span class="student-edit-sidebar-label">
                                    Year / Section
                                </span>


                                <span class="student-edit-sidebar-value">

                                    @if ($profile)

                                        {{ $profile->year_level
                                            ?? 'Year not provided'
                                        }}

                                        @if (
                                            filled(
                                                $profile->section
                                            )
                                        )

                                            ·
                                            {{ $profile->section }}

                                        @endif

                                    @else

                                        Not provided

                                    @endif

                                </span>


                            </div>


                            <div class="student-edit-sidebar-item">


                                <span class="student-edit-sidebar-label">
                                    Current Status
                                </span>


                                <span class="student-edit-sidebar-value">

                                    {{ ucfirst(
                                        $student->status
                                    ) }}

                                </span>


                            </div>


                            <div class="student-edit-sidebar-item">


                                <span class="student-edit-sidebar-label">
                                    Account Created
                                </span>


                                <span class="student-edit-sidebar-value">

                                    {{ $formatDate(
                                        $student->created_at
                                    ) }}

                                </span>


                            </div>


                            <div class="student-edit-sidebar-item">


                                <span class="student-edit-sidebar-label">
                                    Last Updated
                                </span>


                                <span class="student-edit-sidebar-value">

                                    {{ $formatDate(
                                        $student->updated_at
                                    ) }}

                                </span>


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     SECURITY
                     ========================================================== --}}

                <section class="student-edit-panel">


                    <div class="student-edit-panel-body">


                        <div class="security-notice">


                            <span class="security-notice-title">
                                Account Safety
                            </span>


                            <p>

                                Student roles cannot be changed
                                from this page. Account role
                                assignment remains controlled
                                by the server.

                                Password changes are securely
                                handled by Laravel and are never
                                displayed back to the Administrator.

                            </p>


                        </div>


                    </div>


                </section>


            </aside>


        </div>


    </form>


</div>


@endsection


@push('scripts')

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /*
            |--------------------------------------------------------------------------
            | Password Visibility
            |--------------------------------------------------------------------------
            */

            const toggleButtons =
                document.querySelectorAll(
                    '[data-password-toggle]'
                );


            toggleButtons.forEach(
                function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            const inputId =
                                button.getAttribute(
                                    'data-password-toggle'
                                );


                            const input =
                                document.getElementById(
                                    inputId
                                );


                            if (! input) {
                                return;
                            }


                            const isPassword =
                                input.type
                                ===
                                'password';


                            input.type =
                                isPassword
                                    ? 'text'
                                    : 'password';


                            button.textContent =
                                isPassword
                                    ? 'Hide'
                                    : 'Show';

                        }
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Form Submit Protection
            |--------------------------------------------------------------------------
            |
            | Prevent accidental double submission.
            |
            */

            const form =
                document.querySelector(
                    '.student-edit-page form'
                );


            if (form) {

                form.addEventListener(
                    'submit',
                    function () {

                        const submitButton =
                            form.querySelector(
                                'button[type="submit"]'
                            );


                        if (! submitButton) {
                            return;
                        }


                        submitButton.disabled =
                            true;


                        submitButton.textContent =
                            'Saving Changes...';

                    }
                );

            }

        }
    );

</script>

@endpush