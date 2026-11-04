@extends('layouts.app')

@section('title', 'Archived Supervisors | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - ARCHIVED SUPERVISORS
       PROFESSIONAL + READABILITY FIRST
       ================================================================ */

    :root {
        --as-navy: #183B6B;
        --as-navy-dark: #102A4A;
        --as-navy-deep: #0B223D;

        --as-teal: #0F766E;
        --as-teal-dark: #0B5F59;
        --as-teal-light: #2DD4BF;
        --as-teal-soft: #E7F7F5;

        --as-blue: #2563EB;
        --as-blue-soft: #EAF2FF;

        --as-green: #15803D;
        --as-green-soft: #EAF8EF;

        --as-orange: #B45309;
        --as-orange-soft: #FFF5E6;

        --as-red: #B42318;
        --as-red-soft: #FFF0EE;

        --as-purple: #6D4FC2;
        --as-purple-soft: #F2EEFF;

        --as-gray: #475569;
        --as-gray-soft: #F1F5F9;

        --as-text: #102A4A;
        --as-body: #405872;
        --as-muted: #64778C;

        --as-white: #FFFFFF;
        --as-soft: #F8FBFE;

        --as-border: #D8E3EE;
        --as-border-soft: #E7EDF4;

        --as-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --as-shadow-medium:
            0 18px 42px
            rgba(15, 42, 74, 0.10);

        --as-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --as-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .archived-supervisors-page {
        width: 100%;

        color:
            var(--as-text);

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

    .archived-supervisors-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 28px;

        padding:
            42px
            44px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 89% 13%,
                rgba(45, 212, 191, 0.23),
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
                #183B6B 52%,
                #17666B 100%
            );

        box-shadow:
            var(--as-shadow-large);
    }


    .archived-supervisors-hero::before {
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


    .archived-supervisors-hero::after {
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


    .archived-supervisors-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .archived-supervisors-hero-copy {
        max-width: 780px;
    }


    .archived-supervisors-eyebrow {
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


    .archived-supervisors-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background:
            var(--as-teal-light);

        box-shadow:
            0 0 0 5px
            rgba(45, 212, 191, 0.12);
    }


    .archived-supervisors-hero h1 {
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


    .archived-supervisors-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.81);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .archived-supervisors-hero-actions {
        width: 275px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .archived-supervisors-hero-button {
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
            var(--as-transition);
    }


    .hero-button-primary {
        background:
            #FFFFFF;

        color:
            var(--as-navy);
    }


    .hero-button-primary:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;
    }


    .hero-button-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .hero-button-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    /* ================================================================
       SUMMARY
       ================================================================ */

    .archived-supervisors-summary {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 18px;

        margin-bottom: 24px;
    }


    .archived-summary-card {
        padding:
            21px;

        border:
            1px solid
            var(--as-border);

        border-radius: 18px;

        background:
            #FFFFFF;

        box-shadow:
            var(--as-shadow);
    }


    .archived-summary-label {
        display: block;

        margin-bottom: 6px;

        color:
            var(--as-muted);

        font-size: 14px;
        font-weight: 800;
    }


    .archived-summary-value {
        display: block;

        color:
            var(--as-text);

        font-size: 30px;
        font-weight: 900;

        line-height: 1.2;
    }


    .archived-summary-note {
        display: block;

        margin-top: 5px;

        color:
            var(--as-muted);

        font-size: 14px;

        line-height: 1.5;
    }


    /* ================================================================
       INFORMATION NOTICE
       ================================================================ */

    .archived-supervisors-notice {
        display: flex;
        align-items: flex-start;

        gap: 14px;

        margin-bottom: 24px;

        padding:
            18px
            19px;

        border:
            1px solid
            #D7DFF0;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                #FBFCFF,
                #F5F7FD
            );
    }


    .archived-supervisors-notice-icon {
        width: 45px;
        height: 45px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--as-purple-soft);

        color:
            var(--as-purple);

        font-size: 13px;
        font-weight: 900;
    }


    .archived-supervisors-notice strong {
        display: block;

        margin-bottom: 3px;

        color:
            var(--as-text);

        font-size: 16px;
        font-weight: 900;
    }


    .archived-supervisors-notice p {
        margin: 0;

        color:
            var(--as-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       TOOLBAR
       ================================================================ */

    .archived-supervisors-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 19px;

        padding:
            17px;

        border:
            1px solid
            var(--as-border);

        border-radius: 16px;

        background:
            #FFFFFF;

        box-shadow:
            var(--as-shadow);
    }


    .archived-supervisors-search {
        position: relative;

        width: min(
            100%,
            500px
        );
    }


    .archived-supervisors-search input {
        width: 100%;

        min-height: 52px;

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
            var(--as-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;
    }


    .archived-supervisors-search input:focus {
        border-color:
            var(--as-teal);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(15, 118, 110, 0.08);
    }


    .archived-supervisors-search-icon {
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
            var(--as-teal-soft);

        color:
            var(--as-teal);

        font-size: 10px;
        font-weight: 900;

        pointer-events: none;
    }


    .archived-supervisors-visible {
        color:
            var(--as-muted);

        font-size: 14px;
        font-weight: 750;

        white-space: nowrap;
    }


    .archived-supervisors-visible strong {
        color:
            var(--as-text);

        font-size: 17px;
        font-weight: 900;
    }


    /* ================================================================
       ARCHIVED RECORD GRID
       ================================================================ */

    .archived-supervisors-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 18px;
    }


    .archived-supervisor-card {
        overflow: hidden;

        border:
            1px solid
            var(--as-border);

        border-radius: 19px;

        background:
            #FFFFFF;

        box-shadow:
            var(--as-shadow);

        transition:
            var(--as-transition);
    }


    .archived-supervisor-card:hover {
        transform:
            translateY(-3px);

        border-color:
            #BCD0E4;

        box-shadow:
            var(--as-shadow-medium);
    }


    /* ================================================================
       CARD HEADER
       ================================================================ */

    .archived-supervisor-card-header {
        display: flex;
        align-items: flex-start;

        gap: 15px;

        padding:
            20px;

        border-bottom:
            1px solid
            var(--as-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FCFDFE
            );
    }


    .archived-supervisor-avatar {
        width: 58px;
        height: 58px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background:
            linear-gradient(
                145deg,
                var(--as-navy),
                var(--as-teal)
            );

        color:
            #FFFFFF;

        font-size: 17px;
        font-weight: 900;
    }


    .archived-supervisor-identity {
        min-width: 0;

        flex: 1;
    }


    .archived-supervisor-name-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 12px;
    }


    .archived-supervisor-name {
        margin:
            0
            0
            3px;

        color:
            var(--as-text);

        font-size: 20px;
        font-weight: 900;

        line-height: 1.35;
    }


    .archived-supervisor-email {
        display: block;

        color:
            var(--as-muted);

        font-size: 14px;

        line-height: 1.55;

        word-break:
            break-word;
    }


    .archived-badge {
        flex-shrink: 0;

        display: inline-flex;
        align-items: center;

        gap: 6px;

        padding:
            7px
            10px;

        border-radius: 999px;

        background:
            var(--as-red-soft);

        color:
            var(--as-red);

        font-size: 12px;
        font-weight: 900;
    }


    .archived-badge::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;

        background:
            #D92D20;
    }


    /* ================================================================
       CARD BODY
       ================================================================ */

    .archived-supervisor-card-body {
        padding:
            20px;
    }


    .archived-supervisor-details {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 11px;

        margin-bottom: 16px;
    }


    .archived-supervisor-detail {
        padding:
            13px;

        border:
            1px solid
            var(--as-border-soft);

        border-radius: 11px;

        background:
            var(--as-soft);
    }


    .archived-supervisor-detail-label {
        display: block;

        margin-bottom: 3px;

        color:
            var(--as-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            .2px;
    }


    .archived-supervisor-detail-value {
        display: block;

        color:
            var(--as-text);

        font-size: 16px;
        font-weight: 900;

        line-height: 1.45;

        word-break:
            break-word;
    }


    /* ================================================================
       HISTORICAL RESPONSIBILITY
       ================================================================ */

    .archived-supervisor-history {
        margin-bottom: 16px;

        padding:
            14px
            15px;

        border:
            1px solid
            #D8E8E5;

        border-radius: 12px;

        background:
            linear-gradient(
                135deg,
                #FAFDFC,
                #F3FAF8
            );
    }


    .archived-supervisor-history-title {
        display: block;

        margin-bottom: 7px;

        color:
            var(--as-teal);

        font-size: 14px;
        font-weight: 900;
    }


    .archived-supervisor-history-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 9px;
    }


    .archived-supervisor-history-item {
        padding:
            10px;

        border-radius: 9px;

        background:
            rgba(255, 255, 255, 0.78);
    }


    .archived-supervisor-history-item span {
        display: block;

        color:
            var(--as-muted);

        font-size: 12px;
        font-weight: 750;
    }


    .archived-supervisor-history-item strong {
        display: block;

        margin-top: 1px;

        color:
            var(--as-text);

        font-size: 18px;
        font-weight: 900;
    }


    /* ================================================================
       RESTORE AREA
       ================================================================ */

    .archived-supervisor-restore {
        padding-top: 16px;

        border-top:
            1px solid
            var(--as-border-soft);
    }


    .archived-supervisor-restore-notice {
        margin-bottom: 11px;

        color:
            var(--as-muted);

        font-size: 13px;

        line-height: 1.55;
    }


    .archived-supervisor-restore-notice strong {
        color:
            var(--as-orange);
    }


    .archived-supervisor-restore-button {
        width: 100%;

        min-height: 49px;

        border:
            1px solid
            var(--as-teal);

        border-radius: 11px;

        background:
            var(--as-teal);

        color:
            #FFFFFF;

        font-family: inherit;

        font-size: 15px;
        font-weight: 900;

        cursor: pointer;

        transition:
            var(--as-transition);
    }


    .archived-supervisor-restore-button:hover {
        transform:
            translateY(-1px);

        background:
            var(--as-teal-dark);
    }


    .archived-supervisor-restore-button:disabled {
        border-color:
            #8DA2B4;

        background:
            #8DA2B4;

        cursor:
            wait;

        transform:
            none;
    }


    /* ================================================================
       EMPTY STATE
       ================================================================ */

    .archived-supervisors-empty {
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
            var(--as-shadow);
    }


    .archived-supervisors-empty-icon {
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
            var(--as-teal-soft);

        color:
            var(--as-teal);

        font-size: 20px;
        font-weight: 900;
    }


    .archived-supervisors-empty h2 {
        margin:
            0
            0
            6px;

        color:
            var(--as-text);

        font-size: 23px;
        font-weight: 900;
    }


    .archived-supervisors-empty p {
        max-width: 580px;

        margin:
            0
            auto
            20px;

        color:
            var(--as-muted);

        font-size: 15px;

        line-height: 1.65;
    }


    .archived-supervisors-empty-action {
        min-height: 48px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            18px;

        border-radius: 11px;

        background:
            var(--as-navy);

        color:
            #FFFFFF;

        font-size: 15px;
        font-weight: 900;

        text-decoration: none;

        transition:
            var(--as-transition);
    }


    .archived-supervisors-empty-action:hover {
        transform:
            translateY(-1px);

        background:
            var(--as-navy-dark);
    }


    /* ================================================================
       FILTER EMPTY
       ================================================================ */

    .archived-supervisors-filter-empty {
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
            var(--as-muted);

        font-size: 15px;

        text-align: center;
    }


    /* ================================================================
       PAGINATION
       ================================================================ */

    .archived-supervisors-pagination {
        margin-top: 24px;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1000px) {

        .archived-supervisors-hero-inner {
            flex-direction:
                column;

            align-items:
                flex-start;
        }


        .archived-supervisors-hero-actions {
            width: 100%;
        }


        .archived-supervisors-grid {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 800px) {

        .archived-supervisors-summary {
            grid-template-columns:
                1fr;
        }


        .archived-supervisors-toolbar {
            flex-direction:
                column;

            align-items:
                stretch;
        }


        .archived-supervisors-search {
            width: 100%;
        }


        .archived-supervisors-visible {
            text-align: right;
        }

    }


    @media (max-width: 650px) {

        .archived-supervisors-hero {
            padding:
                29px
                22px;

            border-radius:
                22px;
        }


        .archived-supervisors-hero h1 {
            font-size:
                31px;
        }


        .archived-supervisors-hero-description {
            font-size:
                16px;
        }


        .archived-supervisor-card-header {
            flex-wrap: wrap;
        }


        .archived-supervisor-name-row {
            flex-direction:
                column;

            align-items:
                flex-start;
        }


        .archived-supervisor-details,
        .archived-supervisor-history-grid {
            grid-template-columns:
                1fr;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Current Page Collection
    |--------------------------------------------------------------------------
    */

    $archivedSupervisors =
        collect(
            $supervisors->items()
        );


    /*
    |--------------------------------------------------------------------------
    | Historical Counts - Current Pagination Page
    |--------------------------------------------------------------------------
    */

    $historicalAssignments =
        $archivedSupervisors
            ->flatMap(
                fn ($supervisor) =>
                    collect(
                        $supervisor->supervisedAssignments
                        ?? []
                    )
            );


    $historicalStudentCount =
        $historicalAssignments
            ->pluck('student_profile_id')
            ->filter()
            ->unique()
            ->count();


    /*
    |--------------------------------------------------------------------------
    | Initials Helper
    |--------------------------------------------------------------------------
    */

    $makeInitials =
        function ($name) {

            return collect(
                preg_split(
                    '/\s+/',
                    trim(
                        (string) $name
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

        };


    /*
    |--------------------------------------------------------------------------
    | Date Formatter
    |--------------------------------------------------------------------------
    */

    $formatDateTime =
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
                            'M d, Y · h:i A'
                        );

            } catch (\Throwable $exception) {

                return (string) $date;

            }

        };

@endphp


<div class="archived-supervisors-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="archived-supervisors-hero">


        <div class="archived-supervisors-hero-inner">


            <div class="archived-supervisors-hero-copy">


                <div class="archived-supervisors-eyebrow">

                    <span class="archived-supervisors-dot"></span>

                    Administrator · Account Archive

                </div>


                <h1>
                    Archived Supervisors
                </h1>


                <p class="archived-supervisors-hero-description">

                    Review Supervisor accounts that were safely
                    archived from normal system access. Historical
                    OJT supervision records remain preserved, and
                    eligible accounts may be restored when needed.

                </p>


            </div>


            <div class="archived-supervisors-hero-actions">


                <a
                    href="{{ route(
                        'admin.supervisors.index'
                    ) }}"
                    class="
                        archived-supervisors-hero-button
                        hero-button-primary
                    "
                >
                    Back to Supervisors
                </a>


                <a
                    href="{{ route(
                        'admin.supervisors.create'
                    ) }}"
                    class="
                        archived-supervisors-hero-button
                        hero-button-secondary
                    "
                >
                    Create New Supervisor
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="archived-supervisors-summary">


        <article class="archived-summary-card">


            <span class="archived-summary-label">
                Archived Accounts
            </span>


            <span class="archived-summary-value">
                {{ $supervisors->total() }}
            </span>


            <span class="archived-summary-note">
                Supervisor accounts currently archived
            </span>


        </article>


        <article class="archived-summary-card">


            <span class="archived-summary-label">
                Historical Assignments
            </span>


            <span class="archived-summary-value">
                {{ $historicalAssignments->count() }}
            </span>


            <span class="archived-summary-note">
                Assignments represented on this page
            </span>


        </article>


        <article class="archived-summary-card">


            <span class="archived-summary-label">
                Historical Students
            </span>


            <span class="archived-summary-value">
                {{ $historicalStudentCount }}
            </span>


            <span class="archived-summary-note">
                Unique Students represented on this page
            </span>


        </article>


    </section>


    {{-- ==================================================================
         ARCHIVE INFORMATION
         ================================================================== --}}

    <section class="archived-supervisors-notice">


        <div class="archived-supervisors-notice-icon">
            AR
        </div>


        <div>


            <strong>
                Archived does not mean permanently deleted.
            </strong>


            <p>

                OJT Sync uses safe account archiving so historical
                supervision and OJT records can remain available.
                Restoring an account does not automatically reactivate
                Supervisor login access; the restored account remains
                inactive until an Administrator deliberately activates it.

            </p>


        </div>


    </section>


    {{-- ==================================================================
         RECORDS
         ================================================================== --}}

    @if ($supervisors->count() > 0)


        <div class="archived-supervisors-toolbar">


            <div class="archived-supervisors-search">


                <span class="archived-supervisors-search-icon">
                    FN
                </span>


                <input
                    type="search"
                    id="archived-supervisor-search"
                    placeholder="Find an archived Supervisor..."
                    aria-label="Find an archived Supervisor"
                >


            </div>


            <div class="archived-supervisors-visible">

                Showing

                <strong id="archived-supervisor-visible-count">
                    {{ $supervisors->count() }}
                </strong>

                on this page

            </div>


        </div>


        <div
            class="archived-supervisors-grid"
            id="archived-supervisors-grid"
        >


            @foreach ($supervisors as $supervisor)


                @php

                    /*
                    |--------------------------------------------------------------------------
                    | Historical Assignments
                    |--------------------------------------------------------------------------
                    */

                    $assignments =
                        collect(
                            $supervisor
                                ->supervisedAssignments
                            ?? []
                        );


                    $studentCount =
                        $assignments
                            ->pluck(
                                'student_profile_id'
                            )
                            ->filter()
                            ->unique()
                            ->count();


                    $companyCount =
                        $assignments
                            ->pluck(
                                'company_id'
                            )
                            ->filter()
                            ->unique()
                            ->count();


                    /*
                    |--------------------------------------------------------------------------
                    | Search Data
                    |--------------------------------------------------------------------------
                    */

                    $studentNames =
                        $assignments
                            ->map(
                                fn ($assignment) =>
                                    $assignment
                                        ->studentProfile
                                        ?->user
                                        ?->name
                            )
                            ->filter()
                            ->implode(' ');


                    $companyNames =
                        $assignments
                            ->map(
                                fn ($assignment) =>
                                    $assignment
                                        ->company
                                        ?->name
                            )
                            ->filter()
                            ->implode(' ');


                    $searchText =
                        strtolower(
                            implode(
                                ' ',
                                [
                                    $supervisor->name,
                                    $supervisor->email,
                                    $studentNames,
                                    $companyNames,
                                ]
                            )
                        );

                @endphp


                <article
                    class="archived-supervisor-card"
                    data-archived-supervisor
                    data-search="{{ $searchText }}"
                >


                    {{-- ==========================================================
                         HEADER
                         ========================================================== --}}

                    <div class="archived-supervisor-card-header">


                        <div class="archived-supervisor-avatar">
                            {{ $makeInitials(
                                $supervisor->name
                            ) }}
                        </div>


                        <div class="archived-supervisor-identity">


                            <div class="archived-supervisor-name-row">


                                <div>


                                    <h2 class="archived-supervisor-name">
                                        {{ $supervisor->name }}
                                    </h2>


                                    <span class="archived-supervisor-email">
                                        {{ $supervisor->email }}
                                    </span>


                                </div>


                                <span class="archived-badge">
                                    Archived
                                </span>


                            </div>


                        </div>


                    </div>


                    {{-- ==========================================================
                         BODY
                         ========================================================== --}}

                    <div class="archived-supervisor-card-body">


                        <div class="archived-supervisor-details">


                            <div class="archived-supervisor-detail">


                                <span class="archived-supervisor-detail-label">
                                    Account Role
                                </span>


                                <span class="archived-supervisor-detail-value">
                                    Supervisor
                                </span>


                            </div>


                            <div class="archived-supervisor-detail">


                                <span class="archived-supervisor-detail-label">
                                    Account Status
                                </span>


                                <span class="archived-supervisor-detail-value">
                                    {{ ucfirst(
                                        (string)
                                        $supervisor->status
                                    ) }}
                                </span>


                            </div>


                            <div class="archived-supervisor-detail">


                                <span class="archived-supervisor-detail-label">
                                    Archived On
                                </span>


                                <span class="archived-supervisor-detail-value">

                                    {{ $formatDateTime(
                                        $supervisor->deleted_at
                                    ) }}

                                </span>


                            </div>


                            <div class="archived-supervisor-detail">


                                <span class="archived-supervisor-detail-label">
                                    Account ID
                                </span>


                                <span class="archived-supervisor-detail-value">
                                    #{{ $supervisor->id }}
                                </span>


                            </div>


                        </div>


                        {{-- ======================================================
                             HISTORICAL RECORDS
                             ====================================================== --}}

                        <div class="archived-supervisor-history">


                            <span class="archived-supervisor-history-title">
                                Preserved Historical Records
                            </span>


                            <div class="archived-supervisor-history-grid">


                                <div class="archived-supervisor-history-item">

                                    <span>
                                        OJT Assignments
                                    </span>

                                    <strong>
                                        {{ $assignments->count() }}
                                    </strong>

                                </div>


                                <div class="archived-supervisor-history-item">

                                    <span>
                                        Students Supervised
                                    </span>

                                    <strong>
                                        {{ $studentCount }}
                                    </strong>

                                </div>


                                <div class="archived-supervisor-history-item">

                                    <span>
                                        Companies
                                    </span>

                                    <strong>
                                        {{ $companyCount }}
                                    </strong>

                                </div>


                                <div class="archived-supervisor-history-item">

                                    <span>
                                        Archive State
                                    </span>

                                    <strong>
                                        Preserved
                                    </strong>

                                </div>


                            </div>


                        </div>


                        {{-- ======================================================
                             RESTORE
                             ====================================================== --}}

                        <div class="archived-supervisor-restore">


                            <div class="archived-supervisor-restore-notice">

                                After restoration, this account will remain

                                <strong>
                                    inactive
                                </strong>

                                until an Administrator intentionally
                                reactivates it.

                            </div>


                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.supervisors.restore',
                                    $supervisor->id
                                ) }}"
                                data-restore-form
                                data-supervisor-name="{{ $supervisor->name }}"
                            >

                                @csrf
                                @method('PATCH')


                                <button
                                    type="submit"
                                    class="archived-supervisor-restore-button"
                                >
                                    Restore Supervisor Account
                                </button>


                            </form>


                        </div>


                    </div>


                </article>


            @endforeach


            <div
                class="archived-supervisors-filter-empty"
                id="archived-supervisors-filter-empty"
            >

                No archived Supervisor on this page
                matches your search.

            </div>


        </div>


        <div class="archived-supervisors-pagination">

            {{ $supervisors->links() }}

        </div>


    @else


        {{-- ==================================================================
             EMPTY ARCHIVE
             ================================================================== --}}

        <section class="archived-supervisors-empty">


            <div class="archived-supervisors-empty-icon">
                ✓
            </div>


            <h2>
                No Archived Supervisors
            </h2>


            <p>

                There are currently no Supervisor accounts in the
                archive. When an eligible Supervisor is safely archived,
                the account will appear here together with its preserved
                historical OJT information and Restore option.

            </p>


            <a
                href="{{ route(
                    'admin.supervisors.index'
                ) }}"
                class="archived-supervisors-empty-action"
            >
                Return to Supervisor Management
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
            | Search Archived Supervisors
            |--------------------------------------------------------------------------
            |
            | This filters only the records already loaded on the current
            | pagination page. It does not alter or query the database.
            |
            */

            const searchInput =
                document.getElementById(
                    'archived-supervisor-search'
                );


            const records =
                Array.from(
                    document.querySelectorAll(
                        '[data-archived-supervisor]'
                    )
                );


            const visibleCount =
                document.getElementById(
                    'archived-supervisor-visible-count'
                );


            const filterEmpty =
                document.getElementById(
                    'archived-supervisors-filter-empty'
                );


            function filterSupervisors() {

                if (! searchInput) {
                    return;
                }


                const searchValue =
                    searchInput.value
                        .trim()
                        .toLowerCase();


                let visible =
                    0;


                records.forEach(
                    function (record) {

                        const searchData =
                            (
                                record.dataset.search
                                || ''
                            )
                            .toLowerCase();


                        const matches =
                            searchValue === ''
                            ||
                            searchData.includes(
                                searchValue
                            );


                        record.style.display =
                            matches
                                ? ''
                                : 'none';


                        if (matches) {
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
                    filterSupervisors
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Safe Restore Confirmation
            |--------------------------------------------------------------------------
            */

            const restoreForms =
                document.querySelectorAll(
                    '[data-restore-form]'
                );


            restoreForms.forEach(
                function (form) {

                    form.addEventListener(
                        'submit',
                        function (event) {

                            const supervisorName =
                                form.dataset
                                    .supervisorName
                                ||
                                'this Supervisor';


                            const confirmed =
                                window.confirm(
                                    'Restore '
                                    +
                                    supervisorName
                                    +
                                    '?\n\n'
                                    +
                                    'The Supervisor account will be returned '
                                    +
                                    'to the normal system directory, but it '
                                    +
                                    'will remain INACTIVE until an Administrator '
                                    +
                                    'deliberately reactivates it.'
                                );


                            if (! confirmed) {

                                event.preventDefault();

                                return;

                            }


                            const button =
                                form.querySelector(
                                    'button[type="submit"]'
                                );


                            if (button) {

                                button.disabled =
                                    true;


                                button.textContent =
                                    'Restoring Account...';

                            }

                        }
                    );

                }
            );

        }
    );

</script>

@endpush