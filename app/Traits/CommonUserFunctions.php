<?php

namespace App\Traits;

use DB;
use File;
use ImgUploader;
use App\User;
use App\ProfileSummary;
use App\ProfileProject;
use App\ProfileExperience;
use App\ProfileEducation;
use App\ProfileSkill;
use App\ProfileLanguage;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Traits\Active;
use App\ProfileDetails;
use App\ProfileNop;
use App\KeySkill;

trait CommonUserFunctions
{

    use Active;

    private function deleteUserImage($id)
    {
        try {
            // dd('imgae coming');
            $user = User::findOrFail($id);
            // dd($user);
            $image = $user->image;
            if (!empty($image)) {        
                File::delete(ImgUploader::real_public_path() . 'user_images/' . $image);
            }
           
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }
	
	private function deleteUserCoverImage($id)
    {
        try {
            $user = User::findOrFail($id);
            $cover_image = $user->image;
            if (!empty($cover_image)) {
                File::delete(ImgUploader::real_public_path() . 'user_images/thumb/' . $cover_image);
                File::delete(ImgUploader::real_public_path() . 'user_images/mid/' . $cover_image);
                File::delete(ImgUploader::real_public_path() . 'user_images/' . $cover_image);
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }
    public function deleteUserInformations($user_id)
    {
    
    try {
        ProfileDetails::where('user_id', '=', $user_id)->delete();            
        ProfileSummary::where('user_id', '=', $user_id)->delete();
        ProfileNop::where('user_id', '=', $user_id)->delete();
        KeySkill::where('user_id', $user_id)->delete();
        ProfileEducation::where('user_id', '=', $user_id)->delete();
        ProfileExperience::where('user_id', '=', $user_id)->delete();
        ProfileSkill::where('user_id', '=', $user_id)->delete();
        ProfileLanguage::where('user_id', '=', $user_id)->delete();    
        ProfileProject::where('user_id', '=', $user_id)->delete();    
        //$user = User::findOrFail($user_id);
        $user = User::where('id',$user_id)->first();      
        $user->delete();

        return 'ok';   

 } catch (ModelNotFoundException $e) {
            return 'notok';
        }


    }

    public function deleteAllProfileResumes($id)
    {
         try {
            // dd('imgae coming');
            $user = User::findOrFail($id);
            // dd($user);
            $resume = $user->resume;
            $destinationPath = "cvs";
            if (!empty($resume)) {        
                File::delete(ImgUploader::real_public_path() . $destinationPath.  $resume);
            }else{
                //dd('value is not there');
            }
           
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }
	
	

    public function deleteUser(Request $request)
    {
        $user_id = $request->input('id');
        try {
          
          $this->deleteUserImage($user_id); 
          $this->deleteAllProfileResumes($user_id);  
          $this->deleteUserInformations($user_id);
          echo 'ok';

        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }
    public function deleteAllUsersList(Request $request)
     {
         $user_id_array = $request->input('id');
       //  dd($user_id_array);
       
         //dd($user);
        if($user_id_array)
        {
            foreach($user_id_array as $user)
            {

            $user_id = intval($user);
            $this->deleteUserImage($user_id); 
            $this->deleteAllProfileResumes($user_id);  
            $this->deleteUserInformations($user_id);
            
            }
            
                  
            echo 'ok';

        }    

     }

    public function updateImmediateAvailableStatus(Request $request)
    {
        $id = $request->input('user_id');
        $old_status = $request->input('old_status');
        try {
            $user = User::findOrFail($id);
            $user->is_immediate_available = !$old_status;
            $user->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    private function updateUserFullTextSearch($user)
    {
        $str = '';
        $str .= $user->getName();
        $str .= ' ' . $user->getCountry('country');
        $str .= ' ' . $user->getState('state');
        $str .= ' ' . $user->getCity('city');
        $str .= ' ' . $user->father_name;
        $str .= ' ' . $user->date_of_birth->format('Y-m-d');
        $str .= ' ' . $user->phone;
        $str .= ' ' . $user->mobile_num;
        $str .= ' ' . $user->getGender('gender');
        $str .= ' ' . $user->getJobExperience('job_experience');
        $str .= ' ' . $user->current_salary . ' - ' . $user->expected_salary;
        $str .= ' ' . $user->getCareerLevel('career_level');
        $str .= ' ' . $user->getIndustry('industry');
        $str .= ' ' . $user->getFunctionalArea('functional_area');
        $str .= ' ' . $user->street_address;
        $str .= ' ' . $user->getProfileSkillsStr();

        $user->search = $str;
        $user->update();
    }

    public static function countNumJobSeekers($field = 'country_id', $value = '')
    {
        if (!empty($value)) {

            if ($field == 'industry_id') {
                return User::where('industry_id', $value)->active()->count('id');
            }
            if ($field == 'job_skill_id') {
                $job_seeker_ids = ProfileSkill::where('job_skill_id', '=', $value)->pluck('user_id')->toArray();
                return User::whereIn('id', array_unique($job_seeker_ids))->active()->count('id');
            }
            if ($field == 'functional_area_id') {
                return User::where('functional_area_id', '=', $value)->active()->count('id');
            }
            if ($field == 'careel_level_id') {
                return User::where('careel_level_id', '=', $value)->active()->count('id');
            }
            if ($field == 'gender_id') {
                return User::where('gender_id', '=', $value)->active()->count('id');
            }
            if ($field == 'job_experience_id') {
                return User::where('job_experience_id', '=', $value)->active()->count('id');
            }
            if ($field == 'country_id') {
                return User::where('country_id', '=', $value)->active()->count('id');
            }
            if ($field == 'state_id') {
                return User::where('state_id', '=', $value)->active()->count('id');
            }
            if ($field == 'city_id') {
                return User::where('city_id', '=', $value)->active()->count('id');
            }
        }
    }

}
