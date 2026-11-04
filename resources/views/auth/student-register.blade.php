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

    <title>Create Student Account | OJT Sync</title>


    <style>

        /* ================================================================
           DESIGN TOKENS
           ================================================================ */

        :root {
            --primary: #183B6B;
            --primary-dark: #102A4A;
            --primary-deep: #0A1F38;
            --primary-light: #315F98;

            --blue: #2563EB;
            --blue-light: #3B82F6;
            --blue-soft: #DBEAFE;

            --teal: #0F766E;
            --teal-soft: #DDF7F3;

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
            --text-body: #566D88;
            --text-muted: #8292A6;

            --border: #D9E3EE;
            --border-soft: #E8EEF5;

            --shadow-soft:
                0 10px 28px rgba(15, 42, 74, 0.06);

            --shadow-medium:
                0 20px 50px rgba(15, 42, 74, 0.10);

            --shadow-large:
                0 36px 85px rgba(15, 42, 74, 0.14);

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

            color:
                var(--text-heading);
        }


        body {
            min-height: 100vh;

            overflow-x: hidden;

            background:
                radial-gradient(
                    circle at 8% 10%,
                    rgba(59, 130, 246, 0.13),
                    transparent 27%
                ),
                radial-gradient(
                    circle at 92% 18%,
                    rgba(15, 118, 110, 0.08),
                    transparent 26%
                ),
                linear-gradient(
                    145deg,
                    #F9FCFF 0%,
                    #EEF4FA 48%,
                    #EAF1F8 100%
                );
        }


        input,
        button,
        a {
            font: inherit;
        }


        /* ================================================================
           BACKGROUND DECORATIONS
           ================================================================ */

        .background-orb {
            position: fixed;

            border-radius: 50%;

            pointer-events: none;

            z-index: 0;
        }


        .orb-one {
            width: 320px;
            height: 320px;

            top: -120px;
            left: -110px;

            background:
                rgba(37, 99, 235, 0.09);

            filter:
                blur(8px);
        }


        .orb-two {
            width: 350px;
            height: 350px;

            right: -130px;
            top: 23%;

            background:
                rgba(15, 118, 110, 0.07);

            filter:
                blur(8px);
        }


        .orb-three {
            width: 390px;
            height: 390px;

            bottom: -200px;
            left: 37%;

            background:
                rgba(59, 130, 246, 0.06);

            filter:
                blur(10px);
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
           HEADER
           ================================================================ */

        .top-header {
            padding:
                24px
                32px
                0;
        }


        .top-header-inner {
            width: 100%;
            max-width: 1280px;

            margin:
                0
                auto;

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
            color:
                var(--primary);

            font-size: 20px;
            font-weight: 850;

            line-height: 1.1;
        }


        .brand-caption {
            color:
                var(--text-muted);

            font-size: 12px;
        }


        .header-actions {
            display: flex;
            align-items: center;

            gap: 10px;
        }


        .header-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding:
                10px
                15px;

            border:
                1px solid
                rgba(24, 59, 107, 0.10);

            border-radius: 999px;

            background:
                rgba(255, 255, 255, 0.78);

            color:
                var(--primary);

            text-decoration: none;

            font-size: 12px;
            font-weight: 750;

            box-shadow:
                var(--shadow-soft);

            backdrop-filter:
                blur(10px);

            transition:
                var(--transition);
        }


        .header-link:hover {
            transform:
                translateY(-2px);

            background:
                #FFFFFF;

            box-shadow:
                var(--shadow-medium);
        }


        /* ================================================================
           MAIN
           ================================================================ */

        .registration-main {
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


        .registration-container {
            width: 100%;
            max-width: 1200px;

            min-height: 760px;

            display: grid;

            grid-template-columns:
                0.96fr
                1.04fr;

            overflow: hidden;

            border:
                1px solid
                rgba(255, 255, 255, 0.72);

            border-radius:
                var(--radius-extra-large);

            background:
                rgba(255, 255, 255, 0.72);

            box-shadow:
                var(--shadow-large);

            backdrop-filter:
                blur(16px);
        }


        /* ================================================================
           LEFT INFORMATION PANEL
           ================================================================ */

        .registration-information {
            position: relative;

            overflow: hidden;

            padding:
                60px
                52px;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

            background:
                radial-gradient(
                    circle at 15% 12%,
                    rgba(59, 130, 246, 0.18),
                    transparent 25%
                ),
                linear-gradient(
                    145deg,
                    #102D50 0%,
                    #183B6B 56%,
                    #245B94 100%
                );

            color:
                #FFFFFF;
        }


        .registration-information::before {
            content: "";

            position: absolute;

            width: 370px;
            height: 370px;

            top: -180px;
            right: -160px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.06);
        }


        .registration-information::after {
            content: "";

            position: absolute;

            width: 310px;
            height: 310px;

            bottom: -160px;
            left: -150px;

            border-radius: 50%;

            background:
                rgba(59, 130, 246, 0.12);
        }


        .information-content,
        .information-footer {
            position: relative;

            z-index: 2;
        }


        .student-badge {
            display: inline-flex;
            align-items: center;

            gap: 9px;

            width: fit-content;

            padding:
                9px
                14px;

            margin-bottom:
                24px;

            border:
                1px solid
                rgba(255, 255, 255, 0.16);

            border-radius: 999px;

            background:
                rgba(255, 255, 255, 0.09);

            color:
                rgba(255, 255, 255, 0.92);

            font-size: 12px;
            font-weight: 750;
        }


        .student-badge-dot {
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
                18px;

            color:
                #FFFFFF;

            font-size: 43px;
            font-weight: 850;

            line-height: 1.12;

            letter-spacing:
                -0.7px;
        }


        .information-description {
            max-width: 510px;

            margin:
                0
                0
                30px;

            color:
                rgba(255, 255, 255, 0.72);

            font-size: 15px;

            line-height: 1.8;
        }


        /* ================================================================
           ONBOARDING STEPS
           ================================================================ */

        .onboarding-list {
            display: grid;

            gap: 15px;
        }


        .onboarding-item {
            display: flex;
            align-items: flex-start;

            gap: 13px;

            padding:
                14px;

            border:
                1px solid
                rgba(255, 255, 255, 0.10);

            border-radius:
                15px;

            background:
                rgba(255, 255, 255, 0.06);
        }


        .onboarding-number {
            flex-shrink: 0;

            width: 34px;
            height: 34px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background:
                rgba(255, 255, 255, 0.11);

            color:
                #FFFFFF;

            font-size: 12px;
            font-weight: 850;
        }


        .onboarding-text strong {
            display: block;

            margin-bottom: 4px;

            color:
                #FFFFFF;

            font-size: 13px;
        }


        .onboarding-text span {
            color:
                rgba(255, 255, 255, 0.61);

            font-size: 12px;

            line-height: 1.6;
        }


        /* ================================================================
           LEFT FOOTER
           ================================================================ */

        .information-footer {
            margin-top: 30px;

            padding-top: 20px;

            border-top:
                1px solid
                rgba(255, 255, 255, 0.12);

            display: flex;
            align-items: flex-start;

            gap: 12px;
        }


        .security-symbol {
            flex-shrink: 0;

            width: 39px;
            height: 39px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background:
                rgba(255, 255, 255, 0.10);

            color:
                #FFFFFF;

            font-size: 15px;
            font-weight: 900;
        }


        .security-information strong {
            display: block;

            margin-bottom: 3px;

            font-size: 13px;
        }


        .security-information span {
            color:
                rgba(255, 255, 255, 0.60);

            font-size: 12px;

            line-height: 1.5;
        }


        /* ================================================================
           FORM PANEL
           ================================================================ */

        .registration-form-section {
            padding:
                50px
                50px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                rgba(255, 255, 255, 0.96);
        }


        .registration-form-wrapper {
            width: 100%;
            max-width: 500px;
        }


        .registration-icon {
            width: 66px;
            height: 66px;

            margin-bottom: 20px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 21px;

            background:
                linear-gradient(
                    135deg,
                    #E8F1FD 0%,
                    #D8E8FB 100%
                );

            color:
                var(--primary);

            font-size: 19px;
            font-weight: 900;

            box-shadow:
                inset 0 0 0 1px
                rgba(24, 59, 107, 0.07);
        }


        .form-heading {
            margin:
                0
                0
                7px;

            color:
                var(--text-heading);

            font-size: 34px;
            font-weight: 850;

            line-height: 1.2;

            letter-spacing:
                -0.4px;
        }


        .form-subheading {
            margin:
                0
                0
                24px;

            color:
                var(--text-body);

            font-size: 14px;

            line-height: 1.75;
        }


        /* ================================================================
           ACCOUNT TYPE NOTICE
           ================================================================ */

        .account-notice {
            margin-bottom: 24px;

            padding:
                14px;

            display: flex;
            align-items: flex-start;

            gap: 11px;

            border:
                1px solid
                #DCE8F6;

            border-radius:
                13px;

            background:
                #F4F8FD;

            color:
                var(--text-body);

            font-size: 12px;

            line-height: 1.65;
        }


        .account-notice-icon {
            flex-shrink: 0;

            width: 28px;
            height: 28px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background:
                var(--blue-soft);

            color:
                var(--blue);

            font-size: 12px;
            font-weight: 850;
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
                6px
                0
                0;

            padding-left:
                20px;
        }


        /* ================================================================
           FORM
           ================================================================ */

        .form-group {
            margin-bottom: 18px;
        }


        .form-label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            margin-bottom: 8px;
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

            display: flex;
            align-items: center;
            justify-content: center;

            color:
                var(--text-muted);

            pointer-events: none;

            font-size: 13px;
            font-weight: 700;
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
                var(--blue-light);

            background:
                #FFFFFF;

            box-shadow:
                0 0 0 4px
                rgba(59, 130, 246, 0.10);
        }


        .form-control.has-toggle {
            padding-right: 90px;
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
            margin-top: 7px;

            color:
                var(--danger);

            font-size: 12px;
        }


        /* ================================================================
           PASSWORD REQUIREMENTS
           ================================================================ */

        .password-guidance {
            margin:
                -4px
                0
                19px;

            padding:
                13px
                14px;

            border:
                1px solid
                var(--border-soft);

            border-radius:
                12px;

            background:
                var(--surface-soft);
        }


        .password-guidance-title {
            margin-bottom: 8px;

            color:
                var(--text-heading);

            font-size: 11px;
            font-weight: 800;
        }


        .password-requirements {
            margin: 0;
            padding: 0;

            list-style: none;

            display: grid;
            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap:
                6px
                14px;
        }


        .password-requirements li {
            display: flex;
            align-items: center;

            gap: 6px;

            color:
                var(--text-muted);

            font-size: 10px;

            line-height: 1.5;
        }


        .password-requirements li::before {
            content: "•";

            color:
                var(--blue);

            font-weight: 900;
        }


        /* ================================================================
           SUBMIT BUTTON
           ================================================================ */

        .register-button {
            width: 100%;

            min-height: 55px;

            margin-top: 5px;

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
                    #2D609D 100%
                );

            color:
                #FFFFFF;

            cursor: pointer;

            font-size: 14px;
            font-weight: 800;

            box-shadow:
                0 14px 30px
                rgba(24, 59, 107, 0.20);

            transition:
                var(--transition);
        }


        .register-button:hover {
            transform:
                translateY(-2px);

            box-shadow:
                0 18px 38px
                rgba(24, 59, 107, 0.26);
        }


        .button-arrow {
            font-size: 18px;

            transition:
                transform 0.25s ease;
        }


        .register-button:hover .button-arrow {
            transform:
                translateX(4px);
        }


        /* ================================================================
           SECURITY MESSAGE
           ================================================================ */

        .security-note {
            margin-top: 18px;

            display: flex;
            align-items: flex-start;

            gap: 10px;

            color:
                var(--text-muted);

            font-size: 11px;

            line-height: 1.6;
        }


        .security-note-symbol {
            flex-shrink: 0;

            width: 23px;
            height: 23px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 7px;

            background:
                var(--success-soft);

            color:
                var(--success);

            font-weight: 900;
        }


        /* ================================================================
           LOGIN LINK
           ================================================================ */

        .login-navigation {
            margin-top: 20px;

            padding-top: 19px;

            border-top:
                1px solid
                var(--border-soft);

            text-align: center;

            color:
                var(--text-muted);

            font-size: 12px;
        }


        .login-navigation a {
            color:
                var(--blue);

            font-weight: 800;

            text-decoration: none;
        }


        .login-navigation a:hover {
            text-decoration: underline;
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
            max-width: 1280px;

            margin:
                0
                auto;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;

            color:
                var(--text-muted);

            font-size: 12px;
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

            outline-offset: 3px;
        }


        /* ================================================================
           RESPONSIVE
           ================================================================ */

        @media (
            max-width: 1030px
        ) {

            .registration-container {
                grid-template-columns: 1fr;

                max-width: 760px;
            }


            .registration-information {
                min-height: auto;

                padding:
                    44px
                    40px;
            }


            .information-title {
                font-size: 36px;
            }


            .registration-form-section {
                padding:
                    48px
                    40px;
            }


            .registration-form-wrapper {
                max-width: 560px;
            }

        }


        @media (
            max-width: 680px
        ) {

            .top-header {
                padding:
                    18px
                    16px
                    0;
            }


            .brand-caption {
                display: none;
            }


            .header-link {
                padding:
                    9px
                    11px;

                font-size: 11px;
            }


            .registration-main {
                padding:
                    20px
                    14px
                    28px;
            }


            .registration-container {
                border-radius: 24px;
            }


            .registration-information {
                padding:
                    32px
                    24px;
            }


            .information-title {
                font-size: 31px;
            }


            .information-description {
                font-size: 14px;
            }


            .registration-form-section {
                padding:
                    36px
                    24px;
            }


            .form-heading {
                font-size: 29px;
            }


            .password-requirements {
                grid-template-columns: 1fr;
            }


            .page-footer-inner {
                flex-direction: column;

                align-items: flex-start;
            }

        }


        @media (
            max-width: 460px
        ) {

            .brand-information {
                display: none;
            }


            .brand-logo {
                width: 48px;
                height: 48px;
            }


            .information-title {
                font-size: 28px;
            }


            .registration-form-section {
                padding:
                    32px
                    20px;
            }


            .registration-icon {
                width: 60px;
                height: 60px;
            }

        }

    </style>

</head>


<body>


{{-- ======================================================================
     BACKGROUND DECORATION
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


            <div class="header-actions">


                <a
                    href="{{ route('login') }}"
                    class="header-link"
                >
                    ← Back to OJT Portal
                </a>


            </div>


        </div>


    </header>


    {{-- ==================================================================
         MAIN REGISTRATION AREA
         ================================================================== --}}

    <main class="registration-main">


        <section class="registration-container">


            {{-- ==========================================================
                 LEFT INFORMATION PANEL
                 ========================================================== --}}

            <div class="registration-information">


                <div class="information-content">


                    <div class="student-badge">

                        <span class="student-badge-dot"></span>

                        Student Account Registration

                    </div>


                    <h1 class="information-title">

                        Begin your OJT journey
                        with one secure account.

                    </h1>


                    <p class="information-description">

                        Create your OJT Sync Student account to access
                        your OJT profile, GPS Selfie Attendance,
                        automatic Timesheet, Daily Work Logs,
                        reports, and completion history.

                    </p>


                    {{-- ==================================================
                         ONBOARDING STEPS
                         ================================================== --}}

                    <div class="onboarding-list">


                        <div class="onboarding-item">


                            <div class="onboarding-number">
                                01
                            </div>


                            <div class="onboarding-text">

                                <strong>
                                    Create Your Account
                                </strong>

                                <span>
                                    Register using your full name,
                                    email address and a secure password.
                                </span>

                            </div>


                        </div>


                        <div class="onboarding-item">


                            <div class="onboarding-number">
                                02
                            </div>


                            <div class="onboarding-text">

                                <strong>
                                    Complete Your Student Profile
                                </strong>

                                <span>
                                    Add your Student number, program,
                                    year level and required profile details.
                                </span>

                            </div>


                        </div>


                        <div class="onboarding-item">


                            <div class="onboarding-number">
                                03
                            </div>


                            <div class="onboarding-text">

                                <strong>
                                    Receive Your OJT Assignment
                                </strong>

                                <span>
                                    Once assigned by the Administrator,
                                    your company and Supervisor become
                                    available in your dashboard.
                                </span>

                            </div>


                        </div>


                        <div class="onboarding-item">


                            <div class="onboarding-number">
                                04
                            </div>


                            <div class="onboarding-text">

                                <strong>
                                    Start Monitoring Your OJT
                                </strong>

                                <span>
                                    Use GPS Selfie Attendance,
                                    Daily Work Logs and Timesheet
                                    monitoring throughout your placement.
                                </span>

                            </div>


                        </div>


                    </div>


                </div>


                {{-- ======================================================
                     SECURITY
                     ====================================================== --}}

                <div class="information-footer">


                    <div class="security-symbol">
                        ✓
                    </div>


                    <div class="security-information">

                        <strong>
                            Student Registration Only
                        </strong>

                        <span>
                            Public registration always creates a Student
                            account. Administrator and Supervisor roles
                            cannot be assigned from this page.
                        </span>

                    </div>


                </div>


            </div>


            {{-- ==========================================================
                 REGISTRATION FORM
                 ========================================================== --}}

            <div class="registration-form-section">


                <div class="registration-form-wrapper">


                    <div
                        class="registration-icon"
                        aria-hidden="true"
                    >
                        ST
                    </div>


                    <h2 class="form-heading">
                        Create Student Account
                    </h2>


                    <p class="form-subheading">

                        Enter your account information below.
                        After registration, you can continue
                        setting up your Student profile.

                    </p>


                    {{-- ==================================================
                         ACCOUNT NOTICE
                         ================================================== --}}

                    <div class="account-notice">


                        <div class="account-notice-icon">
                            i
                        </div>


                        <div>

                            This registration page creates
                            <strong>Student accounts only</strong>.
                            Supervisor and Administrator accounts are
                            managed separately by the system Administrator.

                        </div>


                    </div>


                    {{-- ==================================================
                         SUCCESS MESSAGE
                         ================================================== --}}

                    @if (session('success'))

                        <div
                            class="alert alert-success"
                            role="status"
                        >

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
                                Please review the information below.
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
                         REGISTRATION FORM
                         ================================================== --}}

                    <form
                        method="POST"
                        action="{{ route('student.register.store') }}"
                        autocomplete="on"
                    >

                        @csrf


                        {{-- ==============================================
                             FULL NAME
                             ============================================== --}}

                        <div class="form-group">


                            <div class="form-label-row">


                                <label
                                    for="name"
                                    class="form-label"
                                >
                                    Full Name
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
                                    A
                                </span>


                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="form-control"
                                    placeholder="Enter your full name"
                                    autocomplete="name"
                                    maxlength="255"
                                    required
                                    autofocus
                                >


                            </div>


                            @error('name')

                                <div class="field-error">

                                    {{ $message }}

                                </div>

                            @enderror


                        </div>


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
                                    placeholder="Enter your email address"
                                    autocomplete="email"
                                    inputmode="email"
                                    maxlength="255"
                                    required
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
                                    placeholder="Create a secure password"
                                    autocomplete="new-password"
                                    required
                                >


                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-password-toggle="password"
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
                             PASSWORD REQUIREMENTS
                             ============================================== --}}

                        <div class="password-guidance">


                            <div class="password-guidance-title">

                                Password requirements

                            </div>


                            <ul class="password-requirements">

                                <li>
                                    At least 8 characters
                                </li>

                                <li>
                                    Uppercase letter
                                </li>

                                <li>
                                    Lowercase letter
                                </li>

                                <li>
                                    At least one number
                                </li>

                                <li>
                                    At least one symbol
                                </li>

                                <li>
                                    Must match confirmation
                                </li>

                            </ul>


                        </div>


                        {{-- ==============================================
                             CONFIRM PASSWORD
                             ============================================== --}}

                        <div class="form-group">


                            <div class="form-label-row">


                                <label
                                    for="password_confirmation"
                                    class="form-label"
                                >
                                    Confirm Password
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
                                    ✓
                                </span>


                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control has-toggle"
                                    placeholder="Re-enter your password"
                                    autocomplete="new-password"
                                    required
                                >


                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-password-toggle="password_confirmation"
                                    aria-controls="password_confirmation"
                                    aria-pressed="false"
                                >
                                    Show
                                </button>


                            </div>


                        </div>


                        {{-- ==============================================
                             SUBMIT
                             ============================================== --}}

                        <button
                            type="submit"
                            class="register-button"
                        >

                            Create Student Account

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

                    <div class="security-note">


                        <div class="security-note-symbol">
                            ✓
                        </div>


                        <div>

                            Your password is securely hashed before
                            it is stored. OJT Sync never displays
                            or stores your password as readable text.

                        </div>


                    </div>


                    {{-- ==================================================
                         LOGIN LINK
                         ================================================== --}}

                    <div class="login-navigation">

                        Already have an account?

                        <a href="{{ route('login') }}">

                            Sign in to the OJT Portal

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

                <strong>
                    OJT Sync
                </strong>

                — OJT Monitoring Platform

            </div>


            <div class="footer-security">

                <span class="footer-security-dot"></span>

                Secure Student Registration

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

            const passwordButtons =
                document.querySelectorAll(
                    '[data-password-toggle]'
                );


            passwordButtons.forEach(
                function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            const targetId =
                                button.getAttribute(
                                    'data-password-toggle'
                                );


                            const input =
                                document.getElementById(
                                    targetId
                                );


                            if (! input) {
                                return;
                            }


                            const isVisible =
                                input.type
                                === 'text';


                            input.type =
                                isVisible
                                    ? 'password'
                                    : 'text';


                            button.textContent =
                                isVisible
                                    ? 'Show'
                                    : 'Hide';


                            button.setAttribute(
                                'aria-pressed',
                                isVisible
                                    ? 'false'
                                    : 'true'
                            );


                            input.focus();

                        }
                    );

                }
            );

        }
    );

</script>


</body>

</html>