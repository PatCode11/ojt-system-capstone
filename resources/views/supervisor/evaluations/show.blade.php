@extends('layouts.app')


@section('title', 'Final Evaluation | OJT Sync')


@push('styles')

<style>

    .evaluation-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 16px;

        margin-bottom: 24px;
    }

    .evaluation-stat {
        padding: 18px;

        background: #ffffff;

        border: 1px solid #dce3eb;
        border-radius: 12px;
    }

    .evaluation-stat span {
        display: block;

        margin-bottom: 7px;

        color: #64748b;

        font-size: 12px;
    }

    .evaluation-stat strong {
        color: #1e3a5f;

        font-size: 21px;
    }

    .score-table {
        width: 100%;

        border-collapse: collapse;

        margin-bottom: 22px;
    }

    .score-table th,
    .score-table td {
        padding: 12px;

        border: 1px solid #dce3eb;

        text-align: left;
    }

    .score-table th {
        background: #f8fafc;
    }

    @media (max-width: 800px) {

        .evaluation-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }

    @media (max-width: 550px) {

        .evaluation-grid {
            grid-template-columns: 1fr;
        }

    }

</style>

@endpush


@section('content')


<div class="page-heading">

    <h1>
        Final Supervisor Evaluation
    </h1>

    <p>
        Evaluate the Student's overall OJT
        performance and completion readiness.
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


<div class="content-grid">


    <div class="panel">

        <h2>
            Student Information
        </h2>

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

            <strong>Company:</strong>

            {{ $assignment
                ->company
                ->name }}

        </p>

    </div>


    <div class="panel">

        <h2>
            OJT Assignment
        </h2>

        <p>

            <strong>Status:</strong>

            {{ ucfirst(
                $assignment->status
            ) }}

        </p>

        <p>

            <strong>Required:</strong>

            {{ $summary[
                'requiredHoursLabel'
            ] }}

        </p>

        <p>

            <strong>Validated:</strong>

            {{ $summary[
                'validatedHoursLabel'
            ] }}

        </p>

        <p>

            <strong>Progress:</strong>

            {{ $summary[
                'completionPercentage'
            ] }}%

        </p>

    </div>


</div>


<br>


<div class="evaluation-grid">


    <div class="evaluation-stat">

        <span>
            Validated Attendance
        </span>

        <strong>

            {{ $summary[
                'validatedAttendanceCount'
            ] }}

        </strong>

    </div>


    <div class="evaluation-stat">

        <span>
            Validated Work Logs
        </span>

        <strong>

            {{ $summary[
                'validatedWorkLogs'
            ] }}

        </strong>

    </div>


    <div class="evaluation-stat">

        <span>
            Remaining Hours
        </span>

        <strong>

            {{ $summary[
                'remainingHoursLabel'
            ] }}

        </strong>

    </div>


    <div class="evaluation-stat">

        <span>
            Evaluation Status
        </span>

        <strong>

            {{ $assignment->finalEvaluation
                ? 'Submitted'
                : (
                    $summary['evaluationReady']
                        ? 'Ready'
                        : 'Not Ready'
                )
            }}

        </strong>

    </div>


</div>


@if (
    ! $summary['evaluationReady']
    && ! $assignment->finalEvaluation
)

    <div class="alert alert-warning">

        <strong>
            Final Evaluation is not yet available.
        </strong>

        <br><br>

        The following requirements must be
        resolved first:

        <ul style="padding-left: 20px; margin-top: 10px;">

            @foreach (
                $summary['evaluationBlockers']
                as $blocker
            )

                <li>
                    {{ $blocker }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


@php

    $evaluation =
        $assignment->finalEvaluation;

    $canEdit =
        $evaluation
        && $assignment->status
            === \App\Models\OjtAssignment::STATUS_ACTIVE;

    $showForm =
        (
            ! $evaluation
            && $summary['evaluationReady']
        )
        || $canEdit;

@endphp


@if ($evaluation)

    <div class="panel">

        <h2>
            Current Final Evaluation
        </h2>


        <div class="evaluation-grid">


            <div class="evaluation-stat">

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


            <div class="evaluation-stat">

                <span>
                    Performance
                </span>

                <strong>

                    {{ $evaluation
                        ->ratingLabel() }}

                </strong>

            </div>


            <div class="evaluation-stat">

                <span>
                    Recommendation
                </span>

                <strong>

                    {{ $evaluation
                        ->recommendationLabel() }}

                </strong>

            </div>


            <div class="evaluation-stat">

                <span>
                    Evaluated At
                </span>

                <strong style="font-size: 15px;">

                    {{ $evaluation
                        ->evaluated_at
                        ?->timezone(
                            'Asia/Manila'
                        )
                        ->format(
                            'M d, Y h:i A'
                        )
                        ?? '—' }}

                </strong>

            </div>


        </div>


        <table class="score-table">

            <thead>

            <tr>

                <th>Criteria</th>
                <th>Score</th>

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


        <p>

            <strong>
                Strengths:
            </strong>

            <br>

            {{ $evaluation->strengths
                ?? 'No comments provided.'
            }}

        </p>


        <p>

            <strong>
                Areas for Improvement:
            </strong>

            <br>

            {{ $evaluation
                ->areas_for_improvement
                ?? 'No comments provided.'
            }}

        </p>


        <p>

            <strong>
                Final Comments:
            </strong>

            <br>

            {{ $evaluation
                ->final_comments
                ?? 'No comments provided.'
            }}

        </p>

    </div>


    <br>

@endif


@if ($showForm)

    <div class="form-card">

        <h2>

            {{ $evaluation
                ? 'Update Final Evaluation'
                : 'Complete Final Evaluation'
            }}

        </h2>


        <div class="alert alert-info">

            <strong>Rating Scale:</strong>

            5 = Outstanding,
            4 = Very Good,
            3 = Good,
            2 = Fair,
            1 = Needs Improvement.

        </div>


        <form
            method="POST"
            action="{{ $evaluation
                ? route(
                    'supervisor.evaluations.update',
                    $assignment
                )
                : route(
                    'supervisor.evaluations.store',
                    $assignment
                )
            }}"
        >

            @csrf


            @if ($evaluation)

                @method('PUT')

            @endif


            @php

                $criteria = [
                    'attendance_reliability' =>
                        'Attendance & Reliability',

                    'work_quality' =>
                        'Quality of Work',

                    'initiative' =>
                        'Initiative',

                    'communication' =>
                        'Communication',

                    'professionalism' =>
                        'Professionalism',

                    'technical_competence' =>
                        'Technical Competence',
                ];

            @endphp


            @foreach (
                $criteria as $field => $label
            )

                <div class="form-group">

                    <label class="form-label">
                        {{ $label }}
                    </label>


                    <select
                        name="{{ $field }}"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Select Rating
                        </option>


                        @for ($score = 5; $score >= 1; $score--)

                            <option
                                value="{{ $score }}"
                                @selected(
                                    old(
                                        $field,
                                        $evaluation?->{$field}
                                    ) == $score
                                )
                            >

                                {{ $score }}

                                —

                                @switch($score)

                                    @case(5)
                                        Outstanding
                                        @break

                                    @case(4)
                                        Very Good
                                        @break

                                    @case(3)
                                        Good
                                        @break

                                    @case(2)
                                        Fair
                                        @break

                                    @default
                                        Needs Improvement

                                @endswitch

                            </option>

                        @endfor

                    </select>

                </div>

            @endforeach


            <div class="form-group">

                <label class="form-label">
                    Student Strengths
                </label>

                <textarea
                    name="strengths"
                    class="form-control"
                    rows="4"
                    placeholder="Describe the Student's strongest qualities..."
                >{{ old(
                    'strengths',
                    $evaluation?->strengths
                ) }}</textarea>

            </div>


            <div class="form-group">

                <label class="form-label">
                    Areas for Improvement
                </label>

                <textarea
                    name="areas_for_improvement"
                    class="form-control"
                    rows="4"
                    placeholder="Describe areas where the Student can still improve..."
                >{{ old(
                    'areas_for_improvement',
                    $evaluation?->areas_for_improvement
                ) }}</textarea>

            </div>


            <div class="form-group">

                <label class="form-label">
                    Final Comments
                </label>

                <textarea
                    name="final_comments"
                    class="form-control"
                    rows="5"
                    placeholder="Provide final Supervisor comments..."
                >{{ old(
                    'final_comments',
                    $evaluation?->final_comments
                ) }}</textarea>

            </div>


            <div class="form-group">

                <label class="form-label">
                    Final Recommendation
                </label>

                <select
                    name="recommendation"
                    class="form-control"
                    required
                >

                    <option value="">
                        Select Recommendation
                    </option>


                    <option
                        value="recommended"
                        @selected(
                            old(
                                'recommendation',
                                $evaluation?->recommendation
                            ) === 'recommended'
                        )
                    >
                        Recommended for Completion
                    </option>


                    <option
                        value="needs_improvement"
                        @selected(
                            old(
                                'recommendation',
                                $evaluation?->recommendation
                            ) === 'needs_improvement'
                        )
                    >
                        Needs Improvement
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="btn btn-success"
                onclick="
                    return confirm(
                        'Submit this Final Supervisor Evaluation?'
                    );
                "
            >

                {{ $evaluation
                    ? 'Update Evaluation'
                    : 'Submit Final Evaluation'
                }}

            </button>

        </form>

    </div>

@endif


<br>


<a
    href="{{ route(
        'supervisor.evaluations.index'
    ) }}"
    class="btn btn-secondary"
>
    Back to Final Evaluations
</a>


@endsection