<form class="form" id="add_certificate" method="POST" action="{{ route('store.front.certificate', [$user->id]) }}">{{csrf_field()}}
    <div class="row">
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Certification Name<span
                    class="text-danger px-1">*</span></label>
            <input type="text"  name="certificate_name" class="w-100 signup_input rounded px-3 py-2" requried
                placeholder="Please Enter Your Certification Name"> 
                <span class="help-block certificate_name-error"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Certification Agency /
                School<span class="text-danger px-1">*</span></label>
            <input type="text" name="certificate_agency"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Please Mention Your Certification Agency/School">
                
                <span class="help-block certificate_agency-error"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <label class="mb-2 pt-3 sign_fontsize">Year of Certification<span
                    class="text-danger px-1">* </span></label> 
                    <?php
                    $date_completion = (isset($certificate) ? $certificate->year_of_passing : null);
                    ?>
                    {!! Form::select('year_of_passing', [''=>'Select Year']+MiscHelper::getEstablishedIn(), $date_completion, array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded', 'id'=>'year_of_passing_id')) !!}
                    <span class="help-block year_of_passing-error"></span>
           
        </div>
        <div class="col-lg-6">
            <label class="mb-2 pt-lg-3 sign_fontsize"><span
                    class="text-danger px-1"> </span></label>  
                    <?php
                    $date_completion = (isset($certificate) ? $certificate->month_of_passing : null);
                    ?>
                    {!! Form::select('month_of_passing', [''=>'Select Month']+MiscHelper::getmonths(), $date_completion, array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded', 'id'=>'month_of_passing_id')) !!}
                    <span class="help-block month_of_passing-error"></span>
                    
          
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label class="mb-2 pt-3 sign_fontsize">Duration<span
                    class="text-danger px-1">* </span></label>  
                    
                    <?php
                    $date_completion = (isset($certificate) ? $certificate->duration : null);
                    ?>
                    {!! Form::select('duration', [''=>'Select Duration']+MiscHelper::getduration(), $date_completion, array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded', 'id'=>'duration_id')) !!}
                    <span class="help-block duration-error"></span>
         
        </div>
    </div>
</form>