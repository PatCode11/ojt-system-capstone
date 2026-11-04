<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>Welcome | OJT Sync</title>

    <style>
        :root {
            --bg-main: #eef3f9;
            --bg-soft: #f8fbff;
            --bg-card: rgba(255, 255, 255, 0.88);
            --bg-card-solid: #ffffff;

            --primary: #183b6b;
            --primary-dark: #102947;
            --primary-light: #2f5f9a;

            --accent: #3b82f6;
            --accent-soft: #dbeafe;

            --text-dark: #16304f;
            --text-body: #5d7390;
            --text-muted: #8091a7;

            --border: rgba(24, 59, 107, 0.10);
            --shadow-lg: 0 30px 70px rgba(18, 45, 78, 0.10);
            --shadow-md: 0 18px 40px rgba(18, 45, 78, 0.08);
            --shadow-sm: 0 8px 18px rgba(18, 45, 78, 0.06);

            --radius-xl: 28px;
            --radius-lg: 22px;
            --radius-md: 16px;
            --radius-sm: 12px;

            --transition: all 0.28s ease;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.10), transparent 28%),
                radial-gradient(circle at top right, rgba(24, 59, 107, 0.10), transparent 24%),
                linear-gradient(180deg, #f7fbff 0%, #edf3f9 100%);
        }

        body {
            position: relative;
            overflow-x: hidden;
        }

        .bg-shape {
            position: fixed;
            border-radius: 50%;
            filter: blur(20px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.55;
        }

        .bg-shape.one {
            top: -80px;
            left: -70px;
            width: 240px;
            height: 240px;
            background: rgba(59, 130, 246, 0.18);
        }

        .bg-shape.two {
            right: -80px;
            top: 120px;
            width: 260px;
            height: 260px;
            background: rgba(24, 59, 107, 0.12);
        }

        .bg-shape.three {
            left: 18%;
            bottom: -120px;
            width: 300px;
            height: 300px;
            background: rgba(37, 99, 235, 0.10);
        }

        .page-shell {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            width: 100%;
            padding: 24px 32px 0;
        }

        .topbar-inner {
            max-width: 1240px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand-inline {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }

        .brand-mark {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary) 0%, #295ea0 100%);
            color: #ffffff;
            font-weight: 800;
            font-size: 18px;
            letter-spacing: 0.5px;
            box-shadow: var(--shadow-sm);
        }

        .brand-copy {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .brand-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.1;
        }

        .brand-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            letter-spacing: 0.2px;
        }

        .topbar-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(24, 59, 107, 0.08);
            box-shadow: var(--shadow-sm);
            font-size: 13px;
            font-weight: 600;
            color: var(--primary);
            backdrop-filter: blur(12px);
        }

        .topbar-badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 0 6px rgba(34, 197, 94, 0.10);
        }

        .main-content {
            flex: 1;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 36px 24px 50px;
        }

        .hero-panel {
            width: 100%;
            max-width: 1240px;
            border: 1px solid rgba(255, 255, 255, 0.55);
            background: rgba(255, 255, 255, 0.56);
            backdrop-filter: blur(14px);
            box-shadow: var(--shadow-lg);
            border-radius: 34px;
            overflow: hidden;
        }

        .hero-layout {
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            min-height: 720px;
        }

        .hero-left {
            padding: 72px 64px;
            position: relative;
            background:
                radial-gradient(circle at 15% 12%, rgba(59, 130, 246, 0.11), transparent 24%),
                linear-gradient(180deg, rgba(255,255,255,0.94) 0%, rgba(245,249,255,0.96) 100%);
        }

        .hero-right {
            padding: 48px 42px;
            background:
                linear-gradient(180deg, rgba(244, 248, 253, 0.84) 0%, rgba(235, 242, 250, 0.96) 100%);
            border-left: 1px solid rgba(24, 59, 107, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: #edf4ff;
            border: 1px solid #d7e7ff;
            color: var(--primary);
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 22px;
        }

        .hero-pill-icon {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--primary);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
        }

        .hero-title {
            margin: 0 0 18px;
            font-size: 56px;
            line-height: 1.08;
            font-weight: 850;
            color: var(--primary-dark);
            letter-spacing: -1px;
            max-width: 620px;
        }

        .hero-highlight {
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-description {
            margin: 0 0 28px;
            max-width: 620px;
            font-size: 18px;
            line-height: 1.75;
            color: var(--text-body);
        }

        .feature-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 34px;
        }

        .feature-chip {
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.86);
            border: 1px solid rgba(24, 59, 107, 0.10);
            box-shadow: var(--shadow-sm);
            color: var(--primary);
            font-size: 13px;
            font-weight: 700;
        }

        .hero-metrics {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            max-width: 650px;
        }

        .metric-card {
            background: rgba(255, 255, 255, 0.84);
            border: 1px solid rgba(24, 59, 107, 0.10);
            border-radius: 18px;
            padding: 18px 18px 16px;
            box-shadow: var(--shadow-sm);
        }

        .metric-value {
            font-size: 28px;
            font-weight: 850;
            color: var(--primary-dark);
            margin-bottom: 8px;
            line-height: 1;
        }

        .metric-label {
            font-size: 13px;
            color: var(--text-body);
            line-height: 1.55;
        }

        .portal-stack {
            width: 100%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .access-card {
            position: relative;
            background: var(--bg-card-solid);
            border: 1px solid rgba(24, 59, 107, 0.09);
            border-radius: 24px;
            padding: 28px 28px 24px;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            overflow: hidden;
        }

        .access-card::before {
            content: "";
            position: absolute;
            inset: 0 auto auto 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .access-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 26px 50px rgba(18, 45, 78, 0.14);
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .card-icon {
            width: 66px;
            height: 66px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #edf4ff 0%, #dceafd 100%);
            color: var(--primary);
            font-size: 24px;
            font-weight: 850;
            box-shadow: inset 0 0 0 1px rgba(24, 59, 107, 0.08);
        }

        .card-badge {
            padding: 8px 12px;
            border-radius: 999px;
            background: #eff6ff;
            color: var(--accent);
            font-size: 12px;
            font-weight: 800;
            border: 1px solid #d7e8ff;
            white-space: nowrap;
        }

        .card-title {
            margin: 0 0 10px;
            font-size: 33px;
            line-height: 1.15;
            font-weight: 800;
            color: var(--primary-dark);
        }

        .card-description {
            margin: 0 0 18px;
            font-size: 16px;
            line-height: 1.8;
            color: var(--text-body);
        }

        .card-list {
            list-style: none;
            padding: 0;
            margin: 0 0 24px;
            display: grid;
            gap: 12px;
        }

        .card-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            color: var(--text-body);
            font-size: 14px;
            line-height: 1.6;
        }

        .card-list li::before {
            content: "•";
            color: var(--accent);
            font-weight: 900;
            font-size: 18px;
            line-height: 1;
            margin-top: 1px;
        }

        .card-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 15px 18px;
            border-radius: 14px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 800;
            transition: var(--transition);
            border: none;
        }

        .card-action.primary {
            background: linear-gradient(135deg, var(--primary) 0%, #285692 100%);
            color: #ffffff;
            box-shadow: 0 14px 28px rgba(24, 59, 107, 0.22);
        }

        .card-action.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 36px rgba(24, 59, 107, 0.26);
        }

        .card-action.secondary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.20);
        }

        .card-action.secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 36px rgba(37, 99, 235, 0.25);
        }

        .security-note {
            margin-top: 18px;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.74);
            border: 1px dashed rgba(24, 59, 107, 0.12);
            border-radius: 14px;
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .page-footer {
            padding: 0 24px 26px;
        }

        .page-footer-inner {
            max-width: 1240px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            color: var(--text-muted);
            font-size: 13px;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-chip {
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.70);
            border: 1px solid rgba(24, 59, 107, 0.08);
            box-shadow: var(--shadow-sm);
            color: var(--primary);
            font-weight: 700;
        }

        a:focus,
        button:focus {
            outline: 3px solid rgba(59, 130, 246, 0.22);
            outline-offset: 2px;
        }

        @media (max-width: 1180px) {
            .hero-layout {
                grid-template-columns: 1fr;
            }

            .hero-right {
                border-left: none;
                border-top: 1px solid rgba(24, 59, 107, 0.08);
            }

            .hero-left,
            .hero-right {
                padding: 42px 32px;
            }

            .hero-title {
                font-size: 46px;
                max-width: 100%;
            }

            .portal-stack {
                max-width: 100%;
            }
        }

        @media (max-width: 780px) {
            .topbar {
                padding: 18px 18px 0;
            }

            .topbar-inner {
                flex-direction: column;
                align-items: flex-start;
            }

            .main-content {
                padding: 22px 16px 26px;
            }

            .hero-panel {
                border-radius: 24px;
            }

            .hero-left,
            .hero-right {
                padding: 28px 20px;
            }

            .hero-title {
                font-size: 36px;
                line-height: 1.15;
            }

            .hero-description {
                font-size: 16px;
            }

            .hero-metrics {
                grid-template-columns: 1fr;
            }

            .card-title {
                font-size: 28px;
            }

            .page-footer-inner {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 520px) {
            .brand-title {
                font-size: 18px;
            }

            .card-top {
                flex-direction: column;
                align-items: flex-start;
            }

            .card-badge {
                align-self: flex-start;
            }

            .feature-chips {
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-shape one"></div>
    <div class="bg-shape two"></div>
    <div class="bg-shape three"></div>

    <div class="page-shell">
        <header class="topbar">
            <div class="topbar-inner">
                <div class="brand-inline">
                    <div class="brand-mark">OJT</div>

                    <div class="brand-copy">
                        <div class="brand-title">OJT Sync</div>
                        <div class="brand-subtitle">
                            Internship monitoring and digital coordination platform
                        </div>
                    </div>
                </div>

                <div class="topbar-badge">
                    <span class="topbar-badge-dot"></span>
                    Secure Role-Based Access
                </div>
            </div>
        </header>

        <main class="main-content">
            <section class="hero-panel">
                <div class="hero-layout">
                    <div class="hero-left">
                        <div class="hero-pill">
                            <span class="hero-pill-icon">✓</span>
                            Professional OJT Monitoring Platform
                        </div>

                        <h1 class="hero-title">
                            Streamline <span class="hero-highlight">OJT monitoring</span>
                            for administrators, students, and supervisors
                        </h1>

                        <p class="hero-description">
                            OJT Sync is a Web and Mobile Application for
                            OJT Timesheet, GPS Selfie Attendance, and Daily Work Log Monitoring.
                            It helps institutions manage internship coordination through a cleaner,
                            more secure, and more efficient digital workflow.
                        </p>

                        <div class="feature-chips">
                            <div class="feature-chip">GPS Selfie Attendance</div>
                            <div class="feature-chip">Daily Work Logs</div>
                            <div class="feature-chip">Rendered Hours Tracking</div>
                            <div class="feature-chip">Supervisor Validation</div>
                            <div class="feature-chip">System Reports</div>
                        </div>

                        <div class="hero-metrics">
                            <div class="metric-card">
                                <div class="metric-value">3</div>
                                <div class="metric-label">
                                    Core user roles with secure access control
                                </div>
                            </div>

                            <div class="metric-card">
                                <div class="metric-value">24/7</div>
                                <div class="metric-label">
                                    Digital monitoring of internship progress
                                </div>
                            </div>

                            <div class="metric-card">
                                <div class="metric-value">1</div>
                                <div class="metric-label">
                                    Centralized platform for OJT operations
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hero-right">
                        <div class="portal-stack">
                            <div class="access-card">
                                <div class="card-top">
                                    <div class="card-icon">AD</div>
                                    <div class="card-badge">Management Access</div>
                                </div>

                                <h2 class="card-title">Administrator Portal</h2>

                                <p class="card-description">
                                    Access the administrative control center for managing
                                    students, supervisors, companies, assignments,
                                    reports, and audit records.
                                </p>

                                <ul class="card-list">
                                    <li>Student and Supervisor account management</li>
                                    <li>Company and OJT assignment management</li>
                                    <li>Monitoring dashboards, system reports, and audit logs</li>
                                </ul>

                                <a
                                    href="{{ route('admin.login') }}"
                                    class="card-action primary"
                                >
                                    Go to Administrator Login
                                    <span>→</span>
                                </a>
                            </div>

                            <div class="access-card">
                                <div class="card-top">
                                    <div class="card-icon">OJ</div>
                                    <div class="card-badge">Portal Access</div>
                                </div>

                                <h2 class="card-title">OJT Portal</h2>

                                <p class="card-description">
                                    Students and Supervisors can access internship tools for
                                    attendance, timesheets, work logs, validation, and
                                    performance monitoring.
                                </p>

                                <ul class="card-list">
                                    <li>Students can manage attendance, timesheets, and work logs</li>
                                    <li>Supervisors can review, validate, and evaluate records</li>
                                    <li>Simple, guided, and role-based user experience</li>
                                </ul>

                                <a
                                    href="{{ route('login') }}"
                                    class="card-action secondary"
                                >
                                    Go to Student / Supervisor Login
                                    <span>→</span>
                                </a>

                                <div class="security-note">
                                    New student users may register through the portal before accessing
                                    their OJT dashboard, depending on your configured workflow.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="page-footer">
            <div class="page-footer-inner">
                <div>
                    © {{ now()->year }} <strong>OJT Sync</strong> — Professional OJT Monitoring Platform
                </div>

                <div class="footer-links">
                    <div class="footer-chip">Secure Authentication</div>
                    <div class="footer-chip">Role-Based Access</div>
                    <div class="footer-chip">Web & Mobile Ready</div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>