<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantFeedback extends Model
{
    protected $table = 'applicant_feedbacks';

    protected $fillable = [
        'job_apply_id',
        'company_id',
        'verdict',
        'comments',
    ];

    public function jobApply()
    {
        return $this->belongsTo(JobApply::class, 'job_apply_id');
    }
}
