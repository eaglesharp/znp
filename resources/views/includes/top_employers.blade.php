@if(isset($home_users))

          

<?php 

$users=\App\User::where('complete','>=',13)->orderBy('created_at','desc')->paginate(20);



$keyskill=\App\JobSkill::all();

   

   

?>

<div class="job_offers pt-1">







@foreach ($home_users as $user)

    

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



         if ($noticed == 1) :

             $days = 'Immediately noticed';

         elseif ($noticed > 1):

             $period = $notice_period->last_working_day;

            //  echo($period);

             $datetime1 = strtotime($todayDate); // convert to timestamps

             $datetime2 = strtotime($period); // convert to timestamps

             $days = (int)(($datetime2 - $datetime1)/86400);

         else:

             $noticed = 'x is equal to y';

         endif;



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

                &nbsp Bangalore</li>

            <li class="list-inline-item pr-3">CTC: {{$ctc}} LPA</li>

            <li class="list-inline-item pr-3">ECTC: {{$ectc}} LPA</li>

            @if ($days != 0)

            <li class="list-inline-item pr-5">Notice Period: {{$days}} days</li>

        @else

            <li class="list-inline-item pr-5">Notice Period: {{$days}}</li>

        @endif

        </ul>

        <?php 

        $keyskill=\App\KeySkill::where('user_id',$user->id)->get();

        

       //  $t4=(isset($skill) ? $skill->keyskill:'');

        //  echo $skill

        ?>

        <div class="section_2 pb-0">

            <ul class="list-inline">

            @foreach($keyskill as $skill)

                <li class="list-inline-item terms mb-1">{{$skill->keyskill}}</li>

                @endforeach

                

            </ul>

        </div>

    </div>



    <div class="col-lg-3 col-xl-2 align-self-center">

        <a class="btn btn_style mx-auto mb-3 mb-lg-0" onclick="alert('Please Login as a Employer')">View Resume</a>

    </div>

    </div>

</div>

@endforeach





</div>



<div class="col-md-12 text-center align-self-center py-4 py-lg-5">

<a class="btn btn_style_1 mx-auto" >VIEW ALL CANDIDATES </a>

</div>

</div>

</div>

@else 



<?php 

$users=\App\User::where('complete','>=',13)->orderBy('created_at','desc')->paginate(20);







?>

<div class="job_offers pt-1">







@foreach ($users as $user)



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



                 if ($noticed == 1) :

                     $days = 'Immediately available';

                 elseif ($noticed > 1):

                     $period = $notice_period->last_working_day;

                    //  echo($period);

                     $datetime1 = strtotime($todayDate); // convert to timestamps

                     $datetime2 = strtotime($period); // convert to timestamps

                     if ($datetime1 < $datetime2) {

                        $days = (int)(($datetime2 - $datetime1)/86400);

                    } else {

                        $days = 'Immediately available';

                    }

                 else:

                     $noticed = 'x is equal to y';

                 endif;

       

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

        &nbsp Bangalore</li>

    <li class="list-inline-item pr-3">CTC: {{$ctc}} LPA</li>

    <li class="list-inline-item pr-3">ECTC: {{$ectc}} LPA</li>

    @if ($days != 0)

    <li class="list-inline-item pr-5">Notice Period: {{$days}} days</li>

@else

    <li class="list-inline-item pr-5">Notice Period: {{$days}}</li>

@endif

</ul>

<?php 

$keyskill=\App\KeySkill::where('user_id',$user->id)->get();



//  $t4=(isset($skill) ? $skill->keyskill:'');

//  echo $skill

?>

<div class="section_2 pb-0">

    <ul class="list-inline">

    @foreach($keyskill as $skill)

        <li class="list-inline-item terms mb-1">{{$skill->keyskill}}</li>

        @endforeach

        

    </ul>

</div>

</div>



<div class="col-lg-3 col-xl-2 align-self-center">

<a class="btn btn_style mx-auto mb-3 mb-lg-0" onclick="alert('Please Login as a Employer')">View Resume</a>

</div>

</div>

</div>

@endforeach





</div>



<div class="col-md-12 text-center align-self-center py-4 py-lg-5">

<a class="btn btn_style_1 mx-auto" >VIEW ALL CANDIDATES </a>

</div>

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

            <div class="number_board-counter  row col-lg py-sm-4 mx-0 my-0">

                <div class="col-md-6 col-lg-5 offset-lg-1 number_board_1 text-center">

                    <div class="run_number">

                    <span

                        class="run_number counter" data-count="3000">0</span>+</div>

                    <p class="typeo_class">NON IT IMMEDIATE HIRES</p>

                </div>

                <div class="col-md-5 number_board_2 md-6-p-0 mt-3 mt-md-0 text-center">

                    <div class="run_number"><span

                        class="run_number counter" data-count="2000">0</span>+</div>

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

            <div class="list_img px-lg-0">Why Zero Notice Period?</div>

            <ul class="list-group pl-4 mx-0 my-0">

                <li class="list-inline-item size_list pesudo_class px-3 mr-0">

                    All Candidates are VERIFIED for Notice Period by Qualified Recruiters to retain only candidates who are serving/completed Notice Periods.

                </li>

                <li class="list-inline-item size_list pesudo_class px-3 mr-0">

                    Database of QUICK JOINERS with Notice Period between 0 - 2 Weeks / Candidates Serving Notice Period / Candidates with Buyable Notice Period.

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

                    Mandatory Data Updates about Compensation (Current & EXPECTED), Competing Offers, Interview Availability.

                </li>

            </ul>

        </div>

        <div class="col-lg-7 text-center text-lg-right align-self-center">

            <img class="img img-fluid" src="asset/images/buying-a-building.png">

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