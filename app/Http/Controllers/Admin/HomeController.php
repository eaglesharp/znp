<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Job;
use App\Company;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Package;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

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
        $today = Carbon::now();
        $totalActiveUsers = User::where('is_active', 1)->count();
        $totalnonActiveUsers = User::where('is_active', 0)->count();
        $totalVerifiedUsers = User::where('verified', 1)->count();
        $totalnonVerifiedUsers = User::where('verified', 0)->count();
        $totalTodaysUsers = User::get()->count();
        $totalitusers = User::where('industry','1')->count();
        $totalnonitusers = User::where('industry','2')->count();
        $recentUsers = User::orderBy('id', 'DESC')->take(25)->get();
        $totalActiveJobs = Job::where('is_active', 1)->count();
        $totalFeaturedJobs = Job::where('is_featured', 1)->count();
        $totalTodaysJobs = Job::where('created_at', 'like', $today->toDateString() . '%')->count();
        $recentJobs = Job::orderBy('id', 'DESC')->take(25)->get();

        $totalEmployers = Company::count();
        $recentEmployers = Company::orderBy('id', 'DESC')->take(25)->get();
        $totalActiveEmployers = Company::where('is_active',1)->count();
        $totalnonActiveEmployers = Company::where('is_active',0)->count();

        $trail = Company::where('package_id',17)->count();
        $basic = Company::where('package_id',18)->count();
        $standard = Company::where('package_id',19)->count();
        $premium = Company::where('package_id',20)->count();

        $Users = User::latest()->get();
        if(Auth::user()->role_id== 2){
            $Users = $Users->where('added_by',Auth::user()->id);
        }

        return view('admin.home')
                        ->with('totalActiveUsers', $totalActiveUsers)
                        ->with('totalVerifiedUsers', $totalVerifiedUsers)
                        ->with('totalnonVerifiedUsers', $totalnonVerifiedUsers)
                        ->with('totalTodaysUsers', $totalTodaysUsers)
                        ->with('recentUsers', $recentUsers)
                        ->with('recentEmployers', $recentEmployers)
                        ->with('totalActiveJobs', $totalActiveJobs)
                        ->with('totalFeaturedJobs', $totalFeaturedJobs)
                        ->with('totalTodaysJobs', $totalTodaysJobs)
                        ->with('totalitusers',$totalitusers)
                        ->with('totalnonitusers',$totalnonitusers)
                        ->with('totalActiveEmployers',$totalActiveEmployers)
                        ->with('totalnonActiveEmployers',$totalnonActiveEmployers)
                        ->with('totalnonActiveUsers',$totalnonActiveUsers)
                        ->with('totalEmployers',$totalEmployers)
                        ->with('trail',$trail)
                        ->with('basic',$basic)
                        ->with('standard',$standard)
                        ->with('premium',$premium)
                        ->with('users',$Users)
                        ->with('recentJobs', $recentJobs);

    }

}
