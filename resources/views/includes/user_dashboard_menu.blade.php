<section class="header mr-auto">

    <div class="container">

        <div class="row line">



            <div class="col-lg-12 px-2 pt-md-4 text-center">

                <div class="parah pt-4 px-5 px-lg-0">@auth Verified Database of IT & Non IT Talent With @else Login To
                    Verified Database of IT & Non IT Talent With @endauth<span
                        class="line_change font_size">ZeroNoticePeriod</span></div>

                <div class="font_size pb-3 pt-1">HIRE QUICK!</div>

            </div>





        </div>

        <?php

        $keyskill=\App\JobSkill::all();

        $city=\App\User::orderBy('current_location')->get()->whereNotNull('current_location')->unique('current_location');

        //  $t4=(isset($skill) ? $skill->keyskill:'');

        //  echo $skill

        ?>





        <form action="{{route('home.search1')}}" method="post">

            @csrf

            <div class="row space_2 pb-5">

                <div class="col-lg col-xl-3 choose-skills position_lit notice-period">

                    <!-- <select name="skills[]" multiple class="select_skills form_control pl-3 pr-5" >

                    <option value="">Choose by Skills</option>

                    @foreach($keyskill as $skill)

                        <option value="{{$skill->id}}"   @if(isset($home_users)) @if(isset($selected_skill)) @if(in_array($skill->id, $selected_skill)) selected @endif  @endif  @endif   >{{$skill->job_skill}}</option>

                    @endforeach

                </select> -->

                    <select id="multiple-select-user_skill" class="form_control form_action rounded pl-3 pr-5"
                        multiple="multiple">
                        <option value="option1">Application Development</option>
                        <option value="option2">Architecture</option>
                        <option value="option3">Artificial Intelligence</option>
                        <option value="option4">Html</option>
                    </select>

                </div>

                <div class="col-lg position_lit notice-period">

                    <!-- <select name="location" class="form_control form_action rounded pl-3 pr-5" >

                    <option selected disabled>Choose by Location</option>

                    @foreach($city as $city)

                        @if($city)

                            <option value="{{$city->current_location}}" @if(isset($location)) @if($location == $city->current_location) selected @endif @endif>{{$city->current_location}}</option>

                        @endif

                    @endforeach

                </select> -->

                    <select id="multiple-select-user_location" class="form_control form_action rounded pl-3 pr-5"
                        multiple="multiple">
                        <option value="option1">Bangalore</option>
                        <option value="option2">Hyderabad</option>
                        <option value="option3">Mumbai</option>
                        <option value="option4">Delhi</option>
                    </select>

                </div>

                <div class="col-lg position_lit notice-period">

                    <!-- <select class="form_control form_action rounded pl-3 pr-5" name="notice_period">

               

                    <option selected disabled>Choose by Notice Period</option>
                    <option value="1" @if(isset($notice_period)) @if($notice_period=="1") selected @endif  @endif>Immediately Available</option>
                    <option value="2" @if(isset($notice_period)) @if($notice_period=="2") selected @endif  @endif>Serving Notice Period</option>
                    <option value="3" @if(isset($notice_period)) @if($notice_period=="3") selected @endif  @endif>Buyable Notice Period</option>
                    <option value="4" @if(isset($notice_period)) @if($notice_period=="4") selected @endif  @endif>Not Under Notice Period</option>

                </select> -->

                    <select id="multiple-select-user_notice" class="form_control form_action rounded pl-3 pr-5"
                        multiple="multiple">
                        <option value="option1">Immediately Available</option>
                        <option value="option2">Serving Notice Period</option>
                        <option value="option3">Zero Notice Period</option>
                        <option value="option4">Any</option>
                    </select>

                </div>

                <div class="col-lg-2 box">

                    <button type="submit" class="btn btn_submit w-100 text-light">Submit</button>

                </div>

            </div>

        </form>



        @if(isset($home_users))



        <?php 

    $users=\App\User::where('complete','>=',13)->orderBy('created_at','desc')->paginate(20);

    $count = count($users);

$keyskill=\App\JobSkill::all();

       

       

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





            <div class="boxing rounded px-4">

                <div class="row">

                    <div class="col-lg-9 col-xl-10 pt-3">

                        <ul class="list-inline">

                            <li class="list-inline-item pr-3 font_color">{{$latestdesg}}</li>

                            <li class="list-inline-item pr-3">Latest Company: {{$latestcom}} </li>

                            <li class="list-inline-item pr-3">Exp: {{$experience}}</li>

                            <li class="list-inline-item pr-3">

                                <img class="pb-1" src="asset/images/location.svg">

                                {{$user->current_city}}
                            </li>

                            <li class="list-inline-item pr-3">CTC: {{$ctc}} LPA</li>

                            <li class="list-inline-item pr-3">ECTC: {{$ectc}} LPA</li>

                            @if ($days != 0)

                            <li class="list-inline-item pr-5">Notice Period: {{$days}} </li>

                            @else

                            <li class="list-inline-item pr-5">Notice Period: {{$days}}</li>

                            @endif

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

?> <li class="list-inline-item terms mb-1">{{(isset($job_skill->job_skill)? $job_skill->job_skill:'')}}</li>

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



                    <div class="col-lg-3 col-xl-2 align-self-center">

                        <a class="btn btn_style mx-auto mb-3 mb-lg-0" onclick="alert('Please Login as a Employer')">View
                            Resume</a>

                    </div>

                </div>

            </div>

            @empty
            <h4 style="
    text-align: center;
    font-size: 30px;
">"No Search Results Found!"</h4>
            @endforelse





        </div>

        @if($count > 20)

        <div class="col-md-12 text-center align-self-center py-4 py-lg-5">

            <a class="btn btn_style_1 mx-auto">VIEW ALL CANDIDATES </a>

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


        <div class="boxing rounded px-4">

            <div class="row">

                <div class="col-lg-9 col-xl-10 pt-3">

                    <ul class="list-inline">

                        <li class="list-inline-item pr-3 font_color">{{$latestdesg}}</li>

                        <li class="list-inline-item pr-3">Latest Company: {{$latestcom}} </li>

                        <li class="list-inline-item pr-3">Exp: {{$experience}}</li>

                        <li class="list-inline-item pr-3">

                            <img class="pb-1" src="asset/images/location.svg">

                            {{$user->current_city}}
                        </li>

                        <li class="list-inline-item pr-3">CTC: {{$ctc}} LPA</li>

                        <li class="list-inline-item pr-3">ECTC: {{$ectc}} LPA</li>

                        @if ($days != 0)

                        <li class="list-inline-item pr-5">Notice Period: {{$days}} </li>

                        @else

                        <li class="list-inline-item pr-5">Notice Period: {{$days}}</li>

                        @endif

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

?> <li class="list-inline-item terms mb-1">{{(isset($job_skill->job_skill)? $job_skill->job_skill:'')}}</li>

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



                <div class="col-lg-3 col-xl-2 align-self-center">

                    <a class="btn btn_style mx-auto mb-3 mb-lg-0" onclick="alert('Please Login as a Employer')">View
                        Resume</a>

                </div>

            </div>

        </div>

        @endif

        @endforeach





    </div>

    @if($count > 20)

    <div class="col-md-12 text-center align-self-center py-4 py-lg-5">

        <a class="btn btn_style_1 mx-auto">VIEW ALL CANDIDATES </a>

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









{{-- <div class="col-lg-3">

	<div class="usernavwrap">

    <div class="switchbox">

        <div class="txtlbl">{{__('Immediate Available')}} <i class="fa fa-info-circle" data-toggle="popover"
    data-trigger="hover" data-placement="top" data-content="{{__('Are you immediate available')}}?"
    data-original-title="{{__('Are you immediate available')}}?" title="{{__('Are you immediate available')}}?"></i>

</div>

<div class="">

    <label class="switch switch-green"> @php

        $checked = ((bool)Auth::user()->is_immediate_available)? 'checked="checked"':'';

        @endphp

        <input type="checkbox" name="is_immediate_available" id="is_immediate_available" class="switch-input"
            {{$checked}}
            onchange="changeImmediateAvailableStatus({{Auth::user()->id}}, {{Auth::user()->is_immediate_available}});">

        <span class="switch-label" data-on="On" data-off="Off"></span> <span class="switch-handle"></span> </label>

</div>

<div class="clearfix"></div>

</div>

<ul class="usernavdash">

    <li class="active"><a href="{{route('home')}}"><i class="fa fa-tachometer" aria-hidden="true"></i>
            {{__('Dashboard')}}</a>

    </li>

    <li><a href="{{ route('my.profile') }}"><i class="fa fa-pencil" aria-hidden="true"></i> {{__('Edit Profile')}}</a>

    </li>

    <li><a href="{{ route('view.public.profile', Auth::user()->id) }}"><i class="fa fa-eye" aria-hidden="true"></i>
            {{__('View Public Profile')}}</a>

    </li>

    <li><a href="{{ route('my.job.applications') }}"><i class="fa fa-desktop" aria-hidden="true"></i>
            {{__('My Job Applications')}}</a>

    </li>

    <li><a href="{{ route('my.favourite.jobs') }}"><i class="fa fa-heart" aria-hidden="true"></i>
            {{__('My Favourite Jobs')}}</a>

    </li>

    <li><a href="{{ route('my-alerts') }}"><i class="fa fa-bullhorn" aria-hidden="true"></i> {{__('My Job Alerts')}}</a>

    </li>

    <li><a href="{{url('my-profile#cvs')}}"><i class="fa fa-file-text" aria-hidden="true"></i>
            {{__('Manage Resume')}}</a>

    </li>

    <li><a href="{{route('my.messages')}}"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{__('My Messages')}}</a>

    </li>

    <li><a href="{{route('my.followings')}}"><i class="fa fa-user-o" aria-hidden="true"></i> {{__('My Followings')}}</a>

    </li>

    <li><a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"
                aria-hidden="true"></i> {{__('Logout')}}</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">

            {{ csrf_field() }}

        </form>

    </li>

</ul>

</div>

<div class="row">

    <div class="col-md-12">{!! $siteSetting->dashboard_page_ad !!}</div>

</div>



</div> --}}



@push('scripts')

<script>
//script to select input
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
//script to select input
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

// multiple select skill
$('#multiple-select-user_skill').multiselect({
    includeSelectAllOption: false,
    nonSelectedText: 'Choose by Skills',
    numberDisplayed: 2,
    enableCaseInsensitiveFiltering: true,
    filterPlaceholder: 'Enter Skills',
});
// multiple select location
$('#multiple-select-user_location').multiselect({
    includeSelectAllOption: false,
    nonSelectedText: 'Choose by Location',
    numberDisplayed: 2,
    enableCaseInsensitiveFiltering: true,
    filterPlaceholder: 'Enter Location',
});
// multiple select notice
$('#multiple-select-user_notice').multiselect({
    includeSelectAllOption: false,
    nonSelectedText: 'Choose by Notice Period',
    numberDisplayed: 2,
});
</script>



@endpush