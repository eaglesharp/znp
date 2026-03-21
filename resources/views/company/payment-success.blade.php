
@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<body class="">
<br><br>

<div class=" text-center">
    <img src="{{asset('admin_assets/payment-success3.png')}}" alt="" class="">
<h4 class="">Thank you for payment<br></h4>
<br>
<p><a class="btn btn-warning"  href="{{ url('/') }}"> Go To Dashboard  
<i class="fa fa-window-restore "></i></a></p>
</div>
@include('includes.footer') 

@endsection