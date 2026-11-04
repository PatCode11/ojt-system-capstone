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
        @yield('title', 'OJT Sync')
    </title>

    <link
        rel="stylesheet"
        href="{{ asset('css/ojt-sync.css') }}"
    >

    <style>

        /* ================================================================
           SHARED PROFESSIONAL APPLICATION DESIGN
           ================================================================ */

        :root {
            --app-primary: #183B6B;
            --app-primary-dark: #102A4A;
            --app-primary-deep: #0A1F38;
            --app-primary-light: #315F98;

            --app-blue: #2563EB;
            --app-blue-soft: #EAF2FF;

            --app-green: #15803D;
            --app-green-soft: #EAF8EF;

            --app-red: #B42318;
            --app-red-soft: #FFF0EE;

            --app-text: #102A4A;
            --app-text-body: #536A84;
            --app-text-muted: #72849A;

            --app-border: #DCE5EE;
            --app-border-soft: #E8EEF4;

            --app-background: #F3F7FB;
            --app-surface: #FFFFFF;

            --app-shadow:
                0 8px 28px
                rgba(15, 42, 74, 0.08);

            --app-transition:
                all 0.22s ease;
        }


        /* ================================================================
           PAGE
           ================================================================ */

        html {
            font-size: 16px;
        }

        body {
            margin: 0;

            color: var(--app-text);

            background:
                linear-gradient(
                    180deg,
                    #F7FAFD 0%,
                    #F1F5F9 100%
                );

            font-family:
                "Segoe UI",
                Tahoma,
                Geneva,
                Verdana,
                sans-serif;

            font-size: 16px;

            line-height: 1.6;

            -webkit-font-smoothing: antialiased;
        }


        /* ================================================================
           HEADER
           ================================================================ */

        .professional-header {
            position: sticky;

            top: 0;

            z-index: 1000;

            background:
                linear-gradient(
                    135deg,
                    #102A4A 0%,
                    #183B6B 58%,
                    #24598F 100%
                );

            box-shadow:
                0 5px 22px
                rgba(16, 42, 74, 0.18);
        }


        .professional-header-main {
            min-height: 88px;
        }


        .professional-header-inner {
            width: calc(100% - 48px);
            max-width: 1400px;

            min-height: 88px;

            margin: 0 auto;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 28px;
        }


        /* ================================================================
           BRAND
           ================================================================ */

        .professional-brand {
            min-width: 230px;

            display: inline-flex;
            align-items: center;

            gap: 14px;

            color: #FFFFFF;

            text-decoration: none;
        }


        .professional-brand-mark {
            width: 52px;
            height: 52px;

            flex-shrink: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border:
                1px solid
                rgba(255, 255, 255, 0.16);

            border-radius: 16px;

            background:
                rgba(255, 255, 255, 0.12);

            color: #FFFFFF;

            font-size: 16px;
            font-weight: 900;

            letter-spacing: 0.4px;

            box-shadow:
                inset 0 1px 0
                rgba(255, 255, 255, 0.08);

            transition:
                var(--app-transition);
        }


        .professional-brand:hover
        .professional-brand-mark {
            background:
                rgba(255, 255, 255, 0.18);

            transform:
                translateY(-1px);
        }


        .professional-brand-copy {
            display: flex;
            flex-direction: column;

            gap: 4px;
        }


        .professional-brand-name {
            color: #FFFFFF;

            font-size: 22px;
            font-weight: 850;

            line-height: 1.1;
        }


        .professional-brand-caption {
            color:
                rgba(255, 255, 255, 0.68);

            font-size: 12px;

            letter-spacing: 0.25px;
        }


        /* ================================================================
           HEADER CONTEXT
           ================================================================ */

        .header-context {
            flex: 1;

            display: flex;
            align-items: center;
            justify-content: center;
        }


        .header-context-badge {
            display: inline-flex;
            align-items: center;

            gap: 9px;

            padding:
                9px
                15px;

            border:
                1px solid
                rgba(255, 255, 255, 0.13);

            border-radius: 999px;

            background:
                rgba(255, 255, 255, 0.08);

            color:
                rgba(255, 255, 255, 0.83);

            font-size: 12px;
            font-weight: 700;
        }


        .header-context-dot {
            width: 8px;
            height: 8px;

            border-radius: 50%;

            background: #4ADE80;

            box-shadow:
                0 0 0 5px
                rgba(74, 222, 128, 0.11);
        }


        /* ================================================================
           USER AREA
           ================================================================ */

        .professional-user-area {
            display: flex;
            align-items: center;

            gap: 12px;
        }


        .professional-user-card {
            min-width: 215px;

            display: flex;
            align-items: center;

            gap: 11px;

            padding:
                9px
                13px;

            border:
                1px solid
                rgba(255, 255, 255, 0.12);

            border-radius: 15px;

            background:
                rgba(255, 255, 255, 0.08);
        }


        .professional-avatar {
            width: 42px;
            height: 42px;

            flex-shrink: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 13px;

            background:
                rgba(255, 255, 255, 0.14);

            color: #FFFFFF;

            font-size: 15px;
            font-weight: 850;
        }


        .professional-user-info {
            min-width: 0;

            display: flex;
            flex-direction: column;

            gap: 3px;
        }


        .professional-user-name {
            max-width: 165px;

            overflow: hidden;

            color: #FFFFFF;

            font-size: 14px;
            font-weight: 800;

            white-space: nowrap;
            text-overflow: ellipsis;
        }


        .professional-user-role {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            color:
                rgba(255, 255, 255, 0.68);

            font-size: 12px;
        }


        .professional-user-role-dot {
            width: 6px;
            height: 6px;

            border-radius: 50%;

            background: #4ADE80;
        }


        /* ================================================================
           LOGOUT
           ================================================================ */

        .professional-logout-form {
            margin: 0;
        }


        .professional-logout {
            min-height: 44px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding:
                0
                16px;

            border:
                1px solid
                rgba(255, 255, 255, 0.17);

            border-radius: 12px;

            background:
                rgba(255, 255, 255, 0.08);

            color: #FFFFFF;

            cursor: pointer;

            font-size: 13px;
            font-weight: 800;

            transition:
                var(--app-transition);
        }


        .professional-logout:hover {
            background:
                rgba(255, 255, 255, 0.15);

            transform:
                translateY(-1px);
        }


        .logout-symbol {
            font-size: 16px;
        }


        /* ================================================================
           NAVIGATION
           ================================================================ */

        .professional-navigation {
            border-top:
                1px solid
                rgba(255, 255, 255, 0.07);

            background:
                rgba(6, 24, 43, 0.26);
        }


        .professional-navigation-inner {
            width: calc(100% - 48px);
            max-width: 1400px;

            min-height: 58px;

            margin: 0 auto;

            display: flex;
            align-items: center;

            gap: 5px;
        }


        .professional-nav-link {
            position: relative;

            min-height: 58px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding:
                0
                15px;

            color:
                rgba(255, 255, 255, 0.79);

            text-decoration: none;

            font-size: 14px;
            font-weight: 750;

            white-space: nowrap;

            transition:
                var(--app-transition);
        }


        .professional-nav-link:hover {
            color: #FFFFFF;

            background:
                rgba(255, 255, 255, 0.06);
        }


        .professional-nav-link.active {
            color: #FFFFFF;

            background:
                rgba(255, 255, 255, 0.09);
        }


        .professional-nav-link.active::after {
            content: "";

            position: absolute;

            left: 14px;
            right: 14px;
            bottom: 0;

            height: 4px;

            border-radius:
                4px
                4px
                0
                0;

            background: #60A5FA;
        }


        .professional-nav-icon {
            width: 29px;
            height: 29px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background:
                rgba(255, 255, 255, 0.07);

            color:
                rgba(255, 255, 255, 0.90);

            font-size: 10px;
            font-weight: 900;
        }


        .professional-nav-link.active
        .professional-nav-icon {
            background:
                rgba(96, 165, 250, 0.19);

            color: #D7E9FF;
        }


        /* ================================================================
           MAIN CONTENT
           ================================================================ */

        .professional-main-container {
            width: calc(100% - 48px);
            max-width: 1400px;

            min-height:
                calc(100vh - 146px);

            margin: 0 auto;

            padding:
                34px
                0
                50px;
        }


        /* ================================================================
           GLOBAL FLASH MESSAGES
           ================================================================ */

        .global-alert {
            position: relative;

            margin-bottom: 22px;

            padding:
                16px
                18px
                16px
                52px;

            overflow: hidden;

            border-radius: 14px;

            font-size: 14px;
            font-weight: 650;

            line-height: 1.65;
        }


        .global-alert::before {
            position: absolute;

            left: 16px;
            top: 50%;

            width: 27px;
            height: 27px;

            transform:
                translateY(-50%);

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            font-size: 13px;
            font-weight: 850;
        }


        .global-alert-success {
            border:
                1px solid
                #CBEBD7;

            background:
                #EFFAF3;

            color:
                #166534;
        }


        .global-alert-success::before {
            content: "✓";

            background:
                #DCFCE7;

            color:
                #15803D;
        }


        .global-alert-error {
            border:
                1px solid
                #F2CECA;

            background:
                #FFF4F2;

            color:
                #9F281E;
        }


        .global-alert-error::before {
            content: "!";

            background:
                #FEE4E2;

            color:
                #B42318;
        }


        /* ================================================================
           ACCESSIBILITY
           ================================================================ */

        a:focus-visible,
        button:focus-visible {
            outline:
                3px solid
                rgba(96, 165, 250, 0.40);

            outline-offset: 3px;
        }


        /* ================================================================
           RESPONSIVE
           ================================================================ */

        @media (max-width: 1150px) {

            .header-context {
                display: none;
            }


            .professional-navigation-inner {
                overflow-x: auto;

                scrollbar-width: none;
            }


            .professional-navigation-inner::-webkit-scrollbar {
                display: none;
            }

        }


        @media (max-width: 820px) {

            .professional-header-inner,
            .professional-navigation-inner,
            .professional-main-container {
                width: calc(100% - 28px);
            }


            .professional-user-card {
                min-width: auto;
            }


            .professional-user-info {
                display: none;
            }


            .professional-user-card {
                padding: 6px;
            }

        }


        @media (max-width: 600px) {

            .professional-header-main,
            .professional-header-inner {
                min-height: 72px;
            }


            .professional-brand {
                min-width: 0;
            }


            .professional-brand-copy {
                display: none;
            }


            .professional-brand-mark {
                width: 44px;
                height: 44px;

                font-size: 13px;
            }


            .professional-logout {
                padding:
                    0
                    11px;
            }


            .logout-label {
                display: none;
            }


            .professional-nav-link {
                min-height: 54px;

                padding:
                    0
                    12px;

                font-size: 13px;
            }


            .professional-navigation-inner {
                min-height: 54px;
            }

        }

    </style>


    @stack('styles')

</head>


<body>


@auth


<header class="professional-header">


    <div class="professional-header-main">


        <div class="professional-header-inner">


            {{-- ==========================================================
                 BRAND
                 ========================================================== --}}

            @if (auth()->user()->isAdmin())

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="professional-brand"
                >

            @elseif (auth()->user()->isStudent())

                <a
                    href="{{ route('student.dashboard') }}"
                    class="professional-brand"
                >

            @elseif (auth()->user()->isSupervisor())

                <a
                    href="{{ route('supervisor.dashboard') }}"
                    class="professional-brand"
                >

            @else

                <div class="professional-brand">

            @endif


                <div class="professional-brand-mark">
                    OJT
                </div>


                <div class="professional-brand-copy">


                    <span class="professional-brand-name">
                        OJT Sync
                    </span>


                    <span class="professional-brand-caption">

                        @if (auth()->user()->isAdmin())

                            Administration Center

                        @elseif (auth()->user()->isStudent())

                            Student OJT Portal

                        @elseif (auth()->user()->isSupervisor())

                            Supervisor Portal

                        @else

                            OJT Monitoring Platform

                        @endif

                    </span>


                </div>


            @if (
                auth()->user()->isAdmin()
                || auth()->user()->isStudent()
                || auth()->user()->isSupervisor()
            )

                </a>

            @else

                </div>

            @endif


            {{-- ==========================================================
                 SESSION CONTEXT
                 ========================================================== --}}

            <div class="header-context">


                <div class="header-context-badge">


                    <span class="header-context-dot"></span>


                    @if (auth()->user()->isAdmin())

                        Administrative access active

                    @elseif (auth()->user()->isStudent())

                        Student account authenticated

                    @elseif (auth()->user()->isSupervisor())

                        Supervisor account authenticated

                    @else

                        Secure authenticated session

                    @endif


                </div>


            </div>


            {{-- ==========================================================
                 USER INFORMATION
                 ========================================================== --}}

            <div class="professional-user-area">


                <div class="professional-user-card">


                    <div class="professional-avatar">

                        {{ strtoupper(
                            mb_substr(
                                auth()->user()->name,
                                0,
                                1
                            )
                        ) }}

                    </div>


                    <div class="professional-user-info">


                        <span class="professional-user-name">

                            {{ auth()->user()->name }}

                        </span>


                        <span class="professional-user-role">


                            <span class="professional-user-role-dot"></span>


                            @if (auth()->user()->isAdmin())

                                Administrator

                            @elseif (auth()->user()->isStudent())

                                Student

                            @elseif (auth()->user()->isSupervisor())

                                Supervisor

                            @else

                                {{ ucfirst(auth()->user()->role) }}

                            @endif


                        </span>


                    </div>


                </div>


                {{-- ======================================================
                     LOGOUT
                     ====================================================== --}}

                @if (auth()->user()->isAdmin())

                    <form
                        method="POST"
                        action="{{ route('admin.logout') }}"
                        class="professional-logout-form"
                    >

                @elseif (auth()->user()->isStudent())

                    <form
                        method="POST"
                        action="{{ route('student.logout') }}"
                        class="professional-logout-form"
                    >

                @elseif (auth()->user()->isSupervisor())

                    <form
                        method="POST"
                        action="{{ route('supervisor.logout') }}"
                        class="professional-logout-form"
                    >

                @endif


                    @if (
                        auth()->user()->isAdmin()
                        || auth()->user()->isStudent()
                        || auth()->user()->isSupervisor()
                    )

                        @csrf


                        <button
                            type="submit"
                            class="professional-logout"
                        >

                            <span class="logout-symbol">
                                ↪
                            </span>


                            <span class="logout-label">
                                Logout
                            </span>


                        </button>


                    @endif


                @if (
                    auth()->user()->isAdmin()
                    || auth()->user()->isStudent()
                    || auth()->user()->isSupervisor()
                )

                    </form>

                @endif


            </div>


        </div>


    </div>


    {{-- ==================================================================
         NAVIGATION
         ================================================================== --}}

    <nav class="professional-navigation">


        <div class="professional-navigation-inner">


            {{-- ==========================================================
                 ADMIN
                 ========================================================== --}}

            @if (auth()->user()->isAdmin())


                <a
                    href="{{ route('admin.dashboard') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('admin.dashboard')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        DB
                    </span>

                    Dashboard

                </a>


                <a
                    href="{{ route('admin.students.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('admin.students.*')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        ST
                    </span>

                    Students

                </a>


                <a
                    href="{{ route('admin.supervisors.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('admin.supervisors.*')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        SV
                    </span>

                    Supervisors

                </a>


                <a
                    href="{{ route('admin.companies.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('admin.companies.*')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        CO
                    </span>

                    Companies

                </a>


                <a
                    href="{{ route('admin.assignments.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('admin.assignments.*')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        OJ
                    </span>

                    OJT Assignments

                </a>


                <a
                    href="{{ route('admin.attendance.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('admin.attendance.*')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        AT
                    </span>

                    Attendance

                </a>


                <a
                    href="{{ route('admin.reports.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('admin.reports.*')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        RP
                    </span>

                    Reports

                </a>


                <a
                    href="{{ route('admin.audit-logs.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('admin.audit-logs.*')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        AU
                    </span>

                    Audit Logs

                </a>


            {{-- ==========================================================
                 STUDENT
                 ========================================================== --}}

            @elseif (auth()->user()->isStudent())


                <a
                    href="{{ route('student.dashboard') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('student.dashboard')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        DB
                    </span>

                    Dashboard

                </a>


                <a
                    href="{{ route('student.profile.show') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('student.profile.*')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        PR
                    </span>

                    My Profile

                </a>


                <a
                    href="{{ route('student.attendance.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('student.attendance.*')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        AT
                    </span>

                    Attendance

                </a>


                <a
                    href="{{ route('student.timesheets.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('student.timesheets.*')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        TS
                    </span>

                    Timesheet

                </a>


                <a
                    href="{{ route('student.work-logs.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('student.work-logs.*')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        WL
                    </span>

                    Daily Work Log

                </a>


                <a
                    href="{{ route(
                        'student.assignment-history.index'
                    ) }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs(
                            'student.assignment-history.*'
                        )
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        HI
                    </span>

                    Assignment History

                </a>


                <a
                    href="{{ route('student.reports.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('student.reports.*')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        RP
                    </span>

                    Reports

                </a>


            {{-- ==========================================================
                 SUPERVISOR
                 ========================================================== --}}

            @elseif (auth()->user()->isSupervisor())


                <a
                    href="{{ route('supervisor.dashboard') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs('supervisor.dashboard')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        DB
                    </span>

                    Dashboard

                </a>


                <a
                    href="{{ route('supervisor.validations.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs(
                            'supervisor.validations.*'
                        )
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        AT
                    </span>

                    Attendance Validation

                </a>


                <a
                    href="{{ route('supervisor.work-logs.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs(
                            'supervisor.work-logs.*'
                        )
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        WL
                    </span>

                    Work Logs

                </a>


                <a
                    href="{{ route('supervisor.evaluations.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs(
                            'supervisor.evaluations.*'
                        )
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        EV
                    </span>

                    Final Evaluations

                </a>


                <a
                    href="{{ route('supervisor.reports.index') }}"
                    class="
                        professional-nav-link
                        {{ request()->routeIs(
                            'supervisor.reports.*'
                        )
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="professional-nav-icon">
                        RP
                    </span>

                    Reports

                </a>


            @endif


        </div>


    </nav>


</header>


@endauth


{{-- ======================================================================
     MAIN CONTENT
     ====================================================================== --}}

<main class="professional-main-container">


    @if (session('success'))

        <div
            class="
                global-alert
                global-alert-success
            "
            role="status"
        >

            {{ session('success') }}

        </div>

    @endif


    @if (session('error'))

        <div
            class="
                global-alert
                global-alert-error
            "
            role="alert"
        >

            {{ session('error') }}

        </div>

    @endif


    @yield('content')


</main>


@stack('scripts')


</body>

</html>