  <!-- Compensation -->
  <div id="compensation" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">
    <div class="myprofile_font">Compensation<i class="fa fa-pencil pl-2" id="edit12"
                aria-hidden="true"></i></div>
</div>

<?php 

$data3=\App\ProfileDetails::where('user_id',$user->id)->first();
           $ctc1=(isset($data3) ? $data3->expect_ctc_lakhs:'');
           $ctc2=(isset($data3) ? $data3->expect_ctc_thousand:'');
           $ctc3=(isset($data3) ? $data3->expect_ctc_lakhs1:'');
           $ctc4=(isset($data3) ? $data3->expect_ctc_thousand1:'');
           $ctc5=(isset($data3) ? $data3->expect_ctc_lakhs2:'');
           $ctc6=(isset($data3) ? $data3->expect_ctc_thousand2:'');
           $ctc7=(isset($data3) ? $data3->expect_ctc_lakhs3:'');
           $ctc8=(isset($data3) ? $data3->expect_ctc_thousand3:'');


?>




<div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">
    <div class="success_msg " id="success_msg15"></div>
    {!! Form::model($user, array('method' => 'post', 'route' => array('update.compensation',[$user->id]), 'class' => 'form', 'id'=>'compensation_form','files'=>true)) !!}

        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-12">
                <label class="mb-2 sign_fontsize">Current Total CTC per annum (Fixed + Variable + Bonus
                    + Incentives + Benefits)<span class="text-danger px-1">*</span></label>
            </div>
            <div class="col-lg-6 pb-3 pb-lg-0 position_lit">
                <input type="number" onkeyup=imposeMinMax(this) min="1" max="100" placeholder="Lakh"
                    class="w-100 pl-3 pr-4 py-2  sign_fontsize  signup_input rounded btnsub1 edit1" name="expect_ctc_lakhs" value="{{$ctc1}}"  >
                  
                <span class="help-block expect_ctc_lakhs-error" style="color:#a94442">
                    </span>
            </div>
            <div class="col-lg-6 pb-3 pb-lg-0 position_lit">
                <input type="number" onkeyup=imposeMinMax(this) min="0" max="99"
                    placeholder="Thousand"
                    class="w-100 pl-3 pr-4 py-2 sign_fontsize  signup_input rounded btnsub1 edit1" name="expect_ctc_thousand" value="{{$ctc2}}" >
                    <span class="help-block expect_ctc_thousand-error" style="color:#a94442"></span>
            
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <label class="mb-2 sign_fontsize pt-3">Fixed CTC per annum<span
                        class="text-danger px-1">*</span></label>
            </div>
            <div class="col-lg-6 pb-3 pb-lg-0">
                </select>
                <input type="number" onkeyup=imposeMinMax(this) min="1" max="100" placeholder="Lakh"
                    class="w-100 pl-3 pr-4 py-2  sign_fontsize  signup_input rounded btnsub1 edit1" name="expect_ctc_lakhs1" value="{{$ctc3}}" >
                    <span class="help-block expect_ctc_lakhs1-error" style="color:#a94442"></span>
            </div>
            <div class="col-lg-6 pb-3 pb-lg-0">
                <input type="number" onkeyup=imposeMinMax(this) min="0" max="99"
                    placeholder="Thousand"
                    class="w-100 pl-3 pr-4 py-2 sign_fontsize  signup_input rounded btnsub1 edit1" name="expect_ctc_thousand1" value="{{$ctc4}}" >
                    <span class="help-block expect_ctc_thousand1-error" style="color:#a94442"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <label class="mb-2 sign_fontsize pt-3">Variable CTC per annum (Incentives/Bonus)<span
                        class="text-danger px-1">*</span></label>
            </div>
            <div class="col-lg-6 pb-3 pb-lg-0">
                <input type="number" onkeyup=imposeMinMax(this) min="1" max="100" placeholder="Lakh"
                    class="w-100 pl-3 pr-4 py-2  sign_fontsize  signup_input rounded btnsub1 edit1" name="expect_ctc_lakhs2" value="{{$ctc5}}" >
                    <span class="help-block expect_ctc_lakhs2-error" style="color:#a94442"></span>
            </div>
            <div class="col-lg-6 pb-3 pb-lg-0">
                <input type="number" onkeyup=imposeMinMax(this) min="0" max="99"
                    placeholder="Thousand"
                    class="w-100 pl-3 pr-4 py-2 sign_fontsize  signup_input rounded btnsub1 edit1" name="expect_ctc_thousand2" value="{{$ctc6}}" >
                    <span class="help-block expect_ctc_thousand2-error" style="color:#a94442"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <label class="mb-2 sign_fontsize pt-3">Expected CTC per annum<span
                        class="text-danger px-1">*</span></label>
            </div>
            <div class="col-lg-6 pb-3 pb-lg-0">
                <input type="number" onkeyup=imposeMinMax(this) min="1" max="100" placeholder="Lakh"
                    class="w-100 pl-3 pr-4 py-2  sign_fontsize  signup_input rounded btnsub1 edit1" name="expect_ctc_lakhs3" value="{{$ctc7}}" >
                    <span class="help-block expect_ctc_lakhs3-error" style="color:#a94442"></span>
            </div>
            <div class="col-lg-6 pb-3 pb-lg-0">
                <input type="number" onkeyup=imposeMinMax(this) min="0" max="99"
                    placeholder="Thousand"
                    class="w-100 pl-3 pr-4 py-2 sign_fontsize  signup_input rounded btnsub1 edit1" name="expect_ctc_thousand3" value="{{$ctc8}}" >
                    <span class="help-block expect_ctc_thousand3-error" style="color:#a94442"></span>
            </div>
        </div>
        <br>
        <div class="col-lg-12  mt-1 text-center">
            <input class="signin_button rounded px-3 py-1 new-cursor" value="Update" type="button" onclick="submitcompensationForm();" >
            
       
        </div>
    </form>
    @if(session()->has('newtext'))
        
    <div class="alert alert-success">
    
        <ul>
    
            {{session()->get('newtext')}}
    
        </ul>
    
    </div>
    
    @endif
</div>


@push('scripts') 

 <script>
 function submitcompensationForm() {
  //  alert('hello');
        var form = $('#compensation_form');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function (json) {
           // alert('success');
           $("#success_msg15").show(); 
           $(".new_error_class").hide(); 
           $("#success_msg15").empty();
                $("#success_msg15").html("<div class='alert alert-success'>{{__('Compensation updated successfully')}}</div>");
                setTimeout(function() { $("#success_msg15").hide(); }, 5000);
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
// $("document").ready(function(){
//     setTimeout(function(){
//        $("div.alert").remove();
//     }, 2000 ); // 5 secs

// });
</script>
 

 @endpush