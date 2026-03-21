
    <?php 



    $keyskill=\App\JobSkill::all();

           
    $count = count($users);
       

    ?>

     @if(isset($users))

        <div class="job_offers pt-1">

            @forelse ($users as $user)


            <?php 

           

               $company=\App\ProfileCityJobsCity::where('user_id',$user->id)->first();  

               $summary=\App\ProfileSummary::where('user_id',$user->id)->first();   

               $todayDate = \Carbon\Carbon::now()->format('Y-m-d');     

               $data2=\App\ProfileSummary::where('user_id',$user->id)->first();

               $experience=(isset($data2) ? $data2->totalexp:'');

               $latestdesg=(isset($data2) ? $data2->latestdesg:'');

               $latestcom=(isset($data2) ? $data2->latestcom:'');

                $data3=\App\ProfileDetails::where('user_id',$user->id)->first();

                 $educations = \App\ProfileEducation::where('user_id', $user->id)->get();

                $ctc=(isset($data3) ? $data3->expect_ctc_lakhs:'');

                $ectc=(isset($data3) ? $data3->expect_ctc_lakhs3:'');

                $notice_period=\App\ProfileNop::where('user_id',$user->id)->first();

                $noticed=(isset($notice_period) ? $notice_period->nop_days:'');

        
           
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

                            $days = '0 days';

                         }
                           

                    }
                    elseif($noticed == 3) {

                        $days = 'Buyable Notice Period';

                    }

                    else
                    {
                        $days = 'Not Under Notice Period';
                    }


               foreach($educations as $education)
                {

                   $high_education = \App\Education::where('id',$education->degree_title)->first();

                    if($high_education->high_value == 1)
                    {
                      
                        $high_education_val = \App\Education::where('high_value',1)->first();
                    }
                    if($high_education->high_value == 2)
                    {
                      
                        $high_education_val = \App\Education::where('high_value',2)->first();
                    }
                    if($high_education->high_value == 3)
                    {
                       
                        $high_education_val = \App\Education::where('high_value',3)->first();
                    }


                }
              
if(isset($high_education_val))
{
                 $final = \App\ProfileEducation::where('user_id', $user->id)->where('degree_title',$high_education_val->id)->first();
            }
                
                if(isset($final))
                {
                    
                  $institute = \App\Degree::where('id', $final->organization)->first();
                  $course = \App\Course::where('id', $final->course)->first();
                    
                }

                 



   

    ?>



                                @php  
                                    $current_city =  $user->current_city;
                               
                                @endphp

                       



            <div class="boxing rounded px-4">

                <div class="row">

                    <div class="col-lg-12 pt-3">

                        <ul class="list-inline job_view">
                            
                            

                            <li class="list-inline-item font_color">{{$latestdesg}}</li>
                            
                            
                            
                             @if(Auth::guard('company')->check())

                            <li class="list-inline-item"><span>Latest Company:</span> {{$latestcom}} </li>
                            
                            @endif

                            <li class="list-inline-item"><span>Exp:</span> {{$experience}}</li>

                            <li class="list-inline-item">

                                <img class="pb-1" src="{{asset('asset/images/location.svg')}}"> 
                                
                                                                  

                                  
                            {{ $current_city??''}}
                            {{-- @if($count > 2)
                            {{ $location_values??''}} <span class="candidate_view-more mb-0 " style="color: #197ff3;"
                            >More +</span>
                            @else
                            {{ $location_values??''}}
                            @endif --}}

                                  
                                   

                            </li>

                          {{--   <li class="list-inline-item"><span>CTC:</span> {{$ctc}} LPA</li>

                            <li class="list-inline-item"><span>ECTC:</span> {{$ectc}} LPA</li> --}}

                            @if ($days != 0)

                            <li class="list-inline-item pr-5"><span>Notice Period:</span> {{$days}} </li>

                            @else

                            <li class="list-inline-item pr-5"><span>Notice Period:</span> {{$days}}</li>

                            @endif

                             {{-- <li class="list-inline-item pr-5"><span>Highest Education:</span> {{ $course->course??'' }}</li>  --}}

                             {{-- <li class="list-inline-item pr-5"><span>Institute:</span> {{$institute->educations??''}}</li> --}}

                        </ul>

                        <?php 

            $keyskill=\App\KeySkill::where('user_id',$user->id)->paginate(5);

            

           //  $t4=(isset($skill) ? $skill->keyskill:'');

            //  echo $skill

            ?>

                        <div class="section_2 pb-0">

                            <ul class="list-inline">

                                @if(count($keyskill) < 5) @foreach($keyskill as $skill) <?php                    

                        $job_skill=\App\JobSkill::where('id',$skill->keyskill)->first();

                        ?> <li class="list-inline-item terms mb-1">
                                    {{(isset($job_skill->job_skill)? $job_skill->job_skill:'')}}</li>

                                    @endforeach

                                    @else

                                    @foreach($keyskill as $skill)

                                    <?php                    

                        $job_skill=\App\JobSkill::where('id',$skill->keyskill)->first();

                        ?>



                                    <li class="list-inline-item terms mb-1">
                                        {{(isset($job_skill->job_skill)? $job_skill->job_skill:'')}}</li>


                                    @endforeach
                                    <li class="list-inline-item terms mb-1"><a class="candidate_view-more"
                                            href="javascript:void(0);">More +</a></li>

                                    @endif



                            </ul>

                        </div>

                    </div>



                    {{-- <div class="col-lg-3 col-xl-2 align-self-center">
                        @if(Auth::guard('company')->check())
                            @php
                            $company = \App\Company::where('id',Auth::guard('company')->user()->id)->first();
                            $now = \Carbon\Carbon::now();
                            $unlock = \App\Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->where('unlocked_users_ids',$user->id)->first();
                            @endphp
                            @if($company->package_end_date > $now)
                                <a class="btn btn_style mx-auto mb-3 mb-lg-0" data-toggle="tooltip" data-placement="top"
                                title="Remaining CV Access : {{$company->availed_cvs_quota??0}}/{{$company->cvs_quota??0}}"
                                href="{{ route('candidate.profile1', $user->id) }}">View Resume</a>
                            @elseif ($unlock)
                                <a class="btn btn_style mx-auto mb-3 mb-lg-0" data-toggle="tooltip" data-placement="top"
                                title=""
                                href="{{ route('candidate.profile2', $user->id) }}" target="_blank">                        
                                    Viewed Resume
                                </a>
                            @elseif ($company->free_cv_access < 5)
                                <a class="btn btn_style mx-auto mb-3 mb-lg-0" data-toggle="tooltip" data-placement="top"
                                    title="CV Access : {{ $company->availed_cvs_quota??'0' }}/5"
                                    href="{{ route('candidate.profile1', $user->id) }}" target="_blank">                         
                                    @if($unlock)
                                    <!-- <img class="pr-1" src="{{ asset('asset/images/tick.png') }}"> -->
                                        Viewed Resume
                                    @else
                                        View Resume
                                    @endif
                            
                                </a>
                    
                       
                            @else
                                <button type="submit" class="btn btn_style mx-auto mb-3 mb-lg-0" data-toggle="modal"
                                    data-target="#LoginasEmployer">View Resume</button>
                            @endif
                        @endif
                    </div> --}}

                </div>

            </div>

            @empty
                        <!--            <h4 style="-->
                        <!--    text-align: center;-->
                        <!--    font-size: 30px;-->
                        <!--">"No Search Results Found!"</h4>-->
            @endforelse





        </div>

        @if($count > 4)

        <div class="col-12 text-center  py-4 py-lg-5">

              @if(Auth::guard('company')->check())

               <a class="btn btn_style_1 view-all-c mx-auto" href="{{url('cv-search')}}">VIEW ALL CANDIDATES </a>

             @elseif(Auth::check())
          
               <a class="btn btn_style_1 view-all-c mx-auto mb-3 mb-lg-0" href="{{ route('pricing') }}">VIEW ALL CANDIDATES</a>
            
             @else
               <a class="btn btn_style_1 view-all-c mx-auto mb-3 mb-lg-0" href="{{ url('employer-register') }}">VIEW ALL CANDIDATES</a>
             @endif


        </div>

        @endif

    </div>

    </div>

        @endif