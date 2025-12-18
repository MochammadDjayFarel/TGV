<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TicketPayment extends Model
{
    protected $fillable = [
        'ticket_id',
        'promo_id',
        'barcode',
        'barcode_path',
        'states',
        'booked_date',
        'paid_date',
        'promo_code',
        'original_price',
        'discount_amount',
        'final_amount',
    ];

    protected $casts = [
        'booked_date' => 'date',
        'paid_date' => 'date',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public static function generateBarcode()
    {
        return 'BAR-' . strtoupper(Str::random(10));
    }

        public function promo()
    {
        return $this->belongsTo(Promo::class);
    }
}
