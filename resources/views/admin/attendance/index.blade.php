@extends('layouts.app')

@section('title', 'Attendance Management | OJT Sync')

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
                ->format('M d, Y');
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

    $initials = static function (?string $name): string {
        $name = trim((string) $name);

        if ($name === '') {
            return 'ST';
        }

        $parts = preg_split('/\s+/', $name) ?: [];
        $first = $parts[0] ?? '';
        $last = count($parts) > 1 ? ($parts[count($parts) - 1] ?? '') : '';

        $value = mb_strtoupper(
            mb_substr($first, 0, 1)
            .mb_substr($last, 0, 1)
        );

        return $value !== '' ? $value : 'ST';
    };
@endphp

@push('styles')
<style>
    /*
    |--------------------------------------------------------------------------
    | Attendance Management Page
    |--------------------------------------------------------------------------
    */

    .attendance-admin {
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
        --amber-900: #92400e;
        --amber-100: #fef3c7;
        --red-800: #991b1b;
        --red-100: #fee2e2;
        --purple-800: #5b21b6;
        --purple-100: #ede9fe;
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
        line-height: 1.65;
    }

    .attendance-admin *,
    .attendance-admin *::before,
    .attendance-admin *::after {
        box-sizing: border-box;
    }

    .attendance-admin a,
    .attendance-admin button,
    .attendance-admin input,
    .attendance-admin select {
        font: inherit;
    }

    /*
    |--------------------------------------------------------------------------
    | Hero
    |--------------------------------------------------------------------------
    */

    .attendance-hero {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 250px;
        align-items: center;
        gap: 34px;
        margin-bottom: 24px;
        padding: 38px 40px;
        border-radius: 26px;
        color: var(--white);
        background:
            radial-gradient(circle at 92% 4%, rgba(94, 234, 212, .20), transparent 28%),
            radial-gradient(circle at 72% 120%, rgba(96, 165, 250, .18), transparent 34%),
            linear-gradient(135deg, #0b223d 0%, #183b6b 62%, #146b70 120%);
        box-shadow: 0 18px 46px rgba(16, 42, 74, .16);
    }

    .attendance-hero::after {
        content: "";
        position: absolute;
        width: 330px;
        height: 330px;
        top: -220px;
        right: -90px;
        border: 1px solid rgba(255, 255, 255, .11);
        border-radius: 50%;
    }

    .hero-copy,
    .hero-summary {
        position: relative;
        z-index: 1;
    }

    .hero-kicker {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 13px;
        padding: 8px 13px;
        border: 1px solid rgba(255, 255, 255, .15);
        border-radius: 999px;
        background: rgba(255, 255, 255, .08);
        color: rgba(255, 255, 255, .92);
        font-size: 13px;
        font-weight: 800;
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

    .attendance-hero h1 {
        margin: 0;
        color: #fff;
        font-size: clamp(34px, 4vw, 46px);
        line-height: 1.1;
        font-weight: 900;
        letter-spacing: -.035em;
    }

    .attendance-hero p {
        max-width: 800px;
        margin: 15px 0 0;
        color: rgba(255, 255, 255, .83);
        font-size: 17px;
        line-height: 1.75;
    }

    .hero-summary {
        padding: 21px;
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 19px;
        background: rgba(255, 255, 255, .10);
        backdrop-filter: blur(6px);
    }

    .hero-summary-label {
        display: block;
        color: rgba(255, 255, 255, .66);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .hero-summary-value {
        display: block;
        margin-top: 4px;
        color: #fff;
        font-size: 40px;
        line-height: 1.1;
        font-weight: 900;
    }

    .hero-summary-copy {
        display: block;
        margin-top: 8px;
        color: rgba(255, 255, 255, .76);
        font-size: 13px;
        line-height: 1.55;
    }

    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

    .attendance-stats {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }

    .stat-card {
        min-width: 0;
        padding: 19px;
        border: 1px solid var(--slate-200);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 7px 24px rgba(15, 42, 74, .045);
    }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 14px;
    }

    .stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 43px;
        border-radius: 13px;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .02em;
    }

    .stat-total .stat-icon { color: var(--blue-700); background: var(--blue-100); }
    .stat-progress .stat-icon { color: var(--teal-800); background: var(--teal-100); }
    .stat-pending .stat-icon { color: var(--amber-900); background: var(--amber-100); }
    .stat-validated .stat-icon { color: var(--green-800); background: var(--green-100); }
    .stat-corrections .stat-icon { color: var(--purple-800); background: var(--purple-100); }

    .stat-caption {
        color: var(--slate-500);
        font-size: 12px;
        font-weight: 750;
    }

    .stat-number {
        display: block;
        margin-top: 3px;
        color: var(--navy-800);
        font-size: 29px;
        line-height: 1.1;
        font-weight: 900;
    }

    .stat-label {
        display: block;
        margin-top: 5px;
        color: var(--slate-600);
        font-size: 14px;
        font-weight: 700;
    }

    /*
    |--------------------------------------------------------------------------
    | Filter Panel
    |--------------------------------------------------------------------------
    */

    .filter-panel {
        margin-bottom: 24px;
        padding: 23px;
        border: 1px solid var(--slate-200);
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 7px 24px rgba(15, 42, 74, .045);
    }

    .filter-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 18px;
    }

    .filter-heading h2 {
        margin: 0;
        color: var(--navy-800);
        font-size: 23px;
        line-height: 1.25;
        font-weight: 900;
    }

    .filter-heading p {
        margin: 5px 0 0;
        color: var(--slate-500);
        font-size: 14px;
    }

    .result-count {
        flex: 0 0 auto;
        padding: 8px 13px;
        border-radius: 999px;
        color: var(--blue-700);
        background: var(--blue-50);
        font-size: 13px;
        font-weight: 850;
    }

    .filter-form {
        display: grid;
        grid-template-columns: minmax(270px, 1fr) 220px 190px auto auto;
        gap: 12px;
        align-items: end;
    }

    .field {
        display: grid;
        gap: 7px;
    }

    .field label {
        color: var(--navy-800);
        font-size: 14px;
        font-weight: 800;
    }

    .field input,
    .field select {
        width: 100%;
        min-height: 54px;
        padding: 0 14px;
        border: 1px solid #c9d7e6;
        border-radius: 12px;
        outline: none;
        color: var(--navy-800);
        background: #fbfdff;
        font-size: 16px;
        font-weight: 650;
        transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
    }

    .field input:focus,
    .field select:focus {
        border-color: var(--blue-600);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
    }

    .filter-button,
    .clear-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 54px;
        padding: 0 18px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 850;
        text-decoration: none;
        white-space: nowrap;
    }

    .filter-button {
        border: 0;
        color: #fff;
        background: linear-gradient(135deg, var(--blue-600), var(--blue-700));
        box-shadow: 0 8px 18px rgba(37, 99, 235, .18);
        cursor: pointer;
    }

    .clear-button {
        border: 1px solid #c8d6e5;
        color: var(--navy-800);
        background: #fff;
    }

    .clear-button:hover {
        color: var(--blue-700);
        border-color: #93c5fd;
        background: var(--blue-50);
    }

    /*
    |--------------------------------------------------------------------------
    | Records Panel
    |--------------------------------------------------------------------------
    */

    .records-panel {
        overflow: hidden;
        border: 1px solid var(--slate-200);
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 10px 32px rgba(15, 42, 74, .05);
    }

    .records-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 24px 25px;
        border-bottom: 1px solid #edf2f7;
        background: linear-gradient(180deg, #fff, #fbfdff);
    }

    .records-title-wrap {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .records-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        flex: 0 0 50px;
        border-radius: 15px;
        color: var(--teal-800);
        background: var(--teal-100);
        font-size: 12px;
        font-weight: 900;
    }

    .records-header h2 {
        margin: 0;
        color: var(--navy-800);
        font-size: 24px;
        line-height: 1.25;
        font-weight: 900;
    }

    .records-header p {
        margin: 4px 0 0;
        color: var(--slate-500);
        font-size: 14px;
    }

    /*
    |--------------------------------------------------------------------------
    | Desktop Table
    |--------------------------------------------------------------------------
    */

    .table-wrap {
        overflow-x: auto;
    }

    .attendance-table {
        width: 100%;
        min-width: 1050px;
        border-collapse: collapse;
    }

    .attendance-table thead th {
        padding: 14px 17px;
        border-bottom: 1px solid var(--slate-200);
        color: var(--slate-500);
        background: var(--slate-50);
        font-size: 12px;
        font-weight: 850;
        letter-spacing: .035em;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .attendance-table tbody td {
        padding: 18px 17px;
        border-bottom: 1px solid #edf2f7;
        vertical-align: middle;
        color: var(--slate-700);
        font-size: 15px;
    }

    .attendance-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .attendance-table tbody tr {
        transition: background .16s ease;
    }

    .attendance-table tbody tr:hover {
        background: #fbfdff;
    }

    .student-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 230px;
    }

    .student-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        border: 1px solid #bfe4dd;
        border-radius: 14px;
        color: var(--teal-800);
        background: var(--teal-50);
        font-size: 13px;
        font-weight: 900;
    }

    .student-name {
        display: block;
        color: var(--navy-800);
        font-size: 16px;
        line-height: 1.35;
        font-weight: 900;
    }

    .student-number,
    .muted-copy {
        display: block;
        margin-top: 3px;
        color: var(--slate-500);
        font-size: 13px;
        line-height: 1.45;
    }

    .primary-value {
        color: var(--navy-800);
        font-size: 15px;
        font-weight: 850;
    }

    .company-cell {
        min-width: 180px;
    }

    /*
    |--------------------------------------------------------------------------
    | Sessions
    |--------------------------------------------------------------------------
    */

    .session-stack {
        display: grid;
        gap: 6px;
        min-width: 185px;
    }

    .session-row {
        display: grid;
        grid-template-columns: 66px 1fr;
        gap: 7px;
        align-items: center;
    }

    .session-tag {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 27px;
        padding: 4px 7px;
        border-radius: 8px;
        color: var(--blue-700);
        background: var(--blue-50);
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
    }

    .session-time {
        color: var(--slate-700);
        font-size: 12px;
        font-weight: 750;
        white-space: nowrap;
    }

    .legacy-label {
        display: inline-flex;
        padding: 6px 9px;
        border-radius: 9px;
        color: var(--slate-600);
        background: var(--slate-100);
        font-size: 11px;
        font-weight: 800;
    }

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 850;
        white-space: nowrap;
    }

    .status-badge::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-progress { color: var(--teal-800); background: var(--teal-100); }
    .status-pending { color: var(--amber-900); background: var(--amber-100); }
    .status-validated { color: var(--green-800); background: var(--green-100); }
    .status-rejected { color: var(--red-800); background: var(--red-100); }
    .status-unknown { color: var(--slate-600); background: var(--slate-100); }

    /*
    |--------------------------------------------------------------------------
    | Action
    |--------------------------------------------------------------------------
    */

    .review-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 9px 14px;
        border-radius: 11px;
        color: #fff;
        background: linear-gradient(135deg, var(--blue-600), var(--blue-700));
        box-shadow: 0 7px 16px rgba(37, 99, 235, .17);
        font-size: 13px;
        font-weight: 850;
        text-decoration: none;
        white-space: nowrap;
        transition: transform .16s ease, box-shadow .16s ease;
    }

    .review-button:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 10px 21px rgba(37, 99, 235, .22);
    }

    /*
    |--------------------------------------------------------------------------
    | Empty State
    |--------------------------------------------------------------------------
    */

    .empty-state {
        padding: 60px 24px;
        text-align: center;
    }

    .empty-icon {
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

    .empty-state h3 {
        margin: 0;
        color: var(--navy-800);
        font-size: 23px;
        font-weight: 900;
    }

    .empty-state p {
        max-width: 560px;
        margin: 8px auto 0;
        color: var(--slate-500);
        font-size: 15px;
        line-height: 1.7;
    }

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    .pagination-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 18px 22px;
        border-top: 1px solid #edf2f7;
        background: var(--slate-50);
    }

    .pagination-copy {
        color: var(--slate-500);
        font-size: 13px;
        font-weight: 700;
    }

    .pagination-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .page-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 8px 13px;
        border: 1px solid #c8d6e5;
        border-radius: 10px;
        color: var(--navy-800);
        background: #fff;
        font-size: 13px;
        font-weight: 850;
        text-decoration: none;
    }

    .page-button:hover {
        color: var(--blue-700);
        border-color: #93c5fd;
        background: var(--blue-50);
    }

    .page-button.disabled {
        color: var(--slate-400);
        background: var(--slate-100);
        pointer-events: none;
    }

    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    .attendance-admin a:focus-visible,
    .attendance-admin button:focus-visible,
    .attendance-admin input:focus-visible,
    .attendance-admin select:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .28);
        outline-offset: 3px;
    }

    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1180px) {
        .attendance-stats {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .filter-form {
            grid-template-columns: minmax(250px, 1fr) 210px 180px;
        }

        .filter-button,
        .clear-button {
            width: 100%;
        }
    }

    @media (max-width: 820px) {
        .attendance-hero {
            grid-template-columns: 1fr;
            padding: 30px 24px;
        }

        .hero-summary {
            width: 100%;
        }

        .attendance-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .filter-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .filter-form {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 620px) {
        .attendance-admin {
            font-size: 16px;
        }

        .attendance-hero {
            padding: 27px 20px;
            border-radius: 20px;
        }

        .attendance-hero p {
            font-size: 16px;
        }

        .attendance-stats {
            grid-template-columns: 1fr;
        }

        .filter-panel {
            padding: 18px;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .records-header {
            padding: 19px;
        }

        .pagination-bar {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="attendance-admin">

    {{-- ===============================================================
         HERO
         =============================================================== --}}

    <section class="attendance-hero">
        <div class="hero-copy">
            <div class="hero-kicker">
                <span class="hero-kicker-dot"></span>
                Attendance Control Center
            </div>

            <h1>Attendance Management</h1>

            <p>
                Review daily Student OJT attendance, monitor Morning and
                Afternoon sessions, track validation status, and open
                individual records for secure administrative corrections.
            </p>
        </div>

        <div class="hero-summary">
            <span class="hero-summary-label">
                Total Attendance Records
            </span>

            <span class="hero-summary-value">
                {{ number_format($totalRecords) }}
            </span>

            <span class="hero-summary-copy">
                {{ number_format($correctionCount) }}
                {{ $correctionCount === 1 ? 'administrative correction' : 'administrative corrections' }}
                recorded.
            </span>
        </div>
    </section>


    {{-- ===============================================================
         STATISTICS
         =============================================================== --}}

    <section class="attendance-stats">

        <article class="stat-card stat-total">
            <div class="stat-top">
                <span class="stat-icon">ALL</span>
                <span class="stat-caption">Records</span>
            </div>

            <span class="stat-number">
                {{ number_format($totalRecords) }}
            </span>

            <span class="stat-label">
                Total Attendance
            </span>
        </article>


        <article class="stat-card stat-progress">
            <div class="stat-top">
                <span class="stat-icon">IP</span>
                <span class="stat-caption">Live</span>
            </div>

            <span class="stat-number">
                {{ number_format($inProgressCount) }}
            </span>

            <span class="stat-label">
                In Progress
            </span>
        </article>


        <article class="stat-card stat-pending">
            <div class="stat-top">
                <span class="stat-icon">PD</span>
                <span class="stat-caption">Review</span>
            </div>

            <span class="stat-number">
                {{ number_format($pendingCount) }}
            </span>

            <span class="stat-label">
                Pending Review
            </span>
        </article>


        <article class="stat-card stat-validated">
            <div class="stat-top">
                <span class="stat-icon">OK</span>
                <span class="stat-caption">Approved</span>
            </div>

            <span class="stat-number">
                {{ number_format($validatedCount) }}
            </span>

            <span class="stat-label">
                Validated
            </span>
        </article>


        <article class="stat-card stat-corrections">
            <div class="stat-top">
                <span class="stat-icon">ED</span>
                <span class="stat-caption">Audit</span>
            </div>

            <span class="stat-number">
                {{ number_format($correctionCount) }}
            </span>

            <span class="stat-label">
                Admin Corrections
            </span>
        </article>

    </section>


    {{-- ===============================================================
         FILTERS
         =============================================================== --}}

    <section class="filter-panel">

        <div class="filter-heading">
            <div>
                <h2>Find Attendance Records</h2>

                <p>
                    Search by Student name, Student number, company, date,
                    or attendance status.
                </p>
            </div>

            <span class="result-count">
                {{ number_format($attendanceRecords->total()) }}
                {{ $attendanceRecords->total() === 1 ? 'result' : 'results' }}
            </span>
        </div>


        <form
            method="GET"
            action="{{ route('admin.attendance.index') }}"
            class="filter-form"
        >

            <div class="field">
                <label for="attendanceSearch">
                    Student or Company
                </label>

                <input
                    id="attendanceSearch"
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search name, student number or company..."
                    autocomplete="off"
                >
            </div>


            <div class="field">
                <label for="attendanceStatus">
                    Status
                </label>

                <select
                    id="attendanceStatus"
                    name="status"
                >
                    <option value="">
                        All Statuses
                    </option>

                    <option
                        value="{{ \App\Models\AttendanceRecord::STATUS_IN_PROGRESS }}"
                        @selected($status === \App\Models\AttendanceRecord::STATUS_IN_PROGRESS)
                    >
                        In Progress
                    </option>

                    <option
                        value="{{ \App\Models\AttendanceRecord::STATUS_PENDING }}"
                        @selected($status === \App\Models\AttendanceRecord::STATUS_PENDING)
                    >
                        Pending Review
                    </option>

                    <option
                        value="{{ \App\Models\AttendanceRecord::STATUS_VALIDATED }}"
                        @selected($status === \App\Models\AttendanceRecord::STATUS_VALIDATED)
                    >
                        Validated
                    </option>

                    <option
                        value="{{ \App\Models\AttendanceRecord::STATUS_REJECTED }}"
                        @selected($status === \App\Models\AttendanceRecord::STATUS_REJECTED)
                    >
                        Rejected
                    </option>
                </select>
            </div>


            <div class="field">
                <label for="attendanceDate">
                    Date
                </label>

                <input
                    id="attendanceDate"
                    type="date"
                    name="date"
                    value="{{ $attendanceDate }}"
                >
            </div>


            <button
                type="submit"
                class="filter-button"
            >
                Apply Filters
            </button>


            <a
                href="{{ route('admin.attendance.index') }}"
                class="clear-button"
            >
                Clear
            </a>

        </form>

    </section>


    {{-- ===============================================================
         RECORDS
         =============================================================== --}}

    <section class="records-panel">

        <div class="records-header">
            <div class="records-title-wrap">

                <div class="records-icon">
                    AT
                </div>

                <div>
                    <h2>Student Attendance Records</h2>

                    <p>
                        Open a daily record to review its sessions,
                        validation state, and correction options.
                    </p>
                </div>

            </div>
        </div>


        @if ($attendanceRecords->count() > 0)

            <div class="table-wrap">

                <table class="attendance-table">

                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Company</th>
                            <th>Sessions</th>
                            <th>Rendered</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($attendanceRecords as $attendance)

                            @php
                                $assignment = $attendance->ojtAssignment;
                                $profile = $assignment?->studentProfile;
                                $student = $profile?->user;
                                $company = $assignment?->company;

                                $sessions = $attendance->relationLoaded('sessions')
                                    ? $attendance->getRelation('sessions')
                                    : collect();

                                $morningSession = $sessions->firstWhere(
                                    'session_number',
                                    \App\Models\AttendanceSession::MORNING_SESSION
                                );

                                $afternoonSession = $sessions->firstWhere(
                                    'session_number',
                                    \App\Models\AttendanceSession::AFTERNOON_SESSION
                                );

                                $studentName = $student?->name ?? 'Unknown Student';
                                $studentNumber = $profile?->student_number ?? 'No Student Number';
                                $companyName = $company?->name ?? 'No Company Assigned';
                            @endphp

                            <tr>

                                <td>
                                    <div class="student-cell">

                                        <div class="student-avatar">
                                            {{ $initials($studentName) }}
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
                                </td>


                                <td>
                                    <span class="primary-value">
                                        {{ $formatDate($attendance->attendance_date) }}
                                    </span>
                                </td>


                                <td class="company-cell">
                                    <span class="primary-value">
                                        {{ $companyName }}
                                    </span>

                                    @if ($assignment?->supervisor)
                                        <span class="muted-copy">
                                            Supervisor: {{ $assignment->supervisor->name }}
                                        </span>
                                    @endif
                                </td>


                                <td>
                                    @if ($sessions->isNotEmpty())

                                        <div class="session-stack">

                                            <div class="session-row">
                                                <span class="session-tag">
                                                    Morning
                                                </span>

                                                <span class="session-time">
                                                    {{ $formatTime($morningSession?->time_in) }}
                                                    –
                                                    {{ $formatTime($morningSession?->time_out) }}
                                                </span>
                                            </div>

                                            <div class="session-row">
                                                <span class="session-tag">
                                                    Afternoon
                                                </span>

                                                <span class="session-time">
                                                    {{ $formatTime($afternoonSession?->time_in) }}
                                                    –
                                                    {{ $formatTime($afternoonSession?->time_out) }}
                                                </span>
                                            </div>

                                        </div>

                                    @else

                                        <span class="legacy-label">
                                            Previous Format
                                        </span>

                                    @endif
                                </td>


                                <td>
                                    <span class="primary-value">
                                        {{ $formatMinutes($attendance->rendered_minutes) }}
                                    </span>
                                </td>


                                <td>
                                    <span class="status-badge {{ $statusClass($attendance->status) }}">
                                        {{ $statusLabel($attendance->status) }}
                                    </span>
                                </td>


                                <td>
                                    <a
                                        href="{{ route('admin.attendance.show', $attendance) }}"
                                        class="review-button"
                                    >
                                        Review
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            @if ($attendanceRecords->hasPages())

                <div class="pagination-bar">

                    <div class="pagination-copy">
                        Showing
                        {{ number_format($attendanceRecords->firstItem() ?? 0) }}
                        to
                        {{ number_format($attendanceRecords->lastItem() ?? 0) }}
                        of
                        {{ number_format($attendanceRecords->total()) }}
                        records
                    </div>


                    <div class="pagination-actions">

                        @if ($attendanceRecords->onFirstPage())
                            <span class="page-button disabled">
                                ← Previous
                            </span>
                        @else
                            <a
                                href="{{ $attendanceRecords->previousPageUrl() }}"
                                class="page-button"
                            >
                                ← Previous
                            </a>
                        @endif


                        @if ($attendanceRecords->hasMorePages())
                            <a
                                href="{{ $attendanceRecords->nextPageUrl() }}"
                                class="page-button"
                            >
                                Next →
                            </a>
                        @else
                            <span class="page-button disabled">
                                Next →
                            </span>
                        @endif

                    </div>

                </div>

            @endif

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    AT
                </div>

                <h3>No attendance records found</h3>

                <p>
                    There are no Student attendance records matching the
                    current filters. Clear the filters or choose another
                    search value.
                </p>

            </div>

        @endif

    </section>

</div>
@endsection
