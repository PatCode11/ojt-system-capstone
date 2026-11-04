@extends('layouts.app')

@section('title', 'Attendance Details | OJT Sync')

@php
    /*
    |--------------------------------------------------------------------------
    | Display Helpers
    |--------------------------------------------------------------------------
    */

    $formatDate = static function ($value): string {
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

    $formatTime = static function ($value): string {
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

    $formatDateTime = static function ($value): string {
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

    $formatMinutes = static function ($minutes): string {
        $minutes = max(0, (int) $minutes);
        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        if ($hours > 0 && $remainingMinutes > 0) {
            return $hours.' hr'.($hours === 1 ? '' : 's').' '.$remainingMinutes.' min';
        }

        if ($hours > 0) {
            return $hours.' hr'.($hours === 1 ? '' : 's');
        }

        return $remainingMinutes.' min';
    };

    $formatCoordinate = static function ($value): string {
        if ($value === null || $value === '') {
            return '—';
        }

        return number_format((float) $value, 7, '.', '');
    };

    $formatAccuracy = static function ($value): string {
        if ($value === null || $value === '') {
            return '—';
        }

        return number_format((float) $value, 1).' m';
    };

    $statusLabel = static function (?string $status): string {
        return match ($status) {
            \App\Models\AttendanceRecord::STATUS_IN_PROGRESS => 'In Progress',
            \App\Models\AttendanceRecord::STATUS_PENDING => 'Pending Review',
            \App\Models\AttendanceRecord::STATUS_VALIDATED => 'Validated',
            \App\Models\AttendanceRecord::STATUS_REJECTED => 'Rejected',
            default => 'Unknown',
        };
    };

    $statusClass = static function (?string $status): string {
        return match ($status) {
            \App\Models\AttendanceRecord::STATUS_IN_PROGRESS => 'status-progress',
            \App\Models\AttendanceRecord::STATUS_PENDING => 'status-pending',
            \App\Models\AttendanceRecord::STATUS_VALIDATED => 'status-validated',
            \App\Models\AttendanceRecord::STATUS_REJECTED => 'status-rejected',
            default => 'status-unknown',
        };
    };

    $assignment = $attendance->ojtAssignment;
    $profile = $assignment?->studentProfile;
    $student = $profile?->user;
    $company = $assignment?->company;
    $supervisor = $assignment?->supervisor;
    $validator = $attendance->validator;

    $studentName = trim((string) ($student?->name ?? ''));

    if ($studentName === '') {
        $studentName = trim(
            (string) ($student?->first_name ?? '')
            .' '
            .(string) ($student?->last_name ?? '')
        );
    }

    $studentName = $studentName !== '' ? $studentName : 'Archived Student';

    $studentNumber = $profile?->student_number ?? 'No Student Number';
    $program = $profile?->program ?? '—';
    $yearLevel = $profile?->year_level ?? '—';
    $section = $profile?->section ?? null;

    $sessions = $attendance->relationLoaded('sessions')
        ? $attendance->getRelation('sessions')
        : collect();

    $sessions = $sessions->sortBy('session_number')->values();

    $isCompletedAssignment = $assignment?->status === \App\Models\OjtAssignment::STATUS_COMPLETED;
    $isLiveAttendance = $attendance->status === \App\Models\AttendanceRecord::STATUS_IN_PROGRESS;
    $hasCorrections = $corrections->isNotEmpty();

    $validatedMinutesValue = max(0, (int) $validatedMinutes);
    $requiredMinutesValue = max(0, (int) $requiredMinutes);
    $remainingMinutesValue = max(0, (int) $remainingMinutes);
    $progressValue = max(0, min(100, (float) $progressPercentage));

    $dailyRenderedMinutes = max(0, (int) $attendance->rendered_minutes);

    $assignmentStatusLabel = $assignment?->status
        ? ucwords(str_replace('_', ' ', (string) $assignment->status))
        : 'Unknown';

    $studentInitials = 'ST';

    if ($studentName !== 'Archived Student') {
        $nameParts = preg_split('/\s+/', trim($studentName)) ?: [];
        $firstPart = $nameParts[0] ?? '';
        $lastPart = count($nameParts) > 1 ? ($nameParts[count($nameParts) - 1] ?? '') : '';

        $candidateInitials = mb_strtoupper(
            mb_substr($firstPart, 0, 1)
            .mb_substr($lastPart, 0, 1)
        );

        if ($candidateInitials !== '') {
            $studentInitials = $candidateInitials;
        }
    }
@endphp

@push('styles')
<style>
    /*
    |--------------------------------------------------------------------------
    | Attendance Details Page
    |--------------------------------------------------------------------------
    */

    .attendance-detail-page {
        --navy-950: #07192d;
        --navy-900: #0b223d;
        --navy-800: #102a4a;
        --navy-700: #183b6b;
        --blue-700: #1d4ed8;
        --blue-600: #2563eb;
        --blue-100: #dbeafe;
        --blue-50: #eff6ff;
        --teal-800: #115e59;
        --teal-700: #0f766e;
        --teal-100: #ccfbf1;
        --teal-50: #f0fdfa;
        --green-800: #166534;
        --green-100: #dcfce7;
        --green-50: #f0fdf4;
        --amber-900: #92400e;
        --amber-100: #fef3c7;
        --amber-50: #fffbeb;
        --red-800: #991b1b;
        --red-700: #b91c1c;
        --red-100: #fee2e2;
        --red-50: #fef2f2;
        --purple-800: #5b21b6;
        --purple-700: #6d28d9;
        --purple-100: #ede9fe;
        --purple-50: #f5f3ff;
        --slate-950: #0f172a;
        --slate-800: #1e293b;
        --slate-700: #334155;
        --slate-600: #475569;
        --slate-500: #64748b;
        --slate-400: #94a3b8;
        --slate-300: #cbd5e1;
        --slate-200: #e2e8f0;
        --slate-100: #f1f5f9;
        --slate-50: #f8fafc;
        --white: #ffffff;

        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 0 72px;

        color: var(--slate-800);
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        font-size: 17px;
        line-height: 1.67;
    }

    .attendance-detail-page *,
    .attendance-detail-page *::before,
    .attendance-detail-page *::after {
        box-sizing: border-box;
    }

    .attendance-detail-page a,
    .attendance-detail-page button {
        font: inherit;
    }

    /*
    |--------------------------------------------------------------------------
    | Top Navigation
    |--------------------------------------------------------------------------
    */

    .detail-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 18px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        min-height: 48px;
        padding: 10px 16px;

        border: 1px solid #cbd5e1;
        border-radius: 12px;

        color: var(--navy-800);
        background: #fff;

        font-size: 14px;
        font-weight: 850;
        text-decoration: none;

        transition:
            border-color .18s ease,
            background .18s ease,
            color .18s ease,
            transform .18s ease;
    }

    .back-button:hover {
        color: var(--blue-700);
        border-color: #93c5fd;
        background: var(--blue-50);
        transform: translateY(-1px);
    }

    .record-reference {
        color: var(--slate-500);
        font-size: 13px;
        font-weight: 750;
    }

    /*
    |--------------------------------------------------------------------------
    | Hero
    |--------------------------------------------------------------------------
    */

    .detail-hero {
        position: relative;
        overflow: hidden;

        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        align-items: center;
        gap: 36px;

        margin-bottom: 24px;
        padding: 38px 40px;

        border-radius: 27px;

        color: #fff;

        background:
            radial-gradient(circle at 90% 0%, rgba(94, 234, 212, .20), transparent 28%),
            radial-gradient(circle at 65% 120%, rgba(96, 165, 250, .17), transparent 34%),
            linear-gradient(135deg, #0b223d 0%, #183b6b 58%, #146b70 115%);

        box-shadow: 0 20px 48px rgba(16, 42, 74, .17);
    }

    .detail-hero::before {
        content: "";
        position: absolute;

        width: 360px;
        height: 360px;

        top: -245px;
        right: -90px;

        border: 1px solid rgba(255, 255, 255, .12);
        border-radius: 50%;
    }

    .hero-main,
    .hero-record-card {
        position: relative;
        z-index: 1;
    }

    .hero-kicker {
        display: inline-flex;
        align-items: center;
        gap: 9px;

        margin-bottom: 14px;
        padding: 8px 13px;

        border: 1px solid rgba(255, 255, 255, .15);
        border-radius: 999px;

        background: rgba(255, 255, 255, .08);
        color: rgba(255, 255, 255, .92);

        font-size: 13px;
        font-weight: 850;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .hero-kicker-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #5eead4;
        box-shadow: 0 0 0 5px rgba(94, 234, 212, .12);
    }

    .detail-hero h1 {
        margin: 0;

        color: #fff;

        font-size: clamp(34px, 4vw, 46px);
        line-height: 1.1;
        font-weight: 900;
        letter-spacing: -.035em;
    }

    .hero-description {
        max-width: 760px;
        margin: 14px 0 0;

        color: rgba(255, 255, 255, .83);

        font-size: 17px;
        line-height: 1.75;
    }

    .hero-student {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-top: 22px;
    }

    .hero-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 52px;
        height: 52px;
        flex: 0 0 52px;

        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 15px;

        color: #fff;
        background: rgba(255, 255, 255, .12);

        font-size: 14px;
        font-weight: 900;
    }

    .hero-student-name {
        display: block;
        color: #fff;
        font-size: 17px;
        font-weight: 900;
    }

    .hero-student-meta {
        display: block;
        margin-top: 2px;
        color: rgba(255, 255, 255, .67);
        font-size: 13px;
    }

    .hero-record-card {
        padding: 21px;

        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 20px;

        background: rgba(255, 255, 255, .10);
        backdrop-filter: blur(5px);
    }

    .hero-record-label {
        display: block;
        color: rgba(255, 255, 255, .64);
        font-size: 11px;
        font-weight: 850;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .hero-record-date {
        display: block;
        margin-top: 5px;
        color: #fff;
        font-size: 25px;
        line-height: 1.25;
        font-weight: 900;
    }

    .hero-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        margin-top: 14px;
        padding: 8px 12px;

        border-radius: 999px;

        font-size: 13px;
        font-weight: 900;
    }

    .hero-status::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
    }

    /*
    |--------------------------------------------------------------------------
    | Status Colors
    |--------------------------------------------------------------------------
    */

    .status-progress {
        color: #115e59;
        background: #ccfbf1;
    }

    .status-pending {
        color: #92400e;
        background: #fef3c7;
    }

    .status-validated {
        color: #166534;
        background: #dcfce7;
    }

    .status-rejected {
        color: #991b1b;
        background: #fee2e2;
    }

    .status-unknown {
        color: #475569;
        background: #f1f5f9;
    }

    /*
    |--------------------------------------------------------------------------
    | Notices
    |--------------------------------------------------------------------------
    */

    .notice {
        display: flex;
        align-items: flex-start;
        gap: 14px;

        margin-bottom: 20px;
        padding: 17px 19px;

        border-radius: 16px;

        font-size: 15px;
        line-height: 1.7;
    }

    .notice-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 38px;
        height: 38px;
        flex: 0 0 38px;

        border-radius: 11px;

        font-size: 12px;
        font-weight: 900;
    }

    .notice strong {
        color: var(--navy-800);
        font-weight: 900;
    }

    .notice-success {
        border: 1px solid #bbf7d0;
        background: var(--green-50);
        color: #166534;
    }

    .notice-success .notice-icon {
        color: #166534;
        background: var(--green-100);
    }

    .notice-error,
    .notice-locked {
        border: 1px solid #fecaca;
        background: var(--red-50);
        color: #991b1b;
    }

    .notice-error .notice-icon,
    .notice-locked .notice-icon {
        color: #991b1b;
        background: var(--red-100);
    }

    .notice-warning {
        border: 1px solid #fde68a;
        background: var(--amber-50);
        color: #92400e;
    }

    .notice-warning .notice-icon {
        color: #92400e;
        background: var(--amber-100);
    }

    .notice-info {
        border: 1px solid #bfdbfe;
        background: var(--blue-50);
        color: #1d4ed8;
    }

    .notice-info .notice-icon {
        color: #1d4ed8;
        background: var(--blue-100);
    }

    /*
    |--------------------------------------------------------------------------
    | OJT Progress
    |--------------------------------------------------------------------------
    */

    .progress-section {
        margin-bottom: 24px;
    }

    .progress-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .progress-card {
        padding: 20px;

        border: 1px solid var(--slate-200);
        border-radius: 18px;

        background: #fff;

        box-shadow: 0 7px 24px rgba(15, 42, 74, .045);
    }

    .progress-label {
        display: block;
        color: var(--slate-500);
        font-size: 13px;
        font-weight: 750;
    }

    .progress-value {
        display: block;
        margin-top: 4px;
        color: var(--navy-800);
        font-size: 29px;
        line-height: 1.15;
        font-weight: 900;
    }

    .progress-note {
        display: block;
        margin-top: 6px;
        color: var(--slate-500);
        font-size: 12px;
        line-height: 1.5;
    }

    .progress-track {
        overflow: hidden;
        width: 100%;
        height: 11px;
        margin-top: 12px;
        border-radius: 999px;
        background: var(--slate-100);
    }

    .progress-fill {
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #2563eb, #0f766e);
    }

    /*
    |--------------------------------------------------------------------------
    | General Cards
    |--------------------------------------------------------------------------
    */

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .detail-card {
        overflow: hidden;

        border: 1px solid var(--slate-200);
        border-radius: 20px;

        background: #fff;

        box-shadow: 0 8px 28px rgba(15, 42, 74, .05);
    }

    .detail-card-header {
        display: flex;
        align-items: center;
        gap: 13px;

        padding: 21px 23px;

        border-bottom: 1px solid #edf2f7;

        background: linear-gradient(180deg, #fff, #fbfdff);
    }

    .card-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 47px;
        height: 47px;
        flex: 0 0 47px;

        border-radius: 14px;

        font-size: 11px;
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
        color: var(--purple-800);
        background: var(--purple-100);
    }

    .detail-card-header h2 {
        margin: 0;

        color: var(--navy-800);

        font-size: 22px;
        line-height: 1.3;
        font-weight: 900;
    }

    .detail-card-header p {
        margin: 4px 0 0;
        color: var(--slate-500);
        font-size: 14px;
    }

    .detail-card-body {
        padding: 22px 23px;
    }

    .detail-list {
        display: grid;
    }

    .detail-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;

        padding: 14px 0;

        border-bottom: 1px solid #edf2f7;
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
        font-size: 14px;
        font-weight: 750;
    }

    .detail-value {
        max-width: 64%;
        color: var(--navy-800);
        font-size: 16px;
        font-weight: 850;
        text-align: right;
        overflow-wrap: anywhere;
    }

    /*
    |--------------------------------------------------------------------------
    | Section Header
    |--------------------------------------------------------------------------
    */

    .section-block {
        margin-top: 24px;
    }

    .section-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 15px;
    }

    .section-heading h2 {
        margin: 0;
        color: var(--navy-800);
        font-size: 25px;
        line-height: 1.25;
        font-weight: 900;
    }

    .section-heading p {
        max-width: 760px;
        margin: 5px 0 0;
        color: var(--slate-500);
        font-size: 15px;
        line-height: 1.65;
    }

    .section-count {
        flex: 0 0 auto;
        padding: 8px 13px;
        border-radius: 999px;
        color: var(--blue-700);
        background: var(--blue-50);
        font-size: 13px;
        font-weight: 850;
    }

    /*
    |--------------------------------------------------------------------------
    | Session Cards
    |--------------------------------------------------------------------------
    */

    .session-list {
        display: grid;
        gap: 18px;
    }

    .session-card {
        overflow: hidden;

        border: 1px solid var(--slate-200);
        border-radius: 21px;

        background: #fff;

        box-shadow: 0 8px 28px rgba(15, 42, 74, .05);
    }

    .session-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;

        padding: 21px 23px;

        border-bottom: 1px solid #edf2f7;

        background:
            linear-gradient(
                90deg,
                #fbfdff,
                #f8fbff
            );
    }

    .session-title-wrap {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .session-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 48px;
        height: 48px;
        flex: 0 0 48px;

        border-radius: 14px;

        color: var(--blue-700);
        background: var(--blue-100);

        font-size: 14px;
        font-weight: 900;
    }

    .session-title {
        margin: 0;
        color: var(--navy-800);
        font-size: 21px;
        line-height: 1.3;
        font-weight: 900;
    }

    .session-subtitle {
        display: block;
        margin-top: 3px;
        color: var(--slate-500);
        font-size: 13px;
    }

    .session-complete-badge,
    .session-open-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        padding: 8px 11px;

        border-radius: 999px;

        font-size: 12px;
        font-weight: 850;
    }

    .session-complete-badge {
        color: var(--green-800);
        background: var(--green-100);
    }

    .session-open-badge {
        color: var(--teal-800);
        background: var(--teal-100);
    }

    .session-complete-badge::before,
    .session-open-badge::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
    }

    .session-body {
        padding: 23px;
    }

    .session-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .session-summary {
        padding: 16px;

        border: 1px solid #e7edf4;
        border-radius: 14px;

        background: var(--slate-50);
    }

    .session-summary-label {
        display: block;
        color: var(--slate-500);
        font-size: 12px;
        font-weight: 750;
    }

    .session-summary-value {
        display: block;
        margin-top: 4px;
        color: var(--navy-800);
        font-size: 19px;
        line-height: 1.3;
        font-weight: 900;
    }

    /*
    |--------------------------------------------------------------------------
    | GPS Evidence
    |--------------------------------------------------------------------------
    */

    .evidence-heading {
        margin: 0 0 11px;
        color: var(--navy-800);
        font-size: 17px;
        font-weight: 900;
    }

    .gps-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .gps-panel {
        padding: 16px;

        border: 1px solid #cce9e2;
        border-radius: 15px;

        background: var(--teal-50);
    }

    .gps-panel-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 11px;
    }

    .gps-panel-title strong {
        color: var(--teal-800);
        font-size: 15px;
        font-weight: 900;
    }

    .gps-evidence-label {
        padding: 5px 8px;
        border-radius: 8px;
        color: var(--teal-800);
        background: var(--teal-100);
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
    }

    .gps-data {
        display: grid;
        gap: 7px;
    }

    .gps-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .gps-label {
        color: var(--slate-500);
        font-size: 13px;
        font-weight: 700;
    }

    .gps-value {
        color: var(--navy-800);
        font-size: 13px;
        font-weight: 850;
        text-align: right;
        word-break: break-word;
    }

    /*
    |--------------------------------------------------------------------------
    | Session Action
    |--------------------------------------------------------------------------
    */

    .session-action-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;

        margin-top: 20px;
        padding-top: 18px;

        border-top: 1px solid #edf2f7;
    }

    .session-action-note {
        max-width: 650px;
        color: var(--slate-500);
        font-size: 13px;
        line-height: 1.55;
    }

    .edit-session-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-height: 48px;
        padding: 10px 16px;

        border-radius: 12px;

        color: #fff;
        background: linear-gradient(135deg, var(--blue-600), var(--blue-700));

        box-shadow: 0 8px 18px rgba(37, 99, 235, .18);

        font-size: 14px;
        font-weight: 900;
        text-decoration: none;
        white-space: nowrap;

        transition:
            transform .18s ease,
            box-shadow .18s ease;
    }

    .edit-session-button:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 11px 22px rgba(37, 99, 235, .23);
    }

    .locked-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-height: 48px;
        padding: 10px 15px;

        border-radius: 12px;

        color: var(--slate-500);
        background: var(--slate-100);

        font-size: 13px;
        font-weight: 850;
        text-align: center;
    }

    /*
    |--------------------------------------------------------------------------
    | Legacy
    |--------------------------------------------------------------------------
    */

    .legacy-card {
        padding: 22px;

        border: 1px solid #fde68a;
        border-radius: 18px;

        color: var(--amber-900);
        background: var(--amber-50);

        font-size: 15px;
        line-height: 1.7;
    }

    .legacy-card strong {
        display: block;
        margin-bottom: 5px;
        color: var(--navy-800);
        font-size: 17px;
        font-weight: 900;
    }

    /*
    |--------------------------------------------------------------------------
    | Validation Review
    |--------------------------------------------------------------------------
    */

    .validation-card {
        margin-top: 24px;
    }

    .validation-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .validation-box {
        padding: 16px;
        border: 1px solid #e7edf4;
        border-radius: 14px;
        background: var(--slate-50);
    }

    .validation-label {
        display: block;
        color: var(--slate-500);
        font-size: 12px;
        font-weight: 750;
    }

    .validation-value {
        display: block;
        margin-top: 4px;
        color: var(--navy-800);
        font-size: 15px;
        font-weight: 850;
    }

    .remarks-panel {
        margin-top: 15px;
        padding: 16px;
        border: 1px solid #dbe5ef;
        border-radius: 14px;
        background: #fbfdff;
    }

    .remarks-panel strong {
        display: block;
        margin-bottom: 6px;
        color: var(--navy-800);
        font-size: 14px;
        font-weight: 900;
    }

    .remarks-panel p {
        margin: 0;
        color: var(--slate-600);
        font-size: 15px;
        line-height: 1.7;
        white-space: pre-wrap;
    }

    /*
    |--------------------------------------------------------------------------
    | Correction History
    |--------------------------------------------------------------------------
    */

    .correction-list {
        display: grid;
        gap: 14px;
    }

    .correction-entry {
        overflow: hidden;

        border: 1px solid #ddd6fe;
        border-radius: 17px;

        background: var(--purple-50);
    }

    .correction-entry-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;

        padding: 17px 18px;

        border-bottom: 1px solid #e9e3fb;
    }

    .correction-entry-title {
        color: var(--purple-800);
        font-size: 16px;
        font-weight: 900;
    }

    .correction-entry-meta {
        margin-top: 3px;
        color: var(--slate-500);
        font-size: 12px;
    }

    .corrected-badge {
        flex: 0 0 auto;
        padding: 7px 10px;
        border-radius: 999px;
        color: var(--purple-800);
        background: var(--purple-100);
        font-size: 11px;
        font-weight: 900;
    }

    .correction-entry-body {
        padding: 17px 18px;
    }

    .correction-comparison {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 11px;
    }

    .comparison-box {
        padding: 14px;

        border: 1px solid #ebe7f8;
        border-radius: 13px;

        background: #fff;
    }

    .comparison-label {
        display: block;
        margin-bottom: 7px;
        color: var(--slate-500);
        font-size: 11px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .comparison-time {
        display: block;
        color: var(--navy-800);
        font-size: 15px;
        font-weight: 900;
    }

    .comparison-rendered {
        display: block;
        margin-top: 4px;
        color: var(--slate-500);
        font-size: 12px;
        font-weight: 700;
    }

    .correction-reason {
        margin-top: 11px;
        padding: 13px 14px;

        border-radius: 13px;

        color: var(--slate-700);
        background: #fff;

        font-size: 14px;
        line-height: 1.65;
    }

    .correction-reason strong {
        color: var(--navy-800);
        font-weight: 900;
    }

    .correction-audit {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 16px;
        margin-top: 11px;
        color: var(--slate-500);
        font-size: 12px;
    }

    /*
    |--------------------------------------------------------------------------
    | Integrity Panel
    |--------------------------------------------------------------------------
    */

    .integrity-panel {
        display: grid;
        grid-template-columns: 58px 1fr;
        gap: 16px;

        margin-top: 24px;
        padding: 20px;

        border: 1px solid #bfdbfe;
        border-radius: 18px;

        background: var(--blue-50);
    }

    .integrity-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 58px;
        height: 58px;

        border-radius: 16px;

        color: var(--blue-700);
        background: var(--blue-100);

        font-size: 13px;
        font-weight: 900;
    }

    .integrity-panel h3 {
        margin: 0;
        color: var(--navy-800);
        font-size: 18px;
        font-weight: 900;
    }

    .integrity-panel p {
        margin: 5px 0 0;
        color: var(--slate-600);
        font-size: 14px;
        line-height: 1.7;
    }

    /*
    |--------------------------------------------------------------------------
    | Empty History
    |--------------------------------------------------------------------------
    */

    .empty-history {
        padding: 30px 20px;
        border: 1px dashed #cbd5e1;
        border-radius: 15px;
        color: var(--slate-500);
        background: var(--slate-50);
        font-size: 14px;
        text-align: center;
    }

    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    .attendance-detail-page a:focus-visible,
    .attendance-detail-page button:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .30);
        outline-offset: 3px;
    }

    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1100px) {
        .detail-hero {
            grid-template-columns: 1fr;
        }

        .hero-record-card {
            width: 100%;
        }

        .progress-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .validation-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .attendance-detail-page {
            font-size: 16px;
        }

        .detail-topbar {
            align-items: flex-start;
            flex-direction: column;
        }

        .detail-hero {
            padding: 29px 22px;
            border-radius: 21px;
        }

        .progress-grid {
            grid-template-columns: 1fr;
        }

        .session-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .session-summary-grid,
        .gps-grid,
        .validation-grid,
        .correction-comparison {
            grid-template-columns: 1fr;
        }

        .session-action-bar {
            align-items: stretch;
            flex-direction: column;
        }

        .edit-session-button,
        .locked-action {
            width: 100%;
        }

        .section-heading {
            align-items: flex-start;
            flex-direction: column;
        }
    }

    @media (max-width: 560px) {
        .detail-card-header,
        .detail-card-body,
        .session-header,
        .session-body {
            padding-left: 17px;
            padding-right: 17px;
        }

        .detail-row {
            flex-direction: column;
            gap: 5px;
        }

        .detail-value {
            max-width: 100%;
            text-align: left;
        }

        .integrity-panel {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="attendance-detail-page">

    {{-- ===============================================================
         TOP BAR
         =============================================================== --}}

    <div class="detail-topbar">

        <a
            href="{{ route('admin.attendance.index') }}"
            class="back-button"
        >
            ← Back to Attendance Management
        </a>

        <span class="record-reference">
            Attendance Record #{{ $attendance->id }}
        </span>

    </div>


    {{-- ===============================================================
         GLOBAL PAGE MESSAGES
         =============================================================== --}}

    @if (session('success'))
        <div class="notice notice-success">
            <span class="notice-icon">OK</span>

            <div>
                <strong>Attendance updated successfully.</strong>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="notice notice-error">
            <span class="notice-icon">!</span>

            <div>
                <strong>Attendance action unavailable.</strong>
                <div>{{ session('error') }}</div>
            </div>
        </div>
    @endif


    {{-- ===============================================================
         HERO
         =============================================================== --}}

    <section class="detail-hero">

        <div class="hero-main">

            <div class="hero-kicker">
                <span class="hero-kicker-dot"></span>
                Administrator · Attendance Review
            </div>

            <h1>
                Attendance Details
            </h1>

            <p class="hero-description">
                Review the Student's daily OJT attendance, Morning and
                Afternoon sessions, rendered time, GPS evidence,
                Supervisor validation, and administrative correction history.
            </p>

            <div class="hero-student">

                <div class="hero-avatar">
                    {{ $studentInitials }}
                </div>

                <div>
                    <span class="hero-student-name">
                        {{ $studentName }}
                    </span>

                    <span class="hero-student-meta">
                        {{ $studentNumber }}
                        ·
                        {{ $program }}
                    </span>
                </div>

            </div>

        </div>


        <div class="hero-record-card">

            <span class="hero-record-label">
                Attendance Date
            </span>

            <span class="hero-record-date">
                {{ $formatDate($attendance->attendance_date) }}
            </span>

            <span class="hero-status {{ $statusClass($attendance->status) }}">
                {{ $statusLabel($attendance->status) }}
            </span>

        </div>

    </section>


    {{-- ===============================================================
         LOCK / REVIEW INFORMATION
         =============================================================== --}}

    @if ($isCompletedAssignment)
        <div class="notice notice-locked">
            <span class="notice-icon">LK</span>

            <div>
                <strong>Attendance history is locked.</strong>
                This OJT Assignment has already been formally completed.
                Historical attendance remains visible, but administrative
                timestamp corrections are disabled.
            </div>
        </div>
    @elseif ($isLiveAttendance)
        <div class="notice notice-warning">
            <span class="notice-icon">IP</span>

            <div>
                <strong>This attendance day is still in progress.</strong>
                Wait until the Student completes the attendance day before
                making an administrative timestamp correction.
            </div>
        </div>
    @elseif ($attendance->status === \App\Models\AttendanceRecord::STATUS_VALIDATED)
        <div class="notice notice-info">
            <span class="notice-icon">RV</span>

            <div>
                <strong>Correction requires Supervisor revalidation.</strong>
                If an Administrator changes a completed timestamp, this daily
                attendance record will return to Pending Review so the
                Supervisor can validate the corrected record again.
            </div>
        </div>
    @endif


    {{-- ===============================================================
         OJT PROGRESS
         =============================================================== --}}

    <section class="progress-section">

        <div class="progress-grid">

            <article class="progress-card">
                <span class="progress-label">
                    Required OJT Hours
                </span>

                <span class="progress-value">
                    {{ number_format($requiredMinutesValue / 60, 1) }}
                </span>

                <span class="progress-note">
                    Total hours required by this assignment
                </span>
            </article>


            <article class="progress-card">
                <span class="progress-label">
                    Validated Hours
                </span>

                <span class="progress-value">
                    {{ number_format($validatedMinutesValue / 60, 1) }}
                </span>

                <span class="progress-note">
                    Supervisor-approved attendance only
                </span>
            </article>


            <article class="progress-card">
                <span class="progress-label">
                    Remaining Hours
                </span>

                <span class="progress-value">
                    {{ number_format($remainingMinutesValue / 60, 1) }}
                </span>

                <span class="progress-note">
                    Hours still needed to meet the requirement
                </span>
            </article>


            <article class="progress-card">
                <span class="progress-label">
                    OJT Progress
                </span>

                <span class="progress-value">
                    {{ number_format($progressValue, 1) }}%
                </span>

                <div class="progress-track">
                    <div
                        class="progress-fill"
                        style="width: {{ $progressValue }}%;"
                    ></div>
                </div>

                <span class="progress-note">
                    Progress bar is capped at 100%
                </span>
            </article>

        </div>

    </section>


    {{-- ===============================================================
         STUDENT + DAILY ATTENDANCE SUMMARY
         =============================================================== --}}

    <div class="detail-grid">

        <section class="detail-card">

            <div class="detail-card-header">

                <div class="card-icon card-icon-blue">
                    ST
                </div>

                <div>
                    <h2>Student & Assignment</h2>
                    <p>Placement and OJT assignment information</p>
                </div>

            </div>


            <div class="detail-card-body">

                <div class="detail-list">

                    <div class="detail-row">
                        <span class="detail-label">Student Name</span>
                        <span class="detail-value">{{ $studentName }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Student Number</span>
                        <span class="detail-value">{{ $studentNumber }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Program</span>
                        <span class="detail-value">{{ $program }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Year Level</span>
                        <span class="detail-value">{{ $yearLevel }}</span>
                    </div>

                    @if ($section)
                        <div class="detail-row">
                            <span class="detail-label">Section</span>
                            <span class="detail-value">{{ $section }}</span>
                        </div>
                    @endif

                    <div class="detail-row">
                        <span class="detail-label">Company</span>
                        <span class="detail-value">{{ $company?->name ?? '—' }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Assigned Supervisor</span>
                        <span class="detail-value">{{ $supervisor?->name ?? '—' }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Assignment Status</span>
                        <span class="detail-value">{{ $assignmentStatusLabel }}</span>
                    </div>

                </div>

            </div>

        </section>


        <section class="detail-card">

            <div class="detail-card-header">

                <div class="card-icon card-icon-teal">
                    DY
                </div>

                <div>
                    <h2>Daily Attendance Summary</h2>
                    <p>Official daily attendance parent record</p>
                </div>

            </div>


            <div class="detail-card-body">

                <div class="detail-list">

                    <div class="detail-row">
                        <span class="detail-label">Attendance Date</span>
                        <span class="detail-value">{{ $formatDate($attendance->attendance_date) }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">First Time In</span>
                        <span class="detail-value">{{ $formatTime($attendance->time_in) }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Last Time Out</span>
                        <span class="detail-value">{{ $formatTime($attendance->time_out) }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Daily Rendered Time</span>
                        <span class="detail-value">{{ $formatMinutes($dailyRenderedMinutes) }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Attendance Status</span>
                        <span class="detail-value">{{ $statusLabel($attendance->status) }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Session Records</span>
                        <span class="detail-value">{{ $sessions->count() }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Admin Corrections</span>
                        <span class="detail-value">{{ $corrections->count() }}</span>
                    </div>

                </div>

            </div>

        </section>

    </div>


    {{-- ===============================================================
         ATTENDANCE SESSIONS
         =============================================================== --}}

    <section class="section-block">

        <div class="section-heading">

            <div>
                <h2>Attendance Sessions</h2>

                <p>
                    Review each Morning or Afternoon attendance session.
                    GPS evidence remains historical evidence and is not
                    modified when an Administrator corrects timestamps.
                </p>
            </div>

            <span class="section-count">
                {{ $sessions->count() }}
                {{ $sessions->count() === 1 ? 'session' : 'sessions' }}
            </span>

        </div>


        @if ($sessions->isNotEmpty())

            <div class="session-list">

                @foreach ($sessions as $session)

                    @php
                        $sessionIsCompleted = $session->time_out !== null;
                        $sessionCanBeEdited = ! $isCompletedAssignment && ! $isLiveAttendance && $sessionIsCompleted;
                    @endphp

                    <article class="session-card">

                        <div class="session-header">

                            <div class="session-title-wrap">

                                <div class="session-number">
                                    {{ str_pad((string) $session->session_number, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                <div>
                                    <h3 class="session-title">
                                        {{ $session->sessionLabel() }}
                                    </h3>

                                    <span class="session-subtitle">
                                        Attendance Session #{{ $session->id }}
                                    </span>
                                </div>

                            </div>


                            @if ($sessionIsCompleted)
                                <span class="session-complete-badge">
                                    Completed
                                </span>
                            @else
                                <span class="session-open-badge">
                                    Open Session
                                </span>
                            @endif

                        </div>


                        <div class="session-body">

                            <div class="session-summary-grid">

                                <div class="session-summary">
                                    <span class="session-summary-label">
                                        Time In
                                    </span>

                                    <span class="session-summary-value">
                                        {{ $formatTime($session->time_in) }}
                                    </span>
                                </div>


                                <div class="session-summary">
                                    <span class="session-summary-label">
                                        Time Out
                                    </span>

                                    <span class="session-summary-value">
                                        {{ $formatTime($session->time_out) }}
                                    </span>
                                </div>


                                <div class="session-summary">
                                    <span class="session-summary-label">
                                        Rendered Time
                                    </span>

                                    <span class="session-summary-value">
                                        {{ $formatMinutes($session->rendered_minutes) }}
                                    </span>
                                </div>

                            </div>


                            <h4 class="evidence-heading">
                                GPS Evidence
                            </h4>


                            <div class="gps-grid">

                                <div class="gps-panel">

                                    <div class="gps-panel-title">
                                        <strong>Time In Location</strong>

                                        <span class="gps-evidence-label">
                                            Original
                                        </span>
                                    </div>

                                    <div class="gps-data">

                                        <div class="gps-row">
                                            <span class="gps-label">Latitude</span>
                                            <span class="gps-value">{{ $formatCoordinate($session->time_in_latitude) }}</span>
                                        </div>

                                        <div class="gps-row">
                                            <span class="gps-label">Longitude</span>
                                            <span class="gps-value">{{ $formatCoordinate($session->time_in_longitude) }}</span>
                                        </div>

                                        <div class="gps-row">
                                            <span class="gps-label">Accuracy</span>
                                            <span class="gps-value">{{ $formatAccuracy($session->time_in_accuracy) }}</span>
                                        </div>

                                    </div>

                                </div>


                                <div class="gps-panel">

                                    <div class="gps-panel-title">
                                        <strong>Time Out Location</strong>

                                        <span class="gps-evidence-label">
                                            Original
                                        </span>
                                    </div>

                                    <div class="gps-data">

                                        <div class="gps-row">
                                            <span class="gps-label">Latitude</span>
                                            <span class="gps-value">{{ $formatCoordinate($session->time_out_latitude) }}</span>
                                        </div>

                                        <div class="gps-row">
                                            <span class="gps-label">Longitude</span>
                                            <span class="gps-value">{{ $formatCoordinate($session->time_out_longitude) }}</span>
                                        </div>

                                        <div class="gps-row">
                                            <span class="gps-label">Accuracy</span>
                                            <span class="gps-value">{{ $formatAccuracy($session->time_out_accuracy) }}</span>
                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="session-action-bar">

                                <div class="session-action-note">
                                    Administrators may correct completed Time In
                                    and Time Out timestamps. The system recalculates
                                    rendered minutes automatically and preserves GPS
                                    and selfie evidence.
                                </div>


                                @if ($sessionCanBeEdited)

                                    <a
                                        href="{{ route('admin.attendance.sessions.edit', $session) }}"
                                        class="edit-session-button"
                                    >
                                        Correct This Session
                                    </a>

                                @elseif ($isCompletedAssignment)

                                    <span class="locked-action">
                                        Locked — OJT Completed
                                    </span>

                                @elseif ($isLiveAttendance)

                                    <span class="locked-action">
                                        Attendance Still In Progress
                                    </span>

                                @else

                                    <span class="locked-action">
                                        Session Must Be Completed
                                    </span>

                                @endif

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="legacy-card">
                <strong>Previous-format attendance record</strong>
                This daily attendance record does not contain separate
                Morning and Afternoon session rows. It remains visible for
                history and reporting, but the current Admin timestamp
                correction workflow is designed for split-session records.
            </div>

        @endif

    </section>


    {{-- ===============================================================
         SUPERVISOR VALIDATION
         =============================================================== --}}

    <section class="section-block validation-card">

        <div class="section-heading">

            <div>
                <h2>Supervisor Validation</h2>

                <p>
                    Review the current validation state and the Supervisor
                    information associated with this attendance day.
                </p>
            </div>

        </div>


        <div class="detail-card">

            <div class="detail-card-header">

                <div class="card-icon card-icon-teal">
                    SV
                </div>

                <div>
                    <h2>Validation Record</h2>
                    <p>Daily approval and Supervisor remarks</p>
                </div>

            </div>


            <div class="detail-card-body">

                <div class="validation-grid">

                    <div class="validation-box">
                        <span class="validation-label">
                            Current Status
                        </span>

                        <span class="validation-value">
                            {{ $statusLabel($attendance->status) }}
                        </span>
                    </div>


                    <div class="validation-box">
                        <span class="validation-label">
                            Validated By
                        </span>

                        <span class="validation-value">
                            {{ $validator?->name ?? 'Not yet validated' }}
                        </span>
                    </div>


                    <div class="validation-box">
                        <span class="validation-label">
                            Validated At
                        </span>

                        <span class="validation-value">
                            {{ $formatDateTime($attendance->validated_at) }}
                        </span>
                    </div>

                </div>


                <div class="remarks-panel">
                    <strong>Supervisor Remarks</strong>

                    <p>{{ $attendance->supervisor_remarks ?: 'No Supervisor remarks have been recorded for this attendance day.' }}</p>
                </div>

            </div>

        </div>

    </section>


    {{-- ===============================================================
         ADMINISTRATIVE CORRECTION HISTORY
         =============================================================== --}}

    <section class="section-block">

        <div class="section-heading">

            <div>
                <h2>Administrative Correction History</h2>

                <p>
                    Every Admin timestamp correction records the original
                    values, corrected values, reason, Administrator, and
                    audit metadata for accountability.
                </p>
            </div>

            <span class="section-count">
                {{ $corrections->count() }}
                {{ $corrections->count() === 1 ? 'correction' : 'corrections' }}
            </span>

        </div>


        <div class="detail-card">

            <div class="detail-card-header">

                <div class="card-icon card-icon-purple">
                    AU
                </div>

                <div>
                    <h2>Correction Audit Trail</h2>
                    <p>Permanent administrative history for this attendance date</p>
                </div>

            </div>


            <div class="detail-card-body">

                @if ($hasCorrections)

                    <div class="correction-list">

                        @foreach ($corrections as $correction)

                            <article class="correction-entry">

                                <div class="correction-entry-header">

                                    <div>
                                        <div class="correction-entry-title">
                                            {{ $correction->sessionLabel() }} Correction
                                        </div>

                                        <div class="correction-entry-meta">
                                            Corrected by
                                            {{ $correction->correctedBy?->name ?? 'Administrator' }}
                                            ·
                                            {{ $formatDateTime($correction->created_at) }}
                                        </div>
                                    </div>

                                    <span class="corrected-badge">
                                        Admin Corrected
                                    </span>

                                </div>


                                <div class="correction-entry-body">

                                    <div class="correction-comparison">

                                        <div class="comparison-box">
                                            <span class="comparison-label">
                                                Original Session
                                            </span>

                                            <span class="comparison-time">
                                                {{ $formatTime($correction->original_time_in) }}
                                                →
                                                {{ $formatTime($correction->original_time_out) }}
                                            </span>

                                            <span class="comparison-rendered">
                                                {{ $formatMinutes($correction->original_rendered_minutes) }}
                                            </span>
                                        </div>


                                        <div class="comparison-box">
                                            <span class="comparison-label">
                                                Corrected Session
                                            </span>

                                            <span class="comparison-time">
                                                {{ $formatTime($correction->corrected_time_in) }}
                                                →
                                                {{ $formatTime($correction->corrected_time_out) }}
                                            </span>

                                            <span class="comparison-rendered">
                                                {{ $formatMinutes($correction->corrected_rendered_minutes) }}
                                            </span>
                                        </div>

                                    </div>


                                    <div class="correction-comparison" style="margin-top: 11px;">

                                        <div class="comparison-box">
                                            <span class="comparison-label">
                                                Original Daily Total
                                            </span>

                                            <span class="comparison-time">
                                                {{ $formatMinutes($correction->original_daily_rendered_minutes) }}
                                            </span>
                                        </div>


                                        <div class="comparison-box">
                                            <span class="comparison-label">
                                                Corrected Daily Total
                                            </span>

                                            <span class="comparison-time">
                                                {{ $formatMinutes($correction->corrected_daily_rendered_minutes) }}
                                            </span>
                                        </div>

                                    </div>


                                    <div class="correction-reason">
                                        <strong>Correction Reason:</strong>
                                        {{ $correction->reason }}
                                    </div>


                                    <div class="correction-audit">
                                        <span>
                                            Attendance date:
                                            {{ $formatDate($correction->attendance_date) }}
                                        </span>

                                        @if ($correction->ip_address)
                                            <span>
                                                IP:
                                                {{ $correction->ip_address }}
                                            </span>
                                        @endif
                                    </div>

                                </div>

                            </article>

                        @endforeach

                    </div>

                @else

                    <div class="empty-history">
                        No administrative timestamp corrections have been
                        recorded for this attendance date.
                    </div>

                @endif

            </div>

        </div>

    </section>


    {{-- ===============================================================
         DATA INTEGRITY
         =============================================================== --}}

    <section class="integrity-panel">

        <div class="integrity-icon">
            SEC
        </div>

        <div>
            <h3>Attendance Evidence Integrity</h3>

            <p>
                Administrative correction is limited to completed session
                timestamps. Rendered time is recalculated by the server.
                GPS coordinates and selfie evidence remain unchanged so the
                original attendance evidence is preserved. A corrected
                attendance record returns to Pending Review for Supervisor
                validation when applicable.
            </p>
        </div>

    </section>

</div>
@endsection
