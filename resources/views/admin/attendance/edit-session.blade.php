@extends('layouts.app')

@section('title', 'Correct Attendance Session | OJT Sync')

@php
    /*
    |--------------------------------------------------------------------------
    | Helpers
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
                ->format('F d, Y · g:i A');
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

        return $remainingMinutes.' min';
    };

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    $profile =
        $assignment?->studentProfile;

    $student =
        $profile?->user;

    $company =
        $assignment?->company;

    $supervisor =
        $assignment?->supervisor;

    /*
    |--------------------------------------------------------------------------
    | Original Form Values
    |--------------------------------------------------------------------------
    */

    $currentTimeIn = '';

    if ($session->time_in) {
        try {
            $currentTimeIn =
                \Carbon\Carbon::parse(
                    $session->time_in
                )
                    ->timezone('Asia/Manila')
                    ->format('H:i');
        } catch (\Throwable $exception) {
            $currentTimeIn = '';
        }
    }

    $currentTimeOut = '';

    if ($session->time_out) {
        try {
            $currentTimeOut =
                \Carbon\Carbon::parse(
                    $session->time_out
                )
                    ->timezone('Asia/Manila')
                    ->format('H:i');
        } catch (\Throwable $exception) {
            $currentTimeOut = '';
        }
    }

    $studentName =
        $student?->name
        ?? 'Unknown Student';

    $studentNumber =
        $profile?->student_number
        ?? 'No Student Number';

    $sessionLabel =
        $session->sessionLabel();

    $isMorning =
        (int) $session->session_number
        ===
        \App\Models\AttendanceSession::MORNING_SESSION;
@endphp


@push('styles')

<style>
    /*
    |--------------------------------------------------------------------------
    | Admin Attendance Correction
    |--------------------------------------------------------------------------
    */

    .attendance-correction-page {
        --navy-950: #07192D;
        --navy-900: #0B223D;
        --navy-800: #102A4A;
        --navy-700: #183B6B;

        --blue-700: #1D4ED8;
        --blue-600: #2563EB;
        --blue-100: #DBEAFE;
        --blue-50: #EFF6FF;

        --teal-800: #115E59;
        --teal-700: #0F766E;
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

        width: 100%;
        max-width: 1450px;

        margin: 0 auto;
        padding: 8px 0 65px;

        color: var(--slate-800);

        font-family:
            "Segoe UI",
            Inter,
            Arial,
            sans-serif;

        font-size: 17px;
        line-height: 1.68;
    }

    .attendance-correction-page *,
    .attendance-correction-page *::before,
    .attendance-correction-page *::after {
        box-sizing: border-box;
    }

    .attendance-correction-page input,
    .attendance-correction-page textarea,
    .attendance-correction-page button,
    .attendance-correction-page a {
        font-family: inherit;
    }

    .attendance-correction-page a:focus-visible,
    .attendance-correction-page input:focus-visible,
    .attendance-correction-page textarea:focus-visible,
    .attendance-correction-page button:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .28);
        outline-offset: 3px;
    }


    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */

    .correction-navigation {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-bottom: 18px;
    }

    .correction-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-height: 48px;

        padding: 10px 16px;

        border: 1px solid #CBD5E1;
        border-radius: 12px;

        color: var(--navy-800);
        background: #FFFFFF;

        font-size: 14px;
        font-weight: 850;

        text-decoration: none;
    }

    .correction-back:hover {
        color: var(--blue-700);
        border-color: #93C5FD;
        background: var(--blue-50);
    }

    .correction-session-id {
        color: var(--slate-500);

        font-size: 13px;
        font-weight: 750;
    }


    /*
    |--------------------------------------------------------------------------
    | Error
    |--------------------------------------------------------------------------
    */

    .correction-alert {
        display: flex;
        align-items: flex-start;

        gap: 14px;

        margin-bottom: 22px;
        padding: 17px 19px;

        border: 1px solid #FECACA;
        border-radius: 16px;

        color: var(--red-800);
        background: var(--red-50);

        font-size: 15px;
        font-weight: 700;
    }

    .correction-alert-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 30px;
        height: 30px;

        flex: 0 0 30px;

        border-radius: 9px;

        color: #FFFFFF;
        background: var(--red-700);

        font-size: 12px;
        font-weight: 900;
    }


    /*
    |--------------------------------------------------------------------------
    | Hero
    |--------------------------------------------------------------------------
    */

    .correction-hero {
        position: relative;
        overflow: hidden;

        margin-bottom: 24px;
        padding: 38px 40px;

        border-radius: 26px;

        color: #FFFFFF;

        background:
            radial-gradient(
                circle at 90% 10%,
                rgba(45, 212, 191, .22),
                transparent 27%
            ),
            radial-gradient(
                circle at 72% 110%,
                rgba(59, 130, 246, .14),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #0B223D 0%,
                #183B6B 58%,
                #17656B 115%
            );

        box-shadow:
            0 22px 48px
            rgba(11, 34, 61, .16);
    }

    .correction-hero-inner {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 30px;
    }

    .correction-hero-copy {
        max-width: 820px;
    }

    .correction-eyebrow {
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

        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .correction-eyebrow-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background: #5EEAD4;
    }

    .correction-hero h1 {
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

    .correction-hero-description {
        max-width: 790px;

        margin: 14px 0 0;

        color:
            rgba(255, 255, 255, .84);

        font-size: 17px;
        line-height: 1.76;
    }

    .correction-hero-session {
        width: 270px;
        flex: 0 0 270px;

        padding: 20px;

        border:
            1px solid
            rgba(255, 255, 255, .16);

        border-radius: 18px;

        background:
            rgba(255, 255, 255, .10);
    }

    .hero-session-label {
        display: block;

        color:
            rgba(255, 255, 255, .67);

        font-size: 11px;
        font-weight: 850;

        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .hero-session-title {
        display: block;

        margin-top: 5px;

        color: #FFFFFF;

        font-size: 23px;
        font-weight: 900;
    }

    .hero-session-date {
        display: block;

        margin-top: 7px;

        color:
            rgba(255, 255, 255, .77);

        font-size: 14px;
    }


    /*
    |--------------------------------------------------------------------------
    | Critical Warning
    |--------------------------------------------------------------------------
    */

    .correction-warning {
        display: flex;
        align-items: flex-start;

        gap: 15px;

        margin-bottom: 24px;
        padding: 19px 21px;

        border: 1px solid #FED7AA;
        border-radius: 17px;

        background:
            linear-gradient(
                135deg,
                #FFFCF8,
                #FFF7ED
            );
    }

    .correction-warning-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 48px;
        height: 48px;

        flex: 0 0 48px;

        border-radius: 14px;

        color: var(--orange-800);
        background: var(--orange-100);

        font-size: 13px;
        font-weight: 900;
    }

    .correction-warning strong {
        display: block;

        margin-bottom: 4px;

        color: var(--navy-800);

        font-size: 17px;
        font-weight: 900;
    }

    .correction-warning p {
        margin: 0;

        color: var(--slate-600);

        font-size: 15px;
        line-height: 1.7;
    }


    /*
    |--------------------------------------------------------------------------
    | Summary
    |--------------------------------------------------------------------------
    */

    .correction-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 15px;

        margin-bottom: 24px;
    }

    .correction-summary-card {
        padding: 20px;

        border: 1px solid var(--slate-200);
        border-radius: 18px;

        background: #FFFFFF;

        box-shadow:
            0 7px 24px
            rgba(15, 42, 74, .045);
    }

    .correction-summary-label {
        display: block;

        color: var(--slate-500);

        font-size: 13px;
        font-weight: 750;
    }

    .correction-summary-value {
        display: block;

        margin-top: 4px;

        color: var(--navy-800);

        font-size: 21px;
        line-height: 1.35;
        font-weight: 900;

        overflow-wrap: anywhere;
    }

    .correction-summary-note {
        display: block;

        margin-top: 6px;

        color: var(--slate-500);

        font-size: 12px;
        line-height: 1.5;
    }


    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    */

    .correction-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1.35fr)
            minmax(320px, .65fr);

        gap: 22px;

        align-items: start;
    }


    /*
    |--------------------------------------------------------------------------
    | Cards
    |--------------------------------------------------------------------------
    */

    .correction-card {
        overflow: hidden;

        border: 1px solid var(--slate-200);
        border-radius: 20px;

        background: #FFFFFF;

        box-shadow:
            0 8px 28px
            rgba(15, 42, 74, .05);
    }

    .correction-card + .correction-card {
        margin-top: 21px;
    }

    .correction-card-header {
        padding: 21px 23px;

        border-bottom:
            1px solid #EDF2F7;

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FBFDFF
            );
    }

    .correction-card-header h2 {
        margin: 0;

        color: var(--navy-800);

        font-size: 22px;
        line-height: 1.35;
        font-weight: 900;
    }

    .correction-card-header p {
        margin: 4px 0 0;

        color: var(--slate-500);

        font-size: 14px;
        line-height: 1.55;
    }

    .correction-card-body {
        padding: 23px;
    }


    /*
    |--------------------------------------------------------------------------
    | Before / Current Attendance
    |--------------------------------------------------------------------------
    */

    .current-time-grid {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 11px;
    }

    .current-time-box {
        padding: 15px;

        border: 1px solid #E4ECF4;
        border-radius: 13px;

        background: var(--slate-50);
    }

    .current-time-label {
        display: block;

        margin-bottom: 5px;

        color: var(--slate-500);

        font-size: 12px;
        font-weight: 750;
    }

    .current-time-value {
        display: block;

        color: var(--navy-800);

        font-size: 19px;
        line-height: 1.35;
        font-weight: 900;
    }


    /*
    |--------------------------------------------------------------------------
    | Form
    |--------------------------------------------------------------------------
    */

    .correction-form-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 16px;

        margin-bottom: 18px;
    }

    .correction-field {
        display: grid;

        gap: 8px;
    }

    .correction-field-full {
        grid-column: 1 / -1;
    }

    .correction-label {
        color: var(--navy-800);

        font-size: 15px;
        font-weight: 850;
    }

    .correction-required {
        color: var(--red-700);

        font-size: 12px;
        font-weight: 800;
    }

    .correction-input,
    .correction-textarea {
        width: 100%;

        border: 1px solid #C8D6E5;
        border-radius: 12px;

        outline: none;

        color: var(--slate-800);
        background: #FBFDFF;

        font-size: 16px;
        font-weight: 650;

        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            background .18s ease;
    }

    .correction-input {
        min-height: 56px;
        padding: 0 14px;
    }

    .correction-textarea {
        min-height: 160px;

        padding: 14px 15px;

        resize: vertical;

        line-height: 1.6;
    }

    .correction-input:focus,
    .correction-textarea:focus {
        border-color: var(--blue-600);

        background: #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, .08);
    }

    .correction-help {
        color: var(--slate-500);

        font-size: 12px;
        line-height: 1.55;
    }

    .field-error {
        color: var(--red-700);

        font-size: 13px;
        font-weight: 700;
    }


    /*
    |--------------------------------------------------------------------------
    | Form Notice
    |--------------------------------------------------------------------------
    */

    .form-impact {
        margin-top: 18px;
        padding: 16px;

        border: 1px solid #BFDBFE;
        border-radius: 14px;

        color: var(--slate-700);
        background: var(--blue-50);

        font-size: 14px;
        line-height: 1.7;
    }

    .form-impact strong {
        color: var(--blue-700);
    }


    /*
    |--------------------------------------------------------------------------
    | Buttons
    |--------------------------------------------------------------------------
    */

    .correction-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 11px;

        margin-top: 20px;
        padding-top: 19px;

        border-top:
            1px solid #EDF2F7;
    }

    .correction-cancel,
    .correction-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-height: 52px;

        padding: 11px 18px;

        border-radius: 12px;

        font-size: 15px;
        font-weight: 900;

        text-decoration: none;
    }

    .correction-cancel {
        border: 1px solid #C8D6E5;

        color: var(--navy-800);
        background: #FFFFFF;
    }

    .correction-cancel:hover {
        color: var(--blue-700);
        background: var(--blue-50);
        border-color: #93C5FD;
    }

    .correction-save {
        border: 0;

        color: #FFFFFF;

        background:
            linear-gradient(
                135deg,
                #2563EB,
                #1D4ED8
            );

        box-shadow:
            0 9px 20px
            rgba(37, 99, 235, .20);

        cursor: pointer;
    }

    .correction-save:hover {
        transform: translateY(-1px);
    }


    /*
    |--------------------------------------------------------------------------
    | Student Details
    |--------------------------------------------------------------------------
    */

    .student-banner {
        display: flex;
        align-items: center;

        gap: 14px;

        margin-bottom: 17px;
        padding: 15px;

        border: 1px solid #E2EAF3;
        border-radius: 14px;

        background: var(--slate-50);
    }

    .student-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 52px;
        height: 52px;

        flex: 0 0 52px;

        border-radius: 15px;

        color: var(--teal-800);
        background: var(--teal-100);

        font-size: 13px;
        font-weight: 900;
    }

    .student-name {
        display: block;

        color: var(--navy-800);

        font-size: 18px;
        font-weight: 900;
    }

    .student-number {
        display: block;

        margin-top: 3px;

        color: var(--slate-500);

        font-size: 13px;
    }

    .detail-list {
        display: grid;
    }

    .detail-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 18px;

        padding: 13px 0;

        border-bottom:
            1px solid #EDF2F7;
    }

    .detail-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .detail-label {
        color: var(--slate-500);

        font-size: 13px;
        font-weight: 700;
    }

    .detail-value {
        max-width: 65%;

        color: var(--navy-800);

        font-size: 14px;
        font-weight: 850;

        text-align: right;

        overflow-wrap: anywhere;
    }


    /*
    |--------------------------------------------------------------------------
    | GPS
    |--------------------------------------------------------------------------
    */

    .gps-box {
        padding: 15px;

        border: 1px solid #CFE6E0;
        border-radius: 13px;

        background: var(--teal-50);
    }

    .gps-box + .gps-box {
        margin-top: 11px;
    }

    .gps-title {
        display: block;

        margin-bottom: 8px;

        color: var(--teal-800);

        font-size: 14px;
        font-weight: 900;
    }

    .gps-row {
        display: flex;
        justify-content: space-between;

        gap: 12px;

        margin-top: 5px;

        color: var(--slate-600);

        font-size: 12px;
    }

    .gps-row strong {
        color: var(--navy-800);
    }


    /*
    |--------------------------------------------------------------------------
    | History
    |--------------------------------------------------------------------------
    */

    .history-list {
        display: grid;

        gap: 12px;
    }

    .history-item {
        padding: 16px;

        border: 1px solid #DDD6FE;
        border-radius: 14px;

        background: var(--purple-50);
    }

    .history-title {
        color: var(--purple-700);

        font-size: 15px;
        font-weight: 900;
    }

    .history-meta {
        margin-top: 4px;

        color: var(--slate-500);

        font-size: 12px;
    }

    .history-times {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 8px;

        margin-top: 11px;
    }

    .history-time {
        padding: 10px;

        border-radius: 10px;

        background: #FFFFFF;
    }

    .history-time span {
        display: block;

        color: var(--slate-500);

        font-size: 10px;
        font-weight: 700;
    }

    .history-time strong {
        display: block;

        margin-top: 3px;

        color: var(--navy-800);

        font-size: 13px;
    }

    .history-reason {
        margin-top: 10px;
        padding: 10px;

        border-radius: 10px;

        color: var(--slate-700);
        background: #FFFFFF;

        font-size: 12px;
        line-height: 1.6;
    }

    .history-empty {
        padding: 22px;

        color: var(--slate-500);

        font-size: 14px;
        line-height: 1.65;

        text-align: center;
    }


    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1150px) {
        .correction-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .correction-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 760px) {
        .attendance-correction-page {
            font-size: 16px;
        }

        .correction-hero {
            padding: 28px 21px;
            border-radius: 21px;
        }

        .correction-hero-inner {
            align-items: flex-start;
            flex-direction: column;
        }

        .correction-hero-session {
            width: 100%;
            flex: 0 0 auto;
        }

        .correction-summary-grid {
            grid-template-columns: 1fr;
        }

        .current-time-grid {
            grid-template-columns: 1fr;
        }

        .correction-form-grid {
            grid-template-columns: 1fr;
        }

        .correction-field-full {
            grid-column: auto;
        }

        .correction-actions {
            align-items: stretch;
            flex-direction: column-reverse;
        }

        .correction-cancel,
        .correction-save {
            width: 100%;
        }
    }

    @media (max-width: 560px) {
        .correction-navigation {
            align-items: flex-start;
            flex-direction: column;
        }

        .correction-card-header,
        .correction-card-body {
            padding-left: 16px;
            padding-right: 16px;
        }

        .detail-row {
            flex-direction: column;

            gap: 4px;
        }

        .detail-value {
            max-width: 100%;
            text-align: left;
        }

        .history-times {
            grid-template-columns: 1fr;
        }

        .correction-warning {
            flex-direction: column;
        }
    }
</style>

@endpush


@section('content')

<div class="attendance-correction-page">


    {{-- ===============================================================
         NAVIGATION
         =============================================================== --}}

    <div class="correction-navigation">

        <a
            href="{{ route(
                'admin.attendance.show',
                $attendance
            ) }}"
            class="correction-back"
        >
            ← Back to Attendance Details
        </a>

        <span class="correction-session-id">
            Session #{{ $session->id }}
        </span>

    </div>


    {{-- ===============================================================
         VALIDATION ERRORS
         =============================================================== --}}

    @if ($errors->any())

        <div class="correction-alert">

            <span class="correction-alert-icon">
                !
            </span>

            <div>

                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach

            </div>

        </div>

    @endif


    {{-- ===============================================================
         HERO
         =============================================================== --}}

    <section class="correction-hero">

        <div class="correction-hero-inner">


            <div class="correction-hero-copy">

                <div class="correction-eyebrow">

                    <span class="correction-eyebrow-dot"></span>

                    Administrator Portal · Attendance Correction

                </div>


                <h1>
                    Correct Attendance Session
                </h1>


                <p class="correction-hero-description">

                    Correct an inaccurate Time In or Time Out
                    while preserving the original GPS and selfie
                    evidence. OJT Sync will automatically recalculate
                    the rendered time and create a permanent
                    correction-history record.

                </p>

            </div>


            <div class="correction-hero-session">

                <span class="hero-session-label">
                    Session Being Corrected
                </span>

                <span class="hero-session-title">
                    {{ $sessionLabel }}
                </span>

                <span class="hero-session-date">

                    {{ $formatDate(
                        $attendance->attendance_date
                    ) }}

                </span>

            </div>


        </div>

    </section>


    {{-- ===============================================================
         IMPORTANT WARNING
         =============================================================== --}}

    <section class="correction-warning">

        <div class="correction-warning-icon">
            !
        </div>

        <div>

            <strong>
                This action changes official attendance timestamps.
            </strong>

            <p>

                Use this feature only for legitimate attendance
                corrections. The original GPS coordinates and selfie
                evidence are not modified. After saving, this daily
                attendance record will return to

                <strong>
                    Pending Review
                </strong>

                so the assigned Supervisor can validate the corrected
                timestamps again.

            </p>

        </div>

    </section>


    {{-- ===============================================================
         SUMMARY
         =============================================================== --}}

    <section class="correction-summary-grid">


        <article class="correction-summary-card">

            <span class="correction-summary-label">
                Student
            </span>

            <span class="correction-summary-value">
                {{ $studentName }}
            </span>

            <span class="correction-summary-note">
                {{ $studentNumber }}
            </span>

        </article>


        <article class="correction-summary-card">

            <span class="correction-summary-label">
                Attendance Date
            </span>

            <span class="correction-summary-value">

                {{ $formatDate(
                    $attendance->attendance_date
                ) }}

            </span>

            <span class="correction-summary-note">
                Asia / Manila
            </span>

        </article>


        <article class="correction-summary-card">

            <span class="correction-summary-label">
                Current Session
            </span>

            <span class="correction-summary-value">
                {{ $sessionLabel }}
            </span>

            <span class="correction-summary-note">

                Session
                {{ $session->session_number }}

            </span>

        </article>


        <article class="correction-summary-card">

            <span class="correction-summary-label">
                Current Rendered Time
            </span>

            <span class="correction-summary-value">

                {{ $formatMinutes(
                    $session->rendered_minutes
                ) }}

            </span>

            <span class="correction-summary-note">
                Recalculated after saving
            </span>

        </article>


    </section>


    {{-- ===============================================================
         MAIN LAYOUT
         =============================================================== --}}

    <div class="correction-layout">


        {{-- ===========================================================
             LEFT
             =========================================================== --}}

        <main>


            {{-- =======================================================
                 CURRENT VALUES
                 ======================================================= --}}

            <section class="correction-card">

                <div class="correction-card-header">

                    <h2>
                        Current Attendance Values
                    </h2>

                    <p>
                        These are the timestamps currently stored for this session.
                    </p>

                </div>


                <div class="correction-card-body">


                    <div class="current-time-grid">


                        <div class="current-time-box">

                            <span class="current-time-label">
                                Current Time In
                            </span>

                            <span class="current-time-value">

                                {{ $formatTime(
                                    $session->time_in
                                ) }}

                            </span>

                        </div>


                        <div class="current-time-box">

                            <span class="current-time-label">
                                Current Time Out
                            </span>

                            <span class="current-time-value">

                                {{ $formatTime(
                                    $session->time_out
                                ) }}

                            </span>

                        </div>


                        <div class="current-time-box">

                            <span class="current-time-label">
                                Current Rendered Time
                            </span>

                            <span class="current-time-value">

                                {{ $formatMinutes(
                                    $session->rendered_minutes
                                ) }}

                            </span>

                        </div>


                    </div>


                </div>

            </section>


            {{-- =======================================================
                 CORRECTION FORM
                 ======================================================= --}}

            <section class="correction-card">

                <div class="correction-card-header">

                    <h2>
                        Enter Corrected Attendance
                    </h2>

                    <p>

                        Change only the incorrect timestamp values.
                        Rendered minutes will be calculated automatically.

                    </p>

                </div>


                <div class="correction-card-body">


                    <form
                        method="POST"
                        action="{{ route(
                            'admin.attendance.sessions.update',
                            $session
                        ) }}"
                    >

                        @csrf
                        @method('PUT')


                        <div class="correction-form-grid">


                            {{-- TIME IN --}}

                            <div class="correction-field">

                                <label
                                    for="correctedTimeIn"
                                    class="correction-label"
                                >
                                    Corrected Time In

                                    <span class="correction-required">
                                        Required
                                    </span>
                                </label>


                                <input
                                    type="time"
                                    id="correctedTimeIn"
                                    name="time_in"
                                    class="correction-input"
                                    value="{{ old(
                                        'time_in',
                                        $currentTimeIn
                                    ) }}"
                                    required
                                >


                                <span class="correction-help">

                                    Current value:
                                    {{ $formatTime(
                                        $session->time_in
                                    ) }}

                                </span>


                                @error('time_in')

                                    <span class="field-error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            {{-- TIME OUT --}}

                            <div class="correction-field">

                                <label
                                    for="correctedTimeOut"
                                    class="correction-label"
                                >
                                    Corrected Time Out

                                    <span class="correction-required">
                                        Required
                                    </span>
                                </label>


                                <input
                                    type="time"
                                    id="correctedTimeOut"
                                    name="time_out"
                                    class="correction-input"
                                    value="{{ old(
                                        'time_out',
                                        $currentTimeOut
                                    ) }}"
                                    required
                                >


                                <span class="correction-help">

                                    Current value:
                                    {{ $formatTime(
                                        $session->time_out
                                    ) }}

                                </span>


                                @error('time_out')

                                    <span class="field-error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            {{-- REASON --}}

                            <div class="correction-field correction-field-full">

                                <label
                                    for="correctionReason"
                                    class="correction-label"
                                >
                                    Correction Reason

                                    <span class="correction-required">
                                        Required
                                    </span>
                                </label>


                                <textarea
                                    id="correctionReason"
                                    name="reason"
                                    class="correction-textarea"
                                    minlength="10"
                                    maxlength="2000"
                                    required
                                    placeholder="Explain why this attendance timestamp must be corrected. Example: Student encountered a GPS delay during Time In and the Supervisor confirmed the actual arrival time."
                                >{{ old('reason') }}</textarea>


                                <span class="correction-help">

                                    Minimum 10 characters.
                                    This reason becomes part of the permanent
                                    administrative correction history.

                                </span>


                                @error('reason')

                                    <span class="field-error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                        </div>


                        <div class="form-impact">

                            <strong>
                                What happens after you save:
                            </strong>

                            OJT Sync recalculates this session,
                            recalculates the entire daily rendered total,
                            records the original and corrected values,
                            records your Administrator account and
                            correction reason, and returns the attendance
                            to Pending Review.

                        </div>


                        <div class="correction-actions">


                            <a
                                href="{{ route(
                                    'admin.attendance.show',
                                    $attendance
                                ) }}"
                                class="correction-cancel"
                            >
                                Cancel
                            </a>


                            <button
                                type="submit"
                                class="correction-save"
                                onclick="
                                    return confirm(
                                        'Save this administrative attendance correction? The attendance will return to Pending Review for Supervisor validation.'
                                    );
                                "
                            >
                                Save Attendance Correction
                            </button>


                        </div>


                    </form>


                </div>

            </section>


        </main>


        {{-- ===========================================================
             RIGHT SIDEBAR
             =========================================================== --}}

        <aside>


            {{-- STUDENT / ASSIGNMENT --}}

            <section class="correction-card">

                <div class="correction-card-header">

                    <h2>
                        Attendance Context
                    </h2>

                    <p>
                        Student and assignment information
                    </p>

                </div>


                <div class="correction-card-body">


                    <div class="student-banner">

                        <div class="student-avatar">
                            ST
                        </div>

                        <div>

                            <span class="student-name">
                                {{ $studentName }}
                            </span>

                            <span class="student-number">
                                {{ $studentNumber }}
                            </span>

                        </div>

                    </div>


                    <div class="detail-list">


                        <div class="detail-row">

                            <span class="detail-label">
                                Program
                            </span>

                            <span class="detail-value">
                                {{ $profile?->program ?? '—' }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <span class="detail-label">
                                Company
                            </span>

                            <span class="detail-value">
                                {{ $company?->name ?? '—' }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <span class="detail-label">
                                Supervisor
                            </span>

                            <span class="detail-value">
                                {{ $supervisor?->name ?? '—' }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <span class="detail-label">
                                Required Hours
                            </span>

                            <span class="detail-value">

                                {{ number_format(
                                    (float) ($assignment?->required_hours ?? 0),
                                    0
                                ) }}
                                hrs

                            </span>

                        </div>


                        <div class="detail-row">

                            <span class="detail-label">
                                Assignment Status
                            </span>

                            <span class="detail-value">

                                {{ ucfirst(
                                    (string) ($assignment?->status ?? 'unknown')
                                ) }}

                            </span>

                        </div>


                    </div>


                </div>

            </section>


            {{-- GPS EVIDENCE --}}

            <section class="correction-card">

                <div class="correction-card-header">

                    <h2>
                        Original GPS Evidence
                    </h2>

                    <p>
                        These values will not be changed
                    </p>

                </div>


                <div class="correction-card-body">


                    <div class="gps-box">

                        <span class="gps-title">
                            Time In Location
                        </span>


                        <div class="gps-row">

                            <span>
                                Latitude
                            </span>

                            <strong>
                                {{ $session->time_in_latitude ?? '—' }}
                            </strong>

                        </div>


                        <div class="gps-row">

                            <span>
                                Longitude
                            </span>

                            <strong>
                                {{ $session->time_in_longitude ?? '—' }}
                            </strong>

                        </div>


                        <div class="gps-row">

                            <span>
                                Accuracy
                            </span>

                            <strong>

                                @if ($session->time_in_accuracy !== null)

                                    {{ number_format(
                                        (float) $session->time_in_accuracy,
                                        1
                                    ) }}
                                    m

                                @else
                                    —
                                @endif

                            </strong>

                        </div>


                    </div>


                    <div class="gps-box">

                        <span class="gps-title">
                            Time Out Location
                        </span>


                        <div class="gps-row">

                            <span>
                                Latitude
                            </span>

                            <strong>
                                {{ $session->time_out_latitude ?? '—' }}
                            </strong>

                        </div>


                        <div class="gps-row">

                            <span>
                                Longitude
                            </span>

                            <strong>
                                {{ $session->time_out_longitude ?? '—' }}
                            </strong>

                        </div>


                        <div class="gps-row">

                            <span>
                                Accuracy
                            </span>

                            <strong>

                                @if ($session->time_out_accuracy !== null)

                                    {{ number_format(
                                        (float) $session->time_out_accuracy,
                                        1
                                    ) }}
                                    m

                                @else
                                    —
                                @endif

                            </strong>

                        </div>


                    </div>


                </div>

            </section>


            {{-- CORRECTION HISTORY --}}

            <section class="correction-card">

                <div class="correction-card-header">

                    <h2>
                        Session Correction History
                    </h2>

                    <p>
                        Previous administrative changes
                    </p>

                </div>


                <div class="correction-card-body">


                    @if ($correctionHistory->isNotEmpty())


                        <div class="history-list">


                            @foreach ($correctionHistory as $correction)


                                <article class="history-item">


                                    <div class="history-title">
                                        Attendance Corrected
                                    </div>


                                    <div class="history-meta">

                                        {{ $correction->correctedBy?->name
                                            ?? 'Administrator' }}

                                        ·

                                        {{ $formatDateTime(
                                            $correction->created_at
                                        ) }}

                                    </div>


                                    <div class="history-times">


                                        <div class="history-time">

                                            <span>
                                                Original
                                            </span>

                                            <strong>

                                                {{ $formatTime(
                                                    $correction->original_time_in
                                                ) }}

                                                →

                                                {{ $formatTime(
                                                    $correction->original_time_out
                                                ) }}

                                            </strong>

                                        </div>


                                        <div class="history-time">

                                            <span>
                                                Corrected
                                            </span>

                                            <strong>

                                                {{ $formatTime(
                                                    $correction->corrected_time_in
                                                ) }}

                                                →

                                                {{ $formatTime(
                                                    $correction->corrected_time_out
                                                ) }}

                                            </strong>

                                        </div>


                                    </div>


                                    <div class="history-reason">

                                        <strong>
                                            Reason:
                                        </strong>

                                        <br>

                                        {{ $correction->reason }}

                                    </div>


                                </article>


                            @endforeach


                        </div>


                    @else


                        <div class="history-empty">

                            This attendance session has never been
                            administratively corrected.

                        </div>


                    @endif


                </div>

            </section>


        </aside>


    </div>


</div>

@endsection