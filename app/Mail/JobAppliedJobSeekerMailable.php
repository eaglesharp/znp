<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class JobAppliedJobSeekerMailable extends Mailable
{

    use SerializesModels;

    public $job;
    public $jobApply;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($job, $jobApply)
    {
        $this->job = $job;
        $this->jobApply = $jobApply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $company = $this->job->getCompany();
        $user = $this->jobApply->getUser();       
        $dt = Carbon::now();
        $today = $dt->toFormattedDateString();  

        return $this->from(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->replyTo(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->to($user->email, $user->first_name)
                        ->subject('You applied for '.$this->job->job_title.'job on '.$today)
                        ->view('emails.job_applied_job_seeker_message')
                        ->with(
                                [
                                    'job_title' => $this->job->job_title,
                                    'job_location' => $this->job->location,
                                    'company_name' => $company->name,
                                    'date' => $today,
                                    'user_name' => $user->first_name,
                                    'company_link' => route('company.detail', $company->slug),
                                    'job_link' => route('job.detail', [$this->job->slug])
                                ]
        );
    }

}
