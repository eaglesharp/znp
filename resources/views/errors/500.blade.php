
@extends('layouts.app')
@section('content')
@include('includes.header')
<style>
    @media (min-width: 1200px) {
        section.not-found {
            height: calc(100vh - 130px);
        }
    }
</style>
<section class="not-found d-flex align-items-center justify-content-center py-4 py-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="{{ asset('public/asset/images/test1.png') }}" class="pb-4">
                <h1>{{__('Page Not Found')}}</h1>
                <p class="mb-0">{{__('Sorry, the page you are looking for could not be found')}}</p>
                <a href="{{ url('/') }}" class="btn btn_style mx-auto mt-4">Go Home</a>
            </div>      
        </div>
    </div>  
</section>
@include('includes.footer')
@endsection