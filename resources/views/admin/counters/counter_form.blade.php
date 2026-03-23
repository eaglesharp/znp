

{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')

<div class="form-body">

    @foreach ($counter as $item) @endforeach
    <input type="hidden" value="{{ $item->id }}" name="counter_value">

    {{-- ─── Existing counters ─── --}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'counter') !!}">
                {!! Form::label('counter', 'NON IT IMMEDIATE HIRES', ['class' => 'bold']) !!} <span class="text-danger">*</span>
                {!! Form::number('counter', $item->counter, ['class' => 'form-control', 'id' => 'counter', 'placeholder' => 'Enter the value']) !!}
                {!! APFrmErrHelp::showErrors($errors, 'counter') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'counter1') !!}">
                {!! Form::label('counter1', 'IT IMMEDIATE HIRES', ['class' => 'bold']) !!} <span class="text-danger">*</span>
                {!! Form::number('counter1', $item->counter1, ['class' => 'form-control', 'id' => 'counter1', 'placeholder' => 'Enter the value']) !!}
                {!! APFrmErrHelp::showErrors($errors, 'counter1') !!}
            </div>
        </div>
    </div>

    <hr>
    <h4 class="bold" style="margin: 16px 0 20px;">Home Page Stats Bar</h4>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'active_jobs') !!}">
                {!! Form::label('active_jobs', 'Active Jobs', ['class' => 'bold']) !!} <span class="text-danger">*</span>
                {!! Form::number('active_jobs', $item->active_jobs, ['class' => 'form-control', 'placeholder' => 'e.g. 122']) !!}
                {!! APFrmErrHelp::showErrors($errors, 'active_jobs') !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'permanent_jobs') !!}">
                {!! Form::label('permanent_jobs', 'Permanent Jobs', ['class' => 'bold']) !!} <span class="text-danger">*</span>
                {!! Form::number('permanent_jobs', $item->permanent_jobs, ['class' => 'form-control', 'placeholder' => 'e.g. 117']) !!}
                {!! APFrmErrHelp::showErrors($errors, 'permanent_jobs') !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'contract_jobs') !!}">
                {!! Form::label('contract_jobs', 'Contract Jobs', ['class' => 'bold']) !!} <span class="text-danger">*</span>
                {!! Form::number('contract_jobs', $item->contract_jobs, ['class' => 'form-control', 'placeholder' => 'e.g. 7']) !!}
                {!! APFrmErrHelp::showErrors($errors, 'contract_jobs') !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'fresher_jobs') !!}">
                {!! Form::label('fresher_jobs', 'Fresher Jobs', ['class' => 'bold']) !!} <span class="text-danger">*</span>
                {!! Form::number('fresher_jobs', $item->fresher_jobs, ['class' => 'form-control', 'placeholder' => 'e.g. 32']) !!}
                {!! APFrmErrHelp::showErrors($errors, 'fresher_jobs') !!}
            </div>
        </div>
    </div>

    <div class="form-actions">
        {!! Form::button('Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', ['class' => 'btn btn-large btn-primary', 'type' => 'submit']) !!}
    </div>

</div>

@if(session()->has('success'))
    <div class="alert alert-success">{{ session()->get('success') }}</div>
@endif

@push('scripts')
@endpush
