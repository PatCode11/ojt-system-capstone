@extends('layouts.app')


@section('title', 'Final Evaluations | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       SUPERVISOR FINAL EVALUATION CENTER
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --ev-navy: #183B6B;
        --ev-navy-dark: #102A4A;
        --ev-navy-deep: #0B223D;

        --ev-blue: #2563EB;
        --ev-blue-soft: #EAF2FF;

        --ev-teal: #0F766E;
        --ev-teal-soft: #E7F7F5;

        --ev-green: #15803D;
        --ev-green-soft: #EAF8EF;

        --ev-orange: #B45309;
        --ev-orange-soft: #FFF5E6;

        --ev-red: #B42318;
        --ev-red-soft: #FFF0EE;

        --ev-purple: #6D4FC2;
        --ev-purple-dark: #563AA7;
        --ev-purple-soft: #F2EEFF;

        --ev-gray: #475569;
        --ev-gray-soft: #F1F5F9;

        --ev-text: #102A4A;
        --ev-body: #405872;
        --ev-muted: #64778C;

        --ev-white: #FFFFFF;
        --ev-soft: #F8FBFE;

        --ev-border: #D8E3EE;
        --ev-border-soft: #E7EDF4;

        --ev-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --ev-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --ev-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .supervisor-evaluation-page {
        width: 100%;

        color: var(--ev-text);

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

    .evaluation-hero {
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
                rgba(167, 139, 250, 0.24),
                transparent 25%
            ),
            radial-gradient(
                circle at 69% 88%,
                rgba(45, 212, 191, 0.14),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 51%,
                #31446F 100%
            );

        box-shadow:
            var(--ev-shadow-large);
    }


    .evaluation-hero::before {
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


    .evaluation-hero::after {
        content: "";

        position: absolute;

        width: 220px;
        height: 220px;

        right: 260px;
        bottom: -150px;

        border-radius: 50%;

        background:
            rgba(167, 139, 250, 0.08);
    }


    .evaluation-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 36px;
    }


    .evaluation-hero-copy {
        min-width: 0;

        max-width: 770px;
    }


    .evaluation-hero-eyebrow {
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


    .evaluation-hero-dot {
        width: 9px;
        height: 9px;

        flex-shrink: 0;

        border-radius: 50%;

        background:
            #A78BFA;

        box-shadow:
            0 0 0 5px
            rgba(167, 139, 250, 0.15);
    }


    .evaluation-hero h1 {
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


    .evaluation-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.83);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO SUMMARY
       ================================================================ */

    .evaluation-hero-summary {
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


    .evaluation-hero-summary-label {
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


    .evaluation-hero-summary-value {
        display: block;

        color: #FFFFFF;

        font-size: 36px;
        font-weight: 900;

        line-height: 1.1;
    }


    .evaluation-hero-summary-description {
        display: block;

        margin-top: 7px;

        color:
            rgba(255, 255, 255, 0.80);

        font-size: 15px;

        line-height: 1.55;
    }


    .evaluation-hero-summary-footer {
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
       REMINDER
       ================================================================ */

    .evaluation-reminder {
        display: flex;
        align-items: flex-start;

        gap: 15px;

        margin-bottom: 26px;

        padding:
            19px
            21px;

        border:
            1px solid
            #DDD5F1;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #FCFBFF 0%,
                #F5F1FF 100%
            );

        box-shadow:
            var(--ev-shadow);
    }


    .evaluation-reminder-icon {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--ev-purple-soft);

        color:
            var(--ev-purple);

        font-size: 16px;
        font-weight: 900;
    }


    .evaluation-reminder strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--ev-text);

        font-size: 17px;
        font-weight: 850;
    }


    .evaluation-reminder span {
        color:
            var(--ev-body);

        font-size: 15px;

        line-height: 1.65;
    }


    /* ================================================================
       SUMMARY CARDS
       ================================================================ */

    .evaluation-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 19px;

        margin-bottom: 28px;
    }


    .evaluation-summary-card {
        padding: 24px;

        border:
            1px solid
            var(--ev-border);

        border-radius: 20px;

        background:
            var(--ev-white);

        box-shadow:
            var(--ev-shadow);

        transition:
            var(--ev-transition);
    }


    .evaluation-summary-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            0 18px 38px
            rgba(15, 42, 74, 0.10);
    }


    .evaluation-summary-icon {
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
            var(--ev-teal-soft);

        color:
            var(--ev-teal);
    }


    .summary-purple {
        background:
            var(--ev-purple-soft);

        color:
            var(--ev-purple);
    }


    .summary-green {
        background:
            var(--ev-green-soft);

        color:
            var(--ev-green);
    }


    .summary-orange {
        background:
            var(--ev-orange-soft);

        color:
            var(--ev-orange);
    }


    .evaluation-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--ev-body);

        font-size: 15px;
        font-weight: 750;
    }


    .evaluation-summary-value {
        display: block;

        color:
            var(--ev-text);

        font-size: 32px;
        font-weight: 900;

        line-height: 1.15;
    }


    .evaluation-summary-note {
        display: block;

        margin-top: 9px;

        color:
            var(--ev-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       FILTER
       ================================================================ */

    .evaluation-filter {
        margin-bottom: 27px;

        padding:
            21px
            22px;

        border:
            1px solid
            var(--ev-border);

        border-radius: 18px;

        background:
            var(--ev-white);

        box-shadow:
            var(--ev-shadow);
    }


    .evaluation-filter-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 16px;
    }


    .evaluation-filter-title {
        display: block;

        margin-bottom: 3px;

        color:
            var(--ev-text);

        font-size: 18px;
        font-weight: 850;
    }


    .evaluation-filter-description {
        color:
            var(--ev-muted);

        font-size: 14px;
    }


    .evaluation-filter-count {
        padding:
            8px
            12px;

        border-radius: 999px;

        background:
            var(--ev-gray-soft);

        color:
            var(--ev-body);

        font-size: 14px;
        font-weight: 850;

        white-space: nowrap;
    }


    .evaluation-filter-grid {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            220px;

        gap: 13px;
    }


    .evaluation-search,
    .evaluation-filter-select {
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
            var(--ev-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;
    }


    .evaluation-search {
        padding:
            0
            15px;
    }


    .evaluation-filter-select {
        padding:
            0
            14px;

        cursor: pointer;
    }


    .evaluation-search:focus,
    .evaluation-filter-select:focus {
        border-color:
            var(--ev-purple);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(109, 79, 194, 0.09);
    }


    /* ================================================================
       PANEL
       ================================================================ */

    .evaluation-panel {
        overflow: hidden;

        border:
            1px solid
            var(--ev-border);

        border-radius: 20px;

        background:
            var(--ev-white);

        box-shadow:
            var(--ev-shadow);
    }


    .evaluation-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            24px
            26px;

        border-bottom:
            1px solid
            var(--ev-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .evaluation-panel-heading {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    .evaluation-panel-icon {
        width: 50px;
        height: 50px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background:
            var(--ev-purple-soft);

        color:
            var(--ev-purple);

        font-size: 13px;
        font-weight: 900;
    }


    .evaluation-panel-heading h2 {
        margin:
            0
            0
            4px;

        color:
            var(--ev-text);

        font-size: 23px;
        font-weight: 850;

        line-height: 1.3;
    }


    .evaluation-panel-heading p {
        margin: 0;

        color:
            var(--ev-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .evaluation-panel-body {
        padding: 26px;
    }


    /* ================================================================
       STUDENT EVALUATION LIST
       ================================================================ */

    .student-evaluation-list {
        display: grid;

        gap: 22px;
    }


    .student-evaluation-card {
        overflow: hidden;

        border:
            1px solid
            var(--ev-border);

        border-radius: 19px;

        background:
            #FFFFFF;

        transition:
            var(--ev-transition);
    }


    .student-evaluation-card:hover {
        border-color:
            #C4D1E0;

        box-shadow:
            0 16px 34px
            rgba(15, 42, 74, 0.08);
    }


    /* ================================================================
       CARD HEADER
       ================================================================ */

    .student-evaluation-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding:
            21px
            22px;

        border-bottom:
            1px solid
            var(--ev-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FAFCFF 100%
            );
    }


    .evaluation-student {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 15px;
    }


    .evaluation-student-avatar {
        width: 58px;
        height: 58px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background:
            var(--ev-teal-soft);

        color:
            var(--ev-teal);

        font-size: 16px;
        font-weight: 900;
    }


    .evaluation-student-name {
        display: block;

        margin-bottom: 3px;

        color:
            var(--ev-text);

        font-size: 19px;
        font-weight: 900;

        line-height: 1.4;
    }


    .evaluation-student-meta {
        display: block;

        color:
            var(--ev-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       BADGES
       ================================================================ */

    .evaluation-status {
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


    .evaluation-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .evaluation-status-completed {
        background:
            var(--ev-purple-soft);

        color:
            var(--ev-purple);
    }


    .evaluation-status-completed::before {
        background:
            #8B5CF6;
    }


    .evaluation-status-needed {
        background:
            var(--ev-orange-soft);

        color:
            var(--ev-orange);
    }


    .evaluation-status-needed::before {
        background:
            #F59E0B;
    }


    .evaluation-status-unavailable {
        background:
            var(--ev-gray-soft);

        color:
            var(--ev-gray);
    }


    .evaluation-status-unavailable::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       BODY
       ================================================================ */

    .student-evaluation-body {
        padding: 22px;
    }


    /* ================================================================
       ASSIGNMENT OVERVIEW
       ================================================================ */

    .evaluation-overview-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 13px;

        margin-bottom: 18px;
    }


    .evaluation-overview-item {
        min-height: 96px;

        padding: 15px;

        border:
            1px solid
            var(--ev-border-soft);

        border-radius: 12px;

        background:
            var(--ev-soft);
    }


    .evaluation-overview-label {
        display: block;

        margin-bottom: 6px;

        color:
            var(--ev-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.25px;
    }


    .evaluation-overview-value {
        display: block;

        color:
            var(--ev-text);

        font-size: 17px;
        font-weight: 900;

        line-height: 1.5;

        word-break: break-word;
    }


    .evaluation-overview-secondary {
        display: block;

        margin-top: 3px;

        color:
            var(--ev-muted);

        font-size: 13px;

        line-height: 1.45;
    }


    /* ================================================================
       OJT PROGRESS
       ================================================================ */

    .evaluation-progress {
        margin-top: 17px;

        padding:
            19px;

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


    .evaluation-progress-top {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 13px;
    }


    .evaluation-progress-title {
        display: block;

        margin-bottom: 4px;

        color:
            var(--ev-text);

        font-size: 17px;
        font-weight: 900;
    }


    .evaluation-progress-description {
        color:
            var(--ev-body);

        font-size: 14px;

        line-height: 1.55;
    }


    .evaluation-progress-value {
        color:
            var(--ev-teal);

        font-size: 24px;
        font-weight: 900;

        white-space: nowrap;
    }


    .evaluation-progress-track {
        width: 100%;
        height: 11px;

        overflow: hidden;

        border-radius: 999px;

        background:
            #D9E9E5;
    }


    .evaluation-progress-fill {
        height: 100%;

        border-radius: inherit;

        background:
            linear-gradient(
                90deg,
                #2563EB,
                #0F766E
            );
    }


    .evaluation-progress-stats {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 11px;

        margin-top: 16px;
    }


    .evaluation-progress-stat {
        padding: 13px;

        border:
            1px solid
            rgba(15, 118, 110, 0.10);

        border-radius: 10px;

        background:
            rgba(255, 255, 255, 0.78);
    }


    .evaluation-progress-stat-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--ev-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .evaluation-progress-stat-value {
        display: block;

        color:
            var(--ev-text);

        font-size: 17px;
        font-weight: 900;
    }


    /* ================================================================
       READINESS
       ================================================================ */

    .evaluation-readiness {
        margin-top: 17px;

        padding: 18px;

        border-radius: 14px;
    }


    .evaluation-readiness-ready {
        border:
            1px solid
            #CFE2D5;

        background:
            var(--ev-green-soft);
    }


    .evaluation-readiness-warning {
        border:
            1px solid
            #EED7B4;

        background:
            var(--ev-orange-soft);
    }


    .evaluation-readiness-complete {
        border:
            1px solid
            #DDD5F1;

        background:
            var(--ev-purple-soft);
    }


    .evaluation-readiness-title {
        display: block;

        margin-bottom: 5px;

        color:
            var(--ev-text);

        font-size: 16px;
        font-weight: 900;
    }


    .evaluation-readiness-description {
        color:
            var(--ev-body);

        font-size: 15px;

        line-height: 1.65;
    }


    /* ================================================================
       COMPLETED EVALUATION
       ================================================================ */

    .completed-evaluation {
        margin-top: 18px;

        padding: 20px;

        border:
            1px solid
            #DDD5F1;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #FCFBFF 0%,
                #F5F1FF 100%
            );
    }


    .completed-evaluation-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 17px;
    }


    .completed-evaluation-title {
        display: block;

        margin-bottom: 4px;

        color:
            var(--ev-text);

        font-size: 18px;
        font-weight: 900;
    }


    .completed-evaluation-date {
        color:
            var(--ev-muted);

        font-size: 14px;
    }


    .recommendation-badge {
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


    .recommendation-recommended {
        background:
            var(--ev-green-soft);

        color:
            var(--ev-green);
    }


    .recommendation-improvement {
        background:
            var(--ev-orange-soft);

        color:
            var(--ev-orange);
    }


    .recommendation-default {
        background:
            var(--ev-purple-soft);

        color:
            var(--ev-purple);
    }


    /* ================================================================
       SCORE SUMMARY
       ================================================================ */

    .evaluation-score-summary {
        display: grid;

        grid-template-columns:
            200px
            minmax(0, 1fr);

        gap: 16px;
    }


    .evaluation-average-card {
        min-height: 180px;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        padding: 20px;

        border:
            1px solid
            rgba(109, 79, 194, 0.13);

        border-radius: 14px;

        background:
            rgba(255, 255, 255, 0.78);

        text-align: center;
    }


    .evaluation-average-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--ev-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .evaluation-average-value {
        display: block;

        color:
            var(--ev-purple);

        font-size: 40px;
        font-weight: 900;

        line-height: 1;
    }


    .evaluation-average-max {
        display: block;

        margin-top: 4px;

        color:
            var(--ev-muted);

        font-size: 14px;
        font-weight: 750;
    }


    .evaluation-average-description {
        margin-top: 10px;

        color:
            var(--ev-text);

        font-size: 15px;
        font-weight: 850;
    }


    /* ================================================================
       CRITERIA
       ================================================================ */

    .evaluation-criteria-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 11px;
    }


    .evaluation-criterion {
        padding:
            13px
            14px;

        border:
            1px solid
            rgba(109, 79, 194, 0.10);

        border-radius: 11px;

        background:
            rgba(255, 255, 255, 0.78);
    }


    .evaluation-criterion-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        margin-bottom: 8px;
    }


    .evaluation-criterion-label {
        color:
            var(--ev-text);

        font-size: 14px;
        font-weight: 850;

        line-height: 1.45;
    }


    .evaluation-criterion-score {
        flex-shrink: 0;

        color:
            var(--ev-purple);

        font-size: 17px;
        font-weight: 900;
    }


    .evaluation-criterion-track {
        width: 100%;
        height: 7px;

        overflow: hidden;

        border-radius: 999px;

        background:
            #E5E1F0;
    }


    .evaluation-criterion-fill {
        height: 100%;

        border-radius: inherit;

        background:
            linear-gradient(
                90deg,
                #6D4FC2,
                #8B5CF6
            );
    }


    /* ================================================================
       EVALUATION COMMENTS
       ================================================================ */

    .evaluation-comments-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 12px;

        margin-top: 16px;
    }


    .evaluation-comment {
        padding:
            16px;

        border:
            1px solid
            rgba(109, 79, 194, 0.10);

        border-radius: 12px;

        background:
            rgba(255, 255, 255, 0.76);
    }


    .evaluation-comment-full {
        grid-column:
            1 / -1;
    }


    .evaluation-comment-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--ev-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.25px;
    }


    .evaluation-comment-value {
        color:
            var(--ev-text);

        font-size: 16px;

        line-height: 1.75;

        white-space: pre-line;

        word-break: break-word;
    }


    /* ================================================================
       ACTIONS
       ================================================================ */

    .evaluation-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 10px;

        margin-top: 18px;

        padding-top: 18px;

        border-top:
            1px solid
            var(--ev-border-soft);
    }


    .evaluation-action {
        min-height: 48px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            16px;

        border:
            1px solid
            var(--ev-border);

        border-radius: 11px;

        background:
            #FFFFFF;

        color:
            var(--ev-navy);

        text-decoration: none;

        font-size: 15px;
        font-weight: 850;

        transition:
            var(--ev-transition);
    }


    .evaluation-action:hover {
        transform:
            translateY(-1px);

        border-color:
            #BBCBDA;

        background:
            var(--ev-blue-soft);
    }


    .evaluation-action-primary {
        border-color:
            var(--ev-purple);

        background:
            var(--ev-purple);

        color:
            #FFFFFF;
    }


    .evaluation-action-primary:hover {
        border-color:
            var(--ev-purple-dark);

        background:
            var(--ev-purple-dark);

        color:
            #FFFFFF;

        box-shadow:
            0 10px 23px
            rgba(109, 79, 194, 0.18);
    }


    /* ================================================================
       NOTES
       ================================================================ */

    .evaluation-info-note {
        margin-top: 17px;

        padding:
            15px
            16px;

        border:
            1px solid
            #D5E4F2;

        border-radius: 12px;

        background:
            #F5FAFE;

        color:
            var(--ev-body);

        font-size: 15px;

        line-height: 1.65;
    }


    .evaluation-info-note strong {
        color:
            var(--ev-text);
    }


    /* ================================================================
       EMPTY
       ================================================================ */

    .evaluation-empty {
        padding:
            55px
            24px;

        text-align: center;
    }


    .evaluation-empty-icon {
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
            var(--ev-purple-soft);

        color:
            var(--ev-purple);

        font-size: 17px;
        font-weight: 900;
    }


    .evaluation-empty h3 {
        margin:
            0
            0
            8px;

        color:
            var(--ev-text);

        font-size: 22px;
        font-weight: 900;
    }


    .evaluation-empty p {
        max-width: 590px;

        margin:
            0
            auto;

        color:
            var(--ev-body);

        font-size: 16px;

        line-height: 1.7;
    }


    .evaluation-filter-empty {
        display: none;

        padding:
            45px
            20px;

        text-align: center;

        color:
            var(--ev-body);

        font-size: 16px;
    }


    .evaluation-filter-empty.is-visible {
        display: block;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1180px) {

        .evaluation-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .evaluation-overview-grid,
        .evaluation-progress-stats {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .evaluation-score-summary {
            grid-template-columns: 1fr;
        }


        .evaluation-average-card {
            min-height: 150px;
        }

    }


    @media (max-width: 850px) {

        .evaluation-hero {
            padding:
                34px
                28px;
        }


        .evaluation-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .evaluation-hero-summary {
            width: 100%;
        }


        .evaluation-filter-grid,
        .evaluation-criteria-grid,
        .evaluation-comments-grid {
            grid-template-columns: 1fr;
        }


        .evaluation-comment-full {
            grid-column: auto;
        }


        .student-evaluation-header {
            flex-direction: column;

            align-items: flex-start;
        }


        .completed-evaluation-top,
        .evaluation-progress-top {
            flex-direction: column;

            align-items: flex-start;
        }

    }


    @media (max-width: 650px) {

        .evaluation-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .evaluation-hero h1 {
            font-size: 31px;
        }


        .evaluation-hero-description {
            font-size: 16px;
        }


        .evaluation-summary-grid,
        .evaluation-overview-grid,
        .evaluation-progress-stats {
            grid-template-columns: 1fr;
        }


        .evaluation-panel-header,
        .evaluation-panel-body {
            padding-left: 20px;
            padding-right: 20px;
        }


        .evaluation-panel-heading h2 {
            font-size: 21px;
        }


        .evaluation-filter-top {
            flex-direction: column;

            align-items: flex-start;
        }


        .evaluation-student {
            align-items: flex-start;
        }


        .evaluation-student-avatar {
            width: 50px;
            height: 50px;
        }


        .evaluation-actions {
            display: grid;

            grid-template-columns: 1fr;
        }


        .evaluation-action {
            width: 100%;
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
    | Evaluation Groups
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


    $notEvaluatedAssignments =
        $supervisedAssignments
            ->filter(
                fn ($assignment) =>
                    $assignment->finalEvaluation
                    === null
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Recommendations
    |--------------------------------------------------------------------------
    */

    $recommendedAssignments =
        $evaluatedAssignments
            ->filter(
                function ($assignment) {

                    return strtolower(
                        (string)
                        $assignment
                            ->finalEvaluation
                            ?->recommendation
                    ) === 'recommended';

                }
            )
            ->values();


    $needsImprovementAssignments =
        $evaluatedAssignments
            ->filter(
                function ($assignment) {

                    return in_array(
                        strtolower(
                            (string)
                            $assignment
                                ->finalEvaluation
                                ?->recommendation
                        ),
                        [
                            'needs_improvement',
                            'needs improvement',
                        ],
                        true
                    );

                }
            )
            ->values();


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
                            'M d, Y'
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
    | Humanize Attribute
    |--------------------------------------------------------------------------
    */

    $humanizeAttribute =
        function ($attribute) {

            $attribute =
                preg_replace(
                    '/_(rating|score)$/',
                    '',
                    (string) $attribute
                );


            return ucwords(
                str_replace(
                    '_',
                    ' ',
                    $attribute
                )
            );

        };


    /*
    |--------------------------------------------------------------------------
    | Extract Numeric Evaluation Criteria
    |--------------------------------------------------------------------------
    |
    | This avoids hard-coding your six criterion column names.
    |
    */

    $extractCriteria =
        function ($evaluation) {

            if (! $evaluation) {
                return collect();
            }


            $excludedKeys = [

                'id',

                'ojt_assignment_id',
                'assignment_id',

                'evaluator_id',
                'evaluated_by',
                'supervisor_id',
                'user_id',

                'recommendation',

                'overall_rating',
                'overall_score',
                'average_score',
                'average_rating',
                'total_score',

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
                        $excludedKeys
                    ) {

                        if (
                            in_array(
                                $key,
                                $excludedKeys,
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


                        $number =
                            (float) $value;


                        return
                            $number >= 1
                            &&
                            $number <= 5;

                    }
                );

        };


    /*
    |--------------------------------------------------------------------------
    | Rating Label
    |--------------------------------------------------------------------------
    */

    $ratingLabel =
        function ($average) {

            if ($average === null) {
                return 'Not available';
            }


            if ($average >= 4.5) {
                return 'Outstanding';
            }


            if ($average >= 3.5) {
                return 'Very Good';
            }


            if ($average >= 2.5) {
                return 'Good';
            }


            if ($average >= 1.5) {
                return 'Needs Improvement';
            }


            return 'Unsatisfactory';

        };


    /*
    |--------------------------------------------------------------------------
    | Recommendation Label
    |--------------------------------------------------------------------------
    */

    $recommendationLabel =
        function ($recommendation) {

            if (blank($recommendation)) {
                return 'Not available';
            }


            return ucwords(
                str_replace(
                    '_',
                    ' ',
                    (string) $recommendation
                )
            );

        };


    /*
    |--------------------------------------------------------------------------
    | Recommendation Class
    |--------------------------------------------------------------------------
    */

    $recommendationClass =
        function ($recommendation) {

            $value =
                strtolower(
                    (string) $recommendation
                );


            if (
                $value === 'recommended'
            ) {

                return
                    'recommendation-recommended';

            }


            if (
                in_array(
                    $value,
                    [
                        'needs_improvement',
                        'needs improvement',
                    ],
                    true
                )
            ) {

                return
                    'recommendation-improvement';

            }


            return
                'recommendation-default';

        };


    /*
    |--------------------------------------------------------------------------
    | Generic Evaluation Text
    |--------------------------------------------------------------------------
    */

    $evaluationText =
        function (
            $evaluation,
            array $keys
        ) {

            if (! $evaluation) {
                return null;
            }


            foreach ($keys as $key) {

                try {

                    $value =
                        data_get(
                            $evaluation,
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


            return null;

        };


    /*
    |--------------------------------------------------------------------------
    | Route Builder
    |--------------------------------------------------------------------------
    |
    | This detects the actual parameter names of your existing routes.
    |
    */

    $buildEvaluationRoute =
        function (
            array $candidateNames,
            $assignment,
            $evaluation = null
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

                        if (
                            preg_match(
                                '/evaluation/i',
                                $parameterName
                            )
                            &&
                            $evaluation
                        ) {

                            $parameters[
                                $parameterName
                            ] =
                                $evaluation
                                    ->getRouteKey();

                            continue;

                        }


                        if (
                            preg_match(
                                '/assignment|ojt/i',
                                $parameterName
                            )
                        ) {

                            $parameters[
                                $parameterName
                            ] =
                                $assignment
                                    ->getRouteKey();

                            continue;

                        }


                        if ($evaluation) {

                            $parameters[
                                $parameterName
                            ] =
                                $evaluation
                                    ->getRouteKey();

                        } else {

                            $parameters[
                                $parameterName
                            ] =
                                $assignment
                                    ->getRouteKey();

                        }

                    }


                    return [
                        'name' =>
                            $routeName,

                        'url' =>
                            route(
                                $routeName,
                                $parameters
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
    | Route Candidates
    |--------------------------------------------------------------------------
    */

    $createRouteCandidates = [

        'supervisor.evaluations.create',

        'supervisor.final-evaluations.create',

        'supervisor.evaluation.create',

    ];


    $showRouteCandidates = [

        'supervisor.evaluations.show',

        'supervisor.final-evaluations.show',

        'supervisor.evaluation.show',

    ];


    $editRouteCandidates = [

        'supervisor.evaluations.edit',

        'supervisor.final-evaluations.edit',

        'supervisor.evaluation.edit',

    ];

@endphp


<div class="supervisor-evaluation-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="evaluation-hero">


        <div class="evaluation-hero-inner">


            <div class="evaluation-hero-copy">


                <div class="evaluation-hero-eyebrow">


                    <span class="evaluation-hero-dot"></span>


                    Supervisor Portal · Final Performance Assessment


                </div>


                <h1>
                    Final Evaluation Center
                </h1>


                <p class="evaluation-hero-description">

                    Review each Student's OJT progress,
                    validated attendance, Daily Work Logs,
                    required hours, and final performance
                    evaluation from one clear and professional
                    Supervisor workspace.

                </p>


            </div>


            <div class="evaluation-hero-summary">


                <span class="evaluation-hero-summary-label">
                    Evaluations Pending
                </span>


                <span class="evaluation-hero-summary-value">

                    {{ $notEvaluatedAssignments->count() }}

                </span>


                <span class="evaluation-hero-summary-description">

                    supervised placement{{ $notEvaluatedAssignments->count() === 1 ? '' : 's' }}
                    currently without a final evaluation.

                </span>


                <div class="evaluation-hero-summary-footer">


                    <span>

                        {{ $evaluatedAssignments->count() }}
                        submitted

                    </span>


                    <span>

                        {{ $supervisedAssignments->count() }}
                        total

                    </span>


                </div>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         REMINDER
         ================================================================== --}}

    <section class="evaluation-reminder">


        <div class="evaluation-reminder-icon">
            EV
        </div>


        <div>


            <strong>
                Final evaluations should reflect the Student's complete OJT performance.
            </strong>


            <span>

                Before submitting an evaluation,
                review the Student's validated attendance,
                rendered hours, Daily Work Logs, workplace
                performance, and overall progress.
                Evaluation records become an important
                part of the Student's final OJT record.

            </span>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="evaluation-summary-grid">


        <article class="evaluation-summary-card">


            <div class="evaluation-summary-icon summary-teal">
                ST
            </div>


            <span class="evaluation-summary-label">
                Supervised Placements
            </span>


            <span class="evaluation-summary-value">

                {{ $supervisedAssignments->count() }}

            </span>


            <span class="evaluation-summary-note">

                OJT Assignments currently
                connected to your Supervisor account.

            </span>


        </article>


        <article class="evaluation-summary-card">


            <div class="evaluation-summary-icon summary-purple">
                EV
            </div>


            <span class="evaluation-summary-label">
                Evaluations Submitted
            </span>


            <span class="evaluation-summary-value">

                {{ $evaluatedAssignments->count() }}

            </span>


            <span class="evaluation-summary-note">

                Final evaluations already
                recorded in the system.

            </span>


        </article>


        <article class="evaluation-summary-card">


            <div class="evaluation-summary-icon summary-green">
                ✓
            </div>


            <span class="evaluation-summary-label">
                Recommended
            </span>


            <span class="evaluation-summary-value">

                {{ $recommendedAssignments->count() }}

            </span>


            <span class="evaluation-summary-note">

                Evaluations with a
                Recommended final result.

            </span>


        </article>


        <article class="evaluation-summary-card">


            <div class="evaluation-summary-icon summary-orange">
                PD
            </div>


            <span class="evaluation-summary-label">
                Awaiting Evaluation
            </span>


            <span class="evaluation-summary-value">

                {{ $notEvaluatedAssignments->count() }}

            </span>


            <span class="evaluation-summary-note">

                Placements without a
                final Supervisor evaluation.

            </span>


        </article>


    </section>


    {{-- ==================================================================
         FILTER
         ================================================================== --}}

    @if ($supervisedAssignments->isNotEmpty())


        <section class="evaluation-filter">


            <div class="evaluation-filter-top">


                <div>


                    <span class="evaluation-filter-title">
                        Find Student Evaluations
                    </span>


                    <span class="evaluation-filter-description">

                        Search by Student,
                        Student number, company,
                        recommendation, or evaluation status.

                    </span>


                </div>


                <span
                    class="evaluation-filter-count"
                    id="evaluation-visible-count"
                >

                    {{ $supervisedAssignments->count() }}
                    records

                </span>


            </div>


            <div class="evaluation-filter-grid">


                <input
                    type="search"
                    id="evaluation-search"
                    class="evaluation-search"
                    placeholder="Search Student, company, recommendation..."
                    autocomplete="off"
                >


                <select
                    id="evaluation-status-filter"
                    class="evaluation-filter-select"
                >

                    <option value="">
                        All Evaluations
                    </option>


                    <option value="submitted">
                        Submitted
                    </option>


                    <option value="pending">
                        Awaiting Evaluation
                    </option>


                    <option value="recommended">
                        Recommended
                    </option>


                    <option value="needs_improvement">
                        Needs Improvement
                    </option>


                </select>


            </div>


        </section>


    @endif


    {{-- ==================================================================
         EVALUATION RECORDS
         ================================================================== --}}

    <section class="evaluation-panel">


        <div class="evaluation-panel-header">


            <div class="evaluation-panel-heading">


                <div class="evaluation-panel-icon">
                    EV
                </div>


                <div>


                    <h2>
                        Student Final Evaluations
                    </h2>


                    <p>
                        OJT progress, assessment results, and recommendations
                    </p>


                </div>


            </div>


        </div>


        <div class="evaluation-panel-body">


            @if ($supervisedAssignments->isNotEmpty())


                <div
                    class="student-evaluation-list"
                    id="student-evaluation-list"
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
                            | Assignment Status
                            |--------------------------------------------------------------------------
                            */

                            $assignmentStatus =
                                strtolower(
                                    (string)
                                    $assignment->status
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


                            $validatedAttendance =
                                $attendanceRecords
                                    ->filter(
                                        fn ($record) =>
                                            strtolower(
                                                (string)
                                                $record->status
                                            ) === 'validated'
                                    );


                            $pendingAttendance =
                                $attendanceRecords
                                    ->filter(
                                        fn ($record) =>
                                            strtolower(
                                                (string)
                                                $record->status
                                            ) === 'pending'
                                    );


                            $rejectedAttendance =
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
                            | Work Logs
                            |--------------------------------------------------------------------------
                            */

                            $workLogs =
                                collect(
                                    $assignment
                                        ->dailyWorkLogs
                                    ?? []
                                );


                            $validatedWorkLogs =
                                $workLogs
                                    ->filter(
                                        fn ($log) =>
                                            strtolower(
                                                (string)
                                                $log->status
                                            ) === 'validated'
                                    );


                            $pendingWorkLogs =
                                $workLogs
                                    ->filter(
                                        fn ($log) =>
                                            strtolower(
                                                (string)
                                                $log->status
                                            ) === 'pending'
                                    );


                            $rejectedWorkLogs =
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
                            | Hours
                            |--------------------------------------------------------------------------
                            */

                            $validatedMinutes =
                                (int)
                                $validatedAttendance
                                    ->sum(
                                        fn ($record) =>
                                            (int) (
                                                $record
                                                    ->rendered_minutes
                                                ?? 0
                                            )
                                    );


                            $validatedHours =
                                $validatedMinutes / 60;


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


                            $progress =
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

                            $evaluation =
                                $assignment
                                    ->finalEvaluation;


                            $criteria =
                                $extractCriteria(
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


                            /*
                            |--------------------------------------------------------------------------
                            | Comments
                            |--------------------------------------------------------------------------
                            */

                            $strengths =
                                $evaluationText(
                                    $evaluation,
                                    [
                                        'strengths',
                                        'student_strengths',
                                    ]
                                );


                            $improvements =
                                $evaluationText(
                                    $evaluation,
                                    [
                                        'areas_for_improvement',
                                        'improvements',
                                        'areas_to_improve',
                                    ]
                                );


                            $comments =
                                $evaluationText(
                                    $evaluation,
                                    [
                                        'comments',
                                        'general_comments',
                                        'final_comments',
                                        'remarks',
                                        'supervisor_comments',
                                    ]
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Pending Review Blockers
                            |--------------------------------------------------------------------------
                            */

                            $hasPendingRecords =
                                $pendingAttendance->isNotEmpty()
                                ||
                                $pendingWorkLogs->isNotEmpty();


                            /*
                            |--------------------------------------------------------------------------
                            | Route URLs
                            |--------------------------------------------------------------------------
                            */

                            $createRoute =
                                ! $evaluation
                                    ? $buildEvaluationRoute(
                                        $createRouteCandidates,
                                        $assignment
                                    )
                                    : null;


                            $showRoute =
                                $evaluation
                                    ? $buildEvaluationRoute(
                                        $showRouteCandidates,
                                        $assignment,
                                        $evaluation
                                    )
                                    : null;


                            $editRoute =
                                $evaluation
                                    ? $buildEvaluationRoute(
                                        $editRouteCandidates,
                                        $assignment,
                                        $evaluation
                                    )
                                    : null;


                            /*
                            |--------------------------------------------------------------------------
                            | Search Status
                            |--------------------------------------------------------------------------
                            */

                            $evaluationStatus =
                                $evaluation
                                    ? 'submitted'
                                    : 'pending';


                            $recommendationSearch =
                                strtolower(
                                    (string)
                                    $recommendation
                                );


                            $searchText =
                                strtolower(
                                    implode(
                                        ' ',
                                        [
                                            $studentName,
                                            $studentNumber,
                                            $companyName,
                                            $assignmentStatus,
                                            $evaluationStatus,
                                            $recommendationSearch,
                                        ]
                                    )
                                );

                        @endphp


                        <article
                            class="student-evaluation-card"
                            data-evaluation-card
                            data-search="{{ $searchText }}"
                            data-status="{{ $evaluationStatus }}"
                            data-recommendation="{{ $recommendationSearch }}"
                        >


                            {{-- ==================================================
                                 HEADER
                                 ================================================== --}}

                            <div class="student-evaluation-header">


                                <div class="evaluation-student">


                                    <div class="evaluation-student-avatar">

                                        {{ $makeInitials(
                                            $studentName
                                        ) }}

                                    </div>


                                    <div>


                                        <span class="evaluation-student-name">

                                            {{ $studentName }}

                                        </span>


                                        <span class="evaluation-student-meta">

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


                                @if ($evaluation)


                                    <span
                                        class="
                                            evaluation-status
                                            evaluation-status-completed
                                        "
                                    >
                                        Evaluation Submitted
                                    </span>


                                @elseif (
                                    in_array(
                                        $assignmentStatus,
                                        [
                                            'active',
                                            'completed',
                                        ],
                                        true
                                    )
                                )


                                    <span
                                        class="
                                            evaluation-status
                                            evaluation-status-needed
                                        "
                                    >
                                        Evaluation Required
                                    </span>


                                @else


                                    <span
                                        class="
                                            evaluation-status
                                            evaluation-status-unavailable
                                        "
                                    >
                                        Not Yet Available
                                    </span>


                                @endif


                            </div>


                            {{-- ==================================================
                                 BODY
                                 ================================================== --}}

                            <div class="student-evaluation-body">


                                {{-- ==============================================
                                     OVERVIEW
                                     ============================================== --}}

                                <div class="evaluation-overview-grid">


                                    <div class="evaluation-overview-item">


                                        <span class="evaluation-overview-label">
                                            OJT Company
                                        </span>


                                        <span class="evaluation-overview-value">

                                            {{ $companyName }}

                                        </span>


                                    </div>


                                    <div class="evaluation-overview-item">


                                        <span class="evaluation-overview-label">
                                            Required Hours
                                        </span>


                                        <span class="evaluation-overview-value">

                                            {{ number_format(
                                                $requiredHours,
                                                1
                                            ) }}

                                            hours

                                        </span>


                                    </div>


                                    <div class="evaluation-overview-item">


                                        <span class="evaluation-overview-label">
                                            Training Period
                                        </span>


                                        <span class="evaluation-overview-value">

                                            {{ $formatDate(
                                                $assignment->start_date
                                            ) }}

                                        </span>


                                        <span class="evaluation-overview-secondary">

                                            to

                                            {{ $formatDate(
                                                $assignment->end_date
                                            ) }}

                                        </span>


                                    </div>


                                    <div class="evaluation-overview-item">


                                        <span class="evaluation-overview-label">
                                            Assignment Status
                                        </span>


                                        <span class="evaluation-overview-value">

                                            {{ ucwords(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $assignmentStatus
                                                )
                                            ) }}

                                        </span>


                                    </div>


                                </div>


                                {{-- ==============================================
                                     PROGRESS
                                     ============================================== --}}

                                <section class="evaluation-progress">


                                    <div class="evaluation-progress-top">


                                        <div>


                                            <span class="evaluation-progress-title">
                                                Student OJT Progress
                                            </span>


                                            <span class="evaluation-progress-description">

                                                Validated attendance
                                                compared with the required
                                                OJT hours.

                                            </span>


                                        </div>


                                        <span class="evaluation-progress-value">

                                            {{ number_format(
                                                $validatedHours,
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


                                    <div class="evaluation-progress-track">


                                        <div
                                            class="evaluation-progress-fill"
                                            style="
                                                width:
                                                {{ $progress }}%;
                                            "
                                        ></div>


                                    </div>


                                    <div class="evaluation-progress-stats">


                                        <div class="evaluation-progress-stat">


                                            <span class="evaluation-progress-stat-label">
                                                Progress
                                            </span>


                                            <span class="evaluation-progress-stat-value">

                                                {{ $progress }}%

                                            </span>


                                        </div>


                                        <div class="evaluation-progress-stat">


                                            <span class="evaluation-progress-stat-label">
                                                Validated Days
                                            </span>


                                            <span class="evaluation-progress-stat-value">

                                                {{ $validatedAttendance->count() }}

                                            </span>


                                        </div>


                                        <div class="evaluation-progress-stat">


                                            <span class="evaluation-progress-stat-label">
                                                Validated Logs
                                            </span>


                                            <span class="evaluation-progress-stat-value">

                                                {{ $validatedWorkLogs->count() }}

                                            </span>


                                        </div>


                                        <div class="evaluation-progress-stat">


                                            <span class="evaluation-progress-stat-label">
                                                Pending Review
                                            </span>


                                            <span class="evaluation-progress-stat-value">

                                                {{ $pendingAttendance->count()
                                                    +
                                                    $pendingWorkLogs->count()
                                                }}

                                            </span>


                                        </div>


                                    </div>


                                </section>


                                {{-- ==============================================
                                     EXISTING EVALUATION
                                     ============================================== --}}

                                @if ($evaluation)


                                    <section class="completed-evaluation">


                                        <div class="completed-evaluation-top">


                                            <div>


                                                <span class="completed-evaluation-title">
                                                    Final Evaluation Result
                                                </span>


                                                <span class="completed-evaluation-date">

                                                    Evaluated:

                                                    {{ $formatDateTime(
                                                        $evaluation->evaluated_at
                                                        ?? $evaluation->created_at
                                                    ) }}

                                                </span>


                                            </div>


                                            <span
                                                class="
                                                    recommendation-badge
                                                    {{ $recommendationClass(
                                                        $recommendation
                                                    ) }}
                                                "
                                            >

                                                {{ $recommendationLabel(
                                                    $recommendation
                                                ) }}

                                            </span>


                                        </div>


                                        @if ($criteria->isNotEmpty())


                                            <div class="evaluation-score-summary">


                                                {{-- ==============================
                                                     AVERAGE
                                                     ============================== --}}

                                                <div class="evaluation-average-card">


                                                    <span class="evaluation-average-label">
                                                        Average Rating
                                                    </span>


                                                    <span class="evaluation-average-value">

                                                        {{ number_format(
                                                            $averageScore,
                                                            2
                                                        ) }}

                                                    </span>


                                                    <span class="evaluation-average-max">
                                                        out of 5.00
                                                    </span>


                                                    <span class="evaluation-average-description">

                                                        {{ $ratingLabel(
                                                            $averageScore
                                                        ) }}

                                                    </span>


                                                </div>


                                                {{-- ==============================
                                                     CRITERIA
                                                     ============================== --}}

                                                <div class="evaluation-criteria-grid">


                                                    @foreach (
                                                        $criteria
                                                        as $criterion =>
                                                        $score
                                                    )


                                                        @php

                                                            $criterionPercent =
                                                                min(
                                                                    100,
                                                                    max(
                                                                        0,
                                                                        (
                                                                            (float)
                                                                            $score
                                                                            /
                                                                            5
                                                                        )
                                                                        * 100
                                                                    )
                                                                );

                                                        @endphp


                                                        <div class="evaluation-criterion">


                                                            <div class="evaluation-criterion-top">


                                                                <span class="evaluation-criterion-label">

                                                                    {{ $humanizeAttribute(
                                                                        $criterion
                                                                    ) }}

                                                                </span>


                                                                <span class="evaluation-criterion-score">

                                                                    {{ number_format(
                                                                        (float)
                                                                        $score,
                                                                        1
                                                                    ) }}

                                                                    / 5

                                                                </span>


                                                            </div>


                                                            <div class="evaluation-criterion-track">


                                                                <div
                                                                    class="evaluation-criterion-fill"
                                                                    style="
                                                                        width:
                                                                        {{ $criterionPercent }}%;
                                                                    "
                                                                ></div>


                                                            </div>


                                                        </div>


                                                    @endforeach


                                                </div>


                                            </div>


                                        @endif


                                        {{-- ======================================
                                             COMMENTS
                                             ====================================== --}}

                                        @if (
                                            $strengths
                                            ||
                                            $improvements
                                            ||
                                            $comments
                                        )


                                            <div class="evaluation-comments-grid">


                                                @if ($strengths)


                                                    <div class="evaluation-comment">


                                                        <span class="evaluation-comment-label">
                                                            Student Strengths
                                                        </span>


                                                        <div class="evaluation-comment-value">

                                                            {{ $strengths }}

                                                        </div>


                                                    </div>


                                                @endif


                                                @if ($improvements)


                                                    <div class="evaluation-comment">


                                                        <span class="evaluation-comment-label">
                                                            Areas for Improvement
                                                        </span>


                                                        <div class="evaluation-comment-value">

                                                            {{ $improvements }}

                                                        </div>


                                                    </div>


                                                @endif


                                                @if ($comments)


                                                    <div
                                                        class="
                                                            evaluation-comment
                                                            evaluation-comment-full
                                                        "
                                                    >


                                                        <span class="evaluation-comment-label">
                                                            Supervisor Comments
                                                        </span>


                                                        <div class="evaluation-comment-value">

                                                            {{ $comments }}

                                                        </div>


                                                    </div>


                                                @endif


                                            </div>


                                        @endif


                                    </section>


                                    {{-- ==========================================
                                         COMPLETED EVALUATION ACTIONS
                                         ========================================== --}}

                                    <div class="evaluation-actions">


                                        @if ($showRoute)


                                            <a
                                                href="{{ $showRoute['url'] }}"
                                                class="
                                                    evaluation-action
                                                    evaluation-action-primary
                                                "
                                            >
                                                View Full Evaluation
                                            </a>


                                        @endif


                                        @if (
                                            $editRoute
                                            &&
                                            $assignmentStatus
                                            !== 'completed'
                                        )


                                            <a
                                                href="{{ $editRoute['url'] }}"
                                                class="evaluation-action"
                                            >
                                                Edit Evaluation
                                            </a>


                                        @endif


                                        @if (
                                            \Illuminate\Support\Facades\Route::has(
                                                'supervisor.reports.index'
                                            )
                                        )


                                            <a
                                                href="{{ route(
                                                    'supervisor.reports.index',
                                                    [
                                                        'assignment' =>
                                                            $assignment->id,
                                                    ]
                                                ) }}"
                                                class="evaluation-action"
                                            >
                                                Student Report
                                            </a>


                                        @endif


                                    </div>


                                {{-- ==============================================
                                     NOT YET EVALUATED
                                     ============================================== --}}

                                @else


                                    @if ($hasPendingRecords)


                                        <section
                                            class="
                                                evaluation-readiness
                                                evaluation-readiness-warning
                                            "
                                        >


                                            <span class="evaluation-readiness-title">
                                                Student records still require review
                                            </span>


                                            <div class="evaluation-readiness-description">

                                                This placement currently has

                                                <strong>

                                                    {{ $pendingAttendance->count() }}

                                                    pending attendance record{{ $pendingAttendance->count() === 1 ? '' : 's' }}

                                                </strong>

                                                and

                                                <strong>

                                                    {{ $pendingWorkLogs->count() }}

                                                    pending Daily Work Log{{ $pendingWorkLogs->count() === 1 ? '' : 's' }}.

                                                </strong>

                                                Review those records before
                                                finalizing the Student's overall
                                                performance assessment.

                                            </div>


                                        </section>


                                    @elseif (
                                        $assignmentStatus === 'completed'
                                    )


                                        <section
                                            class="
                                                evaluation-readiness
                                                evaluation-readiness-complete
                                            "
                                        >


                                            <span class="evaluation-readiness-title">
                                                Completed placement without an evaluation
                                            </span>


                                            <div class="evaluation-readiness-description">

                                                This assignment is already
                                                marked as completed, but no
                                                final evaluation is currently
                                                attached to the displayed record.

                                            </div>


                                        </section>


                                    @elseif (
                                        $assignmentStatus === 'active'
                                    )


                                        <section
                                            class="
                                                evaluation-readiness
                                                evaluation-readiness-ready
                                            "
                                        >


                                            <span class="evaluation-readiness-title">
                                                Final evaluation has not been submitted
                                            </span>


                                            <div class="evaluation-readiness-description">

                                                You can review this Student's
                                                OJT progress and continue to the
                                                final evaluation workflow when
                                                appropriate. The Laravel
                                                controller remains responsible
                                                for enforcing the actual
                                                evaluation eligibility rules.

                                            </div>


                                        </section>


                                    @else


                                        <section
                                            class="
                                                evaluation-readiness
                                                evaluation-readiness-warning
                                            "
                                        >


                                            <span class="evaluation-readiness-title">
                                                Evaluation is not yet available
                                            </span>


                                            <div class="evaluation-readiness-description">

                                                This placement currently has
                                                a status of

                                                <strong>

                                                    {{ ucwords(
                                                        str_replace(
                                                            '_',
                                                            ' ',
                                                            $assignmentStatus
                                                        )
                                                    ) }}.

                                                </strong>

                                                Final evaluation availability
                                                remains controlled by the
                                                application workflow.

                                            </div>


                                        </section>


                                    @endif


                                    {{-- ==========================================
                                         CREATE ACTION
                                         ========================================== --}}

                                    <div class="evaluation-actions">


                                        @if ($createRoute)


                                            <a
                                                href="{{ $createRoute['url'] }}"
                                                class="
                                                    evaluation-action
                                                    evaluation-action-primary
                                                "
                                            >
                                                Start Final Evaluation
                                            </a>


                                        @endif


                                        @if (
                                            \Illuminate\Support\Facades\Route::has(
                                                'supervisor.reports.index'
                                            )
                                        )


                                            <a
                                                href="{{ route(
                                                    'supervisor.reports.index',
                                                    [
                                                        'assignment' =>
                                                            $assignment->id,
                                                    ]
                                                ) }}"
                                                class="evaluation-action"
                                            >
                                                Review Student Report
                                            </a>


                                        @endif


                                        @if (
                                            \Illuminate\Support\Facades\Route::has(
                                                'supervisor.validations.index'
                                            )
                                        )


                                            <a
                                                href="{{ route(
                                                    'supervisor.validations.index'
                                                ) }}"
                                                class="evaluation-action"
                                            >
                                                Attendance Validation
                                            </a>


                                        @endif


                                        @if (
                                            \Illuminate\Support\Facades\Route::has(
                                                'supervisor.work-logs.index'
                                            )
                                        )


                                            <a
                                                href="{{ route(
                                                    'supervisor.work-logs.index'
                                                ) }}"
                                                class="evaluation-action"
                                            >
                                                Work Log Review
                                            </a>


                                        @endif


                                    </div>


                                    @if (! $createRoute)


                                        <div class="evaluation-info-note">

                                            <strong>
                                                Evaluation data is displayed correctly.
                                            </strong>

                                            The page could not automatically
                                            identify the existing named route
                                            used to start this Student's final
                                            evaluation. No backend record has
                                            been modified.

                                        </div>


                                    @endif


                                @endif


                            </div>


                        </article>


                    @endforeach


                </div>


                <div
                    class="evaluation-filter-empty"
                    id="evaluation-filter-empty"
                >

                    No Student evaluations match
                    your current search or filter.

                </div>


            @else


                <div class="evaluation-empty">


                    <div class="evaluation-empty-icon">
                        EV
                    </div>


                    <h3>
                        No Students Available for Evaluation
                    </h3>


                    <p>

                        OJT Assignments connected to your
                        Supervisor account will appear here
                        together with Student progress,
                        validated attendance, Daily Work Logs,
                        and final evaluation information.

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
                    'evaluation-search'
                );


            const statusFilter =
                document.getElementById(
                    'evaluation-status-filter'
                );


            const cards =
                Array.from(
                    document.querySelectorAll(
                        '[data-evaluation-card]'
                    )
                );


            const visibleCount =
                document.getElementById(
                    'evaluation-visible-count'
                );


            const emptyMessage =
                document.getElementById(
                    'evaluation-filter-empty'
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


                            const recommendation =
                                (
                                    card.dataset.recommendation
                                    || ''
                                )
                                    .toLowerCase();


                            const matchesSearch =
                                ! search
                                ||
                                searchable.includes(
                                    search
                                );


                            let matchesFilter = true;


                            if (filter) {

                                if (
                                    filter === 'submitted'
                                    ||
                                    filter === 'pending'
                                ) {

                                    matchesFilter =
                                        status === filter;

                                } else {

                                    matchesFilter =
                                        recommendation === filter;

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