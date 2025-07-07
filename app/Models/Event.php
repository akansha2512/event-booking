<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Event extends Model
{
    // use HasFactory;
    use HasFactory, SoftDeletes;

    // Mass assignable fields (safe for create/update)
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'total_seats',
        'available_seats',
    ];

    // Relationship: one event has many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
