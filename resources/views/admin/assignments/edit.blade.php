@extends('layouts.app')

@section('title', 'Edit OJT Assignment | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - EDIT OJT ASSIGNMENT
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --ae-navy: #183B6B;
        --ae-navy-dark: #102A4A;
        --ae-navy-deep: #0B223D;

        --ae-blue: #2563EB;
        --ae-blue-dark: #1D4ED8;
        --ae-blue-light: #60A5FA;
        --ae-blue-soft: #EAF2FF;

        --ae-teal: #0F766E;
        --ae-teal-dark: #0B5F59;
        --ae-teal-soft: #E7F7F5;

        --ae-green: #15803D;
        --ae-green-soft: #EAF8EF;

        --ae-orange: #B45309;
        --ae-orange-soft: #FFF5E6;

        --ae-red: #B42318;
        --ae-red-soft: #FFF0EE;

        --ae-purple: #6D4FC2;
        --ae-purple-soft: #F2EEFF;

        --ae-gray: #475569;
        --ae-gray-soft: #F1F5F9;

        --ae-text: #102A4A;
        --ae-body: #405872;
        --ae-muted: #64778C;

        --ae-white: #FFFFFF;
        --ae-soft: #F8FBFE;

        --ae-border: #D8E3EE;
        --ae-border-soft: #E7EDF4;

        --ae-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --ae-shadow-medium:
            0 18px 42px
            rgba(15, 42, 74, 0.10);

        --ae-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --ae-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .assignment-edit-page {
        width: 100%;

        color:
            var(--ae-text);

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

    .assignment-edit-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 29px;

        padding:
            43px
            44px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 89% 14%,
                rgba(96, 165, 250, 0.25),
                transparent 27%
            ),
            radial-gradient(
                circle at 71% 96%,
                rgba(45, 212, 191, 0.13),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #0B223D 0%,
                #102A4A 34%,
                #183B6B 67%,
                #17666B 100%
            );

        box-shadow:
            var(--ae-shadow-large);
    }


    .assignment-edit-hero::before {
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


    .assignment-edit-hero::after {
        content: "";

        position: absolute;

        width: 230px;
        height: 230px;

        right: 290px;
        bottom: -170px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.04);
    }


    .assignment-edit-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .assignment-edit-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 21px;
    }


    .assignment-edit-avatar {
        width: 88px;
        height: 88px;

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
    }


    .assignment-edit-eyebrow {
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


    .assignment-edit-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background:
            var(--ae-blue-light);

        box-shadow:
            0 0 0 5px
            rgba(96, 165, 250, 0.13);
    }


    .assignment-edit-hero h1 {
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


    .assignment-edit-hero-subtitle {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.80);

        font-size: 16px;

        line-height: 1.65;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .assignment-edit-hero-actions {
        width: 275px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .assignment-edit-hero-button {
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
            var(--ae-transition);
    }


    .assignment-edit-hero-primary {
        background:
            #FFFFFF;

        color:
            var(--ae-navy);
    }


    .assignment-edit-hero-primary:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;
    }


    .assignment-edit-hero-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .assignment-edit-hero-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    /* ================================================================
       MESSAGES
       ================================================================ */

    .assignment-edit-alert {
        margin-bottom: 22px;

        padding:
            17px
            19px;

        border-radius: 14px;

        font-size: 15px;
        font-weight: 650;

        line-height: 1.6;
    }


    .assignment-edit-alert-success {
        border:
            1px solid
            #CAE2D1;

        background:
            var(--ae-green-soft);

        color:
            var(--ae-green);
    }


    .assignment-edit-alert-error {
        border:
            1px solid
            #E8BEB8;

        background:
            var(--ae-red-soft);

        color:
            var(--ae-red);
    }


    .assignment-edit-errors {
        margin-bottom: 22px;

        padding:
            18px
            20px;

        border:
            1px solid
            #E8BEB8;

        border-radius: 14px;

        background:
            var(--ae-red-soft);

        color:
            var(--ae-red);
    }


    .assignment-edit-errors strong {
        display: block;

        margin-bottom: 7px;

        font-size: 16px;
        font-weight: 900;
    }


    .assignment-edit-errors ul {
        margin: 0;

        padding-left: 22px;
    }


    .assignment-edit-errors li {
        margin:
            3px
            0;

        font-size: 14px;
        font-weight: 650;
    }


    /* ================================================================
       LAYOUT
       ================================================================ */

    .assignment-edit-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            355px;

        gap: 24px;

        align-items: start;
    }


    .assignment-edit-main,
    .assignment-edit-sidebar {
        display: grid;

        gap: 22px;
    }


    /* ================================================================
       PANEL
       ================================================================ */

    .assignment-edit-panel {
        overflow: hidden;

        border:
            1px solid
            var(--ae-border);

        border-radius: 20px;

        background:
            #FFFFFF;

        box-shadow:
            var(--ae-shadow);
    }


    .assignment-edit-panel-header {
        display: flex;
        align-items: center;

        gap: 14px;

        padding:
            22px
            23px;

        border-bottom:
            1px solid
            var(--ae-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .assignment-edit-panel-icon {
        width: 48px;
        height: 48px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        font-size: 12px;
        font-weight: 900;
    }


    .panel-blue {
        background:
            var(--ae-blue-soft);

        color:
            var(--ae-blue);
    }


    .panel-teal {
        background:
            var(--ae-teal-soft);

        color:
            var(--ae-teal);
    }


    .panel-purple {
        background:
            var(--ae-purple-soft);

        color:
            var(--ae-purple);
    }


    .panel-orange {
        background:
            var(--ae-orange-soft);

        color:
            var(--ae-orange);
    }


    .assignment-edit-panel-header h2 {
        margin:
            0
            0
            3px;

        color:
            var(--ae-text);

        font-size: 23px;
        font-weight: 900;

        line-height: 1.3;
    }


    .assignment-edit-panel-header p {
        margin: 0;

        color:
            var(--ae-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .assignment-edit-panel-body {
        padding: 24px;
    }


    /* ================================================================
       FORM GRID
       ================================================================ */

    .assignment-edit-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            21px
            20px;
    }


    .assignment-edit-field {
        display: grid;

        gap: 7px;
    }


    .assignment-edit-field-full {
        grid-column:
            1 / -1;
    }


    .assignment-edit-label {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        color:
            var(--ae-text);

        font-size: 15px;
        font-weight: 850;
    }


    .assignment-edit-required {
        color:
            var(--ae-red);

        font-size: 13px;
        font-weight: 800;
    }


    .assignment-edit-optional {
        color:
            var(--ae-muted);

        font-size: 13px;
        font-weight: 700;
    }


    .assignment-edit-input,
    .assignment-edit-select,
    .assignment-edit-textarea {
        width: 100%;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background:
            #FBFDFF;

        color:
            var(--ae-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;

        transition:
            var(--ae-transition);
    }


    .assignment-edit-input,
    .assignment-edit-select {
        min-height: 57px;
    }


    .assignment-edit-input {
        padding:
            0
            15px;
    }


    .assignment-edit-select {
        padding:
            0
            14px;

        cursor: pointer;
    }


    .assignment-edit-textarea {
        min-height: 145px;

        padding:
            14px
            15px;

        resize: vertical;

        line-height: 1.65;
    }


    .assignment-edit-input::placeholder,
    .assignment-edit-textarea::placeholder {
        color:
            #8999AA;

        font-weight: 500;
    }


    .assignment-edit-input:focus,
    .assignment-edit-select:focus,
    .assignment-edit-textarea:focus {
        border-color:
            var(--ae-blue);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, 0.08);
    }


    .assignment-edit-input.is-invalid,
    .assignment-edit-select.is-invalid,
    .assignment-edit-textarea.is-invalid {
        border-color:
            var(--ae-red);

        background:
            #FFFDFD;
    }


    .assignment-edit-help {
        color:
            var(--ae-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .assignment-edit-error {
        color:
            var(--ae-red);

        font-size: 14px;
        font-weight: 750;

        line-height: 1.5;
    }


    /* ================================================================
       SELECTION PREVIEW
       ================================================================ */

    .assignment-selection-preview {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 12px;

        margin-top: 19px;
    }


    .assignment-preview-card {
        padding: 15px;

        border:
            1px solid
            var(--ae-border-soft);

        border-radius: 12px;

        background:
            var(--ae-soft);
    }


    .assignment-preview-card span {
        display: block;

        margin-bottom: 3px;

        color:
            var(--ae-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform:
            uppercase;
    }


    .assignment-preview-card strong {
        display: block;

        color:
            var(--ae-text);

        font-size: 15px;
        font-weight: 900;

        line-height: 1.5;

        word-break:
            break-word;
    }


    /* ================================================================
       STATUS GUIDANCE
       ================================================================ */

    .assignment-status-guidance {
        margin-top: 17px;

        padding: 17px;

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


    .assignment-status-guidance strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--ae-teal);

        font-size: 16px;
        font-weight: 900;
    }


    .assignment-status-guidance p {
        margin: 0;

        color:
            var(--ae-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       SAFETY NOTICE
       ================================================================ */

    .assignment-safety-notice {
        padding:
            17px
            18px;

        border:
            1px solid
            #ECD7B8;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #FFFCF7,
                #FFF7E9
            );
    }


    .assignment-safety-notice strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--ae-orange);

        font-size: 17px;
        font-weight: 900;
    }


    .assignment-safety-notice p {
        margin: 0;

        color:
            var(--ae-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       ACTIONS
       ================================================================ */

    .assignment-edit-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 10px;

        margin-top: 25px;

        padding-top: 21px;

        border-top:
            1px solid
            var(--ae-border-soft);
    }


    .assignment-edit-button {
        min-height: 52px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            20px;

        border:
            1px solid
            var(--ae-border);

        border-radius: 11px;

        font-family: inherit;

        font-size: 15px;
        font-weight: 900;

        text-align: center;

        text-decoration: none;

        cursor: pointer;

        transition:
            var(--ae-transition);
    }


    .assignment-edit-button-secondary {
        background:
            #FFFFFF;

        color:
            var(--ae-navy);
    }


    .assignment-edit-button-secondary:hover {
        background:
            var(--ae-blue-soft);
    }


    .assignment-edit-button-primary {
        min-width: 215px;

        border-color:
            var(--ae-blue);

        background:
            var(--ae-blue);

        color:
            #FFFFFF;
    }


    .assignment-edit-button-primary:hover {
        transform:
            translateY(-1px);

        border-color:
            var(--ae-blue-dark);

        background:
            var(--ae-blue-dark);
    }


    .assignment-edit-button-primary:disabled {
        border-color:
            #8294A7;

        background:
            #8294A7;

        cursor: wait;

        transform: none;
    }


    /* ================================================================
       STATUS BADGE
       ================================================================ */

    .assignment-current-status {
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


    .assignment-current-status::before {
        content: "";

        width: 8px;
        height: 8px;

        border-radius: 50%;
    }


    .status-pending {
        background:
            var(--ae-orange-soft);

        color:
            var(--ae-orange);
    }


    .status-pending::before {
        background:
            #F59E0B;
    }


    .status-active {
        background:
            var(--ae-green-soft);

        color:
            var(--ae-green);
    }


    .status-active::before {
        background:
            #22C55E;
    }


    .status-completed {
        background:
            var(--ae-teal-soft);

        color:
            var(--ae-teal);
    }


    .status-completed::before {
        background:
            #14B8A6;
    }


    .status-cancelled {
        background:
            var(--ae-red-soft);

        color:
            var(--ae-red);
    }


    .status-cancelled::before {
        background:
            #D92D20;
    }


    .status-other {
        background:
            var(--ae-gray-soft);

        color:
            var(--ae-gray);
    }


    .status-other::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       SIDEBAR
       ================================================================ */

    .assignment-sidebar-list {
        display: grid;

        gap: 11px;
    }


    .assignment-sidebar-item {
        padding: 14px;

        border:
            1px solid
            var(--ae-border-soft);

        border-radius: 11px;

        background:
            var(--ae-soft);
    }


    .assignment-sidebar-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--ae-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform:
            uppercase;

        letter-spacing:
            .2px;
    }


    .assignment-sidebar-value {
        display: block;

        color:
            var(--ae-text);

        font-size: 16px;
        font-weight: 900;

        line-height: 1.5;

        word-break:
            break-word;
    }


    /* ================================================================
       WORKFLOW
       ================================================================ */

    .assignment-workflow-box {
        padding: 18px;

        border:
            1px solid
            #D7E4F1;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #FBFDFF,
                #F3F8FD
            );
    }


    .assignment-workflow-box strong {
        display: block;

        margin-bottom: 6px;

        color:
            var(--ae-blue);

        font-size: 17px;
        font-weight: 900;
    }


    .assignment-workflow-box p {
        margin: 0;

        color:
            var(--ae-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       READ-ONLY WARNING
       ================================================================ */

    .assignment-closed-warning {
        margin-bottom: 22px;

        padding:
            18px
            19px;

        border:
            1px solid
            #D9E4EE;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #FBFDFF,
                #F5F8FB
            );
    }


    .assignment-closed-warning strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--ae-navy);

        font-size: 17px;
        font-weight: 900;
    }


    .assignment-closed-warning p {
        margin: 0;

        color:
            var(--ae-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1100px) {

        .assignment-edit-layout {
            grid-template-columns:
                1fr;
        }


        .assignment-edit-sidebar {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 900px) {

        .assignment-edit-hero-inner {
            flex-direction:
                column;

            align-items:
                flex-start;
        }


        .assignment-edit-hero-actions {
            width: 100%;
        }


        .assignment-selection-preview {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 760px) {

        .assignment-edit-grid {
            grid-template-columns:
                1fr;
        }


        .assignment-edit-field-full {
            grid-column:
                auto;
        }


        .assignment-edit-sidebar {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 650px) {

        .assignment-edit-hero {
            padding:
                29px
                22px;

            border-radius:
                22px;
        }


        .assignment-edit-identity {
            align-items:
                flex-start;
        }


        .assignment-edit-avatar {
            width: 67px;
            height: 67px;

            border-radius:
                19px;

            font-size:
                20px;
        }


        .assignment-edit-hero h1 {
            font-size:
                30px;
        }


        .assignment-edit-actions {
            display: grid;

            grid-template-columns:
                1fr;
        }


        .assignment-edit-button {
            width: 100%;
        }

    }

</style>

@endpush


@section('content')


@php

    /* ================================================================
       CURRENT RELATED RECORDS
       ================================================================ */

    $currentProfile =
        $assignment->studentProfile;


    $currentStudent =
        $currentProfile?->user;


    $currentCompany =
        $assignment->company;


    $currentSupervisor =
        $assignment->supervisor;


    $studentName =
        $currentStudent?->name
        ?? 'Student unavailable';


    $companyName =
        $currentCompany?->name
        ?? 'Company unavailable';


    $supervisorName =
        $currentSupervisor?->name
        ?? 'Supervisor unavailable';


    /* ================================================================
       OPTION COLLECTIONS
       ================================================================
       This supports either $students or $studentProfiles depending on
       how the existing Assignment controller names the collection.
       ================================================================ */

    $studentOptions =
        collect(
            $students
            ?? $studentProfiles
            ?? []
        );


    $companyOptions =
        collect(
            $companies
            ?? []
        );


    $supervisorOptions =
        collect(
            $supervisors
            ?? []
        );


    /* ================================================================
       INITIALS
       ================================================================ */

    $studentInitials =
        collect(
            preg_split(
                '/\s+/',
                trim(
                    (string)
                    $studentName
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


    /* ================================================================
       STATUS
       ================================================================ */

    $currentStatus =
        strtolower(
            trim(
                (string)
                $assignment->status
            )
        );


    $statusClass =
        match ($currentStatus) {

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


    /*
    |--------------------------------------------------------------------------
    | Closed Assignment
    |--------------------------------------------------------------------------
    |
    | Completed and cancelled assignments are historical records.
    | The page still displays their information safely.
    |
    */

    $isClosedAssignment =
        in_array(
            $currentStatus,
            [
                'completed',
                'cancelled',
            ],
            true
        );


    /* ================================================================
       DATE INPUT FORMATTER
       ================================================================ */

    $dateInput =
        function ($date) {

            if (! $date) {
                return '';
            }


            try {

                return
                    \Illuminate\Support\Carbon::parse(
                        $date
                    )
                        ->format(
                            'Y-m-d'
                        );

            } catch (\Throwable $exception) {

                return '';

            }

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


    /* ================================================================
       SELECTED VALUES
       ================================================================ */

    $selectedProfileId =
        (string)
        old(
            'student_profile_id',
            $assignment->student_profile_id
        );


    $selectedCompanyId =
        (string)
        old(
            'company_id',
            $assignment->company_id
        );


    $selectedSupervisorId =
        (string)
        old(
            'supervisor_id',
            $assignment->supervisor_id
        );

@endphp


<div class="assignment-edit-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="assignment-edit-hero">


        <div class="assignment-edit-hero-inner">


            <div class="assignment-edit-identity">


                <div class="assignment-edit-avatar">
                    {{ $studentInitials }}
                </div>


                <div>


                    <div class="assignment-edit-eyebrow">

                        <span class="assignment-edit-dot"></span>

                        Administrator · OJT Placement Editor

                    </div>


                    <h1>
                        Edit OJT Assignment
                    </h1>


                    <p class="assignment-edit-hero-subtitle">

                        {{ $studentName }}

                        ·

                        {{ $companyName }}

                        ·

                        Assignment #{{ $assignment->id }}

                    </p>


                </div>


            </div>


            <div class="assignment-edit-hero-actions">


                <a
                    href="{{ route(
                        'admin.assignments.show',
                        $assignment
                    ) }}"
                    class="
                        assignment-edit-hero-button
                        assignment-edit-hero-primary
                    "
                >
                    View Assignment Record
                </a>


                <a
                    href="{{ route(
                        'admin.assignments.index'
                    ) }}"
                    class="
                        assignment-edit-hero-button
                        assignment-edit-hero-secondary
                    "
                >
                    Back to Assignments
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
                assignment-edit-alert
                assignment-edit-alert-success
            "
        >
            {{ session('success') }}
        </div>

    @endif


    @if (session('error'))

        <div
            class="
                assignment-edit-alert
                assignment-edit-alert-error
            "
        >
            {{ session('error') }}
        </div>

    @endif


    @if ($errors->any())


        <div class="assignment-edit-errors">


            <strong>
                Please review the assignment information below.
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
         HISTORICAL WARNING
         ================================================================== --}}

    @if ($isClosedAssignment)


        <div class="assignment-closed-warning">


            <strong>
                This is a {{ ucfirst($currentStatus) }} OJT Assignment.
            </strong>


            <p>

                Completed and cancelled assignments are important
                historical OJT records. Review changes carefully
                because attendance, Daily Work Logs, Supervisor
                evaluation, and completion history may already
                reference this placement.

            </p>


        </div>


    @endif


    {{-- ==================================================================
         FORM
         ================================================================== --}}

    <form
        id="assignment-edit-form"
        method="POST"
        action="{{ route(
            'admin.assignments.update',
            $assignment
        ) }}"
    >

        @csrf
        @method('PUT')


        <div class="assignment-edit-layout">


            {{-- ==============================================================
                 MAIN
                 ============================================================== --}}

            <main class="assignment-edit-main">


                {{-- ==========================================================
                     PLACEMENT PARTIES
                     ========================================================== --}}

                <section class="assignment-edit-panel">


                    <div class="assignment-edit-panel-header">


                        <div
                            class="
                                assignment-edit-panel-icon
                                panel-blue
                            "
                        >
                            PL
                        </div>


                        <div>

                            <h2>
                                OJT Placement Parties
                            </h2>

                            <p>
                                Review the Student, Company,
                                and Supervisor connected to this placement.
                            </p>

                        </div>


                    </div>


                    <div class="assignment-edit-panel-body">


                        <div class="assignment-edit-grid">


                            {{-- ==================================================
                                 STUDENT
                                 ================================================== --}}

                            <div
                                class="
                                    assignment-edit-field
                                    assignment-edit-field-full
                                "
                            >


                                <label
                                    for="student_profile_id"
                                    class="assignment-edit-label"
                                >

                                    <span>
                                        Student
                                    </span>

                                    <span class="assignment-edit-required">
                                        Required
                                    </span>

                                </label>


                                <select
                                    id="student_profile_id"
                                    name="student_profile_id"
                                    class="
                                        assignment-edit-select
                                        @error('student_profile_id')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                >


                                    <option value="">
                                        Select a Student
                                    </option>


                                    @foreach ($studentOptions as $studentOption)


                                        @php

                                            /*
                                            |--------------------------------------------------------------------------
                                            | Support StudentProfile collection
                                            |--------------------------------------------------------------------------
                                            */

                                            if (
                                                $studentOption
                                                instanceof
                                                \App\Models\StudentProfile
                                            ) {

                                                $optionProfile =
                                                    $studentOption;

                                                $optionStudent =
                                                    $studentOption->user;

                                            } else {

                                                /*
                                                |--------------------------------------------------------------------------
                                                | Support User collection
                                                |--------------------------------------------------------------------------
                                                */

                                                $optionStudent =
                                                    $studentOption;

                                                $optionProfile =
                                                    $studentOption
                                                        ->studentProfile
                                                    ?? null;

                                            }


                                            $optionProfileId =
                                                $optionProfile?->id;


                                            $optionStudentName =
                                                $optionStudent?->name
                                                ?? 'Unnamed Student';


                                            $optionStudentNumber =
                                                $optionProfile
                                                    ?->student_number;


                                            $optionProgram =
                                                $optionProfile
                                                    ?->program;

                                        @endphp


                                        @if ($optionProfileId)


                                            <option
                                                value="{{ $optionProfileId }}"
                                                @selected(
                                                    $selectedProfileId
                                                    ===
                                                    (string)
                                                    $optionProfileId
                                                )
                                            >

                                                {{ $optionStudentName }}

                                                @if (
                                                    filled(
                                                        $optionStudentNumber
                                                    )
                                                )

                                                    —
                                                    {{ $optionStudentNumber }}

                                                @endif


                                                @if (
                                                    filled(
                                                        $optionProgram
                                                    )
                                                )

                                                    · {{ $optionProgram }}

                                                @endif

                                            </option>


                                        @endif


                                    @endforeach


                                    @if (
                                        $currentProfile
                                        &&
                                        ! $studentOptions
                                            ->contains(
                                                function ($option) use (
                                                    $assignment
                                                ) {

                                                    if (
                                                        $option
                                                        instanceof
                                                        \App\Models\StudentProfile
                                                    ) {

                                                        return
                                                            (int)
                                                            $option->id
                                                            ===
                                                            (int)
                                                            $assignment
                                                                ->student_profile_id;

                                                    }


                                                    return
                                                        (int)
                                                        (
                                                            $option
                                                                ->studentProfile
                                                                ?->id
                                                            ?? 0
                                                        )
                                                        ===
                                                        (int)
                                                        $assignment
                                                            ->student_profile_id;

                                                }
                                            )
                                    )


                                        <option
                                            value="{{ $currentProfile->id }}"
                                            @selected(
                                                $selectedProfileId
                                                ===
                                                (string)
                                                $currentProfile->id
                                            )
                                        >

                                            {{ $studentName }}

                                            @if (
                                                filled(
                                                    $currentProfile
                                                        ->student_number
                                                )
                                            )

                                                —
                                                {{ $currentProfile->student_number }}

                                            @endif

                                        </option>


                                    @endif


                                </select>


                                <span class="assignment-edit-help">

                                    Choose the Student Profile that
                                    owns this OJT placement.

                                    Reassigning a Student on an existing
                                    placement should only be done when
                                    you are certain the historical records
                                    still belong to the selected Student.

                                </span>


                                @error('student_profile_id')

                                    <span class="assignment-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 COMPANY
                                 ================================================== --}}

                            <div class="assignment-edit-field">


                                <label
                                    for="company_id"
                                    class="assignment-edit-label"
                                >

                                    <span>
                                        Partner Company
                                    </span>

                                    <span class="assignment-edit-required">
                                        Required
                                    </span>

                                </label>


                                <select
                                    id="company_id"
                                    name="company_id"
                                    class="
                                        assignment-edit-select
                                        @error('company_id')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                >


                                    <option value="">
                                        Select a Company
                                    </option>


                                    @foreach ($companyOptions as $companyOption)


                                        <option
                                            value="{{ $companyOption->id }}"
                                            @selected(
                                                $selectedCompanyId
                                                ===
                                                (string)
                                                $companyOption->id
                                            )
                                        >

                                            {{ $companyOption->name }}

                                            @if (
                                                filled(
                                                    $companyOption->status
                                                )
                                            )

                                                —
                                                {{ ucfirst(
                                                    $companyOption->status
                                                ) }}

                                            @endif

                                        </option>


                                    @endforeach


                                    @if (
                                        $currentCompany
                                        &&
                                        ! $companyOptions
                                            ->contains(
                                                'id',
                                                $currentCompany->id
                                            )
                                    )


                                        <option
                                            value="{{ $currentCompany->id }}"
                                            @selected(
                                                $selectedCompanyId
                                                ===
                                                (string)
                                                $currentCompany->id
                                            )
                                        >

                                            {{ $currentCompany->name }}

                                        </option>


                                    @endif


                                </select>


                                <span class="assignment-edit-help">

                                    Select the establishment where
                                    the Student performs their OJT.

                                </span>


                                @error('company_id')

                                    <span class="assignment-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 SUPERVISOR
                                 ================================================== --}}

                            <div class="assignment-edit-field">


                                <label
                                    for="supervisor_id"
                                    class="assignment-edit-label"
                                >

                                    <span>
                                        Assigned Supervisor
                                    </span>

                                    <span class="assignment-edit-required">
                                        Required
                                    </span>

                                </label>


                                <select
                                    id="supervisor_id"
                                    name="supervisor_id"
                                    class="
                                        assignment-edit-select
                                        @error('supervisor_id')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                >


                                    <option value="">
                                        Select a Supervisor
                                    </option>


                                    @foreach ($supervisorOptions as $supervisorOption)


                                        <option
                                            value="{{ $supervisorOption->id }}"
                                            @selected(
                                                $selectedSupervisorId
                                                ===
                                                (string)
                                                $supervisorOption->id
                                            )
                                        >

                                            {{ $supervisorOption->name }}

                                            @if (
                                                filled(
                                                    $supervisorOption->email
                                                )
                                            )

                                                —
                                                {{ $supervisorOption->email }}

                                            @endif

                                        </option>


                                    @endforeach


                                    @if (
                                        $currentSupervisor
                                        &&
                                        ! $supervisorOptions
                                            ->contains(
                                                'id',
                                                $currentSupervisor->id
                                            )
                                    )


                                        <option
                                            value="{{ $currentSupervisor->id }}"
                                            @selected(
                                                $selectedSupervisorId
                                                ===
                                                (string)
                                                $currentSupervisor->id
                                            )
                                        >

                                            {{ $currentSupervisor->name }}

                                        </option>


                                    @endif


                                </select>


                                <span class="assignment-edit-help">

                                    The Supervisor is responsible
                                    for monitoring, validation, and
                                    final Student evaluation.

                                </span>


                                @error('supervisor_id')

                                    <span class="assignment-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                        </div>


                        {{-- ======================================================
                             CURRENT CONNECTION PREVIEW
                             ====================================================== --}}

                        <div class="assignment-selection-preview">


                            <div class="assignment-preview-card">

                                <span>
                                    Current Student
                                </span>

                                <strong>
                                    {{ $studentName }}
                                </strong>

                            </div>


                            <div class="assignment-preview-card">

                                <span>
                                    Current Company
                                </span>

                                <strong>
                                    {{ $companyName }}
                                </strong>

                            </div>


                            <div class="assignment-preview-card">

                                <span>
                                    Current Supervisor
                                </span>

                                <strong>
                                    {{ $supervisorName }}
                                </strong>

                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     HOURS + SCHEDULE
                     ========================================================== --}}

                <section class="assignment-edit-panel">


                    <div class="assignment-edit-panel-header">


                        <div
                            class="
                                assignment-edit-panel-icon
                                panel-purple
                            "
                        >
                            SC
                        </div>


                        <div>

                            <h2>
                                OJT Hours & Placement Schedule
                            </h2>

                            <p>
                                Configure the required training hours
                                and official placement period.
                            </p>

                        </div>


                    </div>


                    <div class="assignment-edit-panel-body">


                        <div class="assignment-edit-grid">


                            {{-- ==================================================
                                 REQUIRED HOURS
                                 ================================================== --}}

                            <div
                                class="
                                    assignment-edit-field
                                    assignment-edit-field-full
                                "
                            >


                                <label
                                    for="required_hours"
                                    class="assignment-edit-label"
                                >

                                    <span>
                                        Required OJT Hours
                                    </span>

                                    <span class="assignment-edit-required">
                                        Required
                                    </span>

                                </label>


                                <input
                                    type="number"
                                    id="required_hours"
                                    name="required_hours"
                                    value="{{ old(
                                        'required_hours',
                                        $assignment->required_hours
                                    ) }}"
                                    class="
                                        assignment-edit-input
                                        @error('required_hours')
                                            is-invalid
                                        @enderror
                                    "
                                    min="1"
                                    step="1"
                                    required
                                    inputmode="numeric"
                                    placeholder="Enter required OJT hours"
                                >


                                <span class="assignment-edit-help">

                                    Enter the total number of hours
                                    the Student must complete for this
                                    placement.

                                </span>


                                @error('required_hours')

                                    <span class="assignment-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 START DATE
                                 ================================================== --}}

                            <div class="assignment-edit-field">


                                <label
                                    for="start_date"
                                    class="assignment-edit-label"
                                >

                                    <span>
                                        Start Date
                                    </span>

                                    <span class="assignment-edit-required">
                                        Required
                                    </span>

                                </label>


                                <input
                                    type="date"
                                    id="start_date"
                                    name="start_date"
                                    value="{{ old(
                                        'start_date',
                                        $dateInput(
                                            $assignment->start_date
                                        )
                                    ) }}"
                                    class="
                                        assignment-edit-input
                                        @error('start_date')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                >


                                <span class="assignment-edit-help">
                                    Official beginning of the OJT placement.
                                </span>


                                @error('start_date')

                                    <span class="assignment-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 END DATE
                                 ================================================== --}}

                            <div class="assignment-edit-field">


                                <label
                                    for="end_date"
                                    class="assignment-edit-label"
                                >

                                    <span>
                                        End Date
                                    </span>

                                    <span class="assignment-edit-required">
                                        Required
                                    </span>

                                </label>


                                <input
                                    type="date"
                                    id="end_date"
                                    name="end_date"
                                    value="{{ old(
                                        'end_date',
                                        $dateInput(
                                            $assignment->end_date
                                        )
                                    ) }}"
                                    class="
                                        assignment-edit-input
                                        @error('end_date')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                >


                                <span class="assignment-edit-help">
                                    Official scheduled end of the OJT placement.
                                </span>


                                @error('end_date')

                                    <span class="assignment-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     STATUS + NOTES
                     ========================================================== --}}

                <section class="assignment-edit-panel">


                    <div class="assignment-edit-panel-header">


                        <div
                            class="
                                assignment-edit-panel-icon
                                panel-teal
                            "
                        >
                            ST
                        </div>


                        <div>

                            <h2>
                                Status & Administrative Notes
                            </h2>

                            <p>
                                Maintain the placement's workflow state
                                and internal notes.
                            </p>

                        </div>


                    </div>


                    <div class="assignment-edit-panel-body">


                        <div class="assignment-edit-grid">


                            {{-- ==================================================
                                 STATUS
                                 ================================================== --}}

                            <div
                                class="
                                    assignment-edit-field
                                    assignment-edit-field-full
                                "
                            >


                                <label
                                    for="status"
                                    class="assignment-edit-label"
                                >

                                    <span>
                                        Assignment Status
                                    </span>

                                    <span class="assignment-edit-required">
                                        Required
                                    </span>

                                </label>


                                <select
                                    id="status"
                                    name="status"
                                    class="
                                        assignment-edit-select
                                        @error('status')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                >


                                    <option
                                        value="pending"
                                        @selected(
                                            old(
                                                'status',
                                                $assignment->status
                                            )
                                            ===
                                            'pending'
                                        )
                                    >
                                        Pending — Placement prepared but not yet active
                                    </option>


                                    <option
                                        value="active"
                                        @selected(
                                            old(
                                                'status',
                                                $assignment->status
                                            )
                                            ===
                                            'active'
                                        )
                                    >
                                        Active — OJT monitoring currently in progress
                                    </option>


                                    @if (
                                        $currentStatus === 'completed'
                                    )

                                        <option
                                            value="completed"
                                            selected
                                        >
                                            Completed — Historical completed placement
                                        </option>

                                    @endif


                                    <option
                                        value="cancelled"
                                        @selected(
                                            old(
                                                'status',
                                                $assignment->status
                                            )
                                            ===
                                            'cancelled'
                                        )
                                    >
                                        Cancelled — Placement no longer proceeding
                                    </option>


                                </select>


                                <div class="assignment-status-guidance">


                                    <strong>
                                        Assignment Lifecycle
                                    </strong>


                                    <p>

                                        <strong>Pending</strong>
                                        means the placement has been prepared
                                        but monitoring has not formally started.

                                        <strong>Active</strong>
                                        means attendance, Daily Work Logs,
                                        and Supervisor monitoring are ongoing.

                                        <strong>Cancelled</strong>
                                        keeps the placement record while
                                        ending the normal OJT workflow.

                                        Completed placements should remain
                                        historical records and should not
                                        normally be reopened from this editor.

                                    </p>


                                </div>


                                @error('status')

                                    <span class="assignment-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                            {{-- ==================================================
                                 NOTES
                                 ================================================== --}}

                            <div
                                class="
                                    assignment-edit-field
                                    assignment-edit-field-full
                                "
                            >


                                <label
                                    for="notes"
                                    class="assignment-edit-label"
                                >

                                    <span>
                                        Administrative Notes
                                    </span>

                                    <span class="assignment-edit-optional">
                                        Optional
                                    </span>

                                </label>


                                <textarea
                                    id="notes"
                                    name="notes"
                                    class="
                                        assignment-edit-textarea
                                        @error('notes')
                                            is-invalid
                                        @enderror
                                    "
                                    placeholder="Enter important placement notes or administrative remarks..."
                                >{{ old(
                                    'notes',
                                    $assignment->notes
                                ) }}</textarea>


                                <span class="assignment-edit-help">

                                    Record information that helps
                                    explain this placement. Avoid placing
                                    passwords or other sensitive credentials
                                    in this field.

                                </span>


                                @error('notes')

                                    <span class="assignment-edit-error">
                                        {{ $message }}
                                    </span>

                                @enderror


                            </div>


                        </div>


                        {{-- ======================================================
                             ACTIONS
                             ====================================================== --}}

                        <div class="assignment-edit-actions">


                            <a
                                href="{{ route(
                                    'admin.assignments.show',
                                    $assignment
                                ) }}"
                                class="
                                    assignment-edit-button
                                    assignment-edit-button-secondary
                                "
                            >
                                Cancel
                            </a>


                            <button
                                type="submit"
                                id="assignment-edit-submit"
                                class="
                                    assignment-edit-button
                                    assignment-edit-button-primary
                                "
                            >
                                Save Assignment Changes
                            </button>


                        </div>


                    </div>


                </section>


            </main>


            {{-- ==============================================================
                 SIDEBAR
                 ============================================================== --}}

            <aside class="assignment-edit-sidebar">


                {{-- ==========================================================
                     RECORD SUMMARY
                     ========================================================== --}}

                <section class="assignment-edit-panel">


                    <div class="assignment-edit-panel-header">


                        <div
                            class="
                                assignment-edit-panel-icon
                                panel-blue
                            "
                        >
                            RC
                        </div>


                        <div>

                            <h2>
                                Assignment Summary
                            </h2>

                            <p>
                                Current placement record
                            </p>

                        </div>


                    </div>


                    <div class="assignment-edit-panel-body">


                        <div class="assignment-sidebar-list">


                            <div class="assignment-sidebar-item">


                                <span class="assignment-sidebar-label">
                                    Assignment ID
                                </span>


                                <span class="assignment-sidebar-value">
                                    #{{ $assignment->id }}
                                </span>


                            </div>


                            <div class="assignment-sidebar-item">


                                <span class="assignment-sidebar-label">
                                    Current Status
                                </span>


                                <span
                                    class="
                                        assignment-current-status
                                        {{ $statusClass }}
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


                            </div>


                            <div class="assignment-sidebar-item">


                                <span class="assignment-sidebar-label">
                                    Student
                                </span>


                                <span class="assignment-sidebar-value">
                                    {{ $studentName }}
                                </span>


                            </div>


                            <div class="assignment-sidebar-item">


                                <span class="assignment-sidebar-label">
                                    Student Number
                                </span>


                                <span class="assignment-sidebar-value">

                                    {{ $currentProfile
                                        ?->student_number
                                        ?? 'Not provided'
                                    }}

                                </span>


                            </div>


                            <div class="assignment-sidebar-item">


                                <span class="assignment-sidebar-label">
                                    Partner Company
                                </span>


                                <span class="assignment-sidebar-value">
                                    {{ $companyName }}
                                </span>


                            </div>


                            <div class="assignment-sidebar-item">


                                <span class="assignment-sidebar-label">
                                    Supervisor
                                </span>


                                <span class="assignment-sidebar-value">
                                    {{ $supervisorName }}
                                </span>


                            </div>


                            <div class="assignment-sidebar-item">


                                <span class="assignment-sidebar-label">
                                    Required Hours
                                </span>


                                <span class="assignment-sidebar-value">

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


                            <div class="assignment-sidebar-item">


                                <span class="assignment-sidebar-label">
                                    Placement Period
                                </span>


                                <span class="assignment-sidebar-value">

                                    {{ $formatDate(
                                        $assignment->start_date
                                    ) }}

                                    —

                                    {{ $formatDate(
                                        $assignment->end_date
                                    ) }}

                                </span>


                            </div>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     SAFETY
                     ========================================================== --}}

                <section class="assignment-edit-panel">


                    <div class="assignment-edit-panel-body">


                        <div class="assignment-safety-notice">


                            <strong>
                                Edit Existing Placements Carefully
                            </strong>


                            <p>

                                This Assignment may already be linked
                                to Student attendance records, GPS selfie
                                submissions, Daily Work Logs, Supervisor
                                validation, and evaluation history.

                                Changing the Student, Company, or Supervisor
                                changes important placement context, so verify
                                the information before saving.

                            </p>


                        </div>


                    </div>


                </section>


                {{-- ==========================================================
                     WORKFLOW
                     ========================================================== --}}

                <section class="assignment-edit-panel">


                    <div class="assignment-edit-panel-header">


                        <div
                            class="
                                assignment-edit-panel-icon
                                panel-purple
                            "
                        >
                            WF
                        </div>


                        <div>

                            <h2>
                                OJT Workflow
                            </h2>

                            <p>
                                Placement context
                            </p>

                        </div>


                    </div>


                    <div class="assignment-edit-panel-body">


                        <div class="assignment-workflow-box">


                            <strong>
                                Central OJT Record
                            </strong>


                            <p>

                                The Assignment connects the Student,
                                Company, and Supervisor and establishes
                                the context used throughout attendance,
                                work-log monitoring, validation,
                                final evaluation, and completion.

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
            | Placement Date Protection
            |--------------------------------------------------------------------------
            */

            const startDate =
                document.getElementById(
                    'start_date'
                );


            const endDate =
                document.getElementById(
                    'end_date'
                );


            function synchronizeDates() {

                if (
                    ! startDate
                    ||
                    ! endDate
                ) {
                    return;
                }


                if (
                    startDate.value
                ) {

                    endDate.min =
                        startDate.value;

                } else {

                    endDate.removeAttribute(
                        'min'
                    );

                }


                if (
                    startDate.value
                    &&
                    endDate.value
                    &&
                    endDate.value
                    <
                    startDate.value
                ) {

                    endDate.setCustomValidity(
                        'End Date cannot be earlier than Start Date.'
                    );

                } else {

                    endDate.setCustomValidity(
                        ''
                    );

                }

            }


            if (startDate) {

                startDate.addEventListener(
                    'change',
                    synchronizeDates
                );

            }


            if (endDate) {

                endDate.addEventListener(
                    'change',
                    synchronizeDates
                );

            }


            synchronizeDates();


            /*
            |--------------------------------------------------------------------------
            | Prevent Accidental Double Submission
            |--------------------------------------------------------------------------
            */

            const form =
                document.getElementById(
                    'assignment-edit-form'
                );


            const submitButton =
                document.getElementById(
                    'assignment-edit-submit'
                );


            if (
                form
                &&
                submitButton
            ) {

                form.addEventListener(
                    'submit',
                    function () {

                        synchronizeDates();


                        if (! form.checkValidity()) {
                            return;
                        }


                        submitButton.disabled =
                            true;


                        submitButton.textContent =
                            'Saving Assignment...';

                    }
                );

            }

        }
    );

</script>

@endpush