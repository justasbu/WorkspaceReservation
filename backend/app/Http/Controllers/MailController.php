<?php

namespace App\Http\Controllers;

use App\Mail\HelpEmail;
use App\Mail\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    // Method sends an email about successful reservation
    public function sendMail($reservation)
    {

        $reservationData = \App\Models\Reservation::where('id', $reservation)->first();


        Mail::send(new \App\Mail\Reservation($reservationData));

    }

    // Method sends email from Help tab
    public function sendHelpEmail(Request $request)
    {

        $subject = $request->subject;
        $body = $request->body;
        $userId = $request->userID;
        Mail::send(new \App\Mail\HelpEmail($subject, $body, $userId));

    }

    // Method sends email from Help tab
    public function sendResetPasswordEmail(Request $request)
    {

        $subject = $request->subject;
        $body = $request->body;
        $userId = $request->userID;
        Mail::send(new \App\Mail\HelpEmail($subject, $body, $userId));

    }


}


