<?php

namespace App\Traits;

use App\ProfileSummary;
use App\CompanyData;
use App\Http\Requests\ProfileSummaryFormRequest;
use App\User;

trait ProfileSummaryTrait
{

    public function updateProfileSummary($user_id, ProfileSummaryFormRequest $request)
    {
        if (is_numeric($request->input('latestcom'))){

            $company_data_val = CompanyData::where('id',$request->input('latestcom'))->first();
        
        }else{
    
            $company_data_val = new CompanyData();
            $company_data_val->name = $request->input('latestcom');
            $company_data_val->save();
        
        }
        $user = User::where('id',$user_id)->first();
        $user->reason_moved = $request->input('reason_moved');
        $user->save();
        

        ProfileSummary::where('user_id', '=', $user_id)->delete();
        $summary = $request->input('summary');
        $ProfileSummary = new ProfileSummary();
        $ProfileSummary->user_id = $user_id;
        $ProfileSummary->summary = $summary;
        $ProfileSummary->totalexp=$request->input('totalexp');
        $ProfileSummary->totalexpmonth=$request->input('totalexpmonth');
        
        
        $ProfileSummary->latestcom = $company_data_val->name;
    
        $ProfileSummary->latestcom_id = $company_data_val->id;
        $ProfileSummary->latestdesg=$request->input('latestdesg');
        $ProfileSummary->currentshift=$request->input('currentshift');
        $ProfileSummary->save();
        
        
    //     $summary_id=ProfileSummary::where('user_id',$user_id)->first();
        
    //     if($summary_id){    
           
    //         $summary->user_id=$user_id;
    //         $summary->summary=$request->input('summary');
    //         $summary->totalexp=$request->input('totalexp');
    //         $summary->totalexpmonth=$request->input('totalexpmonth');
    //         $summary->save();
        
     
        
    // }else{
    
    //     $summary=new ProfileSummary();
    //     $summary->user_id=$user_id;
    //     $summary->summary=$request->input('summary');
    //     $summary->totalexp=$request->input('totalexp');
    //     $summary->totalexpmonth=$request->input('totalexpmonth');
    //     $summary->save();
    
    
    // }
        
        
        
        
        
        
        /*         * ************************************ */
        return response()->json(array('success' => true, 'status' => 200), 200);
    }
    

}
