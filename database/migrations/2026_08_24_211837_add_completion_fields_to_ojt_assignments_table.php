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
        Schema::table('ojt_assignments', function (Blueprint $table) {
            /*
            |--------------------------------------------------------------------------
            | Formal OJT Completion
            |--------------------------------------------------------------------------
            */

            $table->foreignId('completed_by')
                ->nullable()
                ->after('notes')
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('completed_at')
                ->nullable()
                ->after('completed_by');

            $table->text('completion_remarks')
                ->nullable()
                ->after('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ojt_assignments', function (Blueprint $table) {
            $table->dropConstrainedForeignId(
                'completed_by'
            );

            $table->dropColumn([
                'completed_at',
                'completion_remarks',
            ]);
        });
    }
};