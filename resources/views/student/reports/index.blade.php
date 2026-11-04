@extends('layouts.app')


@section('title', 'My OJT Report | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC - STUDENT REPORT
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --report-navy: #183B6B;
        --report-navy-dark: #102A4A;

        --report-blue: #2563EB;
        --report-blue-soft: #EAF2FF;

        --report-green: #15803D;
        --report-green-soft: #EAF8EF;

        --report-teal: #0F766E;
        --report-teal-soft: #E7F7F5;

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

    .student-report-page {
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
                circle at 90% 14%,
                rgba(45, 212, 191, 0.19),
                transparent 24%
            ),
            radial-gradient(
                circle at 70% 88%,
                rgba(96, 165, 250, 0.14),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 55%,
                #205F79 100%
            );

        box-shadow:
            var(--report-shadow-large);
    }


    .report-hero::before {
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


    .report-hero::after {
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

        max-width: 760px;
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
            rgba(45, 212, 191, 0.13);
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
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .report-hero-actions {
        width: 320px;

        flex-shrink: 0;

        display: grid;

        gap: 11px;
    }


    .report-hero-button {
        min-height: 51px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            17px;

        border:
            1px solid
            rgba(255, 255, 255, 0.17);

        border-radius: 13px;

        background:
            rgba(255, 255, 255, 0.10);

        color:
            #FFFFFF;

        text-decoration: none;

        font-size: 15px;
        font-weight: 850;

        transition:
            var(--report-transition);
    }


    .report-hero-button:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.17);
    }


    .report-hero-button-primary {
        border-color:
            #FFFFFF;

        background:
            #FFFFFF;

        color:
            var(--report-navy);
    }


    .report-hero-button-primary:hover {
        background:
            #F7FAFF;

        color:
            var(--report-navy-dark);
    }


    /* ================================================================
       ASSIGNMENT SELECTOR
       ================================================================ */

    .report-selector {
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
            var(--report-border);

        border-radius: 17px;

        background:
            var(--report-white);

        box-shadow:
            var(--report-shadow);
    }


    .report-selector-title {
        display: block;

        margin-bottom: 4px;

        color:
            var(--report-text);

        font-size: 17px;
        font-weight: 850;
    }


    .report-selector-description {
        display: block;

        color:
            var(--report-body);

        font-size: 15px;
    }


    .report-selector-form {
        min-width: 350px;
    }


    .report-selector-select {
        width: 100%;

        min-height: 52px;

        padding:
            0
            15px;

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

        font-size: 15px;
        font-weight: 750;

        cursor: pointer;
    }


    .report-selector-select:focus {
        border-color:
            var(--report-blue);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, 0.09);
    }


    /* ================================================================
       SUMMARY CARDS
       ================================================================ */

    .report-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 19px;

        margin-bottom: 29px;
    }


    .report-summary-card {
        padding:
            24px;

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


    .summary-blue {
        background:
            var(--report-blue-soft);

        color:
            var(--report-blue);
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
       LAYOUT
       ================================================================ */

    .report-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1.36fr)
            minmax(350px, 0.64fr);

        gap: 23px;

        align-items: start;
    }


    .report-main,
    .report-sidebar {
        display: grid;

        gap: 23px;
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

        font-size: 13px;
        font-weight: 900;
    }


    .panel-blue {
        background:
            var(--report-blue-soft);

        color:
            var(--report-blue);
    }


    .panel-green {
        background:
            var(--report-green-soft);

        color:
            var(--report-green);
    }


    .panel-teal {
        background:
            var(--report-teal-soft);

        color:
            var(--report-teal);
    }


    .panel-purple {
        background:
            var(--report-purple-soft);

        color:
            var(--report-purple);
    }


    .panel-orange {
        background:
            var(--report-orange-soft);

        color:
            var(--report-orange);
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
        padding:
            26px;
    }


    /* ================================================================
       PROGRESS
       ================================================================ */

    .report-progress-card {
        padding:
            25px;

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


    .report-progress-top {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 17px;
    }


    .report-progress-label {
        display: block;

        margin-bottom: 6px;

        color:
            var(--report-muted);

        font-size: 14px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .report-progress-value {
        color:
            var(--report-text);

        font-size: 40px;
        font-weight: 900;

        line-height: 1.05;
    }


    .report-progress-value small {
        color:
            var(--report-muted);

        font-size: 16px;
        font-weight: 750;
    }


    .report-progress-percent {
        color:
            var(--report-teal);

        font-size: 31px;
        font-weight: 900;
    }


    .report-progress-track {
        width: 100%;
        height: 12px;

        overflow: hidden;

        border-radius: 999px;

        background:
            #DCE9E6;
    }


    .report-progress-fill {
        height: 100%;

        border-radius: inherit;

        background:
            linear-gradient(
                90deg,
                #2563EB,
                #0F766E
            );
    }


    .report-progress-note {
        margin-top: 14px;

        color:
            var(--report-body);

        font-size: 15px;

        line-height: 1.7;
    }


    .report-progress-stat-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 12px;

        margin-top: 19px;
    }


    .report-progress-stat {
        padding:
            15px;

        border:
            1px solid
            var(--report-border-soft);

        border-radius: 12px;

        background:
            rgba(255, 255, 255, 0.84);
    }


    .report-progress-stat-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--report-muted);

        font-size: 13px;
        font-weight: 750;
    }


    .report-progress-stat-value {
        display: block;

        color:
            var(--report-text);

        font-size: 19px;
        font-weight: 900;
    }


    /* ================================================================
       PLACEMENT INFORMATION
       ================================================================ */

    .report-detail-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 14px;
    }


    .report-detail-item {
        min-height: 100px;

        padding:
            17px;

        border:
            1px solid
            var(--report-border-soft);

        border-radius: 13px;

        background:
            var(--report-soft);
    }


    .report-detail-full {
        grid-column:
            1 / -1;
    }


    .report-detail-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--report-muted);

        font-size: 14px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.3px;
    }


    .report-detail-value {
        display: block;

        color:
            var(--report-text);

        font-size: 17px;
        font-weight: 850;

        line-height: 1.55;

        word-break: break-word;
    }


    .report-detail-secondary {
        display: block;

        margin-top: 5px;

        color:
            var(--report-body);

        font-size: 15px;

        line-height: 1.55;
    }


    /* ================================================================
       ACTIVITY SUMMARY
       ================================================================ */

    .activity-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 16px;
    }


    .activity-summary-card {
        padding:
            20px;

        border:
            1px solid
            var(--report-border);

        border-radius: 16px;

        background:
            #FBFDFF;
    }


    .activity-summary-heading {
        display: flex;
        align-items: center;

        gap: 12px;

        margin-bottom: 17px;
    }


    .activity-summary-icon {
        width: 44px;
        height: 44px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        font-size: 13px;
        font-weight: 900;
    }


    .activity-summary-title {
        color:
            var(--report-text);

        font-size: 18px;
        font-weight: 900;
    }


    .activity-stat-list {
        display: grid;

        gap: 10px;
    }


    .activity-stat-row {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        padding:
            12px
            13px;

        border:
            1px solid
            var(--report-border-soft);

        border-radius: 10px;

        background:
            #FFFFFF;
    }


    .activity-stat-label {
        color:
            var(--report-body);

        font-size: 15px;
        font-weight: 750;
    }


    .activity-stat-value {
        color:
            var(--report-text);

        font-size: 17px;
        font-weight: 900;
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


    .status-completed,
    .status-validated {
        background:
            var(--report-blue-soft);

        color:
            var(--report-blue);
    }


    .status-completed::before,
    .status-validated::before {
        background:
            #3B82F6;
    }


    .status-rejected,
    .status-cancelled {
        background:
            var(--report-red-soft);

        color:
            var(--report-red);
    }


    .status-rejected::before,
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
       EVALUATION
       ================================================================ */

    .evaluation-card {
        padding:
            22px;

        border:
            1px solid
            #DCD5F2;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #FBFAFF 0%,
                #F4F0FF 100%
            );
    }


    .evaluation-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;
    }


    .evaluation-title {
        display: block;

        margin-bottom: 4px;

        color:
            var(--report-text);

        font-size: 18px;
        font-weight: 900;
    }


    .evaluation-description {
        color:
            var(--report-body);

        font-size: 15px;

        line-height: 1.6;
    }


    .evaluation-badge {
        display: inline-flex;
        align-items: center;

        padding:
            9px
            13px;

        border-radius: 999px;

        background:
            var(--report-purple-soft);

        color:
            var(--report-purple);

        font-size: 14px;
        font-weight: 900;

        white-space: nowrap;
    }


    .evaluation-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 12px;

        margin-top: 17px;
    }


    .evaluation-item {
        padding:
            14px;

        border:
            1px solid
            rgba(109, 79, 194, 0.10);

        border-radius: 11px;

        background:
            rgba(255, 255, 255, 0.75);
    }


    .evaluation-item-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--report-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .evaluation-item-value {
        color:
            var(--report-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.55;
    }


    /* ================================================================
       COMPLETION
       ================================================================ */

    .completion-card {
        margin-top: 15px;

        padding:
            20px;

        border:
            1px solid
            #CADDF3;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                #F8FBFF 0%,
                #EFF6FF 100%
            );
    }


    .completion-title {
        display: block;

        margin-bottom: 5px;

        color:
            var(--report-text);

        font-size: 18px;
        font-weight: 900;
    }


    .completion-description {
        color:
            var(--report-body);

        font-size: 15px;

        line-height: 1.65;
    }


    .completion-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 11px;

        margin-top: 15px;
    }


    .completion-item {
        padding:
            13px;

        border:
            1px solid
            rgba(37, 99, 235, 0.09);

        border-radius: 10px;

        background:
            rgba(255, 255, 255, 0.75);
    }


    .completion-item-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--report-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .completion-item-value {
        color:
            var(--report-text);

        font-size: 15px;
        font-weight: 850;
    }


    .completion-full {
        grid-column:
            1 / -1;
    }


    /* ================================================================
       TABLE
       ================================================================ */

    .report-table-wrapper {
        overflow-x: auto;
    }


    .report-table {
        width: 100%;

        min-width: 900px;

        border-collapse: collapse;
    }


    .report-table th {
        padding:
            15px
            16px;

        border-bottom:
            1px solid
            var(--report-border-soft);

        background:
            #F7FAFD;

        color:
            #4A6076;

        text-align: left;

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        white-space: nowrap;
    }


    .report-table td {
        padding:
            18px
            16px;

        border-bottom:
            1px solid
            var(--report-border-soft);

        color:
            var(--report-body);

        font-size: 15px;

        line-height: 1.55;
    }


    .report-table tbody tr:hover {
        background:
            #FAFCFF;
    }


    .report-table tbody tr:last-child td {
        border-bottom: none;
    }


    .report-table-primary {
        display: block;

        color:
            var(--report-text);

        font-size: 16px;
        font-weight: 850;
    }


    .report-table-secondary {
        display: block;

        margin-top: 3px;

        color:
            var(--report-muted);

        font-size: 13px;
    }


    /* ================================================================
       WORK LOG CARDS
       ================================================================ */

    .report-work-log-list {
        display: grid;

        gap: 14px;
    }


    .report-work-log {
        padding:
            18px;

        border:
            1px solid
            var(--report-border);

        border-radius: 14px;

        background:
            #FBFDFF;
    }


    .report-work-log-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-bottom: 11px;
    }


    .report-work-log-date {
        color:
            var(--report-text);

        font-size: 17px;
        font-weight: 900;
    }


    .report-work-log-tasks {
        color:
            var(--report-body);

        font-size: 16px;

        line-height: 1.7;
    }


    /* ================================================================
       SIDEBAR
       ================================================================ */

    .report-sidebar-list {
        display: grid;

        gap: 12px;
    }


    .report-sidebar-item {
        padding:
            14px
            15px;

        border:
            1px solid
            var(--report-border-soft);

        border-radius: 12px;

        background:
            var(--report-soft);
    }


    .report-sidebar-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--report-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.3px;
    }


    .report-sidebar-value {
        display: block;

        color:
            var(--report-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.55;

        word-break: break-word;
    }


    /* ================================================================
       QUICK LINKS
       ================================================================ */

    .report-links {
        display: grid;

        gap: 11px;
    }


    .report-link {
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
            var(--report-border);

        border-radius: 12px;

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


    .report-link:hover {
        transform:
            translateY(-1px);

        border-color:
            #B8CADC;

        background:
            var(--report-blue-soft);
    }


    /* ================================================================
       NOTE
       ================================================================ */

    .report-note {
        padding:
            16px;

        border:
            1px solid
            #D5E4F2;

        border-radius: 13px;

        background:
            #F5FAFE;

        color:
            var(--report-body);

        font-size: 15px;

        line-height: 1.7;
    }


    .report-note strong {
        color:
            var(--report-text);
    }


    /* ================================================================
       EMPTY
       ================================================================ */

    .report-empty {
        padding:
            48px
            24px;

        text-align: center;
    }


    .report-empty-icon {
        width: 72px;
        height: 72px;

        margin:
            0
            auto
            16px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 20px;

        background:
            var(--report-blue-soft);

        color:
            var(--report-blue);

        font-size: 16px;
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
        max-width: 560px;

        margin:
            0
            auto;

        color:
            var(--report-body);

        font-size: 16px;

        line-height: 1.7;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1180px) {

        .report-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .report-layout {
            grid-template-columns:
                1fr;
        }


        .report-progress-stat-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
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


        .report-hero-actions {
            width: 100%;
        }


        .report-selector {
            flex-direction: column;

            align-items: stretch;
        }


        .report-selector-form {
            min-width: 0;

            width: 100%;
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
        .report-progress-stat-grid,
        .report-detail-grid,
        .activity-summary-grid,
        .evaluation-grid,
        .completion-grid {
            grid-template-columns:
                1fr;
        }


        .report-detail-full,
        .completion-full {
            grid-column:
                auto;
        }


        .report-panel-header,
        .report-panel-body {
            padding-left: 20px;
            padding-right: 20px;
        }


        .report-panel-heading h2 {
            font-size: 21px;
        }


        .report-progress-top,
        .evaluation-top {
            flex-direction: column;

            align-items: flex-start;
        }


        .report-progress-value {
            font-size: 34px;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Student
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
    | Student Assignments
    |--------------------------------------------------------------------------
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
                    'finalEvaluation',
                    'completedBy',
                ])
                ->latest('start_date')
                ->get();

    } else {

        $studentAssignments =
            collect();

    }


    /*
    |--------------------------------------------------------------------------
    | Requested Assignment
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
    | Selected Assignment
    |--------------------------------------------------------------------------
    */

    $selectedAssignment =
        $assignment
        ?? $displayAssignment
        ?? $requestedAssignment
        ?? $activeAssignment
        ?? $studentAssignments
            ->first(
                fn ($item) =>
                    strtolower(
                        (string) $item->status
                    ) === 'active'
            )
        ?? $studentAssignments->first();


    if ($selectedAssignment) {

        $selectedAssignment->loadMissing([
            'company',
            'supervisor',
            'attendanceRecords',
            'dailyWorkLogs',
            'finalEvaluation',
            'completedBy',
        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Attendance
    |--------------------------------------------------------------------------
    */

    $attendanceRecords =
        $selectedAssignment
            ? collect(
                $selectedAssignment
                    ->attendanceRecords
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
    | Hours
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
        $selectedAssignment
            ? (float) (
                $selectedAssignment
                    ->required_hours
                ?? 0
            )
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
                    )
                    * 100
                )
            )
            : 0;


    /*
    |--------------------------------------------------------------------------
    | Evaluation
    |--------------------------------------------------------------------------
    */

    $finalEvaluation =
        $selectedAssignment
            ? $selectedAssignment
                ->finalEvaluation
            : null;


    /*
    |--------------------------------------------------------------------------
    | Status
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
    | Student Initials
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
    | Status Classes
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

                'completed',
                'validated' =>
                    'status-completed',

                'rejected',
                'cancelled' =>
                    'status-rejected',

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
    | Recent Records
    |--------------------------------------------------------------------------
    */

    $recentAttendance =
        $attendanceRecords
            ->sortByDesc(
                fn ($record) =>
                    $record->attendance_date
                    ?? $record->created_at
            )
            ->take(7)
            ->values();


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
    | Routes
    |--------------------------------------------------------------------------
    */

    $routeExists =
        fn ($name) =>
            \Illuminate\Support\Facades\Route::has(
                $name
            );


    $reportIndexUrl =
        $routeExists(
            'student.reports.index'
        )
            ? route(
                'student.reports.index'
            )
            : url(
                '/student/reports'
            );


    $printRouteName =
        collect([
            'student.reports.print',
            'student.reports.printable',
        ])
            ->first(
                fn ($name) =>
                    $routeExists($name)
            );


    $exportRouteName =
        collect([
            'student.reports.export',
            'student.reports.csv',
            'student.reports.export.csv',
        ])
            ->first(
                fn ($name) =>
                    $routeExists($name)
            );

@endphp


<div class="student-report-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="report-hero">


        <div class="report-hero-inner">


            <div class="report-hero-copy">


                <div class="report-hero-eyebrow">


                    <span class="report-hero-dot"></span>


                    Student Portal · OJT Progress & Reporting


                </div>


                <h1>
                    My OJT Report
                </h1>


                <p class="report-hero-description">

                    Review your complete OJT progress,
                    including validated rendered hours,
                    attendance, Daily Work Logs,
                    Supervisor evaluation, placement
                    information, and completion status.

                </p>


            </div>


            <div class="report-hero-actions">


                @if ($printRouteName)


                    <a
                        href="{{ route(
                            $printRouteName,
                            $selectedAssignment
                                ? [
                                    'assignment' =>
                                        $selectedAssignment->id,
                                ]
                                : []
                        ) }}"
                        class="
                            report-hero-button
                            report-hero-button-primary
                        "
                        target="_blank"
                    >
                        Print / Save Report
                    </a>


                @endif


                @if ($exportRouteName)


                    <a
                        href="{{ route(
                            $exportRouteName,
                            $selectedAssignment
                                ? [
                                    'assignment' =>
                                        $selectedAssignment->id,
                                ]
                                : []
                        ) }}"
                        class="report-hero-button"
                    >
                        Export Report
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
                        class="report-hero-button"
                    >
                        View Assignment History
                    </a>


                @endif


            </div>


        </div>


    </section>


    {{-- ==================================================================
         ASSIGNMENT SELECTOR
         ================================================================== --}}

    @if ($studentAssignments->count() > 1)


        <section class="report-selector">


            <div>


                <span class="report-selector-title">
                    Choose an OJT Assignment
                </span>


                <span class="report-selector-description">

                    Switch between your current placement
                    and previous OJT reports.

                </span>


            </div>


            <form
                method="GET"
                action="{{ $reportIndexUrl }}"
                class="report-selector-form"
            >


                <select
                    name="assignment"
                    class="report-selector-select"
                    onchange="this.form.submit()"
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

    <section class="report-summary-grid">


        <article class="report-summary-card">


            <div class="report-summary-icon summary-blue">
                RH
            </div>


            <span class="report-summary-label">
                Required OJT Hours
            </span>


            <span class="report-summary-value">

                {{ number_format(
                    $requiredHours,
                    1
                ) }}

                <span class="report-summary-unit">
                    hrs
                </span>

            </span>


            <span class="report-summary-note">
                Training requirement for this placement.
            </span>


        </article>


        <article class="report-summary-card">


            <div class="report-summary-icon summary-green">
                VH
            </div>


            <span class="report-summary-label">
                Validated Hours
            </span>


            <span class="report-summary-value">

                {{ number_format(
                    $validatedHours,
                    1
                ) }}

                <span class="report-summary-unit">
                    hrs
                </span>

            </span>


            <span class="report-summary-note">
                Official Supervisor-validated rendered hours.
            </span>


        </article>


        <article class="report-summary-card">


            <div class="report-summary-icon summary-orange">
                RM
            </div>


            <span class="report-summary-label">
                Remaining Hours
            </span>


            <span class="report-summary-value">

                {{ number_format(
                    $remainingHours,
                    1
                ) }}

                <span class="report-summary-unit">
                    hrs
                </span>

            </span>


            <span class="report-summary-note">
                Remaining requirement based on validated time.
            </span>


        </article>


        <article class="report-summary-card">


            <div class="report-summary-icon summary-purple">
                %
            </div>


            <span class="report-summary-label">
                OJT Progress
            </span>


            <span class="report-summary-value">

                {{ $progressPercentage }}%

            </span>


            <span class="report-summary-note">
                Overall validated-hour completion percentage.
            </span>


        </article>


    </section>


    {{-- ==================================================================
         CONTENT
         ================================================================== --}}

    <div class="report-layout">


        {{-- ==============================================================
             MAIN
             ============================================================== --}}

        <main class="report-main">


            {{-- ==========================================================
                 PROGRESS
                 ========================================================== --}}

            <section class="report-panel">


                <div class="report-panel-header">


                    <div class="report-panel-heading">


                        <div class="report-panel-icon panel-teal">
                            HR
                        </div>


                        <div>


                            <h2>
                                OJT Progress Overview
                            </h2>


                            <p>
                                Validated hours and record completion
                            </p>


                        </div>


                    </div>


                </div>


                <div class="report-panel-body">


                    @if ($selectedAssignment)


                        <div class="report-progress-card">


                            <div class="report-progress-top">


                                <div>


                                    <span class="report-progress-label">
                                        Official Validated Hours
                                    </span>


                                    <div class="report-progress-value">

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


                                <div class="report-progress-percent">

                                    {{ $progressPercentage }}%

                                </div>


                            </div>


                            <div class="report-progress-track">


                                <div
                                    class="report-progress-fill"
                                    style="
                                        width:
                                        {{ $progressPercentage }}%;
                                    "
                                ></div>


                            </div>


                            <div class="report-progress-note">

                                The official OJT progress on this report
                                counts only attendance records that have
                                been validated by the assigned Supervisor.

                            </div>


                            <div class="report-progress-stat-grid">


                                <div class="report-progress-stat">


                                    <span class="report-progress-stat-label">
                                        Attendance Records
                                    </span>


                                    <span class="report-progress-stat-value">

                                        {{ $attendanceRecords->count() }}

                                    </span>


                                </div>


                                <div class="report-progress-stat">


                                    <span class="report-progress-stat-label">
                                        Validated Days
                                    </span>


                                    <span class="report-progress-stat-value">

                                        {{ $validatedAttendance->count() }}

                                    </span>


                                </div>


                                <div class="report-progress-stat">


                                    <span class="report-progress-stat-label">
                                        Work Logs
                                    </span>


                                    <span class="report-progress-stat-value">

                                        {{ $workLogs->count() }}

                                    </span>


                                </div>


                                <div class="report-progress-stat">


                                    <span class="report-progress-stat-label">
                                        Validated Logs
                                    </span>


                                    <span class="report-progress-stat-value">

                                        {{ $validatedWorkLogs->count() }}

                                    </span>


                                </div>


                            </div>


                        </div>


                    @else


                        <div class="report-empty">


                            <div class="report-empty-icon">
                                RP
                            </div>


                            <h3>
                                No OJT Report Available Yet
                            </h3>


                            <p>

                                Your OJT report will appear
                                after an assignment has been
                                created for your Student Profile.

                            </p>


                        </div>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 PLACEMENT
                 ========================================================== --}}

            <section class="report-panel">


                <div class="report-panel-header">


                    <div class="report-panel-heading">


                        <div class="report-panel-icon panel-blue">
                            OJ
                        </div>


                        <div>


                            <h2>
                                Placement Information
                            </h2>


                            <p>
                                Student, company, Supervisor, and training period
                            </p>


                        </div>


                    </div>


                </div>


                <div class="report-panel-body">


                    @if ($selectedAssignment)


                        <div class="report-detail-grid">


                            <div class="report-detail-item">


                                <span class="report-detail-label">
                                    Student Name
                                </span>


                                <span class="report-detail-value">

                                    {{ $studentName }}

                                </span>


                                <span class="report-detail-secondary">

                                    {{ $studentProfile?->student_number
                                        ?? 'Student number unavailable'
                                    }}

                                </span>


                            </div>


                            <div class="report-detail-item">


                                <span class="report-detail-label">
                                    Academic Program
                                </span>


                                <span class="report-detail-value">

                                    {{ $studentProfile?->program
                                        ?? 'Not provided'
                                    }}

                                </span>


                                <span class="report-detail-secondary">

                                    {{ $studentProfile?->year_level
                                        ?? 'Year level unavailable'
                                    }}

                                    @if (
                                        filled(
                                            $studentProfile?->section
                                        )
                                    )

                                        · Section
                                        {{ $studentProfile->section }}

                                    @endif

                                </span>


                            </div>


                            <div
                                class="
                                    report-detail-item
                                    report-detail-full
                                "
                            >


                                <span class="report-detail-label">
                                    OJT Company
                                </span>


                                <span class="report-detail-value">

                                    {{ $selectedAssignment
                                        ->company
                                        ?->name
                                        ?? 'Company unavailable'
                                    }}

                                </span>


                                <span class="report-detail-secondary">

                                    {{ $selectedAssignment
                                        ->company
                                        ?->address
                                        ?? 'Company address not provided'
                                    }}

                                </span>


                            </div>


                            <div class="report-detail-item">


                                <span class="report-detail-label">
                                    Assigned Supervisor
                                </span>


                                <span class="report-detail-value">

                                    {{ $selectedAssignment
                                        ->supervisor
                                        ?->name
                                        ?? 'Not assigned'
                                    }}

                                </span>


                                <span class="report-detail-secondary">

                                    {{ $selectedAssignment
                                        ->supervisor
                                        ?->email
                                        ?? 'Email unavailable'
                                    }}

                                </span>


                            </div>


                            <div class="report-detail-item">


                                <span class="report-detail-label">
                                    Assignment Status
                                </span>


                                <span class="report-detail-value">


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


                                </span>


                            </div>


                            <div class="report-detail-item">


                                <span class="report-detail-label">
                                    Start Date
                                </span>


                                <span class="report-detail-value">

                                    {{ $formatDate(
                                        $selectedAssignment->start_date
                                    ) }}

                                </span>


                            </div>


                            <div class="report-detail-item">


                                <span class="report-detail-label">
                                    End Date
                                </span>


                                <span class="report-detail-value">

                                    {{ $formatDate(
                                        $selectedAssignment->end_date
                                    ) }}

                                </span>


                            </div>


                        </div>


                    @else


                        <div class="report-empty">


                            <div class="report-empty-icon">
                                OJ
                            </div>


                            <h3>
                                No Placement Information
                            </h3>


                            <p>
                                No OJT Assignment is currently available.
                            </p>


                        </div>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 ACTIVITY SUMMARY
                 ========================================================== --}}

            <section class="report-panel">


                <div class="report-panel-header">


                    <div class="report-panel-heading">


                        <div class="report-panel-icon panel-green">
                            AC
                        </div>


                        <div>


                            <h2>
                                OJT Activity Summary
                            </h2>


                            <p>
                                Attendance and Daily Work Log validation
                            </p>


                        </div>


                    </div>


                </div>


                <div class="report-panel-body">


                    <div class="activity-summary-grid">


                        <div class="activity-summary-card">


                            <div class="activity-summary-heading">


                                <div
                                    class="
                                        activity-summary-icon
                                        summary-green
                                    "
                                >
                                    AT
                                </div>


                                <span class="activity-summary-title">
                                    Attendance
                                </span>


                            </div>


                            <div class="activity-stat-list">


                                <div class="activity-stat-row">


                                    <span class="activity-stat-label">
                                        Total Records
                                    </span>


                                    <span class="activity-stat-value">

                                        {{ $attendanceRecords->count() }}

                                    </span>


                                </div>


                                <div class="activity-stat-row">


                                    <span class="activity-stat-label">
                                        Validated
                                    </span>


                                    <span class="activity-stat-value">

                                        {{ $validatedAttendance->count() }}

                                    </span>


                                </div>


                                <div class="activity-stat-row">


                                    <span class="activity-stat-label">
                                        Pending
                                    </span>


                                    <span class="activity-stat-value">

                                        {{ $pendingAttendance->count() }}

                                    </span>


                                </div>


                                <div class="activity-stat-row">


                                    <span class="activity-stat-label">
                                        Rejected
                                    </span>


                                    <span class="activity-stat-value">

                                        {{ $rejectedAttendance->count() }}

                                    </span>


                                </div>


                            </div>


                        </div>


                        <div class="activity-summary-card">


                            <div class="activity-summary-heading">


                                <div
                                    class="
                                        activity-summary-icon
                                        summary-purple
                                    "
                                >
                                    WL
                                </div>


                                <span class="activity-summary-title">
                                    Daily Work Logs
                                </span>


                            </div>


                            <div class="activity-stat-list">


                                <div class="activity-stat-row">


                                    <span class="activity-stat-label">
                                        Total Logs
                                    </span>


                                    <span class="activity-stat-value">

                                        {{ $workLogs->count() }}

                                    </span>


                                </div>


                                <div class="activity-stat-row">


                                    <span class="activity-stat-label">
                                        Validated
                                    </span>


                                    <span class="activity-stat-value">

                                        {{ $validatedWorkLogs->count() }}

                                    </span>


                                </div>


                                <div class="activity-stat-row">


                                    <span class="activity-stat-label">
                                        Pending
                                    </span>


                                    <span class="activity-stat-value">

                                        {{ $pendingWorkLogs->count() }}

                                    </span>


                                </div>


                                <div class="activity-stat-row">


                                    <span class="activity-stat-label">
                                        Rejected
                                    </span>


                                    <span class="activity-stat-value">

                                        {{ $rejectedWorkLogs->count() }}

                                    </span>


                                </div>


                            </div>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 EVALUATION & COMPLETION
                 ========================================================== --}}

            <section class="report-panel">


                <div class="report-panel-header">


                    <div class="report-panel-heading">


                        <div class="report-panel-icon panel-purple">
                            EV
                        </div>


                        <div>


                            <h2>
                                Evaluation & Completion
                            </h2>


                            <p>
                                Supervisor recommendation and formal OJT status
                            </p>


                        </div>


                    </div>


                </div>


                <div class="report-panel-body">


                    <div class="evaluation-card">


                        <div class="evaluation-top">


                            <div>


                                <span class="evaluation-title">
                                    Supervisor Final Evaluation
                                </span>


                                <div class="evaluation-description">


                                    @if ($finalEvaluation)

                                        Your assigned Supervisor has
                                        submitted the final evaluation
                                        for this OJT placement.

                                    @else

                                        A final Supervisor evaluation
                                        has not yet been submitted
                                        for this placement.

                                    @endif


                                </div>


                            </div>


                            @if ($finalEvaluation)


                                <span class="evaluation-badge">

                                    {{ ucwords(
                                        str_replace(
                                            '_',
                                            ' ',
                                            (string)
                                            $finalEvaluation
                                                ->recommendation
                                        )
                                    ) }}

                                </span>


                            @endif


                        </div>


                        @if ($finalEvaluation)


                            <div class="evaluation-grid">


                                <div class="evaluation-item">


                                    <span class="evaluation-item-label">
                                        Recommendation
                                    </span>


                                    <span class="evaluation-item-value">

                                        {{ ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                (string)
                                                $finalEvaluation
                                                    ->recommendation
                                            )
                                        ) }}

                                    </span>


                                </div>


                                <div class="evaluation-item">


                                    <span class="evaluation-item-label">
                                        Evaluated On
                                    </span>


                                    <span class="evaluation-item-value">

                                        {{ $formatDate(
                                            $finalEvaluation
                                                ->evaluated_at
                                        ) }}

                                    </span>


                                </div>


                            </div>


                        @endif


                    </div>


                    @if (
                        $selectedAssignment
                        &&
                        $assignmentStatus === 'completed'
                    )


                        <div class="completion-card">


                            <span class="completion-title">
                                Formal OJT Completion
                            </span>


                            <div class="completion-description">

                                This placement has been formally
                                completed and is now preserved
                                as part of your OJT history.

                            </div>


                            <div class="completion-grid">


                                <div class="completion-item">


                                    <span class="completion-item-label">
                                        Completed Date
                                    </span>


                                    <span class="completion-item-value">

                                        {{ $formatDate(
                                            $selectedAssignment
                                                ->completed_at
                                        ) }}

                                    </span>


                                </div>


                                <div class="completion-item">


                                    <span class="completion-item-label">
                                        Completed By
                                    </span>


                                    <span class="completion-item-value">

                                        {{ $selectedAssignment
                                            ->completedBy
                                            ?->name
                                            ?? 'Administrator'
                                        }}

                                    </span>


                                </div>


                                @if (
                                    filled(
                                        $selectedAssignment
                                            ->completion_remarks
                                    )
                                )


                                    <div
                                        class="
                                            completion-item
                                            completion-full
                                        "
                                    >


                                        <span class="completion-item-label">
                                            Completion Remarks
                                        </span>


                                        <span class="completion-item-value">

                                            {{ $selectedAssignment
                                                ->completion_remarks
                                            }}

                                        </span>


                                    </div>


                                @endif


                            </div>


                        </div>


                    @else


                        <div class="completion-card">


                            <span class="completion-title">
                                OJT Completion Status
                            </span>


                            <div class="completion-description">

                                This assignment has not yet been
                                formally completed. Completion remains
                                subject to the system's required
                                validated hours, Work Log status,
                                final evaluation, and Administrator
                                completion workflow.

                            </div>


                        </div>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 RECENT ATTENDANCE
                 ========================================================== --}}

            <section class="report-panel">


                <div class="report-panel-header">


                    <div class="report-panel-heading">


                        <div class="report-panel-icon panel-green">
                            AT
                        </div>


                        <div>


                            <h2>
                                Recent Attendance
                            </h2>


                            <p>
                                Latest Time In, Time Out, and rendered-hour records
                            </p>


                        </div>


                    </div>


                </div>


                @if ($recentAttendance->isNotEmpty())


                    <div class="report-table-wrapper">


                        <table class="report-table">


                            <thead>


                                <tr>

                                    <th>Date</th>

                                    <th>Time In</th>

                                    <th>Time Out</th>

                                    <th>Rendered Hours</th>

                                    <th>Status</th>

                                </tr>


                            </thead>


                            <tbody>


                                @foreach ($recentAttendance as $record)


                                    @php

                                        $recordHours =
                                            (
                                                (int) (
                                                    $record
                                                        ->rendered_minutes
                                                    ?? 0
                                                )
                                            )
                                            / 60;

                                    @endphp


                                    <tr>


                                        <td>


                                            <span class="report-table-primary">

                                                {{ $formatDate(
                                                    $record
                                                        ->attendance_date
                                                ) }}

                                            </span>


                                            <span class="report-table-secondary">

                                                Attendance #{{ $record->id }}

                                            </span>


                                        </td>


                                        <td>


                                            <span class="report-table-primary">

                                                {{ $formatTime(
                                                    $record->time_in
                                                ) }}

                                            </span>


                                        </td>


                                        <td>


                                            <span class="report-table-primary">

                                                {{ $formatTime(
                                                    $record->time_out
                                                ) }}

                                            </span>


                                        </td>


                                        <td>


                                            <span class="report-table-primary">

                                                {{ number_format(
                                                    $recordHours,
                                                    1
                                                ) }}
                                                hrs

                                            </span>


                                        </td>


                                        <td>


                                            <span
                                                class="
                                                    report-status
                                                    {{ $statusClass(
                                                        $record->status
                                                    ) }}
                                                "
                                            >

                                                {{ $statusLabel(
                                                    $record->status
                                                ) }}

                                            </span>


                                        </td>


                                    </tr>


                                @endforeach


                            </tbody>


                        </table>


                    </div>


                @else


                    <div class="report-empty">


                        <div class="report-empty-icon">
                            AT
                        </div>


                        <h3>
                            No Attendance Records Yet
                        </h3>


                        <p>
                            Attendance activity will appear here
                            after you begin recording OJT attendance.
                        </p>


                    </div>


                @endif


            </section>


            {{-- ==========================================================
                 RECENT WORK LOGS
                 ========================================================== --}}

            <section class="report-panel">


                <div class="report-panel-header">


                    <div class="report-panel-heading">


                        <div class="report-panel-icon panel-purple">
                            WL
                        </div>


                        <div>


                            <h2>
                                Recent Daily Work Logs
                            </h2>


                            <p>
                                Latest documented OJT tasks and activities
                            </p>


                        </div>


                    </div>


                </div>


                <div class="report-panel-body">


                    @if ($recentWorkLogs->isNotEmpty())


                        <div class="report-work-log-list">


                            @foreach ($recentWorkLogs as $log)


                                <article class="report-work-log">


                                    <div class="report-work-log-top">


                                        <span class="report-work-log-date">

                                            {{ $formatDate(
                                                $log->submitted_at
                                                ?? $log->created_at
                                            ) }}

                                        </span>


                                        <span
                                            class="
                                                report-status
                                                {{ $statusClass(
                                                    $log->status
                                                ) }}
                                            "
                                        >

                                            {{ $statusLabel(
                                                $log->status
                                            ) }}

                                        </span>


                                    </div>


                                    <div class="report-work-log-tasks">

                                        {{ \Illuminate\Support\Str::limit(
                                            $log->tasks
                                                ?: 'No task description provided.',
                                            240
                                        ) }}

                                    </div>


                                </article>


                            @endforeach


                        </div>


                    @else


                        <div class="report-empty">


                            <div class="report-empty-icon">
                                WL
                            </div>


                            <h3>
                                No Daily Work Logs Yet
                            </h3>


                            <p>
                                Your documented OJT tasks and
                                activities will appear here
                                after Work Logs are submitted.
                            </p>


                        </div>


                    @endif


                </div>


            </section>


        </main>


        {{-- ==============================================================
             SIDEBAR
             ============================================================== --}}

        <aside class="report-sidebar">


            {{-- ==========================================================
                 STUDENT
                 ========================================================== --}}

            <section class="report-panel">


                <div class="report-panel-header">


                    <div class="report-panel-heading">


                        <div class="report-panel-icon panel-blue">
                            ID
                        </div>


                        <div>


                            <h2>
                                Student Record
                            </h2>


                            <p>
                                Report owner information
                            </p>


                        </div>


                    </div>


                </div>


                <div class="report-panel-body">


                    <div class="report-sidebar-list">


                        <div class="report-sidebar-item">


                            <span class="report-sidebar-label">
                                Student Name
                            </span>


                            <span class="report-sidebar-value">

                                {{ $studentName }}

                            </span>


                        </div>


                        <div class="report-sidebar-item">


                            <span class="report-sidebar-label">
                                Student Number
                            </span>


                            <span class="report-sidebar-value">

                                {{ $studentProfile?->student_number
                                    ?? 'Not provided'
                                }}

                            </span>


                        </div>


                        <div class="report-sidebar-item">


                            <span class="report-sidebar-label">
                                Program
                            </span>


                            <span class="report-sidebar-value">

                                {{ $studentProfile?->program
                                    ?? 'Not provided'
                                }}

                            </span>


                        </div>


                        <div class="report-sidebar-item">


                            <span class="report-sidebar-label">
                                Year / Section
                            </span>


                            <span class="report-sidebar-value">

                                {{ $studentProfile?->year_level
                                    ?? 'Not provided'
                                }}

                                @if (
                                    filled(
                                        $studentProfile?->section
                                    )
                                )

                                    · {{ $studentProfile->section }}

                                @endif

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 REPORT STATUS
                 ========================================================== --}}

            <section class="report-panel">


                <div class="report-panel-header">


                    <div class="report-panel-heading">


                        <div class="report-panel-icon panel-teal">
                            RP
                        </div>


                        <div>


                            <h2>
                                Report Status
                            </h2>


                            <p>
                                Current OJT record overview
                            </p>


                        </div>


                    </div>


                </div>


                <div class="report-panel-body">


                    <div class="report-sidebar-list">


                        <div class="report-sidebar-item">


                            <span class="report-sidebar-label">
                                Assignment Status
                            </span>


                            <span class="report-sidebar-value">

                                {{ $selectedAssignment
                                    ? $statusLabel(
                                        $assignmentStatus
                                    )
                                    : 'No assignment'
                                }}

                            </span>


                        </div>


                        <div class="report-sidebar-item">


                            <span class="report-sidebar-label">
                                Hour Progress
                            </span>


                            <span class="report-sidebar-value">

                                {{ $progressPercentage }}%

                            </span>


                        </div>


                        <div class="report-sidebar-item">


                            <span class="report-sidebar-label">
                                Evaluation
                            </span>


                            <span class="report-sidebar-value">

                                {{ $finalEvaluation
                                    ? ucwords(
                                        str_replace(
                                            '_',
                                            ' ',
                                            (string)
                                            $finalEvaluation
                                                ->recommendation
                                        )
                                    )
                                    : 'Not submitted'
                                }}

                            </span>


                        </div>


                        <div class="report-sidebar-item">


                            <span class="report-sidebar-label">
                                Formal Completion
                            </span>


                            <span class="report-sidebar-value">

                                {{ $assignmentStatus === 'completed'
                                    ? 'Completed'
                                    : 'Not yet completed'
                                }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 RELATED PAGES
                 ========================================================== --}}

            <section class="report-panel">


                <div class="report-panel-header">


                    <div class="report-panel-heading">


                        <div class="report-panel-icon panel-purple">
                            GO
                        </div>


                        <div>


                            <h2>
                                Related OJT Pages
                            </h2>


                            <p>
                                Review the records behind this report
                            </p>


                        </div>


                    </div>


                </div>


                <div class="report-panel-body">


                    <div class="report-links">


                        @if (
                            $routeExists(
                                'student.timesheets.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.timesheets.index',
                                    $selectedAssignment
                                        ? [
                                            'assignment' =>
                                                $selectedAssignment->id,
                                        ]
                                        : []
                                ) }}"
                                class="report-link"
                            >

                                <span>
                                    My Timesheet
                                </span>

                                <span>→</span>

                            </a>


                        @endif


                        @if (
                            $routeExists(
                                'student.attendance.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.attendance.index',
                                    $selectedAssignment
                                        ? [
                                            'assignment' =>
                                                $selectedAssignment->id,
                                        ]
                                        : []
                                ) }}"
                                class="report-link"
                            >

                                <span>
                                    Attendance Records
                                </span>

                                <span>→</span>

                            </a>


                        @endif


                        @if (
                            $routeExists(
                                'student.work-logs.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.work-logs.index',
                                    $selectedAssignment
                                        ? [
                                            'assignment' =>
                                                $selectedAssignment->id,
                                        ]
                                        : []
                                ) }}"
                                class="report-link"
                            >

                                <span>
                                    Daily Work Logs
                                </span>

                                <span>→</span>

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
                                class="report-link"
                            >

                                <span>
                                    Assignment History
                                </span>

                                <span>→</span>

                            </a>


                        @endif


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 REPORT EXPLANATION
                 ========================================================== --}}

            <section class="report-panel">


                <div class="report-panel-header">


                    <div class="report-panel-heading">


                        <div class="report-panel-icon panel-orange">
                            i
                        </div>


                        <div>


                            <h2>
                                About This Report
                            </h2>


                            <p>
                                How the displayed information is interpreted
                            </p>


                        </div>


                    </div>


                </div>


                <div class="report-panel-body">


                    <div class="report-note">

                        <strong>
                            Validated hours are the official hours.
                        </strong>

                        Attendance can contain calculated rendered
                        minutes before approval, but only
                        Supervisor-validated attendance contributes
                        to the official hour progress displayed
                        in this report.

                    </div>


                </div>


            </section>


        </aside>


    </div>


</div>


@endsection