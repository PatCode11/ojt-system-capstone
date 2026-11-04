<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        OJT Monitoring Report | OJT Sync
    </title>


    <style>

        /* ================================================================
           PRINT REPORT DESIGN SYSTEM
           ================================================================ */

        :root {
            --print-navy: #183B6B;
            --print-navy-dark: #102A4A;
            --print-blue: #2563EB;

            --print-green: #15803D;
            --print-green-soft: #EAF8EF;

            --print-orange: #B45309;
            --print-orange-soft: #FFF5E6;

            --print-red: #B42318;
            --print-red-soft: #FFF0EE;

            --print-purple: #6D4FC2;
            --print-purple-soft: #F2EEFF;

            --print-teal: #0F766E;
            --print-teal-soft: #E7F7F5;

            --print-blue-soft: #EAF2FF;

            --print-text: #102A4A;
            --print-body: #40566E;
            --print-muted: #6B7D90;

            --print-border: #D5DFE9;
            --print-border-soft: #E6EDF4;

            --print-background: #EDF2F7;
            --print-white: #FFFFFF;
            --print-surface: #F8FAFC;
        }


        /* ================================================================
           PAGE SETUP
           ================================================================ */

        @page {
            size: A4 landscape;

            margin:
                11mm
                10mm
                12mm
                10mm;
        }


        * {
            box-sizing: border-box;
        }


        html {
            background:
                var(--print-background);
        }


        body {
            margin: 0;

            background:
                var(--print-background);

            color:
                var(--print-text);

            font-family:
                "Segoe UI",
                Arial,
                Helvetica,
                sans-serif;

            font-size: 13px;

            line-height: 1.55;

            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }


        /* ================================================================
           SCREEN TOOLBAR
           ================================================================ */

        .report-toolbar {
            width:
                min(
                    1380px,
                    calc(100% - 40px)
                );

            margin:
                22px
                auto
                16px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;

            padding:
                14px
                16px;

            border:
                1px solid
                var(--print-border);

            border-radius: 14px;

            background:
                var(--print-white);

            box-shadow:
                0 8px 24px
                rgba(16, 42, 74, 0.08);
        }


        .toolbar-copy strong {
            display: block;

            margin-bottom: 2px;

            color:
                var(--print-text);

            font-size: 14px;
            font-weight: 800;
        }


        .toolbar-copy span {
            color:
                var(--print-muted);

            font-size: 12px;
        }


        .toolbar-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 9px;
        }


        .toolbar-button {
            min-height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding:
                0
                15px;

            border-radius: 10px;

            text-decoration: none;

            cursor: pointer;

            font-family: inherit;

            font-size: 12px;
            font-weight: 800;

            transition:
                all 0.2s ease;
        }


        .toolbar-back {
            border:
                1px solid
                var(--print-border);

            background:
                var(--print-white);

            color:
                var(--print-navy);
        }


        .toolbar-back:hover {
            background:
                #F5F8FB;
        }


        .toolbar-print {
            border:
                1px solid
                var(--print-navy);

            background:
                var(--print-navy);

            color:
                var(--print-white);
        }


        .toolbar-print:hover {
            background:
                var(--print-navy-dark);

            transform:
                translateY(-1px);
        }


        /* ================================================================
           REPORT PAPER
           ================================================================ */

        .report-paper {
            width:
                min(
                    1380px,
                    calc(100% - 40px)
                );

            margin:
                0
                auto
                30px;

            overflow: hidden;

            border:
                1px solid
                var(--print-border);

            border-radius: 18px;

            background:
                var(--print-white);

            box-shadow:
                0 18px 44px
                rgba(16, 42, 74, 0.10);
        }


        .report-content {
            padding:
                31px
                34px
                27px;
        }


        /* ================================================================
           DOCUMENT HEADER
           ================================================================ */

        .document-header {
            position: relative;

            overflow: hidden;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 30px;

            padding:
                27px
                31px;

            background:
                linear-gradient(
                    135deg,
                    #102A4A 0%,
                    #183B6B 58%,
                    #245785 100%
                );

            color:
                var(--print-white);
        }


        .document-header::before {
            content: "";

            position: absolute;

            width: 230px;
            height: 230px;

            right: -90px;
            top: -130px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.06);
        }


        .document-header::after {
            content: "";

            position: absolute;

            width: 130px;
            height: 130px;

            right: 190px;
            bottom: -95px;

            border-radius: 50%;

            background:
                rgba(45, 212, 191, 0.07);
        }


        .document-brand {
            position: relative;

            z-index: 2;

            display: flex;
            align-items: center;

            gap: 16px;
        }


        .document-logo {
            width: 61px;
            height: 61px;

            flex-shrink: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border:
                1px solid
                rgba(255, 255, 255, 0.18);

            border-radius: 17px;

            background:
                rgba(255, 255, 255, 0.12);

            color:
                var(--print-white);

            font-size: 17px;
            font-weight: 900;

            letter-spacing: 0.5px;
        }


        .document-system-name {
            margin-bottom: 3px;

            color:
                rgba(255, 255, 255, 0.76);

            font-size: 11px;
            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: 0.75px;
        }


        .document-title {
            margin: 0;

            color:
                var(--print-white);

            font-size: 25px;
            font-weight: 850;

            line-height: 1.22;

            letter-spacing: -0.3px;
        }


        .document-subtitle {
            margin:
                5px
                0
                0;

            color:
                rgba(255, 255, 255, 0.72);

            font-size: 12px;

            line-height: 1.55;
        }


        /* ================================================================
           HEADER META
           ================================================================ */

        .document-meta {
            position: relative;

            z-index: 2;

            min-width: 250px;

            padding:
                14px
                16px;

            border:
                1px solid
                rgba(255, 255, 255, 0.13);

            border-radius: 13px;

            background:
                rgba(255, 255, 255, 0.08);
        }


        .document-meta-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 14px;

            padding:
                5px
                0;
        }


        .document-meta-row
        + .document-meta-row {
            border-top:
                1px solid
                rgba(255, 255, 255, 0.08);
        }


        .document-meta-label {
            color:
                rgba(255, 255, 255, 0.60);

            font-size: 10px;
            font-weight: 700;
        }


        .document-meta-value {
            color:
                var(--print-white);

            text-align: right;

            font-size: 11px;
            font-weight: 800;
        }


        /* ================================================================
           REPORT INTRO
           ================================================================ */

        .report-intro {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 24px;

            margin-bottom: 22px;

            padding-bottom: 20px;

            border-bottom:
                1px solid
                var(--print-border);
        }


        .report-intro-copy {
            max-width: 730px;
        }


        .report-eyebrow {
            margin-bottom: 5px;

            color:
                var(--print-blue);

            font-size: 10px;
            font-weight: 850;

            text-transform: uppercase;

            letter-spacing: 0.7px;
        }


        .report-intro h2 {
            margin:
                0
                0
                6px;

            color:
                var(--print-text);

            font-size: 21px;
            font-weight: 850;

            line-height: 1.3;
        }


        .report-intro p {
            margin: 0;

            color:
                var(--print-body);

            font-size: 12px;

            line-height: 1.65;
        }


        .report-document-code {
            min-width: 170px;

            padding:
                12px
                14px;

            border:
                1px solid
                var(--print-border);

            border-radius: 11px;

            background:
                var(--print-surface);

            text-align: right;
        }


        .document-code-label {
            display: block;

            margin-bottom: 3px;

            color:
                var(--print-muted);

            font-size: 9px;
            font-weight: 800;

            text-transform: uppercase;
        }


        .document-code-value {
            color:
                var(--print-text);

            font-size: 12px;
            font-weight: 900;
        }


        /* ================================================================
           FILTER SUMMARY
           ================================================================ */

        .filter-summary {
            margin-bottom: 22px;

            padding:
                15px
                17px;

            border:
                1px solid
                var(--print-border-soft);

            border-radius: 13px;

            background:
                #F8FAFC;
        }


        .filter-summary-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 11px;
        }


        .filter-summary-title {
            color:
                var(--print-text);

            font-size: 12px;
            font-weight: 850;
        }


        .filter-summary-caption {
            color:
                var(--print-muted);

            font-size: 10px;
        }


        .filter-chips {
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 7px;
        }


        .filter-chip {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding:
                6px
                9px;

            border:
                1px solid
                #D7E3F0;

            border-radius: 999px;

            background:
                var(--print-white);

            color:
                var(--print-body);

            font-size: 10px;
            font-weight: 750;
        }


        .filter-chip strong {
            color:
                var(--print-text);

            font-weight: 850;
        }


        .no-filter-chip {
            color:
                var(--print-muted);
        }


        /* ================================================================
           SUMMARY
           ================================================================ */

        .report-summary-grid {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 12px;

            margin-bottom: 24px;
        }


        .report-summary-card {
            padding:
                15px
                16px;

            border:
                1px solid
                var(--print-border);

            border-radius: 13px;

            background:
                var(--print-white);
        }


        .report-summary-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            margin-bottom: 9px;
        }


        .report-summary-icon {
            width: 33px;
            height: 33px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            font-size: 10px;
            font-weight: 900;
        }


        .icon-blue {
            background:
                var(--print-blue-soft);

            color:
                var(--print-blue);
        }


        .icon-green {
            background:
                var(--print-green-soft);

            color:
                var(--print-green);
        }


        .icon-purple {
            background:
                var(--print-purple-soft);

            color:
                var(--print-purple);
        }


        .icon-teal {
            background:
                var(--print-teal-soft);

            color:
                var(--print-teal);
        }


        .report-summary-value {
            color:
                var(--print-text);

            font-size: 23px;
            font-weight: 900;

            line-height: 1.1;
        }


        .report-summary-label {
            color:
                var(--print-body);

            font-size: 11px;
            font-weight: 800;
        }


        .report-summary-note {
            margin-top: 4px;

            color:
                var(--print-muted);

            font-size: 9px;

            line-height: 1.4;
        }


        /* ================================================================
           SECTION HEADING
           ================================================================ */

        .report-section-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 11px;
        }


        .report-section-heading h3 {
            margin:
                0
                0
                3px;

            color:
                var(--print-text);

            font-size: 15px;
            font-weight: 850;
        }


        .report-section-heading p {
            margin: 0;

            color:
                var(--print-muted);

            font-size: 10px;
        }


        .report-record-count {
            padding:
                6px
                9px;

            border-radius: 999px;

            background:
                #F1F5F9;

            color:
                var(--print-body);

            font-size: 9px;
            font-weight: 800;
        }


        /* ================================================================
           TABLE
           ================================================================ */

        .report-table-wrapper {
            overflow: hidden;

            border:
                1px solid
                var(--print-border);

            border-radius: 12px;
        }


        .report-table {
            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;
        }


        .report-table thead {
            display:
                table-header-group;
        }


        .report-table tfoot {
            display:
                table-footer-group;
        }


        .report-table tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }


        .report-table th {
            padding:
                9px
                7px;

            border-bottom:
                1px solid
                var(--print-border);

            background:
                #EEF3F8;

            color:
                var(--print-text);

            text-align: left;

            font-size: 8px;
            font-weight: 900;

            line-height: 1.35;

            text-transform: uppercase;

            letter-spacing: 0.25px;
        }


        .report-table td {
            padding:
                10px
                7px;

            border-bottom:
                1px solid
                var(--print-border-soft);

            color:
                var(--print-body);

            font-size: 9px;

            line-height: 1.45;

            vertical-align: top;

            overflow-wrap: anywhere;
        }


        .report-table tbody tr:last-child td {
            border-bottom: none;
        }


        .report-table tbody tr:nth-child(even) {
            background:
                #FBFCFE;
        }


        /*
        |--------------------------------------------------------------------------
        | Column Widths
        |--------------------------------------------------------------------------
        */

        .column-student {
            width: 14%;
        }


        .column-company {
            width: 11%;
        }


        .column-supervisor {
            width: 11%;
        }


        .column-period {
            width: 10%;
        }


        .column-hours {
            width: 11%;
        }


        .column-attendance {
            width: 10%;
        }


        .column-worklogs {
            width: 10%;
        }


        .column-evaluation {
            width: 12%;
        }


        .column-status {
            width: 11%;
        }


        /* ================================================================
           TABLE CONTENT
           ================================================================ */

        .table-primary {
            display: block;

            color:
                var(--print-text);

            font-size: 9px;
            font-weight: 850;

            line-height: 1.4;
        }


        .table-secondary {
            display: block;

            margin-top: 2px;

            color:
                var(--print-muted);

            font-size: 8px;

            line-height: 1.4;
        }


        .student-number {
            font-weight: 750;
        }


        /* ================================================================
           HOURS
           ================================================================ */

        .hours-line {
            display: flex;
            align-items: baseline;

            gap: 3px;
        }


        .hours-rendered {
            color:
                var(--print-text);

            font-size: 12px;
            font-weight: 900;
        }


        .hours-required {
            color:
                var(--print-muted);

            font-size: 8px;
            font-weight: 700;
        }


        .hours-progress {
            width: 100%;
            height: 5px;

            margin-top: 5px;

            overflow: hidden;

            border-radius: 999px;

            background:
                #E4EAF1;
        }


        .hours-progress-fill {
            height: 100%;

            border-radius: inherit;

            background:
                linear-gradient(
                    90deg,
                    #2563EB,
                    #0F766E
                );
        }


        .hours-progress-label {
            display: block;

            margin-top: 3px;

            color:
                var(--print-muted);

            font-size: 7.5px;
            font-weight: 750;
        }


        /* ================================================================
           SMALL STATUS ITEMS
           ================================================================ */

        .metric-list {
            display: grid;

            gap: 3px;
        }


        .metric-line {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 5px;
        }


        .metric-name {
            color:
                var(--print-muted);

            font-size: 8px;
        }


        .metric-value {
            color:
                var(--print-text);

            font-size: 8px;
            font-weight: 850;
        }


        /* ================================================================
           STATUS BADGES
           ================================================================ */

        .status-badge {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            padding:
                4px
                7px;

            border-radius: 999px;

            font-size: 8px;
            font-weight: 850;

            line-height: 1.2;
        }


        .status-badge::before {
            content: "";

            width: 5px;
            height: 5px;

            flex-shrink: 0;

            border-radius: 50%;
        }


        .status-active {
            background:
                var(--print-green-soft);

            color:
                var(--print-green);
        }


        .status-active::before {
            background: #22C55E;
        }


        .status-pending {
            background:
                var(--print-orange-soft);

            color:
                var(--print-orange);
        }


        .status-pending::before {
            background: #F59E0B;
        }


        .status-completed {
            background:
                var(--print-blue-soft);

            color:
                var(--print-blue);
        }


        .status-completed::before {
            background: #3B82F6;
        }


        .status-cancelled {
            background:
                var(--print-red-soft);

            color:
                var(--print-red);
        }


        .status-cancelled::before {
            background: #EF4444;
        }


        /* ================================================================
           EVALUATION
           ================================================================ */

        .evaluation-badge {
            display: inline-flex;

            padding:
                4px
                7px;

            border-radius: 7px;

            font-size: 8px;
            font-weight: 850;
        }


        .evaluation-recommended {
            background:
                var(--print-green-soft);

            color:
                var(--print-green);
        }


        .evaluation-improvement {
            background:
                var(--print-orange-soft);

            color:
                var(--print-orange);
        }


        .evaluation-none {
            background:
                #F1F5F9;

            color:
                var(--print-muted);
        }


        /* ================================================================
           EMPTY REPORT
           ================================================================ */

        .empty-report {
            padding:
                50px
                20px;

            text-align: center;
        }


        .empty-report-icon {
            width: 58px;
            height: 58px;

            margin:
                0
                auto
                13px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 17px;

            background:
                var(--print-blue-soft);

            color:
                var(--print-blue);

            font-size: 15px;
            font-weight: 900;
        }


        .empty-report h3 {
            margin:
                0
                0
                5px;

            color:
                var(--print-text);

            font-size: 15px;
            font-weight: 850;
        }


        .empty-report p {
            margin: 0;

            color:
                var(--print-muted);

            font-size: 10px;
        }


        /* ================================================================
           REPORT NOTES
           ================================================================ */

        .report-notes {
            display: grid;

            grid-template-columns:
                minmax(0, 1.4fr)
                minmax(260px, 0.6fr);

            gap: 17px;

            margin-top: 20px;
        }


        .report-note-box {
            padding:
                14px
                16px;

            border:
                1px solid
                var(--print-border);

            border-radius: 12px;

            background:
                var(--print-surface);
        }


        .report-note-title {
            display: block;

            margin-bottom: 5px;

            color:
                var(--print-text);

            font-size: 10px;
            font-weight: 850;
        }


        .report-note-text {
            margin: 0;

            color:
                var(--print-body);

            font-size: 9px;

            line-height: 1.55;
        }


        /* ================================================================
           SIGNATURE / PREPARATION
           ================================================================ */

        .prepared-block {
            padding:
                14px
                16px;

            border:
                1px solid
                var(--print-border);

            border-radius: 12px;

            background:
                var(--print-white);
        }


        .prepared-label {
            display: block;

            margin-bottom: 16px;

            color:
                var(--print-muted);

            font-size: 8px;
            font-weight: 800;

            text-transform: uppercase;
        }


        .prepared-name {
            padding-top: 6px;

            border-top:
                1px solid
                var(--print-text);

            color:
                var(--print-text);

            font-size: 10px;
            font-weight: 850;

            text-align: center;
        }


        .prepared-role {
            display: block;

            margin-top: 2px;

            color:
                var(--print-muted);

            font-size: 8px;

            text-align: center;
        }


        /* ================================================================
           DOCUMENT FOOTER
           ================================================================ */

        .document-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-top: 23px;

            padding-top: 14px;

            border-top:
                1px solid
                var(--print-border);

            color:
                var(--print-muted);

            font-size: 8px;
        }


        .document-footer strong {
            color:
                var(--print-body);
        }


        .footer-right {
            text-align: right;
        }


        /* ================================================================
           PRINT
           ================================================================ */

        @media print {

            html,
            body {
                background:
                    #FFFFFF;
            }


            body {
                font-size: 10pt;
            }


            .no-print {
                display: none !important;
            }


            .report-paper {
                width: 100%;

                margin: 0;

                border: none;

                border-radius: 0;

                box-shadow: none;
            }


            .document-header {
                border-radius: 0;
            }


            .report-content {
                padding:
                    6mm
                    4mm
                    3mm;
            }


            .report-summary-card,
            .filter-summary,
            .report-note-box,
            .prepared-block {
                page-break-inside: avoid;
                break-inside: avoid;
            }


            .report-table-wrapper {
                overflow: visible;
            }


            a {
                color: inherit;
                text-decoration: none;
            }

        }


        /* ================================================================
           RESPONSIVE SCREEN
           ================================================================ */

        @media (max-width: 900px) {

            .document-header,
            .report-intro {
                flex-direction: column;

                align-items: flex-start;
            }


            .document-meta,
            .report-document-code {
                width: 100%;

                min-width: 0;
            }


            .report-summary-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }


            .report-notes {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 600px) {

            .report-toolbar {
                flex-direction: column;

                align-items: stretch;
            }


            .toolbar-actions {
                width: 100%;
            }


            .toolbar-button {
                flex: 1;
            }


            .report-paper,
            .report-toolbar {
                width:
                    calc(100% - 20px);
            }


            .document-header {
                padding:
                    24px
                    20px;
            }


            .report-content {
                padding:
                    24px
                    20px;
            }


            .report-summary-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


@php

    /*
    |--------------------------------------------------------------------------
    | Report Collection
    |--------------------------------------------------------------------------
    |
    | Supports either a normal Collection or a Laravel paginator.
    |
    */

    $reportAssignments =
        $assignments ?? collect();


    $reportRows =
        method_exists(
            $reportAssignments,
            'getCollection'
        )
            ? $reportAssignments->getCollection()
            : collect($reportAssignments);


    /*
    |--------------------------------------------------------------------------
    | Generated Information
    |--------------------------------------------------------------------------
    */

    $generatedAt =
        now()
            ->timezone('Asia/Manila');


    $generatedBy =
        auth()->user()?->name
        ?? 'OJT Sync Administrator';


    /*
    |--------------------------------------------------------------------------
    | Report Statistics
    |--------------------------------------------------------------------------
    */

    $totalAssignments =
        method_exists(
            $reportAssignments,
            'total'
        )
            ? $reportAssignments->total()
            : $reportRows->count();


    $activeAssignments =
        $reportRows
            ->filter(
                fn ($assignment) =>
                    (string) $assignment->status
                    === \App\Models\OjtAssignment::STATUS_ACTIVE
            )
            ->count();


    $completedAssignments =
        $reportRows
            ->filter(
                fn ($assignment) =>
                    (string) $assignment->status
                    === \App\Models\OjtAssignment::STATUS_COMPLETED
            )
            ->count();


    $validatedMinutes =
        $reportRows
            ->sum(
                function ($assignment) {

                    return collect(
                        $assignment->attendanceRecords
                        ?? []
                    )
                        ->filter(
                            fn ($attendance) =>
                                strtolower(
                                    (string) $attendance->status
                                ) === 'validated'
                        )
                        ->sum(
                            fn ($attendance) =>
                                (int) (
                                    $attendance->rendered_minutes
                                    ?? 0
                                )
                        );

                }
            );


    $validatedHours =
        $validatedMinutes / 60;


    /*
    |--------------------------------------------------------------------------
    | Date Formatter
    |--------------------------------------------------------------------------
    */

    $formatDate =
        function ($value) {

            if (! $value) {
                return '—';
            }


            try {

                return \Illuminate\Support\Carbon::parse(
                    $value
                )->format('M d, Y');

            } catch (\Throwable $exception) {

                return (string) $value;

            }

        };


    /*
    |--------------------------------------------------------------------------
    | Search / Filter Values
    |--------------------------------------------------------------------------
    */

    $search =
        trim(
            (string) request('search')
        );


    $statusFilter =
        trim(
            (string) request('status')
        );


    $companyFilter =
        trim(
            (string) request('company_id')
        );


    $supervisorFilter =
        trim(
            (string) request('supervisor_id')
        );


    $dateFrom =
        trim(
            (string) request('date_from')
        );


    $dateTo =
        trim(
            (string) request('date_to')
        );


    /*
    |--------------------------------------------------------------------------
    | Filter Labels
    |--------------------------------------------------------------------------
    */

    $companyFilterName =
        null;


    if ($companyFilter !== '') {

        $companyFilterName =
            optional(
                $reportRows
                    ->firstWhere(
                        'company_id',
                        $companyFilter
                    )
            )
                ->company
                ?->name;

    }


    $supervisorFilterName =
        null;


    if ($supervisorFilter !== '') {

        $supervisorFilterName =
            optional(
                $reportRows
                    ->firstWhere(
                        'supervisor_id',
                        $supervisorFilter
                    )
            )
                ->supervisor
                ?->name;

    }


    /*
    |--------------------------------------------------------------------------
    | Report Number
    |--------------------------------------------------------------------------
    */

    $reportNumber =
        'OJT-REP-'
        . $generatedAt->format('Ymd-His');

@endphp


{{-- ========================================================================
     SCREEN TOOLBAR
     ======================================================================== --}}

<div class="report-toolbar no-print">


    <div class="toolbar-copy">


        <strong>
            Print Preview
        </strong>


        <span>

            Review the report below before printing
            or saving it as a PDF.

        </span>


    </div>


    <div class="toolbar-actions">


        <a
            href="{{ route(
                'admin.reports.index',
                request()->query()
            ) }}"
            class="
                toolbar-button
                toolbar-back
            "
        >
            ← Back to Reports
        </a>


        <button
            type="button"
            class="
                toolbar-button
                toolbar-print
            "
            onclick="window.print()"
        >
            Print / Save as PDF
        </button>


    </div>


</div>


{{-- ========================================================================
     REPORT PAPER
     ======================================================================== --}}

<main class="report-paper">


    {{-- ==================================================================
         DOCUMENT HEADER
         ================================================================== --}}

    <header class="document-header">


        <div class="document-brand">


            <div class="document-logo">
                OJT
            </div>


            <div>


                <div class="document-system-name">
                    OJT Sync
                </div>


                <h1 class="document-title">
                    Student OJT Monitoring Report
                </h1>


                <p class="document-subtitle">

                    Timesheet, Attendance, Daily Work Log,
                    Evaluation and Completion Summary

                </p>


            </div>


        </div>


        <div class="document-meta">


            <div class="document-meta-row">


                <span class="document-meta-label">
                    Generated
                </span>


                <span class="document-meta-value">

                    {{ $generatedAt->format(
                        'M d, Y h:i A'
                    ) }}

                </span>


            </div>


            <div class="document-meta-row">


                <span class="document-meta-label">
                    Prepared By
                </span>


                <span class="document-meta-value">

                    {{ $generatedBy }}

                </span>


            </div>


            <div class="document-meta-row">


                <span class="document-meta-label">
                    Report Records
                </span>


                <span class="document-meta-value">

                    {{ number_format(
                        $totalAssignments
                    ) }}

                </span>


            </div>


        </div>


    </header>


    <div class="report-content">


        {{-- ==============================================================
             INTRO
             ============================================================== --}}

        <section class="report-intro">


            <div class="report-intro-copy">


                <div class="report-eyebrow">
                    Administrative Report
                </div>


                <h2>
                    OJT Placement Monitoring Summary
                </h2>


                <p>

                    This report provides a consolidated overview
                    of Student OJT placements, assigned companies
                    and Supervisors, required training hours,
                    validated rendered hours, attendance records,
                    Daily Work Logs, final evaluation and formal
                    assignment status.

                </p>


            </div>


            <div class="report-document-code">


                <span class="document-code-label">
                    Report Reference
                </span>


                <span class="document-code-value">

                    {{ $reportNumber }}

                </span>


            </div>


        </section>


        {{-- ==============================================================
             FILTER SUMMARY
             ============================================================== --}}

        <section class="filter-summary">


            <div class="filter-summary-header">


                <span class="filter-summary-title">
                    Report Scope & Filters
                </span>


                <span class="filter-summary-caption">

                    Filters applied when this report was generated

                </span>


            </div>


            <div class="filter-chips">


                @if ($search !== '')


                    <span class="filter-chip">

                        Search:

                        <strong>
                            {{ $search }}
                        </strong>

                    </span>


                @endif


                @if ($statusFilter !== '')


                    <span class="filter-chip">

                        Status:

                        <strong>

                            {{ ucfirst(
                                $statusFilter
                            ) }}

                        </strong>

                    </span>


                @endif


                @if ($companyFilter !== '')


                    <span class="filter-chip">

                        Company:

                        <strong>

                            {{ $companyFilterName
                                ?: 'Company #' . $companyFilter
                            }}

                        </strong>

                    </span>


                @endif


                @if ($supervisorFilter !== '')


                    <span class="filter-chip">

                        Supervisor:

                        <strong>

                            {{ $supervisorFilterName
                                ?: 'Supervisor #' . $supervisorFilter
                            }}

                        </strong>

                    </span>


                @endif


                @if ($dateFrom !== '')


                    <span class="filter-chip">

                        From:

                        <strong>

                            {{ $formatDate(
                                $dateFrom
                            ) }}

                        </strong>

                    </span>


                @endif


                @if ($dateTo !== '')


                    <span class="filter-chip">

                        To:

                        <strong>

                            {{ $formatDate(
                                $dateTo
                            ) }}

                        </strong>

                    </span>


                @endif


                @if (
                    $search === ''
                    &&
                    $statusFilter === ''
                    &&
                    $companyFilter === ''
                    &&
                    $supervisorFilter === ''
                    &&
                    $dateFrom === ''
                    &&
                    $dateTo === ''
                )


                    <span
                        class="
                            filter-chip
                            no-filter-chip
                        "
                    >
                        No additional filters applied
                    </span>


                @endif


            </div>


        </section>


        {{-- ==============================================================
             SUMMARY
             ============================================================== --}}

        <section class="report-summary-grid">


            <article class="report-summary-card">


                <div class="report-summary-card-top">


                    <div class="report-summary-icon icon-blue">
                        OJ
                    </div>


                    <div class="report-summary-value">

                        {{ number_format(
                            $totalAssignments
                        ) }}

                    </div>


                </div>


                <div class="report-summary-label">
                    OJT Assignments
                </div>


                <div class="report-summary-note">
                    Placement records included in this report
                </div>


            </article>


            <article class="report-summary-card">


                <div class="report-summary-card-top">


                    <div class="report-summary-icon icon-green">
                        AC
                    </div>


                    <div class="report-summary-value">

                        {{ number_format(
                            $activeAssignments
                        ) }}

                    </div>


                </div>


                <div class="report-summary-label">
                    Active Placements
                </div>


                <div class="report-summary-note">
                    Active assignments represented by these rows
                </div>


            </article>


            <article class="report-summary-card">


                <div class="report-summary-card-top">


                    <div class="report-summary-icon icon-purple">
                        ✓
                    </div>


                    <div class="report-summary-value">

                        {{ number_format(
                            $completedAssignments
                        ) }}

                    </div>


                </div>


                <div class="report-summary-label">
                    Completed Placements
                </div>


                <div class="report-summary-note">
                    Formally completed assignments in this result
                </div>


            </article>


            <article class="report-summary-card">


                <div class="report-summary-card-top">


                    <div class="report-summary-icon icon-teal">
                        HR
                    </div>


                    <div class="report-summary-value">

                        {{ number_format(
                            $validatedHours,
                            1
                        ) }}

                    </div>


                </div>


                <div class="report-summary-label">
                    Validated Hours
                </div>


                <div class="report-summary-note">
                    Rendered time from validated attendance records
                </div>


            </article>


        </section>


        {{-- ==============================================================
             REPORT TABLE HEADING
             ============================================================== --}}

        <div class="report-section-heading">


            <div>


                <h3>
                    Detailed OJT Placement Records
                </h3>


                <p>

                    Student-level OJT monitoring and completion overview

                </p>


            </div>


            <span class="report-record-count">

                {{ number_format(
                    $totalAssignments
                ) }}

                record{{ $totalAssignments === 1 ? '' : 's' }}

            </span>


        </div>


        {{-- ==============================================================
             REPORT TABLE
             ============================================================== --}}

        @if ($reportRows->isNotEmpty())


            <div class="report-table-wrapper">


                <table class="report-table">


                    <thead>


                        <tr>


                            <th class="column-student">
                                Student
                            </th>


                            <th class="column-company">
                                Company
                            </th>


                            <th class="column-supervisor">
                                Supervisor
                            </th>


                            <th class="column-period">
                                Placement
                            </th>


                            <th class="column-hours">
                                Rendered Hours
                            </th>


                            <th class="column-attendance">
                                Attendance
                            </th>


                            <th class="column-worklogs">
                                Work Logs
                            </th>


                            <th class="column-evaluation">
                                Final Evaluation
                            </th>


                            <th class="column-status">
                                Assignment Status
                            </th>


                        </tr>


                    </thead>


                    <tbody>


                        @foreach ($reportRows as $assignment)


                            @php

                                /*
                                |--------------------------------------------------------------------------
                                | Student
                                |--------------------------------------------------------------------------
                                */

                                $studentProfile =
                                    $assignment->studentProfile;


                                $studentUser =
                                    $studentProfile?->user;


                                $studentName =
                                    $studentUser?->name
                                    ?? 'Student unavailable';


                                /*
                                |--------------------------------------------------------------------------
                                | Attendance
                                |--------------------------------------------------------------------------
                                */

                                $attendanceRecords =
                                    collect(
                                        $assignment->attendanceRecords
                                        ?? []
                                    );


                                $validatedAttendanceRecords =
                                    $attendanceRecords
                                        ->filter(
                                            fn ($attendance) =>
                                                strtolower(
                                                    (string) $attendance->status
                                                ) === 'validated'
                                        );


                                $pendingAttendanceRecords =
                                    $attendanceRecords
                                        ->filter(
                                            fn ($attendance) =>
                                                strtolower(
                                                    (string) $attendance->status
                                                ) === 'pending'
                                        )
                                        ->count();


                                $rejectedAttendanceRecords =
                                    $attendanceRecords
                                        ->filter(
                                            fn ($attendance) =>
                                                strtolower(
                                                    (string) $attendance->status
                                                ) === 'rejected'
                                        )
                                        ->count();


                                $assignmentValidatedMinutes =
                                    (int) $validatedAttendanceRecords
                                        ->sum(
                                            fn ($attendance) =>
                                                (int) (
                                                    $attendance->rendered_minutes
                                                    ?? 0
                                                )
                                        );


                                $assignmentRenderedHours =
                                    $assignmentValidatedMinutes
                                    / 60;


                                /*
                                |--------------------------------------------------------------------------
                                | Hours Progress
                                |--------------------------------------------------------------------------
                                */

                                $requiredHours =
                                    (float) $assignment->required_hours;


                                $requiredMinutes =
                                    (int) round(
                                        $requiredHours
                                        * 60
                                    );


                                $progress =
                                    $requiredMinutes > 0
                                        ? min(
                                            100,
                                            (int) round(
                                                (
                                                    $assignmentValidatedMinutes
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
                                        $assignment->dailyWorkLogs
                                        ?? []
                                    );


                                $validatedWorkLogs =
                                    $workLogs
                                        ->filter(
                                            fn ($workLog) =>
                                                strtolower(
                                                    (string) $workLog->status
                                                ) === 'validated'
                                        )
                                        ->count();


                                $pendingWorkLogs =
                                    $workLogs
                                        ->filter(
                                            fn ($workLog) =>
                                                strtolower(
                                                    (string) $workLog->status
                                                ) === 'pending'
                                        )
                                        ->count();


                                $rejectedWorkLogs =
                                    $workLogs
                                        ->filter(
                                            fn ($workLog) =>
                                                strtolower(
                                                    (string) $workLog->status
                                                ) === 'rejected'
                                        )
                                        ->count();


                                /*
                                |--------------------------------------------------------------------------
                                | Evaluation
                                |--------------------------------------------------------------------------
                                */

                                $evaluation =
                                    $assignment->finalEvaluation;


                                $recommendation =
                                    $evaluation
                                        ? strtolower(
                                            (string) $evaluation->recommendation
                                        )
                                        : null;


                                /*
                                |--------------------------------------------------------------------------
                                | Assignment Status
                                |--------------------------------------------------------------------------
                                */

                                $assignmentStatus =
                                    (string) $assignment->status;

                            @endphp


                            <tr>


                                {{-- ==========================================
                                     STUDENT
                                     ========================================== --}}

                                <td>


                                    <span class="table-primary">

                                        {{ $studentName }}

                                    </span>


                                    <span
                                        class="
                                            table-secondary
                                            student-number
                                        "
                                    >

                                        {{ $studentProfile?->student_number
                                            ?: 'No student number'
                                        }}

                                    </span>


                                    @if (filled($studentProfile?->program))


                                        <span class="table-secondary">

                                            {{ $studentProfile->program }}

                                            @if (filled($studentProfile?->year_level))

                                                ·
                                                {{ $studentProfile->year_level }}

                                            @endif

                                        </span>


                                    @endif


                                </td>


                                {{-- ==========================================
                                     COMPANY
                                     ========================================== --}}

                                <td>


                                    <span class="table-primary">

                                        {{ $assignment
                                            ->company
                                            ?->name
                                            ?? 'Company unavailable'
                                        }}

                                    </span>


                                    @if (
                                        filled(
                                            $assignment
                                                ->company
                                                ?->address
                                        )
                                    )


                                        <span class="table-secondary">

                                            {{ \Illuminate\Support\Str::limit(
                                                $assignment
                                                    ->company
                                                    ->address,
                                                60
                                            ) }}

                                        </span>


                                    @endif


                                </td>


                                {{-- ==========================================
                                     SUPERVISOR
                                     ========================================== --}}

                                <td>


                                    <span class="table-primary">

                                        {{ $assignment
                                            ->supervisor
                                            ?->name
                                            ?? 'Supervisor unavailable'
                                        }}

                                    </span>


                                    <span class="table-secondary">

                                        {{ $assignment
                                            ->supervisor
                                            ?->email
                                            ?? 'No email available'
                                        }}

                                    </span>


                                </td>


                                {{-- ==========================================
                                     PERIOD
                                     ========================================== --}}

                                <td>


                                    <span class="table-primary">

                                        {{ $formatDate(
                                            $assignment->start_date
                                        ) }}

                                    </span>


                                    <span class="table-secondary">
                                        to
                                    </span>


                                    <span class="table-primary">

                                        {{ $formatDate(
                                            $assignment->end_date
                                        ) }}

                                    </span>


                                </td>


                                {{-- ==========================================
                                     HOURS
                                     ========================================== --}}

                                <td>


                                    <div class="hours-line">


                                        <span class="hours-rendered">

                                            {{ number_format(
                                                $assignmentRenderedHours,
                                                1
                                            ) }}

                                        </span>


                                        <span class="hours-required">

                                            /

                                            {{ number_format(
                                                $requiredHours
                                            ) }}

                                            hrs

                                        </span>


                                    </div>


                                    <div class="hours-progress">


                                        <div
                                            class="hours-progress-fill"
                                            style="width: {{ $progress }}%;"
                                        ></div>


                                    </div>


                                    <span class="hours-progress-label">

                                        {{ $progress }}%
                                        completed

                                    </span>


                                </td>


                                {{-- ==========================================
                                     ATTENDANCE
                                     ========================================== --}}

                                <td>


                                    <div class="metric-list">


                                        <div class="metric-line">


                                            <span class="metric-name">
                                                Total
                                            </span>


                                            <span class="metric-value">

                                                {{ $attendanceRecords->count() }}

                                            </span>


                                        </div>


                                        <div class="metric-line">


                                            <span class="metric-name">
                                                Validated
                                            </span>


                                            <span class="metric-value">

                                                {{ $validatedAttendanceRecords->count() }}

                                            </span>


                                        </div>


                                        <div class="metric-line">


                                            <span class="metric-name">
                                                Pending
                                            </span>


                                            <span class="metric-value">

                                                {{ $pendingAttendanceRecords }}

                                            </span>


                                        </div>


                                        @if ($rejectedAttendanceRecords > 0)


                                            <div class="metric-line">


                                                <span class="metric-name">
                                                    Rejected
                                                </span>


                                                <span class="metric-value">

                                                    {{ $rejectedAttendanceRecords }}

                                                </span>


                                            </div>


                                        @endif


                                    </div>


                                </td>


                                {{-- ==========================================
                                     WORK LOGS
                                     ========================================== --}}

                                <td>


                                    <div class="metric-list">


                                        <div class="metric-line">


                                            <span class="metric-name">
                                                Total
                                            </span>


                                            <span class="metric-value">

                                                {{ $workLogs->count() }}

                                            </span>


                                        </div>


                                        <div class="metric-line">


                                            <span class="metric-name">
                                                Validated
                                            </span>


                                            <span class="metric-value">

                                                {{ $validatedWorkLogs }}

                                            </span>


                                        </div>


                                        <div class="metric-line">


                                            <span class="metric-name">
                                                Pending
                                            </span>


                                            <span class="metric-value">

                                                {{ $pendingWorkLogs }}

                                            </span>


                                        </div>


                                        @if ($rejectedWorkLogs > 0)


                                            <div class="metric-line">


                                                <span class="metric-name">
                                                    Rejected
                                                </span>


                                                <span class="metric-value">

                                                    {{ $rejectedWorkLogs }}

                                                </span>


                                            </div>


                                        @endif


                                    </div>


                                </td>


                                {{-- ==========================================
                                     EVALUATION
                                     ========================================== --}}

                                <td>


                                    @if (
                                        $recommendation
                                        === 'recommended'
                                    )


                                        <span
                                            class="
                                                evaluation-badge
                                                evaluation-recommended
                                            "
                                        >
                                            Recommended
                                        </span>


                                    @elseif ($recommendation)


                                        <span
                                            class="
                                                evaluation-badge
                                                evaluation-improvement
                                            "
                                        >

                                            {{ ucwords(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $recommendation
                                                )
                                            ) }}

                                        </span>


                                    @else


                                        <span
                                            class="
                                                evaluation-badge
                                                evaluation-none
                                            "
                                        >
                                            Not Submitted
                                        </span>


                                    @endif


                                    @if (
                                        $evaluation
                                        &&
                                        $evaluation->evaluated_at
                                    )


                                        <span class="table-secondary">

                                            {{ $formatDate(
                                                $evaluation->evaluated_at
                                            ) }}

                                        </span>


                                    @endif


                                </td>


                                {{-- ==========================================
                                     STATUS
                                     ========================================== --}}

                                <td>


                                    @if (
                                        $assignmentStatus
                                        ===
                                        \App\Models\OjtAssignment::STATUS_ACTIVE
                                    )


                                        <span
                                            class="
                                                status-badge
                                                status-active
                                            "
                                        >
                                            Active
                                        </span>


                                    @elseif (
                                        $assignmentStatus
                                        ===
                                        \App\Models\OjtAssignment::STATUS_PENDING
                                    )


                                        <span
                                            class="
                                                status-badge
                                                status-pending
                                            "
                                        >
                                            Pending
                                        </span>


                                    @elseif (
                                        $assignmentStatus
                                        ===
                                        \App\Models\OjtAssignment::STATUS_COMPLETED
                                    )


                                        <span
                                            class="
                                                status-badge
                                                status-completed
                                            "
                                        >
                                            Completed
                                        </span>


                                        @if ($assignment->completed_at)


                                            <span class="table-secondary">

                                                {{ $formatDate(
                                                    $assignment->completed_at
                                                ) }}

                                            </span>


                                        @endif


                                    @else


                                        <span
                                            class="
                                                status-badge
                                                status-cancelled
                                            "
                                        >

                                            {{ ucfirst(
                                                $assignmentStatus
                                                ?: 'Cancelled'
                                            ) }}

                                        </span>


                                    @endif


                                </td>


                            </tr>


                        @endforeach


                    </tbody>


                </table>


            </div>


        @else


            <div class="empty-report">


                <div class="empty-report-icon">
                    RP
                </div>


                <h3>
                    No report records found
                </h3>


                <p>

                    No OJT Assignment records match
                    the selected report criteria.

                </p>


            </div>


        @endif


        {{-- ==============================================================
             NOTES / PREPARED BY
             ============================================================== --}}

        <section class="report-notes">


            <div class="report-note-box">


                <span class="report-note-title">
                    Report Interpretation
                </span>


                <p class="report-note-text">

                    Validated rendered hours are calculated
                    from attendance records whose validation
                    status is <strong>Validated</strong>.
                    Pending or rejected attendance is not
                    included in the validated-hour total.
                    Completion status shown in this report
                    reflects the stored OJT Assignment lifecycle;
                    formal completion remains governed by
                    the system's server-side completion rules.

                </p>


            </div>


            <div class="prepared-block">


                <span class="prepared-label">
                    Prepared / Generated By
                </span>


                <div class="prepared-name">

                    {{ $generatedBy }}

                </div>


                <span class="prepared-role">

                    OJT Sync Administrator

                </span>


            </div>


        </section>


        {{-- ==============================================================
             FOOTER
             ============================================================== --}}

        <footer class="document-footer">


            <div>

                <strong>
                    OJT Sync
                </strong>

                · OJT Monitoring and Reporting System

            </div>


            <div class="footer-right">

                Generated

                {{ $generatedAt->format(
                    'F d, Y · h:i A'
                ) }}

                ·

                {{ $reportNumber }}

            </div>


        </footer>


    </div>


</main>


</body>

</html>