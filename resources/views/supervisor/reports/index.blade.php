@extends('layouts.app')


@section('title', 'Supervisor Reports | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       SUPERVISOR REPORT & MONITORING CENTER
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --report-navy: #183B6B;
        --report-navy-dark: #102A4A;
        --report-navy-deep: #0B223D;

        --report-blue: #2563EB;
        --report-blue-soft: #EAF2FF;

        --report-teal: #0F766E;
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

        --report-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --report-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .supervisor-report-page {
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

        margin-bottom: 30px;

        padding:
            42px
            44px;

        border-radius: 28px;

        background:
            radial-gradient(
                circle at 88% 14%,
                rgba(45, 212, 191, 0.23),
                transparent 25%
            ),
            radial-gradient(
                circle at 70% 88%,
                rgba(96, 165, 250, 0.14),
                transparent 29%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 52%,
                #17666B 100%
            );

        box-shadow:
            var(--report-shadow-large);
    }


    .report-hero::before {
        content: "";

        position: absolute;

        width: 350px;
        height: 350px;

        right: -140px;
        top: -195px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.06);
    }


    .report-hero::after {
        content: "";

        position: absolute;

        width: 220px;
        height: 220px;

        right: 260px;
        bottom: -150px;

        border-radius: 50%;

        background:
            rgba(45, 212, 191, 0.08);
    }


    .report-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 36px;
    }


    .report-hero-copy {
        min-width: 0;

        max-width: 770px;
    }


    .report-hero-eyebrow {
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
            rgba(255, 255, 255, 0.93);

        font-size: 14px;
        font-weight: 800;
    }


    .report-hero-dot {
        width: 9px;
        height: 9px;

        flex-shrink: 0;

        border-radius: 50%;

        background:
            #2DD4BF;

        box-shadow:
            0 0 0 5px
            rgba(45, 212, 191, 0.14);
    }


    .report-hero h1 {
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
            -0.55px;
    }


    .report-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.83);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO SUMMARY
       ================================================================ */

    .report-hero-summary {
        width: 320px;

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


    .report-hero-summary-label {
        display: block;

        margin-bottom: 5px;

        color:
            rgba(255, 255, 255, 0.68);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.4px;
    }


    .report-hero-summary-value {
        display: block;

        color:
            #FFFFFF;

        font-size: 36px;
        font-weight: 900;

        line-height: 1.1;
    }


    .report-hero-summary-description {
        display: block;

        margin-top: 7px;

        color:
            rgba(255, 255, 255, 0.80);

        font-size: 15px;

        line-height: 1.55;
    }


    .report-hero-summary-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        margin-top: 15px;

        padding-top: 14px;

        border-top:
            1px solid
            rgba(255, 255, 255, 0.12);

        color:
            rgba(255, 255, 255, 0.78);

        font-size: 13px;
        font-weight: 750;
    }


    /* ================================================================
       INFO NOTICE
       ================================================================ */

    .report-notice {
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
            var(--report-shadow);
    }


    .report-notice-icon {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--report-teal-soft);

        color:
            var(--report-teal);

        font-size: 15px;
        font-weight: 900;
    }


    .report-notice strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--report-text);

        font-size: 17px;
        font-weight: 850;
    }


    .report-notice span {
        color:
            var(--report-body);

        font-size: 15px;

        line-height: 1.65;
    }


    /* ================================================================
       SUMMARY CARDS
       ================================================================ */

    .report-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 19px;

        margin-bottom: 28px;
    }


    .report-summary-card {
        padding: 24px;

        border:
            1px solid
            var(--report-border);

        border-radius: 20px;

        background:
            var(--report-white);

        box-shadow:
            var(--report-shadow);

        transition:
            var(--report-transition);
    }


    .report-summary-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            0 18px 38px
            rgba(15, 42, 74, 0.10);
    }


    .report-summary-icon {
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
            var(--report-teal-soft);

        color:
            var(--report-teal);
    }


    .summary-green {
        background:
            var(--report-green-soft);

        color:
            var(--report-green);
    }


    .summary-orange {
        background:
            var(--report-orange-soft);

        color:
            var(--report-orange);
    }


    .summary-purple {
        background:
            var(--report-purple-soft);

        color:
            var(--report-purple);
    }


    .report-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--report-body);

        font-size: 15px;
        font-weight: 750;
    }


    .report-summary-value {
        display: block;

        color:
            var(--report-text);

        font-size: 32px;
        font-weight: 900;

        line-height: 1.15;
    }


    .report-summary-unit {
        color:
            var(--report-muted);

        font-size: 16px;
        font-weight: 750;
    }


    .report-summary-note {
        display: block;

        margin-top: 9px;

        color:
            var(--report-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       SECONDARY SUMMARY
       ================================================================ */

    .report-secondary-grid {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 17px;

        margin-bottom: 28px;
    }


    .report-secondary-card {
        display: flex;
        align-items: center;

        gap: 15px;

        padding:
            19px
            20px;

        border:
            1px solid
            var(--report-border);

        border-radius: 16px;

        background:
            #FFFFFF;

        box-shadow:
            var(--report-shadow);
    }


    .report-secondary-icon {
        width: 48px;
        height: 48px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        font-size: 13px;
        font-weight: 900;
    }


    .report-secondary-label {
        display: block;

        margin-bottom: 3px;

        color:
            var(--report-muted);

        font-size: 14px;
        font-weight: 750;
    }


    .report-secondary-value {
        color:
            var(--report-text);

        font-size: 21px;
        font-weight: 900;
    }


    /* ================================================================
       FILTER PANEL
       ================================================================ */

    .report-filter-panel {
        margin-bottom: 27px;

        padding:
            21px
            22px;

        border:
            1px solid
            var(--report-border);

        border-radius: 18px;

        background:
            var(--report-white);

        box-shadow:
            var(--report-shadow);
    }


    .report-filter-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 16px;
    }


    .report-filter-title {
        display: block;

        margin-bottom: 3px;

        color:
            var(--report-text);

        font-size: 18px;
        font-weight: 850;
    }


    .report-filter-description {
        color:
            var(--report-muted);

        font-size: 14px;
    }


    .report-visible-count {
        padding:
            8px
            12px;

        border-radius: 999px;

        background:
            var(--report-gray-soft);

        color:
            var(--report-body);

        font-size: 14px;
        font-weight: 850;

        white-space: nowrap;
    }


    .report-filter-grid {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            220px;

        gap: 13px;
    }


    .report-search,
    .report-filter-select {
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
            var(--report-text);

        font-family:
            inherit;

        font-size: 16px;
        font-weight: 650;
    }


    .report-search {
        padding:
            0
            15px;
    }


    .report-filter-select {
        padding:
            0
            14px;

        cursor: pointer;
    }


    .report-search:focus,
    .report-filter-select:focus {
        border-color:
            var(--report-teal);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(15, 118, 110, 0.09);
    }


    /* ================================================================
       PANEL
       ================================================================ */

    .report-panel {
        overflow: hidden;

        border:
            1px solid
            var(--report-border);

        border-radius: 20px;

        background:
            var(--report-white);

        box-shadow:
            var(--report-shadow);
    }


    .report-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            24px
            26px;

        border-bottom:
            1px solid
            var(--report-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .report-panel-heading {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    .report-panel-icon {
        width: 50px;
        height: 50px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background:
            var(--report-teal-soft);

        color:
            var(--report-teal);

        font-size: 13px;
        font-weight: 900;
    }


    .report-panel-heading h2 {
        margin:
            0
            0
            4px;

        color:
            var(--report-text);

        font-size: 23px;
        font-weight: 850;

        line-height: 1.3;
    }


    .report-panel-heading p {
        margin: 0;

        color:
            var(--report-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .report-panel-body {
        padding: 26px;
    }


    /* ================================================================
       STUDENT REPORT CARDS
       ================================================================ */

    .student-report-list {
        display: grid;

        gap: 22px;
    }


    .student-report-card {
        overflow: hidden;

        border:
            1px solid
            var(--report-border);

        border-radius: 19px;

        background:
            #FFFFFF;

        transition:
            var(--report-transition);
    }


    .student-report-card:hover {
        border-color:
            #BDD0E1;

        box-shadow:
            0 16px 34px
            rgba(15, 42, 74, 0.08);
    }


    /* ================================================================
       STUDENT HEADER
       ================================================================ */

    .student-report-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding:
            22px
            23px;

        border-bottom:
            1px solid
            var(--report-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FAFCFF 100%
            );
    }


    .student-report-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 15px;
    }


    .student-report-avatar {
        width: 58px;
        height: 58px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background:
            var(--report-teal-soft);

        color:
            var(--report-teal);

        font-size: 16px;
        font-weight: 900;
    }


    .student-report-name {
        display: block;

        margin-bottom: 3px;

        color:
            var(--report-text);

        font-size: 19px;
        font-weight: 900;

        line-height: 1.4;
    }


    .student-report-meta {
        display: block;

        color:
            var(--report-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       STATUS
       ================================================================ */

    .report-status {
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


    .report-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
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


    .status-completed {
        background:
            var(--report-blue-soft);

        color:
            var(--report-blue);
    }


    .status-completed::before {
        background:
            #3B82F6;
    }


    .status-cancelled {
        background:
            var(--report-red-soft);

        color:
            var(--report-red);
    }


    .status-cancelled::before {
        background:
            #EF4444;
    }


    .status-default {
        background:
            var(--report-gray-soft);

        color:
            var(--report-gray);
    }


    .status-default::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       BODY
       ================================================================ */

    .student-report-body {
        padding: 22px;
    }


    /* ================================================================
       PLACEMENT DETAILS
       ================================================================ */

    .student-report-details {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 13px;

        margin-bottom: 18px;
    }


    .student-report-detail {
        min-height: 97px;

        padding: 15px;

        border:
            1px solid
            var(--report-border-soft);

        border-radius: 12px;

        background:
            var(--report-soft);
    }


    .student-report-detail-label {
        display: block;

        margin-bottom: 6px;

        color:
            var(--report-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.25px;
    }


    .student-report-detail-value {
        display: block;

        color:
            var(--report-text);

        font-size: 17px;
        font-weight: 900;

        line-height: 1.5;

        word-break: break-word;
    }


    .student-report-detail-secondary {
        display: block;

        margin-top: 3px;

        color:
            var(--report-muted);

        font-size: 13px;

        line-height: 1.45;
    }


    /* ================================================================
       HOURS PROGRESS
       ================================================================ */

    .student-hours-panel {
        padding: 20px;

        border:
            1px solid
            #CDE2DD;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                #F8FCFB 0%,
                #F0FAF7 100%
            );
    }


    .student-hours-top {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 13px;
    }


    .student-hours-title {
        display: block;

        margin-bottom: 4px;

        color:
            var(--report-text);

        font-size: 17px;
        font-weight: 900;
    }


    .student-hours-description {
        color:
            var(--report-body);

        font-size: 14px;

        line-height: 1.55;
    }


    .student-hours-value {
        color:
            var(--report-teal);

        font-size: 25px;
        font-weight: 900;

        white-space: nowrap;
    }


    .student-progress-track {
        width: 100%;
        height: 11px;

        overflow: hidden;

        border-radius: 999px;

        background:
            #D9E9E5;
    }


    .student-progress-fill {
        height: 100%;

        border-radius: inherit;

        background:
            linear-gradient(
                90deg,
                #2563EB,
                #0F766E
            );
    }


    .student-progress-stats {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 11px;

        margin-top: 16px;
    }


    .student-progress-stat {
        padding: 13px;

        border:
            1px solid
            rgba(15, 118, 110, 0.10);

        border-radius: 10px;

        background:
            rgba(255, 255, 255, 0.80);
    }


    .student-progress-stat-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--report-muted);

        font-size: 13px;
        font-weight: 800;
    }


    .student-progress-stat-value {
        display: block;

        color:
            var(--report-text);

        font-size: 18px;
        font-weight: 900;
    }


    /* ================================================================
       REPORT BREAKDOWN
       ================================================================ */

    .student-report-breakdown {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 14px;

        margin-top: 17px;
    }


    .report-breakdown-card {
        padding: 17px;

        border:
            1px solid
            var(--report-border);

        border-radius: 14px;

        background:
            #FBFDFF;
    }


    .report-breakdown-header {
        display: flex;
        align-items: center;

        gap: 10px;

        margin-bottom: 13px;
    }


    .report-breakdown-icon {
        width: 40px;
        height: 40px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 11px;

        font-size: 12px;
        font-weight: 900;
    }


    .breakdown-blue {
        background:
            var(--report-blue-soft);

        color:
            var(--report-blue);
    }


    .breakdown-purple {
        background:
            var(--report-purple-soft);

        color:
            var(--report-purple);
    }


    .breakdown-orange {
        background:
            var(--report-orange-soft);

        color:
            var(--report-orange);
    }


    .report-breakdown-title {
        color:
            var(--report-text);

        font-size: 16px;
        font-weight: 900;
    }


    .report-breakdown-list {
        display: grid;

        gap: 9px;
    }


    .report-breakdown-row {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        padding:
            10px
            11px;

        border:
            1px solid
            var(--report-border-soft);

        border-radius: 9px;

        background:
            #FFFFFF;
    }


    .report-breakdown-label {
        color:
            var(--report-body);

        font-size: 14px;
        font-weight: 700;
    }


    .report-breakdown-value {
        color:
            var(--report-text);

        font-size: 16px;
        font-weight: 900;
    }


    /* ================================================================
       EVALUATION
       ================================================================ */

    .student-evaluation-summary {
        margin-top: 17px;

        padding: 19px;

        border:
            1px solid
            #DDD5F1;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                #FCFBFF 0%,
                #F5F1FF 100%
            );
    }


    .student-evaluation-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;
    }


    .student-evaluation-title {
        display: block;

        margin-bottom: 4px;

        color:
            var(--report-text);

        font-size: 17px;
        font-weight: 900;
    }


    .student-evaluation-description {
        color:
            var(--report-body);

        font-size: 15px;

        line-height: 1.6;
    }


    .evaluation-result {
        display: inline-flex;
        align-items: center;

        padding:
            9px
            13px;

        border-radius: 999px;

        font-size: 14px;
        font-weight: 900;

        white-space: nowrap;
    }


    .evaluation-recommended {
        background:
            var(--report-green-soft);

        color:
            var(--report-green);
    }


    .evaluation-improvement {
        background:
            var(--report-orange-soft);

        color:
            var(--report-orange);
    }


    .evaluation-pending {
        background:
            var(--report-gray-soft);

        color:
            var(--report-gray);
    }


    .evaluation-score {
        display: grid;

        grid-template-columns:
            145px
            minmax(0, 1fr);

        gap: 14px;

        margin-top: 15px;
    }


    .evaluation-score-card {
        display: flex;
        flex-direction: column;
        justify-content: center;

        padding: 16px;

        border:
            1px solid
            rgba(109, 79, 194, 0.11);

        border-radius: 12px;

        background:
            rgba(255, 255, 255, 0.80);

        text-align: center;
    }


    .evaluation-score-label {
        color:
            var(--report-muted);

        font-size: 13px;
        font-weight: 800;

        text-transform: uppercase;
    }


    .evaluation-score-value {
        margin-top: 4px;

        color:
            var(--report-purple);

        font-size: 30px;
        font-weight: 900;

        line-height: 1.1;
    }


    .evaluation-score-max {
        color:
            var(--report-muted);

        font-size: 13px;
    }


    .evaluation-info-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 10px;
    }


    .evaluation-info-item {
        padding:
            13px;

        border:
            1px solid
            rgba(109, 79, 194, 0.10);

        border-radius: 10px;

        background:
            rgba(255, 255, 255, 0.80);
    }


    .evaluation-info-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--report-muted);

        font-size: 13px;
        font-weight: 800;
    }


    .evaluation-info-value {
        color:
            var(--report-text);

        font-size: 15px;
        font-weight: 850;

        line-height: 1.5;
    }


    /* ================================================================
       COMPLETION
       ================================================================ */

    .student-completion {
        margin-top: 17px;

        padding: 18px;

        border-radius: 14px;
    }


    .completion-done {
        border:
            1px solid
            #CADDF3;

        background:
            linear-gradient(
                135deg,
                #F8FBFF 0%,
                #EFF6FF 100%
            );
    }


    .completion-progress {
        border:
            1px solid
            #EED7B4;

        background:
            linear-gradient(
                135deg,
                #FFFCF7 0%,
                #FFF6E8 100%
            );
    }


    .student-completion-title {
        display: block;

        margin-bottom: 5px;

        color:
            var(--report-text);

        font-size: 16px;
        font-weight: 900;
    }


    .student-completion-description {
        color:
            var(--report-body);

        font-size: 15px;

        line-height: 1.65;
    }


    /* ================================================================
       ACTIONS
       ================================================================ */

    .student-report-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 10px;

        margin-top: 19px;

        padding-top: 18px;

        border-top:
            1px solid
            var(--report-border-soft);
    }


    .student-report-action {
        min-height: 48px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            16px;

        border:
            1px solid
            var(--report-border);

        border-radius: 11px;

        background:
            #FFFFFF;

        color:
            var(--report-navy);

        text-decoration: none;

        font-size: 15px;
        font-weight: 850;

        transition:
            var(--report-transition);
    }


    .student-report-action:hover {
        transform:
            translateY(-1px);

        border-color:
            #B8CADC;

        background:
            var(--report-blue-soft);
    }


    .student-report-action-primary {
        border-color:
            var(--report-navy);

        background:
            var(--report-navy);

        color:
            #FFFFFF;
    }


    .student-report-action-primary:hover {
        background:
            var(--report-navy-dark);

        color:
            #FFFFFF;
    }


    /* ================================================================
       EMPTY
       ================================================================ */

    .report-empty {
        padding:
            55px
            24px;

        text-align: center;
    }


    .report-empty-icon {
        width: 76px;
        height: 76px;

        margin:
            0
            auto
            17px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 21px;

        background:
            var(--report-teal-soft);

        color:
            var(--report-teal);

        font-size: 17px;
        font-weight: 900;
    }


    .report-empty h3 {
        margin:
            0
            0
            8px;

        color:
            var(--report-text);

        font-size: 22px;
        font-weight: 900;
    }


    .report-empty p {
        max-width: 590px;

        margin:
            0
            auto;

        color:
            var(--report-body);

        font-size: 16px;

        line-height: 1.7;
    }


    .report-filter-empty {
        display: none;

        padding:
            45px
            20px;

        text-align: center;

        color:
            var(--report-body);

        font-size: 16px;
    }


    .report-filter-empty.is-visible {
        display: block;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1180px) {

        .report-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .report-secondary-grid {
            grid-template-columns:
                1fr;
        }


        .student-report-details,
        .student-progress-stats {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .student-report-breakdown {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 850px) {

        .report-hero {
            padding:
                34px
                28px;
        }


        .report-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .report-hero-summary {
            width: 100%;
        }


        .report-filter-grid {
            grid-template-columns:
                1fr;
        }


        .student-report-header,
        .student-hours-top,
        .student-evaluation-top {
            flex-direction: column;

            align-items: flex-start;
        }


        .evaluation-score {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 650px) {

        .report-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .report-hero h1 {
            font-size: 31px;
        }


        .report-hero-description {
            font-size: 16px;
        }


        .report-summary-grid,
        .student-report-details,
        .student-progress-stats,
        .evaluation-info-grid {
            grid-template-columns:
                1fr;
        }


        .report-panel-header,
        .report-panel-body {
            padding-left: 20px;
            padding-right: 20px;
        }


        .report-panel-heading h2 {
            font-size: 21px;
        }


        .report-filter-top {
            flex-direction: column;

            align-items: flex-start;
        }


        .student-report-identity {
            align-items: flex-start;
        }


        .student-report-avatar {
            width: 50px;
            height: 50px;
        }


        .student-report-actions {
            display: grid;

            grid-template-columns:
                1fr;
        }


        .student-report-action {
            width: 100%;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Authenticated Supervisor
    |--------------------------------------------------------------------------
    */

    $supervisor =
        auth()->user();


    /*
    |--------------------------------------------------------------------------
    | Supervised Assignments
    |--------------------------------------------------------------------------
    */

    $supervisedAssignments =
        $supervisor
            ? $supervisor
                ->supervisedAssignments()
                ->with([
                    'studentProfile.user',
                    'company',
                    'attendanceRecords',
                    'dailyWorkLogs',
                    'finalEvaluation',
                    'completedBy',
                ])
                ->latest('start_date')
                ->get()
            : collect();


    /*
    |--------------------------------------------------------------------------
    | Assignment Groups
    |--------------------------------------------------------------------------
    */

    $activeAssignments =
        $supervisedAssignments
            ->filter(
                fn ($assignment) =>
                    strtolower(
                        (string) $assignment->status
                    ) === 'active'
            )
            ->values();


    $pendingAssignments =
        $supervisedAssignments
            ->filter(
                fn ($assignment) =>
                    strtolower(
                        (string) $assignment->status
                    ) === 'pending'
            )
            ->values();


    $completedAssignments =
        $supervisedAssignments
            ->filter(
                fn ($assignment) =>
                    strtolower(
                        (string) $assignment->status
                    ) === 'completed'
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Students
    |--------------------------------------------------------------------------
    */

    $studentCount =
        $supervisedAssignments
            ->pluck(
                'student_profile_id'
            )
            ->filter()
            ->unique()
            ->count();


    /*
    |--------------------------------------------------------------------------
    | All Attendance
    |--------------------------------------------------------------------------
    */

    $allAttendance =
        $supervisedAssignments
            ->flatMap(
                fn ($assignment) =>
                    collect(
                        $assignment->attendanceRecords
                        ?? []
                    )
            )
            ->values();


    $validatedAttendance =
        $allAttendance
            ->filter(
                fn ($record) =>
                    strtolower(
                        (string) $record->status
                    ) === 'validated'
            )
            ->values();


    $pendingAttendance =
        $allAttendance
            ->filter(
                fn ($record) =>
                    strtolower(
                        (string) $record->status
                    ) === 'pending'
            )
            ->values();


    $rejectedAttendance =
        $allAttendance
            ->filter(
                fn ($record) =>
                    strtolower(
                        (string) $record->status
                    ) === 'rejected'
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Total Validated Hours
    |--------------------------------------------------------------------------
    */

    $totalValidatedMinutes =
        (int) $validatedAttendance
            ->sum(
                fn ($record) =>
                    (int) (
                        $record->rendered_minutes
                        ?? 0
                    )
            );


    $totalValidatedHours =
        $totalValidatedMinutes / 60;


    /*
    |--------------------------------------------------------------------------
    | All Work Logs
    |--------------------------------------------------------------------------
    */

    $allWorkLogs =
        $supervisedAssignments
            ->flatMap(
                fn ($assignment) =>
                    collect(
                        $assignment->dailyWorkLogs
                        ?? []
                    )
            )
            ->values();


    $validatedWorkLogs =
        $allWorkLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string) $log->status
                    ) === 'validated'
            )
            ->values();


    $pendingWorkLogs =
        $allWorkLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string) $log->status
                    ) === 'pending'
            )
            ->values();


    $rejectedWorkLogs =
        $allWorkLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string) $log->status
                    ) === 'rejected'
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Evaluations
    |--------------------------------------------------------------------------
    */

    $evaluatedAssignments =
        $supervisedAssignments
            ->filter(
                fn ($assignment) =>
                    $assignment->finalEvaluation
                    !== null
            )
            ->values();


    $recommendedAssignments =
        $evaluatedAssignments
            ->filter(
                fn ($assignment) =>
                    strtolower(
                        (string)
                        $assignment
                            ->finalEvaluation
                            ?->recommendation
                    ) === 'recommended'
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Pending Review Total
    |--------------------------------------------------------------------------
    */

    $pendingReviewCount =
        $pendingAttendance->count()
        +
        $pendingWorkLogs->count();


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
    | Date + Time Formatter
    |--------------------------------------------------------------------------
    */

    $formatDateTime =
        function ($value) {

            if (! $value) {
                return 'Not available';
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
                            'M d, Y · h:i A'
                        );

            } catch (\Throwable $exception) {

                return (string) $value;

            }

        };


    /*
    |--------------------------------------------------------------------------
    | Initials
    |--------------------------------------------------------------------------
    */

    $makeInitials =
        function ($value) {

            $parts =
                preg_split(
                    '/\s+/',
                    trim(
                        (string) $value
                    )
                );


            $initials =
                collect($parts)
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


            return
                $initials
                ?: 'ST';

        };


    /*
    |--------------------------------------------------------------------------
    | Status Helpers
    |--------------------------------------------------------------------------
    */

    $statusClass =
        function ($status) {

            return match (
                strtolower(
                    (string) $status
                )
            ) {

                'active' =>
                    'status-active',

                'pending' =>
                    'status-pending',

                'completed' =>
                    'status-completed',

                'cancelled' =>
                    'status-cancelled',

                default =>
                    'status-default',

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
    | Evaluation Criteria
    |--------------------------------------------------------------------------
    |
    | Detect numeric 1-to-5 evaluation fields rather than assuming
    | the exact names of all six criteria.
    |
    */

    $extractEvaluationCriteria =
        function ($evaluation) {

            if (! $evaluation) {
                return collect();
            }


            $excluded = [

                'id',
                'ojt_assignment_id',
                'assignment_id',

                'evaluator_id',
                'evaluated_by',
                'supervisor_id',
                'user_id',

                'average',
                'average_score',
                'average_rating',
                'overall_score',
                'overall_rating',
                'total_score',

                'recommendation',

                'evaluated_at',
                'created_at',
                'updated_at',

            ];


            return collect(
                $evaluation->getAttributes()
            )
                ->filter(
                    function (
                        $value,
                        $key
                    ) use (
                        $excluded
                    ) {

                        if (
                            in_array(
                                $key,
                                $excluded,
                                true
                            )
                        ) {

                            return false;

                        }


                        if (
                            str_ends_with(
                                $key,
                                '_id'
                            )
                        ) {

                            return false;

                        }


                        if (
                            ! is_numeric(
                                $value
                            )
                        ) {

                            return false;

                        }


                        $numeric =
                            (float) $value;


                        return
                            $numeric >= 1
                            &&
                            $numeric <= 5;

                    }
                );

        };


    /*
    |--------------------------------------------------------------------------
    | Evaluation Result
    |--------------------------------------------------------------------------
    */

    $evaluationClass =
        function ($recommendation) {

            return match (
                strtolower(
                    (string) $recommendation
                )
            ) {

                'recommended' =>
                    'evaluation-recommended',

                'needs_improvement',
                'needs improvement' =>
                    'evaluation-improvement',

                default =>
                    'evaluation-pending',

            };

        };


    /*
    |--------------------------------------------------------------------------
    | Named Route Helper
    |--------------------------------------------------------------------------
    */

    $routeExists =
        fn ($name) =>
            \Illuminate\Support\Facades\Route::has(
                $name
            );


    /*
    |--------------------------------------------------------------------------
    | Optional Report Route Builder
    |--------------------------------------------------------------------------
    |
    | Used only for optional Print/Export routes if your application
    | already has them.
    |
    */

    $buildOptionalReportRoute =
        function (
            array $candidateNames,
            $assignment
        ) {

            foreach (
                $candidateNames
                as $routeName
            ) {

                if (
                    ! \Illuminate\Support\Facades\Route::has(
                        $routeName
                    )
                ) {

                    continue;

                }


                try {

                    $routeObject =
                        \Illuminate\Support\Facades\Route
                            ::getRoutes()
                            ->getByName(
                                $routeName
                            );


                    $parameterNames =
                        $routeObject
                            ?->parameterNames()
                        ?? [];


                    $parameters = [];


                    foreach (
                        $parameterNames
                        as $parameterName
                    ) {

                        $parameters[
                            $parameterName
                        ] =
                            $assignment
                                ->getRouteKey();

                    }


                    if (
                        empty(
                            $parameterNames
                        )
                    ) {

                        $parameters = [
                            'assignment' =>
                                $assignment->id,
                        ];

                    }


                    return route(
                        $routeName,
                        $parameters
                    );

                } catch (\Throwable $exception) {

                    continue;

                }

            }


            return null;

        };


    $printRouteCandidates = [

        'supervisor.reports.print',

        'supervisor.reports.printable',

        'supervisor.report.print',

    ];


    $exportRouteCandidates = [

        'supervisor.reports.export',

        'supervisor.reports.csv',

        'supervisor.reports.export.csv',

        'supervisor.report.export',

    ];

@endphp


<div class="supervisor-report-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="report-hero">


        <div class="report-hero-inner">


            <div class="report-hero-copy">


                <div class="report-hero-eyebrow">


                    <span class="report-hero-dot"></span>


                    Supervisor Portal · OJT Monitoring & Reports


                </div>


                <h1>
                    Student OJT Reports
                </h1>


                <p class="report-hero-description">

                    Review the complete progress of Students
                    assigned to you, including validated
                    rendered hours, attendance records,
                    Daily Work Logs, final evaluations,
                    training progress, and completion status.

                </p>


            </div>


            <div class="report-hero-summary">


                <span class="report-hero-summary-label">
                    Students Monitored
                </span>


                <span class="report-hero-summary-value">

                    {{ $studentCount }}

                </span>


                <span class="report-hero-summary-description">

                    Student{{ $studentCount === 1 ? '' : 's' }}
                    currently represented in your
                    OJT supervision records.

                </span>


                <div class="report-hero-summary-footer">


                    <span>

                        {{ $activeAssignments->count() }}
                        active

                    </span>


                    <span>

                        {{ $completedAssignments->count() }}
                        completed

                    </span>


                </div>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         NOTICE
         ================================================================== --}}

    <section class="report-notice">


        <div class="report-notice-icon">
            RP
        </div>


        <div>


            <strong>
                This report reflects the Student records under your supervision.
            </strong>


            <span>

                Official rendered-hour progress is based on
                validated attendance. Pending attendance and
                Daily Work Logs remain separate until they
                complete the Supervisor review process.

            </span>


        </div>


    </section>


    {{-- ==================================================================
         MAIN SUMMARY
         ================================================================== --}}

    <section class="report-summary-grid">


        <article class="report-summary-card">


            <div class="report-summary-icon summary-teal">
                ST
            </div>


            <span class="report-summary-label">
                Assigned Students
            </span>


            <span class="report-summary-value">

                {{ $studentCount }}

            </span>


            <span class="report-summary-note">

                Unique Students represented
                in your OJT Assignments.

            </span>


        </article>


        <article class="report-summary-card">


            <div class="report-summary-icon summary-green">
                HR
            </div>


            <span class="report-summary-label">
                Validated OJT Hours
            </span>


            <span class="report-summary-value">

                {{ number_format(
                    $totalValidatedHours,
                    1
                ) }}

                <span class="report-summary-unit">
                    hrs
                </span>

            </span>


            <span class="report-summary-note">

                Combined official rendered
                hours under your supervision.

            </span>


        </article>


        <article class="report-summary-card">


            <div class="report-summary-icon summary-orange">
                RV
            </div>


            <span class="report-summary-label">
                Pending Reviews
            </span>


            <span class="report-summary-value">

                {{ $pendingReviewCount }}

            </span>


            <span class="report-summary-note">

                Attendance and Daily Work Logs
                still awaiting validation.

            </span>


        </article>


        <article class="report-summary-card">


            <div class="report-summary-icon summary-purple">
                EV
            </div>


            <span class="report-summary-label">
                Evaluations Submitted
            </span>


            <span class="report-summary-value">

                {{ $evaluatedAssignments->count() }}

            </span>


            <span class="report-summary-note">

                Final Supervisor evaluations
                already recorded.

            </span>


        </article>


    </section>


    {{-- ==================================================================
         SECONDARY SUMMARY
         ================================================================== --}}

    <section class="report-secondary-grid">


        <article class="report-secondary-card">


            <div class="report-secondary-icon summary-green">
                ✓
            </div>


            <div>


                <span class="report-secondary-label">
                    Validated Attendance Records
                </span>


                <span class="report-secondary-value">

                    {{ $validatedAttendance->count() }}

                </span>


            </div>


        </article>


        <article class="report-secondary-card">


            <div class="report-secondary-icon summary-purple">
                WL
            </div>


            <div>


                <span class="report-secondary-label">
                    Validated Daily Work Logs
                </span>


                <span class="report-secondary-value">

                    {{ $validatedWorkLogs->count() }}

                </span>


            </div>


        </article>


        <article class="report-secondary-card">


            <div class="report-secondary-icon summary-teal">
                RC
            </div>


            <div>


                <span class="report-secondary-label">
                    Recommended Evaluations
                </span>


                <span class="report-secondary-value">

                    {{ $recommendedAssignments->count() }}

                </span>


            </div>


        </article>


    </section>


    {{-- ==================================================================
         FILTER
         ================================================================== --}}

    @if ($supervisedAssignments->isNotEmpty())


        <section class="report-filter-panel">


            <div class="report-filter-top">


                <div>


                    <span class="report-filter-title">
                        Find a Student Report
                    </span>


                    <span class="report-filter-description">

                        Search by Student,
                        Student number, company,
                        assignment status, or evaluation result.

                    </span>


                </div>


                <span
                    class="report-visible-count"
                    id="report-visible-count"
                >

                    {{ $supervisedAssignments->count() }}
                    reports

                </span>


            </div>


            <div class="report-filter-grid">


                <input
                    type="search"
                    id="report-search"
                    class="report-search"
                    placeholder="Search Student, company, status, recommendation..."
                    autocomplete="off"
                >


                <select
                    id="report-status-filter"
                    class="report-filter-select"
                >

                    <option value="">
                        All Placements
                    </option>


                    <option value="active">
                        Active
                    </option>


                    <option value="pending">
                        Pending
                    </option>


                    <option value="completed">
                        Completed
                    </option>


                    <option value="cancelled">
                        Cancelled
                    </option>


                    <option value="needs_evaluation">
                        Needs Evaluation
                    </option>


                </select>


            </div>


        </section>


    @endif


    {{-- ==================================================================
         STUDENT REPORTS
         ================================================================== --}}

    <section class="report-panel">


        <div class="report-panel-header">


            <div class="report-panel-heading">


                <div class="report-panel-icon">
                    RP
                </div>


                <div>


                    <h2>
                        Student Progress Reports
                    </h2>


                    <p>
                        Attendance, Work Logs, rendered hours, evaluations, and completion
                    </p>


                </div>


            </div>


        </div>


        <div class="report-panel-body">


            @if ($supervisedAssignments->isNotEmpty())


                <div
                    class="student-report-list"
                    id="student-report-list"
                >


                    @foreach ($supervisedAssignments as $assignment)


                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | Student
                            |--------------------------------------------------------------------------
                            */

                            $studentProfile =
                                $assignment
                                    ->studentProfile;


                            $studentUser =
                                $studentProfile
                                    ?->user;


                            $studentName =
                                $studentUser?->name
                                ?? 'Student unavailable';


                            $studentNumber =
                                $studentProfile?->student_number
                                ?? 'Student number unavailable';


                            $companyName =
                                $assignment
                                    ->company
                                    ?->name
                                ?? 'Company unavailable';


                            /*
                            |--------------------------------------------------------------------------
                            | Assignment
                            |--------------------------------------------------------------------------
                            */

                            $assignmentStatus =
                                strtolower(
                                    (string)
                                    $assignment->status
                                );


                            $requiredHours =
                                (float) (
                                    $assignment
                                        ->required_hours
                                    ?? 0
                                );


                            $requiredMinutes =
                                (int) round(
                                    $requiredHours * 60
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Attendance
                            |--------------------------------------------------------------------------
                            */

                            $attendanceRecords =
                                collect(
                                    $assignment
                                        ->attendanceRecords
                                    ?? []
                                );


                            $assignmentValidatedAttendance =
                                $attendanceRecords
                                    ->filter(
                                        fn ($record) =>
                                            strtolower(
                                                (string)
                                                $record->status
                                            ) === 'validated'
                                    );


                            $assignmentPendingAttendance =
                                $attendanceRecords
                                    ->filter(
                                        fn ($record) =>
                                            strtolower(
                                                (string)
                                                $record->status
                                            ) === 'pending'
                                    );


                            $assignmentRejectedAttendance =
                                $attendanceRecords
                                    ->filter(
                                        fn ($record) =>
                                            strtolower(
                                                (string)
                                                $record->status
                                            ) === 'rejected'
                                    );


                            /*
                            |--------------------------------------------------------------------------
                            | Hours
                            |--------------------------------------------------------------------------
                            */

                            $assignmentValidatedMinutes =
                                (int)
                                $assignmentValidatedAttendance
                                    ->sum(
                                        fn ($record) =>
                                            (int) (
                                                $record
                                                    ->rendered_minutes
                                                ?? 0
                                            )
                                    );


                            $assignmentValidatedHours =
                                $assignmentValidatedMinutes
                                / 60;


                            $remainingMinutes =
                                max(
                                    0,
                                    $requiredMinutes
                                    -
                                    $assignmentValidatedMinutes
                                );


                            $remainingHours =
                                $remainingMinutes
                                / 60;


                            $progress =
                                $requiredMinutes > 0
                                    ? min(
                                        100,
                                        (int) round(
                                            (
                                                $assignmentValidatedMinutes
                                                /
                                                $requiredMinutes
                                            )
                                            * 100
                                        )
                                    )
                                    : 0;


                            /*
                            |--------------------------------------------------------------------------
                            | Work Logs
                            |--------------------------------------------------------------------------
                            */

                            $workLogs =
                                collect(
                                    $assignment
                                        ->dailyWorkLogs
                                    ?? []
                                );


                            $assignmentValidatedWorkLogs =
                                $workLogs
                                    ->filter(
                                        fn ($log) =>
                                            strtolower(
                                                (string)
                                                $log->status
                                            ) === 'validated'
                                    );


                            $assignmentPendingWorkLogs =
                                $workLogs
                                    ->filter(
                                        fn ($log) =>
                                            strtolower(
                                                (string)
                                                $log->status
                                            ) === 'pending'
                                    );


                            $assignmentRejectedWorkLogs =
                                $workLogs
                                    ->filter(
                                        fn ($log) =>
                                            strtolower(
                                                (string)
                                                $log->status
                                            ) === 'rejected'
                                    );


                            /*
                            |--------------------------------------------------------------------------
                            | Evaluation
                            |--------------------------------------------------------------------------
                            */

                            $evaluation =
                                $assignment
                                    ->finalEvaluation;


                            $criteria =
                                $extractEvaluationCriteria(
                                    $evaluation
                                );


                            $averageScore =
                                $criteria->isNotEmpty()
                                    ? round(
                                        (float)
                                        $criteria->average(),
                                        2
                                    )
                                    : null;


                            $recommendation =
                                $evaluation
                                    ?->recommendation;


                            $recommendationLabel =
                                $recommendation
                                    ? ucwords(
                                        str_replace(
                                            '_',
                                            ' ',
                                            (string)
                                            $recommendation
                                        )
                                    )
                                    : 'Not submitted';


                            /*
                            |--------------------------------------------------------------------------
                            | Optional Print/Export
                            |--------------------------------------------------------------------------
                            */

                            $printUrl =
                                $buildOptionalReportRoute(
                                    $printRouteCandidates,
                                    $assignment
                                );


                            $exportUrl =
                                $buildOptionalReportRoute(
                                    $exportRouteCandidates,
                                    $assignment
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Search
                            |--------------------------------------------------------------------------
                            */

                            $needsEvaluation =
                                $evaluation === null;


                            $searchText =
                                strtolower(
                                    implode(
                                        ' ',
                                        [
                                            $studentName,
                                            $studentNumber,
                                            $companyName,
                                            $assignmentStatus,
                                            $recommendation,
                                            $needsEvaluation
                                                ? 'needs evaluation'
                                                : '',
                                        ]
                                    )
                                );

                        @endphp


                        <article
                            class="student-report-card"
                            data-report-card
                            data-search="{{ $searchText }}"
                            data-status="{{ $assignmentStatus }}"
                            data-needs-evaluation="{{ $needsEvaluation ? '1' : '0' }}"
                        >


                            {{-- ==================================================
                                 HEADER
                                 ================================================== --}}

                            <div class="student-report-header">


                                <div class="student-report-identity">


                                    <div class="student-report-avatar">

                                        {{ $makeInitials(
                                            $studentName
                                        ) }}

                                    </div>


                                    <div>


                                        <span class="student-report-name">

                                            {{ $studentName }}

                                        </span>


                                        <span class="student-report-meta">

                                            {{ $studentNumber }}

                                            @if (
                                                filled(
                                                    $studentProfile?->program
                                                )
                                            )

                                                ·
                                                {{ $studentProfile->program }}

                                            @endif


                                            @if (
                                                filled(
                                                    $studentProfile?->year_level
                                                )
                                            )

                                                ·
                                                {{ $studentProfile->year_level }}

                                            @endif


                                            @if (
                                                filled(
                                                    $studentProfile?->section
                                                )
                                            )

                                                ·
                                                Section
                                                {{ $studentProfile->section }}

                                            @endif

                                        </span>


                                    </div>


                                </div>


                                <span
                                    class="
                                        report-status
                                        {{ $statusClass(
                                            $assignmentStatus
                                        ) }}
                                    "
                                >

                                    {{ $statusLabel(
                                        $assignmentStatus
                                    ) }}

                                </span>


                            </div>


                            {{-- ==================================================
                                 BODY
                                 ================================================== --}}

                            <div class="student-report-body">


                                {{-- ==============================================
                                     PLACEMENT DETAILS
                                     ============================================== --}}

                                <div class="student-report-details">


                                    <div class="student-report-detail">


                                        <span class="student-report-detail-label">
                                            OJT Company
                                        </span>


                                        <span class="student-report-detail-value">

                                            {{ $companyName }}

                                        </span>


                                        <span class="student-report-detail-secondary">

                                            {{ $assignment
                                                ->company
                                                ?->address
                                                ?? 'Address not provided'
                                            }}

                                        </span>


                                    </div>


                                    <div class="student-report-detail">


                                        <span class="student-report-detail-label">
                                            Required Hours
                                        </span>


                                        <span class="student-report-detail-value">

                                            {{ number_format(
                                                $requiredHours,
                                                1
                                            ) }}

                                            hours

                                        </span>


                                    </div>


                                    <div class="student-report-detail">


                                        <span class="student-report-detail-label">
                                            Training Start
                                        </span>


                                        <span class="student-report-detail-value">

                                            {{ $formatDate(
                                                $assignment->start_date
                                            ) }}

                                        </span>


                                    </div>


                                    <div class="student-report-detail">


                                        <span class="student-report-detail-label">
                                            Training End
                                        </span>


                                        <span class="student-report-detail-value">

                                            {{ $formatDate(
                                                $assignment->end_date
                                            ) }}

                                        </span>


                                    </div>


                                </div>


                                {{-- ==============================================
                                     HOURS
                                     ============================================== --}}

                                <section class="student-hours-panel">


                                    <div class="student-hours-top">


                                        <div>


                                            <span class="student-hours-title">
                                                Validated OJT Hour Progress
                                            </span>


                                            <span class="student-hours-description">

                                                Official rendered time based
                                                only on Supervisor-validated
                                                attendance records.

                                            </span>


                                        </div>


                                        <span class="student-hours-value">

                                            {{ number_format(
                                                $assignmentValidatedHours,
                                                1
                                            ) }}

                                            /

                                            {{ number_format(
                                                $requiredHours,
                                                1
                                            ) }}

                                            hrs

                                        </span>


                                    </div>


                                    <div class="student-progress-track">


                                        <div
                                            class="student-progress-fill"
                                            style="
                                                width:
                                                {{ $progress }}%;
                                            "
                                        ></div>


                                    </div>


                                    <div class="student-progress-stats">


                                        <div class="student-progress-stat">


                                            <span class="student-progress-stat-label">
                                                Progress
                                            </span>


                                            <span class="student-progress-stat-value">

                                                {{ $progress }}%

                                            </span>


                                        </div>


                                        <div class="student-progress-stat">


                                            <span class="student-progress-stat-label">
                                                Validated Hours
                                            </span>


                                            <span class="student-progress-stat-value">

                                                {{ number_format(
                                                    $assignmentValidatedHours,
                                                    1
                                                ) }}

                                            </span>


                                        </div>


                                        <div class="student-progress-stat">


                                            <span class="student-progress-stat-label">
                                                Remaining Hours
                                            </span>


                                            <span class="student-progress-stat-value">

                                                {{ number_format(
                                                    $remainingHours,
                                                    1
                                                ) }}

                                            </span>


                                        </div>


                                        <div class="student-progress-stat">


                                            <span class="student-progress-stat-label">
                                                Pending Review
                                            </span>


                                            <span class="student-progress-stat-value">

                                                {{ $assignmentPendingAttendance->count()
                                                    +
                                                    $assignmentPendingWorkLogs->count()
                                                }}

                                            </span>


                                        </div>


                                    </div>


                                </section>


                                {{-- ==============================================
                                     BREAKDOWN
                                     ============================================== --}}

                                <div class="student-report-breakdown">


                                    {{-- ==========================================
                                         ATTENDANCE
                                         ========================================== --}}

                                    <section class="report-breakdown-card">


                                        <div class="report-breakdown-header">


                                            <div
                                                class="
                                                    report-breakdown-icon
                                                    breakdown-blue
                                                "
                                            >
                                                AT
                                            </div>


                                            <span class="report-breakdown-title">
                                                Attendance
                                            </span>


                                        </div>


                                        <div class="report-breakdown-list">


                                            <div class="report-breakdown-row">


                                                <span class="report-breakdown-label">
                                                    Total Records
                                                </span>


                                                <span class="report-breakdown-value">

                                                    {{ $attendanceRecords->count() }}

                                                </span>


                                            </div>


                                            <div class="report-breakdown-row">


                                                <span class="report-breakdown-label">
                                                    Validated
                                                </span>


                                                <span class="report-breakdown-value">

                                                    {{ $assignmentValidatedAttendance->count() }}

                                                </span>


                                            </div>


                                            <div class="report-breakdown-row">


                                                <span class="report-breakdown-label">
                                                    Pending
                                                </span>


                                                <span class="report-breakdown-value">

                                                    {{ $assignmentPendingAttendance->count() }}

                                                </span>


                                            </div>


                                            <div class="report-breakdown-row">


                                                <span class="report-breakdown-label">
                                                    Rejected
                                                </span>


                                                <span class="report-breakdown-value">

                                                    {{ $assignmentRejectedAttendance->count() }}

                                                </span>


                                            </div>


                                        </div>


                                    </section>


                                    {{-- ==========================================
                                         WORK LOGS
                                         ========================================== --}}

                                    <section class="report-breakdown-card">


                                        <div class="report-breakdown-header">


                                            <div
                                                class="
                                                    report-breakdown-icon
                                                    breakdown-purple
                                                "
                                            >
                                                WL
                                            </div>


                                            <span class="report-breakdown-title">
                                                Daily Work Logs
                                            </span>


                                        </div>


                                        <div class="report-breakdown-list">


                                            <div class="report-breakdown-row">


                                                <span class="report-breakdown-label">
                                                    Total Logs
                                                </span>


                                                <span class="report-breakdown-value">

                                                    {{ $workLogs->count() }}

                                                </span>


                                            </div>


                                            <div class="report-breakdown-row">


                                                <span class="report-breakdown-label">
                                                    Validated
                                                </span>


                                                <span class="report-breakdown-value">

                                                    {{ $assignmentValidatedWorkLogs->count() }}

                                                </span>


                                            </div>


                                            <div class="report-breakdown-row">


                                                <span class="report-breakdown-label">
                                                    Pending
                                                </span>


                                                <span class="report-breakdown-value">

                                                    {{ $assignmentPendingWorkLogs->count() }}

                                                </span>


                                            </div>


                                            <div class="report-breakdown-row">


                                                <span class="report-breakdown-label">
                                                    Rejected
                                                </span>


                                                <span class="report-breakdown-value">

                                                    {{ $assignmentRejectedWorkLogs->count() }}

                                                </span>


                                            </div>


                                        </div>


                                    </section>


                                    {{-- ==========================================
                                         PLACEMENT STATUS
                                         ========================================== --}}

                                    <section class="report-breakdown-card">


                                        <div class="report-breakdown-header">


                                            <div
                                                class="
                                                    report-breakdown-icon
                                                    breakdown-orange
                                                "
                                            >
                                                OJ
                                            </div>


                                            <span class="report-breakdown-title">
                                                OJT Record
                                            </span>


                                        </div>


                                        <div class="report-breakdown-list">


                                            <div class="report-breakdown-row">


                                                <span class="report-breakdown-label">
                                                    Assignment
                                                </span>


                                                <span class="report-breakdown-value">

                                                    {{ $statusLabel(
                                                        $assignmentStatus
                                                    ) }}

                                                </span>


                                            </div>


                                            <div class="report-breakdown-row">


                                                <span class="report-breakdown-label">
                                                    Evaluation
                                                </span>


                                                <span class="report-breakdown-value">

                                                    {{ $evaluation
                                                        ? 'Submitted'
                                                        : 'Pending'
                                                    }}

                                                </span>


                                            </div>


                                            <div class="report-breakdown-row">


                                                <span class="report-breakdown-label">
                                                    Recommendation
                                                </span>


                                                <span class="report-breakdown-value">

                                                    {{ $recommendationLabel }}

                                                </span>


                                            </div>


                                            <div class="report-breakdown-row">


                                                <span class="report-breakdown-label">
                                                    Completion
                                                </span>


                                                <span class="report-breakdown-value">

                                                    {{ $assignmentStatus === 'completed'
                                                        ? 'Completed'
                                                        : 'Not completed'
                                                    }}

                                                </span>


                                            </div>


                                        </div>


                                    </section>


                                </div>


                                {{-- ==============================================
                                     EVALUATION
                                     ============================================== --}}

                                <section class="student-evaluation-summary">


                                    <div class="student-evaluation-top">


                                        <div>


                                            <span class="student-evaluation-title">
                                                Supervisor Final Evaluation
                                            </span>


                                            <span class="student-evaluation-description">


                                                @if ($evaluation)

                                                    Final performance evaluation
                                                    has been submitted for this
                                                    Student's OJT placement.

                                                @else

                                                    No final Supervisor evaluation
                                                    has been submitted for this
                                                    placement yet.

                                                @endif


                                            </span>


                                        </div>


                                        <span
                                            class="
                                                evaluation-result
                                                {{ $evaluationClass(
                                                    $recommendation
                                                ) }}
                                            "
                                        >

                                            {{ $recommendationLabel }}

                                        </span>


                                    </div>


                                    @if ($evaluation)


                                        <div class="evaluation-score">


                                            <div class="evaluation-score-card">


                                                <span class="evaluation-score-label">
                                                    Average Rating
                                                </span>


                                                <span class="evaluation-score-value">

                                                    {{ $averageScore !== null
                                                        ? number_format(
                                                            $averageScore,
                                                            2
                                                        )
                                                        : '—'
                                                    }}

                                                </span>


                                                <span class="evaluation-score-max">

                                                    {{ $averageScore !== null
                                                        ? 'out of 5.00'
                                                        : 'Score unavailable'
                                                    }}

                                                </span>


                                            </div>


                                            <div class="evaluation-info-grid">


                                                <div class="evaluation-info-item">


                                                    <span class="evaluation-info-label">
                                                        Recommendation
                                                    </span>


                                                    <span class="evaluation-info-value">

                                                        {{ $recommendationLabel }}

                                                    </span>


                                                </div>


                                                <div class="evaluation-info-item">


                                                    <span class="evaluation-info-label">
                                                        Evaluation Date
                                                    </span>


                                                    <span class="evaluation-info-value">

                                                        {{ $formatDateTime(
                                                            $evaluation->evaluated_at
                                                            ?? $evaluation->created_at
                                                        ) }}

                                                    </span>


                                                </div>


                                            </div>


                                        </div>


                                    @endif


                                </section>


                                {{-- ==============================================
                                     COMPLETION
                                     ============================================== --}}

                                @if ($assignmentStatus === 'completed')


                                    <section
                                        class="
                                            student-completion
                                            completion-done
                                        "
                                    >


                                        <span class="student-completion-title">
                                            Formal OJT Completion
                                        </span>


                                        <div class="student-completion-description">

                                            This OJT Assignment was formally
                                            completed

                                            @if ($assignment->completed_at)

                                                on

                                                <strong>

                                                    {{ $formatDate(
                                                        $assignment->completed_at
                                                    ) }}.

                                                </strong>

                                            @else

                                                and is preserved as a
                                                completed Student record.

                                            @endif


                                            @if ($assignment->completedBy)

                                                Completion was recorded by

                                                <strong>

                                                    {{ $assignment
                                                        ->completedBy
                                                        ->name
                                                    }}.

                                                </strong>

                                            @endif

                                        </div>


                                    </section>


                                @else


                                    <section
                                        class="
                                            student-completion
                                            completion-progress
                                        "
                                    >


                                        <span class="student-completion-title">
                                            OJT Completion Status
                                        </span>


                                        <div class="student-completion-description">

                                            This placement has not yet been
                                            formally completed. Continue
                                            monitoring validated hours,
                                            Student records, and final
                                            evaluation requirements.

                                        </div>


                                    </section>


                                @endif


                                {{-- ==============================================
                                     ACTIONS
                                     ============================================== --}}

                                <div class="student-report-actions">


                                    @if ($printUrl)


                                        <a
                                            href="{{ $printUrl }}"
                                            class="
                                                student-report-action
                                                student-report-action-primary
                                            "
                                            target="_blank"
                                            rel="noopener"
                                        >
                                            Print Student Report
                                        </a>


                                    @endif


                                    @if ($exportUrl)


                                        <a
                                            href="{{ $exportUrl }}"
                                            class="student-report-action"
                                        >
                                            Export Report
                                        </a>


                                    @endif


                                    @if (
                                        $routeExists(
                                            'supervisor.validations.index'
                                        )
                                    )


                                        <a
                                            href="{{ route(
                                                'supervisor.validations.index',
                                                [
                                                    'assignment' =>
                                                        $assignment->id,
                                                ]
                                            ) }}"
                                            class="student-report-action"
                                        >
                                            Attendance Review
                                        </a>


                                    @endif


                                    @if (
                                        $routeExists(
                                            'supervisor.work-logs.index'
                                        )
                                    )


                                        <a
                                            href="{{ route(
                                                'supervisor.work-logs.index',
                                                [
                                                    'assignment' =>
                                                        $assignment->id,
                                                ]
                                            ) }}"
                                            class="student-report-action"
                                        >
                                            Work Log Review
                                        </a>


                                    @endif


                                    @if (
                                        $routeExists(
                                            'supervisor.evaluations.index'
                                        )
                                    )


                                        <a
                                            href="{{ route(
                                                'supervisor.evaluations.index',
                                                [
                                                    'assignment' =>
                                                        $assignment->id,
                                                ]
                                            ) }}"
                                            class="student-report-action"
                                        >
                                            Final Evaluation
                                        </a>


                                    @endif


                                </div>


                            </div>


                        </article>


                    @endforeach


                </div>


                <div
                    class="report-filter-empty"
                    id="report-filter-empty"
                >

                    No Student reports match
                    your current search or filter.

                </div>


            @else


                <div class="report-empty">


                    <div class="report-empty-icon">
                        RP
                    </div>


                    <h3>
                        No Student Reports Available Yet
                    </h3>


                    <p>

                        Student OJT reports will appear here
                        after OJT Assignments are connected
                        to your Supervisor account.

                    </p>


                </div>


            @endif


        </div>


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
            | Student Report Search & Filter
            |--------------------------------------------------------------------------
            */

            const searchInput =
                document.getElementById(
                    'report-search'
                );


            const statusFilter =
                document.getElementById(
                    'report-status-filter'
                );


            const cards =
                Array.from(
                    document.querySelectorAll(
                        '[data-report-card]'
                    )
                );


            const visibleCount =
                document.getElementById(
                    'report-visible-count'
                );


            const emptyMessage =
                document.getElementById(
                    'report-filter-empty'
                );


            const applyFilters =
                function () {

                    if (! cards.length) {
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


                    cards.forEach(
                        function (card) {

                            const searchable =
                                (
                                    card.dataset.search
                                    || ''
                                )
                                    .toLowerCase();


                            const status =
                                (
                                    card.dataset.status
                                    || ''
                                )
                                    .toLowerCase();


                            const needsEvaluation =
                                card.dataset.needsEvaluation
                                === '1';


                            const matchesSearch =
                                ! search
                                ||
                                searchable.includes(
                                    search
                                );


                            let matchesFilter = true;


                            if (filter) {

                                if (
                                    filter ===
                                    'needs_evaluation'
                                ) {

                                    matchesFilter =
                                        needsEvaluation;

                                } else {

                                    matchesFilter =
                                        status === filter;

                                }

                            }


                            const visible =
                                matchesSearch
                                &&
                                matchesFilter;


                            card.style.display =
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
                                    ? ' report'
                                    : ' reports'
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