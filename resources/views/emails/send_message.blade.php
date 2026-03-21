

@extends('admin.layouts.email_template')

@section('content')



<table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">

  
    <tr>

        <td class="cols-wrapper" style="padding-left:12px;padding-right:12px">

            <!--[if mso]>

             <table border="0" width="576" cellpadding="0" cellspacing="0" style="width: 576px;">

                <tr>

                   <td width="192" style="width: 192px;" valign="top">

                      <![endif]-->

            <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">
                <!--<tr>-->
                <!--    <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align: center;padding: 10px 100px;">The sender of this email is <b>{{ Auth::guard('company')->user()->name }}</b> company registered with the email ID  <a href="{{ Auth::guard('company')->user()->email }}">{{ Auth::guard('company')->user()->email }}</a>. You are receiving this email since you have registered with <a href="{{ url('/') }}">www.zeronoticeperiod.com</a> as a Job seeker. ZeroNoticePeriod is an exclusive Job Portal dedicated to Jobseekers with Zero Notice Period. Find Jobs Faster!</td>-->
                <!--</tr>-->
                <tr>

                    <td class="row" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px"><table border="0" cellpadding="0" cellspacing="0" style="width:100%;">



                <tr>
                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 42px;">{!! $messages !!}</td>
                </tr>         

                        </table>

                        </td>

                </tr>
                <tr >
                    <td style="color:#333;text-align: center;">
                        <b>
                            @for ($i=0; $i < 73; $i++)
                                -
                            @endfor
                        </b>
                    </td>
                </tr>
               
                <tr>
                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;"
                    >
                    <b>Disclaimer: </b>
                     The sender of this email is registered with www.zeronoticeperiod.com as {{ Auth::guard('company')->user()->name }} using www.zeronoticeperiod.com services. 
                     The responsibility of checking the authenticity of offers/correspondence lies with you entirely. 
                     If you consider the content of this email inappropriate or spam, you may forward this email to: 
                     info@zeronoticeperiod.com. Please note this email is a private message from the recruiter. 
                     You are advised not to forward this email to protect your account from unauthorized access.
                    
                    </td>
                </tr>
                <tr>
                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;"
                    >
                    <b>General Advise :</b>
                    Please do not pay any money to anyone who promises to find you a job. 
                    This could be in any form. The money could be asked for upfront or it could be asked after trust has been built after some communication has been exchanged. 
                    Please ensure you are not being scammed and in case you are suspicious please contact info@zeronoticeperiod.com for advise.
                    </td>
                </tr>

            </table>      

           </td>

    </tr>

</table>

@endsection

