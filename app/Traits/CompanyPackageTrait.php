<?php



namespace App\Traits;



use DB;

use Carbon\Carbon;

use App\Company;



trait CompanyPackageTrait

{



    public function addCompanyPackage($company, $package)

    {

        $now = Carbon::now();

        $company->package_id = $package->id;

        $company->package_start_date = $now;

        $company->package_end_date = $now->addDays($package->package_num_days);

      //  $company->cvs_package_id = $package->id;

      //  $company->cvs_package_start_date = $now;

      //  $company->cvs_package_end_date = $now->addDays($package->package_num_days);

        $company->email_quota = $package->package_num_listings;

        $company->normal_cv_access = $package->normal_cv_access;

        $company->cvs_quota = $package->cv_access;

        $company->availed_cvs_quota = 0;

        $company->free_cv_access = 5;

        $company->verified_cv_access = $package->verified_cv_access;

        $company->jobs_quota = $package->package_num_listings;

        $company->availed_normal_cv_access = 0;

        $company->availed_verified_cv_access = 0;

        $company->availed_email_quota = 0;

        $company->availed_jobs_quota = 0;

        $company->update();

    }

    public function updateCompanyPackage($company, $package)

    {

        $package_end_date = $company->package_end_date;

        //  if ($package_end_date !== null && $package_end_date->greaterThan(now())) {
        //     $current_end_date = Carbon::createFromDate(
        //         $package_end_date->format('Y'),
        //         $package_end_date->format('m'),
        //         $package_end_date->format('d')
        //     );
        // } else {
            $current_end_date = now();
        // }
       
        $company->package_start_date = now();
       
        $company->package_id = $package->id;

        $company->package_end_date = $current_end_date->addDays($package->package_num_days);

        //   $company->jobs_quota = ($company->jobs_quota - $company->availed_jobs_quota) + $package->package_num_listings;

        // $company->cvs_quota = ($company->cvs_quota - $company->availed_cvs_quota) + $package->cv_access;
        
        $company->cvs_quota =  $package->cv_access;

        // $company->email_quota = ($company->email_quota - $company->availed_email_quota) + $package->package_num_listings;
        
        $company->email_quota = $package->package_num_listings;

        // $company->normal_cv_access =($company->normal_cv_access - $company->availed_normal_cv_access) + $package->normal_cv_access;
        
        $company->normal_cv_access = $package->normal_cv_access;

        // $company->verified_cv_access = ($company->verified_cv_access - $company->availed_verified_cv_access)+$package->verified_cv_access;
       
        $company->verified_cv_access = $package->verified_cv_access;

        $company->availed_email_quota = 0;

        $company->availed_cvs_quota = 0;

        $company->availed_normal_cv_access = 0;

        $company->availed_verified_cv_access = 0;


        $company->update();

    }

 



}

