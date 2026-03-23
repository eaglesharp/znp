@extends('layouts.app1')

@section('title', "Hire People Who Join Immediately")
@section('meta_description', "India's only job portal built for zero notice period talent. Find & apply to 5,000+ jobs today.")

{{-- ══════════════════════════════════════
     PAGE-SPECIFIC STYLES
══════════════════════════════════════ --}}
@push('styles')
<style>
    /* ── HERO ── */
    .hero        { background: var(--bg); padding: 48px 40px 56px; }
    .hero-inner  {
        max-width: 1120px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 48px;
        align-items: center;
    }
    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 100px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-muted);
        margin-bottom: 22px;
    }
    .eyebrow-dot      { width: 8px; height: 8px; background: var(--orange); border-radius: 50%; flex-shrink: 0; }
    .hero h1          { font-size: 42px; font-weight: 800; line-height: 1.18; color: var(--text); margin-bottom: 16px; letter-spacing: -1.5px; }
    .hero h1 .orange  { color: var(--orange); }
    .hero-sub         { font-size: 16px; color: var(--text-muted); line-height: 1.65; margin-bottom: 28px; max-width: 440px; }

    /* Hero search bar */
    .hero-search {
        background: var(--white);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        display: flex;
        align-items: center;
        overflow: hidden;
        max-width: 460px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .hs-field {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 14px;
        flex: 1;
        border-right: 1px solid var(--border);
    }
    .hs-icon              { color: var(--text-light); flex-shrink: 0; width: 16px; height: 16px; }
    .hs-field input       { border: none; outline: none; font-size: 14px; color: var(--text); font-family: 'Inter', sans-serif; width: 100%; padding: 13px 0; background: transparent; }
    .hs-field input::placeholder { color: var(--text-light); }
    .hs-city              { display: flex; align-items: center; gap: 8px; padding: 0 14px; }
    .hs-city input        { border: none; outline: none; font-size: 14px; color: var(--text); font-family: 'Inter', sans-serif; width: 90px; padding: 13px 0; background: transparent; }
    .hs-city input::placeholder { color: var(--text-light); }
    .btn-find             { background: var(--blue); color: var(--white); border: none; padding: 13px 22px; font-size: 14px; font-weight: 700; cursor: pointer; font-family: 'Inter', sans-serif; white-space: nowrap; transition: background 0.15s; }
    .btn-find:hover       { background: var(--blue-dark); }

    /* Quick tags */
    .hero-tags  { display: flex; gap: 8px; margin-top: 16px; flex-wrap: wrap; }
    .hero-tag   {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 100px;
        padding: 6px 14px;
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s;
    }
    .hero-tag:hover { border-color: var(--blue); color: var(--blue); }

    /* ── LIVE JOBS PANEL ── */
    .live-panel        { background: var(--white); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
    .live-panel-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--border); }
    .live-label        { font-size: 14px; font-weight: 600; color: var(--text); display: flex; align-items: center; gap: 7px; }
    .live-dot          { width: 8px; height: 8px; background: #22c55e; border-radius: 50%; animation: blink 1.5s infinite; flex-shrink: 0; }
    @keyframes blink   { 0%,100%{opacity:1} 50%{opacity:0.3} }
    .open-count        { font-size: 13px; color: var(--text-muted); }

    .live-job           { display: flex; align-items: center; gap: 12px; padding: 14px 20px; border-bottom: 1px solid #f3f4f6; transition: background 0.12s; cursor: pointer; text-decoration: none; }
    .live-job:hover     { background: #f9fafb; }
    .live-job:last-of-type { border-bottom: none; }
    .job-avatar         { width: 36px; height: 36px; border-radius: 8px; font-size: 11px; font-weight: 800; color: var(--white); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ja-znp { background: var(--blue); }
    .ja-fs  { background: #f97316; }
    .ja-yx  { background: #7c3aed; }
    .live-job-info      { flex: 1; min-width: 0; }
    .live-job-title     { font-size: 14px; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .live-job-company   { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

    .work-badge   { font-size: 11.5px; font-weight: 600; padding: 3px 10px; border-radius: 100px; flex-shrink: 0; }
    .wb-remote    { background: #fef3c7; color: #92400e; }
    .wb-hybrid    { background: #dbeafe; color: #1d4ed8; }
    .wb-wfo       { background: #dcfce7; color: #166534; }

    .btn-browse {
        display: block;
        margin: 12px 16px 16px;
        background: var(--orange);
        color: var(--white);
        border: none;
        border-radius: 8px;
        padding: 13px;
        font-size: 14px;
        font-weight: 700;
        text-align: center;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: background 0.15s;
        text-decoration: none;
    }
    .btn-browse:hover { background: var(--orange-dark); }

    /* ── STATS BAR ── */
    .stats-bar   { background: var(--blue); padding: 32px 40px; }
    .stats-inner {
        max-width: 1120px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }
    .stat-item  { text-align: center; }
    .stat-num   { font-size: 36px; font-weight: 800; color: var(--white); letter-spacing: -1px; margin-bottom: 6px; }
    .stat-num .hi { color: var(--orange); }
    .stat-lbl   { font-size: 13px; color: rgba(255,255,255,0.65); font-weight: 500; }

    /* ── SECTION WRAPPER ── */
    .section-wrap   { max-width: 1120px; margin: 0 auto; padding: 48px 40px; }
    .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .section-title  { font-size: 22px; font-weight: 800; color: var(--text); }
    .section-title span { color: var(--orange); }
    .see-all        { font-size: 13.5px; font-weight: 600; color: var(--blue); text-decoration: none; }
    .see-all:hover  { text-decoration: underline; }

    /* ── FILTER TABS ── */
    .filter-tabs { display: flex; gap: 6px; margin-bottom: 24px; flex-wrap: wrap; row-gap: 6px; }
    .tab         {
        border: 1.5px solid var(--border);
        background: var(--white);
        color: var(--text-muted);
        padding: 5px 12px;
        border-radius: 100px;
        font-size: 11.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
        font-family: 'Inter', sans-serif;
        white-space: nowrap;
    }
    .tab.active              { background: var(--blue); color: var(--white); border-color: var(--blue); }
    .tab:hover:not(.active)  { border-color: var(--blue); color: var(--blue); }

    /* ── JOB CARDS ── */
    .jobs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
    .job-card  {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 18px 20px;
        transition: all 0.18s;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }
    .job-card:hover { box-shadow: 0 6px 24px rgba(26,63,170,0.12); border-color: #c7d5f8; transform: translateY(-2px); }
    .jc-top     { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 12px; }
    .jc-avatar  { width: 38px; height: 38px; border-radius: 9px; font-size: 11px; font-weight: 800; color: var(--white); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .av-1  { background: var(--blue); }
    .av-2  { background: #f97316; }
    .av-3  { background: #0891b2; }
    .av-4  { background: #7c3aed; }
    .av-5  { background: #16a34a; }
    .av-6  { background: #db2777; }
    .av-7  { background: #ea580c; }
    .av-8  { background: #0d9488; }
    .jc-meta    { flex: 1; min-width: 0; }
    .jc-company { font-size: 11.5px; color: var(--text-muted); margin-bottom: 2px; }
    .jc-title   { font-size: 15px; font-weight: 700; color: var(--text); line-height: 1.3; margin-bottom: 3px; }
    .jc-loc     { font-size: 11px; color: var(--text-light); font-weight: 500; margin-top: 2px; }
    .jc-tags    { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 14px; }
    .tag        { font-size: 11.5px; font-weight: 600; padding: 4px 10px; border-radius: 100px; }
    .t-remote   { background: #fef3c7; color: #92400e; }
    .t-hybrid   { background: #dbeafe; color: #1d4ed8; }
    .t-wfo      { background: #dcfce7; color: #166534; }
    .t-urgent   { background: #fee2e2; color: #b91c1c; }
    .t-new      { background: #f0fdf4; color: #15803d; }
    .t-contract { background: #f3e8ff; color: #7e22ce; }
    .t-full     { background: #f0f9ff; color: #0369a1; }
    .t-c2h      { background: #fdf4ff; color: #86198f; }
    .jc-footer  { display: flex; justify-content: space-between; align-items: center; }
    .jc-exp     { font-size: 12px; color: var(--text-light); font-weight: 500; }
    .salary     { font-size: 12px; color: #7a8fb0; font-weight: 500; }
    .btn-apply  {
        background: transparent;
        border: 1px solid #bfcfef;
        color: var(--blue);
        padding: 7px 18px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.15s;
    }
    .btn-apply:hover { background: var(--blue); color: var(--white); border-color: var(--blue); }

    /* ── CATEGORIES ── */
    .cat-eyebrow        { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-muted); margin-bottom: 6px; }
    .cat-section-title  { font-size: 22px; font-weight: 800; color: var(--text); margin-bottom: 20px; letter-spacing: -0.3px; }
    .cat-section-title span { color: var(--orange); }
    .cat-grid  { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
    .cat-card  {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
    }
    .cat-card:hover        { border-color: var(--blue); box-shadow: 0 4px 16px rgba(26,63,170,0.1); transform: translateY(-2px); }
    .cat-icon  { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .cat-name  { font-size: 13.5px; font-weight: 700; color: var(--text); line-height: 1.3; }
    .cat-count { font-size: 11.5px; color: var(--text-muted); font-weight: 500; margin-top: 2px; }

    /* ── HOW IT WORKS ── */
    .how-section  { background: var(--white); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 56px 40px; }
    .how-inner    { max-width: 1120px; margin: 0 auto; }
    .how-title    { text-align: center; font-size: 26px; font-weight: 800; color: var(--text); margin-bottom: 48px; letter-spacing: -0.5px; }
    .how-title span { color: var(--orange); }
    .how-steps    { display: grid; grid-template-columns: repeat(4, 1fr); position: relative; }
    .how-line     { position: absolute; top: 24px; left: 12.5%; right: 12.5%; height: 2px; background: var(--border); z-index: 0; }
    .step         { text-align: center; position: relative; z-index: 1; padding: 0 20px; }
    .step-num     { width: 48px; height: 48px; background: var(--blue); color: var(--white); border-radius: 50%; font-size: 18px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; border: 3px solid var(--bg); }
    .step-title   { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 8px; }
    .step-desc    { font-size: 13px; color: var(--text-muted); line-height: 1.6; }

    /* ── DUAL CTA CARDS ── */
    .dual-section { max-width: 1120px; margin: 0 auto; padding: 48px 40px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .dual-card    { border-radius: 16px; padding: 36px; }
    .dc-blue  { background: var(--blue); }
    .dc-peach { background: #fff8f5; border: 1.5px solid #fde4d0; }
    .dc-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 14px; }
    .dc-blue  .dc-label { color: rgba(255,255,255,0.5); }
    .dc-peach .dc-label { color: var(--orange); }
    .dc-title { font-size: 26px; font-weight: 800; line-height: 1.25; margin-bottom: 14px; letter-spacing: -0.5px; }
    .dc-blue  .dc-title { color: var(--white); }
    .dc-peach .dc-title { color: var(--text); }
    .dc-desc  { font-size: 14px; line-height: 1.65; margin-bottom: 24px; }
    .dc-blue  .dc-desc  { color: rgba(255,255,255,0.7); }
    .dc-peach .dc-desc  { color: var(--text-muted); }
    .dc-list  { list-style: none; margin-bottom: 28px; display: flex; flex-direction: column; gap: 10px; }
    .dc-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; line-height: 1.45; }
    .dc-blue  .dc-list li { color: rgba(255,255,255,0.85); }
    .dc-peach .dc-list li { color: var(--text); }
    .dc-bullet { width: 6px; height: 6px; border-radius: 50%; background: var(--orange); flex-shrink: 0; margin-top: 5px; }
    .dc-cta    {
        display: inline-block;
        padding: 12px 28px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.15s;
        font-family: 'Inter', sans-serif;
    }
    .dc-blue  .dc-cta { background: var(--orange); color: var(--white); }
    .dc-blue  .dc-cta:hover { background: var(--orange-dark); }
    .dc-peach .dc-cta { background: var(--blue); color: var(--white); }
    .dc-peach .dc-cta:hover { background: var(--blue-dark); }

    /* ── EMPLOYERS CAROUSEL ── */
    .employers-section     { background: var(--white); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 44px 0; }
    .employers-inner       { max-width: 1120px; margin: 0 auto; padding: 0 40px; }
    .employers-header      { text-align: center; margin-bottom: 32px; }
    .employers-title       { font-size: 20px; font-weight: 800; color: var(--text); letter-spacing: -0.3px; margin-bottom: 6px; }
    .employers-title span  { color: var(--orange); }
    .employers-sub         { font-size: 13px; color: var(--text-muted); }
    .emp-carousel-outer    { overflow: hidden; position: relative; }
    .emp-carousel-outer::before,
    .emp-carousel-outer::after {
        content: '';
        position: absolute;
        top: 0; bottom: 0;
        width: 80px;
        z-index: 2;
        pointer-events: none;
    }
    .emp-carousel-outer::before { left: 0;  background: linear-gradient(to right, var(--white), transparent); }
    .emp-carousel-outer::after  { right: 0; background: linear-gradient(to left,  var(--white), transparent); }
    .emp-carousel-track   { display: flex; gap: 12px; animation: empScroll 40s linear infinite; width: max-content; align-items: center; }
    .emp-carousel-track:hover { animation-play-state: paused; }
    @keyframes empScroll  { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    .emp-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.18s;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
    }
    .emp-chip:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(26,63,170,0.13); border-color: #c7d5f8; }
    .emp-chip .ec-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

    /* ── SEE ALL JOBS BUTTON ── */
    .see-all-wrap     { display: flex; justify-content: center; margin-top: 32px; padding-top: 28px; border-top: 1px solid var(--border); }
    .btn-see-all-jobs {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--blue);
        color: var(--white);
        border: none;
        border-radius: 8px;
        padding: 13px 32px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        transition: all 0.15s;
        letter-spacing: 0.01em;
    }
    .btn-see-all-jobs:hover {
        background: var(--blue-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(26,63,170,0.25);
    }
    .btn-see-all-jobs svg { transition: transform 0.15s; }
    .btn-see-all-jobs:hover svg { transform: translateX(3px); }

    /* ── RESPONSIVE ── */
    @media (max-width: 960px) {
        .hero-inner    { grid-template-columns: 1fr; }
        .live-panel    { display: none; }
        .jobs-grid     { grid-template-columns: 1fr 1fr; }
        .cat-grid      { grid-template-columns: repeat(2, 1fr); }
        .dual-section  { grid-template-columns: 1fr; }
        .how-line      { display: none; }
        .how-steps     { grid-template-columns: 1fr 1fr; gap: 32px; }
        .stats-inner   { grid-template-columns: repeat(2, 1fr); gap: 24px; padding: 8px 0; }
    }
    @media (max-width: 600px) {
        .hero               { padding: 32px 16px 40px; }
        .hero h1            { font-size: 30px; }
        .jobs-grid          { grid-template-columns: 1fr; }
        .section-wrap,
        .dual-section       { padding-left: 16px; padding-right: 16px; }
        .how-steps          { grid-template-columns: 1fr; }
        .stats-bar          { padding: 24px 16px; }
        .how-section        { padding: 40px 16px; }
        .employers-section  { padding: 24px 0; }
        .cat-grid           { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

{{-- ══════════════════════════════════════
     PAGE CONTENT
══════════════════════════════════════ --}}
@section('content')

{{-- ══════════
     HERO
══════════ --}}
<section class="hero">
    <div class="hero-inner">

        {{-- Left column: headline + search --}}
        <div>
            <div class="hero-eyebrow">
                <span class="eyebrow-dot"></span>
                India's #1 Exclusive Job Portal For Immediate Joiners
            </div>

            <h1>Hire people who<br>join <span class="orange">immediately.</span></h1>
            <p class="hero-sub">India's only job portal built for zero notice talent.</p>

            {{-- Search bar --}}
            <div class="hero-search">
                <div class="hs-field">
                    <svg class="hs-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" id="skillInput" placeholder="Role, skill or keyword" aria-label="Search by role, skill or keyword">
                </div>
                <div class="hs-city">
                    <svg class="hs-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                    <input type="text" id="cityInput" placeholder="City" aria-label="Filter by city">
                </div>
                <button class="btn-find" id="heroSearchBtn">Find jobs</button>
            </div>

            {{-- Quick-filter tags --}}
            <div class="hero-tags">
                @foreach (['Remote', 'Contract', 'Hybrid', 'Permanent', 'Fresher'] as $tag)
                    <span class="hero-tag" data-tag="{{ $tag }}">{{ $tag }}</span>
                @endforeach
            </div>
        </div>

        {{-- Right column: live jobs panel --}}
        <div class="live-panel">
            <div class="live-panel-header">
                <span class="live-label">
                    <span class="live-dot"></span>Hot Jobs
                </span>
                <span class="open-count">5,000+ open roles</span>
            </div>

            {{--
                In a real Laravel app, pass $hotJobs from the controller:
                    return view('home', ['hotJobs' => Job::hot()->take(3)->get()]);
                Then replace the static links below with:
                @foreach ($hotJobs as $job) ... @endforeach
            --}}
            <a class="live-job" href="{{ url('/jobs') }}" target="_blank">
                <div class="job-avatar ja-znp">ZNP</div>
                <div class="live-job-info">
                    <div class="live-job-title">Data Scientist</div>
                    <div class="live-job-company">ZNP &middot; Bengaluru</div>
                </div>
                <span class="work-badge wb-remote">Remote</span>
            </a>

            <a class="live-job" href="{{ url('/job/snr-dot-net-developer-137') }}" target="_blank">
                <div class="job-avatar ja-fs">FS</div>
                <div class="live-job-info">
                    <div class="live-job-title">Sr. .NET Developer</div>
                    <div class="live-job-company">Fox Solutions &middot; Mumbai</div>
                </div>
                <span class="work-badge wb-hybrid">Hybrid</span>
            </a>

            <a class="live-job" href="{{ url('/jobs') }}" target="_blank">
                <div class="job-avatar ja-yx">YX</div>
                <div class="live-job-info">
                    <div class="live-job-title">Inside Sales Consultant</div>
                    <div class="live-job-company">Y-Axis &middot; Hyderabad</div>
                </div>
                <span class="work-badge wb-wfo">WFO</span>
            </a>

            <a class="btn-browse" href="{{ url('/jobs') }}">Browse all jobs &rarr;</a>
        </div>

    </div>
</section>

{{-- ══════════
     STATS BAR
══════════ --}}
<div class="stats-bar">
    <div class="stats-inner">
        @php
            $stats = [
                ['num' => '5,000', 'label' => 'Active Jobs'],
                ['num' => '4,000', 'label' => 'Permanent Jobs'],
                ['num' => '600',   'label' => 'Contract Jobs'],
                ['num' => '400',   'label' => 'Fresher Jobs'],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="stat-item">
                <div class="stat-num">{{ $stat['num'] }}<span class="hi">+</span></div>
                <div class="stat-lbl">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>
</div>

{{-- ══════════
     LATEST JOBS
══════════ --}}
<div class="section-wrap">
    <div class="section-header">
        <div class="section-title">Latest <span>jobs</span></div>
    </div>

    {{-- Filter tabs --}}
    <div class="filter-tabs">
        @php
            $cities = ['All', 'Bengaluru', 'Chennai', 'Hyderabad', 'Mumbai', 'Delhi', 'Gurgaon', 'Pune', 'Kolkata', 'Others'];
        @endphp
        @foreach ($cities as $city)
            <button
                class="tab {{ $loop->first ? 'active' : '' }}"
                data-filter="{{ strtolower($city) }}"
                onclick="filterJobs('{{ strtolower($city) }}', this)"
            >{{ $city }}</button>
        @endforeach
    </div>

    {{-- Job cards grid
         Replace with: @foreach ($jobs as $job) ... @endforeach
         and bind $job->city_slug to data-cat, etc.
    --}}
    <div class="jobs-grid">

        <a class="job-card" href="{{ url('/jobs') }}" data-cat="bengaluru">
            <div class="jc-top">
                <div class="jc-avatar av-1">ZNP</div>
                <div class="jc-meta">
                    <div class="jc-title">Data Scientist</div>
                    <div class="jc-company">ZNP</div>
                    <div class="jc-loc">Koramangala, Bengaluru</div>
                </div>
            </div>
            <div class="jc-tags">
                <span class="tag t-remote">Remote</span>
                <span class="tag t-full">Full-time</span>
                <span class="tag t-new">New</span>
            </div>
            <div class="jc-footer">
                <span class="jc-exp">3&ndash;6 yrs &nbsp;&middot;&nbsp; <span class="salary">18 LPA</span></span>
                <button class="btn-apply" type="button">Apply now</button>
            </div>
        </a>

        <a class="job-card" href="{{ url('/job/snr-dot-net-developer-137') }}" data-cat="mumbai">
            <div class="jc-top">
                <div class="jc-avatar av-2">FS</div>
                <div class="jc-meta">
                    <div class="jc-title">Sr. .NET Developer</div>
                    <div class="jc-company">Fox Solutions</div>
                    <div class="jc-loc">Andheri, Mumbai</div>
                </div>
            </div>
            <div class="jc-tags">
                <span class="tag t-hybrid">Hybrid</span>
                <span class="tag t-full">Full-time</span>
            </div>
            <div class="jc-footer">
                <span class="jc-exp">5&ndash;8 yrs &nbsp;&middot;&nbsp; <span class="salary">22 LPA</span></span>
                <button class="btn-apply" type="button">Apply now</button>
            </div>
        </a>

        <a class="job-card" href="{{ url('/jobs') }}" data-cat="bengaluru">
            <div class="jc-top">
                <div class="jc-avatar av-3">KDK</div>
                <div class="jc-meta">
                    <div class="jc-title">Business Dev Executive</div>
                    <div class="jc-company">KDK Softwares</div>
                    <div class="jc-loc">Indiranagar, Bengaluru</div>
                </div>
            </div>
            <div class="jc-tags">
                <span class="tag t-wfo">Work from office</span>
                <span class="tag t-new">New</span>
            </div>
            <div class="jc-footer">
                <span class="jc-exp">0&ndash;2 yrs &nbsp;&middot;&nbsp; <span class="salary">5 LPA</span></span>
                <button class="btn-apply" type="button">Apply now</button>
            </div>
        </a>

        <a class="job-card" href="{{ url('/jobs') }}" data-cat="delhi">
            <div class="jc-top">
                <div class="jc-avatar av-4">AC</div>
                <div class="jc-meta">
                    <div class="jc-title">Asst. Manager &mdash; Investor</div>
                    <div class="jc-company">Arin Consultancy</div>
                    <div class="jc-loc">Connaught Place, Delhi</div>
                </div>
            </div>
            <div class="jc-tags">
                <span class="tag t-hybrid">Hybrid</span>
                <span class="tag t-contract">Contract</span>
            </div>
            <div class="jc-footer">
                <span class="jc-exp">4&ndash;6 yrs &nbsp;&middot;&nbsp; <span class="salary">12 LPA</span></span>
                <button class="btn-apply" type="button">Apply now</button>
            </div>
        </a>

        <a class="job-card" href="{{ url('/jobs') }}" data-cat="hyderabad">
            <div class="jc-top">
                <div class="jc-avatar av-4">YX</div>
                <div class="jc-meta">
                    <div class="jc-title">Inside Sales Consultant</div>
                    <div class="jc-company">Y-Axis</div>
                    <div class="jc-loc">Madhapur, Hyderabad</div>
                </div>
            </div>
            <div class="jc-tags">
                <span class="tag t-wfo">Work from office</span>
                <span class="tag t-urgent">Urgent</span>
            </div>
            <div class="jc-footer">
                <span class="jc-exp">1&ndash;3 yrs &nbsp;&middot;&nbsp; <span class="salary">7 LPA</span></span>
                <button class="btn-apply" type="button">Apply now</button>
            </div>
        </a>

        <a class="job-card" href="{{ url('/jobs') }}" data-cat="gurgaon">
            <div class="jc-top">
                <div class="jc-avatar av-5">CM</div>
                <div class="jc-meta">
                    <div class="jc-title">ASP.NET Developer</div>
                    <div class="jc-company">Careermoves</div>
                    <div class="jc-loc">Cyber City, Gurgaon</div>
                </div>
            </div>
            <div class="jc-tags">
                <span class="tag t-remote">Remote</span>
                <span class="tag t-c2h">Contract to hire</span>
            </div>
            <div class="jc-footer">
                <span class="jc-exp">2&ndash;5 yrs &nbsp;&middot;&nbsp; <span class="salary">14 LPA</span></span>
                <button class="btn-apply" type="button">Apply now</button>
            </div>
        </a>

        <a class="job-card" href="{{ url('/jobs') }}" data-cat="bengaluru">
            <div class="jc-top">
                <div class="jc-avatar av-6">DG</div>
                <div class="jc-meta">
                    <div class="jc-title">SEO Executive</div>
                    <div class="jc-company">Digi Strikers</div>
                    <div class="jc-loc">HSR Layout, Bengaluru</div>
                </div>
            </div>
            <div class="jc-tags">
                <span class="tag t-wfo">Work from office</span>
                <span class="tag t-new">New</span>
            </div>
            <div class="jc-footer">
                <span class="jc-exp">0&ndash;2 yrs &nbsp;&middot;&nbsp; <span class="salary">4 LPA</span></span>
                <button class="btn-apply" type="button">Apply now</button>
            </div>
        </a>

        <a class="job-card" href="{{ url('/jobs') }}" data-cat="hyderabad">
            <div class="jc-top">
                <div class="jc-avatar av-7">WN</div>
                <div class="jc-meta">
                    <div class="jc-title">HR Recruiter</div>
                    <div class="jc-company">WEN Jobs</div>
                    <div class="jc-loc">Banjara Hills, Hyderabad</div>
                </div>
            </div>
            <div class="jc-tags">
                <span class="tag t-remote">Remote</span>
                <span class="tag t-full">Full-time</span>
            </div>
            <div class="jc-footer">
                <span class="jc-exp">1&ndash;4 yrs &nbsp;&middot;&nbsp; <span class="salary">6 LPA</span></span>
                <button class="btn-apply" type="button">Apply now</button>
            </div>
        </a>

        <a class="job-card" href="{{ url('/jobs') }}" data-cat="chennai">
            <div class="jc-top">
                <div class="jc-avatar av-8">VK</div>
                <div class="jc-meta">
                    <div class="jc-title">Executive Assistant</div>
                    <div class="jc-company">V-Konnect</div>
                    <div class="jc-loc">Anna Nagar, Chennai</div>
                </div>
            </div>
            <div class="jc-tags">
                <span class="tag t-hybrid">Hybrid</span>
                <span class="tag t-urgent">Urgent</span>
            </div>
            <div class="jc-footer">
                <span class="jc-exp">2&ndash;5 yrs &nbsp;&middot;&nbsp; <span class="salary">8 LPA</span></span>
                <button class="btn-apply" type="button">Apply now</button>
            </div>
        </a>

        <a class="job-card" href="{{ url('/jobs') }}" data-cat="pune">
            <div class="jc-top">
                <div class="jc-avatar av-1">TCS</div>
                <div class="jc-meta">
                    <div class="jc-title">Technical Architect</div>
                    <div class="jc-company">TCS</div>
                    <div class="jc-loc">Hinjewadi, Pune</div>
                </div>
            </div>
            <div class="jc-tags">
                <span class="tag t-wfo">Work from office</span>
                <span class="tag t-full">Full-time</span>
            </div>
            <div class="jc-footer">
                <span class="jc-exp">8&ndash;12 yrs &nbsp;&middot;&nbsp; <span class="salary">32 LPA</span></span>
                <button class="btn-apply" type="button">Apply now</button>
            </div>
        </a>

        <a class="job-card" href="{{ url('/jobs') }}" data-cat="kolkata">
            <div class="jc-top">
                <div class="jc-avatar av-3">IFI</div>
                <div class="jc-meta">
                    <div class="jc-title">Finance Manager</div>
                    <div class="jc-company">Infigen</div>
                    <div class="jc-loc">Salt Lake, Kolkata</div>
                </div>
            </div>
            <div class="jc-tags">
                <span class="tag t-hybrid">Hybrid</span>
                <span class="tag t-full">Full-time</span>
            </div>
            <div class="jc-footer">
                <span class="jc-exp">6&ndash;10 yrs &nbsp;&middot;&nbsp; <span class="salary">16 LPA</span></span>
                <button class="btn-apply" type="button">Apply now</button>
            </div>
        </a>

        <a class="job-card" href="{{ url('/jobs') }}" data-cat="others">
            <div class="jc-top">
                <div class="jc-avatar av-5">AX</div>
                <div class="jc-meta">
                    <div class="jc-title">Full Stack Developer</div>
                    <div class="jc-company">Axora Tech</div>
                    <div class="jc-loc">Sector 62, Noida</div>
                </div>
            </div>
            <div class="jc-tags">
                <span class="tag t-remote">Remote</span>
                <span class="tag t-new">New</span>
            </div>
            <div class="jc-footer">
                <span class="jc-exp">3&ndash;6 yrs &nbsp;&middot;&nbsp; <span class="salary">20 LPA</span></span>
                <button class="btn-apply" type="button">Apply now</button>
            </div>
        </a>

    </div>{{-- /.jobs-grid --}}

    {{-- See All Jobs CTA --}}
    <div class="see-all-wrap">
        <a class="btn-see-all-jobs" href="{{ url('/jobs') }}">
            See All Jobs
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="m9 18 6-6-6-6"/>
            </svg>
        </a>
    </div>

</div>{{-- /.section-wrap --}}

{{-- ══════════
     BROWSE BY CATEGORY
══════════ --}}
<div class="section-wrap" style="padding-top: 0;">
    <div class="employers-header" style="text-align: left; margin-bottom: 20px;">
        <div class="employers-title">Browse by <span>category</span></div>
        <p class="employers-sub">Find roles that match your preferred work style and type</p>
    </div>

    <div class="cat-grid">
        @php
            $categories = [
                ['icon' => '🏢', 'bg' => '#dbeafe', 'name' => 'Hybrid',           'count' => '248 jobs', 'slug' => 'hybrid'],
                ['icon' => '🏠', 'bg' => '#dcfce7', 'name' => 'Remote / WFH',     'count' => '312 jobs', 'slug' => 'remote'],
                ['icon' => '🏛️', 'bg' => '#fed7aa', 'name' => 'Work from Office', 'count' => '415 jobs', 'slug' => 'wfo'],
                ['icon' => '📝', 'bg' => '#e9d5ff', 'name' => 'Contract',         'count' => '189 jobs', 'slug' => 'contract'],
                ['icon' => '🎓', 'bg' => '#fef08a', 'name' => 'Fresher Jobs',     'count' => '97 jobs',  'slug' => 'fresher'],
                ['icon' => '🌙', 'bg' => '#fecaca', 'name' => 'Night Shift',      'count' => '64 jobs',  'slug' => 'night-shift'],
                ['icon' => '💼', 'bg' => '#99f6e4', 'name' => 'Internship',       'count' => '41 jobs',  'slug' => 'internship'],
                ['icon' => '⚡', 'bg' => '#e2e8f0', 'name' => 'Permanent',        'count' => '156 jobs', 'slug' => 'permanent'],
            ];
        @endphp

        @foreach ($categories as $cat)
            <a class="cat-card" href="{{ url('/jobs?type=' . $cat['slug']) }}">
                <div class="cat-icon" style="background: {{ $cat['bg'] }};">{{ $cat['icon'] }}</div>
                <div>
                    <div class="cat-name">{{ $cat['name'] }}</div>
                    <div class="cat-count">{{ $cat['count'] }}</div>
                </div>
            </a>
        @endforeach
    </div>
</div>

{{-- ══════════
     TOP EMPLOYERS CAROUSEL
══════════ --}}
<div class="employers-section">
    <div class="employers-inner">
        <div class="employers-header">
            <div class="employers-title">Top Employers <span>Across India</span></div>
            <p class="employers-sub">Trusted by India's leading companies hiring zero notice period talent</p>
        </div>

        <div class="emp-carousel-outer">
            <div class="emp-carousel-track">
                @php
                    $employers = [
                        ['name' => 'Tech Mahindra', 'color' => '#ed1c24'],
                        ['name' => 'Careermoves',   'color' => '#7c3aed'],
                        ['name' => 'Y-Axis',        'color' => '#0066cc'],
                        ['name' => 'KDK Softwares', 'color' => '#0891b2'],
                        ['name' => 'Argus',         'color' => '#16a34a'],
                        ['name' => 'ACNX Business', 'color' => '#ea580c'],
                        ['name' => 'WEN Jobs',      'color' => '#0056d2'],
                        ['name' => 'Digi Strikers', 'color' => '#db2777'],
                        ['name' => 'V-Konnect',     'color' => '#ca8a04'],
                        ['name' => 'Fox Solutions', 'color' => '#f97316'],
                        ['name' => 'Arin Consultancy', 'color' => '#059669'],
                        ['name' => 'Deloitte',      'color' => '#00a04a'],
                        ['name' => 'KPMG',          'color' => '#00338d'],
                        ['name' => 'Accenture',     'color' => '#a100ff'],
                        ['name' => 'TCS',           'color' => '#0066b2'],
                        ['name' => 'Infosys',       'color' => '#007cc3'],
                        ['name' => 'Wipro',         'color' => '#341a52'],
                        ['name' => 'Cognizant',     'color' => '#0046ad'],
                        ['name' => 'HCL Technologies', 'color' => '#e31837'],
                        ['name' => 'Capgemini',     'color' => '#0070ad'],
                        ['name' => 'Amazon',        'color' => '#ff9900'],
                        ['name' => 'Flipkart',      'color' => '#f68220'],
                        ['name' => 'Razorpay',      'color' => '#2d6be4'],
                        ['name' => 'Swiggy',        'color' => '#fc8019'],
                        ['name' => 'Zomato',        'color' => '#e23744'],
                        ['name' => 'Salesforce',    'color' => '#009edb'],
                        ['name' => 'HDFC Bank',     'color' => '#004c8c'],
                        ['name' => 'ICICI Bank',    'color' => '#f15a29'],
                        ['name' => 'Axis Bank',     'color' => '#97144d'],
                        ['name' => 'Bajaj Finserv', 'color' => '#0066b3'],
                    ];
                    // Duplicate for seamless infinite scroll
                    $allEmployers = array_merge($employers, $employers);
                @endphp

                @foreach ($allEmployers as $emp)
                    <span class="emp-chip">
                        <span class="ec-dot" style="background: {{ $emp['color'] }};"></span>
                        {{ $emp['name'] }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ══════════
     HOW IT WORKS
══════════ --}}
<section class="how-section">
    <div class="how-inner">
        <div class="how-title">How it <span>works</span></div>
        <div class="how-steps">
            <div class="how-line"></div>

            @php
                $steps = [
                    ['num' => 1, 'title' => 'Register free',    'desc' => 'Create your profile in 2 minutes — no fees, no hidden charges'],
                    ['num' => 2, 'title' => 'Set availability', 'desc' => 'Tell employers you\'re ready to join immediately'],
                    ['num' => 3, 'title' => 'Get matched',      'desc' => 'Employers looking for immediate joiners find and contact you'],
                    ['num' => 4, 'title' => 'Start working',    'desc' => 'Accept an offer and join your new team — sometimes within 48 hours'],
                ];
            @endphp

            @foreach ($steps as $step)
                <div class="step">
                    <div class="step-num">{{ $step['num'] }}</div>
                    <div class="step-title">{{ $step['title'] }}</div>
                    <div class="step-desc">{{ $step['desc'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════
     DUAL CTA CARDS
══════════ --}}
<div class="dual-section">

    {{-- For Jobseekers --}}
    <div class="dual-card dc-blue">
        <div class="dc-label">For Jobseekers</div>
        <div class="dc-title">Your next job.<br>This week.</div>
        <p class="dc-desc">No notice period? That's your superpower. Employers are looking for you right now.</p>
        <ul class="dc-list">
            <li><span class="dc-bullet"></span>Apply with one click to verified jobs</li>
            <li><span class="dc-bullet"></span>Get alerts for matching roles instantly</li>
            <li><span class="dc-bullet"></span>Announce your interview availability</li>
            <li><span class="dc-bullet"></span>100% free for jobseekers</li>
        </ul>
        <a class="dc-cta" href="{{ url('/jobs') }}">Browse jobs now</a>
    </div>

    {{-- For Recruiters --}}
    <div class="dual-card dc-peach">
        <div class="dc-label">For Recruiters</div>
        <div class="dc-title">Hire in days,<br>not months.</div>
        <p class="dc-desc">Stop losing time chasing candidates on 60-day notice. Find verified immediate joiners today.</p>
        <ul class="dc-list">
            <li><span class="dc-bullet"></span>Verified zero-notice-period database</li>
            <li><span class="dc-bullet"></span>Buy single CVs or bulk packages</li>
            <li><span class="dc-bullet"></span>Find contractors and perm hires</li>
            <li><span class="dc-bullet"></span>Post jobs to immediate joiners only</li>
        </ul>
        <a class="dc-cta" href="{{ url('/employer-register') }}">Post a job</a>
    </div>

</div>

@endsection

{{-- ══════════════════════════════════════
     PAGE-SPECIFIC SCRIPTS
══════════════════════════════════════ --}}
@push('scripts')
<script>
    // ── HERO SEARCH ──────────────────────────────────────────
    function doSearch() {
        const skill = document.getElementById('skillInput').value.trim();
        const city  = document.getElementById('cityInput').value.trim();
        const params = new URLSearchParams();
        if (skill) params.set('skills', skill);
        if (city)  params.set('location', city);
        const query = params.toString();
        window.location.href = '/jobs' + (query ? '?' + query : '');
    }

    document.getElementById('heroSearchBtn').addEventListener('click', doSearch);

    document.getElementById('skillInput').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') doSearch();
    });
    document.getElementById('cityInput').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') doSearch();
    });

    // Quick-filter tags in hero
    document.querySelectorAll('.hero-tag').forEach(function (tag) {
        tag.addEventListener('click', function () {
            document.getElementById('skillInput').value = this.dataset.tag;
            doSearch();
        });
    });

    // ── JOB FILTER ───────────────────────────────────────────
    function filterJobs(cat, btn) {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        const allCards = Array.from(document.querySelectorAll('.jobs-grid .job-card'));
        allCards.forEach(function (card, i) {
            const match = cat === 'all' || (card.getAttribute('data-cat') || '').includes(cat);
            card.style.display = match ? '' : 'none';
            if (match) {
                card.style.opacity   = '0';
                card.style.transform = 'translateY(10px)';
                card.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                setTimeout(function () {
                    card.style.opacity   = '1';
                    card.style.transform = 'translateY(0)';
                }, i * 40);
            }
        });
    }
</script>
@endpush