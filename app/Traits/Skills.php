<?php

namespace App\Traits;
use App\JobSkill;

use App\JobSkillManager;

trait Skills
{

    private function storeJobSkills($request, $job_id)
    {
       
        if ($request->has('keyskills')) {
            JobSkillManager::where('job_id', '=', $job_id)->delete();
            $skills = $request->input('keyskills');
            foreach ($skills as $job_skill_id) {

              
                $jobSkillManager = new JobSkillManager();
                $jobSkillManager->job_id = $job_id;
              
                if (is_numeric($job_skill_id)){
                
                  $jobSkillManager->job_skill_id = $job_skill_id;
                   
       
                }else{  
                    
                    $key_new= new JobSkill();            

                    $key_new->job_skill =$job_skill_id;
       
                    $key_new->save();  
                    
                    $jobSkillManager->job_skill_id = $key_new->id;           
                    
                    
                }
                
                $jobSkillManager->save();
            }
        }
    }
    
    
    public function getProfilekeySkillEditForm( $request, $user_id)
    {
      
        $returnHTML = view('admin.user.forms.skill.cv_edit_modal')
                ->with('user', $user)
                ->with('profileCv', $profileCv)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

}
