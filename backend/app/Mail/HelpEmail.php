<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HelpEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    public $userID;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$body,$userID)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->userID = $userID;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $userData = \App\Models\User::where('id',$this->userID)->first();

        return $this->subject($this->subject)
            ->to('j.bucionis@uc.group')
            ->markdown('helpEmail')
            ->with([

                'body' => $this->body,
                'user' => $userData
            ]);
    }

}
