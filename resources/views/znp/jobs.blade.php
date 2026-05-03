@extends('layouts.znp')

@section('page_title', 'Browse Immediate Joiner Jobs in India | ZeroNoticePeriod')

@push('styles')
<style>
/* ── ZNP JOBS: SCOPE & RESET ── */
.znp-jobs,
.znp-jobs * {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}
.znp-jobs { background: var(--bg); color: var(--text); font-size: 12px; overflow-x: hidden; }
.znp-jobs a              { color: inherit; text-decoration: none; }
.znp-jobs h1, .znp-jobs h2, .znp-jobs h3, .znp-jobs h4 { margin: 0; font-weight: inherit; }
.znp-jobs p              { margin: 0; }
.znp-jobs ul             { list-style: none; padding: 0; margin: 0; }
.znp-jobs button         { font-family: inherit !important; }

/* ── ZNP JOBS: page-scoped variable overrides (only values that differ from :root in znp-common.css) ── */
.znp-jobs {
    --blue:        #0056d2;   /* jobs uses a brighter blue than site default */
    --blue-dark:   #004bb8;
    --blue-light:  #ebf4ff;   /* not in site :root – jobs-specific tint */
    --green:       #16a34a;   /* jobs-specific utility token */
    --green-light: #f0fdf4;
    --yellow-bg:   #fffbf0;   /* promoted card bg */
}

/* ── SEARCH HERO ── */
.znp-jobs .search-hero { background: var(--white); border-bottom: 1px solid var(--border); padding: 20px 40px; }
.znp-jobs .sh-inner    { max-width: 1200px; margin: 0 auto; }
.znp-jobs .sh-title    { font-size: 16px; font-weight: 700; color: #4b5563; margin-bottom: 14px; letter-spacing: -0.3px; }
.znp-jobs .sh-title span { color: var(--orange); }

.znp-jobs .search-bar {
    display: flex;
    align-items: center;
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    max-width: 900px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    transition: border-color 0.15s;
}
.znp-jobs .search-bar:focus-within { border-color: var(--blue); }
.znp-jobs .sb-field {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0 12px;
    flex: 1;
    border-right: 1px solid var(--border);
}
.znp-jobs .sb-field:last-of-type { border-right: none; }
.znp-jobs .sb-icon { color: var(--text-light); flex-shrink: 0; width: 15px; height: 15px; }
.znp-jobs .sb-field input {
    border: none;
    outline: none;
    font-size: 13px;
    color: var(--text);
    width: 100%;
    padding: 11px 0;
    background: transparent;
}
.znp-jobs .sb-field input::placeholder { color: var(--text-light); }
.znp-jobs .sb-btn {
    background: var(--blue);
    border: none;
    color: var(--white);
    padding: 0 26px;
    height: 100%;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 7px;
    min-height: 46px;
}
.znp-jobs .sb-btn:hover { background: var(--blue-dark); }

/* CAROUSEL TAGS */
.znp-jobs .sh-tags         { position: relative; margin-top: 12px; overflow: hidden; }
.znp-jobs .sh-tags-wrapper { display: flex; align-items: center; }
.znp-jobs .sh-tag-label    { font-size: 11.5px; color: var(--text-muted); margin-right: 8px; flex-shrink: 0; }
.znp-jobs .sh-tags-scroll  { display: flex; gap: 7px; overflow-x: auto; scrollbar-width: none; scroll-behavior: smooth; }
.znp-jobs .sh-tags-scroll::-webkit-scrollbar { display: none; }
.znp-jobs .sh-tag {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 100px;
    padding: 4px 12px;
    font-size: 11.5px;
    color: var(--text-muted);
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
    flex-shrink: 0;
}
.znp-jobs .sh-tag:hover        { border-color: var(--blue); color: var(--blue); background: var(--blue-light); }
.znp-jobs .sh-tag.active       { border-color: var(--blue); color: var(--blue); background: var(--blue-light); font-weight: 600; }

/* ── PAGE LAYOUT ── */
.znp-jobs .page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 40px 60px;
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 20px;
    align-items: start;
}

/* ── FILTER SIDEBAR ── */
.znp-jobs .filter-sidebar {
    position: relative;
    top: auto;
    display: flex;
    flex-direction: column;
    gap: 0;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: visible;
    height: auto;
    max-height: none;
}
.znp-jobs .filter-header {
    padding: 12px 16px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}
.znp-jobs .filter-sections-container { overflow-y: auto; flex: 1; }
.znp-jobs .filter-sections-container::-webkit-scrollbar       { width: 6px; }
.znp-jobs .filter-sections-container::-webkit-scrollbar-track { background: transparent; }
.znp-jobs .filter-sections-container::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
.znp-jobs .filter-sections-container::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

.znp-jobs .filter-header-title { font-size: 13px; font-weight: 600; color: var(--text); }
.znp-jobs .filter-clear-all    { font-size: 11.5px; color: var(--blue); font-weight: 500; cursor: pointer; }
.znp-jobs .filter-clear-all:hover { text-decoration: underline; }

.znp-jobs .filter-section               { border-bottom: 1px solid var(--border); }
.znp-jobs .filter-section:last-child    { border-bottom: none; }
.znp-jobs .filter-section-header        { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; cursor: pointer; transition: background 0.12s; }
.znp-jobs .filter-section-header:hover  { background: #fafafa; }
.znp-jobs .fsh-title                    { font-size: 12.5px; font-weight: 600; color: var(--text); }
.znp-jobs .fsh-chevron                  { font-size: 10px; color: var(--text-light); transition: transform 0.2s; }
.znp-jobs .fsh-chevron.open             { transform: rotate(180deg); }
.znp-jobs .filter-section-body          { padding: 0 16px 12px; }

.znp-jobs .filter-search {
    width: 100%;
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 6px 10px;
    font-size: 12px;
    color: var(--text);
    outline: none;
    margin-bottom: 8px;
    transition: border 0.15s;
    background: var(--white);
}
.znp-jobs .filter-search:focus { border-color: var(--blue); }

.znp-jobs .filter-option        { display: flex; align-items: center; gap: 8px; padding: 5px 0; cursor: pointer; }
.znp-jobs .filter-option:hover .fo-label { color: var(--text); }
.znp-jobs .fo-box {
    width: 15px; height: 15px;
    border: 1.5px solid var(--border);
    border-radius: 3px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    color: transparent;
    transition: all 0.12s;
}
.znp-jobs .filter-option.checked .fo-box  { background: var(--blue); border-color: var(--blue); color: #fff; }
.znp-jobs .fo-label                        { font-size: 12px; color: var(--text-muted); flex: 1; transition: color 0.12s; }
.znp-jobs .filter-option.checked .fo-label { color: var(--text); font-weight: 500; }
.znp-jobs .fo-count {
    font-size: 10.5px;
    color: var(--text-light);
    background: #f3f4f6;
    border-radius: 100px;
    padding: 1px 6px;
}
.znp-jobs .filter-option.checked .fo-count { background: var(--blue-light); color: var(--blue); }
.znp-jobs .show-more-btn { font-size: 11.5px; color: var(--blue); cursor: pointer; margin-top: 4px; font-weight: 500; display: block; }
.znp-jobs .show-more-btn:hover { text-decoration: underline; }

/* Multi-column filter grids */
.znp-jobs .filter-location-grid {
    display: block;
    margin-bottom: 8px;
}
.znp-jobs .filter-location-grid .filter-option { padding: 4px 0; }
.znp-jobs .filter-location-grid .fo-label      { font-size: 11px; }
.znp-jobs .filter-location-grid .fo-count      { font-size: 9.5px; }

.znp-jobs .filter-education-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 5px 8px;
    margin-bottom: 8px;
}
.znp-jobs .filter-education-grid .filter-option { padding: 4px 0; }
.znp-jobs .filter-education-grid .fo-label      { font-size: 11px; }
.znp-jobs .filter-education-grid .fo-count      { font-size: 9.5px; }

/* ── RESULTS AREA ── */
.znp-jobs .results-area   { min-width: 0; }
.znp-jobs .results-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; flex-wrap: wrap; gap: 10px; }
.znp-jobs .results-count  { font-size: 13px; color: var(--text-muted); }
.znp-jobs .results-count strong { color: var(--text); font-weight: 600; }
.znp-jobs .sort-bar        { display: flex; align-items: center; gap: 8px; }
.znp-jobs .sort-label      { font-size: 12px; color: var(--text-muted); }
/* Custom sort dropdown */
.znp-jobs .sort-dropdown   { position: relative; }
.znp-jobs .sort-current {
    display: flex; align-items: center; gap: 6px;
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 6px 10px;
    font-size: 12px;
    color: var(--text-muted);
    background: var(--white);
    cursor: pointer;
    white-space: nowrap;
    font-family: inherit !important;
    transition: border-color 0.15s;
}
.znp-jobs .sort-current:hover           { border-color: var(--blue); color: var(--blue); }
.znp-jobs .sort-dropdown.open .sort-current { border-color: var(--blue); color: var(--blue); }
.znp-jobs .sort-options {
    display: none;
    position: absolute;
    top: calc(100% + 4px);
    right: 0;
    min-width: 165px;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 8px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.10);
    z-index: 500;
    overflow: hidden;
    padding: 4px 0;
}
.znp-jobs .sort-dropdown.open .sort-options { display: block; }
.znp-jobs .sort-option {
    padding: 9px 14px;
    font-size: 12px;
    color: var(--text-muted);
    cursor: pointer;
    transition: background 0.1s;
    white-space: nowrap;
}
.znp-jobs .sort-option:hover  { background: #f5f7ff; color: var(--blue); }
.znp-jobs .sort-option.active { color: var(--blue); font-weight: 600; background: var(--blue-light); }
/* Filter button in topbar — hidden desktop, shown mobile */
.znp-jobs .rt-left             { display: flex; align-items: center; gap: 8px; }
.znp-jobs .mob-topbar-filter-btn { display: none; }

/* active filter chips */
.znp-jobs .active-filters { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 14px; }
.znp-jobs .af-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: var(--blue-light);
    border: 1px solid #c7d5f8;
    color: var(--blue);
    border-radius: 100px;
    padding: 4px 10px;
    font-size: 11.5px;
    font-weight: 500;
}
.znp-jobs .af-chip .af-x       { cursor: pointer; font-size: 12px; color: #7a9de8; margin-left: 2px; }
.znp-jobs .af-chip .af-x:hover { color: var(--blue); }

/* ── JOB CARDS — overrides on top of znp-common.css base ── */
/* All base values (.job-card, .jc-top, .jc-avatar, .jc-title,
   .jc-company, .jc-tags, .tag, tag colours) come from znp-common.css.
   Only delta values are listed here.                                    */

/* job-card: list-view card is more compact with accent left-border */
.znp-jobs .job-card {
    border-radius: 10px;                    /* vs 12px in master */
    padding: 12px 14px;                     /* vs 18px 20px in master */
    gap: 6px;                               /* column gap between card rows */
    border-left: 3px solid var(--border);  /* accent stripe */
}
.znp-jobs .job-card:hover {
    box-shadow: 0 4px 18px rgba(249,115,22,0.12);
    border-color: #fed7aa;
    border-left-color: var(--orange);
    transform: translateY(-1px);
}
.znp-jobs .job-card.promoted { background: var(--yellow-bg); }

/* jc-top: list cards don't need the 12px bottom gap from master */
.znp-jobs .jc-top  { margin-bottom: 0; }

/* jc-avatar: larger (44px) with blue text on grey bg in list view */
.znp-jobs .jc-avatar {
    width: 44px; height: 44px;             /* vs 38px in master */
    border: 1px solid var(--border);
    background: var(--bg);
    font-size: 13px;    font-weight: 700;  /* vs 11px 800 in master */
    color: var(--blue);                    /* vs white in master */
}

/* jc-info: jobs-specific flex column wrapper (home uses .jc-meta) */
.znp-jobs .jc-info {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

/* jc-title: slightly larger in the list view */
.znp-jobs .jc-title {
    font-size: 13.5px;         /* vs 12px in master */
    font-weight: 600;          /* vs 700 in master */
    margin-bottom: 0;          /* gap handled by .jc-info gap */
    transition: color 0.12s;
    line-height: 1.3;
}
.znp-jobs .job-card:hover .jc-title { color: var(--blue); }

/* jc-company: badge/pill style in list view (vs plain text in grid) */
.znp-jobs .jc-company {
    font-size: 11px;
    color: #1e40af;
    font-weight: 600;
    padding: 4px 10px;
    background: #e6efff;
    border: 1px solid #b8cdfa;
    border-radius: 6px;
    margin-bottom: 0;
}

/* jc-tags: tighter gap, no bottom margin (bottom is flex-row with apply btn) */
.znp-jobs .jc-tags   { gap: 5px; margin-bottom: 0; }

/* tag: slightly smaller in list view */
.znp-jobs .tag       { font-size: 10.5px; font-weight: 500; padding: 2px 8px; }

/* Jobs-page-specific tag colours (different from master / new names) */
.znp-jobs .t-mode    { background: #f0f4ff; color: #2a52c9; border: 1px solid #d0daF5; }
.znp-jobs .t-type    { background: #f3faf6; color: #2d7a4f; border: 1px solid #b8d9c8; }
.znp-jobs .t-shift   { background: #f7f8fa; color: var(--text-muted); border: 1px solid var(--border); }
.znp-jobs .t-urgent  { background: #fff5ee; color: #c05500; border: 1px solid #f5cba7; } /* overrides master red */
.znp-jobs .t-fresh   { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; font-weight: 600; }
.znp-jobs .t-new     { background: var(--blue-light); color: var(--blue); border: 1px solid #c7d5f8; } /* overrides master green */

.znp-jobs .jc-apply {
    padding: 6px 16px;
    background: var(--blue);
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
}
.znp-jobs .jc-apply:hover { background: var(--blue-dark); }

/* ── JOBS LIST CONTAINER ── */
.znp-jobs .jobs-list { display: flex; flex-direction: column; gap: 10px; }

/* ── JOB CARD — remaining jobs-specific structural classes ── */
.znp-jobs .jc-company-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

.znp-jobs .jc-meta      { display: flex; gap: 8px; flex-wrap: wrap; }
.znp-jobs .jc-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    color: var(--text);
    padding: 5px 11px;
    background: #ffffff;
    border-radius: 20px;
    border: 1.5px solid #d1d5db;
    font-weight: 500;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
.znp-jobs .jc-meta-item svg { width: 13px; height: 13px; color: var(--text-light); flex-shrink: 0; }
.znp-jobs .jc-exp-lbl { font-size: 9px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.04em; }
.znp-jobs .jc-inr-icon { font-size: 12px; color: var(--text-light); flex-shrink: 0; font-weight: 600; }

.znp-jobs .jc-details { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-top: 4px; }
.znp-jobs .jc-cert {
    font-size: 10px; color: #059669; background: #ecfdf5; border: 1px solid #a7f3d0;
    padding: 3px 8px; border-radius: 100px; font-weight: 500;
    display: inline-flex; align-items: center; gap: 3px;
}
.znp-jobs .jc-headcount {
    font-size: 10px; color: #4b5563; background: #f9fafb; border: 1px solid #e5e7eb;
    padding: 3px 8px; border-radius: 100px; font-weight: 500;
}
.znp-jobs .jc-diversity {
    font-size: 10px; color: #7c3aed; background: #f5f3ff; border: 1px solid #ddd6fe;
    padding: 3px 8px; border-radius: 100px; font-weight: 500;
    display: inline-flex; align-items: center; gap: 3px;
}

.znp-jobs .jc-desc {
    font-size: 12px; color: var(--text-muted); line-height: 1.5;
    overflow: hidden; white-space: nowrap; text-overflow: ellipsis;
}

.znp-jobs .jc-skills { display: flex; gap: 5px; overflow: hidden; white-space: nowrap; }
.znp-jobs .jc-skill {
    font-size: 10px; color: #4b5563; padding: 3px 9px;
    border: 1.5px solid #d1d5db; border-radius: 20px; background: #f3f4f6;
    transition: all 0.15s; font-weight: 500; flex-shrink: 0;
}
.znp-jobs .jc-skill:hover { border-color: #9ca3af; background: #e5e7eb; }

.znp-jobs .jc-bottom { display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap; }

/* ── PAGINATION ── */
.znp-jobs .pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}
.znp-jobs .pg-btn {
    padding: 7px 16px;
    border: 1px solid var(--border);
    background: var(--white);
    color: var(--text-muted);
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;
}
.znp-jobs .pg-btn:hover:not(:disabled) { border-color: var(--blue); color: var(--blue); }
.znp-jobs .pg-btn:disabled             { opacity: 0.35; cursor: not-allowed; }
.znp-jobs .pg-num {
    width: 32px; height: 32px;
    border: 1px solid var(--border);
    background: var(--white);
    color: var(--text-muted);
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
}
.znp-jobs .pg-num:hover       { border-color: var(--blue); color: var(--blue); }
.znp-jobs .pg-num.active      { background: var(--blue); color: #fff; border-color: var(--blue); }
.znp-jobs .pg-ellipsis        { color: var(--text-light); font-size: 13px; padding: 0 4px; }

/* ── MOBILE ELEMENTS: hidden on desktop ── */
.znp-jobs .mob-filter-overlay { display: none; }
.znp-jobs .mob-filter-fab     { display: none; }
.znp-jobs .mob-filter-close   { display: none; }

/* ── RESPONSIVE ── */
@media (max-width: 768px) {

    /* Search Hero */
    .znp-jobs .search-hero { padding: 14px 16px 10px; }
    .znp-jobs .sh-inner    { max-width: 100%; }
    .znp-jobs .sh-title    { font-size: 14px; line-height: 1.4; margin-bottom: 12px; }
    .znp-jobs .search-bar  {
        flex-direction: column;
        border-radius: 10px;
        box-shadow: 0 1px 8px rgba(0,0,0,0.07);
    }
    .znp-jobs .sb-field    { border-right: none; border-bottom: 1px solid var(--border); width: 100%; padding: 10px 14px; }
    .znp-jobs .sb-field:last-of-type { border-bottom: none; }
    .znp-jobs .sb-btn      { width: 100%; justify-content: center; min-height: 44px; border-radius: 0 0 10px 10px; }
    .znp-jobs .sh-tags     { margin-top: 10px; }

    /* Page layout: single-column, extra bottom padding for FAB */
    .znp-jobs .page {
        grid-template-columns: 1fr;
        padding: 0 0 90px;
        gap: 0;
        max-width: 100%;
        width: 100%;
        overflow-x: hidden;
    }

    /* Filter sidebar → slide-in drawer from left */
    .znp-jobs .filter-sidebar {
        position: fixed;
        top: 0;
        left: -100%;
        width: 83%;
        max-width: 310px;
        height: 100vh;
        z-index: 1200;
        background: #fff;
        border-radius: 0 18px 18px 0;
        box-shadow: 6px 0 30px rgba(0,0,0,0.18);
        transition: left 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        overflow-y: auto;
        max-height: none;
        padding-bottom: 80px;
        border: none;
    }
    .znp-jobs .filter-sidebar.mob-open { left: 0; }

    /* Mobile overlay (dim background) */
    .znp-jobs .mob-filter-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.48);
        z-index: 1199;
    }
    .znp-jobs .mob-filter-overlay.active { display: block; }

    /* Close button inside drawer header */
    .znp-jobs .mob-filter-close {
        display: flex;
        align-items: center;
        justify-content: center;
        background: none;
        border: none;
        font-size: 22px;
        color: var(--text-muted);
        cursor: pointer;
        padding: 0 0 0 8px;
        line-height: 1;
        margin-left: 4px;
    }
    .znp-jobs .mob-filter-close:hover { color: var(--text); }

    /* Filters FAB — fixed pill at bottom-centre */
    .znp-jobs .mob-filter-fab {
        display: flex;
        align-items: center;
        gap: 7px;
        position: fixed;
        bottom: 22px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--blue);
        color: #fff;
        border: none;
        padding: 12px 28px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 4px 20px rgba(0, 86, 210, 0.42);
        z-index: 998;
        cursor: pointer;
        white-space: nowrap;
        letter-spacing: 0.2px;
    }
    .znp-jobs .mob-filter-count {
        background: var(--blue);
        color: #fff;
        border: none;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 700;
        padding: 1px 6px;
        min-width: 16px;
        text-align: center;
        display: none;
    }
    .znp-jobs .mob-filter-count.visible { display: inline-block; }

    /* Results area */
    .znp-jobs .results-area    { padding: 12px 14px 0; }
    .znp-jobs .results-topbar  { padding: 8px 0 6px; margin-bottom: 10px; align-items: center; gap: 8px; }
    .znp-jobs .results-count   { font-size: 12px; }
    .znp-jobs .sort-label      { display: none; }
    .znp-jobs .sort-current    { font-size: 12px; padding: 6px 10px; }
    /* Topbar filter button (mobile only) */
    .znp-jobs .mob-topbar-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border: 1.5px solid var(--blue);
        background: var(--blue-light);
        color: var(--blue);
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit !important;
        flex-shrink: 0;
        white-space: nowrap;
    }
    .znp-jobs .mob-topbar-filter-btn:active { background: #d6e4ff; }

    /* Active-filter chips: single-row horizontal scroll */
    .znp-jobs .active-filters {
        flex-wrap: nowrap;
        overflow-x: auto;
        padding: 4px 0 10px;
        margin-bottom: 8px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .znp-jobs .active-filters::-webkit-scrollbar { display: none; }
    .znp-jobs .af-chip { flex-shrink: 0; }

    /* Job cards */
    .znp-jobs .jobs-list       { gap: 9px; }
    .znp-jobs .job-card        { padding: 13px 12px; border-radius: 10px; gap: 5px; }
    .znp-jobs .jc-avatar       { width: 38px; height: 38px; font-size: 11px; flex-shrink: 0; }
    .znp-jobs .jc-title        { font-size: 13.5px; }
    .znp-jobs .jc-company-row  { gap: 5px; flex-wrap: wrap; }
    .znp-jobs .jc-company      { font-size: 11px; padding: 3px 8px; }
    .znp-jobs .jc-meta-item    { font-size: 11px; padding: 3px 8px; gap: 4px; max-width: 100%; }
    .znp-jobs .jc-meta-item svg { width: 11px; height: 11px; }
    .znp-jobs .jc-details      { display: flex; flex-wrap: wrap; gap: 4px; margin-top: 4px; }   /* show cert badges on mobile */
    .znp-jobs .jc-cert          { font-size: 9px; padding: 2px 6px; }
    .znp-jobs .jc-headcount     { font-size: 9px; padding: 2px 6px; }
    .znp-jobs .jc-diversity     { font-size: 9px; padding: 2px 6px; }
    .znp-jobs .jc-desc {
        font-size: 11.5px;
        line-height: 1.45;
        margin: 6px 0 5px;
        white-space: normal;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: unset;
    }
    .znp-jobs .jc-skills       { gap: 4px; flex-wrap: wrap; overflow: visible; white-space: normal; }
    .znp-jobs .jc-skill        { font-size: 10px; padding: 3px 8px; }
    .znp-jobs .jc-bottom       { margin-top: 7px; gap: 6px; flex-wrap: wrap; }
    .znp-jobs .jc-tags         { gap: 4px; flex-wrap: wrap; }
    .znp-jobs .tag             { font-size: 10px; padding: 3px 8px; }
    .znp-jobs .jc-apply        { padding: 7px 16px; font-size: 12px; flex-shrink: 0; }

    /* Pagination */
    .znp-jobs .pagination {
        gap: 3px;
        margin-top: 14px;
        padding-top: 14px;
        flex-wrap: nowrap;
        justify-content: center;
    }
    .znp-jobs .pg-btn        { padding: 6px 8px; font-size: 10.5px; white-space: nowrap; }
    .znp-jobs .pg-num        { width: 26px; height: 26px; font-size: 10.5px; }
    .znp-jobs .pg-ellipsis   { padding: 0 1px; font-size: 10.5px; }
    .znp-jobs .pg-mob-hide   { display: none !important; }
}

/* ── EXTRA SMALL (≤ 390px) ── */
@media (max-width: 390px) {
    .znp-jobs .search-hero { padding: 12px 12px 8px; }
    .znp-jobs .sh-title    { font-size: 13px; }
    .znp-jobs .results-area { padding: 10px 10px 0; }
    .znp-jobs .jc-bottom   { flex-direction: column; align-items: flex-start; gap: 8px; }
    .znp-jobs .jc-apply    { width: 100%; text-align: center; justify-content: center; }
    .znp-jobs .mob-filter-fab { display: none; }
}

/* ── AUTOCOMPLETE DROPDOWN ── */
.znp-jobs .ui-autocomplete {
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
.znp-jobs .ui-autocomplete .ui-menu-item {
    padding: 0;
    white-space: nowrap;
}
.znp-jobs .ui-autocomplete .ui-menu-item-wrapper {
    padding: 9px 16px;
    font-size: 13.5px;
    line-height: 1.35;
    font-family: 'Inter', sans-serif;
    color: var(--text);
    cursor: pointer;
}
.znp-jobs .ui-autocomplete .ui-menu-item-wrapper.ui-state-active,
.znp-jobs .ui-autocomplete .ui-menu-item-wrapper:hover {
    background: #eef2ff;
    color: var(--blue);
    border: none;
}
.znp-jobs .ui-autocomplete .highlight {
    font-weight: 700;
    color: var(--blue);
}
/* ── VIEW MORE BUTTON ── */
.znp-jobs .overflow-opt { display: none; }
.znp-jobs .view-more-btn {
    background: none; border: none; color: var(--blue);
    font-size: 12px; font-family: 'Inter', sans-serif;
    font-weight: 500; cursor: pointer;
    padding: 6px 0 2px; display: block;
}
.znp-jobs .view-more-btn:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
@include('znp.header')
<div class="znp-jobs">

    {{-- ── SEARCH HERO ── --}}
    <div class="search-hero">
        <div class="sh-inner">
            <div class="sh-title">Browse Immediate Joiner Jobs in India, <span>Apply Now!</span></div>
            <form method="GET" action="{{ route('jobs.page') }}" id="searchForm">
                <div class="search-bar">
                    <div class="sb-field">
                        <svg class="sb-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        <input type="text" id="skillInput" name="q" value="{{ rtrim(trim(request('q')), ',') }}" autocomplete="off" placeholder="Role, skill or keyword">
                    </div>
                    <div class="sb-field">
                        <svg class="sb-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <input type="text" id="cityInput" name="loc" value="{{ request('loc') }}" autocomplete="off" placeholder="City">
                    </div>
                    <button type="submit" class="sb-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        Search
                    </button>
                </div>
                {{-- Preserve all active sidebar filters when re-searching --}}
                @foreach(request()->except(['q', 'loc', 'page', 'company_type']) as $pKey => $pVal)
                    @foreach((array)$pVal as $pItem)
                        <input type="hidden" name="{{ $pKey }}{{ is_array($pVal) ? '[]' : '' }}" value="{{ $pItem }}">
                    @endforeach
                @endforeach
            </form>
            <div class="sh-tags">
                <div class="sh-tags-wrapper">
                    <span class="sh-tag-label">Popular:</span>
                    <div class="sh-tags-scroll" id="tagsScroll">
                        <span class="sh-tag {{ !request('tag') ? 'active' : '' }}"             data-tag=""                  onclick="setTag(this)">All Jobs</span>
                        <span class="sh-tag {{ request('tag')=='Bengaluru'        ? 'active':'' }}" data-tag="Bengaluru"        onclick="setTag(this)">Bengaluru</span>
                        <span class="sh-tag {{ request('tag')=='Mumbai'           ? 'active':'' }}" data-tag="Mumbai"           onclick="setTag(this)">Mumbai</span>
                        <span class="sh-tag {{ request('tag')=='Hyderabad'        ? 'active':'' }}" data-tag="Hyderabad"        onclick="setTag(this)">Hyderabad</span>
                        <span class="sh-tag {{ request('tag')=='Delhi NCR'        ? 'active':'' }}" data-tag="Delhi NCR"        onclick="setTag(this)">Delhi NCR</span>
                        <span class="sh-tag {{ request('tag')=='Pune'             ? 'active':'' }}" data-tag="Pune"             onclick="setTag(this)">Pune</span>
                        <span class="sh-tag {{ request('tag')=='Chennai'          ? 'active':'' }}" data-tag="Chennai"          onclick="setTag(this)">Chennai</span>
                        <span class="sh-tag {{ request('tag')=='Remote'           ? 'active':'' }}" data-tag="Remote"           onclick="setTag(this)">Remote</span>
                        <span class="sh-tag {{ request('tag')=='Hybrid'           ? 'active':'' }}" data-tag="Hybrid"           onclick="setTag(this)">Hybrid</span>
                        <span class="sh-tag {{ request('tag')=='Work From Office' ? 'active':'' }}" data-tag="Work From Office" onclick="setTag(this)">Work From Office</span>
                        <span class="sh-tag {{ request('tag')=='Contract'         ? 'active':'' }}" data-tag="Contract"         onclick="setTag(this)">Contract</span>
                        <span class="sh-tag {{ request('tag')=='Night Shift'      ? 'active':'' }}" data-tag="Night Shift"      onclick="setTag(this)">Night Shift</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── PAGE LAYOUT ── --}}
    <div class="page">

        {{-- ── MOBILE FILTER OVERLAY ── --}}
        <div class="mob-filter-overlay" id="mobFilterOverlay" onclick="closeMobFilter()"></div>

        {{-- ── FILTER SIDEBAR ── --}}
        <aside class="filter-sidebar">
            <div class="filter-header">
                <div class="filter-header-title">Filters</div>
                <span class="filter-clear-all" onclick="clearAllFilters()">Clear all</span>
                <button class="mob-filter-close" onclick="closeMobFilter()" aria-label="Close filters">&#x2715;</button>
            </div>

            <div class="filter-sections-container">

                {{-- Experience (static labels, dynamic counts from DB) --}}
                <div class="filter-section">
                    <div class="filter-section-header" onclick="toggleSection(this)">
                        <span class="fsh-title">Experience</span>
                        <span class="fsh-chevron">▴</span>
                    </div>
                    <div class="filter-section-body">
                        @php
                            $expItems = [
                                '0-3'   => '0-3 years',
                                '3-6'   => '3-6 years',
                                '6-10'  => '6-10 years',
                                '10-15' => '10-15 years',
                                '15-25' => '15-25 years',
                                '25+'   => '25+ years',
                            ];
                        @endphp
                        @foreach($expItems as $expVal => $expLabel)
                            @php $expActive = in_array($expVal, (array)request('exp', [])); @endphp
                            <div class="filter-option {{ $expActive ? 'checked' : '' }} {{ !$expActive && $loop->index >= 4 ? 'overflow-opt' : '' }}"
                                 data-overflow="{{ !$expActive && $loop->index >= 4 ? '1' : '0' }}"
                                 onclick="applyFilterEl(this)" data-param="exp" data-val="{{ $expVal }}">
                                <div class="fo-box">{{ $expActive ? '✓' : '' }}</div>
                                <span class="fo-label">{{ $expLabel }}</span>
                                <span class="fo-count">{{ $expCounts[$expVal] ?? 0 }}</span>
                            </div>
                        @endforeach
                        <button class="view-more-btn" onclick="viewMore(this)">+ 2 more</button>
                    </div>
                </div>

                {{-- Salary (static labels, dynamic counts from DB) --}}
                <div class="filter-section">
                    <div class="filter-section-header" onclick="toggleSection(this)">
                        <span class="fsh-title">Salary</span>
                        <span class="fsh-chevron">▴</span>
                    </div>
                    <div class="filter-section-body">
                        @php
                            $salItems = [
                                '0-3'     => '₹0-3 Lakhs',
                                '3-6'     => '₹3-6 Lakhs',
                                '6-10'    => '₹6-10 Lakhs',
                                '10-15'   => '₹10-15 Lakhs',
                                '15-25'   => '₹15-25 Lakhs',
                                '25-50'   => '₹25-50 Lakhs',
                                '50-75'   => '₹50-75 Lakhs',
                                '75-100'  => '₹75 Lakhs - ₹1 Cr',
                                '100-500' => '₹1-5 Cr',
                                '500+'    => '₹5+ Cr',
                            ];
                        @endphp
                        @foreach($salItems as $salVal => $salLabel)
                            @php $salActive = in_array($salVal, (array)request('sal', [])); @endphp
                            <div class="filter-option {{ $salActive ? 'checked' : '' }} {{ !$salActive && $loop->index >= 4 ? 'overflow-opt' : '' }}"
                                 data-overflow="{{ !$salActive && $loop->index >= 4 ? '1' : '0' }}"
                                 onclick="applyFilterEl(this)" data-param="sal" data-val="{{ $salVal }}">
                                <div class="fo-box">{{ $salActive ? '✓' : '' }}</div>
                                <span class="fo-label">{{ $salLabel }}</span>
                                <span class="fo-count">{{ $salaryCounts[$salVal] ?? 0 }}</span>
                            </div>
                        @endforeach
                        <button class="view-more-btn" onclick="viewMore(this)">+ 6 more</button>
                    </div>
                </div>

                {{-- Location (dynamic from DB, serialized field) --}}
                <div class="filter-section">
                    <div class="filter-section-header" onclick="toggleSection(this)">
                        <span class="fsh-title">Location</span>
                        <span class="fsh-chevron">▴</span>
                    </div>
                    <div class="filter-section-body">
                        <div class="filter-location-grid">
                            @foreach($locationCounts as $locVal => $locCount)
                                @php $locActive = in_array($locVal, (array)request('location', [])); @endphp
                                <div class="filter-option {{ $locActive ? 'checked' : '' }}"
                                     onclick="applyFilterEl(this)" data-param="location" data-val="{{ $locVal }}">
                                    <div class="fo-box">{{ $locActive ? '✓' : '' }}</div>
                                    <span class="fo-label">{{ $locVal }}</span>
                                    <span class="fo-count">{{ $locCount }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Work Mode (static labels, dynamic counts from DB) --}}
                <div class="filter-section">
                    <div class="filter-section-header" onclick="toggleSection(this)">
                        <span class="fsh-title">Work Mode</span>
                        <span class="fsh-chevron">▴</span>
                    </div>
                    <div class="filter-section-body">
                        @php
                            $modeItems = [
                                'Remote'           => 'Remote / WFH',
                                'Hybrid'           => 'Hybrid',
                                'Work From Office' => 'Work From Office',
                                'Temp WFH'         => 'Temp WFH',
                            ];
                        @endphp
                        @foreach($modeItems as $modeVal => $modeLabel)
                            @php $modeActive = in_array($modeVal, (array)request('mode', [])); @endphp
                            <div class="filter-option {{ $modeActive ? 'checked' : '' }}"
                                 onclick="applyFilterEl(this)" data-param="mode" data-val="{{ $modeVal }}">
                                <div class="fo-box">{{ $modeActive ? '✓' : '' }}</div>
                                <span class="fo-label">{{ $modeLabel }}</span>
                                <span class="fo-count">{{ $workModeCounts[$modeVal] ?? 0 }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Work Shifts (static labels, dynamic counts from DB) --}}
                <div class="filter-section">
                    <div class="filter-section-header" onclick="toggleSection(this)">
                        <span class="fsh-title">Work Shifts</span>
                        <span class="fsh-chevron">▴</span>
                    </div>
                    <div class="filter-section-body">
                        @php
                            $shiftItems = [
                                'Day Shift'        => 'Day Shift (8 AM +)',
                                'Night Shift'      => 'Night Shift (8 PM +)',
                                'Rotational Shift' => 'Rotational Shift',
                                'US Shift'         => 'US Shift (6 PM +)',
                                'UK Shift'         => 'UK Shift (1:30 PM +)',
                                'APAC Shift'       => 'APAC Shift (6 AM +)',
                                '6 days'           => '6 days/week',
                            ];
                        @endphp
                        @foreach($shiftItems as $shiftVal => $shiftLabel)
                            @php $shiftActive = in_array($shiftVal, (array)request('shift', [])); @endphp
                            <div class="filter-option {{ $shiftActive ? 'checked' : '' }} {{ !$shiftActive && $loop->index >= 4 ? 'overflow-opt' : '' }}"
                                 data-overflow="{{ !$shiftActive && $loop->index >= 4 ? '1' : '0' }}"
                                 onclick="applyFilterEl(this)" data-param="shift" data-val="{{ $shiftVal }}">
                                <div class="fo-box">{{ $shiftActive ? '✓' : '' }}</div>
                                <span class="fo-label">{{ $shiftLabel }}</span>
                                <span class="fo-count">{{ $shiftCounts[$shiftVal] ?? 0 }}</span>
                            </div>
                        @endforeach
                        <button class="view-more-btn" onclick="viewMore(this)">+ 3 more</button>
                    </div>
                </div>

                {{-- Job Type (static labels, dynamic counts from DB) --}}
                <div class="filter-section">
                    <div class="filter-section-header" onclick="toggleSection(this)">
                        <span class="fsh-title">Job Type</span>
                        <span class="fsh-chevron">▴</span>
                    </div>
                    <div class="filter-section-body">
                        @php
                            $typeItems = [
                                'Permanent'        => 'Permanent',
                                'Contract'         => 'Contract',
                                'Contract to Hire' => 'Contract to Hire',
                                'Freelance'        => 'Freelance',
                                'Fresher'          => 'Fresher',
                                'Internship'       => 'Internship',
                            ];
                        @endphp
                        @foreach($typeItems as $typeVal => $typeLabel)
                            @php $typeActive = in_array($typeVal, (array)request('type', [])); @endphp
                            <div class="filter-option {{ $typeActive ? 'checked' : '' }} {{ !$typeActive && $loop->index >= 4 ? 'overflow-opt' : '' }}"
                                 data-overflow="{{ !$typeActive && $loop->index >= 4 ? '1' : '0' }}"
                                 onclick="applyFilterEl(this)" data-param="type" data-val="{{ $typeVal }}">
                                <div class="fo-box">{{ $typeActive ? '✓' : '' }}</div>
                                <span class="fo-label">{{ $typeLabel }}</span>
                                <span class="fo-count">{{ $jobTypeCounts[$typeVal] ?? 0 }}</span>
                            </div>
                        @endforeach
                        <button class="view-more-btn" onclick="viewMore(this)">+ 2 more</button>
                    </div>
                </div>

                {{-- Education (static labels, clickable) --}}
                <div class="filter-section">
                    <div class="filter-section-header" onclick="toggleSection(this)">
                        <span class="fsh-title">Education</span>
                        <span class="fsh-chevron">▴</span>
                    </div>
                    <div class="filter-section-body">
                        <input class="filter-search" type="text" placeholder="Search education..." oninput="filterOptions(this)">
                        @php
                            $eduItems = ['Any Postgraduate','B.Tech / B.E.','Any Graduate','M.Tech','MCA','MS / M.Sc','BCA','MBA / PGDM','B.Sc.','B.Com','M.Com','B.B.A / B.M.S','Diploma','PG Diploma','LLM','CA','B.A','BS','ITI Certification','Master in IT Mgmt','No Graduation Reqd'];
                        @endphp
                        <div class="filter-location-grid">
                        @foreach($eduItems as $eduVal)
                            @php $eduActive = in_array($eduVal, (array)request('edu', [])); @endphp
                            <div class="filter-option {{ $eduActive ? 'checked' : '' }} {{ !$eduActive && $loop->index >= 4 ? 'overflow-opt' : '' }}"
                                 data-overflow="{{ !$eduActive && $loop->index >= 4 ? '1' : '0' }}"
                                 onclick="applyFilterEl(this)" data-param="edu" data-val="{{ $eduVal }}">
                                <div class="fo-box">{{ $eduActive ? '✓' : '' }}</div>
                                <span class="fo-label">{{ $eduVal }}</span>
                                <span class="fo-count">{{ $eduCounts[$eduVal] ?? 0 }}</span>
                            </div>
                        @endforeach
                        </div>
                        <button class="view-more-btn" onclick="viewMore(this)">+ 17 more</button>
                    </div>
                </div>

                {{-- Posted By (static labels, clickable) --}}
                <div class="filter-section">
                    <div class="filter-section-header" onclick="toggleSection(this)">
                        <span class="fsh-title">Posted by</span>
                        <span class="fsh-chevron">▴</span>
                    </div>
                    <div class="filter-section-body">
                        @foreach(['Direct Employer','Recruitment Agency'] as $pbVal)
                            @php $pbActive = in_array($pbVal, (array)request('posted_by', [])); @endphp
                            <div class="filter-option {{ $pbActive ? 'checked' : '' }}"
                                 onclick="applyFilterEl(this)" data-param="posted_by" data-val="{{ $pbVal }}">
                                <div class="fo-box">{{ $pbActive ? '✓' : '' }}</div>
                                <span class="fo-label">{{ $pbVal }}</span>
                                <span class="fo-count">{{ $postedByCounts[$pbVal] ?? 0 }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

           

                {{-- Freshness (static date ranges) --}}
                <div class="filter-section">
                    <div class="filter-section-header" onclick="toggleSection(this)">
                        <span class="fsh-title">Freshness</span>
                        <span class="fsh-chevron">▴</span>
                    </div>
                    <div class="filter-section-body">
                        @php
                            $freshnessOpts = [
                                'today'  => 'Today',
                                '3days'  => 'Last 3 days',
                                'week'   => 'Last 7 days',
                                '2weeks' => 'Last 15 days',
                                'month'  => 'Last 30 days',
                            ];
                        @endphp
                        @foreach($freshnessOpts as $dateVal => $dateLabel)
                            @php $dateActive = request('date') === $dateVal; @endphp
                            <div class="filter-option {{ $dateActive ? 'checked' : '' }}"
                                 onclick="setSingleFilterEl(this)" data-param="date" data-val="{{ $dateVal }}">
                                <div class="fo-box">{{ $dateActive ? '✓' : '' }}</div>
                                <span class="fo-label">{{ $dateLabel }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>{{-- end filter-sections-container --}}
        </aside>

        {{-- ── RESULTS AREA ── --}}
        <div class="results-area">
            <div class="results-topbar">
                <div class="rt-left">
                    <button class="mob-topbar-filter-btn" onclick="openMobFilter()" type="button">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="16" y2="12"/><line x1="4" y1="18" x2="12" y2="18"/></svg>
                        Filters
                        <span class="mob-filter-count" id="mobFilterCount"></span>
                    </button>
                    <div class="results-count"><strong>{{ number_format($jobs->total()) }}</strong> jobs found</div>
                </div>
                <div class="sort-bar">
                    <span class="sort-label">Sort by:</span>
                    <div class="sort-dropdown" id="sortDropdown">
                        @php $currentSort = request('sort', 'relevance'); @endphp
                        <button class="sort-current" onclick="toggleSortDropdown(event)" type="button">
                            @if($currentSort === 'salary_high')Salary: High to Low
                            @elseif($currentSort === 'latest')Date Posted
                            @else Relevance
                            @endif
                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="sort-options" id="sortOptions">
                            <div class="sort-option {{ $currentSort === 'relevance' ? 'active' : '' }}" onclick="applySort('relevance')">Relevance</div>
                            <div class="sort-option {{ $currentSort === 'latest' ? 'active' : '' }}" onclick="applySort('latest')">Date Posted</div>
                            <div class="sort-option {{ $currentSort === 'salary_high' ? 'active' : '' }}" onclick="applySort('salary_high')">Salary (High to Low)</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── ACTIVE FILTER CHIPS ── --}}
            @if(request()->hasAny(['q','loc','tag','mode','type','shift','exp','location','sal','date','edu','posted_by','lang']))
            <div class="active-filters">
                @if(request('q'))
                    <div class="af-chip">{{ rtrim(trim(request('q')), ',') }}
                        <span class="af-x" onclick="removeSingleFilter('q')">×</span>
                    </div>
                @endif
                @if(request('loc'))
                    <div class="af-chip">{{ request('loc') }}
                        <span class="af-x" onclick="removeSingleFilter('loc')">×</span>
                    </div>
                @endif
                @if(request('tag'))
                    <div class="af-chip">{{ request('tag') }}
                        <span class="af-x" onclick="removeSingleFilter('tag')">×</span>
                    </div>
                @endif
                @foreach((array)request('mode',[]) as $chip)
                    <div class="af-chip">{{ $chip }}
                        <span class="af-x" data-param="mode" data-val="{{ $chip }}" onclick="applyFilterEl(this)">×</span>
                    </div>
                @endforeach
                @foreach((array)request('type',[]) as $chip)
                    <div class="af-chip">{{ $chip }}
                        <span class="af-x" data-param="type" data-val="{{ $chip }}" onclick="applyFilterEl(this)">×</span>
                    </div>
                @endforeach
                @foreach((array)request('shift',[]) as $chip)
                    <div class="af-chip">{{ $chip }}
                        <span class="af-x" data-param="shift" data-val="{{ $chip }}" onclick="applyFilterEl(this)">×</span>
                    </div>
                @endforeach
                @foreach((array)request('exp',[]) as $chip)
                    @php
                        $expLabelMap = ['0-3'=>'0-3 years','3-6'=>'3-6 years','6-10'=>'6-10 years','10-15'=>'10-15 years','15-25'=>'15-25 years','25+'=>'25+ years'];
                    @endphp
                    <div class="af-chip">{{ $expLabelMap[$chip] ?? $chip }}
                        <span class="af-x" data-param="exp" data-val="{{ $chip }}" onclick="applyFilterEl(this)">×</span>
                    </div>
                @endforeach
                @foreach((array)request('location',[]) as $chip)
                    <div class="af-chip">{{ $chip }}
                        <span class="af-x" data-param="location" data-val="{{ $chip }}" onclick="applyFilterEl(this)">×</span>
                    </div>
                @endforeach
                @foreach((array)request('sal',[]) as $chip)
                    @php $salLabels = ['0-3'=>'₹0-3 Lakhs','3-6'=>'₹3-6 Lakhs','6-10'=>'₹6-10 Lakhs','10-15'=>'₹10-15 Lakhs','15-25'=>'₹15-25 Lakhs','25-50'=>'₹25-50 Lakhs','50-75'=>'₹50-75 Lakhs','75-100'=>'₹75 Lakhs - ₹1 Cr','100-500'=>'₹1-5 Cr','500+'=>'₹5+ Cr']; @endphp
                    <div class="af-chip">{{ $salLabels[$chip] ?? $chip }}
                        <span class="af-x" data-param="sal" data-val="{{ $chip }}" onclick="applyFilterEl(this)">×</span>
                    </div>
                @endforeach
                @foreach((array)request('edu',[]) as $chip)
                    <div class="af-chip">{{ $chip }}
                        <span class="af-x" data-param="edu" data-val="{{ $chip }}" onclick="applyFilterEl(this)">×</span>
                    </div>
                @endforeach
                @foreach((array)request('posted_by',[]) as $chip)
                    <div class="af-chip">{{ $chip }}
                        <span class="af-x" data-param="posted_by" data-val="{{ $chip }}" onclick="applyFilterEl(this)">×</span>
                    </div>
                @endforeach
                @foreach((array)request('lang',[]) as $chip)
                    <div class="af-chip">{{ $chip }}
                        <span class="af-x" data-param="lang" data-val="{{ $chip }}" onclick="applyFilterEl(this)">×</span>
                    </div>
                @endforeach
                @if(request('date'))
                    @php $dateLabels = ['today'=>'Today','3days'=>'Last 3 days','week'=>'Last 7 days','2weeks'=>'Last 15 days','month'=>'Last 30 days']; @endphp
                    <div class="af-chip">{{ $dateLabels[request('date')] ?? request('date') }}
                        <span class="af-x" onclick="removeSingleFilter('date')">×</span>
                    </div>
                @endif
            </div>
            @endif

            {{-- ── JOBS LIST ── --}}
            <div class="jobs-list">

    @forelse($jobs as $job)
                @php
                    $companyName  = $job->company ? ($job->company->name ?? '') : '';
                    $avatarText   = strtoupper(mb_substr(preg_replace('/\s+/', '', $companyName), 0, 2)) ?: 'CO';
                    $locArr       = @unserialize($job->location);
                    $locationStr  = is_array($locArr) ? implode(', ', array_slice($locArr, 0, 2)) : '';
                    $salaryStr    = ($job->min_salary && $job->max_salary)
                                    ? $job->min_salary.'-'.$job->max_salary.' LPA'
                                    : ($job->min_salary ? $job->min_salary.'+ LPA' : '');
                    $description  = mb_substr(trim(html_entity_decode(strip_tags($job->job_overview ?: ''), ENT_QUOTES | ENT_HTML5)), 0, 160);
                    $ageInDays    = $job->created_at ? $job->created_at->diffInDays(now()) : 999;
                    $isNew        = $ageInDays <= 1;
                    $isFresh      = !$isNew && $ageInDays <= 3;
                    // Dynamic company badges
                    $co = $job->company;
                    $hcMap = ['1-10'=>'1-10 Employees','11-50'=>'11-50 Employees','51-200'=>'51-200 Employees',
                              '201-500'=>'201-500 Employees','501-1000'=>'501-1K Employees','1001-5000'=>'1K-5K Employees',
                              '5001-10000'=>'5K-10K Employees','10001-25000'=>'10K-25K Employees',
                              '25001-50000'=>'25K-50K Employees','50001-75000'=>'50K-75K Employees',
                              '75001-100000'=>'75K-1L Employees','100000+'=>'1L+ Employees'];
                    $hasGptw         = $co && $co->is_gptw_certified;
                    $hasTopEmp       = $co && $co->is_top_employer;
                    $hasDisability   = $co && $co->is_disability_hiring;
                    $hasWomen        = $co && $co->is_women_friendly;
                    $hasAnyBadge     = $hasGptw || $hasTopEmp || $hasDisability || $hasWomen;
                @endphp
                <a href="{{ route('job.detail.znp', $job->slug) }}" class="job-card" target="_blank">
                    <div class="jc-top">
                        <div class="jc-avatar">{{ $avatarText }}</div>
                        <div class="jc-info">
                            <div class="jc-title">{{ $job->job_title }}</div>
                            <div class="jc-company-row">
                                @if($companyName)
                                    <span class="jc-company">{{ $companyName }}</span>
                                @endif
                                @if($job->experience)
                                    <span class="jc-meta-item" title="Experience required for this role">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                        <span class="jc-exp-lbl">Exp. required:</span> {{ $job->experience }}
                                    </span>
                                @endif
                                @if($salaryStr)
                                    <span class="jc-meta-item">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="6" y1="4" x2="18" y2="4"/><line x1="6" y1="9" x2="18" y2="9"/><path d="M6 14h4a4 4 0 0 0 0-5H6"/><path d="M6 20l8-6"/></svg>
                                        {{ $salaryStr }}
                                    </span>
                                @endif
                                @if($locationStr)
                                    <span class="jc-meta-item">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                        {{ $locationStr }}
                                    </span>
                                @endif
                            </div>
                            {{-- jc-details: dynamic from company badges --}}
                            @if($hasAnyBadge)
                            <div class="jc-details">
                                @if($hasGptw)<span class="jc-cert">GPTW Certified</span>@endif
                                @if($hasTopEmp)<span class="jc-cert">Top Employer</span>@endif
                                @if($hasDisability)<span class="jc-diversity">Disability Hiring</span>@endif
                                @if($hasWomen)<span class="jc-diversity">Women Friendly</span>@endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @if($description)
                        <div class="jc-desc">{{ $description }}</div>
                    @endif
                    @if($job->jobSkills->count())
                        <div class="jc-skills">
                            @foreach($job->jobSkills->take(6) as $sm)
                                @php $sname = $sm->getJobSkill('job_skill'); @endphp
                                @if($sname)<span class="jc-skill">{{ $sname }}</span>@endif
                            @endforeach
                        </div>
                    @endif
                    <div class="jc-bottom">
                        <div class="jc-tags">
                            @if($job->work_mode)<span class="tag t-mode">{{ $job->work_mode }}</span>@endif
                            @if($job->job_shift)<span class="tag t-shift">{{ $job->job_shift }}</span>@endif
                            @if($job->job_type)<span class="tag t-type">{{ $job->job_type }}</span>@endif
                            @if($isNew)<span class="tag t-new">New</span>@elseif($isFresh)<span class="tag t-fresh">Fresh Job</span>@endif
                        </div>
                        <button class="jc-apply" onclick="window.open('{{ route('job.detail.znp', $job->slug) }}', '_blank'); event.stopPropagation();">Apply</button>
                    </div>
                </a>
                @empty
                <div style="text-align:center; padding:40px 20px; color:var(--text-muted);">
                    <p style="font-size:14px; margin-bottom:10px;">No jobs found matching your criteria.</p>
                    <a href="{{ route('jobs.page') }}" style="color:var(--blue); font-size:12px; font-weight:600;">Clear all filters</a>
                </div>
                @endforelse

            </div>{{-- end jobs-list --}}

            {{-- ── PAGINATION ── --}}
            @if($jobs->hasPages())
            @php
                $curPage  = $jobs->currentPage();
                $lastPage = $jobs->lastPage();
                $pgStart  = max(1, $curPage - 2);
                $pgEnd    = min($lastPage, $curPage + 2);
            @endphp
            <div class="pagination">
                <button class="pg-btn" {{ $jobs->onFirstPage() ? 'disabled' : '' }}
                        @if($jobs->previousPageUrl()) onclick="window.location.href='{{ $jobs->previousPageUrl() }}'" @endif>
                    <span>Previous</span>
                </button>

                @if($pgStart > 1)
                    <div class="pg-num pg-mob-hide" onclick="window.location.href='{{ $jobs->url(1) }}'">1</div>
                    @if($pgStart > 2)<span class="pg-ellipsis pg-mob-hide">...</span>@endif
                @endif

                @for($p = $pgStart; $p <= $pgEnd; $p++)
                    <div class="pg-num {{ $p == $curPage ? 'active' : '' }} {{ abs($p - $curPage) > 1 ? 'pg-mob-hide' : '' }}"
                         onclick="window.location.href='{{ $jobs->url($p) }}'">{{ $p }}</div>
                @endfor

                @if($pgEnd < $lastPage)
                    @if($pgEnd < $lastPage - 1)<span class="pg-ellipsis pg-mob-hide">...</span>@endif
                    <div class="pg-num pg-mob-hide" onclick="window.location.href='{{ $jobs->url($lastPage) }}'">{{ $lastPage }}</div>
                @endif

                <button class="pg-btn" {{ !$jobs->hasMorePages() ? 'disabled' : '' }}
                        @if($jobs->nextPageUrl()) onclick="window.location.href='{{ $jobs->nextPageUrl() }}'" @endif>
                    <span>Next</span>
                </button>
            </div>
            @endif

        </div>{{-- end results-area --}}

    </div>{{-- end page --}}

</div>{{-- end znp-jobs --}}
@include('znp.footer')
@endsection

@push('scripts')
<script>
// ── URL manipulation helpers ────────────────────────────────────────

/** Multi-select toggle: add if absent, remove if present.
 * Uses param[] (e.g. mode[]) so PHP parses as array. */
function applyFilter(param, value) {
    var url = new URL(window.location.href);
    var keyBr = param + '[]';
    // Read both possible key formats (param and param[]), merge and dedupe
    var current = url.searchParams.getAll(keyBr).concat(url.searchParams.getAll(param));
    current = current.filter(function(v, i) { return current.indexOf(v) === i; });
    var idx = current.indexOf(String(value));
    if (idx > -1) { current.splice(idx, 1); }
    else { current.push(String(value)); }
    // Remove any existing keys then write back using the bracketed form
    url.searchParams.delete(keyBr);
    url.searchParams.delete(param);
    current.forEach(function(v) { url.searchParams.append(keyBr, v); });
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

/** Call applyFilter using data attributes on the clicked element */
function applyFilterEl(el) {
    applyFilter(el.dataset.param, el.dataset.val);
}

/** Single-select toggle (salary, date): set or clear */
function setSingleFilter(param, value) {
    var url = new URL(window.location.href);
    if (url.searchParams.get(param) === String(value)) {
        url.searchParams.delete(param);
    } else {
        url.searchParams.set(param, value);
    }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

/** Call setSingleFilter using data attributes */
function setSingleFilterEl(el) {
    setSingleFilter(el.dataset.param, el.dataset.val);
}

/** Remove a single (non-array) filter param entirely */
function removeSingleFilter(param) {
    var url = new URL(window.location.href);
    url.searchParams.delete(param);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

/** Popular tag: set tag param and reload */
function setTag(el) {
    var val = el.dataset.tag;
    var url = new URL(window.location.href);
    if (val) { url.searchParams.set('tag', val); }
    else     { url.searchParams.delete('tag'); }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

/** Sort dropdown: toggle custom dropdown open/close */
function toggleSortDropdown(e) {
    e.stopPropagation();
    var dd = document.getElementById('sortDropdown');
    dd.classList.toggle('open');
}

/** Sort dropdown change */
function applySort(val) {
    document.getElementById('sortDropdown').classList.remove('open');
    var url = new URL(window.location.href);
    url.searchParams.set('sort', val);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

/** Reset all filters */
function clearAllFilters() {
    window.location.href = '{{ route('jobs.page') }}';
}

// ── Mobile filter drawer ──────────────────────────────────────────
function openMobFilter() {
    document.querySelector('.filter-sidebar').classList.add('mob-open');
    document.getElementById('mobFilterOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeMobFilter() {
    document.querySelector('.filter-sidebar').classList.remove('mob-open');
    document.getElementById('mobFilterOverlay').classList.remove('active');
    document.body.style.overflow = '';
}

// ── Filter section expand/collapse ─────────────────────────────────
function toggleSection(el) {
    var body = el.nextElementSibling;
    var chev = el.querySelector('.fsh-chevron');
    var open = body.style.display === 'none';
    body.style.display = open ? 'block' : 'none';
    chev.classList.toggle('open', open);
}

// ── Reveal overflow items in a filter section ────────────────────
function viewMore(btn) {
    btn.closest('.filter-section-body').querySelectorAll('.overflow-opt').forEach(function(el) {
        el.classList.remove('overflow-opt');
    });
    btn.style.display = 'none';
}

// ── In-sidebar text search (hides non-matching options) ────────────
function filterOptions(input) {
    var term = input.value.toLowerCase().trim();
    var body = input.parentElement;
    body.querySelectorAll('.filter-option').forEach(function(opt) {
        var label = opt.querySelector('.fo-label').textContent.toLowerCase();
        var matches = term === '' || label.includes(term);
        if (term !== '' && matches) {
            opt.style.display = 'flex'; // override overflow-opt display:none
        } else if (term === '') {
            // Restore original overflow state
            opt.style.display = opt.dataset.overflow === '1' ? 'none' : '';
        } else {
            opt.style.display = 'none';
        }
    });
}

// ── Autocomplete: Role/skill input (same as home page) ──────────────
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
            appendTo: '.znp-jobs',
            source: function(request, response) {
                $.ajax({
                    url: '{{ url("autocomplete/skillsposition") }}',
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
            open: function() {
                var term = extractLast(this.value);
                var ac = $(this).data('ui-autocomplete');
                ac.menu.element.find('li').each(function() {
                    var item = $(this).data('ui-autocomplete-item');
                    if (item) {
                        var hl = item.label.replace(
                            new RegExp($.ui.autocomplete.escapeRegex(term), 'gi'),
                            '<span class="highlight">$&</span>'
                        );
                        $(this).find('.ui-menu-item-wrapper').html(hl);
                    }
                });
            },
            select: function(event, ui) {
                var terms = split(this.value);
                terms.pop();
                terms.push(ui.item.value);
                terms.push('');
                this.value = terms.join(', ');
                return false;
            }
        });

    // ── Autocomplete: City input (same as home page) ─────────────────
    $('#cityInput')
        .on('keydown', function(e) {
            if (e.keyCode === $.ui.keyCode.TAB && $(this).autocomplete('instance').menu.active) {
                e.preventDefault();
            }
        })
        .autocomplete({
            minLength: 1,
            appendTo: '.znp-jobs',
            source: function(request, response) {
                $.ajax({
                    url: '{{ url("autocomplete/search-location-job1") }}',
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
            open: function() {
                var term = this.value;
                var ac = $(this).data('ui-autocomplete');
                ac.menu.element.find('li').each(function() {
                    var item = $(this).data('ui-autocomplete-item');
                    if (item) {
                        var hl = item.label.replace(
                            new RegExp($.ui.autocomplete.escapeRegex(term), 'gi'),
                            '<span class="highlight">$&</span>'
                        );
                        $(this).find('.ui-menu-item-wrapper').html(hl);
                    }
                });
            },
            select: function(event, ui) {
                this.value = ui.item.value;
                return false;
            }
        });

    // Enter key on either input submits form (unless navigating suggestions)
    $('#skillInput, #cityInput').on('keydown', function(e) {
        if (e.key === 'Enter') {
            var instance = $(this).autocomplete('instance');
            if (instance && instance.menu && instance.menu.active) { return; }
            e.preventDefault();
            $('.ui-autocomplete').hide();
            $('#searchForm').submit();
        }
    });

    // ── Close sort dropdown when clicking outside ─────────────────
    $(document).on('click', function(e) {
        var dd = document.getElementById('sortDropdown');
        if (dd && !dd.contains(e.target)) {
            dd.classList.remove('open');
        }
    });

    // ── Mobile: update FAB filter-count badge ──────────────────────
    (function() {
        var drawerParams = ['mode', 'type', 'shift', 'exp', 'location', 'sal'];
        var count = 0;
        var url = new URL(window.location.href);
        drawerParams.forEach(function(p) {
            count += url.searchParams.getAll(p + '[]').length;
        });
        if (url.searchParams.get('date')) count++;
        if (count > 0) {
            var badge = document.getElementById('mobFilterCount');
            if (badge) { badge.textContent = count; badge.classList.add('visible'); }
        }
    })();
});
</script>
@endpush
