<div id="competing_offers" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">
    <div class="myprofile_font">Offers In Hand<i class="fa fa-pencil pl-2"
                aria-hidden="true"></i></div>
                
</div>

<div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">
    <div class="success " id="success_msg21"></div>
    <form id="front_offers_in_hand" action="{{route('update.front.offers',$user->id)}}" class = "form" method="post">
        @csrf
        
        <div class="row">
          
            <div class="col-lg position_lit">
                <label class="mb-2 sign_fontsize">Are you holding employment offers?<span
                        class="text-danger px-1">*</span></label>
                <select name="hold"
                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded"
                    id="extraoffers">

                    <option selected disabled>Select Option</option>
                    <option   value="1" @if(isset($user->getoffers()->hold)) @if($user->getoffers()->hold=="1") selected @endif  @endif >Yes</option>
			   <option  value="2" @if(isset($user->getoffers()->hold)) @if($user->getoffers()->hold=="2") selected @endif  @endif>No</option>
                </select>
                <span class="help-block hold-error"></span>
            </div>
        </div>
        <div class="section-offers-details" @if(isset($user->getoffers()->hold))@if($user->getoffers()->hold !="1") style="display:none" @endif @endif>
            <div class="row">
                <div class="col-lg position_lit">
                    <label class="mb-2 sign_fontsize pt-3">Reason for exploring opportunities despite
                        having offer/s<span class="text-danger px-1">* </span></label>
                    <input type="text"  name="expoff" class="w-100 signup_input rounded px-3 py-2" id="opportunities" value="{{old('expoff',(isset($user->getoffers()->expoff))? $user->getoffers()->expoff:'') }}">
                    <span class="help-block expoff-error"></span>
                 </div>
            </div>
            <div class="row">
                <div class="col-lg position_lit">
                    <label class="mb-2 sign_fontsize pt-3">Please mention the total offers you are
                        holding<span class="text-danger px-1">*</span></label>
                    <input type="text" name="repoff" class="w-100 signup_input rounded px-3 py-2" id="offercountinc"
                        value='{{old('repoff',(isset($user->getoffers()->repoff))? $user->getoffers()->repoff:'1') }}' readonly>
                        <span class="help-block repoff-error"></span> 
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 position_lit">
                    <label class="mb-2 sign_fontsize pt-3">CTC Offered (in Lakhs)<span
                            class="text-danger px-1">*</span></label>
                    <input type="tel" name="ctcoff1" id="ctc_value" class="w-100 signup_input rounded px-3 py-2 ctc-input" value="{{old('ctcoff1',isset($user->getoffers()->ctcoff1)) ? $user->getoffers()->ctcoff1 : ''}}"  minlength="0" maxlength="3">
                    <span class="help-block ctcoff1-error"></span>
                 </div>
                <div class="col-lg-4 position_lit">
                    <label class="mb-2 sign_fontsize pt-3">Date of Joining<span
                            class="text-danger px-1">* </span></label>
                    <input type="text" name="dateoff1" class="w-100 signup_input rounded datepickerr px-3 py-2" value="{{old('dateoff1',(isset($user->getoffers()->dateoff1)) ? $user->getoffers()->dateoff1 : '')}}">
                    <span class="help-block dateoff1-error"></span>
                 </div>
                <div class="col-lg-4 position_lit">
                    <label class="mb-2 sign_fontsize pt-3">Location of Job Offer<span
                            class="text-danger px-1">* </span></label>
                    <input type="text" id="autocomplete_offers" name="locoff1" class="w-100 signup_input rounded px-3 py-2 " value="{{old('locoff',(isset($user->getoffers()->locoff1)) ? $user->getoffers()->locoff1 :'')}}">
                    <span class="help-block locoff1-error"></span>
                </div> 
                
    @if(isset($user->getoffers()->ctcoff) && !empty($user->getoffers()->dateoff))
        	<?php
        		$ctcoff = unserialize($user->getoffers()->ctcoff);
        		$dateoff = unserialize($user->getoffers()->dateoff);
        		$locoff = unserialize($user->getoffers()->locoff);
        		// print_r($locoff);
        	?>
	
	@if(isset($ctcoff))
	
	  @foreach($ctcoff as $key => $item )


            <div id="inputFormRow">
                <div class="row mx-0">
                    <div class="col-lg-3 position_lit">
                        <label class="mb-2 sign_fontsize pt-3">CTC Offered(in Lakhs)<span class="text-danger px-1">*</span></label>
                        <input type="number" name="ctcoff[]" class="w-100 signup_input rounded px-3 py-2" min="0" max="10000000" value="{{ $ctcoff[$key]  }}">
                        <span class="help-block ctcoff-error"></span>
                    </div>
                    <div class="col-lg-3 position_lit">
                   
                        <label class="mb-2 sign_fontsize pt-3">Date of Joining<span class="text-danger px-1">*</span></label>
                        <input type="text" name="dateoff[]" class="w-100 signup_input datepickerr rounded px-3 py-2" value="{{$dateoff[$key] }}">
                        <span class="help-block dateoff-error"></span>
                    </div>
                    <div class="col-lg-3 position_lit">
                        <label class="mb-2 sign_fontsize pt-3">Location of Job Offer<span class="text-danger px-1">*</span></label>
                        <input type="text" name="locoff[]" class="w-100 signup_input rounded px-3 py-2 myClass" value="{{$locoff[$key]}}">
                        <span class="help-block locoff-error"></span>
                    </div>
                    <div class="col-lg-3 position_lit d-flex justify-content-center align-items-end">
                    <button id="removeRow" type="button" class="w-100 btn btn-danger removeRow" style="height: 42px;margin-bottom: 3px;margin-top: 20px;">Remove</button>
                    </div>
                </div>
                </div>
                
		
	@endforeach
	@endif
	@endif
                
                
            </div>
            <div id="newRow"></div>
            
           
            <div class="col-sm-4 col-md-3 position_lit px-0 pt-4">
                <button id="addRow" type="button" class="w-100 btn btn-info">Add Offer</button>
            </div>
        </div>
        <div class="text-center pt-4"><button type="button" class="signin_button rounded px-3 py-1" onClick="submitfrontoffers();">Update</button>
        <br>
       
        </div>
    </form>

</div> 

@push('scripts') 

<script type="text/javascript">
function submitfrontoffers()
{
      
        var dataValid = true;
          var dataValid1 = true;
            var dataValid2 = true;
        $("input[name='ctcoff[]']").each(function(){
            if ($(this).val() == ''){
                dataValid = false;
            }
        });
        $("input[name='dateoff[]']").each(function(){
            if ($(this).val() == ''){
                dataValid1 = false;
            }
        });
        $("input[name='locoff[]']").each(function(){
            if ($(this).val() == ''){
                dataValid2 = false;
            }
        });


        if (dataValid && dataValid1 && dataValid2)
        {

            var form = $('#front_offers_in_hand');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function (json) {
            // alert('success');
            $("#success_msg21").show(); 
                $("#success_msg21").html('<div class="alert alert-success">Offers In Hand updated successfully</div>');
                setTimeout(function() { $("#success_msg21").hide(); }, 5000);
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


        } else {
           alert('Fill in all the data!');
        }

              
        
     
}




    
    function myFunction(val) {
  new_location = val;
  //alert(new_location);
}
    
              var count = 1;  
                        $("#addRow").click(function() {
                           var countinc = count++;
                           //while (count <= 1) {
                           var html = '';
                           html += '<div id="inputFormRow">';
                           html += '<div class="row dynamic_class">';
                           html += '<div class="col-lg-3 position_lit">';
                           html += '<label class="mb-2 sign_fontsize pt-3">CTC Offered(in Lakhs)<span class="text-danger px-1">*</span></label>';
                           html += '<input type="number" name="ctcoff[]" class="w-100 signup_input rounded px-3 py-2" min="0" max="100">';
                           html += ' <span class="help-block ctcoff-error"></span>';
                           html += '</div>';
                           html += '<div class="col-lg-3 position_lit">';
                           html +=
                               '<label class="mb-2 sign_fontsize pt-3">Date of Joining<span class="text-danger px-1">*</span></label>';
                           html += '<input type="text" name="dateoff[]" class="w-100 signup_input datepicker7 rounded px-3 py-2 " id="date_pick" >';
                           html += '</div>';
                           html += '<div class="col-lg-3 position_lit">';
                           html +=
                               '<label class="mb-2 sign_fontsize pt-3">Location of Job Offer<span class="text-danger px-1">*</span></label>';
                           html += '<input type="text" name="locoff[]" class="w-100 signup_input rounded px-3 py-2 myClass' + count + '" id="location' + count + '" onchange="myFunction(this.id)">';
                           html += '</div>';
                           html += '<div class="col-lg-3 position_lit d-flex justify-content-center align-items-end">';
                           html +=
                               '<button id="removeRow" type="button" class="w-100 btn btn-danger removeRow" style="height: 42px;margin-bottom: 3px;margin-top: 20px;">Remove</button>';
                           html += '</div>';
                           html += '</div>';
                           html += '</div>';
                           $('#newRow').append(html);
                           var countdec = $("#newRow #inputFormRow").length;
                         //  alert(countdec);
                           $("#offercountinc").val(countdec + 1);
                           $('.datepicker7').datepicker({
                            clearBtn: true,
                            format: 'dd-mm-yyyy'
            
            });



    $location_input = $(".myClass");


                            


    $(document).ready(function () {



   
    var options = {
        types: ['(cities)'],
        componentRestrictions: {
            country: 'IN'
        }
    };
    var input = document.getElementsByClassName('myClass' + count + '');
    for (i = 0; i < input.length; i++) {
                 autocomplete = new google.maps.places.Autocomplete(input[i], options);
                
             }   
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var data = $("#search_form").serialize();

        var location = $('.myClass' + count + '').val();

    // alert(location);
        location = location.split(',')[0];
        $('.myClass' + count + '').val(location);
        // $("#autocomplete12").append(location);
        console.log('blah')
       // show_submit_data(location);
        return false;
    });

});

                           //}
                        });


	// remove row
	$(document).on('click', '.removeRow', function () {

        // alert('remove');
		
		$(this).closest('#inputFormRow').remove();
		var countdec = $("#newRow #inputFormRow").length;
	//	alert(countdec);
		$("#offercountinc").val(countdec+1);
	});
	


</script>



<script>




$("#date_pick").datepicker({

autoclose: true,
startDate: '01/01/1950',

        format: 'dd-mm-yyyy'

});





    </script>
<script>

    $('body').on('keyup', '.ctc-input', function () {
        var $input = $(this),
            value = $input.val(),
            length = value.length,
            inputCharacter = parseInt(value.slice(-1));
    
        if (!((length > 0 && inputCharacter >= 0 && inputCharacter <= 100) || (length === 1 && inputCharacter >= 7 && inputCharacter <= 1000))) {
            $input.val(value.substring(0, length - 1));
         }
      });
    
    
        </script>


@endpush
