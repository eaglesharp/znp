@extends('layouts.app')

@section('content')


@include('includes.header')


<style>
.avatar-upload {

    position: relative;

    max-width: 205px;

    margin: auto;

}

.avatar-upload .avatar-edit {

    position: absolute;

    left: -11px;

    z-index: 1;

    top: -13px;

}

.avatar-upload .avatar-edit input {

    display: none;

}

.avatar-upload .avatar-edit input+label {

    display: inline-block;

    width: 34px;

    height: 34px;

    line-height: 14px;

    margin-bottom: 0;

    border-radius: 100%;

    background: #FFFFFF;

    border: 1px solid transparent;

    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);

    cursor: pointer;

    font-weight: normal;

    transition: all 0.2s ease-in-out;

}

.avatar-upload .avatar-edit input+label:hover {

    background: #f1f1f1;

    border-color: #d6d6d6;

}

.avatar-upload .avatar-edit input+label:after {

    content: "\f040";

    font-family: 'FontAwesome';

    color: #757575;

    position: absolute;

    top: 10px;

    left: 0;

    right: 0;

    text-align: center;

    margin: auto;

}

.avatar-upload .avatar-preview {

    position: relative;

}
</style>




<section class="section_signup py-4 py-sm-5">



    <div class="container">


        <div class="box pt-4 pb-5 dash_box ">
            <h5 class="sign_head px-4 mb-3 text_box-align">Edit Profile</h5>
            <hr class="mb-4">
            <div class="row px-lg-5 px-3">
                <div class="col-lg-3 d-flex justify-content-center align-items-center">
                    <div class="avatar-upload">

                        <div class="avatar-edit">

                            @php
                            $company_id = Auth::guard('company')->user()->id;
                            $company = \App\Company::where('id',$company_id)->first();

                            @endphp




                            <form method="post" enctype="" id="formvalue">

                                {{ csrf_field() }}

                                <input type='file' id="imageUpload" name="logo" class="changeimage"
                                    accept=".png, .jpg, .jpeg" />

                                <label for="imageUpload"></label>



                                <span class="text-danger"></span>



                            </form>







                        </div>

                        <div class="avatar-preview">

                            <div id="imagePreview">

                                <a href="javascript:void(0);">



                                

                                        @if(Auth::guard('company')->user()->logo)
                                        <img src="{{ asset('company_logos/'.$company->logo) }}" style="width: 115px;height:115px"
                                            class="img-fluid  canddashboard-userpic">

                                        @else

                                        <img src="asset/images/dashboardpic.png"
                                            class="img-fluid  canddashboard-userpic">
                                        @endif
                                </a>
<p class="mb-0 pt-2" style="
font-size: 12px;
margin-left: 12px;
">Upload the Logo</p>
                                
                               

                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-lg-9">
                    <form action="{{ url('update-front-companyprofile') }}" id="updatecompanny" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-md-6 pt-4">

                                <label class="mb-2  pt-lg-0 sign_fontsize">Company Name<span
                                        class="text-danger px-1">*</span></label>
                                <input type="text" class="w-100 py-2 px-3 signin_input rounded"
                                    placeholder="Company Name" maxlength="100" name="name" id="company_name"
                                    value="{{ $company->name??'' }}">
                                <input type="hidden" name="company_id" value="{{ $company->id }}">


                                <span class="help-block work_type-error" style="color:#a94442"></span>

                            </div>

                            <div class="col-md-6 pt-3">

                                <label class="mb-2  pt-lg-0 sign_fontsize">Official Email<span
                                        class="text-danger px-1">*</span></label>

                                @if($company->email_verified == 1)
                                <input type="" class="w-100 py-2 px-3 signin_input rounded pricing-mobile " disabled
                                    placeholder="Office Email" maxlength="100" name="email" min="0"
                                    value="{{ $company->email??'' }}">
                                    <p  class="email_verify mt-3 "
                                            value="">Verified</p>
                                @else 
                                <input type="" class="w-100 py-2 px-3 signin_input rounded pricing-mobile"
                                    placeholder="Office Email" maxlength="100" name="email" min="0"
                                    value="{{ $company->email??'' }}">
                                    <a href="{{ route('verify.company.email',$company->id) }}" class="email_verify mt-3 "
                                            value="">Verify</a>
                                @endif

                                <span class="help-block shifts-error" style="color:#a94442"></span>

                            </div>
                            <div class="col-md-6 pt-3">

                                <label class="mb-2  pt-lg-0 sign_fontsize">Mobile/Landline<span
                                        class="text-danger px-1">*</span></label>

                                <input type="number" class="w-100 py-2 px-3 signin_input rounded pricing-mobile"
                                    placeholder="Mobile/Landline Number" maxlength="100" name="phone" min="0"
                                    value="{{ $company->phone??'' }}">

                                <span class="help-block shifts-error" style="color:#a94442"></span>

                            </div>

                            <div class="col-md-6 pt-3">

                                <label class="mb-2  pt-lg-0 sign_fontsize">Contact Person Name<span
                                        class="text-danger px-1">*</span></label>

                                <input type="text" class="w-100 py-2 px-3 signin_input rounded"
                                    placeholder="Contact Person Name" maxlength="100" name="ceo"
                                    value="{{ $company->ceo }}">

                                <span class="help-block shifts-error" style="color:#a94442"></span>

                            </div>
                            @php
                                $descriptionWithoutLineBreaks = strip_tags($company->description);

                            @endphp
                            <div class="col-md-12 pt-3">

                                <label class="mb-2  pt-lg-0 sign_fontsize">About Company<span
                                        class="text-danger px-1">*</span></label>

                                <textarea class="w-100 py-2 px-3 signin_input rounded"
                                    placeholder="About Company" maxlength="100" name="description"
                                    >{{ $descriptionWithoutLineBreaks }}</textarea>
                                
                                <span class="help-block description-error" style="color:#a94442"></span>

                            </div>
                            
                        

                            <div class="col-sm-7 col-md-8 pt-3 mt-3">

                                <div class="success_msg" id="success_msg14"></div>


                            </div>

                            <div class="col-sm-5 col-md-4 pt-sm-3 mt-sm-3 text-center text-sm-right">

                                <input class="signin_button rounded px-5 py-2 new-cursor" value="Update" type="button"
                                    onclick="updatecompanyprofile();">


                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>


@include('includes.footer')

@endsection
@push('scripts')
<script>
$(".changeimage").change(function() {



    // alert('hello');





    $.ajax({



        url: "{{url('employer-image-store')}}",



        type: "POST",





        data: new FormData($('#formvalue')[0]),

        processData: false,

        contentType: false,



        _token: '{{ csrf_token() }}',



        dataType: 'json',



        success: function(data) {



            //   alert('success');



            location.reload(true);





        },



        error: function(json) {



            // location.reload(true);



            if (json.status === 422) {

                var resJSON = json.responseJSON;

                $('.help-block').html('');

                $.each(resJSON.errors, function(key, value) {

                    $('.' + key + '-error').html('<strong class="text-danger">' + value +
                        '</strong>');

                    $('#div_' + key).addClass('has-error');

                });

            } else {

                // Error

                // Incorrect credentials

                // alert('Incorrect credentials. Please try again.')

            }



        }



    });

});

function updatecompanyprofile() {
    //  alert('hello');
    var form = $('#updatecompanny');
    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        dataType: 'json',
        success: function(json) {
            //    alert('success');
            $("#success_msg14").html(
                "<div class='alert alert-success'>{{__('Profile updated successfully')}}</div>");
            setTimeout(function() {
                $("#success_msg14").hide();
            }, 2000);

            location.reload();
            //    $("#success_msg15").show(); 
            //    $(".new_error_class").hide(); 
            //    $("#success_msg15").empty();
            //         $("#success_msg15").html("<div class='alert alert-success'>{{__('Compensation updated successfully')}}</div>");
            //         setTimeout(function() { $("#success_msg15").hide(); }, 5000);
        },
        error: function(json) {
            if (json.status === 422) {
                var resJSON = json.responseJSON;
                $('.help-block').html('');
                $.each(resJSON.errors, function(key, value) {
                    $('.' + key + '-error').html('<strong class="new_error_class">' + value +
                        '</strong>');
                    $('#div_' + key).addClass('has-error');
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


@endpush