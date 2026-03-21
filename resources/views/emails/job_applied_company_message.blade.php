@extends('admin.layouts.email_template')
@section('content')
<table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">
    <tr>
        <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
            <div class="title" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px;font-weight:400;color: #000;text-align: left;
                 padding-top: 20px;">{{$company_name}} ,</div></td>
    </tr>
    <tr>
        <td class="cols-wrapper" style="padding-left:12px;padding-right:12px"><!--[if mso]>
         <table border="0" width="576" cellpadding="0" cellspacing="0" style="width: 576px;">
            <tr>
               <td width="192" style="width: 192px;" valign="top">
                  <![endif]-->      
            <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">
                <tr>
                    <td class="row" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px"><table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tr>
                                <td class="subtitle" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: left;">
                                    <p>"{{ $user_name }}" has applied on a job, posted by you "{{ $job_title }}"</p>                  
                                    <p>
                                        {{-- <br>
                                        Job seeker profile link :
                                        <span style="color: #fff;text-decoration: none;background: #f25a55; padding: 7px 10px;text-align: center;display: inline-block;margin-top: 20px;"><a href="{{ $user_link }}">{{ $user_link }}</a></span>
                                        <br> --}}

                                        <br>
                                        Job link : 
                                        <span style="color: #fff;text-decoration: none;background: #f25a55; padding: 7px 10px;text-align: center;display: inline-block;margin-top: 20px;"><a href="{{ $job_link }}">{{ $job_link }}</a></span>
                                        <br>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 22px;font-weight: 400;color: #333; padding-bottom: 30px;text-align: left;">Thanks,<br>The {{ $siteSetting->site_name }} Team</td>
                            </tr>
                        </table>
                        <br></td>
                </tr>
            </table>      
            <!--[if mso]>
               </td>
            </tr>
         </table>
         <![endif]--></td>
    </tr>
</table>
@endsection



<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- So that mobile will display zoomed in -->

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- enable media queries for windows phone 8 -->

    <meta name="format-detection" content="telephone=no">

    <!-- disable auto telephone linking in iOS -->

    <title>ZeroNoticePeriod</title>

    <style type="text/css">
        body {

            margin: 0;

            padding: 0;

            -ms-text-size-adjust: 100%;

            -webkit-text-size-adjust: 100%;

        }

        table {

            border-spacing: 0;

        }

        table td {

            border-collapse: collapse;

        }

        .ExternalClass {

            width: 100%;

        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {

            line-height: 100%;

        }

        .ReadMsgBody {

            width: 100%;

            background-color: #ebebeb;

        }

        table {

            mso-table-lspace: 0pt;

            mso-table-rspace: 0pt;

        }

        img {

            -ms-interpolation-mode: bicubic;

        }

        .yshortcuts a {

            border-bottom: none !important;

        }

        .soc {

            margin: 0px;

            padding: 0px;

            display: block;

            text-align: center;

        }

        .soc ul {

            margin: 0px;

            padding: 0px;

            float: left;

        }

        .soc ul li {

            list-style: none;

            float: left;

            margin: 0px 9px 0px 0px;

        }

        @media screen and (max-width: 599px) {

            .force-row,
            .container {

                width: 100% !important;

                max-width: 100% !important;

            }

        }

        @media screen and (max-width: 400px) {

            .container-padding {

                padding-left: 12px !important;

                padding-right: 12px !important;

            }

            .col img {

                width: 100% !important;

            }

        }

        .ios-footer a {

            color: #aaaaaa !important;

            text-decoration: underline;

        }

        @media screen and (max-width: 599px) {

            .col {

                width: 100% !important;

                border-top: 1px solid #eee;

                padding-bottom: 0 !important;

            }

            .cols-wrapper {

                padding-top: 18px;

            }

            .img-wrapper {

                float: right;

                max-width: 40% !important;

                height: auto !important;

                margin-left: 12px;

            }

            .subtitle {

                margin-top: 0 !important;

            }

        }

        @media screen and (max-width: 400px) {

            .cols-wrapper {

                padding-left: 0 !important;

                padding-right: 0 !important;

            }

            .content-wrapper {

                padding-left: 12px !important;

                padding-right: 12px !important;

            }

        }

        .update-plan {
            padding: 10px 15px;
            background-color: blue;
            border-radius: 0px;
            text-decoration: none;
            color: #fff;

        }
    </style>

</head>

<body style="margin:0; padding:0;" bgcolor="#F0F0F0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

    <!-- 100% background wrapper (grey background) -->

    <table border="0" width="80%" cellpadding="0" cellspacing="0" bgcolor="#24140e" style="
        color: red;
        margin-left: 73px;
        margin-top: 73px;
        background-color: red!important;
    ">

        <tr>

            <td align="center" valign="top" bgcolor="#24140e" style="background-color:#fff;">
                <!-- 600px container (white background) -->

                <table border="0" cellpadding="0" cellspacing="0" class="container"
                    style="width: 50%;border: solid 1px #d6d4d4;">

                    <tr>

                        <td class="content" align="left"
                            style="padding-top:0px;padding-bottom:12px;background-color:#f8f8f8;">
                            <table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width:100%;">

                                <tr>

                                    <td align="center" valign="middle" class="content-wrapper"
                                        style="padding-left:24px;padding-right:24px"><br>

                                        <a href="{{ url('login') }}"><img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" /></a></td>                                    </td>

                                </tr>

                            </table>
                        </td>

                    </tr>

                    <tr>

                        <td class="content" align="left"
                            style="background: #0642a9;">
                            <table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width:100%;">

                                <tr>

                                    <td align="center" valign="middle" class="content-wrapper"
                                        style="padding-left:24px;padding-right:24px">
                                        <h2
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 24px;font-weight:400;color: #fff;">
                                            You have got a new applicant!</h2>
                                    </td>

                                </tr>

                            </table>
                        </td>

                    </tr>

                    <tr>

                        <td class="content" align="left"
                            style="padding-top:0px;padding-bottom:12px;background-color:#fff">
                            <table border="0" cellpadding="0" cellspacing="0" class="force-row"
                                style="width: 100%;    border-bottom: solid 1px #ccc;">

                                <tr>
                                    <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
                                        <div class="title" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px;font-weight:400;color: #000;text-align: left;
                                      margin-bottom:10px;padding: 25px;background-color: #f6faff;border: 1px solid #e6e6e6;border-radius: 20px;margin-top: 13px;">
                                            <h2
                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 16px;font-weight:500;color: #4a4848;margin: 0;padding-bottom: 8px;">
                                                Job Title</h2>
                                            <h3 style="font-family: Helvetica, Arial, sans-serif; font-size: 20px;font-weight:400;color: #000;margin-top: 0;
                                                margin-bottom: 0;">
                                                {{ $job_title }}</h3>
                                            <h4
                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 14px;font-weight:400;color: #4a4848;margin-top: 8px;">
                                                {{ \Carbon\Carbon::parse($job_date)->format('d-m-Y')  }}</h4>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-wrapper" style="padding-left:24px;padding-right:24px;"><br>
                                        <div class="title"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 18px;font-weight:400;color: #000;text-align: left;
                                      margin-bottom:10px;padding:25px;border:1px solid #e6e6e6;background-color: #fbfbfb;border-radius: 20px;">
                                            <h2
                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 22px;font-weight:500;color: #000;margin: 0;">
                                                {{ $user_name }}</h2>
                                            <h3
                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 16px;font-weight:400;color: #4a4848;">
                                                {{ $pdetails->latestdesg??'' }} at  {{ $pdetails->latestcom??'' }}</h3>
                                            <ul style="padding-left: 0;">
                                                <li style="display: inline;"><img src="{{ asset('img/suitcase-solid.svg') }}" 
                                                        alt="location-dot-solid" style="width: 3%;"></li>
                                                <li style="display: inline-block;">
                                                    <h4
                                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 15px;font-weight:400;color: #4a4848;margin: 0;">
                                                       {{ $pdetails->totalexp }} & {{ $pdetails->totalexpmonth }}</h4>
                                                </li>
                                                <li style="display: inline;"><img src="{{ asset('img/indian-rupee-sign-solid.svg') }}"
                                                        alt="location-dot-solid" style="width: 2%;padding-left: 5px;">
                                                </li>
                                                <li style="display: inline-block;">
                                                    <h4
                                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 15px;font-weight:400;color: #4a4848;margin: 0;">
                                                        {{ $details->expect_ctc_lakhs3??'' }} Lakhs</h4>
                                                </li>
                                            </ul>
                                            {{-- <a href="#"
                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 14px;font-weight:400;color: #197ff3;text-decoration: none;">View
                                                Contact Details </a> --}}
                                                @php

                                                $sks = [];
                                            
                                                    foreach($job->jobskills as $j)
                                                    {
                                                        $sks[] =  $j->job_skill_id;
                                                    }
                        
                                                    $jobskills = \App\JobSkill::whereIn('id',$sks)->select('job_skill')->get();
                                                                        
                                            @endphp
                                           
                                            <ul
                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 14px;font-weight:400; list-style: none; color: #4a4848;padding-left: 0;">
                                                <li style="padding-top: 5px;padding-bottom: 5px;">
                                                    <span style="font-family: Helvetica, Arial, sans-serif; font-size: 15px;font-weight:600;color: #000;padding-right: 10px;">Location</span>{{ $user->current_location??'' }}</li>
                                                {{-- <li style="padding-top: 5px;padding-bottom: 5px;"><span style="font-family: Helvetica, Arial, sans-serif; font-size: 15px;font-weight:600;color: #000;padding-right: 10px;">Past
                                                        Experience</span>Graduate Engineer at Niviqure Meditech Pvt Ltd
                                                </li> --}}
                                                <li style="padding-top: 5px;padding-bottom: 5px;"><span style="font-family: Helvetica, Arial, sans-serif; font-size: 15px;font-weight:600;color: #000;padding-right: 10px;">Notice
                                                        Period</span> @if($user->getprofileNop()->nop_days=="1") Immediately Available @endif  @if($user->getprofileNop()->nop_days=="2") Serving Notice Period @endif</li>
                                                {{-- <li style="padding-top: 5px;padding-bottom: 5px;">
                                                    <span style="font-family: Helvetica, Arial, sans-serif; font-size: 15px;font-weight:600;color: #000;padding-right: 10px;">Education</span>B.Tech/B.E. at Sir M Visvesvaraya Institute of
                                                    Technology, Bangalore</li> --}}
                                                <li style="padding-top: 5px;padding-bottom: 5px;">
                                                    <span style="font-family: Helvetica, Arial, sans-serif; font-size: 15px;font-weight:600;color: #000;padding-right: 10px;">Keyskills</span>    <?php echo implode(', ', $jobskills->pluck('job_skill')->toArray()); ?>
                                                </li>
                                            </ul>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
                                        <div class="title" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px;font-weight:400;color: #000;text-align: center;
                 padding-top: 0;padding-bottom: 10px;"> <span style="color: #ffffff;text-decoration: none;background: #0642a9; padding: 10px 25px; text-align: center; display: inline-block; margin-top: 0px; border-radius: 30px;"><a
                                                    href="{{ $job_link }}"
                                                    style="color: #ffffff;font-size: 14px;text-decoration: none;">View
                                                    Applicants</a></span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
                                        <div class="title" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px;font-weight:400;color: #fff;text-align: left;
                                      padding:25px;background: #197ff3;border-radius: 20px;">
                                            <b>
                                                Beware of Imposters</b>

                                            <ul style="padding-left: 20px;">
                                                <li>Avoid recruiters who are asking for money</li>
                                                <li>Don't trust recruiters promising job offers</li>
                                                <li>Never share your Aadhar/creadit card/ wallet details with anyone
                                                    claiming to be from Naukri</li>
                                            </ul>

                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
                                        <div class="title" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px;font-weight:400;color: #000;text-align: center;
                 padding-top: 10px;">
                                            <h2
                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 16px;font-weight:400;color: #4a4848;padding-bottom: 20px;">
                                                Contact us: <a href="mailto:support@naukri.com"
                                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 14px;font-weight:400;color: #197ff3;padding-right: 10px;padding-left: 10px;">support@naukri.com</a>
                                                <a href="tel:1800-102-5558"
                                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 14px;font-weight:400;color: #197ff3;">1800-102-5558</a>
                                            </h2>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>

                    <tr style="background-color: #fff;">

                        <td class="container-padding footer-text" align="left"
                            style="font-family:Helvetica, Arial, sans-serif;font-size:12px;line-height:16px;color:#aaaaaa;padding: 20px 20px;">
                            <div class="soc">



                            </div>

                            <br>

                            <span class="ios-footer" style=" text-align:center;display: block;"> © Copyright 2023
                                ZeroNoticePeriod - All Rights Reserved </span> <br>

                            <br>
                        </td>

                    </tr>

                </table>

                <!--/600px container -->
            </td>

        </tr>

    </table>

    <!--/100% background wrapper-->

</body>

</html>