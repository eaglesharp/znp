
{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">  
<div class="form-group {!! APFrmErrHelp::hasError($errors, 'education') !!}">
<div class="education">

<label class = 'bold'>Select Courses</label>
<select id="country" name="course_id" class="form-control">
    <option value="" selected disabled>Select Courses</option>
     @foreach($courses as $course)
     <option value="{{$course->id}}"> {{$course->course}}</option>
     @endforeach
     </select>
    </div><br>
    
    <div class="course">


    {!! Form::label('Specs', 'Specilization', ['class' => 'bold']) !!}
    {!! Form::text('specs', null, array('class'=>'form-control', 'id'=>'Specs', 'placeholder'=>'Specs')) !!}
    {!! APFrmErrHelp::showErrors($errors, 'specs') !!}
</div>

</div>
<div class="form-actions">
    {!! Form::button('Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!}
</div>
</div>

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
@push('scripts')

@endpush    