

@extends('layouts.app')

@section('content')

<!-- Header start -->

@include('includes.header')

<!-- Header end --> 

<!-- Inner Page Title start -->

<section class="section_mobileverification align-items-center d-flex">

    <div class="container">

        <div class="col-12 col-md-10 col-lg-7 col-xl-7 mx-auto py-5">

            <div class="row ">

                <div class="col-12">

                    <div class="box my-auto rounded p-4 p-sm-5">

                        <div class="">

                            <h4 class="sign_head text-center pb-2">Mobile Verification</h4>

                            <h6 class="verify_head text-center pb-2">To continue Using Job Portal, Please verify your Mobile Number</h6>

                            <form class="text-center" action="{{url('verify-otp',$user->id)}}" method="POST" id="verifyotp">

                            @csrf

                                <div class="col-lg-8 m-auto pb-2 sign_head">

                                    {{$phone}}

                                </div>

                             <input type="hidden" value="{{$phone}}" name="phone">

                                    <input type="tel" maxlength="6" placeholder="Enter OTP" class="py-2 px-3 otp_mobile rounded signin_input" name="otp">
                                    
                                    <br>
                                    @if($errors->has('otp'))
                                    <span class="text-danger">{{$errors->first('otp')}}</span>
                                    @endif  

                                    @if($errors->has('error'))
                                    <span class="text-danger">{{$errors->first('error')}}</span>
                                    @endif  

                                    <h4 id="error"></h4>

                                    <span class="help-block otp-error"></span>

                                    <span class="help-block not_same-error"></span>


                                <div class="pt-3 text-center"> <button type="button" class="py-2 rounded signin_button px-3" onclick="Submitotp();" >Submit</button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@include('includes.footer')

@endsection

@push('scripts')
<script>

function Submitotp()
{

var form = $('#verifyotp');

$.ajax({
    type: form.attr('method'),
    url     : form.attr('action'),
    data    : form.serialize(),
    dataType: "json",
    success: function (response) {
        alert('success');
        
    },
    error: function(json){



if (json.status === 422) {

var resJSON = json.responseJSON;

$('.help-block').html('');

$.each(resJSON.errors, function (key, value) {

$('.' + key + '-error').html('<strong class="text-danger">' + value + '</strong>');

$('#div_' + key).addClass('has-error');

});

}else{

    // var resJSON = json.responseJSON;

    alert('Please Enter Valid Otp');
    
    
}





}

});





}




</script>
    
@endpush


