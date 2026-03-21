<?php

namespace App\Http\Controllers\Job;

use Auth;
use DB;
use Input;
use Redirect;
use Carbon\Carbon;
use App\Job;
use App\JobApply;
use App\FavouriteJob;
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
use App\ProfileCv;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\JobFormRequest;
use App\Http\Requests\Front\ApplyJobFormRequest;
use App\Http\Controllers\Controller;
use App\Traits\FetchJobs;
use App\Events\JobApplied;


use App\PostJob;

class JobController extends Controller
{

    //use Skills;
    use FetchJobs;

    private $functionalAreas = '';
    private $countries = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['jobs', 'jobDetail']]);

        $this->functionalAreas = DataArrayHelper::langFunctionalAreasArray();
        $this->countries = DataArrayHelper::langCountriesArray();
    }

    // dd($request->all());

    public function jobs(Request $request)
    {
        
        // Retrieve the filter parameters from the request
        $searchfield = $request->input('searchfield');
        $locationFilter = $request->input('location');
        $experienceFilter = $request->input('experience');
        $jobtitle = $request->input('jobtitle');

        // Start with the base query for fetching jobs
        $query =  PostJob::with('company')->with('jobSkills')->status()->latest();

        // Retrieve all job titles
        $titles = $query->pluck('job_title')->toArray();;
        $titles = array_unique($titles);

        $search = array_filter(array_map('strtolower', array_map('trim', explode(',', $request->searchfield))));

       
          // Apply the filters to the query if valid values are provided
          if ($searchfield && $searchfield !== 'searchfield') {
            $query->where(function ($query) use ($search) {
                foreach ($search as $keyword) {
                    if($keyword == 'contract'){
                        $query->where('job_type',$keyword);
                    }else{
                        $query->orWhere('search', 'LIKE', '%' . strtolower($keyword) . '%');
                    }
                   
                }
            });
        }
       

        // Apply the filters to the query if valid values are provided
        if ($jobtitle && $jobtitle !== 'jobtitle') {
            $query->where('job_title', $jobtitle);
        }
       

      if ($locationFilter == "Any") {
            // No filter applied, return all values

        } elseif ($locationFilter == "metro") { 

            $query->where(function ($query) use ($locationFilter) {
                $query->whereIn('location', ['Bangalore', 'Bengaluru','Chennai','Hyderabad','Mumbai','Delhi','Kolkata']);
            });

        } elseif ($locationFilter) {
            $query->Where('search', 'LIKE', '%' . strtolower($locationFilter) . '%');
        }
            
            
        

        if ($experienceFilter && $experienceFilter !== 'Select Experience') {
            // Assuming you have a column named 'experience' in your 'post_jobs' table
            $query->where('experience', $experienceFilter);
        }

         // Fetch the filtered jobs with pagination
        $jobs = $query->paginate(30);
      

        if ($request->ajax()) {
           
            // If it's an AJAX request, return the rendered view for updating the frontend
            return view('job.job_result', compact('jobs'))->render();
        }

        $companies = Company::whereNotNull('logo')
        ->select('logo')
        ->latest()
        ->take(9)
        ->get();
        
        //dd($jobs); 
    

        // If it's a regular request, return the view with the jobs data
        return view('job.job-new', compact('jobs','titles','companies'));
    }

    public function jobDetail(Request $request, $job_slug)
    {


       

        


       // $job = PostJob::
        $job =  PostJob::with('company')->with('jobSkills')->where('slug', 'like', $job_slug)->firstOrFail();
       
        $job_skill_ids = (array) $job->getJobSkillsArray();

        $jobskills = JobSkill::whereIn('id',$job_skill_ids)->select('job_skill')->get();

      
        return view('job.detail')
                        ->with('job', $job)
                        ->with('jobskills', $jobskills);                     
    }

    /*     * ************************************************** */

    public function addToFavouriteJob(Request $request, $job_slug)
    {
        $data['job_slug'] = $job_slug;
        $data['user_id'] = Auth::user()->id;
        $data_save = FavouriteJob::create($data);
        flash(__('Job has been added in favorites list'))->success();
        return \Redirect::route('job.detail', $job_slug);
    }

    public function removeFromFavouriteJob(Request $request, $job_slug)
    {
        $user_id = Auth::user()->id;
        FavouriteJob::where('job_slug', 'like', $job_slug)->where('user_id', $user_id)->delete();

        flash(__('Job has been removed from favorites list'))->success();
        return \Redirect::route('job.detail', $job_slug);
    }

    public function applyJob(Request $request, $job_slug)
    {
        $user = Auth::user();
        $job = Job::where('slug', 'like', $job_slug)->first();
        
        if ((bool)$user->is_active === false) {
            flash(__('Your account is inactive contact site admin to activate it'))->error();
            return \Redirect::route('job.detail', $job_slug);
            exit;
        }
        
        if ((bool) config('jobseeker.is_jobseeker_package_active')) {
            if (
                    ($user->jobs_quota <= $user->availed_jobs_quota) ||
                    ($user->package_end_date->lt(Carbon::now()))
            ) {
                flash(__('Please subscribe to package first'))->error();
                return \Redirect::route('home');
                exit;
            }
        }
        if ($user->isAppliedOnJob($job->id)) {
            flash(__('You have already applied for this job'))->success();
            return \Redirect::route('job.detail', $job_slug);
            exit;
        }
        
        

        $myCvs = ProfileCv::where('user_id', '=', $user->id)->pluck('title', 'id')->toArray();

        return view('job.apply_job_form')
                        ->with('job_slug', $job_slug)
                        ->with('job', $job)
                        ->with('myCvs', $myCvs);
    }

    public function postApplyJob(ApplyJobFormRequest $request)
    {
      
        $user = Auth::user();
        $user_id = $user->id;
        $job = PostJob::where('id', $request->job_id)->first();

        $jobApply = new JobApply();
        $jobApply->user_id = $user_id;
        $jobApply->job_id = $job->id;       
        $jobApply->coverletter = $request->post('coverletter');
        $jobApply->save();

        event(new JobApplied($job, $jobApply));

        return response()->json(['success']);

     
    }

    public function myJobApplications(Request $request)
    {
        $myAppliedJobIds = Auth::user()->getAppliedJobIdsArray();        
        $jobs = PostJob::whereIn('id', $myAppliedJobIds)->latest()->paginate(10);
     
     
        return view('job.my_applied_jobs')
                        ->with('jobs', $jobs);
    }
 

    public function myFavouriteJobs(Request $request)
    {
        $myFavouriteJobSlugs = Auth::user()->getFavouriteJobSlugsArray();
        $jobs = Job::whereIn('slug', $myFavouriteJobSlugs)->paginate(10);
        return view('job.my_favourite_jobs')
                        ->with('jobs', $jobs);
    }

}
