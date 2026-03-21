{{-- {!! APFrmErrHelp::showErrorsNotice($errors) !!} --}}

@include('flash::message')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<style>
    .preferred-city .btn-group {
        max-width: 100%;
        display: grid;
    }
    .preferred-city .multiselect {
        text-align: left;
    }
    .preferred-city .multiselect-container {
        min-width: 100%;
    }
    .help-block-error {
        color: #a94442;
    }
    </style>

@if ($user->id)
{{-- @php $user_data = $user @endphp  --}}
    {!! Form::model($user, array('method' => 'put', 'route' => array('update.user', $user->id), 'class' => 'form', 'files'=>true,'enctype'=>'multipart/form-data')) !!} 
@else
    {!! Form::open(array('method' => 'post', 'route' => 'store.user', 'class' => 'form', 'files'=>true)) !!}
@endif


@if(count($errors) > 0 )
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <ul class="p-0 m-0" style="list-style: none;">
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-body">    

    <input type="hidden" name="front_or_admin" value="admin" />


    <div class="row">
    <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'recruiter_email') !!}">

    

        {!! Form::label('recruiter_email', 'Recruiter Email ', ['class' => 'bold'])  !!} 

        <span class="text-danger px-1">*</span>

        {!! Form::text('recruiter_email', null, array('class'=>'form-control', 'id'=>'recruiter_email', 'placeholder'=>'Recruiter Email')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'recruiter_email') !!}                                       

    </div>
    
    <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'recruiter_phone') !!}">

    

        {!! Form::label('recruiter_phone', 'Recruiter Phone', ['class' => 'bold'])  !!} 

        <span class="text-danger px-1">*</span>

        {!! Form::text('recruiter_phone', null, array('class'=>'form-control', 'id'=>'recruiter_phone', 'placeholder'=>'Recruiter Phone')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'recruiter_phone') !!}                                       

    </div>
</div>
<div class="row">
    <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'first_name') !!}">

    

        {!! Form::label('first_name', 'First Name ', ['class' => 'bold'])  !!} 

        <span class="text-danger px-1">*</span>

        {!! Form::text('first_name', null, array('class'=>'form-control', 'id'=>'first_name', 'placeholder'=>'First Name')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'first_name') !!}                                       

    </div>

    <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'last_name') !!}">

        {!! Form::label('last_name', 'Last Name', ['class' => 'bold']) !!} 

        {!! Form::text('last_name', null, array('class'=>'form-control', 'id'=>'last_name', 'placeholder'=>'Last Name')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'last_name') !!}                                       

    </div>
</div>
    <div class="row">
    <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'nop_days') !!}">

        {!! Form::label('nop_days', 'Notice Period Status', ['class' => 'bold']) !!}     

        <span class="text-danger px-1">*</span>

        
        <select name="nop_days"
        class="form-control"
        id="multiple-select-employee_notice">

        <option selected disabled>Select Option</option>

        <option value="1" {{ old('nop_days') == 1 ? 'selected' : '' }}>Immediately Available
        </option>

        <option value="2" {{ old('nop_days') == 2 ? 'selected' : '' }}>Serving Notice Period
        </option>

       </select>

        {!! APFrmErrHelp::showErrors($errors, 'nop_days') !!}                                       

    </div>

    <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'work_type') !!}">

        {!! Form::label('work_type', 'Preferred Work Type', ['class' => 'bold']) !!}     

        <span class="text-danger px-1">*</span>

        
        <select name="work_type"
        class="form-control"
        id="multiple-select-employee_notice">

        <option selected disabled>Select Work Type</option>

        <option   value="Contract" @if(old('work_type') == 'Contract')selected @endif>Contract</option>

        <option  value="Permanent" @if(old('work_type') == 'Permanent')selected @endif>Permanent</option>

        {{-- <option  value="Freelance" @if(old('work_type') == 'Freelance')selected @endif>Freelance</option> --}}

        <option  value="Flexible" @if(old('work_type') == 'Flexible')selected @endif>Flexible</option>

        </select>

        {!! APFrmErrHelp::showErrors($errors, 'work_type') !!}                                       

    </div>

</div>
    <div class="row">
    <div class="form-group col-md-6">
        <div id="appendforimmednot"  @if(old('immediate_last_date')) style="display:block" @else style="display:none" @endif>
                    <div class="row" id="test_yes1">

                        <div class="col-lg-12">

                            <label class="mb-2 pt-3 sign_fontsize">Mention your Last Working Date with your last employer OR your Month of graduation in case you are a fresher<span class="text-danger px-1">*</span></label>

                            <input type="text" name="immediate_last_date" class="form-control datepicker-month  newtest "  value="{{ old('immediate_last_date') }}" id="appendforsnpinputserveout">
                            @if($errors->has('immediate_last_date'))<span class="help-block "
                                    style="color: red">{{$errors->first('immediate_last_date')}}</span>
                                @endif
                            
                                
                                @if($errors->has('confirm_nop'))<span class="help-block "
                                    style="color: red">{{$errors->first('confirm_nop')}}</span>
                                @endif
                            <span class="help-block immediate_last_date-error" style="color:#a94442"></span>
                        </div>
                    </div>
        </div>
    </div>

    <div class="form-group col-md-6">
        <div id="appendforServenot" style="display:none" >
                <div class="row" id="test_yes1">

                        <div class="col-lg-12">

                            <label class="mb-2 pt-3 sign_fontsize">Last working date incase notice period is being served<span class="text-danger px-1">*</span></label>

                            <input type="text" name="last_working_day" class="form-control datepicker  newtest  " value="{{ old('last_working_day') }}" id="appendforsnpinputserveout">
                            
                            
                            {!! APFrmErrHelp::showErrors($errors, 'last_working_day') !!}   
                                
                        </div>
                </div>
        </div>
    </div>

</div>
    <div class="row">
    <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'email') !!}">

            {!! Form::label('email', 'Email ID', ['class' => 'bold']) !!}  

            <span class="text-danger px-1">*</span>

            {!! Form::text('email', null, array('class'=>'form-control', 'id'=>'email', 'placeholder'=>'Enter your Email')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'email') !!}  

            @if(session()->has('emailerror'))

            <span class="help-block repoff-error" style="color:#a94442"> 

            {{ session()->get('emailerror') }}

            </span>

            @endif

    </div>

    <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'phone') !!}">

            {!! Form::label('phone', 'Phone number', ['class' => 'bold']) !!}    

            <span class="text-danger px-1">*</span>

            {!! Form::number('phone', null, array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>'Phone number')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'phone') !!}                                       

    </div>
</div>
    <div class="row">
    <div class="form-group col-md-12">
        {!! Form::label('expect_ctc_lakhs', 'Current Total CTC per annum (Fixed + Variable + Bonus
        + Incentives + Benefits)', ['class' => 'bold']) !!}  
        <span class="text-danger px-1">*</span>
    </div>
</div>
    <div class="row">
    <div class="form-group col-md-6 pb-3 pb-lg-0 position_lit">
        <input type="number" onkeyup=imposeMinMax(this) min="1" max="100" placeholder="Lakh"
            class="form-control"
            name="expect_ctc_lakhs" value="{{ old('expect_ctc_lakhs') }}">
        
            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_lakhs') !!}
    </div>

    <div class="form-group col-md-6  pb-lg-0 position_lit">
        <input type="number" onkeyup=imposeMinMax(this) min="0" max="99" placeholder="Thousand"
            class="form-control"
            name="expect_ctc_thousand" value="{{ old('expect_ctc_thousand') }}">
        
            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_thousand') !!}
    </div>

</div>
    <div class="row">
    <div class="form-group col-md-12">
        {!! Form::label('current_city', 'Expected CTC per annum', ['class' => 'bold']) !!}  
        <span class="text-danger px-1">*</span>
    </div>
</div>
    <div class="row">
    <div class="form-group col-md-6 pb-3 pb-lg-0 position_lit">
        <input type="number" onkeyup=imposeMinMax(this) min="1" max="100" placeholder="Lakh"
            class="form-control"
            name="expect_ctc_lakhs3" value="{{ old('expect_ctc_lakhs3') }}">
        
            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_lakhs3') !!}
    </div>
    
    <div class="form-group col-md-6  pb-lg-0 position_lit">
        <input type="number" onkeyup=imposeMinMax(this) min="0" max="99" placeholder="Thousand"
            class="form-control"
            name="expect_ctc_thousand3" value="{{ old('expect_ctc_thousand3') }}">
        
            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_thousand3') !!}
    </div>

</div>
    <div class="row">

            <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'latestcom') !!}">

                    {!! Form::label('latestcom', 'Latest Company', ['class' => 'bold']) !!}    

                    <span class="text-danger px-1">*</span>

                    @php
                    $datas = DB::table('company_data')->select('id','name')->distinct()->get();
                    @endphp

                    <select name="latestcom" class="form-control js-example-tags">
                        <option selected disabled>Latest Company</option>
                    @foreach ($datas as $c_data)
                    <option value="{{ $c_data->id }}" @if(old('latestcom') == $c_data->id)selected @endif
         
                        >{{ $c_data->name }}</option>
                    @endforeach                       
                    
                    </select>

                    {!! APFrmErrHelp::showErrors($errors, 'latestcom') !!}                                       

            </div>

            <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'latestdesg') !!}">

                {!! Form::label('latestdesg', 'Latest Designation', ['class' => 'bold']) !!}    

                <span class="text-danger px-1">*</span>

                {!! Form::text('latestdesg', null, array('class'=>'form-control', 'id'=>'latestdesg', 'placeholder'=>'Latest Designation')) !!}

                {!! APFrmErrHelp::showErrors($errors, 'latestdesg') !!}                                       

            </div>  
</div>
    <div class="row">
            <div class="form-group col-md-12 {!! APFrmErrHelp::hasError($errors, 'latestdesg') !!}">

                {{-- {!! Form::label('latestdesg', 'Jobsearch Privacy: Hide your CV from view by the Employers (Current/Past)', ['class' => 'bold']) !!}     --}}
                <label class="bold ignore-i">Jobsearch Privacy: Hide your CV from view by the Employers (Current/Past) <i class="fa fa-info-circle"
                    data-toggle="tooltip" title="This is a privacy option. This wiill help you not be found by the employers (Current/Past) you choose to hide your CV from"></i></label>



                {{-- {!! Form::select('ignore_companies[]', null, array('class'=>'form-control', 'id'=>'ignore_companies', 'placeholder'=>'Lastest Designation','multiple'=>'multiple')) !!} --}}

                <select class="form-control" id="ignore_companies" name="ignore_companies[]" multiple="multiple" >
                                                                                                                               
                </select>
                {!! APFrmErrHelp::showErrors($errors, 'latestdesg') !!}                                       

            </div>  
</div>
    <div class="row">

            
            <div class="form-group col-md-12">
                {!! Form::label('totalexp', 'Total Experience', ['class' => 'bold']) !!}  
                <span class="text-danger px-1">*</span>
            </div>
            </div>
    <div class="row">
            <div class="form-group col-md-6 pb-3 pb-lg-0 position_lit">

                {!! Form::select('totalexp',[''=>'Select Year']+MiscHelper::gettotalexp(),null,array('class'=>'form-control','id'=>'totalexp')  )  !!}  
                
                    {!! APFrmErrHelp::showErrors($errors, 'totalexp') !!}
            </div>
            <div class="form-group col-md-6  pb-lg-0 position_lit">
                {!! Form::select('totalexpmonth',[''=>'Select Month']+MiscHelper::getprofilemonths(),null,array('class'=>'form-control','id'=>'totalexpmonth')  )  !!}  
                        
                
                    {!! APFrmErrHelp::showErrors($errors, 'totalexpmonth') !!}
            </div>

</div>
    <div class="row">
            <div class="form-group col-md-6" id="div_resume">

                    <label for="resume" class="bold">Attach Resume</label>

                    <input name="resume" id="resume" type="file" value=""><br>

                        @if($errors->has('resume'))

                          <span class="error" style="color:#a94442">{{$errors->first('resume')}}</span>
 
                        @endif

                        <p >Upload resume will accept only .pdf and .docx, Size should be lesser than 2 MB.</p>

     

                @if(isset($user->id))

                            @if((isset($user->showcvs()->resume) ? $user->showcvs()->resume :''))

                        

                            <div class="form-group " style="border 1px solid"><br>

                                        <?php 

                                    $file=(isset($user->showcvs()->resume) ? $user->showcvs()->resume :'');

                                    ?>

                                    <button class="btn ">{{ImgUploader::print_doc("cvs/$file", $file, $file)}} </button> <a href="{{url('admin/delete-resume',$user->id)}}" class="btn btn-danger">Delete</a>

                                

                            </div> 

                            @endif

                @endif

        <span class="help-block resume-error"></span>

        </div>

        <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'current_city') !!}">

            {!! Form::label('current_city', 'Current City', ['class' => 'bold']) !!}  
        
            <span class="text-danger px-1">*</span>
        
            {!! Form::text('current_city', null, array('class'=>'form-control', 'id'=>'autocomplete6', 'placeholder'=>'Enter a Location')) !!}
        
            {!! APFrmErrHelp::showErrors($errors, 'current_city') !!}                                       
        
        </div>
        <div class="form-group  col-md-6 preferred-city {!! APFrmErrHelp::hasError($errors, 'prefered_city') !!}">
            {!! Form::label('prefered_city', ' Preferred Cities', ['class' => 'bold']) !!}  
            <span class="text-danger px-1">*</span>
            <br>

            <select class="form-control select-box" name="prefered_city[]" multiple="multiple" placeholder="Please enter location" id="locationFilter41">                    
            </select>

            {!! APFrmErrHelp::showErrors($errors, 'prefered_city') !!}                                       
        </div>

</div>
    <div class="row">
        <div class="form-group col-md-12" style="margin-bottom:20px" id="my-select-container" >

            <label class="sign_fontsize">Key Skills<span class="text-danger px-1">* </span></label>
    
                         <span id="selected-count" style="color:green"></span>
                         <span id="skill-error" style="color: red;"></span>
                            <select class="form-control js-example-tokenizer" name="keyskills[]" multiple="multiple" placeholder="Please enter key skills or technologies" id="my-select">
                              
                                   
    
                                    <?php                            
    
                                  
                                    $job_skills=\App\JobSkill::all()->unique('job_skill')->take(2000);
                                    
                                    
                                    ?>
    
    
                                    @foreach($job_skills as $skill)
                                    <!--<option value="{{ $skill->id }}" {{ in_array($skill->id, old('keyskills', [])) ? 'selected' : '' }}>{{ $skill->job_skill}}</option>-->
                                        <option value="{{ $skill->id }}" {{ in_array($skill->id, old('keyskills', [])) ? 'selected' : '' }}>{{ $skill->job_skill}}</option>
                                            
                        
                                     @endforeach

                                     
                                     @foreach(old('keyskills', []) as $item)

                                     @if(is_numeric($item))
                                   
                                       
                                     @else
 
                                     <option value=""  selected>{{$item }}</option>
                                     @endif
                                      @endforeach
                           

    
                          
                            </select>
                          
                       <span class="text-danger Minimum px-1">(Minimum 10 skills required)* </span>
                       
                        <span class="error" id="keyskillid"></span>
                       
    
                            @if ($errors->has('keyskills')) <span class="help-block" style="color: red">
                                {{ $errors->first('keyskills') }} </span>
                            @endif
    
    
        </div>

</div>

    <div class="row">




                    <?php

                    $profile_education = (isset($profileEducation) ? $profileEducation->degree_title : null);

                    $educationn = \App\Education::find($profile_education);

                    $educations = \App\Education::all();

                    $organization = (isset($profileEducation) ? $profileEducation->course : null);
                        
                    $courses=\App\Course::where('id',$organization)->first();

                    $organization = (isset($profileEducation) ? $profileEducation->organization : null);


                    ?>
                <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'degree_title') !!}">

                    {!! Form::label('education', 'Highest Education', ['class' => 'bold']) !!}    

                    <span class="text-danger px-1">*</span>

                    <select id="education1" name="degree_title" class="form-control dynamic">

                        <option value="" selected disabled>{{(isset($educationn) ? $educationn->education : 'Select Education')}}</option>
                    
                        @if(isset($education))
                        @foreach($education as $edu)
                            <option value="{{$edu->id}}" @if(old('degree_title') == $edu->id)selected @endif>
                                {{$edu->education}}ff
                            </option>
                        @endforeach

                        @else

                            

                            @foreach($educations as $edu)

                            <option value="{{$edu->id}}"  @if(old('degree_title') == $edu->id)selected @endif> {{$edu->education}}</option>


                            @endforeach

                        @endif

                    </select> 

                    {!! APFrmErrHelp::showErrors($errors, 'degree_title') !!}                                       

                </div>
                <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'year_of_completion') !!}">

                    {!! Form::label('year_of_completion', 'Year of completion', ['class' => 'bold']) !!}  
                
                    <span class="text-danger px-1">*</span>
                
                    {!! Form::text('year_of_completion', null, array('class'=>'form-control datepicker-year', 'placeholder'=>'Year of completion')) !!}
                
                    {!! APFrmErrHelp::showErrors($errors, 'year_of_completion') !!}                                       
                
                </div>

            </div>

   
    <div class="row">
                <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'course') !!}">

                    {!! Form::label('course', 'Course', ['class' => 'bold']) !!}    

                    <span class="text-danger px-1">*</span>


                    <select id="course" name="course" class="form-control dynamiccourse">
                        
                                            
                        <option value="{{(isset($newEducation) ? $newEducation->course : 'Select Course')}}"   >{{(isset($courses) ? $courses->course : 'Select Course')}}</option>


                    </select>

                    {!! APFrmErrHelp::showErrors($errors, 'course') !!}                                       

                </div>

                <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'specilation') !!}">

                    {!! Form::label('specialization', 'Specialization', ['class' => 'bold']) !!}    

                    <span class="text-danger px-1">*</span>

                    <select id="specilation" name="specilation" class="form-control dynamicspecs">
                        
                        {{-- <option value="" selected disabled>{{(isset($spec) ? $spec->specs :'Select Specialization')}}</option> --}}

                        <option value="{{(isset($newEducation) ? $newEducation->specilation :'Select Specialization')}}"  >{{(isset($spec) ? $spec->specs :'Select Specialization')}}</option>

                    </select>

                    {!! APFrmErrHelp::showErrors($errors, 'specilation') !!}                                       

                </div>

</div>


    <div class="row">
                <div class="form-group col-md-12 {!! APFrmErrHelp::hasError($errors, 'organization') !!}">

                    {!! Form::label('organization', 'University / College', ['class' => 'bold']) !!}    

                    <span class="text-danger px-1">*</span>

                    @php
                    $datas =  DB::table('degrees')->select('id', 'educations')->distinct()->get();
                    @endphp

                    <select id="university" name="organization"  class="form-control js-example-tags">
                        <option selected disabled>Select University/College</option>
                    @foreach ($datas as $c_data)
                    <option value="{{ $c_data->id }}" @if(old('organization') == $c_data->id)selected @endif
         
                        >{{ $c_data->educations }}</option>
                    @endforeach 
                    </select>

                   
                    
                    {!! APFrmErrHelp::showErrors($errors, 'organization') !!}                                       

                </div>
                <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'education_status') !!}">

                    {!! Form::label('education_status', 'Education Status', ['class' => 'bold']) !!}     
        
                    <span class="text-danger px-1">*</span>
        
             
                    <select id="education_status" name="education_status" class="form-control" >
        
                    <option selected disabled>Select Status</option>

                    <option   value="Completed" @if(old('education_status') == 'Completed')selected @endif>Completed</option>
        
                    <option  value="Pursuing" @if(old('education_status') == 'Pursuing')selected @endif>Pursuing</option>
        
                    <option  value="Discontinued" @if(old('education_status') == 'Discontinued')selected @endif>Discontinued</option>
        
                    </select>
        
                    {!! APFrmErrHelp::showErrors($errors, 'education_status') !!}                                       
        
                </div>

                <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'reason_moved') !!}">

                    {!! Form::label('reason_moved', 'Reason for moving out', ['class' => 'bold']) !!}     
        
                    <span class="text-danger px-1">*</span>
        
             
                    <select id="reason_moved" name="reason_moved" class="form-control" >
        
                        <option selected disabled>Reason for moving out</option>

                        <option   value="Lay Offs" @if(old('reason_moved') == 'Lay Offs')selected @endif>Lay Offs</option>

                        <option  value="Resignation" @if(old('reason_moved') == 'Resignation')selected @endif>Resignation</option>
                        
                         <option  value="Fresher" @if(old('reason_moved') == 'Fresher')selected @endif>NA - Fresher</option>

        
                    </select>
        
                    {!! APFrmErrHelp::showErrors($errors, 'reason_moved') !!}                                       
        
                </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'work_option') !!}">

            {!! Form::label('work_option', 'Preferred Mode', ['class' => 'bold']) !!}    

            <span class="text-danger px-1">*</span>

            <select name="work_option" id="work_option" class="form-control newtest">

                <option value="" selected disabled hidden>Select</option>

                <option   value="1" @if(old('work_option') == '1')selected @endif>Remote</option>
                                    
                <option  value="2" @if(old('work_option') == '2')selected @endif>Hybrid</option>

                <option  value="3" @if(old('work_option') == '3')selected @endif>Work From Office</option>

                <option  value="4" @if(old('work_option') == '4')selected @endif>Flexible</option>
            

            </select>

           
            
            {!! APFrmErrHelp::showErrors($errors, 'work_option') !!}                                       

        </div>

        <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'gender_id') !!}">

            {!! Form::label('gender_id', 'Gender', ['class' => 'bold']) !!} 

            <span class="text-danger px-1">*</span>

            {!! Form::select('gender_id', [''=>'Select Gender']+$genders, null, array('class'=>'form-control admin_gender', 'id'=>'gender_id')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'gender_id') !!}                                       

        </div>
        <div class="form-group col-md-6  {!! APFrmErrHelp::hasError($errors, 'recruiter_comments') !!}" >

            {!! Form::label('recruiter_comments', 'Recruiter Comments', ['class' => 'bold']) !!} 
            <span class="text-danger">*</span>

            {!! Form::textarea('recruiter_comments', null, array('class'=>'form-control ', 'placeholder'=>'Recruiter Comments','rows'=>"3")) !!}

            {!! APFrmErrHelp::showErrors($errors, 'recruiter_comments') !!}
         </div>
         <div class="form-group col-md-6  {!! APFrmErrHelp::hasError($errors, 'recorded_video') !!}" >

            {!! Form::label('recorded_video', 'Recorded Video Interview ', ['class' => 'bold']) !!} 

            {!! Form::file('recorded_video', array('class'=>'form-control')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'recorded_video') !!}
         </div>
    </div>

     
    
    
            <div class="row">

                <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">

                    {!! Form::label('is_active', 'Active', ['class' => 'bold']) !!}
            
                    <div class="radio-list">
            
                        <?php
            
                        $is_active_1 = 'checked="checked"';
            
                        $is_active_2 = '';
            
                        if (old('is_active', ((isset($user->id)) ? $user->is_active : 1)) == 0) {
            
                            $is_active_1 = '';
            
                            $is_active_2 = 'checked="checked"';
            
                        }
            
                        ?>
            
                        <label class="radio-inline">
            
                            <input id="active" name="is_active" type="radio" value="1" {{$is_active_1}}>
            
                            Active </label>
            
                        <label class="radio-inline">
            
                            <input id="not_active" name="is_active" type="radio" value="0" {{$is_active_2}}>
            
                            In-Active </label>
            
                    </div>
            
                    {!! APFrmErrHelp::showErrors($errors, 'is_active') !!}
            
                </div>

                <div class="form-group col-md-6 {!! APFrmErrHelp::hasError($errors, 'verified') !!}">
            
                    {!! Form::label('verified', 'Verified', ['class' => 'bold']) !!}
            
                    <div class="radio-list">
            
                        <?php
            
                        $verified_1 = 'checked="checked"';
            
                        $verified_2 = '';
            
                        if (old('verified', ((isset($user->id)) ? $user->verified : 1)) == 0) {
            
                            $verified_1 = '';
            
                            $verified_2 = 'checked="checked"';
            
                        }
            
                        ?>
            
                        <label class="radio-inline">
            
                            <input id="verified" name="verified" type="radio" value="1" {{$verified_1}}>
            
                            Verified </label>
            
                        <label class="radio-inline">
            
                            <input id="not_verified" name="verified" type="radio" value="0" {{$verified_2}}>
            
                            Not Verified </label>
            
                    </div>
            
                    {!! APFrmErrHelp::showErrors($errors, 'verified') !!}
            
                </div> 
     </div>
  <div class="row">
                <div class="col-lg-3">
                {!! Form::button('Create Account <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!}   
                </div>
</div>
</div>


{!! Form::close() !!}

@push('css')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet"/>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCejQVcKXrBxZGFj0EQpSHkLgOk_Lp6CRI"></script>


<style type="text/css">

    .datepicker>div {

        display: block;

    }

</style>

@endpush

@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

<script>


    $(".admin_industry option:first").attr("disabled", "disabled");
    $(".admin_gender option:first").attr("disabled", "disabled");
    
    $(".admin_marital option:first").attr("disabled","disabled");
   
    $(".admin_physically option:first").attr("disabled","disabled");


    </script>



<script>

    $(".js-example-tags").select2({
                            tags: true
                          });

    $(".js-example-tokenizer").select2({
    tags: true,
    placeholder: "Please enter key skills or technologies",
    
    tokenSeparators: [',']
})


$('#multiple-select-employee_notice').change(function() {
    var value = this.value;
    if (this.value == 1) {
        $('#appendforimmednot').show();
    } else {
        $('#appendforimmednot').hide();
    }
})

$('#multiple-select-employee_notice').change(function() {
    var value = this.value;
    if (this.value == 2) {
        $('#appendforServenot').show();
    } else {
        $('#appendforServenot').hide();
    }
})
$('#multiple-select-employee_notice').change(function() {
    var value = this.value;
    if (this.value == 3) {
        $('#appendforsnp').show();
    } else {
        $('#appendforsnp').hide();
    }
})

    $("document").ready(function(){

        setTimeout(function(){
 
           $("div.alert").remove();

        }, 2000 ); // 5 secs

    

    });
    $('#locationFilter41').select2({
        tags: true, 
        tokenSeparators: [','],
        placeholder: "(Add Location)",
        minimumInputLength: 1, // Set the minimum input length to 2
        maximumSelectionLength: 3,
        ajax: {
            url: "{{ url('autocomplete/search-location-job2') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term // Use the input value as the search query
                };
            },
            processResults: function (data) {
                // Transform the data into the format expected by Select2
                return {
                    results: $.map(data, function (skill) {
                        return {
                            id: skill.location,
                            text: skill.location
                        };
                    })
                };
            },
            cache: true

            
        }
    });

    </script>

<script type="text/javascript">

    $(document).ready(function () {

        initdatepicker();
        

        $('#salary_currency').typeahead({

            source: function (query, process) {

                return $.get("{{ route('typeahead.currency_codes') }}", {query: query}, function (data) {

                    console.log(data);

                    data = $.parseJSON(data);

                    return process(data);

                });

            }

        });



        $('#country_id').on('change', function (e) {

            e.preventDefault();

            filterDefaultStates(0);

        }); 

        $(document).on('change', '#state_id', function (e) {

            e.preventDefault();

            filterDefaultCities(0);

        });

           //multiselect Location
    $('.location-multi-select').multiselect({
        includeSelectAllOption: true,
       selectAllText: 'Any Location',
        enableFiltering: false,
        enableClickableOptGroups: true,
        enableCollapsibleOptGroups: true,
        nonSelectedText: 'Choose by Location',
        numberDisplayed: 2,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Enter Location',
    });

       

    });
    $(".datepicker-year").datepicker({
        autoclose: true,
        format: 'yyyy',
        orientation: 'bottom',
        minViewMode: 'years',
        startView: 'years',
        startDate: '1976',
        endDate: (new Date().getFullYear() + 3).toString()
    });

    $(".datepicker-month").datepicker({
      autoclose: true,
      format: 'dd-M-yyyy',
      todayHighlight: true,
      orientation: 'bottom',
      endDate: new Date()
    });



    $(".datepicker").datepicker({
      autoclose: true,
      format: 'dd-M-yyyy',
      todayHighlight: true,
      orientation: 'bottom',
      startDate: new Date()
    });

    

    $("#industry").change(function(){

 

    if(this.value==2)

    {

     

   $("#hideit").show();

    }else{

    $("#hideit").hide();

    }

    });

    

//     $("#industry").change(function(){

//  if(this.value==2){ $('#yesnohide').show();} else{ $('#yesnohide').hide(); }



// });


$('#ignore_companies').select2({
    tags: true, 
    tokenSeparators: [','],
    maximumSelectionLength: 5,
    placeholder: "(Optional)",
    minimumInputLength: 1, // Set the minimum input length to 2
    ajax: {
        url: "{{ url('search-companies') }}", // Replace this with the URL to your search endpoint
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term // Use the input value as the search query
            };
        },
        processResults: function (data) {
            // Transform the data into the format expected by Select2
            return {
                results: $.map(data, function (company) {
                    return {
                        id: company.id,
                        text: company.name
                    };
                })
            };
        },
        cache: true
    }
});


$('#my-select').on('change', function() {
      var count = $('#my-select').select2('data').length;
      $('#selected-count').text(' (' + count + ' skills updated)');
        if (count < 10) {
        $('#my-select-container .select2-selection--multiple').css('border', '1px solid red');
            $('#skill-error').text('Please update 10 skills.');
            $('.Minimum').show();
            return false; // prevent form submission
            }
                        

         if (count >= 10) {
          $('#my-select-container .select2-selection--multiple').css('border', '1px solid #c1c1c1');
        $('#skill-error').text('');
        $('.Minimum').hide();
        }
                          
    });

$(".datepickerr").datepicker({

autoclose: true,
startDate: '01/01/1950  ',

        format: 'dd-mm-yyyy'

});  
$(".datepickerr-month").datepicker({

autoclose: true,
startDate: '01/1950',

        format: 'mm-yyyy'

}); 




var searchInput = 'search_input';



$(document).ready(function () {

var autocomplete;

autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

types: ['geocode'],

componentRestrictions: {

country: "IN"

}

});



google.maps.event.addListener(autocomplete, 'place_changed', function () {

var near_place = autocomplete.getPlace();

});

});

</script>
    <script>
        var searchInput = 'autocomplete2';


var autocomplete;

autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

types: ['geocode'],

componentRestrictions: {

country: "IN"

}

});



google.maps.event.addListener(autocomplete, 'place_changed', function () {

var near_place = autocomplete.getPlace();
var location =  $("#autocomplete2").val();
        location = location.split(',')[0];
        $('#autocomplete2').val(location);

});


var searchInput = 'autocomplete7';


var autocomplete;

autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

types: ['geocode'],

componentRestrictions: {

country: "IN"

}

});



google.maps.event.addListener(autocomplete, 'place_changed', function () {

var near_place = autocomplete.getPlace();
var location =  $("#autocomplete7").val();
        location = location.split(',')[0];
        $('#autocomplete7').val(location);

});

var searchInput = 'autocomplete9';


var autocomplete;

autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

types: ['geocode'],

componentRestrictions: {

country: "IN"

}

});



google.maps.event.addListener(autocomplete, 'place_changed', function () {

var near_place = autocomplete.getPlace();
var location =  $("#autocomplete9").val();
        location = location.split(',')[0];
        $('#autocomplete9').val(location);

});

 var searchInput = 'autocomplete6';

$(document).ready(function () {

var autocomplete;

autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

types: ['geocode'],

componentRestrictions: {

country: "IN"

}

});



google.maps.event.addListener(autocomplete, 'place_changed', function () {

var near_place = autocomplete.getPlace();
var location =  $("#autocomplete6").val();
        location = location.split(',')[0];
        $('#autocomplete6').val(location);

});

});



</script>

<script>


    // Prepare location info object.
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

$("#autocomplete5").on('focus', function () {
   
    geolocate();
});

var placeSearch, autocomplete5;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};

function initialize() {
    // Create the autocomplete object, restricting the search
    // to geographical location types.
    autocomplete = new google.maps.places.Autocomplete(
    /** @type {HTMLInputElement} */ (document.getElementById('autocomplete5')), {
        types: ['geocode'],
        componentRestrictions: {

country: "IN"

}
        
    });
    // When the user selects an address from the dropdown,
    // populate the address fields in the form.
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        fillInAddress();
        var location =  $("#autocomplete5").val();
        location = location.split(',')[0];
        $('#autocomplete5').val(location);
    });
}

// [START region_fillform]
function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    document.getElementById("latitude").value = place.geometry.location.lat();
    document.getElementById("longitude").value = place.geometry.location.lng();

    for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
        }
    }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = new google.maps.LatLng(
            position.coords.latitude, position.coords.longitude);

            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;

            autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));
        });
    }

}

initialize();
// [END region_geolocation]

</script>
<script>
    

$.ajaxSetup({

headers: {

    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

}

});


var ter = "{{ old('degree_title') }}";

if(ter)
{

    var degree_id = ter;
                
    $.ajax({

                type:"POST",

                url:"{{url('gety')}}",

                _token: '{{ csrf_token() }}',

                data: {

                degree:degree_id,

                },

                dataType: "json",



                success:function(res){        

                if(res){

                $(".dynamiccourse").empty();

                $(".dynamiccourse").append('<option>Select Course</option>');

                $.each(res,function(key,value){
                    
                    var option = $('<option></option>').attr('value', value.id).text(value.course);
                    var oldCourse = "{{ old('course') }}"; // Retrieve the previous value of the "course" input field from the server-side
                    
                    //alert(oldCourse);
                    
                    
                    if (value.id == oldCourse) { // Compare each option value with the old selected value
                        option.attr('selected', true); // Add the "selected" attribute to the corresponding option
                    }
                    
                    $(".dynamiccourse").append(option);

                });


                }else{

                $(".dynamiccourse").empty();

                }

                }

                });
  
}else{
  
}

var course = "{{ old('course') }}";

  if(course)
  {

    

    var course_id = course;

                $.ajax({

            type:"POST",

            url:"{{url('getspecs')}}",

            _token: '{{ csrf_token() }}',

            data: {

            course:course_id,

            },

            dataType:"json",

            success:function(res){        

            if(res){

            $(".dynamicspecs").empty();

            $(".dynamicspecs").append('<option>Select Specialization</option>');

            $.each(res,function(key,value){

                var option = $('<option></option>').attr('value', value.id).text(value.specs);
            var oldSpecs = "{{ old('specilation') }}";

         //   alert(oldSpecs);
            if (value.id == oldSpecs) {
                option.attr('selected', true);
            }
            $(".dynamicspecs").append(option);

            

            });



            }else{

            $(".dynamicspecs").empty();

            }

            }

            });
  }



$('.dynamic').change(function(){

// alert('heloo');

var degree_id = $(this).val(); 


// var oldCourse = "{{ old('course') }}";

//alert(oldCourse);


if(degree_id){
    if(degree_id == 5)
    {
       
        $('.dynamiccourse').empty().append('<option value="N/A" selected disabled>No Input Needed</option>');
        $('.dynamicspecs').empty().append('<option value="N/A" selected disabled>No Input Needed</option>');
        $('#university').empty().append('<option value="N/A" selected disabled>No Input Needed</option>');
        // Disable the search functionality
            $('#university').select2({
            minimumResultsForSearch: Infinity
            })


    }else{


$.ajax({

type:"POST",

url:"{{url('gety')}}",

_token: '{{ csrf_token() }}',

data: {

   degree:degree_id,

},

dataType: "json",



success:function(res){        

if(res){

  $(".dynamiccourse").empty();

  $(".dynamiccourse").append('<option>Select Course</option>');

  $.each(res,function(key,value){
      
    var option = $('<option></option>').attr('value', value.id).text(value.course);
    var oldCourse = "{{ old('course') }}"; // Retrieve the previous value of the "course" input field from the server-side
    
    //alert(oldCourse);
    
    
    if (value.id == oldCourse) { // Compare each option value with the old selected value
        option.attr('selected', true); // Add the "selected" attribute to the corresponding option
    }
    
    $(".dynamiccourse").append(option);

  });


}else{

  $(".dynamiccourse").empty();

}

}

});






$('#university').empty().append('<option value="" selected disabled>Select University/College</option>');


$('#university').select2({
    tags: true, 
   
    minimumInputLength: 2, // Set the minimum input length to 2
    ajax: {
        url: "{{ url('search-university') }}", // Replace this with the URL to your search endpoint
        dataType: 'json',
        delay: 100,
        data: function (params) {
            var query = {
                q: params.term // Use the input value as the search query
            };
            if (params.term) {
                query['old_value'] = '{{ old("organization") }}'; // Add the old value to the query
            }
            return query;
        },
        processResults: function (data) {
            // Transform the data into the format expected by Select2
            return {
                results: $.map(data, function (university) {
                    return {
                        id: university.id,
                        text: university.educations
                    };
                })
            };
        },
        cache: true
    }
});

    }


}else{

//alert('error');

$(".dynamiccourse").empty();

$(".dynamicspecs").empty();

}   

});




$('.dynamiccourse').on('change',function(){



var course_id = $(this).val();  



if(course_id){

$.ajax({

 type:"POST",

 url:"{{url('getspecs')}}",

 _token: '{{ csrf_token() }}',

 data: {

    course:course_id,

 },

 dataType:"json",

 success:function(res){        

 if(res){

   $(".dynamicspecs").empty();

   $(".dynamicspecs").append('<option>Select Specialization</option>');

   $.each(res,function(key,value){

       var option = $('<option></option>').attr('value', value.id).text(value.specs);
    var oldSpecs = "{{ old('specs') }}";
    if (value.id == oldSpecs) {
        option.attr('selected', true);
    }
    $(".dynamicspecs").append(option);

   });

 

 }else{

   $(".dynamicspecs").empty();

 }

 }

});

}else{

$(".dynamicspecs").empty();

}



});
</script>



@endpush