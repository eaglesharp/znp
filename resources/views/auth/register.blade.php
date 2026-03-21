@extends('layouts.app')



@section('content')



<!-- Header start -->



@include('includes.header')



<!-- Header end -->

<style>
.latestcompany .select2-container--default .select2-selection--single {
    height: initial;
}
.latestcompany .select2-selection__rendered{
    font-size: 15px;
    color: grey!important;
    padding-top: 0.4rem !important;
    padding-bottom: 0.4rem !important;
}
.latestcompany .select2-container--default .select2-selection--single .select2-selection__rendered {
  
    line-height: 28px;
}

.select2-container--default .select2-search--inline .select2-search__field {
     background: white!important; 
 
}
.select2-container--default .select2-selection--multiple {
 
    background-image: none !important;
  
}

#education1,#course1,#specs1,#organization{
    color: #000 !important;
}
.sub-title{
    font-size:15px;
}
.ignore-i i {
    background: #949494;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    color: #fff;
    font-size: 15px;
    line-height: 1.3;
    cursor: pointer;
    text-align: center;
}


.select-box label{
    position: absolute!important;
    bottom: -30px!important;
    left: 0!important;
    z-index: 999!important;
}

#terms_of_use-error{
        left: 15px!important;
}

.toggle-icon{
    position: absolute;
    margin-top: 10px;
    margin-left: -28px;
    cursor: pointer;
}

.university .select2-selection--single{
    height: 37px!important;
}
.university .select2-selection__rendered{
    line-height: 35px!important;
}
.select2-selection__choice {
  display: flex;
  justify-content: space-between;
  padding-right: 20px; /* Adjust spacing to give room for the cross */
}

.select2-selection__choice__remove {
  order: 2; /* Place the cross at the end */
  margin-left: 5px; /* Add spacing between text and cross */
}

.select2-container--default .select2-selection--multiple .select2-selection__choice{
    background-color:unset !important;
}
.error,.text-danger,.help-block{
    color:#800000 !important;
}

</style>



<!-- Inner Page Title start -->

@include('flash::message')



<section class="section_signup">

    <div class="container">

        <div class="col-md-12 col-lg-8 m-auto py-5">

            <div class="box py-4 rounded">

                <h5 class="sign_head text-center pt-3">Sign Up As <span class=" sign_color">Jobseeker</span></h5>
                <p class="sign_head text-center sub-title pt-2 text-primary">Please on board with us if your notice period is Zero or if you are serving notice period</p>

                <form class="px-3 px-md-5 py-3" method="POST" action="{{ route('register') }}" id="registerForm"
                    enctype="multipart/form-data">


                    {{ csrf_field() }}

                    <div class="row">

                        <div class="col-12 col-md-6 {{ $errors->has('first_name') ? ' has-error' : '' }}">

                            <label class="sign_fontsize">First name<span class="text-danger px-1">* </span></label>

                            <input type="text" name="first_name" class="w-100 px-3 py-2 rounded signup_input"
                                placeholder="Enter your First Name" maxlength="100" value="{{ old('first_name') }}">

                            @if ($errors->has('first_name')) <span class="help-block" style="color: red">
                                {{ $errors->first('first_name') }} </span> @endif

                        </div>

                        <div class="col-12 col-md-6 {{ $errors->has('last_name') ? ' has-error' : '' }}">

                            <label class="sign_fontsize">Last name</label>

                            <input type="text" name="last_name" class="w-100 px-3 py-2 rounded signup_input"
                                placeholder="Enter your Last Name" maxlength="100" value="{{ old('last_name') }}">

                            @if ($errors->has('last_name')) <span class="help-block" style="color: red">
                                {{ $errors->first('last_name') }} </span> @endif

                        </div>
                         <div class="col-12 col-md-6 notice-period">

                           <label class="mb-2 sign_fontsize pt-3">Notice Period Status<span class="text-danger px-1">*</span><i class="fa fa-info-circle"
                                            data-toggle="tooltip" title="ZeroNoticePeriod caters to Job seekers with either Zero Notice Period or those Serving Notice Period. Please register if you are in either of the categories."></i></label>


                             <select name="nop_days"
                            class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded newtest"
                            id="multiple-select-employee_notice">

                            <option selected disabled>Select Option</option>

                            <option value="1"   @if(old('nop_days') == '1')selected @endif>Immediately Available
                            </option>

                            <option value="2"  @if(old('nop_days') == '2')selected @endif>Serving Notice Period
                            </option>

                           </select>
                             @if($errors->has('nop_days'))<span class="help-block "
                                    style="color: red">{{$errors->first('nop_days')}}</span>
                                   @endif

                        </div>
                        <div class="col-12 col-md-6 notice-period d-md-block d-none">

                            <label class="mb-2 sign_fontsize pt-3">Preferred Work Type<span class="text-danger px-1">*</span></label>
 
 
                            <select class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded newtest" name="work_type" value=""
                            style="height:45px !important" ;>
    
                         
                                <option selected disabled>Select Work Type</option>

                                <option   value="Contract" @if(old('work_type') == 'Contract')selected @endif>Contract</option>
                
                                <option  value="Permanent" @if(old('work_type') == 'Permanent')selected @endif>Permanent</option>
                
                                {{-- <option  value="Freelance" @if(old('work_type') == 'Freelance')selected @endif>Freelance</option> --}}
                
                                <option  value="Flexible" @if(old('work_type') == 'Flexible')selected @endif>Flexible</option>

    
                        </select>
    
                        @if($errors->has('work_type'))<span class="help-block "
                         style="color: red">{{$errors->first('work_type')}}</span>
                        @endif
 
                         </div>
                     <div class="col-12 col-md-12 ">
                              <div id="appendforServenot" @if(old('nop_days') == '2') style="display:block" @else style="display:none"  @endif   >

                          <div class="row" id="test_yes1">

                            <div class="col-lg-12">

                                <label class="mb-2 pt-3 sign_fontsize">Last working date incase notice period is being served<span class="text-danger px-1">*</span></label>

                                <input type="text" name="last_working_day"
                                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize datepicker-noticeperiod  newtest  "
                                    value="{{ old('last_working_day') }}" id="appendforsnpinputserveout">
                                    
                                    @if($errors->has('last_working_day'))<span class="help-block "
                                    style="color: red">{{$errors->first('last_working_day')}}</span>
                                   @endif

                                    
                               
                            </div>
                        </div>
                    </div>

             </div>
              <div class="col-12 col-md-12 ">
                                <div id="appendforimmednot" @if(old('nop_days') == '1') style="display:block" @else style="display:none"  @endif >
                        <div class="row" id="test_yes1">

                            <div class="col-lg-12">

                                <label class="mb-2 pt-3 sign_fontsize">Mention your Last Working Date with your last employer OR your Month of graduation in case you are a fresher<span class="text-danger px-1">*</span></label>

                                <input type="text" name="immediate_last_date"
                                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize datepicker-month  newtest  "
                                    value="{{ old('immediate_last_date') }}" id="appendforsnpinputserveout">
                                   @if($errors->has('immediate_last_date'))<span class="help-block "
                                        style="color: red">{{$errors->first('immediate_last_date')}}</span>
                                    @endif
                                    {{-- <p class="mt-2"  style=" color: grey;"><input type="checkbox" name="confirm_nop" value="1"  @if(old('confirm_nop') == '1')checked @endif /> I confirm I am not employed and I agree that my profile will be
                                        deactivated if the facts are found untrue<span class="text-danger px-1">*</span></p> --}}
                                    
                                     {{-- @if($errors->has('confirm_nop'))<span class="help-block "
                                        style="color: red">{{$errors->first('confirm_nop')}}</span>
                                    @endif --}}
                                <span class="help-block immediate_last_date-error" style="color:#a94442"></span>
                            </div>
                        </div>
                    </div>


             </div>
             
              <div class="col-12 col-md-6 notice-period d-block d-md-none">

                            <label class="mb-2 sign_fontsize pt-3">Preferred Work Type<span class="text-danger px-1">*</span></label>
 
 
                            <select class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded newtest" name="work_type" value=""
                            style="height:45px !important" ;>
    
                         
                                <option selected disabled>Select Work Type</option>

                                <option   value="Contract" @if(old('work_type') == 'Contract')selected @endif>Contract</option>
                
                                <option  value="Permanent" @if(old('work_type') == 'Permanent')selected @endif>Permanent</option>
                
                                <option  value="Freelance" @if(old('work_type') == 'Freelance')selected @endif>Freelance</option>
                
                                <option  value="Any" @if(old('work_type') == 'Any')selected @endif>Any</option>

    
                        </select>
    
                        @if($errors->has('work_type'))<span class="help-block "
                         style="color: red">{{$errors->first('work_type')}}</span>
                        @endif
 
                         </div>

                      

                        <div class="col-12 col-md-6 {{ $errors->has('email') ? ' has-error' : '' }}">

                            <p class="mb-2 pt-3 sign_fontsize">Email ID<span class="text-danger px-1">* </span></p>

                            <input type="email" name="email" class="w-100 py-2 px-3 rounded signup_input"
                                placeholder="Enter your Email" maxlength="100" value="{{ old('email') }}" onchange="checkEmail()" id="email">

                                <span id="error-message" style="color: red"></span>

                            @if ($errors->has('email')) <span class="help-block" style="color: red">
                                {{ $errors->first('email') }} </span> @endif

                        </div>

                        <div class="col-12 col-md-6 {{$errors->has('phone')? 'has-error' : '' }}">

                            <p class="mb-2 pt-3 sign_fontsize">Phone number<span class="text-danger px-1">* </span></p>

                            <input type="tel" name="phone" class="w-100 py-2 px-3 rounded signup_input js-input-mobile"
                                placeholder="Enter your Phone number" minlength="7" maxlength="10"
                                value="{{ old('phone') }}">

                            @if ($errors->has('phone')) <span class="help-block" style="color: red">
                                {{ $errors->first('phone') }} </span> @endif

                        </div>


                        <div class="col-lg-12">
                            <label class="mb-2 pt-3 sign_fontsize">Current Total CTC per annum (Fixed + Variable + Bonus
                                + Incentives + Benefits)<span class="text-danger px-1">*</span></label>
                        </div>
                        <div class="col-lg-6 pb-3 pb-lg-0 position_lit">
                            <input type="number" onkeyup=imposeMinMax(this) min="1" max="100" placeholder="Lakh"
                                class="w-100 pl-3 pr-4 py-2  sign_fontsize  signup_input rounded btnsub1 edit1"
                                name="expect_ctc_lakhs" value="{{ old('expect_ctc_lakhs') }}">
                                @if($errors->has('expect_ctc_lakhs'))<span class="help-block "
                                style="color: red">{{$errors->first('expect_ctc_lakhs')}}</span>
                               @endif
                          
                            </span>
                        </div>
                        <div class="col-lg-6  pb-lg-0 position_lit">
                            <input type="number" onkeyup=imposeMinMax(this) min="0" max="99" placeholder="Thousand"
                                class="w-100 pl-3 pr-4 py-2 sign_fontsize  signup_input rounded btnsub1 edit1"
                                name="expect_ctc_thousand" value="{{ old('expect_ctc_thousand') }}">
                                @if($errors->has('expect_ctc_thousand'))<span class="help-block "
                                style="color: red">{{$errors->first('expect_ctc_thousand')}}</span>
                               @endif

                        </div>



                        <div class="col-lg-12">
                            <label class="mb-2 pt-3 sign_fontsize pt-3">Expected CTC per annum<span
                                    class="text-danger px-1">*</span></label>
                        </div>
                        <div class="col-lg-6 pb-3 pb-lg-0">
                            <input type="number" onkeyup=imposeMinMax(this) min="1" max="100" placeholder="Lakh"
                                class="w-100 pl-3 pr-4 py-2  sign_fontsize  signup_input rounded btnsub1 edit1"
                                name="expect_ctc_lakhs3" value="{{ old('expect_ctc_lakhs3') }}">
                                @if($errors->has('expect_ctc_lakhs3'))<span class="help-block "
                                style="color: red">{{$errors->first('expect_ctc_lakhs3')}}</span>
                               @endif
                           
                        </div>
                        <div class="col-lg-6  pb-lg-0">
                            <input type="number" onkeyup=imposeMinMax(this) min="0" max="99" placeholder="Thousand"
                                class="w-100 pl-3 pr-4 py-2 sign_fontsize  signup_input rounded btnsub1 edit1"
                                name="expect_ctc_thousand3" value="{{ old('expect_ctc_thousand3') }}">
                                @if($errors->has('expect_ctc_thousand3'))<span class="help-block "
                                style="color: red">{{$errors->first('expect_ctc_thousand3')}}</span>
                               @endif
                           
                        </div>

                    </div>




                   
<div class="row mt-3">
    <div class="col-12 col-md-6 latestcompany">

        <label class="sign_fontsize">Latest Company<span class="text-danger px-1">* </span></label>

        @php
        $datas = DB::table('company_data')->select('id','name')->distinct()->get();
       @endphp

        <select name="latestcom" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded js-example-tags">
            <option selected disabled>Latest Company</option>
           @foreach ($datas as $c_data)
           <option value="{{ $c_data->id }}" @if(old('latestcom') == $c_data->id)selected @endif
         
           >{{ $c_data->name }}</option>
           @endforeach                       
        
          </select>
          
          <span class="error" id="latestcomid"></span>

        @if ($errors->has('latestcom')) <span class="help-block" style="color: red">
            {{ $errors->first('latestcom') }} </span> @endif

    </div>

    <div class="col-12 col-md-6">

        <label class="sign_fontsize">Latest Designation</label>

        <input type="text" class="w-100 signup_input rounded px-3 py-2" name="latestdesg" value="{{ old('latestdesg') }}"
        placeholder="Latest Designation">

        @if ($errors->has('latestdesg')) <span class="help-block" style="color: red">
            {{ $errors->first('latestdesg') }} </span> @endif

    </div>
</div>

    <div class="row mt-3">
        <div class="col-12 col-md-12">

            <label class="sign_fontsize ignore-i">Jobsearch Privacy: Hide your CV from view by the Employers (Current/Past) <i class="fa fa-info-circle"
                data-toggle="tooltip" title="This is a privacy option. This wiill help you not be found by the employers (Current/Past) you choose to hide your CV from"></i></label>
                            
                        <div class="w-100"  >
                            <select class="form-control" id="ignore_companies" name="ignore_companies[]" multiple="multiple" >
                                                                                                                               
                            </select>
                        
                        </div> 
        </div>      
    </div>
                    

    <div class="col-12 col-md-12 px-0 mt-3 ">
        <label class="sign_fontsize">Total Experience<span class="text-danger px-1">* </span></label>
    </div>


    <div class="row">
                <div class="col-12 col-md-6">
                        
                    {!! Form::select('totalexp',[''=>'Select Year']+MiscHelper::gettotalexp(),old('totalexp'),array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded','id'=>'totalexp')  )  !!}  
            
                    @if ($errors->has('totalexp')) <span class="help-block" style="color: red">
                        {{ $errors->first('totalexp') }} </span> @endif
            
                
                </div>
 
                <div class="col-12 col-md-6 mt-3 mt-md-0">
                 
                    {!! Form::select('totalexpmonth',[''=>'Select Month']+MiscHelper::getprofilemonths(),old('totalexpmonth'),array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded','id'=>'totalexpmonth')  )  !!}  
            
                    @if ($errors->has('totalexpmonth')) <span class="help-block" style="color: red">
                        {{ $errors->first('totalexpmonth') }} </span> @endif
            
                </div>
 


    </div>
    
<div class="row">
  
<div class="col-12 col-md-6 mt-3  ">

    <label class="sign_fontsize" for="exampleFormControlFile1">Attach Resume<span
            class="text-danger px-1">* </span></label>

    <input type="file" name="resume" class="form-control-file w-100" id="exampleFormControlFile1"
        value="{{ old('resume') }}" accept=".docx,.pdf">

    <p style="width: 287px;
           font-size: 14px;
           color: grey;margin-top: 5px;    margin-bottom: 0px;
       ">(Upload resume will accept only .pdf and .docx, Size should be lesser than 2 MB.)</p>
    @if($errors->has('resume'))<span class="help-block "
        style="color: red">{{$errors->first('resume')}}</span>
    @endif

</div>

<div class="col-12 col-md-6 mt-3 ">

    <label class="sign_fontsize" for="exampleFormControlFile1">Current City<span
            class="text-danger px-1">* </span></label>

    <input type="text" name="current_city" class="w-100 pl-3 pr-4 py-2 sign_fontsize  signup_input rounded " id="autocomplete_reg"
        value="{{ old('current_city') }}">

    
    @if($errors->has('current_city'))<span class="help-block "
        style="color: red">{{$errors->first('current_city')}}</span>
    @endif
    {{--
</div>  
 <div class="col-12 col-md-6 mt-3 "> --}}

    <label class="sign_fontsize" for="exampleFormControlFile1">Preferred Cities </label>
        <select class="form-control select-box" name="prefered_city[]" multiple="multiple" placeholder="Please enter location" id="locationFilter41">                    
        </select>
    
    @if($errors->has('prefered_city'))<span class="help-block "
        style="color: red">{{$errors->first('prefered_city')}}</span>
    @endif
</div> 
</div>
   




<div class="row mt-3">
    <div class="col-12 col-md-12">

        <label class="sign_fontsize">Key Skills<span class="text-danger px-1">* </span></label>
        <span id="selected-count" style="color:green"></span>
        <span id="skill-error" style="color: red;"></span>
                    <div class="w-100" id="my-select-container">

                      
                           <select class="form-control js-example-tokenizer select-box" name="keyskills[]" multiple="multiple" placeholder="Please enter key skills or technologies" id="my-select">
                                              
                                      
                    
                                                    <?php                           
                    
                                                  
                                                    $job_skills=\App\JobSkill::all()->unique('job_skill')->take(2000);
                                                    
                                                    
                                                    ?>
                    
                    
                                                    @foreach($job_skills as $skill)
                                                     <option value="{{ $skill->id }}" {{ in_array($skill->id, old('keyskills', [])) ? 'selected' : '' }}>{{ $skill->job_skill}}</option>
                                                    @endforeach
                    
                                                   
                    
                                          
                                            </select>
                    
                    </div>

                    <span class="text-danger Minimum">(Minimum 10 skills required) </span>
             
                    <span class="error" id="keyskillid"></span>
                    
                        
                        @if ($errors->has('keyskills')) <span class="help-block" style="color: red">
                            {{ $errors->first('keyskills') }} </span> @endif


    </div>

   
</div>
<div class="row mt-3">
    <div class="col-12 col-md-6 password-toggle">

        <label class="sign_fontsize">Set Your Password<span class="text-danger px-1">* </span></label>
               
        <input type="password" name="password" class="w-100 py-2 px-3 rounded signup_input"
                        placeholder="Enter your password" maxlength="100">
                        <span class="toggle-icon"><i class="fa fa-eye"></i></span>

                    @if ($errors->has('password')) <span class="help-block" style="color: red">
                        {{ $errors->first('password') }} </span> @endif

    </div>

    <div class="col-12 col-md-6 password-toggle">

        <label class="sign_fontsize">Confirm Your Password<span class="text-danger px-1">* </span></label>
               
        <input type="password" name="password_confirmation" class="w-100 py-2 px-3 rounded signup_input"
        placeholder="Confirm your password" maxlength="100">
        <span class="toggle-icon"><i class="fa fa-eye"></i></span>

    @if ($errors->has('password_confirmation')) <span class="help-block" style="color: red">
        {{ $errors->first('password_confirmation') }} </span> @endif

    </div>
</div>
<?php

$profile_education = (isset($profileEducation) ? $profileEducation->degree_title : null);



    

   $educationn = \App\Education::find($profile_education);

   $educations = \App\Education::all();

   $organization = (isset($profileEducation) ? $profileEducation->course : null);                  

   $course=\App\Course::where('id',$organization)->first();

   $degrees =\App\Degree::all();

   $organization = (isset($profileEducation) ? $profileEducation->organization : null);

   

   ?>               
<div class="row mt-3">
    <div class="col-12 col-md-6">

        <label class="sign_fontsize">Highest Education<span class="text-danger px-1">* </span></label>

        <select id="education1" name="degree_title" class="w-100 py-2 px-3 rounded signup_input rounded dynamic">

            <option value="" selected disabled>{{(isset($educationn) ? $educationn->education : 'Select Education')}}</option>

             @foreach($educations as $edu)

             <option value="{{$edu->id}}" @if(old('degree_title') == $edu->id)selected @endif> {{$edu->education}}</option>

             @endforeach

      

        </select>                 
      

                    @if ($errors->has('degree_title')) <span class="help-block" style="color: red">
                        {{ $errors->first('degree_title') }} </span> @endif

    </div>
    

        <div class="col-12 col-md-6">

        <label class="sign_fontsize">Year of completion<span class="text-danger px-1">* </span></label>
        
        <input type="text" value="{{ old('year_of_completion') }}" name="year_of_completion" class="w-100 py-2 px-3 rounded signup_input datepicker-year"
        placeholder="Year of completion" maxlength="4">
        @if ($errors->has('year_of_completion')) <span class="help-block" style="color: red">
           {{ $errors->first('year_of_completion') }} </span>
        @endif

    </div>

</div>

 <div class="row mt-3">

    <div class="col-12 col-md-6">

        <label class="sign_fontsize">Course<span class="text-danger px-1">* </span></label>
               
       
        <select id="course1" name="course" class="w-100 py-2 px-3 rounded signup_input course dynamiccourse" >

            <option value="" selected disabled>{{(isset($course) ? $course->course : 'Select Course')}}</option>

        </select>  
       

        @if ($errors->has('course')) <span class="help-block" style="color: red">
           {{ $errors->first('course') }} </span>
        @endif

    </div>

    <div class="col-12 col-md-6">

        <label class="sign_fontsize">Specialization<span class="text-danger px-1">* </span></label>


        <select id="specs1" name="specilation" class="w-100 py-2 px-3 rounded signup_input rounded dynamicspecs">

            <option value="" selected disabled>{{(isset($spec) ? $spec->specs :'Select Specialization')}}</option>



        </select>


        @if ($errors->has('specilation')) <span class="help-block" style="color: red">
                        {{ $errors->first('specilation') }} </span> @endif

    </div>
</div>
<div class="row mt-3">
    <div class="col-12 col-md-12 university">

        <label class="sign_fontsize">University / College<span class="text-danger px-1">* </span></label>
            
            <select id="university" name="organization" class="w-100 py-2 px-3 rounded signup_input rounded ">

                <option value="" selected disabled>Select University/College</option>

            </select>

            @if ($errors->has('organization')) <span class="help-block" style="color: red">
                {{ $errors->first('organization') }} </span>
            @endif

    </div>
</div>
    <div class="row mt-3">
        <div class="col-12 col-md-6">
        <label class="sign_fontsize">Education Status<span class="text-danger px-1">* </span></label>
        <select id="education_status" name="education_status" class="w-100 py-2 px-3 rounded signup_input" >
            <option selected disabled>Select Status</option>
            <option   value="Completed" @if(old('education_status') == 'Completed')selected @endif>Completed</option>
            <option  value="Pursuing" @if(old('education_status') == 'Pursuing')selected @endif>Pursuing</option>
            <option  value="Discontinued" @if(old('education_status') == 'Discontinued')selected @endif>Discontinued</option>
        </select>  
        @if ($errors->has('education_status')) <span class="help-block" style="color: red">
           {{ $errors->first('education_status') }} </span>
        @endif
    </div>







    <div class="col-12 col-md-6">

        <label class="sign_fontsize">Reason for moving out</label>


        <select id="reason_moved" name="reason_moved" class="w-100 py-2 px-3 rounded signup_input" >

            <option selected disabled>Select Status</option>

            <option   value="Lay Offs" @if(old('reason_moved') == 'Lay Offs')selected @endif>Lay Offs</option>

            <option  value="Resignation" @if(old('reason_moved') == 'Resignation')selected @endif>Resignation</option>
             
            <option  value="Fresher" @if(old('reason_moved') == 'Fresher')selected @endif>NA - Fresher</option>


        </select>


        @if ($errors->has('reason_moved')) <span class="help-block" style="color: red">
           {{ $errors->first('reason_moved') }} </span>
        @endif

    </div>


</div>



                    <div class="row mt-3">
                        <div class="col-12 col-md-6">

                            <label class="sign_fontsize ignore-i">Pref. Work Mode</label><span class="text-danger px-1">* </span>
                                            
                                        <div class="w-100"  >
                                            <select class="form-control"  name="work_option">
                                                <option selected disabled>Select Mode</option>

                                                <option   value="1" @if(old('work_option') == '1')selected @endif>Remote</option>
                                    
                                                <option  value="2" @if(old('work_option') == '2')selected @endif>Hybrid</option>

                                                <option  value="3" @if(old('work_option') == '3')selected @endif>Work From Office</option>

                                                <option  value="4" @if(old('work_option') == '4')selected @endif>Flexible</option>
                                    
                                                                                                                           
                                            </select>
                                        
                                        </div> 
                        </div>  

                        @php
                            $genders = \App\Helpers\DataArrayHelper::langGendersArray();
                        @endphp
                        <div class="col-12 col-md-6">

                            <label class="sign_fontsize ignore-i">Gender</label><span class="text-danger px-1">* </span>
                                            
                                        <div class="w-100"  >
                                            {!! Form::select('gender_id', [''=>__('Select Gender')]+$genders, null,
                                            array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize nonselect2
                                            signup_input rounded edit', 'id'=>'gender_id')) !!}
                                        
                                        </div> 

                                        @if ($errors->has('gender_id')) <span class="help-block" style="color: red">
                                            {{ $errors->first('gender_id') }} </span>
                                     @endif
                        </div>      
                    </div>
        




                    <div class="row py-4 ">

                        <div
                            class="col-12 d-flex align-items-sm-center {{ $errors->has('terms_of_use') ? ' has-error' : '' }}">



                            <input type="checkbox" value="1" name="terms_of_use" id="agree" class="checkbox_size"
                                maxlength="100"><label for="agree" class="align-text-bottom mb-0 sign_fontsize">I have read
                                and agreed to the <a href="{{ url('candidate-terms-and-conditons') }}">Terms & Conditions<span
                                    class="text-danger px-1">*</span></a></label>

                        </div>
                        
                         <span class="error" id="termsid"></span>

                        @if ($errors->has('terms_of_use')) <span class="help-block"
                            style="color:red;margin-left: 22px;"> {{ $errors->first('terms_of_use') }} </span> @endif

                    </div>

                    <div class="row">

                        <div class="col-12 text-center">

                            <button type="submit" class="py-2 w-100 rounded signup_button">Create your account</button>

                        </div>

                    </div>

                    <div class="col-12">

                        <div class="text-center pt-4 sign_fontsize">Already have an account ? <a
                                href="{{route('login')}}">Sign in</a></div>

                    </div>
                    <div class="col-12">

                        <div class="text-center pt-4 sign_fontsize">Sign up as an Employer <a
                                href="{{route('company.register.page')}}">Sign up</a></div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>

<!-- <button type="submit" class="btn btn_submit w-100 text-light" data-toggle="modal"
        data-target="#userSignUpInitialPopup">Submit</button> -->
<!--jobseeker Sign-Up Initial modal -->
<div class="container">
    <div class="modal" id="userSignUpInitialPopup">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal_content_custom_width mx-auto p-3">
                <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"
                        src="{{ asset('/') }}asset/images/cancel.png"></p>
                <div class="modal-body p-0">
                    <div class="collection_pic-box text-center mt-4 mt-md-0">
                        <div class="collection_text px-3 py-0">
                            <span class="line_change font_size">Hello Jobseeker!</span>
                            <h4 class="modal-title sign_head">"ZeroNoticePeriod caters to Job seekers with either Zero
                                Notice Period or those Serving Notice Period. Please register if you are in either of
                                the categories".</h4>
                            <div class="error_message1 " id=""></div>
                        </div>
                    </div>
                    
            <div class="d-flex justify-content-center px-3 border-0 py-3">
                <button type="button" class="btn  btn_style btn_style_height">OK</button>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal end -->





@include('includes.footer')
@endsection
@push('scripts')


<script
    src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCejQVcKXrBxZGFj0EQpSHkLgOk_Lp6CRI&region=IN">
</script>
@if(old('degree_title'))
<script>
    $(document).ready(function() {
       $('body').find('.dynamic').trigger('change');
    //    $('body').find('.dynamiccourse').trigger('change');
    });
</script>

@endif



<script>

        function checkEmail() {
        var email = $('#email').val();

        $.ajax({
            url: "{{ url('check-email') }}",
            type: 'POST',
            data: {'email': email},
            success: function(response) {
                
            if (response.exists) {
               // alert('This email address already exists.');
                $('#error-message').text('This email address already exists.');
            }else{
                $('#error-message').text('');
            }
            },
            error: function(xhr) {
          //      $('#error-message').text('An error occurred: ' + error);
          $('#error-message').text('');
           
           //     alert('Error: ' + xhr.responseText);
          
        }
        });
        }

$(document).ready(function() {
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


 $('.password-toggle .toggle-icon').click(function() {
    var passwordInput = $(this).prev('input');
    var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
    passwordInput.attr('type', type);
  if (type === 'password') {
        $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    } else {
        $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
    }
});

    
    
     $('#registerForm').validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2
            },
            // last_name: {
            //     minlength: 2
            // },
            nop_days: {
                required: true
            },
            work_type: {
                required: true
            },
            last_working_day: {
                required: function(element) {
                    return $('#nop_days').val() == '2';
                }
            },
            immediate_last_date: {
                required: function(element) {
                    return $('#nop_days').val() == '1';
                }
            },
            
             email: {
                required: true,
                email: true
            },
            
            phone: {
            required: true,
           // regex: /^(\+?\d{1,3}[\s-]?)?\d{10}$/
            },
            
            expect_ctc_lakhs: {
                required: true
            },
            
            expect_ctc_thousand: {
                required: true
            },
            
             expect_ctc_lakhs3: {
                required: true
            },
            
             expect_ctc_thousand3: {
                required: true
            },
            
              latestcom: {
                required: true
            },
            
              latestdesg: {
                required: true
            },
            
            
            
            totalexp: {
                required: true
            },
            totalexpmonth: {
                required: true
            },
            
             resume: {
                required: true,
                extension: "docx|pdf"
            },
            current_city: {
                required: true
            },
            
            
             "keyskills[]": {
                required: true,
                minlength: 10
            },
            
            
            password: {
                required: true
            },
            
            password_confirmation: {
                required: true
            },
            
            degree_title: {
                required: true
            },

            course: {
                required: {
                    depends: function(element) {
                        return $('#education1').val() != 5;
                    }
                }
            },
            specilation: {
                required: {
                    depends: function(element) {
                        return $('#education1').val() != 5;
                    }
                }
            },
            
            organization: {
                required: true
            },

            work_option:{
                required:true
            },

            gender_id:{
                required:true
            },
            year_of_completion:{
                required: true
            },
            
            terms_of_use: {
                required: true
            },
            
            
        },
        messages: {
            first_name: {
                required: "First Name is required",
                minlength: "Your first name must be at least 2 characters long"
            },
            // last_name: {
            //     minlength: "Your last name must be at least 2 characters long"
            // },
            nop_days: {
                required: "Notice Period is required"
            },
            work_type: {
                required: "Work Type is required"
            },
            last_working_day: {
                required: "Please enter your last working date",
            },
            immediate_last_date: {
                required: "Last Working Date is required",
            },
             email: {
                required: "Email is required",
                email: "Please enter a valid email address"
            },
            
           phone: {
            required: 'Phone Number is required',
            regex: 'Phone Number Must be an Number'
          },
          year_of_completion: {
                required: "Year of Completion field is required"
            },
          
          
          expect_ctc_lakhs: {
                required: "Current CTC Lakhs field is required"
            },
            
            expect_ctc_thousand: {
                required: "Current CTC Thousand field is required"
            },
            
             expect_ctc_lakhs3: {
                required: "Expect CTC Lakhs field is required"
            },
            
             expect_ctc_thousand3: {
                required: "Expect CTC Thousand field is required"
            },
            
            
            latestcom: {
                required: "Latest Company is required"
            },
            latestdesg: {
                required: "Latest Designation is required"
            },
            
            
            
             totalexp: {
                required: "Total Experience Year is required"
            },
            totalexpmonth: {
                required: "Total Experience Month is required"
            },
            
             resume: {
                required: "Resume is required",
                extension: "Upload resume will accept only .pdf and .docx"
            },
            current_city: {
                required: "Current City is required"
            },
            
            "keyskills[]": {
                 required: "Keyskills is required",
                 minlength: "Please select at least 10 key skills"
            },
            
           
             password: {
                required: "Password is required"
            },
            
            password_confirmation: {
                required: "Confirm Password is required"
            },
            
            degree_title: {
                required: "Education is required"
            },
            
            course: {
                required: "Course is required"
            },
            specilation: {
                required: "Specialization is required"
            },
            
             organization: {
                required: "University / College is required"
            },

            education_status:{
                required:"Education status is required"
            },
            
            terms_of_use: {
                required: "Please accept Terms & Conditions"
            },

            work_option: {
                required: "Preferren Mode is required"
            },

            gender_id: {
                required: "Gender is required"
            },
            
            
              
              
              
        },
        errorPlacement: function(error, element) {
          if (element.attr("name") === "keyskills[]") {
            error.insertAfter("#keyskillid");
          } else if (element.attr("name") === "latestcom") {
            error.insertAfter("#latestcomid");
          } else if (element.attr("name") === "terms_of_use") {
            error.insertAfter("#termsid");
          } else {
            error.insertAfter(element);
          }
        }
          
    });
    

var searchInput = 'autocomplete_reg';


var autocomplete;

autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

    types: ['(cities)'],


    componentRestrictions: {

        country: "IN"

    }

});



google.maps.event.addListener(autocomplete, 'place_changed', function() {

    var near_place = autocomplete.getPlace();

    var location = $("#autocomplete_reg").val();
    location = location.split(',')[0];
    $('#autocomplete_reg').val(location);

});



});

$(".js-example-tokenizer").select2({
    tags: true,
    placeholder: "Please enter key skills or technologies",
    tokenSeparators: [',']
});







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


var minimumTags = 10; 

$('#my-select').on('change', function() {
      var count = $('#my-select').select2('data').length;
      $('#selected-count').text(' (' + count + ' skills updated)');
        if (count < 10) {
        $('#my-select-container .select2-selection--multiple').css('border', '1px solid red');
            $('#skill-error').text('Please update 10 skills.');
           
            return false; // prevent form submission
            }
                        

         if (count >= 10) {
          $('#my-select-container .select2-selection--multiple').css('border', '1px solid #c1c1c1');
        $('#skill-error').text('');
        $('.Minimum').hide();
        }
                          
    });


$(".js-example-tags").select2({
                            tags: true
                          });


$('body').on('keyup', '.js-input-mobile', function() {
    var $input = $(this),
        value = $input.val(),
        length = value.length,
        inputCharacter = parseInt(value.slice(-1));

    if (!((length > 0 && inputCharacter >= 0 && inputCharacter <= 10) || (length === 1 && inputCharacter >= 7 &&
            inputCharacter <= 10))) {
        $input.val(value.substring(0, length - 1));
    }
});

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


$(function() {
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if (month < 10)
        month = '0' + month.toString();
    var minDate = year + '-' + month;

    $('#appendforsnpinput').attr('min', minDate);
});

// $(function() {
//     var dtToday = new Date();

//     var month = dtToday.getMonth() + 1;
//     var day = dtToday.getDate();
//     var year = dtToday.getFullYear();
//     if (month < 10)
//         month = '0' + month.toString();
//     if (day < 10)
//         day = '0' + day.toString();

//     var minDate = year + '-' + month + '-' + day;

//     $('#appendforsnpinputserveout').attr('min', minDate);
// });

$(function() {
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if (month < 10)
        month = '0' + month.toString();
    if (day < 10)
        day = '0' + day.toString();
    var minDate = year + '-' + month + '-' + day;
    $('#appendforsnpinputserveout').attr('min', minDate);
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
  orientation: 'bottom',
  endDate: new Date()
});

$(".datepicker").datepicker({
  autoclose: true,
  format: 'dd-M-yyyy',
  orientation: 'bottom',
  endDate: new Date()
});

$(".datepicker-noticeperiod").datepicker({
  autoclose: true,
  format: 'dd-M-yyyy',
  orientation: 'bottom',
  startDate: new Date(),
  endDate: new Date(new Date().setDate(new Date().getDate() + 90)) // Current date + 90 days
});





$.ajaxSetup({

headers: {

  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

}

});


$('.dynamic').change(function(){

// alert('heloo');

var degree_id = $(this).val(); 


// var oldCourse = "{{ old('course') }}";

//alert(oldCourse);


if(degree_id){
    if(degree_id == 5)
    {
        $('.dynamiccourse').empty(); // Set the value to an empty string to deselect any previously selected option
       // $('.dynamiccourse option:contains("N/A")').prop('selected', true); // Select the "N/A" option using the :contains selector
        $('.dynamiccourse').append('<option value="N/A" selected disabled>No Input Needed</option>');
        $('.dynamicspecs').append('<option value="N/A" selected disabled>No Input Needed</option>');
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
            return {
                q: params.term // Use the input value as the search query
            };
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