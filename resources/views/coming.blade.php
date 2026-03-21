

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

.coming-soon h4{
    font-size: 35px;
}





</style>

<body class="">


<section class="coming-soon py-5">
<div class="text-center py-5">
    <img src="{{ asset('images/coming-soon.png')}}" alt="coming-soon" class="img-fluid">
    <h4 class="pt-5">Employer services will begin soon. <br> We will alert you!</h4>
</div>
</section>


@include('includes.footer') 



@endsection