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
        if (!Schema::hasTable('flight_schedules')) {
            Schema::create('flight_schedules', function (Blueprint $table) {
                $table->id();
                $table->string('flight_number');
                $table->foreignId('departure_airport_id')->constrained('airports');
                $table->foreignId('arrival_airport_id')->constrained('airports');
                $table->foreignId('airline_id')->constrained('airlines');
                $table->foreignId('pilot_id')->constrained('pilots');
                // co-pilot is optional -> nullable and cascade/null on delete
                $table->foreignId('co_pilot_id')->nullable()->constrained('co_pilots')->nullOnDelete();
                $table->datetime('departure_time');
                $table->datetime('arrival_time');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_schedules');
    }
};
