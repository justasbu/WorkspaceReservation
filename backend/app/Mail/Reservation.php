<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reservation extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $userData = \App\Models\User::where('id',$this->reservation->user_id)->first();
        $workspaceData = \App\Models\Workspace::where('id',$this->reservation->workspace_id)->first();
        $subject = 'Reservation details';
        return $this->subject($subject)
            ->to($userData->email)
            ->markdown('reservationEmail')
            ->with([
                'reservation' => $this->reservation,
                'workspace' => $workspaceData
            ]);
    }
}
