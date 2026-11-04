@extends('layouts.app')


@section('title', 'Daily Work Logs | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC - STUDENT DAILY WORK LOGS
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --wl-navy: #183B6B;
        --wl-navy-dark: #102A4A;

        --wl-blue: #2563EB;
        --wl-blue-soft: #EAF2FF;

        --wl-green: #15803D;
        --wl-green-soft: #EAF8EF;

        --wl-teal: #0F766E;
        --wl-teal-soft: #E7F7F5;

        --wl-orange: #B45309;
        --wl-orange-soft: #FFF5E6;

        --wl-red: #B42318;
        --wl-red-soft: #FFF0EE;

        --wl-purple: #6D4FC2;
        --wl-purple-soft: #F2EEFF;

        --wl-slate: #475569;
        --wl-slate-soft: #F1F5F9;

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

    .student-work-logs-page {
        width: 100%;

        color:
            var(--wl-text);

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
                circle at 89% 15%,
                rgba(167, 139, 250, 0.17),
                transparent 24%
            ),
            radial-gradient(
                circle at 69% 87%,
                rgba(45, 212, 191, 0.14),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 54%,
                #205F79 100%
            );

        box-shadow:
            var(--wl-shadow-large);
    }


    .work-log-hero::before {
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


    .work-log-hero::after {
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

        max-width: 760px;
    }


    .work-log-eyebrow {
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


    .work-log-eyebrow-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background: #A78BFA;

        box-shadow:
            0 0 0 5px
            rgba(167, 139, 250, 0.13);
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

        letter-spacing: -0.55px;
    }


    .work-log-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO PLACEMENT
       ================================================================ */

    .work-log-placement-card {
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


    .work-log-placement-label {
        display: block;

        margin-bottom: 6px;

        color:
            rgba(255, 255, 255, 0.67);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: 0.4px;
    }


    .work-log-placement-company {
        display: block;

        color: #FFFFFF;

        font-size: 20px;
        font-weight: 900;

        line-height: 1.4;
    }


    .work-log-placement-supervisor {
        display: block;

        margin-top: 7px;

        color:
            rgba(255, 255, 255, 0.78);

        font-size: 15px;

        line-height: 1.55;
    }


    .work-log-placement-footer {
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


    .work-log-placement-status {
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


    .work-log-placement-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;

        background: #2DD4BF;
    }


    .work-log-placement-hours {
        color:
            rgba(255, 255, 255, 0.80);

        font-size: 13px;
        font-weight: 750;
    }


    /* ================================================================
       ASSIGNMENT SELECTOR
       ================================================================ */

    .work-log-selector {
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
            var(--wl-border);

        border-radius: 17px;

        background:
            var(--wl-white);

        box-shadow:
            var(--wl-shadow);
    }


    .work-log-selector-title {
        display: block;

        margin-bottom: 4px;

        color:
            var(--wl-text);

        font-size: 17px;
        font-weight: 850;
    }


    .work-log-selector-description {
        display: block;

        color:
            var(--wl-body);

        font-size: 15px;

        line-height: 1.55;
    }


    .work-log-selector-form {
        min-width: 340px;
    }


    .work-log-selector-select {
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
            var(--wl-text);

        font-family: inherit;

        font-size: 15px;
        font-weight: 750;

        cursor: pointer;
    }


    .work-log-selector-select:focus {
        border-color:
            var(--wl-blue);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, 0.09);
    }


    /* ================================================================
       SUMMARY
       ================================================================ */

    .work-log-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 19px;

        margin-bottom: 29px;
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
       MAIN LAYOUT
       ================================================================ */

    .work-log-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1.35fr)
            minmax(350px, 0.65fr);

        gap: 23px;

        align-items: start;
    }


    .work-log-main,
    .work-log-sidebar {
        display: grid;

        gap: 23px;
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

        font-size: 13px;
        font-weight: 900;
    }


    .panel-purple {
        background:
            var(--wl-purple-soft);

        color:
            var(--wl-purple);
    }


    .panel-blue {
        background:
            var(--wl-blue-soft);

        color:
            var(--wl-blue);
    }


    .panel-green {
        background:
            var(--wl-green-soft);

        color:
            var(--wl-green);
    }


    .panel-orange {
        background:
            var(--wl-orange-soft);

        color:
            var(--wl-orange);
    }


    .panel-teal {
        background:
            var(--wl-teal-soft);

        color:
            var(--wl-teal);
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
        padding: 26px;
    }


    /* ================================================================
       FORM INTRODUCTION
       ================================================================ */

    .work-log-form-intro {
        margin-bottom: 22px;

        padding:
            18px
            19px;

        border:
            1px solid
            #DAD3F3;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #FBFAFF 0%,
                #F5F1FF 100%
            );
    }


    .work-log-form-intro strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--wl-text);

        font-size: 17px;
        font-weight: 850;
    }


    .work-log-form-intro span {
        color:
            var(--wl-body);

        font-size: 15px;

        line-height: 1.65;
    }


    /* ================================================================
       FORM
       ================================================================ */

    .work-log-form-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            21px
            18px;
    }


    .work-log-field {
        min-width: 0;
    }


    .work-log-field-full {
        grid-column:
            1 / -1;
    }


    .work-log-label {
        display: flex;
        align-items: center;

        gap: 7px;

        margin-bottom: 9px;

        color:
            var(--wl-text);

        font-size: 15px;
        font-weight: 850;
    }


    .work-log-required {
        color:
            var(--wl-red);

        font-weight: 900;
    }


    .work-log-optional {
        color:
            var(--wl-muted);

        font-size: 13px;
        font-weight: 700;
    }


    .work-log-select,
    .work-log-textarea {
        width: 100%;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background:
            #FBFDFF;

        color:
            var(--wl-text);

        font-family:
            "Segoe UI",
            Arial,
            sans-serif;

        font-size: 17px;
        font-weight: 600;

        transition:
            var(--wl-transition);
    }


    .work-log-select {
        min-height: 56px;

        padding:
            0
            15px;

        cursor: pointer;
    }


    .work-log-textarea {
        min-height: 145px;

        padding:
            15px
            16px;

        resize: vertical;

        line-height: 1.65;
    }


    .work-log-textarea-large {
        min-height: 175px;
    }


    .work-log-select:focus,
    .work-log-textarea:focus {
        border-color:
            var(--wl-purple);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(109, 79, 194, 0.09);
    }


    .work-log-textarea::placeholder {
        color:
            #8A9AAB;
    }


    .work-log-help {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        margin-top: 8px;

        color:
            var(--wl-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .work-log-character-count {
        flex-shrink: 0;

        font-weight: 750;
    }


    .work-log-field-error {
        display: block;

        margin-top: 7px;

        color:
            var(--wl-red);

        font-size: 14px;
        font-weight: 750;
    }


    /* ================================================================
       FORM ACTION
       ================================================================ */

    .work-log-submit-area {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-top: 24px;

        padding-top: 22px;

        border-top:
            1px solid
            var(--wl-border-soft);
    }


    .work-log-submit-note {
        max-width: 520px;

        color:
            var(--wl-muted);

        font-size: 14px;

        line-height: 1.6;
    }


    .work-log-submit-button {
        min-width: 210px;
        min-height: 54px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            20px;

        border:
            1px solid
            var(--wl-purple);

        border-radius: 13px;

        background:
            var(--wl-purple);

        color: #FFFFFF;

        cursor: pointer;

        font-family: inherit;

        font-size: 16px;
        font-weight: 900;

        transition:
            var(--wl-transition);
    }


    .work-log-submit-button:hover {
        transform:
            translateY(-1px);

        box-shadow:
            0 12px 25px
            rgba(109, 79, 194, 0.18);
    }


    /* ================================================================
       STATUS BADGES
       ================================================================ */

    .work-log-status {
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


    .work-log-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
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


    .status-draft,
    .status-default {
        background:
            var(--wl-slate-soft);

        color:
            var(--wl-slate);
    }


    .status-draft::before,
    .status-default::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       WORK LOG RECORD
       ================================================================ */

    .work-log-records {
        display: grid;

        gap: 18px;
    }


    .work-log-record {
        overflow: hidden;

        border:
            1px solid
            var(--wl-border);

        border-radius: 17px;

        background:
            #FFFFFF;

        transition:
            var(--wl-transition);
    }


    .work-log-record:hover {
        border-color:
            #C3D2E1;

        box-shadow:
            0 12px 26px
            rgba(15, 42, 74, 0.07);
    }


    .work-log-record-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            18px
            20px;

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


    .work-log-record-date {
        display: block;

        margin-bottom: 3px;

        color:
            var(--wl-text);

        font-size: 18px;
        font-weight: 900;
    }


    .work-log-record-meta {
        color:
            var(--wl-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .work-log-record-body {
        padding: 21px;
    }


    .work-log-content-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 15px;
    }


    .work-log-content-block {
        padding:
            17px;

        border:
            1px solid
            var(--wl-border-soft);

        border-radius: 13px;

        background:
            var(--wl-soft);
    }


    .work-log-content-full {
        grid-column:
            1 / -1;
    }


    .work-log-content-label {
        display: flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 8px;

        color:
            var(--wl-muted);

        font-size: 14px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: 0.3px;
    }


    .work-log-content-value {
        color:
            var(--wl-text);

        font-size: 16px;

        line-height: 1.75;

        white-space: pre-line;

        word-break: break-word;
    }


    .work-log-content-value strong {
        font-weight: 850;
    }


    /* ================================================================
       SUPERVISOR FEEDBACK
       ================================================================ */

    .supervisor-feedback {
        margin-top: 15px;

        padding:
            17px
            18px;

        border:
            1px solid
            #CEE2D6;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #F8FCFA 0%,
                #EFF9F3 100%
            );
    }


    .supervisor-feedback.rejected-feedback {
        border-color:
            #ECCBC6;

        background:
            var(--wl-red-soft);
    }


    .supervisor-feedback-label {
        display: block;

        margin-bottom: 6px;

        color:
            var(--wl-green);

        font-size: 14px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .rejected-feedback .supervisor-feedback-label {
        color:
            var(--wl-red);
    }


    .supervisor-feedback-value {
        color:
            var(--wl-text);

        font-size: 16px;

        line-height: 1.7;
    }


    /* ================================================================
       RECORD FOOTER
       ================================================================ */

    .work-log-record-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-top: 17px;

        padding-top: 16px;

        border-top:
            1px solid
            var(--wl-border-soft);
    }


    .work-log-submitted-at {
        color:
            var(--wl-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .work-log-record-actions {
        display: flex;
        align-items: center;

        gap: 9px;
    }


    .work-log-record-button {
        min-height: 42px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            13px;

        border:
            1px solid
            var(--wl-border);

        border-radius: 10px;

        background: #FFFFFF;

        color:
            var(--wl-navy);

        text-decoration: none;

        font-size: 14px;
        font-weight: 850;

        transition:
            var(--wl-transition);
    }


    .work-log-record-button:hover {
        background:
            var(--wl-blue-soft);

        border-color:
            #B8CADD;
    }


    /* ================================================================
       SIDEBAR
       ================================================================ */

    .work-log-sidebar-list {
        display: grid;

        gap: 12px;
    }


    .work-log-sidebar-item {
        padding:
            14px
            15px;

        border:
            1px solid
            var(--wl-border-soft);

        border-radius: 12px;

        background:
            var(--wl-soft);
    }


    .work-log-sidebar-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--wl-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: 0.3px;
    }


    .work-log-sidebar-value {
        display: block;

        color:
            var(--wl-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.55;

        word-break: break-word;
    }


    /* ================================================================
       GUIDE
       ================================================================ */

    .work-log-guide {
        display: grid;

        gap: 16px;
    }


    .work-log-guide-item {
        display: flex;
        align-items: flex-start;

        gap: 12px;
    }


    .work-log-guide-number {
        width: 36px;
        height: 36px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background:
            var(--wl-purple-soft);

        color:
            var(--wl-purple);

        font-size: 13px;
        font-weight: 900;
    }


    .work-log-guide-title {
        display: block;

        margin-bottom: 3px;

        color:
            var(--wl-text);

        font-size: 15px;
        font-weight: 850;
    }


    .work-log-guide-description {
        display: block;

        color:
            var(--wl-body);

        font-size: 14px;

        line-height: 1.6;
    }


    /* ================================================================
       QUICK LINKS
       ================================================================ */

    .work-log-links {
        display: grid;

        gap: 11px;
    }


    .work-log-link {
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
            var(--wl-border);

        border-radius: 12px;

        background:
            #FFFFFF;

        color:
            var(--wl-navy);

        text-decoration: none;

        font-size: 15px;
        font-weight: 850;

        transition:
            var(--wl-transition);
    }


    .work-log-link:hover {
        transform:
            translateY(-1px);

        background:
            var(--wl-blue-soft);

        border-color:
            #B8CADC;
    }


    /* ================================================================
       INFO NOTE
       ================================================================ */

    .work-log-info-note {
        padding: 16px;

        border:
            1px solid
            #D5E4F2;

        border-radius: 13px;

        background:
            #F5FAFE;

        color:
            var(--wl-body);

        font-size: 15px;

        line-height: 1.7;
    }


    .work-log-info-note strong {
        color:
            var(--wl-text);
    }


    /* ================================================================
       PAGINATION
       ================================================================ */

    .work-log-pagination {
        margin-top: 21px;

        padding-top: 20px;

        border-top:
            1px solid
            var(--wl-border-soft);
    }


    /* ================================================================
       EMPTY
       ================================================================ */

    .work-log-empty {
        padding:
            45px
            24px;

        text-align: center;
    }


    .work-log-empty-icon {
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
            var(--wl-purple-soft);

        color:
            var(--wl-purple);

        font-size: 16px;
        font-weight: 900;
    }


    .work-log-empty h3 {
        margin:
            0
            0
            8px;

        color:
            var(--wl-text);

        font-size: 21px;
        font-weight: 850;
    }


    .work-log-empty p {
        max-width: 560px;

        margin:
            0
            auto;

        color:
            var(--wl-body);

        font-size: 15px;

        line-height: 1.7;
    }


    /* ================================================================
       ERRORS
       ================================================================ */

    .work-log-errors {
        margin-bottom: 24px;

        padding:
            18px
            20px;

        border:
            1px solid
            #EDC6C1;

        border-radius: 15px;

        background:
            var(--wl-red-soft);

        color:
            var(--wl-red);
    }


    .work-log-errors strong {
        display: block;

        margin-bottom: 7px;

        font-size: 16px;
        font-weight: 850;
    }


    .work-log-errors ul {
        margin: 0;

        padding-left: 22px;

        font-size: 15px;

        line-height: 1.7;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1150px) {

        .work-log-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .work-log-layout {
            grid-template-columns: 1fr;
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


        .work-log-placement-card {
            width: 100%;
        }


        .work-log-selector {
            flex-direction: column;

            align-items: stretch;
        }


        .work-log-selector-form {
            min-width: 0;

            width: 100%;
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
        .work-log-form-grid,
        .work-log-content-grid {
            grid-template-columns: 1fr;
        }


        .work-log-field-full,
        .work-log-content-full {
            grid-column: auto;
        }


        .work-log-panel-header,
        .work-log-panel-body {
            padding-left: 20px;
            padding-right: 20px;
        }


        .work-log-panel-heading h2 {
            font-size: 21px;
        }


        .work-log-submit-area,
        .work-log-record-header,
        .work-log-record-footer {
            flex-direction: column;

            align-items: stretch;
        }


        .work-log-submit-button {
            width: 100%;
        }


        .work-log-record-actions {
            width: 100%;
        }


        .work-log-record-button {
            flex: 1;
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
    | Assignment Collection
    |--------------------------------------------------------------------------
    */

    $assignments =
        $studentProfile
            ? collect(
                $studentProfile->ojtAssignments
                ?? []
            )
                ->sortByDesc(
                    'start_date'
                )
                ->values()
            : collect();


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
            ? $assignments
                ->first(
                    fn ($item) =>
                        (int) $item->id
                        ===
                        $requestedAssignmentId
                )
            : null;


    /*
    |--------------------------------------------------------------------------
    | Display Assignment
    |--------------------------------------------------------------------------
    */

    $selectedAssignment =
        $assignment
        ?? $displayAssignment
        ?? $requestedAssignment
        ?? $activeAssignment
        ?? $assignments
            ->first(
                fn ($item) =>
                    strtolower(
                        (string) $item->status
                    ) === 'active'
            )
        ?? $assignments->first();


    /*
    |--------------------------------------------------------------------------
    | Load Known Relationships
    |--------------------------------------------------------------------------
    */

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
    | Assignment State
    |--------------------------------------------------------------------------
    */

    $assignmentStatus =
        $selectedAssignment
            ? strtolower(
                (string)
                $selectedAssignment->status
            )
            : null;


    $isActiveAssignment =
        $assignmentStatus === 'active';


    $isCompletedAssignment =
        $assignmentStatus === 'completed';


    /*
    |--------------------------------------------------------------------------
    | Controller Work Log Records
    |--------------------------------------------------------------------------
    |
    | Preserve a paginator if the existing controller sends $logs.
    |
    */

    $workLogRecords =
        $logs
        ?? $workLogs
        ?? collect(
            $selectedAssignment
                ?->dailyWorkLogs
            ?? []
        );


    $pageWorkLogs =
        method_exists(
            $workLogRecords,
            'getCollection'
        )
            ? $workLogRecords->getCollection()
            : collect(
                $workLogRecords
            );


    /*
    |--------------------------------------------------------------------------
    | All Work Logs for Summary
    |--------------------------------------------------------------------------
    */

    $allWorkLogs =
        $selectedAssignment
            ? collect(
                $selectedAssignment
                    ->dailyWorkLogs
                ?? []
            )
            : $pageWorkLogs;


    /*
    |--------------------------------------------------------------------------
    | Status Summary
    |--------------------------------------------------------------------------
    */

    $validatedWorkLogs =
        $allWorkLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string) $log->status
                    ) === 'validated'
            );


    $pendingWorkLogs =
        $allWorkLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string) $log->status
                    ) === 'pending'
            );


    $rejectedWorkLogs =
        $allWorkLogs
            ->filter(
                fn ($log) =>
                    strtolower(
                        (string) $log->status
                    ) === 'rejected'
            );


    /*
    |--------------------------------------------------------------------------
    | Attendance Records
    |--------------------------------------------------------------------------
    */

    $attendanceRecords =
        $selectedAssignment
            ? collect(
                $selectedAssignment
                    ->attendanceRecords
                ?? []
            )
                ->sortByDesc(
                    'attendance_date'
                )
                ->values()
            : collect();


    /*
    |--------------------------------------------------------------------------
    | Eligible Attendance
    |--------------------------------------------------------------------------
    |
    | A completed attendance record without a linked Daily Work Log
    | is shown as available for submission.
    |
    */

    $loggedAttendanceIds =
        $allWorkLogs
            ->pluck(
                'attendance_record_id'
            )
            ->filter()
            ->map(
                fn ($id) =>
                    (int) $id
            )
            ->values();


    $eligibleAttendanceRecords =
        $attendanceRecords
            ->filter(
                function ($attendance) use (
                    $loggedAttendanceIds
                ) {

                    $hasTimeOut =
                        $attendance->time_out
                        !== null;


                    $alreadyLogged =
                        $loggedAttendanceIds
                            ->contains(
                                (int) $attendance->id
                            );


                    return
                        $hasTimeOut
                        &&
                        ! $alreadyLogged;

                }
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    */

    $indexUrl =
        \Illuminate\Support\Facades\Route::has(
            'student.work-logs.index'
        )
            ? route(
                'student.work-logs.index'
            )
            : url(
                '/student/work-logs'
            );


    $storeRouteName =
        collect([
            'student.work-logs.store',
            'student.daily-work-logs.store',
        ])
            ->first(
                fn ($name) =>
                    \Illuminate\Support\Facades\Route::has(
                        $name
                    )
            );


    $storeUrl =
        $storeRouteName
            ? route(
                $storeRouteName
            )
            : url(
                '/student/work-logs'
            );


    $editRouteName =
        collect([
            'student.work-logs.edit',
            'student.daily-work-logs.edit',
        ])
            ->first(
                fn ($name) =>
                    \Illuminate\Support\Facades\Route::has(
                        $name
                    )
            );


    $showRouteName =
        collect([
            'student.work-logs.show',
            'student.daily-work-logs.show',
        ])
            ->first(
                fn ($name) =>
                    \Illuminate\Support\Facades\Route::has(
                        $name
                    )
            );


    /*
    |--------------------------------------------------------------------------
    | Format Date
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
                            'F d, Y'
                        );

            } catch (\Throwable $exception) {

                return (string) $value;

            }

        };


    /*
    |--------------------------------------------------------------------------
    | Format Date Time
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
    | Status
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

                'draft' =>
                    'status-draft',

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
    | Find Attendance Record
    |--------------------------------------------------------------------------
    */

    $findAttendance =
        function ($log) use (
            $attendanceRecords
        ) {

            return $attendanceRecords
                ->first(
                    fn ($attendance) =>
                        (int) $attendance->id
                        ===
                        (int) (
                            $log->attendance_record_id
                            ?? 0
                        )
                );

        };

@endphp


<div class="student-work-logs-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="work-log-hero">


        <div class="work-log-hero-inner">


            <div class="work-log-hero-copy">


                <div class="work-log-eyebrow">


                    <span class="work-log-eyebrow-dot"></span>


                    Student Portal · OJT Activity Journal


                </div>


                <h1>
                    Daily Work Logs
                </h1>


                <p class="work-log-hero-description">

                    Document the tasks you completed,
                    what you learned, challenges you encountered,
                    and important observations from your daily
                    OJT experience. Submitted Work Logs are
                    reviewed by your assigned Supervisor.

                </p>


            </div>


            <div class="work-log-placement-card">


                <span class="work-log-placement-label">
                    Selected OJT Placement
                </span>


                <span class="work-log-placement-company">

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


                <span class="work-log-placement-supervisor">


                    @if ($selectedAssignment)

                        Supervisor:

                        {{ $selectedAssignment
                            ->supervisor
                            ?->name
                            ?? 'Not assigned'
                        }}

                    @else

                        Your Work Logs become available
                        after an OJT Assignment is created.

                    @endif


                </span>


                @if ($selectedAssignment)


                    <div class="work-log-placement-footer">


                        <span class="work-log-placement-status">

                            {{ ucfirst(
                                $assignmentStatus
                            ) }}

                        </span>


                        <span class="work-log-placement-hours">

                            {{ number_format(
                                (float)
                                $selectedAssignment->required_hours
                            ) }}

                            required hrs

                        </span>


                    </div>


                @endif


            </div>


        </div>


    </section>


    {{-- ==================================================================
         ERRORS
         ================================================================== --}}

    @if ($errors->any())


        <section class="work-log-errors">


            <strong>
                Your Daily Work Log could not be submitted.
            </strong>


            <ul>

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>


        </section>


    @endif


    {{-- ==================================================================
         ASSIGNMENT SELECTOR
         ================================================================== --}}

    @if ($assignments->count() > 1)


        <section class="work-log-selector">


            <div>


                <span class="work-log-selector-title">
                    Choose an OJT Assignment
                </span>


                <span class="work-log-selector-description">

                    Review Work Logs from your current
                    or previous OJT placements.

                </span>


            </div>


            <form
                method="GET"
                action="{{ $indexUrl }}"
                class="work-log-selector-form"
            >


                <select
                    name="assignment"
                    class="work-log-selector-select"
                    onchange="this.form.submit()"
                >


                    @foreach ($assignments as $assignmentOption)


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

                Daily activity records
                for this OJT placement.

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

                Approved by your
                assigned Supervisor.

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

                Submitted logs waiting
                for Supervisor review.

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

                Records that may require
                your attention.

            </span>


        </article>


    </section>


    {{-- ==================================================================
         MAIN LAYOUT
         ================================================================== --}}

    <div class="work-log-layout">


        {{-- ==============================================================
             MAIN
             ============================================================== --}}

        <main class="work-log-main">


            {{-- ==========================================================
                 NEW WORK LOG
                 ========================================================== --}}

            <section class="work-log-panel">


                <div class="work-log-panel-header">


                    <div class="work-log-panel-heading">


                        <div class="work-log-panel-icon panel-purple">
                            +
                        </div>


                        <div>


                            <h2>
                                Create Daily Work Log
                            </h2>


                            <p>
                                Record your tasks and learning experience
                            </p>


                        </div>


                    </div>


                </div>


                <div class="work-log-panel-body">


                    @if (! $selectedAssignment)


                        <div class="work-log-empty">


                            <div class="work-log-empty-icon">
                                OJ
                            </div>


                            <h3>
                                No OJT Assignment Available
                            </h3>


                            <p>

                                A Work Log can only be created
                                when you have an active OJT placement.

                            </p>


                        </div>


                    @elseif (! $isActiveAssignment)


                        <div class="work-log-info-note">

                            <strong>
                                This assignment is read-only.
                            </strong>

                            Its current status is

                            <strong>
                                {{ ucfirst($assignmentStatus) }}
                            </strong>.

                            You can still review existing Work Logs,
                            but new entries are only created for
                            an active OJT Assignment.

                        </div>


                    @elseif ($eligibleAttendanceRecords->isEmpty())


                        <div class="work-log-empty">


                            <div class="work-log-empty-icon">
                                WL
                            </div>


                            <h3>
                                No Attendance Ready for a Work Log
                            </h3>


                            <p>

                                Complete your daily Time In and
                                Time Out first. Once a completed
                                attendance record is available
                                without an existing Work Log,
                                you can document your activities here.

                            </p>


                        </div>


                    @else


                        <div class="work-log-form-intro">


                            <strong>
                                Describe your actual OJT experience for the selected day.
                            </strong>


                            <span>

                                Write clearly and professionally.
                                Focus on the tasks you performed,
                                the knowledge or skills you gained,
                                and any challenges you encountered.

                            </span>


                        </div>


                        <form
                            method="POST"
                            action="{{ $storeUrl }}"
                            id="daily-work-log-form"
                        >

                            @csrf


                            <div class="work-log-form-grid">


                                {{-- ======================================
                                     ATTENDANCE DATE
                                     ====================================== --}}

                                <div
                                    class="
                                        work-log-field
                                        work-log-field-full
                                    "
                                >


                                    <label
                                        for="attendance_record_id"
                                        class="work-log-label"
                                    >

                                        Attendance Date

                                        <span class="work-log-required">
                                            *
                                        </span>

                                    </label>


                                    <select
                                        id="attendance_record_id"
                                        name="attendance_record_id"
                                        class="work-log-select"
                                        required
                                    >


                                        <option value="">
                                            Select completed attendance
                                        </option>


                                        @foreach (
                                            $eligibleAttendanceRecords
                                            as $attendance
                                        )


                                            <option
                                                value="{{ $attendance->id }}"
                                                @selected(
                                                    (int) old(
                                                        'attendance_record_id'
                                                    )
                                                    ===
                                                    (int) $attendance->id
                                                )
                                            >

                                                {{ $formatDate(
                                                    $attendance
                                                        ->attendance_date
                                                ) }}

                                                —

                                                {{ $attendance->time_in
                                                    ? \Illuminate\Support\Carbon::parse(
                                                        $attendance->time_in
                                                    )
                                                        ->timezone('Asia/Manila')
                                                        ->format('h:i A')
                                                    : '—'
                                                }}

                                                to

                                                {{ $attendance->time_out
                                                    ? \Illuminate\Support\Carbon::parse(
                                                        $attendance->time_out
                                                    )
                                                        ->timezone('Asia/Manila')
                                                        ->format('h:i A')
                                                    : '—'
                                                }}

                                            </option>


                                        @endforeach


                                    </select>


                                    <span class="work-log-help">

                                        Select the attendance record
                                        connected to this day's activities.

                                    </span>


                                    @error('attendance_record_id')

                                        <span class="work-log-field-error">
                                            {{ $message }}
                                        </span>

                                    @enderror


                                </div>


                                {{-- ======================================
                                     TASKS
                                     ====================================== --}}

                                <div
                                    class="
                                        work-log-field
                                        work-log-field-full
                                    "
                                >


                                    <label
                                        for="tasks"
                                        class="work-log-label"
                                    >

                                        Tasks and Activities Completed

                                        <span class="work-log-required">
                                            *
                                        </span>

                                    </label>


                                    <textarea
                                        id="tasks"
                                        name="tasks"
                                        class="
                                            work-log-textarea
                                            work-log-textarea-large
                                        "
                                        placeholder="Example: Assisted in computer troubleshooting, installed required software, organized technical documents, and helped configure office workstations."
                                        required
                                        data-counter="tasks-count"
                                    >{{ old('tasks') }}</textarea>


                                    <div class="work-log-help">


                                        <span>

                                            Describe the actual work
                                            you completed during the day.

                                        </span>


                                        <span
                                            id="tasks-count"
                                            class="work-log-character-count"
                                        >
                                            0 characters
                                        </span>


                                    </div>


                                    @error('tasks')

                                        <span class="work-log-field-error">
                                            {{ $message }}
                                        </span>

                                    @enderror


                                </div>


                                {{-- ======================================
                                     LEARNINGS
                                     ====================================== --}}

                                <div class="work-log-field">


                                    <label
                                        for="learnings"
                                        class="work-log-label"
                                    >

                                        Learnings and Skills Gained

                                        <span class="work-log-optional">
                                            Optional
                                        </span>

                                    </label>


                                    <textarea
                                        id="learnings"
                                        name="learnings"
                                        class="work-log-textarea"
                                        placeholder="What new knowledge, skill, or workplace practice did you learn today?"
                                        data-counter="learnings-count"
                                    >{{ old('learnings') }}</textarea>


                                    <div class="work-log-help">


                                        <span>
                                            Explain what you learned.
                                        </span>


                                        <span
                                            id="learnings-count"
                                            class="work-log-character-count"
                                        >
                                            0 characters
                                        </span>


                                    </div>


                                    @error('learnings')

                                        <span class="work-log-field-error">
                                            {{ $message }}
                                        </span>

                                    @enderror


                                </div>


                                {{-- ======================================
                                     CHALLENGES
                                     ====================================== --}}

                                <div class="work-log-field">


                                    <label
                                        for="challenges"
                                        class="work-log-label"
                                    >

                                        Challenges Encountered

                                        <span class="work-log-optional">
                                            Optional
                                        </span>

                                    </label>


                                    <textarea
                                        id="challenges"
                                        name="challenges"
                                        class="work-log-textarea"
                                        placeholder="Describe any problem, difficulty, or challenge you encountered and how you handled it."
                                        data-counter="challenges-count"
                                    >{{ old('challenges') }}</textarea>


                                    <div class="work-log-help">


                                        <span>
                                            Mention challenges when applicable.
                                        </span>


                                        <span
                                            id="challenges-count"
                                            class="work-log-character-count"
                                        >
                                            0 characters
                                        </span>


                                    </div>


                                    @error('challenges')

                                        <span class="work-log-field-error">
                                            {{ $message }}
                                        </span>

                                    @enderror


                                </div>


                                {{-- ======================================
                                     STUDENT REMARKS
                                     ====================================== --}}

                                <div
                                    class="
                                        work-log-field
                                        work-log-field-full
                                    "
                                >


                                    <label
                                        for="student_remarks"
                                        class="work-log-label"
                                    >

                                        Additional Student Remarks

                                        <span class="work-log-optional">
                                            Optional
                                        </span>

                                    </label>


                                    <textarea
                                        id="student_remarks"
                                        name="student_remarks"
                                        class="work-log-textarea"
                                        placeholder="Add any other important observation or information about today's OJT experience."
                                        data-counter="remarks-count"
                                    >{{ old('student_remarks') }}</textarea>


                                    <div class="work-log-help">


                                        <span>

                                            Use this only for information
                                            not already covered above.

                                        </span>


                                        <span
                                            id="remarks-count"
                                            class="work-log-character-count"
                                        >
                                            0 characters
                                        </span>


                                    </div>


                                    @error('student_remarks')

                                        <span class="work-log-field-error">
                                            {{ $message }}
                                        </span>

                                    @enderror


                                </div>


                            </div>


                            <div class="work-log-submit-area">


                                <div class="work-log-submit-note">

                                    After submission, your Work Log
                                    may be reviewed by your assigned
                                    Supervisor. Make sure the information
                                    is complete and accurate before continuing.

                                </div>


                                <button
                                    type="submit"
                                    class="work-log-submit-button"
                                >
                                    Submit Daily Work Log
                                </button>


                            </div>


                        </form>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 WORK LOG HISTORY
                 ========================================================== --}}

            <section class="work-log-panel">


                <div class="work-log-panel-header">


                    <div class="work-log-panel-heading">


                        <div class="work-log-panel-icon panel-blue">
                            HS
                        </div>


                        <div>


                            <h2>
                                Work Log History
                            </h2>


                            <p>
                                Review your submitted OJT activity records
                            </p>


                        </div>


                    </div>


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

                        {{ $allWorkLogs->count() }}
                        logs

                    </span>


                </div>


                <div class="work-log-panel-body">


                    @if ($pageWorkLogs->isNotEmpty())


                        <div class="work-log-records">


                            @foreach ($workLogRecords as $log)


                                @php

                                    $attendance =
                                        $findAttendance(
                                            $log
                                        );


                                    $logStatus =
                                        strtolower(
                                            (string)
                                            $log->status
                                        );


                                    $canEdit =
                                        $isActiveAssignment
                                        &&
                                        in_array(
                                            $logStatus,
                                            [
                                                'pending',
                                                'rejected',
                                            ],
                                            true
                                        );

                                @endphp


                                <article class="work-log-record">


                                    {{-- ==================================
                                         HEADER
                                         ================================== --}}

                                    <div class="work-log-record-header">


                                        <div>


                                            <span class="work-log-record-date">

                                                {{ $formatDate(
                                                    $attendance
                                                        ?->attendance_date
                                                    ?? $log->created_at
                                                ) }}

                                            </span>


                                            <span class="work-log-record-meta">

                                                Work Log #{{ $log->id }}

                                                @if ($attendance)

                                                    · Attendance #{{ $attendance->id }}

                                                @endif

                                            </span>


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


                                    {{-- ==================================
                                         CONTENT
                                         ================================== --}}

                                    <div class="work-log-record-body">


                                        <div class="work-log-content-grid">


                                            {{-- ==========================
                                                 TASKS
                                                 ========================== --}}

                                            <div
                                                class="
                                                    work-log-content-block
                                                    work-log-content-full
                                                "
                                            >


                                                <span class="work-log-content-label">
                                                    Tasks & Activities
                                                </span>


                                                <div class="work-log-content-value">

                                                    {{ $log->tasks
                                                        ?: 'No task description provided.'
                                                    }}

                                                </div>


                                            </div>


                                            {{-- ==========================
                                                 LEARNINGS
                                                 ========================== --}}

                                            <div class="work-log-content-block">


                                                <span class="work-log-content-label">
                                                    Learnings & Skills
                                                </span>


                                                <div class="work-log-content-value">

                                                    {{ $log->learnings
                                                        ?: 'No learning notes provided.'
                                                    }}

                                                </div>


                                            </div>


                                            {{-- ==========================
                                                 CHALLENGES
                                                 ========================== --}}

                                            <div class="work-log-content-block">


                                                <span class="work-log-content-label">
                                                    Challenges
                                                </span>


                                                <div class="work-log-content-value">

                                                    {{ $log->challenges
                                                        ?: 'No challenges reported.'
                                                    }}

                                                </div>


                                            </div>


                                            {{-- ==========================
                                                 STUDENT REMARKS
                                                 ========================== --}}

                                            @if (
                                                filled(
                                                    $log
                                                        ->student_remarks
                                                )
                                            )


                                                <div
                                                    class="
                                                        work-log-content-block
                                                        work-log-content-full
                                                    "
                                                >


                                                    <span class="work-log-content-label">
                                                        Student Remarks
                                                    </span>


                                                    <div class="work-log-content-value">

                                                        {{ $log
                                                            ->student_remarks
                                                        }}

                                                    </div>


                                                </div>


                                            @endif


                                        </div>


                                        {{-- ==================================
                                             SUPERVISOR FEEDBACK
                                             ================================== --}}

                                        @if (
                                            filled(
                                                $log
                                                    ->supervisor_remarks
                                            )
                                        )


                                            <div
                                                class="
                                                    supervisor-feedback
                                                    {{ $logStatus === 'rejected'
                                                        ? 'rejected-feedback'
                                                        : ''
                                                    }}
                                                "
                                            >


                                                <span class="supervisor-feedback-label">

                                                    Supervisor Remarks

                                                </span>


                                                <div class="supervisor-feedback-value">

                                                    {{ $log
                                                        ->supervisor_remarks
                                                    }}

                                                </div>


                                            </div>


                                        @endif


                                        {{-- ==================================
                                             FOOTER
                                             ================================== --}}

                                        <div class="work-log-record-footer">


                                            <span class="work-log-submitted-at">

                                                Submitted:

                                                {{ $formatDateTime(
                                                    $log->submitted_at
                                                    ?? $log->created_at
                                                ) }}

                                            </span>


                                            <div class="work-log-record-actions">


                                                @if ($showRouteName)


                                                    <a
                                                        href="{{ route(
                                                            $showRouteName,
                                                            $log
                                                        ) }}"
                                                        class="work-log-record-button"
                                                    >
                                                        View Details
                                                    </a>


                                                @endif


                                                @if (
                                                    $canEdit
                                                    &&
                                                    $editRouteName
                                                )


                                                    <a
                                                        href="{{ route(
                                                            $editRouteName,
                                                            $log
                                                        ) }}"
                                                        class="work-log-record-button"
                                                    >
                                                        Edit Log
                                                    </a>


                                                @endif


                                            </div>


                                        </div>


                                    </div>


                                </article>


                            @endforeach


                        </div>


                        @if (
                            method_exists(
                                $workLogRecords,
                                'hasPages'
                            )
                            &&
                            $workLogRecords->hasPages()
                        )


                            <div class="work-log-pagination">

                                {{ $workLogRecords
                                    ->withQueryString()
                                    ->links()
                                }}

                            </div>


                        @endif


                    @else


                        <div class="work-log-empty">


                            <div class="work-log-empty-icon">
                                WL
                            </div>


                            <h3>
                                No Daily Work Logs Yet
                            </h3>


                            <p>

                                Your OJT tasks, learnings,
                                challenges, remarks, and
                                Supervisor feedback will appear
                                here after you submit your
                                first Daily Work Log.

                            </p>


                        </div>


                    @endif


                </div>


            </section>


        </main>


        {{-- ==============================================================
             SIDEBAR
             ============================================================== --}}

        <aside class="work-log-sidebar">


            {{-- ==========================================================
                 OJT PLACEMENT
                 ========================================================== --}}

            <section class="work-log-panel">


                <div class="work-log-panel-header">


                    <div class="work-log-panel-heading">


                        <div class="work-log-panel-icon panel-teal">
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


                <div class="work-log-panel-body">


                    @if ($selectedAssignment)


                        <div class="work-log-sidebar-list">


                            <div class="work-log-sidebar-item">


                                <span class="work-log-sidebar-label">
                                    Company
                                </span>


                                <span class="work-log-sidebar-value">

                                    {{ $selectedAssignment
                                        ->company
                                        ?->name
                                        ?? 'Not available'
                                    }}

                                </span>


                            </div>


                            <div class="work-log-sidebar-item">


                                <span class="work-log-sidebar-label">
                                    Supervisor
                                </span>


                                <span class="work-log-sidebar-value">

                                    {{ $selectedAssignment
                                        ->supervisor
                                        ?->name
                                        ?? 'Not assigned'
                                    }}

                                </span>


                            </div>


                            <div class="work-log-sidebar-item">


                                <span class="work-log-sidebar-label">
                                    Required OJT Hours
                                </span>


                                <span class="work-log-sidebar-value">

                                    {{ number_format(
                                        (float)
                                        $selectedAssignment->required_hours
                                    ) }}

                                    hours

                                </span>


                            </div>


                            <div class="work-log-sidebar-item">


                                <span class="work-log-sidebar-label">
                                    Placement Period
                                </span>


                                <span class="work-log-sidebar-value">

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


                            <div class="work-log-sidebar-item">


                                <span class="work-log-sidebar-label">
                                    Assignment Status
                                </span>


                                <span class="work-log-sidebar-value">

                                    {{ ucfirst(
                                        $assignmentStatus
                                    ) }}

                                </span>


                            </div>


                        </div>


                    @else


                        <div class="work-log-info-note">

                            <strong>
                                No assignment available.
                            </strong>

                            Your OJT placement information
                            will appear here once an assignment
                            has been created.

                        </div>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 WRITING GUIDE
                 ========================================================== --}}

            <section class="work-log-panel">


                <div class="work-log-panel-header">


                    <div class="work-log-panel-heading">


                        <div class="work-log-panel-icon panel-purple">
                            123
                        </div>


                        <div>


                            <h2>
                                Writing Guide
                            </h2>


                            <p>
                                What to include in your Work Log
                            </p>


                        </div>


                    </div>


                </div>


                <div class="work-log-panel-body">


                    <div class="work-log-guide">


                        <div class="work-log-guide-item">


                            <div class="work-log-guide-number">
                                1
                            </div>


                            <div>


                                <span class="work-log-guide-title">
                                    Describe Your Tasks
                                </span>


                                <span class="work-log-guide-description">

                                    Write the specific work,
                                    activities, or responsibilities
                                    you completed.

                                </span>


                            </div>


                        </div>


                        <div class="work-log-guide-item">


                            <div class="work-log-guide-number">
                                2
                            </div>


                            <div>


                                <span class="work-log-guide-title">
                                    Explain What You Learned
                                </span>


                                <span class="work-log-guide-description">

                                    Mention new knowledge,
                                    technical skills, workplace
                                    practices, or lessons gained.

                                </span>


                            </div>


                        </div>


                        <div class="work-log-guide-item">


                            <div class="work-log-guide-number">
                                3
                            </div>


                            <div>


                                <span class="work-log-guide-title">
                                    Identify Challenges
                                </span>


                                <span class="work-log-guide-description">

                                    Explain difficulties encountered
                                    and how you responded to them.

                                </span>


                            </div>


                        </div>


                        <div class="work-log-guide-item">


                            <div class="work-log-guide-number">
                                4
                            </div>


                            <div>


                                <span class="work-log-guide-title">
                                    Review Before Submitting
                                </span>


                                <span class="work-log-guide-description">

                                    Use clear, professional,
                                    and truthful descriptions.

                                </span>


                            </div>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 STATUS GUIDE
                 ========================================================== --}}

            <section class="work-log-panel">


                <div class="work-log-panel-header">


                    <div class="work-log-panel-heading">


                        <div class="work-log-panel-icon panel-orange">
                            ST
                        </div>


                        <div>


                            <h2>
                                Validation Status
                            </h2>


                            <p>
                                Understand Supervisor review states
                            </p>


                        </div>


                    </div>


                </div>


                <div class="work-log-panel-body">


                    <div class="work-log-sidebar-list">


                        <div class="work-log-sidebar-item">


                            <span class="work-log-sidebar-label">
                                Pending
                            </span>


                            <span class="work-log-sidebar-value">

                                Waiting for Supervisor review.

                            </span>


                        </div>


                        <div class="work-log-sidebar-item">


                            <span class="work-log-sidebar-label">
                                Validated
                            </span>


                            <span class="work-log-sidebar-value">

                                Approved by your Supervisor.

                            </span>


                        </div>


                        <div class="work-log-sidebar-item">


                            <span class="work-log-sidebar-label">
                                Rejected
                            </span>


                            <span class="work-log-sidebar-value">

                                Review the Supervisor remarks
                                and determine what needs attention.

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 RELATED PAGES
                 ========================================================== --}}

            <section class="work-log-panel">


                <div class="work-log-panel-header">


                    <div class="work-log-panel-heading">


                        <div class="work-log-panel-icon panel-blue">
                            GO
                        </div>


                        <div>


                            <h2>
                                Related OJT Pages
                            </h2>


                            <p>
                                Continue managing your OJT records
                            </p>


                        </div>


                    </div>


                </div>


                <div class="work-log-panel-body">


                    <div class="work-log-links">


                        @if (
                            \Illuminate\Support\Facades\Route::has(
                                'student.attendance.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.attendance.index'
                                ) }}"
                                class="work-log-link"
                            >

                                <span>
                                    GPS Selfie Attendance
                                </span>

                                <span>→</span>

                            </a>


                        @endif


                        @if (
                            \Illuminate\Support\Facades\Route::has(
                                'student.timesheets.index'
                            )
                        )


                            <a
                                href="{{ route(
                                    'student.timesheets.index'
                                ) }}"
                                class="work-log-link"
                            >

                                <span>
                                    My Timesheet
                                </span>

                                <span>→</span>

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
                                class="work-log-link"
                            >

                                <span>
                                    My OJT Report
                                </span>

                                <span>→</span>

                            </a>


                        @endif


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 REMINDER
                 ========================================================== --}}

            <section class="work-log-panel">


                <div class="work-log-panel-header">


                    <div class="work-log-panel-heading">


                        <div class="work-log-panel-icon panel-green">
                            i
                        </div>


                        <div>


                            <h2>
                                Work Log Reminder
                            </h2>


                            <p>
                                Maintain accurate activity records
                            </p>


                        </div>


                    </div>


                </div>


                <div class="work-log-panel-body">


                    <div class="work-log-info-note">

                        <strong>
                            Your Daily Work Log should describe real OJT activities.
                        </strong>

                        Avoid vague entries such as
                        “worked today.” Use clear descriptions
                        showing what you actually completed,
                        learned, or experienced during your
                        training day.

                    </div>


                </div>


            </section>


        </aside>


    </div>


</div>


@endsection


@push('scripts')

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /*
            |--------------------------------------------------------------------------
            | Readable Textarea Character Counters
            |--------------------------------------------------------------------------
            */

            const textareas =
                document.querySelectorAll(
                    '[data-counter]'
                );


            textareas.forEach(
                function (textarea) {

                    const counterId =
                        textarea.dataset.counter;


                    const counter =
                        document.getElementById(
                            counterId
                        );


                    if (! counter) {
                        return;
                    }


                    const updateCounter =
                        function () {

                            const count =
                                textarea.value.length;


                            counter.textContent =
                                count
                                + (
                                    count === 1
                                        ? ' character'
                                        : ' characters'
                                );

                        };


                    textarea.addEventListener(
                        'input',
                        updateCounter
                    );


                    updateCounter();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Submit Protection
            |--------------------------------------------------------------------------
            */

            const form =
                document.getElementById(
                    'daily-work-log-form'
                );


            if (form) {

                form.addEventListener(
                    'submit',
                    function () {

                        const button =
                            form.querySelector(
                                '.work-log-submit-button'
                            );


                        if (! button) {
                            return;
                        }


                        button.disabled = true;

                        button.textContent =
                            'Submitting Work Log...';

                    }
                );

            }

        }
    );

</script>

@endpush