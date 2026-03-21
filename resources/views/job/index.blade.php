@extends('layouts.app')

@section('content')

@include('includes.header')

<section class="postjob-listing pt-lg-5 pb-lg-3 py-md-4 py-3 section_canddashboard job-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 my-auto text-center">
                <h1 class="line_change_1 pt-4">Search Jobs From Our Top Recruiters</h1>
                <p class="py-4">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus magnam sunt amet quia sed error! Cupiditate officia molestias in nesciunt hic possimus nisi ratione dicta ipsam tenetur, provident impedit veritatis.</p>
            </div>
            <div class="col-lg-12 my-auto px-0 pb-5">
                <div class="searchwrapper">
                    <div class="searchbox">
                        <div class="row">
                        <div class="col-md-4 col-12 position-relative px-lg-2 px-4 job-input"><i class="fa fa-search"></i><input type="text" class="form-control" placeholder="Search Jobs"></div>
                        <div class="col-md-3 col-12 position-relative pl-lg-0 pr-lg-4 px-4 mt-md-0 mt-3 job-input"><i class="fa fa-map-marker"></i><select class="form-control Location">
                            <option>Location</option>
                            <option>Banglore</option>
                            <option>Ernakulam</option>
                            <option>Bombay</option>
                            <option>Coimbatore</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-12 position-relative px-lg-2 px-4 mt-md-0 mt-3 job-input">
                            <i class="fa fa-calendar pr-2"></i><select class="form-control Experience">
                            <option>Experience</option>
                            <option>0-1 Years</option>
                            <option>1-2 Years</option>
                            <option>2-3 Years</option>
                            <option>3-4 Years</option>
                            <option>4-5 Years</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-12 my-md-auto text-lg-right mt-3"><input type="button" class="btn btn-primary" value="Search"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel owl-theme px-4">
                <div class="item"><a href="#"><h4 class="terms">Android Developer</h4></a></div>
                <div class="item"><a href="#"><h4 class="terms">ETL Developer</h4></a></div>
                <div class="item"><a href="#"><h4 class="terms">HTML Developer</h4></a></div>
                <div class="item"><a href="#"><h4 class="terms">Flutter Developer</h4></a></div>
                <div class="item"><a href="#"><h4 class="terms">UI/UX Developer</h4></a></div>
                <div class="item"><a href="#"><h4 class="terms">ReactJs Developer</h4></a></div>
                <div class="item"><a href="#"><h4 class="terms">PHP Developer</h4></a></div>
                <div class="item"><a href="#"><h4 class="terms">Laravel Developer</h4></a></div>
                <div class="item"><a href="#"><h4 class="terms">Django Developer</h4></a></div>
                <div class="item"><a href="#"><h4 class="terms">Wordpress Developer</h4></a></div>
                <div class="item"><a href="#"><h4 class="terms">Magento Developer</h4></a></div>
                <div class="item"><a href="#"><h4 class="terms">Expressjs Developer</h4></a></div>
            </div>
        </div>
    </div>
</section>


<section class="postjob-listing pt-lg-5 pb-lg-5 pt-4 pb-4 section_canddashboard">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-3 col-md-5">
                <div class="boxing-job dash_box-right pt-4 mt-2 px-4 pb-4">
                    <h2 class="pb-2">Please login/register to</h2>
                    <ul class="list-inline">
                        <li class="pb-2"><i class="fa fa-angle-double-right pr-2"></i>Apply for jobs</li>
                        <li class="pb-2"><i class="fa fa-angle-double-right pr-2"></i>Get personalized job recommendations</li>
                        <li class="pb-2"><i class="fa fa-angle-double-right pr-2"></i>Stay updated with Job alerts</li>
                        <li class="pb-2"><i class="fa fa-angle-double-right pr-2"></i>Avail benefits of career services</li>
                    </ul>
                    <div>
                    <a href="#"><button type="submit" class="btn btn-apply-1 mb-2 mb-sm-2 mr-2">Login</button></a>
                    <a href="#"><button type="submit" class="btn btn-apply-1 mb-2 mb-sm-2 mr-2">Register</button></a>
                    </div>
                </div>
                <div class="boxing-job top-recruiters pt-4 mt-2 px-4 pb-4">
                    <h2 class="pb-2">Get 3X more profile views from it recruiters</h2>
                    <p class="text-white">Increase your chances of callback with ZNP FastForward</p>
                    <div>
                    <a href="#">Know More</a>
                    </div>
                </div>
                <div class="boxing-job dash_box-right mt-2 px-2 pb-4 pt-4">
                    <div class="col-12">
                        <h2 class="pl-2">Top Recruiters</h2>
                    </div>
                    <div class="row px-4 top-priority">
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                        <div class="col-4 mt-2">
                        <img src="{{asset('/')}}asset/images/industry-logo.png">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-7 pr-lg-0 jobs-list">
               @foreach ($jobs as $job)
               <div class="boxing-job bg-white pt-4 mt-2">
                <div class="row px-lg-4 px-2 px-md-4">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-1 text-lg-center text-start col-2 px-lg-0 px-md-3 px-2">
                                @if($job->company->logo)
                                <img src="{{ asset('company_logos/'.$job->company->logo) }}"> 
                                @else
                                <img src="{{asset('/')}}asset/images/profile.png">
                                @endif
                               
                            </div>
                            <div class="col-lg-11 col-10 px-lg-0 my-auto px-2 px-md-3">
                                <h3 class="line_change">{{ $job->job_title??'' }} </h3> 
                                <h4 class="text-dark">{{ $job->company->name }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 pt-2">
                        <ul class="list-inline mb-0 mb-lg-2">
                            <li class="list-inline-item"><i class="fa fa-map-marker pr-2"></i> {{ $job->location??'' }} </li>
                            <li class="list-inline-item"><i class="fa fa-suitcase mr-2"></i> {{ $job->job_type??'' }}</li>
                            <li class="list-inline-item"><i class="fa fa-money pr-2"></i> {{ $job->min_salary ??'' }}lakh - {{ $job->max_salary ??'' }}lakh</li>
                            <li class="list-inline-item"><i class="fa fa-calendar pr-2"></i> {{ $job->experience??'' }}</li>
                            <li class="list-inline-item"><i class="fa fa-user-plus pr-2"></i> {{ $job->no_of_openings??'' }}</li>
                        </ul>
                    </div>
                    <div class="col-lg-12 border-bottom pb-4 mb-2 pb-lg-2 pt-3 pt-lg-0">
                        <ul class="list-inline mb-0 mb-lg-2 skills">
                            @php

                                $sks = [];
                            
                                    foreach($job->jobskills as $j)
                                    {
                                        $sks[] =  $j->job_skill_id;
                                    }

                                    $jobskills = \App\JobSkill::whereIn('id',$sks)->select('job_skill')->get();
                                                        
                            @endphp
                            @foreach ($jobskills as $skill)
                            <li class="list-inline-item">{{ $skill->job_skill }}</li>
                            @endforeach
                            
                           
                        </ul>
                    </div>
                    <div class="col-lg-6 pt-2 pt-lg-0">
                        <ul class="date">
                            <li class="list-inline-item"><span>Posted Date : </span>{{ \Carbon\Carbon::parse($job->created_at)->format('d-m-Y')  }}</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 pb-md-3 pb-lg-0 text-lg-right view">
                        <a href="{{ url('job-details') }}"><button type="submit" class="btn btn-apply mb-2 mb-sm-2 mr-2">View More</button></a>
                    </div>
                </div>
            </div>
               @endforeach
                
               
            </div>
        </div>
    </div>
</section>


@include('includes.footer')

@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        responsiveClass:true,
        autoplay:true,
        autoplayTimeout:2000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            567:{
                items:2,
                nav:true
            },
            768:{
                items:3,
                nav:true,
            },
            992:{
                items:6,
                nav:true,
                loop:false
            }
        }
    })
})
</script>
@endpush