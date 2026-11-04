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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Actor
            |--------------------------------------------------------------------------
            |
            | Nullable because some events, such as failed login attempts,
            | happen before a User has authenticated.
            |
            */

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Event
            |--------------------------------------------------------------------------
            */

            $table->string(
                'action',
                100
            );

            $table->string(
                'description',
                500
            );

            /*
            |--------------------------------------------------------------------------
            | Audited Model
            |--------------------------------------------------------------------------
            |
            | Examples:
            |
            | App\Models\User
            | App\Models\OjtAssignment
            | App\Models\AttendanceRecord
            | App\Models\DailyWorkLog
            |
            */

            $table->nullableMorphs(
                'auditable'
            );

            /*
            |--------------------------------------------------------------------------
            | Safe Additional Information
            |--------------------------------------------------------------------------
            */

            $table->json('metadata')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Security Context
            |--------------------------------------------------------------------------
            */

            $table->string(
                'ip_address',
                45
            )->nullable();

            $table->string(
                'user_agent',
                500
            )->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'action',
                'created_at',
            ]);

            $table->index(
                'created_at'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'audit_logs'
        );
    }
};