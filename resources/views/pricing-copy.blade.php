{{-- {!! APFrmErrHelp::showErrorsNotice($errors) !!} --}}



@extends('layouts.app')



@section('content') 

<!-- Header start --> 

@include('includes.header') 

<!-- Header end --> 



<!-- hear section -->



<style>
    .bubblingG {
	text-align: center;
	width:78px;
	height:49px;
	margin: auto;
}

.bubblingG span {
	display: inline-block;
	vertical-align: middle;
	width: 10px;
	height: 10px;
	margin: 24px auto;
	background: rgb(0,0,0);
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
		background-color:rgb(0,0,0);
		transform: translateY(0);
	}

	100% {
		width: 23px;
		height: 23px;
		background-color:rgb(255,255,255);
		transform: translateY(-20px);
	}
}

@-o-keyframes bubblingG {
	0% {
		width: 10px;
		height: 10px;
		background-color:rgb(0,0,0);
		-o-transform: translateY(0);
	}

	100% {
		width: 23px;
		height: 23px;
		background-color:rgb(255,255,255);
		-o-transform: translateY(-20px);
	}
}

@-ms-keyframes bubblingG {
	0% {
		width: 10px;
		height: 10px;
		background-color:rgb(0,0,0);
		-ms-transform: translateY(0);
	}

	100% {
		width: 23px;
		height: 23px;
		background-color:rgb(255,255,255);
		-ms-transform: translateY(-20px);
	}
}

@-webkit-keyframes bubblingG {
	0% {
		width: 10px;
		height: 10px;
		background-color:rgb(0,0,0);
		-webkit-transform: translateY(0);
	}

	100% {
		width: 23px;
		height: 23px;
		background-color:rgb(255,255,255);
		-webkit-transform: translateY(-20px);
	}
}

@-moz-keyframes bubblingG {
	0% {
		width: 10px;
		height: 10px;
		background-color:rgb(0,0,0);
		-moz-transform: translateY(0);
	}

	100% {
		width: 23px;
		height: 23px;
		background-color:rgb(255,255,255);
		-moz-transform: translateY(-20px);
	}
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

@if(Auth::guard('company')->check()) 

<section class="contact_para pt-sm-3">

    <div class="container">

        <div class="row">

            <div class="col-lg-8 m-auto text-center px-md-2 py-2">

                <div class="py-4 py-sm-5">

                    <p class="contact_para-align mb-0 px-4 px-md-0">Login To Verified Database of IT & Non IT Talent With ZERONOTICEPERIOD</p>

                </div>

            </div>

        </div>

    </div>

</section>

  @else

  <section class="contact_para pt-sm-3">

    <div class="container">

        <div class="row">

            <div class="col-lg-8 m-auto text-center px-md-2 py-2">

                <div class="py-4 py-sm-5">

                    <p class="contact_para-align mb-0 px-4 px-md-0">Login To Verified Database of IT & Non IT Talent

                        With ZERONOTICEPERIOD</p>

                </div>

            </div>

        </div>

    </div>

</section>

@endauth

@php
    
    $package = Package::all();

@endphp



<!-- pricing main section -->



<section class="pricing_main-part">

    <div class="container">

        <div class="row">

            <div class="col-12 m-auto pb-4 pb-sm-5">

                <div class="row">

                    <div class="pricing_parent col-md-6 col-xl-3 pb-3 pb-sm-5">

                        <div class="pricing_content">

                            <h2 class="text-center pricing_background-head">TRIAL</h2>                      

                            <p class="text-center pb-2 px-4 pt-4">30 Days Resume Database Access</p>

                            <p class="text-center pb-2 px-5">200 CVs</p>

                            <!-- <p class="text-center pb-2 px-4">5 Verified CV Access, View & Download <br><span class="pricing-bold">(Verified CV is screened by recruiters for critical data updates)</span></p>

                            <p class="text-center pb-2 pb-md-4 mb-md-4 px-4">NA</p> -->

                            <p class="text-center pb-2 px-4">200 Email</p>

                            <h2 class="text-center pricing_body-head pb-4 mb-3">INR 15000</h2>

                            <div class="pb-5">
                                @if(Auth::guard('company')->check())
                                <a href="{{  route('employer.payment',['plan_id'=>]) }}"  class="btn btn_style mx-auto trail" 

                                     id="trail" > Buy Now</a>
                                     @elseif (Auth::check())
                                     <button type="button" class="btn btn_style mx-auto trail" onclick="alert('Please Login as A Employer')" id="trail" > Select Plan</button>
                                @else
                                    <button type="button" class="btn btn_style mx-auto trail" data-toggle="modal"

                                    data-target="#planform" id="trail" > Select Plan</button>

                                 @endif

                            </div>

                        </div>

                    </div>

                    <div class="pricing_parent col-md-6 col-xl-3 pb-3 pb-sm-5">

                        <div class="pricing_content">

                            <h2 class="text-center pricing_background-head">BASIC</h2>

                            <p class="text-center pb-2 px-4 pt-4">30 Days Resume Database Access</p>

                            <p class="text-center pb-2 px-5">500 CVs</p>

                            <!-- <p class="text-center pb-2 px-4">250 Verified CV Access, View & Download <br><span class="pricing-bold">(Verified CV is screened by recruiters for critical data updates)</span></p>

                            <p class="text-center pb-2 px-4">250 Normal CV Access, Email, Download</p> -->

                            <p class="text-center pb-2 px-4">500 Emails</p>

                            <h2 class="text-center pricing_body-head pb-4 mb-3">INR 25000</h2>

                            <div class="pb-5">

                                @if(Auth::guard('company')->check())
                                <a href="{{  route('employer.payment',['plan_id'=>'Basic']) }}"  class="btn btn_style mx-auto basic" 

                                     id="trail" > Buy Now</a>
                                     @elseif (Auth::check())
                                     <button type="button" class="btn btn_style mx-auto basic" onclick="alert('Please Login as A Employer')" id="trail" > Select Plan</button>
 
                                    @else
                                    <button type="button" class="btn btn_style mx-auto basic" data-toggle="modal"

                                    data-target="#planform" id="trail" > Select Plan</button>

                                 @endif
                            </div>

                        </div>

                    </div>

                    <div class="pricing_parent col-md-6 col-xl-3 pb-3 pb-sm-5">

                        <div class="pricing_content">

                            <h2 class="text-center pricing_background-head">STANDARD</h2>

                            <p class="text-center pb-2 px-4 pt-4">30 Days Resume Database Access</p>

                            <p class="text-center pb-2 px-5">700 CVs</p>

                            <p class="text-center pb-2 px-4">700 Emails</p>

                            <h2 class="text-center pricing_body-head pb-4 mb-3">INR 35000</h2>

                            <div class="pb-5">

                                @if(Auth::guard('company')->check())
                                <a href="{{  route('employer.payment',['plan_id'=>'Standard']) }}"  class="btn btn_style mx-auto standard" 

                                     id="standard" > Buy Now</a>
                                     @elseif (Auth::check())
                                    <button type="button" class="btn btn_style mx-auto standard" onclick="alert('Please Login as A Employer')" id="standard" > Select Plan</button>
                                    @else
                                    <button type="button" class="btn btn_style mx-auto standard" data-toggle="modal"

                                    data-target="#planform" id="standard" > Select Plan</button>
                                 @endif
                            </div>

                        </div>

                    </div>

                    <div class="pricing_parent col-md-6 col-xl-3 pb-3 pb-sm-5">

                        <div class="pricing_content">

                            <h2 class="text-center pricing_background-head">PREMIUM</h2>

                            <p class="text-center pb-2 px-4 pt-4">30 Days Resume Database Access</p>

                            <p class="text-center pb-2 px-5">1000 CVs</p>

                            <!-- <p class="text-center pb-2 px-4">500 Verified CV Access, View & Download <br><span class="pricing-bold">(Verified CV is screened by recruiters for critical data updates)</span></p>

                            <p class="text-center pb-2 px-4">500 Normal CV Access, Email, Download</p> -->

                            <p class="text-center pb-2 px-4">1000 Emails</p>

                            <h2 class="text-center pricing_body-head pb-4 mb-3">INR 50000</h2>

                            <div class="pb-5">

                                @if(Auth::guard('company')->check())
                                <a href="{{  route('employer.payment',['plan_id'=>'Premium']) }}"  class="btn btn_style mx-auto premium" 

                                     id="premium" > Buy Now</a>
                                    @elseif (Auth::check())
                                    <button type="button" class="btn btn_style mx-auto premium" onclick="alert('Please Login as A Employer')"

                                     > Select Plan</button>
                                    @else
                                    <button type="button" class="btn btn_style mx-auto premium" data-toggle="modal"

                                    data-target="#planform" id="premium" > Select Plan</button>

                                 @endif
                            </div>

                        </div>

                    </div>

                    {{-- <p id="myElem" style="display:none" >Successfully Submitted</p> --}}

                    <div class='alert alert-success newclass' id="myElem" style="display:none;margin:auto;margin-bottom:30px;"><i class='fa fa-check'></i> Successfully Submitted</div>
                    @if(session()->has('message12'))
                    <div class="alert alert-success" id="success-section" style="margin:auto;margin-bottom:30px;">
                        {{ session()->get('message12') }}
                    </div>
                @endif
               
                    

                    <div class="pricing_parent col-12 pb-3 pb-sm-4">

                        <div class="pricing_content">

                            <p class="mb-0 py-3 px-3 px-sm-4">Note: Verified CV is Screened by recruiters for a Detailed Notice Period Update & Verification, Compensation Specifics (Split of Fixed/Variable/Bonus) & Expected CTC, Multiple offers information, Detailed Employee Preferences, Openness to Contract Opportunities.</p>

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

                <p type="button" class="info pr-2" id="reset" data-dismiss="modal"><img

                    class="float-right modal_close-icon modal_crossarrow" src="{{asset('/')}}asset/images/cancel.png"></p>

                {{-- <p type="button" class="info pr-2"  ><img

                        class="float-right modal_close-icon modal_crossarrow" src="{{asset('/')}}asset/images/cancel.png"></p> --}}

                <h5 class="text-center sign_head my-0">Sign Up as an<span class=" sign_color"> Employer</span>

                </h5>

                <!-- body -->

              

                

                

                

                <div class="col-12 modal-body px-0">

                    <form class="px-3 px-sm-5 priceform" action="{{route('employer')}}" method="POST" id="priceform1">

                        {{ csrf_field() }}

                        

                        {{-- @if ($errors->any())

                        @foreach ($errors->all() as $error)

                            <div>{{$error}}</div>

                        @endforeach

                    @endif --}}

                        <div id="div_company_name">

                        

                        <input type="hidden"  value="" id="plandetail" name="package_name">

                        <p class="sign_fontsize mb-2 pt-3">Company Name<span class="text-danger px-1">*</span></p>

                        <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Company Name"

                            maxlength="100" name="company_name" id="company_name">

                            <span class="help-block company_name-error"></span>

                        </div>

                            

                        <p class="sign_fontsize mb-2 pt-3">Offical Email<span class="text-danger px-1">*</span></p>

                        <input type="email" class="w-100 py-2 px-3 signin_input rounded" placeholder="Offical Email"

                            maxlength="100" name="email" >

                            

                            <span class="help-block email-error" ></span>

                            

                        <p class="sign_fontsize mb-2 pt-3">Mobile/Landline<span class="text-danger px-1">*</span></p>

                        <input type="number" class="w-100 py-2 px-3 signin_input rounded pricing-mobile" placeholder="Mobile/Landline"

                            maxlength="100" name="mobile" min="0"  >

                            <span class="help-block mobile-error" ></span>

                            

                        <p class=" sign_fontsize mb-2 pt-3">Contact Person Name<span class="text-danger px-1">*</span>

                        </p>

                        <input type="text" class="w-100 py-2 px-3 signin_input rounded"

                            placeholder="Contact Person Name" maxlength="100" name="person_name" >

                            <span class="help-block person_name-error" ></span>

                            

                            

                            

                        <p class=" sign_fontsize mb-2 pt-3">GSTIN (Optional)</p>

                        <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="GSTIN (Optional)" onkeyup="toUpper(event)"

                            maxlength="100" name="gstin" >
                            <span class="help-block gstin-error" ></span>

                        <div class="row px-0 pt-3 py-0">

                            <div class="col-6 form__radio-group m-0 py-0">

                                <input type="radio" name="size" id="small" class="form__radio-input" value="company">

                                <label class="form__label-radio" for="small" class="form__radio-label">

                                    <span class="form__radio-button">Company</span>

                                </label>

                            </div>

                            <div class="col-6 form__radio-group m-0 py-0">

                                <input type="radio" name="size" id="large" class="form__radio-input" value="Recruitment Firm">

                                <label class="form__label-radio" for="large" class="form__radio-label">

                                    <span class="form__radio-button">Recruitment Firm</span>

                                </label>

                            </div>

                            <span class="help-block size-error" style="
                            margin-left: 16px;"></span>

                        </div>

                        <p class="sign_fontsize mb-1">Pin Code<span class="text-danger px-1">*</span></p>

                        <input type="number" class="w-100 py-2 px-3 signin_input rounded mb-2" placeholder="Pin code"

                            maxlength="100" name="pincode" >

                            <span class="help-block pincode-error" ></span>



                        <div class="col-12 px-0 mb-2 mt-1">

                            <input type="checkbox" id="checkbox_sizes" class="checkbox_size align-middle" name="promotional"

                                maxlength="100" requried>

                            <label for="checkbox_sizes" class="sign_fontsize">I agree to receive Promotional

                                Communication from ZeroNoticePeriod</label>

                            </input>

                        </div>

                        <div class="col-12 px-0 mb-3">

                        <div class="dummy">

                            <input type="checkbox" id="Conditions" class="checkbox_size  align-middle" maxlength="100" name="terms"

                                >

                            <label for="Conditions" class="sign_fontsize">I have read, understood and agree to the

                                <a href="#"  required>Terms & Conditions</a>

                            </label>

                        </div>

                            <span class="help-block terms-error" ></span>

                        </div>

                       

                        

                        <button type="submit" class="w-100 py-2 signin_button rounded" onclick="submitprcie();"><span id='submit_text'>Submit</span> <img src='{{asset('asset/images/loader1.gif')}}' style="width: 22px;height: 22px; display:none" id="gif_loader"></button>

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

var SITEURL = '{{URL::to('')}}';

$(".trail").click(function(){

//  alert('trail plan');

    //var text=$(this).text();

    $("#plandetail").val("17");

}); 



$('.basic').click(function(){

//  alert('basic');

$('#plandetail').val("18");





});



$('.standard').click(function(){



//  alert('standard');

$("#plandetail").val("19");





});



$('.premium').click(function()

{



// alert('premium');

$("#plandetail").val("20");





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





    



    $("form").submit(function(e){

        e.preventDefault();

    });


    


    

    // $('#myModal').on('hidden.bs.modal', function () {

    // $('#myModal form')[0].reset();

    // });

    

        var form = $('.priceform');

        $.ajax({

        url     : form.attr('action'),

                type    : form.attr('method'),

                data    : form.serialize(),

                dataType: 'json',
                beforeSend: function(){
                    // Show image container
                    $("#submit_text").hide();
                    $("#gif_loader").show();
                },

                success : function (json){

                
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



               setTimeout(function() { $("#myElem").hide(); }, 5000);

               window.location = SITEURL + '/company-redirect'+ '/' + id;
             
               // $('#msg12').append("<div class='alert alert-success'><i class='fa fa-check'></i> Successfully Submitted</div>"); 

                },

                error: function(json){

                

               // e.preventDefault();

               

                if (json.status === 422) {

                    $("#submit_text").show();

                     $("#gif_loader").hide();

                var resJSON = json.responseJSON;

                $('.help-block').html('');

                $.each(resJSON.errors, function (key, value) {

                

                $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

                

               

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

    $('body').on('keyup', '.pricing-mobile', function () {
        var $input = $(this),
            value = $input.val(),
            length = value.length,
            inputCharacter = parseInt(value.slice(-1));
    
        if (!((length > 0 && inputCharacter >= 0 && inputCharacter <= 10) || (length === 1 && inputCharacter >= 7 && inputCharacter <= 10))) {
            $input.val(value.substring(0, length - 1));
         }
      });
    
      function toUpper(e){
  setTimeout(function(){
    let v = e.target.value.toUpperCase();
  e.target.value = v;
  },100);
}
        </script>


@endpush