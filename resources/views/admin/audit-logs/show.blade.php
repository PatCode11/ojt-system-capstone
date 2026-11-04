@extends('layouts.app')


@section('title', 'Audit Event Details | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       AUDIT EVENT DETAIL DESIGN SYSTEM
       ================================================================ */

    :root {
        --audit-show-primary: #183B6B;
        --audit-show-primary-dark: #102A4A;

        --audit-show-blue: #2563EB;
        --audit-show-blue-soft: #EAF2FF;

        --audit-show-green: #15803D;
        --audit-show-green-soft: #EAF8EF;

        --audit-show-orange: #B45309;
        --audit-show-orange-soft: #FFF5E6;

        --audit-show-red: #B42318;
        --audit-show-red-soft: #FFF0EE;

        --audit-show-purple: #6D4FC2;
        --audit-show-purple-soft: #F2EEFF;

        --audit-show-teal: #0F766E;
        --audit-show-teal-soft: #E7F7F5;

        --audit-show-slate: #475569;
        --audit-show-slate-soft: #F1F5F9;

        --audit-show-text: #102A4A;
        --audit-show-body: #4F667F;
        --audit-show-muted: #718399;

        --audit-show-surface: #FFFFFF;
        --audit-show-soft: #F8FBFE;

        --audit-show-border: #DCE5EE;
        --audit-show-border-soft: #E9EFF5;

        --audit-show-shadow:
            0 10px 30px
            rgba(15, 42, 74, 0.07);

        --audit-show-shadow-hover:
            0 18px 42px
            rgba(15, 42, 74, 0.11);

        --audit-show-transition:
            all 0.24s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .audit-show-page {
        width: 100%;
    }


    /* ================================================================
       HERO
       ================================================================ */

    .audit-show-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 28px;

        padding:
            38px
            40px;

        border-radius: 25px;

        background:
            radial-gradient(
                circle at 89% 18%,
                rgba(248, 113, 113, 0.16),
                transparent 23%
            ),
            radial-gradient(
                circle at 72% 82%,
                rgba(96, 165, 250, 0.11),
                transparent 26%
            ),
            linear-gradient(
                135deg,
                #0B2039 0%,
                #102A4A 44%,
                #183B6B 100%
            );

        color: #FFFFFF;

        box-shadow:
            0 21px 50px
            rgba(16, 42, 74, 0.20);
    }


    .audit-show-hero::before {
        content: "";

        position: absolute;

        width: 310px;
        height: 310px;

        right: -120px;
        top: -160px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.06);
    }


    .audit-show-hero::after {
        content: "";

        position: absolute;

        width: 175px;
        height: 175px;

        right: 220px;
        bottom: -120px;

        border-radius: 50%;

        background:
            rgba(248, 113, 113, 0.06);
    }


    .audit-show-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 30px;
    }


    .audit-show-hero-copy {
        min-width: 0;
        max-width: 800px;
    }


    .audit-show-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 13px;

        color:
            rgba(255, 255, 255, 0.76);

        font-size: 13px;
        font-weight: 750;
    }


    .audit-show-eyebrow-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background: #F87171;

        box-shadow:
            0 0 0 5px
            rgba(248, 113, 113, 0.12);
    }


    .audit-show-hero h1 {
        margin:
            0
            0
            9px;

        color: #FFFFFF;

        font-size: 34px;
        font-weight: 850;

        line-height: 1.18;

        letter-spacing: -0.5px;
    }


    .audit-show-subtitle {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.75);

        font-size: 15px;

        line-height: 1.65;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .audit-show-hero-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 10px;
    }


    .audit-show-back-button {
        min-height: 48px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        padding:
            0
            17px;

        border:
            1px solid
            rgba(255, 255, 255, 0.17);

        border-radius: 13px;

        background:
            rgba(255, 255, 255, 0.10);

        color: #FFFFFF;

        text-decoration: none;

        font-size: 13px;
        font-weight: 850;

        transition:
            var(--audit-show-transition);
    }


    .audit-show-back-button:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.17);
    }


    /* ================================================================
       SUMMARY
       ================================================================ */

    .audit-show-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 18px;

        margin-bottom: 28px;
    }


    .audit-show-summary-card {
        padding: 22px;

        border:
            1px solid
            var(--audit-show-border);

        border-radius: 18px;

        background:
            var(--audit-show-surface);

        box-shadow:
            var(--audit-show-shadow);

        transition:
            var(--audit-show-transition);
    }


    .audit-show-summary-card:hover {
        transform:
            translateY(-3px);

        box-shadow:
            var(--audit-show-shadow-hover);
    }


    .audit-show-summary-icon {
        width: 47px;
        height: 47px;

        margin-bottom: 14px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        font-size: 12px;
        font-weight: 900;
    }


    .summary-security {
        background:
            var(--audit-show-red-soft);

        color:
            var(--audit-show-red);
    }


    .summary-blue {
        background:
            var(--audit-show-blue-soft);

        color:
            var(--audit-show-blue);
    }


    .summary-purple {
        background:
            var(--audit-show-purple-soft);

        color:
            var(--audit-show-purple);
    }


    .summary-teal {
        background:
            var(--audit-show-teal-soft);

        color:
            var(--audit-show-teal);
    }


    .audit-show-summary-label {
        margin-bottom: 6px;

        color:
            var(--audit-show-body);

        font-size: 14px;
        font-weight: 700;
    }


    .audit-show-summary-value {
        color:
            var(--audit-show-text);

        font-size: 18px;
        font-weight: 900;

        line-height: 1.4;

        word-break: break-word;
    }


    .audit-show-summary-note {
        margin-top: 7px;

        color:
            var(--audit-show-muted);

        font-size: 11px;

        line-height: 1.55;
    }


    /* ================================================================
       SECURITY BANNER
       ================================================================ */

    .audit-show-security-banner {
        display: flex;
        align-items: flex-start;

        gap: 14px;

        margin-bottom: 24px;

        padding:
            18px
            20px;

        border:
            1px solid
            #F0CECA;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #FFF8F7 0%,
                #FFF2F1 100%
            );

        box-shadow:
            var(--audit-show-shadow);
    }


    .security-banner-normal {
        border-color:
            #D8E6F3;

        background:
            linear-gradient(
                135deg,
                #F8FBFF 0%,
                #F3F8FD 100%
            );
    }


    .audit-security-banner-icon {
        width: 42px;
        height: 42px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        background:
            var(--audit-show-red-soft);

        color:
            var(--audit-show-red);

        font-size: 14px;
        font-weight: 900;
    }


    .security-banner-normal
    .audit-security-banner-icon {
        background:
            var(--audit-show-blue-soft);

        color:
            var(--audit-show-blue);
    }


    .audit-security-banner-copy strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--audit-show-text);

        font-size: 14px;
        font-weight: 850;
    }


    .audit-security-banner-copy span {
        color:
            var(--audit-show-body);

        font-size: 13px;

        line-height: 1.65;
    }


    /* ================================================================
       LAYOUT
       ================================================================ */

    .audit-show-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1.35fr)
            minmax(320px, 0.65fr);

        gap: 22px;

        align-items: start;
    }


    .audit-show-main,
    .audit-show-sidebar {
        display: grid;

        gap: 20px;
    }


    .audit-show-sidebar {
        position: sticky;

        top: 170px;
    }


    /* ================================================================
       PANEL
       ================================================================ */

    .audit-panel {
        overflow: hidden;

        border:
            1px solid
            var(--audit-show-border);

        border-radius: 19px;

        background:
            var(--audit-show-surface);

        box-shadow:
            var(--audit-show-shadow);
    }


    .audit-panel-header {
        display: flex;
        align-items: center;

        gap: 13px;

        padding:
            22px
            24px;

        border-bottom:
            1px solid
            var(--audit-show-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .audit-panel-icon {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        font-size: 12px;
        font-weight: 900;
    }


    .panel-blue {
        background:
            var(--audit-show-blue-soft);

        color:
            var(--audit-show-blue);
    }


    .panel-purple {
        background:
            var(--audit-show-purple-soft);

        color:
            var(--audit-show-purple);
    }


    .panel-green {
        background:
            var(--audit-show-green-soft);

        color:
            var(--audit-show-green);
    }


    .panel-orange {
        background:
            var(--audit-show-orange-soft);

        color:
            var(--audit-show-orange);
    }


    .panel-red {
        background:
            var(--audit-show-red-soft);

        color:
            var(--audit-show-red);
    }


    .panel-teal {
        background:
            var(--audit-show-teal-soft);

        color:
            var(--audit-show-teal);
    }


    .audit-panel-header h2 {
        margin:
            0
            0
            3px;

        color:
            var(--audit-show-text);

        font-size: 20px;
        font-weight: 850;
    }


    .audit-panel-header p {
        margin: 0;

        color:
            var(--audit-show-muted);

        font-size: 12px;

        line-height: 1.5;
    }


    .audit-panel-body {
        padding:
            23px
            24px;
    }


    /* ================================================================
       OVERVIEW
       ================================================================ */

    .event-overview {
        display: grid;

        gap: 17px;
    }


    .event-primary-block {
        padding:
            18px;

        border:
            1px solid
            var(--audit-show-border-soft);

        border-radius: 14px;

        background:
            var(--audit-show-soft);
    }


    .event-primary-label {
        display: block;

        margin-bottom: 7px;

        color:
            var(--audit-show-muted);

        font-size: 10px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: 0.5px;
    }


    .event-primary-title {
        display: block;

        margin-bottom: 7px;

        color:
            var(--audit-show-text);

        font-size: 21px;
        font-weight: 900;

        line-height: 1.35;
    }


    .event-code {
        display: inline-block;

        padding:
            5px
            8px;

        border-radius: 8px;

        background:
            #E9EFF6;

        color:
            var(--audit-show-primary);

        font-family:
            Consolas,
            "Courier New",
            monospace;

        font-size: 11px;
        font-weight: 800;

        word-break: break-word;
    }


    .event-description {
        margin:
            15px
            0
            0;

        color:
            var(--audit-show-body);

        font-size: 14px;

        line-height: 1.75;
    }


    /* ================================================================
       DETAIL GRID
       ================================================================ */

    .audit-detail-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 13px;
    }


    .audit-detail-card {
        padding:
            15px
            16px;

        border:
            1px solid
            var(--audit-show-border-soft);

        border-radius: 13px;

        background:
            #FBFCFE;
    }


    .audit-detail-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--audit-show-muted);

        font-size: 10px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: 0.4px;
    }


    .audit-detail-value {
        display: block;

        color:
            var(--audit-show-text);

        font-size: 13px;
        font-weight: 800;

        line-height: 1.55;

        word-break: break-word;
    }


    .audit-detail-value-mono {
        font-family:
            Consolas,
            "Courier New",
            monospace;

        font-size: 12px;
    }


    /* ================================================================
       ACTOR
       ================================================================ */

    .audit-actor-profile {
        display: flex;
        align-items: center;

        gap: 15px;

        margin-bottom: 18px;

        padding:
            16px;

        border:
            1px solid
            var(--audit-show-border-soft);

        border-radius: 14px;

        background:
            var(--audit-show-soft);
    }


    .audit-actor-avatar {
        width: 56px;
        height: 56px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #EAF2FF 0%,
                #DCE9F8 100%
            );

        color:
            var(--audit-show-primary);

        font-size: 15px;
        font-weight: 900;
    }


    .audit-actor-name {
        display: block;

        margin-bottom: 3px;

        color:
            var(--audit-show-text);

        font-size: 16px;
        font-weight: 900;
    }


    .audit-actor-subtitle {
        display: block;

        color:
            var(--audit-show-muted);

        font-size: 12px;

        line-height: 1.5;
    }


    /* ================================================================
       RESOURCE
       ================================================================ */

    .resource-display {
        display: flex;
        align-items: center;

        gap: 14px;

        margin-bottom: 17px;

        padding:
            16px;

        border:
            1px solid
            var(--audit-show-border-soft);

        border-radius: 14px;

        background:
            var(--audit-show-soft);
    }


    .resource-icon {
        width: 51px;
        height: 51px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background:
            var(--audit-show-purple-soft);

        color:
            var(--audit-show-purple);

        font-size: 12px;
        font-weight: 900;
    }


    .resource-name {
        display: block;

        color:
            var(--audit-show-text);

        font-size: 16px;
        font-weight: 900;
    }


    .resource-id {
        display: block;

        margin-top: 3px;

        color:
            var(--audit-show-muted);

        font-size: 11px;
    }


    /* ================================================================
       CHANGE COMPARISON
       ================================================================ */

    .change-list {
        display: grid;

        gap: 13px;
    }


    .change-item {
        overflow: hidden;

        border:
            1px solid
            var(--audit-show-border);

        border-radius: 14px;
    }


    .change-field {
        padding:
            10px
            14px;

        border-bottom:
            1px solid
            var(--audit-show-border-soft);

        background:
            #F8FAFC;

        color:
            var(--audit-show-text);

        font-size: 12px;
        font-weight: 850;
    }


    .change-values {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }


    .change-value {
        min-width: 0;

        padding:
            14px;
    }


    .change-value
    + .change-value {
        border-left:
            1px solid
            var(--audit-show-border-soft);
    }


    .change-before {
        background:
            #FFF9F8;
    }


    .change-after {
        background:
            #F6FBF8;
    }


    .change-value-label {
        display: block;

        margin-bottom: 6px;

        font-size: 9px;
        font-weight: 900;

        text-transform: uppercase;

        letter-spacing: 0.45px;
    }


    .change-before
    .change-value-label {
        color:
            var(--audit-show-red);
    }


    .change-after
    .change-value-label {
        color:
            var(--audit-show-green);
    }


    .change-value-content {
        color:
            var(--audit-show-text);

        font-family:
            Consolas,
            "Courier New",
            monospace;

        font-size: 11px;

        line-height: 1.6;

        white-space: pre-wrap;

        word-break: break-word;
    }


    /* ================================================================
       NO CHANGE STATE
       ================================================================ */

    .no-change-state {
        padding:
            24px;

        border:
            1px dashed
            var(--audit-show-border);

        border-radius: 14px;

        background:
            var(--audit-show-soft);

        text-align: center;
    }


    .no-change-state strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--audit-show-text);

        font-size: 14px;
        font-weight: 850;
    }


    .no-change-state span {
        color:
            var(--audit-show-muted);

        font-size: 12px;

        line-height: 1.6;
    }


    /* ================================================================
       METADATA
       ================================================================ */

    .metadata-grid {
        display: grid;

        gap: 10px;
    }


    .metadata-item {
        display: grid;

        grid-template-columns:
            minmax(130px, 0.35fr)
            minmax(0, 0.65fr);

        gap: 15px;

        padding:
            12px
            14px;

        border:
            1px solid
            var(--audit-show-border-soft);

        border-radius: 11px;

        background:
            #FBFCFE;
    }


    .metadata-key {
        color:
            var(--audit-show-muted);

        font-family:
            Consolas,
            "Courier New",
            monospace;

        font-size: 10px;
        font-weight: 800;

        word-break: break-word;
    }


    .metadata-value {
        color:
            var(--audit-show-text);

        font-family:
            Consolas,
            "Courier New",
            monospace;

        font-size: 10px;

        line-height: 1.6;

        white-space: pre-wrap;

        word-break: break-word;
    }


    /* ================================================================
       SIDEBAR
       ================================================================ */

    .sidebar-info-list {
        display: grid;

        gap: 10px;
    }


    .sidebar-info-item {
        padding:
            12px
            13px;

        border:
            1px solid
            var(--audit-show-border-soft);

        border-radius: 11px;

        background:
            #FBFCFE;
    }


    .sidebar-info-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--audit-show-muted);

        font-size: 9px;
        font-weight: 850;

        text-transform: uppercase;

        letter-spacing: 0.4px;
    }


    .sidebar-info-value {
        display: block;

        color:
            var(--audit-show-text);

        font-size: 12px;
        font-weight: 800;

        line-height: 1.5;

        word-break: break-word;
    }


    .sidebar-info-mono {
        font-family:
            Consolas,
            "Courier New",
            monospace;
    }


    /* ================================================================
       CLASSIFICATION
       ================================================================ */

    .classification-badge {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding:
            7px
            10px;

        border-radius: 999px;

        font-size: 11px;
        font-weight: 850;
    }


    .classification-badge::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .classification-security {
        background:
            var(--audit-show-red-soft);

        color:
            var(--audit-show-red);
    }


    .classification-security::before {
        background: #EF4444;
    }


    .classification-auth {
        background:
            var(--audit-show-blue-soft);

        color:
            var(--audit-show-blue);
    }


    .classification-auth::before {
        background: #3B82F6;
    }


    .classification-normal {
        background:
            var(--audit-show-green-soft);

        color:
            var(--audit-show-green);
    }


    .classification-normal::before {
        background: #22C55E;
    }


    .classification-system {
        background:
            var(--audit-show-slate-soft);

        color:
            var(--audit-show-slate);
    }


    .classification-system::before {
        background: #64748B;
    }


    /* ================================================================
       INVESTIGATION LIST
       ================================================================ */

    .investigation-list {
        list-style: none;

        margin: 0;
        padding: 0;

        display: grid;

        gap: 11px;
    }


    .investigation-list li {
        display: flex;
        align-items: flex-start;

        gap: 9px;

        color:
            var(--audit-show-body);

        font-size: 12px;

        line-height: 1.6;
    }


    .investigation-list li::before {
        content: "✓";

        color:
            var(--audit-show-green);

        font-weight: 900;
    }


    /* ================================================================
       READ ONLY CARD
       ================================================================ */

    .read-only-box {
        padding:
            14px;

        border:
            1px solid
            #D8E5F3;

        border-radius: 12px;

        background:
            #F6FAFE;

        color:
            var(--audit-show-body);

        font-size: 12px;

        line-height: 1.65;
    }


    .read-only-box strong {
        color:
            var(--audit-show-text);
    }


    /* ================================================================
       FOOTNOTE
       ================================================================ */

    .audit-show-footnote {
        display: flex;
        align-items: flex-start;

        gap: 11px;

        margin-top: 20px;

        padding:
            16px
            18px;

        border:
            1px solid
            #DCE7F2;

        border-radius: 14px;

        background:
            #F8FBFE;

        color:
            var(--audit-show-body);

        font-size: 12px;

        line-height: 1.65;
    }


    .audit-show-footnote-icon {
        width: 30px;
        height: 30px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        background:
            var(--audit-show-blue-soft);

        color:
            var(--audit-show-blue);

        font-weight: 900;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1100px) {

        .audit-show-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .audit-show-layout {
            grid-template-columns: 1fr;
        }


        .audit-show-sidebar {
            position: static;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 820px) {

        .audit-show-hero {
            padding:
                30px
                25px;
        }


        .audit-show-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .audit-show-hero-actions {
            width: 100%;
        }


        .audit-show-back-button {
            width: 100%;
        }


        .audit-show-sidebar {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 650px) {

        .audit-show-hero h1 {
            font-size: 29px;
        }


        .audit-show-summary-grid,
        .audit-detail-grid,
        .change-values {
            grid-template-columns: 1fr;
        }


        .change-value
        + .change-value {
            border-left: none;

            border-top:
                1px solid
                var(--audit-show-border-soft);
        }


        .metadata-item {
            grid-template-columns: 1fr;

            gap: 6px;
        }


        .audit-panel-header,
        .audit-panel-body {
            padding-left: 19px;
            padding-right: 19px;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Audit Log
    |--------------------------------------------------------------------------
    |
    | Your controller should normally pass:
    |
    | $auditLog
    |
    */

    $log =
        $auditLog
        ?? $log
        ?? null;


    abort_if(
        ! $log,
        404
    );


    /*
    |--------------------------------------------------------------------------
    | Normalize Enum / Scalar Values
    |--------------------------------------------------------------------------
    */

    $normalizeValue =
        function ($value) {

            if ($value instanceof \BackedEnum) {
                return $value->value;
            }


            if ($value instanceof \UnitEnum) {
                return $value->name;
            }


            return $value;

        };


    /*
    |--------------------------------------------------------------------------
    | Safe Value Reader
    |--------------------------------------------------------------------------
    */

    $auditValue =
        function (
            array $keys
        ) use (
            $log,
            $normalizeValue
        ) {

            foreach ($keys as $key) {

                try {

                    $value =
                        data_get(
                            $log,
                            $key
                        );


                    $value =
                        $normalizeValue(
                            $value
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
    | Event
    |--------------------------------------------------------------------------
    */

    $event =
        (string) (
            $auditValue([
                'event',
                'action',
                'event_type',
                'type',
            ])
            ?? 'system.event'
        );


    $eventLower =
        strtolower(
            $event
        );


    $eventLabel =
        \Illuminate\Support\Str::headline(
            str_replace(
                [
                    '.',
                    '_',
                    '-',
                ],
                ' ',
                $event
            )
        );


    /*
    |--------------------------------------------------------------------------
    | Description
    |--------------------------------------------------------------------------
    */

    $description =
        (string) (
            $auditValue([
                'description',
                'message',
                'summary',
            ])
            ?? $eventLabel
        );


    /*
    |--------------------------------------------------------------------------
    | Actor
    |--------------------------------------------------------------------------
    */

    $actorName =
        (string) (
            $auditValue([
                'actor.name',
                'user.name',
                'performedBy.name',
                'actor_name',
                'user_name',
            ])
            ?? 'System'
        );


    $actorEmail =
        (string) (
            $auditValue([
                'actor.email',
                'user.email',
                'performedBy.email',
                'actor_email',
                'user_email',
            ])
            ?? ''
        );


    $actorRole =
        (string) (
            $auditValue([
                'actor.role',
                'user.role',
                'performedBy.role',
                'actor_role',
                'user_role',
            ])
            ?? 'system'
        );


    $actorId =
        $auditValue([
            'actor_id',
            'user_id',
            'performed_by',
        ]);


    $actorParts =
        preg_split(
            '/\s+/',
            trim($actorName)
        );


    $actorInitials =
        collect($actorParts)
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
    | Resource
    |--------------------------------------------------------------------------
    */

    $resourceTypeRaw =
        $auditValue([
            'auditable_type',
            'subject_type',
            'resource_type',
            'model_type',
        ]);


    $resourceType =
        $resourceTypeRaw
            ? \Illuminate\Support\Str::headline(
                class_basename(
                    (string) $resourceTypeRaw
                )
            )
            : 'System';


    $resourceId =
        $auditValue([
            'auditable_id',
            'subject_id',
            'resource_id',
            'model_id',
        ]);


    /*
    |--------------------------------------------------------------------------
    | Request Context
    |--------------------------------------------------------------------------
    */

    $ipAddress =
        (string) (
            $auditValue([
                'ip_address',
                'ip',
                'request_ip',
            ])
            ?? 'Not recorded'
        );


    $userAgent =
        (string) (
            $auditValue([
                'user_agent',
                'browser',
                'request_user_agent',
            ])
            ?? ''
        );


    $requestMethod =
        (string) (
            $auditValue([
                'http_method',
                'request_method',
                'method',
            ])
            ?? 'Not recorded'
        );


    $requestPath =
        (string) (
            $auditValue([
                'request_path',
                'path',
                'url',
                'route',
            ])
            ?? 'Not recorded'
        );


    /*
    |--------------------------------------------------------------------------
    | Device Summary
    |--------------------------------------------------------------------------
    */

    $agent =
        strtolower(
            $userAgent
        );


    $device =
        match (true) {

            $agent === '' =>
                'Device unavailable',

            str_contains(
                $agent,
                'android'
            ) =>
                'Android',

            str_contains(
                $agent,
                'iphone'
            )
            ||
            str_contains(
                $agent,
                'ipad'
            ) =>
                'iOS',

            str_contains(
                $agent,
                'windows'
            ) =>
                'Windows',

            str_contains(
                $agent,
                'macintosh'
            )
            ||
            str_contains(
                $agent,
                'mac os'
            ) =>
                'macOS',

            str_contains(
                $agent,
                'linux'
            ) =>
                'Linux',

            default =>
                'Unknown device',

        };


    $browser =
        match (true) {

            str_contains(
                $agent,
                'edg/'
            ) =>
                'Microsoft Edge',

            str_contains(
                $agent,
                'chrome/'
            ) =>
                'Google Chrome',

            str_contains(
                $agent,
                'firefox/'
            ) =>
                'Mozilla Firefox',

            str_contains(
                $agent,
                'safari/'
            ) =>
                'Safari',

            default =>
                null,

        };


    $deviceSummary =
        $browser
            ? $device . ' · ' . $browser
            : $device;


    /*
    |--------------------------------------------------------------------------
    | Timestamp
    |--------------------------------------------------------------------------
    */

    try {

        $timestamp =
            $log->created_at
                ? \Illuminate\Support\Carbon::parse(
                    $log->created_at
                )->timezone(
                    'Asia/Manila'
                )
                : null;

    } catch (\Throwable $exception) {

        $timestamp = null;

    }


    /*
    |--------------------------------------------------------------------------
    | Security Classification
    |--------------------------------------------------------------------------
    */

    $securityTerms = [
        'failed',
        'failure',
        'denied',
        'unauthorized',
        'invalid',
        'locked',
        'security',
        'suspicious',
    ];


    $isSecurityEvent =
        collect($securityTerms)
            ->contains(
                fn ($term) =>
                    str_contains(
                        $eventLower,
                        $term
                    )
            );


    $isAuthenticationEvent =
        str_contains(
            $eventLower,
            'login'
        )
        ||
        str_contains(
            $eventLower,
            'logout'
        )
        ||
        str_contains(
            $eventLower,
            'auth'
        );


    $isCreateEvent =
        str_contains(
            $eventLower,
            'created'
        )
        ||
        str_contains(
            $eventLower,
            'create'
        );


    $isUpdateEvent =
        str_contains(
            $eventLower,
            'updated'
        )
        ||
        str_contains(
            $eventLower,
            'update'
        )
        ||
        str_contains(
            $eventLower,
            'changed'
        );


    $isDeleteEvent =
        str_contains(
            $eventLower,
            'deleted'
        )
        ||
        str_contains(
            $eventLower,
            'delete'
        );


    if (
        $isSecurityEvent
        ||
        $isDeleteEvent
    ) {

        $classification =
            'Security / Sensitive';

        $classificationClass =
            'classification-security';

        $classificationIcon =
            '!';

    } elseif ($isAuthenticationEvent) {

        $classification =
            'Authentication';

        $classificationClass =
            'classification-auth';

        $classificationIcon =
            'AU';

    } elseif (
        $isCreateEvent
        ||
        $isUpdateEvent
    ) {

        $classification =
            'Normal Activity';

        $classificationClass =
            'classification-normal';

        $classificationIcon =
            'OK';

    } else {

        $classification =
            'System Event';

        $classificationClass =
            'classification-system';

        $classificationIcon =
            'EV';

    }


    /*
    |--------------------------------------------------------------------------
    | Decode Structured Data
    |--------------------------------------------------------------------------
    */

    $decodeStructuredValue =
        function ($value) {

            if (
                $value instanceof
                \Illuminate\Support\Collection
            ) {
                return $value->toArray();
            }


            if (is_object($value)) {
                return (array) $value;
            }


            if (is_array($value)) {
                return $value;
            }


            if (is_string($value)) {

                $decoded =
                    json_decode(
                        $value,
                        true
                    );


                if (
                    json_last_error()
                    === JSON_ERROR_NONE
                    &&
                    is_array($decoded)
                ) {
                    return $decoded;
                }

            }


            return [];

        };


    /*
    |--------------------------------------------------------------------------
    | Sensitive Metadata Redaction
    |--------------------------------------------------------------------------
    |
    | The UI must never intentionally expose secrets from generic metadata.
    |
    */

    $sensitiveTerms = [
        'password',
        'password_confirmation',
        'token',
        'secret',
        'authorization',
        'cookie',
        'remember_token',
        'api_key',
        'apikey',
        'csrf',
        'otp',
        'pin',
    ];


    $sanitizeValue = null;


    $sanitizeValue =
        function (
            $value,
            $key = null
        ) use (
            &$sanitizeValue,
            $sensitiveTerms
        ) {

            $keyLower =
                strtolower(
                    (string) $key
                );


            foreach (
                $sensitiveTerms
                as $sensitiveTerm
            ) {

                if (
                    $keyLower !== ''
                    &&
                    str_contains(
                        $keyLower,
                        $sensitiveTerm
                    )
                ) {
                    return '[REDACTED]';
                }

            }


            if (
                $value instanceof
                \Illuminate\Support\Collection
            ) {
                $value =
                    $value->toArray();
            }


            if (is_object($value)) {
                $value =
                    (array) $value;
            }


            if (is_array($value)) {

                $sanitized = [];


                foreach (
                    $value
                    as $childKey => $childValue
                ) {

                    $sanitized[$childKey] =
                        $sanitizeValue(
                            $childValue,
                            $childKey
                        );

                }


                return $sanitized;

            }


            return $value;

        };


    /*
    |--------------------------------------------------------------------------
    | Old / New Values
    |--------------------------------------------------------------------------
    */

    $oldValuesRaw =
        $auditValue([
            'old_values',
            'old_data',
            'before',
            'properties.old',
            'changes.old',
        ]);


    $newValuesRaw =
        $auditValue([
            'new_values',
            'new_data',
            'after',
            'properties.new',
            'changes.new',
        ]);


    $oldValues =
        $sanitizeValue(
            $decodeStructuredValue(
                $oldValuesRaw
            )
        );


    $newValues =
        $sanitizeValue(
            $decodeStructuredValue(
                $newValuesRaw
            )
        );


    $changeKeys =
        collect(
            array_merge(
                array_keys($oldValues),
                array_keys($newValues)
            )
        )
            ->unique()
            ->filter(
                function ($key) use (
                    $oldValues,
                    $newValues
                ) {

                    return data_get(
                        $oldValues,
                        $key
                    )
                    !==
                    data_get(
                        $newValues,
                        $key
                    );

                }
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | Additional Metadata
    |--------------------------------------------------------------------------
    */

    $metadataRaw =
        $auditValue([
            'metadata',
            'properties',
            'context',
            'additional_data',
        ]);


    $metadata =
        $sanitizeValue(
            $decodeStructuredValue(
                $metadataRaw
            )
        );


    /*
    |--------------------------------------------------------------------------
    | Format Structured Value
    |--------------------------------------------------------------------------
    */

    $formatStructured =
        function ($value) {

            if ($value === null) {
                return 'null';
            }


            if ($value === true) {
                return 'true';
            }


            if ($value === false) {
                return 'false';
            }


            if (
                is_array($value)
                ||
                is_object($value)
            ) {

                return json_encode(
                    $value,
                    JSON_PRETTY_PRINT
                    |
                    JSON_UNESCAPED_SLASHES
                    |
                    JSON_UNESCAPED_UNICODE
                );

            }


            return (string) $value;

        };


    /*
    |--------------------------------------------------------------------------
    | Audit Record ID
    |--------------------------------------------------------------------------
    */

    $auditId =
        data_get(
            $log,
            'id'
        );

@endphp


<div class="audit-show-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="audit-show-hero">


        <div class="audit-show-hero-inner">


            <div class="audit-show-hero-copy">


                <div class="audit-show-eyebrow">


                    <span class="audit-show-eyebrow-dot"></span>


                    Security Monitoring · Audit Record

                    @if ($auditId)

                        #{{ $auditId }}

                    @endif


                </div>


                <h1>
                    {{ $eventLabel }}
                </h1>


                <p class="audit-show-subtitle">

                    Review the full event context,
                    responsible actor, affected resource,
                    network information and recorded changes.

                </p>


            </div>


            <div class="audit-show-hero-actions">


                <a
                    href="{{ route(
                        'admin.audit-logs.index'
                    ) }}"
                    class="audit-show-back-button"
                >
                    ← Back to Audit Logs
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY CARDS
         ================================================================== --}}

    <section class="audit-show-summary-grid">


        {{-- ==============================================================
             CLASSIFICATION
             ============================================================== --}}

        <article class="audit-show-summary-card">


            <div class="audit-show-summary-icon summary-security">

                {{ $classificationIcon }}

            </div>


            <div class="audit-show-summary-label">
                Event Classification
            </div>


            <div class="audit-show-summary-value">


                <span
                    class="
                        classification-badge
                        {{ $classificationClass }}
                    "
                >
                    {{ $classification }}
                </span>


            </div>


            <div class="audit-show-summary-note">

                Visual classification based
                on the recorded event code

            </div>


        </article>


        {{-- ==============================================================
             ACTOR
             ============================================================== --}}

        <article class="audit-show-summary-card">


            <div class="audit-show-summary-icon summary-blue">
                US
            </div>


            <div class="audit-show-summary-label">
                Responsible Actor
            </div>


            <div class="audit-show-summary-value">

                {{ $actorName }}

            </div>


            <div class="audit-show-summary-note">

                {{ \Illuminate\Support\Str::headline(
                    str_replace(
                        ['_', '-'],
                        ' ',
                        $actorRole
                    )
                ) }}

            </div>


        </article>


        {{-- ==============================================================
             RESOURCE
             ============================================================== --}}

        <article class="audit-show-summary-card">


            <div class="audit-show-summary-icon summary-purple">
                DB
            </div>


            <div class="audit-show-summary-label">
                Affected Resource
            </div>


            <div class="audit-show-summary-value">

                {{ $resourceType }}

            </div>


            <div class="audit-show-summary-note">


                @if ($resourceId)

                    Record #{{ $resourceId }}

                @else

                    System-level event

                @endif


            </div>


        </article>


        {{-- ==============================================================
             IP
             ============================================================== --}}

        <article class="audit-show-summary-card">


            <div class="audit-show-summary-icon summary-teal">
                IP
            </div>


            <div class="audit-show-summary-label">
                Source Address
            </div>


            <div
                class="
                    audit-show-summary-value
                    audit-detail-value-mono
                "
            >
                {{ $ipAddress }}
            </div>


            <div class="audit-show-summary-note">

                Recorded request IP address

            </div>


        </article>


    </section>


    {{-- ==================================================================
         SECURITY BANNER
         ================================================================== --}}

    <section
        @class([
            'audit-show-security-banner',
            'security-banner-normal' =>
                ! $isSecurityEvent
                && ! $isDeleteEvent,
        ])
    >


        <div class="audit-security-banner-icon">

            {{ $isSecurityEvent
                || $isDeleteEvent
                ? '!'
                : 'i'
            }}

        </div>


        <div class="audit-security-banner-copy">


            @if (
                $isSecurityEvent
                ||
                $isDeleteEvent
            )


                <strong>
                    This event may require additional administrative review.
                </strong>


                <span>

                    Review the actor, source IP address,
                    timestamp and affected resource before
                    determining whether this activity was expected.
                    The classification shown here is informational
                    and does not modify the stored audit record.

                </span>


            @else


                <strong>
                    This is a read-only historical audit record.
                </strong>


                <span>

                    The information below is presented for
                    accountability and investigation. No controls
                    are provided for changing or deleting the
                    historical event from this screen.

                </span>


            @endif


        </div>


    </section>


    {{-- ==================================================================
         MAIN LAYOUT
         ================================================================== --}}

    <div class="audit-show-layout">


        {{-- ==============================================================
             MAIN COLUMN
             ============================================================== --}}

        <div class="audit-show-main">


            {{-- ==========================================================
                 EVENT OVERVIEW
                 ========================================================== --}}

            <section class="audit-panel">


                <div class="audit-panel-header">


                    <div class="audit-panel-icon panel-blue">
                        EV
                    </div>


                    <div>


                        <h2>
                            Event Overview
                        </h2>


                        <p>
                            Primary information recorded for this event.
                        </p>


                    </div>


                </div>


                <div class="audit-panel-body">


                    <div class="event-overview">


                        <div class="event-primary-block">


                            <span class="event-primary-label">
                                Recorded Activity
                            </span>


                            <span class="event-primary-title">

                                {{ $eventLabel }}

                            </span>


                            <span class="event-code">

                                {{ $event }}

                            </span>


                            <p class="event-description">

                                {{ $description }}

                            </p>


                        </div>


                        <div class="audit-detail-grid">


                            <div class="audit-detail-card">


                                <span class="audit-detail-label">
                                    Audit Record ID
                                </span>


                                <span class="audit-detail-value">

                                    {{ $auditId
                                        ? '#' . $auditId
                                        : 'Not available'
                                    }}

                                </span>


                            </div>


                            <div class="audit-detail-card">


                                <span class="audit-detail-label">
                                    Occurred At
                                </span>


                                <span class="audit-detail-value">

                                    {{ $timestamp
                                        ? $timestamp->format(
                                            'F d, Y · h:i:s A'
                                        )
                                        : 'Timestamp unavailable'
                                    }}

                                </span>


                            </div>


                            <div class="audit-detail-card">


                                <span class="audit-detail-label">
                                    Classification
                                </span>


                                <span class="audit-detail-value">

                                    {{ $classification }}

                                </span>


                            </div>


                            <div class="audit-detail-card">


                                <span class="audit-detail-label">
                                    Time Zone
                                </span>


                                <span class="audit-detail-value">
                                    Asia/Manila
                                </span>


                            </div>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 ACTOR
                 ========================================================== --}}

            <section class="audit-panel">


                <div class="audit-panel-header">


                    <div class="audit-panel-icon panel-green">
                        US
                    </div>


                    <div>


                        <h2>
                            Actor & Account Context
                        </h2>


                        <p>

                            User or system process associated
                            with this event.

                        </p>


                    </div>


                </div>


                <div class="audit-panel-body">


                    <div class="audit-actor-profile">


                        <div class="audit-actor-avatar">

                            {{ $actorInitials ?: 'SY' }}

                        </div>


                        <div>


                            <span class="audit-actor-name">

                                {{ $actorName }}

                            </span>


                            <span class="audit-actor-subtitle">

                                {{ \Illuminate\Support\Str::headline(
                                    str_replace(
                                        ['_', '-'],
                                        ' ',
                                        $actorRole
                                    )
                                ) }}

                                @if ($actorEmail !== '')

                                    · {{ $actorEmail }}

                                @endif

                            </span>


                        </div>


                    </div>


                    <div class="audit-detail-grid">


                        <div class="audit-detail-card">


                            <span class="audit-detail-label">
                                Actor Name
                            </span>


                            <span class="audit-detail-value">

                                {{ $actorName }}

                            </span>


                        </div>


                        <div class="audit-detail-card">


                            <span class="audit-detail-label">
                                Actor Role
                            </span>


                            <span class="audit-detail-value">

                                {{ \Illuminate\Support\Str::headline(
                                    str_replace(
                                        ['_', '-'],
                                        ' ',
                                        $actorRole
                                    )
                                ) }}

                            </span>


                        </div>


                        <div class="audit-detail-card">


                            <span class="audit-detail-label">
                                Actor ID
                            </span>


                            <span class="audit-detail-value">

                                {{ $actorId
                                    ? '#' . $actorId
                                    : 'Not recorded'
                                }}

                            </span>


                        </div>


                        <div class="audit-detail-card">


                            <span class="audit-detail-label">
                                Actor Email
                            </span>


                            <span class="audit-detail-value">

                                {{ $actorEmail
                                    !== ''
                                    ? $actorEmail
                                    : 'Not recorded'
                                }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 RESOURCE
                 ========================================================== --}}

            <section class="audit-panel">


                <div class="audit-panel-header">


                    <div class="audit-panel-icon panel-purple">
                        DB
                    </div>


                    <div>


                        <h2>
                            Affected Resource
                        </h2>


                        <p>

                            Database or system resource
                            associated with this event.

                        </p>


                    </div>


                </div>


                <div class="audit-panel-body">


                    <div class="resource-display">


                        <div class="resource-icon">
                            DB
                        </div>


                        <div>


                            <span class="resource-name">

                                {{ $resourceType }}

                            </span>


                            <span class="resource-id">


                                @if ($resourceId)

                                    Database record
                                    #{{ $resourceId }}

                                @else

                                    No specific database record
                                    was attached to this event

                                @endif


                            </span>


                        </div>


                    </div>


                    <div class="audit-detail-grid">


                        <div class="audit-detail-card">


                            <span class="audit-detail-label">
                                Resource Type
                            </span>


                            <span class="audit-detail-value">

                                {{ $resourceType }}

                            </span>


                        </div>


                        <div class="audit-detail-card">


                            <span class="audit-detail-label">
                                Resource ID
                            </span>


                            <span class="audit-detail-value">

                                {{ $resourceId
                                    ? '#' . $resourceId
                                    : 'Not applicable'
                                }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 CHANGE COMPARISON
                 ========================================================== --}}

            <section class="audit-panel">


                <div class="audit-panel-header">


                    <div class="audit-panel-icon panel-orange">
                        CH
                    </div>


                    <div>


                        <h2>
                            Recorded Data Changes
                        </h2>


                        <p>

                            Before-and-after values where
                            change data was stored with the event.

                        </p>


                    </div>


                </div>


                <div class="audit-panel-body">


                    @if ($changeKeys->isNotEmpty())


                        <div class="change-list">


                            @foreach ($changeKeys as $field)


                                @php

                                    $beforeValue =
                                        data_get(
                                            $oldValues,
                                            $field
                                        );


                                    $afterValue =
                                        data_get(
                                            $newValues,
                                            $field
                                        );

                                @endphp


                                <article class="change-item">


                                    <div class="change-field">

                                        {{ \Illuminate\Support\Str::headline(
                                            str_replace(
                                                ['.', '_', '-'],
                                                ' ',
                                                $field
                                            )
                                        ) }}

                                    </div>


                                    <div class="change-values">


                                        <div
                                            class="
                                                change-value
                                                change-before
                                            "
                                        >


                                            <span class="change-value-label">
                                                Before
                                            </span>


                                            <div class="change-value-content">{{ $formatStructured($beforeValue) }}</div>


                                        </div>


                                        <div
                                            class="
                                                change-value
                                                change-after
                                            "
                                        >


                                            <span class="change-value-label">
                                                After
                                            </span>


                                            <div class="change-value-content">{{ $formatStructured($afterValue) }}</div>


                                        </div>


                                    </div>


                                </article>


                            @endforeach


                        </div>


                    @else


                        <div class="no-change-state">


                            <strong>
                                No before-and-after field changes were recorded.
                            </strong>


                            <span>

                                This is normal for events such as
                                login, logout, failed authentication
                                attempts, system notifications or
                                other activity that does not directly
                                update a database record.

                            </span>


                        </div>


                    @endif


                </div>


            </section>


            {{-- ==========================================================
                 METADATA
                 ========================================================== --}}

            <section class="audit-panel">


                <div class="audit-panel-header">


                    <div class="audit-panel-icon panel-teal">
                        MD
                    </div>


                    <div>


                        <h2>
                            Safe Event Metadata
                        </h2>


                        <p>

                            Additional structured information
                            stored with the audit event.

                        </p>


                    </div>


                </div>


                <div class="audit-panel-body">


                    @if (
                        is_array($metadata)
                        &&
                        count($metadata) > 0
                    )


                        <div class="metadata-grid">


                            @foreach ($metadata as $key => $value)


                                <div class="metadata-item">


                                    <div class="metadata-key">

                                        {{ $key }}

                                    </div>


                                    <div class="metadata-value">{{ $formatStructured($value) }}</div>


                                </div>


                            @endforeach


                        </div>


                    @else


                        <div class="no-change-state">


                            <strong>
                                No additional metadata was recorded.
                            </strong>


                            <span>

                                The core event, actor,
                                resource and request context
                                are still available above.

                            </span>


                        </div>


                    @endif


                </div>


            </section>


        </div>


        {{-- ==============================================================
             SIDEBAR
             ============================================================== --}}

        <aside class="audit-show-sidebar">


            {{-- ==========================================================
                 REQUEST CONTEXT
                 ========================================================== --}}

            <section class="audit-panel">


                <div class="audit-panel-header">


                    <div class="audit-panel-icon panel-red">
                        NET
                    </div>


                    <div>


                        <h2>
                            Request Context
                        </h2>


                        <p>
                            Network and client information.
                        </p>


                    </div>


                </div>


                <div class="audit-panel-body">


                    <div class="sidebar-info-list">


                        <div class="sidebar-info-item">


                            <span class="sidebar-info-label">
                                IP Address
                            </span>


                            <span
                                class="
                                    sidebar-info-value
                                    sidebar-info-mono
                                "
                            >
                                {{ $ipAddress }}
                            </span>


                        </div>


                        <div class="sidebar-info-item">


                            <span class="sidebar-info-label">
                                Device / Browser
                            </span>


                            <span class="sidebar-info-value">

                                {{ $deviceSummary }}

                            </span>


                        </div>


                        <div class="sidebar-info-item">


                            <span class="sidebar-info-label">
                                HTTP Method
                            </span>


                            <span
                                class="
                                    sidebar-info-value
                                    sidebar-info-mono
                                "
                            >
                                {{ strtoupper(
                                    $requestMethod
                                ) }}
                            </span>


                        </div>


                        <div class="sidebar-info-item">


                            <span class="sidebar-info-label">
                                Request Path
                            </span>


                            <span
                                class="
                                    sidebar-info-value
                                    sidebar-info-mono
                                "
                            >
                                {{ $requestPath }}
                            </span>


                        </div>


                        @if ($userAgent !== '')


                            <div class="sidebar-info-item">


                                <span class="sidebar-info-label">
                                    User Agent
                                </span>


                                <span
                                    class="
                                        sidebar-info-value
                                        sidebar-info-mono
                                    "
                                >

                                    {{ $userAgent }}

                                </span>


                            </div>


                        @endif


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 EVENT RECORD
                 ========================================================== --}}

            <section class="audit-panel">


                <div class="audit-panel-header">


                    <div class="audit-panel-icon panel-blue">
                        ID
                    </div>


                    <div>


                        <h2>
                            Event Record
                        </h2>


                        <p>
                            Core audit-log identity.
                        </p>


                    </div>


                </div>


                <div class="audit-panel-body">


                    <div class="sidebar-info-list">


                        <div class="sidebar-info-item">


                            <span class="sidebar-info-label">
                                Audit ID
                            </span>


                            <span class="sidebar-info-value">

                                {{ $auditId
                                    ? '#' . $auditId
                                    : 'Not available'
                                }}

                            </span>


                        </div>


                        <div class="sidebar-info-item">


                            <span class="sidebar-info-label">
                                Event
                            </span>


                            <span
                                class="
                                    sidebar-info-value
                                    sidebar-info-mono
                                "
                            >
                                {{ $event }}
                            </span>


                        </div>


                        <div class="sidebar-info-item">


                            <span class="sidebar-info-label">
                                Classification
                            </span>


                            <span class="sidebar-info-value">


                                <span
                                    class="
                                        classification-badge
                                        {{ $classificationClass }}
                                    "
                                >
                                    {{ $classification }}
                                </span>


                            </span>


                        </div>


                        <div class="sidebar-info-item">


                            <span class="sidebar-info-label">
                                Recorded At
                            </span>


                            <span class="sidebar-info-value">

                                {{ $timestamp
                                    ? $timestamp->format(
                                        'M d, Y · h:i:s A'
                                    )
                                    : 'Unavailable'
                                }}

                            </span>


                        </div>


                    </div>


                </div>


            </section>


            {{-- ==========================================================
                 INVESTIGATION CHECKLIST
                 ========================================================== --}}

            <section class="audit-panel">


                <div class="audit-panel-header">


                    <div class="audit-panel-icon panel-orange">
                        CK
                    </div>


                    <div>


                        <h2>
                            Review Checklist
                        </h2>


                        <p>
                            Useful context during investigation.
                        </p>


                    </div>


                </div>


                <div class="audit-panel-body">


                    <ul class="investigation-list">


                        <li>
                            Verify whether the actor was expected
                            to perform this action.
                        </li>


                        <li>
                            Review the timestamp against known
                            administrative activity.
                        </li>


                        <li>
                            Check whether the IP address and
                            device context are reasonable.
                        </li>


                        <li>
                            Review the affected resource and
                            any before-and-after changes.
                        </li>


                        <li>
                            Investigate repeated failed or
                            unauthorized authentication events.
                        </li>


                    </ul>


                </div>


            </section>


            {{-- ==========================================================
                 READ ONLY
                 ========================================================== --}}

            <section class="audit-panel">


                <div class="audit-panel-header">


                    <div class="audit-panel-icon panel-green">
                        RO
                    </div>


                    <div>


                        <h2>
                            Audit Integrity
                        </h2>


                        <p>
                            Historical accountability.
                        </p>


                    </div>


                </div>


                <div class="audit-panel-body">


                    <div class="read-only-box">

                        <strong>
                            Read-only record.
                        </strong>

                        This page intentionally does not
                        provide Edit, Delete or Clear controls.
                        Historical audit records should remain
                        available for accountability and
                        administrative review.

                    </div>


                </div>


            </section>


        </aside>


    </div>


    {{-- ==================================================================
         FOOTNOTE
         ================================================================== --}}

    <div class="audit-show-footnote">


        <span class="audit-show-footnote-icon">
            i
        </span>


        <span>

            Event classifications such as
            <strong>Security</strong>,
            <strong>Authentication</strong> and
            <strong>Normal Activity</strong> are presentation
            aids derived from the recorded event name.
            They do not alter the original audit-log data.
            Sensitive-looking metadata keys are redacted
            before being displayed on this page.

        </span>


    </div>


</div>


@endsection