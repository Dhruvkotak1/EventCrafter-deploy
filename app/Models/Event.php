<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;
use App\Models\User;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'date',
        'time',
        'venue',
        'price',
        'total_tickets',
        'tickets_booked',
        'image',
    ];

    // Organizer (user who created the event)
    public function organizer()
    {
        return $this->belongsTo(User::class);
    }

    // All bookings for this event
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    // Custom accessor: tickets left
    public function getTicketsLeftAttribute()
    {
        return $this->total_tickets - $this->tickets_booked;
    }
}
