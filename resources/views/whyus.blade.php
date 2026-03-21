

@extends('layouts.app')

@section('content')

@include('includes.header')



<section class="number_board pt-5 pb-md-4 pb-xl-5">

    <div class="container">

        <div class="row">

            <div class="number_board-counter_1 col-12">

                <div class="style_text text-center">

                    ZeroNoticePeriod Metrics

                </div>

                <div class="number_board-counter row col-lg py-4 mx-0 my-0">

                    <div class="col-md-6 col-lg-5 offset-lg-1 number_board_1 text-center">

                    

                    <?php 

                    $counter=\App\Counter::all()->take(1);

                    

                    

                    //  echo $counter;

                    ?>

                @foreach($counter as $c)

                {{-- {{$c->counter}} --}}

                @endforeach

                    

                        <div class="run_number"><span

                            class="run_number counter" data-count="{{$c->counter}}">0</span>+</div>

                        <p class="typeo_class">NON IT IMMEDIATE HIRES</p>

                    </div>

                    <div class="col-md-5 number_board_2 md-6-p-0 mt-3 mt-md-0 text-center">

                        <div class="run_number"><span

                            class="run_number counter" data-count="{{$c->counter1}}">0</span>+</div>

                        <p class="typeo_class">IT IMMEDIATE HIRES</p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<section class="base_img pt-xl-4">

    <div class="container">

        <div class="row pt-2">

            <div class="col-lg-6 col-xl-5 py-0 text-left">

                <div class="list_img px-lg-0 pb-1">Why ZeroNoticePeriod?</div>
                <p> <b>Time is Money.</b> </p>
                <p> <b>We would say, Time is everything for an Employer, A Jobseeker & A Recruiter.</b></p>
                <p>And for the team at ZeroNoticePeriod,<b> YOUR Time Means EVERYTHING.</b></p>
                <p>Meet <b>ZeroNoticePeriod.com.</b></p>
                <p>We are an exclusive online hiring platform connecting Job seekers with ZERO Notice Period OR are Serving Notice Period. That’s our niche.</p>
                <p><b>A Recruiter spends upto 5 hours a day sifting through resumes trying to find “Quick joiners” or “Immediate joiners”. It changes NOW!</b></p>

                 <p><b>You log in. Search. Interview. Hire. Without having to worry about Notice Periods.</b>  </p>
                 <p>ZeroNoticePeriod is not limited to HR or Talent Acquisition Managers but can be accessed by Leaders hiring across all or any levels. Our philosophy is to help cut down the time to hire for an Employer and time to be hired for Talented Jobseekers.

                  </p>
                  <p>With a focused & verified database of Talent with Zero Notice Period, We help Employers hire at a very fast pace without having to lose time on "searching" talent with short/Zero notice period.</p>
                  <p>ZeroNoticePeriod equals Fastest Hiring.</p>
                  <p>We are here to help. Let’s Work Together!</p>
                  <p>Happy Hiring!</p>



            </div>

            <div class="col-lg-6 col-xl-7 text-center py-2 py-lg-0 text-lg-right align-self-center">
               <div class="whyus_last-title  px-lg-0 py-3 text-center">Hello Recruiter!</div>
                <video width="100%" height="335" controlsList="nodownload" controls>
                  <source src="{{ asset('/') }}asset/videos/employer.mp4" type="video/mp4">  
                </video>
                
                <div class="whyus_last-title  px-lg-0 py-3 text-center">Hello Jobseeker!</div>

              
                    <video width="100%" height="335" controlsList="nodownload" controls>
                  <source src="{{ asset('/') }}asset/videos/jobseeker.mp4" type="video/mp4">  
                </video>

            </div>

        </div>

    </div>

</section>



<!--image-->



{{-- <section class="content-head text-center py-2 py-md-5 mb-4 mb-md-5">

    <div class="container text-center">

        <div class="head1 py-2 py-md-4 mb-2 mb-md-4">

            <div class="how_text">How it works</div>

        </div>

        <div class="row align-items-center">

            <div class="col-sm-6 col-lg-4 pt-3 mb-4 mb-xl-0">

                <div class="row">

                    <div class="col-sm-3 align-self-center">

                        <img class="img-fluid" src="{{asset('/')}}asset/images/whyvoting.png">  

                    </div>    

                    <div class="col-sm-9 align-self-center pt-4 pt-sm-0">

                        <span class="whyus_last-title text-center text-sm-left float-sm-left">Register</span> 

                    </div>    

                </div>        

            </div>           

            <div class="col-sm-6 col-lg-4 pt-3 mb-4 mb-xl-0">

                <div class="row">

                    <div class="col-sm-3 align-self-center">

                        <img class="img-fluid" src="{{asset('/')}}asset/images/whybook.png">   

                    </div>    

                    <div class="col-sm-9 align-self-center pt-4 pt-sm-0">

                        <span class="whyus_last-title text-center text-sm-left float-sm-left">Buy database<br>subscriptions</span> 

                    </div>    

                </div> 

            </div>           

            <div class="col-sm-6 col-lg-4 m-auto pt-3 mb-4 mb-xl-0">

               <div class="row">

                    <div class="col-sm-3 align-self-center">

                        <img class="img-fluid" src="{{asset('/')}}asset/images/whylogin.png">  

                    </div>    

                    <div class="col-sm-9 align-self-center pt-4 pt-sm-0">

                        <span class="whyus_last-title text-center text-sm-left float-sm-left">Login to access<br>candidate database</span>

                    </div>    

                </div> 

            </div>

        </div>

    </div>

</section> --}}
<section class="section_home-clients py-5 ">

    <div class="container">

        <div class="row">

            <div class="col-12">

                <div class="list_img text-center mb-sm-4">Top Employers in India</div>

                <div id="carouselExampleControls" class="carousel slide py-4" data-ride="carousel">

                    <div class="carousel-inner">

                        <div class="carousel-item active">

                            <div class="row px-xl-5">

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo1.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo2.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo3.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo4.png" alt="First slide"></div>
                                </div>


                            </div>

                        </div>

                        <div class="carousel-item">

                            <div class="row px-xl-5">

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo5.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo6.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo7.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo8.png" alt="First slide"></div>
                                </div>

                            </div>

                        </div>

                        <div class="carousel-item">

                            <div class="row px-xl-5">

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo9.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo10.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo11.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo12.png" alt="First slide"></div>
                                </div>
                                    

                            </div>

                        </div>

                        <div class="carousel-item">

                            <div class="row px-xl-5">

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo13.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo14.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo16.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo17.png" alt="First slide"></div>
                                </div>

                            </div>

                        </div>

                         <div class="carousel-item">

                        <div class="row px-xl-5">

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo19.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo20.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo21.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo22.png" alt="First slide"></div>
                                </div>

                            </div>

                        </div>

                        <div class="carousel-item">

                            <div class="row px-xl-5">
    
                                    <div class="col-6 col-sm-4 col-lg-3 py-3">
                                        <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo23.png" alt="First slide"></div>
                                    </div>
    
                                </div>
    
                            </div>

                    </div>

                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">

                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>

                        <span class="sr-only">Previous</span>

                    </a>

                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">

                        <span class="carousel-control-next-icon" aria-hidden="true"></span>

                        <span class="sr-only">Next</span>

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

    <section class="four_links d-none d-sm-block">

        <div class="icons">

            <a href="https://www.linkedin.com/company/zeronoticeperiod" target="_blank" class="list_nav">
                <i class="fa fa-linkedin" aria-hidden="true"></i>
            </a>

            <a href="https://www.facebook.com/Zero-Notice-Period-100871645858475" target="_blank" class="list_nav">
                <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>

            <a href="https://twitter.com/ZNPTEAM" target="_blank" class="list_nav">
                <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>

            <a href="https://www.youtube.com/channel/UCA_pykWTYsltpgdinRQMOgg" target="_blank" class="list_nav">
                <i class="fa fa-youtube-play" aria-hidden="true"></i>
            </a>

            {{-- <a href="" target="_blank" class="list_nav">
                <i class="fa fa-instagram" aria-hidden="true"></i>
            </a> --}}

        </div>

    </section>

@include('includes.footer')

@endsection

@push('scripts') 



@endpush

