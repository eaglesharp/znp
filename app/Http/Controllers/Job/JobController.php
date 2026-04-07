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
        // $this->middleware('auth', ['except' => ['jobs', 'jobDetail','jobsPage']]);

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
        $job = PostJob::with('company')->with('jobSkills')->where('slug', 'like', $job_slug)->firstOrFail();

        $job_skill_ids = (array) $job->getJobSkillsArray();
        $jobskills = JobSkill::whereIn('id', $job_skill_ids)->select('job_skill')->get();

        return view('job.detail')
                        ->with('job', $job)
                        ->with('jobskills', $jobskills);
    }

    public function jobDetailZnp(Request $request, $job_slug)
    {
        $job = PostJob::with('company')->with('jobSkills')->where('slug', 'like', $job_slug)->firstOrFail();

        $job_skill_ids = (array) $job->getJobSkillsArray();
        $jobskills = JobSkill::whereIn('id', $job_skill_ids)->select('id', 'job_skill')->get();

        $applicantCount = $job->appliedUsers()->count();

        $titleKeyword = explode(' ', $job->job_title)[0];
        $similarJobs = PostJob::with('company')
            ->status()
            ->where('id', '!=', $job->id)
            ->where('job_title', 'LIKE', '%' . $titleKeyword . '%')
            ->latest()
            ->take(3)
            ->get();

        return view('znp.job-detail', compact('job', 'jobskills', 'applicantCount', 'similarJobs'));
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

    /**
     * Jobs listing page — new ZNP design (temp URL: /jobs-page)
     */
    public function jobsPage(Request $request)
    {
        $query = PostJob::with(['company', 'jobSkills'])->status();

        // ── Text search (q) — split comma-separated terms, match any
        if ($q = trim($request->input('q', ''))) {
            $terms = array_filter(array_map('trim', explode(',', $q)));
            if ($terms) {
                $query->where(function ($sq) use ($terms) {
                    foreach ($terms as $term) {
                        $like = '%' . strtolower($term) . '%';
                        $sq->orWhere('search',    'LIKE', $like)
                           ->orWhere('job_title', 'LIKE', $like);
                    }
                });
            }
        }

        // ── Location from search bar (loc)
        if ($loc = trim($request->input('loc', ''))) {
            $query->where('search', 'LIKE', '%' . strtolower($loc) . '%');
        }

        // ── Popular tag quick filter
        if ($tag = $request->input('tag', '')) {
            $tagMap = [
                'Bengaluru'        => ['search',    '%bengaluru%'],
                'Mumbai'           => ['search',    '%mumbai%'],
                'Hyderabad'        => ['search',    '%hyderabad%'],
                'Delhi NCR'        => ['search',    '%delhi%'],
                'Pune'             => ['search',    '%pune%'],
                'Chennai'          => ['search',    '%chennai%'],
                'Remote'           => ['work_mode', 'Remote/WFH'],
                'Hybrid'           => ['work_mode', 'Hybrid'],
                'Work From Office' => ['work_mode', 'Work From Office'],
                'Contract'         => ['job_type',  'Contract'],
                'Night Shift'      => ['job_shift',  '%shift%'],
            ];
            if (isset($tagMap[$tag])) {
                [$col, $val] = $tagMap[$tag];
                str_contains($val, '%') ? $query->where($col, 'LIKE', $val) : $query->where($col, $val);
            }
        }

        // ── Work mode filter (multi-select, LIKE so partial values match)
        if ($modes = array_filter((array) $request->input('mode', []))) {
            $query->where(function ($sq) use ($modes) {
                foreach ($modes as $mode) {
                    $sq->orWhere('work_mode', 'LIKE', '%' . $mode . '%');
                }
            });
        }

        // ── Job type filter (multi-select, LIKE so partial values match)
        if ($types = array_filter((array) $request->input('type', []))) {
            $query->where(function ($sq) use ($types) {
                foreach ($types as $type) {
                    $sq->orWhere('job_type', 'LIKE', '%' . $type . '%');
                }
            });
        }

        // ── Job shift filter (multi-select, LIKE because values can be verbose)
        if ($shifts = array_filter((array) $request->input('shift', []))) {
            $query->where(function ($sq) use ($shifts) {
                foreach ($shifts as $shift) {
                    $sq->orWhere('job_shift', 'LIKE', '%' . $shift . '%');
                }
            });
        }

        // ── Experience filter (multi-select, range-based)
        if ($exps = array_filter((array) $request->input('exp', []))) {
            $expRangeMap = ['0-3'=>[0,3],'3-6'=>[3,6],'6-10'=>[6,10],'10-15'=>[10,15],'15-25'=>[15,25],'25+'=>[25,999]];
            $query->where(function ($sq) use ($exps, $expRangeMap) {
                foreach ($exps as $range) {
                    if (isset($expRangeMap[$range])) {
                        [$min, $max] = $expRangeMap[$range];
                        $sq->orWhereRaw("CAST(experience AS UNSIGNED) BETWEEN ? AND ?", [$min, $max]);
                    }
                }
            });
        }

        // ── Location sidebar filter (multi-select)
        if ($locations = array_filter((array) $request->input('location', []))) {
            $query->where(function ($sq) use ($locations) {
                foreach ($locations as $l) {
                    $sq->orWhere('search', 'LIKE', '%' . strtolower($l) . '%');
                }
            });
        }

        // ── Salary range filter (multi-select, any selected range overlaps job salary)
        if ($sals = array_filter((array) $request->input('sal', []))) {
            $salaryRangeMap = ['0-3'=>[0,3],'3-6'=>[3,6],'6-10'=>[6,10],'10-15'=>[10,15],'15-25'=>[15,25],'25-50'=>[25,50],'50-75'=>[50,75],'75-100'=>[75,100],'100-500'=>[100,500],'500+'=>[500,999999]];
            $query->where(function ($sq) use ($sals, $salaryRangeMap) {
                foreach ($sals as $sal) {
                    if (isset($salaryRangeMap[$sal])) {
                        [$min, $max] = $salaryRangeMap[$sal];
                        $sq->orWhere(function ($sq2) use ($min, $max) {
                            $sq2->where('max_salary', '>=', $min)
                                ->where('min_salary', '<=', $max);
                        });
                    }
                }
            });
        }

        // ── Freshness filter
        if ($date = $request->input('date', '')) {
            $dateMap = ['today' => 1, '3days' => 3, 'week' => 7, '2weeks' => 15, 'month' => 30];
            if (isset($dateMap[$date])) {
                $query->where('created_at', '>=', now()->subDays($dateMap[$date]));
            }
        }

        // ── Sort
        $sort = $request->input('sort', 'relevance');
        if ($sort === 'salary_high') {
            $query->orderByDesc('max_salary')->orderByDesc('created_at');
        } elseif ($sort === 'latest') {
            $query->orderByDesc('created_at');
        } else {
            // Relevance: when a search term is present, rank title matches first,
            // then partial search-field matches; fall back to created_at DESC.
            $q = trim($request->input('q', ''));
            if ($q) {
                $terms = array_filter(array_map('trim', explode(',', $q)));
                $first = strtolower(reset($terms));  // use the primary term for scoring
                $like  = '%' . $first . '%';
                // CASE score: 2 = job_title match, 1 = search field match, 0 = other
                $query->orderByRaw(
                    "CASE
                        WHEN LOWER(job_title) LIKE ? THEN 2
                        WHEN LOWER(search)    LIKE ? THEN 1
                        ELSE 0
                    END DESC",
                    [$like, $like]
                )->orderByDesc('created_at');
            } else {
                // No search term: default to latest jobs first
                $query->orderByDesc('created_at');
            }
        }

        $jobs = $query->paginate(10)->withQueryString();

        // ── Filter metadata (counts from DB for dynamic sidebar) ──────────────
        // Experience counts — new ranges matching sidebar labels
        $expRangeMap = ['0-3'=>[0,3],'3-6'=>[3,6],'6-10'=>[6,10],'10-15'=>[10,15],'15-25'=>[15,25],'25+'=>[25,999]];
        $expCounts = [];
        foreach ($expRangeMap as $key => [$min, $max]) {
            $expCounts[$key] = PostJob::status()
                ->whereRaw("CAST(experience AS UNSIGNED) BETWEEN ? AND ?", [$min, $max])
                ->count();
        }

        // Salary counts — includes Cr ranges
        $salaryRangeMap = ['0-3'=>[0,3],'3-6'=>[3,6],'6-10'=>[6,10],'10-15'=>[10,15],'15-25'=>[15,25],'25-50'=>[25,50],'50-75'=>[50,75],'75-100'=>[75,100],'100-500'=>[100,500],'500+'=>[500,999999]];
        $salaryCounts = [];
        foreach ($salaryRangeMap as $key => [$min, $max]) {
            $salaryCounts[$key] = PostJob::status()
                ->where('max_salary', '>=', $min)->where('min_salary', '<=', $max)->count();
        }

        // Work mode counts — LIKE-based matching
        $workModeKeys = ['Remote' => 'Remote', 'Hybrid' => 'Hybrid', 'Work From Office' => 'Work From Office', 'Temp WFH' => 'Temp WFH'];
        $workModeCounts = [];
        foreach ($workModeKeys as $key => $like) {
            $workModeCounts[$key] = PostJob::status()->where('work_mode', 'LIKE', '%'.$like.'%')->count();
        }

        // Shift counts — LIKE-based matching
        $shiftKeys = ['Day Shift' => 'Day Shift', 'Night Shift' => 'Night Shift', 'Rotational Shift' => 'Rotational Shift', 'US Shift' => 'US Shift', 'UK Shift' => 'UK Shift', 'APAC Shift' => 'APAC Shift', '6 days' => '6 days'];
        $shiftCounts = [];
        foreach ($shiftKeys as $key => $like) {
            $shiftCounts[$key] = PostJob::status()->where('job_shift', 'LIKE', '%'.$like.'%')->count();
        }

        // Job type counts — LIKE-based matching
        $typeKeys = ['Permanent' => 'Permanent', 'Contract' => 'Contract', 'Contract to Hire' => 'Contract to Hire', 'Freelance' => 'Freelance', 'Fresher' => 'Fresher', 'Internship' => 'Internship'];
        $jobTypeCounts = [];
        foreach ($typeKeys as $key => $like) {
            $jobTypeCounts[$key] = PostJob::status()->where('job_type', 'LIKE', '%'.$like.'%')->count();
        }

        // Locations: unserialize the serialized array column, count occurrences
        $locationCounts = [];
        PostJob::status()->pluck('location')->each(function ($raw) use (&$locationCounts) {
            $arr = @unserialize($raw);
            if (!is_array($arr)) return;
            foreach ($arr as $l) {
                $l = trim($l);
                if ($l) $locationCounts[$l] = ($locationCounts[$l] ?? 0) + 1;
            }
        });
        arsort($locationCounts);

        return view('znp.jobs', compact(
            'jobs', 'expCounts', 'salaryCounts', 'workModeCounts', 'shiftCounts', 'jobTypeCounts', 'locationCounts'
        ));
    }

    /**
     * Autocomplete endpoint for job title search (GET /jobs-autocomplete?q=...)
     */
    public function jobsAutocomplete(Request $request)
    {
        $q = trim($request->input('q', ''));
        if (strlen($q) < 2) {
            return response()->json([]);
        }
        $titles = PostJob::status()
            ->where('job_title', 'LIKE', '%' . $q . '%')
            ->distinct()
            ->pluck('job_title')
            ->take(10)
            ->values();
        return response()->json($titles);
    }

}
