<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $fillable = ['user_id','company_id','emailed','subject','description'];
}
