@extends('layouts.app')

@section('content')

<!-- Header start -->

@include('includes.header')

<!-- Header end --> 

<!-- Inner Page Title start -->



<!-- Inner Page Title end -->







<section class="section_emailverification align-items-center d-flex">

    <div class="container">

    <div class="col-md-8 col-xl-5 col-lg-6 px-sm-0 py-5 m-auto">

            <div class="box middle_verify rounded  p-4">

                <div class="">

                    <h4 class="sign_head text-center">Reset Password</h4>

                    <h6 class="verify_head text-center pt-1">Enter a email  and we will send you a link to reset your password</h6> 

                    

                    @if (session('status'))

                    <div class="alert alert-success">

                        {{ session('status') }}

                    </div>

                    @endif


                    <form class="form-horizontal" method="POST" action="{{ route('company.password.email') }}">

                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                <label for="email" class="col-12 control-label">{{__('Email Address')}} <span class="text-danger">*</span></label>

                                <div class="col-12">

                                    <input id="email" type="email" class="py-2 px-3 w-100 signin_input rounded" name="email" style="

                                    font-family: 'Proximanova-Regular';font-size: 16px;" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))

                                    <span class="help-block">

                                        <strong class="new_error_class">{{ $errors->first('email') }}</strong>

                                    </span>

                                    @endif

                                </div>

                            </div>

                            <div class="form-group">

                                <div class="col-12 pt-3">

                                    <button type="submit" class="w-100 py-2 signin_button rounded">

                                        {{__('Reset Password')}}

                                    </button>

                                </div>

                            </div>

                        </form>
                        <!-- <form class="text-center" method="POST" action="{{ route('company.password.email') }}">

                            {{ csrf_field() }}

                            <div class="col-lg-8 m-auto pt-1 sign_head">

                                {{-- <p class="sign_fontsize mb-2" >Email Address<span class="text-danger px-1">* </span></p> --}}

                            

                            {{-- <input type="email" placeholder="Enter your email address" requried class="py-2 px-3 w-100 signin_input rounded" maxlength="100"> 

                            --}}

                            

                            <input id="email" type="email" class="py-2 px-3 w-100 signin_input rounded" name="email" value="" required="" placeholder="Email Address" style="

                            font-family: 'Proximanova-Regular';font-size: 16px;">

                                        @if ($errors->has('email'))

                                        <span class="help-block">

                                            <strong>{{ $errors->first('email') }}</strong>

                                        </span>

                                        @endif

                    

                            </div>

                        <div class="pt-3"> <button type="submit" class="py-2 rounded signin_button px-3" >Send Verification Email</button></div>

                        </form> -->

                </div>

            </div>

        </div>

    </div>

</section>

@include('includes.footer')

@endsection