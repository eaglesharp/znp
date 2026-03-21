

@extends('layouts.app')

@section('content')

<!-- Header start -->

@include('includes.header')

<!-- Header end --> 

<!-- Inner Page Title start -->

<section class="section_emailverification align-items-center d-flex">

    <div class="container">

        <div class="col-12 col-md-10 col-lg-7 col-xl-7 mx-auto ">

            <div class="box middle_verify rounded  p-4">

                <div class="">

                    <h4 class="sign_head text-center">Email Verification</h4>

                    <h6 class="verify_head text-center pt-1">Please click the button below to verify your email </h6>

                    <form class="text-center" action="{{url('email-verify-user',$user->id)}}" method="POST">

                    @csrf

                        <div class="col-lg-8 m-auto pt-1 sign_head">

                            <!-- <input type="email" placeholder="Enter your email address" requried class="py-2 px-3 w-100 signin_input rounded" maxlength="100"> -->

                            {{$user->email}}

                          

                        </div>

                       <div class="pt-3"> <button type="submit" class="py-2 rounded signin_button px-3" >Send Verification Email</button></div>
                       <br>

                       @if(session()->has('success'))
                       <div class="alert alert-success">
                           {{session()->get('success')}}

                       </div>
                       @endif


                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

@include('includes.footer')

@endsection



