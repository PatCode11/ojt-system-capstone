@extends('layouts.app')

@section('title', 'Edit Company | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - EDIT COMPANY
       PROFESSIONAL + READABILITY FIRST
       ================================================================ */

    :root {
        --ce-navy: #183B6B;
        --ce-navy-dark: #102A4A;
        --ce-navy-deep: #0B223D;

        --ce-purple: #6D4FC2;
        --ce-purple-dark: #573CA5;
        --ce-purple-light: #A78BFA;
        --ce-purple-soft: #F2EEFF;

        --ce-blue: #2563EB;
        --ce-blue-soft: #EAF2FF;

        --ce-teal: #0F766E;
        --ce-teal-soft: #E7F7F5;

        --ce-green: #15803D;
        --ce-green-soft: #EAF8EF;

        --ce-orange: #B45309;
        --ce-orange-soft: #FFF5E6;

        --ce-red: #B42318;
        --ce-red-soft: #FFF0EE;

        --ce-text: #102A4A;
        --ce-body: #405872;
        --ce-muted: #64778C;

        --ce-white: #FFFFFF;
        --ce-soft: #F8FBFE;

        --ce-border: #D8E3EE;
        --ce-border-soft: #E7EDF4;

        --ce-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --ce-shadow-medium:
            0 18px 42px
            rgba(15, 42, 74, 0.10);

        --ce-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --ce-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .company-edit-page {
        width: 100%;

        color:
            var(--ce-text);

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

    .company-edit-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 29px;

        padding:
            42px
            44px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 89% 14%,
                rgba(167, 139, 250, 0.24),
                transparent 27%
            ),
            radial-gradient(
                circle at 70% 96%,
                rgba(96, 165, 250, 0.09),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 55%,
                #54438C 100%
            );

        box-shadow:
            var(--ce-shadow-large);
    }


    .company-edit-hero::before {
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


    .company-edit-hero::after {
        content: "";

        position: absolute;

        width: 220px;
        height: 220px;

        right: 285px;
        bottom: -165px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.04);
    }


    .company-edit-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .company-edit-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 21px;
    }


    .company-edit-avatar {
        width: 86px;
        height: 86px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border:
            2px solid
            rgba(255, 255, 255, 0.18);

        border-radius: 24px;

        background:
            rgba(255, 255, 255, 0.11);

        color:
            #FFFFFF;

        font-size: 24px;
        font-weight: 900;

        letter-spacing:
            .4px;
    }


    .company-edit-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 9px;

        padding:
            7px
            12px;

        border:
            1px solid
            rgba(255, 255, 255, 0.15);

        border-radius: 999px;

        background:
            rgba(255, 255, 255, 0.08);

        color:
            rgba(255, 255, 255, 0.92);

        font-size: 14px;
        font-weight: 800;
    }


    .company-edit-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background:
            #C4B5FD;

        box-shadow:
            0 0 0 5px
            rgba(196, 181, 253, 0.12);
    }


    .company-edit-hero h1 {
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


    .company-edit-hero-subtitle {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.80);

        font-size: 16px;

        line-height: 1.6;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .company-edit-hero-actions {
        width: 275px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .company-edit-hero-button {
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

        font-size: 15px;
        font-weight: 850;

        text-align: center;

        text-decoration: none;

        transition:
            var(--ce-transition);
    }


    .company-edit-hero-primary {
        background:
            #FFFFFF;

        color:
            var(--ce-navy);
    }


    .company-edit-hero-primary:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;
    }


    .company-edit-hero-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .company-edit-hero-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    /* ================================================================
       ALERTS
       ================================================================ */

    .company-edit-alert {
        margin-bottom: 22px;

        padding:
            17px
            19px;

        border-radius: 14px;

        font-size: 15px;

        line-height: 1.6;
    }


    .company-edit-alert-success {
        border:
            1px solid
            #CAE2D1;

        background:
            var(--ce-green-soft);

        color:
            var(--ce-green);
    }


    .company-edit-alert-error {
        border:
            1px solid
            #E8BEB8;

        background:
            var(--ce-red-soft);

        color:
            var(--ce-red);
    }


    .company-edit-errors {
        margin-bottom: 22px;

        padding:
            18px
            20px;

        border:
            1px solid
            #E8BEB8;

        border-radius: 14px;

        background:
            var(--ce-red-soft);

        color:
            var(--ce-red);
    }


    .company-edit-errors strong {
        display: block;

        margin-bottom: 6px;

        font-size: 16px;
        font-weight: 900;
    }


    .company-edit-errors ul {
        margin: 0;

        padding-left: 21px;
    }


    .company-edit-errors li {
        margin:
            3px
            0;

        font-size: 14px;
        font-weight: 650;
    }


    /* ================================================================
       LAYOUT
       ================================================================ */

    .company-edit-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            345px;

        gap: 24px;

        align-items: start;
    }


    .company-edit-main,
    .company-edit-sidebar {
        display: grid;

        gap: 22px;
    }


    /* ================================================================
       PANELS
       ================================================================ */

    .company-edit-panel {
        overflow: hidden;

        border:
            1px solid
            var(--ce-border);

        border-radius: 20px;

        background:
            #FFFFFF;

        box-shadow:
            var(--ce-shadow);
    }


    .company-edit-panel-header {
        display: flex;
        align-items: center;

        gap: 14px;

        padding:
            22px
            23px;

        border-bottom:
            1px solid
            var(--ce-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .company-edit-panel-icon {
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


    .panel-purple {
        background:
            var(--ce-purple-soft);

        color:
            var(--ce-purple);
    }


    .panel-blue {
        background:
            var(--ce-blue-soft);

        color:
            var(--ce-blue);
    }


    .panel-teal {
        background:
            var(--ce-teal-soft);

        color:
            var(--ce-teal);
    }


    .panel-orange {
        background:
            var(--ce-orange-soft);

        color:
            var(--ce-orange);
    }


    .company-edit-panel-header h2 {
        margin:
            0
            0
            3px;

        color:
            var(--ce-text);

        font-size: 23px;
        font-weight: 900;

        line-height: 1.3;
    }


    .company-edit-panel-header p {
        margin: 0;

        color:
            var(--ce-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .company-edit-panel-body {
        padding:
            24px;
    }


    /* ================================================================
       FORM
       ================================================================ */

    .company-edit-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            21px
            20px;
    }


    .company-edit-field {
        display: grid;

        gap: 7px;
    }


    .company-edit-field-full {
        grid-column:
            1 / -1;
    }


    .company-edit-label {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        color:
            var(--ce-text);

        font-size: 15px;
        font-weight: 850;
    }


    .company-edit-required {
        color:
            var(--ce-red);

        font-size: 13px;
        font-weight: 800;
    }


    .company-edit-optional {
        color:
            var(--ce-muted);

        font-size: 13px;
        font-weight: 700;
    }


    .company-edit-input,
    .company-edit-select,
    .company-edit-textarea {
        width: 100%;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background:
            #FBFDFF;

        color:
            var(--ce-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;

        transition:
            var(--ce-transition);
    }


    .company-edit-input,
    .company-edit-select {
        min-height: 56px;
    }


    .company-edit-input {
        padding:
            0
            15px;
    }


    .company-edit-select {
        padding:
            0
            14px;

        cursor: pointer;
    }


    .company-edit-textarea {
        min-height: 130px;

        padding:
            14px
            15px;

        resize: vertical;

        line-height: 1.6;
    }


    .company-edit-input::placeholder,
    .company-edit-textarea::placeholder {
        color:
            #8999AA;

        font-weight: 500;
    }


    .company-edit-input:focus,
    .company-edit-select:focus,
    .company-edit-textarea:focus {
        border-color:
            var(--ce-purple);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(109, 79, 194, 0.08);
    }


    .company-edit-input.is-invalid,
    .company-edit-select.is-invalid,
    .company-edit-textarea.is-invalid {
        border-color:
            var(--ce-red);

        background:
            #FFFDFD;
    }


    .company-edit-help {
        color:
            var(--ce-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .company-edit-error {
        color:
            var(--ce-red);

        font-size: 14px;
        font-weight: 750;

        line-height: 1.5;
    }


    /* ================================================================
       SECTION NOTE
       ================================================================ */

    .company-edit-note {
        margin-top: 18px;

        padding:
            16px
            17px;

        border:
            1px solid
            #DDD6F4;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #FCFBFF,
                #F7F4FF
            );
    }


    .company-edit-note strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--ce-purple);

        font-size: 16px;
        font-weight: 900;
    }


    .company-edit-note p {
        margin: 0;

        color:
            var(--ce-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       STATUS GUIDANCE
       ================================================================ */

    .company-status-guidance {
        margin-top: 17px;

        padding:
            17px;

        border:
            1px solid
            #D8E8E5;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #FAFDFC,
                #F3FAF8
            );
    }


    .company-status-guidance strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--ce-teal);

        font-size: 16px;
        font-weight: 900;
    }


    .company-status-guidance p {
        margin: 0;

        color:
            var(--ce-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       ACTIONS
       ================================================================ */

    .company-edit-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 10px;

        margin-top: 25px;

        padding-top: 21px;

        border-top:
            1px solid
            var(--ce-border-soft);
    }


    .company-edit-button {
        min-height: 52px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            20px;

        border:
            1px solid
            var(--ce-border);

        border-radius: 11px;

        font-family: inherit;

        font-size: 15px;
        font-weight: 900;

        text-decoration: none;

        cursor: pointer;

        transition:
            var(--ce-transition);
    }


    .company-edit-button-secondary {
        background:
            #FFFFFF;

        color:
            var(--ce-navy);
    }


    .company-edit-button-secondary:hover {
        background:
            var(--ce-purple-soft);
    }


    .company-edit-button-primary {
        min-width: 205px;

        border-color:
            var(--ce-purple);

        background:
            var(--ce-purple);

        color:
            #FFFFFF;
    }


    .company-edit-button-primary:hover {
        transform:
            translateY(-1px);

        border-color:
            var(--ce-purple-dark);

        background:
            var(--ce-purple-dark);
    }


    .company-edit-button-primary:disabled {
        border-color:
            #8294A7;

        background:
            #8294A7;

        cursor: wait;

        transform: none;
    }


    /* ================================================================
       SIDEBAR
       ================================================================ */

    .company-edit-sidebar-list {
        display: grid;

        gap: 11px;
    }


    .company-edit-sidebar-item {
        padding:
            14px;

        border:
            1px solid
            var(--ce-border-soft);

        border-radius: 11px;

        background:
            var(--ce-soft);
    }


    .company-edit-sidebar-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--ce-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform:
            uppercase;

        letter-spacing:
            .2px;
    }


    .company-edit-sidebar-value {
        display: block;

        color:
            var(--ce-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.5;

        word-break:
            break-word;
    }


    /* ================================================================
       RECORD STATUS
       ================================================================ */

    .company-current-status {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding:
            8px
            11px;

        border-radius: 999px;

        font-size: 14px;
        font-weight: 900;
    }


    .company-current-status::before {
        content: "";

        width: 8px;
        height: 8px;

        border-radius: 50%;
    }


    .current-status-active {
        background:
            var(--ce-green-soft);

        color:
            var(--ce-green);
    }


    .current-status-active::before {
        background:
            #22C55E;
    }


    .current-status-inactive {
        background:
            var(--ce-orange-soft);

        color:
            var(--ce-orange);
    }


    .current-status-inactive::before {
        background:
            #F59E0B;
    }


    .current-status-other {
        background:
            #F1F5F9;

        color:
            #475569;
    }


    .current-status-other::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       WORKFLOW SAFETY
       ================================================================ */

    .company-workflow-safety {
        padding:
            18px;

        border:
            1px solid
            #D8E4F1;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #FBFDFF,
                #F4F8FD
            );
    }


    .company-workflow-safety-title {
        display: block;

        margin-bottom: 6px;

        color:
            var(--ce-blue);

        font-size: 17px;
        font-weight: 900;
    }


    .company-workflow-safety p {
        margin: 0;

        color:
            var(--ce-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       CONTACT PREVIEW
       ================================================================ */

    .company-contact-preview {
        padding:
            17px;

        border:
            1px solid
            #DDD6F4;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #FCFBFF,
                #F8F5FF
            );
    }


    .company-contact-preview-title {
        display: block;

        margin-bottom: 10px;

        color:
            var(--ce-purple);

        font-size: 17px;
        font-weight: 900;
    }


    .company-contact-preview-row {
        display: grid;

        gap: 3px;

        padding:
            10px
            0;

        border-bottom:
            1px solid
            rgba(109, 79, 194, 0.10);
    }


    .company-contact-preview-row:last-child {
        padding-bottom: 0;

        border-bottom: none;
    }


    .company-contact-preview-label {
        color:
            var(--ce-muted);

        font-size: 12px;
        font-weight: 800;

        text-transform:
            uppercase;
    }


    .company-contact-preview-value {
        color:
            var(--ce-text);

        font-size: 15px;
        font-weight: 850;

        line-height: 1.5;

        word-break:
            break-word;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1080px) {

        .company-edit-layout {
            grid-template-columns:
                1fr;
        }


        .company-edit-sidebar {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 850px) {

        .company-edit-hero-inner {
            flex-direction:
                column;

            align-items:
                flex-start;
        }


        .company-edit-hero-actions {
            width:
                100%;
        }


        .company-edit-grid {
            grid-template-columns:
                1fr;
        }


        .company-edit-field-full {
            grid-column:
                auto;
        }

    }


    @media (max-width: 650px) {

        .company-edit-hero {
            padding:
                29px
                22px;

            border-radius:
                22px;
        }


        .company-edit-identity {
            align-items:
                flex-start;
        }


        .company-edit-avatar {
            width: 66px;
            height: 66px;

            border-radius:
                18px;

            font-size:
                20px;
        }


        .company-edit-hero h1 {
            font-size:
                30px;
        }


        .company-edit-sidebar {
            grid-template-columns:
                1fr;
        }


        .company-edit-actions {
            display: grid;

            grid-template-columns:
                1fr;
        }


        .company-edit-button {
            width: 100%;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Company Initials
    |--------------------------------------------------------------------------
    */

    $companyInitials =
        collect(
            preg_split(
                '/\s+/',
                trim(
                    (string)
                    $company->name
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
            ?: 'CO';


    /*
    |--------------------------------------------------------------------------
    | Current Status Styling
    |--------------------------------------------------------------------------
    */

    $currentStatus =
        strtolower(
            trim(
                (string)
                $company->status
            )
        );


    $currentStatusClass =
        match ($currentStatus) {

            'active' =>
                'current-status-active',

            'inactive' =>
                'current-status-inactive',

            default =>
                'current-status-other',

        };


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
                        ->timezone(
                            'Asia/Manila'
                        )
                        ->format(
                            'M d, Y'
                        );

            } catch (\Throwable $exception) {

                return (string) $date;

            }

        };

@endphp


<div class="company-edit-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="company-edit-hero">


        <div class="company-edit-hero-inner">


            <div class="company-edit-identity">


                <div class="company-edit-avatar">
                    {{ $companyInitials }}
                </div>


                <div>


                    <div class="company-edit-eyebrow">

                        <span class="company-edit-dot"></span>

                        Administrator · Partner Company Editor

                    </div>


                    <h1>
                        Edit Company Record
                    </h1>


                    <p class="company-edit-hero-subtitle">

                        {{ $company->name }}

                        ·

                        Company Record #{{ $company->id }}

                    </p>


                </div>


            </div>


            <div class="company-edit-hero-actions">


                <a
                    href="{{ route(
                        'admin.companies.show',
                        $company
                    ) }}"
                    class="
                        company-edit-hero-button
                        company-edit-hero-primary
                    "
                >
                    View Company Record
                </a>


                <a
                    href="{{ route(
                        'admin.companies.index'
                    ) }}"
                    class="
                        company-edit-hero-button
                        company-edit-hero-secondary
                    "
                >
                    Back to Companies
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         MESSAGES
         ================================================================== --}}

    @if (session('success'))

        <div
            class="
                company-edit-alert
                company-edit-alert-success
            "
        >
            {{ session('success') }}
        </div>

    @endif


    @if (session('error'))

        <div
            class="
                company-edit-alert
                company-edit-alert-error
            "
        >
            {{ session('error') }}
        </div>

    @endif


    @if ($errors->any())


        <div class="company-edit-errors">


            <strong>
                Please review the information below.
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
        id="company-edit-form"
        method="POST"
        action="{{ route(
            'admin.companies.update',
            $company
        ) }}"
    >

        @csrf
        @method('PUT')


        <div class="company-edit-layout">


            {{-- ==============================================================
                 MAIN
                 ============================================================== --}}

            <main class="company-edit-main">


                {{-- ==========================================================
                     COMPANY DETAILS
                     ========================================================== --}}

                <section class="company-edit-panel">


                    <div class="company-edit-panel-header">


                        <div
                            class="
                                company-edit-panel-icon
                                panel-purple
                            "
                        >
                            CO
                        </div>


                        <div>

                            <h2>
                                Company Information
                            </h2>

                            <p>
                                Update the official OJT partner
                                establishment details.
                            </p>

                        </div>


                    </div>


                    <div class="company-edit-panel-body">


                        <div class="company-edit-grid">


                            {{-- ==================================================
                                 COMPANY NAME
                                 ================================================== --}}

                            <div
                                class="
                                    company-edit-field
                                    company-edit-field-full
                                "
                            >


                                <label
                                    for="name"
                                    class="company-edit-label"
                                >

                                    <span>
                                        Company Name
                                    </span>

                                    <span class="company-edit-required">
                                        Required
                                    </span>

                                </label>


                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old(
                                        'name',
                                        $company->name
                                    ) }}"
                                    class="
                                        company-edit-input
                                        @error('name')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                    maxlength="255"
                                    autocomplete="organization"
                                >


                                <span class="company-edit-help">

                                    Enter the official name of the
                                    company or training establishment
                                    as it should appear in OJT records.

                                </span>


                                @error('name')

                                    <span class="company-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 ADDRESS
                                 ================================================== --}}

                            <div
                                class="
                                    company-edit-field
                                    company-edit-field-full
                                "
                            >


                                <label
                                    for="address"
                                    class="company-edit-label"
                                >

                                    <span>
                                        Company Address
                                    </span>

                                    <span class="company-edit-optional">
                                        Company location
                                    </span>

                                </label>


                                <textarea
                                    id="address"
                                    name="address"
                                    class="
                                        company-edit-textarea
                                        @error('address')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="Enter the complete company address"
                                    autocomplete="street-address"
                                >{{ old(
                                    'address',
                                    $company->address
                                ) }}</textarea>


                                <span class="company-edit-help">

                                    Use the establishment's complete
                                    business or OJT training location
                                    whenever possible.

                                </span>


                                @error('address')

                                    <span class="company-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 STATUS
                                 ================================================== --}}

                            <div
                                class="
                                    company-edit-field
                                    company-edit-field-full
                                "
                            >


                                <label
                                    for="status"
                                    class="company-edit-label"
                                >

                                    <span>
                                        Company Status
                                    </span>

                                    <span class="company-edit-required">
                                        Required
                                    </span>

                                </label>


                                <select
                                    id="status"
                                    name="status"
                                    class="
                                        company-edit-select
                                        @error('status')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                >


                                    <option
                                        value="active"
                                        @selected(
                                            old(
                                                'status',
                                                $company->status
                                            )
                                            ===
                                            'active'
                                        )
                                    >
                                        Active — Available for normal system use
                                    </option>


                                    <option
                                        value="inactive"
                                        @selected(
                                            old(
                                                'status',
                                                $company->status
                                            )
                                            ===
                                            'inactive'
                                        )
                                    >
                                        Inactive — Retain record for reference
                                    </option>


                                </select>


                                @error('status')

                                    <span class="company-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                                <div class="company-status-guidance">


                                    <strong>
                                        Company Status Guidance
                                    </strong>


                                    <p>

                                        Use <strong>Active</strong>
                                        when the establishment is
                                        currently available for normal
                                        administrative use.

                                        Use <strong>Inactive</strong>
                                        when the company should remain
                                        in OJT Sync for historical
                                        reference but should no longer
                                        be treated as currently available.

                                    </p>


                                </div>


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     CONTACT INFORMATION
                     ========================================================== --}}

                <section class="company-edit-panel">


                    <div class="company-edit-panel-header">


                        <div
                            class="
                                company-edit-panel-icon
                                panel-teal
                            "
                        >
                            CP
                        </div>


                        <div>

                            <h2>
                                Company Contact Information
                            </h2>

                            <p>
                                Maintain the primary representative
                                and communication details.
                            </p>

                        </div>


                    </div>


                    <div class="company-edit-panel-body">


                        <div class="company-edit-grid">


                            {{-- ==================================================
                                 CONTACT PERSON
                                 ================================================== --}}

                            <div class="company-edit-field">


                                <label
                                    for="contact_person"
                                    class="company-edit-label"
                                >

                                    <span>
                                        Contact Person
                                    </span>

                                    <span class="company-edit-optional">
                                        Representative
                                    </span>

                                </label>


                                <input
                                    type="text"
                                    id="contact_person"
                                    name="contact_person"
                                    value="{{ old(
                                        'contact_person',
                                        $company->contact_person
                                    ) }}"
                                    class="
                                        company-edit-input
                                        @error('contact_person')
                                            is-invalid
                                        @enderror
                                    "
                                    maxlength="255"
                                    autocomplete="name"
                                    placeholder="Company representative"
                                >


                                <span class="company-edit-help">

                                    Enter the person primarily
                                    responsible for OJT-related
                                    communication.

                                </span>


                                @error('contact_person')

                                    <span class="company-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 CONTACT NUMBER
                                 ================================================== --}}

                            <div class="company-edit-field">


                                <label
                                    for="contact_number"
                                    class="company-edit-label"
                                >

                                    <span>
                                        Contact Number
                                    </span>

                                    <span class="company-edit-optional">
                                        Phone
                                    </span>

                                </label>


                                <input
                                    type="text"
                                    id="contact_number"
                                    name="contact_number"
                                    value="{{ old(
                                        'contact_number',
                                        $company->contact_number
                                    ) }}"
                                    class="
                                        company-edit-input
                                        @error('contact_number')
                                            is-invalid
                                        @enderror
                                    "
                                    autocomplete="tel"
                                    placeholder="Company contact number"
                                >


                                <span class="company-edit-help">

                                    Enter the official phone or
                                    mobile number used for company
                                    communication.

                                </span>


                                @error('contact_number')

                                    <span class="company-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 EMAIL
                                 ================================================== --}}

                            <div
                                class="
                                    company-edit-field
                                    company-edit-field-full
                                "
                            >


                                <label
                                    for="email"
                                    class="company-edit-label"
                                >

                                    <span>
                                        Company Email Address
                                    </span>

                                    <span class="company-edit-optional">
                                        Email
                                    </span>

                                </label>


                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old(
                                        'email',
                                        $company->email
                                    ) }}"
                                    class="
                                        company-edit-input
                                        @error('email')
                                            is-invalid
                                        @enderror
                                    "
                                    maxlength="255"
                                    autocomplete="email"
                                    placeholder="company@example.com"
                                >


                                <span class="company-edit-help">

                                    Use an official business or
                                    representative email address
                                    whenever available.

                                </span>


                                @error('email')

                                    <span class="company-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                        </div>


                        <div class="company-edit-note">


                            <strong>
                                Keep Contact Details Current
                            </strong>


                            <p>

                                Accurate contact information helps
                                Administrators clearly identify the
                                organization and representative
                                connected to an OJT placement.

                            </p>


                        </div>


                        {{-- ======================================================
                             FORM ACTIONS
                             ====================================================== --}}

                        <div class="company-edit-actions">


                            <a
                                href="{{ route(
                                    'admin.companies.show',
                                    $company
                                ) }}"
                                class="
                                    company-edit-button
                                    company-edit-button-secondary
                                "
                            >
                                Cancel
                            </a>


                            <button
                                type="submit"
                                id="company-edit-submit"
                                class="
                                    company-edit-button
                                    company-edit-button-primary
                                "
                            >
                                Save Company Changes
                            </button>


                        </div>


                    </div>


                </section>


            </main>


            {{-- ==============================================================
                 SIDEBAR
                 ============================================================== --}}

            <aside class="company-edit-sidebar">


                {{-- ==========================================================
                     RECORD SUMMARY
                     ========================================================== --}}

                <section class="company-edit-panel">


                    <div class="company-edit-panel-header">


                        <div
                            class="
                                company-edit-panel-icon
                                panel-blue
                            "
                        >
                            RC
                        </div>


                        <div>

                            <h2>
                                Company Summary
                            </h2>

                            <p>
                                Current record information
                            </p>

                        </div>


                    </div>


                    <div class="company-edit-panel-body">


                        <div class="company-edit-sidebar-list">


                            <div class="company-edit-sidebar-item">


                                <span class="company-edit-sidebar-label">
                                    Company Record
                                </span>


                                <span class="company-edit-sidebar-value">
                                    #{{ $company->id }}
                                </span>


                            </div>


                            <div class="company-edit-sidebar-item">


                                <span class="company-edit-sidebar-label">
                                    Current Status
                                </span>


                                <span
                                    class="
                                        company-current-status
                                        {{ $currentStatusClass }}
                                    "
                                >

                                    {{ filled(
                                        $company->status
                                    )
                                        ? ucfirst(
                                            $company->status
                                        )
                                        : 'Unknown'
                                    }}

                                </span>


                            </div>


                            <div class="company-edit-sidebar-item">


                                <span class="company-edit-sidebar-label">
                                    Company Name
                                </span>


                                <span class="company-edit-sidebar-value">
                                    {{ $company->name }}
                                </span>


                            </div>


                            <div class="company-edit-sidebar-item">


                                <span class="company-edit-sidebar-label">
                                    Created
                                </span>


                                <span class="company-edit-sidebar-value">

                                    {{ $formatDate(
                                        $company->created_at
                                    ) }}

                                </span>


                            </div>


                            <div class="company-edit-sidebar-item">


                                <span class="company-edit-sidebar-label">
                                    Last Updated
                                </span>


                                <span class="company-edit-sidebar-value">

                                    {{ $formatDate(
                                        $company->updated_at
                                    ) }}

                                </span>


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     CONTACT PREVIEW
                     ========================================================== --}}

                <section class="company-edit-panel">


                    <div class="company-edit-panel-header">


                        <div
                            class="
                                company-edit-panel-icon
                                panel-purple
                            "
                        >
                            CT
                        </div>


                        <div>

                            <h2>
                                Current Contact
                            </h2>

                            <p>
                                Existing company details
                            </p>

                        </div>


                    </div>


                    <div class="company-edit-panel-body">


                        <div class="company-contact-preview">


                            <span class="company-contact-preview-title">
                                Contact Record
                            </span>


                            <div class="company-contact-preview-row">

                                <span class="company-contact-preview-label">
                                    Contact Person
                                </span>

                                <span class="company-contact-preview-value">

                                    {{ filled(
                                        $company->contact_person
                                    )
                                        ? $company->contact_person
                                        : 'Not provided'
                                    }}

                                </span>

                            </div>


                            <div class="company-contact-preview-row">

                                <span class="company-contact-preview-label">
                                    Contact Number
                                </span>

                                <span class="company-contact-preview-value">

                                    {{ filled(
                                        $company->contact_number
                                    )
                                        ? $company->contact_number
                                        : 'Not provided'
                                    }}

                                </span>

                            </div>


                            <div class="company-contact-preview-row">

                                <span class="company-contact-preview-label">
                                    Email Address
                                </span>

                                <span class="company-contact-preview-value">

                                    {{ filled(
                                        $company->email
                                    )
                                        ? $company->email
                                        : 'Not provided'
                                    }}

                                </span>

                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     WORKFLOW SAFETY
                     ========================================================== --}}

                <section class="company-edit-panel">


                    <div class="company-edit-panel-body">


                        <div class="company-workflow-safety">


                            <span class="company-workflow-safety-title">
                                OJT Record Safety
                            </span>


                            <p>

                                Editing the Company record updates
                                its administrative information.

                                Company records may also be referenced
                                by OJT Assignments, so use accurate
                                official details and avoid replacing
                                one company's identity with a completely
                                unrelated organization.

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
            | Prevent Accidental Double Submission
            |--------------------------------------------------------------------------
            */

            const form =
                document.getElementById(
                    'company-edit-form'
                );


            const submitButton =
                document.getElementById(
                    'company-edit-submit'
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