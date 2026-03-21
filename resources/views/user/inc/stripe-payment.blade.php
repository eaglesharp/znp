

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

@php 

$orginal_amount = 499;

$total_amount = ($orginal_amount + ($orginal_amount * 18) / 100);


@endphp

<body class="">
<section class="p-sm-4 py-4 p-md-5">
    <div class="container">
  <div class="row d-flex justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-8">
      <div class="card rounded-3" style="background-color: #f6faff;">
        <div class="card-body p-4">
          <form method="post" action="{{ route('stripeSubmit') }}">
              <div class="d-sm-flex justify-content-between align-items-center border-bottom pb-4 mb-4">
                  
                  
                   @csrf
                   
                   
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="text-center mb-0 pr-2" style="font-family: proximanova-bold;">Powered by</h1>
                    <img src="{{asset('asset/images/stripe-logo.png')}}" alt="" class="">
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="text-center mb-0 pr-2" style="font-family: proximanova-bold;">Secure Payment</h1>
                    <img src="{{asset('asset/images/protect1.png')}}" alt="" class="pr-2">
                    <img src="{{asset('asset/images/3d-secure.png')}}" alt="" class="">
                </div>
            </div>
             <div class="px-3 py-4 border border-primary border-2 rounded mt-4 d-sm-flex justify-content-between mb-4">
              <div class="d-flex flex-row align-items-center">
                <div class="d-flex flex-column ms-4">
                  <span class="h5 mb-1">Xpress Job Seeker</span>
                </div>
              </div>
              <div class="d-flex flex-row align-items-center">
                <h3 class="h2 mx-1 mb-0">&#x20b9;</h3>
                <span class="h2 mx-1 mb-0">{{ $total_amount??'' }}</span>
              </div>
            </div>
            <div class="form-outline mb-md-4">
                <label class="form-label pt-1 pt-md-0" for="formControlLgXsd">Card Holder Name</label>
              <input type="text" id="formControlLgXsd" class="form-control form-control-lg"
                placeholder="Enter Name" />
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-outline">
                    <label class="form-label pt-1 pt-md-0" for="formControlLgXsd">Card Number</label>
                  <div class="input-group"> <input type="text" name="card_no" placeholder="1234 5678 1234 5678" class="form-control form-control-lg mobile" required>
                    <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fa fa-credit-card-alt mx-1"></i></span> </div>
                    </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                    <label class="form-label pt-1 pt-md-0" for="formControlLgXsd">Expire Date / Month</label>
                   <div class="row">
                        <div class="form-outline col-6">
                          <input type="tel" id="formControlLgExpk" class="form-control form-control-lg mobile" name="exp_month"required
                            placeholder="MM" />
                        </div>
                        <div class="form-outline col-6">
                          <input type="tel" id="formControlLgExpk" class="form-control form-control-lg mobile" name="exp_year" required
                            placeholder="YYYY" />
                    </div>
                </div>
              </div>
              <div class="col-6 col-md-2">
                <div class="form-outline">
                <label class="form-label pt-1 pt-md-0" for="formControlLgXsd">CVV</label>
                  <input type="password" id="formControlLgcvv" class="form-control form-control-lg mobile" name="cvc" required
                    placeholder="CVV" />
                </div>
              </div>
              <div class="col-12 pt-4 pt-sm-5">
                  
                 <button class="btn btn-success btn-lg btn-block" style="    background-color: #0642a9;">Pay Now</button>
              </div>
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

<!--<div class="container py-4 py-sm-5 my-xl-3">-->
<!--    <div class="col-lg-7 col-lg-6 mx-auto px-0 ">-->
<!--        <div class="contact_info-color p-4 p-sm-5">-->
<!--                <div class="d-flex justify-content-center align-items-center border-bottom pb-4 mb-4">-->
<!--                    <h6 class="text-center mb-0 pr-2" style="font-family: proximanova-bold;">Powered by</h1>-->
<!--                    <img src="{{asset('asset/images/stripe-logo.png')}}" alt="" class="">-->
<!--                </div>-->
<!--               <form method="post" action="{{ route('stripeSubmit') }}" class="row">-->
<!--                <input type="hidden" name="amount" value="100">-->
<!--                <input type="hidden" name="currency" value="INR">-->
<!--                @csrf-->
            
                
<!--                <div class="col-12">-->
<!--                    <div class="mb-3">-->
<!--                        <label for="card_no" class="col-form-label">Card No</label>-->
<!--                        <div class="">-->
<!--                            <input type="text" id="card_no" class="form-control" name="card_no" required>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-6">-->
<!--                    <div class="mb-3">-->
<!--                        <label for="exp_month" class="col-form-label">Card Exp. month</label>-->
<!--                        <div class="">-->
<!--                            <input type="tel" id="exp_month" class="form-control" name="exp_month" required>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-6">-->
<!--                    <div class="mb-3">-->
<!--                        <label for="exp_year" class="col-form-label">Card Exp. year</label>-->
<!--                        <div class="">-->
<!--                            <input type="tel" id="exp_year" class="form-control" name="exp_year" required>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-12">-->
<!--                    <div class="mb-3">-->
<!--                        <label for="cvc" class="col-form-label">CVV</label>-->
<!--                        <div class="">-->
<!--                            <input type="tel" id="cvc" class="form-control" name="cvc" required>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                
<!--                <div class="col-12 text-center pt-4">-->
                    
<!--                     <input type="submit" name="Submit" class="btn btn-primary px-5 py-2" value="Pay Now">-->
                     
                     
<!--                     @if (\Session::has('error'))-->
<!--                        <div class="alert alert-danger mt-3">-->
<!--                            {!! \Session::get('error') !!}-->
                           
<!--                        </div>-->
<!--                    @endif-->
<!--                    </div>-->
         
               
<!--            </form>-->
<!--            </div>-->
<!--</div>-->
<!--</div>-->
@push('scripts')
<script>
    $(".mobile").bind('keyup blur',function(e){$(this).val($(this).val().replace(/[^0-9]/g,''));});
</script>
@endpush
@include('includes.footer') 



@endsection