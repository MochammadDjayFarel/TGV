<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// contoh migration: php artisan make:migration add_promo_fields_to_ticket_payments_table
    public function up()
    {
        Schema::table('ticket_payments', function (Blueprint $table) {
            $table->string('promo_code')->nullable()->after('barcode_path');
            $table->bigInteger('original_price')->nullable()->after('promo_code');
            $table->bigInteger('discount_amount')->nullable()->after('original_price');
            $table->bigInteger('final_amount')->nullable()->after('discount_amount');
        });
    }

    public function down()
    {
        Schema::table('ticket_payments', function (Blueprint $table) {
            $table->dropColumn(['promo_code', 'original_price', 'discount_amount', 'final_amount']);
        });
    }

};
