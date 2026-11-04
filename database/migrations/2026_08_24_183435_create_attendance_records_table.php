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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | OJT Assignment
            |--------------------------------------------------------------------------
            */

            $table->foreignId('ojt_assignment_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Attendance Date
            |--------------------------------------------------------------------------
            */

            $table->date('attendance_date');

            /*
            |--------------------------------------------------------------------------
            | Time In
            |--------------------------------------------------------------------------
            */

            $table->dateTime('time_in');

            $table->decimal(
                'time_in_latitude',
                10,
                7
            );

            $table->decimal(
                'time_in_longitude',
                10,
                7
            );

            $table->decimal(
                'time_in_accuracy',
                8,
                2
            )->nullable();

            $table->string(
                'time_in_selfie_path',
                500
            );

            /*
            |--------------------------------------------------------------------------
            | Time Out
            |--------------------------------------------------------------------------
            */

            $table->dateTime('time_out')
                ->nullable();

            $table->decimal(
                'time_out_latitude',
                10,
                7
            )->nullable();

            $table->decimal(
                'time_out_longitude',
                10,
                7
            )->nullable();

            $table->decimal(
                'time_out_accuracy',
                8,
                2
            )->nullable();

            $table->string(
                'time_out_selfie_path',
                500
            )->nullable();

            /*
            |--------------------------------------------------------------------------
            | Rendered Time
            |--------------------------------------------------------------------------
            |
            | Store minutes instead of decimal hours.
            |
            | Example:
            |
            | 8 hours 30 minutes = 510 minutes
            |
            */

            $table->unsignedInteger(
                'rendered_minutes'
            )->nullable();

            /*
            |--------------------------------------------------------------------------
            | Supervisor Validation
            |--------------------------------------------------------------------------
            |
            | in_progress = Student has Timed In
            | pending     = Student has Timed Out; waiting for Supervisor
            | validated   = Supervisor approved
            | rejected    = Supervisor rejected
            |
            */

            $table->string('status', 30)
                ->default('in_progress')
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

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Daily Attendance
            |--------------------------------------------------------------------------
            */

            $table->unique(
                [
                    'ojt_assignment_id',
                    'attendance_date',
                ],
                'attendance_assignment_date_unique'
            );

            $table->index([
                'attendance_date',
                'status',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'attendance_records'
        );
    }
};