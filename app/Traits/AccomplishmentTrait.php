<?php

namespace App\Traits;

use App\Accomplishment;
use File;
use ImgUploader;
use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\User;
use App\ProfileProject;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ProfileProjectFormRequest;
use App\Http\Requests\ProfileProjectImageFormRequest;
use Illuminate\Support\Str;

trait AccomplishmentTrait
{
    public function showaccomplishments(Request $request, $user_id)
    {
       
        
        $user = Accomplishment::where('user_id',$user_id)->get();

       // dd($user);  

        $html = '<div class="col-mid-12">
                <table class="table table-bordered table-condensed">';          
        
        foreach ($user as $acc):        
            $html .= '<tr id="acc_' . $acc->id . '">
            <td>' . $acc->profile_name . '</td>
            <td><a href="javascript:;" onclick="showaccEditModal(' . $acc->id . ');"  class="text text-warning">' . __('Edit') . '</a>&nbsp;|&nbsp;<a href="javascript:;" onclick="delete_acc(' . $acc->id . ');" class="text text-danger">' . __('Delete') . '</a></td>   </tr>';
        endforeach;
           
        echo $html . '</table></div>';
        
            

    }

    public function getProfileaccomplishmentForm(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $returnHTML = view('admin.user.forms.accomplishment.accomplishment_modal')->with('user', $user)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }


    public function storeaccomplishment(Request $request, $user_id)
    {

        $request->validate([

            'profile_name' => 'required|max:256',
            'profile_url' => 'required|max:256',
            'description' => 'required|max:1000'
        ]);
    
       
      
        $acc = new Accomplishment();
        $acc->user_id = $user_id;
        $acc->profile_name = $request->profile_name;
        $acc->profile_url = $request->profile_url;
        $acc->description = $request->description;
        $acc->save();

        $returnHTML = view('admin.user.forms.accomplishment.accomplishment_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }


    public function getaccomplishmentEditForm(Request $request, $user_id)
    {
        $accomplishment_id = $request->input('accomplishment_id');
        $accomplishment = Accomplishment::find($accomplishment_id);
        $user = User::find($user_id);
        $returnHTML = view('admin.user.forms.accomplishment.accomplishment_edit_modal')
                ->with('user', $user)
                ->with('accomplishment', $accomplishment)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }


    public function updateaccomplishment(Request $request, $accomplishment_id, $user_id)
    {

        
        $request->validate([

            'profile_name' => 'required|max:256',
            'profile_url' => 'required|max:256',
            'description' => 'required|max:1000'
        ]);        

        $acc = Accomplishment::find($accomplishment_id);
      
        $acc->user_id = $user_id;
        $acc->profile_name = $request->profile_name;
        $acc->profile_url = $request->profile_url;
        $acc->description = $request->description;
        $acc->save();

        $returnHTML = view('admin.user.forms.accomplishment.accomplishment_edit_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }


     
    public function deleteaccomplishments(Request $request)
    {
        $id = $request->input('id');
        echo $this->accomplishment($id);
    }

    
    private function accomplishment($id)
    {
        try {
           
            $certificate = Accomplishment::findOrFail($id);
            $certificate->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }
    
    
    
    
    
   

   

}
