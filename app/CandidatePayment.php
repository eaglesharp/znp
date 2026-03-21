<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidatePayment extends Model
{
    
        protected $fillable =['payment_id','user_id','payment_status','amount','type'];
}
