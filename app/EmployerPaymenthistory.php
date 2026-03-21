<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerPaymenthistory extends Model
{
    protected $fillable = ['payment_id','plan','amount','employer_id','package_start_date','package_end_date'];
}
