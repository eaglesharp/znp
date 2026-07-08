<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantReport extends Model
{
    protected $table = 'applicant_reports';

    protected $fillable = [
        'job_apply_id',
        'company_id',
        'reason',
        'details',
        'status',
    ];

    public function jobApply()
    {
        return $this->belongsTo(JobApply::class, 'job_apply_id');
    }
}
