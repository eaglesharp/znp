<?php

namespace App\Traits;

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

trait CertificateTrait
{
    public function showProfileProjects(Request $request, $user_id)
    {
        $user = User::find($user_id);
        
        
        $html = '<div class="col-mid-12"><table class="table table-bordered table-condensed">';
        if (isset($user) && count($user->profileProjects)):
            $projectCounter = 0;
            foreach ($user->profileProjects as $project):
              
                

                $html .= '<tr id="cv_' . $project->id . '">
								
								<td>'.$project->name.'</td>
									
									<td> <a href="javascript:void(0);" onclick="showProfileProjectEditModal(' . $project->id . ');"class="text text-warning">' . __('Edit') . '</a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="delete_profile_project(' . $project->id . ');"class="text text-danger">' . __('Delete') . '</a></td>
								</tr>';
                                $projectCounter++;
                                if ($projectCounter == 4) {
                                    $projectCounter = 0;
                                    $html .= '<div style="clear:both;"></div>';
                                }
                            endforeach;
                        endif;
                
                        echo $html . '</table></div>';
            
         
        
    
    }
    
    public function storecertificate(CertificateFormRequest $request, $user_id)
    {

        $profileProject = new ProfileProject();
        $profileProject = $this->assignProjectValues($profileProject, $request, $user_id);
        $profileProject->save();

        $this->addProfileProjectImage($request, $profileProject);

        $returnHTML = view('admin.user.forms.project.project_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }

   

}
