@extends('layouts.app')

@section('content')

@include('includes.header')
<style>
    #ui-id-1 :is(li.ui-menu-item:hover, li.ui-menu-item.active ) {
        background-color: #e3eaf2;
    }
  .pagination{
    justify-content:center!important;
  }

  .pagination .results-range
  {
    display: none!important;
  }
  @media screen and (max-width: 567px){ col-change { padding-left: 0;}}
</style>

<section class="postjob-listing  pb-lg-3   section_canddashboard job-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 my-auto text-center">
                <h1 class="line_change_1  py-4 mb-0">Find Jobs From Top Recruiters Now!</h1>
                {{-- <p class="">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus magnam sunt amet quia sed error! Cupiditate officia molestias in nesciunt hic possimus nisi ratione dicta ipsam tenetur, provident impedit veritatis.</p> --}}
            </div>
            <div class="col-lg-12 my-auto px-0 pb-4">
                <div class="searchwrapper">
                    <div class="searchbox">
                        <div class="row">
                            
                        <div class="col-md-4 col-12 position-relative px-lg-2 px-4 job-input"><i class="fa fa-search"></i>
                            <input type="text" id="tags"  class="form-control searchfield" placeholder="Enter Skills / Designation">
                        </div>
                        <div class="col-md-3 col-12 position-relative pl-lg-0 pr-lg-4 px-4 mt-md-0 mt-3 job-input"><i class="fa fa-map-marker"></i>
                            <input type="text" id="locationFilter3"  class="form-control " placeholder="Enter Location" value="{{ request('location') }}">
                           
                        </div>
                        <div class="col-md-3 col-12 position-relative px-lg-2 px-4 mt-md-0 mt-3 job-input">
                            <i class="fa fa-calendar pr-2"></i>
                            <select  id="experienceFilter" class="form-control Experience">
                            <option >Select Experience</option>
                            <option>Less than 1 year</option>
                            <option>1 Year</option>
                            <option>2 Years</option>
                            <option>3 Years</option>
                            <option>4 Years</option>
                            <option>5 Years</option>
                            <option>6 Years</option>
                            <option>7 Years</option>
                            <option>8 Years</option>
                            <option>9 Years</option>
                            <option>10 Years</option>
                            <option>11 Years</option>
                            <option>12 Years</option>
                            <option>13 Years</option>
                            <option>14 Years</option>
                            <option>15 Years</option>
                            <option>16 Years</option>
                            <option>17 Years</option>
                            <option>18 Years</option>
                            <option>19 Years</option>
                            <option>20 Years</option>
                            <option>21 Years</option>
                            <option>22 Years</option>
                            <option>23 Years</option>
                            <option>24 Years</option>
                            <option>25 Years</option>
                            <option>26 Years</option>
                            <option>27 Years</option>
                            <option>28 Years</option>
                            <option>29 Years</option>
                            <option>30 Years</option>                            
                            </select>
                        </div>
                        <div class="col-md-2 col-12 my-md-auto d-flex justify-content-between align-items-center mt-3">
                            <a class="pl-lg-2  order-2 order-md-2 " href="{{ url('jobs') }}" style="color:#197ff3;text-decoration: underline;">Clear</a>
                            <input type="button" class="btn btn-primary searchbtn  order-1 order-md-1" value="Search">
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel owl-theme px-4 job-category-carousel">
                @foreach ($titles as $title)
                <div class="item" id="jobcategory"><a href="#" onclick="getTitle(this)"><h4 class="terms" id="job_title">{{ $title??'' }}</h4></a></div>
                @endforeach
                
                
            </div>
        </div>
    </div>
</section>


<section class="postjob-listing  pb-lg-5 pb-4 section_canddashboard">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-3 col-md-5 order-2 order-md-1">
              
                <div class="boxing-job dash_box-right pt-4 mt-2 px-4 pb-4" style="border: 1px solid #377ff3;min-height: 312px;">
                    <h2 class="pb-2">@if(!Auth::check())Login/Register Now! @else Jobs @endif</h2>
                    <ul class="list-inline">
                        <li class="pb-2"><i class="fa fa-angle-double-right pr-2"></i>Apply for jobs</li>
                        <li class="pb-2"><i class="fa fa-angle-double-right pr-2"></i>Get personalized job recommendations</li>
                        <li class="pb-2"><i class="fa fa-angle-double-right pr-2"></i>Stay updated with Job alerts</li>
                        <li class="pb-2"><i class="fa fa-angle-double-right pr-2"></i>Annouce Your Interview Availability!</li>


                    </ul>
                    @if(!Auth::check())
                    <div class="d-flex">
                    <a href="{{ route('login') }}"><button type="submit" class="btn btn-apply-1 mb-2 mb-sm-2 mr-2">Login</button></a>
                    <a href="{{ route('register') }}"><button type="submit" class="btn btn-apply-1 mb-2 mb-sm-2 mr-2">Register Now!</button></a>
                    </div>
                    @endif

                </div>  
              
                <div class="boxing-job top-recruiters pt-4 mt-2 px-4 pb-4"  >
                    <h2 class="pb-2">Hello Recruiter!</h2>
                    <p class="text-white">Login to the exclusive portal dedicated to jobseekers with ZERO Notice Period and Onboard them Immediately. </p>

                      <p class="text-white"> Find Jobseekers who are Open to Contracts.
                      
                     </p>
                    <div>
                    <a href="{{ url('employer-register') }}">Know More</a>
                    </div>
                </div>
                <div class="boxing-job dash_box-right mt-2 px-2" style="    min-height: 238.5px;
                border: 1px solid #377ff3;">
                  <div class="col-12 mt-4 mb-4">
                      
                    <p>Find Jobseekers with ZERO Notice Period under CV Search. </p>
                    <ul class="list-inline">
                      <li class="pb-2"><i class="fa fa-angle-double-right pr-2"></i>Find Contractors</li>
                      <li class="pb-2"><i class="fa fa-angle-double-right pr-2"></i>Find Recruiter Analyses</li>
                      <li class="pb-2"><i class="fa fa-angle-double-right pr-2"></i>Buy Single CVs</li>
                    </ul>
                    <a href="{{ route('login') }}">Login Now!</a>
                  </div>
                  <div class="row px-4 top-priority">
                  </div>
              </div>
            </div>
            <div class="col-lg-9 col-md-7 pr-lg-0 jobs-list order-1 order-md-2">
                <div class="boxing-job bg-white mt-2 mobile-view first">
                  <div class="row px-lg-4 px-2 px-md-4 jobs">
                    @include('job.job_result')                   
                </div>
                {{-- <div id="load" style="">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="position: absolute; left: 0; top: 0; z-index: 100000;" width="40px" height="40px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><circle cx="50" cy="50" fill="none" stroke="#000" stroke-width="8" r="35" stroke-dasharray="164.93361431346415 56.97787143782138"><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform></circle></svg>
                        
                </div> --}}
            </div>
        </div>
      </div>
  </div>
</section>

<section class="section_home-clients  mb-sm-3 pt-3">

  <div class="container">

      <div class="row">

          <div class="col-12">

              <h2 class="text-center mb-sm-4 pt-3 ">Top Employers in India</h2>

              <div id="carouselExampleControls" class="carousel slide py-4" data-ride="carousel">

                  <div class="carousel-inner">

                    

                      <div class="carousel-item active">

                          <div class="row px-xl-5">

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo5.png" alt="First slide" width="70%"></div>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo6.png" alt="First slide" width="70%"></div>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo7.png" alt="First slide" width="70%"></div>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo8.png" alt="First slide" width="70%"></div>
                              </div>

                          </div>
                          <div class="row px-xl-5">

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo1.png" alt="First slide" width="70%"></div>
                            </div>

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo2.png" alt="First slide" width="70%"></div>
                            </div>

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo3.png" alt="First slide" width="70%"></div>
                            </div>

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo4.png" alt="First slide" width="70%"></div>
                            </div>


                        </div>

                      </div>

                      <div class="carousel-item">

                          <div class="row px-xl-5">

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo9.png" alt="First slide" width="70%"></div>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo10.png" alt="First slide" width="70%"></div>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo11.png" alt="First slide" width="70%"></div>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo12.png" alt="First slide" width="70%"></div>
                              </div>
                                  

                          </div>
                          <div class="row px-xl-5">

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo1.png" alt="First slide" width="70%"></div>
                            </div>

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo2.png" alt="First slide" width="70%"></div>
                            </div>

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo3.png" alt="First slide" width="70%"></div>
                            </div>

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo4.png" alt="First slide" width="70%"></div>
                            </div>


                        </div>

                      </div>

                      <div class="carousel-item">

                          <div class="row px-xl-5">

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo13.png" alt="First slide" width="70%"></div>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo14.png" alt="First slide" width="70%"></div>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo16.png" alt="First slide" width="70%"></div>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo17.png" alt="First slide" width="70%"></div>
                              </div>

                          </div>
                          <div class="row px-xl-5">

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo1.png" alt="First slide" width="70%"></div>
                            </div>

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo2.png" alt="First slide" width="70%"></div>
                            </div>

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo3.png" alt="First slide" width="70%"></div>
                            </div>

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo4.png" alt="First slide" width="70%"></div>
                            </div>


                        </div>

                      </div>

                       <div class="carousel-item">

                      <div class="row px-xl-5">

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo19.png" alt="First slide" width="70%"></div>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo20.png" alt="First slide" width="70%"></div>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo21.png" alt="First slide" width="70%"></div>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-3 py-3">
                                  <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo22.png" alt="First slide" width="70%"></div>
                              </div>

                          </div>
                          <div class="row px-xl-5">

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo1.png" alt="First slide" width="70%"></div>
                            </div>

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo2.png" alt="First slide" width="70%"></div>
                            </div>

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo3.png" alt="First slide" width="70%"></div>
                            </div>

                            <div class="col-6 col-sm-4 col-lg-3 py-3">
                                <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo4.png" alt="First slide" width="70%"></div>
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

<section class="popular-job py-3 border-top border-bottom">
  <div class="container">
    <h2 class="text-center pb-3">Popular Job Categories</h2>
    <div class="row">
      
      <div class="col-lg-2 py-3" style="padding: 0px 10px;">
        <a class="" href="{{ url('/jobs?searchfield=Hybrid') }}">
          <div class="border py-4 text-center shadow-1" style="
              border-radius:20px !important;border-color:#0a2cdb !important;" >
            <img src="{{asset('asset/images/hybrid.png')}}" alt="job-icon" class="img-fluid mb-3">
            <h3>Hybrid</h3>          
          </div>
        </a>
      </div>
      <div class="col-lg-2 py-3" style="padding: 0px 10px;">
        <a class="" href="{{ url('/jobs?searchfield=Work From Office') }}">
          <div class="border py-4 text-center shadow-1" style="border-radius:20px !important;border-color:#0a2cdb !important;">
            <img src="{{asset('asset/images/business-and-trade.png')}}" alt="job-icon" class="img-fluid mb-3">
            <h3>Work From Office</h3>        
          </div>
        </a>

      </div>
      <div class="col-lg-2 py-3" style="padding: 0px 10px;">
        <a class="" href="{{ url('/jobs?searchfield=Remote/WFH') }}">
            <div class="border py-4 text-center shadow-1" style="border-radius:20px !important;border-color:#0a2cdb !important;">
              <img src="{{asset('asset/images/freelancer.png')}}" alt="job-icon" class="img-fluid mb-3">
              <h3>Remote/WFH</h3>        
            </div>
        </a>
      </div>
      <div class="col-lg-2 py-3" style="padding: 0px 10px;">
        <a class="" href="{{ url('/jobs?searchfield=Temp WFH') }}">

          <div class="border py-4 text-center shadow-1" style="border-radius:20px !important;border-color:#0a2cdb !important;">
            <img src="{{asset('asset/images/work-from-home.png')}}" alt="job-icon" class="img-fluid mb-3">
            <h3>Temp WFH</h3>        
          </div>
      </a>
      </div>
      <div class="col-lg-2 py-3" style="padding: 0px 10px;">
        <a class="" href="{{ url('/jobs?searchfield=Full Time') }}">
        <div class="border py-4 text-center shadow-1" style="border-radius:20px !important;border-color:#0a2cdb !important;">
          <img src="{{asset('asset/images/employee.png')}}" alt="job-icon" class="img-fluid mb-3">
          <h3>Permanent Jobs</h3>        
        </div>
      </a>
      </div>
      <div class="col-lg-2 py-3" style="padding: 0px 10px;">
        <a class="" href="{{ url('/jobs?searchfield=Contract') }}">
          <div class="border py-4 text-center shadow-1" style="
            border-radius:20px !important;border-color:#0a2cdb !important;">
            <img src="{{asset('asset/images/contract.png')}}" alt="job-icon" class="img-fluid mb-3">
            <h3>Contract Jobs</h3>
          </div>
        </a>
      </div>
      <div class="col-lg-2 py-3" style="padding: 0px 10px;">
        <a class="" href="{{ url('/jobs?searchfield=Fresher') }}">
          <div class="border py-4 text-center shadow-1" style="
            border-radius:20px !important;border-color:#0a2cdb !important;">
            <img src="{{asset('asset/images/contract.png')}}" alt="job-icon" class="img-fluid mb-3">
            <h3>Fresher Jobs</h3>
          </div>
        </a>
      </div>
      <div class="col-lg-2 py-3" style="padding: 0px 10px;">
        <a class="" href="{{ url('/jobs?searchfield=Internship') }}">
          <div class="border py-4 text-center shadow-1" style="
            border-radius:20px !important;border-color:#0a2cdb !important;">
            <img src="{{asset('asset/images/contract.png')}}" alt="job-icon" class="img-fluid mb-3">
            <h3>Internship Jobs</h3>
          </div>
        </a>
      </div>
      <div class="col-lg-2 py-3" style="padding: 0px 10px;">
        <a class="" href="{{ url('/jobs?searchfield=Contract To Hire') }}">
          <div class="border py-4 text-center shadow-1" style="
            border-radius:20px !important;border-color:#0a2cdb !important;">
            <img src="{{asset('asset/images/contract.png')}}" alt="job-icon" class="img-fluid mb-3">
            <h3>Contract To Hire</h3>
          </div>
        </a>
      </div>
      <div class="col-lg-2 py-3" style="padding: 0px 10px;">
        <a class="" href="{{ url('/jobs?searchfield=Night Shift (9 PM Onwards)') }}">
          <div class="border py-4 text-center shadow-1" style="
            border-radius:20px !important;border-color:#0a2cdb !important;">
            <img src="{{asset('asset/images/contract.png')}}" alt="job-icon" class="img-fluid mb-3">
            <h3>Night Shift Jobs</h3>
          </div>
        </a>
      </div>
      <div class="col-lg-2 py-3" style="padding: 0px 10px;">
        <a class="" href="{{ url('/jobs?searchfield=Day Shift') }}">
          <div class="border py-4 text-center shadow-1" style="
            border-radius:20px !important;border-color:#0a2cdb !important;">
            <img src="{{asset('asset/images/contract.png')}}" alt="job-icon" class="img-fluid mb-3">
            <h3>Day Shift Jobs</h3>
          </div>
        </a>
      </div>
      <div class="col-lg-2 py-3" style="padding: 0px 10px;">
        <a class="" href="{{ url('/jobs?location=Walkin') }}">
          <div class="border py-4 text-center shadow-1" style="
            border-radius:20px !important;border-color:#0a2cdb !important;">
            <img src="{{asset('asset/images/contract.png')}}" alt="job-icon" class="img-fluid mb-3">
            <h3>Walkin Jobs</h3>
          </div>
        </a>
      </div>
    
    </div>
  </div>
</section>
{{-- <section class="terminal-section py-5 my-5">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-12">
        <h2>Terminals</h2>
        <p class="mx-auto para-align">Lorem ipsum dolor sit amet consectetur. Aliquam tortor sit tempus purus egestas tincidunt vitae. 
          Nibh egestas etiam placerat iaculis congue commodo. Pharetra lacus ante commodo aliquam viverra. 
          Lacinia ultricies.
        </p>
      </div>
      <div class="owl-carousel owl-theme terminal-carousel">
        <div class="item">
          <img src="{{asset('asset/images/test-1.png')}}" alt="people" class="rounded-circle img-fluid mb-4">
          <div class="terminal-content mx-auto p-4 position-relative">
            <img src="{{asset('asset/images/polygon.png')}}" alt="polygon" class="img-fluid polygon">
            <p>Lorem ipsum dolor sit amet consectetur. At sit dui porta adipiscing nunc nullam amet. 
            Convallis massa nibh bibendum sem nunc. Maecenas viverra sem cras facilisi quis porttitor habitant turpis. 
            Porttitor adipiscing at semper quam ultricies amet suspendisse id. Nisl at praesent ut id congue risus non.
            </p>
            <ul>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
            </ul>
            <h3>Raja Sekaran</h3>
            <h4>UX UI Designer</h4>
          </div>
        </div>
        <div class="item">
          <img src="{{asset('asset/images/test-1.png')}}" alt="people" class="rounded-circle img-fluid mb-4">
          <div class="terminal-content mx-auto p-4 position-relative">
            <img src="{{asset('asset/images/polygon.png')}}" alt="polygon" class="img-fluid polygon">
            <p>Lorem ipsum dolor sit amet consectetur. At sit dui porta adipiscing nunc nullam amet. 
            Convallis massa nibh bibendum sem nunc. Maecenas viverra sem cras facilisi quis porttitor habitant turpis. 
            Porttitor adipiscing at semper quam ultricies amet suspendisse id. Nisl at praesent ut id congue risus non.
            </p>
            <ul>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
            </ul>
            <h3>Raja Sekaran</h3>
            <h4>UX UI Designer</h4>
          </div>
        </div>
        <div class="item">
          <img src="{{asset('asset/images/test-1.png')}}" alt="people" class="rounded-circle img-fluid mb-4">
          <div class="terminal-content mx-auto p-4 position-relative">
            <img src="{{asset('asset/images/polygon.png')}}" alt="polygon" class="img-fluid polygon">
            <p>Lorem ipsum dolor sit amet consectetur. At sit dui porta adipiscing nunc nullam amet. 
            Convallis massa nibh bibendum sem nunc. Maecenas viverra sem cras facilisi quis porttitor habitant turpis. 
            Porttitor adipiscing at semper quam ultricies amet suspendisse id. Nisl at praesent ut id congue risus non.
            </p>
            <ul>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
            </ul>
            <h3>Raja Sekaran</h3>
            <h4>UX UI Designer</h4>
          </div>
        </div>
        <div class="item">
          <img src="{{asset('asset/images/test-1.png')}}" alt="people" class="rounded-circle img-fluid mb-4">
          <div class="terminal-content mx-auto p-4 position-relative">
            <img src="{{asset('asset/images/polygon.png')}}" alt="polygon" class="img-fluid polygon">
            <p>Lorem ipsum dolor sit amet consectetur. At sit dui porta adipiscing nunc nullam amet. 
            Convallis massa nibh bibendum sem nunc. Maecenas viverra sem cras facilisi quis porttitor habitant turpis. 
            Porttitor adipiscing at semper quam ultricies amet suspendisse id. Nisl at praesent ut id congue risus non.
            </p>
            <ul>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
            </ul>
            <h3>Raja Sekaran</h3>
            <h4>UX UI Designer</h4>
          </div>
        </div>
        <div class="item">
          <img src="{{asset('asset/images/test-1.png')}}" alt="people" class="rounded-circle img-fluid mb-4">
          <div class="terminal-content mx-auto p-4 position-relative">
            <img src="{{asset('asset/images/polygon.png')}}" alt="polygon" class="img-fluid polygon">
            <p>Lorem ipsum dolor sit amet consectetur. At sit dui porta adipiscing nunc nullam amet. 
            Convallis massa nibh bibendum sem nunc. Maecenas viverra sem cras facilisi quis porttitor habitant turpis. 
            Porttitor adipiscing at semper quam ultricies amet suspendisse id. Nisl at praesent ut id congue risus non.
            </p>
            <ul>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
            </ul>
            <h3>Raja Sekaran</h3>
            <h4>UX UI Designer</h4>
          </div>
        </div>
        <div class="item">
          <img src="{{asset('asset/images/test-1.png')}}" alt="people" class="rounded-circle img-fluid mb-4">
          <div class="terminal-content mx-auto p-4 position-relative">
            <img src="{{asset('asset/images/polygon.png')}}" alt="polygon" class="img-fluid polygon">
            <p>Lorem ipsum dolor sit amet consectetur. At sit dui porta adipiscing nunc nullam amet. 
            Convallis massa nibh bibendum sem nunc. Maecenas viverra sem cras facilisi quis porttitor habitant turpis. 
            Porttitor adipiscing at semper quam ultricies amet suspendisse id. Nisl at praesent ut id congue risus non.
            </p>
            <ul>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
            </ul>
            <h3>Raja Sekaran</h3>
            <h4>UX UI Designer</h4>
          </div>
        </div>
        <div class="item">
          <img src="{{asset('asset/images/test-1.png')}}" alt="people" class="rounded-circle img-fluid mb-4">
          <div class="terminal-content mx-auto p-4 position-relative">
            <img src="{{asset('asset/images/polygon.png')}}" alt="polygon" class="img-fluid polygon">
            <p>Lorem ipsum dolor sit amet consectetur. At sit dui porta adipiscing nunc nullam amet. 
            Convallis massa nibh bibendum sem nunc. Maecenas viverra sem cras facilisi quis porttitor habitant turpis. 
            Porttitor adipiscing at semper quam ultricies amet suspendisse id. Nisl at praesent ut id congue risus non.
            </p>
            <ul>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
              <li class="d-inline"><img src="{{asset('asset/images/star.png')}}" alt="star" class="img-fluid"></li>
            </ul>
            <h3>Raja Sekaran</h3>
            <h4>UX UI Designer</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> --}}

<section class="job-notification my-2 pb-2 pt-4 ">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 my-auto col-change py-5 ">
        <h2>Get new job notification</h2>
        <p>Subscribe and get all noticed job recruiters</p>
        
          <form action="{{ url('newsletter') }}" class="form-search pt-3"  method="POST">
            @csrf
          <input type="search" name="email" placeholder="Enter your email">
          <button type="submit">Subscribe</button>
        </form>
      </div>
      <div class="col-lg-5 text-center">
        <img src="{{asset('asset/images/girl.png')}}" alt="logo" class="img-fluid">
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
      
      {{-- <a href="https://www.instagram.com/zeronoticeperiod" target="_blank" class="list_nav">
          <i  class="fa fa-instagram" aria-hidden="true"></i>
      </a> --}}




  </div>



</section>


@include('includes.footer')

@endsection

@push('scripts')
<script
    src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCejQVcKXrBxZGFj0EQpSHkLgOk_Lp6CRI&region=IN">
</script>
<script>
  document.addEventListener("keydown", function(event) {
  if (event.key === "ArrowDown") {
    event.preventDefault(); // Prevent default scrolling behavior
    const items = document.querySelectorAll(".ui-menu-item");
    const activeIndex = Array.from(items).findIndex(item => item.classList.contains("active"));

    if (activeIndex !== -1) {
      items[activeIndex].classList.remove("active");
      const newIndex = (activeIndex + 1) % items.length;
      items[newIndex].classList.add("active");
    } else {
      items[0].classList.add("active");
    }
  }
});
$(function() {
  function split(val) {
    return val.split(/,\s*/);
  }

  function extractLast(term) {
    console.log("Search Keywords:", term); 
    return split(term).pop();
  }

  $("#tags")
    .on("keydown", function(event) {
      if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
        event.preventDefault();
      }
    })
    .on("input", function() {
      this.value = this.value.replace(/[^\w\s,]/gi, '');
    })
    .autocomplete({
      minLength: 0,
      source: function(request, response) {
        $.ajax({
          url: "{{ url('autocomplete/skillsposition') }}",
          dataType: "json",
          data: {
            query: extractLast(request.term)
          },
          success: function(data) {
            response($.map(data, function(item) {
              return {
                label: item,
                value: item
              };
            }));
          }
        });
      },
      focus: function() {
        return false;
      },
      select: function(event, ui) {
        var terms = split(this.value);
        terms.pop();
        terms.push(ui.item.value);
        terms.push("");
        this.value = terms.join(", ");

        // Trigger typing after a value is selected
        
        document.getElementById("tags").blur()
        document.getElementById("tags").focus()

        
        return false;
      },
      open: function(event, ui) {
        var term = extractLast(this.value);
        var autocomplete = $(this).data("ui-autocomplete");
        autocomplete.menu.element.find("li").each(function() {
          var item = $(this).data("ui-autocomplete-item");
          var highlightedItem = item.label.replace(new RegExp($.ui.autocomplete.escapeRegex(term), "gi"), '<span class="highlight">$&</span>');
          $(this).html(highlightedItem);
        });
      }


      
    });



    $("#locationFilter3")
    .on("keydown", function(event) {
      if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
        event.preventDefault();
      }
    })
    .on("input", function() {
      this.value = this.value.replace(/[^\w\s,]/gi, '');
    })
    .autocomplete({
      minLength: 0,
      source: function(request, response) {
        $.ajax({
          url: "{{ url('autocomplete/search-location-job1') }}",
          dataType: "json",
          data: {
            query: request.term
          },
          success: function(data) {
            response($.map(data, function(item) {
              return {
                label: item,
                value: item
              };
            }));
          }
        });
      },
      focus: function() {
        return false;
      },
      select: function(event, ui) {
        this.value = ui.item.value;
        return false;
      },
      open: function(event, ui) {
        var term = this.value;
        var autocomplete = $(this).data("ui-autocomplete");
        autocomplete.menu.element.find("li").each(function() {
          var item = $(this).data("ui-autocomplete-item");
          var highlightedItem = item.label.replace(new RegExp($.ui.autocomplete.escapeRegex(term), "gi"), '<span class="highlight">$&</span>');
          $(this).html(highlightedItem);
        });
      }
    });



});

$(document).ready(function(){

    $('#load').hide();


   

    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        responsiveClass:true,
        autoplay:true,
        autoplayTimeout:2000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:2,
                nav:true
            },
            567:{
                items:3,
                nav:true
            },
            768:{
                items:4,
                nav:true,
            },
            992:{
                items:6,
                nav:true,
                loop:false
            }
        }
    })
});




function getTitle(element) {
        var jobTitle = $(element).text();
        performSearch(jobTitle);
    }


    // Move the event delegation to the document level to handle dynamically loaded pagination links
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();

        //$('#load').show();


        var url = $(this).attr('href');
        getJobs(url);
        window.history.pushState("", "", url);
    });

   


    var jobTitle ="";

    $(document).on('click', '.searchbtn', function(e) {
        e.preventDefault();
        performSearch(jobTitle);
    });

    $(document).on('keydown', '.searchfield', function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            $("#ui-id-1").hide();
            performSearch(jobTitle);
        }
    });
    $(document).on('click', '.jobcategory', function(e) {
        e.preventDefault();
        performSearch(jobTitle);
    });

   


    function performSearch(jobTitle) {
        var searchfield = $('.searchfield').val();
        var locationFilter = $('#locationFilter3').val();
        var experienceFilter = $('#experienceFilter').val();
        var jobtitle = jobTitle;
       
        var url = '{{ url("jobs") }}?location=' + locationFilter + '&experience=' + experienceFilter + '&searchfield=' + searchfield + '&jobtitle=' + jobtitle;
        getJobs(url);
        window.history.pushState("", "", url);
    }



    function getJobs(url) {
        $.ajax({
            url: url,
            success: function(data) {
                $('.jobs').html(data);
                // Reattach event handlers to the newly loaded pagination links
                reattachPaginationHandlers();
            },
            error: function(err) {
                alert("jobs cannot be loaded");
                console.log(err);
            },
            complete: function() {
            // Hide the loader after the request is complete (success or error)
            $('#load').hide();
        }
        });
    }

    // Function to reattach event handlers to pagination links
    function reattachPaginationHandlers() {
        $('.pagination a').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            getJobs(url);
            window.history.pushState("", "", url);
        });
    }


    var searchInput = 'locationFilter';



$(document).ready(function() {

    $location_input = $("#locationFilter");

    var autocomplete;

    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

        types: ['(cities)'],


        componentRestrictions: {

            country: "IN"

        }

    });



    google.maps.event.addListener(autocomplete, 'place_changed', function() {

        var near_place = autocomplete.getPlace();

        var location = $("#locationFilter").val();
        location = location.split(',')[0];
       
        $('#locationFilter').val(location);

    });

});

$('.terminal-carousel').owlCarousel({
    loop:true,
    nav:true,
    margin:10,
    responsiveClass:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})

$('.job-recruiter-carousel').owlCarousel({
    loop:true,
    nav:true,
    margin:10,
    responsiveClass:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
    </script>
@endpush