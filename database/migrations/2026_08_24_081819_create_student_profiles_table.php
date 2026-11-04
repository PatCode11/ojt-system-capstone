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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('student_number', 50)
                ->unique();

            $table->string('program', 150);

            $table->string('year_level', 30);

            $table->string('section', 50)
                ->nullable();

            $table->string('contact_number', 30);

            $table->text('address');

            $table->string('emergency_contact_name')
                ->nullable();

            $table->string('emergency_contact_number', 30)
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};