@extends('layouts.app')


@section('title', 'My OJT Timesheet | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC - STUDENT TIMESHEET
       PROFESSIONAL + READABILITY FIRST
       ================================================================ */

    :root {
        --ts-navy: #183B6B;
        --ts-navy-dark: #102A4A;
        --ts-navy-deep: #0B223D;

        --ts-blue: #2563EB;
        --ts-blue-soft: #EAF2FF;

        --ts-green: #15803D;
        --ts-green-soft: #EAF8EF;

        --ts-teal: #0F766E;
        --ts-teal-soft: #E7F7F5;

        --ts-orange: #B45309;
        --ts-orange-soft: #FFF5E6;

        --ts-red: #B42318;
        --ts-red-soft: #FFF0EE;

        --ts-purple: #6D4FC2;
        --ts-purple-soft: #F2EEFF;

        --ts-slate: #475569;
        --ts-slate-soft: #F1F5F9;

        --ts-text: #102A4A;
        --ts-body: #405872;
        --ts-muted: #64778C;

        --ts-white: #FFFFFF;
        --ts-soft: #F8FBFE;
        --ts-background: #F5F8FC;

        --ts-border: #D8E3EE;
        --ts-border-soft: #E7EDF4;

        --ts-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --ts-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --ts-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .student-timesheet-page {
        width: 100%;

        color: var(--ts-text);

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

    .timesheet-hero {
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
            var(--ts-shadow-large);
    }


    .timesheet-hero::before {
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


    .timesheet-hero::after {
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


    .timesheet-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 36px;
    }


    .timesheet-hero-copy {
        min-width: 0;

        max-width: 760px;
    }


    .timesheet-hero-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 12px;

        padding:
            8px
            13px;

        border:
            1px solid
            rgba(255, 255, 255, 0.15);

        border-radius: 999px;

        background:
            rgba(255, 255, 255, 0.08);

        color:
            rgba(255, 255, 255, 0.92);

        font-size: 14px;
        font-weight: 800;
    }


    .timesheet-hero-dot {
        width: 9px;
        height: 9px;

        flex-shrink: 0;

        border-radius: 50%;

        background: #2DD4BF;

        box-shadow:
            0 0 0 5px
            rgba(45, 212, 191, 0.13);
    }


    .timesheet-hero h1 {
        margin:
            0
            0
            11px;

        color: #FFFFFF;

        font-size: 38px;
        font-weight: 900;

        line-height: 1.18;

        letter-spacing: -0.55px;
    }


    .timesheet-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO PLACEMENT CARD
       ================================================================ */

    .timesheet-placement-card {
        width: 330px;

        flex-shrink: 0;

        padding: 21px;

        border:
            1px solid
            rgba(255, 255, 255, 0.16);

        border-radius: 19px;

        background:
            rgba(255, 255, 255, 0.10);

        backdrop-filter:
            blur(10px);
    }


    .timesheet-placement-label {
        display: block;

        margin-bottom: 6px;

        color:
            rgba(255, 255, 255, 0.67);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: 0.4px;
    }


    .timesheet-placement-company {
        display: block;

        color: #FFFFFF;

        font-size: 20px;
        font-weight: 900;

        line-height: 1.4;
    }


    .timesheet-placement-supervisor {
        display: block;

        margin-top: 7px;

        color:
            rgba(255, 255, 255, 0.78);

        font-size: 15px;

        line-height: 1.55;
    }


    .timesheet-placement-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        margin-top: 16px;

        padding-top: 15px;

        border-top:
            1px solid
            rgba(255, 255, 255, 0.11);
    }


    .timesheet-placement-status {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding:
            7px
            11px;

        border-radius: 999px;

        background:
            rgba(255, 255, 255, 0.12);

        color: #FFFFFF;

        font-size: 13px;
        font-weight: 850;
    }


    .timesheet-placement-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;

        background: #2DD4BF;
    }


    .timesheet-placement-hours {
        color:
            rgba(255, 255, 255, 0.80);

        font-size: 13px;
        font-weight: 750;
    }


    /* ================================================================
       ASSIGNMENT SELECTOR
       ================================================================ */

    .timesheet-selector {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 22px;

        margin-bottom: 27px;

        padding:
            20px
            22px;

        border:
            1px solid
            var(--ts-border);

        border-radius: 17px;

        background:
            var(--ts-white);

        box-shadow:
            var(--ts-shadow);
    }


    .timesheet-selector-copy {
        min-width: 0;
    }


    .timesheet-selector-title {
        display: block;

        margin-bottom: 4px;

        color:
            var(--ts-text);

        font-size: 17px;
        font-weight: 850;
    }


    .timesheet-selector-description {
        display: block;

        color:
            var(--ts-body);

        font-size: 15px;

        line-height: 1.55;
    }


    .timesheet-selector-form {
        min-width: 340px;
    }


    .timesheet-selector-select {
        width: 100%;

        min-height: 52px;

        padding:
            0
            42px
            0
            15px;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background: #FBFDFF;

        color:
            var(--ts-text);

        font-family: inherit;

        font-size: 15px;
        font-weight: 750;

        cursor: pointer;

        transition:
            var(--ts-transition);
    }


    .timesheet-selector-select:focus {
        border-color:
            var(--ts-blue);

        background: #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, 0.09);
    }


    /* ================================================================
       SUMMARY
       ================================================================ */

    .timesheet-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 19px;

        margin-bottom: 29px;
    }


    .timesheet-summary-card {
        padding: 24px;

        border:
            1px solid
            var(--ts-border);

        border-radius: 20px;

        background:
            var(--ts-white);

        box-shadow:
            var(--ts-shadow);

        transition:
            var(--ts-transition);
    }


    .timesheet-summary-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            0 18px 38px
            rgba(15, 42, 74, 0.10);
    }


    .timesheet-summary-icon {
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
            var(--ts-blue-soft);

        color:
            var(--ts-blue);
    }


    .summary-green {
        background:
            var(--ts-green-soft);

        color:
            var(--ts-green);
    }


    .summary-orange {
        background:
            var(--ts-orange-soft);

        color:
            var(--ts-orange);
    }


    .summary-purple {
        background:
            var(--ts-purple-soft);

        color:
            var(--ts-purple);
    }


    .timesheet-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--ts-body);

        font-size: 15px;
        font-weight: 750;
    }


    .timesheet-summary-value {
        display: block;

        color:
            var(--ts-text);

        font-size: 32px;
        font-weight: 900;

        line-height: 1.15;
    }


    .timesheet-summary-unit {
        color:
            var(--ts-muted);

        font-size: 16px;
        font-weight: 750;
    }


    .timesheet-summary-note {
        display: block;

        margin-top: 9px;

        color:
            var(--ts-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       MAIN LAYOUT
       ================================================================ */

    .timesheet-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1.35fr)
            minmax(350px, 0.65fr);

        gap: 23px;

        align-items: start;
    }


    .timesheet-main,
    .timesheet-sidebar {
        display: grid;

        gap: 23px;
    }


    /* ================================================================
       PANEL
       ================================================================ */

    .timesheet-panel {
        overflow: hidden;

        border:
            1px solid
            var(--ts-border);

        border-radius: 20px;

        background:
            var(--ts-white);

        box-shadow:
            var(--ts-shadow);
    }


    .timesheet-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            24px
            26px;

        border-bottom:
            1px solid
            var(--ts-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .timesheet-panel-heading {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    .timesheet-panel-icon {
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
            var(--ts-blue-soft);

        color:
            var(--ts-blue);
    }


    .panel-green {
        background:
            var(--ts-green-soft);

        color:
            var(--ts-green);
    }


    .panel-teal {
        background:
            var(--ts-teal-soft);

        color:
            var(--ts-teal);
    }


    .panel-purple {
        background:
            var(--ts-purple-soft);

        color:
            var(--ts-purple);
    }


    .panel-orange {
        background:
            var(--ts-orange-soft);

        color:
            var(--ts-orange);
    }


    .timesheet-panel-heading h2 {
        margin:
            0
            0
            4px;

        color:
            var(--ts-text);

        font-size: 23px;
        font-weight: 850;

        line-height: 1.3;
    }


    .timesheet-panel-heading p {
        margin: 0;

        color:
            var(--ts-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .timesheet-panel-body {
        padding: 26px;
    }


    /* ================================================================
       HOURS PROGRESS
       ================================================================ */

    .timesheet-progress-card {
        padding: 24px;

        border:
            1px solid
            #CEE5DF;

        border-radius: 18px;

        background:
            linear-gradient(
                135deg,
                #F7FCFB 0%,
                #EFF9F7 100%
            );
    }


    .timesheet-progress-top {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 17px;
    }


    .timesheet-progress-label {
        display: block;

        margin-bottom: 6px;

        color:
            var(--ts-muted);

        font-size: 14px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: 0.3px;
    }


    .timesheet-progress-value {
        color:
            var(--ts-text);

        font-size: 40px;
        font-weight: 900;

        line-height: 1.05;
    }


    .timesheet-progress-value small {
        color:
            var(--ts-muted);

        font-size: 16px;
        font-weight: 750;
    }


    .timesheet-progress-percent {
        color:
            var(--ts-teal);

        font-size: 31px;
        font-weight: 900;
    }


    .timesheet-progress-track {
        width: 100%;
        height: 12px;

        overflow: hidden;

        border-radius: 999px;

        background:
            #D9E7E4;
    }


    .timesheet-progress-fill {
        height: 100%;

        border-radius: inherit;

        background:
            linear-gradient(
                90deg,
                #2563EB,
                #0F766E
            );
    }


    .timesheet-progress-description {
        margin-top: 14px;

        color:
            var(--ts-body);

        font-size: 15px;

        line-height: 1.7;
    }


    .timesheet-progress-stat-grid {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 12px;

        margin-top: 19px;
    }


    .timesheet-progress-stat {
        padding: 15px;

        border:
            1px solid
            var(--ts-border-soft);

        border-radius: 12px;

        background:
            rgba(255, 255, 255, 0.83);
    }


    .timesheet-progress-stat-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--ts-muted);

        font-size: 13px;
        font-weight: 750;
    }


    .timesheet-progress-stat-value {
        display: block;

        color:
            var(--ts-text);

        font-size: 20px;
        font-weight: 900;
    }


    /* ================================================================
       TABLE
       ================================================================ */

    .timesheet-table-wrapper {
        overflow-x: auto;

        scrollbar-width: thin;
    }


    .timesheet-table {
        width: 100%;

        min-width: 1250px;

        border-collapse: collapse;
    }


    .timesheet-table th {
        padding:
            16px
            17px;

        border-bottom:
            1px solid
            var(--ts-border-soft);

        background:
            #F7FAFD;

        color:
            #4A6076;

        text-align: left;

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: 0.3px;

        white-space: nowrap;
    }


    .timesheet-table td {
        padding:
            19px
            17px;

        border-bottom:
            1px solid
            var(--ts-border-soft);

        color:
            var(--ts-body);

        font-size: 15px;

        line-height: 1.6;

        vertical-align: middle;
    }


    .timesheet-table tbody tr {
        transition:
            background 0.18s ease;
    }


    .timesheet-table tbody tr:hover {
        background: #FAFCFF;
    }


    .timesheet-table tbody tr:last-child td {
        border-bottom: none;
    }


    .timesheet-date {
        display: block;

        color:
            var(--ts-text);

        font-size: 16px;
        font-weight: 850;

        white-space: nowrap;
    }


    .timesheet-record-number {
        display: block;

        margin-top: 4px;

        color:
            var(--ts-muted);

        font-size: 13px;
    }


    .timesheet-time {
        color:
            var(--ts-text);

        font-size: 16px;
        font-weight: 850;

        white-space: nowrap;
    }


    .timesheet-hours {
        color:
            var(--ts-text);

        font-size: 17px;
        font-weight: 900;

        white-space: nowrap;
    }


    .timesheet-task {
        max-width: 300px;

        color:
            var(--ts-body);

        font-size: 15px;

        line-height: 1.65;
    }


    .timesheet-task strong {
        display: block;

        margin-bottom: 3px;

        color:
            var(--ts-text);

        font-size: 15px;
        font-weight: 850;
    }


    .timesheet-muted {
        color:
            var(--ts-muted);

        font-size: 14px;
    }


    /* ================================================================
       STATUS
       ================================================================ */

    .timesheet-status {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding:
            8px
            11px;

        border-radius: 999px;

        font-size: 13px;
        font-weight: 850;

        white-space: nowrap;
    }


    .timesheet-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .status-validated {
        background:
            var(--ts-green-soft);

        color:
            var(--ts-green);
    }


    .status-validated::before {
        background: #22C55E;
    }


    .status-pending {
        background:
            var(--ts-orange-soft);

        color:
            var(--ts-orange);
    }


    .status-pending::before {
        background: #F59E0B;
    }


    .status-rejected {
        background:
            var(--ts-red-soft);

        color:
            var(--ts-red);
    }


    .status-rejected::before {
        background: #EF4444;
    }


    .status-in-progress {
        background:
            var(--ts-blue-soft);

        color:
            var(--ts-blue);
    }


    .status-in-progress::before {
        background: #3B82F6;
    }


    .status-none {
        background:
            var(--ts-slate-soft);

        color:
            var(--ts-slate);
    }


    .status-none::before {
        background: #94A3B8;
    }


    /* ================================================================
       SUPERVISOR REMARKS
       ================================================================ */

    .timesheet-remarks {
        max-width: 240px;

        color:
            var(--ts-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       SIDEBAR LIST
       ================================================================ */

    .timesheet-sidebar-list {
        display: grid;

        gap: 12px;
    }


    .timesheet-sidebar-item {
        padding:
            14px
            15px;

        border:
            1px solid
            var(--ts-border-soft);

        border-radius: 12px;

        background:
            var(--ts-soft);
    }


    .timesheet-sidebar-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--ts-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: 0.3px;
    }


    .timesheet-sidebar-value {
        display: block;

        color:
            var(--ts-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.55;

        word-break: break-word;
    }


    /* ================================================================
       HOW HOURS WORK
       ================================================================ */

    .timesheet-guide {
        display: grid;

        gap: 15px;
    }


    .timesheet-guide-item {
        display: flex;
        align-items: flex-start;

        gap: 12px;
    }


    .timesheet-guide-number {
        width: 36px;
        height: 36px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background:
            var(--ts-blue-soft);

        color:
            var(--ts-blue);

        font-size: 13px;
        font-weight: 900;
    }


    .timesheet-guide-title {
        display: block;

        margin-bottom: 3px;

        color:
            var(--ts-text);

        font-size: 15px;
        font-weight: 850;
    }


    .timesheet-guide-description {
        display: block;

        color:
            var(--ts-body);

        font-size: 14px;

        line-height: 1.6;
    }


    /* ================================================================
       QUICK LINKS
       ================================================================ */

    .timesheet-quick-links {
        display: grid;

        gap: 11px;
    }


    .timesheet-quick-link {
        min-height: 51px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        padding:
            0
            15px;

        border:
            1px solid
            var(--ts-border);

        border-radius: 12px;

        background: #FFFFFF;

        color:
            var(--ts-navy);

        text-decoration: none;

        font-size: 15px;
        font-weight: 850;

        transition:
            var(--ts-transition);
    }


    .timesheet-quick-link:hover {
        transform:
            translateY(-1px);

        border-color:
            #B7C9DB;

        background:
            var(--ts-blue-soft);
    }


    .timesheet-link-arrow {
        font-size: 18px;
        font-weight: 900;
    }


    /* ================================================================
       RECORD GUIDE
       ================================================================ */

    .record-guide-list {
        display: grid;

        gap: 12px;
    }


    .record-guide-item {
        display: flex;
        align-items: flex-start;

        gap: 11px;
    }


    .record-guide-copy strong {
        display: block;

        margin-bottom: 2px;

        color:
            var(--ts-text);

        font-size: 15px;
        font-weight: 850;
    }


    .record-guide-copy span {
        color:
            var(--ts-body);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       INFO NOTE
       ================================================================ */

    .timesheet-info-note {
        padding: 16px;

        border:
            1px solid
            #D5E4F2;

        border-radius: 13px;

        background:
            #F5FAFE;

        color:
            var(--ts-body);

        font-size: 15px;

        line-height: 1.7;
    }


    .timesheet-info-note strong {
        color:
            var(--ts-text);
    }


    /* ================================================================
       PAGINATION
       ================================================================ */

    .timesheet-pagination {
        padding:
            22px
            26px;

        border-top:
            1px solid
            var(--ts-border-soft);
    }


    /* ================================================================
       EMPTY STATE
       ================================================================ */

    .timesheet-empty {
        padding:
            45px
            24px;

        text-align: center;
    }


    .timesheet-empty-icon {
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
            var(--ts-blue-soft);

        color:
            var(--ts-blue);

        font-size: 16px;
        font-weight: 900;
    }


    .timesheet-empty h3 {
        margin:
            0
            0
            8px;

        color:
            var(--ts-text);

        font-size: 21px;
        font-weight: 850;
    }


    .timesheet-empty p {
        max-width: 560px;

        margin:
            0
            auto;

        color:
            var(--ts-body);

        font-size: 15px;

        line-height: 1.7;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1150px) {

        .timesheet-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .timesheet-layout {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 850px) {

        .timesheet-hero {
            padding:
                34px
                28px;
        }


        .timesheet-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .timesheet-placement-card {
            width: 100%;
        }


        .timesheet-selector {
            flex-direction: column;

            align-items: stretch;
        }


        .timesheet-selector-form {
            min-width: 0;

            width: 100%;
        }

    }


    @media (max-width: 650px) {

        .student-timesheet-page {
            font-size: 16px;
        }


        .timesheet-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .timesheet-hero h1 {
            font-size: 31px;
        }


        .timesheet-hero-description {
            font-size: 16px;
        }


        .timesheet-summary-grid,
        .timesheet-progress-stat-grid {
            grid-template-columns: 1fr;
        }


        .timesheet-panel-header,
        .timesheet-panel-body {
            padding-left: 20px;
            padding-right: 20px;
        }


        .timesheet-panel-header {
            align-items: flex-start;
        }


        .timesheet-panel-heading h2 {
            font-size: 21px;
        }


        .timesheet-progress-top {
            flex-direction: column;

            align-items: flex-start;
        }


        .timesheet-progress-value {
            font-size: 34px;
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
    | Load Student Assignments
    |--------------------------------------------------------------------------
    |
    | The controller can still provide its own assignment variables.
    | This fallback keeps the page usable for active and historical records.
    |
    */

    if ($studentProfile) {

        $studentAssignments =
            $studentProfile
                ->ojtAssignments()
                ->with([
                    'company',
                    'supervisor',
                    'attendanceRecords',
                    'dailyWorkLogs',
                ])
                ->latest('start_date')
                ->get();

    } else {

        $studentAssignments =
            collect();

    }


    /*
    |--------------------------------------------------------------------------
    | Requested Historical Assignment
    |--------------------------------------------------------------------------
    */

    $requestedAssignmentId =
        (int) request(
            'assignment',
            0
        );


    $requestedAssignment =
        $requestedAssignmentId > 0
            ? $studentAssignments
                ->first(
                    fn ($item) =>
                        (int) $item->id
                        ===
                        $requestedAssignmentId
                )
            : null;


    /*
    |--------------------------------------------------------------------------
    | Controller Provided Assignment
    |--------------------------------------------------------------------------
    */

    $controllerAssignment =
        $assignment
        ?? $displayAssignment
        ?? null;


    /*
    |--------------------------------------------------------------------------
    | Selected Assignment
    |--------------------------------------------------------------------------
    |
    | Historical query parameter comes before the active fallback.
    |
    */

    $selectedAssignment =
        $controllerAssignment
        ?? $requestedAssignment
        ?? $activeAssignment
        ?? $studentAssignments
            ->first(
                fn ($item) =>
                    (string) $item->status
                    ===
                    \App\Models\OjtAssignment::STATUS_ACTIVE
            )
        ?? $studentAssignments->first();


    if ($selectedAssignment) {

        $selectedAssignment->loadMissing([
            'company',
            'supervisor',
            'attendanceRecords',
            'dailyWorkLogs',
        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Attendance Records
    |--------------------------------------------------------------------------
    |
    | If the existing TimesheetController already sends $records,
    | preserve its paginator. Otherwise use the selected assignment
    | relationship.
    |
    */

    $timesheetRecords =
        isset($records)
            ? $records
            : collect(
                $selectedAssignment
                    ?->attendanceRecords
                ?? []
            );


    $pageRecords =
        method_exists(
            $timesheetRecords,
            'getCollection'
        )
            ? $timesheetRecords->getCollection()
            : collect(
                $timesheetRecords
            );


    /*
    |--------------------------------------------------------------------------
    | All Records for Accurate Summary
    |--------------------------------------------------------------------------
    */

    $allAttendanceRecords =
        $selectedAssignment
            ? collect(
                $selectedAssignment
                    ->attendanceRecords
                ?? []
            )
            : $pageRecords;


    /*
    |--------------------------------------------------------------------------
    | Work Logs
    |--------------------------------------------------------------------------
    */

    $workLogs =
        $selectedAssignment
            ? collect(
                $selectedAssignment
                    ->dailyWorkLogs
                ?? []
            )
            : collect();


    /*
    |--------------------------------------------------------------------------
    | Validated Attendance
    |--------------------------------------------------------------------------
    */

    $validatedRecords =
        $allAttendanceRecords
            ->filter(
                fn ($record) =>
                    strtolower(
                        (string) $record->status
                    ) === 'validated'
            );


    $pendingRecords =
        $allAttendanceRecords
            ->filter(
                fn ($record) =>
                    strtolower(
                        (string) $record->status
                    ) === 'pending'
            );


    $rejectedRecords =
        $allAttendanceRecords
            ->filter(
                fn ($record) =>
                    strtolower(
                        (string) $record->status
                    ) === 'rejected'
            );


    /*
    |--------------------------------------------------------------------------
    | Hours
    |--------------------------------------------------------------------------
    */

    $requiredHours =
        $selectedAssignment
            ? (float) (
                $selectedAssignment
                    ->required_hours
                ?? 0
            )
            : 0;


    $validatedMinutes =
        (int) $validatedRecords
            ->sum(
                fn ($record) =>
                    (int) (
                        $record->rendered_minutes
                        ?? 0
                    )
            );


    $validatedHours =
        $validatedMinutes / 60;


    $recordedMinutes =
        (int) $allAttendanceRecords
            ->sum(
                fn ($record) =>
                    (int) (
                        $record->rendered_minutes
                        ?? 0
                    )
            );


    $recordedHours =
        $recordedMinutes / 60;


    $requiredMinutes =
        (int) round(
            $requiredHours * 60
        );


    $remainingMinutes =
        max(
            0,
            $requiredMinutes
            - $validatedMinutes
        );


    $remainingHours =
        $remainingMinutes / 60;


    $progressPercentage =
        $requiredMinutes > 0
            ? min(
                100,
                (int) round(
                    (
                        $validatedMinutes
                        /
                        $requiredMinutes
                    ) * 100
                )
            )
            : 0;


    /*
    |--------------------------------------------------------------------------
    | Assignment Status
    |--------------------------------------------------------------------------
    */

    $assignmentStatus =
        $selectedAssignment
            ? strtolower(
                (string)
                $selectedAssignment->status
            )
            : null;


    /*
    |--------------------------------------------------------------------------
    | Date Formatter
    |--------------------------------------------------------------------------
    */

    $formatDate =
        function ($value) {

            if (! $value) {
                return '—';
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
    | Time Formatter
    |--------------------------------------------------------------------------
    */

    $formatTime =
        function ($value) {

            if (! $value) {
                return '—';
            }


            try {

                return
                    \Illuminate\Support\Carbon::parse(
                        $value
                    )
                        ->timezone(
                            'Asia/Manila'
                        )
                        ->format(
                            'h:i A'
                        );

            } catch (\Throwable $exception) {

                return (string) $value;

            }

        };


    /*
    |--------------------------------------------------------------------------
    | Attendance Status Styling
    |--------------------------------------------------------------------------
    */

    $statusClass =
        function ($status) {

            return match (
                strtolower(
                    (string) $status
                )
            ) {

                'validated' =>
                    'status-validated',

                'pending' =>
                    'status-pending',

                'rejected' =>
                    'status-rejected',

                'in_progress',
                'in progress' =>
                    'status-in-progress',

                default =>
                    'status-none',

            };

        };


    $statusLabel =
        function ($status) {

            if (blank($status)) {
                return 'Not Available';
            }


            return ucwords(
                str_replace(
                    '_',
                    ' ',
                    (string) $status
                )
            );

        };


    /*
    |--------------------------------------------------------------------------
    | Find Work Log for Attendance Record
    |--------------------------------------------------------------------------
    */

    $findWorkLog =
        function ($attendanceRecord) use (
            $workLogs
        ) {

            return $workLogs
                ->first(
                    fn ($log) =>
                        (int) (
                            $log->attendance_record_id
                            ?? 0
                        )
                        ===
                        (int) $attendanceRecord->id
                );

        };


    /*
    |--------------------------------------------------------------------------
    | Timesheet Route
    |--------------------------------------------------------------------------
    */

    $timesheetIndexUrl =
        \Illuminate\Support\Facades\Route::has(
            'student.timesheets.index'
        )
            ? route(
                'student.timesheets.index'
            )
            : url(
                '/student/timesheets'
            );

@endphp


<div class="student-timesheet-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="timesheet-hero">


        <div class="timesheet-hero-inner">


            <div class="timesheet-hero-copy">


                <div class="timesheet-hero-eyebrow">


                    <span class="timesheet-hero-dot"></span>


                    Student Portal · Rendered Hours Monitoring


                </div>


                <h1>
                    My OJT Timesheet
                </h1>


                <p class="timesheet-hero-description">

                    Review your daily Time In and Time Out,
                    rendered hours, Daily Work Log activities,
                    and Supervisor validation. Validated
                    attendance contributes to your official
                    OJT hour progress.

                </p>


            </div>


            <div class="timesheet-placement-card">


                <span class="timesheet-placement-label">
                    Selected OJT Placement
                </span>


                <span class="timesheet-placement-company">

                    {{ $selectedAssignment
                        ? (
                            $selectedAssignment
                                ->company
                                ?->name
                            ?? 'Company unavailable'
                        )
                        : 'No OJT Assignment'
                    }}

                </span>


                <span class="timesheet-placement-supervisor">


                    @if ($selectedAssignment)

                        Supervisor:

                        {{ $selectedAssignment
                            ->supervisor
                            ?->name
                            ?? 'Not assigned'
                        }}

                    @else

                        Your timesheet becomes available
                        after an OJT Assignment is created.

                    @endif


                </span>


                @if ($selectedAssignment)


                    <div class="timesheet-placement-footer">


                        <span class="timesheet-placement-status">

                            {{ ucfirst(
                                $assignmentStatus
                            ) }}

                        </span>


                        <span class="timesheet-placement-hours">

                            {{ number_format(
                                $requiredHours
                            ) }}

                            required hrs

                        </span>


                    </div>


                @endif


            </div>


        </div>


    </section>


    {{-- ==================================================================
         ASSIGNMENT SELECTOR
         ================================================================== --}}

    @if ($studentAssignments->count() > 1)


        <section class="timesheet-selector">


            <div class="timesheet-selector-copy">


                <span class="timesheet-selector-title">
                    Choose an OJT Assignment
                </span>


                <span class="timesheet-selector-description">

                    Switch between your current placement
                    and previous OJT assignment records.

                </span>


            </div>


            <form
                method="GET"
                action="{{ $timesheetIndexUrl }}"
                class="timesheet-selector-form"
            >


                <select
                    name="assignment"
                    class="timesheet-selector-select"
                    onchange="this.form.submit()"
                    aria-label="Choose OJT assignment"
                >


                    @foreach ($studentAssignments as $assignmentOption)


                        <option
                            value="{{ $assignmentOption->id }}"
                            @selected(
                                $selectedAssignment
                                &&
                                (int) $selectedAssignment->id
                                ===
                                (int) $assignmentOption->id
                            )
                        >

                            {{ $assignmentOption
                                ->company
                                ?->name
                                ?? 'Company unavailable'
                            }}

                            —

                            {{ $formatDate(
                                $assignmentOption->start_date
                            ) }}

                            —

                            {{ ucfirst(
                                (string)
                                $assignmentOption->status
                            ) }}

                        </option>


                    @endforeach


                </select>


            </form>


        </section>


    @endif


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="timesheet-summary-grid">


        <article class="timesheet-summary-card">


            <div class="timesheet-summary-icon summary-blue">
                RH
            </div>


            <span class="timesheet-summary-label">
                Required OJT Hours
            </span>


            <span class="timesheet-summary-value">

                {{ number_format(
                    $requiredHours,
                    1
                ) }}

                <span class="timesheet-summary-unit">
                    hrs
                </span>

            </span>


            <span class="timesheet-summary-note">

                Total required training hours
                for this placement.

            </span>


        </article>


        <article class="timesheet-summary-card">


            <div class="timesheet-summary-icon summary-green">
                VH
            </div>


            <span class="timesheet-summary-label">
                Validated Hours
            </span>


            <span class="timesheet-summary-value">

                {{ number_format(
                    $validatedHours,
                    1
                ) }}

                <span class="timesheet-summary-unit">
                    hrs
                </span>

            </span>


            <span class="timesheet-summary-note">

                Official hours approved through
                Supervisor-validated attendance.

            </span>


        </article>


        <article class="timesheet-summary-card">


            <div class="timesheet-summary-icon summary-orange">
                RM
            </div>


            <span class="timesheet-summary-label">
                Remaining Hours
            </span>


            <span class="timesheet-summary-value">

                {{ number_format(
                    $remainingHours,
                    1
                ) }}

                <span class="timesheet-summary-unit">
                    hrs
                </span>

            </span>


            <span class="timesheet-summary-note">

                Hours still needed to reach
                the required OJT total.

            </span>


        </article>


        <article class="timesheet-summary-card">


            <div class="timesheet-summary-icon summary-purple">
                %
            </div>


            <span class="timesheet-summary-label">
                OJT Hour Progress
            </span>


            <span class="timesheet-summary-value">

                {{ $progressPercentage }}%

            </span>


            <span class="timesheet-summary-note">

                Based only on validated
                rendered attendance hours.

            </span>


        </article>


    </section>


    {{-- ==================================================================
         MAIN
         ================================================================== --}}

    <div class="timesheet-layout">


        <main class="timesheet-main">


            {{-- ==========================================================
                 HOURS PROGRESS
                 ========================================================== --}}

            <section class="timesheet-panel">


                <div class="timesheet-panel-header">


                    <div class="timesheet-panel-heading">


                        <div class="timesheet-panel-icon panel-teal">
                            HR
                        </div>


                        <div>


                            <h2>
                                OJT Hours Progress
                            </h2>


                            <p>
                                Validated rendered-hour monitoring
                            </p>


                        </div>


                    </div>


                </div>


                <div class="timesheet-panel-body">


                    @if ($selectedAssignment)


                        <div class="timesheet-progress-card">


                            <div class="timesheet-progress-top">


                                <div>


                                    <span class="timesheet-progress-label">
                                        Official Validated Hours
                                    </span>


                                    <div class="timesheet-progress-value">

                                        {{ number_format(
                                            $validatedHours,
                                            1
                                        ) }}

                                        <small>

                                            /
                                            {{ number_format(
                                                $requiredHours,
                                                1
                                            ) }}
                                            hours

                                        </small>


                                    </div>


                                </div>


                                <div class="timesheet-progress-percent">

                                    {{ $progressPercentage }}%

                                </div>


                            </div>


                            <div class="timesheet-progress-track">


                                <div
                                    class="timesheet-progress-fill"
                                    style="
                                        width:
                                        {{ $progressPercentage }}%;
                                    "
                                ></div>


                            </div>


                            <div class="timesheet-progress-description">

                                Attendance may already contain calculated
                                rendered time before validation, but your
                                official OJT progress shown above only
                                credits attendance that has been validated
                                by your Supervisor.

                            </div>


                            <div class="timesheet-progress-stat-grid">


                                <div class="timesheet-progress-stat">


                                    <span class="timesheet-progress-stat-label">
                                        Recorded Hours
                                    </span>


                                    <span class="timesheet-progress-stat-value">

                                        {{ number_format(
                                            $recordedHours,
                                            1
                                        ) }}

                                    </span>


                                </div>


                                <div class="timesheet-progress-stat">


                                    <span class="timesheet-progress-stat-label">
                                        Validated Days
                                    </span>


                                    <span class="timesheet-progress-stat-value">

                                        {{ $validatedRecords->count() }}

                                    </span>


                                </div>


                                <div class="timesheet-progress-stat">


                                    <span class="timesheet-progress-stat-label">
                                        Pending Review
                                    </span>


                                    <span class="timesheet-progress-stat-value">

                                        {{ $pendingRecords->count() }}

                                    </span>


                                </div>


                            </div>


                        </div>


                    @else


                        <div class="timesheet-empty">


                            <div class="timesheet-empty-icon">
                                HR
                            </div>


                            <h3>
                                No OJT Assignment Yet
                            </h3>


                            <p>

                                Your required hours,
                                validated rendered hours,
                                and remaining OJT progress
                                will appear here once an
                                OJT Assignment is available.

                            </p>


                        </div>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 TIMESHEET RECORDS
                 ========================================================== --}}

            <section class="timesheet-panel">


                <div class="timesheet-panel-header">


                    <div class="timesheet-panel-heading">


                        <div class="timesheet-panel-icon panel-blue">
                            TS
                        </div>


                        <div>


                            <h2>
                                Daily Timesheet Records
                            </h2>


                            <p>
                                Time In, Time Out, tasks, hours, and validation
                            </p>


                        </div>


                    </div>


                    @if ($selectedAssignment)


                        <span
                            style="
                                padding:8px 12px;
                                border-radius:999px;
                                background:#F1F5F9;
                                color:#405872;
                                font-size:14px;
                                font-weight:850;
                                white-space:nowrap;
                            "
                        >

                            {{ $allAttendanceRecords->count() }}
                            records

                        </span>


                    @endif


                </div>


                @if ($pageRecords->isNotEmpty())


                    <div class="timesheet-table-wrapper">


                        <table class="timesheet-table">


                            <thead>


                                <tr>

                                    <th>Date</th>

                                    <th>Time In</th>

                                    <th>Time Out</th>

                                    <th>Rendered</th>

                                    <th>Daily Tasks</th>

                                    <th>Attendance</th>

                                    <th>Work Log</th>

                                    <th>Supervisor Remarks</th>

                                </tr>


                            </thead>


                            <tbody>


                                @foreach ($timesheetRecords as $record)


                                    @php

                                        $recordRenderedMinutes =
                                            (int) (
                                                $record
                                                    ->rendered_minutes
                                                ?? 0
                                            );


                                        $recordRenderedHours =
                                            $recordRenderedMinutes / 60;


                                        $workLog =
                                            $findWorkLog(
                                                $record
                                            );


                                        $attendanceStatus =
                                            strtolower(
                                                (string)
                                                $record->status
                                            );


                                        $workLogStatus =
                                            $workLog
                                                ? strtolower(
                                                    (string)
                                                    $workLog->status
                                                )
                                                : null;

                                    @endphp


                                    <tr>


                                        {{-- ==================================
                                             DATE
                                             ================================== --}}

                                        <td>


                                            <span class="timesheet-date">

                                                {{ $formatDate(
                                                    $record
                                                        ->attendance_date
                                                ) }}

                                            </span>


                                            <span class="timesheet-record-number">

                                                Record #{{ $record->id }}

                                            </span>


                                        </td>


                                        {{-- ==================================
                                             TIME IN
                                             ================================== --}}

                                        <td>


                                            <span class="timesheet-time">

                                                {{ $formatTime(
                                                    $record->time_in
                                                ) }}

                                            </span>


                                        </td>


                                        {{-- ==================================
                                             TIME OUT
                                             ================================== --}}

                                        <td>


                                            <span class="timesheet-time">

                                                {{ $formatTime(
                                                    $record->time_out
                                                ) }}

                                            </span>


                                        </td>


                                        {{-- ==================================
                                             RENDERED
                                             ================================== --}}

                                        <td>


                                            @if (
                                                $record->time_out
                                                !== null
                                            )


                                                <span class="timesheet-hours">

                                                    {{ number_format(
                                                        $recordRenderedHours,
                                                        1
                                                    ) }}

                                                    hrs

                                                </span>


                                            @else


                                                <span class="timesheet-muted">
                                                    In progress
                                                </span>


                                            @endif


                                        </td>


                                        {{-- ==================================
                                             TASKS
                                             ================================== --}}

                                        <td>


                                            @if ($workLog)


                                                <div class="timesheet-task">


                                                    <strong>
                                                        Daily Work Log
                                                    </strong>


                                                    {{ \Illuminate\Support\Str::limit(
                                                        $workLog->tasks
                                                            ?: 'No task description provided.',
                                                        145
                                                    ) }}


                                                </div>


                                            @else


                                                <span class="timesheet-muted">

                                                    No Daily Work Log
                                                    linked yet.

                                                </span>


                                            @endif


                                        </td>


                                        {{-- ==================================
                                             ATTENDANCE STATUS
                                             ================================== --}}

                                        <td>


                                            <span
                                                class="
                                                    timesheet-status
                                                    {{ $statusClass(
                                                        $attendanceStatus
                                                    ) }}
                                                "
                                            >

                                                {{ $statusLabel(
                                                    $attendanceStatus
                                                ) }}

                                            </span>


                                        </td>


                                        {{-- ==================================
                                             WORK LOG STATUS
                                             ================================== --}}

                                        <td>


                                            @if ($workLog)


                                                <span
                                                    class="
                                                        timesheet-status
                                                        {{ $statusClass(
                                                            $workLogStatus
                                                        ) }}
                                                    "
                                                >

                                                    {{ $statusLabel(
                                                        $workLogStatus
                                                    ) }}

                                                </span>


                                            @else


                                                <span
                                                    class="
                                                        timesheet-status
                                                        status-none
                                                    "
                                                >
                                                    Not Submitted
                                                </span>


                                            @endif


                                        </td>


                                        {{-- ==================================
                                             REMARKS
                                             ================================== --}}

                                        <td>


                                            @if (
                                                filled(
                                                    $record
                                                        ->supervisor_remarks
                                                )
                                            )


                                                <div class="timesheet-remarks">

                                                    {{ $record
                                                        ->supervisor_remarks
                                                    }}

                                                </div>


                                            @elseif (
                                                $workLog
                                                &&
                                                filled(
                                                    $workLog
                                                        ->supervisor_remarks
                                                )
                                            )


                                                <div class="timesheet-remarks">

                                                    {{ $workLog
                                                        ->supervisor_remarks
                                                    }}

                                                </div>


                                            @else


                                                <span class="timesheet-muted">
                                                    No remarks
                                                </span>


                                            @endif


                                        </td>


                                    </tr>


                                @endforeach


                            </tbody>


                        </table>


                    </div>


                    @if (
                        method_exists(
                            $timesheetRecords,
                            'hasPages'
                        )
                        &&
                        $timesheetRecords->hasPages()
                    )


                        <div class="timesheet-pagination">

                            {{ $timesheetRecords
                                ->withQueryString()
                                ->links()
                            }}

                        </div>


                    @endif


                @else


                    <div class="timesheet-empty">


                        <div class="timesheet-empty-icon">
                            TS
                        </div>


                        <h3>
                            No Timesheet Records Yet
                        </h3>


                        <p>

                            Your daily Time In,
                            Time Out, rendered hours,
                            work activities, and validation
                            status will appear here once
                            you begin recording OJT attendance.

                        </p>


                    </div>


                @endif


            </section>


        </main>


        {{-- ==============================================================
             SIDEBAR
             ============================================================== --}}

        <aside class="timesheet-sidebar">


            {{-- ==========================================================
                 PLACEMENT
                 ========================================================== --}}

            <section class="timesheet-panel">


                <div class="timesheet-panel-header">


                    <div class="timesheet-panel-heading">


                        <div class="timesheet-panel-icon panel-teal">
                            OJ
                        </div>


                        <div>


                            <h2>
                                OJT Placement
                            </h2>


                            <p>
                                Selected assignment information
                            </p>


                        </div>


                    </div>


                </div>


                <div class="timesheet-panel-body">


                    @if ($selectedAssignment)


                        <div class="timesheet-sidebar-list">


                            <div class="timesheet-sidebar-item">


                                <span class="timesheet-sidebar-label">
                                    Company
                                </span>


                                <span class="timesheet-sidebar-value">

                                    {{ $selectedAssignment
                                        ->company
                                        ?->name
                                        ?? 'Not available'
                                    }}

                                </span>


                            </div>


                            <div class="timesheet-sidebar-item">


                                <span class="timesheet-sidebar-label">
                                    Supervisor
                                </span>


                                <span class="timesheet-sidebar-value">

                                    {{ $selectedAssignment
                                        ->supervisor
                                        ?->name
                                        ?? 'Not assigned'
                                    }}

                                </span>


                            </div>


                            <div class="timesheet-sidebar-item">


                                <span class="timesheet-sidebar-label">
                                    Required Hours
                                </span>


                                <span class="timesheet-sidebar-value">

                                    {{ number_format(
                                        $requiredHours,
                                        1
                                    ) }}

                                    hours

                                </span>


                            </div>


                            <div class="timesheet-sidebar-item">


                                <span class="timesheet-sidebar-label">
                                    Training Period
                                </span>


                                <span class="timesheet-sidebar-value">

                                    {{ $formatDate(
                                        $selectedAssignment
                                            ->start_date
                                    ) }}

                                    →

                                    {{ $formatDate(
                                        $selectedAssignment
                                            ->end_date
                                    ) }}

                                </span>


                            </div>


                            <div class="timesheet-sidebar-item">


                                <span class="timesheet-sidebar-label">
                                    Assignment Status
                                </span>


                                <span class="timesheet-sidebar-value">

                                    {{ ucfirst(
                                        $assignmentStatus
                                    ) }}

                                </span>


                            </div>


                        </div>


                    @else


                        <div class="timesheet-info-note">

                            <strong>
                                No assignment selected.
                            </strong>

                            Timesheet details become available
                            once you have an OJT Assignment.

                        </div>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 VALIDATION SUMMARY
                 ========================================================== --}}

            <section class="timesheet-panel">


                <div class="timesheet-panel-header">


                    <div class="timesheet-panel-heading">


                        <div class="timesheet-panel-icon panel-green">
                            VL
                        </div>


                        <div>


                            <h2>
                                Validation Summary
                            </h2>


                            <p>
                                Supervisor review overview
                            </p>


                        </div>


                    </div>


                </div>


                <div class="timesheet-panel-body">


                    <div class="timesheet-sidebar-list">


                        <div class="timesheet-sidebar-item">


                            <span class="timesheet-sidebar-label">
                                Validated Attendance
                            </span>


                            <span class="timesheet-sidebar-value">

                                {{ $validatedRecords->count() }}

                                record{{ $validatedRecords->count() === 1 ? '' : 's' }}

                            </span>


                        </div>


                        <div class="timesheet-sidebar-item">


                            <span class="timesheet-sidebar-label">
                                Pending Attendance
                            </span>


                            <span class="timesheet-sidebar-value">

                                {{ $pendingRecords->count() }}

                                record{{ $pendingRecords->count() === 1 ? '' : 's' }}

                            </span>


                        </div>


                        <div class="timesheet-sidebar-item">


                            <span class="timesheet-sidebar-label">
                                Rejected Attendance
                            </span>


                            <span class="timesheet-sidebar-value">

                                {{ $rejectedRecords->count() }}

                                record{{ $rejectedRecords->count() === 1 ? '' : 's' }}

                            </span>


                        </div>


                        <div class="timesheet-sidebar-item">


                            <span class="timesheet-sidebar-label">
                                Daily Work Logs
                            </span>


                            <span class="timesheet-sidebar-value">

                                {{ $workLogs->count() }}

                                submitted

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 HOW HOURS ARE CALCULATED
                 ========================================================== --}}

            <section class="timesheet-panel">


                <div class="timesheet-panel-header">


                    <div class="timesheet-panel-heading">


                        <div class="timesheet-panel-icon panel-blue">
                            123
                        </div>


                        <div>


                            <h2>
                                How Hours Work
                            </h2>


                            <p>
                                Understanding your OJT timesheet
                            </p>


                        </div>


                    </div>


                </div>


                <div class="timesheet-panel-body">


                    <div class="timesheet-guide">


                        <div class="timesheet-guide-item">


                            <div class="timesheet-guide-number">
                                1
                            </div>


                            <div>


                                <span class="timesheet-guide-title">
                                    Record Attendance
                                </span>


                                <span class="timesheet-guide-description">

                                    Your Time In and Time Out
                                    create the attendance record
                                    used for your daily timesheet.

                                </span>


                            </div>


                        </div>


                        <div class="timesheet-guide-item">


                            <div class="timesheet-guide-number">
                                2
                            </div>


                            <div>


                                <span class="timesheet-guide-title">
                                    Rendered Time Is Calculated
                                </span>


                                <span class="timesheet-guide-description">

                                    OJT Sync calculates the
                                    elapsed time between your
                                    recorded Time In and Time Out.

                                </span>


                            </div>


                        </div>


                        <div class="timesheet-guide-item">


                            <div class="timesheet-guide-number">
                                3
                            </div>


                            <div>


                                <span class="timesheet-guide-title">
                                    Supervisor Reviews It
                                </span>


                                <span class="timesheet-guide-description">

                                    Completed attendance waits
                                    for Supervisor validation.

                                </span>


                            </div>


                        </div>


                        <div class="timesheet-guide-item">


                            <div class="timesheet-guide-number">
                                4
                            </div>


                            <div>


                                <span class="timesheet-guide-title">
                                    Hours Become Official
                                </span>


                                <span class="timesheet-guide-description">

                                    Only validated attendance
                                    contributes to the official
                                    rendered-hour progress shown here.

                                </span>


                            </div>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 RECORD GUIDE
                 ========================================================== --}}

            <section class="timesheet-panel">


                <div class="timesheet-panel-header">


                    <div class="timesheet-panel-heading">


                        <div class="timesheet-panel-icon panel-orange">
                            ST
                        </div>


                        <div>


                            <h2>
                                Record Status Guide
                            </h2>


                            <p>
                                Meaning of each validation status
                            </p>


                        </div>


                    </div>


                </div>


                <div class="timesheet-panel-body">


                    <div class="record-guide-list">


                        <div class="record-guide-item">


                            <span
                                class="
                                    timesheet-status
                                    status-in-progress
                                "
                            >
                                In Progress
                            </span>


                            <div class="record-guide-copy">


                                <strong>
                                    Workday is still open
                                </strong>


                                <span>

                                    Time In exists but Time Out
                                    has not been completed yet.

                                </span>


                            </div>


                        </div>


                        <div class="record-guide-item">


                            <span
                                class="
                                    timesheet-status
                                    status-pending
                                "
                            >
                                Pending
                            </span>


                            <div class="record-guide-copy">


                                <strong>
                                    Waiting for review
                                </strong>


                                <span>

                                    Time Out has been submitted
                                    and the Supervisor still needs
                                    to review the record.

                                </span>


                            </div>


                        </div>


                        <div class="record-guide-item">


                            <span
                                class="
                                    timesheet-status
                                    status-validated
                                "
                            >
                                Validated
                            </span>


                            <div class="record-guide-copy">


                                <strong>
                                    Approved record
                                </strong>


                                <span>

                                    Rendered time is credited
                                    toward your official OJT hours.

                                </span>


                            </div>


                        </div>


                        <div class="record-guide-item">


                            <span
                                class="
                                    timesheet-status
                                    status-rejected
                                "
                            >
                                Rejected
                            </span>


                            <div class="record-guide-copy">


                                <strong>
                                    Requires attention
                                </strong>


                                <span>

                                    Review the Supervisor remarks
                                    connected to the record.

                                </span>


                            </div>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 QUICK LINKS
                 ========================================================== --}}

            <section class="timesheet-panel">


                <div class="timesheet-panel-header">


                    <div class="timesheet-panel-heading">


                        <div class="timesheet-panel-icon panel-purple">
                            GO
                        </div>


                        <div>


                            <h2>
                                Related OJT Pages
                            </h2>


                            <p>
                                Continue managing your records
                            </p>


                        </div>


                    </div>


                </div>


                <div class="timesheet-panel-body">


                    <div class="timesheet-quick-links">


                        @if (
                            \Illuminate\Support\Facades\Route::has(
                                'student.attendance.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.attendance.index'
                                ) }}"
                                class="timesheet-quick-link"
                            >

                                <span>
                                    GPS Selfie Attendance
                                </span>

                                <span class="timesheet-link-arrow">
                                    →
                                </span>

                            </a>


                        @endif


                        @if (
                            \Illuminate\Support\Facades\Route::has(
                                'student.work-logs.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.work-logs.index'
                                ) }}"
                                class="timesheet-quick-link"
                            >

                                <span>
                                    Daily Work Logs
                                </span>

                                <span class="timesheet-link-arrow">
                                    →
                                </span>

                            </a>


                        @endif


                        @if (
                            \Illuminate\Support\Facades\Route::has(
                                'student.reports.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.reports.index'
                                ) }}"
                                class="timesheet-quick-link"
                            >

                                <span>
                                    My OJT Report
                                </span>

                                <span class="timesheet-link-arrow">
                                    →
                                </span>

                            </a>


                        @endif


                        @if (
                            \Illuminate\Support\Facades\Route::has(
                                'student.assignment-history.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.assignment-history.index'
                                ) }}"
                                class="timesheet-quick-link"
                            >

                                <span>
                                    Assignment History
                                </span>

                                <span class="timesheet-link-arrow">
                                    →
                                </span>

                            </a>


                        @endif


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 IMPORTANT NOTE
                 ========================================================== --}}

            <section class="timesheet-panel">


                <div class="timesheet-panel-header">


                    <div class="timesheet-panel-heading">


                        <div class="timesheet-panel-icon panel-teal">
                            i
                        </div>


                        <div>


                            <h2>
                                Timesheet Reminder
                            </h2>


                            <p>
                                Keep your OJT records complete
                            </p>


                        </div>


                    </div>


                </div>


                <div class="timesheet-panel-body">


                    <div class="timesheet-info-note">

                        <strong>
                            Rendered time and validated time are not always the same.
                        </strong>

                        A completed attendance record may already
                        contain calculated rendered minutes, but
                        only Supervisor-validated attendance is
                        credited toward the official progress
                        displayed on this page.

                    </div>


                </div>


            </section>


        </aside>


    </div>


</div>


@endsection