{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')



<form class="form" id="add_current_edit_profile_jobcity" method="POST" action="{{ route('update.profile.jc', [$user->id]) }}">{{ csrf_field() }}

    <div class="form-body">

        



        <h4>Current Company</h4><br>

        <div class="row">

        

        <div class="form-group col-lg-6" id="div_current_company">

            <label for="current_company" class="bold">Current Company Name</label><span class="text-danger px-1">*</span>

            @php
            $datas = DB::table('company_data')->select('id','name')->distinct()->get();
            @endphp

            <select name="current_company" id="current_company" class="form-control newtest js-example-tags">
              @if ( (isset($user->getprofileJobCity()->current_company)) )
            
              @foreach ($datas as $c_data)
              <option value="{{ $c_data->id }}"
                @isset($user->getprofileJobCity()->current_company_id)                                    
               
                @if ($user->getprofileJobCity()->current_company_id == $c_data->id)
                   selected
                @endif

                @endisset
               >{{ $c_data->name }}</option>
              @endforeach  
            
              @else
             
              @foreach ($datas as $c_data)
              <option value="{{ $c_data->id }}">{{ $c_data->name }}</option>
              @endforeach   
             
              @endif
                                  
            
            </select>
            
            
            <span class="help-block current_company-error"></span> 

        </div>

        

        <div class="form-group col-lg-6" id="div_current_desigination">

            <label for="current_desigination" class="bold">Current Desigination</label><span class="text-danger px-1">*</span>

            <input type="text" name="current_desigination" placeholder="Current Desigination" id="current_desigination" class="form-control newtest" value="{{ old('current_desigination', (isset($user->getprofileJobCity()->current_desigination))? $user->getprofileJobCity()->current_desigination:'') }}">

            <span class="help-block current_desigination-error"></span> 

        </div>

    </div>

        

        <div class="row">

        

        <div class="form-group col-lg-6" id="div_current_start_date">

            <label for="start_date" class="bold">Start date</label><span class="text-danger px-1">*</span>

            <input type="text" name="current_start_date" id="start_date"  class="form-control newtest" placeholder="Starts date" value="{{ old('current_start_date', (isset($user->getprofileJobCity()->current_start_date))? $user->getprofileJobCity()->current_start_date:'') }}">

            <span class="help-block current_start_date-error"></span> 

        </div>

        <?php

        

      

        

        ?>

          

        <div class="form-group col-lg-6" id="datepicker">

            <label for="end_date" class="bold">Till date</label><span class="text-danger px-1">*</span>

            <input type="text" name="current_till_date" id="end_date" class="form-control datepickerr newtest" placeholder="Till date" value="{{ \Carbon\Carbon::parse($user->from_date)->format('m/Y')}}" disabled>

            <span class="help-block current_till_date-error"></span> 

        </div>

        

   





    </div>

    

    <div class="form-group" id="div_current_work_type">

        <label for="work_type" class="bold">Type of Employment</label><span class="text-danger px-1">*</span>

        <select name="current_work_type" id="work_type" class="form-control newtest">

          <option value="" selected disabled hidden>Select Type of Employment</option>

            <option   value="Contract" @if(isset($user->getprofileJobCity()->current_work_type)) @if($user->getprofileJobCity()->current_work_type=="Contract") selected @endif  @endif>Contract</option>

            <option  value="Permanent" @if(isset($user->getprofileJobCity()->current_work_type)) @if($user->getprofileJobCity()->current_work_type=="Permanent") selected @endif  @endif>Permanent</option>

            <option  value="Freelance" @if(isset($user->getprofileJobCity()->current_work_type)) @if($user->getprofileJobCity()->current_work_type=="Freelance") selected @endif  @endif>Freelance</option>

        </select>

        

        <span class="help-block current_work_type-error"></span> 

    </div>



    <div class="form-group" id="div_current_responsibilities">

        <label for="current_responsibilities" class="bold"> Responsibilities</label><span class="text-danger px-1">*</span>

        <input type="text" placeholder="Enter your Responsibilities" name="current_responsibilities" id="current_responsibilities" class="form-control newtest" value="{{ old('current_responsibilities', (isset($user->getprofileJobCity()->current_responsibilities))? $user->getprofileJobCity()->current_responsibilities:'') }}">

        <span class="help-block current_responsibilities-error"></span> 

    </div>

    

    <div class="form-group" id="div_current_project_details">

        <label for="project_details" class="bold"> Project Details</label><span class="text-danger px-1">*</span>

        <textarea name="current_project_details" class="form-control newtest" id="current_project_details" placeholder="Project Details">{{ old('current_project_details', (isset( $user->getprofileJobCity()->current_project_details))? $user->getprofileJobCity()->current_project_details :'') }}</textarea>

        <span class="help-block current_project_details-error"></span> 

    </div>

    

    <div class="form-group" id="div_current_reason">

        <label for="Change_job" class="bold"> Reason for Job Change</label><span class="text-danger px-1">*</span>

        <input type="text" placeholder=" Reason for Job Change"  name="current_reason" id="change_job" class="form-control newtest" value="{{ old('current_reason', (isset($user->getprofileJobCity()->current_reason))? $user->getprofileJobCity()->current_reason:'') }}">

        <span class="help-block current_reason-error"></span> 

    </div>

    

    <div class="row">

    

    <div class="form-group col-lg-6" id="div_current_ctc_start">

        <label for="current_ctc_date" class="bold"> CTC when you started in the organization</label><span class="text-danger px-1">*</span>

        <input type="number" placeholder="" min="0" max="1000000"  name="current_ctc_start" id="chancurrent_com_ctcge_job" class="form-control newtest" value="{{ old('current_ctc_start', (isset($user->getprofileJobCity()->current_ctc_start))? $user->getprofileJobCity()->current_ctc_start:'') }}">

        <span class="help-block current_ctc_start-error"></span> 

    </div>

    

    <div class="form-group col-lg-6" id="div_current_ctc_end">

        <label for="current_com_ctc" class="bold"> CTC when you moved out of the organization</label><span class="text-danger px-1">*</span>

        <input type="number" placeholder="" min="0" max="10000000"  name="current_ctc_end" id="chancurrent_com_ctcge_job" class="form-control newtest" value="{{ old('current_ctc_end', (isset($user->getprofileJobCity()->current_ctc_end))? $user->getprofileJobCity()->current_ctc_end:'') }}">

        <span class="help-block current_ctc_end-error"></span> 

    </div>



        <button type="button" style="
        margin-left: 15px;" class="btn btn-large btn-primary" onClick="submitcurrentProfilejobcity();">Update Company <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>

    <br>

</form>

        <div id="success_msg6" class="has-error"></div>

</div>

        <br>

        <form class="form" id="add_previous_edit_profile_jobcity" method="POST" action="{{ route('update.previous.profile.jc', [$user->id]) }}">{{ csrf_field() }}

<h4>Previous Company</h4><br>

     <div class="row">

            <div class="form-group col-lg-6" id="div_previous_company">

                <label for="previous_company" class="bold">Previous Company Name</label><span class="text-danger px-1">*</span>
                @php
                $datas = DB::table('company_data')->select('id','name')->distinct()->get();
                @endphp
    
                <select name="previous_company" id="previous_company" class="form-control newtest js-example-tags">
                  @if ( (isset($user->getprofileJobCity()->previous_company)) )
                
                  @foreach ($datas as $c_data)
                  <option value="{{ $c_data->id }}"
                    @isset($user->getprofileJobCity()->previous_company_id)                                    
                   
                    @if ($user->getprofileJobCity()->previous_company_id == $c_data->id)
                       selected
                    @endif
    
                    @endisset
                   >{{ $c_data->name }}</option>
                  @endforeach  
                
                  @else
                 
                  @foreach ($datas as $c_data)
                  <option value="{{ $c_data->id }}">{{ $c_data->name }}</option>
                  @endforeach   
                 
                  @endif
                                      
                
                </select>
                {{-- <input type="text" name="previous_company" placeholder="previous company" id="previous_company" class="form-control newtest" value="{{ old('previous_company', (isset($user->getprofileJobCity()->previous_company))? $user->getprofileJobCity()->previous_company:'') }}"> --}}

                <span class="help-block previous_company-error"></span> 

            </div>

            <div class="form-group col-lg-6" id="div_previous_desigination">

                <label for="previous_desigination" class="bold">Previous Desigination</label><span class="text-danger px-1">*</span>

                <input type="text" name="previous_desigination" placeholder="previous designation" id="previous_desigination" class="form-control newtest" value="{{ old('previous_desigination', (isset($user->getprofileJobCity()->previous_desigination))? $user->getprofileJobCity()->previous_desigination:'') }}">

                <span class="help-block previous_desigination-error"></span>

            </div>

        </div>



<div class="row">



        <div class="form-group col-lg-6" id="div_previous_start_date">

            <label for="start_date1" class="bold">Start date</label><span class="text-danger px-1">*</span>

            <input type="text" name="previous_start_date" id="previous_start_date" class="form-control datepickerr1 newtest" placeholder="Starts date" value="{{ old('previous_start_date', (isset($user->getprofileJobCity()->previous_start_date))? $user->getprofileJobCity()->previous_start_date:'') }}">

            <span class="help-block previous_start_date-error"></span> 

        </div>



        <div class="form-group col-lg-6" id="div_previous_till_date">

            <label for="end_date" class="bold">End date</label><span class="text-danger px-1">*</span>

            <input type="text" name="previous_till_date" id="previous_end_date" class="form-control datepickerr1 newtest" placeholder="End date" value="{{ old('previous_till_date', (isset($user->getprofileJobCity()->previous_till_date))? $user->getprofileJobCity()->previous_till_date:'') }}">

            <span class="help-block previous_till_date-error"></span> 

        </div>



</div>



<div class="form-group" id="div_previous_work_type">

            <label for="work_type" class="bold">Type of Employment</label><span class="text-danger px-1">*</span>

            <select name="previous_work_type" id="previous_work_type" class="form-control newtest">

                <option value="" selected disabled hidden>Select</option>

                <option   value="Contract" @if(isset($user->getprofileJobCity()->previous_work_type)) @if($user->getprofileJobCity()->previous_work_type=="Contract") selected @endif  @endif>Contract</option>

                <option  value="Permanent" @if(isset($user->getprofileJobCity()->previous_work_type)) @if($user->getprofileJobCity()->previous_work_type=="Permanent") selected @endif  @endif>Permanent</option>

                <option  value="Freelance" @if(isset($user->getprofileJobCity()->previous_work_type)) @if($user->getprofileJobCity()->previous_work_type=="Freelance") selected @endif  @endif>Freelance</option>

            </select>

            

            <span class="help-block previous_work_type-error"></span> 

</div>



<div class="form-group" id="div_previous_responsibilities">

            <label for="previous_responsibilities" class="bold"> Responsibilities</label><span class="text-danger px-1">*</span>

            <input type="text" placeholder="Responsibilities" name="previous_responsibilities" id="previous_responsibilities" class="form-control newtest" value="{{ old('previous_responsibilities', (isset($user->getprofileJobCity()->previous_responsibilities))? $user->getprofileJobCity()->previous_responsibilities:'') }}">

            <span class="help-block previous_responsibilities-error"></span> 

</div>



<div class="form-group" id="div_previous_project_details">

            <label for="project_details1" class="bold">No.of Projects handled in Case of IT Experience</label><span class="text-danger px-1">*</span>

            <input type="number" name="previous_project_details" min="0" max="10000000" class="form-control newtest" id="previous_project_details" placeholder="" value="{{ old('previous_project_details', (isset($user->getprofileJobCity()->previous_project_details))? $user->getprofileJobCity()->previous_project_details:'') }}">

            <span class="help-block previous_project_details-error"></span> 

</div>



<div class="form-group" id="div_previous_reason">

            <label for="Change_job" class="bold"> Reason for Job Change</label><span class="text-danger px-1">*</span>

            <input type="text" placeholder=" Reason for Job Change"  name="previous_reason" id="change_job1" class="form-control newtest" value="{{ old('previous_reason', (isset($user->getprofileJobCity()->previous_reason))? $user->getprofileJobCity()->previous_reason:'') }}">

            <span class="help-block previous_reason-error"></span> 

</div>



<div class="row">



        <div class="form-group col-lg-6" id="div_previous_ctc_start">

                    <label for="previous_ctc_start" class="bold"> CTC when you started in the organization</label><span class="text-danger px-1">*</span>

                    <input type="number" placeholder=""  min="0" max="1000000" name="previous_ctc_start" id="chancurrent_com_ctcge_job" class="form-control newtest" value="{{ old('previous_ctc_start', (isset($user->getprofileJobCity()->previous_ctc_start))? $user->getprofileJobCity()->previous_ctc_start:'') }}">

                    <span class="help-block previous_ctc_start-error"></span> 

        </div>



        <div class="form-group col-lg-6" id="div_previous_ctc_end">

                    <label for="previous_ctc_end" class="bold"> CTC when you moved out of the organization</label><span class="text-danger px-1">*</span>

                    <input type="number" placeholder="" min="0" max="10000000"  name="previous_ctc_end" id="previous_ctc_end" class="form-control newtest" value="{{ old('previous_ctc_end', (isset($user->getprofileJobCity()->previous_ctc_end))? $user->getprofileJobCity()->previous_ctc_end:'') }}">

                    <span class="help-block previous_ctc_end-error"></span> 

        </div>



</div>





    

        <button type="button" class="btn btn-large btn-primary" onClick="submitProfilejobcity();">Update Company <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>

    </div>

    <div id="success_msg61" class="has-error"></div>

</form>





@push('scripts')

<script>

    $(document).ready(function(){

      $(".datepickerr").datepicker({

        format: "mm-yyyy",

        startView: "months", 

        minViewMode: "months"

      });   

    })



    $(document).ready(function(){

      $(".datepickerr1").datepicker({

        format: "mm-yyyy",

        startView: "months", 

        minViewMode: "months"

      });   

    })

    

    

    </script>

<script type="text/javascript">









    function submitcurrentProfilejobcity() {

        var form = $('#add_current_edit_profile_jobcity');

        $.ajax({

            url: form.attr('action'),

            type: form.attr('method'),

            data: form.serialize(),

            dataType: 'json',

            success: function (json) {
                $(".help-block").hide(); 

$("input.form-control.newtest").css("border-color","#ccc ");

                $("#success_msg6").html('<span class="text text-success">Current Company updated successfully</span>');

                setTimeout(function() { $("#success_msg6").hide(); }, 5000);
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



    function submitProfilejobcity() {

        var form = $('#add_previous_edit_profile_jobcity');

        $.ajax({

            url: form.attr('action'),

            type: form.attr('method'),

            data: form.serialize(),

            dataType: 'json',

            success: function (json) {
                $(".help-block").hide(); 

                $("#success_msg61").show();

$("input.form-control.newtest").css("border-color","#ccc ");

                $("#success_msg61").html('<span class="text text-success">Previous Company updated successfully</span>');

                setTimeout(function() { $("#success_msg61").hide(); }, 5000);
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



    

    $(document).ready(function () {

$('#start_date').datepicker({

    autoclose: true,

    format: 'mm-yyyy',

    todayHighlight: true,

    startDate: '12/1950',

    startView: "months", 

        minViewMode: "months"

});

var startDate = new Date('12/1950');

var FromEndDate = new Date();

var ToEndDate = new Date();

ToEndDate.setDate(ToEndDate.getDate() + 365);



$('#start_date').datepicker({

    weekStart: 1,

    startDate: '09/2019',

    endDate: FromEndDate,

    autoclose: true

})

    .on('changeDate', function (selected) {

        startDate = new Date(selected.date.valueOf());

        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));

        $('#night_telephonic_date_to').datepicker('setStartDate', startDate);

    });

$('#night_telephonic_date_to')

    .datepicker({

        weekStart: 1,

        startDate: startDate,

        endDate: ToEndDate,

        format: 'mm-dd',

        autoclose: true

    })

    .on('changeDate', function (selected) {

        FromEndDate = new Date(selected.date.valueOf());

        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));

        $('#night_telephonic_date_from').datepicker('setEndDate', FromEndDate);

    });



}); 

    

    

    

$(document).ready(function () {

$('#previous_start_date').datepicker({

    autoclose: true,

    format: 'mm-yyyy',

    todayHighlight: true,

    startDate: '12/1950',

    startView: "months", 

        minViewMode: "months"

});

var startDate = new Date('12/1950');

var FromEndDate = new Date();

var ToEndDate = new Date();

ToEndDate.setDate(ToEndDate.getDate() + 365);



$('#previous_start_date').datepicker({

    weekStart: 1,

    startDate: '09/2019',

    endDate: FromEndDate,

    autoclose: true

})

    .on('changeDate', function (selected) {

        startDate = new Date(selected.date.valueOf());

        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));

        $('#previous_end_date').datepicker('setStartDate', startDate);

    });

$('#previous_end_date')

    .datepicker({

        weekStart: 1,

        startDate: startDate,

        endDate: ToEndDate,

        format: 'mm-yyyy',

        autoclose: true,

        startView: "months", 

        minViewMode: "months"

    })

    .on('changeDate', function (selected) {

        FromEndDate = new Date(selected.date.valueOf());

        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));

        $('#previous_start_date').datepicker('setEndDate', FromEndDate);

    });



}); 



$(".js-example-tags").select2({
                            tags: true
                          });
    

</script>

@endpush