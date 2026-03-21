<h5>{{__('Collections')}}</h5>
@if(isset($collection))
{!! Form::model($collection, array('method' => 'post', 'route' => array('update.collection', $collection->id), 'class' => 'form')) !!}
{!! Form::hidden('id', $collection->id) !!}
@else
{!! Form::open(array('method' => 'post', 'route' => array('store.collection'), 'class' => 'form')) !!}
@endif
<div class="row">  
    @if(isset($collection))
    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'name') !!}"> {!! Form::text('name', $collection->name, array('class'=>'form-control', 'id'=>'name', 'placeholder'=>__('Title'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'name') !!} </div>
    </div>
    @else
    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'name') !!}"> {!! Form::text('name', null, array('class'=>'form-control', 'id'=>'name', 'placeholder'=>__('Title'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'name') !!} </div>
    </div>
    @endif
    
	
	
    <div class="col-md-12">
        <div class="formrow">
            <button type="submit" class="btn">{{__('Save')}} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
        </div>
    </div>
</div>
<input type="file" name="image" id="image" style="display:none;" accept="image/*"/>
{!! Form::close() !!}
<hr>
@push('styles')
<style type="text/css">
    .datepicker>div {
        display: block;
    }
</style>
@endpush
@push('scripts')
@include('includes.tinyMCEFront')
<script type="text/javascript">
    $(document).ready(function () {
        // $('.select2-multiple').select2({
        //     placeholder: "{{__('Select Required Skills')}}",
        //     allowClear: true
        // });
        // $(".datepicker").datepicker({
        //     autoclose: true,
        //     format: 'yyyy-m-d'
        // });
        // $('#country_id').on('change', function (e) {
        //     e.preventDefault();
        //     filterLangStates(0);
        // });
        // $(document).on('change', '#state_id', function (e) {
        //     e.preventDefault();
        //     filterLangCities(0);
        // });
        // filterLangStates(<?php echo old('state_id', (isset($job)) ? $job->state_id : 0); ?>);
    });
    // function filterLangStates(state_id)
    // {
    //     var country_id = $('#country_id').val();
    //     if (country_id != '') {
    //         $.post("{{ route('filter.lang.states.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
    //                 .done(function (response) {
    //                     $('#default_state_dd').html(response);
    //                     filterLangCities(<?php echo old('city_id', (isset($job)) ? $job->city_id : 0); ?>);
    //                 });
    //     }
    // }
    // function filterLangCities(city_id)
    // {
    //     var state_id = $('#state_id').val();
    //     if (state_id != '') {
    //         $.post("{{ route('filter.lang.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
    //                 .done(function (response) {
    //                     $('#default_city_dd').html(response);
    //                 });
    //     }
    // }
</script> 
@endpush