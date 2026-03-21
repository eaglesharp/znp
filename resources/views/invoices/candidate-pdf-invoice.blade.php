

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0 ">

	<meta name="format-detection" content="telephone=no">

    {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet"> --}}

    <style type="text/css"> 

      body {

         margin: 0 !important;

            padding: 0 !important;

            -webkit-text-size-adjust: 100% !important;

            -ms-text-size-adjust: 100% !important;

            -webkit-font-smoothing: antialiased !important;

          font-family: sans-serif;

          width: 100%;

          width: 100vw;

    }

    * {

        box-sizing: border-box;

        -moz-box-sizing: border-box;

    }

    .page { 

        /* background: white; */



    }

    @page {

  margin-top: 0px;

  margin-left:0px;

}

    table {

    width: 100%; 

}

    .subpage {

        padding:0 1.5cm;





    }

    td, th {

    font-size: 14px; 

}



    @page {

        size: A4;

        margin: 0;

    }

    @media print {

        .page {

            margin: 0;

            border: initial;

            border-radius: initial;

            width: initial;

            min-height: initial;

            box-shadow: initial;

            background: initial;

            page-break-after: always;

        }

    }

        p.foot {

   padding:40px;

   width: 100%;

    text-align: center;

    bottom: 2%;

    position: absolute;

}

td.three {

    width: 30%;

    border-bottom:1px solid black !important;

    text-align: left!important;

}

td.three1 {

    width: 30%;

    //border-bottom:1px solid black !important;

    text-align: left!important;

}



td.one {

    width: 50%;



}

td.two {

    float:left;

    width: 35%;

    white-space: normal;



    word-break: break-all!important;

}

.one h1{

    font-size:30px;

}

.w{

     width: 100%;

  white-space: normal;

   word-wrap: break-word;

}

#watermark

{

 position:fixed;

 bottom:50%;

 left:50%;

 opacity:0.5;

 z-index:99;

 color:black;

}

    </style>

</head>

<body>



 <div class="book">

    <div class="page">

        <div class="subpage">

           

            <table style="font-family:sans-serif;font-size:17px;padding:5px;margin:auto" cellspacing="0">

	<tbody>

	<tr>

		<td style="padding-bottom:40px;padding-top:70px;text-align:center!important;margin:auto;" colspan="3" >

			<img src="{{ asset('asset/images/logo.png') }}" width="33%" style="text-align:center;">

		</td>

	</tr>

    <tr valign="top" class="sec">

        <td class="one" > 

         <p style="margin-top:0px;margin-bottom:5px;">Kokarya Business Synergy Center,</p>

         <p style="margin-top:0px;margin-bottom:5px;">Nagananda Commercial Complex,</p>

         <p style="margin-top:0px;margin-bottom:5px;"># 07/03, 15/1, Second Floor, 18th</p>

         <p style="margin-top:0px;margin-bottom:5px;">Main Road, Jayanagar 9th Block,</p>

         <p style="margin-top:0px;margin-bottom:15px;">Bengaluru, Karnataka 560041</p>

        </td>

     <td class="two">

         

        </td>

     <td class="three1">

            <p style="margin-top:0px;margin-bottom:0;"></p>

         <p style="margin-top:0px;margin-bottom:5px;">Payment Id : {{ $payment_id }}</p>

         <p style="margin-top:0px;margin-bottom:5px;">GST # 36AFEPK9616F1ZE</p>

        </td>

 </tr>

    </tbody>

            </table>

            <table style="font-family:sans-serif;font-size:17px;padding:0;margin:auto;border: 2px solid black !important;" cellspacing="0">

                <tbody>

 <tr valign="top" class="sec" style=" " >

    <td  width="63%" colspan="3" style="border-bottom:3px solid black !important;">

        <h1 style="margin-bottom:0px;margin-top:3px;text-align:center;">INVOICE</h1>

     

    </td>

 

 <td width="37%" style="border-bottom:3px solid black !important;" >

        <p style="margin-top:0px;margin-bottom:5px;"><b>Invoice No: &nbsp;{{ $invoice_no }}</b></p>

        <p style="margin-top:0px;margin-bottom:0px;" class="w"><b>Invoice Date:&nbsp; {{ \Carbon\Carbon::now()->format('d/m/Y') }}</b></p>

 </td>

</tr>

<tr valign="top" class="sec" style="background-color: #DBE5F1;" >

    <td class="one" colspan="4" style="border-bottom:3px solid black !important;">

     

        <p style="margin-top:0px;margin-bottom:5px;">&nbsp;</p>

    </td>

 

 

</tr>

<tr valign="top" class="sec" style=" " >

    <td class="one" colspan="4" style="border-bottom:1px solid black !important;padding:3px 3px;">

        <p style="margin-top:0px;margin-bottom:5px;">To</p>

        <p style="margin-top:0px;margin-bottom:5px;"><b>{{ $name }}</b></p>

        {{-- <p style="margin-top:0px;margin-bottom:5px;">Safdarjung Enclave</p>

        <p style="margin-top:0px;margin-bottom:5px;">New Delhi - 110029</p> --}}

        <p style="margin-top:0px;margin-bottom:5px;">Email ID: {{ $email }}</p>

        <p style="margin-top:0px;margin-bottom:15px;">Mobile: {{ $mobile }}</p>

    </td>

 

 

</tr>

<tr>

    <td colspan="4" style="padding-top:0px">

    <table width="100%" cellspacing="0">

        <tr style="background-color: yellow;">

            <th width="80%" align="left" style="padding:5px 0;border: solid 2px #000;border-left:none !important">Plan</th>

            

            {{-- <th width="33%" align="right" style="padding:5px 0;border: solid 2px #000; border-left:none !important">Amount (INR) &nbsp;</th> --}}

            <th width="23%" align="right" style="padding:5px 0;border: solid 2px #000;border-left:none !important">Start Date &nbsp;</th>

            {{-- <th width="23%" align="right" style="padding:5px 0;border: solid 2px #000;border-left:none !important">End Date &nbsp;</th> --}}

            

            <th width="45%" align="right" style="padding:5px 0;border: solid 2px #000;border-right:none">Amount (INR) &nbsp;</th>

        </tr>

      

        <tr style="">

            <td align="left" style="border: solid 1px #000; border-left: none !important;border-right: none !important; padding:3px 3px;">

                <p style="margin: 0px;">Express Job Seeker

                </p>

              

            </td>

           

    

            <td align="right" style="border: solid 1px #000;"><p style="margin: 0px;">{{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }}</p></td>

            

            {{-- <td align="right" style="border: solid 1px #000;"><p style="margin: 0px;">{{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</p></td> --}}

            <td align="right" style="border: solid 1px #000; "><p style="margin: 0px;">INR {{ $amount }}</p></td>



            

        </tr>

        {{-- <tr>

            <td align="left" style="border: solid 1px #000;padding:3px 3px;">

                <p style="margin: 0px;">IGST @ 18%</p> 

            </td>

            <td align="right" style="border: solid 1px #000 "><p style="margin: 0px;">INR {{ $gst }}</p></td>

    

           

            

            <td align="right" style="border: solid 1px #000 "><p style="margin: 0px;">INR {{ $gst }}</p></td>

        </tr> --}}

        <tr>   

            <td align="left"  width="30%" style="text-align:center;font-weight:bold;" colspan="2" >TOTAL</td>

            <td align="right" width="70%">

                <p style="margin: 0px;"><b>INR {{ $total_amount }}</b><br></p>

                {{-- <p style="margin: 0px;">(Rupees One Hundred and Eighteen Only)</p> --}}

            </td>

        </tr>

         

       

    </table>

    

	

	





	</tbody>

</table>

{{-- <table style="font-family:sans-serif;font-size:17px;padding:0px;margin:auto;border: 1px solid black !important;border-top: 0px solid black !important;" cellspacing="0">

    <tbody>

   

    <tr valign="top" class="sec" >

        

        <td class="one" colspan="4" style="border-bottom: solid 1px #000;padding:70pxpx 3px 20px;font-size:12px">

           

            <p style="margin-top:0px;margin-bottom:5px;">Senior Operations Executive</p>

            <p style="margin-top:0px;margin-bottom:5px;">For ZeroNoticePeriod Consulting</p>

            <p style="margin-top:0px;margin-bottom:0px;">(This invoice is digitally signed)</p>

        </td>

     

 </tr>

 <tr valign="top" class="sec" >

    <td class="one" colspan="4" >

       

        <p style="margin-top:0px;margin-bottom:5px;padding-bottom:15px;padding-top:15px;font-size:12px;"><b>Banking Details in case of Netbanking/NEFT/IMPS/RTGS Transfer:</b></p>



    </td>

 

</tr>

<tr valign="top" class="sec">

    <td class="one" colspan="2" style="font-size:12px;padding:3px 3px 15px;">

       

        <p style="margin-top:0px;margin-bottom:5px;">Beneficiary Name :</p>

        <p style="margin-top:0px;margin-bottom:5px;">Beneficiary Bank Name :</p>

        <p style="margin-top:0px;margin-bottom:5px;">Beneficiary Bank Branch Name :</p>

        <p style="margin-top:0px;margin-bottom:5px;">Beneficiary Current A/c.No. :</p>

        <p style="margin-top:0px;margin-bottom:5px;">Beneficiary IFSC Code.No.</p>

        

    </td>

    <td class="one" colspan="2" style="font-size:12px;padding-left:100px;">

       

        <p style="margin-top:0px;margin-bottom:5px;"><b>ZeroNoticePeriod Consulting</b></p>

        <p style="margin-top:0px;margin-bottom:5px;">ICICI Bank</p>

        <p style="margin-top:0px;margin-bottom:5px;">Shri Kalki Towers, Plot No. 20, Chandanagar, Hyderabad-500 050</p>

        <p style="margin-top:0px;margin-bottom:5px;">058805500680</p>

        <p style="margin-top:0px;margin-bottom:5px;">ICIC0000588</p>

        

    </td>

 

</tr>

    </tbody>

            </table> --}}

           



</td>

</tr>

            </tbody>

        </table>





        </div>





    </div>







</div>



   	

</body>

</html>







