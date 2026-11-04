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

    <title>OJT Portal Login | OJT Sync</title>


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

            --student: #2563EB;
            --student-soft: #EAF2FF;

            --supervisor: #0F766E;
            --supervisor-dark: #115E59;
            --supervisor-soft: #DDF7F3;

            --success: #15803D;
            --success-soft: #DCFCE7;

            --danger: #B42318;
            --danger-soft: #FEE4E2;

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
                    circle at 7% 8%,
                    rgba(59, 130, 246, 0.13),
                    transparent 27%
                ),
                radial-gradient(
                    circle at 93% 18%,
                    rgba(15, 118, 110, 0.09),
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
            width: 310px;
            height: 310px;

            top: -120px;
            left: -100px;

            background:
                rgba(37, 99, 235, 0.09);

            filter:
                blur(8px);
        }


        .orb-two {
            width: 340px;
            height: 340px;

            right: -130px;
            top: 20%;

            background:
                rgba(15, 118, 110, 0.07);

            filter:
                blur(8px);
        }


        .orb-three {
            width: 380px;
            height: 380px;

            bottom: -190px;
            left: 38%;

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


        .header-link.admin {
            background:
                var(--primary);

            color:
                #FFFFFF;

            border-color:
                var(--primary);
        }


        .header-link.admin:hover {
            background:
                var(--primary-dark);
        }


        /* ================================================================
           MAIN LOGIN
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
            max-width: 1190px;

            min-height: 700px;

            display: grid;

            grid-template-columns:
                1.06fr
                0.94fr;

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
           LEFT PORTAL INFORMATION PANEL
           ================================================================ */

        .portal-information {
            position: relative;

            overflow: hidden;

            padding:
                58px
                54px;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

            background:
                radial-gradient(
                    circle at 15% 12%,
                    rgba(59, 130, 246, 0.18),
                    transparent 26%
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


        .portal-information::before {
            content: "";

            position: absolute;

            width: 360px;
            height: 360px;

            top: -170px;
            right: -160px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.06);
        }


        .portal-information::after {
            content: "";

            position: absolute;

            width: 300px;
            height: 300px;

            bottom: -160px;
            left: -130px;

            border-radius: 50%;

            background:
                rgba(59, 130, 246, 0.12);
        }


        .portal-information-content,
        .portal-information-footer {
            position: relative;

            z-index: 2;
        }


        .portal-badge {
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

            border-radius:
                999px;

            background:
                rgba(255, 255, 255, 0.09);

            color:
                rgba(255, 255, 255, 0.90);

            font-size:
                12px;
            font-weight:
                750;
        }


        .portal-badge-dot {
            width:
                8px;

            height:
                8px;

            border-radius:
                50%;

            background:
                #4ADE80;

            box-shadow:
                0 0 0 6px
                rgba(74, 222, 128, 0.12);
        }


        .portal-title {
            max-width:
                520px;

            margin:
                0
                0
                18px;

            color:
                #FFFFFF;

            font-size:
                43px;

            font-weight:
                850;

            line-height:
                1.12;

            letter-spacing:
                -0.7px;
        }


        .portal-description {
            max-width:
                520px;

            margin:
                0
                0
                28px;

            color:
                rgba(255, 255, 255, 0.72);

            font-size:
                15px;

            line-height:
                1.8;
        }


        /* ================================================================
           ROLE CARDS
           ================================================================ */

        .role-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap:
                14px;
        }


        .role-card {
            padding:
                19px;

            border:
                1px solid
                rgba(255, 255, 255, 0.12);

            border-radius:
                18px;

            background:
                rgba(255, 255, 255, 0.08);

            backdrop-filter:
                blur(10px);
        }


        .role-card-header {
            display: flex;
            align-items: center;

            gap:
                11px;

            margin-bottom:
                12px;
        }


        .role-icon {
            width:
                42px;

            height:
                42px;

            flex-shrink:
                0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius:
                13px;

            font-size:
                14px;

            font-weight:
                850;
        }


        .role-icon.student {
            background:
                rgba(96, 165, 250, 0.17);

            color:
                #BFDBFE;
        }


        .role-icon.supervisor {
            background:
                rgba(45, 212, 191, 0.15);

            color:
                #99F6E4;
        }


        .role-name {
            color:
                #FFFFFF;

            font-size:
                15px;

            font-weight:
                800;
        }


        .role-description {
            margin:
                0;

            color:
                rgba(255, 255, 255, 0.61);

            font-size:
                12px;

            line-height:
                1.7;
        }


        .role-list {
            list-style:
                none;

            margin:
                14px
                0
                0;

            padding:
                0;

            display:
                grid;

            gap:
                8px;
        }


        .role-list li {
            display: flex;
            align-items: flex-start;

            gap:
                8px;

            color:
                rgba(255, 255, 255, 0.68);

            font-size:
                11px;

            line-height:
                1.55;
        }


        .role-list li::before {
            content:
                "✓";

            color:
                #86EFAC;

            font-weight:
                900;
        }


        /* ================================================================
           LEFT FOOTER
           ================================================================ */

        .portal-information-footer {
            margin-top:
                28px;

            padding-top:
                20px;

            border-top:
                1px solid
                rgba(255, 255, 255, 0.12);

            display: flex;
            align-items: center;

            gap:
                12px;
        }


        .security-symbol {
            width:
                39px;

            height:
                39px;

            flex-shrink:
                0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius:
                12px;

            background:
                rgba(255, 255, 255, 0.10);

            color:
                #FFFFFF;

            font-size:
                16px;
        }


        .security-information strong {
            display: block;

            margin-bottom:
                3px;

            font-size:
                13px;
        }


        .security-information span {
            color:
                rgba(255, 255, 255, 0.60);

            font-size:
                12px;

            line-height:
                1.5;
        }


        /* ================================================================
           RIGHT FORM PANEL
           ================================================================ */

        .login-form-section {
            padding:
                54px
                50px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                rgba(255, 255, 255, 0.95);
        }


        .login-form-wrapper {
            width:
                100%;

            max-width:
                430px;
        }


        .portal-icon {
            width:
                68px;

            height:
                68px;

            margin-bottom:
                21px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius:
                21px;

            background:
                linear-gradient(
                    135deg,
                    #E8F1FD 0%,
                    #D8E8FB 100%
                );

            color:
                var(--primary);

            font-size:
                21px;

            font-weight:
                900;

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

            font-size:
                34px;

            font-weight:
                850;

            line-height:
                1.2;

            letter-spacing:
                -0.4px;
        }


        .form-subheading {
            margin:
                0
                0
                26px;

            color:
                var(--text-body);

            font-size:
                14px;

            line-height:
                1.75;
        }


        /* ================================================================
           SMALL ROLE NOTICE
           ================================================================ */

        .role-notice {
            margin-bottom:
                23px;

            padding:
                13px
                14px;

            display:
                flex;
            align-items:
                flex-start;

            gap:
                11px;

            border:
                1px solid
                #DCE8F6;

            border-radius:
                13px;

            background:
                #F4F8FD;

            color:
                var(--text-body);

            font-size:
                12px;

            line-height:
                1.65;
        }


        .role-notice-icon {
            flex-shrink:
                0;

            width:
                27px;

            height:
                27px;

            display:
                inline-flex;
            align-items:
                center;
            justify-content:
                center;

            border-radius:
                8px;

            background:
                var(--blue-soft);

            color:
                var(--blue);

            font-size:
                12px;

            font-weight:
                850;
        }


        /* ================================================================
           ALERTS
           ================================================================ */

        .alert {
            margin-bottom:
                20px;

            padding:
                14px
                16px;

            border-radius:
                var(--radius-small);

            font-size:
                13px;

            line-height:
                1.65;
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
            margin-bottom:
                20px;
        }


        .form-label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap:
                10px;

            margin-bottom:
                8px;
        }


        .form-label {
            color:
                var(--text-heading);

            font-size:
                13px;

            font-weight:
                750;
        }


        .required-label {
            color:
                var(--text-muted);

            font-size:
                11px;
        }


        .input-wrapper {
            position:
                relative;
        }


        .input-icon {
            position:
                absolute;

            top:
                50%;

            left:
                16px;

            transform:
                translateY(-50%);

            width:
                19px;

            display:
                flex;
            align-items:
                center;
            justify-content:
                center;

            color:
                var(--text-muted);

            pointer-events:
                none;

            font-size:
                14px;
        }


        .form-control {
            width:
                100%;

            height:
                54px;

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

            outline:
                none;

            background:
                #FBFDFF;

            color:
                var(--text-heading);

            font-size:
                14px;

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
            padding-right:
                90px;
        }


        .password-toggle {
            position:
                absolute;

            top:
                50%;

            right:
                10px;

            transform:
                translateY(-50%);

            padding:
                8px
                10px;

            border:
                none;

            border-radius:
                9px;

            background:
                transparent;

            color:
                var(--primary-light);

            cursor:
                pointer;

            font-size:
                12px;

            font-weight:
                750;

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
           SUBMIT BUTTON
           ================================================================ */

        .login-button {
            width:
                100%;

            min-height:
                54px;

            margin-top:
                6px;

            display:
                inline-flex;
            align-items:
                center;
            justify-content:
                center;

            gap:
                10px;

            border:
                none;

            border-radius:
                14px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary) 0%,
                    #2D609D 100%
                );

            color:
                #FFFFFF;

            cursor:
                pointer;

            font-size:
                14px;

            font-weight:
                800;

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


        .button-arrow {
            font-size:
                18px;

            transition:
                transform 0.25s ease;
        }


        .login-button:hover .button-arrow {
            transform:
                translateX(4px);
        }


        /* ================================================================
           REGISTRATION SECTION
           ================================================================ */

        .registration-card {
            margin-top:
                24px;

            padding:
                17px;

            border:
                1px solid
                var(--border-soft);

            border-radius:
                15px;

            background:
                var(--surface-soft);
        }


        .registration-title {
            margin:
                0
                0
                5px;

            color:
                var(--text-heading);

            font-size:
                13px;

            font-weight:
                800;
        }


        .registration-description {
            margin:
                0
                0
                12px;

            color:
                var(--text-muted);

            font-size:
                12px;

            line-height:
                1.6;
        }


        .registration-link {
            display:
                inline-flex;
            align-items:
                center;

            gap:
                6px;

            color:
                var(--blue);

            text-decoration:
                none;

            font-size:
                12px;

            font-weight:
                800;
        }


        .registration-link:hover {
            text-decoration:
                underline;
        }


        /* ================================================================
           SECURITY NOTE
           ================================================================ */

        .security-note {
            margin-top:
                18px;

            display:
                flex;
            align-items:
                flex-start;

            gap:
                10px;

            color:
                var(--text-muted);

            font-size:
                11px;

            line-height:
                1.6;
        }


        .security-note-symbol {
            flex-shrink:
                0;

            width:
                23px;

            height:
                23px;

            display:
                inline-flex;
            align-items:
                center;
            justify-content:
                center;

            border-radius:
                7px;

            background:
                var(--success-soft);

            color:
                var(--success);

            font-weight:
                900;
        }


        /* ================================================================
           ADMIN LINK
           ================================================================ */

        .admin-navigation {
            margin-top:
                22px;

            padding-top:
                20px;

            border-top:
                1px solid
                var(--border-soft);

            text-align:
                center;

            color:
                var(--text-muted);

            font-size:
                12px;
        }


        .admin-navigation a {
            color:
                var(--primary);

            font-weight:
                800;

            text-decoration:
                none;
        }


        .admin-navigation a:hover {
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
            width:
                100%;

            max-width:
                1280px;

            margin:
                0
                auto;

            display:
                flex;
            align-items:
                center;
            justify-content:
                space-between;

            gap:
                16px;

            color:
                var(--text-muted);

            font-size:
                12px;
        }


        .footer-security {
            display:
                flex;
            align-items:
                center;

            gap:
                8px;
        }


        .footer-security-dot {
            width:
                7px;

            height:
                7px;

            border-radius:
                50%;

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
            max-width: 1020px
        ) {

            .login-container {
                grid-template-columns:
                    1fr;

                max-width:
                    740px;
            }


            .portal-information {
                min-height:
                    auto;

                padding:
                    44px
                    40px;
            }


            .portal-title {
                font-size:
                    36px;
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
            max-width: 680px
        ) {

            .top-header {
                padding:
                    18px
                    16px
                    0;
            }


            .header-actions {
                gap:
                    7px;
            }


            .header-link {
                padding:
                    9px
                    11px;

                font-size:
                    11px;
            }


            .brand-caption {
                display:
                    none;
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


            .portal-information {
                padding:
                    32px
                    24px;
            }


            .portal-title {
                font-size:
                    31px;
            }


            .portal-description {
                font-size:
                    14px;
            }


            .role-grid {
                grid-template-columns:
                    1fr;
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
            max-width: 470px
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


            .header-link.admin {
                display:
                    none;
            }


            .portal-title {
                font-size:
                    28px;
            }


            .login-form-section {
                padding:
                    32px
                    20px;
            }


            .portal-icon {
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
     BACKGROUND
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
                    href="{{ route('home') }}"
                    class="header-link"
                >
                    ← Portal Selection
                </a>


                <a
                    href="{{ route('admin.login') }}"
                    class="header-link admin"
                >
                    Administrator
                </a>


            </div>


        </div>


    </header>


    {{-- ==================================================================
         LOGIN AREA
         ================================================================== --}}

    <main class="login-main">


        <section class="login-container">


            {{-- ==========================================================
                 LEFT INFORMATION PANEL
                 ========================================================== --}}

            <div class="portal-information">


                <div class="portal-information-content">


                    <div class="portal-badge">

                        <span class="portal-badge-dot"></span>

                        Student & Supervisor Portal

                    </div>


                    <h1 class="portal-title">

                        One portal for your
                        complete OJT journey.

                    </h1>


                    <p class="portal-description">

                        OJT Sync connects Students and Supervisors
                        through one secure portal for attendance,
                        timesheets, Daily Work Logs, validation,
                        evaluation, and progress monitoring.

                    </p>


                    {{-- ==================================================
                         ROLE EXPLANATIONS
                         ================================================== --}}

                    <div class="role-grid">


                        {{-- ==============================================
                             STUDENT
                             ============================================== --}}

                        <div class="role-card">


                            <div class="role-card-header">


                                <div class="role-icon student">
                                    ST
                                </div>


                                <div class="role-name">
                                    Student
                                </div>


                            </div>


                            <p class="role-description">

                                Manage your OJT records and
                                monitor your official progress.

                            </p>


                            <ul class="role-list">

                                <li>
                                    GPS Selfie Attendance
                                </li>

                                <li>
                                    Automatic Timesheet
                                </li>

                                <li>
                                    Daily Work Logs
                                </li>

                                <li>
                                    Reports & Completion History
                                </li>

                            </ul>


                        </div>


                        {{-- ==============================================
                             SUPERVISOR
                             ============================================== --}}

                        <div class="role-card">


                            <div class="role-card-header">


                                <div class="role-icon supervisor">
                                    SV
                                </div>


                                <div class="role-name">
                                    Supervisor
                                </div>


                            </div>


                            <p class="role-description">

                                Review Student records and
                                verify official OJT activity.

                            </p>


                            <ul class="role-list">

                                <li>
                                    Attendance Validation
                                </li>

                                <li>
                                    Work Log Validation
                                </li>

                                <li>
                                    Final Evaluation
                                </li>

                                <li>
                                    Student Progress Reports
                                </li>

                            </ul>


                        </div>


                    </div>


                </div>


                {{-- ======================================================
                     SECURITY
                     ====================================================== --}}

                <div class="portal-information-footer">


                    <div class="security-symbol">
                        ✓
                    </div>


                    <div class="security-information">

                        <strong>
                            Secure Role-Based Portal
                        </strong>

                        <span>
                            Your account role is verified after login
                            and you are automatically directed to the
                            correct Student or Supervisor dashboard.
                        </span>

                    </div>


                </div>


            </div>


            {{-- ==========================================================
                 LOGIN FORM PANEL
                 ========================================================== --}}

            <div class="login-form-section">


                <div class="login-form-wrapper">


                    <div
                        class="portal-icon"
                        aria-hidden="true"
                    >
                        OJT
                    </div>


                    <h2 class="form-heading">
                        Welcome Back
                    </h2>


                    <p class="form-subheading">

                        Sign in using your Student or Supervisor
                        account to continue to your OJT Sync dashboard.

                    </p>


                    {{-- ==================================================
                         ROLE NOTICE
                         ================================================== --}}

                    <div class="role-notice">


                        <div class="role-notice-icon">
                            i
                        </div>


                        <div>

                            You do not need to choose your role here.
                            OJT Sync automatically recognizes whether
                            your account is a Student or Supervisor.

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
                         FORM
                         ================================================== --}}

                    <form
                        method="POST"
                        action="{{ route('login.store') }}"
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
                                    placeholder="Enter your email address"
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
                             LOGIN
                             ============================================== --}}

                        <button
                            type="submit"
                            class="login-button"
                        >

                            Sign In to OJT Portal

                            <span
                                class="button-arrow"
                                aria-hidden="true"
                            >
                                →
                            </span>

                        </button>


                    </form>


                    {{-- ==================================================
                         STUDENT REGISTRATION
                         ================================================== --}}

                    <div class="registration-card">


                        <h3 class="registration-title">
                            New Student?
                        </h3>


                        <p class="registration-description">

                            Create your Student account to begin
                            setting up your OJT Sync profile.

                        </p>


                        <a
                            href="{{ route('student.register') }}"
                            class="registration-link"
                        >
                            Create Student Account
                            <span aria-hidden="true">
                                →
                            </span>
                        </a>


                    </div>


                    {{-- ==================================================
                         SECURITY NOTICE
                         ================================================== --}}

                    <div class="security-note">


                        <div class="security-note-symbol">
                            ✓
                        </div>


                        <div>

                            Secure authentication and role validation
                            protect Student and Supervisor access.
                            Important authentication activity may be
                            recorded for system accountability.

                        </div>


                    </div>


                    {{-- ==================================================
                         ADMIN PORTAL
                         ================================================== --}}

                    <div class="admin-navigation">

                        Are you an Administrator?

                        <a href="{{ route('admin.login') }}">
                            Open Administrator Login
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

                Student & Supervisor Secure Access

            </div>


        </div>


    </footer>


</div>


{{-- ======================================================================
     PASSWORD TOGGLE
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

                    const isVisible =
                        passwordInput.type
                        === 'text';


                    passwordInput.type =
                        isVisible
                            ? 'password'
                            : 'text';


                    passwordToggle.textContent =
                        isVisible
                            ? 'Show'
                            : 'Hide';


                    passwordToggle.setAttribute(
                        'aria-pressed',
                        isVisible
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