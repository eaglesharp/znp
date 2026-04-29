
@php

    $datas =DB::table('company_data')->select('id','name')->distinct()->get();

    if(isset($locationresult)) {       

        $locationresultSelected = $locationresult;

        }

    $user=\App\User::where('id',$user->id)->first();

    $verified=(isset($user) ? $user->verified: '');

    $email_verified=$user->email_verified_at;    

    $phone_verified=$user->phone_verified;

    $now = \Carbon\Carbon::now();

    $interview_date_list = \App\Interview::where('user_id',$user->id)->where('date','>=',\Carbon\Carbon::now())->orderBy('date','asc')->get();

    $hand=(isset($user->physically_challenged) ? $user->physically_challenged : '');

    $gap = \App\ProfileGap::where('user_id',$user->id)->first();   

    $email=$user->email;

    $mobile=$user->phone;

    $education=\App\ProfileEducation::where('user_id',$user->id)->first();

    $data2=\App\ProfileSummary::where('user_id',$user->id)->first();

    $experience=(isset($data2) ? $data2->totalexp:'');

    $latestdesg=(isset($data2) ? $data2->latestdesg:'');

    $latestcom=(isset($data2) ? $data2->latestcom:'');
                    
    $interviews_data=\App\Interview::where('user_id',$user->id)->where('date', '>=', date('Y-m-d'))->orderBy('date','asc');

    $interviews = $interviews_data->get();

    $interview_count = $interviews_data->count();                                                    

    $data3=\App\ProfileDetails::where('user_id',$user->id)->first();

    $ctc=(isset($data3) ? $data3->expect_ctc_lakhs:'');

    $ectc=(isset($data3) ? $data3->expect_ctc_lakhs3:'');                                    

    $data4=\App\ProfileNop::where('user_id',$user->id)->first();

    $nop1 = ''; // Initialize default value

    if((isset($data4->nop_days)? $data4->nop_days : '') == '1')

    {                                    

    $nop1='Immediately Available';

    }elseif((isset($data4->nop_days) ? $data4->nop_days:'') == '2')

    {

        $nop1='Serving Notice Period';

    }elseif((isset($data4->nop_days) ? $data4->nop_days:'') == '3')

    {

        $nop1='Buyable Notice Period';

    }elseif((isset($data4->nop_days) ? $data4->nop_days :'') == '4')

    {

        $nop1='Not Under Notice Period';

    }

    $organization = (isset($education) ? $education->organization : null);

    $degree = \App\Degree::where('id',$organization)->first();

    $profile_education= (isset($user->getedu()->degree_title) ? $user->getedu()->degree_title : '') ;

    $educationn = \App\Education::find($profile_education);

    $interview = [];
    foreach ($interview_date_list as $melson){
        

        if(array_key_exists(date("M", strtotime($melson->date)), $interview)){

            $interview[date("M", strtotime($melson->date))] = $interview[date("M", strtotime($melson->date))].','.date("d", strtotime($melson->date));
        }else{           
            $interview[date("M", strtotime($melson->date))] = date("d", strtotime($melson->date));
        
        }
        
    }


@endphp


    <section class="section_canddashboard pt-4 pt-sm-5">

        <div class="container">          

            @if(session()->has('message12'))
            <div class="alert alert-success">
                {{ session()->get('message12') }}
            </div>
            @endif

            @if(session()->has('messageyes'))
              <input type="hidden" name="" id="yes" value="{{ session()->get('messageyes') }}">            
            @endif 

            <div class="row py-2">

                <div class="col-12 pb-4">
                    <div class="success d-flex justify-content-between align-items-center py-3" 
                        style="background-color: #3998de;color: #fff;padding: 10px 15px;border-radius: 10px;">

                        <div>
                            <h2 class="mb-0 pl-2 myprofile_font text-white">
                                @php
                                $now = \Carbon\Carbon::now();
                                $renew = \Carbon\Carbon::now()->subDay('5');
                                @endphp
                                @if($user->package_end_date > $now)
                                Congrats Xpress Jobseeker! Confirm your interview availability now! @if($user->package_end_date)
                            <p class="mb-0 text-white d-inline" style="font-size:13px"> ( Validity :
                                {{ \Carbon\Carbon::parse($user->package_end_date)->format('d-m-Y') }} )</p>
                            @endif
                                @elseif($user->package_end_date == $renew)
                                Xpress job Seeker is Going To Expired Soon
                                @else
                                Xpress Job Seeker
                                @endif


                            </h2> 
                            <p class="mb-0 pl-2 text-white pt-1" style="font-size:13px">
                                Xpress Jobseekers can declare their <a href="#Interview" class="videoi">VIDEO INTERVIEW</a> availability for recruiters. <a href="#Interview" class="videoi" style="
                                    font-size: 18px;
                                    font-weight: 600;
                                "></a>
                            </p>
                        </div>
                        <a href="#Interview"
                        class="btn btn-plan buy_now " >ADD NOW</a>
                            {{-- @if($user->package_end_date > $now)
                            <a href="{{ route('payment.page') }}"
                            class="btn btn-plan buy_now disabled"  data-amount="499" data-id="2">Rs 499/Per month </a>
                            @else
                            <a href="{{ route('payment.page') }}" class="btn btn-plan buy_now" data-amount="499"
                                data-id="2">Rs 499/Per month</a>
                            @endif --}}
                    </div>
                    <!-- <div class="success d-flex justify-content-between align-items-center" style="background-color: #3998de;color: #fff;padding: 10px 15px;border-radius: 30px;">
                        <div>
                            <h5 class="mb-0 text-white pl-2">
                                
                                Upgrade a Plan 
                            </h5> 
                            
                        </div>
                        <a href="http://localhost/znp/pricing" class="btn btn-plan">Buy now</a>
                    </div> -->

                </div>           
           
                {{-- <div class="col-12 pb-4">
                    <div class="success d-flex justify-content-between align-items-center py-3"
                        style="background-color: #0642a9;color: #fff;padding: 10px 15px;border-radius: 10px;">

                        <div>
                            <h2 class="mb-0 pl-2 myprofile_font text-white d-inline">
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $renew = \Carbon\Carbon::now()->subDay('5');
                                @endphp
                                @if($user->layoff_package_end_date > $now)
                                    Your CV has been featured as a "Layoff CV"
                                    
                                @elseif($user->layoff_package_end_date == $renew)
                                    Layoff CV is Going To Expired Soon
                                @else
                                Laid Off @ work? Get your CV featured as a "Layoff CV" and get found by recruiters!
                                @endif


                            </h2> @if($user->layoff_package_end_date)
                                <p class="mb-0 text-white d-inline" style="font-size:13px"> ( Validity :
                                    {{ \Carbon\Carbon::parse($user->layoff_package_end_date)->format('d-m-Y') }} )</p>
                            @endif
                            <p class="mb-0 pl-2 text-white pt-1" style="font-size:13px">
                        You stand better chance at being chosen by Recruiters!
                            </p>
                        </div>
                        @if($user->layoff_package_end_date > $now)
                            <a href="{{ route('layoff-payment.page') }}"
                            class="btn btn-plan buy_now  disabled" data-amount="499" data-id="3">Rs 499/3 Months</a>
                        @else
                            <a href="{{ route('layoff-payment.page') }}" class="btn btn-plan buy_now" data-amount="499"
                            data-id="3">Rs 499/Per month</a>
                        @endif
                    </div>
                
                </div> --}}

                <div class="col-md-12 ">



                    <div class="dash_box-right_profile text-center text-md-left px-2 px-sm-5 py-4 ">

                        @if($verified === 1)

                            <div class="verified-tag">
                                <p> Verified</p>   
                            </div>

                        @endif


                        <div class="row center_profile ">

                            <div class="col-md-2 pr-xl-0">

                                <div class="avatar-upload">

                                    <div class="avatar-edit">

                                        @if(Auth::user()->image)

                                        <form method="post" enctype="multipart/form-data" id="formvalue">

                                            @csrf

                                            <input type='file' id="imageUpload" name="image" class="changeimage"
                                                accept=".png, .jpg, .jpeg" />

                                            <label for="imageUpload"></label>

                                            @if($errors->has('image'))

                                            <span class="text-danger">{{$errors->first('image')}}</span>

                                            @endif

                                        </form>

                                        @else
                                        <form method="post" enctype="multipart/form-data" id="formvalue">

                                            @csrf

                                            <input type='file' id="imageUpload" name="image" class="changeimage"
                                                accept=".png, .jpg, .jpeg" />

                                            <label for="imageUpload"></label>

                                            @if($errors->has('image'))

                                            <span class="text-danger">{{$errors->first('image')}}</span>

                                            @endif

                                        </form>

                                        @endif





                                    </div>

                                    <div class="avatar-preview">

                                        <div id="imagePreview">

                                            <a href="javascript:void(0);">@if(Auth::user()->image)



                                                <img src="{{ asset('user_images/'.Auth::user()->image) }}" alt="" title=""
                                                    style="width: 100px;height: 100px !important;" class="img-fluid  canddashboard-userpic"><span>
                                                    @else <img src="asset/images/dashboardpic.png"
                                                        class="img-fluid  canddashboard-userpic">@endif</a>

                                        </div>

                                    </div>

                                </div>



                            </div>

                            <div class="col-md-10 pt-3 pt-md-0 pl-lg-0">

                            

                                <div class="d-sm-inline">

                                    <h2 class="text-dark dash_box-texthead mb-2">{{$user->first_name}}</h2>

                                </div>

                                <div class="d-sm-inline"><a href="mailto:{{ $user->email }}" class="text-dark  pr-sm-3 "><i
                                            class="fa fa-envelope pr-2 text-dark"
                                            aria-hidden="true"></i>{{$user->email}}</a>

                                </div>



                                @if(isset($user->phone))

                                <div class="d-sm-inline"><a href="tel:{{ $user->phone }}" class="text-dark  pr-sm-3"><i
                                            class="fa fa-phone text-dark pr-2" aria-hidden="true"></i>{{$user->phone}}</a>
                                </div>

                                @endif



                                @if(isset($user->current_city))

                                <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i
                                            class="fa fa-map-marker text-dark pr-2"
                                            aria-hidden="true"></i>{{$user->current_city}}</a>

                                </div>

                                @endif

                                @if(isset($user->industry))

                                @if((isset($user->industry)) == 1)

                                <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i class="fa fa-user text-dark pr-2"
                                            aria-hidden="true"></i>IT</a></div>

                                @else

                                <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i class="fa fa-user text-dark pr-2"
                                            aria-hidden="true"></i>NON IT</a></div>

                                @endif
                                @endif




                                @if(isset($education->organization))

                                <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i
                                            class="fa fa-university text-dark pr-2"
                                            aria-hidden="true"></i>{{$degree->educations}}</a></div>

                                @endif

                                @if(isset($data2->latestcom))

                                <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i
                                            class="fa fa-building text-dark pr-2" aria-hidden="true"></i>{{$latestcom}}</a>

                                </div>

                                @endif

                                @if(isset($data2->latestdesg))

                                <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i
                                            class="fa fa-briefcase text-dark pr-2"
                                            aria-hidden="true"></i>{{$latestdesg}}</a></div>

                                @endif

                                @if(isset($data3->ctc))

                                <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i class="fa fa-money text-dark pr-2"
                                            aria-hidden="true"></i>Current CTC : {{$ctc}}</a></div>

                                @endif

                                @if(isset($data3->ectc))

                                <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i class="fa fa-money text-dark pr-2"
                                            aria-hidden="true"></i>Expected CTC : {{$ectc}}</a></div>

                                @endif

                                @if(isset($data2->experience))

                                <div class="d-md-inline"><span class="text-dark"><i class="fa fa-calendar text-dark pr-2"
                                            aria-hidden="true"></i>{{$experience}}</span></div>

                                @endif

                                @if(isset($educationn))

                                <div class="text-dark py-1"> <span class="text-dark font-weight-bold">Highest Education :

                                    </span>{{$educationn->education}} </div>

                                @endif



                                @if(isset($data4->nop_days))

                                <div class="text-dark"><span class="text-dark notice_dash">Notice Period : </span> {{$nop1}}

                                </div>

                                @endif
                            

                                @if(isset($interview) && count($interview) > 0) 
                                <div class="text-dark"><span class="text-dark notice_dash">Video Interview Availability : </span>
                                
                                @foreach ($interview as $key => $item)
                                    {{ $key }} {{ $item }}
                                        
                                    @endforeach
                                
                                </div>
                                @endif
                                



                            </div>                    

                        </div>


                        <div class="row pt-4">

                            <div class="col-lg-12">

                                <label class="text-dark">Profile Completeness (Note:Your profile completeness should reach more
                                    than 85% to display your resume on the employer search list)</label>
                                    <div class="container">
                                        <div class="modal" id="myModal">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content modal_content_custom_width mx-auto p-3">
                                                    <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"
                                                            src="{{ asset('/') }}asset/images/cancel.png"></p>
                                                    <div class="modal-body p-0">
                                                        <div class="collection_pic-box text-center mt-2 mt-md-0">
                                                            <div class="collection_text px-lg-3 py-0">
                                                                <h4 class="modal-title sign_head">Please update your profile to rank higher in recruiter searches.</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!--  <div class="d-flex justify-content-center px-3 border-0 pb-3">
                                                        <a href="{{ route('company.register.page') }}" class="btn  btn_style btn_style_height">Sign Up</a>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                </div>




                                <div class="progress-container" data-percentage='30' value="" id="profile_complete">
                                    <div class="progress"></div>
                                    <div class="percentage">0%</div>
                                </div>

                                <div class="row mt-3">

                                    <div class="col-lg-4">

                                        <div class="counter text-center">

                                            <i class="fa fa-eye fa-2x"></i>

                                            <h2 class="timer count-title count-number mt-1 mb-0">{{$user->no_profile_views}}
                                            </h2>

                                            <p class="count-text mb-0">Number of Views <i class="fa fa-info"
                                                    data-toggle="tooltip" title="Number of employers viewed your profile"></i>
                                            </p>

                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="counter text-center">

                                            <i class="fa fa-download fa-2x"></i>

                                            <h2 class="timer count-title count-number mt-1 mb-0">{{$user->no_of_downloads}}</h2>

                                            <p class="count-text mb-0">Number of Downloads <i class="fa fa-info"
                                                    data-toggle="tooltip"
                                                    title="Number of employers downloads your profile"></i>

                                            </p>

                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="counter text-center">

                                            <i class="fa fa-envelope fa-2x"></i>

                                            <h2 class="timer count-title count-number mt-1 mb-0">{{$user->no_of_emails}}</h2>

                                            <p class="count-text mb-0">Number of Emails <i class="fa fa-info"
                                                    data-toggle="tooltip" title="Number of employers emailed your profile"></i>
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row py-5">

                        <div class="col-md-4 col-lg-3  col-12">

                            <div class="sticky_profile">

                                <div class="myScrollspys mb-3 box py-3 text-center rounded profile_myprof">

                                    <h1 class="myprofile_font mb-0">My Profile</h1>

                                </div>

                                <div class="">

                                    <nav class="myScrollspys box py-3 px-lg-1 px-xl-3 rounded profile_nav pro_box-stick stick_top"
                                        id="myScrollspy">

                                        <ul class="nav-pills mb-0 ul-candiatate scroll_profile">

                                            <li class="nav-item sticky_font ">

                                                <a class="nav-link active" href="#account_info">Account Information</a>

                                            </li>

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#basic_info">Personal Details</a>

                                            </li>

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#keyskills">Key Skills</a>

                                            </li>

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#Noticeperiod_profile">Notice Period Status</a>

                                            </li>

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#competing_offers">Competing Offers</a>

                                            </li>

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#compensation">Compensation</a>

                                            </li>

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#Interview">Interview Availability</a>

                                            </li>

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#profile_achievements">Profile Summary</a>

                                            </li>

                                            @if($user->industry == 1)

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#it_skills">IT Skills</a>

                                            </li>


                                            <li class="it-project-process nav-item sticky_font">

                                                <a class="nav-link" href="#it_projects">IT Projects</a>

                                            </li>
                                            @endif

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#Education">Education</a>

                                            </li>

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#Accomplishment">Accomplishment</a>

                                            </li>

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#Technical_Certifications">Other Certifications</a>

                                            </li>

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#gaps">Employment Gaps</a>

                                            </li>

                                            <li class="nav-item sticky_font">

                                                <a class="nav-link" href="#employment">Employment Preferences</a>

                                            </li>

                                        </ul>

                                    </nav>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-8 col-lg-9 col-12">                    

                            <!---- Account Information Section Start -->
                                <div id="account_info" class="col-md-12 col-12 pt-3 pt-sm-0 profile_head rounded">

                                    <div class="myprofile_font pb-3">Account Information</div>

                                </div>
                                <div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">



                                    <div class="row">

                                        <div class="col-lg-6">


                                            <label class="mb-2  sign_fontsize">Email<span class="text-danger px-1">* </span></label>

                                    

                                            @if($user->email_verified == '1')

                                                {!! Form::text('email', $email, array('class'=>'w-100 signup_input pl-3 pr-5 py-2
                                                rounded', 'id'=>'email', 'placeholder'=>'Enter your email','disabled')) !!}

                                                <p href="" class="email_verify" value="" disabled>Verified</p>                                     

                                            @else

                                                {!! Form::text('email', $email, array('class'=>'w-100 signup_input pl-3 pr-5 py-2
                                                rounded', 'id'=>'email', 'placeholder'=>'Enter your email')) !!}

                                                <a href="{{url('verify-emails',$user->id)}}" class="email_verify "
                                                    value="{{$user->email}}">Verify</a>


                                            @endif



                                        </div>

                                        <div class="col-lg-6">

                                            <label class="mb-2 pt-3 pt-lg-0 sign_fontsize">Phone Number<span
                                                    class="text-danger px-1">* </span></label>

                                    

                                            @if($phone_verified == '1')

                                            <form action="{{url('phone-verifys',$user->id)}}" method="post" id="form1">

                                                @csrf

                                                <input type="tel" class="w-100 signup_input px-3 py-2 rounded" id="phone"
                                                    placeholder="Enter your phone number" maxlength="15" minlength="7" name="phone"
                                                    value="" disabled>





                                                <p href="" class="email_verify-1" value="" disabled>Verified</p>

                                            </form>



                                            @else


                                            <input type="tel" class="w-100 signup_input px-3 py-2 rounded" id="phone" disabled
                                                placeholder="Enter your phone number" maxlength="15" minlength="7" name="phone"
                                                value="{{old('phone',$user->phone)}}" >


                                            <!--<a href="{{url('phone-verifys',$user->id)}}" class="email_verify "-->
                                            <!--    value="{{$user->phone}}">Verify</a>-->


                                    



                                            @endif

                                        </div>

                                    </div>



                                </div>
                            <!---- Account Information Section End -->    
                        
                            <!---- Personal Details Section Start -->
                                <div id="basic_info" class="col-lg-6 px-0  pb-3 pt-4 mt-0 mt-md-3 profile_head  rounded">

                                    <div class="myprofile_font">Personal Details<i class="fa fa-pencil pl-2" id="edit11"
                                            aria-hidden="true"></i></div>
                                </div>

                                @if(session()->has('success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif                       

                                <div class="col-12 box_profile px-sm-5 py-4 py-sm-5 rounded">

                                {!! Form::model($user, array('method' => 'put', 'route' => array('my.profile'), 'class' =>
                                    'form', 'files'=>true)) !!}

                                    <div class="row">

                                        <div class="col-lg-4">

                                            <label class="mb-2 pt-lg-0   sign_fontsize">First Name<span class="text-danger px-1">*

                                                </span></label>

                                        

                                            {!! Form::text('first_name', null, array('class'=>'w-100 signup_input px-3 py-2 rounded
                                            edit', 'id'=>'first_name', 'placeholder'=>'Enter your First name') ) !!}



                                            @if($errors->has('first_name'))

                                            <span class="error new_error_class">{{$errors->first('first_name')}}</span>

                                            @endif

                                        </div>

                                        <div class="col-lg-4">

                                            <label class="mb-2  pt-3 pt-lg-0  sign_fontsize">Middle Name </label>


                                            {!! Form::text('middle_name', null, array('class'=>'w-100 signup_input px-3 py-2 rounded
                                            edit ', 'id'=>'middle_name', 'placeholder'=>'Enter your Middle name')) !!}

                                        </div>

                                        <div class="col-lg-4">

                                            <label class="mb-2  pt-3 pt-lg-0  sign_fontsize">Last Name</label>


                                            {!! Form::text('last_name', null, array('class'=>'w-100 signup_input px-3 py-2 rounded
                                            edit', 'id'=>'last_name', 'placeholder'=>'Enter your Last name')) !!}

                                            @if($errors->has('last_name'))

                                            <span class="error" style="color:#a94442">{{$errors->first('last_name')}}</span>

                                            @endif

                                        </div>

                                        <div class="col-lg-6">

                                            <label class="mb-2 pt-3 sign_fontsize">Industry<span class="text-danger px-1">*

                                                </span></label>

                                    
                                            {!! Form::select('industry', [''=>'Select Industry']+MiscHelper::getindustry(), null,
                                            array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize nonselect1
                                            signup_input rounded edit', 'id'=>'industry')) !!}

                                            @if($errors->has('industry'))

                                            <span class="error new_error_class">{{$errors->first('industry')}}</span>

                                            @endif











                                        </div>                         

                                        <div class=" col-lg-6" id="hideit1" @if(isset($user->industry))@if($user->industry
                                            !="2")style="display:none" @endif @endif>

                                            <label class="mb-2 pt-3 sign_fontsize">Type of process<span class="text-danger px-1">*

                                                </span></label>

                                            {{-- <select

                                                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded"

                                                    requried name="process">

                                                    <option selected disabled>Select Process</option>

                                                    <option>Voice Process</option>

                                                    <option>Non Voice Process</option>

                                                    <option>Semi Voice Process</option>

                                                </select> --}}

                                            {!! Form::select('process', [''=>'Select Process']+MiscHelper::getprocess(), null,
                                            array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize signup_input
                                            rounded edit' , 'id'=>'process')) !!}



                                            @if($errors->has('process'))

                                            <span class="error new_error_class">{{$errors->first('process')}}</span>

                                            @endif



                                        </div>

                                        <div class="col-lg-6 gender-canditate">

                                            <label class="mb-2 pt-3 sign_fontsize">Gender<span class="text-danger px-1">*

                                                </span></label>

                                            {{-- <select

                                                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded"

                                                    requried name="gender_id">

                                                    <option selected disabled>Select Gender</option>

                                                    <option>Male</option>

                                                    <option>Female</option>

                                                    <option>Other</option>

                                                </select> --}}

                                            {!! Form::select('gender_id', [''=>__('Select Gender')]+$genders, null,
                                            array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize nonselect2
                                            signup_input rounded edit', 'id'=>'gender_id')) !!}





                                            @if($errors->has('gender_id'))

                                            <span class="error new_error_class">{{$errors->first('gender_id')}}</span>

                                            @endif

                                        </div>

                                        <div class="col-lg-6">

                                            <label class="mb-2 pt-3 sign_fontsize">Date Of Birth<span
                                                    class="text-danger px-1">*</span></label>

                                            <input type="text"
                                                class="w-100 signup_input rounded px-3 py-2 sign_fontsize datepickerr edit" requried
                                                name="date_of_birth"
                                                value="{{ old('date_of_birth', (isset($user->date_of_birth))? Carbon\Carbon::parse($user->date_of_birth)->format('d-m-Y'):'') }}"
                                                placeholder="Date of Birth">

                                            {{-- {!! Form::text('date_of_birth', null, array('class'=>'w-100 signup_input rounded px-3 py-2 sign_fontsize datepickerr ', 'id'=>'date_of_birth', 'placeholder'=>'Date of Birth', 'autocomplete'=>'off')) !!} --}}

                                            @if($errors->has('date_of_birth'))

                                            <span class="error new_error_class">{{$errors->first('date_of_birth')}}</span>

                                            @endif



                                        </div>

                                        <div class="col-lg-6">

                                            <label class="mb-2 pt-3 sign_fontsize">Marital Status<span
                                                    class="text-danger px-1">*</span></label>

                                            {{-- <select

                                                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded"

                                                    requried name="marital_status_id">

                                                    <option>Marital Status</option>

                                                    <option>Married</option>

                                                    <option>Single</option>

                                                </select> --}}



                                            {!! Form::select('marital_status_id', [''=>__('Select Marital
                                            Status')]+$maritalStatuses, null, array('class'=>' edit w-100 pl-3 pr-4 py-2
                                            form_control-arrow sign_fontsize signup_input rounded nonselect3',
                                            'id'=>'marital_status_id')) !!}

                                            @if($errors->has('marital_status_id'))

                                            <span class="error new_error_class">{{$errors->first('marital_status_id')}}</span>

                                            @endif



                                        </div>

                                        <div class="col-lg-6">

                                            <label class="mb-2 pt-3 sign_fontsize">Current City<span class="text-danger px-1">*

                                                </span></label>

                                            <!-- <input type="text" placeholder="Enter your city" requried name="" class="w-100 signup_input rounded px-3 py-2"> -->

                                            {{-- <input type="text" placeholder="Current city" requried name="current_city"

                                                    class="w-100 signup_input rounded px-3 py-2"> --}}



                                            {!! Form::text('current_city', null, array('class'=>'w-100 signup_input rounded px-3
                                            py-2 edit priceinfo', 'id'=>'autocomplete10', 'placeholder'=>'Current City')) !!}

                                            @if($errors->has('current_city'))

                                            <span class="error new_error_class">{{$errors->first('current_city')}}</span>

                                            @endif

                                        </div>

                                        <div class="col-lg-6 notice-period location_cus candidate select-location"  id="my-select-locationcontainer">

                                            <label class="mb-2 pt-3 sign_fontsize">Preferred city<span class="text-danger px-1">*

                                                </span></label>


                                            <select class="form-control select-box" name="prefered_city[]" multiple="multiple" placeholder="Please enter location" id="locationFilter41">                    
                                            </select>
                            

                                            @if($errors->has('prefered_city'))

                                            <span class="error new_error_class">{{$errors->first('prefered_city')}}</span>

                                            @endif

                                        </div>

                                        <div class="col-lg-6">

                                            <label class="mb-2 pt-3 sign_fontsize">Current Location in city<span
                                                    class="text-danger px-1">* </span></label>

                                        
                                            <input id="autocomplete1" name="current_location"
                                                placeholder="Enter Current Location in city" type="text"
                                                class="w-100 signup_input rounded px-3 py-2 edit"
                                                value="{{(isset($user->current_location) ? $user->current_location:'')}}"
                                                autocomplete="off">


                                            @if($errors->has('current_location'))

                                            <span class="error new_error_class">{{$errors->first('current_location')}}</span>

                                            @endif



                                            {{-- <input class=" form-control field" id="locality" name="current_location" style="display:none" value="{{(isset($user->current_location) ? $user->current_location:'')}}">
                                            --}}






                                        </div>

                                        <div id="locationField" style="display:none">


                                            <table id="address">
                                                <tr>
                                                    <td class="label">Street address</td>
                                                    <td class="slimField">
                                                        <input class="field" id="street_number"></input>
                                                    </td>
                                                    <td class="wideField" colspan="2">
                                                        <input class="field" id="route"></input>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">City</td>
                                                    <td class="wideField" colspan="3">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">State</td>
                                                    <td class="slimField">
                                                        <input class="field" id="administrative_area_level_1"></input>
                                                    </td>
                                                    <td class="label">Zip code</td>
                                                    <td class="wideField">
                                                        <input class="field" id="postal_code"></input>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">Country</td>
                                                    <td class="wideField" colspan="3">
                                                        <input class="field" id="country"></input>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">Lat</td>
                                                    <td class="slimField">
                                                        <input type="text" class="field" id="latitude"></input>
                                                    </td>
                                                    <td class="label">Long</td>
                                                    <td class="wideField">
                                                        <input type="text" class="field" id="longitude"></input>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-lg-6">

                                            <label class="mb-2 pt-3 sign_fontsize">Preferred Location in city<span
                                                    class="text-danger px-1">* </span></label>

                                            {{-- <input type="text" placeholder="Enter Preferred Location in city" requried name="prefered_location"

                                                    class="w-100 signup_input rounded px-3 py-2"> --}}

                                            {!! Form::text('prefered_location', null, array('class'=>'w-100 signup_input rounded
                                            px-3 py-2 edit', 'id'=>'autocomplete12', 'placeholder'=>'Enter Preferred Location in
                                            city')) !!}

                                            @if($errors->has('prefered_location'))

                                            <span class="error new_error_class">{{$errors->first('prefered_location')}}</span>

                                            @endif

                                        </div>

                                        <div class="col-lg-6">

                                            <label class="mb-2 pt-3 sign_fontsize">Physically Challenged<span
                                                    class="text-danger px-1">*</span></label>


                                            {!!
                                            Form::select('physically_challenged',[''=>'Select']+MiscHelper::gethand(),null,array('id'=>'physically_challenged','class'=>'
                                            edit w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize signup_input rounded
                                            nonselect4')) !!}

                                            @if($errors->has('physically_challenged'))

                                            <span class="error new_error_class">{{$errors->first('physically_challenged')}}</span>

                                            @endif

                                        </div>

                                        <div class="col-lg-6">

                                            <label class="mb-2 pt-3 sign_fontsize">Upload Resume<span class="text-danger px-1">*

                                                </span></label><br>



                                            <input type="file" class="w-100 edit" id="myFile" name="resume">



                                            <p class="p-upload mb-0 mt-1">Upload resume will accept only .pdf and .docx, Size should
                                                be

                                                lesser than 2 MB.</p>

                                            @if($errors->has('resume'))

                                            <span class="error new_error_class">{{$errors->first('resume')}}</span>

                                            @endif



                                            @if(isset($user))

                                            @if((isset($user->showcvs()->resume) ? $user->showcvs()->resume :''))



                                            <div class="form-group edit" style="border 1px solid"><br>

                                                <?php 

                                                    $file=(isset($user->showcvs()->resume) ? $user->showcvs()->resume :'');

                                                    ?>

                                                <button target="_blank"
                                                    class="btn edit">{{ImgUploader::print_doc("cvs/$file", $file, $file)}} </button>
                                                <a href="{{url('delete-resume',$user->id)}}" class="btn btn-danger">Delete</a>



                                            </div>

                                            @endif

                                            @endif

                                        </div>

                                        <div class="col-lg-12">

                                            <label class="mb-2 pt-3 sign_fontsize">Address<span class="text-danger px-1">*

                                                </span></label>

                                            <textarea type="text" class="w-100 signup_input rounded px-3 py-2 edit"
                                                placeholder="Address" name="street_address" maxlenght="1000"
                                                spellcheck="false">{{ old('previous_project_details', (isset($user->street_address))? $user->street_address:'') }}</textarea>



                                            @if($errors->has('street_address'))

                                            <span class="error new_error_class">{{$errors->first('street_address')}}</span>

                                            @endif

                                        </div>

                                        <div class="col-lg-12  mt-1 text-center">

                                            <input class="signin_button rounded px-3 py-1 edit btnsub new-cursor" type="submit">



                                        </div>
                                    
                                    </div>

                                </form>

                                </div>
                            <!---- Personal Details Section End -->

                            <!---- Language Section Start -->

                              @include('user.forms.language.languages')

                            <!-- Language Section Ends -->


                            <!-- Key Skills  -->

                             @include('user.forms.skill.skills')

                            <!-- Key Skills modals ENDS -->

                            <!-- Notice Period Status -->

                             @include('user.forms.nop')

                            <!-- Offers In Hand -->
                            
                            <!---- Offers In Hand Start -->

                             @include('user.forms.offers_in_hand')

                            <!---- Offers In Hand End -->
                        
                            <!---- Compensation Start -->

                             @include('user.forms.compensation')

                            <!---- Compensation End -->

                            <!---- Interview Availability Start -->

                             @include('user.forms.interview.interview')

                            <!---- Interview Availability End -->

                            <!-- Professional Summary Start-->

                             @include('user.inc.summary')

                            <!---- Interview Availability End-->

                            <!---- Current Company and Previous Company Start -->

                             @include('user.forms.company.company')

                            <!---- Current Company and Previous Company End -->

                            <!-- Accomplishment Start -->

                               @include('user.forms.accomplishment.index')

                            <!-- Accomplishment End -->

                            <!-- IT Skills & Projects Start-->
                                @if($user->industry == 1)

                                
                                    <!-- IT Projects Start--> 
                                    
                                     @include('user.forms.skill.itskills')                                    

                                    <!-- IT Skills End -->



                                    <!-- IT Projects Start-->

                                    @include('user.forms.project.projects')

                                    <!-- IT Projects End-->

                                  

                                @endif
                            <!-- IT Skills & Projects Ends-->

                            <!-- Education Start-->

                             @include('user.forms.education.education')

                            <!-- Education modal ENDS -->

                       

                            <!-- Other Certifications -->

                             @include('user.forms.certificates.certificate')

                            <!-- certification modal end -->

                            <!-- Employment Gaps Start-->
                                @if(isset($gap->gap_from_month))                        

                                    <div id="gaps" class="col-lg-6 pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">

                                        <div class="myprofile_font">Employment Gaps <i class="fa fa-pencil pl-2" aria-hidden="true"></i>
                                        </div>

                                    </div>

                                    <div class="box_profile px-4 px-sm-5 py-4 py-sm-4 rounded">

                                        {{-- <a href="#" title="Add Employment Gaps" class="project_add" data-toggle="modal"

                                            data-target="#employment_modal">ADD</a> --}}

                                        <div class="col-">

                                            <div class="">

                                                <div class="success" id="success_msg29"></div>

                                                <h6 class="my-0 sign_head pt-3">
                                                    {{(isset($gap->gap_from_month) ? $gap->gap_from_month:'')}} /
                                                    {{(isset($gap->gap_to_month)?$gap->gap_to_month:'')}}<a
                                                        href="javascript:void(0)"></a></h6>

                                                <p class="my-0 sign_fontsize"><span>Employment Gaps From :
                                                    </span>{{(isset($gap->gap_from_month) ? $gap->gap_from_month:'')}}</span></p>

                                                <p class="my-0 sign_fontsize"><span>Employment Gaps To :
                                                    </span>{{(isset($gap->gap_to_month)?$gap->gap_to_month:'')}}</span></p>
                                                <div class="success mt-3" id="success_msg22"></div>
                                                <label class="mb-2 pt-3 sign_fontsize">Reason<span class="text-danger px-1">*
                                                    </span></label>
                                                @if($errors->has('reason'))

                                                <span class="error" style="color:#a94442">{{$errors->first('reason')}}</span>

                                                @endif

                                                <form action="{{route('store.front.gap',$user->id)}}" method="post" name="frontgap"
                                                    id="forntgap">

                                                    @csrf

                                                    <div class="col-lg-12">
                                                        <textarea class="w-100 signup_input rounded px-3 py-2"
                                                            name="reason">{{(isset($gap)? $gap->reason:'')}}</textarea>
                                                    </div>

                                                    <span class="help-block reason-error"></span>

                                                    <div class="col-lg-12 pt-4 mt-3 text-center">
                                                        <input class="signin_button rounded px-3 py-1 edit2 btnsub2 new-cursor"
                                                            value="Update" type="button" onclick="submitfrontprofilegapform();">
                                                    </div>
                                                </form>

                                            </div>

                                        </div>


                                    </div>

                                @endif

                            <!-- Employment Gaps End-->

                            <!-- Employment Preferences Start-->

                             @include('user.forms.details')

                            <!-- Employment Preferences End-->


                        </div>

                    </div>

               </div>
            </div>
       
        </div>                  

    </section>





    @push('styles')

    <style type="text/css">
    .datepicker>div {

        display: block;

    }
    </style>

    @endpush

    @push('scripts')


    <script
        src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCejQVcKXrBxZGFj0EQpSHkLgOk_Lp6CRI&region=IN">
    </script>





    <script>
    $(document).ready(function() {

        const progressContainer = document.querySelector('.progress-container');

        // initial call
        setPercentage();



        function setPercentage() {
            const percentage = progressContainer.getAttribute('data-percentage') + '%';

            const progressEl = progressContainer.querySelector('.progress');
            const percentageEl = progressContainer.querySelector('.percentage');

            progressEl.style.width = percentage;
            percentageEl.innerText = percentage;
            percentageEl.style.left = percentage;
        }
    });



    {{$user->complete}}

    var value = Math.round({{$user->complete}} /16*100)
            console.log(value);

            if (value > 100) {

                value = 100

            }

            $("#profile_complete").attr("data-percentage", value.toString());





            // Prepare location info object.
            // This example displays an address form, using the autocomplete feature
            // of the Google Places API to help users fill in the information.


            // [END region_geolocation]




            //datepicker   

            $(".datepicker").datepicker({

                format: "mm-yyyy",

                startView: "months",

                minViewMode: "months"

            });

            $(".datepickerr").datepicker({

                autoclose: true,
                startDate: '01/01/1950',

                format: 'dd-mm-yyyy'

            });





            n = new Date();

            y = n.getFullYear();

            m = n.getMonth() + 1;

            // d = n.getDate();

            document.getElementById("date1").innerHTML = m + "-" + y;
    </script>





    <script>

    $('#locationFilter41').select2({
        tags: true, 
        tokenSeparators: [','],
        placeholder: "(Add Location)",
        minimumInputLength: 1, // Set the minimum input length to 2
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


    @if(isset($locationresultSelected))
        // Set the selected values
        var selectedValues = {!! json_encode($locationresultSelected) !!};
        var select = $('#locationFilter41');
        for (var id in selectedValues) {
            // console.log(id)
            var option = new Option(selectedValues[id], selectedValues[id], true, true);
            select.append(option).trigger('change');
        }
    @endif

    function submitfrontprofilegapform() {

        var form = $('#forntgap');

        $.ajax({

            url: form.attr('action'),

            type: form.attr('method'),

            data: form.serialize(),

            dataType: 'json',

            success: function(json) {

                //   alert('success');
                $("#success_msg29").show();
                $(".new_error_class").hide();

                $("#success_msg29").html('<div class="alert alert-success">Reason updated successfully</div>');
                setTimeout(function() {
                    $("#success_msg29").hide();
                }, 5000);
            },

            error: function(json) {



                // alert('error');

                if (json.status === 422) {

                    var resJSON = json.responseJSON;

                    $('.help-block').html('');

                    $.each(resJSON.errors, function(key, value) {

                        $('.' + key + '-error').html('<strong class="new_error_class">' + value +
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

    }
    </script>



    <script>
    $(".changeimage").change(function() {



        // alert('hello');





        $.ajax({



            url: "{{url('image-store')}}",



            type: "POST",





            data: new FormData($('#formvalue')[0]),

            processData: false,

            contentType: false,



            _token: '{{ csrf_token() }}',



            dataType: 'json',



            success: function(data) {



                alert('success');



                location.reload(true);





            },



            error: function(json) {



                location.reload(true);



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

    $("#industry").change(function() {

        if (this.value == 2) {

            $("#hideit1").show();
        } else {
            $("#hideit1").hide();
        }
    });



    $("#industry option:first").attr("disabled", "disabled");

    $("#gender_id option:first").attr("disabled", "disabled");

    $("#marital_status_id option:first").attr("disabled", "disabled");

    $(".physically_challenged option:first").attr("disabled", "disabled");
    </script>





    <script>
    $(document).ready(function() {
        $location_input = $("#autocomplete12");
        var options = {
        
            componentRestrictions: {
                country: 'IN'
            }
        };
        autocomplete = new google.maps.places.Autocomplete($location_input.get(0), options);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var data = $("#search_form").serialize();
            var location = $("#autocomplete12").val();
            location = location.split(',')[0];
            $('#autocomplete12').val(location);
            // $("#autocomplete12").append(location);
            console.log('blah')
            show_submit_data(location);
            return false;
        });

        $location_input = $("#autocomplete_offers");
        var options = {
            types: ['(cities)'],
            componentRestrictions: {
                country: 'IN'
            }
        };
        autocomplete = new google.maps.places.Autocomplete($location_input.get(0), options);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var data = $("#search_form").serialize();
            var location = $("#autocomplete_offers").val();
            location = location.split(',')[0];
            //  alert(location);
            $('#autocomplete_offers').val(location);
            // $("#autocomplete12").append(location);
            console.log('blah')
            show_submit_data(location);
            return false;
        });



    });

    function show_submit_data(data) {
        $("#result").html(data);
    }




    var searchInput = 'autocomplete11';

    $location_input = $("#autocomplete11");

    var autocomplete;

    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

        types: ['(cities)'],

        componentRestrictions: {

            country: "IN"

        }

    });



    google.maps.event.addListener(autocomplete, 'place_changed', function() {

        var near_place = autocomplete.getPlace();

        var location = $("#autocomplete11").val();
        location = location.split(',')[0];
        $('#autocomplete11').val(location);

    });


    var searchInput = 'autocomplete1';

    $location_input = $("#autocomplete1");

    var autocomplete;

    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

    

        componentRestrictions: {

            country: "IN"

        }

    });



    google.maps.event.addListener(autocomplete, 'place_changed', function() {

        var near_place = autocomplete.getPlace();

        var location = $("#autocomplete1").val();
        location = location.split(',')[0];
        $('#autocomplete1').val(location);

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

    $('#myselect').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true
    });
    $(document).ready(function() {

        //multiselect Location
        $('#location-multi-select').multiselect({
            includeSelectAllOption: true,
        selectAllText: 'Anywhere In India',
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



    <script>
    initialize();
    </script>


    <script type="text/javascript">
        $(window).on('load', function() {
        var dat =  $('#yes').val();


            if(dat == 0)
            {
                $('#myModal').modal('show');

            }
        // 
        });


        $(function() {
    function split(val) {
        return val.split(/,\s*/);
    }

    function extractLast(term) {
        console.log("Search Keywords:", term); 
        return split(term).pop();
    }

        $("#locationFilter4")
        .on("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
        })
        .on("input", function() {
        this.value = this.value.replace(/[^\w\s,]/gi, '');
        })
        .autocomplete({
        minLength: 0,
        source: function(request, response) {
            $.ajax({
            url: "{{ url('autocomplete/search-location-job1') }}",
            dataType: "json",
            data: {
                query: request.term
            },
            success: function(data) {
                response($.map(data, function(item) {
                return {
                    label: item,
                    value: item
                };
                }));
            }
            });
        },
        focus: function() {
            return false;
        },
        select: function(event, ui) {
            this.value = ui.item.value;
            return false;
        },
        open: function(event, ui) {
            var term = this.value;
            var autocomplete = $(this).data("ui-autocomplete");
            autocomplete.menu.element.find("li").each(function() {
            var item = $(this).data("ui-autocomplete-item");
            var highlightedItem = item.label.replace(new RegExp($.ui.autocomplete.escapeRegex(term), "gi"), '<span class="highlight">$&</span>');
            $(this).html(highlightedItem);
            });
        }
        });



    });

    </script>



    @endpush
