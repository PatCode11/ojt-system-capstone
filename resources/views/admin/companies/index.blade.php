@extends('layouts.app')

@section('title', 'Company Management | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - COMPANY MANAGEMENT
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --co-navy: #183B6B;
        --co-navy-dark: #102A4A;
        --co-navy-deep: #0B223D;

        --co-blue: #2563EB;
        --co-blue-soft: #EAF2FF;

        --co-purple: #6D4FC2;
        --co-purple-dark: #573CA5;
        --co-purple-light: #A78BFA;
        --co-purple-soft: #F2EEFF;

        --co-teal: #0F766E;
        --co-teal-soft: #E7F7F5;

        --co-green: #15803D;
        --co-green-soft: #EAF8EF;

        --co-orange: #B45309;
        --co-orange-soft: #FFF5E6;

        --co-red: #B42318;
        --co-red-soft: #FFF0EE;

        --co-text: #102A4A;
        --co-body: #405872;
        --co-muted: #64778C;

        --co-white: #FFFFFF;
        --co-soft: #F8FBFE;

        --co-border: #D8E3EE;
        --co-border-soft: #E7EDF4;

        --co-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --co-shadow-medium:
            0 18px 42px
            rgba(15, 42, 74, 0.10);

        --co-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --co-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .companies-page {
        width: 100%;

        color:
            var(--co-text);

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

    .companies-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 28px;

        padding:
            43px
            44px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 89% 14%,
                rgba(167, 139, 250, 0.24),
                transparent 27%
            ),
            radial-gradient(
                circle at 70% 98%,
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
            var(--co-shadow-large);
    }


    .companies-hero::before {
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


    .companies-hero::after {
        content: "";

        position: absolute;

        width: 220px;
        height: 220px;

        right: 290px;
        bottom: -165px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.04);
    }


    .companies-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .companies-hero-copy {
        max-width: 780px;
    }


    .companies-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 8px;

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


    .companies-eyebrow-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background:
            #C4B5FD;

        box-shadow:
            0 0 0 5px
            rgba(196, 181, 253, 0.12);
    }


    .companies-hero h1 {
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


    .companies-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO ACTION
       ================================================================ */

    .companies-hero-actions {
        width: 270px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .companies-hero-button {
        min-height: 53px;

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

        text-decoration: none;

        text-align: center;

        transition:
            var(--co-transition);
    }


    .companies-hero-button-primary {
        background:
            #FFFFFF;

        color:
            var(--co-navy);
    }


    .companies-hero-button-primary:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;

        box-shadow:
            0 10px 22px
            rgba(0, 0, 0, 0.10);
    }


    .companies-hero-button-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .companies-hero-button-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    /* ================================================================
       SUMMARY
       ================================================================ */

    .companies-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 18px;

        margin-bottom: 24px;
    }


    .companies-summary-card {
        display: flex;
        align-items: center;

        gap: 15px;

        padding:
            20px;

        border:
            1px solid
            var(--co-border);

        border-radius: 18px;

        background:
            #FFFFFF;

        box-shadow:
            var(--co-shadow);
    }


    .companies-summary-icon {
        width: 54px;
        height: 54px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 15px;

        font-size: 13px;
        font-weight: 900;
    }


    .summary-purple {
        background:
            var(--co-purple-soft);

        color:
            var(--co-purple);
    }


    .summary-green {
        background:
            var(--co-green-soft);

        color:
            var(--co-green);
    }


    .summary-orange {
        background:
            var(--co-orange-soft);

        color:
            var(--co-orange);
    }


    .companies-summary-label {
        display: block;

        color:
            var(--co-muted);

        font-size: 13px;
        font-weight: 800;
    }


    .companies-summary-value {
        display: block;

        margin-top: 1px;

        color:
            var(--co-text);

        font-size: 29px;
        font-weight: 900;

        line-height: 1.2;
    }


    .companies-summary-note {
        display: block;

        margin-top: 2px;

        color:
            var(--co-muted);

        font-size: 13px;

        line-height: 1.45;
    }


    /* ================================================================
       INFORMATION NOTICE
       ================================================================ */

    .companies-information {
        display: flex;
        align-items: flex-start;

        gap: 14px;

        margin-bottom: 23px;

        padding:
            18px
            19px;

        border:
            1px solid
            #DDD6F4;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                #FCFBFF,
                #F7F4FF
            );
    }


    .companies-information-icon {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--co-purple-soft);

        color:
            var(--co-purple);

        font-size: 13px;
        font-weight: 900;
    }


    .companies-information strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--co-text);

        font-size: 16px;
        font-weight: 900;
    }


    .companies-information p {
        margin: 0;

        color:
            var(--co-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       TOOLBAR
       ================================================================ */

    .companies-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 19px;

        padding: 17px;

        border:
            1px solid
            var(--co-border);

        border-radius: 16px;

        background:
            #FFFFFF;

        box-shadow:
            var(--co-shadow);
    }


    .companies-search {
        position: relative;

        width:
            min(
                100%,
                520px
            );
    }


    .companies-search input {
        width: 100%;

        min-height: 53px;

        padding:
            0
            15px
            0
            47px;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background:
            #FBFDFF;

        color:
            var(--co-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;

        transition:
            var(--co-transition);
    }


    .companies-search input::placeholder {
        color:
            #8999AA;
    }


    .companies-search input:focus {
        border-color:
            var(--co-purple);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(109, 79, 194, 0.08);
    }


    .companies-search-icon {
        position: absolute;

        top: 50%;
        left: 15px;

        transform:
            translateY(-50%);

        width: 23px;
        height: 23px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 7px;

        background:
            var(--co-purple-soft);

        color:
            var(--co-purple);

        font-size: 10px;
        font-weight: 900;

        pointer-events: none;
    }


    .companies-toolbar-right {
        display: flex;
        align-items: center;

        gap: 12px;
    }


    .companies-status-filter {
        min-height: 47px;

        padding:
            0
            13px;

        border:
            1px solid
            var(--co-border);

        border-radius: 10px;

        outline: none;

        background:
            #FFFFFF;

        color:
            var(--co-text);

        font-family: inherit;

        font-size: 14px;
        font-weight: 750;

        cursor: pointer;
    }


    .companies-status-filter:focus {
        border-color:
            var(--co-purple);
    }


    .companies-visible-count {
        color:
            var(--co-muted);

        font-size: 14px;
        font-weight: 750;

        white-space: nowrap;
    }


    .companies-visible-count strong {
        color:
            var(--co-text);

        font-size: 17px;
        font-weight: 900;
    }


    /* ================================================================
       COMPANY GRID
       ================================================================ */

    .companies-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 18px;
    }


    .company-card {
        overflow: hidden;

        border:
            1px solid
            var(--co-border);

        border-radius: 19px;

        background:
            #FFFFFF;

        box-shadow:
            var(--co-shadow);

        transition:
            var(--co-transition);
    }


    .company-card:hover {
        transform:
            translateY(-3px);

        border-color:
            #CABEE8;

        box-shadow:
            var(--co-shadow-medium);
    }


    /* ================================================================
       COMPANY HEADER
       ================================================================ */

    .company-card-header {
        display: flex;
        align-items: flex-start;

        gap: 15px;

        padding: 20px;

        border-bottom:
            1px solid
            var(--co-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FDFDFF
            );
    }


    .company-avatar {
        width: 59px;
        height: 59px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background:
            linear-gradient(
                145deg,
                var(--co-navy),
                var(--co-purple)
            );

        color:
            #FFFFFF;

        font-size: 17px;
        font-weight: 900;

        letter-spacing:
            .4px;
    }


    .company-heading {
        min-width: 0;

        flex: 1;
    }


    .company-heading-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 12px;
    }


    .company-name {
        margin:
            0
            0
            4px;

        color:
            var(--co-text);

        font-size: 20px;
        font-weight: 900;

        line-height: 1.35;
    }


    .company-address {
        display: block;

        color:
            var(--co-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       STATUS
       ================================================================ */

    .company-status {
        flex-shrink: 0;

        display: inline-flex;
        align-items: center;

        gap: 6px;

        padding:
            7px
            10px;

        border-radius: 999px;

        font-size: 12px;
        font-weight: 900;

        text-transform:
            capitalize;
    }


    .company-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .company-status-active {
        background:
            var(--co-green-soft);

        color:
            var(--co-green);
    }


    .company-status-active::before {
        background:
            #22C55E;
    }


    .company-status-inactive {
        background:
            var(--co-orange-soft);

        color:
            var(--co-orange);
    }


    .company-status-inactive::before {
        background:
            #F59E0B;
    }


    .company-status-other {
        background:
            #F1F5F9;

        color:
            #475569;
    }


    .company-status-other::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       COMPANY BODY
       ================================================================ */

    .company-card-body {
        padding: 20px;
    }


    .company-section-title {
        display: block;

        margin-bottom: 10px;

        color:
            var(--co-muted);

        font-size: 12px;
        font-weight: 900;

        text-transform:
            uppercase;

        letter-spacing:
            .35px;
    }


    .company-contact-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 11px;
    }


    .company-contact-item {
        min-height: 87px;

        padding: 13px;

        border:
            1px solid
            var(--co-border-soft);

        border-radius: 11px;

        background:
            var(--co-soft);
    }


    .company-contact-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--co-muted);

        font-size: 12px;
        font-weight: 800;

        text-transform:
            uppercase;
    }


    .company-contact-value {
        display: block;

        color:
            var(--co-text);

        font-size: 15px;
        font-weight: 850;

        line-height: 1.5;

        word-break:
            break-word;
    }


    /* ================================================================
       COMPANY FOOTER
       ================================================================ */

    .company-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        margin-top: 17px;

        padding-top: 16px;

        border-top:
            1px solid
            var(--co-border-soft);
    }


    .company-record-id {
        color:
            var(--co-muted);

        font-size: 13px;
        font-weight: 750;
    }


    .company-actions {
        display: flex;
        align-items: center;

        gap: 8px;
    }


    .company-action {
        min-height: 43px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            14px;

        border:
            1px solid
            var(--co-border);

        border-radius: 10px;

        background:
            #FFFFFF;

        color:
            var(--co-navy);

        font-size: 14px;
        font-weight: 850;

        text-decoration: none;

        transition:
            var(--co-transition);
    }


    .company-action:hover {
        transform:
            translateY(-1px);

        background:
            var(--co-purple-soft);

        border-color:
            #D5CBEF;
    }


    .company-action-primary {
        border-color:
            var(--co-purple);

        background:
            var(--co-purple);

        color:
            #FFFFFF;
    }


    .company-action-primary:hover {
        background:
            var(--co-purple-dark);

        color:
            #FFFFFF;

        border-color:
            var(--co-purple-dark);
    }


    /* ================================================================
       EMPTY STATE
       ================================================================ */

    .companies-empty {
        padding:
            54px
            30px;

        border:
            1px dashed
            #C5D4E2;

        border-radius: 20px;

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #F9FCFE
            );

        text-align: center;

        box-shadow:
            var(--co-shadow);
    }


    .companies-empty-icon {
        width: 72px;
        height: 72px;

        margin:
            0
            auto
            16px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 20px;

        background:
            var(--co-purple-soft);

        color:
            var(--co-purple);

        font-size: 20px;
        font-weight: 900;
    }


    .companies-empty h2 {
        margin:
            0
            0
            6px;

        color:
            var(--co-text);

        font-size: 23px;
        font-weight: 900;
    }


    .companies-empty p {
        max-width: 600px;

        margin:
            0
            auto
            20px;

        color:
            var(--co-muted);

        font-size: 15px;

        line-height: 1.65;
    }


    .companies-empty-action {
        min-height: 48px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            18px;

        border-radius: 11px;

        background:
            var(--co-purple);

        color:
            #FFFFFF;

        font-size: 15px;
        font-weight: 900;

        text-decoration: none;
    }


    /* ================================================================
       FILTER EMPTY
       ================================================================ */

    .companies-filter-empty {
        display: none;

        grid-column:
            1 / -1;

        padding:
            35px
            20px;

        border:
            1px dashed
            #C9D6E3;

        border-radius: 15px;

        background:
            #FBFDFF;

        color:
            var(--co-muted);

        font-size: 15px;

        text-align: center;
    }


    /* ================================================================
       PAGINATION
       ================================================================ */

    .companies-pagination {
        margin-top: 24px;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1050px) {

        .companies-hero-inner {
            flex-direction:
                column;

            align-items:
                flex-start;
        }


        .companies-hero-actions {
            width: 100%;
        }

    }


    @media (max-width: 900px) {

        .companies-grid {
            grid-template-columns:
                1fr;
        }


        .companies-summary-grid {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 760px) {

        .companies-toolbar {
            flex-direction:
                column;

            align-items:
                stretch;
        }


        .companies-search {
            width: 100%;
        }


        .companies-toolbar-right {
            justify-content:
                space-between;
        }

    }


    @media (max-width: 650px) {

        .companies-hero {
            padding:
                29px
                22px;

            border-radius:
                22px;
        }


        .companies-hero h1 {
            font-size:
                31px;
        }


        .companies-hero-description {
            font-size:
                16px;
        }


        .company-heading-row {
            flex-direction:
                column;

            align-items:
                flex-start;
        }


        .company-contact-grid {
            grid-template-columns:
                1fr;
        }


        .company-card-footer {
            flex-direction:
                column;

            align-items:
                stretch;
        }


        .company-actions {
            display: grid;

            grid-template-columns:
                1fr
                1fr;
        }


        .company-action {
            width: 100%;
        }


        .companies-toolbar-right {
            flex-direction:
                column;

            align-items:
                stretch;
        }


        .companies-visible-count {
            text-align:
                right;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Current Company Collection
    |--------------------------------------------------------------------------
    |
    | Supports the normal Laravel paginator while remaining safe if this
    | page is ever supplied a Collection instead.
    |
    */

    $companyCollection =
        method_exists(
            $companies,
            'items'
        )
            ? collect(
                $companies->items()
            )
            : collect(
                $companies
            );


    /*
    |--------------------------------------------------------------------------
    | Total Companies
    |--------------------------------------------------------------------------
    */

    $totalCompanies =
        method_exists(
            $companies,
            'total'
        )
            ? $companies->total()
            : $companyCollection->count();


    /*
    |--------------------------------------------------------------------------
    | Current Page Status Counts
    |--------------------------------------------------------------------------
    */

    $activeCompaniesOnPage =
        $companyCollection
            ->filter(
                fn ($company) =>
                    strtolower(
                        (string)
                        $company->status
                    )
                    === 'active'
            )
            ->count();


    $inactiveCompaniesOnPage =
        $companyCollection
            ->filter(
                fn ($company) =>
                    strtolower(
                        (string)
                        $company->status
                    )
                    === 'inactive'
            )
            ->count();


    /*
    |--------------------------------------------------------------------------
    | Initials Helper
    |--------------------------------------------------------------------------
    */

    $makeCompanyInitials =
        function ($name) {

            return collect(
                preg_split(
                    '/\s+/',
                    trim(
                        (string)
                        $name
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

        };


    /*
    |--------------------------------------------------------------------------
    | Company Status Class
    |--------------------------------------------------------------------------
    */

    $companyStatusClass =
        function ($status) {

            return match (
                strtolower(
                    (string)
                    $status
                )
            ) {

                'active' =>
                    'company-status-active',

                'inactive' =>
                    'company-status-inactive',

                default =>
                    'company-status-other',

            };

        };

@endphp


<div class="companies-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="companies-hero">


        <div class="companies-hero-inner">


            <div class="companies-hero-copy">


                <div class="companies-eyebrow">

                    <span class="companies-eyebrow-dot"></span>

                    Administrator · Partner Company Directory

                </div>


                <h1>
                    Company Management
                </h1>


                <p class="companies-hero-description">

                    Manage participating OJT companies and training
                    establishments. Maintain official addresses,
                    contact persons, communication details, and
                    company availability for Student OJT placement.

                </p>


            </div>


            <div class="companies-hero-actions">


                <a
                    href="{{ route(
                        'admin.companies.create'
                    ) }}"
                    class="
                        companies-hero-button
                        companies-hero-button-primary
                    "
                >
                    Add New Company
                </a>


                <a
                    href="{{ route(
                        'admin.assignments.index'
                    ) }}"
                    class="
                        companies-hero-button
                        companies-hero-button-secondary
                    "
                >
                    View OJT Assignments
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="companies-summary-grid">


        <article class="companies-summary-card">


            <div
                class="
                    companies-summary-icon
                    summary-purple
                "
            >
                CO
            </div>


            <div>


                <span class="companies-summary-label">
                    Registered Companies
                </span>


                <span class="companies-summary-value">
                    {{ $totalCompanies }}
                </span>


                <span class="companies-summary-note">
                    OJT establishments in the directory
                </span>


            </div>


        </article>


        <article class="companies-summary-card">


            <div
                class="
                    companies-summary-icon
                    summary-green
                "
            >
                AC
            </div>


            <div>


                <span class="companies-summary-label">
                    Active on This Page
                </span>


                <span class="companies-summary-value">
                    {{ $activeCompaniesOnPage }}
                </span>


                <span class="companies-summary-note">
                    Available company records shown here
                </span>


            </div>


        </article>


        <article class="companies-summary-card">


            <div
                class="
                    companies-summary-icon
                    summary-orange
                "
            >
                IN
            </div>


            <div>


                <span class="companies-summary-label">
                    Inactive on This Page
                </span>


                <span class="companies-summary-value">
                    {{ $inactiveCompaniesOnPage }}
                </span>


                <span class="companies-summary-note">
                    Inactive company records shown here
                </span>


            </div>


        </article>


    </section>


    {{-- ==================================================================
         INFORMATION NOTICE
         ================================================================== --}}

    <section class="companies-information">


        <div class="companies-information-icon">
            OJ
        </div>


        <div>


            <strong>
                Company records support the OJT placement workflow.
            </strong>


            <p>

                Keep company information accurate so Administrators,
                Students, and Supervisors can clearly identify the
                organization responsible for each OJT placement.
                Company status should reflect whether the establishment
                is currently available for normal system use.

            </p>


        </div>


    </section>


    {{-- ==================================================================
         COMPANY DIRECTORY
         ================================================================== --}}

    @if ($companyCollection->isNotEmpty())


        {{-- ==============================================================
             TOOLBAR
             ============================================================== --}}

        <div class="companies-toolbar">


            <div class="companies-search">


                <span class="companies-search-icon">
                    FN
                </span>


                <input
                    type="search"
                    id="company-search"
                    placeholder="Find a company, contact person, email, or address..."
                    aria-label="Find a company"
                >


            </div>


            <div class="companies-toolbar-right">


                <select
                    id="company-status-filter"
                    class="companies-status-filter"
                    aria-label="Filter companies by status"
                >

                    <option value="all">
                        All Statuses
                    </option>

                    <option value="active">
                        Active
                    </option>

                    <option value="inactive">
                        Inactive
                    </option>

                </select>


                <div class="companies-visible-count">

                    Showing

                    <strong id="company-visible-count">
                        {{ $companyCollection->count() }}
                    </strong>

                    on this page

                </div>


            </div>


        </div>


        {{-- ==============================================================
             COMPANY CARDS
             ============================================================== --}}

        <div
            class="companies-grid"
            id="companies-grid"
        >


            @foreach ($companies as $company)


                @php

                    $companyStatus =
                        strtolower(
                            trim(
                                (string)
                                $company->status
                            )
                        );


                    $searchText =
                        strtolower(
                            implode(
                                ' ',
                                [
                                    $company->name,
                                    $company->address,
                                    $company->contact_person,
                                    $company->contact_number,
                                    $company->email,
                                    $company->status,
                                ]
                            )
                        );

                @endphp


                <article
                    class="company-card"
                    data-company-card
                    data-status="{{ $companyStatus }}"
                    data-search="{{ $searchText }}"
                >


                    {{-- ==========================================================
                         HEADER
                         ========================================================== --}}

                    <div class="company-card-header">


                        <div class="company-avatar">

                            {{ $makeCompanyInitials(
                                $company->name
                            ) }}

                        </div>


                        <div class="company-heading">


                            <div class="company-heading-row">


                                <div>


                                    <h2 class="company-name">
                                        {{ $company->name }}
                                    </h2>


                                    <span class="company-address">

                                        {{ filled(
                                            $company->address
                                        )
                                            ? $company->address
                                            : 'No company address provided.'
                                        }}

                                    </span>


                                </div>


                                <span
                                    class="
                                        company-status
                                        {{ $companyStatusClass(
                                            $company->status
                                        ) }}
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


                        </div>


                    </div>


                    {{-- ==========================================================
                         BODY
                         ========================================================== --}}

                    <div class="company-card-body">


                        <span class="company-section-title">
                            Official Contact Information
                        </span>


                        <div class="company-contact-grid">


                            <div class="company-contact-item">


                                <span class="company-contact-label">
                                    Contact Person
                                </span>


                                <span class="company-contact-value">

                                    {{ filled(
                                        $company->contact_person
                                    )
                                        ? $company->contact_person
                                        : 'Not provided'
                                    }}

                                </span>


                            </div>


                            <div class="company-contact-item">


                                <span class="company-contact-label">
                                    Contact Number
                                </span>


                                <span class="company-contact-value">

                                    {{ filled(
                                        $company->contact_number
                                    )
                                        ? $company->contact_number
                                        : 'Not provided'
                                    }}

                                </span>


                            </div>


                            <div
                                class="company-contact-item"
                                style="grid-column: 1 / -1;"
                            >


                                <span class="company-contact-label">
                                    Email Address
                                </span>


                                <span class="company-contact-value">

                                    {{ filled(
                                        $company->email
                                    )
                                        ? $company->email
                                        : 'Not provided'
                                    }}

                                </span>


                            </div>


                        </div>


                        {{-- ======================================================
                             FOOTER
                             ====================================================== --}}

                        <div class="company-card-footer">


                            <span class="company-record-id">
                                Company Record #{{ $company->id }}
                            </span>


                            <div class="company-actions">


                                <a
                                    href="{{ route(
                                        'admin.companies.show',
                                        $company
                                    ) }}"
                                    class="company-action"
                                >
                                    View Details
                                </a>


                                <a
                                    href="{{ route(
                                        'admin.companies.edit',
                                        $company
                                    ) }}"
                                    class="
                                        company-action
                                        company-action-primary
                                    "
                                >
                                    Edit Company
                                </a>


                            </div>


                        </div>


                    </div>


                </article>


            @endforeach


            {{-- ==============================================================
                 FILTER EMPTY
                 ============================================================== --}}

            <div
                class="companies-filter-empty"
                id="companies-filter-empty"
            >

                No company on this page matches
                the selected search or status filter.

            </div>


        </div>


        {{-- ==============================================================
             PAGINATION
             ============================================================== --}}

        @if (
            method_exists(
                $companies,
                'links'
            )
        )

            <div class="companies-pagination">

                {{ $companies->links() }}

            </div>

        @endif


    @else


        {{-- ==================================================================
             EMPTY DIRECTORY
             ================================================================== --}}

        <section class="companies-empty">


            <div class="companies-empty-icon">
                CO
            </div>


            <h2>
                No Companies Registered
            </h2>


            <p>

                The OJT company directory is currently empty.
                Add the first participating company or training
                establishment so it can later be used for Student
                OJT placement and Supervisor assignment.

            </p>


            <a
                href="{{ route(
                    'admin.companies.create'
                ) }}"
                class="companies-empty-action"
            >
                Add First Company
            </a>


        </section>


    @endif


</div>


@endsection


@push('scripts')

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /*
            |--------------------------------------------------------------------------
            | Company Directory Filter
            |--------------------------------------------------------------------------
            |
            | Search and status filtering are client-side only and affect
            | companies already loaded on the current pagination page.
            |
            */

            const searchInput =
                document.getElementById(
                    'company-search'
                );


            const statusFilter =
                document.getElementById(
                    'company-status-filter'
                );


            const companyCards =
                Array.from(
                    document.querySelectorAll(
                        '[data-company-card]'
                    )
                );


            const visibleCount =
                document.getElementById(
                    'company-visible-count'
                );


            const filterEmpty =
                document.getElementById(
                    'companies-filter-empty'
                );


            function applyCompanyFilters() {

                const searchValue =
                    searchInput
                        ? searchInput
                            .value
                            .trim()
                            .toLowerCase()
                        : '';


                const selectedStatus =
                    statusFilter
                        ? statusFilter.value
                        : 'all';


                let visible =
                    0;


                companyCards.forEach(
                    function (card) {

                        const searchable =
                            (
                                card.dataset.search
                                || ''
                            )
                            .toLowerCase();


                        const cardStatus =
                            (
                                card.dataset.status
                                || ''
                            )
                            .toLowerCase();


                        const matchesSearch =
                            searchValue === ''
                            ||
                            searchable.includes(
                                searchValue
                            );


                        const matchesStatus =
                            selectedStatus === 'all'
                            ||
                            cardStatus === selectedStatus;


                        const shouldShow =
                            matchesSearch
                            &&
                            matchesStatus;


                        card.style.display =
                            shouldShow
                                ? ''
                                : 'none';


                        if (shouldShow) {
                            visible++;
                        }

                    }
                );


                if (visibleCount) {

                    visibleCount.textContent =
                        String(
                            visible
                        );

                }


                if (filterEmpty) {

                    filterEmpty.style.display =
                        visible === 0
                            ? 'block'
                            : 'none';

                }

            }


            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    applyCompanyFilters
                );

            }


            if (statusFilter) {

                statusFilter.addEventListener(
                    'change',
                    applyCompanyFilters
                );

            }

        }
    );

</script>

@endpush