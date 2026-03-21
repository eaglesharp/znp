

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

    $orginal_amount = 499;

    $total_amount_data = ($orginal_amount + ($orginal_amount * 18) / 100);

    $t_amount = ceil($total_amount_data);

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
                      <form action="{{ url('layoffpaysuccess') }}" method="POST">
                        @csrf


                        <input type="hidden" name="total_amount" value="{{ $total_amount_data }}">
                       <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button other1"
                    data-key="pk_test_51Lzb0fCxL0XaBr6cnmX7e8tDBdeUAIyZAmGr3grKlqjjXtD5PxvK2Nx5CfhQ4ymnnFoS8PFkqJGa9TAfWaZPhATX009itSyy4w"
                    data-amount="{{$total_amount_data * 100}}"
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