

                 <div class="col-lg-9 footer-alignss">

                     {{-- {{$collections}} --}}

                     <div class="col-lg-12 candidates_job-dashboard py-3 px-0 pt-0">

                         <!-- <span class="candidate_title-head">Showing 46 <span class="candidate_text">Candidates</span></span> -->
                         <div class="row pb-4">
                        
                        <?php 
                        $company_id = Auth::guard('company')->user()->id ;      

                        $company_value = \App\Company::where('id', $company_id)->first();
                        $now = \Carbon\Carbon::now();
                        $end_date = $company_value->package_end_date;

                        //echo $end_date;
                        ?>
                        @if($end_date < $now )

                        <div class="col-12 text-right">  
                            <button type="submit" class="py-2 signin_button send_mail_btn rounded px-3" data-toggle="modal"   onclick="alert('Your Package Expired!')">Send Email</button>
                        </div>

                        @else      


                        <div class="col-12 text-right">  
                            <button type="submit" class="py-2 signin_button send_mail_btn rounded px-3" data-toggle="modal" data-target="#bulkemailmodal" data-id="">Send Email</button>
                        </div>


                        @endif




                        </div>
                         <div class="row mx-0 select-all py-2">

                             <div class="col-10">

                                 <div class="select_all-check d-flex align-items-center  d-inline">

                                     <span><input type="checkbox" id="select_all" class="checkbox_size" maxlength="100" required><label for="select_all" class="pl-2 sign_head mb-0">Select all to sent Email</label></span>

                                 </div>

                             </div>

                             <div class="col-2">

                                 <a id="filter_show-button" class="filter_icon-algin d-block d-lg-none" href="javascript:void(0);">

                                     <img class="filter_img-icon" src="asset/images/Group-1.png">

                                 </a>

                             </div>

                         </div>

                     </div>

@forelse ($filter_users as $user)

                  
                   <?php 

                       $users4 = \App\User::where('id',$user->user_id)->first();
                       

                       $company=\App\ProfileCityJobsCity::where('user_id',$user->id)->first();

                       

                       $summary=\App\ProfileSummary::where('user_id',$user->id)->first();

                       

                       $data2=\App\ProfileSummary::where('user_id',$user->id)->first();

                       $experience=(isset($data2) ? $data2->totalexp:'');

                       $latestdesg=(isset($data2) ? $data2->latestdesg:'');

                       $latestcom=(isset($data2) ? $data2->latestcom:'');

                       

                       $data3=\App\ProfileDetails::where('user_id',$user->id)->first();

                       $ctc=(isset($data3) ? $data3->expect_ctc_lakhs:'');

                       $ectc=(isset($data3) ? $data3->expect_ctc_lakhs3:'');

            

                       $todayDate = \Carbon\Carbon::now()->format('Y-m-d');

            

                       $notice_period=\App\ProfileNop::where('user_id',$user->id)->first();

            

                       $noticed=(isset($notice_period) ? $notice_period->nop_days:'');

                       // echo($noticed);

                       if (isset($noticed)) {

            
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


          
                           $com_id = Auth::guard('company')->user()->id ;

                           $emailed=\App\CollectionList::where('user_id',$user->id)->where('company_id',$com_id)->first();
// echo $emailed;
         

            $users4=\App\User::where('id',$user->id)->first();

                       } 

                   ?>

                      
@php
$date = $notice_period->last_working_day;
$datetime1 = strtotime($todayDate); // convert to timestamps    
$datetime2 = strtotime($date); // convert to timestamps  
@endphp      


@php
                                            
$location_values_un =  unserialize($user->prefered_city);

$count = count($location_values_un);

$two_value = array_slice($location_values_un,0,2);

$location_values =  implode(', ', $two_value);

@endphp
                      <div class="boxing @if(isset($emiled)) @if($emailed->emailed == 1) boxing stick_label_email @endif @endif rounded px-4" id="checkbox_list">

                          <div class="row">

                          <div class="col-12 pt-3">



                                   <ul class="list-inline mb-1">
                                    <li class="list-inline-item checkbox">
                                        <input type="checkbox" class="email_checkbox mail_send-box text-left" value="{{$user->id}}"> 
                                    </li>
                                    <li class="list-inline-item font_color">
                                      <span class="sign_head"><h4 class="mb-0">{{ $users4->first_name }}</h4></span>
                                  </li>
                              </ul>
                              <ul class="list-inline mb-1">
                              <li class="list-inline-item">
                                  <a href="mailto:{{ $users4->email }}" class="contact_mail">
                                      <i class="fa fa-envelope-o pr-2 text-primary" aria-hidden="true"></i>{{ $users4->email }}
                                  </a>
                              </li>
                              <li class="list-inline-item">
                                  <a href="tel: +91 {{ $users4->phone }}" class="contact_phone">
                                      <i class="fa fa-phone text-primary pr-2" aria-hidden="true"></i>+91 {{ $users4->phone }}
                                  </a>
                              </li>
                              {{-- <li class="list-inline-item">
                                  <img class="pb-1" src="{{ asset('/') }}asset/images/location.svg"/>
                                  @if($count > 2)
                                  {{ $location_values??''}} <span class="candidate_view-more mb-0 " style="color: #197ff3;"
                                  >More +</span>
                                  @else
                                  {{ $location_values??''}}
                                  @endif
                              </li> --}}
                               </ul>

                               <ul class="list-inline job_view mb-1">

                                   <li class="list-inline-item font_color">{{$latestdesg}}</li>

                                   <li class="list-inline-item"><span>Latest Company:</span> {{$latestcom}} </li>

                                   <li class="list-inline-item"><span>Curr. Location:</span> {{ $users4->current_city }}</li>

                                   <li class="list-inline-item">
                   
                                       <span>Pref. Location:</span>
                   
                                    @if($count > 2)
                                    {{ $location_values??''}} <span class="candidate_view-more mb-0 " style="color: #197ff3;"
                                    >More +</span>
                                    @else
                                    {{ $location_values??''}}
                                    @endif
                   
                                    </li>

                                   <li class="list-inline-item"><span>Exp:</span> {{$experience}}</li>

                                 

                                   <li class="list-inline-item"><span>CTC:</span> {{$ctc}} LPA</li>

                                   <li class="list-inline-item"><span>ECTC:</span> {{$ectc}} LPA</li>

                                   @if ($days != 0)

                                       <li class="list-inline-item pr-5"><span>Notice Period:</span> {{$days}} @if ($datetime1 < $datetime2)days @endif</li>

                                   @else

                                       <li class="list-inline-item pr-5"><span>Notice Period:</span> {{$days}}</li>

                                   @endif

                              </ul>

                              <?php 

                              $keyskill=\App\KeySkill::where('user_id',$user->id)->paginate(5);

                              

                             //  $t4=(isset($skill) ? $skill->keyskill:'');

                              //  echo $skill

                              ?>

                              <div class="section_2 pb-0">

                                <ul class="list-inline">


                                    @if (count($keyskill) < 5)
                                     @foreach ($keyskill as $skill) 
                                     <?php
                                                            
                                     $job_skill = \App\JobSkill::where('id', $skill->keyskill)->first();
        
                                     $key = \App\JobSkill::where('job_skill','like', '%' . session()->get('search') . '%')->first();
                                                            
                                     ?>
                                      <li class="list-inline-item terms mb-1">
        
        
                                        @if(str_contains($job_skill->job_skill, $key->job_skill??'') && !empty($key->job_skill))
                                       
                                       <span style="background-color:yellow">{{ isset($job_skill->job_skill) ? $job_skill->job_skill : '' }}  </span> 
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

                              @php
                              $now = \Carbon\Carbon::now();
                              @endphp
                               @if($user->package_end_date >  $now  )
                               <p class="list-inline-item mb-0 express-job"  data-toggle="tooltip" data-placement="top" title='"Xpress Job Seeker" are looking for jobs on immediate basis.'>Xpress Job Seeker</p>
                               @endif     

                          </div>

                    

                          </div>

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

     