<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantNote extends Model
{
    protected $table = 'applicant_notes';

    protected $fillable = [
        'job_apply_id',
        'job_id',
        'company_id',
        'user_id',
        'body',
    ];

    public function jobApply()
    {
        return $this->belongsTo(JobApply::class, 'job_apply_id');
    }
}
