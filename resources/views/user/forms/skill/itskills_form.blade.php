<div class="modal-body">

    <form class="form" id="add_edit_front_profile_skill" method="POST" action="{{ route('store.front.profile.skill', [$user->id]) }}">{{ csrf_field() }}

        <div class="row">

            <div class="col-lg-12">

                <div class="form-group" id="div_project_title">

                <label class="mb-2 sign_fontsize">Add Skill<span

                        class="text-danger px-1">*</span></label>

                <input type="text" name="project_title" class="w-100 signup_input rounded px-3 py-2" requried

                    placeholder="Enter the IT Skill">

                    <span class="help-block project_title-error"></span>

            </div>

        </div>

        </div>

        <div class="row">

            <div class="col-lg-12"> 

                <div class="form-group" id="div_version">

                <label class="mb-2 pt-3 sign_fontsize">Version<span

                        class="text-danger px-1">*</span></label>

                <input type="text" name="version" class="w-100 signup_input rounded px-3 py-2" min="1" requried

                    placeholder="Enter Version">

                    <span class="help-block version-error"></span>

            </div>

        </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">Last Used<span

                        class="text-danger px-1">*</span></label>

                        <?php 

                        $profileskill=(isset($profileSkill)  ? $profileSkill->last_used_year :'');

                        ?>

                      

                        {!! Form::select('last_used_year', [''=>'Select Year']+MiscHelper::getEstablishedIn(), $profileskill, array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded', 'id'=>'last_used_year')) !!}

                        <span class="help-block last_used_year-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <div class="form-group" id="div_no_of_projects">

                <label class="mb-2 pt-3 sign_fontsize">Number of Projects Completed<span

                        class="text-danger px-1">*</span></label>

                <input type="number" name="no_of_projects" min="0" max="100" onkeyup=imposeMinMax(this)

                    class="w-100 signup_input rounded px-3 py-2" requried

                    placeholder="Number of Projects Completed">

                    <span class="help-block no_of_projects-error"></span>

            </div>

        </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">No.of Years of Experience<span

                        class="text-danger px-1">*</span></label> <?php 

                        $profileskill=(isset($profileSkill) ? $profileSkill->job_experience :'');

                        ?>

                 

                        {!! Form::select('job_experience', [''=>'Select experience']+MiscHelper::getexperience(), $profileskill, array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded', 'id'=>'job_experience')) !!} <span class="help-block job_experience-error"></span>

              

            </div>

        </div>

    </form>

</div>