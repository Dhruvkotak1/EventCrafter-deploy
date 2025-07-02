<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'booking_date',
        'number_of_tickets',
        'amount_paid',
        'status',
    ];

    // Default value logic for booking_date
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_date ??= now()->toDateString(); // e.g., '2025-06-15'
        });
    }

    // Customer who made the booking
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Event for which the booking was made
    public function event()
    {
        return $this->belongsTo(Event::class,'event_id');
    }

    public function feedback()
{
    return $this->hasOne(Feedback::class)->where('user_id', Auth::user()->id);
}
}
