<?php

namespace App;

use DB;
use App;
use App\Traits\Active;
use App\Traits\Status;
use App\Traits\Featured;
use App\Traits\JobTrait;


use Illuminate\Database\Eloquent\Model;

class PostJob extends Model
{

    use Active;
    use Status;
    use featured;
    use JobTrait;


    protected $table = 'post_jobs';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at', 'expiry_date'];

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id', 'id');
    }

    public function getCompany($field = '')
    {
        if (null !== $company = $this->company()->first()) {
            if (!empty($field)) {
                return $company->$field;
            } else {
                return $company;
            }
        }
    }

    public function jobSkills()
    {
        return $this->hasMany('App\JobSkillManager', 'job_id', 'id');
    }

    public function getJobSkillsArray()
    {
        return $this->jobSkills->pluck('job_skill_id')->toArray();
    }

    public function getJobSkillsStr()
    {
        $str = '';
        if ($this->jobSkills->count()) {
            $jobSkills = $this->jobSkills;
            foreach ($jobSkills as $jobSkillManager) {
                
                $str .= ' ' . $jobSkillManager->getJobSkill('job_skill');
            }
        }
        return $str;
    }

    public function getJobSkillsList()
    {
        $str = '';
        if ($this->jobSkills->count()) {
            $jobSkills = $this->jobSkills;
            foreach ($jobSkills as $jobSkillManager) {
                $skill = $jobSkillManager->getJobSkill();
                $str .= '<li><a href="' . route('job.list', ['job_skill_id[]' => $skill->job_skill_id]) . '">' . $skill->job_skill . '</a></li>';
            }
        }
        return $str;
    }

    

    /*     * ****************************** */

    public function appliedUsers()
    {
        return $this->hasMany('App\JobApply', 'job_id', 'id');
    }

    public function getAppliedUserIdsArray()
    {
        return $this->appliedUsers->pluck('user_id')->toArray();
    }

    /*     * ***************************** */

}
