@extends('layouts.app')


@section('title', 'Correct Daily Work Log | OJT Sync')


@section('content')


<div class="page-heading">

    <h1>
        Correct Daily Work Log
    </h1>

    <p>
        Update the rejected Work Log and
        submit it again for Supervisor review.
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


@if ($workLog->supervisor_remarks)

    <div class="alert alert-danger">

        <strong>
            Supervisor Remarks:
        </strong>

        {{ $workLog->supervisor_remarks }}

    </div>

@endif


<div class="form-card">


<form
    method="POST"
    action="{{ route(
        'student.work-logs.update',
        $workLog
    ) }}"
>

    @csrf
    @method('PUT')


    <div class="form-group">

        <label class="form-label">
            Attendance Date
        </label>

        <input
            type="text"
            class="form-control"
            value="{{ $workLog
                ->attendanceRecord
                ->attendance_date
                ->format('F d, Y') }}"
            disabled
        >

    </div>


    <div class="form-group">

        <label class="form-label">
            Tasks / Activities Accomplished
        </label>

        <textarea
            name="tasks_accomplished"
            class="form-control"
            rows="7"
            required
        >{{ old(
            'tasks_accomplished',
            $workLog->tasks_accomplished
        ) }}</textarea>

    </div>


    <div class="form-group">

        <label class="form-label">
            Learnings / Skills Gained
        </label>

        <textarea
            name="learnings"
            class="form-control"
            rows="5"
        >{{ old(
            'learnings',
            $workLog->learnings
        ) }}</textarea>

    </div>


    <div class="form-group">

        <label class="form-label">
            Challenges Encountered
        </label>

        <textarea
            name="challenges"
            class="form-control"
            rows="4"
        >{{ old(
            'challenges',
            $workLog->challenges
        ) }}</textarea>

    </div>


    <div class="form-group">

        <label class="form-label">
            Additional Remarks
        </label>

        <textarea
            name="student_remarks"
            class="form-control"
            rows="4"
        >{{ old(
            'student_remarks',
            $workLog->student_remarks
        ) }}</textarea>

    </div>


    <button
        type="submit"
        class="btn btn-primary"
    >
        Resubmit Work Log
    </button>


    <a
        href="{{ route(
            'student.work-logs.index'
        ) }}"
        class="btn btn-secondary"
    >
        Cancel
    </a>

</form>


</div>


@endsection