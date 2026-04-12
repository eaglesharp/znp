@extends('layouts.znp')

@push('styles')
<style>
/* reuses .znp-pw styles from email.blade — redeclare here for standalone use */
.znp-pw, .znp-pw * {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    box-sizing: border-box; -webkit-font-smoothing: antialiased;
}
.znp-pw a { color: inherit; text-decoration: none; }
.znp-pw p { margin: 0; }
.znp-pw {
    display: flex; justify-content: center; align-items: center;
    padding: 60px 20px; background: #f3f4f8;
}
.znp-pw .pw-container {
    width: 100%; max-width: 960px;
    display: grid; grid-template-columns: 360px 1fr;
    background: #fff; border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.12); overflow: hidden;
}
.znp-pw .pw-left {
    background: linear-gradient(135deg, #1a3faa 0%, #152f85 100%);
    padding: 48px 36px; display: flex; flex-direction: column;
    justify-content: center; position: relative; overflow: hidden;
}
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
.znp-pw .pw-tips { margin-top: 28px; display: flex; flex-direction: column; gap: 12px; }
.znp-pw .pw-tip { display: flex; align-items: flex-start; gap: 10px; }
.znp-pw .pw-tip-icon {
    width: 26px; height: 26px; background: rgba(255,255,255,0.15);
    border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.znp-pw .pw-tip-icon svg { width: 12px !important; height: 12px !important; stroke: #fff !important; }
.znp-pw .pw-tip-text { flex: 1; }
.znp-pw .pw-tip-title { font-size: 11px !important; font-weight: 700 !important; color: #fff !important; margin-bottom: 2px; }
.znp-pw .pw-tip-desc  { font-size: 10px !important; color: rgba(255,255,255,0.7) !important; line-height: 1.5; }
.znp-pw .pw-right {
    padding: 48px 52px; display: flex; flex-direction: column; justify-content: center; background: #fff;
}
.znp-pw .pw-form-title {
    font-size: 22px !important; font-weight: 800 !important;
    color: #111827 !important; margin: 0 0 6px; letter-spacing: -0.5px;
}
.znp-pw .pw-form-sub {
    font-size: 13px !important; color: #6b7280 !important; line-height: 1.6; margin-bottom: 28px;
}
.znp-pw .pw-label {
    display: block; font-size: 12px !important; font-weight: 600 !important;
    color: #374151 !important; margin-bottom: 5px;
}
.znp-pw .pw-required { color: #dc2626 !important; margin-left: 2px; }
.znp-pw .pw-input-wrap { position: relative; margin-bottom: 4px; }
.znp-pw .pw-input-icon {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    width: 15px !important; height: 15px !important; stroke: #9ca3af; pointer-events: none;
}
.znp-pw .pw-input {
    width: 100%; padding: 11px 44px 11px 40px;
    border: 1.5px solid #e5e7eb; border-radius: 8px;
    font-size: 13px !important; color: #111827 !important;
    background: #fff; outline: none; transition: all .2s;
}
.znp-pw .pw-input:focus { border-color: #1a3faa; box-shadow: 0 0 0 4px rgba(26,63,170,0.08); }
.znp-pw .pw-input.is-invalid { border-color: #dc2626; box-shadow: 0 0 0 3px rgba(220,38,38,0.08); }
.znp-pw .pw-toggle {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: none; border: none; color: #9ca3af; cursor: pointer; padding: 4px;
    display: flex; align-items: center; transition: color .2s;
}
.znp-pw .pw-toggle:hover { color: #6b7280; }
.znp-pw .pw-toggle svg { width: 16px !important; height: 16px !important; stroke: currentColor; }
.znp-pw .pw-error { font-size: 11px !important; color: #dc2626 !important; margin: 3px 0 14px; }
.znp-pw .pw-group { margin-bottom: 18px; }
.znp-pw .pw-btn {
    width: 100%; padding: 12px; margin-top: 6px;
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
@media (max-width: 968px) {
    .znp-pw .pw-container { grid-template-columns: 1fr; }
    .znp-pw .pw-left { display: none; }
    .znp-pw .pw-right { padding: 40px 32px; }
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
        <h2>Create a <span>new password</span></h2>
        <p class="pw-desc">Choose a strong password to secure your account and keep your data safe.</p>
        <div class="pw-tips">
          <div class="pw-tip">
            <div class="pw-tip-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
            </div>
            <div class="pw-tip-text">
              <div class="pw-tip-title">At least 8 characters</div>
              <div class="pw-tip-desc">Longer passwords are harder to guess</div>
            </div>
          </div>
          <div class="pw-tip">
            <div class="pw-tip-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
            </div>
            <div class="pw-tip-text">
              <div class="pw-tip-title">Mix letters, numbers & symbols</div>
              <div class="pw-tip-desc">Combine uppercase, lowercase, and special characters</div>
            </div>
          </div>
          <div class="pw-tip">
            <div class="pw-tip-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
            </div>
            <div class="pw-tip-text">
              <div class="pw-tip-title">Avoid personal info</div>
              <div class="pw-tip-desc">Don't use your name, email, or birthdate</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Right Form Panel --}}
    <div class="pw-right">
      <div class="pw-form-title">Set New Password</div>
      <div class="pw-form-sub">Enter your email and choose a new password for your account.</div>

      <form method="POST" action="{{ route('password.request') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        {{-- Email --}}
        <div class="pw-group">
          <label class="pw-label" for="rp-email">Email Address <span class="pw-required">*</span></label>
          <div class="pw-input-wrap">
            <svg class="pw-input-icon" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
            </svg>
            <input id="rp-email" type="email" name="email"
              class="pw-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
              placeholder="your@email.com" value="{{ old('email') }}" autocomplete="email" required>
          </div>
          @if ($errors->has('email'))
            <div class="pw-error">{{ $errors->first('email') }}</div>
          @endif
        </div>

        {{-- New Password --}}
        <div class="pw-group">
          <label class="pw-label" for="rp-password">New Password <span class="pw-required">*</span></label>
          <div class="pw-input-wrap">
            <svg class="pw-input-icon" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            <input id="rp-password" type="password" name="password"
              class="pw-input{{ $errors->has('password') ? ' is-invalid' : '' }}"
              placeholder="Minimum 8 characters" required>
            <button type="button" class="pw-toggle" onclick="znpTogglePw('rp-password', this)">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
          @if ($errors->has('password'))
            <div class="pw-error">{{ $errors->first('password') }}</div>
          @endif
        </div>

        {{-- Confirm Password --}}
        <div class="pw-group">
          <label class="pw-label" for="rp-confirm">Confirm Password <span class="pw-required">*</span></label>
          <div class="pw-input-wrap">
            <svg class="pw-input-icon" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            <input id="rp-confirm" type="password" name="password_confirmation"
              class="pw-input{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
              placeholder="Re-enter your new password" required>
            <button type="button" class="pw-toggle" onclick="znpTogglePw('rp-confirm', this)">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
          @if ($errors->has('password_confirmation'))
            <div class="pw-error">{{ $errors->first('password_confirmation') }}</div>
          @endif
        </div>

        <button type="submit" class="pw-btn">Reset Password</button>
      </form>

      <a href="{{ route('jobseeker.auth') }}" class="pw-back">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        Back to Sign In
      </a>
    </div>

  </div>
</div>

<script>
function znpTogglePw(id, btn) {
    var el = document.getElementById(id);
    if (!el) return;
    var isText = el.type === 'text';
    el.type = isText ? 'password' : 'text';
    btn.innerHTML = isText
        ? '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;stroke:currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>'
        : '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;stroke:currentColor"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
}
</script>

@include('znp.footer')

@endsection