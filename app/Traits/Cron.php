<?php



namespace App\Traits;



use Mail;

use DB;

use Carbon\Carbon;

use App\User;

use App\Company;

use App\Package;

use App\SiteSetting;

use Auth;



trait Cron

{



    private function runCheckPackageValidity()

    {

        $now = Carbon::now();

     

        $company_ids = Company::select('id')->where('cvs_package_end_date', '<', $now)->pluck('id')->toArray();
       //dd($company_ids);

        if (count($company_ids) > 0) {

            DB::table('companies')->whereIn('id', $company_ids)->update(array('package_id' => 0, 'package_start_date' => null, 'package_end_date' => null));

        }

    }



}

