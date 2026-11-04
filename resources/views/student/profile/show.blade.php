@extends('layouts.app')


@section('title', 'My Student Profile | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC STUDENT PROFILE
       READABILITY-FIRST PROFESSIONAL DESIGN
       ================================================================ */

    :root {
        --profile-navy: #183B6B;
        --profile-navy-dark: #102A4A;

        --profile-blue: #2563EB;
        --profile-blue-soft: #EAF2FF;

        --profile-green: #15803D;
        --profile-green-soft: #EAF8EF;

        --profile-teal: #0F766E;
        --profile-teal-soft: #E7F7F5;

        --profile-purple: #6D4FC2;
        --profile-purple-soft: #F2EEFF;

        --profile-orange: #B45309;
        --profile-orange-soft: #FFF5E6;

        --profile-red: #B42318;
        --profile-red-soft: #FFF0EE;

        --profile-text: #102A4A;
        --profile-body: #405872;
        --profile-muted: #64778C;

        --profile-white: #FFFFFF;
        --profile-soft: #F8FBFE;

        --profile-border: #D8E3EE;
        --profile-border-soft: #E7EDF4;

        --profile-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --profile-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --profile-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .student-profile-page {
        width: 100%;

        color:
            var(--profile-text);

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

    .student-profile-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 30px;

        padding:
            42px
            44px;

        border-radius: 28px;

        background:
            radial-gradient(
                circle at 89% 15%,
                rgba(45, 212, 191, 0.20),
                transparent 24%
            ),
            radial-gradient(
                circle at 69% 87%,
                rgba(96, 165, 250, 0.14),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 54%,
                #205F79 100%
            );

        box-shadow:
            var(--profile-shadow-large);
    }


    .student-profile-hero::before {
        content: "";

        position: absolute;

        width: 340px;
        height: 340px;

        right: -135px;
        top: -190px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.06);
    }


    .student-profile-hero::after {
        content: "";

        position: absolute;

        width: 210px;
        height: 210px;

        right: 250px;
        bottom: -145px;

        border-radius: 50%;

        background:
            rgba(45, 212, 191, 0.08);
    }


    .student-profile-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 35px;
    }


    .student-profile-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 23px;
    }


    .student-profile-avatar {
        width: 96px;
        height: 96px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border:
            1px solid
            rgba(255, 255, 255, 0.18);

        border-radius: 27px;

        background:
            rgba(255, 255, 255, 0.12);

        color: #FFFFFF;

        font-size: 27px;
        font-weight: 900;

        backdrop-filter:
            blur(10px);
    }


    .student-profile-copy {
        min-width: 0;
    }


    .student-profile-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 9px;

        color:
            rgba(255, 255, 255, 0.80);

        font-size: 14px;
        font-weight: 800;
    }


    .student-profile-eyebrow-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background:
            #2DD4BF;

        box-shadow:
            0 0 0 5px
            rgba(45, 212, 191, 0.13);
    }


    .student-profile-hero h1 {
        margin:
            0
            0
            8px;

        color:
            #FFFFFF;

        font-size: 38px;
        font-weight: 900;

        line-height: 1.18;

        letter-spacing:
            -0.55px;
    }


    .student-profile-subtitle {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .student-profile-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 11px;
    }


    .profile-hero-button {
        min-height: 50px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            18px;

        border-radius: 13px;

        text-decoration: none;

        font-size: 15px;
        font-weight: 850;

        white-space: nowrap;

        transition:
            var(--profile-transition);
    }


    .profile-button-secondary {
        border:
            1px solid
            rgba(255, 255, 255, 0.18);

        background:
            rgba(255, 255, 255, 0.10);

        color:
            #FFFFFF;
    }


    .profile-button-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.17);
    }


    .profile-button-primary {
        border:
            1px solid
            #FFFFFF;

        background:
            #FFFFFF;

        color:
            var(--profile-navy);
    }


    .profile-button-primary:hover {
        transform:
            translateY(-2px);

        box-shadow:
            0 13px 28px
            rgba(7, 27, 47, 0.18);
    }


    /* ================================================================
       SUMMARY GRID
       ================================================================ */

    .profile-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 19px;

        margin-bottom: 28px;
    }


    .profile-summary-card {
        padding:
            24px;

        border:
            1px solid
            var(--profile-border);

        border-radius: 20px;

        background:
            var(--profile-white);

        box-shadow:
            var(--profile-shadow);

        transition:
            var(--profile-transition);
    }


    .profile-summary-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            0 18px 38px
            rgba(15, 42, 74, 0.10);
    }


    .profile-summary-icon {
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


    .icon-blue {
        background:
            var(--profile-blue-soft);

        color:
            var(--profile-blue);
    }


    .icon-purple {
        background:
            var(--profile-purple-soft);

        color:
            var(--profile-purple);
    }


    .icon-green {
        background:
            var(--profile-green-soft);

        color:
            var(--profile-green);
    }


    .icon-teal {
        background:
            var(--profile-teal-soft);

        color:
            var(--profile-teal);
    }


    .profile-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--profile-body);

        font-size: 15px;
        font-weight: 750;
    }


    .profile-summary-value {
        display: block;

        color:
            var(--profile-text);

        font-size: 22px;
        font-weight: 900;

        line-height: 1.35;

        word-break: break-word;
    }


    .profile-summary-number {
        font-size: 32px;
    }


    .profile-summary-note {
        display: block;

        margin-top: 9px;

        color:
            var(--profile-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       STATUS
       ================================================================ */

    .profile-status {
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


    .profile-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .status-active {
        background:
            var(--profile-green-soft);

        color:
            var(--profile-green);
    }


    .status-active::before {
        background:
            #22C55E;
    }


    .status-inactive {
        background:
            var(--profile-red-soft);

        color:
            var(--profile-red);
    }


    .status-inactive::before {
        background:
            #EF4444;
    }


    .status-pending {
        background:
            var(--profile-orange-soft);

        color:
            var(--profile-orange);
    }


    .status-pending::before {
        background:
            #F59E0B;
    }


    .status-completed {
        background:
            var(--profile-blue-soft);

        color:
            var(--profile-blue);
    }


    .status-completed::before {
        background:
            #3B82F6;
    }


    /* ================================================================
       COMPLETENESS
       ================================================================ */

    .profile-completeness-card {
        margin-bottom: 26px;

        padding:
            21px
            23px;

        border:
            1px solid
            #CEE5DF;

        border-radius: 17px;

        background:
            linear-gradient(
                135deg,
                #F7FCFB 0%,
                #EFF9F7 100%
            );

        box-shadow:
            var(--profile-shadow);
    }


    .profile-completeness-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 13px;
    }


    .profile-completeness-title {
        display: block;

        margin-bottom: 4px;

        color:
            var(--profile-text);

        font-size: 18px;
        font-weight: 850;
    }


    .profile-completeness-description {
        display: block;

        color:
            var(--profile-body);

        font-size: 15px;

        line-height: 1.6;
    }


    .profile-completeness-percent {
        color:
            var(--profile-teal);

        font-size: 28px;
        font-weight: 900;
    }


    .profile-completeness-track {
        height: 10px;

        overflow: hidden;

        border-radius: 999px;

        background:
            #DCE9E6;
    }


    .profile-completeness-fill {
        height: 100%;

        border-radius: inherit;

        background:
            linear-gradient(
                90deg,
                #2563EB,
                #0F766E
            );
    }


    /* ================================================================
       MAIN LAYOUT
       ================================================================ */

    .profile-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1.34fr)
            minmax(350px, 0.66fr);

        gap: 23px;

        align-items: start;
    }


    .profile-main,
    .profile-sidebar {
        display: grid;

        gap: 23px;
    }


    /* ================================================================
       PANEL
       ================================================================ */

    .profile-panel {
        overflow: hidden;

        border:
            1px solid
            var(--profile-border);

        border-radius: 20px;

        background:
            var(--profile-white);

        box-shadow:
            var(--profile-shadow);
    }


    .profile-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            24px
            26px;

        border-bottom:
            1px solid
            var(--profile-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .profile-panel-heading {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    .profile-panel-icon {
        width: 50px;
        height: 50px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        font-size: 13px;
        font-weight: 900;
    }


    .panel-blue {
        background:
            var(--profile-blue-soft);

        color:
            var(--profile-blue);
    }


    .panel-teal {
        background:
            var(--profile-teal-soft);

        color:
            var(--profile-teal);
    }


    .panel-orange {
        background:
            var(--profile-orange-soft);

        color:
            var(--profile-orange);
    }


    .panel-purple {
        background:
            var(--profile-purple-soft);

        color:
            var(--profile-purple);
    }


    .panel-green {
        background:
            var(--profile-green-soft);

        color:
            var(--profile-green);
    }


    .profile-panel-heading h2 {
        margin:
            0
            0
            4px;

        color:
            var(--profile-text);

        font-size: 23px;
        font-weight: 850;

        line-height: 1.3;
    }


    .profile-panel-heading p {
        margin: 0;

        color:
            var(--profile-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .profile-panel-body {
        padding:
            26px;
    }


    /* ================================================================
       IDENTITY
       ================================================================ */

    .profile-identity-card {
        display: flex;
        align-items: center;

        gap: 18px;

        margin-bottom: 18px;

        padding:
            19px;

        border:
            1px solid
            #D5E3F2;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                #F8FBFF 0%,
                #EFF6FD 100%
            );
    }


    .profile-identity-avatar {
        width: 66px;
        height: 66px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 18px;

        background:
            var(--profile-blue-soft);

        color:
            var(--profile-blue);

        font-size: 18px;
        font-weight: 900;
    }


    .profile-identity-name {
        display: block;

        margin-bottom: 4px;

        color:
            var(--profile-text);

        font-size: 20px;
        font-weight: 900;
    }


    .profile-identity-email {
        color:
            var(--profile-body);

        font-size: 15px;

        line-height: 1.55;
    }


    /* ================================================================
       INFORMATION GRID
       ================================================================ */

    .profile-information-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 14px;
    }


    .profile-information-item {
        min-height: 100px;

        padding:
            17px;

        border:
            1px solid
            var(--profile-border-soft);

        border-radius: 13px;

        background:
            var(--profile-soft);
    }


    .profile-information-full {
        grid-column:
            1 / -1;
    }


    .profile-information-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--profile-muted);

        font-size: 14px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.3px;
    }


    .profile-information-value {
        display: block;

        color:
            var(--profile-text);

        font-size: 17px;
        font-weight: 800;

        line-height: 1.55;

        word-break: break-word;
    }


    .profile-information-missing {
        color:
            var(--profile-muted);

        font-weight: 650;
    }


    /* ================================================================
       OJT PLACEMENT CARD
       ================================================================ */

    .profile-placement-card {
        overflow: hidden;

        border:
            1px solid
            #D5E4F2;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #F8FBFF 0%,
                #F1F7FD 100%
            );
    }


    .profile-placement-header {
        padding:
            21px;

        border-bottom:
            1px solid
            #DDE8F2;
    }


    .profile-placement-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--profile-muted);

        font-size: 14px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .profile-placement-company {
        display: block;

        color:
            var(--profile-text);

        font-size: 21px;
        font-weight: 900;

        line-height: 1.4;
    }


    .profile-placement-address {
        display: block;

        margin-top: 7px;

        color:
            var(--profile-body);

        font-size: 15px;

        line-height: 1.6;
    }


    .profile-placement-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }


    .profile-placement-item {
        padding:
            17px
            19px;

        border-bottom:
            1px solid
            #E2EAF2;
    }


    .profile-placement-item:nth-child(odd) {
        border-right:
            1px solid
            #E2EAF2;
    }


    .profile-placement-item-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--profile-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .profile-placement-item-value {
        display: block;

        color:
            var(--profile-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.55;

        word-break: break-word;
    }


    /* ================================================================
       SIDEBAR LIST
       ================================================================ */

    .profile-sidebar-list {
        display: grid;

        gap: 12px;
    }


    .profile-sidebar-item {
        padding:
            14px
            15px;

        border:
            1px solid
            var(--profile-border-soft);

        border-radius: 12px;

        background:
            var(--profile-soft);
    }


    .profile-sidebar-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--profile-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.3px;
    }


    .profile-sidebar-value {
        display: block;

        color:
            var(--profile-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.55;

        word-break: break-word;
    }


    /* ================================================================
       CHECKLIST
       ================================================================ */

    .profile-checklist {
        display: grid;

        gap: 12px;
    }


    .profile-check-item {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        padding:
            14px;

        border:
            1px solid
            var(--profile-border-soft);

        border-radius: 12px;

        background:
            #FBFCFE;
    }


    .profile-check-left {
        display: flex;
        align-items: center;

        gap: 11px;
    }


    .profile-check-icon {
        width: 34px;
        height: 34px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        font-size: 13px;
        font-weight: 900;
    }


    .check-complete {
        background:
            var(--profile-green-soft);

        color:
            var(--profile-green);
    }


    .check-missing {
        background:
            var(--profile-orange-soft);

        color:
            var(--profile-orange);
    }


    .profile-check-name {
        color:
            var(--profile-text);

        font-size: 15px;
        font-weight: 800;
    }


    .profile-check-state {
        color:
            var(--profile-body);

        font-size: 14px;
        font-weight: 850;
    }


    /* ================================================================
       HISTORY BUTTON
       ================================================================ */

    .profile-history-button {
        min-height: 48px;

        margin-top: 15px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            16px;

        border-radius: 12px;

        background:
            var(--profile-navy);

        color:
            #FFFFFF;

        text-decoration: none;

        font-size: 15px;
        font-weight: 850;

        transition:
            var(--profile-transition);
    }


    .profile-history-button:hover {
        transform:
            translateY(-1px);

        background:
            var(--profile-navy-dark);
    }


    /* ================================================================
       PRIVACY
       ================================================================ */

    .profile-privacy-note {
        padding:
            16px;

        border:
            1px solid
            #D5E4F2;

        border-radius: 13px;

        background:
            #F5FAFE;

        color:
            var(--profile-body);

        font-size: 15px;

        line-height: 1.7;
    }


    .profile-privacy-note strong {
        color:
            var(--profile-text);
    }


    /* ================================================================
       EMPTY
       ================================================================ */

    .profile-empty {
        padding:
            42px
            24px;

        text-align: center;
    }


    .profile-empty-icon {
        width: 70px;
        height: 70px;

        margin:
            0
            auto
            16px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 20px;

        background:
            var(--profile-blue-soft);

        color:
            var(--profile-blue);

        font-size: 16px;
        font-weight: 900;
    }


    .profile-empty h3 {
        margin:
            0
            0
            8px;

        color:
            var(--profile-text);

        font-size: 21px;
        font-weight: 850;
    }


    .profile-empty p {
        max-width: 520px;

        margin: 0 auto;

        color:
            var(--profile-body);

        font-size: 15px;

        line-height: 1.7;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1150px) {

        .profile-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .profile-layout {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 850px) {

        .student-profile-hero {
            padding:
                34px
                28px;
        }


        .student-profile-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .student-profile-actions {
            width: 100%;
        }


        .profile-hero-button {
            flex: 1;
        }

    }


    @media (max-width: 650px) {

        .student-profile-page {
            font-size: 16px;
        }


        .student-profile-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .student-profile-identity {
            flex-direction: column;

            align-items: flex-start;
        }


        .student-profile-hero h1 {
            font-size: 31px;
        }


        .student-profile-subtitle {
            font-size: 16px;
        }


        .profile-summary-grid,
        .profile-information-grid,
        .profile-placement-grid {
            grid-template-columns: 1fr;
        }


        .profile-information-full {
            grid-column: auto;
        }


        .profile-placement-item:nth-child(odd) {
            border-right: none;
        }


        .profile-panel-header,
        .profile-panel-body {
            padding-left: 20px;
            padding-right: 20px;
        }


        .profile-panel-heading h2 {
            font-size: 21px;
        }


        .profile-completeness-top {
            flex-direction: column;

            align-items: flex-start;
        }


        .profile-identity-card {
            flex-direction: column;

            align-items: flex-start;
        }


        .student-profile-actions {
            flex-direction: column;
        }


        .profile-hero-button {
            width: 100%;
            flex: none;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Authenticated Student
    |--------------------------------------------------------------------------
    */

    $student =
        auth()->user();


    /*
    |--------------------------------------------------------------------------
    | Student Profile
    |--------------------------------------------------------------------------
    */

    $studentProfile =
        $profile
        ?? $student?->studentProfile;


    /*
    |--------------------------------------------------------------------------
    | Flexible Profile Reader
    |--------------------------------------------------------------------------
    */

    $profileValue =
        function (
            array $keys,
            $default = null
        ) use (
            $studentProfile
        ) {

            if (! $studentProfile) {
                return $default;
            }


            foreach ($keys as $key) {

                try {

                    $value =
                        data_get(
                            $studentProfile,
                            $key
                        );


                    if (
                        $value !== null
                        &&
                        $value !== ''
                    ) {
                        return $value;
                    }

                } catch (\Throwable $exception) {

                    continue;

                }

            }


            return $default;

        };


    /*
    |--------------------------------------------------------------------------
    | Core Student Information
    |--------------------------------------------------------------------------
    */

    $studentName =
        $student?->name
        ?? 'Student';


    $studentNumber =
        $profileValue([
            'student_number',
            'student_id_number',
            'student_id',
            'id_number',
        ]);


    $program =
        $profileValue([
            'program',
            'course',
        ]);


    $yearLevel =
        $profileValue([
            'year_level',
            'year',
        ]);


    $section =
        $profileValue([
            'section',
        ]);


    $contactNumber =
        $profileValue([
            'contact_number',
            'phone',
            'mobile_number',
            'contact',
        ]);


    $address =
        $profileValue([
            'address',
            'residential_address',
            'home_address',
            'full_address',
        ]);


    /*
    |--------------------------------------------------------------------------
    | Emergency Contact
    |--------------------------------------------------------------------------
    */

    $emergencyName =
        $profileValue([
            'emergency_contact_name',
            'emergency_contact_person',
            'guardian_name',
            'emergency_name',
        ]);


    $emergencyNumber =
        $profileValue([
            'emergency_contact_number',
            'emergency_contact_phone',
            'guardian_contact_number',
            'guardian_contact',
            'emergency_number',
        ]);


    $emergencyRelationship =
        $profileValue([
            'emergency_contact_relationship',
            'emergency_relationship',
            'guardian_relationship',
            'relationship',
        ]);


    $emergencyAddress =
        $profileValue([
            'emergency_contact_address',
            'guardian_address',
        ]);


    /*
    |--------------------------------------------------------------------------
    | Student Initials
    |--------------------------------------------------------------------------
    */

    $studentNameParts =
        preg_split(
            '/\s+/',
            trim($studentName)
        );


    $studentInitials =
        collect($studentNameParts)
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
            ->implode('');


    /*
    |--------------------------------------------------------------------------
    | Account Status
    |--------------------------------------------------------------------------
    */

    $accountStatus =
        strtolower(
            (string) (
                $student?->status
                ?? 'active'
            )
        );


    $isAccountActive =
        $accountStatus === 'active';


    /*
    |--------------------------------------------------------------------------
    | OJT Assignments
    |--------------------------------------------------------------------------
    */

    $assignments =
        $studentProfile
            ? collect(
                $studentProfile->ojtAssignments
                ?? []
            )
                ->sortByDesc(
                    'created_at'
                )
                ->values()
            : collect();


    /*
    |--------------------------------------------------------------------------
    | Current Assignment
    |--------------------------------------------------------------------------
    */

    $currentAssignment =
        $assignment
        ?? $activeAssignment
        ?? $assignments
            ->first(
                fn ($item) =>
                    (string) $item->status
                    === \App\Models\OjtAssignment::STATUS_ACTIVE
            )
        ?? $assignments
            ->first(
                fn ($item) =>
                    (string) $item->status
                    === \App\Models\OjtAssignment::STATUS_PENDING
            );


    $currentAssignmentStatus =
        $currentAssignment
            ? (string) $currentAssignment->status
            : null;


    $completedAssignments =
        $assignments
            ->filter(
                fn ($item) =>
                    (string) $item->status
                    === \App\Models\OjtAssignment::STATUS_COMPLETED
            )
            ->count();


    /*
    |--------------------------------------------------------------------------
    | Profile Completeness
    |--------------------------------------------------------------------------
    */

    $profileChecklist = [

        'Student Number' =>
            filled($studentNumber),

        'Academic Program' =>
            filled($program),

        'Year Level' =>
            filled($yearLevel),

        'Section' =>
            filled($section),

        'Contact Number' =>
            filled($contactNumber),

        'Residential Address' =>
            filled($address),

        'Emergency Contact' =>
            filled($emergencyName)
            &&
            filled($emergencyNumber),

    ];


    $completedProfileItems =
        collect(
            $profileChecklist
        )
            ->filter()
            ->count();


    $totalProfileItems =
        count(
            $profileChecklist
        );


    $profileCompleteness =
        $totalProfileItems > 0
            ? (int) round(
                (
                    $completedProfileItems
                    /
                    $totalProfileItems
                ) * 100
            )
            : 0;


    /*
    |--------------------------------------------------------------------------
    | Date Formatter
    |--------------------------------------------------------------------------
    */

    $formatDate =
        function ($value) {

            if (! $value) {
                return 'Not available';
            }


            try {

                return
                    \Illuminate\Support\Carbon::parse(
                        $value
                    )
                        ->format(
                            'M d, Y'
                        );

            } catch (\Throwable $exception) {

                return (string) $value;

            }

        };


    /*
    |--------------------------------------------------------------------------
    | Route Helper
    |--------------------------------------------------------------------------
    */

    $routeExists =
        fn ($name) =>
            \Illuminate\Support\Facades\Route::has(
                $name
            );

@endphp


<div class="student-profile-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="student-profile-hero">


        <div class="student-profile-hero-inner">


            <div class="student-profile-identity">


                <div class="student-profile-avatar">

                    {{ $studentInitials ?: 'ST' }}

                </div>


                <div class="student-profile-copy">


                    <div class="student-profile-eyebrow">


                        <span class="student-profile-eyebrow-dot"></span>


                        Student Portal · Personal & Academic Record


                    </div>


                    <h1>

                        {{ $studentName }}

                    </h1>


                    <p class="student-profile-subtitle">

                        {{ $studentNumber
                            ?: 'Student number not yet provided'
                        }}

                        @if (filled($program))

                            · {{ $program }}

                        @endif

                        @if (filled($yearLevel))

                            · {{ $yearLevel }}

                        @endif

                        @if (filled($section))

                            · Section {{ $section }}

                        @endif

                    </p>


                </div>


            </div>


            <div class="student-profile-actions">


                <a
                    href="{{ route(
                        'student.dashboard'
                    ) }}"
                    class="
                        profile-hero-button
                        profile-button-secondary
                    "
                >
                    ← Back to Dashboard
                </a>


                @if (
                    $routeExists(
                        'student.profile.edit'
                    )
                )


                    <a
                        href="{{ route(
                            'student.profile.edit'
                        ) }}"
                        class="
                            profile-hero-button
                            profile-button-primary
                        "
                    >
                        Edit My Profile
                    </a>


                @endif


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="profile-summary-grid">


        <article class="profile-summary-card">


            <div class="profile-summary-icon icon-blue">
                ID
            </div>


            <span class="profile-summary-label">
                Student Number
            </span>


            <span class="profile-summary-value">

                {{ $studentNumber
                    ?: 'Not Provided'
                }}

            </span>


            <span class="profile-summary-note">

                Your official Student
                profile identifier.

            </span>


        </article>


        <article class="profile-summary-card">


            <div class="profile-summary-icon icon-purple">
                AC
            </div>


            <span class="profile-summary-label">
                Academic Program
            </span>


            <span class="profile-summary-value">

                {{ $program
                    ?: 'Not Provided'
                }}

            </span>


            <span class="profile-summary-note">

                {{ $yearLevel
                    ?: 'Year level not provided'
                }}

                @if (filled($section))

                    · Section {{ $section }}

                @endif

            </span>


        </article>


        <article class="profile-summary-card">


            <div class="profile-summary-icon icon-green">
                US
            </div>


            <span class="profile-summary-label">
                Account Status
            </span>


            <span class="profile-summary-value">


                <span
                    class="
                        profile-status
                        {{ $isAccountActive
                            ? 'status-active'
                            : 'status-inactive'
                        }}
                    "
                >

                    {{ ucfirst(
                        $accountStatus
                    ) }}

                </span>


            </span>


            <span class="profile-summary-note">

                Current availability
                of your OJT Sync account.

            </span>


        </article>


        <article class="profile-summary-card">


            <div class="profile-summary-icon icon-teal">
                OJ
            </div>


            <span class="profile-summary-label">
                OJT Placements
            </span>


            <span
                class="
                    profile-summary-value
                    profile-summary-number
                "
            >

                {{ $assignments->count() }}

            </span>


            <span class="profile-summary-note">

                {{ $completedAssignments }}

                completed placement{{ $completedAssignments === 1 ? '' : 's' }}.

            </span>


        </article>


    </section>


    {{-- ==================================================================
         COMPLETENESS
         ================================================================== --}}

    <section class="profile-completeness-card">


        <div class="profile-completeness-top">


            <div>


                <span class="profile-completeness-title">
                    Student Profile Completeness
                </span>


                <span class="profile-completeness-description">

                    Keeping your Student information complete
                    helps make your OJT records easier to verify
                    and manage.

                </span>


            </div>


            <div class="profile-completeness-percent">

                {{ $profileCompleteness }}%

            </div>


        </div>


        <div class="profile-completeness-track">


            <div
                class="profile-completeness-fill"
                style="width: {{ $profileCompleteness }}%;"
            ></div>


        </div>


    </section>


    {{-- ==================================================================
         MAIN LAYOUT
         ================================================================== --}}

    <div class="profile-layout">


        {{-- ==============================================================
             MAIN
             ============================================================== --}}

        <main class="profile-main">


            {{-- ==========================================================
                 STUDENT INFORMATION
                 ========================================================== --}}

            <section class="profile-panel">


                <div class="profile-panel-header">


                    <div class="profile-panel-heading">


                        <div class="profile-panel-icon panel-blue">
                            AC
                        </div>


                        <div>


                            <h2>
                                Student & Academic Information
                            </h2>


                            <p>
                                Your primary Student profile details
                            </p>


                        </div>


                    </div>


                </div>


                <div class="profile-panel-body">


                    <div class="profile-identity-card">


                        <div class="profile-identity-avatar">

                            {{ $studentInitials ?: 'ST' }}

                        </div>


                        <div>


                            <span class="profile-identity-name">

                                {{ $studentName }}

                            </span>


                            <span class="profile-identity-email">

                                {{ $student?->email
                                    ?: 'Email address unavailable'
                                }}

                            </span>


                        </div>


                    </div>


                    <div class="profile-information-grid">


                        <div class="profile-information-item">


                            <span class="profile-information-label">
                                Student Number
                            </span>


                            <span
                                class="
                                    profile-information-value
                                    {{ blank($studentNumber)
                                        ? 'profile-information-missing'
                                        : ''
                                    }}
                                "
                            >

                                {{ $studentNumber
                                    ?: 'Not provided'
                                }}

                            </span>


                        </div>


                        <div class="profile-information-item">


                            <span class="profile-information-label">
                                Academic Program
                            </span>


                            <span
                                class="
                                    profile-information-value
                                    {{ blank($program)
                                        ? 'profile-information-missing'
                                        : ''
                                    }}
                                "
                            >

                                {{ $program
                                    ?: 'Not provided'
                                }}

                            </span>


                        </div>


                        <div class="profile-information-item">


                            <span class="profile-information-label">
                                Year Level
                            </span>


                            <span
                                class="
                                    profile-information-value
                                    {{ blank($yearLevel)
                                        ? 'profile-information-missing'
                                        : ''
                                    }}
                                "
                            >

                                {{ $yearLevel
                                    ?: 'Not provided'
                                }}

                            </span>


                        </div>


                        <div class="profile-information-item">


                            <span class="profile-information-label">
                                Section
                            </span>


                            <span
                                class="
                                    profile-information-value
                                    {{ blank($section)
                                        ? 'profile-information-missing'
                                        : ''
                                    }}
                                "
                            >

                                {{ $section
                                    ?: 'Not provided'
                                }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 CONTACT INFORMATION
                 ========================================================== --}}

            <section class="profile-panel">


                <div class="profile-panel-header">


                    <div class="profile-panel-heading">


                        <div class="profile-panel-icon panel-teal">
                            CT
                        </div>


                        <div>


                            <h2>
                                Contact Information
                            </h2>


                            <p>
                                Personal contact details used for your OJT record
                            </p>


                        </div>


                    </div>


                </div>


                <div class="profile-panel-body">


                    <div class="profile-information-grid">


                        <div class="profile-information-item">


                            <span class="profile-information-label">
                                Email Address
                            </span>


                            <span class="profile-information-value">

                                {{ $student?->email
                                    ?: 'Not provided'
                                }}

                            </span>


                        </div>


                        <div class="profile-information-item">


                            <span class="profile-information-label">
                                Contact Number
                            </span>


                            <span
                                class="
                                    profile-information-value
                                    {{ blank($contactNumber)
                                        ? 'profile-information-missing'
                                        : ''
                                    }}
                                "
                            >

                                {{ $contactNumber
                                    ?: 'Not provided'
                                }}

                            </span>


                        </div>


                        <div
                            class="
                                profile-information-item
                                profile-information-full
                            "
                        >


                            <span class="profile-information-label">
                                Residential Address
                            </span>


                            <span
                                class="
                                    profile-information-value
                                    {{ blank($address)
                                        ? 'profile-information-missing'
                                        : ''
                                    }}
                                "
                            >

                                {{ $address
                                    ?: 'Not provided'
                                }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 EMERGENCY CONTACT
                 ========================================================== --}}

            <section class="profile-panel">


                <div class="profile-panel-header">


                    <div class="profile-panel-heading">


                        <div class="profile-panel-icon panel-orange">
                            EC
                        </div>


                        <div>


                            <h2>
                                Emergency Contact
                            </h2>


                            <p>
                                Contact information available when needed
                            </p>


                        </div>


                    </div>


                </div>


                <div class="profile-panel-body">


                    <div class="profile-information-grid">


                        <div class="profile-information-item">


                            <span class="profile-information-label">
                                Contact Person
                            </span>


                            <span
                                class="
                                    profile-information-value
                                    {{ blank($emergencyName)
                                        ? 'profile-information-missing'
                                        : ''
                                    }}
                                "
                            >

                                {{ $emergencyName
                                    ?: 'Not provided'
                                }}

                            </span>


                        </div>


                        <div class="profile-information-item">


                            <span class="profile-information-label">
                                Contact Number
                            </span>


                            <span
                                class="
                                    profile-information-value
                                    {{ blank($emergencyNumber)
                                        ? 'profile-information-missing'
                                        : ''
                                    }}
                                "
                            >

                                {{ $emergencyNumber
                                    ?: 'Not provided'
                                }}

                            </span>


                        </div>


                        <div class="profile-information-item">


                            <span class="profile-information-label">
                                Relationship
                            </span>


                            <span
                                class="
                                    profile-information-value
                                    {{ blank($emergencyRelationship)
                                        ? 'profile-information-missing'
                                        : ''
                                    }}
                                "
                            >

                                {{ $emergencyRelationship
                                    ?: 'Not provided'
                                }}

                            </span>


                        </div>


                        <div class="profile-information-item">


                            <span class="profile-information-label">
                                Contact Address
                            </span>


                            <span
                                class="
                                    profile-information-value
                                    {{ blank($emergencyAddress)
                                        ? 'profile-information-missing'
                                        : ''
                                    }}
                                "
                            >

                                {{ $emergencyAddress
                                    ?: 'Not provided'
                                }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 OJT PLACEMENT
                 ========================================================== --}}

            <section class="profile-panel">


                <div class="profile-panel-header">


                    <div class="profile-panel-heading">


                        <div class="profile-panel-icon panel-purple">
                            OJ
                        </div>


                        <div>


                            <h2>
                                Current OJT Placement
                            </h2>


                            <p>
                                Company, Supervisor, schedule, and required hours
                            </p>


                        </div>


                    </div>


                </div>


                <div class="profile-panel-body">


                    @if ($currentAssignment)


                        <div class="profile-placement-card">


                            <div class="profile-placement-header">


                                <span class="profile-placement-label">
                                    OJT Company
                                </span>


                                <span class="profile-placement-company">

                                    {{ $currentAssignment
                                        ->company
                                        ?->name
                                        ?? 'Company unavailable'
                                    }}

                                </span>


                                <span class="profile-placement-address">

                                    {{ $currentAssignment
                                        ->company
                                        ?->address
                                        ?: 'Company address not provided'
                                    }}

                                </span>


                            </div>


                            <div class="profile-placement-grid">


                                <div class="profile-placement-item">


                                    <span class="profile-placement-item-label">
                                        Assigned Supervisor
                                    </span>


                                    <span class="profile-placement-item-value">

                                        {{ $currentAssignment
                                            ->supervisor
                                            ?->name
                                            ?? 'Not assigned'
                                        }}

                                    </span>


                                </div>


                                <div class="profile-placement-item">


                                    <span class="profile-placement-item-label">
                                        Required Hours
                                    </span>


                                    <span class="profile-placement-item-value">

                                        {{ number_format(
                                            (float)
                                            $currentAssignment->required_hours
                                        ) }}

                                        hours

                                    </span>


                                </div>


                                <div class="profile-placement-item">


                                    <span class="profile-placement-item-label">
                                        Start Date
                                    </span>


                                    <span class="profile-placement-item-value">

                                        {{ $formatDate(
                                            $currentAssignment->start_date
                                        ) }}

                                    </span>


                                </div>


                                <div class="profile-placement-item">


                                    <span class="profile-placement-item-label">
                                        End Date
                                    </span>


                                    <span class="profile-placement-item-value">

                                        {{ $formatDate(
                                            $currentAssignment->end_date
                                        ) }}

                                    </span>


                                </div>


                                <div class="profile-placement-item">


                                    <span class="profile-placement-item-label">
                                        Assignment Status
                                    </span>


                                    <span class="profile-placement-item-value">


                                        @if (
                                            $currentAssignmentStatus
                                            ===
                                            \App\Models\OjtAssignment::STATUS_ACTIVE
                                        )


                                            <span
                                                class="
                                                    profile-status
                                                    status-active
                                                "
                                            >
                                                Active
                                            </span>


                                        @elseif (
                                            $currentAssignmentStatus
                                            ===
                                            \App\Models\OjtAssignment::STATUS_PENDING
                                        )


                                            <span
                                                class="
                                                    profile-status
                                                    status-pending
                                                "
                                            >
                                                Pending
                                            </span>


                                        @elseif (
                                            $currentAssignmentStatus
                                            ===
                                            \App\Models\OjtAssignment::STATUS_COMPLETED
                                        )


                                            <span
                                                class="
                                                    profile-status
                                                    status-completed
                                                "
                                            >
                                                Completed
                                            </span>


                                        @else


                                            {{ ucfirst(
                                                $currentAssignmentStatus
                                                ?: 'Unavailable'
                                            ) }}


                                        @endif


                                    </span>


                                </div>


                                <div class="profile-placement-item">


                                    <span class="profile-placement-item-label">
                                        Supervisor Email
                                    </span>


                                    <span class="profile-placement-item-value">

                                        {{ $currentAssignment
                                            ->supervisor
                                            ?->email
                                            ?? 'Not available'
                                        }}

                                    </span>


                                </div>


                            </div>


                        </div>


                    @else


                        <div class="profile-empty">


                            <div class="profile-empty-icon">
                                OJ
                            </div>


                            <h3>
                                No Current OJT Placement
                            </h3>


                            <p>

                                Your company, assigned Supervisor,
                                required training hours, and OJT
                                placement period will appear here
                                when an active or pending assignment
                                becomes available.

                            </p>


                        </div>


                    @endif


                </div>


            </section>


        </main>


        {{-- ==============================================================
             SIDEBAR
             ============================================================== --}}

        <aside class="profile-sidebar">


            {{-- ==========================================================
                 CHECKLIST
                 ========================================================== --}}

            <section class="profile-panel">


                <div class="profile-panel-header">


                    <div class="profile-panel-heading">


                        <div class="profile-panel-icon panel-green">
                            CK
                        </div>


                        <div>


                            <h2>
                                Profile Checklist
                            </h2>


                            <p>
                                Information currently available
                            </p>


                        </div>


                    </div>


                </div>


                <div class="profile-panel-body">


                    <div class="profile-checklist">


                        @foreach (
                            $profileChecklist
                            as $label => $complete
                        )


                            <div class="profile-check-item">


                                <div class="profile-check-left">


                                    <span
                                        class="
                                            profile-check-icon
                                            {{ $complete
                                                ? 'check-complete'
                                                : 'check-missing'
                                            }}
                                        "
                                    >

                                        {{ $complete
                                            ? '✓'
                                            : '!'
                                        }}

                                    </span>


                                    <span class="profile-check-name">

                                        {{ $label }}

                                    </span>


                                </div>


                                <span class="profile-check-state">

                                    {{ $complete
                                        ? 'Complete'
                                        : 'Missing'
                                    }}

                                </span>


                            </div>


                        @endforeach


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 ACCOUNT INFORMATION
                 ========================================================== --}}

            <section class="profile-panel">


                <div class="profile-panel-header">


                    <div class="profile-panel-heading">


                        <div class="profile-panel-icon panel-blue">
                            US
                        </div>


                        <div>


                            <h2>
                                Account Information
                            </h2>


                            <p>
                                Your OJT Sync account record
                            </p>


                        </div>


                    </div>


                </div>


                <div class="profile-panel-body">


                    <div class="profile-sidebar-list">


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Account Name
                            </span>


                            <span class="profile-sidebar-value">

                                {{ $studentName }}

                            </span>


                        </div>


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Email Address
                            </span>


                            <span class="profile-sidebar-value">

                                {{ $student?->email
                                    ?: 'Not available'
                                }}

                            </span>


                        </div>


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Account Role
                            </span>


                            <span class="profile-sidebar-value">
                                Student
                            </span>


                        </div>


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Account Status
                            </span>


                            <span class="profile-sidebar-value">

                                {{ ucfirst(
                                    $accountStatus
                                ) }}

                            </span>


                        </div>


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Member Since
                            </span>


                            <span class="profile-sidebar-value">

                                {{ $formatDate(
                                    $student?->created_at
                                ) }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 OJT SUMMARY
                 ========================================================== --}}

            <section class="profile-panel">


                <div class="profile-panel-header">


                    <div class="profile-panel-heading">


                        <div class="profile-panel-icon panel-purple">
                            HS
                        </div>


                        <div>


                            <h2>
                                OJT Record Summary
                            </h2>


                            <p>
                                Your assignment history overview
                            </p>


                        </div>


                    </div>


                </div>


                <div class="profile-panel-body">


                    <div class="profile-sidebar-list">


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Total Assignments
                            </span>


                            <span class="profile-sidebar-value">

                                {{ $assignments->count() }}

                            </span>


                        </div>


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Completed Placements
                            </span>


                            <span class="profile-sidebar-value">

                                {{ $completedAssignments }}

                            </span>


                        </div>


                        <div class="profile-sidebar-item">


                            <span class="profile-sidebar-label">
                                Current Assignment
                            </span>


                            <span class="profile-sidebar-value">

                                {{ $currentAssignment
                                    ? ucfirst(
                                        $currentAssignmentStatus
                                    )
                                    : 'None'
                                }}

                            </span>


                        </div>


                    </div>


                    @if (
                        $routeExists(
                            'student.assignment-history.index'
                        )
                    )


                        <a
                            href="{{ route(
                                'student.assignment-history.index'
                            ) }}"
                            class="profile-history-button"
                        >
                            View OJT Assignment History →
                        </a>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 PRIVACY
                 ========================================================== --}}

            <section class="profile-panel">


                <div class="profile-panel-header">


                    <div class="profile-panel-heading">


                        <div class="profile-panel-icon panel-teal">
                            PR
                        </div>


                        <div>


                            <h2>
                                Profile Privacy
                            </h2>


                            <p>
                                Keep your information secure
                            </p>


                        </div>


                    </div>


                </div>


                <div class="profile-panel-body">


                    <div class="profile-privacy-note">

                        <strong>
                            Keep your Student information accurate.
                        </strong>

                        Your contact and emergency information
                        should be kept updated. Never place your
                        password, verification codes, authentication
                        tokens, or other private credentials inside
                        ordinary profile fields.

                    </div>


                </div>


            </section>


        </aside>


    </div>


</div>


@endsection