{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')

{{-- <div  id="competing_offers" class=" profile_head new">

	<div class="myprofile_font">Offers In Hand<a href="javascript:void(0)" ><i class="fa fa-pencil pl-2" aria-hidden="true"></i></a></div>

</div> --}}

<br>

<div class="box_profile px-4 px-sm-5 py-4 py-sm-5 new">

   <form id="offers_in_hand" action="{{route('update.offers',$user->id)}}" class = "form" method="post">

   @csrf

   

	   {{-- <div class="row">

		   <div class="col-lg newposition">

			   <label  class="mb-2 newfont">Are you holding employment offers?<span class="text-danger px-1"> </span></label>

			   <select class="w-100 pl-3 pr-4 py-2 form_control-arrow newfont  signup_input new" id="extraoffers">

				   <option selected disabled>Select Option</option>

				   <option value="yes">Yes</option>

				   <option value="no">No</option>

			   </select>

		   </div>

	   </div> --}}

	   <div class="form-group " id="div_hold">

		   <label for="hold" class="bold">Are you holding employment offers?</label><span class="text-danger px-1">*</span>

		   <select name="hold" id="hold" class="form-control">

			   <option   value="1" @if(isset($user->getoffers()->hold)) @if($user->getoffers()->hold=="1") selected @endif  @endif >Yes</option>

			   <option  value="2" @if(isset($user->getoffers()->hold)) @if($user->getoffers()->hold=="2") selected @endif  @endif>No</option>

		   

		   </select>

		   

		   <span class="help-block pricing_type-error"></span> 

	   </div>

	   <div id="yesnohide" @if(isset($user->getoffers()->hold))@if($user->getoffers()->hold !="1")style="display:none" @endif @endif>

		

	   <div class="form-group newposition" id="div_expoff">

		<label for="expoff" class="bold">Reason for exploring opportunities despite having offers</label><span class="text-danger px-1">*</span>	

		

		

		{{-- @foreach($value as $k => $v)

 <div>{{ $k }} ({{ $v->count() }})</div>

@endforeach --}}

		

		

		<input type="text" class=" form-control newtest	" id="expoff" name="expoff" value="{{old('expoff',(isset($user->getoffers()->expoff))? $user->getoffers()->expoff:'') }}" required>

		<span class="help-block expoff-error"></span> 

	  </div>





	<div class="form-group" id="div_repoff">

		<label for="repoff" class="bold">Please mention the total offers you are holding</label><span class="text-danger px-1">*</span>		

		<input type="number" class=" form-control" id="repoff" name="repoff" value={{old('repoff',(isset($user->getoffers()->repoff))? $user->getoffers()->repoff:'1') }} readonly>

		<span class="help-block repoff-error"></span> 

	</div>

	

	<div class="form-group  " id="div_ctcoff1">

		<label for="ctcoff" class="bold">CTC Offered</label><span class="text-danger px-1">*</span>	

		<input type="number" class=" form-control newtest" id="ctcoff" name="ctcoff1" value="{{old('ctcoff1',isset($user->getoffers()->ctcoff1)) ? $user->getoffers()->ctcoff1 : ''}}" min="0" max="1000000">

		<span class="help-block ctcoff1-error"></span>

		</div>

		 <div class="form-group " id="div_dateoff1">

		<label for="dateoff" class="bold">Date of Joining</label><span class="text-danger px-1">*</span>	

		<input type="text" class=" form-control datepickerr newtest" id="dateoff" name="dateoff1" value="{{old('dateoff1',(isset($user->getoffers()->dateoff1)) ? Carbon\Carbon::parse($user->getoffers()->dateoff1)->format('d-m-Y'):'')}}">

		<span class="help-block dateoff1-error"></span>

		</div>

		 <div class="form-group " id="div_locoff1">

		<label for="locoff" class="bold">Location of Job Offer</label><span class="text-danger px-1">*</span>	

		<input type="text" class=" form-control newtest" id="autocomplete_offers_admin" name="locoff1" value="{{old('locoff',(isset($user->getoffers()->locoff1)) ? $user->getoffers()->locoff1 :'')}}">

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



		





{{-- new --}}

		<div id="inputFormRow">

			<div class="row" style="margin: 0">

			 <div class="form-group " id="div_ctcoff">

			<label for="ctcoff" class="bold">CTC Offered</label><span class="text-danger px-1">*</span>	

			<input type="number" class=" form-control" id="ctcoff" name="ctcoff[]" value="{{ $ctcoff[$key]  }}" min="0" max="1000000">

			<span class="help-block ctcoff-error"></span>

			</div>

			 <div class="form-group " id="div_dateoff">

			<label for="dateoff" class="bold">Date of Joining</label><span class="text-danger px-1">*</span>	

			<input type="text" class=" form-control datepickerr" id="dateoff" name="dateoff[]" value="{{ Carbon\Carbon::parse($dateoff[$key])->format('d-m-Y') }}">

			<span class="help-block dateoff-error"></span>

			</div>

			 <div class="form-group " id="div_locoff">

			<label for="locoff" class="bold">Location of Job Offer</label><span class="text-danger px-1">*</span>	

			<input type="text" class=" form-control" id="locoff" name="locoff[]" value="{{$locoff[$key]}}">

			<span class="help-block locoff-error"></span>

			</div>

			<div class="col-lg-3 newposition d-flex justify-content-center align-items-end" style="padding:15px 0 !important;">

			<button  type="button" class="btn btn-danger removeRow " style="margin-bottom: 3px;">Remove</button>

			</div>

			</div>

			</div>

		

	@endforeach

	@endif

	@endif

	<div class="row" style="padding-bottom: 15px;">

	   <div id="newRow"></div>

	

	      <div class="col-lg-1 newposition" style="margin-right:20px">

				   {{-- <label class="mb-2 newfont pt-3">Action<span class="text-danger px-1"> </span></label> --}}

				   <button id="addRow" type="button" class="btn btn-info">Add Offers List</button>

	      </div>

	   

	     

	</div>

	</div> 

	<div class="success" id="success_msg2" style="padding-bottom: 15px;"></div>	

		<div class="col-12" style="padding-bottom: 50px;">

		<button	button type="button" class="btn  btn-primary " style="float:left" onClick="submitoffers();">Update Offer <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>

		</div>

	</form>

	   </div>

	   <!--<div class="row">

		   <div class="col-lg newposition">

			   <label  class="mb-2 newfont pt-3">Reason for exploring opportunities despite having offer/s<span class="text-danger px-1"> </span></label>

			   <textarea class="w-100 signup_input new px-3 py-2"></textarea>

		   </div>

	   </div> -->





@push('css')

<style type="text/css">

    .datepicker>div {

        display: block;

    }

</style>

@endpush



@push('scripts') 

<script type="text/javascript">

    function submitoffers() {

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

     
			var form = $('#offers_in_hand');

$.ajax({

	url: form.attr('action'),

	type: form.attr('method'),

	data: form.serialize(),

	dataType: 'json',

	success: function (json) {
		//alert('cccvcv error');

		$("#success_msg2").show();

	// alert('success');
	  $('.help-block').hide();
	//   $("input.form-control.newtest").css("border-color","#000 !important"); 

	//   $("input.form-control.newtest").addClass('clearCSS'); 
	  $(".newtest").css("border-color","#ccc ");
	//   $("input.form-control.newtest").css("border-color","#ccc ");


		$("#success_msg2").html('<span class="text text-success">Offers updated successfully</span>');

		setTimeout(function() { $("#success_msg2").hide(); }, 5000);
	},

	error: function (json) {

		if (json.status === 422) {

			var resJSON = json.responseJSON;
		//	alert('error');

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


        } else {
           alert('Fill in all the data!');
        }



    }

    

    

	var count = 1;

	$("#addRow").click(function () {

		var countinc = count++;

		//while (count <= 1) {

		var html = '';

		html += '<div id="inputFormRow">';

		html += '<div class="row" style="margin: 0">';

		html += ' <div class="form-group col-lg-12" id="div_ctcoff">';

		html += '<label for="ctcoff" class="bold">CTC Offered</label>	';

		html += '<input type="number" class=" form-control" id="ctcoff" name="ctcoff[]" value=""  min="0" max="1000000">';

		html += '</div>';

		html += ' <div class="form-group col-lg-12" id="div_dateoff">';

		html += '<label for="dateoff" class="bold">Date of Joining</label>	';

		html += '<input type="text" class=" form-control datepicker7" id="dateoff" name="dateoff[]" data-datepicker>';

		html += '</div>';

		html += ' <div class="form-group col-lg-12" id="div_locoff">';

		html += '<label for="locoff" class="bold">Location of Job Offer</label>	';

		html += '<input type="text" class=" form-control myClass' + count + '"" id="locoff" name="locoff[]" value="">';

		html += '</div>';

		html += '<div class="col-lg-3 newposition d-flex justify-content-center align-items-end">';

		html += '<button  type="button" class="btn btn-danger removeRow " style="height: 42px;margin-bottom: 3px;">Remove</button>';

		html += '</div>';

		html += '</div>';

		html += '</div>';

		$('#newRow').append(html);

		var countdec = $("#newRow #inputFormRow").length;

		$("#repoff").val(countdec+1);

		$('.datepicker7').datepicker({
                clearBtn: true,
				format: 'dd-mm-yyyy'
            
            });

		//}
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
	show_submit_data(location);
	return false;
});

});

	});



	// remove row

	$(document).on('click', '.removeRow', function () {

		

		$(this).closest('#inputFormRow').remove();

		var countdec = $("#newRow #inputFormRow").length;

		

		$("#repoff").val(countdec+1);

	});

	

	$("#hold").change(function(){

 if(this.value==1){ $('#yesnohide').show();} else{ $('#yesnohide').hide(); }



});


$(".datepickerr").datepicker({

autoclose: true,
startDate: '01/01/2022',

        format: 'dd-mm-yyyy'

}); 

$(".datepicker5").datepicker({

autoclose: true,
startDate: '01/01/2022',

        format: 'dd-mm-yyyy'

});  


$location_input = $("#autocomplete_offers_admin");
    var options = {
        types: ['(cities)'],
        componentRestrictions: {
            country: 'IN'
        }
    };
    autocomplete = new google.maps.places.Autocomplete($location_input.get(0), options);    
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var data = $("#search_form").serialize();
        var location =  $("#autocomplete_offers_admin").val();
        location = location.split(',')[0];
      //  alert(location);
        $('#autocomplete_offers_admin').val(location);
        // $("#autocomplete12").append(location);
        console.log('blah')
      //  show_submit_data(location);
        return false;
    });
             

</script>




@endpush





</html>