@extends('layouts.znp')

@push('styles')
<style>
/* ─── scope ─────────────────────────────────────────── */
.znp-job-detail {
    background: var(--bg);
    color: var(--text);
    font-size: 13px;
    padding-bottom: 56px;
}

/* ─── page wrapper ───────────────────────────────────── */
.znp-job-detail .jd-pg {
    max-width: 980px;
    margin: 0px auto 0;
    padding: 22px 18px;
}

/* ─── job header ─────────────────────────────────────── */
.znp-job-detail .jh {
    background: var(--white);
    border: 0.5px solid #d1dae8;
    border-radius: 12px;
    overflow: hidden;
}
.znp-job-detail .jh-bar {
    background: #93c5fd;
    height: 6px;
}
.znp-job-detail .jh-body {
    padding: 22px 26px 18px;
}
.znp-job-detail .jh-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 14px;
}
.znp-job-detail .jtitle {
    font-size: 19px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 8px;
    letter-spacing: -.2px;
}
.znp-job-detail .pbadge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #eff6ff;
    border: 0.5px solid #bfdbfe;
    border-radius: 20px;
    padding: 4px 13px;
    font-size: 11px;
    color: #1e40af;
    font-weight: 600;
}
.znp-job-detail .pdot {
    width: 6px;
    height: 6px;
    background: #3b82f6;
    border-radius: 50%;
    display: inline-block;
}
.znp-job-detail .znpbadge {
    width: 56px;
    height: 56px;
    background: var(--blue);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    font-weight: 800;
    color: var(--white);
    text-align: center;
    line-height: 1.45;
    flex-shrink: 0;
}

/* ─── summary pills ──────────────────────────────────── */
.znp-job-detail .sum-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 7px;
    margin: 0 0 12px;
}
.znp-job-detail .sg-pill {
    display: inline-flex;
    align-items: center;
    font-size: 11.5px;
    font-weight: 500;
    color: #334155;
    background: #f1f5f9;
    border: 0.5px solid #cbd5e1;
    border-radius: 20px;
    padding: 4px 12px;
    white-space: nowrap;
}

/* ─── cert badges ────────────────────────────────────── */
.znp-job-detail .cert-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    padding: 8px 0;
    border-top: 0.5px solid #e8eef5;
    border-bottom: 0.5px solid #e8eef5;
    margin-bottom: 12px;
}
.znp-job-detail .ctag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
}
.znp-job-detail .ctag svg {
    width: 12px;
    height: 12px;
    fill: none;
    flex-shrink: 0;
}
.znp-job-detail .cg { border: 1.5px solid #0ea5e9; color: #0369a1; background: #f0f9ff; }
.znp-job-detail .ce { border: 1.5px solid #14b8a6; color: #0f766e; background: #f0fdfa; }
.znp-job-detail .cs { border: 1px solid #94a3b8;   color: #475569; background: #f8fafc; }
.znp-job-detail .cd { border: 1.5px solid #a855f7; color: #7e22ce; background: #faf5ff; }
.znp-job-detail .cw { border: 1.5px solid #ec4899; color: #be185d; background: #fdf2f8; }

/* ─── actions row ────────────────────────────────────── */
.znp-job-detail .jact {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.znp-job-detail .jinfo {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 500;
}
.znp-job-detail .abtns {
    display: flex;
    gap: 10px;
}
.znp-job-detail .bsave {
    border: 1.5px solid #cbd5e1;
    background: var(--white);
    color: #334155;
    padding: 7px 18px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}
.znp-job-detail .bapp {
    background: var(--orange);
    color: var(--white);
    border: none;
    padding: 7px 20px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}
.znp-job-detail .bapp:hover { background: var(--orange-dark); color: var(--white); text-decoration: none; }
.znp-job-detail .bsave:hover { background: #f8fafc; color: #0f172a; text-decoration: none; }

/* ─── grid layout ────────────────────────────────────── */
.znp-job-detail .jd-grid {
    display: grid;
    grid-template-columns: 1fr 284px;
    gap: 16px;
    align-items: start;
    margin-top: 16px;
}
.znp-job-detail .lc,
.znp-job-detail .rc {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

/* ─── cards ──────────────────────────────────────────── */
.znp-job-detail .card {
    background: var(--white);
    border: 0.5px solid #d1dae8;
    border-radius: 12px;
    padding: 20px 24px;
}
.znp-job-detail .ct {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 13px;
}

/* ─── highlights ─────────────────────────────────────── */
.znp-job-detail .hl {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 0;
    margin: 0;
}
.znp-job-detail .hl li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 12.5px;
    color: #334155;
    line-height: 1.6;
    font-weight: 400;
}
.znp-job-detail .hd {
    width: 6px;
    height: 6px;
    min-width: 6px;
    background: var(--orange);
    border-radius: 50%;
    margin-top: 5px;
}

/* ─── key skills ─────────────────────────────────────── */
.znp-job-detail .sw {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.znp-job-detail .sk {
    font-size: 11.5px;
    padding: 4px 12px;
    border-radius: 20px;
    border: 0.5px solid #bfdbfe;
    background: #eff6ff;
    color: #1e40af;
    font-weight: 500;
}
.znp-job-detail .sk.p {
    border-color: var(--blue);
    background: #dbeafe;
}
.znp-job-detail .sknote {
    font-size: 10.5px;
    color: #94a3b8;
    margin-top: 10px;
    font-weight: 500;
    margin-bottom: 0;
}

/* ─── job description ────────────────────────────────── */
.znp-job-detail .db {
    font-size: 12.5px;
    color: #334155;
    line-height: 1.75;
    font-weight: 400;
}
.znp-job-detail .db p { margin-bottom: 8px; }
.znp-job-detail .db ul, .znp-job-detail .db ol { padding-left: 20px; margin-bottom: 10px; }
.znp-job-detail .db li { margin-bottom: 4px; }
.znp-job-detail .db h3,
.znp-job-detail .db h4,
.znp-job-detail .db strong { font-size: 13px; font-weight: 700; color: #0f172a; }
.znp-job-detail .desc-inner {
    max-height: 260px;
    overflow: hidden;
    position: relative;
    transition: max-height 0.3s ease;
}
.znp-job-detail .desc-inner.expanded { max-height: none; }
.znp-job-detail .desc-fade {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(transparent, var(--white));
    pointer-events: none;
    transition: opacity 0.2s;
}
.znp-job-detail .desc-inner.expanded .desc-fade { opacity: 0; }
.znp-job-detail .rm {
    color: var(--blue);
    font-size: 12px;
    cursor: pointer;
    font-weight: 500;
    background: none;
    border: none;
    outline: none;
    padding: 0;
    margin-top: 8px;
    display: inline-block;
}

/* ─── share row ──────────────────────────────────────── */
.znp-job-detail .shr {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}
.znp-job-detail .sob {
    width: 26px;
    height: 26px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 700;
    cursor: pointer;
    color: var(--white);
    border: none;
    text-decoration: none;
}
.znp-job-detail .sfb { background: #1877f2; }
.znp-job-detail .sx  { background: #0f172a; }
.znp-job-detail .sli { background: #0a66c2; }
.znp-job-detail .sob:hover { opacity: 0.85; color: var(--white); text-decoration: none; }
.znp-job-detail .rpt {
    font-size: 11px;
    color: #94a3b8;
    cursor: pointer;
    background: none;
    border: none;
    text-decoration: underline;
    font-weight: 500;
}

/* ─── about company ──────────────────────────────────── */
.znp-job-detail .crow {
    display: flex;
    align-items: center;
    gap: 14px;
}
.znp-job-detail .clogo {
    width: 44px;
    height: 44px;
    background: #f1f5f9;
    border-radius: 8px;
    border: 0.5px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: #475569;
    flex-shrink: 0;
    overflow: hidden;
}
.znp-job-detail .clogo img { width: 44px; height: 44px; object-fit: contain; }
.znp-job-detail .cn {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 2px;
}
.znp-job-detail .csub {
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
}
.znp-job-detail .cdesc {
    font-size: 12px;
    color: #475569;
    margin-top: 13px;
    line-height: 1.7;
    font-weight: 400;
    margin-bottom: 0;
}

/* ─── sidebar: interview mode ────────────────────────── */
.znp-job-detail .itags {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
}
.znp-job-detail .itag {
    font-size: 11px;
    padding: 4px 11px;
    background: #f8fafc;
    border: 0.5px solid #cbd5e1;
    border-radius: 20px;
    color: #334155;
    font-weight: 500;
}

/* ─── sidebar: similar jobs ──────────────────────────── */
.znp-job-detail .sj {
    padding: 11px 0;
    border-bottom: 0.5px solid #f1f5f9;
}
.znp-job-detail .sj:last-of-type { border-bottom: none; }
.znp-job-detail .sjt {
    font-size: 12.5px;
    font-weight: 500;
    color: var(--blue);
    margin-bottom: 2px;
    cursor: pointer;
}
.znp-job-detail .sjt:hover { text-decoration: underline; }
.znp-job-detail .sjm {
    font-size: 11px;
    color: #64748b;
    font-weight: 400;
    margin-bottom: 4px;
}
.znp-job-detail .sjtags {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
}
.znp-job-detail .sjt2 {
    font-size: 10.5px;
    padding: 2px 9px;
    background: #f8fafc;
    border: 0.5px solid #e2e8f0;
    border-radius: 10px;
    color: #475569;
    font-weight: 500;
}
.znp-job-detail .bb {
    width: 100%;
    margin-top: 12px;
    padding: 8px;
    background: #fff7ed;
    border: 0.5px solid #fed7aa;
    border-radius: 7px;
    color: var(--orange);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-align: center;
    display: block;
    text-decoration: none;
}
.znp-job-detail .bb:hover { background: #ffedd5; text-decoration: none; color: var(--orange); }

/* ─── apply modal styles ─────────────────────────────── */
.znp-job-detail .bapp-applied {
    background: #16a34a;
    color: var(--white);
    border: none;
    padding: 7px 20px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    cursor: default;
}

/* ─── walkin info ────────────────────────────────────── */
.znp-job-detail .walkin-box {
    background: #f0f9ff;
    border: 0.5px solid #bae6fd;
    border-radius: 8px;
    padding: 12px 16px;
    margin-top: 10px;
    font-size: 12px;
    color: #0369a1;
    line-height: 1.8;
}
.znp-job-detail .walkin-box strong { font-weight: 700; }

/* ─── responsive ─────────────────────────────────────── */
@media (max-width: 768px) {
    .znp-job-detail .jd-grid {
        grid-template-columns: 1fr;
    }
    .znp-job-detail .rc {
        order: -1;
    }
    .znp-job-detail .jh-body {
        padding: 16px 16px 14px;
    }
    .znp-job-detail .jact {
        flex-direction: column;
        align-items: flex-start;
    }
    .znp-job-detail .jtitle {
        font-size: 16px;
    }
}

/* ─── apply modal ─────────────────────────────────────── */
.znp-apply-modal .modal-content {
    border: none;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18);
    overflow: hidden;
    padding: 0;
}
.znp-am-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 22px 14px;
    border-bottom: 0.5px solid #e2e8f0;
    background: #f8fafc;
}
.znp-am-title {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
}
.znp-am-title svg { width:18px; height:18px; color:#1a3faa; flex-shrink:0; }
.znp-am-title .znp-am-jobtitle {
    color: #1a3faa;
    max-width: 260px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.znp-am-close {
    background: none; border: none; font-size: 22px; line-height: 1;
    color: #94a3b8; cursor: pointer; padding: 0 2px;
}
.znp-am-close:hover { color: #0f172a; }
.znp-am-body { padding: 20px 22px 24px; max-height: 78vh; overflow-y: auto; }
.znp-am-group { margin-bottom: 14px; }
.znp-am-label { display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 5px; }
.znp-am-label span { color: #dc2626; margin-left: 2px; }
.znp-am-input,
.znp-am-select {
    width: 100%; padding: 9px 12px;
    border: 1.5px solid #cbd5e1; border-radius: 8px;
    font-size: 13px; color: #0f172a; background: #fff;
    outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    font-family: inherit;
}
.znp-am-input:focus,
.znp-am-select:focus {
    border-color: #1a3faa;
    box-shadow: 0 0 0 3px rgba(26,63,170,0.08);
}
.znp-am-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center;
    padding-right: 34px; cursor: pointer;
}
.znp-am-section-title {
    font-size: 11px; font-weight: 700; color: #64748b;
    text-transform: uppercase; letter-spacing: 0.07em;
    margin: 18px 0 12px;
    display: flex; align-items: center; gap: 8px;
}
.znp-am-section-title::after { content:''; flex:1; height:1px; background:#e2e8f0; }
.znp-am-slot {
    background: #f8fafc; border: 0.5px solid #e2e8f0;
    border-radius: 10px; padding: 14px 14px 10px; margin-bottom: 10px;
    position: relative;
}
.znp-am-3col { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
.znp-am-3col .znp-am-group { margin-bottom: 0; }
.znp-am-slot-del {
    position: absolute; top: 9px; right: 10px;
    background: none; border: none; color: #94a3b8;
    font-size: 17px; cursor: pointer; line-height: 1; padding: 0;
}
.znp-am-slot-del:hover { color: #dc2626; }
.znp-am-add-btn {
    font-size: 12px; font-weight: 600; color: #1a3faa;
    background: none; border: 1.5px dashed #bfdbfe; border-radius: 8px;
    padding: 7px 14px; cursor: pointer; width: 100%;
    transition: all 0.2s; margin-bottom: 4px; margin-top: 2px;
}
.znp-am-add-btn:hover { background: #eff6ff; border-color: #1a3faa; }
.znp-am-add-btn:disabled { opacity: 0.4; cursor: not-allowed; }
.znp-am-error {
    background: #fef2f2; border: 0.5px solid #fecaca;
    color: #dc2626; border-radius: 8px;
    padding: 10px 14px; font-size: 12px; margin-top: 12px;
}
.znp-am-success { text-align: center; padding: 36px 16px; }
.znp-am-success-icon {
    width: 56px; height: 56px; background: #dcfce7; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; color: #16a34a; margin: 0 auto 14px;
}
.znp-am-success h3 { font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
.znp-am-success p  { font-size: 12px; color: #64748b; margin: 0; }
@media (max-width: 480px) {
    .znp-am-3col { grid-template-columns: 1fr; }
    .znp-apply-modal { margin: 8px; }
}
</style>
@endpush

@section('content')
@include('znp.header')

<div class="znp-job-detail">
<div class="jd-pg">

@php
    /* ── location decode ─────────────────────────────────── */
    try {
        $loc = unserialize($job->location);
        $locationStr = is_array($loc) ? implode(' · ', array_filter(array_values($loc))) : ($job->location ?? '');
    } catch (\Exception $e) {
        $locationStr = $job->location ?? '';
    }

    /* ── salary string ───────────────────────────────────── */
    if ($job->min_salary && $job->max_salary) {
        $salaryStr = $job->min_salary . 'L – ' . $job->max_salary . 'L / yr';
    } elseif ($job->min_salary) {
        $salaryStr = $job->min_salary . 'L+ / yr';
    } elseif ($job->max_salary) {
        $salaryStr = 'Up to ' . $job->max_salary . 'L / yr';
    } else {
        $salaryStr = '';
    }

    /* ── posted age ──────────────────────────────────────── */
    $postedDays = $job->created_at ? (int) $job->created_at->diffInDays(now()) : null;
    if ($postedDays === null) {
        $postedLabel = '';
    } elseif ($postedDays === 0) {
        $postedLabel = 'Posted today';
    } elseif ($postedDays === 1) {
        $postedLabel = 'Posted 1 day ago';
    } else {
        $postedLabel = 'Posted ' . $postedDays . ' days ago';
    }

    /* ── interview modes ─────────────────────────────────── */
    $interviewModes = [];
    if (!empty($job->interview_modes)) {
        $interviewModes = array_filter(array_map('trim', explode(',', $job->interview_modes)));
    }
    $hasWalkin = in_array('Walkin', $interviewModes);

    /* ── job highlights (derive from content) ────────────── */
    $hlSource = $job->job_overview ?: $job->roles_responsibility ?: '';
    preg_match_all('/<li[^>]*>\s*(.*?)\s*<\/li>/si', $hlSource, $hlMatches);
    $highlights = [];
    foreach (($hlMatches[1] ?? []) as $raw) {
        $clean = trim(strip_tags($raw));
        if ($clean) $highlights[] = $clean;
        if (count($highlights) >= 3) break;
    }
    if (empty($highlights)) {
        $plainText = trim(preg_replace('/\s+/', ' ', strip_tags($hlSource)));
        $sentences = array_filter(array_map('trim', preg_split('/(?<=[.!?])\s+/', $plainText)));
        $highlights = array_slice(array_values($sentences), 0, 3);
    }

    /* ── company badges ──────────────────────────────────── */
    $co          = $job->company;
    $hcMap       = [
        '1-10'=>'1-10 Employees','11-50'=>'11-50 Employees','51-200'=>'51-200 Employees',
        '201-500'=>'201-500 Employees','501-1000'=>'501-1K Employees','1001-5000'=>'1K-5K Employees',
        '5001-10000'=>'5K-10K Employees','10001-25000'=>'10K-25K Employees',
        '25001-50000'=>'25K-50K Employees','50001-75000'=>'50K-75K Employees',
        '75001-100000'=>'75K-1L Employees','100000+'=>'1L+ Employees',
    ];
    $headcountStr = ($co && $co->size) ? ($hcMap[$co->size] ?? $co->size . ' Employees') : '';
    $hasGptw      = $co && $co->is_gptw_certified;
    $hasTopEmp    = $co && $co->is_top_employer;
    $hasDisab     = $co && $co->is_disability_hiring;
    $hasWomen     = $co && $co->is_women_friendly;
    $hasAnyBadge  = $hasGptw || $hasTopEmp || $headcountStr || $hasDisab || $hasWomen;

    /* ── share URL ───────────────────────────────────────── */
    $shareUrl = urlencode(url()->current());
    $shareTitle = urlencode($job->job_title . ' at ZeroNoticePeriod');
@endphp

{{-- ═══ JOB HEADER ═══════════════════════════════════════════════ --}}
<div class="jh">
    <div class="jh-bar"></div>
    <div class="jh-body">

        <div class="jh-top">
            <div>
                <div class="jtitle">{{ $job->job_title }}</div>
                <div class="pbadge"><span class="pdot"></span>ZeroNoticePeriod</div>
            </div>
            <div class="znpbadge">Zero<br>Notice<br>Hire</div>
        </div>

        <div class="sum-row">
            @if($salaryStr)<span class="sg-pill">{{ $salaryStr }}</span>@endif
            @if($job->job_type)<span class="sg-pill">{{ $job->job_type }}</span>@endif
            @if($job->experience)<span class="sg-pill">{{ $job->experience }}</span>@endif
            @if($job->job_shift)<span class="sg-pill">{{ $job->job_shift }}</span>@endif
            @if($job->work_mode)<span class="sg-pill">{{ $job->work_mode }}</span>@endif
            @if($locationStr)<span class="sg-pill">{{ $locationStr }}</span>@endif
        </div>

        @if($hasAnyBadge)
        <div class="cert-badges">
            @if($hasGptw)
            <span class="ctag cg">
                <svg viewBox="0 0 13 13" stroke="#0369a1" stroke-width="2"><polyline points="1.5,6.5 5,10 11.5,3"/></svg>
                GPTW Certified
            </span>
            @endif
            @if($hasTopEmp)
            <span class="ctag ce">
                <svg viewBox="0 0 13 13" stroke="#0f766e" stroke-width="1.8"><polygon points="6.5,1.5 8,4.5 11.5,5 9,7.5 9.5,11 6.5,9.5 3.5,11 4,7.5 1.5,5 5,4.5"/></svg>
                Top Employer
            </span>
            @endif
            @if($headcountStr)
            <span class="ctag cs">
                <svg viewBox="0 0 13 13" stroke="#475569" stroke-width="1.8"><circle cx="4.5" cy="4" r="2"/><circle cx="9" cy="4" r="2"/><path d="M1 11c0-2 1.6-3.5 3.5-3.5s3.5 1.5 3.5 3.5"/><path d="M9 7.5c1.5.3 3 1.2 3 3"/></svg>
                {{ $headcountStr }}
            </span>
            @endif
            @if($hasDisab)
            <span class="ctag cd">
                <svg viewBox="0 0 13 13" stroke="#7e22ce" stroke-width="1.8"><circle cx="6.5" cy="3" r="1.5"/><path d="M6.5 5v4M4.5 7h4M4.5 12l2-3 2 3"/></svg>
                Disability Hiring
            </span>
            @endif
            @if($hasWomen)
            <span class="ctag cw">
                <svg viewBox="0 0 13 13" stroke="#be185d" stroke-width="1.8"><circle cx="6.5" cy="4.5" r="2.2"/><path d="M6.5 6.8v4M5 10h3"/></svg>
                Women Friendly
            </span>
            @endif
        </div>
        @endif

        <div class="jact">
            <div class="jinfo">
                {{ $postedLabel }}@if($postedLabel) &nbsp;·&nbsp; @endif Applicants: {{ $applicantCount }}
            </div>
            <div class="abtns">
                @guest
                    {{-- Not logged in: show Register + Apply redirects to login --}}
                    <a href="{{ route('register') }}" class="bsave">Register</a>
                    <a href="{{ route('login') }}" class="bapp">Apply Now →</a>
                @else
                    {{-- Logged in --}}
                    @if(Auth::user()->isAppliedOnJob($job->id))
                        <span class="bapp-applied">✓ Applied</span>
                    @else
                        {{-- No Register button when authenticated --}}
                        <button class="bapp" data-toggle="modal" data-target="#applyModal">Apply Now →</button>
                    @endif
                @endguest
            </div>
        </div>

    </div>
</div>
{{-- end job header --}}

{{-- ═══ GRID ═══════════════════════════════════════════════════════ --}}
<div class="jd-grid">

    {{-- ── LEFT COLUMN ───────────────────────────────────────── --}}
    <div class="lc">

        {{-- Job Highlights --}}
        @if(count($highlights))
        <div class="card">
            <div class="ct">Job highlights</div>
            <ul class="hl">
                @foreach($highlights as $hl)
                    <li><span class="hd"></span>{{ $hl }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Key Skills --}}
        @if($jobskills->count())
        <div class="card">
            <div class="ct">Key skills</div>
            <div class="sw">
                @foreach($jobskills as $i => $skill)
                    <span class="sk{{ $i < 2 ? ' p' : '' }}">{{ $skill->job_skill }}</span>
                @endforeach
            </div>
            @if($jobskills->count() > 2)
            <p class="sknote">Skills highlighted in blue are preferred key skills</p>
            @endif
        </div>
        @endif

        {{-- Job Description --}}
        @if($job->job_description || $job->job_overview || $job->roles_responsibility)
        <div class="card">
            <div class="ct">Job description</div>
            <div class="db">
                <div class="desc-inner" id="jd-desc">
                    @if($job->job_description)
                        {!! $job->job_description !!}
                    @endif
                    @if($job->job_overview)
                        {!! $job->job_overview !!}
                    @endif
                    @if($job->roles_responsibility)
                        {!! $job->roles_responsibility !!}
                    @endif
                    <div class="desc-fade" id="jd-fade"></div>
                </div>
                <button class="rm" id="jd-rm-btn" onclick="znpToggleDesc()">read more ▾</button>
            </div>
        </div>
        @endif

        {{-- Share + Report --}}
        <div class="card" style="padding:13px 24px;">
            <div class="shr">
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:12px;color:#64748b;font-weight:600;">Share this job:</span>
                    <div style="display:flex;gap:7px;">
                        <a class="sob sfb"
                           href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                           target="_blank" rel="noopener noreferrer"
                           title="Share on Facebook">f</a>
                        <a class="sob sx"
                           href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
                           target="_blank" rel="noopener noreferrer"
                           title="Share on X">𝕏</a>
                        <a class="sob sli"
                           href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}&title={{ $shareTitle }}"
                           target="_blank" rel="noopener noreferrer"
                           title="Share on LinkedIn">in</a>
                    </div>
                </div>
                {{-- <button class="rpt" onclick="znpReportJob()">Report this job</button> --}}
            </div>
        </div>

        {{-- About the Company --}}
        <div class="card">
            <div class="ct">About the company</div>
            <div class="crow">
                <div class="clogo">
                    @if($co && $co->logo)
                        <img src="{{ asset('company_logos/' . $co->logo) }}" alt="{{ $co->name ?? 'Company' }}">
                    @else
                        {{ $co ? strtoupper(substr($co->name ?? 'C', 0, 3)) : 'ZNP' }}
                    @endif
                </div>
                <div>
                    <div class="cn">{{ $co->name ?? 'Company' }} (via ZeroNoticePeriod)</div>
                    <div class="csub">Exclusive immediate-hire listing · zeronoticeperiod.com</div>
                </div>
            </div>
            <p class="cdesc">
                @if($co && $co->description)
                    {!! $co->description !!}
                @else
                    ZeroNoticePeriod is an exclusive online hiring platform connecting job seekers with Zero Notice Period with employers looking for immediate hires. We help employers hire at a fast pace without losing time on "searching" talent with zero notice period.
                @endif
            </p>
        </div>

    </div>
    {{-- end left column --}}

    {{-- ── RIGHT COLUMN ──────────────────────────────────────── --}}
    <div class="rc">

        {{-- Mode of Interview --}}
        @if(count($interviewModes))
        <div class="card">
            <div class="ct">Mode of interview</div>
            <div class="itags">
                @foreach($interviewModes as $mode)
                    <span class="itag">{{ $mode }}</span>
                @endforeach
            </div>
            @if($hasWalkin && ($job->walkin_date || $job->walkin_venue))
            <div class="walkin-box">
                @if($job->walkin_date)<div><strong>Date:</strong> {{ $job->walkin_date }}</div>@endif
                @if($job->walkin_time)<div><strong>Time:</strong> {{ $job->walkin_time }}</div>@endif
                @if($job->walkin_venue)<div><strong>Venue:</strong> {{ $job->walkin_venue }}</div>@endif
                @if($job->walkin_contact)<div><strong>Contact:</strong> {{ $job->walkin_contact }}</div>@endif
            </div>
            @endif
        </div>
        @endif

        {{-- Similar Jobs --}}
        <div class="card">
            <div class="ct">Similar jobs on ZNP</div>
            @forelse($similarJobs as $sj)
                @php
                    try {
                        $sjLoc = unserialize($sj->location);
                        $sjLocStr = is_array($sjLoc) ? implode(' · ', array_filter(array_slice(array_values($sjLoc), 0, 2))) : ($sj->location ?? '');
                    } catch (\Exception $e) {
                        $sjLocStr = $sj->location ?? '';
                    }
                    $sjCompany  = $sj->company->name ?? '';
                    $sjSalary   = ($sj->min_salary && $sj->max_salary) ? $sj->min_salary.'–'.$sj->max_salary.' LPA' : ($sj->min_salary ? $sj->min_salary.'+ LPA' : '');
                    $sjExp      = $sj->experience ?? '';
                @endphp
                <div class="sj">
                    <a class="sjt" href="{{ route('job.detail.znp', $sj->slug) }}">{{ $sj->job_title }}</a>
                    @if($sjCompany || $sjLocStr)
                    <div class="sjm">{{ implode(' · ', array_filter([$sjCompany, $sjLocStr])) }}</div>
                    @endif
                    @if($sjExp || $sjSalary)
                    <div class="sjm">{{ implode(' · ', array_filter([$sjExp, $sjSalary])) }}</div>
                    @endif
                    <div class="sjtags">
                        @if($sj->work_mode)<span class="sjt2">{{ $sj->work_mode }}</span>@endif
                        <span class="sjt2">Immediate</span>
                    </div>
                </div>
            @empty
                <p style="font-size:12px;color:#94a3b8;margin:0;">No similar jobs found right now.</p>
            @endforelse
            <a href="{{ route('job.list') }}" class="bb">Browse all jobs →</a>
        </div>

    </div>
    {{-- end right column --}}

</div>
{{-- end grid --}}

</div>
</div>
{{-- end .jd-pg / .znp-job-detail --}}

@include('znp.footer')

{{-- ═══ APPLY MODAL (for authenticated non-applied users) ═════════ --}}
@auth
@if(!Auth::user()->isAppliedOnJob($job->id))
@php $amUser = Auth::user(); @endphp
<div class="modal fade" id="applyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered znp-apply-modal" role="document" style="max-width:520px;">
        <div class="modal-content">

            {{-- header --}}
            <div class="znp-am-header">
                <div class="znp-am-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    Apply for&nbsp;<span class="znp-am-jobtitle">{{ $job->job_title }}</span>
                </div>
                <button class="znp-am-close" type="button" data-dismiss="modal" aria-label="Close">×</button>
            </div>

            {{-- success screen --}}
            <div class="znp-am-success" id="znp-am-success" style="display:none;">
                <div class="znp-am-success-icon">✓</div>
                <h3>Application Submitted!</h3>
                <p>Our recruiters will get back to you soon.</p>
            </div>

            {{-- form body --}}
            <div class="znp-am-body" id="znp-am-form-wrap">
                <form id="znp-apply-form" method="POST"
                      action="{{ route('job.update.front.profile.np', [$amUser->id]) }}">
                    @csrf
                    <input type="hidden" name="job_id"  value="{{ $job->id }}">
                    <input type="hidden" name="user_id" value="{{ $amUser->id }}">

                    {{-- Notice Period Status --}}
                    <div class="znp-am-group">
                        <label class="znp-am-label">Notice Period Status <span>*</span></label>
                        <select name="nop_days" id="znp-nop-sel" class="znp-am-select" required>
                            <option value="" disabled selected>Select Option</option>
                            <option value="1" @if(isset($amUser->getprofileNop()->nop_days) && $amUser->getprofileNop()->nop_days == '1') selected @endif>Immediately Available</option>
                            <option value="2" @if(isset($amUser->getprofileNop()->nop_days) && $amUser->getprofileNop()->nop_days == '2') selected @endif>Serving Notice Period</option>
                        </select>
                    </div>

                    {{-- Shown when Serving Notice Period --}}
                    <div id="znp-snp-wrap" style="{{ (isset($amUser->getprofileNop()->nop_days) && $amUser->getprofileNop()->nop_days == '2') ? '' : 'display:none;' }}">
                        <div class="znp-am-group">
                            <label class="znp-am-label">Last Working Date (while serving notice) <span>*</span></label>
                            <input type="text" name="last_working_day"
                                   class="znp-am-input znp-datepicker"
                                   value="{{ isset($amUser->getprofileNop()->last_working_day) ? \Carbon\Carbon::parse($amUser->getprofileNop()->last_working_day)->format('d-M-Y') : '' }}"
                                   placeholder="DD-Mon-YYYY" autocomplete="off">
                        </div>
                    </div>

                    {{-- Shown when Immediately Available --}}
                    <div id="znp-bnp-wrap" style="{{ (isset($amUser->getprofileNop()->nop_days) && $amUser->getprofileNop()->nop_days == '1') ? '' : 'display:none;' }}">
                        <div class="znp-am-group">
                            <label class="znp-am-label">Last Working Date / Month of Graduation <span>*</span></label>
                            <input type="text" name="immediate_last_date"
                                   class="znp-am-input znp-datepicker-month"
                                   value="{{ isset($amUser->getprofileNop()->immediate_last_date) ? $amUser->getprofileNop()->immediate_last_date : '' }}"
                                   placeholder="Mon-YYYY" autocomplete="off">
                        </div>
                    </div>

                    {{-- Video Interview Availability --}}
                    <div class="znp-am-section-title">Video Interview Availability</div>
                    <div id="znp-slots-wrap">
                        <div class="znp-am-slot">
                            <div class="znp-am-3col">
                                <div class="znp-am-group">
                                    <label class="znp-am-label">Date <span>*</span></label>
                                    <input type="text" name="date[]" class="znp-am-input znp-date-picker" autocomplete="off">
                                </div>
                                <div class="znp-am-group">
                                    <label class="znp-am-label">From <span>*</span></label>
                                    <input type="text" name="from_time[]" class="znp-am-input znp-timepicker znp-from" autocomplete="off">
                                </div>
                                <div class="znp-am-group">
                                    <label class="znp-am-label">To <span>*</span></label>
                                    <input type="text" name="to_time[]" class="znp-am-input znp-timepicker znp-to" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="znp-add-slot" class="znp-am-add-btn">+ Add Another Slot</button>

                    <div class="znp-am-error" id="znp-am-error" style="display:none;"></div>

                    <button type="button" class="bapp" style="width:100%;margin-top:16px;"
                            onclick="znpSubmitApply()">Confirm &amp; Apply</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endif
@endauth

@endsection

@push('scripts')
<script>
/* ── read-more toggle ─────────────────────────────────── */
function znpToggleDesc() {
    var inner = document.getElementById('jd-desc');
    var fade  = document.getElementById('jd-fade');
    var btn   = document.getElementById('jd-rm-btn');
    if (!inner) return;
    if (inner.classList.contains('expanded')) {
        inner.classList.remove('expanded');
        if (fade) fade.style.opacity = '1';
        btn.textContent = 'read more ▾';
    } else {
        inner.classList.add('expanded');
        if (fade) fade.style.opacity = '0';
        btn.textContent = 'show less ▴';
    }
}

/* ── report job ───────────────────────────────────────── */
function znpReportJob() {
    alert('Thank you. Your report has been noted and will be reviewed by our team.');
}

/* ── apply modal ──────────────────────────────────────── */
(function () {
    var MAX_SLOTS = 3;

    /* init datepickers / timepickers inside the modal */
    function initZnpPickers($scope) {
        $scope = $scope || $('#applyModal');
        $scope.find('.znp-datepicker').not('[data-znp-init]').each(function () {
            $(this).attr('data-znp-init', '1').datepicker({
                autoclose: true, format: 'dd-M-yyyy',
                todayHighlight: true, orientation: 'bottom',
                endDate: new Date()
            });
        });
        $scope.find('.znp-datepicker-month').not('[data-znp-init]').each(function () {
            $(this).attr('data-znp-init', '1').datepicker({
                autoclose: true, format: 'M-yyyy',
                viewMode: 'months', minViewMode: 'months',
                orientation: 'bottom', endDate: new Date()
            });
        });
        $scope.find('.znp-date-picker').not('[data-znp-init]').each(function () {
            $(this).attr('data-znp-init', '1').datepicker({
                autoclose: true, format: 'dd-mm-yyyy',
                startDate: new Date(), endDate: '+30d',
                changeMonth: true, changeYear: true, orientation: 'bottom'
            });
        });
        $scope.find('.znp-timepicker').not('[data-znp-init]').each(function () {
            $(this).attr('data-znp-init', '1').timepicker({});
        });
    }

    /* run once on DOM ready too (for pre-filled values) */
    $(function () { initZnpPickers(); });

    /* re-run every time modal opens */
    $('#applyModal').on('shown.bs.modal', function () {
        initZnpPickers();
    });

    /* NOP select: toggle date fields */
    $(document).on('change', '#znp-nop-sel', function () {
        var v = this.value;
        $('#znp-snp-wrap').toggle(v === '2');
        $('#znp-bnp-wrap').toggle(v === '1');
    });

    /* Auto-fill "To" time = "From" + 1 hr */
    $(document).on('changeTime change', '.znp-from', function () {
        var $slot  = $(this).closest('.znp-am-slot');
        var fromVal = $(this).val();
        if (!fromVal) return;
        try {
            var parts     = fromVal.split(' ');
            var timeParts = parts[0].split(':');
            var hours     = parseInt(timeParts[0]);
            var minutes   = parseInt(timeParts[1]);
            var isPM      = parts[1] && parts[1].toUpperCase() === 'PM';
            if (isPM && hours !== 12) hours += 12;
            else if (!isPM && hours === 12) hours = 0;
            var d = new Date();
            d.setHours(hours); d.setMinutes(minutes);
            d.setHours(d.getHours() + 1);
            var uh = d.getHours() % 12 || 12;
            var um = d.getMinutes();
            var ua = d.getHours() >= 12 ? 'PM' : 'AM';
            $slot.find('.znp-to').val(uh + ':' + (um < 10 ? '0' : '') + um + ' ' + ua);
        } catch (e) {}
    });

    /* Add Another Slot (max 3) */
    $(document).on('click', '#znp-add-slot', function () {
        var $wrap  = $('#znp-slots-wrap');
        var count  = $wrap.find('.znp-am-slot').length;
        if (count >= MAX_SLOTS) return;
        var $clone = $wrap.find('.znp-am-slot').first().clone(true, true);
        $clone.find('input').val('').removeAttr('data-znp-init');
        var $del = $('<button type="button" class="znp-am-slot-del" title="Remove slot">×</button>');
        $del.on('click', function () {
            $(this).closest('.znp-am-slot').remove();
            if ($wrap.find('.znp-am-slot').length < MAX_SLOTS) {
                $('#znp-add-slot').prop('disabled', false).text('+ Add Another Slot');
            }
        });
        $clone.append($del);
        $wrap.append($clone);
        initZnpPickers($clone);
        if ($wrap.find('.znp-am-slot').length >= MAX_SLOTS) {
            $(this).prop('disabled', true).text('Max 3 slots added');
        }
    });

    /* AJAX apply submit */
    window.znpSubmitApply = function () {
        var $form = $('#znp-apply-form');
        var $err  = $('#znp-am-error');
        var $btn  = $form.find('button[onclick="znpSubmitApply()"]');
        $err.hide();
        $btn.prop('disabled', true).text('Submitting…');
        $.ajax({
            url:      $form.attr('action'),
            type:     'POST',
            data:     $form.serialize(),
            dataType: 'json',
            success: function () {
                $('#znp-am-form-wrap').hide();
                $('#znp-am-success').show();
                setTimeout(function () {
                    $('#applyModal').modal('hide');
                    location.reload();
                }, 2200);
            },
            error: function (xhr) {
                $btn.prop('disabled', false).text('Confirm & Apply');
                var msg = 'Something went wrong. Please try again.';
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errs = [];
                    $.each(xhr.responseJSON.errors, function (k, v) { errs.push(v[0]); });
                    msg = errs.join('<br>');
                } else if (xhr.status === 419) {
                    msg = 'Session expired. Please refresh the page and try again.';
                }
                $err.html(msg).show();
            }
        });
    };

})();
</script>
@endpush
