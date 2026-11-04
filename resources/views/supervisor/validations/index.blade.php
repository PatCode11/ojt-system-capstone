@extends('layouts.app')

@section('title', 'Attendance Validation | OJT Sync')

@php
    /*
    |--------------------------------------------------------------------------
    | Display Helpers
    |--------------------------------------------------------------------------
    */

    $formatDate = function ($value): string {
        if (! $value) {
            return '—';
        }

        try {
            return \Carbon\Carbon::parse($value)
                ->timezone('Asia/Manila')
                ->format('F d, Y');
        } catch (\Throwable $exception) {
            return '—';
        }
    };

    $formatTime = function ($value): string {
        if (! $value) {
            return '—';
        }

        try {
            return \Carbon\Carbon::parse($value)
                ->timezone('Asia/Manila')
                ->format('g:i A');
        } catch (\Throwable $exception) {
            return '—';
        }
    };

    $formatDateTime = function ($value): string {
        if (! $value) {
            return '—';
        }

        try {
            return \Carbon\Carbon::parse($value)
                ->timezone('Asia/Manila')
                ->format('M d, Y · g:i A');
        } catch (\Throwable $exception) {
            return '—';
        }
    };

    $formatMinutes = function ($minutes): string {
        $minutes = max(
            0,
            (int) $minutes
        );

        $hours = intdiv(
            $minutes,
            60
        );

        $remainingMinutes =
            $minutes % 60;

        if (
            $hours > 0
            && $remainingMinutes > 0
        ) {
            return $hours
                .' hr'
                .($hours !== 1 ? 's' : '')
                .' '
                .$remainingMinutes
                .' min';
        }

        if ($hours > 0) {
            return $hours
                .' hr'
                .($hours !== 1 ? 's' : '');
        }

        return $remainingMinutes
            .' min';
    };

    $statusLabel = function (?string $status): string {
        return match ($status) {
            \App\Models\AttendanceRecord::STATUS_IN_PROGRESS =>
                'In Progress',

            \App\Models\AttendanceRecord::STATUS_PENDING =>
                'Pending Review',

            \App\Models\AttendanceRecord::STATUS_VALIDATED =>
                'Validated',

            \App\Models\AttendanceRecord::STATUS_REJECTED =>
                'Rejected',

            default =>
                'Unknown',
        };
    };

    $statusClass = function (?string $status): string {
        return match ($status) {
            \App\Models\AttendanceRecord::STATUS_IN_PROGRESS =>
                'status-progress',

            \App\Models\AttendanceRecord::STATUS_PENDING =>
                'status-pending',

            \App\Models\AttendanceRecord::STATUS_VALIDATED =>
                'status-validated',

            \App\Models\AttendanceRecord::STATUS_REJECTED =>
                'status-rejected',

            default =>
                'status-neutral',
        };
    };

    $initials = function (?string $name): string {
        $name = trim(
            (string) $name
        );

        if ($name === '') {
            return 'ST';
        }

        $parts = preg_split(
            '/\s+/',
            $name
        );

        $first =
            $parts[0]
            ?? '';

        $last =
            count($parts) > 1
                ? $parts[count($parts) - 1]
                : '';

        $result =
            mb_strtoupper(
                mb_substr(
                    $first,
                    0,
                    1
                )
                .
                mb_substr(
                    $last,
                    0,
                    1
                )
            );

        return $result !== ''
            ? $result
            : 'ST';
    };

    $totalRecords =
        $attendanceRecords->count();

    $inProgressCount =
        $inProgressRecords->count();

    $pendingCount =
        $pendingRecords->count();

    $validatedCount =
        $validatedRecords->count();

    $rejectedCount =
        $rejectedRecords->count();
@endphp


@push('styles')

<style>
    /*
    |--------------------------------------------------------------------------
    | OJT Sync Supervisor Validation
    |--------------------------------------------------------------------------
    */

    .sv-page {
        --navy-950: #07192D;
        --navy-900: #0B223D;
        --navy-850: #0D2745;
        --navy-800: #102A4A;
        --navy-700: #183B6B;

        --blue-700: #1D4ED8;
        --blue-600: #2563EB;
        --blue-500: #3B82F6;
        --blue-100: #DBEAFE;
        --blue-50: #EFF6FF;

        --teal-800: #115E59;
        --teal-700: #0F766E;
        --teal-600: #0D9488;
        --teal-100: #CCFBF1;
        --teal-50: #F0FDFA;

        --green-800: #166534;
        --green-700: #15803D;
        --green-100: #DCFCE7;
        --green-50: #F0FDF4;

        --orange-800: #9A3412;
        --orange-700: #C2410C;
        --orange-100: #FFEDD5;
        --orange-50: #FFF7ED;

        --red-800: #991B1B;
        --red-700: #B91C1C;
        --red-100: #FEE2E2;
        --red-50: #FEF2F2;

        --purple-700: #6D28D9;
        --purple-100: #EDE9FE;
        --purple-50: #F5F3FF;

        --slate-950: #020617;
        --slate-900: #0F172A;
        --slate-800: #1E293B;
        --slate-700: #334155;
        --slate-600: #475569;
        --slate-500: #64748B;
        --slate-400: #94A3B8;
        --slate-300: #CBD5E1;
        --slate-200: #E2E8F0;
        --slate-100: #F1F5F9;
        --slate-50: #F8FAFC;

        --white: #FFFFFF;

        width: 100%;
        max-width: 1540px;

        margin: 0 auto;
        padding: 8px 0 64px;

        color: var(--slate-800);

        font-family:
            "Segoe UI",
            Inter,
            Arial,
            sans-serif;

        font-size: 17px;
        line-height: 1.65;
    }

    .sv-page *,
    .sv-page *::before,
    .sv-page *::after {
        box-sizing: border-box;
    }

    .sv-page button,
    .sv-page input,
    .sv-page select,
    .sv-page a {
        font-family: inherit;
    }


    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    .sv-page a:focus-visible,
    .sv-page button:focus-visible,
    .sv-page input:focus-visible,
    .sv-page select:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .30);
        outline-offset: 3px;
    }


    /*
    |--------------------------------------------------------------------------
    | Flash Messages
    |--------------------------------------------------------------------------
    */

    .sv-alert {
        display: flex;
        align-items: flex-start;

        gap: 14px;

        margin-bottom: 22px;
        padding: 17px 19px;

        border: 1px solid transparent;
        border-radius: 16px;

        font-size: 15px;
        font-weight: 700;

        box-shadow:
            0 6px 18px
            rgba(15, 23, 42, .04);
    }

    .sv-alert-success {
        color: var(--green-800);

        border-color: #BBF7D0;

        background: var(--green-50);
    }

    .sv-alert-error {
        color: var(--red-800);

        border-color: #FECACA;

        background: var(--red-50);
    }

    .sv-alert-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 29px;
        height: 29px;

        flex: 0 0 29px;

        border-radius: 9px;

        color: #FFFFFF;
        background: currentColor;

        font-size: 12px;
        font-weight: 900;
    }


    /*
    |--------------------------------------------------------------------------
    | Hero
    |--------------------------------------------------------------------------
    */

    .sv-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 25px;
        padding: 38px 40px;

        border-radius: 26px;

        color: #FFFFFF;

        background:
            radial-gradient(
                circle at 90% 10%,
                rgba(45, 212, 191, .23),
                transparent 27%
            ),
            radial-gradient(
                circle at 73% 100%,
                rgba(96, 165, 250, .14),
                transparent 33%
            ),
            linear-gradient(
                135deg,
                #0B223D 0%,
                #183B6B 57%,
                #17656B 115%
            );

        box-shadow:
            0 22px 50px
            rgba(11, 34, 61, .17);
    }

    .sv-hero::before {
        content: '';

        position: absolute;

        width: 330px;
        height: 330px;

        top: -185px;
        right: -90px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, .06);
    }

    .sv-hero-inner {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 34px;
    }

    .sv-hero-copy {
        max-width: 820px;
        min-width: 0;
    }

    .sv-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 14px;
        padding: 8px 13px;

        border:
            1px solid
            rgba(255, 255, 255, .16);

        border-radius: 999px;

        background:
            rgba(255, 255, 255, .09);

        color:
            rgba(255, 255, 255, .94);

        font-size: 13px;
        font-weight: 850;

        letter-spacing: .045em;
        text-transform: uppercase;
    }

    .sv-eyebrow-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background: #5EEAD4;

        box-shadow:
            0 0 0 5px
            rgba(94, 234, 212, .12);
    }

    .sv-hero h1 {
        margin: 0;

        color: #FFFFFF;

        font-size:
            clamp(
                32px,
                4vw,
                44px
            );

        line-height: 1.12;
        font-weight: 900;

        letter-spacing: -.04em;
    }

    .sv-hero-description {
        max-width: 800px;

        margin: 15px 0 0;

        color:
            rgba(255, 255, 255, .84);

        font-size: 17px;
        line-height: 1.75;
    }


    /*
    |--------------------------------------------------------------------------
    | Hero Queue
    |--------------------------------------------------------------------------
    */

    .sv-queue {
        width: 290px;
        flex: 0 0 290px;

        padding: 22px;

        border:
            1px solid
            rgba(255, 255, 255, .16);

        border-radius: 19px;

        background:
            rgba(255, 255, 255, .10);

        backdrop-filter:
            blur(8px);
    }

    .sv-queue-label {
        display: block;

        margin-bottom: 5px;

        color:
            rgba(255, 255, 255, .68);

        font-size: 12px;
        font-weight: 850;

        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .sv-queue-value {
        display: block;

        color: #FFFFFF;

        font-size: 42px;
        line-height: 1.05;
        font-weight: 900;
    }

    .sv-queue-description {
        display: block;

        margin-top: 8px;

        color:
            rgba(255, 255, 255, .82);

        font-size: 14px;
        line-height: 1.55;
    }

    .sv-queue-footer {
        margin-top: 16px;
        padding-top: 14px;

        border-top:
            1px solid
            rgba(255, 255, 255, .13);

        color:
            rgba(255, 255, 255, .76);

        font-size: 13px;
        font-weight: 700;
    }


    /*
    |--------------------------------------------------------------------------
    | Review Notice
    |--------------------------------------------------------------------------
    */

    .sv-notice {
        display: flex;
        align-items: flex-start;

        gap: 15px;

        margin-bottom: 25px;
        padding: 19px 21px;

        border: 1px solid #BFDCD6;
        border-radius: 17px;

        background:
            linear-gradient(
                135deg,
                #F8FCFB,
                #F0FAF7
            );

        box-shadow:
            0 7px 23px
            rgba(15, 42, 74, .04);
    }

    .sv-notice-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 47px;
        height: 47px;

        flex: 0 0 47px;

        border-radius: 14px;

        color: var(--teal-800);
        background: var(--teal-100);

        font-size: 14px;
        font-weight: 900;
    }

    .sv-notice strong {
        display: block;

        margin-bottom: 4px;

        color: var(--navy-800);

        font-size: 17px;
        line-height: 1.45;
        font-weight: 850;
    }

    .sv-notice p {
        margin: 0;

        color: var(--slate-600);

        font-size: 15px;
        line-height: 1.65;
    }


    /*
    |--------------------------------------------------------------------------
    | Summary
    |--------------------------------------------------------------------------
    */

    .sv-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 18px;

        margin-bottom: 26px;
    }

    .sv-summary-card {
        position: relative;

        overflow: hidden;

        padding: 23px;

        border: 1px solid var(--slate-200);
        border-radius: 20px;

        background: #FFFFFF;

        box-shadow:
            0 8px 26px
            rgba(15, 42, 74, .05);

        transition:
            transform .18s ease,
            box-shadow .18s ease,
            border-color .18s ease;
    }

    .sv-summary-card:hover {
        transform: translateY(-2px);

        border-color: #CBD9E8;

        box-shadow:
            0 14px 32px
            rgba(15, 42, 74, .08);
    }

    .sv-summary-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 14px;

        margin-bottom: 17px;
    }

    .sv-summary-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 52px;
        height: 52px;

        flex: 0 0 52px;

        border-radius: 15px;

        font-size: 13px;
        font-weight: 900;
    }

    .sv-icon-orange {
        color: var(--orange-700);
        background: var(--orange-100);
    }

    .sv-icon-green {
        color: var(--green-700);
        background: var(--green-100);
    }

    .sv-icon-red {
        color: var(--red-700);
        background: var(--red-100);
    }

    .sv-icon-blue {
        color: var(--blue-700);
        background: var(--blue-100);
    }

    .sv-summary-mini {
        color: var(--slate-400);

        font-size: 11px;
        font-weight: 850;

        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .sv-summary-label {
        display: block;

        color: var(--slate-600);

        font-size: 14px;
        font-weight: 750;
    }

    .sv-summary-value {
        display: block;

        margin-top: 4px;

        color: var(--navy-800);

        font-size: 32px;
        line-height: 1.1;
        font-weight: 900;
    }

    .sv-summary-note {
        display: block;

        margin-top: 8px;

        color: var(--slate-500);

        font-size: 13px;
        line-height: 1.55;
    }


    /*
    |--------------------------------------------------------------------------
    | Filter Panel
    |--------------------------------------------------------------------------
    */

    .sv-filter-card {
        margin-bottom: 25px;
        padding: 21px;

        border: 1px solid var(--slate-200);
        border-radius: 19px;

        background: #FFFFFF;

        box-shadow:
            0 7px 25px
            rgba(15, 42, 74, .04);
    }

    .sv-filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 16px;

        margin-bottom: 16px;
    }

    .sv-filter-title {
        margin: 0;

        color: var(--navy-800);

        font-size: 20px;
        font-weight: 850;
    }

    .sv-filter-description {
        margin: 3px 0 0;

        color: var(--slate-500);

        font-size: 14px;
    }

    .sv-visible-count {
        display: inline-flex;
        align-items: center;

        min-height: 34px;

        padding: 7px 12px;

        border-radius: 999px;

        color: var(--slate-600);
        background: var(--slate-100);

        font-size: 13px;
        font-weight: 800;

        white-space: nowrap;
    }

    .sv-filter-grid {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            230px;

        gap: 13px;
    }

    .sv-search,
    .sv-select {
        width: 100%;
        min-height: 54px;

        border: 1px solid #C9D7E6;
        border-radius: 13px;

        outline: none;

        color: var(--navy-800);
        background: #FBFDFF;

        font-size: 16px;
        font-weight: 650;
    }

    .sv-search {
        padding: 0 16px;
    }

    .sv-select {
        padding: 0 14px;

        cursor: pointer;
    }

    .sv-search::placeholder {
        color: #8A9AAD;
    }

    .sv-search:focus,
    .sv-select:focus {
        border-color: var(--teal-600);

        background: #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(13, 148, 136, .08);
    }


    /*
    |--------------------------------------------------------------------------
    | Records Panel
    |--------------------------------------------------------------------------
    */

    .sv-panel {
        overflow: hidden;

        border: 1px solid var(--slate-200);
        border-radius: 21px;

        background: #FFFFFF;

        box-shadow:
            0 8px 28px
            rgba(15, 42, 74, .05);
    }

    .sv-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding: 24px 25px;

        border-bottom:
            1px solid #EDF2F7;

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FBFDFF
            );
    }

    .sv-panel-heading {
        display: flex;
        align-items: center;

        gap: 14px;
    }

    .sv-panel-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 50px;
        height: 50px;

        flex: 0 0 50px;

        border-radius: 15px;

        color: var(--teal-700);
        background: var(--teal-100);

        font-size: 12px;
        font-weight: 900;
    }

    .sv-panel-heading h2 {
        margin: 0;

        color: var(--navy-800);

        font-size: 23px;
        line-height: 1.3;
        font-weight: 850;
    }

    .sv-panel-heading p {
        margin: 4px 0 0;

        color: var(--slate-500);

        font-size: 14px;
    }

    .sv-panel-total {
        color: var(--slate-500);

        font-size: 13px;
        font-weight: 750;

        white-space: nowrap;
    }

    .sv-panel-body {
        padding: 25px;
    }


    /*
    |--------------------------------------------------------------------------
    | Attendance Records
    |--------------------------------------------------------------------------
    */

    .sv-record-list {
        display: grid;
        gap: 21px;
    }

    .sv-record {
        overflow: hidden;

        border: 1px solid #D9E4EE;
        border-radius: 19px;

        background: #FFFFFF;

        transition:
            transform .18s ease,
            border-color .18s ease,
            box-shadow .18s ease;
    }

    .sv-record:hover {
        transform: translateY(-2px);

        border-color: #BBCFE1;

        box-shadow:
            0 15px 34px
            rgba(15, 42, 74, .08);
    }


    /*
    |--------------------------------------------------------------------------
    | Record Header
    |--------------------------------------------------------------------------
    */

    .sv-record-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding: 21px 22px;

        border-bottom:
            1px solid #EDF2F7;

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FAFCFF
            );
    }

    .sv-student {
        display: flex;
        align-items: center;

        min-width: 0;

        gap: 15px;
    }

    .sv-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 58px;
        height: 58px;

        flex: 0 0 58px;

        border-radius: 17px;

        color: var(--teal-800);

        background:
            linear-gradient(
                135deg,
                var(--teal-100),
                #E5F8F5
            );

        font-size: 16px;
        font-weight: 900;
    }

    .sv-student-name {
        display: block;

        color: var(--navy-800);

        font-size: 20px;
        line-height: 1.35;
        font-weight: 900;
    }

    .sv-student-meta {
        display: block;

        margin-top: 4px;

        color: var(--slate-500);

        font-size: 14px;
        line-height: 1.55;
    }

    .sv-status {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding: 8px 12px;

        border-radius: 999px;

        font-size: 13px;
        font-weight: 850;

        white-space: nowrap;
    }

    .sv-status::before {
        content: '';

        width: 8px;
        height: 8px;

        border-radius: 50%;

        background: currentColor;
    }

    .status-progress {
        color: var(--blue-700);
        background: var(--blue-100);
    }

    .status-pending {
        color: var(--orange-800);
        background: var(--orange-100);
    }

    .status-validated {
        color: var(--green-800);
        background: var(--green-100);
    }

    .status-rejected {
        color: var(--red-800);
        background: var(--red-100);
    }

    .status-neutral {
        color: var(--slate-600);
        background: var(--slate-100);
    }


    /*
    |--------------------------------------------------------------------------
    | Record Body
    |--------------------------------------------------------------------------
    */

    .sv-record-body {
        padding: 22px;
    }

    .sv-record-overview {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 12px;

        margin-bottom: 19px;
    }

    .sv-info-box {
        min-width: 0;

        padding: 15px 16px;

        border: 1px solid #E4ECF4;
        border-radius: 14px;

        background:
            linear-gradient(
                180deg,
                #FCFDFF,
                #F8FAFC
            );
    }

    .sv-info-label {
        display: block;

        margin-bottom: 5px;

        color: var(--slate-500);

        font-size: 12px;
        font-weight: 800;

        letter-spacing: .025em;
        text-transform: uppercase;
    }

    .sv-info-value {
        display: block;

        color: var(--navy-800);

        font-size: 16px;
        line-height: 1.45;
        font-weight: 850;

        overflow-wrap: anywhere;
    }


    /*
    |--------------------------------------------------------------------------
    | Attendance Workflow Strip
    |--------------------------------------------------------------------------
    */

    .sv-workflow {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            auto
            minmax(0, 1fr);

        align-items: stretch;

        gap: 13px;
    }

    .sv-session {
        position: relative;

        overflow: hidden;

        padding: 17px;

        border: 1px solid var(--slate-200);
        border-radius: 15px;

        background: #FFFFFF;
    }

    .sv-session::before {
        content: '';

        position: absolute;

        top: 0;
        bottom: 0;
        left: 0;

        width: 5px;

        background: var(--slate-300);
    }

    .sv-session.complete {
        border-color: #C8EAD2;

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FBFEFC
            );
    }

    .sv-session.complete::before {
        background: var(--green-700);
    }

    .sv-session.active {
        border-color: #BFDBFE;

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FAFCFF
            );
    }

    .sv-session.active::before {
        background: var(--blue-600);
    }

    .sv-session-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 10px;

        margin-bottom: 13px;
    }

    .sv-session-number {
        display: block;

        margin-bottom: 3px;

        color: var(--blue-700);

        font-size: 11px;
        font-weight: 900;

        letter-spacing: .07em;
        text-transform: uppercase;
    }

    .sv-session-title {
        margin: 0;

        color: var(--navy-800);

        font-size: 18px;
        font-weight: 850;
    }

    .sv-session-badge {
        padding: 5px 8px;

        border-radius: 999px;

        color: var(--slate-600);
        background: var(--slate-100);

        font-size: 11px;
        font-weight: 800;

        white-space: nowrap;
    }

    .sv-session-badge.complete {
        color: var(--green-800);
        background: var(--green-100);
    }

    .sv-session-badge.active {
        color: var(--blue-700);
        background: var(--blue-100);
    }

    .sv-session-data {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 8px;
    }

    .sv-session-data-box {
        min-width: 0;

        padding: 11px;

        border-radius: 11px;

        background: var(--slate-50);
    }

    .sv-session-data-label {
        display: block;

        color: var(--slate-500);

        font-size: 11px;
        font-weight: 700;
    }

    .sv-session-data-value {
        display: block;

        margin-top: 3px;

        color: var(--navy-800);

        font-size: 13px;
        font-weight: 850;

        overflow-wrap: anywhere;
    }


    /*
    |--------------------------------------------------------------------------
    | Break
    |--------------------------------------------------------------------------
    */

    .sv-break {
        display: flex;
        align-items: center;
        justify-content: center;

        min-width: 96px;

        padding: 10px;
    }

    .sv-break-inner {
        text-align: center;
    }

    .sv-break-label {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 7px 10px;

        border-radius: 999px;

        color: var(--slate-600);
        background: var(--slate-100);

        font-size: 11px;
        font-weight: 850;
    }

    .sv-break-note {
        display: block;

        margin-top: 5px;

        color: var(--slate-400);

        font-size: 10px;
        font-weight: 700;
    }


    /*
    |--------------------------------------------------------------------------
    | Legacy Attendance
    |--------------------------------------------------------------------------
    */

    .sv-legacy {
        padding: 15px 16px;

        border: 1px solid #DDE5EE;
        border-radius: 13px;

        color: var(--slate-600);
        background: var(--slate-50);

        font-size: 14px;
        line-height: 1.65;
    }

    .sv-legacy strong {
        color: var(--navy-800);
    }


    /*
    |--------------------------------------------------------------------------
    | Record Footer
    |--------------------------------------------------------------------------
    */

    .sv-record-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-top: 19px;
        padding-top: 18px;

        border-top:
            1px solid #EDF2F7;
    }

    .sv-record-message {
        max-width: 760px;

        color: var(--slate-500);

        font-size: 13px;
        line-height: 1.6;
    }

    .sv-record-message strong {
        color: var(--navy-800);

        font-size: 14px;
    }

    .sv-review-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-width: 160px;
        min-height: 50px;

        padding: 11px 17px;

        border-radius: 12px;

        color: #FFFFFF;

        background:
            linear-gradient(
                135deg,
                var(--blue-600),
                var(--blue-700)
            );

        box-shadow:
            0 8px 19px
            rgba(37, 99, 235, .20);

        font-size: 14px;
        font-weight: 850;

        text-decoration: none;

        transition:
            transform .16s ease,
            box-shadow .16s ease;
    }

    .sv-review-button:hover {
        color: #FFFFFF;

        transform: translateY(-1px);

        box-shadow:
            0 11px 24px
            rgba(37, 99, 235, .25);
    }

    .sv-review-button.secondary {
        color: var(--navy-800);

        background: #FFFFFF;

        border: 1px solid #C8D6E5;

        box-shadow: none;
    }

    .sv-review-button.secondary:hover {
        color: var(--blue-700);

        border-color: #93C5FD;

        background: var(--blue-50);
    }


    /*
    |--------------------------------------------------------------------------
    | No Records
    |--------------------------------------------------------------------------
    */

    .sv-empty {
        padding: 52px 22px;

        text-align: center;
    }

    .sv-empty-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 68px;
        height: 68px;

        margin-bottom: 16px;

        border-radius: 20px;

        color: var(--teal-800);
        background: var(--teal-100);

        font-size: 16px;
        font-weight: 900;
    }

    .sv-empty h3 {
        margin: 0;

        color: var(--navy-800);

        font-size: 22px;
        font-weight: 850;
    }

    .sv-empty p {
        max-width: 560px;

        margin: 8px auto 0;

        color: var(--slate-500);

        font-size: 15px;
        line-height: 1.7;
    }


    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1200px) {
        .sv-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .sv-record-overview {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .sv-workflow {
            grid-template-columns: 1fr;
        }

        .sv-break {
            min-width: 0;
            padding: 0;
        }
    }

    @media (max-width: 900px) {
        .sv-hero-inner {
            align-items: flex-start;
            flex-direction: column;
        }

        .sv-queue {
            width: 100%;
            flex: 0 0 auto;
        }
    }

    @media (max-width: 720px) {
        .sv-page {
            font-size: 16px;
        }

        .sv-hero {
            padding: 28px 21px;
            border-radius: 21px;
        }

        .sv-hero-description {
            font-size: 16px;
        }

        .sv-summary-grid {
            grid-template-columns: 1fr;
        }

        .sv-filter-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .sv-filter-grid {
            grid-template-columns: 1fr;
        }

        .sv-panel-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .sv-record-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .sv-record-overview {
            grid-template-columns: 1fr;
        }

        .sv-record-footer {
            align-items: stretch;
            flex-direction: column;
        }

        .sv-review-button {
            width: 100%;
        }
    }

    @media (max-width: 560px) {
        .sv-panel-body,
        .sv-panel-header {
            padding-left: 16px;
            padding-right: 16px;
        }

        .sv-record-body {
            padding: 16px;
        }

        .sv-record-header {
            padding: 17px;
        }

        .sv-student {
            align-items: flex-start;
        }

        .sv-avatar {
            width: 50px;
            height: 50px;

            flex-basis: 50px;
        }

        .sv-student-name {
            font-size: 18px;
        }

        .sv-session-data {
            grid-template-columns: 1fr;
        }

        .sv-notice {
            flex-direction: column;
        }
    }
</style>

@endpush


@section('content')

<div class="sv-page">


    {{-- ===============================================================
         ALERTS
         =============================================================== --}}

    @if (session('success'))

        <div class="sv-alert sv-alert-success">

            <span class="sv-alert-icon">
                ✓
            </span>

            <div>
                {{ session('success') }}
            </div>

        </div>

    @endif


    @if (session('error'))

        <div class="sv-alert sv-alert-error">

            <span class="sv-alert-icon">
                !
            </span>

            <div>
                {{ session('error') }}
            </div>

        </div>

    @endif


    @if ($errors->any())

        <div class="sv-alert sv-alert-error">

            <span class="sv-alert-icon">
                !
            </span>

            <div>
                {{ $errors->first() }}
            </div>

        </div>

    @endif


    {{-- ===============================================================
         HERO
         =============================================================== --}}

    <section class="sv-hero">

        <div class="sv-hero-inner">


            <div class="sv-hero-copy">

                <div class="sv-eyebrow">

                    <span class="sv-eyebrow-dot"></span>

                    Supervisor Portal · Attendance Monitoring

                </div>


                <h1>
                    Attendance Validation
                </h1>


                <p class="sv-hero-description">

                    Review the complete OJT attendance day before
                    approving rendered hours. Each new attendance
                    record contains separate Morning and Afternoon
                    sessions with GPS and selfie evidence available
                    on the detailed review page.

                </p>

            </div>


            <div class="sv-queue">

                <span class="sv-queue-label">
                    Waiting for Review
                </span>


                <span class="sv-queue-value">
                    {{ $pendingCount }}
                </span>


                <span class="sv-queue-description">

                    {{ $pendingCount === 1
                        ? 'completed attendance record is'
                        : 'completed attendance records are' }}

                    waiting for your validation.

                </span>


                <div class="sv-queue-footer">

                    {{ $supervisedAssignmentCount }}

                    supervised

                    {{ $supervisedAssignmentCount === 1
                        ? 'placement'
                        : 'placements' }}

                </div>

            </div>


        </div>

    </section>


    {{-- ===============================================================
         IMPORTANT NOTICE
         =============================================================== --}}

    <section class="sv-notice">

        <div class="sv-notice-icon">
            SEC
        </div>


        <div>

            <strong>
                Validate only after reviewing both attendance sessions.
            </strong>


            <p>

                Morning and Afternoon sessions are calculated
                separately. Lunch and break periods are not counted
                as rendered OJT time. Open the attendance record to
                inspect GPS coordinates and selfie evidence before
                approving official hours.

            </p>

        </div>

    </section>


    {{-- ===============================================================
         DASHBOARD SUMMARY
         =============================================================== --}}

    <section class="sv-summary-grid">


        <article class="sv-summary-card">

            <div class="sv-summary-top">

                <div class="sv-summary-icon sv-icon-orange">
                    PD
                </div>

                <span class="sv-summary-mini">
                    Action Required
                </span>

            </div>


            <span class="sv-summary-label">
                Pending Review
            </span>

            <span class="sv-summary-value">
                {{ $pendingCount }}
            </span>

            <span class="sv-summary-note">
                Completed attendance days waiting for your decision.
            </span>

        </article>


        <article class="sv-summary-card">

            <div class="sv-summary-top">

                <div class="sv-summary-icon sv-icon-green">
                    OK
                </div>

                <span class="sv-summary-mini">
                    Approved
                </span>

            </div>


            <span class="sv-summary-label">
                Validated Records
            </span>

            <span class="sv-summary-value">
                {{ $validatedCount }}
            </span>

            <span class="sv-summary-note">
                Attendance records officially approved by you.
            </span>

        </article>


        <article class="sv-summary-card">

            <div class="sv-summary-top">

                <div class="sv-summary-icon sv-icon-red">
                    RJ
                </div>

                <span class="sv-summary-mini">
                    Needs Attention
                </span>

            </div>


            <span class="sv-summary-label">
                Rejected Records
            </span>

            <span class="sv-summary-value">
                {{ $rejectedCount }}
            </span>

            <span class="sv-summary-note">
                Submissions rejected with Supervisor remarks.
            </span>

        </article>


        <article class="sv-summary-card">

            <div class="sv-summary-top">

                <div class="sv-summary-icon sv-icon-blue">
                    HR
                </div>

                <span class="sv-summary-mini">
                    Official Time
                </span>

            </div>


            <span class="sv-summary-label">
                Validated OJT Hours
            </span>

            <span class="sv-summary-value">

                {{ number_format(
                    $validatedHours,
                    1
                ) }}

            </span>

            <span class="sv-summary-note">
                Combined approved rendered hours under your supervision.
            </span>

        </article>


    </section>


    {{-- ===============================================================
         SEARCH AND FILTER
         =============================================================== --}}

    <section class="sv-filter-card">


        <div class="sv-filter-header">


            <div>

                <h2 class="sv-filter-title">
                    Find Attendance
                </h2>

                <p class="sv-filter-description">

                    Search using Student name, Student number,
                    company, attendance date, or status.

                </p>

            </div>


            <span
                class="sv-visible-count"
                id="svVisibleCount"
            >

                {{ $totalRecords }}
                visible

            </span>


        </div>


        <div class="sv-filter-grid">


            <input
                type="search"
                id="svSearchInput"
                class="sv-search"
                placeholder="Search Student, company, number or date..."
                autocomplete="off"
                aria-label="Search attendance records"
            >


            <select
                id="svStatusFilter"
                class="sv-select"
                aria-label="Filter attendance status"
            >

                <option value="all">
                    All Attendance
                </option>

                <option value="pending">
                    Pending Review
                </option>

                <option value="validated">
                    Validated
                </option>

                <option value="rejected">
                    Rejected
                </option>

                <option value="in_progress">
                    In Progress
                </option>

            </select>


        </div>

    </section>


    {{-- ===============================================================
         ATTENDANCE LIST
         =============================================================== --}}

    <section class="sv-panel">


        <div class="sv-panel-header">


            <div class="sv-panel-heading">

                <div class="sv-panel-icon">
                    OJT
                </div>


                <div>

                    <h2>
                        Student Attendance Records
                    </h2>

                    <p>

                        Complete daily attendance overview for
                        Students assigned to you.

                    </p>

                </div>

            </div>


            <div class="sv-panel-total">

                {{ $totalRecords }}

                total

                {{ $totalRecords === 1
                    ? 'record'
                    : 'records' }}

            </div>


        </div>


        <div class="sv-panel-body">


            @if ($attendanceRecords->isNotEmpty())


                <div
                    class="sv-record-list"
                    id="svRecordList"
                >


                    @foreach ($attendanceRecords as $record)

                        @php
                            $assignment =
                                $record->ojtAssignment;

                            $profile =
                                $assignment?->studentProfile;

                            $student =
                                $profile?->user;

                            $company =
                                $assignment?->company;

                            $sessions =
                                $record->relationLoaded(
                                    'sessions'
                                )
                                    ? $record->getRelation(
                                        'sessions'
                                    )
                                    : collect();

                            $morningSession =
                                $sessions->firstWhere(
                                    'session_number',
                                    \App\Models\AttendanceSession::MORNING_SESSION
                                );

                            $afternoonSession =
                                $sessions->firstWhere(
                                    'session_number',
                                    \App\Models\AttendanceSession::AFTERNOON_SESSION
                                );

                            $completedSessions =
                                $sessions
                                    ->whereNotNull(
                                        'time_out'
                                    )
                                    ->count();

                            $isLegacy =
                                $sessions->isEmpty()
                                &&
                                $record->time_in !== null;

                            $studentName =
                                $student?->name
                                ?? 'Unknown Student';

                            $studentNumber =
                                $profile?->student_number
                                ?? 'No Student Number';

                            $companyName =
                                $company?->name
                                ?? 'No Company Assigned';

                            $searchText =
                                mb_strtolower(
                                    implode(
                                        ' ',
                                        [
                                            $studentName,
                                            $studentNumber,
                                            $companyName,
                                            $formatDate(
                                                $record->attendance_date
                                            ),
                                            $record->status,
                                        ]
                                    )
                                );
                        @endphp


                        <article
                            class="sv-record sv-filter-record"
                            data-status="{{ $record->status }}"
                            data-search="{{ $searchText }}"
                        >


                            {{-- =========================================
                                 STUDENT HEADER
                                 ========================================= --}}

                            <div class="sv-record-header">


                                <div class="sv-student">


                                    <div class="sv-avatar">

                                        {{ $initials(
                                            $studentName
                                        ) }}

                                    </div>


                                    <div>

                                        <span class="sv-student-name">
                                            {{ $studentName }}
                                        </span>


                                        <span class="sv-student-meta">

                                            {{ $studentNumber }}

                                            &nbsp;·&nbsp;

                                            {{ $companyName }}

                                        </span>

                                    </div>


                                </div>


                                <span
                                    class="
                                        sv-status
                                        {{ $statusClass(
                                            $record->status
                                        ) }}
                                    "
                                >

                                    {{ $statusLabel(
                                        $record->status
                                    ) }}

                                </span>


                            </div>


                            {{-- =========================================
                                 CONTENT
                                 ========================================= --}}

                            <div class="sv-record-body">


                                {{-- =====================================
                                     DAILY OVERVIEW
                                     ===================================== --}}

                                <div class="sv-record-overview">


                                    <div class="sv-info-box">

                                        <span class="sv-info-label">
                                            Attendance Date
                                        </span>

                                        <span class="sv-info-value">

                                            {{ $formatDate(
                                                $record->attendance_date
                                            ) }}

                                        </span>

                                    </div>


                                    <div class="sv-info-box">

                                        <span class="sv-info-label">
                                            Attendance Sessions
                                        </span>

                                        <span class="sv-info-value">

                                            @if ($isLegacy)

                                                Previous Format

                                            @else

                                                {{ $completedSessions }}
                                                of 2 Completed

                                            @endif

                                        </span>

                                    </div>


                                    <div class="sv-info-box">

                                        <span class="sv-info-label">
                                            Daily Rendered Time
                                        </span>

                                        <span class="sv-info-value">

                                            {{ $formatMinutes(
                                                $record->rendered_minutes
                                            ) }}

                                        </span>

                                    </div>


                                    <div class="sv-info-box">

                                        <span class="sv-info-label">
                                            Company
                                        </span>

                                        <span class="sv-info-value">
                                            {{ $companyName }}
                                        </span>

                                    </div>


                                </div>


                                {{-- =====================================
                                     MORNING + AFTERNOON
                                     ===================================== --}}

                                @if ($sessions->isNotEmpty())


                                    <div class="sv-workflow">


                                        {{-- MORNING SESSION --}}

                                        <section
                                            class="
                                                sv-session

                                                @if ($morningSession?->time_out)
                                                    complete
                                                @elseif ($morningSession)
                                                    active
                                                @endif
                                            "
                                        >


                                            <div class="sv-session-header">


                                                <div>

                                                    <span class="sv-session-number">
                                                        Session 01
                                                    </span>

                                                    <h3 class="sv-session-title">
                                                        Morning Session
                                                    </h3>

                                                </div>


                                                @if ($morningSession?->time_out)

                                                    <span
                                                        class="
                                                            sv-session-badge
                                                            complete
                                                        "
                                                    >
                                                        Completed
                                                    </span>

                                                @elseif ($morningSession)

                                                    <span
                                                        class="
                                                            sv-session-badge
                                                            active
                                                        "
                                                    >
                                                        Working
                                                    </span>

                                                @else

                                                    <span class="sv-session-badge">
                                                        Not Started
                                                    </span>

                                                @endif


                                            </div>


                                            <div class="sv-session-data">


                                                <div class="sv-session-data-box">

                                                    <span class="sv-session-data-label">
                                                        Time In
                                                    </span>

                                                    <span class="sv-session-data-value">

                                                        {{ $formatTime(
                                                            $morningSession?->time_in
                                                        ) }}

                                                    </span>

                                                </div>


                                                <div class="sv-session-data-box">

                                                    <span class="sv-session-data-label">
                                                        Time Out
                                                    </span>

                                                    <span class="sv-session-data-value">

                                                        {{ $formatTime(
                                                            $morningSession?->time_out
                                                        ) }}

                                                    </span>

                                                </div>


                                                <div class="sv-session-data-box">

                                                    <span class="sv-session-data-label">
                                                        Rendered
                                                    </span>

                                                    <span class="sv-session-data-value">

                                                        {{ $formatMinutes(
                                                            $morningSession?->rendered_minutes
                                                            ?? 0
                                                        ) }}

                                                    </span>

                                                </div>


                                            </div>


                                        </section>


                                        {{-- BREAK --}}

                                        <div class="sv-break">

                                            <div class="sv-break-inner">

                                                <span class="sv-break-label">
                                                    Lunch / Break
                                                </span>

                                                <span class="sv-break-note">
                                                    Not counted
                                                </span>

                                            </div>

                                        </div>


                                        {{-- AFTERNOON SESSION --}}

                                        <section
                                            class="
                                                sv-session

                                                @if ($afternoonSession?->time_out)
                                                    complete
                                                @elseif ($afternoonSession)
                                                    active
                                                @endif
                                            "
                                        >


                                            <div class="sv-session-header">


                                                <div>

                                                    <span class="sv-session-number">
                                                        Session 02
                                                    </span>

                                                    <h3 class="sv-session-title">
                                                        Afternoon Session
                                                    </h3>

                                                </div>


                                                @if ($afternoonSession?->time_out)

                                                    <span
                                                        class="
                                                            sv-session-badge
                                                            complete
                                                        "
                                                    >
                                                        Completed
                                                    </span>

                                                @elseif ($afternoonSession)

                                                    <span
                                                        class="
                                                            sv-session-badge
                                                            active
                                                        "
                                                    >
                                                        Working
                                                    </span>

                                                @else

                                                    <span class="sv-session-badge">
                                                        Not Started
                                                    </span>

                                                @endif


                                            </div>


                                            <div class="sv-session-data">


                                                <div class="sv-session-data-box">

                                                    <span class="sv-session-data-label">
                                                        Time In
                                                    </span>

                                                    <span class="sv-session-data-value">

                                                        {{ $formatTime(
                                                            $afternoonSession?->time_in
                                                        ) }}

                                                    </span>

                                                </div>


                                                <div class="sv-session-data-box">

                                                    <span class="sv-session-data-label">
                                                        Time Out
                                                    </span>

                                                    <span class="sv-session-data-value">

                                                        {{ $formatTime(
                                                            $afternoonSession?->time_out
                                                        ) }}

                                                    </span>

                                                </div>


                                                <div class="sv-session-data-box">

                                                    <span class="sv-session-data-label">
                                                        Rendered
                                                    </span>

                                                    <span class="sv-session-data-value">

                                                        {{ $formatMinutes(
                                                            $afternoonSession?->rendered_minutes
                                                            ?? 0
                                                        ) }}

                                                    </span>

                                                </div>


                                            </div>


                                        </section>


                                    </div>


                                @else


                                    {{-- =================================
                                         OLD RECORD FORMAT
                                         ================================= --}}

                                    <div class="sv-legacy">

                                        <strong>
                                            Previous Attendance Format
                                        </strong>

                                        <br>

                                        This attendance record was
                                        created before the Morning and
                                        Afternoon Session system was
                                        introduced.

                                        &nbsp;·&nbsp;

                                        Time In:

                                        <strong>
                                            {{ $formatTime(
                                                $record->time_in
                                            ) }}
                                        </strong>

                                        &nbsp;·&nbsp;

                                        Time Out:

                                        <strong>
                                            {{ $formatTime(
                                                $record->time_out
                                            ) }}
                                        </strong>

                                    </div>


                                @endif


                                {{-- =====================================
                                     FOOTER
                                     ===================================== --}}

                                <div class="sv-record-footer">


                                    <div class="sv-record-message">


                                        @if (
                                            $record->status
                                            ===
                                            \App\Models\AttendanceRecord::STATUS_PENDING
                                        )

                                            <strong>
                                                Ready for your review.
                                            </strong>

                                            Open this attendance record
                                            to inspect the Morning and
                                            Afternoon GPS and selfie
                                            evidence before deciding.

                                        @elseif (
                                            $record->status
                                            ===
                                            \App\Models\AttendanceRecord::STATUS_VALIDATED
                                        )

                                            <strong>
                                                Attendance approved.
                                            </strong>

                                            @if ($record->validated_at)

                                                Validated on

                                                {{ $formatDateTime(
                                                    $record->validated_at
                                                ) }}.

                                            @endif

                                        @elseif (
                                            $record->status
                                            ===
                                            \App\Models\AttendanceRecord::STATUS_REJECTED
                                        )

                                            <strong>
                                                Attendance rejected.
                                            </strong>

                                            Open the record to review
                                            the submitted evidence and
                                            Supervisor remarks.

                                        @else

                                            <strong>
                                                Student attendance is still in progress.
                                            </strong>

                                            The complete attendance day
                                            has not yet been submitted
                                            for validation.

                                        @endif


                                    </div>


                                    <a
                                        href="{{ route(
                                            'supervisor.validations.show',
                                            $record
                                        ) }}"
                                        class="
                                            sv-review-button

                                            @if (
                                                $record->status
                                                !==
                                                \App\Models\AttendanceRecord::STATUS_PENDING
                                            )
                                                secondary
                                            @endif
                                        "
                                    >

                                        @if (
                                            $record->status
                                            ===
                                            \App\Models\AttendanceRecord::STATUS_PENDING
                                        )

                                            Review Attendance

                                        @else

                                            View Details

                                        @endif

                                    </a>


                                </div>


                            </div>


                        </article>


                    @endforeach


                </div>


                {{-- ===================================================
                     FILTERED EMPTY
                     =================================================== --}}

                <div
                    class="sv-empty"
                    id="svFilteredEmpty"
                    hidden
                >

                    <div class="sv-empty-icon">
                        0
                    </div>

                    <h3>
                        No matching attendance records
                    </h3>

                    <p>

                        No records match your current search
                        and status filter. Try changing the
                        Student name, company, date, or status.

                    </p>

                </div>


            @else


                {{-- ===================================================
                     DATABASE EMPTY
                     =================================================== --}}

                <div class="sv-empty">

                    <div class="sv-empty-icon">
                        OJT
                    </div>

                    <h3>
                        No attendance records available
                    </h3>

                    <p>

                        Attendance records from Students
                        assigned to you will appear here after
                        they begin recording GPS Selfie
                        Attendance.

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

        const searchInput =
            document.getElementById(
                'svSearchInput'
            );

        const statusFilter =
            document.getElementById(
                'svStatusFilter'
            );

        const visibleCount =
            document.getElementById(
                'svVisibleCount'
            );

        const emptyState =
            document.getElementById(
                'svFilteredEmpty'
            );

        const records =
            Array.from(
                document.querySelectorAll(
                    '.sv-filter-record'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Attendance Filtering
        |--------------------------------------------------------------------------
        */

        function applyFilters() {

            const searchValue =
                (
                    searchInput?.value
                    ?? ''
                )
                    .trim()
                    .toLowerCase();

            const statusValue =
                statusFilter?.value
                ?? 'all';

            let visibleRecords =
                0;


            records.forEach(
                function (record) {

                    const recordSearch =
                        (
                            record.dataset.search
                            ?? ''
                        )
                            .toLowerCase();

                    const recordStatus =
                        record.dataset.status
                        ?? '';


                    const matchesSearch =
                        searchValue === ''
                        ||
                        recordSearch.includes(
                            searchValue
                        );


                    const matchesStatus =
                        statusValue === 'all'
                        ||
                        recordStatus === statusValue;


                    const shouldShow =
                        matchesSearch
                        &&
                        matchesStatus;


                    record.hidden =
                        ! shouldShow;


                    if (shouldShow) {
                        visibleRecords++;
                    }
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Update Visible Counter
            |--------------------------------------------------------------------------
            */

            if (visibleCount) {
                visibleCount.textContent =
                    visibleRecords
                    +
                    (
                        visibleRecords === 1
                            ? ' visible record'
                            : ' visible records'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Filter Empty State
            |--------------------------------------------------------------------------
            */

            if (emptyState) {
                emptyState.hidden =
                    visibleRecords !== 0;
            }
        }


        searchInput
            ?.addEventListener(
                'input',
                applyFilters
            );


        statusFilter
            ?.addEventListener(
                'change',
                applyFilters
            );


        applyFilters();
    }
);
</script>

@endpush