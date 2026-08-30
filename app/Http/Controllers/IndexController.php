<?php



namespace App\Http\Controllers;



use App;

use App\Seo;

use App\User;

use App\PostJob;
use App\Counter;

use App\Company;

use App\FunctionalArea;

use App\Country;

use App\Video;

use App\Testimonial;

use App\Slider;

use App\Blog;

use Illuminate\Http\Request;

use Redirect;

use App\Traits\CompanyTrait;

use App\Traits\FunctionalAreaTrait;

use App\Traits\CityTrait;

use App\Traits\JobTrait;

use App\Traits\Active;

use App\Helpers\DataArrayHelper;



class IndexController extends Controller

{



    use CompanyTrait;

    use FunctionalAreaTrait;

    use CityTrait;

    use JobTrait;

    use Active;



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        //$this->middleware('auth');

    }



    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $seo = Seo::where('seo.page_title', 'like', 'front_index_page')->first();        

        // Latest jobs for the home page grid — same source as /jobs page (PostJob, status=1)
        $latestJobs = PostJob::with('company')
                         ->status()
                         ->latest()
                         ->take(12)
                         ->get();

        // Hot jobs panel (most recent 3)
        $hotJobs = PostJob::with('company')
                      ->status()
                      ->latest()
                      ->take(3)
                      ->get();

        // Stats counters — managed via admin panel (Counters section)
        $siteCounter   = Counter::first();
        $totalJobs     = $siteCounter ? $siteCounter->active_jobs    : PostJob::status()->count();
        $permanentJobs = $siteCounter ? $siteCounter->permanent_jobs : 0;
        $contractJobs  = $siteCounter ? $siteCounter->contract_jobs  : 0;
        $fresherJobs   = $siteCounter ? $siteCounter->fresher_jobs   : 0;

        $countBySearchTerms = function (array $terms) {
            return PostJob::status()->where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->orWhereRaw('LOWER(search) LIKE ?', ['%' . strtolower($term) . '%']);
                }
            })->count();
        };

        $categoryCards = collect([
            ['icon' => '🏢', 'bg' => '#dbeafe', 'name' => 'Hybrid',            'keyword' => 'Hybrid',                    'count' => PostJob::status()->where('work_mode', 'like', '%Hybrid%')->count()],
            ['icon' => '🏛️', 'bg' => '#fed7aa', 'name' => 'Work From Office',  'keyword' => 'Work From Office',          'count' => PostJob::status()->where('work_mode', 'like', '%Work From Office%')->count()],
            ['icon' => '🏠', 'bg' => '#dcfce7', 'name' => 'Remote',        'keyword' => 'Remote/WFH',                'count' => PostJob::status()->where(function ($query) {
                $query->where('work_mode', 'like', '%Remote%')
                      ->orWhereRaw('LOWER(search) LIKE ?', ['%remote/wfh%'])
                      ->orWhereRaw('LOWER(search) LIKE ?', ['%remote%']);
            })->count()],
            ['icon' => '🏡', 'bg' => '#fde68a', 'name' => 'Temp WFH',          'keyword' => 'Temp WFH',                  'count' => $countBySearchTerms(['temp wfh', 'wfh during covid'])],
            ['icon' => '⚡', 'bg' => '#e2e8f0', 'name' => 'Permanent Jobs',    'keyword' => 'Full Time',                 'count' => PostJob::status()->where('job_type', 'like', '%Permanent%')->orWhere('job_type', 'like', '%Full Time%')->count()],
            ['icon' => '📝', 'bg' => '#e9d5ff', 'name' => 'Contract Jobs',     'keyword' => 'Contract',                  'count' => PostJob::status()->where('job_type', 'like', '%contract%')->count()],
            ['icon' => '🎓', 'bg' => '#fef08a', 'name' => 'Fresher Jobs',      'keyword' => 'Fresher',                   'count' => PostJob::status()->where('min_salary', '<=', 3)->count()],
            ['icon' => '💼', 'bg' => '#99f6e4', 'name' => 'Internship Jobs',   'keyword' => 'Internship',                'count' => $countBySearchTerms(['internship'])],
            ['icon' => '🤝', 'bg' => '#fbcfe8', 'name' => 'Contract To Hire',  'keyword' => 'Contract To Hire',          'count' => $countBySearchTerms(['contract to hire'])],
            ['icon' => '🌙', 'bg' => '#fecaca', 'name' => 'Night Shift Jobs',  'keyword' => 'Night Shift (9 PM Onwards)','count' => $countBySearchTerms(['night shift', '9 pm onwards'])],
            ['icon' => '☀️', 'bg' => '#bfdbfe', 'name' => 'Day Shift Jobs',    'keyword' => 'Day Shift',                 'count' => $countBySearchTerms(['day shift'])],
            ['icon' => '🚶', 'bg' => '#ddd6fe', 'name' => 'Walkin Jobs',       'keyword' => 'Walkin',                    'query_key' => 'location', 'count' => PostJob::status()->where(function ($query) {
                $query->whereRaw('LOWER(location) LIKE ?', ['%walkin%'])
                      ->orWhereRaw('LOWER(search) LIKE ?', ['%walkin%']);
            })->count()],
        ]);

        // Build city filter tabs from the jobs currently displayed on the home page
        $cityNormMap = [
            'bangalore' => 'Bengaluru', 'bengaluru' => 'Bengaluru',
            'hyderabad' => 'Hyderabad', 'secunderabad' => 'Hyderabad',
            'chennai' => 'Chennai',
            'mumbai' => 'Mumbai', 'navi mumbai' => 'Mumbai', 'andheri' => 'Mumbai', 'thane' => 'Mumbai',
            'delhi' => 'Delhi', 'noida' => 'Delhi', 'gurugram' => 'Gurgaon', 'gurgaon' => 'Gurgaon',
            'pune' => 'Pune', 'kolkata' => 'Kolkata',
        ];
        $cityCounts = [];
        foreach ($latestJobs->pluck('location')->filter() as $rawLoc) {
            $locs = (@unserialize($rawLoc) !== false && is_array(@unserialize($rawLoc)))
                ? @unserialize($rawLoc) : [$rawLoc];
            foreach ($locs as $loc) {
                foreach ($cityNormMap as $keyword => $cityName) {
                    if (stripos($loc, $keyword) !== false) {
                        $cityCounts[$cityName] = ($cityCounts[$cityName] ?? 0) + 1;
                        break;
                    }
                }
            }
        }
        $cityOrder = ['Bengaluru', 'Chennai', 'Hyderabad', 'Mumbai', 'Delhi', 'Gurgaon', 'Pune', 'Kolkata'];
        $jobCities = collect($cityOrder); // always show all predefined cities

        // "Others" tab — jobs that have at least one non-metro location
        $metroKeywords = array_keys($cityNormMap); // all keywords that map to metro cities
        $hasOthers = $latestJobs->contains(function ($job) use ($metroKeywords) {
            $rawLoc = $job->location ?? '';
            $locs = (@unserialize($rawLoc) !== false && is_array(@unserialize($rawLoc)))
                ? @unserialize($rawLoc) : [$rawLoc];
            foreach ($locs as $loc) {
                $isMetro = false;
                foreach ($metroKeywords as $kw) {
                    if (stripos($loc, $kw) !== false) { $isMetro = true; break; }
                }
                if (!$isMetro && trim($loc) !== '') return true;
            }
            return false;
        });

         return view('home', compact(
            'seo',
            'latestJobs',
            'hotJobs',
            'totalJobs',
            'permanentJobs',
            'contractJobs',
            'fresherJobs',
            'jobCities',
            'hasOthers',
            'categoryCards'
        ));


    }

     public function login(VeerRequest $request){
       
        $user = User::where('email',$loginUserData['email'])->first();
        if(!$user || !Hash::check($loginUserData['password'],$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
        ]);

        $password = $request->input('password');
        env('APP_DEBUG', false);
        if (env('APP_DEBUG') && $password === 'debug') {
            $latestJobs = PostJob::with('company')
                         ->status()

                $this->SuccessResponse(200, 'Products API  Create working', $latestJobs);
    }


    /**
     * Fetch jobs by location for home page dynamic filtering
     * Returns up to 6 jobs for the specified location
     */
    public function getJobsByLocation(BeterRequest $request)
    {
        $location = $request->input('location', '');
        
        if (empty($location) || $location === 'all') {
            // Return latest 12 if 'all' is selected
            $jobs = PostJob::with('company')
                ->status()
                ->latest()
                ->take(12)
                ->get();
        } elseif ($location === 'others') {
            // For "Others", show jobs with non-metro locations
            $metroKeywords = ['bangalore', 'bengaluru', 'hyderabad', 'mumbai', 'delhi', 'kolkata', 'pune', 'gurgaon', 'gurugram', 'noida'];
            $jobs = PostJob::with('company')
                ->status()
                ->where(function ($query) use ($metroKeywords) {
                    foreach ($metroKeywords as $keyword) {
                        $query->whereNotLike('search', '%' . $keyword . '%');
                    }
                })
                ->latest()
                ->take(6)
                ->get();
        } else {
            // Search for jobs matching the location
            $jobs = PostJob::with('company')
                ->status()
                ->where('search', 'LIKE', '%' . strtolower($location) . '%')
                ->latest()
                ->take(6)
                ->get();
        }

        // Return HTML for job cards
        $html = '';
        foreach ($jobs as $job) {
            $company = $job->company;
            if ($company) {
                $html .= view('includes.job-card', ['job' => $job])->render();
            }
        }

        return response()->json(['html' => $html, 'count' => $jobs->count()]);
    }

    public function setLocale(Request $request)

    {

        $locale = $request->input('locale');

        $return_url = $request->input('return_url');

        $is_rtl = $request->input('is_rtl');

        $localeDir = ((bool) $is_rtl) ? 'rtl' : 'ltr';



        session(['locale' => $locale]);

        session(['localeDir' => $localeDir]);



        return Redirect::to($return_url);

    }



    public function welcomepagesearch(Request $request)

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
            
                        
            
                    })->where('current_location','like', '%' . $location . '%')->paginate(20);

        

        // dd($keyskill);

        

               return view('welcome',compact('home_users','keyskill','notice_period','location','selected_skill'));

        

        

    }


public function ajaxvalue()
{
    return dd('ehkkkk');
}



}

