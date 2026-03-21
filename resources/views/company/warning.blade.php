@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')

    <body class="">
        <br><br>
        <div class=" text-center">
            <img src="{{ asset('admin_assets/warning.png') }}" alt="image" class="" width="150" height="150">
            @if ($data['kyc_applied'] == 0)
                <h4 class="mt-2">Please submit KYC documents to purchase the resumes</h4>
            @endif
            @if ($data['status'] == 3)
                <h4 class="mt-2">Your KYC verification is rejected, Please resubmit documents.</h4>
            @endif
            @if ($data['status'] == 1)
                <h4 class="mt-2">Your KYC verification is being processed. Please wait until it has been completed.</h4>
                <h4> KYC verification will be completed within 6 hours. </h4>
            @endif
            <br>
            <p>
                <a class="btn btn-warning" href="{{ url('/employer-dashboard') }}">
                    @if ($data['status'] == 1)
                        <i class="fa fa-home"></i>
                        Dashboard
                    @else
                        <i class="fa fa-file"></i>
                        Submit KYC
                    @endif
                </a>
            </p>
        </div>
        @include('includes.footer')
    @endsection
