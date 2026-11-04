@extends('layouts.app')


@section('title', 'Create Daily Work Log | OJT Sync')


@section('content')


<div class="page-heading">

    <h1>
        Create Daily Work Log
    </h1>

    <p>
        Record the tasks, activities and experiences
        completed during your OJT duty.
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


@if ($attendanceRecords->count() === 0)

    <div class="alert alert-warning">

        You do not have a completed attendance record
        available for a new Daily Work Log.

    </div>


    <a
        href="{{ route(
            'student.work-logs.index'
        ) }}"
        class="btn btn-secondary"
    >
        Back
    </a>

@else


<div class="form-card">


    <form
        method="POST"
        action="{{ route(
            'student.work-logs.store'
        ) }}"
    >

        @csrf


        <div class="form-group">

            <label class="form-label">
                OJT Attendance Date
            </label>


            <select
                name="attendance_record_id"
                class="form-control"
                required
            >

                <option value="">
                    Select Attendance Date
                </option>


                @foreach ($attendanceRecords as $attendance)

                    <option
                        value="{{ $attendance->id }}"
                        @selected(
                            old('attendance_record_id')
                            == $attendance->id
                        )
                    >

                        {{ $attendance
                            ->attendance_date
                            ->format('F d, Y') }}

                        —

                        {{ $attendance
                            ->renderedHoursLabel() }}

                        —

                        {{ ucfirst(
                            $attendance->status
                        ) }}

                    </option>

                @endforeach

            </select>

        </div>


        <div class="form-group">

            <label class="form-label">
                Tasks / Activities Accomplished
            </label>


            <textarea
                name="tasks_accomplished"
                class="form-control"
                rows="7"
                placeholder="Describe the tasks and activities you completed during your OJT duty..."
                required
            >{{ old('tasks_accomplished') }}</textarea>

        </div>


        <div class="form-group">

            <label class="form-label">
                Learnings / Skills Gained
            </label>


            <textarea
                name="learnings"
                class="form-control"
                rows="5"
                placeholder="What did you learn today?"
            >{{ old('learnings') }}</textarea>

        </div>


        <div class="form-group">

            <label class="form-label">
                Challenges Encountered
            </label>


            <textarea
                name="challenges"
                class="form-control"
                rows="4"
                placeholder="Describe any challenges you encountered..."
            >{{ old('challenges') }}</textarea>

        </div>


        <div class="form-group">

            <label class="form-label">
                Additional Remarks
            </label>


            <textarea
                name="student_remarks"
                class="form-control"
                rows="4"
                placeholder="Optional additional remarks..."
            >{{ old('student_remarks') }}</textarea>

        </div>


        <button
            type="submit"
            class="btn btn-primary"
        >
            Submit Daily Work Log
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


@endif


@endsection