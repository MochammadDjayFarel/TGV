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
    Schema::table('ticket_payments', function (Blueprint $table) {
        $table->string('barcode_path')->nullable()->after('barcode');
    });
}

public function down(): void
{
    Schema::table('ticket_payments', function (Blueprint $table) {
        $table->dropColumn('barcode_path');
    });
}

};
