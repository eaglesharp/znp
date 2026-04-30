@extends('layouts.znp')

{{-- ══════════════════════════════════════
     PAGE-SPECIFIC STYLES
══════════════════════════════════════ --}}
@push('styles')
<style>
    /* ── ZNP HOME: SCOPE & HARD BOOTSTRAP OVERRIDE ── */
    /* Design tokens, Inter font, jQuery UI → layouts/znp.blade.php + znp-common.css
       Shared components (.job-card, .jc-title, .tag etc.) → znp-common.css         */
    .znp-home {
        background: var(--bg);
        color: var(--text);
    }
    /* Forcibly apply Inter to every element inside the home wrapper,
       overriding Bootstrap's helvetica/system font stack */
    .znp-home,
    .znp-home *,
    .znp-home *::before,
    .znp-home *::after {
        font-family: 'Inter', sans-serif !important;
        box-sizing: border-box;
        -webkit-font-smoothing: antialiased;
    }
    /* Reset Bootstrap element defaults inside our wrapper */
    .znp-home a                 { color: inherit; text-decoration: none; }
    .znp-home h1, .znp-home h2, .znp-home h3,
    .znp-home h4, .znp-home h5, .znp-home h6 { margin: 0; font-weight: inherit; line-height: inherit; }
    .znp-home p                 { margin: 0; }
    .znp-home ul                { list-style: none; padding: 0; margin: 0; }

    /* ── HERO ── */
    .hero { background: var(--bg); padding: 32px 16px 40px; }
    .hero-inner {
        max-width: 1120px;
        margin: 0 auto;
        display: grid;
            grid-template-columns: 1fr 430px;
    gap: 132px;
        align-items: start;
    }
    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--white);
        border: 2px solid var(--border);
        border-radius: 100px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-muted);
        margin-bottom: 22px;
    }
    .eyebrow-dot      { width: 8px; height: 8px; background: var(--orange); border-radius: 50%; flex-shrink: 0; }
    .hero h1          { font-size: 30px !important; font-weight: 800 !important; line-height: 1.18 !important; color: var(--text) !important; margin-bottom: 16px !important; letter-spacing: -1.5px !important; }
    /* Ensure orange/colored words inside headings ALWAYS inherit the heading font-size */
    .hero h1 .orange,
    .section-title span,
    .how-title span,
    .employers-title span,
    .email-title span    { color: var(--orange); font-size: inherit !important; font-weight: inherit !important; }
    .hero-sub         { font-size: 16px; line-height: 1.65; margin-bottom: 28px !important; }
    .hero-sub mark      { background: var(--blue); color: #fff; padding: 2px 8px; border-radius: 4px; font-weight: 500; -webkit-box-decoration-break: clone; box-decoration-break: clone; }

    /* ── HERO SEARCH BAR ── */
    .hero-search {
        background: var(--white);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        display: flex;
        align-items: center;
        overflow: hidden;
        max-width: 520px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .hs-field {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 14px;
        flex: 1 1 0;
        border-right: 1px solid var(--border);
    }
    .hs-icon  { color: var(--text-light); flex-shrink: 0; width: 16px; height: 16px; }
    .hs-field input {
        border: none; outline: none; font-size: 14px; color: var(--text);
        font-family: 'Inter', sans-serif; width: 100%; padding: 13px 0; background: transparent;
    }
    .hs-field input::placeholder { color: var(--text-light); }
    .hs-city {
        display: flex; align-items: center; gap: 8px; padding: 0 16px; flex: 0 0 185px;
    }
    .hs-city input {
        border: none; outline: none; font-size: 14px; color: var(--text);
        font-family: 'Inter', sans-serif; width: 130px; padding: 13px 0; background: transparent;
    }
    .hs-city input::placeholder { color: var(--text-light); }
    .btn-find {
        background: var(--blue); color: var(--white); border: none;
        padding: 13px 22px; font-size: 14px; font-weight: 700; cursor: pointer;
        font-family: 'Inter', sans-serif; white-space: nowrap; transition: background 0.15s;
    }
    .btn-find:hover { background: var(--blue-dark); }

    /* ── HERO QUICK TAGS ── */
    .hero-tags { display: flex; gap: 8px; margin-top: 16px; flex-wrap: wrap; }
    .hero-tag  {
        background: transparent; border: 1.5px solid #d1d5db; border-radius: 100px;
        padding: 6px 16px; font-size: 13px; color: #374151; font-weight: 500;
        cursor: pointer; transition: all 0.15s; display: inline-flex; align-items: center;
    }
    .hero-tag:hover { border-color: var(--blue); color: var(--blue); background: #eef2ff; }

    /* ── AUTOCOMPLETE DROPDOWN ── */
    .znp-home .ui-autocomplete {
        background: var(--white);
        border: 1.5px solid var(--border);
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        max-height: 220px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 4px 0;
        z-index: 1100;
        list-style: none;
        margin: 6px 0 0;
    }
    .znp-home .ui-autocomplete .ui-menu-item {
        padding: 0;
        white-space: nowrap;
    }
    .znp-home .ui-autocomplete .ui-menu-item-wrapper {
        padding: 9px 16px;
        font-size: 13.5px;
        line-height: 1.35;
        font-family: 'Inter', sans-serif;
        color: var(--text);
        cursor: pointer;
    }
    .znp-home .ui-autocomplete .ui-menu-item-wrapper.ui-state-active,
    .znp-home .ui-autocomplete .ui-menu-item-wrapper:hover {
        background: #eef2ff;
        color: var(--blue);
        border: none;
    }
    .znp-home .ui-autocomplete .highlight {
        font-weight: 700;
        color: var(--blue);
    }

    /* ── LIVE JOBS PANEL ── */
    .live-panel {
        background: var(--white); border: 1px solid var(--border); border-radius: 14px;
        overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    }
    .live-panel-header {
        display: flex; justify-content: space-between; align-items: center;
        padding: 10px 20px; border-bottom: 1px solid var(--border);
    }
    .live-label   { font-size: 12px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 7px; }
    .live-dot     { width: 9px; height: 9px; background: #22c55e; border-radius: 50%; animation: blink 1.5s infinite; flex-shrink: 0; }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }
    .open-count   { font-size: 13px; color: var(--text-muted); }
    .live-job {
        display: flex; align-items: center; gap: 12px; padding: 8px 20px;
        border-bottom: 1px solid #f3f4f6; transition: background 0.12s; cursor: pointer; text-decoration: none;
    }
    .live-job:hover              { background: #f9fafb; }
    .live-job:last-of-type       { border-bottom: none; }
    .job-avatar {
        width: 42px; height: 42px; border-radius: 10px; font-size: 11px; font-weight: 800;
        color: var(--white); display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .ja-znp { background: var(--blue); }
    .ja-fs  { background: #f97316; }
    .ja-yx  { background: #7c3aed; }
    .live-job-info       { flex: 1; min-width: 0; }
    .live-job-title      { font-size: 12px; font-weight: 700; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .live-job-company    { font-size: 12.5px; color: var(--text-muted); margin-top: 3px; }
    .work-badge          { font-size: 11.5px; font-weight: 600; padding: 3px 10px; border-radius: 100px; flex-shrink: 0; }
    .wb-remote           { background: #fef3c7; color: #92400e; }
    .wb-hybrid           { background: #dbeafe; color: #1d4ed8; }
    .wb-wfo              { background: #dcfce7; color: #166534; }
    .btn-browse {
        display: block; margin: 16px 20px 20px; background: var(--orange); color: var(--white) !important;
        border: none; border-radius: 10px; padding: 13px; font-size: 15px; font-weight: 700;
        text-align: center; cursor: pointer; font-family: 'Inter', sans-serif;
        transition: background 0.15s; text-decoration: none;
    }
    .btn-browse:hover { background: var(--orange-dark); }

    /* ── STATS BAR ── */
    .stats-bar   { background: var(--blue); padding: 32px 40px; }
    .stats-inner { max-width: 1120px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); }
    .stat-item   { text-align: center; }
    .stat-num    { font-size: 36px; font-weight: 800; color: var(--white); letter-spacing: -1px; margin-bottom: 6px; }
    .stat-num .hi { color: var(--orange); }
    .stat-lbl    { font-size: 13px; color: rgba(255,255,255,0.65); font-weight: 500; }

    /* ── SECTION WRAPPER ── */
    .section-wrap  { max-width: 1120px; margin: 0 auto; padding: 48px 40px; }
    .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .section-title { font-size: 22px; font-weight: 800; color: var(--text); }
    .section-title span { color: var(--orange); }
    .see-all {
        display: inline-flex; align-items: center; gap: 7px;
        font-size: 13px; font-weight: 700; color: var(--blue); text-decoration: none;
        padding: 8px 18px; border-radius: 100px;
        border: 1.5px solid var(--blue);
        background: #fff;
        transition: all 0.18s ease;
        white-space: nowrap;
    }
    .see-all span { font-size: 15px; line-height: 1; }
    .see-all:hover {
        background: var(--blue); color: #fff; text-decoration: none;
    }

    /* ── FILTER TABS ── */
    .filter-tabs { display: flex; gap: 6px; margin-bottom: 24px; flex-wrap: wrap; row-gap: 6px; }
    .tab {
        border: 1.5px solid var(--border); background: var(--white); color: var(--text-muted);
        padding: 5px 12px; border-radius: 100px; font-size: 11.5px; font-weight: 600;
        cursor: pointer; transition: all 0.15s; font-family: 'Inter', sans-serif; white-space: nowrap;
    }
    .tab.active         { background: var(--blue); color: var(--white); border-color: var(--blue); }
    .tab:hover:not(.active) { border-color: var(--blue); color: var(--blue); }

    /* ── JOB CARDS GRID ── */
    .jobs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
    /* .job-card, .jc-top, .jc-avatar, .jc-title, .jc-company,
       .jc-tags, .tag and all tag colours → znp-common.css          */
    .av-1 { background: var(--blue); }
    .av-2 { background: #f97316; }
    .av-3 { background: #0891b2; }
    .av-4 { background: #7c3aed; }
    .av-5 { background: #16a34a; }
    .av-6 { background: #db2777; }
    .av-7 { background: #ea580c; }
    .av-8 { background: #0d9488; }
    .jc-meta    { flex: 1; min-width: 0; }
    .jc-loc     { font-size: 11px; color: var(--text-light); font-weight: 500; margin-top: 2px; }
    .jc-bottom  { margin-top: auto; }
    .jc-footer  { display: flex; justify-content: space-between; align-items: center; }
    .jc-exp     { font-size: 12px; color: var(--text-light); font-weight: 500; }
    .salary     { font-size: 12px; color: #7a8fb0; font-weight: 500; }
    .btn-apply  {
        background: transparent; border: 1px solid #bfcfef; color: var(--blue);
        padding: 7px 18px; border-radius: 7px; font-size: 13px; font-weight: 600;
        cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.15s;
    }
    .btn-apply:hover { background: var(--blue); color: var(--white); border-color: var(--blue); }

    /* ── CATEGORIES ── */
    .cat-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;
    }
    .cat-card {
        background: var(--white); border: 1px solid var(--border); border-radius: 10px;
        padding: 16px 18px; display: flex; align-items: center; gap: 14px;
        cursor: pointer; transition: all 0.15s; text-decoration: none;
    }
    .cat-card:hover { border-color: var(--blue); box-shadow: 0 4px 16px rgba(26,63,170,0.1); transform: translateY(-2px); }
    .cat-icon   {
        width: 42px; height: 42px; border-radius: 12px; display: flex;
        align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;
    }
    .cat-name   { font-size: 13.5px; font-weight: 700; color: var(--text); line-height: 1.3; }
    .cat-count  { font-size: 11.5px; color: var(--text-muted); font-weight: 500; margin-top: 2px; }

    /* ── TOP EMPLOYERS ── */
    .employers-section {
        background: var(--white); border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border); padding: 44px 0;
    }
    .employers-inner  { max-width: 1120px; margin: 0 auto; padding: 0 40px; }
    .employers-header { text-align: center; margin-bottom: 32px; }
    .employers-title  { font-size: 20px; font-weight: 800; color: var(--text); letter-spacing: -0.3px; margin-bottom: 6px; }
    .employers-title span { color: var(--orange); }
    .employers-sub    { font-size: 13px; color: var(--text-muted); }
    .emp-carousel-outer {
        overflow: hidden; position: relative;
    }
    .emp-carousel-outer::before,
    .emp-carousel-outer::after {
        content: ''; position: absolute; top: 0; bottom: 0; width: 80px; z-index: 2; pointer-events: none;
    }
    .emp-carousel-outer::before { left: 0; background: linear-gradient(to right, var(--white), transparent); }
    .emp-carousel-outer::after  { right: 0; background: linear-gradient(to left, var(--white), transparent); }
    .emp-carousel-track {
        display: flex; gap: 12px; animation: empScroll 40s linear infinite; width: max-content; align-items: center;
    }
    .emp-carousel-track:hover { animation-play-state: paused; }
    @keyframes empScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    .emp-chip {
        display: inline-flex; align-items: center; gap: 8px; background: var(--white);
        border: 1px solid var(--border); border-radius: 10px; padding: 10px 18px;
        font-size: 13px; font-weight: 700; color: var(--text); white-space: nowrap;
        cursor: pointer; transition: all 0.18s; box-shadow: 0 1px 6px rgba(0,0,0,0.06);
    }
    .emp-chip:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(26,63,170,0.13); border-color: #c7d5f8; }
    .emp-chip .ec-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .emp-chip-logo {
        min-width: 148px; min-height: 62px; justify-content: center; padding: 14px 20px;
    }
    .emp-logo-img {
        width: auto; height: 28px; max-width: 118px; object-fit: contain; display: block;
        filter: saturate(1.02) contrast(1.02);
    }

    /* ── HOW IT WORKS ── */
    .how-section {
        background: var(--white); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 56px 40px;
    }
    .how-inner  { max-width: 1120px; margin: 0 auto; }
    .how-title  { text-align: center; font-size: 26px; font-weight: 800; color: var(--text); margin-bottom: 48px; letter-spacing: -0.5px; }
    .how-title span { color: var(--orange); }
    .how-steps  { display: grid; grid-template-columns: repeat(4, 1fr); position: relative; }
    .how-line   { position: absolute; top: 24px; left: 12.5%; right: 12.5%; height: 2px; background: var(--border); z-index: 0; }
    .step       { text-align: center; position: relative; z-index: 1; padding: 0 20px; }
    .step-num   {
        width: 48px; height: 48px; background: var(--blue); color: var(--white); border-radius: 50%;
        font-size: 18px; font-weight: 800; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px; border: 3px solid var(--bg);
    }
    .step-title { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 8px; }
    .step-desc  { font-size: 13px; color: var(--text-muted); line-height: 1.6; }

    /* ── DUAL CTA CARDS ── */
    .dual-section {
        max-width: 1120px; margin: 0 auto; padding: 48px 40px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
    }
    .dual-card  { border-radius: 16px; padding: 36px; }
    .dc-blue    { background: var(--blue); }
    .dc-peach   { background: #fff8f5; border: 1.5px solid #fde4d0; }
    .dc-label   { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 14px; }
    .dc-blue .dc-label  { color: rgba(255,255,255,0.5); }
    .dc-peach .dc-label { color: var(--orange); }
    .dc-title   { font-size: 26px; font-weight: 800; line-height: 1.25; margin-bottom: 14px; letter-spacing: -0.5px; }
    .dc-blue .dc-title  { color: var(--white); }
    .dc-peach .dc-title { color: var(--text); }
    .dc-desc    { font-size: 14px; line-height: 1.65; margin-bottom: 24px !important; }
    .dc-blue .dc-desc   { color: rgba(255,255,255,0.7); }
    .dc-peach .dc-desc  { color: var(--text-muted); }
    .dc-list    { list-style: none; margin-bottom: 28px !important; display: flex; flex-direction: column; gap: 10px; }
    .dc-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; line-height: 1.45; }
    .dc-blue .dc-list li  { color: rgba(255,255,255,0.85); }
    .dc-peach .dc-list li { color: var(--text); }
    .dc-bullet  { width: 6px; height: 6px; border-radius: 50%; background: var(--orange); flex-shrink: 0; margin-top: 5px; }
    .dc-cta {
        display: inline-block; padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 700;
        text-decoration: none; cursor: pointer; border: none; transition: all 0.15s; font-family: 'Inter', sans-serif;
    }
    .dc-blue .dc-cta        { background: var(--orange); color: var(--white); }
    .dc-blue .dc-cta:hover  { background: var(--orange-dark); }
    .dc-peach .dc-cta       { background: var(--blue); color: var(--white); }
    .dc-peach .dc-cta:hover { background: var(--blue-dark); }

    /* ── EMAIL CTA ── */
    .email-section  { background: var(--white); padding: 56px 40px; text-align: center; border-top: 1px solid var(--border); }
    .email-inner    { max-width: 560px; margin: 0 auto; }
    .email-title    { font-size: 28px !important; font-weight: 800 !important; color: var(--text) !important; margin-bottom: 10px !important; letter-spacing: -0.5px !important; }
    .email-sub      { font-size: 15px; color: var(--text-muted); margin-bottom: 28px !important; }
    .cta-btns       { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
    .cta-btn-primary {
        background: var(--blue) !important; color: #fff !important; border: none !important;
        border-radius: 8px !important; padding: 14px 32px !important;
        font-size: 14px !important; font-weight: 700 !important; cursor: pointer;
        transition: all 0.15s; display: inline-block; text-decoration: none;
    }
    .cta-btn-primary:hover { background: var(--blue-dark) !important; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(26,63,170,0.2); }
    .cta-btn-secondary {
        background: transparent !important; color: var(--blue) !important;
        border: 1.5px solid #b8c9ee !important; border-radius: 8px !important;
        padding: 14px 32px !important; font-size: 14px !important; font-weight: 600 !important;
        cursor: pointer; transition: all 0.15s; display: inline-block; text-decoration: none;
    }
    .cta-btn-secondary:hover { background: #eef2ff !important; border-color: var(--blue) !important; }

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
        .hero          { padding: 32px 16px 40px; }
        .hero h1       { font-size: 30px; }
        /* ── Hero search: stack vertically ── */
        .hero-search   {
            flex-direction: column;
            max-width: 100%;
            border-radius: 12px;
            overflow: hidden;
        }
        .hs-field {
            border-right: none;
            border-bottom: 1px solid var(--border);
            width: 100%;
            padding: 0 14px;
        }
        .hs-city {
            flex: none;
            width: 100%;
            padding: 0 14px;
            border-bottom: 1px solid var(--border);
        }
        .hs-city input { width: 100%; }
        .btn-find {
            width: 100%;
            padding: 14px 22px;
            text-align: center;
            border-radius: 0;
        }
        /* ── Category cards: 2-col, compact ── */
        .cat-grid  { grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .cat-card  { padding: 12px; gap: 10px; }
        .cat-icon  { width: 36px; height: 36px; font-size: 17px; }
        .cat-name  { font-size: 12.5px; }
        .cat-count { font-size: 11px; }
        .jobs-grid     { grid-template-columns: 1fr; }
        .section-wrap,
        .dual-section  { padding-left: 16px; padding-right: 16px; }
        .how-steps     { grid-template-columns: 1fr; }
        .email-form    { flex-direction: column; }
        .stats-bar     { padding: 24px 16px; }
        .how-section   { padding: 40px 16px; }
        .employers-section { padding: 24px 0; }
        .employers-inner   { padding: 0 16px; }
    }
</style>
@endpush

{{-- ══════════════════════════════════════
     PAGE CONTENT
══════════════════════════════════════ --}}
@section('content')
@include('znp.header')
<div class="znp-home">

@php
    $formatStat = function ($value) {
        $value = (int) $value;
        if ($value >= 1000) {
            return rtrim(rtrim(number_format($value / 1000, 1), '0'), '.') . 'K+';
        }
        return $value . '+';
    };
@endphp

{{-- ── HERO ── --}}
<section class="hero">
    <div class="hero-inner">
        <div>
            <div class="hero-eyebrow">
                <span class="eyebrow-dot"></span>
                Dedicated Job Portal For Immediate Joiners
            </div>
            <h1>India's exclusive pool of<br><span class="orange">immediately available </span>talent.</h1>
            <p class="hero-sub"><mark style="
    font-size: 13px;
">Hire talent with zero notice period now!</mark></p>

            <div class="hero-search" role="search">
                <div class="hs-field">
                    <svg class="hs-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" id="skillInput" placeholder="Role, skill or keyword" aria-label="Search by role, skill or keyword">
                </div>
                <div class="hs-city">
                    <svg class="hs-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                    <input type="text" id="cityInput" placeholder="City" aria-label="Filter by city">
                </div>
                <button class="btn-find" id="heroSearchBtn">Find jobs</button>
            </div>

            <div class="hero-tags">
                @foreach ([
                    ['label' => 'Remote',    'keyword' => 'Remote/WFH'],
                    ['label' => 'Contract',  'keyword' => 'Contract'],
                    ['label' => 'Hybrid',    'keyword' => 'Hybrid'],
                    ['label' => 'Permanent', 'keyword' => 'Full Time'],
                    ['label' => 'Freshers',  'keyword' => 'Fresher'],
                ] as $tag)
                    <a class="hero-tag" href="{{ url('/jobs') . '?q=' . urlencode($tag['keyword']) }}" target="_blank" rel="noopener noreferrer">{{ $tag['label'] }}</a>
                @endforeach
            </div>
        </div>

        {{-- ── LIVE JOBS PANEL ── --}}
        <div class="live-panel">
            <div class="live-panel-header">
                <span class="live-label">
                    <span class="live-dot" aria-hidden="true"></span>Hot Jobs
                </span>
                <span class="open-count">{{ $totalJobs }}+ open roles</span>
            </div>

            @forelse ($hotJobs as $hotJob)
                @php
                    $companyName = $hotJob->company->name ?? 'ZNP';
                    $initials    = strtoupper(mb_substr(preg_replace('/[^A-Za-z ]/', '', $companyName), 0, 3));
                    $colors      = ['ja-znp', 'ja-fs', 'ja-yx'];
                    $colorClass  = $colors[$loop->index % count($colors)];
                    $wm          = $hotJob->work_mode ?? '';
                    $badgeClass  = (stripos($wm, 'remote') !== false) ? 'wb-remote'
                                 : ((stripos($wm, 'hybrid') !== false) ? 'wb-hybrid' : 'wb-wfo');
                    $badgeLabel  = (stripos($wm, 'remote') !== false) ? 'Remote'
                                 : ((stripos($wm, 'hybrid') !== false) ? 'Hybrid' : 'WFO');
                    $rawHotLoc   = $hotJob->location ?? '';
                    $hotLocArr   = (@unserialize($rawHotLoc) !== false && is_array(@unserialize($rawHotLoc)))
                                 ? @unserialize($rawHotLoc) : [$rawHotLoc];
                    $hotCityMap  = ['bangalore' => 'Bengaluru', 'bengaluru' => 'Bengaluru',
                                    'hyderabad' => 'Hyderabad', 'secunderabad' => 'Hyderabad',
                                    'chennai' => 'Chennai', 'mumbai' => 'Mumbai',
                                    'navi mumbai' => 'Mumbai', 'andheri' => 'Mumbai',
                                    'delhi' => 'Delhi', 'noida' => 'Delhi',
                                    'gurgaon' => 'Gurgaon', 'gurugram' => 'Gurgaon',
                                    'pune' => 'Pune', 'kolkata' => 'Kolkata'];
                    $hotCity = '';
                    foreach ($hotLocArr as $hl) {
                        foreach ($hotCityMap as $kw => $cn) {
                            if (stripos($hl, $kw) !== false) { $hotCity = $cn; break 2; }
                        }
                    }
                    if (!$hotCity && !empty($hotLocArr[0])) {
                        $hotCity = trim(explode('/', $hotLocArr[0])[0]);
                    }
                @endphp
                <a class="live-job" href="{{ url('/job/' . $hotJob->slug) }}" target="_blank">
                    <div class="job-avatar {{ $colorClass }}">{{ $initials }}</div>
                    <div class="live-job-info">
                        <div class="live-job-title">{{ $hotJob->job_title }}</div>
                        <div class="live-job-company">{{ $companyName }}@if($hotCity) &middot; {{ $hotCity }}@endif</div>
                    </div>
                    <span class="work-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                </a>
            @empty
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
            @endforelse

            <a class="btn-browse" href="{{ url('/jobs') }}">Browse all jobs &rarr;</a>
        </div>

    </div>
</section>

{{-- ── STATS BAR ── --}}
<div class="stats-bar">
    <div class="stats-inner">
        @php
            $stats = [
                ['num' => $totalJobs,       'label' => 'Active Jobs'],
                ['num' => $permanentJobs,   'label' => 'Permanent Jobs'],
                ['num' => $contractJobs,    'label' => 'Contract Jobs'],
                ['num' => $fresherJobs,     'label' => 'Fresher Jobs'],
            ];
        @endphp
        @foreach ($stats as $stat)
            <div class="stat-item">
                <div class="stat-num" >{{ $formatStat($stat['num']) }}<span class="hi" style="
    font-size: 36px !important;
"></span></div>
                <div class="stat-lbl">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>
</div>

{{-- ── LATEST JOBS ── --}}
<div class="section-wrap">
    <div class="section-header">
        <div class="section-title">Latest <span>jobs</span></div>
        <a class="see-all" href="{{ url('/jobs') }}" target="_blank" rel="noopener noreferrer">See all jobs <span aria-hidden="true">&#8594;</span></a>
    </div>

    {{-- City filter tabs — built dynamically from current live jobs --}}
    <div class="filter-tabs" role="tablist" aria-label="Filter jobs by city">
        <button class="tab active" role="tab" aria-selected="true" data-filter="all" onclick="filterJobs('all', this)">All</button>
        @foreach ($jobCities as $city)
            <button
                class="tab"
                role="tab"
                aria-selected="false"
                data-filter="{{ strtolower($city) }}"
                onclick="filterJobs('{{ strtolower($city) }}', this)"
            >{{ $city }}</button>
        @endforeach
        @if (!empty($hasOthers) && $hasOthers)
            <button class="tab" role="tab" aria-selected="false" data-filter="others" onclick="filterJobs('others', this)">Others</button>
        @endif
    </div>

    {{-- Job cards --}}
    <div class="jobs-grid" id="jobsGrid">
        @forelse ($latestJobs as $index => $job)
            @php
                $company     = $job->company;
                $companyName = $company->name ?? '';
                $initials    = strtoupper(mb_substr(preg_replace('/[^A-Za-z0-9]/', '', $companyName), 0, 3)) ?: 'JOB';
                $avColors    = ['av-1','av-2','av-3','av-4','av-5','av-6','av-7','av-8'];
                $avClass     = $avColors[$index % count($avColors)];
                $jobTypeName = $job->job_type ?? '';
                $typeClass   = (stripos($jobTypeName, 'contract') !== false) ? 't-contract' : 't-full';
                $wm          = $job->work_mode ?? '';
                $workMode    = (stripos($wm, 'remote') !== false) ? 'Remote'
                             : ((stripos($wm, 'hybrid') !== false) ? 'Hybrid' : 'Work from office');
                $workClass   = (stripos($wm, 'remote') !== false) ? 't-remote'
                             : ((stripos($wm, 'hybrid') !== false) ? 't-hybrid' : 't-wfo');
                $expName     = $job->experience ?? '';
                $minSal      = $job->min_salary;
                $maxSal      = $job->max_salary;
                $salaryStr   = ($minSal && $maxSal) ? $minSal . '–' . $maxSal . ' LPA'
                             : ($minSal ? $minSal . '+ LPA' : '');
                // location is sometimes serialized PHP array
                $rawLoc      = $job->location ?? '';
                $locAllParts = (@unserialize($rawLoc) !== false && is_array(@unserialize($rawLoc)))
                             ? @unserialize($rawLoc)
                             : array_map('trim', explode(',', $rawLoc));
                $locAllParts = array_values(array_filter($locAllParts));
                $locDisplay  = (count($locAllParts) > 3)
                             ? implode(', ', array_slice($locAllParts, 0, 3)) . '...'
                             : implode(', ', $locAllParts);
                $isNew       = $job->created_at && $job->created_at->diffInDays(now()) <= 7;
                $cityNormMap2 = ['bangalore' => 'bengaluru', 'bengaluru' => 'bengaluru',
                                 'hyderabad' => 'hyderabad', 'secunderabad' => 'hyderabad',
                                 'chennai' => 'chennai', 'mumbai' => 'mumbai',
                                 'navi mumbai' => 'mumbai', 'andheri' => 'mumbai',
                                 'delhi' => 'delhi', 'noida' => 'delhi', 'ncr' => 'delhi',
                                 'gurgaon' => 'gurgaon', 'gurugram' => 'gurgaon',
                                 'pune' => 'pune', 'kolkata' => 'kolkata'];
                $citySlugs = [];
                $hasNonMetro = false;
                if ($locAllParts) {
                    foreach ($locAllParts as $singleLoc) {
                        $matchedMetro = false;
                        foreach ($cityNormMap2 as $kw => $slug) {
                            if (stripos($singleLoc, $kw) !== false) {
                                $citySlugs[] = $slug;
                                $matchedMetro = true;
                            }
                        }
                        if (!$matchedMetro && trim($singleLoc) !== '') $hasNonMetro = true;
                    }
                }
                if ($hasNonMetro) $citySlugs[] = 'others';
                $citySlug = implode(' ', array_values(array_unique($citySlugs)));
            @endphp
            <a class="job-card" href="{{ url('/job/' . $job->slug) }}" data-cat="{{ $citySlug }}">
                <div class="jc-top">
                    <div class="jc-avatar {{ $avClass }}">{{ $initials }}</div>
                    <div class="jc-meta">
                        <div class="jc-title">{{ $job->job_title }}</div>
                        <div class="jc-company">{{ $companyName }}</div>
                        @if ($locDisplay)<div class="jc-loc">{{ $locDisplay }}</div>@endif
                    </div>
                </div>
                <div class="jc-bottom">
                    <div class="jc-tags">
                        <span class="tag {{ $workClass }}">{{ $workMode }}</span>
                        @if ($jobTypeName)
                            <span class="tag {{ $typeClass }}">{{ $jobTypeName }}</span>
                        @endif
                        @if ($isNew)
                            <span class="tag t-new">New</span>
                        @endif
                    </div>
                    <div class="jc-footer">
                        <span class="jc-exp">
                            @if ($expName){{ $expName }} &nbsp;&middot;&nbsp;@endif
                            <span class="salary">{{ $salaryStr }}</span>
                        </span>
                        <button class="btn-apply" type="button" onclick="event.preventDefault(); window.location.href='{{ url('/job/' . $job->slug) }}'">Apply now</button>
                    </div>
                </div>
            </a>
        @empty
            <p style="color:var(--text-muted);font-size:14px;text-align:center;grid-column:1/-1;padding:48px 0;">No active jobs at the moment — please check back soon.</p>
        @endforelse
    </div>

    <div style="text-align: center; margin-top: 28px;">
        <a class="see-all" href="{{ url('/jobs') }}" target="_blank" rel="noopener noreferrer" style="font-size: 14px; padding: 12px 28px;">View all jobs <span aria-hidden="true">&#8594;</span></a>
    </div>

</div>

{{-- ── BROWSE BY CATEGORY ── --}}
<div class="section-wrap" style="padding-top: 0;">
    <div class="employers-header" style="text-align: left; margin-bottom: 20px;">
        <div class="employers-title">Browse by <span>category</span></div>
        <p class="employers-sub">Find roles that match your preferred work style and type</p>
    </div>

    <div class="cat-grid">
        @foreach ($categoryCards as $cat)
            <a class="cat-card" href="{{ url('/jobs') . '?' . (($cat['query_key'] ?? 'q') . '=' . urlencode($cat['keyword'])) }}" target="_blank" rel="noopener noreferrer">
                <div class="cat-icon" style="background: {{ $cat['bg'] }};" aria-hidden="true">{{ $cat['icon'] }}</div>
                <div>
                    <div class="cat-name">{{ $cat['name'] }}</div>
                    <div class="cat-count">{{ number_format($cat['count']) }} jobs</div>
                </div>
            </a>
        @endforeach
    </div>
</div>

{{-- ── TOP EMPLOYERS CAROUSEL ── --}}
<div class="employers-section">
    <div class="employers-inner">
        <div class="employers-header">
            <div class="employers-title">Top Employers <span>Across India</span></div>
            <p class="employers-sub">India's leading companies hiring zero notice talent</p>
        </div>

        {{-- Previous text-based employer strip kept for quick rollback.
        <div class="emp-carousel-outer" aria-label="Employer logos carousel" role="region">
            <div class="emp-carousel-track">
                @php
                    $employers = [
                        ['name' => 'Tech Mahindra', 'color' => '#ed1c24'],
                    ];
                    $allEmployers = array_merge($employers, $employers);
                @endphp
                @foreach ($allEmployers as $emp)
                    <span class="emp-chip">
                        <span class="ec-dot" style="background: {{ $emp['color'] }};" aria-hidden="true"></span>
                        {{ $emp['name'] }}
                    </span>
                @endforeach
            </div>
        </div>
        --}}

        <div class="emp-carousel-outer" aria-label="Employer logos carousel" role="region">
            <div class="emp-carousel-track">
                @php
                    $employerLogos = [
                        'client-logo5.png', 'client-logo6.png', 'client-logo7.png', 'client-logo8.png',
                        'client-logo1.png', 'client-logo2.png', 'client-logo3.png', 'client-logo4.png',
                        'client-logo9.png', 'client-logo10.png', 'client-logo11.png', 'client-logo12.png',
                        'client-logo13.png', 'client-logo14.png', 'client-logo16.png', 'client-logo17.png',
                        'client-logo19.png', 'client-logo20.png', 'client-logo21.png', 'client-logo22.png',
                        'client-logo23.png', 'client-logo24.png', 'client-logo15.png', 'client-logo18.png',
                    ];
                    $allEmployerLogos = array_merge($employerLogos, $employerLogos);
                @endphp
                @foreach ($allEmployerLogos as $logo)
                    <span class="emp-chip emp-chip-logo">
                        <img src="{{ asset('asset/images/' . $logo) }}" alt="Employer logo" class="emp-logo-img">
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ── HOW IT WORKS ── --}}
<section class="how-section">
    <div class="how-inner">
        <div class="how-title">How it <span>works</span></div>
        <div class="how-steps">
            <div class="how-line" aria-hidden="true"></div>
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
                    <div class="step-num" aria-hidden="true">{{ $step['num'] }}</div>
                    <div class="step-title">{{ $step['title'] }}</div>
                    <div class="step-desc">{{ $step['desc'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── DUAL CTA CARDS ── --}}
<div class="dual-section">

    <div class="dual-card dc-blue">
        <div class="dc-label">For Jobseekers</div>
        <div class="dc-title">Your next job.<br>This week.</div>
        <p class="dc-desc">No notice period? That's your superpower. Employers are looking for you right now.</p>
        <ul class="dc-list">
            <li><span class="dc-bullet" aria-hidden="true"></span>Apply with one click to verified jobs</li>
            <li><span class="dc-bullet" aria-hidden="true"></span>Get alerts for matching roles instantly</li>
            <li><span class="dc-bullet" aria-hidden="true"></span>Announce your interview availability</li>
            <li><span class="dc-bullet" aria-hidden="true"></span>100% free for jobseekers</li>
        </ul>
        <a class="dc-cta" href="{{ url('/jobs') }}">Browse jobs now</a>
    </div>

    <div class="dual-card dc-peach">
        <div class="dc-label">For Recruiters</div>
        <div class="dc-title">Hire in days,<br>not months.</div>
        <p class="dc-desc">Stop losing time chasing candidates with notice. Find verified immediate joiners today.</p>
        <ul class="dc-list">
            <li><span class="dc-bullet" aria-hidden="true"></span>Verified zero-notice-period database</li>
            <li><span class="dc-bullet" aria-hidden="true"></span>Applications from immediate joiners only</li>
            <li><span class="dc-bullet" aria-hidden="true"></span>Find contractors and permanent hires</li>
            <li><span class="dc-bullet" aria-hidden="true"></span>Buy bulk job posts</li>
        </ul>
        <a class="dc-cta" href="{{ url('/employer-login') }}">Post a job</a>
    </div>

</div>

<!-- EMAIL CTA -->
<section class="email-section">
  <div class="email-inner">
    <div class="email-title">Ready to <span>hire immediately?</span></div>
    <p class="email-sub">Join hundreds of employers already hiring zero notice period talent on ZeroNoticePeriod.</p>
    <div class="cta-btns">
            <button class="cta-btn-primary" onclick="window.location='{{ url('/employer-login') }}'">I'm an Employer</button>
      <button class="cta-btn-secondary" onclick="window.location='{{ url('/jobseeker-auth') }}'">I'm a Jobseeker</button>
    </div>
  </div>
</section>

</div>{{-- /.znp-home --}}
@include('znp.footer')

@endsection

{{-- ══════════════════════════════════════
     PAGE-SPECIFIC SCRIPTS
══════════════════════════════════════ --}}
@push('scripts')
<script>
    // ── HERO SEARCH ────────────────────────────────────────────
    function doSearch() {
        var skill = $('#skillInput').val().trim();
        var city  = $('#cityInput').val().trim();
        var params = new URLSearchParams();
        if (skill) params.set('q', skill);    // jobsPage() reads 'q' for keyword
        if (city)  params.set('loc', city);   // jobsPage() reads 'loc' for location
        var url = '/jobs' + (params.toString() ? '?' + params.toString() : '');
        window.open(url, '_blank');
    }

    $('#heroSearchBtn').on('click', doSearch);
    $('#skillInput, #cityInput').on('keydown', function(e) {
        if (e.key === 'Enter') {
            var instance = $(this).autocomplete('instance');
            if (instance && instance.menu && instance.menu.active) {
                return;
            }
            e.preventDefault();
            $('.ui-autocomplete').hide();
            doSearch();
        }
    });

    // ── SKILLS / KEYWORD AUTOCOMPLETE (same as /jobs page) ────
    $(function() {
        function split(val) { return val.split(/,\s*/); }
        function extractLast(term) { return split(term).pop(); }

        $('#skillInput')
            .on('keydown', function(e) {
                if (e.keyCode === $.ui.keyCode.TAB && $(this).autocomplete('instance').menu.active) {
                    e.preventDefault();
                }
            })
            .autocomplete({
                minLength: 2,
                appendTo: '.znp-home',
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('autocomplete/skillsposition') }}",
                        dataType: 'json',
                        data: { query: extractLast(request.term) },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return { label: item, value: item };
                            }));
                        }
                    });
                },
                focus: function() { return false; },
                select: function(event, ui) {
                    var terms = split(this.value);
                    terms.pop();
                    terms.push(ui.item.value);
                    terms.push('');
                    this.value = terms.join(', ');
                    return false;
                },
                open: function() {
                    var term = extractLast(this.value);
                    var ac = $(this).data('ui-autocomplete');
                    ac.menu.element.find('li').each(function() {
                        var item = $(this).data('ui-autocomplete-item');
                        if (item) {
                            var hl = item.label.replace(new RegExp($.ui.autocomplete.escapeRegex(term), 'gi'), '<span class="highlight">$&</span>');
                            $(this).find('.ui-menu-item-wrapper').html(hl);
                        }
                    });
                }
            });

        // ── LOCATION AUTOCOMPLETE (same as /jobs page) ────────────
        $('#cityInput')
            .on('keydown', function(e) {
                if (e.keyCode === $.ui.keyCode.TAB && $(this).autocomplete('instance').menu.active) {
                    e.preventDefault();
                }
            })
            .autocomplete({
                minLength: 1,
                appendTo: '.znp-home',
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('autocomplete/search-location-job1') }}",
                        dataType: 'json',
                        data: { query: request.term },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return { label: item, value: item };
                            }));
                        }
                    });
                },
                focus: function() { return false; },
                select: function(event, ui) {
                    this.value = ui.item.value;
                    return false;
                },
                open: function() {
                    var term = this.value;
                    var ac = $(this).data('ui-autocomplete');
                    ac.menu.element.find('li').each(function() {
                        var item = $(this).data('ui-autocomplete-item');
                        if (item) {
                            var hl = item.label.replace(new RegExp($.ui.autocomplete.escapeRegex(term), 'gi'), '<span class="highlight">$&</span>');
                            $(this).find('.ui-menu-item-wrapper').html(hl);
                        }
                    });
                }
            });
    });

    // ── JOB CARDS CITY FILTER ─────────────────────────────────
    function filterJobs(cat, btn) {
        document.querySelectorAll('.tab').forEach(function (t) {
            t.classList.remove('active');
            t.setAttribute('aria-selected', 'false');
        });
        btn.classList.add('active');
        btn.setAttribute('aria-selected', 'true');

        // For all locations (including "all"), fetch fresh jobs via AJAX
        var gridContainer = document.getElementById('jobsGrid');
        gridContainer.style.opacity = '0.5';
        gridContainer.style.pointerEvents = 'none';

        $.ajax({
            url: "{{ url('/jobs-by-location') }}",
            type: 'GET',
            data: { location: cat },
            dataType: 'json',
            success: function(response) {
                // Clear and repopulate the grid
                gridContainer.innerHTML = response.html;
                gridContainer.style.opacity = '1';
                gridContainer.style.pointerEvents = 'auto';

                // Animate cards entrance
                var idx = 0;
                document.querySelectorAll('#jobsGrid .job-card').forEach(function (card) {
                    card.style.opacity    = '0';
                    card.style.transform  = 'translateY(8px)';
                    card.style.transition = 'opacity .22s ease ' + (idx * 0.04) + 's, transform .22s ease ' + (idx * 0.04) + 's';
                    (function (c) {
                        requestAnimationFrame(function () { c.style.opacity = '1'; c.style.transform = 'translateY(0)'; });
                    })(card);
                    idx++;
                });
            },
            error: function() {
                gridContainer.style.opacity = '1';
                gridContainer.style.pointerEvents = 'auto';
                console.error('Failed to load jobs for location: ' + cat);
            }
        });
    }
</script>
@endpush
