<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class DeleteToken implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    public $token;
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::table('password_reset_tokens')->where('token',$this->token)->delete();
    }
}
