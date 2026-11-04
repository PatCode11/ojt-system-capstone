<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_work_logs', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Attendance Record
            |--------------------------------------------------------------------------
            |
            | One completed attendance record may have one Daily Work Log.
            |
            */

            $table->foreignId('attendance_record_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Student Work Information
            |--------------------------------------------------------------------------
            */

            $table->text('tasks_accomplished');

            $table->text('learnings')
                ->nullable();

            $table->text('challenges')
                ->nullable();

            $table->text('student_remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Submission
            |--------------------------------------------------------------------------
            */

            $table->dateTime('submitted_at');

            /*
            |--------------------------------------------------------------------------
            | Supervisor Validation
            |--------------------------------------------------------------------------
            |
            | pending   = waiting for Supervisor
            | validated = approved
            | rejected  = rejected and may be corrected/resubmitted
            |
            */

            $table->string('status', 30)
                ->default('pending')
                ->index();

            $table->text('supervisor_remarks')
                ->nullable();

            $table->foreignId('validated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('validated_at')
                ->nullable();

            $table->timestamps();

            $table->index([
                'status',
                'submitted_at',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_work_logs');
    }
};