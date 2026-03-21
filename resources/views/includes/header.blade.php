<body data-spy="scroll" data-target="#myScrollspy" data-offset="1">
    <section class="header light">

        <div class="container light">

            <div class="row">

                <div class="col-lg-12">

                    <nav class="navbar navbar-expand-lg navbar-light px-0 custom_nav_hover">
                        @if (Auth::check())
                            <a class="navbar-brand pr-sm-3" href="{{ url('jobs') }}"><img
                                    src="{{ asset('/') }}asset/images/logo.svg"></a>
                        @elseif(Auth::guard('company')->check())
                            <a class="navbar-brand pr-sm-3" href="{{ url('jobs') }}"><img
                                    src="{{ asset('/') }}asset/images/logo.svg"></a>
                        @else
                            <a class="navbar-brand pr-sm-3" href="{{ url('jobs') }}"><img
                                    src="{{ asset('/') }}asset/images/logo.svg"></a>
                        @endif




                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                            aria-label="Toggle navigation">

                            <span class="navbar-toggler-icon"></span>

                        </button>

                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

                            <ul class="navbar-nav ml-auto py-2 align-items-lg-center">



                                @if (Auth::check())
                                    <!--<a class="nav-link style_link {{ request()->routeIs('index') ? 'active_1' : '' }}" id="id_user_home" href="{{ url('/') }}">Home</a>-->
                                @elseif(Auth::guard('company')->check())
                                    {{-- <a class="nav-link style_link {{ request()->routeIs('index') ? 'active_1' : '' }}" id="id_company_home" href="{{url('/find-talent')}}">Find Talent</a> --}}
                                @else
                                    <!-- <li class="nav-item custom_nav_hover_li">

                                        <a class="nav-link style_link {{ request()->routeIs('index') ? 'active_1' : '' }}"
                                            id="id_home" href="{{ url('/find-talent') }}">Find Talent</a>
                                    </li>
                                    <li class="nav-item custom_nav_hover_li">

                                        <a class="nav-link style_link" id="id_job" href="{{ url('jobs') }}">Find
                                            Jobs</a>
                                    </li> -->
                                @endif





                                @if (Auth::guard('company')->check())
                                    <li class="nav-item custom_nav_hover_li">



                                        <a class="nav-link style_link   {{ request()->is('post-job') ? 'active_1' : '' }}"
                                            id="id_post_jobs" href="{{ url('post-job') }}">Post Jobs</a>
                                            


                                    </li>
                                    <li class="nav-item custom_nav_hover_li">



                                        <a class="nav-link style_link  {{ request()->routeIs('cv-search') ? 'active_1' : '' }}{{ request()->routeIs('candidate.filter1.search') ? 'active_1' : '' }}{{ request()->routeIs('candidate.filter2.search') ? 'active_1' : '' }}"
                                            id="id_candidate" href="{{ url('cv-search') }}">CV
                                            Search</a>



                                    </li>

                                    <!-- <li class="nav-item custom_nav_hover_li">-->

                                    <!--    <a class="nav-link style_link" id="id_pricing"-->
                                    <!--        href="{{ route('pricing') }}">Pricing</a>-->

                                    <!--</li>-->
                                @endif

                                {{-- <li class="nav-item custom_nav_hover_li">

                                    <a class="nav-link style_link" id="id_job" href="{{ url('jobs') }}">Find
                                        Jobs</a>
                                </li> --}}

                                @if (Auth::guard('company')->check())
                                    <li class="nav-item custom_nav_hover_li">

                                        <a class="nav-link style_link" id="id_pricing"
                                            href="{{ route('pricing') }}">Pricing</a>

                                    </li>
                                @endif




                                {{-- @if (!Auth::check())
                               

                                <li class="nav-item custom_nav_hover_li">

                                    <a class="nav-link style_link" id="id_whyus" href="{{route('about-us')}}">About</a>

                                </li>

                                @endif --}}
                                {{-- 
                                <li class="nav-item custom_nav_hover_li">

                                    <a class="nav-link style_link" id="id_contact"
                                        href="{{route('contact-us')}}">Contact</a>

                                </li> --}}

                                @if (!Auth::user() && !Auth::guard('company')->user())
                                    <li class="navbar-nav nav-item dropdown d-none  d-lg-block">
                                        <a class="nav-link dropdown-toggle mx-lg-3 mt-2 mt-lg-0 py-2 signin_button2 nav_sign_btn1 rounded px-2 px-sm-3 "
                                            href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                            aria-expanded="false">
                                            Employer
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('employer.login') }}">Sign In</a>
                                            <a class="dropdown-item" href="{{ route('company.register.page') }}">Sign
                                                Up</a>

                                        </div>
                                    </li>
                                    <li class="navbar-nav nav-item dropdown">
                                        <a class="nav-link dropdown-toggle py-2 mt-3 mt-lg-0 signin_button2 nav_sign_btn1 rounded px-2 px-sm-3"
                                            href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                            aria-expanded="false">
                                            Jobseeker
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('login') }}">Sign In </a>
                                            <a class="dropdown-item" href="{{ route('register') }}">Sign Up </a>

                                        </div>
                                    </li>
                                @endif

                                @if (Auth::check() || Auth::guard('company')->check())
                                    <li class="dropdown  text_account">
                                        <a class="dropdown-toggle  p-0 py-2 d-lg-none  text_account" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">My Account</a>


                                        <div class="dropdown-menu border_drop" aria-labelledby="dropdownMenuButton">
                                            @if (Auth::check())
                                                <a class="dropdown-item py-2 px-3" href="{{ route('my.profile') }}"><i
                                                        class="fa fa-tachometer pr-3" aria-hidden="true"></i>Candidate
                                                    Dashboard</a>

                                                <a class="dropdown-item py-2 px-3"
                                                    href="{{ url('my-job-applications') }}">
                                                    <i class="fa fa-list-alt pr-3" aria-hidden="true"></i>Applied
                                                    Jobs</a>

                                                <a class="dropdown-item py-2 px-3"
                                                    href="{{ url('change_password') }}"><i class="fa fa-key pr-3"
                                                        aria-hidden="true"></i>Change password</a>

                                                <a href="{{ route('logoutuser') }}" class="dropdown-item py-2 px-3"><i
                                                        class="fa fa-sign-out  pr-3" aria-hidden="true"></i>
                                                    {{ __('Logout') }}</a>
                                            @endif

                                            @if (Auth::guard('company')->check())
                                                <a class="dropdown-item py-2 px-3"
                                                    href="{{ url('employer-dashboard') }}"><i
                                                        class="fa fa-tachometer pr-3" aria-hidden="true"></i>Employer
                                                    Dashboard</a>

                                                <a class="dropdown-item py-2 px-3" href="{{ url('/find-talent') }}">
                                                    <i class="fa fa-graduation-cap pr-3" aria-hidden="true"></i>
                                                    Find Talent
                                                </a>
                                                <a class="dropdown-item py-2 px-3" href="{{ url('jobs') }}">
                                                    <i class="fa fa-search pr-3" aria-hidden="true"></i>
                                                    Find Jobs
                                                </a>

                                                <!-- <a class="dropdown-item py-2 px-3" href="{{ url('post-job') }}"><i
                                                        class="fa fa-tachometer pr-3" aria-hidden="true"></i>Post A
                                                    Free Job</a> -->
                                                <a class="dropdown-item py-2 px-3" href="{{ url('my-jobs') }}"><i
                                                        class="fa fa-list-alt pr-3" aria-hidden="true"></i>Jobs &
                                                    Applicants</a>
                                                <a class="dropdown-item py-2 px-3"
                                                    href="{{ url('update-profile') }}"><i class="fa fa-pencil pr-3"
                                                        aria-hidden="true"></i></i>Edit Profile</a>

                                                <a class="dropdown-item py-2 px-3"
                                                    href="{{ url('email-templates') }}"><i
                                                        class="fa fa-envelope pr-3" aria-hidden="true"></i></i>Email
                                                    Templates</a>

                                                <a class="dropdown-item py-2 px-3"
                                                    href="{{ url('saved-search') }}"><i class="fa fa-floppy-o pr-3"
                                                        aria-hidden="true"></i></i>Saved Search</a>

                                                <a class="dropdown-item py-2 px-3" href="{{ url('collections') }}"><i
                                                        class="fa fa-folder pr-3" aria-hidden="true"></i>My
                                                    Folders</a>

                                                <a class="dropdown-item py-2 px-3" href="profile.php"><i
                                                        class="fa fa-pencil-square-o pr-3"
                                                        aria-hidden="true"></i>Payment
                                                    History</a>

                                                <a class="dropdown-item py-2 px-3"
                                                    href="{{ url('unlocked-resumes') }}"><i class="fa fa-unlock pr-3"
                                                        aria-hidden="true"></i></i>Unlocked
                                                    Resumes</a>

                                                <a class="dropdown-item py-2 px-3"
                                                    href="{{ url('change-company-password') }}"><i
                                                        class="fa fa-key pr-3" aria-hidden="true"></i>Change
                                                    password</a>

                                                {{-- <a class="dropdown-item py-2 px-3" href="#"><i class="fa fa-sign-out  pr-3" aria-hidden="true"></i>Log out</a> --}}

                                                <a href="{{ route('logoutcompany') }}"
                                                    class="dropdown-item py-2 px-3"><i class="fa fa-sign-out  pr-3"
                                                        aria-hidden="true"></i> {{ __('Logout') }}</a>
                                            @endif
                                    </li>
                                @endif


                            </ul>

                            <!-- <div class="header_signup-signin d-lg-none pr-xl-0 px-0">

                            <ul class="list-inline pt-3">

                                <li class="list-inline-item"><a class="home_signup" href="signup.php">Sign Up</a></li>

                                <li class="list-inline-item"><a class="home_signin" href="signin.php">Sign In</a></li>

                            </ul>

                            </a>

                        </div> -->

                        </div>

                        <div class="dropdown d-none d-lg-block">
                            @if (Auth::user())
                                <a class="btn pr-0" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"><span
                                        class="name_tag px-2">{{ isset(Auth::user()->first_name) ? Auth::user()->first_name : '' }}</span>
                                    @if (Auth::user()->image)
                                        <img src="{{ asset('user_images/' . Auth::user()->image) }}" alt=""
                                            title="" class="image_style">
                                    @else
                                        <img src="{{ asset('/') }}asset/images/profile.png">
                                    @endif
                                </a>
                            @endif


                            @if (Auth::guard('company')->user())
                                <a class="btn pr-0" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"><span
                                        class="name_tag px-2">{{ Auth::guard('company')->user()->name }}</span>
                                    @php

                                        $company = Auth::guard('company')->user();

                                    @endphp

                                    @if ($company->logo)
                                        <img src="{{ asset('company_logos/' . $company->logo) }}" width="50px"
                                            height="50px" class="rounded-circle">
                                    @else
                                        <img src="{{ asset('/') }}asset/images/profile.png">
                                    @endif
                                </a>
                            @endif


                            <div class="dropdown-menu smith_boxdrop" aria-labelledby="dropdownMenuButton">

                                @if (Auth::check())
                                    <a class="dropdown-item py-2 px-3" href="{{ route('my.profile') }}"><i
                                            class="fa fa-tachometer pr-3" aria-hidden="true"></i>Candidate
                                        Dashboard</a>

                                    <a class="dropdown-item py-2 px-3" href="{{ url('my-job-applications') }}">
                                        <i class="fa fa-list-alt pr-3" aria-hidden="true"></i>Applied Jobs</a>

                                    <a class="dropdown-item py-2 px-3" href="{{ url('change_password') }}"><i
                                            class="fa fa-key pr-3" aria-hidden="true"></i>Change password</a>

                                    <a href="{{ route('logoutuser') }}" class="dropdown-item py-2 px-3"><i
                                            class="fa fa-sign-out  pr-3" aria-hidden="true"></i>
                                        {{ __('Logout') }}</a>
                                @endif

                                @if (Auth::guard('company')->check())
                                    <a class="dropdown-item py-2 px-3" href="{{ url('employer-dashboard') }}"><i
                                            class="fa fa-tachometer pr-3" aria-hidden="true"></i>Employer
                                        Dashboard</a>
                                    <a class="dropdown-item py-2 px-3" href="{{ url('/find-talent') }}">
                                        <i class="fa fa-graduation-cap pr-3" aria-hidden="true"></i>Find Talent
                                    </a>
                                    <a class="dropdown-item py-2 px-3" href="{{ url('jobs') }}">
                                        <i class="fa fa-search pr-3" aria-hidden="true"></i>
                                        Find Jobs
                                    </a>
                                    <!-- <a class="dropdown-item py-2 px-3" href="{{ url('post-job') }}"><i
                                            class="fa fa-sticky-note pr-3" aria-hidden="true"></i>Post A Free Job</a> -->
                                    <a class="dropdown-item py-2 px-3" href="{{ url('my-jobs') }}"><i
                                            class="fa fa-list-alt pr-3" aria-hidden="true"></i>Jobs & Applicants</a>
                                    <a class="dropdown-item py-2 px-3" href="{{ url('update-profile') }}"><i
                                            class="fa fa-pencil pr-3" aria-hidden="true"></i>Edit Profile</a>

                                    <a class="dropdown-item py-2 px-3" href="{{ url('email-templates') }}"><i
                                            class="fa fa-envelope pr-3" aria-hidden="true"></i></i>Email Templates</a>

                                    <a class="dropdown-item py-2 px-3" href="{{ url('saved-search') }}"><i
                                            class="fa fa-floppy-o pr-3" aria-hidden="true"></i></i>Saved Search</a>

                                    {{-- <a class="dropdown-item py-2 px-3" href="{{url('collections')}}"><i
                                            class="fa fa-folder pr-3" aria-hidden="true"></i>My Folders</a> --}}

                                    <a class="dropdown-item py-2 px-3" href="{{ route('front.payment.history') }}"><i
                                            class="fa fa-pencil-square-o pr-3" aria-hidden="true"></i>Payment
                                        History</a>

                                    <a class="dropdown-item py-2 px-3" href="{{ route('unlocked-resumes') }}"><i
                                            class="fa fa-unlock pr-3" aria-hidden="true"></i></i>Unlocked Resumes</a>

                                    <a class="dropdown-item py-2 px-3" href="{{ url('change-company-password') }}"><i
                                            class="fa fa-key pr-3" aria-hidden="true"></i>Change password</a>

                                    {{-- <a class="dropdown-item py-2 px-3" href="#"><i class="fa fa-sign-out  pr-3" aria-hidden="true"></i>Log out</a> --}}



                                    <a href="{{ route('logoutcompany') }}" class="dropdown-item py-2 px-3"><i
                                            class="fa fa-sign-out  pr-3" aria-hidden="true"></i>
                                        {{ __('Logout') }}</a>
                                @endif


                            </div>
                        </div>






                        <!-- <div class="header_signup-signin d-none d-lg-block pr-xl-0 px-0">

                            <ul class="list-inline pt-3">

                                <li class="list-inline-item"><a class="home_signup" href="signup.php">Sign Up</a></li>

                                <li class="list-inline-item"><a class="home_signin" href="signin.php">Sign In</a></li>

                            </ul>

                        </a>

                    </div> -->

                    </nav>





                </div>

            </div>

        </div>

    </section>



    <!--fixed icon-->




    <!-- nav_custom_btn py-2 -->
