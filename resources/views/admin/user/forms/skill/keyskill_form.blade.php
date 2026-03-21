<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">

<link rel="stylesheet" href="/resources/demos/style.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.default.css">
<style>
    .exampleSearch .select2-container {
    width: 100%!important; 
    
}
.exampleSearch .select2-selection {
    height: 100%!important; 
    display:flex!important;
    
}
</style>
<div class="modal-body">

    <div class="form-body">

        <div class="form-group  kskills " id="div_project_title">

           <div class="modal-body ">

               <?php

               $keyskill=\App\KeySkill::where('user_id',$user->id)->get();





               //  $t4=(isset($skill) ? $skill->keyskill:'');

               //  echo $skill

               ?>

                <label for="project_title" class="bold">Update Key Skills <span class="text-danger px-1">*</span></label> (Next Skill use , Comma )<br>  <br>
                <label class="mb-2 pt-3 sign_fontsize">Mention your key skills<span
                    class="text-danger px-1">*</span></label>
               <select name="keyskills[]" placeholder="Please enter key skills or technologies" id="search30" multiple="multiple">

            

                  



               </select>



               {{ csrf_field() }}

                <span class="help-block keyskills-error" style="color:#a94442"></span>

          </div>

        </div>





    </div>

</div>

