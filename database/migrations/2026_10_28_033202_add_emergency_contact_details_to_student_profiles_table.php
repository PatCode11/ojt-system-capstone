
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
        Schema::table('student_profiles', function (Blueprint $table) {

            $table->string(
                'emergency_contact_relationship',
                100
            )->nullable()->after('emergency_contact_number');

            $table->text(
                'emergency_contact_address'
            )->nullable()->after('emergency_contact_relationship');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {

            $table->dropColumn([
                'emergency_contact_relationship',
                'emergency_contact_address',
            ]);

        });
    }
};
