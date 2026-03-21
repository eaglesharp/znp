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

.select-skillval .select2-container--default .select2-selection--multiple .select2-selection__choice{
    border-radius: 30px!important;               
                background-color: #f6faff!important;
                padding: 0px 10px;
                height: 26px!important;
}
.select-location .select2-container--default .select2-selection--multiple .select2-selection__choice{
    border-radius: 30px!important;               
                background-color: #f6faff!important;
                padding: 0px 10px;
                height: 26px!important;
}
#my-select-container .select2-search__field {
    padding: 7px 0;
}
#my-select-container  .select2-selection--multiple {
    padding: 5px !important;
}

#my-select-locationcontainer .select2-search__field {
    padding: 7px 0;
}



.avatar-upload .avatar-edit {

position: absolute;

left: -11px;

z-index: 1;

top: -13px;

}

 .avatar-edit input {

display: none;

}

.avatar-upload .avatar-edit input+label {

    display: inline-block;
    width: 34px;
    height: 34px;
    line-height: 14px;
    left: 80px;
    margin-bottom: 10px;
    border-radius: 100%;
    background: #FFFFFF;
    border: 1px solid transparent;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    font-weight: normal;
    transition: all 0.2s ease-in-out;

}

.avatar-upload .avatar-edit input+label:hover {

background: #f1f1f1;

border-color: #d6d6d6;

}

.avatar-upload .avatar-edit input+label:after {

content: "\f040";

font-family: 'FontAwesome';

color: #757575;

position: absolute;

top: 10px;

left: 0;

right: 0;

text-align: center;

margin: auto;

}

.avatar-upload .avatar-preview {

position: relative;

}

</style>

<section class="postjob-listing section_signup post-section">

    <div class="container">

        <div class="col-md-12 col-lg-8 m-auto py-5">

            <div class="box py-4 rounded">

                <h5 class="sign_head text-center pt-3 mb-3">Update a <span class=" sign_color">Job</span></h5>


                <form class="px-3 px-sm-5 priceform row"  method="POST" id="updatejob"  action="{{ route('update.front.job',$job->id) }}">

                  
             @csrf

             @method('PUT')
                        

                    <div class="col-lg-6" id="div_company_name1">



                        <input type="hidden" value="" id="plandetail" name="job_title">

                        <p class="sign_fontsize mb-2 pt-3">Job Title<span class="text-danger px-1">*</span></p>

                        <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Job Title" maxlength="100" name="job_title" id="job_title" value="{{ $job->job_title??'' }}">
                        @if ($errors->has('job_title')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('job_title') }} </span> 
                            
                        @endif

                        
                    </div>


                    <div class="col-lg-6">
                     
                        <p class="sign_fontsize mb-2 pt-3">Mode of Work<span class="text-danger px-1">*</span></p>

                    
                        @php
                       $options = [
                            "Work From Office",
                            "Hybrid",
                            "Remote/WFH",
                            "Temp WFH",                          
                        ];
                       @endphp

                        <select id="inputState" class="w-100 py-2 px-3 signin_input rounded modeofwork" name="work_mode" value="{{ old('work_mode') }}">
                                <option  disabled>--Select--</option>
                                @foreach ($options as $option)
                                <option {{ $job->work_mode == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                        </select>      
                      
                        @if ($errors->has('work_mode')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('work_mode') }} </span> 
                            
                        @endif


                        
                    </div>


                    <div class="col-lg-12">
                                <p class="sign_fontsize mb-2 pt-3">Mode of Interview<span class="text-danger px-1">*</span></p>
                                
                                @php
                                $interviewOptions = [
                                    "CV Screening",
                                    "Technical Assessment",
                                    "Coding Test",
                                    "Video Interviews",
                                    "HR Interview",
                                    "Client Interview",
                                    "Case Study Challenge",
                                    "White Paper Challenge",
                                    "Walkin"
                                ];
                                @endphp
                                
                                <div class="checkbox-group row px-3">
                                    @foreach ($interviewOptions as $option)
                                    <div class="form-check col-lg-4">
                                                    <input class="form-check-input interview-option" type="checkbox" name="interview_modes[]" value="{{ $option }}" @if (in_array($option, explode(',', $job->interview_modes ?? ''))) checked @endif>

                                        <label class="form-check-label">{{ $option }}</label>
                                    </div>
                                    @endforeach
                                </div>

                                @php
                                $interviewModes = explode(',', $job->interview_modes);

                                if(in_array('Walkin', $interviewModes ?? []))
                                {
                                    $value = 1;
                                }else{
                                     $value = 0;
                                }


                                @endphp

                               
                               
                                
                                   <div class="walkin-details" @if (in_array('Walkin', $interviewModes ?? [])) style="display: block;" @else style="display: none;" @endif>
                                        <p class="sign_fontsize mb-2 pt-3">Walkin Details</p>
                                        <input type="date" class="form-control mb-2" name="walkin_date" value="{{ $job->walkin_date ?? old('walkin_date') }}">
                                        <input type="time" class="form-control mb-2" name="walkin_time" value="{{ $job->walkin_time ?? old('walkin_time') }}">
                                        <input type="text" class="form-control mb-2" name="walkin_venue" placeholder="Venue for Walkin" value="{{ $job->walkin_venue ?? old('walkin_venue') }}">
                                        <input type="text" class="form-control mb-2" name="walkin_contact" placeholder="Contact Person" value="{{ $job->walkin_contact ?? old('walkin_contact') }}">
                                    </div>



                                <!-- Display validation errors here if needed -->
                                
                            </div>

                
                    <div class="col-12">

                        <p class="sign_fontsize mb-2 pt-3">Job Type<span class="text-danger px-1">*</span></p>

                    
                        @php
                        $options = [
                            "Full time/Permanent",
                            "Contract",
                            "Contract To Hire",
                            "Internship",                          
                        ];
                       @endphp

                        <select id="job_type" class="w-100 py-2 px-3 signin_input rounded" name="job_type" value="{{ old('job_type') }}">
                                <option selected disabled>--Select--</option>
                                @foreach ($options as $option)
                                <option {{ $job->job_type == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                        </select>      
                      

                       
                        @if ($errors->has('job_type')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('job_type') }} </span> 
                            
                        @endif
                    </div>


                    
                    <div class="col-lg-12 pb-2" id="div_company_name" @if($job->job_type == "Full time/Permanent") style="display: none;" @endif>
                        <input type="hidden" value="" id="plandetail" name="duration">
                    
                        <p class="sign_fontsize mb-2 pt-2">Duration in Months</p>
                    
                        <input type="number" step="any" class="w-100 py-2 px-3 signin_input rounded" placeholder="Duration in months" maxlength="100" name="duration" id="duration" value="{{ old('duration',$job->duration) }}">
                        
                        @if ($errors->has('duration'))
                            <span class="help-block" style="color: red">{{ $errors->first('duration') }}</span>
                        @endif
                    </div>

                    <div class="col-12 mb-2">
                        <p class="sign_fontsize mb-2 pt-3">Job Shift<span class="text-danger px-1">*</span></p>

                        @php
                        $options = [
                            "Day Shift",
                            "UK Shift (1 PM Onwards)",
                            "US Shift (6 PM Onwards)",
                            "Night Shift (9 PM Onwards)",  
                            "Rotational Shifts"                           
                        ];
                        @endphp

                        <select id="job_shift" class="w-100 py-2 px-3 signin_input rounded" name="job_shift" value="{{ old('job_shift') }}" style="height: 42px;">
                            <option selected disabled>--Select--</option>
                            @foreach ($options as $option)
                            <option {{ $job->job_shift == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>      

                        @if ($errors->has('job_shift'))
                            <span class="help-block" style="color: red">{{ $errors->first('job_shift') }}</span>
                        @endif
                    </div>


                    <div class="col-12 col-md-12">

                        <label class="sign_fontsize">Skills<span class="text-danger px-1">* </span></label>
                                    <div class="w-100 select-skillval" id="my-select-container">

                                    
                                        <select class="form-control select-box" name="keyskills[]" multiple="multiple" placeholder="Please enter skills or technologies" id="chooseskill">
                   
                                        </select>
                                    
                                    </div>
                            
                                    <span class="error" id="keyskillid"></span>
                                    
                                        
                                        @if ($errors->has('keyskills')) <span class="help-block" style="color: red">
                                            
                                            {{ $errors->first('keyskills') }} </span> 
                                            
                                        @endif


                    </div>

                    <div class="col-lg-12 mt-2">
                            <label class="mb-2 sign_fontsize">Salary Range<span class="text-muted px-1">(Lakhs PA)</span></label>
                    </div>

                    <div class="col-lg-6 pb-3 pb-lg-0 position_lit">
                        <input type="number" step="any" onkeyup="imposeMinMax(this)" min="1" max="100" placeholder="Minimum" class="w-100 pl-3 pr-4 py-2  sign_fontsize  signup_input rounded btnsub1 edit1" name="min_salary" value="{{ $job->min_salary }}">  
                        @if ($errors->has('min_salary')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('min_salary') }} </span> 
                            
                        @endif
                    </div>

                    <div class="col-lg-6  pb-lg-0 position_lit">
                        <input type="number" step="any" onkeyup="imposeMinMax(this)" min="0" max="99" placeholder="Maximum" class="w-100 pl-3 pr-4 py-2 sign_fontsize  signup_input rounded btnsub1 edit1" name="max_salary" value="{{ $job->max_salary }}">
                        @if ($errors->has('max_salary')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('max_salary') }} </span> 
                            
                        @endif
                    </div>

                    <div class="col-lg-6">
                        <p class=" sign_fontsize mb-2 pt-3">Minimum Relevant Experience<span class="text-danger px-1">*</span>

                        </p>
                      @php
                                $options = [
                                    "Fresher",
                                    "Less than 1 Year",
                                    "1 Year",
                                    "2 Years",
                                    "3 Years",
                                    "4 Years",
                                    "5 Years",
                                    "6 Years",
                                    "7 Years",
                                    "8 Years",
                                    "9 Years",
                                    "10 Years",
                                    "11 Years",
                                    "12 Years",
                                    "13 Years",
                                    "14 Years",
                                    "15 Years",
                                    "16 Years",
                                    "17 Years",
                                    "18 Years",
                                    "19 Years",
                                    "20 Years",
                                    "21 Years",
                                    "22 Years",
                                    "23 Years",
                                    "24 Years",
                                    "25 Years",
                                    "26 Years",
                                    "27 Years",
                                    "28 Years",
                                    "29 Years",
                                    "30 Years"
                                ];

                        @endphp
                        <select id="inputState" class="w-100 py-2 px-3 signin_input rounded" name="experience" value="">
                                <option disabled>--Select--</option>
                                @foreach ($options as $option)
                                <option {{ $job->experience == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>                                                                                                                                               
                        @if ($errors->has('experience')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('experience') }} </span> 
                            
                        @endif
                        {{-- <!-- <input type="number" class="w-100 py-2 px-3 signin_input rounded" min="0" max="10" placeholder="Experience" name="Experience" value=""> --> --}}


                    </div>

                    <div class="col-lg-6">
                        <p class=" sign_fontsize mb-2 pt-3">Number Of Openings <span class="text-danger px-1">*</span>

                        </p>

                        <input type="number" class="w-100 py-2 px-3 signin_input rounded" min="0" max="50" placeholder="Number Of Openings" name="no_of_openings" value="{{ $job->no_of_openings }}">
                        @if ($errors->has('no_of_openings')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('no_of_openings') }} </span> 
                            
                        @endif

                    </div>

                    @php

                    $mode =  old('work_mode');


                    @endphp

                    <div class="col-12 select-location"  id="my-select-locationcontainer" @if($mode == "Remote/WFH") style="display:none;" @endif>
                        <input type="hidden" value="" id="plandetail" name="Location">

                        <p class="sign_fontsize mb-2 pt-3">Location<span class="text-danger px-1">*</span></p>

                        <select class="form-control select-box" name="location[]" multiple="multiple" placeholder="Please enter location" id="locationFilter42">
                   
                        </select>
                    

                        {{-- <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Location" maxlength="100" name="location" id="locationFilter42" value="{{ $job->location }}"> --}}
                        @if ($errors->has('location')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('location') }} </span> 
                            
                        @endif
                   
                    </div>

                    <div class="col-lg-12 select-locality" @if($mode == "Remote/WFH") style="display:none;" @endif >

                        <p class="sign_fontsize mb-2 pt-3">Locality</p>

                        <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Locality" maxlength="100" name="locality" id="locality" value="{{ old('locality',Auth::guard('company')->user()->location) }}">
                  
                        @if ($errors->has('locality')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('locality') }} </span> 
                            
                        @endif

                        
                    </div>



                   

                    <div class="col-12">

                        <p class="sign_fontsize mb-2 pt-3">Job Description<span class="text-danger px-1">*</span></p>
                        <textarea class="w-100 py-2 px-3 signin_input rounded summernote" placeholder="Job Description"  rows="3" name="job_description">{!! $job->job_description !!}</textarea>
                        @if ($errors->has('job_description')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('job_description') }} </span> 
                            
                        @endif
                        <!-- <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Location" maxlength="100" name="Location" id="Location" value=""> -->
                    </div>

                    <div class="col-12">

                        <p class="sign_fontsize mb-2 pt-3">Job Overview<span class="text-danger px-1">*</span></p>
                        <textarea class="w-100 py-2 px-3 signin_input rounded summernote" placeholder="Roles & Responsibility" id="description" name="job_overview"  rows="3">{!! $job->job_overview !!}</textarea>
                  
                        <!-- <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Location" maxlength="100" name="Location" id="Location" value=""> -->
                        @if ($errors->has('job_overview')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('job_overview') }} </span> 
                            
                        @endif
                    </div>

                    <div class="col-12">

                        <p class="sign_fontsize mb-2 pt-3">Roles & Responsibility<span class="text-danger px-1">*</span></p>
                        <textarea class="w-100 py-2 px-3 signin_input rounded summernote" placeholder="Roles & Responsibility" id="description" name="roles_responsibility"  rows="3">{!! $job->roles_responsibility !!}</textarea>
                    
                        <!-- <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Location" maxlength="100" name="Location" id="Location" value=""> -->
                        @if ($errors->has('roles_responsibility')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('roles_responsibility') }} </span> 
                            
                        @endif
                    </div>

                    <div class="col-12">

                        <p class="sign_fontsize mb-2 pt-3">About Company<span class="text-danger px-1">*</span></p>
                        <textarea class="w-100 py-2 px-3 signin_input rounded " placeholder="About Company" id="description" name="description"  rows="3">{{ old('description',Auth::guard('company')->user()->description) }}</textarea>
                    
                        <!-- <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Location" maxlength="100" name="Location" id="Location" value=""> -->
                        @if ($errors->has('description')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('description') }} </span> 
                            
                        @endif
                    </div>

                 



                    <div class="col-lg-12" >

                        <p class="sign_fontsize mb-2 pt-3">Website Address<span class="text-danger px-1">*</span></p>

                        <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Website Address" maxlength="100" name="website_address" id="website_address" value="{{ old('website_address',$job->website_address??'') }}">
                  
                        @if ($errors->has('website_address')) <span class="help-block" style="color: red">
                                           
                            {{ $errors->first('website_address') }} </span> 
                            
                        @endif

                        
                    </div>

                    <div class="col-lg-12 mt-3 mb-5" >

                        <p class="sign_fontsize mb-2 pt-3">Logo</p> 
                      
                        <div class="avatar-upload mt-4 mb-5"> 
                            <div style="" class="avatar-edit">

                             

                                    <input type='file' id="imageUpload" name="logo" class="changeimage"
                                        accept=".png, .jpg, .jpeg" />

                                    <label for="imageUpload"></label>



                                    <span class="text-danger"></span>



                                    @if(!Auth::guard('company')->user()->logo)

                                    <input type="file" name="logo" class="form-control" style="width: 60%;">

                                    @else

                                    @if(Auth::guard('company')->user()->logo)

                                    <img src="{{ asset('company_logos/'.Auth::guard('company')->user()->logo) }}"
                
                                        class="img-fluid canddashboard-userpic" style="width: 50px;height: 50px;">
                                        
                
                                    @else
                
                                    <img src="asset/images/dashboardpic.png" style="width: 115px;height: 115px;" class="img-fluid  canddashboard-userpic">
                
                                    @endif
                                    @endif

                                    @if ($errors->has('logo')) <span class="help-block" style="color: red">
                                                    
                                        {{ $errors->first('logo') }} </span> 
                                        
                                    @endif

                            
                            </div>
                        </div>
                    </div>






                    <div class="col-12 py-4">
                        <button type="submit" class="w-100 py-2 signup_button rounded">Post Job</button>
                    </div>
                </form>
                <!-- <div class="col-12">

                    <div class="text-center pt-4 sign_fontsize d-none">Already have an account ? <a href="http://127.0.0.1:8000/employer-login">Sign
                            in</a></div>

                </div> -->
                <!-- <div class="col-12">

                    <div class="text-center pt-4 sign_fontsize">Sign up as an Jobseeker <a href="http://127.0.0.1:8000/register">Sign
                            up</a></div>

                </div> -->

            </div>

        </div>
    </div>

</section>


@php
     if(isset($resultdata)) {       

            $selected = $resultdata;

        }

     if(isset($locationresult)) {       

           $locationresultSelected = $locationresult;

     }


@endphp




@include('includes.footer')
@endsection
@push('styles')
<style type="text/css">
    .formrow iframe {
        height: 78px;
    }
</style>
@push('scripts')
<script
    src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCejQVcKXrBxZGFj0EQpSHkLgOk_Lp6CRI&region=IN">
</script>


<script>


      const interviewOptions = document.querySelectorAll('.interview-option');
    const walkinDetails = document.querySelector('.walkin-details');

    interviewOptions.forEach(option => {
        option.addEventListener('change', function() {
            if (this.value === 'Walkin') {
                walkinDetails.style.display = this.checked ? 'block' : 'none';
            }
        });
    });


    var modeofWork = $(".modeofwork");

     modeofWork.change(function() {
          modeofwork($(this).val());
      });

     function modeofwork(val)
     {
        if(val == "Remote/WFH")
        {
            console.log('yes');
            $('.select-location').hide();
            $('.select-locality').hide();
        }else{
            console.log('no');
            $('.select-location').show();
            $('.select-locality').show();
        }

     }



$(".changeimage").change(function() {

var formData = new FormData();  // Create a new FormData object

// Append the selected file to the FormData object
formData.append('logo', $('#imageUpload')[0].files[0]);

// Append the CSRF token to the FormData object
formData.append('_token', '{{ csrf_token() }}');

    $.ajax({

        url: "{{url('employer-image-store')}}",

        type: "POST",

        data: formData, 

        processData: false,

        contentType: false,

        _token: '{{ csrf_token() }}',

        dataType: 'json',

        success: function(data) {

            console.log(data.url);

            $('.canddashboard-userpic').attr('src',data.url);



        },



        error: function(json) {



            // location.reload(true);



            if (json.status === 422) {

                var resJSON = json.responseJSON;

                $('.help-block').html('');

                $.each(resJSON.errors, function(key, value) {

                    $('.' + key + '-error').html('<strong class="text-danger">' + value +
                        '</strong>');

                    $('#div_' + key).addClass('has-error');

                });

            } else {

                // Error

                // Incorrect credentials    

                // alert('Incorrect credentials. Please try again.')

            }



        }



    });

});

          // Function to show or hide the duration field based on the selected job type
          function toggleDurationField() {
      
            var selectedJobType = document.getElementById('job_type').value;
            var durationField = document.getElementById('div_company_name');
            
            if (selectedJobType === 'Full time/Permanent') {
                // If "Full time/Permanent" is selected, hide the duration field and clear its value
                durationField.style.display = 'none';
                document.getElementById('duration').value = '';
            } else {
                // If any other option is selected, show the duration field
                    durationField.style.display = 'block';
                }
            }

            // Attach an event listener to the dropdown to trigger the toggle function on change
            document.getElementById('job_type').addEventListener('change', toggleDurationField);

            // Call the function once on page load to initialize the state based on the initial value
            // toggleDurationField();



        function checkEmail() {
        var email = $('#email').val();

        $.ajax({
            url: '/check-email',
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


$.validator.addMethod("summernoteEmpty", function (value, element) {
    // Get the Summernote content from the hidden textarea
    var summernoteContent = $(element).summernote('code').trim();
    // Check if the content is empty
    return summernoteContent !== "";
}, "This field is required.");

    





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



    $('#locationFilter42').select2({
    tags: true, 
    tokenSeparators: [','],
    placeholder: "(Add Location)",
    minimumInputLength: 1, // Set the minimum input length to 2
    ajax: {
        url: "{{ url('autocomplete/search-location-job') }}",
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



var selectedValues = @json($selected);




    //console.log(selectedValuese);

    $('#chooseskill').select2({
    tags: true,
    tokenSeparators: [','],
    placeholder: "(Search Skill)",
    minimumInputLength: 1, // Set the minimum input length to 1
    ajax: {
        url: '/search-skills', // Replace this with the URL to your search endpoint
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
                        id: skill.id,
                        text: skill.job_skill
                    };
                })
            };
        },
        cache: true
    }
});
@if(isset($resultdata))
    // Set the selected values
    var selectedValues = {!! json_encode($selected) !!};
    var select = $('#chooseskill');
    for (var id in selectedValues) {
       // console.log(selectedValues[id])
        var option = new Option(selectedValues[id], id, true, true);
        select.append(option).trigger('change');
    }
@endif

@if(isset($locationresult))

    // Set the selected values
    var selectedValues = {!! json_encode($locationresultSelected) !!};

    // Get the select element by its ID
    var select = $('#locationFilter42');

    // Clear existing options (optional)
    select.empty();

    // Loop through the selectedValues array
    for (var i = 0; i < selectedValues.length; i++) {
        // Create a new option element with the value and text from selectedValues
        // The 'true' arguments indicate that the option is both selected and default selected
        var option = new Option(selectedValues[i], selectedValues[i], true, true);
        
        // Append the option to the select element
        select.append(option).trigger('change');
    }
@endif


            

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

});



</script>

<script>  
        $(document).ready(function() { 

            $('textarea.summernote').summernote({   
                placeholder: 'Write Your Message',  
                tabsize: 2, 
                height: 100,    
                toolbar: [  
                    // ['style', ['style']],   
                    ['font', ['bold', 'italic', 'underline', 'clear']], 
                    // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']], 
                    //['fontname', ['fontname']],   
                    // ['fontsize', ['fontsize']],  
                    // ['color', ['color']],   
                    ['para', ['ul', 'ol', 'paragraph']],    
                    // ['height', ['height']],  
                    // ['table', ['table']],    
                    // ['insert', ['link']],   
                    // //['view', ['fullscreen', 'codeview']],  
                    // ['help', ['help']]   
                ],  
                callbacks: {
                    onPaste: function(e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                        e.preventDefault();
                        document.execCommand('insertText', false, bufferText);
                    }
                    }
            }); 
        }); 

        var searchInput = 'autocomplete10';



$(document).ready(function() {

    $location_input = $("#autocomplete10");

    var autocomplete;

    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

        types: ['(cities)'],


        componentRestrictions: {

            country: "IN"

        }

    });



    google.maps.event.addListener(autocomplete, 'place_changed', function() {

        var near_place = autocomplete.getPlace();

        var location = $("#autocomplete10").val();
        location = location.split(',')[0];
        $('#autocomplete10').val(location);

    });

});
    </script> 

    
@endpush
