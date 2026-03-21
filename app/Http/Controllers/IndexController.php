<?php



namespace App\Http\Controllers;



use App;

use App\Seo;

use App\User;

use App\Job;

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



        // $topCompanyIds = $this->getCompanyIdsAndNumJobs(16);

        // $topFunctionalAreaIds = $this->getFunctionalAreaIdsAndNumJobs(32);

        // $topIndustryIds = $this->getIndustryIdsFromCompanies(32);

        // $topCityIds = $this->getCityIdsAndNumJobs(32);

        // // $featuredJobs = Job::active()->featured()->notExpire()->limit(12)->orderBy('id', 'desc')->get();

        // // $latestJobs = Job::active()->notExpire()->orderBy('id', 'desc')->limit(18)->get();

        // $blogs = Blog::orderBy('id', 'desc')->where('lang', 'like', \App::getLocale())->limit(3)->get();

        // $video = Video::getVideo();

        // $testimonials = Testimonial::langTestimonials();



        // $functionalAreas = DataArrayHelper::langFunctionalAreasArray();

        // $countries = DataArrayHelper::langCountriesArray();

		// $sliders = Slider::langSliders();



        $seo = SEO::where('seo.page_title', 'like', 'front_index_page')->first();

        return view('welcome')

                   

                        ->with('seo', $seo);

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

