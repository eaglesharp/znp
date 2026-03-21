{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <?php 

        $interviews_data=\App\Interview::where('user_id',$user->id);

        $interviews = $interviews_data->get();
        $interview_count = $interviews_data->count();


    ?>

    @if($interview_count < 3)
    <div class="form-group">
        <button class="btn purple btn-outline sbold" onclick="showInterviewModal();"> Add Interview </button>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption"> <i class=" icon-layers font-green"></i> <span class="caption-subject font-green bold uppercase">InterViews</span> </div>
                </div>
                <div class="portlet-body"><div class="row" id="interview_div"></div></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-lg" id="add_interview_modal" tabindex="-1" role="dialog" aria-hidden="true"></div>
@push('css')
<style type="text/css">
    .datepicker>div {
        display: block;
    }
</style>
@endpush
@push('scripts') 
<script type="text/javascript">
    /**************************************************/

    function showInterviewModal(){
    $("#add_interview_modal").modal();
    loadInterviewForm();
    }
    function loadInterviewForm(){
    $.ajax({
    type: "POST",
            url: "{{ route('get.interview.form', $user->id) }}",
            data: {"_token": "{{ csrf_token() }}"},
            datatype: 'json',
            success: function (json) {
            $("#add_interview_modal").html(json.html);
            initdatepicker();
            }
    });
    }
   
    $(document).ready(function(){

        $('.date-picker').datepicker({

        startDate: new Date(), // controll start date like startDate: '-2m' m: means Month
        endDate: '+30d',
        dateFormat: 'dd/mm/y',//check change
        changeMonth: true,
        changeYear: true


        });


        

        showInterview(); 
 
    });
    function showInterview()
    {
     
    $.post("{{ route('show.interview.form', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#interview_div').html(response);
            });
    }

    function submitInterviewForm() {
    var form = $('#add_interview_form');
    $.ajax({
    url     : form.attr('action'),
            type    : form.attr('method'),
            data    : form.serialize(),
            dataType: 'json',
            success : function (json){
            $ ("#add_interview_modal").html(json.html);
            showInterview();
            },
            error: function(json){
            if (json.status === 422) {
            var resJSON = json.responseJSON;
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

    function delete_interview(id) {
    if (confirm('Are you sure! you want to delete?')) {
    $.post("{{ route('delete.interview') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            if (response == 'ok')
            {
                showInterview();
            } else
            {
                showInterview();
            }
            });
    }
    }


    function interview(interview_id ){    
   
   // $("#add_education_modal").modal();
   loadInterviewEditForm(interview_id );
   }
   function loadInterviewEditForm(interview_id ){
   $.ajax({
   type: "POST",
           url: "{{ route('get.interview.edit.form', $user->id) }}",
           data: {"interview_id": interview_id, "_token": "{{ csrf_token() }}"},
           datatype: 'json',
           success: function (json) {
           $("#add_interview_modal").modal();
           $("#add_interview_modal").html(json.html);
           

           }
   });
   }

   
</script> 
@endpush        