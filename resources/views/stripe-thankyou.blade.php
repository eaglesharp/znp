

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

  @media (max-width:546px) {

.img-class{
    width:170px;
}

}  

</style>

<body class="">

<br><br>



<div class=" text-center container">

    <img src="{{asset('admin_assets/payment-success3.png')}}" alt="" class="img-class">
    


<h4 class="my-3">“Thank You for purchasing. An Invoice has been sent to your registered Email ID. Please check all the mail folders”</h4>


<p>

    




@if(session()->has('employer_plan_payment'))

<a href="{{ url('employer-dashboard') }}" class="btn btn_style mx-auto mt-4">Go To Dashboard</a>

@else

    <a class="btn btn_style mx-auto mt-4"  href="{{ url('my-profile') }}"> Go To Dashboard  
</a>


@endif

</p>

</div>

@include('includes.footer') 



@endsection