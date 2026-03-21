

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

    

    <a class="btn btn_style mx-auto mt-4"  href="{{ url('my-profile') }}"> Go To Dashboard  
</a></p>

</div>

@include('includes.footer') 



@endsection