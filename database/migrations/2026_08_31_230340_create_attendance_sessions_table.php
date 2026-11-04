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
        Schema::create(
            'attendance_sessions',
            function (Blueprint $table): void {
                /*
                |--------------------------------------------------------------------------
                | Storage Engine
                |--------------------------------------------------------------------------
                |
                | The project uses InnoDB so foreign keys and transactional
                | attendance operations work correctly.
                |
                */

                $table->engine = 'InnoDB';

                /*
                |--------------------------------------------------------------------------
                | Primary Key
                |--------------------------------------------------------------------------
                */

                $table->id();

                /*
                |--------------------------------------------------------------------------
                | Parent Daily Attendance Record
                |--------------------------------------------------------------------------
                |
                | One attendance record represents one Student OJT day.
                |
                | Example:
                |
                | attendance_records
                | September 1, 2026
                |
                | attendance_sessions
                | Session 1: 8:00 AM - 12:00 PM
                | Session 2: 1:00 PM - 5:00 PM
                |
                */

                $table
                    ->foreignId(
                        'attendance_record_id'
                    )
                    ->constrained(
                        'attendance_records'
                    )
                    ->cascadeOnDelete();

                /*
                |--------------------------------------------------------------------------
                | Session Number
                |--------------------------------------------------------------------------
                |
                | Normal OJT schedule:
                |
                | 1 = Morning Session
                | 2 = Afternoon Session
                |
                */

                $table->unsignedTinyInteger(
                    'session_number'
                );

                /*
                |--------------------------------------------------------------------------
                | Time In
                |--------------------------------------------------------------------------
                */

                $table->dateTime(
                    'time_in'
                );

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
                );

                $table->string(
                    'time_in_selfie_path'
                );

                /*
                |--------------------------------------------------------------------------
                | Time Out
                |--------------------------------------------------------------------------
                |
                | These columns remain nullable while the Student is
                | currently working inside the session.
                |
                */

                $table
                    ->dateTime(
                        'time_out'
                    )
                    ->nullable();

                $table
                    ->decimal(
                        'time_out_latitude',
                        10,
                        7
                    )
                    ->nullable();

                $table
                    ->decimal(
                        'time_out_longitude',
                        10,
                        7
                    )
                    ->nullable();

                $table
                    ->decimal(
                        'time_out_accuracy',
                        8,
                        2
                    )
                    ->nullable();

                $table
                    ->string(
                        'time_out_selfie_path'
                    )
                    ->nullable();

                /*
                |--------------------------------------------------------------------------
                | Rendered Time
                |--------------------------------------------------------------------------
                |
                | Stored as minutes to avoid floating-point hour problems.
                |
                | Example:
                |
                | 4 hours = 240 minutes
                | 8 hours = 480 minutes
                |
                */

                $table
                    ->unsignedInteger(
                        'rendered_minutes'
                    )
                    ->default(0);

                /*
                |--------------------------------------------------------------------------
                | Laravel Timestamps
                |--------------------------------------------------------------------------
                */

                $table->timestamps();

                /*
                |--------------------------------------------------------------------------
                | Constraints
                |--------------------------------------------------------------------------
                |
                | An attendance day cannot have two Session 1 records
                | or two Session 2 records.
                |
                */

                $table->unique(
                    [
                        'attendance_record_id',
                        'session_number',
                    ],
                    'attendance_sessions_record_session_unique'
                );

                /*
                |--------------------------------------------------------------------------
                | Index
                |--------------------------------------------------------------------------
                */

                $table->index(
                    [
                        'attendance_record_id',
                        'time_in',
                    ],
                    'attendance_sessions_record_time_in_index'
                );
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'attendance_sessions'
        );
    }
};