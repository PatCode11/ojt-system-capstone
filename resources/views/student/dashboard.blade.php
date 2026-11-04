@extends('layouts.app')


@section('title', 'Student Dashboard | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC STUDENT DASHBOARD
       READABILITY-FIRST PROFESSIONAL DESIGN
       ================================================================ */

    :root {
        --dash-navy: #183B6B;
        --dash-navy-dark: #102A4A;
        --dash-navy-deep: #0B223D;

        --dash-blue: #2563EB;
        --dash-blue-soft: #EAF2FF;

        --dash-green: #15803D;
        --dash-green-soft: #EAF8EF;

        --dash-teal: #0F766E;
        --dash-teal-soft: #E7F7F5;

        --dash-orange: #B45309;
        --dash-orange-soft: #FFF5E6;

        --dash-red: #B42318;
        --dash-red-soft: #FFF0EE;

        --dash-purple: #6D4FC2;
        --dash-purple-soft: #F2EEFF;

        --dash-text: #102A4A;
        --dash-body: #405872;
        --dash-muted: #64778C;

        --dash-white: #FFFFFF;
        --dash-soft: #F8FBFE;

        --dash-border: #D8E3EE;
        --dash-border-soft: #E7EDF4;

        --dash-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --dash-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --dash-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .student-dashboard-page {
        width: 100%;

        color:
            var(--dash-text);

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

    .student-dashboard-hero {
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
            var(--dash-shadow-large);
    }


    .student-dashboard-hero::before {
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


    .student-dashboard-hero::after {
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


    .dashboard-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 36px;
    }


    .dashboard-hero-profile {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 23px;
    }


    .dashboard-hero-avatar {
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

        color:
            #FFFFFF;

        font-size: 27px;
        font-weight: 900;

        backdrop-filter:
            blur(10px);
    }


    .dashboard-hero-copy {
        min-width: 0;

        max-width: 710px;
    }


    .dashboard-hero-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 9px;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 14px;
        font-weight: 800;
    }


    .dashboard-hero-dot {
        width: 9px;
        height: 9px;

        flex-shrink: 0;

        border-radius: 50%;

        background:
            #2DD4BF;

        box-shadow:
            0 0 0 5px
            rgba(45, 212, 191, 0.13);
    }


    .student-dashboard-hero h1 {
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
            -0.55px;
    }


    .dashboard-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO PLACEMENT CARD
       ================================================================ */

    .dashboard-placement-card {
        width: 330px;

        flex-shrink: 0;

        padding:
            21px;

        border:
            1px solid
            rgba(255, 255, 255, 0.16);

        border-radius: 19px;

        background:
            rgba(255, 255, 255, 0.10);

        backdrop-filter:
            blur(10px);
    }


    .dashboard-placement-label {
        display: block;

        margin-bottom: 7px;

        color:
            rgba(255, 255, 255, 0.68);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: 0.4px;
    }


    .dashboard-placement-company {
        display: block;

        color:
            #FFFFFF;

        font-size: 20px;
        font-weight: 900;

        line-height: 1.4;
    }


    .dashboard-placement-supervisor {
        display: block;

        margin-top: 7px;

        color:
            rgba(255, 255, 255, 0.78);

        font-size: 15px;

        line-height: 1.6;
    }


    .dashboard-placement-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        margin-top: 16px;

        padding-top: 15px;

        border-top:
            1px solid
            rgba(255, 255, 255, 0.12);
    }


    .dashboard-placement-status {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding:
            7px
            11px;

        border-radius: 999px;

        background:
            rgba(255, 255, 255, 0.12);

        color:
            #FFFFFF;

        font-size: 13px;
        font-weight: 850;
    }


    .dashboard-placement-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;

        background:
            #2DD4BF;
    }


    .dashboard-placement-hours {
        color:
            rgba(255, 255, 255, 0.80);

        font-size: 13px;
        font-weight: 750;
    }


    /* ================================================================
       COMPLETION NOTICE
       ================================================================ */

    .dashboard-completion-notice {
        display: flex;
        align-items: flex-start;

        gap: 15px;

        margin-bottom: 26px;

        padding:
            19px
            21px;

        border:
            1px solid
            #CFE0F4;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #F7FAFF 0%,
                #EFF6FF 100%
            );

        box-shadow:
            var(--dash-shadow);
    }


    .dashboard-completion-icon {
        width: 45px;
        height: 45px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--dash-blue-soft);

        color:
            var(--dash-blue);

        font-size: 17px;
        font-weight: 900;
    }


    .dashboard-completion-notice strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--dash-text);

        font-size: 17px;
        font-weight: 850;
    }


    .dashboard-completion-notice span {
        color:
            var(--dash-body);

        font-size: 15px;

        line-height: 1.65;
    }


    /* ================================================================
       SUMMARY GRID
       ================================================================ */

    .dashboard-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 19px;

        margin-bottom: 29px;
    }


    .dashboard-summary-card {
        padding:
            24px;

        border:
            1px solid
            var(--dash-border);

        border-radius: 20px;

        background:
            var(--dash-white);

        box-shadow:
            var(--dash-shadow);

        transition:
            var(--dash-transition);
    }


    .dashboard-summary-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            0 18px 38px
            rgba(15, 42, 74, 0.10);
    }


    .dashboard-summary-icon {
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
            var(--dash-blue-soft);

        color:
            var(--dash-blue);
    }


    .summary-green {
        background:
            var(--dash-green-soft);

        color:
            var(--dash-green);
    }


    .summary-orange {
        background:
            var(--dash-orange-soft);

        color:
            var(--dash-orange);
    }


    .summary-purple {
        background:
            var(--dash-purple-soft);

        color:
            var(--dash-purple);
    }


    .dashboard-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--dash-body);

        font-size: 15px;
        font-weight: 750;
    }


    .dashboard-summary-value {
        display: block;

        color:
            var(--dash-text);

        font-size: 32px;
        font-weight: 900;

        line-height: 1.15;
    }


    .dashboard-summary-value-text {
        font-size: 19px;
    }


    .dashboard-summary-note {
        display: block;

        margin-top: 9px;

        color:
            var(--dash-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       STATUS BADGES
       ================================================================ */

    .dashboard-status {
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


    .dashboard-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .status-active {
        background:
            var(--dash-green-soft);

        color:
            var(--dash-green);
    }


    .status-active::before {
        background:
            #22C55E;
    }


    .status-pending {
        background:
            var(--dash-orange-soft);

        color:
            var(--dash-orange);
    }


    .status-pending::before {
        background:
            #F59E0B;
    }


    .status-completed {
        background:
            var(--dash-blue-soft);

        color:
            var(--dash-blue);
    }


    .status-completed::before {
        background:
            #3B82F6;
    }


    .status-rejected,
    .status-cancelled {
        background:
            var(--dash-red-soft);

        color:
            var(--dash-red);
    }


    .status-rejected::before,
    .status-cancelled::before {
        background:
            #EF4444;
    }


    .status-validated {
        background:
            var(--dash-green-soft);

        color:
            var(--dash-green);
    }


    .status-validated::before {
        background:
            #22C55E;
    }


    .status-in-progress {
        background:
            var(--dash-blue-soft);

        color:
            var(--dash-blue);
    }


    .status-in-progress::before {
        background:
            #3B82F6;
    }


    /* ================================================================
       MAIN LAYOUT
       ================================================================ */

    .dashboard-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1.34fr)
            minmax(350px, 0.66fr);

        gap: 23px;

        align-items: start;
    }


    .dashboard-main,
    .dashboard-sidebar {
        display: grid;

        gap: 23px;
    }


    /* ================================================================
       PANEL
       ================================================================ */

    .dashboard-panel {
        overflow: hidden;

        border:
            1px solid
            var(--dash-border);

        border-radius: 20px;

        background:
            var(--dash-white);

        box-shadow:
            var(--dash-shadow);
    }


    .dashboard-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            24px
            26px;

        border-bottom:
            1px solid
            var(--dash-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .dashboard-panel-heading {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    .dashboard-panel-icon {
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
            var(--dash-blue-soft);

        color:
            var(--dash-blue);
    }


    .panel-green {
        background:
            var(--dash-green-soft);

        color:
            var(--dash-green);
    }


    .panel-teal {
        background:
            var(--dash-teal-soft);

        color:
            var(--dash-teal);
    }


    .panel-orange {
        background:
            var(--dash-orange-soft);

        color:
            var(--dash-orange);
    }


    .panel-purple {
        background:
            var(--dash-purple-soft);

        color:
            var(--dash-purple);
    }


    .dashboard-panel-heading h2 {
        margin:
            0
            0
            4px;

        color:
            var(--dash-text);

        font-size: 23px;
        font-weight: 850;

        line-height: 1.3;
    }


    .dashboard-panel-heading p {
        margin: 0;

        color:
            var(--dash-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .dashboard-panel-body {
        padding:
            26px;
    }


    /* ================================================================
       HOURS PROGRESS
       ================================================================ */

    .hours-feature {
        padding:
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
    }


    .hours-feature-top {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 15px;
    }


    .hours-feature-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--dash-muted);

        font-size: 14px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .hours-feature-value {
        color:
            var(--dash-text);

        font-size: 40px;
        font-weight: 900;

        line-height: 1.05;
    }


    .hours-feature-value span {
        color:
            var(--dash-muted);

        font-size: 16px;
        font-weight: 750;
    }


    .hours-feature-percent {
        color:
            var(--dash-teal);

        font-size: 30px;
        font-weight: 900;
    }


    .hours-progress-track {
        width: 100%;
        height: 11px;

        overflow: hidden;

        border-radius: 999px;

        background:
            #DCE9E6;
    }


    .hours-progress-fill {
        height: 100%;

        border-radius: inherit;

        background:
            linear-gradient(
                90deg,
                #2563EB,
                #0F766E
            );
    }


    .hours-feature-description {
        margin-top: 13px;

        color:
            var(--dash-body);

        font-size: 15px;

        line-height: 1.7;
    }


    .hours-stat-grid {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 12px;

        margin-top: 18px;
    }


    .hours-stat-card {
        padding:
            15px;

        border:
            1px solid
            var(--dash-border-soft);

        border-radius: 12px;

        background:
            rgba(255, 255, 255, 0.82);
    }


    .hours-stat-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--dash-muted);

        font-size: 13px;
        font-weight: 750;
    }


    .hours-stat-value {
        display: block;

        color:
            var(--dash-text);

        font-size: 19px;
        font-weight: 900;
    }


    /* ================================================================
       PLACEMENT INFORMATION
       ================================================================ */

    .placement-information-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 14px;
    }


    .placement-information-item {
        min-height: 100px;

        padding:
            17px;

        border:
            1px solid
            var(--dash-border-soft);

        border-radius: 13px;

        background:
            var(--dash-soft);
    }


    .placement-information-full {
        grid-column:
            1 / -1;
    }


    .placement-information-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--dash-muted);

        font-size: 14px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.3px;
    }


    .placement-information-value {
        display: block;

        color:
            var(--dash-text);

        font-size: 17px;
        font-weight: 850;

        line-height: 1.55;

        word-break: break-word;
    }


    .placement-information-secondary {
        display: block;

        margin-top: 5px;

        color:
            var(--dash-body);

        font-size: 15px;

        line-height: 1.55;
    }


    /* ================================================================
       RECENT ACTIVITY
       ================================================================ */

    .recent-list {
        display: grid;
    }


    .recent-item {
        display: grid;

        grid-template-columns:
            auto
            minmax(0, 1fr)
            auto;

        gap: 15px;

        align-items: center;

        padding:
            18px
            0;

        border-bottom:
            1px solid
            var(--dash-border-soft);
    }


    .recent-item:first-child {
        padding-top: 0;
    }


    .recent-item:last-child {
        padding-bottom: 0;

        border-bottom: none;
    }


    .recent-icon {
        width: 48px;
        height: 48px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--dash-blue-soft);

        color:
            var(--dash-blue);

        font-size: 13px;
        font-weight: 900;
    }


    .recent-icon-purple {
        background:
            var(--dash-purple-soft);

        color:
            var(--dash-purple);
    }


    .recent-title {
        display: block;

        margin-bottom: 4px;

        color:
            var(--dash-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.45;
    }


    .recent-description {
        display: block;

        color:
            var(--dash-muted);

        font-size: 14px;

        line-height: 1.6;
    }


    /* ================================================================
       VIEW ALL LINK
       ================================================================ */

    .dashboard-view-link {
        color:
            var(--dash-navy);

        text-decoration: none;

        font-size: 14px;
        font-weight: 850;

        white-space: nowrap;
    }


    .dashboard-view-link:hover {
        text-decoration: underline;
    }


    /* ================================================================
       QUICK ACTIONS
       ================================================================ */

    .quick-action-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 13px;
    }


    .quick-action-card {
        min-height: 132px;

        display: flex;
        flex-direction: column;
        justify-content: space-between;

        gap: 14px;

        padding:
            17px;

        border:
            1px solid
            var(--dash-border);

        border-radius: 15px;

        background:
            #FBFDFF;

        color:
            var(--dash-text);

        text-decoration: none;

        transition:
            var(--dash-transition);
    }


    .quick-action-card:hover {
        transform:
            translateY(-2px);

        border-color:
            #B9CCDF;

        background:
            #FFFFFF;

        box-shadow:
            0 12px 26px
            rgba(16, 42, 74, 0.08);
    }


    .quick-action-icon {
        width: 42px;
        height: 42px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 11px;

        font-size: 13px;
        font-weight: 900;
    }


    .action-blue {
        background:
            var(--dash-blue-soft);

        color:
            var(--dash-blue);
    }


    .action-green {
        background:
            var(--dash-green-soft);

        color:
            var(--dash-green);
    }


    .action-purple {
        background:
            var(--dash-purple-soft);

        color:
            var(--dash-purple);
    }


    .action-orange {
        background:
            var(--dash-orange-soft);

        color:
            var(--dash-orange);
    }


    .action-teal {
        background:
            var(--dash-teal-soft);

        color:
            var(--dash-teal);
    }


    .quick-action-title {
        display: block;

        color:
            var(--dash-text);

        font-size: 16px;
        font-weight: 850;
    }


    .quick-action-description {
        display: block;

        margin-top: 4px;

        color:
            var(--dash-muted);

        font-size: 14px;

        line-height: 1.5;
    }


    /* ================================================================
       SIDEBAR INFO
       ================================================================ */

    .dashboard-sidebar-list {
        display: grid;

        gap: 12px;
    }


    .dashboard-sidebar-item {
        padding:
            14px
            15px;

        border:
            1px solid
            var(--dash-border-soft);

        border-radius: 12px;

        background:
            var(--dash-soft);
    }


    .dashboard-sidebar-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--dash-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .dashboard-sidebar-value {
        display: block;

        color:
            var(--dash-text);

        font-size: 17px;
        font-weight: 850;

        line-height: 1.5;
    }


    /* ================================================================
       VALIDATION LIST
       ================================================================ */

    .validation-list {
        display: grid;

        gap: 12px;
    }


    .validation-item {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 13px;

        padding:
            14px
            15px;

        border:
            1px solid
            var(--dash-border-soft);

        border-radius: 12px;

        background:
            #FBFCFE;
    }


    .validation-left {
        display: flex;
        align-items: center;

        gap: 11px;
    }


    .validation-icon {
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


    .validation-clear {
        background:
            var(--dash-green-soft);

        color:
            var(--dash-green);
    }


    .validation-warning {
        background:
            var(--dash-orange-soft);

        color:
            var(--dash-orange);
    }


    .validation-name {
        color:
            var(--dash-text);

        font-size: 15px;
        font-weight: 800;
    }


    .validation-count {
        color:
            var(--dash-body);

        font-size: 16px;
        font-weight: 900;
    }


    /* ================================================================
       TODAY STATUS
       ================================================================ */

    .today-status-card {
        display: flex;
        align-items: center;

        gap: 15px;

        padding:
            16px;

        border:
            1px solid
            var(--dash-border-soft);

        border-radius: 13px;

        background:
            var(--dash-soft);
    }


    .today-status-icon {
        width: 48px;
        height: 48px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--dash-blue-soft);

        color:
            var(--dash-blue);

        font-size: 13px;
        font-weight: 900;
    }


    .today-status-title {
        display: block;

        margin-bottom: 4px;

        color:
            var(--dash-text);

        font-size: 16px;
        font-weight: 850;
    }


    .today-status-description {
        color:
            var(--dash-body);

        font-size: 14px;

        line-height: 1.6;
    }


    .today-time-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 11px;

        margin-top: 13px;
    }


    .today-time-item {
        padding:
            13px;

        border:
            1px solid
            var(--dash-border-soft);

        border-radius: 11px;

        background:
            #FFFFFF;
    }


    .today-time-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--dash-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .today-time-value {
        display: block;

        color:
            var(--dash-text);

        font-size: 18px;
        font-weight: 900;
    }


    /* ================================================================
       EMPTY STATE
       ================================================================ */

    .dashboard-empty-state {
        padding:
            42px
            24px;

        text-align: center;
    }


    .dashboard-empty-icon {
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
            var(--dash-blue-soft);

        color:
            var(--dash-blue);

        font-size: 16px;
        font-weight: 900;
    }


    .dashboard-empty-state h3 {
        margin:
            0
            0
            8px;

        color:
            var(--dash-text);

        font-size: 21px;
        font-weight: 850;
    }


    .dashboard-empty-state p {
        max-width: 540px;

        margin:
            0
            auto;

        color:
            var(--dash-body);

        font-size: 15px;

        line-height: 1.7;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1150px) {

        .dashboard-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .dashboard-layout {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 850px) {

        .student-dashboard-hero {
            padding:
                34px
                28px;
        }


        .dashboard-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .dashboard-placement-card {
            width: 100%;
        }

    }


    @media (max-width: 650px) {

        .student-dashboard-page {
            font-size: 16px;
        }


        .student-dashboard-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .dashboard-hero-profile {
            flex-direction: column;

            align-items: flex-start;
        }


        .student-dashboard-hero h1 {
            font-size: 31px;
        }


        .dashboard-hero-description {
            font-size: 16px;
        }


        .dashboard-summary-grid,
        .hours-stat-grid,
        .placement-information-grid,
        .quick-action-grid {
            grid-template-columns: 1fr;
        }


        .placement-information-full {
            grid-column: auto;
        }


        .dashboard-panel-header,
        .dashboard-panel-body {
            padding-left: 20px;
            padding-right: 20px;
        }


        .dashboard-panel-heading h2 {
            font-size: 21px;
        }


        .hours-feature-top {
            flex-direction: column;

            align-items: flex-start;
        }


        .hours-feature-value {
            font-size: 34px;
        }


        .recent-item {
            grid-template-columns:
                auto
                minmax(0, 1fr);
        }


        .recent-item > :last-child {
            grid-column: 2;
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
    | Assignments
    |--------------------------------------------------------------------------
    */

    $assignments =
        $studentProfile
            ? collect(
                $studentProfile->ojtAssignments
                ?? []
            )
            : collect();


    /*
    |--------------------------------------------------------------------------
    | Display Assignment
    |--------------------------------------------------------------------------
    |
    | Priority:
    |
    | 1. Controller provided assignment
    | 2. Controller provided activeAssignment
    | 3. Active assignment
    | 4. Pending assignment
    | 5. Most recent assignment
    |
    */

    $displayAssignment =
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
            )
        ?? $assignments
            ->sortByDesc(
                'created_at'
            )
            ->first();


    /*
    |--------------------------------------------------------------------------
    | Student Identity
    |--------------------------------------------------------------------------
    */

    $studentName =
        $student?->name
        ?? 'Student';


    $nameParts =
        preg_split(
            '/\s+/',
            trim($studentName)
        );


    $studentInitials =
        collect($nameParts)
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
    | Assignment Status
    |--------------------------------------------------------------------------
    */

    $assignmentStatus =
        $displayAssignment
            ? (string) $displayAssignment->status
            : null;


    $isActive =
        $displayAssignment
        &&
        $assignmentStatus
        === \App\Models\OjtAssignment::STATUS_ACTIVE;


    $isPending =
        $displayAssignment
        &&
        $assignmentStatus
        === \App\Models\OjtAssignment::STATUS_PENDING;


    $isCompleted =
        $displayAssignment
        &&
        $assignmentStatus
        === \App\Models\OjtAssignment::STATUS_COMPLETED;


    /*
    |--------------------------------------------------------------------------
    | Attendance Records
    |--------------------------------------------------------------------------
    */

    $attendanceRecords =
        $displayAssignment
            ? collect(
                $displayAssignment->attendanceRecords
                ?? []
            )
            : collect();


    $validatedAttendance =
        $attendanceRecords
            ->filter(
                fn ($record) =>
                    strtolower(
                        (string) $record->status
                    ) === 'validated'
            );


    $pendingAttendance =
        $attendanceRecords
            ->filter(
                fn ($record) =>
                    strtolower(
                        (string) $record->status
                    ) === 'pending'
            );


    $rejectedAttendance =
        $attendanceRecords
            ->filter(
                fn ($record) =>
                    strtolower(
                        (string) $record->status
                    ) === 'rejected'
            );


    /*
    |--------------------------------------------------------------------------
    | Rendered Hours
    |--------------------------------------------------------------------------
    */

    $validatedMinutes =
        (int) $validatedAttendance
            ->sum(
                fn ($record) =>
                    (int) (
                        $record->rendered_minutes
                        ?? 0
                    )
            );


    $validatedHours =
        $validatedMinutes / 60;


    $requiredHours =
        $displayAssignment
            ? (float) $displayAssignment->required_hours
            : 0;


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
    | Daily Work Logs
    |--------------------------------------------------------------------------
    */

    $workLogs =
        $displayAssignment
            ? collect(
                $displayAssignment->dailyWorkLogs
                ?? []
            )
            : collect();


    $validatedWorkLogs =
        $workLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string) $log->status
                    ) === 'validated'
            );


    $pendingWorkLogs =
        $workLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string) $log->status
                    ) === 'pending'
            );


    $rejectedWorkLogs =
        $workLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string) $log->status
                    ) === 'rejected'
            );


    /*
    |--------------------------------------------------------------------------
    | Final Evaluation
    |--------------------------------------------------------------------------
    */

    $finalEvaluation =
        $displayAssignment
            ? $displayAssignment->finalEvaluation
            : null;


    /*
    |--------------------------------------------------------------------------
    | Today
    |--------------------------------------------------------------------------
    */

    $today =
        now()
            ->timezone(
                'Asia/Manila'
            )
            ->toDateString();


    /*
    |--------------------------------------------------------------------------
    | Today's Attendance
    |--------------------------------------------------------------------------
    */

    $todayAttendance =
        $attendanceRecords
            ->first(
                function ($record) use (
                    $today
                ) {

                    $recordDate =
                        $record->attendance_date
                        ?? $record->date
                        ?? null;


                    if (! $recordDate) {
                        return false;
                    }


                    try {

                        return
                            \Illuminate\Support\Carbon::parse(
                                $recordDate
                            )
                                ->toDateString()
                            ===
                            $today;

                    } catch (\Throwable $exception) {

                        return false;

                    }

                }
            );


    /*
    |--------------------------------------------------------------------------
    | Today's Work Log
    |--------------------------------------------------------------------------
    */

    $todayWorkLog =
        $workLogs
            ->first(
                function ($log) use (
                    $today
                ) {

                    $value =
                        $log->submitted_at
                        ?? $log->created_at;


                    if (! $value) {
                        return false;
                    }


                    try {

                        return
                            \Illuminate\Support\Carbon::parse(
                                $value
                            )
                                ->timezone(
                                    'Asia/Manila'
                                )
                                ->toDateString()
                            ===
                            $today;

                    } catch (\Throwable $exception) {

                        return false;

                    }

                }
            );


    /*
    |--------------------------------------------------------------------------
    | Recent Attendance
    |--------------------------------------------------------------------------
    */

    $recentAttendance =
        $attendanceRecords
            ->sortByDesc(
                fn ($record) =>
                    $record->attendance_date
                    ?? $record->date
                    ?? $record->created_at
            )
            ->take(5)
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Recent Work Logs
    |--------------------------------------------------------------------------
    */

    $recentWorkLogs =
        $workLogs
            ->sortByDesc(
                fn ($log) =>
                    $log->submitted_at
                    ?? $log->created_at
            )
            ->take(5)
            ->values();


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
    | Route Helper
    |--------------------------------------------------------------------------
    */

    $routeExists =
        fn ($name) =>
            \Illuminate\Support\Facades\Route::has(
                $name
            );


    /*
    |--------------------------------------------------------------------------
    | Status Class
    |--------------------------------------------------------------------------
    */

    $recordStatusClass =
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

                default =>
                    'status-in-progress',

            };

        };


    /*
    |--------------------------------------------------------------------------
    | Status Label
    |--------------------------------------------------------------------------
    */

    $recordStatusLabel =
        function ($status) {

            return ucwords(
                str_replace(
                    '_',
                    ' ',
                    (string) $status
                )
            );

        };

@endphp


<div class="student-dashboard-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="student-dashboard-hero">


        <div class="dashboard-hero-inner">


            <div class="dashboard-hero-profile">


                <div class="dashboard-hero-avatar">

                    {{ $studentInitials ?: 'ST' }}

                </div>


                <div class="dashboard-hero-copy">


                    <div class="dashboard-hero-eyebrow">


                        <span class="dashboard-hero-dot"></span>


                        Student Portal · OJT Monitoring


                    </div>


                    <h1>

                        Welcome back,
                        {{ $studentName }}

                    </h1>


                    <p class="dashboard-hero-description">


                        @if ($displayAssignment)

                            Monitor your OJT placement,
                            validated rendered hours,
                            attendance, Daily Work Logs,
                            and Supervisor review from
                            one easy-to-read dashboard.

                        @else

                            Your Student account is ready.
                            Your OJT placement information
                            will appear here once an
                            assignment becomes available.

                        @endif


                    </p>


                </div>


            </div>


            <div class="dashboard-placement-card">


                <span class="dashboard-placement-label">
                    Current OJT Placement
                </span>


                <span class="dashboard-placement-company">

                    {{ $displayAssignment
                        ? (
                            $displayAssignment
                                ->company
                                ?->name
                            ?? 'Company unavailable'
                        )
                        : 'Awaiting Assignment'
                    }}

                </span>


                <span class="dashboard-placement-supervisor">


                    @if ($displayAssignment)

                        Supervisor:

                        {{ $displayAssignment
                            ->supervisor
                            ?->name
                            ?? 'Not assigned'
                        }}

                    @else

                        Your company and assigned
                        Supervisor will appear here.

                    @endif


                </span>


                @if ($displayAssignment)


                    <div class="dashboard-placement-footer">


                        <span class="dashboard-placement-status">

                            {{ ucfirst(
                                $assignmentStatus
                            ) }}

                        </span>


                        <span class="dashboard-placement-hours">

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
         COMPLETED ASSIGNMENT NOTICE
         ================================================================== --}}

    @if ($isCompleted)


        <section class="dashboard-completion-notice">


            <div class="dashboard-completion-icon">
                ✓
            </div>


            <div>


                <strong>
                    Your OJT Assignment Has Been Completed
                </strong>


                <span>

                    This dashboard is showing your
                    completed placement for reference.
                    Historical attendance, Work Logs,
                    reports, and assignment information
                    remain available for review.

                </span>


            </div>


        </section>


    @endif


    {{-- ==================================================================
         SUMMARY CARDS
         ================================================================== --}}

    <section class="dashboard-summary-grid">


        {{-- ==============================================================
             ASSIGNMENT STATUS
             ============================================================== --}}

        <article class="dashboard-summary-card">


            <div class="dashboard-summary-icon summary-blue">
                ST
            </div>


            <span class="dashboard-summary-label">
                Assignment Status
            </span>


            <span
                class="
                    dashboard-summary-value
                    dashboard-summary-value-text
                "
            >


                @if ($isActive)


                    <span
                        class="
                            dashboard-status
                            status-active
                        "
                    >
                        Active
                    </span>


                @elseif ($isPending)


                    <span
                        class="
                            dashboard-status
                            status-pending
                        "
                    >
                        Pending
                    </span>


                @elseif ($isCompleted)


                    <span
                        class="
                            dashboard-status
                            status-completed
                        "
                    >
                        Completed
                    </span>


                @elseif ($displayAssignment)


                    <span
                        class="
                            dashboard-status
                            status-cancelled
                        "
                    >

                        {{ ucfirst(
                            $assignmentStatus
                        ) }}

                    </span>


                @else


                    Not Assigned


                @endif


            </span>


            <span class="dashboard-summary-note">
                Current OJT placement lifecycle status.
            </span>


        </article>


        {{-- ==============================================================
             HOURS
             ============================================================== --}}

        <article class="dashboard-summary-card">


            <div class="dashboard-summary-icon summary-green">
                HR
            </div>


            <span class="dashboard-summary-label">
                Validated Hours
            </span>


            <span class="dashboard-summary-value">

                {{ number_format(
                    $validatedHours,
                    1
                ) }}

            </span>


            <div
                class="hours-progress-track"
                style="margin-top:12px;"
            >


                <div
                    class="hours-progress-fill"
                    style="width: {{ $progressPercentage }}%;"
                ></div>


            </div>


            <span class="dashboard-summary-note">

                {{ $progressPercentage }}%
                of
                {{ number_format(
                    $requiredHours
                ) }}
                required hours.

            </span>


        </article>


        {{-- ==============================================================
             ATTENDANCE
             ============================================================== --}}

        <article class="dashboard-summary-card">


            <div class="dashboard-summary-icon summary-orange">
                AT
            </div>


            <span class="dashboard-summary-label">
                Attendance Records
            </span>


            <span class="dashboard-summary-value">

                {{ $attendanceRecords->count() }}

            </span>


            <span class="dashboard-summary-note">

                {{ $validatedAttendance->count() }}
                validated ·

                {{ $pendingAttendance->count() }}
                pending.

            </span>


        </article>


        {{-- ==============================================================
             WORK LOGS
             ============================================================== --}}

        <article class="dashboard-summary-card">


            <div class="dashboard-summary-icon summary-purple">
                WL
            </div>


            <span class="dashboard-summary-label">
                Daily Work Logs
            </span>


            <span class="dashboard-summary-value">

                {{ $workLogs->count() }}

            </span>


            <span class="dashboard-summary-note">

                {{ $validatedWorkLogs->count() }}
                validated ·

                {{ $pendingWorkLogs->count() }}
                pending.

            </span>


        </article>


    </section>


    {{-- ==================================================================
         MAIN DASHBOARD
         ================================================================== --}}

    <div class="dashboard-layout">


        {{-- ==============================================================
             MAIN COLUMN
             ============================================================== --}}

        <main class="dashboard-main">


            {{-- ==========================================================
                 OJT HOURS
                 ========================================================== --}}

            <section class="dashboard-panel">


                <div class="dashboard-panel-header">


                    <div class="dashboard-panel-heading">


                        <div class="dashboard-panel-icon panel-teal">
                            HR
                        </div>


                        <div>


                            <h2>
                                OJT Hours Progress
                            </h2>


                            <p>
                                Track your validated rendered hours
                            </p>


                        </div>


                    </div>


                </div>


                <div class="dashboard-panel-body">


                    @if ($displayAssignment)


                        <div class="hours-feature">


                            <div class="hours-feature-top">


                                <div>


                                    <span class="hours-feature-label">
                                        Validated Rendered Hours
                                    </span>


                                    <div class="hours-feature-value">

                                        {{ number_format(
                                            $validatedHours,
                                            1
                                        ) }}

                                        <span>

                                            /
                                            {{ number_format(
                                                $requiredHours
                                            ) }}
                                            hrs

                                        </span>


                                    </div>


                                </div>


                                <div class="hours-feature-percent">

                                    {{ $progressPercentage }}%

                                </div>


                            </div>


                            <div class="hours-progress-track">


                                <div
                                    class="hours-progress-fill"
                                    style="width: {{ $progressPercentage }}%;"
                                ></div>


                            </div>


                            <div class="hours-feature-description">

                                Your official rendered-hour total
                                only includes attendance records
                                that have been validated by your
                                assigned Supervisor.

                            </div>


                            <div class="hours-stat-grid">


                                <div class="hours-stat-card">


                                    <span class="hours-stat-label">
                                        Required Hours
                                    </span>


                                    <span class="hours-stat-value">

                                        {{ number_format(
                                            $requiredHours,
                                            1
                                        ) }}

                                    </span>


                                </div>


                                <div class="hours-stat-card">


                                    <span class="hours-stat-label">
                                        Validated Hours
                                    </span>


                                    <span class="hours-stat-value">

                                        {{ number_format(
                                            $validatedHours,
                                            1
                                        ) }}

                                    </span>


                                </div>


                                <div class="hours-stat-card">


                                    <span class="hours-stat-label">
                                        Remaining Hours
                                    </span>


                                    <span class="hours-stat-value">

                                        {{ number_format(
                                            $remainingHours,
                                            1
                                        ) }}

                                    </span>


                                </div>


                            </div>


                        </div>


                    @else


                        <div class="dashboard-empty-state">


                            <div class="dashboard-empty-icon">
                                HR
                            </div>


                            <h3>
                                No OJT Hours Yet
                            </h3>


                            <p>

                                Your rendered-hour progress
                                will appear after your OJT
                                Assignment becomes available
                                and your attendance records
                                begin receiving Supervisor validation.

                            </p>


                        </div>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 OJT PLACEMENT
                 ========================================================== --}}

            <section class="dashboard-panel">


                <div class="dashboard-panel-header">


                    <div class="dashboard-panel-heading">


                        <div class="dashboard-panel-icon panel-blue">
                            OJ
                        </div>


                        <div>


                            <h2>
                                My OJT Placement
                            </h2>


                            <p>
                                Company, Supervisor, schedule, and requirements
                            </p>


                        </div>


                    </div>


                </div>


                <div class="dashboard-panel-body">


                    @if ($displayAssignment)


                        <div class="placement-information-grid">


                            <div
                                class="
                                    placement-information-item
                                    placement-information-full
                                "
                            >


                                <span class="placement-information-label">
                                    OJT Company
                                </span>


                                <span class="placement-information-value">

                                    {{ $displayAssignment
                                        ->company
                                        ?->name
                                        ?? 'Company unavailable'
                                    }}

                                </span>


                                <span class="placement-information-secondary">

                                    {{ $displayAssignment
                                        ->company
                                        ?->address
                                        ?: 'Company address not provided'
                                    }}

                                </span>


                            </div>


                            <div class="placement-information-item">


                                <span class="placement-information-label">
                                    Assigned Supervisor
                                </span>


                                <span class="placement-information-value">

                                    {{ $displayAssignment
                                        ->supervisor
                                        ?->name
                                        ?? 'Supervisor unavailable'
                                    }}

                                </span>


                                <span class="placement-information-secondary">

                                    {{ $displayAssignment
                                        ->supervisor
                                        ?->email
                                        ?? 'Supervisor email not available'
                                    }}

                                </span>


                            </div>


                            <div class="placement-information-item">


                                <span class="placement-information-label">
                                    Required Hours
                                </span>


                                <span class="placement-information-value">

                                    {{ number_format(
                                        $requiredHours
                                    ) }}
                                    hours

                                </span>


                            </div>


                            <div class="placement-information-item">


                                <span class="placement-information-label">
                                    Start Date
                                </span>


                                <span class="placement-information-value">

                                    {{ $formatDate(
                                        $displayAssignment->start_date
                                    ) }}

                                </span>


                            </div>


                            <div class="placement-information-item">


                                <span class="placement-information-label">
                                    End Date
                                </span>


                                <span class="placement-information-value">

                                    {{ $formatDate(
                                        $displayAssignment->end_date
                                    ) }}

                                </span>


                            </div>


                        </div>


                    @else


                        <div class="dashboard-empty-state">


                            <div class="dashboard-empty-icon">
                                OJ
                            </div>


                            <h3>
                                No OJT Assignment Yet
                            </h3>


                            <p>

                                Your company, Supervisor,
                                required training hours, and
                                OJT placement schedule will
                                appear here after your assignment
                                is created.

                            </p>


                        </div>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 RECENT ATTENDANCE
                 ========================================================== --}}

            <section class="dashboard-panel">


                <div class="dashboard-panel-header">


                    <div class="dashboard-panel-heading">


                        <div class="dashboard-panel-icon panel-green">
                            AT
                        </div>


                        <div>


                            <h2>
                                Recent Attendance
                            </h2>


                            <p>
                                Your latest GPS Selfie Attendance records
                            </p>


                        </div>


                    </div>


                    @if (
                        $routeExists(
                            'student.attendance.index'
                        )
                    )


                        <a
                            href="{{ route(
                                'student.attendance.index'
                            ) }}"
                            class="dashboard-view-link"
                        >
                            View All →
                        </a>


                    @endif


                </div>


                <div class="dashboard-panel-body">


                    @if ($recentAttendance->isNotEmpty())


                        <div class="recent-list">


                            @foreach ($recentAttendance as $record)


                                @php

                                    $attendanceDate =
                                        $record->attendance_date
                                        ?? $record->date
                                        ?? null;


                                    $renderedHours =
                                        (
                                            (int) (
                                                $record->rendered_minutes
                                                ?? 0
                                            )
                                        ) / 60;

                                @endphp


                                <div class="recent-item">


                                    <div class="recent-icon">
                                        AT
                                    </div>


                                    <div>


                                        <span class="recent-title">

                                            {{ $formatDate(
                                                $attendanceDate
                                            ) }}

                                        </span>


                                        <span class="recent-description">

                                            {{ $formatTime(
                                                $record->time_in
                                            ) }}

                                            →

                                            {{ $formatTime(
                                                $record->time_out
                                            ) }}

                                            ·

                                            {{ number_format(
                                                $renderedHours,
                                                1
                                            ) }}

                                            rendered hrs

                                        </span>


                                    </div>


                                    <span
                                        class="
                                            dashboard-status
                                            {{ $recordStatusClass(
                                                $record->status
                                            ) }}
                                        "
                                    >

                                        {{ $recordStatusLabel(
                                            $record->status
                                        ) }}

                                    </span>


                                </div>


                            @endforeach


                        </div>


                    @else


                        <div class="dashboard-empty-state">


                            <div class="dashboard-empty-icon">
                                AT
                            </div>


                            <h3>
                                No Attendance Activity Yet
                            </h3>


                            <p>

                                Your recent GPS Selfie Attendance
                                records will appear here after
                                you begin recording Time In
                                and Time Out.

                            </p>


                        </div>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 RECENT WORK LOGS
                 ========================================================== --}}

            <section class="dashboard-panel">


                <div class="dashboard-panel-header">


                    <div class="dashboard-panel-heading">


                        <div class="dashboard-panel-icon panel-purple">
                            WL
                        </div>


                        <div>


                            <h2>
                                Recent Daily Work Logs
                            </h2>


                            <p>
                                Your latest submitted OJT activities
                            </p>


                        </div>


                    </div>


                    @if (
                        $routeExists(
                            'student.work-logs.index'
                        )
                    )


                        <a
                            href="{{ route(
                                'student.work-logs.index'
                            ) }}"
                            class="dashboard-view-link"
                        >
                            View All →
                        </a>


                    @endif


                </div>


                <div class="dashboard-panel-body">


                    @if ($recentWorkLogs->isNotEmpty())


                        <div class="recent-list">


                            @foreach ($recentWorkLogs as $log)


                                <div class="recent-item">


                                    <div
                                        class="
                                            recent-icon
                                            recent-icon-purple
                                        "
                                    >
                                        WL
                                    </div>


                                    <div>


                                        <span class="recent-title">

                                            {{ \Illuminate\Support\Str::limit(
                                                $log->tasks
                                                    ?: 'Daily Work Log',
                                                85
                                            ) }}

                                        </span>


                                        <span class="recent-description">

                                            Submitted

                                            {{ $formatDate(
                                                $log->submitted_at
                                                ?? $log->created_at
                                            ) }}

                                            @if (filled($log->learnings))

                                                ·

                                                {{ \Illuminate\Support\Str::limit(
                                                    $log->learnings,
                                                    70
                                                ) }}

                                            @endif

                                        </span>


                                    </div>


                                    <span
                                        class="
                                            dashboard-status
                                            {{ $recordStatusClass(
                                                $log->status
                                            ) }}
                                        "
                                    >

                                        {{ $recordStatusLabel(
                                            $log->status
                                        ) }}

                                    </span>


                                </div>


                            @endforeach


                        </div>


                    @else


                        <div class="dashboard-empty-state">


                            <div class="dashboard-empty-icon">
                                WL
                            </div>


                            <h3>
                                No Daily Work Logs Yet
                            </h3>


                            <p>

                                Your submitted tasks,
                                learnings, and daily OJT
                                activities will appear here
                                after you begin creating
                                Work Logs.

                            </p>


                        </div>


                    @endif


                </div>


            </section>


        </main>


        {{-- ==============================================================
             SIDEBAR
             ============================================================== --}}

        <aside class="dashboard-sidebar">


            {{-- ==========================================================
                 QUICK ACTIONS
                 ========================================================== --}}

            <section class="dashboard-panel">


                <div class="dashboard-panel-header">


                    <div class="dashboard-panel-heading">


                        <div class="dashboard-panel-icon panel-blue">
                            QA
                        </div>


                        <div>


                            <h2>
                                Quick Actions
                            </h2>


                            <p>
                                Open your most-used OJT tools
                            </p>


                        </div>


                    </div>


                </div>


                <div class="dashboard-panel-body">


                    <div class="quick-action-grid">


                        @if (
                            $routeExists(
                                'student.attendance.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.attendance.index'
                                ) }}"
                                class="quick-action-card"
                            >


                                <span
                                    class="
                                        quick-action-icon
                                        action-green
                                    "
                                >
                                    AT
                                </span>


                                <span>


                                    <span class="quick-action-title">
                                        Attendance
                                    </span>


                                    <span class="quick-action-description">

                                        GPS Selfie Time In
                                        and Time Out.

                                    </span>


                                </span>


                            </a>


                        @endif


                        @if (
                            $routeExists(
                                'student.timesheets.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.timesheets.index'
                                ) }}"
                                class="quick-action-card"
                            >


                                <span
                                    class="
                                        quick-action-icon
                                        action-blue
                                    "
                                >
                                    TS
                                </span>


                                <span>


                                    <span class="quick-action-title">
                                        Timesheet
                                    </span>


                                    <span class="quick-action-description">

                                        Review your
                                        rendered OJT hours.

                                    </span>


                                </span>


                            </a>


                        @endif


                        @if (
                            $routeExists(
                                'student.work-logs.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.work-logs.index'
                                ) }}"
                                class="quick-action-card"
                            >


                                <span
                                    class="
                                        quick-action-icon
                                        action-purple
                                    "
                                >
                                    WL
                                </span>


                                <span>


                                    <span class="quick-action-title">
                                        Work Logs
                                    </span>


                                    <span class="quick-action-description">

                                        Submit daily tasks,
                                        learnings, and activities.

                                    </span>


                                </span>


                            </a>


                        @endif


                        @if (
                            $routeExists(
                                'student.reports.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.reports.index'
                                ) }}"
                                class="quick-action-card"
                            >


                                <span
                                    class="
                                        quick-action-icon
                                        action-orange
                                    "
                                >
                                    RP
                                </span>


                                <span>


                                    <span class="quick-action-title">
                                        My Report
                                    </span>


                                    <span class="quick-action-description">

                                        Review your OJT
                                        progress summary.

                                    </span>


                                </span>


                            </a>


                        @endif


                        @if (
                            $routeExists(
                                'student.profile.show'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.profile.show'
                                ) }}"
                                class="quick-action-card"
                            >


                                <span
                                    class="
                                        quick-action-icon
                                        action-teal
                                    "
                                >
                                    PF
                                </span>


                                <span>


                                    <span class="quick-action-title">
                                        My Profile
                                    </span>


                                    <span class="quick-action-description">

                                        View your Student
                                        and academic information.

                                    </span>


                                </span>


                            </a>


                        @endif


                        @if (
                            $routeExists(
                                'student.assignment-history.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.assignment-history.index'
                                ) }}"
                                class="quick-action-card"
                            >


                                <span
                                    class="
                                        quick-action-icon
                                        action-blue
                                    "
                                >
                                    HS
                                </span>


                                <span>


                                    <span class="quick-action-title">
                                        OJT History
                                    </span>


                                    <span class="quick-action-description">

                                        Review previous
                                        OJT placements.

                                    </span>


                                </span>


                            </a>


                        @endif


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 TODAY'S ATTENDANCE
                 ========================================================== --}}

            <section class="dashboard-panel">


                <div class="dashboard-panel-header">


                    <div class="dashboard-panel-heading">


                        <div class="dashboard-panel-icon panel-green">
                            TD
                        </div>


                        <div>


                            <h2>
                                Today's Attendance
                            </h2>


                            <p>

                                {{ now()
                                    ->timezone('Asia/Manila')
                                    ->format('F d, Y')
                                }}

                            </p>


                        </div>


                    </div>


                </div>


                <div class="dashboard-panel-body">


                    @if ($todayAttendance)


                        <div class="today-status-card">


                            <div class="today-status-icon">
                                AT
                            </div>


                            <div>


                                <span class="today-status-title">
                                    Attendance Recorded
                                </span>


                                <div class="today-status-description">

                                    Status:

                                    <strong>

                                        {{ $recordStatusLabel(
                                            $todayAttendance->status
                                        ) }}

                                    </strong>

                                </div>


                            </div>


                        </div>


                        <div class="today-time-grid">


                            <div class="today-time-item">


                                <span class="today-time-label">
                                    Time In
                                </span>


                                <span class="today-time-value">

                                    {{ $formatTime(
                                        $todayAttendance->time_in
                                    ) }}

                                </span>


                            </div>


                            <div class="today-time-item">


                                <span class="today-time-label">
                                    Time Out
                                </span>


                                <span class="today-time-value">

                                    {{ $formatTime(
                                        $todayAttendance->time_out
                                    ) }}

                                </span>


                            </div>


                        </div>


                    @else


                        <div class="today-status-card">


                            <div class="today-status-icon">
                                AT
                            </div>


                            <div>


                                <span class="today-status-title">
                                    No Attendance Recorded Yet
                                </span>


                                <div class="today-status-description">

                                    Open the Attendance page
                                    when you are ready to record
                                    today's OJT Time In.

                                </div>


                            </div>


                        </div>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 VALIDATION STATUS
                 ========================================================== --}}

            <section class="dashboard-panel">


                <div class="dashboard-panel-header">


                    <div class="dashboard-panel-heading">


                        <div class="dashboard-panel-icon panel-orange">
                            VL
                        </div>


                        <div>


                            <h2>
                                Validation Status
                            </h2>


                            <p>
                                Records that may need attention
                            </p>


                        </div>


                    </div>


                </div>


                <div class="dashboard-panel-body">


                    <div class="validation-list">


                        <div class="validation-item">


                            <div class="validation-left">


                                <span
                                    class="
                                        validation-icon
                                        {{ $pendingAttendance->count() === 0
                                            ? 'validation-clear'
                                            : 'validation-warning'
                                        }}
                                    "
                                >

                                    {{ $pendingAttendance->count() === 0
                                        ? '✓'
                                        : '!'
                                    }}

                                </span>


                                <span class="validation-name">
                                    Pending Attendance
                                </span>


                            </div>


                            <span class="validation-count">

                                {{ $pendingAttendance->count() }}

                            </span>


                        </div>


                        <div class="validation-item">


                            <div class="validation-left">


                                <span
                                    class="
                                        validation-icon
                                        {{ $pendingWorkLogs->count() === 0
                                            ? 'validation-clear'
                                            : 'validation-warning'
                                        }}
                                    "
                                >

                                    {{ $pendingWorkLogs->count() === 0
                                        ? '✓'
                                        : '!'
                                    }}

                                </span>


                                <span class="validation-name">
                                    Pending Work Logs
                                </span>


                            </div>


                            <span class="validation-count">

                                {{ $pendingWorkLogs->count() }}

                            </span>


                        </div>


                        <div class="validation-item">


                            <div class="validation-left">


                                <span
                                    class="
                                        validation-icon
                                        {{ $rejectedAttendance->count() === 0
                                            ? 'validation-clear'
                                            : 'validation-warning'
                                        }}
                                    "
                                >

                                    {{ $rejectedAttendance->count() === 0
                                        ? '✓'
                                        : '!'
                                    }}

                                </span>


                                <span class="validation-name">
                                    Rejected Attendance
                                </span>


                            </div>


                            <span class="validation-count">

                                {{ $rejectedAttendance->count() }}

                            </span>


                        </div>


                        <div class="validation-item">


                            <div class="validation-left">


                                <span
                                    class="
                                        validation-icon
                                        {{ $rejectedWorkLogs->count() === 0
                                            ? 'validation-clear'
                                            : 'validation-warning'
                                        }}
                                    "
                                >

                                    {{ $rejectedWorkLogs->count() === 0
                                        ? '✓'
                                        : '!'
                                    }}

                                </span>


                                <span class="validation-name">
                                    Rejected Work Logs
                                </span>


                            </div>


                            <span class="validation-count">

                                {{ $rejectedWorkLogs->count() }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 FINAL EVALUATION
                 ========================================================== --}}

            <section class="dashboard-panel">


                <div class="dashboard-panel-header">


                    <div class="dashboard-panel-heading">


                        <div class="dashboard-panel-icon panel-purple">
                            EV
                        </div>


                        <div>


                            <h2>
                                Final Evaluation
                            </h2>


                            <p>
                                Supervisor evaluation status
                            </p>


                        </div>


                    </div>


                </div>


                <div class="dashboard-panel-body">


                    @if ($finalEvaluation)


                        <div class="today-status-card">


                            <div class="today-status-icon">
                                EV
                            </div>


                            <div>


                                <span class="today-status-title">

                                    {{ ucwords(
                                        str_replace(
                                            '_',
                                            ' ',
                                            (string)
                                            $finalEvaluation->recommendation
                                        )
                                    ) }}

                                </span>


                                <div class="today-status-description">

                                    Your assigned Supervisor
                                    has submitted your final
                                    OJT evaluation.

                                </div>


                            </div>


                        </div>


                    @else


                        <div class="today-status-card">


                            <div class="today-status-icon">
                                EV
                            </div>


                            <div>


                                <span class="today-status-title">
                                    Not Submitted Yet
                                </span>


                                <div class="today-status-description">

                                    Your final evaluation
                                    will appear after your
                                    Supervisor completes it.

                                </div>


                            </div>


                        </div>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 TODAY'S WORK LOG
                 ========================================================== --}}

            <section class="dashboard-panel">


                <div class="dashboard-panel-header">


                    <div class="dashboard-panel-heading">


                        <div class="dashboard-panel-icon panel-purple">
                            WL
                        </div>


                        <div>


                            <h2>
                                Today's Work Log
                            </h2>


                            <p>
                                Daily OJT activity status
                            </p>


                        </div>


                    </div>


                </div>


                <div class="dashboard-panel-body">


                    @if ($todayWorkLog)


                        <div class="today-status-card">


                            <div class="today-status-icon">
                                ✓
                            </div>


                            <div>


                                <span class="today-status-title">
                                    Work Log Submitted
                                </span>


                                <div class="today-status-description">

                                    {{ \Illuminate\Support\Str::limit(
                                        $todayWorkLog->tasks
                                            ?: 'Your Daily Work Log has been submitted.',
                                        125
                                    ) }}

                                </div>


                            </div>


                        </div>


                    @else


                        <div class="today-status-card">


                            <div class="today-status-icon">
                                WL
                            </div>


                            <div>


                                <span class="today-status-title">
                                    No Work Log Submitted Today
                                </span>


                                <div class="today-status-description">

                                    Your Daily Work Log records
                                    your tasks, learnings, and
                                    other OJT activities.

                                </div>


                            </div>


                        </div>


                    @endif


                </div>


            </section>


        </aside>


    </div>


</div>


@endsection