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
            .img-class {
                width: 170px;
            }

        }
    </style>

    <body class="">
        <br><br>
        <div class=" text-center container">
            <img src="{{ asset('admin_assets/payment-success3.png') }}" alt="" class="img-class">
            <h4 class="my-3">“Thank you for confirmation of your email address.”</h4>
            <p>
                <a href="{{ url('employer-login') }}" class="btn btn_style mx-auto mt-4">Login</a>
            </p>
        </div>
        @include('includes.footer')
    @endsection
