@extends('layouts.app')

@section('title', 'OJT Assignment Management | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMIN - OJT ASSIGNMENT MANAGEMENT
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */

    :root {
        --oa-navy: #183B6B;
        --oa-navy-dark: #102A4A;
        --oa-navy-deep: #0B223D;

        --oa-blue: #2563EB;
        --oa-blue-light: #60A5FA;
        --oa-blue-soft: #EAF2FF;

        --oa-teal: #0F766E;
        --oa-teal-dark: #0B5F59;
        --oa-teal-soft: #E7F7F5;

        --oa-green: #15803D;
        --oa-green-soft: #EAF8EF;

        --oa-orange: #B45309;
        --oa-orange-soft: #FFF5E6;

        --oa-red: #B42318;
        --oa-red-soft: #FFF0EE;

        --oa-purple: #6D4FC2;
        --oa-purple-soft: #F2EEFF;

        --oa-gray: #475569;
        --oa-gray-soft: #F1F5F9;

        --oa-text: #102A4A;
        --oa-body: #405872;
        --oa-muted: #64778C;

        --oa-white: #FFFFFF;
        --oa-soft: #F8FBFE;

        --oa-border: #D8E3EE;
        --oa-border-soft: #E7EDF4;

        --oa-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --oa-shadow-medium:
            0 18px 42px
            rgba(15, 42, 74, 0.10);

        --oa-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);

        --oa-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .assignment-index-page {
        width: 100%;

        color:
            var(--oa-text);

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

    .assignment-index-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 28px;

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
                rgba(45, 212, 191, 0.12),
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
            var(--oa-shadow-large);
    }


    .assignment-index-hero::before {
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


    .assignment-index-hero::after {
        content: "";

        position: absolute;

        width: 220px;
        height: 220px;

        right: 285px;
        bottom: -165px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.04);
    }


    .assignment-index-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 38px;
    }


    .assignment-index-hero-copy {
        max-width: 800px;
    }


    .assignment-index-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 11px;

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


    .assignment-index-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background:
            #60A5FA;

        box-shadow:
            0 0 0 5px
            rgba(96, 165, 250, 0.13);
    }


    .assignment-index-hero h1 {
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
            -0.5px;
    }


    .assignment-index-hero-description {
        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.7;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .assignment-index-hero-actions {
        width: 275px;

        flex-shrink: 0;

        display: grid;

        gap: 10px;
    }


    .assignment-index-hero-button {
        min-height: 53px;

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
            var(--oa-transition);
    }


    .assignment-index-hero-primary {
        background:
            #FFFFFF;

        color:
            var(--oa-navy);
    }


    .assignment-index-hero-primary:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;
    }


    .assignment-index-hero-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .assignment-index-hero-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    /* ================================================================
       SUMMARY
       ================================================================ */

    .assignment-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(5, minmax(0, 1fr));

        gap: 16px;

        margin-bottom: 24px;
    }


    .assignment-summary-card {
        padding: 20px;

        border:
            1px solid
            var(--oa-border);

        border-radius: 18px;

        background:
            #FFFFFF;

        box-shadow:
            var(--oa-shadow);

        transition:
            var(--oa-transition);
    }


    .assignment-summary-card:hover {
        transform:
            translateY(-2px);

        box-shadow:
            var(--oa-shadow-medium);
    }


    .assignment-summary-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        margin-bottom: 13px;
    }


    .assignment-summary-icon {
        width: 45px;
        height: 45px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        font-size: 12px;
        font-weight: 900;
    }


    .summary-all {
        background:
            var(--oa-blue-soft);

        color:
            var(--oa-blue);
    }


    .summary-pending {
        background:
            var(--oa-orange-soft);

        color:
            var(--oa-orange);
    }


    .summary-active {
        background:
            var(--oa-green-soft);

        color:
            var(--oa-green);
    }


    .summary-completed {
        background:
            var(--oa-teal-soft);

        color:
            var(--oa-teal);
    }


    .summary-cancelled {
        background:
            var(--oa-red-soft);

        color:
            var(--oa-red);
    }


    .assignment-summary-label {
        display: block;

        color:
            var(--oa-muted);

        font-size: 13px;
        font-weight: 800;
    }


    .assignment-summary-value {
        display: block;

        color:
            var(--oa-text);

        font-size: 30px;
        font-weight: 900;

        line-height: 1.15;
    }


    .assignment-summary-note {
        display: block;

        margin-top: 4px;

        color:
            var(--oa-muted);

        font-size: 12px;

        line-height: 1.45;
    }


    /* ================================================================
       WORKFLOW INFO
       ================================================================ */

    .assignment-workflow-info {
        display: flex;
        align-items: flex-start;

        gap: 14px;

        margin-bottom: 23px;

        padding:
            18px
            19px;

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


    .assignment-workflow-icon {
        width: 46px;
        height: 46px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--oa-blue-soft);

        color:
            var(--oa-blue);

        font-size: 12px;
        font-weight: 900;
    }


    .assignment-workflow-info strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--oa-text);

        font-size: 16px;
        font-weight: 900;
    }


    .assignment-workflow-info p {
        margin: 0;

        color:
            var(--oa-body);

        font-size: 14px;

        line-height: 1.65;
    }


    /* ================================================================
       TOOLBAR
       ================================================================ */

    .assignment-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 19px;

        padding: 17px;

        border:
            1px solid
            var(--oa-border);

        border-radius: 16px;

        background:
            #FFFFFF;

        box-shadow:
            var(--oa-shadow);
    }


    .assignment-search {
        position: relative;

        width:
            min(
                100%,
                520px
            );
    }


    .assignment-search input {
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

        background:
            #FBFDFF;

        color:
            var(--oa-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 650;

        transition:
            var(--oa-transition);
    }


    .assignment-search input::placeholder {
        color:
            #8999AA;

        font-weight: 500;
    }


    .assignment-search input:focus {
        border-color:
            var(--oa-blue);

        background:
            #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, 0.08);
    }


    .assignment-search-icon {
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

        background:
            var(--oa-blue-soft);

        color:
            var(--oa-blue);

        font-size: 10px;
        font-weight: 900;
    }


    .assignment-toolbar-right {
        display: flex;
        align-items: center;

        gap: 11px;
    }


    .assignment-filter {
        min-height: 47px;

        padding:
            0
            13px;

        border:
            1px solid
            var(--oa-border);

        border-radius: 10px;

        outline: none;

        background:
            #FFFFFF;

        color:
            var(--oa-text);

        font-family: inherit;

        font-size: 14px;
        font-weight: 750;

        cursor: pointer;
    }


    .assignment-filter:focus {
        border-color:
            var(--oa-blue);
    }


    .assignment-visible-count {
        color:
            var(--oa-muted);

        font-size: 14px;
        font-weight: 750;

        white-space: nowrap;
    }


    .assignment-visible-count strong {
        color:
            var(--oa-text);

        font-size: 17px;
        font-weight: 900;
    }


    /* ================================================================
       ASSIGNMENT LIST
       ================================================================ */

    .assignment-list {
        display: grid;

        gap: 17px;
    }


    .assignment-card {
        overflow: hidden;

        border:
            1px solid
            var(--oa-border);

        border-radius: 19px;

        background:
            #FFFFFF;

        box-shadow:
            var(--oa-shadow);

        transition:
            var(--oa-transition);
    }


    .assignment-card:hover {
        transform:
            translateY(-2px);

        border-color:
            #BCD0E4;

        box-shadow:
            var(--oa-shadow-medium);
    }


    /* ================================================================
       CARD HEADER
       ================================================================ */

    .assignment-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 20px;

        padding:
            20px
            21px;

        border-bottom:
            1px solid
            var(--oa-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FCFDFE
            );
    }


    .assignment-student-area {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 15px;
    }


    .assignment-student-avatar {
        width: 57px;
        height: 57px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background:
            linear-gradient(
                145deg,
                var(--oa-navy),
                var(--oa-blue)
            );

        color:
            #FFFFFF;

        font-size: 16px;
        font-weight: 900;
    }


    .assignment-student-name {
        display: block;

        margin-bottom: 3px;

        color:
            var(--oa-text);

        font-size: 20px;
        font-weight: 900;

        line-height: 1.35;
    }


    .assignment-student-meta {
        display: block;

        color:
            var(--oa-muted);

        font-size: 14px;

        line-height: 1.5;
    }


    /* ================================================================
       STATUS
       ================================================================ */

    .assignment-status {
        flex-shrink: 0;

        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding:
            8px
            12px;

        border-radius: 999px;

        font-size: 13px;
        font-weight: 900;

        text-transform:
            capitalize;
    }


    .assignment-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;
    }


    .status-pending {
        background:
            var(--oa-orange-soft);

        color:
            var(--oa-orange);
    }


    .status-pending::before {
        background:
            #F59E0B;
    }


    .status-active {
        background:
            var(--oa-green-soft);

        color:
            var(--oa-green);
    }


    .status-active::before {
        background:
            #22C55E;
    }


    .status-completed {
        background:
            var(--oa-teal-soft);

        color:
            var(--oa-teal);
    }


    .status-completed::before {
        background:
            #14B8A6;
    }


    .status-cancelled {
        background:
            var(--oa-red-soft);

        color:
            var(--oa-red);
    }


    .status-cancelled::before {
        background:
            #D92D20;
    }


    .status-other {
        background:
            var(--oa-gray-soft);

        color:
            var(--oa-gray);
    }


    .status-other::before {
        background:
            #94A3B8;
    }


    /* ================================================================
       BODY
       ================================================================ */

    .assignment-card-body {
        padding:
            20px
            21px;
    }


    .assignment-parties-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 12px;

        margin-bottom: 14px;
    }


    .assignment-party-card {
        padding:
            14px
            15px;

        border:
            1px solid
            var(--oa-border-soft);

        border-radius: 12px;

        background:
            var(--oa-soft);
    }


    .assignment-party-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--oa-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform:
            uppercase;

        letter-spacing:
            .25px;
    }


    .assignment-party-value {
        display: block;

        color:
            var(--oa-text);

        font-size: 16px;
        font-weight: 900;

        line-height: 1.5;

        word-break:
            break-word;
    }


    .assignment-party-helper {
        display: block;

        margin-top: 3px;

        color:
            var(--oa-muted);

        font-size: 13px;

        line-height: 1.45;
    }


    /* ================================================================
       PLACEMENT DETAILS
       ================================================================ */

    .assignment-details-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 11px;
    }


    .assignment-detail {
        padding:
            13px;

        border:
            1px solid
            var(--oa-border-soft);

        border-radius: 11px;

        background:
            #FFFFFF;
    }


    .assignment-detail-label {
        display: block;

        margin-bottom: 4px;

        color:
            var(--oa-muted);

        font-size: 12px;
        font-weight: 850;

        text-transform:
            uppercase;
    }


    .assignment-detail-value {
        display: block;

        color:
            var(--oa-text);

        font-size: 15px;
        font-weight: 900;

        line-height: 1.45;
    }


    /* ================================================================
       NOTES
       ================================================================ */

    .assignment-notes {
        margin-top: 13px;

        padding:
            14px
            15px;

        border:
            1px solid
            #D8E4F1;

        border-radius: 11px;

        background:
            linear-gradient(
                135deg,
                #FBFDFF,
                #F5F9FE
            );

        color:
            var(--oa-body);

        font-size: 14px;

        line-height: 1.65;
    }


    .assignment-notes strong {
        color:
            var(--oa-text);

        font-weight: 900;
    }


    /* ================================================================
       FOOTER
       ================================================================ */

    .assignment-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 14px;

        margin-top: 17px;

        padding-top: 16px;

        border-top:
            1px solid
            var(--oa-border-soft);
    }


    .assignment-record-id {
        color:
            var(--oa-muted);

        font-size: 13px;
        font-weight: 750;
    }


    .assignment-actions {
        display: flex;
        align-items: center;

        gap: 8px;
    }


    .assignment-action {
        min-height: 44px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            14px;

        border:
            1px solid
            var(--oa-border);

        border-radius: 10px;

        background:
            #FFFFFF;

        color:
            var(--oa-navy);

        font-size: 14px;
        font-weight: 850;

        text-decoration: none;

        transition:
            var(--oa-transition);
    }


    .assignment-action:hover {
        transform:
            translateY(-1px);

        background:
            var(--oa-blue-soft);
    }


    .assignment-action-primary {
        border-color:
            var(--oa-blue);

        background:
            var(--oa-blue);

        color:
            #FFFFFF;
    }


    .assignment-action-primary:hover {
        border-color:
            #1D4ED8;

        background:
            #1D4ED8;

        color:
            #FFFFFF;
    }


    /* ================================================================
       EMPTY STATE
       ================================================================ */

    .assignment-empty {
        padding:
            56px
            30px;

        border:
            1px dashed
            #C5D4E2;

        border-radius: 20px;

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #F9FCFE
            );

        text-align: center;

        box-shadow:
            var(--oa-shadow);
    }


    .assignment-empty-icon {
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

        background:
            var(--oa-blue-soft);

        color:
            var(--oa-blue);

        font-size: 20px;
        font-weight: 900;
    }


    .assignment-empty h2 {
        margin:
            0
            0
            7px;

        color:
            var(--oa-text);

        font-size: 24px;
        font-weight: 900;
    }


    .assignment-empty p {
        max-width: 610px;

        margin:
            0
            auto
            20px;

        color:
            var(--oa-muted);

        font-size: 15px;

        line-height: 1.65;
    }


    .assignment-empty-action {
        min-height: 49px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            19px;

        border-radius: 11px;

        background:
            var(--oa-blue);

        color:
            #FFFFFF;

        font-size: 15px;
        font-weight: 900;

        text-decoration: none;
    }


    /* ================================================================
       FILTER EMPTY
       ================================================================ */

    .assignment-filter-empty {
        display: none;

        padding:
            35px
            20px;

        border:
            1px dashed
            #C9D6E3;

        border-radius: 15px;

        background:
            #FBFDFF;

        color:
            var(--oa-muted);

        font-size: 15px;

        text-align: center;
    }


    /* ================================================================
       PAGINATION
       ================================================================ */

    .assignment-pagination {
        margin-top: 24px;
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1180px) {

        .assignment-summary-grid {
            grid-template-columns:
                repeat(3, minmax(0, 1fr));
        }


        .assignment-details-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 950px) {

        .assignment-index-hero-inner {
            flex-direction:
                column;

            align-items:
                flex-start;
        }


        .assignment-index-hero-actions {
            width:
                100%;
        }


        .assignment-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 800px) {

        .assignment-toolbar {
            flex-direction:
                column;

            align-items:
                stretch;
        }


        .assignment-search {
            width:
                100%;
        }


        .assignment-toolbar-right {
            justify-content:
                space-between;
        }

    }


    @media (max-width: 700px) {

        .assignment-parties-grid,
        .assignment-details-grid {
            grid-template-columns:
                1fr;
        }


        .assignment-card-header {
            flex-direction:
                column;
        }


        .assignment-card-footer {
            flex-direction:
                column;

            align-items:
                stretch;
        }


        .assignment-actions {
            display: grid;

            grid-template-columns:
                1fr
                1fr;
        }


        .assignment-action {
            width:
                100%;
        }

    }


    @media (max-width: 650px) {

        .assignment-index-hero {
            padding:
                29px
                22px;

            border-radius:
                22px;
        }


        .assignment-index-hero h1 {
            font-size:
                31px;
        }


        .assignment-index-hero-description {
            font-size:
                16px;
        }


        .assignment-summary-grid {
            grid-template-columns:
                1fr;
        }


        .assignment-toolbar-right {
            flex-direction:
                column;

            align-items:
                stretch;
        }


        .assignment-visible-count {
            text-align:
                right;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Assignment Collection
    |--------------------------------------------------------------------------
    |
    | Supports Laravel pagination while also remaining compatible with a
    | normal Collection.
    |
    */

    $assignmentCollection =
        method_exists(
            $assignments,
            'items'
        )
            ? collect(
                $assignments->items()
            )
            : collect(
                $assignments
            );


    /*
    |--------------------------------------------------------------------------
    | Total Assignment Count
    |--------------------------------------------------------------------------
    */

    $totalAssignments =
        method_exists(
            $assignments,
            'total'
        )
            ? $assignments->total()
            : $assignmentCollection->count();


    /*
    |--------------------------------------------------------------------------
    | Current Page Status Counts
    |--------------------------------------------------------------------------
    */

    $pendingCount =
        $assignmentCollection
            ->where(
                'status',
                \App\Models\OjtAssignment::STATUS_PENDING
            )
            ->count();


    $activeCount =
        $assignmentCollection
            ->where(
                'status',
                \App\Models\OjtAssignment::STATUS_ACTIVE
            )
            ->count();


    $completedCount =
        $assignmentCollection
            ->where(
                'status',
                \App\Models\OjtAssignment::STATUS_COMPLETED
            )
            ->count();


    $cancelledCount =
        $assignmentCollection
            ->where(
                'status',
                \App\Models\OjtAssignment::STATUS_CANCELLED
            )
            ->count();


    /*
    |--------------------------------------------------------------------------
    | Initials Helper
    |--------------------------------------------------------------------------
    */

    $makeInitials =
        function ($name) {

            return collect(
                preg_split(
                    '/\s+/',
                    trim(
                        (string) $name
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

        };


    /*
    |--------------------------------------------------------------------------
    | Date Formatter
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


    /*
    |--------------------------------------------------------------------------
    | Status Class
    |--------------------------------------------------------------------------
    */

    $statusClass =
        function ($status) {

            return match (
                strtolower(
                    (string)
                    $status
                )
            ) {

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

        };

@endphp


<div class="assignment-index-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="assignment-index-hero">


        <div class="assignment-index-hero-inner">


            <div class="assignment-index-hero-copy">


                <div class="assignment-index-eyebrow">

                    <span class="assignment-index-dot"></span>

                    Administrator · OJT Placement Management

                </div>


                <h1>
                    OJT Assignment Management
                </h1>


                <p class="assignment-index-hero-description">

                    Manage Student OJT placements and maintain
                    the connection between Students, partner
                    companies, Supervisors, required training hours,
                    placement schedules, and assignment status.

                </p>


            </div>


            <div class="assignment-index-hero-actions">


                @if (Route::has('admin.assignments.create'))

                    <a
                        href="{{ route(
                            'admin.assignments.create'
                        ) }}"
                        class="
                            assignment-index-hero-button
                            assignment-index-hero-primary
                        "
                    >
                        Create OJT Assignment
                    </a>

                @endif


                <a
                    href="{{ route(
                        'admin.reports.index'
                    ) }}"
                    class="
                        assignment-index-hero-button
                        assignment-index-hero-secondary
                    "
                >
                    Open OJT Reports
                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SUMMARY
         ================================================================== --}}

    <section class="assignment-summary-grid">


        <article class="assignment-summary-card">


            <div class="assignment-summary-top">

                <div
                    class="
                        assignment-summary-icon
                        summary-all
                    "
                >
                    OJ
                </div>

            </div>


            <span class="assignment-summary-label">
                Total Assignments
            </span>


            <span class="assignment-summary-value">
                {{ $totalAssignments }}
            </span>


            <span class="assignment-summary-note">
                All OJT placement records
            </span>


        </article>


        <article class="assignment-summary-card">


            <div class="assignment-summary-top">

                <div
                    class="
                        assignment-summary-icon
                        summary-pending
                    "
                >
                    PN
                </div>

            </div>


            <span class="assignment-summary-label">
                Pending
            </span>


            <span class="assignment-summary-value">
                {{ $pendingCount }}
            </span>


            <span class="assignment-summary-note">
                On this page
            </span>


        </article>


        <article class="assignment-summary-card">


            <div class="assignment-summary-top">

                <div
                    class="
                        assignment-summary-icon
                        summary-active
                    "
                >
                    AC
                </div>

            </div>


            <span class="assignment-summary-label">
                Active
            </span>


            <span class="assignment-summary-value">
                {{ $activeCount }}
            </span>


            <span class="assignment-summary-note">
                On this page
            </span>


        </article>


        <article class="assignment-summary-card">


            <div class="assignment-summary-top">

                <div
                    class="
                        assignment-summary-icon
                        summary-completed
                    "
                >
                    CP
                </div>

            </div>


            <span class="assignment-summary-label">
                Completed
            </span>


            <span class="assignment-summary-value">
                {{ $completedCount }}
            </span>


            <span class="assignment-summary-note">
                On this page
            </span>


        </article>


        <article class="assignment-summary-card">


            <div class="assignment-summary-top">

                <div
                    class="
                        assignment-summary-icon
                        summary-cancelled
                    "
                >
                    CN
                </div>

            </div>


            <span class="assignment-summary-label">
                Cancelled
            </span>


            <span class="assignment-summary-value">
                {{ $cancelledCount }}
            </span>


            <span class="assignment-summary-note">
                On this page
            </span>


        </article>


    </section>


    {{-- ==================================================================
         WORKFLOW INFORMATION
         ================================================================== --}}

    <section class="assignment-workflow-info">


        <div class="assignment-workflow-icon">
            WF
        </div>


        <div>


            <strong>
                OJT Assignments are the center of the Student monitoring workflow.
            </strong>


            <p>

                Each assignment connects a Student with a Company
                and Supervisor, defines required OJT hours and placement
                dates, and provides the context for attendance,
                Daily Work Logs, Supervisor validation, final evaluation,
                and completion history.

            </p>


        </div>


    </section>


    {{-- ==================================================================
         ASSIGNMENTS
         ================================================================== --}}

    @if ($assignmentCollection->isNotEmpty())


        {{-- ==============================================================
             TOOLBAR
             ============================================================== --}}

        <div class="assignment-toolbar">


            <div class="assignment-search">


                <span class="assignment-search-icon">
                    FN
                </span>


                <input
                    type="search"
                    id="assignment-search"
                    placeholder="Find Student, Company, Supervisor, or assignment..."
                    aria-label="Find OJT Assignment"
                >


            </div>


            <div class="assignment-toolbar-right">


                <select
                    id="assignment-status-filter"
                    class="assignment-filter"
                    aria-label="Filter assignment status"
                >

                    <option value="all">
                        All Statuses
                    </option>

                    <option value="pending">
                        Pending
                    </option>

                    <option value="active">
                        Active
                    </option>

                    <option value="completed">
                        Completed
                    </option>

                    <option value="cancelled">
                        Cancelled
                    </option>

                </select>


                <div class="assignment-visible-count">

                    Showing

                    <strong id="assignment-visible-count">
                        {{ $assignmentCollection->count() }}
                    </strong>

                    on this page

                </div>


            </div>


        </div>


        {{-- ==============================================================
             LIST
             ============================================================== --}}

        <div
            class="assignment-list"
            id="assignment-list"
        >


            @foreach ($assignments as $assignment)


                @php

                    /*
                    |--------------------------------------------------------------------------
                    | Student
                    |--------------------------------------------------------------------------
                    */

                    $student =
                        $assignment
                            ->studentProfile
                            ?->user;


                    $studentName =
                        $student
                            ?->name
                        ?? 'Student unavailable';


                    $studentNumber =
                        $assignment
                            ->studentProfile
                            ?->student_number
                        ?? 'Not provided';


                    $program =
                        $assignment
                            ->studentProfile
                            ?->program
                        ?? null;


                    /*
                    |--------------------------------------------------------------------------
                    | Company
                    |--------------------------------------------------------------------------
                    */

                    $companyName =
                        $assignment
                            ->company
                            ?->name
                        ?? 'Company unavailable';


                    /*
                    |--------------------------------------------------------------------------
                    | Supervisor
                    |--------------------------------------------------------------------------
                    */

                    $supervisorName =
                        $assignment
                            ->supervisor
                            ?->name
                        ?? 'Supervisor unavailable';


                    /*
                    |--------------------------------------------------------------------------
                    | Status
                    |--------------------------------------------------------------------------
                    */

                    $assignmentStatus =
                        strtolower(
                            trim(
                                (string)
                                $assignment->status
                            )
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Search Data
                    |--------------------------------------------------------------------------
                    */

                    $searchText =
                        strtolower(
                            implode(
                                ' ',
                                [
                                    $assignment->id,
                                    $studentName,
                                    $studentNumber,
                                    $program,
                                    $companyName,
                                    $supervisorName,
                                    $assignment->status,
                                ]
                            )
                        );

                @endphp


                <article
                    class="assignment-card"
                    data-assignment-card
                    data-status="{{ $assignmentStatus }}"
                    data-search="{{ $searchText }}"
                >


                    {{-- ==========================================================
                         HEADER
                         ========================================================== --}}

                    <div class="assignment-card-header">


                        <div class="assignment-student-area">


                            <div class="assignment-student-avatar">

                                {{ $makeInitials(
                                    $studentName
                                ) }}

                            </div>


                            <div>


                                <span class="assignment-student-name">
                                    {{ $studentName }}
                                </span>


                                <span class="assignment-student-meta">

                                    Student No.

                                    {{ $studentNumber }}

                                    @if (filled($program))

                                        · {{ $program }}

                                    @endif

                                </span>


                            </div>


                        </div>


                        <span
                            class="
                                assignment-status
                                {{ $statusClass(
                                    $assignment->status
                                ) }}
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


                    </div>


                    {{-- ==========================================================
                         BODY
                         ========================================================== --}}

                    <div class="assignment-card-body">


                        {{-- ======================================================
                             PARTIES
                             ====================================================== --}}

                        <div class="assignment-parties-grid">


                            <div class="assignment-party-card">


                                <span class="assignment-party-label">
                                    Partner Company
                                </span>


                                <span class="assignment-party-value">
                                    {{ $companyName }}
                                </span>


                                <span class="assignment-party-helper">
                                    OJT training establishment
                                </span>


                            </div>


                            <div class="assignment-party-card">


                                <span class="assignment-party-label">
                                    Assigned Supervisor
                                </span>


                                <span class="assignment-party-value">
                                    {{ $supervisorName }}
                                </span>


                                <span class="assignment-party-helper">
                                    Responsible for monitoring and validation
                                </span>


                            </div>


                        </div>


                        {{-- ======================================================
                             DETAILS
                             ====================================================== --}}

                        <div class="assignment-details-grid">


                            <div class="assignment-detail">


                                <span class="assignment-detail-label">
                                    Required Hours
                                </span>


                                <span class="assignment-detail-value">

                                    {{ number_format(
                                        (float)
                                        (
                                            $assignment
                                                ->required_hours
                                            ?? 0
                                        ),
                                        0
                                    ) }}

                                    hours

                                </span>


                            </div>


                            <div class="assignment-detail">


                                <span class="assignment-detail-label">
                                    Start Date
                                </span>


                                <span class="assignment-detail-value">

                                    {{ $formatDate(
                                        $assignment->start_date
                                    ) }}

                                </span>


                            </div>


                            <div class="assignment-detail">


                                <span class="assignment-detail-label">
                                    End Date
                                </span>


                                <span class="assignment-detail-value">

                                    {{ $formatDate(
                                        $assignment->end_date
                                    ) }}

                                </span>


                            </div>


                            <div class="assignment-detail">


                                <span class="assignment-detail-label">
                                    Assignment ID
                                </span>


                                <span class="assignment-detail-value">
                                    #{{ $assignment->id }}
                                </span>


                            </div>


                        </div>


                        {{-- ======================================================
                             NOTES
                             ====================================================== --}}

                        @if (filled($assignment->notes))


                            <div class="assignment-notes">

                                <strong>
                                    Placement Notes:
                                </strong>

                                {{ $assignment->notes }}

                            </div>


                        @endif


                        {{-- ======================================================
                             ACTIONS
                             ====================================================== --}}

                        <div class="assignment-card-footer">


                            <span class="assignment-record-id">

                                OJT Placement Record
                                #{{ $assignment->id }}

                            </span>


                            <div class="assignment-actions">


                                @if (
                                    Route::has(
                                        'admin.assignments.show'
                                    )
                                )


                                    <a
                                        href="{{ route(
                                            'admin.assignments.show',
                                            $assignment
                                        ) }}"
                                        class="
                                            assignment-action
                                            assignment-action-primary
                                        "
                                    >
                                        View Assignment
                                    </a>


                                @endif


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
                                        class="assignment-action"
                                    >
                                        Edit Assignment
                                    </a>


                                @endif


                            </div>


                        </div>


                    </div>


                </article>


            @endforeach


        </div>


        {{-- ==============================================================
             FILTER EMPTY
             ============================================================== --}}

        <div
            class="assignment-filter-empty"
            id="assignment-filter-empty"
        >

            No OJT Assignment on this page matches
            your current search or status filter.

        </div>


        {{-- ==============================================================
             PAGINATION
             ============================================================== --}}

        @if (
            method_exists(
                $assignments,
                'links'
            )
        )

            <div class="assignment-pagination">

                {{ $assignments->links() }}

            </div>

        @endif


    @else


        {{-- ==================================================================
             EMPTY STATE
             ================================================================== --}}

        <section class="assignment-empty">


            <div class="assignment-empty-icon">
                OJ
            </div>


            <h2>
                No OJT Assignments Yet
            </h2>


            <p>

                There are currently no OJT placement records.
                Create the first assignment to connect a Student
                with a participating Company and Supervisor,
                configure required OJT hours, and begin the
                monitoring workflow.

            </p>


            @if (Route::has('admin.assignments.create'))


                <a
                    href="{{ route(
                        'admin.assignments.create'
                    ) }}"
                    class="assignment-empty-action"
                >
                    Create First OJT Assignment
                </a>


            @endif


        </section>


    @endif


</div>


@endsection


@push('scripts')

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /*
            |--------------------------------------------------------------------------
            | Current Page Assignment Search + Filter
            |--------------------------------------------------------------------------
            |
            | This only filters assignments already loaded on the current
            | pagination page. It does not alter the database.
            |
            */

            const searchInput =
                document.getElementById(
                    'assignment-search'
                );


            const statusFilter =
                document.getElementById(
                    'assignment-status-filter'
                );


            const assignmentCards =
                Array.from(
                    document.querySelectorAll(
                        '[data-assignment-card]'
                    )
                );


            const visibleCount =
                document.getElementById(
                    'assignment-visible-count'
                );


            const filterEmpty =
                document.getElementById(
                    'assignment-filter-empty'
                );


            function applyAssignmentFilters() {

                const searchValue =
                    searchInput
                        ? searchInput
                            .value
                            .trim()
                            .toLowerCase()
                        : '';


                const selectedStatus =
                    statusFilter
                        ? statusFilter.value
                        : 'all';


                let visible =
                    0;


                assignmentCards.forEach(
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


                        const matchesSearch =
                            searchValue === ''
                            ||
                            searchable.includes(
                                searchValue
                            );


                        const matchesStatus =
                            selectedStatus === 'all'
                            ||
                            status === selectedStatus;


                        const shouldShow =
                            matchesSearch
                            &&
                            matchesStatus;


                        card.style.display =
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
                    applyAssignmentFilters
                );

            }


            if (statusFilter) {

                statusFilter.addEventListener(
                    'change',
                    applyAssignmentFilters
                );

            }

        }
    );

</script>

@endpush