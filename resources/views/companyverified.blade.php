


@extends('layouts.app')
@section('content')
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
<div class="container">
<div class="row align-items-center">
<div class="col-12" style="margin:auto;text-align:center;margin-top:20px">
    {{-- <i class="fas fa-check" style="color:green;margin-top:10px"></i> --}}
    <img class="pb-1" src="{{ asset('/') }}asset/images/verified3.jpg">
<h2 class="py-2">

     Success</h2>
<p class="mb-4">Your email has been verified</p>


{{-- <a class="navbar-brand pr-sm-3" href="{{route('home')}}"><img src="{{asset('/')}}asset/images/logo.png"></a> --}}


<a href="{{route('update.profile')}}" class="btn btn-success">Go to Profile</a>


 </div>
</div>
</div>
@include('includes.footer')
@endsection
@push('scripts') 

@endpush
