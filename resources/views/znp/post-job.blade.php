@extends('layouts.znp')

@php
    /* ── Mode (create | edit) ────────────────────────────────────────────
       The same blade powers both "Post a Job" (create) and "Edit Job".
       In edit mode the controller `flashInput(...)` pre-populates ALL
       `old('field', ...)` calls with the existing job's values — so the
       rest of this template needs almost no edit-specific branching.    */
    $mode    = $mode ?? 'create';
    $job     = $job ?? null;
    $isEdit  = ($mode === 'edit') && $job;
    $formAction        = $isEdit ? route('employer.post.job.update', $job->id) : route('employer.post.job.store');
    $pageHeading       = $isEdit ? 'Edit Job' : 'Post A New Job';
    $pageSub           = $isEdit
        ? 'Update the fields below — the changes will replace what candidates see immediately after save.'
        : "Your job will be visible to verified zero-notice-period candidates immediately after review.";
    $submitButtonLabel = $isEdit ? 'Preview & Update Job' : 'Preview & Post Job';
@endphp

@section('page_title', ($isEdit ? 'Edit Job' : 'Post a New Job') . ' | ZeroNoticePeriod')

@php
    /* ── Auto-saved prefill values (Company snapshot from the last post) ── */
    $aboutCompany   = old('about_company', strip_tags($company->description ?? ''));
    $websiteRaw     = old('website_address', $company->website ?? '');
    $websiteHost    = preg_replace('#^https?://(www\.)?#i', '', trim($websiteRaw));
    $headcountSel   = old('headcount', $company->headcount ?? $company->no_of_employees ?? '');
    $officeAddr     = old('office_address', $company->office_address ?? $company->location ?? '');
    $industryIdSel  = old('industry_id', $company->industry_id ?? '');
    $logoUrl        = ! empty($company->logo) ? asset('company_logos/'.$company->logo) : null;

    $prefillCountries = (array) old('countries_presence', $companyCountries ?? []);
    $prefillAwards    = (array) old('awards', $companyAwards ?? []);
    $prefillPerks     = (array) old('perks', $companyPerks ?? []);

    /* Headcount pill labels used by the new UI. */
    $headcountPills = ['1–10','11–50','51–200','201–500','500–1K','1K–5K','5K–10K','10K–25K','25K–50K','50K–75K','75K–1L','1L+'];

@endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="{{ asset('asset/select2.min.css') }}" rel="stylesheet">
<style>
/* ────────────────────────────────────────────────────────────────────
   ZNP Post-Job page — scoped under .znp-pj so it never leaks into the
   shared layout (header/footer). Styles are ported from the design
   mock at znp_post_job_v9 with .znp-pj selector prefixes.
   ──────────────────────────────────────────────────────────────────── */
.znp-pj {
    font-family: 'Manrope', sans-serif;
    background: #f0f4f8;
    color: #0f172a;
    font-size: 13px;
    -webkit-font-smoothing: antialiased;
    min-height: 100vh;
    padding-bottom: 60px;
}
.znp-pj *, .znp-pj *::before, .znp-pj *::after { box-sizing: border-box; }
.znp-pj a { color: inherit; text-decoration: none; }
.znp-pj button { cursor: pointer; font-family: inherit; }

/* ── INLINE NAV (matches job-pricing pattern with pj- prefixes) ── */
.znp-pj .pj-nav {
    background: #fff; border-bottom: 1px solid #e2e8f0;
    padding: 0 32px; display: flex; align-items: center; justify-content: space-between;
    height: 56px; position: sticky; top: 0; z-index: 50;
}
.znp-pj .pj-logo { font-size: 18px; font-weight: 800; letter-spacing: -.3px; }
.znp-pj .pj-la, .znp-pj .pj-lc { color: #1c3faa; }
.znp-pj .pj-lb { color: #ea580c; }
.znp-pj .pj-nb {
    padding: 7px 18px; border-radius: 6px; font-size: 12.5px; font-weight: 600;
    transition: all .2s; display: inline-flex; align-items: center; border: none;
    cursor: pointer; font-family: 'Manrope', sans-serif;
}
.znp-pj .pj-nb-o { border: 1.5px solid #1c3faa; background: #fff; color: #1c3faa; }
.znp-pj .pj-nb-o:hover { background: #eff6ff; }

/* ── PAGE LAYOUT ── */
.znp-pj .pj-pg { max-width: 760px; margin: 24px auto 0; padding: 0 20px; overflow-x: hidden; }
.znp-pj .pj-page-head { margin-bottom: 18px; text-align: center; }
.znp-pj .pj-page-title { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -.3px; display: flex; align-items: center; justify-content: center; gap: 10px; flex-wrap: wrap; }
.znp-pj .pj-page-title span { color: #1c3faa; }
.znp-pj .pj-page-sub { font-size: 12.5px; color: #64748b; margin-top: 6px; }

/* ── SAVE BANNER ── */
.znp-pj .save-banner { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 12px 18px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
.znp-pj .sb-left { display: flex; align-items: center; gap: 10px; }
.znp-pj .sb-icon { width: 32px; height: 32px; background: #1c3faa; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.znp-pj .sb-text { font-size: 12.5px; color: #1e40af; font-weight: 500; }
.znp-pj .sb-text strong { font-weight: 700; }

/* ── SECTION CARDS ── */
.znp-pj .sec { background: #fff; border: 0.5px solid #d1dae8; border-radius: 12px; padding: 20px 22px; margin-bottom: 12px; }
.znp-pj .sec-bar { height: 3px; border-radius: 12px 12px 0 0; margin: -20px -22px 18px; background: #1c3faa; }
.znp-pj .sec-bar.orange { background: #ea580c; }
.znp-pj .sec-bar.teal { background: #0ea5e9; }
.znp-pj .sec-bar.purple { background: #a855f7; }
.znp-pj .sec-bar.green { background: #22c55e; }
.znp-pj .sec-bar.indigo { background: #6366f1; }
.znp-pj .sec-title { font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 4px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.znp-pj .sec-sub { font-size: 11.5px; color: #94a3b8; margin-bottom: 20px; }
.znp-pj .auto-pill { display: inline-flex; align-items: center; gap: 4px; font-size: 10.5px; font-weight: 600; color: #15803d; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 20px; padding: 2px 9px; }

/* ── FORM GRID ── */
.znp-pj .fg2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.znp-pj .fg3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }
.znp-pj .fspan2 { grid-column: span 2; }

/* ── FIELD ── */
.znp-pj .field { display: flex; flex-direction: column; gap: 5px; }
.znp-pj .flabel { font-size: 11.5px; font-weight: 600; color: #334155; display: flex; align-items: center; gap: 4px; }
.znp-pj .req { color: #ea580c; }
.znp-pj .finput, .znp-pj .fselect, .znp-pj .ftextarea {
    width: 100%; border: 1px solid #d1dae8; border-radius: 7px; padding: 9px 12px;
    font-size: 12.5px; font-family: inherit; color: #0f172a; outline: none;
    background: #fff; transition: border .15s;
}
.znp-pj .finput:focus, .znp-pj .fselect:focus, .znp-pj .ftextarea:focus {
    border-color: #1c3faa; box-shadow: 0 0 0 3px rgba(28,63,170,.08);
}
.znp-pj .fselect {
    cursor: pointer; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center; padding-right: 30px;
}
.znp-pj .ftextarea { min-height: 110px; resize: vertical; line-height: 1.6; }
.znp-pj .fhint { font-size: 10.5px; color: #94a3b8; }
.znp-pj .field-error { font-size: 11px; color: #dc2626; font-weight: 600; margin-top: 3px; display: block; }

/* ── RICH TEXT MOCK ── */
.znp-pj .rich-wrap { border: 1px solid #d1dae8; border-radius: 7px; overflow: hidden; background: #fff; }
.znp-pj .rich-toolbar { background: #f8fafc; border-bottom: 1px solid #e8eef5; padding: 6px 10px; display: flex; gap: 4px; align-items: center; flex-wrap: wrap; }
.znp-pj .rt-btn { width: 26px; height: 26px; border: 1px solid #e2e8f0; border-radius: 4px; background: #fff; cursor: pointer; font-size: 11px; font-weight: 700; color: #475569; display: flex; align-items: center; justify-content: center; font-family: inherit; }
.znp-pj .rt-btn:hover { background: #eff6ff; border-color: #bfdbfe; color: #1c3faa; }
.znp-pj .rt-div { width: 1px; height: 18px; background: #e2e8f0; margin: 0 2px; }
.znp-pj .rich-area { min-height: 120px; padding: 12px; font-size: 12.5px; color: #0f172a; outline: none; line-height: 1.7; }
.znp-pj .rich-area[contenteditable=true]:empty::before { content: attr(data-ph); color: #94a3b8; }

/* ── INTERVIEW + PROFILE-REQ CHECK GRID ── */
.znp-pj .check-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
.znp-pj .check-grid.col3 { grid-template-columns: repeat(3, 1fr); }
.znp-pj .check-grid.col2 { grid-template-columns: repeat(2, 1fr); }
.znp-pj .check-item { display: flex; align-items: center; gap: 7px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 7px; padding: 8px 10px; cursor: pointer; transition: all .15s; user-select: none; }
.znp-pj .check-item:hover { border-color: #1c3faa; background: #eff6ff; }
.znp-pj .check-item.checked { border-color: #1c3faa; background: #eff6ff; }
.znp-pj .check-item input[type="checkbox"] { display: none; }
.znp-pj .check-box { width: 15px; height: 15px; border: 1.5px solid #cbd5e1; border-radius: 4px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all .15s; }
.znp-pj .check-item.checked .check-box { background: #1c3faa; border-color: #1c3faa; }
.znp-pj .check-item.checked .check-box::after { content: ''; display: block; width: 5px; height: 8px; border: 2px solid #fff; border-top: none; border-left: none; transform: rotate(42deg) translateY(-1px); }
.znp-pj .check-label { font-size: 12px; font-weight: 500; color: #334155; }
.znp-pj .check-item.checked .check-label { color: #1c3faa; font-weight: 600; }

/* ── PERKS GRID ── */
.znp-pj .perks-cat { font-size: 10.5px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .07em; margin: 4px 0 8px; }
.znp-pj .perks-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 7px; margin-bottom: 14px; }
.znp-pj .perk-item { display: flex; align-items: flex-start; gap: 8px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 7px; padding: 9px 11px; cursor: pointer; transition: all .15s; user-select: none; }
.znp-pj .perk-item input[type="checkbox"] { display: none; }
.znp-pj .perk-item:hover { border-color: #a855f7; background: #faf5ff; }
.znp-pj .perk-item.checked { border-color: #a855f7; background: #faf5ff; }
.znp-pj .perk-item.checked .check-box { background: #a855f7; border-color: #a855f7; }
.znp-pj .perk-item.checked .check-box::after { content: ''; display: block; width: 5px; height: 8px; border: 2px solid #fff; border-top: none; border-left: none; transform: rotate(42deg) translateY(-1px); }
.znp-pj .perk-item .check-label { font-size: 11.5px; color: #334155; line-height: 1.45; }
.znp-pj .perk-item.checked .check-label { color: #7e22ce; font-weight: 600; }

/* ── AWARDS / TAGS ── */
.znp-pj .awards-wrap { display: flex; flex-direction: column; gap: 8px; }
.znp-pj .award-tag-row { display: flex; flex-wrap: wrap; gap: 6px; min-height: 36px; padding: 6px; background: #f8fafc; border: 1px solid #d1dae8; border-radius: 7px; }
.znp-pj .atag { display: inline-flex; align-items: center; gap: 5px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 20px; padding: 3px 10px; font-size: 11.5px; color: #1e40af; font-weight: 600; }
.znp-pj .atag-x { cursor: pointer; color: #93c5fd; font-size: 14px; line-height: 1; }
.znp-pj .award-add-row { display: flex; gap: 8px; }
.znp-pj .award-select { flex: 1; }
.znp-pj .award-btn { background: #1c3faa; color: #fff; border: none; padding: 9px 16px; border-radius: 7px; font-size: 12.5px; font-weight: 600; cursor: pointer; font-family: inherit; white-space: nowrap; }
.znp-pj .award-btn.purple { background: #a855f7; }
.znp-pj .custom-row { display: flex; gap: 8px; margin-top: 6px; }

/* ── LOGO ── */
.znp-pj .logo-row { display: flex; align-items: center; gap: 10px; }
.znp-pj .logo-prev { width: 44px; height: 44px; border-radius: 8px; background: #f1f5f9; border: 1px solid #d1dae8; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; }
.znp-pj .logo-prev img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
.znp-pj .logo-upload-btn { padding: 7px 14px; border: 1.5px solid #d1dae8; border-radius: 7px; background: #fff; font-size: 12px; font-weight: 600; color: #334155; cursor: pointer; font-family: inherit; transition: all .15s; }
.znp-pj .logo-upload-btn:hover { border-color: #1c3faa; color: #1c3faa; }

/* ── HEADCOUNT PILLS ── */
.znp-pj .hc-row { display: flex; flex-wrap: wrap; gap: 8px; }
.znp-pj .hc-pill { padding: 7px 16px; border: 1.5px solid #d1dae8; border-radius: 20px; font-size: 12px; font-weight: 600; color: #64748b; cursor: pointer; transition: all .15s; user-select: none; }
.znp-pj .hc-pill:hover { border-color: #1c3faa; color: #1c3faa; }
.znp-pj .hc-pill.sel { border-color: #1c3faa; background: #1c3faa; color: #fff; }

/* ── SUBMIT ROW ── */
.znp-pj .submit-row { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; background: #fff; border: 0.5px solid #d1dae8; border-radius: 12px; padding: 16px 22px; }
.znp-pj .sr-left { display: flex; align-items: center; gap: 10px; }
.znp-pj .save-info { display: flex; align-items: center; gap: 10px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 10px 14px; }
.znp-pj .save-info-title { font-size: 12.5px; font-weight: 700; color: #15803d; }
.znp-pj .save-info-sub { font-size: 11px; color: #166534; }
.znp-pj .submit-btn { background: #ea580c; color: #fff; border: none; padding: 9px 22px; border-radius: 8px; font-size: 12.5px; font-weight: 700; cursor: pointer; font-family: inherit; display: inline-flex; align-items: center; gap: 7px; }
.znp-pj .submit-btn:hover { background: #c2410c; }
.znp-pj .save-draft { border: 1.5px solid #d1dae8; color: #64748b; background: #fff; padding: 9px 18px; border-radius: 8px; font-size: 12.5px; font-weight: 600; cursor: pointer; font-family: inherit; }
.znp-pj .save-draft:hover { border-color: #1c3faa; color: #1c3faa; }

/* ── SAVE TOGGLE (compensation confidential, video Q, strict mode) ── */
.znp-pj .save-toggle { width: 38px; height: 22px; border-radius: 100px; background: #e2e8f0; position: relative; transition: background .2s; cursor: pointer; flex-shrink: 0; }
.znp-pj .save-toggle.on { background: #1c3faa; }
.znp-pj .save-knob { position: absolute; top: 3px; left: 3px; width: 16px; height: 16px; border-radius: 50%; background: #fff; transition: left .2s; box-shadow: 0 1px 3px rgba(0,0,0,.15); }
.znp-pj .save-toggle.on .save-knob { left: 19px; }
.znp-pj .toggle-row { display: flex; align-items: center; gap: 8px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 7px; padding: 9px 12px; margin-bottom: 14px; }
.znp-pj .toggle-title { font-size: 12px; font-weight: 600; color: #334155; }
.znp-pj .toggle-sub { font-size: 11px; color: #94a3b8; }

/* ── QUESTIONNAIRE ── */
.znp-pj .q-list { display: flex; flex-direction: column; gap: 12px; }
.znp-pj .q-row { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 9px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 14px; transition: border .15s; }
.znp-pj .q-num { width: 26px; height: 26px; border-radius: 50%; background: #1c3faa; color: #fff; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px; }
.znp-pj .q-body { flex: 1; }
.znp-pj .q-title { font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 4px; }
.znp-pj .q-desc { font-size: 11.5px; color: #64748b; line-height: 1.5; margin-bottom: 8px; }
.znp-pj .q-type-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.znp-pj .q-type-badge { font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
.znp-pj .qt-text { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.znp-pj .qt-number { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
.znp-pj .q-required { font-size: 10.5px; color: #94a3b8; }
.znp-pj .q-required.yes { color: #ea580c; font-weight: 600; }
.znp-pj .q-toggle-wrap { display: flex; align-items: center; gap: 6px; margin-top: 8px; }
.znp-pj .q-toggle { width: 32px; height: 18px; border-radius: 100px; background: #1c3faa; position: relative; cursor: pointer; flex-shrink: 0; }
.znp-pj .q-toggle .save-knob { top: 2px; left: 16px; width: 14px; height: 14px; }
.znp-pj .q-toggle.off { background: #e2e8f0; }
.znp-pj .q-toggle.off .save-knob { left: 2px; }
.znp-pj .q-toggle-label { font-size: 11.5px; color: #475569; font-weight: 500; }
.znp-pj .q-add-row { display: flex; gap: 8px; margin-top: 10px; }
.znp-pj .q-add-btn { display: flex; align-items: center; gap: 6px; padding: 8px 16px; border: 1.5px dashed #c7d5f8; border-radius: 8px; background: #f8faff; color: #1c3faa; font-size: 12.5px; font-weight: 600; cursor: pointer; font-family: inherit; transition: all .15s; }
.znp-pj .q-add-btn:hover { background: #eff6ff; border-color: #1c3faa; }

/* ── STEP INDICATOR ── */
.znp-pj .steps { display: flex; align-items: center; gap: 0; margin-bottom: 22px; }
.znp-pj .step { display: flex; align-items: center; gap: 8px; flex: 0 0 auto; }
.znp-pj .step-num { width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0; }
.znp-pj .step-num.done { background: #1c3faa; color: #fff; }
.znp-pj .step-num.active { background: #ea580c; color: #fff; }
.znp-pj .step-num.idle { background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0; }
.znp-pj .step-label { font-size: 10.5px; font-weight: 600; color: #94a3b8; white-space: nowrap; }
.znp-pj .step-label.active { color: #ea580c; }
.znp-pj .step-label.done { color: #1c3faa; }
.znp-pj .step-line { flex: 1; height: 1px; background: #e2e8f0; margin: 0 8px; }
.znp-pj .step-line.done { background: #1c3faa; }

/* ── CLONE BANNER ── */
.znp-pj .clone-bar { background: #fff; border: 1.5px solid #D6DEFC; border-radius: 14px; padding: 16px 20px; margin-bottom: 18px; position: relative; overflow: hidden; }
.znp-pj .clone-bar-empty { border-color: #e2e8f0; background: #f8fafc; }
.znp-pj .clone-bar-empty .clone-bar-icon { background: #eef2f7; }
.znp-pj .clone-bar::before { content: ''; position: absolute; inset: 0; border-radius: 14px; border-left: 4px solid #3B5CCC; pointer-events: none; }
.znp-pj .clone-bar-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; cursor: pointer; user-select: none; }
.znp-pj .clone-bar-left { display: flex; align-items: center; gap: 10px; }
.znp-pj .clone-bar-icon { width: 34px; height: 34px; background: #EEF1FB; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.znp-pj .clone-bar-title { font-size: 13px; font-weight: 700; color: #0f172a; }
.znp-pj .clone-bar-sub { font-size: 11.5px; color: #717A96; margin-top: 1px; }
.znp-pj .clone-chevron { width: 18px; height: 18px; stroke: #94a3b8; transition: transform .25s; flex-shrink: 0; }
.znp-pj .clone-bar.open .clone-chevron { transform: rotate(180deg); }
.znp-pj .clone-body { display: none; margin-top: 14px; padding-top: 14px; border-top: 1px solid #E7EAF3; }
.znp-pj .clone-bar.open .clone-body { display: block; }
.znp-pj .clone-select-row { display: flex; gap: 10px; align-items: flex-end; }
.znp-pj .clone-sel-wrap { flex: 1; }
.znp-pj .clone-sel-label { font-size: 11px; font-weight: 700; color: #4A5068; margin-bottom: 6px; text-transform: uppercase; letter-spacing: .06em; }
.znp-pj .clone-sel { width: 100%; padding: 9px 32px 9px 12px; border: 1.5px solid #E7EAF3; border-radius: 9px; font-family: inherit; font-size: 13px; color: #2F3443; outline: none; appearance: none; background: #F7F8FC url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' fill='none' stroke='%23A0AABF' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 10px center; cursor: pointer; }
.znp-pj .clone-sel:focus { border-color: #3B5CCC; box-shadow: 0 0 0 3px rgba(59,92,204,.09); background-color: #fff; }
.znp-pj .clone-btn { padding: 9px 20px; background: #3B5CCC; color: #fff; border: none; border-radius: 9px; font-family: inherit; font-size: 13px; font-weight: 700; cursor: pointer; white-space: nowrap; display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
.znp-pj .clone-btn:hover { background: #2d47a3; }
.znp-pj .clone-btn:disabled { background: #E7EAF3; color: #A0AABF; cursor: not-allowed; }
.znp-pj .clone-preview { margin-top: 12px; background: #F7F8FC; border: 1px solid #E7EAF3; border-radius: 9px; padding: 12px 14px; display: none; }
.znp-pj .clone-preview.show { display: flex; flex-wrap: wrap; gap: 6px 14px; }
.znp-pj .cp-item { font-size: 11.5px; color: #4A5068; display: flex; align-items: center; gap: 4px; }
.znp-pj .clone-checks { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px; }
.znp-pj .clone-check-pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 11px; border: 1.5px solid #E7EAF3; border-radius: 20px; font-size: 11.5px; font-weight: 600; color: #4A5068; cursor: pointer; background: #fff; transition: all .15s; user-select: none; }
.znp-pj .clone-check-pill input { width: 13px; height: 13px; accent-color: #3B5CCC; cursor: pointer; }
.znp-pj .clone-check-pill.on { border-color: #D6DEFC; background: #EEF1FB; color: #3B5CCC; }

/* ── FRONTEND VALIDATION (red ring + inline error text + scroll target) ── */
.znp-pj .finput.has-error,
.znp-pj .fselect.has-error,
.znp-pj .ftextarea.has-error,
.znp-pj .rich-wrap.has-error,
.znp-pj .has-error > .skill-tag-row,
.znp-pj .has-error > .award-tag-row,
.znp-pj .has-error > .website-wrap,
.znp-pj .has-error .select2-selection { border-color: #ef4444 !important; box-shadow: 0 0 0 3px rgba(239,68,68,.08) !important; }
.znp-pj .field-error.live { color: #dc2626; }
.znp-pj .pj-toast { position: fixed; left: 50%; transform: translateX(-50%); bottom: 28px; z-index: 200; background: #1f2937; color: #fff; padding: 10px 18px; border-radius: 10px; font-size: 12.5px; font-weight: 600; box-shadow: 0 8px 24px rgba(15,23,42,.25); opacity: 0; transition: opacity .2s, transform .2s; pointer-events: none; }
.znp-pj .pj-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
.znp-pj .pj-toast.error { background: #b91c1c; }
.znp-pj .pj-toast.success { background: #15803d; }

/* ── PREVIEW OVERLAY (shown before final submit) ── */
.znp-pj .pj-preview-overlay { display: none; position: fixed; inset: 0; background: #f1f5f9; z-index: 1000; overflow-y: auto; padding-bottom: 100px; }
.znp-pj .pj-preview-overlay.show { display: block; }
.znp-pj .pj-preview-bar { position: sticky; top: 0; z-index: 5; background: #fff; border-bottom: 1px solid #e2e8f0; padding: 12px 22px; display: flex; align-items: center; justify-content: space-between; gap: 12px; box-shadow: 0 2px 8px rgba(15,23,42,.04); }
.znp-pj .pj-preview-bar-left { display: flex; align-items: center; gap: 12px; min-width: 0; }
.znp-pj .pj-preview-bar-divider { width: 1px; height: 30px; background: #e2e8f0; }
.znp-pj .pj-preview-bar-title { font-size: 14px; font-weight: 800; color: #0f172a; letter-spacing: -.2px; }
.znp-pj .pj-preview-bar-sub { font-size: 11.5px; color: #64748b; margin-top: 1px; }
.znp-pj .pj-preview-bar-actions { display: flex; gap: 8px; flex-wrap: wrap; }
.znp-pj .pj-preview-notice { max-width: 880px; margin: 14px auto 0; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 9px; padding: 9px 14px; font-size: 12px; color: #1e40af; display: flex; align-items: center; gap: 8px; }
.znp-pj .pj-preview-body { max-width: 880px; margin: 16px auto 0; padding: 0 22px; }
.znp-pj .pj-preview-footer { max-width: 880px; margin: 12px auto 0; padding: 16px 22px; display: flex; justify-content: flex-end; gap: 10px; flex-wrap: wrap; }
.znp-pj .pj-logo { font-size: 12.5px; font-weight: 800; letter-spacing: -.2px; }
.znp-pj .pj-la { color: #1c3faa; }
.znp-pj .pj-lb { color: #0f172a; }
.znp-pj .pj-lc { color: #ea580c; }

/* ── CONDITIONAL PANELS ── */
.znp-pj .conditional-panel { display: none; margin-top: 14px; padding: 14px 16px; background: #f8fafc; border: 1px dashed #d1dae8; border-radius: 8px; }
.znp-pj .conditional-panel.show { display: block; }
.znp-pj .cond-label { font-size: 10.5px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .07em; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }

/* ── WEBSITE FIELD (https:// prefix UI) ── */
.znp-pj .website-wrap { display: flex; align-items: stretch; border: 1px solid #d1dae8; border-radius: 7px; overflow: hidden; background: #fff; }
.znp-pj .website-prefix { padding: 0 10px; font-size: 12.5px; font-weight: 600; color: #64748b; background: #f1f5f9; border-right: 1px solid #e2e8f0; display: flex; align-items: center; white-space: nowrap; user-select: none; }
.znp-pj .website-input { flex: 1; border: none; outline: none; background: transparent; padding: 9px 12px; font-size: 12.5px; font-family: inherit; color: #0f172a; }
.znp-pj .website-wrap:focus-within { border-color: #1c3faa; box-shadow: 0 0 0 3px rgba(28,63,170,.08); }

/* ── SELECT2 OVERRIDES (inside the page only) ── */
.znp-pj .select2-container .select2-selection--multiple { min-height: 40px; border: 1px solid #d1dae8 !important; border-radius: 7px !important; padding: 3px 6px; }
.znp-pj .select2-container--default .select2-selection--multiple .select2-selection__choice { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; font-weight: 600; font-size: 11.5px; border-radius: 20px; padding: 2px 10px; }
.znp-pj .select2-container--default .select2-selection--multiple .select2-selection__choice__remove { color: #93c5fd; margin-right: 4px; }
.znp-pj .select2-container--default.select2-container--focus .select2-selection--multiple { border-color: #1c3faa !important; box-shadow: 0 0 0 3px rgba(28,63,170,.08); }

/* ── SALARY ROW ── */
.znp-pj .sal-wrap { display: flex; align-items: center; gap: 8px; }
.znp-pj .sal-wrap .finput { flex: 1; }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
    .znp-pj .fg2, .znp-pj .fg3 { grid-template-columns: 1fr; }
    .znp-pj .fspan2 { grid-column: span 1; }
    .znp-pj .check-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 560px) {
    .znp-pj .perks-grid { grid-template-columns: 1fr; }
    .znp-pj .check-grid { grid-template-columns: repeat(2, 1fr); }
    .znp-pj .pj-nav { padding: 0 16px; }
    .znp-pj .pj-pg { padding: 0 14px; }
    .znp-pj .clone-select-row { flex-direction: column; align-items: stretch; }
    .znp-pj .submit-row { flex-direction: column; align-items: stretch; }
    .znp-pj .step-label { display: none; }
    .znp-pj .step-line { margin: 0 4px; }
}
</style>
@endpush

@section('content')
<div class="znp-pj">

    {{-- ── INLINE NAV (no shared header/footer — like job-pricing) ── --}}
    <nav class="pj-nav">
        <a class="pj-logo" href="{{ route('index') }}">
            <span class="pj-la">Zero</span><span class="pj-lb">Notice</span><span class="pj-lc">Period</span>
        </a>
        <a href="{{ route('employer.dashboard.page') }}" class="pj-nb pj-nb-o">Dashboard</a>
    </nav>

    <form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" id="znpPostJobForm" novalidate>
        @csrf
        <input type="hidden" name="is_draft" id="isDraftField" value="0">

        {{-- Hidden inputs synced with rich-text contenteditable areas. --}}
        <input type="hidden" name="job_description" id="jobDescriptionField" value="{{ old('job_description') }}">
        <input type="hidden" name="job_overview"    id="jobOverviewField"    value="{{ old('job_overview') }}">

        {{-- Hidden mirror of the selected industry's display label (used by storeJobZNP for $job->industry). --}}
        <input type="hidden" name="industry" id="industryNameField" value="{{ old('industry') }}">

        {{-- Hidden custom-questions JSON (built by JS). --}}
        <input type="hidden" name="custom_questions" id="customQuestionsField" value="{{ old('custom_questions', '[]') }}">

        <div class="pj-pg">

            {{-- ── PAGE HEAD ── --}}
            <div class="pj-page-head">
                <div class="pj-page-title">{{ $pageHeading }}</div>
                <div class="pj-page-sub">{{ $pageSub }}</div>
                @if($isEdit)
                    <div class="pj-page-sub" style="margin-top:6px;font-size:12px;color:#94a3b8;">
                        Editing <span style="color:#1c3faa;font-weight:600;">{{ $job->job_title ?? '—' }}</span> · ID #{{ $job->id }}
                    </div>
                @endif
            </div>

            {{-- ── STEP INDICATOR (1 of 5) ── --}}
            <div class="steps" aria-label="Job posting progress">
                <div class="step">
                    <div class="step-num active">1</div>
                    <div class="step-label active">Job Details</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-num idle">2</div>
                    <div class="step-label">Description</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-num idle">3</div>
                    <div class="step-label">Company</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-num idle">4</div>
                    <div class="step-label">Perks</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-num idle">5</div>
                    <div class="step-label">Profile Update</div>
                </div>
            </div>

            {{-- ── CLONE BANNER (one-click: clones the latest posted job) ── --}}
            @if(!$isEdit)
            @php
                $latestJob = ($pastJobs ?? collect())->first();
                $latestLocStr = '—';
                if ($latestJob && $latestJob->location) {
                    $u = @unserialize($latestJob->location);
                    $locs = is_array($u) ? array_values($u) : [(string) $latestJob->location];
                    $latestLocStr = $locs ? implode(', ', $locs) : '—';
                }
            @endphp
            @if(!$latestJob)
            <div class="clone-bar clone-bar-empty">
                <div class="clone-bar-head" style="cursor:default;">
                    <div class="clone-bar-left">
                        <div class="clone-bar-icon">
                            <svg width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        </div>
                        <div>
                            <div class="clone-bar-title" style="color:#475569;">No previous jobs yet</div>
                            <div class="clone-bar-sub">Once you post your first job, you'll be able to clone its details in one click from here.</div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="clone-bar" id="cloneBar">
                <div class="clone-bar-head" onclick="ZnpPostJob.toggleCloneBar()">
                    <div class="clone-bar-left">
                        <div class="clone-bar-icon">
                            <svg width="16" height="16" fill="none" stroke="#3B5CCC" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        </div>
                        <div>
                            <div class="clone-bar-title">Clone from your last job</div>
                            <div class="clone-bar-sub">
                                <strong>{{ $latestJob->job_title }}</strong>
                                · {{ $latestLocStr }} · Posted {{ optional($latestJob->created_at)->format('M j, Y') }}
                            </div>
                        </div>
                    </div>
                    <svg class="clone-chevron" viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </div>

                <div class="clone-body">
                    <input type="hidden" id="cloneLatestId" value="{{ $latestJob->id }}">
                    <div class="clone-preview show" id="clonePreview">
                        <span class="cp-item">📌 {{ $latestJob->job_title }}</span>
                        <span class="cp-item">📍 {{ $latestLocStr }}</span>
                        <span class="cp-item">💼 {{ $latestJob->work_mode ?: '—' }}</span>
                        <span class="cp-item">🕒 Posted {{ optional($latestJob->created_at)->format('M j, Y') }}</span>
                    </div>

                    {{-- "Carry over" pills — choose which sections to copy from the latest job. --}}
                    <div id="cloneChecksWrap" style="display:block;">
                        <div style="font-size:11px;font-weight:700;color:#4A5068;text-transform:uppercase;letter-spacing:.06em;margin:12px 0 7px;">Carry over</div>
                        <div class="clone-checks">
                            <label class="clone-check-pill on"><input type="checkbox" data-cc="basics" checked> Role &amp; Location</label>
                            <label class="clone-check-pill on"><input type="checkbox" data-cc="salary" checked> Salary &amp; Experience</label>
                            <label class="clone-check-pill on"><input type="checkbox" data-cc="desc" checked> Job Description</label>
                            <label class="clone-check-pill on"><input type="checkbox" data-cc="eligibility" checked> Eligibility</label>
                            <label class="clone-check-pill on"><input type="checkbox" data-cc="skills" checked> Skills</label>
                            <label class="clone-check-pill"><input type="checkbox" data-cc="profile"> Profile Requirements</label>
                            <label class="clone-check-pill"><input type="checkbox" data-cc="interview"> Interview Modes</label>
                            <label class="clone-check-pill"><input type="checkbox" data-cc="perks"> Perks &amp; Awards</label>
                        </div>
                    </div>

                    <div style="margin-top:14px;display:flex;gap:8px;flex-wrap:wrap;">
                        <button class="clone-btn" type="button" onclick="ZnpPostJob.applyClone()">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            Copy details from this job
                        </button>
                    </div>
                </div>
            </div>
            @endif
            @endif {{-- !$isEdit --}}

            {{-- ════════════════════ SECTION 1 — JOB BASICS ════════════════════ --}}
            <div class="sec">
                <div class="sec-bar"></div>
                <div class="sec-title">
                    <svg width="16" height="16" fill="none" stroke="#1c3faa" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    Job Details
                </div>
                <div class="sec-sub">Core information about the role. All fields marked <span class="req">*</span> are required.</div>

                {{-- Title + Mode --}}
                <div class="fg2" style="margin-bottom:14px;">
                    <div class="field">
                        <label class="flabel">Job Title <span class="req">*</span></label>
                        <input class="finput" type="text" name="job_title" id="jobTitle" placeholder="e.g. Senior .NET Developer" value="{{ old('job_title') }}">
                        @error('job_title') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="flabel">Mode of Work <span class="req">*</span></label>
                        <select class="fselect" name="work_mode" id="workModeSelect" onchange="ZnpPostJob.onWorkModeChange(this)">
                            <option value="">— Select —</option>
                            @foreach(['Work from Office','Hybrid','Remote / WFH','Temp WFH'] as $wm)
                                <option value="{{ $wm }}" {{ old('work_mode') === $wm ? 'selected' : '' }}>{{ $wm }}</option>
                            @endforeach
                        </select>
                        @error('work_mode') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Job Type + Shift --}}
                <div class="fg2" style="margin-bottom:14px;">
                    <div class="field">
                        <label class="flabel">Job Type <span class="req">*</span></label>
                        <select class="fselect" name="job_type" id="jobTypeSelect" onchange="ZnpPostJob.onJobTypeChange(this)">
                            <option value="">— Select —</option>
                            @foreach(['Full Time / Permanent','Contract','Contract to Hire','Internship','Fresher','Part Time'] as $jt)
                                <option value="{{ $jt }}" {{ old('job_type') === $jt ? 'selected' : '' }}>{{ $jt }}</option>
                            @endforeach
                        </select>
                        @error('job_type') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="flabel">Job Shift <span class="req">*</span></label>
                        <select class="fselect" name="job_shift">
                            <option value="">— Select —</option>
                            @foreach([
                                'General Shift (9 AM – 6 PM)','Rotational Shift','US Shift (6 PM +)',
                                'UK Shift (1:30 PM +)','APAC Shift (6 AM +)','6 Days / Week','Flexible Hours'
                            ] as $sh)
                                <option value="{{ $sh }}" {{ old('job_shift') === $sh ? 'selected' : '' }}>{{ $sh }}</option>
                            @endforeach
                        </select>
                        @error('job_shift') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- CONTRACT (revealed when Contract / Contract to Hire) --}}
                <div class="conditional-panel" id="contractPanel">
                    <div class="cond-label">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                        Contract Details — required for contract postings
                    </div>
                    <div class="fg3">
                        <div class="field">
                            <label class="flabel">Contract Duration</label>
                            <select class="fselect" name="contract_duration">
                                <option value="">— Select —</option>
                                @foreach(['1 Month','2 Months','3 Months','6 Months','9 Months','12 Months','18 Months','24 Months','Open-ended'] as $cd)
                                    <option value="{{ $cd }}" {{ old('contract_duration') === $cd ? 'selected' : '' }}>{{ $cd }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label class="flabel">Day Rate (₹)</label>
                            <input class="finput" type="number" min="0" name="contract_day_rate" value="{{ old('contract_day_rate') }}" placeholder="e.g. 2500">
                            <span class="fhint">Per working day · shown to candidates</span>
                        </div>
                        <div class="field">
                            <label class="flabel">Extension Possibility</label>
                            <select class="fselect" name="contract_extension">
                                <option value="">— Select —</option>
                                @foreach(['Likely','Possible','None'] as $ce)
                                    <option value="{{ $ce }}" {{ old('contract_extension') === $ce ? 'selected' : '' }}>{{ $ce }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Salary + Openings --}}
                <div class="fg3" style="margin-top:14px;margin-bottom:14px;">
                    <div class="field">
                        <label class="flabel">Minimum Salary (LPA) <span class="req">*</span></label>
                        <input class="finput" type="number" name="min_salary" id="salMin" min="0" step="0.1" value="{{ old('min_salary') }}" placeholder="e.g. 8.5">
                        @error('min_salary') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="flabel">Maximum Salary (LPA) <span class="req">*</span></label>
                        <input class="finput" type="number" name="max_salary" id="salMax" min="0" step="0.1" value="{{ old('max_salary') }}" placeholder="e.g. 16.0">
                        @error('max_salary') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="flabel">Number of Openings <span class="req">*</span></label>
                        <input class="finput" type="number" name="no_of_openings" min="1" value="{{ old('no_of_openings', 1) }}" placeholder="e.g. 2">
                        @error('no_of_openings') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Confidential toggle --}}
                <div class="toggle-row">
                    <div class="save-toggle {{ old('compensation_confidential') ? 'on' : '' }}" id="confidentialToggle" onclick="ZnpPostJob.toggleConfidential()"><div class="save-knob"></div></div>
                    <input type="hidden" name="compensation_confidential" id="confidentialField" value="{{ old('compensation_confidential', 0) }}">
                    <div>
                        <div class="toggle-title">Keep compensation confidential</div>
                        <div class="toggle-sub">Salary range will not be shown publicly — candidates can apply and discuss in interview.</div>
                    </div>
                </div>

                {{-- Experience --}}
                <div class="fg2" style="margin-bottom:14px;">
                    <div class="field">
                        <label class="flabel">Min Experience (yrs) <span class="req">*</span></label>
                        <input class="finput" type="number" name="exp_min" id="expMin" min="0" max="40" step="0.5" value="{{ old('exp_min') }}" placeholder="e.g. 2">
                        <span class="fhint">Enter in steps of 0.5 — e.g. 1, 1.5, 2, 2.5…</span>
                        @error('exp_min') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="flabel">Max Experience (yrs)</label>
                        <input class="finput" type="number" name="exp_max" id="expMax" min="0" max="40" step="0.5" value="{{ old('exp_max') }}" placeholder="e.g. 5">
                    </div>
                </div>

                {{-- Language + Posting type --}}
                <div class="fg2" style="margin-bottom:14px;">
                    <div class="field">
                        <label class="flabel">Primary Work Language <span class="req">*</span></label>
                        <select class="fselect" name="primary_language">
                            <option value="">— Select —</option>
                            @foreach(['English','Hindi','English & Hindi','Tamil','Telugu','Kannada','Malayalam','Marathi','Bengali','Gujarati','Other'] as $lang)
                                <option value="{{ $lang }}" {{ old('primary_language') === $lang ? 'selected' : '' }}>{{ $lang }}</option>
                            @endforeach
                        </select>
                        @error('primary_language') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="flabel">Posting Type <span class="req">*</span></label>
                        <select class="fselect" name="posting_type" id="postingTypeSelect" onchange="ZnpPostJob.onPostingTypeChange(this)">
                            <option value="">— Select —</option>
                            <option value="direct" {{ old('posting_type') === 'direct' ? 'selected' : '' }}>Direct Employer</option>
                            <option value="client" {{ old('posting_type') === 'client' ? 'selected' : '' }}>Hiring for a Client</option>
                        </select>
                        <span class="fhint">Candidates will see this on the listing.</span>
                        @error('posting_type') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- CLIENT details (revealed when posting_type=client) --}}
                <div class="conditional-panel" id="clientPanel">
                    <div class="cond-label">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Client Details
                    </div>
                    <div class="fg2">
                        <div class="field">
                            <label class="flabel">Client Company Name</label>
                            <input class="finput" type="text" name="client_name" value="{{ old('client_name') }}" placeholder="e.g. Acme Corp (or leave blank to show as Confidential)">
                            <span class="fhint">Leave blank to display as "Confidential" on the listing.</span>
                        </div>
                        <div class="field">
                            <label class="flabel">Client Industry</label>
                            <select class="fselect" name="client_industry">
                                <option value="">— Select —</option>
                                @foreach(['Information Technology','Banking & Financial Services','Healthcare & Pharma','E-commerce & Retail','Manufacturing','Consulting','Other'] as $ci)
                                    <option value="{{ $ci }}" {{ old('client_industry') === $ci ? 'selected' : '' }}>{{ $ci }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Location + Locality --}}
                <div class="fg2" style="margin-top:14px;margin-bottom:14px;">
                    <div class="field">
                        <label class="flabel" id="locationLabel">Location <span class="req" id="locationReq">*</span></label>
                        <select class="form-control" name="location[]" id="locationFilter41" multiple="multiple">
                            @foreach((array) old('location', []) as $locVal)
                                <option value="{{ $locVal }}" selected>{{ $locVal }}</option>
                            @endforeach
                        </select>
                        @error('location') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="flabel">Locality / Area</label>
                        <input class="finput" type="text" name="locality" value="{{ old('locality') }}" placeholder="e.g. Andheri East">
                    </div>
                </div>

                {{-- Skills --}}
                <div class="field" style="margin-bottom:14px;">
                    <label class="flabel">Skills Required <span class="req">*</span></label>
                    <select class="form-control" name="keyskills[]" id="chooseskill" multiple="multiple">
                        @php
                            /* Prefer the rich [{id, name}] payload (edit mode + clone) so the
                               chip shows the real skill name. Fallback to bare ids from old(). */
                            $skillOpts = $prefillSkills ?? null;
                            if (!$skillOpts) {
                                $skillOpts = collect((array) old('keyskills', []))->map(function ($v) {
                                    return ['id' => $v, 'name' => $v];
                                })->all();
                            }
                        @endphp
                        @foreach($skillOpts as $sk)
                            <option value="{{ $sk['id'] }}" selected>{{ $sk['name'] }}</option>
                        @endforeach
                    </select>
                    <span class="fhint">Type a skill name. First skills are shown as primary.</span>
                    @error('keyskills') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                {{-- Interview modes --}}
                <div class="field">
                    <label class="flabel">Mode of Interview <span class="req">*</span> <span style="font-size:11px;font-weight:400;color:#94a3b8;">select multiple</span></label>
                    <div class="check-grid">
                        @php $oldInterview = (array) old('interview_modes', ['Video Interview']); @endphp
                        @foreach([
                            'CV Screening','Video Interview','Technical Assessment','HR Interview',
                            'Coding Test','Client Interview','Case Study Challenge','White Paper Challenge',
                            'Walk-in','AI Assessment','AI Interview'
                        ] as $im)
                            <label class="check-item {{ in_array($im, $oldInterview) ? 'checked' : '' }}">
                                <input type="checkbox" name="interview_modes[]" value="{{ $im }}" {{ in_array($im, $oldInterview) ? 'checked' : '' }}>
                                <span class="check-box"></span>
                                <span class="check-label">{{ $im }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ════════════════════ SECTION 2 — DESCRIPTION ════════════════════ --}}
            <div class="sec">
                <div class="sec-bar orange"></div>
                <div class="sec-title">
                    <svg width="16" height="16" fill="none" stroke="#ea580c" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    Job Description
                </div>
                <div class="sec-sub">Write clearly — candidates read this before deciding to apply.</div>

                <div class="field" style="margin-bottom:14px;">
                    <label class="flabel">Job Description <span class="req">*</span></label>
                    <div class="rich-wrap">
                        <div class="rich-toolbar">
                            <button class="rt-btn" type="button" onclick="ZnpPostJob.fmtRich('jobDesc','bold')"><b>B</b></button>
                            <button class="rt-btn" type="button" onclick="ZnpPostJob.fmtRich('jobDesc','italic')"><i>I</i></button>
                            <button class="rt-btn" type="button" onclick="ZnpPostJob.fmtRich('jobDesc','underline')"><u>U</u></button>
                            <div class="rt-div"></div>
                            <button class="rt-btn" type="button" onclick="ZnpPostJob.fmtRich('jobDesc','insertUnorderedList')">•≡</button>
                            <button class="rt-btn" type="button" onclick="ZnpPostJob.fmtRich('jobDesc','insertOrderedList')">1≡</button>
                        </div>
                        <div class="rich-area" contenteditable="true" id="jobDesc" data-ph="Write a summary of the role, key responsibilities, and what a typical day looks like…">{!! old('job_description') !!}</div>
                    </div>
                    @error('job_description') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="field" style="margin-bottom:14px;">
                    <label class="flabel">Candidate Eligibility / Overview <span class="req">*</span></label>
                    <div class="rich-wrap">
                        <div class="rich-toolbar">
                            <button class="rt-btn" type="button" onclick="ZnpPostJob.fmtRich('jobOverview','bold')"><b>B</b></button>
                            <button class="rt-btn" type="button" onclick="ZnpPostJob.fmtRich('jobOverview','italic')"><i>I</i></button>
                            <button class="rt-btn" type="button" onclick="ZnpPostJob.fmtRich('jobOverview','underline')"><u>U</u></button>
                            <div class="rt-div"></div>
                            <button class="rt-btn" type="button" onclick="ZnpPostJob.fmtRich('jobOverview','insertUnorderedList')">•≡</button>
                            <button class="rt-btn" type="button" onclick="ZnpPostJob.fmtRich('jobOverview','insertOrderedList')">1≡</button>
                        </div>
                        <div class="rich-area" contenteditable="true" id="jobOverview" data-ph="List qualifications, certifications, or education requirements…">{!! old('job_overview') !!}</div>
                    </div>
                    @error('job_overview') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- ════════════════════ SECTION 3 — COMPANY (auto-saved) ════════════════════ --}}
            <div class="sec">
                <div class="sec-bar teal"></div>
                <div class="sec-title">
                    <svg width="16" height="16" fill="none" stroke="#0ea5e9" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Company Information
                    <span class="auto-pill"><svg width='9' height='9' fill='none' stroke='#15803d' stroke-width='2.5' viewBox='0 0 12 12'><polyline points='1.5,6 4.5,9 10.5,3'/></svg> Auto-saved</span>
                </div>
                <div class="sec-sub">Helps candidates understand who they'll be joining. Saved to your profile for next time.</div>

                {{-- About --}}
                <div class="field" style="margin-bottom:14px;">
                    <label class="flabel">About the Company <span class="req">*</span></label>
                    <textarea class="ftextarea" name="about_company" placeholder="Describe your company — what you do, culture, team size, technology stack…">{{ $aboutCompany }}</textarea>
                    @error('about_company') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                {{-- Website + Industry --}}
                <div class="fg2" style="margin-bottom:14px;">
                    <div class="field">
                        <label class="flabel">Website URL <span class="req">*</span></label>
                        <div class="website-wrap">
                            <span class="website-prefix">https://www.</span>
                            <input class="website-input" type="text" id="websiteHost" value="{{ $websiteHost }}" placeholder="yourcompany.com" oninput="ZnpPostJob.syncWebsite()">
                        </div>
                        <input type="hidden" name="website_address" id="websiteAddressField" value="{{ $websiteRaw }}">
                        @error('website_address') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="flabel">Industry / Sector</label>
                        <select class="fselect" name="industry_id" id="industryIdSelect" onchange="ZnpPostJob.onIndustryChange(this)">
                            <option value="">— Select —</option>
                            @foreach($industries ?? [] as $ind)
                                <option value="{{ $ind->id }}" data-name="{{ $ind->industry }}" {{ (string) $industryIdSel === (string) $ind->id ? 'selected' : '' }}>
                                    {{ $ind->industry }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Headcount --}}
                <div class="field" style="margin-bottom:14px;">
                    <label class="flabel">Employer Headcount</label>
                    <div class="hc-row" id="headcountRow">
                        @foreach($headcountPills as $hc)
                            <div class="hc-pill {{ (string) $headcountSel === $hc ? 'sel' : '' }}" data-value="{{ $hc }}" onclick="ZnpPostJob.selectHC(this)">{{ $hc }}</div>
                        @endforeach
                    </div>
                    <input type="hidden" name="headcount" id="headcountField" value="{{ $headcountSel }}">
                </div>

                {{-- Logo --}}
                <div class="field" style="margin-bottom:14px;">
                    <label class="flabel">Company Logo</label>
                    <div class="logo-row">
                        <div class="logo-prev" id="logoPreview">
                            @if($logoUrl)
                                <img src="{{ $logoUrl }}" alt="Logo">
                            @else
                                <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            @endif
                        </div>
                        <div style="flex:1;">
                            <button type="button" class="logo-upload-btn" onclick="document.getElementById('logoFile').click()">Upload logo</button>
                            <div class="fhint" style="margin-top:4px;">PNG / JPG · Max 2MB · 400×400 recommended.</div>
                        </div>
                        <input type="file" id="logoFile" name="logo" accept="image/*" style="display:none;" onchange="ZnpPostJob.previewLogo(this)">
                    </div>
                </div>

                {{-- Office Address --}}
                <div class="field" id="officeAddrWrap" style="margin-bottom:14px;">
                    <label class="flabel" id="officeAddrLabel">
                        Office Address (India) <span class="req" id="officeAddrReq">*</span>
                    </label>
                    <input class="finput" type="text" name="office_address" id="officeAddrInput" value="{{ $officeAddr }}" placeholder="e.g. 4th Floor, Prestige Tech Park, Marathahalli, Bengaluru 560037">
                    <span class="fhint" id="officeAddrHint">Shown to candidates — helps them assess commute for WFO / Hybrid roles.</span>
                </div>

                {{-- Countries of presence --}}
                <div class="field">
                    <label class="flabel">Countries of Presence <span style="font-size:11px;font-weight:400;color:#94a3b8;">(select all that apply)</span></label>
                    <div class="award-tag-row" id="countryTags">
                        @foreach($prefillCountries as $cn)
                            @if(trim((string) $cn) !== '')
                                <span class="atag">
                                    {{ $cn }}
                                    <input type="hidden" name="countries_presence[]" value="{{ $cn }}">
                                    <span class="atag-x" onclick="ZnpPostJob.removeTag(this)">×</span>
                                </span>
                            @endif
                        @endforeach
                    </div>
                    <select class="fselect" style="margin-top:8px;" onchange="ZnpPostJob.addCountry(this)">
                        <option value="">+ Add country</option>
                        @foreach([
                            'India','United States','United Kingdom','United Arab Emirates','Singapore',
                            'Australia','Canada','Germany','Netherlands','Malaysia','Saudi Arabia',
                            'Qatar','Bahrain','Japan','South Africa','New Zealand','Other'
                        ] as $cn)
                            <option>{{ $cn }}</option>
                        @endforeach
                    </select>
                    <span class="fhint">Helps candidates understand the company's international footprint.</span>
                </div>
            </div>

            {{-- ════════════════════ SECTION 4 — AWARDS (auto-saved) ════════════════════ --}}
            <div class="sec">
                <div class="sec-bar teal"></div>
                <div class="sec-title">
                    <svg width="16" height="16" fill="none" stroke="#0369a1" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                    Employer Awards &amp; Recognition
                    <span class="auto-pill"><svg width='9' height='9' fill='none' stroke='#15803d' stroke-width='2.5' viewBox='0 0 12 12'><polyline points='1.5,6 4.5,9 10.5,3'/></svg> Auto-saved</span>
                </div>
                <div class="sec-sub">Selected certifications and awards appear as badges on your job listing — builds candidate trust instantly.</div>

                <div class="awards-wrap">
                    <div class="award-tag-row" id="awardTags">
                        @foreach($prefillAwards as $aw)
                            @if(trim((string) $aw) !== '')
                                <span class="atag">
                                    {{ $aw }}
                                    <input type="hidden" name="awards[]" value="{{ $aw }}">
                                    <span class="atag-x" onclick="ZnpPostJob.removeTag(this)">×</span>
                                </span>
                            @endif
                        @endforeach
                    </div>

                    <div class="award-add-row">
                        <select class="fselect award-select" id="awardSelect">
                            <option value="">— Add an award or certification —</option>
                            <optgroup label="Workplace & Employer Branding">
                                <option>Great Place to Work® Certification</option>
                                <option>Top Employers Institute Certification</option>
                                <option>LinkedIn Top Companies</option>
                                <option>Economic Times Best Workplace for Women</option>
                                <option>Randstad Employer Brand Research (REBR) Awards</option>
                                <option>BW People Best Employers</option>
                            </optgroup>
                            <optgroup label="Fortune & Corporate Excellence">
                                <option>Fortune India's Best Companies to Work For</option>
                                <option>The Economic Times Awards for Corporate Excellence</option>
                                <option>Golden Peacock Awards</option>
                                <option>CNBC-TV18 India Business Leader Awards (IBLA)</option>
                                <option>EY Entrepreneur Of The Year™ India</option>
                                <option>CII Industrial Innovation Awards</option>
                                <option>FICCI Quality Systems Excellence Awards</option>
                                <option>Forbes India Leadership Awards (FILA)</option>
                                <option>Business Today-Best CEO Awards</option>
                                <option>National Startup Awards (by Startup India)</option>
                                <option>DPIIT Startup India Recognition</option>
                            </optgroup>
                            <optgroup label="Sustainability, ESG & CSR">
                                <option>CII-ITC Sustainability Awards</option>
                                <option>FICCI CSR Awards</option>
                                <option>India Green Awards</option>
                                <option>Mahatma Award (for Social Impact)</option>
                                <option>National CSR Awards (Ministry of Corporate Affairs)</option>
                                <option>The Golden Globe Tigers Awards (for CSR)</option>
                                <option>Greentech Environment & Safety Awards</option>
                            </optgroup>
                            <optgroup label="Operational & ISO Certifications">
                                <option>ISO 9001 (Quality Management)</option>
                                <option>ISO 14001 (Environmental Management)</option>
                                <option>ISO 27001 (Information Security)</option>
                                <option>ISO 45001 (Occupational Health and Safety)</option>
                                <option>CMMI (Capability Maturity Model Integration)</option>
                                <option>BIS / ISI Mark (Product Quality and Safety)</option>
                                <option>ZED Certification (Zero Defect Zero Effect)</option>
                                <option>Udyam MSME Registration</option>
                                <option>FSSAI License (Food Safety)</option>
                                <option>BEE Star Rating (Energy Efficiency)</option>
                            </optgroup>
                            <optgroup label="Quality & Regional Benchmarks">
                                <option>IMC Ramkrishna Bajaj National Quality Award</option>
                                <option>National Quality Awards (NQA)</option>
                                <option>India SME 100 Awards</option>
                                <option>Deloitte Technology Fast 50 India</option>
                                <option>Karnataka Business Awards (Regional Excellence)</option>
                            </optgroup>
                        </select>
                        <button class="award-btn" type="button" onclick="ZnpPostJob.addAward()">+ Add</button>
                    </div>

                    <div class="custom-row">
                        <input class="finput" type="text" id="customAwardInput" placeholder="Can't find yours? Type a custom award name…" style="flex:1;">
                        <button class="award-btn" type="button" onclick="ZnpPostJob.addCustomAward()">+ Add Custom</button>
                    </div>
                </div>
            </div>

            {{-- ════════════════════ SECTION 5 — PERKS (auto-saved) ════════════════════ --}}
            <div class="sec">
                <div class="sec-bar purple"></div>
                <div class="sec-title">
                    <svg width="16" height="16" fill="none" stroke="#a855f7" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Employee Perks &amp; Benefits
                    <span class="auto-pill"><svg width='9' height='9' fill='none' stroke='#15803d' stroke-width='2.5' viewBox='0 0 12 12'><polyline points='1.5,6 4.5,9 10.5,3'/></svg> Auto-saved</span>
                    <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px;">select all that apply</span>
                </div>
                <div class="sec-sub">Candidates filter by perks. The more you add, the higher your visibility with matching profiles.</div>

                @php
                    $perkCategories = [
                        'Compensation & Financial' => [
                            'Annual Performance Bonus', 'Variable Pay / Incentive Programs', 'Joining Bonus',
                            'Retention Bonus', 'Employee Referral Bonus', 'ESOP / Employee Stock Options',
                            'Gratuity', 'Provident Fund (PF)',
                        ],
                        'Compensation' => [
                            'ESOPs / Stock Options', 'Quarterly Performance Payout', 'Sales / Target Incentive',
                            'Retention / Loyalty Bonus',
                        ],
                        'Health & Insurance' => [
                            'Group Health Insurance', 'Medical Insurance for Family', 'Term Life Insurance',
                            'Personal Accident Insurance', 'Mental Health & Wellness Support', 'Annual Health Check-up',
                        ],
                        'Transport & Food' => [
                            'Transportation Provision (cab / bus)', 'Petrol / Fuel Allowance',
                            'Free Food at Office', 'Subsidised / Meal Allowance',
                        ],
                        'Travel & Relocation' => [
                            'Travel Allowance / Reimbursement', 'Relocation Benefits / Assistance',
                            'LTA (Leave Travel Allowance)', 'Onsite / International Travel Opportunities',
                        ],
                        'Work & Leave' => [
                            'Flexible Work Hours', 'Work from Home Days', '5-Day Work Week',
                            'Compensatory Off (Comp-off)', 'Maternity / Paternity Leave', 'Sabbatical Leave Policy',
                        ],
                        'Growth & Learning' => [
                            'Training & Development Programs', 'Certification / Upskilling Support',
                            'Conference & Event Sponsorship', 'Education Reimbursement',
                        ],
                        'Workplace & Culture' => [
                            'Equal Opportunity Employer', 'POSH Policy (Anti-Harassment)',
                            'Employee Recognition Programs', 'Team Outings & Engagement Events',
                        ],
                    ];
                    $perkChecked = array_map('strval', $prefillPerks);
                @endphp

                @foreach($perkCategories as $cat => $perks)
                    <div class="perks-cat">{{ $cat }}</div>
                    <div class="perks-grid">
                        @foreach($perks as $p)
                            <label class="perk-item {{ in_array((string) $p, $perkChecked, true) ? 'checked' : '' }}">
                                <input type="checkbox" name="perks[]" value="{{ $p }}" {{ in_array((string) $p, $perkChecked, true) ? 'checked' : '' }}>
                                <span class="check-box"></span>
                                <span class="check-label">{{ $p }}</span>
                            </label>
                        @endforeach
                    </div>
                @endforeach

                {{-- Custom perks added via JS get appended here. --}}
                <div id="customPerksGrid" class="perks-grid"></div>

                <div class="custom-row" style="margin-top:4px;">
                    <input class="finput" type="text" id="customPerkInput" placeholder="Add a custom benefit your company offers…" style="flex:1;">
                    <button class="award-btn purple" type="button" onclick="ZnpPostJob.addCustomPerk()">+ Add Custom</button>
                </div>
            </div>

            {{-- ════════════════════ SECTION 6 — QUESTIONNAIRE ════════════════════ --}}
            <div class="sec">
                <div class="sec-bar green"></div>
                <div class="sec-title">
                    <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Mandatory Questionnaire
                    <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px;">shown to every candidate before they apply</span>
                </div>
                <div class="sec-sub">Q1 and Q2 are presented to every applicant; the optional video link can be toggled off.</div>

                <div class="q-list">
                    <div class="q-row">
                        <div class="q-num">1</div>
                        <div class="q-body">
                            <div class="q-title">How many years of experience do you have relevant to this role?</div>
                            <div class="q-desc">Candidate states specific experience for this role — distinguishes total experience from relevant.</div>
                            <div class="q-type-row">
                                <span class="q-type-badge qt-number">Number</span>
                                <span class="q-required yes">Required</span>
                            </div>
                            <div class="q-toggle-wrap">
                                <div class="q-toggle" style="cursor:default;opacity:.7;" title="Always enabled"><div class="save-knob"></div></div>
                                <span class="q-toggle-label">Always enabled — required for all applicants</span>
                            </div>
                        </div>
                    </div>

                    <div class="q-row">
                        <div class="q-num">2</div>
                        <div class="q-body">
                            <div class="q-title">Why should we hire you?</div>
                            <div class="q-desc">Short open-text answer (max 300 characters) — a quick litmus test for motivation and communication.</div>
                            <div class="q-type-row">
                                <span class="q-type-badge qt-text">Text (300 chars)</span>
                                <span class="q-required yes">Required</span>
                            </div>
                            <div class="q-toggle-wrap">
                                <div class="q-toggle" style="cursor:default;opacity:.7;" title="Always enabled"><div class="save-knob"></div></div>
                                <span class="q-toggle-label">Always enabled — mandatory for all applicants</span>
                            </div>
                        </div>
                    </div>

                    <div class="q-row">
                        <div class="q-num">3</div>
                        <div class="q-body">
                            <div class="q-title">Share a link to your video introduction <span style="font-size:11px;font-weight:500;color:#94a3b8;">(Optional)</span></div>
                            <div class="q-desc">Candidates can paste any public link (Loom, YouTube unlisted, Drive). Toggle off if you don't want this.</div>
                            <div class="q-type-row">
                                <span class="q-type-badge qt-text">URL / Link</span>
                                <span class="q-required" id="videoQRequired">Not mandatory</span>
                            </div>
                            <div class="q-toggle-wrap">
                                <input type="hidden" name="q_video_enabled" id="qVideoEnabledField" value="{{ old('q_video_enabled', 1) }}">
                                <div class="q-toggle {{ (int) old('q_video_enabled', 1) === 0 ? 'off' : '' }}" id="qVideoToggle" onclick="ZnpPostJob.toggleVideoQ()"><div class="save-knob"></div></div>
                                <span class="q-toggle-label" id="qVideoLabel">{{ (int) old('q_video_enabled', 1) === 0 ? 'Question disabled — click to enable' : 'Question enabled — applicants can share a link' }}</span>
                            </div>
                        </div>
                    </div>

                    <div id="customQuestionsList"></div>
                </div>

                <div class="q-add-row">
                    <button class="q-add-btn" type="button" onclick="ZnpPostJob.toggleCustomQ()">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                        Add a custom question
                    </button>
                </div>

                <div id="customQWrap" style="display:none;margin-top:10px;">
                    <div class="fg2">
                        <input class="finput" type="text" id="customQText" placeholder="e.g. Do you have a valid passport?">
                        <select class="fselect" id="customQType">
                            <option value="text">Text answer</option>
                            <option value="yesno">Yes / No</option>
                            <option value="number">Number</option>
                        </select>
                    </div>
                    <div style="display:flex;gap:8px;margin-top:8px;">
                        <button class="award-btn" type="button" onclick="ZnpPostJob.saveCustomQ()">Add Question</button>
                        <button class="save-draft" type="button" onclick="ZnpPostJob.toggleCustomQ()">Cancel</button>
                    </div>
                </div>
            </div>

            {{-- ════════════════════ SECTION 7 — PROFILE REQUIREMENTS ════════════════════ --}}
            <div class="sec">
                <div class="sec-bar indigo"></div>
                <div class="sec-title">
                    <svg width="16" height="16" fill="none" stroke="#6366f1" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Candidate Profile Requirements
                    <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px;">candidates must confirm these before applying</span>
                </div>
                <div class="sec-sub">Select the profile fields candidates must verify and update before submitting their application.</div>

                @php
                    $profileReqs = [
                        'Current CTC','Expected CTC','Notice Period','Current Location',
                        'Preferred Work Mode','Total Years of Experience','Resume / CV (updated)',
                        'LinkedIn Profile URL','Highest Qualification','Preferred Job Location',
                    ];
                    $oldProfileReqs = (array) old('profile_requirements', ['Expected CTC','Notice Period','Current Location']);
                @endphp

                <div class="check-grid col2">
                    @foreach($profileReqs as $pr)
                        <label class="check-item {{ in_array($pr, $oldProfileReqs) ? 'checked' : '' }}">
                            <input type="checkbox" name="profile_requirements[]" value="{{ $pr }}" {{ in_array($pr, $oldProfileReqs) ? 'checked' : '' }}>
                            <span class="check-box"></span>
                            <span class="check-label">{{ $pr }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="toggle-row" style="margin-top:12px;margin-bottom:0;">
                    <div class="save-toggle {{ (int) old('strict_mode', 0) === 1 ? 'on' : '' }}" id="strictModeToggle" onclick="ZnpPostJob.toggleStrict()"><div class="save-knob"></div></div>
                    <input type="hidden" name="strict_mode" id="strictModeField" value="{{ old('strict_mode', 0) }}">
                    <div>
                        <div class="toggle-title">Strict mode <span id="strictModeStatus" style="font-weight:600;color:{{ (int) old('strict_mode', 0) === 1 ? '#1c3faa' : '#94a3b8' }};">— {{ (int) old('strict_mode', 0) === 1 ? 'On' : 'Off' }}</span></div>
                        <div class="toggle-sub" id="strictModeDesc">{{ (int) old('strict_mode', 0) === 1 ? 'Candidates must complete every selected field — no skipping.' : 'Candidates can skip required profile fields with a warning.' }}</div>
                    </div>
                </div>
            </div>

            {{-- ════════════════════ SUBMIT ════════════════════ --}}
            <div class="submit-row">
                <div class="sr-left">
                    <div class="save-info">
                        <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 12 12"><polyline points="1.5,6 4.5,9 10.5,3"/></svg>
                        <div>
                            <div class="save-info-title">Auto-save enabled</div>
                            <div class="save-info-sub">Company info, awards &amp; perks are saved for future job posts.</div>
                        </div>
                    </div>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    @if(!$isEdit)
                        <button class="save-draft" type="button" onclick="ZnpPostJob.saveDraft()">Save as Draft</button>
                    @endif
                    <button class="submit-btn" type="button" onclick="ZnpPostJob.showPreview()">
                        <svg width="14" height="14" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        {{ $submitButtonLabel }} →
                    </button>
                </div>
            </div>

        </div>{{-- /pj-pg --}}
    </form>

    {{-- ── PREVIEW OVERLAY (shown before final submit) ── --}}
    <div id="pjPreviewOverlay" class="pj-preview-overlay" aria-hidden="true">
        <div class="pj-preview-bar">
            <div class="pj-preview-bar-left">
                <div class="pj-logo" aria-hidden="true">
                    <span class="pj-la">Zero</span><span class="pj-lb">Notice</span><span class="pj-lc">Period</span>
                </div>
                <div class="pj-preview-bar-divider"></div>
                <div>
                    <div class="pj-preview-bar-title">Job Preview</div>
                    <div class="pj-preview-bar-sub">This is how your posting will appear to candidates.</div>
                </div>
            </div>
            <div class="pj-preview-bar-actions">
                <button type="button" class="save-draft" onclick="ZnpPostJob.closePreview()">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-right:5px;vertical-align:-1px;"><polyline points="15 18 9 12 15 6"/></svg>
                    Back to editing
                </button>
                <button type="button" class="submit-btn" onclick="ZnpPostJob.confirmPost()">
                    <svg width="14" height="14" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $isEdit ? 'Confirm & Update Job' : 'Confirm & Post Job' }}
                </button>
            </div>
        </div>
        <div class="pj-preview-notice">
            <svg width="15" height="15" fill="none" stroke="#1c3faa" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>Review all details below. When you're satisfied, click <strong>{{ $isEdit ? 'Confirm & Update Job' : 'Confirm & Post Job' }}</strong> to {{ $isEdit ? 'save your changes' : 'publish' }}.</span>
        </div>
        <div class="pj-preview-body" id="pjPreviewBody"></div>
        <div class="pj-preview-footer">
            <button type="button" class="save-draft" onclick="ZnpPostJob.closePreview()">← Back to editing</button>
            <button type="button" class="submit-btn" onclick="ZnpPostJob.confirmPost()">
                <svg width="14" height="14" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ $isEdit ? 'Confirm & Update Job' : 'Confirm & Post Job' }} →
            </button>
        </div>
    </div>

    {{-- Floating toast for client-side validation feedback. --}}
    <div class="pj-toast" id="pjToast" role="status" aria-live="polite"></div>
</div>{{-- /znp-pj --}}

{{-- Past jobs JSON (used by the clone banner — no extra endpoint required). --}}
<script type="application/json" id="znpPastJobsJson">{!! json_encode($cloneJobsPayload ?? [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endsection

@push('scripts')
<script src="{{ asset('asset/script/select2.full.min.js') }}"></script>
<script>
(function () {
    'use strict';

    var pastJobs = {};
    try {
        pastJobs = JSON.parse(document.getElementById('znpPastJobsJson').textContent || '{}');
    } catch (e) { pastJobs = {}; }

    window.ZnpPostJob = {

        /* ───────── Tag-row helpers ───────── */
        removeTag: function (x) {
            var tag = x.closest('.atag');
            if (tag) tag.remove();
        },

        /* ───────── Countries of presence ───────── */
        addCountry: function (sel) {
            var val = sel.value;
            if (!val) return;
            var row = document.getElementById('countryTags');
            var existing = Array.prototype.slice.call(row.querySelectorAll('.atag input')).map(function (i) { return i.value; });
            if (existing.indexOf(val) === -1) {
                var span = document.createElement('span');
                span.className = 'atag';
                span.innerHTML = val + '<input type="hidden" name="countries_presence[]" value="' + val.replace(/"/g, '&quot;') + '"><span class="atag-x" onclick="ZnpPostJob.removeTag(this)">×</span>';
                row.appendChild(span);
            }
            sel.value = '';
        },

        /* ───────── Awards ───────── */
        addAward: function () {
            var sel = document.getElementById('awardSelect');
            if (!sel.value) return;
            this._addAwardTag(sel.value);
            sel.value = '';
        },
        addCustomAward: function () {
            var inp = document.getElementById('customAwardInput');
            var val = inp.value.trim();
            if (!val) return;
            this._addAwardTag(val);
            inp.value = '';
        },
        _addAwardTag: function (val) {
            var row = document.getElementById('awardTags');
            var existing = Array.prototype.slice.call(row.querySelectorAll('.atag input')).map(function (i) { return i.value; });
            if (existing.indexOf(val) !== -1) return;
            var span = document.createElement('span');
            span.className = 'atag';
            span.innerHTML = val + '<input type="hidden" name="awards[]" value="' + val.replace(/"/g, '&quot;') + '"><span class="atag-x" onclick="ZnpPostJob.removeTag(this)">×</span>';
            row.appendChild(span);
        },

        /* ───────── Custom perks ───────── */
        addCustomPerk: function () {
            var inp = document.getElementById('customPerkInput');
            var val = inp.value.trim();
            if (!val) return;
            var grid = document.getElementById('customPerksGrid');
            var label = document.createElement('label');
            label.className = 'perk-item checked';
            label.innerHTML = '<input type="checkbox" name="perks[]" value="' + val.replace(/"/g, '&quot;') + '" checked><span class="check-box"></span><span class="check-label">' + val + '</span>';
            grid.appendChild(label);
            inp.value = '';
        },

        /* ───────── Conditional panels ───────── */
        onJobTypeChange: function (sel) {
            var v = sel.value;
            var show = v === 'Contract' || v === 'Contract to Hire';
            document.getElementById('contractPanel').classList.toggle('show', show);
        },
        onPostingTypeChange: function (sel) {
            document.getElementById('clientPanel').classList.toggle('show', sel.value === 'client');
        },
        onWorkModeChange: function (sel) {
            var v = sel.value;
            var remote = (v === 'Remote / WFH');
            var wrap = document.getElementById('officeAddrWrap');
            var req = document.getElementById('officeAddrReq');
            var hint = document.getElementById('officeAddrHint');
            if (wrap) {
                wrap.style.opacity = remote ? '.55' : '1';
                wrap.style.pointerEvents = remote ? 'none' : '';
                if (req)  req.style.display  = remote ? 'none' : '';
                if (hint) hint.textContent   = remote
                    ? 'Not required for fully remote roles.'
                    : 'Shown to candidates — helps them assess commute for WFO / Hybrid roles.';
            }
            /* Location is required when work_mode is anything other than Remote/WFH. */
            var locReq = document.getElementById('locationReq');
            if (locReq) locReq.style.display = remote ? 'none' : '';
        },

        /* ───────── Headcount pills ───────── */
        selectHC: function (el) {
            Array.prototype.forEach.call(document.querySelectorAll('#headcountRow .hc-pill'), function (p) {
                p.classList.remove('sel');
            });
            el.classList.add('sel');
            document.getElementById('headcountField').value = el.getAttribute('data-value') || '';
        },

        /* ───────── Industry — sync hidden display name ───────── */
        onIndustryChange: function (sel) {
            var opt = sel.options[sel.selectedIndex];
            var name = opt ? (opt.getAttribute('data-name') || opt.text || '') : '';
            document.getElementById('industryNameField').value = name;
        },

        /* ───────── Website prefix UI ───────── */
        syncWebsite: function () {
            var host = (document.getElementById('websiteHost').value || '').trim();
            host = host.replace(/^https?:\/\/(www\.)?/i, '');
            document.getElementById('websiteAddressField').value = host ? 'https://www.' + host : '';
        },

        /* ───────── Confidential / Strict / Video toggles ───────── */
        toggleConfidential: function () {
            var t = document.getElementById('confidentialToggle');
            t.classList.toggle('on');
            document.getElementById('confidentialField').value = t.classList.contains('on') ? 1 : 0;
        },
        toggleStrict: function () {
            var t = document.getElementById('strictModeToggle');
            t.classList.toggle('on');
            var on = t.classList.contains('on');
            document.getElementById('strictModeField').value = on ? 1 : 0;
            var status = document.getElementById('strictModeStatus');
            var desc   = document.getElementById('strictModeDesc');
            if (status) { status.textContent = '— ' + (on ? 'On' : 'Off'); status.style.color = on ? '#1c3faa' : '#94a3b8'; }
            if (desc)   { desc.textContent   = on ? 'Candidates must complete every selected field — no skipping.' : 'Candidates can skip required profile fields with a warning.'; }
        },
        toggleVideoQ: function () {
            var t = document.getElementById('qVideoToggle');
            t.classList.toggle('off');
            var enabled = !t.classList.contains('off');
            document.getElementById('qVideoEnabledField').value = enabled ? 1 : 0;
            var lbl = document.getElementById('qVideoLabel');
            if (lbl) lbl.textContent = enabled ? 'Question enabled — applicants can share a link' : 'Question disabled — click to enable';
        },

        /* ───────── Logo preview ───────── */
        previewLogo: function (input) {
            if (!input.files || !input.files[0]) return;
            var reader = new FileReader();
            reader.onload = function (e) {
                var prev = document.getElementById('logoPreview');
                prev.innerHTML = '<img src="' + e.target.result + '" alt="Logo">';
            };
            reader.readAsDataURL(input.files[0]);
        },

        /* ───────── Rich-text ───────── */
        fmtRich: function (areaId, cmd) {
            var area = document.getElementById(areaId);
            if (!area) return;
            area.focus();
            try { document.execCommand(cmd, false, null); } catch (e) {}
        },
        _syncRich: function () {
            var desc = document.getElementById('jobDesc');
            var ovr  = document.getElementById('jobOverview');
            document.getElementById('jobDescriptionField').value = desc ? desc.innerHTML.trim() : '';
            document.getElementById('jobOverviewField').value    = ovr  ? ovr.innerHTML.trim()  : '';
        },

        /* ───────── Custom questions ───────── */
        toggleCustomQ: function () {
            var w = document.getElementById('customQWrap');
            w.style.display = w.style.display === 'none' ? 'block' : 'none';
        },
        _customQs: [],
        saveCustomQ: function () {
            var text = document.getElementById('customQText').value.trim();
            var type = document.getElementById('customQType').value;
            if (!text) return;
            this._customQs.push({ label: text, type: type });
            this._renderCustomQs();
            document.getElementById('customQText').value = '';
            document.getElementById('customQWrap').style.display = 'none';
        },
        removeCustomQ: function (idx) {
            this._customQs.splice(idx, 1);
            this._renderCustomQs();
        },
        _renderCustomQs: function () {
            var typeLabels = { text: 'Text', yesno: 'Yes / No', number: 'Number' };
            var list = document.getElementById('customQuestionsList');
            list.innerHTML = '';
            var base = 4;
            this._customQs.forEach(function (q, idx) {
                var row = document.createElement('div');
                row.className = 'q-row';
                row.innerHTML =
                    '<div class="q-num">' + (base + idx) + '</div>' +
                    '<div class="q-body">' +
                        '<div class="q-title">' + q.label + '</div>' +
                        '<div class="q-type-row">' +
                            '<span class="q-type-badge qt-text">' + (typeLabels[q.type] || 'Text') + '</span>' +
                            '<span class="q-required yes">Required</span>' +
                        '</div>' +
                        '<div class="q-toggle-wrap">' +
                            '<button type="button" class="save-draft" style="padding:5px 12px;font-size:11.5px;" onclick="ZnpPostJob.removeCustomQ(' + idx + ')">Remove</button>' +
                        '</div>' +
                    '</div>';
                list.appendChild(row);
            });
            document.getElementById('customQuestionsField').value = JSON.stringify(this._customQs);
        },

        /* ───────── Clone banner ───────── */
        toggleCloneBar: function () {
            var bar = document.getElementById('cloneBar');
            if (bar) bar.classList.toggle('open');
        },
        applyClone: function () {
            /* One-click clone — always uses the latest posted job (id rendered server-side). */
            var idEl = document.getElementById('cloneLatestId');
            var key  = idEl ? idEl.value : '';
            if (!key || !pastJobs[key]) {
                ZnpPostJob.toast('No previous job found to clone from.', 'error');
                return;
            }
            var job = pastJobs[key];

            /* Carry-over flags from the pills (default: all on if pills missing). */
            var flags = { basics:true, salary:true, desc:true, eligibility:true, skills:true, profile:false, interview:false, perks:false };
            document.querySelectorAll('.znp-pj .clone-check-pill input[type="checkbox"]').forEach(function (cb) {
                var k = cb.getAttribute('data-cc');
                if (k) flags[k] = !!cb.checked;
            });

            var setVal = function (id, v) {
                var el = document.getElementById(id);
                if (el && v !== undefined && v !== null && v !== '') el.value = v;
            };
            var setByName = function (name, v) {
                var el = document.querySelector('[name="' + name + '"]');
                if (!el || v === undefined || v === null || v === '') return;
                if (el.tagName === 'SELECT') {
                    Array.prototype.forEach.call(el.options, function (o) {
                        if (o.value && String(o.value).toLowerCase() === String(v).toLowerCase()) el.value = o.value;
                    });
                } else {
                    el.value = v;
                }
            };

            setVal('jobTitle', job.job_title);

            /* ── Role & Location ── */
            if (flags.basics) {
                setByName('work_mode', job.work_mode);
                ZnpPostJob.onWorkModeChange(document.getElementById('workModeSelect'));
                setByName('job_type', job.job_type);
                ZnpPostJob.onJobTypeChange(document.getElementById('jobTypeSelect'));
                setByName('job_shift', job.job_shift);
                setByName('contract_duration', job.contract_duration);
                setByName('contract_day_rate', job.contract_day_rate);
                setByName('contract_extension', job.contract_extension);
                setByName('no_of_openings', job.no_of_openings);
                setByName('primary_language', job.primary_language);
                setByName('posting_type', job.posting_type);
                ZnpPostJob.onPostingTypeChange(document.getElementById('postingTypeSelect'));
                setByName('client_name', job.client_name);
                setByName('client_industry', job.client_industry);
                setByName('locality', job.locality);

                if (job.location && window.jQuery) {
                    var $loc = jQuery('#locationFilter41');
                    $loc.val(null).trigger('change');
                    (Array.isArray(job.location) ? job.location : [job.location]).forEach(function (l) {
                        if (!l) return;
                        if ($loc.find('option[value="' + l + '"]').length === 0) {
                            $loc.append(new Option(l, l, true, true));
                        }
                    });
                    $loc.trigger('change');
                }
            }

            /* ── Salary & Experience ── */
            if (flags.salary) {
                setVal('salMin', job.min_salary);
                setVal('salMax', job.max_salary);
                if (job.compensation_confidential) {
                    document.getElementById('confidentialToggle').classList.add('on');
                    document.getElementById('confidentialField').value = '1';
                }
                setVal('expMin', job.exp_min);
                setVal('expMax', job.exp_max);
            }

            /* ── Skills ──
               Payload is [{id, name}, ...]; we append by id and label with name. */
            if (flags.skills && Array.isArray(job.keyskills) && window.jQuery) {
                var $sk = jQuery('#chooseskill');
                $sk.val(null).trigger('change');
                job.keyskills.forEach(function (s) {
                    /* Accept legacy payload (bare id) as well as new {id,name} shape. */
                    var id   = (s && typeof s === 'object') ? s.id   : s;
                    var name = (s && typeof s === 'object') ? s.name : String(s);
                    if (!id) return;
                    if ($sk.find('option[value="' + id + '"]').length === 0) {
                        $sk.append(new Option(name || ('Skill #' + id), id, true, true));
                    } else {
                        $sk.find('option[value="' + id + '"]').prop('selected', true);
                    }
                });
                $sk.trigger('change');
            }

            /* ── Profile Requirements (Candidate must confirm) ── */
            if (flags.profile && Array.isArray(job.profile_requirements)) {
                var wanted = new Set(job.profile_requirements);
                document.querySelectorAll('input[name="profile_requirements[]"]').forEach(function (cb) {
                    var on = wanted.has(cb.value);
                    cb.checked = on;
                    var item = cb.closest('.check-item, .perk-item');
                    if (item) item.classList.toggle('checked', on);
                });
            }

            /* ── Interview Modes ── */
            if (flags.interview && job.interview_modes) {
                document.querySelectorAll('input[name="interview_modes[]"]').forEach(function (cb) {
                    var on = job.interview_modes.indexOf(cb.value) !== -1;
                    cb.checked = on;
                    var item = cb.closest('.check-item');
                    if (item) item.classList.toggle('checked', on);
                });
            }

            /* ── Job Description ── */
            if (flags.desc) {
                var desc = document.getElementById('jobDesc');
                if (desc && job.job_description) desc.innerHTML = job.job_description;
            }

            /* ── Eligibility ── */
            if (flags.eligibility) {
                var ovr  = document.getElementById('jobOverview');
                if (ovr && job.job_overview) ovr.innerHTML = job.job_overview;
            }

            /* ── Perks & Awards ── */
            if (flags.perks) {
                if (job.perks) {
                    document.querySelectorAll('input[name="perks[]"]').forEach(function (cb) {
                        var on = job.perks.indexOf(cb.value) !== -1;
                        cb.checked = on;
                        var item = cb.closest('.perk-item');
                        if (item) item.classList.toggle('checked', on);
                    });
                }
                if (job.awards) {
                    var awardRow = document.getElementById('awardTags');
                    if (awardRow) awardRow.innerHTML = '';
                    job.awards.forEach(function (a) { if (a) ZnpPostJob._addAwardTag(a); });
                }
            }

            ZnpPostJob._syncRich();
            document.getElementById('cloneBar').classList.remove('open');
            ZnpPostJob.toast('Cloned details applied.', 'success');
        },

        /* ───────── Toast helper ───────── */
        _toastTimer: null,
        toast: function (msg, kind) {
            var el = document.getElementById('pjToast');
            if (!el) return;
            el.textContent = msg;
            el.className = 'pj-toast show ' + (kind || '');
            clearTimeout(ZnpPostJob._toastTimer);
            ZnpPostJob._toastTimer = setTimeout(function () {
                el.className = 'pj-toast';
            }, 3200);
        },

        /* ───────── Validation engine ───────── */
        _markError: function (el, msg) {
            if (!el) return;
            el.classList.add('has-error');
            /* Find/create an inline message next to the field. */
            var field = el.closest('.field') || el.parentNode;
            if (!field) return;
            var hint = field.querySelector('.field-error.live');
            if (!hint) {
                hint = document.createElement('span');
                hint.className = 'field-error live';
                field.appendChild(hint);
            }
            hint.textContent = msg;
            hint.style.display = 'block';
        },
        clearValidation: function () {
            document.querySelectorAll('.znp-pj .has-error').forEach(function (el) { el.classList.remove('has-error'); });
            document.querySelectorAll('.znp-pj .field-error.live').forEach(function (el) { el.remove(); });
        },
        _validateForm: function () {
            ZnpPostJob.clearValidation();
            var errors = [];

            var byId = function (id) { return document.getElementById(id); };
            var require = function (el, msg) {
                if (!el) return;
                var val = (el.value == null ? '' : String(el.value)).trim();
                if (!val) { ZnpPostJob._markError(el, msg); errors.push(el); }
            };

            /* Section 1 — Job Basics. */
            require(byId('jobTitle'),         'Job title is required');
            require(byId('workModeSelect'),   'Please select a mode of work');
            require(byId('jobTypeSelect'),    'Please select a job type');
            require(document.querySelector('[name="job_shift"]'),       'Please select a job shift');
            require(byId('salMin'),           'Minimum salary is required');
            require(byId('salMax'),           'Maximum salary is required');
            require(document.querySelector('[name="no_of_openings"]'),  'Number of openings is required');
            require(byId('expMin'),           'Minimum experience is required');
            require(document.querySelector('[name="primary_language"]'),'Primary work language is required');
            require(document.querySelector('[name="posting_type"]'),    'Please select a posting type');

            /* Number range checks. */
            var min = parseFloat(byId('salMin').value);
            var max = parseFloat(byId('salMax').value);
            if (!isNaN(min) && !isNaN(max) && max <= min) {
                ZnpPostJob._markError(byId('salMax'), 'Maximum salary must be greater than minimum');
                errors.push(byId('salMax'));
            }
            var eMin = parseFloat(byId('expMin').value);
            var eMax = parseFloat(byId('expMax').value);
            if (!isNaN(eMin) && !isNaN(eMax) && eMax < eMin) {
                ZnpPostJob._markError(byId('expMax'), 'Maximum experience must be ≥ minimum');
                errors.push(byId('expMax'));
            }

            /* Contract conditional fields. */
            var jt = byId('jobTypeSelect').value;
            if (jt === 'Contract' || jt === 'Contract to Hire') {
                require(document.querySelector('[name="contract_duration"]'), 'Contract duration is required');
            }

            /* Client conditional — name required only if "Hiring for a Client". */
            var pt = document.querySelector('[name="posting_type"]');
            if (pt && pt.value === 'client') {
                /* Client name optional in the design (shows "Confidential"); industry is the gate. */
                require(document.querySelector('[name="client_industry"]'), 'Client industry is required');
            }

            /* Location — required for everything except Remote / WFH. */
            var wm = byId('workModeSelect').value;
            if (wm && wm !== 'Remote / WFH') {
                var locSel = byId('locationFilter41');
                var locVals = locSel ? Array.prototype.filter.call(locSel.selectedOptions || [], function () { return true; }) : [];
                /* Select2 may not populate selectedOptions; fall back to <option selected>. */
                if (locSel && (!locVals || locVals.length === 0)) {
                    locVals = Array.prototype.filter.call(locSel.querySelectorAll('option[selected], option:checked'), function () { return true; });
                }
                if (!locSel || locVals.length === 0) {
                    var locField = locSel ? locSel.closest('.field') : null;
                    if (locField) locField.classList.add('has-error');
                    ZnpPostJob._markError(locSel, 'Add at least one location');
                    errors.push(locSel);
                }
            }

            /* Skills — at least 1. */
            var skSel = byId('chooseskill');
            var skVals = skSel ? Array.prototype.filter.call(skSel.selectedOptions || [], function () { return true; }) : [];
            if (skSel && (!skVals || skVals.length === 0)) {
                skVals = Array.prototype.filter.call(skSel.querySelectorAll('option[selected], option:checked'), function () { return true; });
            }
            if (!skSel || skVals.length === 0) {
                var skField = skSel ? skSel.closest('.field') : null;
                if (skField) skField.classList.add('has-error');
                ZnpPostJob._markError(skSel, 'Add at least one required skill');
                errors.push(skSel);
            }

            /* Interview modes — at least 1. */
            var anyMode = document.querySelector('input[name="interview_modes[]"]:checked');
            if (!anyMode) {
                var modeGrid = document.getElementById('interviewModes');
                if (modeGrid) {
                    var modeField = modeGrid.closest('.field') || modeGrid;
                    modeField.classList.add('has-error');
                    ZnpPostJob._markError(modeField, 'Select at least one interview mode');
                }
                errors.push(modeGrid);
            }

            /* Section 2 — Description + Eligibility. */
            ZnpPostJob._syncRich();
            var descVal = (byId('jobDescriptionField').value || '').replace(/<[^>]+>/g, '').trim();
            if (!descVal) {
                var descWrap = byId('jobDesc') && byId('jobDesc').closest('.rich-wrap');
                if (descWrap) descWrap.classList.add('has-error');
                ZnpPostJob._markError(descWrap, 'Job description is required');
                errors.push(descWrap);
            }
            var ovrVal = (byId('jobOverviewField').value || '').replace(/<[^>]+>/g, '').trim();
            if (!ovrVal) {
                var ovrWrap = byId('jobOverview') && byId('jobOverview').closest('.rich-wrap');
                if (ovrWrap) ovrWrap.classList.add('has-error');
                ZnpPostJob._markError(ovrWrap, 'Candidate eligibility is required');
                errors.push(ovrWrap);
            }

            /* Section 3 — Company. */
            require(document.querySelector('[name="about_company"]'), 'About the company is required');
            var webHost = (byId('websiteHost').value || '').trim();
            if (!webHost) {
                ZnpPostJob._markError(byId('websiteHost'), 'Website URL is required');
                errors.push(byId('websiteHost'));
            }

            /* Office address required for WFO / Hybrid / Temp WFH. */
            if (wm && wm !== 'Remote / WFH') {
                var addrEl = document.querySelector('[name="office_address"]');
                if (addrEl && !addrEl.value.trim()) {
                    ZnpPostJob._markError(addrEl, 'Office address is required for this work mode');
                    errors.push(addrEl);
                }
            }

            return errors;
        },

        /* ───────── Preview before submit ───────── */
        showPreview: function () {
            /* Sync hidden fields, then validate before opening the preview. */
            ZnpPostJob._syncRich();
            ZnpPostJob.syncWebsite();
            var sel = document.getElementById('industryIdSelect');
            if (sel) ZnpPostJob.onIndustryChange(sel);

            var errors = ZnpPostJob._validateForm();
            if (errors.length) {
                var first = document.querySelector('.znp-pj .has-error');
                if (first && first.scrollIntoView) first.scrollIntoView({behavior:'smooth', block:'center'});
                var focusable = first && first.querySelector ? first.querySelector('input,select,textarea,[contenteditable]') : null;
                if (focusable && focusable.focus) focusable.focus();
                ZnpPostJob.toast('Please fix ' + errors.length + ' field' + (errors.length > 1 ? 's' : '') + ' before previewing.', 'error');
                return;
            }

            document.getElementById('pjPreviewBody').innerHTML = ZnpPostJob._buildPreviewHTML();
            var overlay = document.getElementById('pjPreviewOverlay');
            overlay.classList.add('show');
            overlay.setAttribute('aria-hidden', 'false');
            overlay.scrollTop = 0;
            document.body.style.overflow = 'hidden';
        },
        closePreview: function () {
            var overlay = document.getElementById('pjPreviewOverlay');
            overlay.classList.remove('show');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        },
        confirmPost: function () {
            /* Final submit after the user has reviewed the preview. Re-sync and
               re-validate so programmatic submit cannot bypass client checks. */
            if (!ZnpPostJob.beforeSubmit()) {
                ZnpPostJob.closePreview();
                return;
            }
            document.getElementById('isDraftField').value = '0';
            document.getElementById('znpPostJobForm').submit();
        },
        _buildPreviewHTML: function () {
            var $ = function (id) { return document.getElementById(id); };
            var v = function (id) { var el = $(id); return el ? (el.value || '').trim() : ''; };
            var esc = function (s) {
                return String(s == null ? '' : s)
                    .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
            };

            var title     = v('jobTitle') || 'Untitled role';
            var locations = [];
            var locField  = document.querySelector('[name="location[]"]');
            if (locField && locField.tagName === 'SELECT') {
                Array.prototype.forEach.call(locField.selectedOptions, function (o) {
                    var t = (o.text || o.value || '').trim();
                    if (t) locations.push(t);
                });
            }
            var locality  = v('locality');
            var locStr    = (locality ? locality + ', ' : '') + (locations.join(', ') || '—');

            var workMode    = (document.getElementById('workModeSelect') || {}).value || '—';
            var jobType     = (document.getElementById('jobTypeSelect')  || {}).value || '—';
            var shift       = (document.querySelector('[name="job_shift"]') || {}).value || '';

            var salMin      = v('salMin');
            var salMax      = v('salMax');
            var salRange    = (salMin || salMax)
                              ? ('₹' + (salMin || '—') + ' – ₹' + (salMax || '—') + ' LPA')
                              : '—';
            var expMin      = v('expMin');
            var expMax      = v('expMax');
            var expRange    = (expMin || expMax)
                              ? ((expMin || '0') + ' – ' + (expMax || '—') + ' yrs')
                              : '—';

            /* Skills + Awards (tags) */
            var skills = [];
            document.querySelectorAll('#skillTags .stag, #skillTags .skill-tag').forEach(function (s) {
                var t = (s.childNodes[0] && s.childNodes[0].textContent || s.textContent || '').trim();
                if (t) skills.push(t.replace(/×$/, '').trim());
            });
            var awards = [];
            document.querySelectorAll('#awardTags .atag, #awardTags .award-tag').forEach(function (a) {
                var t = (a.childNodes[0] && a.childNodes[0].textContent || a.textContent || '').trim();
                if (t) awards.push(t.replace(/×$/, '').trim());
            });

            /* Perks + interview modes (checked labels) */
            var perks = [];
            document.querySelectorAll('.znp-pj .perk-item input[type="checkbox"]:checked').forEach(function (cb) {
                var label = cb.closest('label');
                var lbl   = label && label.querySelector('.check-label, .perk-label');
                if (lbl) perks.push(lbl.textContent.trim());
            });
            var interviewModes = [];
            document.querySelectorAll('#interviewModes .check-item input[type="checkbox"]:checked').forEach(function (cb) {
                var label = cb.closest('label');
                var lbl   = label && label.querySelector('.check-label');
                if (lbl) interviewModes.push(lbl.textContent.trim());
            });

            /* Rich fields */
            var desc      = ($('jobDesc')     && $('jobDesc').innerHTML)     || '';
            var elig      = ($('eligibility') && $('eligibility').innerHTML) || '';
            var aboutCo   = v('aboutCompany');
            var industry  = (document.querySelector('[name="industry"]') || {}).value || '';
            var headcount = (document.querySelector('[name="headcount"]') || {}).value || '';

            var badge = function (txt, color, bg, border) {
                return '<span style="display:inline-flex;align-items:center;font-size:11.5px;font-weight:600;padding:3px 12px;border-radius:20px;border:1px solid ' + border + ';color:' + color + ';background:' + bg + ';margin:3px;">' + esc(txt) + '</span>';
            };
            var awardBadges = awards.map(function (a) { return badge(a, '#0369a1', '#f0f9ff', '#bae6fd'); }).join('');
            var skillBadges = skills.map(function (s) { return badge(s, '#1e40af', '#eff6ff', '#bfdbfe'); }).join('');
            var perkBadges  = perks.map(function (p)  { return badge('✓ ' + p, '#7e22ce', '#faf5ff', '#d8b4fe'); }).join('');
            var modeBadges  = interviewModes.map(function (m) { return badge(m, '#334155', '#f8fafc', '#e2e8f0'); }).join('');

            var metaRow = function (label, val) {
                return '<div style="display:flex;gap:8px;padding:9px 0;border-bottom:0.5px solid #f1f5f9;font-size:12.5px;"><span style="color:#94a3b8;font-weight:600;min-width:160px;flex-shrink:0;">' + esc(label) + '</span><span style="color:#0f172a;font-weight:500;">' + esc(val) + '</span></div>';
            };

            return [
                /* Hero card */
                '<div style="background:#fff;border:0.5px solid #d1dae8;border-radius:12px;overflow:hidden;margin-bottom:16px;">',
                  '<div style="height:5px;background:linear-gradient(90deg,#1c3faa,#3b82f6);"></div>',
                  '<div style="padding:24px 28px 20px;">',
                    '<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;gap:16px;">',
                      '<div>',
                        '<div style="font-size:22px;font-weight:800;color:#0f172a;margin-bottom:10px;letter-spacing:-.3px;">', esc(title), '</div>',
                        '<div style="display:flex;flex-wrap:wrap;gap:8px;">',
                          '<span style="display:inline-flex;align-items:center;gap:5px;background:#eff6ff;border:0.5px solid #bfdbfe;border-radius:20px;padding:5px 14px;font-size:11.5px;color:#1e40af;font-weight:600;">📍 ', esc(locStr), '</span>',
                          '<span style="display:inline-flex;align-items:center;gap:5px;background:#f0fdf4;border:0.5px solid #bbf7d0;border-radius:20px;padding:5px 14px;font-size:11.5px;color:#15803d;font-weight:600;">💰 ', esc(salRange), '</span>',
                          '<span style="display:inline-flex;align-items:center;gap:5px;background:#faf5ff;border:0.5px solid #d8b4fe;border-radius:20px;padding:5px 14px;font-size:11.5px;color:#7e22ce;font-weight:600;">🏢 ', esc(workMode), '</span>',
                        '</div>',
                      '</div>',
                    '</div>',
                    awards.length ? '<div style="display:flex;flex-wrap:wrap;gap:6px;padding:12px 0;border-top:0.5px solid #e8eef5;border-bottom:0.5px solid #e8eef5;margin-bottom:14px;">' + awardBadges + '</div>' : '',
                    '<div style="font-size:12px;color:#64748b;">Verified candidates only · Immediate joiners &amp; serving notice</div>',
                  '</div>',
                '</div>',

                /* Role overview */
                '<div style="background:#fff;border:0.5px solid #d1dae8;border-radius:12px;padding:22px 26px;margin-bottom:14px;">',
                  '<div style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:14px;">Role Overview</div>',
                  metaRow('Job Type', jobType),
                  shift ? metaRow('Shift', shift) : '',
                  metaRow('Salary Range', salRange),
                  metaRow('Experience', expRange),
                  metaRow('Location', locStr),
                  metaRow('Mode of Work', workMode),
                '</div>',

                /* Skills */
                skillBadges ? '<div style="background:#fff;border:0.5px solid #d1dae8;border-radius:12px;padding:22px 26px;margin-bottom:14px;"><div style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:12px;">Key Skills</div><div style="display:flex;flex-wrap:wrap;gap:6px;">' + skillBadges + '</div></div>' : '',

                /* Description */
                '<div style="background:#fff;border:0.5px solid #d1dae8;border-radius:12px;padding:22px 26px;margin-bottom:14px;"><div style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:12px;">Job Description</div><div style="font-size:13px;color:#334155;line-height:1.8;">', (desc || '<em style="color:#94a3b8;">No description provided.</em>'), '</div></div>',

                /* Eligibility */
                '<div style="background:#fff;border:0.5px solid #d1dae8;border-radius:12px;padding:22px 26px;margin-bottom:14px;"><div style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:12px;">Candidate Eligibility</div><div style="font-size:13px;color:#334155;line-height:1.8;">', (elig || '<em style="color:#94a3b8;">No eligibility criteria provided.</em>'), '</div></div>',

                /* Interview process */
                interviewModes.length ? '<div style="background:#fff;border:0.5px solid #d1dae8;border-radius:12px;padding:22px 26px;margin-bottom:14px;"><div style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:12px;">Interview Process</div><div style="display:flex;flex-wrap:wrap;gap:6px;">' + modeBadges + '</div></div>' : '',

                /* Perks */
                perks.length ? '<div style="background:#fff;border:0.5px solid #d1dae8;border-radius:12px;padding:22px 26px;margin-bottom:14px;"><div style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:12px;">Perks &amp; Benefits</div><div style="display:flex;flex-wrap:wrap;gap:6px;">' + perkBadges + '</div></div>' : '',

                /* About company */
                aboutCo ? '<div style="background:#fff;border:0.5px solid #d1dae8;border-radius:12px;padding:22px 26px;margin-bottom:14px;"><div style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:6px;">About the Company</div>' + (industry ? '<div style="font-size:11.5px;color:#64748b;margin-bottom:10px;">' + esc(industry) + (headcount ? ' · ' + esc(headcount) : '') + '</div>' : '') + '<div style="font-size:13px;color:#334155;line-height:1.8;">' + esc(aboutCo) + '</div></div>' : ''
            ].join('');
        },

        /* ───────── Submit handling ───────── */
        saveDraft: function () {
            ZnpPostJob._syncRich();
            ZnpPostJob.syncWebsite();
            var sel = document.getElementById('industryIdSelect');
            if (sel) ZnpPostJob.onIndustryChange(sel);

            var title = (document.getElementById('jobTitle').value || '').trim();
            if (!title) {
                ZnpPostJob.clearValidation();
                ZnpPostJob._markError(document.getElementById('jobTitle'), 'Add a job title to save the draft');
                document.getElementById('jobTitle').scrollIntoView({behavior:'smooth', block:'center'});
                ZnpPostJob.toast('Add a job title to save a draft.', 'error');
                return false;
            }
            document.getElementById('isDraftField').value = '1';
            document.getElementById('znpPostJobForm').submit();
        },
        beforeSubmit: function (ev) {
            /* Always sync before validation so rich fields are evaluated. */
            ZnpPostJob._syncRich();
            ZnpPostJob.syncWebsite();
            var sel = document.getElementById('industryIdSelect');
            if (sel) ZnpPostJob.onIndustryChange(sel);

            var errors = ZnpPostJob._validateForm();
            if (errors.length) {
                if (ev && ev.preventDefault) ev.preventDefault();
                var first = document.querySelector('.znp-pj .has-error');
                if (first && first.scrollIntoView) first.scrollIntoView({behavior:'smooth', block:'center'});
                var focusable = first && first.querySelector ? first.querySelector('input,select,textarea,[contenteditable]') : null;
                if (focusable && focusable.focus) focusable.focus();
                ZnpPostJob.toast('Please fix ' + errors.length + ' field' + (errors.length > 1 ? 's' : '') + ' marked in red.', 'error');
                return false;
            }
            return true;
        }
    };

    /* ───────── Generic check-item toggling for native <label> checkboxes ─────────
       (Interview modes, profile-requirements, perks all use <label class="check-item|perk-item">
       wrapping a hidden <input type="checkbox">. We sync the .checked class.) */
    function bindCheckToggles() {
        var checkboxes = document.querySelectorAll('.znp-pj .check-item input[type="checkbox"], .znp-pj .perk-item input[type="checkbox"]');
        Array.prototype.forEach.call(checkboxes, function (cb) {
            cb.addEventListener('change', function () {
                var label = cb.closest('label');
                if (label) label.classList.toggle('checked', cb.checked);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        bindCheckToggles();

        /* Trigger conditional panels for restored old-input values. */
        var jt = document.getElementById('jobTypeSelect');
        var pt = document.getElementById('postingTypeSelect');
        var wm = document.getElementById('workModeSelect');
        if (jt) ZnpPostJob.onJobTypeChange(jt);
        if (pt) ZnpPostJob.onPostingTypeChange(pt);
        if (wm) ZnpPostJob.onWorkModeChange(wm);

        /* Mirror industry name once on load. */
        var ind = document.getElementById('industryIdSelect');
        if (ind) ZnpPostJob.onIndustryChange(ind);

        /* Sync hidden website on load (handles old input + prefill). */
        ZnpPostJob.syncWebsite();

        /* Restore custom questions from old() if present. */
        try {
            var rawCQ = document.getElementById('customQuestionsField').value || '[]';
            var parsed = JSON.parse(rawCQ);
            if (Array.isArray(parsed) && parsed.length) {
                ZnpPostJob._customQs = parsed;
                ZnpPostJob._renderCustomQs();
            }
        } catch (e) {}

        /* Validate + sync on every submit (real Post Job button — drafts bypass). */
        var form = document.getElementById('znpPostJobForm');
        if (form) {
            form.addEventListener('submit', function (ev) {
                var isDraft = document.getElementById('isDraftField').value === '1';
                ZnpPostJob._syncRich();
                ZnpPostJob.syncWebsite();
                if (!isDraft) {
                    var errors = ZnpPostJob._validateForm();
                    if (errors.length) {
                        ev.preventDefault();
                        var first = document.querySelector('.znp-pj .has-error');
                        if (first && first.scrollIntoView) first.scrollIntoView({behavior:'smooth', block:'center'});
                        ZnpPostJob.toast('Please fix ' + errors.length + ' field' + (errors.length > 1 ? 's' : '') + ' marked in red.', 'error');
                        return false;
                    }
                }
            });
        }

        /* Clear an inline error on a field as soon as the user starts fixing it. */
        document.addEventListener('input', function (e) {
            var t = e.target;
            if (!t || !t.classList) return;
            if (t.classList.contains('has-error')) {
                t.classList.remove('has-error');
                var wrap = t.closest('.field');
                if (wrap) {
                    var hint = wrap.querySelector('.field-error.live');
                    if (hint) hint.remove();
                }
            }
        }, true);

        /* "Carry over" pill styling — toggle .on as checkboxes change. */
        document.querySelectorAll('.znp-pj .clone-check-pill input[type="checkbox"]').forEach(function (cb) {
            cb.addEventListener('change', function () {
                var pill = cb.closest('.clone-check-pill');
                if (pill) pill.classList.toggle('on', cb.checked);
            });
        });

        /* ── Select2: skills + locations (same endpoints as legacy post-job) ── */
        if (window.jQuery && jQuery.fn && jQuery.fn.select2) {
            jQuery('#chooseskill').select2({
                tags: true,
                tokenSeparators: [','],
                placeholder: 'Add a skill or technology',
                minimumInputLength: 1,
                ajax: {
                    url: "{{ url('search-skills') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) { return { q: params.term }; },
                    processResults: function (data) {
                        return {
                            results: jQuery.map(data, function (skill) {
                                return { id: skill.id, text: skill.job_skill };
                            })
                        };
                    },
                    cache: true
                }
            });

            jQuery('#locationFilter41').select2({
                tags: true,
                tokenSeparators: [','],
                placeholder: 'Add a city / location',
                minimumInputLength: 1,
                ajax: {
                    url: "{{ url('autocomplete/search-location-job') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) { return { q: params.term }; },
                    processResults: function (data) {
                        return {
                            results: jQuery.map(data, function (loc) {
                                return { id: loc.location, text: loc.location };
                            })
                        };
                    },
                    cache: true
                }
            });
        }
    });
})();
</script>
@endpush
