<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = [
        'counter', 'counter1',
        'active_jobs', 'permanent_jobs', 'contract_jobs', 'fresher_jobs',
    ];
}
