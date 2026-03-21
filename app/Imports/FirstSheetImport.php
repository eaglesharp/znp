<?php

namespace App\Imports;
use Auth;

use App\Certificate;
use App\Course;
use App\Offers;
use App\User;
use App\KeySkill;
use App\JobSkill;
use App\ProfileSummary;
use App\ProfileExperience;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Carbon\Carbon;
use App\ProfileProject;
use App\ProfileEducation;
use App\ProfileSkill;
use App\ProfileLanguage;
use App\ProfileNop;
use App\ProfileGap;
use App\ProfileCityJobsCity;
use App\ProfileDetails;
use Mail;
use App\Events\UserRegistered;
use App\Mail\NewUserRegistered;
use Illuminate\Support\Str;
use App\CompanyData;
use App\Jobs\BulkUserStore;
use App\Degree;




class FirstSheetImport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements ToCollection, WithHeadingRow,WithCustomValueBinder 
{
    
    public function unixdatechange($date){
    
    //  $newDate = date("Y-m-d", strtotime($date));
    // dd($newDate);
    $var = '20/04/2012';
$date = str_replace('/', '-', $date);
$newDate = date('Y-m-d', strtotime($date));
// dd($newDate);
        return $newDate;
    }

    public function dbdatechange($date)

    {

    $date= date("Y-m-d", strtotime($date));

    return $date;

    }
    
    public function exceldatechange($date)
    {
        $convertdate =  Carbon::createFromFormat('j-M-y', $date);
        
        // $convertdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);

        return  $convertdate->format('Y-m-d');
        
    }

    public function companydatechange($date){

        $newDate = date("Y-m-d", strtotime($date));
        return $newDate;
    }
    
    public function collection(Collection $rows)
    {
          //  return dd($rows);
        //  $password = 'required|min:6';
        Validator::make($rows->toArray(), [
        

            '*.recruiter_email' => 'required|email',

            '*.recruiter_phone' => 'required',
            
            '*.first_name' => 'required',

           // '*.last_name' => 'required',

            '*noticeperiod_status'  =>'required|in:1,2',

            '*.last_working_day' => 'required_if:noticeperiod_status,2',

            '*.immediate_last_date' =>'required_if:noticeperiod_status,1',

            '*preferred_work_type'  =>'required|in:1,2,3',

            '*.email' => 'required|unique:users,email|email',
            // '*.password' => $password,

            '*.phone_number' => 'required',

            '*.current_ctc_lakhs' => 'required|numeric',

            '*.current_ctc_thousand' => 'required|numeric',

            '*.expect_ctc_lakhs' => 'required|numeric',

            '*.expect_ctc_thousand' => 'required|numeric',  

            '*.latest_company' => 'required',

            '*.latest_designation' => 'required',

          //  '*.ignore_companies' => 'required',

            '*.totalexpyear' => 'required',

            '*.totalexpmonth' => 'required',

            '*.current_city' => 'required',

            '*.keyskills' => 'required',

            '*.highest_education'  => 'required|in:2,3,4,5',

            '*.education_status' => 'required',

            '*.course'  => 'required_if:highest_education,2,3,4',

            '*.specilation'  => 'required_if:highest_education,2,3,4', 
            
            '*.university'  => 'required_if:highest_education,2,3,4',

            '*.reason_moved'  => 'required',
            
            '*.active' => 'required',

            '*.verified' => 'required',

            '*.gender'  => 'required',

            '*.preferred_mode' => 'required'

           
        ])->validate();
            // return dd($rows);
            $count = 0;

        //     dispatch(new App\Jobs\BulkUserStore($rows));

        //    // BulkUserStore::dispatch($rows)->delay(now()->addMinutes(2));;

           //  dd('validation successs');
           
           
           

        foreach ($rows as $row) {

            //dd($row);
            
           // dd($this->exceldatechange($row['last_working_day']));

            $password=Str::random(8);           

           // $password = Hash::make($randompassword);

         


           $ig_companies= (explode(",",$row['ignore_companies']));

        
           $ignored_companies = [];
        
           if($row['ignore_companies'])
           {
               foreach($ig_companies as $company)
   
              {
               // dd($company);
   
               if (is_numeric($company)){
   
                   $company_data_val = CompanyData::where('id',$company)->first();
               
               }else{
           
                   $company_data_val = new CompanyData();
                   $company_data_val->name = $company;
                   $company_data_val->save();
               
               }
   
               $ignored_companies[] = $company_data_val->id;
        
          }
           }else{
                $ignored_companies = NULL;
           }


           //dd($ignored_companies);


            $user = User::create([

                'first_name' =>  $row['first_name'],
    
                'last_name' => $row['last_name'],
    
                'email'     => $row['email'],
    
                'phone'   => $row['phone_number'],
    
                'password' => bcrypt($password),
    
                'current_city'  =>  $row['current_city'] ,
    
                'is_active' =>$row['active'],
    
                'verified'   => $row['verified'],

                'recruiter_comments'   => $row['recruiter_comments'],

                'ignore_companies' =>  serialize($ignored_companies),

                'reason_moved'  => $row['reason_moved'],
     
                'recruiter_email'  => $row['recruiter_email'],
     
                'recruiter_phone'  => $row['recruiter_phone'],
     
    
                'email_verified'  => 1,
    
                'phone_verified'  => 0,
    
                'no_profile_views' => 0,
    
                'no_of_downloads' =>0,
    
                'no_of_emails'  => 0,
    
                'complete'   => 3,
    
                'profile_completion' => 2,
    
                'payment_status' => 0,

                'added' => 1,
                
                'added_by' => Auth::user()->id,
                
                'prefered_city' => serialize($row['prefered_city'])
    
        
            ]);
            
           


            $profileNP = ProfileNop::where('user_id', '=', $user->id)->first();

            if($profileNP)
    
            {
    
                $profileNP->nop_days = $row['noticeperiod_status'] ;
    
                $profileNP->last_working_day = $this->exceldatechange($row['last_working_day'])??'';
    
                $profileNP->immediate_last_date = $this->exceldatechange($row['immediate_last_date']);
    
                // $profileNP->contract = $request->contract;
    
                $profileNP->save();
    
            }else{
    
                $nop = new ProfileNop();
    
                $nop->user_id = $user->id;

                $nop->nop_days = $row['noticeperiod_status'];
                
                $nop->last_working_day = $this->exceldatechange($row['last_working_day'])??'';
    
                $nop->immediate_last_date = $this->exceldatechange($row['immediate_last_date']);  
               
    
                // $nop->contract = $request->contract;
    
                $nop->save();
    
            }


            $compensation = ProfileDetails::where('user_id', '=', $user->id)->first();


            if($compensation)
            {
                $compensation->candidate_wfh = $row['preferred_mode']??'';
                $compensation->expect_ctc_lakhs = $row['current_ctc_lakhs'];
                $compensation->expect_ctc_thousand = $row['current_ctc_thousand'];
                $compensation->expect_ctc_lakhs3 = $row['expect_ctc_lakhs'];
                $compensation->expect_ctc_thousand3 = $row['expect_ctc_thousand'];
                $compensation->work_type = $row['preferred_work_type'];
                $compensation->save();
            }else{
    
                $newcompensation = new ProfileDetails();
                $newcompensation->user_id = $user->id;
                $newcompensation->candidate_wfh = $row['preferred_mode']??'';
                $newcompensation->expect_ctc_lakhs = $row['current_ctc_lakhs'];
                $newcompensation->expect_ctc_thousand = $row['current_ctc_thousand'];
                $newcompensation->expect_ctc_lakhs3 = $row['expect_ctc_lakhs'];
                $newcompensation->expect_ctc_thousand3 = $row['expect_ctc_thousand'];
                $newcompensation->work_type = $row['preferred_work_type'];
                $newcompensation->save();
    
            }

            if (is_numeric($row['latest_company'])){

                $company_data_val = CompanyData::where('id',$row['latest_company'])->first();
            
            }else{
        
                $company_data_val = new CompanyData();
                $company_data_val->name = $row['latest_company'];
                $company_data_val->save();
            
            }
            
    
    
            $summary = ProfileSummary::where('user_id', '=', $user->id)->first();
    
    
            if($summary)
            {
                $summary->latestcom = $company_data_val->name;
                $summary->latestcom_id = $company_data_val->id;            
                $summary->latestdesg = $row['latest_designation'];
                $summary->totalexp = $row['latest_company'];
                $summary->totalexpmonth = $row['totalexpmonth'];
                $summary->save();
            }else{
    
                $newsummary = new ProfileSummary();
                $newsummary->user_id = $user->id;
                $newsummary->latestcom = $company_data_val->name;
                $newsummary->latestcom_id = $company_data_val->id;
                $newsummary->latestdesg = $row['latest_designation'];
                $newsummary->totalexp = $row['latest_company'];
                $newsummary->totalexpmonth = $row['totalexpmonth'];
                $newsummary->save();
    
            }

            
            if($row['keyskills'])

            {
    
            // dd($request->keyskills);
    
    
                $delete = KeySkill::where('user_id',$user->id)->get();
    
                // dd($delete);
    
                if($delete)
    
                {
    
                
    
                    foreach($delete as $dele)
    
                    {
    
                    $dele->delete();
    
                    }
    
                }

                $keysk= (explode(",",$row['keyskills']));
    
    
                foreach($keysk as $keyskill)
    
                {
                
    
    
                        $skills = JobSkill::where('id',$keyskill)->get();
    
    
    
    
                        if(count($skills) > 0)
                        {
    
                            $key_new= new KeySkill();
    
                            $key_new->user_id=$user->id;
    
                            $key_new->keyskill =$keyskill;
    
                            $key_new->save();
                        
    
                        }else{
    
                            $key_new= new JobSkill();            
    
                            $key_new->job_skill =$keyskill;
    
                            $key_new->save();
    
    
                            $key_sk= new KeySkill();
    
                            $key_sk->user_id=$user->id;
    
                            $key_sk->keyskill =$key_new->id;
    
                            $key_sk->save();
                            
                        }
                        
                    }

                    $education = ProfileEducation::where('user_id', '=', $user->id)->first();


                    if($education)
                    {
                        if (is_numeric($row['university'])){
               
                        $education->degree_title =  $row['highest_education'];
                        $education->course = $row['course']??'NULL';
                         $education->education_status = $row['education_status'];
                        $education->specilation = $row['specilation']??'NULL';
                        $education->organization = $row['university'];
                        $education->save();
                    
                    }else{
                
                        $organization = new Degree();
                        $organization->educations = $row['university'];
                        $organization->save();
                        
                        $education->degree_title =  $row['highest_education'];
                        $education->course = $row['course']??'NULL';
                         $education->education_status = $row['education_status'];
                        $education->specilation = $row['specilation']??'NULL';
                        $education->organization = $organization->id;
                        $education->save();
                    
                    }
                       
            
                        
                        
                    }else{           
                   
                       // dd($row['university']);
            
                        $education = new ProfileEducation();
                        $education->user_id = $user->id;
                        $education->degree_title = $row['highest_education'];
                        $education->education_status = $row['education_status'];
                        $education->course = $row['course']??'NULL';
                        $education->specilation = $row['specilation']??'NULL';
                        if($row['university'])
                        {
                            if (is_numeric($row['university']) ){
                                $education->organization = $row['university'];
                                }else{
                                    $organization = new Degree();
                                    $organization->educations = $row['university'];
                                    $organization->save();
                                $education->organization =  $organization->id;
                                }
                        }else{
                            $education->organization =  NULL;
            
                        }
                      
                        $education->save();
                    
                    }
            


    
                    $user = User::where('id',$user->id)->first();
    
                    $user->complete = $user->complete + 3;
    
                    $user->profile_completion = $user->profile_completion + 2;

                    $user->gender_id = $row['gender'];
    
                    $user->save();

                    //Mail::send(new NewUserRegistered($user,$password));
    
        
            }
    
    

        }


        
    }
}