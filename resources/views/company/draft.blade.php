@extends('layouts.app')



@section('content') 



<!-- Header start --> 



@include('includes.header') 
<style>
    #overlay {
      position: fixed;
      display: none;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0,0,0,0.5);
      z-index: 2;
      cursor: pointer;
    }
    #text{
      position: absolute;
      top: 50%;
      left: 50%;
      font-size: 50px;
      color: white;
      transform: translate(-50%,-50%);
      -ms-transform: translate(-50%,-50%);
    }
    
    
    
    </style>
<section class="contact_bg-color">

<div class="container contact_bg-color">

    <div class="row">

        <div class="col-lg-12 text-center py-5">

            <div class="contact_head-color py-1">

            Draft

            </div>

        </div>

    </div>

</div>

</section>







<!-- Email modal starts -->



<!-- modal -->

<div class="container">
    <!-- modal -->
    <div class="modal" id="bulkemailmodal">
        <div class="modal-dialog">
            <div class="modal-content mx-auto">
                <!-- header -->
            
                <form  method="post" action="" enctype="multipart/form-data">
                    @csrf
                <div class="col-12 pt-3">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="modal-title sign_head">Send Email</h4>
                        </div>
                        <div class="col-4">
                            <p type="button" class="info" data-dismiss="modal"><img class="float-right modal_close-icon" src="{{asset('/')}}asset/images/close.png"></p>
                        </div>
                    </div>
                </div>
                <!-- body -->
                <div class="modal-body">
                    <div class="text-danger p-2">
                        <h6 id="user_id-error" style="color: red"></h6>
                    </div>
                    <div class="row">
                        <div id="overlay" onclick="off()">
                            <div id="text">Sending..</div></div>
                        {{-- <input type="hidden" value="{{$user->id}}" name="id" id="id"> --}}
                        <input type="hidden" name="user_id[]" id="user_id" value="">
                        <div class="col-md-10 pb-2">
                            <input type="text" placeholder="Subject" name="subject" id="subject" class="w-75 signup_input rounded px-3 py-2" value="{{ $draft_value->subject??"" }}">
                           
                            <div class="text-danger">
                                <strong id="subject-error" class="new_error_class"></strong>
                            </div>
                        </div>
                        <div class="col-md-12 pb-2">
                            <textarea class="form-control" placeholder="Message" id="description" name="description" aria-label="With textarea" row="10">{{ $draft_value->description??"" }}</textarea>
                            <span class="text-danger">
                                <strong id="description-error" class="new_error_class"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end px-3">
                    <button type="button" class="btn btn-secondary py-2 mr-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="form_Submit" class="signin_button px-4 py-2 rounded form_Submit1">Send</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class='alert alert-success newclass mt-2' id="myElem" style="display:none;">Email Sent Successfully</div>
</div>

<!-- modal end -->











<section class="section_search-box pt-4">

    <div class="container">

            {{-- <form class="col-lg form-inline serach-icon px-2" action="{{route('bulk.search')}}" method="post">

                @csrf

                <input type="hidden" name='collection_id' value="{{(isset($collection_id)? $collection_id:'')}}">

                <input class="form_control-1 rounded pl-3 pr-5" type="text" placeholder="Search" aria-label="Search" name="search">

                <button class="filter_search-button" type="submit"><img class="search_icon-input pr-0"

                        src="{{asset('/')}}asset/images/loupe.png"></button>

            </form> --}}


                    <form class="row px-2 mt-sm-5" action="{{route('candidate.draft.filter.page')}}" method="post">
                        <div class="col-lg form-inline serach-icon px-2">
                        @csrf
                        
               

                <input class="form_control-1 rounded pl-3 pr-5" type="text" placeholder="Search" aria-label="Search" name="search" value="{{(isset($search)?$search:'')}}">

                <button class="filter_search-button" type="submit"><img class="search_icon-input pr-0"

                        src="{{asset('/')}}asset/images/loupe.png"></button>
                    </div>
                        <div class="annual-salary col-lg position_lit px-2">

                            <div class="form-check pl-0 w-100">
                    <label class="mb-1 pt-0">Annual Salary (In Lakhs)<span class="text-danger px-1"> </span></label>

                    <div class="row">

                        <div class="col">

                            <input type="hidden" name='collection_id' value="{{(isset($collection_id)? $collection_id:'')}}" >

                            <input type="number" name="min_salary" placeholder="Min" min="0" max="100" onkeyup=imposeMinMax(this) value="{{(isset($min)?$min:'')}}"

                                class="w-100 signup_input rounded px-2">

                        </div>

                        <div class="col-1 text-center px-0 align-self-center">-</div>

                        <div class="col text-center">

                            <input type="number" name="max_salary" placeholder="Max" min="0" max="100" onkeyup=imposeMinMax(this) value="{{(isset($max)?$max:'')}}"

                                class="w-100 signup_input rounded px-2">

                        </div>

                    </div>

                </div>

            </div>

            <?php

            $locations = \App\User::all();

            $city=\App\User::orderBy('current_location')->get()->whereNotNull('current_location')->unique('current_location');
           


            ?>

           <div class="col-lg position_lit px-2 notice-period location_cus">
          
             <?php 

                  $locations = \App\Location::all();
                  $locationCategorys = \App\LocationCategory::all();


             ?>

            <select id="location-multi-select" multiple="multiple" name="location[]" class="form_control form_action rounded pl-3 pr-5  savelocation" >
                 
             @foreach($locationCategorys as $locationcategory)
             
            <optgroup label="{{ $locationcategory->category }}" value="" id="checks">
                @php

               $locations = \App\Location::where('category_id','=',$locationcategory->id)->get();

                @endphp
                @foreach($locations as $location)
                <option value="{{ $location->location}}" @if (isset($location1)) @if (in_array($location->id, $location1)) selected @endif @endif  label="{{ $location->location}}">{{ $location->location}}</option>
                @endforeach
               
            </optgroup>
            @endforeach
                
                
            </select>
        </div>

            <!-- <div class="col-lg position_lit px-2">

                <select id="multiple-select-notice" class="form_control form_action rounded pl-3 pr-5" multiple="multiple" name="notice_period[]">
                    <option value="1" @if (isset($notice_period)) @if (in_array(1, $notice_period)) selected @endif @endif>
                    
                        Immediately Available </option>
                    <option value="2" @if (isset($notice_period)) @if (in_array(2, $notice_period)) selected @endif @endif>Serving
                        Notice Period</option>
                    
                </select>

            </div> -->
             <div class="col-lg position_lit px-2 notice-period choose-notice">
                

                <select id="multiple-select-notice" class="form_control form_action rounded pl-3 pr-5" multiple="multiple" name="notice_period[]">
                    <option value="1" @if (isset($notice_period)) @if (in_array(1, $notice_period)) selected @endif @endif>
                    
                        Immediately Available </option>
                    <option value="2" @if (isset($notice_period)) @if (in_array(2, $notice_period)) selected @endif @endif>Serving
                        Notice Period</option>
                    
                </select>

            </div>

            <div class="col-lg-1 box px-2">

                <button type="submit" class="btn btn_submit w-100 text-light">Apply</button>

            </div>

            </form>

        </div>

</section>



<!-- second section -->



<section class="section_candidate-list py-4">

    <div class="container">

        <div class="row">

            <div class="col-lg-3 col-12 scrollbar candidate_filter-sub">

                <div class="candidate_filter-inner">

                    <div class="row d-block d-lg-none">

                        <div class="col-lg candidate_filter-header">

                            <div class="candidate_filter-body candidate_filter-hide py-3 px-2">

                                All Filters

                                <a id="filter_hide-button" class="close_icon-algin" href="javascript:void(0);">

                                    <img class="close_img-icon" src="{{asset('/')}}asset/images/cancel.png">

                                </a>

                            </div>

                        </div>

                    </div>

                    <div class="candidate_list-filter mb-4 mb-md-0 px-0">

                        <div class="accordion" id="accordionExample">

                            <div class="candidate_list mt-2 pt-3">

                                <div class="candidate_head mb-1 px-lg-1" id="headingOne">

                                    <button class="btn_candidate-box btn_candidate-arrow px-3 py-4" type="button"

                                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"

                                        aria-controls="collapseOne">

                                        Sub Filters

                                    </button>

                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"

                                    data-parent="#accordionExample">

                                    <div class="candidate_body px-lg-3 py-2">

                                    <div class="form-check pb-2 pl-0 w-100">

                                        <form action="{{route('candidate.draft.subfilter')}}" method="post">

                                            @csrf



                                            <input type="hidden" name='collection_id' value="{{(isset($collection_id)? $collection_id:'')}}">

                                        <label  class="mb-1 pt-0 sign_fontsize">Total Experience<span class="text-danger px-1"> </span></label>

                                            <div class="row py-1">

                                                <div class="col">

                                                    <input type="number" name="min_exp" placeholder="Min" min="0" max="50" value="{{(isset($min_exp)?$min_exp:'')}}"

                                                        onkeyup=imposeMinMax(this)

                                                        class="w-100 signup_input rounded pl-2 py-1">

                                                </div>

                                                <div class="col-1 text-center px-0 pt-1">-</div>

                                                <div class="col">

                                                    <input type="number" name="max_exp" placeholder="Max" min="0" max="50" value="{{(isset($max_exp)?$max_exp:'')}}"

                                                        onkeyup=imposeMinMax(this)

                                                        class="w-100 signup_input rounded pl-2 py-1">

                                                </div>

                                            </div>

                                        </div>

                                        <!-- <select class="form_control form_action rounded pl-3 pr-5 mb-3"

                                            style="height: 35px!important;">

                                            <option Selected Disabled>Multiple offers</option>

                                            <option>Yes</option>

                                            <option>No</option>

                                        </select>  -->
                                        <select class="form_control form_action rounded pl-3 pr-5 mb-3"
                                        name="filter_resume" style="height: 35px!important;" id="save_filter_resume">
                                        <!--<option Selected Disabled>Filter Resumes</option>-->
                                        <option value="" >Filter Resumes</option>
                                        <option value="1"  @if (isset($filter_resume)) @if ($filter_resume=='1' ) selected
                                                @endif @endif>Verified Resumes</option>
                                        <option value="2" @if (isset($filter_resume)) @if ($filter_resume=='2' ) selected
                                                @endif @endif >Un-Verified Resumes</option>
                                        <option value="3"@if (isset($filter_resume)) @if ($filter_resume=='3' ) selected
                                                @endif @endif >Xpress Job Seekers</option>
                                    </select>

                                        <select class="form_control form_action rounded pl-3 pr-5 mb-3" name="interview_avail"

                                        style="height: 35px!important;">

                                        <!--<option Selected Disabled>Interview Availability</option>-->
                                        <option value="" >Interview Availability</option>

                                        <option value="1" @if(isset($interview)) @if($interview=="1") selected @endif  @endif>Today</option>
                                            <option value="2" @if(isset($interview)) @if($interview=="2") selected @endif  @endif>Tomorrow</option>

                                    </select>
                                    
                                    
                                    <?php

                                                    $profile_education = (isset($profileEducation) ? $profileEducation->degree_title : null);



                                                        

                                                    $educationn = \App\Education::find($profile_education);

                                                    $educations = \App\Education::all();


                                                    $education = (isset($education) ? $education : null);

                                                    $education1 = \App\Education::where('id',$education)->first();

                                                    

                                       ?>

                                        <select class="form_control form_action rounded pl-3 pr-5 mb-3 dynamic " name="education" 
                                            style="height: 35px!important;">
                                              
                                            <option value="" selected >{{(isset($education1) ? $education1->education : 'Select Education')}}</option>
                                            
                                             <!--<option value="" >All</option>-->
                                            @foreach($educations as $edu)

                                                <option value="{{$edu->id}}"> {{$edu->education}}</option>

                                            @endforeach
                                        </select>


                                        <?php

                                                $organization = (isset($course) ? $course : null);

                                                $specilation = (isset($specilation) ? $specilation : null);



                                                $course=\App\Course::where('id',$organization)->first();

                                                $spec=\App\specs::where('id',$specilation)->first();



                                        ?>

                                        <select class="form_control form_action rounded pl-3 pr-5 mb-3 dynamiccourse" name="course" id="newcourse123"
                                            style="height: 35px!important;">
                                          
                                            <option value="" selected disabled>{{(isset($course) ? $course->course : 'Select Course')}}</option>
                                           
                                        </select>

                                        <select class="form_control form_action rounded pl-3 pr-5 mb-3 dynamicspecs" name="specilation" id="specs123"
                                            style="height: 35px!important;">
                                            <!-- <option selected disabled>Specilation</option> -->
                                            <option value="" selected disabled>{{(isset($spec) ? $spec->specs :'Select Specialization')}}</option>
                                           
                                        </select>
                                    
                                    
                                    
                                    
                                    <select class="form_control form_action rounded pl-3 pr-5 mb-3" name="gender"

                                        style="height: 35px!important;">

                                        <!--<option Selected Disabled>Gender</option>-->
                                        <option value="" >Gender</option>
                                        <option value="2" @if(isset($gender)) @if($gender=="2") selected @endif  @endif>Male</option>
                                        <option value="1" @if(isset($gender)) @if($gender=="1") selected @endif  @endif>Female</option>
                                        <option value="3" @if(isset($gender)) @if($gender=="3") selected @endif  @endif>Other</option>

                                    </select> <select class="form_control form_action rounded pl-3 pr-5 mb-3" name="job_type"

                                        style="height: 35px!important;">

                                        <!--<option Selected Disabled>Job Type</option>-->
                                        <option value="" >Job Type</option>
                                        <option value="Contract" @if(isset($job_type)) @if($job_type=="Contract") selected @endif  @endif>Contract</option>
                                        <option value="Permanent" @if(isset($job_type)) @if($job_type=="Permanent") selected @endif  @endif>Permanent</option>
                                        <option value="Freelance" @if(isset($job_type)) @if($job_type=="Freelance") selected @endif  @endif>Freelance</option>
                                        <option value="Any" @if(isset($job_type)) @if($job_type=="Any") selected @endif  @endif>Any</option>

                                    </select>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-12 box d-block px-0 px-lg-3 mb-1">

                            <button type="submit" class="btn btn_submit w-100 text-light">Apply</button>

                        </div>

                    </form>

                    </div>

                </div>

            </div>



            <!-- candidate listing left part -->

@if(isset($filter_users))

@include('company.draft-search')

@else 

@if(count($drafts) > 0)

<div class="col-lg-9 footer-alignss">
    {{-- {{$collections}} --}}
    <div class="col-lg-12 candidates_job-dashboard py-3 px-0 pt-0">
        <div class="container">
            <div class='alert alert-success newclass' id="myElem" style="display:none;">Email sent successfully</div>
        </div>
        <!-- <span class="candidate_title-head">Showing 46 <span class="candidate_text">Candidates</span></span> -->

        <div class="row pb-4">

                <?php 
                $company_id = Auth::guard('company')->user()->id ;      
        
                $company_value = \App\Company::where('id', $company_id)->first();
                $now = \Carbon\Carbon::now();
                $end_date = $company_value->package_end_date;
           
                //echo $end_date;
                ?>
                @if($end_date < $now )
            
                <div class="col-12 text-right">  
                    <button type="submit" class="py-2 signin_button send_mail_btn rounded px-3" data-toggle="modal" onclick="alert('Purchase a Plan')">Send Email</button>
                </div>

                @else      


                <div class="col-12 text-right">  
                    <button type="submit" class="py-2 signin_button send_mail_btn rounded px-3" data-toggle="modal" data-target="#bulkemailmodal" data-id="">Send Email</button>
                </div>


               @endif


               

        </div>
        <div class="row mx-0 select-all py-2">
            <div class="col-10">
                <?php 



                foreach ($drafts as  $users)
                {

                    # code...
                    $check_user = \App\User::where('id',$users->user_id);
                
                }

                ?>
                
                                            @if(isset($check_user))
                <div class="select_all-check d-flex align-items-center  d-inline">
                    <span><input type="checkbox" id="select_all" class="checkbox_size" maxlength="100" required><label for="select_all" class="pl-2 sign_head mb-0">Select all to sent Email</label></span>
                </div>
                @endif
            </div>
            <div class="col-2">
                <a id="filter_show-button" class="filter_icon-algin d-block d-lg-none" href="javascript:void(0);">
                    <img class="filter_img-icon" src="asset/images/Group-1.png">
                </a>
            </div>
        </div>
    </div>
   
  
      
  @foreach ($drafts as $user)
      
  
  <?php 

      $keyskill=\App\KeySkill::where('user_id',$user->user_id)->first();  
      
      $company=\App\ProfileCityJobsCity::where('user_id',$user->user_id)->first();
      
      $summary=\App\ProfileSummary::where('user_id',$user->user_id)->first();
      
      $data2=\App\ProfileSummary::where('user_id',$user->user_id)->first();
      $experience=(isset($data2) ? $data2->totalexp:'');
      $latestdesg=(isset($data2) ? $data2->latestdesg:'');
      $latestcom=(isset($data2) ? $data2->latestcom:'');
      
      $data3=\App\ProfileDetails::where('user_id',$user->user_id)->first();
      $ctc=(isset($data3) ? $data3->expect_ctc_lakhs:'');
      $ectc=(isset($data3) ? $data3->expect_ctc_lakhs3:'');

      $todayDate = \Carbon\Carbon::now()->format('Y-m-d');

      $notice_period=\App\ProfileNop::where('user_id',$user->user_id)->first();

      $noticed=(isset($notice_period) ? $notice_period->nop_days:'');
      // echo($noticed);
      if ($noticed == 1) 
                {

                

                        $days = 'Immediately available';
                }

                    elseif ($noticed == 2)
                    {

                        $period = $notice_period->last_working_day;

                        $datetime1 = strtotime($todayDate); // convert to timestamps

                        $datetime2 = strtotime($period); // convert to timestamps  


                        if ($datetime1 < $datetime2)
                        {

                             $days = (int)(($datetime2 - $datetime1)/86400);

                        } else {

                            $days = 'Immediately available';

                         }
                           

                    }
                    elseif($noticed == 3) {

                        $days = 'Buyable Notice Period';

                    }

                    else
                    {
                        $days = 'Not Under Notice Period';
                    }

      // echo $user;
      $com_id = Auth::guard('company')->user()->id ;

// echo $com_id;

      $emailed=\App\CollectionList::where('user_id',$user->user_id)->where('company_id',$com_id)->first();

      $user45= \App\User::where('id',$user->user_id)->first();
// echo $user45;


                    //    $company_id = \App\Company::where('id', $com_id)->first();

                    // echo $company_id;

  ?>
     @if ($keyskill)

            @php
            $date = $notice_period->last_working_day;
            $datetime1 = strtotime($todayDate); // convert to timestamps    
            $datetime2 = strtotime($date); // convert to timestamps  
            @endphp  

@php
                                            
$location_values_un =  unserialize($user45->prefered_city);

$count = count($location_values_un);

$two_value = array_slice($location_values_un,0,2);

$location_values =  implode(', ', $two_value);

@endphp
            
           


     <div class="boxing rounded px-4 " id="checkbox_list">
         <div class="row">
         <div class="col-12 pt-3">
             <ul class="list-inline mb-1">
                  <li class="list-inline-item checkbox">
                      <input type="checkbox" class="email_checkbox mail_send-box text-left" value="{{$user->user_id}}"> 
                  </li>
                  <li class="list-inline-item font_color">
                    <span  class="sign_head"><h4 class="mb-0">{{ $user45->first_name }}</h4></span>
                </li>
            </ul>
            <ul class="list-inline mb-1">
            <li class="list-inline-item">
                <a href="mailto:{{ $user45->email }}" class="contact_mail">
                    <i class="fa fa-envelope-o pr-2 text-primary" aria-hidden="true"></i>{{ $user45->email }}
                </a>
            </li>
            <li class="list-inline-item">
                <a href="tel: +91 {{ $user45->phone }}" class="contact_phone">
                    <i class="fa fa-phone text-primary pr-2" aria-hidden="true"></i>+91 {{ $user45->phone }}
                </a>
            </li>
            {{-- <li class="list-inline-item">
                <img class="pb-1" src="{{ asset('/') }}asset/images/location.svg"/>
                @if($count > 2)
                {{ $location_values??''}} <span class="candidate_view-more mb-0 " style="color: #197ff3;"
                >More +</span>
                @else
                {{ $location_values??''}}
                @endif
            </li> --}}
             </ul>
             <ul class="list-inline mb-1 job_view">
                <li class="list-inline-item font_color">{{$latestdesg}}</li>
                <li class="list-inline-item"><span>Latest Company:</span> {{$latestcom}} </li>
                <li class="list-inline-item"><span>Curr. Location:</span> {{ $user45->current_city }}</li>

                <li class="list-inline-item">

                    <span>Pref. Location:</span>

                 @if($count > 2)
                 {{ $location_values??''}} <span class="candidate_view-more mb-0 " style="color: #197ff3;"
                 >More +</span>
                 @else
                 {{ $location_values??''}}
                 @endif

                 </li>
                <li class="list-inline-item"><span>Exp:</span> {{$experience}}</li>
               
                <li class="list-inline-item"><span>CTC:</span> {{$ctc}} LPA</li>
                <li class="list-inline-item"><span>ECTC:</span> {{$ectc}} LPA</li>
                @if ($days != 0)
                    <li class="list-inline-item pr-5"><span>Notice Period:</span> {{$days}} @if ($datetime1 < $datetime2)days @endif</li>
                @else
                    <li class="list-inline-item pr-5"><span>Notice Period:</span> {{$days}}</li>
                @endif
             </ul>
             <?php 
             $keyskill=\App\KeySkill::where('user_id',$user->user_id)->paginate(5);

            
             
            //  $t4=(isset($skill) ? $skill->keyskill:'');
             //  echo $skill
             ?>
             <div class="section_2 pb-0">
                 <ul class="list-inline">
                   
                            @if(count($keyskill) < 5)

                                        @foreach($keyskill as $skill)

                                                <?php                    

                                                $job_skill=\App\JobSkill::where('id',$skill->keyskill)->first();

                                                ?>



                                                <li class="list-inline-item terms mb-1">{{(isset($job_skill->job_skill)? $job_skill->job_skill:'')}}</li>

                                        @endforeach

                            @else 

                                        @foreach($keyskill as $skill)

                                            <?php                    

                                            $job_skill=\App\JobSkill::where('id',$skill->keyskill)->first();

                                            ?>



                                            <li class="list-inline-item terms mb-1">{{(isset($job_skill->job_skill)? $job_skill->job_skill:'')}}</li>
                                            

                                        @endforeach
                                            <li class="list-inline-item terms mb-1"><a class="candidate_view-more" href="javascript:void(0);">More +</a></li>

                            @endif

                     
                 </ul>
             </div>
             @php
             $now = \Carbon\Carbon::now();
             @endphp
              @if($user45->package_end_date >  $now  )
              <p class="list-inline-item mb-0 express-job"  data-toggle="tooltip" data-placement="top" title='"Xpress Job Seeker" are looking for jobs on immediate basis.'>Xpress Job Seeker</p>
              @endif  
             {{-- <p class="list-inline-item mb-0 express-job"  data-toggle="tooltip" data-placement="top" title='"Xpress Job Seeker" are looking for jobs on immediate basis.'>Xpress Job Seeker</p> --}}
         </div>
         </div>
     </div>
     @endif
     {{-- {{$company}}<h1>company end</h1><br>
    {{$summary}}<h1>summary end</h1><br>
    {{$data3}}<h1>data3 end</h1><br> --}}
     @endforeach
     
     <div class="pagiWrap">
        <nav aria-label="Page navigation example">
            @if(isset($collections) && count($collections))
            {{ $collections->appends(request()->query())->links() }} @endif
        </nav>
    </div>

                                    </div>




@endif
                        @endif

                    </div> 

                </div>

            </div>

        </div>

</section>



@include('includes.footer')



@endsection



<script type="text/JavaScript">





        		

     

    </script>



@push('scripts')



<script>

var base_url = '{{URL::to('')}}';

$(document).ready(function(){

    

    $(".email_checkbox").click(function(){

      //  alert('test');

        var array = new Array();

        // var checked = $(".email_checkbox:checked").length;

        var checkbox = $(".email_checkbox:checked");

        if (checkbox) {

            var check = checkbox.map(function(){

                // check1= $(this).val();

                array.push($(this).val());

            });

        }

        $("#user_id").val(array);

        //console.log(array);

    });



    $("#select_all").click(function(event){

        var array1 = new Array();

        var checkbox = $(".email_checkbox");

        if (checkbox.is(':checked')) {

            var selectid = checkbox.map(function(){

                array1.push($(this).val());

            });

        } else {

           selectid=0; 

        }

        $("#user_id").val(array1);

    });

});
    $(document).ready(function(){
        $('#form_Submit').click(function(e){
            // document.getElementById("overlay").style.display = "block";

  document.getElementById('form_Submit').innerHTML = 'Sending..';

    document.getElementsByClassName('names')

            e.preventDefault();
            $( '#user_id-error' ).html( "" );
            $( '#subject-error' ).html( "" );
            $( '#description-error' ).html( "" );
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('email.sendbulkemail') }}",
                method: 'POST',
                data: {
                    user_id:$('#user_id').val(),
                    _token:"{{ csrf_token() }}",
                    subject: $('#subject').val(),
                    description: $('#description').val(),
                },
                success: function(result){
                    console.log(result);
                    if(result.success) {
                        $('.alert-danger').hide();
                        $('#bulkemailmodal').modal('hide');
                        $("#myElem").show();
                        $('#user_id').val('');
                        // $('#subject').val('');
                        // $('#description').val('');
                          document.getElementById('form_Submit').innerHTML = 'Send';
                        setTimeout(function() { $("#myElem").hide(); }, 5000);
                    }
                    if(result.errors)
                    {
                        document.getElementById('form_Submit').innerHTML = 'Send'
                       // console.log(result.errors);
                        if(result.errors.user_id){
                        $( '#user_id-error' ).html( result.errors.user_id[0] );
                        }
                        if(result.errors.subject){
                            $( '#subject-error' ).html( result.errors.subject[0] );
                        }
                        if(result.errors.description){
                            $( '#description-error' ).html( result.errors.description[0] );
                        }
                       
                    }if(result.errors1)
                    {
                        if(result.errors1){
                           alert('Please Upgrade Your Plan');
                        }
                    }
                }
            });
        });
    });










    $.ajaxSetup({

headers: {

    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

}

});

$('.dynamic').change(function(){

var degree_id = $(this).val(); 



//     alert(degree_id);



if(degree_id){



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

      $(".dynamiccourse").append('<option>Select course</option>');
      $("#newcourse123 option:first").attr("disabled", "disabled");

      $.each(res,function(key,value){

        $(".dynamiccourse").append('<option value="'+value.id+'">'+value.course+'</option>');

      });

    

    }else{

      $(".dynamiccourse").empty();

    }

    }

  });

}else{



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

     $(".dynamicspecs").append('<option>Select Specilization</option>');
    

$("#specs123 option:first").attr("disabled", "disabled");

     $.each(res,function(key,value){

       $(".dynamicspecs").append('<option value="'+value.id+'">'+value.specs+'</option>');

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


$('#multiple-select-notice').multiselect({
    includeSelectAllOption: false,
    nonSelectedText: 'Choose by Notice Periods',
    numberDisplayed: 2,
});

function getSelectedValues() {
    var selectedVal = $("#multiple-select-notice").val();
    for (var i = 0; i < selectedVal.length; i++) {
        function innerFunc(i) {
            setTimeout(function() {
                location.href = selectedVal[i];
            }, i * 2000);
        }
        innerFunc(i);
    }
}

function show() {

}

$('#multiple-select-notice-responsive').multiselect({
    includeSelectAllOption: false,
    nonSelectedText: 'Choose by Notice Periods',
});

function getSelectedValues() {
    var selectedVal = $("#multiple-select-notice-responsive").val();
    for (var i = 0; i < selectedVal.length; i++) {
        function innerFunc(i) {
            setTimeout(function() {
                location.href = selectedVal[i];
            }, i * 2000);
        }
        innerFunc(i);
    }
}



          // Location multiselect

          $(document).ready(function() {

    //multiselect Location
    $('#location-multi-select').multiselect({
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


</script>




@endpush



