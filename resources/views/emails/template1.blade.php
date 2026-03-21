

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
    <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 42px;">{!! $message1 !!}</td>
</tr>


<!--<tr >-->
<!--    <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:10px;text-align:left;padding-top: 42px;">-->
 
<!--    <p style=" border-top: 1px dashed #000;"><p>-->

<!--    <b> Disclaimer :</b> The sender of this email is registered with <a href="{{ url('/') }}">www.zeronoticeperiod.com</a> as <b> {{ Auth::guard('company')->user()->name }} ({{ Auth::guard('company')->user()->email }}) </b> using <a href="{{ url('/') }}">www.zeronoticeperiod.com</a> services. If you consider the content of this email inappropriate or spam, you may forward the email to: <a href="mailto:compliance@zeronoticeperiod.com" target="_blank">compliance@zeronoticeperiod.com</a>.  Please note this email is a private message from the recruiter. Please do not pay any money to anyone who promises to find you a job. Please note, there are multiple scams where you may be asked to pay money for a job. In case you are suspicious please forward the content to <a href="mailto:compliance@zeronoticeperiod.com" target="_blank">compliance@zeronoticeperiod.com</a>-->

<!--    </td>-->

<!--</tr>-->
                          
                  


                        </table>

                        </td>

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

