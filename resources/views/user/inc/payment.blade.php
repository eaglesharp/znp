

@extends('layouts.app')

@section('content') 

<!-- Header start --> 

@include('includes.header') 

<style>
    .stripe-button-el
    {
        display: none!important;
    }
  </style>
@php 

$orginal_amount = 299;

$total_amount = ($orginal_amount + ($orginal_amount * 18) / 100);


@endphp
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <section class="py-5">
          <div class="container">
              <center>
                  <div class="thank-content">
                      <br>
                      <br>
                      <h1>Please Wait</h1>
                      <p>Transaction processing....</p>
                      <form action="{{ url('paysuccess') }}" method="POST">
                        @csrf


                        <input type="hidden" name="total_amount" value="{{ $total_amount }}">
                       <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button other1"
                    data-key="pk_test_51MZyciSIpW7etStiDCnZfjSBjo5cwAKzXWCnu7WHGwVPeeD3A16NnaYs0aL5eLpdhwuu1GgWj5W2l3OH3ykUPXEi00oSjAFfnA"
                    data-amount="{{$total_amount * 100}}"
                    data-name="ZeroNoticePeriod"
                    data-description="test"
                    data-image="{{ asset('asset/images/logo2.png') }}"
                    data-locale="auto"
                    data-currency="INR">
                    </script>
                    </form>
                       <br>
                      <br>
                      <br>
                      <br>
                      <br>
  
                  </div>
              </center>
          </div>
      </section>
  
  

  

{{-- @include('includes.footer') --}}

@push('scripts') 
  
<script>
    $(document).ready(function(){

        $(".stripe-button-el").trigger('click');
    });
    </script>


@endpush

@endsection