<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantEvent extends Model
{
    public $timestamps = false;

    protected $table = 'applicant_events';

    protected $fillable = [
        'job_apply_id',
        'job_id',
        'company_id',
        'type',
        'label',
        'meta',
        'created_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
    ];

    public function jobApply()
    {
        return $this->belongsTo(JobApply::class, 'job_apply_id');
    }
}
