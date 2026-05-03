<?php



namespace App\Http\Controllers\Auth;



use App\User;

use ImgUploader;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

use Illuminate\Foundation\Auth\RegistersUsers;

use Jrean\UserVerification\Traits\VerifiesUsers;

use Jrean\UserVerification\Facades\UserVerification;

use App\Http\Requests\Front\UserFrontRegisterFormRequest;

use Illuminate\Auth\Events\Registered;

use App\Events\UserRegistered;


use App\ProfileNop;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Mail;

use App\ProfileDetails;

use App\CompanyData;

use App\ProfileSummary;

use App\ProfileEducation;

use App\KeySkill;

use App\JobSkill;

use App\Degree;


class RegisterController extends Controller

{

    

    /*

      |--------------------------------------------------------------------------

      | Register Controller

      |--------------------------------------------------------------------------

      |

      | This controller handles the registration of new users as well as their

      | validation and creation. By default this controller uses a trait to

      | provide this functionality without requiring any additional code.

      |

     */



use RegistersUsers;

    use VerifiesUsers;



    /**

     * Where to redirect users after registration.

     *

     * @var string

     */

    protected $redirectTo = '/my-profile';



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('guest', ['except' => ['getVerification', 'getVerificationError']]);

    }

    public function dbdatechange($date)

    {

       $date= date("Y-m-d", strtotime($date));

       return $date;

    }

    public function register(UserFrontRegisterFormRequest $request)

    {

    //  dd($request->all()); 

  

        $fileName = '';

        if ($request->hasFile('resume')) {

            $cv_file = $request->file('resume');

            $fileName = ImgUploader::UploadDoc('cvs', $cv_file, $request->input('title'));

        }
        $ignored_companies = [];
        
        // Support both array (ignore_companies[]) and comma-separated text (ignore_companies_text)
        $ignoreInput = $request->ignore_companies
            ?? (array_filter(array_map('trim', explode(',', $request->ignore_companies_text ?? ''))));

        if (!empty($ignoreInput))
        {
              foreach($ignoreInput as $company)

        {
           // dd($company);

            if (is_numeric($company)){

                $company_data_val = CompanyData::where('id',$company)->first();
            
            }else{
        
                $company_data_val = new CompanyData();
                $company_data_val->name = $company;
                $company_data_val->save();
            
            }

            $ignored_companies[] = $company_data_val->id;
     
       }
        }else{
             $ignored_companies = NULL;
        }

      


       
        // dd($ignored_companies);
       

        $user = User::create([

            'first_name' => $request->input('first_name'),

            'last_name' => $request->input('last_name'),

            'email'     => $request->input('email'),

            'phone'   => $request->input('phone'),

            'password' => bcrypt($request->input('password')),

            'resume'    => $fileName,

            'current_city'  => $request->current_city,

            'locality'      => $request->locality,

            'linkedin_url'  => $request->linkedin_url,

            'reason_moved'  => $request->reason_moved,

            'mode_of_separation' => $request->mode_of_separation,

            'date_of_birth' => $request->input('date_of_birth'),

            'industry_domain' => $request->input('industry_domain'),

            'hide_cv_from_current_employer' => $request->boolean('hide_cv_from_current_employer'),

            'accuracy_confirmed' => $request->boolean('accuracy_confirmed'),

            'pref_job_alerts' => $request->boolean('pref_job_alerts'),

            'pref_platform_tips' => $request->boolean('pref_platform_tips'),

            'pref_promotions' => $request->boolean('pref_promotions'),

            'terms_accepted_at' => now(),

            'is_active' => 1,

            'verified'   => 0,

            'email_verified'  => 0,

            'phone_verified'  => 0,

            'no_profile_views' => 0,

            'no_of_downloads' =>0,

            'no_of_emails'  => 0,

            'complete'   => 3,

            'profile_completion' => 2,

            'payment_status' => 0,

           'ignore_companies' =>  serialize($ignored_companies),

           




        ]);
        
        $user = User::where('id',$user->id)->first();
        $user->gender_id = $request->gender_id;
        if($request->prefered_city){
            $user->prefered_city = serialize($request->prefered_city);
        }

        $user->added = "Candiate";
        $user->save();

        

            


      ///  dd($user);

        $profileNP = ProfileNop::where('user_id', '=', $user->id)->first();

        if($profileNP)

        {

            $profileNP->nop_days = $request->nop_days;

            $profileNP->last_working_day = $request->last_working_day;

            $profileNP->lwd_proof = $request->lwd_proof;

            $profileNP->immediate_last_date = $request->immediate_last_date;

            $profileNP->contract = $request->contract;

            $profileNP->save();

        }else{

            $nop = new ProfileNop();

            $nop->user_id = $user->id;
            
            $nop->last_working_day = $request->last_working_day;

            $nop->lwd_proof = $request->lwd_proof;

            $nop->immediate_last_date = $request->immediate_last_date;

            $nop->nop_days = $request->nop_days;

            $nop->contract = $request->contract;

            $nop->save();

        }

            $data = [

            'title' =>   $request->input('email'),

            'subject'  => 'Welcome to ZeroNoticePeriod | Jobseeker Account Created',

            'content' =>  $request->input('password'),

            'name'     => $request->input('first_name'),

            'link' => route('login'),

        ];


        $compensation = ProfileDetails::where('user_id', '=', $user->id)->first();

       if($compensation)
        {
            $compensation->candidate_wfh = $request->work_option;
            $compensation->expect_ctc_lakhs = $request->expect_ctc_lakhs;
            $compensation->expect_ctc_thousand = $request->expect_ctc_thousand;
            $compensation->expect_ctc_lakhs3 = $request->expect_ctc_lakhs3;
            $compensation->expect_ctc_thousand3 = $request->expect_ctc_thousand3;
            $compensation->work_type = $request->work_type;
            $compensation->save();
        }else{
            $newcompensation = new ProfileDetails();
            $newcompensation->user_id = $user->id;
            $newcompensation->candidate_wfh = $request->work_option;
            $newcompensation->expect_ctc_lakhs = $request->expect_ctc_lakhs;
            $newcompensation->expect_ctc_thousand = $request->expect_ctc_thousand;
            $newcompensation->expect_ctc_lakhs3 = $request->expect_ctc_lakhs3;
            $newcompensation->expect_ctc_thousand3 = $request->expect_ctc_thousand3;
            $newcompensation->work_type = $request->work_type;
            $newcompensation->save();
        }
        if (is_numeric($request->input('latestcom'))){

            $company_data_val = CompanyData::where('id',$request->input('latestcom'))->first();
        
        }else{
    
            $company_data_val = new CompanyData();
            $company_data_val->name = $request->input('latestcom');
            $company_data_val->save();
        
        }
        


        $summary = ProfileSummary::where('user_id', '=', $user->id)->first();


        if($summary)
        {
            $summary->latestcom = $company_data_val->name;
            $summary->latestcom_id = $company_data_val->id;            
            $summary->latestdesg = $request->latestdesg;
            $summary->totalexp = $request->totalexp;
            $summary->totalexpmonth = $request->totalexpmonth;
            $summary->save();
        }else{

            $newsummary = new ProfileSummary();
            $newsummary->user_id = $user->id;
            $newsummary->latestcom = $company_data_val->name;
            $newsummary->latestcom_id = $company_data_val->id;
            $newsummary->latestdesg = $request->latestdesg;
            $newsummary->totalexp = $request->totalexp;
            $newsummary->totalexpmonth = $request->totalexpmonth;
            $newsummary->save();

        }

        //Keyskills Section 

        if($request->keyskills)

        {

           // dd($request->keyskills);


            $delete = KeySkill::where('user_id',$user->id)->get();

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

             $key_new->user_id=$user->id;

             $key_new->keyskill =$keyskill;

             $key_new->save();
           

          }else{

             $key_new= new JobSkill();            

             $key_new->job_skill =$keyskill;

             $key_new->save();


             $key_sk= new KeySkill();

             $key_sk->user_id=$user->id;

             $key_sk->keyskill =$key_new->id;

             $key_sk->save();
            
          }
                





                }

                $user = User::where('id',$user->id)->first();

                $user->complete = $user->complete + 3;

                $user->profile_completion = $user->profile_completion + 2;

                $user->save();

    
        }
        

        $education = ProfileEducation::where('user_id', '=', $user->id)->first();


        if($education)
        {
            if (is_numeric($request->input('organization'))){
   
            $education->degree_title = $request->degree_title;
            $education->course = $request->course??'NULL';
            $education->year_of_completion = $request->year_of_completion??'NULL';
            $education->education_status = $request->education_status;
            $education->specilation = $request->specilation??'NULL';
            $education->organization = $request->organization;
            $education->save();
        
            }else{
        
                $organization = new Degree();
                $organization->educations = $request->input('organization');
                $organization->save();
                
                $education->degree_title = $request->degree_title;
                $education->course = $request->course??'NULL';
                $education->year_of_completion = $request->year_of_completion??'NULL';
                $education->education_status = $request->education_status;
                $education->specilation = $request->specilation??'NULL';
                $education->organization = $organization->id;
                $education->save();
            
            }
           
        }else{           

            $education = new ProfileEducation();
            $education->user_id = $user->id;
            $education->year_of_completion = $request->year_of_completion;
            $education->degree_title = $request->degree_title;
            $education->education_status = $request->education_status;
            $education->course = $request->course??'NULL';
            $education->specilation = $request->specilation??'NULL';
            if($request->input('organization'))
            {
                if (is_numeric($request->input('organization')) ){
                    $education->organization = $request->organization;
                    }else{
                        $organization = new Degree();
                        $organization->educations = $request->input('organization');
                        $organization->save();
                    $education->organization =  $organization->id;
                    }
            }else{
                $education->organization =  NULL;

            }
          
            $education->save();
        
        }


        // Mail::send('emails.frontuserregistered', $data, function($message) use ($data) {

        //     $message->to($data['title'])->from('info@zeronoticeperiod.com')

        //     ->subject($data['subject']);

        //   });

        

        /*         * *********************** */
        // $user->sendEmailVerificationNotification();
        $res = event(new Registered($user));
        // $res = event(new UserRegistered($user));
        // echo "<pre>";print_r($res);
        //   echo "done";exit;

        // $this->guard()->login($user);

        // UserVerification::generate($user);

        // UserVerification::send($user, 'User Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));

        // return $this->registered($request, $user) ?: redirect($this->redirectPath());
        return redirect(route('jobseeker.auth'))->with('new_message', "Thank you for registering! We've sent a verification email to your registered email address. Please verify your email to activate your account and then use the 'Sign In' option below to log in.");


    }



}

