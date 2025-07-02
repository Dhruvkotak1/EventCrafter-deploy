<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Booking;
use App\Models\Event;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

     /**
     * Events created by this user (if organizer)
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function feedbacks(){
        return $this->hasMany(Feedback::class);
    }

    /**
     * Bookings made by this user (if customer)
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    /**
     * Check if user is a customer
     */
    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    /**
     * Check if user is an organizer
     */
    public function isOrganizer()
    {
        return $this->role === 'organizer';
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
