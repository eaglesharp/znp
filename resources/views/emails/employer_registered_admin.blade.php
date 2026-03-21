@extends('admin.layouts.email_template')

@section('content')
    <table border="0" cellpadding="0" cellspacing="0" class="force-row"
        style="width: 100%;    border-bottom: solid 1px #ccc;">

        <tr>

            <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>

                <div class="title"
                    style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">
                    Hello! <b>{!! $c_name !!}</b>,</div>
            </td>

        </tr>

        <tr>

            <td class="cols-wrapper" style="padding-left:12px;padding-right:12px"><!--[if mso]>

                                         <table border="0" width="576" cellpadding="0" cellspacing="0" style="width: 576px;">

                                            <tr>

                                               <td width="192" style="width: 192px;" valign="top">

                                                  <![endif]-->

                <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">

                    <tr>

                        <td class="row" valign="top"
                            style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">

                                <tr>

                                    <td class="subtitle"
                                        style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: left;">

                                        <p
                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            Welcome to <b>ZeroNoticePeriod.com</b>, an Exclusive Portal for Jobseekers ONLY
                                            with ZERO (or are serving notice period)!</p>

                                        <p
                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            ZeroNoticePeriod.com onboards jobseekers with ZERO notice period (or who are
                                            currently serving notice period). Here is how we can POWER your (Time-Sensitive)
                                            talent search & cut short your operational time on hiring:</p>


                                        <p
                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            *At first, We are a Dedicated & Exclusive portal for jobseekers with
                                            ZERO/Serving Notice Period onboard. This will help you save time trying to find
                                            "Immediate hires" in a huge pool. You search, connect, interview, hire and do
                                            not have to worry about their Notice Period.</p>



                                        <p
                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            *Find jobseekers, who update their Video Interview Availability. This allows a
                                            recruiter to save at least 50% of their operational time when determining a job
                                            seeker's availability and ensuring that he or she is active in their job search.
                                        </p>



                                        <p
                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            You can now Search & Find contractors at the click of a button. We realise you
                                            do not always need to hire "Permanent" Workforce and may need to hire
                                            "On-Demand" for shorter projects. We help you find jobseekers who are open to
                                            working on Contractual Jobs.</p>



                                        <p
                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            <b>Thanks for registering!</b>
                                        </p>



                                        <p
                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            <b>Please use the following credentials to login:</b>
                                        </p>


                                        <span
                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color:#333">
                                            Login URL: </span> :

                                        <span style=><a href="{{ $link }}">{{ $link }}</a></span><br>

                                        <span
                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color:#333">Username
                                        </span> : {!! $title !!}
                                        <br>

                                        <span
                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color:#333">
                                            Password</span> :{!! $content !!}<br><br>



                                        <p
                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            Welcome & Happy Hiring!
                                        </p>

                                        <p
                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            Team ZeroNoticePeriod
                                        </p>
                                        <a href="http://www.zeronoticeperiod.com"><b>www.zeronoticeperiod.com</b></a>
                                    </td>

                                </tr>



                            </table>

                            <br>
                        </td>

                    </tr>

                </table>

                <!--[if mso]>

                                               </td>

                                            </tr>

                                         </table>

                                         <![endif]-->
            </td>

        </tr>

    </table>
@endsection
