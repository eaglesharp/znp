<?php



namespace App\Traits;



use App\Unlocked_users;
use Auth;

use DB;

use Input;

use Redirect;

use Carbon\Carbon;

use App\Job;

use App\PostJob;

use App\Company;

use App\JobSkill;

use App\JobSkillManager;

use App\Country;

use App\CountryDetail;

use App\State;

use App\City;

use App\CareerLevel;

use App\FunctionalArea;

use App\JobType;

use App\JobShift;

use App\Gender;

use App\JobExperience;

use App\DegreeLevel;

use App\SalaryPeriod;

use App\Helpers\MiscHelper;

use App\Helpers\DataArrayHelper;

use App\Http\Requests;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests\JobFormRequest;

use App\Http\Requests\Front\JobFrontFormRequest;

use App\Http\Controllers\Controller;

use App\Traits\Skills;

use App\Events\JobPosted;
use App\JobApply;
use Illuminate\Support\Str;

use ImgUploader;




trait JobTrait

{



    use Skills;



    public function deleteJob(Request $request)

    {

        $id = $request->input('id');

        try {

            $job = PostJob::findOrFail($id);

            JobSkillManager::where('job_id', '=', $id)->delete();

            JobApply::where('job_id', '=', $id)->delete();
            
            $job->delete();

            return 'ok';

        } catch (ModelNotFoundException $e) {

            return 'notok';

        }

    }



    private function updateFullTextSearch($job,$request)

    {
        //  dd($request->location);
                // Step 1: Unserialize the data
     //   $data = unserialize($request->location);

        // if($request->location)
        // {
        //      $values = array_values($request->location);
        //  }else{
        //     $values = '';
        //  }

        $values = $request->location?$request->location:NULL;
        $result = $values?implode(' ', $values):'';

      
        $str = '';

        $str .= ' ' . $job->job_title;

        $str .= ' ' . $job->location;

        $str .= ' ' . $request->experience;

        $str .= $job->getJobSkillsStr();

        $str .= $result;

        $str .= ' ' . $request->job_type;

        $str .= ' ' . $request->job_shift;

        $str .= ' ' . $job->work_mode;

        $job->search = $str;

        $job->update();

    }



    private function assignJobValues($job, $request)

    {
       // dd($request->all());

        $job->job_title = $request->input('job_title');

        $job->duration = $request->input('duration');

        $job->work_mode = $request->input('work_mode');

        $job->job_type = $request->input('job_type');

        $job->job_shift = $request->input('job_shift');

        $job->experience = $request->input('experience');

        $job->no_of_openings = $request->input('no_of_openings');

         $job->location = $request->input('location') ? serialize($request->input('location')) :  NULL;

        $job->min_salary = $request->input('min_salary');

        $job->max_salary = $request->input('max_salary');

        $job->job_description = $request->input('job_description');

        $job->job_overview = $request->input('job_overview');

        $job->roles_responsibility = $request->input('roles_responsibility');

        $job->website_address = $request->input('website_address');

         // Storing interview mode checkboxes as a serialized array
        $interviewModes = $request->input('interview_modes', []);
        $job->interview_modes = implode(',', $interviewModes); // Convert array to a comma-separated string

        // Storing walkin details if walkin mode is selected
        if (in_array('Walkin', $interviewModes)) {
            $job->walkin_date = $request->input('walkin_date');
            $job->walkin_time = $request->input('walkin_time');
            $job->walkin_venue = $request->input('walkin_venue');
            $job->walkin_contact = $request->input('walkin_contact');
        }


        return $job;

    }



    public function createJob()

    {

        $companies = DataArrayHelper::companiesArray();

        $countries = DataArrayHelper::defaultCountriesArray();

        $currencies = DataArrayHelper::currenciesArray();

        $careerLevels = DataArrayHelper::defaultCareerLevelsArray();

        $functionalAreas = DataArrayHelper::defaultFunctionalAreasArray();

        $jobTypes = DataArrayHelper::defaultJobTypesArray();

        $jobShifts = DataArrayHelper::defaultJobShiftsArray();

        $genders = DataArrayHelper::defaultGendersArray();

        $jobExperiences = DataArrayHelper::defaultJobExperiencesArray();

        $jobSkills = DataArrayHelper::defaultJobSkillsArray();

        $degreeLevels = DataArrayHelper::defaultDegreeLevelsArray();

        $salaryPeriods = DataArrayHelper::defaultSalaryPeriodsArray();

        $jobSkillIds = array();

        return view('admin.job.add')

                        ->with('companies', $companies)

                        ->with('countries', $countries)

                        ->with('currencies', array_unique($currencies))

                        ->with('careerLevels', $careerLevels)

                        ->with('functionalAreas', $functionalAreas)

                        ->with('jobTypes', $jobTypes)

                        ->with('jobShifts', $jobShifts)

                        ->with('genders', $genders)

                        ->with('jobExperiences', $jobExperiences)

                        ->with('jobSkills', $jobSkills)

                        ->with('jobSkillIds', $jobSkillIds)

                        ->with('degreeLevels', $degreeLevels)

                        ->with('salaryPeriods', $salaryPeriods);

    }



    public function storeJob(JobFormRequest $request)

    {
     //   dd($request->all());

        $job = new Job();

        $job->company_id = $request->input('company_id');

        $job = $this->assignJobValues($job, $request);

        $job->is_active = $request->input('is_active');

        $job->is_featured = $request->input('is_featured');

        $job->save();

        /*         * ******************************* */

        $job->slug = Str::slug($job->title, '-') . '-' . $job->id;

        /*         * ******************************* */

        $job->update();

        /*         * ************************************ */

        /*         * ************************************ */

        $this->storeJobSkills($request, $job->id);

        /*         * ************************************ */

        $this->updateFullTextSearch($job);

        /*         * ************************************ */

        flash('Job has been added!')->success();

        return \Redirect::route('edit.job', array($job->id));

    }



    public function editJob($id)

    {

        $companies = DataArrayHelper::companiesArray();

        $countries = DataArrayHelper::defaultCountriesArray();

        $currencies = DataArrayHelper::currenciesArray();

        $careerLevels = DataArrayHelper::defaultCareerLevelsArray();

        $functionalAreas = DataArrayHelper::defaultFunctionalAreasArray();

        $jobTypes = DataArrayHelper::defaultJobTypesArray();

        $jobShifts = DataArrayHelper::defaultJobShiftsArray();

        $genders = DataArrayHelper::defaultGendersArray();

        $jobExperiences = DataArrayHelper::defaultJobExperiencesArray();

        $jobSkills = DataArrayHelper::defaultJobSkillsArray();

        $degreeLevels = DataArrayHelper::defaultDegreeLevelsArray();

        $salaryPeriods = DataArrayHelper::defaultSalaryPeriodsArray();



        $job = Job::findOrFail($id);

        $jobSkillIds = $job->getJobSkillsArray();

        return view('admin.job.edit')

                        ->with('companies', $companies)

                        ->with('countries', $countries)

                        ->with('currencies', array_unique($currencies))

                        ->with('careerLevels', $careerLevels)

                        ->with('functionalAreas', $functionalAreas)

                        ->with('jobTypes', $jobTypes)

                        ->with('jobShifts', $jobShifts)

                        ->with('genders', $genders)

                        ->with('jobExperiences', $jobExperiences)

                        ->with('jobSkills', $jobSkills)

                        ->with('jobSkillIds', $jobSkillIds)

                        ->with('degreeLevels', $degreeLevels)

                        ->with('salaryPeriods', $salaryPeriods)

                        ->with('job', $job);

    }



    public function updateJob($id, JobFormRequest $request)

    {

        $job = Job::findOrFail($id);

        $job->company_id = $request->input('company_id');

        $job = $this->assignJobValues($job, $request);

        $job->is_active = $request->input('is_active');

        $job->is_featured = $request->input('is_featured');



        /*         * ******************************* */

        $job->slug = Str::slug($job->title, '-') . '-' . $job->id;

        /*         * ******************************* */



        /*         * ************************************ */

        $job->update();

        /*         * ************************************ */

        $this->storeJobSkills($request, $job->id);

        /*         * ************************************ */

        $this->updateFullTextSearch($job);

        /*         * ************************************ */

        flash('Job has been updated!')->success();

        return \Redirect::route('edit.job', array($job->id));

    }



    /*     * *************************************** */

    /*     * *************************************** */



    public function createFrontJob()

    {

        $company = Auth::guard('company')->user();

		

		if ((bool)$company->is_active === false) {

            flash(__('Your account is inactive contact site admin to activate it'))->error();

            return \Redirect::url('/');

            exit;

        }

      
		if((bool)config('company.is_company_package_active')){

			if(

				($company->package_end_date === null) || 

				($company->package_end_date->lt(Carbon::now())) ||

				($company->jobs_quota <= $company->availed_jobs_quota)

				)

			{

				flash(__('Please subscribe to package first'))->error();

				return \Redirect::url('/');

				exit;

			}

		}

        

		$countries = DataArrayHelper::langCountriesArray();

        $currencies = DataArrayHelper::currenciesArray();

        $careerLevels = DataArrayHelper::langCareerLevelsArray();

        $functionalAreas = DataArrayHelper::langFunctionalAreasArray();

        $jobTypes = DataArrayHelper::langJobTypesArray();

        $jobShifts = DataArrayHelper::langJobShiftsArray();

        $genders = DataArrayHelper::langGendersArray();

        $jobExperiences = DataArrayHelper::langJobExperiencesArray();

        $jobSkills = DataArrayHelper::langJobSkillsArray();

        $degreeLevels = DataArrayHelper::langDegreeLevelsArray();

        $salaryPeriods = DataArrayHelper::langSalaryPeriodsArray();



        $jobSkillIds = array();

        return view('job.add_edit_job')

                        ->with('countries', $countries)

                        ->with('currencies', array_unique($currencies))

                        ->with('careerLevels', $careerLevels)

                        ->with('functionalAreas', $functionalAreas)

                        ->with('jobTypes', $jobTypes)

                        ->with('jobShifts', $jobShifts)

                        ->with('genders', $genders)

                        ->with('jobExperiences', $jobExperiences)

                        ->with('jobSkills', $jobSkills)

                        ->with('jobSkillIds', $jobSkillIds)

                        ->with('degreeLevels', $degreeLevels)

                        ->with('salaryPeriods', $salaryPeriods);

    }


    public function myFrontJob()
    {

        $company = Auth::guard('company')->user();        

        $jobs = PostJob::withCount('appliedUsers')->where('company_id',$company->id)->latest()->get();

      
        return view('company.job.postjob-listing')

        ->with('jobs', $jobs);


    }

    public function makeActiveJob(Request $request)
    {
        $user = PostJob::find($request->job_id);
        $user->status = $request->status;   
        $user->save();
        if($user->status == 1)
        {
            return response()->json(['success'=>'Job Activated successfully.']);
        }else{
            return response()->json(['success'=>'Job InActive successfully.']);

        }
      
        
    }



    public function storeFrontJob(JobFrontFormRequest $request)

    {
       
      ///  dd($request->all());
        

        $company = Auth::guard('company')->user();
        

        
        $job = new PostJob();

        $job->company_id = $company->id;

        $job = $this->assignJobValues($job, $request);

        $job->save();

        /*         * ******************************* */

        $job->slug = Str::slug($job->job_title, '-') . '-' . $job->id;

        /*         * ******************************* */

        $job->update();

        /*         * ************************************ */

        /*         * ************************************ */

        $this->storeJobSkills($request, $job->id);

        /*         * ************************************ */

        $this->updateFullTextSearch($job,$request);

        /*         * ************************************ */



        /*         * ******************************* */

     //   $company->availed_jobs_quota = $company->availed_jobs_quota + 1;

     if ($request->hasFile('logo')) {

        $is_deleted = $this->deleteCompanyLogo($company->id);

        $image = $request->file('logo');

        $fileName = ImgUploader::UploadImage('company_logos', $image, $request->input('name'), 300, 300, false);

        $company->logo = $fileName;

    }else{

        $company->logo = $company->logo;

    }

        $company->description = $request->description;

        $company->location = $request->locality;

        $company->website = $request->website_address;

        $company->update();

        /*         * ******************************* */


      //  event(new JobPosted($job));

    

        flash('Job has been added!')->success();

       // return view('job.list');

        return \Redirect::route('my-jobs')->with('message','Job Created Successfully');

    }


    public function clonestoreFrontJob(JobFrontFormRequest $request)

    {
       
       // dd($request->all());
        

        $company = Auth::guard('company')->user();
        

        
        $job = new PostJob();

        $job->company_id = $company->id;

        $job = $this->assignJobValues($job, $request);

        $job->save();

        /*         * ******************************* */

        $job->slug = Str::slug($job->job_title, '-') . '-' . $job->id;

        /*         * ******************************* */

        $job->update();

        /*         * ************************************ */

        /*         * ************************************ */

        $this->storeJobSkills($request, $job->id);

        /*         * ************************************ */

        $this->updateFullTextSearch($job,$request);

        /*         * ************************************ */



        /*         * ******************************* */

     //   $company->availed_jobs_quota = $company->availed_jobs_quota + 1;

     if ($request->hasFile('logo')) {

        $is_deleted = $this->deleteCompanyLogo($company->id);

        $image = $request->file('logo');

        $fileName = ImgUploader::UploadImage('company_logos', $image, $request->input('name'), 300, 300, false);

        $company->logo = $fileName;

    }else{

        $company->logo = $company->logo;

    }

        $company->description = $request->description;

        $company->location = $request->locality;

        $company->website = $request->website_address;

        $company->update();

        /*         * ******************************* */


      //  event(new JobPosted($job));

    

        flash('Job has been added!')->success();

       // return view('job.list');

        return \Redirect::route('my-jobs')->with('message','Job Created Successfully');

    }



    public function editFrontJob($id)

    {   


        $jobSkills = DataArrayHelper::langJobSkillsArray();

      

        $job = PostJob::findOrFail($id);

        
    

        $jobSkillIds = $job->getJobSkillsArray();

      

        $result = [];

        foreach ($jobSkillIds as $value) {
            if (isset($jobSkills[$value])) {
                $result[$value] = $jobSkills[$value];
            } else {
                $result[$value] = null; // or any default value if the key doesn't exist in $array2
            }
        }

     
        function is_serialized($data) {
            // If $data is not a string, it cannot be serialized
            if (!is_string($data)) {
                return false;
            }
        
            // Remove white spaces from the data
            $data = trim($data);
        
            // If $data is empty, it cannot be serialized
            if ($data === '') {
                return false;
            }
        
            // Check if the data is serialized by unserializing it and checking for errors
            $unserialized_data = @unserialize($data);
        
            // If there were no errors during unserialization, then $data is serialized
            return $unserialized_data !== false;
        }
        
        try {
            // Check if the data is serialized before calling unserialize
            if (is_serialized($job->location)) {
                $locationresult = unserialize($job->location);
                // Use $locationresult as needed
            } else {

                $locationresult ="";
                // Handle the case where the data is not serialized
                // For example, you might set $locationresult to a default value or an empty array
                // $locationresult = some_default_value;
            }
        } catch (ErrorException $e) {
            // Handle any other errors that might occur during unserialize
            // For example, log the error or set $locationresult to a default value
            // $locationresult = some_default_value;
        }


     

        return view('company.job.edit-post-job')

                

                        ->with('jobSkills', $jobSkills)

                        ->with('jobSkillIds', $jobSkillIds)

                        ->with('resultdata', $result)

                        ->with('locationresult', $locationresult)

                        ->with('job', $job);

    }

    public function cloneFrontJob($id)

    {   


        $jobSkills = DataArrayHelper::langJobSkillsArray();      

        $job = PostJob::findOrFail($id);           

        $jobSkillIds = $job->getJobSkillsArray();      

        $result = [];

        foreach ($jobSkillIds as $value) {
            if (isset($jobSkills[$value])) {
                $result[$value] = $jobSkills[$value];
            } else {
                $result[$value] = null; // or any default value if the key doesn't exist in $array2
            }
        }
     
        function is_serialized($data) {
            // If $data is not a string, it cannot be serialized
            if (!is_string($data)) {
                return false;
            }
        
            // Remove white spaces from the data
            $data = trim($data);
        
            // If $data is empty, it cannot be serialized
            if ($data === '') {
                return false;
            }
        
          
            $unserialized_data = @unserialize($data);
        
         
            return $unserialized_data !== false;
        }   
        
        try {
           
            if (is_serialized($job->location)) {
                $locationresult = unserialize($job->location);
              
            } else {

                $locationresult ="";
              
            }
        } catch (ErrorException $e) {
           
        }

       

        return view('company.job.clone-post-job')

                

                        ->with('jobSkills', $jobSkills)

                        ->with('jobSkillIds', $jobSkillIds)

                        ->with('resultdata', $result)

                        ->with('locationresult', $locationresult)

                        ->with('job', $job);

    }



    public function updateFrontJob($id, JobFrontFormRequest $request)

    {
       
      //  dd($request->all());
        $job = PostJob::findOrFail($id);

		$job = $this->assignJobValues($job, $request);

        /*         * ******************************* */

        $job->slug = Str::slug($job->job_title, '-') . '-' . $job->id;

        /*         * ******************************* */



        /*         * ************************************ */

        $job->update();

        /*         * ************************************ */

        $this->storeJobSkills($request, $job->id);

        /*         * ************************************ */

        $this->updateFullTextSearch($job,$request);

        /*         * ************************************ */

        $company = Auth::guard('company')->user();
        $company->description = $request->description;
        $company->website = $request->website_address;
        $company->location = $request->locality;


        $company->update();

        flash('Job has been updated!')->success();

        return \Redirect::route('my-jobs')->with('message','Job Updated Successfully');

        

    }



    public static function countNumJobs($field = 'title', $value = '')
    {
        if (!empty($value)) {
            if ($field == 'title') {
                return DB::table('jobs')->where('title', 'like', $value)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'company_id') {
                return DB::table('jobs')->where('company_id', '=', $value)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'industry_id') {
                $company_ids = Company::where('industry_id', '=', $value)->where('is_active', '=', 1)->pluck('id')->toArray();
                return DB::table('jobs')->whereIn('company_id', $company_ids)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'job_skill_id') {
                $job_ids = JobSkillManager::where('job_skill_id', '=', $value)->pluck('job_id')->toArray();
                return DB::table('jobs')->whereIn('id', array_unique($job_ids))->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'functional_area_id') {
                return DB::table('jobs')->where('functional_area_id', '=', $value)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'careel_level_id') {
                return DB::table('jobs')->where('careel_level_id', '=', $value)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'job_type_id') {
                return DB::table('jobs')->where('job_type_id', '=', $value)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'job_shift_id') {
                return DB::table('jobs')->where('job_shift_id', '=', $value)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'gender_id') {
                return DB::table('jobs')->where('gender_id', '=', $value)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'degree_level_id') {
                return DB::table('jobs')->where('degree_level_id', '=', $value)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'job_experience_id') {
                return DB::table('jobs')->where('job_experience_id', '=', $value)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'country_id') {
                return DB::table('jobs')->where('country_id', '=', $value)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'state_id') {
                return DB::table('jobs')->where('state_id', '=', $value)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
            if ($field == 'city_id') {
                return DB::table('jobs')->where('city_id', '=', $value)->where('is_active', '=', 1)->where('expiry_date', '>',  \Carbon\Carbon::now())->count('id');
            }
        }
    }



    public function scopeNotExpire($query)

    {

        return $query->whereDate('expiry_date', '>', Carbon::now()); //where('expiry_date', '>=', date('Y-m-d'));

    }

    

    public function isJobExpired()

    {

        return ($this->expiry_date < Carbon::now())? true:false;

    }

    public function viewApplicants($id)
    {       
             
        $jobs = JobApply::with('user')->where('job_id', $id)->latest()->paginate(5);
        $job = PostJob::where('id', $id)->first();
        $unlocked_cvs = optional(Unlocked_users:: where('company_id',$job->company_id)
        ->where('created_at', '>=', now()->subDays(30))
        ->pluck('unlocked_users_ids'))->toarray();

        return view('company.job.view-applicant')
                        ->with('jobs', $jobs)
                        ->with('unlocked_cvs', $unlocked_cvs)
                        ->with('jobData', $job);
    }
}

