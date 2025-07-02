<?php

namespace App\Jobs;

use App\Mail\BookingCancelled;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBookingCancelledEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $event;
    public $booking;
    public $email;

    public function __construct($user, $event, $booking, $email)
    {
        $this->user = (object) $user;
        $this->event = (object) $event;
        $this->booking = (object) $booking;
        $this->email = $email;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new BookingCancelled($this->user, $this->event, $this->booking));
    }
}

