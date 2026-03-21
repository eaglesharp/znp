
{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">  
<div class="form-group {!! APFrmErrHelp::hasError($errors, 'education') !!}">
<div class="education">

<label class = 'bold'>Select Education</label>
<select id="country" name="education_id" class="form-control">
    <option value="" selected disabled>Select Education</option>
     @foreach($education as $education)
     <option value="{{$education->id}}"> {{$education->education}}</option>
     @endforeach
     </select>
    </div><br>
    
    <div class="course">


    {!! Form::label('course', 'Course', ['class' => 'bold']) !!}
    {!! Form::text('course', null, array('class'=>'form-control', 'id'=>'course', 'placeholder'=>'course')) !!}
    {!! APFrmErrHelp::showErrors($errors, 'course') !!}
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