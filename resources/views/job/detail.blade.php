@extends('layouts.app')

@section('content')

@include('includes.header')

<style>
    .share-job .link{
        color: #197ff3 !important;
        text-decoration: underline !important;
        cursor: pointer;
    }
    .btn-sent-apply-job{
        width: 132px;
        color: black !important;
        border: 2px solid #0642a9;
        border-radius: 30px;
        padding: 2px;
    }
    @media screen and (max-width: 767px)
    {
        .btn-sent-apply-job {
        margin-bottom: 10px;
    }
    }
    
</style>



<section class="postjob-listing py-5 section_canddashboard" >
    <div class="container" style='user-select: none;'>
        <div class="row">
            <div class="col-lg-7 pr-lg-3 pl-lg-0 p-0">
                <div class="boxing rounded dash_box-right ">
                    <div class="row pt-3">
                        <div class="col-lg-9 col-md-10">
                            <div class="row">
                            <div class="col-lg-2 pr-0 mr-0 text-center col-3 col-md-2 detail-industry">
                                @if(isset($job->company->logo))
                                <img src="{{ asset('company_logos/'.$job->company->logo) }}" width="50" height="50"> 
                                @else
                                <img src="{{asset('/')}}asset/images/industry-logo.png" width="50" height="50" style= ' border-radius : 50%'>
                                @endif
                            </div>
                            <div class="col-lg-10 pl-0 ml-0 col-9 col-md-10">
                                <h2 class="line_change_detail font-weight-bold mb-0">{{ $job->job_title??'' }} </h2>
                                <ul class="list-inline pt-2">
                                    <li class="list-inline-item"><i class="fa fa-building-o pr-2"></i>{{ $job->company->name??'' }}</li>
                                    @php


                                      
                                        try {

                                                $loc = unserialize($job->location);
                    
                                                $values = array_values($loc);
                    
                                                $result = implode(',', $values);

                                        } catch (Exception $e) {
                                            if($job->location)
                                            {

                                                $result=$job->location;
                                            }else {
                                                $result="";
                                            }
                                         
                                        }

                                       
                                                            
                                    @endphp

                                    @if ($result)
                                      <li class="list-inline-item"><i class="fa fa-map-marker pr-2"></i>{{ $result??'' }}</li>
                                    @endif

                                    @if (isset($job->company->location))

                                      <li class="list-inline-item"><span>Locality:</span> {{ $job->company->location??'' }}</li>
                                        
                                    @endif
                                   
                                   

                                </ul>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-2 my-auto text-center">
                           
                            @if(Auth::check() && Auth::user()->isAppliedOnJob($job->id))                          
                            <button  class="btn btn-sent-apply  mb-sm-2 mr-2" >Applied</button>
                            @elseif(Auth::check())
                            <button  class="btn btn-sent-apply  mb-sm-2 mr-2" id="showapplied" style="display:none">Applied</button>
                            <button type="submit" class="btn btn-sent-apply mb-2 mb-sm-2 mr-2" data-toggle="modal" data-target="#firstmodal" id="apply-1" style="display:block">Apply</button>
                            @else
                            @php
                                 Session::put('url.intended', url()->current());
                            @endphp
                            <a class="btn btn-sent-apply mb-sm-2 mr-2" href="{{ url('login') }}">Login To Apply</a>
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-share-alt pr-2"></i>
                              </button> --}}
                            <li class="list-inline-item share-job mb-2">
                                {{-- <i class="fa fa-share-alt pr-2" style="cursor:pointer" ></i> --}}
                                <a class="btn btn-sent-apply-job mb-sm-2 mr-2 text-white" data-toggle="modal" data-target="#myModal">Share Job</a>
                                {{-- <a class=" mb-sm-2 mr-2 link" data-toggle="modal" data-target="#myModal">Share Job</a> --}}
                            
                            </li>                              
                            @endif
                           
                        </div>
                    </div>
                    @php
                        $jobsappllied = \App\JobApply::where('job_id',$job->id)->count();
                        $user = auth()->user();
                        if($user)
                        {
                            $interview = \App\Interview::Where("user_id",$user->id)->first();
                        }

                        if($job->interview_modes)
                        {
                             $interviewModes = explode(',', $job->interview_modes);
                        }


                       
                    
                        
                    @endphp
                 
                 
                    <div class="row">
                        <div class="col-6 pt-2 pt-lg-0 border-top">
                                <ul class="date pt-3">
                                    <li class="list-inline-item"><span>Job Applicants : {{ $jobsappllied??'' }}</span></li>
                                </ul>
                        </div>
                        <div class="col-6 pt-2 pt-lg-0 border-top text-md-right">
                                <ul class="date pt-3">
                                    <li class="list-inline-item"><span>Posted Date : </span>{{ \Carbon\Carbon::parse($job->created_at)->format('d-m-Y')  }} </li>
                                </ul>
                        </div>
                    </div>
                </div>
                <div class="boxing rounded justify-content-center bg-white px-lg-5">
                            <h3 class="pt-4">Job Description</h3>
                         {!! $job->job_description??'' !!}
                            <h3 class="pt-4">Job Overview</h3>
                           {!! $job->job_overview??'' !!}
                            <h3 class="pt-4">Roles & Responsibilities</h3>
                            {!! $job->roles_responsibility??'' !!}
                </div>

            </div>
            <div class="col-lg-5 pl-lg-3 pr-lg-0 p-0">
              
                <div class="boxing rounded justify-content-center bg-white px-lg-5 pb-4">
                            <h3 class="pt-4">Job Summary</h3>
                            <ul class="detail-list">
                                <li class="pt-3"><i class="fa fa-money mr-2"></i><span>Salary Range :</span> @if($job->min_salary == "1") {{ $job->min_salary??'' }} Lakh @else {{ $job->min_salary??'' }} Lakhs @endif - {{ $job->max_salary??'' }} Lakhs a year</li>
                                <li class="pt-3"><i class="fa fa-suitcase mr-2"></i><span>Job Type :</span> {{ $job->job_type??'' }} </li>
                               
                                <li class="pt-3"><i class="fa fa-calendar mr-2"></i><span>Experience :</span> {{ $job->experience??'' }}</li>
                                <li class="pt-3"><i class="fa fa-user-plus mr-2"></i><span>Number Of Openings:</span> {{ $job->no_of_openings??'' }}</li>
                              @if ($job->job_shift)
                              <li class="pt-3"><svg xmlns="http://www.w3.org/2000/svg" style="
                                width: 15px;
                                margin-right: 4px;
                            " fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />
                              </svg>
                              <span>Job Shift :</span> {{ $job->job_shift??'' }} </li>
                              @endif
                               <li class="pt-3"><i class="fa fa-suitcase mr-2"></i><span>Mode of Work:</span> {{ $job->work_mode??'' }}</li>


                              @if ($job->website_address)                                  
                              <li class="pt-3"><i class="fa fa-globe mr-2"></i><span>Web. Address:</span> {{ $job->website_address??'' }}</li>
                              @endif

                              @if(isset($interviewModes))
                              @if (in_array('Walkin', $interviewModes ?? [])) 
                                  <li class="pt-3 pl-1"><i class="fa fa-info mr-2"></i><span>Walkin Details:</span> </li>
                                  <li class="pt-3 pl-4"><span>Date:</span> {{ $job->walkin_date }}</li>
                                  <li class="pt-3 pl-4"><span>Time:</span> {{ $job->walkin_time }}</li>
                                  <li class="pt-3 pl-4"><span>Venue for Walkin:</span> {{ $job->walkin_venue }}</li>
                                  <li class="pt-3 pl-4"><span>Contact Person:</span> {{ $job->walkin_contact }}</li>
                              @endif
                              @endif
                                       



                             
                                {{-- <li class="pt-3"><i class="fa fa-globe mr-2"></i><span>Locality:</span> {{ $job->company->location??'' }}</li> --}}

                            </ul>   


                              @if(isset($interviewModes))
                                 <h3 class="pt-4">Mode of Interview </h3>
                                 <ul class="list-inline developer">   
                                    @foreach($interviewModes as $mode)
                                        <li class="list-inline-item terms-mode mb-1">{{ $mode??'' }}</li>
                                    @endforeach 
                                </ul>  
                             @endif
                            
                            <h3 class="pt-4">Skills</h3>
                            <ul class="list-inline developer">   
                                @foreach($jobskills as $jobskill)
                                    <li class="list-inline-item terms mb-1">{{ $jobskill->job_skill??'' }}</li>
                                @endforeach    

                              
                            </ul>
                </div>  
                
                @if(isset($job->company->description))
                <div class="boxing-job company pt-4 mt-2 px-lg-5 pb-2 my-4">
                    <h2>About Company</h2>
                    <p class="text-white">{!! $job->company->description??'' !!}</p>
                    <div>
                    </div>
                </div> 
                @endif

                <div class="boxing rounded justify-content-center bg-white px-lg-5 pb-4 job-detail-img">
                           
                            <p class="pr-4 pt-3">ZeroNoticePeriod is an exclusive online hiring platform connecting Job seekers with ZERO Notice Period with employers looking for Immediate hires. That’s our niche. With a focused & verified database of Talent with Zero Notice Period, We help Employers hire at a very fast pace without having to lose time on "searching" talent with Zero notice period
                                .</p>
                                <p>ZeroNoticePeriod equals Fastest Hiring.</p>                            <a href="{{ url('jobs') }}">Find More Jobs</a>
                </div>        
           
             </div>
       



        </div>
        
    </div>
</section>



<!--cv Search Plan Expire modal -->

<div class="container">

    <div class="modal" id="firstmodal">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content modal_content_custom_width mx-auto p-3">

                <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"

                        src="{{ asset('/') }}asset/images/close.png"></p>

                <div class="modal-body py-0">

                    <div class="collection_pic-box mt-2 mt-md-0">
                        <h4 class="font_color text-center">Apply Now</h4>
                        {{-- <form class="px-3 px-sm-5 coverletter row" action="" method="POST" id="coverletter1">
                            @csrf
                            <input type="hidden" id="job_id" value="{{ $job->id??'' }}">
                            <div class="col-12">
                                <p class="sign_fontsize mb-2 pt-3">Message<span class="text-danger px-1">*</span></p>
                                <textarea class="w-100 py-2 px-3 signin_input rounded summernote" placeholder="Message" id="description" name="description"  rows="5"></textarea>
                                <p class="success_msg1 covererror " style="color:red" id="covererror" ></p>

                                <button type="button" class="btn btn-sent mb-2 mb-sm-4 mr-2 mt-4" id="apply-now">Apply Now</button>

                                <!-- <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Location" maxlength="100" name="Location" id="Location" value=""> -->
                            </div>
                        </form> --}}
                        @if($user)
                        <form class="form" id="add_profile_np" method="POST" action="{{ route('job.update.front.profile.np', [$user->id]) }}">{{ csrf_field() }}

                            <div class="success_msg1 success_msg17 " id="success_msg17"></div>
                    
                            <input type="hidden" id="job_id" value="{{ $job->id??'' }}" name="job_id">
                    
                            <div class="row">
                    
                                <div class="col-lg position_lit">
                    
                                    <label class="mb-2 sign_fontsize">Notice Period Status<span
                    
                                            class="text-danger px-1">*</span></label>
                    
                                            <input type="hidden" value="{{$user->id}}" name="user_id">
                    
                                    <select name="nop_days" 
                    
                                        class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded newtest"
                    
                                        id="noticeperiodopt1">
                    
                                        <option selected disabled>Select Option</option>
                    
                                        <option   value="1" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days=="1") selected @endif  @endif>Immediately Available</option>
                    
                                    <option  value="2" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days=="2") selected @endif  @endif>Serving Notice Period</option>
                    
                                    </select>
                                    <span class="help-block nop_days-error"></span> 
                    
                                </div>
                    
                            </div>
                    
                            <div id="appendforsnp" @if(isset($user->getprofileNop()->nop_days))@if($user->getprofileNop()->nop_days !="2")style="display:none" @endif @endif>
                    
                                <div  class="row" id="test_yes1">
                    
                                    <div class="col-lg-12">
                    
                                        <label class="mb-2 pt-3 sign_fontsize"> Last working date incase notice period is being
                    
                                            served<span class="text-danger px-1">*</span></label>
                    
                                        <input type="text" name="last_working_day" class="w-100 signup_input rounded px-3 py-2 sign_fontsize datepicker  newtest  " value="{{isset($user->getprofileNop()->last_working_day) ? \Carbon\Carbon::parse($user->getprofileNop()->last_working_day)->format('d-M-Y'): ''  }}"
                    
                                            id="appendforsnpinput">
                                            <span class="help-block last_working_day-error" style="color:#a94442"></span>
                    
                                    </div>
                    
                                </div>
                    
                            </div>
                    
                            <div class="row" id="appendforbnp" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days !="1")style="display:none" @endif @endif>
                    
                                <div class="col-lg-12">
                    
                                    <label class="mb-2 pt-3 sign_fontsize">Mention your Last Working Date with your last employer OR your Month of graduation in case you are a fresher<span
                    
                                            class="text-danger px-1">* </span></label>
                    
                                    <input type="text" name="immediate_last_date" class="w-100 signup_input rounded px-3 py-2 newtest datepicker-month" id="appendforbnpinput" value="{{(isset($user->getprofileNop()->immediate_last_date) ?$user->getprofileNop()->immediate_last_date: '')  }}" >
                    
                                    <span class="help-block immediate_last_date-error" style="color:#a94442"></span>
                    
                                </div>
                    
                            </div>

                            <label class="my-3 sign_fontsize">Video Interview Availability</label>
                            <div class="row template">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 sign_fontsize">Date<span class="text-danger px-1">*</span></label>
                                        <input type="text" name="date[]" class="w-100 signup_input rounded px-3 py-2 sign_fontsize date-picker">
                                        <span class="help-block date-error" style="color:#a94442"></span> 
                                     
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 pt-3 pt-lg-0 sign_fontsize">From Time<span class="text-danger px-1">*</span></label>
                                        <input type="text" name="from_time[]" class="w-100 signup_input rounded px-3 py-2 sign_fontsize timepicker" id="edit_input_from">
                                        <span class="help-block from_time-error" style="color:#a94442"></span> 
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="mb-2 pt-3 pt-lg-0 sign_fontsize">To Time<span class="text-danger px-1">*</span></label>
                                        <input type="text" name="to_time[]" class="w-100 signup_input rounded px-3 py-2 sign_fontsize timepicker" id="edit_input_to">
                                        <span class="help-block to_time-error" style="color:#a94442"></span> 
                                    </div>
                                </div>
                            </div>
                            <div class=" addfields">

                            </div>
                            
                            <a id="addMoreFields" class="btn btn-primary">Add More</a>

                            {{-- <div class="row" >
                                <div class="col-lg-12">
                                    <p class="sign_fontsize mb-2 pt-3">Mention relevant skills/expertise you have for the role<span class="text-danger px-1">*</span></p>
                                    <textarea class="w-100 py-2 px-3 signin_input rounded " placeholder="Message" id="description" name="description"  rows="5"></textarea>
                                    <p class="success_msg1 covererror " style="color:red" id="covererror" ></p>

                                </div>
                            </div> --}}

                    
                            <div class="col-lg-12  mt-1 text-center">
                            <br>
                             
                                    <button type="button" class="signin_button rounded px-3 py-1" onClick="submitnopskills();">Apply Now</button>
                           <br>
                                   
                            </div>
                    
                        </form> 
                        @endif
                        <div class="collection_text px-lg-3 py-0">

                            <!-- <h3 class="line_change font_size">Alert</h3>

                            <p class="fs-18 mb-1">Thank you for Applying job.</p>
                            <p>Our recruiters will get back to you soon.....</p> -->

                            <div class="error_message1 " id=""></div>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>



<!-- modal end -->



<!--cv Search Plan Expire modal -->

<div class="container">

    <div class="modal" id="second-modal">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content modal_content_custom_width mx-auto p-3">

                <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"

                        src="{{ asset('/') }}asset/images/close.png"></p>

                <div class="modal-body py-0">

                    <div class="collection_pic-box mt-2 mt-md-0 text-center">

                                <!-- <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Location" maxlength="100" name="Location" id="Location" value=""> -->
                            </div>
                        </form>

                        <div class="px-lg-3 py-0 text-center">

                            <p class="fs-18 mb-1">Thank you for Applying job.</p>
                            <p>Our recruiters will get back to you soon.....</p>

                            <div class="error_message1 " id=""></div>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>


<!--cv Search Plan Expire modal -->

<div class="container">

    <div class="modal" id="myModal">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content modal_content_custom_width mx-auto p-3">

                <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"

                        src="{{ asset('/') }}asset/images/close.png"></p>

                <div class="modal-body py-0">

                    <h2 class="font_color text-center">Share job</h2>
                        <div class="px-lg-3 py-0 text-center">
                            <ul class="pricing-package pt-4 d-flex justify-content-center">


                                <li class="d-inline">
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank">
                                        <img src="{{ asset('asset/images/linkedin.png')}}" alt="Share on LinkedIn" class="img-fluid pr-2">
                                    </a>
                                </li>

                                <li class="d-inline">
                                    <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ urlencode($job->job_title ?? '') }} - Check out this awesome job!" target="_blank">
                                        <img src="{{ asset('asset/images/twitter.png')}}" alt="Share on Twitter" class="img-fluid pr-2">
                                    </a>
                                </li>

                                <li class="d-inline">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&quote={{ urlencode($job->job_title ?? '') }} - Check out this awesome job!" target="_blank">
                                        <img src="{{ asset('asset/images/fb.png')}}" alt="Share on Facebook" class="img-fluid pr-2">
                                    </a>
                                </li>

                                <li class="d-inline">
                                    <a href="https://www.instagram.com/share?url={{ url()->current() }}&caption={{ urlencode($job->job_title ?? '') }} - Check out this awesome job!" target="_blank">
                                        <img src="{{ asset('asset/images/insta.png')}}" alt="Share on Instagram" class="img-fluid pr-2">
                                    </a>
                                </li>
                                <!--<li class="d-inline">-->
                                <!--    <a href="https://www.youtube.com/create_link?url={{ url()->current() }}&title={{ urlencode($videoTitle ?? '') }}" target="_blank">-->
                                <!--        <img src="{{ asset('asset/images/youtube.png')}}" alt="Share on YouTube" class="img-fluid pr-2">-->
                                <!--    </a>-->
                                <!--</li>-->

                            </ul>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>




<script>
    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });
</script>



@include('includes.footer')

@endsection


@push('scripts') 

<script type="text/javascript">


$(document).ready(function(){


//set button id on click to hide first modal
$("#apply-now").on( "click", function() {


    $.ajax({
        url:"{{ url("applyjob") }}",
        method: 'POST',
        data:{

            job_id:$('#job_id').val(),

            _token:"{{ csrf_token() }}",

            coverletter: $('#description').val(),

        },
        success:function(result)
        {
            console.log('success');
            $('#firstmodal').modal('hide');  
            $('#second-modal').modal('show'); 
            $("#showapplied").css('display','block');
            $("#apply-1").css('display','none');

        },
        error:function(json)
        {
            if (json.status == 422) {

                console.log('error');
                $(".covererror").html("{{__('Cover Letter is required')}}");
            }
           
        }


    });
  


    });
    

});




$("#noticeperiodopt1").change(function(){

var value= this.value;


if(this.value==2)
{ 
$('#appendforsnp').show();
} else{
$('#appendforsnp').hide(); }



});


$('#noticeperiodopt1').change(function(){



if(this.value==1)

{

$('#appendforbnp').show();

}else{

$('#appendforbnp').hide();

}



});


function submitnopskills() {

    var form = $('#add_profile_np');

    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        dataType: 'json',
        success: function (json) {
            $(".success_msg17").show();
            $('.help-block').hide();
            $(".newtest").css("border-color", "#ccc ");
            $(".success_msg17").html("<div class='alert alert-success'>{{__('You have successfully applied for the job!')}}</div>");
            setTimeout(function () {
                $(".success_msg17").hide();
                location.reload();
            }, 2000);
        },
        error: function (response) {
            if (response.status === 422) {
                var errors = response.responseJSON.errors;

                // Clear previous error messages
                $('.help-block').empty();

                // Loop through the errors and display them
           

                $.each(errors, function (field, messages) {
            var fieldIndex = field.split('.').pop(); // Extract the array element index
            var fieldName = field.replace('.' + fieldIndex, ''); // Remove the index from the field name

            var errorField = $('input[name="' + fieldName + '[]"]').eq(fieldIndex);
            var errorBlock = errorField.siblings('.help-block');
            console.log(errorField)
                    console.log(field)
            errorBlock.text(messages[0]);
            errorField.addClass('is-invalid');
        });
                
            }
        }

    });

}


// Function to display the error message for a specific field
function displayError(field, message, index = null) {
    var errorContainer = $('<strong class="new_error_class">' + message + '</strong>');
    var parent = field.closest('.form-group');
    if (index !== null) {
        parent = parent.eq(index);
    }
    parent.append(errorContainer);
}




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

$('.date-picker').datepicker({

startDate: new Date(), // controll start date like startDate: '-2m' m: means Month
endDate: '+30d',
format: 'dd-mm-yyyy',
changeMonth: true,
changeYear: true


});

  // Initialize timepicker
  $('.timepicker').timepicker({});

  // Add event listener to edit_input_from
  $('#edit_input_from').on('change', function() {
        var fromTime = $(this).val();
        if (fromTime) {
      

            // Original time in 12-hour format: "5:30 PM"
var originalTime =fromTime;

// Parse the original time in 12-hour format to a 24-hour format
var timeParts = originalTime.split(" ");
var timeWithoutAmPm = timeParts[0];
var isPM = timeParts[1].toUpperCase() === "PM";
var timeArray = timeWithoutAmPm.split(":");
var hours = parseInt(timeArray[0]);
var minutes = parseInt(timeArray[1]);

if (isPM && hours !== 12) {
  hours += 12;
} else if (!isPM && hours === 12) {
  hours = 0;
}

// Create a new Date object with the original time in 24-hour format
var dateObj = new Date();
dateObj.setHours(hours);
dateObj.setMinutes(minutes);

// Add one hour to the time
dateObj.setHours(dateObj.getHours() + 1);

// Format the updated time to display in 12-hour format
var updatedHours = dateObj.getHours() % 12 || 12;
var updatedMinutes = dateObj.getMinutes();
var updatedAmPm = dateObj.getHours() >= 12 ? "PM" : "AM";
var updatedTime = updatedHours + ":" + (updatedMinutes < 10 ? "0" : "") + updatedMinutes + " " + updatedAmPm;



            // Set the value of edit_input_to
            $('#edit_input_to').val(updatedTime);
        }
    });


$(document).ready(function() {
    var maxOptions = 3; // Maximum number of options allowed
    var optionCount = 1; // Initial option count

    
    // Function to initialize datepicker
    function initializeDatepicker(element) {
        $(element).datepicker({
            startDate: '-2m', // Control start date (2 months ago)
            endDate: '+30d', // Allow selection up to 30 days from now
            format: 'dd-mm-yyyy',
            changeMonth: true,
            changeYear: true
        });
    }
    
    $('#addMoreFields').click(function() {
        if (optionCount < maxOptions) {
            var template = $('.template').clone(); // Clone the template
            template.removeClass('template'); // Remove the 'template' class from the cloned element
            
            // Add a delete button for the current option
            var deleteButton = $('<button class="btn btn-danger deleteOption" style="margin-left: 14px;margin-bottom: 12px;">Delete</button>');
            deleteButton.click(function() {
                $(this).parent().remove(); // Remove the parent div when delete button is clicked
                optionCount--; // Decrease the option count
            });
            template.append(deleteButton); // Append the delete button to the cloned element
            
            $('.addfields').append(template); // Append the cloned element to the row
            optionCount++; // Increase the option count

              // Initialize datepicker for the new fields
              var newDatepicker = template.find('.date-picker');
            initializeDatepicker(newDatepicker);

            $('.timepicker').timepicker({});
        }
    });
});


</script>
@endpush
