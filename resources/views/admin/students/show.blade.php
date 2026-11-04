@extends('layouts.app')

@section('title', 'Student Record | OJT Sync')

@push('styles')
<style>

    /* ================================================================
       OJT SYNC
       ADMIN STUDENT RECORD
       PROFESSIONAL + HIGH READABILITY
       ================================================================ */
    :root {
        --sr-navy: #183B6B;
        --sr-navy-dark: #102A4A;
        --sr-navy-deep: #0B223D;
        --sr-blue: #2563EB;
        --sr-blue-light: #60A5FA;
        --sr-blue-soft: #EAF2FF;
        --sr-teal: #0F766E;
        --sr-teal-soft: #E7F7F5;
        --sr-green: #15803D;
        --sr-green-soft: #EAF8EF;
        --sr-orange: #B45309;
        --sr-orange-soft: #FFF5E6;
        --sr-red: #B42318;
        --sr-red-dark: #92231B;
        --sr-red-soft: #FFF0EE;
        --sr-purple: #6D4FC2;
        --sr-purple-soft: #F2EEFF;
        --sr-gray: #475569;
        --sr-gray-soft: #F1F5F9;
        --sr-text: #102A4A;
        --sr-body: #405872;
        --sr-muted: #64778C;
        --sr-white: #FFFFFF;
        --sr-soft: #F8FBFE;
        --sr-border: #D8E3EE;
        --sr-border-soft: #E7EDF4;
        --sr-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);
        --sr-shadow-large:
            0 22px 54px
            rgba(15, 42, 74, 0.13);
        --sr-transition:
            all 0.22s ease;
    }

    /* ================================================================
       PAGE
       ================================================================ */
    .student-record-page {
        width: 100%;
        color:
            var(--sr-text);
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
    .student-record-hero {
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        padding:
            42px
            44px;
        border-radius: 29px;
        background:
            radial-gradient(
                circle at 90% 14%,
                rgba(96, 165, 250, 0.25),
                transparent 26%
            ),
            radial-gradient(
                circle at 70% 92%,
                rgba(45, 212, 191, 0.10),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 55%,
                #285F98 100%
            );
        box-shadow:
            var(--sr-shadow-large);
    }

    .student-record-hero::before {
        content: "";
        position: absolute;
        width: 390px;
        height: 390px;
        right: -150px;
        top: -230px;
        border-radius: 50%;
        background:
            rgba(255, 255, 255, 0.06);
    }

    .student-record-hero-inner {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 38px;
    }

    .student-record-identity {
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 22px;
    }

    .student-record-avatar {
        width: 92px;
        height: 92px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border:
            2px solid
            rgba(255, 255, 255, 0.18);
        border-radius: 25px;
        background:
            rgba(255, 255, 255, 0.12);
        color:
            #FFFFFF;
        font-size: 27px;
        font-weight: 900;
        box-shadow:
            inset 0 1px 0
            rgba(255, 255, 255, 0.12);
    }

    .student-record-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 9px;
        padding:
            7px
            12px;
        border:
            1px solid
            rgba(255, 255, 255, 0.15);
        border-radius: 999px;
        background:
            rgba(255, 255, 255, 0.08);
        color:
            rgba(255, 255, 255, 0.90);
        font-size: 14px;
        font-weight: 800;
    }

    .student-record-eyebrow-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background:
            var(--sr-blue-light);
    }

    .student-record-hero h1 {
        margin:
            0
            0
            6px;
        color:
            #FFFFFF;
        font-size: 36px;
        font-weight: 900;
        line-height: 1.2;
        letter-spacing:
            -0.4px;
    }

    .student-record-email {
        margin: 0;
        color:
            rgba(255, 255, 255, 0.78);
        font-size: 16px;
        word-break:
            break-word;
    }

    /* ================================================================
       HERO ACTIONS
       ================================================================ */
    .student-record-hero-actions {
        width: 280px;
        flex-shrink: 0;
        display: grid;
        gap: 10px;
    }

    .student-record-hero-btn {
        min-height: 51px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding:
            0
            16px;
        border:
            1px solid
            rgba(255, 255, 255, 0.18);
        border-radius: 12px;
        font-family: inherit;
        font-size: 15px;
        font-weight: 850;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition:
            var(--sr-transition);
    }

    .hero-btn-primary {
        background:
            #FFFFFF;
        color:
            var(--sr-navy);
    }

    .hero-btn-primary:hover {
        transform:
            translateY(-2px);
        background:
            #F8FBFF;
    }

    .hero-btn-secondary {
        background:
            rgba(255, 255, 255, 0.09);
        color:
            #FFFFFF;
    }

    .hero-btn-secondary:hover {
        transform:
            translateY(-2px);
        background:
            rgba(255, 255, 255, 0.15);
    }

    /* ================================================================
       STATUS STRIP
       ================================================================ */
    .student-record-status-strip {
        display: grid;
        grid-template-columns:
            repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }

    .student-record-stat {
        padding: 22px;
        border:
            1px solid
            var(--sr-border);
        border-radius: 19px;
        background:
            #FFFFFF;
        box-shadow:
            var(--sr-shadow);
    }

    .student-record-stat-label {
        display: block;
        margin-bottom: 7px;
        color:
            var(--sr-muted);
        font-size: 14px;
        font-weight: 750;
    }

    .student-record-stat-value {
        display: block;
        color:
            var(--sr-text);
        font-size: 25px;
        font-weight: 900;
        line-height: 1.25;
    }

    .student-record-stat-note {
        display: block;
        margin-top: 6px;
        color:
            var(--sr-muted);
        font-size: 14px;
        line-height: 1.5;
    }

    /* ================================================================
       STATUS BADGES
       ================================================================ */
    .record-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding:
            8px
            12px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: 850;
    }

    .record-status-badge::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }

    .record-active {
        background:
            var(--sr-green-soft);
        color:
            var(--sr-green);
    }

    .record-active::before {
        background:
            #22C55E;
    }

    .record-inactive {
        background:
            var(--sr-orange-soft);
        color:
            var(--sr-orange);
    }

    .record-inactive::before {
        background:
            #F59E0B;
    }

    /* ================================================================
       MAIN GRID
       ================================================================ */
    .student-record-layout {
        display: grid;
        grid-template-columns:
            minmax(0, 1fr)
            345px;
        gap: 24px;
        align-items: start;
    }

    .student-record-main,
    .student-record-sidebar {
        display: grid;
        gap: 22px;
    }

    /* ================================================================
       PANELS
       ================================================================ */
    .record-panel {
        overflow: hidden;
        border:
            1px solid
            var(--sr-border);
        border-radius: 19px;
        background:
            #FFFFFF;
        box-shadow:
            var(--sr-shadow);
    }

    .record-panel-header {
        display: flex;
        align-items: center;
        gap: 13px;
        padding:
            21px
            22px;
        border-bottom:
            1px solid
            var(--sr-border-soft);
        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }

    .record-panel-icon {
        width: 45px;
        height: 45px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 12px;
        font-weight: 900;
    }

    .panel-blue {
        background:
            var(--sr-blue-soft);
        color:
            var(--sr-blue);
    }

    .panel-teal {
        background:
            var(--sr-teal-soft);
        color:
            var(--sr-teal);
    }

    .panel-purple {
        background:
            var(--sr-purple-soft);
        color:
            var(--sr-purple);
    }

    .panel-orange {
        background:
            var(--sr-orange-soft);
        color:
            var(--sr-orange);
    }

    .record-panel-header h2 {
        margin:
            0
            0
            3px;
        font-size: 22px;
        font-weight: 900;
        line-height: 1.3;
    }

    .record-panel-header p {
        margin: 0;
        color:
            var(--sr-muted);
        font-size: 14px;
    }

    .record-panel-body {
        padding: 22px;
    }

    /* ================================================================
       DETAILS GRID
       ================================================================ */
    .record-details-grid {
        display: grid;
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
        gap:
            18px
            20px;
    }

    .record-detail {
        padding-bottom: 15px;
        border-bottom:
            1px solid
            var(--sr-border-soft);
    }

    .record-detail:nth-last-child(-n+2) {
        padding-bottom: 0;
        border-bottom: none;
    }

    .record-detail-label {
        display: block;
        margin-bottom: 5px;
        color:
            var(--sr-muted);
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing:
            0.2px;
    }

    .record-detail-value {
        display: block;
        color:
            var(--sr-text);
        font-size: 17px;
        font-weight: 850;
        line-height: 1.55;
        word-break: break-word;
    }

    /* ================================================================
       PROFILE COMPLETENESS
       ================================================================ */
    .profile-completeness {
        margin-bottom: 18px;
    }

    .profile-completeness-top {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 10px;
    }

    .profile-completeness-title {
        display: block;
        color:
            var(--sr-text);
        font-size: 17px;
        font-weight: 900;
    }

    .profile-completeness-note {
        color:
            var(--sr-muted);
        font-size: 14px;
    }

    .profile-completeness-percent {
        color:
            var(--sr-blue);
        font-size: 22px;
        font-weight: 900;
    }

    .profile-progress-track {
        height: 11px;
        overflow: hidden;
        border-radius: 999px;
        background:
            #E4ECF4;
    }

    .profile-progress-fill {
        height: 100%;
        border-radius: inherit;
        background:
            linear-gradient(
                90deg,
                var(--sr-blue),
                var(--sr-teal)
            );
    }

    /* ================================================================
       ASSIGNMENT HISTORY
       ================================================================ */
    .assignment-list {
        display: grid;
        gap: 15px;
    }

    .assignment-card {
        overflow: hidden;
        border:
            1px solid
            var(--sr-border);
        border-radius: 15px;
        background:
            #FBFDFF;
    }

    .assignment-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        padding:
            17px
            18px;
        border-bottom:
            1px solid
            var(--sr-border-soft);
        background:
            #FFFFFF;
    }

    .assignment-company {
        display: block;
        margin-bottom: 3px;
        color:
            var(--sr-text);
        font-size: 18px;
        font-weight: 900;
    }

    .assignment-supervisor {
        display: block;
        color:
            var(--sr-muted);
        font-size: 14px;
    }

    .assignment-status {
        display: inline-flex;
        padding:
            7px
            11px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 850;
        white-space: nowrap;
    }

    .assignment-active {
        background:
            var(--sr-green-soft);
        color:
            var(--sr-green);
    }

    .assignment-pending {
        background:
            var(--sr-orange-soft);
        color:
            var(--sr-orange);
    }

    .assignment-completed {
        background:
            var(--sr-blue-soft);
        color:
            var(--sr-blue);
    }

    .assignment-cancelled {
        background:
            var(--sr-red-soft);
        color:
            var(--sr-red);
    }

    .assignment-default {
        background:
            var(--sr-gray-soft);
        color:
            var(--sr-gray);
    }

    .assignment-card-body {
        padding:
            17px
            18px;
    }

    .assignment-details-grid {
        display: grid;
        grid-template-columns:
            repeat(4, minmax(0, 1fr));
        gap: 11px;
    }

    .assignment-detail {
        padding:
            12px;
        border:
            1px solid
            var(--sr-border-soft);
        border-radius: 10px;
        background:
            #FFFFFF;
    }

    .assignment-detail-label {
        display: block;
        margin-bottom: 4px;
        color:
            var(--sr-muted);
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .assignment-detail-value {
        display: block;
        color:
            var(--sr-text);
        font-size: 15px;
        font-weight: 850;
        line-height: 1.45;
    }

    .assignment-notes {
        margin-top: 12px;
        padding:
            13px
            14px;
        border:
            1px solid
            var(--sr-border-soft);
        border-radius: 10px;
        background:
            #FFFFFF;
        color:
            var(--sr-body);
        font-size: 15px;
        line-height: 1.65;
    }

    .assignment-actions {
        display: flex;
        gap: 8px;
        margin-top: 13px;
    }

    /* ================================================================
       BUTTONS
       ================================================================ */
    .record-button {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding:
            0
            14px;
        border:
            1px solid
            var(--sr-border);
        border-radius: 10px;
        background:
            #FFFFFF;
        color:
            var(--sr-navy);
        font-family: inherit;
        font-size: 14px;
        font-weight: 850;
        text-decoration: none;
        cursor: pointer;
        transition:
            var(--sr-transition);
    }

    .record-button:hover {
        transform:
            translateY(-1px);
        background:
            var(--sr-blue-soft);
    }

    .record-button-primary {
        border-color:
            var(--sr-navy);
        background:
            var(--sr-navy);
        color:
            #FFFFFF;
    }

    .record-button-primary:hover {
        background:
            var(--sr-navy-dark);
        color:
            #FFFFFF;
    }

    /* ================================================================
       SIDEBAR
       ================================================================ */
    .sidebar-record {
        display: grid;
        gap: 13px;
    }

    .sidebar-record-item {
        padding:
            14px;
        border:
            1px solid
            var(--sr-border-soft);
        border-radius: 11px;
        background:
            var(--sr-soft);
    }

    .sidebar-record-label {
        display: block;
        margin-bottom: 4px;
        color:
            var(--sr-muted);
        font-size: 13px;
        font-weight: 800;
    }

    .sidebar-record-value {
        display: block;
        color:
            var(--sr-text);
        font-size: 16px;
        font-weight: 850;
    }

    /* ================================================================
       ARCHIVE SAFETY PANEL
       ================================================================ */
    .archive-safety-panel {
        border-color:
            #E4B5AF;
    }

    .archive-safety-body {
        padding:
            21px;
    }

    .archive-safety-title {
        display: block;
        margin-bottom: 6px;
        color:
            var(--sr-red);
        font-size: 18px;
        font-weight: 900;
    }

    .archive-safety-description {
        margin:
            0
            0
            15px;
        color:
            var(--sr-body);
        font-size: 15px;
        line-height: 1.65;
    }

    .archive-warning {
        margin-bottom: 15px;
        padding:
            13px
            14px;
        border:
            1px solid
            #ECD6B4;
        border-radius: 10px;
        background:
            var(--sr-orange-soft);
        color:
            #7A4B0D;
        font-size: 14px;
        line-height: 1.6;
    }

    .archive-safe {
        margin-bottom: 15px;
        padding:
            13px
            14px;
        border:
            1px solid
            #CAE2D1;
        border-radius: 10px;
        background:
            var(--sr-green-soft);
        color:
            #11632F;
        font-size: 14px;
        line-height: 1.6;
    }

    .archive-button {
        width: 100%;
        min-height: 49px;
        border:
            1px solid
            var(--sr-red);
        border-radius: 11px;
        background:
            #FFFFFF;
        color:
            var(--sr-red);
        font-family: inherit;
        font-size: 15px;
        font-weight: 900;
        cursor: pointer;
        transition:
            var(--sr-transition);
    }

    .archive-button:hover {
        background:
            var(--sr-red-soft);
    }

    .archive-button:disabled {
        border-color:
            #D9E1E8;
        background:
            #F8FAFC;
        color:
            #94A3B8;
        cursor: not-allowed;
    }

    /* ================================================================
       EMPTY ASSIGNMENT
       ================================================================ */
    .assignment-empty {
        padding:
            32px
            20px;
        border:
            1px dashed
            #C9D6E3;
        border-radius: 14px;
        background:
            #FBFDFF;
        text-align: center;
    }

    .assignment-empty strong {
        display: block;
        margin-bottom: 5px;
        font-size: 18px;
        font-weight: 900;
    }

    .assignment-empty span {
        color:
            var(--sr-muted);
        font-size: 15px;
    }

    /* ================================================================
       RESPONSIVE
       ================================================================ */
    @media (max-width: 1180px) {
        .student-record-layout {
            grid-template-columns:
                1fr;
        }

        .student-record-sidebar {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .assignment-details-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 900px) {
        .student-record-status-strip {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .student-record-hero-inner {
            flex-direction: column;
            align-items: flex-start;
        }

        .student-record-hero-actions {
            width: 100%;
        }
    }

    @media (max-width: 700px) {
        .student-record-hero {
            padding:
                30px
                22px;
            border-radius: 22px;
        }

        .student-record-identity {
            align-items: flex-start;
        }

        .student-record-avatar {
            width: 68px;
            height: 68px;
            border-radius: 19px;
            font-size: 21px;
        }

        .student-record-hero h1 {
            font-size: 30px;
        }

        .student-record-status-strip,
        .record-details-grid,
        .student-record-sidebar,
        .assignment-details-grid {
            grid-template-columns:
                1fr;
        }

        .record-detail:nth-last-child(-n+2) {
            padding-bottom: 15px;
            border-bottom:
                1px solid
                var(--sr-border-soft);
        }

        .record-detail:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .assignment-card-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

</style>

@endpush

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Student Profile
    |--------------------------------------------------------------------------
    */
    $profile =
        $student->studentProfile;
    /*
    |--------------------------------------------------------------------------
    | Assignment History
    |--------------------------------------------------------------------------
    */
    $assignments =
        $profile
            ? collect(
                $profile->ojtAssignments
                ?? []
            )
                ->sortByDesc(
                    fn ($assignment) =>
                        $assignment->start_date
                        ?? $assignment->created_at
                )
                ->values()
            : collect();
    /*
    |--------------------------------------------------------------------------
    | Open Assignments
    |--------------------------------------------------------------------------
    */
    $openAssignments =
        $assignments
            ->filter(
                fn ($assignment) =>
                    in_array(
                        strtolower(
                            (string)
                            $assignment->status
                        ),
                        \App\Models\OjtAssignment::OPEN_STATUSES,
                        true
                    )
            )
            ->values();
    $currentAssignment =
        $openAssignments->first();
    $completedAssignments =
        $assignments
            ->filter(
                fn ($assignment) =>
                    strtolower(
                        (string)
                        $assignment->status
                    )
                    ===
                    \App\Models\OjtAssignment::STATUS_COMPLETED
            )
            ->values();
    /*
    |--------------------------------------------------------------------------
    | Profile Completeness
    |--------------------------------------------------------------------------
    */
    $profileFields = [
        $profile?->student_number,
        $profile?->program,
        $profile?->year_level,
        $profile?->section,
        $profile?->contact_number,
        $profile?->address,
        $profile?->emergency_contact_name,
        $profile?->emergency_contact_number,
    ];
    $completedProfileFields =
        collect($profileFields)
            ->filter(
                fn ($value) =>
                    filled($value)
            )
            ->count();
    $profileCompleteness =
        count($profileFields) > 0
            ? (int) round(
                (
                    $completedProfileFields
                    /
                    count($profileFields)
                )
                * 100
            )
            : 0;
    /*
    |--------------------------------------------------------------------------
    | Initials
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
    | Date Formatting
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
    | Assignment Status Styling
    |--------------------------------------------------------------------------
    */
    $assignmentStatusClass =
        function ($status) {
            return match (
                strtolower(
                    (string)
                    $status
                )
            ) {
                'active' =>
                    'assignment-active',
                'pending' =>
                    'assignment-pending',
                'completed' =>
                    'assignment-completed',
                'cancelled' =>
                    'assignment-cancelled',
                default =>
                    'assignment-default',
            };
        };
@endphp
<div class="student-record-page">

    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="student-record-hero">
        <div class="student-record-hero-inner">
            <div class="student-record-identity">
                <div class="student-record-avatar">
                    {{ $makeInitials(
                        $student->name
                    ) }}
                </div>
                <div>
                    <div class="student-record-eyebrow">
                        <span class="student-record-eyebrow-dot"></span>
                        Administrator · Student Record
                    </div>
                    <h1>
                        {{ $student->name }}
                    </h1>
                    <p class="student-record-email">
                        {{ $student->email }}
                    </p>
                </div>
            </div>
            <div class="student-record-hero-actions">
                <a
                    href="{{ route(
                        'admin.students.edit',
                        $student
                    ) }}"
                    class="
                        student-record-hero-btn
                        hero-btn-primary
                    "
                >
                    Edit Student Account
                </a>
                <a
                    href="{{ route(
                        'admin.students.index'
                    ) }}"
                    class="
                        student-record-hero-btn
                        hero-btn-secondary
                    "
                >
                    Back to Students
                </a>
            </div>
        </div>

    </section>

    {{-- ==================================================================
         QUICK SUMMARY
         ================================================================== --}}

    <section class="student-record-status-strip">
        <article class="student-record-stat">
            <span class="student-record-stat-label">
                Account Status
            </span>
            @if ($student->isActive())
                <span
                    class="
                        record-status-badge
                        record-active
                    "
                >
                    Active
                </span>
            @else
                <span
                    class="
                        record-status-badge
                        record-inactive
                    "
                >
                    Inactive
                </span>
            @endif
            <span class="student-record-stat-note">
                {{ $student->isActive()
                    ? 'OJT Portal access enabled'
                    : 'OJT Portal access disabled'
                }}
            </span>
        </article>
        <article class="student-record-stat">
            <span class="student-record-stat-label">
                Student Number
            </span>
            <span class="student-record-stat-value">
                {{ $profile
                    ?->student_number
                    ?? 'Not Set'
                }}
            </span>
            <span class="student-record-stat-note">
                Academic Student identifier
            </span>
        </article>
        <article class="student-record-stat">
            <span class="student-record-stat-label">
                OJT Placements
            </span>
            <span class="student-record-stat-value">
                {{ $assignments->count() }}
            </span>
            <span class="student-record-stat-note">
                {{ $openAssignments->count() }}
                open ·
                {{ $completedAssignments->count() }}
                completed
            </span>
        </article>
        <article class="student-record-stat">
            <span class="student-record-stat-label">
                Profile Completion
            </span>
            <span class="student-record-stat-value">
                {{ $profileCompleteness }}%
            </span>
            <span class="student-record-stat-note">
                Student profile information
            </span>
        </article>

    </section>

    {{-- ==================================================================
         MAIN LAYOUT
         ================================================================== --}}
    <div class="student-record-layout">

        <main class="student-record-main">

            {{-- ==============================================================
                 STUDENT PROFILE
                 ============================================================== --}}

            <section class="record-panel">
                <div class="record-panel-header">
                    <div class="record-panel-icon panel-blue">
                        PF
                    </div>
                    <div>
                        <h2>
                            Student Profile
                        </h2>
                        <p>
                            Academic and personal OJT information
                        </p>
                    </div>
                </div>
                <div class="record-panel-body">
                    <div class="profile-completeness">
                        <div class="profile-completeness-top">
                            <div>
                                <span class="profile-completeness-title">
                                    Profile Completeness
                                </span>
                                <span class="profile-completeness-note">
                                    {{ $completedProfileFields }}
                                    of
                                    {{ count($profileFields) }}
                                    profile fields completed
                                </span>
                            </div>
                            <span class="profile-completeness-percent">
                                {{ $profileCompleteness }}%
                            </span>
                        </div>
                        <div class="profile-progress-track">
                            <div
                                class="profile-progress-fill"
                                style="
                                    width:
                                    {{ $profileCompleteness }}%;
                                "
                            ></div>
                        </div>
                    </div>
                    <div class="record-details-grid">
                        <div class="record-detail">
                            <span class="record-detail-label">
                                Student Number
                            </span>
                            <span class="record-detail-value">
                                {{ $profile
                                    ?->student_number
                                    ?? 'Not provided'
                                }}
                            </span>
                        </div>
                        <div class="record-detail">
                            <span class="record-detail-label">
                                Program
                            </span>
                            <span class="record-detail-value">
                                {{ $profile
                                    ?->program
                                    ?? 'Not provided'
                                }}
                            </span>
                        </div>
                        <div class="record-detail">
                            <span class="record-detail-label">
                                Year Level
                            </span>
                            <span class="record-detail-value">
                                {{ $profile
                                    ?->year_level
                                    ?? 'Not provided'
                                }}
                            </span>
                        </div>
                        <div class="record-detail">
                            <span class="record-detail-label">
                                Section
                            </span>
                            <span class="record-detail-value">
                                {{ $profile
                                    ?->section
                                    ?? 'Not provided'
                                }}
                            </span>
                        </div>
                        <div class="record-detail">
                            <span class="record-detail-label">
                                Contact Number
                            </span>
                            <span class="record-detail-value">
                                {{ $profile
                                    ?->contact_number
                                    ?? 'Not provided'
                                }}
                            </span>
                        </div>
                        <div class="record-detail">
                            <span class="record-detail-label">
                                Address
                            </span>
                            <span class="record-detail-value">
                                {{ $profile
                                    ?->address
                                    ?? 'Not provided'
                                }}
                            </span>
                        </div>
                        <div class="record-detail">
                            <span class="record-detail-label">
                                Emergency Contact
                            </span>
                            <span class="record-detail-value">
                                {{ $profile
                                    ?->emergency_contact_name
                                    ?? 'Not provided'
                                }}
                            </span>
                        </div>
                        <div class="record-detail">
                            <span class="record-detail-label">
                                Emergency Number
                            </span>
                            <span class="record-detail-value">
                                {{ $profile
                                    ?->emergency_contact_number
                                    ?? 'Not provided'
                                }}
                            </span>
                        </div>
                        <div class="record-detail">
                            <span class="record-detail-label">
                                Relationship
                            </span>
                            <span class="record-detail-value">
                                {{ filled($profile?->emergency_contact_relationship)
                                    ? $profile->emergency_contact_relationship
                                    : 'Not provided' }}
                            </span>
                        </div>
                        <div class="record-detail">
                            <span class="record-detail-label">
                                Contact Address
                            </span>
                            <span class="record-detail-value">
                                {{ filled($profile?->emergency_contact_address)
                                    ? $profile->emergency_contact_address
                                    : 'Not provided' }}
                            </span>
                        </div>
                    </div>
                </div>

            </section>

            {{-- ==============================================================
                 OJT PLACEMENT HISTORY
                 ============================================================== --}}

            <section class="record-panel">
                <div class="record-panel-header">
                    <div class="record-panel-icon panel-purple">
                        OJ
                    </div>
                    <div>
                        <h2>
                            OJT Placement History
                        </h2>
                        <p>
                            Current and previous OJT Assignments
                        </p>
                    </div>
                </div>
                <div class="record-panel-body">
                    @if ($assignments->isNotEmpty())
                        <div class="assignment-list">
                            @foreach ($assignments as $assignment)
                                <article class="assignment-card">
                                    <div class="assignment-card-header">
                                        <div>
                                            <span class="assignment-company">
                                                {{ $assignment
                                                    ->company
                                                    ?->name
                                                    ?? 'Company unavailable'
                                                }}
                                            </span>
                                            <span class="assignment-supervisor">
                                                Supervisor:
                                                {{ $assignment
                                                    ->supervisor
                                                    ?->name
                                                    ?? 'Not assigned'
                                                }}
                                            </span>
                                        </div>
                                        <span
                                            class="
                                                assignment-status
                                                {{ $assignmentStatusClass(
                                                    $assignment->status
                                                ) }}
                                            "
                                        >
                                            {{ ucwords(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $assignment->status
                                                )
                                            ) }}
                                        </span>
                                    </div>
                                    <div class="assignment-card-body">
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
                                                        $assignment
                                                            ->start_date
                                                    ) }}
                                                </span>
                                            </div>
                                            <div class="assignment-detail">
                                                <span class="assignment-detail-label">
                                                    End Date
                                                </span>
                                                <span class="assignment-detail-value">
                                                    {{ $formatDate(
                                                        $assignment
                                                            ->end_date
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
                                        @if (
                                            filled(
                                                $assignment->notes
                                            )
                                        )
                                            <div class="assignment-notes">
                                                <strong>
                                                    Placement Notes:
                                                </strong>
                                                {{ $assignment->notes }}
                                            </div>
                                        @endif
                                        @if (
                                            \Illuminate\Support\Facades\Route::has(
                                                'admin.assignments.show'
                                            )
                                        )
                                            <div class="assignment-actions">
                                                <a
                                                    href="{{ route(
                                                        'admin.assignments.show',
                                                        $assignment
                                                    ) }}"
                                                    class="record-button"
                                                >
                                                    View Assignment
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="assignment-empty">
                            <strong>
                                No OJT Assignment Yet
                            </strong>
                            <span>
                                This Student does not currently
                                have an OJT placement record.
                            </span>
                        </div>
                    @endif
                </div>

            </section>

        </main>

        {{-- ==================================================================
             SIDEBAR
             ================================================================== --}}

        <aside class="student-record-sidebar">

            {{-- ==============================================================
                 ACCOUNT INFORMATION
                 ============================================================== --}}

            <section class="record-panel">
                <div class="record-panel-header">
                    <div class="record-panel-icon panel-teal">
                        AC
                    </div>
                    <div>
                        <h2>
                            Account Record
                        </h2>
                        <p>
                            System account information
                        </p>
                    </div>
                </div>
                <div class="record-panel-body">
                    <div class="sidebar-record">
                        <div class="sidebar-record-item">
                            <span class="sidebar-record-label">
                                Account Role
                            </span>
                            <span class="sidebar-record-value">
                                Student
                            </span>
                        </div>
                        <div class="sidebar-record-item">
                            <span class="sidebar-record-label">
                                Account Status
                            </span>
                            <span class="sidebar-record-value">
                                {{ ucfirst(
                                    $student->status
                                ) }}
                            </span>
                        </div>
                        <div class="sidebar-record-item">
                            <span class="sidebar-record-label">
                                Email Address
                            </span>
                            <span class="sidebar-record-value">
                                {{ $student->email }}
                            </span>
                        </div>
                        <div class="sidebar-record-item">
                            <span class="sidebar-record-label">
                                Account Created
                            </span>
                            <span class="sidebar-record-value">
                                {{ $formatDate(
                                    $student->created_at
                                ) }}
                            </span>
                        </div>
                        <div class="sidebar-record-item">
                            <span class="sidebar-record-label">
                                Last Updated
                            </span>
                            <span class="sidebar-record-value">
                                {{ $formatDate(
                                    $student->updated_at
                                ) }}
                            </span>
                        </div>
                    </div>
                </div>

            </section>

            {{-- ==============================================================
                 CURRENT PLACEMENT
                 ============================================================== --}}

            <section class="record-panel">
                <div class="record-panel-header">
                    <div class="record-panel-icon panel-purple">
                        CP
                    </div>
                    <div>
                        <h2>
                            Current Placement
                        </h2>
                        <p>
                            Active OJT workflow
                        </p>
                    </div>
                </div>
                <div class="record-panel-body">
                    @if ($currentAssignment)
                        <div class="sidebar-record">
                            <div class="sidebar-record-item">
                                <span class="sidebar-record-label">
                                    Company
                                </span>
                                <span class="sidebar-record-value">
                                    {{ $currentAssignment
                                        ->company
                                        ?->name
                                        ?? 'Unavailable'
                                    }}
                                </span>
                            </div>
                            <div class="sidebar-record-item">
                                <span class="sidebar-record-label">
                                    Supervisor
                                </span>
                                <span class="sidebar-record-value">
                                    {{ $currentAssignment
                                        ->supervisor
                                        ?->name
                                        ?? 'Unavailable'
                                    }}
                                </span>
                            </div>
                            <div class="sidebar-record-item">
                                <span class="sidebar-record-label">
                                    Required Hours
                                </span>
                                <span class="sidebar-record-value">
                                    {{ number_format(
                                        (float)
                                        (
                                            $currentAssignment
                                                ->required_hours
                                            ?? 0
                                        ),
                                        0
                                    ) }}
                                    hours
                                </span>
                            </div>
                            <div class="sidebar-record-item">
                                <span class="sidebar-record-label">
                                    Placement Status
                                </span>
                                <span class="sidebar-record-value">
                                    {{ ucfirst(
                                        $currentAssignment
                                            ->status
                                    ) }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="assignment-empty">
                            <strong>
                                No Open Placement
                            </strong>
                            <span>
                                There is no pending or active
                                OJT Assignment for this Student.
                            </span>
                        </div>
                    @endif
                </div>

            </section>

            {{-- ==============================================================
                 ARCHIVE ACCOUNT
                 ============================================================== --}}

            <section
                class="
                    record-panel
                    archive-safety-panel
                "
            >
                <div class="archive-safety-body">
                    <span class="archive-safety-title">
                        Archive Student Account
                    </span>
                    <p class="archive-safety-description">
                        Archiving disables login access and
                        removes this Student from the normal
                        account directory without permanently
                        deleting historical OJT records.
                    </p>
                    @if ($openAssignments->isNotEmpty())
                        <div class="archive-warning">
                            This account cannot be archived because
                            the Student currently has
                            <strong>
                                {{ $openAssignments->count() }}
                                pending or active OJT Assignment{{ $openAssignments->count() === 1 ? '' : 's' }}.
                            </strong>
                            Complete or cancel the open placement first.
                        </div>
                        <button
                            type="button"
                            class="archive-button"
                            disabled
                        >
                            Archive Unavailable
                        </button>
                    @else
                        <div class="archive-safe">
                            No pending or active OJT Assignment
                            was found. This account is eligible
                            for safe archiving.
                        </div>
                        <form
                            method="POST"
                            action="{{ route(
                                'admin.students.archive',
                                $student
                            ) }}"
                            onsubmit="
                                return confirm(
                                    'Archive this Student account?\n\nStudent: {{ addslashes($student->name) }}\n\nThe Student will no longer be able to log in. Historical OJT Assignments and related records will remain preserved.'
                                );
                            "
                        >
                            @csrf
                            @method('PATCH')
                            <button
                                type="submit"
                                class="archive-button"
                            >
                                Archive Student Account
                            </button>
                        </form>
                    @endif
                </div>

            </section>

        </aside>
    </div>
</div>

@endsection
