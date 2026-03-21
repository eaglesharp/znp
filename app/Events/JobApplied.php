<?php

namespace App\Events;

use App\PostJob;
use App\JobApply;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class JobApplied
{

    use SerializesModels;

    public $job;
    public $jobApply;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PostJob $job, JobApply $jobApply)
    {
      //  Log::alert('its coming job applied calss');
        $this->job = $job;
        $this->jobApply = $jobApply;
    }

}
