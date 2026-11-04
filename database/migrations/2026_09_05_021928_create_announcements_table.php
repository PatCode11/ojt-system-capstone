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
            'announcements',
            function (
                Blueprint $table
            ): void {
                $table->id();


                /*
                |--------------------------------------------------------------------------
                | Announcement Content
                |--------------------------------------------------------------------------
                */

                $table->string(
                    'title',
                    255
                );


                $table->text(
                    'message'
                );


                /*
                |--------------------------------------------------------------------------
                | Audience
                |--------------------------------------------------------------------------
                |
                | Allowed application values:
                |
                | all
                | students
                | supervisors
                |
                */

                $table
                    ->string(
                        'audience',
                        30
                    )
                    ->default(
                        'students'
                    );


                /*
                |--------------------------------------------------------------------------
                | Publication
                |--------------------------------------------------------------------------
                |
                | published_at:
                | null = draft
                |
                | expires_at:
                | null = announcement does not automatically expire
                |
                */

                $table
                    ->dateTime(
                        'published_at'
                    )
                    ->nullable();


                $table
                    ->dateTime(
                        'expires_at'
                    )
                    ->nullable();


                /*
                |--------------------------------------------------------------------------
                | Administrator Who Created It
                |--------------------------------------------------------------------------
                |
                | nullOnDelete preserves the announcement even if the historical
                | Administrator account is later removed.
                |
                */

                $table
                    ->foreignId(
                        'created_by'
                    )
                    ->nullable()
                    ->constrained(
                        'users'
                    )
                    ->nullOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Laravel Timestamps
                |--------------------------------------------------------------------------
                */

                $table->timestamps();


                /*
                |--------------------------------------------------------------------------
                | Indexes
                |--------------------------------------------------------------------------
                |
                | These improve the Student mobile queries when filtering visible
                | and active announcements.
                |
                */

                $table->index(
                    [
                        'audience',
                        'published_at',
                    ],
                    'announcements_audience_published_index'
                );


                $table->index(
                    'expires_at',
                    'announcements_expires_at_index'
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
            'announcements'
        );
    }
};