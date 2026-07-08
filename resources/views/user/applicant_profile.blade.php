@extends('layouts.app')



@section('content')

@php
    $unlocked = $unlocked ?? false;
    $collections = $collections ?? collect();
@endphp

    <!-- Header start -->
    @include('includes.header')

    <style>
        .down-btn {
            background-color: #0642a9;
            padding: 13px 20px 13px 20px !important;
            border-radius: 5px;
            border: 2px solid #0642a9;
            transition: 1s ease;
            cursor: pointer;
        }

        .down-btn {
            background-color: #0642a9;
            padding: 13px 20px 13px 20px !important;
            border-radius: 5px;
            border: 2px solid #0642a9;
            transition: 1s ease;
            cursor: pointer;
        }

        .docx-wrapper {
            background: #fff !important;
        }

        .docx-wrapper>section.docx {
            box-shadow: 0 0 2px rgb(0 0 0 / 50%) !important;
            width: 100% !important;

        }

        .modal.show .modal-dialog {
            display: flex;
            justify-content: center;
        }

        .modal.fade .modal-dialog {
            display: flex;
            justify-content: center;
        }

        canvas {
            max-width: -webkit-fill-available;
        }

        #more-button {
            background: transparent;
            border: none;
            text-decoration: underline;
            color: blue;
        }
        }
    </style>



    <section class="section_canddashboard pt-5">



        <div class="container">



            @if (session()->has('message'))
                <div class="alert alert-success">



                    {{ session()->get('message') }}



                </div>
            @endif



            <div class="success_msg1 success_msg27 " id="success_msg27"></div>



            <div class="alert alert-success " style="display:none">



                <span class='alert alert-success' id="myElem1" style="display:none; margin-left-500px;"><i
                        class='fa fa-check'></i> Resume already exists in this collection</span>



            </div>

            <div class="success_msg1 success_msg47 " id="success_msg47"></div>



            <div class="alert alert-danger " style="display:none">



                <span class='alert alert-danger' id="myElem1" style="display:none; margin-left-500px;"><i
                        class='fa fa-check'></i> Resume already exists in this collection</span>



            </div>



            @if (session()->has('error'))
                <div class="alert alert-danger">



                    {{ session()->get('error') }}



                </div>
            @endif



        </div>



        <div class="container">



            <div class="row py-2">







                <div class="col-md-12 ">



                    <?php
                    
                    $user1 = \App\User::where('id', $user->id)->first();
                    
                    //  echo $user1;
                    
                    $verified = isset($user1) ? $user1->verified : '';
                    
                    $interview_date_list = \App\Interview::where('user_id', $user->id)
                        ->where('date', '>=', date('Y-m-d'))
                        ->where(function ($query) {
                            $query->where('date', '>', date('Y-m-d'))->orWhere(function ($query) {
                                $query->where('date', '=', date('Y-m-d'))->where('from_time', '>', date('g:i A'));
                            });
                        })
                        ->orderBy('date', 'asc')
                        ->orderBy('from_time', 'asc')
                        ->get();
                    
                    foreach ($interview_date_list as $dat) {
                        //   echo $dat->date;
                    
                        $newDate[] = date('d', strtotime($dat->date));
                    
                        $newMonth[] = date('F', strtotime($dat->date));
                    }
                    
                    if (isset($newMonth) && count($newMonth) > 0) {
                        $newMonth = array_unique($newMonth);
                    } else {
                        $newMonth = [];
                    }
                    
                    if (isset($newDate) && count($newDate) > 0) {
                        $interview_dates = implode(', ', $newDate);
                    } else {
                        $interview_dates = [];
                    }
                    
                    $company = \App\ProfileCityJobsCity::where('user_id', $user->id)->first();
                    
                    $itskill = \App\ProfileSkill::where('user_id', $user->id)->get();
                    
                    foreach ($itskill as $value) {
                        //  echo $value;
                    
                        $itvalue = $value;
                    }
                    
                    $projects = \App\ProfileProject::where('user_id', $user->id)->get();
                    
                    foreach ($projects as $key => $value) {
                        $project_value = $value;
                    }
                    
                    $accomplishments = \App\Accomplishment::where('user_id', $user->id)->get();
                    
                    $certificates = \App\Certificate::where('user_id', $user->id)->get();
                    
                    foreach ($certificates as $key => $value) {
                        $certificates_value = $value;
                    }
                    
                    $gaps = \App\ProfileGap::where('user_id', $user->id)->get();
                    
                    foreach ($gaps as $key => $value) {
                        # code...
                    
                        $gap_value = $value;
                    
                        // echo $gap_value;
                    }
                    
                    ?>







                    <div
                        class="dash_box-right_profile text-center text-md-left px-2 px-sm-5 py-4 boxing @if ($user1->verified == 1) stick_label @endif">







                        {{-- @if ($user1->verified == 1)



                



                    <div class="verified-tag">            



                    <p> Verified</p>                                   



                    



                    </div>



                    @endif --}}



                        <div class="row center_profile ">



                            <div class="col-md-2 pr-3 pr-lg-0">



                                <div class="dash_pic">





                                    <a href="javascript:void(0);">
                                        @if ($user1->image)
                                            <img src="{{ asset('user_images/' . $user1->image) }}" alt=""
                                                title="" style="width: 100px;height: 100px !important;"
                                                class="img-fluid  canddashboard-userpic"><span>
                                            @else
                                                <img src="{{ asset('/') }}asset/images/dashboardpic.png"
                                                    class="img-fluid  canddashboard-userpic">
                                        @endif
                                    </a>



                                </div>



                            </div>



                            <div class="col-md-10 pt-3 pt-md-0 pl-lg-0">



                                <?php
                                
                                $user = \App\User::where('id', $user->id)->first();
                                
                                $education = \App\ProfileEducation::where('user_id', $user->id)->first();
                                
                                $data2 = \App\ProfileSummary::where('user_id', $user->id)->first();
                                
                                $experience = isset($data2) ? $data2->totalexp : '';
                                
                                $latestdesg = isset($data2) ? $data2->latestdesg : '';
                                
                                $latestcom = isset($data2) ? $data2->latestcom : '';
                                
                                $data3 = \App\ProfileDetails::where('user_id', $user->id)->first();
                                
                                $ctc1 = isset($data3) ? $data3->expect_ctc_lakhs : '';
                                
                                $ctc2 = isset($data3) ? $data3->expect_ctc_thousand : '';
                                
                                $ctc3 = isset($data3) ? $data3->expect_ctc_lakhs1 : '';
                                
                                $ctc4 = isset($data3) ? $data3->expect_ctc_thousand1 : '';
                                
                                $ctc5 = isset($data3) ? $data3->expect_ctc_lakhs2 : '';
                                
                                $ctc6 = isset($data3) ? $data3->expect_ctc_thousand1 : '';
                                
                                $ctc7 = isset($data3) ? $data3->expect_ctc_lakhs3 : '';
                                
                                $ctc8 = isset($data3) ? $data3->expect_ctc_thousand3 : '';
                                
                                $ctc = isset($data3) ? $data3->expect_ctc_lakhs : '';
                                
                                $ectc = isset($data3) ? $data3->expect_ctc_lakhs3 : '';
                                
                                $data4 = \App\ProfileNop::where('user_id', $user->id)->first();
                                
                                if ((isset($data4->nop_days) ? $data4->nop_days : '') == '1') {
                                    $nop1 = 'Immediately Available';
                                } elseif ((isset($data4->nop_days) ? $data4->nop_days : '') == '2') {
                                    $nop1 = 'Serving Notice Period';
                                } elseif ((isset($data4->nop_days) ? $data4->nop_days : '') == '3') {
                                    $nop1 = 'Buyable Notice Period';
                                } elseif ((isset($data4->nop_days) ? $data4->nop_days : '') == '4') {
                                    $nop1 = 'Not Under Notice Period';
                                }
                                
                                ?>



                                <?php
                                
                                $organization = isset($education) ? $education->organization : null;
                                
                                ?>



                                <div class="d-sm-inline">



                                    <h2 class="text-dark dash_box-texthead mb-2">{{ $user->first_name }}</h2>



                                </div>



                                <div class="d-sm-inline">

                                    <i class="fa fa-envelope pr-2 text-dark" aria-hidden="true"></i>

                                    <input type="text" value="{{ $user->email }}" id="myInput" hidden>

                                    <span onclick="myFunction()" data-toggle="tooltip" data-placement="top"
                                        title="Email ID Copied"
                                        class="copytext text-dark  pr-sm-3">{{ $user->email }}</span>



                                </div>









                                @if (isset($user->phone))
                                    <div class="d-sm-inline"><a href="tel:{{ $user->phone }}" class="text-dark  pr-sm-3"><i
                                                class="fa fa-phone text-dark pr-2"
                                                aria-hidden="true"></i>{{ $user->phone }}</a></div>
                                @endif







                                @if (isset($user->current_city))
                                    <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i
                                                class="fa fa-map-marker text-dark pr-2"
                                                aria-hidden="true"></i>{{ $user->current_city }}</a>



                                    </div>
                                @endif







                                @if (isset($user->industry) == 1)
                                    <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i
                                                class="fa fa-user text-dark pr-2" aria-hidden="true"></i>IT</a></div>
                                @else
                                    <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i
                                                class="fa fa-user text-dark pr-2" aria-hidden="true"></i>NON IT</a></div>
                                @endif











                                @if (isset($education->organization))
                                    <?php
                                    
                                    $degree = \App\Degree::where('id', $organization)->first();
                                    
                                    ?>







                                    <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i
                                                class="fa fa-university text-dark pr-2"
                                                aria-hidden="true"></i>{{ $degree->educations }}</a></div>
                                @endif



                                @if (isset($data2->latestcom))
                                    <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i
                                                class="fa fa-building text-dark pr-2"
                                                aria-hidden="true"></i>{{ $latestcom }}</a>



                                    </div>
                                @endif







                                @if (isset($data2->latestdesg))
                                    <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i
                                                class="fa fa-briefcase text-dark pr-2"
                                                aria-hidden="true"></i>{{ $latestdesg }}</a></div>
                                @endif



                                @if (isset($data3->ctc))
                                    <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i
                                                class="fa fa-money text-dark pr-2" aria-hidden="true"></i>Current CTC :
                                            {{ $ctc }}</a></div>
                                @endif



                                @if (isset($data3->ectc))
                                    <div class="d-sm-inline"><a class="text-dark pr-sm-3"><i
                                                class="fa fa-money text-dark pr-2" aria-hidden="true"></i>Expected CTC :
                                            {{ $ectc }}</a></div>
                                @endif



                                @if (isset($data2->experience))
                                    <div class="d-md-inline"><span class="text-dark"><i
                                                class="fa fa-calendar text-dark pr-2"
                                                aria-hidden="true"></i>{{ $experience }}</span></div>
                                @endif







                                <?php
                                
                                $profile_education = isset($user->getedu()->degree_title) ? $user->getedu()->degree_title : '';
                                
                                $educationn = \App\Education::find($profile_education);
                                
                                ?>



                                @if (isset($educationn))
                                    <div class="text-dark py-1"> <span class="text-dark font-weight-bold">Highest Education
                                            :



                                        </span>{{ $educationn->education }} </div>
                                @endif







                                @if (isset($data4->nop_days))
                                    <div class="text-dark"><span class="text-dark notice_dash">Notice Period : </span>
                                        {{ $nop1 ?? '' }}</div>

                                    @php
                                        $interview_date = \App\Interview::where('user_id', $user->id)
                                            ->where('date', '>=', date('Y-m-d'))
                                            ->where(function ($query) {
                                                $query->where('date', '>', date('Y-m-d'))->orWhere(function ($query) {
                                                    $query
                                                        ->where('date', '=', date('Y-m-d'))
                                                        ->where('from_time', '>', date('g:i A'));
                                                });
                                            })
                                            ->orderBy('date', 'asc')
                                            ->orderBy('from_time', 'asc');

                                        $interview_date_list = $interview_date->get();
                                        $num_count = 0;

                                        $num_of_items = $interview_date->count();

                                    @endphp
                                @endif

                                @if (isset($data3->work_type))
                                    <div class="text-dark"><span class="text-dark notice_dash">Pref. Work Type : </span>
                                        {{ $data3->work_type ?? '' }}</div>
                                @endif

                                @php

                                    $interview = [];

                                    foreach ($interview_date_list as $melson) {
                                        if (array_key_exists(date('M', strtotime($melson->date)), $interview)) {
                                            $interview[date('M', strtotime($melson->date))] =
                                                $interview[date('M', strtotime($melson->date))] .
                                                ',' .
                                                date('d', strtotime($melson->date));
                                        } else {
                                            $interview[date('M', strtotime($melson->date))] = date(
                                                'd',
                                                strtotime($melson->date),
                                            );
                                        }
                                    }

                                @endphp

                                @if (isset($newMonth) && count($newMonth) > 0)
                                    <div class="text-dark"><span class="text-dark notice_dash">Interview Availability :
                                        </span>

                                        @foreach ($interview as $key => $item)
                                            {{ $key }} {{ $item }}
                                        @endforeach



                                    </div>
                                @endif

                                @if ($user->recruiter_comments)
                                    <div class="text-dark">
                                        <span class="text-dark notice_dash">Recruiter Comments :</span>
                                        <span id="recruiter-comments">
                                            {{ \Illuminate\Support\Str::limit($user->recruiter_comments, 100) }}
                                        </span>
                                        <span id="more-content" style="display: none;">
                                            {{ $user->recruiter_comments }}
                                        </span>
                                        <button id="more-button" onclick="showMore()">More</button>
                                    </div>
                                @endif









                            </div>



                            <!-- <div class="dash_edit">



                                 <a href="javascript:void(0)"><i class="fa fa-pencil px-0 text-white" aria-hidden="true"></i></a>



                            </div> -->



                        </div>



                        <div class="row pt-4 center_profile">



                            <div class="col-lg-12">



                                <label class="text-dark">Profile Completeness</label>



                                <div class="progress-container" data-percentage='30' value=""
                                    id="profile_complete">

                                    <div class="progress"></div>

                                    <div class="percentage">0%</div>

                                </div>



                            </div>



                        </div>



                    </div>



                </div>



            </div>



            <div class="row pt-4">



                <div class="col text-sm-right">



                    <?php
                    
                    $file = isset($user->showcvs()->resume) ? $user->showcvs()->resume : '';
                    
                    // echo $file;
                    
                    ?>







                    <?php
                    
                    $com = isset($company->id) ? $company->id : '';
                    
                    ?>







                    {{-- @if (null !== $profileCv)<a href="{{asset('cvs/'.$profileCv->cv_file)}}" class="btn"><i class="fa fa-download" aria-hidden="true"></i> {{__('Download CV')}}</a>@endif --}}



                    <span class='alert alert-success newclass' id="myElem" style="display:none; margin-left-500px;"><i
                            class='fa fa-check'></i> Email Sent Successfully</span>







                    @if ($user->resume)
                        @php

                            $str = "$user->resume";

                            $parts = explode('.', $str);

                            $result = end($parts);

                        @endphp







                        <!--<a href="{{ url('download-candidate-resum', $user->id) }}" style="color: white" target="_blank" class="py-2 down-btn px-2 px-sm-3 mr-1 mr-sm-3">View/Download Resume</a>  -->

                        @if ($result == 'pdf')
                            <input type="button" id="pdfbtnPreview" value="View/Download Resume" style="color: white"
                                class="py-2 signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3"
                                onclick="LoadPdfFromUrl('{{ asset('cvs/' . $user->resume) }}')" />
                        @endif



                        @if ($result == 'docx')
                            <input type="button" id="docbtnPreview" value="View/Download Resume" style="color: white"
                                class="py-2 signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3" onclick="PreviewWordDoc()" />
                        @endif
                    @endif





                    <?php
                    
                    $company_id = Auth::guard('company')->user()->id;
                    
                    $company_value = \App\Company::where('id', $company_id)->first();
                    
                    $now = \Carbon\Carbon::now();
                    
                    $end_date = $company_value->package_end_date;
                    
                    $report = \App\ReportAbuseCompanyMessage::where('user_id', $user->id)
                        ->where('company_id', $company_id)
                        ->first();
                    
                    $employer_payment = \App\EmployerPayment::where('company_id', $company_id)
                        ->where('payment_status', 1)
                        ->where('user_id', $user->id)
                        ->orderBy('id', 'desc')
                        ->first();
                    
                    //echo $end_date;
                    
                    ?>


                    @if ($user->recorded_video)
                        @if ($employer_payment && ($employer_payment->payment_method == 3 || $employer_payment->singlecv_videointerview == 1))
                            <button type="submit" class="py-2 signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3"
                                onclick="recordedmodal({{ $user->id }})">View Interview</button>
                            <input type="hidden" class="modalid{{ $user->id }}"
                                value="{{ asset('cvs/' . $user->recorded_video) }}">
                        @else
                            <a href="{{ route('employer.buy.interview', $user->id) }}" target="_blank"
                                class=" signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3" style="padding:12px 0px">View
                                Interview</a>
                        @endif
                    @endif


                    @if (isset($end_date) && $end_date < $now)
                        <button type="submit" class="py-2 signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3"
                            onclick="alert('Buy CV/Subscription!')">Send Email</button>
                    @else
                            <button type="submit" class="py-2 signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3"
                                data-toggle="modal" data-target="#emailmodal">Send Email</button>
                    @endif

                    {{-- <button type="submit" class="py-2 signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3" onclick="sendsms({{ $user->id }})">Send SMS</button> --}}



                    {{-- <button type="submit" class="py-2 signup_button rounded px-2 px-sm-3 mr-1 mr-sm-3" data-toggle="modal" data-target="#addfoldermodal">Add to Folder</button> --}}


                    @if (!$report)
                        <button type="submit" class="py-2 signup_button rounded px-2 px-sm-2 mb-1 mb-sm-0 "
                            data-toggle="modal" data-target="#addfoldermodal1">Report CV</button>
                    @endif



                </div>



            </div>



            <div class="row pb-5 pt-4">



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

                                    @if (isset($newMonth) && count($newMonth) > 0)
                                        <li class="nav-item sticky_font">



                                            <a class="nav-link" href="#Interview">Interview Availability</a>



                                        </li>
                                    @endif



                                    @if (isset($company))
                                        <li class="nav-item sticky_font">



                                            <a class="nav-link" href="#profile_achievements">Professional Summary</a>



                                        </li>
                                    @endif



                                    @if (isset($itvalue))
                                        <li class="nav-item sticky_font">



                                            <a class="nav-link" href="#it_skills">IT Skills</a>



                                        </li>
                                    @endif



                                    @if (isset($project_value))
                                        <li class="it-project-process nav-item sticky_font">



                                            <a class="nav-link" href="#it_projects">IT Projects</a>



                                        </li>
                                    @endif



                                    <li class="nav-item sticky_font">



                                        <a class="nav-link" href="#Education">Education</a>



                                    </li>

                                    @if (!$accomplishments)
                                        <li class="nav-item sticky_font">

                                            <a class="nav-link" href="#Accomplishment">Accomplishment</a>

                                        </li>
                                    @endif



                                    @if (isset($certificates_value))
                                        <li class="nav-item sticky_font">



                                            <a class="nav-link" href="#Technical_Certifications">Other Certifications</a>



                                        </li>
                                    @endif



                                    @if (isset($gap_value->gap_from_month))
                                        <li class="nav-item sticky_font">



                                            <a class="nav-link" href="#gaps">Employment Gaps</a>



                                        </li>
                                    @endif



                                    @if (isset($data3->contract_type))
                                        <li class="nav-item sticky_font">



                                            <a class="nav-link" href="#employment">Employment Preferences</a>



                                        </li>
                                    @endif



                                    <li class="nav-item sticky_font">



                                        <a class="nav-link" href="#basic_info">Personal Details</a>



                                    </li>



                                </ul>



                            </nav>



                        </div>



                    </div>



                </div>







                <div class="col-md-8 col-lg-9 col-12">







                    <!-- Account Information -->



                    <div class="row">



                        <div id="account_info" class="col-md-12 col-12 pt-3 pt-sm-0 profile_head rounded">



                            <div class="myprofile_font pb-3">Account Information</div>



                        </div>



                        <!-- <div class="col-md-6 col-6 d-flex py-3  pr-3 justify-content-end px-0 ">



                            <button type="submit" class="py-2 px-2 mr-3 save_pro rounded signin_button">Save changes</button>



                            <button type="submit" title="Save" class="py-2 px-3 mr-3 rounded signup_button  d-sm-none"><i class="fa fa-floppy-o pro_smicon d-block d-sm-none" aria-hidden="true"></i></button>



                            <button type="submit" class="py-2 px-2 rounded signup_button save_pro ">Edit<i class="fa fa-pencil pl-2 pro_smicon" aria-hidden="true"></i></button>



                            <button type="submit" title="Edit" class="py-2 px-3 rounded signup_button d-sm-none "><i class="fa fa-pencil  pro_smicon d-sm-none " aria-hidden="true"></i></button>



                        </div> -->



                    </div>



                    <div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="mb-2  sign_fontsize">Email : <span>{{ $user->email }}</span></label>
                                    @if ($user->email_verified == '1')
                                        <img class="" style="width:25px"
                                            src="{{ asset('/') }}asset/images/verified.png" data-toggle="tooltip"
                                            title="Verified">
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="mb-2 pt-1 pt-sm-3 pt-lg-0 sign_fontsize">Phone Number :
                                        <span>{{ $user->phone }}</span></label>
                                    @if ($user->phone_verified == '1')
                                        <img class="" style="width:25px"
                                            src="{{ asset('/') }}asset/images/verified.png" data-toggle="tooltip"
                                            title="Verified">
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>







                    <!-- Key Skills  -->







                    <?php
                    
                    $keyskill = \App\KeySkill::where('user_id', $user->id)->get();
                    
                    foreach ($keyskill as $value) {
                        $key = $value;
                    }
                    
                    //  $t4=(isset($skill) ? $skill->keyskill:'');
                    
                    //  echo $skill
                    
                    ?>











                    @if (isset($key))
                        <div id="keyskills" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                            <div class="myprofile_font">Key Skills</div>



                        </div>















                        <div class="box_profile px-4 px-sm-5 py-4 py-sm-4 rounded">



                            <div class="">



                                <ul class="list-inline my-0">



                                    @foreach ($keyskill as $skill)
                                        <?php
                                        
                                        $job_skill = \App\JobSkill::where('id', $skill->keyskill)->first();
                                        
                                        //  echo $job_skill->job_skill;
                                        
                                        ?>







                                        <li class="list-inline-item terms mb-1">
                                            {{ isset($job_skill->job_skill) ? $job_skill->job_skill : '' }}</li>
                                    @endforeach



                                </ul>



                            </div>



                        </div>
                    @endif







                    <!-- Notice Period Status -->



                    <?php
                    
                    $nop_data = \App\ProfileNop::where('user_id', $user->id)->first();
                    
                    ?>







                    @if ($nop_data)
                        <div id="Noticeperiod_profile" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                            <div class="myprofile_font">Notice Period Status</div>



                        </div>



                        <div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">



                            <form>



                                <div class="row">



                                    @if (isset($data4->nop_days))
                                        <div class="col-12 position_lit">



                                            <label class="mb-2 sign_fontsize">Notice Period Status : <span>
                                                    {{ $nop1 ?? '' }}</span></label>



                                        </div>
                                    @endif



                                    @if (isset($nop_data->last_working_day) && (isset($data4->nop_days) ? $data4->nop_days : '') == '2')
                                        <div class="col-12">



                                            <label class="mb-2 pt-1 pt-sm-3 sign_fontsize">Last working date incase notice
                                                period is being served : <span>
                                                    {{ Carbon\Carbon::parse($nop_data->last_working_day)->format('d-m-Y') }}</span></label>



                                        </div>
                                    @endif



                                    @if (isset($nop_data->immediate_last_date) && (isset($data4->nop_days) ? $data4->nop_days : '') == '1')
                                        <div class="col-12">



                                            <label class="mb-2 pt-1 pt-sm-3 sign_fontsize">Mention your Last Working Date
                                                with your last employer OR your Month of graduation in case you are a
                                                fresher : <span> {{ $nop_data->immediate_last_date }}</span></label>



                                        </div>
                                    @endif



                                </div>



                            </form>



                        </div>
                    @endif







                    <!-- Offers In Hand -->







                    <?php
                    
                    $offers = \App\Offers::where('user_id', $user->id)->first();
                    
                    //  echo $offers;
                    
                    if (isset($offers) && $offers->hold == 1) {
                        $offer = 'Yes';
                    
                        // echo $offer;
                    } else {
                        $offer = 'No';
                    
                        //echo $offer;
                    }
                    
                    ?>



                    <?php
                    
                    $ctcoff = unserialize(isset($offers->ctcoff) ? $offers->ctcoff : '');
                    
                    $dateoff = unserialize(isset($offers->dateoff) ? $offers->dateoff : '');
                    
                    $locoff = unserialize(isset($offers->locoff) ? $offers->locoff : '');
                    
                    // print_r($locoff);
                    
                    ?>



                    <div id="competing_offers" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                        <div class="myprofile_font">Offers In Hand<a href="javascript:void(0)"></a></div>



                    </div>



                    <div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">



                        <form>



                            <div class="row">



                                <div class="col-12 position_lit">



                                    <label class="mb-2 sign_fontsize">Are you holding employment offers? :
                                        <span>{{ $offer }}



                                        </span></label>



                                </div>



                                @if (isset($offers) && $offers->hold == 1)
                                    <div class="col-12 position_lit">



                                        <label class="mb-1 sign_fontsize pt-3">Reason for exploring opportunities despite
                                            having



                                            offer/s :</label>



                                        <p class="mb-0">{{ $offers->expoff }}</p>



                                    </div>



                                    <div class="col-12 position_lit">



                                        <label class="mb-2 sign_fontsize pt-3">Please mention the total offers you are
                                            holding :



                                            <span>{{ $offers->repoff }}</span></label>



                                    </div>
                                @endif



                            </div>







                            @if (isset($offers) && $offers->hold == 1)
                                <div class="row">



                                    <div class="col-lg-3 position_lit">



                                        <label class="mb-2 sign_fontsize pt-3">CTC Offered : <span>{{ $offers->ctcoff1 }}
                                            </span></label>



                                    </div>



                                    <div class="col-lg-4 position_lit">



                                        <label class="mb-2 sign_fontsize pt-3">Date of Joining :
                                            <span>{{ \Carbon\Carbon::parse($offers->dateoff1)->format('d-m-Y') }}</span></label>



                                    </div>



                                    <div class="col-lg-5 position_lit">



                                        <label class="mb-2 sign_fontsize pt-3">Location of Job Offer :
                                            <span>{{ $offers->locoff1 }}</span></label>



                                    </div>



                                </div>
                            @endif







                            @if (isset($ctcoff) && !empty($ctcoff))



                                @if ($offers->ctcoff && $offers->hold == 1)
                                    @foreach (isset($ctcoff) ? $ctcoff : '' as $key => $item)
                                        <div class="row">

                                            <div class="col-lg-3 position_lit">

                                                <label class="mb-2 sign_fontsize pt-3">CTC Offered :
                                                    <span>{{ $ctcoff[$key] }} </span></label>

                                            </div>

                                            <div class="col-lg-4 position_lit">

                                                <label class="mb-2 sign_fontsize pt-3">Date of Joining :
                                                    <span>{{ \Carbon\Carbon::parse($dateoff[$key])->format('d-m-Y') }}</span></label>

                                            </div>

                                            <div class="col-lg-5 position_lit">

                                                <label class="mb-2 sign_fontsize pt-3">Location of Job Offer :
                                                    <span>{{ $locoff[$key] }} </span></label>

                                            </div>

                                        </div>
                                    @endforeach
                                @endif

                            @endif







                        </form>



                    </div>



                    <?php
                    
                    ?>



                    @if ($data3)
                        <!-- Compensation -->



                        <div id="compensation" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                            <div class="myprofile_font">Compensation</div>



                        </div>



                        <div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">



                            <form>



                                <div class="row">



                                    <div class="col-12 position_lit">



                                        <label class="mb-2 sign_fontsize">Current Total CTC per annum (Fixed + Variable +
                                            Bonus + Incentives + Benefits) : <span>{{ $ctc1 }} Lakh</span></label>



                                    </div>

                                    @if (isset($ctc3))
                                        <div class="col-12 position_lit">



                                            <label class="mb-2 sign_fontsize pt-3">Fixed CTC per annum :
                                                <span>{{ $ctc3 }} Lakh</span></label>



                                        </div>
                                    @endif



                                    @if (isset($ctc5))
                                        <div class="col-12 position_lit">



                                            <label class="mb-2 sign_fontsize pt-3">Variable CTC per annum
                                                (Incentives/Bonus) : <span>{{ $ctc5 }} Lakh</span></label>



                                        </div>
                                    @endif



                                    <div class="col-12 position_lit">



                                        <label class="mb-2 sign_fontsize pt-3">Expected CTC per annum :
                                            <span>{{ $ctc7 }} Lakh</span></label>



                                    </div>



                                </div>



                            </form>



                        </div>
                    @endif



                    <?php
                    
                    $video_date_from = isset($data3->video_date_from) ? $data3->video_date_from : '';
                    
                    $video_date_to = isset($data3->video_date_to) ? $data3->video_date_to : '';
                    
                    $video_time = isset($data3->video_time) ? $data3->video_time : '';
                    
                    $night_telephonic_from = isset($data3->night_telephonic_date_from) ? $data3->night_telephonic_date_from : '';
                    
                    $night_telephonic_to = isset($data3->night_telephonic_date_to) ? $data3->night_telephonic_date_to : '';
                    
                    $night_time = isset($data3->night_time) ? $data3->night_time : '';
                    
                    $interviews = \App\Interview::where('user_id', $user->id)
                        ->where('date', '>=', date('Y-m-d'))
                        ->where(function ($query) {
                            $query->where('date', '>', date('Y-m-d'))->orWhere(function ($query) {
                                $query->where('date', '=', date('Y-m-d'))->where('from_time', '>', date('g:i A'));
                            });
                        })
                        ->orderBy('date', 'asc')
                        ->orderBy('from_time', 'asc')
                        ->get();
                    
                    ?>







                    @if (isset($newMonth) && count($newMonth) > 0)
                        <!-- Interview Availability -->



                        <div id="Interview" class="col-lg-6 pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                            <div class="myprofile_font">Interview Availability</div>



                        </div>



                        <div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">



                            <div class="inner_box_1 mb-2">



                                <p>Please mention your availability for a Video Interview</p>



                                <div class="table-responsive">





                                    <table class="table">



                                        <thead>



                                            <tr>



                                                <th class="pt-0">Date</th>



                                                <th class="pt-0">From Time</th>



                                                <th class="experience_skill_1 pt-0">To Time</th>



                                            </tr>



                                        </thead>



                                        <tbody>



                                            @foreach ($interviews as $interview)
                                                <tr>



                                                    <td class="pb-0">
                                                        {{ \Carbon\Carbon::parse($interview->date)->format('d/m/Y') }}</td>



                                                    <td class="pb-0">{{ $interview->from_time }}</td>



                                                    <td class="pb-0">{{ $interview->to_time }}</td>



                                                </tr>
                                            @endforeach



                                        </tbody>



                                    </table>









                                </div>



                            </div>







                        </div>
                    @endif



                    <!-- profile summary starts -->





                    @if (isset($company))
                        <div id="profile_achievements" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                            <div class="myprofile_font">Professional Summary</div>



                        </div>



                        <div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">



                            <form>



                                <div class="row">



                                    <div class="col-12">



                                        <label class="mb-1 pt-2 sign_fontsize">Profile Achievements :</label>



                                        <p type="text" class="w-100 pb-1 mb-0">{{ $data2->summary }}</p>



                                    </div>



                                    <div class="col-12">



                                        <label class="mb-2 pt-2 sign_fontsize">Total Experience : <span>
                                                {{ $data2->totalexp }} </span> & <span
                                                class="">{{ $data2->totalexpmonth }}</span></label>



                                    </div>



                                    <div class="col-12">



                                        <label class="mb-2 pt-2 sign_fontsize">Latest Company :
                                            <span>{{ $latestcom }}</span></label>



                                    </div>



                                    <div class="col-12">



                                        <label class="mb-2 pt-2 sign_fontsize">Latest Designation : <span>
                                                {{ $latestdesg }}</span></label>



                                    </div>



                                    <div class="col-12">



                                        <label class="mb-2 pt-2 sign_fontsize">Current Shift : <span>
                                                {{ $data2->currentshift }}</span></label>



                                    </div>



                                </div>



                            </form>



                            @if (isset($company->current_desigination))
                                <div class="pt-3">



                                    <h6 class="sign_head">{{ $company->current_company }}</h6>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Current Designation
                                        :<span>{{ $company->current_desigination }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Start date : <span>
                                            {{ $company->current_start_date }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Till date :
                                        <span>{{ \Carbon\Carbon::parse($user->from_date)->format('m-Y') }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Type of Employment :
                                        <span>{{ $company->current_work_type }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Responsibilites :
                                        <span>{{ $company->current_responsibilities }}</span>



                                    </p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Project Details :
                                        <span>{{ $company->current_project_details }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Reason for Job Change :
                                        <span>{{ $company->current_reason }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">CTC when you started in the organization :
                                        <span>{{ $company->current_ctc_start }} LPA</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">CTC when you moved out of the organization :
                                        <span>{{ $company->current_ctc_end }} LPA</span></p>











                                </div>
                            @endif

                            @if (isset($company->previous_company))
                                <div class="pt-3">



                                    <h6 class="sign_head">{{ $company->previous_company }}</h6>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Previous Designation :
                                        <span>{{ $company->previous_desigination }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Start date :
                                        <span>{{ $company->previous_start_date }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">End date :
                                        <span>{{ $company->previous_till_date }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Type of Employment :
                                        <span>{{ $company->previous_work_type }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1" style="word-break: break-all;">Responsibilites
                                        : <span>{{ $company->previous_responsibilities }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">No.of Projects handled in Case of IT Experience
                                        : <span>{{ $company->previous_project_details }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Reason for Job Change :
                                        <span>{{ $company->previous_reason }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">CTC when you started in the organization :
                                        <span>{{ $company->previous_ctc_start }} LPA</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">CTC when you moved out of the organization :
                                        <span>{{ $company->previous_ctc_end }} LPA</span></p>







                                </div>
                            @endif







                        </div>
                    @endif



                    <!-- IT Skills -->





                    @if (isset($itvalue))
                        <div id="it_skills" class="col-lg-6 pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                            <div class="myprofile_font">IT Skills</div>



                        </div>



                        <div class="box_profile px-4 px-sm-5 py-4 pt-sm-5 pb-sm-4 rounded">



                            <div class="table-responsive">



                                <table class="table">



                                    <thead>



                                        <th class="pt-0">Skills</th>



                                        <th class="pt-0">Version</th>



                                        <th class="experience_skill_1 pt-0">Last used</th>



                                        <th class="experience_skill pt-0">Projects Completed</th>



                                        <th class="experience_skill pt-0">Years of Experience</th>



                                    </thead>



                                    @foreach ($itskill as $skill)
                                        <tr>



                                            <td class="pb-0">{{ $skill->project_title }}</td>



                                            <td class="pb-0">{{ $skill->version }}</td>



                                            <td class="pb-0">{{ $skill->last_used_year }}</td>



                                            <td class="pb-0">{{ $skill->no_of_projects }}</td>



                                            <td class="pb-0">{{ $skill->job_experience }}</td>



                                        </tr>
                                    @endforeach



                                </table>



                            </div>



                        </div>
                    @endif



                    <!-- IT Projects -->





                    @if (isset($project_value))
                        <div id="it_projects" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                            <div class="myprofile_font">IT Projects</div>



                        </div>



                        <div class="box_profile px-4 px-sm-5 py-4 py-sm-4 rounded">







                            @foreach ($projects as $project)
                                <div class="border_style">



                                    <h6 class="sign_head">{{ $project->name }}</h6>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Role in the project :
                                        <span>{{ $project->name }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Client : <span>{{ $project->client }}</span>
                                    </p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Domain : <span>{{ $project->domain }}</span>
                                    </p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Duration of the Project :
                                        <span>{{ $project->duration }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Project Type :
                                        <span>{{ $project->project_type }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Technologies Used in the Project :
                                        <span>{{ $project->tech_used }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Project Description :</p>



                                    <p class="w-100 pb-2 mb-0 sign_fontsize"><span>{{ $project->description }}</span></p>







                                </div>
                            @endforeach







                        </div>
                    @endif







                    <!-- Education -->



                    <?php
                    
                    $p_edu = \App\ProfileEducation::where('user_id', $user->id)->get();
                    
                    foreach ($p_edu as $key => $value) {
                        $education_value = $value;
                    }
                    
                    ?>

                    <?php
                    
                    ?>





                    @if (isset($education_value))
                        <div id="Education" class="col-lg-6 pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                            <div class="myprofile_font">Education</div>



                        </div>

                        <div class="box_profile px-4 px-sm-5 py-4 py-sm-4 rounded">



                            @foreach ($p_edu as $edu)
                                <?php
                                
                                $educations = \App\Education::where('id', $edu->degree_title)->first();
                                
                                $course = \App\Course::where('id', $edu->course)->first();
                                
                                $spec = \App\specs::where('id', $edu->specilation)->first();
                                
                                $degree = \App\Degree::where('id', $edu->organization)->first();
                                
                                ?>

                                <div class="">

                                    <h6 class="sign_head">{{ $educations->education }}</h6>

                                    @if (isset($edu->year_of_passing))
                                        <p class="my-0 sign_fontsize pt-1 mb-1">Year of Passing :
                                            <span>{{ $edu->year_of_passing }}</span></p>
                                    @endif



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Course :
                                        <span>{{ $course->course ?? '' }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">University / College :
                                        <span>{{ $degree->educations ?? '' }}</span></p>



                                    <p class="my-0 sign_fontsize pt-1 mb-1">Specialization :
                                        <span>{{ isset($spec->specs) ? $spec->specs : '' }}</span></p>





                                    @if ($edu->degree_result == '1')
                                        <p class="my-0 sign_fontsize pt-1 mb-1">Grade : <span>Scale 10 Grading
                                                System</span></p>

                                        <p class="my-0 sign_fontsize"><span>Grade Achieved :
                                            </span>{{ $edu->grade_achieved1 }}</p>
                                    @elseif($edu->degree_result == '2')
                                        <p class="my-0 sign_fontsize pt-1 mb-1">Grade : <span>Scale 4 Grading System</span>
                                        </p>

                                        <p class="my-0 sign_fontsize"><span>Grade Achieved :
                                            </span>{{ $edu->grade_achieved2 }}</p>
                                    @elseif($edu->degree_result == '3')
                                        <p class="my-0 sign_fontsize pt-1 mb-1">Grade : <span>% Marks out 100
                                                Maximum</span></p>

                                        <p class="my-0 sign_fontsize"><span>Grade Achieved :
                                            </span>{{ $edu->grade_achieved3 }}</p>
                                    @elseif($edu->degree_result == '4')
                                        <p class="my-0 sign_fontsize pt-1 mb-1">Grade : <span>Course requires a Pass</span>
                                        </p>

                                        <p class="my-0 sign_fontsize"><span>Grade Achieved :
                                            </span>{{ $edu->grade_achieved4 }}</p>
                                    @endif



                                </div>
                            @endforeach



                        </div>
                    @endif

                    @if ($accomplishments)
                        <div id="Accomplishment" class="col-lg-6 pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                            <div class="myprofile_font">Accomplishment</div>



                        </div>


                        <div class="box_profile px-4 px-sm-5 py-4 py-sm-4 rounded">

                            <div class="row ">

                                <div class="col-12">

                                    <div class="myprofile_font">Online Profile</div>

                                    <p>Add link to online profiles (e.g. Linkedin, Github etc.).</p>

                                    <div class="">

                                        @foreach ($accomplishments as $acc)
                                            <p class="my-0 sign_fontsize"><span>Social Profile Name:
                                                </span>{{ $acc->profile_name }}</p>

                                            <p class="my-0 sign_fontsize"><span>URL : </span>{{ $acc->profile_url }} </p>

                                            <p class="my-0 sign_fontsize" style='word-break: break-all;'><span>Description
                                                    : </span>{!! $acc->description !!}</p>
                                        @endforeach

                                    </div>



                                </div>

                            </div>



                        </div>
                    @endif



                    <!-- cOther Certifications -->





                    @if (isset($certificates_value))
                        <div id="Technical_Certifications"
                            class="col-lg-6 pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                            <div class="myprofile_font">Other Certifications</div>



                        </div>



                        <div class="box_profile px-4 px-sm-5 py-4 py-sm-4 rounded">







                            @foreach ($certificates as $certificate)
                                <div class="row ">



                                    <div class="col-12">



                                        <h6 class="sign_head">{{ $certificate->certificate_name }}</h6>



                                        <p class="my-0 sign_fontsize pt-1 mb-1">Certification Agency / School :
                                            <span>{{ $certificate->certificate_agency }}</p>



                                        <p class="my-0 sign_fontsize pt-1 mb-1">Year of Certification :
                                            <span>{{ $certificate->year_of_passing }} -
                                                <span>{{ $certificate->month_of_passing }}</span></p>



                                        <p class="my-0 sign_fontsize pt-1 mb-1">Duration :
                                            <span>{{ $certificate->duration }}</span></p>



                                    </div>



                                    <!-- <div class="col-6 text-right"> -->







                                    <!-- </div> -->



                                </div>
                            @endforeach







                        </div>
                    @endif







                    <!-- Employment Gaps -->







                    @if (isset($gap_value->gap_from_month))
                        <div id="gaps" class="col-lg-6 pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                            <div class="myprofile_font">Employment Gaps</div>



                        </div>



                        <div class="box_profile px-4 px-sm-5 py-4 py-sm-4 rounded">







                            @foreach ($gaps as $gap)
                                <div class="col-">



                                    <div class="border_style">



                                        <h6 class="sign_head">{{ $gap->gap_from_month }} {{ $gap->gap_from_year }} -
                                            {{ $gap->gap_to_month }} {{ $gap->gap_to_year }}</h6>



                                        <p class="my-0 sign_fontsize pt-1 mb-1">Employment Gaps From :
                                            <span>{{ $gap->gap_from_month }}</span></p>



                                        <p class="my-0 sign_fontsize pt-1 mb-1">Employment Gaps To :
                                            <span>{{ $gap->gap_to_month }}</span></p>

                                        @if (isset($gap_value->reason))
                                            <p class="my-0 sign_fontsize pt-1 mb-1">Reason :</p>



                                            <p class="my-0 sign_fontsize pt-1 mb-1"><span>{{ $gap->reason }}</span></p>
                                        @endif



                                    </div>



                                </div>
                            @endforeach



                        </div>
                    @endif



                    <!-- Employment Preferences -->







                    <?php
                    
                    $d1 = isset($data3->contract_type) ? $data3->contract_type : '';
                    
                    if ($d1 == '1') {
                        $contract = 'Yes';
                    } else {
                        $contract = 'No';
                    }
                    
                    // work flexibility
                    
                    if (isset($data3->candidate_wfh) == '1') {
                        $work_flexibility = 'Willing to WFO';
                    } elseif (isset($data3->candidate_wfh) == '2') {
                        $work_flexibility = 'Looking for WFH Only';
                    } else {
                        $work_flexibility = 'Flexible';
                    }
                    
                    ?>







                    @if (isset($data3->contract_type))
                        <div id="employment" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">



                            <div class="myprofile_font">Employment Preferences</div>



                        </div>



                        <div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">



                            <form>



                                <div class="row ">



                                    <div class="col-lg-6">



                                        <label class="mb-2 pt-1 pt-sm-3 pt-lg-0 sign_fontsize">Preferred Work Type :
                                            <span>{{ $data3->work_type }}</span></label>



                                    </div>



                                    <div class="col-lg-6">



                                        <label class="mb-2 pt-1 pt-sm-3 pt-lg-0 sign_fontsize">Preferred Work Shift :
                                            <span>{{ $data3->shifts }}</span></label>



                                    </div>



                                    <div class="col-lg-6">



                                        <label class="mb-2 pt-1 pt-sm-3 sign_fontsize">Are you willing to work on contract?
                                            : <span>{{ $contract }}</span></label>



                                    </div>



                                    <div class="col-lg-6">



                                        <label class="mb-2 pt-1 pt-sm-3 sign_fontsize">Work Flexibility :
                                            <span>{{ $work_flexibility }}</span></label>



                                    </div>



                                    <div class="col-12">



                                        <label class="mb-2 pt-1 pt-sm-3 sign_fontsize">Expecting job opportunities in :
                                            <span>{{ $data3->expecting_opportunities }}</span></label>



                                    </div>



                                    <div class="col-12">



                                        <label class="mb-2 pt-1 pt-sm-3 sign_fontsize">Expected Pay/Month in case of
                                            Contractual Opportunities : <span>
                                                {{ $data3->expecting_payment }}</span></label>



                                    </div>



                                </div>



                            </form>



                        </div>
                    @endif



                    <!-- personal details -->



                    <div id="basic_info" class="col-lg-6 px-0  pb-3 pt-4 mt-0 mt-md-3 profile_head  rounded">



                        <div class="myprofile_font">Personal Details</div>



                    </div>



                    <div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">



                        <form>



                            <?php
                            
                            $user = \App\User::where('id', $user->id)->first();
                            
                            $education = \App\ProfileEducation::where('user_id', $user->id)->first();
                            
                            $data2 = \App\ProfileSummary::where('user_id', $user->id)->first();
                            
                            $experience = isset($data2) ? $data2->totalexp : '';
                            
                            $latestdesg = isset($data2) ? $data2->latestdesg : '';
                            
                            $latestcom = isset($data2) ? $data2->latestcom : '';
                            
                            $data4 = \App\ProfileNop::where('user_id', $user->id)->first();
                            
                            $nop = isset($data4) ? $data4->nop_days : '';
                            
                            //   Gender Staus
                            
                            if ($user->gender_id == '1') {
                                $gender = 'Female';
                            } elseif ($user->gender_id == '2') {
                                $gender = 'Male';
                            } elseif ($user->gender_id == '3') {
                                $gender = 'others';
                            }
                            
                            //    Marital Status
                            
                            if ($user->marital_status_id == '2') {
                                $marital = 'Married';
                            } else {
                                $marital = 'Single';
                            }
                            
                            ?>



                            <div class="row ">



                                <div class="col-lg-4">



                                    <label class="mb-2 pt-lg-0   sign_fontsize">First Name :
                                        <span>{{ $user->first_name }}</span></label>



                                </div>



                                @if (isset($user->middle_name))
                                    <div class="col-lg-4">



                                        <label class="mb-2 pt-1 pt-sm-3 pt-lg-0 sign_fontsize">Middle name :
                                            <span>{{ $user->middle_name }}</span></label>



                                    </div>
                                @endif



                                <div class="col-lg-4">



                                    <label class="mb-2 pt-1 pt-sm-3 pt-lg-0  sign_fontsize">Last name :
                                        <span>{{ $user->last_name }}</span></label>



                                </div>



                                <div class="col-lg-4">

                                    @if (isset($user->industry) == 1)
                                        <label class="mb-2 pt-1 pt-sm-3  pt-lg-0   sign_fontsize">Industry :
                                            <span>IT</span></label>
                                    @else
                                        <label class="mb-2 pt-1 pt-sm-3  pt-lg-0   sign_fontsize">Industry : <span>NON
                                                IT</span></label>
                                    @endif





                                </div>



                                @if (isset($gender))
                                    <div class="col-lg-4">



                                        <label class="mb-2 pt-1 pt-sm-3  pt-lg-0   sign_fontsize">Gender :
                                            <span>{{ isset($gender) ? $gender : '' }}</span></label>



                                    </div>
                                @endif



                                <div class="col-lg-4">



                                    <label class="mb-2 pt-1 pt-sm-3  pt-lg-0   sign_fontsize">Marital Status :
                                        <span>{{ $marital }}</span></label>



                                </div>



                                @if ($user->date_of_birth)
                                    <div class="col-lg-4">



                                        <label class="mb-2 pt-1 pt-sm-3   pt-lg-0   sign_fontsize">Date Of Birth : <span>
                                                {{ Carbon\Carbon::parse($user->date_of_birth)->format('d-m-Y') }}</span></label>



                                    </div>
                                @endif



                                @if ($user->physically_challenged)
                                    <div class="col-lg-4">



                                        <label class="mb-2 pt-1 pt-sm-3  pt-lg-0   sign_fontsize">Physically Challenged :
                                            <span>{{ $user->physically_challenged }}</span></label>



                                    </div>
                                @endif



                                <div class="col-lg-4">



                                    <label class="mb-2 pt-1 pt-sm-3  pt-lg-0   sign_fontsize">Current City :
                                        <span>{{ $user->current_city }}</span></label>



                                </div>

                                @php

                                    $two_value = unserialize($user->prefered_city);

                                    if (isset($two_value) && !empty($two_value)) {
                                        $location_values = implode(', ', $two_value);
                                    }

                                @endphp





                                @if (isset($location_values))
                                    <div class="col-lg-6">



                                        <label class="mb-2 pt-1 pt-sm-3  sign_fontsize">Preferred city : <span>

                                                @php
                                                    if ($location_values) {
                                                        $dataValues = explode(', ', $location_values);
                                                    }
                                                @endphp
                                                @foreach ($dataValues as $val)
                                                    <span>{{ $val }}</span>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach

                                            </span></label>



                                    </div>
                                @endif



                                @if (isset($user->current_location))
                                    <div class="col-lg-4">



                                        <label class="mb-2 pt-1 pt-sm-3   sign_fontsize">Current Location in city :
                                            <span>{{ $user->current_location }}</span></label>



                                    </div>
                                @endif



                                @php

                                    $location_values = unserialize($user->prefered_city);

                                @endphp



                                @if (isset($user->prefered_location))
                                    <div class="col-lg-4">



                                        <label class="mb-2 pt-1 pt-sm-3   sign_fontsize">Preferred Location in city :
                                            <span>{{ $user->prefered_location }}



                                            </span></label>



                                    </div>
                                @endif



                                @if (isset($user->street_address))
                                    <div class="col-12">



                                        <label class="mb-2 pt-2 sign_fontsize">Address :</label>



                                        <p type="text" class="w-100 pb-2 mb-0">{{ $user->street_address }}</p>



                                    </div>
                                @endif



                            </div>







                            <?php
                            
                            $data2 = \App\ProfileLanguage::where('user_id', $user->id)->get();
                            
                            foreach ($data2 as $key => $value) {
                                $lang = $value;
                            }
                            
                            ?>



                            @if (isset($lang))
                                <div class="row">



                                    <div class="col-4">



                                        <ul class="list-inline pt-3  my-0">



                                            <li class="list-inline-item">Languages</li>



                                        </ul>



                                    </div>



                                    <div class="col-2">



                                        <ul class="list-inline pt-3  my-0">



                                            <li class="list-inline-item">Read</li>



                                        </ul>



                                    </div>



                                    <div class="col-2">



                                        <ul class="list-inline pt-3  my-0">



                                            <li class="list-inline-item ">Write</li>



                                        </ul>



                                    </div>



                                    <div class="col-2">



                                        <ul class="list-inline pt-3  my-0">



                                            <li class="list-inline-item">Speak</li>



                                        </ul>



                                    </div>



                                </div>



                                <hr class="mt-2  mb-0">



                                <div class="row">







                                    @foreach ($data2 as $data)
                                        <?php
                                        
                                        $language = isset($data->language_level) ? $data->language_level : '';
                                        
                                        $datas = isset($language) ? unserialize($language) : '';
                                        
                                        ?>











                                        <div class="col-4">



                                            <ul class="list-inline pt-3  my-0">



                                                <li class="list-inline-item">{{ $data->language }}</li>



                                            </ul>



                                        </div>



                                        <div class="col-2">



                                            <ul class="list-inline pt-3  my-0">



                                                <li class="list-inline-item pl-1">{{ in_array(1, $datas) ? '✔' : null }}
                                                </li>



                                            </ul>



                                        </div>



                                        <div class="col-2">



                                            <ul class="list-inline pt-3  my-0">



                                                <li class="list-inline-item pl-1">{{ in_array(2, $datas) ? '✔' : null }}
                                                </li>



                                            </ul>



                                        </div>



                                        <div class="col-2">



                                            <ul class="list-inline pt-3  my-0">



                                                <li class="list-inline-item pl-1">{{ in_array(3, $datas) ? '✔' : null }}
                                                </li>



                                            </ul>



                                        </div>
                                    @endforeach



                                </div>
                            @endif



                        </form>



                    </div>



                </div>



            </div>



        </div>



    </section>





    <div class="container">

        <div class="modal" id="recorded_video">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content modal_content_custom_width mx-auto p-3">

                    <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"
                            src="{{ asset('/') }}asset/images/close.png"></p>

                    <div class="modal-body py-0">

                        <div class="collection_pic-box text-center mt-2 mt-md-0">

                            <div class="collection_text pr-lg-3 py-0">

                                <h3 class="line_change font_size">Recorded Video Interview</h3>

                                <video width="100%" height="100%" controls id="videoElement"
                                    style=" max-height: 80vh;">

                                </video>

                            </div>

                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>



    @php

        $templates = DB::table('templates')
            ->where('company_id', Auth::guard('company')->user()->id)
            ->get();

    @endphp





    <!-- modal -->



    <div class="container">

        <!-- modal -->

        <div class="modal newmodalclass" id="emailmodal">

            <div class="modal-dialog">

                <div class="modal-content mx-auto" style="
    max-height: calc(100vh - 50px);
    overflow: auto;
">

                    <!-- header -->

                    <div class="alert alert-danger print-error-msg" style="display:none">

                        <ul></ul>

                    </div>



                    <form method="post" action="" enctype="multipart/form-data">

                        @csrf

                        <div class="col-12 pt-3">

                            <div class="row">

                                <div class="col-md-8">

                                    <h4 class="modal-title sign_head">Send Email</h4>

                                </div>

                                <div class="col-md-4">

                                    <p type="button" class="info" data-dismiss="modal"><img
                                            class="float-right modal_close-icon"
                                            src="{{ asset('/') }}asset/images/close.png"></p>

                                </div>

                            </div>

                        </div>

                        <!-- body -->

                        <div class="modal-body">

                            <div class="row">

                                <input type="hidden" value="{{ $user->id }}" name="id" id="id">

                                <input type="hidden" name="templateidsend" id="templateidsend" value="0">

                                @if (count($templates) > 0 && isset($templates))
                                    <div class="col-md-12 pb-2 mb-4">

                                        <select class="form-control" id="templatesend" name="template"
                                            style="width: 175px;background: #e3e3e3;float:right">

                                            <option selected value="">Select Templates</option>

                                            @foreach ($templates as $template)
                                                <option value="{{ $template->id }}">{{ $template->templatename }}
                                                </option>
                                            @endforeach

                                        </select>

                                        {{-- <span class="text-danger">

                                    <strong id="template-error-sec" class="new_error_class template-error"></strong>

                                </span> --}}

                                    </div>
                                @else
                                    <div class="col-md-12 pb-2 mb-4">

                                        <select class="form-control" style="width: 175px;background: #e3e3e3;float:right">

                                            <option selected disabled>No Templates</option>

                                        </select>

                                    </div>
                                @endif

                                <div class="col-md-12 pb-2">

                                    <textarea class="form-control" placeholder="Subject" aria-label="With textarea" id="subject" name="subject"
                                        rows="1"></textarea>

                                    <span class="text-danger">

                                        <strong id="subject-error" class="new_error_class"></strong>

                                    </span>

                                </div>

                                <div class="col-md-12 pb-2">

                                    <textarea class="form-control summernote" placeholder="Message" name="message" id="message"
                                        aria-label="With textarea" rows="3"></textarea>

                                    <span class="text-danger">

                                        <strong id="message-error" class="new_error_class "></strong>

                                    </span>

                                </div>

                                <div class="col-md-12 pb-2 mt-5">

                                    <label>Save Template <span class="text-danger">*</span></label>

                                    <a href="{{ url('email-templates') }}" target="_blank"
                                        style="float: right;margin-right: 10px;">Edit</a>

                                    <input class="form-control" placeholder="Template Name" id="sendname"
                                        name="name" rows="1"></textarea>

                                    <span class="text-danger">

                                        <strong id="templatesend-error-sec" class="new_error_class name-error"></strong>

                                    </span>

                                    <span class="text-danger">

                                        <strong id="sendname-error" class="new_error_class name-error"></strong>

                                    </span>

                                </div>



                            </div>

                        </div>

                        <div class="modal-footer justify-content-end px-3">

                            <button type="button" class="btn btn-secondary py-2 mr-3"
                                data-dismiss="modal">Cancel</button>

                            <button type="button" id="preview"
                                class="signin_button px-4 py-2 emailsend rounded">Preview</button>

                            <button type="submit" id="formSubmit"
                                class="signin_button px-4 py-2 emailsend rounded">Send</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>



    <div class="container">
        <div class="modal newmodalclass" id="previewmodal">
            <div class="modal-dialog">
                <div class="modal-content mx-auto">
                    <!-- header -->
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="col-12 pt-3">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="modal-title sign_head">Preview Email</h4>
                            </div>
                            <div class="col-4">
                                <p type="button" class="info" data-dismiss="modal"><img
                                        class="float-right modal_close-icon"
                                        src="{{ asset('/') }}asset/images/close.png"></p>
                            </div>
                        </div>
                        <!-- body -->
                        <div class="modal-body">
                            <table border="0" cellpadding="0" cellspacing="0" class="force-row"
                                style="width: 100%;    border-bottom: solid 1px #ccc;">
                                <tr>
                                    <td class="cols-wrapper" style="padding-left:12px;padding-right:12px">
                                        <table border="0" cellpadding="0" cellspacing="0" align="left"
                                            class="force-row" style="width: 100%;">
                                            <tr>
                                                <td class="row" valign="top"
                                                    style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        style="width:100%;">
                                                        <tr>
                                                            <td
                                                                style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:3px;text-align:left;padding-top: 42px;">
                                                                <b>Subject</b> :<span id="previewsubject"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;">
                                                                <b> Message</b> :<p id="previewmessage"></p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>
                                            @for ($i = 0; $i < 64; $i++)
                                                -
                                            @endfor
                                        </b>
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        style="font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;">
                                        <b>Disclaimer: </b>
                                        The sender of this email is registered with www.zeronoticeperiod.com as
                                        {{ Auth::guard('company')->user()->name }} using www.zeronoticeperiod.com
                                        services.
                                        The responsibility of checking the authenticity of offers/correspondence lies with
                                        you entirely.
                                        If you consider the content of this email inappropriate or spam, you may forward
                                        this email to:
                                        info@zeronoticeperiod.com. Please note this email is a private message from the
                                        recruiter.
                                        You are advised not to forward this email to protect your account from unauthorized
                                        access.

                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;">
                                        <b>General Advise :</b>
                                        Please do not pay any money to anyone who promises to find you a job.
                                        This could be in any form. The money could be asked for upfront or it could be asked
                                        after trust has been built after some communication has been exchanged.
                                        Please ensure you are not being scammed and in case you are suspicious please
                                        contact info@zeronoticeperiod.com for advise.
                                    </td>
                                </tr>
                            </table>



                        </div>

                        <div class="modal-footer justify-content-end px-3">

                            <button type="button" class="btn btn-secondary py-2 mr-3" id="previewclose">Back</button>



                        </div>

                    </div>

                </div>

            </div>

        </div>



    </div>

    <div class="container">



        <!-- modal -->



        <div class="modal" id="addfoldermodal">



            <div class="modal-dialog">



                <div class="modal-content mx-auto">



                    <!-- header -->







                    <div class="modal-header pb-0">



                        <h4 class="modal-title sign_head">Select Add Folder</h4>



                        <p type="button" class="info" data-dismiss="modal"><img class="float-right modal_close-icon"
                                src="{{ asset('/') }}asset/images/close.png"></p>



                    </div>



                    @if (count($collections) > 0)
                        <form method="POST" action="{{ url('add_resumes') }}" enctype="multipart/form-data"
                            id="add_folder_form">



                            @csrf



                            <div class="modal-body">



                                <div class="collection_pic-box text-center mt-4 mt-md-0">



                                    <div class="collection_text p-5">



                                        <input type="hidden" name="user_id" value="{{ $user->id }}">



                                        <select name="collection_id" id="" class="form-control">



                                            <option value="" selected disabled>Select Folder</option>



                                            @foreach ($collections as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach



                                        </select>



                                        <span class="help-block collection_id-error"></span>

                                        <div class="error_message1 " id=""></div>







                                    </div>



                                </div>



                            </div>



                            <div class="modal-footer justify-content-end px-3">



                                <button type="button" id="formSubmit" onclick="submitfolder();"
                                    class="signin_button px-4 py-2 rounded">Add Folder</button>



                                <button type="button" class="btn btn-secondary py-2 mr-3"
                                    data-dismiss="modal">Cancel</button>



                            </div>



                        </form>
                    @else
                        <div class="text-center p-3">



                            <a class="btn signin_button" href="{{ url('collections') }}">Create Folder</a>



                        </div>
                    @endif







                </div>



            </div>



        </div>



    </div>



    <div class="container">



        <!--add to folder modal -->



        <div class="modal" id="addfoldermodal1">



            <div class="modal-dialog">



                <div class="modal-content mx-auto">



                    <!-- header -->







                    <div class="modal-header pb-0">



                        <h4 class="modal-title sign_head">Select Report CV</h4>



                        <p type="button" class="info" data-dismiss="modal"><img class="float-right modal_close-icon"
                                src="{{ asset('/') }}asset/images/close.png"></p>



                    </div>







                    <form method="POST" action="" enctype="multipart/form-data" id="add_folder_form">

                        <div class="modal-body">


                            <span class="help-block user_id1-error"></span>


                            <div class="collection_pic-box text-center mt-4 mt-md-0">


                                <div class="collection_text p-5">


                                    <input type="hidden" name="user_id1[]" id="user_id1"
                                        value="{{ $user->id }}">


                                    <select name="report" id="report" class="form-control">

                                        <option value="" selected disabled>Select Option</option>

                                        <option value="Notice Period">Notice Period</option>
                                        <option value="Employed">Employed</option>
                                        <option value="Not looking for jobs">Not looking for jobs</option>

                                    </select>

                                    <span class="help-block report-error"></span>

                                    <div class="error_message1 " id=""></div>

                                </div>


                            </div>


                        </div>



                        <div class="modal-footer justify-content-end px-3">


                            <button type="button" id="form_Submit1"
                                class="signin_button px-4 py-2 rounded">Submit</button>



                            <button type="button" class="btn btn-secondary py-2 mr-3"
                                data-dismiss="modal">Cancel</button>



                        </div>



                    </form>


                </div>



            </div>



        </div>



    </div>



    <!--sms-send modal Start-->

    <div class="container">

        <!-- modal -->

        <div class="modal newmodalclass" id="sendsmsmodal">

            <div class="modal-dialog">

                <div class="modal-content mx-auto px-2 py-2">

                    <!-- header -->

                    <div class="alert alert-danger print-error-msg" style="display:none">

                        <ul></ul>

                    </div>



                    <form method="post" action="" enctype="multipart/form-data">

                        @csrf

                        <div class="col-12 pt-3">



                            <div class="row">

                                <div class="col-md-8">

                                    <h4 class="modal-title sign_head">Send SMS</h4>

                                </div>

                                <div class="col-md-4">

                                    <p type="button" class="info" data-dismiss="modal"><img
                                            class="float-right modal_close-icon"
                                            src="{{ asset('/') }}asset/images/cancel.png"></p>

                                </div>

                            </div>

                        </div>

                        <!-- body -->

                        <div class="modal-body">

                            <span class="help-block sms_user_id-error"></span>

                            <div class="row">



                                <input type="hidden" value="" name="send_sms_userid" id="send_sms_userid">



                                <div class="col-md-12 pb-2">

                                    <textarea class="form-control" placeholder="Message" name="sendmessage" id="sendmessage" aria-label="With textarea"
                                        rows="3"></textarea>



                                    <span class="help-block sendmessage-error"></span>

                                    <span class="text-danger">

                                        <strong id="sendmessage-error" class="new_error_class"></strong>

                                    </span>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer justify-content-end px-3">

                            <button type="button" class="btn btn-secondary py-2 mr-3"
                                data-dismiss="modal">Cancel</button>

                            <button type="button" id="send_sms_formsubmit"
                                class="signin_button px-4 py-2 emailsend rounded">Send</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>





    <div class="modal fade" id="rendermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <div class="d-flex justify-content-between col-11">
                        <h5 class="modal-title pt-3" id="exampleModalCenterTitle">Preview </h5> <a
                            href="{{ url('download-candidate-resum', $user->id) }}"
                             style="color: white" target="_blank"
                            class="py-2 signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3">Download Resume</a>
                    </div>



                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true"><img class="float-right modal_close-icon"
                                src="{{ asset('/') }}asset/images/close.png"></span>

                    </button>

                </div>

                <div class="modal-body">

                    <div id="pdf_container">

                    </div>

                </div>



            </div>

        </div>

    </div>

    <div class="modal fade" id="docrendermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <div class="d-flex justify-content-between col-11">
                        <h5 class="modal-title pt-3" id="exampleModalCenterTitle">Preview </h5>
                        <a href="{{ url('download-candidate-resum', $user->id) }}" style="color: white" target="_blank"
                            class="py-2 signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3">
                            Download Resume
                        </a>
                    </div>



                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true"><img class="float-right modal_close-icon"
                                src="{{ asset('/') }}asset/images/close.png"></span>

                    </button>

                </div>

                <div class="modal-body">

                    <div id="word-container" class=""></div>

                </div>



            </div>

        </div>

    </div>





    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf_viewer.min.css" rel="stylesheet"
        type="text/css" />



    <input type="hidden" id="docvalue" value="{{ asset('cvs/' . $user->resume) }}">



    <!-- modal end -->



    @include('includes.footer')



@endsection



@push('styles')
    <style type="text/css">
        .formrow iframe {



            height: 78px;



        }
    </style>
@endpush

<script type="text/javascript" src="https://unpkg.com/jszip/dist/jszip.min.js"></script>




@push('scripts')
    <script>
        $(document).ready(function() {


            $('textarea.summernote').summernote({
                placeholder: 'Write Your Message',
                tabsize: 2,
                height: 300,
                toolbar: [
                    //  ['style', ['style']],   
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']], 
                    //['fontname', ['fontname']],   
                    // ['fontsize', ['fontsize']],  
                    //  ['color', ['color']],   
                    ['para', ['ul', 'ol', 'paragraph']],
                    // ['height', ['height']],  
                    // ['table', ['table']],    
                    // ['insert', ['link']],   
                    // //['view', ['fullscreen', 'codeview']],  
                    // ['help', ['help']]   
                ],
                callbacks: {
                    onPaste: function(e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData)
                            .getData('Text');
                        e.preventDefault();
                        document.execCommand('insertText', false, bufferText);
                    }
                }


            });
        });
    </script>


    <script>
        function PreviewWordDoc() {

            //URL of the Word Document.

            var url = $("#docvalue").attr("value");



            $('#docrendermodal').modal('show');



            //Send a XmlHttpRequest to the URL.

            var request = new XMLHttpRequest();

            request.open('GET', url, true);

            request.responseType = 'blob';

            request.onload = function() {

                //Set the ContentType to docx.

                var contentType = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";



                //Convert BLOB to File object.

                var doc = new File([request.response], contentType);



                //If Document not NULL, render it.

                if (doc != null) {

                    //Set the Document options.

                    var docxOptions = Object.assign(docx.defaultOptions, {

                        useMathMLPolyfill: true

                    });

                    //Reference the Container DIV.

                    var container = document.querySelector("#word-container");



                    //Render the Word Document.

                    docx.renderAsync(doc, container, null, docxOptions);

                }



            };

            request.send();

        };









        var pdfjsLib = window['pdfjs-dist/build/pdf'];

        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';

        var pdfDoc = null;

        var scale = 1; //Set Scale for zooming PDF.

        var resolution = 2; //Set Resolution to Adjust PDF clarity.



        function LoadPdfFromUrl(url) {

            //Read PDF from URL.

            pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {

                pdfDoc = pdfDoc_;



                $('#rendermodal').modal('show');

                $('#pdf_container').empty();



                //Reference the Container DIV.

                var pdf_container = document.getElementById("pdf_container");

                pdf_container.style.display = "block";



                //Loop and render all pages.

                for (var i = 1; i <= pdfDoc.numPages; i++) {

                    RenderPage(pdf_container, i);

                }

            });

        };

        function RenderPage(pdf_container, num) {

            pdfDoc.getPage(num).then(function(page) {

                //Create Canvas element and append to the Container DIV.

                var canvas = document.createElement('canvas');

                canvas.id = 'pdf-' + num;

                ctx = canvas.getContext('2d');

                pdf_container.appendChild(canvas);



                //Create and add empty DIV to add SPACE between pages.

                var spacer = document.createElement("div");

                spacer.style.height = "20px";

                pdf_container.appendChild(spacer);



                //Set the Canvas dimensions using ViewPort and Scale.

                var viewport = page.getViewport({
                    scale: scale
                });

                canvas.height = resolution * viewport.height;

                canvas.width = resolution * viewport.width;



                //Render the PDF page.

                var renderContext = {

                    canvasContext: ctx,

                    viewport: viewport,

                    transform: [resolution, 0, 0, resolution, 0, 0]

                };



                page.render(renderContext);

            });

        };



        function myFunction() {

            // Get the text field

            var copyText = document.getElementById("myInput");



            // Select the text field

            copyText.select();

            copyText.setSelectionRange(0, 99999); // For mobile devices



            // Copy the text inside the text field

            navigator.clipboard.writeText(copyText.value);



            // Alert the copied text

            //alert("Copied the text: " + copyText.value);

            //$('[data-toggle="tooltip"]').tooltip();



        }

        $('.copytext[data-toggle="tooltip"]').tooltip({

            trigger: 'click'

        })



        $('.copytext').mouseleave(function() {

            $(this).tooltip('hide');

        });



        function submitfolder() {



            //  alert('helo');



            var form = $('#add_folder_form');



            $.ajax({



                url: form.attr('action'),



                type: form.attr('method'),



                data: form.serialize(),



                dataType: 'json',



                success: function(json) {



                    console.log(json);

                    $('#addfoldermodal').modal('hide');



                    $(".success_msg27").html(
                        "<div class='alert alert-success education_style'>{{ __('Resume added successfully') }}</div>"
                        );

                    setTimeout(function() {
                        $(".success_msg27").hide();
                    }, 5000);





                },



                error: function(json) {





                    // $('#addfoldermodal').modal('hide');



                    // $("#myElem1").show();



                    if (json.status == 422) {

                        // console.log(json.status);



                        //    $('#addfoldermodal').modal('hide');



                        //    $(".success_msg27").html("<div class='alert alert-success education_style'>{{ __('Resume already exists in this collection') }}</div>");





                        var resJSON = json.responseJSON;



                        $('.help-block').html('');



                        $.each(resJSON.errors, function(key, value) {



                            $('.' + key + '-error').html('<strong class="new_error_class">' + value +
                                '</strong>');



                            $('#div_' + key).addClass('has-error');



                        });



                    }

                    if (json.status == 400) {



                        // alert('error');

                        console.log(json.status);





                        $('#addfoldermodal').modal('hide');

                        $(".success_msg47").show();



                        $(".success_msg47").html(
                            "<div class='alert alert-danger education_style'>{{ __('Resume already exists in this collection') }}</div>"
                            );



                        setTimeout(function() {
                            $(".success_msg47").hide();
                        }, 5000);

                    }

                    if (json.status == 402) {





                        $(".error_message1").html(
                            "<div class='alert alert-danger education_style'>{{ __('The Maximum Folder Size is 100') }}</div>"
                            );

                    }



                }



            });



        }





        $(document).ready(function() {

            $('#formSubmit').click(function(e) {

                // alert('hello');



                $('#sendname-error').html("");

                $('#subject-error').html("");

                $('#message-error').html("");

                $('#templatesend-error-sec').html("");



                var template_id = $("#templatesend").val();





                $('.alert-danger').hide();

                document.getElementById('formSubmit').innerHTML = 'Sending..';

                e.preventDefault();

                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                    }

                });

                $.ajax({

                    url: "{{ route('emails.store') }}",

                    method: 'post',

                    data: {

                        id: $('#id').val(),

                        _token: "{{ csrf_token() }}",

                        subject: $('#subject').val(),

                        message: $('#message').val(),

                        template: template_id,

                        name: $('#sendname').val(),

                    },

                    success: function(result) {

                        // console.log(result);

                        if (result.success) {

                            $('.alert-danger').hide();

                            $('#emailmodal').modal('hide');

                            $("#myElem").show();

                            $('#subject').val('');

                            $("#message").summernote('code', '');

                            $('#subject').val('');

                            $('#sendname').val('');

                            $('#subject-error').val('');

                            $('#message-error').val('');

                            $('#templatesend-error-sec').val("");

                            $('#templateidsend').val('');

                            setTimeout(function() {
                                $("#myElem").hide();
                            }, 5000);

                        }

                        if (result.errors)

                        {

                            document.getElementById('formSubmit').innerHTML = 'Send';

                            // $( '#subject-error' ).html( result.errors[0] );

                            // $( '#message-error' ).html( result.errors[1] );



                            if (result.errors.subject) {

                                $('#subject-error').html(result.errors.subject[0]);

                            }

                            if (result.errors.template) {

                                $('#templatesend-error-sec').html(result.errors.template[0]);

                            }

                            if (result.errors.name) {

                                $('#sendname-error').html(result.errors.name[0]);

                            }

                            if (result.errors.message) {

                                $('#message-error').html(result.errors.message[0]);

                            }



                        }
                        if (result.errors1)

                        {

                            document.getElementById('formSubmit').innerHTML = 'Send';

                            if (result.errors1) {

                                alert(result.errors1);

                            }

                        }



                    }

                });

            });







        });









        {{ $user1->complete }}



        var value = Math.round({{ $user1->complete }} / 16 * 100)



        console.log(value);



        if (value > 100) {



            value = 100



        }



        $("#profile_complete").attr("data-percentage", value.toString());







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







        $('#templatesend').change(function() {



            var template_id = $("#templatesend").val();



            //alert(template_id);



            $.ajax({

                url: "{{ route('get.template') }}",

                method: 'POST',

                data: {

                    _token: "{{ csrf_token() }}",

                    id: template_id,



                },



                success: function(result) {



                    console.log(result.data.templatename);



                    if (result.data.templatename != null)

                    {

                        $('#templateidsend').val(result.data.id);

                    } else {

                        $('#templateidsend').val('');

                    }



                    $('#subject').val(result.data.subject);


                    $("#message").summernote('code', result.data.message);


                },

                error: function(json) {





                    if (json.status == 422) {



                        var resJSON = json.responseJSON;



                        $('.help-block').html('');



                        $.each(resJSON.errors, function(key, value) {



                            //  alert(key);



                            $('.' + key + '-error').html('<strong class="new_error_class">' +
                                value + '</strong>');



                            $('#div_' + key).addClass('has-error');



                        });



                    }

                }

            });





        });







        $("#preview").click(function() {



            var subject = $('#subject').val();

            var description = $('#message').val();



            // alert(subject);



            $('#previewsubject').html(subject);

            $('#previewmessage').html(description);



            $("#emailmodal").modal('hide');



            $("#previewmodal").modal('show');



        });

        $("#previewclose").click(function() {





            $("#emailmodal").modal('show');



            $("#previewmodal").modal('hide');



        });

        $('#form_Submit1').click(function(e) {

            //    alert('test');

            // document.getElementById("overlay").style.display = "block";



            document.getElementById('form_Submit1').innerHTML = 'Sending..';



            // document.getElementsByClassName('names')



            e.preventDefault();



            //    $( '#description-error' ).html( "" );

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                }

            });

            $.ajax({

                url: "{{ url('reportcv') }}",

                method: 'POST',

                data: {

                    user_id1: $('#user_id1').val(),

                    report: $('#report').val(),

                    _token: "{{ csrf_token() }}",

                },

                success: function(result) {

                    console.log(result);

                    if (result.success) {

                        $('.alert-danger').hide();

                        $('#addfoldermodal1').modal('hide');

                        // $("#success_msg27").show();

                        $('#user_id').val('');

                        $('#report').val('');



                        $(".success_msg27").html(
                            "<div class='alert alert-success education_style'>{{ __('Report Updated') }}</div>"
                            );

                        setTimeout(function() {
                            $(".success_msg27").hide();
                            location.reload();
                        }, 1000);



                    }



                },

                error: function(json) {





                    if (json.status == 422) {





                        var resJSON = json.responseJSON;



                        $('.help-block').html('');



                        $.each(resJSON.errors, function(key, value) {



                            $('.' + key + '-error').html('<strong class="new_error_class">' +
                                value + '</strong>');



                            $('#div_' + key).addClass('has-error');



                        });



                    }



                    if (json.status == 402) {



                        $(".error_message1").html(
                            "<div class='alert alert-danger education_style'>{{ __('The Maximum Folder Size is 100') }}</div>"
                            );

                    }



                }

            });

        });


        function recordedmodal(id) {

            $dta = $('.modalid' + id).val();



            var dta = $('.modalid' + id).val();
            $('#videoElement').replaceWith(
                '<video id="videoElement" width="100%" height="100%"   style=" max-height: 80vh;" controlsList="nodownload" controls><source src="' +
                dta + '" type="video/mp4"></video>');
            $('#recorded_video').modal({
                backdrop: 'static'
            });
            $('#recorded_video').modal('show');
        }


        var isExpanded = false; // Variable to track the state

        function showMore() {
            var recruiterComments = document.getElementById("recruiter-comments");
            var moreContent = document.getElementById("more-content");
            var button = document.getElementById("more-button");

            if (!isExpanded) {
                moreContent.style.display = "inline"; // Show the full content
                recruiterComments.style.display = "none"; // Hide the limited portion
                button.innerHTML = "Less";
            } else {
                moreContent.style.display = "none"; // Hide the full content
                recruiterComments.style.display = "inline"; // Show the limited portion
                button.innerHTML = "More";
            }

            isExpanded = !isExpanded; // Toggle the state
        }
    </script>
@endpush
