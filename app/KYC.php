<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KYC extends Model
{
    protected $guarded = [];


    public function kycdocuments()
    {
        return $this->belongsTo('App\Company','company_id','id');
    }
}
