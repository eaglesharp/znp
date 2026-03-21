@foreach($jobs as $job)

@php
    $company = Auth::guard('company')->user();
    $now = \Carbon\Carbon::now();
    $data2 = \App\ProfileSummary::where('user_id', $job->user->id)->first();
    $experience = isset($data2) ? $data2->totalexp : '';
    $latestdesg = isset($data2) ? $data2->latestdesg : '';
    $latestcom = isset($data2) ? $data2->latestcom : '';
    $user = $job->user;

    

   
    $todayDate = \Carbon\Carbon::now()->format("Y-m-d");

    //    echo($todayDate);

    $user_detail = \App\ProfileCityJobsCity::where("user_id", $user->id)->first();

    //echo $company;

    $summary = \App\ProfileSummary::where("user_id", $user->id)->first();

    $notice_period = \App\ProfileNop::where("user_id", $user->id)->first();

    $educations = \App\ProfileEducation::where("user_id", $user->id)->get();

    $noticed = isset($notice_period) ? $notice_period->nop_days : "";

    //    echo($noticed);

    if (isset($noticed) && !empty($noticed)) {
        if ($noticed == 1) {
            $days = "Immediately available";
        } elseif ($noticed == 2) {
            $period = $notice_period->last_working_day;

            $datetime1 = strtotime($todayDate); // convert to timestamps

            $datetime2 = strtotime($period); // convert to timestamps

            if ($datetime1 < $datetime2) {
                $days = (int) (($datetime2 - $datetime1) / 86400);
            } else {
                $days = "Immediately available";
            }
        } elseif ($noticed == 3) {
            $days = "Buyable Notice Period";
        } else {
            $days = "Not Under Notice Period";
        }
    }



        $data2 = \App\ProfileSummary::where("user_id", $user->id)->first();

        $experience = isset($data2) ? $data2->totalexp : "";

        $latestdesg = isset($data2) ? $data2->latestdesg : "";

        $latestcom = isset($data2) ? $data2->latestcom : "";

        //   echo $t

        $data3 = \App\ProfileDetails::where("user_id", $user->id)->first();

        $ctc = isset($data3) ? $data3->expect_ctc_lakhs : "";

        $ectc = isset($data3) ? $data3->expect_ctc_lakhs3 : "";

        $user12 = \App\User::where("id", $user->id)->first();

        foreach ($educations as $education) {
            $high_education = \App\Education::where("id", $education->degree_title)
                ->where("high_value", 1)
                ->orWhere("high_value", 2)
                ->orWhere("high_value", 3)
                ->first();
        }

        if (isset($high_education)) {
            $final = \App\ProfileEducation::where("user_id", $user->id)
                ->where("degree_title", $high_education->id)
                ->first();
        }

        if (isset($final)) {
            $institute = \App\Degree::where("id", $final->organization)->first();

            $course = \App\Course::where("id", $final->course)->first();
        }

        if(isset($notice_period->last_working_day) && !empty($notice_period->last_working_day))

        {        
        

        $date = $notice_period->last_working_day;

        $datetime1 = strtotime($todayDate); // convert to timestamps

        $datetime2 = strtotime($date); // convert to timestamps



        }

        $keyskill = \App\KeySkill::where('user_id', $user->id)

        ->take(10)

        ->get();

       
       
        // $location_values_un =  unserialize($user->prefered_city);



        // if(isset($location_values_un) && !empty($location_values_un))

        // {

        //     $count = count($location_values_un);

        //     $two_value = array_slice($location_values_un,0,2);

        // }


        // if(isset($two_value) && !empty($two_value))

        // {

        //     $location_values =  implode(', ', $two_value);

        // }
   

@endphp

<div class="col-12 boxing rounded justify-content-center bg-white mt-4 py-4">
    <div class="row">
        <div class="col-lg-1 pr-0 mr-0 text-lg-center text-start col-3">
            @if($job->user->image)
              <img src="{{ asset('user_images/'.$job->user->image) }}" width="50px" height="50px" class="rounded-circle">
             @else
             <img src="{{asset('/')}}asset/images/profile.png">
            @endif
            
        </div>
        <div class="col-lg-9 select_input_cus bg-white pl-0 ml-0 col-9">
                <h2 class="line_change">{{ $job->job_title??'' }}</h2>
                <p class="m-0 text-muted font-weight-bold">{{ $job->user->first_name }}</p>
                <p class="m-0    " style="color: #197ff3">{{ $latestdesg   }}</p>
                <p class="text-muted font-weight-bold">{{ $job->location??'' }}</p>
        </div>
        <div class="col-lg-2 select_input_cus bg-white pl-0 ml-0 col-9 my-auto cv-search-btns">
            @php
            $view=[];
            if($jobData->resume_view){
                $view = json_decode($jobData->resume_view,true);
            }
            @endphp
            @if ( count($view) < 3 || in_array($job->user->id,  $view)|| in_array($job->user->id,  $unlocked_cvs))
                <a class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                    title="View Resume"
                    href="{{ route('view.applicant.profile', ['job_id'=>$job->job_id , 'id'=>$job->user->id]) }}" target="_blank">
                    <i class="fa fa-file-pdf-o  mr-2" aria-hidden="true"></i>
                    @if(in_array($job->user->id,  $view))
                    View Resume 
                    @else
                    View Resume 
                    @endif
                </a>
            @else
                <a class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"
                    title="Buy Resume"
                    href="{{ route('employer.buy.cv', $user->id) }}" target="_blank">
                    <i class="fa fa-file-pdf-o  mr-2" aria-hidden="true"></i>
                    Buy Resume
                </a>
                
            @endif

                
              

        </div>

        <div class="col-12">
            {{-- <p class="m-0 pt-2 px-lg-4"><span class="font-weight-bold">Message : </span>{{ $job->coverletter }}</p> --}}
            <ul class="list-inline job_view ">


                <li class="list-inline-item"><span>Latest Company:</span>

                    {{ $summary->latestcom??'' }} </li>



                <li class="list-inline-item"><span>Exp:</span> {{ $experience??'' }}</li>



                <li class="list-inline-item"><span>Curr. Location:</span> {{ $user->current_city }}</li>



                @if(isset($location_values)  && !empty($location_values))



                <li class="list-inline-item">



                    <span>Pref. Location:</span>



                 @if($count > 2)

                 {{ $location_values??''}} <span class="candidate_view-more mb-0 " style="color: #197ff3;"

                 >More +</span>

                 @else

                 {{ $location_values??''}}

                 @endif



                 </li>



                 @endif



                <li class="list-inline-item"><span>CTC:</span> {{ $ctc }} LPA</li>



                <li class="list-inline-item"><span>ECTC:</span> {{ $ectc }} LPA</li>



                @if ($days != 0 && isset($datetime1))
                <li class="list-inline-item"><span>Notice Period:</span> {{ $days }}

                    @if ($datetime1 < $datetime2) days @endif </li>

                        @else

                <li class="list-inline-item"><span>Notice Period:</span> {{ $days }}

                </li>

                @endif



                 <li class="list-inline-item"><span>Highest Education:</span> {{ $course->course??'' }}</li>



                <li class="list-inline-item"><span>Institution:</span> {{$institute->educations??''}}

                        @if(isset($data3->work_type))

                        <li class="list-inline-item pr-5"><span>Pref. Work Type:</span>

                            {{ $data3->work_type??'' }}</li>



                          @endif

                @php

                    $interview_date = \App\Interview::where('user_id',$user->id)->where('date','>=',\Carbon\Carbon::now())->orderBy('date','asc');

                    $interview_date_list = $interview_date->get();

                    $num_count = 0;

                    $num_of_items = $interview_date->count();

                @endphp

                

                     @php

                        $interview = [];

                        foreach ($interview_date_list as $InterView){

                            



                            if(array_key_exists(date("M", strtotime($InterView->date)), $interview)){



                                $interview[date("M", strtotime($InterView->date))] = $interview[date("M", strtotime($InterView->date))].','.date("d", strtotime($InterView->date));

                            }else{           

                                $interview[date("M", strtotime($InterView->date))] = date("d", strtotime($InterView->date));

                            

                            }

                            

                        }

                        

                        @endphp



                                            @if(isset($interview_date_list) && count($interview_date_list) > 0)

                                            

                                        



                                                <li class="list-inline-item pr-5"><span>Video Interview: </span>

                                                @foreach ($interview as $key => $item)

                                                    {{ $key }} {{ $item }}

                                                @endforeach

                                                </li>



                                            @endif

           

            
            </ul>
            <div class="section_2 pb-0">



                <ul class="list-inline">





                    @if (count($keyskill) < 10)

                     @foreach ($keyskill as $skill) 

                     <?php

                                            

                     $job_skill = \App\JobSkill::where('id', $skill->keyskill)->first();

                     

                  
                     

                 

                                            

                     ?>

                      <li class="list-inline-item terms mb-1">





                        @if(str_contains($job_skill->job_skill, $key->job_skill??'') && !empty($key->job_skill))

                       

                       <span style="background-color:yellow">{{ isset($job_skill->job_skill) ? $job_skill->job_skill : '' }} </span> 

                       @else

                       <span >{{ isset($job_skill->job_skill) ? $job_skill->job_skill : '' }} </span> 

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

                            <p class="candidate_view-more mb-0 " style="color: #197ff3;"

                                data-toggle="tooltip" data-placement="top"

                                title="To Know more click View Resume">More +</p>

                        </li>

                    @endif





                </ul>



            </div>
            
        </div>
        
    </div>
</div>

@endforeach
<div class="col-lg-12">
    <div class="pagiWrap pb-2">

        <nav aria-label="Page navigation example">
    
            @if (isset($jobs) && count($jobs))
    
            {{ $jobs->appends(request()->query())->links() }} @endif
    
        </nav>
    
    </div>
</div>
