@extends('layouts.app')

@section('title', 'Supervisor Record | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - SUPERVISOR RECORD
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --svr-navy: #183B6B;
        --svr-navy-dark: #102A4A;
        --svr-navy-deep: #0B223D;

        --svr-teal: #0F766E;
        --svr-teal-dark: #0B5F59;
        --svr-teal-light: #2DD4BF;
        --svr-teal-soft: #E7F7F5;

        --svr-blue: #2563EB;
        --svr-blue-soft: #EAF2FF;

        --svr-green: #15803D;
        --svr-green-soft: #EAF8EF;

        --svr-orange: #B45309;
        --svr-orange-soft: #FFF5E6;

        --svr-red: #B42318;
        --svr-red-soft: #FFF0EE;

        --svr-purple: #6D4FC2;
        --svr-purple-soft: #F2EEFF;

        --svr-gray: #475569;
        --svr-gray-soft: #F1F5F9;

        --svr-text: #102A4A;
        --svr-body: #405872;
        --svr-muted: #64778C;

        --svr-white: #FFFFFF;
        --svr-soft: #F8FBFE;

        --svr-border: #D8E3EE;
        --svr-border-soft: #E7EDF4;

        --svr-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --svr-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --svr-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .supervisor-record-page {
        width: 100%;

        color:
            var(--svr-text);

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

    .supervisor-record-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 30px;

        padding:
            42px
            44px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 89% 13%,
                rgba(45, 212, 191, 0.25),
                transparent 26%
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
            var(--svr-shadow-large);
    }


    .supervisor-record-hero::before {
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


    .supervisor-record-hero::after {
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


    .supervisor-record-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .supervisor-record-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 22px;
    }


    .supervisor-record-avatar {
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
            rgba(255, 255, 255, 0.12);

        color:
            #FFFFFF;

        font-size: 27px;
        font-weight: 900;
    }


    .supervisor-record-eyebrow {
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
            rgba(255, 255, 255, 0.90);

        font-size: 14px;
        font-weight: 800;
    }


    .supervisor-record-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background:
            var(--svr-teal-light);

        box-shadow:
            0 0 0 5px
            rgba(45, 212, 191, 0.12);
    }


    .supervisor-record-hero h1 {
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


    .supervisor-record-email {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.79);

        font-size: 16px;

        word-break: break-word;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .supervisor-record-hero-actions {
        width: 285px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .supervisor-record-hero-button {
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

        transition:
            var(--svr-transition);
    }


    .hero-button-primary {
        background:
            #FFFFFF;

        color:
            var(--svr-navy);
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

    .supervisor-record-summary {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 18px;

        margin-bottom: 28px;
    }


    .supervisor-summary-card {
        padding: 22px;

        border:
            1px solid
            var(--svr-border);

        border-radius: 19px;

        background:
            #FFFFFF;

        box-shadow:
            var(--svr-shadow);

        transition:
            var(--svr-transition);
    }


    .supervisor-summary-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            0 18px 38px
            rgba(15, 42, 74, 0.10);
    }


    .supervisor-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--svr-muted);

        font-size: 14px;
        font-weight: 750;
    }


    .supervisor-summary-value {
        display: block;

        color:
            var(--svr-text);

        font-size: 28px;
        font-weight: 900;

        line-height: 1.2;
    }


    .supervisor-summary-note {
        display: block;

        margin-top: 6px;

        color:
            var(--svr-muted);

        font-size: 14px;

        line-height: 1.5;
    }


    /* ================================================================
       ACCOUNT STATUS
       ================================================================ */

    .supervisor-account-status {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding:
            8px
            12px;

        border-radius: 999px;

        font-size: 14px;
        font-weight: 850;
    }


    .supervisor-account-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .account-active {
        background:
            var(--svr-green-soft);

        color:
            var(--svr-green);
    }


    .account-active::before {
        background:
            #22C55E;
    }


    .account-inactive {
        background:
            var(--svr-orange-soft);

        color:
            var(--svr-orange);
    }


    .account-inactive::before {
        background:
            #F59E0B;
    }


    /* ================================================================
       MAIN LAYOUT
       ================================================================ */

    .supervisor-record-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            350px;

        gap: 24px;

        align-items: start;
    }


    .supervisor-record-main,
    .supervisor-record-sidebar {
        display: grid;

        gap: 22px;
    }


    /* ================================================================
       PANELS
       ================================================================ */

    .supervisor-record-panel {
        overflow: hidden;

        border:
            1px solid
            var(--svr-border);

        border-radius: 19px;

        background:
            #FFFFFF;

        box-shadow:
            var(--svr-shadow);
    }


    .supervisor-record-panel-header {
        display: flex;
        align-items: center;

        gap: 13px;

        padding:
            21px
            22px;

        border-bottom:
            1px solid
            var(--svr-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .supervisor-record-panel-icon {
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


    .panel-teal {
        background:
            var(--svr-teal-soft);

        color:
            var(--svr-teal);
    }


    .panel-blue {
        background:
            var(--svr-blue-soft);

        color:
            var(--svr-blue);
    }


    .panel-purple {
        background:
            var(--svr-purple-soft);

        color:
            var(--svr-purple);
    }


    .panel-orange {
        background:
            var(--svr-orange-soft);

        color:
            var(--svr-orange);
    }


    .supervisor-record-panel-header h2 {
        margin:
            0
            0
            3px;

        font-size: 22px;
        font-weight: 900;

        line-height: 1.3;
    }


    .supervisor-record-panel-header p {
        margin: 0;

        color:
            var(--svr-muted);

        font-size: 14px;
    }


    .supervisor-record-panel-body {
        padding: 22px;
    }


    /* ================================================================
       RESPONSIBILITY OVERVIEW
       ================================================================ */

    .supervisor-responsibility-grid {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 13px;
    }


    .supervisor-responsibility-item {
        min-height: 105px;

        padding:
            15px;

        border:
            1px solid
            var(--svr-border-soft);

        border-radius: 12px;

        background:
            var(--svr-soft);
    }


    .supervisor-responsibility-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--svr-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: .2px;
    }


    .supervisor-responsibility-value {
        display: block;

        color:
            var(--svr-text);

        font-size: 18px;
        font-weight: 900;

        line-height: 1.4;
    }


    .supervisor-responsibility-helper {
        display: block;

        margin-top: 4px;

        color:
            var(--svr-muted);

        font-size: 13px;

        line-height: 1.5;
    }


    /* ================================================================
       ASSIGNMENTS
       ================================================================ */

    .supervisor-assignment-list {
        display: grid;

        gap: 15px;
    }


    .supervisor-assignment-card {
        overflow: hidden;

        border:
            1px solid
            var(--svr-border);

        border-radius: 15px;

        background:
            #FBFDFF;
    }


    .supervisor-assignment-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 18px;

        padding:
            17px
            18px;

        border-bottom:
            1px solid
            var(--svr-border-soft);

        background:
            #FFFFFF;
    }


    .supervisor-assignment-student {
        display: block;

        margin-bottom: 3px;

        color:
            var(--svr-text);

        font-size: 18px;
        font-weight: 900;
    }


    .supervisor-assignment-company {
        display: block;

        color:
            var(--svr-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .supervisor-assignment-status {
        display: inline-flex;

        padding:
            7px
            11px;

        border-radius: 999px;

        font-size: 13px;
        font-weight: 850;

        white-space: nowrap;
    }


    .assignment-active {
        background:
            var(--svr-green-soft);

        color:
            var(--svr-green);
    }


    .assignment-pending {
        background:
            var(--svr-orange-soft);

        color:
            var(--svr-orange);
    }


    .assignment-completed {
        background:
            var(--svr-blue-soft);

        color:
            var(--svr-blue);
    }


    .assignment-cancelled {
        background:
            var(--svr-red-soft);

        color:
            var(--svr-red);
    }


    .assignment-default {
        background:
            var(--svr-gray-soft);

        color:
            var(--svr-gray);
    }


    .supervisor-assignment-body {
        padding:
            17px
            18px;
    }


    .supervisor-assignment-details {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 11px;
    }


    .supervisor-assignment-detail {
        padding:
            12px;

        border:
            1px solid
            var(--svr-border-soft);

        border-radius: 10px;

        background:
            #FFFFFF;
    }


    .supervisor-assignment-detail-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--svr-muted);

        font-size: 12px;
        font-weight: 800;

        text-transform: uppercase;
    }


    .supervisor-assignment-detail-value {
        display: block;

        color:
            var(--svr-text);

        font-size: 15px;
        font-weight: 850;

        line-height: 1.45;
    }


    .supervisor-assignment-notes {
        margin-top: 12px;

        padding:
            13px
            14px;

        border:
            1px solid
            var(--svr-border-soft);

        border-radius: 10px;

        background:
            #FFFFFF;

        color:
            var(--svr-body);

        font-size: 15px;

        line-height: 1.65;
    }


    .supervisor-assignment-actions {
        display: flex;
        flex-wrap: wrap;

        gap: 8px;

        margin-top: 13px;
    }


    /* ================================================================
       BUTTON
       ================================================================ */

    .supervisor-record-button {
        min-height: 44px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            14px;

        border:
            1px solid
            var(--svr-border);

        border-radius: 10px;

        background:
            #FFFFFF;

        color:
            var(--svr-navy);

        font-size: 14px;
        font-weight: 850;

        text-decoration: none;

        transition:
            var(--svr-transition);
    }


    .supervisor-record-button:hover {
        transform:
            translateY(-1px);

        background:
            var(--svr-teal-soft);
    }


    .supervisor-record-button-primary {
        border-color:
            var(--svr-teal);

        background:
            var(--svr-teal);

        color:
            #FFFFFF;
    }


    .supervisor-record-button-primary:hover {
        background:
            var(--svr-teal-dark);

        color:
            #FFFFFF;
    }


    /* ================================================================
       SIDEBAR
       ================================================================ */

    .supervisor-sidebar-list {
        display: grid;

        gap: 12px;
    }


    .supervisor-sidebar-item {
        padding:
            14px;

        border:
            1px solid
            var(--svr-border-soft);

        border-radius: 11px;

        background:
            var(--svr-soft);
    }


    .supervisor-sidebar-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--svr-muted);

        font-size: 13px;
        font-weight: 800;

        text-transform: uppercase;
    }


    .supervisor-sidebar-value {
        display: block;

        color:
            var(--svr-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.5;

        word-break: break-word;
    }


    /* ================================================================
       CURRENT WORKLOAD
       ================================================================ */

    .supervisor-workload-card {
        padding:
            16px;

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


    .supervisor-workload-title {
        display: block;

        margin-bottom: 5px;

        color:
            var(--svr-teal);

        font-size: 17px;
        font-weight: 900;
    }


    .supervisor-workload-card p {
        margin: 0;

        color:
            var(--svr-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       ARCHIVE
       ================================================================ */

    .supervisor-archive-panel {
        border-color:
            #E4B5AF;
    }


    .supervisor-archive-body {
        padding:
            21px;
    }


    .supervisor-archive-title {
        display: block;

        margin-bottom: 6px;

        color:
            var(--svr-red);

        font-size: 18px;
        font-weight: 900;
    }


    .supervisor-archive-description {
        margin:
            0
            0
            15px;

        color:
            var(--svr-body);

        font-size: 15px;

        line-height: 1.65;
    }


    .supervisor-archive-warning {
        margin-bottom: 15px;

        padding:
            13px
            14px;

        border:
            1px solid
            #ECD6B4;

        border-radius: 10px;

        background:
            var(--svr-orange-soft);

        color:
            #7A4B0D;

        font-size: 14px;

        line-height: 1.6;
    }


    .supervisor-archive-safe {
        margin-bottom: 15px;

        padding:
            13px
            14px;

        border:
            1px solid
            #CAE2D1;

        border-radius: 10px;

        background:
            var(--svr-green-soft);

        color:
            #11632F;

        font-size: 14px;

        line-height: 1.6;
    }


    .supervisor-archive-button {
        width: 100%;

        min-height: 49px;

        border:
            1px solid
            var(--svr-red);

        border-radius: 11px;

        background:
            #FFFFFF;

        color:
            var(--svr-red);

        font-family: inherit;

        font-size: 15px;
        font-weight: 900;

        cursor: pointer;

        transition:
            var(--svr-transition);
    }


    .supervisor-archive-button:hover {
        background:
            var(--svr-red-soft);
    }


    .supervisor-archive-button:disabled {
        border-color:
            #D9E1E8;

        background:
            #F8FAFC;

        color:
            #94A3B8;

        cursor: not-allowed;
    }


    /* ================================================================
       EMPTY
       ================================================================ */

    .supervisor-assignment-empty {
        padding:
            34px
            20px;

        border:
            1px dashed
            #C9D6E3;

        border-radius: 14px;

        background:
            #FBFDFF;

        text-align: center;
    }


    .supervisor-assignment-empty strong {
        display: block;

        margin-bottom: 5px;

        font-size: 18px;
        font-weight: 900;
    }


    .supervisor-assignment-empty span {
        color:
            var(--svr-muted);

        font-size: 15px;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1180px) {

        .supervisor-record-layout {
            grid-template-columns:
                1fr;
        }


        .supervisor-record-sidebar {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .supervisor-assignment-details {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 950px) {

        .supervisor-record-summary {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .supervisor-responsibility-grid {
            grid-template-columns:
                1fr;
        }


        .supervisor-record-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .supervisor-record-hero-actions {
            width: 100%;
        }

    }


    @media (max-width: 700px) {

        .supervisor-record-hero {
            padding:
                30px
                22px;

            border-radius: 22px;
        }


        .supervisor-record-identity {
            align-items: flex-start;
        }


        .supervisor-record-avatar {
            width: 68px;
            height: 68px;

            border-radius: 19px;

            font-size: 21px;
        }


        .supervisor-record-hero h1 {
            font-size: 30px;
        }


        .supervisor-record-summary,
        .supervisor-record-sidebar,
        .supervisor-assignment-details {
            grid-template-columns: 1fr;
        }


        .supervisor-assignment-header {
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
    | Assignments
    |--------------------------------------------------------------------------
    */

    $assignments =
        collect(
            $supervisor->supervisedAssignments
            ?? []
        )
            ->sortByDesc(
                fn ($assignment) =>
                    $assignment->start_date
                    ?? $assignment->created_at
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Open Assignments
    |--------------------------------------------------------------------------
    */

    $openAssignments =
        $assignments
            ->filter(
                fn ($assignment) =>
                    in_array(
                        strtolower(
                            (string)
                            $assignment->status
                        ),
                        \App\Models\OjtAssignment::OPEN_STATUSES,
                        true
                    )
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Completed Assignments
    |--------------------------------------------------------------------------
    */

    $completedAssignments =
        $assignments
            ->filter(
                fn ($assignment) =>
                    strtolower(
                        (string)
                        $assignment->status
                    )
                    ===
                    \App\Models\OjtAssignment::STATUS_COMPLETED
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Current Students
    |--------------------------------------------------------------------------
    */

    $currentStudentCount =
        $openAssignments
            ->pluck('student_profile_id')
            ->filter()
            ->unique()
            ->count();


    /*
    |--------------------------------------------------------------------------
    | Historical Students
    |--------------------------------------------------------------------------
    */

    $historicalStudentCount =
        $assignments
            ->pluck('student_profile_id')
            ->filter()
            ->unique()
            ->count();


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
    | Initials
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


    /*
    |--------------------------------------------------------------------------
    | Status Styling
    |--------------------------------------------------------------------------
    */

    $assignmentStatusClass =
        function ($status) {

            return match (
                strtolower(
                    (string)
                    $status
                )
            ) {

                'active' =>
                    'assignment-active',

                'pending' =>
                    'assignment-pending',

                'completed' =>
                    'assignment-completed',

                'cancelled' =>
                    'assignment-cancelled',

                default =>
                    'assignment-default',

            };

        };

@endphp


<div class="supervisor-record-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="supervisor-record-hero">


        <div class="supervisor-record-hero-inner">


            <div class="supervisor-record-identity">


                <div class="supervisor-record-avatar">
                    {{ $initials }}
                </div>


                <div>


                    <div class="supervisor-record-eyebrow">

                        <span class="supervisor-record-dot"></span>

                        Administrator · Supervisor Record

                    </div>


                    <h1>
                        {{ $supervisor->name }}
                    </h1>


                    <p class="supervisor-record-email">
                        {{ $supervisor->email }}
                    </p>


                </div>


            </div>


            <div class="supervisor-record-hero-actions">


                <a
                    href="{{ route(
                        'admin.supervisors.edit',
                        $supervisor
                    ) }}"
                    class="
                        supervisor-record-hero-button
                        hero-button-primary
                    "
                >
                    Edit Supervisor Account
                </a>


                <a
                    href="{{ route(
                        'admin.supervisors.index'
                    ) }}"
                    class="
                        supervisor-record-hero-button
                        hero-button-secondary
                    "
                >
                    Back to Supervisors
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="supervisor-record-summary">


        <article class="supervisor-summary-card">


            <span class="supervisor-summary-label">
                Account Status
            </span>


            @if ($supervisor->isActive())


                <span
                    class="
                        supervisor-account-status
                        account-active
                    "
                >
                    Active
                </span>


            @else


                <span
                    class="
                        supervisor-account-status
                        account-inactive
                    "
                >
                    Inactive
                </span>


            @endif


            <span class="supervisor-summary-note">

                {{ $supervisor->isActive()
                    ? 'OJT Portal access enabled'
                    : 'OJT Portal access disabled'
                }}

            </span>


        </article>


        <article class="supervisor-summary-card">


            <span class="supervisor-summary-label">
                Current Students
            </span>


            <span class="supervisor-summary-value">
                {{ $currentStudentCount }}
            </span>


            <span class="supervisor-summary-note">
                Students in pending or active placements
            </span>


        </article>


        <article class="supervisor-summary-card">


            <span class="supervisor-summary-label">
                OJT Assignments
            </span>


            <span class="supervisor-summary-value">
                {{ $assignments->count() }}
            </span>


            <span class="supervisor-summary-note">

                {{ $openAssignments->count() }}
                open ·

                {{ $completedAssignments->count() }}
                completed

            </span>


        </article>


        <article class="supervisor-summary-card">


            <span class="supervisor-summary-label">
                Companies Supervised
            </span>


            <span class="supervisor-summary-value">
                {{ $companyCount }}
            </span>


            <span class="supervisor-summary-note">
                Historical OJT company relationships
            </span>


        </article>


    </section>


    {{-- ==================================================================
         MAIN
         ================================================================== --}}

    <div class="supervisor-record-layout">


        <main class="supervisor-record-main">


            {{-- ==============================================================
                 SUPERVISION OVERVIEW
                 ============================================================== --}}

            <section class="supervisor-record-panel">


                <div class="supervisor-record-panel-header">


                    <div
                        class="
                            supervisor-record-panel-icon
                            panel-teal
                        "
                    >
                        OV
                    </div>


                    <div>

                        <h2>
                            Supervision Overview
                        </h2>

                        <p>
                            Current and historical OJT responsibilities
                        </p>

                    </div>


                </div>


                <div class="supervisor-record-panel-body">


                    <div class="supervisor-responsibility-grid">


                        <div class="supervisor-responsibility-item">


                            <span class="supervisor-responsibility-label">
                                Current Students
                            </span>


                            <span class="supervisor-responsibility-value">
                                {{ $currentStudentCount }}
                            </span>


                            <span class="supervisor-responsibility-helper">
                                Pending or active placements
                            </span>


                        </div>


                        <div class="supervisor-responsibility-item">


                            <span class="supervisor-responsibility-label">
                                Historical Students
                            </span>


                            <span class="supervisor-responsibility-value">
                                {{ $historicalStudentCount }}
                            </span>


                            <span class="supervisor-responsibility-helper">
                                Unique Students supervised
                            </span>


                        </div>


                        <div class="supervisor-responsibility-item">


                            <span class="supervisor-responsibility-label">
                                Completed Assignments
                            </span>


                            <span class="supervisor-responsibility-value">
                                {{ $completedAssignments->count() }}
                            </span>


                            <span class="supervisor-responsibility-helper">
                                Finished OJT placement records
                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==============================================================
                 ASSIGNMENT HISTORY
                 ============================================================== --}}

            <section class="supervisor-record-panel">


                <div class="supervisor-record-panel-header">


                    <div
                        class="
                            supervisor-record-panel-icon
                            panel-purple
                        "
                    >
                        OJ
                    </div>


                    <div>

                        <h2>
                            Supervised OJT Assignments
                        </h2>

                        <p>
                            Current and historical Student placements
                        </p>

                    </div>


                </div>


                <div class="supervisor-record-panel-body">


                    @if ($assignments->isNotEmpty())


                        <div class="supervisor-assignment-list">


                            @foreach ($assignments as $assignment)


                                @php

                                    $studentName =
                                        $assignment
                                            ->studentProfile
                                            ?->user
                                            ?->name
                                        ?? 'Student unavailable';


                                    $studentNumber =
                                        $assignment
                                            ->studentProfile
                                            ?->student_number
                                        ?? 'Not provided';


                                    $program =
                                        $assignment
                                            ->studentProfile
                                            ?->program
                                        ?? 'Program unavailable';

                                @endphp


                                <article class="supervisor-assignment-card">


                                    <div class="supervisor-assignment-header">


                                        <div>


                                            <span class="supervisor-assignment-student">
                                                {{ $studentName }}
                                            </span>


                                            <span class="supervisor-assignment-company">

                                                {{ $assignment
                                                    ->company
                                                    ?->name
                                                    ?? 'Company unavailable'
                                                }}

                                                · Student No.

                                                {{ $studentNumber }}

                                                · {{ $program }}

                                            </span>


                                        </div>


                                        <span
                                            class="
                                                supervisor-assignment-status
                                                {{ $assignmentStatusClass(
                                                    $assignment->status
                                                ) }}
                                            "
                                        >

                                            {{ ucwords(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $assignment->status
                                                )
                                            ) }}

                                        </span>


                                    </div>


                                    <div class="supervisor-assignment-body">


                                        <div class="supervisor-assignment-details">


                                            <div class="supervisor-assignment-detail">


                                                <span class="supervisor-assignment-detail-label">
                                                    Required Hours
                                                </span>


                                                <span class="supervisor-assignment-detail-value">

                                                    {{ number_format(
                                                        (float)
                                                        (
                                                            $assignment
                                                                ->required_hours
                                                            ?? 0
                                                        ),
                                                        0
                                                    ) }}

                                                    hours

                                                </span>


                                            </div>


                                            <div class="supervisor-assignment-detail">


                                                <span class="supervisor-assignment-detail-label">
                                                    Start Date
                                                </span>


                                                <span class="supervisor-assignment-detail-value">

                                                    {{ $formatDate(
                                                        $assignment
                                                            ->start_date
                                                    ) }}

                                                </span>


                                            </div>


                                            <div class="supervisor-assignment-detail">


                                                <span class="supervisor-assignment-detail-label">
                                                    End Date
                                                </span>


                                                <span class="supervisor-assignment-detail-value">

                                                    {{ $formatDate(
                                                        $assignment
                                                            ->end_date
                                                    ) }}

                                                </span>


                                            </div>


                                            <div class="supervisor-assignment-detail">


                                                <span class="supervisor-assignment-detail-label">
                                                    Assignment ID
                                                </span>


                                                <span class="supervisor-assignment-detail-value">
                                                    #{{ $assignment->id }}
                                                </span>


                                            </div>


                                        </div>


                                        @if (filled($assignment->notes))


                                            <div class="supervisor-assignment-notes">

                                                <strong>
                                                    Placement Notes:
                                                </strong>

                                                {{ $assignment->notes }}

                                            </div>


                                        @endif


                                        <div class="supervisor-assignment-actions">


                                            <a
                                                href="{{ route(
                                                    'admin.assignments.show',
                                                    $assignment
                                                ) }}"
                                                class="
                                                    supervisor-record-button
                                                    supervisor-record-button-primary
                                                "
                                            >
                                                View Assignment
                                            </a>


                                            @if (
                                                $assignment
                                                    ->studentProfile
                                                    ?->user
                                            )


                                                <a
                                                    href="{{ route(
                                                        'admin.students.show',
                                                        $assignment
                                                            ->studentProfile
                                                            ->user
                                                    ) }}"
                                                    class="supervisor-record-button"
                                                >
                                                    View Student
                                                </a>


                                            @endif


                                        </div>


                                    </div>


                                </article>


                            @endforeach


                        </div>


                    @else


                        <div class="supervisor-assignment-empty">


                            <strong>
                                No OJT Assignments
                            </strong>


                            <span>

                                This Supervisor does not yet have
                                a current or historical OJT assignment.

                            </span>


                        </div>


                    @endif


                </div>


            </section>


        </main>


        {{-- ==================================================================
             SIDEBAR
             ================================================================== --}}

        <aside class="supervisor-record-sidebar">


            {{-- ==============================================================
                 ACCOUNT RECORD
                 ============================================================== --}}

            <section class="supervisor-record-panel">


                <div class="supervisor-record-panel-header">


                    <div
                        class="
                            supervisor-record-panel-icon
                            panel-blue
                        "
                    >
                        AC
                    </div>


                    <div>

                        <h2>
                            Account Record
                        </h2>

                        <p>
                            System account information
                        </p>

                    </div>


                </div>


                <div class="supervisor-record-panel-body">


                    <div class="supervisor-sidebar-list">


                        <div class="supervisor-sidebar-item">

                            <span class="supervisor-sidebar-label">
                                Account Role
                            </span>

                            <span class="supervisor-sidebar-value">
                                Supervisor
                            </span>

                        </div>


                        <div class="supervisor-sidebar-item">

                            <span class="supervisor-sidebar-label">
                                Account Status
                            </span>

                            <span class="supervisor-sidebar-value">
                                {{ ucfirst($supervisor->status) }}
                            </span>

                        </div>


                        <div class="supervisor-sidebar-item">

                            <span class="supervisor-sidebar-label">
                                Email Address
                            </span>

                            <span class="supervisor-sidebar-value">
                                {{ $supervisor->email }}
                            </span>

                        </div>


                        <div class="supervisor-sidebar-item">

                            <span class="supervisor-sidebar-label">
                                Account Created
                            </span>

                            <span class="supervisor-sidebar-value">

                                {{ $formatDate(
                                    $supervisor->created_at
                                ) }}

                            </span>

                        </div>


                        <div class="supervisor-sidebar-item">

                            <span class="supervisor-sidebar-label">
                                Last Updated
                            </span>

                            <span class="supervisor-sidebar-value">

                                {{ $formatDate(
                                    $supervisor->updated_at
                                ) }}

                            </span>

                        </div>


                    </div>


                </div>


            </section>


            {{-- ==============================================================
                 CURRENT WORKLOAD
                 ============================================================== --}}

            <section class="supervisor-record-panel">


                <div class="supervisor-record-panel-header">


                    <div
                        class="
                            supervisor-record-panel-icon
                            panel-teal
                        "
                    >
                        WL
                    </div>


                    <div>

                        <h2>
                            Current Workload
                        </h2>

                        <p>
                            Active supervision status
                        </p>

                    </div>


                </div>


                <div class="supervisor-record-panel-body">


                    <div class="supervisor-workload-card">


                        @if ($openAssignments->isNotEmpty())


                            <span class="supervisor-workload-title">
                                Currently Supervising
                            </span>


                            <p>

                                This Supervisor currently has

                                <strong>
                                    {{ $openAssignments->count() }}
                                </strong>

                                pending or active OJT
                                Assignment{{ $openAssignments->count() === 1 ? '' : 's' }}

                                involving

                                <strong>
                                    {{ $currentStudentCount }}
                                </strong>

                                Student{{ $currentStudentCount === 1 ? '' : 's' }}.

                            </p>


                        @else


                            <span class="supervisor-workload-title">
                                No Open Assignments
                            </span>


                            <p>

                                This Supervisor currently has no
                                pending or active OJT placement
                                responsibilities.

                            </p>


                        @endif


                    </div>


                </div>


            </section>


            {{-- ==============================================================
                 RESPONSIBILITIES
                 ============================================================== --}}

            <section class="supervisor-record-panel">


                <div class="supervisor-record-panel-header">


                    <div
                        class="
                            supervisor-record-panel-icon
                            panel-orange
                        "
                    >
                        RS
                    </div>


                    <div>

                        <h2>
                            OJT Responsibilities
                        </h2>

                        <p>
                            Supervisor role overview
                        </p>

                    </div>


                </div>


                <div class="supervisor-record-panel-body">


                    <div class="supervisor-sidebar-list">


                        <div class="supervisor-sidebar-item">

                            <span class="supervisor-sidebar-label">
                                Attendance
                            </span>

                            <span class="supervisor-sidebar-value">
                                Validate Student attendance
                            </span>

                        </div>


                        <div class="supervisor-sidebar-item">

                            <span class="supervisor-sidebar-label">
                                Work Logs
                            </span>

                            <span class="supervisor-sidebar-value">
                                Review Daily Work Logs
                            </span>

                        </div>


                        <div class="supervisor-sidebar-item">

                            <span class="supervisor-sidebar-label">
                                Evaluation
                            </span>

                            <span class="supervisor-sidebar-value">
                                Submit final OJT evaluation
                            </span>

                        </div>


                    </div>


                </div>


            </section>


            {{-- ==============================================================
                 ARCHIVE
                 ============================================================== --}}

            <section
                class="
                    supervisor-record-panel
                    supervisor-archive-panel
                "
            >


                <div class="supervisor-archive-body">


                    <span class="supervisor-archive-title">
                        Archive Supervisor Account
                    </span>


                    <p class="supervisor-archive-description">

                        Archiving disables Supervisor login access
                        and removes this account from the normal
                        Supervisor directory while preserving
                        historical supervision, validation,
                        assignment, and evaluation records.

                    </p>


                    @if ($openAssignments->isNotEmpty())


                        <div class="supervisor-archive-warning">

                            This account cannot be archived because
                            the Supervisor still has

                            <strong>

                                {{ $openAssignments->count() }}

                                pending or active OJT
                                Assignment{{ $openAssignments->count() === 1 ? '' : 's' }}.

                            </strong>

                            Reassign, complete, or cancel those
                            placements before archiving.

                        </div>


                        <button
                            type="button"
                            class="supervisor-archive-button"
                            disabled
                        >
                            Archive Unavailable
                        </button>


                    @else


                        <div class="supervisor-archive-safe">

                            No pending or active OJT Assignments
                            were found. This Supervisor account
                            is eligible for safe archiving.

                        </div>


                        <form
                            method="POST"
                            action="{{ route(
                                'admin.supervisors.archive',
                                $supervisor
                            ) }}"
                            onsubmit="
                                return confirm(
                                    'Archive this Supervisor account?\n\nThe Supervisor will no longer be able to sign in. Historical supervision, assignment, validation, and evaluation records will remain preserved.'
                                );
                            "
                        >

                            @csrf
                            @method('PATCH')


                            <button
                                type="submit"
                                class="supervisor-archive-button"
                            >
                                Archive Supervisor Account
                            </button>


                        </form>


                    @endif


                </div>


            </section>


        </aside>


    </div>


</div>


@endsection