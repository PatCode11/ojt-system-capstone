@extends('layouts.app')


@section('title', 'Supervisor Dashboard | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC - SUPERVISOR DASHBOARD
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --sv-navy: #183B6B;
        --sv-navy-dark: #102A4A;
        --sv-navy-deep: #0B223D;

        --sv-blue: #2563EB;
        --sv-blue-soft: #EAF2FF;

        --sv-teal: #0F766E;
        --sv-teal-light: #14B8A6;
        --sv-teal-soft: #E7F7F5;

        --sv-green: #15803D;
        --sv-green-soft: #EAF8EF;

        --sv-orange: #B45309;
        --sv-orange-soft: #FFF5E6;

        --sv-red: #B42318;
        --sv-red-soft: #FFF0EE;

        --sv-purple: #6D4FC2;
        --sv-purple-soft: #F2EEFF;

        --sv-gray: #475569;
        --sv-gray-soft: #F1F5F9;

        --sv-text: #102A4A;
        --sv-body: #405872;
        --sv-muted: #64778C;

        --sv-white: #FFFFFF;
        --sv-soft: #F8FBFE;

        --sv-border: #D8E3EE;
        --sv-border-soft: #E7EDF4;

        --sv-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --sv-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --sv-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .supervisor-dashboard-page {
        width: 100%;

        color:
            var(--sv-text);

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

    .supervisor-dashboard-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 30px;

        padding:
            42px
            44px;

        border-radius: 28px;

        background:
            radial-gradient(
                circle at 88% 15%,
                rgba(45, 212, 191, 0.24),
                transparent 25%
            ),
            radial-gradient(
                circle at 69% 88%,
                rgba(96, 165, 250, 0.13),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 52%,
                #17666B 100%
            );

        box-shadow:
            var(--sv-shadow-large);
    }


    .supervisor-dashboard-hero::before {
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


    .supervisor-dashboard-hero::after {
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


    .supervisor-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 36px;
    }


    .supervisor-hero-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 23px;
    }


    .supervisor-hero-avatar {
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


    .supervisor-hero-copy {
        min-width: 0;

        max-width: 720px;
    }


    .supervisor-hero-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 9px;

        color:
            rgba(255, 255, 255, 0.84);

        font-size: 14px;
        font-weight: 800;
    }


    .supervisor-hero-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background:
            #2DD4BF;

        box-shadow:
            0 0 0 5px
            rgba(45, 212, 191, 0.15);
    }


    .supervisor-dashboard-hero h1 {
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


    .supervisor-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.83);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO WORKLOAD CARD
       ================================================================ */

    .supervisor-hero-workload {
        width: 320px;

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


    .supervisor-workload-label {
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


    .supervisor-workload-value {
        display: block;

        color:
            #FFFFFF;

        font-size: 34px;
        font-weight: 900;

        line-height: 1.15;
    }


    .supervisor-workload-description {
        display: block;

        margin-top: 7px;

        color:
            rgba(255, 255, 255, 0.80);

        font-size: 15px;

        line-height: 1.55;
    }


    .supervisor-workload-footer {
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
            rgba(255, 255, 255, 0.80);

        font-size: 13px;
        font-weight: 750;
    }


    /* ================================================================
       REVIEW NOTICE
       ================================================================ */

    .supervisor-review-notice {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 26px;

        padding:
            20px
            22px;

        border:
            1px solid
            #F0D7B1;

        border-radius: 17px;

        background:
            linear-gradient(
                135deg,
                #FFFDF9 0%,
                #FFF7E9 100%
            );

        box-shadow:
            var(--sv-shadow);
    }


    .supervisor-review-notice-left {
        display: flex;
        align-items: flex-start;

        gap: 14px;
    }


    .supervisor-review-notice-icon {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--sv-orange-soft);

        color:
            var(--sv-orange);

        font-size: 18px;
        font-weight: 900;
    }


    .supervisor-review-notice strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--sv-text);

        font-size: 17px;
        font-weight: 850;
    }


    .supervisor-review-notice p {
        margin: 0;

        color:
            var(--sv-body);

        font-size: 15px;

        line-height: 1.6;
    }


    .supervisor-review-button {
        min-height: 48px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            17px;

        border-radius: 12px;

        background:
            var(--sv-orange);

        color:
            #FFFFFF;

        text-decoration: none;

        font-size: 14px;
        font-weight: 850;

        transition:
            var(--sv-transition);
    }


    .supervisor-review-button:hover {
        transform:
            translateY(-1px);

        background:
            #92400E;
    }


    /* ================================================================
       SUMMARY CARDS
       ================================================================ */

    .supervisor-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 19px;

        margin-bottom: 29px;
    }


    .supervisor-summary-card {
        padding:
            24px;

        border:
            1px solid
            var(--sv-border);

        border-radius: 20px;

        background:
            var(--sv-white);

        box-shadow:
            var(--sv-shadow);

        transition:
            var(--sv-transition);
    }


    .supervisor-summary-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            0 18px 38px
            rgba(15, 42, 74, 0.10);
    }


    .supervisor-summary-icon {
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
            var(--sv-teal-soft);

        color:
            var(--sv-teal);
    }


    .summary-orange {
        background:
            var(--sv-orange-soft);

        color:
            var(--sv-orange);
    }


    .summary-purple {
        background:
            var(--sv-purple-soft);

        color:
            var(--sv-purple);
    }


    .summary-green {
        background:
            var(--sv-green-soft);

        color:
            var(--sv-green);
    }


    .supervisor-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--sv-body);

        font-size: 15px;
        font-weight: 750;
    }


    .supervisor-summary-value {
        display: block;

        color:
            var(--sv-text);

        font-size: 32px;
        font-weight: 900;

        line-height: 1.15;
    }


    .supervisor-summary-note {
        display: block;

        margin-top: 9px;

        color:
            var(--sv-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       MAIN LAYOUT
       ================================================================ */

    .supervisor-dashboard-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1.36fr)
            minmax(350px, 0.64fr);

        gap: 23px;

        align-items: start;
    }


    .supervisor-dashboard-main,
    .supervisor-dashboard-sidebar {
        display: grid;

        gap: 23px;
    }


    /* ================================================================
       PANEL
       ================================================================ */

    .supervisor-panel {
        overflow: hidden;

        border:
            1px solid
            var(--sv-border);

        border-radius: 20px;

        background:
            var(--sv-white);

        box-shadow:
            var(--sv-shadow);
    }


    .supervisor-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            24px
            26px;

        border-bottom:
            1px solid
            var(--sv-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .supervisor-panel-heading {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    .supervisor-panel-icon {
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


    .panel-teal {
        background:
            var(--sv-teal-soft);

        color:
            var(--sv-teal);
    }


    .panel-blue {
        background:
            var(--sv-blue-soft);

        color:
            var(--sv-blue);
    }


    .panel-orange {
        background:
            var(--sv-orange-soft);

        color:
            var(--sv-orange);
    }


    .panel-purple {
        background:
            var(--sv-purple-soft);

        color:
            var(--sv-purple);
    }


    .panel-green {
        background:
            var(--sv-green-soft);

        color:
            var(--sv-green);
    }


    .supervisor-panel-heading h2 {
        margin:
            0
            0
            4px;

        color:
            var(--sv-text);

        font-size: 23px;
        font-weight: 850;

        line-height: 1.3;
    }


    .supervisor-panel-heading p {
        margin: 0;

        color:
            var(--sv-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .supervisor-panel-body {
        padding:
            26px;
    }


    .supervisor-panel-link {
        color:
            var(--sv-navy);

        text-decoration: none;

        font-size: 14px;
        font-weight: 850;

        white-space: nowrap;
    }


    .supervisor-panel-link:hover {
        text-decoration: underline;
    }


    /* ================================================================
       REVIEW QUEUE
       ================================================================ */

    .review-queue-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 15px;
    }


    .review-queue-card {
        padding:
            20px;

        border:
            1px solid
            var(--sv-border);

        border-radius: 16px;

        background:
            #FBFDFF;
    }


    .review-queue-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 14px;

        margin-bottom: 15px;
    }


    .review-queue-heading {
        display: flex;
        align-items: center;

        gap: 11px;
    }


    .review-queue-icon {
        width: 43px;
        height: 43px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        font-size: 13px;
        font-weight: 900;
    }


    .review-queue-title {
        color:
            var(--sv-text);

        font-size: 17px;
        font-weight: 900;
    }


    .review-queue-count {
        color:
            var(--sv-orange);

        font-size: 27px;
        font-weight: 900;
    }


    .review-list {
        display: grid;

        gap: 10px;
    }


    .review-item {
        padding:
            13px
            14px;

        border:
            1px solid
            var(--sv-border-soft);

        border-radius: 11px;

        background:
            #FFFFFF;
    }


    .review-item-name {
        display: block;

        margin-bottom: 3px;

        color:
            var(--sv-text);

        font-size: 15px;
        font-weight: 850;
    }


    .review-item-meta {
        color:
            var(--sv-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .review-empty {
        padding:
            17px;

        border:
            1px dashed
            #C8D6E3;

        border-radius: 11px;

        color:
            var(--sv-body);

        font-size: 14px;

        line-height: 1.6;

        text-align: center;
    }


    /* ================================================================
       STUDENT PROGRESS
       ================================================================ */

    .supervised-student-list {
        display: grid;

        gap: 17px;
    }


    .supervised-student-card {
        overflow: hidden;

        border:
            1px solid
            var(--sv-border);

        border-radius: 17px;

        background:
            #FFFFFF;

        transition:
            var(--sv-transition);
    }


    .supervised-student-card:hover {
        transform:
            translateY(-2px);

        border-color:
            #BDD0E1;

        box-shadow:
            0 14px 30px
            rgba(15, 42, 74, 0.07);
    }


    .supervised-student-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            19px
            20px;

        border-bottom:
            1px solid
            var(--sv-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .supervised-student-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 14px;
    }


    .supervised-student-avatar {
        width: 51px;
        height: 51px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background:
            var(--sv-teal-soft);

        color:
            var(--sv-teal);

        font-size: 15px;
        font-weight: 900;
    }


    .supervised-student-name {
        display: block;

        margin-bottom: 3px;

        color:
            var(--sv-text);

        font-size: 18px;
        font-weight: 900;

        line-height: 1.4;
    }


    .supervised-student-meta {
        color:
            var(--sv-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       STATUS
       ================================================================ */

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

        white-space: nowrap;
    }


    .supervisor-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .status-active {
        background:
            var(--sv-green-soft);

        color:
            var(--sv-green);
    }


    .status-active::before {
        background:
            #22C55E;
    }


    .status-pending {
        background:
            var(--sv-orange-soft);

        color:
            var(--sv-orange);
    }


    .status-pending::before {
        background:
            #F59E0B;
    }


    .status-completed,
    .status-validated {
        background:
            var(--sv-blue-soft);

        color:
            var(--sv-blue);
    }


    .status-completed::before,
    .status-validated::before {
        background:
            #3B82F6;
    }


    .status-rejected,
    .status-cancelled {
        background:
            var(--sv-red-soft);

        color:
            var(--sv-red);
    }


    .status-rejected::before,
    .status-cancelled::before {
        background:
            #EF4444;
    }


    .status-default {
        background:
            var(--sv-gray-soft);

        color:
            var(--sv-gray);
    }


    .status-default::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       STUDENT BODY
       ================================================================ */

    .supervised-student-body {
        padding:
            20px;
    }


    .supervised-student-stat-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 11px;

        margin-bottom: 16px;
    }


    .supervised-student-stat {
        padding:
            13px;

        border:
            1px solid
            var(--sv-border-soft);

        border-radius: 11px;

        background:
            var(--sv-soft);
    }


    .supervised-student-stat-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--sv-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .supervised-student-stat-value {
        display: block;

        color:
            var(--sv-text);

        font-size: 17px;
        font-weight: 900;
    }


    /* ================================================================
       PROGRESS
       ================================================================ */

    .student-progress-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-bottom: 9px;
    }


    .student-progress-copy {
        color:
            var(--sv-body);

        font-size: 14px;
        font-weight: 750;
    }


    .student-progress-percentage {
        color:
            var(--sv-teal);

        font-size: 17px;
        font-weight: 900;
    }


    .student-progress-track {
        width: 100%;
        height: 10px;

        overflow: hidden;

        border-radius: 999px;

        background:
            #DCE8EA;
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


    /* ================================================================
       QUICK ACTIONS
       ================================================================ */

    .supervisor-quick-actions {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 13px;
    }


    .supervisor-quick-action {
        min-height: 132px;

        display: flex;
        flex-direction: column;
        justify-content: space-between;

        gap: 14px;

        padding:
            17px;

        border:
            1px solid
            var(--sv-border);

        border-radius: 15px;

        background:
            #FBFDFF;

        color:
            var(--sv-text);

        text-decoration: none;

        transition:
            var(--sv-transition);
    }


    .supervisor-quick-action:hover {
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


    .supervisor-action-icon {
        width: 42px;
        height: 42px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 11px;

        font-size: 13px;
        font-weight: 900;
    }


    .action-teal {
        background:
            var(--sv-teal-soft);

        color:
            var(--sv-teal);
    }


    .action-purple {
        background:
            var(--sv-purple-soft);

        color:
            var(--sv-purple);
    }


    .action-orange {
        background:
            var(--sv-orange-soft);

        color:
            var(--sv-orange);
    }


    .action-blue {
        background:
            var(--sv-blue-soft);

        color:
            var(--sv-blue);
    }


    .supervisor-action-title {
        display: block;

        color:
            var(--sv-text);

        font-size: 16px;
        font-weight: 850;
    }


    .supervisor-action-description {
        display: block;

        margin-top: 4px;

        color:
            var(--sv-muted);

        font-size: 14px;

        line-height: 1.5;
    }


    /* ================================================================
       SIDEBAR LIST
       ================================================================ */

    .supervisor-sidebar-list {
        display: grid;

        gap: 12px;
    }


    .supervisor-sidebar-item {
        padding:
            14px
            15px;

        border:
            1px solid
            var(--sv-border-soft);

        border-radius: 12px;

        background:
            var(--sv-soft);
    }


    .supervisor-sidebar-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--sv-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.3px;
    }


    .supervisor-sidebar-value {
        display: block;

        color:
            var(--sv-text);

        font-size: 17px;
        font-weight: 850;

        line-height: 1.55;
    }


    /* ================================================================
       EVALUATION STATUS
       ================================================================ */

    .evaluation-list {
        display: grid;

        gap: 11px;
    }


    .evaluation-row {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        padding:
            14px;

        border:
            1px solid
            var(--sv-border-soft);

        border-radius: 12px;

        background:
            #FBFCFE;
    }


    .evaluation-row-label {
        color:
            var(--sv-text);

        font-size: 15px;
        font-weight: 800;
    }


    .evaluation-row-value {
        color:
            var(--sv-purple);

        font-size: 17px;
        font-weight: 900;
    }


    /* ================================================================
       GUIDE
       ================================================================ */

    .supervisor-guide {
        display: grid;

        gap: 15px;
    }


    .supervisor-guide-item {
        display: flex;
        align-items: flex-start;

        gap: 12px;
    }


    .supervisor-guide-number {
        width: 36px;
        height: 36px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background:
            var(--sv-teal-soft);

        color:
            var(--sv-teal);

        font-size: 13px;
        font-weight: 900;
    }


    .supervisor-guide-title {
        display: block;

        margin-bottom: 3px;

        color:
            var(--sv-text);

        font-size: 15px;
        font-weight: 850;
    }


    .supervisor-guide-description {
        color:
            var(--sv-body);

        font-size: 14px;

        line-height: 1.6;
    }


    /* ================================================================
       INFO NOTE
       ================================================================ */

    .supervisor-info-note {
        padding:
            16px;

        border:
            1px solid
            #CEE3DF;

        border-radius: 13px;

        background:
            #F3FBF9;

        color:
            var(--sv-body);

        font-size: 15px;

        line-height: 1.7;
    }


    .supervisor-info-note strong {
        color:
            var(--sv-text);
    }


    /* ================================================================
       EMPTY
       ================================================================ */

    .supervisor-empty {
        padding:
            45px
            24px;

        text-align: center;
    }


    .supervisor-empty-icon {
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
            var(--sv-teal-soft);

        color:
            var(--sv-teal);

        font-size: 16px;
        font-weight: 900;
    }


    .supervisor-empty h3 {
        margin:
            0
            0
            8px;

        color:
            var(--sv-text);

        font-size: 22px;
        font-weight: 900;
    }


    .supervisor-empty p {
        max-width: 560px;

        margin:
            0
            auto;

        color:
            var(--sv-body);

        font-size: 16px;

        line-height: 1.7;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1180px) {

        .supervisor-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .supervisor-dashboard-layout {
            grid-template-columns:
                1fr;
        }


        .supervised-student-stat-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 850px) {

        .supervisor-dashboard-hero {
            padding:
                34px
                28px;
        }


        .supervisor-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .supervisor-hero-workload {
            width: 100%;
        }


        .supervisor-review-notice {
            flex-direction: column;

            align-items: stretch;
        }


        .supervisor-review-button {
            width: 100%;
        }


        .review-queue-grid {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 650px) {

        .supervisor-dashboard-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .supervisor-hero-identity {
            flex-direction: column;

            align-items: flex-start;
        }


        .supervisor-dashboard-hero h1 {
            font-size: 31px;
        }


        .supervisor-hero-description {
            font-size: 16px;
        }


        .supervisor-summary-grid,
        .supervised-student-stat-grid,
        .supervisor-quick-actions {
            grid-template-columns:
                1fr;
        }


        .supervisor-panel-header,
        .supervisor-panel-body {
            padding-left: 20px;
            padding-right: 20px;
        }


        .supervisor-panel-heading h2 {
            font-size: 21px;
        }


        .supervised-student-top {
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
    | Authenticated Supervisor
    |--------------------------------------------------------------------------
    */

    $supervisor =
        auth()->user();


    /*
    |--------------------------------------------------------------------------
    | Supervisor Identity
    |--------------------------------------------------------------------------
    */

    $supervisorName =
        $supervisor?->name
        ?? 'Supervisor';


    $supervisorNameParts =
        preg_split(
            '/\s+/',
            trim($supervisorName)
        );


    $supervisorInitials =
        collect($supervisorNameParts)
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
    | Supervised Assignments
    |--------------------------------------------------------------------------
    |
    | Load the records needed by this dashboard directly from the
    | Supervisor relationship so the redesigned Blade is not dependent
    | on a particular dashboard variable name.
    |
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
                        (string)
                        $assignment->status
                    ) === 'active'
            )
            ->values();


    $pendingAssignments =
        $supervisedAssignments
            ->filter(
                fn ($assignment) =>
                    strtolower(
                        (string)
                        $assignment->status
                    ) === 'pending'
            )
            ->values();


    $completedAssignments =
        $supervisedAssignments
            ->filter(
                fn ($assignment) =>
                    strtolower(
                        (string)
                        $assignment->status
                    ) === 'completed'
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Unique Assigned Students
    |--------------------------------------------------------------------------
    */

    $assignedStudentCount =
        $supervisedAssignments
            ->pluck(
                'student_profile_id'
            )
            ->filter()
            ->unique()
            ->count();


    $activeStudentCount =
        $activeAssignments
            ->pluck(
                'student_profile_id'
            )
            ->filter()
            ->unique()
            ->count();


    /*
    |--------------------------------------------------------------------------
    | All Attendance Records
    |--------------------------------------------------------------------------
    */

    $allAttendanceRecords =
        $supervisedAssignments
            ->flatMap(
                fn ($assignment) =>
                    collect(
                        $assignment
                            ->attendanceRecords
                        ?? []
                    )
                        ->map(
                            function ($attendance) use (
                                $assignment
                            ) {

                                $attendance
                                    ->setRelation(
                                        'dashboardAssignment',
                                        $assignment
                                    );


                                return $attendance;

                            }
                        )
            )
            ->values();


    $pendingAttendance =
        $allAttendanceRecords
            ->filter(
                fn ($record) =>
                    strtolower(
                        (string)
                        $record->status
                    ) === 'pending'
            )
            ->sortByDesc(
                fn ($record) =>
                    $record->date
                    ?? $record->attendance_date
                    ?? $record->created_at
            )
            ->values();


    $validatedAttendance =
        $allAttendanceRecords
            ->filter(
                fn ($record) =>
                    strtolower(
                        (string)
                        $record->status
                    ) === 'validated'
            )
            ->values();


    $rejectedAttendance =
        $allAttendanceRecords
            ->filter(
                fn ($record) =>
                    strtolower(
                        (string)
                        $record->status
                    ) === 'rejected'
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Validated Hours Across Assigned Students
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


    /*
    |--------------------------------------------------------------------------
    | All Daily Work Logs
    |--------------------------------------------------------------------------
    */

    $allWorkLogs =
        $supervisedAssignments
            ->flatMap(
                fn ($assignment) =>
                    collect(
                        $assignment
                            ->dailyWorkLogs
                        ?? []
                    )
                        ->map(
                            function ($log) use (
                                $assignment
                            ) {

                                $log
                                    ->setRelation(
                                        'dashboardAssignment',
                                        $assignment
                                    );


                                return $log;

                            }
                        )
            )
            ->values();


    $pendingWorkLogs =
        $allWorkLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string)
                        $log->status
                    ) === 'pending'
            )
            ->sortByDesc(
                fn ($log) =>
                    $log->submitted_at
                    ?? $log->created_at
            )
            ->values();


    $validatedWorkLogs =
        $allWorkLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string)
                        $log->status
                    ) === 'validated'
            )
            ->values();


    $rejectedWorkLogs =
        $allWorkLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string)
                        $log->status
                    ) === 'rejected'
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Final Evaluations
    |--------------------------------------------------------------------------
    */

    $assignmentsWithEvaluation =
        $supervisedAssignments
            ->filter(
                fn ($assignment) =>
                    $assignment
                        ->finalEvaluation
                    !== null
            )
            ->values();


    $assignmentsWithoutEvaluation =
        $supervisedAssignments
            ->filter(
                fn ($assignment) =>
                    in_array(
                        strtolower(
                            (string)
                            $assignment->status
                        ),
                        [
                            'active',
                            'completed',
                        ],
                        true
                    )
                    &&
                    $assignment
                        ->finalEvaluation
                    === null
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Total Pending Reviews
    |--------------------------------------------------------------------------
    */

    $totalPendingReviews =
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
    | Assignment Status
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

                'cancelled',
                'rejected' =>
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
    | Route Helper
    |--------------------------------------------------------------------------
    */

    $routeExists =
        fn ($name) =>
            \Illuminate\Support\Facades\Route::has(
                $name
            );

@endphp


<div class="supervisor-dashboard-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="supervisor-dashboard-hero">


        <div class="supervisor-hero-inner">


            <div class="supervisor-hero-identity">


                <div class="supervisor-hero-avatar">

                    {{ $supervisorInitials ?: 'SV' }}

                </div>


                <div class="supervisor-hero-copy">


                    <div class="supervisor-hero-eyebrow">


                        <span class="supervisor-hero-dot"></span>


                        Supervisor Portal · OJT Monitoring


                    </div>


                    <h1>

                        Welcome,
                        {{ $supervisorName }}

                    </h1>


                    <p class="supervisor-hero-description">

                        Monitor your assigned Students,
                        review GPS Selfie Attendance,
                        validate Daily Work Logs,
                        track rendered-hour progress,
                        and manage final OJT evaluations
                        from one clear workspace.

                    </p>


                </div>


            </div>


            <div class="supervisor-hero-workload">


                <span class="supervisor-workload-label">
                    Current Review Queue
                </span>


                <span class="supervisor-workload-value">

                    {{ $totalPendingReviews }}

                </span>


                <span class="supervisor-workload-description">

                    Attendance and Daily Work Log
                    records currently waiting
                    for your review.

                </span>


                <div class="supervisor-workload-footer">


                    <span>

                        {{ $pendingAttendance->count() }}
                        attendance

                    </span>


                    <span>

                        {{ $pendingWorkLogs->count() }}
                        work logs

                    </span>


                </div>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         PENDING REVIEW NOTICE
         ================================================================== --}}

    @if ($totalPendingReviews > 0)


        <section class="supervisor-review-notice">


            <div class="supervisor-review-notice-left">


                <div class="supervisor-review-notice-icon">
                    !
                </div>


                <div>


                    <strong>
                        You have records waiting for validation.
                    </strong>


                    <p>

                        There are currently

                        {{ $pendingAttendance->count() }}

                        attendance record{{ $pendingAttendance->count() === 1 ? '' : 's' }}

                        and

                        {{ $pendingWorkLogs->count() }}

                        Daily Work Log{{ $pendingWorkLogs->count() === 1 ? '' : 's' }}

                        that may need your review.

                    </p>


                </div>


            </div>


            @if (
                $routeExists(
                    'supervisor.validations.index'
                )
            )


                <a
                    href="{{ route(
                        'supervisor.validations.index'
                    ) }}"
                    class="supervisor-review-button"
                >
                    Review Pending Records
                </a>


            @endif


        </section>


    @endif


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="supervisor-summary-grid">


        <article class="supervisor-summary-card">


            <div class="supervisor-summary-icon summary-teal">
                ST
            </div>


            <span class="supervisor-summary-label">
                Assigned Students
            </span>


            <span class="supervisor-summary-value">

                {{ $assignedStudentCount }}

            </span>


            <span class="supervisor-summary-note">

                {{ $activeStudentCount }}

                currently in active OJT placements.

            </span>


        </article>


        <article class="supervisor-summary-card">


            <div class="supervisor-summary-icon summary-orange">
                AT
            </div>


            <span class="supervisor-summary-label">
                Pending Attendance
            </span>


            <span class="supervisor-summary-value">

                {{ $pendingAttendance->count() }}

            </span>


            <span class="supervisor-summary-note">

                GPS Selfie Attendance
                awaiting validation.

            </span>


        </article>


        <article class="supervisor-summary-card">


            <div class="supervisor-summary-icon summary-purple">
                WL
            </div>


            <span class="supervisor-summary-label">
                Pending Work Logs
            </span>


            <span class="supervisor-summary-value">

                {{ $pendingWorkLogs->count() }}

            </span>


            <span class="supervisor-summary-note">

                Student activity records
                waiting for your review.

            </span>


        </article>


        <article class="supervisor-summary-card">


            <div class="supervisor-summary-icon summary-green">
                HR
            </div>


            <span class="supervisor-summary-label">
                Validated OJT Hours
            </span>


            <span class="supervisor-summary-value">

                {{ number_format(
                    $validatedHours,
                    1
                ) }}

            </span>


            <span class="supervisor-summary-note">

                Combined validated hours
                across your assigned placements.

            </span>


        </article>


    </section>


    {{-- ==================================================================
         MAIN LAYOUT
         ================================================================== --}}

    <div class="supervisor-dashboard-layout">


        {{-- ==============================================================
             MAIN
             ============================================================== --}}

        <main class="supervisor-dashboard-main">


            {{-- ==========================================================
                 REVIEW QUEUE
                 ========================================================== --}}

            <section class="supervisor-panel">


                <div class="supervisor-panel-header">


                    <div class="supervisor-panel-heading">


                        <div class="supervisor-panel-icon panel-orange">
                            RV
                        </div>


                        <div>


                            <h2>
                                Review Queue
                            </h2>


                            <p>
                                Student records currently waiting for validation
                            </p>


                        </div>


                    </div>


                    @if (
                        $routeExists(
                            'supervisor.validations.index'
                        )
                    )


                        <a
                            href="{{ route(
                                'supervisor.validations.index'
                            ) }}"
                            class="supervisor-panel-link"
                        >
                            Open Validation Center →
                        </a>


                    @endif


                </div>


                <div class="supervisor-panel-body">


                    <div class="review-queue-grid">


                        {{-- ==============================================
                             ATTENDANCE
                             ============================================== --}}

                        <div class="review-queue-card">


                            <div class="review-queue-card-header">


                                <div class="review-queue-heading">


                                    <div
                                        class="
                                            review-queue-icon
                                            panel-teal
                                        "
                                    >
                                        AT
                                    </div>


                                    <span class="review-queue-title">
                                        Attendance
                                    </span>


                                </div>


                                <span class="review-queue-count">

                                    {{ $pendingAttendance->count() }}

                                </span>


                            </div>


                            @if ($pendingAttendance->isNotEmpty())


                                <div class="review-list">


                                    @foreach (
                                        $pendingAttendance->take(4)
                                        as $attendance
                                    )


                                        @php

                                            $reviewAssignment =
                                                $attendance
                                                    ->getRelation(
                                                        'dashboardAssignment'
                                                    );


                                            $reviewStudent =
                                                $reviewAssignment
                                                    ?->studentProfile
                                                    ?->user;


                                            $attendanceDate =
                                                $attendance->date
                                                ?? $attendance->attendance_date
                                                ?? null;

                                        @endphp


                                        <div class="review-item">


                                            <span class="review-item-name">

                                                {{ $reviewStudent?->name
                                                    ?? 'Student unavailable'
                                                }}

                                            </span>


                                            <span class="review-item-meta">

                                                {{ $formatDate(
                                                    $attendanceDate
                                                ) }}

                                                ·

                                                {{ $formatTime(
                                                    $attendance->time_in
                                                ) }}

                                                →

                                                {{ $formatTime(
                                                    $attendance->time_out
                                                ) }}

                                            </span>


                                        </div>


                                    @endforeach


                                </div>


                            @else


                                <div class="review-empty">

                                    No attendance records are
                                    waiting for validation.

                                </div>


                            @endif


                        </div>


                        {{-- ==============================================
                             WORK LOGS
                             ============================================== --}}

                        <div class="review-queue-card">


                            <div class="review-queue-card-header">


                                <div class="review-queue-heading">


                                    <div
                                        class="
                                            review-queue-icon
                                            panel-purple
                                        "
                                    >
                                        WL
                                    </div>


                                    <span class="review-queue-title">
                                        Daily Work Logs
                                    </span>


                                </div>


                                <span class="review-queue-count">

                                    {{ $pendingWorkLogs->count() }}

                                </span>


                            </div>


                            @if ($pendingWorkLogs->isNotEmpty())


                                <div class="review-list">


                                    @foreach (
                                        $pendingWorkLogs->take(4)
                                        as $log
                                    )


                                        @php

                                            $logAssignment =
                                                $log
                                                    ->getRelation(
                                                        'dashboardAssignment'
                                                    );


                                            $logStudent =
                                                $logAssignment
                                                    ?->studentProfile
                                                    ?->user;

                                        @endphp


                                        <div class="review-item">


                                            <span class="review-item-name">

                                                {{ $logStudent?->name
                                                    ?? 'Student unavailable'
                                                }}

                                            </span>


                                            <span class="review-item-meta">

                                                {{ $formatDate(
                                                    $log->submitted_at
                                                    ?? $log->created_at
                                                ) }}

                                                ·

                                                {{ \Illuminate\Support\Str::limit(
                                                    $log->tasks
                                                        ?: 'Daily Work Log',
                                                    70
                                                ) }}

                                            </span>


                                        </div>


                                    @endforeach


                                </div>


                            @else


                                <div class="review-empty">

                                    No Daily Work Logs are
                                    waiting for validation.

                                </div>


                            @endif


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 ASSIGNED STUDENTS
                 ========================================================== --}}

            <section class="supervisor-panel">


                <div class="supervisor-panel-header">


                    <div class="supervisor-panel-heading">


                        <div class="supervisor-panel-icon panel-teal">
                            ST
                        </div>


                        <div>


                            <h2>
                                Assigned Student Progress
                            </h2>


                            <p>
                                OJT hour progress and validation overview
                            </p>


                        </div>


                    </div>


                    @if (
                        $routeExists(
                            'supervisor.reports.index'
                        )
                    )


                        <a
                            href="{{ route(
                                'supervisor.reports.index'
                            ) }}"
                            class="supervisor-panel-link"
                        >
                            View Reports →
                        </a>


                    @endif


                </div>


                <div class="supervisor-panel-body">


                    @if ($supervisedAssignments->isNotEmpty())


                        <div class="supervised-student-list">


                            @foreach (
                                $supervisedAssignments
                                    ->take(8)
                                as $assignment
                            )


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


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Assignment Attendance
                                    |--------------------------------------------------------------------------
                                    */

                                    $assignmentAttendance =
                                        collect(
                                            $assignment
                                                ->attendanceRecords
                                            ?? []
                                        );


                                    $assignmentValidatedAttendance =
                                        $assignmentAttendance
                                            ->filter(
                                                fn ($record) =>
                                                    strtolower(
                                                        (string)
                                                        $record->status
                                                    ) === 'validated'
                                            );


                                    $assignmentPendingAttendance =
                                        $assignmentAttendance
                                            ->filter(
                                                fn ($record) =>
                                                    strtolower(
                                                        (string)
                                                        $record->status
                                                    ) === 'pending'
                                            );


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Assignment Hours
                                    |--------------------------------------------------------------------------
                                    */

                                    $studentValidatedMinutes =
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


                                    $studentValidatedHours =
                                        $studentValidatedMinutes
                                        / 60;


                                    $studentRequiredHours =
                                        (float) (
                                            $assignment
                                                ->required_hours
                                            ?? 0
                                        );


                                    $studentRequiredMinutes =
                                        (int) round(
                                            $studentRequiredHours
                                            * 60
                                        );


                                    $studentProgress =
                                        $studentRequiredMinutes > 0
                                            ? min(
                                                100,
                                                (int) round(
                                                    (
                                                        $studentValidatedMinutes
                                                        /
                                                        $studentRequiredMinutes
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

                                    $assignmentWorkLogs =
                                        collect(
                                            $assignment
                                                ->dailyWorkLogs
                                            ?? []
                                        );


                                    $assignmentPendingWorkLogs =
                                        $assignmentWorkLogs
                                            ->filter(
                                                fn ($log) =>
                                                    strtolower(
                                                        (string)
                                                        $log->status
                                                    ) === 'pending'
                                            );


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Status
                                    |--------------------------------------------------------------------------
                                    */

                                    $studentAssignmentStatus =
                                        strtolower(
                                            (string)
                                            $assignment->status
                                        );

                                @endphp


                                <article class="supervised-student-card">


                                    <div class="supervised-student-top">


                                        <div class="supervised-student-identity">


                                            <div class="supervised-student-avatar">

                                                {{ $makeInitials(
                                                    $studentName
                                                ) }}

                                            </div>


                                            <div>


                                                <span class="supervised-student-name">

                                                    {{ $studentName }}

                                                </span>


                                                <span class="supervised-student-meta">

                                                    {{ $studentProfile
                                                        ?->student_number
                                                        ?? 'Student number unavailable'
                                                    }}

                                                    @if (
                                                        filled(
                                                            $studentProfile
                                                                ?->program
                                                        )
                                                    )

                                                        ·
                                                        {{ $studentProfile->program }}

                                                    @endif


                                                    @if (
                                                        filled(
                                                            $assignment
                                                                ->company
                                                                ?->name
                                                        )
                                                    )

                                                        ·
                                                        {{ $assignment
                                                            ->company
                                                            ->name
                                                        }}

                                                    @endif

                                                </span>


                                            </div>


                                        </div>


                                        <span
                                            class="
                                                supervisor-status
                                                {{ $statusClass(
                                                    $studentAssignmentStatus
                                                ) }}
                                            "
                                        >

                                            {{ $statusLabel(
                                                $studentAssignmentStatus
                                            ) }}

                                        </span>


                                    </div>


                                    <div class="supervised-student-body">


                                        <div class="supervised-student-stat-grid">


                                            <div class="supervised-student-stat">


                                                <span class="supervised-student-stat-label">
                                                    Validated Hours
                                                </span>


                                                <span class="supervised-student-stat-value">

                                                    {{ number_format(
                                                        $studentValidatedHours,
                                                        1
                                                    ) }}

                                                </span>


                                            </div>


                                            <div class="supervised-student-stat">


                                                <span class="supervised-student-stat-label">
                                                    Required Hours
                                                </span>


                                                <span class="supervised-student-stat-value">

                                                    {{ number_format(
                                                        $studentRequiredHours,
                                                        1
                                                    ) }}

                                                </span>


                                            </div>


                                            <div class="supervised-student-stat">


                                                <span class="supervised-student-stat-label">
                                                    Pending Attendance
                                                </span>


                                                <span class="supervised-student-stat-value">

                                                    {{ $assignmentPendingAttendance->count() }}

                                                </span>


                                            </div>


                                            <div class="supervised-student-stat">


                                                <span class="supervised-student-stat-label">
                                                    Pending Work Logs
                                                </span>


                                                <span class="supervised-student-stat-value">

                                                    {{ $assignmentPendingWorkLogs->count() }}

                                                </span>


                                            </div>


                                        </div>


                                        <div class="student-progress-top">


                                            <span class="student-progress-copy">

                                                Validated OJT hour progress

                                            </span>


                                            <span class="student-progress-percentage">

                                                {{ $studentProgress }}%

                                            </span>


                                        </div>


                                        <div class="student-progress-track">


                                            <div
                                                class="student-progress-fill"
                                                style="
                                                    width:
                                                    {{ $studentProgress }}%;
                                                "
                                            ></div>


                                        </div>


                                    </div>


                                </article>


                            @endforeach


                        </div>


                    @else


                        <div class="supervisor-empty">


                            <div class="supervisor-empty-icon">
                                ST
                            </div>


                            <h3>
                                No Students Assigned Yet
                            </h3>


                            <p>

                                Students assigned to you as their
                                OJT Supervisor will appear here
                                together with their attendance,
                                Work Logs, rendered hours,
                                and evaluation status.

                            </p>


                        </div>


                    @endif


                </div>


            </section>


        </main>


        {{-- ==============================================================
             SIDEBAR
             ============================================================== --}}

        <aside class="supervisor-dashboard-sidebar">


            {{-- ==========================================================
                 QUICK ACTIONS
                 ========================================================== --}}

            <section class="supervisor-panel">


                <div class="supervisor-panel-header">


                    <div class="supervisor-panel-heading">


                        <div class="supervisor-panel-icon panel-teal">
                            QA
                        </div>


                        <div>


                            <h2>
                                Quick Actions
                            </h2>


                            <p>
                                Open your Supervisor tools
                            </p>


                        </div>


                    </div>


                </div>


                <div class="supervisor-panel-body">


                    <div class="supervisor-quick-actions">


                        @if (
                            $routeExists(
                                'supervisor.validations.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'supervisor.validations.index'
                                ) }}"
                                class="supervisor-quick-action"
                            >


                                <span
                                    class="
                                        supervisor-action-icon
                                        action-teal
                                    "
                                >
                                    AT
                                </span>


                                <span>


                                    <span class="supervisor-action-title">
                                        Attendance Review
                                    </span>


                                    <span class="supervisor-action-description">

                                        Validate Student GPS
                                        Selfie Attendance.

                                    </span>


                                </span>


                            </a>


                        @endif


                        @if (
                            $routeExists(
                                'supervisor.work-logs.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'supervisor.work-logs.index'
                                ) }}"
                                class="supervisor-quick-action"
                            >


                                <span
                                    class="
                                        supervisor-action-icon
                                        action-purple
                                    "
                                >
                                    WL
                                </span>


                                <span>


                                    <span class="supervisor-action-title">
                                        Work Log Review
                                    </span>


                                    <span class="supervisor-action-description">

                                        Review Student tasks,
                                        learnings, and activities.

                                    </span>


                                </span>


                            </a>


                        @endif


                        @if (
                            $routeExists(
                                'supervisor.evaluations.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'supervisor.evaluations.index'
                                ) }}"
                                class="supervisor-quick-action"
                            >


                                <span
                                    class="
                                        supervisor-action-icon
                                        action-orange
                                    "
                                >
                                    EV
                                </span>


                                <span>


                                    <span class="supervisor-action-title">
                                        Final Evaluation
                                    </span>


                                    <span class="supervisor-action-description">

                                        Complete Student
                                        final OJT evaluations.

                                    </span>


                                </span>


                            </a>


                        @endif


                        @if (
                            $routeExists(
                                'supervisor.reports.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'supervisor.reports.index'
                                ) }}"
                                class="supervisor-quick-action"
                            >


                                <span
                                    class="
                                        supervisor-action-icon
                                        action-blue
                                    "
                                >
                                    RP
                                </span>


                                <span>


                                    <span class="supervisor-action-title">
                                        Student Reports
                                    </span>


                                    <span class="supervisor-action-description">

                                        Review Student OJT
                                        progress summaries.

                                    </span>


                                </span>


                            </a>


                        @endif


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 WORKLOAD
                 ========================================================== --}}

            <section class="supervisor-panel">


                <div class="supervisor-panel-header">


                    <div class="supervisor-panel-heading">


                        <div class="supervisor-panel-icon panel-blue">
                            WB
                        </div>


                        <div>


                            <h2>
                                Workload Overview
                            </h2>


                            <p>
                                Your current OJT monitoring workload
                            </p>


                        </div>


                    </div>


                </div>


                <div class="supervisor-panel-body">


                    <div class="supervisor-sidebar-list">


                        <div class="supervisor-sidebar-item">


                            <span class="supervisor-sidebar-label">
                                Total Assignments
                            </span>


                            <span class="supervisor-sidebar-value">

                                {{ $supervisedAssignments->count() }}

                            </span>


                        </div>


                        <div class="supervisor-sidebar-item">


                            <span class="supervisor-sidebar-label">
                                Active Placements
                            </span>


                            <span class="supervisor-sidebar-value">

                                {{ $activeAssignments->count() }}

                            </span>


                        </div>


                        <div class="supervisor-sidebar-item">


                            <span class="supervisor-sidebar-label">
                                Pending Placements
                            </span>


                            <span class="supervisor-sidebar-value">

                                {{ $pendingAssignments->count() }}

                            </span>


                        </div>


                        <div class="supervisor-sidebar-item">


                            <span class="supervisor-sidebar-label">
                                Completed Placements
                            </span>


                            <span class="supervisor-sidebar-value">

                                {{ $completedAssignments->count() }}

                            </span>


                        </div>


                        <div class="supervisor-sidebar-item">


                            <span class="supervisor-sidebar-label">
                                Validated Attendance
                            </span>


                            <span class="supervisor-sidebar-value">

                                {{ $validatedAttendance->count() }}

                            </span>


                        </div>


                        <div class="supervisor-sidebar-item">


                            <span class="supervisor-sidebar-label">
                                Validated Work Logs
                            </span>


                            <span class="supervisor-sidebar-value">

                                {{ $validatedWorkLogs->count() }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 EVALUATIONS
                 ========================================================== --}}

            <section class="supervisor-panel">


                <div class="supervisor-panel-header">


                    <div class="supervisor-panel-heading">


                        <div class="supervisor-panel-icon panel-purple">
                            EV
                        </div>


                        <div>


                            <h2>
                                Final Evaluations
                            </h2>


                            <p>
                                Evaluation completion overview
                            </p>


                        </div>


                    </div>


                </div>


                <div class="supervisor-panel-body">


                    <div class="evaluation-list">


                        <div class="evaluation-row">


                            <span class="evaluation-row-label">
                                Evaluations Submitted
                            </span>


                            <span class="evaluation-row-value">

                                {{ $assignmentsWithEvaluation->count() }}

                            </span>


                        </div>


                        <div class="evaluation-row">


                            <span class="evaluation-row-label">
                                Without Evaluation
                            </span>


                            <span class="evaluation-row-value">

                                {{ $assignmentsWithoutEvaluation->count() }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 SUPERVISOR GUIDE
                 ========================================================== --}}

            <section class="supervisor-panel">


                <div class="supervisor-panel-header">


                    <div class="supervisor-panel-heading">


                        <div class="supervisor-panel-icon panel-green">
                            123
                        </div>


                        <div>


                            <h2>
                                Review Workflow
                            </h2>


                            <p>
                                Recommended Supervisor process
                            </p>


                        </div>


                    </div>


                </div>


                <div class="supervisor-panel-body">


                    <div class="supervisor-guide">


                        <div class="supervisor-guide-item">


                            <div class="supervisor-guide-number">
                                1
                            </div>


                            <div>


                                <span class="supervisor-guide-title">
                                    Review Attendance
                                </span>


                                <span class="supervisor-guide-description">

                                    Check the Student's
                                    submitted attendance record
                                    before validation.

                                </span>


                            </div>


                        </div>


                        <div class="supervisor-guide-item">


                            <div class="supervisor-guide-number">
                                2
                            </div>


                            <div>


                                <span class="supervisor-guide-title">
                                    Review Daily Work Logs
                                </span>


                                <span class="supervisor-guide-description">

                                    Confirm that the documented
                                    tasks and activities reflect
                                    the Student's OJT work.

                                </span>


                            </div>


                        </div>


                        <div class="supervisor-guide-item">


                            <div class="supervisor-guide-number">
                                3
                            </div>


                            <div>


                                <span class="supervisor-guide-title">
                                    Monitor OJT Progress
                                </span>


                                <span class="supervisor-guide-description">

                                    Track validated rendered
                                    hours against each Student's
                                    required training hours.

                                </span>


                            </div>


                        </div>


                        <div class="supervisor-guide-item">


                            <div class="supervisor-guide-number">
                                4
                            </div>


                            <div>


                                <span class="supervisor-guide-title">
                                    Submit Final Evaluation
                                </span>


                                <span class="supervisor-guide-description">

                                    Complete the final evaluation
                                    when the Student reaches the
                                    appropriate stage of OJT.

                                </span>


                            </div>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 RESPONSIBILITY NOTE
                 ========================================================== --}}

            <section class="supervisor-panel">


                <div class="supervisor-panel-header">


                    <div class="supervisor-panel-heading">


                        <div class="supervisor-panel-icon panel-teal">
                            i
                        </div>


                        <div>


                            <h2>
                                Validation Reminder
                            </h2>


                            <p>
                                Maintain reliable OJT records
                            </p>


                        </div>


                    </div>


                </div>


                <div class="supervisor-panel-body">


                    <div class="supervisor-info-note">

                        <strong>
                            Validate records carefully.
                        </strong>

                        Validated attendance contributes to a
                        Student's official rendered OJT hours.
                        Review the available attendance details,
                        Work Log information, and Supervisor
                        remarks before making a validation decision.

                    </div>


                </div>


            </section>


        </aside>


    </div>


</div>


@endsection