<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $token;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link,$token,$user)
    {
        $this->link = $link;
        $this->token = $token;
        $this->user = $user;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Reset Password Email';
        return $this->subject($subject)
            ->to($this->user->email)
            ->markdown('forgotPassword')
            ->with([
                'link' => $this->link,
            ]);

    }

}
