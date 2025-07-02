<?php

namespace App\Jobs;

use App\Mail\BookingConfirmed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmedEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $email;
    public $user;
    public $event;
    public $booking;
    public function __construct($email,$user,$event,$booking)
    {
        $this->email = $email;
        $this->user = $user;
        $this->event = $event;
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      Mail::to($this->email)->send(new BookingConfirmed($this->user,$this->event,$this->booking));  
    }
}
