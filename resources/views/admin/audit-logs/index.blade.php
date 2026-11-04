@extends('layouts.app')

@section('title', 'Audit & Security Logs | OJT Sync')


@push('styles')

<style>

    :root {
        --audit-navy: #183B6B;
        --audit-navy-dark: #102A4A;

        --audit-blue: #2563EB;
        --audit-blue-soft: #EAF2FF;

        --audit-teal: #0F766E;
        --audit-teal-soft: #E7F7F5;

        --audit-green: #15803D;
        --audit-green-soft: #EAF8EF;

        --audit-orange: #B45309;
        --audit-orange-soft: #FFF5E6;

        --audit-red: #B42318;
        --audit-red-soft: #FFF0EE;

        --audit-purple: #6D4FC2;
        --audit-purple-soft: #F2EEFF;

        --audit-gray: #475569;
        --audit-gray-soft: #F1F5F9;

        --audit-text: #102A4A;
        --audit-body: #405872;
        --audit-muted: #64778C;

        --audit-white: #FFFFFF;
        --audit-soft: #F8FBFE;

        --audit-border: #D8E3EE;
        --audit-border-soft: #E7EDF4;

        --audit-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --audit-shadow-medium:
            0 18px 42px
            rgba(15, 42, 74, 0.10);

        --audit-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --audit-transition:
            all 0.22s ease;
    }


    .audit-page {
        width: 100%;
        color: var(--audit-text);
        font-family: "Segoe UI", Arial, sans-serif;
        font-size: 16px;
        line-height: 1.65;
    }


    .audit-hero {
        position: relative;
        overflow: hidden;

        margin-bottom: 28px;

        padding: 43px 44px;

        border-radius: 29px;

        background:
            radial-gradient(
                circle at 90% 12%,
                rgba(96, 165, 250, 0.23),
                transparent 27%
            ),
            radial-gradient(
                circle at 72% 98%,
                rgba(167, 139, 250, 0.12),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #091D34 0%,
                #102A4A 35%,
                #183B6B 70%,
                #403F78 100%
            );

        box-shadow: var(--audit-shadow-large);
    }


    .audit-hero-inner {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 40px;
    }


    .audit-hero-copy {
        max-width: 790px;
    }


    .audit-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 11px;

        padding: 7px 12px;

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


    .audit-eyebrow-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background: #93C5FD;
    }


    .audit-hero h1 {
        margin: 0 0 10px;

        color: #FFFFFF;

        font-size: 38px;
        font-weight: 900;

        line-height: 1.18;
    }


    .audit-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    .audit-hero-actions {
        width: 275px;
        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .audit-hero-button {
        min-height: 53px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 0 17px;

        border:
            1px solid
            rgba(255, 255, 255, 0.18);

        border-radius: 12px;

        font-size: 15px;
        font-weight: 850;

        text-decoration: none;

        transition: var(--audit-transition);
    }


    .audit-hero-primary {
        background: #FFFFFF;
        color: var(--audit-navy);
    }


    .audit-hero-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color: #FFFFFF;
    }


    .audit-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 17px;

        margin-bottom: 24px;
    }


    .audit-summary-card {
        padding: 21px;

        border:
            1px solid
            var(--audit-border);

        border-radius: 18px;

        background: #FFFFFF;

        box-shadow: var(--audit-shadow);
    }


    .audit-summary-icon {
        width: 46px;
        height: 46px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 13px;

        border-radius: 13px;

        font-size: 12px;
        font-weight: 900;
    }


    .summary-all {
        background: var(--audit-blue-soft);
        color: var(--audit-blue);
    }


    .summary-security {
        background: var(--audit-red-soft);
        color: var(--audit-red);
    }


    .summary-account {
        background: var(--audit-purple-soft);
        color: var(--audit-purple);
    }


    .summary-workflow {
        background: var(--audit-teal-soft);
        color: var(--audit-teal);
    }


    .audit-summary-label {
        display: block;

        color: var(--audit-muted);

        font-size: 14px;
        font-weight: 800;
    }


    .audit-summary-value {
        display: block;

        margin-top: 3px;

        color: var(--audit-text);

        font-size: 31px;
        font-weight: 900;
    }


    .audit-summary-note {
        display: block;

        margin-top: 4px;

        color: var(--audit-muted);

        font-size: 13px;
    }


    .audit-integrity {
        display: flex;
        align-items: flex-start;

        gap: 14px;

        margin-bottom: 23px;

        padding: 18px 19px;

        border:
            1px solid
            #D4E2F0;

        border-radius: 15px;

        background:
            linear-gradient(
                135deg,
                #FBFDFF,
                #F3F8FD
            );
    }


    .audit-integrity-icon {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background: var(--audit-blue-soft);
        color: var(--audit-blue);

        font-size: 12px;
        font-weight: 900;
    }


    .audit-integrity strong {
        display: block;

        margin-bottom: 4px;

        font-size: 16px;
        font-weight: 900;
    }


    .audit-integrity p {
        margin: 0;

        color: var(--audit-body);

        font-size: 14px;
    }


    .audit-panel {
        overflow: hidden;

        border:
            1px solid
            var(--audit-border);

        border-radius: 20px;

        background: #FFFFFF;

        box-shadow: var(--audit-shadow);
    }


    .audit-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding: 21px 22px;

        border-bottom:
            1px solid
            var(--audit-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FBFDFF
            );
    }


    .audit-panel-heading {
        display: flex;
        align-items: center;

        gap: 13px;
    }


    .audit-panel-icon {
        width: 48px;
        height: 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background: var(--audit-purple-soft);
        color: var(--audit-purple);

        font-size: 12px;
        font-weight: 900;
    }


    .audit-panel-header h2 {
        margin: 0 0 3px;

        font-size: 23px;
        font-weight: 900;
    }


    .audit-panel-header p {
        margin: 0;

        color: var(--audit-muted);

        font-size: 14px;
    }


    .audit-readonly-badge {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding: 8px 11px;

        border-radius: 999px;

        background: var(--audit-green-soft);
        color: var(--audit-green);

        font-size: 13px;
        font-weight: 900;
    }


    .audit-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 17px;

        padding: 17px 20px;

        border-bottom:
            1px solid
            var(--audit-border-soft);
    }


    .audit-search {
        position: relative;

        width:
            min(
                100%,
                520px
            );
    }


    .audit-search input {
        width: 100%;
        min-height: 53px;

        padding:
            0
            15px
            0
            47px;

        border:
            1px solid
            #C9D6E3;

        border-radius: 12px;

        outline: none;

        background: #FBFDFF;

        color: var(--audit-text);

        font-size: 16px;
        font-weight: 650;
    }


    .audit-search-icon {
        position: absolute;

        top: 50%;
        left: 15px;

        transform:
            translateY(-50%);

        width: 23px;
        height: 23px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 7px;

        background: var(--audit-blue-soft);
        color: var(--audit-blue);

        font-size: 10px;
        font-weight: 900;
    }


    .audit-toolbar-right {
        display: flex;
        align-items: center;

        gap: 10px;
    }


    .audit-filter {
        min-height: 47px;

        padding: 0 12px;

        border:
            1px solid
            var(--audit-border);

        border-radius: 10px;

        background: #FFFFFF;

        color: var(--audit-text);

        font-size: 14px;
        font-weight: 750;
    }


    .audit-visible-count {
        color: var(--audit-muted);

        font-size: 14px;
        font-weight: 750;

        white-space: nowrap;
    }


    .audit-visible-count strong {
        color: var(--audit-text);

        font-size: 17px;
        font-weight: 900;
    }


    .audit-entry {
        display: grid;

        grid-template-columns:
            64px
            minmax(0, 1fr)
            210px;

        gap: 17px;

        padding: 20px 21px;

        border-bottom:
            1px solid
            var(--audit-border-soft);
    }


    .audit-entry:last-child {
        border-bottom: none;
    }


    .audit-entry:hover {
        background: #FBFDFF;
    }


    .audit-event-icon {
        width: 52px;
        height: 52px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 15px;

        font-size: 12px;
        font-weight: 900;
    }


    .event-security {
        background: var(--audit-red-soft);
        color: var(--audit-red);
    }


    .event-account {
        background: var(--audit-purple-soft);
        color: var(--audit-purple);
    }


    .event-workflow {
        background: var(--audit-teal-soft);
        color: var(--audit-teal);
    }


    .event-access {
        background: var(--audit-blue-soft);
        color: var(--audit-blue);
    }


    .event-system {
        background: var(--audit-gray-soft);
        color: var(--audit-gray);
    }


    .audit-entry-top {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 8px;

        margin-bottom: 7px;
    }


    .audit-action-name {
        color: var(--audit-text);

        font-size: 17px;
        font-weight: 900;
    }


    .audit-category {
        display: inline-flex;

        padding: 5px 9px;

        border-radius: 999px;

        font-size: 11px;
        font-weight: 900;

        text-transform: uppercase;
    }


    .category-security {
        background: var(--audit-red-soft);
        color: var(--audit-red);
    }


    .category-account {
        background: var(--audit-purple-soft);
        color: var(--audit-purple);
    }


    .category-workflow {
        background: var(--audit-teal-soft);
        color: var(--audit-teal);
    }


    .category-access {
        background: var(--audit-blue-soft);
        color: var(--audit-blue);
    }


    .category-system {
        background: var(--audit-gray-soft);
        color: var(--audit-gray);
    }


    .audit-description {
        margin: 0 0 10px;

        color: var(--audit-body);

        font-size: 15px;
    }


    .audit-meta-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap:
            7px
            14px;
    }


    .audit-meta-item {
        color: var(--audit-muted);

        font-size: 13px;
    }


    .audit-meta-item strong {
        color: var(--audit-text);
    }


    .audit-entry-side {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: center;

        gap: 8px;

        text-align: right;
    }


    .audit-time {
        color: var(--audit-text);

        font-size: 14px;
        font-weight: 850;
    }


    .audit-date {
        color: var(--audit-muted);

        font-size: 12px;
    }


    .audit-view-button {
        min-height: 41px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 0 13px;

        border:
            1px solid
            var(--audit-border);

        border-radius: 9px;

        background: #FFFFFF;

        color: var(--audit-navy);

        font-size: 13px;
        font-weight: 850;

        text-decoration: none;
    }


    .audit-filter-empty {
        display: none;

        margin: 20px;

        padding: 32px 20px;

        border:
            1px dashed
            #C8D6E3;

        border-radius: 14px;

        background: #FBFDFF;

        color: var(--audit-muted);

        text-align: center;
    }


    .audit-empty {
        padding: 58px 30px;

        text-align: center;
    }


    .audit-empty-icon {
        width: 74px;
        height: 74px;

        margin:
            0
            auto
            16px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 20px;

        background: var(--audit-blue-soft);
        color: var(--audit-blue);

        font-size: 19px;
        font-weight: 900;
    }


    .audit-empty h3 {
        margin: 0 0 7px;

        font-size: 23px;
        font-weight: 900;
    }


    .audit-empty p {
        max-width: 590px;

        margin:
            0
            auto;

        color: var(--audit-muted);

        font-size: 15px;
    }


    .audit-panel-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        padding: 17px 21px;

        border-top:
            1px solid
            var(--audit-border-soft);

        background: #FCFDFE;
    }


    .audit-footer-text {
        color: var(--audit-muted);

        font-size: 13px;
    }


    .audit-footer-text strong {
        color: var(--audit-text);
    }


    /* ================================================================
       CUSTOM PAGINATION
       ================================================================ */

    .audit-custom-pagination {
        display: flex;
        align-items: center;
        justify-content: center;

        flex-wrap: wrap;

        gap: 8px;

        margin-top: 24px;

        padding: 14px 16px;

        border:
            1px solid
            var(--audit-border);

        border-radius: 16px;

        background: #FFFFFF;

        box-shadow: var(--audit-shadow);
    }


    .audit-page-button,
    .audit-page-number {
        min-width: 44px;
        min-height: 44px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 0 14px;

        border:
            1px solid
            var(--audit-border);

        border-radius: 10px;

        background: #FFFFFF;

        color: var(--audit-navy);

        font-size: 14px;
        font-weight: 850;

        line-height: 1;

        text-decoration: none;

        transition: var(--audit-transition);
    }


    .audit-page-number {
        padding: 0 12px;
    }


    .audit-page-button:hover,
    .audit-page-number:hover {
        border-color: #BCD0E4;

        background: var(--audit-blue-soft);

        color: var(--audit-blue);
    }


    .audit-page-current {
        border-color: var(--audit-blue);

        background: var(--audit-blue);

        color: #FFFFFF;

        cursor: default;
    }


    .audit-page-disabled {
        border-color: #E0E7EF;

        background: #F5F8FB;

        color: #9AA8B7;

        cursor: not-allowed;
    }


    .audit-page-dots {
        min-width: 32px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        color: var(--audit-muted);

        font-size: 18px;
        font-weight: 900;
    }


    .audit-pagination-info {
        margin-top: 10px;

        color: var(--audit-muted);

        font-size: 14px;
        font-weight: 650;

        text-align: center;
    }


    .audit-pagination-info strong {
        color: var(--audit-text);
    }


    /*
    |--------------------------------------------------------------------------
    | Protect against oversized Laravel pagination SVG
    |--------------------------------------------------------------------------
    */

    .audit-page svg,
    .audit-custom-pagination svg,
    .audit-pagination svg {
        width: 18px !important;
        height: 18px !important;

        max-width: 18px !important;
        max-height: 18px !important;

        display: inline-block !important;
    }


    @media (max-width: 1050px) {

        .audit-hero-inner {
            flex-direction: column;
            align-items: flex-start;
        }


        .audit-hero-actions {
            width: 100%;
        }


        .audit-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 850px) {

        .audit-toolbar {
            flex-direction: column;
            align-items: stretch;
        }


        .audit-search {
            width: 100%;
        }


        .audit-toolbar-right {
            justify-content: space-between;
        }


        .audit-entry {
            grid-template-columns:
                55px
                minmax(0, 1fr);
        }


        .audit-entry-side {
            grid-column: 2;

            align-items: flex-start;

            text-align: left;
        }

    }


    @media (max-width: 650px) {

        .audit-hero {
            padding: 29px 22px;

            border-radius: 22px;
        }


        .audit-hero h1 {
            font-size: 31px;
        }


        .audit-summary-grid {
            grid-template-columns: 1fr;
        }


        .audit-toolbar-right {
            flex-direction: column;
            align-items: stretch;
        }


        .audit-panel-header {
            flex-direction: column;
            align-items: flex-start;
        }


        .audit-entry {
            grid-template-columns: 1fr;
        }


        .audit-entry-side {
            grid-column: auto;
        }


        .audit-panel-footer {
            flex-direction: column;
            align-items: flex-start;
        }


        .audit-custom-pagination {
            gap: 6px;

            padding: 12px 10px;
        }


        .audit-page-button {
            flex: 1 1 auto;
        }

    }

</style>

@endpush


@section('content')


@php

    $auditSource =
        $auditLogs
        ?? $logs
        ?? collect();


    $auditCollection =
        is_object($auditSource)
        && method_exists(
            $auditSource,
            'items'
        )
            ? collect(
                $auditSource->items()
            )
            : collect(
                $auditSource
            );


    $totalAuditLogs =
        is_object($auditSource)
        && method_exists(
            $auditSource,
            'total'
        )
            ? $auditSource->total()
            : $auditCollection->count();


    $classifyEvent =
        function ($action) {

            $normalized =
                strtolower(
                    (string)
                    $action
                );


            if (
                str_contains(
                    $normalized,
                    'failed'
                )
                ||
                str_contains(
                    $normalized,
                    'security'
                )
                ||
                str_contains(
                    $normalized,
                    'password'
                )
                ||
                str_contains(
                    $normalized,
                    'unauthorized'
                )
            ) {
                return 'security';
            }


            if (
                str_contains(
                    $normalized,
                    'login'
                )
                ||
                str_contains(
                    $normalized,
                    'logout'
                )
                ||
                str_contains(
                    $normalized,
                    'auth'
                )
            ) {
                return 'access';
            }


            if (
                str_contains(
                    $normalized,
                    'student'
                )
                ||
                str_contains(
                    $normalized,
                    'supervisor'
                )
                ||
                str_contains(
                    $normalized,
                    'account'
                )
                ||
                str_contains(
                    $normalized,
                    'user'
                )
                ||
                str_contains(
                    $normalized,
                    'archive'
                )
                ||
                str_contains(
                    $normalized,
                    'restore'
                )
            ) {
                return 'account';
            }


            if (
                str_contains(
                    $normalized,
                    'attendance'
                )
                ||
                str_contains(
                    $normalized,
                    'work'
                )
                ||
                str_contains(
                    $normalized,
                    'assignment'
                )
                ||
                str_contains(
                    $normalized,
                    'evaluation'
                )
                ||
                str_contains(
                    $normalized,
                    'validate'
                )
                ||
                str_contains(
                    $normalized,
                    'completion'
                )
            ) {
                return 'workflow';
            }


            return 'system';

        };


    $securityCount =
        $auditCollection
            ->filter(
                function ($log) use (
                    $classifyEvent
                ) {

                    $action =
                        data_get(
                            $log,
                            'action'
                        )
                        ??
                        data_get(
                            $log,
                            'event'
                        )
                        ??
                        '';


                    return
                        $classifyEvent(
                            $action
                        )
                        ===
                        'security';

                }
            )
            ->count();


    $accountCount =
        $auditCollection
            ->filter(
                function ($log) use (
                    $classifyEvent
                ) {

                    $action =
                        data_get(
                            $log,
                            'action'
                        )
                        ??
                        data_get(
                            $log,
                            'event'
                        )
                        ??
                        '';


                    return
                        $classifyEvent(
                            $action
                        )
                        ===
                        'account';

                }
            )
            ->count();


    $workflowCount =
        $auditCollection
            ->filter(
                function ($log) use (
                    $classifyEvent
                ) {

                    $action =
                        data_get(
                            $log,
                            'action'
                        )
                        ??
                        data_get(
                            $log,
                            'event'
                        )
                        ??
                        '';


                    return
                        $classifyEvent(
                            $action
                        )
                        ===
                        'workflow';

                }
            )
            ->count();


    $actionOptions =
        $auditCollection
            ->map(
                fn ($log) =>
                    (string)
                    (
                        data_get(
                            $log,
                            'action'
                        )
                        ??
                        data_get(
                            $log,
                            'event'
                        )
                        ??
                        'system_event'
                    )
            )
            ->filter()
            ->unique()
            ->sort()
            ->values();


    $formatAction =
        function ($action) {

            return ucwords(
                str_replace(
                    [
                        '.',
                        '_',
                        '-',
                    ],
                    ' ',
                    (string)
                    $action
                )
            );

        };


    $formatDate =
        function ($date) {

            if (! $date) {
                return 'Date unavailable';
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
                            'M d, Y'
                        );

            } catch (\Throwable $exception) {

                return (string) $date;

            }

        };


    $formatTime =
        function ($date) {

            if (! $date) {
                return 'Time unavailable';
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
                            'h:i:s A'
                        );

            } catch (\Throwable $exception) {

                return '';

            }

        };

@endphp


<div class="audit-page">


    <section class="audit-hero">


        <div class="audit-hero-inner">


            <div class="audit-hero-copy">


                <div class="audit-eyebrow">

                    <span class="audit-eyebrow-dot"></span>

                    Administrator · Security & Accountability

                </div>


                <h1>
                    Audit & Security Logs
                </h1>


                <p class="audit-hero-description">

                    Review important system activity including
                    authentication events, account administration,
                    OJT Assignment actions, validation activity,
                    and other security-sensitive events.

                </p>


            </div>


            <div class="audit-hero-actions">


                <a
                    href="{{ route(
                        'admin.dashboard'
                    ) }}"
                    class="
                        audit-hero-button
                        audit-hero-primary
                    "
                >
                    Back to Dashboard
                </a>


                <a
                    href="{{ route(
                        'admin.reports.index'
                    ) }}"
                    class="
                        audit-hero-button
                        audit-hero-secondary
                    "
                >
                    Open Reports Center
                </a>


            </div>


        </div>


    </section>


    <section class="audit-summary-grid">


        <article class="audit-summary-card">

            <div class="audit-summary-icon summary-all">
                AU
            </div>

            <span class="audit-summary-label">
                Audit Records
            </span>

            <span class="audit-summary-value">
                {{ $totalAuditLogs }}
            </span>

            <span class="audit-summary-note">
                Total records available
            </span>

        </article>


        <article class="audit-summary-card">

            <div class="audit-summary-icon summary-security">
                SE
            </div>

            <span class="audit-summary-label">
                Security Events
            </span>

            <span class="audit-summary-value">
                {{ $securityCount }}
            </span>

            <span class="audit-summary-note">
                Detected on this page
            </span>

        </article>


        <article class="audit-summary-card">

            <div class="audit-summary-icon summary-account">
                AC
            </div>

            <span class="audit-summary-label">
                Account Events
            </span>

            <span class="audit-summary-value">
                {{ $accountCount }}
            </span>

            <span class="audit-summary-note">
                Detected on this page
            </span>

        </article>


        <article class="audit-summary-card">

            <div class="audit-summary-icon summary-workflow">
                WF
            </div>

            <span class="audit-summary-label">
                OJT Workflow
            </span>

            <span class="audit-summary-value">
                {{ $workflowCount }}
            </span>

            <span class="audit-summary-note">
                Detected on this page
            </span>

        </article>


    </section>


    <section class="audit-integrity">


        <div class="audit-integrity-icon">
            RO
        </div>


        <div>

            <strong>
                Audit history is read-only.
            </strong>

            <p>

                Audit records should be reviewed rather than edited
                or removed so the system preserves a reliable
                administrative activity history.

            </p>

        </div>


    </section>


    <section class="audit-panel">


        <div class="audit-panel-header">


            <div class="audit-panel-heading">


                <div class="audit-panel-icon">
                    LG
                </div>


                <div>

                    <h2>
                        System Activity History
                    </h2>

                    <p>
                        Most recent recorded activity appears first
                    </p>

                </div>


            </div>


            <span class="audit-readonly-badge">
                Read-Only History
            </span>


        </div>


        @if ($auditCollection->isNotEmpty())


            <div class="audit-toolbar">


                <div class="audit-search">


                    <span class="audit-search-icon">
                        FN
                    </span>


                    <input
                        type="search"
                        id="audit-search"
                        placeholder="Find action, actor, description, or IP address..."
                        aria-label="Search audit logs"
                    >


                </div>


                <div class="audit-toolbar-right">


                    <select
                        id="audit-category-filter"
                        class="audit-filter"
                    >

                        <option value="all">
                            All Categories
                        </option>

                        <option value="security">
                            Security
                        </option>

                        <option value="access">
                            Authentication
                        </option>

                        <option value="account">
                            Account Management
                        </option>

                        <option value="workflow">
                            OJT Workflow
                        </option>

                        <option value="system">
                            System
                        </option>

                    </select>


                    <select
                        id="audit-action-filter"
                        class="audit-filter"
                    >

                        <option value="all">
                            All Actions
                        </option>


                        @foreach ($actionOptions as $action)

                            <option
                                value="{{ strtolower($action) }}"
                            >
                                {{ $formatAction($action) }}
                            </option>

                        @endforeach


                    </select>


                    <div class="audit-visible-count">

                        Showing

                        <strong id="audit-visible-count">
                            {{ $auditCollection->count() }}
                        </strong>

                    </div>


                </div>


            </div>


            <div id="audit-list">


                @foreach ($auditCollection as $auditLog)


                    @php

                        $action =
                            (string)
                            (
                                data_get(
                                    $auditLog,
                                    'action'
                                )
                                ??
                                data_get(
                                    $auditLog,
                                    'event'
                                )
                                ??
                                'system_event'
                            );


                        $category =
                            $classifyEvent(
                                $action
                            );


                        $actionLabel =
                            $formatAction(
                                $action
                            );


                        $actorName =
                            data_get(
                                $auditLog,
                                'actor.name'
                            )
                            ??
                            data_get(
                                $auditLog,
                                'user.name'
                            )
                            ??
                            'System / Guest';


                        $actorRole =
                            data_get(
                                $auditLog,
                                'actor.role'
                            )
                            ??
                            data_get(
                                $auditLog,
                                'actor_role'
                            )
                            ??
                            null;


                        $description =
                            data_get(
                                $auditLog,
                                'description'
                            )
                            ??
                            data_get(
                                $auditLog,
                                'message'
                            )
                            ??
                            'System activity was recorded for this event.';


                        $ipAddress =
                            data_get(
                                $auditLog,
                                'ip_address'
                            )
                            ??
                            data_get(
                                $auditLog,
                                'ip'
                            )
                            ??
                            'Not recorded';


                        $categoryLabel =
                            match ($category) {

                                'security' =>
                                    'Security',

                                'access' =>
                                    'Authentication',

                                'account' =>
                                    'Account',

                                'workflow' =>
                                    'OJT Workflow',

                                default =>
                                    'System',

                            };


                        $eventInitials =
                            match ($category) {

                                'security' =>
                                    'SE',

                                'access' =>
                                    'AU',

                                'account' =>
                                    'AC',

                                'workflow' =>
                                    'WF',

                                default =>
                                    'SY',

                            };


                        $searchText =
                            strtolower(
                                implode(
                                    ' ',
                                    [
                                        $auditLog->id,
                                        $action,
                                        $actionLabel,
                                        $actorName,
                                        $actorRole,
                                        $description,
                                        $ipAddress,
                                        $categoryLabel,
                                    ]
                                )
                            );

                    @endphp


                    <article
                        class="audit-entry"
                        data-audit-entry
                        data-category="{{ $category }}"
                        data-action="{{ strtolower($action) }}"
                        data-search="{{ $searchText }}"
                    >


                        <div
                            class="
                                audit-event-icon
                                event-{{ $category }}
                            "
                        >
                            {{ $eventInitials }}
                        </div>


                        <div>


                            <div class="audit-entry-top">


                                <span class="audit-action-name">
                                    {{ $actionLabel }}
                                </span>


                                <span
                                    class="
                                        audit-category
                                        category-{{ $category }}
                                    "
                                >
                                    {{ $categoryLabel }}
                                </span>


                            </div>


                            <p class="audit-description">
                                {{ $description }}
                            </p>


                            <div class="audit-meta-row">


                                <span class="audit-meta-item">

                                    Actor:

                                    <strong>
                                        {{ $actorName }}
                                    </strong>

                                </span>


                                @if (filled($actorRole))

                                    <span class="audit-meta-item">

                                        Role:

                                        <strong>

                                            {{ ucwords(
                                                str_replace(
                                                    [
                                                        '_',
                                                        '-',
                                                    ],
                                                    ' ',
                                                    $actorRole
                                                )
                                            ) }}

                                        </strong>

                                    </span>

                                @endif


                                <span class="audit-meta-item">

                                    IP:

                                    <strong>
                                        {{ $ipAddress }}
                                    </strong>

                                </span>


                                <span class="audit-meta-item">

                                    Log ID:

                                    <strong>
                                        #{{ $auditLog->id }}
                                    </strong>

                                </span>


                            </div>


                        </div>


                        <div class="audit-entry-side">


                            <div>

                                <div class="audit-time">

                                    {{ $formatTime(
                                        $auditLog->created_at
                                    ) }}

                                </div>

                                <div class="audit-date">

                                    {{ $formatDate(
                                        $auditLog->created_at
                                    ) }}

                                </div>

                            </div>


                            @if (
                                Route::has(
                                    'admin.audit-logs.show'
                                )
                            )

                                <a
                                    href="{{ route(
                                        'admin.audit-logs.show',
                                        $auditLog
                                    ) }}"
                                    class="audit-view-button"
                                >
                                    View Event Details
                                </a>

                            @endif


                        </div>


                    </article>


                @endforeach


            </div>


            <div
                class="audit-filter-empty"
                id="audit-filter-empty"
            >
                No audit event on this page matches your search.
            </div>


            <div class="audit-panel-footer">

                <span class="audit-footer-text">

                    Current page:

                    <strong>
                        {{ $auditCollection->count() }}
                    </strong>

                    event(s)

                </span>


                <span class="audit-footer-text">

                    Viewed:

                    <strong>

                        {{ now()
                            ->timezone(
                                'Asia/Manila'
                            )
                            ->format(
                                'M d, Y · h:i A'
                            )
                        }}

                    </strong>

                </span>

            </div>


        @else


            <div class="audit-empty">


                <div class="audit-empty-icon">
                    AU
                </div>


                <h3>
                    No Audit Events Recorded
                </h3>


                <p>

                    There are currently no audit entries available.

                </p>


            </div>


        @endif


    </section>


    {{-- ==================================================================
         CUSTOM PAGINATION
         ================================================================== --}}

    @if (
        is_object($auditSource)
        &&
        method_exists(
            $auditSource,
            'hasPages'
        )
        &&
        $auditSource->hasPages()
    )


        @php

            $currentPage =
                $auditSource->currentPage();


            $lastPage =
                $auditSource->lastPage();


            $startPage =
                max(
                    1,
                    $currentPage - 2
                );


            $endPage =
                min(
                    $lastPage,
                    $currentPage + 2
                );

        @endphp


        <nav
            class="audit-custom-pagination"
            aria-label="Audit log pagination"
        >


            @if ($auditSource->onFirstPage())

                <span
                    class="
                        audit-page-button
                        audit-page-disabled
                    "
                >
                    ← Previous
                </span>

            @else

                <a
                    href="{{ route(
                        'admin.audit-logs.index',
                        array_merge(
                            request()->except('page'),
                            [
                                'page' =>
                                    $currentPage - 1
                            ]
                        )
                    ) }}"
                    class="audit-page-button"
                >
                    ← Previous
                </a>

            @endif


            @if ($startPage > 1)

                <a
                    href="{{ route(
                        'admin.audit-logs.index',
                        array_merge(
                            request()->except('page'),
                            [
                                'page' => 1
                            ]
                        )
                    ) }}"
                    class="audit-page-number"
                >
                    1
                </a>


                @if ($startPage > 2)

                    <span class="audit-page-dots">
                        …
                    </span>

                @endif

            @endif


            @for (
                $page = $startPage;
                $page <= $endPage;
                $page++
            )


                @if ($page === $currentPage)

                    <span
                        class="
                            audit-page-number
                            audit-page-current
                        "
                    >
                        {{ $page }}
                    </span>

                @else

                    <a
                        href="{{ route(
                            'admin.audit-logs.index',
                            array_merge(
                                request()->except('page'),
                                [
                                    'page' => $page
                                ]
                            )
                        ) }}"
                        class="audit-page-number"
                    >
                        {{ $page }}
                    </a>

                @endif


            @endfor


            @if ($endPage < $lastPage)


                @if (
                    $endPage
                    <
                    ($lastPage - 1)
                )

                    <span class="audit-page-dots">
                        …
                    </span>

                @endif


                <a
                    href="{{ route(
                        'admin.audit-logs.index',
                        array_merge(
                            request()->except('page'),
                            [
                                'page' =>
                                    $lastPage
                            ]
                        )
                    ) }}"
                    class="audit-page-number"
                >
                    {{ $lastPage }}
                </a>


            @endif


            @if ($auditSource->hasMorePages())

                <a
                    href="{{ route(
                        'admin.audit-logs.index',
                        array_merge(
                            request()->except('page'),
                            [
                                'page' =>
                                    $currentPage + 1
                            ]
                        )
                    ) }}"
                    class="audit-page-button"
                >
                    Next →
                </a>

            @else

                <span
                    class="
                        audit-page-button
                        audit-page-disabled
                    "
                >
                    Next →
                </span>

            @endif


        </nav>


        <div class="audit-pagination-info">

            Page

            <strong>
                {{ $currentPage }}
            </strong>

            of

            <strong>
                {{ $lastPage }}
            </strong>

            ·

            {{ number_format(
                $auditSource->total()
            ) }}

            total audit event(s)

        </div>


    @endif


</div>


@endsection


@push('scripts')

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const searchInput =
                document.getElementById(
                    'audit-search'
                );


            const categoryFilter =
                document.getElementById(
                    'audit-category-filter'
                );


            const actionFilter =
                document.getElementById(
                    'audit-action-filter'
                );


            const auditEntries =
                Array.from(
                    document.querySelectorAll(
                        '[data-audit-entry]'
                    )
                );


            const visibleCount =
                document.getElementById(
                    'audit-visible-count'
                );


            const filterEmpty =
                document.getElementById(
                    'audit-filter-empty'
                );


            function applyAuditFilters() {

                const searchValue =
                    searchInput
                        ? searchInput
                            .value
                            .trim()
                            .toLowerCase()
                        : '';


                const selectedCategory =
                    categoryFilter
                        ? categoryFilter.value
                        : 'all';


                const selectedAction =
                    actionFilter
                        ? actionFilter.value
                        : 'all';


                let visible = 0;


                auditEntries.forEach(
                    function (entry) {

                        const searchable =
                            (
                                entry.dataset.search
                                || ''
                            )
                            .toLowerCase();


                        const category =
                            (
                                entry.dataset.category
                                || ''
                            )
                            .toLowerCase();


                        const action =
                            (
                                entry.dataset.action
                                || ''
                            )
                            .toLowerCase();


                        const matchesSearch =
                            searchValue === ''
                            ||
                            searchable.includes(
                                searchValue
                            );


                        const matchesCategory =
                            selectedCategory === 'all'
                            ||
                            category ===
                            selectedCategory;


                        const matchesAction =
                            selectedAction === 'all'
                            ||
                            action ===
                            selectedAction;


                        const shouldShow =
                            matchesSearch
                            &&
                            matchesCategory
                            &&
                            matchesAction;


                        entry.style.display =
                            shouldShow
                                ? ''
                                : 'none';


                        if (shouldShow) {
                            visible++;
                        }

                    }
                );


                if (visibleCount) {

                    visibleCount.textContent =
                        String(
                            visible
                        );

                }


                if (filterEmpty) {

                    filterEmpty.style.display =
                        visible === 0
                            ? 'block'
                            : 'none';

                }

            }


            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    applyAuditFilters
                );

            }


            if (categoryFilter) {

                categoryFilter.addEventListener(
                    'change',
                    applyAuditFilters
                );

            }


            if (actionFilter) {

                actionFilter.addEventListener(
                    'change',
                    applyAuditFilters
                );

            }

        }
    );

</script>

@endpush