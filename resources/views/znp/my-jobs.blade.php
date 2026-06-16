@extends('layouts.znp')

@section('page_title', 'My Job Postings | ZeroNoticePeriod')

@push('styles')
{{-- Manrope font (matches client design; same family used on post-job + employer-dashboard) --}}
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* ── ZNP MY-JOBS: SCOPE & RESET ── */
.znp-myjobs,
.znp-myjobs *,
.znp-myjobs *::before,
.znp-myjobs *::after {
    font-family: 'Manrope', sans-serif !important;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}
.znp-myjobs * { margin: 0; padding: 0; }
.znp-myjobs                                                  { background: var(--bg); color: var(--text); line-height: 1.5; min-height: 100vh; }
.znp-myjobs a                                                { color: inherit; text-decoration: none; }
.znp-myjobs h1, .znp-myjobs h2,
.znp-myjobs h3, .znp-myjobs h4                               { margin: 0; font-weight: inherit; }
.znp-myjobs p                                                { margin: 0; }
.znp-myjobs ul                                               { list-style: none; padding: 0; margin: 0; }
.znp-myjobs button                                           { font-family: inherit !important; }

/* ── PAGE-SCOPED TOKENS (mirror the client design palette) ── */
.znp-myjobs {
    --blue:        #3B5CCC;
    --blue-d:      #2d47a3;
    --blue-light:  #EEF1FB;
    --blue-100:    #D6DEFC;
    --orange:      #F2994A;
    --orange-light:#FEF3E8;
    --green:       #15803d;
    --green-light: #f0fdf4;
    --green-100:   #dcfce7;
    --bg:          #F7F8FC;
    --surface:     #ffffff;
    --surface-2:   #EEF1FB;
    --border:      #E7EAF3;
    --text:        #2F3443;
    --t2:          #4A5068;
    --t3:          #717A96;
    --t4:          #A0AABF;
    --shadow:      0 1px 4px rgba(59,92,204,.06), 0 1px 2px rgba(47,52,67,.04);
    --shadow-md:   0 4px 16px rgba(59,92,204,.09), 0 1px 4px rgba(47,52,67,.04);
    --r:           12px;
    --r-sm:        8px;
    --nav-h:       56px;
    --side-w:      240px;
}

/* ── NAV (employer-specific top bar, prefixed mj- to avoid Bootstrap .nav clash) ── */
.znp-myjobs .mj-nav { background: rgba(255,255,255,.96); backdrop-filter: blur(14px); border-bottom: 1px solid var(--border); height: var(--nav-h); display: flex; align-items: center; justify-content: space-between; padding: 0 24px; position: sticky; top: 0; z-index: 200; }
.znp-myjobs .mj-logo { font-size: 16px; font-weight: 800; letter-spacing: -.3px; text-decoration: none; }
.znp-myjobs .la { color: var(--blue); }
.znp-myjobs .lb { color: var(--orange); }
.znp-myjobs .lc { color: var(--blue); }
.znp-myjobs .nav-r { display: flex; align-items: center; gap: 12px; }
.znp-myjobs .plan-chip { font-size: 11px; font-weight: 700; padding: 3px 11px; border-radius: 20px; background: var(--blue-light); color: var(--blue); border: 1px solid var(--blue-100); cursor: pointer; }
.znp-myjobs .plan-chip.growth     { background: #fef3e8; color: var(--orange); border-color: #fed7aa; }
.znp-myjobs .plan-chip.enterprise { background: var(--green-light); color: var(--green); border-color: var(--green-100); }
.znp-myjobs .av { width: 32px; height: 32px; border-radius: 50%; background: var(--blue); color: #fff; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; cursor: pointer; }
.znp-myjobs .btn-post { background: var(--blue); color: #fff; border: none; border-radius: 50px; padding: 7px 18px; font-size: 12.5px; font-weight: 700; cursor: pointer; transition: all .2s; display: flex; align-items: center; gap: 6px; }
.znp-myjobs .btn-post:hover { background: var(--blue-d); transform: translateY(-1px); }

/* ── LAYOUT ── */
.znp-myjobs .shell { display: grid; grid-template-columns: var(--side-w) 1fr; min-height: calc(100vh - var(--nav-h)); }

/* ── SIDEBAR ── */
.znp-myjobs .sidebar { background: var(--surface); border-right: 1px solid var(--border); padding: 20px 16px; position: sticky; top: var(--nav-h); height: calc(100vh - var(--nav-h)); overflow-y: auto; }
.znp-myjobs .sidebar::-webkit-scrollbar       { width: 3px; }
.znp-myjobs .sidebar::-webkit-scrollbar-track { background: transparent; }
.znp-myjobs .sidebar::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
.znp-myjobs .sidebar::-webkit-scrollbar-thumb:hover { background: var(--t4); }
.znp-myjobs .sb-title { font-size: 10px; font-weight: 700; color: var(--t4); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; }
.znp-myjobs .clear-link { font-size: 11px; color: var(--blue); font-weight: 600; cursor: pointer; text-transform: none; letter-spacing: 0; }
.znp-myjobs .clear-link:hover { text-decoration: underline; }
.znp-myjobs .sb-section { margin-bottom: 22px; }
.znp-myjobs .sb-section-lbl { font-size: 11px; font-weight: 700; color: var(--t2); margin-bottom: 8px; }
.znp-myjobs .sb-check { display: flex; align-items: center; gap: 8px; padding: 5px 0; cursor: pointer; }
.znp-myjobs .sb-check input { width: 14px; height: 14px; accent-color: var(--blue); cursor: pointer; }
.znp-myjobs .sb-check label { font-size: 12.5px; color: var(--t2); cursor: pointer; flex: 1; }
.znp-myjobs .sb-check .cnt   { font-size: 11px; color: var(--t4); font-weight: 600; }
.znp-myjobs .sb-divider { height: 1px; background: var(--border); margin: 16px 0; }
.znp-myjobs .sb-date { width: 100%; border: 1.5px solid var(--border); border-radius: var(--r-sm); padding: 7px 10px; font-size: 12.5px; color: var(--text); outline: none; background: var(--surface); }
.znp-myjobs .sb-date:focus { border-color: var(--blue); }
.znp-myjobs .sb-search { width: 100%; border: 1.5px solid var(--border); border-radius: var(--r-sm); padding: 7px 10px 7px 32px; font-size: 12.5px; color: var(--text); outline: none; background: var(--surface); background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' stroke='%23A0AABF' stroke-width='2' viewBox='0 0 24 24'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: 10px center; }
.znp-myjobs .sb-search:focus { border-color: var(--blue); }

/* ── PLAN USAGE BAR ── */
.znp-myjobs .plan-bar { background: var(--surface-2); border: 1px solid var(--blue-100); border-radius: var(--r-sm); padding: 12px 14px; margin-bottom: 12px; }
.znp-myjobs .pb-label { font-size: 11px; font-weight: 600; color: var(--t2); display: flex; justify-content: space-between; margin-bottom: 6px; }
.znp-myjobs .pb-track { height: 5px; background: var(--border); border-radius: 3px; overflow: hidden; }
.znp-myjobs .pb-fill  { height: 100%; border-radius: 3px; background: var(--blue); transition: width .4s; }
.znp-myjobs .pb-fill.warn { background: var(--orange); }
.znp-myjobs .pb-fill.full { background: #ef4444; }
.znp-myjobs .pb-sub   { font-size: 10.5px; color: var(--t4); margin-top: 5px; }
.znp-myjobs .upgrade-link { font-size: 11px; font-weight: 700; color: var(--orange); cursor: pointer; }
.znp-myjobs .upgrade-link:hover { text-decoration: underline; }

/* ── MAIN CONTENT ── */
.znp-myjobs .main { padding: 16px 22px; }

/* TOP BAR */
.znp-myjobs .top-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px; }
.znp-myjobs .top-left h1 { font-size: 17px; font-weight: 800; color: var(--text); letter-spacing: -.3px; margin-bottom: 1px; }
.znp-myjobs .top-left p  { font-size: 12px; color: var(--t3); }
.znp-myjobs .top-right { display: flex; align-items: center; gap: 10px; }
.znp-myjobs .sort-sel { border: 1.5px solid var(--border); border-radius: var(--r-sm); padding: 7px 12px; font-size: 12.5px; color: var(--t2); outline: none; background: var(--surface); cursor: pointer; appearance: none; padding-right: 28px; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' fill='none' stroke='%23A0AABF' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 8px center; }
.znp-myjobs .sort-sel:focus { border-color: var(--blue); }

/* TAB ROW */
.znp-myjobs .tab-row { display: flex; gap: 0; border-bottom: 2px solid var(--border); margin-bottom: 12px; }
.znp-myjobs .tab { padding: 7px 14px; font-size: 12px; font-weight: 600; color: var(--t3); cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: all .15s; display: flex; align-items: center; gap: 6px; background: none; border-top: none; border-left: none; border-right: none; }
.znp-myjobs .tab.active { color: var(--blue); border-bottom-color: var(--blue); }
.znp-myjobs .tab:hover:not(.active) { color: var(--t2); }
.znp-myjobs .tab-count { font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 20px; background: var(--blue-light); color: var(--blue); }
.znp-myjobs .tab.active .tab-count { background: var(--blue); color: #fff; }

/* JOB ROWS */
.znp-myjobs .job-row { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-sm); padding: 0; margin-bottom: 7px; display: grid; grid-template-columns: 1fr auto; gap: 0; align-items: stretch; transition: all .2s; position: relative; overflow: hidden; }
.znp-myjobs .job-row:hover  { box-shadow: var(--shadow-md); border-color: rgba(59,92,204,.2); }
.znp-myjobs .job-row.inactive { opacity: .65; }
.znp-myjobs .job-left { display: flex; flex-direction: column; min-width: 0; padding: 12px 16px 0; flex: 1; justify-content: space-between; }
.znp-myjobs .job-logo { width: 40px; height: 40px; border-radius: 10px; background: var(--surface-2); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; color: var(--blue); flex-shrink: 0; }
.znp-myjobs .job-info { min-width: 0; flex: 1; }
.znp-myjobs .job-title { font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 2px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.znp-myjobs .status-pill { font-size: 10px; font-weight: 700; padding: 1px 7px; border-radius: 20px; flex-shrink: 0; }
.znp-myjobs .sp-active   { background: var(--green-light); color: var(--green); border: 1px solid var(--green-100); }
.znp-myjobs .sp-inactive { background: #f1f5f9; color: var(--t4); border: 1px solid var(--border); }
.znp-myjobs .sp-expired  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.znp-myjobs .sp-pending  { background: var(--orange-light); color: var(--orange); border: 1px solid #fed7aa; }
.znp-myjobs .job-meta { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; font-size: 11px; color: var(--t3); }
.znp-myjobs .jm-item { display: flex; align-items: center; gap: 4px; }
.znp-myjobs .job-tags { display: flex; gap: 5px; flex-wrap: wrap; margin-top: 5px; }
.znp-myjobs .jtag { font-size: 10.5px; font-weight: 500; padding: 2px 7px; border-radius: 5px; background: var(--bg); border: 1px solid var(--border); color: var(--t2); }

/* RIGHT SIDE of job row */
.znp-myjobs .job-right { display: flex; align-items: stretch; flex-shrink: 0; border-left: 1px solid var(--border); }
.znp-myjobs .app-panel { background: var(--surface); border: none; overflow: hidden; min-width: 192px; transition: background .2s; cursor: pointer; text-decoration: none; display: flex; flex-direction: column; justify-content: center; }
.znp-myjobs .app-panel:hover { background: var(--blue-light); }

/* APPLICANT PANEL */
.znp-myjobs .app-panel-header { display: flex; align-items: center; justify-content: space-between; padding: 8px 12px 6px; background: var(--blue-light); border-bottom: 1px solid var(--blue-100); }
.znp-myjobs .app-total-row { display: flex; align-items: baseline; gap: 6px; }
.znp-myjobs .app-big-num   { font-size: 20px; font-weight: 800; color: var(--blue); line-height: 1; }
.znp-myjobs .app-total-lbl { font-size: 10.5px; font-weight: 600; color: var(--t3); }
.znp-myjobs .app-new-badge { font-size: 9.5px; font-weight: 700; color: #fff; background: var(--orange); padding: 2px 7px; border-radius: 20px; white-space: nowrap; }
.znp-myjobs .app-chevron   { width: 14px; height: 14px; stroke: var(--blue); flex-shrink: 0; }
.znp-myjobs .app-breakdown { display: grid; grid-template-columns: 1fr 1fr 1fr; padding: 8px 0 7px; gap: 0; }
.znp-myjobs .app-stat      { display: flex; flex-direction: column; align-items: center; gap: 2px; padding: 0 4px; }
.znp-myjobs .app-stat + .app-stat { border-left: 1px solid var(--border); }
.znp-myjobs .app-stat-num  { font-size: 14px; font-weight: 800; color: var(--text); line-height: 1; }
.znp-myjobs .app-stat-lbl  { font-size: 9.5px; font-weight: 600; color: var(--t4); text-transform: uppercase; letter-spacing: .04em; white-space: nowrap; }

/* ACTIONS */
.znp-myjobs .job-actions { display: flex; gap: 7px; align-items: center; }
.znp-myjobs .act-btn { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; cursor: pointer; border: 1.5px solid var(--border); background: var(--surface); color: var(--t2); transition: all .15s; }
.znp-myjobs .act-btn:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-light); }
.znp-myjobs .act-btn.repost { border-color: #0891b2; color: #0891b2; background: #ecfeff; }
.znp-myjobs .act-btn.repost:hover { background: #0891b2; color: #fff; }
.znp-myjobs .act-btn.toggle-off { border-color: var(--border); color: var(--t3); background: var(--surface); }
.znp-myjobs .act-btn.toggle-off:hover { border-color: var(--t3); color: var(--text); background: var(--bg); }
.znp-myjobs .act-btn.clone { border-color: var(--blue-100); color: var(--blue); background: var(--blue-light); }
.znp-myjobs .act-btn.clone:hover { background: var(--blue); color: #fff; border-color: var(--blue); }
.znp-myjobs .posted-by { font-size: 10.5px; color: var(--t4); display: flex; align-items: center; gap: 4px; }
.znp-myjobs .posted-by span { color: var(--t2); font-weight: 600; }
.znp-myjobs .job-footer { display: flex; align-items: center; justify-content: space-between; padding: 8px 0 10px; margin-top: 8px; border-top: 1px solid var(--border); gap: 12px; flex-wrap: wrap; }

/* EXPIRES BADGE */
.znp-myjobs .expires { font-size: 10.5px; color: var(--t4); display: flex; align-items: center; gap: 3px; }
.znp-myjobs .expires.soon { color: var(--orange); font-weight: 600; }
.znp-myjobs .expires.exp  { color: #dc2626; font-weight: 600; }

/* EMPTY STATE */
.znp-myjobs .empty { text-align: center; padding: 60px 20px; color: var(--t4); }
.znp-myjobs .empty-ico { width: 56px; height: 56px; background: var(--surface-2); border: 1px solid var(--border); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
.znp-myjobs .empty h3 { font-size: 16px; font-weight: 700; color: var(--t2); margin-bottom: 6px; }
.znp-myjobs .empty p  { font-size: 13px; color: var(--t4); margin-bottom: 12px; }

/* BUY MORE NUDGE */
.znp-myjobs .buy-nudge { border: 2px dashed var(--border); border-radius: 12px; padding: 28px 24px; text-align: center; margin-top: 8px; background: #fafbff; }
.znp-myjobs .buy-nudge-ico { width: 44px; height: 44px; background: var(--blue-light); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
.znp-myjobs .buy-nudge-title { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 6px; }
.znp-myjobs .buy-nudge-sub   { font-size: 12.5px; color: var(--t3); margin-bottom: 18px; max-width: 320px; margin-left: auto; margin-right: auto; }
.znp-myjobs .buy-nudge-btns  { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
.znp-myjobs .buy-btn-primary { padding: 9px 22px; background: var(--blue); color: #fff; border: none; border-radius: 50px; font-size: 13px; font-weight: 700; cursor: pointer; }
.znp-myjobs .buy-btn-secondary { padding: 9px 22px; background: var(--orange-light); color: var(--orange); border: 1.5px solid #fed7aa; border-radius: 50px; font-size: 13px; font-weight: 700; cursor: pointer; }

/* TOAST (renamed mj-toast to avoid Bootstrap .toast clash) */
.znp-myjobs .mj-toast { position: fixed; bottom: 24px; right: 24px; background: var(--text); color: #fff; padding: 11px 18px; border-radius: var(--r-sm); font-size: 13px; font-weight: 500; box-shadow: 0 8px 24px rgba(0,0,0,.2); z-index: 999; transform: translateY(80px); opacity: 0; transition: all .3s; max-width: 300px; }
.znp-myjobs .mj-toast.show { transform: translateY(0); opacity: 1; }

/* CLONE MODAL */
.znp-myjobs .clone-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(15,23,42,.45); z-index: 300; align-items: center; justify-content: center; backdrop-filter: blur(3px); }
.znp-myjobs .clone-modal-overlay.open { display: flex; }
.znp-myjobs .clone-modal { background: #fff; border-radius: 16px; width: 100%; max-width: 480px; box-shadow: 0 24px 64px rgba(15,23,42,.18); overflow: hidden; animation: znpMjCmIn .25s ease; }
@keyframes znpMjCmIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
.znp-myjobs .cm-head { padding: 20px 24px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
.znp-myjobs .cm-title { font-size: 15px; font-weight: 800; color: var(--text); margin-bottom: 3px; }
.znp-myjobs .cm-sub   { font-size: 12px; color: var(--t3); }
.znp-myjobs .cm-close { width: 28px; height: 28px; border-radius: 50%; border: none; background: var(--bg); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--t3); flex-shrink: 0; font-size: 16px; line-height: 1; }
.znp-myjobs .cm-close:hover { background: var(--border); color: var(--text); }
.znp-myjobs .cm-body  { padding: 20px 24px; }
.znp-myjobs .cm-field { margin-bottom: 14px; }
.znp-myjobs .cm-label { font-size: 11.5px; font-weight: 700; color: var(--t2); margin-bottom: 6px; display: block; }
.znp-myjobs .cm-input { width: 100%; padding: 9px 12px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 13px; color: var(--text); outline: none; transition: border-color .2s; }
.znp-myjobs .cm-input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,92,204,.09); }
.znp-myjobs .cm-checks { display: flex; flex-direction: column; gap: 8px; margin-top: 2px; }
.znp-myjobs .cm-check  { display: flex; align-items: flex-start; gap: 9px; padding: 8px 10px; border: 1.5px solid var(--border); border-radius: 8px; cursor: pointer; transition: all .15s; }
.znp-myjobs .cm-check:hover { border-color: var(--blue-100); background: var(--blue-light); }
.znp-myjobs .cm-check input { margin-top: 1px; accent-color: var(--blue); width: 14px; height: 14px; flex-shrink: 0; cursor: pointer; }
.znp-myjobs .cm-check-text  { font-size: 12.5px; color: var(--t2); font-weight: 500; }
.znp-myjobs .cm-check-text small { display: block; font-size: 11px; color: var(--t4); font-weight: 400; margin-top: 1px; }
.znp-myjobs .cm-foot { padding: 14px 24px; border-top: 1px solid var(--border); display: flex; gap: 8px; justify-content: flex-end; }
.znp-myjobs .cm-btn-cancel { padding: 8px 18px; border: 1.5px solid var(--border); background: #fff; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--t2); cursor: pointer; }
.znp-myjobs .cm-btn-cancel:hover { border-color: var(--t3); }
.znp-myjobs .cm-btn-clone { padding: 8px 20px; border: none; background: var(--blue); border-radius: 8px; font-size: 13px; font-weight: 700; color: #fff; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: background .2s; }
.znp-myjobs .cm-btn-clone:hover { background: var(--blue-d); }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
    .znp-myjobs .shell { grid-template-columns: 1fr; }
    .znp-myjobs .sidebar { display: none; }
    .znp-myjobs .job-right { flex-direction: row; align-items: center; }
    .znp-myjobs .posted-by { display: none; }
}
@media (max-width: 600px) {
    .znp-myjobs .job-row { grid-template-columns: 1fr; }
    .znp-myjobs .job-right { flex-direction: row; flex-wrap: wrap; justify-content: flex-start; }
}
</style>
@endpush

@section('content')
<div class="znp-myjobs">

    {{-- ── INLINE NAV (employer-specific; no shared header — same pattern as post-job) ── --}}
    @php
        /* Plan state flags — keep all derived booleans in one place so the
           sidebar + chip + buy-more nudge below all read from the same source. */
        $hasPlan    = !empty($plan['has_plan']);
        $isExpired  = !empty($plan['is_expired']);
        $isUnlimited= !empty($plan['is_unlimited']);
        $isFull     = ($plan['tone'] ?? '') === 'full';
        $isWarn     = ($plan['tone'] ?? '') === 'warn';
        $canPost    = !empty($plan['can_post']);
        $pricingUrl = $plan['pricing_url'] ?? route('employer.job.pricing');
    @endphp
    <nav class="mj-nav">
        <a class="mj-logo" href="{{ url('/') }}">
            <span class="la">Zero</span><span class="lb">Notice</span><span class="lc">Period</span>
        </a>
        <div class="nav-r">
            <a class="plan-chip {{ $isWarn ? 'growth' : '' }} {{ $isFull ? 'enterprise' : '' }}"
               href="{{ $pricingUrl }}"
               id="planChip"
               style="text-decoration:none;{{ $isFull ? 'color:#dc2626;background:#fef2f2;border-color:#fecaca;' : '' }}"
               title="{{ $plan['sub_line'] ?? '' }}">
                {{ $plan['label'] }}
            </a>
            @if ($canPost)
                <a class="btn-post" href="{{ route('employer.post.job.page') }}" title="Post a new job">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Post a Job
                </a>
            @else
                <a class="btn-post" href="{{ $plan['cta_url'] ?? $pricingUrl }}" style="background:#f1f5f9;color:#64748b;box-shadow:none;" title="{{ $plan['sub_line'] ?? 'Buy a plan to post jobs' }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    {{ $plan['cta_label'] ?? 'Buy a Plan' }}
                </a>
            @endif
            <div class="av" title="{{ $company->name ?? 'Employer' }}">{{ $companyInitials }}</div>
        </div>
    </nav>

    <div class="shell">

        {{-- ── SIDEBAR ── --}}
        <aside class="sidebar">

            {{-- ─────────────────────────────────────────────────────────────
                 PLAN USAGE BAR
                 Five mutually-exclusive states (driven by $plan / $hasPlan
                 / $isExpired / $isUnlimited from the top of this template):
                   1. No plan       — orange "Choose a plan" prompt
                   2. Expired       — red "Renew plan" prompt
                   3. Full          — red bar at 100% + "Buy more" link
                   4. Unlimited     — neutral "Pro · X posted · expires …"
                   5. Active w/quota — blue/orange progress bar + expires date
            ───────────────────────────────────────────────────────────── --}}
            @if (! $hasPlan)
                <div class="plan-bar" style="border-color:#fed7aa;background:#fff7ed;">
                    <div class="pb-label" style="color:#c2410c;">
                        <span>No active plan</span>
                    </div>
                    <div class="pb-sub" style="color:#c2410c;">
                        Choose a plan to start posting &nbsp;
                        <a class="upgrade-link" href="{{ $pricingUrl }}" style="color:#c2410c;">Choose →</a>
                    </div>
                </div>
            @elseif ($isExpired)
                <div class="plan-bar" style="border-color:#fecaca;background:#fef2f2;">
                    <div class="pb-label" style="color:#dc2626;">
                        <span>{{ $plan['name'] }} · expired</span>
                    </div>
                    <div class="pb-sub" style="color:#dc2626;">
                        Expired on {{ $plan['expires_label'] }} &nbsp;
                        <a class="upgrade-link" href="{{ $pricingUrl }}" style="color:#dc2626;font-weight:700;">Renew →</a>
                    </div>
                </div>
            @elseif ($isUnlimited)
                <div class="plan-bar">
                    <div class="pb-label">
                        <span>{{ $plan['name'] }}</span>
                        <span id="usageLabel">{{ $plan['used'] }} posted</span>
                    </div>
                    <div class="pb-sub">
                        Unlimited posts
                        @if (!empty($plan['expires_label']))
                            · expires {{ $plan['expires_label'] }}
                        @endif
                    </div>
                </div>
            @elseif ($isFull)
                <div class="plan-bar" style="border-color:#fecaca;background:#fef2f2;">
                    <div class="pb-label" style="color:#dc2626;">
                        <span>Posts used</span>
                        <span id="usageLabel">{{ $plan['used'] }} / {{ $plan['limit'] }}</span>
                    </div>
                    <div class="pb-track"><div class="pb-fill full" id="pbFill" style="width:100%"></div></div>
                    <div class="pb-sub" style="color:#dc2626;">
                        No credits remaining &nbsp;
                        <a class="upgrade-link" href="{{ $pricingUrl }}" style="color:#dc2626;font-weight:700;">Buy more →</a>
                    </div>
                </div>
            @else
                <div class="plan-bar">
                    <div class="pb-label">
                        <span>Posts used</span>
                        <span id="usageLabel">{{ $plan['used'] }} / {{ $plan['limit'] }}</span>
                    </div>
                    <div class="pb-track"><div class="pb-fill {{ $isWarn ? 'warn' : '' }}" id="pbFill" style="width:{{ $plan['percent'] }}%"></div></div>
                    <div class="pb-sub">
                        {{ $plan['remaining'] }} credit{{ $plan['remaining'] === 1 ? '' : 's' }} remaining
                        @if (!empty($plan['expires_label']))
                            · expires {{ $plan['expires_label'] }}
                        @endif
                        &nbsp;
                        <a class="upgrade-link" href="{{ $pricingUrl }}">Upgrade →</a>
                    </div>
                </div>
            @endif

            <div class="sb-title">Filters <span class="clear-link" onclick="MJ.clearFilters()">Clear all</span></div>

            <div class="sb-section">
                <input class="sb-search" id="mjSearch" type="text" placeholder="Search job title…" oninput="MJ.applyFilters()">
            </div>

            <div class="sb-section">
                <div class="sb-section-lbl">Status</div>
                <label class="sb-check"><input type="checkbox" data-facet="status" value="active" onchange="MJ.applyFilters()"><label>Active</label><span class="cnt">{{ $statusCounts['active'] }}</span></label>
                <label class="sb-check"><input type="checkbox" data-facet="status" value="inactive" onchange="MJ.applyFilters()"><label>Inactive</label><span class="cnt">{{ $statusCounts['inactive'] }}</span></label>
                <label class="sb-check"><input type="checkbox" data-facet="status" value="expired" onchange="MJ.applyFilters()"><label>Expired</label><span class="cnt">{{ $statusCounts['expired'] }}</span></label>
            </div>

            @if ($modeCounts['wfo'] + $modeCounts['hybrid'] + $modeCounts['remote'] > 0)
                <div class="sb-divider"></div>
                <div class="sb-section">
                    <div class="sb-section-lbl">Work Mode</div>
                    <label class="sb-check"><input type="checkbox" data-facet="mode" value="wfo" onchange="MJ.applyFilters()"><label>Work from Office</label><span class="cnt">{{ $modeCounts['wfo'] }}</span></label>
                    <label class="sb-check"><input type="checkbox" data-facet="mode" value="hybrid" onchange="MJ.applyFilters()"><label>Hybrid</label><span class="cnt">{{ $modeCounts['hybrid'] }}</span></label>
                    <label class="sb-check"><input type="checkbox" data-facet="mode" value="remote" onchange="MJ.applyFilters()"><label>Remote</label><span class="cnt">{{ $modeCounts['remote'] }}</span></label>
                </div>
            @endif

            @if ($typeCounts['permanent'] + $typeCounts['contract'] > 0)
                <div class="sb-divider"></div>
                <div class="sb-section">
                    <div class="sb-section-lbl">Job Type</div>
                    <label class="sb-check"><input type="checkbox" data-facet="type" value="permanent" onchange="MJ.applyFilters()"><label>Permanent</label><span class="cnt">{{ $typeCounts['permanent'] }}</span></label>
                    <label class="sb-check"><input type="checkbox" data-facet="type" value="contract" onchange="MJ.applyFilters()"><label>Contract</label><span class="cnt">{{ $typeCounts['contract'] }}</span></label>
                </div>
            @endif

            <div class="sb-divider"></div>

            <div class="sb-section">
                <div class="sb-section-lbl">Posted Between</div>
                <input class="sb-date" id="mjDateFrom" type="date" onchange="MJ.applyFilters()" style="margin-bottom:7px">
                <input class="sb-date" id="mjDateTo"   type="date" onchange="MJ.applyFilters()">
            </div>

            @if (count($locationCounts) > 0)
                <div class="sb-divider"></div>
                <div class="sb-section">
                    <div class="sb-section-lbl">Location</div>
                    @foreach ($locationCounts as $loc => $cnt)
                        <label class="sb-check">
                            <input type="checkbox" data-facet="location" value="{{ $loc }}" onchange="MJ.applyFilters()">
                            <label>{{ $loc }}</label>
                            <span class="cnt">{{ $cnt }}</span>
                        </label>
                    @endforeach
                </div>
            @endif

        </aside>

        {{-- ── MAIN ── --}}
        <main class="main">

            <div class="top-bar">
                <div class="top-left">
                    <h1>My Job Postings</h1>
                    <p id="jobCount">
                        @if ($statusCounts['all'] === 0)
                            No jobs posted yet
                        @else
                            Showing {{ $statusCounts['all'] }} job{{ $statusCounts['all'] === 1 ? '' : 's' }} · {{ $statusCounts['active'] }} active
                        @endif
                    </p>
                </div>
                <div class="top-right">
                    <select class="sort-sel" id="mjSort" onchange="MJ.applyFilters()">
                        <option value="newest">Newest first</option>
                        <option value="oldest">Oldest first</option>
                        <option value="applicants">Most applicants</option>
                        <option value="expiring">Expiring soon</option>
                    </select>
                </div>
            </div>

            {{-- TABS --}}
            <div class="tab-row">
                <button class="tab active" data-tab="all"      onclick="MJ.setTab(this,'all')">All <span class="tab-count">{{ $statusCounts['all'] }}</span></button>
                <button class="tab"        data-tab="active"   onclick="MJ.setTab(this,'active')">Active <span class="tab-count">{{ $statusCounts['active'] }}</span></button>
                <button class="tab"        data-tab="inactive" onclick="MJ.setTab(this,'inactive')">Inactive <span class="tab-count">{{ $statusCounts['inactive'] }}</span></button>
                <button class="tab"        data-tab="expired"  onclick="MJ.setTab(this,'expired')">Expired <span class="tab-count">{{ $statusCounts['expired'] }}</span></button>
            </div>

            {{-- JOB LIST --}}
            <div id="jobList">

                @forelse ($jobs as $job)
                    @php $d = $job->derived; @endphp
                    <div class="job-row {{ $d['status_key'] === 'inactive' ? 'inactive' : '' }}"
                         data-id="{{ $job->id }}"
                         data-status="{{ $d['status_key'] }}"
                         data-mode="{{ $d['mode_key'] }}"
                         data-type="{{ $d['type_key'] }}"
                         data-locations="{{ implode('|', $d['locations']) }}"
                         data-title="{{ strtolower((string) $job->job_title) }}"
                         data-posted-ts="{{ optional($job->created_at)->getTimestamp() ?? 0 }}"
                         data-applicants="{{ $d['applicants_total'] }}"
                         data-expires-ts="{{ $d['expires_ts'] ?? 0 }}">
                        <div class="job-left">
                            <div class="job-info">
                                <div class="job-title">
                                    {{ $job->job_title }}
                                    <span class="status-pill sp-{{ $d['status_key'] }}">{{ $d['status_label'] }}</span>
                                </div>
                                <div class="job-meta">
                                    @if (!empty($d['location_label']) && $d['location_label'] !== '—')
                                        <span class="jm-item"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>{{ $d['location_label'] }}</span>
                                    @endif
                                    @if (!empty($d['type_label']))
                                        <span class="jm-item"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>{{ $d['type_label'] }}</span>
                                    @endif
                                    <span class="jm-item"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>{{ $d['posted_label'] }}</span>
                                    @if (!empty($d['expires_label']))
                                        <span class="expires {{ $d['expires_tone'] }}"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>{{ $d['expires_label'] }}</span>
                                    @endif
                                </div>
                                <div class="job-tags">
                                    @if (!empty($d['mode_label']))     <span class="jtag">{{ $d['mode_label'] }}</span>     @endif
                                    @if (!empty($d['exp_label']))      <span class="jtag">{{ $d['exp_label'] }}</span>      @endif
                                    @if (!empty($d['salary_label']))   <span class="jtag">{{ $d['salary_label'] }}</span>   @endif
                                    @if (!empty($d['skills_label']))   <span class="jtag">{{ $d['skills_label'] }}</span>   @endif
                                </div>
                            </div>
                            <div class="job-footer">
                                <div class="job-actions">
                                    @if ($d['status_key'] === 'expired')
                                        <button class="act-btn repost" onclick="MJ.repost(this, {{ $job->id }})">Repost</button>
                                    @endif
                                    <button class="act-btn clone" onclick="MJ.openClone(this)">Clone</button>
                                    <a class="act-btn" href="{{ route('employer.post.job.edit', ['id' => $job->id]) }}">Edit</a>
                                    @if ($d['status_key'] === 'inactive')
                                        <button class="act-btn" data-toggle-target="1" onclick="MJ.toggleStatus(this, {{ $job->id }}, 'inactive')" style="border-color:var(--green);color:var(--green);background:var(--green-light);">Activate</button>
                                    @else
                                        <button class="act-btn toggle-off" data-toggle-target="0" onclick="MJ.toggleStatus(this, {{ $job->id }}, 'active')">Deactivate</button>
                                    @endif
                                </div>
                                <div class="posted-by">Posted by <span>{{ $company->name ?: 'Employer' }}</span></div>
                            </div>
                        </div>
                        <div class="job-right">
                            <a class="app-panel" href="{{ route('employer.post.job.applicants', ['id' => $job->id]) }}" title="View applicants">
                                <div class="app-panel-header">
                                    <div class="app-total-row">
                                        <span class="app-big-num">{{ $d['applicants_total'] }}</span>
                                        <span class="app-total-lbl">{{ $d['applicants_total'] === 1 ? 'applicant' : 'applicants' }}</span>
                                        @if ($d['applicants_new'] > 0)
                                            <span class="app-new-badge">+{{ $d['applicants_new'] }} new</span>
                                        @endif
                                    </div>
                                    <svg class="app-chevron" viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                                </div>
                                <div class="app-breakdown">
                                    <div class="app-stat">
                                        <span class="app-stat-num">{{ $d['applicants_new'] }}</span>
                                        <span class="app-stat-lbl">New</span>
                                    </div>
                                    <div class="app-stat">
                                        <span class="app-stat-num">{{ $d['applicants_viewed'] }}</span>
                                        <span class="app-stat-lbl">Viewed</span>
                                    </div>
                                    <div class="app-stat">
                                        <span class="app-stat-num">{{ $d['applicants_pending'] }}</span>
                                        <span class="app-stat-lbl">Pending</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="empty">
                        <div class="empty-ico">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18"/></svg>
                        </div>
                        @if($canPost)
                            <h3>No jobs posted yet</h3>
                            <p>You haven't published any jobs from this account.</p>
                            <a class="buy-btn-primary" href="{{ route('employer.post.job.page') }}" style="display:inline-block;text-decoration:none;">Post your first job</a>
                        @else
                            <h3>{{ $hasPlan ? ($isExpired ? 'Your plan has expired' : "You're out of posts") : 'Choose a plan to start posting' }}</h3>
                            <p>{{ $plan['sub_line'] ?? 'Pick a plan to post your first job on ZeroNoticePeriod.' }}</p>
                            <a class="buy-btn-primary" href="{{ $plan['cta_url'] ?? $pricingUrl }}" style="display:inline-block;text-decoration:none;">{{ $plan['cta_label'] ?? 'Choose a Plan' }} →</a>
                        @endif
                    </div>
                @endforelse

                {{-- ── EMPTY-FILTER STATE (shown by JS when current filters hide every row) ── --}}
                <div class="empty" id="mjEmptyFiltered" style="display:none;">
                    <div class="empty-ico">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    </div>
                    <h3>No jobs match your filters</h3>
                    <p>Try clearing some filters or switching tabs.</p>
                    <button class="buy-btn-secondary" onclick="MJ.clearFilters()" style="border:none;">Clear all filters</button>
                </div>

                {{-- BUY-MORE NUDGE — only when this account has posts but is
                     out of quota OR plan has expired. Buttons are data-driven
                     from $upsellPlans (passed in by myJobsZNP) so price /
                     name changes in the DB reflect here without code edits. --}}
                @if ($statusCounts['all'] > 0 && ($isFull || $isExpired))
                    @php
                        /* Pick up to 2 plans to show as buttons: prefer the
                           current plan slug first (for "buy another Flex pack")
                           then the next-best option after it. */
                        $currentSlug = $plan['plan_slug'] ?? null;
                        $offers = ($upsellPlans ?? collect())->take(2);
                        $sameAgain = ($upsellPlans ?? collect())->firstWhere('slug', $currentSlug);
                        if ($sameAgain) {
                            $offers = collect([$sameAgain])
                                ->concat(($upsellPlans ?? collect())->where('slug', '!=', $currentSlug))
                                ->take(2);
                        }
                    @endphp
                    <div class="buy-nudge">
                        <div class="buy-nudge-ico">
                            <svg width="20" height="20" fill="none" stroke="#3B5CCC" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </div>
                        <div class="buy-nudge-title">
                            @if($isExpired)
                                Your {{ $plan['name'] }} plan has expired
                            @else
                                Post another job
                            @endif
                        </div>
                        <div class="buy-nudge-sub">
                            @if($isExpired)
                                Renew your plan or pick a different pack to keep hiring on ZNP.
                            @else
                                You've used all {{ $plan['limit'] }} posts on your <strong>{{ $plan['name'] }}</strong> plan. Pick up another pack to keep going.
                            @endif
                        </div>
                        <div class="buy-nudge-btns">
                            @foreach($offers as $i => $p)
                                @php
                                    $btnClass = $i === 0 ? 'buy-btn-primary' : 'buy-btn-secondary';
                                    $priceLabel = $p->is_custom_price
                                        ? 'Talk to Sales'
                                        : '₹' . number_format((float) $p->price, 0, '.', ',');
                                @endphp
                                <a href="{{ $pricingUrl }}" class="{{ $btnClass }}" style="display:inline-block;text-decoration:none;">
                                    @if($p->is_custom_price)
                                        {{ $p->name }} · {{ $priceLabel }} →
                                    @else
                                        {{ $p->name }} · {{ $priceLabel }}@if((int)$p->job_posts_limit > 1) for {{ (int)$p->job_posts_limit }} posts @endif
                                    @endif
                                </a>
                            @endforeach
                            @if($offers->isEmpty())
                                <a href="{{ $pricingUrl }}" class="buy-btn-primary" style="display:inline-block;text-decoration:none;">View plans →</a>
                            @endif
                        </div>
                    </div>
                @endif

            </div>{{-- /jobList --}}
        </main>
    </div>

    {{-- TOAST --}}
    <div class="mj-toast" id="toast"></div>

    {{-- CLONE MODAL --}}
    <div class="clone-modal-overlay" id="cloneOverlay" onclick="MJ.handleOverlayClick(event)">
        <div class="clone-modal">
            <div class="cm-head">
                <div>
                    <div class="cm-title">Clone Job Post</div>
                    <div class="cm-sub" id="cloneSourceLabel">Creating a copy of <strong>–</strong></div>
                </div>
                <button class="cm-close" onclick="MJ.closeClone()">×</button>
            </div>
            <div class="cm-body">
                <div class="cm-field">
                    <label class="cm-label">New job title</label>
                    <input class="cm-input" type="text" id="cloneTitle" placeholder="e.g. Senior .NET Developer (Copy)">
                </div>
                <div class="cm-sub" style="font-size:12px;color:var(--t3);">
                    The cloned post opens in the editor pre-filled with the original job's
                    description, salary, experience, interview modes, questionnaire, perks
                    and awards. You can adjust anything before publishing.
                </div>
            </div>
            <div class="cm-foot">
                <button class="cm-btn-cancel" onclick="MJ.closeClone()">Cancel</button>
                <button class="cm-btn-clone" id="cmConfirmBtn" onclick="MJ.confirmClone()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    Clone &amp; Open Editor
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
window.MJ = (function () {
    'use strict';

    /* ── Endpoints / config injected from Blade ─────────────────────────── */
    var ROUTES = {
        toggleStatus: @json(route('make.active.job')),
        cloneStore:   '/clone-front-job/',     // POST /clone-front-job/{id}
        editPrefix:   '/post-job-page/',       // GET  /post-job-page/{id}/edit
    };
    var CSRF = document.querySelector('meta[name=csrf-token]')?.content || '';

    /* ── Filter / sort state ────────────────────────────────────────────── */
    var state = {
        tab: 'all',
        search: '',
        status: new Set(),
        mode:   new Set(),
        type:   new Set(),
        location: new Set(),
        from: null,
        to:   null,
        sort: 'newest',
    };

    var rows = function () { return Array.from(document.querySelectorAll('.znp-myjobs #jobList .job-row')); };

    /* ── Tab handling ───────────────────────────────────────────────────── */
    function setTab(btn, tab) {
        document.querySelectorAll('.znp-myjobs .tab').forEach(function (t) { t.classList.remove('active'); });
        btn.classList.add('active');
        state.tab = tab;
        applyFilters();
    }

    /* ── Read filter widget state into `state` ──────────────────────────── */
    function readWidgets() {
        state.search = (document.getElementById('mjSearch')?.value || '').trim().toLowerCase();
        state.sort   = document.getElementById('mjSort')?.value || 'newest';
        state.from   = parseDate(document.getElementById('mjDateFrom')?.value);
        state.to     = parseDate(document.getElementById('mjDateTo')?.value);
        state.to     = state.to ? state.to + 86400 : null; // include the "to" day fully

        ['status', 'mode', 'type', 'location'].forEach(function (k) {
            state[k] = new Set(
                Array.from(document.querySelectorAll('.znp-myjobs .sidebar input[data-facet=' + k + ']:checked'))
                     .map(function (cb) { return cb.value; })
            );
        });
    }

    function parseDate(s) {
        if (!s) return null;
        var t = Date.parse(s + 'T00:00:00');
        return isNaN(t) ? null : Math.floor(t / 1000);
    }

    /* ── Single row predicate ───────────────────────────────────────────── */
    function matches(row) {
        var status = row.getAttribute('data-status');
        if (state.tab !== 'all' && state.tab !== status) return false;
        if (state.status.size > 0 && !state.status.has(status)) return false;

        if (state.mode.size > 0) {
            var m = row.getAttribute('data-mode');
            if (!m || !state.mode.has(m)) return false;
        }
        if (state.type.size > 0) {
            var t = row.getAttribute('data-type');
            if (!t || !state.type.has(t)) return false;
        }
        if (state.location.size > 0) {
            var locs = (row.getAttribute('data-locations') || '').split('|').filter(Boolean);
            var ok = false;
            for (var i = 0; i < locs.length; i++) { if (state.location.has(locs[i])) { ok = true; break; } }
            if (!ok) return false;
        }
        if (state.search) {
            var title = row.getAttribute('data-title') || '';
            if (!title.includes(state.search)) return false;
        }
        var posted = parseInt(row.getAttribute('data-posted-ts') || '0', 10);
        if (state.from && posted < state.from) return false;
        if (state.to   && posted >= state.to) return false;

        return true;
    }

    /* ── Sort comparator ────────────────────────────────────────────────── */
    function compareRows(a, b) {
        switch (state.sort) {
            case 'oldest':
                return num(a, 'data-posted-ts') - num(b, 'data-posted-ts');
            case 'applicants':
                return num(b, 'data-applicants') - num(a, 'data-applicants');
            case 'expiring':
                return (num(a, 'data-expires-ts') || Infinity) - (num(b, 'data-expires-ts') || Infinity);
            case 'newest':
            default:
                return num(b, 'data-posted-ts') - num(a, 'data-posted-ts');
        }
    }
    function num(el, attr) { return parseInt(el.getAttribute(attr) || '0', 10); }

    /* ── Apply filters + sort + counter update ──────────────────────────── */
    function applyFilters() {
        readWidgets();
        var all = rows();
        var visible = 0;
        all.forEach(function (row) {
            var ok = matches(row);
            row.style.display = ok ? 'grid' : 'none';
            if (ok) visible++;
        });

        // Sort visible rows in DOM (skips hidden so they stay in their original spot).
        var visibleRows = all.filter(function (r) { return r.style.display !== 'none'; });
        visibleRows.sort(compareRows);
        var listEl = document.getElementById('jobList');
        var anchor = document.getElementById('mjEmptyFiltered');
        visibleRows.forEach(function (r) { listEl.insertBefore(r, anchor); });

        var counter = document.getElementById('jobCount');
        if (counter) {
            counter.textContent = visible === 0
                ? 'No jobs match your filters'
                : 'Showing ' + visible + (visible === 1 ? ' job' : ' jobs');
        }

        var emptyEl = document.getElementById('mjEmptyFiltered');
        if (emptyEl) emptyEl.style.display = (all.length > 0 && visible === 0) ? 'block' : 'none';
    }

    function clearFilters() {
        document.querySelectorAll('.znp-myjobs .sidebar input[type=checkbox]').forEach(function (cb) { cb.checked = false; });
        document.querySelectorAll('.znp-myjobs .sidebar input[type=date]').forEach(function (d) { d.value = ''; });
        var s = document.getElementById('mjSearch'); if (s) s.value = '';
        var sort = document.getElementById('mjSort'); if (sort) sort.value = 'newest';

        document.querySelectorAll('.znp-myjobs .tab').forEach(function (t) { t.classList.remove('active'); });
        var allTab = document.querySelector('.znp-myjobs .tab[data-tab=all]');
        if (allTab) allTab.classList.add('active');
        state.tab = 'all';

        applyFilters();
    }

    /* ── Activate / Deactivate (AJAX → make.active.job) ─────────────────── */
    function toggleStatus(btn, jobId, currentStatus) {
        if (btn.dataset.busy === '1') return;
        btn.dataset.busy = '1';
        var row = btn.closest('.job-row');
        var nextStatus = currentStatus === 'active' ? 0 : 1;

        var url = ROUTES.toggleStatus + '?job_id=' + encodeURIComponent(jobId) + '&status=' + nextStatus;
        fetch(url, { method: 'GET', credentials: 'same-origin', headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json().catch(function () { return null; }); })
            .then(function () {
                if (nextStatus === 0) {
                    row.setAttribute('data-status', 'inactive');
                    row.classList.add('inactive');
                    setPill(row, 'inactive', 'Inactive');
                    btn.textContent = 'Activate';
                    btn.style.borderColor = 'var(--green)';
                    btn.style.color = 'var(--green)';
                    btn.style.background = 'var(--green-light)';
                    btn.classList.remove('toggle-off');
                    btn.onclick = function () { toggleStatus(btn, jobId, 'inactive'); };
                    showToast('Job deactivated — no longer visible to candidates');
                } else {
                    row.setAttribute('data-status', 'active');
                    row.classList.remove('inactive');
                    setPill(row, 'active', 'Active');
                    btn.textContent = 'Deactivate';
                    btn.style.borderColor = '';
                    btn.style.color = '';
                    btn.style.background = '';
                    btn.classList.add('toggle-off');
                    btn.onclick = function () { toggleStatus(btn, jobId, 'active'); };
                    showToast('Job activated — it is now visible to candidates');
                }
                bumpTabCounts();
                applyFilters();
            })
            .catch(function () {
                showToast('Could not update job status. Please try again.');
            })
            .finally(function () { btn.dataset.busy = '0'; });
    }

    function setPill(row, key, label) {
        var pill = row.querySelector('.status-pill');
        if (!pill) return;
        pill.textContent = label;
        pill.className = 'status-pill sp-' + key;
    }

    function bumpTabCounts() {
        var counts = { all: 0, active: 0, inactive: 0, expired: 0 };
        rows().forEach(function (r) {
            counts.all++;
            counts[r.getAttribute('data-status')]++;
        });
        document.querySelectorAll('.znp-myjobs .tab').forEach(function (tab) {
            var k = tab.getAttribute('data-tab');
            var c = tab.querySelector('.tab-count');
            if (c && counts[k] !== undefined) c.textContent = counts[k];
        });
    }

    /* ── Clone modal ────────────────────────────────────────────────────── */
    var cloneJobId = null;
    var cloneSourceTitle = '';

    function openClone(btn) {
        var row = btn.closest('.job-row');
        cloneJobId = row.getAttribute('data-id');
        cloneSourceTitle = row.querySelector('.job-title').childNodes[0].textContent.trim();
        document.getElementById('cloneSourceLabel').innerHTML = 'Creating a copy of <strong>' + escapeHtml(cloneSourceTitle) + '</strong>';
        document.getElementById('cloneTitle').value = cloneSourceTitle + ' (Copy)';
        document.getElementById('cloneOverlay').classList.add('open');
        document.body.style.overflow = 'hidden';
        setTimeout(function () { document.getElementById('cloneTitle').select(); }, 100);
    }

    function closeClone() {
        document.getElementById('cloneOverlay').classList.remove('open');
        document.body.style.overflow = '';
    }

    function handleOverlayClick(e) {
        if (e.target === document.getElementById('cloneOverlay')) closeClone();
    }

    function confirmClone() {
        if (!cloneJobId) return;
        var btn = document.getElementById('cmConfirmBtn');
        if (btn.dataset.busy === '1') return;
        btn.dataset.busy = '1';
        // Existing legacy clone flow: GET /clone-front-job/{id} returns the editor with prefilled job.
        // We just navigate to it and let the user adjust the title/details before publishing.
        window.location = '/clone-front-job/' + encodeURIComponent(cloneJobId);
    }

    /* ── Repost (no dedicated backend yet — flips status to active) ─────── */
    function repost(btn, jobId) {
        // For an expired job, "Repost" simply re-activates so it shows on listings again.
        toggleStatus(btn, jobId, 'inactive');
    }

    /* ── Toast ──────────────────────────────────────────────────────────── */
    function showToast(msg) {
        var t = document.getElementById('toast');
        if (!t) return;
        t.textContent = msg;
        t.classList.add('show');
        clearTimeout(t._mjTimer);
        t._mjTimer = setTimeout(function () { t.classList.remove('show'); }, 3000);
    }

    function escapeHtml(s) {
        return String(s || '').replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    /* ── Boot ───────────────────────────────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', applyFilters);

    return {
        setTab: setTab,
        applyFilters: applyFilters,
        clearFilters: clearFilters,
        toggleStatus: toggleStatus,
        openClone: openClone,
        closeClone: closeClone,
        handleOverlayClick: handleOverlayClick,
        confirmClone: confirmClone,
        repost: repost,
        showToast: showToast,
    };
})();
</script>
@endpush
