<div class="modal-body">
    <div class="form-body">
        <div class="form-group col-lg-6" id="div_name">
            <label for="name" class="bold">IT Project Name <span class="text-danger px-1">*</span></label>
            <input class="form-control" id="name" placeholder="Project Name" name="name"  type="text" required value="{{(isset($profileProject)? $profileProject->name:'')}}" >
            <span class="help-block name-error"></span> </div>
            
            <div class="form-group col-lg-6" id="div_role_in_project">
                <label for="Role in the project" class="bold">Role in the project <span class="text-danger px-1">*</span></label>
                <input class="form-control" id="role_in_project" placeholder="Role in the project"  required name="role_in_project" type="text" value="{{(isset($profileProject)? $profileProject->role_in_project:'')}}">
                <span class="help-block role_in_project-error" ></span> </div>

        {{-- @if(isset($profileProject))
        <div class="form-group">
            {{ImgUploader::print_image("project_images/thumb/$profileProject->image")}}
        </div>
        @endif

        <div class="form-group" id="div_image">
            <div class="uploadphotobx dropzone needsclick dz-clickable"  id="dropzone"> <i class="fa fa-upload" aria-hidden="true"></i>
                <div class="dz-message" data-dz-message><span>Drop files here or click to upload Project Image.</span></div>
                <div class="fallback">
                    <input name="image" type="file" multiple />
                </div>
            </div>
            <span class="help-block image-error"></span> </div> --}}
            {{-- <div class="form-group" id="div_image1">
                <div class="uploadphotobx dropzone needsclick dz-clickable"  id="dropzone"> <i class="fa fa-upload" aria-hidden="true"></i>
                    <div class="dz-message" data-dz-message><span>Drop files here or click to upload Project Image.</span></div>
                    <div class="fallback">
                        <input name="im1age" type="file" multiple />
                    </div>
                </div>
                <span class="help-block image-error"></span> </div> --}}
        <div class="form-group col-lg-6" id="div_client">
            <label for="client" class="bold">Client</label><span class="text-danger px-1">*</span>
            <input class="form-control" id="client" placeholder="client" name="client" type="text" value="{{(isset($profileProject)? $profileProject->client:'')}}">
            <span class="help-block client-error"></span> </div>
            
            <div class="form-group col-lg-6" id="div_domain">
                <label for="domain" class="bold">Domain</label><span class="text-danger px-1">*</span>
                <input class="form-control" id="domain" placeholder="Domain" name="domain" type="text" value="{{(isset($profileProject)? $profileProject->domain:'')}}" required>
                <span class="help-block domain-error"></span> </div>
                
{{--                 
                <option   value="1" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days=="1") selected @endif  @endif>Not Serving Notice Period</option>
                <option  value="2" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days=="2") selected @endif  @endif>Serving Notice Period</option>
                <option  value="3" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days=="3") selected @endif  @endif>Buyable Notice Period</option> --}}
                
            
            
            <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'duration') !!}"> 
            
                
                {!! Form::label('duration', 'Duration of the Project', ['class' => 'bold']) !!} <span class="text-danger px-1">*</span>
                
                <?php
                $project_duration = (isset($profileProject) ? $profileProject->duration : null);
                ?>
                
                {!! Form::select('duration', ['' => 'Select Duration']+MiscHelper::getprofilemonths1(), $project_duration , array('class'=>'form-control', 'id'=>'duration ')) !!}
                <span class="help-block duration-error" style="color: #a94442"></span> 
            </div>
                
                
                
                
                
                <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'project_type') !!}">
                
                {!! Form::label('project_type', 'Project Type', ['class' => 'bold']) !!} <span class="text-danger px-1">*</span>
                
                    <?php
                    $project_type = (isset($profileProject) ? $profileProject->project_type : '');
                  
                    ?>
                    {!! Form::select('project_type', ['' => 'Select Type']+MiscHelper::getprojecttype(), $project_type, array('class'=>'form-control', 'id'=>'project_type')) !!}
                    <span class="help-block project_type-error" style="color: #a94442"></span> 
                </div>
    
                
        <div class="form-group col-lg-12" id="div_tech_used">
            <label for="technologies" class="bold">Technologies Used in the Project <span class="text-danger px-1">*</span></label>
            <input class="form-control " autocomplete="off"  id="tech_used" placeholder="Technologies Used in the Project" name="tech_used" type="text" value="{{(isset($profileProject)? $profileProject->tech_used:'')}}">
            <span class="help-block tech_used-error"></span> </div>  

        {{-- <div class="form-group" id="div_is_on_going">
            <label for="is_on_going" class="bold">Currently Ongoing?</label>
            <div class="radio-list" style="margin-left:22px;">
            

                <label class="radio-inline"><input id="on_going" name="is_on_going" type="radio" value="1" {{$val_1_checked}}> Yes </label>
                <label class="radio-inline"><input id="not_on_going" name="is_on_going" type="radio" value="0" {{$val_2_checked}}> No </label>
            </div>
            <span class="help-block is_on_going-error"></span>
        </div> --}}
        
        
        <div class="form-group col-lg-12" id="div_description">
            <label for="name" class="bold">Project Description <span class="text-danger px-1">*</span></label>
            <textarea name="description" class="form-control" id="description" placeholder="Project description" required>{{(isset($profileProject)? $profileProject->description:'')}}</textarea>
            <span class="help-block description-error"></span> </div>
{{-- 
        <div class="form-group" id="div_description">
            <label for="name" class="bold">Project Description</label>
            <textarea name="description" class="form-control" id="description" placeholder="Project description" value="{{(isset($profileProject)? $profileProject->description:'')}}"></textarea>
            <span class="help-block description-error"></span> </div> --}}
    </div>
</div>