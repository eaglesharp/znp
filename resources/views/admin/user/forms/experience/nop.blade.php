{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')

<form class="form" id="add_edit_profile_np" method="POST" action="{{ route('update.profile.np', [$user->id]) }}">{{ csrf_field() }}

    <div class="form-body">

        <div id="success_msg" class="has-error"></div>

        <div class="form-group" id="div_nop_days">

            <label for="nop_days" class="bold">Notice Period Status </label><span class="text-danger px-1">*</span>

            <select name="nop_days" id="nop_days" class="form-control">

                <option   value="1" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days=="1") selected @endif  @endif>Immediately Available</option>

                <option  value="2" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days=="2") selected @endif  @endif>Serving Notice Period</option>

                {{-- <option  value="3" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days=="3") selected @endif  @endif>Buyable Notice Period</option>

                <option  value="4" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days=="4") selected @endif  @endif>Not Under Notice Period </option> --}}

            </select>

            <input type="hidden" value="{{$user->id}}" name="user_id">

            </div>

            



            <div id="test_yes" @if(isset($user->getprofileNop()->nop_days))@if($user->getprofileNop()->nop_days !="1")style="display:none" @endif @endif>

            <div class="form-group"  id="buyable">

                    

                <label for="immediate_last_date" class="bold">Mention your Last Working Date with your last employer OR your Month of graduation in case you are a fresher </label><span class="text-danger px-1">*</span>

                <input type="text" name="immediate_last_date" id="immediate_last_date" class="form-control datepicker-immediate newtest" value="{{ old('immediate_last_date', (isset($user->getprofileNop()->immediate_last_date))? $user->getprofileNop()->immediate_last_date:'') }}" > 

                <span class="help-block immediate_last_date-error" style="color:#a94442"></span>

            </div>

        </div>

        



        <div id="last_yeshide" @if(isset($user->getprofileNop()->nop_days))@if($user->getprofileNop()->nop_days !="2")style="display:none" @endif @endif>

            <div class="form-group">

                    

                <label for="nop_status" class="bold">Last working date incase notice period is being served</label><span class="text-danger px-1">*</span>

                <input type="text" name="last_working_day" id="last_working_day" class="form-control datepicker_lastwork newtest" value="{{ old('last_working_day', (isset($user->getprofileNop()->last_working_day))? Carbon\Carbon::parse($user->getprofileNop()->last_working_day)->format('d-M-Y'):'') }}"> 

                <span class="help-block last_working_day-error" style="color:#a94442"></span>

            </div>

        </div>

    

        <button type="button" class="btn btn-large btn-primary" onClick="submitProfileNp();">Update Notice Period <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>

        <div class="success" id="success_msg"></div>

    </div>

</form>

@push('scripts') 

<script type="text/javascript">

    function submitProfileNp() {

        var form = $('#add_edit_profile_np');

        $.ajax({

            url: form.attr('action'),

            type: form.attr('method'),

            data: form.serialize(),

            dataType: 'json',

            success: function (json) {
                $('.help-block').hide();

                $("#success_msg").show();

	           $("input.form-control.newtest").css("border-color","#ccc ");

                $("#success_msg").html('<span class="text text-success">Notice Period updated successfully</span>');

                setTimeout(function() { $("#success_msg").hide(); }, 5000);
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

    

    $("#nop_days").change(function(){

 if(this.value==1){ $('#test_yes').show();} else{ $('#test_yes').hide(); }



});

$('#nop_days').change(function(){



if(this.value==2)

{

$('#last_yeshide').show();

}else{

$('#last_yeshide').hide();

}



});

    

$(".datepicker-immediate").datepicker({
  autoclose: true,
  format: 'dd-M-yyyy',
  todayHighlight: true,
  orientation: 'bottom',
  endDate: new Date()
});



$(".datepicker_lastwork").datepicker({
  autoclose: true,
  format: 'dd-M-yyyy',
  todayHighlight: true,
  orientation: 'bottom',
  startDate: new Date()
});

    
    

</script>

@endpush