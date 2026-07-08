{!! APFrmErrHelp::showOnlyErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'logo') !!}">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"> <img src="{{ asset('/') }}admin_assets/no-image.png" alt="" /> </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                    <div> <span class="btn default btn-file"> <span class="fileinput-new"> Select Company logo </span> <span class="fileinput-exists"> Change </span> {!! Form::file('logo', null, array('id'=>'logo')) !!} </span> <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a> </div>
                </div>
                {!! APFrmErrHelp::showErrors($errors, 'logo') !!} </div>
        </div>
        @if(isset($company))
        <div class="col-md-6">
            {{ ImgUploader::print_image("company_logos/$company->logo") }}        
        </div>    
        @endif  
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'name') !!}"> {!! Form::label('name', 'Company Name', ['class' => 'bold']) !!}
        {!! Form::text('name', null, array('class'=>'form-control', 'id'=>'name', 'placeholder'=>'Company Name')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'name') !!}
     </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'email') !!}"> {!! Form::label('email', 'Offical Email', ['class' => 'bold']) !!}
        {!! Form::text('email', null, array('class'=>'form-control', 'id'=>'email', 'placeholder'=>'Offical Email')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'email') !!} 
    </div>
        @if(isset($company))
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'password') !!}"> {!! Form::label('password', 'Password', ['class' => 'bold']) !!}
        {!! Form::password('password', array('class'=>'form-control', 'id'=>'password', 'placeholder'=>'Password')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'password') !!}
     </div>
        @endif

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'phone') !!}"> {!! Form::label('phone', 'Mobile/Landline', ['class' => 'bold']) !!}
        {!! Form::text('phone', null, array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>'Mobile/Landline')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'phone') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'designation') !!}"> {!! Form::label('designation', 'Designation', ['class' => 'bold']) !!}
        {!! Form::text('designation', null, array('class'=>'form-control', 'id'=>'designation', 'placeholder'=>'Designation')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'designation') !!}
    </div>

       
            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'ceo') !!}"> {!! Form::label('ceo', 'Contact Person Name', ['class' => 'bold']) !!}
                {!! Form::text('ceo', null, array('class'=>'form-control', 'id'=>'ceo', 'placeholder'=>'Contact Person Name')) !!}
                {!! APFrmErrHelp::showErrors($errors, 'ceo') !!}
             </div>
                <br>

                <div class="form-group {!! APFrmErrHelp::hasError($errors, 'Company/Recruitment Firm') !!}">
                    {!! Form::label('is_featured', 'Company / Recruitment Firm', ['class' => 'bold']) !!}
                    <div class="radio-list">
                        <?php
                        $is_featured_1 = '';
                        $is_featured_2 = 'checked="checked"';
                        if (old('is_featured', ((isset($company)) ? $company->is_featured : 0)) == 1) {
                            $is_featured_1 = 'checked="checked"';
                            $is_featured_2 = '';
                        }
                        ?>
                        <label class="radio-inline">
                            <input id="featured" name="is_featured" type="radio" value="1" {{$is_featured_1}}>
                            Company </label>
                        <label class="radio-inline">
                            <input id="not_featured" name="is_featured" type="radio" value="0" {{$is_featured_2}}>
                            Recruitment Firm </label>
                    </div><br>



    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'company_package_id') !!}"> {!! Form::label('company_package_id', 'Package', ['class' => 'bold']) !!}  
        {!! Form::select('company_package_id', ['' => 'Select Package']+$packages, null, array('class'=>'form-control', 'id'=>'company_package_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'company_package_id') !!} </div>

    @if(isset($company) && $company->cvs_package_id > 0)
    
    <div class="form-group">
        {!! Form::label('package', 'Package : ', ['class' => 'bold']) !!}         
        <strong>{{$package_id->package_title}}</strong>
    </div>
    <div class="form-group">
        {!! Form::label('package_Duration', 'Package Duration : ', ['class' => 'bold']) !!}
        <strong>{!! date('d/M/y', strtotime($company->package_start_date)) !!}</strong> - <strong>{!! date('d/M/y', strtotime($company->package_end_date)) !!}</strong>
    
        {{-- <strong>{{$company->package_num_days}}</strong> --}}
    </div>
    <div class="form-group">
        {!! Form::label('package_quota', 'Availed quota : ', ['class' => 'bold']) !!}
        <strong>{{$company->availed_cvs_quota}}</strong> / <strong>{{$company->cvs_quota}}</strong>
    </div>
    
    <div class="form-group">
        {!! Form::label('package_quota', 'Email quota : ', ['class' => 'bold']) !!}
        <strong>{{$company->availed_email_quota}}</strong> / <strong>{{$company->email_quota}}</strong>
    </div>
    <hr/>
    @endif

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Is Active?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $is_active_1 = 'checked="checked"';
            $is_active_2 = '';
            if (old('is_active', ((isset($company)) ? $company->is_active : 1)) == 0) {
                $is_active_1 = '';
                $is_active_2 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="active" name="is_active" type="radio" value="1" {{$is_active_1}}>
                Active </label>
            <label class="radio-inline">
                <input id="not_active" name="is_active" type="radio" value="0" {{$is_active_2}}>
                In-Active </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_active') !!}
    </div>
    
    
    
    
    
    
    
  
    <div class="form-actions"> {!! Form::button('Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!} </div>
</div>
@push('scripts')
@include('admin.shared.tinyMCEFront') 
<script type="text/javascript">
    $(document).ready(function () {
        $('#country_id').on('change', function (e) {
            e.preventDefault();
            filterDefaultStates(0);
        });
        $(document).on('change', '#state_id', function (e) {
            e.preventDefault();
            filterDefaultCities(0);
        });
        filterDefaultStates(<?php echo old('state_id', (isset($company)) ? $company->state_id : 0); ?>);
    });
    function filterDefaultStates(state_id)
    {
        var country_id = $('#country_id').val();
        if (country_id != '') {
            $.post("{{ route('filter.default.states.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        $('#default_state_dd').html(response);
                        filterDefaultCities(<?php echo old('city_id', (isset($company)) ? $company->city_id : 0); ?>);
                    });
        }
    }
    function filterDefaultCities(city_id)
    {
        var state_id = $('#state_id').val();
        if (state_id != '') {
            $.post("{{ route('filter.default.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
        }
    }
</script>
@endpush