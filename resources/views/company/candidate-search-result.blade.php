<?php
function maskedData($name)
{
    $length = strlen($name);
    if ($length <= 2) {
        return $name;
    }
    $firstChar = substr($name, 0, 1);
    $maskedChars = str_repeat('*', $length - 1);
    return $firstChar . $maskedChars;
}
?>
@forelse ($users as $user)



    <?php
    
    $now = \Carbon\Carbon::now();
    
    $todayDate = \Carbon\Carbon::now()->format('Y-m-d');
    
    //    echo($todayDate);
    
    $user_detail = \App\ProfileCityJobsCity::where('user_id', $user->id)->first();
    
    //echo $company;
    
    $summary = \App\ProfileSummary::where('user_id', $user->id)->first();
    
    $notice_period = \App\ProfileNop::where('user_id', $user->id)->first();
    
    $noticed = isset($notice_period) ? $notice_period->nop_days : '';
    
    //    echo($noticed);
    
    if (isset($noticed) && !empty($noticed)) {
        if ($noticed == 1) {
            $days = 'Immediately available';
        } elseif ($noticed == 2) {
            $period = $notice_period->last_working_day;
    
            $datetime1 = strtotime($todayDate); // convert to timestamps
    
            $datetime2 = strtotime($period); // convert to timestamps
    
            if ($datetime1 < $datetime2) {
                $days = (int) (($datetime2 - $datetime1) / 86400);
            } else {
                $days = 'Immediately available';
            }
        } elseif ($noticed == 3) {
            $days = 'Buyable Notice Period';
        } else {
            $days = 'Not Under Notice Period';
        }
    }
    
    // echo($period);
    
    // echo($days);
    
    $data2 = \App\ProfileSummary::where('user_id', $user->id)->first();
    
    $experience = isset($data2) ? $data2->totalexp : '';
    
    $latestdesg = isset($data2) ? $data2->latestdesg : '';
    
    $latestcom = isset($data2) ? $data2->latestcom : '';
    
    //   echo $t
    
    $data3 = \App\ProfileDetails::where('user_id', $user->id)->first();
    // dd($data3);
    $ctc = isset($data3) ? $data3->expect_ctc_lakhs : '';
    
    $ectc = isset($data3) ? $data3->expect_ctc_lakhs3 : '';
    
    $user12 = \App\User::where('id', $user->id)->first();
    
    // if(isset($high_education))
    
    // {
    
    //$final = \App\ProfileEducation::where('user_id', $user->id)->first();
    
    // }
    
    $educations = \App\ProfileEducation::where('user_id', $user->id)->get();
    $lowestHighValueEducation = null;
    
    foreach ($educations as $edu) {
        $education = \App\Education::find($edu->degree_title);
    
        if (!$lowestHighValueEducation || $education->high_value < $lowestHighValueEducation->high_value) {
            $lowestHighValueEducation = $education;
        }
    }
    $final = null;
    if ($lowestHighValueEducation) {
        $final = \App\ProfileEducation::where('user_id', $user->id)
            ->where('degree_title', $lowestHighValueEducation->id)
            ->first();
    }
    
    if (isset($final)) {
        $institute = \App\Degree::where('id', $final->organization)->first();
    
        $course = \App\Course::where('id', $final->course)->first();
    }
    
    $employer_payment = \App\EmployerPayment::where('company_id', Auth::guard('company')->user()->id)
        ->where('payment_status', 1)
        ->where('user_id', $user->id)
        ->orderBy('id', 'desc')
        ->first();
    
    ?>



    @php

        if (isset($notice_period->last_working_day) && !empty($notice_period->last_working_day)) {
            $date = $notice_period->last_working_day;

            $datetime1 = strtotime($todayDate); // convert to timestamps

            $datetime2 = strtotime($date); // convert to timestamps
        }
        // dd($user->prefered_city);

        $location_values_un = unserialize($user->prefered_city);

        if (isset($location_values_un) && !empty($location_values_un)) {
            $count = count($location_values_un);

            $two_value = array_slice($location_values_un, 0, 2);
        }

        if (isset($two_value) && !empty($two_value)) {
            $location_values = implode(', ', $two_value);
        }

    @endphp
    <?php
    
    $com_id = Auth::guard('company')->user()->id;
    
    $company = \App\Company::where('id', $com_id)->first();
    
    $unlock = \App\Unlocked_users::where('company_id', Auth::guard('company')->user()->id)
        ->where('unlocked_users_ids', $user->id)
        ->first();
    
    ?>





    <div class="boxing  rounded px-4">



        <div class="row">



            <div class="col-12 pt-3 select_input_cus">

                <!-- <div class="col-lg-8 col-xl-9 pt-3 select_input_cus"> -->

                <input type="checkbox" class="email_checkbox mail_send-box text-left" value="{{ $user->id }}">

                <ul class="list-inline mb-1 d-flex">



                    <li class="list-inline-item font_color">

                        <h4 class=" mb-4 mb-sm-0 sign_head ">
                            @if ($unlock || $company->package_end_date > $now)
                                {{ $user->first_name }}
                            @else
                                {{ maskedData($user->first_name) }}
                            @endif

                        </h4>

                    </li>
                    @if ($user->verified == 1)
                        <li class="sign_head list-inline v-icon stick_label">Recruiter Verified</li>
                    @endif
                    {{-- @if ($user->verified == 2)
                    <li class="sign_head list-inline research">Researched</li>
                @endif  --}}

                </ul>

                <ul class="list-inline job_view">



                    <li class="list-inline-item font_color">{{ $summary->latestdesg ?? '' }}

                    </li>

                    <li class="list-inline-item"><span>Latest Company:</span>
                        @if ($unlock || $company->package_end_date > $now)
                            {{ $summary->latestcom }}
                        @else
                            {{ maskedData(trim($summary->latestcom)) }}
                        @endif
                    </li>



                    <li class="list-inline-item"><span>Exp:</span> {{ $experience ?? '' }}</li>



                    <li class="list-inline-item"><span>Curr. Location:</span> {{ $user->current_city }}</li>



                    @if (isset($location_values) && !empty($location_values))
                        <li class="list-inline-item">
                            {{-- {{ dd($location_values) }} --}}


                            <span>Pref. Location:</span>

                            @if ($count > 2)
                                {{ $location_values ?? '' }} <span class="candidate_view-more mb-0 "
                                    style="color: #197ff3;">More +</span>
                            @else
                                {{ $location_values ?? '' }}
                            @endif



                        </li>
                    @endif



                    <li class="list-inline-item"><span>CTC:</span> {{ $ctc }} LPA</li>



                    <li class="list-inline-item"><span>ECTC:</span> {{ $ectc }} LPA</li>



                    @if ($days != 0 && isset($datetime1))
                        <li class="list-inline-item"><span>Notice Period:</span> {{ $days }}

                            @if ($datetime1 < $datetime2)
                                days (Serving Notice)
                            @endif
                        </li>
                    @else
                        <li class="list-inline-item"><span>Notice Period:</span> {{ $days }}

                        </li>
                    @endif
                    <li class="list-inline-item"><span>Highest Education:</span> {{ $course->course ?? '' }}
                        {{ $final ? ($final->year_of_completion ? '(' . $final->year_of_completion . ')' : '') : '' }}
                    </li>



                    <li class="list-inline-item"><span>Institution:</span> {{ $institute->educations ?? '' }}


                        @if (isset($data3->work_type))
                    <li class="list-inline-item pr-5"><span>Pref. Work Type:</span>

                        {{ $data3->work_type ?? '' }}</li>
@endif
@if (isset($data3->candidate_wfh))
    <li class="list-inline-item pr-5"><span>Pref. Work Mode:</span>
        @if ($data3->candidate_wfh == '1')
            Remote
        @elseif($data3->candidate_wfh == '2')
            Hybrid
        @elseif($data3->candidate_wfh == '3')
            Work From Office
        @elseif($data3->candidate_wfh == '4')
            Flexible
        @endif
    </li>
@endif

@php

    $interview_date = \App\Interview::where('user_id', $user->id)
        ->where('date', '>=', date('Y-m-d'))
        ->orderBy('date', 'asc');

    $interview_date_list = $interview_date->get();

    $num_count = 0;

    $num_of_items = $interview_date->count();

@endphp



@php

    $interview = [];

    foreach ($interview_date_list as $melson) {
        if (array_key_exists(date('M', strtotime($melson->date)), $interview)) {
            $interview[date('M', strtotime($melson->date))] =
                $interview[date('M', strtotime($melson->date))] . ',' . date('d', strtotime($melson->date));
        } else {
            $interview[date('M', strtotime($melson->date))] = date('d', strtotime($melson->date));
        }
    }

@endphp



@if (isset($interview_date_list) && count($interview_date_list) > 0)
    <li class="list-inline-item pr-5"><span>Video Interview: </span>

        @foreach ($interview as $key => $item)
            {{ $key }} {{ $item }}
        @endforeach

    </li>
@endif

@if ($user->recruiter_comments)
    <li class="list-inline-item pr-5">
        <span>Recruiter Comments:</span>

        @if (strlen($user->recruiter_comments) > 100)
            <span class="limited-content recruiter-comments">
                {{ \Illuminate\Support\Str::limit($user->recruiter_comments, 100) }}
            </span>
            <span class="full-content recruiter-comments" style="display: none;">
                {{ $user->recruiter_comments }}
            </span>
            <button class="toggle-button" id="more-button" onclick="showMore(this)">More</button>
        @else
            <span class="recruiter-comments">{{ $user->recruiter_comments }}</span>
        @endif
    </li>
@endif



</ul>



<?php

$keyskill = \App\KeySkill::where('user_id', $user->id)

    ->take(10)

    ->get();

//  $t4=(isset($skill) ? $skill->keyskill:'');

//  echo $skill

?>



<div class="section_2 pb-0">



    <ul class="list-inline">





        @if (count($keyskill) < 10)
            @foreach ($keyskill as $skill)
                <?php
                
                $job_skill = \App\JobSkill::where('id', $skill->keyskill)->first();
                
                ?>

                <li class="list-inline-item terms mb-1">





                    @if (str_contains($job_skill->job_skill, $key->job_skill ?? '') && !empty($key->job_skill))
                        <span
                            style="background-color:yellow">{{ isset($job_skill->job_skill) ? $job_skill->job_skill : '' }}
                        </span>
                    @else
                        <span>{{ isset($job_skill->job_skill) ? $job_skill->job_skill : '' }} </span>
                    @endif



                </li>
            @endforeach
        @else
            @foreach ($keyskill as $skill)
                <?php
                
                $job_skill = \App\JobSkill::where('id', $skill->keyskill)->first();
                
                ?>







                <li class="list-inline-item terms mb-1">

                    {{ isset($job_skill->job_skill) ? $job_skill->job_skill : '' }}

                </li>
            @endforeach

            <li class="list-inline-item terms mb-1">

                <p class="candidate_view-more mb-0 " style="color: #197ff3;" data-toggle="tooltip" data-placement="top"
                    title="To Know more click View Resume">More +</p>

            </li>
        @endif





    </ul>



</div>



</div>











<div class="col-12 border-top pt-3 mt-3 cv-search-btns">

    <div class="d-md-flex align-items-center justify-content-between">

        <div class="d-flex flex-wrap justify-content-center">

            @if ($company->package_end_date > $now)
            
                @if ($user->resume)
                    @php

                        $str = "$user->resume";

                        $parts = explode('.', $str);

                        $result = end($parts);

                    @endphp
                    <!--<a href="{{ url('download-candidate-resum', $user->id) }}" style="color: white" target="_blank" class="py-2 down-btn px-2 px-sm-3 mr-1 mr-sm-3">View/Download Resume</a>  -->

                    @if ($result == 'pdf')
                        <button type="button" id="pdfbtnPreview" class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                        title="CV Access : {{ $company->availed_cvs_quota }}/{{ $company->cvs_quota }}" 
                        onclick="LoadPdfFromUrl('{{ asset('cvs/' . $user->resume) }}','{{ $user->id }}')"><i class="fa fa-file-pdf-o mr-2"
                                aria-hidden="true"></i>View CV</button>
                    @endif



                    @if ($result == 'docx')
                        @php $u_resume = asset('cvs/' . $user->resume); @endphp
                        <button type="button" id="pdfbtnPreview" class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                        title="CV Access : {{ $company->availed_cvs_quota }}/{{ $company->cvs_quota }}" 
                        onclick="PreviewWordDoc('{{ $u_resume }}','{{ $user->id }}')"><i class="fa fa-file-pdf-o mr-2"
                                aria-hidden="true"></i>View CV</button>
                    @endif
                @endif
                
                <button type="submit" class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                    title="Email Quota : {{ $company->availed_email_quota }}/{{ $company->email_quota }}"
                    onclick="sendemail({{ $user->id }})"><i class="fa fa-envelope-o mr-2"
                        aria-hidden="true"></i>Send Email</button>

                <a class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                    title="CV Access : {{ $company->availed_cvs_quota }}/{{ $company->cvs_quota }}"
                    href="{{ route('candidate.profile1', $user->id) }}" target="_blank">

                    @if ($unlock)
                        <!-- <img class="pr-1" src="{{ asset('asset/images/tick.png') }}"> -->

                        <i class="fa fa-check mr-2" aria-hidden="true"></i>

                        Viewed Profile
                    @else
                        <i class="fa fa-file-pdf-o  mr-2" aria-hidden="true"></i>View Profile
                    @endif


                </a>



                <!--@if ($company->is_freeze == 0)
-->

                <!--        <button type="submit" class="btn btn-sent mb-2 mb-sm-0 mr-2"  data-toggle="modal" data-target="#kyc"-->

                <!--        ><i class="fa fa-envelope-o mr-2" aria-hidden="true"></i>Send Email</button>-->

            <!--@else-->



                <!--
@endif-->

                <!--@if ($user->recorded_video)
-->

                <!--<button type="submit"  class="btn btn-sent mb-2 mb-sm-0 mr-2"   onclick="recordedmodal({{ $user->id }})"-->

                <!--        ><i class="fa fa-envelope-o mr-2" aria-hidden="true"></i>View Interview</button>-->
                <!--        <input type="hidden" class="modalid{{ $user->id }}" value="{{ asset('cvs/' . $user->recorded_video) }}">-->

                <!--
@endif    -->

                @if ($user->recorded_video)
                    @if ($employer_payment && ($employer_payment->payment_method == 3 || $employer_payment->singlecv_videointerview == 1))
                        <button type="submit" class="btn btn-sent mb-2 mb-sm-0 mr-2"
                            onclick="recordedmodal({{ $user->id }})"><i class="fa fa-envelope-o mr-2"
                                aria-hidden="true"></i>View Interview</button>
                        <input type="hidden" class="modalid{{ $user->id }}"
                            value="{{ asset('cvs/' . $user->recorded_video) }}">
                    @else
                        <a class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                            title="To View Video Interview Unlock the CV"
                            href="{{ route('candidate.profile1', $user->id) }}" target="_blank">


                            <i class="fa fa-file-pdf-o  mr-2" aria-hidden="true"></i>View Interview

                        </a>
                    @endif
                @endif
            @elseif ($unlock)
                <a class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top" title=""
                    href="{{ route('candidate.profile2', $user->id) }}" target="_blank">

                    <i class="fa fa-check mr-2" aria-hidden="true"></i>
                    Viewed Resume
                </a>
                <button type="submit" class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip"
                    data-placement="top" title="Email Quota Used: {{ $unlock->remaining_emails }}/5"
                    onclick="sendemail({{ $user->id }})"><i class="fa fa-envelope-o mr-2"
                        aria-hidden="true"></i>Send Email</button>

                @if ($user->recorded_video)
                    @if ($employer_payment && ($employer_payment->payment_method == 3 || $employer_payment->singlecv_videointerview == 1))
                        <button type="submit" class="btn btn-sent mb-2 mb-sm-0 mr-2"
                            onclick="recordedmodal({{ $user->id }})"><i class="fa fa-envelope-o mr-2"
                                aria-hidden="true"></i>View Interview</button>
                        <input type="hidden" class="modalid{{ $user->id }}"
                            value="{{ asset('cvs/' . $user->recorded_video) }}">
                    @else
                        <a class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                            title="To View Video Interview Unlock the CV"
                            href="{{ route('candidate.profile2', $user->id) }}" target="_blank">


                            <i class="fa fa-file-pdf-o  mr-2" aria-hidden="true"></i>View Interview
                        </a>
                    @endif
                @endif
            @elseif ($company->free_cv_access < 0)
                <a class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                    title="CV Access : {{ $company->availed_cvs_quota ?? '0' }}/3"
                    href="{{ route('candidate.profile1', $user->id) }}" target="_blank">

                    @if ($unlock)
                        <!-- <img class="pr-1" src="{{ asset('asset/images/tick.png') }}"> -->

                        <i class="fa fa-check mr-2" aria-hidden="true"></i>

                        Viewed Resume
                    @else
                        <i class="fa fa-file-pdf-o  mr-2" aria-hidden="true"></i>View Resume
                    @endif

                </a>

                <a class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                    title="Purchase a CV" href="{{ route('employer.buy.cv', $user->id) }}" target="_blank">

                    <i class="fa fa-file-pdf-o  mr-2" aria-hidden="true"></i>Send Email
                </a>

                @if ($user->recorded_video)
                    @if ($employer_payment && ($employer_payment->payment_method == 3 || $employer_payment->singlecv_videointerview == 1))
                        <button type="submit" class="py-2 signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3"
                            onclick="recordedmodal({{ $user->id }})">View Interview</button>
                        <input type="hidden" class="modalid{{ $user->id }}"
                            value="{{ asset('cvs/' . $user->recorded_video) }}">
                    @else
                        <button type="submit" data-id="{{ $user->id }}"
                            class="btn alertmodal btn-sent mb-2 mb-sm-0 mr-2" data-toggle="modal"
                            data-target="#alertmodal">
                            <i class="fa fa-envelope-o mr-2" aria-hidden="true"></i>View Interview
                        </button>
                    @endif
                @endif
            @else
                <a class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                    title="Buy Now" href="javascript:void(0)">

                    @if ($unlock)
                        <!-- <img class="pr-1" src="{{ asset('asset/images/tick.png') }}"> -->

                        <i class="fa fa-check mr-2" aria-hidden="true"></i>

                        Viewed Resume
                    @else
                        <i class="fa fa-file-pdf-o  mr-2" aria-hidden="true"></i>View Resume
                    @endif
                </a>

                <a class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                    title="Buy Now" href="javascript:void(0)">

                    <i class="fa fa-file-pdf-o  mr-2" aria-hidden="true"></i>Send Email

                </a>


                @if ($user->recorded_video)
                    @if ($employer_payment && ($employer_payment->payment_method == 3 || $employer_payment->singlecv_videointerview == 1))
                        <button type="submit" class="py-2 signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3"
                            onclick="recordedmodal({{ $user->id }})">View Interview</button>
                        <input type="hidden" class="modalid{{ $user->id }}"
                            value="{{ asset('cvs/' . $user->recorded_video) }}">
                    @else
                        <button type="submit" data-id="{{ $user->id }}"
                            class="btn alertmodal btn-sent mb-2 mb-sm-0 mr-2" data-toggle="modal"
                            data-target="#alertmodal">
                            <i class="fa fa-envelope-o mr-2" aria-hidden="true"></i>View Interview
                        </button>
                    @endif
                @endif





                <a class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                    title="Buy Now" {{-- href="{{ route('employer.buy.cv', $user->id) }}" target="_blank"  --}}
                     href="{{ route('pricing') }}" >

                    <i class="fa fa-file-pdf-o  mr-2" aria-hidden="true"></i>Buy Now
                </a>
            @endif


            <!--<button type="submit" class="btn btn-sent mb-2 mb-sm-0 mr-2" onclick="sendsms({{ $user->id }})"><i class="fa fa-commenting-o mr-2" aria-hidden="true"></i>Send SMS</button>-->

        </div>



        <div class="d-flex justify-content-center align-items-center view-in-resume pt-2 pt-sm-3 pt-md-0">

            <div class="mr-3" style="font-size: 12px;color:#8c8080;cursor:default"> ID: {{ $user->id }}</div>


            <div class="mr-3"><i class="fa fa-envelope-open pr-2"></i><span>{{ $user->no_of_emails ?? '0' }}</span>
            </div>

            <div><i class="fa fa-download pr-2"></i><span>{{ $user->no_of_downloads ?? '0' }}</span></div>

        </div>

    </div>

</div>



<input type="hidden" value="{{ $user->phone ?? '' }}" id="phone_number" class="phone_number">




<div class="joblist">
    @if ($data3->work_type == 'Contract')
        <p class="list-inline-item-1 mb-0 layoff-cv" data-toggle="tooltip" data-placement="top"
            title='"Contract CV" (CV of Contract Jobseeker)' style="background-color: gray;">
            Open to {{ $data3->work_type }}</p>
    @endif



    @if ($user->reason_moved == 'Lay Offs')
        <p class="list-inline-item-1 mb-0 layoff-cv" data-toggle="tooltip" data-placement="top"
            title='"Layoff CV" (CV of Jobseeker laid off at work)'>
            Layoff CV</p>
    @endif



    @if ($user->package_end_date > $now)
        <p class="list-inline-item mb-0 express-job" data-toggle="tooltip" data-placement="top"
            title='“Xpress Jobseeker” (Jobseeker has updated Video Interview availability)'>

            Xpress Job Seeker</p>
    @endif

</div>



</div>



</div>




@empty

<h4 style="

        text-align: center;

        font-size: 30px;

    ">

    "No Search Results Found!"</h4>

@endforelse
<script>
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });
</script>
