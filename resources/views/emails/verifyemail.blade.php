   @extends('admin.layouts.email_template')

   @section('content')
       <table border="0" cellpadding="0" cellspacing="0" class="force-row"
           style="width: 100%;    border-bottom: solid 1px #ccc;">

           <tr>

               <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>

                   <div class="title"
                       style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:18px;margin-top:10px;text-align:left">
                       Hello Jobseekers,</div>
               </td>

           </tr>

           <tr>

               <td class="cols-wrapper" style="padding-left:12px;padding-right:12px"><!--[if mso]>

             <table border="0" width="576" cellpadding="0" cellspacing="0" style="width: 576px;">

                <tr>

                   <td width="192" style="width: 192px;" valign="top">

                      <![endif]-->

                   <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row"
                       style="width: 100%;">

                       <tr>

                           <td class="row" valign="top"
                               style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                               <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">

                                   <tr>

                                       <td class="subtitle"
                                           style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: left;">

                                           <p
                                               style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:10px;text-align:left">
                                               Welcome to ZeroNoticePeriod’s Family of jobseekers!</p>

                                           <p
                                               style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:10px;text-align:left">
                                               Please click the button below to verify your email address.</p>
                                           <p
                                               style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:10px;text-align:left">
                                               <a href="{{ $url }}" style="background-color: #4CAF50;color: white;padding: 10px 20px;text-decoration: none;border-radius: 5px;">Verify Email</a></p>
                                           <!--<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:10px;text-align:left">Our portal is restricted to job seekers whose notice period is Zero (or are serving notice period).</p> -->
                                           <!--<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:10px;text-align:left">Since we are dedicated to Jobseekers who are in a Time sensitive Job Search, There is a great chance Recruiters will find you very quickly.</p> -->


                                           <p
                                               style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:10px;text-align:left">
                                               <b>If you did not create an account, please ignore this email.<b>
                                           </p>
                                           <p
                                               style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:10px;text-align:left">
                                               Team ZeroNoticePeriod
                                           </p>



                                       </td>

                                   </tr>

                                   <tr>

                                       <td
                                           style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 22px;font-weight: 400;color: #333; padding-bottom: 20px;text-align: left;">

                                           <a href="http://www.zeronoticeperiod.com"><b>www.zeronoticeperiod.com</b></a>

                                           <p
                                               style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:12px;line-height:1.5em;margin-top:10px;text-align:left">
                                               <b>Advisory</b> : In case you receive emails/calls asking for Payment against
                                               promise for jobs, Please do not engage/pay any money. This could be in the
                                               form of a registration fee or document processing fee or visa charges or any
                                               other pretext. The money could be asked for upfront or it could be asked
                                               after trust has been built after some correspondence has been exchanged. Also
                                               please note that in case you get a job offer or a letter of intent without
                                               having been through an interview process it is probably a scam and you are
                                               requested to contact compliance@zeronoticeperiod.com for advise.</p>


                                       </td>


                                   </tr>



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
