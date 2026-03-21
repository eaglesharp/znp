<?php
$keyskill=\App\JobSkill::all();
$city=\App\User::all();
//  $t4=(isset($skill) ? $skill->keyskill:'');
//  echo $skill
?>


<form action="{{route('welcome.search')}}" method="post" >
@csrf
<div class="row space_2 pb-5">
	<div class="col-lg position_lit">
		<select name="skills[]" multiple class="select_skills form_control pl-3 pr-5">
			<option value="">Choose by Skills</option>
			@foreach($keyskill as $skill)
				<option value="{{$skill->id}}">{{$skill->job_skill}}</option>
			@endforeach


		</select>
	</div>
	<div class="col-lg position_lit">
		<select name="location" class="form_control form_action rounded pl-3 pr-5" >
			<option selected disabled>Choose by Location</option>
			@foreach($city as $city)
				@if($city)
					<option value="{{$city->current_location}}">{{$city->current_location}}</option>
				@endif
			@endforeach
		</select>
	</div>
	<div class="col-lg position_lit">
		<select class="form_control form_action rounded pl-3 pr-5" name="notice_period">
			<option selected disabled>Choose by Notice Period</option>
			<option value="1">Immediately Available</option>
			<option value="2">Serving Notice Period</option>
			<option value="3">Buyable Notice Period</option>
			<option value="4">Not Under Notice Period</option>
		</select>
	</div>
	<div class="col-lg-2 box">
		<button type="submit" class="btn btn_submit w-100 text-light">Submit</button>
	</div>
</div>
</form>