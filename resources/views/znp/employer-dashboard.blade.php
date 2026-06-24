@extends('layouts.znp')

@section('page_title', 'Employer Dashboard | ZeroNoticePeriod')

@php
    $displayCompanyName = trim((string) ($companyDisplayName ?? ($company->name ?? '')));
    $displayCompanyName = $displayCompanyName !== '' ? $displayCompanyName : 'Employer';
    $words = preg_split('/\s+/', $displayCompanyName);
    $companyInitials = '';
    foreach (array_slice($words, 0, 2) as $w) {
        $companyInitials .= $w !== '' ? strtoupper(mb_substr($w, 0, 1)) : '';
    }
    $companyInitials = $companyInitials ?: 'EM';
@endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ── ZNP EMPLOYER DASHBOARD: scoped tokens (never leak to header/footer) ── */
.znp-ed {
    --ed-blue:       #3B5CCC;
    --ed-blue-d:     #2d47a3;
    --ed-blue-50:    #EEF1FB;
    --ed-blue-100:   #D6DEFC;
    --ed-orange:     #F2994A;
    --ed-orange-d:   #e0852e;
    --ed-orange-50:  #FEF3E8;
    --ed-orange-100: #fde8c8;
    --ed-green:      #15803d;
    --ed-green-50:   #f0fdf4;
    --ed-green-100:  #dcfce7;
    --ed-purple:     #7c3aed;
    --ed-purple-50:  #f5f3ff;
    --ed-purple-100: #ede9fe;
    --ed-teal:       #0f766e;
    --ed-teal-50:    #f0fdfa;
    --ed-teal-100:   #ccfbf1;
    --ed-amber:      #d97706;
    --ed-amber-50:   #fffbeb;
    --ed-amber-100:  #fde68a;
    --ed-bg:         #F7F8FC;
    --ed-surface:    #fff;
    --ed-border:     #E7EAF3;
    --ed-text:       #2F3443;
    --ed-t2:         #4A5068;
    --ed-t3:         #717A96;
    --ed-t4:         #A0AABF;
    --ed-font:       'Manrope', sans-serif;
    --ed-sw:         218px;
    --ed-r:          12px;
    --ed-r-sm:       8px;
    --ed-sh:         0 1px 3px rgba(59,92,204,.05), 0 1px 2px rgba(47,52,67,.04);
    --ed-sh-md:      0 4px 16px rgba(59,92,204,.08), 0 2px 6px rgba(47,52,67,.04);
}

/* ── SCOPE & RESET ── */
.znp-ed, .znp-ed * {
    font-family: var(--ed-font), 'Inter', sans-serif !important;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}
.znp-ed { background: var(--ed-bg); color: var(--ed-text); font-size: 12px; }
.znp-ed a { color: inherit; text-decoration: none; }
.znp-ed h1, .znp-ed h2, .znp-ed h3, .znp-ed h4 { margin: 0; font-weight: inherit; }
.znp-ed p { margin: 0; }
.znp-ed ul { list-style: none; padding: 0; margin: 0; }
.znp-ed button { cursor: pointer; border: none; background: none; padding: 0; }

/* ── LAYOUT ── */
.znp-ed .ed-layout { display: flex; min-height: 100vh; }

/* ── SIDEBAR ── */
.znp-ed .ed-sidebar {
    width: var(--ed-sw);
    background: var(--ed-surface);
    border-right: 1px solid var(--ed-border);
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    display: flex;
    flex-direction: column;
    z-index: 900;
    overflow-y: auto;
    transition: transform .25s ease;
    scrollbar-width: thin;
    scrollbar-color: var(--ed-border) transparent;
}
.znp-ed .ed-sidebar::-webkit-scrollbar { width: 4px; }
.znp-ed .ed-sidebar::-webkit-scrollbar-thumb {
    background: var(--ed-border);
    border-radius: 10px;
}
.znp-ed .ed-sidebar::-webkit-scrollbar-track {
    background: transparent;
}

/* ── SIDEBAR LOGO ── */
.znp-ed .ed-sb-logo { padding: 16px 16px 13px; border-bottom: 1px solid var(--ed-border); flex-shrink: 0; }
.znp-ed .ed-sb-logo-mark { font-size: 15px; font-weight: 800; letter-spacing: -.3px; }
.znp-ed .ed-sb-la, .znp-ed .ed-sb-lc { color: var(--ed-blue); }
.znp-ed .ed-sb-lb { color: var(--ed-orange); }
.znp-ed .ed-sb-logo-sub { font-size: 9.5px; color: var(--ed-t4); margin-top: 3px; letter-spacing: .1em; text-transform: uppercase; font-weight: 600; }

/* ── NAV ── */
.znp-ed .ed-nav-grp { padding: 10px 0 4px; }
.znp-ed .ed-nav-lbl {
    font-size: 9.5px; font-weight: 700; color: var(--ed-t4);
    text-transform: uppercase; letter-spacing: .1em; padding: 0 14px 5px;
}
.znp-ed .ed-nav-item {
    display: flex; align-items: center; gap: 9px;
    padding: 8px 14px; font-size: 12px; font-weight: 500;
    color: var(--ed-t3); transition: all .15s;
    border-left: 2px solid transparent;
    width: 100%; text-align: left; background: none; outline: none;
}
.znp-ed .ed-nav-item:hover { color: var(--ed-text); background: var(--ed-bg); }
.znp-ed .ed-nav-item.is-active {
    color: var(--ed-blue); background: var(--ed-blue-50);
    border-left-color: var(--ed-blue); font-weight: 700;
}
.znp-ed .ed-nav-icon { width: 14px; height: 14px; flex-shrink: 0; stroke: currentColor; opacity: .65; }
.znp-ed .ed-nav-item.is-active .ed-nav-icon { opacity: 1; }
.znp-ed .ed-nav-arrow {
    margin-left: auto; width: 10px; height: 10px; flex-shrink: 0;
    transition: transform .2s; stroke: currentColor; fill: none;
}

.znp-ed .ed-nav-sub {
    max-height: 0; overflow: hidden; transition: max-height .28s ease;
    padding-left: 36px;
}
.znp-ed .ed-nav-sub.is-open { max-height: 420px; }
.znp-ed .ed-nav-sub-item {
    display: flex; align-items: center; gap: 5px;
    padding: 5px 14px 5px 0; font-size: 11px; color: var(--ed-t3);
    font-weight: 500; transition: color .12s;
}
.znp-ed .ed-nav-sub-item:hover { color: var(--ed-blue); }

.znp-ed .ed-nbadge {
    margin-left: auto; background: var(--ed-blue-50); color: var(--ed-blue);
    border: 1px solid var(--ed-blue-100); font-size: 9.5px; font-weight: 700;
    padding: 1px 6px; border-radius: 50px;
}

/* ── PLAN CARD ── */
.znp-ed .ed-plan-card {
    margin: 14px 10px 0; background: var(--ed-blue-50);
    border: 1px solid var(--ed-blue-100); border-radius: var(--ed-r-sm); padding: 11px 13px;
}
.znp-ed .ed-plan-card.is-none    { background: #fff7ed; border-color: #fed7aa; }
.znp-ed .ed-plan-card.is-warn    { background: #fff7ed; border-color: #fed7aa; }
.znp-ed .ed-plan-card.is-full    { background: #fef2f2; border-color: #fecaca; }
.znp-ed .ed-plan-card.is-expired { background: #fef2f2; border-color: #fecaca; }

.znp-ed .ed-plan-head { display: flex; align-items: center; justify-content: space-between; gap: 6px; margin-bottom: 2px; }
.znp-ed .ed-plan-name { font-size: 11px; font-weight: 700; color: var(--ed-blue); }
.znp-ed .ed-plan-card.is-warn    .ed-plan-name,
.znp-ed .ed-plan-card.is-none    .ed-plan-name { color: #c2410c; }
.znp-ed .ed-plan-card.is-full    .ed-plan-name,
.znp-ed .ed-plan-card.is-expired .ed-plan-name { color: #b91c1c; }
.znp-ed .ed-plan-tag { font-size: 9px; font-weight: 700; padding: 1px 6px; border-radius: 20px; background: rgba(59,92,204,.12); color: var(--ed-blue); text-transform: uppercase; letter-spacing: .04em; }
.znp-ed .ed-plan-card.is-warn .ed-plan-tag,
.znp-ed .ed-plan-card.is-none .ed-plan-tag { background: rgba(234,88,12,.14); color: #c2410c; }
.znp-ed .ed-plan-card.is-full .ed-plan-tag,
.znp-ed .ed-plan-card.is-expired .ed-plan-tag { background: rgba(185,28,28,.12); color: #b91c1c; }
.znp-ed .ed-plan-desc { font-size: 10.5px; color: var(--ed-t3); line-height: 1.5; }

.znp-ed .ed-plan-bar { height: 4px; background: rgba(59,92,204,.15); border-radius: 4px; overflow: hidden; margin: 8px 0 6px; }
.znp-ed .ed-plan-bar-fill { height: 100%; background: var(--ed-blue); border-radius: 4px; transition: width .4s; }
.znp-ed .ed-plan-card.is-warn .ed-plan-bar-fill { background: var(--ed-orange); }
.znp-ed .ed-plan-card.is-full .ed-plan-bar-fill,
.znp-ed .ed-plan-card.is-expired .ed-plan-bar-fill { background: #ef4444; }
.znp-ed .ed-plan-meta { display: flex; align-items: center; justify-content: space-between; font-size: 10.5px; color: var(--ed-t3); font-weight: 600; }

.znp-ed .ed-plan-upgrade {
    display: block; margin-top: 8px; width: 100%; padding: 7px;
    background: var(--ed-orange); color: #fff !important; border: none;
    border-radius: 50px; font-size: 11.5px; font-weight: 700;
    text-align: center; text-decoration: none !important; transition: opacity .15s;
}
.znp-ed .ed-plan-upgrade:hover { opacity: .9; }
.znp-ed .ed-plan-card.is-default .ed-plan-upgrade { background: var(--ed-blue); }
.znp-ed .ed-plan-card.is-default .ed-plan-upgrade:hover { background: var(--ed-blue-d); }

/* ── HELP CARD ── */
.znp-ed .ed-help-card {
    margin: 9px 10px 0;
    background: linear-gradient(135deg, var(--ed-blue-50), #e8eeff);
    border: 1px solid var(--ed-blue-100); border-radius: var(--ed-r-sm); padding: 14px 13px;
}
.znp-ed .ed-help-title { font-size: 11px; font-weight: 800; color: var(--ed-blue); margin-bottom: 4px; }
.znp-ed .ed-help-text { font-size: 10.5px; color: var(--ed-t3); line-height: 1.55; margin-bottom: 10px; }
.znp-ed .ed-help-mail {
    display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 10.5px; font-weight: 600;
    color: var(--ed-blue) !important; background: var(--ed-blue-50);
    border: 1px solid var(--ed-blue-100); border-radius: 50px;
    padding: 5px 10px; margin-bottom: 7px; white-space: nowrap;
    overflow: hidden; text-overflow: ellipsis; text-decoration: none !important;
}
.znp-ed .ed-help-mail:hover { background: var(--ed-blue-100); }
.znp-ed .ed-help-call {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 7px; background: var(--ed-blue); color: #fff !important;
    border: none; border-radius: 50px; font-size: 11.5px; font-weight: 700;
    text-decoration: none !important; transition: background .15s;
}
.znp-ed .ed-help-call:hover { background: var(--ed-blue-d); }

/* ── SIDEBAR FOOTER ── */
.znp-ed .ed-sb-footer { margin-top: auto; padding: 13px 14px; border-top: 1px solid var(--ed-border); }
.znp-ed .ed-sf-name { font-size: 12px; font-weight: 700; color: var(--ed-text); }
.znp-ed .ed-sf-sub { font-size: 10.5px; color: var(--ed-t3); margin-top: 2px; }

/* ── MAIN ── */
.znp-ed .ed-main {
    margin-left: var(--ed-sw); flex: 1;
    display: flex; flex-direction: column;
    width: calc(100% - var(--ed-sw)); min-width: 0;
}

/* ── TOPBAR ── */
.znp-ed .ed-topbar {
    background: var(--ed-surface); border-bottom: 1px solid var(--ed-border);
    padding: 0 26px; min-height: 56px; display: flex; align-items: center;
    justify-content: space-between; gap: 12px;
    position: sticky; top: 0; z-index: 850;
    box-shadow: var(--ed-sh);
}
.znp-ed .ed-tb-menu {
    display: none; align-items: center; justify-content: center;
    width: 40px; height: 40px; border: 1.5px solid var(--ed-border) !important;
    border-radius: 10px; background: var(--ed-surface); flex-shrink: 0;
    color: var(--ed-t2);
}
.znp-ed .ed-tb-left { flex: 1; min-width: 0; }
.znp-ed .ed-tb-title { font-size: 14px; font-weight: 800; color: var(--ed-text); letter-spacing: -.3px; }
.znp-ed .ed-tb-sub { font-size: 11.5px; color: var(--ed-blue); margin-top: 2px; font-weight: 500; }
.znp-ed .ed-co-wrap { display: flex; align-items: center; gap: 10px; flex-shrink: 0; min-width: 0; }
.znp-ed .ed-co-av {
    width: 36px; height: 36px; border-radius: 9px; background: var(--ed-blue-50);
    border: 1px solid var(--ed-blue-100); color: var(--ed-blue); font-size: 12px;
    font-weight: 800; display: flex; align-items: center; justify-content: center;
    overflow: hidden; flex-shrink: 0;
}
.znp-ed .ed-co-av img { width: 100%; height: 100%; object-fit: cover; border-radius: 9px; }
.znp-ed .ed-co-name {
    font-size: 13px; font-weight: 700; color: var(--ed-text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;
}
.znp-ed .ed-co-sub {
    font-size: 11px; color: var(--ed-t4); font-weight: 500;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;
}
.znp-ed .ed-logout-form { margin: 0; }
.znp-ed .ed-logout-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: 5px;
    padding: 5px 12px; border-radius: 50px; font-size: 11px; font-weight: 700;
    color: var(--ed-blue) !important; background: var(--ed-blue-50);
    border: 1px solid var(--ed-blue-100); transition: all .15s;
}
.znp-ed .ed-logout-btn:hover { background: var(--ed-blue-100); }

/* ── CONTENT ── */
.znp-ed .ed-content { padding: 22px 26px; }

/* ── HERO ── */
.znp-ed .ed-hero {
    background: var(--ed-surface); border: 1px solid var(--ed-border);
    border-radius: var(--ed-r); padding: 28px 32px; margin-bottom: 18px;
    text-align: center; position: relative; overflow: hidden; box-shadow: var(--ed-sh);
}
.znp-ed .ed-hero::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--ed-blue), var(--ed-orange));
}
.znp-ed .ed-hero-eyebrow {
    font-size: 10.5px; color: var(--ed-t4); text-transform: uppercase;
    letter-spacing: .1em; margin-bottom: 8px; font-weight: 600;
}
.znp-ed .ed-hero-title { font-size: 22px; font-weight: 800; color: var(--ed-text); letter-spacing: -.5px; margin-bottom: 6px; }
.znp-ed .ed-hero-badge {
    display: inline-flex; align-items: center; gap: 6px; flex-wrap: wrap; justify-content: center;
    font-size: 12px; color: var(--ed-blue); background: var(--ed-blue-50);
    border: 1px solid var(--ed-blue-100); border-radius: 50px;
    padding: 5px 16px; margin-bottom: 22px; font-weight: 600;
}
.znp-ed .ed-cta-row { display: flex; gap: 10px; justify-content: center; margin-bottom: 24px; flex-wrap: wrap; }
.znp-ed .ed-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 24px; border-radius: 50px; font-size: 13px; font-weight: 700;
    border: none; transition: all .18s; text-decoration: none !important;
}
.znp-ed .ed-btn-blue { background: var(--ed-blue); color: #fff !important; box-shadow: 0 2px 10px rgba(59,92,204,.25); }
.znp-ed .ed-btn-blue:hover { background: var(--ed-blue-d); transform: translateY(-1px); }
.znp-ed .ed-btn-orange { background: var(--ed-orange); color: #fff !important; box-shadow: 0 2px 10px rgba(242,153,74,.25); }
.znp-ed .ed-btn-orange:hover { background: var(--ed-orange-d); transform: translateY(-1px); }
.znp-ed .ed-btn-ghost { background: #dce7fb; color: var(--ed-blue-d) !important; border: 1.5px solid #b8ccf7; }
.znp-ed .ed-btn-ghost:hover { background: #c8d9f8; }

/* ── STATS STRIP ── */
.znp-ed .ed-stats-strip {
    display: flex; background: var(--ed-bg); border: 1px solid var(--ed-border);
    border-radius: var(--ed-r-sm); overflow: hidden; flex-wrap: wrap;
}
.znp-ed .ed-stat-cell { flex: 1 1 80px; padding: 10px 14px; border-right: 1px solid var(--ed-border); text-align: center; }
.znp-ed .ed-stat-cell:last-child { border-right: none; }
.znp-ed .ed-sc-num { font-size: 15px; font-weight: 800; letter-spacing: -.3px; color: var(--ed-blue-d); }
.znp-ed .ed-sc-lbl { font-size: 10.5px; color: var(--ed-t4); font-weight: 500; margin-top: 2px; }

/* ── SUMMARY STRIP ── */
.znp-ed .ed-summary-strip {
    display: flex; background: var(--ed-surface); border: 1px solid var(--ed-border);
    border-radius: var(--ed-r); overflow: hidden; margin-bottom: 18px;
    box-shadow: var(--ed-sh); flex-wrap: wrap;
}
.znp-ed .ed-sum-cell { flex: 1 1 120px; padding: 13px 16px; border-right: 1px solid var(--ed-border); }
.znp-ed .ed-sum-cell:last-child { border-right: none; }
.znp-ed .ed-sum-lbl {
    font-size: 10.5px; color: var(--ed-t4); font-weight: 600;
    margin-bottom: 4px; text-transform: uppercase; letter-spacing: .06em;
}
.znp-ed .ed-sum-num { font-size: 19px; font-weight: 800; color: var(--ed-text); letter-spacing: -.5px; }
.znp-ed .ed-sum-num.is-dim { color: var(--ed-t4); }
.znp-ed .ed-sum-sub { font-size: 10.5px; color: var(--ed-blue); margin-top: 3px; font-weight: 600; }
.znp-ed .ed-sum-sub.is-muted { color: var(--ed-t4); }
.znp-ed .ed-sum-sub a { color: inherit !important; }

/* ── RECRUITER PANEL ── */
.znp-ed .ed-rp-card {
    background: var(--ed-blue-50); border: 1px solid var(--ed-blue-100);
    border-radius: var(--ed-r); margin-bottom: 18px; overflow: hidden; box-shadow: var(--ed-sh);
}
.znp-ed .ed-rp-head {
    padding: 13px 18px; border-bottom: 1px solid var(--ed-blue-100);
    display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
}
.znp-ed .ed-rp-av {
    width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
    background: var(--ed-blue-100); border: 1.5px solid var(--ed-blue);
    color: var(--ed-blue-d); display: flex; align-items: center; justify-content: center;
}
.znp-ed .ed-rp-info { display: flex; align-items: center; gap: 12px; flex: 1; min-width: 0; }
.znp-ed .ed-rp-name { font-size: 13px; font-weight: 800; color: var(--ed-blue-d); }
.znp-ed .ed-rp-role { font-size: 11px; color: var(--ed-blue); font-weight: 500; }
.znp-ed .ed-rp-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.znp-ed .ed-rp-mail {
    display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 600;
    color: var(--ed-blue) !important; background: rgba(255,255,255,.8);
    border: 1px solid var(--ed-blue-100); border-radius: 50px; padding: 5px 12px;
    text-decoration: none !important;
}
.znp-ed .ed-rp-mail:hover { background: #fff; }
.znp-ed .ed-rp-call {
    display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px;
    background: var(--ed-blue); color: #fff !important; border-radius: 50px;
    font-size: 12px; font-weight: 700; text-decoration: none !important;
}
.znp-ed .ed-rp-call:hover { background: var(--ed-blue-d); }
.znp-ed .ed-rp-body { padding: 14px 18px; }
.znp-ed .ed-ai-item {
    display: flex; align-items: flex-start; gap: 10px; padding: 8px 0;
    border-bottom: 1px solid var(--ed-blue-100);
}
.znp-ed .ed-ai-item:last-child { border-bottom: none; }
.znp-ed .ed-ai-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 4px; }
.znp-ed .ed-ai-text { font-size: 12px; color: var(--ed-t2); flex: 1; line-height: 1.5; font-weight: 500; }
.znp-ed .ed-ai-time { font-size: 10.5px; color: var(--ed-t4); flex-shrink: 0; }

/* ── CONTRACTORS / RESUMEZ ── */
.znp-ed .ed-ctc-section {
    background: var(--ed-surface); border: 1px solid var(--ed-border);
    border-radius: var(--ed-r); margin-bottom: 18px; overflow: hidden; box-shadow: var(--ed-sh);
}
.znp-ed .ed-ctc-head {
    padding: 14px 18px; border-bottom: 1px solid var(--ed-border);
    display: flex; align-items: center; justify-content: space-between; gap: 10px;
    flex-wrap: wrap; background: var(--ed-purple-50);
}
.znp-ed .ed-ctc-icon {
    width: 32px; height: 32px; background: var(--ed-purple-100);
    border-radius: var(--ed-r-sm); display: flex; align-items: center;
    justify-content: center; font-size: 15px; flex-shrink: 0;
}
.znp-ed .ed-ctc-hl { display: flex; align-items: center; gap: 10px; }
.znp-ed .ed-ctc-head-title { font-size: 13px; font-weight: 800; color: var(--ed-text); }
.znp-ed .ed-ctc-head-sub { font-size: 11.5px; color: var(--ed-t3); margin-top: 2px; font-weight: 500; }
.znp-ed .ed-btn-purple {
    display: inline-flex; align-items: center; justify-content: center;
    padding: 7px 14px; border-radius: 50px; font-size: 12px; font-weight: 700;
    background: var(--ed-purple); color: #fff !important; border: none;
    box-shadow: 0 2px 8px rgba(124,58,237,.2); text-decoration: none !important;
}
.znp-ed .ed-btn-purple:hover { background: #6d28d9; }

.znp-ed .ed-ctc-body { padding: 16px 18px; }
.znp-ed .ed-ctc-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
.znp-ed .ed-ctc-card {
    border: 1px solid var(--ed-purple-100); border-radius: var(--ed-r);
    padding: 14px; background: var(--ed-purple-50); transition: all .18s;
    display: flex; flex-direction: column; min-height: 100%;
}
.znp-ed .ed-ctc-card:hover { border-color: var(--ed-purple); box-shadow: 0 4px 14px rgba(124,58,237,.1); transform: translateY(-2px); }
.znp-ed .ed-ctc-top { display: flex; align-items: center; gap: 9px; margin-bottom: 10px; }
.znp-ed .ed-ctc-av {
    width: 36px; height: 36px; border-radius: 50%; font-size: 12px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    border: 1px solid var(--ed-purple-100); flex-shrink: 0;
}
.znp-ed .ed-ctc-av.ac-purple { background: var(--ed-purple-50); color: var(--ed-purple); }
.znp-ed .ed-ctc-av.ac-teal   { background: var(--ed-teal-50);   color: var(--ed-teal); }
.znp-ed .ed-ctc-av.ac-orange { background: var(--ed-orange-50); color: var(--ed-orange-d); }
.znp-ed .ed-ctc-av.ac-green  { background: var(--ed-green-50);  color: var(--ed-green); }
.znp-ed .ed-ctc-nm { font-size: 12px; font-weight: 700; color: var(--ed-text); }
.znp-ed .ed-ctc-sk { font-size: 11px; color: var(--ed-t3); font-weight: 500; }
.znp-ed .ed-avail-lbl {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 10px; font-weight: 700; color: var(--ed-blue); margin-bottom: 5px;
    text-transform: uppercase; letter-spacing: .06em; line-height: 1.2;
}
.znp-ed .ed-avail-lbl .ed-avail-ico { font-size: 12px; line-height: 1; flex-shrink: 0; display: inline-flex; align-items: center; }
.znp-ed .ed-loc-row { display: flex; gap: 4px; flex-wrap: wrap; margin-bottom: 8px; }
.znp-ed .ed-chip {
    font-size: 10px; font-weight: 600; color: var(--ed-t3);
    background: var(--ed-bg); border: 1px solid var(--ed-border);
    border-radius: 4px; padding: 2px 7px;
}
.znp-ed .ed-ctc-tags { display: flex; gap: 4px; flex-wrap: wrap; margin-bottom: 10px; }
.znp-ed .ed-ctc-tag {
    background: var(--ed-purple-100); color: var(--ed-purple);
    font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 50px;
}
.znp-ed .ed-ctc-cta {
    display: flex; align-items: center; justify-content: center;
    width: 100%; padding: 7px; background: transparent;
    border: 1.5px solid var(--ed-blue-100); color: var(--ed-blue) !important;
    border-radius: 50px; font-size: 12px; font-weight: 700;
    text-decoration: none !important; transition: all .15s; margin-top: auto;
}
.znp-ed .ed-ctc-cta:hover { background: var(--ed-blue); color: #fff !important; border-color: var(--ed-blue); }

/* ── JOBS SCROLL ── */
.znp-ed .ed-jobs-section {
    background: var(--ed-surface); border: 1px solid var(--ed-border);
    border-radius: var(--ed-r); overflow: hidden; box-shadow: var(--ed-sh);
}
.znp-ed .ed-jobs-head {
    padding: 14px 18px; border-bottom: 1px solid var(--ed-border);
    display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
}
.znp-ed .ed-jh-title { font-size: 13px; font-weight: 800; color: var(--ed-text); }
.znp-ed .ed-jh-sub { font-size: 11px; color: var(--ed-t4); }
.znp-ed .ed-jh-cta {
    display: inline-flex; align-items: center; font-size: 12px; font-weight: 700;
    color: var(--ed-blue) !important; padding: 6px 14px;
    border: 1.5px solid var(--ed-blue-100); border-radius: 50px;
    background: var(--ed-blue-50); text-decoration: none !important; transition: all .15s;
}
.znp-ed .ed-jh-cta:hover { background: var(--ed-blue-100); }
.znp-ed .ed-jobs-scroll-wrap { height: 240px; overflow: hidden; position: relative; }
.znp-ed .ed-jobs-scroll-wrap::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 40px;
    background: linear-gradient(transparent, var(--ed-surface));
    pointer-events: none; z-index: 1;
}
.znp-ed .ed-marquee { animation: edScrollUp 24s linear infinite; }
.znp-ed .ed-marquee:hover { animation-play-state: paused; }
@keyframes edScrollUp { 0% { transform: translateY(0); } 100% { transform: translateY(-50%); } }

.znp-ed .ed-jrow {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 18px; border-bottom: 1px solid var(--ed-border);
}
.znp-ed .ed-jrow:hover { background: var(--ed-blue-50); }
.znp-ed .ed-jrow-av {
    width: 32px; height: 32px; border-radius: var(--ed-r-sm); font-size: 10px;
    font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.znp-ed .ed-jrow-info { flex: 1; min-width: 0; }
.znp-ed .ed-jrow-title { font-size: 12px; font-weight: 700; color: var(--ed-text); }
.znp-ed .ed-jrow-meta { font-size: 11px; color: var(--ed-t4); font-weight: 500; }
.znp-ed .ed-jrow-empty { padding: 48px 20px; text-align: center; color: var(--ed-t4); font-size: 12.5px; }

/* ── MODALS (outside .znp-ed wrapper, so unscoped but prefixed) ── */
.ed-modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 9500;
    background: rgba(15,23,42,.55); align-items: center; justify-content: center;
    padding: 24px 16px; overflow-y: auto;
    backdrop-filter: blur(3px); -webkit-backdrop-filter: blur(3px);
}
.ed-modal-overlay.is-open { display: flex; }
.ed-modal-surface {
    background: #fff; border-radius: 12px; width: 100%; max-width: 520px;
    box-shadow: 0 20px 60px rgba(0,0,0,.18); overflow: hidden;
    font-family: 'Manrope', 'Inter', sans-serif;
}
.ed-modal-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px; border-bottom: 1px solid #E7EAF3; background: #F7F8FC;
}
.ed-modal-title { font-size: 15px; font-weight: 800; color: #2F3443; font-family: inherit; }
.ed-modal-close {
    width: 32px; height: 32px; border-radius: 50%; border: 1px solid #E7EAF3;
    background: #fff; color: #717A96; font-size: 18px; line-height: 1; cursor: pointer;
    display: flex; align-items: center; justify-content: center; font-family: inherit;
}
.ed-modal-body { padding: 20px 22px 24px; text-align: center; font-family: inherit; }
.ed-modal-body p { font-size: 12.5px; color: #717A96; line-height: 1.6; margin-bottom: 16px; font-family: inherit; }
.ed-modal-actions { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
.ed-modal-btn-solid {
    display: inline-flex; align-items: center; justify-content: center;
    padding: 11px 22px; border-radius: 50px; font-size: 13px; font-weight: 700;
    border: none; background: #3B5CCC; color: #fff !important;
    text-decoration: none !important; font-family: inherit; cursor: pointer;
}
.ed-modal-btn-solid:hover { background: #2d47a3; }
.ed-modal-btn-soft {
    display: inline-flex; align-items: center; justify-content: center;
    padding: 11px 22px; border-radius: 50px; font-size: 13px; font-weight: 700;
    border: 1.5px solid #D6DEFC; background: #EEF1FB; color: #2d47a3;
    font-family: inherit; cursor: pointer;
}

/* ── SIDEBAR OVERLAY (outside .znp-ed, uses ID) ── */
#ed-overlay {
    display: none; position: fixed; inset: 0; z-index: 899;
    background: rgba(15,23,42,.28); backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
}
#ed-overlay.is-on { display: block; }

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
    .znp-ed .ed-ctc-grid { grid-template-columns: repeat(2, 1fr); }
}
#ed-copy-toast {
    position: fixed;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%) translateY(20px);
    z-index: 10000;
    padding: 10px 22px;
    border-radius: 999px;
    background: rgba(31,41,55,.94);
    color: #fff;
    font-weight: 700;
    font-size: 13px;
    opacity: 0;
    pointer-events: none;
    transition: opacity .22s ease, transform .26s ease;
    box-shadow: 0 8px 26px rgba(0, 0, 0, .18);
}
#ed-copy-toast.is-visible {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}

@media (max-width: 768px) {
    .znp-ed .ed-tb-menu { display: flex; }
    .znp-ed .ed-sidebar {
        transform: translateX(-100%); top: 0; z-index: 1100;
        box-shadow: var(--ed-sh-md); max-width: min(280px, 88vw);
    }
    .znp-ed .ed-sidebar.is-open { transform: translateX(0); }
    .znp-ed .ed-main { margin-left: 0; width: 100%; }
    .znp-ed .ed-topbar { padding: 10px 16px; }
    .znp-ed .ed-content { padding: 14px 14px 32px; }
    .znp-ed .ed-hero { padding: 20px 16px; }
    .znp-ed .ed-hero-title { font-size: 18px; }
    .znp-ed .ed-cta-row { flex-direction: column; align-items: stretch; }
    .znp-ed .ed-btn { justify-content: center; }
    .znp-ed .ed-ctc-grid { grid-template-columns: 1fr; }
    .znp-ed .ed-stat-cell { border-right: none; border-bottom: 1px solid var(--ed-border); }
    .znp-ed .ed-stat-cell:last-child { border-bottom: none; }
    .znp-ed .ed-sum-cell { border-right: none; border-bottom: 1px solid var(--ed-border); }
    .znp-ed .ed-sum-cell:last-child { border-bottom: none; }
    .znp-ed .ed-co-name, .znp-ed .ed-co-sub { max-width: 120px; }
    .znp-ed .ed-tb-left { flex: 1; }
}

</style>
@endpush

@section('content')
@php
if (!function_exists('znp_ed_job_location_preview')) {
    /** Turn post_jobs.location blobs into readable city/text (handles php-serialised + JSON-ish rows). */
    function znp_ed_job_location_preview($raw): string
    {
        if ($raw === null || $raw === '') {
            return '';
        }

        $decoded = null;

        if (is_string($raw)) {
            $decoded = @unserialize($raw);

            if ($decoded === false && $raw !== 'b:0;') {

                $json = json_decode($raw, true);

                $decoded = is_array($json) ? $json : null;

            }

        } elseif (is_array($raw)) {

            $decoded = $raw;

        } else {

            return '';

        }

        if ($decoded === null || $decoded === false || ! is_array($decoded)) {

            return '';

        }

        // Single associative map (city payload)

        if (isset($decoded['city']) && is_string($decoded['city']) && strlen($decoded['city']) < 200) {

            return trim($decoded['city']);

        }

        // List of payloads or strings — walk shallowly first

        foreach ($decoded as $v) {

            if (is_string($v)) {

                $t = trim($v);

                if ($t !== '' && strlen($t) < 200 && $t[0] !== '{') {

                    return $t;

                }

            }

            if (is_array($v) && isset($v['city']) && is_string($v['city'])) {

                $t = trim($v['city']);

                if ($t !== '') {

                    return $t;

                }

            }

        }



        return '';

    }

}

@endphp
<div id="ed-overlay" onclick="EdDash.closeSb()" aria-hidden="true"></div>

<div class="znp-ed">
<div class="ed-layout">

    {{-- ── SIDEBAR ── --}}
    <aside id="ed-sidebar" class="ed-sidebar" aria-label="Employer navigation">

        {{-- Logo --}}
        <div class="ed-sb-logo">
            <div class="ed-sb-logo-mark">
                <span class="ed-sb-la">Zero</span><span class="ed-sb-lb">Notice</span><span class="ed-sb-lc">Period</span>
            </div>
            <div class="ed-sb-logo-sub">Employer Portal</div>
        </div>

        <nav class="ed-nav-grp" aria-label="Primary">
            <a target="_blank" rel="noopener noreferrer" href="{{ route('employer.dashboard.page') }}" class="ed-nav-item is-active">
                <svg class="ed-nav-icon" viewBox="0 0 24 24" fill="none" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            {{-- Jobs --}}
            <button type="button" class="ed-nav-item" onclick="EdDash.toggleSub('edSubJobs','edArrJobs')" aria-expanded="true">
                <svg class="ed-nav-icon" viewBox="0 0 24 24" fill="none" stroke-width="2" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                Jobs
                <svg id="edArrJobs" class="ed-nav-arrow" style="transform:rotate(180deg)" viewBox="0 0 24 24" stroke-width="2.5" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div id="edSubJobs" class="ed-nav-sub is-open">
                <a target="_blank" rel="noopener noreferrer" href="{{ url('post-job-page') }}" class="ed-nav-sub-item">Post a Job</a>
                <a target="_blank" rel="noopener noreferrer" href="{{ route('my-jobs') }}" class="ed-nav-sub-item">
                    My Job Postings
                    <span class="ed-nbadge">{{ $jobsPostedCount }}</span>
                </a>
            </div>

            {{-- ResumeDB --}}
            <button type="button" class="ed-nav-item" onclick="EdDash.toggleSub('edSubCz','edArrCz')" aria-expanded="true">
                <svg class="ed-nav-icon" viewBox="0 0 24 24" fill="none" stroke-width="2" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                ResumeDB
                <svg id="edArrCz" class="ed-nav-arrow" style="transform:rotate(180deg)" viewBox="0 0 24 24" stroke-width="2.5" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div id="edSubCz" class="ed-nav-sub is-open">
                <a target="_blank" rel="noopener noreferrer" href="{{ route('cv-search') }}" class="ed-nav-sub-item">Browse Contractors</a>
                <a target="_blank" rel="noopener noreferrer" href="{{ url('/cv-search') }}" class="ed-nav-sub-item">Browse Resumes</a>
            </div>

            {{-- Profile --}}
            <button type="button" class="ed-nav-item" onclick="EdDash.toggleSub('edSubPf','edArrPf')" aria-expanded="true">
                <svg class="ed-nav-icon" viewBox="0 0 24 24" fill="none" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                Profile
                <svg id="edArrPf" class="ed-nav-arrow" style="transform:rotate(180deg)" viewBox="0 0 24 24" stroke-width="2.5" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div id="edSubPf" class="ed-nav-sub is-open">
                <a target="_blank" rel="noopener noreferrer" href="{{ route('company.profile') }}" class="ed-nav-sub-item">Company Profile</a>
                <a href="#" target="_blank" rel="noopener noreferrer" class="ed-nav-sub-item">Users &amp; Reports</a>
                <a target="_blank" rel="noopener noreferrer" href="{{ route('employer.dashboard') }}" class="ed-nav-sub-item">
                    KYC &amp; Verification
                    @if((int) $company->kyc_verified === 2)
                        <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#4ade80;margin-left:4px;flex-shrink:0;"></span>
                    @else
                        <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#f97316;margin-left:4px;flex-shrink:0;"></span>
                    @endif
                </a>
                <a href="#" class="ed-nav-sub-item">Notifications</a>
                <a target="_blank" rel="noopener noreferrer" href="{{ route('front.payment.history') }}" class="ed-nav-sub-item">Billing &amp; Plan</a>
            </div>
        </nav>

        {{-- ── Plan card (ZNP) ──
             Driven by $znpPlan from Company::znpPlanViewModel(). Shows live
             quota + days-remaining bar when an active subscription exists,
             a warm "Choose a Plan" prompt when there is none, and a red
             "Renew" prompt when the plan has expired. --}}
        <div class="ed-plan-card is-{{ $znpPlan['tone'] }}">
            <div class="ed-plan-head">
                <div class="ed-plan-name">{{ $znpPlan['plan_name'] }}</div>
                @if($znpPlan['tag_label'])
                    <span class="ed-plan-tag">{{ $znpPlan['tag_label'] }}</span>
                @elseif(! $znpPlan['has_plan'])
                    <span class="ed-plan-tag">Required</span>
                @elseif($znpPlan['is_expired'])
                    <span class="ed-plan-tag">Expired</span>
                @elseif($znpPlan['tone'] === 'full')
                    <span class="ed-plan-tag">Out of quota</span>
                @endif
            </div>

            @if($znpPlan['has_plan'] && ! $znpPlan['is_unlimited'])
                <div class="ed-plan-bar"><div class="ed-plan-bar-fill" style="width: {{ $znpPlan['percent'] }}%"></div></div>
                <div class="ed-plan-meta">
                    <span>{{ $znpPlan['posts_used'] }} of {{ $znpPlan['posts_limit'] }} used</span>
                    @if($znpPlan['expires_label'])
                        <span>{{ $znpPlan['days_remaining'] > 0 ? $znpPlan['days_remaining'] . 'd left' : 'expired' }}</span>
                    @endif
                </div>
            @elseif($znpPlan['has_plan'] && $znpPlan['is_unlimited'])
                <div class="ed-plan-desc">{{ $znpPlan['posts_used'] }} posted · unlimited @if($znpPlan['expires_label']) · expires {{ $znpPlan['expires_label'] }} @endif</div>
            @else
                <div class="ed-plan-desc">{{ $znpPlan['sub_line'] }}</div>
            @endif

            <a target="_blank" rel="noopener noreferrer" href="{{ $znpPlan['cta_url'] }}" class="ed-plan-upgrade">
                {{ $znpPlan['cta_label'] }} →
            </a>
        </div>

        {{-- Help card --}}
        <div class="ed-help-card">
            <div class="ed-help-title">Need help getting started?</div>
            <div class="ed-help-text">Our customer success team is here to help you post your first job and find the right talent.</div>
            <span class="ed-help-mail" role="button" tabindex="0" onclick="EdDash.copyEmail()" onkeydown="if(event.key==='Enter'){EdDash.copyEmail();}" title="Click to copy" style="cursor:pointer;user-select:none">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                hello@zeronoticeperiod.com
            </span>
            <a target="_blank" rel="noopener noreferrer" href="tel:+919876543210" class="ed-help-call">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6.5-6.5 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.89 4.93h3a2 2 0 0 1 2 1.72c.127.962.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 13.91a16 16 0 0 0 6 6l3.06-3.06a2 2 0 0 1 2.11-.45c.907.339 1.848.574 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                +91 98765 43210
            </a>
        </div>

        {{-- Sidebar footer --}}
        <div class="ed-sb-footer">
            <div class="ed-sf-name">{{ $displayCompanyName }}</div>
            @if($contactLine !== '')
                <div class="ed-sf-sub">{{ $contactLine }}</div>
            @elseif(!empty($company->designation))
                <div class="ed-sf-sub">{{ $company->designation }}</div>
            @endif
        </div>
    </aside>

    {{-- ── MAIN ── --}}
    <div class="ed-main">

        {{-- Topbar --}}
        <div class="ed-topbar">
            <button type="button" class="ed-tb-menu" onclick="EdDash.openSb()" aria-label="Open sidebar">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
            <div class="ed-tb-left">
                <div class="ed-tb-title">Employer Dashboard</div>
                <div class="ed-tb-sub">Start hiring from India's exclusive pool of zero notice period talent</div>
            </div>
            <div class="ed-co-wrap">
                <div class="ed-co-av">
                    @if(!empty($company->logo))
                        <img src="{{ asset('company_logos/'.$company->logo) }}" alt="{{ $displayCompanyName }}">
                    @else
                        {{ $companyInitials }}
                    @endif
                </div>
                <div>
                    <div class="ed-co-name">{{ $displayCompanyName }}</div>
                    <form method="POST" action="{{ route('company.logout') }}" class="ed-logout-form">
                        @csrf
                        <button type="submit" class="ed-logout-btn">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="ed-content">

            {{-- HERO --}}
            <section class="ed-hero">
                <div class="ed-hero-eyebrow">ZeroNoticePeriod · Employer Portal</div>
                <h1 class="ed-hero-title">Welcome, {{ $welcomeName }}</h1>
                <div class="ed-hero-badge">
                    {{ $displayCompanyName }}
                    @if(! $znpPlan['has_plan'])
                        &nbsp;·&nbsp; <a target="_blank" rel="noopener noreferrer" href="{{ $znpPlan['pricing_url'] }}" style="color:var(--ed-orange-d);font-weight:700">Choose a plan to post jobs</a>
                    @elseif($znpPlan['is_expired'])
                        &nbsp;·&nbsp; <a target="_blank" rel="noopener noreferrer" href="{{ $znpPlan['pricing_url'] }}" style="color:#b91c1c;font-weight:700">Plan expired — renew to keep posting</a>
                    @elseif(! $znpPlan['can_post'])
                        &nbsp;·&nbsp; <a target="_blank" rel="noopener noreferrer" href="{{ $znpPlan['pricing_url'] }}" style="color:var(--ed-orange-d);font-weight:700">Out of posts — buy more</a>
                    @else
                        &nbsp;·&nbsp; <span style="color:var(--ed-blue);font-weight:700">{{ $znpPlan['plan_name'] }}@if(! $znpPlan['is_unlimited']) · {{ $znpPlan['posts_remaining'] }} post{{ $znpPlan['posts_remaining'] === 1 ? '' : 's' }} left @endif</span>
                    @endif
                </div>
                <div class="ed-cta-row">
                    {{-- Primary CTA flips between "Post a Job" and "Choose / Buy a Plan"
                         depending on the live ZNP plan state (see Company::znpPlanViewModel). --}}
                    @if($znpPlan['can_post'])
                        <a href="{{ route('employer.post.job.page') }}" class="ed-btn ed-btn-blue">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                            Post a Job
                        </a>
                    @else
                        <a href="{{ $znpPlan['cta_url'] }}" class="ed-btn ed-btn-blue">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                            {{ $znpPlan['cta_label'] }}
                        </a>
                    @endif
                    <a target="_blank" rel="noopener noreferrer" href="{{ route('cv-search') }}" class="ed-btn ed-btn-orange">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Browse ResumeDB
                    </a>
                </div>
                <div class="ed-stats-strip">
                    <div class="ed-stat-cell">
                        <div class="ed-sc-num">{{ number_format($dashLiveJobsZn) }}</div>
                        <div class="ed-sc-lbl">Live jobs on ZNP</div>
                    </div>
                    <div class="ed-stat-cell">
                        <div class="ed-sc-num">{{ number_format($dashPermanentRoles) }}</div>
                        <div class="ed-sc-lbl">Permanent roles</div>
                    </div>
                    <div class="ed-stat-cell">
                        <div class="ed-sc-num">{{ number_format($dashContractRoles) }}</div>
                        <div class="ed-sc-lbl">Contract roles</div>
                    </div>
                </div>
            </section>

            {{-- SUMMARY STRIP --}}
            <section class="ed-summary-strip" aria-label="Account summary">
                <div class="ed-sum-cell">
                    <div class="ed-sum-lbl">Jobs posted</div>
                    <div class="ed-sum-num {{ $jobsPostedCount ? '' : 'is-dim' }}">{{ $jobsPostedCount }}</div>
                    <div class="ed-sum-sub">
                        @if($znpPlan['can_post'])
                            <a href="{{ route('employer.post.job.page') }}">Post a job →</a>
                        @else
                            <a href="{{ $znpPlan['pricing_url'] }}">{{ $znpPlan['cta_label'] }} →</a>
                        @endif
                    </div>
                </div>
                <div class="ed-sum-cell">
                    <div class="ed-sum-lbl">Applications</div>
                    <div class="ed-sum-num {{ $applicationsCount ? '' : 'is-dim' }}">{{ $applicationsCount }}</div>
                    <div class="ed-sum-sub is-muted">{{ $applicationsCount ? 'Across your postings' : 'Appears once you post' }}</div>
                </div>
                {{-- "Posts remaining" replaces the legacy CV-credits tile so it
                     reflects the actual ZNP job-posting quota the user paid for. --}}
                <div class="ed-sum-cell">
                    <div class="ed-sum-lbl">{{ $znpPlan['is_unlimited'] ? 'Plan' : 'Posts remaining' }}</div>
                    @if(! $znpPlan['has_plan'])
                        <div class="ed-sum-num is-dim">—</div>
                        <div class="ed-sum-sub"><a href="{{ $znpPlan['pricing_url'] }}">Choose a plan →</a></div>
                    @elseif($znpPlan['is_expired'])
                        <div class="ed-sum-num is-dim">0</div>
                        <div class="ed-sum-sub"><a href="{{ $znpPlan['pricing_url'] }}" style="color:#b91c1c;font-weight:700">Renew {{ $znpPlan['plan_name'] }} →</a></div>
                    @elseif($znpPlan['is_unlimited'])
                        <div class="ed-sum-num">∞</div>
                        <div class="ed-sum-sub is-muted">{{ $znpPlan['plan_name'] }}@if($znpPlan['expires_label']) · expires {{ $znpPlan['expires_label'] }} @endif</div>
                    @else
                        <div class="ed-sum-num {{ $znpPlan['posts_remaining'] ? '' : 'is-dim' }}">{{ $znpPlan['posts_remaining'] }}</div>
                        <div class="ed-sum-sub">
                            @if($znpPlan['posts_remaining'] === 0)
                                <a href="{{ $znpPlan['pricing_url'] }}" style="color:#b91c1c;font-weight:700">Buy more →</a>
                            @else
                                <span class="is-muted">of {{ $znpPlan['posts_limit'] }} on {{ $znpPlan['plan_name'] }}</span>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="ed-sum-cell">
                    <div class="ed-sum-lbl">ResumeDB available</div>
                    <div class="ed-sum-num">{{ $resumezSpotlightCount }}</div>
                    <div class="ed-sum-sub is-muted">Visible contract profiles</div>
                </div>
            </section>

            {{-- RECRUITER PANEL --}}
            <section class="ed-rp-card" aria-label="Customer success">
                <div class="ed-rp-head">
                    <div class="ed-rp-info">
                        <div class="ed-rp-av">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <div>
                            <div class="ed-rp-name">Connect With Customer Success Team</div>
                            <div class="ed-rp-role">ZeroNoticePeriod · Customer Success</div>
                        </div>
                    </div>
                    <div class="ed-rp-actions">
                        <span class="ed-rp-mail" role="button" tabindex="0" onclick="EdDash.copyEmail()" onkeydown="if(event.key==='Enter'){EdDash.copyEmail();}" title="Click to copy" style="cursor:pointer;user-select:none">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            hello@zeronoticeperiod.com
                        </span>
                        <a target="_blank" rel="noopener noreferrer" href="tel:+919876543210" class="ed-rp-call">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6.5-6.5 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.89 4.93h3a2 2 0 0 1 2 1.72c.127.962.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 13.91a16 16 0 0 0 6 6l3.06-3.06a2 2 0 0 1 2.11-.45c.907.339 1.848.574 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            +91 98765 43210
                        </a>
                    </div>
                </div>
                <div class="ed-rp-body">
                    <div class="ed-ai-item">
                        <span class="ed-ai-dot" style="background:var(--ed-green)"></span>
                        <div class="ed-ai-text">Upgrade, complete KYC verification, post jobs and hire immediately</div>
                        <span class="ed-ai-time">Today</span>
                    </div>
                    <div class="ed-ai-item">
                        <span class="ed-ai-dot" style="background:var(--ed-orange)"></span>
                        <div class="ed-ai-text">{{ $resumezSpotlightCount }} visible contract-role profiles are currently available in ResumeDB</div>
                        <span class="ed-ai-time">Today</span>
                    </div>
                    <div class="ed-ai-item">
                        <span class="ed-ai-dot" style="background:var(--ed-blue)"></span>
                        <div class="ed-ai-text">Tip: Post your first job now to start receiving applications from zero notice period candidates</div>
                        <span class="ed-ai-time">Suggestion</span>
                    </div>
                </div>
            </section>

            {{-- RESUMEDB --}}
            <section class="ed-ctc-section" aria-label="ResumeDB spotlight">
                <div class="ed-ctc-head">
                    <div class="ed-ctc-hl">
                        <div class="ed-ctc-icon" aria-hidden="true">🔧</div>
                        <div>
                            <div class="ed-ctc-head-title">ResumeDB Spotlight</div>
                            <div class="ed-ctc-head-sub">{{ $resumezSpotlightCount }} visible contract-role profiles · Availability shown per profile</div>
                        </div>
                    </div>
                    <a target="_blank" rel="noopener noreferrer" href="{{ route('cv-search') }}" class="ed-btn-purple">Browse all {{ $resumezSpotlightCount }}</a>
                </div>
                <div class="ed-ctc-body">
                    <div class="ed-ctc-grid">
                        @forelse($contractorsShowcase as $card)
                            @php
                                $acMap = ['purple'=>'ac-purple','teal'=>'ac-teal','orange'=>'ac-orange','green'=>'ac-green'];
                                $ac = $acMap[$card['accent']] ?? 'ac-purple';
                            @endphp
                            <article class="ed-ctc-card">
                                <div class="ed-ctc-top">
                                    <div class="ed-ctc-av {{ $ac }}">{{ $card['initials'] }}</div>
                                    <div>
                                        <div class="ed-ctc-nm">{{ $card['name'] }}</div>
                                        <div class="ed-ctc-sk">{{ $card['role'] }}</div>
                                    </div>
                                </div>
                                @php
                                    $availColor = ($card['availability_color'] ?? 'green') === 'amber' ? 'var(--ed-amber, #d97706)' : 'var(--ed-green)';
                                    $__edAvail = trim((string) ($card['availability_label'] ?? '⚡ Starts immediately'));
                                @endphp
                                <div class="ed-avail-lbl" style="color:{{ $availColor }}">
                                    @if(str_starts_with($__edAvail, '⚡'))
                                        <span class="ed-avail-ico" aria-hidden="true">⚡</span>
                                        <span>{{ trim(mb_substr($__edAvail, mb_strlen('⚡'))) }}</span>
                                    @elseif(str_starts_with($__edAvail, '⏱'))
                                        <span class="ed-avail-ico" aria-hidden="true">⏱</span>
                                        <span>{{ trim(mb_substr($__edAvail, mb_strlen('⏱'))) }}</span>
                                    @else
                                        <span>{{ $__edAvail }}</span>
                                    @endif
                                </div>
                                @php
                                    $chipLoc = trim((string)($card['loc'] ?? ''));
                                    $chipMd  = trim((string)($card['mode'] ?? ''));
                                    $showChipRow = ($chipLoc !== '' || $chipMd !== '');
                                @endphp
                                @if($showChipRow)
                                <div class="ed-loc-row">
                                    @if($chipLoc !== '')
                                        <span class="ed-chip">{{ $chipLoc }}</span>
                                    @endif
                                    @if($chipMd !== '')
                                        <span class="ed-chip">{{ $chipMd }}</span>
                                    @endif
                                </div>
                                @endif
                                @php
                                    $skillTagsShown = [];
                                    foreach ($card['tags'] ?? [] as $_tg) {
                                        $tgStr = trim((string) $_tg);
                                        if ($tgStr !== '') {
                                            $skillTagsShown[] = $tgStr;
                                        }
                                    }
                                @endphp
                                @if(count($skillTagsShown) > 0)
                                <div class="ed-ctc-tags">
                                    @foreach($skillTagsShown as $tg)
                                        <span class="ed-ctc-tag">{{ $tg }}</span>
                                    @endforeach
                                </div>
                                @endif
                                <a target="_blank" rel="noopener noreferrer" href="{{ route('cv-search') }}" class="ed-ctc-cta">View</a>
                            </article>
                        @empty
                            <div class="ed-jrow-empty" style="grid-column:1/-1">No active contract-role profiles surfaced yet — check back shortly or widen search in ResumeDB.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- JOBS SCROLL --}}
            <section class="ed-jobs-section" aria-label="Recent platform jobs">
                <div class="ed-jobs-head">
                    <div>
                        <span class="ed-jh-title">Jobs posted on ZNP in the last 30 days</span>
                        <span class="ed-jh-sub"> — See what others are hiring for</span>
                    </div>
                    @if($znpPlan['can_post'])
                        <a href="{{ route('employer.post.job.page') }}" class="ed-jh-cta">+ Post your first job</a>
                    @else
                        <a href="{{ $znpPlan['cta_url'] }}" class="ed-jh-cta">{{ $znpPlan['cta_label'] }} →</a>
                    @endif
                </div>
                <div class="ed-jobs-scroll-wrap">
                    @php
                        $palette = [
                            ['bg'=>'#dde5f8','fg'=>'var(--ed-blue)'],
                            ['bg'=>'var(--ed-green-50)','fg'=>'var(--ed-green)'],
                            ['bg'=>'var(--ed-orange-50)','fg'=>'var(--ed-orange-d)'],
                            ['bg'=>'var(--ed-purple-50)','fg'=>'var(--ed-purple)'],
                            ['bg'=>'var(--ed-teal-50)','fg'=>'var(--ed-teal)'],
                        ];
                    @endphp
                    @if($recentJobsScroll->count())
                    <div class="ed-marquee">
                        @foreach($recentJobsScroll as $idx => $job)
                            @php
                                $co     = optional($job->company)->name ?: 'ZNP';
                                $parts  = preg_split('/\s+/', $co);
                                $av     = '';
                                foreach (array_slice($parts, 0, 2) as $c) {
                                    $av .= $c !== '' ? strtoupper(mb_substr($c, 0, 1)) : '';
                                }
                                $locStr = znp_ed_job_location_preview($job->location ?? null);
                                $meta   = implode(' · ', array_filter([
                                    $locStr,
                                    ($job->min_salary ?? null) !== null && ($job->max_salary ?? null) !== null
                                        ? ('₹'.$job->min_salary.'–'.$job->max_salary.' LPA') : null,
                                    $job->experience ?? null,
                                    $job->work_mode  ?? null,
                                ]));
                                $pcol   = $palette[$idx % count($palette)];
                            @endphp
                            <a target="_blank" rel="noopener noreferrer" href="{{ $job->slug ? route('job.detail.znp', $job->slug) : '#' }}" style="display:block;color:inherit;text-decoration:none;">
                                <div class="ed-jrow">
                                    <div class="ed-jrow-av" style="background:{{ $pcol['bg'] }};color:{{ $pcol['fg'] }}">{{ $av ?: 'JN' }}</div>
                                    <div class="ed-jrow-info">
                                        <div class="ed-jrow-title">
                                            {{ $job->job_title }}
                                            <span class="ed-jrow-meta">· {{ $meta }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    @else
                    <div class="ed-jrow-empty">No new public jobs in the last 30 days. Be the next employer to publish on ZNP.</div>
                    @endif
                </div>
            </section>

        </div>{{-- /ed-content --}}
    </div>{{-- /ed-main --}}
</div>{{-- /ed-layout --}}
</div>{{-- /znp-ed --}}

<div id="ed-copy-toast" role="status" aria-live="polite" aria-atomic="true">Copied!</div>

{{-- POST JOB MODAL --}}
<div id="edModalPostJob" class="ed-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="edPostJobTitle">
    <div class="ed-modal-surface">
        <div class="ed-modal-head">
            <span id="edPostJobTitle" class="ed-modal-title">Post a Job</span>
            <button type="button" class="ed-modal-close" onclick="EdDash.closePostJob()" aria-label="Close">×</button>
        </div>
        <div class="ed-modal-body">
            @if($znpPlan['can_post'])
                <p>You will continue to ZeroNoticePeriod's guided job publishing flow.
                    @if(! $znpPlan['is_unlimited'])
                        You have <strong>{{ $znpPlan['posts_remaining'] }}</strong> of {{ $znpPlan['posts_limit'] }} posts left on your {{ $znpPlan['plan_name'] }} plan.
                    @endif
                </p>
                <div class="ed-modal-actions">
                    <a href="{{ route('employer.post.job.page') }}" class="ed-modal-btn-solid">Continue to job form →</a>
                    <button type="button" class="ed-modal-btn-soft" onclick="EdDash.closePostJob()">Not now</button>
                </div>
            @else
                <p>{{ $znpPlan['sub_line'] }}</p>
                <div class="ed-modal-actions">
                    <a href="{{ $znpPlan['cta_url'] }}" class="ed-modal-btn-solid">{{ $znpPlan['cta_label'] }} →</a>
                    <button type="button" class="ed-modal-btn-soft" onclick="EdDash.closePostJob()">Not now</button>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- PRICING MODAL --}}
<div id="edModalPricing" class="ed-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="edPricingTitle">
    <div class="ed-modal-surface">
        <div class="ed-modal-head">
            <span id="edPricingTitle" class="ed-modal-title">Plans &amp; Pricing</span>
            <button type="button" class="ed-modal-close" onclick="EdDash.closePricing()" aria-label="Close">×</button>
        </div>
        <div class="ed-modal-body">
            <p>Unlock CV search credits, job slots and branded listings that match how your teams hire.</p>
            <div class="ed-modal-actions">
                <a target="_blank" rel="noopener noreferrer" href="{{ route('company.packages') }}" class="ed-modal-btn-solid">View employer packages →</a>
                <button type="button" class="ed-modal-btn-soft" onclick="EdDash.closePricing()">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    var overlay = document.getElementById('ed-overlay');
    var sb      = document.getElementById('ed-sidebar');

    window.EdDash = {

        toastTimer: null,
        toggleSub: function (subId, arrowId) {
            var sub   = document.getElementById(subId);
            var arrow = document.getElementById(arrowId);
            if (!sub || !arrow) return;
            var open = sub.classList.toggle('is-open');
            arrow.style.transform = open ? 'rotate(180deg)' : 'rotate(0deg)';
        },
        openSb: function () {
            if (sb)      sb.classList.add('is-open');
            if (overlay) overlay.classList.add('is-on');
            document.documentElement.style.overflow = 'hidden';
        },
        closeSb: function () {
            if (sb)      sb.classList.remove('is-open');
            if (overlay) overlay.classList.remove('is-on');
            document.documentElement.style.overflow = '';
        },
        openPostJob: function () {
            var m = document.getElementById('edModalPostJob');
            if (m) m.classList.add('is-open');
        },
        closePostJob: function () {
            var m = document.getElementById('edModalPostJob');
            if (m) m.classList.remove('is-open');
        },
        openPricing: function () {
            var m = document.getElementById('edModalPricing');
            if (m) m.classList.add('is-open');
        },
        closePricing: function () {
            var m = document.getElementById('edModalPricing');
            if (m) m.classList.remove('is-open');
        },
        showCopiedToast: function () {
            var toast = document.getElementById('ed-copy-toast');
            if (!toast) return;
            toast.textContent = 'Copied';
            toast.classList.add('is-visible');
            if (EdDash.toastTimer) clearTimeout(EdDash.toastTimer);
            EdDash.toastTimer = setTimeout(function () {
                toast.classList.remove('is-visible');
            }, 2000);
        },
        fallbackCopyEmail: function (email) {
            try {
                var t = document.createElement('textarea');
                t.value = email;
                t.setAttribute('readonly', '');
                t.style.position = 'absolute';
                t.style.left = '-9999px';
                document.body.appendChild(t);
                t.select();
                document.execCommand('copy');
                document.body.removeChild(t);
                return true;
            } catch (e) {}
            return false;
        },
        copyEmail: function () {
            var email = 'hello@zeronoticeperiod.com';
            var notify = EdDash.showCopiedToast;
            if (navigator && navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(email).then(notify).catch(function () {
                    if (EdDash.fallbackCopyEmail(email)) notify();
                });
                return;
            }
            if (EdDash.fallbackCopyEmail(email)) notify();
        }
    };

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        EdDash.closeSb();
        EdDash.closePostJob();
        EdDash.closePricing();
    });
})();
</script>
@endpush
