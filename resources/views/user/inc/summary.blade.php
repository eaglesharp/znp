<div id="profile_achievements" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">
    <div class="myprofile_font">Profile Summary</div>
</div>

<div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">
    <form action="{{route('store.user.front.summary',$user->id)}}" method="post" id="frontsummary">
    @csrf
    <div class="success_msg" id="success_msg14"></div>

        <div class="row">
            <div class="col-12">  <div class="form-group " id="div_summary">
                <label class="mb-2 pt-2 sign_fontsize">Professional Achievements<span
                        class="text-danger px-1">*</span></label>
                <!--<textarea type="text" class="w-100 signup_input rounded px-3 py-2" id="charcount" name-->
                <!--="summary"-->
                <!--    placeholder="Describe Your Self" maxlenght="256">{{ old('summary', (isset($user))? $user->getProfileSummary('summary'):'') }}</textarea>-->
                    <textarea id="textarea" class="w-100 signup_input rounded px-3 py-2" id="charcount" name
                ="summary"
                    placeholder="Describe Your Self" maxlength="500">{{ old('summary', (isset($user))? $user->getProfileSummary('summary'):'') }}</textarea>
 
                    <span class="help-block summary-error"></span> 
                    <p class="sign_fontsize"><span class="label label-info" id="charNum">500 Character(s) Remaining</span></p>
                    <!--<p class="sign_fontsize"> <span id="rchars">500</span> Character(s) Remaining</p>-->
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <label class="mb-2 pt-2 sign_fontsize">Total Experience<span
                        class="text-danger px-1">*</span></label>
                        <?php 
        
                        $exp=(isset($user->getsummaries()->totalexp) ? $user->getsummaries()->totalexp:'');
                        
                        ?>                
       {!! Form::select('totalexp',[''=>'Select Year']+MiscHelper::gettotalexp(),$exp,array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded','id'=>'totalexp')  )  !!}  
       <span class="help-block totalexp-error"></span> 
            </div>
            <div class="col-lg-6">
                <label class="mb-sm-2 pt-lg-3 sign_fontsize"><span
                        class="text-danger px-1 my-0"></span></label>
                        <?php 
                        $month=(isset($user->getsummaries()->totalexpmonth) ?$user->getsummaries()->totalexpmonth :'');
                        ?>
                        {!! Form::select('totalexpmonth',[''=>'Select Month']+MiscHelper::getprofilemonths(),$month,array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded modal_emplo','id'=>'totalexpmonth')  )  !!}  
        <span class="help-block totalexpmonth-error"></span> 
                        
            </div>
            <div class="col-lg-6 lacom">
                <label class="mb-2 pt-3 sign_fontsize">Latest Company<span
                        class="text-danger px-1">*</span></label>
                        <?php 
                
         $latestcom=(isset($user->getsummaries()->latestcom) ? $user->getsummaries()->latestcom:'');
         
         ?> 
                {{-- <input type="text" class="w-100 signup_input rounded px-3 py-2" name="latestcom" value="{{$latestcom}}"
                    placeholder="Latest Company"> --}}


                    <select name="latestcom" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded js-example-tags livesearch latestcom">
                     
                       @foreach ($datas as $c_data)
                       <option value="{{ $c_data->id }}"
                        @isset($user->getsummaries()->latestcom_id)                                    
                       
                        @if ($user->getsummaries()->latestcom_id == $c_data->id)
                           selected
                        @endif

                        @endisset
                       >{{ $c_data->name }}</option>
                       @endforeach                       
                    
                      </select>
                    <span class="help-block latestcom-error"></span> 
            </div>
            <div class="col-lg-6">
                <label class="mb-2 pt-3 sign_fontsize">Latest Designation<span
                        class="text-danger px-1">*</span></label>
                        <?php 
                        $latestdesg=(isset($user->getsummaries()->latestdesg) ?$user->getsummaries()->latestdesg :'');
                        ?>
                <input type="text" class="w-100 signup_input rounded px-3 py-2" name="latestdesg" value="{{$latestdesg}}"
                    placeholder="Latest Designation">
                   
                    <span class="help-block latestdesg-error"></span> 
            </div>
            
        @php
            $selected = [];
            $selected = unserialize($user->ignore_companies);
        @endphp
      
                <div class="col-12 col-md-12 mt-3">

                    <label class="sign_fontsize ignore-i">Jobsearch Privacy: Please choose to hide your CV from being viewed by the Employers (Current/Past) <i class="fa fa-info"
                        data-toggle="tooltip" title="This is a privacy option. This wiill help you not be found by the employers (Current/Past) you choose to hide your CV from"></i></label>
                                    
                                <div class="w-100 ignore-class"  >
                                    <select class="form-control" id="ignore_companies" name="ignore_companies[]" multiple="multiple" >
                                
                                        @foreach ($datas as $c_data)
                                       <option value="{{ $c_data->id }}" @if(!is_null($selected) && is_array($selected) && in_array($c_data->id, $selected)) selected @endif>
                                            {{ $c_data->name }}
                                        </option>
                                    @endforeach                                                         
                                    </select>
                                
                                </div> 
                </div>      
          
            <div class="col-6">
                <label class="mb-2 pt-3 sign_fontsize">Current Shift<span
                        class="text-danger px-1 my-0">*</span></label>
                <select name="currentshift"
                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded modal_emplo"
                    placeholder="month">
                    <option selected disabled>Select Shift</option>
                    <option   value="Indian Shift" @if(isset($user->getsummaries()->currentshift)) @if($user->getsummaries()->currentshift=="Indian Shift") selected @endif  @endif >Indian Shift</option>                           
                                <option  value="US Shift"  @if(isset($user->getsummaries()->currentshift)) @if($user->getsummaries()->currentshift=="US Shift") selected @endif  @endif >US Shift</option>
                                <option  value="UK Shift" @if(isset($user->getsummaries()->currentshift)) @if($user->getsummaries()->currentshift=="UK Shift") selected @endif  @endif >UK Shift</option>
                                <option  value="Rotational" @if(isset($user->getsummaries()->currentshift)) @if($user->getsummaries()->currentshift=="Rotational") selected @endif  @endif >Rotational</option>
                </select>
                <span class="help-block currentshift-error"></span> 
            </div>
            <div class="col-6">
                <label class="mb-2 pt-3 sign_fontsize">Reason for moving out<span
                        class="text-danger px-1 my-0">*</span></label>
                        <select id="reason_moved" name="reason_moved" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded modal_emplo" >

                            <option selected disabled>Select Status</option>
                
                            <option   value="Lay Offs" @if($user->reason_moved == 'Lay Offs')selected @endif>Lay Offs</option>
                
                            <option  value="Resignation" @if($user->reason_moved == 'Resignation')selected @endif>Resignation</option>
                            
                                <option  value="Fresher" @if($user->reason_moved == 'Fresher')selected @endif>NA - Fresher</option>
                
                
                
                        </select>

                <span class="help-block currentshift-error"></span> 
            </div>
         
        </div>
    </form> <br>
    
    <div class="col-lg-12  mt-1 text-center">
        <input class="signin_button rounded px-3 py-1 new-cursor" value="Update" type="submit" onclick="submitProfileSummaryForm();" >
   
    </div>
   
@push('scripts') 
<script type="text/javascript">



$('#ignore_companies').select2({

    tags: true,
 
 tokenSeparators: [','],
    
    maximumSelectionLength: 5
});

$(".js-example-tags").select2({
                            tags: true
                          });


    function submitProfileSummaryForm() {
   // alert('hello');
        var form = $('#frontsummary');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function (json) {
           // alert('success');
           $("#success_msg14").show(); 
           $(".new_error_class").hide(); 
                $("#success_msg14").html("<div class='alert alert-success'>{{__('Summary updated successfully')}}</div>");
                setTimeout(function() { $("#success_msg14").hide(); }, 5000);
            },
            error: function (json) {
                if (json.status === 422) {
                    var resJSON = json.responseJSON;
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
    
    $("#totalexp option:first").attr("disabled", "disabled");
    
    $("#totalexpmonth option:first").attr("disabled", "disabled");


    $(document).ready(function(){
  $('#charcount').keyup(function () {
    var max = 500;
    var len = $(this).val().length;
    if (len >= max) {
      $('#charNum').text(' You have reached the limit');
    } else {
      var char = max - len;
      $('#charNum').text(char + ' characters left');
    }
  });
});

var maxLength = 500;
$('#charcount').keyup(function() {
  var textlen = maxLength - $(this).val().length;
  
  if (textlen > 0) {
      
      $("#charNum").css("color", "");
      
      $('#charNum').text(textlen + ' Character(s) Remaining');
     
    
    } else {
        
        
          
           $('#charNum').css("color","red");
       
          $('#charNum').text(' You have reached the limit');
      
    }
 
});
    
</script> 
@endpush            