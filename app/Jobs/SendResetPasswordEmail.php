<?php

namespace App\Jobs;

use App\Mail\ResetPasswordEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendResetPasswordEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    public $email;
    public $otp;
    public function __construct($email,$otp)
    {
        $this->email = $email;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new ResetPasswordEmail($this->otp));
    }
}
