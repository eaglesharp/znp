




     @extends('admin.layouts.email_template')

     @section('content')
     <style>

.pay_table table.td {
    color: #000;
}
</style>
     
     <table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">
     
         <tr>
     
             <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
     
                 <div class="title" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">Hi {{ $title }},</div></td>
     
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
     
                             <!--        <td class="subtitle" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: left;">-->
     
                             <!--            {{-- <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Payment Success</p>                   --}}-->
     
                                   
     
                                          
     
                             <!--                <span style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left"> Thank your for using the {{ $plan }} plan! We've successfully processed your payment of Rs {{ $amount }}.00 </span> :-->
     
                             <!--                <span style=><a href=""></a></span>-->
     
                             <!--                <br>-->
     
                             <!--                {{-- <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;margin-top: 37px;" >You Can Login From Those Credentials</p>-->
     
                             <!--                <span style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Email </span> : -->
                             <!--                <br>-->
     
                             <!--               <span style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left"> Password</span> : --}}-->
     
                                            
     
                             <!--        </td>-->
     
                             <!--    </tr>-->
     
                             <!--    <tr>-->
     
                             <!--        <td style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 22px;font-weight: 400;color: #333; padding-bottom: 20px;text-align: left; padding-top:50px;">Thanks,<br>The ZNP Team</td>-->
     
                             <!--    </tr>-->
     
                             <!--</table>-->
     
                             <!--<br></td>-->
                                <td class="subtitle" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:10px; text-align: left;">
     
                                         <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Thank you for choosing ZeroNoticePeriod.</p>                  
     
                                   <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Your purchase has been registered with us. The Online payment for this purchase was SUCCESSFUL.</p>   
     
                                          <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">The Transaction ID for the purchase is: “{{$payment_id}}”</p> 
                                          @if(isset($user_id))
                                        
                                          <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">The Purchased CV is: “{{$user_id??''}}”</p>           
                                          @endif
                                             <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;margin-bottom: 0px;text-align: center;font-weight:700"> ORDER DETAILS FOR TRANSACTION ID: “{{$payment_id}}” </p>
     
                                            
                     <tr>
    <td colspan="4" style="padding-top:0px">
  <table class="pay_table" style="width:100%">
  <tr style="color:#000;background-color: #cbe7ea;padding-top:2px">
    <th style="padding: 15px;">Product</th>
    <th>Qty</th>
     <th>Start Date -to- End Date</th>	
      <th>Unit Price (INR)</th>
    <th>Price (INR)</th>
  </tr>
  <tr style="color:#000;background-color: #e7e9eb;" >
    <td style="padding: 15px;">{{ $plan }}</td>
    <td>1</td>
    <td style="padding-left: 60px;">{{  date('M-d-Y', strtotime($start_date))}} -to- {{ date('M-d-Y', strtotime($end_date))}}</td>
     <td style="padding-left: 30px;">{{ $original_amount }}</td>
     <td style="padding-left: 30px;">{{ $original_amount }}</td>
  </tr>
   <tr style="color:#000;background-color: #e7e9eb;" >
    <td style="padding: 15px;">GST</td>
    <td></td>
    <td style="padding-left: 60px;"></td>
     <td style="padding-left: 30px;">18%</td>
     <td style="padding-left: 30px;">{{ $gst }}</td>
  </tr>
  <tr style="color:#000;background-color: #cbe7ea;">
    <td colspan="4" style="padding: 10px;">TOTAL (All Taxes if/as applicable)</td>    
    <td style="padding-left: 30px;">{{ $amount }}</td>
  </tr>
  
</table>
    
	

                                         <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color: black;margin-top: 30px;"><b>Please Note:</b> Please note that the CV can be accessed immediately and is valid for a month with an option to email them 5 times.  </p>   	

                                      <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color: black;padding-top: 23px;">Thank you!</p>   	

                             <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color: #333;">ZeroNoticePeriod Team</p>   	
	</tbody>


           

</td>
</tr>
     
                                            
     
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
     
     