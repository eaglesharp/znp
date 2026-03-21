




     @extends('admin.layouts.email_template')

     @section('content')
     
     <table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">
     
         <tr>
     
             <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
     
                 <div class="title" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">Hello,</div></td>
     
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
     
                                         <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">This is a gentle reminder that your Employer subscription with ZeroNoticePeriod is about to expire in 5 Days.</p>                  
     
                                         <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Please login to your account and renew your subscription at <a href="{{route('pricing')}}">{{route('pricing')}}</a></p>                  

     
                                            
      <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Thank You!</p>                  
                                     </td>
     
                                 </tr>
     
                                 <tr>
     
                                     <td style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 22px;font-weight: 400;color: #333; padding-bottom: 20px;text-align: left; padding-top:50px;">ZeroNoticePeriod Team</td>
     
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
     
     