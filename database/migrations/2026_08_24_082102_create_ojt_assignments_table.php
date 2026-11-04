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
        Schema::create('ojt_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_profile_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('company_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('supervisor_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->unsignedInteger('required_hours');

            $table->date('start_date');

            $table->date('end_date')
                ->nullable();

            $table->string('status', 30)
                ->default('pending')
                ->index();

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->index([
                'student_profile_id',
                'status',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ojt_assignments');
    }
};