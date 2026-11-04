
@extends('layouts.app')

@section('title', 'Create Student Account | OJT Sync')

@push('styles')
<style>
    /* ================================================================
       OJT SYNC
       ADMIN - CREATE STUDENT ACCOUNT
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --sc-navy: #183B6B;
        --sc-navy-dark: #102A4A;
        --sc-navy-deep: #0B223D;

        --sc-blue: #2563EB;
        --sc-blue-light: #60A5FA;
        --sc-blue-soft: #EAF2FF;

        --sc-teal: #0F766E;
        --sc-teal-soft: #E7F7F5;

        --sc-green: #15803D;
        --sc-green-soft: #EAF8EF;

        --sc-orange: #B45309;
        --sc-orange-soft: #FFF5E6;

        --sc-red: #B42318;
        --sc-red-soft: #FFF0EE;

        --sc-purple: #6D4FC2;
        --sc-purple-soft: #F2EEFF;

        --sc-text: #102A4A;
        --sc-body: #405872;
        --sc-muted: #64778C;

        --sc-white: #FFFFFF;
        --sc-soft: #F8FBFE;
        --sc-soft-blue: #F3F8FD;

        --sc-border: #D8E3EE;
        --sc-border-soft: #E7EDF4;

        --sc-shadow: 0 12px 32px rgba(15, 42, 74, 0.07);
        --sc-shadow-large: 0 22px 54px rgba(15, 42, 74, 0.13);

        --sc-transition: all 0.22s ease;
    }

    /* ================================================================
       PAGE
       ================================================================ */

    .student-create-page {
        width: 100%;
        color: var(--sc-text);

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

    .student-create-hero {
        position: relative;
        overflow: hidden;

        margin-bottom: 30px;
        padding: 42px 44px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 88% 14%,
                rgba(96, 165, 250, 0.25),
                transparent 27%
            ),
            radial-gradient(
                circle at 70% 95%,
                rgba(45, 212, 191, 0.11),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 55%,
                #285F98 100%
            );

        box-shadow: var(--sc-shadow-large);
    }

    .student-create-hero::before {
        content: "";
        position: absolute;

        width: 390px;
        height: 390px;

        top: -230px;
        right: -150px;

        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
    }

    .student-create-hero::after {
        content: "";
        position: absolute;

        width: 220px;
        height: 220px;

        right: 290px;
        bottom: -160px;

        border-radius: 50%;
        background: rgba(255, 255, 255, 0.04);
    }

    .student-create-hero-inner {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }

    .student-create-hero-copy {
        max-width: 760px;
    }

    .student-create-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;
        margin-bottom: 11px;
        padding: 7px 12px;

        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 999px;

        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.92);

        font-size: 14px;
        font-weight: 800;
    }

    .student-create-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;
        background: var(--sc-blue-light);

        box-shadow:
            0 0 0 5px rgba(96, 165, 250, 0.14);
    }

    .student-create-hero h1 {
        margin: 0 0 10px;

        color: #FFFFFF;
        font-size: 38px;
        font-weight: 900;

        line-height: 1.18;
        letter-spacing: -0.5px;
    }

    .student-create-hero-description {
        margin: 0;

        color: rgba(255, 255, 255, 0.82);
        font-size: 17px;
        line-height: 1.7;
    }

    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .student-create-hero-actions {
        width: 255px;
        flex-shrink: 0;

        display: grid;
        gap: 10px;
    }

    .student-create-hero-button {
        min-height: 52px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 0 17px;

        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 12px;

        text-decoration: none;
        font-size: 15px;
        font-weight: 850;

        transition: var(--sc-transition);
    }

    .student-create-hero-button-primary {
        background: #FFFFFF;
        color: var(--sc-navy);
    }

    .student-create-hero-button-primary:hover {
        transform: translateY(-2px);
        background: #F8FBFF;
    }

    .student-create-hero-button-secondary {
        background: rgba(255, 255, 255, 0.09);
        color: #FFFFFF;
    }

    .student-create-hero-button-secondary:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.15);
    }

    /* ================================================================
       INTRO CARDS
       ================================================================ */

    .student-create-intro {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));

        gap: 18px;
        margin-bottom: 27px;
    }

    .student-create-intro-card {
        display: flex;
        align-items: flex-start;

        gap: 13px;
        padding: 19px;

        border: 1px solid var(--sc-border);
        border-radius: 17px;

        background: #FFFFFF;
        box-shadow: var(--sc-shadow);
    }

    .student-create-intro-icon {
        width: 46px;
        height: 46px;
        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;
        font-size: 12px;
        font-weight: 900;
    }

    .intro-blue {
        background: var(--sc-blue-soft);
        color: var(--sc-blue);
    }

    .intro-green {
        background: var(--sc-green-soft);
        color: var(--sc-green);
    }

    .intro-purple {
        background: var(--sc-purple-soft);
        color: var(--sc-purple);
    }

    .student-create-intro-title {
        display: block;
        margin-bottom: 3px;

        color: var(--sc-text);
        font-size: 16px;
        font-weight: 900;
    }

    .student-create-intro-description {
        display: block;

        color: var(--sc-muted);
        font-size: 14px;
        line-height: 1.55;
    }

    /* ================================================================
       MAIN LAYOUT
       ================================================================ */

    .student-create-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr) 340px;

        gap: 24px;
        align-items: start;
    }

    .student-create-main,
    .student-create-sidebar {
        display: grid;
        gap: 22px;
    }

    /* ================================================================
       PANELS
       ================================================================ */

    .student-create-panel {
        overflow: hidden;

        border: 1px solid var(--sc-border);
        border-radius: 20px;

        background: #FFFFFF;
        box-shadow: var(--sc-shadow);
    }

    .student-create-panel-header {
        display: flex;
        align-items: center;

        gap: 14px;
        padding: 22px 23px;

        border-bottom: 1px solid var(--sc-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }

    .student-create-panel-icon {
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
        background: var(--sc-blue-soft);
        color: var(--sc-blue);
    }

    .panel-purple {
        background: var(--sc-purple-soft);
        color: var(--sc-purple);
    }

    .panel-teal {
        background: var(--sc-teal-soft);
        color: var(--sc-teal);
    }

    .student-create-panel-header h2 {
        margin: 0 0 3px;

        color: var(--sc-text);
        font-size: 23px;
        font-weight: 900;
        line-height: 1.3;
    }

    .student-create-panel-header p {
        margin: 0;

        color: var(--sc-muted);
        font-size: 14px;
    }

    .student-create-panel-body {
        padding: 24px;
    }

    /* ================================================================
       FORM GRID
       ================================================================ */

    .student-create-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 21px 20px;

        align-items: start;
    }

    /* ================================================================
       FIELD ALIGNMENT FIX
       ================================================================ */

    .student-create-field {
        display: flex;
        flex-direction: column;

        align-self: start;

        min-width: 0;
        width: 100%;

        gap: 7px;
    }

    /*
       IMPORTANT FIX:

       Using flex-direction: column prevents
       the individual fields from stretching
       their internal rows differently.

       Full Name and Email Address will now
       have matching input positions and heights,
       even when their help texts have
       different numbers of lines.
    */

    .student-create-field-full {
        grid-column: 1 / -1;
    }

    .student-create-label {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        width: 100%;

        color: var(--sc-text);
        font-size: 15px;
        font-weight: 850;

        line-height: 1.5;
    }

    .student-create-required {
        color: var(--sc-red);
        font-size: 13px;
        font-weight: 800;

        white-space: nowrap;
    }

    /* ================================================================
       MATCHING INPUT BOXES
       ================================================================ */

    .student-create-input,
    .student-create-select {
        display: block;

        box-sizing: border-box;

        width: 100%;
        height: 56px;
        min-height: 56px;

        margin: 0;

        border: 1px solid #C9D6E3;
        border-radius: 12px;

        outline: none;

        background: #FBFDFF;
        color: var(--sc-text);

        font-family: inherit;
        font-size: 16px;
        font-weight: 650;

        line-height: normal;

        transition: var(--sc-transition);
    }

    .student-create-input {
        padding: 0 15px;
    }

    .student-create-select {
        padding: 0 14px;
        cursor: pointer;
    }

    .student-create-input::placeholder {
        color: #8A9CAF;
        font-weight: 500;
    }

    .student-create-input:focus,
    .student-create-select:focus {
        border-color: var(--sc-blue);
        background: #FFFFFF;

        box-shadow:
            0 0 0 4px rgba(37, 99, 235, 0.09);
    }

    .student-create-input.is-invalid,
    .student-create-select.is-invalid {
        border-color: var(--sc-red);
        background: #FFFDFD;
    }

    .student-create-help {
        display: block;
        width: 100%;

        color: var(--sc-muted);
        font-size: 14px;
        line-height: 1.55;
    }

    .student-create-error {
        display: block;

        color: var(--sc-red);
        font-size: 14px;
        font-weight: 750;
        line-height: 1.5;
    }

    /* ================================================================
       PASSWORD
       ================================================================ */

    .student-password-wrapper {
        position: relative;
        width: 100%;
    }

    .student-password-wrapper .student-create-input {
        padding-right: 104px;
    }

    .student-password-toggle {
        position: absolute;

        top: 50%;
        right: 8px;

        transform: translateY(-50%);

        min-width: 82px;
        height: 39px;

        border: 1px solid var(--sc-border);
        border-radius: 9px;

        background: #FFFFFF;
        color: var(--sc-navy);

        font-family: inherit;
        font-size: 13px;
        font-weight: 850;

        cursor: pointer;
    }

    .student-password-toggle:hover {
        background: var(--sc-blue-soft);
    }

    /* ================================================================
       PASSWORD REQUIREMENTS
       ================================================================ */

    .student-password-rules {
        margin-top: 18px;
        padding: 17px;

        border: 1px solid #D9D2F3;
        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #FBFAFF,
                #F5F2FF
            );
    }

    .student-password-rules-title {
        display: block;
        margin-bottom: 9px;

        color: var(--sc-purple);
        font-size: 16px;
        font-weight: 900;
    }

    .student-password-rule-list {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 8px 12px;
    }

    .student-password-rule {
        display: flex;
        align-items: center;

        gap: 8px;

        color: var(--sc-body);
        font-size: 14px;
    }

    .student-password-rule-dot {
        width: 7px;
        height: 7px;
        flex-shrink: 0;

        border-radius: 50%;
        background: var(--sc-purple);
    }

    /* ================================================================
       STATUS GUIDANCE
       ================================================================ */

    .student-status-guidance {
        margin-top: 17px;
        padding: 16px 17px;

        border: 1px solid #D5E2EF;
        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #F8FBFF 0%,
                #F2F7FD 100%
            );
    }

    .student-status-guidance strong {
        display: block;
        margin-bottom: 5px;

        color: var(--sc-text);
        font-size: 16px;
        font-weight: 900;
    }

    .student-status-guidance p {
        margin: 0;

        color: var(--sc-body);
        font-size: 14px;
        line-height: 1.65;
    }

    /* ================================================================
       FORM ACTIONS
       ================================================================ */

    .student-create-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 10px;
        margin-top: 25px;
        padding-top: 21px;

        border-top: 1px solid var(--sc-border-soft);
    }

    .student-create-button {
        min-height: 51px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 0 19px;

        border: 1px solid var(--sc-border);
        border-radius: 11px;

        font-family: inherit;
        font-size: 15px;
        font-weight: 900;

        text-decoration: none;
        cursor: pointer;

        transition: var(--sc-transition);
    }

    .student-create-button-secondary {
        background: #FFFFFF;
        color: var(--sc-navy);
    }

    .student-create-button-secondary:hover {
        background: var(--sc-blue-soft);
    }

    .student-create-button-primary {
        min-width: 190px;

        border-color: var(--sc-navy);
        background: var(--sc-navy);
        color: #FFFFFF;
    }

    .student-create-button-primary:hover {
        transform: translateY(-1px);
        background: var(--sc-navy-dark);
    }

    .student-create-button-primary:disabled {
        border-color: #7E91A4;
        background: #7E91A4;

        cursor: wait;
        transform: none;
    }

    /* ================================================================
       SIDEBAR
       ================================================================ */

    .student-create-sidebar-list {
        display: grid;
        gap: 12px;
    }

    .student-create-sidebar-item {
        padding: 15px;

        border: 1px solid var(--sc-border-soft);
        border-radius: 12px;

        background: var(--sc-soft);
    }

    .student-create-sidebar-label {
        display: block;
        margin-bottom: 4px;

        color: var(--sc-muted);
        font-size: 13px;
        font-weight: 800;

        text-transform: uppercase;
    }

    .student-create-sidebar-value {
        display: block;

        color: var(--sc-text);
        font-size: 16px;
        font-weight: 850;
        line-height: 1.5;
    }

    /* ================================================================
       SERVER PROTECTION
       ================================================================ */

    .student-create-security {
        padding: 18px;

        border: 1px solid #CAE2D1;
        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #F8FCF9,
                #EFF9F2
            );
    }

    .student-create-security-title {
        display: block;
        margin-bottom: 6px;

        color: var(--sc-green);
        font-size: 17px;
        font-weight: 900;
    }

    .student-create-security p {
        margin: 0;

        color: var(--sc-body);
        font-size: 14px;
        line-height: 1.65;
    }

    /* ================================================================
       NEXT STEP
       ================================================================ */

    .student-create-next-step {
        padding: 18px;

        border: 1px solid #D6DDF5;
        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #FBFCFF,
                #F4F6FF
            );
    }

    .student-create-next-step-title {
        display: block;
        margin-bottom: 6px;

        color: var(--sc-purple);
        font-size: 17px;
        font-weight: 900;
    }

    .student-create-next-step p {
        margin: 0;

        color: var(--sc-body);
        font-size: 14px;
        line-height: 1.65;
    }

    /* ================================================================
       ERROR SUMMARY
       ================================================================ */

    .student-create-errors {
        margin-bottom: 22px;
        padding: 18px 20px;

        border: 1px solid #E8BEB8;
        border-radius: 14px;

        background: var(--sc-red-soft);
        color: var(--sc-red);
    }

    .student-create-errors strong {
        display: block;
        margin-bottom: 6px;

        font-size: 16px;
        font-weight: 900;
    }

    .student-create-errors ul {
        margin: 0;
        padding-left: 21px;
    }

    .student-create-errors li {
        margin: 3px 0;

        font-size: 14px;
        font-weight: 650;
    }

    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1100px) {
        .student-create-layout {
            grid-template-columns: 1fr;
        }

        .student-create-sidebar {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 900px) {
        .student-create-intro {
            grid-template-columns: 1fr;
        }

        .student-create-hero-inner {
            flex-direction: column;
            align-items: flex-start;
        }

        .student-create-hero-actions {
            width: 100%;
        }
    }

    @media (max-width: 750px) {
        .student-create-grid {
            grid-template-columns: 1fr;
        }

        .student-create-field-full {
            grid-column: auto;
        }

        .student-password-rule-list {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 650px) {
        .student-create-hero {
            padding: 29px 22px;
            border-radius: 22px;
        }

        .student-create-hero h1 {
            font-size: 31px;
        }

        .student-create-hero-description {
            font-size: 16px;
        }

        .student-create-sidebar {
            grid-template-columns: 1fr;
        }

        .student-create-actions {
            display: grid;
            grid-template-columns: 1fr;
        }

        .student-create-button {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

<div class="student-create-page">

    {{-- ================================================================
         HERO
         ================================================================ --}}

    <section class="student-create-hero">

        <div class="student-create-hero-inner">

            <div class="student-create-hero-copy">

                <div class="student-create-eyebrow">
                    <span class="student-create-dot"></span>
                    Administrator · Student Account Creation
                </div>

                <h1>Create Student Account</h1>

                <p class="student-create-hero-description">
                    Register a new Student account for OJT Sync.
                    Create secure portal credentials, define the
                    initial account status, and prepare the Student
                    for profile completion and OJT placement.
                </p>

            </div>

            <div class="student-create-hero-actions">

                <a
                    href="{{ route('admin.students.index') }}"
                    class="
                        student-create-hero-button
                        student-create-hero-button-primary
                    "
                >
                    Back to Students
                </a>

                <a
                    href="{{ route('admin.students.archived') }}"
                    class="
                        student-create-hero-button
                        student-create-hero-button-secondary
                    "
                >
                    Archived Students
                </a>

            </div>

        </div>

    </section>

    {{-- ================================================================
         INTRO CARDS
         ================================================================ --}}

    <section class="student-create-intro">

        <article class="student-create-intro-card">

            <div class="student-create-intro-icon intro-blue">
                01
            </div>

            <div>

                <span class="student-create-intro-title">
                    Account Details
                </span>

                <span class="student-create-intro-description">
                    Enter the Student's official
                    name and unique email address.
                </span>

            </div>

        </article>

        <article class="student-create-intro-card">

            <div class="student-create-intro-icon intro-purple">
                02
            </div>

            <div>

                <span class="student-create-intro-title">
                    Secure Credentials
                </span>

                <span class="student-create-intro-description">
                    Assign a strong password
                    that meets system requirements.
                </span>

            </div>

        </article>

        <article class="student-create-intro-card">

            <div class="student-create-intro-icon intro-green">
                03
            </div>

            <div>

                <span class="student-create-intro-title">
                    Portal Access
                </span>

                <span class="student-create-intro-description">
                    Choose whether the new
                    account begins Active or Inactive.
                </span>

            </div>

        </article>

    </section>

    {{-- ================================================================
         VALIDATION SUMMARY
         ================================================================ --}}

    @if ($errors->any())

        <div class="student-create-errors">

            <strong>
                Please review the following information:
            </strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    {{-- ================================================================
         CREATE STUDENT FORM
         ================================================================ --}}

    <form
        id="student-create-form"
        method="POST"
        action="{{ route('admin.students.store') }}"
    >

        @csrf

        <div class="student-create-layout">

            {{-- ========================================================
                 MAIN FORM
                 ======================================================== --}}

            <main class="student-create-main">

                {{-- ====================================================
                     ACCOUNT INFORMATION
                     ==================================================== --}}

                <section class="student-create-panel">

                    <div class="student-create-panel-header">

                        <div class="student-create-panel-icon panel-blue">
                            AC
                        </div>

                        <div>
                            <h2>Student Account Information</h2>
                            <p>
                                Basic information used
                                throughout OJT Sync.
                            </p>
                        </div>

                    </div>

                    <div class="student-create-panel-body">

                        <div class="student-create-grid">

                            {{-- ========================================
                                 FULL NAME
                                 ======================================== --}}

                            <div class="student-create-field">

                                <label
                                    for="name"
                                    class="student-create-label"
                                >

                                    <span>Full Name</span>

                                    <span class="student-create-required">
                                        Required
                                    </span>

                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="
                                        student-create-input
                                        @error('name')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="Example: Aubrey O. Siega"
                                    required
                                    maxlength="255"
                                    autocomplete="name"
                                    autofocus
                                >

                                <span class="student-create-help">
                                    Enter the Student's complete
                                    name as it should appear in
                                    reports and OJT records.
                                </span>

                                @error('name')
                                    <span class="student-create-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            {{-- ========================================
                                 EMAIL ADDRESS
                                 ======================================== --}}

                            <div class="student-create-field">

                                <label
                                    for="email"
                                    class="student-create-label"
                                >

                                    <span>Email Address</span>

                                    <span class="student-create-required">
                                        Required
                                    </span>

                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="
                                        student-create-input
                                        @error('email')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="student@example.com"
                                    required
                                    maxlength="255"
                                    autocomplete="email"
                                >

                                <span class="student-create-help">
                                    This will become the
                                    Student's OJT Portal
                                    login email.
                                </span>

                                @error('email')
                                    <span class="student-create-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            {{-- ========================================
                                 INITIAL ACCOUNT STATUS
                                 ======================================== --}}

                            <div
                                class="
                                    student-create-field
                                    student-create-field-full
                                "
                            >

                                <label
                                    for="status"
                                    class="student-create-label"
                                >

                                    <span>Initial Account Status</span>

                                    <span class="student-create-required">
                                        Required
                                    </span>

                                </label>

                                <select
                                    id="status"
                                    name="status"
                                    class="
                                        student-create-select
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
                                                \App\Models\User::STATUS_ACTIVE
                                            ) === \App\Models\User::STATUS_ACTIVE
                                        )
                                    >
                                        Active — Student can log in immediately
                                    </option>

                                    <option
                                        value="{{ \App\Models\User::STATUS_INACTIVE }}"
                                        @selected(
                                            old('status') ===
                                            \App\Models\User::STATUS_INACTIVE
                                        )
                                    >
                                        Inactive — Student login remains disabled
                                    </option>

                                </select>

                                @error('status')
                                    <span class="student-create-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                                <div class="student-status-guidance">

                                    <strong>
                                        Which status should I choose?
                                    </strong>

                                    <p>
                                        Choose <strong>Active</strong>
                                        when the Student should be able
                                        to access the OJT Portal after
                                        receiving their credentials.

                                        Choose <strong>Inactive</strong>
                                        when you want to prepare the
                                        account first and enable login
                                        later.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>

                {{-- ====================================================
                     STUDENT LOGIN PASSWORD
                     ==================================================== --}}

                <section class="student-create-panel">

                    <div class="student-create-panel-header">

                        <div class="student-create-panel-icon panel-purple">
                            PW
                        </div>

                        <div>
                            <h2>Student Login Password</h2>
                            <p>
                                Create secure credentials
                                for Student portal access.
                            </p>
                        </div>

                    </div>

                    <div class="student-create-panel-body">

                        <div class="student-create-grid">

                            {{-- ========================================
                                 PASSWORD
                                 ======================================== --}}

                            <div class="student-create-field">

                                <label
                                    for="password"
                                    class="student-create-label"
                                >

                                    <span>Password</span>

                                    <span class="student-create-required">
                                        Required
                                    </span>

                                </label>

                                <div class="student-password-wrapper">

                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="
                                            student-create-input
                                            @error('password')
                                                is-invalid
                                            @enderror
                                        "
                                        placeholder="Create a secure password"
                                        required
                                        autocomplete="new-password"
                                    >

                                    <button
                                        type="button"
                                        class="student-password-toggle"
                                        data-password-toggle="password"
                                        aria-label="Show password"
                                    >
                                        Show
                                    </button>

                                </div>

                                <span class="student-create-help">
                                    Do not use an easy-to-guess
                                    or reused password.
                                </span>

                                @error('password')
                                    <span class="student-create-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            {{-- ========================================
                                 CONFIRM PASSWORD
                                 ======================================== --}}

                            <div class="student-create-field">

                                <label
                                    for="password_confirmation"
                                    class="student-create-label"
                                >

                                    <span>Confirm Password</span>

                                    <span class="student-create-required">
                                        Required
                                    </span>

                                </label>

                                <div class="student-password-wrapper">

                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="student-create-input"
                                        placeholder="Re-enter the password"
                                        required
                                        autocomplete="new-password"
                                    >

                                    <button
                                        type="button"
                                        class="student-password-toggle"
                                        data-password-toggle="password_confirmation"
                                        aria-label="Show password confirmation"
                                    >
                                        Show
                                    </button>

                                </div>

                                <span class="student-create-help">
                                    Enter exactly the same
                                    password again.
                                </span>

                            </div>

                        </div>

                        {{-- ============================================
                             PASSWORD REQUIREMENTS
                             ============================================ --}}

                        <div class="student-password-rules">

                            <span class="student-password-rules-title">
                                Password Requirements
                            </span>

                            <div class="student-password-rule-list">

                                <div class="student-password-rule">
                                    <span class="student-password-rule-dot"></span>
                                    At least 8 characters
                                </div>

                                <div class="student-password-rule">
                                    <span class="student-password-rule-dot"></span>
                                    Uppercase letter
                                </div>

                                <div class="student-password-rule">
                                    <span class="student-password-rule-dot"></span>
                                    Lowercase letter
                                </div>

                                <div class="student-password-rule">
                                    <span class="student-password-rule-dot"></span>
                                    At least one number
                                </div>

                                <div class="student-password-rule">
                                    <span class="student-password-rule-dot"></span>
                                    At least one symbol
                                </div>

                                <div class="student-password-rule">
                                    <span class="student-password-rule-dot"></span>
                                    Password confirmation must match
                                </div>

                            </div>

                        </div>

                        {{-- ============================================
                             FORM ACTIONS
                             ============================================ --}}

                        <div class="student-create-actions">

                            <a
                                href="{{ route('admin.students.index') }}"
                                class="
                                    student-create-button
                                    student-create-button-secondary
                                "
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                id="student-create-submit"
                                class="
                                    student-create-button
                                    student-create-button-primary
                                "
                            >
                                Create Student Account
                            </button>

                        </div>

                    </div>

                </section>

            </main>

            {{-- ========================================================
                 SIDEBAR
                 ======================================================== --}}

            <aside class="student-create-sidebar">

                {{-- ====================================================
                     ACCOUNT SUMMARY
                     ==================================================== --}}

                <section class="student-create-panel">

                    <div class="student-create-panel-header">

                        <div class="student-create-panel-icon panel-teal">
                            ST
                        </div>

                        <div>
                            <h2>New Account</h2>
                            <p>Account creation summary</p>
                        </div>

                    </div>

                    <div class="student-create-panel-body">

                        <div class="student-create-sidebar-list">

                            <div class="student-create-sidebar-item">

                                <span class="student-create-sidebar-label">
                                    Account Type
                                </span>

                                <span class="student-create-sidebar-value">
                                    Student
                                </span>

                            </div>

                            <div class="student-create-sidebar-item">

                                <span class="student-create-sidebar-label">
                                    Portal
                                </span>

                                <span class="student-create-sidebar-value">
                                    OJT Student Portal
                                </span>

                            </div>

                            <div class="student-create-sidebar-item">

                                <span class="student-create-sidebar-label">
                                    Login Method
                                </span>

                                <span class="student-create-sidebar-value">
                                    Email + Password
                                </span>

                            </div>

                            <div class="student-create-sidebar-item">

                                <span class="student-create-sidebar-label">
                                    Account Role
                                </span>

                                <span class="student-create-sidebar-value">
                                    Automatically assigned as Student
                                </span>

                            </div>

                        </div>

                    </div>

                </section>

                {{-- ====================================================
                     SECURITY
                     ==================================================== --}}

                <section class="student-create-panel">

                    <div class="student-create-panel-body">

                        <div class="student-create-security">

                            <span class="student-create-security-title">
                                Server-Protected Role
                            </span>

                            <p>
                                The browser does not choose the
                                Student role. OJT Sync assigns
                                the Student role on the server,
                                preventing account creation from
                                being used to assign Administrator
                                or Supervisor privileges.
                            </p>

                        </div>

                    </div>

                </section>

                {{-- ====================================================
                     NEXT STEP
                     ==================================================== --}}

                <section class="student-create-panel">

                    <div class="student-create-panel-body">

                        <div class="student-create-next-step">

                            <span class="student-create-next-step-title">
                                After Account Creation
                            </span>

                            <p>
                                The Student account will be created
                                first. Student profile information
                                such as Student Number, program,
                                year level, section, contact
                                information, and later OJT placement
                                records remain separate from these
                                login credentials.
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

            /* ========================================================
               PASSWORD VISIBILITY
               ======================================================== */

            const passwordButtons =
                document.querySelectorAll(
                    '[data-password-toggle]'
                );

            passwordButtons.forEach(function (button) {

                button.addEventListener('click', function () {

                    const inputId =
                        button.getAttribute(
                            'data-password-toggle'
                        );

                    const input =
                        document.getElementById(inputId);

                    if (!input) {
                        return;
                    }

                    const shouldShow =
                        input.type === 'password';

                    input.type =
                        shouldShow ? 'text' : 'password';

                    button.textContent =
                        shouldShow ? 'Hide' : 'Show';

                    button.setAttribute(
                        'aria-label',
                        shouldShow
                            ? 'Hide password'
                            : 'Show password'
                    );

                });

            });

            /* ========================================================
               PREVENT ACCIDENTAL DOUBLE SUBMISSION
               ======================================================== */

            const form =
                document.getElementById(
                    'student-create-form'
                );

            const submitButton =
                document.getElementById(
                    'student-create-submit'
                );

            if (form && submitButton) {

                form.addEventListener('submit', function () {

                    if (!form.checkValidity()) {
                        return;
                    }

                    submitButton.disabled = true;

                    submitButton.textContent =
                        'Creating Account...';

                });

            }

        }
    );
</script>
@endpush
