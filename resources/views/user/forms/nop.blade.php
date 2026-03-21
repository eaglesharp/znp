<div id="Noticeperiod_profile" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">

    <div class="myprofile_font">Notice Period Status<i

                class="fa fa-pencil pl-2" aria-hidden="true"></i></div>

</div>

<div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">

    <form class="form" id="add_profile_np" method="POST" action="{{ route('update.front.profile.np', [$user->id]) }}">{{ csrf_field() }}

        <div class="success_msg1 success_msg17 " id="success_msg17"></div>

        

        <div class="row">

            <div class="col-lg position_lit">

                <label class="mb-2 sign_fontsize">Notice Period Status<span

                        class="text-danger px-1">*</span></label>

                        <input type="hidden" value="{{$user->id}}" name="user_id">

                <select name="nop_days" 

                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded newtest"

                    id="noticeperiodopt1">

                    <option selected disabled>Select Option</option>

                    <option   value="1" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days=="1") selected @endif  @endif>Immediately Available</option>

                <option  value="2" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days=="2") selected @endif  @endif>Serving Notice Period</option>

                </select>
                <span class="help-block nop_days-error"></span> 

            </div>

        </div>

        <div id="appendforsnp" @if(isset($user->getprofileNop()->nop_days))@if($user->getprofileNop()->nop_days !="2")style="display:none" @endif @endif>

            <div  class="row" id="test_yes1">

                <div class="col-lg-12">

                    <label class="mb-2 pt-3 sign_fontsize"> Last working date incase notice period is being

                        served<span class="text-danger px-1">*</span></label>

                    <input type="text" name="last_working_day" class="w-100 signup_input rounded px-3 py-2 sign_fontsize datepicker  newtest  " value="{{isset($user->getprofileNop()->last_working_day) ? \Carbon\Carbon::parse($user->getprofileNop()->last_working_day)->format('d-M-Y'): ''  }}"

                        id="appendforsnpinput">
                        <span class="help-block last_working_day-error" style="color:#a94442"></span>

                </div>

            </div>

        </div>

        <div class="row" id="appendforbnp" @if(isset($user->getprofileNop()->nop_days)) @if($user->getprofileNop()->nop_days !="1")style="display:none" @endif @endif>

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">Mention your Last Working Date with your last employer OR your Month of graduation in case you are a fresher<span

                        class="text-danger px-1">* </span></label>

                <input type="text" name="immediate_last_date" class="w-100 signup_input rounded px-3 py-2 newtest datepicker-month" id="appendforbnpinput" value="{{(isset($user->getprofileNop()->immediate_last_date) ?$user->getprofileNop()->immediate_last_date: '')  }}" >

                <span class="help-block immediate_last_date-error" style="color:#a94442"></span>

            </div>

        </div>

        <div class="col-lg-12  mt-1 text-center">
        <br>
         
                <button type="button" class="signin_button rounded px-3 py-1" onClick="submitnopskills();">Update</button>
       <br>
               
        </div>

    </form> 

    @if(session()->has('message'))

    <span class="alert alert-success">

        {{ session()->get('message') }}

    </span>

@endif

    <div class="success" id="success_msg"></div>

</div>

@push('scripts') 

<script type="text/javascript">

   

    

    $("#noticeperiodopt1").change(function(){

            var value= this.value;


        if(this.value==2)
        { 
            $('#appendforsnp').show();
        } else{
            $('#appendforsnp').hide(); }



        });



$('#noticeperiodopt1').change(function(){



if(this.value==1)

{

$('#appendforbnp').show();

}else{

$('#appendforbnp').hide();

}



});

    
function submitnopskills() {

   //alert('hello');

var form = $('#add_profile_np');

$.ajax({

url     : form.attr('action'),

       type    : form.attr('method'),

       data    : form.serialize(),

       dataType: 'json',

       success : function (json){        

   // alert('success');
   $(".success_msg17").show(); 

   //$(".new_error_class").hide(); 

   $('.help-block').hide();
            $(".newtest").css("border-color","#ccc ");

    $(".success_msg17").html("<div class='alert alert-success'>{{__('Notice Period updated successfully')}}</div>");
                setTimeout(function() { $(".success_msg17").hide(); }, 5000);

      

       },

       error: function(json){


       
        // document.getElementById('savekey').innerHTML = 'Save';
        
     //location.reload(true);


       if (json.status === 422) {

       var resJSON = json.responseJSON;

       $('.help-block').show();

       $('.help-block').html('');

       $.each(resJSON.errors, function (key, value) {

       $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

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


$(".datepicker-month").datepicker({
  autoclose: true,
  format: 'dd-M-yyyy',
  todayHighlight: true,
  orientation: 'bottom',
  endDate: new Date()
});



$(".datepicker").datepicker({
  autoclose: true,
  format: 'dd-M-yyyy',
  todayHighlight: true,
  orientation: 'bottom',
  startDate: new Date()
});


    

</script>

@endpush