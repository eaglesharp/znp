{!! APFrmErrHelp::showOnlyErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
   {{-- <div class="form-group {!! APFrmErrHelp::hasError($errors, 'plan') !!}"> {!! Form::label('plan', 'plan', ['class' => 'bold']) !!}                    
        {!! Form::select('plan', ['' => 'Select plan'], null, array('class'=>'form-control', 'id'=>'plan')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'plan') !!} </div> --}}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_title') !!}"> {!! Form::label('package_title', 'Package Title', ['class' => 'bold']) !!}
        {!! Form::text('package_title', null, array('class'=>'form-control', 'id'=>'package_title', 'placeholder'=>'Package Title')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_title') !!} </div>
        
        
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'cv_access') !!}"> {!! Form::label('cv_access', 'Cv Access', ['class' => 'bold']) !!}
            {!! Form::text('cv_access', null, array('class'=>'form-control', 'id'=>'cv_access', 'placeholder'=>'Cv Access')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'cv_access') !!} </div>
        
        
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_price') !!}"> {!! Form::label('package_price', 'Package Price', ['class' => 'bold']) !!}
        {!! Form::text('package_price', null, array('class'=>'form-control', 'id'=>'package_price', 'placeholder'=>'Package Price')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_price') !!} </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_num_days') !!}"> {!! Form::label('package_num_days', 'Package num days', ['class' => 'bold']) !!}
        {!! Form::text('package_num_days', null, array('class'=>'form-control', 'id'=>'package_num_days', 'placeholder'=>'Package num days')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_num_days') !!} </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_num_listings') !!}"> {!! Form::label('package_num_listings', 'Email Access', ['class' => 'bold']) !!}
        {!! Form::text('package_num_listings', null, array('class'=>'form-control', 'id'=>'package_num_listings', 'placeholder'=>'Email Access')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_num_listings') !!}
        
         </div>


         <div class="form-group {!! APFrmErrHelp::hasError($errors, 'verified_cv_access') !!}"> {!! Form::label('verified_cv_access', 'Verified Cv Access', ['class' => 'bold']) !!}
            {!! Form::text('verified_cv_access', null, array('class'=>'form-control', 'id'=>'verified_cv_access', 'placeholder'=>'Email Access')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'verified_cv_access') !!}
            
             </div>
             <div class="form-group {!! APFrmErrHelp::hasError($errors, 'normal_cv_access') !!}"> {!! Form::label('normal_cv_access', 'Normal Cv Access', ['class' => 'bold']) !!}
                {!! Form::text('normal_cv_access', null, array('class'=>'form-control', 'id'=>'normal_cv_access', 'placeholder'=>'Email Access')) !!}
                {!! APFrmErrHelp::showErrors($errors, 'normal_cv_access') !!}
                
                 </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_for') !!}" style="display: none;">
        {!! Form::label('package_for', 'Package for?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $package_for_1 = 'checked="checked"';
            $package_for_2 = '';
            $package_for_3 = '';
            if (old('package_for', ((isset($package)) ? $package->package_for : 'job_seeker')) == 'employer') {
                $package_for_1 = '';
                $package_for_2 = 'checked="checked"';
                $package_for_3 = '';
            }
            if (old('package_for', ((isset($package)) ? $package->package_for : 'cv_search')) == 'cv_search') {
                $package_for_1 = '';
                $package_for_2 = '';
                $package_for_3 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="job_seeker" name="package_for" type="radio" value="job_seeker" >
                Job Seeker </label>
            <label class="radio-inline">
                <input id="employer" name="package_for" type="radio" value="employer" checked>
                Employer </label>
            <label class="radio-inline">
                <input id="cv_search" name="package_for" type="radio" value="cv_search" >
                Cv Search </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'package_for') !!}
    </div>
    <div class="form-actions"> {!! Form::button('Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!} </div>
</div>