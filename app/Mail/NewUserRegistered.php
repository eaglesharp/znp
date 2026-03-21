<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserRegistered extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('info@zeronoticeperiod.com')
    ->to($this->user->email)
    ->subject('Candidate Account Created On ZNP Team')
    ->view('emails.new_user_registered')
    ->with([
        'name' => $this->user->first_name,
        'title' => $this->user->email,
        'content' => $this->password,
        'link' => route('login'),
    ]);
        return $this->view('view.name');
    }
}
