@extends('layouts.app')

@section('title', 'Review Attendance | OJT Sync')

@php
    /*
    |--------------------------------------------------------------------------
    | Format Helpers
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
                'review-status-blue',

            \App\Models\AttendanceRecord::STATUS_PENDING =>
                'review-status-orange',

            \App\Models\AttendanceRecord::STATUS_VALIDATED =>
                'review-status-green',

            \App\Models\AttendanceRecord::STATUS_REJECTED =>
                'review-status-red',

            default =>
                'review-status-gray',
        };
    };

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    $assignment =
        $attendance->ojtAssignment;

    $studentProfile =
        $assignment?->studentProfile;

    $student =
        $studentProfile?->user;

    $company =
        $assignment?->company;

    /*
    |--------------------------------------------------------------------------
    | Attendance Sessions
    |--------------------------------------------------------------------------
    */

    $sessions =
        $attendance->relationLoaded('sessions')
            ? $attendance->getRelation('sessions')
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
            ->whereNotNull('time_out')
            ->count();

    $hasSessionAttendance =
        $sessions->isNotEmpty();

    $isLegacyAttendance =
        ! $hasSessionAttendance
        && $attendance->time_in !== null;

    /*
    |--------------------------------------------------------------------------
    | Evidence Count
    |--------------------------------------------------------------------------
    */

    $evidenceCount = 0;

    foreach ($sessions as $session) {
        if ($session->time_in_selfie_path) {
            $evidenceCount++;
        }

        if ($session->time_out_selfie_path) {
            $evidenceCount++;
        }
    }

    if ($isLegacyAttendance) {
        if ($attendance->time_in_selfie_path) {
            $evidenceCount++;
        }

        if ($attendance->time_out_selfie_path) {
            $evidenceCount++;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Workflow Completion
    |--------------------------------------------------------------------------
    */

    if ($hasSessionAttendance) {
        $sessionWorkflowComplete =
            $sessions->count() >= 2
            && $sessions->every(
                fn ($session) =>
                    $session->time_out !== null
            );
    } else {
        $sessionWorkflowComplete =
            $attendance->time_out !== null;
    }

    /*
    |--------------------------------------------------------------------------
    | Student Name + Initials
    |--------------------------------------------------------------------------
    */

    $studentName =
        $student?->name
        ?? 'Unknown Student';

    $nameParts =
        preg_split(
            '/\s+/',
            trim($studentName)
        );

    $firstInitial =
        mb_substr(
            $nameParts[0] ?? 'S',
            0,
            1
        );

    $lastInitial =
        mb_substr(
            count($nameParts) > 1
                ? $nameParts[count($nameParts) - 1]
                : 'T',
            0,
            1
        );

    $studentInitials =
        mb_strtoupper(
            $firstInitial
            .$lastInitial
        );

    /*
    |--------------------------------------------------------------------------
    | Session Photo URLs
    |--------------------------------------------------------------------------
    */

    $sessionPhotoUrl = function (
        $session,
        string $type
    ): ?string {
        if (! $session) {
            return null;
        }

        $path = match ($type) {
            'time-in' =>
                $session->time_in_selfie_path,

            'time-out' =>
                $session->time_out_selfie_path,

            default =>
                null,
        };

        if (! $path) {
            return null;
        }

        return route(
            'supervisor.validations.session-selfie',
            [
                'session' =>
                    $session->id,

                'type' =>
                    $type,
            ]
        );
    };

    $morningTimeInPhoto =
        $sessionPhotoUrl(
            $morningSession,
            'time-in'
        );

    $morningTimeOutPhoto =
        $sessionPhotoUrl(
            $morningSession,
            'time-out'
        );

    $afternoonTimeInPhoto =
        $sessionPhotoUrl(
            $afternoonSession,
            'time-in'
        );

    $afternoonTimeOutPhoto =
        $sessionPhotoUrl(
            $afternoonSession,
            'time-out'
        );

    /*
    |--------------------------------------------------------------------------
    | Legacy Photos
    |--------------------------------------------------------------------------
    */

    $legacyTimeInPhoto =
        $attendance->time_in_selfie_path
            ? route(
                'supervisor.validations.selfie',
                [
                    'attendance' =>
                        $attendance,

                    'type' =>
                        'time-in',
                ]
            )
            : null;

    $legacyTimeOutPhoto =
        $attendance->time_out_selfie_path
            ? route(
                'supervisor.validations.selfie',
                [
                    'attendance' =>
                        $attendance,

                    'type' =>
                        'time-out',
                ]
            )
            : null;
@endphp


@push('styles')

<style>
    /*
    |--------------------------------------------------------------------------
    | OJT Sync - Supervisor Attendance Review
    |--------------------------------------------------------------------------
    */

    .attendance-review-page {
        --navy-950: #07192D;
        --navy-900: #0B223D;
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
        --green-600: #16A34A;
        --green-100: #DCFCE7;
        --green-50: #F0FDF4;

        --orange-800: #9A3412;
        --orange-700: #C2410C;
        --orange-100: #FFEDD5;
        --orange-50: #FFF7ED;

        --red-800: #991B1B;
        --red-700: #B91C1C;
        --red-600: #DC2626;
        --red-100: #FEE2E2;
        --red-50: #FEF2F2;

        --purple-700: #6D28D9;
        --purple-100: #EDE9FE;

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

    .attendance-review-page *,
    .attendance-review-page *::before,
    .attendance-review-page *::after {
        box-sizing: border-box;
    }

    .attendance-review-page button,
    .attendance-review-page textarea,
    .attendance-review-page a {
        font-family: inherit;
    }


    /*
    |--------------------------------------------------------------------------
    | Focus
    |--------------------------------------------------------------------------
    */

    .attendance-review-page a:focus-visible,
    .attendance-review-page button:focus-visible,
    .attendance-review-page textarea:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .28);
        outline-offset: 3px;
    }


    /*
    |--------------------------------------------------------------------------
    | Alerts
    |--------------------------------------------------------------------------
    */

    .review-alert {
        display: flex;
        align-items: flex-start;

        gap: 14px;

        margin-bottom: 22px;
        padding: 17px 19px;

        border: 1px solid transparent;
        border-radius: 16px;

        font-size: 15px;
        font-weight: 700;
    }

    .review-alert-error {
        color: var(--red-800);

        border-color: #FECACA;

        background: var(--red-50);
    }

    .review-alert-success {
        color: var(--green-800);

        border-color: #BBF7D0;

        background: var(--green-50);
    }

    .review-alert-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 30px;
        height: 30px;

        flex: 0 0 30px;

        border-radius: 9px;

        color: #FFFFFF;
        background: currentColor;

        font-size: 12px;
        font-weight: 900;
    }


    /*
    |--------------------------------------------------------------------------
    | Back Navigation
    |--------------------------------------------------------------------------
    */

    .review-top-navigation {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 16px;

        margin-bottom: 17px;
    }

    .review-back-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-height: 46px;

        padding: 10px 15px;

        border: 1px solid #C8D6E5;
        border-radius: 12px;

        color: var(--navy-800);
        background: #FFFFFF;

        font-size: 14px;
        font-weight: 850;

        text-decoration: none;

        transition:
            border-color .18s ease,
            background .18s ease,
            color .18s ease;
    }

    .review-back-link:hover {
        color: var(--blue-700);

        border-color: #93C5FD;

        background: var(--blue-50);
    }

    .review-record-number {
        color: var(--slate-500);

        font-size: 13px;
        font-weight: 750;
    }


    /*
    |--------------------------------------------------------------------------
    | Hero
    |--------------------------------------------------------------------------
    */

    .review-hero {
        position: relative;
        overflow: hidden;

        margin-bottom: 25px;
        padding: 39px 40px;

        border-radius: 27px;

        color: #FFFFFF;

        background:
            radial-gradient(
                circle at 90% 10%,
                rgba(45, 212, 191, .22),
                transparent 26%
            ),
            radial-gradient(
                circle at 70% 100%,
                rgba(59, 130, 246, .15),
                transparent 32%
            ),
            linear-gradient(
                135deg,
                #0B223D 0%,
                #183B6B 58%,
                #17656B 115%
            );

        box-shadow:
            0 22px 50px
            rgba(11, 34, 61, .17);
    }

    .review-hero::before {
        content: '';

        position: absolute;

        width: 350px;
        height: 350px;

        top: -200px;
        right: -100px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, .06);
    }

    .review-hero-inner {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 35px;
    }

    .review-hero-copy {
        min-width: 0;
        max-width: 840px;
    }

    .review-eyebrow {
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

    .review-eyebrow-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background: #5EEAD4;

        box-shadow:
            0 0 0 5px
            rgba(94, 234, 212, .12);
    }

    .review-hero h1 {
        margin: 0;

        color: #FFFFFF;

        font-size:
            clamp(
                33px,
                4vw,
                45px
            );

        line-height: 1.12;
        font-weight: 900;

        letter-spacing: -.04em;
    }

    .review-hero-description {
        max-width: 800px;

        margin: 15px 0 0;

        color:
            rgba(255, 255, 255, .84);

        font-size: 17px;
        line-height: 1.76;
    }


    /*
    |--------------------------------------------------------------------------
    | Hero Student
    |--------------------------------------------------------------------------
    */

    .review-hero-student {
        width: 310px;
        flex: 0 0 310px;

        padding: 21px;

        border:
            1px solid
            rgba(255, 255, 255, .16);

        border-radius: 19px;

        background:
            rgba(255, 255, 255, .10);

        backdrop-filter:
            blur(8px);
    }

    .hero-student-top {
        display: flex;
        align-items: center;

        gap: 12px;

        margin-bottom: 16px;
    }

    .hero-student-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 50px;
        height: 50px;

        flex: 0 0 50px;

        border-radius: 14px;

        color: var(--navy-800);
        background: #FFFFFF;

        font-size: 15px;
        font-weight: 900;
    }

    .hero-student-name {
        display: block;

        color: #FFFFFF;

        font-size: 16px;
        line-height: 1.35;
        font-weight: 900;
    }

    .hero-student-number {
        display: block;

        margin-top: 3px;

        color:
            rgba(255, 255, 255, .70);

        font-size: 12px;
    }

    .hero-status-label {
        display: block;

        margin-bottom: 5px;

        color:
            rgba(255, 255, 255, .64);

        font-size: 11px;
        font-weight: 850;

        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .hero-status-value {
        display: block;

        color: #FFFFFF;

        font-size: 22px;
        font-weight: 900;
    }

    .hero-date {
        display: block;

        margin-top: 4px;

        color:
            rgba(255, 255, 255, .74);

        font-size: 13px;
    }


    /*
    |--------------------------------------------------------------------------
    | Review Notice
    |--------------------------------------------------------------------------
    */

    .review-notice {
        display: flex;
        align-items: flex-start;

        gap: 15px;

        margin-bottom: 25px;
        padding: 19px 21px;

        border: 1px solid #BEDDD6;
        border-radius: 17px;

        background:
            linear-gradient(
                135deg,
                #F9FCFB,
                #F0FAF7
            );
    }

    .review-notice-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 48px;
        height: 48px;

        flex: 0 0 48px;

        border-radius: 14px;

        color: var(--teal-800);
        background: var(--teal-100);

        font-size: 13px;
        font-weight: 900;
    }

    .review-notice strong {
        display: block;

        margin-bottom: 4px;

        color: var(--navy-800);

        font-size: 17px;
        font-weight: 850;
    }

    .review-notice p {
        margin: 0;

        color: var(--slate-600);

        font-size: 15px;
        line-height: 1.7;
    }


    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    .review-status {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding: 8px 12px;

        border-radius: 999px;

        font-size: 13px;
        font-weight: 850;

        white-space: nowrap;
    }

    .review-status::before {
        content: '';

        width: 8px;
        height: 8px;

        border-radius: 50%;

        background: currentColor;
    }

    .review-status-blue {
        color: var(--blue-700);
        background: var(--blue-100);
    }

    .review-status-orange {
        color: var(--orange-800);
        background: var(--orange-100);
    }

    .review-status-green {
        color: var(--green-800);
        background: var(--green-100);
    }

    .review-status-red {
        color: var(--red-800);
        background: var(--red-100);
    }

    .review-status-gray {
        color: var(--slate-600);
        background: var(--slate-100);
    }


    /*
    |--------------------------------------------------------------------------
    | Summary Statistics
    |--------------------------------------------------------------------------
    */

    .review-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 16px;

        margin-bottom: 24px;
    }

    .review-summary-card {
        padding: 20px;

        border: 1px solid var(--slate-200);
        border-radius: 18px;

        background: #FFFFFF;

        box-shadow:
            0 7px 24px
            rgba(15, 42, 74, .045);
    }

    .review-summary-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 44px;
        height: 44px;

        margin-bottom: 13px;

        border-radius: 13px;

        font-size: 11px;
        font-weight: 900;
    }

    .summary-blue {
        color: var(--blue-700);
        background: var(--blue-100);
    }

    .summary-teal {
        color: var(--teal-800);
        background: var(--teal-100);
    }

    .summary-green {
        color: var(--green-800);
        background: var(--green-100);
    }

    .summary-purple {
        color: var(--purple-700);
        background: var(--purple-100);
    }

    .review-summary-label {
        display: block;

        color: var(--slate-500);

        font-size: 13px;
        font-weight: 750;
    }

    .review-summary-value {
        display: block;

        margin-top: 4px;

        color: var(--navy-800);

        font-size: 23px;
        line-height: 1.2;
        font-weight: 900;
    }

    .review-summary-note {
        display: block;

        margin-top: 6px;

        color: var(--slate-500);

        font-size: 12px;
        line-height: 1.5;
    }


    /*
    |--------------------------------------------------------------------------
    | Main Grid
    |--------------------------------------------------------------------------
    */

    .review-info-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 21px;

        margin-bottom: 24px;
    }


    /*
    |--------------------------------------------------------------------------
    | Standard Card
    |--------------------------------------------------------------------------
    */

    .review-card {
        overflow: hidden;

        border: 1px solid var(--slate-200);
        border-radius: 21px;

        background: #FFFFFF;

        box-shadow:
            0 8px 28px
            rgba(15, 42, 74, .05);
    }

    .review-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 16px;

        padding: 22px 23px;

        border-bottom:
            1px solid #EDF2F7;

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FBFDFF
            );
    }

    .review-card-heading {
        display: flex;
        align-items: center;

        gap: 14px;
    }

    .review-card-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 48px;
        height: 48px;

        flex: 0 0 48px;

        border-radius: 14px;

        font-size: 12px;
        font-weight: 900;
    }

    .card-icon-blue {
        color: var(--blue-700);
        background: var(--blue-100);
    }

    .card-icon-teal {
        color: var(--teal-800);
        background: var(--teal-100);
    }

    .card-icon-purple {
        color: var(--purple-700);
        background: var(--purple-100);
    }

    .review-card-title {
        margin: 0;

        color: var(--navy-800);

        font-size: 22px;
        line-height: 1.3;
        font-weight: 900;
    }

    .review-card-description {
        margin: 4px 0 0;

        color: var(--slate-500);

        font-size: 14px;
        line-height: 1.55;
    }

    .review-card-body {
        padding: 23px;
    }


    /*
    |--------------------------------------------------------------------------
    | Student Information
    |--------------------------------------------------------------------------
    */

    .student-profile-banner {
        display: flex;
        align-items: center;

        gap: 15px;

        margin-bottom: 19px;
        padding: 17px;

        border: 1px solid #E1EAF3;
        border-radius: 15px;

        background: var(--slate-50);
    }

    .student-profile-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 62px;
        height: 62px;

        flex: 0 0 62px;

        border-radius: 18px;

        color: var(--teal-800);
        background: var(--teal-100);

        font-size: 17px;
        font-weight: 900;
    }

    .student-profile-name {
        display: block;

        color: var(--navy-800);

        font-size: 20px;
        line-height: 1.35;
        font-weight: 900;
    }

    .student-profile-meta {
        display: block;

        margin-top: 3px;

        color: var(--slate-500);

        font-size: 14px;
    }


    /*
    |--------------------------------------------------------------------------
    | Detail Rows
    |--------------------------------------------------------------------------
    */

    .review-details {
        display: grid;
    }

    .review-detail-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 20px;

        padding: 15px 0;

        border-bottom:
            1px solid #EDF2F7;
    }

    .review-detail-row:first-child {
        padding-top: 0;
    }

    .review-detail-row:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .review-detail-label {
        color: var(--slate-500);

        font-size: 14px;
        font-weight: 700;
    }

    .review-detail-value {
        max-width: 65%;

        color: var(--navy-800);

        font-size: 16px;
        line-height: 1.5;
        font-weight: 850;

        text-align: right;

        overflow-wrap: anywhere;
    }


    /*
    |--------------------------------------------------------------------------
    | Session Container
    |--------------------------------------------------------------------------
    */

    .session-review-list {
        display: grid;
        gap: 23px;
    }

    .session-review-card {
        position: relative;
        overflow: hidden;

        border: 1px solid var(--slate-200);
        border-radius: 20px;

        background: #FFFFFF;
    }

    .session-review-card::before {
        content: '';

        position: absolute;

        top: 0;
        bottom: 0;
        left: 0;

        width: 6px;

        background: var(--slate-300);
    }

    .session-review-card.completed {
        border-color: #C6E8D0;
    }

    .session-review-card.completed::before {
        background: var(--green-600);
    }

    .session-review-card.active {
        border-color: #BFDBFE;
    }

    .session-review-card.active::before {
        background: var(--blue-600);
    }

    .session-review-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 17px;

        padding: 21px 22px 21px 26px;

        border-bottom:
            1px solid #EDF2F7;

        background:
            linear-gradient(
                180deg,
                #FFFFFF,
                #FBFDFF
            );
    }

    .session-review-number {
        display: block;

        margin-bottom: 4px;

        color: var(--blue-700);

        font-size: 11px;
        font-weight: 900;

        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .session-review-title {
        margin: 0;

        color: var(--navy-800);

        font-size: 23px;
        line-height: 1.3;
        font-weight: 900;
    }

    .session-review-body {
        padding: 22px 22px 23px 26px;
    }


    /*
    |--------------------------------------------------------------------------
    | Session Summary
    |--------------------------------------------------------------------------
    */

    .session-time-grid {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 11px;

        margin-bottom: 19px;
    }

    .session-time-card {
        padding: 15px;

        border: 1px solid #E6EDF5;
        border-radius: 13px;

        background: var(--slate-50);
    }

    .session-time-label {
        display: block;

        margin-bottom: 5px;

        color: var(--slate-500);

        font-size: 12px;
        font-weight: 750;
    }

    .session-time-value {
        display: block;

        color: var(--navy-800);

        font-size: 17px;
        line-height: 1.4;
        font-weight: 900;
    }


    /*
    |--------------------------------------------------------------------------
    | GPS
    |--------------------------------------------------------------------------
    */

    .session-section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 14px;

        margin: 4px 0 13px;
    }

    .session-section-title {
        margin: 0;

        color: var(--navy-800);

        font-size: 18px;
        font-weight: 900;
    }

    .secure-badge {
        display: inline-flex;
        align-items: center;

        padding: 6px 10px;

        border-radius: 999px;

        color: var(--teal-800);
        background: var(--teal-100);

        font-size: 11px;
        font-weight: 850;

        white-space: nowrap;
    }

    .gps-review-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 13px;

        margin-bottom: 21px;
    }

    .gps-review-card {
        padding: 16px;

        border: 1px solid #CFE6E0;
        border-radius: 14px;

        background:
            linear-gradient(
                180deg,
                #F5FFFC,
                #F0FDFA
            );
    }

    .gps-review-title {
        display: block;

        margin-bottom: 11px;

        color: var(--teal-800);

        font-size: 15px;
        font-weight: 900;
    }

    .gps-review-details {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 8px;
    }

    .gps-review-item {
        min-width: 0;

        padding: 10px;

        border-radius: 10px;

        background:
            rgba(255, 255, 255, .83);
    }

    .gps-review-label {
        display: block;

        color: var(--slate-500);

        font-size: 11px;
        font-weight: 700;
    }

    .gps-review-value {
        display: block;

        margin-top: 3px;

        color: var(--navy-800);

        font-size: 13px;
        font-weight: 850;

        overflow-wrap: anywhere;
    }


    /*
    |--------------------------------------------------------------------------
    | Photo Evidence
    |--------------------------------------------------------------------------
    */

    .evidence-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 15px;
    }

    .evidence-photo {
        display: block;
        overflow: hidden;

        border: 1px solid #D8E3ED;
        border-radius: 16px;

        color: inherit;
        background: #FFFFFF;

        text-decoration: none;

        transition:
            transform .18s ease,
            border-color .18s ease,
            box-shadow .18s ease;
    }

    .evidence-photo:hover {
        transform: translateY(-2px);

        border-color: #93C5FD;

        box-shadow:
            0 13px 28px
            rgba(15, 42, 74, .11);
    }

    .evidence-photo-preview {
        position: relative;
        overflow: hidden;

        height: 300px;

        background: var(--slate-100);
    }

    .evidence-photo-preview img {
        display: block;

        width: 100%;
        height: 100%;

        object-fit: cover;
    }

    .evidence-photo-overlay {
        position: absolute;

        right: 12px;
        bottom: 12px;

        padding: 8px 11px;

        border-radius: 999px;

        color: #FFFFFF;

        background:
            rgba(11, 34, 61, .89);

        font-size: 11px;
        font-weight: 850;
    }

    .evidence-photo-details {
        padding: 15px 16px;
    }

    .evidence-photo-title {
        display: block;

        color: var(--navy-800);

        font-size: 16px;
        font-weight: 900;
    }

    .evidence-photo-time {
        display: block;

        margin-top: 3px;

        color: var(--slate-500);

        font-size: 13px;
    }

    .evidence-empty {
        display: flex;
        align-items: center;
        justify-content: center;

        min-height: 205px;

        padding: 22px;

        border:
            1px dashed
            var(--slate-300);

        border-radius: 16px;

        color: var(--slate-500);
        background: var(--slate-50);

        font-size: 14px;
        font-weight: 700;

        text-align: center;
        line-height: 1.65;
    }


    /*
    |--------------------------------------------------------------------------
    | Break Divider
    |--------------------------------------------------------------------------
    */

    .attendance-break {
        display: flex;
        align-items: center;

        gap: 14px;

        padding: 0 5px;
    }

    .attendance-break-line {
        height: 1px;

        flex: 1;

        background: var(--slate-200);
    }

    .attendance-break-label {
        padding: 8px 14px;

        border-radius: 999px;

        color: var(--slate-600);
        background: var(--slate-100);

        font-size: 12px;
        font-weight: 850;

        white-space: nowrap;
    }


    /*
    |--------------------------------------------------------------------------
    | Legacy
    |--------------------------------------------------------------------------
    */

    .legacy-notice {
        margin-bottom: 18px;
        padding: 17px;

        border: 1px solid #FDE68A;
        border-radius: 14px;

        color: #854D0E;
        background: #FFFBEB;

        font-size: 14px;
        line-height: 1.7;
    }

    .legacy-notice strong {
        color: #713F12;
    }


    /*
    |--------------------------------------------------------------------------
    | Decision Area
    |--------------------------------------------------------------------------
    */

    .decision-section {
        margin-top: 25px;
    }

    .decision-heading {
        margin-bottom: 15px;
    }

    .decision-heading h2 {
        margin: 0;

        color: var(--navy-800);

        font-size: 25px;
        font-weight: 900;
    }

    .decision-heading p {
        margin: 5px 0 0;

        color: var(--slate-500);

        font-size: 15px;
    }

    .decision-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 20px;
    }

    .decision-card {
        padding: 24px;

        border: 1px solid var(--slate-200);
        border-radius: 20px;

        background: #FFFFFF;

        box-shadow:
            0 8px 26px
            rgba(15, 42, 74, .045);
    }

    .decision-card.approve {
        border-top:
            5px solid
            var(--green-600);
    }

    .decision-card.reject {
        border-top:
            5px solid
            var(--red-600);
    }

    .decision-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 50px;
        height: 50px;

        margin-bottom: 14px;

        border-radius: 14px;

        font-size: 12px;
        font-weight: 900;
    }

    .decision-card.approve
    .decision-icon {
        color: var(--green-800);
        background: var(--green-100);
    }

    .decision-card.reject
    .decision-icon {
        color: var(--red-800);
        background: var(--red-100);
    }

    .decision-title {
        margin: 0;

        color: var(--navy-800);

        font-size: 22px;
        font-weight: 900;
    }

    .decision-description {
        margin: 7px 0 18px;

        color: var(--slate-500);

        font-size: 15px;
        line-height: 1.65;
    }

    .decision-label {
        display: block;

        margin-bottom: 8px;

        color: var(--navy-800);

        font-size: 15px;
        font-weight: 850;
    }

    .decision-required {
        color: var(--red-700);

        font-size: 12px;
        font-weight: 800;
    }

    .decision-textarea {
        width: 100%;
        min-height: 140px;

        padding: 14px 15px;

        border: 1px solid #C8D6E5;
        border-radius: 13px;

        outline: none;
        resize: vertical;

        color: var(--slate-800);
        background: #FBFDFF;

        font-size: 16px;
        line-height: 1.6;

        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            background .18s ease;
    }

    .decision-textarea:focus {
        border-color: var(--blue-500);

        background: #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(37, 99, 235, .08);
    }

    .decision-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 100%;
        min-height: 55px;

        margin-top: 15px;
        padding: 12px 18px;

        border: 0;
        border-radius: 13px;

        color: #FFFFFF;

        font-size: 16px;
        font-weight: 900;

        cursor: pointer;

        transition:
            transform .16s ease,
            box-shadow .16s ease,
            opacity .16s ease;
    }

    .decision-button:hover {
        transform: translateY(-1px);
    }

    .decision-button:disabled {
        opacity: .55;

        cursor: not-allowed;

        transform: none;
    }

    .decision-button-approve {
        background:
            linear-gradient(
                135deg,
                #16A34A,
                #15803D
            );

        box-shadow:
            0 9px 20px
            rgba(21, 128, 61, .18);
    }

    .decision-button-reject {
        background:
            linear-gradient(
                135deg,
                #DC2626,
                #B91C1C
            );

        box-shadow:
            0 9px 20px
            rgba(185, 28, 28, .18);
    }


    /*
    |--------------------------------------------------------------------------
    | Processed Decision
    |--------------------------------------------------------------------------
    */

    .processed-decision {
        margin-top: 25px;
        padding: 23px;

        border: 1px solid var(--slate-200);
        border-radius: 20px;

        background: #FFFFFF;

        box-shadow:
            0 7px 24px
            rgba(15, 42, 74, .045);
    }

    .processed-decision h2 {
        margin: 0 0 13px;

        color: var(--navy-800);

        font-size: 23px;
        font-weight: 900;
    }

    .processed-meta {
        margin-top: 13px;

        color: var(--slate-500);

        font-size: 14px;
    }

    .processed-meta strong {
        color: var(--navy-800);
    }

    .processed-remarks {
        margin-top: 16px;
        padding: 17px;

        border-radius: 14px;

        color: var(--slate-700);
        background: var(--slate-50);

        font-size: 15px;
        line-height: 1.7;

        white-space: pre-wrap;
    }

    .processed-remarks strong {
        color: var(--navy-800);
    }


    /*
    |--------------------------------------------------------------------------
    | Bottom Navigation
    |--------------------------------------------------------------------------
    */

    .review-bottom-navigation {
        margin-top: 24px;
    }


    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1150px) {
        .review-summary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .review-info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 900px) {
        .review-hero-inner {
            align-items: flex-start;
            flex-direction: column;
        }

        .review-hero-student {
            width: 100%;
            flex: 0 0 auto;
        }

        .decision-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 760px) {
        .attendance-review-page {
            font-size: 16px;
        }

        .review-hero {
            padding: 29px 21px;

            border-radius: 21px;
        }

        .review-hero-description {
            font-size: 16px;
        }

        .review-summary-grid {
            grid-template-columns: 1fr;
        }

        .session-time-grid {
            grid-template-columns: 1fr;
        }

        .gps-review-grid {
            grid-template-columns: 1fr;
        }

        .evidence-grid {
            grid-template-columns: 1fr;
        }

        .evidence-photo-preview {
            height: 350px;
        }
    }

    @media (max-width: 560px) {
        .review-top-navigation {
            align-items: flex-start;
            flex-direction: column;
        }

        .review-card-header,
        .review-card-body,
        .session-review-header,
        .session-review-body {
            padding-left: 16px;
            padding-right: 16px;
        }

        .session-review-body,
        .session-review-header {
            padding-left: 20px;
        }

        .review-detail-row {
            gap: 5px;

            flex-direction: column;
        }

        .review-detail-value {
            max-width: 100%;

            text-align: left;
        }

        .gps-review-details {
            grid-template-columns: 1fr;
        }

        .session-review-header,
        .session-section-heading {
            align-items: flex-start;

            flex-direction: column;
        }

        .student-profile-banner {
            align-items: flex-start;
        }

        .evidence-photo-preview {
            height: 300px;
        }
    }
</style>

@endpush


@section('content')

<div class="attendance-review-page">


    {{-- ===============================================================
         ALERTS
         =============================================================== --}}

    @if ($errors->any())

        <div class="review-alert review-alert-error">

            <span class="review-alert-icon">
                !
            </span>

            <div>

                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach

            </div>

        </div>

    @endif


    @if (session('error'))

        <div class="review-alert review-alert-error">

            <span class="review-alert-icon">
                !
            </span>

            <div>
                {{ session('error') }}
            </div>

        </div>

    @endif


    @if (session('success'))

        <div class="review-alert review-alert-success">

            <span class="review-alert-icon">
                ✓
            </span>

            <div>
                {{ session('success') }}
            </div>

        </div>

    @endif


    {{-- ===============================================================
         TOP NAVIGATION
         =============================================================== --}}

    <div class="review-top-navigation">

        <a
            href="{{ route('supervisor.validations.index') }}"
            class="review-back-link"
        >
            ← Back to Attendance Validation
        </a>


        <span class="review-record-number">
            Attendance Record #{{ $attendance->id }}
        </span>

    </div>


    {{-- ===============================================================
         HERO
         =============================================================== --}}

    <section class="review-hero">

        <div class="review-hero-inner">


            <div class="review-hero-copy">

                <div class="review-eyebrow">

                    <span class="review-eyebrow-dot"></span>

                    Supervisor Portal · Attendance Evidence

                </div>


                <h1>
                    Review Attendance
                </h1>


                <p class="review-hero-description">

                    Verify the Student's complete OJT attendance day.
                    Review Morning and Afternoon timestamps, GPS
                    coordinates, selfie evidence and rendered hours
                    before approving or rejecting this record.

                </p>

            </div>


            <div class="review-hero-student">


                <div class="hero-student-top">

                    <div class="hero-student-avatar">
                        {{ $studentInitials }}
                    </div>


                    <div>

                        <span class="hero-student-name">
                            {{ $studentName }}
                        </span>

                        <span class="hero-student-number">

                            {{ $studentProfile?->student_number
                                ?? 'No Student Number' }}

                        </span>

                    </div>

                </div>


                <span class="hero-status-label">
                    Current Status
                </span>

                <span class="hero-status-value">

                    {{ $statusLabel(
                        $attendance->status
                    ) }}

                </span>

                <span class="hero-date">

                    {{ $formatDate(
                        $attendance->attendance_date
                    ) }}

                </span>


            </div>


        </div>

    </section>


    {{-- ===============================================================
         RESPONSIBILITY NOTICE
         =============================================================== --}}

    <section class="review-notice">

        <div class="review-notice-icon">
            SEC
        </div>


        <div>

            <strong>
                Review the complete attendance evidence before making a decision.
            </strong>


            <p>

                Morning and Afternoon attendance sessions are recorded
                separately. Lunch or break time between sessions is not
                included in rendered OJT hours. Validate only after
                checking the timestamps, GPS information and available
                selfie evidence.

            </p>

        </div>

    </section>


    {{-- ===============================================================
         SUMMARY CARDS
         =============================================================== --}}

    <section class="review-summary-grid">


        <article class="review-summary-card">

            <div class="review-summary-icon summary-blue">
                DAY
            </div>

            <span class="review-summary-label">
                Attendance Date
            </span>

            <span class="review-summary-value">

                {{ $formatDate(
                    $attendance->attendance_date
                ) }}

            </span>

            <span class="review-summary-note">
                Philippine Time
            </span>

        </article>


        <article class="review-summary-card">

            <div class="review-summary-icon summary-teal">
                SS
            </div>

            <span class="review-summary-label">
                Completed Sessions
            </span>

            <span class="review-summary-value">

                @if ($isLegacyAttendance)

                    Previous Format

                @else

                    {{ $completedSessions }} / 2

                @endif

            </span>

            <span class="review-summary-note">

                @if ($isLegacyAttendance)

                    Created before split-session attendance

                @else

                    Morning and Afternoon attendance

                @endif

            </span>

        </article>


        <article class="review-summary-card">

            <div class="review-summary-icon summary-green">
                HR
            </div>

            <span class="review-summary-label">
                Rendered Time
            </span>

            <span class="review-summary-value">

                {{ $formatMinutes(
                    $attendance->rendered_minutes
                ) }}

            </span>

            <span class="review-summary-note">
                Daily rendered OJT time
            </span>

        </article>


        <article class="review-summary-card">

            <div class="review-summary-icon summary-purple">
                IMG
            </div>

            <span class="review-summary-label">
                Selfie Evidence
            </span>

            <span class="review-summary-value">
                {{ $evidenceCount }}
            </span>

            <span class="review-summary-note">

                {{ $evidenceCount === 1
                    ? 'protected attendance photo'
                    : 'protected attendance photos' }}

            </span>

        </article>


    </section>


    {{-- ===============================================================
         STUDENT + ATTENDANCE INFORMATION
         =============================================================== --}}

    <div class="review-info-grid">


        {{-- STUDENT INFORMATION --}}

        <section class="review-card">

            <div class="review-card-header">

                <div class="review-card-heading">

                    <div class="review-card-icon card-icon-teal">
                        ST
                    </div>


                    <div>

                        <h2 class="review-card-title">
                            Student Information
                        </h2>

                        <p class="review-card-description">
                            Student identity and OJT placement
                        </p>

                    </div>

                </div>

            </div>


            <div class="review-card-body">


                <div class="student-profile-banner">

                    <div class="student-profile-avatar">
                        {{ $studentInitials }}
                    </div>


                    <div>

                        <span class="student-profile-name">
                            {{ $studentName }}
                        </span>

                        <span class="student-profile-meta">

                            {{ $studentProfile?->student_number
                                ?? 'No Student Number' }}

                            ·

                            {{ $studentProfile?->program
                                ?? 'Program unavailable' }}

                        </span>

                    </div>

                </div>


                <div class="review-details">


                    <div class="review-detail-row">

                        <span class="review-detail-label">
                            Student Number
                        </span>

                        <span class="review-detail-value">
                            {{ $studentProfile?->student_number ?? '—' }}
                        </span>

                    </div>


                    <div class="review-detail-row">

                        <span class="review-detail-label">
                            Program
                        </span>

                        <span class="review-detail-value">
                            {{ $studentProfile?->program ?? '—' }}
                        </span>

                    </div>


                    <div class="review-detail-row">

                        <span class="review-detail-label">
                            Year Level
                        </span>

                        <span class="review-detail-value">
                            {{ $studentProfile?->year_level ?? '—' }}
                        </span>

                    </div>


                    <div class="review-detail-row">

                        <span class="review-detail-label">
                            Section
                        </span>

                        <span class="review-detail-value">
                            {{ $studentProfile?->section ?? '—' }}
                        </span>

                    </div>


                    <div class="review-detail-row">

                        <span class="review-detail-label">
                            Training Company
                        </span>

                        <span class="review-detail-value">
                            {{ $company?->name ?? '—' }}
                        </span>

                    </div>


                </div>


            </div>

        </section>


        {{-- ATTENDANCE INFORMATION --}}

        <section class="review-card">

            <div class="review-card-header">

                <div class="review-card-heading">

                    <div class="review-card-icon card-icon-blue">
                        OJT
                    </div>


                    <div>

                        <h2 class="review-card-title">
                            Attendance Information
                        </h2>

                        <p class="review-card-description">
                            Daily attendance record summary
                        </p>

                    </div>

                </div>


                <span
                    class="
                        review-status
                        {{ $statusClass(
                            $attendance->status
                        ) }}
                    "
                >
                    {{ $statusLabel(
                        $attendance->status
                    ) }}
                </span>

            </div>


            <div class="review-card-body">


                <div class="review-details">


                    <div class="review-detail-row">

                        <span class="review-detail-label">
                            Attendance Date
                        </span>

                        <span class="review-detail-value">

                            {{ $formatDate(
                                $attendance->attendance_date
                            ) }}

                        </span>

                    </div>


                    <div class="review-detail-row">

                        <span class="review-detail-label">
                            Attendance Format
                        </span>

                        <span class="review-detail-value">

                            @if ($isLegacyAttendance)

                                Previous Attendance Format

                            @else

                                Morning + Afternoon Sessions

                            @endif

                        </span>

                    </div>


                    <div class="review-detail-row">

                        <span class="review-detail-label">
                            First Time In
                        </span>

                        <span class="review-detail-value">

                            {{ $formatTime(
                                $attendance->time_in
                            ) }}

                        </span>

                    </div>


                    <div class="review-detail-row">

                        <span class="review-detail-label">
                            Last Time Out
                        </span>

                        <span class="review-detail-value">

                            {{ $formatTime(
                                $attendance->time_out
                            ) }}

                        </span>

                    </div>


                    <div class="review-detail-row">

                        <span class="review-detail-label">
                            Total Rendered
                        </span>

                        <span class="review-detail-value">

                            {{ $formatMinutes(
                                $attendance->rendered_minutes
                            ) }}

                        </span>

                    </div>


                    <div class="review-detail-row">

                        <span class="review-detail-label">
                            Evidence Photos
                        </span>

                        <span class="review-detail-value">
                            {{ $evidenceCount }}
                        </span>

                    </div>


                </div>


            </div>

        </section>


    </div>


    {{-- ===============================================================
         ATTENDANCE EVIDENCE
         =============================================================== --}}

    <section class="review-card">

        <div class="review-card-header">

            <div class="review-card-heading">

                <div class="review-card-icon card-icon-purple">
                    GPS
                </div>


                <div>

                    <h2 class="review-card-title">
                        Attendance Evidence
                    </h2>

                    <p class="review-card-description">

                        Review timestamps, GPS coordinates and
                        protected selfie evidence

                    </p>

                </div>

            </div>

        </div>


        <div class="review-card-body">


            {{-- =======================================================
                 SESSION-BASED ATTENDANCE
                 ======================================================= --}}

            @if ($hasSessionAttendance)


                <div class="session-review-list">


                    {{-- =================================================
                         MORNING SESSION
                         ================================================= --}}

                    <article
                        class="
                            session-review-card

                            @if ($morningSession?->time_out)
                                completed
                            @elseif ($morningSession)
                                active
                            @endif
                        "
                    >


                        <div class="session-review-header">


                            <div>

                                <span class="session-review-number">
                                    Session 01
                                </span>

                                <h3 class="session-review-title">
                                    Morning Session
                                </h3>

                            </div>


                            @if ($morningSession?->time_out)

                                <span class="review-status review-status-green">
                                    Completed
                                </span>

                            @elseif ($morningSession)

                                <span class="review-status review-status-blue">
                                    Currently Active
                                </span>

                            @else

                                <span class="review-status review-status-gray">
                                    Not Started
                                </span>

                            @endif


                        </div>


                        <div class="session-review-body">


                            {{-- =========================================
                                 TIME SUMMARY
                                 ========================================= --}}

                            <div class="session-time-grid">


                                <div class="session-time-card">

                                    <span class="session-time-label">
                                        Morning Time In
                                    </span>

                                    <span class="session-time-value">

                                        {{ $formatTime(
                                            $morningSession?->time_in
                                        ) }}

                                    </span>

                                </div>


                                <div class="session-time-card">

                                    <span class="session-time-label">
                                        Morning Time Out
                                    </span>

                                    <span class="session-time-value">

                                        {{ $formatTime(
                                            $morningSession?->time_out
                                        ) }}

                                    </span>

                                </div>


                                <div class="session-time-card">

                                    <span class="session-time-label">
                                        Morning Rendered
                                    </span>

                                    <span class="session-time-value">

                                        {{ $formatMinutes(
                                            $morningSession?->rendered_minutes
                                            ?? 0
                                        ) }}

                                    </span>

                                </div>


                            </div>


                            {{-- =========================================
                                 GPS
                                 ========================================= --}}

                            <div class="session-section-heading">

                                <h4 class="session-section-title">
                                    Morning GPS Verification
                                </h4>

                                <span class="secure-badge">
                                    Recorded Evidence
                                </span>

                            </div>


                            <div class="gps-review-grid">


                                {{-- TIME IN GPS --}}

                                <div class="gps-review-card">

                                    <span class="gps-review-title">
                                        Time In Location
                                    </span>


                                    <div class="gps-review-details">


                                        <div class="gps-review-item">

                                            <span class="gps-review-label">
                                                Latitude
                                            </span>

                                            <span class="gps-review-value">

                                                {{ $morningSession
                                                    ?->time_in_latitude
                                                    ?? '—' }}

                                            </span>

                                        </div>


                                        <div class="gps-review-item">

                                            <span class="gps-review-label">
                                                Longitude
                                            </span>

                                            <span class="gps-review-value">

                                                {{ $morningSession
                                                    ?->time_in_longitude
                                                    ?? '—' }}

                                            </span>

                                        </div>


                                        <div class="gps-review-item">

                                            <span class="gps-review-label">
                                                Accuracy
                                            </span>

                                            <span class="gps-review-value">

                                                @if ($morningSession?->time_in_accuracy !== null)

                                                    {{ number_format(
                                                        (float) $morningSession->time_in_accuracy,
                                                        1
                                                    ) }}
                                                    m

                                                @else

                                                    —

                                                @endif

                                            </span>

                                        </div>


                                    </div>

                                </div>


                                {{-- TIME OUT GPS --}}

                                <div class="gps-review-card">

                                    <span class="gps-review-title">
                                        Time Out Location
                                    </span>


                                    <div class="gps-review-details">


                                        <div class="gps-review-item">

                                            <span class="gps-review-label">
                                                Latitude
                                            </span>

                                            <span class="gps-review-value">

                                                {{ $morningSession
                                                    ?->time_out_latitude
                                                    ?? '—' }}

                                            </span>

                                        </div>


                                        <div class="gps-review-item">

                                            <span class="gps-review-label">
                                                Longitude
                                            </span>

                                            <span class="gps-review-value">

                                                {{ $morningSession
                                                    ?->time_out_longitude
                                                    ?? '—' }}

                                            </span>

                                        </div>


                                        <div class="gps-review-item">

                                            <span class="gps-review-label">
                                                Accuracy
                                            </span>

                                            <span class="gps-review-value">

                                                @if ($morningSession?->time_out_accuracy !== null)

                                                    {{ number_format(
                                                        (float) $morningSession->time_out_accuracy,
                                                        1
                                                    ) }}
                                                    m

                                                @else

                                                    —

                                                @endif

                                            </span>

                                        </div>


                                    </div>

                                </div>


                            </div>


                            {{-- =========================================
                                 PHOTOS
                                 ========================================= --}}

                            <div class="session-section-heading">

                                <h4 class="session-section-title">
                                    Morning Selfie Evidence
                                </h4>

                                <span class="secure-badge">
                                    Private Evidence
                                </span>

                            </div>


                            <div class="evidence-grid">


                                {{-- TIME IN --}}

                                @if ($morningTimeInPhoto)

                                    <a
                                        href="{{ $morningTimeInPhoto }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="evidence-photo"
                                    >

                                        <div class="evidence-photo-preview">

                                            <img
                                                src="{{ $morningTimeInPhoto }}"
                                                alt="Morning Time In selfie"
                                                loading="lazy"
                                            >

                                            <span class="evidence-photo-overlay">
                                                View Full Photo
                                            </span>

                                        </div>


                                        <div class="evidence-photo-details">

                                            <span class="evidence-photo-title">
                                                Morning Time In Selfie
                                            </span>

                                            <span class="evidence-photo-time">

                                                Captured at

                                                {{ $formatTime(
                                                    $morningSession?->time_in
                                                ) }}

                                            </span>

                                        </div>

                                    </a>

                                @else

                                    <div class="evidence-empty">

                                        Morning Time In selfie
                                        is not available.

                                    </div>

                                @endif


                                {{-- TIME OUT --}}

                                @if ($morningTimeOutPhoto)

                                    <a
                                        href="{{ $morningTimeOutPhoto }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="evidence-photo"
                                    >

                                        <div class="evidence-photo-preview">

                                            <img
                                                src="{{ $morningTimeOutPhoto }}"
                                                alt="Morning Time Out selfie"
                                                loading="lazy"
                                            >

                                            <span class="evidence-photo-overlay">
                                                View Full Photo
                                            </span>

                                        </div>


                                        <div class="evidence-photo-details">

                                            <span class="evidence-photo-title">
                                                Morning Time Out Selfie
                                            </span>

                                            <span class="evidence-photo-time">

                                                Captured at

                                                {{ $formatTime(
                                                    $morningSession?->time_out
                                                ) }}

                                            </span>

                                        </div>

                                    </a>

                                @else

                                    <div class="evidence-empty">

                                        Morning Time Out selfie
                                        is not available.

                                    </div>

                                @endif


                            </div>


                        </div>


                    </article>


                    {{-- =================================================
                         LUNCH / BREAK
                         ================================================= --}}

                    <div class="attendance-break">

                        <span class="attendance-break-line"></span>

                        <span class="attendance-break-label">
                            Lunch / Break · Not Counted
                        </span>

                        <span class="attendance-break-line"></span>

                    </div>


                    {{-- =================================================
                         AFTERNOON SESSION
                         ================================================= --}}

                    <article
                        class="
                            session-review-card

                            @if ($afternoonSession?->time_out)
                                completed
                            @elseif ($afternoonSession)
                                active
                            @endif
                        "
                    >


                        <div class="session-review-header">


                            <div>

                                <span class="session-review-number">
                                    Session 02
                                </span>

                                <h3 class="session-review-title">
                                    Afternoon Session
                                </h3>

                            </div>


                            @if ($afternoonSession?->time_out)

                                <span class="review-status review-status-green">
                                    Completed
                                </span>

                            @elseif ($afternoonSession)

                                <span class="review-status review-status-blue">
                                    Currently Active
                                </span>

                            @else

                                <span class="review-status review-status-gray">
                                    Not Started
                                </span>

                            @endif


                        </div>


                        <div class="session-review-body">


                            {{-- =========================================
                                 TIME SUMMARY
                                 ========================================= --}}

                            <div class="session-time-grid">


                                <div class="session-time-card">

                                    <span class="session-time-label">
                                        Afternoon Time In
                                    </span>

                                    <span class="session-time-value">

                                        {{ $formatTime(
                                            $afternoonSession?->time_in
                                        ) }}

                                    </span>

                                </div>


                                <div class="session-time-card">

                                    <span class="session-time-label">
                                        Afternoon Time Out
                                    </span>

                                    <span class="session-time-value">

                                        {{ $formatTime(
                                            $afternoonSession?->time_out
                                        ) }}

                                    </span>

                                </div>


                                <div class="session-time-card">

                                    <span class="session-time-label">
                                        Afternoon Rendered
                                    </span>

                                    <span class="session-time-value">

                                        {{ $formatMinutes(
                                            $afternoonSession?->rendered_minutes
                                            ?? 0
                                        ) }}

                                    </span>

                                </div>


                            </div>


                            {{-- =========================================
                                 GPS
                                 ========================================= --}}

                            <div class="session-section-heading">

                                <h4 class="session-section-title">
                                    Afternoon GPS Verification
                                </h4>

                                <span class="secure-badge">
                                    Recorded Evidence
                                </span>

                            </div>


                            <div class="gps-review-grid">


                                {{-- TIME IN GPS --}}

                                <div class="gps-review-card">

                                    <span class="gps-review-title">
                                        Time In Location
                                    </span>


                                    <div class="gps-review-details">


                                        <div class="gps-review-item">

                                            <span class="gps-review-label">
                                                Latitude
                                            </span>

                                            <span class="gps-review-value">

                                                {{ $afternoonSession
                                                    ?->time_in_latitude
                                                    ?? '—' }}

                                            </span>

                                        </div>


                                        <div class="gps-review-item">

                                            <span class="gps-review-label">
                                                Longitude
                                            </span>

                                            <span class="gps-review-value">

                                                {{ $afternoonSession
                                                    ?->time_in_longitude
                                                    ?? '—' }}

                                            </span>

                                        </div>


                                        <div class="gps-review-item">

                                            <span class="gps-review-label">
                                                Accuracy
                                            </span>

                                            <span class="gps-review-value">

                                                @if ($afternoonSession?->time_in_accuracy !== null)

                                                    {{ number_format(
                                                        (float) $afternoonSession->time_in_accuracy,
                                                        1
                                                    ) }}
                                                    m

                                                @else

                                                    —

                                                @endif

                                            </span>

                                        </div>


                                    </div>

                                </div>


                                {{-- TIME OUT GPS --}}

                                <div class="gps-review-card">

                                    <span class="gps-review-title">
                                        Time Out Location
                                    </span>


                                    <div class="gps-review-details">


                                        <div class="gps-review-item">

                                            <span class="gps-review-label">
                                                Latitude
                                            </span>

                                            <span class="gps-review-value">

                                                {{ $afternoonSession
                                                    ?->time_out_latitude
                                                    ?? '—' }}

                                            </span>

                                        </div>


                                        <div class="gps-review-item">

                                            <span class="gps-review-label">
                                                Longitude
                                            </span>

                                            <span class="gps-review-value">

                                                {{ $afternoonSession
                                                    ?->time_out_longitude
                                                    ?? '—' }}

                                            </span>

                                        </div>


                                        <div class="gps-review-item">

                                            <span class="gps-review-label">
                                                Accuracy
                                            </span>

                                            <span class="gps-review-value">

                                                @if ($afternoonSession?->time_out_accuracy !== null)

                                                    {{ number_format(
                                                        (float) $afternoonSession->time_out_accuracy,
                                                        1
                                                    ) }}
                                                    m

                                                @else

                                                    —

                                                @endif

                                            </span>

                                        </div>


                                    </div>

                                </div>


                            </div>


                            {{-- =========================================
                                 PHOTOS
                                 ========================================= --}}

                            <div class="session-section-heading">

                                <h4 class="session-section-title">
                                    Afternoon Selfie Evidence
                                </h4>

                                <span class="secure-badge">
                                    Private Evidence
                                </span>

                            </div>


                            <div class="evidence-grid">


                                {{-- TIME IN --}}

                                @if ($afternoonTimeInPhoto)

                                    <a
                                        href="{{ $afternoonTimeInPhoto }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="evidence-photo"
                                    >

                                        <div class="evidence-photo-preview">

                                            <img
                                                src="{{ $afternoonTimeInPhoto }}"
                                                alt="Afternoon Time In selfie"
                                                loading="lazy"
                                            >

                                            <span class="evidence-photo-overlay">
                                                View Full Photo
                                            </span>

                                        </div>


                                        <div class="evidence-photo-details">

                                            <span class="evidence-photo-title">
                                                Afternoon Time In Selfie
                                            </span>

                                            <span class="evidence-photo-time">

                                                Captured at

                                                {{ $formatTime(
                                                    $afternoonSession?->time_in
                                                ) }}

                                            </span>

                                        </div>

                                    </a>

                                @else

                                    <div class="evidence-empty">

                                        Afternoon Time In selfie
                                        is not available.

                                    </div>

                                @endif


                                {{-- TIME OUT --}}

                                @if ($afternoonTimeOutPhoto)

                                    <a
                                        href="{{ $afternoonTimeOutPhoto }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="evidence-photo"
                                    >

                                        <div class="evidence-photo-preview">

                                            <img
                                                src="{{ $afternoonTimeOutPhoto }}"
                                                alt="Afternoon Time Out selfie"
                                                loading="lazy"
                                            >

                                            <span class="evidence-photo-overlay">
                                                View Full Photo
                                            </span>

                                        </div>


                                        <div class="evidence-photo-details">

                                            <span class="evidence-photo-title">
                                                Afternoon Time Out Selfie
                                            </span>

                                            <span class="evidence-photo-time">

                                                Captured at

                                                {{ $formatTime(
                                                    $afternoonSession?->time_out
                                                ) }}

                                            </span>

                                        </div>

                                    </a>

                                @else

                                    <div class="evidence-empty">

                                        Afternoon Time Out selfie
                                        is not available.

                                    </div>

                                @endif


                            </div>


                        </div>


                    </article>


                </div>


            @else


                {{-- ===================================================
                     LEGACY ATTENDANCE
                     =================================================== --}}

                <div class="legacy-notice">

                    <strong>
                        Previous Attendance Format
                    </strong>

                    <br>

                    This attendance record was created before
                    OJT Sync introduced separate Morning and
                    Afternoon attendance sessions. The original
                    daily Time In and Time Out evidence remains
                    available below.

                </div>


                <div class="session-time-grid">


                    <div class="session-time-card">

                        <span class="session-time-label">
                            Time In
                        </span>

                        <span class="session-time-value">

                            {{ $formatTime(
                                $attendance->time_in
                            ) }}

                        </span>

                    </div>


                    <div class="session-time-card">

                        <span class="session-time-label">
                            Time Out
                        </span>

                        <span class="session-time-value">

                            {{ $formatTime(
                                $attendance->time_out
                            ) }}

                        </span>

                    </div>


                    <div class="session-time-card">

                        <span class="session-time-label">
                            Rendered Time
                        </span>

                        <span class="session-time-value">

                            {{ $formatMinutes(
                                $attendance->rendered_minutes
                            ) }}

                        </span>

                    </div>


                </div>


                <div class="gps-review-grid">


                    <div class="gps-review-card">

                        <span class="gps-review-title">
                            Time In Location
                        </span>


                        <div class="gps-review-details">


                            <div class="gps-review-item">

                                <span class="gps-review-label">
                                    Latitude
                                </span>

                                <span class="gps-review-value">
                                    {{ $attendance->time_in_latitude ?? '—' }}
                                </span>

                            </div>


                            <div class="gps-review-item">

                                <span class="gps-review-label">
                                    Longitude
                                </span>

                                <span class="gps-review-value">
                                    {{ $attendance->time_in_longitude ?? '—' }}
                                </span>

                            </div>


                            <div class="gps-review-item">

                                <span class="gps-review-label">
                                    Accuracy
                                </span>

                                <span class="gps-review-value">

                                    @if ($attendance->time_in_accuracy !== null)

                                        {{ number_format(
                                            (float) $attendance->time_in_accuracy,
                                            1
                                        ) }}
                                        m

                                    @else

                                        —

                                    @endif

                                </span>

                            </div>


                        </div>

                    </div>


                    <div class="gps-review-card">

                        <span class="gps-review-title">
                            Time Out Location
                        </span>


                        <div class="gps-review-details">


                            <div class="gps-review-item">

                                <span class="gps-review-label">
                                    Latitude
                                </span>

                                <span class="gps-review-value">
                                    {{ $attendance->time_out_latitude ?? '—' }}
                                </span>

                            </div>


                            <div class="gps-review-item">

                                <span class="gps-review-label">
                                    Longitude
                                </span>

                                <span class="gps-review-value">
                                    {{ $attendance->time_out_longitude ?? '—' }}
                                </span>

                            </div>


                            <div class="gps-review-item">

                                <span class="gps-review-label">
                                    Accuracy
                                </span>

                                <span class="gps-review-value">

                                    @if ($attendance->time_out_accuracy !== null)

                                        {{ number_format(
                                            (float) $attendance->time_out_accuracy,
                                            1
                                        ) }}
                                        m

                                    @else

                                        —

                                    @endif

                                </span>

                            </div>


                        </div>

                    </div>


                </div>


                <div class="session-section-heading">

                    <h4 class="session-section-title">
                        Selfie Evidence
                    </h4>

                    <span class="secure-badge">
                        Private Evidence
                    </span>

                </div>


                <div class="evidence-grid">


                    @if ($legacyTimeInPhoto)

                        <a
                            href="{{ $legacyTimeInPhoto }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="evidence-photo"
                        >

                            <div class="evidence-photo-preview">

                                <img
                                    src="{{ $legacyTimeInPhoto }}"
                                    alt="Time In attendance selfie"
                                    loading="lazy"
                                >

                                <span class="evidence-photo-overlay">
                                    View Full Photo
                                </span>

                            </div>


                            <div class="evidence-photo-details">

                                <span class="evidence-photo-title">
                                    Time In Selfie
                                </span>

                                <span class="evidence-photo-time">

                                    Captured at

                                    {{ $formatTime(
                                        $attendance->time_in
                                    ) }}

                                </span>

                            </div>

                        </a>

                    @else

                        <div class="evidence-empty">
                            No Time In selfie is available.
                        </div>

                    @endif


                    @if ($legacyTimeOutPhoto)

                        <a
                            href="{{ $legacyTimeOutPhoto }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="evidence-photo"
                        >

                            <div class="evidence-photo-preview">

                                <img
                                    src="{{ $legacyTimeOutPhoto }}"
                                    alt="Time Out attendance selfie"
                                    loading="lazy"
                                >

                                <span class="evidence-photo-overlay">
                                    View Full Photo
                                </span>

                            </div>


                            <div class="evidence-photo-details">

                                <span class="evidence-photo-title">
                                    Time Out Selfie
                                </span>

                                <span class="evidence-photo-time">

                                    Captured at

                                    {{ $formatTime(
                                        $attendance->time_out
                                    ) }}

                                </span>

                            </div>

                        </a>

                    @else

                        <div class="evidence-empty">
                            No Time Out selfie is available.
                        </div>

                    @endif


                </div>


            @endif


        </div>

    </section>


    {{-- ===============================================================
         PENDING DECISION
         =============================================================== --}}

    @if ($attendance->status === \App\Models\AttendanceRecord::STATUS_PENDING)

        <section class="decision-section">


            <div class="decision-heading">

                <h2>
                    Supervisor Decision
                </h2>

                <p>

                    Make your decision only after reviewing
                    the complete attendance evidence above.

                </p>

            </div>


            @if (! $sessionWorkflowComplete)

                <div class="review-alert review-alert-error">

                    <span class="review-alert-icon">
                        !
                    </span>

                    <div>

                        This attendance record is not fully complete.
                        Validation will remain blocked until all
                        required attendance sessions have been finished.

                    </div>

                </div>

            @endif


            <div class="decision-grid">


                {{-- ===================================================
                     APPROVE
                     =================================================== --}}

                <article class="decision-card approve">


                    <div class="decision-icon">
                        OK
                    </div>


                    <h3 class="decision-title">
                        Validate Attendance
                    </h3>


                    <p class="decision-description">

                        Approve the Student's completed attendance
                        record and allow its rendered time to count
                        toward official OJT hours.

                    </p>


                    <form
                        method="POST"
                        action="{{ route(
                            'supervisor.validations.approve',
                            $attendance
                        ) }}"
                    >

                        @csrf
                        @method('PUT')


                        <label
                            for="approveSupervisorRemarks"
                            class="decision-label"
                        >

                            Supervisor Remarks

                            <span
                                style="
                                    color: #64748B;
                                    font-size: 12px;
                                    font-weight: 700;
                                "
                            >
                                (Optional)
                            </span>

                        </label>


                        <textarea
                            id="approveSupervisorRemarks"
                            name="supervisor_remarks"
                            class="decision-textarea"
                            maxlength="2000"
                            placeholder="Optional comments about this attendance record..."
                        >{{ old('supervisor_remarks') }}</textarea>


                        <button
                            type="submit"
                            class="
                                decision-button
                                decision-button-approve
                            "
                            @disabled(! $sessionWorkflowComplete)
                            onclick="
                                return confirm(
                                    'Validate this attendance day and approve its rendered OJT hours?'
                                );
                            "
                        >
                            Validate Attendance
                        </button>


                    </form>


                </article>


                {{-- ===================================================
                     REJECT
                     =================================================== --}}

                <article class="decision-card reject">


                    <div class="decision-icon">
                        RJ
                    </div>


                    <h3 class="decision-title">
                        Reject Attendance
                    </h3>


                    <p class="decision-description">

                        Reject the attendance if the recorded
                        timestamps, GPS information, selfie evidence
                        or rendered hours are invalid.

                    </p>


                    <form
                        method="POST"
                        action="{{ route(
                            'supervisor.validations.reject',
                            $attendance
                        ) }}"
                    >

                        @csrf
                        @method('PUT')


                        <label
                            for="rejectSupervisorRemarks"
                            class="decision-label"
                        >

                            Rejection Reason

                            <span class="decision-required">
                                Required
                            </span>

                        </label>


                        <textarea
                            id="rejectSupervisorRemarks"
                            name="supervisor_remarks"
                            class="decision-textarea"
                            maxlength="2000"
                            minlength="3"
                            required
                            placeholder="Clearly explain why this attendance record is being rejected..."
                        >{{ old('supervisor_remarks') }}</textarea>


                        <button
                            type="submit"
                            class="
                                decision-button
                                decision-button-reject
                            "
                            onclick="
                                return confirm(
                                    'Reject this attendance record?'
                                );
                            "
                        >
                            Reject Attendance
                        </button>


                    </form>


                </article>


            </div>


        </section>


    @else


        {{-- ===========================================================
             PROCESSED ATTENDANCE
             =========================================================== --}}

        <section class="processed-decision">


            <h2>
                Supervisor Decision
            </h2>


            <span
                class="
                    review-status
                    {{ $statusClass(
                        $attendance->status
                    ) }}
                "
            >
                {{ $statusLabel(
                    $attendance->status
                ) }}
            </span>


            @if ($attendance->validator)

                <div class="processed-meta">

                    Processed by:

                    <strong>
                        {{ $attendance->validator->name }}
                    </strong>

                </div>

            @endif


            @if ($attendance->validated_at)

                <div class="processed-meta">

                    Processed on:

                    <strong>

                        {{ $formatDateTime(
                            $attendance->validated_at
                        ) }}

                    </strong>

                </div>

            @endif


            @if ($attendance->supervisor_remarks)

                <div class="processed-remarks">

                    <strong>
                        Supervisor Remarks
                    </strong>

                    <br><br>

                    {{ $attendance->supervisor_remarks }}

                </div>

            @endif


        </section>


    @endif


    {{-- ===============================================================
         BOTTOM NAVIGATION
         =============================================================== --}}

    <div class="review-bottom-navigation">

        <a
            href="{{ route('supervisor.validations.index') }}"
            class="review-back-link"
        >
            ← Back to Attendance Validation
        </a>

    </div>


</div>

@endsection