@extends('layouts.app')


@section('title', 'OJT Assignment History | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC - STUDENT ASSIGNMENT HISTORY
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --history-navy: #183B6B;
        --history-navy-dark: #102A4A;

        --history-blue: #2563EB;
        --history-blue-soft: #EAF2FF;

        --history-green: #15803D;
        --history-green-soft: #EAF8EF;

        --history-teal: #0F766E;
        --history-teal-soft: #E7F7F5;

        --history-orange: #B45309;
        --history-orange-soft: #FFF5E6;

        --history-red: #B42318;
        --history-red-soft: #FFF0EE;

        --history-purple: #6D4FC2;
        --history-purple-soft: #F2EEFF;

        --history-gray: #475569;
        --history-gray-soft: #F1F5F9;

        --history-text: #102A4A;
        --history-body: #405872;
        --history-muted: #64778C;

        --history-white: #FFFFFF;
        --history-soft: #F8FBFE;

        --history-border: #D8E3EE;
        --history-border-soft: #E7EDF4;

        --history-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --history-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --history-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .assignment-history-page {
        width: 100%;

        color:
            var(--history-text);

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

    .history-hero {
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
                rgba(167, 139, 250, 0.18),
                transparent 25%
            ),
            radial-gradient(
                circle at 70% 90%,
                rgba(45, 212, 191, 0.13),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 55%,
                #205F79 100%
            );

        box-shadow:
            var(--history-shadow-large);
    }


    .history-hero::before {
        content: "";

        position: absolute;

        width: 340px;
        height: 340px;

        right: -130px;
        top: -190px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.06);
    }


    .history-hero::after {
        content: "";

        position: absolute;

        width: 210px;
        height: 210px;

        right: 250px;
        bottom: -145px;

        border-radius: 50%;

        background:
            rgba(45, 212, 191, 0.07);
    }


    .history-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 36px;
    }


    .history-hero-copy {
        max-width: 760px;

        min-width: 0;
    }


    .history-eyebrow {
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


    .history-eyebrow-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background:
            #A78BFA;

        box-shadow:
            0 0 0 5px
            rgba(167, 139, 250, 0.13);
    }


    .history-hero h1 {
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


    .history-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO STUDENT CARD
       ================================================================ */

    .history-student-card {
        width: 320px;

        flex-shrink: 0;

        display: flex;
        align-items: center;

        gap: 15px;

        padding: 19px;

        border:
            1px solid
            rgba(255, 255, 255, 0.16);

        border-radius: 18px;

        background:
            rgba(255, 255, 255, 0.10);

        backdrop-filter:
            blur(10px);
    }


    .history-student-avatar {
        width: 60px;
        height: 60px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border:
            1px solid
            rgba(255, 255, 255, 0.14);

        border-radius: 17px;

        background:
            rgba(255, 255, 255, 0.11);

        color:
            #FFFFFF;

        font-size: 18px;
        font-weight: 900;
    }


    .history-student-label {
        display: block;

        margin-bottom: 3px;

        color:
            rgba(255, 255, 255, 0.67);

        font-size: 12px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .history-student-name {
        display: block;

        color: #FFFFFF;

        font-size: 17px;
        font-weight: 900;

        line-height: 1.4;
    }


    .history-student-number {
        display: block;

        margin-top: 3px;

        color:
            rgba(255, 255, 255, 0.76);

        font-size: 14px;
    }


    /* ================================================================
       SUMMARY
       ================================================================ */

    .history-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 19px;

        margin-bottom: 28px;
    }


    .history-summary-card {
        padding: 24px;

        border:
            1px solid
            var(--history-border);

        border-radius: 20px;

        background:
            var(--history-white);

        box-shadow:
            var(--history-shadow);

        transition:
            var(--history-transition);
    }


    .history-summary-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            0 18px 38px
            rgba(15, 42, 74, 0.10);
    }


    .history-summary-icon {
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
            var(--history-blue-soft);

        color:
            var(--history-blue);
    }


    .summary-green {
        background:
            var(--history-green-soft);

        color:
            var(--history-green);
    }


    .summary-purple {
        background:
            var(--history-purple-soft);

        color:
            var(--history-purple);
    }


    .summary-teal {
        background:
            var(--history-teal-soft);

        color:
            var(--history-teal);
    }


    .history-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--history-body);

        font-size: 15px;
        font-weight: 750;
    }


    .history-summary-value {
        display: block;

        color:
            var(--history-text);

        font-size: 32px;
        font-weight: 900;

        line-height: 1.15;
    }


    .history-summary-unit {
        color:
            var(--history-muted);

        font-size: 16px;
        font-weight: 750;
    }


    .history-summary-note {
        display: block;

        margin-top: 9px;

        color:
            var(--history-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       FILTER BAR
       ================================================================ */

    .history-filter-panel {
        margin-bottom: 27px;

        padding:
            21px
            22px;

        border:
            1px solid
            var(--history-border);

        border-radius: 18px;

        background:
            var(--history-white);

        box-shadow:
            var(--history-shadow);
    }


    .history-filter-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 16px;
    }


    .history-filter-title {
        display: block;

        margin-bottom: 3px;

        color:
            var(--history-text);

        font-size: 18px;
        font-weight: 850;
    }


    .history-filter-description {
        color:
            var(--history-muted);

        font-size: 14px;
    }


    .history-record-count {
        padding:
            8px
            12px;

        border-radius: 999px;

        background:
            var(--history-gray-soft);

        color:
            var(--history-body);

        font-size: 14px;
        font-weight: 850;

        white-space: nowrap;
    }


    .history-filter-grid {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            220px;

        gap: 13px;
    }


    .history-search-input,
    .history-filter-select {
        width: 100%;

        min-height: 52px;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background:
            #FBFDFF;

        color:
            var(--history-text);

        font-family:
            inherit;

        font-size: 15px;
        font-weight: 650;
    }


    .history-search-input {
        padding:
            0
            15px;
    }


    .history-filter-select {
        padding:
            0
            13px;

        cursor: pointer;
    }


    .history-search-input:focus,
    .history-filter-select:focus {
        border-color:
            var(--history-blue);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, 0.09);
    }


    /* ================================================================
       MAIN PANEL
       ================================================================ */

    .history-panel {
        overflow: hidden;

        border:
            1px solid
            var(--history-border);

        border-radius: 20px;

        background:
            var(--history-white);

        box-shadow:
            var(--history-shadow);
    }


    .history-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            24px
            26px;

        border-bottom:
            1px solid
            var(--history-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .history-panel-heading {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    .history-panel-icon {
        width: 50px;
        height: 50px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background:
            var(--history-purple-soft);

        color:
            var(--history-purple);

        font-size: 13px;
        font-weight: 900;
    }


    .history-panel-heading h2 {
        margin:
            0
            0
            4px;

        color:
            var(--history-text);

        font-size: 23px;
        font-weight: 850;

        line-height: 1.3;
    }


    .history-panel-heading p {
        margin: 0;

        color:
            var(--history-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .history-panel-body {
        padding: 26px;
    }


    /* ================================================================
       TIMELINE
       ================================================================ */

    .assignment-timeline {
        position: relative;

        display: grid;

        gap: 22px;
    }


    .assignment-timeline::before {
        content: "";

        position: absolute;

        top: 18px;
        bottom: 18px;
        left: 24px;

        width: 2px;

        background:
            linear-gradient(
                180deg,
                #C7D8EA,
                #E1E9F2
            );
    }


    .assignment-history-item {
        position: relative;

        padding-left: 67px;
    }


    .assignment-timeline-marker {
        position: absolute;

        z-index: 2;

        left: 8px;
        top: 22px;

        width: 34px;
        height: 34px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border:
            5px solid
            #FFFFFF;

        border-radius: 50%;

        box-shadow:
            0 0 0 1px
            var(--history-border);
    }


    .marker-active {
        background:
            var(--history-green);
    }


    .marker-pending {
        background:
            var(--history-orange);
    }


    .marker-completed {
        background:
            var(--history-blue);
    }


    .marker-cancelled {
        background:
            var(--history-red);
    }


    .marker-default {
        background:
            #64748B;
    }


    /* ================================================================
       ASSIGNMENT CARD
       ================================================================ */

    .assignment-history-card {
        overflow: hidden;

        border:
            1px solid
            var(--history-border);

        border-radius: 19px;

        background:
            #FFFFFF;

        transition:
            var(--history-transition);
    }


    .assignment-history-card:hover {
        transform:
            translateY(-2px);

        border-color:
            #BDD0E2;

        box-shadow:
            0 16px 32px
            rgba(15, 42, 74, 0.08);
    }


    .assignment-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 20px;

        padding:
            22px
            23px;

        border-bottom:
            1px solid
            var(--history-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .assignment-company-section {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 16px;
    }


    .assignment-company-avatar {
        width: 58px;
        height: 58px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background:
            var(--history-blue-soft);

        color:
            var(--history-blue);

        font-size: 17px;
        font-weight: 900;
    }


    .assignment-company-name {
        display: block;

        margin-bottom: 4px;

        color:
            var(--history-text);

        font-size: 21px;
        font-weight: 900;

        line-height: 1.4;
    }


    .assignment-company-address {
        display: block;

        color:
            var(--history-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    /* ================================================================
       STATUS
       ================================================================ */

    .assignment-status {
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


    .assignment-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .status-active {
        background:
            var(--history-green-soft);

        color:
            var(--history-green);
    }


    .status-active::before {
        background:
            #22C55E;
    }


    .status-pending {
        background:
            var(--history-orange-soft);

        color:
            var(--history-orange);
    }


    .status-pending::before {
        background:
            #F59E0B;
    }


    .status-completed {
        background:
            var(--history-blue-soft);

        color:
            var(--history-blue);
    }


    .status-completed::before {
        background:
            #3B82F6;
    }


    .status-cancelled {
        background:
            var(--history-red-soft);

        color:
            var(--history-red);
    }


    .status-cancelled::before {
        background:
            #EF4444;
    }


    .status-default {
        background:
            var(--history-gray-soft);

        color:
            var(--history-gray);
    }


    .status-default::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       ASSIGNMENT BODY
       ================================================================ */

    .assignment-card-body {
        padding:
            23px;
    }


    .assignment-detail-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 13px;

        margin-bottom: 19px;
    }


    .assignment-detail-item {
        padding:
            15px;

        border:
            1px solid
            var(--history-border-soft);

        border-radius: 12px;

        background:
            var(--history-soft);
    }


    .assignment-detail-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--history-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing:
            0.25px;
    }


    .assignment-detail-value {
        display: block;

        color:
            var(--history-text);

        font-size: 16px;
        font-weight: 850;

        line-height: 1.5;

        word-break: break-word;
    }


    /* ================================================================
       HOURS PROGRESS
       ================================================================ */

    .assignment-hours-panel {
        padding:
            18px;

        border:
            1px solid
            #D3E5DF;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #F8FCFB 0%,
                #F0F9F7 100%
            );
    }


    .assignment-hours-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 16px;

        margin-bottom: 12px;
    }


    .assignment-hours-title {
        display: block;

        margin-bottom: 3px;

        color:
            var(--history-text);

        font-size: 16px;
        font-weight: 850;
    }


    .assignment-hours-description {
        color:
            var(--history-muted);

        font-size: 14px;
    }


    .assignment-hours-number {
        color:
            var(--history-teal);

        font-size: 22px;
        font-weight: 900;

        white-space: nowrap;
    }


    .assignment-progress-track {
        width: 100%;
        height: 10px;

        overflow: hidden;

        border-radius: 999px;

        background:
            #DCE9E6;
    }


    .assignment-progress-fill {
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
       SECONDARY STATS
       ================================================================ */

    .assignment-stat-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 12px;

        margin-top: 17px;
    }


    .assignment-stat-item {
        padding:
            14px;

        border:
            1px solid
            var(--history-border-soft);

        border-radius: 12px;

        background:
            #FFFFFF;
    }


    .assignment-stat-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--history-muted);

        font-size: 13px;
        font-weight: 750;
    }


    .assignment-stat-value {
        display: block;

        color:
            var(--history-text);

        font-size: 18px;
        font-weight: 900;
    }


    /* ================================================================
       COMPLETION
       ================================================================ */

    .assignment-completion-box {
        margin-top: 17px;

        padding:
            18px;

        border:
            1px solid
            #CADDF3;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #F8FBFF 0%,
                #EFF6FF 100%
            );
    }


    .assignment-completion-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-bottom: 12px;
    }


    .assignment-completion-title {
        color:
            var(--history-text);

        font-size: 17px;
        font-weight: 900;
    }


    .assignment-completion-date {
        color:
            var(--history-blue);

        font-size: 14px;
        font-weight: 850;
    }


    .assignment-completion-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 11px;
    }


    .assignment-completion-item {
        padding:
            13px;

        border:
            1px solid
            rgba(37, 99, 235, 0.08);

        border-radius: 10px;

        background:
            rgba(255, 255, 255, 0.74);
    }


    .assignment-completion-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--history-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .assignment-completion-value {
        color:
            var(--history-text);

        font-size: 15px;
        font-weight: 800;

        line-height: 1.55;
    }


    .assignment-completion-remarks {
        grid-column:
            1 / -1;
    }


    /* ================================================================
       EVALUATION
       ================================================================ */

    .assignment-evaluation-box {
        margin-top: 17px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 16px;

        padding:
            17px
            18px;

        border:
            1px solid
            #DED7F1;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #FBFAFF 0%,
                #F4F0FF 100%
            );
    }


    .assignment-evaluation-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--history-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .assignment-evaluation-value {
        color:
            var(--history-text);

        font-size: 17px;
        font-weight: 900;
    }


    .evaluation-badge {
        display: inline-flex;
        align-items: center;

        padding:
            8px
            12px;

        border-radius: 999px;

        background:
            var(--history-purple-soft);

        color:
            var(--history-purple);

        font-size: 14px;
        font-weight: 850;

        white-space: nowrap;
    }


    /* ================================================================
       NOTES
       ================================================================ */

    .assignment-notes {
        margin-top: 17px;

        padding:
            16px;

        border:
            1px solid
            var(--history-border-soft);

        border-radius: 12px;

        background:
            #FBFCFE;
    }


    .assignment-notes-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--history-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform: uppercase;
    }


    .assignment-notes-text {
        color:
            var(--history-body);

        font-size: 15px;

        line-height: 1.7;

        white-space: pre-line;
    }


    /* ================================================================
       ACTIONS
       ================================================================ */

    .assignment-card-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 10px;

        margin-top: 19px;

        padding-top: 18px;

        border-top:
            1px solid
            var(--history-border-soft);
    }


    .assignment-action-link {
        min-height: 46px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            15px;

        border:
            1px solid
            var(--history-border);

        border-radius: 11px;

        background:
            #FFFFFF;

        color:
            var(--history-navy);

        text-decoration: none;

        font-size: 14px;
        font-weight: 850;

        transition:
            var(--history-transition);
    }


    .assignment-action-link:hover {
        transform:
            translateY(-1px);

        border-color:
            #B8CADC;

        background:
            var(--history-blue-soft);
    }


    .assignment-action-primary {
        border-color:
            var(--history-navy);

        background:
            var(--history-navy);

        color:
            #FFFFFF;
    }


    .assignment-action-primary:hover {
        background:
            var(--history-navy-dark);

        color:
            #FFFFFF;
    }


    /* ================================================================
       EMPTY
       ================================================================ */

    .history-empty {
        padding:
            55px
            24px;

        text-align: center;
    }


    .history-empty-icon {
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
            var(--history-purple-soft);

        color:
            var(--history-purple);

        font-size: 17px;
        font-weight: 900;
    }


    .history-empty h3 {
        margin:
            0
            0
            8px;

        color:
            var(--history-text);

        font-size: 22px;
        font-weight: 900;
    }


    .history-empty p {
        max-width: 570px;

        margin:
            0
            auto;

        color:
            var(--history-body);

        font-size: 16px;

        line-height: 1.7;
    }


    /* ================================================================
       NO FILTER RESULTS
       ================================================================ */

    .history-filter-empty {
        display: none;

        padding:
            40px
            20px;

        text-align: center;

        color:
            var(--history-body);

        font-size: 16px;
    }


    .history-filter-empty.is-visible {
        display: block;
    }


    /* ================================================================
       PAGINATION
       ================================================================ */

    .history-pagination {
        margin-top: 23px;

        padding-top: 21px;

        border-top:
            1px solid
            var(--history-border-soft);
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1180px) {

        .history-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .assignment-detail-grid,
        .assignment-stat-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 850px) {

        .history-hero {
            padding:
                34px
                28px;
        }


        .history-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .history-student-card {
            width: 100%;
        }


        .history-filter-grid {
            grid-template-columns: 1fr;
        }


        .assignment-card-top {
            flex-direction: column;
        }

    }


    @media (max-width: 650px) {

        .history-hero {
            padding:
                29px
                22px;

            border-radius: 22px;
        }


        .history-hero h1 {
            font-size: 31px;
        }


        .history-hero-description {
            font-size: 16px;
        }


        .history-summary-grid,
        .assignment-detail-grid,
        .assignment-stat-grid,
        .assignment-completion-grid {
            grid-template-columns: 1fr;
        }


        .assignment-completion-remarks {
            grid-column: auto;
        }


        .history-panel-header,
        .history-panel-body {
            padding-left: 20px;
            padding-right: 20px;
        }


        .history-panel-heading h2 {
            font-size: 21px;
        }


        .assignment-timeline::before {
            display: none;
        }


        .assignment-history-item {
            padding-left: 0;
        }


        .assignment-timeline-marker {
            display: none;
        }


        .assignment-company-section {
            align-items: flex-start;
        }


        .assignment-company-avatar {
            width: 50px;
            height: 50px;
        }


        .assignment-company-name {
            font-size: 19px;
        }


        .assignment-hours-top,
        .assignment-evaluation-box,
        .assignment-completion-header {
            flex-direction: column;

            align-items: flex-start;
        }


        .assignment-card-actions {
            display: grid;

            grid-template-columns: 1fr;
        }


        .assignment-action-link {
            width: 100%;
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
    | Student Identity
    |--------------------------------------------------------------------------
    */

    $studentName =
        $student?->name
        ?? 'Student';


    $studentNumber =
        $studentProfile?->student_number
        ?? 'Student number unavailable';


    $nameParts =
        preg_split(
            '/\s+/',
            trim(
                $studentName
            )
        );


    $studentInitials =
        collect(
            $nameParts
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
            ->implode('');


    /*
    |--------------------------------------------------------------------------
    | Complete Assignment Collection
    |--------------------------------------------------------------------------
    |
    | This collection is used for the overall history summary.
    |
    */

    if ($studentProfile) {

        $allStudentAssignments =
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

        $allStudentAssignments =
            collect();

    }


    /*
    |--------------------------------------------------------------------------
    | Controller Assignment Source
    |--------------------------------------------------------------------------
    |
    | Preserve the existing controller's collection/paginator if it supplies
    | one. Otherwise display the complete Student assignment collection.
    |
    */

    $assignmentSource =
        $assignments
        ?? $history
        ?? $allStudentAssignments;


    $historyAssignments =
        method_exists(
            $assignmentSource,
            'getCollection'
        )
            ? $assignmentSource->getCollection()
            : collect(
                $assignmentSource
            );


    /*
    |--------------------------------------------------------------------------
    | Ensure Required Relationships
    |--------------------------------------------------------------------------
    */

    foreach ($historyAssignments as $historyAssignment) {

        $historyAssignment->loadMissing([
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
    | Global History Statistics
    |--------------------------------------------------------------------------
    */

    $totalAssignments =
        $allStudentAssignments->count();


    $completedAssignments =
        $allStudentAssignments
            ->filter(
                fn ($item) =>
                    strtolower(
                        (string) $item->status
                    ) === 'completed'
            )
            ->count();


    $activeAssignments =
        $allStudentAssignments
            ->filter(
                fn ($item) =>
                    strtolower(
                        (string) $item->status
                    ) === 'active'
            )
            ->count();


    $companyCount =
        $allStudentAssignments
            ->pluck(
                'company_id'
            )
            ->filter()
            ->unique()
            ->count();


    /*
    |--------------------------------------------------------------------------
    | Total Validated Minutes Across Assignments
    |--------------------------------------------------------------------------
    */

    $totalValidatedMinutes =
        $allStudentAssignments
            ->sum(
                function ($item) {

                    return collect(
                        $item->attendanceRecords
                        ?? []
                    )
                        ->filter(
                            fn ($attendance) =>
                                strtolower(
                                    (string)
                                    $attendance->status
                                ) === 'validated'
                        )
                        ->sum(
                            fn ($attendance) =>
                                (int) (
                                    $attendance
                                        ->rendered_minutes
                                    ?? 0
                                )
                        );

                }
            );


    $totalValidatedHours =
        $totalValidatedMinutes / 60;


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
    | Status Class
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


    /*
    |--------------------------------------------------------------------------
    | Timeline Marker
    |--------------------------------------------------------------------------
    */

    $markerClass =
        function ($status) {

            return match (
                strtolower(
                    (string) $status
                )
            ) {

                'active' =>
                    'marker-active',

                'pending' =>
                    'marker-pending',

                'completed' =>
                    'marker-completed',

                'cancelled' =>
                    'marker-cancelled',

                default =>
                    'marker-default',

            };

        };


    /*
    |--------------------------------------------------------------------------
    | Status Label
    |--------------------------------------------------------------------------
    */

    $statusLabel =
        function ($status) {

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
    | Initials Helper
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
                collect(
                    $parts
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
                    ->implode('');


            return
                $initials
                ?: 'OJ';

        };


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

@endphp


<div class="assignment-history-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="history-hero">


        <div class="history-hero-inner">


            <div class="history-hero-copy">


                <div class="history-eyebrow">


                    <span class="history-eyebrow-dot"></span>


                    Student Portal · OJT Placement Archive


                </div>


                <h1>
                    OJT Assignment History
                </h1>


                <p class="history-hero-description">

                    Review your current and previous OJT placements,
                    companies, Supervisors, validated rendered hours,
                    attendance records, Daily Work Logs, final
                    evaluations, and formal completion information.

                </p>


            </div>


            <div class="history-student-card">


                <div class="history-student-avatar">

                    {{ $studentInitials ?: 'ST' }}

                </div>


                <div>


                    <span class="history-student-label">
                        Student Record
                    </span>


                    <span class="history-student-name">

                        {{ $studentName }}

                    </span>


                    <span class="history-student-number">

                        {{ $studentNumber }}

                    </span>


                </div>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="history-summary-grid">


        <article class="history-summary-card">


            <div class="history-summary-icon summary-blue">
                OJ
            </div>


            <span class="history-summary-label">
                Total Placements
            </span>


            <span class="history-summary-value">

                {{ $totalAssignments }}

            </span>


            <span class="history-summary-note">

                All OJT Assignments connected
                to your Student Profile.

            </span>


        </article>


        <article class="history-summary-card">


            <div class="history-summary-icon summary-green">
                ✓
            </div>


            <span class="history-summary-label">
                Completed Placements
            </span>


            <span class="history-summary-value">

                {{ $completedAssignments }}

            </span>


            <span class="history-summary-note">

                Placements formally marked
                as completed.

            </span>


        </article>


        <article class="history-summary-card">


            <div class="history-summary-icon summary-purple">
                HR
            </div>


            <span class="history-summary-label">
                Validated OJT Hours
            </span>


            <span class="history-summary-value">

                {{ number_format(
                    $totalValidatedHours,
                    1
                ) }}

                <span class="history-summary-unit">
                    hrs
                </span>

            </span>


            <span class="history-summary-note">

                Combined validated attendance
                hours from your placements.

            </span>


        </article>


        <article class="history-summary-card">


            <div class="history-summary-icon summary-teal">
                CO
            </div>


            <span class="history-summary-label">
                Training Companies
            </span>


            <span class="history-summary-value">

                {{ $companyCount }}

            </span>


            <span class="history-summary-note">

                Unique companies represented
                in your OJT history.

            </span>


        </article>


    </section>


    {{-- ==================================================================
         FILTERS
         ================================================================== --}}

    @if ($historyAssignments->isNotEmpty())


        <section class="history-filter-panel">


            <div class="history-filter-top">


                <div>


                    <span class="history-filter-title">
                        Find an OJT Placement
                    </span>


                    <span class="history-filter-description">

                        Search or filter the placement records
                        currently shown on this page.

                    </span>


                </div>


                <span
                    class="history-record-count"
                    id="visible-assignment-count"
                >

                    {{ $historyAssignments->count() }}
                    records

                </span>


            </div>


            <div class="history-filter-grid">


                <input
                    type="search"
                    id="assignment-history-search"
                    class="history-search-input"
                    placeholder="Search company, Supervisor, status, or year..."
                    autocomplete="off"
                >


                <select
                    id="assignment-history-status"
                    class="history-filter-select"
                >

                    <option value="">
                        All Statuses
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

                </select>


            </div>


        </section>


    @endif


    {{-- ==================================================================
         ASSIGNMENT HISTORY
         ================================================================== --}}

    <section class="history-panel">


        <div class="history-panel-header">


            <div class="history-panel-heading">


                <div class="history-panel-icon">
                    HS
                </div>


                <div>


                    <h2>
                        Placement History
                    </h2>


                    <p>
                        Detailed OJT assignment lifecycle and records
                    </p>


                </div>


            </div>


        </div>


        <div class="history-panel-body">


            @if ($historyAssignments->isNotEmpty())


                <div
                    class="assignment-timeline"
                    id="assignment-history-list"
                >


                    @foreach ($historyAssignments as $historyAssignment)


                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | Assignment Status
                            |--------------------------------------------------------------------------
                            */

                            $historyStatus =
                                strtolower(
                                    (string)
                                    $historyAssignment->status
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Attendance
                            |--------------------------------------------------------------------------
                            */

                            $attendanceRecords =
                                collect(
                                    $historyAssignment
                                        ->attendanceRecords
                                    ?? []
                                );


                            $validatedAttendance =
                                $attendanceRecords
                                    ->filter(
                                        fn ($attendance) =>
                                            strtolower(
                                                (string)
                                                $attendance->status
                                            ) === 'validated'
                                    );


                            $pendingAttendance =
                                $attendanceRecords
                                    ->filter(
                                        fn ($attendance) =>
                                            strtolower(
                                                (string)
                                                $attendance->status
                                            ) === 'pending'
                                    );


                            /*
                            |--------------------------------------------------------------------------
                            | Validated Hours
                            |--------------------------------------------------------------------------
                            */

                            $validatedMinutes =
                                (int) $validatedAttendance
                                    ->sum(
                                        fn ($attendance) =>
                                            (int) (
                                                $attendance
                                                    ->rendered_minutes
                                                ?? 0
                                            )
                                    );


                            $validatedHours =
                                $validatedMinutes / 60;


                            $requiredHours =
                                (float) (
                                    $historyAssignment
                                        ->required_hours
                                    ?? 0
                                );


                            $requiredMinutes =
                                (int) round(
                                    $requiredHours
                                    * 60
                                );


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
                            | Work Logs
                            |--------------------------------------------------------------------------
                            */

                            $workLogs =
                                collect(
                                    $historyAssignment
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


                            /*
                            |--------------------------------------------------------------------------
                            | Final Evaluation
                            |--------------------------------------------------------------------------
                            */

                            $evaluation =
                                $historyAssignment
                                    ->finalEvaluation;


                            /*
                            |--------------------------------------------------------------------------
                            | Company
                            |--------------------------------------------------------------------------
                            */

                            $companyName =
                                $historyAssignment
                                    ->company
                                    ?->name
                                ?? 'Company unavailable';


                            $companyAddress =
                                $historyAssignment
                                    ->company
                                    ?->address
                                ?? 'Company address not provided';


                            /*
                            |--------------------------------------------------------------------------
                            | Supervisor
                            |--------------------------------------------------------------------------
                            */

                            $supervisorName =
                                $historyAssignment
                                    ->supervisor
                                    ?->name
                                ?? 'Supervisor unavailable';


                            /*
                            |--------------------------------------------------------------------------
                            | Searchable Text
                            |--------------------------------------------------------------------------
                            */

                            $searchText =
                                strtolower(
                                    implode(
                                        ' ',
                                        [
                                            $companyName,
                                            $supervisorName,
                                            $historyStatus,
                                            $historyAssignment
                                                ->start_date,
                                            $historyAssignment
                                                ->end_date,
                                        ]
                                    )
                                );

                        @endphp


                        <article
                            class="assignment-history-item"
                            data-assignment-card
                            data-status="{{ $historyStatus }}"
                            data-search="{{ $searchText }}"
                        >


                            <span
                                class="
                                    assignment-timeline-marker
                                    {{ $markerClass(
                                        $historyStatus
                                    ) }}
                                "
                            ></span>


                            <div class="assignment-history-card">


                                {{-- ======================================
                                     TOP
                                     ====================================== --}}

                                <div class="assignment-card-top">


                                    <div class="assignment-company-section">


                                        <div class="assignment-company-avatar">

                                            {{ $makeInitials(
                                                $companyName
                                            ) }}

                                        </div>


                                        <div>


                                            <span class="assignment-company-name">

                                                {{ $companyName }}

                                            </span>


                                            <span class="assignment-company-address">

                                                {{ $companyAddress }}

                                            </span>


                                        </div>


                                    </div>


                                    <span
                                        class="
                                            assignment-status
                                            {{ $statusClass(
                                                $historyStatus
                                            ) }}
                                        "
                                    >

                                        {{ $statusLabel(
                                            $historyStatus
                                        ) }}

                                    </span>


                                </div>


                                {{-- ======================================
                                     BODY
                                     ====================================== --}}

                                <div class="assignment-card-body">


                                    {{-- ==================================
                                         PLACEMENT DETAILS
                                         ================================== --}}

                                    <div class="assignment-detail-grid">


                                        <div class="assignment-detail-item">


                                            <span class="assignment-detail-label">
                                                Supervisor
                                            </span>


                                            <span class="assignment-detail-value">

                                                {{ $supervisorName }}

                                            </span>


                                        </div>


                                        <div class="assignment-detail-item">


                                            <span class="assignment-detail-label">
                                                Required Hours
                                            </span>


                                            <span class="assignment-detail-value">

                                                {{ number_format(
                                                    $requiredHours,
                                                    1
                                                ) }}

                                                hours

                                            </span>


                                        </div>


                                        <div class="assignment-detail-item">


                                            <span class="assignment-detail-label">
                                                Start Date
                                            </span>


                                            <span class="assignment-detail-value">

                                                {{ $formatDate(
                                                    $historyAssignment
                                                        ->start_date
                                                ) }}

                                            </span>


                                        </div>


                                        <div class="assignment-detail-item">


                                            <span class="assignment-detail-label">
                                                End Date
                                            </span>


                                            <span class="assignment-detail-value">

                                                {{ $formatDate(
                                                    $historyAssignment
                                                        ->end_date
                                                ) }}

                                            </span>


                                        </div>


                                    </div>


                                    {{-- ==================================
                                         HOURS PROGRESS
                                         ================================== --}}

                                    <div class="assignment-hours-panel">


                                        <div class="assignment-hours-top">


                                            <div>


                                                <span class="assignment-hours-title">
                                                    Validated OJT Hour Progress
                                                </span>


                                                <span class="assignment-hours-description">

                                                    Only Supervisor-validated
                                                    attendance contributes
                                                    to this total.

                                                </span>


                                            </div>


                                            <div class="assignment-hours-number">

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

                                            </div>


                                        </div>


                                        <div class="assignment-progress-track">


                                            <div
                                                class="assignment-progress-fill"
                                                style="
                                                    width:
                                                    {{ $progressPercentage }}%;
                                                "
                                            ></div>


                                        </div>


                                        <div class="assignment-stat-grid">


                                            <div class="assignment-stat-item">


                                                <span class="assignment-stat-label">
                                                    Progress
                                                </span>


                                                <span class="assignment-stat-value">

                                                    {{ $progressPercentage }}%

                                                </span>


                                            </div>


                                            <div class="assignment-stat-item">


                                                <span class="assignment-stat-label">
                                                    Attendance
                                                </span>


                                                <span class="assignment-stat-value">

                                                    {{ $attendanceRecords->count() }}

                                                </span>


                                            </div>


                                            <div class="assignment-stat-item">


                                                <span class="assignment-stat-label">
                                                    Validated Days
                                                </span>


                                                <span class="assignment-stat-value">

                                                    {{ $validatedAttendance->count() }}

                                                </span>


                                            </div>


                                            <div class="assignment-stat-item">


                                                <span class="assignment-stat-label">
                                                    Work Logs
                                                </span>


                                                <span class="assignment-stat-value">

                                                    {{ $workLogs->count() }}

                                                </span>


                                            </div>


                                        </div>


                                    </div>


                                    {{-- ==================================
                                         COMPLETION
                                         ================================== --}}

                                    @if ($historyStatus === 'completed')


                                        <div class="assignment-completion-box">


                                            <div class="assignment-completion-header">


                                                <span class="assignment-completion-title">
                                                    Formal OJT Completion
                                                </span>


                                                <span class="assignment-completion-date">

                                                    Completed:

                                                    {{ $formatDate(
                                                        $historyAssignment
                                                            ->completed_at
                                                    ) }}

                                                </span>


                                            </div>


                                            <div class="assignment-completion-grid">


                                                <div class="assignment-completion-item">


                                                    <span class="assignment-completion-label">
                                                        Completed By
                                                    </span>


                                                    <div class="assignment-completion-value">

                                                        {{ $historyAssignment
                                                            ->completedBy
                                                            ?->name
                                                            ?? 'Administrator'
                                                        }}

                                                    </div>


                                                </div>


                                                <div class="assignment-completion-item">


                                                    <span class="assignment-completion-label">
                                                        Validated Work Logs
                                                    </span>


                                                    <div class="assignment-completion-value">

                                                        {{ $validatedWorkLogs->count() }}

                                                        validated

                                                    </div>


                                                </div>


                                                @if (
                                                    filled(
                                                        $historyAssignment
                                                            ->completion_remarks
                                                    )
                                                )


                                                    <div
                                                        class="
                                                            assignment-completion-item
                                                            assignment-completion-remarks
                                                        "
                                                    >


                                                        <span class="assignment-completion-label">
                                                            Completion Remarks
                                                        </span>


                                                        <div class="assignment-completion-value">

                                                            {{ $historyAssignment
                                                                ->completion_remarks
                                                            }}

                                                        </div>


                                                    </div>


                                                @endif


                                            </div>


                                        </div>


                                    @endif


                                    {{-- ==================================
                                         FINAL EVALUATION
                                         ================================== --}}

                                    <div class="assignment-evaluation-box">


                                        <div>


                                            <span class="assignment-evaluation-label">
                                                Supervisor Final Evaluation
                                            </span>


                                            <div class="assignment-evaluation-value">


                                                @if ($evaluation)

                                                    Evaluation submitted

                                                @else

                                                    No final evaluation recorded

                                                @endif


                                            </div>


                                        </div>


                                        @if ($evaluation)


                                            <span class="evaluation-badge">

                                                {{ ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        (string)
                                                        $evaluation
                                                            ->recommendation
                                                    )
                                                ) }}

                                            </span>


                                        @endif


                                    </div>


                                    {{-- ==================================
                                         NOTES
                                         ================================== --}}

                                    @if (
                                        filled(
                                            $historyAssignment->notes
                                        )
                                    )


                                        <div class="assignment-notes">


                                            <span class="assignment-notes-label">
                                                Placement Notes
                                            </span>


                                            <div class="assignment-notes-text">

                                                {{ $historyAssignment->notes }}

                                            </div>


                                        </div>


                                    @endif


                                    {{-- ==================================
                                         ACTIONS
                                         ================================== --}}

                                    <div class="assignment-card-actions">


                                        @if (
                                            $routeExists(
                                                'student.timesheets.index'
                                            )
                                        )


                                            <a
                                                href="{{ route(
                                                    'student.timesheets.index',
                                                    [
                                                        'assignment' =>
                                                            $historyAssignment->id,
                                                    ]
                                                ) }}"
                                                class="
                                                    assignment-action-link
                                                    assignment-action-primary
                                                "
                                            >
                                                View Timesheet
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
                                                    [
                                                        'assignment' =>
                                                            $historyAssignment->id,
                                                    ]
                                                ) }}"
                                                class="assignment-action-link"
                                            >
                                                Attendance
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
                                                    [
                                                        'assignment' =>
                                                            $historyAssignment->id,
                                                    ]
                                                ) }}"
                                                class="assignment-action-link"
                                            >
                                                Daily Work Logs
                                            </a>


                                        @endif


                                        @if (
                                            $routeExists(
                                                'student.reports.index'
                                            )
                                        )


                                            <a
                                                href="{{ route(
                                                    'student.reports.index',
                                                    [
                                                        'assignment' =>
                                                            $historyAssignment->id,
                                                    ]
                                                ) }}"
                                                class="assignment-action-link"
                                            >
                                                OJT Report
                                            </a>


                                        @endif


                                    </div>


                                </div>


                            </div>


                        </article>


                    @endforeach


                </div>


                {{-- ======================================================
                     CLIENT FILTER EMPTY
                     ====================================================== --}}

                <div
                    class="history-filter-empty"
                    id="history-filter-empty"
                >

                    No OJT placements match your current search
                    or status filter.

                </div>


                {{-- ======================================================
                     PAGINATION
                     ====================================================== --}}

                @if (
                    method_exists(
                        $assignmentSource,
                        'hasPages'
                    )
                    &&
                    $assignmentSource->hasPages()
                )


                    <div class="history-pagination">

                        {{ $assignmentSource
                            ->withQueryString()
                            ->links()
                        }}

                    </div>


                @endif


            @else


                <div class="history-empty">


                    <div class="history-empty-icon">
                        HS
                    </div>


                    <h3>
                        No OJT Assignment History Yet
                    </h3>


                    <p>

                        Your current and previous OJT placements
                        will appear here after an Administrator
                        creates an OJT Assignment for your
                        Student Profile.

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
            | Assignment History Client-Side Filter
            |--------------------------------------------------------------------------
            */

            const searchInput =
                document.getElementById(
                    'assignment-history-search'
                );


            const statusSelect =
                document.getElementById(
                    'assignment-history-status'
                );


            const cards =
                Array.from(
                    document.querySelectorAll(
                        '[data-assignment-card]'
                    )
                );


            const countLabel =
                document.getElementById(
                    'visible-assignment-count'
                );


            const emptyMessage =
                document.getElementById(
                    'history-filter-empty'
                );


            if (
                ! cards.length
                ||
                ! searchInput
                ||
                ! statusSelect
            ) {
                return;
            }


            const applyFilter =
                function () {

                    const search =
                        searchInput
                            .value
                            .trim()
                            .toLowerCase();


                    const status =
                        statusSelect
                            .value
                            .trim()
                            .toLowerCase();


                    let visibleCount = 0;


                    cards.forEach(
                        function (card) {

                            const cardSearch =
                                (
                                    card.dataset.search
                                    || ''
                                )
                                    .toLowerCase();


                            const cardStatus =
                                (
                                    card.dataset.status
                                    || ''
                                )
                                    .toLowerCase();


                            const matchesSearch =
                                ! search
                                ||
                                cardSearch.includes(
                                    search
                                );


                            const matchesStatus =
                                ! status
                                ||
                                cardStatus
                                ===
                                status;


                            const visible =
                                matchesSearch
                                &&
                                matchesStatus;


                            card.style.display =
                                visible
                                    ? ''
                                    : 'none';


                            if (visible) {
                                visibleCount++;
                            }

                        }
                    );


                    if (countLabel) {

                        countLabel.textContent =
                            visibleCount
                            +
                            (
                                visibleCount === 1
                                    ? ' record'
                                    : ' records'
                            );

                    }


                    if (emptyMessage) {

                        emptyMessage.classList.toggle(
                            'is-visible',
                            visibleCount === 0
                        );

                    }

                };


            searchInput.addEventListener(
                'input',
                applyFilter
            );


            statusSelect.addEventListener(
                'change',
                applyFilter
            );

        }
    );

</script>

@endpush