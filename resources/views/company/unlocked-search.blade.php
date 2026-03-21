<div class="col-lg-9 footer-align">



    <?php 
        //$users=\App\User::orderBy('created_at','desc')->get();
    ?>



    <div class="col-12 candidates_job-dashboard py-3 px-0 pt-0">



        <span class="candidate_title-head">Showing {{count($filter_users)}} <span class="candidate_text">Candidates</span></span>



        <a id="filter_show-button" class="filter_icon-algin d-block d-lg-none" href="javascript:void(0);">



            <img class="filter_img-icon" src="asset/images/Group-1.png">



        </a>



    </div>



    



    {{-- {{$filter_users}} --}}







    <div class="job_offers pt-1">







 







        @forelse ($filter_users as $user)



                



        <?php 



// echo $user;



        $company=\App\ProfileCityJobsCity::where('user_id',$user->id)->first();



    



        $summary=\App\ProfileSummary::where('user_id',$user->id)->first();



    



        $todayDate = \Carbon\Carbon::now()->format('Y-m-d');



        



        $data2=\App\ProfileSummary::where('user_id',$user->id)->first();



        $experience=(isset($data2) ? $data2->totalexp:'');



        $latestdesg=(isset($data2) ? $data2->latestdesg:'');



        $latestcom=(isset($data2) ? $data2->latestcom:'');



    



        //   echo $t







        $data3=\App\ProfileDetails::where('user_id',$user->id)->first();



        $ctc=(isset($data3) ? $data3->expect_ctc_lakhs:'');



        $ectc=(isset($data3) ? $data3->expect_ctc_lakhs3:'');







        $notice_period=\App\ProfileNop::where('user_id',$user->id)->first();



        // echo($notice_period);



        $noticed=(isset($notice_period) ? $notice_period->nop_days:'');



        //    echo($noticed);







        

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



   $user2= \App\User::where('id',$user->id)->first();



    ?>



    @php

    $date = $notice_period->last_working_day;

    $datetime1 = strtotime($todayDate); // convert to timestamps    

    $datetime2 = strtotime($date); // convert to timestamps  

    @endphp



@php

                                            

$location_values_un =  unserialize($user->prefered_city);



        if(isset($location_values_un) && !empty($location_values_un))

        {

            $count = count($location_values_un);

            $two_value = array_slice($location_values_un,0,2);

        }



        if(isset($two_value) && !empty($two_value)) 

        {

            $location_values =  implode(', ', $two_value);

        }



@endphp



            


            <div class="boxing ul-resume @if($user->verified==1)v-icon stick_label @endif rounded px-4">
                
                <a href="{{ route('candidate.profile1', $user->id) }}" class="py-0 float-right  btn btn-outline-primary" style="font-size: 12px;z-index: 999;margin-top: -15px;margin-right: -15px; border-radius: 30px;" target="_blank">View</a>

                         <ul class="list-inline pt-3 my-0">

            <li class="list-inline-item pr-3 font_color">

                <a href="{{ route('candidate.profile1', $user->id) }}" class="sign_head"><h4>{{$user->first_name}}</h4></a>

            </li>

        </ul>

        {{-- <ul class="list-inline my-0">

            <li class="list-inline-item pr-3">

                <a href="mailto:{{$user->email}}" class="contact_mail">

                    <i class="fa fa-envelope-o pr-2 text-primary" aria-hidden="true"></i>{{$user->email}}

                </a>

            </li>

            <li class="list-inline-item pr-3">

                <a href="tel: {{$user->phone}}" class="contact_phone">

                    <i class="fa fa-phone text-primary pr-2" aria-hidden="true"></i>{{$user->phone}}

                </a>

            </li>

            

        </ul> --}}



                {{-- <div class="row"> --}}



                    {{-- <div class="col-lg-8 col-xl-9 pt-3"> --}}



                        <ul class="list-inline job_view">


                            <li class="list-inline-item pr-3 font_color">{{$latestdesg}}</li>



                            <li class="list-inline-item pr-3"><span>Latest Company:</span> {{$latestcom}} </li>



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



                            <li class="list-inline-item pr-3"><span>Exp:</span> {{$experience}}</li>



                          



                            <li class="list-inline-item pr-3"><span>CTC:</span> {{$ctc}} LPA</li>



                            <li class="list-inline-item pr-3"><span>ECTC:</span> {{$ectc}} LPA</li>



                            @if ($days != 0)



                            <li class="list-inline-item pr-5"><span>Notice Period:</span> {{$days}} @if ($datetime1 < $datetime2)days @endif</li>



                        @else



                            <li class="list-inline-item pr-5"><span>Notice Period:</span> {{$days}}</li>



                        @endif    



                        </ul>



                        <?php 



                        $keyskill=\App\KeySkill::where('user_id',$user->id)->take(5)->get();



                        



                        //  $t4=(isset($skill) ? $skill->keyskill:'');



                        //  echo $skill



                        ?>



                        <div class="section_2 pb-0">



                            <ul class="list-inline">





                                @foreach ($keyskill as $skill)
                                  <?php
                                    $job_skill = \App\JobSkill::find($skill->keyskill);
                                    $searchTerm = 'designer';
                                    $highlighted = str_contains($job_skill->job_skill, $searchTerm ?? '');
                                  ?>
                                  <li class="list-inline-item terms mb-1">
                                    @if ($highlighted && !empty($searchTerm))
                                      <span style="background-color: yellow">{{ $job_skill->job_skill }}</span>
                                    @else
                                      <span>{{ $job_skill->job_skill }}</span>
                                    @endif
                                  </li>
                                @endforeach
                                
                                @if (count($keyskill) >= 10)
                                  <li class="list-inline-item terms mb-1">
                                    <p class="candidate_view-more mb-0" style="color: #197ff3;"
                                       data-toggle="tooltip" data-placement="top"
                                       title="To know more click View Resume">More +</p>
                                  </li>
                                @endif


    

    

                            </ul>



                        </div>

                        @php

                          $now = \Carbon\Carbon::now();

                        @endphp

                        <div class="joblist">

                               @if ($user->layoff_package_end_date > $now)



                                  <p class="list-inline-item-1 mb-0 layoff-cv" data-toggle="tooltip" data-placement="top" title='"Layoff CV" (CV of Jobseeker laid off at work)'>


            

                                    Layoff CV</p>

                                

        

                                @endif

                            @if($user->package_end_date >  $now  )

                            <p class="list-inline-item mb-0 express-job unlocked"  data-toggle="tooltip" data-placement="top" title='"Xpress Job Seeker" are looking for jobs on immediate basis.'>Xpress Job Seeker</p>

                            @endif    


                            </div>
                    {{-- </div> --}}



                    {{-- <div class="col-lg-3 col-xl-2 align-self-center">



                        <a class="btn btn_style mx-auto mb-3 mb-lg-0" data-toggle="tooltip" data-placement="top" title="Remaining CV Access : 28/100" href="{{ route('candidate.profile1', $user->id) }}">View Resume</a>



                    </div> --}}



                {{-- </div> --}}



            </div>



            @empty

            <h4 style="

            text-align: center;

            font-size: 30px;

        ">"No Search Results Found!"</h4>

            @endforelse



        <div class="pagiWrap">

            <nav aria-label="Page navigation example">

                @if(isset($filter_users) && count($filter_users))

                {{ $filter_users->appends(request()->query())->links() }} @endif

            </nav>

        </div>



    </div>



</div>

