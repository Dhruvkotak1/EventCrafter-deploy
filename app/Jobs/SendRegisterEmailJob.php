<?php

namespace App\Jobs;

use App\Mail\RegisterEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendRegisterEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    public $email;
    public $username;
    public $role;
    public function __construct($email,$username,$role)
    {
        $this->email = $email;
        $this->username = $username;
        $this->role = $role;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new RegisterEmail($this->username,$this->role));
    }
}
