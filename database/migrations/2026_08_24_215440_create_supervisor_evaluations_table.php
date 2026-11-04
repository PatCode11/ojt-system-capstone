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
        Schema::create('supervisor_evaluations', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | OJT Assignment
            |--------------------------------------------------------------------------
            |
            | One OJT Assignment may have only one final evaluation.
            |
            */

            $table->foreignId('ojt_assignment_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Evaluation Criteria
            |--------------------------------------------------------------------------
            |
            | 5 = Outstanding
            | 4 = Very Good
            | 3 = Good
            | 2 = Fair
            | 1 = Needs Improvement
            |
            */

            $table->unsignedTinyInteger(
                'attendance_reliability'
            );

            $table->unsignedTinyInteger(
                'work_quality'
            );

            $table->unsignedTinyInteger(
                'initiative'
            );

            $table->unsignedTinyInteger(
                'communication'
            );

            $table->unsignedTinyInteger(
                'professionalism'
            );

            $table->unsignedTinyInteger(
                'technical_competence'
            );

            /*
            |--------------------------------------------------------------------------
            | Written Evaluation
            |--------------------------------------------------------------------------
            */

            $table->text('strengths')
                ->nullable();

            $table->text('areas_for_improvement')
                ->nullable();

            $table->text('final_comments')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Final Recommendation
            |--------------------------------------------------------------------------
            |
            | recommended
            | needs_improvement
            |
            */

            $table->string(
                'recommendation',
                30
            )->index();

            /*
            |--------------------------------------------------------------------------
            | Evaluation Audit
            |--------------------------------------------------------------------------
            */

            $table->foreignId('evaluated_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->dateTime('evaluated_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'supervisor_evaluations'
        );
    }
};