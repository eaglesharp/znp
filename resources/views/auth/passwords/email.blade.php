@extends('layouts.znp')

@push('styles')
<style>
/* ── ZNP Password Pages: scoped styles ── */
.znp-pw, .znp-pw * {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    box-sizing: border-box; -webkit-font-smoothing: antialiased;
}
.znp-pw a { color: inherit; text-decoration: none; }
.znp-pw p { margin: 0; }
.znp-pw {
    display: flex; justify-content: center; align-items: center;
    padding: 45px 12px; background: #f3f4f8;
}
.znp-pw .pw-container {
    width: 100%; max-width: 530px; margin: 0 auto;
    display: grid; grid-template-columns: 1fr;
    background: #fff; border-radius: 16px;
    box-shadow: 0 18px 48px rgba(0,0,0,0.10); overflow: hidden;
}
.znp-pw .pw-left { display: none; }
.znp-pw .pw-left::before {
    content: ''; position: absolute; top: -100px; right: -100px;
    width: 280px; height: 280px; background: rgba(255,255,255,0.08); border-radius: 50%;
}
.znp-pw .pw-left::after {
    content: ''; position: absolute; bottom: -120px; left: -80px;
    width: 260px; height: 260px; background: rgba(249,115,22,0.13); border-radius: 50%;
}
.znp-pw .pw-left-content { position: relative; z-index: 1; }
.znp-pw .pw-logo-text {
    font-size: 14px !important; font-weight: 800 !important;
    color: #fff; display: flex; flex-wrap: wrap; line-height: 1.3; margin-bottom: 28px;
}
.znp-pw .pw-logo-text .orange { color: #f97316 !important; }
.znp-pw .pw-icon-circle {
    width: 64px; height: 64px; background: rgba(255,255,255,0.14);
    border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 24px;
}
.znp-pw .pw-icon-circle svg { width: 28px !important; height: 28px !important; stroke: #fff !important; }
.znp-pw .pw-left h2 {
    font-size: 20px !important; font-weight: 700 !important; color: #fff !important;
    margin: 0 0 12px; line-height: 1.3; letter-spacing: -0.3px;
}
.znp-pw .pw-left h2 span { color: #f97316 !important; }
.znp-pw .pw-left .pw-desc {
    font-size: 12px !important; color: rgba(255,255,255,0.82) !important; line-height: 1.7; margin: 0;
}
.znp-pw .pw-steps { margin-top: 32px; display: flex; flex-direction: column; gap: 14px; }
.znp-pw .pw-step { display: flex; align-items: flex-start; gap: 12px; }
.znp-pw .pw-step-num {
    width: 26px; height: 26px; background: rgba(255,255,255,0.15);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 11px !important; font-weight: 700 !important; color: #fff !important; flex-shrink: 0;
}
.znp-pw .pw-step-text { flex: 1; }
.znp-pw .pw-step-title { font-size: 11px !important; font-weight: 700 !important; color: #fff !important; margin-bottom: 2px; }
.znp-pw .pw-step-desc  { font-size: 10px !important; color: rgba(255,255,255,0.7) !important; line-height: 1.5; }
.znp-pw .pw-right {
    padding: 36px 32px; display: flex; flex-direction: column; justify-content: center; align-items: center; background: #fff;
}
.znp-pw .pw-form-title {
    font-size: 22px !important; font-weight: 800 !important;
    color: #111827 !important; margin: 0 0 6px; letter-spacing: -0.5px; text-align:center;
}
.znp-pw .pw-form-sub {
    font-size: 13px !important; color: #6b7280 !important; line-height: 1.6; margin-bottom: 18px; text-align:center;
}
.znp-pw .pw-label {
    display: block; font-size: 12px !important; font-weight: 600 !important;
    color: #374151 !important; margin-bottom: 5px;
}
.znp-pw .pw-required { color: #dc2626 !important; margin-left: 2px; }
.znp-pw .pw-input-wrap { position: relative; margin: 8px auto 12px; width:100%; max-width:480px }
.znp-pw .pw-input-icon {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    width: 15px !important; height: 15px !important; stroke: #9ca3af; pointer-events: none;
}
.znp-pw .pw-input {
    width: 100%; padding: 11px 14px 11px 40px;
    border: 1.5px solid #e5e7eb; border-radius: 8px;
    font-size: 13px !important; color: #111827 !important;
    background: #fff; outline: none; transition: all .2s;
}
.znp-pw .pw-input:focus { border-color: #1a3faa; box-shadow: 0 0 0 4px rgba(26,63,170,0.08); }
.znp-pw .pw-input.is-invalid { border-color: #dc2626; box-shadow: 0 0 0 3px rgba(220,38,38,0.08); }
.znp-pw .pw-error { font-size: 11px !important; color: #dc2626 !important; margin: 3px 0 12px; }
.znp-pw .pw-btn {
    width: 100%; padding: 12px; margin-top: 10px;
    background: #1a3faa; border: none; border-radius: 8px;
    color: #fff !important; font-size: 13.5px !important; font-weight: 700 !important;
    cursor: pointer; transition: all .2s; letter-spacing: 0.2px;
    box-shadow: 0 4px 12px rgba(26,63,170,0.22);
}
.znp-pw .pw-btn:hover { background: #152f85; box-shadow: 0 6px 18px rgba(26,63,170,0.32); transform: translateY(-1px); }
.znp-pw .pw-back {
    display: inline-flex; align-items: center; gap: 6px; margin-top: 20px;
    font-size: 12.5px !important; font-weight: 600 !important; color: #1a3faa !important; text-decoration: none;
}
.znp-pw .pw-back:hover { text-decoration: underline; }
.znp-pw .pw-back svg { width: 13px !important; height: 13px !important; stroke: currentColor; }
.znp-pw .pw-alert-success {
    padding: 10px 14px; border-radius: 8px; font-size: 12px !important;
    background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a !important; margin-bottom: 20px;
}
.znp-pw .pw-success-icon {
    width: 68px; height: 68px;
    background: linear-gradient(135deg, #eef2ff, #c7d2fe);
    border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;
    animation: znpPwPop .4s cubic-bezier(.175,.885,.32,1.275);
}
@keyframes znpPwPop { from { transform:scale(.5); opacity:0; } to { transform:scale(1); opacity:1; } }
.znp-pw .pw-success-icon svg { width: 32px !important; height: 32px !important; stroke: #1a3faa !important; }
@media (max-width: 968px) {
    .znp-pw .pw-container { grid-template-columns: 1fr; }
    .znp-pw .pw-left { display: none; }
    .znp-pw .pw-right { padding: 28px 20px; }
}
@media (max-width: 640px) {
    .znp-pw { padding: 0; }
    .znp-pw .pw-container { border-radius: 0; box-shadow: none; }
    .znp-pw .pw-right { padding: 32px 24px; }
}
</style>
@endpush

@section('content')

@include('znp.header')

<div class="znp-pw">
  <div class="pw-container">

    {{-- Left Info Panel --}}
    <div class="pw-left">
      <div class="pw-left-content">
        <div class="pw-logo-text"><span>Zero<span class="orange">Notice</span>Period</span></div>
        <div class="pw-icon-circle">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
        </div>
        <h2>Forgot your <span>password?</span></h2>
        <p class="pw-desc">No worries — enter your registered email and we'll send you a secure reset link instantly.</p>
        <div class="pw-steps">
          <div class="pw-step">
            <div class="pw-step-num">1</div>
            <div class="pw-step-text">
              <div class="pw-step-title">Enter your email</div>
              <div class="pw-step-desc">Provide the email linked to your account</div>
            </div>
          </div>
          <div class="pw-step">
            <div class="pw-step-num">2</div>
            <div class="pw-step-text">
              <div class="pw-step-title">Check your inbox</div>
              <div class="pw-step-desc">We'll send a secure reset link to your email</div>
            </div>
          </div>
          <div class="pw-step">
            <div class="pw-step-num">3</div>
            <div class="pw-step-text">
              <div class="pw-step-title">Create new password</div>
              <div class="pw-step-desc">Follow the link and set your new password</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Right Form Panel --}}
    <div class="pw-right">

      @if (session('status'))
        <div class="pw-success-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
          </svg>
        </div>
        <div class="pw-form-title">Email Sent!</div>
        <div class="pw-form-sub">A password reset link has been sent to your email. Please check your inbox and follow the instructions.</div>
        <div class="pw-alert-success">{{ session('status') }}</div>
        <a href="{{ route('jobseeker.auth') }}" class="pw-btn" style="display:block;text-align:center;text-decoration:none;">Back to Sign In</a>

      @else
        <div class="pw-form-title">Reset Password</div>
        <div class="pw-form-sub">Enter your email address and we'll send you a link to reset your password.</div>

        <form method="POST" action="{{ route('password.email') }}">
          @csrf
          <label class="pw-label" for="pw-email">Email Address <span class="pw-required">*</span></label>
          <div class="pw-input-wrap">
            <svg class="pw-input-icon" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
            </svg>
            <input id="pw-email" type="email" name="email"
              class="pw-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
              placeholder="your@email.com" value="{{ old('email') }}" autocomplete="email" required>
          </div>
          @if ($errors->has('email'))
            <div class="pw-error">{{ $errors->first('email') }}</div>
          @endif
          <button type="submit" class="pw-btn">Send Reset Link</button>
        </form>

        <a href="{{ route('jobseeker.auth') }}" class="pw-back">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
          </svg>
          Back to Sign In
        </a>
      @endif

    </div>
  </div>
</div>

@include('znp.footer')

{{-- OLD_REMOVED_START

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

@endsection