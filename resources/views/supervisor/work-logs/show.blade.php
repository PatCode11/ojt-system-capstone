@extends('layouts.app')


@section('title', 'Review Daily Work Log | OJT Sync')


@section('content')


<div class="page-heading">

    <h1>
        Review Daily Work Log
    </h1>

    <p>
        Review the Student's attendance information
        and daily OJT accomplishments.
    </p>

</div>


@if ($errors->any())

    <div class="alert alert-danger">

        <ul style="padding-left: 20px;">

            @foreach ($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


@php

    $attendance =
        $workLog->attendanceRecord;

    $assignment =
        $attendance->ojtAssignment;

    $student =
        $assignment->studentProfile;

@endphp


<div class="content-grid">


    <div class="panel">

        <h2>
            Student Information
        </h2>


        <p>

            <strong>
                Student:
            </strong>

            {{ $student->user->name }}

        </p>


        <p>

            <strong>
                Student Number:
            </strong>

            {{ $student->student_number }}

        </p>


        <p>

            <strong>
                Program:
            </strong>

            {{ $student->program }}

        </p>


        <p>

            <strong>
                Company:
            </strong>

            {{ $assignment->company->name }}

        </p>

    </div>


    <div class="panel">

        <h2>
            Attendance
        </h2>


        <p>

            <strong>
                Date:
            </strong>

            {{ $attendance
                ->attendance_date
                ->format('F d, Y') }}

        </p>


        <p>

            <strong>
                Time In:
            </strong>

            {{ $attendance
                ->time_in
                ?->timezone('Asia/Manila')
                ->format('h:i A')
                ?? '—' }}

        </p>


        <p>

            <strong>
                Time Out:
            </strong>

            {{ $attendance
                ->time_out
                ?->timezone('Asia/Manila')
                ->format('h:i A')
                ?? '—' }}

        </p>


        <p>

            <strong>
                Rendered:
            </strong>

            {{ $attendance
                ->renderedHoursLabel() }}

        </p>


        <p>

            <strong>
                Attendance Status:
            </strong>

            {{ ucwords(
                str_replace(
                    '_',
                    ' ',
                    $attendance->status
                )
            ) }}

        </p>

    </div>


</div>


<br>


<div class="panel">

    <h2>
        Tasks / Activities Accomplished
    </h2>

    <p style="white-space: pre-line;">
        {{ $workLog->tasks_accomplished }}
    </p>

</div>


<br>


<div class="content-grid">


    <div class="panel">

        <h2>
            Learnings / Skills Gained
        </h2>

        <p style="white-space: pre-line;">

            {{ $workLog->learnings
                ?? 'No information provided.' }}

        </p>

    </div>


    <div class="panel">

        <h2>
            Challenges Encountered
        </h2>

        <p style="white-space: pre-line;">

            {{ $workLog->challenges
                ?? 'No information provided.' }}

        </p>

    </div>


</div>


<br>


@if ($workLog->student_remarks)

    <div class="panel">

        <h2>
            Student Remarks
        </h2>

        <p style="white-space: pre-line;">
            {{ $workLog->student_remarks }}
        </p>

    </div>

    <br>

@endif


@if (
    $attendance->status
    !== \App\Models\AttendanceRecord::STATUS_VALIDATED
)

    <div class="alert alert-warning">

        This Student's attendance has not yet been validated.

        You may review or reject this Work Log,
        but attendance must be validated before
        approving the Work Log.

    </div>

@endif


@if (
    $workLog->status
    === \App\Models\DailyWorkLog::STATUS_PENDING
)

<div class="content-grid">


    <div class="panel">

        <h2>
            Validate Work Log
        </h2>

        <p>
            Approve the Student's submitted
            Daily Work Log.
        </p>


        <form
            method="POST"
            action="{{ route(
                'supervisor.work-logs.approve',
                $workLog
            ) }}"
        >

            @csrf
            @method('PUT')


            <div class="form-group">

                <label class="form-label">
                    Supervisor Remarks
                </label>

                <textarea
                    name="remarks"
                    class="form-control"
                    rows="4"
                    placeholder="Optional remarks..."
                >{{ old('remarks') }}</textarea>

            </div>


            <button
                type="submit"
                class="btn btn-success"
                onclick="
                    return confirm(
                        'Validate this Daily Work Log?'
                    );
                "
            >
                Validate Work Log
            </button>

        </form>

    </div>


    <div class="panel">

        <h2>
            Reject Work Log
        </h2>

        <p>
            Reject the Work Log and explain
            what the Student must correct.
        </p>


        <form
            method="POST"
            action="{{ route(
                'supervisor.work-logs.reject',
                $workLog
            ) }}"
        >

            @csrf
            @method('PUT')


            <div class="form-group">

                <label class="form-label">
                    Rejection Reason
                </label>

                <textarea
                    name="remarks"
                    class="form-control"
                    rows="4"
                    placeholder="Explain what needs to be corrected..."
                    required
                >{{ old('remarks') }}</textarea>

            </div>


            <button
                type="submit"
                class="btn btn-warning"
                onclick="
                    return confirm(
                        'Reject this Daily Work Log?'
                    );
                "
            >
                Reject Work Log
            </button>

        </form>

    </div>


</div>

@endif


<br>


<a
    href="{{ route(
        'supervisor.work-logs.index'
    ) }}"
    class="btn btn-secondary"
>
    ← Back to Work Logs
</a>


@endsection