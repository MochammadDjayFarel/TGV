<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_number',
        'departure_airport_id',
        'arrival_airport_id',
        'departure_time',
        'arrival_time',
        'airline_id',
        'pilot_id',
        'co_pilot_id',
        'status',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ];

    public function departureAirport()
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }

    public function arrivalAirport()
    {
        return $this->belongsTo(Airport::class, 'arrival_airport_id');
    }

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function pilot()
    {
        return $this->belongsTo(Pilot::class);
    }

    public function coPilot()
    {
        return $this->belongsTo(CoPilot::class, 'co_pilot_id');
    }
}
