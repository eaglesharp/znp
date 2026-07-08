<?php



namespace App\Http\Controllers\Company;

use App\CompanyVerify;

use App\ProfileCityJobsCity;

use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Mail;

use Hash;

use URL;

use App\ProfileSummary;

use App\SaveSearch;

use App\JobSkill;

use App\Template;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Draft;

use Response;

use File;

use Illuminate\Support\Facades\Session;

use App\Jobs\SendBulkQueueEmail;

use ImgUploader;

// use Auth;

use Validator;

use App\ProfileDetails;

use DB;

use Input;

use Redirect;

use App\Subscription;

use Newsletter;

use App\User;

use App\Company;

use App\CompanyMessage;

use App\ApplicantMessage;

use App\Country;

use App\CountryDetail;

use App\State;

use App\City;

use App\Unlocked_users;

use App\Industry;

use App\FavouriteCompany;

use App\Package;

use App\FavouriteApplicant;

use App\OwnershipType;

use App\JobApply;

use Carbon\Carbon;

use App\Helpers\MiscHelper;

use App\Helpers\DataArrayHelper;

use App\Http\Requests;

use App\Mail\CompanyContactMail;

use App\Mail\ApplicantContactMail;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests\Front\CompanyFrontFormRequest;

use App\Http\Controllers\Controller;

use App\Traits\CompanyTrait;

use App\Traits\Cron;

use Illuminate\Support\Str;

use App\Collection;

use App\CollectionList;
use App\EmployerPayment;
use App\KYC;
use App\Location;
use App\Mail\ReportAbuseCompany;
use App\ReportAbuseCompanyMessage;

use App\Mail\KYCEmail;

class CompanyController extends Controller
{



    use CompanyTrait;

    use Cron;



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {

        $this->middleware('company', ['except' => ['companyDetail', 'sendContactForm']]);

        //FExpi$this->runCheckPackageValidity();

    }









    public function viewPublicProfile(Request $request, $id)
    {





        $c_id = Auth::guard('company')->user()->id;

        //  dd($c_id);

        $com = Company::where('id', $c_id)->first();

        $now = Carbon::now();

        $end_date = $com->package_end_date;


        $user_id = User::where('id', $id)->first();



        // dd($user_id->verified);



        $balance = $com->cvs_quota - $com->availed_cvs_quota;



        $email_balance = $com->email_quota - $com->availed_email_quota;



        $normal_cv_balance = $com->normal_cv_access - $com->availed_normal_cv_access;



        $verified_cv_balance = $com->verified_cv_access - $com->availed_verified_cv_access;



        $cvsSearch = Auth::guard('company')->user();

        // dd($cvsSearch);


        $unlocked = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->where('unlocked_users_ids', $id)->exists();
        $unlock = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->where('unlocked_users_ids', $id)->first();
        //  if($unlock){
        //         $end_date = new DateTime($unlock->created_at);
        //         $end_date->add(new DateInterval('P1M'));
        //     }else{
        //         $end_date = null;
        //     }


        $collections = Collection::where('user_id', Auth::guard('company')->user()->id)->get();


        if (($end_date > $now && ($balance > 0)) || $com->free_cv_access < 3 || !empty($unlock)) {




            if (empty($unlock)) {



                $unlock = new Unlocked_users();

                $unlock->company_id = Auth::guard('company')->user()->id;

                $unlock->unlocked_users_ids = $id;

                $unlock->save();

                $com->availed_verified_cv_access += 1;

                $com->availed_cvs_quota += 1;

                $com->free_cv_access += 1;

                $com->save();
                
                $unlocked=true;


            } else {
                // dd($unlock);
            }


            $user = User::findOrFail($id);

            // $user_view=new User();

            // $user->no_of_views = 1;

            // $user->




            $no_profile_views = $user->no_profile_views + 1;

            $user->no_profile_views = $no_profile_views;

            $user->update();


            $profileCv = $user->getDefaultCv();



            return view('user.applicant_profile')

                ->with('unlocked', $unlocked)
                ->with('user', $user)

                ->with('profileCv', $profileCv)

                ->with('page_title', $user->getName())

                ->with('form_title', 'Contact ' . $user->getName())

                ->with('collections', $collections);



        } else {

            if ($com->free_cv_access > 3) {
                return redirect()->back()->with('warning', 'Upgrade Your Plan!');
            } elseif ($end_date) {
                return redirect()->back()->with('warning', 'Your Package Expired!');
            } else {

                return redirect()->back()->with('warning', 'Upgrade Your Plan!');

            }


        }



    }

    public function clickProfile(Request $request, $id)
    {





        $c_id = Auth::guard('company')->user()->id;

        //  dd($c_id);

        $com = Company::where('id', $c_id)->first();

        $now = Carbon::now();

        $end_date = $com->package_end_date;


        $user_id = User::where('id', $id)->first();



        // dd($user_id->verified);



        $balance = $com->cvs_quota - $com->availed_cvs_quota;



        $email_balance = $com->email_quota - $com->availed_email_quota;



        $normal_cv_balance = $com->normal_cv_access - $com->availed_normal_cv_access;



        $verified_cv_balance = $com->verified_cv_access - $com->availed_verified_cv_access;



        $cvsSearch = Auth::guard('company')->user();

        // dd($cvsSearch);


        $unlocked = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->where('unlocked_users_ids', $id)->exists();
        $unlock = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->where('unlocked_users_ids', $id)->first();
        //  if($unlock){
        //         $end_date = new DateTime($unlock->created_at);
        //         $end_date->add(new DateInterval('P1M'));
        //     }else{
        //         $end_date = null;
        //     }


        $collections = Collection::where('user_id', Auth::guard('company')->user()->id)->get();


        
        if (($end_date > $now && ($balance > 0)) || $com->free_cv_access < 3 || !empty($unlock)) {




            if (empty($unlock)) {



                $unlock = new Unlocked_users();

                $unlock->company_id = Auth::guard('company')->user()->id;

                $unlock->unlocked_users_ids = $id;

                $unlock->save();

                $com->availed_verified_cv_access += 1;

                $com->availed_cvs_quota += 1;

                $com->free_cv_access += 1;

                $com->save();
                
                $unlocked=true;


            } else {
                // dd($unlock);
            }


            $user = User::findOrFail($id);

            // $user_view=new User();

            // $user->no_of_views = 1;

            // $user->




            $no_profile_views = $user->no_profile_views + 1;

            $user->no_profile_views = $no_profile_views;

            $user->update();


            $profileCv = $user->getDefaultCv();



            return response()->json(['status'=>true,'msg'=>'']);



        } else {

            if ($com->free_cv_access > 3) {
                return response()->json(['status'=>false,'msg'=>'Upgrade Your Plan!']);
            } elseif ($end_date) {
                return response()->json(['status'=>false,'msg'=>'Your Package Expired!']);
            } else {

                return response()->json(['status'=>false,'msg'=>'Upgrade Your Plan!']);

            }


        }



    }

    public function viewPublicProfile2(Request $request, $id)
    {

        //  return dd($request);


        $user = User::findOrFail($id);


        $c_id = Auth::guard('company')->user()->id;

        //  dd($c_id);

        $com = Company::where('id', $c_id)->first();

        $now = Carbon::now();

        $end_date = $com->package_end_date;


        $user_id = User::where('id', $id)->first();



        // dd($user_id->verified);



        $balance = $com->cvs_quota - $com->availed_cvs_quota;



        $email_balance = $com->email_quota - $com->availed_email_quota;



        $normal_cv_balance = $com->normal_cv_access - $com->availed_normal_cv_access;



        $verified_cv_balance = $com->verified_cv_access - $com->availed_verified_cv_access;



        $cvsSearch = Auth::guard('company')->user();

        // dd($cvsSearch);

        $unlocked = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->where('unlocked_users_ids', $id)->exists();

        $unlock = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->where('unlocked_users_ids', $id)->first();





        $collections = Collection::where('user_id', Auth::guard('company')->user()->id)->get();

        //dd($unlocked);

        $profileCv = $user->getDefaultCv();



        return view('user.applicant_profile')

            ->with('unlocked', $unlocked)

            ->with('user', $user)

            ->with('profileCv', $profileCv)

            ->with('page_title', $user->getName())

            ->with('form_title', 'Contact ' . $user->getName())

            ->with('collections', $collections);






    }



    public function index()
    {

        return view('company_home');

    }

    public function company_listing()
    {

        $data['companies'] = Company::paginate(20);

        return view('company.listing')->with($data);

    }

    public function collections()
    {

        // return dd( Auth::guard('company')->user()->id);

        $collections = Collection::where('user_id', Auth::guard('company')->user()->id)->get();

        // return dd($collections);

        $collection_list = CollectionList::all();

        // return dd($collections);

        // return view('collectionsbulkmail',compact('collections'));

        // return dd($collections);

        return view('company.folders.addfolder.addfolder', compact('collections', 'collection_list'));

        // ->with('collections', $collections);

        // return dd($collections)

        // ->with('collections', $collections);

        // return view('collections');

    }

    public function addcollections()
    {



        return view('addcollections');





    }

    public function editcollection(Request $request, $id)
    {

        $collection = Collection::where('user_id', Auth::guard('company')->user()->id)->where('id', $id)->first();

        // return dd($collection);

        if ($collection) {

            return view('company.folders.addfolder.editcollection', compact('collection'));

        } else {

            abort(403);

        }







    }

    public function storecollection(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->passes()) {
            $collection = new Collection();
            $collection->user_id = Auth::guard('company')->user()->id;
            $collection->name = $request->name;
            $collection->description = $request->description;
            $collection->save();

            return response()->json(array('success' => true, 'status' => 200), 200);

            // return back()->with('message','Collection created successfully');
        }
        return response()->json(['errors' => $validator->errors()->all()]);


    }

    public function updatecollection(Request $request)
    {

        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        // return dd($request->all());

        if ($validator->passes()) {

            $collection = Collection::where('user_id', Auth::guard('company')->user()->id)->where('id', $request->id)->first();

            // dd($collection);

            $collection->user_id = Auth::guard('company')->user()->id;

            $collection->name = $request->name;

            $collection->description = $request->description;

            $collection->save();

            return response()->json(array('success' => true, 'status' => 200), 200);

        }
        return response()->json(['errors' => $validator->errors()->all()]);

    }

    public function gotodeletemodal(Request $request, $id)
    {

        $collection = Collection::where('user_id', Auth::guard('company')->user()->id)->where('id', $id)->first();

        if ($collection) {

            return view('company.folders.addfolder.deletecollection', compact('collection'));

        }

        // $collection->delete();

        // return back();

    }

    public function deletecollection(Request $request, $delete_id)
    {

        ///dd('hello');



        $collection = Collection::where('user_id', Auth::guard('company')->user()->id)->where('id', $delete_id)->first();

        if ($collection) {

            $collection->delete();



            //return view('company.folders.addfolder.deletecollection',compact('collection'));

        }

        return back()->with('message', 'Folder Deleted Successfully');

        // $collection->delete();

        // return back();

    }

    public function collectionsbulkmail($id)
    {

        session()->forget('search');
        // return dd( Auth::guard('company')->user()->id);

        $folder_id = $id;

        $collections = CollectionList::where('collection_id', $id)->get();

        $fusers = User::join('collection_lists', 'users.id', '=', 'collection_lists.user_id')
            ->where('collection_lists.collection_id', $id)
            ->select('users.*')
            ->paginate(10);


        return view('collectionsbulkmail', compact('fusers', 'folder_id', 'collections'));


        // return dd($collections);

        // ->with('collections', $collections);

        // return view('collections');

    }









    public function companyProfile()
    {

        $countries = DataArrayHelper::defaultCountriesArray();

        $industries = DataArrayHelper::defaultIndustriesArray();

        $ownershipTypes = DataArrayHelper::defaultOwnershipTypesArray();

        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        return view('company.edit_profile')

            ->with('company', $company)

            ->with('countries', $countries)

            ->with('industries', $industries)

            ->with('ownershipTypes', $ownershipTypes);

    }

    public function sendbulkemail(Request $request)
    {

        //  return dd($request->all());
        // $emails = $request->users;
        $company1 = Company::findOrFail(Auth::guard('company')->user()->id);

        $email_balance = $company1->email_quota - $company1->availed_email_quota;

        $now = Carbon::now();

        $end_date = $company1->package_end_date;
        // dd($email_balance);
        if ($email_balance > 0 && $end_date > $now) {

            $emails = $request->user_id;
            $email = (explode(",", $emails));
            $selected_emails = count($email);
            if($email_balance >= $selected_emails) 
            {



                if ($request->name != null) {
                    $validator = Validator::make($request->all(), [
                        'user_id' => 'required',

                        'name' => 'unique:templates,templatename,required_without:template|max:255',
                        'template' => 'required_without:name',
                        'subject' => 'required',
                        'description' => 'required',
                    ], [
                        'user_id.required' => '
                        Note: Choose at least one candidate to send email.',

                        'name.required' => 'Template name is required',

                        'subject.required' => 'Subject is required',

                        'description.required' => 'Description is required'
                    ]);


                } else {

                    $validator = Validator::make($request->all(), [
                        'user_id' => 'required',
                        'name' => 'unique:templates,templatename,required_without:template|max:255',
                        'template' => 'required_without:name',
                        'subject' => 'required',
                        'description' => 'required',
                    ], [
                        'user_id.required' => '
                        Note: Choose at least one candidate to send email.',

                        'name.required' => 'Template name is required',

                        'name.required_without' => 'Template name is required',

                        'subject.required' => 'Subject is required',

                        'description.required' => 'Description is required'
                    ]);

                }

                if ($validator->passes()) {

                    if ($request->name) {
                        $template = new Template();
                        $template->templatename = $request->name;
                        $template->subject = $request->subject;
                        $template->message = $request->description;
                        $template->company_id = Auth::guard('company')->user()->id;
                        $template->save();
                    }





                    $company = Company::findOrFail(Auth::guard('company')->user()->id);
                    // return dd($company);
                    $name = $company->name;
                    $companymail = $company->email;

                    $emails = $request->user_id;
                    $email = (explode(",", $emails));

                    if (isset($email)) {

                        $users = User::whereIn('id', $email)->get();
                        // return dd($users);

                        // foreach ($users as $user_mail) {
                        $data = array(
                            'heading' => $request->subject,
                            'message1' => $request->description,
                            'companyname' => $name,
                            'companymail' => $companymail,
                            'email' => $users
                        );
                        // return dd($data);
                        // send all mail in the queue.
                        foreach ($users as $user) {
                            Mail::send('emails.template1', $data, function ($message) use ($data, $user, $companymail, $name) {
                                $message->from($companymail, $name);
                                $message->to($user->email);
                                $message->bcc($companymail);
                                $message->subject($data["heading"]);
                            });
                        }


                        $collection_list = CollectionList::whereIn('user_id', $email)->get();
                        // return dd($collection_list);
                        foreach ($collection_list as $list) {
                            $list->emailed = 1;
                            $list->save();
                        }

                        $company->availed_email_quota = $company->availed_email_quota + count($email);
                        $company->save();

                        return response()->json(array('success' => true, 'status' => 200), 200);
                    }
                }
                return response()->json(['errors' => $validator->errors()]);
            }else{
                
                return response()->json(['errors1' => 'Available Quota is '.$email_balance.' and you selected email is '.$selected_emails]);
            }
            // }else{

            //     // return redirect('candidate-filter1-search')->with('plan_exp_msg',0);

            //     return response()->json(['errors2'=>'Your Account is Freezed']);
            // }

        } else {

            //  return Response::json(array('name' => 'Pakainfo', 'state' => 'GJ'));

            return response()->json(['errors1' => 'Upgrage Your Plan']);
            //  return response()->json(array('error1' => true, 'status' => 422), 422);


        }


    }



    // Search functionality



    public function candidateListing()
    {
        session()->forget('search');
        session()->forget('location1');
        $users = \App\User::where('hide_show', 0)->orderBy('created_at', 'desc')->paginate(10);
        return view("company.candidate_listing", compact('users'));

    }





    public function updateCompanyProfile(CompanyFrontFormRequest $request)
    {





        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        /*         * **************************************** */

        if ($request->hasFile('logo')) {

            $is_deleted = $this->deleteCompanyLogo($company->id);

            $image = $request->file('logo');

            $fileName = ImgUploader::UploadImage('company_logos', $image, $request->input('name'), 300, 300, false);

            $company->logo = $fileName;

        }

        /*         * ************************************** */

        $company->name = $request->input('name');

        $company->email = $request->input('email');

        if (!empty($request->input('password'))) {

            $company->password = Hash::make($request->input('password'));

        }

        $company->ceo = $request->input('ceo');

        $company->industry_id = $request->input('industry_id');

        $company->ownership_type_id = $request->input('ownership_type_id');

        $company->description = $request->input('description');

        $company->location = $request->input('location');

        $company->map = $request->input('map');

        $company->no_of_offices = $request->input('no_of_offices');

        $website = $request->input('website');

        $company->website = (false === strpos($website, 'http')) ? 'http://' . $website : $website;

        $company->no_of_employees = $request->input('no_of_employees');

        $company->established_in = $request->input('established_in');

        $company->fax = $request->input('fax');

        $company->phone = $request->input('phone');

        $company->facebook = $request->input('facebook');

        $company->twitter = $request->input('twitter');

        $company->linkedin = $request->input('linkedin');

        $company->google_plus = $request->input('google_plus');

        $company->pinterest = $request->input('pinterest');

        $company->country_id = $request->input('country_id');

        $company->state_id = $request->input('state_id');

        $company->city_id = $request->input('city_id');

        $company->is_subscribed = $request->input('is_subscribed', 0);



        $company->slug = Str::slug($company->name, '-') . '-' . $company->id;

        $company->update();

        /*************************/

        Subscription::where('email', 'like', $company->email)->delete();

        if ((bool) $company->is_subscribed) {

            $subscription = new Subscription();

            $subscription->email = $company->email;

            $subscription->name = $company->name;

            $subscription->save();

            /*************************/

            Newsletter::subscribeOrUpdate($subscription->email, ['FNAME' => $subscription->name]);

            /*************************/

        } else {

            /*************************/

            Newsletter::unsubscribe($company->email);

            /*************************/

        }





        flash(__('Company has been updated'))->success();

        return \Redirect::route('company.profile');

    }



    public function addToFavouriteApplicant(Request $request, $application_id, $user_id, $job_id, $company_id)
    {

        $data['user_id'] = $user_id;

        $data['job_id'] = $job_id;

        $data['company_id'] = $company_id;



        $data_save = FavouriteApplicant::create($data);

        flash(__('Job seeker has been added in favorites list'))->success();

        return \Redirect::route('applicant.profile', $application_id);

    }



    public function removeFromFavouriteApplicant(Request $request, $application_id, $user_id, $job_id, $company_id)
    {

        $data['user_id'] = $user_id;

        $data['job_id'] = $job_id;

        $data['company_id'] = $company_id;

        FavouriteApplicant::where('user_id', $user_id)

            ->where('job_id', '=', $job_id)

            ->where('company_id', '=', $company_id)

            ->delete();



        flash(__('Job seeker has been removed from favorites list'))->success();

        return \Redirect::route('applicant.profile', $application_id);

    }



    public function companyDetail(Request $request, $company_slug)
    {

        $company = Company::where('slug', 'like', $company_slug)->firstOrFail();

        /*         * ************************************************** */

        $seo = $this->getCompanySEO($company);

        /*         * ************************************************** */

        return view('company.detail')

            ->with('company', $company)

            ->with('seo', $seo);

    }



    public function sendContactForm(Request $request)
    {

        $msgresponse = array();

        $rules = array(

            'from_name' => 'required|max:100|between:4,70',

            'from_email' => 'required|email|max:100',

            'subject' => 'required|max:200',

            'message' => 'required',

            'to_id' => 'required',

            'g-recaptcha-response' => 'required|captcha',

        );

        $rules_messages = array(

            'from_name.required' => __('Name is required'),

            'from_email.required' => __('E-mail address is required'),

            'from_email.email' => __('Valid e-mail address is required'),

            'subject.required' => __('Subject is required'),

            'message.required' => __('Message is required'),

            'to_id.required' => __('Recieving Company details missing'),

            'g-recaptcha-response.required' => __('Please verify that you are not a robot'),

            'g-recaptcha-response.captcha' => __('Captcha error! try again'),

        );

        $validation = Validator::make($request->all(), $rules, $rules_messages);

        if ($validation->fails()) {

            $msgresponse = $validation->messages()->toJson();

            echo $msgresponse;

            exit;

        } else {

            $receiver_company = Company::findOrFail($request->input('to_id'));

            $data['company_id'] = $request->input('company_id');

            $data['company_name'] = $request->input('company_name');

            $data['from_id'] = $request->input('from_id');

            $data['to_id'] = $request->input('to_id');

            $data['from_name'] = $request->input('from_name');

            $data['from_email'] = $request->input('from_email');

            $data['from_phone'] = $request->input('from_phone');

            $data['subject'] = $request->input('subject');

            $data['message_txt'] = $request->input('message');

            $data['to_email'] = $receiver_company->email;

            $data['to_name'] = $receiver_company->name;

            $msg_save = CompanyMessage::create($data);

            $when = Carbon::now()->addMinutes(5);

            Mail::send(new CompanyContactMail($data));

            $msgresponse = ['success' => 'success', 'message' => __('Message sent successfully')];

            echo json_encode($msgresponse);

            exit;

        }

    }



    public function sendApplicantContactForm(Request $request)
    {

        $msgresponse = array();

        $rules = array(

            'from_name' => 'required|max:100|between:4,70',

            'from_email' => 'required|email|max:100',

            'subject' => 'required|max:200',

            'message' => 'required',

            'to_id' => 'required',

        );

        $rules_messages = array(

            'from_name.required' => __('Name is required'),

            'from_email.required' => __('E-mail address is required'),

            'from_email.email' => __('Valid e-mail address is required'),

            'subject.required' => __('Subject is required'),

            'message.required' => __('Message is required'),

            'to_id.required' => __('Recieving applicant details missing'),

            'g-recaptcha-response.required' => __('Please verify that you are not a robot'),

            'g-recaptcha-response.captcha' => __('Captcha error! try again'),

        );

        $validation = Validator::make($request->all(), $rules, $rules_messages);

        if ($validation->fails()) {

            $msgresponse = $validation->messages()->toJson();

            echo $msgresponse;

            exit;

        } else {

            $receiver_user = User::findOrFail($request->input('to_id'));

            $data['user_id'] = $request->input('user_id');

            $data['user_name'] = $request->input('user_name');

            $data['from_id'] = $request->input('from_id');

            $data['to_id'] = $request->input('to_id');

            $data['from_name'] = $request->input('from_name');

            $data['from_email'] = $request->input('from_email');

            $data['from_phone'] = $request->input('from_phone');

            $data['subject'] = $request->input('subject');

            $data['message_txt'] = $request->input('message');

            $data['to_email'] = $receiver_user->email;

            $data['to_name'] = $receiver_user->getName();

            $msg_save = ApplicantMessage::create($data);

            $when = Carbon::now()->addMinutes(5);

            Mail::send(new ApplicantContactMail($data));

            $msgresponse = ['success' => 'success', 'message' => __('Message sent successfully')];

            echo json_encode($msgresponse);

            exit;

        }

    }



    public function postedJobs(Request $request)
    {

        $jobs = Auth::guard('company')->user()->jobs()->paginate(10);

        return view('job.company_posted_jobs')

            ->with('jobs', $jobs);

    }



    public function listAppliedUsers(Request $request, $job_id)
    {

        $job_applications = JobApply::where('job_id', '=', $job_id)->get();



        return view('job.job_applications')

            ->with('job_applications', $job_applications);

    }



    public function listFavouriteAppliedUsers(Request $request, $job_id)
    {

        $company_id = Auth::guard('company')->user()->id;

        $user_ids = FavouriteApplicant::where('job_id', '=', $job_id)->where('company_id', '=', $company_id)->pluck('user_id')->toArray();

        $job_applications = JobApply::where('job_id', '=', $job_id)->whereIn('user_id', $user_ids)->get();



        return view('job.job_applications')

            ->with('job_applications', $job_applications);

    }



    public function applicantProfile($application_id)
    {



        $job_application = JobApply::findOrFail($application_id);

        $user = $job_application->getUser();

        $job = $job_application->getJob();

        $company = $job->getCompany();

        $profileCv = $job_application->getProfileCv();



        /*         * ********************************************** */

        $num_profile_views = $user->num_profile_views + 1;

        $user->num_profile_views = $num_profile_views;

        $user->update();

        /*         * ********************************************** */

        return view('user.applicant_profile')

            ->with('job_application', $job_application)

            ->with('user', $user)

            ->with('job', $job)

            ->with('company', $company)

            ->with('profileCv', $profileCv)

            ->with('page_title', 'Applicant Profile')

            ->with('form_title', 'Contact Applicant');

    }



    public function userProfile($id)
    {



        $user = User::findOrFail($id);

        $profileCv = $user->getDefaultCv();



        /*         * ********************************************** */

        $num_profile_views = $user->num_profile_views + 1;

        $user->num_profile_views = $num_profile_views;

        $user->update();

        /*         * ********************************************** */

        $collections = Collection::where('user_id', Auth::guard('company')->user()->id)->get();

        return view('user.applicant_profile')

            ->with('user', $user)

            ->with('profileCv', $profileCv)

            ->with('page_title', 'Job Seeker Profile')

            ->with('form_title', 'Contact Job Seeker')->with('collections', $collections);

    }

    public function companyFollowers()
    {

        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        $userIdsArray = $company->getFollowerIdsArray();

        $users = User::whereIn('id', $userIdsArray)->get();



        return view('company.follower_users')

            ->with('users', $users)

            ->with('company', $company);

    }

    public function addtocollection(Request $request)
    {

        $check = CollectionList::where('collection_id', $request->collection_id)->where('user_id', Auth::guard('company')->user()->id)->where('resume_id', $request->resume_id)->first();

        if (empty($check)) {

            $collection = new CollectionList();

            $collection->user_id = Auth::guard('company')->user()->id;

            $collection->resume_id = $request->resume_id;

            $collection->collection_id = $request->collection_id;

            $collection->save();

            flash(__('Add to Collection'))->success();

            return back();

        } else {

            flash(__('Already in Collection'))->success();

            return back();

        }

    }



    public function companyMessages()
    {

        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        $messages = CompanyMessage::where('company_id', '=', $company->id)

            ->orderBy('is_read', 'asc')

            ->orderBy('created_at', 'desc')

            ->get();



        return view('company.company_messages')

            ->with('company', $company)

            ->with('messages', $messages);

    }



    public function companyMessageDetail($message_id)
    {

        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        $message = CompanyMessage::findOrFail($message_id);

        $message->update(['is_read' => 1]);



        return view('company.company_message_detail')

            ->with('company', $company)

            ->with('message', $message);

    }





    public function resume_search_packages()
    {

        //dd('yrdy');

        $data['packages'] = Package::where('package_for', 'cv_search')->get();



        //dd(Auth::guard('company')->user()->cvs_package_id);

        if (Auth::guard('company')->user()->cvs_package_id > 0) {

            $data['success_package'] = Package::findorfail(Auth::guard('company')->user()->cvs_package_id);

        } else {

            $data['success_package'] = '';

        }

        //return dd( $data['success_package']);

        //dd($data['success_package']);

        return view('company_resume_search_packages')->with($data);

    }

    public function unlocked_users()
    {

        $data = array();


        $unlocked_users = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->get();

        foreach ($unlocked_users as $unlock) {

            $data[] = $unlock->unlocked_users_ids;


        }

        $filter_users = User::where('hide_show', 0)->whereIn('id', $data)->paginate(10);


        session()->forget('search');
        return view('company.unlocked_users', compact('filter_users'));
    }



    public function unlock($user_id)
    {

        $cvsSearch = Auth::guard('company')->user();

        if (null !== ($cvsSearch)) {

            if ($cvsSearch->availed_cvs_ids != '') {



                $newString = $this->addtoString($cvsSearch->availed_cvs_ids, $user_id);

            } else {

                $newString = $user_id;

            }



            $cvsSearch->availed_cvs_ids = $newString;

            $cvsSearch->availed_cvs_quota += 1;

            $cvsSearch->update();



            $unlock = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->first();

            if (null !== ($unlock)) {

                $unlock->unlocked_users_ids = $newString;

                $unlock->update();

            } else {

                $unlock = new Unlocked_users();



                $unlock->company_id = Auth::guard('company')->user()->id;

                $unlock->unlocked_users_ids = $newString;

                $unlock->save();

            }

            return redirect()->back();

        } else {

            return redirect('/company-packages');

        }

    }

    function addtoString($str, $item)
    {

        $parts = explode(',', $str);

        $parts[] = $item;



        return implode(',', $parts);

    }





    public function resumes(Request $request, $id)
    {


        $no_of_downloads = 0;

        $user = User::where('id', $id)->first();

        $exp = ProfileSummary::where('user_id', $user->id)->first();

        $user->no_of_downloads = $no_of_downloads + 1;

        $user->save();

        $company = Company::where('id', Auth::guard('company')->user()->id)->first();
        $company->no_of_downloads = $company->no_of_downloads + 1;
        // $company->save();

        // dd('test');

        //return $user->resume;


        $myFile = public_path('cvs/' . $user->resume);
        $headers = ['Content-Type: application/pdf'];
        $newName = 'ZNP_' . $user->first_name . '-' . $user->last_name . '.pdf';


        return response()->download($myFile, $newName, $headers);

        //return response()->file($myFile);


        // return response()->download(public_path('cvs/' . $user->resume, 'user'));

        // 'cvs', $cv_file, $request->input('title')



    }
    public function invoice(Request $request, $id)
    {



        $payment = EmployerPayment::where('payment_id', $id)->first();

        // dd($payment);
        //return $payment->resume;

        return response()->download(public_path('invoices/' . $payment->invoice));

        // 'cvs', $cv_file, $request->input('title')



    }



    public function candidatelistsearch(Request $request)
    {

        $sea = $request->search;





        //dd($sea);



        // $users = User::whereHas('profileNop', function($q){

        //     $q->where('buyable_nop', $sea);

        // })->get();



        //  $test = ProfileCityJobsCity::where ('current_desigination', 'LIKE', '%' . $sea . '%' )->get ();

        //

        //    $users = User::whereHas('ProfileCityJobsCity', function($q) use ($sea){

        //        $q->where('current_company', $sea)->get();

        //    });



        //    $categories = User::whereHas('ProfileCityJobsCity', function($query) use ($sea)

        //    {

        //      //  $query->whereIn('current_company', $sea);

        //        $query->where('current_desigination',$sea);

        //    })

        //        ->get();

        // $showcampaign = User::query()

        //     ->whereHas('ProfileCityJobsCity',function(\Illuminate\Database\Eloquent\Builder $query) use ($sea){

        //         return $query->where('current_designation', 'LIKE','%'.$sea.'%');



        //     })



        //     ->get();

        $users = User::whereHas('ProfileCityJobsCity', function ($q) {

            $q->where('buyable_nop', 2);

        })->get();

        // $users = User::whereHas('profileNop', function($q){

        //     $q->where('buyable_nop', 3);

        // })

        // // ->whereHas('profileSkills',function($h){

        // //     $h->whereIn('job_skill_id', [3,16]);

        // // })

        // ->where('current_location','kasturi')->get();



        dd($users);

    }





    public function employerdashboard()
    {

        $company = Company::findOrFail(Auth::guard('company')->user()->id);




        if ($company->cvs_quota != null) {
            $balance = $company->cvs_quota - $company->availed_cvs_quota;

        } else {
            $va = 0;
            $balance = $va - $company->availed_cvs_quota;

        }
        $email_balance = 0;
        if ($company->email_quota) {
            $email_balance = $company->email_quota ? $company->email_quota - $company->availed_email_quota:0;
        }


        //        dd($balance);



        return view('company.company_dashboard', compact('company', 'balance', 'email_balance'));

    }



    public function emailsend(Request $request)
    {

        // dd($request->all());

        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        $companyemail = $company->email;

        $companyname = $company->name;

        $email_balance = $company->email_quota - $company->availed_email_quota;
        
        $now = Carbon::now();

        $package_end_date = $company->package_end_date;

        $unlock = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->where('unlocked_users_ids', $request->id)->first();
        $now = Carbon::now();
        if ($unlock) {
            $end_date = new DateTime($unlock->created_at);
            $end_date->add(new DateInterval('P1M'));
        } else {
            $end_date = null;
        }

        if (($email_balance > 0 &&  $package_end_date > $now) || ($end_date > $now && @$unlock->remaining_emails)) {

            $user = User::where('id', $request->id)->first();


            if ($request->name != null) {

                $validator = Validator::make($request->all(), [

                    'name' => 'unique:templates,templatename,required_without:template|max:255',
                    'template' => 'required_without:name',
                    'subject' => 'required',
                    'message' => 'required',
                ], [

                    'name.required' => 'Template name is required',

                    'subject.required' => 'Subject is required',

                    'template.required_without' => 'Template name is required',

                    'message.required' => 'Message is required'
                ]);




            } else {



                $validator = Validator::make($request->all(), [

                    'name' => 'unique:templates,templatename,required_without:template|max:255',
                    'template' => 'required_without:name',
                    'subject' => 'required',
                    'message' => 'required',
                ], [

                    'name.required' => 'Template name is required',

                    'template.required_without' => 'Template name is required',

                    'subject.required' => 'Subject is required',

                    'message.required' => 'Message is required'
                ]);

            }



            if ($validator->passes()) {


                if ($request->name) {
                    $template = new Template();
                    $template->templatename = $request->name;
                    $template->subject = $request->subject;
                    $template->message = $request->message;
                    $template->company_id = Auth::guard('company')->user()->id;
                    $template->save();
                }


                $data = [
                    'title' => $user->email,
                    'subject' => $request->subject,
                    'messages' => $request->message,

                ];


                Mail::send('emails.send_message', $data, function ($message) use ($data, $companyemail, $companyname) {
                    $message->from($companyemail, $companyname);
                    $message->to($data['title'])
                        ->bcc($companyemail)
                        ->subject($data['subject']);
                });
                
                if ($unlock) {
                    $unlock->remaining_emails = $unlock->remaining_emails - 1;
                    $unlock->save();
                }

                $user->no_of_emails = $user->no_of_emails + 1;
                $user->save();
                // dd($request->id);
                $collection_list = CollectionList::where('user_id', $request->id)->where('company_id', $company->id)->first();
                //dd($collection_list);
                if ($collection_list) {
                    $collection_list->emailed = 1;
                    $collection_list->save();
                }


                $company->availed_email_quota = $company->availed_email_quota + 1;
                $company->save();

                return response()->json(array('success' => true, 'status' => 200), 200);

            }
            return response()->json(['errors' => $validator->errors()]);

        } else {

            return response()->json(['errors1' => 'Your Email Sending Limit is Exceed']);

            //    return redirect()->back()->with('warning', 'Your Email Access Limit is Exceed');

        }



    }



    public function homesearch(Request $request)
    {



        $company_id = Auth::guard("company")->user()->id;

        $company = Company::where('id', $company_id)->first();

        $now = Carbon::now();

        if ($company->package_end_date > $now) {

            $company->search = $company->search + 1;
            $company->save();



            if (!is_null($request->location[0])) {
                $location1 = $request->location;
                //  dd('not null');
            } else {
                $location1 = NULL;
                //    dd('null');
            }


            $notice_period = $request->notice_period;
            $keyskill = $request->skill;

            // dd($keyskill);


            if (!is_null($request->location[0])) {
                //  dd($request->location);

                $query = User::latest();


                $query->where(function ($q) use ($keyskill) {

                    $q->whereHas('profilekeyskill', function ($q) use ($keyskill) {

                        if (in_array(null, $keyskill, true) || in_array('', $keyskill, true)) {

                        } else {
                            $t = [];
                            foreach ($keyskill as $skill) {
                                $t = explode(",", $skill);
                            }
                            dd($t);

                            foreach ($t as $skill) {
                                $job_skill = JobSkill::where('job_skill', 'like', "%{$skill}%")->first();

                                if ($job_skill) {
                                    $q->where('keyskill', $job_skill->id);
                                }

                            }
                        }

                    });
                });

                if ($notice_period) {

                    $query->whereHas('profileNop', function ($q) use ($notice_period, $location) {

                        if ($notice_period) {
                            $q->whereIn('nop_days', $notice_period);
                        }


                    });
                }


                if ($location1) {
                    $locations = [];
                    foreach ($location1 as $location) {
                        $split = explode(',', $location);
                        $trimmed = array_map('trim', $split);
                        $locations = array_merge($locations, $trimmed);
                    }
                    if (!in_array('Any', $locations)) {
                        $query->whereIn('current_city', $locations);
                    }
                }

                $users = $query->take(5)->get();


            } else {

                //dd('location not coming');


                $users = User::whereHas('profilekeyskill', function ($q) use ($keyskill) {

                    // if($keyskill)
                    // {
                    //     $q->whereIn('keyskill', $keyskill);
                    // }
                    if (in_array(null, $keyskill, true) || in_array('', $keyskill, true)) {

                    } else {
                        //   dd('skill is coming');

                        $t = [];
                        foreach ($keyskill as $skill) {
                            $t = explode(",", $skill);
                        }
                        // dd($t);

                        $jobSkills = JobSkill::whereIn('job_skill', $t)->get()->pluck('id');
                        if ($jobSkills->count() > 0) {
                            $q->whereIn('keyskill', $jobSkills);
                        }



                    }

                })->whereHas('profileNop', function ($q) use ($notice_period) {

                    if ($notice_period) {
                        $q->whereIn('nop_days', $notice_period);
                    }


                })->take(5)->get();
            }


            $view = view('welcome-search', compact('users'))->render();
            return response()->json(['users' => $view]);



        } else {

            return response()->json(array('error' => true, 'status' => 400), 400);
        }



    }


    // Candidate First search


    public function search(Request $request)
    {
        // dd($request);

        $search = $request->search;

        $search_users = User::whereHas('profileSummary', function ($q) use ($search) {
            $q->where('latestdesg', $search);
        })->get();


        return view("company.candidate_listing", compact('search_users', 'search'));

    }
    public function candidatesearch(Request $request)
    {
        $company_id = Auth::guard("company")->user()->id;
        $company = Company::findOrFail($company_id);

        // Increment search count using atomic operation
        $company->increment('search');

        // Input search and location
        $search_skill = $request->input('search', Session::get('search', ''));
        $location_input = $request->input('location', Session::get('store_locations', ''));

        // Normalize search keywords
        $keywords = array_values(array_filter(array_map(function ($value) {
            return strtolower(trim($value));
        }, explode(',', $search_skill)), 'strlen'));

        // Normalize locations
        $normalized_locations = [];
        $store_locations=[];
        if ($location_input) {
            
            // $normalized_locations = array_values(array_filter(array_map(function ($value) {
            //     return strtolower(trim($value));
            // }, explode(',', $location_input)), 'strlen'));
            // $normalized_locations = $this->normalizeLocations($normalized_locations);
            
            $normalized_locations = array_map('strtolower', array_map('trim', explode(',', $location_input)));
            // dd($locations);

            if (in_array('bengaluru', $normalized_locations)) {
                array_push($normalized_locations, 'bangalore');
            }
            if (in_array('bangalore', $normalized_locations)) {
                array_push($normalized_locations, 'bengaluru');
            }
            if (in_array('bangalore/bengaluru', $normalized_locations)) {
                array_push($normalized_locations, 'bengaluru', 'bangalore');
            }
            

            $locations = array_map('strtolower', array_map('trim', explode(',',$location_input)));
            $store_locations = array_unique(array_filter($locations));
        }

        // Generate subquery for matches using UNION
        $subquery = DB::table('profile_summaries')
            ->select('user_id')
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('latestdesg', 'like', "{$keyword}%");
                }
            })
            ->union(
                DB::table('key_skills')
                    ->select('user_id')
                    ->whereIn('keyskill', function ($query) use ($keywords) {
                        $query->select('id')
                            ->from('job_skills')
                            ->whereIn('job_skill', $keywords);
                    })
            );

        // Build main query with JOIN
        $query = User::query()
            ->joinSub($subquery, 'matches', function ($join) {
                $join->on('users.id', '=', 'matches.user_id');
            })
            ->where('users.hide_show', 0);

        // Apply location filters
        if ($normalized_locations) {
            $query->where(function ($q) use ($normalized_locations) {
                foreach ($normalized_locations as $location) {
                    if($location != ''){
                        $q->orWhereRaw('LOWER(current_city) LIKE ?', ["%{$location}%"]);
                    }
                }
            });
        }

        // Fetch users with pagination
        $users = $query->distinct()->paginate(10);

        // Save search and location inputs in the session
        Session::put('search', $search_skill ?: null);
        Session::put('store_locations', $location_input ?: null);
        Session::put('location1', $store_locations ?: null);

        // Prepare response
        $filter = ($search_skill || $location_input) ? 1 : 0;
        return view("company.candidate_listing", [
            'users' => $users,
            'filter' => $filter,
            'locations_vals' => $store_locations,
            'search_vals' => $search_skill,
            'store_locations' => $location_input,
            'search_skill' => $search_skill,
        ]);
    }

    
    /**
     * Normalize locations for alias handling.
     */
    private function normalizeLocations(array $locations): array
    {
        static $aliases = [
            'bengaluru' => 'bangalore',
            'bangalore' => 'bengaluru',
        ];
    
        $normalized = [];
        foreach ($locations as $location) {
            $normalized[] = $location;
            if (isset($aliases[$location])) {
                $normalized[] = $aliases[$location];
            }
        }
        return array_unique($normalized);
    }
    



    // Candidate Second search

    public function filter2search(Request $request)
    {



        if ($request->max_exp && $request->min_exp) {

            $request->validate([
                'min_exp' => 'numeric',
                'max_exp' => 'numeric|gte:min_exp',
            ], [
                'max_exp.gte' => 'Invalid Input',
                'min_exp.numeric' => 'Invalid Input',
                'max_exp.numeric' => 'Invalid Input',
            ]);

        }
        if ($request->max_salary && $request->min_salary) {

            $request->validate(
                [

                    'min_salary' => 'numeric',

                    'max_salary' => 'numeric|gte:min_salary',

                ],
                [
                    'max_salary.gte' => 'Invalid Input'
                ]
            );
        }


        // dd('validation passed');




        $company_id = Auth::guard("company")->user()->id;

        $company = Company::where('id', $company_id)->first();

        $now = Carbon::now();

        //    if($company->package_end_date > $now)
        //    {

        // if(!$company->is_freeze) 
        // {


        $company->search = $company->search + 1;
        $company->save();


        if ($request->method() == 'POST') {
            //  dd('post method');

            $min_exp = (int) ($request->min_exp ?? null);
            $max_exp = (int) ($request->max_exp ?? null);

            $min = (int) ($request->min_salary ?? null);
            $max = (int) ($request->max_salary ?? null);


            $interview = $request->interview_avail;
            $education = $request->education;
            $course = $request->course;
            $specilation = $request->specilation;
            $gender = $request->gender;
            $job_type = $request->job_type;
            $filter_resume = $request->filter_resume;
            $s_date = $request->previous_start_date;
            $e_date = $request->previous_end_date;

            // dd($interview ,
            // $education,
            // $course,
            // $specilation,
            // $gender ,
            // $job_type,
            // $filter_resume ,
            // $s_date,      $min_exp, $max_exp, $max,$min );


            if ($request->previous_start_date) {
                $startDate = date("Y-m-d", strtotime($request->previous_start_date));
            } else {
                $startDate = '';
            }
            if ($request->previous_end_date) {
                $endDate = date("Y-m-d", strtotime($request->previous_end_date));
            } else {
                $endDate = '';
            }
            if ($request->notice_period) {
                $notice_period = $request->notice_period;
            } else {
                $notice_period = NULL;
            }



            $now = \Carbon\Carbon::now();

            // dd($startDate);

            $today = \Carbon\Carbon::now()->format('Y-m-d');
            $tommorrow = \Carbon\Carbon::now()->addDay(1)->format('Y-m-d');



            $search = Session::get('search');
            $location1 = Session::get('location1');

            $search_skill = $search;





            $query = User::where('hide_show', 0)->latest();


            //filter 1 search value is there 

            if ($search) {

                //  dd('search value is there');


                // Split the search keywords into an array and trim any whitespace
                $keywords = array_values(array_filter(array_map(function ($value) {
                    return strtolower(trim($value));
                }, explode(',', $search)), 'strlen'));
                $subquery = DB::table('profile_summaries')
                    ->select('user_id')
                    ->where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->orWhere('latestdesg', 'like', "%{$keyword}%");
                        }
                    })
                    ->union(
                        DB::table('key_skills')
                            ->select('user_id')
                            ->whereIn('keyskill', function ($query) use ($keywords) {
                                $query->select('id')
                                    ->from('job_skills')
                                    ->whereIn('job_skill', $keywords);
                            })
                    );
                    $query->joinSub($subquery, 'matches', function ($join) {
                        $join->on('users.id', '=', 'matches.user_id');
                    });
            } else {
                // dd('search value is not there');
            }

            if (!is_null($location1)) {

                $store_locations = $location1;
                $locations = array_map('strtolower', array_map('trim', explode(',', implode(',', $location1))));
                $store_locations = array_unique(array_filter($location1));
                $store_locations = implode(',', $store_locations);

                if (in_array('bengaluru', $locations)) {
                    array_push($locations, 'bangalore');
                }
                if (in_array('bangalore', $locations)) {
                    array_push($locations, 'bengaluru');
                }
                if (in_array('bangalore/bengaluru', $locations)) {
                    array_push($locations, 'bengaluru', 'bangalore');
                }
                if ($locations) {
                    $query->where(function ($q) use ($locations) {
                        foreach ($locations as $location) {
                            if ($location != '') {
                                $q->orWhereRaw('LOWER(current_city) LIKE ?', ["%{$location}%"]);
                            }
                        }
                    });
                }

                Session::put('store_locations', $store_locations);

            } else {
                $store_locations = '';

                Session::forget('location1');
            }




            if ($min_exp && $max_exp) {
                // Both min_exp and max_exp are provided
                $query->whereHas('profileSummary', function ($q) use ($min_exp, $max_exp) {
                    $q->whereRaw("CAST(SUBSTRING_INDEX(totalexp, ' ', 1) AS UNSIGNED) BETWEEN ? AND ?", [$min_exp, $max_exp]);
                });
            } elseif ($min_exp) {
                // Only min_exp is provided
                $query->whereHas('profileSummary', function ($q) use ($min_exp) {
                    $q->whereRaw("CAST(SUBSTRING_INDEX(totalexp, ' ', 1) AS UNSIGNED) >= ?", [$min_exp]);
                });
            } elseif ($max_exp) {
                // Only max_exp is provided
                $query->whereHas('profileSummary', function ($q) use ($max_exp) {
                    $q->whereRaw("CAST(SUBSTRING_INDEX(totalexp, ' ', 1) AS UNSIGNED) <= ?", [$max_exp]);
                });
            }



            if ($min && $max) {
                // Both min_exp and max_exp are provided
                $query->whereHas('profileDetails', function ($q) use ($min, $max) {
                    $q->whereBetween('expect_ctc_lakhs', [$min, $max]);
                });
            } elseif ($min) {

                $query->whereHas('profileDetails', function ($q) use ($min) {
                    $q->where('expect_ctc_lakhs', '>=', (int) $min);
                });
            } elseif ($max) {
                // Only max_exp is provided
                $query->whereHas('profileDetails', function ($q) use ($max) {
                    $q->where('expect_ctc_lakhs', '<=', (int) $max);
                });
            }




            if ($notice_period) {
                if ($notice_period[0] == 2) {
                    $query->whereHas('profileNop', function ($q) use ($notice_period) {
                        $q->whereIn('nop_days', $notice_period);
                        $q->where('last_working_day', '>', now()->toDateString());
                    });
                } else {
                    $query->whereHas('profileNop', function ($q) use ($notice_period) {
                        $q->whereIn('nop_days', $notice_period);
                    });
                }
            }

            if ($education) {
                $query->whereHas('profileEducation', function ($q) use ($education) {
                    $q->where('degree_title', $education);
                });
            }

            if ($course) {
                $query->whereHas('profileEducation', function ($q) use ($course) {
                    $q->where('course', $course);
                });
            }

            if ($specilation) {
                $query->whereHas('profileEducation', function ($q) use ($specilation) {
                    $q->where('specilation', $specilation);
                });
            }

            if ($job_type) {
                $query->whereHas('profileDetails', function ($q) use ($job_type) {
                    $q->where('work_type', $job_type);
                });
            }

            if ($gender) {
                $query->where('gender_id', $gender);
            }
            if ($startDate && $endDate) {
                $query->whereHas('interViews', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('date', [$startDate, $endDate]);
                });
            } elseif ($startDate) {
                $query->whereHas('interViews', function ($q) use ($startDate) {
                    $q->where('date', '>=', $startDate);
                });
            } elseif ($endDate) {
                $query->whereHas('interViews', function ($q) use ($endDate) {
                    $q->where('date', '<=', $endDate);
                });
            }


            if ($filter_resume == '1') {
                $query->where('verified', 1);

            }
            if ($filter_resume == '2') {
                $query->where('verified', 0);
            }
            if ($filter_resume == '3') {
                $query->where('package_end_date', '>', $now);
            }


            $users = $query->paginate(10);
            // dd($users);

            Session::put('notice_period', $notice_period);

            Session::put('min1', $request->min_salary ?? null);

            Session::put('max1', $request->max_salary ?? null);

            Session::put('min_exp', $request->min_exp ?? null);

            Session::put('max_exp', $request->max_exp ?? null);

            Session::put('interview_avail', $interview);

            Session::put('education', $education);

            Session::put('course', $course);

            Session::put('specilation', $specilation);

            Session::put('gender', $gender);

            Session::put('startDate', $request->previous_start_date ?? null);

            Session::put('endDate', $request->previous_end_date ?? null);

            Session::put('job_type', $job_type);

            Session::put('filter_resume', $filter_resume);

            Session::put('s_date', $s_date);

            Session::put('e_date', $e_date);

            $filter = 2;


            if (isset($location1)) {
                $locations_vals = $location1;

            } else {
                $locations_vals = null;

            }

            if (isset($search)) {
                $search_vals = $search;

            } else {
                $search_vals = null;

            }

            // dd($search_vals);

            //dd($education);


            return view("company.candidate_listing", compact('search_skill', 'users', 'locations_vals', 'search_vals', 'min_exp', 'max', 'min', 'max_exp', 'interview', 'education', 'notice_period', 'job_type', 'gender', 'course', 'specilation', 'filter_resume', 'filter', 's_date', 'e_date', 'store_locations'));



        }

        if ($request->method() == 'GET') {
            $min_exp = Session::get('min_exp');
            $max_exp = Session::get('max_exp');
            $interview = Session::get('interview_avail');
            $education = Session::get('education');
            $course = Session::get('course');
            $specilation = Session::get('specilation');
            $gender = Session::get('gender');
            $job_type = Session::get('job_type');
            $filter_resume = Session::get('filter_resume');
            $startDate = Session::get('startDate');
            $endDate = Session::get('endDate');
            $min = Session::get('min1');
            $max = Session::get('max1');
            $notice_period = Session::get('notice_period');
            $s_date = Session::get('s_date');
            $e_date = Session::get('e_date');


            $now = \Carbon\Carbon::now();

            $today = \Carbon\Carbon::now()->format('Y-m-d');

            $tommorrow = \Carbon\Carbon::now()->addDay(1)->format('Y-m-d');


            $search = Session::get('search');
            $location1 = Session::get('location1');
            $search_skill = $search;


            $query = User::where('hide_show', 0)->latest();

            //filter 1 search value is there 

            if ($search) {

                //  dd('search value is there');


                // Split the search keywords into an array and trim any whitespace
                $keywords = array_values(array_filter(array_map(function ($value) {
                    return strtolower(trim($value));
                }, explode(',', $search)), 'strlen'));
                $subquery = DB::table('profile_summaries')
                    ->select('user_id')
                    ->where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->orWhere('latestdesg', 'like', "%{$keyword}%");
                        }
                    })
                    ->union(
                        DB::table('key_skills')
                            ->select('user_id')
                            ->whereIn('keyskill', function ($query) use ($keywords) {
                                $query->select('id')
                                    ->from('job_skills')
                                    ->whereIn('job_skill', $keywords);
                            })
                    );
                    $query->joinSub($subquery, 'matches', function ($join) {
                        $join->on('users.id', '=', 'matches.user_id');
                    });
                // $query->where(function ($q) use ($search) {
                //     $q->where(function ($query) use ($search) {
                //         foreach ($search as $keyword) {
                //             $query->orWhereHas('profileSummary', function ($q) use ($keyword) {
                //                 $q->where('latestdesg', 'like', '%' . $keyword . '%');
                //             });
                //         }
                //     });


                //     $q->orWhere(function ($query) use ($search) {
                //         $keyIds = JobSkill::whereIn('job_skill', $search)->pluck('id')->toArray();

                //         if (!empty ($keyIds)) {
                //             $query->orWhereHas('profilekeyskill', function ($q) use ($keyIds) {
                //                 $q->whereIn('keyskill', $keyIds);
                //             });
                //         }
                //     });
                // });
            } else {
                // dd('search value is not there');
            }

            if (!is_null($location1)) {

                $store_locations = $location1;

                $locations = array_map('strtolower', array_map('trim', explode(',', implode(',', $location1))));
                $store_locations = array_unique(array_filter($location1));
                $store_locations = implode(',', $store_locations);

                if (in_array('bengaluru', $locations)) {
                    array_push($locations, 'bangalore');
                }
                if (in_array('bangalore', $locations)) {
                    array_push($locations, 'bengaluru');
                }
                if (in_array('bangalore/bengaluru', $locations)) {
                    array_push($locations, 'bengaluru', 'bangalore');
                }
                // $locations = array_map('strtolower', array_map('trim', explode(',', implode(',', $location1))));
                // $store_locations = array_filter($location1);
                // $store_locations = implode(',', $store_locations);

                // if (in_array('bengaluru', $locations)) {
                //     array_push($locations, 'bangalore');
                // }
                // if (in_array('bangalore', $locations)) {
                //     array_push($locations, 'bengaluru');
                // }
                // if (in_array('bangalore/bengaluru', $locations)) {
                //     array_push($locations, 'bengaluru', 'bangalore');
                // }



                // if (!in_array('Any', $locations) && !in_array('any', $locations)) {
                    // $query->where(function ($query) use ($locations) {
                    //     foreach ($locations as $location) {
                    //         if ($location != '') {
                    //             $query->orWhereRaw("LOWER(current_city) LIKE ?", ['%' . strtolower($location) . '%']);
                    //         }

                    //     }
                    // });
                // }
                if ($locations) {
                    $query->where(function ($q) use ($locations) {
                        foreach ($locations as $location) {
                            if ($location != '') {
                                $q->orWhereRaw('LOWER(current_city) LIKE ?', ["%{$location}%"]);
                            }
                        }
                    });
                }

                Session::put('store_locations', $store_locations);

            } else {
                $store_locations = '';

                Session::forget('location1');
            }




            if ($min_exp && $max_exp) {
                // Both min_exp and max_exp are provided
                $query->whereHas('profileSummary', function ($q) use ($min_exp, $max_exp) {
                    $q->whereRaw("CAST(SUBSTRING_INDEX(totalexp, ' ', 1) AS UNSIGNED) BETWEEN ? AND ?", [$min_exp, $max_exp]);
                });
            } elseif ($min_exp) {
                // Only min_exp is provided
                $query->whereHas('profileSummary', function ($q) use ($min_exp) {
                    $q->whereRaw("CAST(SUBSTRING_INDEX(totalexp, ' ', 1) AS UNSIGNED) >= ?", [$min_exp]);
                });
            } elseif ($max_exp) {
                // Only max_exp is provided
                $query->whereHas('profileSummary', function ($q) use ($max_exp) {
                    $q->whereRaw("CAST(SUBSTRING_INDEX(totalexp, ' ', 1) AS UNSIGNED) <= ?", [$max_exp]);
                });
            }


            if ($min && $max) {
                // Both min_exp and max_exp are provided
                $query->whereHas('profileDetails', function ($q) use ($min, $max) {
                    $q->whereBetween('expect_ctc_lakhs', [$min, $max]);
                });
            } elseif ($min) {

                $query->whereHas('profileDetails', function ($q) use ($min) {
                    $q->where('expect_ctc_lakhs', '>=', (int) $min);
                });
            } elseif ($max) {
                // Only max_exp is provided
                $query->whereHas('profileDetails', function ($q) use ($max) {
                    $q->where('expect_ctc_lakhs', '<=', (int) $max);
                });
            }





            if ($notice_period) {
                if ($notice_period[0] == 2) {
                    $query->whereHas('profileNop', function ($q) use ($notice_period) {
                        $q->whereIn('nop_days', $notice_period);
                        $q->where('last_working_day', '>', now()->toDateString());
                    });
                } else {
                    $query->whereHas('profileNop', function ($q) use ($notice_period) {
                        $q->whereIn('nop_days', $notice_period);
                    });
                }
            }

            if ($education) {
                $query->whereHas('profileEducation', function ($q) use ($education) {
                    $q->where('degree_title', $education);
                });
            }

            if ($course) {
                $query->whereHas('profileEducation', function ($q) use ($course) {
                    $q->where('course', $course);
                });
            }

            if ($specilation) {
                $query->whereHas('profileEducation', function ($q) use ($specilation) {
                    $q->where('specilation', $specilation);
                });
            }

            if ($job_type) {
                $query->whereHas('profileDetails', function ($q) use ($job_type) {
                    $q->where('work_type', $job_type);
                });
            }

            if ($gender) {
                $query->where('gender_id', $gender);
            }
            if ($startDate && $endDate) {
                // Both min_exp and max_exp are provided
                $query->whereHas('interViews', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('date', [$startDate, $endDate]);
                });
            } elseif ($startDate) {

                $query->whereHas('interViews', function ($q) use ($startDate) {
                    $q->where('date', '>=', $startDate);
                });
            } elseif ($endDate) {
                // Only max_exp is provided
                $query->whereHas('interViews', function ($q) use ($endDate) {
                    $q->where('date', '<=', $endDate);
                });
            }


            if ($filter_resume == '1') {
                $query->where('verified', 1);

            }
            if ($filter_resume == '2') {
                $query->where('verified', 0);
            }
            if ($filter_resume == '3') {
                $query->where('package_end_date', '>', $now);
            }


            $users = $query->paginate(10);

            $filter = 2;


            if (isset($location1)) {
                $locations_vals = $location1;

            } else {
                $locations_vals = null;

            }

            if (isset($search)) {
                $search_vals = $search;

            } else {
                $search_vals = null;

            }



            return view("company.candidate_listing", compact('search_skill', 'users', 'locations_vals', 'search_vals', 'min_exp', 'max', 'min', 'max_exp', 'interview', 'education', 'notice_period', 'job_type', 'gender', 'course', 'specilation', 'filter_resume', 'filter', 's_date', 'e_date'));

        }


        // }else{

        //     // return redirect('candidate-filter1-search')->with('plan_exp_msg',0);

        //     return redirect()->back()->with('plan_exp_msg',2);
        // }

                // }else{

                //     return redirect()->back()->with('plan_exp_msg',0);
        // }





    }














    /************************************************  Unlocked Users       ************************************ */









    public function search1(Request $request)
    {

        //  dd('ghello');

        $search = $request->search;



        $emails = $request->user_id;





        // $ids; // array of ids

        // $placeholders = implode(',',array_fill(0, count($ids), '?')); // string for the query



        // Operation::whereIn('id', $ids)

        //    ->orderByRaw("field(id,{$placeholders})", $ids)->get();



        //$data=array();



        $unlocked_users = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->get();









        foreach ($unlocked_users as $unlock) {



            $data[] = $unlock->unlocked_users_ids;



        }



        //dd($data);



        $search_users = User::whereHas('profileSummary', function ($q) use ($search) {

            $q->where('latestdesg', $search);

            $search = $request->search;



        })->whereIn('id', $data)->get();



        //dd($search_users);

        return view("company.unlocked_users", compact('search_users'));



    }







    public function unlockedfiltersearch1(Request $request)
    {


        if ($request->method() == 'POST') {


            // dd('posrt');

            $unlocked_users = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->get();

            foreach ($unlocked_users as $unlock) {



                $data[] = $unlock->unlocked_users_ids;



            }


            if (count($unlocked_users) > 0) {

                $search = $request->search;

                $search = !is_null($request->search[0]) ? $request->search : NULL;

                if (!is_null($request->location)) {

                    $location1 = !is_null($request->location[0]) ? $request->location : NULL;

                } else {
                    $location1 = null;
                }





                $query = User::where('hide_show', 0)->whereIn('id', $data);

                if ($search) {
                    // Split the search keywords into an array and trim any whitespace
                    $search = array_map('trim', explode(',', implode(',', $search)));

                    $query->where(function ($q) use ($search) {
                        $q->where(function ($query) use ($search) {
                            foreach ($search as $keyword) {
                                $query->orWhereHas('profileSummary', function ($q) use ($keyword) {
                                    $q->where('latestdesg', 'like', '%' . $keyword . '%');
                                });
                            }
                        });

                        $q->orWhere(function ($query) use ($search) {
                            $keyIds = JobSkill::whereIn('job_skill', $search)->pluck('id')->toArray();

                            if (!empty ($keyIds)) {
                                $query->orWhereHas('profilekeyskill', function ($q) use ($keyIds) {
                                    $q->whereIn('keyskill', $keyIds);
                                });
                            }
                        });


                    });
                } else {
                    Session::forget('search');
                }

                if (!is_null($location1)) {


                    $store_locations = $location1;

                    // dd($location1);

                    $locations = array_map('strtolower', array_map('trim', explode(',', $location1)));
                    // dd($locations);

                    if (in_array('bengaluru', $locations)) {
                        array_push($locations, 'bangalore');
                    }
                    if (in_array('bangalore', $locations)) {
                        array_push($locations, 'bengaluru');
                    }
                    if (in_array('bangalore/bengaluru', $locations)) {
                        array_push($locations, 'bengaluru', 'bangalore');
                    }


                    // dd($locations);

                    if (!in_array('any', $locations) || !in_array('any', $locations)) {
                        $query->where(function ($query) use ($locations) {
                            foreach ($locations as $location) {

                                $query->orWhereRaw("LOWER(current_city) LIKE ?", [strtolower($location)]);
                            }
                        });
                    }

                    Session::put('store_locations', $store_locations);

                } else {
                    $store_locations = '';

                    Session::forget('store_locations');

                    Session::forget('location1');
                }


                $filter_users = $query->paginate(30);

                Session::put('filter_users', $filter_users);// $this->filter2search($filter1_users);



                $filter = 1;

                if (isset($locations)) {

                    // Split the string into an array, trim, and convert to lowercase
                    $locationsArray = array_map('strtolower', array_map('trim', explode(',', implode(',', $locations))));

                    // Check for specific conditions and modify the array
                    $locationsArray = array_filter($locationsArray, function ($location) {
                        return !in_array($location, ['bengaluru', 'bangalore', 'bangalore/bengaluru']);
                    });

                    // Add a new value to the array
                    $locationsArray[] = 'Bangalore/Bengaluru';

                    // Remove duplicate values
                    $locationsArray = array_unique($locationsArray);

                    // Store the modified array in the session
                    Session::put('location1', $locationsArray);

                    $locations_vals = $locationsArray;
                } else {

                    $locations_vals = null;
                }

                if (isset($search)) {
                    $search_vals = $search;
                    $search = Session::put('search', $search_vals);

                } else {
                    $search_vals = null;

                }




                return view("company.unlocked_users", compact('filter_users', 'search', 'location1', 'filter', 'locations_vals', 'search_vals', 'store_locations'));


            }
        }


        if ($request->method() == 'GET') {

            $search = Session::get('search');
            $min = Session::get('min1');
            $max = Session::get('max1');
            $location1 = Session::get('location1');
            // dd($location1);
            $notice_period = Session::get('notice_period');



            $unlocked_users = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->get();

            foreach ($unlocked_users as $unlock) {



                $data[] = $unlock->unlocked_users_ids;



            }

            $query = User::where('hide_show', 0)->whereIn('id', $data);

            if ($search) {
                // Split the search keywords into an array and trim any whitespace
                $search = array_map('trim', explode(',', implode(',', $search)));

                $query->where(function ($q) use ($search) {
                    $q->where(function ($query) use ($search) {
                        foreach ($search as $keyword) {
                            $query->orWhereHas('profileSummary', function ($q) use ($keyword) {
                                $q->where('latestdesg', 'like', '%' . $keyword . '%');
                            });
                        }
                    });

                    $q->orWhere(function ($query) use ($search) {
                        $keyIds = JobSkill::whereIn('job_skill', $search)->pluck('id')->toArray();

                        if (!empty ($keyIds)) {
                            $query->orWhereHas('profilekeyskill', function ($q) use ($keyIds) {
                                $q->whereIn('keyskill', $keyIds);
                            });
                        }
                    });


                });
            } else {
                Session::forget('search');
            }



            if (!is_null($location1)) {


                $store_locations = array_filter($location1);

                $store_locations = implode(',', $store_locations);

                $locations = array_filter($location1);
                // dd($locations);

                if (in_array('bengaluru', $locations)) {
                    array_push($locations, 'bangalore');
                }
                if (in_array('bangalore', $locations)) {
                    array_push($locations, 'bengaluru');
                }
                if (in_array('bangalore/bengaluru', $locations)) {
                    array_push($locations, 'bengaluru', 'bangalore');
                }


                // dd($locations);

                if (!in_array('any', $locations) || !in_array('any', $locations)) {
                    $query->where(function ($query) use ($locations) {
                        foreach ($locations as $location) {

                            $query->orWhereRaw("LOWER(current_city) LIKE ?", [strtolower($location)]);
                        }
                    });
                }

                Session::put('store_locations', $store_locations);

            } else {
                $store_locations = '';

                Session::forget('store_locations');

                Session::forget('location1');
            }




            $filter_users = $query->paginate(2);

            Session::put('filter_users', $filter_users);// $this->filter2search($filter1_users);



            $filter = 1;

            if (isset($locations)) {

                // Split the string into an array, trim, and convert to lowercase
                $locationsArray = array_map('strtolower', array_map('trim', explode(',', implode(',', $locations))));

                // Check for specific conditions and modify the array
                $locationsArray = array_filter($locationsArray, function ($location) {
                    return !in_array($location, ['bengaluru', 'bangalore', 'bangalore/bengaluru']);
                });

                // Add a new value to the array
                $locationsArray[] = 'Bangalore/Bengaluru';

                // Remove duplicate values
                $locationsArray = array_unique($locationsArray);

                // Store the modified array in the session
                Session::put('location1', $locationsArray);

                $locations_vals = $locationsArray;
            } else {

                $locations_vals = null;
            }

            if (isset($search)) {
                $search_vals = $search;
                $search = Session::put('search', $search_vals);

            } else {
                $search_vals = null;

            }




            return view("company.unlocked_users", compact('filter_users', 'search', 'location1', 'filter', 'locations_vals', 'search_vals', 'store_locations'));


        } else {

            return redirect()->back();
        }







    }




    public function unlockedfiltersearch2(Request $request)
    {


        if ($request->max_exp) {
            $request->validate(
                [

                    'min_exp' => 'numeric',

                    'max_exp' => 'numeric|gt:min_exp',

                ],
                [
                    'max_exp.gt' => 'Max may not greater than min value',

                    'max_salary.gt' => 'Max may not greater than min value'
                ]
            );
        } elseif ($request->max_salary && $request->min_salary) {
            $request->validate(
                [

                    'min_salary' => 'numeric',

                    'max_salary' => 'numeric|gt:min_salary',

                ],
                [
                    'max_salary.gt' => 'Max may not greater than min value'
                ]
            );
        }



        if ($request->method() == 'POST') {

            //dd($request);



            $unlocked_users = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->get();

            //  dd($unlocked_users);

            foreach ($unlocked_users as $data4) {
                $data[] = $data4->unlocked_users_ids;
                //  dd($data);
            }

            if (count($unlocked_users) > 0) {


                $min_exp = (int) ($request->min_exp ?? 0);
                $max_exp = (int) ($request->max_exp ?? 0);

                //  dd($request->max_exp);



                $new1 = $request->max_salary;
                $max = (int) $new1;
                //  dd($max);

                $new = $request->min_salary;
                $min = (int) $new;


                if ($request->min_salary) {
                    $new = $request->min_salary;
                    $min = (int) $new;
                } else {
                    $min = 0;

                }

                $interview = $request->interview_avail;
                $education = $request->education;
                $course = $request->course;
                $specilation = $request->specilation;
                $gender = $request->gender;
                $job_type = $request->job_type;
                $filter_resume = $request->filter_resume;
                $s_date = $request->previous_start_date;
                $e_date = $request->previous_end_date;


                if ($request->previous_start_date) {
                    $startDate = date("Y-m-d", strtotime($request->previous_start_date));
                } else {
                    $startDate = '';
                }
                if ($request->previous_end_date) {
                    $endDate = date("Y-m-d", strtotime($request->previous_end_date));
                } else {
                    $endDate = '';
                }
                if ($request->notice_period) {
                    $notice_period = $request->notice_period;
                } else {
                    $notice_period = NULL;
                }



                $now = \Carbon\Carbon::now();

                // dd($startDate);

                $today = \Carbon\Carbon::now()->format('Y-m-d');
                $tommorrow = \Carbon\Carbon::now()->addDay(1)->format('Y-m-d');



                $search = Session::get('search');
                $location1 = Session::get('location1');



                $query = User::where('hide_show', 0)->whereIn('id', $data);

                if ($search) {

                    //  dd('search value is there');


                    // Split the search keywords into an array and trim any whitespace
                    $search = array_map('trim', explode(',', implode(',', $search)));

                    $query->where(function ($q) use ($search) {
                        $q->where(function ($query) use ($search) {
                            foreach ($search as $keyword) {
                                $query->orWhereHas('profileSummary', function ($q) use ($keyword) {
                                    $q->where('latestdesg', 'like', '%' . $keyword . '%');
                                });
                            }
                        });

                        $q->orWhere(function ($query) use ($search) {
                            $keyIds = JobSkill::whereIn('job_skill', $search)->pluck('id')->toArray();

                            if (!empty ($keyIds)) {
                                $query->orWhereHas('profilekeyskill', function ($q) use ($keyIds) {
                                    $q->whereIn('keyskill', $keyIds);
                                });
                            }
                        });
                    });
                } else {
                    // dd('search value is not there');
                }

                if (!is_null($location1)) {

                    $store_locations = $location1;

                    $locations = array_map('strtolower', array_map('trim', explode(',', implode(',', $location1))));
                    $store_locations = array_filter($location1);
                    $store_locations = implode(',', $store_locations);

                    if (in_array('bengaluru', $locations)) {
                        array_push($locations, 'bangalore');
                    }
                    if (in_array('bangalore', $locations)) {
                        array_push($locations, 'bengaluru');
                    }
                    if (in_array('bangalore/bengaluru', $locations)) {
                        array_push($locations, 'bengaluru', 'bangalore');
                    }


                    // dd($locations);

                    if (!in_array('any', $locations) && !in_array('any', $locations)) {
                        $query->where(function ($query) use ($locations) {
                            foreach ($locations as $location) {
                                $query->orWhereRaw("LOWER(current_city) LIKE ?", [strtolower($location)]);
                            }
                        });
                    }


                    Session::put('store_locations', $store_locations);

                } else {
                    $store_locations = '';

                    Session::forget('location1');
                }




                if ($min_exp && $max_exp) {
                    // Both min_exp and max_exp are provided
                    $query->whereHas('profileSummary', function ($q) use ($min_exp, $max_exp) {
                        $q->whereBetween('totalexp', [$min_exp, $max_exp]);
                    });
                } elseif ($min_exp) {
                    // Only min_exp is provided
                    $query->whereHas('profileSummary', function ($q) use ($min_exp) {
                        $q->where('totalexp', '>=', $min_exp);
                    });
                } elseif ($max_exp) {
                    // Only max_exp is provided
                    $query->whereHas('profileSummary', function ($q) use ($max_exp) {
                        $q->where('totalexp', '<=', $max_exp);
                    });
                }

                // dd($max); 

                if ($min || $max) {

                    $query->whereHas('profileDetails', function ($q) use ($min, $max) {
                        $q->whereBetween('expect_ctc_lakhs', [$min, $max]);
                    });

                }


                if ($notice_period) {
                    $query->whereHas('profileNop', function ($q) use ($notice_period) {
                        $q->whereIn('nop_days', $notice_period);
                    });


                }

                if ($education) {
                    $query->whereHas('profileEducation', function ($q) use ($education) {

                        $q->where('degree_title', $education);

                    });
                }

                if ($course) {

                    $query->whereHas('profileEducation', function ($q) use ($course) {

                        $q->where('course', $course);

                    });
                }

                if ($specilation) {
                    $query->whereHas('profileEducation', function ($q) use ($specilation) {
                        $q->where('specilation', $specilation);
                    });
                }

                if ($job_type) {
                    $query->whereHas('profileDetails', function ($q) use ($job_type) {
                        $q->where('work_type', $job_type);
                    });
                }

                if ($gender) {
                    //  dd($gender);
                    $query->where('gender_id', $gender);
                }



                if ($startDate) {
                    //  dd($startDate);

                    // dd($today);
                    $query->whereHas('interViews', function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('date', [$startDate, $endDate]);
                        // dd($q);
                    });


                }


                if ($filter_resume == '1') {
                    $query->where('verified', 1);

                }
                if ($filter_resume == '2') {
                    $query->where('verified', 0);
                }
                if ($filter_resume == '3') {
                    $query->where('package_end_date', '>', $now);
                }



                $filter_users = $query->paginate(30);
                //  dd($users);


                Session::put('notice_period', $notice_period);

                Session::put('min1', $min);

                Session::put('max1', $max);

                Session::put('min_exp', $min_exp);

                Session::put('max_exp', $max_exp);

                Session::put('interview_avail', $interview);

                Session::put('education', $education);

                Session::put('course', $course);

                Session::put('specilation', $specilation);

                Session::put('gender', $gender);

                Session::put('startDate', $startDate);

                Session::put('endDate', $endDate);

                Session::put('job_type', $job_type);

                Session::put('filter_resume', $filter_resume);

                $filter = 2;


                if (isset($location1)) {
                    $locations_vals = $location1;

                } else {
                    $locations_vals = null;

                }

                if (isset($search)) {
                    $search_vals = $search;

                } else {
                    $search_vals = null;

                }


                return view("company.unlocked_users", compact('filter_users', 'min_exp', 'max', 'min', 'max_exp', 'interview', 'gender', 'education', 'job_type', 'course', 'notice_period', 'locations_vals', 'search_vals', 'filter_resume', 's_date', 'e_date'));





            }


            if ($request->method() == 'GET') {


                $unlocked_users = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->get();



                foreach ($unlocked_users as $data4) {
                    $data[] = $data4->unlocked_users_ids;
                    //    dd($data);
                }


                $min_exp = Session::get('min_exp');
                $max_exp = Session::get('max_exp');
                $interview = Session::get('interview_avail');
                $education = Session::get('education');
                $course = Session::get('course');
                $specilation = Session::get('specilation');
                $gender = Session::get('gender');
                $job_type = Session::get('job_type');
                $filter_resume = Session::get('filter_resume');
                $startDate = Session::get('startDate');
                $endDate = Session::get('endDate');





                $now = \Carbon\Carbon::now();

                $today = \Carbon\Carbon::now()->format('Y-m-d');

                $tommorrow = \Carbon\Carbon::now()->addDay(1)->format('Y-m-d');




                $query = User::whereIn('id', $data);



                //dd($query);


                if ($min_exp && $max_exp) {
                    $query->whereHas('profileSummary', function ($q) use ($min_exp, $max_exp) {

                        $q->whereBetween('totalexp', [$min_exp, $max_exp]);

                    });
                }

                if ($education) {
                    $query->whereHas('profileEducation', function ($q) use ($education) {
                        $q->where('degree_title', $education);
                    });
                }
                if ($course) {
                    $query->whereHas('profileEducation', function ($q) use ($course) {
                        $q->where('course', $course);
                    });
                }

                if ($specilation) {
                    $query->whereHas('profileEducation', function ($q) use ($specilation) {
                        $q->where('specilation', $specilation);
                    });
                }
                if ($job_type) {
                    $query->whereHas('profileDetails', function ($q) use ($job_type) {
                        $q->where('work_type', $job_type);
                    });
                }

                if ($gender) {
                    $query->where('gender_id', $gender);
                }


                if ($startDate) {
                    //dd($startDate);

                    // dd($today);
                    $query->whereHas('interViews', function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('date', [$startDate, $endDate]);
                        // dd($q);
                    });


                }


                if ($filter_resume == '1') {

                    $query->where('verified', 1);


                }
                if ($filter_resume == '2') {
                    $query->where('verified', 0);
                }

                if ($filter_resume == '3') {


                    $query->where('package_end_date', '>', $now);

                }



                $users = $query->paginate(10);



                Session::put('min_exp', $min_exp);

                //  Session::put('min1', $min );





                return view("company.unlocked_users", compact('users', 'min_exp', 'max_exp', 'interview', 'education', 'job_type', 'gender', 's_date', 'e_date'));

            } else {
                return redirect()->back();
            }


        }


    }



    /************************************************    Bulk Email  ***************************************** */





    public function search2(Request $request)
    {


        $search = $request->search;



        $collections = CollectionList::where('collection_id', '=', $request->collection_id)->get();



        foreach ($collections as $unlock) {



            $data[] = $unlock->user_id;



        }



        $search_users = User::whereHas('profileSummary', function ($q) use ($search) {

            $q->where('latestdesg', $search);

        })->whereIn('id', $data)->get();


        return view("collectionsbulkmail", compact('search_users', 'collections'));



    }

    public function bulkfiltersearch1(Request $request)
    {


        if ($request->method() == 'POST') {

            $collections = CollectionList::where('collection_id', '=', $request->collection_id)->get();

            $folder_id = $request->collection_id;

            foreach ($collections as $unlock) {

                $data[] = $unlock->user_id;


            }



            $search = $request->search;

            $collection_id = $request->collection_id;

            $search = !is_null($request->search[0]) ? $request->search : NULL;

            if (!is_null($request->location)) {

                $location1 = !is_null($request->location[0]) ? $request->location : NULL;

            } else {
                $location1 = null;
            }
            $query = User::where('hide_show', 0)->whereIn('id', $data);



            if ($search) {
                // Split the search keywords into an array and trim any whitespace
                $search = array_map('trim', explode(',', implode(',', $search)));

                $query->where(function ($q) use ($search) {
                    $q->where(function ($query) use ($search) {
                        foreach ($search as $keyword) {
                            $query->orWhereHas('profileSummary', function ($q) use ($keyword) {
                                $q->where('latestdesg', 'like', '%' . $keyword . '%');
                            });
                        }
                    });

                    $q->orWhere(function ($query) use ($search) {
                        $keyIds = JobSkill::whereIn('job_skill', $search)->pluck('id')->toArray();

                        if (!empty ($keyIds)) {
                            $query->orWhereHas('profilekeyskill', function ($q) use ($keyIds) {
                                $q->whereIn('keyskill', $keyIds);
                            });
                        }
                    });


                });
            } else {
                Session::forget('search');
            }

            if (!is_null($location1)) {

                $store_locations = $location1;


                $locations = array_map('strtolower', array_map('trim', explode(',', $location1)));

                if (in_array('bengaluru', $locations)) {
                    array_push($locations, 'bangalore');
                }
                if (in_array('bangalore', $locations)) {
                    array_push($locations, 'bengaluru');
                }
                if (in_array('bangalore/bengaluru', $locations)) {
                    array_push($locations, 'bengaluru', 'bangalore');
                }


                if (!in_array('Any', $locations) || !in_array('any', $locations)) {
                    $query->where(function ($query) use ($locations) {
                        foreach ($locations as $location) {

                            $query->orWhereRaw("LOWER(current_city) LIKE ?", [strtolower($location)]);
                        }
                    });
                }

                Session::put('store_locations', $store_locations);

            } else {
                $store_locations = '';

                Session::forget('store_locations');

                Session::forget('location1');
            }

            $fusers = $query->paginate(10);

            Session::put('users', $fusers);// $this->filter2search($filter1_users);
            Session::put('collection_id', $collection_id);



            $filter = 1;


            if (isset($locations)) {

                // Split the string into an array, trim, and convert to lowercase
                $locationsArray = array_map('strtolower', array_map('trim', explode(',', implode(',', $locations))));

                // Check for specific conditions and modify the array
                $locationsArray = array_filter($locationsArray, function ($location) {
                    return !in_array($location, ['bengaluru', 'bangalore', 'bangalore/bengaluru']);
                });

                // Add a new value to the array
                $locationsArray[] = 'Bangalore/Bengaluru';

                // Remove duplicate values
                $locationsArray = array_unique($locationsArray);

                // Store the modified array in the session
                Session::put('location1', $locationsArray);

                $locations_vals = $locationsArray;
            } else {

                $locations_vals = null;
            }

            if (isset($search)) {
                $search_vals = $search;
                $search = Session::put('search', $search_vals);

            } else {
                $search_vals = null;

            }

            //  dd($fusers);


            return view("collectionsbulkmail", compact('fusers', 'collections', 'search', 'location1', 'locations_vals', 'search_vals', 'folder_id', 'store_locations'));

        }
        if ($request->method() == 'GET') {

            $collection_id = Session::get('collection_id');

            $folder_id = $collection_id;


            $collections = CollectionList::where('collection_id', '=', $collection_id)->get();

            // dd($collections);

            foreach ($collections as $unlock) {



                $data[] = $unlock->user_id;



            }





            $search = Session::get('search');
            $location1 = Session::get('location1');


            $query = User::whereIn('id', $data);

            if ($search) {
                // Split the search keywords into an array and trim any whitespace
                $search = array_map('trim', explode(',', implode(',', $search)));

                $query->where(function ($q) use ($search) {
                    $q->where(function ($query) use ($search) {
                        foreach ($search as $keyword) {
                            $query->orWhereHas('profileSummary', function ($q) use ($keyword) {
                                $q->where('latestdesg', 'like', '%' . $keyword . '%');
                            });
                        }
                    });

                    $q->orWhere(function ($query) use ($search) {
                        $keyIds = JobSkill::whereIn('job_skill', $search)->pluck('id')->toArray();

                        if (!empty ($keyIds)) {
                            $query->orWhereHas('profilekeyskill', function ($q) use ($keyIds) {
                                $q->whereIn('keyskill', $keyIds);
                            });
                        }
                    });


                });
            } else {
                Session::forget('search');
            }

            if (!is_null($location1)) {

                $store_locations = $location1;


                $locations = array_map('strtolower', array_map('trim', explode(',', $location1)));

                if (in_array('bengaluru', $locations)) {
                    array_push($locations, 'bangalore');
                }
                if (in_array('bangalore', $locations)) {
                    array_push($locations, 'bengaluru');
                }
                if (in_array('bangalore/bengaluru', $locations)) {
                    array_push($locations, 'bengaluru', 'bangalore');
                }


                if (!in_array('Any', $locations) || !in_array('any', $locations)) {
                    $query->where(function ($query) use ($locations) {
                        foreach ($locations as $location) {

                            $query->orWhereRaw("LOWER(current_city) LIKE ?", [strtolower($location)]);
                        }
                    });
                }

                Session::put('store_locations', $store_locations);

            } else {
                $store_locations = '';

                Session::forget('store_locations');

                Session::forget('location1');
            }

            $fusers = $query->paginate(10);

            Session::put('users', $fusers);// $this->filter2search($filter1_users);
            Session::put('collection_id', $collection_id);



            $filter = 1;


            if (isset($locations)) {

                // Split the string into an array, trim, and convert to lowercase
                $locationsArray = array_map('strtolower', array_map('trim', explode(',', implode(',', $locations))));

                // Check for specific conditions and modify the array
                $locationsArray = array_filter($locationsArray, function ($location) {
                    return !in_array($location, ['bengaluru', 'bangalore', 'bangalore/bengaluru']);
                });

                // Add a new value to the array
                $locationsArray[] = 'Bangalore/Bengaluru';

                // Remove duplicate values
                $locationsArray = array_unique($locationsArray);

                // Store the modified array in the session
                Session::put('location1', $locationsArray);

                $locations_vals = $locationsArray;
            } else {

                $locations_vals = null;
            }

            if (isset($search)) {
                $search_vals = $search;
                $search = Session::put('search', $search_vals);

            } else {
                $search_vals = null;

            }




            return view("collectionsbulkmail", compact('fusers', 'collections', 'search', 'location1', 'locations_vals', 'search_vals', 'folder_id', 'store_locations'));

        }
    }


    public function bulkfiltersearch2(Request $request)
    {

        if ($request->max_exp) {
            $request->validate(
                [

                    'min_exp' => 'numeric',

                    'max_exp' => 'numeric|gt:min_exp',


                ],
                [
                    'max_exp.gt' => 'Max may not greater than min value',

                    'max_salary.gt' => 'Max may not greater than min value'
                ]
            );
        } elseif ($request->max_salary && $request->min_salary) {
            $request->validate(
                [

                    'min_salary' => 'numeric',

                    'max_salary' => 'numeric|gt:min_salary',

                ],
                [
                    'max_salary.gt' => 'Max may not greater than min value'
                ]
            );
        }



        if ($request->method() == 'POST') {

            $collections = CollectionList::where('collection_id', '=', $request->collection_id)->get();

            $folder_id = $request->collection_id;



            foreach ($collections as $unlock) {
                $data[] = $unlock->user_id;
            }


            $collection_id1 = $request->collection_id;

            // $query = User::whereIn('id', $data);
            $min_exp = (int) ($request->min_exp ?? 0);
            $max_exp = (int) ($request->max_exp ?? 0);

            //  dd($request->max_exp);



            $new1 = $request->max_salary;
            $max = (int) $new1;
            //  dd($max);

            $new = $request->min_salary;
            $min = (int) $new;


            if ($request->min_salary) {
                $new = $request->min_salary;
                $min = (int) $new;
            } else {
                $min = 0;

            }

            $interview = $request->interview_avail;
            $education = $request->education;
            $course = $request->course;
            $specilation = $request->specilation;
            $gender = $request->gender;
            $job_type = $request->job_type;
            $filter_resume = $request->filter_resume;
            $s_date = $request->previous_start_date;
            $e_date = $request->previous_end_date;


            if ($request->previous_start_date) {
                $startDate = date("Y-m-d", strtotime($request->previous_start_date));
            } else {
                $startDate = '';
            }
            if ($request->previous_end_date) {
                $endDate = date("Y-m-d", strtotime($request->previous_end_date));
            } else {
                $endDate = '';
            }
            if ($request->notice_period) {
                $notice_period = $request->notice_period;
            } else {
                $notice_period = NULL;
            }



            $now = \Carbon\Carbon::now();

            // dd($startDate);

            $today = \Carbon\Carbon::now()->format('Y-m-d');
            $tommorrow = \Carbon\Carbon::now()->addDay(1)->format('Y-m-d');



            $search = Session::get('search');
            $location1 = Session::get('location1');



            $query = User::where('hide_show', 0)->whereIn('id', $data);

            if ($search) {

                //  dd('search value is there');


                // Split the search keywords into an array and trim any whitespace
                $search = array_map('trim', explode(',', implode(',', $search)));

                $query->where(function ($q) use ($search) {
                    $q->where(function ($query) use ($search) {
                        foreach ($search as $keyword) {
                            $query->orWhereHas('profileSummary', function ($q) use ($keyword) {
                                $q->where('latestdesg', 'like', '%' . $keyword . '%');
                            });
                        }
                    });

                    $q->orWhere(function ($query) use ($search) {
                        $keyIds = JobSkill::whereIn('job_skill', $search)->pluck('id')->toArray();

                        if (!empty ($keyIds)) {
                            $query->orWhereHas('profilekeyskill', function ($q) use ($keyIds) {
                                $q->whereIn('keyskill', $keyIds);
                            });
                        }
                    });
                });
            } else {
                // dd('search value is not there');
            }

            if (!is_null($location1)) {

                $store_locations = $location1;

                $locations = array_map('strtolower', array_map('trim', explode(',', implode(',', $location1))));
                $store_locations = array_filter($location1);
                $store_locations = implode(',', $store_locations);

                if (in_array('bengaluru', $locations)) {
                    array_push($locations, 'bangalore');
                }
                if (in_array('bangalore', $locations)) {
                    array_push($locations, 'bengaluru');
                }
                if (in_array('bangalore/bengaluru', $locations)) {
                    array_push($locations, 'bengaluru', 'bangalore');
                }


                // dd($locations);

                if (!in_array('Any', $locations) && !in_array('any', $locations)) {
                    $query->where(function ($query) use ($locations) {
                        foreach ($locations as $location) {
                            $query->orWhereRaw("LOWER(current_city) LIKE ?", [strtolower($location)]);
                        }
                    });
                }


                Session::put('store_locations', $store_locations);

            } else {
                $store_locations = '';

                Session::forget('location1');
            }




            if ($min_exp && $max_exp) {
                // Both min_exp and max_exp are provided
                $query->whereHas('profileSummary', function ($q) use ($min_exp, $max_exp) {
                    $q->whereBetween('totalexp', [$min_exp, $max_exp]);
                });
            } elseif ($min_exp) {
                // Only min_exp is provided
                $query->whereHas('profileSummary', function ($q) use ($min_exp) {
                    $q->where('totalexp', '>=', $min_exp);
                });
            } elseif ($max_exp) {
                // Only max_exp is provided
                $query->whereHas('profileSummary', function ($q) use ($max_exp) {
                    $q->where('totalexp', '<=', $max_exp);
                });
            }


            if ($min || $max) {

                $query->whereHas('profileDetails', function ($q) use ($min, $max) {
                    $q->whereBetween('expect_ctc_lakhs', [$min, $max]);
                });

            }


            if ($notice_period) {
                $query->whereHas('profileNop', function ($q) use ($notice_period) {
                    $q->whereIn('nop_days', $notice_period);
                });


            }

            if ($education) {
                $query->whereHas('profileEducation', function ($q) use ($education) {

                    $q->where('degree_title', $education);

                });
            }

            if ($course) {

                $query->whereHas('profileEducation', function ($q) use ($course) {

                    $q->where('course', $course);

                });
            }

            if ($specilation) {
                $query->whereHas('profileEducation', function ($q) use ($specilation) {
                    $q->where('specilation', $specilation);
                });
            }

            if ($job_type) {
                $query->whereHas('profileDetails', function ($q) use ($job_type) {
                    $q->where('work_type', $job_type);
                });
            }

            if ($gender) {
                //  dd($gender);
                $query->where('gender_id', $gender);
            }



            if ($startDate) {
                //  dd($startDate);

                // dd($today);
                $query->whereHas('interViews', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('date', [$startDate, $endDate]);
                    // dd($q);
                });


            }


            if ($filter_resume == '1') {
                $query->where('verified', 1);

            }
            if ($filter_resume == '2') {
                $query->where('verified', 0);
            }
            if ($filter_resume == '3') {
                $query->where('package_end_date', '>', $now);
            }



            $fusers = $query->paginate(30);

            Session::put('notice_period', $notice_period);

            Session::put('min1', $min);

            Session::put('max1', $max);

            Session::put('min_exp', $min_exp);

            Session::put('max_exp', $max_exp);

            Session::put('interview_avail', $interview);

            Session::put('education', $education);

            Session::put('course', $course);

            Session::put('specilation', $specilation);

            Session::put('gender', $gender);

            Session::put('startDate', $startDate);

            Session::put('endDate', $endDate);

            Session::put('job_type', $job_type);

            Session::put('filter_resume', $filter_resume);

            $filter = 2;


            if (isset($location1)) {
                $locations_vals = $location1;

            } else {
                $locations_vals = null;

            }

            if (isset($search)) {
                $search_vals = $search;

            } else {
                $search_vals = null;

            }


            return view("collectionsbulkmail", compact('fusers', 'collections', 'min_exp', 'max', 'min', 'max_exp', 'interview', 'gender', 'education', 'job_type', 'course', 'notice_period', 'locations_vals', 'search_vals', 'folder_id', 'filter_resume', 's_date', 'e_date'));
        }


        if ($request->method() == 'GET') {

            $collection_id1 = Session::get('collection_id1');
            $folder_id = $collection_id1;
            $collections = CollectionList::where('collection_id', '=', $collection_id1)->get();


            foreach ($collections as $unlock) {



                $data[] = $unlock->user_id;



            }





            $min_exp = Session::get('min_exp');
            $max_exp = Session::get('max_exp');
            $interview = Session::get('interview_avail');
            $education = Session::get('education');
            $course = Session::get('course');
            $specilation = Session::get('specilation');
            $gender = Session::get('gender');
            $job_type = Session::get('job_type');
            $filter_resume = Session::get('filter_resume');
            $startDate = Session::get('startDate');
            $endDate = Session::get('endDate');
            $s_date = Session::get('s_date');
            $e_date = Session::get('e_date');
            $notice_period = Session::get('notice_period');
            $min = Session::get('min1');
            $max = Session::get('max1');







            $now = \Carbon\Carbon::now();
            $today = \Carbon\Carbon::now()->format('Y-m-d');
            $tommorrow = \Carbon\Carbon::now()->addDay(1)->format('Y-m-d');


            $search = Session::get('search');
            $location1 = Session::get('location1');


            $query = User::whereIn('id', $data);

            //filter 1 search value is there 

            if ($search) {


                // Split the search keywords into an array and trim any whitespace
                $search = array_map('trim', explode(',', implode(',', $search)));

                $query->where(function ($q) use ($search) {
                    $q->where(function ($query) use ($search) {
                        foreach ($search as $keyword) {
                            $query->orWhereHas('profileSummary', function ($q) use ($keyword) {
                                $q->where('latestdesg', 'like', '%' . $keyword . '%');
                            });
                        }
                    });

                    $q->orWhere(function ($query) use ($search) {
                        $keyIds = JobSkill::whereIn('job_skill', $search)->pluck('id')->toArray();

                        if (!empty ($keyIds)) {
                            $query->orWhereHas('profilekeyskill', function ($q) use ($keyIds) {
                                $q->whereIn('keyskill', $keyIds);
                            });
                        }
                    });
                });
            }

            if ($location1) {
                $locations = array_map('trim', explode(',', implode(',', $location1)));
                if (!in_array('any', $locations)) {
                    $query->whereIn('current_city', $locations);
                }
            }


            if ($min || $max) {

                $query->whereHas('profileDetails', function ($q) use ($min, $max) {
                    $q->whereBetween('expect_ctc_lakhs3', [$min, $max]);
                });

            }


            if ($notice_period) {
                $query->whereHas('profileNop', function ($q) use ($notice_period) {
                    $q->whereIn('nop_days', $notice_period);
                });


            }



            if ($min_exp && $max_exp) {
                $query->whereHas('profileSummary', function ($q) use ($min_exp, $max_exp) {

                    $q->whereBetween('totalexp', [$min_exp, $max_exp]);

                });
            }

            if ($education) {
                $query->whereHas('profileEducation', function ($q) use ($education) {
                    $q->where('degree_title', $education);
                });
            }
            if ($course) {
                $query->whereHas('profileEducation', function ($q) use ($course) {
                    $q->where('course', $course);
                });
            }

            if ($specilation) {
                $query->whereHas('profileEducation', function ($q) use ($specilation) {
                    $q->where('specilation', $specilation);
                });
            }
            if ($job_type) {
                $query->whereHas('profileDetails', function ($q) use ($job_type) {
                    $q->where('work_type', $job_type);
                });
            }

            if ($gender) {
                $query->where('gender_id', $gender);
            }



            if ($startDate) {
                //dd($startDate);

                // dd($today);
                $query->whereHas('interViews', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('date', [$startDate, $endDate]);
                    // dd($q);
                });


            }


            if ($filter_resume == '1') {

                $query->where('verified', 1);


            }
            if ($filter_resume == '2') {
                $query->where('verified', 0);
            }

            if ($filter_resume == '3') {


                $query->where('package_end_date', '>', $now);

            }



            $users = $query->paginate(10);


            if (isset($location1)) {
                $locations_vals = $location1;

            } else {
                $locations_vals = null;

            }

            if (isset($search)) {
                $search_vals = $search;

            } else {
                $search_vals = null;

            }




            return view("collectionsbulkmail", compact('users', 'collections', 'min_exp', 'max', 'min', 'max_exp', 'interview', 'gender', 'education', 'job_type', 'course', 'notice_period', 'locations_vals', 'search_vals', 'folder_id', 'filter_resume', 's_date', 'e_date'));
        }


    }







    public function changeCompanyPassword()
    {

        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        // return dd($company);

        return view('company_auth.passwords.change_com_password', compact('company'));

    }



    public function updateCompanyPassword(Request $request, $id)
    {



        // $user = User::findOrFail(Auth::user()->id);



        // $request->validate([

        //     'old_password'=>'required',

        //     'new_password'=>'required|min:6',

        //     'new_password_confirmation'=>'required|same:new_password|min:6'

        // ]);
        $this->validate(

            $request,
            [
                'old_password' => 'required',

                'new_password' => 'required|min:6|max:12',

                'new_password_confirmation' => 'required|same:new_password|min:6|max:12'
            ],
            [

                'old_password.required' => ' Old Password is required',
                'new_password.required' => ' New Password is required',
                'new_password_confirmation.required' => ' Confirm New Password is required',

            ]
        );


        $hashedPassword = Auth::guard('company')->user()->password;

        // dd($hashedPassword);



        if (\Hash::check($request->old_password, $hashedPassword)) {



            if (!\Hash::check($request->new_password, $hashedPassword)) {

                $company = Auth::guard('company')->user()->get();

                // dd($company);

                $company->password = bcrypt($request->new_password);

                Company::where('id', Auth::guard('company')->user()->id)->update(array('password' => $company->password));



                // session()->flash('message','Password updated successfully');

                // return back()->with('success', 'Password updated successfully!');

                return redirect()->back()->with('message', 'Password updated successfully');

            } else {

                return redirect()->back()->with('message', "New password can not be the old password");

            }

        } else {

            return redirect()->back()->with('error', "Old password doesn't matched");

        }

    }



    // Add resumes to Folder

    public function addResumes(Request $request)
    {



        $collection_list = CollectionList::where('collection_id', $request->collection_id)->get();



        if (count($collection_list) < 100) {
            //return dd('value');

            // return dd(count($collection_list));

            $this->validate(

                $request,
                [

                    'collection_id' => 'required',


                ],
                [

                    'collection_id.required' => 'Folder is required'

                ]
            );


            $company_id = Auth::guard('company')->user()->id;
            // dd($company_id);

            $collection_list = CollectionList::where('user_id', $request->user_id)->where('collection_id', $request->collection_id)->first();

            // dd($collection_list);

            if (empty($collection_list)) {

                $collection_folder_list = new CollectionList;

                $collection_folder_list->user_id = $request->user_id;

                $collection_folder_list->company_id = $company_id;

                $collection_folder_list->collection_id = $request->collection_id;

                $collection_folder_list->save();


                // return dd($collection_folder_list);

                return response()->json(array('success' => true, 'status' => 200), 200);
                // return back()->with('message','Resume added successfully');

            } else {
                // return response()->json(array('success' => true, 'status' => 200), 200);
                return response()->json(array('error' => true, 'status' => 400), 400);
                //   $msgresponse = ['error' => 'erroe', 'message' => __('Message sent successfully')];

                //   echo json_encode($msgresponse);

                //  return response()->json(array('errors' => true, 'status' => 422), 422); 

                //  return back()->with('error','Resume already exists in this collection');

            }


        } else {
            // return dd('no value');
            return response()->json(array('error1' => true, 'status' => 402), 402);
        }





    }

    public function addBulkResumes(Request $request)
    {

        // dd($request->all());


        $collection_list = CollectionList::where('collection_id', $request->collection_id)->get();

        //dd(count($collection_list));

        if (count($collection_list) < 100) {
            //return dd($request->all());

            // return dd(count($collection_list));

            $this->validate(

                $request,
                [

                    'collection_id' => 'required',
                    'user_id1' => 'required'


                ],
                [
                    'user_id1.required' => 'Note : Select atleast one user',

                    'collection_id.required' => 'Folder is required'

                ]
            );


            $company_id = Auth::guard('company')->user()->id;
            // dd($company_id);

            $user_idsec = $request->user_id1;

            //dd($user_ids1)
            $user_ids = (explode(",", $user_idsec));


            foreach ($user_ids as $user_id) {
                $collection_list = CollectionList::where('user_id', $user_id)->where('collection_id', $request->collection_id)->first();

                if (empty($collection_list)) {

                    $collection_folder_list = new CollectionList;

                    $collection_folder_list->user_id = $user_id;

                    $collection_folder_list->company_id = $company_id;

                    $collection_folder_list->collection_id = $request->collection_id;

                    $collection_folder_list->save();


                    // return dd($collection_folder_list);


                    // return back()->with('message','Resume added successfully');

                }


            }

            return response()->json(array('success' => true, 'status' => 200), 200);


        } else {
            // return dd('no value');
            return response()->json(array('error1' => true, 'status' => 402), 402);
        }





    }

    public function updatefrontcompany(Request $request)
    {
        //dd($request->all());

        $company = Company::where('id', $request->company_id)->first();

        $company->name = $request->name;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->ceo = $request->ceo;
        $company->description = nl2br($request->description);

        $company->save();

        return response()->json(['success', 'Updated Successfully']);
    }



    public function ajax11(Request $request)
    {
        //  dd('helooo');
        $user = User::paginate(3);

        if ($request->ajax()) {
            $view = view('company.candidate_listing', compact('user'))->render();
            return response()->json(['html' => $view]);
        }

        return view('candidate_listing', compact('user'));
    }
    public function paymenthistory()
    {
        $company_id = Auth::guard('company')->user()->id;

        $company_detail = Company::where('id', $company_id)->first();

        $payments = EmployerPayment::where('company_id', $company_id)->latest()->get();
        return view('company.payment-history', compact('payments', 'company_detail'));

    }


    public function updateprofilesection()
    {
        return view('company.updateprofile');
    }




    public function imagestore(Request $request)
    {


        $company_id = Auth::guard('company')->user()->id;
        $company = Company::where('id', $company_id)->first();

        // dd($request->all());

        if ($request->hasFile('logo')) {
            $is_deleted = $this->deleteCompanyLogo($company->id);
            $image = $request->file('logo');
            $fileName = ImgUploader::UploadImage('company_logos', $image, 300, 300, false);
            $company->logo = $fileName;

        }
        $url = asset('company_logos/' . $fileName);
        $company->save();

        return response()->json(
            [
                'success' => 'Updated Successfully',
                'url' => $url
            ]
        );

    }

    public function draft()
    {
        $drafts = Draft::where('emailed', 0)->where('company_id', Auth::guard('company')->user()->id)->get();
        $draft_value = Draft::where('emailed', 0)->where('company_id', Auth::guard('company')->user()->id)->first();

        return view('company.draft', compact('drafts', 'draft_value'));
    }


    public function storedraft(Request $request)
    {

        $request->validate([

            'name' => 'required',
            'message' => 'required',

        ], [

            'name.required' => 'Name is required',

            'message.required' => 'Message is required'
        ]);

        $draft = new Template();
        $draft->company_id = Auth::guard('company')->user()->id;
        $draft->name = $request->name;
        $draft->message = $request->message;
        $draft->save();

        return response()->json(array('success' => true, 'status' => 200), 200);



    }

    public function bulksms(Request $request)
    {

        $request->validate(
            [

                'message' => 'required',
                'user_id' => 'required'

            ],
            [
                'message.required' => 'Message is required',
                'user_id.required' => 'Note : Select atleast one user',
            ]

        );
        $emails = $request->user_id;
        $email = (explode(",", $emails));

        if (isset($email)) {

            $users = User::whereIn('id', $email)->get();
            //return dd($users);

            foreach ($users as $user_mail) {

                $apiKey = urlencode('MzA2MzUwMzA1NTc1NDU3MjZmMzk3MTQ5NTA3OTUzNDk=   ');

                // Message details
                $numbers = array(916374363023, 917639069608);
                $sender = urlencode('600010');
                $otp = 1230;
                $message = rawurlencode('Hi there, thank you for sending your first test message from Textlocal. Get 20% off today with our code: ' . $otp . '.');

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

            }


            return response()->json(array('success' => true, 'status' => 200), 200);
        }
    }

    // Draft Filter

    public function draftfiltersearch1(Request $request)
    {

        $request->validate([



        ]);



        if ($request->method() == 'POST') {


            //  dd($request->all());

            $company_id = Auth::guard('company')->user()->id;

            $collections = Draft::where('company_id', '=', $company_id)->get();

            if (count($collections) > 0) {



                foreach ($collections as $draft) {



                    $data[] = $draft->user_id;



                }


                $search = $request->search;

                $bulk12 = $request->min_salary;

                $bulk13 = $request->max_salary;

                $min = (int) $bulk12;
                $max = (int) $bulk13;


                if ($request->location) {
                    $location1 = $request->location;
                } else {
                    $location1 = NULL;
                }
                if ($request->notice_period) {
                    $notice_period = $request->notice_period;
                } else {
                    $notice_period = NULL;
                }


                if ($location1) {
                    $query = User::whereIn('id', $data);

                    if ($search) {

                        $query->where(function ($q) use ($search, $query) {

                            $q->whereHas('profilekeyskill', function ($q) use ($search, $query) {

                                $key = JobSkill::where('job_skill', 'like', '%' . $search . '%')->first();

                                if ($key != null) {

                                    $q->where('keyskill', $key->id);


                                } else {

                                    $query->WhereHas('profileSummary', function ($q) use ($search) {

                                        $q->where('latestdesg', 'like', '%' . $search . '%');


                                    });

                                }

                            })->orWhereHas('profileSummary', function ($q) use ($search) {

                                $q->where('latestdesg', 'like', '%' . $search . '%');


                            });
                        });

                    }

                    if ($min && $max) {

                        $query->whereHas('profileDetails', function ($q) use ($min, $max) {
                            $q->whereBetween('expect_ctc_lakhs3', [$min, $max]);
                        });

                    }


                    if ($notice_period) {
                        $query->whereHas('profileNop', function ($q) use ($notice_period, $location1) {
                            $q->whereIn('nop_days', $notice_period);
                        });


                    }
                    if ($location1) {
                        foreach ($location1 as $location) {
                            // dd($location);
                            $location_val = Location::where('location', 'like', "%{$location}%")->first();

                            $location_id[] = $location_val->id;
                        }
                        $query->whereHas('userlocation', function ($q) use ($location1) {
                            $q->whereIn('location', $location1);
                        });

                    }

                    $users = $query->paginate(10);

                } else {


                    $query = User::whereIn('id', $data);

                    if ($search) {

                        $query->where(function ($q) use ($search, $query) {

                            $q->whereHas('profilekeyskill', function ($q) use ($search, $query) {

                                $key = JobSkill::where('job_skill', 'like', '%' . $search . '%')->first();

                                if ($key != null) {

                                    $q->where('keyskill', $key->id);


                                } else {

                                    $query->WhereHas('profileSummary', function ($q) use ($search) {

                                        $q->where('latestdesg', 'like', '%' . $search . '%');


                                    });

                                }

                            })->orWhereHas('profileSummary', function ($q) use ($search) {

                                $q->where('latestdesg', 'like', '%' . $search . '%');


                            });
                        });
                    }

                    if ($min && $max) {

                        $query->whereHas('profileDetails', function ($q) use ($min, $max) {
                            $q->whereBetween('expect_ctc_lakhs3', [$min, $max]);
                        });

                    }


                    if ($notice_period) {
                        $query->whereHas('profileNop', function ($q) use ($notice_period, $location1) {
                            $q->whereIn('nop_days', $notice_period);
                        });


                    }


                    $users = $query->paginate(10);

                }






                // dd($filter1_users);


                // Session::put('filter1_users', $filter1_users );// $this->filter2search($filter1_users);

                Session::put('search', $search);

                Session::put('min1', $min);

                Session::put('max1', $max);



                Session::put('notice_period', $notice_period);

                if (isset($location_id)) {
                    $location1 = $location_id;
                }

                $location2 = $request->location;
                Session::put('location1', $location2);


                return view("company.draft", compact('users', 'collections', 'search', 'min', 'max', 'location1', 'notice_period'));

            } else {

                return redirect()->back();

            }

        }
        if ($request->method() == 'GET') {
            //  dd('get');



            $company_id = Auth::guard('company')->user()->id;

            $collections = Draft::where('company_id', '=', $company_id)->get();



            foreach ($collections as $draft) {



                $data[] = $draft->user_id;



            }


            $search = Session::get('search');


            $min = Session::get('min1');
            //    return dd($min);

            $max = Session::get('max1');


            $location1 = Session::get('location1');

            $notice_period = Session::get('notice_period');


            if ($location1) {
                $query = User::whereIn('id', $data);

                if ($search) {

                    $query->where(function ($q) use ($search, $query) {

                        $q->whereHas('profilekeyskill', function ($q) use ($search, $query) {

                            $key = JobSkill::where('job_skill', 'like', '%' . $search . '%')->first();

                            if ($key != null) {

                                $q->where('keyskill', $key->id);


                            } else {

                                $query->WhereHas('profileSummary', function ($q) use ($search) {

                                    $q->where('latestdesg', 'like', '%' . $search . '%');


                                });

                            }

                        })->orWhereHas('profileSummary', function ($q) use ($search) {

                            $q->where('latestdesg', 'like', '%' . $search . '%');


                        });
                    });

                }

                if ($min && $max) {

                    $query->whereHas('profileDetails', function ($q) use ($min, $max) {
                        $q->whereBetween('expect_ctc_lakhs3', [$min, $max]);
                    });

                }


                if ($notice_period) {
                    $query->whereHas('profileNop', function ($q) use ($notice_period, $location1) {
                        $q->whereIn('nop_days', $notice_period);
                    });


                }
                if ($location1) {
                    foreach ($location1 as $location) {
                        // dd($location);
                        $location_val = Location::where('location', 'like', "%{$location}%")->first();

                        $location_id[] = $location_val->id;
                    }
                    $query->whereHas('userlocation', function ($q) use ($location1) {
                        $q->whereIn('location', $location1);
                    });

                }

                $users = $query->paginate(10);

            } else {
                $query = User::whereIn('id', $data);

                if ($search) {

                    $query->where(function ($q) use ($search, $query) {

                        $q->whereHas('profilekeyskill', function ($q) use ($search, $query) {

                            $key = JobSkill::where('job_skill', 'like', '%' . $search . '%')->first();

                            if ($key != null) {

                                $q->where('keyskill', $key->id);


                            } else {

                                $query->WhereHas('profileSummary', function ($q) use ($search) {

                                    $q->where('latestdesg', 'like', '%' . $search . '%');


                                });

                            }

                        })->orWhereHas('profileSummary', function ($q) use ($search) {

                            $q->where('latestdesg', 'like', '%' . $search . '%');


                        });
                    });

                }

                if ($min && $max) {

                    $query->whereHas('profileDetails', function ($q) use ($min, $max) {
                        $q->whereBetween('expect_ctc_lakhs3', [$min, $max]);
                    });

                }


                if ($notice_period) {
                    $query->whereHas('profileNop', function ($q) use ($notice_period, $location1) {
                        $q->whereIn('nop_days', $notice_period);
                    });


                }


                $users = $query->paginate(10);

            }


            if (isset($location_id)) {
                $location1 = $location_id;
            }



            // dd($filter1_users);

            return view("company.draft", compact('users', 'collections', 'search', 'min', 'max', 'location1', 'notice_period'));

            // return view("collectionsbulkmail",compact('filter1_users','collections','search','min','max','location1','notice_period'));
        }


    }

    public function draftsubfiltersearch(Request $request)
    {


        if ($request->method() == 'POST') {

            $company_id = Auth::guard('company')->user()->id;

            $collections = Draft::where('company_id', '=', $company_id)->get();

            if (count($collections) > 0) {

                foreach ($collections as $draft) {



                    $data[] = $draft->user_id;



                }


                $exp = $request->min_exp;
                $min_exp = (int) $exp;
                $exp1 = $request->max_exp;
                $max_exp = (int) $exp1;

                $interview = $request->interview_avail;

                $education = $request->education;

                $gender = $request->gender;

                //return dd($gender);

                $job_type = $request->job_type;

                $course = $request->course;

                $specilation = $request->specilation;

                $filter_resume = $request->filter_resume;


                $now = \Carbon\Carbon::now();

                $today = \Carbon\Carbon::now()->format('Y-m-d');

                $tommorrow = \Carbon\Carbon::now()->addDay(1)->format('Y-m-d');



                $query = User::whereIn('id', $data);



                //dd($query);


                if ($min_exp && $max_exp) {
                    $query->whereHas('profileSummary', function ($q) use ($min_exp, $max_exp) {

                        $q->whereBetween('totalexp', [$min_exp, $max_exp]);

                    });
                }

                if ($education) {
                    $query->whereHas('profileEducation', function ($q) use ($education) {
                        $q->where('degree_title', $education);
                    });
                }
                if ($course) {
                    $query->whereHas('profileEducation', function ($q) use ($course) {
                        $q->where('course', $course);
                    });
                }

                if ($specilation) {
                    $query->whereHas('profileEducation', function ($q) use ($specilation) {
                        $q->where('specilation', $specilation);
                    });
                }
                if ($job_type) {
                    $query->whereHas('profileDetails', function ($q) use ($job_type) {
                        $q->where('work_type', $job_type);
                    });
                }

                if ($gender) {
                    $query->where('gender_id', $gender);
                }



                if ($interview == '1') {
                    //  dd($today);

                    // dd($today);
                    $query->whereHas('profileDetails', function ($q) use ($today) {
                        $q->where('video_date_from', '<=', $today)->where('video_date_to', '>=', $today)->where('night_telephonic_date_from', '<=', $today)->where('night_telephonic_date_to', '>=', $today);
                        // dd($q);
                    });


                } elseif ($interview == '2') {
                    // dd('tommorrow');

                    // dd($today);
                    $query->whereHas('profileDetails', function ($q) use ($tommorrow) {
                        $q->where('video_date_from', '<=', $tommorrow)->where('video_date_to', '>=', $tommorrow)->where('night_telephonic_date_from', '<=', $tommorrow)->where('night_telephonic_date_to', '>=', $tommorrow);
                        // dd($q);
                    });

                }

                if ($filter_resume == '1') {

                    $query->where('verified', 1);


                }
                if ($filter_resume == '2') {
                    $query->where('verified', 0);
                }
                if ($filter_resume == '3') {


                    $query->where('package_end_date', '>', $now);

                }


                $users = $query->paginate(10);





                //dd($filter2_users);
                Session::put('min_exp', $min_exp);

                //  Session::put('min1', $min );

                Session::put('max_exp', $max_exp);

                Session::put('interview_avail', $interview);

                Session::put('education', $education);

                Session::put('course', $course);

                Session::put('specilation', $specilation);

                Session::put('gender', $gender);

                Session::put('job_type', $job_type);

                Session::put('filter_resume', $filter_resume);

                return view("company.draft", compact('users', 'collections', 'min_exp', 'max_exp', 'interview', 'gender', 'education', 'job_type', 'course', 'specilation', 'filter_resume'));


            } else {

                return redirect()->back();
            }



        }


        if ($request->method() == 'GET') {



            $company_id = Auth::guard('company')->user()->id;

            $collections = Draft::where('company_id', '=', $company_id)->get();



            foreach ($collections as $draft) {



                $data[] = $draft->user_id;



            }


            $min_exp = Session::get('min_exp');
            $max_exp = Session::get('max_exp');
            $interview = Session::get('interview_avail');
            $education = Session::get('education');
            $course = Session::get('course');
            $specilation = Session::get('specilation');
            $gender = Session::get('gender');
            $job_type = Session::get('job_type');
            $filter_resume = Session::get('filter_resume');


            $now = \Carbon\Carbon::now();

            $today = \Carbon\Carbon::now()->format('Y-m-d');

            $tommorrow = \Carbon\Carbon::now()->addDay(1)->format('Y-m-d');



            $query = User::whereIn('id', $data);



            //dd($query);


            if ($min_exp && $max_exp) {
                $query->whereHas('profileSummary', function ($q) use ($min_exp, $max_exp) {

                    $q->whereBetween('totalexp', [$min_exp, $max_exp]);

                });
            }

            if ($education) {
                $query->whereHas('profileEducation', function ($q) use ($education) {
                    $q->where('degree_title', $education);
                });
            }
            if ($course) {
                $query->whereHas('profileEducation', function ($q) use ($course) {
                    $q->where('course', $course);
                });
            }

            if ($specilation) {
                $query->whereHas('profileEducation', function ($q) use ($specilation) {
                    $q->where('specilation', $specilation);
                });
            }
            if ($job_type) {
                $query->whereHas('profileDetails', function ($q) use ($job_type) {
                    $q->where('work_type', $job_type);
                });
            }

            if ($gender) {
                $query->where('gender_id', $gender);
            }



            if ($interview == '1') {
                //  dd($today);

                // dd($today);
                $query->whereHas('profileDetails', function ($q) use ($today) {
                    $q->where('video_date_from', '<=', $today)->where('video_date_to', '>=', $today)->where('night_telephonic_date_from', '<=', $today)->where('night_telephonic_date_to', '>=', $today);
                    // dd($q);
                });


            } elseif ($interview == '2') {
                // dd('tommorrow');

                // dd($today);
                $query->whereHas('profileDetails', function ($q) use ($tommorrow) {
                    $q->where('video_date_from', '<=', $tommorrow)->where('video_date_to', '>=', $tommorrow)->where('night_telephonic_date_from', '<=', $tommorrow)->where('night_telephonic_date_to', '>=', $tommorrow);
                    // dd($q);
                });

            }



            if ($filter_resume == '1') {

                $query->where('verified', 1);


            }
            if ($filter_resume == '2') {
                $query->where('verified', 0);
            }

            if ($filter_resume == '3') {


                $query->where('package_end_date', '>', $now);

            }


            $users = $query->paginate(10);

            //dd($filter2_users);


            return view("company.draft", compact('users', 'collections', 'min_exp', 'max_exp', 'interview', 'gender', 'education', 'job_type', 'course', 'specilation', 'filter_resume'));

        }

    }


    public function save_search(Request $request)
    {
        //  dd($request->all());
        $request->validate(
            [

                'search_value' => 'required'


            ],
            [
                'search_value.required' => 'Search name is requried'

            ]

        );

        //dd($request->all());


        $search = new SaveSearch();
        $search->company_id = Auth::guard('company')->user()->id;
        $search->search_value = $request->search_value;
        $search->search = $request->search;
        if ($request->location) {
            $locationArray = explode(',', $request->location);
            //dd($myArray);
            $search->location = serialize($locationArray);

        } else {
            $search->location = NUll;

        }

        $search->notice_period = $request->notice_period;
        $search->min_salary = $request->min_salary;
        $search->max_salary = $request->max_salary;

        $search->min_exp = $request->min_exp;
        $search->max_exp = $request->max_exp;
        $search->filter_resume = $request->filter_resume;
        $search->interview_avail = $request->interview_avail;
        $search->education = $request->education;
        $search->course = $request->course;
        $search->specilation = $request->specilation;
        $search->gender = $request->gender;
        $search->job_type = $request->job_type;
        $search->filter = $request->filter;
        $search->save();

        return response()->json(['success', 'Saved Successfully']);
    }

    public function saved_search(Request $request)
    {
        return view('company.savedsearch');
    }

    public function delete_saved_search($id)
    {
        $search = SaveSearch::where('id', $id)->delete();

        return redirect()->back()->with('message', 'Successfully Deleted');
    }

    public function searchnow($id)
    {
        $search_value = SaveSearch::where("id", $id)->first();

        if (!$search_value) {
            abort(404);
        }


        if ($search_value->filter == 1) {


            $search = $search_value->search;
            $new = $search_value->min_salary;
            $min = (int) $new;
            $new1 = $search_value->max_salary;
            $max = (int) $new1;
            if ($search_value->location) {
                $location1 = unserialize($search_value->location);
            } else {
                $location1 = NULL;
            }
            if ($search_value->notice_period) {
                $notice = $search_value->notice_period;
                $notice_period = explode(",", $notice);
            } else {
                $notice_period = NULL;
            }

            $search_skill = $search;
            if ($location1) {
                $store_locations = implode(',', $location1);
            } else {
                $store_locations = null;

            }



            if ($location1) {
                $query = User::latest();

                if ($search) {
                    $search = array_values(array_filter(array_map(function ($value) {
                        return strtolower(trim($value));
                    }, explode(',', $search)), 'strlen'));
                    $query->where(function ($q) use ($search) {
                        $q->where(function ($query) use ($search) {
                            foreach ($search as $keyword) {
                                $query->orWhereHas('profileSummary', function ($q) use ($keyword) {
                                    $q->where('latestdesg', 'like', '%' . $keyword . '%');
                                });
                            }
                        });

                        $q->orWhere(function ($query) use ($search) {
                            $keyIds = JobSkill::whereIn('job_skill', $search)->pluck('id')->toArray();

                            if (!empty ($keyIds)) {
                                $query->orWhereHas('profilekeyskill', function ($q) use ($keyIds) {
                                    $q->whereIn('keyskill', $keyIds);
                                });
                            }
                        });
                    });
                }



                if ($min && $max) {
                    $query->whereHas('profileDetails', function ($q) use ($min, $max) {
                        $q->whereBetween('expect_ctc_lakhs3', [$min, $max]);
                    });

                }


                if ($notice_period) {
                    $query->whereHas('profileNop', function ($q) use ($notice_period) {
                        $q->whereIn('nop_days', $notice_period);
                    });


                }

                if (!is_null($location1)) {

                    $locations = array_map('strtolower', array_map('trim', explode(',', implode(',', $location1))));

                    if (in_array('bengaluru', $locations)) {
                        array_push($locations, 'bangalore');
                    }
                    if (in_array('bangalore', $locations)) {
                        array_push($locations, 'bengaluru');
                    }
                    if (in_array('bangalore/bengaluru', $locations)) {
                        array_push($locations, 'bengaluru', 'bangalore');
                    }


                    if (!in_array('Any', $locations) || !in_array('any', $locations)) {
                        $query->where(function ($query) use ($locations) {
                            foreach ($locations as $location) {
                                if ($location != '') {
                                    $query->orWhereRaw("LOWER(current_city) LIKE ?", [strtolower($location)]);
                                }
                            }
                        });
                    }

                }

                $users = $query->paginate(10);

            } else {


                $query = User::latest();

                if ($search) {

                    $query->where(function ($q) use ($search, $query) {

                        $q->whereHas('profilekeyskill', function ($q) use ($search, $query) {

                            $key = JobSkill::where('job_skill', 'like', '%' . $search . '%')->first();

                            if ($key != null) {

                                $q->where('keyskill', $key->id);


                            } else {

                                $query->WhereHas('profileSummary', function ($q) use ($search) {

                                    $q->where('latestdesg', 'like', '%' . $search . '%');


                                });

                            }

                        })->orWhereHas('profileSummary', function ($q) use ($search) {

                            $q->where('latestdesg', 'like', '%' . $search . '%');


                        });
                    });

                }






                if ($min && $max) {

                    $query->whereHas('profileDetails', function ($q) use ($min, $max) {
                        $q->whereBetween('expect_ctc_lakhs3', [$min, $max]);
                    });

                }


                if ($notice_period) {
                    $query->whereHas('profileNop', function ($q) use ($notice_period, $location1) {
                        $q->whereIn('nop_days', $notice_period);
                    });


                }


                $users = $query->paginate(10);

            }

            // dd($users);



            Session::put('users', $users);// $this->filter2search($filter1_users);

            $search1 = Session::put('search', $search);
            //return dd($search1);

            Session::put('min1', $min);

            Session::put('max1', $max);



            Session::put('notice_period', $notice_period);


            $filter = 1;

            if ($min) {

            } else {
                $min = '';
                $max = '';
            }

            if (isset($location_id)) {
                $location1 = $location_id;
            }

            $location2 = unserialize($search_value->location);
            if (isset($locations)) {
                $locations_vals = $locations;
                Session::put('location1', $locations_vals);

            } else {
                $locations_vals = null;

            }

            return view("company.candidate_listing", compact('store_locations', 'search_skill', 'users', 'search1', 'min', 'max', 'location1', 'notice_period', 'filter', 'locations_vals'));
        } else {

            $exp = $search_value->min_exp;
            $min_exp = (int) $exp;
            $exp1 = $search_value->max_exp;
            $max_exp = (int) $exp1;
            $interview = $search_value->interview_avail;
            $education = $search_value->education;
            $course = $search_value->course;
            $specilation = $search_value->specilation;
            $gender = $search_value->gender;
            $job_type = $search_value->job_type;
            $filter_resume = $search_value->filter_resume;

            $now = \Carbon\Carbon::now();

            // dd($now);

            $today = \Carbon\Carbon::now()->format('Y-m-d');
            $tommorrow = \Carbon\Carbon::now()->addDay(1)->format('Y-m-d');


            // $use = User::where('package_end_date','>',$now)->where('complete','>=',13)->get()->dd();

            $query = User::latest();

            if ($min_exp && $max_exp) {
                $query->whereHas('profileSummary', function ($q) use ($min_exp, $max_exp) {

                    $q->whereBetween('totalexp', [$min_exp, $max_exp]);

                });
            }

            if ($education) {
                $query->whereHas('profileEducation', function ($q) use ($education) {

                    $q->where('degree_title', $education);

                });
            }

            if ($course) {

                $query->whereHas('profileEducation', function ($q) use ($course) {

                    $q->where('course', $course);

                });
            }

            if ($specilation) {
                $query->whereHas('profileEducation', function ($q) use ($specilation) {
                    $q->where('specilation', $specilation);
                });
            }

            if ($job_type) {
                $query->whereHas('profileDetails', function ($q) use ($job_type) {
                    $q->where('work_type', $job_type);
                });
            }

            if ($gender) {
                $query->where('gender_id', $gender);
            }



            if ($interview == '1') {
                //  dd($today);

                // dd($today);
                $query->whereHas('profileDetails', function ($q) use ($today) {
                    $q->where('video_date_from', '<=', $today)->where('video_date_to', '>=', $today)->where('night_telephonic_date_from', '<=', $today)->where('night_telephonic_date_to', '>=', $today);
                    // dd($q);
                });


            } elseif ($interview == '2') {
                // dd('tommorrow');

                // dd($today);
                $query->whereHas('profileDetails', function ($q) use ($tommorrow) {
                    $q->where('video_date_from', '<=', $tommorrow)->where('video_date_to', '>=', $tommorrow)->where('night_telephonic_date_from', '<=', $tommorrow)->where('night_telephonic_date_to', '>=', $tommorrow);
                    // dd($q);
                });

            }

            if ($filter_resume == '1') {

                $query->where('verified', 1);


            }
            if ($filter_resume == '2') {
                $query->where('verified', 0);
            }
            if ($filter_resume == '3') {


                $query->where('package_end_date', '>', $now);

            }


            $users = $query->paginate(10);
            // dd($users);


            Session::put('min_exp', $min_exp);

            //  Session::put('min1', $min );

            Session::put('max_exp', $max_exp);

            Session::put('interview_avail', $interview);

            Session::put('education', $education);

            Session::put('course', $course);

            Session::put('specilation', $specilation);

            Session::put('gender', $gender);

            Session::put('job_type', $job_type);

            Session::put('filter_resume', $filter_resume);

            $filter = 2;


            return view("company.candidate_listing", compact('users', 'min_exp', 'max_exp', 'interview', 'education', 'job_type', 'gender', 'course', 'specilation', 'filter_resume', 'filter'));


        }


    }

    public function verifyemail($id)
    {
        $company = Company::where('id', $id)->first();

        return view('company.email_verify', compact('company'));


    }

    public function companyemailverify($id)
    {

        $company = Company::where('id', $id)->first();

        // return dd($user);
        //  dd($company);

        $token = Str::random(64);


        $data = CompanyVerify::create([
            'company_id' => $company->id,
            'token' => $token,
        ]);

        // return dd($data);

        Mail::send('emails.company.emailVerificationEmail', ['token' => $token, 'company' => $company, 'link' => URL::route('company.verify', $token)], function ($message) use ($company) {
            $message->to($company->email);
            $message->subject('Confirm Your Email');
        });



        return redirect()->back()->with('success', 'Verification mail sent successfully to your email ID.');

    }

    public function verifyAccount($token)
    {

        $verifyCompany = CompanyVerify::where('token', $token)->first();

        // $db_user = new User();

        $db_user = Company::findOrFail(Auth::guard('company')->user()->id);

        // return dd($db_user);

        $message = 'Sorry your email cannot be identified.';

        if (!is_null($verifyCompany)) {


            if ($db_user->email_verified != 1) {
                $db_user->email_verified = 1;
                $db_user->save();

                // return dd('saved');
                $message = "Your email has been verified";
                return view('companyverified')->with('message', $message);
            } else {

                $message = "It looks like you've already verified your email with us, thanks!.";
                return view('companyverified')->with('message', $message);
            }
        }


        return redirect()->route('employer.login')->with('new_message', $message);
    }


    public function gettemplate(Request $request)
    {
        $template = Template::where('id', $request->id)->first();

        return response()->json(['data' => $template]);
    }

    public function emailtemplates()
    {
        $templates = Template::where('company_id', Auth::guard('company')->user()->id);
        $templates_count = $templates->count();
        $templates = $templates->get();
        return view('company.templates.list', compact('templates', 'templates_count'));
    }

    public function gettemplatedata(Request $request)
    {
        $template = Template::where('id', $request->id)->first();

        return response()->json(['result' => $template]);
    }

    public function updatetemplatedata(Request $request)
    {

        // dd($request->all());


        $validator = Validator::make($request->all(), [

            'subject' => 'required',
            'message' => 'required',
            'templatename' => 'required|max:255',
        ], [

            'templatename.required' => 'Template name is required',
            'templatename.unique' => 'Template name already exist.',

            'subject.required' => 'Subject is required',

            'message.required' => 'Description is required'
        ]);

        if ($validator->passes()) {


            $template = Template::where('id', $request->id)->first();

            $template->templatename = $request->templatename;
            $template->subject = $request->subject;
            $template->message = $request->message;
            $template->save();

            return response()->json(array('success' => true, 'status' => 200), 200);

        }

        return response()->json(['errors' => $validator->errors()]);




    }

    public function storetemplatedata(Request $request)
    {

        // dd($request->all());


        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
            'templatename' => [
                'required_without:template',
                'max:255',
                Rule::unique('templates')->where(function ($query) use ($request) {
                    return $query->where('templatename', $request->input('templatename'))
                        ->where('company_id', Auth::guard('company')->user()->id);
                }),
            ],
        ], [
            'templatename.required' => 'Template name is required',
            'templatename.unique' => 'Template name already exist.',
            'subject.required' => 'Subject is required',
            'message.required' => 'Description is required'
        ]);


        if ($validator->passes()) {


            $template = new Template();
            $template->templatename = $request->templatename;
            $template->subject = $request->subject;
            $template->message = $request->message;
            $template->company_id = Auth::guard('company')->user()->id;
            $template->save();

            return response()->json(array('success' => true, 'status' => 200), 200);

        }

        return response()->json(['errors' => $validator->errors()]);




    }

    public function deletetemplate(Request $request)
    {
        $in = Template::where('id', $request->id)->delete();
        return 'ok';
    }




    public function searchlocation(Request $request)
    {
        // dd($request);

        $search = $request->search;

        $search_users = Location::where('location', $search)->distinct()->get(['location']);

        return view("company.candidate_listing", compact('search_users', 'search'));

    }


    public function reportcv(Request $request)
    {
        $request->validate([

            'report' => 'required'

        ]);

        $report = new ReportAbuseCompanyMessage();
        $report->user_id = $request->user_id1;
        $report->company_id = Auth::guard('company')->user()->id;
        $report->report = $request->report;
        $report->save();

        return response()->json(array('success' => true, 'status' => 200), 200);


    }

    public function kycdocuments(Request $request)
    {

        $request->validate([
            'document_type' => 'required',
            // 'selfie' => 'required',
        ]);
        $company_id = Auth::guard('company')->user()->id;



        if ($request->has('selfie')) {
            $base64Image = $request->input('selfie');
            $extension = 'png';
            $filename = 'selfieImage_' . time() . '.' . $extension;
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

            $destinationFolder = public_path('uploads/kyc_documents');
            $destinationPath = $destinationFolder . '/' . $filename;

            if (!File::isDirectory($destinationFolder)) {
                File::makeDirectory($destinationFolder, 0777, true, true);
            }

            file_put_contents($destinationPath, $imageData);
            $selfie = $filename;
            // dd( $selfie );
        } else {
            $selfie = null;
        }

        // Upload PAN Card file
        if ($request->hasFile('pancard')) {
            $pancardFile = $request->file('pancard');
            $pancard = uniqid() . '.' . $pancardFile->getClientOriginalExtension();
            $pancardFile->move(public_path('uploads/kyc_documents'), $pancard);
        } else {
            $pancard = null;
        }

        // Upload Aadhar Card file
        if ($request->hasFile('aadharcard')) {
            $aadharcardFile = $request->file('aadharcard');
            $aadharcard = uniqid() . '.' . $aadharcardFile->getClientOriginalExtension();
            $aadharcardFile->move(public_path('uploads/kyc_documents'), $aadharcard);
        } else {
            $aadharcard = null;
        }

        // Upload other files

        // Sole GST Certificate
        if ($request->hasFile('sole_gstcertificate')) {
            $gstCertificateFile = $request->file('sole_gstcertificate');
            $gstCertificate = uniqid() . '.' . $gstCertificateFile->getClientOriginalExtension();
            $gstCertificateFile->move(public_path('uploads/kyc_documents'), $gstCertificate);
        } else {
            $gstCertificate = null;
        }

        // Sole PAN Card
        if ($request->hasFile('sole_pancard')) {
            $solePancardFile = $request->file('sole_pancard');
            $solePancard = uniqid() . '.' . $solePancardFile->getClientOriginalExtension();
            $solePancardFile->move(public_path('uploads/kyc_documents'), $solePancard);
        } else {
            $solePancard = null;
        }

        // Sole Aadhar Card
        if ($request->hasFile('sole_aadharcard')) {
            $soleAadharcardFile = $request->file('sole_aadharcard');
            $soleAadharcard = uniqid() . '.' . $soleAadharcardFile->getClientOriginalExtension();
            $soleAadharcardFile->move(public_path('uploads/kyc_documents'), $soleAadharcard);
        } else {
            $soleAadharcard = null;
        }


        // Upload Partnership Registration Certificate file
        if ($request->hasFile('partnership_registrationcertificate')) {
            $partnershipRegistrationCertificateFile = $request->file('partnership_registrationcertificate');
            $partnershipRegistrationCertificate = uniqid() . '.' . $partnershipRegistrationCertificateFile->getClientOriginalExtension();
            $partnershipRegistrationCertificateFile->move(public_path('uploads/kyc_documents'), $partnershipRegistrationCertificate);
        } else {
            $partnershipRegistrationCertificate = null;
        }

        // Upload Partnership PAN Card file
        if ($request->hasFile('partnership_pancard')) {
            $partnershipPancardFile = $request->file('partnership_pancard');
            $partnershipPancard = uniqid() . '.' . $partnershipPancardFile->getClientOriginalExtension();
            $partnershipPancardFile->move(public_path('uploads/kyc_documents'), $partnershipPancard);
        } else {
            $partnershipPancard = null;
        }

        // Upload Partnership Aadhar Card file
        if ($request->hasFile('partnership_aadharcard')) {
            $partnershipAadharcardFile = $request->file('partnership_aadharcard');
            $partnershipAadharcard = uniqid() . '.' . $partnershipAadharcardFile->getClientOriginalExtension();
            $partnershipAadharcardFile->move(public_path('uploads/kyc_documents'), $partnershipAadharcard);
        } else {
            $partnershipAadharcard = null;
        }

        // Upload Limited Certificate of Incorporation file
        if ($request->hasFile('limited_certificateofincorporation')) {
            $limitedCertificateofIncorporationFile = $request->file('limited_certificateofincorporation');
            $limitedCertificateofIncorporation = uniqid() . '.' . $limitedCertificateofIncorporationFile->getClientOriginalExtension();
            $limitedCertificateofIncorporationFile->move(public_path('uploads/kyc_documents'), $limitedCertificateofIncorporation);
        } else {
            $limitedCertificateofIncorporation = null;
        }

        // Upload Limited PAN Card (LLP) file
        if ($request->hasFile('limited_pancardllp')) {
            $limitedPancardLLPFile = $request->file('limited_pancardllp');
            $limitedPancardLLP = uniqid() . '.' . $limitedPancardLLPFile->getClientOriginalExtension();
            $limitedPancardLLPFile->move(public_path('uploads/kyc_documents'), $limitedPancardLLP);
        } else {
            $limitedPancardLLP = null;
        }

        // Upload Private Certificate of Incorporation file
        if ($request->hasFile('private_certificateofincorporation')) {
            $privateCertificateofIncorporationFile = $request->file('private_certificateofincorporation');
            $privateCertificateofIncorporation = uniqid() . '.' . $privateCertificateofIncorporationFile->getClientOriginalExtension();
            $privateCertificateofIncorporationFile->move(public_path('uploads/kyc_documents'), $privateCertificateofIncorporation);
        } else {
            $privateCertificateofIncorporation = null;
        }

        // Upload Private PAN Card (Company) file
        if ($request->hasFile('private_pancardcompany')) {
            $privatePancardCompanyFile = $request->file('private_pancardcompany');
            $privatePancardCompany = uniqid() . '.' . $privatePancardCompanyFile->getClientOriginalExtension();
            $privatePancardCompanyFile->move(public_path('uploads/kyc_documents'), $privatePancardCompany);
        } else {
            $privatePancardCompany = null;
        }

        // Upload Private Commencement Certificate file
        if ($request->hasFile('private_commencementcertificate')) {
            $privateCommencementCertificateFile = $request->file('private_commencementcertificate');
            $privateCommencementCertificate = uniqid() . '.' . $privateCommencementCertificateFile->getClientOriginalExtension();
            $privateCommencementCertificateFile->move(public_path('uploads/kyc_documents'), $privateCommencementCertificate);
        } else {
            $privateCommencementCertificate = null;
        }

        // Upload Private Proof of Company file
        if ($request->hasFile('private_proofofcompany')) {
            $privateProofofCompanyFile = $request->file('private_proofofcompany');
            $privateProofofCompany = uniqid() . '.' . $privateProofofCompanyFile->getClientOriginalExtension();
            $privateProofofCompanyFile->move(public_path('uploads/kyc_documents'), $privateProofofCompany);
        } else {
            $privateProofofCompany = null;
        }

        $kyc = KYC::create([
            'company_id' => $company_id,
            'document_type' => $request->document_type,
            'selfie' => $selfie,
            'pancard' => $pancard,
            'aadharcard' => $aadharcard,
            'sole_gstcertificate' => $gstCertificate,
            'sole_pancard' => $solePancard,
            'sole_aadharcard' => $soleAadharcard,
            'partnership_registrationcertificate' => $partnershipRegistrationCertificate,
            'partnership_pancard' => $partnershipPancard,
            'partnership_aadharcard' => $partnershipAadharcard,
            'limited_certificateofincorporation' => $limitedCertificateofIncorporation,
            'limited_pancardllp' => $limitedPancardLLP,
            'private_certificateofincorporation' => $privateCertificateofIncorporation,
            'private_pancardcompany' => $privatePancardCompany,
            'private_commencementcertificate' => $privateCommencementCertificate,
            'private_proofofcompany' => $privateProofofCompany,
            'kyc_verified' => 1,
        ]);

        $company = Company::where('id', $company_id)->first();
        $company->kyc_verified = 1;
        $company->save();



        Mail::to('employer@zeronoticeperiod.com')->send(new KYCEmail($company_id));


        return redirect()->back()->with('message', 'KYC Submitted Successfully');


    }
    public function clearfilter1search(Request $request)
    {
        $min_exp = Session::get('min_exp');
        $max_exp = Session::get('max_exp');
        $interview = Session::get('interview_avail');
        $education = Session::get('education');
        $course = Session::get('course');
        $specilation = Session::get('specilation');
        $gender = Session::get('gender');
        $job_type = Session::get('job_type');
        $filter_resume = Session::get('filter_resume');
        $startDate = Session::get('startDate');
        $endDate = Session::get('endDate');
        $min = Session::get('min1');
        $max = Session::get('max1');
        $notice_period = Session::get('notice_period');
        $s_date = Session::get('s_date');
        $e_date = Session::get('e_date');


        $now = \Carbon\Carbon::now();

        $today = \Carbon\Carbon::now()->format('Y-m-d');

        $tommorrow = \Carbon\Carbon::now()->addDay(1)->format('Y-m-d');


        $search = Session::get('search');
        $location1 = Session::get('location1');


        $query = User::where('hide_show', 0)->latest();

        //filter 1 search value is there 






        //       dd($min_exp);


        //       if ($min_exp && $max_exp || $min_exp == 0) 
//       {
//       $query->whereHas('profileSummary', function($q) use($min_exp,$max_exp){

        //       $q->whereBetween('totalexp', [$min_exp,$max_exp]);

        //       });
//   }


        if ($min && $max) {

            $query->whereHas('profileDetails', function ($q) use ($min, $max) {
                $q->whereBetween('expect_ctc_lakhs', [$min, $max]);
            });

        }


        if ($notice_period) {
            $query->whereHas('profileNop', function ($q) use ($notice_period) {
                $q->whereIn('nop_days', $notice_period);
            });


        }

        if ($education) {
            $query->whereHas('profileEducation', function ($q) use ($education) {
                $q->where('degree_title', $education);
            });
        }

        if ($course) {
            $query->whereHas('profileEducation', function ($q) use ($course) {
                $q->where('course', $course);
            });
        }

        if ($specilation) {
            $query->whereHas('profileEducation', function ($q) use ($specilation) {
                $q->where('specilation', $specilation);
            });
        }

        if ($job_type) {
            $query->whereHas('profileDetails', function ($q) use ($job_type) {
                $q->where('work_type', $job_type);
            });
        }

        if ($gender) {
            $query->where('gender_id', $gender);
        }


        if ($startDate) {
            //dd($startDate);

            // dd($today);
            $query->whereHas('interViews', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
                // dd($q);
            });


        }

        if ($filter_resume == '1') {

            $query->where('verified', 1);


        }
        if ($filter_resume == '2') {
            $query->where('verified', 0);
        }
        if ($filter_resume == '3') {


            $query->where('package_end_date', '>', $now);

        }


        $users = $query->paginate(10);

        $filter = 2;


        if (isset($location1)) {
            $locations_vals = '';

        } else {
            $locations_vals = null;

        }

        if (isset($search)) {
            $search_vals = '';

        } else {
            $search_vals = null;

        }


        Session::forget('search');
        Session::forget('location1');

        // dd($users);

        if ($request->ajax()) {

            $view = view("company.candidate-search-result", compact('users', 'locations_vals', 'search_vals', 'min_exp', 'max', 'min', 'max_exp', 'interview', 'education', 'notice_period', 'job_type', 'gender', 'course', 'specilation', 'filter_resume', 'filter', 's_date', 'e_date'))->render();
            return response()->json(['html' => $view]);


        }



    }


    public function clearfilter2search(Request $request)
    {
        $search = Session::get('search');
        $location1 = Session::get('location1');

        $search_skill = $search;
        $query = User::where('hide_show', 0)->latest();

        if ($search) {

            // Split the search keywords into an array and trim any whitespace
            $search = array_values(array_filter(array_map(function ($value) {
                return strtolower(trim($value));
            }, explode(',', $search)), 'strlen'));
            $query->where(function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    foreach ($search as $keyword) {
                        $query->orWhereHas('profileSummary', function ($q) use ($keyword) {
                            $q->where('latestdesg', 'like', '%' . $keyword . '%');
                        });
                    }
                });

                $q->orWhere(function ($query) use ($search) {
                    $keyIds = JobSkill::whereIn('job_skill', $search)->pluck('id')->toArray();

                    if (!empty ($keyIds)) {
                        $query->orWhereHas('profilekeyskill', function ($q) use ($keyIds) {
                            $q->whereIn('keyskill', $keyIds);
                        });
                    }
                });
            });
        }

        if (!is_null($location1)) {

            $locations = array_map('strtolower', array_map('trim', explode(',', implode(',', $location1))));
            //dd($locations);

            if (in_array('bengaluru', $locations)) {
                array_push($locations, 'bangalore');
            }
            if (in_array('bangalore', $locations)) {
                array_push($locations, 'bengaluru');
            }
            if (in_array('bangalore/bengaluru', $locations)) {
                array_push($locations, 'bengaluru', 'bangalore');
            }


            // dd($locations);

            if (!in_array('Any', $locations)) {
                $query->where(function ($query) use ($locations) {
                    foreach ($locations as $location) {

                        $query->orWhereRaw("LOWER(current_city) LIKE ?", [strtolower($location)]);
                    }
                });
            }

        } else {

            Session::forget('location1');
        }

        $users = $query->paginate(10);


        $filter = 1;


        if (isset($locations)) {
            $locations = array_map('trim', explode(',', implode(',', $location1)));
            $locations = array_map('strtolower', $locations);

            if (in_array('bengaluru', $locations) || in_array('bangalore', $locations) || in_array('bangalore/bengaluru', $locations)) {
                $locations = array_diff($locations, ['bengaluru', 'bangalore', 'bangalore/bengaluru']);
                $locations[] = 'Bangalore/Bengaluru';

            }

            $locations_vals = array_unique($locations);

            Session::put('location1', $locations_vals);

        } else {
            $locations_vals = null;

        }

        if (isset($search)) {
            $search_vals = $search;

        } else {
            $search_vals = null;

        }




        //dd($locations_vals);
        if ($request->ajax()) {

            $view = view('company.candidate-search-result', compact('users', 'location1', 'filter', 'locations_vals', 'search_vals'))->render();
            return response()->json(['html' => $view]);


        }



    }




}

