@extends('layouts.app')

@section('content')

<!-- Header start -->

@include('includes.header')

<!-- Header end --> 

<!-- Inner Page Title start -->

{{-- @include('includes.inner_page_title', ['page_title'=>'Reset Password']) --}}

<!-- Inner Page Title end -->

<div class="section_signin listpgWraper">

    <div class="container">

        <div class="row">

    <div class="col-md-8 col-xl-5 col-lg-6 px-sm-0 py-5 m-auto">
            <div class="box py-4 rounded">
                <div class="panel panel-default">
                    <h5 class="sign_head text-center pt-3 my-0">{{__('Reset Password')}}</h5>

                    <div class="panel-body">

                        <form class="form-horizontal px-3 px-sm-5 py-3" method="POST" action="{{ route('company.password.request') }}">

                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                <label for="email" class="col-12 control-label">{{__('Email Address')}} <span class="text-danger">*</span></label>

                                <div class="col-md-12">

                                    <input id="email" type="email" class="w-100 py-2 px-3 signin_input rounded" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))

                                    <span class="help-block">

                                        <strong class="new_error_class">{{ $errors->first('email') }}</strong>

                                    </span>

                                    @endif

                                </div>

                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                <label for="password" class="col-12 control-label">{{__('Password')}} <span class="text-danger">*</span></label>

                                <div class="col-md-12">

                                    <input id="password" type="password" class="w-100 py-2 px-3 signin_input rounded" name="password" required>

                                    @if ($errors->has('password'))

                                    <span class="help-block">

                                        <strong class="new_error_class">{{ $errors->first('password') }}</strong>

                                    </span>

                                    @endif

                                </div>

                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                                <label for="password-confirm" class="col-12 control-label">{{__('Confirm Password')}} <span class="text-danger">*</span></label>

                                <div class="col-md-12">

                                    <input id="password-confirm" type="password" class="w-100 py-2 px-3 signin_input rounded" name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))

                                    <span class="help-block">

                                        <strong class="new_error_class">{{ $errors->first('password_confirmation') }}</strong>

                                    </span>

                                    @endif

                                </div>

                            </div>

                            <div class="form-group">

                                <div class="col-md-12 text-center pt-3">

                                    <button type="submit" class="w-100 py-2 signin_button rounded">

                                        {{__('Reset Password')}}

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
    </div>
</div>

@include('includes.footer')

@endsection