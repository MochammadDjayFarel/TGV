<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'city',
        'country',
    ];

    public function departureSchedules()
    {
        return $this->hasMany(FlightSchedule::class, 'departure_airport_id');
    }

    public function arrivalSchedules()
    {
        return $this->hasMany(FlightSchedule::class, 'arrival_airport_id');
    }
}
