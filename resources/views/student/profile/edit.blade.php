@extends('layouts.app')


@section('title', 'Edit Student Profile | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC - STUDENT PROFILE EDIT
       READABILITY-FIRST PROFESSIONAL DESIGN
       ================================================================ */

    :root {
        --edit-navy: #183B6B;
        --edit-navy-dark: #102A4A;

        --edit-blue: #2563EB;
        --edit-blue-soft: #EAF2FF;

        --edit-green: #15803D;
        --edit-green-soft: #EAF8EF;

        --edit-teal: #0F766E;
        --edit-teal-soft: #E7F7F5;

        --edit-orange: #B45309;
        --edit-orange-soft: #FFF5E6;

        --edit-red: #B42318;
        --edit-red-soft: #FFF0EE;

        --edit-purple: #6D4FC2;
        --edit-purple-soft: #F2EEFF;

        --edit-text: #102A4A;
        --edit-body: #405872;
        --edit-muted: #64778C;

        --edit-white: #FFFFFF;
        --edit-soft: #F8FBFE;

        --edit-border: #D8E3EE;
        --edit-border-soft: #E7EDF4;

        --edit-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --edit-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --edit-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .student-profile-edit-page {
        width: 100%;

        color:
            var(--edit-text);

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

    .profile-edit-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 30px;

        padding:
            42px
            44px;

        border-radius: 28px;

        background:
            radial-gradient(
                circle at 89% 15%,
                rgba(45, 212, 191, 0.20),
                transparent 24%
            ),
            radial-gradient(
                circle at 69% 87%,
                rgba(96, 165, 250, 0.14),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 54%,
                #205F79 100%
            );

        box-shadow:
            var(--edit-shadow-large);
    }


    .profile-edit-hero::before {
        content: "";

        position: absolute;

        width: 340px;
        height: 340px;

        right: -135px;
        top: -190px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.06);
    }


    .profile-edit-hero::after {
        content: "";

        position: absolute;

        width: 210px;
        height: 210px;

        right: 250px;
        bottom: -145px;

        border-radius: 50%;

        background:
            rgba(45, 212, 191, 0.08);
    }


    .profile-edit-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 35px;
    }


    .profile-edit-identity {
        display: flex;
        align-items: center;

        min-width: 0;

        gap: 23px;
    }


    .profile-edit-avatar {
        width: 96px;
        height: 96px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border:
            1px solid
            rgba(255, 255, 255, 0.18);

        border-radius: 27px;

        background:
            rgba(255, 255, 255, 0.12);

        color: #FFFFFF;

        font-size: 27px;
        font-weight: 900;
    }


    .profile-edit-copy {
        min-width: 0;
    }


    .profile-edit-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 9px;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 14px;
        font-weight: 800;
    }


    .profile-edit-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background:
            #2DD4BF;

        box-shadow:
            0 0 0 5px
            rgba(45, 212, 191, 0.13);
    }


    .profile-edit-hero h1 {
        margin:
            0
            0
            9px;

        color:
            #FFFFFF;

        font-size: 38px;
        font-weight: 900;

        line-height: 1.18;

        letter-spacing:
            -0.55px;
    }


    .profile-edit-description {
        max-width: 720px;

        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO ACTION
       ================================================================ */

    .profile-edit-back {
        min-height: 50px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            18px;

        border:
            1px solid
            rgba(255, 255, 255, 0.18);

        border-radius: 13px;

        background:
            rgba(255, 255, 255, 0.10);

        color:
            #FFFFFF;

        text-decoration: none;

        font-size: 15px;
        font-weight: 850;

        white-space: nowrap;

        transition:
            var(--edit-transition);
    }


    .profile-edit-back:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.17);
    }


    /* ================================================================
       NOTICE
       ================================================================ */

    .profile-edit-notice {
        display: flex;
        align-items: flex-start;

        gap: 15px;

        margin-bottom: 25px;

        padding:
            19px
            21px;

        border:
            1px solid
            #D1E2F3;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #F8FBFF 0%,
                #F1F7FD 100%
            );

        box-shadow:
            var(--edit-shadow);
    }


    .profile-edit-notice-icon {
        width: 44px;
        height: 44px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        background:
            var(--edit-blue-soft);

        color:
            var(--edit-blue);

        font-size: 15px;
        font-weight: 900;
    }


    .profile-edit-notice strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--edit-text);

        font-size: 16px;
        font-weight: 850;
    }


    .profile-edit-notice span {
        color:
            var(--edit-body);

        font-size: 15px;

        line-height: 1.65;
    }


    /* ================================================================
       ERRORS
       ================================================================ */

    .profile-error-box {
        margin-bottom: 25px;

        padding:
            19px
            21px;

        border:
            1px solid
            #EDC6C1;

        border-radius: 15px;

        background:
            var(--edit-red-soft);

        color:
            var(--edit-red);
    }


    .profile-error-box strong {
        display: block;

        margin-bottom: 8px;

        font-size: 16px;
        font-weight: 850;
    }


    .profile-error-box ul {
        margin: 0;

        padding-left: 22px;

        font-size: 15px;

        line-height: 1.7;
    }


    /* ================================================================
       LAYOUT
       ================================================================ */

    .profile-edit-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1.35fr)
            minmax(350px, 0.65fr);

        gap: 23px;

        align-items: start;
    }


    .profile-edit-main,
    .profile-edit-sidebar {
        display: grid;

        gap: 23px;
    }


    .profile-edit-sidebar {
        position: sticky;

        top: 170px;
    }


    /* ================================================================
       PANEL
       ================================================================ */

    .profile-edit-panel {
        overflow: hidden;

        border:
            1px solid
            var(--edit-border);

        border-radius: 20px;

        background:
            var(--edit-white);

        box-shadow:
            var(--edit-shadow);
    }


    .profile-edit-panel-header {
        display: flex;
        align-items: center;

        gap: 14px;

        padding:
            24px
            26px;

        border-bottom:
            1px solid
            var(--edit-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .profile-edit-panel-icon {
        width: 50px;
        height: 50px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        font-size: 13px;
        font-weight: 900;
    }


    .panel-blue {
        background:
            var(--edit-blue-soft);

        color:
            var(--edit-blue);
    }


    .panel-teal {
        background:
            var(--edit-teal-soft);

        color:
            var(--edit-teal);
    }


    .panel-orange {
        background:
            var(--edit-orange-soft);

        color:
            var(--edit-orange);
    }


    .panel-purple {
        background:
            var(--edit-purple-soft);

        color:
            var(--edit-purple);
    }


    .panel-green {
        background:
            var(--edit-green-soft);

        color:
            var(--edit-green);
    }


    .profile-edit-panel-header h2 {
        margin:
            0
            0
            4px;

        color:
            var(--edit-text);

        font-size: 23px;
        font-weight: 850;

        line-height: 1.3;
    }


    .profile-edit-panel-header p {
        margin: 0;

        color:
            var(--edit-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .profile-edit-panel-body {
        padding:
            26px;
    }


    /* ================================================================
       ACCOUNT IDENTITY
       ================================================================ */

    .profile-account-card {
        display: flex;
        align-items: center;

        gap: 18px;

        padding:
            19px;

        border:
            1px solid
            #D5E3F2;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                #F8FBFF 0%,
                #EFF6FD 100%
            );
    }


    .profile-account-avatar {
        width: 66px;
        height: 66px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 18px;

        background:
            var(--edit-blue-soft);

        color:
            var(--edit-blue);

        font-size: 18px;
        font-weight: 900;
    }


    .profile-account-name {
        display: block;

        margin-bottom: 4px;

        color:
            var(--edit-text);

        font-size: 20px;
        font-weight: 900;
    }


    .profile-account-email {
        display: block;

        color:
            var(--edit-body);

        font-size: 15px;

        line-height: 1.55;
    }


    .profile-account-note {
        display: block;

        margin-top: 5px;

        color:
            var(--edit-muted);

        font-size: 14px;
    }


    /* ================================================================
       FORM GRID
       ================================================================ */

    .profile-form-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            21px
            18px;
    }


    .profile-form-group {
        min-width: 0;
    }


    .profile-form-full {
        grid-column:
            1 / -1;
    }


    /* ================================================================
       LABELS
       ================================================================ */

    .profile-form-label {
        display: flex;
        align-items: center;

        gap: 7px;

        margin-bottom: 9px;

        color:
            var(--edit-text);

        font-size: 15px;
        font-weight: 850;
    }


    .profile-required {
        color:
            var(--edit-red);

        font-weight: 900;
    }


    .profile-optional {
        color:
            var(--edit-muted);

        font-size: 13px;
        font-weight: 700;
    }


    /* ================================================================
       INPUTS
       ================================================================ */

    .profile-form-input,
    .profile-form-select,
    .profile-form-textarea {
        width: 100%;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background:
            #FBFDFF;

        color:
            var(--edit-text);

        font-family:
            "Segoe UI",
            Arial,
            sans-serif;

        font-size: 16px;
        font-weight: 600;

        transition:
            var(--edit-transition);
    }


    .profile-form-input,
    .profile-form-select {
        min-height: 54px;

        padding:
            0
            15px;
    }


    .profile-form-textarea {
        min-height: 125px;

        resize: vertical;

        padding:
            14px
            15px;

        line-height: 1.6;
    }


    .profile-form-input::placeholder,
    .profile-form-textarea::placeholder {
        color:
            #8A9AAB;
    }


    .profile-form-input:focus,
    .profile-form-select:focus,
    .profile-form-textarea:focus {
        border-color:
            var(--edit-blue);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, 0.09);
    }


    .profile-form-input.is-invalid,
    .profile-form-select.is-invalid,
    .profile-form-textarea.is-invalid {
        border-color:
            #D8675B;

        background:
            #FFFDFC;
    }


    /* ================================================================
       HELP TEXT
       ================================================================ */

    .profile-form-help {
        display: block;

        margin-top: 8px;

        color:
            var(--edit-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .profile-field-error {
        display: block;

        margin-top: 7px;

        color:
            var(--edit-red);

        font-size: 14px;
        font-weight: 750;

        line-height: 1.55;
    }


    /* ================================================================
       FORM SECTION DIVIDER
       ================================================================ */

    .profile-form-divider {
        grid-column:
            1 / -1;

        height: 1px;

        margin:
            2px
            0;

        background:
            var(--edit-border-soft);
    }


    /* ================================================================
       ACTION BAR
       ================================================================ */

    .profile-edit-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 12px;

        margin-top: 25px;

        padding-top: 22px;

        border-top:
            1px solid
            var(--edit-border-soft);
    }


    .profile-cancel-button,
    .profile-save-button {
        min-height: 52px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            20px;

        border-radius: 12px;

        font-family:
            inherit;

        font-size: 15px;
        font-weight: 850;

        text-decoration: none;

        cursor: pointer;

        transition:
            var(--edit-transition);
    }


    .profile-cancel-button {
        border:
            1px solid
            var(--edit-border);

        background:
            #FFFFFF;

        color:
            var(--edit-navy);
    }


    .profile-cancel-button:hover {
        background:
            #F5F8FB;

        border-color:
            #B9C9D8;
    }


    .profile-save-button {
        min-width: 180px;

        border:
            1px solid
            var(--edit-navy);

        background:
            var(--edit-navy);

        color:
            #FFFFFF;
    }


    .profile-save-button:hover {
        transform:
            translateY(-1px);

        background:
            var(--edit-navy-dark);

        box-shadow:
            0 12px 25px
            rgba(16, 42, 74, 0.15);
    }


    /* ================================================================
       SIDEBAR INFORMATION
       ================================================================ */

    .profile-sidebar-list {
        display: grid;

        gap: 12px;
    }


    .profile-sidebar-item {
        padding:
            14px
            15px;

        border:
            1px solid
            var(--edit-border-soft);

        border-radius: 12px;

        background:
            var(--edit-soft);
    }


    .profile-sidebar-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--edit-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: 0.3px;
    }


    .profile-sidebar-value {
        display: block;

        color:
            var(--edit-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.55;

        word-break: break-word;
    }


    /* ================================================================
       CHECKLIST
       ================================================================ */

    .profile-edit-checklist {
        display: grid;

        gap: 12px;
    }


    .profile-edit-check-item {
        display: flex;
        align-items: center;

        gap: 11px;

        padding:
            14px;

        border:
            1px solid
            var(--edit-border-soft);

        border-radius: 12px;

        background:
            #FBFCFE;
    }


    .profile-edit-check-icon {
        width: 35px;
        height: 35px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        background:
            var(--edit-green-soft);

        color:
            var(--edit-green);

        font-size: 13px;
        font-weight: 900;
    }


    .profile-edit-check-title {
        display: block;

        margin-bottom: 2px;

        color:
            var(--edit-text);

        font-size: 15px;
        font-weight: 850;
    }


    .profile-edit-check-description {
        color:
            var(--edit-body);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       SECURITY NOTE
       ================================================================ */

    .profile-security-note {
        padding:
            16px;

        border:
            1px solid
            #D5E4F2;

        border-radius: 13px;

        background:
            #F5FAFE;

        color:
            var(--edit-body);

        font-size: 15px;

        line-height: 1.7;
    }


    .profile-security-note strong {
        color:
            var(--edit-text);
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1150px) {

        .profile-edit-layout {
            grid-template-columns:
                1fr;
        }


        .profile-edit-sidebar {
            position: static;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 850px) {

        .profile-edit-hero {
            padding:
                34px
                28px;
        }


        .profile-edit-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .profile-edit-back {
            width: 100%;
        }


        .profile-edit-sidebar {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 650px) {

        .profile-edit-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .profile-edit-identity {
            flex-direction: column;

            align-items: flex-start;
        }


        .profile-edit-hero h1 {
            font-size: 31px;
        }


        .profile-edit-description {
            font-size: 16px;
        }


        .profile-form-grid {
            grid-template-columns:
                1fr;
        }


        .profile-form-full,
        .profile-form-divider {
            grid-column: auto;
        }


        .profile-edit-panel-header,
        .profile-edit-panel-body {
            padding-left: 20px;
            padding-right: 20px;
        }


        .profile-edit-panel-header h2 {
            font-size: 21px;
        }


        .profile-edit-actions {
            flex-direction: column-reverse;

            align-items: stretch;
        }


        .profile-cancel-button,
        .profile-save-button {
            width: 100%;
        }


        .profile-account-card {
            flex-direction: column;

            align-items: flex-start;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Student Account
    |--------------------------------------------------------------------------
    */

    $student =
        auth()->user();


    /*
    |--------------------------------------------------------------------------
    | Student Profile
    |--------------------------------------------------------------------------
    */

    $studentProfile =
        $profile
        ?? $student?->studentProfile;


    /*
    |--------------------------------------------------------------------------
    | Initials
    |--------------------------------------------------------------------------
    */

    $studentName =
        $student?->name
        ?? 'Student';


    $nameParts =
        preg_split(
            '/\s+/',
            trim($studentName)
        );


    $studentInitials =
        collect($nameParts)
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
            ->implode('');


    /*
    |--------------------------------------------------------------------------
    | Route Helpers
    |--------------------------------------------------------------------------
    */

    $showAction =
        \Illuminate\Support\Facades\Route::has(
            'student.profile.show'
        )
            ? route(
                'student.profile.show'
            )
            : url(
                '/student/profile'
            );


    $updateAction =
        \Illuminate\Support\Facades\Route::has(
            'student.profile.update'
        )
            ? route(
                'student.profile.update'
            )
            : url(
                '/student/profile'
            );


    /*
    |--------------------------------------------------------------------------
    | Optional Emergency Contact Values
    |--------------------------------------------------------------------------
    |
    | Keep both edit inputs visible even when the current profile does not yet
    | have values for these optional fields.
    |
    */

    $profileAttributes =
        $studentProfile
            ? $studentProfile->getAttributes()
            : [];


    /*
    |--------------------------------------------------------------------------
    | Account Status
    |--------------------------------------------------------------------------
    */

    $accountStatus =
        strtolower(
            (string) (
                $student?->status
                ?? 'active'
            )
        );


    /*
    |--------------------------------------------------------------------------
    | Existing OJT Assignments
    |--------------------------------------------------------------------------
    */

    $assignmentCount =
        $studentProfile
            ? $studentProfile
                ->ojtAssignments()
                ->count()
            : 0;


    $activeAssignment =
        $studentProfile
            ? $studentProfile
                ->ojtAssignments()
                ->with([
                    'company',
                    'supervisor',
                ])
                ->where(
                    'status',
                    \App\Models\OjtAssignment::STATUS_ACTIVE
                )
                ->latest(
                    'start_date'
                )
                ->first()
            : null;

@endphp


<div class="student-profile-edit-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="profile-edit-hero">


        <div class="profile-edit-hero-inner">


            <div class="profile-edit-identity">


                <div class="profile-edit-avatar">

                    {{ $studentInitials ?: 'ST' }}

                </div>


                <div class="profile-edit-copy">


                    <div class="profile-edit-eyebrow">


                        <span class="profile-edit-dot"></span>


                        Student Portal · Profile Management


                    </div>


                    <h1>
                        Edit My Profile
                    </h1>


                    <p class="profile-edit-description">

                        Review and update your academic,
                        contact, residential, and emergency
                        information. Keeping these details
                        accurate helps maintain reliable OJT records.

                    </p>


                </div>


            </div>


            <a
                href="{{ $showAction }}"
                class="profile-edit-back"
            >
                ← Back to My Profile
            </a>


        </div>


    </section>


    {{-- ==================================================================
         NOTICE
         ================================================================== --}}

    <section class="profile-edit-notice">


        <div class="profile-edit-notice-icon">
            i
        </div>


        <div>


            <strong>
                Please review your information carefully before saving.
            </strong>


            <span>

                Changes to your Student information may also appear
                in OJT monitoring records and reports. Make sure the
                details you provide are accurate and current.

            </span>


        </div>


    </section>


    {{-- ==================================================================
         VALIDATION SUMMARY
         ================================================================== --}}

    @if ($errors->any())


        <section class="profile-error-box">


            <strong>
                Please correct the following information:
            </strong>


            <ul>

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>


        </section>


    @endif


    <div class="profile-edit-layout">


        {{-- ==============================================================
             MAIN FORM
             ============================================================== --}}

        <main class="profile-edit-main">


            <form
                method="POST"
                action="{{ $updateAction }}"
            >

                @csrf

                @method('PUT')


                {{-- ======================================================
                     ACCOUNT IDENTITY
                     ====================================================== --}}

                <section class="profile-edit-panel">


                    <div class="profile-edit-panel-header">


                        <div class="profile-edit-panel-icon panel-blue">
                            US
                        </div>


                        <div>


                            <h2>
                                Student Account
                            </h2>


                            <p>
                                Your authenticated OJT Sync account
                            </p>


                        </div>


                    </div>


                    <div class="profile-edit-panel-body">


                        <div class="profile-account-card">


                            <div class="profile-account-avatar">

                                {{ $studentInitials ?: 'ST' }}

                            </div>


                            <div>


                                <span class="profile-account-name">

                                    {{ $studentName }}

                                </span>


                                <span class="profile-account-email">

                                    {{ $student?->email
                                        ?: 'Email unavailable'
                                    }}

                                </span>


                                <span class="profile-account-note">

                                    Account identity is shown here
                                    for reference while editing your
                                    Student Profile.

                                </span>


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ======================================================
                     ACADEMIC INFORMATION
                     ====================================================== --}}

                <section
                    class="profile-edit-panel"
                    style="margin-top:23px;"
                >


                    <div class="profile-edit-panel-header">


                        <div class="profile-edit-panel-icon panel-purple">
                            AC
                        </div>


                        <div>


                            <h2>
                                Academic Information
                            </h2>


                            <p>
                                Student number, program, year level, and section
                            </p>


                        </div>


                    </div>


                    <div class="profile-edit-panel-body">


                        <div class="profile-form-grid">


                            {{-- ==========================================
                                 STUDENT NUMBER
                                 ========================================== --}}

                            <div class="profile-form-group">


                                <label
                                    for="student_number"
                                    class="profile-form-label"
                                >
                                    Student Number

                                    <span class="profile-required">
                                        *
                                    </span>
                                </label>


                                <input
                                    id="student_number"
                                    type="text"
                                    name="student_number"
                                    value="{{ old(
                                        'student_number',
                                        $studentProfile?->student_number
                                    ) }}"
                                    class="
                                        profile-form-input
                                        @error('student_number')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="Enter your Student number"
                                    autocomplete="off"
                                    required
                                >


                                <span class="profile-form-help">

                                    Use the official Student number
                                    issued by your institution.

                                </span>


                                @error('student_number')

                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==========================================
                                 PROGRAM
                                 ========================================== --}}

                            <div class="profile-form-group">


                                <label
                                    for="program"
                                    class="profile-form-label"
                                >
                                    Academic Program

                                    <span class="profile-required">
                                        *
                                    </span>
                                </label>


                                <input
                                    id="program"
                                    type="text"
                                    name="program"
                                    value="{{ old(
                                        'program',
                                        $studentProfile?->program
                                    ) }}"
                                    class="
                                        profile-form-input
                                        @error('program')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="Example: BS Information Technology"
                                    required
                                >


                                <span class="profile-form-help">

                                    Enter your complete
                                    academic program or course.

                                </span>


                                @error('program')

                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==========================================
                                 YEAR LEVEL
                                 ========================================== --}}

                            <div class="profile-form-group">


                                <label
                                    for="year_level"
                                    class="profile-form-label"
                                >
                                    Year Level

                                    <span class="profile-required">
                                        *
                                    </span>
                                </label>


                                <input
                                    id="year_level"
                                    type="text"
                                    name="year_level"
                                    value="{{ old(
                                        'year_level',
                                        $studentProfile?->year_level
                                    ) }}"
                                    class="
                                        profile-form-input
                                        @error('year_level')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="Example: 4th Year"
                                    required
                                >


                                <span class="profile-form-help">

                                    Enter your current
                                    academic year level.

                                </span>


                                @error('year_level')

                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==========================================
                                 SECTION
                                 ========================================== --}}

                            <div class="profile-form-group">


                                <label
                                    for="section"
                                    class="profile-form-label"
                                >
                                    Section

                                    <span class="profile-optional">
                                        Optional
                                    </span>
                                </label>


                                <input
                                    id="section"
                                    type="text"
                                    name="section"
                                    value="{{ old(
                                        'section',
                                        $studentProfile?->section
                                    ) }}"
                                    class="
                                        profile-form-input
                                        @error('section')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="Example: B2"
                                >


                                <span class="profile-form-help">

                                    Enter your section if
                                    your program uses one.

                                </span>


                                @error('section')

                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ======================================================
                     CONTACT INFORMATION
                     ====================================================== --}}

                <section
                    class="profile-edit-panel"
                    style="margin-top:23px;"
                >


                    <div class="profile-edit-panel-header">


                        <div class="profile-edit-panel-icon panel-teal">
                            CT
                        </div>


                        <div>


                            <h2>
                                Contact Information
                            </h2>


                            <p>
                                Keep your phone number and address current
                            </p>


                        </div>


                    </div>


                    <div class="profile-edit-panel-body">


                        <div class="profile-form-grid">


                            {{-- ==========================================
                                 CONTACT NUMBER
                                 ========================================== --}}

                            <div class="profile-form-group">


                                <label
                                    for="contact_number"
                                    class="profile-form-label"
                                >
                                    Contact Number

                                    <span class="profile-required">
                                        *
                                    </span>
                                </label>


                                <input
                                    id="contact_number"
                                    type="text"
                                    name="contact_number"
                                    value="{{ old(
                                        'contact_number',
                                        $studentProfile?->contact_number
                                    ) }}"
                                    class="
                                        profile-form-input
                                        @error('contact_number')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="Example: 0912 345 6789"
                                    autocomplete="tel"
                                    required
                                >


                                <span class="profile-form-help">

                                    Enter a contact number
                                    where you can currently be reached.

                                </span>


                                @error('contact_number')

                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==========================================
                                 ACCOUNT EMAIL - READ ONLY DISPLAY
                                 ========================================== --}}

                            <div class="profile-form-group">


                                <label
                                    for="account_email"
                                    class="profile-form-label"
                                >
                                    Account Email
                                </label>


                                <input
                                    id="account_email"
                                    type="email"
                                    value="{{ $student?->email }}"
                                    class="profile-form-input"
                                    disabled
                                >


                                <span class="profile-form-help">

                                    This is your authenticated
                                    OJT Sync account email.

                                </span>


                            </div>


                            {{-- ==========================================
                                 ADDRESS
                                 ========================================== --}}

                            <div
                                class="
                                    profile-form-group
                                    profile-form-full
                                "
                            >


                                <label
                                    for="address"
                                    class="profile-form-label"
                                >
                                    Residential Address

                                    <span class="profile-required">
                                        *
                                    </span>
                                </label>


                                <textarea
                                    id="address"
                                    name="address"
                                    class="
                                        profile-form-textarea
                                        @error('address')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="Enter your complete current residential address"
                                    required
                                >{{ old(
                                    'address',
                                    $studentProfile?->address
                                ) }}</textarea>


                                <span class="profile-form-help">

                                    Enter enough address information
                                    to correctly identify your
                                    current residence.

                                </span>


                                @error('address')

                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ======================================================
                     EMERGENCY CONTACT
                     ====================================================== --}}

                <section
                    class="profile-edit-panel"
                    style="margin-top:23px;"
                >


                    <div class="profile-edit-panel-header">


                        <div class="profile-edit-panel-icon panel-orange">
                            EC
                        </div>


                        <div>


                            <h2>
                                Emergency Contact
                            </h2>


                            <p>
                                Person who may be contacted when necessary
                            </p>


                        </div>


                    </div>


                    <div class="profile-edit-panel-body">


                        <div class="profile-form-grid">


                            {{-- ==========================================
                                 EMERGENCY NAME
                                 ========================================== --}}

                            <div class="profile-form-group">


                                <label
                                    for="emergency_contact_name"
                                    class="profile-form-label"
                                >
                                    Contact Person

                                    <span class="profile-required">
                                        *
                                    </span>
                                </label>


                                <input
                                    id="emergency_contact_name"
                                    type="text"
                                    name="emergency_contact_name"
                                    value="{{ old(
                                        'emergency_contact_name',
                                        $studentProfile?->emergency_contact_name
                                    ) }}"
                                    class="
                                        profile-form-input
                                        @error('emergency_contact_name')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="Enter emergency contact person's name"
                                    required
                                >


                                @error('emergency_contact_name')

                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==========================================
                                 EMERGENCY NUMBER
                                 ========================================== --}}

                            <div class="profile-form-group">


                                <label
                                    for="emergency_contact_number"
                                    class="profile-form-label"
                                >
                                    Contact Number

                                    <span class="profile-required">
                                        *
                                    </span>
                                </label>


                                <input
                                    id="emergency_contact_number"
                                    type="text"
                                    name="emergency_contact_number"
                                    value="{{ old(
                                        'emergency_contact_number',
                                        $studentProfile?->emergency_contact_number
                                    ) }}"
                                    class="
                                        profile-form-input
                                        @error('emergency_contact_number')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="Example: 0912 345 6789"
                                    required
                                >


                                @error('emergency_contact_number')

                                    <span class="profile-field-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==========================================
                                 EMERGENCY CONTACT RELATIONSHIP
                                 ========================================== --}}

                                <div class="profile-form-group">


                                    <label
                                        for="emergency_contact_relationship"
                                        class="profile-form-label"
                                    >
                                        Relationship

                                        <span class="profile-optional">
                                            Optional
                                        </span>
                                    </label>


                                    <input
                                        id="emergency_contact_relationship"
                                        type="text"
                                        name="emergency_contact_relationship"
                                        value="{{ old(
                                            'emergency_contact_relationship',
                                            ($profileAttributes['emergency_contact_relationship'] ?? null)
                                        ) }}"
                                        class="
                                            profile-form-input
                                            @error('emergency_contact_relationship')
                                                is-invalid
                                            @enderror
                                        "
                                        placeholder="Example: Parent, Guardian, Sibling"
                                        maxlength="100"
                                    >


                                    <span class="profile-form-help">
                                        Enter your relationship to this emergency contact.
                                    </span>


                                    @error('emergency_contact_relationship')

                                        <span class="profile-field-error">
                                            {{ $message }}
                                        </span>

                                    @enderror


                                </div>


                            {{-- ==========================================
                                 EMERGENCY CONTACT ADDRESS
                                 ========================================== --}}

                                <div
                                    class="profile-form-group"
                                >


                                    <label
                                        for="emergency_contact_address"
                                        class="profile-form-label"
                                    >
                                        Contact Address

                                        <span class="profile-optional">
                                            Optional
                                        </span>
                                    </label>


                                    <textarea
                                        id="emergency_contact_address"
                                        name="emergency_contact_address"
                                        class="
                                            profile-form-textarea
                                            @error('emergency_contact_address')
                                                is-invalid
                                            @enderror
                                        "
                                        placeholder="Enter the emergency contact's complete address"
                                        maxlength="500"
                                    >{{ old(
                                        'emergency_contact_address',
                                        ($profileAttributes['emergency_contact_address'] ?? null)
                                    ) }}</textarea>


                                    <span class="profile-form-help">
                                        Enter the address where this person can be reached.
                                    </span>


                                    @error('emergency_contact_address')

                                        <span class="profile-field-error">
                                            {{ $message }}
                                        </span>

                                    @enderror


                                </div>


                        </div>


                    </div>


                </section>


                {{-- ======================================================
                     ACTIONS
                     ====================================================== --}}

                <div class="profile-edit-actions">


                    <a
                        href="{{ $showAction }}"
                        class="profile-cancel-button"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="profile-save-button"
                    >
                        Save Profile Changes
                    </button>


                </div>


            </form>


        </main>


        {{-- ==============================================================
             SIDEBAR
             ============================================================== --}}

        <aside class="profile-edit-sidebar">


            {{-- ==========================================================
                 CURRENT ACCOUNT
                 ========================================================== --}}

            <section class="profile-edit-panel">


                <div class="profile-edit-panel-header">


                    <div class="profile-edit-panel-icon panel-blue">
                        ID
                    </div>


                    <div>


                        <h2>
                            Current Account
                        </h2>


                        <p>
                            Student account overview
                        </p>


                    </div>


                </div>


                <div class="profile-edit-panel-body">


                    <div class="profile-sidebar-list">


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Student Name
                            </span>


                            <span class="profile-sidebar-value">

                                {{ $studentName }}

                            </span>


                        </div>


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Email Address
                            </span>


                            <span class="profile-sidebar-value">

                                {{ $student?->email
                                    ?: 'Not available'
                                }}

                            </span>


                        </div>


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Account Role
                            </span>


                            <span class="profile-sidebar-value">
                                Student
                            </span>


                        </div>


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Account Status
                            </span>


                            <span class="profile-sidebar-value">

                                {{ ucfirst(
                                    $accountStatus
                                ) }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 OJT CONNECTION
                 ========================================================== --}}

            <section class="profile-edit-panel">


                <div class="profile-edit-panel-header">


                    <div class="profile-edit-panel-icon panel-purple">
                        OJ
                    </div>


                    <div>


                        <h2>
                            OJT Connection
                        </h2>


                        <p>
                            Placement information linked to your profile
                        </p>


                    </div>


                </div>


                <div class="profile-edit-panel-body">


                    <div class="profile-sidebar-list">


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Total Assignments
                            </span>


                            <span class="profile-sidebar-value">

                                {{ $assignmentCount }}

                            </span>


                        </div>


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Active Company
                            </span>


                            <span class="profile-sidebar-value">

                                {{ $activeAssignment
                                    ? (
                                        $activeAssignment
                                            ->company
                                            ?->name
                                        ?? 'Company unavailable'
                                    )
                                    : 'No active placement'
                                }}

                            </span>


                        </div>


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Assigned Supervisor
                            </span>


                            <span class="profile-sidebar-value">

                                {{ $activeAssignment
                                    ? (
                                        $activeAssignment
                                            ->supervisor
                                            ?->name
                                        ?? 'Not assigned'
                                    )
                                    : 'None'
                                }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 PROFILE GUIDANCE
                 ========================================================== --}}

            <section class="profile-edit-panel">


                <div class="profile-edit-panel-header">


                    <div class="profile-edit-panel-icon panel-green">
                        CK
                    </div>


                    <div>


                        <h2>
                            Before Saving
                        </h2>


                        <p>
                            Quick profile review
                        </p>


                    </div>


                </div>


                <div class="profile-edit-panel-body">


                    <div class="profile-edit-checklist">


                        <div class="profile-edit-check-item">


                            <div class="profile-edit-check-icon">
                                ✓
                            </div>


                            <div>


                                <span class="profile-edit-check-title">
                                    Use Accurate Information
                                </span>


                                <span class="profile-edit-check-description">

                                    Make sure your Student
                                    number and academic details
                                    match your official records.

                                </span>


                            </div>


                        </div>


                        <div class="profile-edit-check-item">


                            <div class="profile-edit-check-icon">
                                ✓
                            </div>


                            <div>


                                <span class="profile-edit-check-title">
                                    Check Your Contact Number
                                </span>


                                <span class="profile-edit-check-description">

                                    Use a phone number
                                    where you can currently
                                    be reached.

                                </span>


                            </div>


                        </div>


                        <div class="profile-edit-check-item">


                            <div class="profile-edit-check-icon">
                                ✓
                            </div>


                            <div>


                                <span class="profile-edit-check-title">
                                    Review Emergency Contact
                                </span>


                                <span class="profile-edit-check-description">

                                    Confirm that the emergency
                                    contact details are still
                                    valid and current.

                                </span>


                            </div>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 PRIVACY
                 ========================================================== --}}

            <section class="profile-edit-panel">


                <div class="profile-edit-panel-header">


                    <div class="profile-edit-panel-icon panel-teal">
                        SEC
                    </div>


                    <div>


                        <h2>
                            Profile Security
                        </h2>


                        <p>
                            Keep sensitive credentials private
                        </p>


                    </div>


                </div>


                <div class="profile-edit-panel-body">


                    <div class="profile-security-note">

                        <strong>
                            Never enter your password here.
                        </strong>

                        This page is intended only for ordinary
                        Student Profile information. Passwords,
                        verification codes, authentication tokens,
                        PINs, and similar secrets should never be
                        stored in profile fields.

                    </div>


                </div>


            </section>


        </aside>


    </div>


</div>


@endsection