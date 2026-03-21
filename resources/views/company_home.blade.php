@extends('layouts.app')

@section('content') 

<!-- Header start --> 

@include('includes.header') 

<!-- Header end --> 

<!-- Inner Page Title start --> 



<!-- Inner Page Title end -->

<div class="listpgWraper">

    <div class="container">@include('flash::message')

        <div class="row"> @include('includes.company_dashboard_menu')

    

        </div>

    </div>

</div>

@include('includes.footer')

@endsection

@push('scripts')

@include('includes.immediate_available_btn')

@endpush

