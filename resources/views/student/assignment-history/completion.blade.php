@extends('layouts.app')


@section(
    'title',
    'Official OJT Completion Record | OJT Sync'
)


@push('styles')

<style>

    .completion-document {
        max-width: 1050px;

        margin: 0 auto;

        padding: 30px;

        background: #ffffff;

        border: 1px solid #dce3eb;

        border-radius: 14px;
    }

    .completion-document-header {
        text-align: center;

        padding-bottom: 20px;
        margin-bottom: 25px;

        border-bottom: 2px solid #1e3a5f;
    }

    .completion-document-header h1 {
        color: #1e3a5f;
    }

    .official-badge {
        display: inline-block;

        margin-top: 10px;
        padding: 7px 13px;

        border-radius: 999px;

        background: #dcfce7;
        color: #166534;

        font-weight: 700;
    }

    .info-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 20px;

        margin-bottom: 25px;
    }

    .info-box {
        padding: 18px;

        border-radius: 10px;

        background: #f8fafc;
    }

    .summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 14px;

        margin-bottom: 25px;
    }

    .summary-box {
        padding: 17px;

        text-align: center;

        border: 1px solid #dce3eb;
        border-radius: 10px;
    }

    .summary-box span {
        display: block;

        margin-bottom: 6px;

        color: #64748b;

        font-size: 12px;
    }

    .summary-box strong {
        color: #1e3a5f;

        font-size: 20px;
    }

    @media print {

        .app-header,
        .app-navigation,
        .print-controls {
            display: none !important;
        }

        .main-container {
            width: 100% !important;
            max-width: none !important;

            margin: 0 !important;
            padding: 0 !important;
        }

        .completion-document {
            border: none;

            max-width: none;

            padding: 0;
        }

    }

    @media (max-width: 700px) {

        .info-grid,
        .summary-grid {
            grid-template-columns: 1fr;
        }

    }

</style>

@endpush


@section('content')


<div
    class="print-controls"
    style="margin-bottom: 20px;"
>

    <button
        type="button"
        class="btn btn-primary"
        onclick="window.print();"
    >
        Print / Save as PDF
    </button>


    <a
        href="{{ route(
            'student.assignment-history.index'
        ) }}"
        class="btn btn-secondary"
    >
        Back to Assignment History
    </a>

</div>


<div class="completion-document">


    <div class="completion-document-header">

        <h1>
            OJT Sync
        </h1>

        <h2>
            Official OJT Completion Record
        </h2>

        <span class="official-badge">
            COMPLETED
        </span>

    </div>


    <div class="info-grid">


        <div class="info-box">

            <h3>
                Student Information
            </h3>

            <p>

                <strong>Name:</strong>

                {{ $assignment
                    ->studentProfile
                    ->user
                    ->name }}

            </p>

            <p>

                <strong>Student Number:</strong>

                {{ $assignment
                    ->studentProfile
                    ->student_number }}

            </p>

            <p>

                <strong>Program:</strong>

                {{ $assignment
                    ->studentProfile
                    ->program }}

            </p>

            <p>

                <strong>Year Level:</strong>

                {{ $assignment
                    ->studentProfile
                    ->year_level }}

            </p>

            <p>

                <strong>Section:</strong>

                {{ $assignment
                    ->studentProfile
                    ->section
                    ?? '—' }}

            </p>

        </div>


        <div class="info-box">

            <h3>
                OJT Placement
            </h3>

            <p>

                <strong>Company:</strong>

                {{ $assignment
                    ->company
                    ->name }}

            </p>

            <p>

                <strong>Supervisor:</strong>

                {{ $assignment
                    ->supervisor
                    ->name }}

            </p>

            <p>

                <strong>Start Date:</strong>

                {{ $assignment
                    ->start_date
                    ->format('F d, Y') }}

            </p>

            <p>

                <strong>End Date:</strong>

                {{ $assignment
                    ->end_date
                    ?->format('F d, Y')
                    ?? '—' }}

            </p>

            <p>

                <strong>Completed At:</strong>

                {{ $assignment
                    ->completed_at
                    ?->timezone(
                        'Asia/Manila'
                    )
                    ->format(
                        'F d, Y h:i A'
                    )
                    ?? '—' }}

            </p>

        </div>


    </div>


    <div class="summary-grid">


        <div class="summary-box">

            <span>
                Required Hours
            </span>

            <strong>

                {{ $completionSummary[
                    'requiredHoursLabel'
                ] }}

            </strong>

        </div>


        <div class="summary-box">

            <span>
                Validated Hours
            </span>

            <strong>

                {{ $completionSummary[
                    'validatedHoursLabel'
                ] }}

            </strong>

        </div>


        <div class="summary-box">

            <span>
                Validated Attendance
            </span>

            <strong>

                {{ $completionSummary[
                    'validatedAttendanceCount'
                ] }}

            </strong>

        </div>


        <div class="summary-box">

            <span>
                Validated Work Logs
            </span>

            <strong>

                {{ $completionSummary[
                    'validatedWorkLogs'
                ] }}

            </strong>

        </div>


    </div>


    {{-- ====================================================================
         FINAL SUPERVISOR EVALUATION
         ==================================================================== --}}

    <h2>
        Final Supervisor Evaluation
    </h2>


    @if ($assignment->finalEvaluation)

        @php

            $evaluation =
                $assignment
                    ->finalEvaluation;

        @endphp


        <div class="summary-grid">


            <div class="summary-box">

                <span>
                    Overall Rating
                </span>

                <strong>

                    {{ number_format(
                        $evaluation
                            ->overallRating(),
                        2
                    ) }}

                    / 5.00

                </strong>

            </div>


            <div class="summary-box">

                <span>
                    Performance
                </span>

                <strong>

                    {{ $evaluation
                        ->ratingLabel() }}

                </strong>

            </div>


            <div class="summary-box">

                <span>
                    Recommendation
                </span>

                <strong style="font-size: 15px;">

                    {{ $evaluation
                        ->recommendationLabel() }}

                </strong>

            </div>


            <div class="summary-box">

                <span>
                    Evaluated By
                </span>

                <strong style="font-size: 15px;">

                    {{ $evaluation
                        ->evaluator
                        ?->name
                        ?? '—' }}

                </strong>

            </div>


        </div>


        <div class="table-wrapper">

            <table class="data-table">

                <thead>

                <tr>

                    <th>Evaluation Criteria</th>
                    <th>Rating</th>

                </tr>

                </thead>


                <tbody>

                <tr>
                    <td>Attendance & Reliability</td>
                    <td>{{ $evaluation->attendance_reliability }} / 5</td>
                </tr>

                <tr>
                    <td>Quality of Work</td>
                    <td>{{ $evaluation->work_quality }} / 5</td>
                </tr>

                <tr>
                    <td>Initiative</td>
                    <td>{{ $evaluation->initiative }} / 5</td>
                </tr>

                <tr>
                    <td>Communication</td>
                    <td>{{ $evaluation->communication }} / 5</td>
                </tr>

                <tr>
                    <td>Professionalism</td>
                    <td>{{ $evaluation->professionalism }} / 5</td>
                </tr>

                <tr>
                    <td>Technical Competence</td>
                    <td>{{ $evaluation->technical_competence }} / 5</td>
                </tr>

                </tbody>

            </table>

        </div>


        <div style="margin-top: 20px;">

            <p>

                <strong>Strengths:</strong>

                <br>

                {{ $evaluation->strengths
                    ?? 'No comments provided.'
                }}

            </p>

            <p>

                <strong>Areas for Improvement:</strong>

                <br>

                {{ $evaluation
                    ->areas_for_improvement
                    ?? 'No comments provided.'
                }}

            </p>

            <p>

                <strong>Final Comments:</strong>

                <br>

                {{ $evaluation
                    ->final_comments
                    ?? 'No comments provided.'
                }}

            </p>

        </div>


    @else

        <p>
            No Final Supervisor Evaluation
            is attached to this historical record.
        </p>

    @endif


    <br>


    {{-- ====================================================================
         ATTENDANCE
         ==================================================================== --}}

    <h2>
        Attendance & Work Log Summary
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
                <th>Daily Work Log</th>

            </tr>

            </thead>


            <tbody>

            @foreach ($attendanceRecords as $record)

                <tr>

                    <td>

                        {{ $record
                            ->attendance_date
                            ->format('M d, Y') }}

                    </td>


                    <td>

                        {{ $record
                            ->time_in
                            ?->timezone(
                                'Asia/Manila'
                            )
                            ->format('h:i A')
                            ?? '—' }}

                    </td>


                    <td>

                        {{ $record
                            ->time_out
                            ?->timezone(
                                'Asia/Manila'
                            )
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

            @endforeach

            </tbody>

        </table>

    </div>


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
                Completion Date:
            </strong>

            {{ $assignment
                ->completed_at
                ?->timezone(
                    'Asia/Manila'
                )
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


</div>


@endsection