<div class="modal-body">

    <div class="form-body">

    

        <div class="form-group" id="div_project_title">

            <label for="project_title" class="bold">Add Skill <span class="text-danger px-1">*</span></label>

           <input type="text" class="form-control" id="project_title" placeholder="Enter Your IT Skill" name="project_title" value="{{(isset($profileSkill) ? $profileSkill->project_title : '')}}">

           <span class="help-block project_title-error"></span>

        </div>

            

        <div class="form-group" id="div_version">

            <label for="version" class="bold">Version <span class="text-danger px-1">*</span></label>

           <input type="text" class="form-control" id="version" placeholder="Enter Version" name="version" value="{{(isset($profileSkill) ? $profileSkill->version :'')}}" min="0">

           <span class="help-block version-error"></span>

        </div>

        

        {{-- <div class="form-group" id="div_date">

            <label for="date" class="bold">Last Used</label>

          {!! Form::text('date',[''=>'Last Used']+MiscHelper::getEstablishedIn(),null,array('class'=>'form-control','id'=>'date') ) !!}

        </div> --}}

        

 

        

        

        <div class="form-group" id="div_no_of_projects">

            <label for="version" class="bold">Number of Projects Completed <span class="text-danger px-1">*</span></label>

            <input type="number" class="form-control" placeholder="Number of Projects Completed" name="no_of_projects" value="{{(isset($profileSkill) ? $profileSkill->no_of_projects : '')}}" min="0">

            <span class="help-block no_of_projects-error"></span>

            

        </div>

        

    

        <div class="form-group" id="div_last_used_year">

            <label for="last_used_year" class="bold">Last Used</label> <span class="text-danger">*</span>

            <?php 

            $profileskill=(isset($profileSkill)  ? $profileSkill->last_used_year :'');

            ?>

          

            {!! Form::select('last_used_year', [''=>'Select Year']+MiscHelper::getEstablishedIn(), $profileskill, array('class'=>'form-control', 'id'=>'last_used_year')) !!}

            <span class="help-block last_used_year-error"></span> </div>

   

  

  

     

            

         {{-- <div class="form-group" id="div_job_skill_id">

            <label for="job_skill_id" class="bold">Add Skill</label>

            <?php

            $job_skill_id = (isset($profileSkill) ? $profileSkill->job_skill_id : null);

            ?>

            {!! Form::select('job_skill_id', [''=>'Select skill']+$jobSkills, $job_skill_id, array('class'=>'form-control', 'id'=>'job_skill_id')) !!} <span class="help-block job_skill_id-error"></span> </div>  --}}

            

         

            

        <div class="form-group" id="div_job_experience">

            <label for="job_experience" class="bold">No.of Years of Experience <span class="text-danger px-1">*</span></label>

            <?php 

            $profileskill=(isset($profileSkill) ? $profileSkill->job_experience :'');

            ?>

     

            {!! Form::select('job_experience', [''=>'Select experience']+MiscHelper::getexperience(), $profileskill, array('class'=>'form-control', 'id'=>'job_experience')) !!} <span class="help-block job_experience-error"></span> </div>

    </div>

</div>

