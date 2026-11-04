@extends('layouts.app')


@section('title', 'Daily Work Log Review | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC - SUPERVISOR DAILY WORK LOG REVIEW
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --wl-navy: #183B6B;
        --wl-navy-dark: #102A4A;

        --wl-blue: #2563EB;
        --wl-blue-soft: #EAF2FF;

        --wl-teal: #0F766E;
        --wl-teal-soft: #E7F7F5;

        --wl-green: #15803D;
        --wl-green-dark: #11632F;
        --wl-green-soft: #EAF8EF;

        --wl-orange: #B45309;
        --wl-orange-soft: #FFF5E6;

        --wl-red: #B42318;
        --wl-red-soft: #FFF0EE;

        --wl-purple: #6D4FC2;
        --wl-purple-soft: #F2EEFF;

        --wl-gray: #475569;
        --wl-gray-soft: #F1F5F9;

        --wl-text: #102A4A;
        --wl-body: #405872;
        --wl-muted: #64778C;

        --wl-white: #FFFFFF;
        --wl-soft: #F8FBFE;

        --wl-border: #D8E3EE;
        --wl-border-soft: #E7EDF4;

        --wl-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --wl-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --wl-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .supervisor-work-log-page {
        width: 100%;

        color: var(--wl-text);

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

    .work-log-hero {
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
                rgba(167, 139, 250, 0.20),
                transparent 25%
            ),
            radial-gradient(
                circle at 70% 90%,
                rgba(45, 212, 191, 0.16),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 52%,
                #17666B 100%
            );

        box-shadow:
            var(--wl-shadow-large);
    }


    .work-log-hero::before {
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


    .work-log-hero::after {
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


    .work-log-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 36px;
    }


    .work-log-hero-copy {
        min-width: 0;

        max-width: 770px;
    }


    .work-log-hero-eyebrow {
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


    .work-log-hero-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background:
            #A78BFA;

        box-shadow:
            0 0 0 5px
            rgba(167, 139, 250, 0.14);
    }


    .work-log-hero h1 {
        margin:
            0
            0
            11px;

        color: #FFFFFF;

        font-size: 38px;
        font-weight: 900;

        line-height: 1.18;

        letter-spacing:
            -0.55px;
    }


    .work-log-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.83);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO QUEUE
       ================================================================ */

    .work-log-hero-queue {
        width: 315px;

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


    .work-log-queue-label {
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


    .work-log-queue-value {
        display: block;

        color: #FFFFFF;

        font-size: 36px;
        font-weight: 900;

        line-height: 1.1;
    }


    .work-log-queue-description {
        display: block;

        margin-top: 7px;

        color:
            rgba(255, 255, 255, 0.80);

        font-size: 15px;

        line-height: 1.55;
    }


    .work-log-queue-footer {
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
       REVIEW NOTICE
       ================================================================ */

    .work-log-review-notice {
        display: flex;
        align-items: flex-start;

        gap: 15px;

        margin-bottom: 26px;

        padding:
            19px
            21px;

        border:
            1px solid
            #D9D1F1;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #FBFAFF 0%,
                #F5F1FF 100%
            );

        box-shadow:
            var(--wl-shadow);
    }


    .work-log-review-notice-icon {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--wl-purple-soft);

        color:
            var(--wl-purple);

        font-size: 17px;
        font-weight: 900;
    }


    .work-log-review-notice strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--wl-text);

        font-size: 17px;
        font-weight: 850;
    }


    .work-log-review-notice span {
        color:
            var(--wl-body);

        font-size: 15px;

        line-height: 1.65;
    }


    /* ================================================================
       SUMMARY
       ================================================================ */

    .work-log-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 19px;

        margin-bottom: 28px;
    }


    .work-log-summary-card {
        padding: 24px;

        border:
            1px solid
            var(--wl-border);

        border-radius: 20px;

        background:
            var(--wl-white);

        box-shadow:
            var(--wl-shadow);

        transition:
            var(--wl-transition);
    }


    .work-log-summary-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            0 18px 38px
            rgba(15, 42, 74, 0.10);
    }


    .work-log-summary-icon {
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


    .summary-purple {
        background:
            var(--wl-purple-soft);

        color:
            var(--wl-purple);
    }


    .summary-green {
        background:
            var(--wl-green-soft);

        color:
            var(--wl-green);
    }


    .summary-orange {
        background:
            var(--wl-orange-soft);

        color:
            var(--wl-orange);
    }


    .summary-red {
        background:
            var(--wl-red-soft);

        color:
            var(--wl-red);
    }


    .work-log-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--wl-body);

        font-size: 15px;
        font-weight: 750;
    }


    .work-log-summary-value {
        display: block;

        color:
            var(--wl-text);

        font-size: 32px;
        font-weight: 900;

        line-height: 1.15;
    }


    .work-log-summary-note {
        display: block;

        margin-top: 9px;

        color:
            var(--wl-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       FILTER
       ================================================================ */

    .work-log-filter {
        margin-bottom: 27px;

        padding:
            21px
            22px;

        border:
            1px solid
            var(--wl-border);

        border-radius: 18px;

        background:
            var(--wl-white);

        box-shadow:
            var(--wl-shadow);
    }


    .work-log-filter-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 16px;
    }


    .work-log-filter-title {
        display: block;

        margin-bottom: 3px;

        color:
            var(--wl-text);

        font-size: 18px;
        font-weight: 850;
    }


    .work-log-filter-description {
        color:
            var(--wl-muted);

        font-size: 14px;
    }


    .work-log-visible-count {
        padding:
            8px
            12px;

        border-radius: 999px;

        background:
            var(--wl-gray-soft);

        color:
            var(--wl-body);

        font-size: 14px;
        font-weight: 850;

        white-space: nowrap;
    }


    .work-log-filter-grid {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            210px;

        gap: 13px;
    }


    .work-log-search,
    .work-log-filter-select {
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
            var(--wl-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;
    }


    .work-log-search {
        padding:
            0
            15px;
    }


    .work-log-filter-select {
        padding:
            0
            14px;

        cursor: pointer;
    }


    .work-log-search:focus,
    .work-log-filter-select:focus {
        border-color:
            var(--wl-purple);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(109, 79, 194, 0.09);
    }


    /* ================================================================
       PANEL
       ================================================================ */

    .work-log-panel {
        overflow: hidden;

        border:
            1px solid
            var(--wl-border);

        border-radius: 20px;

        background:
            var(--wl-white);

        box-shadow:
            var(--wl-shadow);
    }


    .work-log-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            24px
            26px;

        border-bottom:
            1px solid
            var(--wl-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .work-log-panel-heading {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    .work-log-panel-icon {
        width: 50px;
        height: 50px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background:
            var(--wl-purple-soft);

        color:
            var(--wl-purple);

        font-size: 13px;
        font-weight: 900;
    }


    .work-log-panel-heading h2 {
        margin:
            0
            0
            4px;

        color:
            var(--wl-text);

        font-size: 23px;
        font-weight: 850;

        line-height: 1.3;
    }


    .work-log-panel-heading p {
        margin: 0;

        color:
            var(--wl-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .work-log-panel-body {
        padding:
            26px;
    }


    /* ================================================================
       WORK LOG RECORD
       ================================================================ */

    .supervisor-work-log-list {
        display: grid;

        gap: 22px;
    }


    .supervisor-work-log-record {
        overflow: hidden;

        border:
            1px solid
            var(--wl-border);

        border-radius: 19px;

        background:
            #FFFFFF;

        transition:
            var(--wl-transition);
    }


    .supervisor-work-log-record:hover {
        border-color:
            #C4D1E0;

        box-shadow:
            0 16px 34px
            rgba(15, 42, 74, 0.08);
    }


    /* ================================================================
       RECORD HEADER
       ================================================================ */

    .work-log-record-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding:
            21px
            22px;

        border-bottom:
            1px solid
            var(--wl-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FAFCFF 100%
            );
    }


    .work-log-student {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 15px;
    }


    .work-log-student-avatar {
        width: 56px;
        height: 56px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background:
            var(--wl-teal-soft);

        color:
            var(--wl-teal);

        font-size: 16px;
        font-weight: 900;
    }


    .work-log-student-name {
        display: block;

        margin-bottom: 3px;

        color:
            var(--wl-text);

        font-size: 19px;
        font-weight: 900;

        line-height: 1.4;
    }


    .work-log-student-meta {
        display: block;

        color:
            var(--wl-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       STATUS
       ================================================================ */

    .work-log-status {
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


    .work-log-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .status-pending {
        background:
            var(--wl-orange-soft);

        color:
            var(--wl-orange);
    }


    .status-pending::before {
        background:
            #F59E0B;
    }


    .status-validated {
        background:
            var(--wl-green-soft);

        color:
            var(--wl-green);
    }


    .status-validated::before {
        background:
            #22C55E;
    }


    .status-rejected {
        background:
            var(--wl-red-soft);

        color:
            var(--wl-red);
    }


    .status-rejected::before {
        background:
            #EF4444;
    }


    .status-default {
        background:
            var(--wl-gray-soft);

        color:
            var(--wl-gray);
    }


    .status-default::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       RECORD BODY
       ================================================================ */

    .work-log-record-body {
        padding:
            22px;
    }


    /* ================================================================
       RECORD OVERVIEW
       ================================================================ */

    .work-log-overview-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 13px;

        margin-bottom: 18px;
    }


    .work-log-overview-item {
        min-height: 96px;

        padding:
            15px;

        border:
            1px solid
            var(--wl-border-soft);

        border-radius: 12px;

        background:
            var(--wl-soft);
    }


    .work-log-overview-label {
        display: block;

        margin-bottom: 6px;

        color:
            var(--wl-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.25px;
    }


    .work-log-overview-value {
        display: block;

        color:
            var(--wl-text);

        font-size: 17px;
        font-weight: 900;

        line-height: 1.5;
    }


    .work-log-overview-secondary {
        display: block;

        margin-top: 3px;

        color:
            var(--wl-muted);

        font-size: 13px;

        line-height: 1.45;
    }


    /* ================================================================
       WORK LOG CONTENT
       ================================================================ */

    .work-log-content-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 15px;
    }


    .work-log-content-block {
        padding:
            19px;

        border:
            1px solid
            var(--wl-border);

        border-radius: 15px;

        background:
            #FBFDFF;
    }


    .work-log-content-full {
        grid-column:
            1 / -1;
    }


    .work-log-content-header {
        display: flex;
        align-items: center;

        gap: 10px;

        margin-bottom: 10px;
    }


    .work-log-content-icon {
        width: 38px;
        height: 38px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        font-size: 11px;
        font-weight: 900;
    }


    .content-purple {
        background:
            var(--wl-purple-soft);

        color:
            var(--wl-purple);
    }


    .content-blue {
        background:
            var(--wl-blue-soft);

        color:
            var(--wl-blue);
    }


    .content-orange {
        background:
            var(--wl-orange-soft);

        color:
            var(--wl-orange);
    }


    .content-teal {
        background:
            var(--wl-teal-soft);

        color:
            var(--wl-teal);
    }


    .work-log-content-label {
        color:
            var(--wl-text);

        font-size: 16px;
        font-weight: 900;
    }


    .work-log-content-value {
        color:
            var(--wl-body);

        font-size: 17px;

        line-height: 1.8;

        white-space: pre-line;

        word-break: break-word;
    }


    .work-log-no-content {
        color:
            var(--wl-muted);

        font-size: 15px;

        font-style: italic;
    }


    /* ================================================================
       ATTENDANCE CONNECTION
       ================================================================ */

    .work-log-attendance {
        margin-top: 17px;

        padding:
            18px;

        border:
            1px solid
            #CDE2DD;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #F8FCFB 0%,
                #F1FAF8 100%
            );
    }


    .work-log-attendance-title {
        display: block;

        margin-bottom: 13px;

        color:
            var(--wl-text);

        font-size: 17px;
        font-weight: 900;
    }


    .work-log-attendance-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 11px;
    }


    .work-log-attendance-item {
        padding:
            13px;

        border:
            1px solid
            rgba(15, 118, 110, 0.10);

        border-radius: 10px;

        background:
            rgba(255, 255, 255, 0.80);
    }


    .work-log-attendance-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--wl-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .work-log-attendance-value {
        display: block;

        color:
            var(--wl-text);

        font-size: 15px;
        font-weight: 850;

        line-height: 1.5;
    }


    /* ================================================================
       REVIEW FORM
       ================================================================ */

    .work-log-review-section {
        margin-top: 18px;

        padding:
            20px;

        border:
            1px solid
            #DDD6F1;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                #FCFBFF 0%,
                #F7F4FF 100%
            );
    }


    .work-log-review-title {
        display: block;

        margin-bottom: 5px;

        color:
            var(--wl-text);

        font-size: 17px;
        font-weight: 900;
    }


    .work-log-review-description {
        display: block;

        margin-bottom: 13px;

        color:
            var(--wl-body);

        font-size: 15px;

        line-height: 1.6;
    }


    .work-log-review-label {
        display: block;

        margin-bottom: 8px;

        color:
            var(--wl-text);

        font-size: 15px;
        font-weight: 850;
    }


    .work-log-review-textarea {
        width: 100%;

        min-height: 120px;

        resize: vertical;

        padding:
            14px
            15px;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background:
            #FFFFFF;

        color:
            var(--wl-text);

        font-family:
            inherit;

        font-size: 16px;
        font-weight: 600;

        line-height: 1.7;

        transition:
            var(--wl-transition);
    }


    .work-log-review-textarea:focus {
        border-color:
            var(--wl-purple);

        box-shadow:
            0 0 0 4px
            rgba(109, 79, 194, 0.09);
    }


    .work-log-review-help {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        margin-top: 8px;

        color:
            var(--wl-muted);

        font-size: 13px;

        line-height: 1.55;
    }


    /* ================================================================
       REVIEW ACTIONS
       ================================================================ */

    .work-log-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        flex-wrap: wrap;

        gap: 11px;

        margin-top: 18px;

        padding-top: 18px;

        border-top:
            1px solid
            rgba(109, 79, 194, 0.10);
    }


    .work-log-action-form {
        margin: 0;
    }


    .work-log-action-button {
        min-height: 51px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            19px;

        border-radius: 12px;

        font-family:
            inherit;

        font-size: 15px;
        font-weight: 900;

        cursor: pointer;

        transition:
            var(--wl-transition);
    }


    .work-log-action-validate {
        border:
            1px solid
            var(--wl-green);

        background:
            var(--wl-green);

        color:
            #FFFFFF;
    }


    .work-log-action-validate:hover {
        transform:
            translateY(-1px);

        background:
            var(--wl-green-dark);

        box-shadow:
            0 10px 22px
            rgba(21, 128, 61, 0.16);
    }


    .work-log-action-reject {
        border:
            1px solid
            #E4B5AF;

        background:
            #FFFFFF;

        color:
            var(--wl-red);
    }


    .work-log-action-reject:hover {
        transform:
            translateY(-1px);

        border-color:
            var(--wl-red);

        background:
            var(--wl-red-soft);
    }


    .work-log-action-button:disabled {
        opacity: 0.65;

        cursor: not-allowed;

        transform: none;
    }


    /* ================================================================
       EXISTING REVIEW
       ================================================================ */

    .existing-work-log-review {
        margin-top: 18px;

        padding:
            18px;

        border:
            1px solid
            #D5E4F2;

        border-radius: 14px;

        background:
            #F6FAFE;
    }


    .existing-work-log-review-label {
        display: block;

        margin-bottom: 6px;

        color:
            var(--wl-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .existing-work-log-review-value {
        color:
            var(--wl-text);

        font-size: 16px;

        line-height: 1.75;

        white-space: pre-line;
    }


    .work-log-review-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap:
            8px
            18px;

        margin-top: 14px;

        padding-top: 14px;

        border-top:
            1px solid
            var(--wl-border-soft);

        color:
            var(--wl-muted);

        font-size: 13px;
    }


    /* ================================================================
       ROUTE NOTICE
       ================================================================ */

    .work-log-route-note {
        margin-top: 17px;

        padding:
            14px
            15px;

        border:
            1px solid
            #E7D9BC;

        border-radius: 11px;

        background:
            #FFF9ED;

        color:
            #7A4B0D;

        font-size: 14px;

        line-height: 1.6;
    }


    /* ================================================================
       EMPTY STATE
       ================================================================ */

    .work-log-empty {
        padding:
            55px
            24px;

        text-align: center;
    }


    .work-log-empty-icon {
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
            var(--wl-purple-soft);

        color:
            var(--wl-purple);

        font-size: 17px;
        font-weight: 900;
    }


    .work-log-empty h3 {
        margin:
            0
            0
            8px;

        color:
            var(--wl-text);

        font-size: 22px;
        font-weight: 900;
    }


    .work-log-empty p {
        max-width: 590px;

        margin:
            0
            auto;

        color:
            var(--wl-body);

        font-size: 16px;

        line-height: 1.7;
    }


    .work-log-filter-empty {
        display: none;

        padding:
            45px
            20px;

        text-align: center;

        color:
            var(--wl-body);

        font-size: 16px;
    }


    .work-log-filter-empty.is-visible {
        display: block;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1180px) {

        .work-log-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .work-log-overview-grid,
        .work-log-attendance-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 850px) {

        .work-log-hero {
            padding:
                34px
                28px;
        }


        .work-log-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .work-log-hero-queue {
            width: 100%;
        }


        .work-log-filter-grid,
        .work-log-content-grid {
            grid-template-columns:
                1fr;
        }


        .work-log-content-full {
            grid-column:
                auto;
        }


        .work-log-record-header {
            flex-direction: column;

            align-items: flex-start;
        }

    }


    @media (max-width: 650px) {

        .work-log-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .work-log-hero h1 {
            font-size: 31px;
        }


        .work-log-hero-description {
            font-size: 16px;
        }


        .work-log-summary-grid,
        .work-log-overview-grid,
        .work-log-attendance-grid {
            grid-template-columns:
                1fr;
        }


        .work-log-panel-header,
        .work-log-panel-body {
            padding-left: 20px;
            padding-right: 20px;
        }


        .work-log-panel-heading h2 {
            font-size: 21px;
        }


        .work-log-filter-top {
            flex-direction: column;

            align-items: flex-start;
        }


        .work-log-student {
            align-items: flex-start;
        }


        .work-log-student-avatar {
            width: 50px;
            height: 50px;
        }


        .work-log-actions {
            display: grid;

            grid-template-columns:
                1fr;
        }


        .work-log-action-form,
        .work-log-action-button {
            width: 100%;
        }


        .work-log-review-help {
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
    | Supervisor
    |--------------------------------------------------------------------------
    */

    $supervisor =
        auth()->user();


    /*
    |--------------------------------------------------------------------------
    | Supervisor Assignments
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
                ])
                ->latest('start_date')
                ->get()
            : collect();


    /*
    |--------------------------------------------------------------------------
    | Build Work Log Collection
    |--------------------------------------------------------------------------
    |
    | The assignment and attendance are attached as temporary relations
    | for display only.
    |
    */

    $allWorkLogs =
        $supervisedAssignments
            ->flatMap(
                function ($assignment) {

                    $attendanceRecords =
                        collect(
                            $assignment
                                ->attendanceRecords
                            ?? []
                        );


                    return collect(
                        $assignment
                            ->dailyWorkLogs
                        ?? []
                    )
                        ->map(
                            function ($log) use (
                                $assignment,
                                $attendanceRecords
                            ) {

                                $log->setRelation(
                                    'reviewAssignment',
                                    $assignment
                                );


                                $attendance =
                                    $attendanceRecords
                                        ->first(
                                            fn ($record) =>
                                                (int) $record->id
                                                ===
                                                (int) (
                                                    $log
                                                        ->attendance_record_id
                                                    ?? 0
                                                )
                                        );


                                if ($attendance) {

                                    $log->setRelation(
                                        'reviewAttendance',
                                        $attendance
                                    );

                                }


                                return $log;

                            }
                        );

                }
            )
            ->sortByDesc(
                fn ($log) =>
                    $log->submitted_at
                    ?? $log->created_at
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Status Groups
    |--------------------------------------------------------------------------
    */

    $pendingWorkLogs =
        $allWorkLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string) $log->status
                    ) === 'pending'
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
    | Unique Students
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
    | Format Date
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
                            'F d, Y'
                        );

            } catch (\Throwable $exception) {

                return (string) $value;

            }

        };


    /*
    |--------------------------------------------------------------------------
    | Format Date + Time
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
    | Format Time
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
    | Rendered Time
    |--------------------------------------------------------------------------
    */

    $formatRenderedTime =
        function ($minutes) {

            $minutes =
                max(
                    0,
                    (int) $minutes
                );


            $hours =
                intdiv(
                    $minutes,
                    60
                );


            $remainder =
                $minutes % 60;


            if (
                $hours > 0
                &&
                $remainder > 0
            ) {

                return
                    $hours
                    . ' hr '
                    . $remainder
                    . ' min';

            }


            if ($hours > 0) {

                return
                    $hours
                    . (
                        $hours === 1
                            ? ' hr'
                            : ' hrs'
                    );

            }


            return
                $remainder
                . ' min';

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

                'pending' =>
                    'status-pending',

                'validated' =>
                    'status-validated',

                'rejected' =>
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
    | Action Route Resolver
    |--------------------------------------------------------------------------
    |
    | The precise route names are detected rather than hard-coded.
    |
    */

    $resolveAction =
        function (
            array $candidateNames,
            $log
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


                    $methods =
                        collect(
                            $routeObject
                                ?->methods()
                            ?? [
                                'POST',
                            ]
                        )
                            ->reject(
                                fn ($method) =>
                                    strtoupper(
                                        $method
                                    ) === 'HEAD'
                            )
                            ->values();


                    $method =
                        $methods
                            ->first(
                                fn ($method) =>
                                    strtoupper(
                                        $method
                                    ) !== 'GET'
                            )
                        ?? 'POST';


                    return [
                        'name' =>
                            $routeName,

                        'url' =>
                            route(
                                $routeName,
                                $log
                            ),

                        'method' =>
                            strtoupper(
                                $method
                            ),
                    ];

                } catch (\Throwable $exception) {

                    continue;

                }

            }


            return null;

        };


    /*
    |--------------------------------------------------------------------------
    | Validation Route Candidates
    |--------------------------------------------------------------------------
    */

    $validateRouteCandidates = [

        'supervisor.work-logs.validate',

        'supervisor.work-logs.approve',

        'supervisor.daily-work-logs.validate',

        'supervisor.daily-work-logs.approve',

        'supervisor.work-log-validations.validate',

    ];


    $rejectRouteCandidates = [

        'supervisor.work-logs.reject',

        'supervisor.daily-work-logs.reject',

        'supervisor.work-log-validations.reject',

    ];

@endphp


<div class="supervisor-work-log-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="work-log-hero">


        <div class="work-log-hero-inner">


            <div class="work-log-hero-copy">


                <div class="work-log-hero-eyebrow">


                    <span class="work-log-hero-dot"></span>


                    Supervisor Portal · Student Activity Review


                </div>


                <h1>
                    Daily Work Log Review
                </h1>


                <p class="work-log-hero-description">

                    Review Student OJT tasks, learnings,
                    challenges, additional remarks,
                    connected attendance information,
                    and Supervisor feedback before
                    validating each Daily Work Log.

                </p>


            </div>


            <div class="work-log-hero-queue">


                <span class="work-log-queue-label">
                    Waiting for Review
                </span>


                <span class="work-log-queue-value">

                    {{ $pendingWorkLogs->count() }}

                </span>


                <span class="work-log-queue-description">

                    Daily Work Log{{ $pendingWorkLogs->count() === 1 ? '' : 's' }}
                    currently waiting for your validation.

                </span>


                <div class="work-log-queue-footer">

                    {{ $studentCount }}

                    Student{{ $studentCount === 1 ? '' : 's' }}
                    under your supervision

                </div>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         REVIEW NOTICE
         ================================================================== --}}

    <section class="work-log-review-notice">


        <div class="work-log-review-notice-icon">
            i
        </div>


        <div>


            <strong>
                Review the complete Student entry before making a decision.
            </strong>


            <span>

                Check the documented tasks,
                learnings, challenges, Student remarks,
                and connected attendance information.
                Supervisor remarks should be professional,
                clear, and useful to the Student.

            </span>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="work-log-summary-grid">


        <article class="work-log-summary-card">


            <div class="work-log-summary-icon summary-purple">
                WL
            </div>


            <span class="work-log-summary-label">
                Total Work Logs
            </span>


            <span class="work-log-summary-value">

                {{ $allWorkLogs->count() }}

            </span>


            <span class="work-log-summary-note">

                All Daily Work Logs submitted
                by your assigned Students.

            </span>


        </article>


        <article class="work-log-summary-card">


            <div class="work-log-summary-icon summary-orange">
                PD
            </div>


            <span class="work-log-summary-label">
                Pending Review
            </span>


            <span class="work-log-summary-value">

                {{ $pendingWorkLogs->count() }}

            </span>


            <span class="work-log-summary-note">

                Student Work Logs waiting
                for your review.

            </span>


        </article>


        <article class="work-log-summary-card">


            <div class="work-log-summary-icon summary-green">
                ✓
            </div>


            <span class="work-log-summary-label">
                Validated Logs
            </span>


            <span class="work-log-summary-value">

                {{ $validatedWorkLogs->count() }}

            </span>


            <span class="work-log-summary-note">

                Work Logs already approved
                by the Supervisor.

            </span>


        </article>


        <article class="work-log-summary-card">


            <div class="work-log-summary-icon summary-red">
                !
            </div>


            <span class="work-log-summary-label">
                Rejected Logs
            </span>


            <span class="work-log-summary-value">

                {{ $rejectedWorkLogs->count() }}

            </span>


            <span class="work-log-summary-note">

                Student entries that
                require attention.

            </span>


        </article>


    </section>


    {{-- ==================================================================
         FILTER
         ================================================================== --}}

    @if ($allWorkLogs->isNotEmpty())


        <section class="work-log-filter">


            <div class="work-log-filter-top">


                <div>


                    <span class="work-log-filter-title">
                        Find Student Work Logs
                    </span>


                    <span class="work-log-filter-description">

                        Search by Student,
                        company, task, date,
                        or validation status.

                    </span>


                </div>


                <span
                    class="work-log-visible-count"
                    id="work-log-visible-count"
                >

                    {{ $allWorkLogs->count() }}
                    records

                </span>


            </div>


            <div class="work-log-filter-grid">


                <input
                    type="search"
                    id="work-log-search"
                    class="work-log-search"
                    placeholder="Search Student, company, task, date..."
                    autocomplete="off"
                >


                <select
                    id="work-log-status-filter"
                    class="work-log-filter-select"
                >

                    <option value="">
                        All Statuses
                    </option>


                    <option value="pending">
                        Pending
                    </option>


                    <option value="validated">
                        Validated
                    </option>


                    <option value="rejected">
                        Rejected
                    </option>


                </select>


            </div>


        </section>


    @endif


    {{-- ==================================================================
         REVIEW RECORDS
         ================================================================== --}}

    <section class="work-log-panel">


        <div class="work-log-panel-header">


            <div class="work-log-panel-heading">


                <div class="work-log-panel-icon">
                    WL
                </div>


                <div>


                    <h2>
                        Student Work Log Records
                    </h2>


                    <p>
                        Tasks, learnings, challenges, attendance, and Supervisor review
                    </p>


                </div>


            </div>


        </div>


        <div class="work-log-panel-body">


            @if ($allWorkLogs->isNotEmpty())


                <div
                    class="supervisor-work-log-list"
                    id="supervisor-work-log-list"
                >


                    @foreach ($allWorkLogs as $log)


                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | Assignment
                            |--------------------------------------------------------------------------
                            */

                            $assignment =
                                $log
                                    ->getRelation(
                                        'reviewAssignment'
                                    );


                            /*
                            |--------------------------------------------------------------------------
                            | Attendance
                            |--------------------------------------------------------------------------
                            */

                            $attendance =
                                $log
                                    ->relationLoaded(
                                        'reviewAttendance'
                                    )
                                    ? $log->getRelation(
                                        'reviewAttendance'
                                    )
                                    : null;


                            /*
                            |--------------------------------------------------------------------------
                            | Student
                            |--------------------------------------------------------------------------
                            */

                            $studentProfile =
                                $assignment
                                    ?->studentProfile;


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
                                    ?->company
                                    ?->name
                                ?? 'Company unavailable';


                            /*
                            |--------------------------------------------------------------------------
                            | Status
                            |--------------------------------------------------------------------------
                            */

                            $logStatus =
                                strtolower(
                                    (string)
                                    $log->status
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Attendance Date
                            |--------------------------------------------------------------------------
                            */

                            $attendanceDate =
                                $attendance
                                    ? (
                                        $attendance->date
                                        ?? $attendance->attendance_date
                                        ?? null
                                    )
                                    : null;


                            /*
                            |--------------------------------------------------------------------------
                            | Rendered Time
                            |--------------------------------------------------------------------------
                            */

                            $renderedMinutes =
                                (int) (
                                    $attendance
                                        ?->rendered_minutes
                                    ?? 0
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Routes
                            |--------------------------------------------------------------------------
                            */

                            $validateAction =
                                $logStatus === 'pending'
                                    ? $resolveAction(
                                        $validateRouteCandidates,
                                        $log
                                    )
                                    : null;


                            $rejectAction =
                                $logStatus === 'pending'
                                    ? $resolveAction(
                                        $rejectRouteCandidates,
                                        $log
                                    )
                                    : null;


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
                                            $studentName,
                                            $studentNumber,
                                            $companyName,
                                            $attendanceDate,
                                            $logStatus,
                                            $log->tasks,
                                            $log->learnings,
                                            $log->challenges,
                                        ]
                                    )
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Validation Metadata
                            |--------------------------------------------------------------------------
                            */

                            $validatedAt =
                                $log->validated_at
                                ?? null;


                            $reviewedByName =
                                null;


                            try {

                                $reviewedByName =
                                    data_get(
                                        $log,
                                        'validatedBy.name'
                                    )
                                    ??
                                    data_get(
                                        $log,
                                        'validator.name'
                                    );

                            } catch (\Throwable $exception) {

                                $reviewedByName =
                                    null;

                            }

                        @endphp


                        <article
                            class="supervisor-work-log-record"
                            data-work-log-record
                            data-status="{{ $logStatus }}"
                            data-search="{{ $searchText }}"
                        >


                            {{-- ==================================================
                                 HEADER
                                 ================================================== --}}

                            <div class="work-log-record-header">


                                <div class="work-log-student">


                                    <div class="work-log-student-avatar">

                                        {{ $makeInitials(
                                            $studentName
                                        ) }}

                                    </div>


                                    <div>


                                        <span class="work-log-student-name">

                                            {{ $studentName }}

                                        </span>


                                        <span class="work-log-student-meta">

                                            {{ $studentNumber }}

                                            @if (
                                                filled(
                                                    $studentProfile?->program
                                                )
                                            )

                                                ·
                                                {{ $studentProfile->program }}

                                            @endif

                                            ·
                                            {{ $companyName }}

                                        </span>


                                    </div>


                                </div>


                                <span
                                    class="
                                        work-log-status
                                        {{ $statusClass(
                                            $logStatus
                                        ) }}
                                    "
                                >

                                    {{ $statusLabel(
                                        $logStatus
                                    ) }}

                                </span>


                            </div>


                            {{-- ==================================================
                                 BODY
                                 ================================================== --}}

                            <div class="work-log-record-body">


                                {{-- ==============================================
                                     OVERVIEW
                                     ============================================== --}}

                                <div class="work-log-overview-grid">


                                    <div class="work-log-overview-item">


                                        <span class="work-log-overview-label">
                                            OJT Date
                                        </span>


                                        <span class="work-log-overview-value">

                                            {{ $formatDate(
                                                $attendanceDate
                                                ?? $log->submitted_at
                                                ?? $log->created_at
                                            ) }}

                                        </span>


                                        <span class="work-log-overview-secondary">

                                            Work Log #{{ $log->id }}

                                        </span>


                                    </div>


                                    <div class="work-log-overview-item">


                                        <span class="work-log-overview-label">
                                            Company
                                        </span>


                                        <span class="work-log-overview-value">

                                            {{ $companyName }}

                                        </span>


                                        <span class="work-log-overview-secondary">
                                            OJT placement
                                        </span>


                                    </div>


                                    <div class="work-log-overview-item">


                                        <span class="work-log-overview-label">
                                            Submitted
                                        </span>


                                        <span class="work-log-overview-value">

                                            {{ $formatDateTime(
                                                $log->submitted_at
                                                ?? $log->created_at
                                            ) }}

                                        </span>


                                    </div>


                                    <div class="work-log-overview-item">


                                        <span class="work-log-overview-label">
                                            Attendance
                                        </span>


                                        <span class="work-log-overview-value">

                                            {{ $attendance
                                                ? $statusLabel(
                                                    $attendance->status
                                                )
                                                : 'Not linked'
                                            }}

                                        </span>


                                        <span class="work-log-overview-secondary">

                                            {{ $attendance
                                                ? $formatRenderedTime(
                                                    $renderedMinutes
                                                )
                                                : 'Attendance unavailable'
                                            }}

                                        </span>


                                    </div>


                                </div>


                                {{-- ==============================================
                                     CONTENT
                                     ============================================== --}}

                                <div class="work-log-content-grid">


                                    {{-- ==========================================
                                         TASKS
                                         ========================================== --}}

                                    <section
                                        class="
                                            work-log-content-block
                                            work-log-content-full
                                        "
                                    >


                                        <div class="work-log-content-header">


                                            <div
                                                class="
                                                    work-log-content-icon
                                                    content-purple
                                                "
                                            >
                                                TK
                                            </div>


                                            <span class="work-log-content-label">
                                                Tasks & Activities Completed
                                            </span>


                                        </div>


                                        @if (
                                            filled(
                                                $log->tasks
                                            )
                                        )


                                            <div class="work-log-content-value">

                                                {{ $log->tasks }}

                                            </div>


                                        @else


                                            <div class="work-log-no-content">

                                                No task description was provided.

                                            </div>


                                        @endif


                                    </section>


                                    {{-- ==========================================
                                         LEARNINGS
                                         ========================================== --}}

                                    <section class="work-log-content-block">


                                        <div class="work-log-content-header">


                                            <div
                                                class="
                                                    work-log-content-icon
                                                    content-blue
                                                "
                                            >
                                                LR
                                            </div>


                                            <span class="work-log-content-label">
                                                Learnings & Skills Gained
                                            </span>


                                        </div>


                                        @if (
                                            filled(
                                                $log->learnings
                                            )
                                        )


                                            <div class="work-log-content-value">

                                                {{ $log->learnings }}

                                            </div>


                                        @else


                                            <div class="work-log-no-content">

                                                No learning notes were provided.

                                            </div>


                                        @endif


                                    </section>


                                    {{-- ==========================================
                                         CHALLENGES
                                         ========================================== --}}

                                    <section class="work-log-content-block">


                                        <div class="work-log-content-header">


                                            <div
                                                class="
                                                    work-log-content-icon
                                                    content-orange
                                                "
                                            >
                                                CH
                                            </div>


                                            <span class="work-log-content-label">
                                                Challenges Encountered
                                            </span>


                                        </div>


                                        @if (
                                            filled(
                                                $log->challenges
                                            )
                                        )


                                            <div class="work-log-content-value">

                                                {{ $log->challenges }}

                                            </div>


                                        @else


                                            <div class="work-log-no-content">

                                                No challenges were reported.

                                            </div>


                                        @endif


                                    </section>


                                    {{-- ==========================================
                                         STUDENT REMARKS
                                         ========================================== --}}

                                    @if (
                                        filled(
                                            $log->student_remarks
                                        )
                                    )


                                        <section
                                            class="
                                                work-log-content-block
                                                work-log-content-full
                                            "
                                        >


                                            <div class="work-log-content-header">


                                                <div
                                                    class="
                                                        work-log-content-icon
                                                        content-teal
                                                    "
                                                >
                                                    RM
                                                </div>


                                                <span class="work-log-content-label">
                                                    Additional Student Remarks
                                                </span>


                                            </div>


                                            <div class="work-log-content-value">

                                                {{ $log->student_remarks }}

                                            </div>


                                        </section>


                                    @endif


                                </div>


                                {{-- ==============================================
                                     ATTENDANCE CONNECTION
                                     ============================================== --}}

                                @if ($attendance)


                                    <section class="work-log-attendance">


                                        <span class="work-log-attendance-title">
                                            Connected Attendance Record
                                        </span>


                                        <div class="work-log-attendance-grid">


                                            <div class="work-log-attendance-item">


                                                <span class="work-log-attendance-label">
                                                    Attendance Date
                                                </span>


                                                <span class="work-log-attendance-value">

                                                    {{ $formatDate(
                                                        $attendanceDate
                                                    ) }}

                                                </span>


                                            </div>


                                            <div class="work-log-attendance-item">


                                                <span class="work-log-attendance-label">
                                                    Time In
                                                </span>


                                                <span class="work-log-attendance-value">

                                                    {{ $formatTime(
                                                        $attendance->time_in
                                                    ) }}

                                                </span>


                                            </div>


                                            <div class="work-log-attendance-item">


                                                <span class="work-log-attendance-label">
                                                    Time Out
                                                </span>


                                                <span class="work-log-attendance-value">

                                                    {{ $formatTime(
                                                        $attendance->time_out
                                                    ) }}

                                                </span>


                                            </div>


                                            <div class="work-log-attendance-item">


                                                <span class="work-log-attendance-label">
                                                    Rendered Time
                                                </span>


                                                <span class="work-log-attendance-value">

                                                    {{ $formatRenderedTime(
                                                        $renderedMinutes
                                                    ) }}

                                                </span>


                                            </div>


                                        </div>


                                    </section>


                                @endif


                                {{-- ==============================================
                                     PENDING REVIEW
                                     ============================================== --}}

                                @if ($logStatus === 'pending')


                                    <section class="work-log-review-section">


                                        <span class="work-log-review-title">
                                            Supervisor Review
                                        </span>


                                        <span class="work-log-review-description">

                                            Add a professional remark
                                            before validating or rejecting
                                            this Student Work Log.

                                        </span>


                                        <label
                                            for="supervisor-remarks-{{ $log->id }}"
                                            class="work-log-review-label"
                                        >
                                            Supervisor Remarks
                                        </label>


                                        <textarea
                                            id="supervisor-remarks-{{ $log->id }}"
                                            class="work-log-review-textarea"
                                            placeholder="Example: The tasks and learning reflections are complete and consistent with the Student's OJT activities."
                                            data-supervisor-remarks
                                            data-log-id="{{ $log->id }}"
                                        >{{ old(
                                            'supervisor_remarks',
                                            $log->supervisor_remarks
                                        ) }}</textarea>


                                        <div class="work-log-review-help">


                                            <span>

                                                Use clear feedback,
                                                especially when rejecting
                                                a Work Log.

                                            </span>


                                            <span
                                                id="remarks-counter-{{ $log->id }}"
                                            >
                                                0 characters
                                            </span>


                                        </div>


                                        <div class="work-log-actions">


                                            {{-- ==================================
                                                 REJECT
                                                 ================================== --}}

                                            @if ($rejectAction)


                                                <form
                                                    method="POST"
                                                    action="{{ $rejectAction['url'] }}"
                                                    class="work-log-action-form"
                                                    data-work-log-review-form
                                                    data-log-id="{{ $log->id }}"
                                                    data-review-action="reject"
                                                >

                                                    @csrf


                                                    @if (
                                                        $rejectAction['method']
                                                        !== 'POST'
                                                    )

                                                        <input
                                                            type="hidden"
                                                            name="_method"
                                                            value="{{ $rejectAction['method'] }}"
                                                        >

                                                    @endif


                                                    <input
                                                        type="hidden"
                                                        name="supervisor_remarks"
                                                        value=""
                                                        data-hidden-review-remarks
                                                    >


                                                    <button
                                                        type="submit"
                                                        class="
                                                            work-log-action-button
                                                            work-log-action-reject
                                                        "
                                                    >
                                                        Reject Work Log
                                                    </button>


                                                </form>


                                            @endif


                                            {{-- ==================================
                                                 VALIDATE
                                                 ================================== --}}

                                            @if ($validateAction)


                                                <form
                                                    method="POST"
                                                    action="{{ $validateAction['url'] }}"
                                                    class="work-log-action-form"
                                                    data-work-log-review-form
                                                    data-log-id="{{ $log->id }}"
                                                    data-review-action="validate"
                                                >

                                                    @csrf


                                                    @if (
                                                        $validateAction['method']
                                                        !== 'POST'
                                                    )

                                                        <input
                                                            type="hidden"
                                                            name="_method"
                                                            value="{{ $validateAction['method'] }}"
                                                        >

                                                    @endif


                                                    <input
                                                        type="hidden"
                                                        name="supervisor_remarks"
                                                        value=""
                                                        data-hidden-review-remarks
                                                    >


                                                    <button
                                                        type="submit"
                                                        class="
                                                            work-log-action-button
                                                            work-log-action-validate
                                                        "
                                                    >
                                                        Validate Work Log
                                                    </button>


                                                </form>


                                            @endif


                                        </div>


                                    </section>


                                    @if (
                                        ! $validateAction
                                        &&
                                        ! $rejectAction
                                    )


                                        <div class="work-log-route-note">

                                            This Work Log is ready for review,
                                            but the current Blade could not
                                            automatically identify the project's
                                            Validate or Reject route names.
                                            The Work Log itself has not been changed.

                                        </div>


                                    @endif


                                {{-- ==============================================
                                     REVIEWED
                                     ============================================== --}}

                                @else


                                    @if (
                                        filled(
                                            $log->supervisor_remarks
                                        )
                                    )


                                        <div class="existing-work-log-review">


                                            <span class="existing-work-log-review-label">
                                                Supervisor Remarks
                                            </span>


                                            <div class="existing-work-log-review-value">

                                                {{ $log->supervisor_remarks }}

                                            </div>


                                        </div>


                                    @endif


                                    <div class="work-log-review-meta">


                                        <span>

                                            Status:

                                            <strong>

                                                {{ $statusLabel(
                                                    $logStatus
                                                ) }}

                                            </strong>

                                        </span>


                                        @if ($reviewedByName)


                                            <span>

                                                Reviewed by:

                                                <strong>

                                                    {{ $reviewedByName }}

                                                </strong>

                                            </span>


                                        @endif


                                        @if ($validatedAt)


                                            <span>

                                                Reviewed:

                                                <strong>

                                                    {{ $formatDateTime(
                                                        $validatedAt
                                                    ) }}

                                                </strong>

                                            </span>


                                        @endif


                                    </div>


                                @endif


                            </div>


                        </article>


                    @endforeach


                </div>


                <div
                    class="work-log-filter-empty"
                    id="work-log-filter-empty"
                >

                    No Daily Work Logs match
                    your current search or status filter.

                </div>


            @else


                <div class="work-log-empty">


                    <div class="work-log-empty-icon">
                        WL
                    </div>


                    <h3>
                        No Daily Work Logs Available
                    </h3>


                    <p>

                        Daily Work Logs submitted by
                        Students assigned to you will
                        appear here for Supervisor
                        review and validation.

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

            /* ============================================================
               SEARCH + FILTER
               ============================================================ */

            const searchInput =
                document.getElementById(
                    'work-log-search'
                );


            const statusFilter =
                document.getElementById(
                    'work-log-status-filter'
                );


            const records =
                Array.from(
                    document.querySelectorAll(
                        '[data-work-log-record]'
                    )
                );


            const visibleCount =
                document.getElementById(
                    'work-log-visible-count'
                );


            const emptyMessage =
                document.getElementById(
                    'work-log-filter-empty'
                );


            const applyFilter =
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


                    const status =
                        statusFilter
                            ? statusFilter
                                .value
                                .trim()
                                .toLowerCase()
                            : '';


                    let count = 0;


                    records.forEach(
                        function (record) {

                            const searchableText =
                                (
                                    record.dataset.search
                                    || ''
                                )
                                    .toLowerCase();


                            const recordStatus =
                                (
                                    record.dataset.status
                                    || ''
                                )
                                    .toLowerCase();


                            const matchesSearch =
                                ! search
                                ||
                                searchableText.includes(
                                    search
                                );


                            const matchesStatus =
                                ! status
                                ||
                                recordStatus
                                === status;


                            const show =
                                matchesSearch
                                &&
                                matchesStatus;


                            record.style.display =
                                show
                                    ? ''
                                    : 'none';


                            if (show) {
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
                                    ? ' record'
                                    : ' records'
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
                    applyFilter
                );

            }


            if (statusFilter) {

                statusFilter.addEventListener(
                    'change',
                    applyFilter
                );

            }


            /* ============================================================
               REMARK COUNTERS
               ============================================================ */

            const remarkFields =
                document.querySelectorAll(
                    '[data-supervisor-remarks]'
                );


            remarkFields.forEach(
                function (field) {

                    const logId =
                        field.dataset.logId;


                    const counter =
                        document.getElementById(
                            'remarks-counter-'
                            + logId
                        );


                    const updateCounter =
                        function () {

                            if (! counter) {
                                return;
                            }


                            const length =
                                field.value.length;


                            counter.textContent =
                                length
                                +
                                (
                                    length === 1
                                        ? ' character'
                                        : ' characters'
                                );

                        };


                    field.addEventListener(
                        'input',
                        updateCounter
                    );


                    updateCounter();

                }
            );


            /* ============================================================
               COPY REMARKS + CONFIRM REVIEW
               ============================================================ */

            const reviewForms =
                document.querySelectorAll(
                    '[data-work-log-review-form]'
                );


            reviewForms.forEach(
                function (form) {

                    form.addEventListener(
                        'submit',
                        function (event) {

                            const logId =
                                form.dataset.logId;


                            const action =
                                form.dataset.reviewAction;


                            const visibleRemarks =
                                document.getElementById(
                                    'supervisor-remarks-'
                                    + logId
                                );


                            const hiddenRemarks =
                                form.querySelector(
                                    '[data-hidden-review-remarks]'
                                );


                            if (
                                visibleRemarks
                                &&
                                hiddenRemarks
                            ) {

                                hiddenRemarks.value =
                                    visibleRemarks.value;

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Reject Requires Clear Feedback
                            |--------------------------------------------------------------------------
                            */

                            if (
                                action === 'reject'
                                &&
                                visibleRemarks
                                &&
                                visibleRemarks.value.trim() === ''
                            ) {

                                event.preventDefault();


                                alert(
                                    'Please provide a Supervisor remark explaining why this Work Log is being rejected.'
                                );


                                visibleRemarks.focus();


                                return;

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Confirmation
                            |--------------------------------------------------------------------------
                            */

                            const message =
                                action === 'reject'
                                    ? 'Reject this Daily Work Log?'
                                    : 'Validate this Daily Work Log?';


                            if (
                                ! window.confirm(
                                    message
                                )
                            ) {

                                event.preventDefault();

                                return;

                            }


                            const button =
                                form.querySelector(
                                    'button[type="submit"]'
                                );


                            if (button) {

                                button.disabled = true;


                                button.textContent =
                                    action === 'reject'
                                        ? 'Rejecting Work Log...'
                                        : 'Validating Work Log...';

                            }

                        }
                    );

                }
            );

        }
    );

</script>

@endpush