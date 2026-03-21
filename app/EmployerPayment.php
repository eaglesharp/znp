<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerPayment extends Model
{
    protected $fillable =['payment_id','user_id','invoice_no','payment_status','amount','payment_activity','plan_id','company_id','invoice','invoice_status','plan_start_date','plan_end_date','singlecv_videointerview','payment_method','singlecv_videointerview','plan_start_date','plan_end_date','	user_id'];



    
}
