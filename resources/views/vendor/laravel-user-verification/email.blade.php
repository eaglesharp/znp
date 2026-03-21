@extends('admin.layouts.email_template')

@section('content')

@php

if(auth('company')->check()){

$link = route('company.email-verification.check', $user->verification_token);

}elseif(auth()->check()){

$link = route('email-verification.check', $user->verification_token);

}

@endphp

<table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">

    <tr>

        <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>

            <div class="title" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">Hello! {{ $user->first_name }} ,</div></td>

    </tr>

    <tr>

        <td class="cols-wrapper" style="padding-left:12px;padding-right:12px">

            <!--[if mso]>

             <table border="0" width="576" cellpadding="0" cellspacing="0" style="width: 576px;">

                <tr>

                   <td width="192" style="width: 192px;" valign="top">

                      <![endif]-->

            <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">

                <tr>

                    <td class="row" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px"><table border="0" cellpadding="0" cellspacing="0" style="width:100%;">



<tr>
    <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left;color:black">We're excited to have you get started. First, you need to confirm your account. Just press the button below.</td>
</tr>

                            <tr>

                                <td class="subtitle" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: left; padding-top: 17px;text-align: center;"><a href="{{ $link . '?email=' . urlencode($user->email) }}" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;background-color:#2d3748;border-bottom:8px solid #2d3748;border-left:18px solid #2d3748;border-right:18px solid #2d3748;border-top:8px solid #2d3748">Confirm Account</a></td>

                            </tr>

                            <tr>
                                

                                <td class="subtitle" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';line-height:1.5em;margin-top:0;text-align:left;font-size:14px;color:black">If that doesn't work, copy and paste the following link in your browser:  <span style=""><a href="{{ $link . '?email=' . urlencode($user->email) }}">{{ $link . '?email=' . urlencode($user->email) }}</a></span> </td>

                       
                        
                          
                            </tr>

                            <tr>

                                <td style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 22px;font-weight: 400;color: #333; padding-bottom: 20px;text-align: left; padding-top:50px;">Thanks, <br>

                                    {{ $siteSetting->site_name }} Team</td>

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

