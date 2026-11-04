@extends('layouts.app')

@section('title', 'Supervisor Management | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN SUPERVISOR MANAGEMENT
       PROFESSIONAL + READABILITY FIRST
       ================================================================ */

    :root {
        --sp-navy: #183B6B;
        --sp-navy-dark: #102A4A;
        --sp-navy-deep: #0B223D;

        --sp-teal: #0F766E;
        --sp-teal-dark: #0B5F59;
        --sp-teal-light: #2DD4BF;
        --sp-teal-soft: #E7F7F5;

        --sp-blue: #2563EB;
        --sp-blue-soft: #EAF2FF;

        --sp-green: #15803D;
        --sp-green-soft: #EAF8EF;

        --sp-orange: #B45309;
        --sp-orange-soft: #FFF5E6;

        --sp-red: #B42318;
        --sp-red-dark: #92231B;
        --sp-red-soft: #FFF0EE;

        --sp-purple: #6D4FC2;
        --sp-purple-soft: #F2EEFF;

        --sp-text: #102A4A;
        --sp-body: #405872;
        --sp-muted: #64778C;

        --sp-white: #FFFFFF;
        --sp-soft: #F8FBFE;

        --sp-border: #D8E3EE;
        --sp-border-soft: #E7EDF4;

        --sp-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --sp-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --sp-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .admin-supervisors-page {
        width: 100%;

        color: var(--sp-text);

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

    .supervisors-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 30px;

        padding:
            43px
            44px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 88% 14%,
                rgba(45, 212, 191, 0.24),
                transparent 26%
            ),
            radial-gradient(
                circle at 72% 90%,
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
            var(--sp-shadow-large);
    }


    .supervisors-hero::before {
        content: "";

        position: absolute;

        width: 380px;
        height: 380px;

        top: -225px;
        right: -150px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.06);
    }


    .supervisors-hero::after {
        content: "";

        position: absolute;

        width: 220px;
        height: 220px;

        right: 300px;
        bottom: -155px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.04);
    }


    .supervisors-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .supervisors-hero-copy {
        max-width: 760px;
    }


    .supervisors-hero-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 12px;

        padding:
            8px
            13px;

        border:
            1px solid
            rgba(255, 255, 255, 0.16);

        border-radius: 999px;

        background:
            rgba(255, 255, 255, 0.08);

        color:
            rgba(255, 255, 255, 0.93);

        font-size: 14px;
        font-weight: 800;
    }


    .supervisors-hero-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background:
            var(--sp-teal-light);

        box-shadow:
            0 0 0 5px
            rgba(45, 212, 191, 0.14);
    }


    .supervisors-hero h1 {
        margin:
            0
            0
            11px;

        color:
            #FFFFFF;

        font-size: 38px;
        font-weight: 900;

        line-height: 1.18;

        letter-spacing:
            -0.5px;
    }


    .supervisors-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.83);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .supervisors-hero-actions {
        width: 310px;

        flex-shrink: 0;

        display: grid;

        gap: 11px;
    }


    .supervisors-hero-button {
        min-height: 54px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        padding:
            0
            17px;

        border:
            1px solid
            rgba(255, 255, 255, 0.17);

        border-radius: 13px;

        text-decoration: none;

        font-size: 15px;
        font-weight: 850;

        transition:
            var(--sp-transition);
    }


    .supervisors-hero-button-primary {
        background:
            #FFFFFF;

        color:
            var(--sp-navy);
    }


    .supervisors-hero-button-primary:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;

        box-shadow:
            0 12px 25px
            rgba(0, 0, 0, 0.12);
    }


    .supervisors-hero-button-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .supervisors-hero-button-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    .supervisors-button-icon {
        width: 32px;
        height: 32px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        font-size: 15px;
        font-weight: 900;
    }


    .supervisors-hero-button-primary
    .supervisors-button-icon {
        background:
            var(--sp-teal-soft);

        color:
            var(--sp-teal);
    }


    .supervisors-hero-button-secondary
    .supervisors-button-icon {
        background:
            rgba(255, 255, 255, 0.11);

        color:
            #FFFFFF;
    }


    /* ================================================================
       SUMMARY
       ================================================================ */

    .supervisors-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 19px;

        margin-bottom: 28px;
    }


    .supervisors-summary-card {
        padding: 24px;

        border:
            1px solid
            var(--sp-border);

        border-radius: 20px;

        background:
            #FFFFFF;

        box-shadow:
            var(--sp-shadow);

        transition:
            var(--sp-transition);
    }


    .supervisors-summary-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            0 18px 38px
            rgba(15, 42, 74, 0.10);
    }


    .supervisors-summary-icon {
        width: 52px;
        height: 52px;

        margin-bottom: 16px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 15px;

        font-size: 14px;
        font-weight: 900;
    }


    .summary-teal {
        background:
            var(--sp-teal-soft);

        color:
            var(--sp-teal);
    }


    .summary-green {
        background:
            var(--sp-green-soft);

        color:
            var(--sp-green);
    }


    .summary-orange {
        background:
            var(--sp-orange-soft);

        color:
            var(--sp-orange);
    }


    .summary-purple {
        background:
            var(--sp-purple-soft);

        color:
            var(--sp-purple);
    }


    .supervisors-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--sp-body);

        font-size: 15px;
        font-weight: 750;
    }


    .supervisors-summary-value {
        display: block;

        color:
            var(--sp-text);

        font-size: 32px;
        font-weight: 900;

        line-height: 1.15;
    }


    .supervisors-summary-note {
        display: block;

        margin-top: 9px;

        color:
            var(--sp-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       NOTICE
       ================================================================ */

    .supervisors-notice {
        display: flex;
        align-items: flex-start;

        gap: 15px;

        margin-bottom: 26px;

        padding:
            19px
            21px;

        border:
            1px solid
            #CDE2DD;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #F8FCFB 0%,
                #F0FAF7 100%
            );

        box-shadow:
            var(--sp-shadow);
    }


    .supervisors-notice-icon {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--sp-teal-soft);

        color:
            var(--sp-teal);

        font-size: 17px;
        font-weight: 900;
    }


    .supervisors-notice strong {
        display: block;

        margin-bottom: 4px;

        font-size: 17px;
        font-weight: 900;
    }


    .supervisors-notice span {
        color:
            var(--sp-body);

        font-size: 15px;

        line-height: 1.65;
    }


    /* ================================================================
       FILTER
       ================================================================ */

    .supervisors-filter {
        margin-bottom: 26px;

        padding:
            21px
            22px;

        border:
            1px solid
            var(--sp-border);

        border-radius: 18px;

        background:
            #FFFFFF;

        box-shadow:
            var(--sp-shadow);
    }


    .supervisors-filter-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 15px;
    }


    .supervisors-filter-title {
        display: block;

        margin-bottom: 3px;

        font-size: 18px;
        font-weight: 900;
    }


    .supervisors-filter-description {
        color:
            var(--sp-muted);

        font-size: 14px;
    }


    .supervisors-visible-count {
        padding:
            8px
            12px;

        border-radius: 999px;

        background:
            var(--sp-teal-soft);

        color:
            var(--sp-teal);

        font-size: 14px;
        font-weight: 850;
    }


    .supervisors-filter-grid {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            220px;

        gap: 13px;
    }


    .supervisors-search,
    .supervisors-status-filter {
        width: 100%;

        min-height: 53px;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background:
            #FBFDFF;

        color:
            var(--sp-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;
    }


    .supervisors-search {
        padding:
            0
            15px;
    }


    .supervisors-status-filter {
        padding:
            0
            14px;

        cursor: pointer;
    }


    .supervisors-search:focus,
    .supervisors-status-filter:focus {
        border-color:
            var(--sp-teal);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(15, 118, 110, 0.09);
    }


    /* ================================================================
       PANEL
       ================================================================ */

    .supervisors-panel {
        overflow: hidden;

        border:
            1px solid
            var(--sp-border);

        border-radius: 21px;

        background:
            #FFFFFF;

        box-shadow:
            var(--sp-shadow);
    }


    .supervisors-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            24px
            26px;

        border-bottom:
            1px solid
            var(--sp-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .supervisors-panel-heading {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    .supervisors-panel-icon {
        width: 50px;
        height: 50px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background:
            var(--sp-teal-soft);

        color:
            var(--sp-teal);

        font-size: 13px;
        font-weight: 900;
    }


    .supervisors-panel-header h2 {
        margin:
            0
            0
            4px;

        font-size: 23px;
        font-weight: 900;
    }


    .supervisors-panel-header p {
        margin: 0;

        color:
            var(--sp-muted);

        font-size: 14px;
    }


    /* ================================================================
       SUPERVISOR LIST
       ================================================================ */

    .supervisors-list {
        display: grid;

        gap: 17px;

        padding: 25px;
    }


    .supervisor-record {
        overflow: hidden;

        border:
            1px solid
            var(--sp-border);

        border-radius: 18px;

        background:
            #FFFFFF;

        transition:
            var(--sp-transition);
    }


    .supervisor-record:hover {
        border-color:
            #BCD3D0;

        box-shadow:
            0 14px 30px
            rgba(15, 42, 74, 0.08);
    }


    .supervisor-record-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding:
            19px
            20px;

        border-bottom:
            1px solid
            var(--sp-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FAFCFF 100%
            );
    }


    .supervisor-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 14px;
    }


    .supervisor-avatar {
        width: 56px;
        height: 56px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #E7F7F5,
                #D7F0EC
            );

        color:
            var(--sp-teal);

        font-size: 17px;
        font-weight: 900;
    }


    .supervisor-name {
        display: block;

        margin-bottom: 3px;

        color:
            var(--sp-text);

        font-size: 18px;
        font-weight: 900;

        line-height: 1.4;
    }


    .supervisor-email {
        display: block;

        color:
            var(--sp-muted);

        font-size: 14px;

        word-break: break-word;
    }


    .supervisor-status {
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


    .supervisor-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .status-active {
        background:
            var(--sp-green-soft);

        color:
            var(--sp-green);
    }


    .status-active::before {
        background:
            #22C55E;
    }


    .status-inactive {
        background:
            var(--sp-orange-soft);

        color:
            var(--sp-orange);
    }


    .status-inactive::before {
        background:
            #F59E0B;
    }


    /* ================================================================
       RECORD BODY
       ================================================================ */

    .supervisor-record-body {
        padding: 20px;
    }


    .supervisor-info-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 12px;
    }


    .supervisor-info-item {
        min-height: 96px;

        padding: 14px;

        border:
            1px solid
            var(--sp-border-soft);

        border-radius: 12px;

        background:
            var(--sp-soft);
    }


    .supervisor-info-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--sp-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: .2px;
    }


    .supervisor-info-value {
        display: block;

        color:
            var(--sp-text);

        font-size: 17px;
        font-weight: 900;

        line-height: 1.45;
    }


    .supervisor-info-helper {
        display: block;

        margin-top: 3px;

        color:
            var(--sp-muted);

        font-size: 13px;

        line-height: 1.5;
    }


    /* ================================================================
       WORKLOAD
       ================================================================ */

    .supervisor-workload {
        margin-top: 14px;

        padding:
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


    .supervisor-workload-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;
    }


    .supervisor-workload-title {
        display: block;

        margin-bottom: 3px;

        color:
            var(--sp-text);

        font-size: 16px;
        font-weight: 900;
    }


    .supervisor-workload-description {
        color:
            var(--sp-body);

        font-size: 14px;

        line-height: 1.55;
    }


    .workload-badge {
        flex-shrink: 0;

        padding:
            8px
            11px;

        border-radius: 999px;

        font-size: 14px;
        font-weight: 850;
    }


    .workload-active {
        background:
            var(--sp-teal-soft);

        color:
            var(--sp-teal);
    }


    .workload-available {
        background:
            var(--sp-green-soft);

        color:
            var(--sp-green);
    }


    /* ================================================================
       CURRENT STUDENTS
       ================================================================ */

    .supervisor-students {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 10px;

        margin-top: 14px;
    }


    .supervisor-student-item {
        padding:
            13px
            14px;

        border:
            1px solid
            rgba(15, 118, 110, 0.10);

        border-radius: 11px;

        background:
            rgba(255, 255, 255, 0.84);
    }


    .supervisor-student-name {
        display: block;

        color:
            var(--sp-text);

        font-size: 15px;
        font-weight: 900;
    }


    .supervisor-student-company {
        display: block;

        margin-top: 3px;

        color:
            var(--sp-muted);

        font-size: 13px;
    }


    /* ================================================================
       ACTIONS
       ================================================================ */

    .supervisor-record-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 9px;

        margin-top: 17px;

        padding-top: 17px;

        border-top:
            1px solid
            var(--sp-border-soft);
    }


    .supervisor-action {
        min-height: 44px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            14px;

        border:
            1px solid
            var(--sp-border);

        border-radius: 10px;

        background:
            #FFFFFF;

        color:
            var(--sp-navy);

        text-decoration: none;

        font-family: inherit;

        font-size: 14px;
        font-weight: 850;

        cursor: pointer;

        transition:
            var(--sp-transition);
    }


    .supervisor-action:hover {
        transform:
            translateY(-1px);

        background:
            var(--sp-teal-soft);
    }


    .supervisor-action-primary {
        border-color:
            var(--sp-teal);

        background:
            var(--sp-teal);

        color:
            #FFFFFF;
    }


    .supervisor-action-primary:hover {
        background:
            var(--sp-teal-dark);

        color:
            #FFFFFF;
    }


    .supervisor-action-archive {
        margin-left: auto;

        border-color:
            #E4B5AF;

        color:
            var(--sp-red);
    }


    .supervisor-action-archive:hover {
        border-color:
            var(--sp-red);

        background:
            var(--sp-red-soft);
    }


    .supervisor-action-disabled {
        margin-left: auto;

        border-color:
            #E2E8F0;

        background:
            #F8FAFC;

        color:
            #94A3B8;

        cursor: not-allowed;
    }


    .supervisor-action-disabled:hover {
        transform: none;

        background:
            #F8FAFC;
    }


    .supervisor-action-form {
        margin:
            0
            0
            0
            auto;
    }


    /* ================================================================
       EMPTY / FILTER EMPTY
       ================================================================ */

    .supervisors-empty {
        padding:
            58px
            25px;

        text-align: center;
    }


    .supervisors-empty-icon {
        width: 72px;
        height: 72px;

        margin:
            0
            auto
            17px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 20px;

        background:
            var(--sp-teal-soft);

        color:
            var(--sp-teal);

        font-size: 18px;
        font-weight: 900;
    }


    .supervisors-empty h3 {
        margin:
            0
            0
            8px;

        font-size: 22px;
        font-weight: 900;
    }


    .supervisors-empty p {
        margin: 0;

        color:
            var(--sp-muted);

        font-size: 16px;
    }


    .supervisors-filter-empty {
        display: none;

        padding:
            50px
            25px;

        text-align: center;

        color:
            var(--sp-body);

        font-size: 16px;
    }


    .supervisors-filter-empty.is-visible {
        display: block;
    }


    /* ================================================================
       PAGINATION
       ================================================================ */

    .supervisors-pagination {
        padding:
            20px
            25px;

        border-top:
            1px solid
            var(--sp-border-soft);
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1150px) {

        .supervisors-summary-grid,
        .supervisor-info-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 850px) {

        .supervisors-hero {
            padding:
                34px
                28px;
        }


        .supervisors-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .supervisors-hero-actions {
            width: 100%;
        }


        .supervisors-filter-grid {
            grid-template-columns: 1fr;
        }


        .supervisor-record-header,
        .supervisor-workload-top {
            flex-direction: column;

            align-items: flex-start;
        }


        .supervisor-students {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 650px) {

        .supervisors-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .supervisors-hero h1 {
            font-size: 31px;
        }


        .supervisors-hero-description {
            font-size: 16px;
        }


        .supervisors-summary-grid,
        .supervisor-info-grid {
            grid-template-columns: 1fr;
        }


        .supervisors-filter-top,
        .supervisors-panel-header {
            flex-direction: column;

            align-items: flex-start;
        }


        .supervisors-list {
            padding: 18px;
        }


        .supervisor-record-actions {
            display: grid;

            grid-template-columns: 1fr;
        }


        .supervisor-action,
        .supervisor-action-form,
        .supervisor-action-form button {
            width: 100%;

            margin-left: 0;
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

    $pageSupervisors =
        collect(
            $supervisors->items()
        );


    /*
    |--------------------------------------------------------------------------
    | Summary
    |--------------------------------------------------------------------------
    */

    $activeSupervisors =
        $pageSupervisors
            ->filter(
                fn ($supervisor) =>
                    $supervisor->status
                    ===
                    \App\Models\User::STATUS_ACTIVE
            )
            ->count();


    $inactiveSupervisors =
        $pageSupervisors
            ->filter(
                fn ($supervisor) =>
                    $supervisor->status
                    ===
                    \App\Models\User::STATUS_INACTIVE
            )
            ->count();


    $supervisorsWithOpenAssignments =
        $pageSupervisors
            ->filter(
                fn ($supervisor) =>
                    collect(
                        $supervisor
                            ->supervisedAssignments
                        ?? []
                    )
                        ->isNotEmpty()
            )
            ->count();


    $currentStudents =
        $pageSupervisors
            ->flatMap(
                fn ($supervisor) =>
                    collect(
                        $supervisor
                            ->supervisedAssignments
                        ?? []
                    )
            )
            ->pluck(
                'student_profile_id'
            )
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
                ?: 'SV';

        };

@endphp


<div class="admin-supervisors-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="supervisors-hero">


        <div class="supervisors-hero-inner">


            <div class="supervisors-hero-copy">


                <div class="supervisors-hero-eyebrow">


                    <span class="supervisors-hero-dot"></span>


                    Administrator · Supervisor Account Management


                </div>


                <h1>
                    Supervisor Management
                </h1>


                <p class="supervisors-hero-description">

                    Manage Supervisor accounts, monitor current
                    Student supervision responsibilities, review
                    account access, and safely preserve archived
                    supervision history.

                </p>


            </div>


            <div class="supervisors-hero-actions">


                <a
                    href="{{ route(
                        'admin.supervisors.create'
                    ) }}"
                    class="
                        supervisors-hero-button
                        supervisors-hero-button-primary
                    "
                >


                    <span>
                        Add New Supervisor
                    </span>


                    <span class="supervisors-button-icon">
                        +
                    </span>


                </a>


                <a
                    href="{{ route(
                        'admin.supervisors.archived'
                    ) }}"
                    class="
                        supervisors-hero-button
                        supervisors-hero-button-secondary
                    "
                >


                    <span>
                        Archived Supervisors
                    </span>


                    <span class="supervisors-button-icon">
                        AR
                    </span>


                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="supervisors-summary-grid">


        <article class="supervisors-summary-card">


            <div class="supervisors-summary-icon summary-teal">
                SV
            </div>


            <span class="supervisors-summary-label">
                Registered Supervisors
            </span>


            <span class="supervisors-summary-value">

                {{ $supervisors->total() }}

            </span>


            <span class="supervisors-summary-note">

                Current non-archived
                Supervisor accounts.

            </span>


        </article>


        <article class="supervisors-summary-card">


            <div class="supervisors-summary-icon summary-green">
                AC
            </div>


            <span class="supervisors-summary-label">
                Active on This Page
            </span>


            <span class="supervisors-summary-value">

                {{ $activeSupervisors }}

            </span>


            <span class="supervisors-summary-note">

                Supervisors currently allowed
                to access the OJT Portal.

            </span>


        </article>


        <article class="supervisors-summary-card">


            <div class="supervisors-summary-icon summary-orange">
                IN
            </div>


            <span class="supervisors-summary-label">
                Inactive on This Page
            </span>


            <span class="supervisors-summary-value">

                {{ $inactiveSupervisors }}

            </span>


            <span class="supervisors-summary-note">

                Supervisor login access
                currently disabled.

            </span>


        </article>


        <article class="supervisors-summary-card">


            <div class="supervisors-summary-icon summary-purple">
                OJ
            </div>


            <span class="supervisors-summary-label">
                Current Students
            </span>


            <span class="supervisors-summary-value">

                {{ $currentStudents }}

            </span>


            <span class="supervisors-summary-note">

                Students represented by
                pending or active assignments.

            </span>


        </article>


    </section>


    {{-- ==================================================================
         NOTICE
         ================================================================== --}}

    <section class="supervisors-notice">


        <div class="supervisors-notice-icon">
            i
        </div>


        <div>


            <strong>
                Supervisor accounts with open assignments cannot be archived.
            </strong>


            <span>

                Reassign, complete, or cancel pending and active
                OJT Assignments before archiving a Supervisor.
                Historical validation, Work Log review, final
                evaluation, and placement records remain preserved
                after a Supervisor is archived.

            </span>


        </div>


    </section>


    {{-- ==================================================================
         FILTER
         ================================================================== --}}

    @if ($supervisors->count())


        <section class="supervisors-filter">


            <div class="supervisors-filter-top">


                <div>


                    <span class="supervisors-filter-title">
                        Find a Supervisor
                    </span>


                    <span class="supervisors-filter-description">

                        Search by Supervisor name, email,
                        assigned Student, company, or account status.

                    </span>


                </div>


                <span
                    class="supervisors-visible-count"
                    id="supervisors-visible-count"
                >

                    {{ $supervisors->count() }}
                    shown

                </span>


            </div>


            <div class="supervisors-filter-grid">


                <input
                    type="search"
                    id="supervisors-search"
                    class="supervisors-search"
                    placeholder="Search Supervisor, Student, company..."
                    autocomplete="off"
                >


                <select
                    id="supervisors-status-filter"
                    class="supervisors-status-filter"
                >

                    <option value="">
                        All Accounts
                    </option>


                    <option value="active">
                        Active
                    </option>


                    <option value="inactive">
                        Inactive
                    </option>


                    <option value="supervising">
                        Supervising Students
                    </option>


                    <option value="available">
                        No Open Assignments
                    </option>


                </select>


            </div>


        </section>


    @endif


    {{-- ==================================================================
         DIRECTORY
         ================================================================== --}}

    <section class="supervisors-panel">


        <div class="supervisors-panel-header">


            <div class="supervisors-panel-heading">


                <div class="supervisors-panel-icon">
                    SV
                </div>


                <div>


                    <h2>
                        Supervisor Account Directory
                    </h2>


                    <p>
                        Account access, workload, assigned Students, and Administration actions
                    </p>


                </div>


            </div>


        </div>


        @if ($supervisors->count())


            <div
                class="supervisors-list"
                id="supervisors-list"
            >


                @foreach ($supervisors as $supervisor)


                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | Open Assignments
                        |--------------------------------------------------------------------------
                        |
                        | The Admin controller loads only OPEN_STATUSES in this list.
                        |
                        */

                        $assignments =
                            collect(
                                $supervisor
                                    ->supervisedAssignments
                                ?? []
                            );


                        $hasOpenAssignments =
                            $assignments
                                ->isNotEmpty();


                        $assignedStudentCount =
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
                        | Search
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
                                        $supervisor->status,
                                        $studentNames,
                                        $companyNames,
                                    ]
                                )
                            );


                        $accountStatus =
                            strtolower(
                                (string)
                                $supervisor->status
                            );

                    @endphp


                    <article
                        class="supervisor-record"
                        data-supervisor-record
                        data-search="{{ $searchText }}"
                        data-status="{{ $accountStatus }}"
                        data-open-assignments="{{ $hasOpenAssignments ? '1' : '0' }}"
                    >


                        {{-- ======================================================
                             HEADER
                             ====================================================== --}}

                        <div class="supervisor-record-header">


                            <div class="supervisor-identity">


                                <div class="supervisor-avatar">

                                    {{ $makeInitials(
                                        $supervisor->name
                                    ) }}

                                </div>


                                <div>


                                    <span class="supervisor-name">

                                        {{ $supervisor->name }}

                                    </span>


                                    <span class="supervisor-email">

                                        {{ $supervisor->email }}

                                    </span>


                                </div>


                            </div>


                            @if (
                                $supervisor->status
                                ===
                                \App\Models\User::STATUS_ACTIVE
                            )


                                <span
                                    class="
                                        supervisor-status
                                        status-active
                                    "
                                >
                                    Active Account
                                </span>


                            @else


                                <span
                                    class="
                                        supervisor-status
                                        status-inactive
                                    "
                                >
                                    Inactive Account
                                </span>


                            @endif


                        </div>


                        {{-- ======================================================
                             BODY
                             ====================================================== --}}

                        <div class="supervisor-record-body">


                            <div class="supervisor-info-grid">


                                <div class="supervisor-info-item">


                                    <span class="supervisor-info-label">
                                        Account Role
                                    </span>


                                    <span class="supervisor-info-value">
                                        Supervisor
                                    </span>


                                    <span class="supervisor-info-helper">
                                        OJT validation and monitoring
                                    </span>


                                </div>


                                <div class="supervisor-info-item">


                                    <span class="supervisor-info-label">
                                        Account Access
                                    </span>


                                    <span class="supervisor-info-value">

                                        {{ ucfirst(
                                            $supervisor->status
                                        ) }}

                                    </span>


                                    <span class="supervisor-info-helper">

                                        {{ $supervisor->isActive()
                                            ? 'OJT Portal login enabled'
                                            : 'OJT Portal login disabled'
                                        }}

                                    </span>


                                </div>


                                <div class="supervisor-info-item">


                                    <span class="supervisor-info-label">
                                        Open Assignments
                                    </span>


                                    <span class="supervisor-info-value">

                                        {{ $assignments->count() }}

                                    </span>


                                    <span class="supervisor-info-helper">
                                        Pending or active placements
                                    </span>


                                </div>


                                <div class="supervisor-info-item">


                                    <span class="supervisor-info-label">
                                        Current Students
                                    </span>


                                    <span class="supervisor-info-value">

                                        {{ $assignedStudentCount }}

                                    </span>


                                    <span class="supervisor-info-helper">

                                        Across
                                        {{ $companyCount }}

                                        compan{{ $companyCount === 1 ? 'y' : 'ies' }}

                                    </span>


                                </div>


                            </div>


                            {{-- ==================================================
                                 WORKLOAD
                                 ================================================== --}}

                            <section class="supervisor-workload">


                                <div class="supervisor-workload-top">


                                    <div>


                                        <span class="supervisor-workload-title">

                                            @if ($hasOpenAssignments)

                                                Current Supervision Workload

                                            @else

                                                Supervision Availability

                                            @endif

                                        </span>


                                        <div class="supervisor-workload-description">


                                            @if ($hasOpenAssignments)

                                                This Supervisor is currently
                                                responsible for
                                                {{ $assignedStudentCount }}

                                                Student{{ $assignedStudentCount === 1 ? '' : 's' }}
                                                in pending or active OJT placements.

                                            @else

                                                No pending or active OJT Assignments
                                                are currently connected to this Supervisor.

                                            @endif


                                        </div>


                                    </div>


                                    @if ($hasOpenAssignments)


                                        <span
                                            class="
                                                workload-badge
                                                workload-active
                                            "
                                        >
                                            Supervising
                                        </span>


                                    @else


                                        <span
                                            class="
                                                workload-badge
                                                workload-available
                                            "
                                        >
                                            No Open Assignments
                                        </span>


                                    @endif


                                </div>


                                {{-- ==============================================
                                     CURRENT STUDENTS
                                     ============================================== --}}

                                @if ($hasOpenAssignments)


                                    <div class="supervisor-students">


                                        @foreach (
                                            $assignments->take(4)
                                            as $assignment
                                        )


                                            <div class="supervisor-student-item">


                                                <span class="supervisor-student-name">

                                                    {{ $assignment
                                                        ->studentProfile
                                                        ?->user
                                                        ?->name
                                                        ?? 'Student unavailable'
                                                    }}

                                                </span>


                                                <span class="supervisor-student-company">

                                                    {{ $assignment
                                                        ->company
                                                        ?->name
                                                        ?? 'Company unavailable'
                                                    }}

                                                    ·
                                                    {{ ucfirst(
                                                        $assignment->status
                                                    ) }}

                                                </span>


                                            </div>


                                        @endforeach


                                    </div>


                                    @if ($assignments->count() > 4)


                                        <div
                                            style="
                                                margin-top: 11px;
                                                color: #64778C;
                                                font-size: 14px;
                                                font-weight: 700;
                                            "
                                        >

                                            + {{ $assignments->count() - 4 }}
                                            more open assignment{{ ($assignments->count() - 4) === 1 ? '' : 's' }}

                                        </div>


                                    @endif


                                @endif


                            </section>


                            {{-- ==================================================
                                 ACTIONS
                                 ================================================== --}}

                            <div class="supervisor-record-actions">


                                <a
                                    href="{{ route(
                                        'admin.supervisors.show',
                                        $supervisor
                                    ) }}"
                                    class="
                                        supervisor-action
                                        supervisor-action-primary
                                    "
                                >
                                    View Supervisor
                                </a>


                                <a
                                    href="{{ route(
                                        'admin.supervisors.edit',
                                        $supervisor
                                    ) }}"
                                    class="supervisor-action"
                                >
                                    Edit Account
                                </a>


                                @if ($hasOpenAssignments)


                                    <button
                                        type="button"
                                        class="
                                            supervisor-action
                                            supervisor-action-disabled
                                        "
                                        disabled
                                        title="Reassign, complete, or cancel the Supervisor's pending or active OJT Assignments before archiving."
                                    >
                                        Archive Unavailable
                                    </button>


                                @else


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.supervisors.archive',
                                            $supervisor
                                        ) }}"
                                        class="supervisor-action-form"
                                        onsubmit="
                                            return confirm(
                                                'Archive this Supervisor account?\n\nSupervisor: {{ addslashes($supervisor->name) }}\n\nThe account will become inactive and disappear from the normal Supervisor list. Historical supervision and evaluation records will remain preserved.'
                                            );
                                        "
                                    >

                                        @csrf
                                        @method('PATCH')


                                        <button
                                            type="submit"
                                            class="
                                                supervisor-action
                                                supervisor-action-archive
                                            "
                                        >
                                            Archive Account
                                        </button>


                                    </form>


                                @endif


                            </div>


                        </div>


                    </article>


                @endforeach


            </div>


            <div
                class="supervisors-filter-empty"
                id="supervisors-filter-empty"
            >

                No Supervisors match
                your current search or filter.

            </div>


            @if ($supervisors->hasPages())


                <div class="supervisors-pagination">

                    {{ $supervisors->links() }}

                </div>


            @endif


        @else


            <div class="supervisors-empty">


                <div class="supervisors-empty-icon">
                    SV
                </div>


                <h3>
                    No Supervisor Accounts
                </h3>


                <p>

                    Supervisor accounts created by
                    the Administrator will appear here.

                </p>


            </div>


        @endif


    </section>


</div>


@endsection


@push('scripts')

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /*
            |--------------------------------------------------------------------------
            | Supervisor Search + Filter
            |--------------------------------------------------------------------------
            */

            const searchInput =
                document.getElementById(
                    'supervisors-search'
                );


            const statusFilter =
                document.getElementById(
                    'supervisors-status-filter'
                );


            const records =
                Array.from(
                    document.querySelectorAll(
                        '[data-supervisor-record]'
                    )
                );


            const visibleCount =
                document.getElementById(
                    'supervisors-visible-count'
                );


            const emptyMessage =
                document.getElementById(
                    'supervisors-filter-empty'
                );


            const applyFilters =
                function () {

                    if (! records.length) {
                        return;
                    }


                    const search =
                        searchInput
                            ? searchInput
                                .value
                                .trim()
                                .toLowerCase()
                            : '';


                    const filter =
                        statusFilter
                            ? statusFilter
                                .value
                                .trim()
                                .toLowerCase()
                            : '';


                    let count = 0;


                    records.forEach(
                        function (record) {

                            const searchable =
                                (
                                    record.dataset.search
                                    || ''
                                )
                                    .toLowerCase();


                            const status =
                                (
                                    record.dataset.status
                                    || ''
                                )
                                    .toLowerCase();


                            const hasOpenAssignments =
                                record
                                    .dataset
                                    .openAssignments
                                === '1';


                            const matchesSearch =
                                ! search
                                ||
                                searchable.includes(
                                    search
                                );


                            let matchesFilter = true;


                            if (filter === 'active') {

                                matchesFilter =
                                    status === 'active';

                            }


                            if (filter === 'inactive') {

                                matchesFilter =
                                    status === 'inactive';

                            }


                            if (filter === 'supervising') {

                                matchesFilter =
                                    hasOpenAssignments;

                            }


                            if (filter === 'available') {

                                matchesFilter =
                                    ! hasOpenAssignments;

                            }


                            const visible =
                                matchesSearch
                                &&
                                matchesFilter;


                            record.style.display =
                                visible
                                    ? ''
                                    : 'none';


                            if (visible) {
                                count++;
                            }

                        }
                    );


                    if (visibleCount) {

                        visibleCount.textContent =
                            count
                            +
                            (
                                count === 1
                                    ? ' Supervisor shown'
                                    : ' Supervisors shown'
                            );

                    }


                    if (emptyMessage) {

                        emptyMessage.classList.toggle(
                            'is-visible',
                            count === 0
                        );

                    }

                };


            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    applyFilters
                );

            }


            if (statusFilter) {

                statusFilter.addEventListener(
                    'change',
                    applyFilters
                );

            }

        }
    );

</script>

@endpush