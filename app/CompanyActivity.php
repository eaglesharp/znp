<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyActivity extends Model
{
  

    protected $fillable = ['date','location','company_id'];
}
