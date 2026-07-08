<?php

namespace App\Http\Controllers\Job;

use App\Collection;
use App\PostJob;
use App\Unlocked_users;
use App\User;
use Auth;
use DB;
use Input;
use Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Traits\JobTrait;

class JobPublishController extends Controller
{

    use JobTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('company');
    }
    public function viewApplicantProfile(Request $request)
    {
        $job_id = $request->job_id;
        $user_id = $request->id;

        $jobData = PostJob::where('id', $job_id)->first();

        
        if($jobData->resume_view){
            $data = json_decode($jobData->resume_view,true);
        }else{
            $data =[$user_id => $user_id];
        }
        if (count($data) < 3 || in_array($user_id, $data)) {

            $unlocked = Unlocked_users::where('company_id',Auth::guard('company')->user()->id)
            ->where('unlocked_users_ids',$user_id)->exists();
            $data [$user_id] = $user_id;
            $jobData->resume_view= json_encode($data);
            $jobData->save();
            $user = User::findOrFail($user_id );

            $profileCv = $user->getDefaultCv();
            $collections= Collection::where('user_id',Auth::guard('company')->user()->id)->get();



            return view('user.applicant_profile')

                        ->with('user', $user)
                        
                        ->with('unlocked', $unlocked)

                        ->with('profileCv', $profileCv)

                        ->with('page_title', $user->getName())

                        ->with('form_title', 'Contact ' . $user->getName())

                        ->with('collections',$collections);
        }else{
            return redirect('/employer/buy-cv/'. $user_id );
        }

    }

}
