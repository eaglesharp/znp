
{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">  
<div class="form-group {!! APFrmErrHelp::hasError($errors, 'education') !!}">
    {!! Form::label('education', 'Education', ['class' => 'bold']) !!}
    {!! Form::text('education', null, array('class'=>'form-control', 'id'=>'education', 'placeholder'=>'Education')) !!}
    {!! APFrmErrHelp::showErrors($errors, 'education') !!}
</div>
<div class="form-actions">
    {!! Form::button('Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!}
</div>
</div>
@push('scripts')

@endpush