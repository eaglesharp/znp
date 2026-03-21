
@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<style>
    @media (min-width:1200px) {

.header.dark {

position: fixed;

bottom: 0;

width: 100%;

}

}    
</style>
<body class="">
<br><br>

<div class=" text-center">
    <img src="{{asset('admin_assets/payment-failed4.png')}}" alt="" class="">
<h4 class="">Payment Failed<br></h4>
<br>
<p><a href="{{ url('employer-dashboard') }}" class="btn btn_style mx-auto mt-4">Go To Dashboard</a></p>
</div>
<br><br><br>
@include('includes.footer') 
@endsection