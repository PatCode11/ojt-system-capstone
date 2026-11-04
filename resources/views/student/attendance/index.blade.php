@extends('layouts.app')

@section('title', 'GPS Selfie Attendance')

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

    $formatMinutes = function ($minutes): string {
        $minutes = max(0, (int) $minutes);

        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        if ($hours > 0 && $remainingMinutes > 0) {
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

        return $remainingMinutes.' min';
    };

    $statusLabel = function (?string $status): string {
        return match ($status) {
            'in_progress' => 'In Progress',
            'pending' => 'Pending Validation',
            'validated' => 'Validated',
            'rejected' => 'Rejected',
            default => 'Not Recorded',
        };
    };

    $statusClass = function (?string $status): string {
        return match ($status) {
            'in_progress' => 'status-blue',
            'pending' => 'status-orange',
            'validated' => 'status-green',
            'rejected' => 'status-red',
            default => 'status-gray',
        };
    };

    /*
    |--------------------------------------------------------------------------
    | Sessions
    |--------------------------------------------------------------------------
    */

    $morningSession = $todaySessions
        ->firstWhere('session_number', 1);

    $afternoonSession = $todaySessions
        ->firstWhere('session_number', 2);

    $morningState = match (true) {
        (bool) $morningSession?->time_out => 'complete',
        (bool) $morningSession => 'active',
        default => 'waiting',
    };

    $afternoonState = match (true) {
        (bool) $afternoonSession?->time_out => 'complete',
        (bool) $afternoonSession => 'active',
        default => 'waiting',
    };

    /*
    |--------------------------------------------------------------------------
    | Assignment
    |--------------------------------------------------------------------------
    */

    $assignmentIsActive =
        $activeAssignment
        && $activeAssignment->status === 'active';

    /*
    |--------------------------------------------------------------------------
    | Attendance Action
    |--------------------------------------------------------------------------
    */

    if ($canTimeOut) {
        $isAfternoon =
            $openSession?->session_number === 2;

        $actionStep =
            $isAfternoon ? '04' : '02';

        $actionTitle =
            $isAfternoon
                ? 'Finish Afternoon Session'
                : 'Finish Morning Session';

        $actionSubtitle =
            $isAfternoon
                ? 'Your Afternoon Session is currently active.'
                : 'Your Morning Session is currently active.';

        $actionDescription =
            'Verify your current GPS location and capture a clear attendance selfie before recording your Time Out.';

        $actionButton =
            $isAfternoon
                ? 'Record Afternoon Time Out'
                : 'Record Morning Time Out';

        $actionRoute =
            route('student.attendance.time-out');

        $actionMode =
            'time-out';
    } elseif ($canTimeIn) {
        $isAfternoon =
            $nextSessionNumber === 2;

        $actionStep =
            $isAfternoon ? '03' : '01';

        $actionTitle =
            $isAfternoon
                ? 'Start Afternoon Session'
                : 'Start Morning Session';

        $actionSubtitle =
            $isAfternoon
                ? 'Your Morning Session is complete.'
                : 'Attendance has not started today.';

        $actionDescription =
            $isAfternoon
                ? 'After your lunch or break period, verify your GPS location and capture another selfie to begin your Afternoon Session.'
                : 'Verify your GPS location and capture a clear attendance selfie to begin your Morning Session.';

        $actionButton =
            $isAfternoon
                ? 'Record Afternoon Time In'
                : 'Record Morning Time In';

        $actionRoute =
            route('student.attendance.time-in');

        $actionMode =
            'time-in';
    } else {
        $actionStep = '—';
        $actionTitle = 'Attendance Unavailable';
        $actionSubtitle = '';
        $actionDescription = '';
        $actionButton = null;
        $actionRoute = null;
        $actionMode = null;
    }
@endphp


@push('styles')

<style>
    .attendance-page {
        --navy-950: #07192D;
        --navy-900: #0B223D;
        --navy-800: #102A4A;
        --navy-700: #183B6B;

        --blue-700: #1D4ED8;
        --blue-600: #2563EB;
        --blue-500: #3B82F6;
        --blue-100: #DBEAFE;
        --blue-50: #EFF6FF;

        --teal-700: #0F766E;
        --teal-100: #CCFBF1;

        --green-700: #15803D;
        --green-100: #DCFCE7;

        --orange-700: #C2410C;
        --orange-100: #FFEDD5;

        --red-700: #B91C1C;
        --red-100: #FEE2E2;

        --purple-700: #6D28D9;
        --purple-100: #F3E8FF;

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
        max-width: 1500px;

        margin: 0 auto;
        padding: 6px 0 60px;

        color: var(--slate-800);

        font-size: 16px;
        line-height: 1.65;
    }

    .attendance-page *,
    .attendance-page *::before,
    .attendance-page *::after {
        box-sizing: border-box;
    }

    /*
    |--------------------------------------------------------------------------
    | Alerts
    |--------------------------------------------------------------------------
    */

    .attendance-alert {
        display: flex;
        align-items: flex-start;

        gap: 13px;

        margin-bottom: 22px;
        padding: 16px 18px;

        border: 1px solid transparent;
        border-radius: 15px;

        font-size: 15px;
        font-weight: 700;
    }

    .attendance-alert-success {
        color: #166534;
        background: #F0FDF4;
        border-color: #BBF7D0;
    }

    .attendance-alert-error {
        color: #991B1B;
        background: #FEF2F2;
        border-color: #FECACA;
    }

    .alert-symbol {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 26px;
        height: 26px;

        flex: 0 0 26px;

        color: #FFFFFF;
        background: currentColor;

        border-radius: 50%;

        font-size: 12px;
        font-weight: 900;
    }

    /*
    |--------------------------------------------------------------------------
    | Hero
    |--------------------------------------------------------------------------
    */

    .attendance-hero {
        position: relative;
        overflow: hidden;

        margin-bottom: 24px;
        padding: 35px 36px;

        border-radius: 24px;

        color: #FFFFFF;

        background:
            linear-gradient(
                135deg,
                #0B223D 0%,
                #183B6B 58%,
                #245598 100%
            );

        box-shadow:
            0 18px 46px
            rgba(11, 34, 61, 0.17);
    }

    .attendance-hero::before {
        content: '';

        position: absolute;

        width: 320px;
        height: 320px;

        top: -175px;
        right: -80px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.06);
    }

    .attendance-hero::after {
        content: '';

        position: absolute;

        width: 240px;
        height: 240px;

        right: 190px;
        bottom: -155px;

        border-radius: 50%;

        background:
            rgba(45, 212, 191, 0.09);
    }

    .hero-content {
        position: relative;
        z-index: 2;

        display: flex;

        align-items: flex-end;
        justify-content: space-between;

        gap: 30px;
    }

    .hero-main {
        min-width: 0;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 13px;
        padding: 7px 12px;

        border:
            1px solid
            rgba(255, 255, 255, 0.17);

        border-radius: 999px;

        background:
            rgba(255, 255, 255, 0.09);

        font-size: 12px;
        font-weight: 800;

        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .hero-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background: #5EEAD4;
    }

    .attendance-hero h1 {
        margin: 0;

        color: #FFFFFF;

        font-size: clamp(30px, 4vw, 42px);
        line-height: 1.15;
        font-weight: 850;

        letter-spacing: -.035em;
    }

    .hero-description {
        max-width: 790px;

        margin: 14px 0 0;

        color:
            rgba(255, 255, 255, .82);

        font-size: 16px;
        line-height: 1.75;
    }

    .hero-date {
        min-width: 245px;

        padding: 19px 20px;

        border:
            1px solid
            rgba(255, 255, 255, .16);

        border-radius: 17px;

        background:
            rgba(255, 255, 255, .09);
    }

    .hero-date-label {
        display: block;

        margin-bottom: 6px;

        color:
            rgba(255, 255, 255, .67);

        font-size: 11px;
        font-weight: 800;

        text-transform: uppercase;
    }

    .hero-date-value {
        display: block;

        font-size: 18px;
        font-weight: 850;
    }

    .hero-date-zone {
        display: block;

        margin-top: 4px;

        color:
            rgba(255, 255, 255, .67);

        font-size: 12px;
    }

    /*
    |--------------------------------------------------------------------------
    | Assignment Strip
    |--------------------------------------------------------------------------
    */

    .assignment-strip {
        display: grid;

        grid-template-columns:
            minmax(220px, 1.6fr)
            minmax(190px, 1fr)
            minmax(150px, .7fr)
            minmax(150px, .7fr);

        overflow: hidden;

        margin-bottom: 24px;

        border: 1px solid var(--slate-200);
        border-radius: 19px;

        background: #FFFFFF;

        box-shadow:
            0 7px 24px
            rgba(15, 42, 74, .045);
    }

    .assignment-item {
        min-width: 0;

        padding: 19px 20px;

        border-right:
            1px solid
            var(--slate-200);
    }

    .assignment-item:last-child {
        border-right: 0;
    }

    .assignment-label {
        display: block;

        margin-bottom: 6px;

        color: var(--slate-500);

        font-size: 12px;
        font-weight: 800;

        text-transform: uppercase;
    }

    .assignment-value {
        display: block;

        color: var(--navy-800);

        font-size: 16px;
        font-weight: 800;

        overflow-wrap: anywhere;
    }

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    .status-pill {
        display: inline-flex;

        align-items: center;

        gap: 7px;

        padding: 7px 11px;

        border-radius: 999px;

        font-size: 12px;
        font-weight: 800;

        white-space: nowrap;
    }

    .status-dot {
        width: 7px;
        height: 7px;

        border-radius: 50%;

        background: currentColor;
    }

    .status-blue {
        color: #1D4ED8;
        background: #DBEAFE;
    }

    .status-orange {
        color: #9A3412;
        background: #FFEDD5;
    }

    .status-green {
        color: #166534;
        background: #DCFCE7;
    }

    .status-red {
        color: #991B1B;
        background: #FEE2E2;
    }

    .status-gray {
        color: #475569;
        background: #F1F5F9;
    }

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    */

    .attendance-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1.72fr)
            minmax(320px, .72fr);

        gap: 24px;

        align-items: start;
    }

    .attendance-main,
    .attendance-sidebar {
        display: grid;
        gap: 22px;
    }

    /*
    |--------------------------------------------------------------------------
    | Cards
    |--------------------------------------------------------------------------
    */

    .attendance-card {
        overflow: hidden;

        border: 1px solid var(--slate-200);
        border-radius: 21px;

        background: #FFFFFF;

        box-shadow:
            0 7px 28px
            rgba(15, 42, 74, .045);
    }

    .card-header {
        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 16px;

        padding: 21px 22px;

        border-bottom:
            1px solid #EDF2F7;
    }

    .card-heading {
        display: flex;
        align-items: center;

        gap: 14px;

        min-width: 0;
    }

    .card-icon {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 44px;
        height: 44px;

        flex: 0 0 44px;

        border-radius: 13px;

        font-size: 11px;
        font-weight: 900;
    }

    .icon-blue {
        color: #1D4ED8;
        background: #DBEAFE;
    }

    .icon-teal {
        color: #0F766E;
        background: #CCFBF1;
    }

    .icon-orange {
        color: #C2410C;
        background: #FFEDD5;
    }

    .icon-purple {
        color: #6D28D9;
        background: #F3E8FF;
    }

    .card-title {
        margin: 0;

        color: var(--navy-800);

        font-size: 20px;
        line-height: 1.3;
        font-weight: 850;
    }

    .card-description {
        margin: 4px 0 0;

        color: var(--slate-500);

        font-size: 14px;
        line-height: 1.5;
    }

    .card-body {
        padding: 22px;
    }

    /*
    |--------------------------------------------------------------------------
    | Overview
    |--------------------------------------------------------------------------
    */

    .daily-overview {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 13px;

        margin-bottom: 22px;
    }

    .overview-card {
        padding: 18px;

        border: 1px solid #DCE7F4;
        border-radius: 15px;

        background:
            linear-gradient(
                180deg,
                #FBFDFF,
                #F4F8FD
            );
    }

    .overview-label {
        display: block;

        margin-bottom: 7px;

        color: var(--slate-500);

        font-size: 12px;
        font-weight: 800;

        text-transform: uppercase;
    }

    .overview-value {
        display: block;

        color: var(--navy-800);

        font-size: 21px;
        font-weight: 850;
    }

    /*
    |--------------------------------------------------------------------------
    | Sessions
    |--------------------------------------------------------------------------
    */

    .attendance-sessions {
        display: grid;
        gap: 15px;
    }

    .session-card {
        position: relative;

        overflow: hidden;

        padding: 21px;

        border: 1px solid var(--slate-200);
        border-radius: 18px;

        background: #FFFFFF;
    }

    .session-card::before {
        content: '';

        position: absolute;

        top: 0;
        bottom: 0;
        left: 0;

        width: 5px;

        background: var(--slate-300);
    }

    .session-card.session-active {
        border-color: #BFDBFE;
        background: #FAFCFF;
    }

    .session-card.session-active::before {
        background: #2563EB;
    }

    .session-card.session-complete {
        border-color: #BBF7D0;
        background: #FCFFFD;
    }

    .session-card.session-complete::before {
        background: #16A34A;
    }

    .session-top {
        display: flex;

        align-items: flex-start;
        justify-content: space-between;

        gap: 16px;

        margin-bottom: 18px;
    }

    .session-number {
        display: block;

        margin-bottom: 5px;

        color: #2563EB;

        font-size: 11px;
        font-weight: 900;

        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .session-title {
        margin: 0;

        color: var(--navy-800);

        font-size: 21px;
        font-weight: 850;
    }

    .session-description {
        margin: 5px 0 0;

        color: var(--slate-500);

        font-size: 14px;
    }

    .session-data {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 11px;
    }

    .session-data-card {
        padding: 14px;

        border: 1px solid #EDF2F7;
        border-radius: 13px;

        background: #F8FAFC;
    }

    .session-data-label {
        display: block;

        margin-bottom: 5px;

        color: var(--slate-500);

        font-size: 12px;
        font-weight: 700;
    }

    .session-data-value {
        display: block;

        color: var(--navy-800);

        font-size: 16px;
        font-weight: 850;
    }

    /*
    |--------------------------------------------------------------------------
    | Break
    |--------------------------------------------------------------------------
    */

    .break-divider {
        display: flex;
        align-items: center;

        gap: 13px;

        padding: 2px 4px;
    }

    .break-line {
        height: 1px;
        flex: 1;

        background: var(--slate-200);
    }

    .break-label {
        padding: 7px 12px;

        border-radius: 999px;

        color: var(--slate-600);
        background: var(--slate-100);

        font-size: 12px;
        font-weight: 800;

        white-space: nowrap;
    }

    /*
    |--------------------------------------------------------------------------
    | Photo Evidence
    |--------------------------------------------------------------------------
    */

    .session-evidence {
        margin-top: 20px;
        padding-top: 20px;

        border-top:
            1px solid var(--slate-200);
    }

    .evidence-header {
        display: flex;

        align-items: flex-start;
        justify-content: space-between;

        gap: 14px;

        margin-bottom: 14px;
    }

    .evidence-title {
        margin: 0;

        color: var(--navy-800);

        font-size: 17px;
        font-weight: 850;
    }

    .evidence-description {
        margin: 4px 0 0;

        color: var(--slate-500);

        font-size: 13px;
    }

    .private-badge {
        display: inline-flex;

        align-items: center;

        padding: 7px 10px;

        border-radius: 999px;

        color: #0F766E;
        background: #CCFBF1;

        font-size: 11px;
        font-weight: 850;

        white-space: nowrap;
    }

    .evidence-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 14px;
    }

    .evidence-card {
        display: block;

        overflow: hidden;

        border: 1px solid #DCE5EF;
        border-radius: 16px;

        color: inherit;
        background: #FFFFFF;

        text-decoration: none;

        transition:
            transform .18s ease,
            border-color .18s ease,
            box-shadow .18s ease;
    }

    .evidence-card:hover {
        transform: translateY(-2px);

        border-color: #93C5FD;

        box-shadow:
            0 10px 25px
            rgba(15, 42, 74, .11);
    }

    .evidence-image {
        position: relative;

        overflow: hidden;

        height: 230px;

        background: var(--slate-100);
    }

    .evidence-image img {
        display: block;

        width: 100%;
        height: 100%;

        object-fit: cover;
    }

    .view-photo {
        position: absolute;

        right: 11px;
        bottom: 11px;

        padding: 7px 10px;

        border-radius: 999px;

        color: #FFFFFF;

        background:
            rgba(11, 34, 61, .88);

        font-size: 11px;
        font-weight: 850;
    }

    .evidence-info {
        padding: 14px 15px;
    }

    .evidence-type {
        display: block;

        color: var(--navy-800);

        font-size: 15px;
        font-weight: 850;
    }

    .evidence-time {
        display: block;

        margin-top: 3px;

        color: var(--slate-500);

        font-size: 13px;
    }

    .evidence-empty {
        display: flex;

        align-items: center;
        justify-content: center;

        min-height: 150px;

        padding: 20px;

        border:
            1px dashed
            var(--slate-300);

        border-radius: 15px;

        color: var(--slate-500);
        background: var(--slate-50);

        font-size: 13px;
        font-weight: 700;

        text-align: center;
    }

    /*
    |--------------------------------------------------------------------------
    | Action
    |--------------------------------------------------------------------------
    */

    .action-shell {
        overflow: hidden;

        border: 1px solid #CFE0F5;
        border-radius: 18px;
    }

    .action-heading {
        display: flex;

        align-items: flex-start;

        gap: 15px;

        padding: 22px;

        border-bottom:
            1px solid #DFE8F3;

        background:
            linear-gradient(
                135deg,
                #F8FBFF,
                #EFF6FF
            );
    }

    .action-number {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 50px;
        height: 50px;

        flex: 0 0 50px;

        border-radius: 14px;

        color: #FFFFFF;
        background: #2563EB;

        font-size: 14px;
        font-weight: 900;
    }

    .action-kicker {
        display: block;

        margin-bottom: 4px;

        color: #1D4ED8;

        font-size: 12px;
        font-weight: 850;

        text-transform: uppercase;
    }

    .action-title {
        margin: 0;

        color: var(--navy-800);

        font-size: 23px;
        font-weight: 850;
    }

    .action-subtitle {
        margin: 5px 0 0;

        color: var(--slate-600);

        font-size: 14px;
    }

    .action-body {
        padding: 22px;
    }

    .action-description {
        margin: 0 0 20px;

        color: var(--slate-600);

        font-size: 15px;
    }

    /*
    |--------------------------------------------------------------------------
    | Verification
    |--------------------------------------------------------------------------
    */

    .verification-box {
        padding: 17px;

        border: 1px solid var(--slate-200);
        border-radius: 15px;

        background: var(--slate-50);
    }

    .verification-box + .verification-box {
        margin-top: 14px;
    }

    .verification-header {
        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 12px;

        margin-bottom: 12px;
    }

    .verification-title {
        display: flex;
        align-items: center;

        gap: 10px;

        color: var(--navy-800);

        font-size: 15px;
        font-weight: 850;
    }

    .verification-number {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 30px;
        height: 30px;

        border-radius: 9px;

        color: #1D4ED8;
        background: #DBEAFE;

        font-size: 12px;
        font-weight: 900;
    }

    .required-label {
        color: var(--slate-500);

        font-size: 12px;
        font-weight: 700;
    }

    .gps-button,
    .selfie-label {
        display: flex;

        align-items: center;
        justify-content: center;

        width: 100%;
        min-height: 54px;

        padding: 13px 17px;

        border: 1px solid #BDD0E7;
        border-radius: 13px;

        color: var(--navy-800);
        background: #FFFFFF;

        font-family: inherit;

        font-size: 15px;
        font-weight: 800;

        text-align: center;

        cursor: pointer;
    }

    .gps-button:hover:not(:disabled),
    .selfie-label:hover {
        color: #1D4ED8;

        border-color: #93C5FD;

        background: #EFF6FF;
    }

    .gps-button:disabled {
        opacity: .65;
        cursor: wait;
    }

    .gps-result {
        display: none;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 9px;

        margin-top: 11px;
    }

    .gps-result.visible {
        display: grid;
    }

    .gps-result-card {
        min-width: 0;

        padding: 12px;

        border: 1px solid #BAE6E0;
        border-radius: 11px;

        background: #F0FDFA;
    }

    .gps-result-label {
        display: block;

        margin-bottom: 4px;

        color: #0F766E;

        font-size: 11px;
        font-weight: 850;

        text-transform: uppercase;
    }

    .gps-result-value {
        display: block;

        overflow: hidden;

        color: #134E4A;

        font-size: 13px;
        font-weight: 750;

        text-overflow: ellipsis;
    }

    .gps-error {
        display: none;

        margin-top: 11px;
        padding: 12px 13px;

        border: 1px solid #FECACA;
        border-radius: 11px;

        color: #991B1B;
        background: #FEF2F2;

        font-size: 13px;
        font-weight: 600;
    }

    .gps-error.visible {
        display: block;
    }

    .selfie-input {
        position: absolute;

        width: 1px;
        height: 1px;

        opacity: 0;

        pointer-events: none;
    }

    .selfie-preview {
        display: none;

        align-items: center;

        gap: 14px;

        margin-top: 11px;
        padding: 12px;

        border: 1px solid var(--slate-200);
        border-radius: 13px;

        background: #FFFFFF;
    }

    .selfie-preview.visible {
        display: flex;
    }

    .selfie-preview-image {
        width: 78px;
        height: 78px;

        flex: 0 0 78px;

        object-fit: cover;

        border-radius: 12px;
    }

    .selfie-ready {
        display: block;

        color: #15803D;

        font-size: 14px;
        font-weight: 850;
    }

    .selfie-name {
        display: block;

        max-width: 350px;

        margin-top: 3px;

        overflow: hidden;

        color: var(--slate-500);

        font-size: 13px;

        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .attendance-submit {
        width: 100%;

        min-height: 57px;

        margin-top: 18px;
        padding: 14px 20px;

        border: 0;
        border-radius: 14px;

        color: #FFFFFF;

        background:
            linear-gradient(
                135deg,
                #2563EB,
                #1D4ED8
            );

        box-shadow:
            0 10px 23px
            rgba(37, 99, 235, .22);

        font-family: inherit;

        font-size: 16px;
        font-weight: 850;

        cursor: pointer;
    }

    .attendance-submit:disabled {
        color: #94A3B8;

        background: #E2E8F0;

        box-shadow: none;

        cursor: not-allowed;
    }

    .server-note {
        margin: 14px 0 0;

        color: var(--slate-500);

        font-size: 13px;

        text-align: center;
    }

    /*
    |--------------------------------------------------------------------------
    | Notices
    |--------------------------------------------------------------------------
    */

    .notice {
        padding: 17px 18px;

        border: 1px solid var(--slate-200);
        border-radius: 14px;

        color: var(--slate-600);
        background: var(--slate-50);

        font-size: 14px;
    }

    .notice strong {
        display: block;

        margin-bottom: 4px;

        color: var(--navy-800);

        font-size: 15px;
    }

    .notice-warning {
        color: #854D0E;
        border-color: #FDE68A;
        background: #FFFBEB;
    }

    .notice-success {
        color: #166534;
        border-color: #BBF7D0;
        background: #F0FDF4;
    }

    /*
    |--------------------------------------------------------------------------
    | Detail Lists
    |--------------------------------------------------------------------------
    */

    .detail-list {
        display: grid;
    }

    .detail-row {
        display: flex;

        align-items: flex-start;
        justify-content: space-between;

        gap: 18px;

        padding: 14px 0;

        border-bottom:
            1px solid #EDF2F7;
    }

    .detail-row:first-child {
        padding-top: 0;
    }

    .detail-row:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .detail-label {
        color: var(--slate-500);

        font-size: 13px;
        font-weight: 650;
    }

    .detail-value {
        max-width: 62%;

        color: var(--navy-800);

        font-size: 14px;
        font-weight: 800;

        text-align: right;

        overflow-wrap: anywhere;
    }

    /*
    |--------------------------------------------------------------------------
    | Workflow
    |--------------------------------------------------------------------------
    */

    .workflow-list {
        display: grid;

        margin: 0;
        padding: 0;

        list-style: none;
    }

    .workflow-item {
        position: relative;

        display: flex;

        align-items: flex-start;

        gap: 13px;

        padding-bottom: 20px;
    }

    .workflow-item:last-child {
        padding-bottom: 0;
    }

    .workflow-item:not(:last-child)::after {
        content: '';

        position: absolute;

        top: 37px;
        left: 16px;

        width: 2px;
        height: calc(100% - 24px);

        background: #DCE6F2;
    }

    .workflow-number {
        position: relative;
        z-index: 2;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 34px;
        height: 34px;

        flex: 0 0 34px;

        border-radius: 10px;

        color: #1D4ED8;
        background: #DBEAFE;

        font-size: 12px;
        font-weight: 900;
    }

    .workflow-title {
        display: block;

        color: var(--navy-800);

        font-size: 14px;
        font-weight: 850;
    }

    .workflow-description {
        display: block;

        margin-top: 3px;

        color: var(--slate-500);

        font-size: 13px;
        line-height: 1.55;
    }

    /*
    |--------------------------------------------------------------------------
    | History
    |--------------------------------------------------------------------------
    */

    .history-wrapper {
        overflow-x: auto;
    }

    .history-table {
        width: 100%;
        min-width: 940px;

        border-collapse: collapse;
    }

    .history-table th {
        padding: 13px 14px;

        border-bottom:
            1px solid var(--slate-200);

        color: var(--slate-600);
        background: var(--slate-50);

        font-size: 12px;
        font-weight: 850;

        text-align: left;
        text-transform: uppercase;

        white-space: nowrap;
    }

    .history-table td {
        padding: 16px 14px;

        border-bottom:
            1px solid #EDF2F7;

        color: var(--slate-700);

        font-size: 14px;

        vertical-align: middle;

        white-space: nowrap;
    }

    .history-table tbody tr:hover {
        background: #FAFCFF;
    }

    .history-date,
    .history-hours {
        color: var(--navy-800) !important;
        font-weight: 800;
    }

    .history-evidence {
        display: flex;

        flex-wrap: wrap;

        gap: 7px;

        min-width: 215px;
    }

    .history-photo {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        min-height: 35px;

        padding: 7px 10px;

        border: 1px solid #BFDBFE;
        border-radius: 9px;

        color: #1D4ED8;
        background: #EFF6FF;

        font-size: 12px;
        font-weight: 800;

        text-decoration: none;
    }

    .history-photo:hover {
        color: #FFFFFF;

        border-color: #2563EB;

        background: #2563EB;
    }

    .history-no-photo {
        color: #94A3B8;

        font-size: 12px;
        font-weight: 700;
    }

    .history-empty {
        padding: 34px 15px !important;

        color: var(--slate-500) !important;

        text-align: center;
    }

    .pagination-wrapper {
        margin-top: 20px;
    }

    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1180px) {
        .attendance-layout {
            grid-template-columns: 1fr;
        }

        .attendance-sidebar {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 900px) {
        .assignment-strip {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .daily-overview {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 760px) {
        .attendance-hero {
            padding: 27px 21px;
            border-radius: 20px;
        }

        .hero-content {
            align-items: flex-start;
            flex-direction: column;
        }

        .hero-date {
            width: 100%;
            min-width: 0;
        }

        .attendance-sidebar {
            grid-template-columns: 1fr;
        }

        .session-data {
            grid-template-columns: 1fr;
        }

        .evidence-grid {
            grid-template-columns: 1fr;
        }

        .evidence-image {
            height: 260px;
        }

        .gps-result {
            grid-template-columns: 1fr;
        }

        .card-header,
        .card-body,
        .action-heading,
        .action-body {
            padding-left: 17px;
            padding-right: 17px;
        }
    }

    @media (max-width: 560px) {
        .assignment-strip {
            grid-template-columns: 1fr;
        }

        .assignment-item {
            border-right: 0;

            border-bottom:
                1px solid var(--slate-200);
        }

        .assignment-item:last-child {
            border-bottom: 0;
        }

        .session-top,
        .evidence-header,
        .verification-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .detail-row {
            gap: 6px;
            flex-direction: column;
        }

        .detail-value {
            max-width: 100%;
            text-align: left;
        }
    }

    /* Student selfie: camera + upload/drag-and-drop choices */
    .selfie-choices { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:12px; margin-bottom:14px; }
    .selfie-choice { min-height:56px; display:flex; gap:9px; justify-content:center; align-items:center; padding:12px; border:1px solid #BDD0E7; border-radius:12px; background:white; color:#102A4A; font:inherit; font-weight:800; cursor:pointer; text-align:center; }
    .selfie-choice:hover, .selfie-choice:focus-visible { border-color:#2563EB; background:#EFF6FF; outline:2px solid transparent; }
    .selfie-dropzone { display:flex; flex-direction:column; align-items:center; justify-content:center; min-height:148px; gap:6px; padding:22px; border:2px dashed #9BB4D3; border-radius:14px; background:#F8FBFF; cursor:pointer; text-align:center; }
    .selfie-dropzone:hover, .selfie-dropzone:focus-visible, .selfie-dropzone.is-dragging { border-color:#2563EB; background:#EAF3FF; outline:none; }
    .selfie-dropzone strong { color:#102A4A; font-size:15px; }
    .selfie-dropzone span { color:#64748B; font-size:13px; }
    .selfie-camera { display:none; margin-top:14px; padding:14px; background:#07192D; border-radius:14px; }
    .selfie-camera.visible { display:block; }
    .selfie-video { display:block; width:100%; max-height:350px; aspect-ratio:4/3; object-fit:cover; border-radius:10px; background:#0B223D; }
    .selfie-camera-actions { display:flex; flex-wrap:wrap; gap:10px; margin-top:12px; }
    .selfie-camera-actions button { flex:1; min-height:44px; padding:9px 13px; border:0; border-radius:9px; background:#2563EB; color:#fff; font:inherit; font-size:14px; font-weight:800; cursor:pointer; }
    .selfie-camera-actions .selfie-camera-cancel { color:#102A4A; background:#E2E8F0; }
    .selfie-camera-actions button:disabled { opacity:.6; cursor:not-allowed; }
    .selfie-feedback { display:none; padding:11px 13px; margin-top:12px; border-radius:10px; font-size:13px; }
    .selfie-feedback.visible { display:block; }
    .selfie-feedback.error { background:#FEF2F2; color:#991B1B; border:1px solid #FECACA; }
    .selfie-feedback.info { background:#EFF6FF; color:#1D4ED8; border:1px solid #BFDBFE; }
    @media (max-width:560px) { .selfie-choices { grid-template-columns:1fr; } }
</style>

@endpush


@section('content')

<div class="attendance-page">

    {{-- ===============================================================
         ALERTS
         =============================================================== --}}

    @if (session('success'))

        <div class="attendance-alert attendance-alert-success">

            <span class="alert-symbol">✓</span>

            <div>
                {{ session('success') }}
            </div>

        </div>

    @endif


    @if (session('error'))

        <div class="attendance-alert attendance-alert-error">

            <span class="alert-symbol">!</span>

            <div>
                {{ session('error') }}
            </div>

        </div>

    @endif


    @if ($errors->any())

        <div class="attendance-alert attendance-alert-error">

            <span class="alert-symbol">!</span>

            <div>
                {{ $errors->first() }}
            </div>

        </div>

    @endif


    {{-- ===============================================================
         HERO
         =============================================================== --}}

    <section class="attendance-hero">

        <div class="hero-content">

            <div class="hero-main">

                <div class="hero-eyebrow">

                    <span class="hero-dot"></span>

                    Student OJT Attendance

                </div>


                <h1>
                    GPS Selfie Attendance
                </h1>


                <p class="hero-description">

                    Record your Morning and Afternoon OJT sessions
                    using verified GPS coordinates and selfie evidence.
                    Your Time In and Time Out photos remain available
                    for secure review.

                </p>

            </div>


            <div class="hero-date">

                <span class="hero-date-label">
                    Attendance Date
                </span>

                <span class="hero-date-value">
                    {{ $formatDate($today) }}
                </span>

                <span class="hero-date-zone">
                    Philippine Time
                </span>

            </div>

        </div>

    </section>


    {{-- ===============================================================
         ASSIGNMENT
         =============================================================== --}}

    @if ($activeAssignment)

        <section class="assignment-strip">

            <div class="assignment-item">

                <span class="assignment-label">
                    Training Company
                </span>

                <span class="assignment-value">
                    {{ $activeAssignment->company?->name ?? 'Not available' }}
                </span>

            </div>


            <div class="assignment-item">

                <span class="assignment-label">
                    OJT Supervisor
                </span>

                <span class="assignment-value">
                    {{ $activeAssignment->supervisor?->name ?? 'Not assigned' }}
                </span>

            </div>


            <div class="assignment-item">

                <span class="assignment-label">
                    Required Hours
                </span>

                <span class="assignment-value">

                    {{ number_format(
                        (float) $activeAssignment->required_hours,
                        0
                    ) }}

                    Hours

                </span>

            </div>


            <div class="assignment-item">

                <span class="assignment-label">
                    Assignment Status
                </span>

                <span
                    class="
                        status-pill
                        {{ $assignmentIsActive
                            ? 'status-green'
                            : 'status-orange' }}
                    "
                >

                    <span class="status-dot"></span>

                    {{ ucfirst($activeAssignment->status) }}

                </span>

            </div>

        </section>

    @endif


    <div class="attendance-layout">


        {{-- ===========================================================
             MAIN
             =========================================================== --}}

        <main class="attendance-main">


            {{-- =======================================================
                 TODAY
                 ======================================================= --}}

            <section class="attendance-card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon icon-blue">
                            DAY
                        </div>

                        <div>

                            <h2 class="card-title">
                                Today's Attendance
                            </h2>

                            <p class="card-description">
                                Morning and Afternoon attendance sessions
                            </p>

                        </div>

                    </div>


                    @if ($todayAttendance)

                        <span
                            class="
                                status-pill
                                {{ $statusClass(
                                    $todayAttendance->status
                                ) }}
                            "
                        >

                            <span class="status-dot"></span>

                            {{ $statusLabel(
                                $todayAttendance->status
                            ) }}

                        </span>

                    @endif

                </div>


                <div class="card-body">

                    <div class="daily-overview">

                        <div class="overview-card">

                            <span class="overview-label">
                                Sessions Completed
                            </span>

                            <span class="overview-value">

                                {{ $todaySessions
                                    ->whereNotNull('time_out')
                                    ->count() }}
                                / 2

                            </span>

                        </div>


                        <div class="overview-card">

                            <span class="overview-label">
                                Rendered Today
                            </span>

                            <span class="overview-value">

                                {{ $formatMinutes(
                                    $todayRenderedMinutes
                                ) }}

                            </span>

                        </div>


                        <div class="overview-card">

                            <span class="overview-label">
                                Current State
                            </span>

                            <span class="overview-value">

                                @if ($dayComplete)
                                    Complete
                                @elseif ($openSession)
                                    Working
                                @elseif ($sessionCount > 0)
                                    On Break
                                @else
                                    Not Started
                                @endif

                            </span>

                        </div>

                    </div>


                    @if ($legacyToday)

                        <div class="notice notice-warning">

                            <strong>
                                Previous Attendance Format
                            </strong>

                            Today's record uses the previous
                            attendance format. Its Time In and
                            Time Out photos remain available
                            in Attendance History below.

                        </div>

                    @else

                        <div class="attendance-sessions">


                            {{-- =========================================
                                 MORNING
                                 ========================================= --}}

                            <article
                                class="
                                    session-card
                                    {{ $morningState === 'complete'
                                        ? 'session-complete'
                                        : '' }}
                                    {{ $morningState === 'active'
                                        ? 'session-active'
                                        : '' }}
                                "
                            >

                                <div class="session-top">

                                    <div>

                                        <span class="session-number">
                                            Session 01
                                        </span>

                                        <h3 class="session-title">
                                            Morning Session
                                        </h3>

                                        <p class="session-description">
                                            First attendance period of your OJT day.
                                        </p>

                                    </div>


                                    @if ($morningState === 'complete')

                                        <span class="status-pill status-green">
                                            <span class="status-dot"></span>
                                            Completed
                                        </span>

                                    @elseif ($morningState === 'active')

                                        <span class="status-pill status-blue">
                                            <span class="status-dot"></span>
                                            Currently Working
                                        </span>

                                    @else

                                        <span class="status-pill status-gray">
                                            <span class="status-dot"></span>
                                            Not Started
                                        </span>

                                    @endif

                                </div>


                                <div class="session-data">

                                    <div class="session-data-card">

                                        <span class="session-data-label">
                                            Time In
                                        </span>

                                        <span class="session-data-value">
                                            {{ $formatTime(
                                                $morningSession?->time_in
                                            ) }}
                                        </span>

                                    </div>


                                    <div class="session-data-card">

                                        <span class="session-data-label">
                                            Time Out
                                        </span>

                                        <span class="session-data-value">
                                            {{ $formatTime(
                                                $morningSession?->time_out
                                            ) }}
                                        </span>

                                    </div>


                                    <div class="session-data-card">

                                        <span class="session-data-label">
                                            Rendered Time
                                        </span>

                                        <span class="session-data-value">

                                            {{ $formatMinutes(
                                                $morningSession?->rendered_minutes
                                                ?? 0
                                            ) }}

                                        </span>

                                    </div>

                                </div>


                                @if ($morningSession)

                                    <div class="session-evidence">

                                        <div class="evidence-header">

                                            <div>

                                                <h4 class="evidence-title">
                                                    Morning Attendance Photos
                                                </h4>

                                                <p class="evidence-description">
                                                    Secure selfie evidence from Session 01.
                                                </p>

                                            </div>


                                            <span class="private-badge">
                                                Private Evidence
                                            </span>

                                        </div>


                                        <div class="evidence-grid">


                                            @if ($morningSession->time_in_selfie_path)

                                                <a
                                                    href="{{ route(
                                                        'student.attendance.session-selfie',
                                                        [
                                                            'session' => $morningSession->id,
                                                            'type' => 'time-in',
                                                        ]
                                                    ) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="evidence-card"
                                                >

                                                    <div class="evidence-image">

                                                        <img
                                                            src="{{ route(
                                                                'student.attendance.session-selfie',
                                                                [
                                                                    'session' => $morningSession->id,
                                                                    'type' => 'time-in',
                                                                ]
                                                            ) }}"
                                                            alt="Morning Time In attendance selfie"
                                                            loading="lazy"
                                                        >

                                                        <span class="view-photo">
                                                            View Full Photo
                                                        </span>

                                                    </div>


                                                    <div class="evidence-info">

                                                        <span class="evidence-type">
                                                            Morning Time In Selfie
                                                        </span>

                                                        <span class="evidence-time">
                                                            {{ $formatTime(
                                                                $morningSession->time_in
                                                            ) }}
                                                        </span>

                                                    </div>

                                                </a>

                                            @else

                                                <div class="evidence-empty">
                                                    Morning Time In photo is not available.
                                                </div>

                                            @endif


                                            @if ($morningSession->time_out_selfie_path)

                                                <a
                                                    href="{{ route(
                                                        'student.attendance.session-selfie',
                                                        [
                                                            'session' => $morningSession->id,
                                                            'type' => 'time-out',
                                                        ]
                                                    ) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="evidence-card"
                                                >

                                                    <div class="evidence-image">

                                                        <img
                                                            src="{{ route(
                                                                'student.attendance.session-selfie',
                                                                [
                                                                    'session' => $morningSession->id,
                                                                    'type' => 'time-out',
                                                                ]
                                                            ) }}"
                                                            alt="Morning Time Out attendance selfie"
                                                            loading="lazy"
                                                        >

                                                        <span class="view-photo">
                                                            View Full Photo
                                                        </span>

                                                    </div>


                                                    <div class="evidence-info">

                                                        <span class="evidence-type">
                                                            Morning Time Out Selfie
                                                        </span>

                                                        <span class="evidence-time">
                                                            {{ $formatTime(
                                                                $morningSession->time_out
                                                            ) }}
                                                        </span>

                                                    </div>

                                                </a>

                                            @else

                                                <div class="evidence-empty">

                                                    Morning Time Out photo will
                                                    appear after you finish
                                                    this session.

                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                @endif

                            </article>


                            {{-- =========================================
                                 BREAK
                                 ========================================= --}}

                            <div class="break-divider">

                                <span class="break-line"></span>

                                <span class="break-label">
                                    Lunch / Break · Not Counted
                                </span>

                                <span class="break-line"></span>

                            </div>


                            {{-- =========================================
                                 AFTERNOON
                                 ========================================= --}}

                            <article
                                class="
                                    session-card
                                    {{ $afternoonState === 'complete'
                                        ? 'session-complete'
                                        : '' }}
                                    {{ $afternoonState === 'active'
                                        ? 'session-active'
                                        : '' }}
                                "
                            >

                                <div class="session-top">

                                    <div>

                                        <span class="session-number">
                                            Session 02
                                        </span>

                                        <h3 class="session-title">
                                            Afternoon Session
                                        </h3>

                                        <p class="session-description">
                                            Second attendance period after your break.
                                        </p>

                                    </div>


                                    @if ($afternoonState === 'complete')

                                        <span class="status-pill status-green">
                                            <span class="status-dot"></span>
                                            Completed
                                        </span>

                                    @elseif ($afternoonState === 'active')

                                        <span class="status-pill status-blue">
                                            <span class="status-dot"></span>
                                            Currently Working
                                        </span>

                                    @else

                                        <span class="status-pill status-gray">
                                            <span class="status-dot"></span>
                                            Not Started
                                        </span>

                                    @endif

                                </div>


                                <div class="session-data">

                                    <div class="session-data-card">

                                        <span class="session-data-label">
                                            Time In
                                        </span>

                                        <span class="session-data-value">
                                            {{ $formatTime(
                                                $afternoonSession?->time_in
                                            ) }}
                                        </span>

                                    </div>


                                    <div class="session-data-card">

                                        <span class="session-data-label">
                                            Time Out
                                        </span>

                                        <span class="session-data-value">
                                            {{ $formatTime(
                                                $afternoonSession?->time_out
                                            ) }}
                                        </span>

                                    </div>


                                    <div class="session-data-card">

                                        <span class="session-data-label">
                                            Rendered Time
                                        </span>

                                        <span class="session-data-value">

                                            {{ $formatMinutes(
                                                $afternoonSession?->rendered_minutes
                                                ?? 0
                                            ) }}

                                        </span>

                                    </div>

                                </div>


                                @if ($afternoonSession)

                                    <div class="session-evidence">

                                        <div class="evidence-header">

                                            <div>

                                                <h4 class="evidence-title">
                                                    Afternoon Attendance Photos
                                                </h4>

                                                <p class="evidence-description">
                                                    Secure selfie evidence from Session 02.
                                                </p>

                                            </div>


                                            <span class="private-badge">
                                                Private Evidence
                                            </span>

                                        </div>


                                        <div class="evidence-grid">


                                            @if ($afternoonSession->time_in_selfie_path)

                                                <a
                                                    href="{{ route(
                                                        'student.attendance.session-selfie',
                                                        [
                                                            'session' => $afternoonSession->id,
                                                            'type' => 'time-in',
                                                        ]
                                                    ) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="evidence-card"
                                                >

                                                    <div class="evidence-image">

                                                        <img
                                                            src="{{ route(
                                                                'student.attendance.session-selfie',
                                                                [
                                                                    'session' => $afternoonSession->id,
                                                                    'type' => 'time-in',
                                                                ]
                                                            ) }}"
                                                            alt="Afternoon Time In attendance selfie"
                                                            loading="lazy"
                                                        >

                                                        <span class="view-photo">
                                                            View Full Photo
                                                        </span>

                                                    </div>


                                                    <div class="evidence-info">

                                                        <span class="evidence-type">
                                                            Afternoon Time In Selfie
                                                        </span>

                                                        <span class="evidence-time">
                                                            {{ $formatTime(
                                                                $afternoonSession->time_in
                                                            ) }}
                                                        </span>

                                                    </div>

                                                </a>

                                            @else

                                                <div class="evidence-empty">
                                                    Afternoon Time In photo is not available.
                                                </div>

                                            @endif


                                            @if ($afternoonSession->time_out_selfie_path)

                                                <a
                                                    href="{{ route(
                                                        'student.attendance.session-selfie',
                                                        [
                                                            'session' => $afternoonSession->id,
                                                            'type' => 'time-out',
                                                        ]
                                                    ) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="evidence-card"
                                                >

                                                    <div class="evidence-image">

                                                        <img
                                                            src="{{ route(
                                                                'student.attendance.session-selfie',
                                                                [
                                                                    'session' => $afternoonSession->id,
                                                                    'type' => 'time-out',
                                                                ]
                                                            ) }}"
                                                            alt="Afternoon Time Out attendance selfie"
                                                            loading="lazy"
                                                        >

                                                        <span class="view-photo">
                                                            View Full Photo
                                                        </span>

                                                    </div>


                                                    <div class="evidence-info">

                                                        <span class="evidence-type">
                                                            Afternoon Time Out Selfie
                                                        </span>

                                                        <span class="evidence-time">
                                                            {{ $formatTime(
                                                                $afternoonSession->time_out
                                                            ) }}
                                                        </span>

                                                    </div>

                                                </a>

                                            @else

                                                <div class="evidence-empty">

                                                    Afternoon Time Out photo
                                                    will appear after you
                                                    finish this session.

                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                @endif

                            </article>

                        </div>

                    @endif

                </div>

            </section>


            {{-- =======================================================
                 VERIFICATION
                 ======================================================= --}}

            <section class="attendance-card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon icon-teal">
                            GPS
                        </div>

                        <div>

                            <h2 class="card-title">
                                Attendance Verification
                            </h2>

                            <p class="card-description">
                                GPS location and selfie evidence are required
                            </p>

                        </div>

                    </div>

                </div>


                <div class="card-body">


                    @if (! $profile)

                        <div class="notice notice-warning">

                            <strong>
                                Student Profile Required
                            </strong>

                            Complete your Student Profile before recording attendance.

                        </div>

                    @elseif (! $activeAssignment)

                        <div class="notice notice-warning">

                            <strong>
                                No OJT Assignment
                            </strong>

                            You currently do not have an OJT Assignment.

                        </div>

                    @elseif (! $assignmentIsActive)

                        <div class="notice notice-warning">

                            <strong>
                                Assignment Not Yet Active
                            </strong>

                            Your OJT Assignment must be activated before
                            attendance can be recorded.

                        </div>

                    @elseif ($legacyToday)

                        <div class="notice notice-warning">

                            <strong>
                                Previous Attendance Format
                            </strong>

                            Today's attendance uses the previous workflow.
                            Begin the new two-session attendance process
                            on your next attendance day.

                        </div>

                    @elseif ($dayComplete)

                        <div class="notice notice-success">

                            <strong>
                                Today's Attendance Is Complete
                            </strong>

                            You completed both sessions.

                            Your total rendered time today is

                            <b>
                                {{ $formatMinutes(
                                    $todayRenderedMinutes
                                ) }}.
                            </b>

                            The record is now waiting for Supervisor validation.

                        </div>

                    @elseif ($actionRoute)

                        <div class="action-shell">

                            <div class="action-heading">

                                <span class="action-number">
                                    {{ $actionStep }}
                                </span>


                                <div>

                                    <span class="action-kicker">
                                        Current Attendance Action
                                    </span>

                                    <h3 class="action-title">
                                        {{ $actionTitle }}
                                    </h3>

                                    <p class="action-subtitle">
                                        {{ $actionSubtitle }}
                                    </p>

                                </div>

                            </div>


                            <div class="action-body">

                                <p class="action-description">
                                    {{ $actionDescription }}
                                </p>


                                <form
                                    method="POST"
                                    action="{{ $actionRoute }}"
                                    enctype="multipart/form-data"
                                    class="attendance-verification-form"
                                    data-mode="{{ $actionMode }}"
                                >

                                    @csrf


                                    <div class="verification-box">

                                        <div class="verification-header">

                                            <span class="verification-title">

                                                <span class="verification-number">
                                                    1
                                                </span>

                                                Verify Current GPS Location

                                            </span>


                                            <span class="required-label">
                                                Required
                                            </span>

                                        </div>


                                        <input
                                            type="hidden"
                                            name="latitude"
                                            value="{{ old('latitude') }}"
                                            class="gps-latitude"
                                        >

                                        <input
                                            type="hidden"
                                            name="longitude"
                                            value="{{ old('longitude') }}"
                                            class="gps-longitude"
                                        >

                                        <input
                                            type="hidden"
                                            name="accuracy"
                                            value="{{ old('accuracy') }}"
                                            class="gps-accuracy"
                                        >


                                        <button
                                            type="button"
                                            class="gps-button"
                                        >
                                            Detect My Current Location
                                        </button>


                                        <div class="gps-result">

                                            <div class="gps-result-card">

                                                <span class="gps-result-label">
                                                    Latitude
                                                </span>

                                                <span class="gps-result-value gps-latitude-display">
                                                    —
                                                </span>

                                            </div>


                                            <div class="gps-result-card">

                                                <span class="gps-result-label">
                                                    Longitude
                                                </span>

                                                <span class="gps-result-value gps-longitude-display">
                                                    —
                                                </span>

                                            </div>


                                            <div class="gps-result-card">

                                                <span class="gps-result-label">
                                                    Accuracy
                                                </span>

                                                <span class="gps-result-value gps-accuracy-display">
                                                    —
                                                </span>

                                            </div>

                                        </div>


                                        <div class="gps-error"></div>

                                    </div>


                                    <div class="verification-box">

                                        <div class="verification-header">

                                            <span class="verification-title">

                                                <span class="verification-number">
                                                    2
                                                </span>

                                                Capture Attendance Selfie

                                            </span>


                                            <span class="required-label">
                                                Maximum 5 MB
                                            </span>

                                        </div>


                                        {{-- Two explicit selfie methods, one backend field. --}}
                                        <div class="selfie-choices">
                                            <button type="button" class="selfie-choice selfie-open-camera">📷 Take Selfie with Camera</button>
                                            <button type="button" class="selfie-choice selfie-choose-file">📁 Choose Photo from Device</button>
                                        </div>

                                        <div class="selfie-dropzone" role="button" tabindex="0" aria-label="Drag a selfie image here or click to browse">
                                            <strong>Drag and drop a photo here</strong>
                                            <span>or click this area to browse · JPG, PNG or WebP · Maximum 5 MB</span>
                                        </div>

                                        <input
                                            type="file"
                                            name="selfie"
                                            accept="image/jpeg,image/png,image/webp"
                                            class="selfie-input"
                                            required
                                        >

                                        <div class="selfie-camera" aria-label="Live selfie camera">
                                            <video class="selfie-video" autoplay playsinline muted aria-label="Live front camera preview"></video>
                                            <div class="selfie-camera-actions">
                                                <button type="button" class="selfie-capture">Capture Selfie</button>
                                                <button type="button" class="selfie-camera-cancel">Cancel Camera</button>
                                            </div>
                                        </div>

                                        <p class="selfie-feedback" role="status" aria-live="polite"></p>

                                        <div class="selfie-preview">

                                            <img
                                                src=""
                                                alt="Attendance selfie preview"
                                                class="selfie-preview-image"
                                            >


                                            <div>

                                                <span class="selfie-ready">
                                                    Selfie Ready
                                                </span>

                                                <span class="selfie-name">
                                                    —
                                                </span>

                                            </div>

                                        </div>

                                    </div>


                                    <button
                                        type="submit"
                                        class="attendance-submit"
                                        disabled
                                    >
                                        {{ $actionButton }}
                                    </button>


                                    <p class="server-note">

                                        Official attendance timestamps are
                                        generated by the OJT Sync server.

                                    </p>

                                </form>

                            </div>

                        </div>

                    @endif

                </div>

            </section>


            {{-- =======================================================
                 HISTORY
                 ======================================================= --}}

            <section class="attendance-card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon icon-orange">
                            HIS
                        </div>

                        <div>

                            <h2 class="card-title">
                                Attendance History
                            </h2>

                            <p class="card-description">
                                Review attendance time, photos and validation status
                            </p>

                        </div>

                    </div>

                </div>


                <div class="card-body">

                    <div class="history-wrapper">

                        <table class="history-table">

                            <thead>

                                <tr>

                                    <th>Date</th>

                                    <th>First Time In</th>

                                    <th>Last Time Out</th>

                                    <th>Rendered</th>

                                    <th>Photo Evidence</th>

                                    <th>Status</th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($records as $record)

                                    @php
                                        $recordSessions =
                                            $historySessions->get(
                                                $record->id,
                                                collect()
                                            );
                                    @endphp


                                    <tr>

                                        <td class="history-date">
                                            {{ $formatDate(
                                                $record->attendance_date
                                            ) }}
                                        </td>


                                        <td>
                                            {{ $formatTime(
                                                $record->time_in
                                            ) }}
                                        </td>


                                        <td>
                                            {{ $formatTime(
                                                $record->time_out
                                            ) }}
                                        </td>


                                        <td class="history-hours">
                                            {{ $formatMinutes(
                                                $record->rendered_minutes
                                            ) }}
                                        </td>


                                        <td>

                                            <div class="history-evidence">


                                                {{-- IMPORTANT:
                                                     Keep @foreach on one expression.
                                                --}}

                                                @foreach ($recordSessions as $historySession)

                                                    @if ($historySession->time_in_selfie_path)

                                                        <a
                                                            href="{{ route(
                                                                'student.attendance.session-selfie',
                                                                [
                                                                    'session' => $historySession->id,
                                                                    'type' => 'time-in',
                                                                ]
                                                            ) }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="history-photo"
                                                        >
                                                            S{{ $historySession->session_number }}
                                                            Time In
                                                        </a>

                                                    @endif


                                                    @if ($historySession->time_out_selfie_path)

                                                        <a
                                                            href="{{ route(
                                                                'student.attendance.session-selfie',
                                                                [
                                                                    'session' => $historySession->id,
                                                                    'type' => 'time-out',
                                                                ]
                                                            ) }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="history-photo"
                                                        >
                                                            S{{ $historySession->session_number }}
                                                            Time Out
                                                        </a>

                                                    @endif

                                                @endforeach


                                                @if ($recordSessions->isEmpty())

                                                    @if ($record->time_in_selfie_path)

                                                        <a
                                                            href="{{ route(
                                                                'student.attendance.selfie',
                                                                [
                                                                    'attendance' => $record->id,
                                                                    'type' => 'time-in',
                                                                ]
                                                            ) }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="history-photo"
                                                        >
                                                            Time In
                                                        </a>

                                                    @endif


                                                    @if ($record->time_out_selfie_path)

                                                        <a
                                                            href="{{ route(
                                                                'student.attendance.selfie',
                                                                [
                                                                    'attendance' => $record->id,
                                                                    'type' => 'time-out',
                                                                ]
                                                            ) }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="history-photo"
                                                        >
                                                            Time Out
                                                        </a>

                                                    @endif

                                                @endif


                                                @if (
                                                    $recordSessions->isEmpty()
                                                    && ! $record->time_in_selfie_path
                                                    && ! $record->time_out_selfie_path
                                                )

                                                    <span class="history-no-photo">
                                                        No photos
                                                    </span>

                                                @endif

                                            </div>

                                        </td>


                                        <td>

                                            <span
                                                class="
                                                    status-pill
                                                    {{ $statusClass(
                                                        $record->status
                                                    ) }}
                                                "
                                            >

                                                <span class="status-dot"></span>

                                                {{ $statusLabel(
                                                    $record->status
                                                ) }}

                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="6"
                                            class="history-empty"
                                        >
                                            No attendance records are available yet.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    @if ($records->hasPages())

                        <div class="pagination-wrapper">
                            {{ $records->links() }}
                        </div>

                    @endif

                </div>

            </section>

        </main>


        {{-- ===========================================================
             SIDEBAR
             =========================================================== --}}

        <aside class="attendance-sidebar">


            <section class="attendance-card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon icon-teal">
                            OJT
                        </div>

                        <div>

                            <h2 class="card-title">
                                Current Assignment
                            </h2>

                            <p class="card-description">
                                Your active training placement
                            </p>

                        </div>

                    </div>

                </div>


                <div class="card-body">

                    @if ($activeAssignment)

                        <div class="detail-list">

                            <div class="detail-row">

                                <span class="detail-label">
                                    Company
                                </span>

                                <span class="detail-value">
                                    {{ $activeAssignment->company?->name
                                        ?? 'Not available' }}
                                </span>

                            </div>


                            <div class="detail-row">

                                <span class="detail-label">
                                    Supervisor
                                </span>

                                <span class="detail-value">
                                    {{ $activeAssignment->supervisor?->name
                                        ?? 'Not assigned' }}
                                </span>

                            </div>


                            <div class="detail-row">

                                <span class="detail-label">
                                    Required Hours
                                </span>

                                <span class="detail-value">

                                    {{ number_format(
                                        (float) $activeAssignment->required_hours,
                                        0
                                    ) }}
                                    Hours

                                </span>

                            </div>


                            <div class="detail-row">

                                <span class="detail-label">
                                    Start Date
                                </span>

                                <span class="detail-value">
                                    {{ $formatDate(
                                        $activeAssignment->start_date
                                    ) }}
                                </span>

                            </div>


                            <div class="detail-row">

                                <span class="detail-label">
                                    End Date
                                </span>

                                <span class="detail-value">
                                    {{ $formatDate(
                                        $activeAssignment->end_date
                                    ) }}
                                </span>

                            </div>


                            <div class="detail-row">

                                <span class="detail-label">
                                    Status
                                </span>

                                <span class="detail-value">
                                    {{ ucfirst(
                                        $activeAssignment->status
                                    ) }}
                                </span>

                            </div>

                        </div>

                    @else

                        <div class="notice">

                            <strong>
                                No OJT Assignment
                            </strong>

                            Assignment information will appear here
                            after your placement is assigned.

                        </div>

                    @endif

                </div>

            </section>


            <section class="attendance-card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon icon-blue">
                            TD
                        </div>

                        <div>

                            <h2 class="card-title">
                                Today's Status
                            </h2>

                            <p class="card-description">
                                Current attendance progress
                            </p>

                        </div>

                    </div>

                </div>


                <div class="card-body">

                    <div class="detail-list">

                        <div class="detail-row">

                            <span class="detail-label">
                                Morning Session
                            </span>

                            <span class="detail-value">

                                @if ($morningState === 'complete')
                                    Complete
                                @elseif ($morningState === 'active')
                                    Working
                                @else
                                    Not Started
                                @endif

                            </span>

                        </div>


                        <div class="detail-row">

                            <span class="detail-label">
                                Afternoon Session
                            </span>

                            <span class="detail-value">

                                @if ($afternoonState === 'complete')
                                    Complete
                                @elseif ($afternoonState === 'active')
                                    Working
                                @else
                                    Not Started
                                @endif

                            </span>

                        </div>


                        <div class="detail-row">

                            <span class="detail-label">
                                Completed Sessions
                            </span>

                            <span class="detail-value">

                                {{ $todaySessions
                                    ->whereNotNull('time_out')
                                    ->count() }}

                                of 2

                            </span>

                        </div>


                        <div class="detail-row">

                            <span class="detail-label">
                                Rendered Today
                            </span>

                            <span class="detail-value">
                                {{ $formatMinutes(
                                    $todayRenderedMinutes
                                ) }}
                            </span>

                        </div>

                    </div>

                </div>

            </section>


            <section class="attendance-card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon icon-orange">
                            123
                        </div>

                        <div>

                            <h2 class="card-title">
                                Daily Workflow
                            </h2>

                            <p class="card-description">
                                Normal two-session process
                            </p>

                        </div>

                    </div>

                </div>


                <div class="card-body">

                    <ol class="workflow-list">

                        <li class="workflow-item">

                            <span class="workflow-number">
                                1
                            </span>

                            <div>

                                <span class="workflow-title">
                                    Morning Time In
                                </span>

                                <span class="workflow-description">
                                    Verify GPS and capture your first selfie.
                                </span>

                            </div>

                        </li>


                        <li class="workflow-item">

                            <span class="workflow-number">
                                2
                            </span>

                            <div>

                                <span class="workflow-title">
                                    Morning Time Out
                                </span>

                                <span class="workflow-description">
                                    Finish your first session before your break.
                                </span>

                            </div>

                        </li>


                        <li class="workflow-item">

                            <span class="workflow-number">
                                3
                            </span>

                            <div>

                                <span class="workflow-title">
                                    Afternoon Time In
                                </span>

                                <span class="workflow-description">
                                    Start your second verified session.
                                </span>

                            </div>

                        </li>


                        <li class="workflow-item">

                            <span class="workflow-number">
                                4
                            </span>

                            <div>

                                <span class="workflow-title">
                                    Afternoon Time Out
                                </span>

                                <span class="workflow-description">
                                    Complete your day and submit it for validation.
                                </span>

                            </div>

                        </li>

                    </ol>

                </div>

            </section>


            <section class="attendance-card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon icon-purple">
                            SEC
                        </div>

                        <div>

                            <h2 class="card-title">
                                Evidence Security
                            </h2>

                            <p class="card-description">
                                Attendance photos remain private
                            </p>

                        </div>

                    </div>

                </div>


                <div class="card-body">

                    <div class="notice">

                        <strong>
                            Private Attendance Evidence
                        </strong>

                        Your selfie files are stored privately.
                        OJT Sync verifies the authenticated Student
                        and OJT Assignment before displaying an
                        attendance photo.

                    </div>

                </div>

            </section>

        </aside>

    </div>

</div>

@endsection


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms =
        document.querySelectorAll(
            '.attendance-verification-form'
        );

    forms.forEach(function (form) {
        const gpsButton =
            form.querySelector('.gps-button');

        const latitudeInput =
            form.querySelector('.gps-latitude');

        const longitudeInput =
            form.querySelector('.gps-longitude');

        const accuracyInput =
            form.querySelector('.gps-accuracy');

        const latitudeDisplay =
            form.querySelector('.gps-latitude-display');

        const longitudeDisplay =
            form.querySelector('.gps-longitude-display');

        const accuracyDisplay =
            form.querySelector('.gps-accuracy-display');

        const gpsResult =
            form.querySelector('.gps-result');

        const gpsError =
            form.querySelector('.gps-error');

        const selfieInput =
            form.querySelector('.selfie-input');

        const selfiePreview =
            form.querySelector('.selfie-preview');

        const selfiePreviewImage =
            form.querySelector('.selfie-preview-image');

        const selfieName =
            form.querySelector('.selfie-name');

        const openCameraButton = form.querySelector('.selfie-open-camera');
        const chooseFileButton = form.querySelector('.selfie-choose-file');
        const dropZone = form.querySelector('.selfie-dropzone');
        const cameraBox = form.querySelector('.selfie-camera');
        const cameraVideo = form.querySelector('.selfie-video');
        const captureButton = form.querySelector('.selfie-capture');
        const cancelCameraButton = form.querySelector('.selfie-camera-cancel');
        const selfieFeedback = form.querySelector('.selfie-feedback');

        const submitButton =
            form.querySelector('.attendance-submit');


        let locationReady = false;
        let selfieReady = false;


        function updateSubmitState() {
            if (! submitButton) {
                return;
            }

            submitButton.disabled =
                ! locationReady
                || ! selfieReady;
        }


        /*
        |--------------------------------------------------------------------------
        | Restore GPS After Validation Failure
        |--------------------------------------------------------------------------
        */

        if (
            latitudeInput?.value
            && longitudeInput?.value
            && accuracyInput?.value
        ) {
            locationReady = true;

            if (latitudeDisplay) {
                latitudeDisplay.textContent =
                    Number(latitudeInput.value)
                        .toFixed(6);
            }

            if (longitudeDisplay) {
                longitudeDisplay.textContent =
                    Number(longitudeInput.value)
                        .toFixed(6);
            }

            if (accuracyDisplay) {
                accuracyDisplay.textContent =
                    Number(accuracyInput.value)
                        .toFixed(1)
                    + ' m';
            }

            gpsResult?.classList.add(
                'visible'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | GPS
        |--------------------------------------------------------------------------
        */

        gpsButton?.addEventListener(
            'click',
            function () {
                if (! navigator.geolocation) {
                    if (gpsError) {
                        gpsError.textContent =
                            'Your browser does not support location detection.';

                        gpsError.classList.add(
                            'visible'
                        );
                    }

                    return;
                }


                gpsButton.disabled = true;

                gpsButton.textContent =
                    'Detecting Current Location...';

                gpsError?.classList.remove(
                    'visible'
                );


                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const latitude =
                            position.coords.latitude;

                        const longitude =
                            position.coords.longitude;

                        const accuracy =
                            position.coords.accuracy;


                        latitudeInput.value =
                            latitude;

                        longitudeInput.value =
                            longitude;

                        accuracyInput.value =
                            accuracy;


                        latitudeDisplay.textContent =
                            latitude.toFixed(6);

                        longitudeDisplay.textContent =
                            longitude.toFixed(6);

                        accuracyDisplay.textContent =
                            accuracy.toFixed(1)
                            + ' m';


                        locationReady = true;


                        gpsResult?.classList.add(
                            'visible'
                        );

                        gpsError?.classList.remove(
                            'visible'
                        );


                        gpsButton.disabled = false;

                        gpsButton.textContent =
                            'Location Verified — Refresh GPS';


                        updateSubmitState();
                    },

                    function (error) {
                        let message =
                            'OJT Sync could not detect your current location. Please try again.';

                        if (error.code === 1) {
                            message =
                                'Location permission was denied. Allow location access and try again.';
                        }

                        if (error.code === 2) {
                            message =
                                'Your device could not determine its location. Make sure Location Services are enabled.';
                        }

                        if (error.code === 3) {
                            message =
                                'Location detection timed out. Please try again.';
                        }


                        locationReady = false;


                        gpsResult?.classList.remove(
                            'visible'
                        );


                        if (gpsError) {
                            gpsError.textContent =
                                message;

                            gpsError.classList.add(
                                'visible'
                            );
                        }


                        gpsButton.disabled = false;

                        gpsButton.textContent =
                            'Try Detecting Location Again';


                        updateSubmitState();
                    },

                    {
                        enableHighAccuracy: true,
                        timeout: 15000,
                        maximumAge: 0,
                    }
                );
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Camera / choose file / drag & drop: all send the original "selfie" field.
        |--------------------------------------------------------------------------
        */
        const allowedImageTypes = ['image/jpeg', 'image/png', 'image/webp'];
        const maximumPhotoSize = 5 * 1024 * 1024;
        let cameraStream = null;
        let previewUrl = null;

        function showSelfieMessage(message, kind = 'error') {
            if (! selfieFeedback) return;
            selfieFeedback.textContent = message;
            selfieFeedback.classList.add('visible');
            selfieFeedback.classList.toggle('error', kind === 'error');
            selfieFeedback.classList.toggle('info', kind === 'info');
        }

        function clearSelfieMessage() {
            selfieFeedback?.classList.remove('visible', 'error', 'info');
        }

        function stopCamera() {
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
                cameraStream = null;
            }
            if (cameraVideo) cameraVideo.srcObject = null;
            cameraBox?.classList.remove('visible');
        }

        function clearPhoto() {
            selfieReady = false;
            if (selfieInput) selfieInput.value = '';
            selfiePreview?.classList.remove('visible');
            if (previewUrl) URL.revokeObjectURL(previewUrl);
            previewUrl = null;
            if (selfiePreviewImage) selfiePreviewImage.removeAttribute('src');
            updateSubmitState();
        }

        function displayPhoto(file) {
            if (! file) {
                clearPhoto();
                return false;
            }
            if (! allowedImageTypes.includes(file.type)) {
                clearPhoto();
                showSelfieMessage('Please use a JPG, PNG, or WebP image.');
                return false;
            }
            if (! file.size || file.size > maximumPhotoSize) {
                clearPhoto();
                showSelfieMessage('Your selfie must be a non-empty image smaller than 5 MB.');
                return false;
            }
            if (previewUrl) URL.revokeObjectURL(previewUrl);
            previewUrl = URL.createObjectURL(file);
            if (selfiePreviewImage) selfiePreviewImage.src = previewUrl;
            if (selfieName) selfieName.textContent = file.name;
            selfiePreview?.classList.add('visible');
            selfieReady = true;
            clearSelfieMessage();
            updateSubmitState();
            return true;
        }

        function useFile(file) {
            if (! file) return;
            // The native file input is submitted using multipart/form-data.
            // DataTransfer lets a camera Blob or dropped file use that same input.
            try {
                const transfer = new DataTransfer();
                transfer.items.add(file);
                selfieInput.files = transfer.files;
                if (selfieInput.files.length !== 1) {
                    throw new Error('File input was not updated.');
                }
                displayPhoto(selfieInput.files[0]);
                stopCamera();
            } catch (error) {
                showSelfieMessage('This browser could not attach the photo. Choose a photo from your device instead.');
            }
        }

        selfieInput?.addEventListener('change', function () {
            const file = selfieInput.files?.[0];
            displayPhoto(file);
            if (file) stopCamera();
        });

        function browsePhoto() {
            stopCamera();
            selfieInput?.click();
        }

        chooseFileButton?.addEventListener('click', browsePhoto);
        dropZone?.addEventListener('click', browsePhoto);
        dropZone?.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                browsePhoto();
            }
        });

        ['dragenter', 'dragover'].forEach(name => {
            dropZone?.addEventListener(name, function (event) {
                event.preventDefault();
                event.dataTransfer.dropEffect = 'copy';
                dropZone.classList.add('is-dragging');
            });
        });
        ['dragleave', 'drop'].forEach(name => {
            dropZone?.addEventListener(name, function (event) {
                event.preventDefault();
                dropZone.classList.remove('is-dragging');
            });
        });
        dropZone?.addEventListener('drop', function (event) {
            const files = event.dataTransfer?.files;
            if (! files || files.length !== 1) {
                showSelfieMessage('Please drag exactly one JPG, PNG, or WebP selfie.');
                return;
            }
            useFile(files[0]);
        });

        openCameraButton?.addEventListener('click', async function () {
            clearSelfieMessage();
            stopCamera();
            if (! window.isSecureContext || ! navigator.mediaDevices?.getUserMedia) {
                showSelfieMessage('Live camera is unavailable. Use localhost or HTTPS, or choose a photo from your device.');
                return;
            }
            openCameraButton.disabled = true;
            showSelfieMessage('Requesting camera permission...', 'info');
            try {
                cameraStream = await navigator.mediaDevices.getUserMedia({
                    audio: false,
                    video: { facingMode: 'user' },
                });
                cameraVideo.srcObject = cameraStream;
                cameraBox.classList.add('visible');
                await cameraVideo.play();
                clearSelfieMessage();
            } catch (error) {
                stopCamera();
                showSelfieMessage('Unable to start the camera. Check browser camera permission and make sure another app is not using it. You can still upload a photo.');
            } finally {
                openCameraButton.disabled = false;
            }
        });

        captureButton?.addEventListener('click', function () {
            if (! cameraStream || ! cameraVideo.videoWidth || ! cameraVideo.videoHeight) {
                showSelfieMessage('Camera image is not ready. Please try again.');
                return;
            }
            const canvas = document.createElement('canvas');
            const scale = Math.min(1, 1280 / cameraVideo.videoWidth);
            canvas.width = Math.round(cameraVideo.videoWidth * scale);
            canvas.height = Math.round(cameraVideo.videoHeight * scale);
            const context = canvas.getContext('2d');
            if (! context) {
                showSelfieMessage('Unable to capture camera image.');
                return;
            }
            context.drawImage(cameraVideo, 0, 0, canvas.width, canvas.height);
            captureButton.disabled = true;
            canvas.toBlob(function (blob) {
                captureButton.disabled = false;
                if (! blob) {
                    showSelfieMessage('Could not capture your photo. Please retry.');
                    return;
                }
                const photo = new File(
                    [blob],
                    'ojt-selfie-' + Date.now() + '.jpg',
                    { type: 'image/jpeg' }
                );
                useFile(photo);
            }, 'image/jpeg', 0.88);
        });

        cancelCameraButton?.addEventListener('click', stopCamera);
        window.addEventListener('pagehide', function () {
            stopCamera();
            if (previewUrl) URL.revokeObjectURL(previewUrl);
        }, { once: true });

        /*
        |--------------------------------------------------------------------------
        | Submit
        |--------------------------------------------------------------------------
        */

        form.addEventListener(
            'submit',
            function (event) {
                if (
                    ! locationReady
                    || ! selfieReady
                    || ! selfieInput?.files?.length
                ) {
                    event.preventDefault();

                    alert(
                        'Please verify your GPS location and capture your attendance selfie before submitting.'
                    );

                    return;
                }


                stopCamera();

                if (submitButton) {
                    submitButton.disabled = true;

                    submitButton.textContent =
                        form.dataset.mode === 'time-out'
                            ? 'Recording Time Out...'
                            : 'Recording Time In...';
                }
            }
        );


        updateSubmitState();
    });
});
</script>

@endpush