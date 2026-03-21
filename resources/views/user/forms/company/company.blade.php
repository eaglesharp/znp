<div class="pt-3">



<?php 



$companies = \App\ProfileCityJobsCity::where('user_id',$user->id)->get();



foreach ($companies as $key => $value) {

  // echo $value;

}







?>



@foreach ($companies as $company)

@if($company->current_desigination)



    <h6 class="sign_head">{{$company->current_company}}<a href="javascript:void(0)"><i class="fa fa-pencil pl-2"

                aria-hidden="true" onclick="showcurrentcompanyEditModal({{$company->id}});"></i></a></h6>

    <p class="my-0 sign_fontsize"><span>Current Designation : </span>{{$company->current_desigination}}</p>

    <p class="my-0 sign_fontsize"><span>Start date : </span>{{$company->current_start_date}}</p>

    <p class="my-0 sign_fontsize"><span>Till date : </span>{{ \Carbon\Carbon::parse($user->from_date)->format('m-Y')}}</p>

    <p class="my-0 sign_fontsize"><span>Type of Employment : </span>{{$company->current_work_type}}</p>

    <p class="my-0 sign_fontsize"  style="word-break: break-all;"><span>Responsibilites : </span> {{$company->current_responsibilities}}

    </p>

    <p class="my-0 sign_fontsize"><span>Project Details : </span>{{$company->current_project_details}}</p>

    <p class="my-0 sign_fontsize"><span>Reason for Job Change : </span>{{$company->current_reason}} </p>

    <p class="my-0 sign_fontsize"><span>CTC when you started in the organization : </span>{{$company->current_ctc_start}}

    </p>

    <p class="my-0 sign_fontsize"><span>CTC when you moved out of the organization : </span>{{$company->current_ctc_end}}

    </p>

    @endif

    @endforeach

</div>

<div class="pt-3">

 @foreach ($companies as $company)

 @if($company->previous_desigination)

    <h6 class="sign_head">{{$company->previous_company}}<a href="javascript:void(0)"><i class="fa fa-pencil pl-2"

                aria-hidden="true" onclick="showpreviouscompanyEditModal({{$company->id}});"></i></a></h6>

    <p class="my-0 sign_fontsize"><span>Previous Designation : </span>{{$company->previous_desigination}}</p>

    <p class="my-0 sign_fontsize"><span>Start date : </span>{{$company->previous_start_date}}</p>

    <p class="my-0 sign_fontsize"><span>End date : </span>{{$company->previous_till_date}}</p>

    <p class="my-0 sign_fontsize" ><span>Type of Employment : </span>{{$company->previous_work_type}}</p>

    <p class="my-0 sign_fontsize" style="word-break: break-all;"><span>Responsibilites : </span> {{$company->previous_responsibilities}}

    </p>

    <p class="my-0 sign_fontsize"><span>No.of Projects handled in Case of IT Experience : </span>{{$company->previous_project_details}}

    </p>

    <p class="my-0 sign_fontsize"><span>Reason for Job Change : </span>{{$company->previous_reason}}</p>

    <p class="my-0 sign_fontsize"><span>CTC when you started in the organization : </span>{{$company->previous_ctc_start}}

    </p>

    <p class="my-0 sign_fontsize"><span>CTC when you moved out of the organization : </span>{{$company->previous_ctc_end}}

    </p> 

    @endif

 @endforeach

</div>



@if(empty($company->current_company))

<!--<div class="col-lg-12 pt-3 px-0">-->

<!--    <a href="#" title="Add Current Company" data-toggle="modal" data-target="#profile_sum">Add-->

<!--        Current Company</a>-->

<!--</div>-->

@endif

@if(empty($company->previous_company))

<div class="col-lg-12 pt-2 px-0">

    <a href="#" title="Add Previous Company" data-toggle="modal" data-target="#previous_sum">Add

        Previous Company</a>

</div>

@endif

</div>



<!-- Current Company  modal starts -->

@include('user.forms.company.current_company')

<!-- Current Company  modal Ends -->







<!-- previous company modal starts -->

@include('user.forms.company.previous_company')

@push('scripts')

<script>

$(".js-example-tags").select2({
                            tags: true
                          });

    
$("#front_work_disabled option:first").attr("disabled", "disabled");
    
    $("#type_employment option:first").attr("disabled", "disabled");




    $(document).ready(function(){

      $(".datepickerr").datepicker({

        format: "mm-yyyy",

        startView: "months", 

        minViewMode: "months"

      });   

    })
    


    $(function() {
    $( "#current_date_id" ).datepicker({   format: 'mm-yyyy',
        endDate: '+0d',
        autoclose: true });
  });

  $(function(){

$("#current_start_date2").datepicker({
format:'mm-yyyy',
endDate:'+0d',
autoclose:true
});


  });

  
    /**************************************************/





    

        /**************************************************/

    

     

    

        function submitcurrentcompanyForm() {



       // alert('value');

        var form = $('#current_company_form_id');

        

     //   alert($form);

    

        $.ajax({

    

        url     : form.attr('action'),

    

                type    : form.attr('method'),

    

                data    : form.serialize(),

    

                dataType: 'json',

    

                success : function (json){

                    $('#success_id9').html('<p class="alert alert-success">' + 'Current Company Updated Successfully ' + '</p>');

    location.reload(true);

                   

    

             

    

                },

    

                error: function(json){

       // alert('error');

                    if (json.status === 422) {

            var resJSON = json.responseJSON;

            $('.help-block').html('');

            $.each(resJSON.errors, function (key, value) {

            $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

            $('#div_' + key).addClass('has-error');

            });

            }

    

    

                }

    

        });

    

        }   

        

        

        function updatecurrentcompany() {



  // alert('value');

var form = $('#current_company_edit_form_id');



//   alert($form);



$.ajax({



url     : form.attr('action'),



        type    : form.attr('method'),



        data    : form.serialize(),



        dataType: 'json',



        success : function (json){

            $('#success_id8').html('<p class="alert alert-success">' + 'Current Company Updated Successfully ' + '</p>');


location.reload(true);

           



     



        },



        error: function(json){

 //alert('error');

            if (json.status === 422) {

    var resJSON = json.responseJSON;

    $('.help-block').html('');

    $.each(resJSON.errors, function (key, value) {

    $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

    $('#div_' + key).addClass('has-error');

    });

    }





        }



});



} 



function showcurrentcompanyEditModal(current_company_id){   

   // alert(current_company_id);

    

    $("#edit_current_company").modal();

    loadfrontcurrentEditForm(current_company_id);

    }

    function loadfrontcurrentEditForm(current_company_id){

    

    $.ajax({

    type: "POST",

            url: "{{ route('get.front.current.company.edit.form', $user->id) }}",

            data: {"current_company_id": current_company_id, "_token": "{{ csrf_token() }}"},

            datatype: 'json',

            success: function (json) {

                // $('#add_language_modal1234').modal('show'); 

                $("#edit_current_company").html(json.html);

            }

    });

    }

    

    

    

       

/********************* Previous company *************************/  

function submitpreviouscompanyForm() {



 // alert('value');

var form = $('#previous_company_form_id');



//   alert($form);



$.ajax({



url     : form.attr('action'),



        type    : form.attr('method'),



        data    : form.serialize(),



        dataType: 'json',



        success : function (json){

        $('#success_id11').html('<p class="alert alert-success">' + ' Previous Company Updated Successfully ' + '</p>');

location.reload(true);

           



     



        },



        error: function(json){

  //alert('error');

            if (json.status === 422) {

    var resJSON = json.responseJSON;

    $('.help-block').html('');

    $.each(resJSON.errors, function (key, value) {

    $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

    $('#div_' + key).addClass('has-error');

    });

    }





        }



});



}  







function showpreviouscompanyEditModal(previous_company_id){    

   // alert(previous_company_id); 

    

    $("#edit_previous_company").modal();

    loadfrontpreviousEditForm(previous_company_id);

    }

    function loadfrontpreviousEditForm(previous_company_id){

    

    $.ajax({

    type: "POST",

            url: "{{ route('get.front.previous.company.edit.form', $user->id) }}",

            data: {"previous_company_id": previous_company_id, "_token": "{{ csrf_token() }}"},

            datatype: 'json',

            success: function (json) {

                // $('#add_language_modal1234').modal('show'); 

                $("#edit_previous_company").html(json.html);

            }

    });

    } 

    

    

    function updatepreviouscompanyForm() {



// alert('value');

var form = $('#previous_company_edit_form_id');



//   alert($form);



$.ajax({



url     : form.attr('action'),



       type    : form.attr('method'),



       data    : form.serialize(),



       dataType: 'json',



       success : function (json){

        $('#success_id10').html('<p class="alert alert-success">' + 'Previous Company Updated Successfully ' + '</p>');


location.reload(true);

          



    



       },



       error: function(json){

 //alert('error');

           if (json.status === 422) {

   var resJSON = json.responseJSON;

   $('.help-block').html('');

   $.each(resJSON.errors, function (key, value) {

   $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

   $('#div_' + key).addClass('has-error');

   });

   }





       }



});



} 



$(document).ready(function () {
$('#previous_front_start').datepicker({
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

$('#previous_front_start').datepicker({
weekStart: 1,
startDate: '09/2019',
endDate: FromEndDate,
autoclose: true
})
.on('changeDate', function (selected) {
startDate = new Date(selected.date.valueOf());
startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
$('#previous_front_end').datepicker('setStartDate', startDate);
});
$('#previous_front_end')
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
$('#previous_front_start').datepicker('setEndDate', FromEndDate);
});

});

$(document).ready(function () {
$('#previous_front_start1').datepicker({
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

$('#previous_front_start1').datepicker({
weekStart: 1,
startDate: '09/2019',
endDate: FromEndDate,
autoclose: true
})
.on('changeDate', function (selected) {
startDate = new Date(selected.date.valueOf());
startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
$('#previous_front_end1').datepicker('setStartDate', startDate);
});
$('#previous_front_end1')
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
$('#previous_front_start1').datepicker('setEndDate', FromEndDate);
});

});











    </script>



@endpush