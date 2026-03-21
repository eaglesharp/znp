{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')

<form class="form" id="add_edit_profile_compensation" method="POST" action="{{ route('update.profile.compensation', [$user->id]) }}">{{ csrf_field() }}

    <div class="form-body">



        

    

    <label class="bold">Current Total CTC Per annum(Fixed + Variable + Bonus + Incentives + Benefits)</label><span class="text-danger px-1">*</span>

    <div class="row">

    

        <div class="form-group  col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_lakhs') !!}">

            <?php 

        

            $lakhs=(isset($user->getprofileDetails()->expect_ctc_lakhs) ? $user->getprofileDetails()->expect_ctc_lakhs:'');

            

            ?>

                 

            {!! Form::number('expect_ctc_lakhs', $lakhs, array('class'=>'form-control newtest', 'id'=>'expect_ctc_lakhs','placeholder'=>"Lakh" ,'min' =>"0",'max' =>"100",'onkeyup'=>'imposeMinMax(this)')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_lakhs') !!}

            <span class="help-block expect_ctc_lakhs-error" style="color:#a94442"></span>

        </div>

        



        <div class="form-group  col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_thousand') !!}">

            <?php 

        

            $thousand=(isset($user->getprofileDetails()->expect_ctc_thousand) ? $user->getprofileDetails()->expect_ctc_thousand:'');

            

            ?>

                 

            {!! Form::number('expect_ctc_thousand', $thousand, array('class'=>'form-control newtest', 'id'=>'expect_ctc_thousand','placeholder'=>"Thousand" ,'min' =>"0",'max' =>"99999",'onkeyup'=>'imposeMinMax(this)')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_thousand') !!}

            <span class="help-block expect_ctc_thousand-error" style="color:#a94442"></span>

        </div>

    </div>

    

    

    

    <label class="bold">Fixed CTC per annum</label><span class="text-danger px-1">*</span>

    <div class="row">

    

        <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_lakhs1') !!}">

            <?php 

        

            $lakhs=(isset($user->getprofileDetails()->expect_ctc_lakhs1) ? $user->getprofileDetails()->expect_ctc_lakhs1:'');

            

            ?>

                 

            {!! Form::number('expect_ctc_lakhs1', $lakhs, array('class'=>'form-control newtest', 'id'=>'expect_ctc_lakhs1','placeholder'=>"Lakh" ,'min' =>"0",'max' =>"100",'onkeyup'=>'imposeMinMax(this)')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_lakhs1') !!}

            <span class="help-block expect_ctc_lakhs1-error" style="color:#a94442"></span>

        </div>

        <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_thousand1') !!}">

        

            <?php 

        

            $thousand=(isset($user->getprofileDetails()->expect_ctc_thousand1) ? $user->getprofileDetails()->expect_ctc_thousand1:'');

            

            ?>

                 

            {!! Form::number('expect_ctc_thousand1',  $thousand, array('class'=>'form-control newtest', 'id'=>'expect_ctc_thousand1','placeholder'=>"Thousand" ,'min' =>"0",'max' =>"99999",'onkeyup'=>'imposeMinMax(this)')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_thousand1') !!}

            <span class="help-block expect_ctc_thousand1-error" style="color:#a94442"></span>

        </div>

    </div>

    

    

    <label class="bold">Variable CTC per annum(Incentives/Bonus)</label><span class="text-danger px-1">*</span>

    

    <div class="row">

    

       

        <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_lakhs2') !!}">

        <?php 

        

        $lakhs=(isset($user->getprofileDetails()->expect_ctc_lakhs2) ? $user->getprofileDetails()->expect_ctc_lakhs2:'');

        

        ?>

                 

            {!! Form::number('expect_ctc_lakhs2', $lakhs, array('class'=>'form-control newtest', 'id'=>'expect_ctc_lakhs2','placeholder'=>"Lakh" ,'min' =>"0",'max' =>"100",'onkeyup'=>'imposeMinMax(this)')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_lakhs2') !!}

            <span class="help-block expect_ctc_lakhs2-error" style="color:#a94442"></span> 

        </div>        

        

        

        <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_thousand2') !!}">

        

            <?php 

        

            $thousand=(isset($user->getprofileDetails()->expect_ctc_thousand2) ? $user->getprofileDetails()->expect_ctc_thousand2:'');

            

            ?>

                 

            {!! Form::number('expect_ctc_thousand2', $thousand, array('class'=>'form-control newtest', 'id'=>'expect_ctc_thousand2','placeholder'=>"Thousand" ,'min' =>"0",'max' =>"99999",'onkeyup'=>'imposeMinMax(this)')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_thousand2') !!}

            <span class="help-block expect_ctc_thousand2-error" style="color:#a94442"></span>

        </div>

    </div>

    

    

    <label class="bold">Expected CTC per annum</label><span class="text-danger px-1">*</span>

    <div class="row">

       

        <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_lakhs3') !!}">

            <?php 

        

            $lakhs=(isset($user->getprofileDetails()->expect_ctc_lakhs3) ? $user->getprofileDetails()->expect_ctc_lakhs3:'');

            

            ?>

                 

            {!! Form::number('expect_ctc_lakhs3',$lakhs, array('class'=>'form-control newtest', 'id'=>'expect_ctc_lakhs3','placeholder'=>"Lakh" ,'min' =>"0",'max' =>"100",'onkeyup'=>'imposeMinMax(this)')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_lakhs3') !!}

            <span class="help-block expect_ctc_lakhs3-error" style="color:#a94442"></span>

        </div>

        

      

        

            <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_thousand3') !!}">

                 

                 

                <?php 

        

                $thousand=(isset($user->getprofileDetails()->expect_ctc_thousand3) ? $user->getprofileDetails()->expect_ctc_thousand3:'');

                

                ?>

                {!! Form::number('expect_ctc_thousand3', $thousand, array('class'=>'form-control newtest', 'id'=>'expect_ctc_thousand3','placeholder'=>"Thousand" ,'min' =>"0",'max' =>"99999",'onkeyup'=>'imposeMinMax(this)')) !!}

                {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_thousand3') !!}

                <span class="help-block expect_ctc_thousand3-error" style="color:#a94442"></span>

            </div>

        

       

      

        </div>



        {{-- <div class="form-group" id="div_night_video_time_from">

            <label for="night_video_time_from" class="bold">Night Video Interview Time From</label>

            <input type="time" name="night_video_time_from" id="night_video_time_from" class="form-control" value="{{ old('night_video_time_from', (isset($user->getprofileDetails()->night_video_time_from))? $user->getprofileDetails()->night_video_time_from:'') }}">

            

            

            <span class="help-block night_video_time_from-error" style="color:#a94442"></span> 

        </div>



        <div class="form-group" id="div_night_video_time_to">

            <label for="night_video_time_to" class="bold">Night Video Interview Time To</label>

            <input type="time" name="night_video_time_to" id="night_video_time_to" class="form-control" value="{{ old('night_video_time_to', (isset($user->getprofileDetails()->night_video_time_to))? $user->getprofileDetails()->night_video_time_to:'') }}">

            

            

            <span class="help-block night_video_time_to-error"></span> 

        </div> --}}



        {{-- <div class="form-group" id="div_bgv_name1">

            <label for="bgv_name1" class="bold">Name 1</label>

            <input type="text" name="bgv_name1" id="bgv_name1" class="form-control" value="{{ old('bgv_name1', (isset($user->getprofileDetails()->bgv_name1))? $user->getprofileDetails()->bgv_name1:'') }}">

            

            

            <span class="help-block bgv_name1-error"></span> 

        </div>



        <div class="form-group" id="div_bgv_email1">

            <label for="bgv_email1" class="bold">Email 1</label>

            <input type="email" name="bgv_email1" id="bgv_email1" class="form-control" value="{{ old('bgv_email1', (isset($user->getprofileDetails()->bgv_email1))? $user->getprofileDetails()->bgv_email1:'') }}">

            

            

            <span class="help-block bgv_email1-error"></span> 

        </div>



        <div class="form-group" id="div_bgv_mobile1">

            <label for="bgv_mobile1" class="bold">Mobile 1</label>

            <input type="text" name="bgv_mobile1" id="bgv_mobile1" class="form-control" value="{{ old('bgv_mobile1', (isset($user->getprofileDetails()->bgv_mobile1))? $user->getprofileDetails()->bgv_mobile1:'') }}">

            

            

            <span class="help-block bgv_mobile1-error"></span> 

        </div>



        <div class="form-group" id="div_bgv_name2">

            <label for="bgv_name2" class="bold">Name 2</label>

            <input type="text" name="bgv_name2" id="bgv_name2" class="form-control" value="{{ old('bgv_name2', (isset($user->getprofileDetails()->bgv_name2))? $user->getprofileDetails()->bgv_name2:'') }}">

            

            

            <span class="help-block bgv_name2-error"></span> 

        </div>



        <div class="form-group" id="div_bgv_email2">

            <label for="bgv_email2" class="bold">Email 2</label>

            <input type="email" name="bgv_email2" id="bgv_email2" class="form-control" value="{{ old('bgv_email2', (isset($user->getprofileDetails()->bgv_email2))? $user->getprofileDetails()->bgv_email2:'') }}">

            

            

            <span class="help-block bgv_email2-error"></span> 

        </div>



        <div class="form-group" id="div_bgv_mobile2">

            <label for="bgv_mobile2" class="bold">Mobile 2</label>

            <input type="text" name="bgv_mobile2" id="bgv_mobile2" class="form-control" value="{{ old('bgv_mobile2', (isset($user->getprofileDetails()->bgv_mobile2))? $user->getprofileDetails()->bgv_mobile2:'') }}">

            

            

            <span class="help-block bgv_mobile2-error"></span> 

        </div>



        



        <div class="form-group" id="div_pricing_type">

            <label for="pricing_type" class="bold">Pricing Type</label>

            <select name="pricing_type" id="pricing_type" class="form-control">

                <option   value="1" @if(isset($user->getprofileDetails()->pricing_type)) @if($user->getprofileDetails()->pricing_type=="1") selected @endif  @endif>Week</option>

                <option  value="2" @if(isset($user->getprofileDetails()->pricing_type)) @if($user->getprofileDetails()->pricing_type=="2") selected @endif  @endif>Month</option>

            

            </select>

            

            <span class="help-block pricing_type-error"></span> 

        </div>



        <div class="form-group" id="div_pricing_details">

            <label for="pricing_details" class="bold">Pricing Details</label>

            <input type="text" name="pricing_details" id="pricing_details" class="form-control" value="{{ old('pricing_details', (isset($user->getprofileDetails()->pricing_details))? $user->getprofileDetails()->pricing_details:'') }}">

            

            

            <span class="help-block pricing_details-error"></span> 

        </div>



        <div class="form-group" id="div_visa_country">

            <label for="visa_country" class="bold">Visa Country</label>

            <input type="text" name="visa_country" id="visa_country" class="form-control" value="{{ old('visa_country', (isset($user->getprofileDetails()->visa_country))? $user->getprofileDetails()->visa_country:'') }}">

            

            

            <span class="help-block visa_country-error"></span> 

        </div>

        

        <div class="form-group" id="div_visa_validity">

            <label for="visa_validity" class="bold">Visa Country</label>

            <input type="date" name="visa_validity" id="visa_validity" class="form-control" value="{{ old('visa_validity', (isset($user->getprofileDetails()->visa_validity))? $user->getprofileDetails()->visa_validity:'') }}">

            

            

            <span class="help-block visa_validity-error"></span> 

        </div>



        <div class="form-group" id="div_wfo">

            <label for="wfo" class="bold">WFO</label>

            <select name="wfo" id="wfo" class="form-control">

                <option   value="1" @if(isset($user->getprofileDetails()->wfo)) @if($user->getprofileDetails()->wfo=="1") selected @endif  @endif>Week</option>

                <option  value="2" @if(isset($user->getprofileDetails()->wfo)) @if($user->getprofileDetails()->wfo=="2") selected @endif  @endif>Month</option>

            

            </select>

            

            <span class="help-block pricing_type-error"></span> 

        </div> --}}



        

    

        <button type="button" class="btn btn-large btn-primary" onClick="submitProfileCompensation();">Update Compensation   <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>

       

    </div>

    <div class="success" id="success_msg4"></div>

</form>

@push('scripts') 

<script type="text/javascript">

    function submitProfileCompensation() {

        var form = $('#add_edit_profile_compensation');

        $.ajax({

            url: form.attr('action'),

            type: form.attr('method'),

            data: form.serialize(),

            dataType: 'json',

            success: function (json) {
                $('.help-block').hide();

                $("#success_msg4").show();

$(".newtest").css("border-color","#ccc ");
                $("#success_msg4").html('<span class="text text-success">Compensation updated successfully</span>');

                setTimeout(function() { $("#success_msg4").hide(); }, 5000);
            },

            error: function (json) {

                if (json.status === 422) {

                    var resJSON = json.responseJSON;

                    $('.help-block').show();

                    $('.help-block').html('');

                    $.each(resJSON.errors, function (key, value) {

                        $('.' + key + '-error').html('<strong>' + value + '</strong>');

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

    

    function imposeMinMax(el){

    if(el.value != ""){

      if(parseInt(el.value) < parseInt(el.min)){

        el.value = el.min;

      }

      if(parseInt(el.value) > parseInt(el.max)){

        el.value = el.max;

      }

    }

  }



    

</script>

@endpush