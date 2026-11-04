@extends('layouts.app')

@section('title', 'Reports & Export Center | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - REPORTS & EXPORT CENTER
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --report-navy: #183B6B;
        --report-navy-dark: #102A4A;
        --report-navy-deep: #0B223D;

        --report-blue: #2563EB;
        --report-blue-dark: #1D4ED8;
        --report-blue-light: #60A5FA;
        --report-blue-soft: #EAF2FF;

        --report-teal: #0F766E;
        --report-teal-dark: #0B5F59;
        --report-teal-soft: #E7F7F5;

        --report-green: #15803D;
        --report-green-soft: #EAF8EF;

        --report-orange: #B45309;
        --report-orange-soft: #FFF5E6;

        --report-red: #B42318;
        --report-red-soft: #FFF0EE;

        --report-purple: #6D4FC2;
        --report-purple-soft: #F2EEFF;

        --report-gray: #475569;
        --report-gray-soft: #F1F5F9;

        --report-text: #102A4A;
        --report-body: #405872;
        --report-muted: #64778C;

        --report-white: #FFFFFF;
        --report-soft: #F8FBFE;

        --report-border: #D8E3EE;
        --report-border-soft: #E7EDF4;

        --report-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --report-shadow-medium:
            0 18px 42px
            rgba(15, 42, 74, 0.10);

        --report-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --report-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .admin-report-page {
        width: 100%;

        color:
            var(--report-text);

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

    .report-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 28px;

        padding:
            43px
            44px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 90% 12%,
                rgba(96, 165, 250, 0.25),
                transparent 27%
            ),
            radial-gradient(
                circle at 72% 98%,
                rgba(45, 212, 191, 0.12),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #0B223D 0%,
                #102A4A 33%,
                #183B6B 67%,
                #17666B 100%
            );

        box-shadow:
            var(--report-shadow-large);
    }


    .report-hero::before {
        content: "";

        position: absolute;

        width: 400px;
        height: 400px;

        top: -240px;
        right: -150px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.06);
    }


    .report-hero::after {
        content: "";

        position: absolute;

        width: 230px;
        height: 230px;

        right: 295px;
        bottom: -170px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.04);
    }


    .report-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 40px;
    }


    .report-hero-copy {
        max-width: 790px;
    }


    .report-eyebrow {
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


    .report-eyebrow-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background:
            var(--report-blue-light);

        box-shadow:
            0 0 0 5px
            rgba(96, 165, 250, 0.13);
    }


    .report-hero h1 {
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


    .report-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .report-hero-actions {
        width: 280px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .report-hero-button {
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

        text-align: center;

        text-decoration: none;

        transition:
            var(--report-transition);
    }


    .report-hero-button-primary {
        background:
            #FFFFFF;

        color:
            var(--report-navy);
    }


    .report-hero-button-primary:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;
    }


    .report-hero-button-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .report-hero-button-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    /* ================================================================
       SUMMARY
       ================================================================ */

    .report-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 17px;

        margin-bottom: 24px;
    }


    .report-summary-card {
        padding: 21px;

        border:
            1px solid
            var(--report-border);

        border-radius: 18px;

        background:
            #FFFFFF;

        box-shadow:
            var(--report-shadow);

        transition:
            var(--report-transition);
    }


    .report-summary-card:hover {
        transform:
            translateY(-2px);

        box-shadow:
            var(--report-shadow-medium);
    }


    .report-summary-icon {
        width: 46px;
        height: 46px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 13px;

        border-radius: 13px;

        font-size: 12px;
        font-weight: 900;
    }


    .summary-blue {
        background:
            var(--report-blue-soft);

        color:
            var(--report-blue);
    }


    .summary-orange {
        background:
            var(--report-orange-soft);

        color:
            var(--report-orange);
    }


    .summary-green {
        background:
            var(--report-green-soft);

        color:
            var(--report-green);
    }


    .summary-teal {
        background:
            var(--report-teal-soft);

        color:
            var(--report-teal);
    }


    .report-summary-label {
        display: block;

        color:
            var(--report-muted);

        font-size: 14px;
        font-weight: 800;
    }


    .report-summary-value {
        display: block;

        margin-top: 3px;

        color:
            var(--report-text);

        font-size: 31px;
        font-weight: 900;

        line-height: 1.2;
    }


    .report-summary-note {
        display: block;

        margin-top: 4px;

        color:
            var(--report-muted);

        font-size: 13px;

        line-height: 1.5;
    }


    /* ================================================================
       REPORT INFORMATION
       ================================================================ */

    .report-information {
        display: flex;
        align-items: flex-start;

        gap: 14px;

        margin-bottom: 23px;

        padding:
            18px
            19px;

        border:
            1px solid
            #D4E2F0;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                #FBFDFF,
                #F3F8FD
            );
    }


    .report-information-icon {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--report-blue-soft);

        color:
            var(--report-blue);

        font-size: 12px;
        font-weight: 900;
    }


    .report-information strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--report-text);

        font-size: 16px;
        font-weight: 900;
    }


    .report-information p {
        margin: 0;

        color:
            var(--report-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       REPORT PANEL
       ================================================================ */

    .report-panel {
        overflow: hidden;

        border:
            1px solid
            var(--report-border);

        border-radius: 20px;

        background:
            #FFFFFF;

        box-shadow:
            var(--report-shadow);
    }


    .report-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding:
            21px
            22px;

        border-bottom:
            1px solid
            var(--report-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FBFDFF
            );
    }


    .report-panel-heading {
        display: flex;
        align-items: center;

        gap: 13px;
    }


    .report-panel-icon {
        width: 47px;
        height: 47px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--report-teal-soft);

        color:
            var(--report-teal);

        font-size: 12px;
        font-weight: 900;
    }


    .report-panel-header h2 {
        margin:
            0
            0
            3px;

        color:
            var(--report-text);

        font-size: 23px;
        font-weight: 900;

        line-height: 1.3;
    }


    .report-panel-header p {
        margin: 0;

        color:
            var(--report-muted);

        font-size: 14px;
    }


    /* ================================================================
       TOOLBAR
       ================================================================ */

    .report-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 17px;

        padding:
            17px
            20px;

        border-bottom:
            1px solid
            var(--report-border-soft);

        background:
            #FFFFFF;
    }


    .report-search {
        position: relative;

        width:
            min(
                100%,
                520px
            );
    }


    .report-search input {
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
            var(--report-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;

        transition:
            var(--report-transition);
    }


    .report-search input:focus {
        border-color:
            var(--report-blue);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, 0.08);
    }


    .report-search-icon {
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
            var(--report-blue-soft);

        color:
            var(--report-blue);

        font-size: 10px;
        font-weight: 900;
    }


    .report-toolbar-right {
        display: flex;
        align-items: center;

        gap: 11px;
    }


    .report-filter {
        min-height: 47px;

        padding:
            0
            13px;

        border:
            1px solid
            var(--report-border);

        border-radius: 10px;

        outline: none;

        background:
            #FFFFFF;

        color:
            var(--report-text);

        font-family: inherit;

        font-size: 14px;
        font-weight: 750;

        cursor: pointer;
    }


    .report-filter:focus {
        border-color:
            var(--report-blue);
    }


    .report-visible {
        color:
            var(--report-muted);

        font-size: 14px;
        font-weight: 750;

        white-space: nowrap;
    }


    .report-visible strong {
        color:
            var(--report-text);

        font-size: 17px;
        font-weight: 900;
    }


    /* ================================================================
       TABLE
       ================================================================ */

    .report-table-wrap {
        width: 100%;

        overflow-x: auto;
    }


    .report-table {
        width: 100%;

        min-width: 1120px;

        border-collapse: collapse;
    }


    .report-table th {
        padding:
            15px
            16px;

        border-bottom:
            1px solid
            var(--report-border);

        background:
            #F7FAFD;

        color:
            var(--report-muted);

        font-size: 12px;
        font-weight: 900;

        text-align: left;

        text-transform:
            uppercase;

        letter-spacing:
            .25px;

        white-space: nowrap;
    }


    .report-table td {
        padding:
            17px
            16px;

        border-bottom:
            1px solid
            var(--report-border-soft);

        color:
            var(--report-body);

        font-size: 15px;

        vertical-align: middle;
    }


    .report-table tbody tr {
        transition:
            var(--report-transition);
    }


    .report-table tbody tr:hover {
        background:
            #FBFDFF;
    }


    .report-table tbody tr:last-child td {
        border-bottom: none;
    }


    /* ================================================================
       STUDENT CELL
       ================================================================ */

    .report-student {
        display: flex;
        align-items: center;

        gap: 12px;

        min-width: 230px;
    }


    .report-student-avatar {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            linear-gradient(
                145deg,
                var(--report-navy),
                var(--report-blue)
            );

        color:
            #FFFFFF;

        font-size: 13px;
        font-weight: 900;
    }


    .report-student-name {
        display: block;

        color:
            var(--report-text);

        font-size: 16px;
        font-weight: 900;

        line-height: 1.4;
    }


    .report-student-number {
        display: block;

        margin-top: 2px;

        color:
            var(--report-muted);

        font-size: 13px;
    }


    /* ================================================================
       CELL VALUE
       ================================================================ */

    .report-cell-primary {
        display: block;

        color:
            var(--report-text);

        font-size: 15px;
        font-weight: 850;

        line-height: 1.5;
    }


    .report-cell-secondary {
        display: block;

        margin-top: 2px;

        color:
            var(--report-muted);

        font-size: 12px;

        line-height: 1.4;
    }


    /* ================================================================
       STATUS
       ================================================================ */

    .report-status {
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


    .report-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .status-pending {
        background:
            var(--report-orange-soft);

        color:
            var(--report-orange);
    }


    .status-pending::before {
        background:
            #F59E0B;
    }


    .status-active {
        background:
            var(--report-green-soft);

        color:
            var(--report-green);
    }


    .status-active::before {
        background:
            #22C55E;
    }


    .status-completed {
        background:
            var(--report-teal-soft);

        color:
            var(--report-teal);
    }


    .status-completed::before {
        background:
            #14B8A6;
    }


    .status-cancelled {
        background:
            var(--report-red-soft);

        color:
            var(--report-red);
    }


    .status-cancelled::before {
        background:
            #D92D20;
    }


    .status-other {
        background:
            var(--report-gray-soft);

        color:
            var(--report-gray);
    }


    .status-other::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       HOURS
       ================================================================ */

    .report-hours {
        min-width: 150px;
    }


    .report-hours-value {
        display: flex;
        justify-content: space-between;

        gap: 10px;

        margin-bottom: 7px;

        color:
            var(--report-text);

        font-size: 14px;
        font-weight: 850;
    }


    .report-hours-bar {
        overflow: hidden;

        width: 100%;
        height: 8px;

        border-radius: 999px;

        background:
            #E8EEF5;
    }


    .report-hours-progress {
        height: 100%;

        border-radius: inherit;

        background:
            linear-gradient(
                90deg,
                var(--report-blue),
                var(--report-teal)
            );
    }


    .report-hours-percent {
        display: block;

        margin-top: 5px;

        color:
            var(--report-muted);

        font-size: 12px;
        font-weight: 750;
    }


    /* ================================================================
       EVALUATION
       ================================================================ */

    .report-evaluation {
        display: inline-flex;
        align-items: center;

        gap: 7px;
    }


    .report-evaluation-score {
        min-width: 43px;

        padding:
            6px
            8px;

        border-radius: 9px;

        background:
            var(--report-teal-soft);

        color:
            var(--report-teal);

        font-size: 14px;
        font-weight: 900;

        text-align: center;
    }


    .report-evaluation-none {
        color:
            var(--report-muted);

        font-size: 13px;
        font-weight: 700;
    }


    /* ================================================================
       ACTION
       ================================================================ */

    .report-row-action {
        min-height: 41px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            12px;

        border:
            1px solid
            var(--report-border);

        border-radius: 9px;

        background:
            #FFFFFF;

        color:
            var(--report-navy);

        font-size: 13px;
        font-weight: 850;

        text-decoration: none;

        white-space: nowrap;

        transition:
            var(--report-transition);
    }


    .report-row-action:hover {
        background:
            var(--report-blue-soft);

        border-color:
            #C9DAEE;
    }


    /* ================================================================
       EMPTY
       ================================================================ */

    .report-empty {
        padding:
            55px
            30px;

        text-align: center;
    }


    .report-empty-icon {
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
            var(--report-blue-soft);

        color:
            var(--report-blue);

        font-size: 19px;
        font-weight: 900;
    }


    .report-empty h3 {
        margin:
            0
            0
            6px;

        color:
            var(--report-text);

        font-size: 23px;
        font-weight: 900;
    }


    .report-empty p {
        max-width: 590px;

        margin:
            0
            auto;

        color:
            var(--report-muted);

        font-size: 15px;

        line-height: 1.65;
    }


    /* ================================================================
       FILTER EMPTY
       ================================================================ */

    .report-filter-empty {
        display: none;

        margin: 20px;

        padding:
            30px
            20px;

        border:
            1px dashed
            #C8D6E3;

        border-radius: 14px;

        background:
            #FBFDFF;

        color:
            var(--report-muted);

        font-size: 15px;

        text-align: center;
    }


    /* ================================================================
       FOOTER
       ================================================================ */

    .report-panel-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 16px;

        padding:
            17px
            21px;

        border-top:
            1px solid
            var(--report-border-soft);

        background:
            #FCFDFE;
    }


    .report-generated {
        color:
            var(--report-muted);

        font-size: 13px;
    }


    .report-generated strong {
        color:
            var(--report-text);
    }


    .report-pagination {
        margin-top: 24px;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1050px) {

        .report-hero-inner {
            flex-direction:
                column;

            align-items:
                flex-start;
        }


        .report-hero-actions {
            width: 100%;
        }


        .report-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 800px) {

        .report-toolbar {
            flex-direction:
                column;

            align-items:
                stretch;
        }


        .report-search {
            width: 100%;
        }


        .report-toolbar-right {
            justify-content:
                space-between;
        }


        .report-panel-header {
            align-items:
                flex-start;
        }

    }


    @media (max-width: 650px) {

        .report-hero {
            padding:
                29px
                22px;

            border-radius:
                22px;
        }


        .report-hero h1 {
            font-size:
                31px;
        }


        .report-hero-description {
            font-size:
                16px;
        }


        .report-summary-grid {
            grid-template-columns:
                1fr;
        }


        .report-toolbar-right {
            flex-direction:
                column;

            align-items:
                stretch;
        }


        .report-visible {
            text-align:
                right;
        }


        .report-panel-heading {
            align-items:
                flex-start;
        }


        .report-panel-footer {
            flex-direction:
                column;

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
    | Report Source
    |--------------------------------------------------------------------------
    |
    | Supports the common Assignment/report variable names while keeping
    | this Blade page independent from pagination implementation details.
    |
    */

    $reportSource =
        $assignments
        ?? $reportAssignments
        ?? $reportRows
        ?? $rows
        ?? collect();


    $reportCollection =
        is_object($reportSource)
        && method_exists(
            $reportSource,
            'items'
        )
            ? collect(
                $reportSource->items()
            )
            : collect(
                $reportSource
            );


    /*
    |--------------------------------------------------------------------------
    | Total
    |--------------------------------------------------------------------------
    */

    $reportTotal =
        is_object($reportSource)
        && method_exists(
            $reportSource,
            'total'
        )
            ? $reportSource->total()
            : $reportCollection->count();


    /*
    |--------------------------------------------------------------------------
    | Current Page Status Counts
    |--------------------------------------------------------------------------
    */

    $pendingCount =
        $reportCollection
            ->where(
                'status',
                \App\Models\OjtAssignment::STATUS_PENDING
            )
            ->count();


    $activeCount =
        $reportCollection
            ->where(
                'status',
                \App\Models\OjtAssignment::STATUS_ACTIVE
            )
            ->count();


    $completedCount =
        $reportCollection
            ->where(
                'status',
                \App\Models\OjtAssignment::STATUS_COMPLETED
            )
            ->count();


    /*
    |--------------------------------------------------------------------------
    | Helpers
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


    $statusClass =
        function ($status) {

            return match (
                strtolower(
                    (string)
                    $status
                )
            ) {

                'pending' =>
                    'status-pending',

                'active' =>
                    'status-active',

                'completed' =>
                    'status-completed',

                'cancelled' =>
                    'status-cancelled',

                default =>
                    'status-other',

            };

        };

@endphp


<div class="admin-report-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="report-hero">


        <div class="report-hero-inner">


            <div class="report-hero-copy">


                <div class="report-eyebrow">

                    <span class="report-eyebrow-dot"></span>

                    Administrator · Reporting & Export Center

                </div>


                <h1>
                    OJT Reports & Monitoring
                </h1>


                <p class="report-hero-description">

                    Review Student OJT placements, validated rendered
                    hours, participating Companies, assigned Supervisors,
                    final evaluations, and assignment progress.

                    Generate formal printable reports or export report
                    information for administrative documentation.

                </p>


            </div>


            <div class="report-hero-actions">


                <a
                    href="{{ route(
                        'admin.reports.print',
                        request()->query()
                    ) }}"
                    class="
                        report-hero-button
                        report-hero-button-primary
                    "
                    target="_blank"
                    rel="noopener"
                >
                    Open Printable Report
                </a>


                <a
                    href="{{ route(
                        'admin.reports.export-csv',
                        request()->query()
                    ) }}"
                    class="
                        report-hero-button
                        report-hero-button-secondary
                    "
                >
                    Export Report as CSV
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="report-summary-grid">


        <article class="report-summary-card">


            <div
                class="
                    report-summary-icon
                    summary-blue
                "
            >
                RP
            </div>


            <span class="report-summary-label">
                Report Records
            </span>


            <span class="report-summary-value">
                {{ $reportTotal }}
            </span>


            <span class="report-summary-note">
                OJT placement records in this report
            </span>


        </article>


        <article class="report-summary-card">


            <div
                class="
                    report-summary-icon
                    summary-orange
                "
            >
                PN
            </div>


            <span class="report-summary-label">
                Pending
            </span>


            <span class="report-summary-value">
                {{ $pendingCount }}
            </span>


            <span class="report-summary-note">
                Pending records on this page
            </span>


        </article>


        <article class="report-summary-card">


            <div
                class="
                    report-summary-icon
                    summary-green
                "
            >
                AC
            </div>


            <span class="report-summary-label">
                Active
            </span>


            <span class="report-summary-value">
                {{ $activeCount }}
            </span>


            <span class="report-summary-note">
                Active placements on this page
            </span>


        </article>


        <article class="report-summary-card">


            <div
                class="
                    report-summary-icon
                    summary-teal
                "
            >
                CP
            </div>


            <span class="report-summary-label">
                Completed
            </span>


            <span class="report-summary-value">
                {{ $completedCount }}
            </span>


            <span class="report-summary-note">
                Completed records on this page
            </span>


        </article>


    </section>


    {{-- ==================================================================
         INFO
         ================================================================== --}}

    <section class="report-information">


        <div class="report-information-icon">
            IN
        </div>


        <div>


            <strong>
                Administrative OJT reporting uses the Assignment as its central record.
            </strong>


            <p>

                The report connects each Student with their OJT
                Company and Supervisor while summarizing required
                hours, validated attendance progress, assignment
                lifecycle, and final evaluation information.

                Use the printable view for formal documentation
                and CSV export when the data needs to be reviewed
                or processed outside the system.

            </p>


        </div>


    </section>


    {{-- ==================================================================
         REPORT
         ================================================================== --}}

    <section class="report-panel">


        <div class="report-panel-header">


            <div class="report-panel-heading">


                <div class="report-panel-icon">
                    OJ
                </div>


                <div>

                    <h2>
                        OJT Placement Report
                    </h2>

                    <p>
                        Student placement and monitoring overview
                    </p>

                </div>


            </div>


            <a
                href="{{ route(
                    'admin.assignments.index'
                ) }}"
                class="report-row-action"
            >
                Manage Assignments
            </a>


        </div>


        @if ($reportCollection->isNotEmpty())


            {{-- ==============================================================
                 TOOLBAR
                 ============================================================== --}}

            <div class="report-toolbar">


                <div class="report-search">


                    <span class="report-search-icon">
                        FN
                    </span>


                    <input
                        type="search"
                        id="report-search"
                        placeholder="Find Student, Company, Supervisor, or record..."
                        aria-label="Search report records"
                    >


                </div>


                <div class="report-toolbar-right">


                    <select
                        id="report-status-filter"
                        class="report-filter"
                        aria-label="Filter report by assignment status"
                    >

                        <option value="all">
                            All Statuses
                        </option>

                        <option value="pending">
                            Pending
                        </option>

                        <option value="active">
                            Active
                        </option>

                        <option value="completed">
                            Completed
                        </option>

                        <option value="cancelled">
                            Cancelled
                        </option>

                    </select>


                    <div class="report-visible">

                        Showing

                        <strong id="report-visible-count">
                            {{ $reportCollection->count() }}
                        </strong>

                        on this page

                    </div>


                </div>


            </div>


            {{-- ==============================================================
                 TABLE
                 ============================================================== --}}

            <div class="report-table-wrap">


                <table class="report-table">


                    <thead>

                        <tr>

                            <th>
                                Student
                            </th>

                            <th>
                                Company
                            </th>

                            <th>
                                Supervisor
                            </th>

                            <th>
                                Required Hours
                            </th>

                            <th>
                                Validated Hours
                            </th>

                            <th>
                                Placement Period
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Evaluation
                            </th>

                            <th>
                                Record
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @foreach ($reportCollection as $assignment)


                            @php

                                /*
                                |--------------------------------------------------------------------------
                                | Related Records
                                |--------------------------------------------------------------------------
                                */

                                $profile =
                                    $assignment
                                        ->studentProfile;


                                $student =
                                    $profile?->user;


                                $company =
                                    $assignment->company;


                                $supervisor =
                                    $assignment->supervisor;


                                $evaluation =
                                    $assignment
                                        ->finalEvaluation;


                                $studentName =
                                    $student?->name
                                    ?? 'Student unavailable';


                                $studentNumber =
                                    $profile
                                        ?->student_number
                                    ?? 'Not provided';


                                $companyName =
                                    $company?->name
                                    ?? 'Company unavailable';


                                $supervisorName =
                                    $supervisor?->name
                                    ?? 'Supervisor unavailable';


                                /*
                                |--------------------------------------------------------------------------
                                | Validated Attendance
                                |--------------------------------------------------------------------------
                                */

                                $validatedMinutes =
                                    $assignment
                                        ->attendanceRecords
                                        ->where(
                                            'status',
                                            'validated'
                                        )
                                        ->sum(
                                            'rendered_minutes'
                                        );


                                $validatedHours =
                                    $validatedMinutes / 60;


                                $requiredHours =
                                    (float)
                                    (
                                        $assignment
                                            ->required_hours
                                        ?? 0
                                    );


                                $progressPercent =
                                    $requiredHours > 0
                                        ? min(
                                            100,
                                            round(
                                                (
                                                    $validatedHours
                                                    /
                                                    $requiredHours
                                                )
                                                *
                                                100
                                            )
                                        )
                                        : 0;


                                /*
                                |--------------------------------------------------------------------------
                                | Search Text
                                |--------------------------------------------------------------------------
                                */

                                $searchText =
                                    strtolower(
                                        implode(
                                            ' ',
                                            [
                                                $assignment->id,
                                                $studentName,
                                                $studentNumber,
                                                $profile?->program,
                                                $companyName,
                                                $supervisorName,
                                                $assignment->status,
                                            ]
                                        )
                                    );


                                $assignmentStatus =
                                    strtolower(
                                        trim(
                                            (string)
                                            $assignment->status
                                        )
                                    );

                            @endphp


                            <tr
                                data-report-row
                                data-status="{{ $assignmentStatus }}"
                                data-search="{{ $searchText }}"
                            >


                                {{-- ==========================================
                                     STUDENT
                                     ========================================== --}}

                                <td>


                                    <div class="report-student">


                                        <div class="report-student-avatar">

                                            {{ $makeInitials(
                                                $studentName
                                            ) }}

                                        </div>


                                        <div>


                                            <span class="report-student-name">
                                                {{ $studentName }}
                                            </span>


                                            <span class="report-student-number">

                                                {{ $studentNumber }}

                                                @if (
                                                    filled(
                                                        $profile?->program
                                                    )
                                                )

                                                    ·
                                                    {{ $profile->program }}

                                                @endif

                                            </span>


                                        </div>


                                    </div>


                                </td>


                                {{-- ==========================================
                                     COMPANY
                                     ========================================== --}}

                                <td>


                                    <span class="report-cell-primary">
                                        {{ $companyName }}
                                    </span>


                                    <span class="report-cell-secondary">

                                        {{ filled(
                                            $company?->address
                                        )
                                            ? $company->address
                                            : 'Address unavailable'
                                        }}

                                    </span>


                                </td>


                                {{-- ==========================================
                                     SUPERVISOR
                                     ========================================== --}}

                                <td>


                                    <span class="report-cell-primary">
                                        {{ $supervisorName }}
                                    </span>


                                    <span class="report-cell-secondary">

                                        {{ $supervisor?->email
                                            ?? 'Email unavailable'
                                        }}

                                    </span>


                                </td>


                                {{-- ==========================================
                                     REQUIRED
                                     ========================================== --}}

                                <td>


                                    <span class="report-cell-primary">

                                        {{ number_format(
                                            $requiredHours,
                                            0
                                        ) }}

                                        hours

                                    </span>


                                    <span class="report-cell-secondary">
                                        Placement requirement
                                    </span>


                                </td>


                                {{-- ==========================================
                                     VALIDATED HOURS
                                     ========================================== --}}

                                <td>


                                    <div class="report-hours">


                                        <div class="report-hours-value">

                                            <span>

                                                {{ number_format(
                                                    $validatedHours,
                                                    2
                                                ) }}

                                                hrs

                                            </span>


                                            <span>
                                                {{ $progressPercent }}%
                                            </span>


                                        </div>


                                        <div class="report-hours-bar">

                                            <div
                                                class="report-hours-progress"
                                                style="
                                                    width:
                                                    {{ $progressPercent }}%;
                                                "
                                            ></div>

                                        </div>


                                        <span class="report-hours-percent">
                                            Validated attendance progress
                                        </span>


                                    </div>


                                </td>


                                {{-- ==========================================
                                     PERIOD
                                     ========================================== --}}

                                <td>


                                    <span class="report-cell-primary">

                                        {{ $formatDate(
                                            $assignment->start_date
                                        ) }}

                                    </span>


                                    <span class="report-cell-secondary">

                                        to

                                        {{ $formatDate(
                                            $assignment->end_date
                                        ) }}

                                    </span>


                                </td>


                                {{-- ==========================================
                                     STATUS
                                     ========================================== --}}

                                <td>


                                    <span
                                        class="
                                            report-status
                                            {{ $statusClass(
                                                $assignment->status
                                            ) }}
                                        "
                                    >

                                        {{ ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                (string)
                                                $assignment->status
                                            )
                                        ) }}

                                    </span>


                                </td>


                                {{-- ==========================================
                                     EVALUATION
                                     ========================================== --}}

                                <td>


                                    @if ($evaluation)


                                        <div class="report-evaluation">


                                            <span class="report-evaluation-score">

                                                {{ number_format(
                                                    $evaluation
                                                        ->overallRating(),
                                                    2
                                                ) }}

                                            </span>


                                            <div>

                                                <span class="report-cell-primary">

                                                    {{ $evaluation
                                                        ->ratingLabel()
                                                    }}

                                                </span>


                                                <span class="report-cell-secondary">

                                                    {{ $evaluation
                                                        ->recommendationLabel()
                                                    }}

                                                </span>

                                            </div>


                                        </div>


                                    @else


                                        <span class="report-evaluation-none">
                                            Not evaluated
                                        </span>


                                    @endif


                                </td>


                                {{-- ==========================================
                                     ACTION
                                     ========================================== --}}

                                <td>


                                    @if (
                                        Route::has(
                                            'admin.assignments.show'
                                        )
                                    )


                                        <a
                                            href="{{ route(
                                                'admin.assignments.show',
                                                $assignment
                                            ) }}"
                                            class="report-row-action"
                                        >
                                            View Record
                                        </a>


                                    @else


                                        <span class="report-cell-secondary">
                                            #{{ $assignment->id }}
                                        </span>


                                    @endif


                                </td>


                            </tr>


                        @endforeach


                    </tbody>


                </table>


            </div>


            <div
                class="report-filter-empty"
                id="report-filter-empty"
            >

                No report record on this page matches
                your current search or status filter.

            </div>


            {{-- ==============================================================
                 FOOTER
                 ============================================================== --}}

            <div class="report-panel-footer">


                <div class="report-generated">

                    Report generated:

                    <strong>

                        {{ now()
                            ->timezone(
                                'Asia/Manila'
                            )
                            ->format(
                                'M d, Y · h:i A'
                            )
                        }}

                    </strong>

                </div>


                <div class="report-generated">

                    Current page records:

                    <strong>
                        {{ $reportCollection->count() }}
                    </strong>

                </div>


            </div>


        @else


            {{-- ==============================================================
                 EMPTY
                 ============================================================== --}}

            <div class="report-empty">


                <div class="report-empty-icon">
                    RP
                </div>


                <h3>
                    No OJT Report Records
                </h3>


                <p>

                    There are currently no OJT Assignment records
                    available for this report.

                    Once Student placements are created and monitoring
                    begins, their Company, Supervisor, rendered hours,
                    placement status, and evaluation information can
                    appear in the reporting center.

                </p>


            </div>


        @endif


    </section>


    {{-- ==================================================================
         PAGINATION
         ================================================================== --}}

    @if (
        is_object(
            $reportSource
        )
        &&
        method_exists(
            $reportSource,
            'links'
        )
    )


        <div class="report-pagination">

            {{ $reportSource->links() }}

        </div>


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
            | Current Page Search + Status Filter
            |--------------------------------------------------------------------------
            |
            | This only changes which records are visible on the current
            | page. It does not modify the database or report contents.
            |
            */

            const searchInput =
                document.getElementById(
                    'report-search'
                );


            const statusFilter =
                document.getElementById(
                    'report-status-filter'
                );


            const reportRows =
                Array.from(
                    document.querySelectorAll(
                        '[data-report-row]'
                    )
                );


            const visibleCount =
                document.getElementById(
                    'report-visible-count'
                );


            const filterEmpty =
                document.getElementById(
                    'report-filter-empty'
                );


            function applyReportFilters() {

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


                reportRows.forEach(
                    function (row) {

                        const searchable =
                            (
                                row.dataset.search
                                || ''
                            )
                                .toLowerCase();


                        const status =
                            (
                                row.dataset.status
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
                            status === selectedStatus;


                        const shouldShow =
                            matchesSearch
                            &&
                            matchesStatus;


                        row.style.display =
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
                    applyReportFilters
                );

            }


            if (statusFilter) {

                statusFilter.addEventListener(
                    'change',
                    applyReportFilters
                );

            }

        }
    );

</script>

@endpush