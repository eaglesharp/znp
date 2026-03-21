@extends('layouts.app')



@section('content')
    <!-- Header start -->

    @include('includes.header')

    <style>
        @media (min-width:1400px) {



            .header.dark {



                position: fixed;



                bottom: 0;



                width: 100%;



            }



        }
    </style>


    <body class="">
        <section class="p-sm-4 py-4 p-md-5">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-8">
                        <a href="{{ url('/employer-dashboard') }}">
                            <p style="color:red;">
                                @if ($employer->kyc_verified == 0)
                                    Please submit KYC documents to purchase. Please click here to submit documents.
                                @elseif ($employer->kyc_verified == 1)
                                    Your KYC verification is being processed. Please wait until it has been
                                    completed.
                                    KYC verification will be completed within 6 hours.
                                @elseif ($employer->kyc_verified == 3)
                                    Your KYC verification is rejected, Please click here to resubmit documents.
                                @endif
                            </p>
                        </a>
                        <div class="card rounded-3" style="background-color: #f6faff;">
                            <div class="card-body p-4">
                                <form method="post" action="{{ route('employer.submit') }}">
                                    <div
                                        class="d-sm-flex justify-content-between align-items-center border-bottom pb-4 mb-4">

                                        <input type="hidden" name="amount" value="{{ $total_amount }}">
                                        <input type="hidden" name="currency" value="INR">
                                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                                        @csrf


                                        <div class="d-flex justify-content-center align-items-center">
                                            <h6 class="text-center mb-0 pr-2" style="font-family: proximanova-bold;">Powered
                                                by</h1>
                                                <img src="{{ asset('asset/images/stripe-logo.png') }}" alt=""
                                                    class="">
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <h6 class="text-center mb-0 pr-2" style="font-family: proximanova-bold;">Secure
                                                Payment</h1>
                                                <img src="{{ asset('asset/images/protect1.png') }}" alt=""
                                                    class="pr-2">
                                                <img src="{{ asset('asset/images/3d-secure.png') }}" alt=""
                                                    class="">
                                        </div>
                                    </div>
                                    <div
                                        class="px-3 py-4 border border-primary border-2 rounded mt-4 d-sm-flex justify-content-between mb-4">
                                        <div class="d-flex flex-row align-items-center">
                                            <div class="d-flex flex-column ms-4">
                                                <span class="h5 mb-1">{{ $package->package_title }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center">
                                            <h3 class="h2 mx-1 mb-0">&#x20b9;</h3>
                                            <span class="h2 mx-1 mb-0">{{ $total_amount ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div class="form-outline mb-md-4">
                                        <label class="form-label pt-1 pt-md-0" for="formControlLgXsd">Card Holder
                                            Name</label>
                                        <input type="text" id="formControlLgXsd" class="form-control form-control-lg"
                                            placeholder="Enter Name" />
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-outline">
                                                <label class="form-label pt-1 pt-md-0" for="formControlLgXsd">Card
                                                    Number</label>
                                                <div class="input-group"> <input type="text" name="card_no"
                                                        placeholder="1234 5678 1234 5678"
                                                        class="form-control form-control-lg mobile" required>
                                                    <div class="input-group-append"> <span
                                                            class="input-group-text text-muted"> <i
                                                                class="fa fa-credit-card-alt mx-1"></i></span> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <label class="form-label pt-1 pt-md-0" for="formControlLgXsd">Expire Date /
                                                Month</label>
                                            <div class="row">
                                                <div class="form-outline col-6">
                                                    <input type="tel" id="formControlLgExpk"
                                                        class="form-control form-control-lg mobile" name="exp_month"required
                                                        placeholder="MM" />
                                                </div>
                                                <div class="form-outline col-6">
                                                    <input type="tel" id="formControlLgExpk"
                                                        class="form-control form-control-lg mobile" name="exp_year" required
                                                        placeholder="YYYY" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <div class="form-outline">
                                                <label class="form-label pt-1 pt-md-0" for="formControlLgXsd">CVV</label>
                                                <input type="password" id="formControlLgcvv"
                                                    class="form-control form-control-lg mobile" name="cvc" required
                                                    placeholder="CVV" />
                                            </div>
                                        </div>
                                        @if ($employer->kyc_verified == 2)
                                            <div class="col-12 pt-4 pt-sm-5">
                                                <button class="btn btn-success btn-lg btn-block"
                                                    style="background-color: #0642a9;">Pay Now</button>
                                            </div>
                                        @endif
                                    </div>
                                    @if (\Session::has('error'))
                                        <div class="alert alert-danger mt-3">
                                            {!! \Session::get('error') !!}

                                        </div>
                                    @endif

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        @push('scripts')
            <script>
                $(".mobile").bind('keyup blur', function(e) {
                    $(this).val($(this).val().replace(/[^0-9]/g, ''));
                });
            </script>
        @endpush
        @include('includes.footer')
    @endsection
