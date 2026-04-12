<?php



namespace App\Http\Controllers\Auth;



use App\User;

use Auth;

use Socialite;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

use App\ProfileLanguage;

use App\KeySkill;

use App\ProfileNop;

use App\Offers;

use App\ProfileDetails;

use App\ProfileSummary;

use App\ProfileCityJobsCity;

use App\ProfileSkill;

use App\ProfileProject;

use App\ProfileEducation;

use App\Certificate;

use App\ProfileGap;

use Session;



class LoginController extends Controller

{

    /*

      |--------------------------------------------------------------------------

      | Login Controller

      |--------------------------------------------------------------------------

      |

      | This controller handles authenticating users for the application and

      | redirecting them to your home screen. The controller uses a trait

      | to conveniently provide its functionality to your applications.

      |

     */



use AuthenticatesUsers;



    /**

     * Where to redirect users after login.

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
        $this->middleware('guest')->except('logout');
    }



    /**

     * Redirect the user to the OAuth Provider.

     *

     * @return Response

     */

    public function redirectToProvider($provider)

    {

        return Socialite::driver($provider)->redirect();

    }



    /**

     * Obtain the user information from provider.  Check if the user already exists in our

     * database by looking up their provider_id in the database.

     * If the user exists, log them in. Otherwise, create a new user then log them in. After that 

     * redirect them to the authenticated users homepage.

     *

     * @return Response

     */

    public function handleProviderCallback($provider)

    {

        

        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);

        return redirect($this->redirectTo);

    }



    /**

     * If a user has registered before using social auth, return the user

     * else, create a new user object.

     * @param  $user Socialite user object

     * @param $provider Social auth provider

     * @return  User

     */

    public function findOrCreateUser($user, $provider)

    {

        if ($user->getEmail() != '') {

            $authUser = User::where('email', 'like', $user->getEmail())->first();

            if ($authUser) {

                /* $authUser->provider = $provider;

                  $authUser->provider_id = $user->getId();

                  $authUser->update(); */

                return $authUser;

            }

        }

        $str = $user->getName() . $user->getId() . $user->getEmail();

        return User::create([

                    'first_name' => $user->getName(),

                    'middle_name' => $user->getName(),

                    'last_name' => $user->getName(),

                    'name' => $user->getName(),

                    'email' => $user->getEmail(),

                    //'provider' => $provider,

                    //'provider_id' => $user->getId(),

                    'password' => bcrypt($str),

                    'is_active' => 1,

                    'verified' => 1,

        ]);

    }
    
    public function showLoginForm()
    {
    
        return view('auth.login');
    }

    public function showJobseekerAuth()
    {
        $educations = \App\Education::orderBy('education')->get();
        return view('znp.jobseeker-auth', compact('educations'));
    }

    public function login(Request $request)

    {

        if(Auth::guard('company')->user() !== null)
        {
          //  dd(Auth::guard('company')->user());

            return redirect()->back()->with('error_message1', 'Please logout of the Employer account');
                   
        }else{   
       

        $request->validate([

            'email' => 'required',

            'password' => 'required',

        ]);

        // return dd($request->all());

        $credentials = $request->only('email', 'password');

        $user = User::where('email',$request->email)->first();

        if($user)

        {

            if($user->is_active==1)

            {

                if($user->email_verified==1)

                {
                if (Auth::attempt($credentials)) {


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

       if(isset($user->current_city) && isset($lang->language) && isset($keyskill->keyskill) && isset($profileNP->last_working_day) && isset($offers->repoff) && isset($compensation->expect_ctc_lakhs) && isset($interview->video_date_from) && isset($summary->summary) && isset($company->current_company) && isset($education->organization) && isset($certificate->certificate_name) && isset($interview->shifts))
       {
        $yes = 1;
       
       }else{

         $yes = 0;
        

       }


                  $intendedUrl = Session::pull('url.intended', 'my-profile');

                   /// dd($intendedUrl);

                    return redirect()->to($intendedUrl);

                }

                else{

                     return redirect()->back()->withInput($request->only('email','remember'))->with('error_message1', 'You have entered invalid credentials!');

                   

                }
            }

            else{

                 return redirect()->back()->withInput($request->only('email','remember'))->with('verify_message', 'Email verfication is pending. If you not received? <a href="' . route('verification.resend', $user->id) . '">Click here to Resend</a>');

               

            }

            }

            else{

                return redirect()->back()->withInput($request->only('email','remember'))->with('error_message', 'Your account deactivated!');

            }


        }



        else{

             return redirect()->back()->withInput($request->only('email','remember'))->with('error_message1', 'Please enter valid email!');

            

        }


      
    }

    }

}

