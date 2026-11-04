@extends('layouts.app')

@section('title', 'OJT Assignment Record | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - OJT ASSIGNMENT RECORD
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --oas-navy: #183B6B;
        --oas-navy-dark: #102A4A;
        --oas-navy-deep: #0B223D;

        --oas-blue: #2563EB;
        --oas-blue-light: #60A5FA;
        --oas-blue-soft: #EAF2FF;

        --oas-teal: #0F766E;
        --oas-teal-dark: #0B5F59;
        --oas-teal-soft: #E7F7F5;

        --oas-green: #15803D;
        --oas-green-soft: #EAF8EF;

        --oas-orange: #B45309;
        --oas-orange-soft: #FFF5E6;

        --oas-red: #B42318;
        --oas-red-soft: #FFF0EE;

        --oas-purple: #6D4FC2;
        --oas-purple-soft: #F2EEFF;

        --oas-gray: #475569;
        --oas-gray-soft: #F1F5F9;

        --oas-text: #102A4A;
        --oas-body: #405872;
        --oas-muted: #64778C;

        --oas-white: #FFFFFF;
        --oas-soft: #F8FBFE;

        --oas-border: #D8E3EE;
        --oas-border-soft: #E7EDF4;

        --oas-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --oas-shadow-medium:
            0 18px 42px
            rgba(15, 42, 74, 0.10);

        --oas-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --oas-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .assignment-show-page {
        width: 100%;

        color:
            var(--oas-text);

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

    .assignment-show-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 29px;

        padding:
            43px
            44px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 89% 14%,
                rgba(96, 165, 250, 0.25),
                transparent 27%
            ),
            radial-gradient(
                circle at 71% 96%,
                rgba(45, 212, 191, 0.13),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #0B223D 0%,
                #102A4A 34%,
                #183B6B 67%,
                #17666B 100%
            );

        box-shadow:
            var(--oas-shadow-large);
    }


    .assignment-show-hero::before {
        content: "";

        position: absolute;

        width: 400px;
        height: 400px;

        top: -240px;
        right: -150px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.06);
    }


    .assignment-show-hero::after {
        content: "";

        position: absolute;

        width: 230px;
        height: 230px;

        right: 290px;
        bottom: -170px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.04);
    }


    .assignment-show-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .assignment-show-identity {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 22px;
    }


    .assignment-show-avatar {
        width: 92px;
        height: 92px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border:
            2px solid
            rgba(255, 255, 255, 0.18);

        border-radius: 25px;

        background:
            rgba(255, 255, 255, 0.11);

        color:
            #FFFFFF;

        font-size: 25px;
        font-weight: 900;
    }


    .assignment-show-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 9px;

        padding:
            7px
            12px;

        border:
            1px solid
            rgba(255, 255, 255, 0.16);

        border-radius: 999px;

        background:
            rgba(255, 255, 255, 0.08);

        color:
            rgba(255, 255, 255, 0.92);

        font-size: 14px;
        font-weight: 800;
    }


    .assignment-show-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background:
            var(--oas-blue-light);

        box-shadow:
            0 0 0 5px
            rgba(96, 165, 250, 0.13);
    }


    .assignment-show-hero h1 {
        margin:
            0
            0
            6px;

        color:
            #FFFFFF;

        font-size: 36px;
        font-weight: 900;

        line-height: 1.2;

        letter-spacing:
            -0.4px;
    }


    .assignment-show-hero-subtitle {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.80);

        font-size: 16px;

        line-height: 1.65;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .assignment-show-hero-actions {
        width: 275px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .assignment-show-hero-button {
        min-height: 52px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            17px;

        border:
            1px solid
            rgba(255, 255, 255, 0.18);

        border-radius: 12px;

        font-size: 15px;
        font-weight: 850;

        text-align: center;

        text-decoration: none;

        transition:
            var(--oas-transition);
    }


    .assignment-show-hero-primary {
        background:
            #FFFFFF;

        color:
            var(--oas-navy);
    }


    .assignment-show-hero-primary:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;
    }


    .assignment-show-hero-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .assignment-show-hero-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    /* ================================================================
       SUMMARY
       ================================================================ */

    .assignment-show-summary {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 18px;

        margin-bottom: 27px;
    }


    .assignment-show-summary-card {
        padding: 21px;

        border:
            1px solid
            var(--oas-border);

        border-radius: 18px;

        background:
            #FFFFFF;

        box-shadow:
            var(--oas-shadow);

        transition:
            var(--oas-transition);
    }


    .assignment-show-summary-card:hover {
        transform:
            translateY(-2px);

        box-shadow:
            var(--oas-shadow-medium);
    }


    .assignment-show-summary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--oas-muted);

        font-size: 14px;
        font-weight: 800;
    }


    .assignment-show-summary-value {
        display: block;

        color:
            var(--oas-text);

        font-size: 23px;
        font-weight: 900;

        line-height: 1.3;

        word-break:
            break-word;
    }


    .assignment-show-summary-note {
        display: block;

        margin-top: 5px;

        color:
            var(--oas-muted);

        font-size: 13px;

        line-height: 1.5;
    }


    /* ================================================================
       STATUS
       ================================================================ */

    .assignment-show-status {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding:
            8px
            12px;

        border-radius: 999px;

        font-size: 14px;
        font-weight: 900;

        text-transform:
            capitalize;
    }


    .assignment-show-status::before {
        content: "";

        width: 8px;
        height: 8px;

        border-radius: 50%;
    }


    .status-pending {
        background:
            var(--oas-orange-soft);

        color:
            var(--oas-orange);
    }


    .status-pending::before {
        background:
            #F59E0B;
    }


    .status-active {
        background:
            var(--oas-green-soft);

        color:
            var(--oas-green);
    }


    .status-active::before {
        background:
            #22C55E;
    }


    .status-completed {
        background:
            var(--oas-teal-soft);

        color:
            var(--oas-teal);
    }


    .status-completed::before {
        background:
            #14B8A6;
    }


    .status-cancelled {
        background:
            var(--oas-red-soft);

        color:
            var(--oas-red);
    }


    .status-cancelled::before {
        background:
            #D92D20;
    }


    .status-other {
        background:
            var(--oas-gray-soft);

        color:
            var(--oas-gray);
    }


    .status-other::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       MAIN LAYOUT
       ================================================================ */

    .assignment-show-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            355px;

        gap: 24px;

        align-items: start;
    }


    .assignment-show-main,
    .assignment-show-sidebar {
        display: grid;

        gap: 22px;
    }


    /* ================================================================
       PANELS
       ================================================================ */

    .assignment-show-panel {
        overflow: hidden;

        border:
            1px solid
            var(--oas-border);

        border-radius: 20px;

        background:
            #FFFFFF;

        box-shadow:
            var(--oas-shadow);
    }


    .assignment-show-panel-header {
        display: flex;
        align-items: center;

        gap: 14px;

        padding:
            22px
            23px;

        border-bottom:
            1px solid
            var(--oas-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .assignment-show-panel-icon {
        width: 48px;
        height: 48px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        font-size: 12px;
        font-weight: 900;
    }


    .panel-blue {
        background:
            var(--oas-blue-soft);

        color:
            var(--oas-blue);
    }


    .panel-teal {
        background:
            var(--oas-teal-soft);

        color:
            var(--oas-teal);
    }


    .panel-purple {
        background:
            var(--oas-purple-soft);

        color:
            var(--oas-purple);
    }


    .panel-orange {
        background:
            var(--oas-orange-soft);

        color:
            var(--oas-orange);
    }


    .panel-green {
        background:
            var(--oas-green-soft);

        color:
            var(--oas-green);
    }


    .assignment-show-panel-header h2 {
        margin:
            0
            0
            3px;

        color:
            var(--oas-text);

        font-size: 23px;
        font-weight: 900;

        line-height: 1.3;
    }


    .assignment-show-panel-header p {
        margin: 0;

        color:
            var(--oas-muted);

        font-size: 14px;

        line-height: 1.55;
    }


    .assignment-show-panel-body {
        padding: 23px;
    }


    /* ================================================================
       PEOPLE / ORGANIZATIONS
       ================================================================ */

    .placement-parties-grid {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 14px;
    }


    .placement-party {
        position: relative;

        min-height: 190px;

        padding: 18px;

        border:
            1px solid
            var(--oas-border);

        border-radius: 15px;

        background:
            var(--oas-soft);
    }


    .placement-party-icon {
        width: 48px;
        height: 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 13px;

        border-radius: 13px;

        font-size: 12px;
        font-weight: 900;
    }


    .party-student {
        background:
            var(--oas-blue-soft);

        color:
            var(--oas-blue);
    }


    .party-company {
        background:
            var(--oas-purple-soft);

        color:
            var(--oas-purple);
    }


    .party-supervisor {
        background:
            var(--oas-teal-soft);

        color:
            var(--oas-teal);
    }


    .placement-party-label {
        display: block;

        margin-bottom: 3px;

        color:
            var(--oas-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform:
            uppercase;

        letter-spacing:
            .25px;
    }


    .placement-party-name {
        display: block;

        color:
            var(--oas-text);

        font-size: 18px;
        font-weight: 900;

        line-height: 1.45;

        word-break:
            break-word;
    }


    .placement-party-meta {
        display: block;

        margin-top: 4px;

        color:
            var(--oas-muted);

        font-size: 13px;

        line-height: 1.5;
    }


    .placement-party-link {
        display: inline-flex;

        margin-top: 13px;

        color:
            var(--oas-blue);

        font-size: 13px;
        font-weight: 850;

        text-decoration: none;
    }


    .placement-party-link:hover {
        text-decoration:
            underline;
    }


    /* ================================================================
       PLACEMENT DETAILS
       ================================================================ */

    .placement-details-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 13px;
    }


    .placement-detail {
        min-height: 102px;

        padding:
            15px;

        border:
            1px solid
            var(--oas-border-soft);

        border-radius: 12px;

        background:
            var(--oas-soft);
    }


    .placement-detail-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--oas-muted);

        font-size: 13px;
        font-weight: 850;

        text-transform:
            uppercase;
    }


    .placement-detail-value {
        display: block;

        color:
            var(--oas-text);

        font-size: 17px;
        font-weight: 900;

        line-height: 1.5;
    }


    .placement-detail-helper {
        display: block;

        margin-top: 3px;

        color:
            var(--oas-muted);

        font-size: 13px;
    }


    /* ================================================================
       TIMELINE
       ================================================================ */

    .assignment-timeline {
        position: relative;

        display: grid;

        gap: 18px;

        padding-left: 32px;
    }


    .assignment-timeline::before {
        content: "";

        position: absolute;

        left: 9px;
        top: 10px;
        bottom: 10px;

        width: 2px;

        background:
            #D6E1EC;
    }


    .assignment-timeline-item {
        position: relative;

        padding:
            14px
            15px;

        border:
            1px solid
            var(--oas-border-soft);

        border-radius: 12px;

        background:
            var(--oas-soft);
    }


    .assignment-timeline-item::before {
        content: "";

        position: absolute;

        left: -30px;
        top: 20px;

        width: 13px;
        height: 13px;

        border:
            3px solid
            #FFFFFF;

        border-radius: 50%;

        background:
            var(--oas-blue);

        box-shadow:
            0 0 0 2px
            #BCD1E7;
    }


    .assignment-timeline-label {
        display: block;

        color:
            var(--oas-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform:
            uppercase;
    }


    .assignment-timeline-value {
        display: block;

        margin-top: 3px;

        color:
            var(--oas-text);

        font-size: 17px;
        font-weight: 900;
    }


    .assignment-timeline-note {
        display: block;

        margin-top: 3px;

        color:
            var(--oas-muted);

        font-size: 13px;

        line-height: 1.5;
    }


    /* ================================================================
       NOTES
       ================================================================ */

    .assignment-notes-box {
        padding:
            17px
            18px;

        border:
            1px solid
            #D8E4F1;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #FBFDFF,
                #F5F9FE
            );

        color:
            var(--oas-body);

        font-size: 15px;

        line-height: 1.75;
    }


    .assignment-notes-box strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--oas-text);

        font-size: 16px;
        font-weight: 900;
    }


    /* ================================================================
       FINAL EVALUATION
       ================================================================ */

    .evaluation-overview {
        display: grid;

        grid-template-columns:
            190px
            minmax(0, 1fr);

        gap: 18px;

        align-items: stretch;
    }


    .evaluation-score {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        min-height: 170px;

        padding: 20px;

        border:
            1px solid
            #D8E8E5;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                #FAFDFC,
                #F1FAF7
            );

        text-align: center;
    }


    .evaluation-score-number {
        color:
            var(--oas-teal);

        font-size: 42px;
        font-weight: 900;

        line-height: 1;
    }


    .evaluation-score-total {
        margin-top: 3px;

        color:
            var(--oas-muted);

        font-size: 14px;
        font-weight: 750;
    }


    .evaluation-score-label {
        margin-top: 9px;

        color:
            var(--oas-text);

        font-size: 16px;
        font-weight: 900;
    }


    .evaluation-details {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 11px;
    }


    .evaluation-detail {
        padding:
            13px;

        border:
            1px solid
            var(--oas-border-soft);

        border-radius: 11px;

        background:
            var(--oas-soft);
    }


    .evaluation-detail span {
        display: block;

        color:
            var(--oas-muted);

        font-size: 12px;
        font-weight: 800;

        text-transform:
            uppercase;
    }


    .evaluation-detail strong {
        display: block;

        margin-top: 3px;

        color:
            var(--oas-text);

        font-size: 16px;
        font-weight: 900;
    }


    .evaluation-recommendation {
        margin-top: 14px;

        padding:
            15px;

        border:
            1px solid
            #D8E8E5;

        border-radius: 12px;

        background:
            var(--oas-teal-soft);
    }


    .evaluation-recommendation span {
        display: block;

        color:
            var(--oas-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform:
            uppercase;
    }


    .evaluation-recommendation strong {
        display: block;

        margin-top: 3px;

        color:
            var(--oas-teal);

        font-size: 17px;
        font-weight: 900;
    }


    .evaluation-comments {
        display: grid;

        gap: 11px;

        margin-top: 14px;
    }


    .evaluation-comment {
        padding: 14px;

        border:
            1px solid
            var(--oas-border-soft);

        border-radius: 11px;

        background:
            #FFFFFF;
    }


    .evaluation-comment strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--oas-text);

        font-size: 14px;
        font-weight: 900;
    }


    .evaluation-comment p {
        margin: 0;

        color:
            var(--oas-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       EMPTY EVALUATION
       ================================================================ */

    .evaluation-empty {
        padding:
            29px
            20px;

        border:
            1px dashed
            #C8D6E3;

        border-radius: 14px;

        background:
            #FBFDFF;

        text-align: center;
    }


    .evaluation-empty strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--oas-text);

        font-size: 18px;
        font-weight: 900;
    }


    .evaluation-empty span {
        color:
            var(--oas-muted);

        font-size: 14px;
    }


    /* ================================================================
       SIDEBAR
       ================================================================ */

    .assignment-sidebar-list {
        display: grid;

        gap: 11px;
    }


    .assignment-sidebar-item {
        padding: 14px;

        border:
            1px solid
            var(--oas-border-soft);

        border-radius: 11px;

        background:
            var(--oas-soft);
    }


    .assignment-sidebar-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--oas-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform:
            uppercase;
    }


    .assignment-sidebar-value {
        display: block;

        color:
            var(--oas-text);

        font-size: 16px;
        font-weight: 900;

        line-height: 1.5;

        word-break:
            break-word;
    }


    /* ================================================================
       WORKFLOW CARD
       ================================================================ */

    .assignment-workflow-card {
        padding: 18px;

        border:
            1px solid
            #D7E4F1;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #FBFDFF,
                #F3F8FD
            );
    }


    .assignment-workflow-card strong {
        display: block;

        margin-bottom: 6px;

        color:
            var(--oas-blue);

        font-size: 17px;
        font-weight: 900;
    }


    .assignment-workflow-card p {
        margin: 0;

        color:
            var(--oas-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       COMPLETION RECORD
       ================================================================ */

    .completion-record {
        padding: 17px;

        border:
            1px solid
            #D8E8E5;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #FAFDFC,
                #F2FAF8
            );
    }


    .completion-record-title {
        display: block;

        margin-bottom: 9px;

        color:
            var(--oas-teal);

        font-size: 17px;
        font-weight: 900;
    }


    .completion-record-list {
        display: grid;

        gap: 9px;
    }


    .completion-record-item {
        padding:
            11px
            12px;

        border-radius: 9px;

        background:
            rgba(255, 255, 255, 0.80);
    }


    .completion-record-item span {
        display: block;

        color:
            var(--oas-muted);

        font-size: 12px;
        font-weight: 800;

        text-transform:
            uppercase;
    }


    .completion-record-item strong {
        display: block;

        margin-top: 2px;

        color:
            var(--oas-text);

        font-size: 15px;
        font-weight: 900;

        line-height: 1.5;
    }


    /* ================================================================
       QUICK ACTIONS
       ================================================================ */

    .assignment-quick-actions {
        display: grid;

        gap: 10px;
    }


    .assignment-quick-action {
        width: 100%;

        min-height: 49px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            15px;

        border:
            1px solid
            var(--oas-border);

        border-radius: 11px;

        background:
            #FFFFFF;

        color:
            var(--oas-navy);

        font-size: 15px;
        font-weight: 900;

        text-align: center;

        text-decoration: none;

        transition:
            var(--oas-transition);
    }


    .assignment-quick-action:hover {
        transform:
            translateY(-1px);

        background:
            var(--oas-blue-soft);
    }


    .assignment-quick-action-primary {
        border-color:
            var(--oas-blue);

        background:
            var(--oas-blue);

        color:
            #FFFFFF;
    }


    .assignment-quick-action-primary:hover {
        border-color:
            #1D4ED8;

        background:
            #1D4ED8;

        color:
            #FFFFFF;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1150px) {

        .assignment-show-layout {
            grid-template-columns:
                1fr;
        }


        .assignment-show-sidebar {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .placement-parties-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 950px) {

        .assignment-show-hero-inner {
            flex-direction:
                column;

            align-items:
                flex-start;
        }


        .assignment-show-hero-actions {
            width: 100%;
        }


        .assignment-show-summary {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 760px) {

        .placement-parties-grid,
        .placement-details-grid,
        .evaluation-details {
            grid-template-columns:
                1fr;
        }


        .evaluation-overview {
            grid-template-columns:
                1fr;
        }


        .assignment-show-sidebar {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 650px) {

        .assignment-show-hero {
            padding:
                29px
                22px;

            border-radius:
                22px;
        }


        .assignment-show-identity {
            align-items:
                flex-start;
        }


        .assignment-show-avatar {
            width: 68px;
            height: 68px;

            border-radius:
                19px;

            font-size:
                20px;
        }


        .assignment-show-hero h1 {
            font-size:
                30px;
        }


        .assignment-show-summary {
            grid-template-columns:
                1fr;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Related Records
    |--------------------------------------------------------------------------
    */

    $profile =
        $assignment->studentProfile;


    $student =
        $profile?->user;


    $company =
        $assignment->company;


    $supervisor =
        $assignment->supervisor;


    $evaluation =
        $assignment->finalEvaluation;


    $completedBy =
        $assignment->completedBy;


    /*
    |--------------------------------------------------------------------------
    | Names
    |--------------------------------------------------------------------------
    */

    $studentName =
        $student?->name
        ?? 'Student unavailable';


    $companyName =
        $company?->name
        ?? 'Company unavailable';


    $supervisorName =
        $supervisor?->name
        ?? 'Supervisor unavailable';


    /*
    |--------------------------------------------------------------------------
    | Student Initials
    |--------------------------------------------------------------------------
    */

    $studentInitials =
        collect(
            preg_split(
                '/\s+/',
                trim(
                    (string)
                    $studentName
                )
            )
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
            ->implode('')
            ?: 'ST';


    /*
    |--------------------------------------------------------------------------
    | Assignment Status
    |--------------------------------------------------------------------------
    */

    $assignmentStatus =
        strtolower(
            trim(
                (string)
                $assignment->status
            )
        );


    $assignmentStatusClass =
        match ($assignmentStatus) {

            'pending' =>
                'status-pending',

            'active' =>
                'status-active',

            'completed' =>
                'status-completed',

            'cancelled' =>
                'status-cancelled',

            default =>
                'status-other',

        };


    /*
    |--------------------------------------------------------------------------
    | Date Formatting
    |--------------------------------------------------------------------------
    */

    $formatDate =
        function ($date) {

            if (! $date) {
                return 'Not available';
            }


            try {

                return
                    \Illuminate\Support\Carbon::parse(
                        $date
                    )
                        ->format(
                            'M d, Y'
                        );

            } catch (\Throwable $exception) {

                return (string) $date;

            }

        };


    $formatDateTime =
        function ($date) {

            if (! $date) {
                return 'Not available';
            }


            try {

                return
                    \Illuminate\Support\Carbon::parse(
                        $date
                    )
                        ->timezone(
                            'Asia/Manila'
                        )
                        ->format(
                            'M d, Y · h:i A'
                        );

            } catch (\Throwable $exception) {

                return (string) $date;

            }

        };


    /*
    |--------------------------------------------------------------------------
    | Placement Duration
    |--------------------------------------------------------------------------
    */

    $placementDuration =
        'Not available';


    if (
        $assignment->start_date
        &&
        $assignment->end_date
    ) {

        try {

            $start =
                \Illuminate\Support\Carbon::parse(
                    $assignment->start_date
                );


            $end =
                \Illuminate\Support\Carbon::parse(
                    $assignment->end_date
                );


            $days =
                $start->diffInDays(
                    $end
                ) + 1;


            $placementDuration =
                number_format(
                    $days
                )
                .
                ' day'
                .
                (
                    $days === 1
                        ? ''
                        : 's'
                );

        } catch (\Throwable $exception) {

            $placementDuration =
                'Not available';

        }

    }

@endphp


<div class="assignment-show-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="assignment-show-hero">


        <div class="assignment-show-hero-inner">


            <div class="assignment-show-identity">


                <div class="assignment-show-avatar">
                    {{ $studentInitials }}
                </div>


                <div>


                    <div class="assignment-show-eyebrow">

                        <span class="assignment-show-dot"></span>

                        Administrator · OJT Placement Record

                    </div>


                    <h1>
                        {{ $studentName }}
                    </h1>


                    <p class="assignment-show-hero-subtitle">

                        {{ $companyName }}

                        ·

                        Assignment #{{ $assignment->id }}

                    </p>


                </div>


            </div>


            <div class="assignment-show-hero-actions">


                @if (
                    Route::has(
                        'admin.assignments.edit'
                    )
                )

                    <a
                        href="{{ route(
                            'admin.assignments.edit',
                            $assignment
                        ) }}"
                        class="
                            assignment-show-hero-button
                            assignment-show-hero-primary
                        "
                    >
                        Edit Assignment
                    </a>

                @endif


                <a
                    href="{{ route(
                        'admin.assignments.index'
                    ) }}"
                    class="
                        assignment-show-hero-button
                        assignment-show-hero-secondary
                    "
                >
                    Back to Assignments
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="assignment-show-summary">


        <article class="assignment-show-summary-card">


            <span class="assignment-show-summary-label">
                Assignment Status
            </span>


            <span
                class="
                    assignment-show-status
                    {{ $assignmentStatusClass }}
                "
            >

                {{ ucwords(
                    str_replace(
                        '_',
                        ' ',
                        (string)
                        $assignment->status
                    )
                ) }}

            </span>


            <span class="assignment-show-summary-note">
                Current OJT placement lifecycle state
            </span>


        </article>


        <article class="assignment-show-summary-card">


            <span class="assignment-show-summary-label">
                Required OJT Hours
            </span>


            <span class="assignment-show-summary-value">

                {{ number_format(
                    (float)
                    (
                        $assignment->required_hours
                        ?? 0
                    ),
                    0
                ) }}

                hours

            </span>


            <span class="assignment-show-summary-note">
                Required training duration
            </span>


        </article>


        <article class="assignment-show-summary-card">


            <span class="assignment-show-summary-label">
                Start Date
            </span>


            <span class="assignment-show-summary-value">

                {{ $formatDate(
                    $assignment->start_date
                ) }}

            </span>


            <span class="assignment-show-summary-note">
                Official placement beginning
            </span>


        </article>


        <article class="assignment-show-summary-card">


            <span class="assignment-show-summary-label">
                End Date
            </span>


            <span class="assignment-show-summary-value">

                {{ $formatDate(
                    $assignment->end_date
                ) }}

            </span>


            <span class="assignment-show-summary-note">
                Official placement end
            </span>


        </article>


    </section>


    {{-- ==================================================================
         MAIN LAYOUT
         ================================================================== --}}

    <div class="assignment-show-layout">


        {{-- ==================================================================
             MAIN
             ================================================================== --}}

        <main class="assignment-show-main">


            {{-- ==============================================================
                 PLACEMENT PARTIES
                 ============================================================== --}}

            <section class="assignment-show-panel">


                <div class="assignment-show-panel-header">


                    <div
                        class="
                            assignment-show-panel-icon
                            panel-blue
                        "
                    >
                        PL
                    </div>


                    <div>

                        <h2>
                            OJT Placement Parties
                        </h2>

                        <p>
                            Student, partner Company, and assigned Supervisor
                        </p>

                    </div>


                </div>


                <div class="assignment-show-panel-body">


                    <div class="placement-parties-grid">


                        {{-- ==================================================
                             STUDENT
                             ================================================== --}}

                        <div class="placement-party">


                            <div
                                class="
                                    placement-party-icon
                                    party-student
                                "
                            >
                                ST
                            </div>


                            <span class="placement-party-label">
                                Student
                            </span>


                            <span class="placement-party-name">
                                {{ $studentName }}
                            </span>


                            <span class="placement-party-meta">

                                Student No.

                                {{ $profile?->student_number
                                    ?? 'Not provided'
                                }}

                                @if (
                                    filled(
                                        $profile?->program
                                    )
                                )

                                    · {{ $profile->program }}

                                @endif

                            </span>


                            @if (
                                $student
                                &&
                                Route::has(
                                    'admin.students.show'
                                )
                            )

                                <a
                                    href="{{ route(
                                        'admin.students.show',
                                        $student
                                    ) }}"
                                    class="placement-party-link"
                                >
                                    View Student Record →
                                </a>

                            @endif


                        </div>


                        {{-- ==================================================
                             COMPANY
                             ================================================== --}}

                        <div class="placement-party">


                            <div
                                class="
                                    placement-party-icon
                                    party-company
                                "
                            >
                                CO
                            </div>


                            <span class="placement-party-label">
                                Partner Company
                            </span>


                            <span class="placement-party-name">
                                {{ $companyName }}
                            </span>


                            <span class="placement-party-meta">

                                {{ filled(
                                    $company?->address
                                )
                                    ? $company->address
                                    : 'No company address provided'
                                }}

                            </span>


                            @if (
                                $company
                                &&
                                Route::has(
                                    'admin.companies.show'
                                )
                            )

                                <a
                                    href="{{ route(
                                        'admin.companies.show',
                                        $company
                                    ) }}"
                                    class="placement-party-link"
                                >
                                    View Company Record →
                                </a>

                            @endif


                        </div>


                        {{-- ==================================================
                             SUPERVISOR
                             ================================================== --}}

                        <div class="placement-party">


                            <div
                                class="
                                    placement-party-icon
                                    party-supervisor
                                "
                            >
                                SV
                            </div>


                            <span class="placement-party-label">
                                Assigned Supervisor
                            </span>


                            <span class="placement-party-name">
                                {{ $supervisorName }}
                            </span>


                            <span class="placement-party-meta">

                                {{ $supervisor?->email
                                    ?? 'Supervisor email unavailable'
                                }}

                            </span>


                            @if (
                                $supervisor
                                &&
                                Route::has(
                                    'admin.supervisors.show'
                                )
                            )

                                <a
                                    href="{{ route(
                                        'admin.supervisors.show',
                                        $supervisor
                                    ) }}"
                                    class="placement-party-link"
                                >
                                    View Supervisor Record →
                                </a>

                            @endif


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==============================================================
                 PLACEMENT DETAILS
                 ============================================================== --}}

            <section class="assignment-show-panel">


                <div class="assignment-show-panel-header">


                    <div
                        class="
                            assignment-show-panel-icon
                            panel-purple
                        "
                    >
                        DT
                    </div>


                    <div>

                        <h2>
                            Placement Details
                        </h2>

                        <p>
                            Required hours, schedule, status, and record information
                        </p>

                    </div>


                </div>


                <div class="assignment-show-panel-body">


                    <div class="placement-details-grid">


                        <div class="placement-detail">

                            <span class="placement-detail-label">
                                Required Hours
                            </span>

                            <span class="placement-detail-value">

                                {{ number_format(
                                    (float)
                                    (
                                        $assignment->required_hours
                                        ?? 0
                                    ),
                                    0
                                ) }}

                                hours

                            </span>

                            <span class="placement-detail-helper">
                                Training requirement
                            </span>

                        </div>


                        <div class="placement-detail">

                            <span class="placement-detail-label">
                                Placement Duration
                            </span>

                            <span class="placement-detail-value">
                                {{ $placementDuration }}
                            </span>

                            <span class="placement-detail-helper">
                                Calendar duration
                            </span>

                        </div>


                        <div class="placement-detail">

                            <span class="placement-detail-label">
                                Assignment Status
                            </span>

                            <span class="placement-detail-value">

                                {{ ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        (string)
                                        $assignment->status
                                    )
                                ) }}

                            </span>

                            <span class="placement-detail-helper">
                                Current workflow state
                            </span>

                        </div>


                        <div class="placement-detail">

                            <span class="placement-detail-label">
                                Assignment ID
                            </span>

                            <span class="placement-detail-value">
                                #{{ $assignment->id }}
                            </span>

                            <span class="placement-detail-helper">
                                OJT Sync record identifier
                            </span>

                        </div>


                    </div>


                    @if (
                        filled(
                            $assignment->notes
                        )
                    )

                        <div
                            class="assignment-notes-box"
                            style="margin-top: 15px;"
                        >

                            <strong>
                                Placement Notes
                            </strong>

                            {{ $assignment->notes }}

                        </div>

                    @endif


                </div>


            </section>


            {{-- ==============================================================
                 TIMELINE
                 ============================================================== --}}

            <section class="assignment-show-panel">


                <div class="assignment-show-panel-header">


                    <div
                        class="
                            assignment-show-panel-icon
                            panel-orange
                        "
                    >
                        TL
                    </div>


                    <div>

                        <h2>
                            Assignment Timeline
                        </h2>

                        <p>
                            Important dates in this OJT placement
                        </p>

                    </div>


                </div>


                <div class="assignment-show-panel-body">


                    <div class="assignment-timeline">


                        <div class="assignment-timeline-item">


                            <span class="assignment-timeline-label">
                                Assignment Created
                            </span>


                            <span class="assignment-timeline-value">

                                {{ $formatDateTime(
                                    $assignment->created_at
                                ) }}

                            </span>


                            <span class="assignment-timeline-note">
                                OJT placement record entered into the system
                            </span>


                        </div>


                        <div class="assignment-timeline-item">


                            <span class="assignment-timeline-label">
                                Placement Start
                            </span>


                            <span class="assignment-timeline-value">

                                {{ $formatDate(
                                    $assignment->start_date
                                ) }}

                            </span>


                            <span class="assignment-timeline-note">
                                Official beginning of OJT placement
                            </span>


                        </div>


                        <div class="assignment-timeline-item">


                            <span class="assignment-timeline-label">
                                Placement End
                            </span>


                            <span class="assignment-timeline-value">

                                {{ $formatDate(
                                    $assignment->end_date
                                ) }}

                            </span>


                            <span class="assignment-timeline-note">
                                Scheduled end of OJT placement
                            </span>


                        </div>


                        @if (
                            $assignment->completed_at
                        )

                            <div class="assignment-timeline-item">


                                <span class="assignment-timeline-label">
                                    Assignment Completed
                                </span>


                                <span class="assignment-timeline-value">

                                    {{ $formatDateTime(
                                        $assignment->completed_at
                                    ) }}

                                </span>


                                <span class="assignment-timeline-note">
                                    Completion formally recorded in OJT Sync
                                </span>


                            </div>

                        @endif


                    </div>


                </div>


            </section>


            {{-- ==============================================================
                 FINAL EVALUATION
                 ============================================================== --}}

            <section class="assignment-show-panel">


                <div class="assignment-show-panel-header">


                    <div
                        class="
                            assignment-show-panel-icon
                            panel-teal
                        "
                    >
                        EV
                    </div>


                    <div>

                        <h2>
                            Final Supervisor Evaluation
                        </h2>

                        <p>
                            Student performance and completion recommendation
                        </p>

                    </div>


                </div>


                <div class="assignment-show-panel-body">


                    @if ($evaluation)


                        <div class="evaluation-overview">


                            <div class="evaluation-score">


                                <span class="evaluation-score-number">

                                    {{ number_format(
                                        $evaluation->overallRating(),
                                        2
                                    ) }}

                                </span>


                                <span class="evaluation-score-total">
                                    out of 5.00
                                </span>


                                <span class="evaluation-score-label">
                                    {{ $evaluation->ratingLabel() }}
                                </span>


                            </div>


                            <div>


                                <div class="evaluation-details">


                                    <div class="evaluation-detail">

                                        <span>
                                            Attendance Reliability
                                        </span>

                                        <strong>
                                            {{ $evaluation->attendance_reliability }}/5
                                        </strong>

                                    </div>


                                    <div class="evaluation-detail">

                                        <span>
                                            Work Quality
                                        </span>

                                        <strong>
                                            {{ $evaluation->work_quality }}/5
                                        </strong>

                                    </div>


                                    <div class="evaluation-detail">

                                        <span>
                                            Initiative
                                        </span>

                                        <strong>
                                            {{ $evaluation->initiative }}/5
                                        </strong>

                                    </div>


                                    <div class="evaluation-detail">

                                        <span>
                                            Communication
                                        </span>

                                        <strong>
                                            {{ $evaluation->communication }}/5
                                        </strong>

                                    </div>


                                    <div class="evaluation-detail">

                                        <span>
                                            Professionalism
                                        </span>

                                        <strong>
                                            {{ $evaluation->professionalism }}/5
                                        </strong>

                                    </div>


                                    <div class="evaluation-detail">

                                        <span>
                                            Technical Competence
                                        </span>

                                        <strong>
                                            {{ $evaluation->technical_competence }}/5
                                        </strong>

                                    </div>


                                </div>


                                <div class="evaluation-recommendation">

                                    <span>
                                        Recommendation
                                    </span>

                                    <strong>
                                        {{ $evaluation->recommendationLabel() }}
                                    </strong>

                                </div>


                            </div>


                        </div>


                        @if (
                            filled(
                                $evaluation->strengths
                            )
                            ||
                            filled(
                                $evaluation->areas_for_improvement
                            )
                            ||
                            filled(
                                $evaluation->final_comments
                            )
                        )

                            <div class="evaluation-comments">


                                @if (
                                    filled(
                                        $evaluation->strengths
                                    )
                                )

                                    <div class="evaluation-comment">

                                        <strong>
                                            Strengths
                                        </strong>

                                        <p>
                                            {{ $evaluation->strengths }}
                                        </p>

                                    </div>

                                @endif


                                @if (
                                    filled(
                                        $evaluation->areas_for_improvement
                                    )
                                )

                                    <div class="evaluation-comment">

                                        <strong>
                                            Areas for Improvement
                                        </strong>

                                        <p>
                                            {{ $evaluation->areas_for_improvement }}
                                        </p>

                                    </div>

                                @endif


                                @if (
                                    filled(
                                        $evaluation->final_comments
                                    )
                                )

                                    <div class="evaluation-comment">

                                        <strong>
                                            Final Comments
                                        </strong>

                                        <p>
                                            {{ $evaluation->final_comments }}
                                        </p>

                                    </div>

                                @endif


                            </div>

                        @endif


                    @else


                        <div class="evaluation-empty">

                            <strong>
                                No Final Evaluation Yet
                            </strong>

                            <span>

                                The assigned Supervisor has not yet
                                submitted the final OJT evaluation
                                for this placement.

                            </span>

                        </div>


                    @endif


                </div>


            </section>


        </main>


        {{-- ==================================================================
             SIDEBAR
             ================================================================== --}}

        <aside class="assignment-show-sidebar">


            {{-- ==============================================================
                 RECORD SUMMARY
                 ============================================================== --}}

            <section class="assignment-show-panel">


                <div class="assignment-show-panel-header">


                    <div
                        class="
                            assignment-show-panel-icon
                            panel-blue
                        "
                    >
                        RC
                    </div>


                    <div>

                        <h2>
                            Record Summary
                        </h2>

                        <p>
                            Assignment information
                        </p>

                    </div>


                </div>


                <div class="assignment-show-panel-body">


                    <div class="assignment-sidebar-list">


                        <div class="assignment-sidebar-item">

                            <span class="assignment-sidebar-label">
                                Assignment ID
                            </span>

                            <span class="assignment-sidebar-value">
                                #{{ $assignment->id }}
                            </span>

                        </div>


                        <div class="assignment-sidebar-item">

                            <span class="assignment-sidebar-label">
                                Student
                            </span>

                            <span class="assignment-sidebar-value">
                                {{ $studentName }}
                            </span>

                        </div>


                        <div class="assignment-sidebar-item">

                            <span class="assignment-sidebar-label">
                                Company
                            </span>

                            <span class="assignment-sidebar-value">
                                {{ $companyName }}
                            </span>

                        </div>


                        <div class="assignment-sidebar-item">

                            <span class="assignment-sidebar-label">
                                Supervisor
                            </span>

                            <span class="assignment-sidebar-value">
                                {{ $supervisorName }}
                            </span>

                        </div>


                        <div class="assignment-sidebar-item">

                            <span class="assignment-sidebar-label">
                                Status
                            </span>

                            <span class="assignment-sidebar-value">

                                {{ ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        (string)
                                        $assignment->status
                                    )
                                ) }}

                            </span>

                        </div>


                        <div class="assignment-sidebar-item">

                            <span class="assignment-sidebar-label">
                                Last Updated
                            </span>

                            <span class="assignment-sidebar-value">

                                {{ $formatDateTime(
                                    $assignment->updated_at
                                ) }}

                            </span>

                        </div>


                    </div>


                </div>


            </section>


            {{-- ==============================================================
                 WORKFLOW
                 ============================================================== --}}

            <section class="assignment-show-panel">


                <div class="assignment-show-panel-body">


                    <div class="assignment-workflow-card">


                        <strong>
                            OJT Monitoring Workflow
                        </strong>


                        <p>

                            This placement provides the shared context
                            used by the Student's attendance records,
                            Daily Work Logs, Supervisor validation,
                            final evaluation, and completion history.

                        </p>


                    </div>


                </div>


            </section>


            {{-- ==============================================================
                 COMPLETION
                 ============================================================== --}}

            @if (
                $assignmentStatus === 'completed'
                ||
                $assignment->completed_at
            )


                <section class="assignment-show-panel">


                    <div class="assignment-show-panel-header">


                        <div
                            class="
                                assignment-show-panel-icon
                                panel-green
                            "
                        >
                            CP
                        </div>


                        <div>

                            <h2>
                                Completion Record
                            </h2>

                            <p>
                                Formal placement completion
                            </p>

                        </div>


                    </div>


                    <div class="assignment-show-panel-body">


                        <div class="completion-record">


                            <span class="completion-record-title">
                                Assignment Completed
                            </span>


                            <div class="completion-record-list">


                                <div class="completion-record-item">

                                    <span>
                                        Completed On
                                    </span>

                                    <strong>

                                        {{ $formatDateTime(
                                            $assignment->completed_at
                                        ) }}

                                    </strong>

                                </div>


                                <div class="completion-record-item">

                                    <span>
                                        Completed By
                                    </span>

                                    <strong>

                                        {{ $completedBy?->name
                                            ?? 'Not available'
                                        }}

                                    </strong>

                                </div>


                                @if (
                                    filled(
                                        $assignment->completion_remarks
                                    )
                                )

                                    <div class="completion-record-item">

                                        <span>
                                            Completion Remarks
                                        </span>

                                        <strong>
                                            {{ $assignment->completion_remarks }}
                                        </strong>

                                    </div>

                                @endif


                            </div>


                        </div>


                    </div>


                </section>


            @endif


            {{-- ==============================================================
                 QUICK ACTIONS
                 ============================================================== --}}

            <section class="assignment-show-panel">


                <div class="assignment-show-panel-header">


                    <div
                        class="
                            assignment-show-panel-icon
                            panel-purple
                        "
                    >
                        QA
                    </div>


                    <div>

                        <h2>
                            Quick Actions
                        </h2>

                        <p>
                            Placement administration
                        </p>

                    </div>


                </div>


                <div class="assignment-show-panel-body">


                    <div class="assignment-quick-actions">


                        @if (
                            Route::has(
                                'admin.assignments.edit'
                            )
                        )

                            <a
                                href="{{ route(
                                    'admin.assignments.edit',
                                    $assignment
                                ) }}"
                                class="
                                    assignment-quick-action
                                    assignment-quick-action-primary
                                "
                            >
                                Edit Assignment
                            </a>

                        @endif


                        @if (
                            $student
                            &&
                            Route::has(
                                'admin.students.show'
                            )
                        )

                            <a
                                href="{{ route(
                                    'admin.students.show',
                                    $student
                                ) }}"
                                class="assignment-quick-action"
                            >
                                View Student Record
                            </a>

                        @endif


                        @if (
                            $company
                            &&
                            Route::has(
                                'admin.companies.show'
                            )
                        )

                            <a
                                href="{{ route(
                                    'admin.companies.show',
                                    $company
                                ) }}"
                                class="assignment-quick-action"
                            >
                                View Company Record
                            </a>

                        @endif


                        @if (
                            $supervisor
                            &&
                            Route::has(
                                'admin.supervisors.show'
                            )
                        )

                            <a
                                href="{{ route(
                                    'admin.supervisors.show',
                                    $supervisor
                                ) }}"
                                class="assignment-quick-action"
                            >
                                View Supervisor Record
                            </a>

                        @endif


                        <a
                            href="{{ route(
                                'admin.reports.index'
                            ) }}"
                            class="assignment-quick-action"
                        >
                            Open OJT Reports
                        </a>


                        <a
                            href="{{ route(
                                'admin.assignments.index'
                            ) }}"
                            class="assignment-quick-action"
                        >
                            Back to Assignment Management
                        </a>


                    </div>


                </div>


            </section>


        </aside>


    </div>


</div>


@endsection