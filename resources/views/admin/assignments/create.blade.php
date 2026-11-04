
@extends('layouts.app')

@section('title', 'Create OJT Assignments | OJT Sync')

@push('styles')
<style>
    .bulk-page {
        --navy: #15365f;
        --blue: #2563eb;
        --muted: #64748b;
        --border: #dce5ef;
        --bg: #f6f9fd;
        --green: #15803d;

        color: #16324f;
        font-family: 'Segoe UI', Arial, sans-serif;
        font-size: 15px;
        line-height: 1.5;
    }

    .bulk-page * {
        box-sizing: border-box;
    }

    .bulk-hero {
        background: linear-gradient(
            115deg,
            #0d2849,
            #19467b 70%,
            #0e7676
        );
        color: #fff;
        border-radius: 22px;
        padding: 30px 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 22px;
    }

    .bulk-hero h1 {
        margin: 4px 0 8px;
        font-size: 30px;
        font-weight: 800;
        color: #fff;
    }

    .bulk-hero p {
        margin: 0;
        color: #dceafa;
        max-width: 700px;
    }

    .bulk-overline {
        text-transform: uppercase;
        letter-spacing: .09em;
        font-size: 12px;
        font-weight: 800;
        color: #bdddff;
    }

    .bulk-back {
        background: #fff;
        color: var(--navy);
        padding: 12px 17px;
        border-radius: 10px;
        text-decoration: none;
        white-space: nowrap;
        font-weight: 750;
    }

    .bulk-back:hover {
        color: #1d4ed8;
    }

    .bulk-steps {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    .bulk-step {
        padding: 12px 16px;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        font-weight: 700;
        color: #334e68;
        flex: 1 1 180px;
    }

    .bulk-step span {
        display: inline-grid;
        place-items: center;
        margin-right: 9px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #e9f1ff;
        color: #1d4ed8;
    }

    .bulk-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 310px;
        gap: 22px;
        align-items: start;
    }

    .bulk-main,
    .bulk-side {
        display: grid;
        gap: 20px;
        min-width: 0;
    }

    .bulk-panel {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 17px;
        box-shadow: 0 10px 28px rgba(15, 47, 83, .06);
        overflow: hidden;
    }

    .bulk-panel-heading {
        padding: 20px 22px;
        border-bottom: 1px solid #e8eef5;
    }

    .bulk-panel-heading h2 {
        margin: 0 0 3px;
        font-size: 21px;
        font-weight: 800;
    }

    .bulk-panel-heading p {
        margin: 0;
        font-size: 14px;
        color: var(--muted);
    }

    .bulk-panel-body {
        padding: 22px;
    }

    .bulk-search-wrap {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .bulk-search {
        width: 100%;
        max-width: 430px;
        padding: 12px 14px;
        background: #fbfdff;
        border: 1px solid #c8d5e5;
        border-radius: 10px;
        font: inherit;
    }

    .bulk-search:focus,
    .bulk-field input:focus,
    .bulk-field select:focus,
    .bulk-field textarea:focus {
        outline: none;
        border-color: var(--blue);
        box-shadow: 0 0 0 3px #2563eb16;
    }

    .bulk-pill {
        color: #1e40af;
        background: #e9f1ff;
        padding: 8px 12px;
        border-radius: 999px;
        font-weight: 800;
    }

    .bulk-select-all {
        background: #f3f7fc;
        border: 1px solid var(--border);
        border-radius: 11px;
        padding: 12px 14px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 750;
    }

    .bulk-select-all input,
    .bulk-row input {
        width: 19px;
        height: 19px;
        accent-color: var(--blue);
        flex: none;
        cursor: pointer;
    }

    .bulk-students {
        max-height: 385px;
        overflow-y: auto;
        border: 1px solid var(--border);
        border-radius: 12px;
    }

    .bulk-row {
        padding: 13px 15px;
        border-bottom: 1px solid #e9eef5;
        display: flex;
        gap: 12px;
        align-items: center;
        cursor: pointer;
    }

    .bulk-row:last-child {
        border-bottom: 0;
    }

    .bulk-row:not(.is-unavailable):hover {
        background: #f4f9ff;
    }

    .bulk-row.is-unavailable {
        background: #f8fafc;
        opacity: .72;
        cursor: not-allowed;
    }

    .bulk-row.is-hidden {
        display: none;
    }

    .bulk-row-main {
        flex: 1;
        min-width: 0;
    }

    .bulk-row-name {
        font-size: 15px;
        font-weight: 800;
        display: block;
        word-break: break-word;
    }

    .bulk-row-info {
        display: block;
        font-size: 13px;
        color: var(--muted);
        margin-top: 2px;
        word-break: break-word;
    }

    .bulk-tag {
        font-size: 12px;
        background: #e8f7ee;
        color: #166534;
        padding: 5px 8px;
        border-radius: 7px;
        font-weight: 750;
        white-space: nowrap;
    }

    .bulk-row.is-unavailable .bulk-tag {
        background: #e9edf3;
        color: #64748b;
    }

    .bulk-empty {
        padding: 24px;
        text-align: center;
        color: var(--muted);
    }

    .bulk-help {
        margin: 12px 0 0;
        color: var(--muted);
        font-size: 13px;
    }

    .bulk-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 17px;
    }

    .bulk-field {
        display: flex;
        flex-direction: column;
        gap: 7px;
        min-width: 0;
    }

    .bulk-field.full {
        grid-column: 1 / -1;
    }

    .bulk-field label {
        font-weight: 750;
        color: #243e5b;
    }

    .bulk-field label em {
        font-style: normal;
        color: #b91c1c;
    }

    .bulk-field input,
    .bulk-field select,
    .bulk-field textarea {
        width: 100%;
        border-radius: 10px;
        border: 1px solid #c8d5e5;
        padding: 12px 13px;
        color: #16324f;
        background: #fbfdff;
        font: inherit;
    }

    .bulk-field textarea {
        min-height: 105px;
        resize: vertical;
    }

    .bulk-field small {
        color: var(--muted);
        line-height: 1.45;
    }

    .bulk-errors,
    .bulk-warning {
        padding: 16px 19px;
        border-radius: 12px;
        margin-bottom: 18px;
    }

    .bulk-errors {
        background: #fff1f0;
        border: 1px solid #e7b7b2;
        color: #9f221d;
    }

    .bulk-errors ul {
        margin: 7px 0 0;
        padding-left: 20px;
    }

    .bulk-warning {
        background: #fffaef;
        border: 1px solid #ecd6a8;
        color: #85520e;
    }

    .bulk-side-box {
        padding: 16px;
        border-radius: 12px;
        background: #f5f9fe;
        border: 1px solid var(--border);
        margin-bottom: 12px;
    }

    .bulk-side-box:last-child {
        margin-bottom: 0;
    }

    .bulk-side-box strong {
        display: block;
        font-size: 17px;
        word-break: break-word;
    }

    .bulk-side-box small {
        display: block;
        margin-bottom: 4px;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
        font-size: 11px;
    }

    .bulk-actions {
        border-top: 1px solid var(--border);
        padding-top: 18px;
        margin-top: 21px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
    }

    .bulk-btn {
        display: inline-block;
        text-align: center;
        border: 1px solid var(--border);
        padding: 12px 20px;
        border-radius: 11px;
        font: inherit;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
    }

    .bulk-btn-secondary {
        background: #fff;
        color: var(--navy);
    }

    .bulk-btn-primary {
        background: var(--blue);
        border-color: var(--blue);
        color: #fff;
    }

    .bulk-btn-primary:hover {
        background: #1d4ed8;
    }

    .bulk-btn:disabled {
        cursor: not-allowed;
        opacity: .55;
    }

    .bulk-links {
        display: grid;
        gap: 9px;
    }

    .bulk-links a {
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 9px;
        text-decoration: none;
        color: var(--navy);
        font-weight: 700;
        background: #fff;
    }

    .bulk-links a:hover {
        background: #eaf2ff;
    }

    @media (max-width: 1060px) {
        .bulk-layout {
            grid-template-columns: 1fr;
        }

        .bulk-side {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 700px) {
        .bulk-hero {
            display: block;
            padding: 24px;
        }

        .bulk-hero h1 {
            font-size: 25px;
        }

        .bulk-back {
            display: inline-block;
            margin-top: 17px;
        }

        .bulk-fields,
        .bulk-side {
            grid-template-columns: 1fr;
        }

        .bulk-panel-body {
            padding: 16px;
        }

        .bulk-actions {
            flex-direction: column-reverse;
        }

        .bulk-btn {
            width: 100%;
        }

        .bulk-row {
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@section('content')

@php
    $students = collect($students ?? []);
    $companies = collect($companies ?? []);
    $supervisors = collect($supervisors ?? []);

    $alreadyAssigned = collect($assignedStudentIds ?? [])
        ->map(fn ($id) => (int) $id)
        ->all();

    $selectedIds = collect(old('student_profile_ids', []))
        ->map(fn ($id) => (string) $id)
        ->all();

    $availableCount = $students->filter(
        fn ($student) =>
            ! in_array(
                (int) $student->id,
                $alreadyAssigned,
                true
            )
    )->count();

    $isReady =
        $availableCount > 0
        && $companies->isNotEmpty()
        && $supervisors->isNotEmpty();
@endphp

<div class="bulk-page">

    {{-- PAGE HEADER --}}

    <section class="bulk-hero">
        <div>
            <div class="bulk-overline">
                Administrator · OJT placements
            </div>

            <h1>Create OJT Assignments</h1>

            <p>
                Select multiple students, set the placement
                details once, and create one separate assignment
                for each selected student.
            </p>
        </div>

        <a
            href="{{ route('admin.assignments.index') }}"
            class="bulk-back"
        >
            Back to Assignments
        </a>
    </section>

    {{-- PROCESS STEPS --}}

    <div class="bulk-steps">
        <div class="bulk-step">
            <span>1</span>Choose students
        </div>

        <div class="bulk-step">
            <span>2</span>Set company & supervisor
        </div>

        <div class="bulk-step">
            <span>3</span>Set hours & dates
        </div>

        <div class="bulk-step">
            <span>4</span>Create assignments
        </div>
    </div>

    {{-- VALIDATION ERRORS --}}

    @if ($errors->any())
        <div class="bulk-errors" role="alert">
            <strong>
                Please review the information below.
            </strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- MISSING REQUIREMENTS --}}

    @unless ($isReady)
        <div class="bulk-warning" role="alert">
            <strong>
                Some required records are not available.
            </strong>

            You need at least one student without an open
            assignment, one active company, and one active
            supervisor.
        </div>
    @endunless

    <form
        id="bulk-form"
        method="POST"
        action="{{ route('admin.assignments.store') }}"
    >
        @csrf

        <div class="bulk-layout">

            <main class="bulk-main">

                {{-- STUDENT SELECTION --}}

                <section class="bulk-panel">

                    <header class="bulk-panel-heading">
                        <h2>1. Select Students</h2>

                        <p>
                            Tick all students you want to assign
                            to the same company and supervisor.
                        </p>
                    </header>

                    <div class="bulk-panel-body">

                        <div class="bulk-search-wrap">

                            <input
                                id="bulk-search"
                                class="bulk-search"
                                type="search"
                                placeholder="Search name, student number, or program..."
                                aria-label="Search students"
                            >

                            <span
                                id="bulk-count"
                                class="bulk-pill"
                                aria-live="polite"
                            >
                                0 students selected
                            </span>

                        </div>

                        {{-- SELECT ALL --}}

                        <label class="bulk-select-all">

                            <input
                                id="bulk-select-all"
                                type="checkbox"
                                @disabled($availableCount === 0)
                            >

                            <span>
                                Select all visible available students
                            </span>

                        </label>

                        {{-- STUDENT CHECKLIST --}}

                        <div
                            class="bulk-students"
                            id="bulk-students"
                        >

                            @forelse ($students as $student)

                                @php
                                    $unavailable = in_array(
                                        (int) $student->id,
                                        $alreadyAssigned,
                                        true
                                    );

                                    $number =
                                        $student->student_number ?? null;

                                    $program =
                                        $student->program ?? null;

                                    $year =
                                        $student->year_level ?? null;

                                    $name =
                                        $student->user?->name
                                        ?? 'Unnamed Student';

                                    $details = implode(
                                        ' · ',
                                        array_filter([
                                            $number,
                                            $program,
                                            $year,
                                        ])
                                    );
                                @endphp

                                <label
                                    class="
                                        bulk-row
                                        {{ $unavailable ? 'is-unavailable' : '' }}
                                    "
                                    data-student-row
                                    data-search="{{ mb_strtolower($name . ' ' . $details) }}"
                                >

                                    <input
                                        type="checkbox"
                                        name="student_profile_ids[]"
                                        value="{{ $student->id }}"
                                        data-student-checkbox
                                        @checked(
                                            ! $unavailable
                                            && in_array(
                                                (string) $student->id,
                                                $selectedIds,
                                                true
                                            )
                                        )
                                        @disabled($unavailable)
                                    >

                                    <span class="bulk-row-main">

                                        <span class="bulk-row-name">
                                            {{ $name }}
                                        </span>

                                        <span class="bulk-row-info">

                                            {{ $details ?: 'Student profile' }}

                                        </span>

                                    </span>

                                    <span class="bulk-tag">

                                        {{ $unavailable
                                            ? 'Already assigned'
                                            : 'Available'
                                        }}

                                    </span>

                                </label>

                            @empty

                                <div class="bulk-empty">
                                    No active student profiles found.
                                </div>

                            @endforelse

                            <div
                                id="bulk-no-results"
                                class="bulk-empty"
                                hidden
                            >
                                No students match your search.
                            </div>

                        </div>

                        <p class="bulk-help">
                            Students with pending or active OJT
                            assignments cannot be selected.
                            "Select all" selects available students
                            shown by your search.
                        </p>

                    </div>
                </section>

                {{-- COMPANY AND SUPERVISOR --}}

                <section class="bulk-panel">

                    <header class="bulk-panel-heading">
                        <h2>2. Company and Supervisor</h2>

                        <p>
                            These details will apply to every
                            checked student.
                        </p>
                    </header>

                    <div class="bulk-panel-body bulk-fields">

                        <div class="bulk-field">

                            <label for="company_id">
                                Partner Company <em>*</em>
                            </label>

                            <select
                                name="company_id"
                                id="company_id"
                                required
                            >
                                <option value="">
                                    Select a company
                                </option>

                                @foreach ($companies as $company)
                                    <option
                                        value="{{ $company->id }}"
                                        @selected(
                                            (string) old('company_id')
                                            === (string) $company->id
                                        )
                                    >
                                        {{ $company->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('company_id')
                                <small style="color:#b91c1c">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                        <div class="bulk-field">

                            <label for="supervisor_id">
                                Assigned Supervisor <em>*</em>
                            </label>

                            <select
                                name="supervisor_id"
                                id="supervisor_id"
                                required
                            >
                                <option value="">
                                    Select a supervisor
                                </option>

                                @foreach ($supervisors as $supervisor)
                                    <option
                                        value="{{ $supervisor->id }}"
                                        @selected(
                                            (string) old('supervisor_id')
                                            === (string) $supervisor->id
                                        )
                                    >
                                        {{ $supervisor->name }}

                                        {{ $supervisor->email
                                            ? ' · ' . $supervisor->email
                                            : ''
                                        }}
                                    </option>
                                @endforeach

                            </select>

                            @error('supervisor_id')
                                <small style="color:#b91c1c">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                    </div>
                </section>

                {{-- PLACEMENT DETAILS --}}

                <section class="bulk-panel">

                    <header class="bulk-panel-heading">
                        <h2>3. Placement Details</h2>

                        <p>
                            Enter the OJT requirements only once
                            for all selected students.
                        </p>
                    </header>

                    <div class="bulk-panel-body">

                        <div class="bulk-fields">

                            <div class="bulk-field full">

                                <label for="required_hours">
                                    Required OJT Hours <em>*</em>
                                </label>

                                <input
                                    id="required_hours"
                                    name="required_hours"
                                    type="number"
                                    min="1"
                                    max="5000"
                                    step="1"
                                    value="{{ old('required_hours') }}"
                                    placeholder="Example: 480"
                                    required
                                >

                            </div>

                            <div class="bulk-field">

                                <label for="start_date">
                                    Start Date <em>*</em>
                                </label>

                                <input
                                    id="start_date"
                                    name="start_date"
                                    type="date"
                                    value="{{ old('start_date') }}"
                                    required
                                >

                            </div>

                            <div class="bulk-field">

                                <label for="end_date">
                                    End Date (Optional)
                                </label>

                                <input
                                    id="end_date"
                                    name="end_date"
                                    type="date"
                                    value="{{ old('end_date') }}"
                                >

                            </div>

                            <div class="bulk-field full">

                                <label for="status">
                                    Initial Status <em>*</em>
                                </label>

                                <select
                                    id="status"
                                    name="status"
                                    required
                                >

                                    <option
                                        value="pending"
                                        @selected(
                                            old('status', 'pending')
                                            === 'pending'
                                        )
                                    >
                                        Pending — placement has not started
                                    </option>

                                    <option
                                        value="active"
                                        @selected(
                                            old('status') === 'active'
                                        )
                                    >
                                        Active — start OJT monitoring
                                    </option>

                                </select>

                            </div>

                            <div class="bulk-field full">

                                <label for="notes">
                                    Administrative Notes (Optional)
                                </label>

                                <textarea
                                    id="notes"
                                    name="notes"
                                    maxlength="2000"
                                    placeholder="Notes for the selected students..."
                                >{{ old('notes') }}</textarea>

                                <small>
                                    The same notes will be saved
                                    in each student's assignment.
                                </small>

                            </div>

                        </div>

                        {{-- FORM ACTIONS --}}

                        <div class="bulk-actions">

                            <a
                                class="
                                    bulk-btn
                                    bulk-btn-secondary
                                "
                                href="{{ route('admin.assignments.index') }}"
                            >
                                Cancel
                            </a>

                            <button
                                class="
                                    bulk-btn
                                    bulk-btn-primary
                                "
                                id="bulk-submit"
                                type="submit"
                                @disabled(! $isReady)
                            >
                                Create Assignments
                            </button>

                        </div>

                    </div>
                </section>

            </main>

            {{-- RIGHT SIDEBAR --}}

            <aside class="bulk-side">

                <section class="bulk-panel">

                    <header class="bulk-panel-heading">
                        <h2>Assignment Summary</h2>

                        <p>
                            Preview the selected placement.
                        </p>
                    </header>

                    <div class="bulk-panel-body">

                        <div class="bulk-side-box">

                            <small>
                                Students available
                            </small>

                            <strong>
                                {{ $availableCount }}
                                of
                                {{ $students->count() }}
                            </strong>

                        </div>

                        <div class="bulk-side-box">

                            <small>
                                Students selected
                            </small>

                            <strong id="bulk-summary-count">
                                0
                            </strong>

                        </div>

                        <div class="bulk-side-box">

                            <small>Company</small>

                            <strong id="bulk-summary-company">
                                Not selected
                            </strong>

                        </div>

                        <div class="bulk-side-box">

                            <small>Supervisor</small>

                            <strong id="bulk-summary-supervisor">
                                Not selected
                            </strong>

                        </div>

                        <div class="bulk-side-box">

                            <small>Required hours</small>

                            <strong id="bulk-summary-hours">
                                Not set
                            </strong>

                        </div>

                        <p class="bulk-help">
                            Each selected student receives a
                            separate assignment record.
                            If one selection has a conflict,
                            none of the assignments will
                            be created.
                        </p>

                    </div>
                </section>

                {{-- QUICK LINKS --}}

                <section class="bulk-panel">

                    <header class="bulk-panel-heading">
                        <h2>Need Another Record?</h2>

                        <p>
                            Setup shortcuts
                        </p>
                    </header>

                    <div class="bulk-panel-body bulk-links">

                        <a href="{{ route('admin.students.index') }}">
                            Manage Students
                        </a>

                        <a href="{{ route('admin.companies.index') }}">
                            Manage Companies
                        </a>

                        <a href="{{ route('admin.supervisors.index') }}">
                            Manage Supervisors
                        </a>

                    </div>

                </section>

            </aside>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form =
        document.getElementById('bulk-form');

    const rows = Array.from(
        document.querySelectorAll('[data-student-row]')
    );

    const checkboxes = Array.from(
        document.querySelectorAll(
            '[data-student-checkbox]:not(:disabled)'
        )
    );

    const search =
        document.getElementById('bulk-search');

    const selectAll =
        document.getElementById('bulk-select-all');

    const count =
        document.getElementById('bulk-count');

    const summaryCount =
        document.getElementById('bulk-summary-count');

    const summaryCompany =
        document.getElementById('bulk-summary-company');

    const summarySupervisor =
        document.getElementById('bulk-summary-supervisor');

    const summaryHours =
        document.getElementById('bulk-summary-hours');

    const company =
        document.getElementById('company_id');

    const supervisor =
        document.getElementById('supervisor_id');

    const hours =
        document.getElementById('required_hours');

    const startDate =
        document.getElementById('start_date');

    const endDate =
        document.getElementById('end_date');

    const submit =
        document.getElementById('bulk-submit');

    const noResults =
        document.getElementById('bulk-no-results');

    /*
    |--------------------------------------------------------------------------
    | Available Students Visible in Search
    |--------------------------------------------------------------------------
    */

    function visibleAvailable() {
        return checkboxes.filter(box =>
            ! box.closest('[data-student-row]')
                .classList.contains('is-hidden')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Read Selected Dropdown Text
    |--------------------------------------------------------------------------
    */

    function chosenText(element) {

        if (
            ! element
            || ! element.value
        ) {
            return 'Not selected';
        }

        return element.options[
            element.selectedIndex
        ]
            .textContent
            .trim()
            .split(' · ')[0];
    }

    /*
    |--------------------------------------------------------------------------
    | Update Assignment Summary
    |--------------------------------------------------------------------------
    */

    function refresh() {

        const selected = checkboxes.filter(
            box => box.checked
        ).length;

        const visible = visibleAvailable();

        const selectedVisible = visible.filter(
            box => box.checked
        ).length;

        count.textContent =
            selected
            + (
                selected === 1
                    ? ' student selected'
                    : ' students selected'
            );

        summaryCount.textContent =
            String(selected);

        summaryCompany.textContent =
            chosenText(company);

        summarySupervisor.textContent =
            chosenText(supervisor);

        summaryHours.textContent =
            hours.value
                ? hours.value + ' hours'
                : 'Not set';

        /*
        |--------------------------------------------------------------------------
        | Select All State
        |--------------------------------------------------------------------------
        */

        selectAll.checked =
            visible.length > 0
            && selectedVisible === visible.length;

        selectAll.indeterminate =
            selectedVisible > 0
            && selectedVisible < visible.length;

        selectAll.disabled =
            visible.length === 0;

        /*
        |--------------------------------------------------------------------------
        | Submission Readiness
        |--------------------------------------------------------------------------
        */

        submit.disabled =
            selected === 0
            || ! company.value
            || ! supervisor.value;
    }

    /*
    |--------------------------------------------------------------------------
    | Student Search
    |--------------------------------------------------------------------------
    */

    search.addEventListener('input', function () {

        const term =
            search.value.trim().toLocaleLowerCase();

        let shown = 0;

        rows.forEach(row => {

            const matches = (
                row.dataset.search || ''
            ).includes(term);

            row.classList.toggle(
                'is-hidden',
                ! matches
            );

            if (matches) {
                shown++;
            }

        });

        noResults.hidden = shown > 0;

        refresh();
    });

    /*
    |--------------------------------------------------------------------------
    | Select All Visible Students
    |--------------------------------------------------------------------------
    */

    selectAll.addEventListener(
        'change',
        function () {

            visibleAvailable().forEach(box => {
                box.checked = selectAll.checked;
            });

            refresh();
        }
    );

    /*
    |--------------------------------------------------------------------------
    | Individual Checkbox Changes
    |--------------------------------------------------------------------------
    */

    checkboxes.forEach(box => {

        box.addEventListener(
            'change',
            refresh
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Placement Preview Changes
    |--------------------------------------------------------------------------
    */

    [
        company,
        supervisor,
        hours
    ].forEach(element => {

        element.addEventListener(
            'input',
            refresh
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Placement Date Validation
    |--------------------------------------------------------------------------
    */

    function checkDates() {

        endDate.min =
            startDate.value || '';

        endDate.setCustomValidity(
            startDate.value
            && endDate.value
            && endDate.value < startDate.value

                ? 'End Date cannot be before Start Date.'
                : ''
        );
    }

    startDate.addEventListener(
        'change',
        checkDates
    );

    endDate.addEventListener(
        'change',
        checkDates
    );

    /*
    |--------------------------------------------------------------------------
    | Confirm Bulk Assignment Submission
    |--------------------------------------------------------------------------
    */

    form.addEventListener(
        'submit',
        function (event) {

            checkDates();

            const selected = checkboxes.filter(
                box => box.checked
            ).length;

            if (! selected) {

                event.preventDefault();

                alert(
                    'Please select at least one available student.'
                );

                return;
            }

            if (! form.checkValidity()) {

                event.preventDefault();

                form.reportValidity();

                return;
            }

            const confirmed = confirm(
                'Create '
                + selected
                + (
                    selected === 1
                        ? ' OJT assignment'
                        : ' OJT assignments'
                )
                + ' using the same placement details?'
            );

            if (! confirmed) {

                event.preventDefault();

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Prevent Double Submission
            |--------------------------------------------------------------------------
            */

            submit.disabled = true;

            submit.textContent =
                'Creating Assignments...';
        }
    );

    /*
    |--------------------------------------------------------------------------
    | Initial State
    |--------------------------------------------------------------------------
    */

    checkDates();
    refresh();

});
</script>

@endpush
