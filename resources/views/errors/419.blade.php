
@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
<style>
    section.not-found {
        height: calc(100vh - 146px);
    }
</style>
<section class="not-found d-flex align-items-center justify-content-center">
   <div>
    <div class="about-wraper"> 
        <!-- About -->
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                     <!--<h1>419</h1>-->
                    <h1>{{__('Page Expired')}}</h1>
                    <p class="mb-0">{{__('Please Refresh the page or login again')}}</p>
                    <a class="btn btn-primary" href="{{ url('employer-login') }}">Login</a>
                </div>      
            </div>
        </div>  
    </div>
   </div>
</section>
@include('includes.footer')
@endsection