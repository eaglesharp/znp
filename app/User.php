<?php

namespace App;

use Auth;
use App\JobSkill;
use App\CompanyMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\CountryStateCity;
use App\Traits\CommonUserFunctions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\ProfileLanguage;
use App\KeySkill;
use App\UserLocation;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    // use SoftDeletes;
    use Notifiable;
    use CountryStateCity;
    use CommonUserFunctions;
    use \Conner\Tagging\Taggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'resume',
        'is_active',
        'verified',
        'email_verified',
        'phone_verified',
        'no_profile_views',
        'no_of_downloads',
        'no_of_emails',
        'complete',
        'profile_completion',
        'current_city',
        'recruiter_comments',
        'added',
        'interview_dates',
        'ignore_companies',
        'reason_moved',
        'recruiter_email',
        'recruiter_phone',
        'hide_show',
        'recorded_video',
        'email_verified_at',
        'added_by'

    ];
    protected $dates = ['created_at', 'updated_at', 'date_of_birth', 'package_start_date', 'package_end_date'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function profileSummary()
    {
        return $this->hasMany('App\ProfileSummary', 'user_id', 'id');
    }

    public function profilekeyskill()
    {
        return $this->hasMany('App\KeySkill', 'user_id', 'id');
    }

    public function userlocation()
    {
        return $this->hasMany('App\UserLocation', 'user_id', 'id');
    }

    public function profileNop()
    {
        return $this->hasMany('App\ProfileNop', 'user_id', 'id');
    }
    public function getprofileNop()
    {

        $nop = ProfileNop::where('user_id', '=', $this->id)->first();

        return $nop;
    }


    public function ProfileCityJobsCity()
    {
        return $this->hasMany('App\ProfileCityJobsCity', 'user_id', 'id');
    }
    public function getprofileJobCity()
    {

        $nop = ProfileCityJobsCity::where('user_id', '=', $this->id)->first();

        return $nop;
    }

    public function getedu()
    {

        $nop = ProfileEducation::where('user_id', '=', $this->id)->first();


        return $nop;
    }

    public function getoffers()
    {
        $offers = Offers::where('user_id', '=', $this->id)->first();
        return $offers;

    }



    public function showCvs()
    {
        $file = User::where('id', '=', $this->id)->first();
        return $file;
    }


    public function gettime()
    {
        $date = Carbon::now();

        return $date;
    }


    public static function geteducation()
    {

        $education = Education::all();
        return $education;

    }






    public function profileDetails()
    {
        return $this->hasMany('App\ProfileDetails', 'user_id', 'id');
    }

    public function interViews()
    {
        return $this->hasMany('App\Interview', 'user_id', 'id');
    }


    public function getprofileGap()
    {

        $nop = ProfileGap::where('user_id', '=', $this->id)->first();

        return $nop;
    }
    public function profileGap()
    {
        return $this->hasMany('App\ProfileGap', 'user_id', 'id');
    }
    public function getprofileDetails()
    {

        $nop = ProfileDetails::where('user_id', '=', $this->id)->first();

        return $nop;
    }


    public function getsummaries()
    {
        $summary = ProfileSummary::where('user_id', '=', $this->id)->first();
        return $summary;

    }

    public function getProfileSummary($field = '')
    {
        if (null !== $this->profileSummary->first()) {
            $profileSummary = $this->profileSummary->first();
            if ($field != '') {
                return $profileSummary->$field;
            } else {
                return $profileSummary;
            }
        } else {
            return '';
        }
    }

    public function profileProjects()
    {
        return $this->hasMany('App\ProfileProject', 'user_id', 'id');
    }

    public function getProfileProjectsArray()
    {
        return $this->profileProjects->pluck('id')->toArray();
    }

    public function getDefaultCv()
    {
        $cv = ProfileCv::where('user_id', '=', $this->id)->where('is_default', '=', 1)->first();

        if (null === $cv)
            $cv = ProfileCv::where('user_id', '=', $this->id)->first();

        return $cv;
    }

    public function profileCvs()
    {
        return $this->hasMany('App\ProfileCv', 'user_id', 'id');
    }




    public function certificates()
    {
        return $this->hasMany('App\Certificate', 'user_id', 'id');
    }

    public function getcertificatesArray()
    {
        return $this->certificates->pluck('id')->toArray();
    }

    public function countcertificates()
    {
        return $this->certificates->count();
    }



    public function getProfileCvsArray()
    {
        return $this->profileCvs->pluck('id')->toArray();
    }

    public function countProfileCvs()
    {
        return $this->profileCvs->count();
    }

    public function profileExperience()
    {
        return $this->hasMany('App\ProfileExperience', 'user_id', 'id');
    }

    public function profileEducation()
    {
        return $this->hasMany('App\ProfileEducation', 'user_id', 'id');
    }

    public function profileSkills()
    {
        return $this->hasMany('App\ProfileSkill', 'user_id', 'id');
    }

    public function getProfileSkills()
    {
        return $this->profileSkills->get();
    }

    public function getProfileSkillsStr()
    {
        $profileSkills = $this->profileSkills()->get();
        $str = '';
        if ($profileSkills !== null) {
            foreach ($profileSkills as $profileSkill) {
                $jobSkill = JobSkill::where('job_skill_id', '=', $profileSkill->job_skill_id)->lang()->first();
                $str .= ' ' . $jobSkill->job_skill;
            }
        }
        return $str;
    }

    public function profileLanguages()
    {
        return $this->hasMany('App\ProfileLanguage', 'user_id', 'id');
    }

    public function favouriteJobs()
    {
        return $this->hasMany('App\FavouriteJob', 'user_id', 'id');
    }

    public function getFavouriteJobSlugsArray()
    {
        return $this->favouriteJobs->pluck('job_slug')->toArray();
    }

    public function isFavouriteJob($job_slug)
    {
        $return = false;
        if (Auth::check()) {
            $count = FavouriteJob::where('user_id', Auth::user()->id)->where('job_slug', 'like', $job_slug)->count();
            if ($count > 0)
                $return = true;
        }
        return $return;
    }

    public function favouriteCompanies()
    {
        return $this->hasMany('App\FavouriteCompany', 'user_id', 'id');
    }

    public function getFavouriteCompanies()
    {
        return $this->favouriteCompanies->pluck('company_slug')->toArray();
    }

    /*     * ****************************** */

    public function isAppliedOnJob($job_id)
    {
        $return = false;
        if (Auth::check()) {
            $count = JobApply::where('user_id', Auth::user()->id)->where('job_id', '=', $job_id)->count();
            if ($count > 0)
                $return = true;
        }
        return $return;
    }

    public function appliedJobs()
    {
        return $this->hasMany('App\JobApply', 'user_id', 'id');
    }

    public function getAppliedJobIdsArray()
    {
        return $this->appliedJobs->pluck('job_id')->toArray();
    }

    /*     * ***************************** */

    public function isFavouriteCompany($company_slug)
    {
        $return = false;
        if (Auth::check()) {
            $count = FavouriteCompany::where('user_id', Auth::user()->id)->where('company_slug', 'like', $company_slug)->count();
            if ($count > 0)
                $return = true;
        }
        return $return;
    }

    public function printUserImage($width = 50, $height = 50, $radius = 50)
    {

        $image = (string) $this->image;
        $image = (!empty($image)) ? $image : 'no-no-image.gif';
        return \ImgUploader::print_image("user_images/$image", $width, $height, '/admin_assets/no-image.png', $this->getName());
    }

    public function printUserCoverImage($width = 0, $height = 0)
    {
        $cover_image = (string) $this->cover_image;
        $cover_image = (!empty($cover_image)) ? $cover_image : 'no-no-image.gif';
        return \ImgUploader::print_image("user_images/$cover_image", $width, $height, '/admin_assets/no-cover.jpg', $this->name);
    }

    public function getName()
    {
        $html = '';
        if (!empty($this->first_name))
            $html .= $this->first_name;

        if (!empty($this->middle_name))
            $html .= ' ' . $this->middle_name;

        if (!empty($this->last_name))
            $html .= ' ' . $this->last_name;

        return $html;
    }

    public function getAge()
    {
        if (
            (!empty((string) $this->date_of_birth)) && (null !== $this->date_of_birth)
        ) {
            return $this->date_of_birth->age;
        }
    }

    public function careerLevel()
    {
        return $this->belongsTo('App\CareerLevel', 'career_level_id', 'career_level_id');
    }

    public function recruiter()
    {
        return $this->belongsTo('App\Admin', 'added_by', 'id');
    }

    public function getCareerLevel($field = '')
    {
        $careerLevel = $this->careerLevel()->lang()->first();
        if (null === $careerLevel) {
            $careerLevel = $this->careerLevel()->first();
        }
        if (null !== $careerLevel) {
            if (!empty($field))
                return $careerLevel->$field;
            else
                return $careerLevel;
        }
    }

    public function jobExperience()
    {
        return $this->belongsTo('App\JobExperience', 'job_experience_id', 'job_experience_id');
    }

    public function getJobExperience($field = '')
    {
        $jobExperience = $this->jobExperience()->lang()->first();
        if (null === $jobExperience) {
            $jobExperience = $this->jobExperience()->first();
        }
        if (null !== $jobExperience) {
            if (!empty($field))
                return $jobExperience->$field;
            else
                return $jobExperience;
        }
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender', 'gender_id', 'gender_id');
    }

    public function getGender($field = '')
    {
        $gender = $this->gender()->lang()->first();
        if (null === $gender) {
            $gender = $this->gender()->first();
        }
        if (null !== $gender) {
            if (!empty($field))
                return $gender->$field;
            else
                return $gender;
        }
    }

    public function maritalStatus()
    {
        return $this->belongsTo('App\MaritalStatus', 'marital_status_id', 'marital_status_id');
    }

    public function getMaritalStatus($field = '')
    {
        $maritalStatus = $this->maritalStatus()->lang()->first();
        if (null === $maritalStatus) {
            $maritalStatus = $this->maritalStatus()->first();
        }
        if (null !== $maritalStatus) {
            if (!empty($field))
                return $maritalStatus->$field;
            else
                return $maritalStatus;
        }
    }

    public function followingCompanies()
    {
        return $this->hasMany('App\FavouriteCompany', 'user_id', 'id');
    }

    public function getFollowingCompaniesSlugArray()
    {
        return $this->followingCompanies()->pluck('company_slug')->toArray();
    }

    public function countFollowings()
    {
        return FavouriteCompany::where('user_id', '=', $this->id)->count();
    }

    public function countApplicantMessages()
    {
        return ApplicantMessage::where('user_id', '=', $this->id)->where('is_read', '=', 0)->count();
    }

    public function package()
    {
        return $this->hasOne('App\Package', 'id', 'package_id');
    }

    public function getPackage($field = '')
    {
        $package = $this->package()->first();
        if (null !== $package) {
            if (!empty($field)) {
                return $package->$field;
            } else {
                return $package;
            }
        }
    }

    public function industry()
    {
        return $this->belongsTo('App\Industry', 'industry_id', 'industry_id');
    }

    public function getIndustry($field = '')
    {
        $industry = $this->industry()->lang()->first();
        if (null === $industry) {
            $industry = $this->industry()->first();
        }
        if (null !== $industry) {
            if (!empty($field))
                return $industry->$field;
            else
                return $industry;
        }
    }

    public function functionalArea()
    {
        return $this->belongsTo('App\FunctionalArea', 'functional_area_id', 'functional_area_id');
    }

    public function getFunctionalArea($field = '')
    {
        $functionalArea = $this->functionalArea()->lang()->first();
        if (null === $functionalArea) {
            $functionalArea = $this->functionalArea()->first();
        }
        if (null !== $functionalArea) {
            if (!empty($field))
                return $functionalArea->$field;
            else
                return $functionalArea;
        }
    }
    public function countUserMessages()
    {

        return CompanyMessage::where('seeker_id', '=', $this->id)->where('status', '=', 'unviewed')->where('type', '=', 'message')->count();

    }

    public function countMessages($id)
    {

        return CompanyMessage::where('seeker_id', '=', $this->id)->where('company_id', '=', $id)->where('status', '=', 'unviewed')->where('type', '=', 'message')->count();

    }
}
