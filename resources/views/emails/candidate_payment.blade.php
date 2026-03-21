
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

     

                                     <td class="subtitle" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:10px; text-align: left;">

     

                                         <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Thank you for choosing to be an “Xpress Job Seeker”.</p>                  

     

                                   <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Your purchase has been registered with us. The Online payment for this purchase was SUCCESSFUL.</p>   

     

                                          <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">The Transaction ID for the purchase is: “{{$payment_id}}”</p>           

     

                                             <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;margin-bottom: 0px;text-align: center;font-weight:700"> ORDER DETAILS FOR TRANSACTION ID: “{{$payment_id}}” </p>

     

                                            

                     <tr>

    <td colspan="4" style="padding-top:0px">

  <table class="pay_table" style="width:90%">

  <tr style="color:#000;background-color: #cbe7ea;padding-top:2px">

    <th style="padding: 15px;">Product</th>

    <th>Qty</th>

     <th>Start Date -to- End Date</th>	

      <th>Unit Price (INR)</th>

    <th>Price (INR)</th>

  </tr>

  <tr style="color:#000;background-color: #e7e9eb;" >

    <td style="padding: 15px;">Xpress Job Seeker Plan</td>

    <td>1</td>

    <td style="padding-left: 60px;">{{ \Carbon\Carbon::parse($start_date)->isoFormat('MMM Do YYYY')}} -to- {{ \Carbon\Carbon::parse($end_date)->isoFormat('MMM Do YYYY')}}</td>

     <td style="padding-left: 30px;">499</td>

     <td style="padding-left: 30px;">499</td>

  </tr>

  <tr style="color:#000;background-color: #e7e9eb;" >

  <td style="padding: 15px;">GST</td>

  <td></td>

  <td style="padding-left: 60px;"></td>

  <td style="padding-left: 30px;">18%</td>

  <td style="padding-left: 30px;">{{ $gst}}</td>

  </tr>

  <tr style="color:#000;background-color: #cbe7ea;">

    <td colspan="4" style="padding: 10px;">TOTAL (All Taxes if/as applicable)</td>    

    <td style="padding-left: 30px;">{{ $total_amount}}</td>

  </tr>

  

</table>

    

	



                                         <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color: black;margin-top: 30px;"><b>Please Note:</b> Your profile will be marked as an Xpress Job Seeker within 24 Hours. As an Xpress Job Seeker – Your profile will show up with a LABEL (Xpress Job Seeker) that shows that you are looking for a Job on an Immediate basis. You will now be able to update your Video Interview Availability. Please refresh your availability often to attract more opportunities!</p>   	



                                      <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color: black;padding-top: 23px;">Thank you!</p>   	



                             <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color: #333;">ZeroNoticePeriod Team</p>   	

	</tbody>





           



</td>

</tr>

     

                                            

     

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

     

     