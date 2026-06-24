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

use App\PostJob;

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



    /**

     * ZNP standalone job-posting pricing page (matches new design HTML).

     *

     * @return \Illuminate\View\View

     */

    public function jobPricingZNP()

    {

        /* Pull active plans from znp_pricing_plans (ordered by display_order).
           Each row drives one card on the pricing page; copy/price/quota/etc.
           are all editable directly in the DB so a change there reflects on
           the public page without a redeploy. */
        $plans = \App\ZnpPricingPlan::active()->ordered()->get();

        /* The current employer's plan (if logged in) — used to highlight
           "Your current plan" on the matching card. */
        $currentPlanId = null;
        if (\Auth::guard('company')->check()) {
            $sub = \Auth::guard('company')->user()->activeZnpSubscription();
            $currentPlanId = $sub ? (int) $sub->plan_id : null;
        }

        return view('znp.job-pricing', compact('plans', 'currentPlanId'));

    }



    /* ════════════════════════════════════════════════════════════════════════
     *  NEW ZNP "Post a Job" page (resources/views/znp/post-job.blade.php)
     *  Route GET  /post-job-page  → postJobZNP()   (show form, prefilled)
     *  Route POST /post-job-page  → storeJobZNP()  (save + redirect to /my-jobs)
     * ════════════════════════════════════════════════════════════════════════ */

    /**
     * Render the new "Post a Job" form.
     *
     * Pre-fill rules (per spec):
     *  - Company-level "Auto-saved" sections (about, industry, headcount, office
     *    address, countries, awards, perks) come from the Company row, which is
     *    updated each time a job is posted via storeJobZNP().
     *  - First-time posters: those columns are empty/null; the existing fields
     *    on the Company row (description, website, industry_id, no_of_employees,
     *    logo) are still used as the seed values.
     *  - Subsequent posts: the columns we wrote on the previous post are used.
     */
    public function postJobZNP()
    {
        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        /* ── ZNP plan gate ──
           Bounce before the user fills out a long form they can't submit.
           Mirrors the gate inside storeJobZNP(); see that method for the
           full rationale + error strings. */
        $sub = $company->activeZnpSubscription();
        if (! $sub) {
            return redirect()->route('employer.job.pricing')
                ->with('error', 'You need an active job-posting plan before you can publish. Choose a plan below.');
        }
        if (! $sub->isLive()) {
            return redirect()->route('employer.job.pricing')
                ->with('error', 'Your ' . $sub->plan_name . ' plan expired on '
                    . optional($sub->expires_at)->format('d M Y') . '. Renew to continue posting.');
        }
        if (! $sub->hasQuotaLeft()) {
            return redirect()->route('employer.job.pricing')
                ->with('error', 'You have used all '
                    . $sub->posts_limit . ' job posts on your '
                    . $sub->plan_name . ' plan. Upgrade or buy another pack to post more.');
        }

        /* Industry options (active + localised). */
        $industries = Industry::lang()->active()->orderBy('industry')->get();

        /* Past jobs for the "Clone from previous job" banner.
           Drafts are excluded — they're usually empty stubs and not useful to clone. */
        $pastJobs = PostJob::where('company_id', $company->id)
            ->where(function ($q) {
                $q->whereNull('is_draft')->orWhere('is_draft', 0);
            })
            ->latest('id')
            ->take(20)
            ->get();

        $cloneJobsPayload = $this->znpBuildCloneJobsPayload($pastJobs);

        /* Decode JSON-typed columns on Company for the view. */
        $companyCountries = $this->znpDecodeJsonColumn($company->countries_presence, ['India']);
        $companyAwards    = $this->znpDecodeJsonColumn($company->awards, []);
        $companyPerks     = $this->znpDecodeJsonColumn($company->perks, []);

        return view('znp.post-job', compact(
            'company',
            'industries',
            'pastJobs',
            'cloneJobsPayload',
            'companyCountries',
            'companyAwards',
            'companyPerks'
        ));
    }

    /**
     * Persist a job submitted from the new ZNP form.
     *
     * Strategy:
     *  - Insert into post_jobs directly (mass-assignment with $guarded=['id']).
     *  - Re-use the existing JobSkillManager via the Skills trait pattern.
     *  - Snapshot the auto-saved sections onto Company so the next post pre-fills.
     */
    public function storeJobZNP(Request $request)
    {
        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        /* Required-field validation (mirrors the HTML form's red asterisks). */
        $isDraft = (int) $request->input('is_draft') === 1;

        /* ── ZNP plan quota gate ──
           Drafts are exempt (no quota consumed for a stub). Real publishes
           require an active subscription with quota left. The plan_id, validity
           window and posts_limit all live on znp_company_subscriptions. If the
           employer has no plan / has exhausted quota / their plan window
           expired, we bounce them to the pricing page with a friendly message. */
        if (! $isDraft) {
            $sub = $company->activeZnpSubscription();

            if (! $sub) {
                return redirect()->route('employer.job.pricing')
                    ->with('error', 'You need an active job-posting plan before you can publish. Choose a plan below.');
            }
            if (! $sub->isLive()) {
                return redirect()->route('employer.job.pricing')
                    ->with('error', 'Your ' . $sub->plan_name . ' plan expired on '
                        . optional($sub->expires_at)->format('d M Y') . '. Renew to continue posting.');
            }
            if (! $sub->hasQuotaLeft()) {
                return redirect()->route('employer.job.pricing')
                    ->with('error', 'You have used all '
                        . $sub->posts_limit . ' job posts on your '
                        . $sub->plan_name . ' plan. Upgrade or buy another pack to post more.');
            }
        }

        $rules = [
            'job_title'         => 'required|max:255',
            'work_mode'         => 'required',
            'job_type'          => 'required',
            'job_shift'         => 'required',
            'min_salary'        => 'required|numeric|min:0',
            'max_salary'        => 'required|numeric|min:0',
            'no_of_openings'    => 'required|integer|min:1',
            'exp_min'           => 'required|numeric|min:0',
            'primary_language'  => 'required',
            'posting_type'      => 'required',
            'keyskills'         => 'required|array|min:1',
            'interview_modes'   => 'required|array|min:1',
            'job_description'   => 'required',
            'job_overview'      => 'required',
            'about_company'     => 'required',
            'website_address'   => 'required',
            'profile_requirements' => 'required|array|min:1',
        ];

        $wm = (string) $request->input('work_mode');
        if (! in_array($wm, ['Remote / WFH', 'Remote/WFH'], true)) {
            $rules['location'] = 'required|array|min:1';
        }

        if ($request->input('posting_type') === 'client') {
            $rules['client_industry'] = 'required';
        }

        if ($isDraft) {
            $rules = ['job_title' => 'required|max:255']; /* drafts only need a title */
        }

        $request->validate($rules);

        /* ── Insert into post_jobs ── */
        $job = new PostJob();
        $job->company_id = $company->id;

        /* Section 1 — Job Basics (labels from new UI → legacy DB values). */
        $job->job_title = $request->input('job_title');
        $job->work_mode = $this->znpNormalizeWorkMode($request->input('work_mode'));
        $job->job_type  = $this->znpNormalizeJobType($request->input('job_type'));
        $job->job_shift = $request->input('job_shift');

        /* Contract details (visible when job_type contains "Contract"). */
        $job->duration            = $request->input('contract_duration');
        $job->contract_day_rate   = $request->input('contract_day_rate');
        $job->contract_extension  = $request->input('contract_extension');

        $job->min_salary = $request->input('min_salary');
        $job->max_salary = $request->input('max_salary');
        $job->compensation_confidential = (int) $request->input('compensation_confidential', 0);
        $job->no_of_openings = $request->input('no_of_openings');

        $job->exp_min = $request->input('exp_min');
        $job->exp_max = $request->input('exp_max');
        /* Keep legacy `experience` populated for back-compat with old listings. */
        $job->experience = $request->input('exp_min') !== null
            ? trim((string) $request->input('exp_min') . ' Years')
            : null;

        $job->primary_language = $request->input('primary_language');
        $job->posting_type     = $request->input('posting_type');
        $job->client_name      = $request->input('client_name');
        $job->client_industry  = $request->input('client_industry');

        $loc = $request->input('location');
        $job->location = $loc ? serialize($loc) : null;
        $job->locality = $request->input('locality');

        /* Interview modes (comma-separated — legacy column). */
        $interviewModes = array_map([$this, 'znpNormalizeInterviewMode'], (array) $request->input('interview_modes', []));
        $job->interview_modes = implode(',', array_filter($interviewModes));

        /* Section 2 — Description (server-side strip of foreign HTML / Word styling). */
        $job->job_description     = $this->znpSanitizeRichHtml($request->input('job_description'));
        $job->job_overview        = $this->znpSanitizeRichHtml($request->input('job_overview'));
        $job->roles_responsibility = null; /* dropped from new UI; column kept nullable */

        /* Section 3 snapshot (also written to companies below for auto-save). */
        $job->about_company    = $request->input('about_company');
        $job->website_address  = $request->input('website_address');
        $job->industry         = $request->input('industry');
        $job->headcount        = $request->input('headcount');
        $job->office_address   = $request->input('office_address');
        $countries             = (array) $request->input('countries_presence', []);
        $job->countries_presence = json_encode(array_values(array_filter($countries, 'strlen')));

        /* Sections 4 / 5 / 6 / 7. */
        $awards  = array_values(array_filter((array) $request->input('awards', []), 'strlen'));
        $perks   = array_values(array_filter((array) $request->input('perks', []), 'strlen'));
        $profile = array_values(array_filter((array) $request->input('profile_requirements', []), 'strlen'));

        $job->awards = json_encode($awards);
        $job->perks  = json_encode($perks);

        /* Questionnaire is built server-side: 2 fixed required + optional video link + customs. */
        $questionnaire = [
            ['key' => 'years_relevant', 'label' => 'How many years of experience do you have relevant to this role?', 'type' => 'number', 'required' => true,  'enabled' => true],
            ['key' => 'why_hire',       'label' => 'Why should we hire you?',                                         'type' => 'text',   'required' => true,  'enabled' => true],
            ['key' => 'video_intro',    'label' => 'Share a link to your video introduction',                         'type' => 'url',    'required' => false, 'enabled' => (int) $request->input('q_video_enabled', 1) === 1],
        ];
        $customQsRaw = $request->input('custom_questions', '[]');
        $customQs = is_string($customQsRaw)
            ? (json_decode($customQsRaw, true) ?: [])
            : (array) $customQsRaw;
        foreach ($customQs as $cq) {
            if (! is_array($cq) || empty($cq['label'])) {
                continue;
            }
            $questionnaire[] = [
                'key'      => 'custom_' . md5($cq['label']),
                'label'    => (string) $cq['label'],
                'type'     => in_array(($cq['type'] ?? 'text'), ['text', 'yesno', 'number'], true) ? $cq['type'] : 'text',
                'required' => true,
                'enabled'  => true,
            ];
        }
        $job->questionnaire = json_encode($questionnaire);

        $job->profile_requirements = json_encode($profile);
        $job->strict_mode = (int) $request->input('strict_mode', 0);
        $job->is_draft    = $isDraft ? 1 : 0;

        $job->save();

        /* Slug + skills + full-text — same as legacy storeFrontJob. */
        $job->slug = \Illuminate\Support\Str::slug($job->job_title, '-') . '-' . $job->id;
        $job->update();

        $this->znpStoreJobSkills($request, $job->id);
        $this->znpUpdateFullTextSearch($job, $request);

        /* ── Snapshot auto-saved fields onto the Company row ── */
        $company->description       = $request->input('about_company');
        $company->website           = $request->input('website_address');
        if ($request->filled('industry_id')) {
            $company->industry_id = $request->input('industry_id');
        }
        $company->no_of_employees   = $request->input('headcount');
        $company->headcount         = $request->input('headcount');
        $company->office_address    = $request->input('office_address');
        $company->countries_presence = json_encode(array_values(array_filter($countries, 'strlen')));
        $company->awards            = json_encode($awards);
        $company->perks             = json_encode($perks);

        /* Logo upload (re-uses existing ImgUploader convention). */
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $fileName = \ImgUploader::UploadImage('company_logos', $image, $company->name, 300, 300, false);
            $company->logo = $fileName;
        }

        $company->save();

        /* Consume one post from the active ZNP subscription on a real publish.
           Drafts are exempt (see the quota gate at the top of this method). */
        if (! $isDraft) {
            $company->consumeOneZnpPost();
        }

        return redirect()->route('my-jobs')->with('message', $isDraft ? 'Draft saved.' : 'Job posted successfully.');
    }

    /* ── ZNP helpers (kept private — used only by postJobZNP/storeJobZNP) ── */

    /**
     * Full job payloads for the clone banner (inline JSON — no extra route).
     */
    private function znpBuildCloneJobsPayload($pastJobs): array
    {
        $payload = [];
        $reverseWorkMode = [
            'Work From Office' => 'Work from Office',
            'Remote/WFH'       => 'Remote / WFH',
        ];
        $reverseJobType = [
            'Full time/Permanent' => 'Full Time / Permanent',
            'Contract To Hire'    => 'Contract to Hire',
        ];

        foreach ($pastJobs as $pj) {
            $loc = [];
            if ($pj->location) {
                $u = @unserialize($pj->location);
                $loc = is_array($u) ? array_values($u) : [(string) $pj->location];
            }

            /* Skills need NAMES (for the Select2 chip label) and IDs (for posting back). */
            $skills = \DB::table('manage_job_skills')
                ->join('job_skills', 'manage_job_skills.job_skill_id', '=', 'job_skills.id')
                ->where('manage_job_skills.job_id', $pj->id)
                ->orderBy('manage_job_skills.id')
                ->get(['job_skills.id', 'job_skills.job_skill as name'])
                ->map(function ($r) {
                    return ['id' => (int) $r->id, 'name' => trim((string) $r->name)];
                })
                ->all();

            $payload[$pj->id] = [
                'id'                       => $pj->id,
                'job_title'                => (string) $pj->job_title,
                'work_mode'                => $reverseWorkMode[$pj->work_mode] ?? $pj->work_mode,
                'job_type'                 => $reverseJobType[$pj->job_type] ?? $pj->job_type,
                'job_shift'                => (string) $pj->job_shift,
                'contract_duration'        => (string) $pj->duration,
                'contract_day_rate'        => $pj->contract_day_rate,
                'contract_extension'       => (string) $pj->contract_extension,
                'min_salary'               => $pj->min_salary,
                'max_salary'               => $pj->max_salary,
                'compensation_confidential'=> (int) $pj->compensation_confidential,
                'no_of_openings'           => $pj->no_of_openings,
                'exp_min'                  => $pj->exp_min,
                'exp_max'                  => $pj->exp_max,
                'primary_language'         => (string) $pj->primary_language,
                'posting_type'             => (string) $pj->posting_type,
                'client_name'              => (string) $pj->client_name,
                'client_industry'          => (string) $pj->client_industry,
                'location'                 => $loc,
                'locality'                 => (string) $pj->locality,
                'keyskills'                => $skills,
                'interview_modes'          => $pj->interview_modes
                    ? array_map(function ($m) {
                        return $m === 'Video Interviews' ? 'Video Interview' : ($m === 'Walkin' ? 'Walk-in' : $m);
                    }, explode(',', $pj->interview_modes))
                    : [],
                'job_description'          => (string) $pj->job_description,
                'job_overview'             => (string) $pj->job_overview,
                'about_company'            => (string) ($pj->about_company ?: ''),
                'website_address'          => (string) $pj->website_address,
                'industry'                 => (string) $pj->industry,
                'headcount'                => (string) $pj->headcount,
                'office_address'           => (string) $pj->office_address,
                'countries_presence'       => $this->znpDecodeJsonColumn($pj->countries_presence, []),
                'awards'                   => $this->znpDecodeJsonColumn($pj->awards, []),
                'perks'                    => $this->znpDecodeJsonColumn($pj->perks, []),
                'profile_requirements'     => $this->znpDecodeJsonColumn($pj->profile_requirements, []),
                'strict_mode'              => (int) $pj->strict_mode,
                'created'                  => optional($pj->created_at)->format('M j, Y') ?? '',
            ];
        }

        return $payload;
    }

    private function znpNormalizeWorkMode(?string $mode): ?string
    {
        $map = [
            'Work from Office' => 'Work From Office',
            'Remote / WFH'     => 'Remote/WFH',
        ];
        return $map[$mode] ?? $mode;
    }

    private function znpNormalizeJobType(?string $type): ?string
    {
        $map = [
            'Full Time / Permanent' => 'Full time/Permanent',
            'Contract to Hire'      => 'Contract To Hire',
            'Part Time'             => 'Part Time',
        ];
        return $map[$type] ?? $type;
    }

    private function znpNormalizeInterviewMode(string $mode): string
    {
        $map = [
            'Video Interview' => 'Video Interviews',
            'Walk-in'         => 'Walkin',
        ];
        return $map[$mode] ?? $mode;
    }

    /**
     * Server-side defense for pasted-from-Word HTML.
     *
     * Even with the client-side paste sanitizer, we never trust the
     * submitted HTML. We keep only a tiny whitelist (formatting tags +
     * lists) and strip every attribute. Anything outside the whitelist
     * is dropped entirely.
     */
    private function znpSanitizeRichHtml(?string $html): ?string
    {
        if ($html === null || $html === '') {
            return $html;
        }

        /* strip_tags handles the whitelist; we then strip every attribute via regex.
           The whitelist mirrors what the client-side _sanitizeRich keeps. */
        $allowed = '<p><br><strong><b><em><i><u><ul><ol><li>';
        $clean   = strip_tags($html, $allowed);

        /* Remove any remaining attributes on whitelisted tags (e.g. <p style="…">). */
        $clean = preg_replace('#<([a-z]+)\b[^>]*>#i', '<$1>', $clean) ?? $clean;

        /* Collapse &nbsp; and runs of whitespace introduced by Word/Google Docs. */
        $clean = str_replace('&nbsp;', ' ', $clean);
        $clean = preg_replace('/\s{2,}/u', ' ', $clean) ?? $clean;
        $clean = preg_replace('#<p>\s*</p>#i', '', $clean) ?? $clean;

        return trim($clean);
    }

    /* ── Reverse maps (DB value → UI label) — used by editJobZNP ── */

    private function znpDenormalizeWorkMode(?string $mode): ?string
    {
        $map = [
            'Work From Office' => 'Work from Office',
            'Remote/WFH'       => 'Remote / WFH',
        ];
        return $map[$mode] ?? $mode;
    }

    private function znpDenormalizeJobType(?string $type): ?string
    {
        $map = [
            'Full time/Permanent' => 'Full Time / Permanent',
            'Contract To Hire'    => 'Contract to Hire',
        ];
        return $map[$type] ?? $type;
    }

    private function znpDenormalizeInterviewMode(string $mode): string
    {
        $map = [
            'Video Interviews' => 'Video Interview',
            'Walkin'           => 'Walk-in',
        ];
        return $map[$mode] ?? $mode;
    }

    /**
     * Build enriched applicant rows + metrics + stage counts for the ZNP Applicants page.
     */
    private function znpBuildApplicantsPageData(PostJob $job, Company $company): array
    {
        $jobSkillRows = \DB::table('manage_job_skills')
            ->join('job_skills', 'manage_job_skills.job_skill_id', '=', 'job_skills.id')
            ->where('manage_job_skills.job_id', $job->id)
            ->orderBy('manage_job_skills.id')
            ->get(['job_skills.id', 'job_skills.job_skill as name']);

        $jobSkillNamesLower = $jobSkillRows
            ->map(function ($r) {
                return strtolower(trim((string) $r->name));
            })
            ->filter()
            ->values()
            ->all();

        $jobSkillCount = max(count($jobSkillNamesLower), 1);

        $applications = JobApply::with('user')
            ->where('job_id', $job->id)
            ->orderByDesc('created_at')
            ->get();

        $userIds = $applications->pluck('user_id')->filter()->unique()->values()->all();
        $appIds  = $applications->pluck('id')->all();

        $shortlistedSet = [];
        if (! empty($userIds)) {
            $shortlistedSet = FavouriteApplicant::where('job_id', $job->id)
                ->where('company_id', $company->id)
                ->whereIn('user_id', $userIds)
                ->pluck('user_id')
                ->flip()
                ->all();
        }

        $today = \Carbon\Carbon::now()->format('Y-m-d');
        $interviewSet = [];
        if (! empty($userIds)) {
            $interviewSet = \App\Interview::whereIn('user_id', $userIds)
                ->where('date', '>=', $today)
                ->pluck('user_id')
                ->flip()
                ->all();
        }

        $notesByApp = [];
        $feedbacksByApp = [];
        $reportsByApp = [];
        $eventsByApp = [];
        $emailCountsByApp = [];

        if (! empty($appIds)) {
            $notesByApp = \App\ApplicantNote::whereIn('job_apply_id', $appIds)
                ->get()
                ->keyBy('job_apply_id');

            $feedbacksByApp = \App\ApplicantFeedback::whereIn('job_apply_id', $appIds)
                ->orderByDesc('created_at')
                ->get()
                ->groupBy('job_apply_id')
                ->map(function ($group) {
                    return $group->first();
                });

            $reportsByApp = \App\ApplicantReport::whereIn('job_apply_id', $appIds)
                ->orderByDesc('created_at')
                ->get()
                ->groupBy('job_apply_id')
                ->map(function ($group) {
                    return $group->first();
                });

            $eventsByApp = \App\ApplicantEvent::whereIn('job_apply_id', $appIds)
                ->orderBy('created_at')
                ->get()
                ->groupBy('job_apply_id');

            $emailCountsByApp = \App\ApplicantEmail::whereIn('job_apply_id', $appIds)
                ->where('status', 'sent')
                ->select('job_apply_id', \DB::raw('count(*) as total'))
                ->groupBy('job_apply_id')
                ->pluck('total', 'job_apply_id')
                ->all();
        }

        $applicants = [];
        foreach ($applications as $application) {
            $user = $application->user;
            if (! $user) {
                continue;
            }

            $applicants[] = $this->znpEnrichApplicantRow(
                $application,
                $user,
                $job,
                $jobSkillNamesLower,
                $jobSkillCount,
                isset($shortlistedSet[$user->id]),
                isset($interviewSet[$user->id]),
                $notesByApp[$application->id] ?? null,
                $feedbacksByApp[$application->id] ?? null,
                $reportsByApp[$application->id] ?? null,
                $eventsByApp[$application->id] ?? collect(),
                (int) ($emailCountsByApp[$application->id] ?? 0)
            );
        }

        return [
            'applicants' => $applicants,
            'metrics'    => $this->znpBuildApplicantMetrics($applicants, $job),
            'stages'     => $this->znpBuildApplicantStageCounts($applicants),
        ];
    }

    private function znpEnrichApplicantRow(
        JobApply $application,
        $user,
        PostJob $job,
        array $jobSkillNamesLower,
        int $jobSkillCount,
        bool $isShortlisted,
        bool $hasInterview,
        $note = null,
        $feedback = null,
        $report = null,
        $events = null,
        int $emailCount = 0
    ): array {
        $summary  = \App\ProfileSummary::where('user_id', $user->id)->first();
        $details  = ProfileDetails::where('user_id', $user->id)->first();
        $nop      = \App\ProfileNop::where('user_id', $user->id)->first();
        $educations = \App\ProfileEducation::where('user_id', $user->id)->get();

        $experienceRaw = $summary->totalexp ?? '';
        $expYears = 0;
        if (preg_match('/(\d+(?:\.\d+)?)/', (string) $experienceRaw, $m)) {
            $expYears = (int) round((float) $m[1]);
        }

        $currCtc = $details->expect_ctc_lakhs ?? null;
        $expCtc  = $details->expect_ctc_lakhs3 ?? $details->expect_ctc_lakhs ?? null;
        $expCtcNum = is_numeric($expCtc) ? (float) $expCtc : (preg_match('/(\d+)/', (string) $expCtc, $em) ? (float) $em[1] : 0);

        [$noticeLabel, $noticeSlug, $noticeVerified] = $this->znpApplicantNoticeMeta($nop);

        $workType = trim((string) ($details->work_type ?? ''));
        $modeSlug = $this->znpApplicantWorkModeSlug($workType, $details->candidate_wfh ?? null);
        $modeLabel = $workType !== '' ? $workType : ($modeSlug === 'remote' ? 'Remote / WFH' : ucfirst($modeSlug));

        $isContract = stripos($workType, 'contract') !== false
            || stripos((string) ($details->contract_type ?? ''), 'contract') !== false;

        $storedStage = trim((string) ($application->stage ?? ''));
        if ($storedStage !== '' && in_array($storedStage, ['rejected', 'offer', 'resumedb', 'shortlisted'], true)) {
            $stage = $storedStage;
        } elseif ($hasInterview) {
            $stage = 'interview';
        } elseif ($isShortlisted || $storedStage === 'shortlisted') {
            $stage = 'shortlisted';
        } else {
            $stage = 'new';
        }
        if ($isContract && $stage === 'new') {
            $stage = 'contractor';
        }

        $userSkills = \App\KeySkill::where('user_id', $user->id)->take(12)->get();
        $skills = [];
        $matched = 0;
        foreach ($userSkills as $ks) {
            $skillRow = JobSkill::find($ks->keyskill);
            $name = trim((string) ($skillRow->job_skill ?? ''));
            if ($name === '') {
                continue;
            }
            $isMatch = in_array(strtolower($name), $jobSkillNamesLower, true);
            if ($isMatch) {
                $matched++;
            }
            $skills[] = ['name' => $name, 'match' => $isMatch];
        }

        $fit = (int) round(($matched / $jobSkillCount) * 100);
        $fitClass = $fit >= 80 ? 'fs-high' : ($fit >= 60 ? 'fs-mid' : 'fs-low');
        $cardClass = $isContract ? 'contract' : ($fit >= 85 ? 'top' : ($fit >= 70 ? 'good' : 'watch'));

        $courseName = '';
        $collegeName = '';
        $highEducation = null;
        foreach ($educations as $education) {
            $highEducation = \App\Education::where('id', $education->degree_title)
                ->where(function ($q) {
                    $q->where('high_value', 1)->orWhere('high_value', 2)->orWhere('high_value', 3);
                })
                ->first();
            if ($highEducation) {
                break;
            }
        }
        if ($highEducation) {
            $final = \App\ProfileEducation::where('user_id', $user->id)
                ->where('degree_title', $highEducation->id)
                ->first();
            if ($final) {
                $institute = \App\Degree::where('id', $final->organization)->first();
                $course    = \App\Course::where('id', $final->course)->first();
                $courseName  = $course->course ?? '';
                $collegeName = $institute->educations ?? '';
            }
        }

        $questionnaire = $this->znpDecodeJsonColumn($application->questionnaire_answers, []);

        $first = trim((string) ($user->first_name ?? ''));
        $last  = trim((string) ($user->last_name ?? ''));
        $displayName = trim($first . ' ' . $last) ?: trim((string) ($user->name ?? 'Candidate'));
        $initials = '';
        if ($first !== '') {
            $initials .= strtoupper(mb_substr($first, 0, 1));
        }
        if ($last !== '') {
            $initials .= strtoupper(mb_substr($last, 0, 1));
        }
        $initials = $initials ?: 'CN';

        $locationCity = trim((string) ($user->current_city ?? ''));
        $locationSlug = $this->znpApplicantLocationSlug($locationCity);

        $activity = $this->znpBuildApplicantActivity($application, $events, $isShortlisted, $hasInterview);

        $verdictLabels = [
            'sy' => 'Strong Yes',
            'y'  => 'Yes',
            'm'  => 'Maybe',
            'n'  => 'No',
            'sn' => 'Strong No',
        ];
        $offerLabels = [
            'offered' => 'Offered',
            'joined'  => 'Joined',
            'dropout' => 'Offer Dropout',
        ];

        $noteData = null;
        if ($note) {
            $noteData = [
                'body'       => $note->body,
                'updated_at' => $note->updated_at ? $note->updated_at->format('M j, Y g:i A') : '—',
            ];
        }

        $feedbackData = null;
        if ($feedback) {
            $feedbackData = [
                'verdict'       => $feedback->verdict,
                'verdict_label' => $verdictLabels[$feedback->verdict] ?? $feedback->verdict,
                'comments'      => $feedback->comments,
                'created_at'    => $feedback->created_at ? $feedback->created_at->format('M j, Y g:i A') : '—',
            ];
        }

        $offerStatus = $application->offer_status;
        $offerLabel = $offerStatus ? ($offerLabels[$offerStatus] ?? $offerStatus) : null;
        $isReported = (bool) ($application->reported_at || $report);

        $withinBudget = $job->max_salary && $expCtcNum > 0
            ? $expCtcNum <= (float) $job->max_salary
            : true;

        return [
            'application_id'   => $application->id,
            'user_id'          => $user->id,
            'slug'             => 'u' . $user->id,
            'stage'            => $stage,
            'card_class'       => $cardClass,
            'fit'              => $fit,
            'fit_class'        => $fitClass,
            'initials'         => $initials,
            'display_name'     => $displayName,
            'candidate_email'   => $user->email ?? '',
            'photo_url'        => ! empty($user->image) ? asset('user_images/' . $user->image) : null,
            'current_role'     => trim((string) ($summary->latestdesg ?? '')),
            'current_company'  => trim((string) ($summary->latestcom ?? '')),
            'location_display' => $locationCity,
            'location_slug'    => $locationSlug,
            'badges'           => array_values(array_filter([
                $noticeVerified ? 'Notice Verified' : null,
                $isContract ? 'Open to Contract' : null,
            ])),
            'exp_years'        => $expYears,
            'exp_label'        => $expYears > 0 ? $expYears . ' yrs' : ($experienceRaw ?: '—'),
            'curr_ctc'         => $currCtc !== null && $currCtc !== '' ? '₹' . $currCtc . ' LPA' : '—',
            'exp_ctc'          => $expCtcNum > 0 ? '₹' . rtrim(rtrim(number_format($expCtcNum, 1), '0'), '.') . ' LPA' : '—',
            'exp_ctc_num'      => $expCtcNum,
            'notice_label'     => $noticeLabel,
            'notice_slug'      => $noticeSlug,
            'pref_mode'        => $modeLabel,
            'mode_slug'        => $modeSlug,
            'education'        => $courseName ?: '—',
            'college'          => $collegeName ?: '—',
            'skills'           => $skills,
            'questionnaire'    => is_array($questionnaire) ? $questionnaire : [],
            'applied_label'    => $application->created_at ? $application->created_at->diffForHumans(null, true) . ' ago' : 'Recently',
            'applied_ref'      => '#' . $application->id,
            'activity'         => $activity,
            'has_interview'    => $hasInterview,
            'is_shortlisted'   => $isShortlisted || $stage === 'shortlisted',
            'is_contract'      => $isContract,
            'type_slug'        => $isContract ? 'contract' : 'fulltime',
            'within_budget'    => $withinBudget,
            'verified'         => (bool) $noticeVerified,
            'data_exp'         => $expYears,
            'data_ctc'         => (int) round($expCtcNum),
            'data_fit'         => $fit,
            'note'             => $noteData,
            'feedback'         => $feedbackData,
            'offer_status'     => $offerStatus,
            'offer_label'      => $offerLabel,
            'is_reported'      => $isReported,
            'rejected_reason'  => $application->rejected_reason,
            'profile_url'      => route('applicant.profile', $application->id),
            'has_resume'       => ! empty($user->resume),
            'email_count'      => $emailCount,
            'has_emailed'      => $emailCount > 0,
        ];
    }

    private function znpBuildApplicantActivity(
        JobApply $application,
        $events,
        bool $isShortlisted,
        bool $hasInterview
    ): array {
        $eventList = $events instanceof \Illuminate\Support\Collection ? $events : collect($events ?: []);

        if ($eventList->isNotEmpty()) {
            $order = [
                'applied'       => 10,
                'viewed'        => 20,
                'downloaded'    => 30,
                'emailed'       => 35,
                'note'          => 40,
                'feedback'      => 50,
                'reported'      => 60,
                'shortlisted'   => 70,
                'unshortlisted' => 71,
                'offer'         => 80,
                'rejected'      => 90,
            ];

            $eventsByType = [];
            foreach ($eventList as $event) {
                if ($application->stage === 'rejected' && $event->type === 'offer') {
                    continue;
                }
                if ($application->stage === 'offer' && $event->type === 'rejected') {
                    continue;
                }
                $eventsByType[$event->type] = $event;
            }

            uasort($eventsByType, function ($a, $b) use ($order) {
                $ao = $order[$a->type] ?? 999;
                $bo = $order[$b->type] ?? 999;

                return $ao <=> $bo;
            });

            $compactEvents = array_slice(array_values($eventsByType), 0, 7);
            $activity = [];
            $lastIndex = count($compactEvents) - 1;
            foreach ($compactEvents as $i => $event) {
                $activity[] = [
                    'label' => $event->label,
                    'date'  => $event->created_at ? $event->created_at->format('M j') : '—',
                    'state' => $i === $lastIndex ? 'now' : 'done',
                ];
            }

            return $activity;
        }

        $activity = [['label' => 'Applied', 'date' => $application->created_at ? $application->created_at->format('M j') : '—', 'state' => 'done']];
        if ($isShortlisted) {
            $activity[] = ['label' => 'Shortlisted', 'date' => '—', 'state' => 'done'];
        }
        if ($hasInterview) {
            $activity[] = ['label' => 'Interview', 'date' => 'Scheduled', 'state' => 'now'];
        }

        return $activity;
    }

    private function znpApplicantNoticeMeta(?\App\ProfileNop $nop): array
    {
        if (! $nop) {
            return ['—', 'immediate', false];
        }

        $todayDate = \Carbon\Carbon::now()->format('Y-m-d');
        $noticed = $nop->nop_days ?? null;

        if ((int) $noticed === 1) {
            return ['0 days', 'immediate', true];
        }

        if ((int) $noticed === 2 && ! empty($nop->last_working_day)) {
            $datetime1 = strtotime($todayDate);
            $datetime2 = strtotime($nop->last_working_day);
            if ($datetime1 !== false && $datetime2 !== false && $datetime1 < $datetime2) {
                $days = (int) (($datetime2 - $datetime1) / 86400);
                return [$days . ' days (Serving)', 'serving', true];
            }
            return ['0 days', 'immediate', true];
        }

        if ((int) $noticed === 3) {
            return ['Buyable', 'immediate', true];
        }

        return ['Not under notice', 'immediate', false];
    }

    private function znpApplicantWorkModeSlug(?string $workType, $wfh = null): string
    {
        $hay = strtolower(trim((string) $workType . ' ' . (string) $wfh));
        if (strpos($hay, 'remote') !== false || strpos($hay, 'wfh') !== false) {
            return 'remote';
        }
        if (strpos($hay, 'hybrid') !== false) {
            return 'hybrid';
        }
        return 'wfo';
    }

    private function znpApplicantLocationSlug(string $city): string
    {
        $c = strtolower(trim($city));
        if ($c === '') {
            return 'other';
        }
        $map = [
            'mumbai'     => ['mumbai', 'andheri', 'powai', 'malad', 'bandra'],
            'pune'       => ['pune', 'hinjewadi'],
            'bengaluru'  => ['bengaluru', 'bangalore', 'whitefield'],
            'hyderabad'  => ['hyderabad'],
            'delhi'      => ['delhi', 'ncr', 'gurgaon', 'noida'],
            'chennai'    => ['chennai'],
        ];
        foreach ($map as $slug => $needles) {
            foreach ($needles as $needle) {
                if (strpos($c, $needle) !== false) {
                    return $slug;
                }
            }
        }
        return 'other';
    }

    private function znpBuildApplicantMetrics(array $applicants, PostJob $job): array
    {
        $total = count($applicants);
        $within = 0;
        $over = 0;
        $mumbai = 0;
        $otherCities = 0;
        $expInRange = 0;
        $expSenior = 0;
        $verified = 0;
        $emailed = 0;

        $jobExpMin = $job->exp_min !== null ? (float) $job->exp_min : 0;
        $jobExpMax = $job->exp_max !== null ? (float) $job->exp_max : 999;

        foreach ($applicants as $a) {
            if ($a['within_budget']) {
                $within++;
            } else {
                $over++;
            }
            if ($a['location_slug'] === 'mumbai') {
                $mumbai++;
            } else {
                $otherCities++;
            }
            if ($a['data_exp'] >= $jobExpMin && $a['data_exp'] <= $jobExpMax) {
                $expInRange++;
            } elseif ($a['data_exp'] > $jobExpMax) {
                $expSenior++;
            }
            if ($a['verified']) {
                $verified++;
            }
            if (! empty($a['has_emailed'])) {
                $emailed++;
            }
        }

        return [
            'total'       => $total,
            'resumedb'    => 0,
            'within'      => $within,
            'over'        => $over,
            'mumbai'      => $mumbai,
            'other_cities'=> $otherCities,
            'exp_in_range'=> $expInRange,
            'exp_senior'  => $expSenior,
            'verified'    => $verified,
            'emailed'     => $emailed,
            'shortlisted' => collect($applicants)->where('is_shortlisted', true)->count(),
            'interview'   => collect($applicants)->where('has_interview', true)->count(),
        ];
    }

    private function znpBuildApplicantStageCounts(array $applicants): array
    {
        $counts = [
            'all'         => count($applicants),
            'new'         => 0,
            'shortlisted' => 0,
            'interview'   => 0,
            'offer'       => 0,
            'contractor'  => 0,
            'resumedb'    => 0,
            'rejected'    => 0,
        ];

        foreach ($applicants as $a) {
            $s = $a['stage'] ?? 'new';
            if (isset($counts[$s])) {
                $counts[$s]++;
            }
        }

        return $counts;
    }

    /* ════════════════════════════════════════════════════════════════════════
     *  ZNP "Edit a Job" page (mirrors postJobZNP, drives the same blade)
     *  Route GET  /post-job-page/{id}/edit  → editJobZNP()
     *  Route POST /post-job-page/{id}/edit  → updateJobZNP()
     * ════════════════════════════════════════════════════════════════════════ */

    /**
     * Render the new "Edit Job" form.
     *
     * Strategy: build a complete form-input array from the existing job and
     * flash it as "old input". This makes every `old('field', $default)` call
     * in the shared blade resolve to the job's saved value with zero extra
     * branching. Validation-error redirects (`->withInput()`) override this
     * naturally on subsequent renders.
     */
    public function editJobZNP($id)
    {
        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        $job = PostJob::where('id', $id)
            ->where('company_id', $company->id)
            ->firstOrFail();

        $industries = Industry::lang()->active()->orderBy('industry')->get();

        /* Decode existing JSON snapshots so we can fall back to them. */
        $jobCountries = $this->znpDecodeJsonColumn($job->countries_presence, ['India']);
        $jobAwards    = $this->znpDecodeJsonColumn($job->awards, []);
        $jobPerks     = $this->znpDecodeJsonColumn($job->perks, []);
        $jobProfile   = $this->znpDecodeJsonColumn($job->profile_requirements, []);
        $jobQuestionnaire = $this->znpDecodeJsonColumn($job->questionnaire, []);

        /* Re-hydrate location from PHP-serialized blob. */
        $locArray = [];
        if ($job->location) {
            $u = @unserialize($job->location);
            $locArray = is_array($u) ? array_values($u) : [(string) $job->location];
        }

        /* Skills with names — drives the <option> render and the Select2 chip. */
        $prefillSkills = \DB::table('manage_job_skills')
            ->join('job_skills', 'manage_job_skills.job_skill_id', '=', 'job_skills.id')
            ->where('manage_job_skills.job_id', $job->id)
            ->orderBy('manage_job_skills.id')
            ->get(['job_skills.id', 'job_skills.job_skill as name'])
            ->map(function ($r) {
                return ['id' => (int) $r->id, 'name' => trim((string) $r->name)];
            })
            ->all();

        /* Extract video-question toggle + custom questions from questionnaire JSON. */
        $qVideoEnabled = 1;
        $customQs = [];
        foreach ($jobQuestionnaire as $q) {
            if (! is_array($q)) {
                continue;
            }
            $key = $q['key'] ?? '';
            if ($key === 'video_intro') {
                $qVideoEnabled = (int) ($q['enabled'] ?? 1);
            } elseif (strpos($key, 'custom_') === 0) {
                $customQs[] = [
                    'label' => (string) ($q['label'] ?? ''),
                    'type'  => (string) ($q['type'] ?? 'text'),
                ];
            }
        }

        $interviewModes = array_filter(array_map('trim', explode(',', (string) $job->interview_modes)));
        $interviewModesUi = array_map([$this, 'znpDenormalizeInterviewMode'], $interviewModes);

        /* Strip trailing .00 from decimal columns so the edit form shows "5" not "5.00". */
        $fmtDecimal = function ($v) {
            if ($v === null || $v === '') return null;
            return (string) (float) $v;
        };

        /* The complete form-input snapshot — keys MUST match form field names. */
        $formInput = [
            'job_title'          => $job->job_title,
            'work_mode'          => $this->znpDenormalizeWorkMode($job->work_mode),
            'job_type'           => $this->znpDenormalizeJobType($job->job_type),
            'job_shift'          => $job->job_shift,
            'contract_duration'  => $job->duration,
            'contract_day_rate'  => $job->contract_day_rate,
            'contract_extension' => $job->contract_extension,
            'min_salary'         => $job->min_salary,
            'max_salary'         => $job->max_salary,
            'compensation_confidential' => (int) $job->compensation_confidential,
            'no_of_openings'     => $job->no_of_openings,
            'exp_min'            => $fmtDecimal($job->exp_min),
            'exp_max'            => $fmtDecimal($job->exp_max),
            'primary_language'   => $job->primary_language,
            'posting_type'       => $job->posting_type,
            'client_name'        => $job->client_name,
            'client_industry'    => $job->client_industry,
            'location'           => $locArray,
            'locality'           => $job->locality,
            'interview_modes'    => $interviewModesUi,
            'keyskills'          => array_map(function ($s) { return $s['id']; }, $prefillSkills),
            'job_description'    => $job->job_description,
            'job_overview'       => $job->job_overview,
            /* Company snapshot — these are on both job and company; prefer job's. */
            'about_company'      => $job->about_company ?? strip_tags($company->description ?? ''),
            'website_address'    => $job->website_address ?? $company->website,
            'industry_id'        => $company->industry_id,
            'industry'           => $job->industry,
            'headcount'          => $job->headcount ?? $company->headcount ?? $company->no_of_employees,
            'office_address'     => $job->office_address ?? $company->office_address,
            'countries_presence' => $jobCountries,
            'awards'             => $jobAwards,
            'perks'              => $jobPerks,
            'profile_requirements' => $jobProfile,
            'strict_mode'        => (int) $job->strict_mode,
            'q_video_enabled'    => $qVideoEnabled,
            'custom_questions'   => json_encode($customQs),
        ];

        session()->flashInput($formInput);

        /* These three feed the existing $companyCountries/Awards/Perks fallbacks; in edit
           mode they're irrelevant because flashed input always wins, but the blade still
           references them so keep the contract. */
        $companyCountries = $jobCountries;
        $companyAwards    = $jobAwards;
        $companyPerks     = $jobPerks;

        return view('znp.post-job', [
            'mode'              => 'edit',
            'job'               => $job,
            'company'           => $company,
            'industries'        => $industries,
            'pastJobs'          => collect(), // clone banner hidden in edit mode
            'cloneJobsPayload'  => [],
            'companyCountries'  => $companyCountries,
            'companyAwards'     => $companyAwards,
            'companyPerks'      => $companyPerks,
            'prefillSkills'     => $prefillSkills,
        ]);
    }

    /**
     * ZNP Applicants page — visual-only phase 1.
     * Renders real applicants for a job the logged-in company owns.
     * Action buttons are stubbed in the blade (toast only).
     */
    public function applicantsZNP($id)
    {
        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        $job = PostJob::where('id', $id)
            ->where('company_id', $company->id)
            ->firstOrFail();

        $pageData = $this->znpBuildApplicantsPageData($job, $company);

        return view('znp.applicants', array_merge([
            'job'     => $job,
            'company' => $company,
        ], $pageData));
    }

    /**
     * Handle the edit form submission. Mirrors storeJobZNP but updates an
     * existing row and (optionally) refreshes the company auto-save snapshot.
     */
    public function updateJobZNP(Request $request, $id)
    {
        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        $job = PostJob::where('id', $id)
            ->where('company_id', $company->id)
            ->firstOrFail();

        /* Same validation rules as create. Drafts are not supported on edit. */
        $rules = [
            'job_title'         => 'required|max:255',
            'work_mode'         => 'required',
            'job_type'          => 'required',
            'job_shift'         => 'required',
            'min_salary'        => 'required|numeric|min:0',
            'max_salary'        => 'required|numeric|min:0',
            'no_of_openings'    => 'required|integer|min:1',
            'exp_min'           => 'required|numeric|min:0',
            'primary_language'  => 'required',
            'posting_type'      => 'required',
            'keyskills'         => 'required|array|min:1',
            'interview_modes'   => 'required|array|min:1',
            'job_description'   => 'required',
            'job_overview'      => 'required',
            'about_company'     => 'required',
            'website_address'   => 'required',
            'profile_requirements' => 'required|array|min:1',
        ];

        $wm = (string) $request->input('work_mode');
        if (! in_array($wm, ['Remote / WFH', 'Remote/WFH'], true)) {
            $rules['location'] = 'required|array|min:1';
        }

        if ($request->input('posting_type') === 'client') {
            $rules['client_industry'] = 'required';
        }

        $request->validate($rules);

        /* ── Update post_jobs row ── */
        $job->job_title = $request->input('job_title');
        $job->work_mode = $this->znpNormalizeWorkMode($request->input('work_mode'));
        $job->job_type  = $this->znpNormalizeJobType($request->input('job_type'));
        $job->job_shift = $request->input('job_shift');

        $job->duration            = $request->input('contract_duration');
        $job->contract_day_rate   = $request->input('contract_day_rate');
        $job->contract_extension  = $request->input('contract_extension');

        $job->min_salary = $request->input('min_salary');
        $job->max_salary = $request->input('max_salary');
        $job->compensation_confidential = (int) $request->input('compensation_confidential', 0);
        $job->no_of_openings = $request->input('no_of_openings');

        $job->exp_min = $request->input('exp_min');
        $job->exp_max = $request->input('exp_max');
        $job->experience = $request->input('exp_min') !== null
            ? trim((string) $request->input('exp_min') . ' Years')
            : null;

        $job->primary_language = $request->input('primary_language');
        $job->posting_type     = $request->input('posting_type');
        $job->client_name      = $request->input('client_name');
        $job->client_industry  = $request->input('client_industry');

        $loc = $request->input('location');
        $job->location = $loc ? serialize($loc) : null;
        $job->locality = $request->input('locality');

        $interviewModes = array_map([$this, 'znpNormalizeInterviewMode'], (array) $request->input('interview_modes', []));
        $job->interview_modes = implode(',', array_filter($interviewModes));

        $job->job_description      = $this->znpSanitizeRichHtml($request->input('job_description'));
        $job->job_overview         = $this->znpSanitizeRichHtml($request->input('job_overview'));
        $job->roles_responsibility = null;

        $job->about_company    = $request->input('about_company');
        $job->website_address  = $request->input('website_address');
        $job->industry         = $request->input('industry');
        $job->headcount        = $request->input('headcount');
        $job->office_address   = $request->input('office_address');
        $countries             = (array) $request->input('countries_presence', []);
        $job->countries_presence = json_encode(array_values(array_filter($countries, 'strlen')));

        $awards  = array_values(array_filter((array) $request->input('awards', []), 'strlen'));
        $perks   = array_values(array_filter((array) $request->input('perks', []), 'strlen'));
        $profile = array_values(array_filter((array) $request->input('profile_requirements', []), 'strlen'));

        $job->awards = json_encode($awards);
        $job->perks  = json_encode($perks);

        $questionnaire = [
            ['key' => 'years_relevant', 'label' => 'How many years of experience do you have relevant to this role?', 'type' => 'number', 'required' => true,  'enabled' => true],
            ['key' => 'why_hire',       'label' => 'Why should we hire you?',                                         'type' => 'text',   'required' => true,  'enabled' => true],
            ['key' => 'video_intro',    'label' => 'Share a link to your video introduction',                         'type' => 'url',    'required' => false, 'enabled' => (int) $request->input('q_video_enabled', 1) === 1],
        ];
        $customQsRaw = $request->input('custom_questions', '[]');
        $customQs = is_string($customQsRaw)
            ? (json_decode($customQsRaw, true) ?: [])
            : (array) $customQsRaw;
        foreach ($customQs as $cq) {
            if (! is_array($cq) || empty($cq['label'])) {
                continue;
            }
            $questionnaire[] = [
                'key'      => 'custom_' . md5($cq['label']),
                'label'    => (string) $cq['label'],
                'type'     => in_array(($cq['type'] ?? 'text'), ['text', 'yesno', 'number'], true) ? $cq['type'] : 'text',
                'required' => true,
                'enabled'  => true,
            ];
        }
        $job->questionnaire = json_encode($questionnaire);

        $job->profile_requirements = json_encode($profile);
        $job->strict_mode = (int) $request->input('strict_mode', 0);

        /* Refresh slug if title changed. */
        $job->slug = \Illuminate\Support\Str::slug($job->job_title, '-') . '-' . $job->id;

        $job->save();

        /* Replace skills (delete + reinsert via the same helper). */
        \DB::table('manage_job_skills')->where('job_id', $job->id)->delete();
        $this->znpStoreJobSkills($request, $job->id);
        $this->znpUpdateFullTextSearch($job, $request);

        /* Also refresh the company auto-save snapshot — keeps "next time" prefills current. */
        $company->description       = $request->input('about_company');
        $company->website           = $request->input('website_address');
        if ($request->filled('industry_id')) {
            $company->industry_id = $request->input('industry_id');
        }
        $company->no_of_employees   = $request->input('headcount');
        $company->headcount         = $request->input('headcount');
        $company->office_address    = $request->input('office_address');
        $company->countries_presence = json_encode(array_values(array_filter($countries, 'strlen')));
        $company->awards            = json_encode($awards);
        $company->perks             = json_encode($perks);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $fileName = \ImgUploader::UploadImage('company_logos', $image, $company->name, 300, 300, false);
            $company->logo = $fileName;
        }

        $company->save();

        return redirect()->route('my-jobs')->with('message', 'Job updated successfully.');
    }

    private function znpDecodeJsonColumn($raw, array $default = [])
    {
        if (is_array($raw)) {
            return $raw;
        }
        if (! is_string($raw) || $raw === '') {
            return $default;
        }
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : $default;
    }

    /**
     * Replicates the legacy Skills trait logic so we don't have to wire JobTrait
     * into this controller. Accepts both numeric IDs and free-text skill names.
     */
    private function znpStoreJobSkills($request, $job_id)
    {
        if (! $request->has('keyskills')) {
            return;
        }

        \App\JobSkillManager::where('job_id', '=', $job_id)->delete();
        $skills = (array) $request->input('keyskills');

        foreach ($skills as $job_skill_id) {
            $job_skill_id = is_string($job_skill_id) ? trim($job_skill_id) : $job_skill_id;
            if ($job_skill_id === '' || $job_skill_id === null) {
                continue;
            }

            $manager = new \App\JobSkillManager();
            $manager->job_id = $job_id;

            if (is_numeric($job_skill_id)) {
                $manager->job_skill_id = (int) $job_skill_id;
            } else {
                /* New free-text skill — persist into job_skills first. */
                $existing = JobSkill::where('job_skill', $job_skill_id)->first();
                if ($existing) {
                    $manager->job_skill_id = $existing->id;
                } else {
                    $new = new JobSkill();
                    $new->job_skill = $job_skill_id;
                    $new->save();
                    $manager->job_skill_id = $new->id;
                }
            }

            $manager->save();
        }
    }

    /**
     * Mirrors JobTrait::updateFullTextSearch but doesn't depend on the trait.
     */
    private function znpUpdateFullTextSearch($job, $request)
    {
        $values = $request->input('location') ? (array) $request->input('location') : [];
        $locStr = $values ? implode(' ', $values) : '';

        $str  = ' ' . $job->job_title;
        $str .= ' ' . $job->locality;
        $str .= ' ' . $request->input('exp_min');
        $str .= ' ' . $job->getJobSkillsStr();
        $str .= ' ' . $locStr;
        $str .= ' ' . $job->job_type;
        $str .= ' ' . $job->job_shift;
        $str .= ' ' . $job->work_mode;
        $str .= ' ' . $job->industry;
        $str .= ' ' . $job->client_name;

        $job->search = $str;
        $job->update();
    }



    /**

     * New-design employer dashboard (ZNP isolated layout).

     *

     * @return \Illuminate\View\View

     */

    public function employerDashboardNew()

    {

        $company = Company::findOrFail(Auth::guard('company')->user()->id);



        $jobIds = $company->jobs()->pluck('id');

        $jobsPostedCount = $company->jobs()->count();

        $applicationsCount = JobApply::whereIn('job_id', $jobIds)->count();



        if ($company->cvs_quota != null) {

            $creditsRemaining = $company->cvs_quota - $company->availed_cvs_quota;

        } else {

            $creditsRemaining = 0 - $company->availed_cvs_quota;

        }

        $creditsRemaining = max(0, $creditsRemaining);



        $packageActive = $company->package_end_date

            && Carbon::parse($company->package_end_date)->isFuture();



        /* ── ZNP plan view-model (new system; supersedes the legacy package_*) ──
           One denormalised array shared with my-jobs so plan messaging stays
           consistent across the app. See Company::znpPlanViewModel(). */
        $znpPlan = $company->znpPlanViewModel();

        /* "Upsell" picks the other plans to show as next-step options on the
           dashboard plan card (excludes the user's current plan if any). */
        $znpUpsellPlans = \App\ZnpPricingPlan::active()->ordered()->get()
            ->reject(function ($p) use ($znpPlan) {
                return $znpPlan['has_plan'] && $znpPlan['plan_slug'] === $p->slug;
            })
            ->values();



        /* Sidebar plan card copy. Falls back to the legacy "Paid plan active"
           label only when this employer has neither a ZNP nor a legacy plan. */
        if ($znpPlan['has_plan']) {

            $planLabel = $znpPlan['plan_name'];

            $planDescription = $znpPlan['sub_line'];

        } elseif ($packageActive) {

            $planLabel = 'Paid plan active';

            $planDescription = 'Your plan is active through ' . Carbon::parse($company->package_end_date)->format('j M Y') . '. Post jobs and unlock credits from your package.';

        } else {

            $planLabel = 'Free Account';

            $planDescription = 'Explore ZNP — upgrade to post jobs and access contractors';

        }



        $recentPlatformJobs = PostJob::status()

            ->where('created_at', '>=', Carbon::now()->subDays(30))

            ->with('company')

            ->latest()

            ->take(8)

            ->get();

        $recentJobsScroll = $recentPlatformJobs->count() >= 4

            ? $recentPlatformJobs->concat($recentPlatformJobs)

            : $recentPlatformJobs;



        $contactLine = $this->employerDashboardEmployerContactLine($company);



        $companyDisplayName = trim((string) ($company->name ?? ''));

        $contactPersonName = trim((string) ($company->ceo ?: ($company->person_name ?? '')));

        $welcomeName = mb_strlen($contactPersonName) > 1
            ? $contactPersonName
            : ($companyDisplayName !== '' ? $companyDisplayName : 'there');



        /* Live counts (same semantics as homepage) — avoids static Counter placeholders. */

        $dashLiveJobsZn = PostJob::status()->count();

        $dashPermanentRoles = PostJob::status()->where(function ($q) {

            $q->where('job_type', 'LIKE', '%Permanent%')

                ->orWhere('job_type', 'LIKE', '%Full Time%')

                ->orWhere('job_type', 'LIKE', '%Full time%');

        })->count();

        $dashContractRoles = PostJob::status()->where('job_type', 'LIKE', '%Contract%')->count();



        $contractorsShowcase = $this->buildEmployerDashboardContractShowcase(4);



        $resumezSpotlightCount = User::query()

            ->where('hide_show', 0)

            ->whereHas('profileDetails', function ($q) {

                $q->where('work_type', 'Contract');

            })

            ->count();



        return view('znp.employer-dashboard', compact(

            'company',

            'jobsPostedCount',

            'applicationsCount',

            'creditsRemaining',

            'recentPlatformJobs',

            'recentJobsScroll',

            'contactLine',

            'welcomeName',

            'companyDisplayName',

            'planLabel',

            'planDescription',

            'packageActive',

            'znpPlan',

            'znpUpsellPlans',

            'contractorsShowcase',

            'dashLiveJobsZn',

            'dashPermanentRoles',

            'dashContractRoles',

            'resumezSpotlightCount'

        ));

    }



    /**

     * City/state columns sometimes carry JSON blobs (translations row). Normalize for UI text.

     */

    private function employerDashboardStripStructuredNoise(string $s): string

    {

        $t = trim($s);

        if ($t !== '' && ($t[0] === '{' || $t[0] === '[')) {

            return '';

        }



        return $t;

    }



    private function employerDashboardReadableLocationPiece($mixed): string

    {

        $s = trim((string) $mixed);

        if ($s === '') {

            return '';

        }



        $first = substr($s, 0, 1);



        if ($first === '{' || $first === '[') {

            $decoded = json_decode($s, true);

            if (! is_array($decoded)) {

                return '';

            }

            if (! empty($decoded['city']) && is_string($decoded['city'])) {

                return $this->employerDashboardStripStructuredNoise(trim($decoded['city']));

            }



            foreach (['state', 'province', 'region', 'country'] as $k) {

                if (! empty($decoded[$k]) && is_string($decoded[$k])) {

                    return $this->employerDashboardStripStructuredNoise(trim($decoded[$k]));

                }

            }



            return '';

        }



        $maybePhp = @unserialize($s);

        if ($maybePhp !== false && $s !== 'b:0;') {

            if (is_array($maybePhp) && ! empty($maybePhp['city']) && is_string($maybePhp['city'])) {

                return trim($maybePhp['city']);

            }



            return '';

        }



        // Last-resort scrape if the DB column still contains escaped JSON-ish text inside a varchar.

        if (strpos($s, '"city"') !== false && preg_match('/"city"\s*:\s*"([^"]+)"/u', $s, $mm)) {

            return trim(html_entity_decode($mm[1], ENT_QUOTES, 'UTF-8'));

        }



        return $this->employerDashboardStripStructuredNoise($s);

    }



    private function employerDashboardEmployerContactLine(Company $company): string

    {

        $parts = [];

        foreach ([

            $this->employerDashboardReadableLocationPiece(isset($company->city) ? $company->city : ''),

            $this->employerDashboardReadableLocationPiece(isset($company->state) ? $company->state : ''),

        ] as $frag) {

            if ($frag !== '') {

                $parts[$frag] = true;

            }

        }



        return implode(', ', array_keys($parts));

    }



    /**

     * Turn key_skills.keyskill cell into a recruiter-facing label — matches CV-search logic,

     * but resolves both JobSkill PK and locale job_skill_id.

     *

     * @param  string  $raw

     * @return string

     */

    private function employerDashboardResolveKeyskillDisplayLabel(string $raw): string

    {

        static $cache;

        $cache ??= [];

        $raw = trim($raw);

        if ($raw === '') {

            return '';

        }

        if (array_key_exists($raw, $cache)) {

            return $cache[$raw];

        }

        if (! ctype_digit($raw)) {

            return $cache[$raw] = $raw;

        }

        $id = (int) $raw;

        $matcher = static function ($q) use ($id) {

            $q->where('id', $id)->orWhere('job_skill_id', $id);

        };

        /** @var \App\JobSkill|null $jsk */

        $jsk = JobSkill::query()

            ->where($matcher)

            ->lang()

            ->first();

        if (! $jsk) {

            $jsk = JobSkill::query()

                ->where($matcher)

                ->first();

        }



        return $cache[$raw] = $jsk ? trim((string) $jsk->job_skill) : '';

    }



    /**

     * Contract-role candidates shown on employer dashboard spotlight cards.

     */

    private function buildEmployerDashboardContractShowcase(int $limit = 4): array

    {

        $rows = [];

        $accents = ['purple', 'teal', 'orange', 'green'];



        $users = User::query()

            ->where('hide_show', 0)

            ->whereHas('profileDetails', function ($q) {

                $q->where('work_type', 'Contract');

            })

            ->with([

                'profileSummary',

                'profileDetails',

                'profileNop',

                'profilekeyskill' => function ($rel) {

                    $rel->limit(50);

                },

                'profileSkills' => function ($rel) {

                    $rel->limit(36);

                },

            ])

            ->orderByDesc('users.updated_at')

            ->take(48)

            ->get()

            /** Prefer profiles that actually have skill rows so the spotlight matches the CV UI. */

            ->sortByDesc(static function (User $u) {

                return $u->profilekeyskill->count() + $u->profileSkills->count();

            })

            ->values();



        foreach ($users as $idx => $user) {

            if (count($rows) >= $limit) {

                break;

            }



            $name = trim((string) $user->name);

            $anon = $this->employerDashboardAnonymizedNameParts($name);

            $summ = optional($user->profileSummary)->first();

            $title = trim((string) (optional($summ)->latestdesg ?? ''));

            $totExpRaw = optional($summ)->totalexp ?? '';

            $totExpDisp = '';

            if ($totExpRaw !== '' && $totExpRaw !== null) {

                $totFloat = (float) $totExpRaw;

                $totExpDisp = $totFloat == floor($totFloat) ? (string) (int) $totFloat : (string) $totFloat;

            }

            $roleLineParts = [];

            if ($title !== '') {

                $roleLineParts[] = $title;

            }

            if ($totExpDisp !== '') {

                $roleLineParts[] = $totExpDisp . ' yrs';

            }

            $roleLine = implode(' · ', $roleLineParts) ?: 'Contract professional';



            $pd = optional($user->profileDetails)->first();

            $loc = '';

            if (isset($user->current_city)) {

                $loc = $this->employerDashboardReadableLocationPiece(trim((string) $user->current_city));

            }

            if ($loc !== '' && (strpos($loc, ',') !== false)) {

                $locPieces = preg_split('/[,\/+]/', $loc, 2);

                $loc = trim((string) ($locPieces[0] ?? ''));

            }

            $mode = $this->employerDashboardNormalizeWorkMode(($pd !== null ? $pd->candidate_wfh : null));



            [$availLabel, $availColor] = $this->employerDashboardAvailabilityFromProfileNop(optional($user->profileNop)->first());

            $tagLabels = [];

            $pushSkillTag = static function (string $lbl) use (&$tagLabels): bool {

                $lbl = trim($lbl);

                if ($lbl === '' || in_array($lbl, $tagLabels, true)) {

                    return false;

                }

                $tagLabels[] = $lbl;

                return true;

            };



            /* Same resolution path as CV search (JobSkill rows may match id or job_skill_id). */

            foreach ($user->profilekeyskill as $ksRow) {

                if (count($tagLabels) >= 5) {

                    break;

                }



                $rawKs = isset($ksRow->keyskill) ? trim((string) $ksRow->keyskill) : '';

                if ($rawKs === '') {

                    continue;

                }



                $lbl = $this->employerDashboardResolveKeyskillDisplayLabel($rawKs);

                if ($lbl !== '') {

                    $pushSkillTag($lbl);

                }

            }



            foreach ($user->profileSkills as $ps) {

                if (count($tagLabels) >= 5) {

                    break;

                }



                $lbl = trim((string) $ps->getJobSkill('job_skill'));

                if ($lbl !== '') {

                    $pushSkillTag($lbl);

                }

            }



            $rows[] = [

                'initials' => $anon['initials'],

                'name' => $anon['masked'],

                'role' => $roleLine,

                'availability_label' => $availLabel,

                'availability_color' => $availColor,

                'loc' => $loc,

                'mode' => $mode,

                'accent' => $accents[$idx % count($accents)],

                'tags' => array_values(array_unique(array_filter($tagLabels))),

            ];

        }



        return $rows;

    }



    /**

     * Mask name similarly to dashboard mock-ups (prefix + *** + last char).

     */

    private function employerDashboardMaskNamePiece(string $piece): string

    {

        $piece = trim($piece);

        if ($piece === '') {

            return '';

        }

        $len = mb_strlen($piece);

        if ($len === 1) {

            return $piece . '***';

        }

        if ($len === 2) {

            return mb_substr($piece, 0, 1) . '***' . mb_substr($piece, -1);

        }

        return mb_substr($piece, 0, 1) . '***' . mb_substr($piece, -1);

    }



    /**

     * @return array{initials:string,masked:string}

     */

    private function employerDashboardAnonymizedNameParts(string $fullName): array

    {

        $fullName = trim($fullName);

        if ($fullName === '') {

            return ['initials' => 'JN', 'masked' => 'J***'];

        }



        $parts = preg_split('/\s+/u', $fullName);

        $parts = array_values(array_filter($parts, function ($s) {

            return $s !== '';

        }));

        if (! $parts) {

            return ['initials' => 'JN', 'masked' => 'J***'];

        }



        $initials = '';

        foreach (array_slice($parts, 0, 2) as $p) {

            $initials .= mb_strtoupper(mb_substr($p, 0, 1));

        }

        $maskedPieces = [];

        foreach ($parts as $p) {

            $maskedPieces[] = $this->employerDashboardMaskNamePiece($p);

        }



        return [

            'initials' => $initials !== '' ? $initials : 'JN',

            'masked' => implode(' ', $maskedPieces),

        ];

    }



    private function employerDashboardNormalizeWorkMode($candidateWfh): string

    {

        $candidateWfh = (string) $candidateWfh;

        switch ($candidateWfh) {

            case '1': return 'Remote';

            case '2': return 'Hybrid';

            case '3': return 'Work From Office';

            case '4': return 'Flexible';

            default:

                return '';

        }

    }



    /**

     * nop_days: '1' = immediately available / not under notice UX, '2' = serving notice (use last_working_day).

     *

     * @return array{0:string,1:'green'|'amber'}

     */

    private function employerDashboardAvailabilityFromProfileNop(?\App\ProfileNop $nop): array

    {

        if ($nop !== null && (string) $nop->nop_days === '2') {

            if (! empty($nop->last_working_day)) {

                try {

                    $lwd = Carbon::parse($nop->last_working_day)->startOfDay();

                    if ($lwd->lte(Carbon::today())) {

                        return ['⚡ Starts immediately', 'green'];

                    }



                    $d = Carbon::today()->diffInDays($lwd);

                    $d = max(1, (int) $d);

                    $lbl = ($d === 1)

                        ? '⏱ Starts after 1 day'

                        : ('⏱ Starts after ' . $d . ' days');



                    return [$lbl, 'amber'];

                } catch (\Throwable $e) {

                    return ['⏱ Serving notice — date pending', 'amber'];

                }

            }



            return ['⏱ Serving notice — date pending', 'amber'];

        }



        return ['⚡ Starts immediately', 'green'];

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

