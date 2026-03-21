{{-- {!! APFrmErrHelp::showErrorsNotice($errors) !!} --}}

@include('flash::message')

<style>
    .preferred-city .btn-group {
        max-width: 100%;
        display: grid;
    }
    .preferred-city .multiselect {
        text-align: left;
    }
    .preferred-city .multiselect-container {
        min-width: 100%;
    }
    </style>

@if(isset($user))

    <?php 

    $user_loc = unserialize($user->prefered_city);


    ?>

{!! Form::model($user, array('method' => 'put', 'route' => array('update.user', $user->id), 'class' => 'form', 'files'=>true,'enctype'=>'multipart/form-data')) !!}

{!! Form::hidden('id', $user->id) !!}

@else

{!! Form::open(array('method' => 'post', 'route' => 'store.user', 'class' => 'form', 'files'=>true)) !!}

@endif

<div class="form-body">    

    <input type="hidden" name="front_or_admin" value="admin" />

    <div class="row">

        <div class="col-md-6">

            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'image') !!}">

                <div class="fileinput fileinput-new" data-provides="fileinput">

                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"> <img src="{{ asset('/') }}admin_assets/no-image.png" alt="" /> </div>

                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>

                    <div> <span class="btn default btn-file"> <span class="fileinput-new"> Select Profile Image </span> <span class="fileinput-exists"> Change </span> {!! Form::file('image', null, array('id'=>'image')) !!} </span> <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a> </div>

                </div>

                {!! APFrmErrHelp::showErrors($errors, 'image') !!} </div>

        </div>

        @if(isset($user))

        <div class="col-md-6">

            {{ ImgUploader::print_image("user_images/$user->image") }}        

        </div>    

        @endif  

    </div>
<div class="row">
    <div class="col-md-6">

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'first_name') !!}">

    

        {!! Form::label('first_name', 'First Name ', ['class' => 'bold'])  !!} 

        <span class="text-danger px-1">*</span>

        {!! Form::text('first_name', null, array('class'=>'form-control', 'id'=>'first_name', 'placeholder'=>'First Name')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'first_name') !!}                                       

    </div>
    </div>
    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'middle_name') !!}">

        {!! Form::label('middle_name', 'Middle Name', ['class' => 'bold']) !!}    

      

        {!! Form::text('middle_name', null, array('class'=>'form-control', 'id'=>'middle_name', 'placeholder'=>'Middle Name')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'middle_name') !!}                                       

    </div>
    </div>
    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'last_name') !!}">

        {!! Form::label('last_name', 'Last Name', ['class' => 'bold']) !!} 

       

        {!! Form::text('last_name', null, array('class'=>'form-control', 'id'=>'last_name', 'placeholder'=>'Last Name')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'last_name') !!}                                       

    </div>
    </div>
    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'email') !!}">

        {!! Form::label('email', 'Email', ['class' => 'bold']) !!}  

        <span class="text-danger px-1">*</span>

        {!! Form::text('email', null, array('class'=>'form-control', 'id'=>'email', 'placeholder'=>'Email')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'email') !!}  

        @if(session()->has('emailerror'))

        <span class="help-block repoff-error" style="color:#a94442"> 

        {{ session()->get('emailerror') }}

        </span>
  
         @endif

    </div>
    </div>

    @if(isset($user))
    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'password') !!}">

        {!! Form::label('password', 'Password', ['class' => 'bold']) !!}  

        <!--<span class="text-danger px-1">*</span>-->

        {!! Form::password('password', array('class'=>'form-control', 'id'=>'password', 'placeholder'=>'Password')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'password') !!}                                       

    </div>
    </div>

    @endif
    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'current_city') !!}">

        {!! Form::label('current_city', 'Current City', ['class' => 'bold']) !!}  

        <span class="text-danger px-1">*</span>

        {!! Form::text('current_city', null, array('class'=>'form-control', 'id'=>'autocomplete6', 'placeholder'=>'Current City')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'current_city') !!}                                       

    </div>
    </div>


    <?php 


                    // Function to check if the value is serialized
        function is_serialized($data) {
        // If the data is not a string, return false
        if (!is_string($data)) {
            return false;
        }

            // Try to decode the serialized data without actually unserializing it
            $unserializedData = @unserialize($data);

            // If decoding is successful and the result is an array, return true
            return is_array($unserializedData);
        }

                
                  $prefered_city = $user->prefered_city;

            // Check if the data is serialized
            if (is_serialized($prefered_city)) {
                // The data is serialized
                try {
                    $locationresultSelected = unserialize($prefered_city);
                } catch (Exception $e) {
                    $locationresultSelected = '';
                }
            } else {
                // The data is not serialized
                $locationresultSelected = $prefered_city;
            }

                ?>


    <!-- <input class="field" id="locality"></input> -->
    <div class="col-md-6">
    <div class="form-group preferred-city {!! APFrmErrHelp::hasError($errors, 'prefered_city') !!}">

       

                    {!! Form::label('prefered_city', 'Prefered City', ['class' => 'bold']) !!}  

                    <br>

                    <select class="form-control select-box" name="prefered_city[]" multiple="multiple" placeholder="Please enter location" id="locationFilter41">                    
                    </select>
    
                    {!! APFrmErrHelp::showErrors($errors, 'prefered_city') !!}                                       

        
    </div>
</div>

    
    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'current_location') !!}">

        {!! Form::label('current_location', 'Current Location in city', ['class' => 'bold']) !!}

        <span class="text-danger px-1">*</span>

        <!-- <input class="form-control" type="text" id="address" /> -->

        {{-- <input id="autocomplete9" name="current_location"  placeholder="Enter Current Location in city" type="text" class="form-control" autocomplete="off" value="{{(isset($user->current_location) ? $user->current_location:'')}}"></input> --}}

         {!! Form::text('current_location', null, array('class'=>'form-control', 'id'=>'autocomplete9', 'placeholder'=>'Current Location in city')) !!} 

        {!! APFrmErrHelp::showErrors($errors, 'current_location') !!}                                       

    </div>
</div>


  


{{-- <input class=" form-control field" id="locality" name="current_location" style="display:none" value="{{(isset($user->current_location) ? $user->current_location:'')}}"> --}}


    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'prefered_location') !!}">

        {!! Form::label('preferred_location_city', 'Preferred Location in city', ['class' => 'bold']) !!}

        <span class="text-danger px-1">*</span>

        {!! Form::text('prefered_location', null, array('class'=>'form-control', 'id'=>'autocomplete2', 'placeholder'=>'Preferred Location in city')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'prefered_location') !!}                                       

    </div>
</div>

    
    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'physically_challenged') !!}">

        {!! Form::label('physically_challenged', 'Physically Challenged ', ['class' => 'bold','placeholder'=>'Select    ']) !!} 

        <span class="text-danger px-1">*</span>

        <?php 

        $hand=(isset($user->physically_challenged) ? $user->physically_challenged : '');

        ?>

        

        {!! Form::select('physically_challenged',[''=>'Select']+MiscHelper::gethand(),null,array('id'=>'physically_challenged','class'=>'form-control admin_physically'))    !!}

        {{-- <select name="physically_challenged" id="physically_challenged" class="form-control">

        <option selected>Select</option>

            <option   value="yes"  >Yes</option>

            <option  value="no" >No</option>

     

        </select> --}}

        {!! APFrmErrHelp::showErrors($errors, 'physically_challenged') !!}                                       

    </div>
</div>

    

    
    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'date_of_birth') !!}">

        {!! Form::label('date_of_birth', 'Date of Birth', ['class' => 'bold']) !!}    

        <span class="text-danger px-1">*</span>               

        {{-- {!! Form::text('date_of_birth', (isset($user->date_of_birth) ? $user->date_of_birth : null), array('class'=>'form-control datepickerr', 'id'=>'date_of_birth', 'placeholder'=>'Date of Birth', 'autocomplete'=>'off')) !!} --}}

        <input type="text" class="form-control datepickerr" requried name="date_of_birth" value="{{ old('date_of_birth', (isset($user->date_of_birth))? Carbon\Carbon::parse($user->date_of_birth)->format('d-m-Y'):'') }}" placeholder="Date of Birth">

        {!! APFrmErrHelp::showErrors($errors, 'date_of_birth') !!}                                       

    </div>
</div>
    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'gender_id') !!}">

        {!! Form::label('gender_id', 'Gender', ['class' => 'bold']) !!} 

        <span class="text-danger px-1">*</span>

        {!! Form::select('gender_id', [''=>'Select Gender']+$genders, null, array('class'=>'form-control admin_gender', 'id'=>'gender_id')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'gender_id') !!}                                       

    </div>
</div>
    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'marital_status_id') !!}">

        {!! Form::label('marital_status_id', 'Marital Status', ['class' => 'bold']) !!} 

        <span class="text-danger px-1">*</span>

        {!! Form::select('marital_status_id', [''=>'Select Marital Status']+$maritalStatuses, null, array('class'=>'form-control admin_marital', 'id'=>'marital_status_id')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'marital_status_id') !!}                                       

    </div>
</div>

    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'phone') !!}">

        {!! Form::label('phone', 'Phone', ['class' => 'bold']) !!}    

        <span class="text-danger px-1">*</span>

        {!! Form::number('phone', null, array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>'Phone')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'phone') !!}                                       

    </div>
</div>

          
        
           
   
    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'industry') !!}">

        {!! Form::label('industry_id', 'Industry', ['class' => 'bold']) !!}     

        <span class="text-danger px-1">*</span>

        {!! Form::select('industry', [''=>'Select Industry']+MiscHelper::getindustry(), null, array('class'=>'form-control admin_industry', 'id'=>'industry')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'industry') !!}                                       

    </div>
</div>

    <?php

        $test=(isset($user->industry));

    ?>

 



    
    <div class="col-md-6">
    <div class="hideit" id="hideit" @if(isset($user->industry))@if($user->industry !="2")style="display:none" @endif @endif>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'process') !!}">

        {!! Form::label('process', 'Type of Process', ['class' => 'bold']) !!}     

        <span class="text-danger px-1">*</span>

        {!! Form::select('process', [''=>'Select Process']+MiscHelper::getprocess(), null, array('class'=>'form-control', 'id'=>'process')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'process') !!}                                       

    </div>
</div>

    

</div>



    <div class="col-md-6" >
        <label for="resume" class="bold">CV File</label> <span class="text-danger px-1">*</span>
    <div class="form-group" id="div_resume" style="border-block: 1px;border: 1px solid #d1d1d1;padding: 6px;">

     

        <input name="resume" id="resume" type="file" value=""><br>

        @if($errors->has('resume'))

        <span class="error" style="color:#a94442">{{$errors->first('resume')}}</span>

        @endif

        <p >Upload resume will accept only .pdf and .docx, Size should be lesser than 2 MB.</p>

     

        @if(isset($user))

        @if((isset($user->showcvs()->resume) ? $user->showcvs()->resume :''))

    

        <div class="form-group " style="border 1px solid"><br>

            <?php 

        $file=(isset($user->showcvs()->resume) ? $user->showcvs()->resume :'');

        ?>

         <button class="btn ">{{ImgUploader::print_doc("cvs/$file", $file, $file)}} </button> <a href="{{url('admin/delete-resume',$user->id)}}" class="btn btn-danger">Delete</a>

       

        </div> 

        @endif

        @endif

        <span class="help-block resume-error"></span>

    </div>
    </div>

        

   

        {{--         

                <div class="form-group {!! APFrmErrHelp::hasError($errors, 'resume') !!}">

                {!! Form::label('resume', ' CV File', ['class' => 'bold']) !!}                    

                {!! Form::file('resume', null, array('class'=>'form-control', 'id'=>'resume')) !!}

                {!! APFrmErrHelp::showErrors($errors, 'resume') !!}                                       

            </div> --}}

        

    
     <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'street_address') !!}">

        {!! Form::label('street_address', ' Address', ['class' => 'bold']) !!}<span class="text-danger px-1">*</span>      

        

        {!! Form::textarea('street_address', null, array('class'=>'form-control', 'id'=>'street_address', 'placeholder'=>' Address')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'street_address') !!}                                       

    </div>
    </div>

    {{-- <div class="form-group {!! APFrmErrHelp::hasError($errors, 'linkedin') !!}"> {!! Form::label('linkedin', 'Linkedin', ['class' => 'bold']) !!}

        {!! Form::text('linkedin', null, array('class'=>'form-control', 'id'=>'linkedin', 'placeholder'=>'Linkedin')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'linkedin') !!} </div> --}}

    {{-- @if((bool)config('jobseeker.is_jobseeker_package_active'))

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'job_seeker_package_id') !!}"> {!! Form::label('job_seeker_package_id', 'Package', ['class' => 'bold']) !!}  

        {!! Form::select('job_seeker_package_id', ['' => 'Select Package']+$packages, null, array('class'=>'form-control', 'id'=>'job_seeker_package_id')) !!}

        {!! APFrmErrHelp::showErrors($errors, 'job_seeker_package_id') !!} </div>



    @if(isset($user) && $user->package_id > 0)

    <div class="form-group">

        {!! Form::label('package', 'Package : ', ['class' => 'bold']) !!}         

        <strong>{{$user->getPackage('package_title')}}</strong>

    </div>

    <div class="form-group">

        {!! Form::label('package_Duration', 'Package Duration : ', ['class' => 'bold']) !!}

        <strong>{{$user->package_start_date->format('d M, Y')}}</strong> - <strong>{{$user->package_end_date->format('d M, Y')}}</strong>

    </div>

    <div class="form-group">

        {!! Form::label('package_quota', 'Availed quota : ', ['class' => 'bold']) !!}

        <strong>{{$user->availed_jobs_quota}}</strong> / <strong>{{$user->jobs_quota}}</strong>

    </div>



    <hr/>

    @endif

    @endif --}}





    {{-- <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_immediate_available') !!}">

        {!! Form::label('is_immediate_available', 'Is Immediate available?', ['class' => 'bold']) !!}

        <div class="radio-list">

            <?php

            $is_immediate_available_1 = 'checked="checked"';

            $is_immediate_available_2 = '';

            if (old('is_immediate_available', ((isset($user)) ? $user->is_immediate_available : 1)) == 0) {

                $is_immediate_available_1 = '';

                $is_immediate_available_2 = 'checked="checked"';

            }

            ?>

            <label class="radio-inline">

                <input id="immediate_available" name="is_immediate_available" type="radio" value="1" {{$is_immediate_available_1}}>

                Immediate Available </label>

            <label class="radio-inline">

                <input id="not_immediate_available" name="is_immediate_available" type="radio" value="0" {{$is_immediate_available_2}}>

                Not Immediate available </label>

        </div>

        {!! APFrmErrHelp::showErrors($errors, 'is_immediate_available') !!}

    </div> --}}




    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">

        {!! Form::label('is_active', 'Active', ['class' => 'bold']) !!}

        <div class="radio-list">

            <?php

            $is_active_1 = 'checked="checked"';

            $is_active_2 = '';

            if (old('is_active', ((isset($user)) ? $user->is_active : 1)) == 0) {

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
    </div>
    <div class="col-md-6">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'verified') !!}">

        {!! Form::label('verified', 'Verified', ['class' => 'bold']) !!}

        <div class="radio-list">

            <?php

            $verified_1 = 'checked="checked"';

            $verified_2 = '';

            if (old('verified', ((isset($user)) ? $user->verified : 1)) == 0) {

                $verified_1 = '';

                $verified_2 = 'checked="checked"';

            }

            ?>

            <label class="radio-inline">

                <input id="verified" name="verified" type="radio" value="1" {{$verified_1}}>

                Verified </label>

            <label class="radio-inline">

                <input id="not_verified" name="verified" type="radio" value="0" {{$verified_2}}>

                Not Verified </label>

        </div>

        {!! APFrmErrHelp::showErrors($errors, 'verified') !!}

    </div> 
    </div>
</div>



    <div id="locationField" style="display:none">
    

<table id="address">
    <tr>
        <td class="label">Street address</td>
        <td class="slimField">
            <input class="field" id="street_number"></input>
        </td>
        <td class="wideField" colspan="2">
            <input class="field" id="route"></input>
        </td>
    </tr>
    <tr>
        <td class="label">City</td>
        <td class="wideField" colspan="3">
          
        </td>
    </tr>
    <tr>
        <td class="label">State</td>
        <td class="slimField">
            <input class="field" id="administrative_area_level_1"></input>
        </td>
        <td class="label">Zip code</td>
        <td class="wideField">
            <input class="field" id="postal_code"></input>
        </td>
    </tr>
    <tr>
        <td class="label">Country</td>
        <td class="wideField" colspan="3">
            <input class="field" id="country"></input>
        </td>
    </tr>
    <tr>
        <td class="label">Lat</td>
        <td class="slimField">
            <input type="text" class="field" id="latitude"></input>
        </td>
        <td class="label">Long</td>
        <td class="wideField">
            <input type="text" class="field" id="longitude"></input>
        </td>
    </tr>
</table>
</div>


<div id="locationField" style="display:none">
  

    <table id="address">
        <tr>
            <td class="label">Street address</td>
            <td class="slimField">
                <input class="field" id="street_number1"></input>
            </td>
            <td class="wideField" colspan="2">
                <input class="field" id="route1"></input>
            </td>
        </tr>
        <tr>
            <td class="label">City</td>
            <td class="wideField" colspan="3">
              
            </td>
        </tr>
        <tr>
            <td class="label">State</td>
            <td class="slimField">
                <input class="field" id="administrative_area_level_2"></input>
            </td>
            <td class="label">Zip code</td>
            <td class="wideField">
                <input class="field" id="postal_code1"></input>
            </td>
        </tr>
        <tr>
            <td class="label">Country</td>
            <td class="wideField" colspan="3">
                <input class="field" id="country1"></input>
            </td>
        </tr>
        <tr>
            <td class="label">Lat</td>
            <td class="slimField">
                <input type="text" class="field" id="latitude1"></input>
            </td>
            <td class="label">Long</td>
            <td class="wideField">
                <input type="text" class="field" id="longitude1"></input>
            </td>
        </tr>
    </table>
    </div>
    {!! Form::button('Update Personal Information <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!}   

</div>
 
{!! Form::close() !!}



@push('css')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet"/>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCejQVcKXrBxZGFj0EQpSHkLgOk_Lp6CRI"></script>


<style type="text/css">

    .datepicker>div {

        display: block;

    }

</style>

@endpush

@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

<script>

$('#locationFilter41').select2({ 
        tags: true, 
        tokenSeparators: [','],
        placeholder: "(Add Location)",
        minimumInputLength: 1, // Set the minimum input length to 2
        ajax: {
            url: "{{ url('autocomplete/search-location-job2') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term // Use the input value as the search query
                };
            },
            processResults: function (data) {
                // Transform the data into the format expected by Select2
                return {
                    results: $.map(data, function (skill) {
                        return {
                            id: skill.location,
                            text: skill.location
                        };
                    })
                };
            },
            cache: true

            
        }
    });

    @if(isset($locationresultSelected))
        // Set the selected values
        var selectedValues = {!! json_encode($locationresultSelected) !!};
        var select = $('#locationFilter41');
        console.log(selectedValues)
        for (var id in selectedValues) {
            console.log(selectedValues)
            var option = new Option(selectedValues[id], selectedValues[id], true, true);
            select.append(option).trigger('change');
        }
    @endif



    $(".admin_industry option:first").attr("disabled", "disabled");
    $(".admin_gender option:first").attr("disabled", "disabled");
    
    $(".admin_marital option:first").attr("disabled","disabled");
   
    $(".admin_physically option:first").attr("disabled","disabled");


    </script>



<script>

    $("document").ready(function(){

        setTimeout(function(){

           $("div.alert").remove();

        }, 2000 ); // 5 secs

    

    });

    </script>

<script type="text/javascript">

    $(document).ready(function () {

        initdatepicker();

        $('#salary_currency').typeahead({

            source: function (query, process) {

                return $.get("{{ route('typeahead.currency_codes') }}", {query: query}, function (data) {

                    console.log(data);

                    data = $.parseJSON(data);

                    return process(data);

                });

            }

        });



        $('#country_id').on('change', function (e) {

            e.preventDefault();

            filterDefaultStates(0);

        }); 

        $(document).on('change', '#state_id', function (e) {

            e.preventDefault();

            filterDefaultCities(0);

        });

           //multiselect Location
    $('.location-multi-select').multiselect({
        includeSelectAllOption: true,
       selectAllText: 'Any Location',
        enableFiltering: false,
        enableClickableOptGroups: true,
        enableCollapsibleOptGroups: true,
        nonSelectedText: 'Choose by Location',
        numberDisplayed: 2,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Enter Location',
    });

       

    });




    function initdatepicker() {

        $(".datepicker").datepicker({

            autoclose: true,

            format: 'yyyy-m-d'

        });

    }

    

    $("#industry").change(function(){

 

    if(this.value==2)

    {

     

   $("#hideit").show();

    }else{

    $("#hideit").hide();

    }

    });

    

//     $("#industry").change(function(){

//  if(this.value==2){ $('#yesnohide').show();} else{ $('#yesnohide').hide(); }



// });

$(".datepickerr").datepicker({

autoclose: true,
startDate: '01/01/1950  ',

        format: 'dd-mm-yyyy'

});  





var searchInput = 'search_input';



$(document).ready(function () {

var autocomplete;

autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

types: ['geocode'],

componentRestrictions: {

country: "IN"

}

});



google.maps.event.addListener(autocomplete, 'place_changed', function () {

var near_place = autocomplete.getPlace();

});

});

</script>
    <script>
        var searchInput = 'autocomplete2';


var autocomplete;

autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

types: ['geocode'],

componentRestrictions: {

country: "IN"

}

});



google.maps.event.addListener(autocomplete, 'place_changed', function () {

var near_place = autocomplete.getPlace();
var location =  $("#autocomplete2").val();
        location = location.split(',')[0];
        $('#autocomplete2').val(location);

});


var searchInput = 'autocomplete7';


var autocomplete;

autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

types: ['geocode'],

componentRestrictions: {

country: "IN"

}

});



google.maps.event.addListener(autocomplete, 'place_changed', function () {

var near_place = autocomplete.getPlace();
var location =  $("#autocomplete7").val();
        location = location.split(',')[0];
        $('#autocomplete7').val(location);

});

var searchInput = 'autocomplete9';


var autocomplete;

autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

types: ['geocode'],

componentRestrictions: {

country: "IN"

}

});



google.maps.event.addListener(autocomplete, 'place_changed', function () {

var near_place = autocomplete.getPlace();
var location =  $("#autocomplete9").val();
        location = location.split(',')[0];
        $('#autocomplete9').val(location);

});

 var searchInput = 'autocomplete6';

$(document).ready(function () {

var autocomplete;

autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

types: ['geocode'],

componentRestrictions: {

country: "IN"

}

});



google.maps.event.addListener(autocomplete, 'place_changed', function () {

var near_place = autocomplete.getPlace();
var location =  $("#autocomplete6").val();
        location = location.split(',')[0];
        $('#autocomplete6').val(location);

});

});



</script>

<script>


    // Prepare location info object.
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

$("#autocomplete5").on('focus', function () {
   
    geolocate();
});

var placeSearch, autocomplete5;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};

function initialize() {
    // Create the autocomplete object, restricting the search
    // to geographical location types.
    autocomplete = new google.maps.places.Autocomplete(
    /** @type {HTMLInputElement} */ (document.getElementById('autocomplete5')), {
        types: ['geocode'],
        componentRestrictions: {

country: "IN"

}
        
    });
    // When the user selects an address from the dropdown,
    // populate the address fields in the form.
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        fillInAddress();
        var location =  $("#autocomplete5").val();
        location = location.split(',')[0];
        $('#autocomplete5').val(location);
    });
}

// [START region_fillform]
function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    document.getElementById("latitude").value = place.geometry.location.lat();
    document.getElementById("longitude").value = place.geometry.location.lng();

    for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
        }
    }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = new google.maps.LatLng(
            position.coords.latitude, position.coords.longitude);

            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;

            autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));
        });
    }

}

initialize();
// [END region_geolocation]
</script>


<script>



</script>

<script>



</script>

@endpush