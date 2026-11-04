@extends('layouts.app')


@section('title', 'Add Company | OJT Sync')


@push('styles')

<style>

    /* ================================================================
       CREATE COMPANY DESIGN SYSTEM
       ================================================================ */

    :root {
        --cc-primary: #183B6B;
        --cc-primary-dark: #102A4A;
        --cc-primary-light: #315F98;

        --cc-blue: #2563EB;
        --cc-blue-soft: #EAF2FF;

        --cc-green: #15803D;
        --cc-green-soft: #EAF8EF;

        --cc-orange: #B45309;
        --cc-orange-soft: #FFF5E6;

        --cc-red: #B42318;
        --cc-red-soft: #FFF0EE;

        --cc-purple: #6D4FC2;
        --cc-purple-soft: #F2EEFF;

        --cc-teal: #0F766E;
        --cc-teal-soft: #E7F7F5;

        --cc-text: #102A4A;
        --cc-text-body: #4F667F;
        --cc-text-muted: #718399;

        --cc-surface: #FFFFFF;
        --cc-surface-soft: #F8FBFE;

        --cc-border: #DCE5EE;
        --cc-border-soft: #E9EFF5;

        --cc-shadow:
            0 10px 30px rgba(15, 42, 74, 0.07);

        --cc-shadow-hover:
            0 18px 42px rgba(15, 42, 74, 0.11);

        --cc-transition:
            all 0.24s ease;
    }


    /* ================================================================
       PAGE
       ================================================================ */

    .create-company-page {
        width: 100%;
    }


    /* ================================================================
       HERO
       ================================================================ */

    .create-company-hero {
        position: relative;

        overflow: hidden;

        margin-bottom: 29px;

        padding:
            36px
            40px;

        border-radius: 25px;

        background:
            radial-gradient(
                circle at 87% 18%,
                rgba(167, 139, 250, 0.18),
                transparent 24%
            ),
            radial-gradient(
                circle at 72% 80%,
                rgba(96, 165, 250, 0.11),
                transparent 24%
            ),
            linear-gradient(
                135deg,
                #102A4A 0%,
                #183B6B 56%,
                #2B5B91 100%
            );

        color: #FFFFFF;

        box-shadow:
            0 21px 50px
            rgba(16, 42, 74, 0.18);
    }


    .create-company-hero::before {
        content: "";

        position: absolute;

        width: 300px;
        height: 300px;

        right: -115px;
        top: -155px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.07);
    }


    .create-company-hero::after {
        content: "";

        position: absolute;

        width: 185px;
        height: 185px;

        right: 215px;
        bottom: -125px;

        border-radius: 50%;

        background:
            rgba(139, 92, 246, 0.07);
    }


    .create-company-hero-inner {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 30px;
    }


    .create-company-hero-copy {
        max-width: 780px;
    }


    .create-company-eyebrow {
        display: inline-flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 14px;

        padding:
            9px
            14px;

        border:
            1px solid
            rgba(255, 255, 255, 0.15);

        border-radius: 999px;

        background:
            rgba(255, 255, 255, 0.09);

        color:
            rgba(255, 255, 255, 0.92);

        font-size: 13px;
        font-weight: 750;
    }


    .create-company-eyebrow-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background: #A78BFA;

        box-shadow:
            0 0 0 5px
            rgba(167, 139, 250, 0.13);
    }


    .create-company-hero h1 {
        margin:
            0
            0
            11px;

        color: #FFFFFF;

        font-size: 35px;
        font-weight: 850;

        line-height: 1.18;

        letter-spacing: -0.5px;
    }


    .create-company-hero p {
        max-width: 730px;

        margin: 0;

        color:
            rgba(255, 255, 255, 0.77);

        font-size: 16px;

        line-height: 1.72;
    }


    .hero-back-button {
        min-height: 49px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        padding:
            0
            17px;

        border:
            1px solid
            rgba(255, 255, 255, 0.17);

        border-radius: 13px;

        background:
            rgba(255, 255, 255, 0.10);

        color: #FFFFFF;

        text-decoration: none;

        font-size: 14px;
        font-weight: 850;

        white-space: nowrap;

        backdrop-filter:
            blur(10px);

        transition:
            var(--cc-transition);
    }


    .hero-back-button:hover {
        transform:
            translateY(-2px);

        background:
            rgba(255, 255, 255, 0.17);
    }


    /* ================================================================
       WORKFLOW
       ================================================================ */

    .company-workflow {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 15px;

        margin-bottom: 28px;
    }


    .workflow-card {
        display: flex;
        align-items: center;

        gap: 14px;

        padding: 19px;

        border:
            1px solid
            var(--cc-border);

        border-radius: 17px;

        background:
            var(--cc-surface);

        box-shadow:
            var(--cc-shadow);
    }


    .workflow-number {
        width: 44px;
        height: 44px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            var(--cc-purple-soft);

        color:
            var(--cc-purple);

        font-size: 13px;
        font-weight: 900;
    }


    .workflow-card.current
    .workflow-number {
        background:
            var(--cc-primary);

        color: #FFFFFF;
    }


    .workflow-copy strong {
        display: block;

        margin-bottom: 4px;

        color:
            var(--cc-text);

        font-size: 14px;
        font-weight: 850;
    }


    .workflow-copy span {
        color:
            var(--cc-text-muted);

        font-size: 12px;

        line-height: 1.5;
    }


    /* ================================================================
       MAIN LAYOUT
       ================================================================ */

    .create-company-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1.45fr)
            minmax(300px, 0.55fr);

        gap: 22px;

        align-items: start;
    }


    /* ================================================================
       FORM PANEL
       ================================================================ */

    .company-form-panel {
        overflow: hidden;

        border:
            1px solid
            var(--cc-border);

        border-radius: 20px;

        background:
            var(--cc-surface);

        box-shadow:
            var(--cc-shadow);
    }


    .company-form-header {
        padding:
            25px
            27px;

        border-bottom:
            1px solid
            var(--cc-border-soft);

        background:
            linear-gradient(
                180deg,
                #FFFFFF 0%,
                #FBFDFF 100%
            );
    }


    .company-form-header-content {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    .company-form-header-icon {
        width: 50px;
        height: 50px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 15px;

        background:
            var(--cc-purple-soft);

        color:
            var(--cc-purple);

        font-size: 14px;
        font-weight: 900;
    }


    .company-form-header h2 {
        margin:
            0
            0
            4px;

        color:
            var(--cc-text);

        font-size: 22px;
        font-weight: 850;
    }


    .company-form-header p {
        margin: 0;

        color:
            var(--cc-text-body);

        font-size: 14px;

        line-height: 1.55;
    }


    .company-form-body {
        padding:
            28px
            27px;
    }


    /* ================================================================
       VALIDATION
       ================================================================ */

    .validation-summary {
        margin-bottom: 25px;

        padding:
            17px
            18px;

        border:
            1px solid
            #F2CECA;

        border-radius: 14px;

        background:
            var(--cc-red-soft);

        color:
            var(--cc-red);
    }


    .validation-summary-title {
        display: flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 8px;

        font-size: 14px;
        font-weight: 850;
    }


    .validation-summary-icon {
        width: 25px;
        height: 25px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 7px;

        background:
            #FEE4E2;

        font-weight: 900;
    }


    .validation-summary ul {
        margin: 0;

        padding-left: 22px;

        font-size: 13px;

        line-height: 1.75;
    }


    /* ================================================================
       FORM SECTIONS
       ================================================================ */

    .form-section {
        margin-bottom: 33px;
    }


    .form-section:last-of-type {
        margin-bottom: 0;
    }


    .form-section-heading {
        display: flex;
        align-items: center;

        gap: 10px;

        margin-bottom: 18px;
    }


    .form-section-number {
        width: 32px;
        height: 32px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        background:
            #F0F5FA;

        color:
            var(--cc-primary);

        font-size: 11px;
        font-weight: 900;
    }


    .form-section-title {
        color:
            var(--cc-text);

        font-size: 17px;
        font-weight: 850;
    }


    .form-section-description {
        margin:
            -10px
            0
            19px
            42px;

        color:
            var(--cc-text-muted);

        font-size: 12px;

        line-height: 1.6;
    }


    .form-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            20px
            21px;
    }


    .form-field-full {
        grid-column:
            1 / -1;
    }


    /* ================================================================
       LABELS
       ================================================================ */

    .form-label-row {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        margin-bottom: 8px;
    }


    .form-label {
        color:
            var(--cc-text);

        font-size: 14px;
        font-weight: 800;
    }


    .required-label {
        color:
            var(--cc-text-muted);

        font-size: 11px;
        font-weight: 650;
    }


    .optional-label {
        color:
            var(--cc-purple);

        font-size: 11px;
        font-weight: 750;
    }


    /* ================================================================
       INPUTS
       ================================================================ */

    .field-wrapper {
        position: relative;
    }


    .field-symbol {
        position: absolute;

        top: 50%;
        left: 15px;

        transform:
            translateY(-50%);

        width: 24px;
        height: 24px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        color:
            var(--cc-text-muted);

        font-size: 12px;
        font-weight: 850;

        pointer-events: none;
    }


    .company-input,
    .company-textarea {
        width: 100%;

        border:
            1px solid
            var(--cc-border);

        border-radius: 13px;

        outline: none;

        background:
            #FBFDFF;

        color:
            var(--cc-text);

        font-size: 15px;

        transition:
            var(--cc-transition);
    }


    .company-input {
        min-height: 54px;

        padding:
            0
            16px
            0
            49px;
    }


    .company-textarea {
        min-height: 125px;

        padding:
            15px
            16px;

        line-height: 1.65;

        resize: vertical;
    }


    .company-input::placeholder,
    .company-textarea::placeholder {
        color: #98A7B8;
    }


    .company-input:hover,
    .company-textarea:hover {
        border-color:
            #BCCCDC;
    }


    .company-input:focus,
    .company-textarea:focus {
        border-color:
            var(--cc-purple);

        background: #FFFFFF;

        box-shadow:
            0 0 0 4px
            rgba(109, 79, 194, 0.09);
    }


    .field-help {
        margin-top: 7px;

        color:
            var(--cc-text-muted);

        font-size: 12px;

        line-height: 1.6;
    }


    .field-error {
        margin-top: 7px;

        color:
            var(--cc-red);

        font-size: 12px;
        font-weight: 650;

        line-height: 1.5;
    }


    /* ================================================================
       CONTACT GROUP
       ================================================================ */

    .contact-note {
        display: flex;
        align-items: flex-start;

        gap: 11px;

        margin-bottom: 18px;

        padding:
            15px
            16px;

        border:
            1px solid
            #DDEAF7;

        border-radius: 13px;

        background:
            #F5F9FE;
    }


    .contact-note-icon {
        width: 31px;
        height: 31px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        background:
            var(--cc-blue-soft);

        color:
            var(--cc-blue);

        font-size: 12px;
        font-weight: 900;
    }


    .contact-note strong {
        display: block;

        margin-bottom: 3px;

        color:
            var(--cc-text);

        font-size: 13px;
        font-weight: 850;
    }


    .contact-note span {
        color:
            var(--cc-text-body);

        font-size: 12px;

        line-height: 1.6;
    }


    /* ================================================================
       STATUS OPTIONS
       ================================================================ */

    .status-options {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 13px;
    }


    .status-option {
        position: relative;
    }


    .status-option input {
        position: absolute;

        opacity: 0;

        pointer-events: none;
    }


    .status-option-label {
        min-height: 90px;

        display: flex;
        align-items: center;

        gap: 12px;

        padding:
            15px;

        border:
            1px solid
            var(--cc-border);

        border-radius: 14px;

        background:
            #FBFDFF;

        cursor: pointer;

        transition:
            var(--cc-transition);
    }


    .status-option-label:hover {
        border-color:
            #BCCCDC;

        background: #FFFFFF;
    }


    .status-option input:checked
    + .status-option-label {
        border-color:
            var(--cc-purple);

        background:
            #F8F6FF;

        box-shadow:
            0 0 0 3px
            rgba(109, 79, 194, 0.07);
    }


    .status-icon {
        width: 41px;
        height: 41px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 11px;

        font-size: 13px;
        font-weight: 900;
    }


    .status-icon-active {
        background:
            var(--cc-green-soft);

        color:
            var(--cc-green);
    }


    .status-icon-inactive {
        background:
            var(--cc-orange-soft);

        color:
            var(--cc-orange);
    }


    .status-copy strong {
        display: block;

        margin-bottom: 3px;

        color:
            var(--cc-text);

        font-size: 14px;
        font-weight: 850;
    }


    .status-copy span {
        color:
            var(--cc-text-muted);

        font-size: 11px;

        line-height: 1.5;
    }


    /* ================================================================
       ACTIONS
       ================================================================ */

    .form-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;

        gap: 12px;

        margin-top: 33px;

        padding-top: 24px;

        border-top:
            1px solid
            var(--cc-border-soft);
    }


    .cancel-button {
        min-height: 46px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0
            18px;

        border:
            1px solid
            var(--cc-border);

        border-radius: 11px;

        background:
            #FFFFFF;

        color:
            var(--cc-primary);

        text-decoration: none;

        font-size: 13px;
        font-weight: 800;

        transition:
            var(--cc-transition);
    }


    .cancel-button:hover {
        border-color:
            #BCCCDC;

        background:
            #F5F8FB;
    }


    .save-company-button {
        min-height: 49px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 9px;

        padding:
            0
            21px;

        border: none;

        border-radius: 12px;

        background:
            linear-gradient(
                135deg,
                var(--cc-primary) 0%,
                #2B5B91 100%
            );

        color: #FFFFFF;

        cursor: pointer;

        font-size: 14px;
        font-weight: 850;

        box-shadow:
            0 10px 24px
            rgba(24, 59, 107, 0.18);

        transition:
            var(--cc-transition);
    }


    .save-company-button:hover {
        transform:
            translateY(-2px);

        box-shadow:
            0 15px 31px
            rgba(24, 59, 107, 0.23);
    }


    .save-company-arrow {
        font-size: 18px;
    }


    /* ================================================================
       SIDEBAR
       ================================================================ */

    .company-sidebar {
        display: grid;

        gap: 17px;
    }


    .sidebar-card {
        padding: 22px;

        border:
            1px solid
            var(--cc-border);

        border-radius: 18px;

        background:
            var(--cc-surface);

        box-shadow:
            var(--cc-shadow);
    }


    .sidebar-card-header {
        display: flex;
        align-items: center;

        gap: 11px;

        margin-bottom: 15px;
    }


    .sidebar-icon {
        width: 41px;
        height: 41px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        font-size: 12px;
        font-weight: 900;
    }


    .sidebar-purple {
        background:
            var(--cc-purple-soft);

        color:
            var(--cc-purple);
    }


    .sidebar-blue {
        background:
            var(--cc-blue-soft);

        color:
            var(--cc-blue);
    }


    .sidebar-green {
        background:
            var(--cc-green-soft);

        color:
            var(--cc-green);
    }


    .sidebar-orange {
        background:
            var(--cc-orange-soft);

        color:
            var(--cc-orange);
    }


    .sidebar-card h3 {
        margin: 0;

        color:
            var(--cc-text);

        font-size: 16px;
        font-weight: 850;
    }


    .sidebar-card p {
        margin:
            0
            0
            14px;

        color:
            var(--cc-text-body);

        font-size: 13px;

        line-height: 1.65;
    }


    .sidebar-list {
        list-style: none;

        margin: 0;
        padding: 0;

        display: grid;

        gap: 10px;
    }


    .sidebar-list li {
        display: flex;
        align-items: flex-start;

        gap: 9px;

        color:
            var(--cc-text-body);

        font-size: 12px;

        line-height: 1.6;
    }


    .sidebar-list li::before {
        content: "✓";

        color:
            var(--cc-green);

        font-weight: 900;
    }


    /* ================================================================
       INFORMATION BOX
       ================================================================ */

    .information-box {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        padding: 13px;

        border-radius: 11px;

        background:
            rgba(109, 79, 194, 0.06);

        color:
            var(--cc-text-body);

        font-size: 12px;

        line-height: 1.65;
    }


    .information-symbol {
        width: 25px;
        height: 25px;

        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 7px;

        background:
            var(--cc-purple-soft);

        color:
            var(--cc-purple);

        font-weight: 900;
    }


    /* ================================================================
       SECURITY CARD
       ================================================================ */

    .security-card {
        border-color:
            #DDEAF7;

        background:
            linear-gradient(
                135deg,
                #F8FBFF 0%,
                #F1F7FD 100%
            );
    }


    /* ================================================================
       RESPONSIVE
       ================================================================ */

    @media (max-width: 1060px) {

        .create-company-layout {
            grid-template-columns: 1fr;
        }


        .company-sidebar {
            grid-template-columns:
                repeat(3, minmax(0, 1fr));
        }

    }


    @media (max-width: 800px) {

        .create-company-hero {
            padding:
                30px
                25px;
        }


        .create-company-hero-inner {
            flex-direction: column;

            align-items: flex-start;
        }


        .create-company-hero h1 {
            font-size: 30px;
        }


        .hero-back-button {
            width: 100%;
        }


        .company-workflow {
            grid-template-columns: 1fr;
        }


        .company-sidebar {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 650px) {

        .company-form-header,
        .company-form-body {
            padding:
                22px
                20px;
        }


        .form-grid,
        .status-options {
            grid-template-columns: 1fr;
        }


        .form-field-full {
            grid-column: auto;
        }


        .form-actions {
            flex-direction: column;

            align-items: stretch;
        }


        .cancel-button,
        .save-company-button {
            width: 100%;
        }

    }

</style>

@endpush


@section('content')


<div class="create-company-page">


    {{-- ==================================================================
         HERO
         ================================================================== --}}

    <section class="create-company-hero">


        <div class="create-company-hero-inner">


            <div class="create-company-hero-copy">


                <div class="create-company-eyebrow">


                    <span class="create-company-eyebrow-dot"></span>


                    Company Management · New Partner Company


                </div>


                <h1>
                    Add OJT Partner Company
                </h1>


                <p>

                    Register an official company or establishment
                    that can be used for Student OJT placement.
                    Maintain accurate contact information and
                    availability so Administrators can confidently
                    manage future assignments.

                </p>


            </div>


            <a
                href="{{ route('admin.companies.index') }}"
                class="hero-back-button"
            >
                ← Back to Companies
            </a>


        </div>


    </section>


    {{-- ==================================================================
         WORKFLOW
         ================================================================== --}}

    <section class="company-workflow">


        <div class="workflow-card current">


            <div class="workflow-number">
                01
            </div>


            <div class="workflow-copy">


                <strong>
                    Register Company
                </strong>


                <span>

                    Add official company and contact information

                </span>


            </div>


        </div>


        <div class="workflow-card">


            <div class="workflow-number">
                02
            </div>


            <div class="workflow-copy">


                <strong>
                    Create OJT Assignment
                </strong>


                <span>

                    Select the company during Student placement

                </span>


            </div>


        </div>


        <div class="workflow-card">


            <div class="workflow-number">
                03
            </div>


            <div class="workflow-copy">


                <strong>
                    Monitor Placement
                </strong>


                <span>

                    Track Student attendance, logs and progress

                </span>


            </div>


        </div>


    </section>


    {{-- ==================================================================
         MAIN LAYOUT
         ================================================================== --}}

    <div class="create-company-layout">


        {{-- ==============================================================
             FORM
             ============================================================== --}}

        <section class="company-form-panel">


            <div class="company-form-header">


                <div class="company-form-header-content">


                    <div class="company-form-header-icon">
                        CO
                    </div>


                    <div>


                        <h2>
                            Company Information
                        </h2>


                        <p>

                            Enter the official business and
                            OJT contact details for this company.

                        </p>


                    </div>


                </div>


            </div>


            <div class="company-form-body">


                {{-- ======================================================
                     VALIDATION ERRORS
                     ====================================================== --}}

                @if ($errors->any())


                    <div
                        class="validation-summary"
                        role="alert"
                    >


                        <div class="validation-summary-title">


                            <span class="validation-summary-icon">
                                !
                            </span>


                            Please review the information below


                        </div>


                        <ul>


                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach


                        </ul>


                    </div>


                @endif


                {{-- ======================================================
                     FORM
                     ====================================================== --}}

                <form
                    method="POST"
                    action="{{ route('admin.companies.store') }}"
                >

                    @csrf


                    {{-- ==================================================
                         COMPANY IDENTITY
                         ================================================== --}}

                    <section class="form-section">


                        <div class="form-section-heading">


                            <span class="form-section-number">
                                01
                            </span>


                            <span class="form-section-title">
                                Company Identity
                            </span>


                        </div>


                        <p class="form-section-description">

                            Enter the official name of the company
                            or establishment that will participate
                            in the OJT program.

                        </p>


                        <div class="form-grid">


                            <div class="form-field-full">


                                <div class="form-label-row">


                                    <label
                                        for="name"
                                        class="form-label"
                                    >
                                        Company Name
                                    </label>


                                    <span class="required-label">
                                        Required
                                    </span>


                                </div>


                                <div class="field-wrapper">


                                    <span
                                        class="field-symbol"
                                        aria-hidden="true"
                                    >
                                        CO
                                    </span>


                                    <input
                                        id="name"
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        class="company-input"
                                        placeholder="Enter the official company name"
                                        autocomplete="organization"
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


                                <div class="field-help">

                                    Use the complete official business
                                    or establishment name because this
                                    may appear in OJT assignments and reports.

                                </div>


                            </div>


                        </div>


                    </section>


                    {{-- ==================================================
                         CONTACT INFORMATION
                         ================================================== --}}

                    <section class="form-section">


                        <div class="form-section-heading">


                            <span class="form-section-number">
                                02
                            </span>


                            <span class="form-section-title">
                                OJT Contact Information
                            </span>


                        </div>


                        <p class="form-section-description">

                            Record the company's primary person and
                            communication details for OJT coordination.

                        </p>


                        <div class="contact-note">


                            <span class="contact-note-icon">
                                i
                            </span>


                            <div>


                                <strong>
                                    Use reliable contact information
                                </strong>


                                <span>

                                    These details help Administrators
                                    coordinate Student placement and
                                    communicate with the company when
                                    OJT concerns need attention.

                                </span>


                            </div>


                        </div>


                        <div class="form-grid">


                            {{-- ==========================================
                                 CONTACT PERSON
                                 ========================================== --}}

                            <div>


                                <div class="form-label-row">


                                    <label
                                        for="contact_person"
                                        class="form-label"
                                    >
                                        Contact Person
                                    </label>


                                    <span class="optional-label">
                                        Contact
                                    </span>


                                </div>


                                <div class="field-wrapper">


                                    <span
                                        class="field-symbol"
                                        aria-hidden="true"
                                    >
                                        CP
                                    </span>


                                    <input
                                        id="contact_person"
                                        type="text"
                                        name="contact_person"
                                        value="{{ old('contact_person') }}"
                                        class="company-input"
                                        placeholder="Enter contact person's name"
                                        autocomplete="name"
                                        maxlength="255"
                                    >


                                </div>


                                @error('contact_person')

                                    <div class="field-error">
                                        {{ $message }}
                                    </div>

                                @enderror


                                <div class="field-help">

                                    Person responsible for OJT
                                    coordination at the company.

                                </div>


                            </div>


                            {{-- ==========================================
                                 CONTACT NUMBER
                                 ========================================== --}}

                            <div>


                                <div class="form-label-row">


                                    <label
                                        for="contact_number"
                                        class="form-label"
                                    >
                                        Contact Number
                                    </label>


                                    <span class="optional-label">
                                        Contact
                                    </span>


                                </div>


                                <div class="field-wrapper">


                                    <span
                                        class="field-symbol"
                                        aria-hidden="true"
                                    >
                                        #
                                    </span>


                                    <input
                                        id="contact_number"
                                        type="text"
                                        name="contact_number"
                                        value="{{ old('contact_number') }}"
                                        class="company-input"
                                        placeholder="Example: 0912-345-6789"
                                        autocomplete="tel"
                                        inputmode="tel"
                                        maxlength="50"
                                    >


                                </div>


                                @error('contact_number')

                                    <div class="field-error">
                                        {{ $message }}
                                    </div>

                                @enderror


                                <div class="field-help">

                                    Enter the primary mobile,
                                    telephone or office number.

                                </div>


                            </div>


                            {{-- ==========================================
                                 EMAIL
                                 ========================================== --}}

                            <div class="form-field-full">


                                <div class="form-label-row">


                                    <label
                                        for="email"
                                        class="form-label"
                                    >
                                        Company Email Address
                                    </label>


                                    <span class="optional-label">
                                        Contact
                                    </span>


                                </div>


                                <div class="field-wrapper">


                                    <span
                                        class="field-symbol"
                                        aria-hidden="true"
                                    >
                                        @
                                    </span>


                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="company-input"
                                        placeholder="company@example.com"
                                        autocomplete="email"
                                        inputmode="email"
                                        maxlength="255"
                                    >


                                </div>


                                @error('email')

                                    <div class="field-error">
                                        {{ $message }}
                                    </div>

                                @enderror


                                <div class="field-help">

                                    Use an official company email
                                    address when one is available.

                                </div>


                            </div>


                        </div>


                    </section>


                    {{-- ==================================================
                         ADDRESS
                         ================================================== --}}

                    <section class="form-section">


                        <div class="form-section-heading">


                            <span class="form-section-number">
                                03
                            </span>


                            <span class="form-section-title">
                                Company Location
                            </span>


                        </div>


                        <p class="form-section-description">

                            Enter the business or OJT training
                            location associated with this company.

                        </p>


                        <div class="form-grid">


                            <div class="form-field-full">


                                <div class="form-label-row">


                                    <label
                                        for="address"
                                        class="form-label"
                                    >
                                        Complete Address
                                    </label>


                                    <span class="optional-label">
                                        Location
                                    </span>


                                </div>


                                <textarea
                                    id="address"
                                    name="address"
                                    class="company-textarea"
                                    placeholder="Enter street, barangay, municipality/city, province, and other useful location details"
                                >{{ old('address') }}</textarea>


                                @error('address')

                                    <div class="field-error">
                                        {{ $message }}
                                    </div>

                                @enderror


                                <div class="field-help">

                                    A complete address makes the
                                    company easier to identify when
                                    Administrators manage Student placements.

                                </div>


                            </div>


                        </div>


                    </section>


                    {{-- ==================================================
                         STATUS
                         ================================================== --}}

                    <section class="form-section">


                        <div class="form-section-heading">


                            <span class="form-section-number">
                                04
                            </span>


                            <span class="form-section-title">
                                Company Availability
                            </span>


                        </div>


                        <p class="form-section-description">

                            Set whether this company is currently
                            available for normal administrative use.

                        </p>


                        <div class="status-options">


                            {{-- ==========================================
                                 ACTIVE
                                 ========================================== --}}

                            <div class="status-option">


                                <input
                                    id="status_active"
                                    type="radio"
                                    name="status"
                                    value="active"
                                    @checked(
                                        old(
                                            'status',
                                            'active'
                                        ) === 'active'
                                    )
                                    required
                                >


                                <label
                                    for="status_active"
                                    class="status-option-label"
                                >


                                    <span
                                        class="
                                            status-icon
                                            status-icon-active
                                        "
                                    >
                                        ✓
                                    </span>


                                    <span class="status-copy">


                                        <strong>
                                            Active
                                        </strong>


                                        <span>

                                            Company is available
                                            for normal OJT management
                                            and future placements.

                                        </span>


                                    </span>


                                </label>


                            </div>


                            {{-- ==========================================
                                 INACTIVE
                                 ========================================== --}}

                            <div class="status-option">


                                <input
                                    id="status_inactive"
                                    type="radio"
                                    name="status"
                                    value="inactive"
                                    @checked(
                                        old('status') === 'inactive'
                                    )
                                    required
                                >


                                <label
                                    for="status_inactive"
                                    class="status-option-label"
                                >


                                    <span
                                        class="
                                            status-icon
                                            status-icon-inactive
                                        "
                                    >
                                        —
                                    </span>


                                    <span class="status-copy">


                                        <strong>
                                            Inactive
                                        </strong>


                                        <span>

                                            Company record remains stored
                                            but is marked unavailable.

                                        </span>


                                    </span>


                                </label>


                            </div>


                        </div>


                        @error('status')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror


                    </section>


                    {{-- ==================================================
                         ACTIONS
                         ================================================== --}}

                    <div class="form-actions">


                        <a
                            href="{{ route('admin.companies.index') }}"
                            class="cancel-button"
                        >
                            Cancel
                        </a>


                        <button
                            type="submit"
                            class="save-company-button"
                        >

                            Add Company

                            <span
                                class="save-company-arrow"
                                aria-hidden="true"
                            >
                                →
                            </span>

                        </button>


                    </div>


                </form>


            </div>


        </section>


        {{-- ==============================================================
             SIDEBAR
             ============================================================== --}}

        <aside class="company-sidebar">


            {{-- ==========================================================
                 COMPANY RECORD
                 ========================================================== --}}

            <section class="sidebar-card">


                <div class="sidebar-card-header">


                    <div class="sidebar-icon sidebar-purple">
                        CO
                    </div>


                    <h3>
                        OJT Partner Company
                    </h3>


                </div>


                <p>

                    Company records identify the establishments
                    where Students can complete their required OJT.

                </p>


                <ul class="sidebar-list">


                    <li>
                        Used when creating OJT Assignments
                    </li>


                    <li>
                        Appears in Student placement records
                    </li>


                    <li>
                        Appears in administrative reports
                    </li>


                    <li>
                        Keeps OJT contact information centralized
                    </li>


                </ul>


            </section>


            {{-- ==========================================================
                 NEXT STEP
                 ========================================================== --}}

            <section class="sidebar-card">


                <div class="sidebar-card-header">


                    <div class="sidebar-icon sidebar-blue">
                        02
                    </div>


                    <h3>
                        What Happens Next?
                    </h3>


                </div>


                <p>

                    Registering a company does not automatically
                    assign a Student to that company.

                </p>


                <ul class="sidebar-list">


                    <li>
                        Save the company record
                    </li>


                    <li>
                        Open OJT Assignments
                    </li>


                    <li>
                        Choose a Student
                    </li>


                    <li>
                        Select this company
                    </li>


                    <li>
                        Assign an authorized Supervisor
                    </li>


                    <li>
                        Configure required hours and dates
                    </li>


                </ul>


            </section>


            {{-- ==========================================================
                 DATA QUALITY
                 ========================================================== --}}

            <section class="sidebar-card">


                <div class="sidebar-card-header">


                    <div class="sidebar-icon sidebar-green">
                        ✓
                    </div>


                    <h3>
                        Data Quality
                    </h3>


                </div>


                <p>

                    Accurate company information improves
                    placement administration and reporting.

                </p>


                <div class="information-box">


                    <span class="information-symbol">
                        i
                    </span>


                    <span>

                        Before saving, verify the company name,
                        contact person, phone number, email,
                        and business address whenever possible.

                    </span>


                </div>


            </section>


            {{-- ==========================================================
                 SECURITY
                 ========================================================== --}}

            <section
                class="
                    sidebar-card
                    security-card
                "
            >


                <div class="sidebar-card-header">


                    <div class="sidebar-icon sidebar-orange">
                        SC
                    </div>


                    <h3>
                        Administrative Record
                    </h3>


                </div>


                <p>

                    Company creation is restricted to authenticated
                    Administrator access and is part of the system's
                    managed OJT records.

                </p>


                <ul class="sidebar-list">


                    <li>
                        Server-side validation remains enforced
                    </li>


                    <li>
                        Company status is controlled by Administrators
                    </li>


                    <li>
                        Existing OJT records remain separate
                        from company account management
                    </li>


                    <li>
                        Administrative changes can be captured
                        by the Audit Log system
                    </li>


                </ul>


            </section>


        </aside>


    </div>


</div>


@endsection