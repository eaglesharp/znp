
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
    <img src="{{asset('admin_assets/payment-success3.png')}}" alt="" class="">
<h4 class="">Thank you for payment<br></h4>
<br>
<p>  
@if(session()->has('user_id_data'))

<a href="{{ route('candidate.profile2', ['id' => session('user_id_data')]) }}" class="btn btn_style mx-auto mt-4">Go To Profile</a>

@else

<a href="{{ url('employer-dashboard') }}" class="btn btn_style mx-auto mt-4">Go To Dashboard</a>

@endif

</p>
</div>
@include('includes.footer') 

@endsection