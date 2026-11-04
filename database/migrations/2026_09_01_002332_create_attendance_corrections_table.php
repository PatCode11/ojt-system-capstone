<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | Run Migration
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::create(
            'attendance_corrections',
            function (Blueprint $table): void {

                $table->engine =
                    'InnoDB';

                $table->id();


                /*
                |--------------------------------------------------------------------------
                | Related Attendance
                |--------------------------------------------------------------------------
                |
                | These references are nullable so the correction history can
                | remain available even if a related record is ever archived
                | or removed in the future.
                |
                */

                $table
                    ->foreignId(
                        'attendance_record_id'
                    )
                    ->nullable()
                    ->constrained(
                        'attendance_records'
                    )
                    ->nullOnDelete();

                $table
                    ->foreignId(
                        'attendance_session_id'
                    )
                    ->nullable()
                    ->constrained(
                        'attendance_sessions'
                    )
                    ->nullOnDelete();

                $table
                    ->foreignId(
                        'ojt_assignment_id'
                    )
                    ->nullable()
                    ->constrained(
                        'ojt_assignments'
                    )
                    ->nullOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Student Snapshot
                |--------------------------------------------------------------------------
                */

                $table
                    ->foreignId(
                        'student_user_id'
                    )
                    ->nullable()
                    ->constrained(
                        'users'
                    )
                    ->nullOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Correcting Administrator
                |--------------------------------------------------------------------------
                */

                $table
                    ->foreignId(
                        'corrected_by'
                    )
                    ->nullable()
                    ->constrained(
                        'users'
                    )
                    ->nullOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Attendance Identification
                |--------------------------------------------------------------------------
                */

                $table->date(
                    'attendance_date'
                );

                $table
                    ->unsignedTinyInteger(
                        'session_number'
                    )
                    ->nullable();


                /*
                |--------------------------------------------------------------------------
                | Original Session Values
                |--------------------------------------------------------------------------
                */

                $table
                    ->dateTime(
                        'original_time_in'
                    )
                    ->nullable();

                $table
                    ->dateTime(
                        'original_time_out'
                    )
                    ->nullable();

                $table
                    ->unsignedInteger(
                        'original_rendered_minutes'
                    )
                    ->default(0);


                /*
                |--------------------------------------------------------------------------
                | Corrected Session Values
                |--------------------------------------------------------------------------
                */

                $table
                    ->dateTime(
                        'corrected_time_in'
                    )
                    ->nullable();

                $table
                    ->dateTime(
                        'corrected_time_out'
                    )
                    ->nullable();

                $table
                    ->unsignedInteger(
                        'corrected_rendered_minutes'
                    )
                    ->default(0);


                /*
                |--------------------------------------------------------------------------
                | Daily Totals
                |--------------------------------------------------------------------------
                |
                | We also preserve the daily total before and after the
                | correction so the effect on the Student's OJT progress is
                | always visible.
                |
                */

                $table
                    ->unsignedInteger(
                        'original_daily_rendered_minutes'
                    )
                    ->default(0);

                $table
                    ->unsignedInteger(
                        'corrected_daily_rendered_minutes'
                    )
                    ->default(0);


                /*
                |--------------------------------------------------------------------------
                | Required Correction Reason
                |--------------------------------------------------------------------------
                */

                $table->text(
                    'reason'
                );


                /*
                |--------------------------------------------------------------------------
                | Request Audit Information
                |--------------------------------------------------------------------------
                */

                $table
                    ->string(
                        'ip_address',
                        45
                    )
                    ->nullable();

                $table
                    ->string(
                        'user_agent',
                        1000
                    )
                    ->nullable();


                /*
                |--------------------------------------------------------------------------
                | Immutable Correction Timestamp
                |--------------------------------------------------------------------------
                |
                | Corrections should not normally be edited later. Each new
                | change should create another correction record instead.
                |
                */

                $table
                    ->timestamp(
                        'created_at'
                    )
                    ->useCurrent();


                /*
                |--------------------------------------------------------------------------
                | Indexes
                |--------------------------------------------------------------------------
                */

                $table->index(
                    [
                        'attendance_record_id',
                        'created_at',
                    ],
                    'attendance_corrections_record_created_index'
                );

                $table->index(
                    [
                        'student_user_id',
                        'attendance_date',
                    ],
                    'attendance_corrections_student_date_index'
                );

                $table->index(
                    [
                        'corrected_by',
                        'created_at',
                    ],
                    'attendance_corrections_admin_created_index'
                );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Reverse Migration
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        Schema::dropIfExists(
            'attendance_corrections'
        );
    }
};