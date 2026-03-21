

    <?php 

    $users=\App\User::where('complete','>=',13)->orderBy('created_at','desc')->paginate(20);
    

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

                                &nbsp {{$user->current_location}}
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

       @endif