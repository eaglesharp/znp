@extends('layouts.app')

@section('content')

<!-- Header start -->

@include('includes.header')

<!-- contact heading -->

<style>

    @media (min-width:1400px) {

        .header.dark {

            position: fixed;

            bottom: 0;

            width: 100%;

        }

    }

</style>

<section class="contact_bg-color">

    <div class="container ">

        <div class="row">

            <div class="col-lg-12 text-center py-5">

                <div class="contact_head-color py-1">

                Work With Us!

                </div>

            </div>

        </div>

    </div>

</section>



<!-- contact reference -->

@auth

<section class="contact_para">

    <div class="container">

        <div class="row">

            <div class="col-lg-8 m-auto text-center py-lg-2">

                <div class="pb-4 pb-lg-5 pt-5 px-4 px-md-0">

                    <p class="parah mb-0 px-3 px-md-0"> Verified Database of IT & Non IT Talent With <span class="line_change">ZeroNoticePeriod</span></p>

                </div>

            </div>

        </div>

    </div>

</section>

@else 

<section class="contact_para">

    <div class="container">

        <div class="row">

            <div class="col-lg-8 m-auto text-center py-lg-2">

                <div class="pb-4 pb-lg-5 pt-5 px-4 px-md-0">

                    <p class="parah mb-0 px-3 px-md-0">Verified Database of IT & Non IT Talent With <span class="line_change">ZeroNoticePeriod</span></p>

                </div>

            </div>

        </div>

    </div>

</section>

@endauth



<!-- contact info -->



<section class="contact_info-icons pb-2 pb-md-5">

    <div class="container pb-2 pb-md-5 ">

            <div class="col-lg-10 m-auto contact_info-color py-3 py-md-5 mb-0 mb-md-5">

                <div class="row">

                    {{-- <div class="col-md text-center mb-4 mb-md-0">

                        <img class="py-2" src="{{asset('/')}}asset/images/Group 55.png"/>

                        <div class="contact_phone">

                            <a href="tel:+91 9035479715" class="contact_phone">

                                +91 9035479715

                            </a>

                        </div>

                        <div class="contact_phone">

                            <a href="tel: +91 9035479716" class="contact_phone">

                                +91 9035479716

                            </a>

                        </div>

                    </div> --}}

                    <div class="col-md text-center mb-4 mb-md-0">

                        <img class="py-2" src="{{asset('/')}}asset/images/Group 56.png"/>

                        <div class="contact_mail">

                            <a href="mailto:hello@zeronoticeperiod.com" class="contact_mail">

                            hello@zeronoticeperiod.com

                            </a>

                        </div>

                        {{-- <div class="contact_mail">

                            <a href="mailto:hello@zeronoticeperiod.com" class="contact_mail">

                            hello@zeronoticeperiod.com

                            </a>

                        </div> --}}

                    </div>

                    <div class="col-md text-center mb-4 mb-md-0">

                        <img class="py-2" src="{{asset('/')}}asset/images/Group 57.png"/>

                        <div class="contact_location px-4">

                            Kokarya Business Synergy Center,
                            Nagananda Commercial Complex, 
                            # 07/03, 15/1, Second Floor, 18th Main Road, 
                            Jayanagar 9th Block, Bengaluru, Karnataka 560041

                        </div>

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

        </div>

    </section>


<!-- Footer section -->

@include('includes.footer')

@endsection