@extends('layouts.app')

@section('title', 'Create Supervisor Account | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - CREATE SUPERVISOR ACCOUNT
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --svc-navy: #183B6B;
        --svc-navy-dark: #102A4A;
        --svc-navy-deep: #0B223D;

        --svc-teal: #0F766E;
        --svc-teal-dark: #0B5F59;
        --svc-teal-light: #2DD4BF;
        --svc-teal-soft: #E7F7F5;

        --svc-blue: #2563EB;
        --svc-blue-soft: #EAF2FF;

        --svc-green: #15803D;
        --svc-green-soft: #EAF8EF;

        --svc-orange: #B45309;
        --svc-orange-soft: #FFF5E6;

        --svc-red: #B42318;
        --svc-red-soft: #FFF0EE;

        --svc-purple: #6D4FC2;
        --svc-purple-soft: #F2EEFF;

        --svc-text: #102A4A;
        --svc-body: #405872;
        --svc-muted: #64778C;

        --svc-white: #FFFFFF;
        --svc-soft: #F8FBFE;

        --svc-border: #D8E3EE;
        --svc-border-soft: #E7EDF4;

        --svc-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --svc-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --svc-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .supervisor-create-page {
        width: 100%;

        color:
            var(--svc-text);

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

    .supervisor-create-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 30px;

        padding:
            42px
            44px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 88% 14%,
                rgba(45, 212, 191, 0.25),
                transparent 27%
            ),
            radial-gradient(
                circle at 70% 95%,
                rgba(96, 165, 250, 0.10),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 53%,
                #17666B 100%
            );

        box-shadow:
            var(--svc-shadow-large);
    }


    .supervisor-create-hero::before {
        content: "";

        position: absolute;

        width: 390px;
        height: 390px;

        top: -230px;
        right: -150px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.06);
    }


    .supervisor-create-hero::after {
        content: "";

        position: absolute;

        width: 220px;
        height: 220px;

        right: 290px;
        bottom: -160px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.04);
    }


    .supervisor-create-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .supervisor-create-hero-copy {
        max-width: 760px;
    }


    .supervisor-create-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 11px;

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
            rgba(255, 255, 255, 0.92);

        font-size: 14px;
        font-weight: 800;
    }


    .supervisor-create-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background:
            var(--svc-teal-light);

        box-shadow:
            0 0 0 5px
            rgba(45, 212, 191, 0.14);
    }


    .supervisor-create-hero h1 {
        margin:
            0
            0
            10px;

        color:
            #FFFFFF;

        font-size: 38px;
        font-weight: 900;

        line-height: 1.18;

        letter-spacing:
            -0.5px;
    }


    .supervisor-create-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .supervisor-create-hero-actions {
        width: 270px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .supervisor-create-hero-button {
        min-height: 52px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            17px;

        border:
            1px solid
            rgba(255, 255, 255, 0.18);

        border-radius: 12px;

        text-decoration: none;

        font-size: 15px;
        font-weight: 850;

        transition:
            var(--svc-transition);
    }


    .supervisor-create-hero-button-primary {
        background:
            #FFFFFF;

        color:
            var(--svc-navy);
    }


    .supervisor-create-hero-button-primary:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;
    }


    .supervisor-create-hero-button-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .supervisor-create-hero-button-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    /* ================================================================
       INTRO
       ================================================================ */

    .supervisor-create-intro {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 18px;

        margin-bottom: 27px;
    }


    .supervisor-create-intro-card {
        display: flex;
        align-items: flex-start;

        gap: 13px;

        padding:
            19px;

        border:
            1px solid
            var(--svc-border);

        border-radius: 17px;

        background:
            #FFFFFF;

        box-shadow:
            var(--svc-shadow);
    }


    .supervisor-create-intro-icon {
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


    .intro-teal {
        background:
            var(--svc-teal-soft);

        color:
            var(--svc-teal);
    }


    .intro-purple {
        background:
            var(--svc-purple-soft);

        color:
            var(--svc-purple);
    }


    .intro-green {
        background:
            var(--svc-green-soft);

        color:
            var(--svc-green);
    }


    .supervisor-create-intro-title {
        display: block;

        margin-bottom: 3px;

        color:
            var(--svc-text);

        font-size: 16px;
        font-weight: 900;
    }


    .supervisor-create-intro-description {
        display: block;

        color:
            var(--svc-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       MAIN LAYOUT
       ================================================================ */

    .supervisor-create-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            340px;

        gap: 24px;

        align-items: start;
    }


    .supervisor-create-main,
    .supervisor-create-sidebar {
        display: grid;

        gap: 22px;
    }


    /* ================================================================
       PANELS
       ================================================================ */

    .supervisor-create-panel {
        overflow: hidden;

        border:
            1px solid
            var(--svc-border);

        border-radius: 20px;

        background:
            #FFFFFF;

        box-shadow:
            var(--svc-shadow);
    }


    .supervisor-create-panel-header {
        display: flex;
        align-items: center;

        gap: 14px;

        padding:
            22px
            23px;

        border-bottom:
            1px solid
            var(--svc-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .supervisor-create-panel-icon {
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


    .panel-teal {
        background:
            var(--svc-teal-soft);

        color:
            var(--svc-teal);
    }


    .panel-purple {
        background:
            var(--svc-purple-soft);

        color:
            var(--svc-purple);
    }


    .panel-blue {
        background:
            var(--svc-blue-soft);

        color:
            var(--svc-blue);
    }


    .supervisor-create-panel-header h2 {
        margin:
            0
            0
            3px;

        color:
            var(--svc-text);

        font-size: 23px;
        font-weight: 900;

        line-height: 1.3;
    }


    .supervisor-create-panel-header p {
        margin: 0;

        color:
            var(--svc-muted);

        font-size: 14px;
    }


    .supervisor-create-panel-body {
        padding: 24px;
    }


    /* ================================================================
       FORM
       ================================================================ */

    .supervisor-create-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            21px
            20px;

        align-items: start;
    }


    .supervisor-create-field {
        display: flex;
        flex-direction: column;
        align-self: start;
        width: 100%;
        min-width: 0;

        gap: 7px;
    }


    .supervisor-create-field-full {
        grid-column:
            1 / -1;
    }


    .supervisor-create-label {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        color:
            var(--svc-text);

        font-size: 15px;
        font-weight: 850;
    }


    .supervisor-create-required {
        color:
            var(--svc-red);

        font-size: 13px;
        font-weight: 800;
    }


    .supervisor-create-input,
    .supervisor-create-select {
        box-sizing: border-box;
        width: 100%;
        height: 56px;
        min-height: 56px;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background:
            #FBFDFF;

        color:
            var(--svc-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;

        transition:
            var(--svc-transition);
    }


    .supervisor-create-input {
        padding:
            0
            15px;
    }


    .supervisor-create-select {
        padding:
            0
            14px;

        cursor: pointer;
    }


    .supervisor-create-input::placeholder {
        color:
            #8A9CAF;

        font-weight: 500;
    }


    .supervisor-create-input:focus,
    .supervisor-create-select:focus {
        border-color:
            var(--svc-teal);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(15, 118, 110, 0.09);
    }


    .supervisor-create-input.is-invalid,
    .supervisor-create-select.is-invalid {
        border-color:
            var(--svc-red);

        background:
            #FFFDFD;
    }


    .supervisor-create-help {
        color:
            var(--svc-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .supervisor-create-error {
        color:
            var(--svc-red);

        font-size: 14px;
        font-weight: 750;

        line-height: 1.5;
    }


    /* ================================================================
       PASSWORD
       ================================================================ */

    .supervisor-password-wrapper {
        position: relative;
    }


    .supervisor-password-wrapper
    .supervisor-create-input {
        padding-right:
            104px;
    }


    .supervisor-password-toggle {
        position: absolute;

        top: 50%;
        right: 8px;

        transform:
            translateY(-50%);

        min-width: 82px;
        height: 39px;

        border:
            1px solid
            var(--svc-border);

        border-radius: 9px;

        background:
            #FFFFFF;

        color:
            var(--svc-navy);

        font-family: inherit;

        font-size: 13px;
        font-weight: 850;

        cursor: pointer;
    }


    .supervisor-password-toggle:hover {
        background:
            var(--svc-teal-soft);
    }


    /* ================================================================
       PASSWORD REQUIREMENTS
       ================================================================ */

    .supervisor-password-rules {
        margin-top: 18px;

        padding:
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


    .supervisor-password-rules-title {
        display: block;

        margin-bottom: 9px;

        color:
            var(--svc-purple);

        font-size: 16px;
        font-weight: 900;
    }


    .supervisor-password-rule-list {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            8px
            12px;
    }


    .supervisor-password-rule {
        display: flex;
        align-items: center;

        gap: 8px;

        color:
            var(--svc-body);

        font-size: 14px;
    }


    .supervisor-password-rule-dot {
        width: 7px;
        height: 7px;

        flex-shrink: 0;

        border-radius: 50%;

        background:
            var(--svc-purple);
    }


    /* ================================================================
       STATUS
       ================================================================ */

    .supervisor-status-guidance {
        margin-top: 17px;

        padding:
            16px
            17px;

        border:
            1px solid
            #CDE2DD;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #F8FCFB 0%,
                #F1FAF8 100%
            );
    }


    .supervisor-status-guidance strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--svc-text);

        font-size: 16px;
        font-weight: 900;
    }


    .supervisor-status-guidance p {
        margin: 0;

        color:
            var(--svc-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       ACTIONS
       ================================================================ */

    .supervisor-create-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 10px;

        margin-top: 25px;

        padding-top: 21px;

        border-top:
            1px solid
            var(--svc-border-soft);
    }


    .supervisor-create-button {
        min-height: 51px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            19px;

        border:
            1px solid
            var(--svc-border);

        border-radius: 11px;

        font-family: inherit;

        font-size: 15px;
        font-weight: 900;

        text-decoration: none;

        cursor: pointer;

        transition:
            var(--svc-transition);
    }


    .supervisor-create-button-secondary {
        background:
            #FFFFFF;

        color:
            var(--svc-navy);
    }


    .supervisor-create-button-secondary:hover {
        background:
            var(--svc-teal-soft);
    }


    .supervisor-create-button-primary {
        min-width: 210px;

        border-color:
            var(--svc-teal);

        background:
            var(--svc-teal);

        color:
            #FFFFFF;
    }


    .supervisor-create-button-primary:hover {
        transform:
            translateY(-1px);

        background:
            var(--svc-teal-dark);
    }


    .supervisor-create-button-primary:disabled {
        border-color:
            #7E91A4;

        background:
            #7E91A4;

        cursor: wait;

        transform: none;
    }


    /* ================================================================
       SIDEBAR
       ================================================================ */

    .supervisor-create-sidebar-list {
        display: grid;

        gap: 12px;
    }


    .supervisor-create-sidebar-item {
        padding:
            15px;

        border:
            1px solid
            var(--svc-border-soft);

        border-radius: 12px;

        background:
            var(--svc-soft);
    }


    .supervisor-create-sidebar-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--svc-muted);

        font-size: 13px;
        font-weight: 800;

        text-transform: uppercase;
    }


    .supervisor-create-sidebar-value {
        display: block;

        color:
            var(--svc-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.5;
    }


    /* ================================================================
       SECURITY CARD
       ================================================================ */

    .supervisor-create-security {
        padding: 18px;

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


    .supervisor-create-security-title {
        display: block;

        margin-bottom: 6px;

        color:
            var(--svc-green);

        font-size: 17px;
        font-weight: 900;
    }


    .supervisor-create-security p {
        margin: 0;

        color:
            var(--svc-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       RESPONSIBILITY CARD
       ================================================================ */

    .supervisor-create-responsibility {
        padding: 18px;

        border:
            1px solid
            #CDE2DD;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #F8FCFB,
                #F1FAF8
            );
    }


    .supervisor-create-responsibility-title {
        display: block;

        margin-bottom: 6px;

        color:
            var(--svc-teal);

        font-size: 17px;
        font-weight: 900;
    }


    .supervisor-create-responsibility p {
        margin: 0;

        color:
            var(--svc-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       ERRORS
       ================================================================ */

    .supervisor-create-errors {
        margin-bottom: 22px;

        padding:
            18px
            20px;

        border:
            1px solid
            #E8BEB8;

        border-radius: 14px;

        background:
            var(--svc-red-soft);

        color:
            var(--svc-red);
    }


    .supervisor-create-errors strong {
        display: block;

        margin-bottom: 6px;

        font-size: 16px;
        font-weight: 900;
    }


    .supervisor-create-errors ul {
        margin: 0;

        padding-left: 21px;
    }


    .supervisor-create-errors li {
        margin:
            3px
            0;

        font-size: 14px;
        font-weight: 650;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1100px) {

        .supervisor-create-layout {
            grid-template-columns: 1fr;
        }


        .supervisor-create-sidebar {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 900px) {

        .supervisor-create-intro {
            grid-template-columns: 1fr;
        }


        .supervisor-create-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .supervisor-create-hero-actions {
            width: 100%;
        }

    }


    @media (max-width: 750px) {

        .supervisor-create-grid {
            grid-template-columns: 1fr;
        }


        .supervisor-create-field-full {
            grid-column: auto;
        }


        .supervisor-password-rule-list {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 650px) {

        .supervisor-create-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .supervisor-create-hero h1 {
            font-size: 31px;
        }


        .supervisor-create-hero-description {
            font-size: 16px;
        }


        .supervisor-create-sidebar {
            grid-template-columns: 1fr;
        }


        .supervisor-create-actions {
            display: grid;

            grid-template-columns: 1fr;
        }


        .supervisor-create-button {
            width: 100%;
        }

    }

</style>

@endpush


@section('content')


<div class="supervisor-create-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="supervisor-create-hero">


        <div class="supervisor-create-hero-inner">


            <div class="supervisor-create-hero-copy">


                <div class="supervisor-create-eyebrow">

                    <span class="supervisor-create-dot"></span>

                    Administrator · Supervisor Account Creation

                </div>


                <h1>
                    Create Supervisor Account
                </h1>


                <p class="supervisor-create-hero-description">

                    Register a new Supervisor for OJT Sync.
                    Create secure portal credentials, configure
                    initial account access, and prepare the
                    Supervisor for Student monitoring,
                    attendance validation, Work Log review,
                    and final evaluation responsibilities.

                </p>


            </div>


            <div class="supervisor-create-hero-actions">


                <a
                    href="{{ route(
                        'admin.supervisors.index'
                    ) }}"
                    class="
                        supervisor-create-hero-button
                        supervisor-create-hero-button-primary
                    "
                >
                    Back to Supervisors
                </a>


                <a
                    href="{{ route(
                        'admin.supervisors.archived'
                    ) }}"
                    class="
                        supervisor-create-hero-button
                        supervisor-create-hero-button-secondary
                    "
                >
                    Archived Supervisors
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         INTRO
         ================================================================== --}}

    <section class="supervisor-create-intro">


        <article class="supervisor-create-intro-card">


            <div
                class="
                    supervisor-create-intro-icon
                    intro-teal
                "
            >
                01
            </div>


            <div>

                <span class="supervisor-create-intro-title">
                    Supervisor Identity
                </span>

                <span class="supervisor-create-intro-description">

                    Enter the Supervisor's
                    official name and email address.

                </span>

            </div>


        </article>


        <article class="supervisor-create-intro-card">


            <div
                class="
                    supervisor-create-intro-icon
                    intro-purple
                "
            >
                02
            </div>


            <div>

                <span class="supervisor-create-intro-title">
                    Secure Credentials
                </span>

                <span class="supervisor-create-intro-description">

                    Create a strong password
                    for protected portal access.

                </span>

            </div>


        </article>


        <article class="supervisor-create-intro-card">


            <div
                class="
                    supervisor-create-intro-icon
                    intro-green
                "
            >
                03
            </div>


            <div>

                <span class="supervisor-create-intro-title">
                    Account Access
                </span>

                <span class="supervisor-create-intro-description">

                    Decide whether the new
                    Supervisor begins Active or Inactive.

                </span>

            </div>


        </article>


    </section>


    {{-- ==================================================================
         VALIDATION ERRORS
         ================================================================== --}}

    @if ($errors->any())


        <div class="supervisor-create-errors">


            <strong>
                Please review the following information:
            </strong>


            <ul>

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>


        </div>


    @endif


    {{-- ==================================================================
         FORM
         ================================================================== --}}

    <form
        id="supervisor-create-form"
        method="POST"
        action="{{ route(
            'admin.supervisors.store'
        ) }}"
    >

        @csrf


        <div class="supervisor-create-layout">


            {{-- ==============================================================
                 MAIN
                 ============================================================== --}}

            <main class="supervisor-create-main">


                {{-- ==========================================================
                     ACCOUNT INFORMATION
                     ========================================================== --}}

                <section class="supervisor-create-panel">


                    <div class="supervisor-create-panel-header">


                        <div
                            class="
                                supervisor-create-panel-icon
                                panel-teal
                            "
                        >
                            SV
                        </div>


                        <div>

                            <h2>
                                Supervisor Account Information
                            </h2>

                            <p>
                                Basic account and portal access information.
                            </p>

                        </div>


                    </div>


                    <div class="supervisor-create-panel-body">


                        <div class="supervisor-create-grid">


                            {{-- ==================================================
                                 FULL NAME
                                 ================================================== --}}

                            <div class="supervisor-create-field">


                                <label
                                    for="name"
                                    class="supervisor-create-label"
                                >

                                    <span>
                                        Full Name
                                    </span>

                                    <span class="supervisor-create-required">
                                        Required
                                    </span>

                                </label>


                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="
                                        supervisor-create-input
                                        @error('name')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="Example: Juan Dela Cruz"
                                    required
                                    maxlength="255"
                                    autocomplete="name"
                                    autofocus
                                >


                                <span class="supervisor-create-help">

                                    Enter the Supervisor's complete
                                    professional name as it should
                                    appear in OJT records.

                                </span>


                                @error('name')

                                    <span class="supervisor-create-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 EMAIL
                                 ================================================== --}}

                            <div class="supervisor-create-field">


                                <label
                                    for="email"
                                    class="supervisor-create-label"
                                >

                                    <span>
                                        Email Address
                                    </span>

                                    <span class="supervisor-create-required">
                                        Required
                                    </span>

                                </label>


                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="
                                        supervisor-create-input
                                        @error('email')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="supervisor@example.com"
                                    required
                                    maxlength="255"
                                    autocomplete="email"
                                >


                                <span class="supervisor-create-help">

                                    This email becomes the
                                    Supervisor's OJT Portal
                                    sign-in credential.

                                </span>


                                @error('email')

                                    <span class="supervisor-create-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 STATUS
                                 ================================================== --}}

                            <div
                                class="
                                    supervisor-create-field
                                    supervisor-create-field-full
                                "
                            >


                                <label
                                    for="status"
                                    class="supervisor-create-label"
                                >

                                    <span>
                                        Initial Account Status
                                    </span>

                                    <span class="supervisor-create-required">
                                        Required
                                    </span>

                                </label>


                                <select
                                    id="status"
                                    name="status"
                                    class="
                                        supervisor-create-select
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
                                            )
                                            ===
                                            \App\Models\User::STATUS_ACTIVE
                                        )
                                    >
                                        Active — Supervisor can log in immediately
                                    </option>


                                    <option
                                        value="{{ \App\Models\User::STATUS_INACTIVE }}"
                                        @selected(
                                            old('status')
                                            ===
                                            \App\Models\User::STATUS_INACTIVE
                                        )
                                    >
                                        Inactive — Supervisor login remains disabled
                                    </option>


                                </select>


                                @error('status')

                                    <span class="supervisor-create-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                                <div class="supervisor-status-guidance">


                                    <strong>
                                        Account Access Guidance
                                    </strong>


                                    <p>

                                        Choose <strong>Active</strong>
                                        if this Supervisor should be
                                        able to access the OJT Portal
                                        immediately.

                                        Choose <strong>Inactive</strong>
                                        if you want to prepare the
                                        account now and enable access
                                        at a later time.

                                    </p>


                                </div>


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     PASSWORD
                     ========================================================== --}}

                <section class="supervisor-create-panel">


                    <div class="supervisor-create-panel-header">


                        <div
                            class="
                                supervisor-create-panel-icon
                                panel-purple
                            "
                        >
                            PW
                        </div>


                        <div>

                            <h2>
                                Supervisor Login Password
                            </h2>

                            <p>
                                Create secure credentials for protected portal access.
                            </p>

                        </div>


                    </div>


                    <div class="supervisor-create-panel-body">


                        <div class="supervisor-create-grid">


                            {{-- PASSWORD --}}

                            <div class="supervisor-create-field">


                                <label
                                    for="password"
                                    class="supervisor-create-label"
                                >

                                    <span>
                                        Password
                                    </span>

                                    <span class="supervisor-create-required">
                                        Required
                                    </span>

                                </label>


                                <div class="supervisor-password-wrapper">


                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="
                                            supervisor-create-input
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
                                        class="supervisor-password-toggle"
                                        data-password-toggle="password"
                                        aria-label="Show password"
                                    >
                                        Show
                                    </button>


                                </div>


                                <span class="supervisor-create-help">

                                    Use a unique password that
                                    is not shared with another account.

                                </span>


                                @error('password')

                                    <span class="supervisor-create-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- CONFIRM PASSWORD --}}

                            <div class="supervisor-create-field">


                                <label
                                    for="password_confirmation"
                                    class="supervisor-create-label"
                                >

                                    <span>
                                        Confirm Password
                                    </span>

                                    <span class="supervisor-create-required">
                                        Required
                                    </span>

                                </label>


                                <div class="supervisor-password-wrapper">


                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="supervisor-create-input"
                                        placeholder="Re-enter the password"
                                        required
                                        autocomplete="new-password"
                                    >


                                    <button
                                        type="button"
                                        class="supervisor-password-toggle"
                                        data-password-toggle="password_confirmation"
                                        aria-label="Show password confirmation"
                                    >
                                        Show
                                    </button>


                                </div>


                                <span class="supervisor-create-help">

                                    Enter exactly the same
                                    password again.

                                </span>


                            </div>


                        </div>


                        {{-- ======================================================
                             PASSWORD RULES
                             ====================================================== --}}

                        <div class="supervisor-password-rules">


                            <span class="supervisor-password-rules-title">
                                Password Requirements
                            </span>


                            <div class="supervisor-password-rule-list">


                                <div class="supervisor-password-rule">

                                    <span class="supervisor-password-rule-dot"></span>

                                    At least 8 characters

                                </div>


                                <div class="supervisor-password-rule">

                                    <span class="supervisor-password-rule-dot"></span>

                                    Uppercase letter

                                </div>


                                <div class="supervisor-password-rule">

                                    <span class="supervisor-password-rule-dot"></span>

                                    Lowercase letter

                                </div>


                                <div class="supervisor-password-rule">

                                    <span class="supervisor-password-rule-dot"></span>

                                    At least one number

                                </div>


                                <div class="supervisor-password-rule">

                                    <span class="supervisor-password-rule-dot"></span>

                                    At least one symbol

                                </div>


                                <div class="supervisor-password-rule">

                                    <span class="supervisor-password-rule-dot"></span>

                                    Confirmation must match

                                </div>


                            </div>


                        </div>


                        {{-- ======================================================
                             ACTIONS
                             ====================================================== --}}

                        <div class="supervisor-create-actions">


                            <a
                                href="{{ route(
                                    'admin.supervisors.index'
                                ) }}"
                                class="
                                    supervisor-create-button
                                    supervisor-create-button-secondary
                                "
                            >
                                Cancel
                            </a>


                            <button
                                type="submit"
                                id="supervisor-create-submit"
                                class="
                                    supervisor-create-button
                                    supervisor-create-button-primary
                                "
                            >
                                Create Supervisor Account
                            </button>


                        </div>


                    </div>


                </section>


            </main>


            {{-- ==============================================================
                 SIDEBAR
                 ============================================================== --}}

            <aside class="supervisor-create-sidebar">


                {{-- ==========================================================
                     ACCOUNT SUMMARY
                     ========================================================== --}}

                <section class="supervisor-create-panel">


                    <div class="supervisor-create-panel-header">


                        <div
                            class="
                                supervisor-create-panel-icon
                                panel-blue
                            "
                        >
                            AC
                        </div>


                        <div>

                            <h2>
                                New Account
                            </h2>

                            <p>
                                Supervisor account summary
                            </p>

                        </div>


                    </div>


                    <div class="supervisor-create-panel-body">


                        <div class="supervisor-create-sidebar-list">


                            <div class="supervisor-create-sidebar-item">

                                <span class="supervisor-create-sidebar-label">
                                    Account Type
                                </span>

                                <span class="supervisor-create-sidebar-value">
                                    Supervisor
                                </span>

                            </div>


                            <div class="supervisor-create-sidebar-item">

                                <span class="supervisor-create-sidebar-label">
                                    Portal Access
                                </span>

                                <span class="supervisor-create-sidebar-value">
                                    OJT Supervisor Portal
                                </span>

                            </div>


                            <div class="supervisor-create-sidebar-item">

                                <span class="supervisor-create-sidebar-label">
                                    Login Method
                                </span>

                                <span class="supervisor-create-sidebar-value">
                                    Email + Password
                                </span>

                            </div>


                            <div class="supervisor-create-sidebar-item">

                                <span class="supervisor-create-sidebar-label">
                                    Account Role
                                </span>

                                <span class="supervisor-create-sidebar-value">
                                    Assigned automatically as Supervisor
                                </span>

                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     RESPONSIBILITIES
                     ========================================================== --}}

                <section class="supervisor-create-panel">


                    <div class="supervisor-create-panel-body">


                        <div class="supervisor-create-responsibility">


                            <span class="supervisor-create-responsibility-title">
                                Supervisor Responsibilities
                            </span>


                            <p>

                                Supervisor accounts are intended
                                for OJT personnel responsible for
                                Student monitoring, attendance
                                validation, Daily Work Log review,
                                and final OJT evaluation.

                                Student assignments are managed
                                separately by the Administrator.

                            </p>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     SECURITY
                     ========================================================== --}}

                <section class="supervisor-create-panel">


                    <div class="supervisor-create-panel-body">


                        <div class="supervisor-create-security">


                            <span class="supervisor-create-security-title">
                                Server-Protected Role
                            </span>


                            <p>

                                The Supervisor role is not accepted
                                from a browser field. OJT Sync
                                assigns the Supervisor role on the
                                server, helping prevent unauthorized
                                role manipulation during account
                                creation.

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

            const passwordButtons =
                document.querySelectorAll(
                    '[data-password-toggle]'
                );


            passwordButtons.forEach(
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


                            const shouldShow =
                                input.type
                                ===
                                'password';


                            input.type =
                                shouldShow
                                    ? 'text'
                                    : 'password';


                            button.textContent =
                                shouldShow
                                    ? 'Hide'
                                    : 'Show';


                            button.setAttribute(
                                'aria-label',
                                shouldShow
                                    ? 'Hide password'
                                    : 'Show password'
                            );

                        }
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Prevent Double Submission
            |--------------------------------------------------------------------------
            */

            const form =
                document.getElementById(
                    'supervisor-create-form'
                );


            const submitButton =
                document.getElementById(
                    'supervisor-create-submit'
                );


            if (
                form
                &&
                submitButton
            ) {

                form.addEventListener(
                    'submit',
                    function () {

                        if (! form.checkValidity()) {
                            return;
                        }


                        submitButton.disabled =
                            true;


                        submitButton.textContent =
                            'Creating Account...';

                    }
                );

            }

        }
    );

</script>

@endpush