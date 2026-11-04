@extends('layouts.app')

@section('title', 'Student Management | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN STUDENT MANAGEMENT
       PROFESSIONAL + READABILITY FIRST
       ================================================================ */

    :root {
        --st-navy: #183B6B;
        --st-navy-dark: #102A4A;
        --st-navy-deep: #0B223D;

        --st-blue: #2563EB;
        --st-blue-light: #60A5FA;
        --st-blue-soft: #EAF2FF;

        --st-teal: #0F766E;
        --st-teal-soft: #E7F7F5;

        --st-green: #15803D;
        --st-green-soft: #EAF8EF;

        --st-orange: #B45309;
        --st-orange-soft: #FFF5E6;

        --st-red: #B42318;
        --st-red-dark: #92231B;
        --st-red-soft: #FFF0EE;

        --st-purple: #6D4FC2;
        --st-purple-soft: #F2EEFF;

        --st-text: #102A4A;
        --st-body: #405872;
        --st-muted: #64778C;

        --st-white: #FFFFFF;
        --st-soft: #F8FBFE;
        --st-soft-blue: #F3F8FD;

        --st-border: #D8E3EE;
        --st-border-soft: #E7EDF4;

        --st-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --st-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --st-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .admin-students-page {
        width: 100%;

        color: var(--st-text);

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

    .students-hero {
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
                rgba(96, 165, 250, 0.24),
                transparent 26%
            ),
            radial-gradient(
                circle at 72% 90%,
                rgba(45, 212, 191, 0.10),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 54%,
                #285F98 100%
            );

        box-shadow:
            var(--st-shadow-large);
    }


    .students-hero::before {
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


    .students-hero::after {
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


    .students-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .students-hero-copy {
        max-width: 760px;
    }


    .students-hero-eyebrow {
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


    .students-hero-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background:
            var(--st-blue-light);

        box-shadow:
            0 0 0 5px
            rgba(96, 165, 250, 0.14);
    }


    .students-hero h1 {
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


    .students-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.83);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .students-hero-actions {
        width: 300px;

        flex-shrink: 0;

        display: grid;

        gap: 11px;
    }


    .students-hero-button {
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
            var(--st-transition);
    }


    .students-hero-button-primary {
        background:
            #FFFFFF;

        color:
            var(--st-navy);
    }


    .students-hero-button-primary:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;

        box-shadow:
            0 12px 25px
            rgba(0, 0, 0, 0.12);
    }


    .students-hero-button-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .students-hero-button-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    .students-button-icon {
        width: 32px;
        height: 32px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        font-size: 16px;
        font-weight: 900;
    }


    .students-hero-button-primary
    .students-button-icon {
        background:
            var(--st-blue-soft);

        color:
            var(--st-blue);
    }


    .students-hero-button-secondary
    .students-button-icon {
        background:
            rgba(255, 255, 255, 0.11);

        color:
            #FFFFFF;
    }


    /* ================================================================
       SUMMARY CARDS
       ================================================================ */

    .students-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 19px;

        margin-bottom: 28px;
    }


    .students-summary-card {
        padding: 24px;

        border:
            1px solid
            var(--st-border);

        border-radius: 20px;

        background:
            var(--st-white);

        box-shadow:
            var(--st-shadow);

        transition:
            var(--st-transition);
    }


    .students-summary-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            0 18px 38px
            rgba(15, 42, 74, 0.10);
    }


    .students-summary-icon {
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


    .summary-blue {
        background:
            var(--st-blue-soft);

        color:
            var(--st-blue);
    }


    .summary-green {
        background:
            var(--st-green-soft);

        color:
            var(--st-green);
    }


    .summary-orange {
        background:
            var(--st-orange-soft);

        color:
            var(--st-orange);
    }


    .summary-purple {
        background:
            var(--st-purple-soft);

        color:
            var(--st-purple);
    }


    .students-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--st-body);

        font-size: 15px;
        font-weight: 750;
    }


    .students-summary-value {
        display: block;

        color:
            var(--st-text);

        font-size: 32px;
        font-weight: 900;

        line-height: 1.15;
    }


    .students-summary-note {
        display: block;

        margin-top: 9px;

        color:
            var(--st-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       MANAGEMENT NOTICE
       ================================================================ */

    .students-notice {
        display: flex;
        align-items: flex-start;

        gap: 15px;

        margin-bottom: 26px;

        padding:
            19px
            21px;

        border:
            1px solid
            #D3E0EF;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #F8FBFF 0%,
                #F2F7FD 100%
            );

        box-shadow:
            var(--st-shadow);
    }


    .students-notice-icon {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--st-blue-soft);

        color:
            var(--st-blue);

        font-size: 17px;
        font-weight: 900;
    }


    .students-notice strong {
        display: block;

        margin-bottom: 4px;

        font-size: 17px;
        font-weight: 900;
    }


    .students-notice span {
        color:
            var(--st-body);

        font-size: 15px;

        line-height: 1.65;
    }


    /* ================================================================
       FILTER
       ================================================================ */

    .students-filter {
        margin-bottom: 26px;

        padding:
            21px
            22px;

        border:
            1px solid
            var(--st-border);

        border-radius: 18px;

        background:
            #FFFFFF;

        box-shadow:
            var(--st-shadow);
    }


    .students-filter-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 15px;
    }


    .students-filter-title {
        display: block;

        margin-bottom: 3px;

        font-size: 18px;
        font-weight: 900;
    }


    .students-filter-description {
        color:
            var(--st-muted);

        font-size: 14px;
    }


    .students-visible-count {
        padding:
            8px
            12px;

        border-radius: 999px;

        background:
            var(--st-blue-soft);

        color:
            var(--st-blue);

        font-size: 14px;
        font-weight: 850;
    }


    .students-filter-grid {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            205px;

        gap: 13px;
    }


    .students-search,
    .students-status-filter {
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
            var(--st-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;

        transition:
            var(--st-transition);
    }


    .students-search {
        padding:
            0
            15px;
    }


    .students-status-filter {
        padding:
            0
            14px;

        cursor: pointer;
    }


    .students-search:focus,
    .students-status-filter:focus {
        border-color:
            var(--st-blue);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, 0.09);
    }


    /* ================================================================
       DIRECTORY PANEL
       ================================================================ */

    .students-panel {
        overflow: hidden;

        border:
            1px solid
            var(--st-border);

        border-radius: 21px;

        background:
            #FFFFFF;

        box-shadow:
            var(--st-shadow);
    }


    .students-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            24px
            26px;

        border-bottom:
            1px solid
            var(--st-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .students-panel-heading {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    .students-panel-icon {
        width: 50px;
        height: 50px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background:
            var(--st-blue-soft);

        color:
            var(--st-blue);

        font-size: 13px;
        font-weight: 900;
    }


    .students-panel-header h2 {
        margin:
            0
            0
            4px;

        font-size: 23px;
        font-weight: 900;
    }


    .students-panel-header p {
        margin: 0;

        color:
            var(--st-muted);

        font-size: 14px;
    }


    /* ================================================================
       STUDENT CARDS
       ================================================================ */

    .students-list {
        display: grid;

        gap: 17px;

        padding: 25px;
    }


    .student-record {
        overflow: hidden;

        border:
            1px solid
            var(--st-border);

        border-radius: 18px;

        background:
            #FFFFFF;

        transition:
            var(--st-transition);
    }


    .student-record:hover {
        border-color:
            #BDD0E2;

        box-shadow:
            0 14px 30px
            rgba(15, 42, 74, 0.08);
    }


    .student-record-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding:
            19px
            20px;

        border-bottom:
            1px solid
            var(--st-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FAFCFF 100%
            );
    }


    .student-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 14px;
    }


    .student-avatar {
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
                #EAF2FF,
                #DDEBFC
            );

        color:
            var(--st-navy);

        font-size: 17px;
        font-weight: 900;
    }


    .student-name {
        display: block;

        margin-bottom: 3px;

        color:
            var(--st-text);

        font-size: 18px;
        font-weight: 900;

        line-height: 1.4;
    }


    .student-email {
        display: block;

        color:
            var(--st-muted);

        font-size: 14px;

        word-break: break-word;
    }


    .student-status {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding:
            8px
            12px;

        border-radius: 999px;

        font-size: 14px;
        font-weight: 850;

        white-space: nowrap;
    }


    .student-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .status-active {
        background:
            var(--st-green-soft);

        color:
            var(--st-green);
    }


    .status-active::before {
        background:
            #22C55E;
    }


    .status-inactive {
        background:
            var(--st-orange-soft);

        color:
            var(--st-orange);
    }


    .status-inactive::before {
        background:
            #F59E0B;
    }


    /* ================================================================
       STUDENT INFO
       ================================================================ */

    .student-record-body {
        padding:
            20px;
    }


    .student-info-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 12px;
    }


    .student-info-item {
        min-height: 95px;

        padding:
            14px;

        border:
            1px solid
            var(--st-border-soft);

        border-radius: 12px;

        background:
            var(--st-soft);
    }


    .student-info-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--st-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.2px;
    }


    .student-info-value {
        display: block;

        color:
            var(--st-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.5;

        word-break: break-word;
    }


    .student-info-helper {
        display: block;

        margin-top: 3px;

        color:
            var(--st-muted);

        font-size: 13px;
    }


    /* ================================================================
       OJT PLACEMENT
       ================================================================ */

    .student-placement {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-top: 14px;

        padding:
            16px
            17px;

        border:
            1px solid
            #D7E2EE;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #F9FCFF 0%,
                #F3F8FD 100%
            );
    }


    .student-placement-title {
        display: block;

        margin-bottom: 3px;

        color:
            var(--st-text);

        font-size: 16px;
        font-weight: 900;
    }


    .student-placement-description {
        color:
            var(--st-body);

        font-size: 14px;

        line-height: 1.55;
    }


    .placement-badge {
        flex-shrink: 0;

        display: inline-flex;
        align-items: center;

        padding:
            8px
            11px;

        border-radius: 999px;

        font-size: 14px;
        font-weight: 850;
    }


    .placement-open {
        background:
            var(--st-blue-soft);

        color:
            var(--st-blue);
    }


    .placement-none {
        background:
            var(--st-green-soft);

        color:
            var(--st-green);
    }


    /* ================================================================
       ACTIONS
       ================================================================ */

    .student-record-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 9px;

        margin-top: 17px;

        padding-top: 17px;

        border-top:
            1px solid
            var(--st-border-soft);
    }


    .student-action {
        min-height: 44px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            14px;

        border:
            1px solid
            var(--st-border);

        border-radius: 10px;

        background:
            #FFFFFF;

        color:
            var(--st-navy);

        text-decoration: none;

        font-family: inherit;

        font-size: 14px;
        font-weight: 850;

        cursor: pointer;

        transition:
            var(--st-transition);
    }


    .student-action:hover {
        transform:
            translateY(-1px);

        background:
            var(--st-blue-soft);
    }


    .student-action-primary {
        border-color:
            var(--st-navy);

        background:
            var(--st-navy);

        color:
            #FFFFFF;
    }


    .student-action-primary:hover {
        background:
            var(--st-navy-dark);

        color:
            #FFFFFF;
    }


    .student-action-archive {
        margin-left: auto;

        border-color:
            #E4B5AF;

        color:
            var(--st-red);
    }


    .student-action-archive:hover {
        border-color:
            var(--st-red);

        background:
            var(--st-red-soft);
    }


    .student-action-disabled {
        margin-left: auto;

        border-color:
            #E2E8F0;

        background:
            #F8FAFC;

        color:
            #94A3B8;

        cursor: not-allowed;
    }


    .student-action-disabled:hover {
        transform: none;

        background:
            #F8FAFC;
    }


    .student-action-form {
        margin:
            0
            0
            0
            auto;
    }


    /* ================================================================
       EMPTY
       ================================================================ */

    .students-empty {
        padding:
            58px
            25px;

        text-align: center;
    }


    .students-empty-icon {
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
            var(--st-blue-soft);

        color:
            var(--st-blue);

        font-size: 18px;
        font-weight: 900;
    }


    .students-empty h3 {
        margin:
            0
            0
            8px;

        font-size: 22px;
        font-weight: 900;
    }


    .students-empty p {
        margin: 0;

        color:
            var(--st-muted);

        font-size: 16px;
    }


    .students-filter-empty {
        display: none;

        padding:
            50px
            25px;

        text-align: center;

        color:
            var(--st-body);

        font-size: 16px;
    }


    .students-filter-empty.is-visible {
        display: block;
    }


    /* ================================================================
       PAGINATION
       ================================================================ */

    .students-pagination {
        padding:
            20px
            25px;

        border-top:
            1px solid
            var(--st-border-soft);
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1150px) {

        .students-summary-grid,
        .student-info-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 850px) {

        .students-hero {
            padding:
                34px
                28px;
        }


        .students-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .students-hero-actions {
            width: 100%;
        }


        .students-filter-grid {
            grid-template-columns: 1fr;
        }


        .student-record-header,
        .student-placement {
            flex-direction: column;

            align-items: flex-start;
        }

    }


    @media (max-width: 650px) {

        .students-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .students-hero h1 {
            font-size: 31px;
        }


        .students-hero-description {
            font-size: 16px;
        }


        .students-summary-grid,
        .student-info-grid {
            grid-template-columns: 1fr;
        }


        .students-filter-top,
        .students-panel-header {
            flex-direction: column;

            align-items: flex-start;
        }


        .students-list {
            padding: 18px;
        }


        .student-record-actions {
            display: grid;

            grid-template-columns:
                1fr;
        }


        .student-action,
        .student-action-form,
        .student-action-form button {
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

    $pageStudents =
        collect(
            $students->items()
        );


    /*
    |--------------------------------------------------------------------------
    | Summary
    |--------------------------------------------------------------------------
    */

    $activeStudents =
        $pageStudents
            ->filter(
                fn ($student) =>
                    $student->status
                    ===
                    \App\Models\User::STATUS_ACTIVE
            )
            ->count();


    $inactiveStudents =
        $pageStudents
            ->filter(
                fn ($student) =>
                    $student->status
                    ===
                    \App\Models\User::STATUS_INACTIVE
            )
            ->count();


    $studentsWithOpenAssignments =
        $pageStudents
            ->filter(
                function ($student) {

                    $profile =
                        $student->studentProfile;


                    return
                        $profile
                        &&
                        collect(
                            $profile
                                ->ojtAssignments
                            ?? []
                        )
                            ->isNotEmpty();

                }
            )
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

@endphp


<div class="admin-students-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="students-hero">


        <div class="students-hero-inner">


            <div class="students-hero-copy">


                <div class="students-hero-eyebrow">


                    <span class="students-hero-dot"></span>


                    Administrator · Student Account Management


                </div>


                <h1>
                    Student Management
                </h1>


                <p class="students-hero-description">

                    Manage Student accounts, academic profile
                    information, account access, OJT placement
                    status, and archived records from one
                    organized Administration workspace.

                </p>


            </div>


            <div class="students-hero-actions">


                <a
                    href="{{ route(
                        'admin.students.create'
                    ) }}"
                    class="
                        students-hero-button
                        students-hero-button-primary
                    "
                >


                    <span>
                        Add New Student
                    </span>


                    <span class="students-button-icon">
                        +
                    </span>


                </a>


                <a
                    href="{{ route(
                        'admin.students.archived'
                    ) }}"
                    class="
                        students-hero-button
                        students-hero-button-secondary
                    "
                >


                    <span>
                        Archived Students
                    </span>


                    <span class="students-button-icon">
                        AR
                    </span>


                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="students-summary-grid">


        <article class="students-summary-card">


            <div class="students-summary-icon summary-blue">
                ST
            </div>


            <span class="students-summary-label">
                Registered Students
            </span>


            <span class="students-summary-value">

                {{ $students->total() }}

            </span>


            <span class="students-summary-note">

                Current non-archived
                Student accounts.

            </span>


        </article>


        <article class="students-summary-card">


            <div class="students-summary-icon summary-green">
                AC
            </div>


            <span class="students-summary-label">
                Active on This Page
            </span>


            <span class="students-summary-value">

                {{ $activeStudents }}

            </span>


            <span class="students-summary-note">

                Students currently allowed
                to access the OJT Portal.

            </span>


        </article>


        <article class="students-summary-card">


            <div class="students-summary-icon summary-orange">
                IN
            </div>


            <span class="students-summary-label">
                Inactive on This Page
            </span>


            <span class="students-summary-value">

                {{ $inactiveStudents }}

            </span>


            <span class="students-summary-note">

                Accounts with Student
                login access disabled.

            </span>


        </article>


        <article class="students-summary-card">


            <div class="students-summary-icon summary-purple">
                OJ
            </div>


            <span class="students-summary-label">
                Open OJT Placements
            </span>


            <span class="students-summary-value">

                {{ $studentsWithOpenAssignments }}

            </span>


            <span class="students-summary-note">

                Students with pending or
                active OJT Assignments.

            </span>


        </article>


    </section>


    {{-- ==================================================================
         NOTICE
         ================================================================== --}}

    <section class="students-notice">


        <div class="students-notice-icon">
            i
        </div>


        <div>


            <strong>
                Student accounts use safe archiving instead of permanent deletion.
            </strong>


            <span>

                Archiving removes the account from the normal
                Student directory and disables login access,
                while historical OJT Assignments, attendance,
                Timesheets, Daily Work Logs, evaluations, and
                completion records remain preserved.

            </span>


        </div>


    </section>


    {{-- ==================================================================
         FILTER
         ================================================================== --}}

    @if ($students->count())


        <section class="students-filter">


            <div class="students-filter-top">


                <div>


                    <span class="students-filter-title">
                        Find a Student
                    </span>


                    <span class="students-filter-description">

                        Search by Student name, email,
                        Student number, program, company,
                        or account status.

                    </span>


                </div>


                <span
                    class="students-visible-count"
                    id="students-visible-count"
                >

                    {{ $students->count() }}
                    shown

                </span>


            </div>


            <div class="students-filter-grid">


                <input
                    type="search"
                    id="students-search"
                    class="students-search"
                    placeholder="Search Student name, ID, program, company..."
                    autocomplete="off"
                >


                <select
                    id="students-status-filter"
                    class="students-status-filter"
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


                    <option value="open">
                        Open OJT Placement
                    </option>


                    <option value="available">
                        No Open Placement
                    </option>


                </select>


            </div>


        </section>


    @endif


    {{-- ==================================================================
         DIRECTORY
         ================================================================== --}}

    <section class="students-panel">


        <div class="students-panel-header">


            <div class="students-panel-heading">


                <div class="students-panel-icon">
                    ST
                </div>


                <div>


                    <h2>
                        Student Account Directory
                    </h2>


                    <p>
                        Account details, academic information, OJT placement, and actions
                    </p>


                </div>


            </div>


        </div>


        @if ($students->count())


            <div
                class="students-list"
                id="students-list"
            >


                @foreach ($students as $student)


                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | Student Profile
                        |--------------------------------------------------------------------------
                        */

                        $profile =
                            $student
                                ->studentProfile;


                        /*
                        |--------------------------------------------------------------------------
                        | Open Assignments
                        |--------------------------------------------------------------------------
                        |
                        | StudentController loads only OPEN_STATUSES here.
                        |
                        */

                        $openAssignments =
                            $profile
                                ? collect(
                                    $profile
                                        ->ojtAssignments
                                    ?? []
                                )
                                : collect();


                        $openAssignment =
                            $openAssignments
                                ->first();


                        $hasOpenAssignment =
                            $openAssignments
                                ->isNotEmpty();


                        /*
                        |--------------------------------------------------------------------------
                        | Search
                        |--------------------------------------------------------------------------
                        */

                        $searchText =
                            strtolower(
                                implode(
                                    ' ',
                                    [
                                        $student->name,
                                        $student->email,

                                        $profile
                                            ?->student_number,

                                        $profile
                                            ?->program,

                                        $profile
                                            ?->year_level,

                                        $profile
                                            ?->section,

                                        $openAssignment
                                            ?->company
                                            ?->name,

                                        $student->status,
                                    ]
                                )
                            );


                        $accountStatus =
                            strtolower(
                                (string)
                                $student->status
                            );

                    @endphp


                    <article
                        class="student-record"
                        data-student-record
                        data-search="{{ $searchText }}"
                        data-status="{{ $accountStatus }}"
                        data-open-assignment="{{ $hasOpenAssignment ? '1' : '0' }}"
                    >


                        {{-- ======================================================
                             HEADER
                             ====================================================== --}}

                        <div class="student-record-header">


                            <div class="student-identity">


                                <div class="student-avatar">

                                    {{ $makeInitials(
                                        $student->name
                                    ) }}

                                </div>


                                <div>


                                    <span class="student-name">

                                        {{ $student->name }}

                                    </span>


                                    <span class="student-email">

                                        {{ $student->email }}

                                    </span>


                                </div>


                            </div>


                            @if (
                                $student->status
                                ===
                                \App\Models\User::STATUS_ACTIVE
                            )


                                <span
                                    class="
                                        student-status
                                        status-active
                                    "
                                >
                                    Active Account
                                </span>


                            @else


                                <span
                                    class="
                                        student-status
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

                        <div class="student-record-body">


                            <div class="student-info-grid">


                                <div class="student-info-item">


                                    <span class="student-info-label">
                                        Student Number
                                    </span>


                                    <span class="student-info-value">

                                        {{ $profile
                                            ?->student_number
                                            ?? 'Not provided'
                                        }}

                                    </span>


                                    <span class="student-info-helper">

                                        {{ $profile
                                            ? 'Student profile available'
                                            : 'Profile not completed'
                                        }}

                                    </span>


                                </div>


                                <div class="student-info-item">


                                    <span class="student-info-label">
                                        Academic Program
                                    </span>


                                    <span class="student-info-value">

                                        {{ $profile
                                            ?->program
                                            ?? 'Not provided'
                                        }}

                                    </span>


                                    <span class="student-info-helper">

                                        @if ($profile)


                                            {{ $profile->year_level
                                                ?? 'Year level not set'
                                            }}


                                            @if (
                                                filled(
                                                    $profile->section
                                                )
                                            )

                                                ·
                                                {{ $profile->section }}

                                            @endif


                                        @else

                                            No academic information

                                        @endif

                                    </span>


                                </div>


                                <div class="student-info-item">


                                    <span class="student-info-label">
                                        Contact Number
                                    </span>


                                    <span class="student-info-value">

                                        {{ $profile
                                            ?->contact_number
                                            ?? 'Not provided'
                                        }}

                                    </span>


                                    <span class="student-info-helper">
                                        Student contact information
                                    </span>


                                </div>


                                <div class="student-info-item">


                                    <span class="student-info-label">
                                        Account Access
                                    </span>


                                    <span class="student-info-value">

                                        {{ ucfirst(
                                            $student->status
                                        ) }}

                                    </span>


                                    <span class="student-info-helper">

                                        {{ $student->isActive()
                                            ? 'OJT Portal login enabled'
                                            : 'OJT Portal login disabled'
                                        }}

                                    </span>


                                </div>


                            </div>


                            {{-- ==================================================
                                 OJT PLACEMENT
                                 ================================================== --}}

                            <div class="student-placement">


                                <div>


                                    <span class="student-placement-title">

                                        @if ($openAssignment)

                                            Current OJT Placement

                                        @else

                                            OJT Placement Availability

                                        @endif

                                    </span>


                                    <div class="student-placement-description">


                                        @if ($openAssignment)


                                            {{ $openAssignment
                                                ->company
                                                ?->name
                                                ?? 'Company unavailable'
                                            }}


                                            @if (
                                                $openAssignment
                                                    ->supervisor
                                            )

                                                · Supervisor:
                                                {{ $openAssignment
                                                    ->supervisor
                                                    ->name
                                                }}

                                            @endif


                                        @else


                                            No pending or active OJT Assignment.
                                            This account may be archived if it
                                            is no longer needed.

                                        @endif


                                    </div>


                                </div>


                                @if ($openAssignment)


                                    <span
                                        class="
                                            placement-badge
                                            placement-open
                                        "
                                    >

                                        {{ ucfirst(
                                            $openAssignment->status
                                        ) }}

                                    </span>


                                @else


                                    <span
                                        class="
                                            placement-badge
                                            placement-none
                                        "
                                    >
                                        No Open Placement
                                    </span>


                                @endif


                            </div>


                            {{-- ==================================================
                                 ACTIONS
                                 ================================================== --}}

                            <div class="student-record-actions">


                                <a
                                    href="{{ route(
                                        'admin.students.show',
                                        $student
                                    ) }}"
                                    class="
                                        student-action
                                        student-action-primary
                                    "
                                >
                                    View Student
                                </a>


                                <a
                                    href="{{ route(
                                        'admin.students.edit',
                                        $student
                                    ) }}"
                                    class="student-action"
                                >
                                    Edit Account
                                </a>


                                @if ($hasOpenAssignment)


                                    <button
                                        type="button"
                                        class="
                                            student-action
                                            student-action-disabled
                                        "
                                        disabled
                                        title="Complete or cancel the Student's pending or active OJT Assignment before archiving."
                                    >
                                        Archive Unavailable
                                    </button>


                                @else


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.students.archive',
                                            $student
                                        ) }}"
                                        class="student-action-form"
                                        onsubmit="
                                            return confirm(
                                                'Archive this Student account?\n\nStudent: {{ addslashes($student->name) }}\n\nThe account will become inactive and disappear from the normal Student list. Historical OJT records will remain preserved.'
                                            );
                                        "
                                    >

                                        @csrf
                                        @method('PATCH')


                                        <button
                                            type="submit"
                                            class="
                                                student-action
                                                student-action-archive
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
                class="students-filter-empty"
                id="students-filter-empty"
            >

                No Students match your
                current search or filter.

            </div>


            @if ($students->hasPages())


                <div class="students-pagination">

                    {{ $students->links() }}

                </div>


            @endif


        @else


            <div class="students-empty">


                <div class="students-empty-icon">
                    ST
                </div>


                <h3>
                    No Student Accounts
                </h3>


                <p>

                    Student accounts created by
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
            | Student Search + Filter
            |--------------------------------------------------------------------------
            */

            const searchInput =
                document.getElementById(
                    'students-search'
                );


            const statusFilter =
                document.getElementById(
                    'students-status-filter'
                );


            const records =
                Array.from(
                    document.querySelectorAll(
                        '[data-student-record]'
                    )
                );


            const visibleCount =
                document.getElementById(
                    'students-visible-count'
                );


            const emptyMessage =
                document.getElementById(
                    'students-filter-empty'
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


                            const hasOpenAssignment =
                                record
                                    .dataset
                                    .openAssignment
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


                            if (filter === 'open') {

                                matchesFilter =
                                    hasOpenAssignment;

                            }


                            if (filter === 'available') {

                                matchesFilter =
                                    ! hasOpenAssignment;

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
                                    ? ' Student shown'
                                    : ' Students shown'
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