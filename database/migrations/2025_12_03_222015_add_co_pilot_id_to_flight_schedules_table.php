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
        // Only modify if the table exists and the column is not already present
        if (Schema::hasTable('flight_schedules') && !Schema::hasColumn('flight_schedules', 'co_pilot_id')) {
            Schema::table('flight_schedules', function (Blueprint $table) {
                // co_pilot is optional -> nullable and null on delete
                $table->foreignId('co_pilot_id')->nullable()->constrained('co_pilots')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('flight_schedules') && Schema::hasColumn('flight_schedules', 'co_pilot_id')) {
            Schema::table('flight_schedules', function (Blueprint $table) {
                // guard drops to avoid exceptions if the FK was not created
                try {
                    $table->dropForeign(['co_pilot_id']);
                } catch (\Throwable $e) {
                    // ignore if foreign key doesn't exist
                }
                try {
                    $table->dropColumn('co_pilot_id');
                } catch (\Throwable $e) {
                    // ignore if column was already removed
                }
            });
        }
    }
};
