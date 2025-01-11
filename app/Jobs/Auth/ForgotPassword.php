<?php

namespace App\Jobs\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ForgotPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $_email;
    protected $_token;

    public function __construct($email, $token)
    {
        $this->_email = $email;
        $this->_token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mailTo = $this->_email;
        $data = array(
            'email' => $this->_email,
            'token' => $this->_token
        );
        Mail::send('email.auth.forgot-password', $data, function($message) use($mailTo) {
            $message->to($mailTo);
            $message->subject('Permintaan perubahan kata sandi '.$mailTo.'');
        });   
    }
}
