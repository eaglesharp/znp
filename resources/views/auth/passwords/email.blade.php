@extends('layouts.app')

@section('content')

<!-- Header start -->

@include('includes.header')

<!-- Header end --> 

<!-- Inner Page Title start -->

<section class="section_emailverification align-items-center d-flex">

    <div class="container">

    <div class="col-md-8 col-xl-5 col-lg-6 px-sm-0 py-5 m-auto">

            <div class="box middle_verify rounded  p-4">

                <div class="">

                    <h4 class="sign_head text-center">Reset Password</h4>

                    <h6 class="verify_head text-center py-1"> Enter a email  and we will send you a link to reset your password</h6>

                    <div class="panel-body">

                        @if (session('status'))

                        <div class="alert alert-success">

                            {{ session('status') }}

                        </div>

                        @endif

                        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">

                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                <label for="email" class="col-12 control-label">{{__('Email Address')}} <span class="text-danger">*</span></label>

                                <div class="col-12">

                                    <input id="email" type="email" class="py-2 px-3 w-100 signin_input rounded" name="email" style="

                                    font-family: 'Proximanova-Regular';font-size: 16px;" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))

                                    <span class="new_error_class">

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

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- Inner Page Title end -->

{{-- <div class="listpgWraper">

    <div class="container">

        <div class="row">

            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">

                    <div class="panel-heading">{{__('Reset Password')}}</div>

                    <div class="panel-body">

                        @if (session('status'))

                        <div class="alert alert-success">

                            {{ session('status') }}

                        </div>

                        @endif

                        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">

                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                <label for="email" class="col-md-4 control-label">{{__('Email Address')}}</label>

                                <div class="col-md-6">

                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))

                                    <span class="help-block">

                                        <strong>{{ $errors->first('email') }}</strong>

                                    </span>

                                    @endif

                                </div>

                            </div>

                            <div class="form-group">

                                <div class="col-md-6 col-md-offset-4">

                                    <button type="submit" class="btn btn-primary">

                                        {{__('Send Password Reset Link')}}

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div> --}}

@include('includes.footer')

@endsection