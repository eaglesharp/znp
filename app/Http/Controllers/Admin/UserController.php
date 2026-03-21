<?php



namespace App\Http\Controllers\Admin;



use DB;

use App\Degree;

use Validator;

use Zip;

use Auth;

use File;

use Input;

use App\City;

use App\User;

use Redirect;

use App\State;

use App\Gender;

use App\Interview;

use App\Offers;

use DataTables;

use App\Country;

use App\Package;

use ImgUploader;

use App\Industry;

use App\KeySkill;

use App\ProfileCv;

use Carbon\Carbon;

use App\ProfileGap;

use App\ProfileNop;

use App\CareerLevel;

use App\ProfileSkill;

use App\Http\Requests;

use App\JobExperience;

use App\MaritalStatus;

use App\Traits\Skills;

use App\FunctionalArea;

use App\ProfileDetails;

use App\ProfileProject;

use App\ProfileSummary;

use App\CompanyData;

use App\JobSkill;

use App\ProfileLanguage;

use Carbon\CarbonPeriod;

use App\ProfileEducation;

use App\ProfileExperience;

use Illuminate\Support\Str;

use App\Exports\StateExport;

use App\Imports\UsersImport;

use App\Imports\EducationImport;

use App\ProfileCityJobsCity;

use Illuminate\Http\Request;

use App\Exports\CareerExport;

use App\Exports\CountryExport;

use App\Exports\LatestCompanyExport;

use App\Exports\IndustryExport;

use App\Exports\LanguageExport;

use App\Traits\ProfileCvsTrait;

use App\Exports\JobSkillsExport;

use App\Helpers\DataArrayHelper;

use App\Exports\DegreeTypeExport;

use App\Traits\ProfileSkillTrait;

use Illuminate\Http\UploadedFile;

use App\Traits\CommonUserFunctions;

use App\Traits\ProfileSummaryTrait;

use App\Http\Controllers\Controller;

use App\Http\Requests\OffersRequest;

use App\Traits\ProfileLanguageTrait;

use App\Traits\ProfileProjectsTrait;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;

use Maatwebsite\Excel\Facades\Excel;

use App\Helpers\ImageUploadingHelper;

use App\Http\Requests\CompanyRequest;

use App\Traits\JobSeekerPackageTrait;

use App\Traits\ProfileEducationTrait;

use App\Traits\AccomplishmentTrait;

use App\Http\Requests\UserFormRequest;

use App\Traits\ProfileExperienceTrait;

use App\Http\Requests\ProfileNpRequest;

use App\Http\Requests\ProfileGapRequest;

use App\Http\Requests\PreferencesRequest;

use App\Http\Requests\CompanyFrontRequest;

use App\Http\Requests\CompensationRequest;

use App\Http\Requests\UpdateUserFormRequest;

use App\Http\Requests\MajorSubjectFormRequest;

use App\Http\Requests\ProfileInterviewRequest;


use App\Http\Requests\ProfileProjectFormRequest;

use App\Http\Requests\CompanyPreviousFrontRequest;

use App\Http\Requests\ProfileProjectImageFormRequest;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\UserLocation;




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

    use AccomplishmentTrait;

    use JobSeekerPackageTrait;



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {

        //

    }



    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function indexUsers()
    {

        \Session::forget('keyskills');

        return view('admin.user.index');

    }

    public function bulkuseruploads()
    {

        return view('admin.user.bulk');

    }

    public function bulkresume()
    {

        return view('admin.user.resume');

    }

    public function bulkuserresume(Request $request)
    {



        if ($request->hasFile('file')) {

            //return dd($request->file('file'));

            foreach ($request->file('file') as $file) {

                $filenameWithExt = $file->getClientOriginalName();

                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                $extension = $file->getClientOriginalExtension();

                $name = $filename . '.' . $extension;

                // return dd($name);

                $usercheck = User::where('email', $filename)->first();

                //  return dd($usercheck);

                if (!empty($usercheck)) {

                    $today = date("d/m/Y");

                    $cv_updated = 'Admin - ' . $today;

                    $profileCv = User::findOrFail($usercheck->id);

                    $profileCv1 = User::where('id', $usercheck->id)->first();

                    $profileCv1->cv_updated = $cv_updated;

                    $profileCv1->resume = $name;

                    $profileCv1->save();


                    if (file_exists(public_path('cvs/' . $name))) {

                        unlink(public_path('cvs/' . $name));

                    }

                    $file->move(public_path() . '/cvs/', $file->getClientOriginalName());


                } else {

                    $data[] = $name;

                    return view('admin.user.resume', compact('data'));

                }



            }



        }


        return back()->with('success', "Resumes Updated Successfully!");


    }



    public function createUser()
    {

        $genders = DataArrayHelper::defaultGendersArray();

        $maritalStatuses = DataArrayHelper::defaultMaritalStatusesArray();

        $nationalities = DataArrayHelper::defaultNationalitiesArray();

        $countries = DataArrayHelper::defaultCountriesArray();

        $jobExperiences = DataArrayHelper::defaultJobExperiencesArray();

        $careerLevels = DataArrayHelper::defaultCareerLevelsArray();

        $industries = DataArrayHelper::defaultIndustriesArray();

        $functionalAreas = DataArrayHelper::defaultFunctionalAreasArray();

        $packages = Package::select('id', DB::raw("CONCAT(`package_title`, ', $', `package_price`, ', Days:', `package_num_days`, ', Listings:', `package_num_listings`) AS package_detail"))->where('package_for', 'like', 'job_seeker')->pluck('package_detail', 'id')->toArray();

        $upload_max_filesize = UploadedFile::getMaxFilesize() / (1048576);

        $job_skills = \App\JobSkill::all()->unique('job_skill')->take(2000);

        $user = (object) [
            'id' => null
        ];


        // if (\Session::has('errkeyskills')) {
        //     \Session::forget('keyskills');
        // }

        return view('admin.user.add')

            ->with('user', $user)

            ->with('genders', $genders)

            ->with('job_skills', $job_skills)

            ->with('maritalStatuses', $maritalStatuses)

            ->with('nationalities', $nationalities)

            ->with('countries', $countries)

            ->with('jobExperiences', $jobExperiences)

            ->with('careerLevels', $careerLevels)

            ->with('industries', $industries)

            ->with('functionalAreas', $functionalAreas)

            ->with('upload_max_filesize', $upload_max_filesize)

            ->with('packages', $packages);

    }




    public function storeUser(UpdateUserFormRequest $request)
    {

        //return dd($request->password);






        if ($request->hasFile('resume')) {



            // $this->validate(
            //     $request, 
            //     // ['resume' => 'mimes:pdf,docx|max:2048'],
            //     [
            //       // 'resume.required' => 'Resume is required',
            //         'mimes.required' => 'Only Supports pdf and docx types',
            //         'max.required' => 'Maximum file size 2mb'

            //         ]
            // );



        } else {





            // $this->validate(
            //     $request, 
            //     ['resume' => 'required'],
            //     ['resume.required' => 'Resume is required']
            // );
        }






        $randompassword = Str::random(8);



        $password = Hash::make($randompassword);





        $fileName = '';

        if ($request->hasFile('resume')) {

            $cv_file = $request->file('resume');

            $fileName = ImgUploader::UploadDoc('cvs', $cv_file, $request->input('title'));

        } else {
            $fileName = '';
        }

        $fileName_recorded_video = '';

        if ($request->hasFile('recorded_video')) {

            $recorded_video = $request->file('recorded_video');

            $fileName_recorded_video = ImgUploader::UploadDoc('cvs', $recorded_video, "recorded_video");

        } else {
            $fileName_recorded_video = '';
        }










        $ignored_companies = [];

        if ($request->ignore_companies) {
            foreach ($request->ignore_companies as $company) {
                // dd($company);

                if (is_numeric($company)) {

                    $company_data_val = CompanyData::where('id', $company)->first();

                } else {

                    $company_data_val = new CompanyData();
                    $company_data_val->name = $company;
                    $company_data_val->save();

                }

                $ignored_companies[] = $company_data_val->id;

            }
        } else {
            $ignored_companies = NULL;
        }


        $today = date("d/m/Y");

        $cv_updated = 'Admin - ' . $today;





        // dd($ignored_companies);

        // dd($fileName_recorded_video);
        $user = User::create([

            'first_name' => $request->input('first_name'),

            'last_name' => $request->input('last_name'),

            'email' => $request->input('email'),

            'phone' => $request->input('phone'),

            'password' => $password,

            'resume' => $fileName,

            'current_city' => $request->current_city,

            'reason_moved' => $request->reason_moved,

            'recruiter_email' => $request->recruiter_email,

            'recruiter_phone' => $request->recruiter_phone,

            'is_active' => $request->input('is_active'),

            'verified' => $request->input('verified'),

            'email_verified' => 1,

            'phone_verified' => 0,

            'no_profile_views' => 0,

            'no_of_downloads' => 0,

            'no_of_emails' => 0,

            'complete' => 3,

            'profile_completion' => 2,

            'payment_status' => 0,

            'ignore_companies' => serialize($ignored_companies),

            'recruiter_comments' => $request->recruiter_comments,

            'recorded_video' => $fileName_recorded_video,

        ]);




        $user = User::where('id', $user->id)->first();
        $user->gender_id = $request->gender_id;
        if ($request->hasFile('resume')) {

            $user->cv_updated = $cv_updated;

        }
        if ($request->prefered_city) {
            $user->prefered_city = serialize($request->prefered_city);
        }


        $user->added = "Admin";
        $user->added_by = Auth::user()->id;
        $user->save();



        ///  dd($user);
        $profileNP = ProfileNop::where('user_id', '=', $user->id)->first();

        if ($profileNP) {

            $profileNP->nop_days = $request->nop_days;

            $profileNP->last_working_day = $request->last_working_day;

            $profileNP->immediate_last_date = $request->immediate_last_date;

            $profileNP->contract = $request->contract;

            $profileNP->save();

        } else {

            $nop = new ProfileNop();

            $nop->user_id = $user->id;

            $nop->last_working_day = $request->last_working_day ?? '';

            $nop->immediate_last_date = $request->immediate_last_date;

            $nop->nop_days = $request->nop_days;

            $nop->contract = $request->contract;

            $nop->save();

        }



        $compensation = ProfileDetails::where('user_id', '=', $user->id)->first();


        if ($compensation) {
            $compensation->candidate_wfh = $request->work_option;
            $compensation->expect_ctc_lakhs = $request->expect_ctc_lakhs;
            $compensation->expect_ctc_thousand = $request->expect_ctc_thousand;
            $compensation->expect_ctc_lakhs3 = $request->expect_ctc_lakhs3;
            $compensation->expect_ctc_thousand3 = $request->expect_ctc_thousand3;
            $compensation->work_type = $request->work_type;
            $compensation->save();
        } else {

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

        if (is_numeric($request->input('latestcom'))) {

            $company_data_val = CompanyData::where('id', $request->input('latestcom'))->first();

        } else {

            $company_data_val = new CompanyData();
            $company_data_val->name = $request->input('latestcom');
            $company_data_val->save();

        }



        $summary = ProfileSummary::where('user_id', '=', $user->id)->first();


        if ($summary) {
            $summary->latestcom = $company_data_val->name;
            $summary->latestcom_id = $company_data_val->id;
            $summary->latestdesg = $request->latestdesg;
            $summary->totalexp = $request->totalexp;
            $summary->totalexpmonth = $request->totalexpmonth;
            $summary->save();
        } else {

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

        if ($request->keyskills) {

            // dd($request->keyskills);


            $delete = KeySkill::where('user_id', $user->id)->get();

            // dd($delete);

            if ($delete) {



                foreach ($delete as $dele) {

                    $dele->delete();

                }

            }


            foreach ($request->keyskills as $keyskill) {

                $skills = jobSkill::where('id', $keyskill)->first();

                if ($skills) {

                    $key_new = new KeySkill();

                    $key_new->user_id = $user->id;

                    $key_new->keyskill = $keyskill;

                    $key_new->save();


                } else {

                    $key_new = new JobSkill();

                    $key_new->job_skill = $keyskill;

                    $key_new->save();


                    $key_sk = new KeySkill();

                    $key_sk->user_id = $user->id;

                    $key_sk->keyskill = $key_new->id;

                    $key_sk->save();

                }
            }

            $user = User::where('id', $user->id)->first();

            $user->complete = $user->complete + 3;

            $user->profile_completion = $user->profile_completion + 2;

            $user->save();


        }


        $education = ProfileEducation::where('user_id', '=', $user->id)->first();


        if ($education) {
            if (is_numeric($request->input('organization'))) {

                $education->degree_title = $request->degree_title;
                $education->course = $request->course ?? 'NULL';
                $education->education_status = $request->education_status;
                $education->year_of_completion = $request->year_of_completion ?? 'NULL';
                $education->specilation = $request->specilation ?? 'NULL';
                $education->organization = $request->organization;
                $education->save();

            } else {

                $organization = new Degree();
                $organization->educations = $request->input('organization');
                $organization->save();

                $education->degree_title = $request->degree_title;
                $education->course = $request->course ?? 'NULL';
                $education->education_status = $request->education_status;
                $education->year_of_completion = $request->year_of_completion ?? 'NULL';
                $education->specilation = $request->specilation ?? 'NULL';
                $education->organization = $organization->id;
                $education->save();

            }




        } else {


            $education = new ProfileEducation();
            $education->user_id = $user->id;
            $education->degree_title = $request->degree_title;
            $education->education_status = $request->education_status;
            $education->year_of_completion = $request->year_of_completion ?? 'NULL';
            $education->course = $request->course ?? 'NULL';
            $education->specilation = $request->specilation ?? 'NULL';
            if ($request->input('organization')) {
                if (is_numeric($request->input('organization'))) {
                    $education->organization = $request->organization;
                } else {
                    $organization = new Degree();
                    $organization->educations = $request->input('organization');
                    $organization->save();
                    $education->organization = $organization->id;
                }
            } else {
                $education->organization = NULL;

            }

            $education->save();

        }





        $data = [

            'title' => $request->email,

            'subject' => 'Candidate Account Created On ZNP Team',

            'content' => $randompassword,

            'name' => $request->first_name,

            'link' => route('login'),

        ];



        Mail::send('emails.userregistered', $data, function ($message) use ($data) {

            $message->to($data['title'])->from('hr@zeronoticeperiod.com')

                ->subject($data['subject']);

        });



        flash('User has been added!')->success();



        return \Redirect::route('list.users', array($user->id));

    }

    public function editUserSkills($id)
    {

        $user = User::where('id', $id)->first();

        $keyskills = KeySkill::where('user_id', $user->id)
            ->pluck('keyskill')->toArray();

        $job_skills = Jobskill::groupBy('job_skill')
            ->select('job_skill')->get();
        dd($job_skills, $keyskills);


        return view('admin.user.editskills')->with([
            'user' => $user
        ]);
    }



    public function editUser($id)
    {







        // $cities = City::select('cities.city', 'cities.city_id')->where('cities.state_id', '=', $state_id)->isDefault()->active()->sorted()->pluck('cities.city', 'cities.city_id')->toArray();





        $genders = DataArrayHelper::defaultGendersArray();

        $maritalStatuses = DataArrayHelper::defaultMaritalStatusesArray();

        $nationalities = DataArrayHelper::defaultNationalitiesArray();

        $countries = DataArrayHelper::defaultCountriesArray();



        $jobExperiences = DataArrayHelper::defaultJobExperiencesArray();

        $careerLevels = DataArrayHelper::defaultCareerLevelsArray();

        $industries = DataArrayHelper::defaultIndustriesArray();

        $functionalAreas = DataArrayHelper::defaultFunctionalAreasArray();



        $upload_max_filesize = UploadedFile::getMaxFilesize() / (1048576);

        $user = User::findOrFail($id);
        // dd($user);

        // return dd($user->profileNop);

        // if ($user->package_id > 0) {

        //     $package = Package::find($user->package_id);
        //  dd($user);

        //     $packages = Package::select('id', DB::raw("CONCAT(`package_title`, ', $', `package_price`, ', Days:', `package_num_days`, ', Listings:', `package_num_listings`) AS package_detail"))->where('package_for', 'like', 'job_seeker')->where('id', '<>', $user->package_id)->where('package_price', '>=', $package->package_price)->pluck('package_detail', 'id')->toArray();

        // } else {

        //     $packages = Package::select('id', DB::raw("CONCAT(`package_title`, ', $', `package_price`, ', Days:', `package_num_days`, ', Listings:', `package_num_listings`) AS package_detail"))->where('package_for', 'like', 'job_seeker')->pluck('package_detail', 'id')->toArray();

        // }



        return view('admin.user.edit')

            ->with('genders', $genders)

            // ->with('cities',$cities)

            ->with('maritalStatuses', $maritalStatuses)

            ->with('nationalities', $nationalities)

            ->with('countries', $countries)

            ->with('jobExperiences', $jobExperiences)

            ->with('careerLevels', $careerLevels)

            ->with('industries', $industries)

            ->with('functionalAreas', $functionalAreas)

            ->with('user', $user)

            ->with('upload_max_filesize', $upload_max_filesize);

        // ->with('packages', $packages);

    }



    public function updateUser($id, UserFormRequest $request)
    {

        //return dd($request);

        if ($request->industry == 2) {

            $this->validate(
                $request,
                ['process' => 'required'],
                ['process.required' => 'Process is required']
            );


        }




        // $request->validate([



        // 'resume'=>'required|mimes:pdf,docx|max:2048'     



        // ]);

        $newuser = User::where('id', $id)->first();





        $user = User::findOrFail($id);

        /*         * **************************************** */
        if ($user->resume) {
            if ($request->resume) {
                $fileName = '';

                if ($request->hasFile('resume')) {

                    $this->validate(
                        $request,
                        ['resume' => 'required|mimes:pdf,docx|max:2048'],
                        [
                            'resume.required' => 'Resume is required',
                            'mimes.required' => 'Only Supports pdf and docx types',
                            'max.required' => 'Maximum file size 2mb'

                        ]
                    );

                    $today = date("d/m/Y");

                    $cv_updated = 'Admin - ' . $today;

                    $cv_file = $request->file('resume');

                    $fileName = ImgUploader::UploadDoc('cvs', $cv_file, $request->input('title'));

                    $user->resume = $fileName;

                    $user->cv_updated = $cv_updated;

                }
            }
        } else {
            if ($request->resume) {
                $fileName = '';

                if ($request->hasFile('resume')) {

                    $this->validate(
                        $request,
                        ['resume' => 'required|mimes:pdf,docx|max:2048'],
                        [
                            'resume.required' => 'Resume is required',
                            'mimes.required' => 'Only Supports pdf and docx types',
                            'max.required' => 'Maximum file size 2mb'

                        ]
                    );

                    $today = date("d/m/Y");

                    $cv_updated = 'Admin - ' . $today;

                    $cv_file = $request->file('resume');

                    $fileName = ImgUploader::UploadDoc('cvs', $cv_file, $request->input('title'));

                    $user->resume = $fileName;

                    $user->cv_updated = $cv_updated;

                }
            } else {





                $this->validate(
                    $request,
                    ['resume' => 'required'],
                    ['resume.required' => 'Resume is required']
                );
            }

        }



        if ($request->hasFile('image')) {

            $is_deleted = $this->deleteUserImage($user->id);

            $image = $request->file('image');

            $fileName = ImgUploader::UploadImage('user_images', $image, $request->input('name'), 300, 300, false);

            $user->image = $fileName;

        }







        $user->first_name = $request->input('first_name');

        $user->middle_name = $request->input('middle_name');

        $user->last_name = $request->input('last_name');

        /*         * *********************** */

        $user->name = $user->getName();

        /*         * *********************** */



        if (!empty($request->input('password'))) {

            $user->password = Hash::make($request->input('password'));

        }

        $user->email = $request->input('email');









        $user->father_name = $request->input('father_name');

        $user->date_of_birth = $request->input('date_of_birth');

        $user->gender_id = $request->input('gender_id');

        $user->marital_status_id = $request->input('marital_status_id');

        // $user->nationality_id = $request->input('nationality_id');

        // $user->national_id_card_number = $request->input('national_id_card_number');

        $user->current_city = $request->input('current_city');

        $user->prefered_city = serialize($request->input('prefered_city'));

        $user->current_location = $request->input('current_location');

        $user->phone = $request->input('phone');

        $user->mobile_num = $request->input('mobile_num');

        $user->prefered_location = $request->input('prefered_location');

        $user->physically_challenged = $request->input('physically_challenged');

        $user->industry = $request->input('industry');

        $user->process = $request->input('process');

        // $user->functional_area_id = $request->input('functional_area_id');

        // $user->current_salary = $request->input('current_salary');

        // $user->expected_salary = $request->input('expected_salary');

        // $user->salary_currency = $request->input('salary_currency');

        $user->street_address = $request->input('street_address');

        // $user->is_immediate_available = $request->input('is_immediate_available');

        $user->is_active = $request->input('is_active');

        $user->verified = $request->input('verified');

        $user->update();


        foreach ($request->input('prefered_city') as $location_data) {
            $location = UserLocation::where('location', 'like', $location_data)->where('user_id', $id)->first();

            // dd($location_data);
            if ($location) {


            } else {
                $location = new UserLocation();
                $location->user_id = $id;
                $location->location = $location_data;
                $location->save();
            }

        }


        flash('User has been updated!')->success();

        return \Redirect::route('edit.user', array($user->id));

    }



    public function fetchUsersData(Request $request)
    {

        $users = User::select(

            [

                'users.id',

                'users.first_name',

                'users.middle_name',

                'users.last_name',

                'users.email',

                'users.password',

                'users.phone',

                'users.country_id',

                'users.state_id',

                'users.city_id',

                'users.is_immediate_available',

                'users.num_profile_views',

                'users.is_active',

                'users.verified',

                'users.created_at',

                'users.updated_at',

                'users.added',

                'users.resume',

                'users.cv_updated',

                'users.added_by',



            ]
        )->with(['recruiter'])->where('hide_show', 0)->orderBy('id', 'DESC');

        if (Auth::user()->role_id == 2) {
            $users = $users->where('added_by', Auth::user()->id);
        }

        // dd($users->get()[0]);

        return Datatables::of($users)

            ->filter(function ($query) use ($request) {

                if ($request->has('id') && !empty ($request->id)) {

                    $query->where('users.id', 'like', "{$request->get('id')}");

                }

                if ($request->has('name') && !empty ($request->name)) {

                    $query->where(function ($q) use ($request) {

                        $q->where('users.first_name', 'like', "%{$request->get('name')}%")

                            ->orWhere('users.middle_name', 'like', "%{$request->get('name')}%")

                            ->orWhere('users.last_name', 'like', "%{$request->get('name')}%");

                    });

                }

                if ($request->has('email') && !empty ($request->email)) {

                    $query->where('users.email', 'like', "%{$request->get('email')}%");

                }

            })

            ->addColumn('name', function ($users) {

                if ($users->resume && $users->cv_updated) {
                    return $users->first_name . ' ' . $users->middle_name . ' ' . $users->last_name . '<span class="" style="background-color:blue;color:white;padding:3px 11px;margin-left:8px">' . $users->cv_updated ?? '' . '</span';

                } else {
                    return $users->first_name . ' ' . $users->middle_name . ' ' . $users->last_name;

                }



            })
            ->addColumn('recruiter', function ($users) {
                if ($users->recruiter) {
                    $data = $users->recruiter->name . '<br>' . $users->recruiter->email;
                    return $data;
                } else {
                    return 'NA';
                }
            })





            ->addColumn('action', function ($users) {

                /*                             * ************************* */

                $active_txt = 'Make Active';

                $active_href = 'make_active(' . $users->id . ');';

                $active_icon = 'square-o';

                if ((int) $users->is_active == 1) {

                    $active_txt = 'Make InActive';

                    $active_href = 'make_not_active(' . $users->id . ');';

                    $active_icon = 'check-square-o';

                }

                /*                             * ************************* */

                /*                             * ************************* */

                $verified_txt = 'Not Verified';

                $verified_href = 'make_verified(' . $users->id . ');';

                $verified_icon = 'square-o';

                if ((int) $users->verified == 1) {

                    $verified_txt = 'Verified';

                    $verified_href = 'make_not_verified(' . $users->id . ');';

                    $verified_icon = 'check-square-o';

                }

                /*                             * ************************* */

                return '

				<div class="btn-group">

					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action

						<i class="fa fa-angle-down"></i>

					</button>

					<ul class="dropdown-menu">

						<li>

							<a href="' . route('edit.user', ['id' => $users->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>

						</li>						

						<li>

							<a href="javascript:void(0);" onclick="delete_user(' . $users->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>

						</li>

						<li>

						<a href="javascript:void(0);" onClick="' . $active_href . '" id="onclick_active_' . $users->id . '"><i class="fa fa-' . $active_icon . '" aria-hidden="true"></i>' . $active_txt . '</a>

						</li>

						<li>

						<a href="javascript:void(0);" onClick="' . $verified_href . '" id="onclick_verified_' . $users->id . '"><i class="fa fa-' . $verified_icon . '" aria-hidden="true"></i>' . $verified_txt . '</a>

						</li>	
                        <li>

                        <a href="' . route('user.payment.history', ['id' => $users->id]) . '"><i class="fa fa-trash-o" aria-hidden="true"></i>Payment History</a>

						</li>																																						

					</ul>

				</div>';

            })

            ->addColumn('created_at', function ($users) {

                return ($users->created_at)->format('d-m-Y');

            })

            ->addColumn('updated_at', function ($users) {

                return ($users->updated_at)->format('d-m-Y');

            })

            ->addColumn('added', function ($users) {

                return ((bool) $users->added) ? 'Admin' : 'Candidate';

            })

            ->addColumn('updated_by', function ($users) {

                $add = ((bool) $users->added) ? 'Admin' : 'Candidate';
                $date = ($users->updated_at)->format('d-m-Y');

                return $add . '-' . $date;

            })

            ->addColumn('verify', function ($users) {

                return ((bool) $users->verified) ? 'Verified' : 'Not Verified';

            })

            ->addColumn('checkbox', '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="{{$id}}" />')
            ->rawColumns(['action', 'name', 'checkbox', 'recruiter'])

            ->setRowId(function ($users) {

                return 'user_dt_row_' . $users->id;

            })

            ->make(true);

    }



    public function makeActiveUser(Request $request)
    {

        $id = $request->input('id');

        try {

            $user = User::findOrFail($id);

            $user->is_active = 1;

            $user->update();

            echo 'ok';

        } catch (ModelNotFoundException $e) {

            echo 'notok';

        }

    }



    public function makeNotActiveUser(Request $request)
    {

        $id = $request->input('id');

        try {

            $user = User::findOrFail($id);

            $user->is_active = 0;

            $user->update();

            echo 'ok';

        } catch (ModelNotFoundException $e) {

            echo 'notok';

        }

    }



    public function makeVerifiedUser(Request $request)
    {

        $id = $request->input('id');

        try {

            $user = User::findOrFail($id);

            $user->verified = 1;

            $user->update();

            echo 'ok';

        } catch (ModelNotFoundException $e) {

            echo 'notok';

        }

    }



    public function makeNotVerifiedUser(Request $request)
    {

        $id = $request->input('id');

        try {

            $user = User::findOrFail($id);

            $user->verified = 0;

            $user->update();

            echo 'ok';

        } catch (ModelNotFoundException $e) {

            echo 'notok';

        }

    }

    public function updateProfileNp($user_id, Request $request)
    {

        // return dd($request);

        // $user_id=$request->user_id;

        //         return dd($user_id);

        // if($request->nop_days)
        // {
        //     $this->validate(
        //         $request, 
        //         ['nop_days' => 'required'],
        //         ['nop_days.required' => 'Notice Period is required']
        //     );
        // } $this->validate(
        $this->validate(
            $request,
            ['nop_days' => 'required'],
            ['nop_days.required' => ' Notice Period is required']
        );
        ;






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

            $profileNP->nop_days = $request->input('nop_days');

            $profileNP->buyable_nop = $request->input('buyable_nop');


            $profileNP->last_working_day = $request->last_working_day;

            $profileNP->immediate_last_date = $request->input('immediate_last_date');

            $profileNP->user_id = $request->user_id;

            $profileNP->save();

        } else {

            $profileNP = new ProfileNop();

            $profileNP->nop_days = $request->input('nop_days');

            $profileNP->buyable_nop = $request->input('buyable_nop');

            if ($request->last_workiing_day) {

                $profileNP->last_working_day = $request->last_working_day;
            } else {
                $profileNP->last_working_day = '';
            }

            $profileNP->immediate_last_date = $request->input('immediate_last_date');

            $profileNP->user_id = $request->user_id;

            $profileNP->save();

        }

        return response()->json(array('success' => true, 'status' => 200), 200);

    }





    public function updatecurrentProfileJobCity($user_id, CompanyFrontRequest $request)
    {


        if (is_numeric($request->input('current_company'))) {

            $company_data_val = CompanyData::where('id', $request->input('current_company'))->first();

        } else {

            $company_data_val = new CompanyData();
            $company_data_val->name = $request->input('current_company');
            $company_data_val->save();

        }

        $profileNP = ProfileCityJobsCity::where('user_id', '=', $user_id)->first();

        if ($profileNP) {

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

        } else {

            $profileNP = new ProfileCityJobsCity();

            $profileNP->user_id = $user_id;

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





        /*         * ************************************ */

        return response()->json(array('success' => true, 'status' => 200), 200);

    }



    public function updatepreviousProfileJobCity($user_id, CompanyPreviousFrontRequest $request)
    {

        //  dd($request->input('previous_till_date'));

        if (is_numeric($request->input('previous_company'))) {

            $company_data_val = CompanyData::where('id', $request->input('previous_company'))->first();

        } else {

            $company_data_val = new CompanyData();
            $company_data_val->name = $request->input('previous_company');
            $company_data_val->save();

        }



        $profileNP = ProfileCityJobsCity::where('user_id', '=', $user_id)->first();



        //  $n_date=$profileNP->current_start_date;

        // dd($n_date);



        if ($profileNP->current_start_date) {

            $n_date = $profileNP->current_start_date;



        } else {



            $n_date = Carbon::now()->format('m-Y');

        }





        $profilegap = ProfileGap::where('user_id', $user_id)->first();

        // dd($profilegap);







        $gapti = '01-' . $request->input('previous_till_date') . '';





        $result = CarbonPeriod::create('01-' . $request->input('previous_till_date') . '', '1 month', '01-' . $n_date . '');



        $numItems = count($result);



        // dd($numItems);

        //  echo $numItems.'<br>';

        $i = 0;

        $ilast = count($result);

        // dd(count($result));

        foreach ($result as $key => $value) {

            if ($i == 0) {

                $first = $value->format("M-Y");

            }

            if ($i == $ilast - 1) {

                $last = $value->format("M-Y");

            }



            if (++$i === $numItems) {

                $data = $value->format("M-Y") . "<br>";



                $gaptid = '01-' . $data . '' . "<br>";



                $month = date("M", strtotime($gapti));





            }

        }



        //  dd(count($result));

        if (count($result) > 6) {

            if ($profilegap) {

                $profilegap->user_id = $user_id;

                $profilegap->gap_from_month = $first;

                $profilegap->gap_to_month = $last;



                $profilegap->save();

            } else {

                $profilegap = new ProfileGap();

                $profilegap->user_id = $user_id;

                $profilegap->gap_from_month = $first;

                $profilegap->gap_to_month = $last;



                $profilegap->save();

            }





        }



        $profileNP = ProfileCityJobsCity::where('user_id', '=', $user_id)->first();

        if ($profileNP) {

            $profileNP->user_id = $user_id;

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

            //



            $profileNP->save();

        } else {

            $profileNP = new ProfileCityJobsCity();

            $profileNP->user_id = $user_id;





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





        /*         * ************************************ */

        return response()->json(array('success' => true, 'status' => 200), 200);

    }



    public function updateProfileDetails($user_id, PreferencesRequest $request)
    {

        $profileNP = ProfileDetails::where('user_id', '=', $user_id)->first();

        if ($profileNP) {

            $profileNP->user_id = $user_id;

            $profileNP->shifts = $request->input('shifts');

            $profileNP->work_type = $request->input('work_type');

            $profileNP->contract_type = $request->input('contract_type');

            $profileNP->candidate_wfh = $request->input('work_option');

            $profileNP->case_of_contract = $request->input('case_of_contract');







            $profileNP->expecting_opportunities = $request->input('expecting_opportunities');

            $profileNP->expecting_payment = $request->input('expecting_payment');



            // $profileNP->telephonic_date_from = $request->input('telephonic_date_from');

            // $profileNP->video_date_from = $request->input('video_date_from');

            // $profileNP->video_date_to = $request->input('video_date_to');

            // $profileNP->video_time = $request->input('video_time');





            // $profileNP->night_time = $request->input('night_time');





            // $profileNP->expect_ctc_lakhs = $request->input('expect_ctc_lakhs');

            // $profileNP->expect_ctc_thousand = $request->input('expect_ctc_thousand');



            // $profileNP->expect_ctc_lakhs1 = $request->input('expect_ctc_lakhs1');

            // $profileNP->expect_ctc_thousand1 = $request->input('expect_ctc_thousand1');



            // $profileNP->expect_ctc_lakhs2 = $request->input('expect_ctc_lakhs2');

            // $profileNP->expect_ctc_thousand2 = $request->input('expect_ctc_thousand2');



            // $profileNP->expect_ctc_lakhs3 = $request->input('expect_ctc_lakhs3');

            // $profileNP->expect_ctc_thousand3 = $request->input('expect_ctc_thousand3');





            // $profileNP->night_interview = $request->input('night_interview');

            // $profileNP->night_telephonic_date_from = $request->input('night_telephonic_date_from');

            // $profileNP->night_telephonic_date_to = $request->input('night_telephonic_date_to');



            // $profileNP->night_telephonic_time_form = $request->input('night_telephonic_time_form');

            // $profileNP->night_telephonic_time_to = $request->input('night_telephonic_time_to');

            // $profileNP->night_video_time_from = $request->input('night_video_time_from');



            // $profileNP->night_video_time_to = $request->input('night_video_time_to');

            // $profileNP->bgv_name1 = $request->input('bgv_name1');

            // $profileNP->bgv_email1 = $request->input('bgv_email1');

            // $profileNP->bgv_mobile1 = $request->input('bgv_mobile1');

            // $profileNP->bgv_name2 = $request->input('bgv_name2');

            // $profileNP->bgv_email2 = $request->input('bgv_email2');

            // $profileNP->bgv_mobile2 = $request->input('bgv_mobile2');

            // $profileNP->pricing_details = $request->input('pricing_details');

            // $profileNP->pricing_type = $request->input('pricing_type');



            // $profileNP->visa_country = $request->input('visa_country');

            // $profileNP->visa_validity = $request->input('visa_validity');

            // $profileNP->wfo = $request->input('wfo');



            $profileNP->save();

        } else {

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

        }

        // $summary = $request->input('summary');

        // $ProfileSummary = new ProfileSummary();

        // $ProfileSummary->user_id = $user_id;



        /*         * ************************************ */

        return response()->json(array('success' => true, 'status' => 200), 200);

    }





    public function updateProfileCompensation($user_id, CompensationRequest $request)
    {



        //  return dd($request);

        $profileNP = ProfileDetails::where('user_id', '=', $user_id)->first();

        if ($profileNP) {

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

        } else {

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

        return response()->json(array('success' => true, 'status' => 200), 200);











    }

    public function updateProfileInterview($user_id, Request $request)
    {

        if ($request->video_interview == 2) {


            $this->validate(

                $request,
                [
                    'video_interview' => 'required',
                    'video_date_from' => 'required_if:video_interview,2',
                    'video_date_to' => 'required_if:video_interview,2',
                    'video_time' => 'required_if:video_interview,2',
                    'video_time_to' => 'required_if:video_interview,2',
                ],
                [

                    'video_date_from.required_if' => ' Video Date From is required',
                    'video_date_to.required_if' => ' Video Date To is required',
                    'video_time.required_if' => 'From Time is required',
                    'video_time_to.required_if' => 'To Time is required',
                    'video_interview.required_if' => 'Interview Availability is required'

                ]
            );

        }


        $profileNP = ProfileDetails::where('user_id', '=', $user_id)->first();

        if ($profileNP) {

            $profileNP->user_id = $user_id;

            $profileNP->video_interview = $request->input('video_interview');

            $profileNP->video_date_from = date("Y-m-d", strtotime($request->input('video_date_from'))) ?? '';

            $profileNP->video_date_to = date("Y-m-d", strtotime($request->input('video_date_to'))) ?? '';

            $profileNP->video_time = $request->input('video_time');

            $profileNP->video_time_to = $request->input('video_time_to');



            $profileNP->save();

        } else {

            $profileNP = new ProfileDetails();

            $profileNP->user_id = $user_id;

            $profileNP->video_interview = $request->input('video_interview');

            $profileNP->video_date_from = date("Y-m-d", strtotime($request->input('video_date_from'))) ?? '';

            $profileNP->video_date_to = date("Y-m-d", strtotime($request->input('video_date_to'))) ?? '';

            $profileNP->video_time = $request->input('video_time');

            $profileNP->video_time_to = $request->input('video_time_to');

            $profileNP->save();

        }



        /*         * ************************************ */

        return response()->json(array('success' => true, 'status' => 200), 200);

    }

    public function updateProfileNightInterview(Request $request, $id)
    {




        $this->validate(

            $request,
            [
                'night_telephonic_date_from' => 'required',

                'night_telephonic_date_to' => 'required',

                'night_time' => 'required'
            ],
            [

                'night_telephonic_date_from.required' => ' Night Date From is required',
                'night_telephonic_date_to.required' => ' Night Date To is required',
                'night_time.required' => ' Time is required',

            ]
        );



        $user = ProfileDetails::where('user_id', $id)->first();

        if ($user) {

            $user->user_id = $id;

            $user->night_time = $request->input('night_time');





            $night_from_date = date("Y-m-d", strtotime($request->input('night_telephonic_date_from')));

            $user->night_telephonic_date_from = $night_from_date;

            $night_to_date = date("Y-m-d", strtotime($request->input('night_telephonic_date_to')));

            $user->night_telephonic_date_to = $night_to_date;


            $user->save();

        } else {



            $user = new ProfileDetails();
            $user->user_id = $id;

            $user->night_time = $request->input('night_time');





            $night_from_date = date("Y-m-d", strtotime($request->input('night_telephonic_date_from')));

            $user->night_telephonic_date_from = $night_from_date;

            $night_to_date = date("Y-m-d", strtotime($request->input('night_telephonic_date_to')));

            $user->night_telephonic_date_to = $night_to_date;


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






    public function bulkuserupload(Request $request)
    {

        if ($request->hasFile('file')) {

            //  return dd('file'); 

            $this->validate(
                $request,
                ['file' => 'required'],
                [
                    'file.required' => 'Excel is required',



                ]
            );

        }

        //  Excel::import(new EducationImport,request()->file('file')); 

        Excel::import(new UsersImport, request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');

    }

    public function downloadstate()
    {



        if (Auth::check()) {

            return Excel::download(new StateExport(), 'user.csv');

        } else {

            return redirect('/');

        }

    }

    public function downloadcareerlevel()
    {



        if (Auth::check()) {

            return Excel::download(new CareerExport(), 'careers.csv');

        } else {

            return redirect('/');

        }

    }

    public function downloadindustry()
    {



        if (Auth::check()) {

            return Excel::download(new IndustryExport(), 'specilation.csv');

        } else {

            return redirect('/');

        }

    }

    public function downloaddegreetype()
    {



        if (Auth::check()) {

            return Excel::download(new DegreeTypeExport(), 'course.csv');

        } else {

            return redirect('/');

        }

    }

    public function downloadjobskills()
    {



        if (Auth::check()) {

            return Excel::download(new JobSkillsExport(), 'keyskills.csv');

        } else {

            return redirect('/');

        }

    }

    public function downloadlanguages()
    {



        if (Auth::check()) {

            return Excel::download(new LanguageExport(), 'id_details.csv');

        } else {

            return redirect('/');

        }

    }

    public function downloadcountry()
    {



        if (Auth::check()) {

            return Excel::download(new CountryExport(), 'country.csv');

        } else {

            return redirect('/');

        }

    }

    public function updateVerifications($user_id, Request $request)
    {



        $this->validate(

            $request,
            [



                'recruiter_comments' => 'required'



            ],
            [
                'recruiter_comments.required' => 'Recruiter Comments is required'
            ]


        );

        // return response()->json(array('message' => $user_id, 'status' => 200), 200);

        $user = User::where('id', $user_id)->first();


        $fileName = '';

        if ($request->hasFile('recorded_video')) {

            $cv_file = $request->file('recorded_video');

            $fileName = ImgUploader::UploadDoc('cvs', $cv_file, "recorded_video");

        } else {
            $fileName = '';
        }




        $user->recorded_video = $fileName;

        $user->recruiter_comments = $request->input('recruiter_comments');

        $user->recruiter_email = $request->input('recruiter_email');

        $user->recruiter_phone = $request->input('recruiter_phone');


        $user->save();



        return response()->json(array('success' => true, 'status' => 200), 200);



    }

    public function bulkresumeresponse(Request $request)
    {

        $data = $request->data;

        // return dd($request->all());

        return view('admin.user.response');

    }



    // public function storecertificate(Request $request)

    // {



    //     return "hello";

    // }

    /*     * ******************************************** */





    public function getProfilekeySkill(Request $request, $user_id)
    {

        $jobSkills = DataArrayHelper::defaultJobSkillsArray();

        $jobExperiences = DataArrayHelper::defaultJobExperiencesArray();



        $user = User::find($user_id);

        $returnHTML = view('admin.user.forms.skill.keyskill_modal')

            ->with('user', $user)

            ->with('jobSkills', $jobSkills)

            ->with('jobExperiences', $jobExperiences)

            ->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));





        // $returnHTML = view('admin.user.forms.skill.keyskill_modal')



        //         ->render();

        // return response()->json(array('success' => true, 'html' => $returnHTML));

    }





    public function storekeyskill(MajorSubjectFormRequest $request, $id)
    {




        if ($request->keyskills) {

            // dd($request->keyskills);


            $delete = KeySkill::where('user_id', $id)->get();

            // dd($delete);

            if ($delete) {


                foreach ($delete as $dele) {

                    $dele->delete();

                }

            }


            foreach ($request->keyskills as $keyskill) {

                $skills = jobSkill::where('id', $keyskill)->get();

                if (count($skills) > 0) {

                    $key_new = new KeySkill();

                    $key_new->user_id = $id;

                    $key_new->keyskill = $keyskill;

                    $key_new->save();


                } else {

                    $key_new = new JobSkill();

                    $key_new->job_skill = $keyskill;

                    $key_new->save();


                    $key_sk = new KeySkill();

                    $key_sk->user_id = $id;

                    $key_sk->keyskill = $key_new->id;

                    $key_sk->save();

                }
            }

            $user = User::where('id', $id)->first();

            $user->complete = $user->complete + 3;

            $user->profile_completion = $user->profile_completion + 2;

            $user->save();


            $returnHTML = view('admin.user.forms.skill.keyskill_thanks');

            return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);



        }



    }





    // public function storekeyskill(MajorSubjectFormRequest $request,$user_id)



    // {



    //     $tags = explode(",", $request->keyskill);



    //     foreach($tags as $tag){



    //         KeySkill::create([

    //           'user_id'=>$user_id,

    //         'keyskill' => $tag

    //     ]);

    //     }



    // // $request->validate([



    // // 'keyskill'=>'required'



    // // ]);



    // // $profiekeyskill=new KeySkill();

    // // $profiekeyskill->user_id=$user_id;

    // // $profiekeyskill->keyskill=$request->input('keyskill');

    // // $profiekeyskill->save();



    // $returnHTML = view('admin.user.forms.skill.keyskill_thanks')->render();

    //     return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);



    //     // $this->validate($request, [



    //     //     'keyskill' => 'required',

    //     // ]);



    // //     $input = $request->all();



    // //     $tags = explode(", ", $input['keyskill']);

    // //     $post = KeySkill::create([



    // // 'keyskill' => '$request'    



    // // ]);

    // //     $post->tag($tags);









    // //     $input = $request->all();

    // //     $tags = explode(", ", $request->input('keyskill'));

    // //     $post = KeySkill::create($input);

    // //     $post->tag($tags);





    // // $request->validate([



    // // 'keyskill'=>'required'



    // // ]);



    // // $profiekeyskill=new KeySkill();

    // // $profiekeyskill->user_id=$user_id;

    // // $profiekeyskill->keyskill=$request->input('keyskill');

    // // $profiekeyskill->save();



    // $returnHTML = view('admin.user.forms.skill.keyskill_thanks')->render();

    //     return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);



    // // $returnHTMl=view('admin.user.forms.skill.keyskill_thanks')->render();

    // // return response()->json(array('success' =>true,'status' =>200,'html' => $returnHTML),200);



    // }



    public function showProfileKeySkills(Request $request, $user_id)
    {

        $keyskill = KeySkill::where('user_id', $user_id)->get();

        // return dd($keyskill);

        $html = '<div class="panel-group">';



        foreach ($keyskill as $keyskill):







            $job_skill = \App\JobSkill::where('id', $keyskill->keyskill)->first();





            //  echo $job_skill->job_skill;







            $html .= '<div class="panel panel-info" id="skill_' . $keyskill->id . '">

    <div class="mt-element-ribbon bg-grey-steel">

    <div class="panel-body">

    <p class="text-left"><h5>' . $job_skill->job_skill . '</h5></p>

 

    </div>

  <a href="javascript:void(0);"  onclick="delete_profile_keyskill(' . $keyskill->id . ');"class="btn btn-danger">' . __('Delete') . '</a> </div>

  </div>';





        endforeach;





        echo $html . '</table></div>';











    }



    public function getProfilekeySkillEditForm(Request $request, $user_id)
    {

        $keyskill_id = $request->input('keyskill_id');

        $jobSkills = DataArrayHelper::defaultJobSkillsArray();

        $jobExperiences = DataArrayHelper::defaultJobExperiencesArray();



        $user = User::find($user_id);

        $keyskill = KeySkill::find($keyskill_id);

        $returnHTML = view('admin.user.forms.skill.keyskill_edit_modal')

            ->with('user', $user)

            ->with('jobSkills', $jobSkills)

            ->with('jobExperiences', $jobExperiences)

            ->with('keyskills', $keyskill)

            ->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));





        // $returnHTML = view('admin.user.forms.skill.keyskill_modal')



        //         ->render();

        // return response()->json(array('success' => true, 'html' => $returnHTML));

    }

    public function updatekeyskill(MajorSubjectFormRequest $request, $keyskill_id, $user_id)
    {







        $tags = explode(",", $request->keyskill);

        $keyskill = KeySkill::where('id', $keyskill_id)->first();



        foreach ($tags as $tag) {





            $keyskill->user_id = $request->user_id;

            $keyskill->keyskill = $tag;



        }







        // return dd($keyskill);

        // $keyskill->user_id=$user_id;

        // //$keyskill->tags()->sync($request->input('tag'));

        // //  $keyskill->keyskill=$request->input('keyskill');

        // $keyskill->keyskill=$request->tag($tags);







        $keyskill->update();



        $returnHTML = view('admin.user.forms.skill.keyskill_edit_modal_thanks')->render();

        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);







    }



    public function deletekeyskill(Request $request)
    {



        $id = $request->input('id');

        try {



            $keyskill = KeySkill::findorFail($id);

            $keyskill->delete();

            echo 'ok';



        } catch (ModelNotFoundException $e) {

            echo 'notok';

        }



    }



    public function updateOffers(Request $request, $user_id)
    {





        // return dd($request);

        $this->validate(
            $request,
            ['hold' => 'required'],
            ['hold.required' => ' Holding Employment offers is required']
        );



        if ($request->hold == '1') {


            $this->validate(
                $request,
                [
                    'expoff' => 'required|max:80',
                    'ctcoff1' => 'required|numeric|max:1000000',
                    'dateoff1' => 'required',
                    'locoff1' => 'required',
                ],
                [

                    'expoff.required' => ' Reason for exploring opportunities is required',
                    'ctcoff1.required' => ' CTC Offered is required',
                    'ctcoff1.max' => 'Maximum Length is 100',
                    'numeric.required' => 'CTC Offered must be a number',
                    'dateoff1.required' => ' Date of Joining is required',
                    'locoff1.required' => ' Location of Job Offer is required'
                ]

            );




        }



        $offers = Offers::where('user_id', '=', $user_id)->first();

        if ($offers) {





            $offers->user_id = $user_id;

            $offers->hold = $request->input('hold');

            $offers->expoff = $request->input('expoff');

            $offers->repoff = $request->input('repoff');

            $offers->ctcoff1 = $request->input('ctcoff1');

            $offers->dateoff1 = $request->input('dateoff1');

            $offers->locoff1 = $request->input('locoff1');

            if (isset($request->ctcoff)) {

                $offers->ctcoff = serialize($request->input('ctcoff'));

                $offers->dateoff = serialize($request->input('dateoff'));

                $offers->locoff = serialize($request->input('locoff'));

            } else {

                $offers->ctcoff = '';

                $offers->dateoff = '';

                $offers->locoff = '';

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





        } else {





            $offers = new Offers();



            $offers->create([

                'user_id' => $user_id,

                'hold' => $request->input('hold'),

                'expoff' => $request->input('expoff'),

                'repoff' => $request->input('repoff'),

                'ctcoff1' => $request->input('ctcoff1'),

                'dateoff1' => $request->input('dateoff1'),

                'locoff1' => $request->input('locoff1'),

                'ctcoff' => serialize($request->input('ctcoff')),

                'dateoff' => serialize($request->input('dateoff')),

                'locoff' => serialize($request->input('locoff'))



            ]);









        }





        /*         * ************************************ */

        return response()->json(array('success' => true, 'status' => 200), 200);

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

        $profileCv1 = User::where('id', $request->id)->first();

        $profileCv1->resume = '';

        $profileCv1->save();

        return back();

    }



    public function dbdatechange($date)
    {

        $date = date("Y-m-d", strtotime($date));

        return $date;

    }


    function fetchadmin(Request $request)
    {

        if ($request->get('query')) {

            $query = $request->get('query');

            $data = DB::table('job_skills')

                ->where('job_skill', 'LIKE', "%{$query}%")

                ->get();

            return response()->json($data);
            // return response()->json(['data'=> $data, 'query'=>$query]);

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

    function paymenthistory()
    {
        $users = User::all();
        return view('admin.user.users-payment', compact('users'));

    }

    function userpaymenthistory($id)
    {
        // dd($id);
        $user = User::where('id', $id)->first();
        return view('admin.user.userpayment', compact('user'));

    }





    public function storeInterview(REquest $request, $id)
    {

        // $d =  date("h:i:sa");
        $nowtime = date("g:i A");
        $todaydate = date("d-m-Y");
        // dd($nowtime);

        if ($request->date == $todaydate) {
            $this->validate(

                $request,
                [
                    'date' => 'required',
                    'from_time' => 'required|date_format:g:i A|after:' . $nowtime,
                    'to_time' => 'required|date_format:g:i A|after:from_time',

                ],
                [

                    'video_date_from.required' => ' Date is required',
                    'from_time.required' => 'From Time is required',
                    'to_time.required' => 'To Time is required'

                ]
            );

        } else {

            $this->validate(

                $request,
                [
                    'date' => 'required',
                    'from_time' => 'required|date_format:g:i A',
                    'to_time' => 'required|date_format:g:i A|after:from_time',


                ],
                [

                    'video_date_from.required' => ' Date is required',
                    'from_time.required' => 'From Time is required',
                    'to_time.required' => 'To Time is required'

                ]
            );

        }



        $user = new Interview();

        $user->user_id = $request->id;

        $user->date = $this->dbdatechange($request->date) ?? '';

        $user->from_time = $request->from_time;

        $user->to_time = $request->to_time;

        $user->save();



        $returnHTML = view('admin.user.forms.interview.interview_thanks')->render();

        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);


    }


    public function showInterview(Request $request, $user_id)
    {

        $user = User::find($user_id);

        $interviews = Interview::where('user_id', $user_id)->get();





        $html = '';

        if (isset($user)):

            foreach ($interviews as $interview):


                $html .= '<!--education Start-->

          <div class="col-md-12" id="education_' . $interview->id . '">

            <div class="mt-element-ribbon bg-grey-steel">

          

              <p class="ribbon-content">

                            

             <span>Date </span> : ' . $interview->date . ' <br />

             <span>From Time </span> : ' . $interview->from_time . '<br />

             <span>To Time </span> : ' . $interview->to_time . '<br /><br />

              <a href="javascript:void(0);" onclick="interview(' . $interview->id . ');" class="btn btn-warning">' . __('Edit') . '</a>

              <a href="javascript:void(0);" onclick="delete_interview(' . $interview->id . ');" class="btn btn-danger">' . __('Delete') . '</a>

              </p>

            </div>

          </div>

          <!--education End-->';

            endforeach;

        endif;



        echo $html;

    }


    public function getInterviewForm(Request $request, $user_id)
    {

        $user = User::find($user_id);

        $returnHTML = view('admin.user.forms.interview.interview_modal')

            ->with('user', $user)

            ->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));

    }

    public function deleteInterview(Request $request)
    {
        $in = Interview::where('id', $request->id)->delete();
        return 'ok';
    }

    public function getInterviewEditForm(Request $request, $user_id)
    {

        $interview_id = $request->input('interview_id');


        $interview = Interview::find($interview_id);

        $user = User::find($user_id);


        $returnHTML = view('admin.user.forms.interview.interview_edit_modal')

            ->with('user', $user)

            ->with('interview', $interview)

            ->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));

    }

    public function updateInterview(Request $request, $interview_id, $user_id)
    {



        // $d =  date("h:i:sa");
        $nowtime = date("g:i A");
        $todaydate = date("d-m-Y");
        // dd($nowtime);

        if ($request->date == $todaydate) {
            $this->validate(

                $request,
                [
                    'date' => 'required',
                    'from_time' => 'required|date_format:g:i A|after:' . $nowtime,
                    'to_time' => 'required|date_format:g:i A|after:from_time',

                ],
                [

                    'video_date_from.required' => ' Date is required',
                    'from_time.required' => 'From Time is required',
                    'to_time.required' => 'To Time is required'

                ]
            );

        } else {

            $this->validate(

                $request,
                [
                    'date' => 'required',
                    'from_time' => 'required|date_format:g:i A',
                    'to_time' => 'required|date_format:g:i A|after:from_time',


                ],
                [

                    'video_date_from.required' => ' Date is required',
                    'from_time.required' => 'From Time is required',
                    'to_time.required' => 'To Time is required'

                ]
            );

        }


        $inter = Interview::where('id', $interview_id)->first();

        $inter->date = $this->dbdatechange($request->date) ?? '';

        $inter->from_time = $request->from_time;

        $inter->to_time = $request->to_time;

        $inter->save();



        $returnHTML = view('admin.user.forms.interview.interview_edit_thanks')->render();

        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }

    public function downloadlatestcompany(Request $request)
    {
        if (Auth::check()) {

            return Excel::download(new LatestCompanyExport(), 'latestcompanydetails.csv');

        } else {

            return redirect('/');

        }

    }


    public function userSoftDelete(Request $request)
    {
        $user_id_array = $request->input('id');
        // dd($user_id_array);


        foreach ($user_id_array as $user) {
            $user = User::where('id', $user)->first();
            $user->hide_show = 1;
            $user->save();
            // dd($user);
        }

        echo 'ok';


    }

    public function hidedUsersList()
    {
        return view('admin.user.hideusers');
    }

    public function fetchHideUsersData(Request $request)
    {

        $users = User::select(

            [

                'users.id',

                'users.first_name',

                'users.middle_name',

                'users.last_name',

                'users.email',

                'users.password',

                'users.phone',

                'users.country_id',

                'users.state_id',

                'users.city_id',

                'users.is_immediate_available',

                'users.num_profile_views',

                'users.is_active',

                'users.verified',

                'users.created_at',

                'users.updated_at',

                'users.added',

                'users.added_by',



            ]
        )->where('hide_show', 1);

        if (Auth::user()->role_id == 2) {
            $users = $users->where('added_by', Auth::user()->id);
        }


        return Datatables::of($users)

            ->filter(function ($query) use ($request) {

                if ($request->has('id') && !empty ($request->id)) {

                    $query->where('users.id', 'like', "{$request->get('id')}");

                }

                if ($request->has('name') && !empty ($request->name)) {

                    $query->where(function ($q) use ($request) {

                        $q->where('users.first_name', 'like', "%{$request->get('name')}%")

                            ->orWhere('users.middle_name', 'like', "%{$request->get('name')}%")

                            ->orWhere('users.last_name', 'like', "%{$request->get('name')}%");

                    });

                }

                if ($request->has('email') && !empty ($request->email)) {

                    $query->where('users.email', 'like', "%{$request->get('email')}%");

                }

            })

            ->addColumn('name', function ($users) {

                return $users->first_name . ' ' . $users->middle_name . ' ' . $users->last_name;

            })





            ->addColumn('action', function ($users) {

                /*                             * ************************* */

                $active_txt = 'Make Active';

                $active_href = 'make_active(' . $users->id . ');';

                $active_icon = 'square-o';

                if ((int) $users->is_active == 1) {

                    $active_txt = 'Make InActive';

                    $active_href = 'make_not_active(' . $users->id . ');';

                    $active_icon = 'check-square-o';

                }

                /*                             * ************************* */

                /*                             * ************************* */

                $verified_txt = 'Not Verified';

                $verified_href = 'make_verified(' . $users->id . ');';

                $verified_icon = 'square-o';

                if ((int) $users->verified == 1) {

                    $verified_txt = 'Verified';

                    $verified_href = 'make_not_verified(' . $users->id . ');';

                    $verified_icon = 'check-square-o';

                }

                /*                             * ************************* */

                return '

                <div class="btn-group">

                    <button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action

                        <i class="fa fa-angle-down"></i>

                    </button>

                    <ul class="dropdown-menu">

                        <li>

                            <a href="' . route('edit.user', ['id' => $users->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>

                        </li>                       

                        <li>

                            <a href="javascript:void(0);" onclick="delete_user(' . $users->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>

                        </li>

                        <li>

                        <a href="javascript:void(0);" onClick="' . $active_href . '" id="onclick_active_' . $users->id . '"><i class="fa fa-' . $active_icon . '" aria-hidden="true"></i>' . $active_txt . '</a>

                        </li>

                        <li>

                        <a href="javascript:void(0);" onClick="' . $verified_href . '" id="onclick_verified_' . $users->id . '"><i class="fa fa-' . $verified_icon . '" aria-hidden="true"></i>' . $verified_txt . '</a>

                        </li>   
                        <li>

                        <a href="' . route('user.payment.history', ['id' => $users->id]) . '"><i class="fa fa-trash-o" aria-hidden="true"></i>Payment History</a>

                        </li>                                                                                                                                                       

                    </ul>

                </div>';

            })

            ->addColumn('created_at', function ($users) {

                return ($users->created_at)->format('d-m-Y');

            })

            ->addColumn('updated_at', function ($users) {

                return ($users->updated_at)->format('d-m-Y');

            })

            ->addColumn('added', function ($users) {

                return ((bool) $users->added) ? 'Admin' : 'Candidate';

            })

            ->addColumn('verify', function ($users) {

                return ((bool) $users->verified) ? 'Verified' : 'Not Verified';

            })

            ->addColumn('checkbox', '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="{{$id}}" />')
            ->rawColumns(['action', 'name', 'checkbox'])

            ->setRowId(function ($users) {

                return 'user_dt_row_' . $users->id;

            })

            ->make(true);

    }

    public function restoredUsersList(Request $request)
    {
        $user_id_array = $request->input('id');

        foreach ($user_id_array as $user) {
            $user = User::where('id', $user)->first();
            $user->hide_show = 0;
            $user->save();
            // dd($user);
        }

        echo 'ok';

    }




    public function sendbulkemailusers(Request $request)
    {

        // return dd($request->all());
        // $emails = $request->users;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',

            'subject' => 'required',
            'description' => 'required',
        ], [
            'user_id.required' => '
                     Note: Choose at least one candidate to send email.',

            'subject.required' => 'Subject is required',

        ]);


        if ($validator->passes()) {



            $emails = $request->user_id;

            $emails = (implode(",", $emails));
            $email = (explode(",", $emails));

            if (isset($email)) {

                $users = User::whereIn('id', $email)->get();
                // return dd($companys);


                // return dd($data);
                // send all mail in the queue.
                foreach ($users as $user) {

                    // foreach ($users as $user_mail) {
                    $data = array(
                        'heading' => $request->subject,
                        'message1' => $request->description,
                        'username' => $user->name,
                        'usermail' => $user->email,
                        'email' => $user->email
                    );

                    $usermail = "info@zeronoticeperiod.com";
                    $name = "ZeroNoticePeriod";


                    Mail::send('emails.template2', $data, function ($message) use ($data, $user, $usermail, $name) {
                        $message->from($usermail, $name);
                        $message->bcc($user->email);
                        $message->subject($data["heading"]);
                    });
                }


                return response()->json(array('success' => true, 'status' => 200), 200);
            }
        }
        return response()->json(['errors' => $validator->errors()]);



    }






}







