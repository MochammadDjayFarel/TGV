<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TicketPayment;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_code',
        'img',
        'flight_schedule_id',
        'price',
        'ticket_type',
        'status',
        'user_id',
    ];

    public function flightSchedule()
    {
        return $this->belongsTo(FlightSchedule::class);
    }

    // semua payment
    public function ticketPayments()
    {
        return $this->hasMany(TicketPayment::class);
    }

    // payment terakhir (PALING PENTING UNTUK RIWAYAT)
    public function ticketPayment()
    {
        return $this->hasOne(TicketPayment::class)->latestOfMany();
    }
}
