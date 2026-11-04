@extends('layouts.app')

@section('title', 'Administration Dashboard | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       OJT SYNC
       ADMINISTRATION DASHBOARD
       PROFESSIONAL + READABILITY FIRST
       ================================================================ */

    :root {
        --ad-navy: #183B6B;
        --ad-navy-dark: #102A4A;
        --ad-navy-deep: #0B223D;

        --ad-blue: #2563EB;
        --ad-blue-light: #60A5FA;
        --ad-blue-soft: #EAF2FF;

        --ad-teal: #0F766E;
        --ad-teal-dark: #0B5F59;
        --ad-teal-soft: #E7F7F5;

        --ad-green: #15803D;
        --ad-green-soft: #EAF8EF;

        --ad-orange: #B45309;
        --ad-orange-soft: #FFF5E6;

        --ad-red: #B42318;
        --ad-red-soft: #FFF0EE;

        --ad-purple: #6D4FC2;
        --ad-purple-soft: #F2EEFF;

        --ad-cyan: #087C9B;
        --ad-cyan-soft: #E8F8FC;

        --ad-text: #102A4A;
        --ad-body: #405872;
        --ad-muted: #64778C;

        --ad-white: #FFFFFF;
        --ad-soft: #F8FBFE;
        --ad-soft-blue: #F3F8FD;

        --ad-border: #D8E3EE;
        --ad-border-soft: #E7EDF4;

        --ad-shadow:
            0 12px 32px
            rgba(15, 42, 74, 0.07);

        --ad-shadow-medium:
            0 17px 40px
            rgba(15, 42, 74, 0.10);

        --ad-shadow-large:
            0 24px 58px
            rgba(15, 42, 74, 0.14);

        --ad-transition:
            all 0.22s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .admin-dashboard-page {
        width: 100%;

        color:
            var(--ad-text);

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

    .admin-dashboard-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 30px;

        padding:
            45px
            46px;

        border-radius: 30px;

        background:
            radial-gradient(
                circle at 89% 13%,
                rgba(96, 165, 250, 0.27),
                transparent 25%
            ),
            radial-gradient(
                circle at 72% 100%,
                rgba(45, 212, 191, 0.12),
                transparent 31%
            ),
            linear-gradient(
                135deg,
                #0B223D 0%,
                #102A4A 35%,
                #183B6B 68%,
                #28649C 100%
            );

        box-shadow:
            var(--ad-shadow-large);
    }


    .admin-dashboard-hero::before {
        content: "";

        position: absolute;

        width: 420px;
        height: 420px;

        right: -175px;
        top: -245px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.06);
    }


    .admin-dashboard-hero::after {
        content: "";

        position: absolute;

        width: 240px;
        height: 240px;

        right: 285px;
        bottom: -175px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.04);
    }


    .admin-dashboard-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 42px;
    }


    .admin-dashboard-hero-copy {
        max-width: 790px;
    }


    .admin-dashboard-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 13px;

        padding:
            8px
            13px;

        border:
            1px solid
            rgba(255, 255, 255, 0.16);

        border-radius: 999px;

        background:
            rgba(255, 255, 255, 0.08);

        color:
            rgba(255, 255, 255, 0.93);

        font-size: 14px;
        font-weight: 800;
    }


    .admin-dashboard-dot {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background:
            #60A5FA;

        box-shadow:
            0 0 0 5px
            rgba(96, 165, 250, 0.14);
    }


    .admin-dashboard-hero h1 {
        margin:
            0
            0
            12px;

        color:
            #FFFFFF;

        font-size: 40px;
        font-weight: 900;

        line-height: 1.17;

        letter-spacing:
            -0.6px;
    }


    .admin-dashboard-hero-description {
        max-width: 760px;

        margin: 0;

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 17px;

        line-height: 1.72;
    }


    .admin-dashboard-hero-meta {
        display: flex;
        flex-wrap: wrap;

        gap: 9px;

        margin-top: 19px;
    }


    .admin-dashboard-meta-pill {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding:
            8px
            12px;

        border:
            1px solid
            rgba(255, 255, 255, 0.13);

        border-radius: 999px;

        background:
            rgba(255, 255, 255, 0.07);

        color:
            rgba(255, 255, 255, 0.82);

        font-size: 14px;
        font-weight: 700;
    }


    /* ================================================================
       HERO ACTIONS
       ================================================================ */

    .admin-dashboard-hero-actions {
        width: 285px;

        flex-shrink: 0;

        display: grid;

        gap: 11px;
    }


    .admin-dashboard-hero-button {
        min-height: 54px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        padding:
            0
            17px;

        border:
            1px solid
            rgba(255, 255, 255, 0.18);

        border-radius: 13px;

        font-size: 15px;
        font-weight: 850;

        text-decoration: none;

        transition:
            var(--ad-transition);
    }


    .admin-dashboard-hero-button-primary {
        background:
            #FFFFFF;

        color:
            var(--ad-navy);
    }


    .admin-dashboard-hero-button-primary:hover {
        transform:
            translateY(-2px);

        background:
            #F8FBFF;

        box-shadow:
            0 12px 25px
            rgba(0, 0, 0, 0.12);
    }


    .admin-dashboard-hero-button-secondary {
        background:
            rgba(255, 255, 255, 0.09);

        color:
            #FFFFFF;
    }


    .admin-dashboard-hero-button-secondary:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.15);
    }


    .hero-button-code {
        width: 33px;
        height: 33px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        font-size: 12px;
        font-weight: 900;
    }


    .admin-dashboard-hero-button-primary
    .hero-button-code {
        background:
            var(--ad-blue-soft);

        color:
            var(--ad-blue);
    }


    .admin-dashboard-hero-button-secondary
    .hero-button-code {
        background:
            rgba(255, 255, 255, 0.11);

        color:
            #FFFFFF;
    }


    /* ================================================================
       SECTION
       ================================================================ */

    .dashboard-section {
        margin-bottom: 30px;
    }


    .dashboard-section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 17px;
    }


    .dashboard-section-title {
        margin:
            0
            0
            5px;

        color:
            var(--ad-text);

        font-size: 25px;
        font-weight: 900;

        line-height: 1.3;

        letter-spacing:
            -0.2px;
    }


    .dashboard-section-description {
        margin: 0;

        color:
            var(--ad-muted);

        font-size: 15px;

        line-height: 1.6;
    }


    .dashboard-section-link {
        flex-shrink: 0;

        min-height: 43px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            14px;

        border:
            1px solid
            var(--ad-border);

        border-radius: 10px;

        background:
            #FFFFFF;

        color:
            var(--ad-navy);

        font-size: 14px;
        font-weight: 850;

        text-decoration: none;

        transition:
            var(--ad-transition);
    }


    .dashboard-section-link:hover {
        background:
            var(--ad-blue-soft);

        border-color:
            #BDD2EC;

        transform:
            translateY(-1px);
    }


    /* ================================================================
       PRIMARY METRICS
       ================================================================ */

    .dashboard-primary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 18px;

        margin-bottom: 18px;
    }


    .dashboard-primary-card {
        position: relative;

        overflow: hidden;

        min-height: 186px;

        padding:
            23px;

        border:
            1px solid
            var(--ad-border);

        border-radius: 20px;

        background:
            #FFFFFF;

        box-shadow:
            var(--ad-shadow);

        transition:
            var(--ad-transition);
    }


    .dashboard-primary-card:hover {
        transform:
            translateY(-3px);

        border-color:
            #BCD0E4;

        box-shadow:
            var(--ad-shadow-medium);
    }


    .dashboard-primary-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 14px;

        margin-bottom: 18px;
    }


    .dashboard-metric-icon {
        width: 52px;
        height: 52px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 15px;

        font-size: 14px;
        font-weight: 900;
    }


    .metric-blue {
        background:
            var(--ad-blue-soft);

        color:
            var(--ad-blue);
    }


    .metric-teal {
        background:
            var(--ad-teal-soft);

        color:
            var(--ad-teal);
    }


    .metric-purple {
        background:
            var(--ad-purple-soft);

        color:
            var(--ad-purple);
    }


    .metric-green {
        background:
            var(--ad-green-soft);

        color:
            var(--ad-green);
    }


    .metric-orange {
        background:
            var(--ad-orange-soft);

        color:
            var(--ad-orange);
    }


    .metric-red {
        background:
            var(--ad-red-soft);

        color:
            var(--ad-red);
    }


    .metric-cyan {
        background:
            var(--ad-cyan-soft);

        color:
            var(--ad-cyan);
    }


    .dashboard-metric-tag {
        padding:
            7px
            10px;

        border-radius: 999px;

        background:
            var(--ad-soft);

        color:
            var(--ad-muted);

        font-size: 12px;
        font-weight: 850;
    }


    .dashboard-primary-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--ad-body);

        font-size: 15px;
        font-weight: 800;
    }


    .dashboard-primary-value {
        display: block;

        color:
            var(--ad-text);

        font-size: 36px;
        font-weight: 900;

        line-height: 1.08;

        letter-spacing:
            -0.5px;
    }


    .dashboard-primary-note {
        display: block;

        margin-top: 9px;

        color:
            var(--ad-muted);

        font-size: 14px;

        line-height: 1.5;
    }


    .dashboard-primary-note strong {
        color:
            var(--ad-text);

        font-weight: 900;
    }


    /* ================================================================
       MONITORING METRICS
       ================================================================ */

    .dashboard-monitor-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 18px;
    }


    .dashboard-monitor-card {
        display: flex;
        align-items: center;

        gap: 15px;

        padding:
            19px;

        border:
            1px solid
            var(--ad-border);

        border-radius: 17px;

        background:
            #FFFFFF;

        box-shadow:
            var(--ad-shadow);

        transition:
            var(--ad-transition);
    }


    .dashboard-monitor-card:hover {
        transform:
            translateY(-2px);

        box-shadow:
            var(--ad-shadow-medium);
    }


    .dashboard-monitor-icon {
        width: 48px;
        height: 48px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        font-size: 13px;
        font-weight: 900;
    }


    .dashboard-monitor-copy {
        min-width: 0;

        flex: 1;
    }


    .dashboard-monitor-label {
        display: block;

        color:
            var(--ad-muted);

        font-size: 13px;
        font-weight: 800;
    }


    .dashboard-monitor-value {
        display: block;

        margin-top: 1px;

        color:
            var(--ad-text);

        font-size: 26px;
        font-weight: 900;

        line-height: 1.2;
    }


    .dashboard-monitor-note {
        display: block;

        margin-top: 3px;

        color:
            var(--ad-muted);

        font-size: 13px;
    }


    /* ================================================================
       OPERATIONS SUMMARY
       ================================================================ */

    .dashboard-operations {
        display: grid;

        grid-template-columns:
            minmax(0, 1.25fr)
            minmax(320px, .75fr);

        gap: 22px;

        margin-bottom: 30px;
    }


    .operations-main {
        overflow: hidden;

        border:
            1px solid
            var(--ad-border);

        border-radius: 20px;

        background:
            #FFFFFF;

        box-shadow:
            var(--ad-shadow);
    }


    .operations-main-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        padding:
            22px
            23px;

        border-bottom:
            1px solid
            var(--ad-border-soft);
    }


    .operations-heading {
        display: flex;
        align-items: center;

        gap: 13px;
    }


    .operations-heading-icon {
        width: 48px;
        height: 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 14px;

        background:
            var(--ad-blue-soft);

        color:
            var(--ad-blue);

        font-size: 13px;
        font-weight: 900;
    }


    .operations-main-header h3 {
        margin:
            0
            0
            3px;

        font-size: 21px;
        font-weight: 900;
    }


    .operations-main-header p {
        margin: 0;

        color:
            var(--ad-muted);

        font-size: 14px;
    }


    .operations-body {
        padding: 22px;
    }


    .operations-queue-grid {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 13px;
    }


    .operations-queue-item {
        padding:
            17px;

        border:
            1px solid
            var(--ad-border-soft);

        border-radius: 13px;

        background:
            var(--ad-soft);
    }


    .operations-queue-label {
        display: block;

        margin-bottom: 5px;

        color:
            var(--ad-muted);

        font-size: 13px;
        font-weight: 800;
    }


    .operations-queue-value {
        display: block;

        color:
            var(--ad-text);

        font-size: 27px;
        font-weight: 900;
    }


    .operations-queue-note {
        display: block;

        margin-top: 3px;

        color:
            var(--ad-muted);

        font-size: 13px;
    }


    /* ================================================================
       STATUS CARD
       ================================================================ */

    .dashboard-health-card {
        padding:
            23px;

        border:
            1px solid
            var(--ad-border);

        border-radius: 20px;

        background:
            linear-gradient(
                145deg,
                #FFFFFF 0%,
                #F7FBFE 100%
            );

        box-shadow:
            var(--ad-shadow);
    }


    .dashboard-health-label {
        display: block;

        margin-bottom: 10px;

        color:
            var(--ad-muted);

        font-size: 14px;
        font-weight: 800;
    }


    .dashboard-health-status {
        display: flex;
        align-items: center;

        gap: 10px;

        margin-bottom: 14px;
    }


    .dashboard-health-dot {
        width: 13px;
        height: 13px;

        border-radius: 50%;
    }


    .health-good {
        background:
            #22C55E;

        box-shadow:
            0 0 0 6px
            rgba(34, 197, 94, .11);
    }


    .health-attention {
        background:
            #F59E0B;

        box-shadow:
            0 0 0 6px
            rgba(245, 158, 11, .11);
    }


    .dashboard-health-status strong {
        font-size: 23px;
        font-weight: 900;
    }


    .dashboard-health-description {
        margin:
            0
            0
            17px;

        color:
            var(--ad-body);

        font-size: 15px;

        line-height: 1.65;
    }


    .dashboard-health-meta {
        display: grid;

        gap: 9px;
    }


    .dashboard-health-meta-item {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        padding:
            11px
            12px;

        border:
            1px solid
            var(--ad-border-soft);

        border-radius: 10px;

        background:
            #FFFFFF;
    }


    .dashboard-health-meta-label {
        color:
            var(--ad-muted);

        font-size: 14px;
        font-weight: 700;
    }


    .dashboard-health-meta-value {
        color:
            var(--ad-text);

        font-size: 15px;
        font-weight: 900;
    }


    .dashboard-health-meta-value.danger {
        color:
            var(--ad-red);
    }


    /* ================================================================
       MANAGEMENT CENTER
       ================================================================ */

    .dashboard-management-grid {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 18px;
    }


    .dashboard-management-card {
        position: relative;

        overflow: hidden;

        min-height: 265px;

        display: flex;
        flex-direction: column;

        padding:
            23px;

        border:
            1px solid
            var(--ad-border);

        border-radius: 19px;

        background:
            #FFFFFF;

        box-shadow:
            var(--ad-shadow);

        transition:
            var(--ad-transition);
    }


    .dashboard-management-card:hover {
        transform:
            translateY(-4px);

        border-color:
            #BCD0E4;

        box-shadow:
            var(--ad-shadow-medium);
    }


    .dashboard-management-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-bottom: 18px;
    }


    .dashboard-management-icon {
        width: 52px;
        height: 52px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 15px;

        font-size: 14px;
        font-weight: 900;
    }


    .dashboard-management-number {
        color:
            #A0ADBB;

        font-size: 14px;
        font-weight: 900;

        letter-spacing:
            .5px;
    }


    .dashboard-management-card h3 {
        margin:
            0
            0
            8px;

        color:
            var(--ad-text);

        font-size: 20px;
        font-weight: 900;

        line-height: 1.35;
    }


    .dashboard-management-card p {
        margin:
            0
            0
            20px;

        color:
            var(--ad-body);

        font-size: 15px;

        line-height: 1.65;
    }


    .dashboard-management-action {
        min-height: 45px;

        margin-top: auto;

        display: inline-flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        padding:
            0
            14px;

        border:
            1px solid
            var(--ad-border);

        border-radius: 10px;

        background:
            var(--ad-soft);

        color:
            var(--ad-navy);

        font-size: 14px;
        font-weight: 900;

        text-decoration: none;

        transition:
            var(--ad-transition);
    }


    .dashboard-management-action:hover {
        border-color:
            #BDD2EC;

        background:
            var(--ad-blue-soft);
    }


    /* ================================================================
       SECURITY GRID
       ================================================================ */

    .dashboard-security-grid {
        display: grid;

        grid-template-columns:
            minmax(0, 1.55fr)
            minmax(315px, .65fr);

        gap: 22px;
    }


    .dashboard-security-panel {
        overflow: hidden;

        border:
            1px solid
            var(--ad-border);

        border-radius: 20px;

        background:
            #FFFFFF;

        box-shadow:
            var(--ad-shadow);
    }


    .dashboard-security-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 17px;

        padding:
            21px
            22px;

        border-bottom:
            1px solid
            var(--ad-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .dashboard-security-panel-heading {
        display: flex;
        align-items: center;

        gap: 12px;
    }


    .security-panel-icon {
        width: 45px;
        height: 45px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--ad-red-soft);

        color:
            var(--ad-red);

        font-size: 12px;
        font-weight: 900;
    }


    .security-panel-icon.safe {
        background:
            var(--ad-green-soft);

        color:
            var(--ad-green);
    }


    .dashboard-security-panel-header h3 {
        margin:
            0
            0
            3px;

        color:
            var(--ad-text);

        font-size: 20px;
        font-weight: 900;
    }


    .dashboard-security-panel-header p {
        margin: 0;

        color:
            var(--ad-muted);

        font-size: 14px;
    }


    /* ================================================================
       SECURITY TABLE
       ================================================================ */

    .dashboard-security-table-wrap {
        overflow-x: auto;
    }


    .dashboard-security-table {
        width: 100%;

        min-width: 800px;

        border-collapse:
            collapse;
    }


    .dashboard-security-table th {
        padding:
            13px
            15px;

        border-bottom:
            1px solid
            var(--ad-border);

        background:
            #F8FBFE;

        color:
            var(--ad-muted);

        font-size: 12px;
        font-weight: 850;

        text-align: left;

        text-transform:
            uppercase;

        letter-spacing:
            .25px;
    }


    .dashboard-security-table td {
        padding:
            15px;

        border-bottom:
            1px solid
            var(--ad-border-soft);

        color:
            var(--ad-body);

        font-size: 14px;

        vertical-align:
            top;
    }


    .dashboard-security-table tbody tr:last-child td {
        border-bottom:
            none;
    }


    .dashboard-security-date {
        min-width: 160px;

        color:
            var(--ad-muted);

        font-size: 13px;
        font-weight: 700;
    }


    .dashboard-security-actor {
        color:
            var(--ad-text);

        font-weight: 850;
    }


    .dashboard-event-code {
        display: inline-flex;

        max-width: 210px;

        padding:
            6px
            9px;

        border-radius: 8px;

        background:
            var(--ad-blue-soft);

        color:
            var(--ad-blue);

        font-size: 12px;
        font-weight: 850;

        line-height: 1.4;

        word-break:
            break-word;
    }


    .dashboard-event-code.danger {
        background:
            var(--ad-red-soft);

        color:
            var(--ad-red);
    }


    .dashboard-event-code.warning {
        background:
            var(--ad-orange-soft);

        color:
            var(--ad-orange);
    }


    .dashboard-event-code.success {
        background:
            var(--ad-green-soft);

        color:
            var(--ad-green);
    }


    /* ================================================================
       EMPTY SECURITY
       ================================================================ */

    .dashboard-security-empty {
        padding:
            45px
            25px;

        text-align: center;
    }


    .dashboard-security-empty-icon {
        width: 62px;
        height: 62px;

        margin:
            0
            auto
            14px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 18px;

        background:
            var(--ad-green-soft);

        color:
            var(--ad-green);

        font-size: 22px;
        font-weight: 900;
    }


    .dashboard-security-empty strong {
        display: block;

        margin-bottom: 5px;

        color:
            var(--ad-text);

        font-size: 18px;
        font-weight: 900;
    }


    .dashboard-security-empty span {
        color:
            var(--ad-muted);

        font-size: 14px;
    }


    /* ================================================================
       SECURITY OVERVIEW
       ================================================================ */

    .dashboard-security-overview {
        padding:
            21px;
    }


    .dashboard-monitoring-status {
        margin-bottom: 17px;

        padding:
            18px;

        border:
            1px solid
            #CAE2D1;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #F8FCF9,
                #EFF9F2
            );
    }


    .dashboard-monitoring-status-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-bottom: 9px;
    }


    .dashboard-monitoring-icon {
        width: 45px;
        height: 45px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--ad-green-soft);

        color:
            var(--ad-green);

        font-size: 18px;
        font-weight: 900;
    }


    .dashboard-monitoring-label {
        color:
            var(--ad-muted);

        font-size: 13px;
        font-weight: 750;

        text-align: right;
    }


    .dashboard-monitoring-value {
        color:
            var(--ad-green);

        font-size: 20px;
        font-weight: 900;

        text-align: right;
    }


    .dashboard-monitoring-status p {
        margin: 0;

        color:
            var(--ad-body);

        font-size: 14px;

        line-height: 1.6;
    }


    .dashboard-security-list {
        display: grid;

        gap: 9px;
    }


    .dashboard-security-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        padding:
            13px
            14px;

        border:
            1px solid
            var(--ad-border-soft);

        border-radius: 11px;

        background:
            var(--ad-soft);
    }


    .dashboard-security-list-label {
        color:
            var(--ad-body);

        font-size: 14px;
        font-weight: 750;
    }


    .dashboard-security-list-value {
        color:
            var(--ad-text);

        font-size: 18px;
        font-weight: 900;
    }


    .dashboard-security-list-value.danger {
        color:
            var(--ad-red);
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1200px) {

        .dashboard-primary-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .dashboard-monitor-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .dashboard-management-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }


        .dashboard-security-grid {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 980px) {

        .admin-dashboard-hero-inner {
            flex-direction:
                column;

            align-items:
                flex-start;
        }


        .admin-dashboard-hero-actions {
            width:
                100%;
        }


        .dashboard-operations {
            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 760px) {

        .operations-queue-grid {
            grid-template-columns:
                1fr;
        }


        .dashboard-section-header {
            flex-direction:
                column;

            align-items:
                flex-start;
        }

    }


    @media (max-width: 650px) {

        .admin-dashboard-hero {
            padding:
                30px
                22px;

            border-radius:
                22px;
        }


        .admin-dashboard-hero h1 {
            font-size:
                31px;
        }


        .admin-dashboard-hero-description {
            font-size:
                16px;
        }


        .dashboard-primary-grid,
        .dashboard-monitor-grid,
        .dashboard-management-grid {
            grid-template-columns:
                1fr;
        }


        .dashboard-primary-value {
            font-size:
                33px;
        }


        .dashboard-section-title {
            font-size:
                22px;
        }

    }

</style>

@endpush


@section('content')


@php

    /*
    |--------------------------------------------------------------------------
    | Dashboard Derived Values
    |--------------------------------------------------------------------------
    |
    | These values use the existing statistics already supplied by the
    | Admin Dashboard controller. No additional database query is needed.
    |
    */

    $pendingReviewQueue =
        (int) $pendingAttendance
        +
        (int) $pendingWorkLogs;


    $securityNeedsAttention =
        (int) $failedLoginsLast24Hours > 0;


    $adminName =
        auth()->user()?->name
        ?? 'Administrator';

@endphp


<div class="admin-dashboard-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="admin-dashboard-hero">


        <div class="admin-dashboard-hero-inner">


            <div class="admin-dashboard-hero-copy">


                <div class="admin-dashboard-eyebrow">

                    <span class="admin-dashboard-dot"></span>

                    Administrator · OJT Sync Control Center

                </div>


                <h1>
                    Administration Dashboard
                </h1>


                <p class="admin-dashboard-hero-description">

                    Monitor Student and Supervisor accounts,
                    participating companies, active OJT placements,
                    validation queues, reports, and important
                    security activity from one centralized workspace.

                </p>


                <div class="admin-dashboard-hero-meta">


                    <span class="admin-dashboard-meta-pill">

                        Signed in as
                        <strong>{{ $adminName }}</strong>

                    </span>


                    <span class="admin-dashboard-meta-pill">

                        Asia / Manila

                    </span>


                    <span class="admin-dashboard-meta-pill">

                        {{ now()
                            ->timezone('Asia/Manila')
                            ->format('M d, Y')
                        }}

                    </span>


                </div>


            </div>


            <div class="admin-dashboard-hero-actions">


                <a
                    href="{{ route(
                        'admin.reports.index'
                    ) }}"
                    class="
                        admin-dashboard-hero-button
                        admin-dashboard-hero-button-primary
                    "
                >

                    <span>
                        Open System Reports
                    </span>

                    <span class="hero-button-code">
                        RP
                    </span>

                </a>


                <a
                    href="{{ route(
                        'admin.audit-logs.index'
                    ) }}"
                    class="
                        admin-dashboard-hero-button
                        admin-dashboard-hero-button-secondary
                    "
                >

                    <span>
                        Review Audit Logs
                    </span>

                    <span class="hero-button-code">
                        AU
                    </span>

                </a>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         SYSTEM OVERVIEW
         ================================================================== --}}

    <section class="dashboard-section">


        <div class="dashboard-section-header">


            <div>


                <h2 class="dashboard-section-title">
                    System Overview
                </h2>


                <p class="dashboard-section-description">

                    Current account, company, placement,
                    monitoring, and security statistics.

                </p>


            </div>


            <a
                href="{{ route(
                    'admin.reports.index'
                ) }}"
                class="dashboard-section-link"
            >
                View Detailed Reports →
            </a>


        </div>


        {{-- ==============================================================
             PRIMARY COUNTS
             ============================================================== --}}

        <div class="dashboard-primary-grid">


            <article class="dashboard-primary-card">


                <div class="dashboard-primary-top">

                    <div class="dashboard-metric-icon metric-blue">
                        ST
                    </div>

                    <span class="dashboard-metric-tag">
                        Accounts
                    </span>

                </div>


                <span class="dashboard-primary-label">
                    Registered Students
                </span>


                <span class="dashboard-primary-value">
                    {{ $studentCount }}
                </span>


                <span class="dashboard-primary-note">

                    <strong>
                        {{ $activeStudentCount }}
                    </strong>

                    active Student
                    account{{ $activeStudentCount == 1 ? '' : 's' }}

                </span>


            </article>


            <article class="dashboard-primary-card">


                <div class="dashboard-primary-top">

                    <div class="dashboard-metric-icon metric-teal">
                        SV
                    </div>

                    <span class="dashboard-metric-tag">
                        Accounts
                    </span>

                </div>


                <span class="dashboard-primary-label">
                    Registered Supervisors
                </span>


                <span class="dashboard-primary-value">
                    {{ $supervisorCount }}
                </span>


                <span class="dashboard-primary-note">

                    <strong>
                        {{ $activeSupervisorCount }}
                    </strong>

                    active Supervisor
                    account{{ $activeSupervisorCount == 1 ? '' : 's' }}

                </span>


            </article>


            <article class="dashboard-primary-card">


                <div class="dashboard-primary-top">

                    <div class="dashboard-metric-icon metric-purple">
                        CO
                    </div>

                    <span class="dashboard-metric-tag">
                        Partners
                    </span>

                </div>


                <span class="dashboard-primary-label">
                    Partner Companies
                </span>


                <span class="dashboard-primary-value">
                    {{ $companyCount }}
                </span>


                <span class="dashboard-primary-note">

                    Registered OJT training
                    establishment{{ $companyCount == 1 ? '' : 's' }}

                </span>


            </article>


            <article class="dashboard-primary-card">


                <div class="dashboard-primary-top">

                    <div class="dashboard-metric-icon metric-green">
                        OJ
                    </div>

                    <span class="dashboard-metric-tag">
                        Ongoing
                    </span>

                </div>


                <span class="dashboard-primary-label">
                    Active OJT Assignments
                </span>


                <span class="dashboard-primary-value">
                    {{ $activeAssignments }}
                </span>


                <span class="dashboard-primary-note">

                    OJT placement{{ $activeAssignments == 1 ? '' : 's' }}
                    currently in progress

                </span>


            </article>


        </div>


        {{-- ==============================================================
             MONITORING COUNTS
             ============================================================== --}}

        <div class="dashboard-monitor-grid">


            <article class="dashboard-monitor-card">


                <div class="dashboard-monitor-icon metric-orange">
                    AT
                </div>


                <div class="dashboard-monitor-copy">

                    <span class="dashboard-monitor-label">
                        Pending Attendance
                    </span>

                    <span class="dashboard-monitor-value">
                        {{ $pendingAttendance }}
                    </span>

                    <span class="dashboard-monitor-note">
                        Awaiting Supervisor validation
                    </span>

                </div>


            </article>


            <article class="dashboard-monitor-card">


                <div class="dashboard-monitor-icon metric-cyan">
                    WL
                </div>


                <div class="dashboard-monitor-copy">

                    <span class="dashboard-monitor-label">
                        Pending Work Logs
                    </span>

                    <span class="dashboard-monitor-value">
                        {{ $pendingWorkLogs }}
                    </span>

                    <span class="dashboard-monitor-note">
                        Awaiting Supervisor review
                    </span>

                </div>


            </article>


            <article class="dashboard-monitor-card">


                <div class="dashboard-monitor-icon metric-blue">
                    AU
                </div>


                <div class="dashboard-monitor-copy">

                    <span class="dashboard-monitor-label">
                        Audit Events · 24h
                    </span>

                    <span class="dashboard-monitor-value">
                        {{ $auditEventsLast24Hours }}
                    </span>

                    <span class="dashboard-monitor-note">
                        Recorded system activities
                    </span>

                </div>


            </article>


            <article class="dashboard-monitor-card">


                <div
                    class="
                        dashboard-monitor-icon
                        {{ $securityNeedsAttention
                            ? 'metric-red'
                            : 'metric-green'
                        }}
                    "
                >
                    SE
                </div>


                <div class="dashboard-monitor-copy">

                    <span class="dashboard-monitor-label">
                        Failed Logins · 24h
                    </span>

                    <span class="dashboard-monitor-value">
                        {{ $failedLoginsLast24Hours }}
                    </span>

                    <span class="dashboard-monitor-note">

                        {{ $securityNeedsAttention
                            ? 'Review authentication activity'
                            : 'No failed login activity'
                        }}

                    </span>

                </div>


            </article>


        </div>


    </section>


    {{-- ==================================================================
         OPERATIONS SUMMARY
         ================================================================== --}}

    <section class="dashboard-operations">


        <article class="operations-main">


            <div class="operations-main-header">


                <div class="operations-heading">


                    <div class="operations-heading-icon">
                        OP
                    </div>


                    <div>


                        <h3>
                            Operational Review Queue
                        </h3>


                        <p>

                            Items currently waiting for
                            Supervisor validation or review.

                        </p>


                    </div>


                </div>


            </div>


            <div class="operations-body">


                <div class="operations-queue-grid">


                    <div class="operations-queue-item">


                        <span class="operations-queue-label">
                            Total Pending Reviews
                        </span>


                        <span class="operations-queue-value">
                            {{ $pendingReviewQueue }}
                        </span>


                        <span class="operations-queue-note">
                            Attendance + Work Logs
                        </span>


                    </div>


                    <div class="operations-queue-item">


                        <span class="operations-queue-label">
                            Attendance Validation
                        </span>


                        <span class="operations-queue-value">
                            {{ $pendingAttendance }}
                        </span>


                        <span class="operations-queue-note">
                            Waiting for Supervisor
                        </span>


                    </div>


                    <div class="operations-queue-item">


                        <span class="operations-queue-label">
                            Work Log Review
                        </span>


                        <span class="operations-queue-value">
                            {{ $pendingWorkLogs }}
                        </span>


                        <span class="operations-queue-note">
                            Waiting for Supervisor
                        </span>


                    </div>


                </div>


            </div>


        </article>


        <aside class="dashboard-health-card">


            <span class="dashboard-health-label">
                System Monitoring
            </span>


            <div class="dashboard-health-status">


                <span
                    class="
                        dashboard-health-dot
                        {{ $securityNeedsAttention
                            ? 'health-attention'
                            : 'health-good'
                        }}
                    "
                ></span>


                <strong>

                    {{ $securityNeedsAttention
                        ? 'Review Recommended'
                        : 'Monitoring Active'
                    }}

                </strong>


            </div>


            <p class="dashboard-health-description">

                OJT Sync is recording important
                administrative and authentication activity
                through the Audit Log system.

            </p>


            <div class="dashboard-health-meta">


                <div class="dashboard-health-meta-item">

                    <span class="dashboard-health-meta-label">
                        Audit Events · 24h
                    </span>

                    <span class="dashboard-health-meta-value">
                        {{ $auditEventsLast24Hours }}
                    </span>

                </div>


                <div class="dashboard-health-meta-item">

                    <span class="dashboard-health-meta-label">
                        Failed Logins · 24h
                    </span>

                    <span
                        class="
                            dashboard-health-meta-value
                            {{ $securityNeedsAttention
                                ? 'danger'
                                : ''
                            }}
                        "
                    >
                        {{ $failedLoginsLast24Hours }}
                    </span>

                </div>


                <div class="dashboard-health-meta-item">

                    <span class="dashboard-health-meta-label">
                        Open Review Queue
                    </span>

                    <span class="dashboard-health-meta-value">
                        {{ $pendingReviewQueue }}
                    </span>

                </div>


            </div>


        </aside>


    </section>


    {{-- ==================================================================
         MANAGEMENT CENTER
         ================================================================== --}}

    <section class="dashboard-section">


        <div class="dashboard-section-header">


            <div>


                <h2 class="dashboard-section-title">
                    Management Center
                </h2>


                <p class="dashboard-section-description">

                    Quick access to the main
                    Administration modules of OJT Sync.

                </p>


            </div>


        </div>


        <div class="dashboard-management-grid">


            {{-- STUDENTS --}}

            <article class="dashboard-management-card">


                <div class="dashboard-management-card-top">

                    <div class="dashboard-management-icon metric-blue">
                        ST
                    </div>

                    <span class="dashboard-management-number">
                        01
                    </span>

                </div>


                <h3>
                    Student Management
                </h3>


                <p>

                    Create and manage Student accounts,
                    review profile information, control
                    account access, and inspect OJT history.

                </p>


                <a
                    href="{{ route(
                        'admin.students.index'
                    ) }}"
                    class="dashboard-management-action"
                >

                    <span>
                        Manage Students
                    </span>

                    <span>→</span>

                </a>


            </article>


            {{-- SUPERVISORS --}}

            <article class="dashboard-management-card">


                <div class="dashboard-management-card-top">

                    <div class="dashboard-management-icon metric-teal">
                        SV
                    </div>

                    <span class="dashboard-management-number">
                        02
                    </span>

                </div>


                <h3>
                    Supervisor Management
                </h3>


                <p>

                    Manage Supervisor accounts and
                    review personnel responsible for
                    Student monitoring and validation.

                </p>


                <a
                    href="{{ route(
                        'admin.supervisors.index'
                    ) }}"
                    class="dashboard-management-action"
                >

                    <span>
                        Manage Supervisors
                    </span>

                    <span>→</span>

                </a>


            </article>


            {{-- COMPANIES --}}

            <article class="dashboard-management-card">


                <div class="dashboard-management-card-top">

                    <div class="dashboard-management-icon metric-purple">
                        CO
                    </div>

                    <span class="dashboard-management-number">
                        03
                    </span>

                </div>


                <h3>
                    Company Directory
                </h3>


                <p>

                    Maintain participating OJT companies,
                    establishment information, contacts,
                    and partner organization records.

                </p>


                <a
                    href="{{ route(
                        'admin.companies.index'
                    ) }}"
                    class="dashboard-management-action"
                >

                    <span>
                        Manage Companies
                    </span>

                    <span>→</span>

                </a>


            </article>


            {{-- ASSIGNMENTS --}}

            <article class="dashboard-management-card">


                <div class="dashboard-management-card-top">

                    <div class="dashboard-management-icon metric-green">
                        OJ
                    </div>

                    <span class="dashboard-management-number">
                        04
                    </span>

                </div>


                <h3>
                    OJT Assignments
                </h3>


                <p>

                    Connect Students with companies and
                    Supervisors, configure required hours,
                    and monitor placement status.

                </p>


                <a
                    href="{{ route(
                        'admin.assignments.index'
                    ) }}"
                    class="dashboard-management-action"
                >

                    <span>
                        Manage Assignments
                    </span>

                    <span>→</span>

                </a>


            </article>


            {{-- REPORTS --}}

            <article class="dashboard-management-card">


                <div class="dashboard-management-card-top">

                    <div class="dashboard-management-icon metric-cyan">
                        RP
                    </div>

                    <span class="dashboard-management-number">
                        05
                    </span>

                </div>


                <h3>
                    Reports & Export Center
                </h3>


                <p>

                    Review OJT monitoring information,
                    validated hours and evaluations,
                    then prepare printable and CSV reports.

                </p>


                <a
                    href="{{ route(
                        'admin.reports.index'
                    ) }}"
                    class="dashboard-management-action"
                >

                    <span>
                        Open Reports
                    </span>

                    <span>→</span>

                </a>


            </article>


            {{-- AUDIT LOGS --}}

            <article class="dashboard-management-card">


                <div class="dashboard-management-card-top">

                    <div class="dashboard-management-icon metric-orange">
                        AU
                    </div>

                    <span class="dashboard-management-number">
                        06
                    </span>

                </div>


                <h3>
                    Audit & Security Logs
                </h3>


                <p>

                    Review authentication attempts,
                    administrative changes, validation
                    events, and important system activity.

                </p>


                <a
                    href="{{ route(
                        'admin.audit-logs.index'
                    ) }}"
                    class="dashboard-management-action"
                >

                    <span>
                        View Audit Logs
                    </span>

                    <span>→</span>

                </a>


            </article>


        </div>


    </section>


    {{-- ==================================================================
         SECURITY MONITORING
         ================================================================== --}}

    <section class="dashboard-section">


        <div class="dashboard-section-header">


            <div>


                <h2 class="dashboard-section-title">
                    Security Monitoring
                </h2>


                <p class="dashboard-section-description">

                    Recent security-sensitive events,
                    authentication activity, and system monitoring.

                </p>


            </div>


            <a
                href="{{ route(
                    'admin.audit-logs.index'
                ) }}"
                class="dashboard-section-link"
            >
                Open Audit Center →
            </a>


        </div>


        <div class="dashboard-security-grid">


            {{-- ==========================================================
                 RECENT EVENTS
                 ========================================================== --}}

            <section class="dashboard-security-panel">


                <div class="dashboard-security-panel-header">


                    <div class="dashboard-security-panel-heading">


                        <div class="security-panel-icon">
                            SE
                        </div>


                        <div>


                            <h3>
                                Recent Security Events
                            </h3>


                            <p>
                                Latest important system activity
                            </p>


                        </div>


                    </div>


                </div>


                @if ($recentSecurityEvents->count() > 0)


                    <div class="dashboard-security-table-wrap">


                        <table class="dashboard-security-table">


                            <thead>

                                <tr>

                                    <th>
                                        Date & Time
                                    </th>

                                    <th>
                                        Actor
                                    </th>

                                    <th>
                                        Event
                                    </th>

                                    <th>
                                        Description
                                    </th>

                                </tr>

                            </thead>


                            <tbody>


                                @foreach ($recentSecurityEvents as $event)


                                    @php

                                        $eventAction =
                                            (string)
                                            $event->action;


                                        $eventClass =
                                            match (true) {

                                                str_contains(
                                                    $eventAction,
                                                    'failed'
                                                ) =>
                                                    'danger',

                                                str_contains(
                                                    $eventAction,
                                                    'cancelled'
                                                ) =>
                                                    'warning',

                                                str_contains(
                                                    $eventAction,
                                                    'completed'
                                                ) =>
                                                    'success',

                                                default =>
                                                    '',

                                            };

                                    @endphp


                                    <tr>


                                        <td class="dashboard-security-date">

                                            {{ $event
                                                ->created_at
                                                ?->timezone(
                                                    'Asia/Manila'
                                                )
                                                ->format(
                                                    'M d, Y h:i A'
                                                )
                                                ?? 'Not available'
                                            }}

                                        </td>


                                        <td>

                                            <span class="dashboard-security-actor">

                                                {{ $event->actor
                                                    ? $event->actor->name
                                                    : 'Guest / System'
                                                }}

                                            </span>

                                        </td>


                                        <td>

                                            <span
                                                class="
                                                    dashboard-event-code
                                                    {{ $eventClass }}
                                                "
                                            >

                                                {{ $event->action }}

                                            </span>

                                        </td>


                                        <td>

                                            {{ $event->description }}

                                        </td>


                                    </tr>


                                @endforeach


                            </tbody>


                        </table>


                    </div>


                @else


                    <div class="dashboard-security-empty">


                        <div class="dashboard-security-empty-icon">
                            ✓
                        </div>


                        <strong>
                            No Recent Security Events
                        </strong>


                        <span>

                            Important security activity
                            will appear here automatically.

                        </span>


                    </div>


                @endif


            </section>


            {{-- ==========================================================
                 SECURITY OVERVIEW
                 ========================================================== --}}

            <aside class="dashboard-security-panel">


                <div class="dashboard-security-panel-header">


                    <div class="dashboard-security-panel-heading">


                        <div class="security-panel-icon safe">
                            ✓
                        </div>


                        <div>


                            <h3>
                                Security Overview
                            </h3>


                            <p>
                                Last 24-hour monitoring window
                            </p>


                        </div>


                    </div>


                </div>


                <div class="dashboard-security-overview">


                    <div class="dashboard-monitoring-status">


                        <div class="dashboard-monitoring-status-top">


                            <div class="dashboard-monitoring-icon">
                                ✓
                            </div>


                            <div>


                                <div class="dashboard-monitoring-label">
                                    Audit Monitoring
                                </div>


                                <div class="dashboard-monitoring-value">
                                    Active
                                </div>


                            </div>


                        </div>


                        <p>

                            Important authentication and
                            Administration events are being
                            recorded through the Audit Log system.

                        </p>


                    </div>


                    <div class="dashboard-security-list">


                        <div class="dashboard-security-list-item">

                            <span class="dashboard-security-list-label">
                                Audit Events
                            </span>

                            <span class="dashboard-security-list-value">
                                {{ $auditEventsLast24Hours }}
                            </span>

                        </div>


                        <div class="dashboard-security-list-item">

                            <span class="dashboard-security-list-label">
                                Failed Logins
                            </span>

                            <span
                                class="
                                    dashboard-security-list-value
                                    {{ $failedLoginsLast24Hours > 0
                                        ? 'danger'
                                        : ''
                                    }}
                                "
                            >
                                {{ $failedLoginsLast24Hours }}
                            </span>

                        </div>


                        <div class="dashboard-security-list-item">

                            <span class="dashboard-security-list-label">
                                Pending Attendance
                            </span>

                            <span class="dashboard-security-list-value">
                                {{ $pendingAttendance }}
                            </span>

                        </div>


                        <div class="dashboard-security-list-item">

                            <span class="dashboard-security-list-label">
                                Pending Work Logs
                            </span>

                            <span class="dashboard-security-list-value">
                                {{ $pendingWorkLogs }}
                            </span>

                        </div>


                    </div>


                </div>


            </aside>


        </div>


    </section>


</div>


@endsection