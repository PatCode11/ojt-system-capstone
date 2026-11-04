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

    <title>Administrator Login | OJT Sync</title>


    <style>

        /* ================================================================
           DESIGN TOKENS
           ================================================================ */

        :root {
            --primary: #183B6B;
            --primary-dark: #102A4A;
            --primary-deep: #0B203A;
            --primary-light: #2E5F99;

            --accent: #3B82F6;
            --accent-dark: #2563EB;
            --accent-soft: #DBEAFE;

            --success: #15803D;
            --success-soft: #DCFCE7;

            --danger: #B42318;
            --danger-soft: #FEE4E2;

            --warning: #92400E;
            --warning-soft: #FEF3C7;

            --surface: #FFFFFF;
            --surface-soft: #F8FBFF;
            --surface-muted: #EEF4FA;

            --text-heading: #102A4A;
            --text-body: #536B87;
            --text-muted: #8292A6;

            --border: #D9E3EE;
            --border-light: #E8EEF5;

            --shadow-soft:
                0 10px 30px rgba(15, 42, 74, 0.06);

            --shadow-medium:
                0 20px 55px rgba(15, 42, 74, 0.10);

            --shadow-large:
                0 35px 80px rgba(15, 42, 74, 0.14);

            --radius-small: 12px;
            --radius-medium: 18px;
            --radius-large: 26px;
            --radius-extra-large: 34px;

            --transition:
                all 0.25s ease;
        }


        /* ================================================================
           RESET
           ================================================================ */

        * {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;

            min-height: 100%;

            font-family:
                "Segoe UI",
                Tahoma,
                Geneva,
                Verdana,
                sans-serif;

            color: var(--text-heading);
        }


        body {
            min-height: 100vh;

            overflow-x: hidden;

            background:
                radial-gradient(
                    circle at 8% 8%,
                    rgba(59, 130, 246, 0.12),
                    transparent 26%
                ),
                radial-gradient(
                    circle at 92% 20%,
                    rgba(24, 59, 107, 0.11),
                    transparent 25%
                ),
                linear-gradient(
                    145deg,
                    #F8FBFF 0%,
                    #EEF4FA 46%,
                    #EAF1F9 100%
                );
        }


        button,
        input,
        a {
            font: inherit;
        }


        a {
            color: inherit;
        }


        /* ================================================================
           BACKGROUND DECORATION
           ================================================================ */

        .background-orb {
            position: fixed;

            border-radius: 50%;

            filter: blur(10px);

            pointer-events: none;

            z-index: 0;
        }


        .orb-one {
            top: -100px;
            left: -80px;

            width: 300px;
            height: 300px;

            background:
                rgba(59, 130, 246, 0.10);
        }


        .orb-two {
            right: -110px;
            top: 22%;

            width: 330px;
            height: 330px;

            background:
                rgba(24, 59, 107, 0.08);
        }


        .orb-three {
            bottom: -160px;
            left: 35%;

            width: 360px;
            height: 360px;

            background:
                rgba(37, 99, 235, 0.07);
        }


        /* ================================================================
           PAGE SHELL
           ================================================================ */

        .page-shell {
            position: relative;

            z-index: 1;

            min-height: 100vh;

            display: flex;
            flex-direction: column;
        }


        /* ================================================================
           TOP HEADER
           ================================================================ */

        .top-header {
            padding:
                24px
                32px
                0;
        }


        .top-header-inner {
            width: 100%;
            max-width: 1260px;

            margin: 0 auto;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }


        .brand {
            display: inline-flex;
            align-items: center;

            gap: 14px;

            text-decoration: none;
        }


        .brand-logo {
            width: 54px;
            height: 54px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary) 0%,
                    #2C65A7 100%
                );

            color: #FFFFFF;

            font-size: 18px;
            font-weight: 900;

            letter-spacing: 0.5px;

            box-shadow:
                0 10px 24px
                rgba(24, 59, 107, 0.20);
        }


        .brand-information {
            display: flex;
            flex-direction: column;

            gap: 3px;
        }


        .brand-name {
            color: var(--primary);

            font-size: 20px;
            font-weight: 850;

            line-height: 1.1;
        }


        .brand-caption {
            color: var(--text-muted);

            font-size: 12px;
        }


        .header-back-link {
            display: inline-flex;
            align-items: center;

            gap: 8px;

            padding:
                11px
                16px;

            border:
                1px solid
                rgba(24, 59, 107, 0.10);

            border-radius: 999px;

            background:
                rgba(255, 255, 255, 0.75);

            color: var(--primary);

            text-decoration: none;

            font-size: 13px;
            font-weight: 750;

            box-shadow: var(--shadow-soft);

            backdrop-filter: blur(12px);

            transition: var(--transition);
        }


        .header-back-link:hover {
            transform:
                translateY(-2px);

            background:
                #FFFFFF;

            box-shadow: var(--shadow-medium);
        }


        /* ================================================================
           MAIN LOGIN AREA
           ================================================================ */

        .login-main {
            flex: 1;

            width: 100%;

            display: flex;
            align-items: center;
            justify-content: center;

            padding:
                34px
                24px
                50px;
        }


        .login-container {
            width: 100%;
            max-width: 1160px;

            display: grid;

            grid-template-columns:
                1.05fr
                0.95fr;

            min-height: 680px;

            overflow: hidden;

            border:
                1px solid
                rgba(255, 255, 255, 0.70);

            border-radius:
                var(--radius-extra-large);

            background:
                rgba(255, 255, 255, 0.70);

            box-shadow:
                var(--shadow-large);

            backdrop-filter:
                blur(16px);
        }


        /* ================================================================
           LEFT INFORMATION PANEL
           ================================================================ */

        .login-information {
            position: relative;

            overflow: hidden;

            padding:
                64px
                56px;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

            background:
                linear-gradient(
                    145deg,
                    #102D50 0%,
                    #183B6B 52%,
                    #275E9B 100%
                );

            color:
                #FFFFFF;
        }


        .login-information::before {
            content: "";

            position: absolute;

            width: 340px;
            height: 340px;

            top: -150px;
            right: -150px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.07);
        }


        .login-information::after {
            content: "";

            position: absolute;

            width: 300px;
            height: 300px;

            left: -150px;
            bottom: -150px;

            border-radius: 50%;

            background:
                rgba(59, 130, 246, 0.16);
        }


        .information-content,
        .information-footer {
            position: relative;

            z-index: 2;
        }


        .admin-label {
            display: inline-flex;
            align-items: center;

            gap: 9px;

            width: fit-content;

            padding:
                9px
                14px;

            margin-bottom: 26px;

            border:
                1px solid
                rgba(255, 255, 255, 0.18);

            border-radius: 999px;

            background:
                rgba(255, 255, 255, 0.09);

            color:
                rgba(255, 255, 255, 0.92);

            font-size: 12px;
            font-weight: 750;

            backdrop-filter:
                blur(10px);
        }


        .admin-label-dot {
            width: 8px;
            height: 8px;

            border-radius: 50%;

            background:
                #4ADE80;

            box-shadow:
                0 0 0 6px
                rgba(74, 222, 128, 0.12);
        }


        .information-title {
            max-width: 500px;

            margin:
                0
                0
                20px;

            color: #FFFFFF;

            font-size: 44px;
            font-weight: 850;

            line-height: 1.12;

            letter-spacing: -0.8px;
        }


        .information-description {
            max-width: 510px;

            margin:
                0
                0
                32px;

            color:
                rgba(255, 255, 255, 0.72);

            font-size: 16px;

            line-height: 1.8;
        }


        .feature-list {
            display: grid;

            gap: 15px;
        }


        .feature-item {
            display: flex;
            align-items: flex-start;

            gap: 13px;
        }


        .feature-icon {
            flex-shrink: 0;

            width: 30px;
            height: 30px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background:
                rgba(255, 255, 255, 0.11);

            border:
                1px solid
                rgba(255, 255, 255, 0.10);

            color:
                #FFFFFF;

            font-size: 13px;
            font-weight: 850;
        }


        .feature-text strong {
            display: block;

            margin-bottom: 3px;

            color: #FFFFFF;

            font-size: 14px;
        }


        .feature-text span {
            color:
                rgba(255, 255, 255, 0.62);

            font-size: 13px;

            line-height: 1.6;
        }


        .information-footer {
            margin-top: 38px;

            padding-top: 22px;

            border-top:
                1px solid
                rgba(255, 255, 255, 0.13);

            display: flex;
            align-items: center;

            gap: 12px;
        }


        .security-symbol {
            width: 38px;
            height: 38px;

            flex-shrink: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background:
                rgba(255, 255, 255, 0.10);

            font-size: 17px;
        }


        .security-text strong {
            display: block;

            margin-bottom: 3px;

            font-size: 13px;
        }


        .security-text span {
            color:
                rgba(255, 255, 255, 0.60);

            font-size: 12px;

            line-height: 1.5;
        }


        /* ================================================================
           RIGHT LOGIN FORM PANEL
           ================================================================ */

        .login-form-section {
            padding:
                58px
                52px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                rgba(255, 255, 255, 0.94);
        }


        .login-form-wrapper {
            width: 100%;
            max-width: 430px;
        }


        .login-icon {
            width: 68px;
            height: 68px;

            margin-bottom: 22px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 21px;

            background:
                linear-gradient(
                    135deg,
                    #E7F0FC 0%,
                    #D6E7FB 100%
                );

            color: var(--primary);

            font-size: 24px;
            font-weight: 900;

            box-shadow:
                inset 0 0 0 1px
                rgba(24, 59, 107, 0.07);
        }


        .form-heading {
            margin:
                0
                0
                8px;

            color:
                var(--text-heading);

            font-size: 34px;
            font-weight: 850;

            line-height: 1.2;

            letter-spacing: -0.4px;
        }


        .form-subheading {
            margin:
                0
                0
                30px;

            color:
                var(--text-body);

            font-size: 15px;

            line-height: 1.7;
        }


        /* ================================================================
           ALERTS
           ================================================================ */

        .alert {
            margin-bottom: 20px;

            padding:
                14px
                16px;

            border-radius:
                var(--radius-small);

            font-size: 13px;

            line-height: 1.65;
        }


        .alert-danger {
            border:
                1px solid
                #F5C2C0;

            background:
                var(--danger-soft);

            color:
                var(--danger);
        }


        .alert-success {
            border:
                1px solid
                #BBE7C8;

            background:
                var(--success-soft);

            color:
                var(--success);
        }


        .alert ul {
            margin:
                0;

            padding-left:
                20px;
        }


        /* ================================================================
           FORM
           ================================================================ */

        .form-group {
            margin-bottom: 20px;
        }


        .form-label-row {
            margin-bottom: 8px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;
        }


        .form-label {
            color:
                var(--text-heading);

            font-size: 13px;
            font-weight: 750;
        }


        .required-label {
            color:
                var(--text-muted);

            font-size: 11px;
        }


        .input-wrapper {
            position: relative;
        }


        .input-icon {
            position: absolute;

            top: 50%;
            left: 16px;

            transform:
                translateY(-50%);

            width: 19px;
            height: 19px;

            display: flex;
            align-items: center;
            justify-content: center;

            color:
                var(--text-muted);

            pointer-events: none;
        }


        .form-control {
            width: 100%;

            height: 54px;

            padding:
                0
                16px
                0
                48px;

            border:
                1px solid
                var(--border);

            border-radius:
                14px;

            outline: none;

            background:
                #FBFDFF;

            color:
                var(--text-heading);

            font-size: 14px;

            transition:
                var(--transition);
        }


        .form-control::placeholder {
            color:
                #9AA9BA;
        }


        .form-control:hover {
            border-color:
                #B9CADC;
        }


        .form-control:focus {
            border-color:
                var(--accent);

            background:
                #FFFFFF;

            box-shadow:
                0 0 0 4px
                rgba(59, 130, 246, 0.10);
        }


        .form-control.has-toggle {
            padding-right:
                94px;
        }


        .password-toggle {
            position: absolute;

            top: 50%;
            right: 10px;

            transform:
                translateY(-50%);

            padding:
                8px
                10px;

            border: none;

            border-radius: 9px;

            background:
                transparent;

            color:
                var(--primary-light);

            cursor: pointer;

            font-size: 12px;
            font-weight: 750;

            transition:
                var(--transition);
        }


        .password-toggle:hover {
            background:
                var(--surface-muted);

            color:
                var(--primary);
        }


        .field-error {
            margin-top:
                7px;

            color:
                var(--danger);

            font-size:
                12px;
        }


        /* ================================================================
           LOGIN BUTTON
           ================================================================ */

        .login-button {
            width: 100%;

            min-height: 54px;

            margin-top: 6px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 10px;

            border: none;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary) 0%,
                    #2A5D9B 100%
                );

            color: #FFFFFF;

            cursor: pointer;

            font-size: 14px;
            font-weight: 800;

            box-shadow:
                0 14px 30px
                rgba(24, 59, 107, 0.20);

            transition:
                var(--transition);
        }


        .login-button:hover {
            transform:
                translateY(-2px);

            box-shadow:
                0 18px 38px
                rgba(24, 59, 107, 0.26);
        }


        .login-button:active {
            transform:
                translateY(0);
        }


        .button-arrow {
            font-size: 18px;

            transition:
                transform 0.25s ease;
        }


        .login-button:hover .button-arrow {
            transform:
                translateX(4px);
        }


        /* ================================================================
           SECURITY NOTE
           ================================================================ */

        .login-security-note {
            margin-top: 24px;

            padding:
                15px
                16px;

            display: flex;
            align-items: flex-start;

            gap: 11px;

            border:
                1px solid
                var(--border-light);

            border-radius:
                14px;

            background:
                var(--surface-soft);

            color:
                var(--text-muted);

            font-size:
                12px;

            line-height:
                1.65;
        }


        .security-note-icon {
            flex-shrink: 0;

            width: 26px;
            height: 26px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background:
                var(--accent-soft);

            color:
                var(--accent-dark);

            font-weight:
                850;
        }


        /* ================================================================
           PORTAL LINK
           ================================================================ */

        .portal-navigation {
            margin-top:
                25px;

            padding-top:
                22px;

            border-top:
                1px solid
                var(--border-light);

            text-align:
                center;

            color:
                var(--text-muted);

            font-size:
                13px;
        }


        .portal-navigation a {
            color:
                var(--accent-dark);

            font-weight:
                750;

            text-decoration:
                none;
        }


        .portal-navigation a:hover {
            text-decoration:
                underline;
        }


        /* ================================================================
           FOOTER
           ================================================================ */

        .page-footer {
            padding:
                0
                24px
                26px;
        }


        .page-footer-inner {
            width: 100%;
            max-width: 1260px;

            margin:
                0
                auto;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;

            color:
                var(--text-muted);

            font-size:
                12px;
        }


        .footer-security {
            display: flex;
            align-items: center;

            gap: 8px;
        }


        .footer-security-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background:
                #22C55E;
        }


        /* ================================================================
           ACCESSIBILITY
           ================================================================ */

        a:focus-visible,
        button:focus-visible,
        input:focus-visible {
            outline:
                3px solid
                rgba(59, 130, 246, 0.22);

            outline-offset:
                3px;
        }


        /* ================================================================
           RESPONSIVE
           ================================================================ */

        @media (
            max-width: 1000px
        ) {

            .login-container {
                grid-template-columns:
                    1fr;

                max-width:
                    720px;
            }


            .login-information {
                min-height:
                    auto;

                padding:
                    44px
                    40px;
            }


            .information-title {
                font-size:
                    36px;
            }


            .information-footer {
                margin-top:
                    30px;
            }


            .login-form-section {
                padding:
                    48px
                    40px;
            }


            .login-form-wrapper {
                max-width:
                    520px;
            }

        }


        @media (
            max-width: 650px
        ) {

            .top-header {
                padding:
                    18px
                    16px
                    0;
            }


            .top-header-inner {
                align-items:
                    flex-start;
            }


            .brand-caption {
                display:
                    none;
            }


            .header-back-link {
                padding:
                    9px
                    12px;

                font-size:
                    12px;
            }


            .login-main {
                padding:
                    20px
                    14px
                    28px;
            }


            .login-container {
                border-radius:
                    24px;
            }


            .login-information {
                padding:
                    32px
                    24px;
            }


            .information-title {
                font-size:
                    31px;
            }


            .information-description {
                font-size:
                    14px;
            }


            .login-form-section {
                padding:
                    36px
                    24px;
            }


            .form-heading {
                font-size:
                    29px;
            }


            .page-footer-inner {
                flex-direction:
                    column;

                align-items:
                    flex-start;
            }

        }


        @media (
            max-width: 430px
        ) {

            .brand-information {
                display:
                    none;
            }


            .brand-logo {
                width:
                    48px;

                height:
                    48px;
            }


            .information-title {
                font-size:
                    28px;
            }


            .feature-list {
                gap:
                    13px;
            }


            .login-form-section {
                padding:
                    32px
                    20px;
            }


            .login-icon {
                width:
                    60px;

                height:
                    60px;
            }

        }

    </style>

</head>


<body>


{{-- ======================================================================
     BACKGROUND ELEMENTS
     ====================================================================== --}}

<div class="background-orb orb-one"></div>
<div class="background-orb orb-two"></div>
<div class="background-orb orb-three"></div>


<div class="page-shell">


    {{-- ==================================================================
         HEADER
         ================================================================== --}}

    <header class="top-header">

        <div class="top-header-inner">


            <a
                href="{{ route('home') }}"
                class="brand"
                aria-label="Return to OJT Sync home"
            >

                <div class="brand-logo">
                    OJT
                </div>


                <div class="brand-information">

                    <span class="brand-name">
                        OJT Sync
                    </span>

                    <span class="brand-caption">
                        Internship Monitoring Platform
                    </span>

                </div>

            </a>


            <a
                href="{{ route('home') }}"
                class="header-back-link"
            >
                <span aria-hidden="true">
                    ←
                </span>

                Back to Portal Selection
            </a>


        </div>

    </header>


    {{-- ==================================================================
         MAIN LOGIN
         ================================================================== --}}

    <main class="login-main">


        <section class="login-container">


            {{-- ==========================================================
                 LEFT PANEL
                 ========================================================== --}}

            <div class="login-information">


                <div class="information-content">


                    <div class="admin-label">

                        <span class="admin-label-dot"></span>

                        Authorized Administrator Access

                    </div>


                    <h1 class="information-title">

                        Manage OJT operations
                        from one secure
                        control center.

                    </h1>


                    <p class="information-description">

                        The OJT Sync Administrator Portal provides
                        centralized management for Students,
                        Supervisors, companies, assignments,
                        monitoring reports, completion records,
                        and system security activities.

                    </p>


                    <div class="feature-list">


                        <div class="feature-item">

                            <div class="feature-icon">
                                01
                            </div>

                            <div class="feature-text">

                                <strong>
                                    Account Management
                                </strong>

                                <span>
                                    Manage Student and Supervisor
                                    accounts with role-based access.
                                </span>

                            </div>

                        </div>


                        <div class="feature-item">

                            <div class="feature-icon">
                                02
                            </div>

                            <div class="feature-text">

                                <strong>
                                    OJT Monitoring
                                </strong>

                                <span>
                                    Review companies, assignments,
                                    validated hours and progress.
                                </span>

                            </div>

                        </div>


                        <div class="feature-item">

                            <div class="feature-icon">
                                03
                            </div>

                            <div class="feature-text">

                                <strong>
                                    Reports & Accountability
                                </strong>

                                <span>
                                    Access formal completion records,
                                    reports and system audit history.
                                </span>

                            </div>

                        </div>


                    </div>


                </div>


                <div class="information-footer">

                    <div class="security-symbol">
                        ✓
                    </div>

                    <div class="security-text">

                        <strong>
                            Protected Administrative Area
                        </strong>

                        <span>
                            Authentication attempts and important
                            administrative actions are monitored
                            for system accountability.
                        </span>

                    </div>

                </div>


            </div>


            {{-- ==========================================================
                 LOGIN FORM
                 ========================================================== --}}

            <div class="login-form-section">


                <div class="login-form-wrapper">


                    <div
                        class="login-icon"
                        aria-hidden="true"
                    >
                        AD
                    </div>


                    <h2 class="form-heading">
                        Administrator Login
                    </h2>


                    <p class="form-subheading">

                        Enter your authorized Administrator
                        credentials to access the OJT Sync
                        management dashboard.

                    </p>


                    {{-- ==================================================
                         SESSION STATUS
                         ================================================== --}}

                    @if (session('success'))

                        <div class="alert alert-success">

                            {{ session('success') }}

                        </div>

                    @endif


                    {{-- ==================================================
                         VALIDATION ERRORS
                         ================================================== --}}

                    @if ($errors->any())

                        <div
                            class="alert alert-danger"
                            role="alert"
                        >

                            <strong>
                                Unable to sign in.
                            </strong>

                            <ul>

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- ==================================================
                         LOGIN FORM
                         ================================================== --}}

                    <form
                        method="POST"
                        action="{{ route('admin.login.store') }}"
                        autocomplete="on"
                    >

                        @csrf


                        {{-- ==============================================
                             EMAIL
                             ============================================== --}}

                        <div class="form-group">


                            <div class="form-label-row">

                                <label
                                    for="email"
                                    class="form-label"
                                >
                                    Email Address
                                </label>

                                <span class="required-label">
                                    Required
                                </span>

                            </div>


                            <div class="input-wrapper">


                                <span
                                    class="input-icon"
                                    aria-hidden="true"
                                >
                                    @
                                </span>


                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control"
                                    placeholder="admin@example.com"
                                    autocomplete="username"
                                    inputmode="email"
                                    maxlength="255"
                                    required
                                    autofocus
                                >


                            </div>


                            @error('email')

                                <div class="field-error">

                                    {{ $message }}

                                </div>

                            @enderror


                        </div>


                        {{-- ==============================================
                             PASSWORD
                             ============================================== --}}

                        <div class="form-group">


                            <div class="form-label-row">

                                <label
                                    for="password"
                                    class="form-label"
                                >
                                    Password
                                </label>

                                <span class="required-label">
                                    Required
                                </span>

                            </div>


                            <div class="input-wrapper">


                                <span
                                    class="input-icon"
                                    aria-hidden="true"
                                >
                                    ●
                                </span>


                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control has-toggle"
                                    placeholder="Enter your password"
                                    autocomplete="current-password"
                                    required
                                >


                                <button
                                    type="button"
                                    class="password-toggle"
                                    id="passwordToggle"
                                    aria-controls="password"
                                    aria-pressed="false"
                                >
                                    Show
                                </button>


                            </div>


                            @error('password')

                                <div class="field-error">

                                    {{ $message }}

                                </div>

                            @enderror


                        </div>


                        {{-- ==============================================
                             SUBMIT
                             ============================================== --}}

                        <button
                            type="submit"
                            class="login-button"
                        >

                            Sign In to Administrator Portal

                            <span
                                class="button-arrow"
                                aria-hidden="true"
                            >
                                →
                            </span>

                        </button>


                    </form>


                    {{-- ==================================================
                         SECURITY MESSAGE
                         ================================================== --}}

                    <div class="login-security-note">

                        <div class="security-note-icon">
                            ✓
                        </div>

                        <div>

                            This portal is restricted to authorized
                            OJT Sync Administrators. Login attempts
                            may be recorded as part of the system's
                            security and audit monitoring.

                        </div>

                    </div>


                    {{-- ==================================================
                         PORTAL NAVIGATION
                         ================================================== --}}

                    <div class="portal-navigation">

                        Are you a Student or Supervisor?

                        <a href="{{ route('login') }}">
                            Open the OJT Portal
                        </a>

                    </div>


                </div>


            </div>


        </section>


    </main>


    {{-- ==================================================================
         FOOTER
         ================================================================== --}}

    <footer class="page-footer">


        <div class="page-footer-inner">


            <div>

                © {{ now()->year }}
                <strong>OJT Sync</strong>

                — OJT Monitoring Platform

            </div>


            <div class="footer-security">

                <span class="footer-security-dot"></span>

                Secure Role-Based Authentication

            </div>


        </div>


    </footer>


</div>


{{-- ======================================================================
     PASSWORD VISIBILITY
     ====================================================================== --}}

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const passwordInput =
                document.getElementById(
                    'password'
                );

            const passwordToggle =
                document.getElementById(
                    'passwordToggle'
                );

            if (
                ! passwordInput
                || ! passwordToggle
            ) {
                return;
            }

            passwordToggle.addEventListener(
                'click',
                function () {

                    const passwordVisible =
                        passwordInput.type
                        === 'text';

                    passwordInput.type =
                        passwordVisible
                            ? 'password'
                            : 'text';

                    passwordToggle.textContent =
                        passwordVisible
                            ? 'Show'
                            : 'Hide';

                    passwordToggle.setAttribute(
                        'aria-pressed',
                        passwordVisible
                            ? 'false'
                            : 'true'
                    );

                    passwordInput.focus();

                }
            );

        }
    );

</script>


</body>

</html>