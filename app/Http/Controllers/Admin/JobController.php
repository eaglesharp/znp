<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Job;
use App\PostJob;
use App\Company;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Controllers\Controller;
use App\Traits\JobTrait;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use GeoIp2\Record\Postal;
use Illuminate\Support\Str;

class JobController extends Controller
{

    use JobTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexJobs(Request $request)
    {
        
        $jobs = PostJob::withCount('appliedUsers')->where('company_id',$request->company_id)->get();
        
        $countries = DataArrayHelper::defaultCountriesArray();
       
        return view('admin.job.index')
                        ->with('jobs', $jobs)
                        ->with('countries', $countries);
                        

                        
    }

    public function fetchJobsData(Request $request)
    {
      //  dd($request->all());
        $jobs = PostJob::get();
      //  dd($jobs);
        return Datatables::of($jobs)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('company_id') && !empty($request->company_id)) {
                                $query->where('jobs.company_id', '=', "{$request->get('company_id')}");
                            }
                            if ($request->has('title') && !empty($request->title)) {
                                $query->where('jobs.job_title', 'like', "%{$request->get('title')}%");
                            }
                            if ($request->has('description') && !empty($request->description)) {
                                $query->where('jobs.job_description', 'like', "%{$request->get('description')}%");
                            }
                          
                          
                            // if ($request->has('status') && $request->status != -1) {
                            //     $query->where('jobs.status', '=', "{$request->get('status')}");
                            // }
                          
                        })
                        ->addColumn('company_id', function ($jobs) {
                            return $jobs->getCompany('name');
                        })
                       
                        ->addColumn('description', function ($jobs) {
                            return strip_tags(Str::limit($jobs->description, 50, '...'));
                        })
                        ->addColumn('action', function ($jobs) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $jobs->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $jobs->status == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $jobs->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            $featuredTxt = 'Make Featured';
                            $featuredHref = 'makeFeatured(' . $jobs->id . ');';
                            $featuredIcon = 'square-o';
                            if ((int) $jobs->is_featured == 1) {
                                $featuredTxt = 'Make Not Featured';
                                $featuredHref = 'makeNotFeatured(' . $jobs->id . ');';
                                $featuredIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.job', ['id' => $jobs->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteJob(' . $jobs->id . ', ' . $jobs->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $jobs->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $featuredHref . '" id="onclickFeatured' . $jobs->id . '"><i class="fa fa-' . $featuredIcon . '" aria-hidden="true"></i>' . $featuredTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'company_id', 'city_id', 'description'])
                        ->setRowId(function($jobs) {
                            return 'jobDtRow' . $jobs->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            $job->is_active = 1;
            $job->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            $job->is_active = 0;
            $job->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeFeaturedJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            $job->is_featured = 1;
            $job->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotFeaturedJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            $job->is_featured = 0;
            $job->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

}
