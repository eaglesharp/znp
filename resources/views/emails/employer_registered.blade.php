



@extends('admin.layouts.email_template')

@section('content')

<table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">

    <tr>

        <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>

            <div class="title" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">Hello! <b>{!! $c_name !!}</b>,</div></td>

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

                                    <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Welcome to <b>ZeroNoticePeriod.com</b>, an Exclusive Portal for Jobseekers ONLY with ZERO (or are serving notice period)!</p>                  

                              <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">ZeroNoticePeriod.com <b>"restricts to and onboards"</b> ONLY jobseekers with ZERO notice period (or who are currently serving notice period). Here is how we can POWER your (<b>Time-Sensitive) TALENT Search & cut short your operational time on hiring:</b></p>                  


                              <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">*At first, We are a <b>Dedicated & Exclusive portal for jobseekers with ONLY ZERO/Serving Notice Period onboard.</b> This will help you save time trying to find <b>"Immediate hires"</b> in a huge pool. You search, connect, interview, hire and do NOT have to worry about their Notice Period.</p> 



  <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">*Find <b>Xpress jobseekers</b>, who update their <b>Video Interview Availability</b>. This allows a recruiter to save at least 50% of their operational time when determining a job seeker's availability and ensuring that he or she is ACTIVE in their job search.</p> 



  <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">You can now Search & Find <b>CONTRACTORS at the click of a button</b>. We realise you do not always need to hire "Permanent" Workforce and may need to hire "On-Demand" for shorter projects. We help you find jobseekers who are open to working on <b>Contractual Jobs</b>.</p> 



  <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Thanks for registering, and we will soon alert you when we go live with the Employer services!</p> 



                                        <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left" ><b>Please use the following credentials to login:</b></p>
                                     

                                        <span style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color:#333"> Login URL:  </span> :

                                        <span style=><a href="{{ $link }}">{{ $link }}</a></span>
                                       
                                        <span style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color:#333">Username </span> : {!! $title !!}
                                        <br>

                                       <span style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color:#333"> Password</span> :{!! $content !!}



  <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><b>Welcome & Happy Hiring!</b></p> 

         <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><b>Team ZeroNoticePeriod</b></p>                                 
 <a href="http://www.zeronoticeperiod.com"><b>www.zeronoticeperiod.com</b></a>
                                </td>

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

