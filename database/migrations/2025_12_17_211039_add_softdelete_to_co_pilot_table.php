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
        Schema::table('co_pilots', function (Blueprint $table) {
            if (! Schema::hasColumn('co_pilots', 'deleted_at')) {
                $table->softDeletes(); // otomatis membuat TIMESTAMP NULL 'deleted_at'
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('co_pilots', function (Blueprint $table) {
            if (Schema::hasColumn('co_pilots', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });
    }
};
