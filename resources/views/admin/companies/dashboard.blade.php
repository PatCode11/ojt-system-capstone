@extends('layouts.app')


@section('title', 'Admin Dashboard | OJT Sync')


@section('content')

<div class="page-heading">

    <h1>
        Administrator Dashboard
    </h1>

    <p>
        Monitor OJT students, supervisors,
        establishments and system activity.
    </p>

</div>


<div class="dashboard-grid">

    <div class="stat-card">

        <div class="stat-label">
            OJT Students
        </div>

        <div class="stat-value">
            —
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            Supervisors
        </div>

        <div class="stat-value">
            —
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            Companies
        </div>

        <div class="stat-value">
            —
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            Pending Validation
        </div>

        <div class="stat-value">
            —
        </div>

    </div>

</div>


<div class="content-grid">

    <div class="panel">

        <h2>
            OJT Establishments
        </h2>

        <p>
            Manage companies where students
            complete their internship.
        </p>

        <a
            href="{{ route('admin.companies.index') }}"
            class="btn btn-primary"
        >
            Manage Companies
        </a>

    </div>


    <div class="panel">

        <h2>
            Reports
        </h2>

        <p>
            Attendance, timesheet and rendered-hour
            reports will appear here later.
        </p>

    </div>

</div>

@endsection