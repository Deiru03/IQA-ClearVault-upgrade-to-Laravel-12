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
        Schema::table('clearances', function (Blueprint $table) {
            $table->enum('type', ['Part-Time', 'Part-Time-FullTime', 'Permanent-Temporary', 'Permanent-FullTime', 'Dean', 'Program-Head', 'Admin-Staff'])->nullable()->change();
            // $table->timestamp('date_completed')->nullable()->after('number_of_requirements');
        });

        Schema::table('user_clearances', function (Blueprint $table) {
            $table->timestamp('date_completed')->nullable()->after('status');
            $table->timestamp('last_uploaded')->nullable()->after('date_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clearances', function (Blueprint $table) {
            $table->enum('type', ['Part-Time', 'Part-Time-FullTime', 'Permanent-Temporary', 'Permanent-FullTime', 'Dean', 'Program-Head'])->nullable()->change();
            // $table->dropColumn('date_completed');
        });
        Schema::table('user_clearances', function (Blueprint $table) {
            $table->dropColumn('date_completed');
            $table->dropColumn('last_uploaded');
        });
    }
};
