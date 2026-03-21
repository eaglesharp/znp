<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class VerifyEmail extends Notification
{
    // Determines the delivery channels
    public function via($notifiable)
    {
        return ['mail'];
    }

    // Builds the email message
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
    
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->view('emails.verifyemail', ['url' => $verificationUrl])->from('info@zeronoticeperiod.com')
            ->subject('Verify Your Email Address');
    }

    // Generates the verification URL
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
