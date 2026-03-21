<?php

namespace App\Mail;

use App\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KYCEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $company_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $company = Company::where('id',$this->company_id)->first();
        return $this->to("employer@zeronoticeperiod.com")
        ->subject('KYC Application Submitted')
            ->view('emails.kyc_applied')
            ->with(
                    [
                        'name' => $company->name,   
                        'id' => $company->id,                       
                    ]
    );
    
}
}
