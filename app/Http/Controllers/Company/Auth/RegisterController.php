<?php

namespace App\Http\Controllers\Company\Auth;

use App\Company;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use App\Http\Requests\Front\CompanyFrontRegisterFormRequest;
use Illuminate\Auth\Events\Registered;
use App\Events\CompanyRegistered;
use App\Package;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Traits\CompanyTrait;
use App\CompanyActivity;
use Stevebauman\Location\Facades\Location;
use Carbon\Carbon;
use ImgUploader;

use App\Traits\CompanyPackageTrait;

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
    use CompanyTrait;

    use CompanyPackageTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '//';
    protected $userTable = 'companies';
    protected $redirectIfVerified = '//';
    protected $redirectAfterVerification = '//';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('company.guest', ['except' => ['getVerification', 'getVerificationError']]);
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('company');
    }

    public function register(CompanyFrontRegisterFormRequest $request)
    {
        $data = Route::currentRouteAction();
        ;
        return dd($data);

        $company = new Company();
        $company->name = $request->input('name');
        $company->email = $request->input('email');
        $company->password = bcrypt($request->input('password'));
        $company->is_active = 0;
        $company->verified = 0;

        $company->save();
        /*         * ******************** */
        $company->slug = Str::slug($company->name, '-') . '-' . $company->id;
        $company->update();
        /*         * ******************** */

        event(new Registered($company));
        event(new CompanyRegistered($company));
        $this->guard()->login($company);
        UserVerification::generate($company);
        UserVerification::send($company, 'Company Verification', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
        return $this->registered($request, $company) ?: redirect($this->redirectPath());
    }

    public function showRegistrationForm()
    {
        // dd('helo');
        return view('auth.register1');
    }

    public function storeregister(Request $request)
    {



        $this->validate(

            $request,
            [
                'company_name' => 'required',
                'email' => 'required|email|unique:companies,email|unique:users,email',
                'mobile' => 'required|numeric|digits:10',
                'person_name' => 'required',
                'size' => 'required',
                'pincode' => 'required|numeric|digits:6',
                'gstin' => 'max:15',
                'terms' => 'required',
                'designation' => 'required',
                'linkedin' => 'nullable|url',
                'password' => 'required|min:6|max:50',
                'confirm_password' => 'required|same:password|min:6|max:50',
                'company_type' => 'required'
            ],
            [

                'company_name.required' => ' Company Name is required',
                'email.required' => ' Email is required',
                'mobile.required' => ' Mobile/Landline is required',
                'person_name.required' => ' Contact Person Name is required',
                'size.required' => ' Company/Recruitment Firm is required',
                'pincode.required' => 'Pin Code is required',
                'gstin.max' => ' The maximum limit is 15 characters',
                'terms.required' => ' Terms and Conditions is required',
                'linkedin.required' => 'Linked In is required',
                'password.required' => __('Password is required'),

                'password.min' => __('The password must be at least 6 characters.'),

                'confirm_password.required' => __('Confirm Password is required'),

                'confirm_password.min' => __('The password must be at least 6 characters.'),

                'confirm_password.same' => __(' The password confirmation does not match.'),

                'company_type.required' => 'Company Type is required'


            ]
        );




        $company = new Company();

        $token = Str::lower(Str::random(25));

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $fileName = ImgUploader::UploadImage('company_logos', $image, 300, 300, false);
            $company->logo = $fileName;

        }

        $company->company_type = $request->input('company_type');

        $company->name = $request->input('company_name');

        $company->ceo = $request->input('person_name');

        $company->email = $request->input('email');

        $randompassword = Str::random(6);

        $password = Hash::make($request->input('password'));

        $company->password = $password;

        $company->designation = $request->input('designation');

        $company->phone = $request->input('mobile');
        
        $company->linkedin            = $request->input('linkedin');
        $company->gstin               = $request->input('gstin');
        $company->size                = $request->input('size');
        $company->pincode             = $request->input('pincode');
        $company->promotional         = $request->has('promotional') ? 1 : 0;
        $company->is_gptw_certified   = $request->has('is_gptw_certified') ? 1 : 0;
        $company->is_top_employer     = $request->has('is_top_employer') ? 1 : 0;
        $company->is_disability_hiring = $request->has('is_disability_hiring') ? 1 : 0;
        $company->is_women_friendly   = $request->has('is_women_friendly') ? 1 : 0;

        $company->is_active = 1;

        $company->is_featured = 1;

        $company->search = 0;

        $company->verification_token = $token;

        $company->save();

        /*         * ******************************* */

        $company->slug = Str::slug($company->company_name, '-') . '-' . $company->id;

        /*         * ******************************* */

        $company->update();

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }


        $now = Carbon::now();

        $locationData = Location::get($ip);
        $data = CompanyActivity::create([

            'date' => $now,
            //    'location' => $locationData->cityName ,
            'company_id' => $company->id
        ]);

        $data = [
            'title' => $request->input('email'),
            'link' => url('company/email-verify/' . $token),
            'c_name' => $request->input('ame'),
        ];
        Mail::send('emails.employer_registered_verification', $data, function ($message) use ($data) {
            $message->to($data['title'])->from('info@zeronoticeperiod.com')
                ->subject('Employer Account Verification');
        });


        $data = [

            'title' => $request->input('email'),

            'subject' => 'Employer Account Created On ZNP Team',

            'content' => $request->input('password'),

            'c_name' => $request->input('name'),

            'link' => route('employer.login'),

        ];

        // $package = Package::where('package_title','=','Trail')->first();

        // if ($package) {

        //     $package_id = $package->id;

        //     $package = Package::find($package_id);

        //      $this->addCompanyPackage($company, $package);

        //     // $this->addCompanySearchPackage($company, $package);

        // }





        Mail::send('emails.employer_registered_admin', $data, function ($message) use ($data) {
            $message->to($data['title'])->from('info@zeronoticeperiod.com')
                ->subject($data['subject']);
        });

        return redirect()->back()->with('success', 'Registration was completed successfully. Please verify your email address.');
        // $data1 = [
        //     'message' => 'Welcome Recruiter!',
        //     'message1' => '0',
        // ];
        // //   return redirect('coming-soon');
        // $this->guard()->login($company);

        // return redirect()->intended('/employer-dashboard');

        //  ->with($data1);
    }
    public function storeEnquiry(Request $request)
    {


        $this->validate(

            $request,
            [
                'company_name' => 'required',
                'email' => 'required|email|unique:companies',
                'mobile' => 'required|numeric|digits:10',
                'person_name' => 'required',
                'size' => 'required',
                'pincode' => 'required|numeric|digits:6',
                'gstin' => 'max:15',
                'terms' => 'required',
                //  'package_name' =>'required',

            ],
            [

                'company_name.required' => ' Company Name is required',
                'email.required' => ' Email is required',
                'mobile.required' => ' Mobile/Landline is required',
                'person_name.required' => ' Contact Person Name is required',
                'size.required' => ' Company/Recruitment Firm is required',
                'pincode.required' => 'Pin Code is required',
                'gstin.max' => ' The maximum limit is 15 characters',
                'terms.required' => ' Terms and Conditions is required',
                //  'package_name.required' => ' Confirm New Password is required',


            ]
        );


        $company = new Company();

        /*         * **************************************** */



        /*         * ************************************** */

        $company->name = $request->input('company_name');

        $company->ceo = $request->input('person_name');

        $company->email = $request->input('email');

        $randompassword = Str::random(6);

        $password = Hash::make($randompassword);

        $company->password = $password;

        $company->phone = $request->input('mobile');

        $company->is_active = 1;

        $company->is_featured = 1;

        $company->search = 10;

        $company->save();

        /*         * ******************************* */

        $company->slug = Str::slug($company->company_name, '-') . '-' . $company->id;

        /*         * ******************************* */

        $company->update();


        $data = [

            'title' => $request->input('email'),

            'subject' => 'Employer Account Created On ZNP Team',

            'content' => $randompassword,

            'c_name' => $request->input('name'),

            'link' => route('employer.login'),

        ];


        Mail::send('emails.employer_registered_admin', $data, function ($message) use ($data) {


            $message->to($data['title'])->from('info@zeronoticeperiod.com')


                ->subject($data['subject']);

        });

        $this->guard()->login($company);

        //   return redirect('/');


        return response()->json(array('success' => true, 'status' => 200, 'plan_id' => $request->package_name), 200);
    }
    public function VerifyEmployer(Request $request, $token)
    {
        $data = Company::where('verification_token', $token)->first();
        if (!$data) {
            abort(404);
        }

        $data->verification_token = null;
        $data->email_verified_at = now();
        $data->email_verified = 1;
        $data->save();
        return view('email-verified');
    }

}
