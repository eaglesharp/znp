

   <form class="form" id="add_front_profile_project" method="POST" action="{{ route('store.front.profile.projects', [$user->id]) }}">{{ csrf_field() }}
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <label class="mb-2 pt-3 sign_fontsize">IT Project Name<span
                        class="text-danger px-1">*</span></label>
                <input type="text" name="name" class="w-100 signup_input rounded px-3 py-2" requried
                    placeholder="Enter your Project Name" value="{{(isset($profileProject)? $profileProject->name:'')}}">
                  
                    <span class="help-block name-error"></span>
            </div>
            <div class="col-lg-6">
                <label class="mb-2 pt-3 sign_fontsize">Role in the project<span
                        class="text-danger px-1">*</span></label>
                <input type="text" name="role_in_project" value="{{(isset($profileProject)? $profileProject->role_in_project:'')}}" class="w-100 signup_input rounded px-3 py-2" requried
                    placeholder=" Enter your Role in the Project">
                    <span class="help-block role_in_project-error" ></span>
            </div>
            <div class="col-lg-6">
                <label class="mb-2 pt-3 sign_fontsize">Client<span
                        class="text-danger px-1">*</span></label>
                <input type="text" name="client"  class="w-100 signup_input rounded px-3 py-2" requried
                    placeholder="" value="{{(isset($profileProject)? $profileProject->client:'')}}" >
                    <span class="help-block client-error"></span>
            </div>
            <div class="col-lg-6">
                <label class="mb-2 pt-3 sign_fontsize">Domain<span
                        class="text-danger px-1">*</span></label>
                <input type="text" name="domain" class="w-100 signup_input rounded px-3 py-2" requried
                    placeholder="" value="{{(isset($profileProject)? $profileProject->domain:'')}}"> 
                    <span class="help-block domain-error"></span>
            </div>
            <div class="col-lg-6">
                <label class="mb-2 pt-3 sign_fontsize">Duration of the Project<span
                        class="text-danger px-1"> *</span></label>
                        <?php
                        $project_duration = (isset($profileProject) ? $profileProject->duration : null);
                        ?>
                        
                        {!! Form::select('duration', ['' => 'Select Duration']+MiscHelper::getprofilemonths1(), null , array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize newduration  signup_input rounded', 'id'=>'duration ')) !!}
                        <span class="help-block duration-error" style="color: #a94442"></span> 
               
            </div>
            <div class="col-lg-6">
                <label class="mb-2 pt-3 sign_fontsize">Project Type<span
                        class="text-danger px-1">*</span></label> 
                        <?php
                        $project_type = (isset($profileProject) ? $profileProject->project_type : '');
                      
                        ?>
                        {!! Form::select('project_type', ['' => 'Select Type']+MiscHelper::getprojecttype(), $project_type, array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded', 'id'=>'project_type')) !!}
                        <span class="help-block project_type-error" style="color: #a94442"></span> 
               
            </div>
            <div class="col-lg-12">
                <label class="mb-2 pt-3 sign_fontsize">Technologies Used in the
                    Project<span class="text-danger px-1">*</span></label>
                <input type="text" name="tech_used" class="w-100 signup_input rounded px-3 py-2" requried
                    placeholder=" Enter technologies used in the project" value="{{(isset($profileProject)? $profileProject->tech_used:'')}}">
                    <span class="help-block tech_used-error"></span>
            </div>
            <div class="col-lg-12">
                <label class="mb-2 pt-3 sign_fontsize">Project Description<span
                        class="text-danger px-1">*</span></label>
                <textarea class="w-100 signup_input rounded px-3 py-2" name="description"
                    placeholder="Project Description" maxlenghth="1000">{{(isset($profileProject)? $profileProject->description:'')}}</textarea>
                    <span class="help-block description-error"></span>
            </div>
        </div>
    </div>
    <!-- footer -->

</form>


{{-- <div class="modal-body">
    <div class="form-body">
        <div class="formrow" id="div_name">
            <input class="form-control" id="name" placeholder="{{__('Project Name')}}" name="name" type="text" value="{{(isset($profileProject)? $profileProject->name:'')}}">
            <span class="help-block name-error"></span> </div>

        @if(isset($profileProject))
        <div class="formrow">
            {{ImgUploader::print_image("project_images/thumb/$profileProject->image")}}
        </div>
        @endif

        <div class="formrow" id="div_image">
            <div class="uploadphotobx dropzone needsclick dz-clickable"  id="dropzone"> <i class="fa fa-upload" aria-hidden="true"></i>
                <div class="dz-message" data-dz-message><span>{{__('Drop files here or click to upload Project Image')}}.</span></div>
                <div class="fallback">
                    <input name="image" type="file" />
                </div>
            </div>
            <span class="help-block image-error"></span> </div>
        <div class="formrow" id="div_url">
            <input class="form-control" id="url" placeholder="{{__('Project URL')}}" name="url" type="text" value="{{(isset($profileProject)? $profileProject->url:'')}}">
            <span class="help-block url-error"></span> </div>
        <div class="formrow" id="div_date_start">
            <input class="form-control datepicker" id="date_start" placeholder="{{__('Project Start Date')}}" name="date_start" type="text" autocomplete="off" value="{{(isset($profileProject)? $profileProject->date_start:'')}}">
            <span class="help-block date_start-error"></span> </div>
        <div class="formrow" id="div_date_end">
            <input class="form-control datepicker" autocomplete="off" id="date_end" placeholder="{{__('Project End Date')}}" name="date_end" type="text" value="{{(isset($profileProject)? $profileProject->date_end:'')}}">
            <span class="help-block date_end-error"></span> </div>  

        <div class="formrow" id="div_is_on_going">
            <label for="is_on_going" class="bold">{{__('Is Currently Ongoing')}}?</label>
            <div class="radio-list">
                <?php
                $val_1_checked = '';
                $val_2_checked = 'checked="checked"';

                if (isset($profileProject) && $profileProject->is_on_going == 1) {
                    $val_1_checked = 'checked="checked"';
                    $val_2_checked = '';
                }
                ?>

                <label class="radio-inline"><input id="on_going" name="is_on_going" type="radio" value="1" {{$val_1_checked}}> {{__('Yes')}} </label>
                <label class="radio-inline"><input id="not_on_going" name="is_on_going" type="radio" value="0" {{$val_2_checked}}> {{__('No')}} </label>
            </div>
            <span class="help-block is_on_going-error"></span>
        </div>

        <div class="formrow" id="div_description">
            <textarea name="description" class="form-control" id="description" placeholder="{{__('Project description')}}">{{(isset($profileProject)? $profileProject->description:'')}}</textarea>
            <span class="help-block description-error"></span> </div>
    </div>
</div> --}}