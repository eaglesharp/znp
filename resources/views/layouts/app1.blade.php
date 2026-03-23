<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title') @yield('title') — @else ZeroNoticePeriod — India's Exclusive Platform for Immediately Available Talent @endif</title>
    <meta name="description" content="@yield('meta_description', 'India\'s only job portal built exclusively for zero notice period talent. Find jobs & hire immediately available candidates.')">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Base Styles --}}
    <style>
        /* ── CSS VARIABLES ── */
        :root {
            --blue:         #1a3faa;
            --blue-dark:    #152f85;
            --blue-mid:     #2350cc;
            --orange:       #f97316;
            --orange-dark:  #ea6a00;
            --text:         #111827;
            --text-muted:   #6b7280;
            --text-light:   #9ca3af;
            --border:       #e5e7eb;
            --bg:           #f3f4f8;
            --white:        #ffffff;
        }

        /* ── RESET ── */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            font-size: 12px;
        }

        /* ── HEADER ── */
        .header {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 0 40px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 200;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .logo-text          { font-size: 16px; font-weight: 700; color: var(--text); }
        .logo-text .logo-blue   { color: var(--blue); }
        .logo-text .logo-orange { color: var(--orange); }

        .nav-links   { display: flex; align-items: center; gap: 10px; }
        .nav-actions { display: flex; align-items: center; gap: 8px; }

        .btn-find-jobs {
            background: var(--white);
            border: 1.5px solid var(--blue);
            color: var(--blue);
            padding: 9px 22px;
            border-radius: 7px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s;
            letter-spacing: 0.01em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-find-jobs:hover { background: #eef2ff; box-shadow: 0 2px 8px rgba(26,63,170,0.12); }

        .btn-post {
            background: var(--orange);
            border: none;
            color: var(--white);
            padding: 9px 20px;
            border-radius: 7px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-post:hover { background: var(--orange-dark); }

        /* ── FOOTER ── */
        .footer {
            background: var(--blue);
            padding: 0 40px 24px;
            border-top: 4px solid var(--orange);
        }
        .footer-inner { max-width: 1120px; margin: 0 auto; padding-top: 44px; }
        .footer-grid {
            display: grid;
            grid-template-columns: 1.8fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        .footer-brand   { font-size: 18px; font-weight: 800; color: #fff; margin-bottom: 14px; }
        .footer-addr    { font-size: 12.5px; color: rgba(255,255,255,0.5); line-height: 1.75; margin-bottom: 10px; }
        .footer-email   { font-size: 12.5px; color: var(--orange); text-decoration: none; font-weight: 600; }
        .footer-email:hover { text-decoration: underline; }
        .footer-col-title {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--orange);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 12px;
        }
        .footer-links                  { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .footer-links a                { font-size: 12.5px; color: rgba(255,255,255,0.45); text-decoration: none; transition: color 0.15s; }
        .footer-links a:hover          { color: var(--orange); }
        .footer-bottom {
            border-top: 1px solid rgba(249,115,22,0.35);
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer-copy    { font-size: 12px; color: rgba(255,255,255,0.35); }
        .footer-socials { display: flex; gap: 10px; }
        .social-icon {
            width: 32px;
            height: 32px;
            background: rgba(249,115,22,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            transition: all 0.15s;
        }
        .social-icon:hover { background: var(--orange); color: #fff; }

        /* ── RESPONSIVE: FOOTER ── */
        @media (max-width: 960px) {
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 28px; }
        }
        @media (max-width: 600px) {
            .footer-grid { grid-template-columns: 1fr; }
            .footer       { padding: 32px 16px 20px; }
            .header        { padding: 0 16px; }
            .nav-links     { display: none; }
        }
    </style>

    {{-- Page-specific styles --}}
    @stack('styles')
</head>
<body>

{{-- ══════════════════════════════════════
     HEADER / NAVIGATION
══════════════════════════════════════ --}}
<header class="header">
    <a class="logo" href="{{ url('/') }}">
        <span class="logo-text">
            <span class="logo-blue">Zero</span><span class="logo-orange">Notice</span><span class="logo-blue">Period</span>
        </span>
    </a>

    <nav class="nav-links">
        {{-- Add nav items here if needed --}}
    </nav>

    <div class="nav-actions">
        <a class="btn-find-jobs" href="{{ url('/jobs') }}">Find Jobs</a>
        <a class="btn-post"      href="{{ url('/employer-register') }}">Post Jobs</a>
    </div>
</header>

{{-- ══════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════ --}}
<main>
    @yield('content')
</main>

{{-- ══════════════════════════════════════
     HIRE CTA SECTION
══════════════════════════════════════ --}}
<section class="email-section">
    <div class="email-inner">
        <div class="email-title">Ready to <span>hire immediately?</span></div>
        <p class="email-sub">Join 1,800+ employers already hiring zero notice period talent on ZeroNoticePeriod.</p>
        <div class="cta-btns">
            <a class="cta-btn-primary" href="{{ url('/employer-register') }}">Post a Job — It's Free</a>
            <a class="cta-btn-secondary" href="{{ url('/register') }}">I'm a Jobseeker</a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     FOOTER
══════════════════════════════════════ --}}
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-grid">

            {{-- Brand column --}}
            <div class="footer-col footer-col-wide">
                <div class="footer-brand">ZeroNoticePeriod</div>
                <p class="footer-addr">
                    Evolve, SNN Raj Serenity, Begur - Koppa Rd,<br>
                    Yelenahalli, Bengaluru, Karnataka 560114
                </p>
                <a href="mailto:hello@zeronoticeperiod.com" class="footer-email">hello@zeronoticeperiod.com</a>
            </div>

            {{-- Jobs by Metro --}}
            <div class="footer-col">
                <div class="footer-col-title">Jobs by Metros</div>
                <ul class="footer-links">
                    <li><a href="{{ url('/jobs?location=Bengaluru') }}">Jobs in Bengaluru</a></li>
                    <li><a href="{{ url('/jobs?location=Hyderabad') }}">Jobs in Hyderabad</a></li>
                    <li><a href="{{ url('/jobs?location=Chennai') }}">Jobs in Chennai</a></li>
                    <li><a href="{{ url('/jobs?location=Mumbai') }}">Jobs in Mumbai</a></li>
                    <li><a href="{{ url('/jobs?location=Delhi') }}">Jobs in Delhi</a></li>
                </ul>
            </div>

            {{-- Jobs by Work Mode --}}
            <div class="footer-col">
                <div class="footer-col-title">Jobs by Work Mode</div>
                <ul class="footer-links">
                    <li><a href="{{ url('/jobs?mode=hybrid') }}">Jobs (Hybrid)</a></li>
                    <li><a href="{{ url('/jobs?mode=wfo') }}">Jobs (Work From Office)</a></li>
                    <li><a href="{{ url('/jobs?mode=remote') }}">Jobs (Remote/WFH)</a></li>
                    <li><a href="{{ url('/jobs?mode=temp-wfh') }}">Jobs (Temp WFH)</a></li>
                </ul>
            </div>

            {{-- Links column --}}
            <div class="footer-col">
                <div class="footer-col-title">Jobs by Job Type</div>
                <ul class="footer-links">
                    <li><a href="{{ url('/jobs?type=fulltime') }}">Jobs (Full time)</a></li>
                    <li><a href="{{ url('/jobs?type=contract') }}">Jobs (Contract)</a></li>
                </ul>
                <div class="footer-col-title" style="margin-top:20px;">Links</div>
                <ul class="footer-links">
                    <li><a href="{{ url('/terms') }}">Terms &amp; Conditions</a></li>
                    <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>
                </ul>
            </div>

        </div>{{-- /.footer-grid --}}

        <div class="footer-bottom">
            <span class="footer-copy">&copy; {{ date('Y') }} ZeroNoticePeriod. All rights reserved.</span>
            <div class="footer-socials">
                <a href="#" class="social-icon" title="Facebook" aria-label="Facebook">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                <a href="#" class="social-icon" title="LinkedIn" aria-label="LinkedIn">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                </a>
                <a href="#" class="social-icon" title="Twitter / X" aria-label="Twitter">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4l16 16M4 20L20 4"/></svg>
                </a>
                <a href="#" class="social-icon" title="YouTube" aria-label="YouTube">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.54C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white"/></svg>
                </a>
            </div>
        </div>

    </div>{{-- /.footer-inner --}}
</footer>

{{-- ══════════════════════════════════════
     SHARED FOOTER STYLES
══════════════════════════════════════ --}}
<style>
    /* ── EMAIL CTA ── */
    .email-section    { background: var(--white); padding: 56px 40px; text-align: center; border-top: 1px solid var(--border); }
    .email-inner      { max-width: 560px; margin: 0 auto; }
    .email-title      { font-size: 28px; font-weight: 800; color: var(--text); margin-bottom: 10px; letter-spacing: -0.5px; }
    .email-title span { color: var(--orange); }
    .email-sub        { font-size: 15px; color: var(--text-muted); margin-bottom: 28px; }
    .email-form       { display: flex; gap: 10px; max-width: 480px; margin: 0 auto; }
    .email-input      {
        flex: 1;
        border: 1.5px solid var(--border);
        background: var(--white);
        border-radius: 8px;
        padding: 13px 18px;
        font-size: 14px;
        color: var(--text);
        font-family: 'Inter', sans-serif;
        outline: none;
        transition: border 0.15s;
    }
    .email-input::placeholder { color: var(--text-light); }
    .email-input:focus        { border-color: var(--blue); }
    .btn-subscribe {
        background: var(--orange);
        color: var(--white);
        border: none;
        border-radius: 8px;
        padding: 13px 24px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: background 0.15s;
    }
    .btn-subscribe:hover { background: var(--orange-dark); }

    @media (max-width: 600px) {
        .email-form { flex-direction: column; }
        .email-section { padding: 40px 16px; }
    }
</style>

{{-- ══════════════════════════════════════
     BASE SCRIPTS
══════════════════════════════════════ --}}
<script>
    // Email subscription handler
    document.getElementById('subscribeBtn').addEventListener('click', function () {
        const el = document.getElementById('emailInput');
        if (el.value && el.value.includes('@')) {
            el.placeholder = '✓ You\'re subscribed!';
            el.value = '';
        } else {
            el.style.borderColor = 'var(--orange)';
            setTimeout(() => el.style.borderColor = '', 1500);
        }
    });
</script>

{{-- Page-specific scripts --}}
@stack('scripts')

</body>
</html>