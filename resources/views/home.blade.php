@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 
@include('includes.user_dashboard_menu')


@include('includes.footer')
@endsection
@push('scripts')

@endpush