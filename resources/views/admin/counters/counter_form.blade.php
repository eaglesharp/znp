

{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')

<div class="form-body">  

<div class="form-group {!! APFrmErrHelp::hasError($errors, 'counter') !!}">



    

    <div class="counter">





    {!! Form::label('counter', 'NON IT IMMEDIATE HIRES', ['class' => 'bold']) !!} <span class="text-danger">*</span>

    <?php 

    

   

    ?>

    @foreach ($counter as $item)

       

    @endforeach

    <input type="hidden" id="" value="{{$item->id}}" name="counter_value">

    {!! Form::number('counter', $item->counter, array('class'=>'form-control', 'id'=>'counter', 'placeholder'=>'Enter the value')) !!}

    {!! APFrmErrHelp::showErrors($errors, 'counter') !!}

</div>



</div>



<div class="form-group {!! APFrmErrHelp::hasError($errors, 'counter1') !!}">

    <input type="hidden" id="" value="2" name="counter_value1">



    

    <div class="counter1">





    {!! Form::label('counter1', 'IT IMMEDIATE HIRES', ['class' => 'bold']) !!} <span class="text-danger">*</span>

    {!! Form::number('counter1', $item->counter1, array('class'=>'form-control', 'id'=>'counter1', 'placeholder'=>'Enter the value')) !!}

    {!! APFrmErrHelp::showErrors($errors, 'counter1') !!}

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