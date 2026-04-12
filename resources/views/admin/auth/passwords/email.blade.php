@extends('admin.layouts.login_layout')
@section('content')

<style>
  /* ── Modern Forgot Password Card ── */
  .fpw-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.10), 0 1px 4px rgba(0,0,0,0.06);
    padding: 40px 36px 32px;
    max-width: 420px;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
  }
  .fpw-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #26c281, #1a9f67);
    border-radius: 12px 12px 0 0;
  }
  .fpw-icon-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px; height: 60px;
    background: linear-gradient(135deg, #e8faf3, #c7f2e1);
    border-radius: 50%;
    margin: 0 auto 20px;
  }
  .fpw-icon-wrap svg {
    width: 28px; height: 28px;
    stroke: #26c281;
  }
  .fpw-title {
    text-align: center;
    font-size: 22px;
    font-weight: 700;
    color: #2c3e50;
    margin: 0 0 6px;
    letter-spacing: -0.3px;
  }
  .fpw-subtitle {
    text-align: center;
    font-size: 13.5px;
    color: #7f8c8d;
    margin: 0 0 28px;
    line-height: 1.5;
  }
  .fpw-label {
    display: block;
    font-size: 12.5px;
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 6px;
    letter-spacing: 0.3px;
    text-transform: uppercase;
  }
  .fpw-input-wrap {
    position: relative;
    margin-bottom: 6px;
  }
  .fpw-input-wrap svg {
    position: absolute;
    left: 13px; top: 50%;
    transform: translateY(-50%);
    width: 16px; height: 16px;
    stroke: #a0aec0;
    pointer-events: none;
  }
  .fpw-input {
    width: 100%;
    padding: 11px 14px 11px 40px;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #2d3748;
    background: #f8fafc;
    transition: border-color .2s, box-shadow .2s;
    box-sizing: border-box;
    outline: none;
  }
  .fpw-input:focus {
    border-color: #26c281;
    box-shadow: 0 0 0 3px rgba(38,194,129,0.12);
    background: #fff;
  }
  .fpw-input.has-error {
    border-color: #e74c3c;
    box-shadow: 0 0 0 3px rgba(231,76,60,0.10);
  }
  .fpw-error {
    font-size: 12px;
    color: #e74c3c;
    margin: 4px 0 14px;
    display: flex;
    align-items: center;
    gap: 5px;
  }
  .fpw-error svg { width: 13px; height: 13px; stroke: #e74c3c; flex-shrink: 0; }
  .fpw-btn {
    display: block;
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #26c281, #1a9f67);
    color: #fff;
    font-size: 14.5px;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    letter-spacing: 0.3px;
    transition: opacity .2s, transform .1s;
    margin-top: 20px;
  }
  .fpw-btn:hover { opacity: .92; transform: translateY(-1px); }
  .fpw-btn:active { transform: translateY(0); }
  .fpw-back {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 18px;
    font-size: 13px;
    color: #718096;
    text-decoration: none;
  }
  .fpw-back:hover { color: #26c281; }
  .fpw-back svg { width: 14px; height: 14px; stroke: currentColor; }
  /* Success state */
  .fpw-success {
    text-align: center;
    padding: 8px 0 4px;
  }
  .fpw-success-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 68px; height: 68px;
    background: linear-gradient(135deg, #e8faf3, #c7f2e1);
    border-radius: 50%;
    margin: 0 auto 20px;
    animation: fpwPop .4s cubic-bezier(.175,.885,.32,1.275);
  }
  @keyframes fpwPop { from { transform: scale(.5); opacity:0; } to { transform: scale(1); opacity:1; } }
  .fpw-success-icon svg { width: 32px; height: 32px; stroke: #26c281; }
  .fpw-success h3 { font-size: 20px; font-weight: 700; color: #2c3e50; margin: 0 0 10px; }
  .fpw-success p  { font-size: 13.5px; color: #7f8c8d; line-height: 1.6; margin: 0 0 22px; }
</style>

<div class="content">
  <div class="fpw-card">

    @if (session('status'))

      {{-- ── SUCCESS STATE ── --}}
      <div class="fpw-success">
        <div class="fpw-success-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
            <polyline points="22,6 12,13 2,6"/>
          </svg>
        </div>
        <h3>Check Your Email</h3>
        <p>A password reset link has been sent to your email address. Please check your inbox and follow the instructions.</p>
        <a href="{{ route('admin.login') }}" class="fpw-btn" style="text-decoration:none;display:block;text-align:center;">Back to Sign In</a>
      </div>

    @else

      {{-- ── FORM STATE ── --}}
      <div class="fpw-icon-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="11" width="18" height="11" rx="2"/>
          <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
      </div>
      <h2 class="fpw-title">Forgot Password?</h2>
      <p class="fpw-subtitle">Enter your admin email address and we'll send you a link to reset your password.</p>

      <form method="POST" action="{{ route('admin.password.email') }}">
        @csrf

        <label class="fpw-label" for="fpw-email">Email Address</label>
        <div class="fpw-input-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
            <polyline points="22,6 12,13 2,6"/>
          </svg>
          <input
            id="fpw-email"
            type="email"
            name="email"
            class="fpw-input{{ $errors->has('email') ? ' has-error' : '' }}"
            placeholder="admin@example.com"
            value="{{ old('email') }}"
            autocomplete="email"
            required
          >
        </div>

        @if ($errors->has('email'))
          <div class="fpw-error">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ $errors->first('email') }}
          </div>
        @endif

        <button type="submit" class="fpw-btn">Send Reset Link</button>
      </form>

      <a href="{{ route('admin.login') }}" class="fpw-back">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        Back to Sign In
      </a>

    @endif

  </div>
</div>

@endsection