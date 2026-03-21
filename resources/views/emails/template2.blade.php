

@extends('admin.layouts.email_template')

@section('content')



<table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">

  
    <tr>

        <td class="cols-wrapper" style="padding-left:12px;padding-right:12px">

    

            <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">
                <!--<tr>-->
                <!--</tr>-->
                <tr>

                    <td class="row" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px"><table border="0" cellpadding="0" cellspacing="0" style="width:100%;">



                        <tr>
                            <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 42px;">{!! $message1 !!}</td>
                        </tr>



                          
                  


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

