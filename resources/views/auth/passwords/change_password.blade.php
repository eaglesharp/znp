@extends('layouts.app')

@section('content') 

<!-- Header start --> 

@include('includes.header') 



    <!-- Inner Page Title end -->

    <section class="section_emailverification align-items-center d-flex">

        <div class="container">

            <div class="col-md-8 col-xl-5 col-lg-6 px-0 py-5 m-auto">

                <div class="box py-4 rounded">

                    <div class="panel panel-default">

                        <div class="panel-heading text-center pb-3"><strong>{{__('Change Password')}}</strong></div>

                        <div class="panel-body">

    

                            @if(session()->has('message'))

                                <div class="alert alert-success">

                                    {{ session()->get('message') }}

                                </div>

                            @endif

    

                            @if(session()->has('error'))

                                <div class="alert alert-danger">

                                    {{ session()->get('error') }}

                                </div>

                            @endif

    

                            <form class="form-horizontal px-5 py-3" method="POST" action="{{url('update_password',$user->id)}}">

                                {{ csrf_field() }}

                                {{-- <input type="hidden" name="token" value=""> --}}

                                <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">

                                    <label for="password" class="col-12 sign_fontsize mb-2">{{__('Old Password')}} <span class="text-danger">*</span></label>

                                    <div class="col-12">

                                        <input id="password" type="password" class="w-100 py-2 px-3 signin_input rounded" name="old_password" >

                                        @if ($errors->has('old_password'))

                                            <span class="help-block">

                                        <strong class="new_error_class">{{ $errors->first('old_password') }} </strong>

                                    </span>

                                        @endif

                                    </div>

                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                    <label for="password" class="col-12 sign_fontsize mb-2">{{__('New Password')}} <span class="text-danger">*</span></label>

                                    <div class="col-12">

                                        <input id="password" type="password" class="w-100 py-2 px-3 signin_input rounded" name="new_password">

                                        @if ($errors->has('new_password'))

                                            <span class="help-block">

                                        <strong class="new_error_class">{{ $errors->first('new_password') }}</strong>

                                    </span>

                                        @endif

                                    </div>

                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                                    <label for="password-confirm" class="col-12 sign_fontsize mb-2">{{__('Confirm New Password')}} <span class="text-danger">*</span></label>

                                    <div class="col-12">

                                        <input id="password-confirm" type="password" class="w-100 py-2 px-3 signin_input rounded" name="new_password_confirmation">

                                        @if ($errors->has('new_password_confirmation'))

                                            <span class="help-block">

                                        <strong class="new_error_class">{{ $errors->first('new_password_confirmation') }}</strong>

                                    </span>

                                        @endif

                                    </div>

                                </div>

                                <div class="form-group">

                                    <div class="col-12 pt-3">

                                        {{-- <button type="submit" class="btn btn-primary">

                                            {{__('Reset Password')}}

                                        </button> --}}

                                        <button type="submit" class="w-100 py-2 signin_button rounded">{{__('Reset Password')}}</button>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@include('includes.footer')

@endsection

@push('scripts')



@endpush