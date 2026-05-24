<?php



namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use App\ProfileLanguage;

use App\UserVerify;

use App\JobSkill;

use App\Accomplishment;

use Cache;

use App\Interview;

use Auth;

use URL;

use Illuminate\Support\Facades\Mail;

use DB;

use Input;

use File;

use DateTime;

use DatePeriod;

use DateInterval;


use Illuminate\Support\Facades\Hash;

use Illuminate\Http\UploadedFile;

use ImgUploader;

use Carbon\Carbon;

use Redirect;

use Newsletter;

use Carbon\CarbonPeriod;

use App\Offers;

use App\User;

use App\Subscription;

use App\Locality;


use App\KeySkill;

use App\ApplicantMessage;

use App\Company;

use App\FavouriteCompany;

use App\ProfileSummary;

use App\Imports\EducationImport;

use App\Gender;

use App\ProfileSkill;

use Jrean\UserVerification\Traits\VerifiesUsers;

use Jrean\UserVerification\Facades\UserVerification;

use Maatwebsite\Excel\Facades\Excel;

use App\MaritalStatus;

use App\Country;

use App\State;

use App\City;

use App\JobExperience;

use App\JobApply;

use App\UserLocation;



use App\CareerLevel;

use App\Industry;

use App\Alert;

use Illuminate\Support\Str;

use App\ProfileNop;

use App\FunctionalArea;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Http\Requests\UserFormRequest;

use App\Http\Requests\CompensationRequest; 

use App\Http\Requests\CertificateFormRequest;

use App\Http\Requests\CompanyRequest;

use App\Http\Requests\CompanyFrontRequest;

use App\Http\Requests\CompanyPreviousFrontRequest;

use App\Http\Requests\MajorSubjectFormRequest;

use App\Http\Requests\UpdateUserFormRequest;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Controllers\Controller;

use App\Traits\CommonUserFunctions;

use App\Traits\ProfileSummaryTrait;

use App\Traits\ProfileCvsTrait;

use App\Traits\ProfileProjectsTrait;

use App\Traits\ProfileExperienceTrait;

use App\ProfileDetails;

use App\Traits\ProfileEducationTrait;

use App\Traits\ProfileSkillTrait;

use App\Traits\ProfileLanguageTrait;

use App\Traits\Skills;

use App\ProfileGap;

use App\ProfileEducation;

use App\ProfileProject;

use App\Certificate;

use App\Http\Requests\Front\UserFrontFormRequest;

use App\Helpers\DataArrayHelper;

use App\Http\Requests\PreferencesRequest;

use App\Http\Requests\FrontRequest;

use App\Http\Requests\ProfileSummaryFormRequest;

use App\Http\Requests\ProfileSkillFormRequest;

use App\ProfileCityJobsCity;

use App\CompanyData;

use Session;

use App\Events\JobApplied;
use App\PostJob;



class UserController extends Controller

{



    use CommonUserFunctions;

    use ProfileSummaryTrait;

    use ProfileCvsTrait;

    use ProfileProjectsTrait;

    use ProfileExperienceTrait;

    use ProfileEducationTrait;

    use ProfileSkillTrait;

    use ProfileLanguageTrait;

    use Skills;

    



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        //$this->middleware('auth', ['only' => ['myProfile', 'updateMyProfile', 'viewPublicProfile']]);

        $this->middleware('auth', ['except' => ['showApplicantProfileEducation', 'showApplicantProfileProjects', 'showApplicantProfileExperience', 'showApplicantProfileSkills', 'showApplicantProfileLanguages']]);

    }



    public function dbdatechange($date)

    {

       $date= date("Y-m-d", strtotime($date));

       return $date;

    }



    public function viewPublicProfile($id)

    {



        $user = User::findOrFail($id);

        // $user_view=new User();

        // $user->no_of_views = 1;

        // $user->

        $profileCv = $user->getDefaultCv();



        return view('user.applicant_profile')

                        ->with('user', $user)

                        ->with('profileCv', $profileCv)

                        ->with('page_title', $user->getName())

                        ->with('form_title', 'Contact ' . $user->getName());

    }



    public function myProfile()

    {

    

        $user = User::findOrFail(Auth::user()->id);

        $user_id = Auth::user()->id;

       // dd($user_id);



       $lang = ProfileLanguage::where('user_id',$user_id)->first();



       $keyskill = KeySkill::where('user_id',$user_id)->first();



       $profileNP = ProfileNop::where('user_id',$user_id)->first();



       $offers = Offers::where('user_id',$user_id)->first();



       $compensation = ProfileDetails::where('user_id',$user_id)->first();



       $interview=ProfileDetails::where('user_id',$user_id)->first();



       $summary = ProfileSummary::where('user_id',$user_id)->first();



       $company = ProfileCityJobsCity::where('user_id',$user_id)->first();



       $itskill = ProfileSkill::where('user_id',$user_id)->first();



       $project = ProfileProject::where('user_id',$user_id)->first();



       $education = ProfileEducation::where('user_id',$user_id)->first();



       $certificate = Certificate::where('user_id',$user_id)->first();



       $gap = ProfileGap::where('user_id',$user_id)->first();

   



       $count = 5;



       if(isset($user->current_city))

       {



                $count++;



                $data= $count;



                $user->complete = $data;



                $user->save();



       }

       if(isset($lang->language))

       {

        $count++;



        $data= $count;



        $user->complete = $data;



        $user->save();

       }

       if(isset($keyskill->keyskill))

       {



       // dd('value');

        $count++;



        $data= $count;



        $user->complete = $data;



        $user->save();

       }

       if(isset($profileNP->last_working_day))

       {

        $count++;



        $data= $count;



        $user->complete = $data;



        $user->save();

       }

       if(isset($offers->repoff))

       {

        $count++;



        $data= $count;



        $user->complete = $data;



        $user->save();

       }



       if(isset($compensation->expect_ctc_lakhs))

       {

        $count++;



        $data= $count;



        $user->complete = $data;



        $user->save();

       }

       if(isset($interview->video_date_from))

       {

        $count++;



        $data= $count;



        $user->complete = $data;



        $user->save();



       }



       if(isset($summary->summary))

       {

        $count++;



        $data= $count;



        $user->complete = $data;



        $user->save();



       }

if(isset($company->current_company)) 


{

    $count++;



    $data= $count;



    $user->complete = $data;



    $user->save();

}


if(isset($company->previous_company))
{

    $count++;



    $data= $count;



    $user->complete = $data;



    $user->save();

}

if(isset($itskill->version))

{

    $count++;



    $data= $count;



    $user->complete = $data;



    $user->save();

}

    if(isset($project->domain))

    {

        $count++;



        $data= $count;

    

        $user->complete = $data;

    

        $user->save();

    }



    if(isset($education->organization))

    {

        $count++;



        $data= $count;

    

        $user->complete = $data;

    

        $user->save();

    }

    if(isset($certificate->certificate_name))

    {

        $count++;



        $data= $count;

    

        $user->complete = $data;

    

        $user->save();

    }

    

    if(isset($gap->reason))

    {

        $count++;



        $data= $count;

    

        $user->complete = $data;

    

        $user->save();



    }

    if(isset($interview->shifts))

    {

        $count++;



        $data= $count;

    

        $user->complete = $data;

    

        $user->save();

    }

        $genders = DataArrayHelper::langGendersArray();

        $maritalStatuses = DataArrayHelper::langMaritalStatusesArray();

        $nationalities = DataArrayHelper::langNationalitiesArray();

        $countries = DataArrayHelper::langCountriesArray();

        $jobExperiences = DataArrayHelper::langJobExperiencesArray();

        $careerLevels = DataArrayHelper::langCareerLevelsArray();

        $industries = DataArrayHelper::langIndustriesArray();

        $functionalAreas = DataArrayHelper::langFunctionalAreasArray();



        $upload_max_filesize = UploadedFile::getMaxFilesize() / (1048576);

        $user = User::findOrFail(Auth::user()->id);
        
    //    dd($maritalStatuses);

  // Function to check if the value is serialized
function is_serialized($data) {
    // If the data is not a string, return false
    if (!is_string($data)) {
        return false;
    }

    // Try to decode the serialized data without actually unserializing it
    $unserializedData = @unserialize($data);

    // If decoding is successful and the result is an array, return true
    return is_array($unserializedData);
}

$prefered_city = $user->prefered_city;

// Check if the data is serialized
if (is_serialized($prefered_city)) {
    // The data is serialized
    try {
        $locationresult = unserialize($prefered_city);
    } catch (Exception $e) {
        $locationresult = '';
    }
} else {
    // The data is not serialized
    $locationresult = $prefered_city;
}


        
      
        return view('user.edit_profile')

                        ->with('genders', $genders)
                        
                     

                        ->with('maritalStatuses', $maritalStatuses)

                        ->with('nationalities', $nationalities)

                        ->with('countries', $countries)

                        ->with('jobExperiences', $jobExperiences)

                        ->with('careerLevels', $careerLevels)

                        ->with('industries', $industries)

                        ->with('functionalAreas', $functionalAreas)

                        ->with('user', $user)                                     

                        ->with('upload_max_filesize', $upload_max_filesize)                        

                        ->with('locationresult', $locationresult);
                       

    }



    public function deleteresume(Request $request)

    {

    

    // $req=User::where('id','=',$request->id)->first();

    // return $req->resume;

    // $req->update(['resume' => null]);

    

    $profileCv = User::findOrFail($request->id);

    $file = $profileCv->resume;

    if (!empty($file)) {

        

        File::delete(ImgUploader::real_public_path() . 'cvs/' . $file);

    }

    $profileCv1=User::where('id',$request->id)->first();

    $profileCv1->resume='';

    $profileCv1->save();

    return back();

    }

    public function updateProfileDetails($user_id, PreferencesRequest $request)

    {

        $profileNP = ProfileDetails::where('user_id', '=', $user_id)->first();

        if($profileNP)

        {

            $profileNP->user_id = $user_id;

            $profileNP->shifts = $request->input('shifts');

            $profileNP->work_type = $request->input('work_type');

            $profileNP->contract_type = $request->input('contract_type');

            $profileNP->candidate_wfh = $request->input('work_option');

            $profileNP->case_of_contract = $request->input('case_of_contract');

            

            $profileNP->expecting_opportunities = $request->input('expecting_opportunities');

            $profileNP->expecting_payment = $request->input('expecting_payment');






            $profileNP->save();

            return response()->json(array('success' => true, 'status' => 200), 200);

        }

        else

        {       

            $profileNP = new ProfileDetails();

            $profileNP->user_id = $user_id;

            $profileNP->shifts = $request->input('shifts');

            $profileNP->work_type = $request->input('work_type');

            $profileNP->contract_type = $request->input('contract_type');

            $profileNP->candidate_wfh = $request->input('work_option');

            $profileNP->case_of_contract = $request->input('case_of_contract');

            

            

            

            $profileNP->expecting_opportunities = $request->input('expecting_opportunities');

            $profileNP->expecting_payment = $request->input('expecting_payment');



           

            

            // $profileNP->contract_type = $request->input('contract_type');



            // $profileNP->telephonic_date_from = $request->input('telephonic_date_from');

            // $profileNP->video_date_from = $request->input('video_date_from');

            // $profileNP->video_date_to = $request->input('video_date_to');

            // $profileNP->video_time = $request->input('video_time');

            

            // $profileNP->night_telephonic_date_from = $request->input('night_telephonic_date_from');

            // $profileNP->night_telephonic_date_to = $request->input('night_telephonic_date_to');



            // $profileNP->night_time = $request->input('night_time');

            // $profileNP->expect_ctc_lakhs = $request->input('expect_ctc_lakhs');

            // $profileNP->expect_ctc_thousand = $request->input('expect_ctc_thousand');

            

            // $profileNP->expect_ctc_lakhs1 = $request->input('expect_ctc_lakhs1');

            // $profileNP->expect_ctc_thousand1 = $request->input('expect_ctc_thousand1');

            

            // $profileNP->expect_ctc_lakhs2 = $request->input('expect_ctc_lakhs2');

            // $profileNP->expect_ctc_thousand2 = $request->input('expect_ctc_thousand2');

            

            // $profileNP->expect_ctc_lakhs3 = $request->input('expect_ctc_lakhs3');

            // $profileNP->expect_ctc_thousand3 = $request->input('expect_ctc_thousand3');



            $profileNP->save();

            return response()->json(array('success' => true, 'status' => 200), 200);


        }

        // $summary = $request->input('summary');

        // $ProfileSummary = new ProfileSummary();

        // $ProfileSummary->user_id = $user_id;

       

        /*         * ************************************ */

        return back ()->with('success','Compensation Updated successfully');

    }

    

    public function updateProfileCompensation($user_id, CompensationRequest $request)

    {

    

   // return dd($request);

        $profileNP = ProfileDetails::where('user_id', '=', $user_id)->first();

        if($profileNP)

        {

            $profileNP->user_id = $user_id;

          

            $profileNP->expect_ctc_lakhs = $request->input('expect_ctc_lakhs');

            $profileNP->expect_ctc_thousand = $request->input('expect_ctc_thousand');

            

            $profileNP->expect_ctc_lakhs1 = $request->input('expect_ctc_lakhs1');

            $profileNP->expect_ctc_thousand1 = $request->input('expect_ctc_thousand1');

            

            $profileNP->expect_ctc_lakhs2 = $request->input('expect_ctc_lakhs2');

            $profileNP->expect_ctc_thousand2 = $request->input('expect_ctc_thousand2');

            

            $profileNP->expect_ctc_lakhs3 = $request->input('expect_ctc_lakhs3');

            $profileNP->expect_ctc_thousand3 = $request->input('expect_ctc_thousand3');





            $profileNP->save();



            return response()->json(array('success' => true, 'status' => 200), 200);

        }

        else

        {       

            $profileNP = new ProfileDetails();

            $profileNP->user_id = $user_id;

         

            $profileNP->expect_ctc_lakhs = $request->input('expect_ctc_lakhs');

            $profileNP->expect_ctc_thousand = $request->input('expect_ctc_thousand');

            

            $profileNP->expect_ctc_lakhs1 = $request->input('expect_ctc_lakhs1');

            $profileNP->expect_ctc_thousand1 = $request->input('expect_ctc_thousand1');

            

            $profileNP->expect_ctc_lakhs2 = $request->input('expect_ctc_lakhs2');

            $profileNP->expect_ctc_thousand2 = $request->input('expect_ctc_thousand2');

            

            $profileNP->expect_ctc_lakhs3 = $request->input('expect_ctc_lakhs3');

            $profileNP->expect_ctc_thousand3 = $request->input('expect_ctc_thousand3');

            $profileNP->save();


               

        }

        // $summary = $request->input('summary');

        // $ProfileSummary = new ProfileSummary();

        // $ProfileSummary->user_id = $user_id;

       

        /*         * ************************************ */

       // flash(__('You have updated your profile successfully'))->success();

       return response()->json(array('success' => true, 'status' => 200), 200);

    

    

    

    

    

    }

    

    

    

        

        public function updateMyProfile(FrontRequest $request)

        {

        
    
       

     // return dd($request->all());

    if($request->industry == 2)
    {

        $this->validate(
            $request, 
            ['process' => 'required'],
            ['process.required' => 'Process is required']
        );


    }
    
   // dd($request->resume);

           

            $user = User::findOrFail(Auth::user()->id);

      
             if($request->resume)
             {
                $fileName = '';

                if ($request->hasFile('resume')) {
    
                    // $request->validate([
    
                    //     'resume'=>'required|mimes:pdf,docx|max:2048'     
    
                    //     ]);
    
                    $cv_file = $request->file('resume');
    
                    $fileName = ImgUploader::UploadDoc('cvs', $cv_file, $request->input('title'));
    
                    $user->resume= $fileName;
    
                }
             }else{
                   if($user->resume)
                     {
                       //  dd('value');
                     }else{
                
                    $this->validate(
                        $request, 
                        ['resume' => 'required'],
                        ['resume.required' => 'Resume is required']
                    );
             }
             }
             
            

         

            $user->first_name = $request->input('first_name');

            $user->middle_name = $request->input('middle_name');

            $user->last_name = $request->input('last_name');

            $user->date_of_birth = $request->input('date_of_birth');

            $user->gender_id = $request->input('gender_id');

             $user->marital_status_id = $request->input('marital_status_id');

            $user->current_city = $request->input('current_city');

            $user->prefered_city = serialize($request->input('prefered_city'));

            $user->current_location =$request->input('current_location');

            // $user->phone = $request->input('phone');           

            $user->prefered_location = $request->input('prefered_location');

            // $user->prefered_city = $request->input('prefered_city');

            $user->physically_challenged = $request->input('physically_challenged');

            $user->industry = $request->input('industry');

            $user->process = $request->input('process');

            $user->street_address = $request->input('street_address');

            $user->profile_completion = $user->profile_completion + 2;



           

            $user->update();

            // foreach($request->input('prefered_city') as $location_data)
            // {
            //     $location =  UserLocation::where('location','like',$location_data)->first();

            //     if($location)
            //     {
                   

            //     }else{
            //         $location = new UserLocation();
            //         $location->user_id = Auth::user()->id;
            //         $location->location = $location_data;
            //         $location->save();
            //     }

            // }
            // foreach($request->input('current_location') as $location_data)
            // {
            //     $location =  Locality::where('location','like',$location_data)->first();

            //     if($location)
            //     {
                   

            //     }else{
            //         $location = new Locality();                
            //         $location->location = $location_data;
            //         $location->save();
            //     }

            // }
           // dd('saved');

		

        //  flash(__('success','You have updated your profile successfully'))->success();
        //  flash(__('You have updated your profile successfully'))->success();

        return redirect()->to(url()->previous() . '#basic_info')->with('success', 'Personal Details Updated Successfully');

        // return redirect()->back()->with('success','You have updated your profile successfully');

        // return \Redirect::route('my.profile');

    }



    public function addToFavouriteCompany(Request $request, $company_slug)

    {

        $data['company_slug'] = $company_slug;

        $data['user_id'] = Auth::user()->id;

        $data_save = FavouriteCompany::create($data);

        flash(__('Company has been added in favorites list'))->success();

        return \Redirect::route('company.detail', $company_slug);

    }



    public function removeFromFavouriteCompany(Request $request, $company_slug)

    {

        $user_id = Auth::user()->id;

        FavouriteCompany::where('company_slug', 'like', $company_slug)->where('user_id', $user_id)->delete();



        flash(__('Company has been removed from favorites list'))->success();

        return \Redirect::route('company.detail', $company_slug);

    }



    public function myFollowings()

    {

        $user = User::findOrFail(Auth::user()->id);

        $companiesSlugArray = $user->getFollowingCompaniesSlugArray();

        $companies = Company::whereIn('slug', $companiesSlugArray)->get();



        return view('user.following_companies')

                        ->with('user', $user)

                        ->with('companies', $companies);

    }



    public function myMessages()

    {

        $user = User::findOrFail(Auth::user()->id);

        $messages = ApplicantMessage::where('user_id', '=', $user->id)

                ->orderBy('is_read', 'asc')

                ->orderBy('created_at', 'desc')

                ->get();



        return view('user.applicant_messages')

                        ->with('user', $user)

                        ->with('messages', $messages);

    }



    public function applicantMessageDetail($message_id)

    {

        $user = User::findOrFail(Auth::user()->id);

        $message = ApplicantMessage::findOrFail($message_id);

        $message->update(['is_read' => 1]);



        return view('user.applicant_message_detail')

                        ->with('user', $user)

                        ->with('message', $message);

    }



    public function myAlerts()

    {

        $alerts = Alert::where('email', Auth::user()->email)

            ->orderBy('created_at', 'desc')

            ->get();

        //dd($alerts);

        return view('user.applicant_alerts')

            ->with('alerts', $alerts);

    }

    public function delete_alert($id)

    {

        $alert = Alert::findOrFail($id);

        $alert->delete();

        $arr = array('msg' => 'A Alert has been successfully deleted. ', 'status' => true);

        return Response()->json($arr);

    }

    

    

    public function verifyusers($id)

    {

    $user=User::where('id',$id)->first();

    

    return view('user.email_verify',compact('user'));

    

    }

    

    public function emailverifyuser($id)

    {

    

    $user=User::where('id',$id)->first();

   // return dd($user);

    $token = Str::random(64);
  
   
   $data =  UserVerify::create([
          'user_id' => $user->id, 
          'token' => $token,


        ]);

      // return dd($data);

    Mail::send('emails.emailVerificationEmail', ['token' => $token,'user'=>$user,'link' => URL::route('user.verify', $token)], function($message) use($user){
          $message->from('info@zeronoticeperiod.com');
          $message->to($user->email);
          $message->subject('Confirm Your Email');
      });
     
   // return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    

        // UserVerification::generate($user);

        // UserVerification::send($user, 'User Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));

         return redirect()->back()->with('success','Verification mail sent successfully to your email ID.');

       

    

    }

    public function verifyAccount($token)
    {
      //  return dd($token);
        $verifyUser = UserVerify::where('token', $token)->first();

       // $db_user = new User();

        $db_user = User::findOrFail(Auth::user()->id);

   // return dd($db_user);
  
        $message = 'Sorry your email cannot be identified.';
  
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
              
            if(!$user->email_verified) {
                $verifyUser->user->email_verified = 1;
                $verifyUser->user->save();
                $db_user->email_verified = '1';
                $db_user->save();
               // return dd('saved');
                $message = "Your email has been verified , please use the link below to login to home page.";
                return view('verified')->with('message', $message);
            } else {
                //return dd('hello');
                $message = "It looks like you've already verified your email with us, thanks!.";
                return view('verified')->with('message', $message);
            }
        }
  
      return redirect()->route('login')->with('new_message', $message);
    }
    

    public function verifyphoneuser(Request $request,$id)

    {

    $phone=$request->phone;

    

//     $apiKey = urlencode('MzA2MzUwMzA1NTc1NDU3MjZmMzk3MTQ5NTA3OTUzNDk=');

    

//     $otp=rand(100000,200000);

    

//     $user=User::where('id',$id)->first();

//      $user->otp=$otp;

//      $user->save();

    

 

//    // return $otp;

	

// 	// Message details

// 	$numbers = $phone;

// 	$sender = urlencode('600010');

// 	$message = rawurlencode('Hi there, thank you for sending your first test message from Textlocal. Get 20% off today with our code: '.$otp.'.');

 

// 	//$numbers = implode(',', $numbers);

 

// 	// Prepare data for POST request

// 	$data = 'apikey=' . $apiKey . '&numbers=' . $numbers . "&sender=" . $sender . "&message=" . $message;

 

// 	// Send the GET request with cURL

// 	$ch = curl_init('https://api.textlocal.in/send/?' . $data);

// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 	$response = curl_exec($ch);

// 	curl_close($ch);

	

// 	// Process your response here

// 	// echo $response;

// 	return view('user.phone_verify',compact('user','phone'));

    
// Account details
$apiKey = urlencode('MzA2MzUwMzA1NTc1NDU3MjZmMzk3MTQ5NTA3OTUzNDk=	');
	
// Message details
$numbers = array(917019588629, 917639069608);
$sender = urlencode('600010');
$otp = 1230;
	$message = rawurlencode('Hi there, thank you for sending your first test message from Textlocal. Get 20% off today with our code: '.$otp.'.');

$numbers = implode(',', $numbers);

// Prepare data for POST request
$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

// Send the POST request with cURL
$ch = curl_init('https://api.textlocal.in/send/');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Process your response here
echo $response;
    }

    

    public function verifyotp(Request $request,$id)

    

    {
      //  dd($request);
        $request->validate([
    
            'otp' => 'required'
        
        ]);
            
    

    $user=User::where('id',$id)->first();

    

    if($request->otp === $user->otp)

    {

    

    $user->phone_verified=1;

    $user->save();

   return redirect('/');

    

    }else{

      //  return view('user.phone_verify');

      return response()->json(['not_same' => 'Please Enter Valid Otp'], 404);
    // return redirect()->back()->with('error','Please Enter Valid Otp');

    

    }

    

    

    

    }

   

   

   public function videointerview(Request $request,$id)

   {
       
        // $d =  date("h:i:sa");
          $nowtime =  date("g:i A");
          $todaydate = date("d-m-Y");
        // dd($nowtime);

if($request->date == $todaydate)
{
    $this->validate(

    $request, 
    [
        'date' => 'required',
        'from_time'  => 'required|date_format:g:i A|after:'.$nowtime,
        'to_time'  => 'required|date_format:g:i A|after:from_time',  

    ],
    [

        'video_date_from.required' => ' Date is required',
        'from_time.after'  => 'Please schedule at least 2 hours ahead of current local time.',
        'video_date_from.required' => ' Date is required',
        'to_time.required' => 'To Time is required',
        'to_time.after' => 'Please allot a 30/45/60 minute schedule post start time.'
       
    ]
);
    
}else{
    
        $this->validate(

    $request, 
    [
        'date' => 'required',
        'from_time'  => 'required|date_format:g:i A',
        'to_time'  => 'required|date_format:g:i A|after:from_time', 
      
        
    ],
    [

        'video_date_from.required' => ' Date is required',
        'from_time.required'  => 'From Time is required',
        'to_time.required' => 'To Time is required',
          'to_time.after' => 'Please allot a 30/45/60 minute schedule post start time.'
       
    ]
);
    
}

    
   //dd('validation passed');


   $user=new Interview();

   $user->user_id = $request->id;

   $user->date = $this->dbdatechange($request->date)??'';

   $user->from_time = $request->from_time;

   $user->to_time = $request->to_time;

   $user->save();

//   $interviews = Interview::where('user_id',$request->id)->get();
//
//   if($interviews)
//   {
//       foreach ($interviews as $inter) {
//           $dates[] = $inter->date;
//       }
//       $userdata = User::where('id',$request->id)->first();
//       if($userdata)
//       {
//           $userdata->interview_dates = '';
//
//       }
//       $userdata->interview_dates =  explode(',', $dates);
//       $userdata->save();
//   }

   return response()->json(array('success' => true, 'status' => 200), 200);

 

   

   }



public function getFrontVideoEditForm(Request $request)

{


 

$user=Interview::where('id',$request->interview_id)->first();


$returnHTML = view('user.forms.interview.video_edit_modal')

->with('user', $user)



->render();


$date = Carbon::parse($user->date)->format('d-m-Y');

// dd($user->date);

return response()->json(array('success' => true,'from_time' => $user->from_time,'to_time' => $user->to_time,'date' => $date,'id'=>$user->id ));



}



public function updatevideointerview(Request $request,$id)



{

  //  dd($request->all());


        // $d =  date("h:i:sa");
          $nowtime =  date("g:i A");
          $todaydate = date("d-m-Y");
        // dd($nowtime);

if($request->date == $todaydate)
{
    $this->validate(

    $request, 
    [
        'date' => 'required',
        'from_time'  => 'required|date_format:g:i A|after:'.$nowtime,
        'to_time'  => 'required|date_format:g:i A|after:from_time',  

    ],
    [

        'video_date_from.required' => ' Date is required',
        'from_time.required'  => 'From Time is required',
        'to_time.required' => 'To Time is required'
       
    ]
);
    
}else{
    
        $this->validate(

    $request, 
    [
        'date' => 'required',
        'from_time'  => 'required|date_format:g:i A',
        'to_time'  => 'required|date_format:g:i A|after:from_time', 
      
        
    ],
    [

        'video_date_from.required' => ' Date is required',
        'from_time.required'  => 'From Time is required',
        'to_time.required' => 'To Time is required'
       
    ]
);
    
}
    //dd('validation success');
       
    
       $inter = Interview::where('id',$request->interview_id)->first();

       $inter->date = $this->dbdatechange($request->date)??'';
    
       $inter->from_time = $request->from_time;
    
       $inter->to_time = $request->to_time;
    
       $inter->save();

//        $interviews = Interview::where('user_id',$request->id)->orderBy('date','asc')->get();
//
//
//
//        if($interviews)
//        {
//            foreach ($interviews as $inter) {
//                $newDate[] = date("d", strtotime($inter->date));
//            }
//
//            $userdata = User::where('id',$request->id)->first();
//            if($userdata)
//            {
//                $userdata->interview_dates = '';
//
//            }
//            $interview_dates =  implode(', ', $newDate);
//
//            $userdata->interview_dates =  $interview_dates;
//            $userdata->save();
//        }


 
       return response()->json(array('success' => true, 'status' => 200), 200);

 
}

public function deleteInterview(Request $request)
{
   $in = Interview::where('id',$request->id)->delete();
   return 'ok';
}



public function nightinterview(Request $request,$id)

{

        $this->validate(

            $request, 
            [
                'night_telephonic_date_from'=>'required',

                'night_telephonic_date_to' =>'required',
        
                'night_time'  => 'required'
            ],
            [
        
                'night_telephonic_date_from.required' => ' Night Date From is required',
                'night_telephonic_date_to.required' => ' Night Date To is required',
                'night_time.required' => ' Time is required',
               
            ]
        );

       

       $user=ProfileDetails::where('user_id',$id)->first();

       if($user)

       {

       $user->user_id = $id;

       $user->night_telephonic_date_from = $this->dbdatechange($request->night_telephonic_date_from);

       $user->night_telephonic_date_to = $this->dbdatechange($request->night_telephonic_date_to);

       $user->night_time = $request->night_time;

       $user->save();

       }else{

       

       $user=new ProfileDetails();

       $user->user_id = $id;

       $user->night_telephonic_date_from = $this->dbdatechange($request->night_telephonic_date_from);

       $user->night_telephonic_date_to = $this->dbdatechange($request->night_telephonic_date_to);

       $user->night_time = $request->night_time;

       $user->save();

       

       

       }

       

       

       

        // flash(__('You have updated your profile successfully'))->success();

        //     return \Redirect::route('my.profile');

       

    //    return response()->json([

    //     'status' => true,

      

    //     'message' => ' successfully.',

    // ]);

    

    

    //    $returnHTML = view('admin.user.forms.interview.language_thanks')->render();

       return response()->json(array('success' => true, 'status' => 200), 200);



}



// public function updateFrontProfileLanguage(Request $request,$id)

// {



// $language=ProfileLanguage::where('user_id',$id)->first();



// return $language;



// }



public function getFrontnightEditForm(Request $request,$id)

{



    $user=ProfileDetails::where('user_id',$request->user_id)->first();





    $returnHTML = view('user.forms.interview.night_edit_modal')

    ->with('user', $user)

    

    ->render();

    return response()->json(array('success' => true, 'html' => $returnHTML));



}



public function nightinterviewupdate(Request $request,$id)

{



  //return dd($request);


  $this->validate(

    $request, 
    [
        'night_telephonic_date_from'=>'required',

        'night_telephonic_date_to' =>'required',

        'night_time'  => 'required'
    ],
    [

        'night_telephonic_date_from.required' => ' Night Date From is required',
        'night_telephonic_date_to.required' => ' Night Date To is required',
        'night_time.required' => ' Time is required',
       
    ]
);


       

       $user=ProfileDetails::where('user_id',$request->user_id)->first();

       

     //  return dd($user);

    

       $user->user_id = $request->user_id;

       $user->night_telephonic_date_from = $this->dbdatechange($request->night_telephonic_date_from);

       $user->night_telephonic_date_to = $this->dbdatechange($request->night_telephonic_date_to);

       $user->night_time = $request->night_time;

       $user->save();

       

       return response()->json(array('success' => true, 'status' => 200), 200);

       



}



public function storesummary(ProfileSummaryFormRequest $request,$id)

{

    if (is_numeric($request->input('latestcom'))){

        $company_data_val = CompanyData::where('id',$request->input('latestcom'))->first();
    
    }else{

        $company_data_val = new CompanyData();
        $company_data_val->name = $request->input('latestcom');
        $company_data_val->save();
    
    }


    $user_data = User::where('id',$id)->first();
    $user_data->reason_moved  = $request->reason_moved;
    $user_data->ignore_companies = serialize($request->input('ignore_companies'));
    $user_data->save();


    ProfileSummary::where('user_id', '=', $id)->delete();

    $summary = $request->input('summary');

    $ProfileSummary = new ProfileSummary();

    $ProfileSummary->user_id = $id;

    $ProfileSummary->summary = $summary;
    
  

    $ProfileSummary->totalexp=$request->input('totalexp');

    $ProfileSummary->totalexpmonth=$request->input('totalexpmonth');

    
    $ProfileSummary->latestcom = $company_data_val->name;

    $ProfileSummary->latestcom_id = $company_data_val->id;
    
    
    

   // $ProfileSummary->latestcom=$request->input('latestcom');

    $ProfileSummary->latestdesg=$request->input('latestdesg');

    $ProfileSummary->currentshift=$request->input('currentshift');

    $ProfileSummary->save();





    

    return response()->json(array('success' => true, 'status' => 200), 200);





}





public function storecurrentcompany(CompanyFrontRequest $request,$id)

{

    if (is_numeric($request->input('current_company'))){

        $company_data_val = CompanyData::where('id',$request->input('current_company'))->first();
       
    }else{

        $company_data_val = new CompanyData();
        $company_data_val->name = $request->input('current_company');
        $company_data_val->save();
       
    }

   // return dd($company_data_val);

 $user = User::findOrFail(Auth::user()->id);



    $profileNP = ProfileCityJobsCity::where('user_id', '=', $user->id)->first();


if($profileNP != NULL){



    if($profileNP->previous_till_date == NULL)

    {

        $n_date=$profileNP->previous_till_date;



    }else{



        $n_date=Carbon::now()->format('m-Y');

    }



    //   dd($n_date);

      $profilegap= ProfileGap::where('user_id',$user->id)->first();         

      

      $gapti='01-'.$request->input('current_start_date').'';  

                

      $result = CarbonPeriod::create('01-'.$request->input('current_start_date').'', '1 month', '01-'.$n_date.'');

      

      $numItems = count($result);

    //  echo $numItems.'<br>';

    $i = 0;

    $ilast = count($result);

    // dd(count($result));

    foreach($result as $key=>$value) {

      if($i==0)

      {

        $first = $value->format("M-Y");

      }

      if($i==$ilast-1)

      {

        $last = $value->format("M-Y");

      }

      

      if(++$i === $numItems) {

        $data=$value->format("M-Y"). "<br>";



        $gaptid='01-'.$data.''."<br>";

 

        $month = date("M",strtotime($gapti));

    

        

      }

    }  

    

   if(count($result) > 6)

      {

          if($profilegap)

          {

              $profilegap->user_id = $user->id;

              $profilegap->gap_from_month = $first;

              $profilegap->gap_to_month = $last;

              $profilegap->save();

          }else{

              $profilegap = new ProfileGap();

              $profilegap->user_id = $user->id;

              $profilegap->gap_from_month = $first;

              $profilegap->gap_to_month = $last;

              $profilegap->save();

          }





      }



    
}



    if($profileNP)

    {

     //   dd('is there');



        $profileNP->user_id = $user->id;

       
        $profileNP->current_company = $company_data_val->name;

        $profileNP->current_company_id = $company_data_val->id;
      
        $profileNP->current_desigination = $request->input('current_desigination');

        $profileNP->current_start_date = $request->input('current_start_date');

        $profileNP->current_till_date = $request->input('current_till_date');

        $profileNP->current_work_type = $request->input('current_work_type');        

        $profileNP->current_project_details = $request->input('current_project_details');

        $profileNP->current_reason = $request->input('current_reason');

        $profileNP->current_responsibilities = $request->input('current_responsibilities');

        $profileNP->current_ctc_start = $request->input('current_ctc_start');

        $profileNP->current_ctc_end = $request->input('current_ctc_end');




        $profileNP->save();

    }

    else

    {      
      //  dd('no value') ;

        $profileNP = new ProfileCityJobsCity();

        $profile = $user->id;

        

        $profileNP->user_id = $user->id;

           // $profileNP->expect_ctc = $request->input('expect_ctc');

           $profileNP->current_company = $company_data_val->name;

           $profileNP->current_company_id = $company_data_val->id;

           $profileNP->current_desigination = $request->input('current_desigination');

           $profileNP->current_start_date = $request->input('current_start_date');



           $profileNP->current_till_date = $request->input('current_till_date');

           $profileNP->current_work_type = $request->input('current_work_type');        

           $profileNP->current_project_details = $request->input('current_project_details');

           $profileNP->current_reason = $request->input('current_reason');

           $profileNP->current_responsibilities = $request->input('current_responsibilities');

           $profileNP->current_ctc_start = $request->input('current_ctc_start');

           $profileNP->current_ctc_end = $request->input('current_ctc_end');



        $profileNP->save();

    }

    // $summary = $request->input('summary');

    // $ProfileSummary = new ProfileSummary();

    // $ProfileSummary->user_id = $user_id;

   

    /*         * ************************************ */

    return response()->json(array('success' => true, 'status' => 200), 200);





}

public function storefrontpreviouscompany(CompanyPreviousFrontRequest $request,$id)

{
   
    if (is_numeric($request->input('previous_company'))){

        $company_data_val = CompanyData::where('id',$request->input('previous_company'))->first();
       
    }else{

        $company_data_val = new CompanyData();
        $company_data_val->name = $request->input('previous_company');
        $company_data_val->save();
       
    }

  

    $profileNP = ProfileCityJobsCity::where('user_id', '=', $id)->first();

  
    if((isset($profileNP->current_start_date)))

    {
        

        $n_date=$profileNP->current_start_date;



    }else{

        $n_date=Carbon::now()->format('m-Y');

    }

     //  dd($n_date);

      $profilegap= ProfileGap::where('user_id',$id)->first();         

      

      $gapti='01-'.$request->input('previous_till_date').'';  

    //  dd($gapti);

      $result = CarbonPeriod::create('01-'.$request->input('previous_till_date').'', '1 month', '01-'.$n_date.'');

      

      $numItems = count($result);

    

    //  echo $numItems.'<br>';

    $i = 0;

    $ilast = count($result);

    

    //dd(count($result));

    foreach($result as $key=>$value) {

    
      if($i==0)

      {

        $first[] = $value->format("M-Y");

       

      }
     

      if($i==count($first)-1)

      {

        $last = $value->format("M-Y");

      }


    }  
   
   // dd($first[0]);
  //  dd(end($first));

        

    if(count($result) > 6)

    {

        if($profilegap)

        {

            $profilegap->user_id = $id;

            $profilegap->gap_from_month = current($first);

            $profilegap->gap_to_month = end($first);

            $profilegap->save();

        }else{

            $profilegap = new ProfileGap();

            $profilegap->user_id = $id;

            $profilegap->gap_from_month = current($first);

            $profilegap->gap_to_month = end($first);

            $profilegap->save();

        }





    }

    

    

    

    if($profileNP)

    {

        // $profileNP->current_ctc = $request->input('current_ctc');

        // $profileNP->expect_ctc = $request->input('expect_ctc');

        $profileNP->user_id = $id;   




        $profileNP->previous_company = $company_data_val->name;

        $profileNP->previous_company_id = $company_data_val->id;
        

         $profileNP->previous_desigination = $request->input('previous_desigination');



        $profileNP->previous_start_date = $request->input('previous_start_date');

        $profileNP->previous_till_date = $request->input('previous_till_date');

        $profileNP->previous_reason = $request->input('previous_reason');

        $profileNP->previous_responsibilities = $request->input('previous_responsibilities');

        $profileNP->previous_work_type = $request->input('previous_work_type');



    

        $profileNP->previous_project_details = $request->input('previous_project_details');

        $profileNP->previous_ctc_start = $request->input('previous_ctc_start');

        $profileNP->previous_ctc_end = $request->input('previous_ctc_end');

        

       

        $profileNP->save();

    }

    else

    {       

        $profileNP = new ProfileCityJobsCity();

        $profile = $id;

        

        $profileNP->user_id = $id;

       

            $profileNP->previous_company = $company_data_val->name;

            $profileNP->previous_company_id = $company_data_val->id;

            $profileNP->previous_desigination = $request->input('previous_desigination');



           $profileNP->previous_start_date = $request->input('previous_start_date');

           $profileNP->previous_till_date = $request->input('previous_till_date');

           $profileNP->previous_reason = $request->input('previous_reason');

           $profileNP->previous_responsibilities = $request->input('previous_responsibilities');

           $profileNP->previous_work_type = $request->input('previous_work_type');



       

           $profileNP->previous_project_details = $request->input('previous_project_details');

           $profileNP->previous_ctc_start = $request->input('previous_ctc_start');

           $profileNP->previous_ctc_end = $request->input('previous_ctc_end');

        

        

        

      

        $profileNP->save();

    }

    // $summary = $request->input('summary');

    // $ProfileSummary = new ProfileSummary();

    // $ProfileSummary->user_id = $user_id;

   

    /*         * ************************************ */

    return response()->json(array('success' => true, 'status' => 200), 200);



}

public function userinfo()
{
    return view('user.info');
}



public function storeFrontProfileSkills(ProfileSkillFormRequest $request,$id)

{



    $profileSkill = new ProfileSkill();

    $profileSkill->user_id = $id;

    // $profileSkill->job_skill_id = $request->input('job_skill_id');

    $profileSkill->project_title = $request->input('project_title');

    $profileSkill->version = $request->input('version');

    $profileSkill->no_of_projects = $request->input('no_of_projects');

    $profileSkill->last_used_year = $request->input('last_used_year');

    

    $profileSkill->job_experience = $request->input('job_experience');

    $profileSkill->save();

    /*         * ************************************ */

    

    return response()->json(array('success' => true, 'status' => 200), 200);

}



public function edititskill(Request $request,$id)

{

    $skill_id = $request->input('skill_id');

    

   

    $jobSkills = DataArrayHelper::defaultJobSkillsArray();

    $jobExperiences = DataArrayHelper::defaultJobExperiencesArray();



    $profileSkill = ProfileSkill::find($skill_id);

    $user = User::find($id);



    $returnHTML = view('user.forms.skill.itskill_edit_modal')

            ->with('user', $user)

            ->with('profileSkill', $profileSkill)

            ->with('jobSkills', $jobSkills)

            ->with('jobExperiences', $jobExperiences)

            ->with('skill_id',$skill_id)

            ->render();

    return response()->json(array('success' => true, 'html' => $returnHTML));

}



public function updateitskill(ProfileSkillFormRequest $request,$id)

{



    $profileSkill = ProfileSkill::find($request->input('skill_id'));

    $profileSkill->user_id = $id;

    $profileSkill->project_title = $request->input('project_title');

    $profileSkill->version = $request->input('version');

    $profileSkill->no_of_projects = $request->input('no_of_projects');

    $profileSkill->last_used_year = $request->input('last_used_year');

    

    $profileSkill->job_experience = $request->input('job_experience');

 

    $profileSkill->update();

    /*         * ************************************ */



    //$returnHTML = view('admin.user.forms.skill.skill_edit_thanks')->render();

    return response()->json(array('success' => true, 'status' => 200), 200);



}



// public function deletefrontcompany()

// {

// return dd($id);



// }

public function getcurrentcompanyeditform($id)

{



return "hello";



}



public function updatecurrentcompany(CompanyFrontRequest $request,$id)

{

    if (is_numeric($request->input('current_company'))){

        $company_data_val = CompanyData::where('id',$request->input('current_company'))->first();
       
    }else{

        $company_data_val = new CompanyData();
        $company_data_val->name = $request->input('current_company');
        $company_data_val->save();
       
    }



    $profileNP = ProfileCityJobsCity::where('user_id', '=', $id)->first();

   // dd($profileNP->previous_till_date);

    if($profileNP->previous_till_date)

    {

     

        $n_date=$profileNP->previous_till_date;

      



    }else{



        $n_date=Carbon::now()->format('m-Y');

    }



    //   dd($n_date);

      $profilegap= ProfileGap::where('user_id',$id)->first();         

      

      $gapti='01-'.$request->input('current_start_date').'';  

                

      $result = CarbonPeriod::create('01-'.$request->input('current_start_date').'', '1 month', '01-'.$n_date.'');

     

      $numItems = count($result);



      

    //  echo $numItems.'<br>';

    $i = 0;

    $ilast = count($result);

    // dd(count($result));

    foreach($result as $key=>$value) {

      if($i==0)

      {

        $first = $value->format("M-Y");

      }

      if($i==$ilast-1)

      {

        $last = $value->format("M-Y");

      }

      

      if(++$i === $numItems) {

        $data=$value->format("M-Y"). "<br>";



        $gaptid='01-'.$data.''."<br>";

 

        $month = date("M",strtotime($gapti));

    

        

      }

    }  

   





   if(count($result) > 6)

      {

          if($profilegap)

          {

              $profilegap->user_id = $id;

              $profilegap->gap_from_month = $first;

              $profilegap->gap_to_month = $last;



              $profilegap->save();

          }else{

              $profilegap = new ProfileGap();

              $profilegap->user_id = $id;

              $profilegap->gap_from_month = $first;

              $profilegap->gap_to_month = $last;



              $profilegap->save();

          }





      }

        

    

    

        $profileNP->user_id = $id;

        $profileNP->current_company = $company_data_val->name;

        $profileNP->current_company_id = $company_data_val->id;

        $profileNP->current_desigination = $request->input('current_desigination');

        $profileNP->current_start_date = $request->input('current_start_date');

        



        $profileNP->current_till_date = $request->input('current_till_date');

        $profileNP->current_work_type = $request->input('current_work_type');        

        $profileNP->current_project_details = $request->input('current_project_details');

        $profileNP->current_reason = $request->input('current_reason');

        $profileNP->current_responsibilities = $request->input('current_responsibilities');

        $profileNP->current_ctc_start = $request->input('current_ctc_start');

        $profileNP->current_ctc_end = $request->input('current_ctc_end');

        $profileNP->save();



        return response()->json(array('success' => true, 'status' => 200), 200);

} 

      

      

      public function getpreviouscompanyeditform($id)

      {

      

      return "hello";

      

      }

      

      

      public function updatepreviouscompany(CompanyPreviousFrontRequest $request,$id)

      {


        if (is_numeric($request->input('previous_company'))){

            $company_data_val = CompanyData::where('id',$request->input('previous_company'))->first();
           
        }else{
    
            $company_data_val = new CompanyData();
            $company_data_val->name = $request->input('previous_company');
            $company_data_val->save();
           
        }

      

        $profileNP = ProfileCityJobsCity::where('user_id', '=', $id)->first();



        

       if($profileNP->current_start_date)

        {

            $n_date=$profileNP->current_start_date;



        }else{



            $n_date=Carbon::now()->format('m-Y');

        }



         //  dd($n_date);

          $profilegap= ProfileGap::where('user_id',$id)->first();         

          

          $gapti='01-'.$request->input('previous_till_date').'';  

                    

          $result = CarbonPeriod::create('01-'.$request->input('previous_till_date').'', '1 month', '01-'.$n_date.'');

          

          $numItems = count($result);

        //  echo $numItems.'<br>';

        $i = 0;

        $ilast = count($result);

        // dd(count($result));

        foreach($result as $key=>$value) {

          if($i==0)

          {

            $first = $value->format("M-Y");

          }

          if($i==$ilast-1)

          {

            $last = $value->format("M-Y");

          }

          

          if(++$i === $numItems) {

            $data=$value->format("M-Y"). "<br>";

    

            $gaptid='01-'.$data.''."<br>";

     

            $month = date("M",strtotime($gapti));

        

            

          }

        }  

    //  dd($last);

       if(count($result) > 6)

          {

              if($profilegap)

              {

                  $profilegap->user_id = $id;

                  $profilegap->gap_from_month = $first;

                  $profilegap->gap_to_month = $last;



                  $profilegap->save();

              }else{

                  $profilegap = new ProfileGap();

                  $profilegap->user_id = $id;

                  $profilegap->gap_from_month = $first;

                  $profilegap->gap_to_month = $last;



                  $profilegap->save();

              }





          }

            

            

      

            $profileNP->user_id = $id;

            $profileNP->previous_company = $company_data_val->name;

            $profileNP->previous_company_id = $company_data_val->id;

            $profileNP->previous_desigination = $request->input('previous_desigination');    

            $profileNP->previous_start_date = $request->input('previous_start_date');

            $profileNP->previous_till_date = $request->input('previous_till_date');

            $profileNP->previous_reason = $request->input('previous_reason');

            $profileNP->previous_responsibilities = $request->input('previous_responsibilities');

            $profileNP->previous_work_type = $request->input('previous_work_type'); 

            $profileNP->previous_project_details = $request->input('previous_project_details');

            $profileNP->previous_ctc_start = $request->input('previous_ctc_start');

            $profileNP->previous_ctc_end = $request->input('previous_ctc_end');           

            $profileNP->save();

            

            return response()->json(array('success' => true, 'status' => 200), 200);

      

      }

      

      
  public function jobstorefrontnp(Request $request,$id)

  {

    /* The new ZNP apply modal no longer asks for Notice Period in the
       form — it now ships only the Mandatory Questionnaire. We still
       accept and persist NOP fields *if they are submitted* so the
       legacy resources/views/job/detail.blade.php apply page keeps
       working unchanged. */
    if ($request->filled('nop_days')) {
        if ($request->nop_days == 2) {
            $this->validate(
                $request,
                ['last_working_day' => 'required'],
                ['last_working_day.required' => 'Last working date is required']
            );
        }
        if ($request->nop_days == 1) {
            $this->validate(
                $request,
                ['immediate_last_date' => 'required'],
                ['immediate_last_date.required' => ' Date is required']
            );
        }

        $profileNP = ProfileNop::where('user_id', '=', $request->user_id)->first();
        if ($profileNP) {
            $profileNP->nop_days            = $request->input('nop_days');
            $profileNP->buyable_nop         = $request->input('buyable_nop');
            $profileNP->last_working_day    = $this->dbdatechange($request->last_working_day);
            $profileNP->immediate_last_date = $request->immediate_last_date;
            $profileNP->user_id             = $request->user_id;
            $profileNP->save();
        } else {
            $profileNP = new ProfileNop();
            $profileNP->nop_days            = $request->input('nop_days');
            $profileNP->buyable_nop         = $request->input('buyable_nop');
            $profileNP->last_working_day    = $this->dbdatechange($request->last_working_day) ?? '';
            $profileNP->immediate_last_date = $request->immediate_last_date;
            $profileNP->user_id             = $request->user_id;
            $profileNP->save();
        }
    }


        // $d =  date("h:i:sa");
        $nowtime =  date("g:i A");
        $todaydate = date("d-m-Y");
      // dd($nowtime);

      $todayDate = date('d-m-Y');
      $nowTime = date('g:i A');
      
    /* ── Legacy interview-availability slots (still posted by the old
         resources/views/job/detail.blade.php apply form). The new ZNP
         apply modal no longer sends date[]/from_time[]/to_time[], so
         we treat slots as optional and only run their validation +
         Interview row save when the legacy form actually submits them. */
    $hasLegacySlots = $request->filled('date') && is_array($request->date) && count($request->date) > 0;

    if ($hasLegacySlots) {
        if ($request->date == $todayDate) {
            $this->validate($request, [
                'date.*'      => 'required',
                'from_time.*' => 'required|date_format:g:i A|after:' . $nowTime,
                'to_time.*'   => 'required|date_format:g:i A|after:from_time.*',
            ], [
                'date.*.required'         => 'Date is required',
                'from_time.*.required'    => 'From Time is required',
                'from_time.*.date_format' => 'From Time should be in valid format',
                'from_time.*.after'       => 'From Time should be after the current time',
                'to_time.*.required'      => 'To Time is required',
                'to_time.*.date_format'   => 'To Time should be in valid format',
                'to_time.*.after'         => 'To Time should be after From Time',
            ]);
        } else {
            $this->validate($request, [
                'date.*'      => 'required',
                'from_time.*' => 'required|date_format:g:i A',
                'to_time.*'   => 'required|date_format:g:i A|after:from_time.*',
            ], [
                'date.*.required'         => 'Date is required',
                'from_time.*.required'    => 'From Time is required',
                'from_time.*.date_format' => 'From Time should be in valid format',
                'to_time.*.required'      => 'To Time is required',
                'to_time.*.date_format'   => 'To Time should be in valid format',
                'to_time.*.after'         => 'To Time should be after From Time',
            ]);
        }

        Interview::where('user_id', $request->id)->delete();
        foreach ($request->date as $index => $date) {
            $interview = new Interview();
            $interview->user_id   = $request->id;
            $interview->date      = $this->dbdatechange($date) ?? '';
            $interview->from_time = $request->from_time[$index] ?? null;
            $interview->to_time   = $request->to_time[$index]   ?? null;
            $interview->save();
        }
    }

    $user_id = $request->id;
    $job = PostJob::where('id', $request->job_id)->first();

    /* ── Mandatory Questionnaire (new ZNP apply flow).
         The job's questionnaire JSON drives which keys we expect; the
         apply form posts answers under `answers[<key>]`. Required
         questions are validated; the answers are then captured as a
         labelled JSON array on job_apply.questionnaire_answers so the
         employer dashboard can render Q&A pairs without needing to
         re-resolve the live job questionnaire (which may have been
         edited after the application was submitted). */
    $jobQuestionnaire = [];
    if ($job && !empty($job->questionnaire)) {
        $decoded = json_decode((string) $job->questionnaire, true);
        if (is_array($decoded)) {
            $jobQuestionnaire = $decoded;
        }
    }

    $rawAnswers       = (array) $request->input('answers', []);
    $questionnaireRow = [];
    $qErrors          = [];

    foreach ($jobQuestionnaire as $q) {
        if (! is_array($q) || empty($q['label'])) continue;
        if (isset($q['enabled']) && ! $q['enabled']) continue;

        $key      = (string) ($q['key']      ?? 'q_' . md5((string) $q['label']));
        $label    = (string) ($q['label']    ?? '');
        $type     = (string) ($q['type']     ?? 'text');
        $required = (bool)   ($q['required'] ?? false);

        $raw = $rawAnswers[$key] ?? null;
        $val = is_string($raw) ? trim($raw) : $raw;

        /* Type-specific normalisation. */
        if ($type === 'yesno') {
            $val = is_string($val) ? ucfirst(strtolower($val)) : '';
            if ($val !== '' && ! in_array($val, ['Yes', 'No'], true)) {
                $qErrors['answers.' . $key] = 'Please choose Yes or No for "' . $label . '".';
                $val = '';
            }
        } elseif ($type === 'number') {
            if ($val !== '' && $val !== null && ! is_numeric($val)) {
                $qErrors['answers.' . $key] = '"' . $label . '" needs a numeric answer.';
                $val = '';
            }
        } elseif ($type === 'url') {
            if ($val !== '' && $val !== null && ! filter_var($val, FILTER_VALIDATE_URL)) {
                $qErrors['answers.' . $key] = '"' . $label . '" needs a valid URL.';
                $val = '';
            }
        }

        if ($required && ($val === '' || $val === null)) {
            $qErrors['answers.' . $key] = '"' . $label . '" is required.';
        }

        $questionnaireRow[] = [
            'key'      => $key,
            'label'    => $label,
            'type'     => $type,
            'required' => $required,
            'answer'   => is_scalar($val) ? (string) $val : '',
        ];
    }

    if (! empty($qErrors)) {
        return response()->json([
            'success' => false,
            'message' => 'The given data was invalid.',
            'errors'  => array_map(function ($m) { return [$m]; }, $qErrors),
        ], 422);
    }

    $matchThese = ['user_id' => $user_id, 'job_id' => $job->id];
    $data = [
        'user_id'                => $user_id,
        'job_id'                 => $job->id,
        'coverletter'            => $request->description,
        'questionnaire_answers'  => ! empty($questionnaireRow) ? json_encode($questionnaireRow) : null,
    ];
    $item = JobApply::updateOrCreate($matchThese, $data);

    if ($item->wasRecentlyCreated === true) {
        event(new JobApplied($job, $item));
    }

    return response()->json(['success' => true, 'status' => 200], 200);

  }

      

   public function storefrontnp(Request $request,$id)

      

      {

//  dd($request);

 $this->validate(
    $request, 
    ['nop_days' => 'required'],
    ['nop_days.required' => ' Notice Period is required']
);

        if($request->nop_days == 2){

    

             $this->validate(
                $request, 
                ['last_working_day' => 'required'],
                ['last_working_day.required' => 'Last working date is required']
            );

            

            }

            if($request->nop_days == 1){

            


                    $this->validate(
                        $request, 
                        ['immediate_last_date' => 'required'],
                        ['immediate_last_date.required' => ' Date is required']
                    );

            

            

            }

            
            $profileNP = ProfileNop::where('user_id', '=', $request->user_id)->first();

        

            if($profileNP)

            {

                $profileNP->nop_days = $request->input('nop_days');

                $profileNP->buyable_nop = $request->input('buyable_nop');

                $profileNP->last_working_day = $this->dbdatechange($request->last_working_day);

               // $profileNP->nop_status = $request->input('nop_status');

                $profileNP->immediate_last_date=$request->immediate_last_date;

                $profileNP->user_id=$request->user_id;

                $profileNP->save();

            }

            else

            {       

                $profileNP = new ProfileNop();

                $profileNP->nop_days = $request->input('nop_days');

                $profileNP->buyable_nop = $request->input('buyable_nop');

                $profileNP->last_working_day = $this->dbdatechange($request->last_working_day)??"";

                //$profileNP->nop_status = $request->input('nop_status');

                $profileNP->immediate_last_date=$request->immediate_last_date;

                $profileNP->user_id=$request->user_id;

                $profileNP->save();

            }

            // $summary = $request->input('summary');

            // $ProfileSummary = new ProfileSummary();

            // $ProfileSummary->user_id = $user_id;

           

            /*         * ************************************ */

            return response()->json(array('success' => true, 'status' => 200), 200);

      }

      

      public function frontupdateoffers(Request $request,$id)

      {

            // return dd($request->ctcoff);
         
        
        $this->validate(
            $request, 
            ['hold' => 'required'],
            ['hold.required' => ' Holding Employment offers is required']
        );


      
        if($request->hold == '1')
        {
        

        $this->validate(
            $request, 
            [
                'expoff' => 'required|max:80',
                'ctcoff1' => 'required|numeric|max:100',
                'dateoff1' => 'required',
                'locoff1' => 'required',
            ],
            [
 
                'expoff.required' => ' Reason for exploring opportunities is required',
                'ctcoff1.required' => ' CTC Offered is required',
                'ctcoff1.max'     => 'Maximum Length is 100',
                'numeric.required'  =>  'CTC Offered must be a number',
                'dateoff1.required' => ' Date of Joining is required',
                'locoff1.required' => ' Location of Job Offer is required'
            ]
          
        );
          
      
        
        
        }

        
        // if($request->ctcoff1){
        
         
        //     $request->validate([
        
              
        //         'ctcoff1'  => 'required',
        //         'dateoff1' => 'required',
        //         'locoff1'  => 'required'
                
                
                
        //         ]);
        
        
        // }
        
            $offers = Offers::where('user_id', '=', $id)->first();
            if($offers)
            {
               
                
              $offers->user_id=$id;
              $offers->hold=$request->input('hold');
              $offers->expoff=$request->input('expoff');
              $offers->repoff=$request->input('repoff');
              $offers->ctcoff1=$request->input('ctcoff1');
              $offers->dateoff1=$request->input('dateoff1');
              $offers->locoff1=$request->input('locoff1');
              if(isset($request->ctcoff)){
                $offers->ctcoff=serialize($request->input('ctcoff'));
                $offers->dateoff=serialize($request->input('dateoff'));
                $offers->locoff=serialize($request->input('locoff'));
              }else{
                $offers->ctcoff='';
                $offers->dateoff='';
                $offers->locoff='';
              }
              
             
             
              $offers->save();
           
            //    $data=Offers::update([
            //    'user_id'=>$user_id,
            //    'hold' => $request->input('hold'),
            //    'expoff'=>$request->input('expoff'),
            //    'repoff'=>$request->input('repoff'),
            //    'ctcoff'=>serialize($request->input('ctcoff')),
            //    'dateoff'=>serialize($request->input('dateoff')),
            //    'locoff'=>serialize($request->input('locoff'))           
               
            //    ]);
              
       
            }
            else
            {   
            
            
                $offers = new Offers();
                
                $offers->create([
                    'user_id'=>$id,
                    'hold' => $request->input('hold'),
                    'expoff'=>$request->input('expoff'),
                    'repoff'=>$request->input('repoff'),
                    'ctcoff1'=>$request->input('ctcoff1'),
                    'dateoff1'=>$request->input('dateoff1'),
                    'locoff1'=>$request->input('locoff1'),
                    'ctcoff'=>serialize($request->input('ctcoff')),
                    'dateoff'=>serialize($request->input('dateoff')),
                    'locoff'=>serialize($request->input('locoff'))           
                    
                    ]);
                  
      
          
               
            }
       
           
            /*         * ************************************ */
            return response()->json(array('success' => true, 'status' => 200), 200);
          
          }

      

      public function getautocompletesearch($id)

      {

      

      return dd('hello');

      

      }

      

      

    function fetch(Request $request)

    {
        

     if($request->get('query'))

     {

      $query = $request->get('query');

      $data = DB::table('job_skills')

        ->where('job_skill', 'LIKE', "%{$query}%")

        ->get();

        return response()->json($data);

    //   $output = '<ul class="dropdown-menu" style="display:block; position:relative">';

    //   foreach($data as $row)

    //   {

    //    $output .= '

    //    <li><a href="#">'.$row->job_skill.'</a></li>

    //    ';

    //   }

    //   $output .= '</ul>';

    //   echo $output;

    echo $data;

     }

    }

    

      

    function index()

    {

     return view('autocomplete');

    }

    

    

    public function storefrontkeyskills(Request $request,$id)

    

    {

    

   

     dd($request);



   

 foreach($request->keyskills as $keyskill)

 {

 

 

 

 $check_skill = KeySkill::all();

 

 $key= KeySkill::where('user_id',$id)->first();

 

 //  dd($key);

 $test=KeySkill::where('keyskill',$keyskill)->where('user_id',$id)->first();

 

     if($test)

    {



// dd('value');

    

     $test->user_id = $id;

     $test->keyskill= $keyskill;

     $test->save();

     

    }else{

    

 //dd('no value');

    $key_new= new KeySkill();

    $key_new->user_id=$id;

    $key_new->keyskill =$keyskill;

    $key_new->save();

    

    //    $data= KeySkill::create([

    //         'user_id'=>$id,

    //       'keyskill' => $keyskill

    //   ]);

    // dd($data);

    }

     

     

    //  return dd('success');



     return redirect()->back();

    

    }

    

    

    }

    

    public function keyskillfront($id)

    {

    

    return dd('hello');  

    

    }

    public function updatefrontkeyskills(MajorSubjectFormRequest $request,$id)    

    {


        if($request->keyskills)

        {

           // dd($request->keyskills);


            $delete = KeySkill::where('user_id',$id)->get();

            // dd($delete);

            if($delete)

            {

            

                foreach($delete as $dele)

                {

                  $dele->delete();

                }

            }
 

             foreach($request->keyskills as $keyskill)

             {
               


          $skills = jobSkill::where('id',$keyskill)->get();




          if(count($skills) > 0)
          {

             $key_new= new KeySkill();

             $key_new->user_id=$id;

             $key_new->keyskill =$keyskill;

             $key_new->save();
           

          }else{

             $key_new= new JobSkill();            

             $key_new->job_skill =$keyskill;

             $key_new->save();


             $key_sk= new KeySkill();

             $key_sk->user_id=$id;

             $key_sk->keyskill =$key_new->id;

             $key_sk->save();
            
          }
                





                }

                $user = User::where('id',$id)->first();

                $user->complete = $user->complete + 3;

                $user->profile_completion = $user->profile_completion + 2;

                $user->save();

    
        }
        

    return response()->json(array('success' => true, 'status' => 200), 200);

}

    

    

    public function storefrontgap(Request $request,$id)

    {

 
        $this->validate(
            $request, 
            ['reason' => 'required|max:200'],
            ['reason.required' => 'Reason is required']
        );


 

        

        //   dd($last);

        //   dd($first);
        

          

          

          

        $gap = ProfileGap::where('user_id',$id)->first();

        

        if($gap)

        {

        $gap->user_id=$id;

        $gap->reason = $request->reason;

        // $gap->gap_from_month = $first;

        // $gap->gap_to_month = $last;

    

        $gap->save();

        

        }else{

        

        $gap1=new ProfileGap();

        $gap1->user_id=$id;

        $gap1->reason= $request->reason;

        $gap1->save();

        

        }

      

      

      return response()->json(array('success' => true, 'status' => 200), 200);

    

    }

    

    public function homesearch1(Request $request)

{
    

$location = $request->location;

$notice_period = $request->notice_period;

$keyskill = $request->skills;
$selected_skill = $request->skills;




   $home_users = User::whereHas('profilekeyskill', function($q) use($keyskill){
if($keyskill)
{
    $q->where('keyskill', [$keyskill]);
}
            

           })->whereHas('profileNop', function($q) use($notice_period,$location){
               if($notice_period)
               {
                $q->where('nop_days', $notice_period);
               }

            

        })->where('current_location','like', '%' . $location . '%')->where('complete','>=',13)->get();



// dd($home_users);




       return view('home',compact('home_users','location','notice_period','keyskill','selected_skill'));



}

public function userListing()

{

    return view("user.user_listing");

}





public function changePassword()

{

    $user = User::findOrFail(Auth::user()->id);

    return view('auth.passwords.change_password',compact('user'));

}



public function updatePassword(Request $request,$id)

{

   //dd($request);


    // $user = User::findOrFail(Auth::user()->id);



    $this->validate(

        $request, 
        [
            'old_password'=>'required',
    
            'new_password' =>'required|min:6|max:12',
        
            'new_password_confirmation'  => 'required|same:new_password|min:6|max:12'
        ],
        [
    
            'old_password.required' => ' Old Password is required',
            'new_password.required' => ' New Password is required',
            'new_password_confirmation.required' => ' Confirm New Password is required',
            'new_password_confirmation.same'   => "Confirm New Password Doesn't Match",
           
        ],
    );



    $hashedPassword = Auth::user()->password;



    if (\Hash::check($request->old_password , $hashedPassword )) {



        if (!\Hash::check($request->new_password , $hashedPassword))

        {

            $users =User::find(Auth::user()->id);

            $users->password = bcrypt($request->new_password);

            User::where( 'id' , Auth::user()->id)->update( array( 'password' =>  $users->password));

            

            // session()->flash('message','Password updated successfully');

            // return back()->with('success', 'Password updated successfully!');

            return redirect()->back()->with('message', 'Password updated successfully');

        }



        else{

            return redirect()->back()->with('message', "New password can not be the old password");

        }

    }

    else{

        return redirect()->back()->with('error', "Old password doesn't matched");

    }

}





public function imagestore(Request $request)

{

  //dd($request->image);









 $user =User::find(Auth::user()->id);



if ($request->hasFile('image')) {

   // dd($request->image);



   // dd('file');

    $is_deleted = $this->deleteUserImage($user->id);

    $image = $request->file('image');

    $fileName = ImgUploader::UploadImage('user_images', $image, $request->input('name'), 115, 115, false);

    $user->image = $fileName;

}

$user->save();



}





public function fetchemployersData(Request $request)
{
   // dd('heloo');
    if ($request->ajax()) {
        $data = User::get();
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                       $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
 
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }
  
    return view('admin.employer.index');
}


public  function getcompnies(Request $request)
{

    $companies = [];
    if($request->has('q')){
        $search = $request->q;
        $companies =DB::table('company_data')->select('id','name')->distinct()->get();
    }
    return response()->json($companies);
}

public function storefrontaccomplishments(Request $request)
{
    $request->validate([

        'profile_name' => 'required|max:256',
        'profile_url' => 'required|max:256',
        'description' => 'required|max:1000'
    ]);

    $acc = new Accomplishment();
    $acc->user_id = Auth::user()->id;
    $acc->profile_name = $request->profile_name;
    $acc->profile_url = $request->profile_url;
    $acc->description = $request->description;
    $acc->save();

    return response()->json(array('success' => true, 'status' => 200), 200);
    
}

public function getfrontaccomplishmentEditForm(Request $request, $id)
{
    $accomplishment_id = $request->input('accomplishment_id');
    $accomplishment = Accomplishment::find($accomplishment_id);
    $user = User::find($id);
    
    $returnHTML = view('user.forms.accomplishment.accomplishment_edit_modal')
            ->with('user', $user)
            ->with('accomplishment', $accomplishment)
            ->render();
    return response()->json(array('success' => true, 'html' => $returnHTML));
}

public function updatefrontaccomplishments(Request $request,$id)
{

    $request->validate([

        'profile_name' => 'required|max:256',
        'profile_url' => 'required|max:256',
        'description' => 'required|max:1000'
    ]);

    $acc = Accomplishment::find($request->input('accomplishment_id'));
   
    $acc->user_id = $id;
    $acc->profile_name = $request->profile_name;
    $acc->profile_url = $request->profile_url;
    $acc->description = $request->description;    
    $acc->save();

    return response()->json(array('success' => true, 'status' => 200), 200);


}

    
public function deleteaccomplishments(Request $request)
{
    $id = $request->input('id');
    echo $this->removeaccomplishment($id);
}

private function removeaccomplishment($id)
{
    try {
       
        $accomplishment = Accomplishment::findOrFail($id);
        $accomplishment->delete();
        return 'ok';
    } catch (ModelNotFoundException $e) {
        return 'notok';
    }
}


public function storewhitepaper(Request $request)
{

   // dd($request->all());
    $request->validate([

        'white_paper' => 'required'
    ]);

    $user = User::where('id',$request->user_id)->first();
    $user->white_paper = $request->white_paper;
    if ($request->hasFile('file')) {
    
        // $request->validate([

        //     'file'=>'required|mimes:pdf,docx|max:2048'     

        //     ]);

        $cv_file = $request->file('file');

        $fileName = ImgUploader::UploadDoc('whitepaper', $cv_file, $request->input('title'));

        $user->file= $fileName;

    }
    $user->save();

    return response()->json(array('success' => true, 'status' => 200), 200);
}
    




}

    

    



