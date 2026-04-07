@extends('layouts.znp')

@push('styles')
<style>
/* ── ZNP JOBSEEKER-AUTH: SCOPE & RESET ── */
.znp-jobseeker-auth,
.znp-jobseeker-auth * {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}
.znp-jobseeker-auth { background: var(--bg); color: var(--text); font-size: 12px; }
.znp-jobseeker-auth .form-content { flex: 1; }
.znp-jobseeker-auth a   { color: inherit; text-decoration: none; }
.znp-jobseeker-auth p   { margin: 0; }
.znp-jobseeker-auth ul  { list-style: none; padding: 0; margin: 0; }
.znp-jobseeker-auth button { font-family: inherit !important; }

/* ── MAIN CONTENT WRAPPER ── */
.znp-jobseeker-auth {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
}

/* ── AUTH CONTAINER ── */
.znp-jobseeker-auth .auth-container {
    width: 100%;
    max-width: 960px;
    display: grid;
    grid-template-columns: 360px 1fr;
    background: var(--white);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    overflow: hidden;
}

/* ── LEFT INFO PANEL ── */
.znp-jobseeker-auth .info-panel {
    background: linear-gradient(135deg, #1a3faa 0%, #152f85 100%);
    padding: 28px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}
.znp-jobseeker-auth .info-panel::before {
    content: '';
    position: absolute;
    top: -100px; right: -100px;
    width: 300px; height: 300px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}
.znp-jobseeker-auth .info-panel::after {
    content: '';
    position: absolute;
    bottom: -120px; left: -80px;
    width: 280px; height: 280px;
    background: rgba(249,115,22,0.15);
    border-radius: 50%;
}
.znp-jobseeker-auth .info-content { position: relative; z-index: 1; }
.znp-jobseeker-auth .logo-section { margin-bottom: 20px; }
.znp-jobseeker-auth .logo-section .logo-text {
    font-size: 14px !important; font-weight: 800 !important; color: var(--white);
    display: flex; flex-wrap: wrap; line-height: 1.3;
}
.znp-jobseeker-auth .logo-section .logo-orange { color: var(--orange) !important; }
.znp-jobseeker-auth .info-headline {
    font-size: 16px !important; font-weight: 600 !important; color: var(--white) !important;
    line-height: 1.3; margin-bottom: 8px; letter-spacing: -0.3px;
}
.znp-jobseeker-auth .info-headline .highlight { color: var(--orange) !important; }
.znp-jobseeker-auth .info-desc {
    font-size: 10px !important; color: rgba(255,255,255,0.9) !important;
    line-height: 1.5; margin-bottom: 16px;
}
.znp-jobseeker-auth .info-features { display: flex; flex-direction: column; gap: 8px; }
.znp-jobseeker-auth .feature-item { display: flex; align-items: flex-start; gap: 8px; }
.znp-jobseeker-auth .feature-icon {
    width: 24px; height: 24px;
    background: rgba(255,255,255,0.15);
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.znp-jobseeker-auth .feature-icon svg { width: 12px !important; height: 12px !important; stroke: var(--white) !important; }
.znp-jobseeker-auth .feature-text { flex: 1; }
.znp-jobseeker-auth .feature-title {
    font-size: 10px !important; font-weight: 700 !important; color: var(--white) !important; margin-bottom: 1px;
}
.znp-jobseeker-auth .feature-desc { font-size: 9px !important; color: rgba(255,255,255,0.8) !important; line-height: 1.4; }

/* Roles carousel */
.znp-jobseeker-auth .info-stats { position: relative; z-index: 1; margin-top: 10px; overflow: hidden; }
.znp-jobseeker-auth .roles-carousel {
    display: flex; flex-direction: column; gap: 6px; position: relative;
}
.znp-jobseeker-auth .roles-carousel::before,
.znp-jobseeker-auth .roles-carousel::after {
    content: ''; position: absolute; top: 0; bottom: 0; width: 30px; z-index: 2; pointer-events: none;
}
.znp-jobseeker-auth .roles-carousel::before {
    left: 0;
    background: linear-gradient(to right, #152f85 0%, transparent 100%);
}
.znp-jobseeker-auth .roles-carousel::after {
    right: 0;
    background: linear-gradient(to left, #152f85 0%, transparent 100%);
}
.znp-jobseeker-auth .rc-row {
    display: flex; gap: 6px; width: max-content;
    animation: jsa-scrollLeft 20s linear infinite;
}
.znp-jobseeker-auth .rc-row.reverse { animation: jsa-scrollRight 16s linear infinite; }
@keyframes jsa-scrollLeft {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
@keyframes jsa-scrollRight {
    0%   { transform: translateX(-50%); }
    100% { transform: translateX(0); }
}
.znp-jobseeker-auth .roles-carousel:hover .rc-row { animation-play-state: paused; }
.znp-jobseeker-auth .rc-pill {
    display: inline-flex; align-items: center; white-space: nowrap;
    border-radius: 100px; cursor: default; transition: all 0.2s;
    line-height: 1; font-size: 9px !important; padding: 4px 10px;
}
.znp-jobseeker-auth .rc-pill:hover { transform: scale(1.05); }
.znp-jobseeker-auth .rc-pill.bold  { background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.22); color: #fff !important; font-weight: 700 !important; }
.znp-jobseeker-auth .rc-pill.light { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.55) !important; font-weight: 400 !important; }
.znp-jobseeker-auth .rc-pill.ghost { background: transparent; border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.28) !important; font-weight: 400 !important; }
.znp-jobseeker-auth .rc-pill.accent{ background: rgba(249,115,22,0.18); border: 1px solid rgba(249,115,22,0.5); color: #ffb07a !important; font-weight: 700 !important; }
.znp-jobseeker-auth .rc-pill .pulse {
    width: 4px; height: 4px; border-radius: 50%;
    background: #4ade80; display: inline-block; margin-right: 4px;
    animation: jsa-rcpulse 2s ease-in-out infinite; flex-shrink: 0;
}
@keyframes jsa-rcpulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50%      { opacity: 0.35; transform: scale(0.7); }
}
.znp-jobseeker-auth .rc-label {
    font-size: 8px !important; font-weight: 700 !important; color: var(--orange) !important;
    text-transform: uppercase; letter-spacing: 0.08em;
    text-align: center; margin-bottom: 8px; opacity: 0.9;
}

/* ── RIGHT FORM PANEL ── */
.znp-jobseeker-auth .form-panel {
    padding: 36px 42px;
    display: flex; flex-direction: column;
    background: var(--white);
}
/* Fixed panel height so Sign-In and Sign-Up tabs never resize the card. */
.znp-jobseeker-auth .form-panel {
    min-height: 500px;
    overflow-y: auto;
}
.znp-jobseeker-auth .tab-switcher {
    display: flex; background: #f3f4f8;
    border-radius: 10px; padding: 3px;
    /* margin-bottom: 20px; */
}
.znp-jobseeker-auth .tab-btn {
    flex: 1; padding: 10px 16px;
    border: 2px solid rgba(26,90,203,0.18);
    background: transparent; color: var(--text-muted);
    font-size: 13px !important; font-weight: 700 !important; border-radius: 8px;
    cursor: pointer; transition: all 0.2s;
}
.znp-jobseeker-auth .tab-btn.active {
    background: var(--white); color: var(--blue) !important;
    box-shadow: 0 1px 2px rgba(0,0,0,0.08);
    border-color: #cbdeff;
}
.znp-jobseeker-auth .tab-btn:hover:not(.active) { color: var(--text) !important; }
.znp-jobseeker-auth .tab-btn:focus { outline: none; box-shadow: 0 0 0 2px rgba(26,63,170,0.08); }
.znp-jobseeker-auth .tab-btn.active:focus { border-color: #cbdeff; }
.znp-jobseeker-auth .form-title {
    font-size: 20px !important; font-weight: 800 !important; color: var(--text) !important;
    margin-bottom: 6px; letter-spacing: -0.5px;
}
.znp-jobseeker-auth .form-subtitle {
    font-size: 12px !important; color: var(--text-muted) !important;
    line-height: 1.6;
}
/* Both sections stack in the same grid cell so card height = tallest section always.
   opacity+z-index toggling is GPU-composited: zero layout reflow, zero flash. */
.znp-jobseeker-auth .form-sections-stack { display: grid; }
.znp-jobseeker-auth .form-sections-stack > .form-section {
    grid-row: 1; grid-column: 1;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    z-index: 0;
    transition: none !important;
    background: var(--white);
}
.znp-jobseeker-auth .form-sections-stack > .form-section.active {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    z-index: 1;
}

/* Progress bar */
.znp-jobseeker-auth .znp-step-bar {
    display: flex; align-items: center; gap: 8px; margin-bottom: 20px;
}
.znp-jobseeker-auth .znp-step-seg {
    height: 3px; flex: 1; background: var(--border);
    border-radius: 2px; transition: background 0.3s;
}
.znp-jobseeker-auth .znp-step-seg.active { background: var(--blue); }
.znp-jobseeker-auth .znp-step-label {
    font-size: 11px !important; color: var(--text-muted) !important; font-weight: 600 !important;
    text-align: center; margin-top: 6px;
}

/* Form elements */
.znp-jobseeker-auth .form-group { margin-bottom: 14px; }
.znp-jobseeker-auth .form-label {
    display: block; font-size: 12px !important; font-weight: 600 !important;
    color: var(--text) !important; margin-bottom: 5px;
}
.znp-jobseeker-auth .required { color: #dc2626 !important; margin-left: 2px; }
/* ── Validation error state ── */
.znp-jobseeker-auth .form-input.is-invalid,
.znp-jobseeker-auth .form-select.is-invalid {
    border-color: #dc2626 !important;
    box-shadow: 0 0 0 3px rgba(220,38,38,0.1);
}
.znp-jobseeker-auth .znp-fe-err,
.znp-jobseeker-auth .field-error {
    display: block;
    color: #dc2626 !important;
    font-size: 11px !important;
    margin-top: 4px;
    line-height: 1.4;
}
.znp-jobseeker-auth .form-input,
.znp-jobseeker-auth .form-select {
    width: 100%; padding: 10px 12px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: 13px !important; color: var(--text) !important;
    background: var(--white); transition: all 0.2s; outline: none;
}
.znp-jobseeker-auth .form-input:focus,
.znp-jobseeker-auth .form-select:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 4px rgba(26,63,170,0.08);
}
.znp-jobseeker-auth .form-input::placeholder { color: var(--text-light) !important; }
.znp-jobseeker-auth .form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center;
    padding-right: 40px; cursor: pointer;
}
.znp-jobseeker-auth .form-row {
    display: grid; grid-template-columns: 1fr 1fr; gap: 12px;
}
.znp-jobseeker-auth .input-with-icon { position: relative; }
.znp-jobseeker-auth .input-icon-left {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: var(--text-light); width: 14px; height: 14px; pointer-events: none;
}
.znp-jobseeker-auth .input-with-icon .form-input { padding-left: 38px; }
.znp-jobseeker-auth .password-toggle {
    position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
    background: none; border: none; color: var(--text-light);
    cursor: pointer; padding: 4px; display: flex; align-items: center; justify-content: center; transition: color 0.2s;
}
.znp-jobseeker-auth .password-toggle:hover { color: var(--text-muted); }
.znp-jobseeker-auth .password-toggle svg { width: 18px !important; height: 18px !important; }
.znp-jobseeker-auth .form-options {
    display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;
}
.znp-jobseeker-auth .checkbox-label {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px !important; color: var(--text-muted) !important; cursor: pointer;
}
.znp-jobseeker-auth .checkbox-label input[type="checkbox"] {
    width: 14px; height: 14px; accent-color: var(--blue); cursor: pointer;
}
.znp-jobseeker-auth .forgot-link {
    font-size: 12px !important; font-weight: 600 !important; color: var(--blue) !important;
    text-decoration: none; transition: color 0.2s;
}
.znp-jobseeker-auth .forgot-link:hover { color: var(--blue-dark) !important; text-decoration: underline; }
.znp-jobseeker-auth .btn-primary {
    width: 100%; padding: 11px 20px;
    background: var(--blue); border: none; border-radius: 8px;
    color: var(--white) !important; font-size: 13px !important; font-weight: 700 !important;
    cursor: pointer; transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(26,63,170,0.2);
}
.znp-jobseeker-auth .btn-primary:hover {
    background: var(--blue-dark);
    box-shadow: 0 6px 16px rgba(26,63,170,0.3); transform: translateY(-1px);
}
.znp-jobseeker-auth .btn-secondary {
    width: 100%; padding: 11px 20px;
    background: transparent; border: 1.5px solid var(--border);
    border-radius: 8px; color: var(--text) !important; font-size: 13px !important; font-weight: 700 !important;
    cursor: pointer; transition: all 0.2s;
}
.znp-jobseeker-auth .btn-secondary:hover {
    border-color: var(--blue); color: var(--blue) !important; background: #f0f5ff;
}
.znp-jobseeker-auth .step-nav { display: flex; gap: 10px; margin-top: 18px; }
.znp-jobseeker-auth .step-nav .btn-secondary { flex: 0 0 100px; }
.znp-jobseeker-auth .step-nav .btn-primary  { flex: 1; }
.znp-jobseeker-auth .alt-action {
    text-align: center; font-size: 12px !important; color: var(--text-muted) !important; margin-top: 18px;
}
.znp-jobseeker-auth .alt-action a {
    color: var(--blue) !important; font-weight: 600 !important; text-decoration: none; cursor: pointer;
}
.znp-jobseeker-auth .alt-action a:hover { text-decoration: underline; }

/* ── Alerts ── */
.znp-jobseeker-auth .znp-alert {
    padding: 10px 14px; border-radius: 8px;
    font-size: 12px !important; margin-bottom: 16px;
    display: flex; align-items: flex-start; gap: 8px;
}
.znp-jobseeker-auth .znp-alert-error  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626 !important; }
.znp-jobseeker-auth .znp-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a !important; }

/* File upload */
.znp-jobseeker-auth .file-upload { position: relative; }
.znp-jobseeker-auth .file-upload-label {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    padding: 10px 16px; border: 2px dashed var(--border); border-radius: 8px;
    background: #fafafa; cursor: pointer; transition: all 0.2s;
    font-size: 12px !important; font-weight: 600 !important; color: var(--text-muted) !important;
}
.znp-jobseeker-auth .file-upload-label:hover {
    border-color: var(--blue); background: #f0f5ff; color: var(--blue) !important;
}
.znp-jobseeker-auth .file-upload-label svg { width: 14px !important; height: 14px !important; }
.znp-jobseeker-auth .file-upload input[type="file"] { position: absolute; opacity: 0; width: 0; height: 0; }
.znp-jobseeker-auth .file-name {
    font-size: 11px !important; color: var(--text-muted) !important; margin-top: 5px; font-style: italic;
}

/* Checkbox group */
.znp-jobseeker-auth .checkbox-group { display: flex; flex-direction: column; gap: 10px; margin-bottom: 18px; }
.znp-jobseeker-auth .checkbox-item {
    display: flex; align-items: flex-start; gap: 8px;
    font-size: 11px !important; color: var(--text-muted) !important; line-height: 1.6; cursor: pointer;
}
.znp-jobseeker-auth .checkbox-item input[type="checkbox"] {
    margin-top: 2px; width: 14px; height: 14px;
    accent-color: var(--blue); cursor: pointer; flex-shrink: 0;
}
.znp-jobseeker-auth .checkbox-item a { color: var(--blue) !important; font-weight: 600 !important; text-decoration: none; }
.znp-jobseeker-auth .checkbox-item a:hover { text-decoration: underline; }

/* Skills input */
.znp-jobseeker-auth .skills-tags {
    display: flex; flex-wrap: wrap; gap: 6px;
    padding: 8px 12px; border: 1.5px solid var(--border);
    border-radius: 8px; min-height: 44px; cursor: text;
    background: var(--white); transition: border 0.2s;
}
.znp-jobseeker-auth .skills-tags:focus-within {
    border-color: var(--blue); box-shadow: 0 0 0 4px rgba(26,63,170,0.08);
}
.znp-jobseeker-auth .skill-tag {
    display: inline-flex; align-items: center; gap: 4px;
    background: #eef2ff; border: 1px solid #c7d2fe;
    color: var(--blue) !important; border-radius: 100px;
    padding: 2px 8px; font-size: 11px !important; font-weight: 600 !important;
}
.znp-jobseeker-auth .skill-tag button {
    background: none; border: none; color: var(--blue);
    cursor: pointer; font-size: 13px; line-height: 1; padding: 0; opacity: 0.6;
}
.znp-jobseeker-auth .skill-tag button:hover { opacity: 1; }
.znp-jobseeker-auth .skills-text-input {
    border: none; outline: none; font-size: 12px !important;
    color: var(--text) !important; min-width: 140px; flex: 1; background: transparent;
}
.znp-jobseeker-auth .skills-text-input::placeholder { color: var(--text-light) !important; }
.znp-jobseeker-auth .skills-hint { font-size: 10px !important; color: var(--text-muted) !important; margin-top: 4px; }
.znp-jobseeker-auth .skills-error {
    font-size: 10px !important; color: #dc2626 !important; font-weight: 600 !important; margin-top: 4px; display: none;
}

/* City chips */
.znp-jobseeker-auth .cities-wrap { display: flex; flex-wrap: wrap; gap: 6px; }
.znp-jobseeker-auth .city-chip {
    display: inline-flex; align-items: center; gap: 4px;
    border: 1.5px solid var(--border); border-radius: 100px;
    padding: 5px 12px; font-size: 11px !important; font-weight: 600 !important;
    cursor: pointer; color: var(--text-muted) !important; background: var(--white); transition: all 0.15s;
}
.znp-jobseeker-auth .city-chip:hover { border-color: var(--blue); color: var(--blue) !important; }
.znp-jobseeker-auth .city-chip.selected {
    background: #eef2ff; border-color: var(--blue); color: var(--blue) !important;
}
.znp-jobseeker-auth .city-chip.selected::before { content: '✓ '; }

/* Notice date field (conditionally shown) */
.znp-jobseeker-auth .nop-date-field { display: none; margin-top: 8px; }
.znp-jobseeker-auth .nop-date-field.visible { display: block; }

/* Responsive */
@media (max-width: 968px) {
    .znp-jobseeker-auth .auth-container { grid-template-columns: 1fr; }
    .znp-jobseeker-auth .info-panel { display: none; }
    .znp-jobseeker-auth .form-panel { padding: 40px 32px; }
}
@media (max-width: 640px) {
    .znp-jobseeker-auth { padding: 0; }
    .znp-jobseeker-auth .auth-container { border-radius: 0; box-shadow: none; }
    .znp-jobseeker-auth .form-panel { padding: 32px 24px; }
    .znp-jobseeker-auth .form-row { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
@include('znp.header')

<main class="znp-jobseeker-auth">
  <div class="auth-container">

    {{-- ── LEFT INFO PANEL ── --}}
    <div class="info-panel">
      <div class="info-content">
        <div class="logo-section">
          <span class="logo-text">
            <span class="logo-blue">Zero</span><span class="logo-orange">Notice</span>Period
          </span>
        </div>

        <div class="info-headline">
          Find jobs you can <span class="highlight">join immediately</span>
        </div>
        <p class="info-desc">
          We connect candidates who are on zero notice period or serving notice with companies that need to hire fast. No wait, no fuss.
        </p>

        <div class="info-features">
          <div class="feature-item">
            <div class="feature-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
            </div>
            <div class="feature-text">
              <div class="feature-title">Instant Matching</div>
              <div class="feature-desc">Get matched with employers looking for immediate joiners</div>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="feature-text">
              <div class="feature-title">Verified Employers</div>
              <div class="feature-desc">All companies on our platform are verified and genuine</div>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="feature-text">
              <div class="feature-title">Privacy First</div>
              <div class="feature-desc">Control who can see your CV — hide from current/past employers</div>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div class="feature-text">
              <div class="feature-title">Free for Jobseekers</div>
              <div class="feature-desc">100% free to register, apply and get placed</div>
            </div>
          </div>
        </div>
      </div>

      {{-- Roles Carousel --}}
      <div class="info-stats">
        <div class="rc-label">🟢 Actively Hiring Roles</div>
        <div class="roles-carousel">
          <div class="rc-row">
            <span class="rc-pill accent"><span class="pulse"></span>Software Engineer</span>
            <span class="rc-pill bold">Product Manager</span>
            <span class="rc-pill light">Data Analyst</span>
            <span class="rc-pill bold">Business Analyst</span>
            <span class="rc-pill accent"><span class="pulse"></span>React Developer</span>
            <span class="rc-pill light">HR Generalist</span>
            <span class="rc-pill bold">DevOps Engineer</span>
            <span class="rc-pill accent"><span class="pulse"></span>Software Engineer</span>
            <span class="rc-pill bold">Product Manager</span>
            <span class="rc-pill light">Data Analyst</span>
            <span class="rc-pill bold">Business Analyst</span>
            <span class="rc-pill accent"><span class="pulse"></span>React Developer</span>
            <span class="rc-pill light">HR Generalist</span>
            <span class="rc-pill bold">DevOps Engineer</span>
          </div>
          <div class="rc-row reverse">
            <span class="rc-pill light">Finance Manager</span>
            <span class="rc-pill bold">QA Engineer</span>
            <span class="rc-pill accent"><span class="pulse"></span>Sales Executive</span>
            <span class="rc-pill light">Node.js Developer</span>
            <span class="rc-pill bold">UI/UX Designer</span>
            <span class="rc-pill light">Marketing Manager</span>
            <span class="rc-pill accent"><span class="pulse"></span>Cloud Architect</span>
            <span class="rc-pill light">Finance Manager</span>
            <span class="rc-pill bold">QA Engineer</span>
            <span class="rc-pill accent"><span class="pulse"></span>Sales Executive</span>
            <span class="rc-pill light">Node.js Developer</span>
            <span class="rc-pill bold">UI/UX Designer</span>
            <span class="rc-pill light">Marketing Manager</span>
            <span class="rc-pill accent"><span class="pulse"></span>Cloud Architect</span>
          </div>
          <div class="rc-row">
            <span class="rc-pill bold">Python Developer</span>
            <span class="rc-pill light">Operations Lead</span>
            <span class="rc-pill accent"><span class="pulse"></span>Full Stack Dev</span>
            <span class="rc-pill light">Scrum Master</span>
            <span class="rc-pill bold">ML Engineer</span>
            <span class="rc-pill light">Content Writer</span>
            <span class="rc-pill accent"><span class="pulse"></span>iOS Developer</span>
            <span class="rc-pill bold">Python Developer</span>
            <span class="rc-pill light">Operations Lead</span>
            <span class="rc-pill accent"><span class="pulse"></span>Full Stack Dev</span>
            <span class="rc-pill light">Scrum Master</span>
            <span class="rc-pill bold">ML Engineer</span>
            <span class="rc-pill light">Content Writer</span>
            <span class="rc-pill accent"><span class="pulse"></span>iOS Developer</span>
          </div>
        </div>
      </div>
    </div>
    {{-- end info-panel --}}

    {{-- ── RIGHT FORM PANEL ── --}}
    <div class="form-panel">

      <div class="tab-switcher">
        <button class="tab-btn active" id="tab-signin" type="button" onclick="jsaTab('signin')">JobSeeker Sign In</button>
        <button class="tab-btn" id="tab-signup" type="button" onclick="jsaTab('signup')">JobSeeker Sign Up</button>
      </div>

      <div class="form-sections-stack">

      {{-- ── SIGN IN ── --}}
      <div class="form-section active" id="section-signin">
        {{-- <div class="form-title">Sign In As <span class="highlight">Jobseeker</span></div> --}}
        {{-- <div class="form-subtitle">Please on-board with us if your notice period is Zero or if you are serving notice period</div> --}}

        @if(session('new_message'))
          <div class="znp-alert znp-alert-success">
            {!! session('new_message') !!}
          </div>
        @endif
        @if(session('error_message1'))
          <div class="znp-alert znp-alert-error">
            {{ session('error_message1') }}
          </div>
        @endif
        @if(session('error_message'))
          <div class="znp-alert znp-alert-error">
            {{ session('error_message') }}
          </div>
        @endif
        @if(session('verify_message'))
          <div class="znp-alert znp-alert-error">
            {!! session('verify_message') !!}
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="jsa-signin-form" style="margin-top:20px;">
          @csrf

          <div class="form-group">
            <label class="form-label">Email ID <span class="required">*</span></label>
            <div class="input-with-icon">
              <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              <input type="email" name="email" id="signin-email" class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter Email" value="{{ old('email') }}" required>
            </div>
            @if($errors->has('email'))
              <div class="field-error">{{ $errors->first('email') }}</div>
            @endif
          </div>

          <div class="form-group">
            <label class="form-label">Password <span class="required">*</span></label>
            <div class="input-with-icon">
              <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              <input type="password" name="password" id="signin-password" class="form-input" placeholder="Enter your password" style="padding-right:44px;" required>
              <button class="password-toggle" type="button" onclick="jsaTogglePass('signin-password', this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
          </div>

          <div class="form-options">
            <label class="checkbox-label">
              <input type="checkbox" name="remember"> Remember me
            </label>
            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
          </div>

          <button type="submit" class="btn-primary">Sign in</button>
        </form>

        <div class="alt-action" style="margin-top:14px;">
          Don't have an account? <a onclick="jsaTab('signup')">Sign up</a>
        </div>
        <div class="alt-action">
          Sign in as an Employer? <a href="{{ route('employer.auth') }}">Sign in</a>
        </div>
      </div>
      {{-- end sign-in --}}

      {{-- ── SIGN UP ── --}}
      <div class="form-section" id="section-signup">
        {{-- <div class="form-title">Sign Up As <span class="highlight">Jobseeker</span></div> --}}
        {{-- <div class="form-subtitle">Please on-board with us if your notice period is Zero or if you are serving notice period</div> --}}

        <div style="margin-top: 22px;">
          <div class="znp-step-bar">
            <div class="znp-step-seg active" id="ps1"></div>
            <div class="znp-step-seg" id="ps2"></div>
            <div class="znp-step-seg" id="ps3"></div>
          </div>
          {{-- <div class="znp-step-label" id="progress-label">Step 1 of 3 — Personal Information</div> --}}
        </div>

        @if ($errors->any() && old('_from_signup'))
          <div class="znp-alert znp-alert-error">
            <div><strong>Please fix the following errors:</strong>
              <ul style="margin:6px 0 0 16px; padding:0;">
                @foreach ($errors->all() as $err)
                  <li>{{ $err }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="jsa-signup-form">
          @csrf
          <input type="hidden" name="_from_signup" value="1">
          {{-- hidden keyskills array (populated by JS) --}}
          <div id="keyskills-hidden-wrap"></div>
          {{-- hidden prefered_city array (populated by JS) --}}
          <div id="prefcity-hidden-wrap"></div>

          {{-- ───── STEP 1: Personal Information ───── --}}
          <div id="step1" style="margin-top: 22px;">
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">First name <span class="required">*</span></label>
                <input type="text" name="first_name" class="form-input{{ $errors->has('first_name') ? ' is-invalid' : '' }}" placeholder="Enter your First Name" value="{{ old('first_name') }}" required>
                @if($errors->has('first_name'))<div class="field-error">{{ $errors->first('first_name') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Last name</label>
                <input type="text" name="last_name" class="form-input" placeholder="Enter your Last Name" value="{{ old('last_name') }}">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Notice Period Status <span class="required">*</span>
                  <span title="Select your current notice period status" style="cursor:help; color:var(--text-muted);">ℹ</span>
                </label>
                <select name="nop_days" id="nop_days" class="form-select{{ $errors->has('nop_days') ? ' is-invalid' : '' }}" required onchange="jsaNopChange(this.value)">
                  <option value="">Select Option</option>
                  <option value="1" {{ old('nop_days') == '1' ? 'selected' : '' }}>Immediately Available (0 days)</option>
                  <option value="2" {{ old('nop_days') == '2' ? 'selected' : '' }}>Serving Notice (≤15 days)</option>
                  <option value="3" {{ old('nop_days') == '3' ? 'selected' : '' }}>Serving Notice (15–30 days)</option>
                  <option value="4" {{ old('nop_days') == '4' ? 'selected' : '' }}>Serving Notice (30–45 days)</option>
                  <option value="5" {{ old('nop_days') == '5' ? 'selected' : '' }}>Serving Notice (45–60 days)</option>
                  <option value="6" {{ old('nop_days') == '6' ? 'selected' : '' }}>Serving Notice (60–90 days)</option>
                </select>
                @if($errors->has('nop_days'))<div class="field-error">{{ $errors->first('nop_days') }}</div>@endif
                {{-- Shown only when Immediately Available (nop_days=1) --}}
                <div class="nop-date-field{{ old('nop_days') == '1' ? ' visible' : '' }}" id="nop-date-wrap">
                  <label class="form-label" style="margin-top:6px;">Last Working Date <span class="required">*</span></label>
                  <input type="date" name="immediate_last_date" class="form-input{{ $errors->has('immediate_last_date') ? ' is-invalid' : '' }}" value="{{ old('immediate_last_date') }}">
                  @if($errors->has('immediate_last_date'))<div class="field-error">{{ $errors->first('immediate_last_date') }}</div>@endif
                </div>
                {{-- Shown when Serving Notice (nop_days = 2-6) --}}
                <div class="nop-date-field{{ in_array(old('nop_days'), ['2','3','4','5','6']) ? ' visible' : '' }}" id="nop-lwd-wrap">
                  <label class="form-label" style="margin-top:6px;">Last Working Date <span class="required">*</span></label>
                  <input type="date" name="last_working_day" class="form-input{{ $errors->has('last_working_day') ? ' is-invalid' : '' }}" value="{{ old('last_working_day') }}">
                  @if($errors->has('last_working_day'))<div class="field-error">{{ $errors->first('last_working_day') }}</div>@endif
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Preferred Work Type <span class="required">*</span></label>
                <select name="work_type" class="form-select{{ $errors->has('work_type') ? ' is-invalid' : '' }}" required>
                  <option value="">Select Work Type</option>
                  <option value="Full Time"  {{ old('work_type') == 'Full Time'  ? 'selected' : '' }}>Full Time</option>
                  <option value="Contract"   {{ old('work_type') == 'Contract'   ? 'selected' : '' }}>Contract</option>
                  <option value="Internship" {{ old('work_type') == 'Internship' ? 'selected' : '' }}>Internship</option>
                  <option value="Part Time"  {{ old('work_type') == 'Part Time'  ? 'selected' : '' }}>Part Time</option>
                </select>
                @if($errors->has('work_type'))<div class="field-error">{{ $errors->first('work_type') }}</div>@endif
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Email ID <span class="required">*</span></label>
                <input type="email" name="email" class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter your Email" value="{{ old('email') }}" required>
                @if($errors->has('email'))<div class="field-error">{{ $errors->first('email') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Phone number <span class="required">*</span></label>
                <input type="tel" name="phone" class="form-input{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="10-digit mobile number" maxlength="10" value="{{ old('phone') }}" required>
                @if($errors->has('phone'))<div class="field-error">{{ $errors->first('phone') }}</div>@endif
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Current CTC per annum <span class="required">*</span></label>
                <div style="display:flex;gap:6px;">
                  <input type="number" name="expect_ctc_lakhs" class="form-input{{ $errors->has('expect_ctc_lakhs') ? ' is-invalid' : '' }}" placeholder="Lakhs" min="0" value="{{ old('expect_ctc_lakhs') }}" required>
                  <input type="number" name="expect_ctc_thousand" class="form-input" placeholder="Thousand" min="0" max="99" value="{{ old('expect_ctc_thousand') }}">
                </div>
                @if($errors->has('expect_ctc_lakhs'))<div class="field-error">{{ $errors->first('expect_ctc_lakhs') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Expected CTC per annum <span class="required">*</span></label>
                <div style="display:flex;gap:6px;">
                  <input type="number" name="expect_ctc_lakhs3" class="form-input{{ $errors->has('expect_ctc_lakhs3') ? ' is-invalid' : '' }}" placeholder="Lakhs" min="0" value="{{ old('expect_ctc_lakhs3') }}" required>
                  <input type="number" name="expect_ctc_thousand3" class="form-input" placeholder="Thousand" min="0" max="99" value="{{ old('expect_ctc_thousand3') }}">
                </div>
                @if($errors->has('expect_ctc_lakhs3'))<div class="field-error">{{ $errors->first('expect_ctc_lakhs3') }}</div>@endif
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Latest Company <span class="required">*</span></label>
                <input type="text" name="latestcom" class="form-input{{ $errors->has('latestcom') ? ' is-invalid' : '' }}" placeholder="Latest Company" value="{{ old('latestcom') }}" required>
                @if($errors->has('latestcom'))<div class="field-error">{{ $errors->first('latestcom') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Latest Designation <span class="required">*</span></label>
                <input type="text" name="latestdesg" class="form-input{{ $errors->has('latestdesg') ? ' is-invalid' : '' }}" placeholder="Latest Designation" value="{{ old('latestdesg') }}" required>
                @if($errors->has('latestdesg'))<div class="field-error">{{ $errors->first('latestdesg') }}</div>@endif
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">
                Jobseeker Privacy: Hide your CV from these Employers (Current/Past)
                <span title="These employers won't see your profile" style="cursor:help; color:var(--text-muted);">ℹ</span>
              </label>
              <input type="text" name="ignore_companies_text" class="form-input" placeholder="e.g. Infosys, TCS (Optional)">
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Total Experience <span class="required">*</span></label>
                <select name="totalexp" class="form-select{{ $errors->has('totalexp') ? ' is-invalid' : '' }}" required>
                  <option value="">Select Year</option>
                  <option value="0"  {{ old('totalexp') == '0'  ? 'selected' : '' }}>Fresher (0 years)</option>
                  <option value="1"  {{ old('totalexp') == '1'  ? 'selected' : '' }}>1 Year</option>
                  <option value="2"  {{ old('totalexp') == '2'  ? 'selected' : '' }}>2 Years</option>
                  <option value="3"  {{ old('totalexp') == '3'  ? 'selected' : '' }}>3 Years</option>
                  <option value="4"  {{ old('totalexp') == '4'  ? 'selected' : '' }}>4 Years</option>
                  <option value="5"  {{ old('totalexp') == '5'  ? 'selected' : '' }}>5 Years</option>
                  <option value="7"  {{ old('totalexp') == '7'  ? 'selected' : '' }}>6–10 Years</option>
                  <option value="11" {{ old('totalexp') == '11' ? 'selected' : '' }}>10+ Years</option>
                </select>
                @if($errors->has('totalexp'))<div class="field-error">{{ $errors->first('totalexp') }}</div>@endif
              </div>
              <div class="form-group" style="display:flex;align-items:flex-end;">
                <div style="width:100%;">
                  <label class="form-label">&nbsp;</label>
                  <select name="totalexpmonth" class="form-select{{ $errors->has('totalexpmonth') ? ' is-invalid' : '' }}" required>
                    <option value="">Select Month</option>
                    @for($m = 0; $m <= 11; $m++)
                      <option value="{{ $m }}" {{ old('totalexpmonth') == $m ? 'selected' : '' }}>
                        {{ $m === 0 ? '0 Months' : ($m === 1 ? '1 Month' : "$m Months") }}
                      </option>
                    @endfor
                  </select>
                  @if($errors->has('totalexpmonth'))<div class="field-error">{{ $errors->first('totalexpmonth') }}</div>@endif
                </div>
              </div>
            </div>

            <div class="step-nav" style="margin-top:10px;">
              <button type="button" class="btn-primary" onclick="jsaGoStep(2)">Continue →</button>
            </div>
            <div class="alt-action">Already have an account? <a onclick="jsaTab('signin')">Sign in</a></div>
          </div>
          {{-- end step1 --}}

          {{-- ───── STEP 2: Resume & Skills ───── --}}
          <div id="step2" style="display:none;">

            <div class="form-group">
              <label class="form-label">Attach Resume <span class="required">*</span></label>
              <div class="file-upload">
                <label for="resume-upload" class="file-upload-label" id="resume-label">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                  Choose File
                </label>
                <input type="file" id="resume-upload" name="resume" accept=".pdf,.doc,.docx" onchange="jsaUpdateFileName(this,'resume-file-name','resume-label')" required>
                <div class="file-name" id="resume-file-name">Accepts only .pdf, .doc, .docx. Max size 2 MB.</div>
              </div>
              @if($errors->has('resume'))<div class="field-error">{{ $errors->first('resume') }}</div>@endif
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Current City <span class="required">*</span></label>
                <input type="text" name="current_city" class="form-input{{ $errors->has('current_city') ? ' is-invalid' : '' }}" placeholder="Enter a location" value="{{ old('current_city') }}" required>
                @if($errors->has('current_city'))<div class="field-error">{{ $errors->first('current_city') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Preferred Cities</label>
                <div class="cities-wrap" id="cities-wrap">
                  @php $prefCities = ['Bengaluru','Hyderabad','Mumbai','Chennai','Delhi','Pune','Remote']; @endphp
                  @foreach($prefCities as $city)
                    <span class="city-chip {{ in_array($city, (array) old('prefered_city', [])) ? 'selected' : '' }}"
                          data-city="{{ $city }}"
                          onclick="jsaToggleCity(this)">{{ $city }}</span>
                  @endforeach
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Key Skills <span class="required">*</span></label>
              <div class="skills-tags" id="skills-container" onclick="document.getElementById('skill-input').focus()">
                <input type="text" id="skill-input" class="skills-text-input"
                       placeholder="Please enter key skills or technologies"
                       onkeydown="jsaHandleSkillInput(event)">
              </div>
              <div class="skills-error" id="skills-error">Minimum 10 skills required</div>
              <div class="skills-hint">Press Enter or comma to add a skill. Minimum 10 skills required.</div>
              @if($errors->has('keyskills'))<div class="field-error">{{ $errors->first('keyskills') }}</div>@endif
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Set Your Password <span class="required">*</span></label>
                <div class="input-with-icon">
                  <input type="password" name="password" id="signup-password" class="form-input{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Min. 6 characters" style="padding-right:44px;" required>
                  <button class="password-toggle" type="button" onclick="jsaTogglePass('signup-password', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  </button>
                </div>
                @if($errors->has('password'))<div class="field-error">{{ $errors->first('password') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Confirm Your Password <span class="required">*</span></label>
                <div class="input-with-icon">
                  <input type="password" name="password_confirmation" id="signup-password-confirm" class="form-input{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="Re-enter password" style="padding-right:44px;" required>
                  <button class="password-toggle" type="button" onclick="jsaTogglePass('signup-password-confirm', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  </button>
                </div>
                @if($errors->has('password_confirmation'))<div class="field-error">{{ $errors->first('password_confirmation') }}</div>@endif
              </div>
            </div>

            <div class="step-nav">
              <button type="button" class="btn-secondary" onclick="jsaGoStep(1)">← Back</button>
              <button type="button" class="btn-primary" onclick="jsaGoStep(3)">Continue →</button>
            </div>
          </div>
          {{-- end step2 --}}

          {{-- ───── STEP 3: Education & Submit ───── --}}
          <div id="step3" style="display:none;">

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Highest Education <span class="required">*</span></label>
                <select name="degree_title" id="degree_title_select" class="form-select{{ $errors->has('degree_title') ? ' is-invalid' : '' }}" required onchange="jsaDegreeChange(this.value)">
                  <option value="">Select Education</option>
                  <option value="5" {{ old('degree_title') == '5' ? 'selected' : '' }}>10th</option>
                  <option value="5" {{ old('degree_title') == '5' ? 'selected' : '' }}>12th / HSC</option>
                  <option value="4" {{ old('degree_title') == '4' ? 'selected' : '' }}>Diploma</option>
                  <option value="4" {{ old('degree_title') == '4' ? 'selected' : '' }}>B.Tech / B.E.</option>
                  <option value="4" {{ old('degree_title') == '4' ? 'selected' : '' }}>B.Sc</option>
                  <option value="4" {{ old('degree_title') == '4' ? 'selected' : '' }}>B.Com</option>
                  <option value="4" {{ old('degree_title') == '4' ? 'selected' : '' }}>BBA</option>
                  <option value="3" {{ old('degree_title') == '3' ? 'selected' : '' }}>MBA</option>
                  <option value="3" {{ old('degree_title') == '3' ? 'selected' : '' }}>MCA</option>
                  <option value="3" {{ old('degree_title') == '3' ? 'selected' : '' }}>M.Tech</option>
                  <option value="2" {{ old('degree_title') == '2' ? 'selected' : '' }}>PhD</option>
                  <option value="4" {{ old('degree_title') == '4' ? 'selected' : '' }}>Other</option>
                </select>
                @if($errors->has('degree_title'))<div class="field-error">{{ $errors->first('degree_title') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Year of completion <span class="required">*</span></label>
                <input type="text" name="year_of_completion" class="form-input" placeholder="e.g. 2022" maxlength="4" value="{{ old('year_of_completion') }}">
              </div>
            </div>

            <div class="form-row" id="course-spec-row" style="{{ in_array(old('degree_title'), ['2','3','4']) ? '' : 'display:none;' }}">
              <div class="form-group">
                <label class="form-label">Course <span class="required">*</span></label>
                <select name="course" id="course_select" class="form-select{{ $errors->has('course') ? ' is-invalid' : '' }}">
                  <option value="">Select Course</option>
                  <option value="Computer Science"        {{ old('course') == 'Computer Science'        ? 'selected' : '' }}>Computer Science</option>
                  <option value="Information Technology"  {{ old('course') == 'Information Technology'  ? 'selected' : '' }}>Information Technology</option>
                  <option value="Electronics"             {{ old('course') == 'Electronics'             ? 'selected' : '' }}>Electronics</option>
                  <option value="Mechanical"              {{ old('course') == 'Mechanical'              ? 'selected' : '' }}>Mechanical</option>
                  <option value="Civil"                   {{ old('course') == 'Civil'                   ? 'selected' : '' }}>Civil</option>
                  <option value="Business Administration" {{ old('course') == 'Business Administration' ? 'selected' : '' }}>Business Administration</option>
                  <option value="Commerce"                {{ old('course') == 'Commerce'                ? 'selected' : '' }}>Commerce</option>
                  <option value="Arts"                    {{ old('course') == 'Arts'                    ? 'selected' : '' }}>Arts</option>
                  <option value="Science"                 {{ old('course') == 'Science'                 ? 'selected' : '' }}>Science</option>
                  <option value="Other"                   {{ old('course') == 'Other'                   ? 'selected' : '' }}>Other</option>
                </select>
                @if($errors->has('course'))<div class="field-error">{{ $errors->first('course') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Specialization <span class="required">*</span></label>
                <select name="specilation" id="specilation_select" class="form-select{{ $errors->has('specilation') ? ' is-invalid' : '' }}">
                  <option value="">Select Specialization</option>
                  <option value="Full Stack Development" {{ old('specilation') == 'Full Stack Development' ? 'selected' : '' }}>Full Stack Development</option>
                  <option value="Data Science"           {{ old('specilation') == 'Data Science'           ? 'selected' : '' }}>Data Science</option>
                  <option value="AI / ML"                {{ old('specilation') == 'AI / ML'                ? 'selected' : '' }}>AI / ML</option>
                  <option value="Cyber Security"         {{ old('specilation') == 'Cyber Security'         ? 'selected' : '' }}>Cyber Security</option>
                  <option value="Marketing"              {{ old('specilation') == 'Marketing'              ? 'selected' : '' }}>Marketing</option>
                  <option value="Finance"                {{ old('specilation') == 'Finance'                ? 'selected' : '' }}>Finance</option>
                  <option value="HR"                     {{ old('specilation') == 'HR'                     ? 'selected' : '' }}>HR</option>
                  <option value="Operations"             {{ old('specilation') == 'Operations'             ? 'selected' : '' }}>Operations</option>
                  <option value="Other"                  {{ old('specilation') == 'Other'                  ? 'selected' : '' }}>Other</option>
                </select>
                @if($errors->has('specilation'))<div class="field-error">{{ $errors->first('specilation') }}</div>@endif
              </div>
            </div>

            <div class="form-group" id="org-row" style="{{ in_array(old('degree_title'), ['2','3','4']) ? '' : 'display:none;' }}">
              <label class="form-label">University / College <span class="required">*</span></label>
              <select name="organization" id="organization_select" class="form-select{{ $errors->has('organization') ? ' is-invalid' : '' }}">
                <option value="">Select University/College</option>
                <option value="IIT Bombay"   {{ old('organization') == 'IIT Bombay'   ? 'selected' : '' }}>IIT Bombay</option>
                <option value="IIT Delhi"    {{ old('organization') == 'IIT Delhi'    ? 'selected' : '' }}>IIT Delhi</option>
                <option value="IIT Madras"   {{ old('organization') == 'IIT Madras'   ? 'selected' : '' }}>IIT Madras</option>
                <option value="IIM Ahmedabad" {{ old('organization') == 'IIM Ahmedabad' ? 'selected' : '' }}>IIM Ahmedabad</option>
                <option value="BITS Pilani"  {{ old('organization') == 'BITS Pilani'  ? 'selected' : '' }}>BITS Pilani</option>
                <option value="VTU"          {{ old('organization') == 'VTU'          ? 'selected' : '' }}>VTU (Visvesvaraya Technological University)</option>
                <option value="Anna University"   {{ old('organization') == 'Anna University'   ? 'selected' : '' }}>Anna University</option>
                <option value="Osmania University" {{ old('organization') == 'Osmania University' ? 'selected' : '' }}>Osmania University</option>
                <option value="Other"        {{ old('organization') == 'Other'        ? 'selected' : '' }}>Other</option>
              </select>
              @if($errors->has('organization'))<div class="field-error">{{ $errors->first('organization') }}</div>@endif
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Education Status <span class="required">*</span></label>
                <select name="education_status" class="form-select{{ $errors->has('education_status') ? ' is-invalid' : '' }}" required>
                  <option value="">Select Status</option>
                  <option value="Completed"   {{ old('education_status') == 'Completed'   ? 'selected' : '' }}>Completed</option>
                  <option value="Pursuing"    {{ old('education_status') == 'Pursuing'    ? 'selected' : '' }}>Pursuing</option>
                  <option value="Discontinued" {{ old('education_status') == 'Discontinued' ? 'selected' : '' }}>Discontinued</option>
                </select>
                @if($errors->has('education_status'))<div class="field-error">{{ $errors->first('education_status') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Reason for moving out <span class="required">*</span></label>
                <select name="reason_moved" class="form-select{{ $errors->has('reason_moved') ? ' is-invalid' : '' }}" required>
                  <option value="">Select Reason</option>
                  <option value="Better Opportunity" {{ old('reason_moved') == 'Better Opportunity' ? 'selected' : '' }}>Better Opportunity</option>
                  <option value="Higher Salary"      {{ old('reason_moved') == 'Higher Salary'      ? 'selected' : '' }}>Higher Salary</option>
                  <option value="Career Growth"      {{ old('reason_moved') == 'Career Growth'      ? 'selected' : '' }}>Career Growth</option>
                  <option value="Relocation"         {{ old('reason_moved') == 'Relocation'         ? 'selected' : '' }}>Relocation</option>
                  <option value="Work-Life Balance"  {{ old('reason_moved') == 'Work-Life Balance'  ? 'selected' : '' }}>Work-Life Balance</option>
                  <option value="Company Layoff"     {{ old('reason_moved') == 'Company Layoff'     ? 'selected' : '' }}>Company Layoff</option>
                  <option value="Other"              {{ old('reason_moved') == 'Other'              ? 'selected' : '' }}>Other</option>
                </select>
                @if($errors->has('reason_moved'))<div class="field-error">{{ $errors->first('reason_moved') }}</div>@endif
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Pref. Work Mode <span class="required">*</span></label>
                <select name="work_option" class="form-select{{ $errors->has('work_option') ? ' is-invalid' : '' }}" required>
                  <option value="">Select Mode</option>
                  <option value="WFO"      {{ old('work_option') == 'WFO'      ? 'selected' : '' }}>Work From Office</option>
                  <option value="WFH"      {{ old('work_option') == 'WFH'      ? 'selected' : '' }}>Work From Home / Remote</option>
                  <option value="Hybrid"   {{ old('work_option') == 'Hybrid'   ? 'selected' : '' }}>Hybrid</option>
                  <option value="Temp WFH" {{ old('work_option') == 'Temp WFH' ? 'selected' : '' }}>Temporary WFH</option>
                  <option value="Any"      {{ old('work_option') == 'Any'      ? 'selected' : '' }}>Any</option>
                </select>
                @if($errors->has('work_option'))<div class="field-error">{{ $errors->first('work_option') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Gender <span class="required">*</span></label>
                <select name="gender_id" class="form-select{{ $errors->has('gender_id') ? ' is-invalid' : '' }}" required>
                  <option value="">Select Gender</option>
                  <option value="1" {{ old('gender_id') == '1' ? 'selected' : '' }}>Male</option>
                  <option value="2" {{ old('gender_id') == '2' ? 'selected' : '' }}>Female</option>
                  <option value="3" {{ old('gender_id') == '3' ? 'selected' : '' }}>Non-binary</option>
                  <option value="4" {{ old('gender_id') == '4' ? 'selected' : '' }}>Prefer not to say</option>
                </select>
                @if($errors->has('gender_id'))<div class="field-error">{{ $errors->first('gender_id') }}</div>@endif
              </div>
            </div>

            <div class="checkbox-group">
              <label class="checkbox-item">
                <input type="checkbox" name="terms_of_use" value="1" {{ old('terms_of_use') ? 'checked' : '' }} required>
                I have read and agreed to the <a href="#">Terms &amp; Conditions</a>. <span class="required">*</span>
              </label>
            </div>
            @if($errors->has('terms_of_use'))<div class="field-error" style="margin-top:-10px; margin-bottom:10px;">{{ $errors->first('terms_of_use') }}</div>@endif

            <div class="step-nav">
              <button type="button" class="btn-secondary" onclick="jsaGoStep(2)">← Back</button>
              <button type="submit" class="btn-primary" onclick="return jsaHandleSignUp()">Create your account</button>
            </div>
            <div class="alt-action">Already have an account? <a onclick="jsaTab('signin')">Sign in</a></div>
          </div>
          {{-- end step3 --}}

        </form>
      </div>
      {{-- end signup --}}

      </div>
      {{-- end form-sections-stack --}}

    </div>
    {{-- end form-panel --}}

  </div>
</main>

@include('znp.footer')
@endsection

@push('scripts')
<script>
(function () {
  'use strict';

  /* ── Tab switching ── */
  window.jsaTab = function (tab) {
    document.querySelectorAll('.znp-jobseeker-auth .tab-btn').forEach(function (btn) {
      btn.classList.remove('active');
    });
    document.getElementById('tab-' + tab).classList.add('active');
    document.querySelectorAll('.znp-jobseeker-auth .form-section').forEach(function (s) {
      s.classList.remove('active');
    });
    document.getElementById('section-' + tab).classList.add('active');
    if (tab === 'signup') jsaGoStep(1);
  };

  /* ── Password toggle ── */
  window.jsaTogglePass = function (inputId, btn) {
    var input = document.getElementById(inputId);
    var isPass = input.type === 'password';
    input.type = isPass ? 'text' : 'password';
    btn.style.color = isPass ? 'var(--blue)' : 'var(--text-light)';
  };

  /* ── File name update ── */
  window.jsaUpdateFileName = function (input, labelId, btnId) {
    var label = document.getElementById(labelId);
    var btn   = document.getElementById(btnId);
    if (input.files && input.files[0]) {
      label.textContent = input.files[0].name;
      label.style.fontStyle = 'normal';
      label.style.color = 'var(--blue)';
      if (btn) btn.style.color = 'var(--blue)';
    }
  };

  /* ── Notice period date toggle ── */
  window.jsaNopChange = function (val) {
    var immWrap = document.getElementById('nop-date-wrap');
    var lwdWrap  = document.getElementById('nop-lwd-wrap');
    if (immWrap) {
      if (val === '1') { immWrap.classList.add('visible'); } else { immWrap.classList.remove('visible'); }
    }
    if (lwdWrap) {
      if (['2','3','4','5','6'].indexOf(val) !== -1) { lwdWrap.classList.add('visible'); } else { lwdWrap.classList.remove('visible'); }
    }
  };

  /* ── Multi-step navigation ── */
  window.jsaGoStep = function (step) {
    // Validate current step before proceeding forward
    var currentStep = jsaCurrentStep();
    if (step > currentStep && !jsaValidateStep(currentStep)) return;

    [1, 2, 3].forEach(function (i) {
      var el = document.getElementById('step' + i);
      if (el) el.style.display = (i === step) ? 'block' : 'none';
      var ps = document.getElementById('ps' + i);
      if (ps) ps.classList.toggle('active', i <= step);
    });

    var labels = [
      'Step 1 of 3 — Personal Information',
      'Step 2 of 3 — Resume & Skills',
      'Step 3 of 3 — Education & Confirm'
    ];
    var lbl = document.getElementById('progress-label');
    if (lbl) lbl.textContent = labels[step - 1];

    var panel = document.querySelector('.znp-jobseeker-auth .form-panel');
    if (panel) panel.scrollTo({ top: 0, behavior: 'smooth' });
  };

  function jsaCurrentStep() {
    for (var i = 1; i <= 3; i++) {
      var el = document.getElementById('step' + i);
      if (el && el.style.display !== 'none') return i;
    }
    return 1;
  }

  function jsaValidateStep(step) {
    if (step === 1) {
      var req = ['first_name', 'nop_days', 'work_type', 'email', 'phone',
                 'expect_ctc_lakhs', 'expect_ctc_lakhs3', 'latestcom', 'latestdesg',
                 'totalexp', 'totalexpmonth'];
      var ok = true;
      req.forEach(function (name) {
        var el = document.querySelector('#step1 [name="' + name + '"]');
        if (el && !el.value.trim()) {
          el.classList.add('is-invalid');
          ok = false;
        } else if (el) {
          el.classList.remove('is-invalid');
        }
      });
      return ok;
    }
    if (step === 2) {
      var resumeInput = document.getElementById('resume-upload');
      var cityInput   = document.querySelector('#step2 [name="current_city"]');
      var ok2 = true;
      if (resumeInput && !resumeInput.files.length) {
        ok2 = false;
        alert('Please attach your resume before continuing.');
        return false;
      }
      if (cityInput && !cityInput.value.trim()) {
        cityInput.classList.add('is-invalid');
        ok2 = false;
      } else if (cityInput) {
        cityInput.classList.remove('is-invalid');
      }
      if (jsaSkills.length < 10) {
        document.getElementById('skills-error').style.display = 'block';
        ok2 = false;
      }
      return ok2;
    }
    return true;
  }

  /* ── Skills tag input ── */
  var jsaSkills = [];
  window.jsaSkills = jsaSkills;

  window.jsaHandleSkillInput = function (e) {
    var input = document.getElementById('skill-input');
    var val = input.value.trim().replace(/,$/, '');
    if ((e.key === 'Enter' || e.key === ',') && val) {
      e.preventDefault();
      jsaAddSkill(val);
      input.value = '';
    } else if (e.key === 'Backspace' && input.value === '' && jsaSkills.length) {
      jsaRemoveSkill(jsaSkills.length - 1);
    }
  };

  window.jsaAddSkill = function (name) {
    if (jsaSkills.indexOf(name) !== -1) return;
    jsaSkills.push(name);
    jsaRenderSkills();
  };

  window.jsaRemoveSkill = function (idx) {
    jsaSkills.splice(idx, 1);
    jsaRenderSkills();
  };

  function jsaRenderSkills() {
    var container = document.getElementById('skills-container');
    var input = document.getElementById('skill-input');
    container.innerHTML = '';
    jsaSkills.forEach(function (s, i) {
      var tag = document.createElement('span');
      tag.className = 'skill-tag';
      tag.innerHTML = s + '<button type="button" onclick="jsaRemoveSkill(' + i + ')" title="Remove">×</button>';
      container.appendChild(tag);
    });
    container.appendChild(input);
    input.focus();

    var err = document.getElementById('skills-error');
    if (err) err.style.display = (jsaSkills.length > 0 && jsaSkills.length < 10) ? 'block' : 'none';

    // Sync hidden inputs
    var wrap = document.getElementById('keyskills-hidden-wrap');
    if (wrap) {
      wrap.innerHTML = '';
      jsaSkills.forEach(function (s) {
        var inp = document.createElement('input');
        inp.type = 'hidden';
        inp.name = 'keyskills[]';
        inp.value = s;
        wrap.appendChild(inp);
      });
    }
  }

  /* ── City chip toggle ── */
  window.jsaToggleCity = function (el) {
    el.classList.toggle('selected');
    jsaSyncPreferredCities();
  };

  function jsaSyncPreferredCities() {
    var wrap = document.getElementById('prefcity-hidden-wrap');
    if (!wrap) return;
    wrap.innerHTML = '';
    document.querySelectorAll('.znp-jobseeker-auth .city-chip.selected').forEach(function (chip) {
      var inp = document.createElement('input');
      inp.type = 'hidden';
      inp.name = 'prefered_city[]';
      inp.value = chip.dataset.city;
      wrap.appendChild(inp);
    });
  }

  /* ── Degree change: show/hide course/spec/org rows ── */
  window.jsaDegreeChange = function (val) {
    var show = ['2', '3', '4'].indexOf(val) !== -1;
    var csRow  = document.getElementById('course-spec-row');
    var orgRow = document.getElementById('org-row');
    if (csRow)  csRow.style.display  = show ? '' : 'none';
    if (orgRow) orgRow.style.display = show ? '' : 'none';
    // Toggle required attributes
    ['course_select', 'specilation_select', 'organization_select'].forEach(function (id) {
      var el = document.getElementById(id);
      if (el) el.required = show;
    });
  };

  /* ── Final submit validation ── */
  window.jsaHandleSignUp = function () {
    if (jsaSkills.length < 10) {
      document.getElementById('skills-error').style.display = 'block';
      jsaGoStep(2);
      return false;
    }
    jsaSyncPreferredCities();
    return true;
  };

  /* ── Restore state on validation error (page reload) ── */
  (function restoreOnError() {
    var hasErrors = document.querySelectorAll('.znp-jobseeker-auth .field-error').length > 0;
    @if ($errors->any() && old('_from_signup'))
    hasErrors = true;
    @endif
    if (hasErrors) {
      // Switch to sign-up tab and advance to the step that has errors
      jsaTab('signup');
      // If step3 fields have errors, jump to step 3
      @if ($errors->hasAny(['degree_title','education_status','course','specilation','organization','reason_moved','work_option','gender_id','terms_of_use']))
      jsaGoStep(3);
      @elseif ($errors->hasAny(['resume','current_city','keyskills','password','password_confirmation']))
      jsaGoStep(2);
      @else
      jsaGoStep(1);
      @endif
    }

    // Restore previously-entered nop_days display
    var nopSelect = document.getElementById('nop_days');
    if (nopSelect && nopSelect.value) {
      jsaNopChange(nopSelect.value);
    }

    // Restore degree-dependent fields
    var degSelect = document.getElementById('degree_title_select');
    if (degSelect && degSelect.value) {
      jsaDegreeChange(degSelect.value);
    }

    // Restore pre-checked city chips
    document.querySelectorAll('.znp-jobseeker-auth .city-chip.selected').forEach(function () {
      jsaSyncPreferredCities();
    });
  }());

})();
</script>
@endpush
