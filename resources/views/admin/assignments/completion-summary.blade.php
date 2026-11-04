@extends('layouts.app')


@section(
    'title',
    'OJT Completion Summary | OJT Sync'
)


@push('styles')

<style>

    .official-report {
        max-width: 1100px;

        margin: 0 auto;

        padding: 28px;

        background: #ffffff;

        border: 1px solid #dce3eb;

        border-radius: 14px;
    }

    .official-report-header {
        text-align: center;

        padding-bottom: 22px;

        margin-bottom: 25px;

        border-bottom: 2px solid #1e3a5f;
    }

    .official-report-header h1 {
        color: #1e3a5f;

        margin-bottom: 7px;
    }

    .report-status {
        display: inline-block;

        margin-top: 10px;

        padding: 6px 12px;

        border-radius: 999px;

        font-weight: 700;
    }

    .report-official {
        color: #166534;
        background: #dcfce7;
    }

    .report-draft {
        color: #92400e;
        background: #fef3c7;
    }

    .report-info-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 20px;

        margin-bottom: 25px;
    }

    .report-info-box {
        padding: 18px;

        background: #f8fafc;

        border-radius: 10px;
    }

    .report-info-box p {
        margin-bottom: 8px;
    }

    .report-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 14px;

        margin-bottom: 25px;
    }

    .report-summary-card {
        padding: 16px;

        text-align: center;

        border: 1px solid #dce3eb;
        border-radius: 10px;
    }

    .report-summary-card span {
        display: block;

        margin-bottom: 6px;

        color: #64748b;

        font-size: 12px;
    }

    .report-summary-card strong {
        color: #1e3a5f;

        font-size: 20px;
    }

    @media (max-width: 700px) {

        .report-info-grid,
        .report-summary-grid {
            grid-template-columns: 1fr;
        }

    }

    @media print {

        .app-header,
        .app-navigation,
        .print-hide {
            display: none !important;
        }

        body {
            background: #ffffff !important;
        }

        .main-container {
            width: 100% !important;
            max-width: none !important;

            margin: 0 !important;
            padding: 0 !important;
        }

        .official-report {
            max-width: none;

            padding: 0;

            border: none;
            box-shadow: none;
        }

        .data-table {
            font-size: 10px;
        }

    }

</style>

@endpush


@section('content')


<div class="print-hide" style="margin-bottom: 20px;">

    <button
        type="button"
        class="btn btn-primary"
        onclick="window.print();"
    >
        Print / Save as PDF
    </button>


    <a
        href="{{ route(
            'admin.assignments.show',
            $assignment
        ) }}"
        class="btn btn-secondary"
    >
        Back to Assignment
    </a>

</div>


<div class="official-report">


    <div class="official-report-header">

        <h1>
            OJT Sync
        </h1>

        <h2>
            OJT Assignment Completion Summary
        </h2>


        @if (
            $assignment->status
            === \App\Models\OjtAssignment::STATUS_COMPLETED
        )

            <span
                class="
                    report-status
                    report-official
                "
            >
                OFFICIAL COMPLETED RECORD
            </span>

        @else

            <span
                class="
                    report-status
                    report-draft
                "
            >
                DRAFT / NOT YET COMPLETED
            </span>

        @endif

    </div>


    <div class="report-info-grid">


        <div class="report-info-box">

            <h3>
                Student Information
            </h3>


            <p>

                <strong>
                    Name:
                </strong>

                {{ $assignment
                    ->studentProfile
                    ->user
                    ->name }}

            </p>


            <p>

                <strong>
                    Student Number:
                </strong>

                {{ $assignment
                    ->studentProfile
                    ->student_number }}

            </p>


            <p>

                <strong>
                    Program:
                </strong>

                {{ $assignment
                    ->studentProfile
                    ->program }}

            </p>


            <p>

                <strong>
                    Year Level:
                </strong>

                {{ $assignment
                    ->studentProfile
                    ->year_level }}

            </p>


            <p>

                <strong>
                    Section:
                </strong>

                {{ $assignment
                    ->studentProfile
                    ->section
                    ?? '—' }}

            </p>

        </div>


        <div class="report-info-box">

            <h3>
                OJT Placement
            </h3>


            <p>

                <strong>
                    Company:
                </strong>

                {{ $assignment
                    ->company
                    ->name }}

            </p>


            <p>

                <strong>
                    Supervisor:
                </strong>

                {{ $assignment
                    ->supervisor
                    ->name }}

            </p>


            <p>

                <strong>
                    Start Date:
                </strong>

                {{ $assignment
                    ->start_date
                    ->format('F d, Y') }}

            </p>


            <p>

                <strong>
                    End Date:
                </strong>

                {{ $assignment
                    ->end_date
                    ?->format('F d, Y')
                    ?? '—' }}

            </p>


            <p>

                <strong>
                    Status:
                </strong>

                {{ ucfirst(
                    $assignment->status
                ) }}

            </p>

        </div>


    </div>


    <div class="report-summary-grid">


        <div class="report-summary-card">

            <span>
                Required Hours
            </span>

            <strong>

                {{ $completionSummary[
                    'requiredHoursLabel'
                ] }}

            </strong>

        </div>


        <div class="report-summary-card">

            <span>
                Validated Hours
            </span>

            <strong>

                {{ $completionSummary[
                    'validatedHoursLabel'
                ] }}

            </strong>

        </div>


        <div class="report-summary-card">

            <span>
                Remaining Hours
            </span>

            <strong>

                {{ $completionSummary[
                    'remainingHoursLabel'
                ] }}

            </strong>

        </div>


        <div class="report-summary-card">

            <span>
                Completion
            </span>

            <strong>

                {{ $completionSummary[
                    'completionPercentage'
                ] }}%

            </strong>

        </div>


    </div>


    <h2>
        Attendance and Daily Work Log Record
    </h2>


    <div class="table-wrapper">

        <table class="data-table">

            <thead>

            <tr>

                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Rendered</th>
                <th>Attendance</th>
                <th>Work Log</th>

            </tr>

            </thead>


            <tbody>


            @forelse ($attendanceRecords as $record)

                <tr>

                    <td>

                        {{ $record
                            ->attendance_date
                            ->format('M d, Y') }}

                    </td>


                    <td>

                        {{ $record
                            ->time_in
                            ?->timezone('Asia/Manila')
                            ->format('h:i A')
                            ?? '—' }}

                    </td>


                    <td>

                        {{ $record
                            ->time_out
                            ?->timezone('Asia/Manila')
                            ->format('h:i A')
                            ?? '—' }}

                    </td>


                    <td>

                        {{ $record
                            ->renderedHoursLabel() }}

                    </td>


                    <td>

                        {{ ucwords(
                            str_replace(
                                '_',
                                ' ',
                                $record->status
                            )
                        ) }}

                    </td>


                    <td>

                        {{ $record
                            ->dailyWorkLog
                            ? ucfirst(
                                $record
                                    ->dailyWorkLog
                                    ->status
                            )
                            : 'No Work Log' }}

                    </td>

                </tr>


            @empty

                <tr>

                    <td
                        colspan="6"
                        style="text-align: center;"
                    >
                        No attendance records.
                    </td>

                </tr>

            @endforelse


            </tbody>

        </table>

    </div>


    @if (
        $assignment->status
        === \App\Models\OjtAssignment::STATUS_COMPLETED
    )

        <div style="margin-top: 30px;">

            <h2>
                Formal Completion
            </h2>


            <p>

                <strong>
                    Completed By:
                </strong>

                {{ $assignment
                    ->completedBy
                    ?->name
                    ?? '—' }}

            </p>


            <p>

                <strong>
                    Completed At:
                </strong>

                {{ $assignment
                    ->completed_at
                    ?->timezone('Asia/Manila')
                    ->format(
                        'F d, Y h:i A'
                    )
                    ?? '—' }}

            </p>


            <p>

                <strong>
                    Completion Remarks:
                </strong>

                {{ $assignment
                    ->completion_remarks
                    ?? 'No remarks.' }}

            </p>

        </div>

    @endif


</div>


@endsection