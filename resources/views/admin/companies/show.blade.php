@extends('layouts.app')

@section('title', 'Company Record | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - COMPANY RECORD
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --cshow-navy: #183B6B;
        --cshow-navy-dark: #102A4A;
        --cshow-navy-deep: #0B223D;

        --cshow-purple: #6D4FC2;
        --cshow-purple-dark: #573CA5;
        --cshow-purple-light: #A78BFA;
        --cshow-purple-soft: #F2EEFF;

        --cshow-blue: #2563EB;
        --cshow-blue-soft: #EAF2FF;

        --cshow-teal: #0F766E;
        --cshow-teal-soft: #E7F7F5;

        --cshow-green: #15803D;
        --cshow-green-soft: #EAF8EF;

        --cshow-orange: #B45309;
        --cshow-orange-soft: #FFF5E6;

        --cshow-red: #B42318;
        --cshow-red-soft: #FFF0EE;

        --cshow-text: #102A4A;
        --cshow-body: #405872;
        --cshow-muted: #64778C;

        --cshow-white: #FFFFFF;
        --cshow-soft: #F8FBFE;

        --cshow-border: #D8E3EE;
        --cshow-border-soft: #E7EDF4;

        --cshow-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --cshow-shadow-medium:
            0 18px 42px
            rgba(15, 42, 74, 0.10);

        --cshow-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --cshow-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .company-show-page {
        width: 100%;

        color:
            var(--cshow-text);

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

    .company-show-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 28px;

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
                circle at 71% 97%,
                rgba(96, 165, 250, 0.09),
                transparent 31%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 55%,
                #54438C 100%
            );

        box-shadow:
            var(--cshow-shadow-large);
    }


    .company-show-hero::before {
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


    .company-show-hero::after {
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


    .company-show-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .company-show-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 22px;
    }


    .company-show-avatar {
        width: 92px;
        height: 92px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border:
            2px solid
            rgba(255, 255, 255, 0.18);

        border-radius: 25px;

        background:
            rgba(255, 255, 255, 0.11);

        color:
            #FFFFFF;

        font-size: 26px;
        font-weight: 900;

        letter-spacing:
            0.6px;
    }


    .company-show-eyebrow {
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
            rgba(255, 255, 255, 0.91);

        font-size: 14px;
        font-weight: 800;
    }


    .company-show-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background:
            #C4B5FD;

        box-shadow:
            0 0 0 5px
            rgba(196, 181, 253, 0.12);
    }


    .company-show-hero h1 {
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


    .company-show-hero-address {
        max-width: 720px;

        margin: 0;

        color:
            rgba(255, 255, 255, 0.80);

        font-size: 16px;

        line-height: 1.65;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .company-show-hero-actions {
        width: 275px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .company-show-hero-button {
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
            var(--cshow-transition);
    }


    .company-show-hero-primary {
        background:
            #FFFFFF;

        color:
            var(--cshow-navy);
    }


    .company-show-hero-primary:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;

        box-shadow:
            0 11px 24px
            rgba(0, 0, 0, 0.10);
    }


    .company-show-hero-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .company-show-hero-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    /* ================================================================
       SUMMARY
       ================================================================ */

    .company-show-summary {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 18px;

        margin-bottom: 27px;
    }


    .company-show-summary-card {
        padding:
            21px;

        border:
            1px solid
            var(--cshow-border);

        border-radius: 18px;

        background:
            #FFFFFF;

        box-shadow:
            var(--cshow-shadow);

        transition:
            var(--cshow-transition);
    }


    .company-show-summary-card:hover {
        transform:
            translateY(-2px);

        box-shadow:
            var(--cshow-shadow-medium);
    }


    .company-show-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--cshow-muted);

        font-size: 14px;
        font-weight: 800;
    }


    .company-show-summary-value {
        display: block;

        color:
            var(--cshow-text);

        font-size: 20px;
        font-weight: 900;

        line-height: 1.4;

        word-break:
            break-word;
    }


    .company-show-summary-note {
        display: block;

        margin-top: 5px;

        color:
            var(--cshow-muted);

        font-size: 13px;

        line-height: 1.5;
    }


    /* ================================================================
       STATUS
       ================================================================ */

    .company-show-status {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding:
            8px
            12px;

        border-radius: 999px;

        font-size: 14px;
        font-weight: 900;
    }


    .company-show-status::before {
        content: "";

        width: 8px;
        height: 8px;

        border-radius: 50%;
    }


    .company-show-status-active {
        background:
            var(--cshow-green-soft);

        color:
            var(--cshow-green);
    }


    .company-show-status-active::before {
        background:
            #22C55E;
    }


    .company-show-status-inactive {
        background:
            var(--cshow-orange-soft);

        color:
            var(--cshow-orange);
    }


    .company-show-status-inactive::before {
        background:
            #F59E0B;
    }


    .company-show-status-other {
        background:
            #F1F5F9;

        color:
            #475569;
    }


    .company-show-status-other::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       MAIN LAYOUT
       ================================================================ */

    .company-show-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            350px;

        gap: 24px;

        align-items: start;
    }


    .company-show-main,
    .company-show-sidebar {
        display: grid;

        gap: 22px;
    }


    /* ================================================================
       PANELS
       ================================================================ */

    .company-show-panel {
        overflow: hidden;

        border:
            1px solid
            var(--cshow-border);

        border-radius: 19px;

        background:
            #FFFFFF;

        box-shadow:
            var(--cshow-shadow);
    }


    .company-show-panel-header {
        display: flex;
        align-items: center;

        gap: 13px;

        padding:
            21px
            22px;

        border-bottom:
            1px solid
            var(--cshow-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .company-show-panel-icon {
        width: 47px;
        height: 47px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        font-size: 12px;
        font-weight: 900;
    }


    .panel-purple {
        background:
            var(--cshow-purple-soft);

        color:
            var(--cshow-purple);
    }


    .panel-blue {
        background:
            var(--cshow-blue-soft);

        color:
            var(--cshow-blue);
    }


    .panel-teal {
        background:
            var(--cshow-teal-soft);

        color:
            var(--cshow-teal);
    }


    .panel-orange {
        background:
            var(--cshow-orange-soft);

        color:
            var(--cshow-orange);
    }


    .company-show-panel-header h2 {
        margin:
            0
            0
            3px;

        color:
            var(--cshow-text);

        font-size: 22px;
        font-weight: 900;

        line-height: 1.3;
    }


    .company-show-panel-header p {
        margin: 0;

        color:
            var(--cshow-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .company-show-panel-body {
        padding:
            22px;
    }


    /* ================================================================
       INFORMATION GRID
       ================================================================ */

    .company-information-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 13px;
    }


    .company-information-item {
        min-height: 105px;

        padding:
            15px;

        border:
            1px solid
            var(--cshow-border-soft);

        border-radius: 12px;

        background:
            var(--cshow-soft);
    }


    .company-information-full {
        grid-column:
            1 / -1;
    }


    .company-information-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--cshow-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform:
            uppercase;

        letter-spacing:
            .25px;
    }


    .company-information-value {
        display: block;

        color:
            var(--cshow-text);

        font-size: 17px;
        font-weight: 850;

        line-height: 1.55;

        word-break:
            break-word;
    }


    .company-information-helper {
        display: block;

        margin-top: 4px;

        color:
            var(--cshow-muted);

        font-size: 13px;

        line-height: 1.5;
    }


    /* ================================================================
       CONTACT PERSON
       ================================================================ */

    .company-contact-highlight {
        display: flex;
        align-items: center;

        gap: 16px;

        padding:
            18px;

        border:
            1px solid
            #DDD6F4;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #FCFBFF,
                #F7F4FF
            );
    }


    .company-contact-avatar {
        width: 58px;
        height: 58px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background:
            var(--cshow-purple-soft);

        color:
            var(--cshow-purple);

        font-size: 16px;
        font-weight: 900;
    }


    .company-contact-highlight-copy {
        min-width: 0;
    }


    .company-contact-highlight-label {
        display: block;

        margin-bottom: 3px;

        color:
            var(--cshow-muted);

        font-size: 13px;
        font-weight: 800;

        text-transform:
            uppercase;
    }


    .company-contact-highlight-name {
        display: block;

        color:
            var(--cshow-text);

        font-size: 19px;
        font-weight: 900;

        line-height: 1.4;

        word-break:
            break-word;
    }


    .company-contact-highlight-note {
        display: block;

        margin-top: 3px;

        color:
            var(--cshow-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       COMMUNICATION
       ================================================================ */

    .company-communication-list {
        display: grid;

        gap: 11px;
    }


    .company-communication-item {
        display: flex;
        align-items: center;

        gap: 13px;

        padding:
            14px;

        border:
            1px solid
            var(--cshow-border-soft);

        border-radius: 11px;

        background:
            var(--cshow-soft);
    }


    .company-communication-icon {
        width: 43px;
        height: 43px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        background:
            var(--cshow-blue-soft);

        color:
            var(--cshow-blue);

        font-size: 11px;
        font-weight: 900;
    }


    .company-communication-copy {
        min-width: 0;
    }


    .company-communication-label {
        display: block;

        color:
            var(--cshow-muted);

        font-size: 12px;
        font-weight: 800;

        text-transform:
            uppercase;
    }


    .company-communication-value {
        display: block;

        margin-top: 2px;

        color:
            var(--cshow-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.45;

        word-break:
            break-word;
    }


    /* ================================================================
       SIDEBAR
       ================================================================ */

    .company-sidebar-list {
        display: grid;

        gap: 11px;
    }


    .company-sidebar-item {
        padding:
            14px;

        border:
            1px solid
            var(--cshow-border-soft);

        border-radius: 11px;

        background:
            var(--cshow-soft);
    }


    .company-sidebar-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--cshow-muted);

        font-size: 12px;
        font-weight: 800;

        text-transform:
            uppercase;
    }


    .company-sidebar-value {
        display: block;

        color:
            var(--cshow-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.5;

        word-break:
            break-word;
    }


    /* ================================================================
       WORKFLOW NOTE
       ================================================================ */

    .company-workflow-note {
        padding:
            17px;

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


    .company-workflow-note strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--cshow-blue);

        font-size: 17px;
        font-weight: 900;
    }


    .company-workflow-note p {
        margin: 0;

        color:
            var(--cshow-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       STATUS GUIDANCE
       ================================================================ */

    .company-status-guidance {
        padding:
            17px;

        border:
            1px solid
            #D8E8E5;

        border-radius: 14px;

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
            var(--cshow-teal);

        font-size: 17px;
        font-weight: 900;
    }


    .company-status-guidance p {
        margin: 0;

        color:
            var(--cshow-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       ACTION AREA
       ================================================================ */

    .company-record-actions {
        display: grid;

        gap: 10px;
    }


    .company-record-action {
        width: 100%;

        min-height: 49px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            15px;

        border:
            1px solid
            var(--cshow-border);

        border-radius: 11px;

        background:
            #FFFFFF;

        color:
            var(--cshow-navy);

        font-size: 15px;
        font-weight: 900;

        text-align: center;

        text-decoration: none;

        transition:
            var(--cshow-transition);
    }


    .company-record-action:hover {
        transform:
            translateY(-1px);

        background:
            var(--cshow-purple-soft);

        border-color:
            #D3C9EE;
    }


    .company-record-action-primary {
        border-color:
            var(--cshow-purple);

        background:
            var(--cshow-purple);

        color:
            #FFFFFF;
    }


    .company-record-action-primary:hover {
        border-color:
            var(--cshow-purple-dark);

        background:
            var(--cshow-purple-dark);

        color:
            #FFFFFF;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1150px) {

        .company-show-layout {
            grid-template-columns:
                1fr;
        }


        .company-show-sidebar {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 950px) {

        .company-show-summary {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .company-show-hero-inner {
            flex-direction:
                column;

            align-items:
                flex-start;
        }


        .company-show-hero-actions {
            width:
                100%;
        }

    }


    @media (max-width: 750px) {

        .company-information-grid {
            grid-template-columns:
                1fr;
        }


        .company-information-full {
            grid-column:
                auto;
        }


        .company-show-sidebar {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 650px) {

        .company-show-hero {
            padding:
                29px
                22px;

            border-radius:
                22px;
        }


        .company-show-identity {
            align-items:
                flex-start;
        }


        .company-show-avatar {
            width: 68px;
            height: 68px;

            border-radius:
                19px;

            font-size:
                20px;
        }


        .company-show-hero h1 {
            font-size:
                30px;
        }


        .company-show-summary {
            grid-template-columns:
                1fr;
        }


        .company-contact-highlight {
            align-items:
                flex-start;
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
    | Contact Person Initials
    |--------------------------------------------------------------------------
    */

    $contactInitials =
        filled(
            $company->contact_person
        )
            ? collect(
                preg_split(
                    '/\s+/',
                    trim(
                        (string)
                        $company->contact_person
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
            : 'CP';


    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    $companyStatus =
        strtolower(
            trim(
                (string)
                $company->status
            )
        );


    $companyStatusClass =
        match ($companyStatus) {

            'active' =>
                'company-show-status-active',

            'inactive' =>
                'company-show-status-inactive',

            default =>
                'company-show-status-other',

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


<div class="company-show-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="company-show-hero">


        <div class="company-show-hero-inner">


            <div class="company-show-identity">


                <div class="company-show-avatar">
                    {{ $companyInitials }}
                </div>


                <div>


                    <div class="company-show-eyebrow">

                        <span class="company-show-dot"></span>

                        Administrator · Partner Company Record

                    </div>


                    <h1>
                        {{ $company->name }}
                    </h1>


                    <p class="company-show-hero-address">

                        {{ filled(
                            $company->address
                        )
                            ? $company->address
                            : 'No company address has been provided.'
                        }}

                    </p>


                </div>


            </div>


            <div class="company-show-hero-actions">


                <a
                    href="{{ route(
                        'admin.companies.edit',
                        $company
                    ) }}"
                    class="
                        company-show-hero-button
                        company-show-hero-primary
                    "
                >
                    Edit Company Record
                </a>


                <a
                    href="{{ route(
                        'admin.companies.index'
                    ) }}"
                    class="
                        company-show-hero-button
                        company-show-hero-secondary
                    "
                >
                    Back to Companies
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="company-show-summary">


        <article class="company-show-summary-card">


            <span class="company-show-summary-label">
                Company Status
            </span>


            <span
                class="
                    company-show-status
                    {{ $companyStatusClass }}
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


            <span class="company-show-summary-note">

                Current availability in
                the Company Directory

            </span>


        </article>


        <article class="company-show-summary-card">


            <span class="company-show-summary-label">
                Contact Person
            </span>


            <span class="company-show-summary-value">

                {{ filled(
                    $company->contact_person
                )
                    ? $company->contact_person
                    : 'Not provided'
                }}

            </span>


            <span class="company-show-summary-note">
                Primary company representative
            </span>


        </article>


        <article class="company-show-summary-card">


            <span class="company-show-summary-label">
                Contact Number
            </span>


            <span class="company-show-summary-value">

                {{ filled(
                    $company->contact_number
                )
                    ? $company->contact_number
                    : 'Not provided'
                }}

            </span>


            <span class="company-show-summary-note">
                Official contact information
            </span>


        </article>


        <article class="company-show-summary-card">


            <span class="company-show-summary-label">
                Company Record
            </span>


            <span class="company-show-summary-value">
                #{{ $company->id }}
            </span>


            <span class="company-show-summary-note">
                OJT Sync company identifier
            </span>


        </article>


    </section>


    {{-- ==================================================================
         MAIN LAYOUT
         ================================================================== --}}

    <div class="company-show-layout">


        {{-- ==================================================================
             MAIN
             ================================================================== --}}

        <main class="company-show-main">


            {{-- ==============================================================
                 COMPANY INFORMATION
                 ============================================================== --}}

            <section class="company-show-panel">


                <div class="company-show-panel-header">


                    <div
                        class="
                            company-show-panel-icon
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
                            Official OJT partner establishment details
                        </p>

                    </div>


                </div>


                <div class="company-show-panel-body">


                    <div class="company-information-grid">


                        <div class="company-information-item">


                            <span class="company-information-label">
                                Company Name
                            </span>


                            <span class="company-information-value">
                                {{ $company->name }}
                            </span>


                            <span class="company-information-helper">
                                Registered establishment name
                            </span>


                        </div>


                        <div class="company-information-item">


                            <span class="company-information-label">
                                Current Status
                            </span>


                            <span class="company-information-value">

                                {{ filled(
                                    $company->status
                                )
                                    ? ucfirst(
                                        $company->status
                                    )
                                    : 'Unknown'
                                }}

                            </span>


                            <span class="company-information-helper">
                                Company directory availability
                            </span>


                        </div>


                        <div
                            class="
                                company-information-item
                                company-information-full
                            "
                        >


                            <span class="company-information-label">
                                Company Address
                            </span>


                            <span class="company-information-value">

                                {{ filled(
                                    $company->address
                                )
                                    ? $company->address
                                    : 'No company address has been provided.'
                                }}

                            </span>


                            <span class="company-information-helper">

                                Official location recorded
                                for the OJT establishment

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==============================================================
                 CONTACT PERSON
                 ============================================================== --}}

            <section class="company-show-panel">


                <div class="company-show-panel-header">


                    <div
                        class="
                            company-show-panel-icon
                            panel-teal
                        "
                    >
                        CP
                    </div>


                    <div>

                        <h2>
                            Company Contact
                        </h2>

                        <p>
                            Primary representative and communication details
                        </p>

                    </div>


                </div>


                <div class="company-show-panel-body">


                    <div class="company-contact-highlight">


                        <div class="company-contact-avatar">
                            {{ $contactInitials ?: 'CP' }}
                        </div>


                        <div class="company-contact-highlight-copy">


                            <span class="company-contact-highlight-label">
                                Primary Contact Person
                            </span>


                            <span class="company-contact-highlight-name">

                                {{ filled(
                                    $company->contact_person
                                )
                                    ? $company->contact_person
                                    : 'No contact person provided'
                                }}

                            </span>


                            <span class="company-contact-highlight-note">

                                Main representative recorded
                                for OJT-related communication.

                            </span>


                        </div>


                    </div>


                    <div
                        class="company-communication-list"
                        style="margin-top: 15px;"
                    >


                        <div class="company-communication-item">


                            <div class="company-communication-icon">
                                PH
                            </div>


                            <div class="company-communication-copy">


                                <span class="company-communication-label">
                                    Contact Number
                                </span>


                                <span class="company-communication-value">

                                    {{ filled(
                                        $company->contact_number
                                    )
                                        ? $company->contact_number
                                        : 'Not provided'
                                    }}

                                </span>


                            </div>


                        </div>


                        <div class="company-communication-item">


                            <div class="company-communication-icon">
                                EM
                            </div>


                            <div class="company-communication-copy">


                                <span class="company-communication-label">
                                    Email Address
                                </span>


                                <span class="company-communication-value">

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


                </div>


            </section>


            {{-- ==============================================================
                 OJT WORKFLOW
                 ============================================================== --}}

            <section class="company-show-panel">


                <div class="company-show-panel-header">


                    <div
                        class="
                            company-show-panel-icon
                            panel-blue
                        "
                    >
                        OJ
                    </div>


                    <div>

                        <h2>
                            OJT Placement Context
                        </h2>

                        <p>
                            How this company record is used in OJT Sync
                        </p>

                    </div>


                </div>


                <div class="company-show-panel-body">


                    <div class="company-workflow-note">


                        <strong>
                            Partner Company Record
                        </strong>


                        <p>

                            This company can be referenced when
                            Administrators create and manage Student
                            OJT Assignments.

                            The Company record helps keep the Student,
                            assigned Supervisor, required OJT hours,
                            placement dates, and training establishment
                            connected within the monitoring workflow.

                        </p>


                    </div>


                </div>


            </section>


        </main>


        {{-- ==================================================================
             SIDEBAR
             ================================================================== --}}

        <aside class="company-show-sidebar">


            {{-- ==============================================================
                 RECORD INFORMATION
                 ============================================================== --}}

            <section class="company-show-panel">


                <div class="company-show-panel-header">


                    <div
                        class="
                            company-show-panel-icon
                            panel-purple
                        "
                    >
                        RC
                    </div>


                    <div>

                        <h2>
                            Record Details
                        </h2>

                        <p>
                            System information
                        </p>

                    </div>


                </div>


                <div class="company-show-panel-body">


                    <div class="company-sidebar-list">


                        <div class="company-sidebar-item">


                            <span class="company-sidebar-label">
                                Company ID
                            </span>


                            <span class="company-sidebar-value">
                                #{{ $company->id }}
                            </span>


                        </div>


                        <div class="company-sidebar-item">


                            <span class="company-sidebar-label">
                                Status
                            </span>


                            <span class="company-sidebar-value">

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


                        <div class="company-sidebar-item">


                            <span class="company-sidebar-label">
                                Created
                            </span>


                            <span class="company-sidebar-value">

                                {{ $formatDate(
                                    $company->created_at
                                ) }}

                            </span>


                        </div>


                        <div class="company-sidebar-item">


                            <span class="company-sidebar-label">
                                Last Updated
                            </span>


                            <span class="company-sidebar-value">

                                {{ $formatDate(
                                    $company->updated_at
                                ) }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==============================================================
                 STATUS GUIDANCE
                 ============================================================== --}}

            <section class="company-show-panel">


                <div class="company-show-panel-header">


                    <div
                        class="
                            company-show-panel-icon
                            panel-orange
                        "
                    >
                        ST
                    </div>


                    <div>

                        <h2>
                            Status Guidance
                        </h2>

                        <p>
                            Company availability
                        </p>

                    </div>


                </div>


                <div class="company-show-panel-body">


                    <div class="company-status-guidance">


                        <strong>

                            {{ $companyStatus === 'active'
                                ? 'Company is Active'
                                : (
                                    $companyStatus === 'inactive'
                                        ? 'Company is Inactive'
                                        : 'Company Status'
                                )
                            }}

                        </strong>


                        <p>

                            @if ($companyStatus === 'active')

                                This company is currently marked
                                Active in OJT Sync and is available
                                as a normal company record for
                                administrative use.

                            @elseif ($companyStatus === 'inactive')

                                This company is currently marked
                                Inactive. Its record remains stored
                                for historical and administrative
                                reference.

                            @else

                                Review this Company's current status
                                from the Edit Company page.

                            @endif

                        </p>


                    </div>


                </div>


            </section>


            {{-- ==============================================================
                 QUICK ACTIONS
                 ============================================================== --}}

            <section class="company-show-panel">


                <div class="company-show-panel-header">


                    <div
                        class="
                            company-show-panel-icon
                            panel-blue
                        "
                    >
                        QA
                    </div>


                    <div>

                        <h2>
                            Quick Actions
                        </h2>

                        <p>
                            Company administration
                        </p>

                    </div>


                </div>


                <div class="company-show-panel-body">


                    <div class="company-record-actions">


                        <a
                            href="{{ route(
                                'admin.companies.edit',
                                $company
                            ) }}"
                            class="
                                company-record-action
                                company-record-action-primary
                            "
                        >
                            Edit Company Record
                        </a>


                        <a
                            href="{{ route(
                                'admin.assignments.index'
                            ) }}"
                            class="company-record-action"
                        >
                            View OJT Assignments
                        </a>


                        <a
                            href="{{ route(
                                'admin.companies.index'
                            ) }}"
                            class="company-record-action"
                        >
                            Back to Company Directory
                        </a>


                    </div>


                </div>


            </section>


        </aside>


    </div>


</div>


@endsection