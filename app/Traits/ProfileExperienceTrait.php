<?php

namespace App\Traits;

use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\User;
use App\ProfileExperience;
use App\Country;
use App\ProfileGap;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ProfileExperienceFormRequest;
use App\Http\Requests\ProfileGapRequest;
use App\Helpers\DataArrayHelper;
use Illuminate\Support\Str;

trait ProfileExperienceTrait
{


    public function showProfileExperience(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $html = '';
        if (isset($user) && count($user->profileExperience)):
            foreach ($user->profileExperience as $experience):
                if ($experience->is_currently_working == 1)
                    $date_end = 'Currently working';
                else
                    $date_end = $experience->date_end->format('d M, Y');

                $html .= '<!--experience Start-->
            <div class="col-md-12" id="experience_' . $experience->id . '">
              <div class="mt-element-ribbon bg-grey-steel">
                <div class="ribbon ribbon-color-warning uppercase ">' . $experience->title . '</div>
                <p class="ribbon-content">
				' . $experience->company . '<br />               	
                ' . $experience->date_start->format('d M, Y') . ' - ' . $date_end . ' | ' . $experience->getCity('city') . '<br />
                ' . $experience->description . '<br />
                <a href="javascript:void(0);" onclick="showProfileExperienceEditModal(' . $experience->id . ',' . $experience->state_id . ',' . $experience->city_id . ');" class="btn btn-warning">' . __('Edit') . '</a>
				<a href="javascript:void(0);" onclick="delete_profile_experience(' . $experience->id . ');" class="btn btn-danger">' . __('Delete') . '</a>
                </p>
              </div>
            </div>
            <!--experience End-->';
            endforeach;
        endif;

        echo $html;
    }

    public function showProfileGap(Request $request, $user_id)
    {
        $user = User::find($user_id);
        
        $html = '';
        if (isset($user) && count($user->profileGap)):
            foreach ($user->profileGap as $gap):
              

                
                $html .= '<!--experience Start-->
              <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="experience_' . $gap->id . '">
                <div class="mt-card-item" style=" 
                border: 1px solid #e7ecf1;
                position: relative;
                margin-bottom: 30px;"
            >
              
                  <div class="mt-card-content" style="font-size: 16px;
                  font-weight: 600;
                  margin-bottom: 10px;     text-align: center;">
                  <h4 class="mt-card-name" style="font-size: 16px;
                  font-weight: 600;
                  margin-bottom: 10px;">' . $gap->gap_from_month . ' ' . $gap->gap_from_year . ' - ' . $gap->gap_to_month . ' ' . $gap->gap_to_year .   '</h4>
                    <p class="mt-card-desc font-grey-mint">
                  
                    ' . Str::limit($gap->reason, 25, '...') . ' </p>
                    <div class="mt-card-social">
                      <ul style=" padding: 0;
                      margin-bottom: 10px;      " class="profile-gap">
					   <a href="javascript:void(0);" onclick="showProfileGAPEditModal(' . $gap->id .');" <i class="icon-pencil"></i></a> 
                         <a href="javascript:void(0);" onclick="delete_profile_GAP(' . $gap->id . ');" c<i class="icon-close"></i></a></a> 
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <!--experience End-->';
              
            endforeach;
        endif;

        echo $html;
        
        
        
        // $html = '';
        // if (isset($user) && count($user->profileGap)):
        //     foreach ($user->profileGap as $gap):
              

        //         $html .= '<!--experience Start-->
        //     <div class="col-md-12" id="experience_' . $gap->id . '">
        //       <div class="mt-element-ribbon bg-grey-steel">
        //       <div class="ribbon ribbon-color-warning uppercase ">' . $gap->id .  '</div>
        //         <p class="ribbon-content">
				             	
        //         ' . $gap->gap_from_month . ' ' . $gap->gap_from_year . ' - ' . $gap->gap_to_month . ' ' . $gap->gap_to_year . '<br />
               
        //         ' . $gap->reason . '<br /><br/>
        //         <a href="javascript:void(0);" onclick="showProfileGAPEditModal(' . $gap->id .');" class="btn btn-warning">' . __('Edit') . '</a>
		// 		<a href="javascript:void(0);" onclick="delete_profile_GAP(' . $gap->id . ');" class="btn btn-danger">' . __('Delete') . '</a>
        //         </p>
        //       </div>
        //     </div>
        //     <!--experience End-->';
        //     endforeach;
        // endif;

        // echo $html;
    }

    public function showFrontProfileExperience(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $html = '<div class="panel-group">';
        if (isset($user) && count($user->profileExperience)):
            foreach ($user->profileExperience as $experience):
                if ($experience->is_currently_working == 1)
                    $date_end = 'Currently working';
                else
                    $date_end = $experience->date_end->format('d M, Y');

                $html .= '<div class="panel panel-info" id="experience_' . $experience->id . '">
						  <div class="panel-heading"><h4>' . $experience->title . '</h4></div>
						  <div class="panel-body">
						  <p class="text-left"><h5>' . $experience->company . '</h5></p>
						  <p class="text-left">' . $experience->date_start->format('d M, Y') . ' - ' . $date_end . ' | ' . $experience->getCity('city') . '</p>
						  <p class="text-left">' . $experience->description . '</p>
						  </div>
						<div class="panel-footer"><a href="javascript:void(0);" onclick="showProfileGapEditModal(' . $experience->id .  ');" class="text text-default">' . __('Edit') . '</a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="delete_profile_experience(' . $experience->id . ');" class="text text-danger">' . __('Delete') . '</a></div>
						</div>';
            endforeach;
        endif;

        echo $html . '</div>';
    }

    public function showApplicantProfileExperience(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $html = '<ul class="experienceList">';
        if (isset($user) && count($user->profileExperience)):
            foreach ($user->profileExperience as $experience):
                if ($experience->is_currently_working == 1)
                    $date_end = 'Currently working';
                else
                    $date_end = $experience->date_end->format('d M, Y');

                $html .= '<li>
                <div class="row">
                  <div class="col-md-2"><img src="' . asset('images/work-experience.png') . '" alt="work experience"></div>
                  <div class="col-md-10">
                    <h4>' . $experience->company . ' | ' . $experience->getCity('city') . '</h4>
                    <div class="row">
                      <div class="col-md-6">' . $experience->title . '</div>
                      <div class="col-md-6">From ' . $experience->date_start->format('d M, Y') . ' - ' . $date_end . '</div>
                    </div>
                    <p>' . $experience->description . '</p>
                  </div>
                </div>
              </li>';
            endforeach;
        endif;

        echo $html . '</ul>';
    }

    public function getProfileExperienceForm(Request $request, $user_id)
    {
        $countries = DataArrayHelper::defaultCountriesArray();

        $user = User::find($user_id);
        $returnHTML = view('admin.user.forms.experience.experience_modal')
                ->with('user', $user)
                ->with('countries', $countries)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
    public function getProfileGapForm(Request $request, $user_id)
    {
      

        $user = User::find($user_id);
        $returnHTML = view('admin.user.forms.experience.gap_modal')
                ->with('user', $user)
                
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function getFrontProfileExperienceForm(Request $request, $user_id)
    {
        $countries = DataArrayHelper::langCountriesArray();

        $user = User::find($user_id);
        $returnHTML = view('user.forms.experience.experience_modal')
                ->with('user', $user)
                ->with('countries', $countries)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function storeProfileExperience(ProfileExperienceFormRequest $request, $user_id)
    {

        $profileExperience = new ProfileExperience();
        $profileExperience = $this->assignExperienceValues($profileExperience, $request, $user_id);
        $profileExperience->save();

        $returnHTML = view('admin.user.forms.experience.experience_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }
    public function storeProfileGap(ProfileGapRequest $request, $user_id)
    {

        $profileExperience = new ProfileGap();
        // $profileExperience = $this->assignExperienceValues($profileExperience, $request, $user_id);
        $profileExperience->user_id = $user_id;
//        $profileExperience->gap_from_year = $request->input('gap_from_year');
//        $profileExperience->gap_from_month = $request->input('gap_from_month');
//        $profileExperience->gap_to_year = $request->input('gap_to_year');
//        $profileExperience->gap_to_month = $request->input('gap_to_month');
        $profileExperience->reason = $request->input('reason');
        $profileExperience->save();

        $returnHTML = view('admin.user.forms.experience.gap_edit_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }
    public function storeFrontProfileExperience(ProfileExperienceFormRequest $request, $user_id)
    {

        $profileExperience = new ProfileExperience();
        $profileExperience = $this->assignExperienceValues($profileExperience, $request, $user_id);
        $profileExperience->save();

        $returnHTML = view('user.forms.experience.experience_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }

    private function assignExperienceValues($profileExperience, $request, $user_id)
    {
        $profileExperience->user_id = $user_id;
        $profileExperience->title = $request->input('title');
        $profileExperience->company = $request->input('company');
        $profileExperience->country_id = $request->input('country_id');
        $profileExperience->state_id = $request->input('state_id');
        $profileExperience->city_id = $request->input('city_id');
        $profileExperience->date_start = $request->input('date_start');
        $profileExperience->date_end = $request->input('date_end');
        $profileExperience->is_currently_working = $request->input('is_currently_working');
        $profileExperience->description = $request->input('description');
        return $profileExperience;
    }

    public function getProfileExperienceEditForm(Request $request, $user_id)
    {
        $profile_experience_id = $request->input('profile_experience_id');

        $countries = DataArrayHelper::defaultCountriesArray();

        $profileExperience = ProfileExperience::find($profile_experience_id);
        $user = User::find($user_id);

        $returnHTML = view('admin.user.forms.experience.experience_edit_modal')
                ->with('user', $user)
                ->with('profileExperience', $profileExperience)
                ->with('countries', $countries)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function getProfileGapEditForm(Request $request, $user_id)
    {
        $profile_experience_id = $request->input('profile_experience_id');

      

        $profilegap = ProfileGap::find($profile_experience_id);
        $user = User::find($user_id);
       

        $returnHTML = view('admin.user.forms.experience.gap_edit_modal')
                ->with('user', $user)
                ->with('profilegap', $profilegap)
            
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
    

    public function getFrontProfileExperienceEditForm(Request $request, $user_id)
    {
        $profile_experience_id = $request->input('profile_experience_id');
        $countries = DataArrayHelper::langCountriesArray();

        $profileExperience = ProfileExperience::find($profile_experience_id);
        $user = User::find($user_id);

        $returnHTML = view('user.forms.experience.experience_edit_modal')
                ->with('user', $user)
                ->with('profileExperience', $profileExperience)
                ->with('countries', $countries)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function updateProfileExperience(ProfileExperienceFormRequest $request, $profile_experience_id, $user_id)
    {

        $profileExperience = ProfileExperience::find($profile_experience_id);
        $profileExperience = $this->assignExperienceValues($profileExperience, $request, $user_id);
        $profileExperience->update();

        $returnHTML = view('admin.user.forms.experience.experience_edit_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }
    public function updateProfileGap(Request $request, $profile_experience_id, $user_id)
    {
        $this->validate(
            $request, 
            ['reason' => 'required|max:200'],
            ['reason.required' => 'Reason is required']
        );

        // $profileExperience = new ProfileGap();
        $profileExperience = ProfileGap::find($profile_experience_id);
        // $profileExperience = $this->assignExperienceValues($profileExperience, $request, $user_id);
        $profileExperience->user_id = $user_id;
//        $profileExperience->gap_from_year = $request->input('gap_from_year');
//        $profileExperience->gap_from_month = $request->input('gap_from_month');
//        $profileExperience->gap_to_year = $request->input('gap_to_year');
//        $profileExperience->gap_to_month = $request->input('gap_to_month');
        $profileExperience->reason = $request->input('reason');
        $profileExperience->save();
        
       


        // $profileExperience = ProfileExperience::find($profile_experience_id);
        // $profileExperience = $this->assignExperienceValues($profileExperience, $request, $user_id);
        // $profileExperience->update();

        $returnHTML = view('admin.user.forms.experience.gap_edit_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }

    public function updateFrontProfileExperience(ProfileExperienceFormRequest $request, $profile_experience_id, $user_id)
    {

        $profileExperience = ProfileExperience::find($profile_experience_id);
        $profileExperience = $this->assignExperienceValues($profileExperience, $request, $user_id);
        $profileExperience->update();

        $returnHTML = view('user.forms.experience.experience_edit_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }

    public function deleteProfileExperience(Request $request)
    {
        $id = $request->input('id');
        try {
            $profileExperience = ProfileExperience::findOrFail($id);
            $profileExperience->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }



    public function deleteProfileGap(Request $request)
    {

            $id=$request->input('id');

            try{
            $profilegap=ProfileGap::findorFail($id);
            $profilegap->delete();
            echo 'ok';

            }catch(ModelNotFoundExeception $e){
            echo 'notok';

            }
    }
}
