<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoPilot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'license_number',
        'date_of_birth',
        'phone',
        'address',
    ];

    public function flightSchedules()
    {
        return $this->hasMany(FlightSchedule::class);
    }
}
