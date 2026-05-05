
<section class="header footer-color pt-5">
    <div class="container footer-color py-2">
        <div class="row py-2">
            <div class="col-lg-4">
                <a class="navbar-brand pr-sm-3 py-3" href="{{url('/')}}"><img
                    src="{{asset('/')}}asset/images/logo.svg"></a>
                <p class="pr-4">We are an exclusive online hiring platform connecting Job seekers with ZERO Notice Period with employers looking for Immediate hires. That’s our niche. With a focused & verified database of Talent with Zero Notice Period, Hire now at a very fast pace without having to lose time on "searching" talent with Zero notice period
                    .</p>
                    <p>ZeroNoticePeriod equals Fastest Hiring.</p>
                <ul class="pricing-package">
                    <li class="text-start " style="display: -webkit-box;"><a><img src="{{asset('asset/images/location.png')}}" alt="call" class="img-fluid pr-2"></a> 
                      <div style="width: 69%;">
                        <p style="font-size: 14px" class="mb-0">
                        Kokarya Business Synergy Center,
                        Nagananda Commercial Complex, 
                        # 07/03, 15/1, Second Floor, 18th Main Road, 
                        Jayanagar 9th Block, Bengaluru, Karnataka 560041  
                    </p>
                      </div>  
                    
                    </li>
                    {{-- <li class="text-start pb-2 pt-2"><a href="tel:8056668173" class="text-dark text-decoration-none"><img src="{{asset('asset/images/call.png')}}" alt="call" class="img-fluid pr-2"> 8056668173</a>
                            </li> --}}
                    <li class="text-start pb-2 "><a href="mailto:hello@zeronoticeperiod.com" class="text-dark text-decoration-none" style="font-size: 14px"><img src="{{asset('asset/images/mail.png')}}" alt="call" class="img-fluid pr-2">hello@zeronoticeperiod.com</a>
                            </li>
                </ul>
            </div>
            <div class="col-lg-8">
                <div class="row pt-2">
                    <div class="col-lg-3 footerlinks">
                        <h2 class="py-3">Jobs by Metros</h2>
                        <p><a href="{{ url('/jobs?location=Bengaluru') }}">Jobs in Bengaluru</a><p>
                        <p><a href="{{ url('/jobs?location=Hyderabad') }}">Jobs in Hyderabad</a><p>
                        <p><a href="{{ url('/jobs?location=Chennai') }}">Jobs in Chennai</a><p>
                        <p><a href="{{ url('/jobs?location=Mumbai') }}">Jobs in Mumbai</a><p>
                        <p><a href="{{ url('/jobs?location=Delhi') }}">Jobs in Delhi</a><p>
                    
                    </div>
                    <div class="col-lg-4 footerlinks workmode">
                        <h2 class="py-3">Jobs by Work Mode</h2>
                        <p><a href="{{ url('/jobs?tag=Hybrid') }}">Jobs (Hybrid)</a></p>
                        <p><a href="{{ url('/jobs?tag=Work+From+Office') }}">Jobs (Work From Office)</a></p>
                        <p><a href="{{ url('/jobs?tag=Remote') }}">Jobs (Remote/WFH)</a></p>
                        <p><a href="{{ url('/jobs?mode[]=Temp+WFH') }}">Jobs (Temp WFH)</a></p>
                    </div>
                    <div class="col-lg-3 footerlinks">
                        <h2 class="py-3">Jobs by Job Type</h2>
                        <p><a href="{{ url('/jobs?type[]=Permanent') }}">Jobs (Full time/Permanent)</a></p>
                        <p><a href="{{ url('/jobs?tag=Contract') }}">Jobs (Contract)</a></p>
                    </div>
                    <div class="col-lg-2 footerlinks">
                        <h2 class="py-3">Links</h2>
                        <p><a class="" id="" href="{{route('about-us')}}">About</a></p>
                        <p><a class="" id="" href="{{route('contact-us')}}">Contact</a></p>
                       
                    </div>
                </div>
                <ul class="pricing-package pt-4 d-flex justify-content-center">
                    <li class="d-inline"><a href="https://www.facebook.com/profile.php?id=100078635680624"><img src="{{asset('asset/images/fb.png')}}" alt="call" class="img-fluid pr-2"></a></li>
                    <!--<li class="d-inline"><a href="https://www.instagram.com/zeronoticeperiod/"><img src="{{asset('asset/images/insta.png')}}" alt="call" class="img-fluid pr-2"></a></li>-->
                    <li class="d-inline"><a href="https://www.linkedin.com/company/zeronoticeperiod/"><img src="{{asset('asset/images/linkedin.png')}}" alt="call" class="img-fluid pr-2"></a></li>
                    <li class="d-inline"><a href="https://twitter.com/ZNPTEAM"><img src="{{asset('asset/images/twitter.png')}}" alt="call" class="img-fluid pr-2"></a></li>
                    <li class="d-inline"><a href="https://www.youtube.com/channel/UCA_pykWTYsltpgdinRQMOgg"><img src="{{asset('asset/images/youtube.png')}}" alt="call" class="img-fluid pr-2"></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="footer-color pt-3 pb-3 border-color">
    <div class=" text-center  footer">
        &copy; Copyrights reserved 2023 ZeroNoticePeriod. All Rights  Reserved | <a href="{{url('terms-and-conditons')}}" class="a-hover ">Terms & Conditions</a> | <a href="{{url('privacy-policy')}}" class="a-hover ">Privacy Policy</a>
    </div>
</section>