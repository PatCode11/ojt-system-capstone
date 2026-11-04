@extends('layouts.app')

@section('title', 'Edit Supervisor Account | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - EDIT SUPERVISOR ACCOUNT
       PROFESSIONAL + READABILITY FIRST
       ================================================================ */

    :root {
        --sve-navy: #183B6B;
        --sve-navy-dark: #102A4A;
        --sve-navy-deep: #0B223D;

        --sve-teal: #0F766E;
        --sve-teal-dark: #0B5F59;
        --sve-teal-light: #2DD4BF;
        --sve-teal-soft: #E7F7F5;

        --sve-blue: #2563EB;
        --sve-blue-soft: #EAF2FF;

        --sve-green: #15803D;
        --sve-green-soft: #EAF8EF;

        --sve-orange: #B45309;
        --sve-orange-soft: #FFF5E6;

        --sve-red: #B42318;
        --sve-red-soft: #FFF0EE;

        --sve-purple: #6D4FC2;
        --sve-purple-soft: #F2EEFF;

        --sve-text: #102A4A;
        --sve-body: #405872;
        --sve-muted: #64778C;

        --sve-white: #FFFFFF;
        --sve-soft: #F8FBFE;

        --sve-border: #D8E3EE;
        --sve-border-soft: #E7EDF4;

        --sve-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --sve-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --sve-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .supervisor-edit-page {
        width: 100%;

        color: var(--sve-text);

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

    .supervisor-edit-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 30px;

        padding:
            41px
            44px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 89% 14%,
                rgba(45, 212, 191, 0.25),
                transparent 27%
            ),
            radial-gradient(
                circle at 72% 95%,
                rgba(96, 165, 250, 0.10),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 52%,
                #17666B 100%
            );

        box-shadow: var(--sve-shadow-large);
    }


    .supervisor-edit-hero::before {
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


    .supervisor-edit-hero::after {
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


    .supervisor-edit-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .supervisor-edit-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 20px;
    }


    .supervisor-edit-avatar {
        width: 84px;
        height: 84px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border:
            2px solid
            rgba(255, 255, 255, 0.18);

        border-radius: 23px;

        background:
            rgba(255, 255, 255, 0.11);

        color: #FFFFFF;

        font-size: 24px;
        font-weight: 900;
    }


    .supervisor-edit-eyebrow {
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
            rgba(255, 255, 255, 0.92);

        font-size: 14px;
        font-weight: 800;
    }


    .supervisor-edit-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background:
            var(--sve-teal-light);

        box-shadow:
            0 0 0 5px
            rgba(45, 212, 191, 0.12);
    }


    .supervisor-edit-hero h1 {
        margin:
            0
            0
            6px;

        color: #FFFFFF;

        font-size: 36px;
        font-weight: 900;

        line-height: 1.2;

        letter-spacing: -0.4px;
    }


    .supervisor-edit-subtitle {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.80);

        font-size: 16px;

        line-height: 1.6;

        word-break: break-word;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .supervisor-edit-hero-actions {
        width: 275px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .supervisor-edit-hero-button {
        min-height: 51px;

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

        text-align: center;

        text-decoration: none;

        transition: var(--sve-transition);
    }


    .hero-button-primary {
        background: #FFFFFF;

        color: var(--sve-navy);
    }


    .hero-button-primary:hover {
        transform:
            translateY(-2px);

        background: #F8FBFF;
    }


    .hero-button-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color: #FFFFFF;
    }


    .hero-button-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    /* ================================================================
       ALERTS
       ================================================================ */

    .supervisor-edit-alert {
        margin-bottom: 22px;

        padding:
            16px
            18px;

        border-radius: 13px;

        font-size: 15px;
        font-weight: 700;

        line-height: 1.6;
    }


    .supervisor-edit-alert-error {
        border:
            1px solid
            #E8BEB8;

        background:
            var(--sve-red-soft);

        color:
            var(--sve-red);
    }


    .supervisor-edit-alert-success {
        border:
            1px solid
            #CAE2D1;

        background:
            var(--sve-green-soft);

        color:
            var(--sve-green);
    }


    /* ================================================================
       MAIN LAYOUT
       ================================================================ */

    .supervisor-edit-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            340px;

        gap: 24px;

        align-items: start;
    }


    .supervisor-edit-main,
    .supervisor-edit-sidebar {
        display: grid;

        gap: 22px;
    }


    /* ================================================================
       PANELS
       ================================================================ */

    .supervisor-edit-panel {
        overflow: hidden;

        border:
            1px solid
            var(--sve-border);

        border-radius: 20px;

        background: #FFFFFF;

        box-shadow: var(--sve-shadow);
    }


    .supervisor-edit-panel-header {
        display: flex;
        align-items: center;

        gap: 14px;

        padding:
            22px
            23px;

        border-bottom:
            1px solid
            var(--sve-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .supervisor-edit-panel-icon {
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
            var(--sve-teal-soft);

        color:
            var(--sve-teal);
    }


    .panel-purple {
        background:
            var(--sve-purple-soft);

        color:
            var(--sve-purple);
    }


    .panel-blue {
        background:
            var(--sve-blue-soft);

        color:
            var(--sve-blue);
    }


    .supervisor-edit-panel-header h2 {
        margin:
            0
            0
            3px;

        color:
            var(--sve-text);

        font-size: 23px;
        font-weight: 900;

        line-height: 1.3;
    }


    .supervisor-edit-panel-header p {
        margin: 0;

        color:
            var(--sve-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .supervisor-edit-panel-body {
        padding: 24px;
    }


    /* ================================================================
       FORM
       ================================================================ */

    .supervisor-edit-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            21px
            20px;
    }


    .supervisor-edit-field {
        display: grid;

        gap: 7px;
    }


    .supervisor-edit-field-full {
        grid-column:
            1 / -1;
    }


    .supervisor-edit-label {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        color:
            var(--sve-text);

        font-size: 15px;
        font-weight: 850;
    }


    .supervisor-edit-required {
        color:
            var(--sve-red);

        font-size: 13px;
        font-weight: 800;
    }


    .supervisor-edit-optional {
        color:
            var(--sve-muted);

        font-size: 13px;
        font-weight: 700;
    }


    .supervisor-edit-input,
    .supervisor-edit-select {
        width: 100%;

        min-height: 56px;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background:
            #FBFDFF;

        color:
            var(--sve-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;

        transition:
            var(--sve-transition);
    }


    .supervisor-edit-input {
        padding:
            0
            15px;
    }


    .supervisor-edit-select {
        padding:
            0
            14px;

        cursor: pointer;
    }


    .supervisor-edit-input:focus,
    .supervisor-edit-select:focus {
        border-color:
            var(--sve-teal);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(15, 118, 110, 0.09);
    }


    .supervisor-edit-input.is-invalid,
    .supervisor-edit-select.is-invalid {
        border-color:
            var(--sve-red);

        background:
            #FFFDFD;
    }


    .supervisor-edit-help {
        color:
            var(--sve-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .supervisor-edit-error {
        color:
            var(--sve-red);

        font-size: 14px;
        font-weight: 750;

        line-height: 1.5;
    }


    /* ================================================================
       STATUS GUIDANCE
       ================================================================ */

    .supervisor-status-guidance {
        margin-top: 17px;

        padding:
            17px;

        border:
            1px solid
            #CDE2DD;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #F8FCFB,
                #F1FAF8
            );
    }


    .supervisor-status-guidance-title {
        display: block;

        margin-bottom: 5px;

        color:
            var(--sve-teal);

        font-size: 16px;
        font-weight: 900;
    }


    .supervisor-status-guidance p {
        margin: 0;

        color:
            var(--sve-body);

        font-size: 14px;

        line-height: 1.65;
    }


    .supervisor-status-guidance strong {
        color:
            var(--sve-text);
    }


    /* ================================================================
       PASSWORD
       ================================================================ */

    .supervisor-password-wrapper {
        position: relative;
    }


    .supervisor-password-wrapper
    .supervisor-edit-input {
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
            var(--sve-border);

        border-radius: 9px;

        background:
            #FFFFFF;

        color:
            var(--sve-navy);

        font-family: inherit;

        font-size: 13px;
        font-weight: 850;

        cursor: pointer;

        transition:
            var(--sve-transition);
    }


    .supervisor-password-toggle:hover {
        background:
            var(--sve-teal-soft);
    }


    /* ================================================================
       PASSWORD INFORMATION
       ================================================================ */

    .supervisor-password-notice {
        margin-bottom: 20px;

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


    .supervisor-password-notice strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--sve-purple);

        font-size: 16px;
        font-weight: 900;
    }


    .supervisor-password-notice p {
        margin: 0;

        color:
            var(--sve-body);

        font-size: 14px;

        line-height: 1.65;
    }


    .supervisor-password-rules {
        margin-top: 18px;

        padding:
            16px;

        border:
            1px solid
            var(--sve-border-soft);

        border-radius: 12px;

        background:
            var(--sve-soft);
    }


    .supervisor-password-rules-title {
        display: block;

        margin-bottom: 9px;

        color:
            var(--sve-text);

        font-size: 15px;
        font-weight: 900;
    }


    .supervisor-password-rules-grid {
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
            var(--sve-body);

        font-size: 14px;
    }


    .supervisor-password-rule-dot {
        width: 7px;
        height: 7px;

        flex-shrink: 0;

        border-radius: 50%;

        background:
            var(--sve-purple);
    }


    /* ================================================================
       ACTIONS
       ================================================================ */

    .supervisor-edit-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 10px;

        margin-top: 25px;

        padding-top: 21px;

        border-top:
            1px solid
            var(--sve-border-soft);
    }


    .supervisor-edit-button {
        min-height: 51px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            19px;

        border:
            1px solid
            var(--sve-border);

        border-radius: 11px;

        font-family: inherit;

        font-size: 15px;
        font-weight: 900;

        text-decoration: none;

        cursor: pointer;

        transition:
            var(--sve-transition);
    }


    .supervisor-edit-button-secondary {
        background:
            #FFFFFF;

        color:
            var(--sve-navy);
    }


    .supervisor-edit-button-secondary:hover {
        background:
            var(--sve-teal-soft);
    }


    .supervisor-edit-button-primary {
        min-width: 200px;

        border-color:
            var(--sve-teal);

        background:
            var(--sve-teal);

        color:
            #FFFFFF;
    }


    .supervisor-edit-button-primary:hover {
        transform:
            translateY(-1px);

        background:
            var(--sve-teal-dark);
    }


    .supervisor-edit-button-primary:disabled {
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

    .supervisor-edit-sidebar-list {
        display: grid;

        gap: 12px;
    }


    .supervisor-edit-sidebar-item {
        padding:
            15px;

        border:
            1px solid
            var(--sve-border-soft);

        border-radius: 12px;

        background:
            var(--sve-soft);
    }


    .supervisor-edit-sidebar-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--sve-muted);

        font-size: 13px;
        font-weight: 800;

        text-transform: uppercase;

        letter-spacing: .2px;
    }


    .supervisor-edit-sidebar-value {
        display: block;

        color:
            var(--sve-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.5;

        word-break: break-word;
    }


    /* ================================================================
       SECURITY BOX
       ================================================================ */

    .supervisor-edit-security {
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


    .supervisor-edit-security-title {
        display: block;

        margin-bottom: 6px;

        color:
            var(--sve-green);

        font-size: 17px;
        font-weight: 900;
    }


    .supervisor-edit-security p {
        margin: 0;

        color:
            var(--sve-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       ROLE BOX
       ================================================================ */

    .supervisor-role-box {
        display: flex;
        align-items: flex-start;

        gap: 13px;

        padding: 17px;

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


    .supervisor-role-icon {
        width: 44px;
        height: 44px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        background:
            var(--sve-teal-soft);

        color:
            var(--sve-teal);

        font-size: 12px;
        font-weight: 900;
    }


    .supervisor-role-title {
        display: block;

        margin-bottom: 3px;

        color:
            var(--sve-text);

        font-size: 16px;
        font-weight: 900;
    }


    .supervisor-role-description {
        display: block;

        color:
            var(--sve-body);

        font-size: 14px;

        line-height: 1.6;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1050px) {

        .supervisor-edit-layout {
            grid-template-columns: 1fr;
        }


        .supervisor-edit-sidebar {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 800px) {

        .supervisor-edit-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .supervisor-edit-hero-actions {
            width: 100%;
        }


        .supervisor-edit-grid {
            grid-template-columns: 1fr;
        }


        .supervisor-edit-field-full {
            grid-column: auto;
        }


        .supervisor-password-rules-grid {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 650px) {

        .supervisor-edit-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .supervisor-edit-identity {
            align-items: flex-start;
        }


        .supervisor-edit-avatar {
            width: 66px;
            height: 66px;

            border-radius: 18px;

            font-size: 20px;
        }


        .supervisor-edit-hero h1 {
            font-size: 30px;
        }


        .supervisor-edit-sidebar {
            grid-template-columns: 1fr;
        }


        .supervisor-edit-actions {
            display: grid;

            grid-template-columns: 1fr;
        }


        .supervisor-edit-button {
            width: 100%;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Supervisor Initials
    |--------------------------------------------------------------------------
    */

    $initials =
        collect(
            preg_split(
                '/\s+/',
                trim(
                    (string)
                    $supervisor->name
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
            ?: 'SV';


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


<div class="supervisor-edit-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="supervisor-edit-hero">


        <div class="supervisor-edit-hero-inner">


            <div class="supervisor-edit-identity">


                <div class="supervisor-edit-avatar">
                    {{ $initials }}
                </div>


                <div>


                    <div class="supervisor-edit-eyebrow">

                        <span class="supervisor-edit-dot"></span>

                        Administrator · Supervisor Account Editor

                    </div>


                    <h1>
                        Edit Supervisor Account
                    </h1>


                    <p class="supervisor-edit-subtitle">

                        {{ $supervisor->name }}

                        ·

                        {{ $supervisor->email }}

                    </p>


                </div>


            </div>


            <div class="supervisor-edit-hero-actions">


                <a
                    href="{{ route(
                        'admin.supervisors.show',
                        $supervisor
                    ) }}"
                    class="
                        supervisor-edit-hero-button
                        hero-button-primary
                    "
                >
                    View Supervisor Record
                </a>


                <a
                    href="{{ route(
                        'admin.supervisors.index'
                    ) }}"
                    class="
                        supervisor-edit-hero-button
                        hero-button-secondary
                    "
                >
                    Back to Supervisors
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         MESSAGES
         ================================================================== --}}

    @if (session('error'))


        <div
            class="
                supervisor-edit-alert
                supervisor-edit-alert-error
            "
        >
            {{ session('error') }}
        </div>


    @endif


    @if (session('success'))


        <div
            class="
                supervisor-edit-alert
                supervisor-edit-alert-success
            "
        >
            {{ session('success') }}
        </div>


    @endif


    {{-- ==================================================================
         FORM
         ================================================================== --}}

    <form
        id="supervisor-edit-form"
        method="POST"
        action="{{ route(
            'admin.supervisors.update',
            $supervisor
        ) }}"
    >

        @csrf
        @method('PUT')


        <div class="supervisor-edit-layout">


            {{-- ==============================================================
                 MAIN CONTENT
                 ============================================================== --}}

            <main class="supervisor-edit-main">


                {{-- ==========================================================
                     ACCOUNT INFORMATION
                     ========================================================== --}}

                <section class="supervisor-edit-panel">


                    <div class="supervisor-edit-panel-header">


                        <div
                            class="
                                supervisor-edit-panel-icon
                                panel-teal
                            "
                        >
                            AC
                        </div>


                        <div>

                            <h2>
                                Account Information
                            </h2>

                            <p>
                                Update the Supervisor's name,
                                email address, and portal access.
                            </p>

                        </div>


                    </div>


                    <div class="supervisor-edit-panel-body">


                        <div class="supervisor-edit-grid">


                            {{-- ==================================================
                                 NAME
                                 ================================================== --}}

                            <div class="supervisor-edit-field">


                                <label
                                    for="name"
                                    class="supervisor-edit-label"
                                >

                                    <span>
                                        Full Name
                                    </span>

                                    <span class="supervisor-edit-required">
                                        Required
                                    </span>

                                </label>


                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old(
                                        'name',
                                        $supervisor->name
                                    ) }}"
                                    class="
                                        supervisor-edit-input
                                        @error('name')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                    maxlength="255"
                                    autocomplete="name"
                                >


                                <span class="supervisor-edit-help">

                                    Enter the Supervisor's
                                    complete professional name
                                    as it should appear throughout
                                    OJT Sync.

                                </span>


                                @error('name')

                                    <span class="supervisor-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 EMAIL
                                 ================================================== --}}

                            <div class="supervisor-edit-field">


                                <label
                                    for="email"
                                    class="supervisor-edit-label"
                                >

                                    <span>
                                        Email Address
                                    </span>

                                    <span class="supervisor-edit-required">
                                        Required
                                    </span>

                                </label>


                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old(
                                        'email',
                                        $supervisor->email
                                    ) }}"
                                    class="
                                        supervisor-edit-input
                                        @error('email')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                    maxlength="255"
                                    autocomplete="email"
                                >


                                <span class="supervisor-edit-help">

                                    This email is used when
                                    the Supervisor signs in
                                    to the OJT Portal.

                                </span>


                                @error('email')

                                    <span class="supervisor-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 STATUS
                                 ================================================== --}}

                            <div
                                class="
                                    supervisor-edit-field
                                    supervisor-edit-field-full
                                "
                            >


                                <label
                                    for="status"
                                    class="supervisor-edit-label"
                                >

                                    <span>
                                        Account Status
                                    </span>

                                    <span class="supervisor-edit-required">
                                        Required
                                    </span>

                                </label>


                                <select
                                    id="status"
                                    name="status"
                                    class="
                                        supervisor-edit-select
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
                                                $supervisor->status
                                            )
                                            ===
                                            \App\Models\User::STATUS_ACTIVE
                                        )
                                    >
                                        Active — Supervisor can log in
                                    </option>


                                    <option
                                        value="{{ \App\Models\User::STATUS_INACTIVE }}"
                                        @selected(
                                            old(
                                                'status',
                                                $supervisor->status
                                            )
                                            ===
                                            \App\Models\User::STATUS_INACTIVE
                                        )
                                    >
                                        Inactive — Supervisor login disabled
                                    </option>


                                </select>


                                @error('status')

                                    <span class="supervisor-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                                <div class="supervisor-status-guidance">


                                    <span class="supervisor-status-guidance-title">
                                        Supervisor Access Guidance
                                    </span>


                                    <p>

                                        An <strong>Active</strong>
                                        Supervisor can sign in and
                                        access their assigned OJT
                                        monitoring responsibilities.

                                        An <strong>Inactive</strong>
                                        Supervisor cannot sign in,
                                        but historical assignments,
                                        validations, and evaluation
                                        records remain stored.

                                        If this Supervisor still has
                                        a pending or active OJT
                                        Assignment, OJT Sync will
                                        prevent deactivation until
                                        those responsibilities are
                                        reassigned, completed, or
                                        cancelled.

                                    </p>


                                </div>


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     PASSWORD
                     ========================================================== --}}

                <section class="supervisor-edit-panel">


                    <div class="supervisor-edit-panel-header">


                        <div
                            class="
                                supervisor-edit-panel-icon
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
                                Optionally assign a new
                                Supervisor login password.
                            </p>

                        </div>


                    </div>


                    <div class="supervisor-edit-panel-body">


                        <div class="supervisor-password-notice">


                            <strong>
                                Leave these fields blank to keep the current password.
                            </strong>


                            <p>

                                A password change is not required
                                when editing the Supervisor's name,
                                email address, or account status.

                                Only enter a new password when the
                                Supervisor's existing credential
                                should be replaced.

                            </p>


                        </div>


                        <div class="supervisor-edit-grid">


                            {{-- ==================================================
                                 PASSWORD
                                 ================================================== --}}

                            <div class="supervisor-edit-field">


                                <label
                                    for="password"
                                    class="supervisor-edit-label"
                                >

                                    <span>
                                        New Password
                                    </span>

                                    <span class="supervisor-edit-optional">
                                        Optional
                                    </span>

                                </label>


                                <div class="supervisor-password-wrapper">


                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="
                                            supervisor-edit-input
                                            @error('password')
                                                is-invalid
                                            @enderror
                                        "
                                        autocomplete="new-password"
                                    >


                                    <button
                                        type="button"
                                        class="supervisor-password-toggle"
                                        data-password-toggle="password"
                                        aria-label="Show new password"
                                    >
                                        Show
                                    </button>


                                </div>


                                <span class="supervisor-edit-help">

                                    Enter a new password only
                                    when the existing password
                                    needs to be reset.

                                </span>


                                @error('password')

                                    <span class="supervisor-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 CONFIRM PASSWORD
                                 ================================================== --}}

                            <div class="supervisor-edit-field">


                                <label
                                    for="password_confirmation"
                                    class="supervisor-edit-label"
                                >

                                    <span>
                                        Confirm New Password
                                    </span>

                                    <span class="supervisor-edit-optional">
                                        Optional
                                    </span>

                                </label>


                                <div class="supervisor-password-wrapper">


                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="supervisor-edit-input"
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


                                <span class="supervisor-edit-help">

                                    Re-enter the new password
                                    exactly as entered above.

                                </span>


                            </div>


                        </div>


                        {{-- ======================================================
                             PASSWORD RULES
                             ====================================================== --}}

                        <div class="supervisor-password-rules">


                            <span class="supervisor-password-rules-title">
                                New Password Requirements
                            </span>


                            <div class="supervisor-password-rules-grid">


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

                        <div class="supervisor-edit-actions">


                            <a
                                href="{{ route(
                                    'admin.supervisors.show',
                                    $supervisor
                                ) }}"
                                class="
                                    supervisor-edit-button
                                    supervisor-edit-button-secondary
                                "
                            >
                                Cancel
                            </a>


                            <button
                                type="submit"
                                id="supervisor-edit-submit"
                                class="
                                    supervisor-edit-button
                                    supervisor-edit-button-primary
                                "
                            >
                                Save Supervisor Changes
                            </button>


                        </div>


                    </div>


                </section>


            </main>


            {{-- ==============================================================
                 SIDEBAR
                 ============================================================== --}}

            <aside class="supervisor-edit-sidebar">


                {{-- ==========================================================
                     CURRENT RECORD
                     ========================================================== --}}

                <section class="supervisor-edit-panel">


                    <div class="supervisor-edit-panel-header">


                        <div
                            class="
                                supervisor-edit-panel-icon
                                panel-blue
                            "
                        >
                            SV
                        </div>


                        <div>

                            <h2>
                                Supervisor Summary
                            </h2>

                            <p>
                                Current account information
                            </p>

                        </div>


                    </div>


                    <div class="supervisor-edit-panel-body">


                        <div class="supervisor-edit-sidebar-list">


                            <div class="supervisor-edit-sidebar-item">


                                <span class="supervisor-edit-sidebar-label">
                                    Account Role
                                </span>


                                <span class="supervisor-edit-sidebar-value">
                                    Supervisor
                                </span>


                            </div>


                            <div class="supervisor-edit-sidebar-item">


                                <span class="supervisor-edit-sidebar-label">
                                    Current Status
                                </span>


                                <span class="supervisor-edit-sidebar-value">

                                    {{ ucfirst(
                                        $supervisor->status
                                    ) }}

                                </span>


                            </div>


                            <div class="supervisor-edit-sidebar-item">


                                <span class="supervisor-edit-sidebar-label">
                                    Email Address
                                </span>


                                <span class="supervisor-edit-sidebar-value">
                                    {{ $supervisor->email }}
                                </span>


                            </div>


                            <div class="supervisor-edit-sidebar-item">


                                <span class="supervisor-edit-sidebar-label">
                                    Account Created
                                </span>


                                <span class="supervisor-edit-sidebar-value">

                                    {{ $formatDate(
                                        $supervisor->created_at
                                    ) }}

                                </span>


                            </div>


                            <div class="supervisor-edit-sidebar-item">


                                <span class="supervisor-edit-sidebar-label">
                                    Last Updated
                                </span>


                                <span class="supervisor-edit-sidebar-value">

                                    {{ $formatDate(
                                        $supervisor->updated_at
                                    ) }}

                                </span>


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     ROLE PROTECTION
                     ========================================================== --}}

                <section class="supervisor-edit-panel">


                    <div class="supervisor-edit-panel-body">


                        <div class="supervisor-role-box">


                            <div class="supervisor-role-icon">
                                RL
                            </div>


                            <div>


                                <span class="supervisor-role-title">
                                    Role Protected
                                </span>


                                <span class="supervisor-role-description">

                                    This account remains a
                                    Supervisor. The role is not
                                    editable from this page and is
                                    controlled by the server.

                                </span>


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     SECURITY
                     ========================================================== --}}

                <section class="supervisor-edit-panel">


                    <div class="supervisor-edit-panel-body">


                        <div class="supervisor-edit-security">


                            <span class="supervisor-edit-security-title">
                                Account Safety
                            </span>


                            <p>

                                Passwords are never displayed
                                back to the Administrator.

                                When a password reset is submitted,
                                Laravel securely stores the new
                                password rather than keeping the
                                plain-text value.

                                Existing OJT history is unaffected
                                when ordinary account details are
                                updated.

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
            | Prevent Accidental Double Submission
            |--------------------------------------------------------------------------
            */

            const form =
                document.getElementById(
                    'supervisor-edit-form'
                );


            const submitButton =
                document.getElementById(
                    'supervisor-edit-submit'
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
                            'Saving Changes...';

                    }
                );

            }

        }
    );

</script>

@endpush