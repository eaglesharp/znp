{{-- {!! APFrmErrHelp::showErrorsNotice($errors) !!} --}}



@extends('layouts.app')



@section('content')

<!-- Header start -->

@include('includes.header')

<!-- Header end -->



<!-- hear section -->



<style>

.font_size1 {
    color: #0642a9;
    font-size: 30px;
    font-family: "proximanova-regular";
}

.font_size2 {
    color: #197ff3;
    font-size: 30px;
    font-family: "proximanova-bold";
}



.bubblingG {
    text-align: center;
    width: 78px;
    height: 49px;
    margin: auto;
}

.bubblingG span {
    display: inline-block;
    vertical-align: middle;
    width: 10px;
    height: 10px;
    margin: 24px auto;
    background: rgb(0, 0, 0);
    border-radius: 49px;
    -o-border-radius: 49px;
    -ms-border-radius: 49px;
    -webkit-border-radius: 49px;
    -moz-border-radius: 49px;
    animation: bubblingG 1.5s infinite alternate;
    -o-animation: bubblingG 1.5s infinite alternate;
    -ms-animation: bubblingG 1.5s infinite alternate;
    -webkit-animation: bubblingG 1.5s infinite alternate;
    -moz-animation: bubblingG 1.5s infinite alternate;
}

#bubblingG_1 {
    animation-delay: 0s;
    -o-animation-delay: 0s;
    -ms-animation-delay: 0s;
    -webkit-animation-delay: 0s;
    -moz-animation-delay: 0s;
}

#bubblingG_2 {
    animation-delay: 0.45s;
    -o-animation-delay: 0.45s;
    -ms-animation-delay: 0.45s;
    -webkit-animation-delay: 0.45s;
    -moz-animation-delay: 0.45s;
}

#bubblingG_3 {
    animation-delay: 0.9s;
    -o-animation-delay: 0.9s;
    -ms-animation-delay: 0.9s;
    -webkit-animation-delay: 0.9s;
    -moz-animation-delay: 0.9s;
}



@keyframes bubblingG {
    0% {
        width: 10px;
        height: 10px;
        background-color: rgb(0, 0, 0);
        transform: translateY(0);
    }

    100% {
        width: 23px;
        height: 23px;
        background-color: rgb(255, 255, 255);
        transform: translateY(-20px);
    }
}

@-o-keyframes bubblingG {
    0% {
        width: 10px;
        height: 10px;
        background-color: rgb(0, 0, 0);
        -o-transform: translateY(0);
    }

    100% {
        width: 23px;
        height: 23px;
        background-color: rgb(255, 255, 255);
        -o-transform: translateY(-20px);
    }
}

@-ms-keyframes bubblingG {
    0% {
        width: 10px;
        height: 10px;
        background-color: rgb(0, 0, 0);
        -ms-transform: translateY(0);
    }

    100% {
        width: 23px;
        height: 23px;
        background-color: rgb(255, 255, 255);
        -ms-transform: translateY(-20px);
    }
}

@-webkit-keyframes bubblingG {
    0% {
        width: 10px;
        height: 10px;
        background-color: rgb(0, 0, 0);
        -webkit-transform: translateY(0);
    }

    100% {
        width: 23px;
        height: 23px;
        background-color: rgb(255, 255, 255);
        -webkit-transform: translateY(-20px);
    }
}

@-moz-keyframes bubblingG {
    0% {
        width: 10px;
        height: 10px;
        background-color: rgb(0, 0, 0);
        -moz-transform: translateY(0);
    }

    100% {
        width: 23px;
        height: 23px;
        background-color: rgb(255, 255, 255);
        -moz-transform: translateY(-20px);
    }
}

.cv-box:hover{
  
    -webkit-transform: translateY(-20px);
    -ms-transform: translateY(-20px);
    transform: translateY(-20px);
    box-shadow: 0 22px 43px rgba(0, 0, 0, 0.32);
    cursor: pointer;
    border-radius: 5px;
}
</style>




<!-- pricing_page -->

<!-- 

<section class="contact_bg-color">

    <div class="container contact_bg-color">

        <div class="row">

            <div class="col-lg-12 text-center py-5">

                <div class="contact_head-color py-1">

                    Pricing

                </div>

            </div>

        </div>

    </div>

</section> -->



<!-- Pricing reference -->



<section class="contact_para pt-sm-3 section_canddashboard">

    <div class="container">

        <div class="row">
            <div class="col-lg-12  text-center">



                <div class="parah pt-2 px-1 px-sm-5 px-lg-0">
                    

                    @if(Auth::check() || Auth::guard('company')->check())

                    <span

                        class="line_change font_size1">  Verified Database of IT & Non IT Talent With ZeroNoticePeriod</span>

                    @else

                    <span

                        class="line_change font_size1">Verified Database of IT & Non IT Talent With ZeroNoticePeriod</span>

                     @endif
                </div>



                <div class="font_size2 pb-2 pt-1">HIRE QUICK!</div>



            </div>

            <div class="col-12 pb-4 kyc-box px-3">
                
     
                {{-- <div class="success d-flex justify-content-between align-items-center py-3 cv-bodx" 
                          style="background-color: #3998de;color: #fff;padding: 10px 15px;border-radius: 10px;box-shadow: 5px 5px 19px 0px #878787;">
        
                          <div>
                              <h2 class="mb-0 pl-2 myprofile_font text-white">Buy Single CV & Video Interview</h2> 
                            
                                  <div>
                                      <p class="mb-0 pl-2 text-white pt-1" style="font-size:13px">1 month validity for CV access/download & 5 emails.</p>                                                             
                                  </div>      
                              
                          </div> 
                          <div class="cv-search-btns">
                            {{-- <a class="btn btn-sent mb-2 mb-sm-0 mr-2" data-toggle="tooltip" data-placement="top"title="Purchase a CV" href="{{ route('cv-search') }}" target="_blank">                         
                                <i class="fa fa-file-pdf-o  mr-2" aria-hidden="true"></i>Buy CV
                              </a>  }}
                        </div>                         
                             
                </div> --}}
               
                    
        
            </div>
        
        </div>
   </div>

</section>






@php

$packages = \App\Package::all();
@endphp



<!-- pricing main section -->



<section class="pricing_main-part section_canddashboard">

    <div class="container">

        <div class="row">

            <div class="col-12 m-auto pb-4 pb-sm-5">

                <div class="row">
                    <?php $i=0; ?>

                    @foreach ($packages as $package)
                    <?php $i++; ?>
                    @if ($package->package_title != "Premium")
                        
                   

                    <div class="pricing_parent col-md-6 col-xl-4 pb-3 pb-sm-5">

                        <div class="pricing_content_new">

                            <h2 class="text-center pricing_background-head_new">{{ $package->package_title }}</h2>
                            <ul class="pricing-package">
                               
                                <li class=" pb-2 px-4 d-flex">
                                    <div class="col-2 p-0">
                                      <a><img src="{{asset('asset/images/check_circle.svg')}}" alt="check-circle" class="img-fluid pr-2"></a>
                                    </div>
                                   
                                    <div class="col-10 my-auto p-0">   
                                    <span class="">Free unlimited job postings</span>                               
                                   </div>

                                </li>
                                 
                                <li class=" pb-2 px-4 d-flex">
                                    <div class="col-2 p-0">
                                        <a><img src="{{asset('asset/images/check_circle.svg')}}" alt="check-circle" class="img-fluid pr-2"></a>
                                    </div>
                                   
                                    <div class="col-10 my-auto p-0">   
                                        <span class="">Applications from candidates with Zero Notice Period</span>           
                                   </div>
                                   
                                </li>

                                <li class=" pb-2 px-4 d-flex">
                                    <div class="col-2 p-0">
                                        <a><img src="{{asset('asset/images/check_circle.svg')}}" alt="check-circle" class="img-fluid pr-2"></a>
                                    </div>
                                   
                                    <div class="col-10 my-auto p-0">   
                                        <span class="">{{ $package->package_num_days }} Days Job Applicants' Data/CV Database Access</span>           
                                   </div>
                                   
                                </li>

                                <li class=" pb-2 px-4 d-flex">
                                    <div class="col-2 p-0">
                                        <a><img src="{{asset('asset/images/check_circle.svg')}}" alt="check-circle" class="img-fluid pr-2"></a>
                                    </div>
                                   
                                    <div class="col-10 my-auto p-0">   
                                        <span class="">{{ $package->cv_access }}  CV Database/Applicant CV Views & Download</span>           
                                   </div>
                                   
                                </li>

                                <li class=" pb-2 px-4 d-flex">
                                    <div class="col-2 p-0">
                                        <a><img src="{{asset('asset/images/check_circle.svg')}}" alt="check-circle" class="img-fluid pr-2"></a>
                                    </div>
                                   
                                    <div class="col-10 my-auto p-0">   
                                        <span class="">{{ $package->package_num_listings }} Email connects across Job Ads/CV Database</span>           
                                   </div>
                                   
                                </li>

                                <li class=" pb-2 px-4 d-flex">
                                    <div class="col-2 p-0">
                                        <a><img src="{{asset('asset/images/check_circle.svg')}}" alt="check-circle" class="img-fluid pr-2"></a>
                                    </div>
                                   
                                    <div class="col-10 my-auto p-0">   
                                        <span class="">Upto {{ $package->cv_access }} Views of Jobseekers’ Video Interview Availability.
                                            </span>           
                                   </div>
                                   
                                </li>
                                <li class=" pb-2 px-4 d-flex">
                                    <div class="col-2 p-0">
                                        <a><img src="{{asset('asset/images/check_circle.svg')}}" alt="check-circle" class="img-fluid pr-2"></a>
                                    </div>
                                   
                                    <div class="col-10 my-auto p-0">   
                                        <span class="">
                                            Layoff CVs</span>           
                                   </div>
                                   
                                </li>

                                <li class=" pb-2 px-4 d-flex">
                                    <div class="col-2 p-0">
                                        <a><img src="{{asset('asset/images/check_circle.svg')}}" alt="check-circle" class="img-fluid pr-2"></a>
                                    </div>
                                   
                                    <div class="col-10 my-auto p-0">   
                                        <span class="">Post Contract/Internship Jobs</span>           
                                   </div>
                                   
                                </li>
                                {{-- <li class=" pb-2 px-4 d-flex">
                                    <div class="col-2 p-0">
                                        <a><img src="{{asset('asset/images/check_circle.svg')}}" alt="check-circle" class="img-fluid pr-2"></a>
                                    </div>
                                   
                                    <div class="col-10 my-auto p-0">   
                                        <span class="">Post Contract/Internship Jobs</span>           
                                   </div>
                                   
                                </li> --}}

                                {{-- @if($package->package_title == "Starter" || $package->package_title == "Basic")<li class="text-start pb-2 px-4"><a><img src="{{asset('asset/images/check_circle.svg')}}" alt="check-circle" class="img-fluid pr-2"></a>5 Free CV Views</li>@endif --}}
                            </ul>

                            <!-- <p class="text-center pb-2 px-4">5 Verified CV Access, View & Download <br><span class="pricing-bold">(Verified CV is screened by recruiters for critical data updates)</span></p>

                            <p class="text-center pb-2 pb-md-4 mb-md-4 px-4">NA</p> -->
                            <input type="hidden" name="package_id" class="package_id{{ $i }}"
                                value="{{ $package->id??'' }}"> 

                            <h2 class="text-center pricing_body-head_new pb-4 mb-3">₹ {{ $package->package_price }}</h2>

                            <div class="pb-5">
                                @if(Auth::guard('company')->check())
                                <a 
                                href="{{  route('employer.payment',['plan_id'=>$package->id]) }}"
                                    class="btn btn_style_new mx-auto trail" id="trail">Select Plan</a>
                                @elseif (Auth::check())
                                <button type="button" class="btn btn_style mx-auto plan"
                                    onclick="alert('Please Login as A Employer')" id="trail"> Select Plan</button>
                                @else
                                <button type="button" class="btn btn_style mx-auto trail{{ $i }}" data-toggle="modal"
                                    data-target="#planform" id="trail"> Select Plan</button>

                                @endif

                            </div>

                        </div>

                    </div>

                    @endif

                    @endforeach

                    {{-- <p id="myElem" style="display:none" >Successfully Submitted</p> --}}

                    <div class='alert alert-success newclass' id="myElem"
                        style="display:none;margin:auto;margin-bottom:30px;"><i class='fa fa-check'></i> Successfully
                        Submitted</div>
                    @if(session()->has('message12'))
                    <div class="alert alert-success" id="success-section" style="margin:auto;margin-bottom:30px;">
                        {{ session()->get('message12') }}
                    </div>
                    @endif



                    <div class="pricing_parent col-12 pb-3 pb-sm-4">

                        <div class="pricing_content px-3 px-sm-4">

                            <h6 class="mb-1 pt-3 dash_box-texthead">Note:</h6>
                            <ul class="pl-4">
                                <li>*3 free CVs of Applicants accessible when jobs are posted. Responses after free CV views are to be purchased.</li>
                                <li>CV View / CV Download / Click to view phone no. = 1 CV Access.</li>
                                <li>All features should be consumed within 30 Days from the date of activation/purchase. Please refer the validity.</li>
                                <li>Please note that the amounts are exclusive of taxes. Taxes will be added as applicable.</li>
                                <!--<li></li>-->
                                <!--<li>Single CV/Video Interview purchase are standalone products and are not combined with the subscription plans above.</li>-->
                            </ul>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<!-- modal -->



<div class="container modal_content" id="modal-container">

    <!-- modal -->

    <div class="modal" id="planform">

        <div class="modal-dialog px-0">

            <div class="modal-content w-md-50 mx-auto px-0 py-3">

                <!-- header -->

                <p type="button" class="info pr-3" id="reset" data-dismiss="modal"><img
                        class="float-right modal_close-icon modal_crossarrow"
                        src="{{asset('/')}}asset/images/close.png"></p>

                {{-- <p type="button" class="info pr-2"  ><img

                        class="float-right modal_close-icon modal_crossarrow" src="{{asset('/')}}asset/images/cancel.png">
                </p> --}}

                <h5 class="text-center sign_head my-0">Sign Up As An<span class=" sign_color"> Employer</span>

                </h5>

                <!-- body -->









                <div class="col-12 modal-body px-0">

                    <form class="px-3 px-sm-5 priceform row" action="{{route('employer')}}" method="POST"
                        id="priceform1">

                        {{ csrf_field() }}



                        {{-- @if ($errors->any())

                        @foreach ($errors->all() as $error)

                            <div>{{$error}}
                </div>

                @endforeach

                @endif --}}

                <div class="col-lg-6" id="div_company_name">



                    <input type="hidden" value="" id="plandetail" class="plan" name="package_name">

                    <p class="sign_fontsize mb-2 pt-3">Company Name<span class="text-danger px-1">*</span></p>

                    <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Company Name"
                        maxlength="100" name="company_name" id="company_name">

                    <span class="help-block company_name-error"></span>

                </div>


                <div class="col-lg-6">
                    <p class="sign_fontsize mb-2 pt-3">Offical Email<span class="text-danger px-1">*</span></p>

                    <input type="email" class="w-100 py-2 px-3 signin_input rounded" placeholder="Offical Email"
                        maxlength="100" name="email">



                    <span class="help-block email-error"></span>

                </div>
                <div class="col-lg-6">
                    <p class="sign_fontsize mb-2 pt-3">Mobile/Landline<span class="text-danger px-1">*</span></p>

                    <input type="number" class="w-100 py-2 px-3 signin_input rounded pricing-mobile"
                        placeholder="Mobile/Landline" maxlength="100" name="mobile" min="0">

                    <span class="help-block mobile-error"></span>
                </div>

                <div class="col-lg-6">
                    <p class=" sign_fontsize mb-2 pt-3">Contact Person Name<span class="text-danger px-1">*</span>

                    </p>

                    <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Contact Person Name"
                        maxlength="100" name="person_name">

                    <span class="help-block person_name-error"></span>

                </div>

                <div class="col-12">
                    <div class="row px-0 pt-3 py-0">

                        <div class="col-6 form__radio-group m-0 py-0">

                            <input type="radio" name="size" id="small" class="form__radio-input" value="company">

                            <label class="form__label-radio" for="small" class="form__radio-label">

                                <span class="form__radio-button">Company</span>

                            </label>

                        </div>

                        <div class="col-6 form__radio-group m-0 py-0">

                            <input type="radio" name="size" id="large" class="form__radio-input"
                                value="Recruitment Firm">

                            <label class="form__label-radio" for="large" class="form__radio-label">

                                <span class="form__radio-button">Recruitment Firm</span>

                            </label>

                        </div>

                        <span class="help-block size-error" style="
                            margin-left: 16px;"></span>

                    </div>
                </div>
                <div class="col-lg-6">
                    <p class=" sign_fontsize mb-2 pt-3">GSTIN (Optional)</p>

                    <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="GSTIN (Optional)"
                        onkeyup="toUpper(event)" maxlength="100" name="gstin">
                    <span class="help-block gstin-error"></span>
                </div>
                <div class="col-lg-6">

                    <p class="sign_fontsize mb-2 pt-3">Pin Code<span class="text-danger px-1">*</span></p>

                    <input type="number" class="w-100 py-2 px-3 signin_input rounded mb-2" placeholder="Pin code"
                        maxlength="100" name="pincode">

                    <span class="help-block pincode-error"></span>

                </div>

                <div class="col-12  mb-2 mt-1">

                    <input type="checkbox" id="checkbox_sizes" class="checkbox_size align-middle" name="promotional"
                        maxlength="100" requried>

                    <label for="checkbox_sizes" class="sign_fontsize">I agree to receive Promotional

                        Communication from ZeroNoticePeriod</label>

                    </input>

                </div>

                <div class="col-12 mb-3">

                    <div class="dummy">

                        <input type="checkbox" id="Conditions" class="checkbox_size  align-middle" maxlength="100"
                            name="terms">

                        <label for="Conditions" class="sign_fontsize">I have read, understood and agree to the

                            <a href="{{ url('employer-terms-conditions') }}" required>Terms & Conditions</a>

                        </label>

                    </div>

                    <span class="help-block terms-error"></span>

                </div>




                <div class="col-12">

                <button type="submit" class="w-100 py-2 signin_button rounded" onclick="submitprcie();"><span
                        id='submit_text'>Submit</span> <img src='{{asset('asset/images/loader1.gif')}}'
                        style="width: 22px;height: 22px; display:none" id="gif_loader"></button>
            </div>
            </form>

        </div>

    </div>

</div>

</div>

</div>



<!-- modal end -->



<!-- Footer section -->





@include('includes.footer')

@endsection

@push('scripts')

<script></script>

<script type="text/javascript">
var SITEURL = '{{URL::to('
')}}';

$(".trail1").click(function() {

    //  alert('trail plan');

    //var text=$(this).text();

    var p = $('.package_id1').val();

    $("#plandetail").val(p);




});



$('.trail2').click(function() {

    var p = $('.package_id3').val();


    $("#plandetail").val(p);



});



$('.trail3').click(function() {



    //  alert('standard');
    var p = $('.package_id3').val();


    $("#plandetail").val(p);


});



$('.trail4').click(function()

    {



        // alert('premium');

        var p = $('.package_id4').val();


        $("#plandetail").val(p);


    });
</script>

<script>
//                    $(document).ready(function() {

//     $('.modal_content').on('hidden.bs.modal', function(){

//         $(this).find('form')[0].reset();

//      });

// });

// $(document).ready(function() {

//    $('#planform').on('hidden', function() {

//       clear()

//    });

// });









function submitprcie() {









    $("form").submit(function(e) {

        e.preventDefault();

    });







    // $('#myModal').on('hidden.bs.modal', function () {

    // $('#myModal form')[0].reset();

    // });



    var form = $('.priceform');

    $.ajax({

        url: form.attr('action'),

        type: form.attr('method'),

        data: form.serialize(),

        dataType: 'json',
        beforeSend: function() {
            // Show image container
            $("#submit_text").hide();
            $("#gif_loader").show();
        },

        success: function(json) {


            var id = json.plan_id;
            //  alert('success');



            //$('#planform').hide();
            $("#submit_text").show();

            $("#gif_loader").hide();

            $('#planform').modal('hide');

            $("#myElem").show();

            // $('#myModal').on('hidden.bs.modal', function () {

            // $('#myModal form')[0].reset();

            // });



            setTimeout(function() {
                $("#myElem").hide();
            }, 5000);

            window.location = SITEURL + '/company-redirect' + '/' + id;

            // $('#msg12').append("<div class='alert alert-success'><i class='fa fa-check'></i> Successfully Submitted</div>"); 

        },

        error: function(json) {



            // e.preventDefault();



            if (json.status === 422) {

                $("#submit_text").show();

                $("#gif_loader").hide();

                var resJSON = json.responseJSON;

                $('.help-block').html('');

                $.each(resJSON.errors, function(key, value) {



                    $('.' + key + '-error').html('<strong class="new_error_class">' + value +
                        '</strong>');





                    $('#div_' + key).addClass('has-error');

                    //  alert('hello');





                });



            } else {

                // Error

                // Incorrect credentials

                // alert('Incorrect credentials. Please try again.')

            }

        }

    });

}
</script>
<script>
$('body').on('keyup', '.pricing-mobile', function() {
    var $input = $(this),
        value = $input.val(),
        length = value.length,
        inputCharacter = parseInt(value.slice(-1));

    if (!((length > 0 && inputCharacter >= 0 && inputCharacter <= 10) || (length === 1 && inputCharacter >= 7 &&
            inputCharacter <= 10))) {
        $input.val(value.substring(0, length - 1));
    }
});

function toUpper(e) {
    setTimeout(function() {
        let v = e.target.value.toUpperCase();
        e.target.value = v;
    }, 100);
}
</script>


@endpush