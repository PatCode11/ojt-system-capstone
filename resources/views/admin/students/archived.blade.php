@extends('layouts.app')

@section('title', 'Archived Students | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - ARCHIVED STUDENTS
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --ast-navy: #183B6B;
        --ast-navy-dark: #102A4A;
        --ast-navy-deep: #0B223D;

        --ast-blue: #2563EB;
        --ast-blue-light: #60A5FA;
        --ast-blue-soft: #EAF2FF;

        --ast-teal: #0F766E;
        --ast-teal-soft: #E7F7F5;

        --ast-green: #15803D;
        --ast-green-soft: #EAF8EF;

        --ast-orange: #B45309;
        --ast-orange-soft: #FFF5E6;

        --ast-red: #B42318;
        --ast-red-soft: #FFF0EE;

        --ast-purple: #6D4FC2;
        --ast-purple-soft: #F2EEFF;

        --ast-text: #102A4A;
        --ast-body: #405872;
        --ast-muted: #64778C;

        --ast-white: #FFFFFF;
        --ast-soft: #F8FBFE;

        --ast-border: #D8E3EE;
        --ast-border-soft: #E7EDF4;

        --ast-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --ast-shadow-medium:
            0 18px 42px
            rgba(15, 42, 74, 0.10);

        --ast-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --ast-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .archived-students-page {
        width: 100%;

        color:
            var(--ast-text);

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

    .archived-students-hero {
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
                rgba(96, 165, 250, 0.26),
                transparent 27%
            ),
            radial-gradient(
                circle at 70% 96%,
                rgba(45, 212, 191, 0.10),
                transparent 31%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 55%,
                #285F98 100%
            );

        box-shadow:
            var(--ast-shadow-large);
    }


    .archived-students-hero::before {
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


    .archived-students-hero::after {
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


    .archived-students-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .archived-students-hero-copy {
        max-width: 780px;
    }


    .archived-students-eyebrow {
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


    .archived-students-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background:
            var(--ast-blue-light);

        box-shadow:
            0 0 0 5px
            rgba(96, 165, 250, 0.13);
    }


    .archived-students-hero h1 {
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


    .archived-students-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .archived-students-hero-actions {
        width: 270px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .archived-students-hero-button {
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
            var(--ast-transition);
    }


    .hero-button-primary {
        background:
            #FFFFFF;

        color:
            var(--ast-navy);
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

    .archived-students-summary {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 18px;

        margin-bottom: 24px;
    }


    .archived-student-summary-card {
        padding:
            21px;

        border:
            1px solid
            var(--ast-border);

        border-radius: 18px;

        background:
            #FFFFFF;

        box-shadow:
            var(--ast-shadow);
    }


    .archived-student-summary-label {
        display: block;

        margin-bottom: 6px;

        color:
            var(--ast-muted);

        font-size: 14px;
        font-weight: 800;
    }


    .archived-student-summary-value {
        display: block;

        color:
            var(--ast-text);

        font-size: 30px;
        font-weight: 900;

        line-height: 1.2;
    }


    .archived-student-summary-note {
        display: block;

        margin-top: 5px;

        color:
            var(--ast-muted);

        font-size: 14px;

        line-height: 1.5;
    }


    /* ================================================================
       ARCHIVE INFORMATION
       ================================================================ */

    .archived-students-notice {
        display: flex;
        align-items: flex-start;

        gap: 14px;

        margin-bottom: 24px;

        padding:
            18px
            19px;

        border:
            1px solid
            #D6E2EF;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                #FBFDFF,
                #F4F8FD
            );
    }


    .archived-students-notice-icon {
        width: 45px;
        height: 45px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--ast-blue-soft);

        color:
            var(--ast-blue);

        font-size: 13px;
        font-weight: 900;
    }


    .archived-students-notice strong {
        display: block;

        margin-bottom: 3px;

        color:
            var(--ast-text);

        font-size: 16px;
        font-weight: 900;
    }


    .archived-students-notice p {
        margin: 0;

        color:
            var(--ast-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       TOOLBAR
       ================================================================ */

    .archived-students-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 19px;

        padding:
            17px;

        border:
            1px solid
            var(--ast-border);

        border-radius: 16px;

        background:
            #FFFFFF;

        box-shadow:
            var(--ast-shadow);
    }


    .archived-students-search {
        position: relative;

        width:
            min(
                100%,
                510px
            );
    }


    .archived-students-search input {
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
            var(--ast-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;

        transition:
            var(--ast-transition);
    }


    .archived-students-search input:focus {
        border-color:
            var(--ast-blue);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, 0.08);
    }


    .archived-students-search-icon {
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
            var(--ast-blue-soft);

        color:
            var(--ast-blue);

        font-size: 10px;
        font-weight: 900;

        pointer-events: none;
    }


    .archived-students-visible {
        color:
            var(--ast-muted);

        font-size: 14px;
        font-weight: 750;

        white-space: nowrap;
    }


    .archived-students-visible strong {
        color:
            var(--ast-text);

        font-size: 17px;
        font-weight: 900;
    }


    /* ================================================================
       RECORD GRID
       ================================================================ */

    .archived-students-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 18px;
    }


    .archived-student-card {
        overflow: hidden;

        border:
            1px solid
            var(--ast-border);

        border-radius: 19px;

        background:
            #FFFFFF;

        box-shadow:
            var(--ast-shadow);

        transition:
            var(--ast-transition);
    }


    .archived-student-card:hover {
        transform:
            translateY(-3px);

        border-color:
            #BCD0E4;

        box-shadow:
            var(--ast-shadow-medium);
    }


    /* ================================================================
       CARD HEADER
       ================================================================ */

    .archived-student-card-header {
        display: flex;
        align-items: flex-start;

        gap: 15px;

        padding: 20px;

        border-bottom:
            1px solid
            var(--ast-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FCFDFE
            );
    }


    .archived-student-avatar {
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
                var(--ast-navy),
                var(--ast-blue)
            );

        color:
            #FFFFFF;

        font-size: 17px;
        font-weight: 900;
    }


    .archived-student-identity {
        min-width: 0;

        flex: 1;
    }


    .archived-student-name-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 12px;
    }


    .archived-student-name {
        margin:
            0
            0
            3px;

        color:
            var(--ast-text);

        font-size: 20px;
        font-weight: 900;

        line-height: 1.35;
    }


    .archived-student-email {
        display: block;

        color:
            var(--ast-muted);

        font-size: 14px;

        line-height: 1.55;

        word-break:
            break-word;
    }


    .archived-student-badge {
        flex-shrink: 0;

        display: inline-flex;
        align-items: center;

        gap: 6px;

        padding:
            7px
            10px;

        border-radius: 999px;

        background:
            var(--ast-red-soft);

        color:
            var(--ast-red);

        font-size: 12px;
        font-weight: 900;
    }


    .archived-student-badge::before {
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

    .archived-student-card-body {
        padding: 20px;
    }


    .archived-student-details {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 11px;

        margin-bottom: 16px;
    }


    .archived-student-detail {
        padding: 13px;

        border:
            1px solid
            var(--ast-border-soft);

        border-radius: 11px;

        background:
            var(--ast-soft);
    }


    .archived-student-detail-label {
        display: block;

        margin-bottom: 3px;

        color:
            var(--ast-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform:
            uppercase;

        letter-spacing:
            .2px;
    }


    .archived-student-detail-value {
        display: block;

        color:
            var(--ast-text);

        font-size: 16px;
        font-weight: 900;

        line-height: 1.45;

        word-break:
            break-word;
    }


    /* ================================================================
       ACADEMIC INFORMATION
       ================================================================ */

    .archived-student-academic {
        margin-bottom: 16px;

        padding:
            15px;

        border:
            1px solid
            #D8E4F1;

        border-radius: 12px;

        background:
            linear-gradient(
                135deg,
                #FBFDFF,
                #F5F9FE
            );
    }


    .archived-student-academic-title {
        display: block;

        margin-bottom: 8px;

        color:
            var(--ast-blue);

        font-size: 14px;
        font-weight: 900;
    }


    .archived-student-academic-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 9px;
    }


    .archived-student-academic-item {
        padding:
            10px;

        border-radius: 9px;

        background:
            rgba(255, 255, 255, 0.82);
    }


    .archived-student-academic-item span {
        display: block;

        color:
            var(--ast-muted);

        font-size: 12px;
        font-weight: 750;
    }


    .archived-student-academic-item strong {
        display: block;

        margin-top: 2px;

        color:
            var(--ast-text);

        font-size: 15px;
        font-weight: 900;

        line-height: 1.45;
    }


    /* ================================================================
       HISTORICAL OJT
       ================================================================ */

    .archived-student-history {
        margin-bottom: 16px;

        padding:
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


    .archived-student-history-title {
        display: block;

        margin-bottom: 8px;

        color:
            var(--ast-teal);

        font-size: 14px;
        font-weight: 900;
    }


    .archived-student-history-grid {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 9px;
    }


    .archived-student-history-item {
        padding:
            10px;

        border-radius: 9px;

        background:
            rgba(255, 255, 255, 0.80);
    }


    .archived-student-history-item span {
        display: block;

        color:
            var(--ast-muted);

        font-size: 12px;
        font-weight: 750;
    }


    .archived-student-history-item strong {
        display: block;

        margin-top: 1px;

        color:
            var(--ast-text);

        font-size: 18px;
        font-weight: 900;
    }


    /* ================================================================
       RESTORE
       ================================================================ */

    .archived-student-restore {
        padding-top: 16px;

        border-top:
            1px solid
            var(--ast-border-soft);
    }


    .archived-student-restore-notice {
        margin-bottom: 11px;

        color:
            var(--ast-muted);

        font-size: 13px;

        line-height: 1.55;
    }


    .archived-student-restore-notice strong {
        color:
            var(--ast-orange);
    }


    .archived-student-restore-button {
        width: 100%;

        min-height: 49px;

        border:
            1px solid
            var(--ast-blue);

        border-radius: 11px;

        background:
            var(--ast-blue);

        color:
            #FFFFFF;

        font-family: inherit;

        font-size: 15px;
        font-weight: 900;

        cursor: pointer;

        transition:
            var(--ast-transition);
    }


    .archived-student-restore-button:hover {
        transform:
            translateY(-1px);

        background:
            #1D4ED8;
    }


    .archived-student-restore-button:disabled {
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
       EMPTY ARCHIVE
       ================================================================ */

    .archived-students-empty {
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
            var(--ast-shadow);
    }


    .archived-students-empty-icon {
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
            var(--ast-blue-soft);

        color:
            var(--ast-blue);

        font-size: 20px;
        font-weight: 900;
    }


    .archived-students-empty h2 {
        margin:
            0
            0
            6px;

        color:
            var(--ast-text);

        font-size: 23px;
        font-weight: 900;
    }


    .archived-students-empty p {
        max-width: 600px;

        margin:
            0
            auto
            20px;

        color:
            var(--ast-muted);

        font-size: 15px;

        line-height: 1.65;
    }


    .archived-students-empty-action {
        min-height: 48px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            18px;

        border-radius: 11px;

        background:
            var(--ast-navy);

        color:
            #FFFFFF;

        font-size: 15px;
        font-weight: 900;

        text-decoration: none;

        transition:
            var(--ast-transition);
    }


    .archived-students-empty-action:hover {
        transform:
            translateY(-1px);

        background:
            var(--ast-navy-dark);
    }


    /* ================================================================
       SEARCH EMPTY
       ================================================================ */

    .archived-students-filter-empty {
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
            var(--ast-muted);

        font-size: 15px;

        text-align: center;
    }


    /* ================================================================
       PAGINATION
       ================================================================ */

    .archived-students-pagination {
        margin-top: 24px;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1000px) {

        .archived-students-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .archived-students-hero-actions {
            width: 100%;
        }


        .archived-students-grid {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 800px) {

        .archived-students-summary {
            grid-template-columns:
                1fr;
        }


        .archived-students-toolbar {
            flex-direction: column;

            align-items: stretch;
        }


        .archived-students-search {
            width: 100%;
        }


        .archived-students-visible {
            text-align: right;
        }

    }


    @media (max-width: 650px) {

        .archived-students-hero {
            padding:
                29px
                22px;

            border-radius:
                22px;
        }


        .archived-students-hero h1 {
            font-size: 31px;
        }


        .archived-students-hero-description {
            font-size: 16px;
        }


        .archived-student-card-header {
            flex-wrap: wrap;
        }


        .archived-student-name-row {
            flex-direction: column;

            align-items: flex-start;
        }


        .archived-student-details,
        .archived-student-academic-grid,
        .archived-student-history-grid {
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
    | Current Page Students
    |--------------------------------------------------------------------------
    */

    $archivedStudents =
        collect(
            $students->items()
        );


    /*
    |--------------------------------------------------------------------------
    | Current Page Historical Assignments
    |--------------------------------------------------------------------------
    */

    $historicalAssignments =
        $archivedStudents
            ->flatMap(
                function ($student) {

                    return collect(
                        $student
                            ->studentProfile
                            ?->ojtAssignments
                        ?? []
                    );

                }
            );


    /*
    |--------------------------------------------------------------------------
    | Unique Companies Represented
    |--------------------------------------------------------------------------
    */

    $historicalCompanyCount =
        $historicalAssignments
            ->pluck('company_id')
            ->filter()
            ->unique()
            ->count();


    /*
    |--------------------------------------------------------------------------
    | Initials
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
                ?: 'ST';

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


<div class="archived-students-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="archived-students-hero">


        <div class="archived-students-hero-inner">


            <div class="archived-students-hero-copy">


                <div class="archived-students-eyebrow">

                    <span class="archived-students-dot"></span>

                    Administrator · Student Account Archive

                </div>


                <h1>
                    Archived Students
                </h1>


                <p class="archived-students-hero-description">

                    Review Student accounts that were safely
                    archived from normal system access.
                    Academic information and historical OJT
                    placement records remain preserved, and
                    eligible accounts may be restored when needed.

                </p>


            </div>


            <div class="archived-students-hero-actions">


                <a
                    href="{{ route(
                        'admin.students.index'
                    ) }}"
                    class="
                        archived-students-hero-button
                        hero-button-primary
                    "
                >
                    Back to Students
                </a>


                <a
                    href="{{ route(
                        'admin.students.create'
                    ) }}"
                    class="
                        archived-students-hero-button
                        hero-button-secondary
                    "
                >
                    Create New Student
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="archived-students-summary">


        <article class="archived-student-summary-card">


            <span class="archived-student-summary-label">
                Archived Accounts
            </span>


            <span class="archived-student-summary-value">
                {{ $students->total() }}
            </span>


            <span class="archived-student-summary-note">
                Student accounts currently archived
            </span>


        </article>


        <article class="archived-student-summary-card">


            <span class="archived-student-summary-label">
                Historical Placements
            </span>


            <span class="archived-student-summary-value">
                {{ $historicalAssignments->count() }}
            </span>


            <span class="archived-student-summary-note">
                OJT Assignments represented on this page
            </span>


        </article>


        <article class="archived-student-summary-card">


            <span class="archived-student-summary-label">
                Companies Represented
            </span>


            <span class="archived-student-summary-value">
                {{ $historicalCompanyCount }}
            </span>


            <span class="archived-student-summary-note">
                Historical OJT companies on this page
            </span>


        </article>


    </section>


    {{-- ==================================================================
         INFORMATION
         ================================================================== --}}

    <section class="archived-students-notice">


        <div class="archived-students-notice-icon">
            AR
        </div>


        <div>


            <strong>
                Archived accounts are preserved, not permanently deleted.
            </strong>


            <p>

                The Student's account is removed from normal
                account listings and login access is disabled,
                while Student profile information and historical
                OJT records remain available to the system.

                Restoring a Student does not immediately reactivate
                portal access. The restored account remains inactive
                until an Administrator deliberately activates it.

            </p>


        </div>


    </section>


    {{-- ==================================================================
         STUDENT RECORDS
         ================================================================== --}}

    @if ($students->count() > 0)


        {{-- ==============================================================
             SEARCH
             ============================================================== --}}

        <div class="archived-students-toolbar">


            <div class="archived-students-search">


                <span class="archived-students-search-icon">
                    FN
                </span>


                <input
                    type="search"
                    id="archived-student-search"
                    placeholder="Find an archived Student..."
                    aria-label="Find an archived Student"
                >


            </div>


            <div class="archived-students-visible">

                Showing

                <strong id="archived-student-visible-count">
                    {{ $students->count() }}
                </strong>

                on this page

            </div>


        </div>


        {{-- ==============================================================
             GRID
             ============================================================== --}}

        <div
            class="archived-students-grid"
            id="archived-students-grid"
        >


            @foreach ($students as $student)


                @php

                    /*
                    |--------------------------------------------------------------------------
                    | Profile
                    |--------------------------------------------------------------------------
                    */

                    $profile =
                        $student->studentProfile;


                    /*
                    |--------------------------------------------------------------------------
                    | Assignment History
                    |--------------------------------------------------------------------------
                    */

                    $assignments =
                        $profile
                            ? collect(
                                $profile->ojtAssignments
                                ?? []
                            )
                            : collect();


                    /*
                    |--------------------------------------------------------------------------
                    | Companies
                    |--------------------------------------------------------------------------
                    */

                    $companyCount =
                        $assignments
                            ->pluck('company_id')
                            ->filter()
                            ->unique()
                            ->count();


                    /*
                    |--------------------------------------------------------------------------
                    | Supervisors
                    |--------------------------------------------------------------------------
                    */

                    $supervisorCount =
                        $assignments
                            ->pluck('supervisor_id')
                            ->filter()
                            ->unique()
                            ->count();


                    /*
                    |--------------------------------------------------------------------------
                    | Searchable Company Names
                    |--------------------------------------------------------------------------
                    */

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


                    /*
                    |--------------------------------------------------------------------------
                    | Searchable Supervisor Names
                    |--------------------------------------------------------------------------
                    */

                    $supervisorNames =
                        $assignments
                            ->map(
                                fn ($assignment) =>
                                    $assignment
                                        ->supervisor
                                        ?->name
                            )
                            ->filter()
                            ->implode(' ');


                    /*
                    |--------------------------------------------------------------------------
                    | Search String
                    |--------------------------------------------------------------------------
                    */

                    $searchText =
                        strtolower(
                            implode(
                                ' ',
                                [
                                    $student->name,
                                    $student->email,
                                    $profile?->student_number,
                                    $profile?->program,
                                    $profile?->year_level,
                                    $profile?->section,
                                    $companyNames,
                                    $supervisorNames,
                                ]
                            )
                        );

                @endphp


                <article
                    class="archived-student-card"
                    data-archived-student
                    data-search="{{ $searchText }}"
                >


                    {{-- ==========================================================
                         HEADER
                         ========================================================== --}}

                    <div class="archived-student-card-header">


                        <div class="archived-student-avatar">

                            {{ $makeInitials(
                                $student->name
                            ) }}

                        </div>


                        <div class="archived-student-identity">


                            <div class="archived-student-name-row">


                                <div>


                                    <h2 class="archived-student-name">
                                        {{ $student->name }}
                                    </h2>


                                    <span class="archived-student-email">
                                        {{ $student->email }}
                                    </span>


                                </div>


                                <span class="archived-student-badge">
                                    Archived
                                </span>


                            </div>


                        </div>


                    </div>


                    {{-- ==========================================================
                         BODY
                         ========================================================== --}}

                    <div class="archived-student-card-body">


                        {{-- ======================================================
                             ACCOUNT INFORMATION
                             ====================================================== --}}

                        <div class="archived-student-details">


                            <div class="archived-student-detail">


                                <span class="archived-student-detail-label">
                                    Account Role
                                </span>


                                <span class="archived-student-detail-value">
                                    Student
                                </span>


                            </div>


                            <div class="archived-student-detail">


                                <span class="archived-student-detail-label">
                                    Account Status
                                </span>


                                <span class="archived-student-detail-value">

                                    {{ ucfirst(
                                        (string)
                                        $student->status
                                    ) }}

                                </span>


                            </div>


                            <div class="archived-student-detail">


                                <span class="archived-student-detail-label">
                                    Archived On
                                </span>


                                <span class="archived-student-detail-value">

                                    {{ $formatDateTime(
                                        $student->deleted_at
                                    ) }}

                                </span>


                            </div>


                            <div class="archived-student-detail">


                                <span class="archived-student-detail-label">
                                    Account ID
                                </span>


                                <span class="archived-student-detail-value">
                                    #{{ $student->id }}
                                </span>


                            </div>


                        </div>


                        {{-- ======================================================
                             ACADEMIC RECORD
                             ====================================================== --}}

                        <div class="archived-student-academic">


                            <span class="archived-student-academic-title">
                                Preserved Student Profile
                            </span>


                            <div class="archived-student-academic-grid">


                                <div class="archived-student-academic-item">

                                    <span>
                                        Student Number
                                    </span>

                                    <strong>

                                        {{ $profile
                                            ?->student_number
                                            ?? 'Not provided'
                                        }}

                                    </strong>

                                </div>


                                <div class="archived-student-academic-item">

                                    <span>
                                        Program
                                    </span>

                                    <strong>

                                        {{ $profile
                                            ?->program
                                            ?? 'Not provided'
                                        }}

                                    </strong>

                                </div>


                                <div class="archived-student-academic-item">

                                    <span>
                                        Year Level
                                    </span>

                                    <strong>

                                        {{ $profile
                                            ?->year_level
                                            ?? 'Not provided'
                                        }}

                                    </strong>

                                </div>


                                <div class="archived-student-academic-item">

                                    <span>
                                        Section
                                    </span>

                                    <strong>

                                        {{ $profile
                                            ?->section
                                            ?? 'Not provided'
                                        }}

                                    </strong>

                                </div>


                            </div>


                        </div>


                        {{-- ======================================================
                             HISTORICAL OJT
                             ====================================================== --}}

                        <div class="archived-student-history">


                            <span class="archived-student-history-title">
                                Preserved OJT History
                            </span>


                            <div class="archived-student-history-grid">


                                <div class="archived-student-history-item">

                                    <span>
                                        OJT Placements
                                    </span>

                                    <strong>
                                        {{ $assignments->count() }}
                                    </strong>

                                </div>


                                <div class="archived-student-history-item">

                                    <span>
                                        Companies
                                    </span>

                                    <strong>
                                        {{ $companyCount }}
                                    </strong>

                                </div>


                                <div class="archived-student-history-item">

                                    <span>
                                        Supervisors
                                    </span>

                                    <strong>
                                        {{ $supervisorCount }}
                                    </strong>

                                </div>


                            </div>


                        </div>


                        {{-- ======================================================
                             RESTORE
                             ====================================================== --}}

                        <div class="archived-student-restore">


                            <div class="archived-student-restore-notice">

                                Restoring this Student returns
                                the account to the normal directory,
                                but its login status will remain

                                <strong>
                                    inactive
                                </strong>

                                until an Administrator intentionally
                                reactivates it.

                            </div>


                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.students.restore',
                                    $student->id
                                ) }}"
                                data-student-restore-form
                                data-student-name="{{ $student->name }}"
                            >

                                @csrf
                                @method('PATCH')


                                <button
                                    type="submit"
                                    class="archived-student-restore-button"
                                >
                                    Restore Student Account
                                </button>


                            </form>


                        </div>


                    </div>


                </article>


            @endforeach


            {{-- ==============================================================
                 FILTER EMPTY
                 ============================================================== --}}

            <div
                class="archived-students-filter-empty"
                id="archived-students-filter-empty"
            >

                No archived Student on this page
                matches your search.

            </div>


        </div>


        {{-- ==============================================================
             PAGINATION
             ============================================================== --}}

        <div class="archived-students-pagination">

            {{ $students->links() }}

        </div>


    @else


        {{-- ==================================================================
             EMPTY ARCHIVE
             ================================================================== --}}

        <section class="archived-students-empty">


            <div class="archived-students-empty-icon">
                ✓
            </div>


            <h2>
                No Archived Students
            </h2>


            <p>

                There are currently no Student accounts in
                the archive. When an eligible Student account
                is safely archived, it will appear here together
                with its preserved profile information, historical
                OJT records, and Restore option.

            </p>


            <a
                href="{{ route(
                    'admin.students.index'
                ) }}"
                class="archived-students-empty-action"
            >
                Return to Student Management
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
            | Search Archived Students
            |--------------------------------------------------------------------------
            |
            | This filters only Students already loaded on the current
            | pagination page. It does not perform a database query.
            |
            */

            const searchInput =
                document.getElementById(
                    'archived-student-search'
                );


            const studentRecords =
                Array.from(
                    document.querySelectorAll(
                        '[data-archived-student]'
                    )
                );


            const visibleCount =
                document.getElementById(
                    'archived-student-visible-count'
                );


            const filterEmpty =
                document.getElementById(
                    'archived-students-filter-empty'
                );


            function filterStudents() {

                if (! searchInput) {
                    return;
                }


                const value =
                    searchInput
                        .value
                        .trim()
                        .toLowerCase();


                let visible =
                    0;


                studentRecords.forEach(
                    function (record) {

                        const searchable =
                            (
                                record.dataset.search
                                || ''
                            )
                                .toLowerCase();


                        const matches =
                            value === ''
                            ||
                            searchable.includes(
                                value
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
                    filterStudents
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Restore Confirmation
            |--------------------------------------------------------------------------
            */

            const restoreForms =
                document.querySelectorAll(
                    '[data-student-restore-form]'
                );


            restoreForms.forEach(
                function (form) {

                    form.addEventListener(
                        'submit',
                        function (event) {

                            const studentName =
                                form.dataset
                                    .studentName
                                ||
                                'this Student';


                            const confirmed =
                                window.confirm(
                                    'Restore '
                                    +
                                    studentName
                                    +
                                    '?\n\n'
                                    +
                                    'The Student account will return '
                                    +
                                    'to the normal Student directory, '
                                    +
                                    'but it will remain INACTIVE until '
                                    +
                                    'an Administrator deliberately '
                                    +
                                    'reactivates it.'
                                );


                            if (! confirmed) {

                                event.preventDefault();

                                return;

                            }


                            const submitButton =
                                form.querySelector(
                                    'button[type="submit"]'
                                );


                            if (submitButton) {

                                submitButton.disabled =
                                    true;


                                submitButton.textContent =
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