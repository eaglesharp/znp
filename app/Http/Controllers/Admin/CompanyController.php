<?php



namespace App\Http\Controllers\Admin;





use File;

use ImgUploader;

use Auth;

use DB;

use Validator;

use App\Price;

use Input;

use Redirect;

use App\Package;

use App\Company;

use App\ZnpPricingPlan;

use App\ZnpCompanySubscription;

use App\Country;

use App\State;

use App\User;

use App\City;
use App\EmployerPayment;
use App\Industry;

use App\PostJob;

use App\OwnershipType;

use Carbon\Carbon;

use App\Helpers\MiscHelper;

use App\Helpers\DataArrayHelper;

use App\Http\Requests;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Mail;

use DataTables;

use App\Http\Requests\CompanyFormRequest;



use App\Http\Controllers\Controller;
use App\KYC;
use App\Traits\CompanyTrait;

use App\Traits\CompanyPackageTrait;

use Illuminate\Support\Str;

use App\Mail\Registeredmail;


use Hash;



class CompanyController extends Controller
{



    use CompanyTrait;

    use CompanyPackageTrait;



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {

        //

    }



    public function indexCompanies()
    {



        $company = Company::orderBy('created_at', 'desc')->get();





        return view('admin.company.index')->with('company', $company);

    }













    public function indexEmployer()
    {



        // $enquirydata=Price::all();



        $enquirydata = Price::orderBy('created_at', 'desc')->get();



        //   $enquirydata = Price::select("*")

        //   ->orderBy('created_at', 'desc')

        //   ->get();





        return view('admin.employer.index')->with('enquirydata', $enquirydata);

    }





    public function registerEmployer($id)
    {

        $registerdata = Price::where('id', $id)->first();




        //return dd($registerdata);

        if ($registerdata->size == 'company') {
            // return dd('company');
            $size = '1';
        } else {
            $size = '0';
        }


        $package_id = $registerdata->package_name;



        $package = Package::find($package_id);





        $companydata = Company::where('email', $registerdata->email)->first();



        $user = Company::where('email', '=', $registerdata->email)->first();



        if ($user === null) {



            $randompassword = Str::random(6);



            $password = Hash::make($randompassword);

            $email = $registerdata->email;





            $company = new Company();



            $company->name = $registerdata->company_name;

            $company->email = $registerdata->email;

            $company->phone = $registerdata->mobile;

            $company->ceo = $registerdata->person_name;

            $company->gstin = $registerdata->gstin;

            $company->size = $registerdata->size;

            $company->pincode = $registerdata->pincode;

            //$company->status = '1';



            $company->promotional = $registerdata->promotional;

            $company->password = $password;

            $company->slug = Str::slug($company->name, '-') . '-' . $id;

            $company->is_featured = $size;



            if ($registerdata->package_name && $registerdata->package_name > 0) {

                $package_id = $registerdata->package_name;

                $package = Package::find($package_id);

                $this->addCompanyPackage($company, $package);

                // $this->addCompanySearchPackage($company, $package);

            }





            $company->save();



            $registerdata->status = '1';



            $registerdata->save();



            $data = [

                'title' => $email,

                'subject' => 'Employer Account Created On ZNP Team',

                'content' => $randompassword,

                'c_name' => $registerdata->company_name,

                'link' => route('employer.login'),

            ];



            Mail::send('emails.employer_registered', $data, function ($message) use ($data) {

                $message->to($data['title'])

                    ->subject($data['subject']);

            });



            return redirect()->back()->with(['message' => 'Email successfully sent!']);





        }

        return redirect()->back()->with('newtext', 'Employer Has been Already Registered');





    }







    public function createCompany()
    {

        $countries = DataArrayHelper::defaultCountriesArray();

        $industries = DataArrayHelper::defaultIndustriesArray();

        $ownershipTypes = DataArrayHelper::defaultOwnershipTypesArray();

        // $packages = Package::select('*', DB::raw("CONCAT(`package_title`, ', $', `package_price`, ', Days:', `package_num_days`, ', Listings:', `package_num_listings`) AS package_detail"))->where('package_for', 'like', 'cv_search')->pluck('package_detail', 'id')->toArray();





        $packages = Package::select('*', DB::raw("CONCAT(`package_title`, ', ₹', `package_price`, ', Days:', `package_num_days`, ', Listings:', `package_num_listings`) AS package_detail"))->pluck('package_detail', 'id')->toArray();

        //  return dd($packages);



        return view('admin.company.add')

            ->with('countries', $countries)

            ->with('industries', $industries)

            ->with('ownershipTypes', $ownershipTypes)

            ->with('packages', $packages);

    }



    public function storeCompany(Request $request)
    {

        // return dd($request);
        $request->validate(
            [

                'name' => 'required',
                'email' => 'required|email|unique:companies',
                'ceo' => 'required',
                'phone' => 'required|numeric|digits:10',
                'company_package_id' => 'required',
                'designation' => 'required'


            ],
            [
                'name.required' => ' Company Name is required',
                'email.required' => 'Email is required',
                'ceo.required' => ' Person name is required',
                'phone.required' => __('Phone Number is required'),
                'company_package_id.required' => 'Package is required',
                'designation.required' => 'Designation is required'

            ]
        );


        //  dd('validation successfully');


        $company = new Company();

        /*         * **************************************** */

        if ($request->hasFile('logo')) {

            $image = $request->file('logo');

            $fileName = ImgUploader::UploadImage('company_logos', $image, $request->input('name'), 300, 300, false);

            $company->logo = $fileName;

        }

        /*         * ************************************** */

        $company->name = $request->input('name');

        $company->email = $request->input('email');

        $randompassword = Str::random(6);



        $password = Hash::make($randompassword);



        $company->password = $password;



        // if (!empty($request->input('password'))) {

        //     $company->password = Hash::make($request->input('password'));

        // }
        $company->designation = $request->input('designation');

        $company->ceo = $request->input('ceo');

        $company->industry_id = $request->input('industry_id');

        $company->ownership_type_id = $request->input('ownership_type_id');

        $company->description = $request->input('description');

        $company->location = $request->input('location');

        // $company->map = $request->input('map');

        $company->no_of_offices = $request->input('no_of_offices');

        $website = $request->input('website');

        $company->website = (false === strpos($website, 'http')) ? 'http://' . $website : $website;

        $company->no_of_employees = $request->input('no_of_employees');

        $company->established_in = $request->input('established_in');

        // $company->fax = $request->input('fax');

        $company->phone = $request->input('phone');

        // $company->facebook = $request->input('facebook');

        // $company->twitter = $request->input('twitter');

        // $company->linkedin = $request->input('linkedin');

        // $company->google_plus = $request->input('google_plus');

        // $company->pinterest = $request->input('pinterest');

        $company->country_id = $request->input('country_id');

        $company->state_id = $request->input('state_id');

        $company->city_id = $request->input('city_id');

        $company->is_active = $request->input('is_active');

        $company->is_featured = $request->input('is_featured');



        $company->save();

        /*         * ******************************* */

        $company->slug = Str::slug($company->name, '-') . '-' . $company->id;

        /*         * ******************************* */

        $company->update();

        /*         * ************************************ */

        if ($request->has('company_package_id') && $request->input('company_package_id') > 0) {

            $package_id = $request->input('company_package_id');

            $package = Package::find($package_id);

            $this->addCompanyPackage($company, $package);

            // $this->addCompanySearchPackage($company, $package);





        }

        /*         * ************************************ */



        $data = [

            'title' => $request->input('email'),

            'subject' => 'Employer Account Created On ZNP Team',

            'content' => $randompassword,

            'c_name' => $request->input('name'),

            'link' => route('employer.login'),

        ];



        Mail::send('emails.employer_registered_admin', $data, function ($message) use ($data) {

            $message->to($data['title'])

                ->subject($data['subject']);

        });



        flash('Company has been added!')->success();

        return \Redirect::route('edit.company', array($company->id));

    }



    public function editCompany($id)
    {





        $company_id = Company::where('id', $id)->first();

        $cvs_id = $company_id->cvs_package_id;

        $package_id = Package::where('id', $cvs_id)->first();



        //  return dd($company_id);





        $countries = DataArrayHelper::defaultCountriesArray();

        $industries = DataArrayHelper::defaultIndustriesArray();

        $ownershipTypes = DataArrayHelper::defaultOwnershipTypesArray();



        $company = Company::findOrFail($id);

        // if ($company->package_id > 0) {

        //     $package = Package::find($company->package_id);

        //     $packages = Package::select('id', DB::raw("CONCAT(`package_title`, ', $', `package_price`, ', Days:', `package_num_days`, ', Listings:', `package_num_listings`) AS package_detail"))->where('package_for', 'like', 'employer')->where('id', '<>', $company->package_id)->where('package_price', '>=', $package->package_price)->pluck('package_detail', 'id')->toArray();

        // } else {

        //     $packages = Package::select('id', DB::raw("CONCAT(`package_title`, ', $', `package_price`, ', Days:', `package_num_days`, ', Listings:', `package_num_listings`) AS package_detail"))->where('package_for', 'like', 'employer')->pluck('package_detail', 'id')->toArray();

        // }



        $packages = Package::select('*', DB::raw("CONCAT(`package_title`, ', ₹', `package_price`, ', Days:', `package_num_days`, ', Emails:', `package_num_listings`,', Cv:',`cv_access`) AS package_detail"))->pluck('package_detail', 'id')->toArray();





        // if ($company->package_id > 0) {

        //     $package = Package::find($company->package_id);

        //     $packages = Package::select('id', DB::raw("CONCAT(`package_title`, ', $', `package_price`, ', Days:', `package_num_days`, ', Listings:', `package_num_listings`) AS package_detail"))->where('package_for', 'like', 'employer')->where('id', '<>', $company->package_id)->pluck('package_detail', 'id')->toArray();

        // } else {

        //     $packages = Package::select('id', DB::raw("CONCAT(`package_title`, ', $', `package_price`, ', Days:', `package_num_days`, ', Listings:', `package_num_listings`) AS package_detail"))->where('package_for', 'like', 'employer')->pluck('package_detail', 'id')->toArray();

        // }

        // return dd($packages);



        /* ── ZNP pricing plans (new system) ──
           Drives the "ZNP Plan" dropdown on the form so admins can grant a
           plan to an employer manually until the Razorpay flow is live.
           NOTE: ignores soft-stored/seeded rows whose is_active=0. */
        $znpPlans = ZnpPricingPlan::active()->ordered()->get();
        $znpPlanOptions = ['' => '— Select ZNP Plan —'];
        foreach ($znpPlans as $p) {
            $limitLabel = ((int) $p->job_posts_limit === 0)
                ? 'Unlimited'
                : (int) $p->job_posts_limit . ' posts';
            $priceLabel = $p->is_custom_price
                ? 'Custom'
                : '₹' . number_format((float) $p->price, 0, '.', ',');
            $znpPlanOptions[$p->id] = $p->name . ' · ' . $priceLabel
                . ' · ' . $limitLabel . ' · ' . (int) $p->validity_days . 'd';
        }

        $znpSubscription = $company->activeZnpSubscription();

        return view('admin.company.edit')

            ->with('company', $company)

            ->with('countries', $countries)

            ->with('industries', $industries)

            ->with('ownershipTypes', $ownershipTypes)

            ->with('packages', $packages)

            ->with('package_id', $package_id)

            ->with('znpPlans', $znpPlans)

            ->with('znpPlanOptions', $znpPlanOptions)

            ->with('znpSubscription', $znpSubscription);

    }



    public function updateCompany($id, CompanyFormRequest $request)
    {



        // return dd($request);





        $newcompany = Company::where('id', $id)->first();

        $company = Company::findOrFail($id);

        /*         * **************************************** */

        if ($request->hasFile('logo')) {

            $is_deleted = $this->deleteCompanyLogo($company->id);

            $image = $request->file('logo');

            $fileName = ImgUploader::UploadImage('company_logos', $image, $request->input('name'), 300, 300, false);

            $company->logo = $fileName;

        }

        /*         * ************************************** */

        $company->name = $request->input('name');



        if ($request->input('email') === $newcompany->email) {

            $company->email = $request->input('email');



        } else {





            return back()->with('emailerror', 'The Email Has been Already taken');



        }













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

        $company->is_active = $request->input('is_active');

        $company->is_featured = $request->input('is_featured');

        $company->designation = $request->input('designation');

        $company->cvs_package_id = $request->input('company_package_id');



        $company->slug = Str::slug($company->name, '-') . '-' . $company->id;

        $company->update();



        /*         * ************************************ */

        if ($request->has('company_package_id') && $request->input('company_package_id') > 0) {

            $package_id = $request->input('company_package_id');

            $package = Package::find($package_id);

            if ($company->cvs_package_id > 0) {

                //$this->updateCompanySearchPackage($company, $package);

                $this->updateCompanyPackage($company, $package);





            } else {

                $this->addCompanyPackage($company, $package);

                // $this->addCompanySearchPackage($company, $package);

            }

        }

        /*         * ************************************ */

        /* ── ZNP plan assignment (new system) ──
           When the admin picks a ZNP plan from the dropdown, we cancel any
           previously-active subscription and grant a fresh one with:
             - posts quota snapshotted from the plan
             - expires_at = now + plan.validity_days
             - assignment_source = 'admin_manual' (no payment captured)
           Picking the same plan again issues a fresh window (re-grant). */
        if ($request->filled('znp_plan_id')) {
            $this->grantZnpPlanToCompany(
                $company,
                (int) $request->input('znp_plan_id'),
                $request->input('znp_plan_notes')
            );
        }

        flash('Company has been updated!')->success();

        return \Redirect::route('edit.company', array($company->id));

    }



    /**
     * Cancel any active ZNP subscription on the company and grant a fresh
     * one based on the chosen plan. Used by the manual-grant flow on the
     * admin edit-company form (no payment captured, source = 'admin_manual').
     *
     * Safe to call multiple times — each call yields a new subscription row
     * so the audit trail is preserved.
     */
    protected function grantZnpPlanToCompany(Company $company, int $planId, ?string $notes = null): ?ZnpCompanySubscription
    {
        $plan = ZnpPricingPlan::find($planId);
        if (! $plan) {
            return null;
        }

        /* End any currently-active subscriptions before issuing a new one. */
        ZnpCompanySubscription::where('company_id', $company->id)
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        $now = Carbon::now();
        $adminId = Auth::guard('admin')->check() ? (int) Auth::guard('admin')->user()->id : null;

        return ZnpCompanySubscription::create([
            'company_id'           => $company->id,
            'plan_id'              => $plan->id,
            'plan_slug'            => $plan->slug,
            'plan_name'            => $plan->name,
            'posts_limit'          => (int) $plan->job_posts_limit,
            'posts_used'           => 0,
            'validity_days'        => (int) $plan->validity_days,
            'post_active_days'     => (int) $plan->post_active_days,
            'starts_at'            => $now,
            'expires_at'           => $now->copy()->addDays((int) $plan->validity_days),
            'status'               => 'active',
            'amount_paid'          => 0,
            'currency'             => $plan->currency ?: 'INR',
            'assignment_source'    => 'admin_manual',
            'payment_ref'          => null,
            'assigned_by_admin_id' => $adminId,
            'notes'                => $notes,
        ]);
    }



    public function deleteCompany(Request $request)
    {

        $id = $request->input('id');

        try {

            $company = Company::findOrFail($id);

            $jobs = PostJob::where('company_id', $company->id);

            $jobs->delete();

            $this->deleteCompanyLogo($company->id);

            $company->delete();

            return 'ok';

        } catch (ModelNotFoundException $e) {

            return 'notok';

        }

    }




    public function fetchCompaniesData(Request $request)
    {


        $companies = Company::select([

            'companies.id',

            'companies.name',

            'companies.email',

            'companies.jobs_quota',

            'companies.availed_jobs_quota',

            'companies.password',

            'companies.ceo',

            'companies.industry_id',

            'companies.ownership_type_id',

            'companies.description',

            'companies.location',

            'companies.no_of_offices',

            'companies.website',

            'companies.no_of_employees',

            'companies.established_in',

            'companies.fax',

            'companies.phone',

            'companies.logo',

            'companies.country_id',

            'companies.state_id',

            'companies.city_id',

            'companies.is_active',

            'companies.is_freeze',

            'companies.is_featured',

            'companies.cvs_quota',

            'companies.availed_cvs_quota',

            'companies.kyc_verified',

            'companies.linkedin',

            'companies.package_end_date',

        ])->orderBy('id', 'DESC');
        $now = Carbon::now();

        return Datatables::of($companies)

            ->filter(function ($query) use ($request) {

                if ($request->has('name') && !empty ($request->name)) {

                    $query->where('companies.name', 'like', "%{$request->get('name')}%");

                }

                if ($request->has('email') && !empty ($request->email)) {

                    $query->where('companies.email', 'like', "%{$request->get('email')}%");

                }

                if ($request->has('is_active') && $request->is_active != -1) {

                    $query->where('companies.is_active', '=', "{$request->get('is_active')}");

                }

                if ($request->has('is_featured') && $request->is_featured != -1) {

                    $query->where('companies.is_featured', '=', "{$request->get('is_featured')}");

                }

                if ($request->has('is_featured') && $request->is_featured != -1) {

                    $query->where('companies.is_featured', '=', "{$request->get('is_featured')}");

                }

            })

            ->addColumn('is_active', function ($companies) {

                $data = ((bool) $companies->is_active) ? 'Yes' : 'No';
                $data = $data . '<br> <p class="text-nowrap" style="margin: 0;"> KYC : ';
                if ($companies->kyc_verified == 0) {
                    $data = $data . '<span class="badge badge-info"> Not Applied </span></p>';
                } elseif ($companies->kyc_verified == 1) {
                    $data = $data . '<span class="badge badge-warning"> Applied </span></p>';
                } elseif ($companies->kyc_verified == 2) {
                    $data = $data . '<span class="badge badge-success"> Verified </span></p>';
                } elseif ($companies->kyc_verified == 3) {
                    $data = $data . '<span class="badge badge-danger"> Rejected </span></p>';
                }
                // dd($data);
                if ($companies->linkedin) {
                    $data .= '<a target="_blank" href="' . $companies->linkedin . '">LinkedIn</a>';
                }

                return $data;

            })



            ->addColumn('jobs_quota', function ($companies) {
                $now = Carbon::now();
                if ($companies->package_end_date) {
                    if ($companies->package_end_date > $now) {
                        return $companies->availed_cvs_quota . ' / ' . $companies->cvs_quota . '
                                |' . $companies->package_end_date->format('d-m-Y');
                    } else {
                        return $companies->availed_cvs_quota . ' / ' . $companies->cvs_quota . '
                                |' . 'Expired';
                    }
                } else {
                    return 'No Plan';
                }




            })


            ->addColumn('action', function ($companies) {

                /*                             * ************************* */

                $activeTxt = 'Make Active';

                $activeHref = 'makeActive(' . $companies->id . ');';

                $activeIcon = 'square-o';

                if ((int) $companies->is_active == 1) {

                    $activeTxt = 'Make InActive';

                    $activeHref = 'makeNotActive(' . $companies->id . ');';

                    $activeIcon = 'check-square-o';

                }




                if ((int) $companies->is_freeze == 0) {

                    $freezeTxt = 'KYC Unhold';

                    $freezeHref = 'makeNotFreeze(' . $companies->id . ');';

                    $freezeIcon = 'check-square-o';

                }
                if ((int) $companies->is_freeze == 1) {
                    $freezeTxt = 'KYC Hold';

                    $freezeHref = 'makeFreeze(' . $companies->id . ');';

                    $freezeIcon = 'square-o';
                }


                /*                             * ************************* */

                $featuredTxt = 'Make Featured';

                $featuredHref = 'makeFeatured(' . $companies->id . ');';

                $featuredIcon = 'square-o';

                if ((int) $companies->is_featured == 1) {

                    $featuredTxt = 'Make Not Featured';

                    $featuredHref = 'makeNotFeatured(' . $companies->id . ');';

                    $featuredIcon = 'check-square-o';

                }

                return '

				<div class="btn-group">

					<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action

						<i class="fa fa-angle-down"></i>

					</button>

					<ul class="dropdown-menu">
                            
						 <li>

							<a href="' . route('list.jobs', ['company_id' => $companies->id]) . '" target="_blank"><i class="fa fa-list" aria-hidden="true"></i>List Jobs</a>

						</li> 

                        <li>

                        <a href="' . route('kyc-documents.list', ['company_id' => $companies->id]) . '" target="_blank"><i class="fa fa-list" aria-hidden="true"></i>KYC Documents</a>

                      </li> 


						

						<li>

							<a href="' . route('edit.company', ['id' => $companies->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>

						</li>						

						<li>

							<a href="javascript:void(0);" onclick="deleteCompany(' . $companies->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>

						</li>

						

<li><a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $companies->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a></li>
<li><a href="javascript:void(0);" onClick="' . $freezeHref . '" id="onclickFreeze' . $companies->id . '"><i class="fa fa-' . $freezeIcon . '" aria-hidden="true"></i>' . $freezeTxt . '</a></li>
						

<!-- <li><a href="javascript:void(0);" onClick="' . $featuredHref . '" id="onclickFeatured' . $companies->id . '"><i class="fa fa-' . $featuredIcon . '" aria-hidden="true"></i>' . $featuredTxt . '</a></li> -->
<li>

							<a href="' . route('admin.employer.payment.history', ['company_id' => $companies->id]) . '" target="_blank"><i class="fa fa-list" aria-hidden="true"></i>Payment History</a>

						</li>

					</ul>

				</div>';

            })



            ->addColumn('phone', function ($companies) {

                return $companies->phone;

            })

            ->addColumn('checkbox', '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="{{$id}}"  onclick="loadvalue()" />')

            ->rawColumns(['action', 'is_active', 'is_featured', 'checkbox'])

            ->setRowId(function ($companies) {

                return 'companyDtRow' . $companies->id;

            })

            ->make(true);

        //$query = $dataTable->getQuery()->get();

        //return $query;

    }

    public function fetchEmployersData(Request $request)
    {

        $companies = Company::select([

            'companies.id',

            'companies.name',

            'companies.email',

            'companies.password',

            'companies.ceo',



            'companies.industry_id',

            'companies.ownership_type_id',

            'companies.description',

            'companies.location',

            'companies.no_of_offices',

            'companies.website',

            'companies.no_of_employees',

            'companies.established_in',

            'companies.fax',

            'companies.phone',

            'companies.logo',

            'companies.country_id',

            'companies.state_id',

            'companies.city_id',

            'companies.is_active',

            'companies.is_featured',

        ]);

        return Datatables::of($companies)

            ->filter(function ($query) use ($request) {

                if ($request->has('name') && !empty ($request->name)) {

                    $query->where('companies.name', 'like', "%{$request->get('name')}%");

                }

                if ($request->has('email') && !empty ($request->email)) {

                    $query->where('companies.email', 'like', "%{$request->get('email')}%");

                }

                if ($request->has('is_active') && $request->is_active != -1) {

                    $query->where('companies.is_active', '=', "{$request->get('is_active')}");

                }

                if ($request->has('is_featured') && $request->is_featured != -1) {

                    $query->where('companies.is_featured', '=', "{$request->get('is_featured')}");

                }

            })

            ->addColumn('is_active', function ($companies) {

                return ((bool) $companies->is_active) ? 'Yes' : 'No';

            })

            ->addColumn('is_featured', function ($companies) {

                return ((bool) $companies->is_featured) ? 'Yes' : 'No';

            })

            ->addColumn('action', function ($companies) {

                /*                             * ************************* */

                $activeTxt = 'Make Active';

                $activeHref = 'makeActive(' . $companies->id . ');';

                $activeIcon = 'square-o';

                if ((int) $companies->is_active == 1) {

                    $activeTxt = 'Make InActive';

                    $activeHref = 'makeNotActive(' . $companies->id . ');';

                    $activeIcon = 'check-square-o';

                }

                /*                             * ************************* */

                $featuredTxt = 'Make Featured';

                $featuredHref = 'makeFeatured(' . $companies->id . ');';

                $featuredIcon = 'square-o';

                if ((int) $companies->is_featured == 1) {

                    $featuredTxt = 'Make Not Featured';

                    $featuredHref = 'makeNotFeatured(' . $companies->id . ');';

                    $featuredIcon = 'check-square-o';

                }

                return '

				<div class="btn-group">

					<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action

						<i class="fa fa-angle-down"></i>

					</button>

					<ul class="dropdown-menu">

						<li>

							<a href="' . route('list.jobs', ['company_id' => $companies->id]) . '" target="_blank"><i class="fa fa-list" aria-hidden="true"></i>List Jobs</a>

						</li>  

						

						<li>

							<a href="' . route('edit.company', ['id' => $companies->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>

						</li>						

						<li>

							<a href="javascript:void(0);" onclick="deleteCompany(' . $companies->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>

						</li>

						

						

<li><a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $companies->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a></li>

						

<!-- <li><a href="javascript:void(0);" onClick="' . $featuredHref . '" id="onclickFeatured' . $companies->id . '"><i class="fa fa-' . $featuredIcon . '" aria-hidden="true"></i>' . $featuredTxt . '</a></li> -->

					</ul>

				</div>';

            })

            ->rawColumns(['action', 'is_active', 'is_featured'])

            ->setRowId(function ($companies) {

                return 'companyDtRow' . $companies->id;

            })

            ->make(true);

        //$query = $dataTable->getQuery()->get();

        //return $query;

    }



    public function makeActiveCompany(Request $request)
    {

        $id = $request->input('id');

        try {

            $company = Company::findOrFail($id);

            $company->is_active = 1;

            $company->update();

            echo 'ok';

        } catch (ModelNotFoundException $e) {

            echo 'notok';

        }

    }



    public function makeNotActiveCompany(Request $request)
    {

        $id = $request->input('id');

        try {

            $company = Company::findOrFail($id);

            $company->is_active = 0;

            $company->update();

            echo 'ok';

        } catch (ModelNotFoundException $e) {

            echo 'notok';

        }

    }

    public function makeFreezeCompany(Request $request)
    {

        $id = $request->input('id');

        try {

            $company = Company::findOrFail($id);

            $company->is_freeze = 0;

            $company->update();

            echo 'ok';

        } catch (ModelNotFoundException $e) {

            echo 'notok';

        }

    }



    public function makeNotFreezeCompany(Request $request)
    {

        $id = $request->input('id');

        try {

            $company = Company::findOrFail($id);

            $company->is_freeze = 1;

            $company->update();

            echo 'ok';

        } catch (ModelNotFoundException $e) {

            echo 'notok';

        }

    }






    public function makeFeaturedCompany(Request $request)
    {

        $id = $request->input('id');

        try {

            $company = Company::findOrFail($id);

            $company->is_featured = 1;

            $company->update();

            echo 'ok';

        } catch (ModelNotFoundException $e) {

            echo 'notok';

        }

    }



    public function makeNotFeaturedCompany(Request $request)
    {

        $id = $request->input('id');

        try {

            $company = Company::findOrFail($id);

            $company->is_featured = 0;

            $company->update();

            echo 'ok';

        } catch (ModelNotFoundException $e) {

            echo 'notok';

        }

    }

    public function deleteEnquiry(Request $request)
    {





        // $id = $request->input('id');





        try {

            $company = Price::where('id', $request->id)->delete();





            return redirect()->back()->with('message', 'Enquiry Deleted Successfully');

        } catch (ModelNotFoundException $e) {

            return 'notok';

        }

    }





    public function employerpaymenthistory()
    {

        $employers = EmployerPayment::latest()->get();

        return view('admin.company.employers-payment', compact('employers'));

    }
    public function adminemployerpaymenthistory(Request $request)
    {
        $company = Company::where('id', $request->company_id)->first();

        $payments = EmployerPayment::where('company_id', $request->company_id)->latest()->get();

        return view('admin.company.employer-payment', compact('company', 'payments'));

    }

    public function changeStatus(Request $request)
    {
        //    dd('helo');
        $user = EmployerPayment::find($request->id)->update(['invoice_status' => $request->status]);

        return 'ok';

        return response()->json(['success' => 'Status changed successfully.']);
    }

    public function employeractivities()
    {
        return view('admin.activites.employer_activities');
    }

    public function kycdocuments(Request $request)
    {

        // $company = Company::where('id',$id)->first();
        $kycs = KYC::where("company_id", $request->company_id)->get();
        $company = Company::where("id", $request->company_id)->first();


        return view('admin.company.kyc', compact('kycs', 'company'));

    }


    public function kycdocumentdownload($filename)
    {
        // dd($filename);
        $filePath = public_path('uploads/kyc_documents/' . $filename);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404, 'File not found');
        }
    }

    public function kycdocumentstatus($id, $status)
    {
        //dd($id.'-'.$status);
        $kyc = KYC::where("id", $id)->first();
        $kyc->kyc_verified = $status;
        $kyc->save();

        $company = Company::where('id', $kyc->company_id)->first();
        $company->kyc_verified = $status;
        $company->save();

        return redirect()->back();

    }



    public function sendbulkemail(Request $request)
    {

        //  return dd($request->all());
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
            $email = (explode(",", $emails));

            if (isset($email)) {

                $companies = Company::whereIn('id', $email)->get();
                // return dd($companys);


                // return dd($data);
                // send all mail in the queue.
                foreach ($companies as $company) {

                    // foreach ($companys as $company_mail) {
                    $data = array(
                        'heading' => $request->subject,
                        'message1' => $request->description,
                        'companyname' => $company->name,
                        'companymail' => $company->email,
                        'email' => $company->email
                    );


                    $companymail = "info@zeronoticeperiod.com";
                    $name = "ZeroNoticePeriod";



                    Mail::send('emails.template2', $data, function ($message) use ($data, $company, $companymail, $name) {
                        $message->from($companymail, $name);
                        $message->bcc($company->email);
                        $message->subject($data["heading"]);
                    });
                }


                return response()->json(array('success' => true, 'status' => 200), 200);
            }
        }
        return response()->json(['errors' => $validator->errors()]);



    }



}




