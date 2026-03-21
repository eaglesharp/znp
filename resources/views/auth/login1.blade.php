@extends('layouts.app')

@section('content')

<!-- Header start -->

@include('includes.header')



<section class="section_signin">

    <div class="container">

        <div class="col-md-8 col-xl-5 col-lg-6 px-0 py-5 m-auto">

            <div class="box py-4 rounded">

                <h5 class="sign_head text-center my-0 pt-3" >Sign In As An<span class=" sign_color"> Employer</span></h5>

                

                {{-- <form class="form-horizontal" method="POST" action="{{ route('company.login') }}">

                    {{ csrf_field() }}

                    <input type="hidden" name="candidate_or_employer" value="employer" />

                    <div class="formpanel">

                        <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">

                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="{{__('Email Address')}}">

                            @if ($errors->has('email'))

                            <span class="help-block">

                                <strong>{{ $errors->first('email') }}</strong>

                            </span>

                            @endif

                        </div>

                        <div class="formrow{{ $errors->has('password') ? ' has-error' : '' }}">

                            <input id="password" type="password" class="form-control" name="password" value="" required placeholder="{{__('Password')}}">

                            @if ($errors->has('password'))

                            <span class="help-block">

                                <strong>{{ $errors->first('password') }}</strong>

                            </span>

                            @endif

                        </div>            

                        <input type="submit" class="btn" value="{{__('Login')}}">

                    </div>

                    <!-- login form  end--> 

                </form> --}}

                <form class="px-5 py-3" method="POST" action="{{ route('company.login') }}">

                    {{ csrf_field() }}

       

                    <p class="sign_fontsize mb-2" >Email ID<span class="text-danger px-1">* </span></p>

                  

                    <input type="email" class="w-100 py-2 px-3 signin_input rounded" name="email" value="{{ old('email') }}" placeholder="Enter Email" maxlength="100"  >

                    @if ($errors->has('email')) <span class="help-block" style="color: red"> {{ $errors->first('email') }} </span> @endif

                    

                    

                    

                    @if(session()->has('error_message1'))



                    <span style="color: #ff0000">

                    

                        {{ session()->get('error_message1') }}

                    

                    </span>

                    

                    @endif



                    @if(session()->has('error_message'))



<div class="alert alert-danger" style="margin-top: 11px">



{{ session()->get('error_message') }}



</div>



@endif

                    

                    <p class=" sign_fontsize mb-2 pt-4">Password<span class="text-danger px-1">* </span></p>

             



                    <input type="password" class="w-100 py-2 px-3 signin_input rounded" name="password" value="" placeholder="Enter your password" maxlength="100"  >

                    @if ($errors->has('password')) <span class="help-block" style="color: red"> {{ $errors->first('password') }} </span> @endif

                    <div class="py-4  row">

                        <div class="col-md-6 pl-2">

                            <input type="checkbox" id="remember" class="checkbox_size mt-0" maxlength="100" requried>

                            <label for="remember" class="mb-0 align-top sign_fontsize" >Remember me</label>

                            </input>

                        </div>

                        <div class="col-md-6 signin_forgot sign_fontsize pt-2 pt-md-0">

                            <a href="{{route('company.password.request')}}">Forgot password ?</a>

                        </div>

                    </div>

                    <button type="submit" class="w-100 py-2 signin_button rounded" >Sign in</button>

                     <div class="text-center pt-4 sign_fontsize">Don't have an account?<a class="px-2" href="{{route('company.register.page')}}">Sign up</a>


                    <div class="text-center pt-4 sign_fontsize">Sign in as Jobseeker <a class="px-2" href="{{route('login')}}">Sign in</a>

                </form>

            </div>

        </div>

    </div>

</section>

@include('includes.footer')

@endsection

