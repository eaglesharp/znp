{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')

<div id="employment" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">

    <div class="myprofile_font">Employment Preferences<a href="javascript:void(0)"><i id="edit13"

                class="fa fa-pencil pl-2" aria-hidden="true"></i></a> </div>

</div>

<div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">

    <form  method="POST" id="update_details" action="{{ route('update.details', [$user->id]) }}">{{ csrf_field() }}
        <div class="success_msg" id="success_msg165">

               

        </div>
        <div class="row ">

            <div class="col-lg-6">

                <label class="mb-2 pt-3 pt-lg-0 sign_fontsize">Preferred Work Type<span

                        class="text-danger px-1">*</span></label>

                <select name="work_type"

                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded edit2" >

                    <option selected disabled>Select Work Type</option>

                  

                <option   value="Contract" @if(isset($user->getprofileDetails()->work_type)) @if($user->getprofileDetails()->work_type=="Contract") selected @endif  @endif>Contract</option>

                <option  value="Permanent" @if(isset($user->getprofileDetails()->work_type)) @if($user->getprofileDetails()->work_type=="Permanent") selected @endif  @endif>Permanent</option>

                {{-- <option  value="Freelance" @if(isset($user->getprofileDetails()->work_type)) @if($user->getprofileDetails()->work_type=="Freelance") selected @endif  @endif>Freelance</option> --}}

                <option  value="Flexible" @if(isset($user->getprofileDetails()->work_type)) @if($user->getprofileDetails()->work_type=="Flexible") selected @endif  @endif>Flexible</option>

            
            
            </select>

                <span class="help-block work_type-error" style="color:#a94442"></span>

            </div>

            <div class="col-lg-6">

                <label class="mb-2 pt-3 pt-lg-0 sign_fontsize">Preferred Work Shift<span

                        class="text-danger px-1">*</span></label>

                <select name="shifts"

                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded edit2" >

                    <option selected disabled>Select Shift</option>

                    <option   value="Indian Shift" @if(isset($user->getprofileDetails()->shifts)) @if($user->getprofileDetails()->shifts=="Indian Shift") selected @endif  @endif>Indian Shift</option>

                <option  value="Rotational" @if(isset($user->getprofileDetails()->shifts)) @if($user->getprofileDetails()->shifts=="Rotational") selected @endif  @endif>Rotational</option>

                <option  value="US Shift" @if(isset($user->getprofileDetails()->shifts)) @if($user->getprofileDetails()->shifts=="US Shift") selected @endif  @endif>US Shift</option>

                <option  value="UK Shift" @if(isset($user->getprofileDetails()->shifts)) @if($user->getprofileDetails()->shifts=="UK Shift") selected @endif  @endif>UK Shift</option>

                </select>

                <span class="help-block shifts-error" style="color:#a94442"></span>

            </div>

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">Are you willing to work on contract?<span

                        class="text-danger px-1">*</span></label>

                <select name="contract_type"

                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded edit2" >

                    <option selected disabled>Select One</option>

                    <option value="1" @if(isset($user->getprofileDetails()->contract_type)) @if($user->getprofileDetails()->contract_type=="1") selected @endif  @endif>Yes</option>

                <option value="2" @if(isset($user->getprofileDetails()->contract_type)) @if($user->getprofileDetails()->contract_type=="2") selected @endif  @endif>No</option>

                </select>
                <span class="help-block contract_type-error" style="color:#a94442"></span>

            </div>

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">Preferred Mode<span

                        class="text-danger px-1">*</span></label>

                <select name="work_option"

                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded edit2" >

                    <option selected disabled>Select One</option>

                    <option value="1" @if(isset($user->getprofileDetails()->candidate_wfh)) @if($user->getprofileDetails()->candidate_wfh=="1") selected @endif  @endif>Remote</option>

                    <option value="2" @if(isset($user->getprofileDetails()->candidate_wfh)) @if($user->getprofileDetails()->candidate_wfh=="2") selected @endif  @endif>Hybrid</option>

                    <option value="3" @if(isset($user->getprofileDetails()->candidate_wfh)) @if($user->getprofileDetails()->candidate_wfh=="3") selected @endif  @endif>Work From Office</option>

                    <option value="4" @if(isset($user->getprofileDetails()->candidate_wfh)) @if($user->getprofileDetails()->candidate_wfh=="4") selected @endif  @endif>Flexible</option>

                </select>
                <span class="help-block work_option-error" style="color:#a94442"></span>

            </div>

            <div class="col-12">

                <label class="mb-2 pt-3 sign_fontsize">Expecting job opportunities in<span

                        class="text-danger px-1">*</span></label>

                <input type="text" name="expecting_opportunities" class="w-100 signup_input rounded px-3 py-2 edit2" value="{{ old('expecting_opportunities', (isset($user->getprofileDetails()->expecting_opportunities))? $user->getprofileDetails()->expecting_opportunities:'') }}" >

                <span class="help-block expecting_opportunities-error" style="color:#a94442"></span>

            </div>

            <div class="col-12">

                <label class="mb-2 pt-3 sign_fontsize">Expected Pay/Month in case of Contractual

                    Opportunities<span class="text-danger px-1">*</span></label>

                <input type="number" name="expecting_payment" class="w-100 signup_input rounded px-3 py-2 edit2"  value="{{ old('expecting_payment', (isset($user->getprofileDetails()->expecting_payment))? $user->getprofileDetails()->expecting_payment:'') }}" >

                <span class="help-block expecting_payment-error" style="color:#a94442"></span>

            </div>

            <div class="col-lg-12 pt-4 mt-3 text-center">

                <input class="signin_button rounded px-3 py-1 new-cursor" value="Update" type="button" onclick="submitdetailsForm();" >
    

        </div>

    </form>

</div>

@push('scripts') 



 <script>



$("document").ready(function(){

    setTimeout(function(){

       $("div.alert").remove();

    }, 2000 ); // 5 secs



});



function submitdetailsForm() {
  //  alert('hello');
        var form = $('#update_details');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function (json) {
           // alert('success');
           $("#success_msg165").show(); 
           $(".new_error_class").hide(); 
                $("#success_msg165").html("<div class='alert alert-success'>{{__('Employment Preferences updated successfully')}}</div>");
                setTimeout(function() { $("#success_msg165").hide(); }, 5000);
            },
            error: function (json) {
                if (json.status === 422) {
                    var resJSON = json.responseJSON;
                    $('.help-block').html('');
                    $.each(resJSON.errors, function (key, value) {
                        $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');
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