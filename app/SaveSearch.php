<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaveSearch extends Model
{
    protected $fillable = ['search_value','location','search','notice_period','min_salary','max_salary',

       'min_exp',
       'max_exp',
       'filter_resume',
       'interview_avail',
       'education',
       'course',
       'specilation',
       'gender',
       'job_type',
       'filter'



];
}
