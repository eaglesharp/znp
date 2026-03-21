{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')

<form class="form" id="add_edit_profile_details" method="POST" action="{{ route('update.profile.details', [$user->id]) }}">{{ csrf_field() }}

    <div class="form-body">

        <h4 style="margin-left:14px">Employment Preferences</h4><br>

      

        <div class="form-group col-lg-6" id="div_shifts">

        

            <label for="shifts" class="bold">Preferred Work Shift </label><span class="text-danger px-1">*</span>

            <select name="shifts" id="shifts" class="form-control newtest">

                <option value="" selected disabled hidden>Select</option>

                <option   value="Indian Shift" @if(isset($user->getprofileDetails()->shifts)) @if($user->getprofileDetails()->shifts=="Indian Shift") selected @endif  @endif>Indian Shift</option>

                <option  value="Rotational" @if(isset($user->getprofileDetails()->shifts)) @if($user->getprofileDetails()->shifts=="Rotational") selected @endif  @endif>Rotational</option>

                <option  value="US Shift" @if(isset($user->getprofileDetails()->shifts)) @if($user->getprofileDetails()->shifts=="US Shift") selected @endif  @endif>US Shift</option>

                <option  value="UK Shift" @if(isset($user->getprofileDetails()->shifts)) @if($user->getprofileDetails()->shifts=="UK Shift") selected @endif  @endif>UK Shift</option>

            </select>

            

            <span class="help-block shifts-error"></span> 

        </div>

        <div class="form-group col-lg-6" id="div_work_type">

            <label for="work_type" class="bold">Preferred Work Type</label><span class="text-danger px-1">*</span>

            <select name="work_type" id="work_type" class="form-control newtest">

                <option value="" selected disabled hidden>Select</option>

                <option   value="Contract" @if(isset($user->getprofileDetails()->work_type)) @if($user->getprofileDetails()->work_type=="Contract") selected @endif  @endif>Contract</option>

                <option  value="Permanent" @if(isset($user->getprofileDetails()->work_type)) @if($user->getprofileDetails()->work_type=="Permanent") selected @endif  @endif>Permanent</option>

                <option  value="Freelance" @if(isset($user->getprofileDetails()->work_type)) @if($user->getprofileDetails()->work_type=="Freelance") selected @endif  @endif>Freelance</option>

                <option  value="Any" @if(isset($user->getprofileDetails()->work_type)) @if($user->getprofileDetails()->work_type=="Any") selected @endif  @endif>Any</option>

            </select>

            

            <span class="help-block work_type-error"></span> 

        </div>

        <div class="form-group col-lg-6" id="div_contract_type">

            <label for="contract_type" class="bold">Are you willing to work on contract?</label><span class="text-danger px-1">*</span>

            <select name="contract_type" id="contract_type" class="form-control newtest">

                <option value="" selected disabled hidden>Select</option>

                <option value="1" @if(isset($user->getprofileDetails()->contract_type)) @if($user->getprofileDetails()->contract_type=="1") selected @endif  @endif>Yes</option>

                <option value="2" @if(isset($user->getprofileDetails()->contract_type)) @if($user->getprofileDetails()->contract_type=="2") selected @endif  @endif>No</option>

            

            </select>

            

            <span class="help-block contract_type-error"></span> 

        </div>

        

        

        

        <div class="form-group col-lg-6" id="div_work_option">

            <label for="work_option" class="bold">Preferred Mode</label><span class="text-danger px-1">*</span>

            <select name="work_option" id="work_option" class="form-control newtest">

                <option value="" selected disabled hidden>Select</option>

                <option value="1" @if(isset($user->getprofileDetails()->work_option)) @if($user->getprofileDetails()->work_option=="1") selected @endif  @endif>Remote</option>

                <option value="2" @if(isset($user->getprofileDetails()->work_option)) @if($user->getprofileDetails()->work_option=="2") selected @endif  @endif>Hybrid</option>

                <option value="3" @if(isset($user->getprofileDetails()->work_option)) @if($user->getprofileDetails()->work_option=="3") selected @endif  @endif>Work From Office</option>

                <option value="4" @if(isset($user->getprofileDetails()->work_option)) @if($user->getprofileDetails()->work_option=="4") selected @endif  @endif>Flexible</option>

            

            </select>

            

            <span class="help-block work_option-error"></span> 

        </div>

                

        

        

        

        

        

      

        

        

        <div class="form-group col-lg-6" id="div_expecting_opportunities">

            <label for="expecting_opportunities" class="bold">Expecting job opportunities in</label><span class="text-danger px-1">*</span>

            <input type="text" name="expecting_opportunities" id="expecting_opportunities" class="form-control newtest" value="{{ old('expecting_opportunities', (isset($user->getprofileDetails()->expecting_opportunities))? $user->getprofileDetails()->expecting_opportunities:'') }}">

            

            

            <span class="help-block expecting_opportunities-error"></span> 

        </div>

        

            

        <div class="form-group col-lg-6" id="div_expecting_payment">

            <label for="expecting_payment" class="bold">Expected Pay/Month in case of Contractual Opportunities</label><span class="text-danger px-1">*</span>

            <input type="number" name="expecting_payment" min="0" max="100000" id="expecting_payment" class="form-control newtest" value="{{ old('expecting_payment', (isset($user->getprofileDetails()->expecting_payment))? $user->getprofileDetails()->expecting_payment:'') }}">

            <span class="help-block expecting_payment-error"></span> 

        </div>

        

        

        

        

        

        {{-- <div class="form-group col-lg-6" id="div_duration_contract">

            <label for="duration_contract" class="bold">Duration of Contract</label>

            <input type="text" name="duration_contract" id="duration_contract" class="form-control" value="{{ old('duration_contract', (isset($user->getprofileDetails()->duration_contract))? $user->getprofileDetails()->duration_contract:'') }}">

            

            

            <span class="help-block duration_contract-error"></span> 

        </div>

        <div class="form-group col-lg-6" id="div_contract_company">

            <label for="contract_company" class="bold">Company  Contract</label>

            <input type="text" name="contract_company" id="contract_company" class="form-control" value="{{ old('contract_company', (isset($user->getprofileDetails()->contract_company))? $user->getprofileDetails()->contract_company:'') }}">

            

            

            <span class="help-block contract_company-error"></span> 

        </div>

        <div class="form-group col-lg-6" id="div_pay_contract">

            <label for="pay_contract" class="bold">Pay Contract</label>

            <input type="text" name="pay_contract" id="pay_contract" class="form-control" value="{{ old('pay_contract', (isset($user->getprofileDetails()->pay_contract))? $user->getprofileDetails()->pay_contract:'') }}">

            

            

            <span class="help-block pay_contract-error"></span> 

        </div> --}}



        



        {{-- <div class="form-group col-lg-6" id="div_candidate_wfh">

            <label for="candidate_wfh" class="bold">Can the candidate WFH</label>

            <select name="candidate_wfh" id="candidate_wfh" class="form-control">

                <option value="1" @if(isset($user->getprofileDetails()->candidate_wfh)) @if($user->getprofileDetails()->candidate_wfh=="1") selected @endif  @endif>Yes</option>

                <option value="2" @if(isset($user->getprofileDetails()->candidate_wfh)) @if($user->getprofileDetails()->candidate_wfh=="2") selected @endif  @endif>No</option>

            

            </select>

            

            <span class="help-block last_working_day-error"></span> 

        </div> --}}

        {{-- <h4>Interview Availability</h4><br>



        <div class="form-group col-lg-6 " id="div_video_date_from">

            <label for="video_date_from" class="bold"> Video Interview Date From</label>

            <input type="date" name="video_date_from" id="video_date_from" class="form-control" value="{{ old('video_date_from', (isset($user->getprofileDetails()->video_date_from))? $user->getprofileDetails()->video_date_from:'') }}">

            

            

            <span class="help-block telephonic_date_from-error"></span> 

        </div>



        <div class="form-group col-lg-6" id="div_telephonic_date_from">

            <label for="video_date_to" class="bold"> Video Interview Date To</label>

            <input type="date" name="video_date_to" id="video_date_to" class="form-control" value="{{ old('video_date_to', (isset($user->getprofileDetails()->video_date_to))? $user->getprofileDetails()->video_date_to:'') }}">

            

            

            <span class="help-block telephonic_date_from-error"></span> 

        </div> --}}

        {{-- <div class="form-group col-lg-6" id="div_telephonic_time_from">

            <label for="telephonic_time_from" class="bold">Telephonic Interview Time From</label>

            <input type="time" name="telephonic_time_from" id="telephonic_time_from" class="form-control" value="{{ old('telephonic_time_from', (isset($user->getprofileDetails()->telephonic_time_from))? $user->getprofileDetails()->telephonic_time_from:'') }}">

            

            

            <span class="help-block telephonic_time_from-error"></span> 

        </div>



        <div class="form-group col-lg-6" id="div_telephonic_time_to">

            <label for="telephonic_time_to" class="bold">Telephonic Interview Time To</label>

            <input type="time" name="telephonic_time_to" id="telephonic_time_to" class="form-control" value="{{ old('telephonic_time_to', (isset($user->getprofileDetails()->telephonic_time_to))? $user->getprofileDetails()->telephonic_time_to:'') }}">

            

            

            <span class="help-block telephonic_time_to-error"></span> 

        </div> --}}



        {{-- <div class="form-group col-lg-12" id="div_video_time_from">

            <label for="video_time" class="bold">Video Interview Time </label>

            <input type="time" name="video_time" id="video_time" class="form-control" value="{{ old('video_time', (isset($user->getprofileDetails()->video_time))? $user->getprofileDetails()->video_time:'') }}">

            

            

            <span class="help-block video_time_from-error"></span> 

        </div> --}}



        {{-- <div class="form-group " id="div_video_time_to">

            <label for="video_time_to" class="bold">Video Interview Time To</label>

            <input type="time" name="video_time_to" id="video_time_to" class="form-control" value="{{ old('video_time_to', (isset($user->getprofileDetails()->video_time_to))? $user->getprofileDetails()->video_time_to:'') }}">

            

            

            <span class="help-block video_time_to-error"></span> 

        </div> --}}

{{-- 

        <div class="form-group col-lg-6" id="div_night_interview">

            <label for="night_interview" class="bold">Night Interview</label>

            <select name="night_interview" id="night_interview" class="form-control">

                <option value="1" @if(isset($user->getprofileDetails()->night_interview)) @if($user->getprofileDetails()->night_interview=="1") selected @endif  @endif>Yes</option>

                <option value="2" @if(isset($user->getprofileDetails()->night_interview)) @if($user->getprofileDetails()->night_interview=="2") selected @endif  @endif>No</option>

            

            </select>

            

            <span class="help-block night_interview-error"></span> 

        </div> --}}



        {{-- <div class="form-group col-lg-6 " id="div_night_telephonic_date_from">

            <label for="night_telephonic_date_from" class="bold">Night  Interview Date From</label>

            <input type="date" name="night_telephonic_date_from" id="night_telephonic_date_from" class="form-control" value="{{ old('night_telephonic_date_from', (isset($user->getprofileDetails()->night_telephonic_date_from))? $user->getprofileDetails()->night_telephonic_date_from:'') }}">

            

            

            <span class="help-block night_telephonic_date_from-error"></span> 

        </div>



        <div class="form-group col-lg-6" id="div_night_telephonic_date_from">

            <label for="night_telephonic_date_to" class="bold">Night  Interview Date To</label>

            <input type="date" name="night_telephonic_date_to" id="night_telephonic_date_to" class="form-control" value="{{ old('night_telephonic_date_to', (isset($user->getprofileDetails()->night_telephonic_date_to))? $user->getprofileDetails()->night_telephonic_date_to:'') }}">

            

            

            <span class="help-block night_telephonic_date_from-error"></span> 

        </div>

        <div class="form-group col-lg-12" id="div_night_telephonic_time_from">

            <label for="night_time" class="bold">Night  Interview Time</label>

            <input type="time" name="night_time" id="night_time" class="form-control" value="{{ old('night_telephonic_time', (isset($user->getprofileDetails()->night_time))? $user->getprofileDetails()->night_time:'') }}">

            

            

            <span class="help-block night_telephonic_time_from-error"></span> 

        </div> --}}



        {{-- <div class="form-group " id="div_night_telephonic_time_to">

            <label for="night_telephonic_time_to" class="bold">Night  Interview Time To</label>

            <input type="time" name="night_telephonic_time_to" id="night_telephonic_time_to" class="form-control" value="{{ old('night_telephonic_time_to', (isset($user->getprofileDetails()->night_telephonic_time_to))? $user->getprofileDetails()->night_telephonic_time_to:'') }}">

            

            

            <span class="help-block night_telephonic_time_to-error"></span> 

        </div>

         --}}

         {{-- @include('admin.user.forms.experience.compensation') --}}

        

    {{-- <h4>Compensation</h4>

    <label class="bold">Current Total CTC Per annum(Fixed + Variable + Bonus + Incentives + Benefits)</label>

    <div class="row">

    

        <div class="form-group  col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_lakhs') !!}">

            <?php 

        

            $lakhs=(isset($user->getprofileDetails()->expect_ctc_lakhs) ? $user->getprofileDetails()->expect_ctc_lakhs:'');

            

            ?>

                 

            {!! Form::select('expect_ctc_lakhs', ['' => 'Select ']+MiscHelper::getlakhs(), $lakhs, array('class'=>'form-control', 'id'=>'expect_ctc_lakhs')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_lakhs') !!}

            

        </div>

        <div class="form-group  col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_thousand') !!}">

            <?php 

        

            $thousand=(isset($user->getprofileDetails()->expect_ctc_thousand) ? $user->getprofileDetails()->expect_ctc_thousand:'');

            

            ?>

                 

            {!! Form::select('expect_ctc_thousand', ['' => 'Select']+MiscHelper::getthousand(), $thousand, array('class'=>'form-control', 'id'=>'expect_ctc_thousand')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_thousand') !!}

            

        </div>

    </div>

    

    

    

    <label class="bold">Fixed CTC per annum</label>

    <div class="row">

    

        <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_lakhs1') !!}">

            <?php 

        

            $lakhs=(isset($user->getprofileDetails()->expect_ctc_lakhs1) ? $user->getprofileDetails()->expect_ctc_lakhs1:'');

            

            ?>

                 

            {!! Form::select('expect_ctc_lakhs1', ['' => 'Select ']+MiscHelper::getlakhs(), $lakhs, array('class'=>'form-control', 'id'=>'expect_ctc_lakhs1')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_lakhs1') !!}

            

        </div>

        <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_thousand1') !!}">

        

            <?php 

        

            $thousand=(isset($user->getprofileDetails()->expect_ctc_thousand1) ? $user->getprofileDetails()->expect_ctc_thousand1:'');

            

            ?>

                 

            {!! Form::select('expect_ctc_thousand1', ['' => 'Select']+MiscHelper::getthousand(), $thousand, array('class'=>'form-control', 'id'=>'expect_ctc_thousand1')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_thousand1') !!}

            

        </div>

    </div>

    

    

    <label class="bold">Variable CTC per annum(Incentives/Bonus)</label>

    

    <div class="row">

    

       

        <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_lakhs2') !!}">

        <?php 

        

        $lakhs=(isset($user->getprofileDetails()->expect_ctc_lakhs2) ? $user->getprofileDetails()->expect_ctc_lakhs2:'');

        

        ?>

                 

            {!! Form::select('expect_ctc_lakhs2', ['' => 'Select ']+MiscHelper::getlakhs(), $lakhs, array('class'=>'form-control', 'id'=>'expect_ctc_lakhs2')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_lakhs2') !!}

            

        </div>        

        

        

        <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_thousand2') !!}">

        

            <?php 

        

            $thousand=(isset($user->getprofileDetails()->expect_ctc_thousand2) ? $user->getprofileDetails()->expect_ctc_thousand2:'');

            

            ?>

                 

            {!! Form::select('expect_ctc_thousand2', ['' => 'Select']+MiscHelper::getthousand(), $thousand, array('class'=>'form-control', 'id'=>'expect_ctc_thousand2')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_thousand2') !!}

            

        </div>

    </div>

    

    

    <label class="bold">Expected CTC per annum</label>

    <div class="row">

       

        <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_lakhs3') !!}">

            <?php 

        

            $lakhs=(isset($user->getprofileDetails()->expect_ctc_lakhs3) ? $user->getprofileDetails()->expect_ctc_lakhs3:'');

            

            ?>

                 

            {!! Form::select('expect_ctc_lakhs3', ['' => 'Select ']+MiscHelper::getlakhs(), $lakhs, array('class'=>'form-control', 'id'=>'expect_ctc_lakhs3')) !!}

            {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_lakhs3') !!}

            

        </div>

        

            <div class="form-group col-lg-6 {!! APFrmErrHelp::hasError($errors, 'expect_ctc_thousand3') !!}">

                 

                 

                <?php 

        

                $thousand=(isset($user->getprofileDetails()->expect_ctc_thousand3) ? $user->getprofileDetails()->expect_ctc_thousand3:'');

                

                ?>

                {!! Form::select('expect_ctc_thousand3', ['' => 'Select']+MiscHelper::getthousand(), $thousand, array('class'=>'form-control', 'id'=>'expect_ctc_thousand3')) !!}

                {!! APFrmErrHelp::showErrors($errors, 'expect_ctc_thousand3') !!}

                

            </div>

        

       

      

        </div> --}}



        {{-- <div class="form-group" id="div_night_video_time_from">

            <label for="night_video_time_from" class="bold">Night Video Interview Time From</label>

            <input type="time" name="night_video_time_from" id="night_video_time_from" class="form-control" value="{{ old('night_video_time_from', (isset($user->getprofileDetails()->night_video_time_from))? $user->getprofileDetails()->night_video_time_from:'') }}">

            

            

            <span class="help-block night_video_time_from-error"></span> 

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



        

    

       

    </div>
   

    <div id="success_msg7" class="has-error"></div>

</form>
<button type="button" class="btn btn-large btn-primary " style="margin-left:14px;margin-top: 14px;" onClick="submitProfileDetails();">Update Preference <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>

@push('scripts') 

<script type="text/javascript">

    function submitProfileDetails() {

        var form = $('#add_edit_profile_details');

        $.ajax({

            url: form.attr('action'),

            type: form.attr('method'),

            data: form.serialize(),

            dataType: 'json',

            success: function (json) {
                $(".help-block").hide(); 

                $(".newtest").css("border-color","#ccc ");

                $("#success_msg7").html('<span class="text text-success">Employment Preferences updated successfully</span>');

                setTimeout(function() { $("#success_msg7").hide(); }, 5000);
            },

            error: function (json) {

                if (json.status === 422) {

                    var resJSON = json.responseJSON;

                    $(".help-block").show(); 

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

</script>

@endpush