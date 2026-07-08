<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantEmail extends Model
{
    protected $table = 'applicant_emails';

    protected $fillable = [
        'job_apply_id',
        'job_id',
        'company_id',
        'user_id',
        'recipient_email',
        'subject',
        'body',
        'template_id',
        'send_scope',
        'status',
        'error',
    ];

    public function jobApply()
    {
        return $this->belongsTo(JobApply::class, 'job_apply_id');
    }
}
