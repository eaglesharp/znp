<div class="col-md-4 position-absolute text-center" style="right: 0;top:10px;">
    <p id="success_id101" class="p-success34 homealert mb-0"></p>
</div>

<section class="header col-12 mr-auto">

    <div class="container">

        <div class="row line">



            <div class="col-lg-12 px-2 pt-4 text-center">

                @if(Auth::guard('company')->check())

                <div class="parah pt-4 px-5 px-lg-0"> Verified Database of IT & Non IT Talent With

                    <span class="line_change font_size">ZeroNoticePeriod</span>
                </div>

                @else



                <div class="parah pt-4 px-5 px-lg-0"> Login To Verified Database of IT & Non IT Talent With

                    <span class="line_change font_size">ZeroNoticePeriod</span>
                </div>



                @endif

                <div class="font_size pb-3 pt-1">HIRE QUICK!</div>

            </div>



        </div>

        <?php

        $keyskills=\App\JobSkill::all();
        $keyskill_val=\App\JobSkill::all();
        // echo $keyskills;
// foreach($keyskill as $key_skill)
// {
//     echo $key_skill;
// }
       

        $city=\App\User::orderBy('current_location')->get()->whereNotNull('current_location')->unique('current_location');

        //  $t4=(isset($skill) ? $skill->keyskill:'');

        //  echo $skill

        ?>
                                


    </div>

    <form action="{{route('home.search')}}" method="post">

        @csrf

        <div class="row space_2 pb-5">

            <div class="col-lg col-xl-3 choose-skills position_lit notice-period">



                <!-- <select name="skills[]" multiple class="select_skills form_control pl-3 pr-5">

                    <option value="">Choose by Skills</option>

                  
                    @foreach($keyskills as $skill)           

                        <option value="{{$skill->id}}"  @if(isset($home_users)) @if(isset($selected_skill)) @if(in_array($skill->id, $selected_skill)) selected @endif  @endif  @endif>{{$skill->job_skill}}</option>

                    @endforeach
                </select> -->

                <select id="multiple-select-employee_skill" class="form_control form_action rounded pl-3 pr-5"
                    multiple="multiple">
                    <option value="option1">Application Development</option>
                    <option value="option2">Architecture</option>
                    <option value="option3">Artificial Intelligence</option>
                    <option value="option4">Html</option>
                </select>

            </div>

            <div class="col-lg position_lit notice-period location_cus">

                <!-- <select name="location" class="form_control form_action rounded pl-3 pr-5" >

                    <option selected disabled>Choose by Location</option>

                    @foreach($city as $city)

                        @if($city)
                        <option value="{{$city->current_location}}" @if(isset($location)) @if($location == $city->current_location) selected @endif @endif>{{$city->current_location}}</option>

                        @endif

                    @endforeach

                </select> -->

                <select id="location-multi-select" multiple="multiple">
                        <optgroup label="North India" value="b3a2eff6-5351-4b0f-9861-0d47e136517d" id="checks">
                            <option value="90b4365b-9ddc-4c08-9e42-03662d73d923" label="Chimneys and Towers"></option>
                            <option value="6a7d30d8-e500-476f-a2c6-7adfb47a3e00" label="Height Safety"></option>
                            <option value="eb89ab4a-0431-4ed2-b6ba-a0c1bc91b0f0" label="Lightning Protection"></option>
                        </optgroup>
                        <optgroup label="South India" value="42da4f3e-1944-4f42-a5b7-350871cbffea">
                            <option value="90b4365b-9ddc-4c08-9e42-03662d73d922" label="Chimneys and Towers4"></option>
                            <option value="6a7d30d8-e500-476f-a2c6-7adfb47a3e03" label="Height Safety4"></option>
                            <option value="eb89ab4a-0431-4ed2-b6ba-a0c1bc91b0f3" label="Lightning Protection4"></option>
                        </optgroup>
                        <optgroup label="East India." value="46ec4dec-e669-4829-b99a-5ac64340eb84">
                            <option value="90b4365b-9ddc-4c08-9e42-03662d73d9231" label="Chimneys and Towers1"></option>
                            <option value="6a7d30d8-e500-476f-a2c6-7adfb47a3e001" label="Height Safety1"></option>
                            <option value="eb89ab4a-0431-4ed2-b6ba-a0c1bc91b0f01" label="Lightning Protection1">
                            </option>
                        </optgroup>
                    </select>

            </div>

            <div class="col-lg  position_lit notice-period">

                <!-- <select class="form_control form_action rounded pl-3 pr-5" name="notice_period">

                    <option selected disabled>Choose by Notice Period</option>
                    <option value="1" @if(isset($notice_period)) @if($notice_period=="1") selected @endif  @endif>Immediately Available</option>
                    <option value="2" @if(isset($notice_period)) @if($notice_period=="2") selected @endif  @endif>Serving Notice Period</option>
                    <option value="3" @if(isset($notice_period)) @if($notice_period=="3") selected @endif  @endif>Buyable Notice Period</option>
                    <option value="4" @if(isset($notice_period)) @if($notice_period=="4") selected @endif  @endif>Not Under Notice Period</option>

                </select> -->

                <select id="multiple-select-employee_notice" class="form_control form_action rounded pl-3 pr-5"
                    multiple="multiple">
                    <option value="option1">Immediately Available</option>
                    <option value="option2">Serving Notice Period</option>
                    <option value="option3">Zero Notice Period</option>
                    <option value="option4">Any</option>
                </select>

            </div>

            <div class="col-lg-2 box">

                <button type="submit" class="btn btn_submit w-100 text-light" data-toggle="modal"
                    data-target="#LoginThankModal">Submit</button>
            </div>

        </div>

    </form>
    <!-- <button type="submit" class="btn btn_submit w-100 text-light" data-toggle="modal"
        data-target="#LoginThankModal">Submit</button> -->




    @if(isset($home_users))



    <?php 

           $users=\App\User::where('complete','>=',13)->orderBy('created_at','desc')->paginate(20);

           $count = count($users);

           $keyskill=\App\JobSkill::all();

               
// echo $home_users;


               

            ?>

    <div class="job_offers pt-1">







        @forelse ($home_users as $user)



        <?php 

           

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

           

            ?>


        @php
        $date = $notice_period->last_working_day;
        $datetime1 = strtotime($todayDate); // convert to timestamps
        $datetime2 = strtotime($date); // convert to timestamps
        @endphp




        <div class="boxing rounded px-4">

            <div class="row">

                <div class="col-lg-9 col-xl-10 pt-3">

                    <ul class="list-inline">

                        <li class="list-inline-item pr-3 font_color">{{$latestdesg}}</li>

                        <li class="list-inline-item pr-3">Latest Company: {{$latestcom}} </li>

                        <li class="list-inline-item pr-3">Exp: {{$experience}}</li>

                        <li class="list-inline-item pr-3">

                            <img class="pb-1" src="asset/images/location.svg">

                            &nbsp {{$user->current_location}}
                        </li>

                        <li class="list-inline-item pr-3">CTC: {{$ctc}} LPA</li>

                        <li class="list-inline-item pr-3">ECTC: {{$ectc}} LPA</li>

                        @if ($days != 0)

                        <li class="list-inline-item pr-5">Notice Period: {{$days}} @if ($datetime1 < $datetime2)days
                                @endif</li>

                                @else

                        <li class="list-inline-item pr-5">Notice Period: {{$days}}</li>

                        @endif

                    </ul>

                    <?php 

                    $keyskill=\App\KeySkill::where('user_id',$user->id)->paginate(5);

                   // echo count($keyskill);

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
                                <li class="list-inline-item terms mb-1">
                                    <p class="candidate_view-more mb-0" style="color: #197ff3;">More +</p>
                                </li>

                                @endif


                        </ul>

                    </div>

                </div>

                <?php 

                        $com_id = Auth::guard('company')->user()->id ;

      

              $company = \App\Company::where('id', $com_id)->first();

           //  echo $company->cvs_quota;

                

                ?>

                <div class="col-lg-3 col-xl-2 align-self-center">

                    <a class="btn btn_style mx-auto mb-3 mb-lg-0" data-toggle="tooltip" data-placement="top"
                        title="Remaining CV Access : {{$company->availed_cvs_quota}}/{{$company->cvs_quota}}"
                        href="{{ route('candidate.profile2', $user->id) }}">View Resume</a>

                </div>

                @php
                $now = \Carbon\Carbon::now();
                @endphp

                @if($user->package_end_date > $now )

                <p class="mb-0 list-inline-item express-job" data-toggle="tooltip" data-placement="top"
                    title='"Express Job Seeker" are looking for jobs on immediate basis.'>Express Job Seeker</p>
                @endif
            </div>

        </div>

        @empty
        <h4 style="
        text-align: center;
        font-size: 30px;
    ">"No Search Results Found!"</h4>
        @endforelse




    </div>

    <input type="hidden" name="company_id" value="{{ Auth::guard('company')->user()->id }}">

    @if($count >= 20)

    <div class="col-md-12 text-center align-self-center py-4 py-lg-5">

        <a class="btn btn_style_1 mx-auto" href="{{url('candidate_list')}}">VIEW ALL CANDIDATES </a>

    </div>
    @endif

    </div>

    </div>

    @else



    <?php 

    $users=\App\User::where('complete','>=',13)->orderBy('created_at','desc')->paginate(20);

    


$count = count($users);
       

       

    ?>

    <div class="job_offers pt-1">







        @foreach ($users as $user)



        <?php 

    $keyskill=\App\KeySkill::where('user_id',$user->id)->first();  

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

   

    ?>

        @if ($keyskill)


        @php
        $date = $notice_period->last_working_day;
        $datetime1 = strtotime($todayDate); // convert to timestamps
        $datetime2 = strtotime($date); // convert to timestamps
        @endphp



        <div class="boxing @if($user->verified==1)stick_label @endif rounded px-4">

            <div class="row">

                <div class="col-lg-9 col-xl-10 pt-3">

                    <ul class="list-inline">

                        <li class="list-inline-item pr-3 font_color">{{$latestdesg}}</li>



                        <li class="list-inline-item pr-3">Latest Company: {{$latestcom}} </li>

                        <li class="list-inline-item pr-3">Exp: {{$experience}}</li>

                        <li class="list-inline-item pr-3">

                            <img class="pb-1" src="asset/images/location.svg">

                            &nbsp {{$user->current_location}}
                        </li>

                        <li class="list-inline-item pr-3">CTC: {{$ctc}} LPA</li>

                        <li class="list-inline-item pr-3">ECTC: {{$ectc}} LPA</li>



                        @if ($days != 0)

                        <li class="list-inline-item pr-3">Notice Period: {{$days}} @if ($datetime1 < $datetime2)days
                                @endif</li>

                                @else

                        <li class="list-inline-item pr-3">Notice Period: {{$days}}</li>

                        @endif

                    </ul>

                    <?php 

            $keyskill=\App\KeySkill::where('user_id',$user->id)->paginate(5);

           // echo count($keyskill);

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
                                <li class="list-inline-item terms mb-1">
                                    <p class="candidate_view-more mb-0 " style="color: #197ff3;" data-toggle="tooltip"
                                        data-placement="top" title="To Know more click View Resume">More +</p>
                                </li>

                                @endif


                        </ul>

                    </div>

                </div>

                <?php 

        $com_id = Auth::guard('company')->user()->id ;
        $company = \App\Company::where('id', $com_id)->first();

   //  echo $company->cvs_quota;

        

        ?>

              
    <div class="col-lg-3 col-xl-2 align-self-center">
        <a class="btn btn_style mx-auto mb-3 mb-lg-0" data-toggle="tooltip" data-placement="top"
            title="Remaining CV Access : {{$company->availed_cvs_quota??0}}/{{$company->cvs_quota??0}}"
            href="{{ route('candidate.profile2', $user->id) }}">View Resume</a>
    </div>

    @php
    $now = \Carbon\Carbon::now();
    @endphp

    @if($user->package_end_date > $now )

    <p class="mb-0 list-inline-item express-job" data-toggle="tooltip" data-placement="top"
        title='"Express Job Seeker" are looking for jobs on immediate basis.'>Express Job Seeker</p>

    @endif
    </div>

    </div>

    @endif

    @endforeach





    </div>

    <input type="hidden" name="company_id" value="{{ Auth::guard('company')->user()->id }}">

    @if($count >= 20)

    <div class="col-md-12 text-center align-self-center py-4 py-lg-5">

        <a class="btn btn_style_1 mx-auto" href="{{url('candidate_list')}}">VIEW ALL CANDIDATES </a>

    </div>

    @endif

    </div>

    </div>





    @endif

</section>



<!-- number Board -->



<section class="number_board py-4 py-lg-5">

    <div class="container">

        <div class="row">

            <div class="col-12 number_board-counter">

                <div class="style_text text-center">

                    ZeroNoticePeriod Metrics

                </div>
                <?php 

                $counter=\App\Counter::all()->take(1);

                

                

                //  echo $counter;

                ?>
                @foreach($counter as $c)

                {{-- {{$c->counter}} --}}

                @endforeach

                <div class="number_board-counter  row col-lg py-sm-4 mx-0 my-0">

                    <div class="col-md-6 col-lg-5 offset-lg-1 number_board_1 text-center">

                        <div class="run_number">

                            <span class="run_number counter" data-count="{{$c->counter}}">0</span>+
                        </div>

                        <p class="typeo_class">NON IT IMMEDIATE HIRES</p>

                    </div>

                    <div class="col-md-5 number_board_2 md-6-p-0 mt-3 mt-md-0 text-center">

                        <div class="run_number"><span class="run_number counter" data-count="{{$c->counter1}}">0</span>+
                        </div>

                        <p class="typeo_class">IT IMMEDIATE HIRES</p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<!--image section-->



<section class="base_img py-lg-5">

    <div class="container">

        <div class="row">

            <div class="col-lg-5 text-left align-self-center">

                <div class="list_img px-lg-0">Why ZeroNoticePeriod?</div>

                <ul class="list-group pl-4 mx-0 my-0">

                    <li class="list-inline-item size_list pesudo_class px-3 mr-0">

                        All Candidates are VERIFIED for Notice Period by Qualified Recruiters to retain only candidates
                        who are serving/completed Notice Periods.

                    </li>

                    <li class="list-inline-item size_list pesudo_class px-3 mr-0">

                        Database of QUICK JOINERS with Notice Period between 0 - 2 Weeks / Candidates Serving Notice
                        Period / Candidates with Buyable Notice Period.

                    </li>

                    <li class="list-inline-item size_list pesudo_class px-3 mr-0">

                        Database has job seekers who are under Notice Period OR have Completed Notice Periods.

                    </li>

                    <li class="list-inline-item size_list pesudo_class px-3 mr-0">

                        Database REFRESHED every week to allow Quick Hires ONLY.

                    </li>

                    <li class="list-inline-item size_list pesudo_class px-3 mr-0">

                        No Passive Job Seekers.

                    </li>

                    <li class="list-inline-item size_list pesudo_class px-3 mr-0">

                        Mandatory Data Updates about Compensation (Current & EXPECTED), Competing Offers, Interview
                        Availability.

                    </li>

                </ul>

            </div>

            <div class="col-lg-7 col-xl-7 text-center py-3 py-lg-0 text-lg-right align-self-center">

                <iframe class="iframe_img-aligin img" width="100%" height="445"
                    src="https://www.youtube.com/channel/UCA_pykWTYsltpgdinRQMOgg/about" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>

                </iframe>

            </div>

        </div>

    </div>

</section>


<!--image-->



<section class="content-head text-center py-5">

    <div class="container">

        <div class="head1 pb-4 mb-2">

            <div class="how_text">How it works</div>

        </div>

        <div class="row">

            <div class="col-md-4 pt-3">

                <img src="asset/images/voting (1).png">

                <div class="line">Register</div>

            </div>

            <div class="col-md-4 pt-3">

                <img src="asset/images/book (2).png">

                <div class="line">Buy database<br>subscriptions</div>

            </div>

            <div class="col-md-4 pt-3">

                <img src="asset/images/login.png">

                <div class="line">Login to access<br>candidate database</div>

            </div>

        </div>

    </div>

</section>

<button type="submit" class="btn btn_submit w-100 text-light" data-toggle="modal"
                    data-target="#LoginasEmployer">Submit</button>

<!--Register Success modal -->
<div class="container">
    <div class="modal" id="LoginThankModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal_content_custom_width mx-auto p-3">
                <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"
                        src="{{ asset('/') }}asset/images/cancel.png"></p>
                <div class="modal-body pt-0">
                    <div class="collection_pic-box text-center mt-2 mt-md-0">
                        <div class="collection_text ">
                            <span class="line_change">Thanks for Signing up. </span>
                            <h4 class="modal-title sign_head">"With free account, you can make 10 CV searches".</h4>
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
    <div class="modal" id="PlanExpire">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal_content_custom_width mx-auto p-3">
                <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"
                        src="{{ asset('/') }}asset/images/cancel.png"></p>
                <div class="modal-body py-0">
                    <div class="collection_pic-box text-center mt-2 mt-md-0">
                        <div class="collection_text px-lg-3 py-0">
                            <span class="line_change font_size">Note!!!</span>
                            <h4 class="modal-title sign_head">"You have used your quota of 10 searches with a Free
                                account. Please purchase the Subscription to find talent FASTER!".</h4>
                            <div class="error_message1 " id=""></div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center px-3 border-0 py-3">
                    <button type="button" class="btn  btn_style btn_style_height">Subscribe Now</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal end -->
<!--View Resume Plan Expire modal -->
<div class="container">
    <div class="modal" id="LoginorReister">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal_content_custom_width mx-auto p-3">
                <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"
                        src="{{ asset('/') }}asset/images/cancel.png"></p>
                <div class="modal-body p-0">
                    <div class="collection_pic-box text-center mt-2 mt-md-0">
                        <div class="collection_text px-lg-3 py-0">
                            <h4 class="modal-title sign_head">Your Plan Has Been Expired, Please Update</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center px-3 border-0 pb-3">
                        <button type="button" class="btn  btn_style btn_style_height">Subscribe Now</button>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- modal end -->


<!--Sign As Employer modal -->
<div class="container">
    <div class="modal" id="LoginasEmployer">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal_content_custom_width mx-auto p-3">
                <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"
                        src="{{ asset('/') }}asset/images/cancel.png"></p>
                <div class="modal-body p-0">
                    <div class="collection_pic-box text-center mt-2 mt-md-0">
                        <div class="collection_text px-lg-3 py-0">
                            <h4 class="modal-title sign_head">Sign Up As An Employer</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center px-3 border-0 pb-3">
                    <button type="button" class="btn  btn_style btn_style_height">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal end -->














@push('scripts')


<script>
$(document).ready(function() {
    let select1 = $('.select_skills');
    $('.select_skills').next('span.select2').find('ul').html(function() {
        let count = select1.select2('data').length;
        if (count < 1) {
            return "<li>Choose by Skills</li>";
        } else {
            return "<li>" + count + " skills selected</li>";
        }
    });

});






var msg = '{{Session::get('
alert ')}}';

var exist = '{{Session::has('
alert ')}}';

if (exist) {


    $('#success_id101').html('<p class="alert alert-info mb-0">' + msg + '</p>');
    setTimeout(function() {
        $(".homealert").hide();
    }, 5000);
}



//counter for all page script

var counted = 0;



function counter_start() {

    if ($('.number_board-counter').length) {

        var oTop = $(".number_board-counter").offset().top - window.innerHeight;

        if (counted == 0 && $(window).scrollTop() > oTop) {

            $(".number_board-counter .counter").each(function() {

                var $this = $(this),

                    countTo = $this.attr("data-count");

                $({

                    countNum: $this.text(),

                }).animate(

                    {

                        countNum: countTo,

                    },

                    {

                        duration: 4000,

                        easing: "swing",

                        step: function() {

                            $this.text(Math.floor(this.countNum));

                        },

                        complete: function() {

                            $this.text(this.countNum);

                        },

                    }

                );

            });

            counted = 1;

        }

    }

}



if (window.location.href.indexOf("jobportal") > -1) {

    $(window).scroll(function() {

        counter_start();

    });

}



if (window.location.href.indexOf("about-us") > -1) {

    counter_start();

}

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



// multiple select skill
$('#multiple-select-employee_skill').multiselect({
    includeSelectAllOption: false,
    nonSelectedText: 'Choose by Skills',
    numberDisplayed: 2,
    enableCaseInsensitiveFiltering: true,
    filterPlaceholder: 'Enter Skills',
});
// multiple select location
$('#multiple-select-employee_location').multiselect({
    includeSelectAllOption: false,
    nonSelectedText: 'Choose by Location',
    numberDisplayed: 2,
    enableCaseInsensitiveFiltering: true,
    filterPlaceholder: 'Enter Location',
});
// multiple select notice
$('#multiple-select-employee_notice').multiselect({
    includeSelectAllOption: false,
    nonSelectedText: 'Choose by Notice Period',
    numberDisplayed: 2,
});
</script>



@endpush