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
    margin-bottom: 20px;
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
.znp-jobseeker-auth .form-sections-stack > .form-section {
    display: none;
}
.znp-jobseeker-auth .form-sections-stack > .form-section.active {
    display: block;
    animation: jsaFadeIn 180ms ease;
}
@keyframes jsaFadeIn {
    from { opacity: 0; transform: translateY(4px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Progress bar */
.znp-jobseeker-auth .znp-step-bar {
    display: flex; align-items: center; gap: 8px; margin-bottom: 14px;
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
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 12px;
  width: 100%;
  margin-left: 0;
  margin-right: 0;
  padding-left: 0;
  padding-right: 0;
}
.znp-jobseeker-auth .form-row > .form-group {
  min-width: 0;
  padding-left: 0;
  padding-right: 0;
}
.znp-jobseeker-auth .input-with-icon { position: relative; }
.znp-jobseeker-auth .input-icon-left {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: var(--text-light); width: 14px; height: 14px; pointer-events: none;
}
.znp-jobseeker-auth .input-with-icon .form-input { padding-left: 38px; }
/* Password-only wrapper — right toggle, no left icon */
.znp-jobseeker-auth .input-pass-wrap { position: relative; }
.znp-jobseeker-auth .input-pass-wrap .form-input { padding-right: 44px; }
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
.znp-jobseeker-auth .nop-date-field { display: none; }
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

/* ── Success modal ── */
.znp-jobseeker-auth .znp-modal {
    display: none;
    position: fixed; inset: 0;
    z-index: 9999;
    align-items: center; justify-content: center;
    padding: 20px;
}
.znp-jobseeker-auth .znp-modal.open { display: flex; }
.znp-jobseeker-auth .znp-modal-overlay {
    position: absolute; inset: 0;
    background: rgba(10,18,50,0.55);
    backdrop-filter: blur(3px);
    opacity: 0; transition: opacity 280ms ease;
}
.znp-jobseeker-auth .znp-modal.open .znp-modal-overlay { opacity: 1; }
.znp-jobseeker-auth .znp-modal-content {
    position: relative;
    background: #fff;
    border-radius: 20px;
    padding: 36px 32px 0;
    width: 100%; max-width: 400px;
    box-shadow: 0 32px 80px rgba(10,18,50,0.22), 0 4px 16px rgba(10,18,50,0.08);
    z-index: 2;
    text-align: center;
    overflow: hidden;
    transform: translateY(20px) scale(0.97);
    opacity: 0;
    transition: transform 320ms cubic-bezier(.16,1,.3,1), opacity 240ms ease;
}
.znp-jobseeker-auth .znp-modal.open .znp-modal-content {
    transform: translateY(0) scale(1);
    opacity: 1;
}
.znp-jobseeker-auth .znp-modal-topclose {
    position: absolute; right: 14px; top: 14px;
    width: 28px; height: 28px;
    border-radius: 50%; background: #f3f4f6; border: none;
    cursor: pointer; color: #6b7280;
    font-size: 16px; line-height: 28px; text-align: center;
    display: flex; align-items: center; justify-content: center;
    transition: background 150ms;
}
.znp-jobseeker-auth .znp-modal-topclose:hover { background: #e5e7eb; color: #111827; }
.znp-jobseeker-auth .znp-modal-topclose:focus { outline: none; }
.znp-jobseeker-auth .znp-modal-icon-wrap {
    width: 76px; height: 76px;
    border-radius: 50%;
    background: linear-gradient(135deg,#e8effe,#dbeafe);
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 18px;
    position: relative;
}
.znp-jobseeker-auth .znp-modal-icon-wrap::before {
    content: '';
    position: absolute; inset: -6px;
    border-radius: 50%;
    border: 2px solid rgba(59,130,246,0.18);
}
.znp-jobseeker-auth .znp-check {
    width: 52px; height: 52px; border-radius: 50%;
    background: linear-gradient(135deg,#2563eb,#1a3faa);
    box-shadow: 0 8px 24px rgba(37,99,235,0.30);
    display: inline-grid; place-items: center;
}
.znp-jobseeker-auth .znp-check svg {
    width: 26px; height: 26px;
    stroke: #fff; stroke-width: 2.5;
    stroke-linecap: round; stroke-linejoin: round; fill: none;
}
.znp-jobseeker-auth .znp-check .chkpath {
    stroke-dasharray: 48; stroke-dashoffset: 48;
    animation: znpChkDraw 400ms ease forwards 200ms;
}
@keyframes znpChkDraw { to { stroke-dashoffset: 0; } }
.znp-jobseeker-auth .znp-modal-content h3 {
    margin: 0 0 8px; font-size: 20px !important; font-weight: 800 !important;
    color: #0f172a !important;
}
.znp-jobseeker-auth .znp-modal-content .znp-modal-msg {
    font-size: 13.5px !important; color: #475569 !important; line-height: 1.6;
    margin: 0 0 24px;
}
.znp-jobseeker-auth .znp-modal-cta {
    display: block; width: 100%;
    padding: 13px 0;
    background: linear-gradient(135deg,#2563eb,#1a3faa);
    color: #fff !important; font-weight: 700 !important; font-size: 14px !important;
    border: none; border-radius: 12px;
    cursor: pointer; margin-bottom: 20px;
    transition: opacity 150ms;
}
.znp-jobseeker-auth .znp-modal-cta:hover { opacity: 0.9; }
.znp-jobseeker-auth .znp-modal-cta:focus { outline: none; box-shadow: 0 0 0 4px rgba(37,99,235,0.18); }
.znp-jobseeker-auth .znp-modal-bar-wrap {
    height: 3px; background: #f1f5f9;
    position: absolute; bottom: 0; left: 0; right: 0;
}
.znp-jobseeker-auth .znp-modal-bar {
    height: 100%;
    background: linear-gradient(90deg,#2563eb,#60a5fa);
    width: 100%;
    transform-origin: left;
    animation: znpBarShrink var(--znp-bar-dur,6s) linear forwards;
}
@keyframes znpBarShrink { to { transform: scaleX(0); } }
.znp-jobseeker-auth .znp-modal.paused .znp-modal-bar { animation-play-state: paused; }

/* ── jQuery UI Autocomplete dropdown — scoped to this page ── */
.znp-jobseeker-auth .ui-autocomplete {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 4px 0;
    z-index: 9999;
    list-style: none;
    margin: 4px 0 0;
}
.znp-jobseeker-auth .ui-autocomplete .ui-menu-item { padding: 0; }
.znp-jobseeker-auth .ui-autocomplete .ui-menu-item-wrapper {
    padding: 9px 14px;
    font-size: 13px;
    font-family: 'Inter', sans-serif;
    color: var(--text);
    cursor: pointer;
    display: block;
}
.znp-jobseeker-auth .ui-autocomplete .ui-menu-item-wrapper.ui-state-active,
.znp-jobseeker-auth .ui-autocomplete .ui-menu-item-wrapper:hover {
    background: #eef2ff;
    color: var(--blue);
    border: none;
    outline: none;
}
.znp-jobseeker-auth .ui-autocomplete .highlight {
    font-weight: 700;
    color: var(--blue);
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
          <div id="znp-success-modal" class="znp-modal" role="dialog" aria-modal="true">
            <div class="znp-modal-overlay" onclick="jsaCloseSuccessModal()"></div>
            <div class="znp-modal-content" role="document">
              <button class="znp-modal-topclose" aria-label="Close" onclick="jsaCloseSuccessModal()">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                  <line x1="1" y1="1" x2="11" y2="11"/><line x1="11" y1="1" x2="1" y2="11"/>
                </svg>
              </button>
              <div class="znp-modal-icon-wrap">
                <div class="znp-check" aria-hidden="true">
                  <svg viewBox="0 0 24 24"><polyline class="chkpath" points="20 6 9 17 4 12"></polyline></svg>
                </div>
              </div>
              <h3>You're registered!</h3>
              <p class="znp-modal-msg">{!! session('new_message') !!}</p>
              <button id="jsa-success-close" class="znp-modal-cta">Continue to Sign In</button>
              <div class="znp-modal-bar-wrap">
                <div class="znp-modal-bar" id="jsa-modal-bar"></div>
              </div>
            </div>
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

        <div>
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

          {{-- ───── STEP 1: Notice Period & Personal Info ───── --}}
          <div id="step1">

            {{-- Notice Period Status --}}
            <div class="form-group">
              <label class="form-label">Notice Period Status <span class="required">*</span></label>
              <select name="nop_days" id="nop_days" class="form-select{{ $errors->has('nop_days') ? ' is-invalid' : '' }}" required onchange="jsaNopChange(this.value)">
                <option value="">Select Option</option>
                <option value="Immediate Joiner" {{ old('nop_days') == 'Immediate Joiner' ? 'selected' : '' }}>Immediate Joiner</option>
                <option value="Serving Notice"   {{ old('nop_days') == 'Serving Notice'   ? 'selected' : '' }}>Serving Notice</option>
              </select>
              @if($errors->has('nop_days'))<div class="field-error">{{ $errors->first('nop_days') }}</div>@endif
            </div>

            {{-- Shown when Immediate Joiner --}}
            <div class="nop-date-field{{ old('nop_days') == 'Immediate Joiner' ? ' visible' : '' }}" id="nop-date-wrap">
              <div class="form-group">
                <label class="form-label">Last Working Date <span class="required">*</span></label>
                <input type="date" name="immediate_last_date" id="nop-immediate-date"
                       class="form-input{{ $errors->has('immediate_last_date') ? ' is-invalid' : '' }}"
                       value="{{ old('immediate_last_date') }}">
                @if($errors->has('immediate_last_date'))<div class="field-error">{{ $errors->first('immediate_last_date') }}</div>@endif
              </div>
            </div>

            {{-- Shown when Serving Notice --}}
            <div class="nop-date-field{{ old('nop_days') == 'Serving Notice' ? ' visible' : '' }}" id="nop-lwd-wrap">
              <div class="form-group">
                <label class="form-label">Last Working Date <span class="required">*</span></label>
                <input type="date" name="last_working_day" id="nop-lwd-date"
                       class="form-input{{ $errors->has('last_working_day') ? ' is-invalid' : '' }}"
                       value="{{ old('last_working_day') }}">
                @if($errors->has('last_working_day'))<div class="field-error">{{ $errors->first('last_working_day') }}</div>@endif
              </div>
            </div>

            {{-- Shown when any NOP status is selected --}}
            <div class="nop-date-field{{ old('nop_days') ? ' visible' : '' }}" id="nop-lwd-proof-wrap">
              <div class="form-group">
                <label class="form-label">Last Working Date Proof Available <span class="required">*</span></label>
                <select name="lwd_proof" class="form-select{{ $errors->has('lwd_proof') ? ' is-invalid' : '' }}">
                  <option value="">Select Proof Type</option>
                  <option value="EPFO Service History"        {{ old('lwd_proof') == 'EPFO Service History'        ? 'selected' : '' }}>EPFO Service History</option>
                  <option value="Resignation Acceptance Mail" {{ old('lwd_proof') == 'Resignation Acceptance Mail' ? 'selected' : '' }}>Resignation Acceptance Mail</option>
                  <option value="Relieving Letter"            {{ old('lwd_proof') == 'Relieving Letter'            ? 'selected' : '' }}>Relieving Letter</option>
                  <option value="Fresher"                     {{ old('lwd_proof') == 'Fresher'                     ? 'selected' : '' }}>Fresher</option>
                </select>
                @if($errors->has('lwd_proof'))<div class="field-error">{{ $errors->first('lwd_proof') }}</div>@endif
              </div>
            </div>

            {{-- First Name / Last Name --}}
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">First Name <span class="required">*</span></label>
                <input type="text" name="first_name" class="form-input{{ $errors->has('first_name') ? ' is-invalid' : '' }}" placeholder="Enter your First Name" value="{{ old('first_name') }}" required>
                @if($errors->has('first_name'))<div class="field-error">{{ $errors->first('first_name') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Last Name <span class="required">*</span></label>
                <input type="text" name="last_name" class="form-input{{ $errors->has('last_name') ? ' is-invalid' : '' }}" placeholder="Enter your Last Name" value="{{ old('last_name') }}" required>
                @if($errors->has('last_name'))<div class="field-error">{{ $errors->first('last_name') }}</div>@endif
              </div>
            </div>

            {{-- LinkedIn Profile URL --}}
            <div class="form-row">
              <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label">LinkedIn Profile URL</label>
                <input type="url" name="linkedin_url" class="form-input{{ $errors->has('linkedin_url') ? ' is-invalid' : '' }}" placeholder="https://linkedin.com/in/yourprofile" value="{{ old('linkedin_url') }}" autocomplete="off">
                @if($errors->has('linkedin_url'))<div class="field-error">{{ $errors->first('linkedin_url') }}</div>@endif
              </div>
            </div>

            {{-- Email / Phone --}}
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Email ID <span class="required">*</span></label>
                <input type="email" name="email" class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter your Email" value="{{ old('email') }}" required>
                @if($errors->has('email'))<div class="field-error">{{ $errors->first('email') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Phone Number <span class="required">*</span></label>
                <input type="tel" name="phone" class="form-input{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="10-digit mobile number" maxlength="10" value="{{ old('phone') }}" required>
                @if($errors->has('phone'))<div class="field-error">{{ $errors->first('phone') }}</div>@endif
              </div>
            </div>

            <div class="step-nav" style="margin-top:10px;">
              <button type="button" class="btn-primary" onclick="jsaGoStep(2)">Continue →</button>
            </div>
            <div class="alt-action">Already have an account? <a onclick="jsaTab('signin')">Sign in</a></div>
          </div>
          {{-- end step1 --}}

          {{-- ───── STEP 2: Work Profile & Experience ───── --}}
          <div id="step2" style="display:none;">

            {{-- Current City / Locality --}}
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Current City <span class="required">*</span></label>
                <input type="text" id="jsa-city-input" name="current_city" class="form-input{{ $errors->has('current_city') ? ' is-invalid' : '' }}" placeholder="Enter a location" value="{{ old('current_city') }}" required autocomplete="off">
                @if($errors->has('current_city'))<div class="field-error">{{ $errors->first('current_city') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Locality <span class="required">*</span></label>
                <input type="text" id="jsa-locality-input" name="locality" class="form-input{{ $errors->has('locality') ? ' is-invalid' : '' }}" placeholder="Enter your area / locality" value="{{ old('locality') }}" required autocomplete="off">
                @if($errors->has('locality'))<div class="field-error">{{ $errors->first('locality') }}</div>@endif
              </div>
            </div>

            {{-- Preferred Cities --}}
            <div class="form-row">
              <div class="form-group" style="grid-column: 1 / -1;">
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

            {{-- Mode Of Separation / Preferred Work Mode --}}
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Mode Of Separation <span class="required">*</span></label>
                <select name="mode_of_separation" class="form-select{{ $errors->has('mode_of_separation') ? ' is-invalid' : '' }}" required>
                  <option value="">Select Mode</option>
                  <option value="Resignation"      {{ old('mode_of_separation') == 'Resignation'      ? 'selected' : '' }}>Resignation</option>
                  <option value="Layoff"           {{ old('mode_of_separation') == 'Layoff'           ? 'selected' : '' }}>Layoff</option>
                  <option value="Fresher"          {{ old('mode_of_separation') == 'Fresher'          ? 'selected' : '' }}>Fresher</option>
                  <option value="Contract Closure" {{ old('mode_of_separation') == 'Contract Closure' ? 'selected' : '' }}>Contract Closure</option>
                </select>
                @if($errors->has('mode_of_separation'))<div class="field-error">{{ $errors->first('mode_of_separation') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Preferred Work Mode <span class="required">*</span></label>
                <select name="work_option" class="form-select{{ $errors->has('work_option') ? ' is-invalid' : '' }}" required>
                  <option value="">Select Mode</option>
                  <option value="Hybrid"  {{ old('work_option') == 'Hybrid'  ? 'selected' : '' }}>Hybrid</option>
                  <option value="Remote"  {{ old('work_option') == 'Remote'  ? 'selected' : '' }}>Remote</option>
                  <option value="WFO"     {{ old('work_option') == 'WFO'     ? 'selected' : '' }}>WFO</option>
                  <option value="Any"     {{ old('work_option') == 'Any'     ? 'selected' : '' }}>Any</option>
                </select>
                @if($errors->has('work_option'))<div class="field-error">{{ $errors->first('work_option') }}</div>@endif
              </div>
            </div>

            {{-- Gender / Total Experience --}}
            <div class="form-row">
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
              <div class="form-group">
                <label class="form-label">Total Experience <span class="required">*</span></label>
                <div style="display:flex;gap:6px;">
                  <select name="totalexp" class="form-select{{ $errors->has('totalexp') ? ' is-invalid' : '' }}" required>
                    <option value="">Year</option>
                    @for($y = 0; $y <= 30; $y++)
                      <option value="{{ $y }}" {{ old('totalexp') == $y ? 'selected' : '' }}>
                        {{ $y === 0 ? '0 (Fresher)' : "$y" }}
                      </option>
                    @endfor
                  </select>
                  <select name="totalexpmonth" class="form-select{{ $errors->has('totalexpmonth') ? ' is-invalid' : '' }}" required>
                    <option value="">Month</option>
                    @for($m = 0; $m <= 11; $m++)
                      <option value="{{ $m }}" {{ old('totalexpmonth') == $m ? 'selected' : '' }}>
                        {{ $m === 0 ? '0' : $m }}
                      </option>
                    @endfor
                  </select>
                </div>
                @if($errors->has('totalexp'))<div class="field-error">{{ $errors->first('totalexp') }}</div>@endif
              </div>
            </div>

            {{-- Latest Company / Latest Designation --}}
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Latest Company <span class="required">*</span></label>
                <input type="text" id="jsa-company-input" name="latestcom" class="form-input{{ $errors->has('latestcom') ? ' is-invalid' : '' }}" placeholder="Latest Company" value="{{ old('latestcom') }}" required autocomplete="off">
                @if($errors->has('latestcom'))<div class="field-error">{{ $errors->first('latestcom') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Latest Designation <span class="required">*</span></label>
                <input type="text" name="latestdesg" class="form-input{{ $errors->has('latestdesg') ? ' is-invalid' : '' }}" placeholder="Latest Designation" value="{{ old('latestdesg') }}" required>
                @if($errors->has('latestdesg'))<div class="field-error">{{ $errors->first('latestdesg') }}</div>@endif
              </div>
            </div>

            {{-- Key Skills (min 10) --}}
            <div class="form-group">
              <label class="form-label">Key Skills <span class="required">*</span></label>
              <div class="skills-tags" id="skills-container" onclick="document.getElementById('skill-input').focus()">
                <input type="text" id="skill-input" class="skills-text-input"
                       placeholder="Please enter key skills or technologies"
                       onkeydown="jsaHandleSkillInput(event)"
                       autocomplete="off">
              </div>
              <div class="skills-error" id="skills-error">Minimum 10 skills required</div>
              <div class="skills-hint">Press Enter or comma to add a skill. Minimum 10 skills required.</div>
              @if($errors->has('keyskills'))<div class="field-error">{{ $errors->first('keyskills') }}</div>@endif
            </div>

            {{-- Preferred Work Type --}}
            <div class="form-row">
              <div class="form-group" style="grid-column: 1 / -1;">
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

            {{-- Annual CTC / Expected Annual CTC --}}
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Annual CTC <span class="required">*</span></label>
                <div style="display:flex;gap:6px;">
                  <input type="number" name="expect_ctc_lakhs" class="form-input{{ $errors->has('expect_ctc_lakhs') ? ' is-invalid' : '' }}" placeholder="Lakh" min="0" value="{{ old('expect_ctc_lakhs') }}" required>
                  <input type="number" name="expect_ctc_thousand" class="form-input" placeholder="Thousand" min="0" max="99" value="{{ old('expect_ctc_thousand') }}">
                </div>
                @if($errors->has('expect_ctc_lakhs'))<div class="field-error">{{ $errors->first('expect_ctc_lakhs') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Expected Annual CTC <span class="required">*</span></label>
                <div style="display:flex;gap:6px;">
                  <input type="number" name="expect_ctc_lakhs3" class="form-input{{ $errors->has('expect_ctc_lakhs3') ? ' is-invalid' : '' }}" placeholder="Lakh" min="0" value="{{ old('expect_ctc_lakhs3') }}" required>
                  <input type="number" name="expect_ctc_thousand3" class="form-input" placeholder="Thousand" min="0" max="99" value="{{ old('expect_ctc_thousand3') }}">
                </div>
                @if($errors->has('expect_ctc_lakhs3'))<div class="field-error">{{ $errors->first('expect_ctc_lakhs3') }}</div>@endif
              </div>
            </div>

            <div class="step-nav">
              <button type="button" class="btn-secondary" onclick="jsaGoStep(1)">← Back</button>
              <button type="button" class="btn-primary" onclick="jsaGoStep(3)">Continue →</button>
            </div>
          </div>
          {{-- end step2 --}}

          {{-- ───── STEP 3: Education & Account ───── --}}
          <div id="step3" style="display:none;">

            {{-- Education Status / Highest Education --}}
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Education Status <span class="required">*</span></label>
                <select name="education_status" class="form-select{{ $errors->has('education_status') ? ' is-invalid' : '' }}" required>
                  <option value="">Select Status</option>
                  <option value="Completed"    {{ old('education_status') == 'Completed'    ? 'selected' : '' }}>Completed</option>
                  <option value="Pursuing"     {{ old('education_status') == 'Pursuing'     ? 'selected' : '' }}>Pursuing</option>
                  <option value="Discontinued" {{ old('education_status') == 'Discontinued' ? 'selected' : '' }}>Discontinued</option>
                </select>
                @if($errors->has('education_status'))<div class="field-error">{{ $errors->first('education_status') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Highest Education <span class="required">*</span></label>
                <select name="degree_title" id="degree_title_select" class="form-select{{ $errors->has('degree_title') ? ' is-invalid' : '' }}" required onchange="jsaDegreeChange(this.value)">
                  <option value="">Select Education</option>
                  @foreach($educations as $edu)
                    <option value="{{ $edu->id }}" {{ old('degree_title') == $edu->id ? 'selected' : '' }}>{{ $edu->education }}</option>
                  @endforeach
                </select>
                @if($errors->has('degree_title'))<div class="field-error">{{ $errors->first('degree_title') }}</div>@endif
              </div>
            </div>

            {{-- Year of Completion --}}
            <div class="form-row">
              <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label">Year of Completion <span class="required">*</span></label>
                <input type="text" name="year_of_completion" class="form-input{{ $errors->has('year_of_completion') ? ' is-invalid' : '' }}" placeholder="e.g. 2022" maxlength="4" value="{{ old('year_of_completion') }}" required>
                @if($errors->has('year_of_completion'))<div class="field-error">{{ $errors->first('year_of_completion') }}</div>@endif
              </div>
            </div>

            {{-- Course / Specialization (shown when degree > diploma/ug level) --}}
            <div class="form-row" id="course-spec-row" style="{{ in_array(old('degree_title'), ['2','3','4']) ? '' : 'display:none;' }}">
              <div class="form-group">
                <label class="form-label">Course <span class="required">*</span></label>
                <select name="course" id="course_select" class="form-select{{ $errors->has('course') ? ' is-invalid' : '' }}" onchange="jsaCourseChange(this.value)">
                  <option value="">Select Course</option>
                </select>
                @if($errors->has('course'))<div class="field-error">{{ $errors->first('course') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Specialization <span class="required">*</span></label>
                <select name="specilation" id="specilation_select" class="form-select{{ $errors->has('specilation') ? ' is-invalid' : '' }}">
                  <option value="">Select Specialization</option>
                </select>
                @if($errors->has('specilation'))<div class="field-error">{{ $errors->first('specilation') }}</div>@endif
              </div>
            </div>

            {{-- University / College --}}
            <div class="form-group" id="org-row" style="{{ in_array(old('degree_title'), ['2','3','4']) ? '' : 'display:none;' }}">
              <label class="form-label">University / College <span class="required">*</span></label>
              <input type="text" id="jsa-university-input" name="organization"
                     class="form-input{{ $errors->has('organization') ? ' is-invalid' : '' }}"
                     placeholder="Search university / college"
                     value="{{ old('organization') }}"
                     autocomplete="off">
              @if($errors->has('organization'))<div class="field-error">{{ $errors->first('organization') }}</div>@endif
            </div>

            {{-- Attach Resume --}}
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

            {{-- Set Your Password / Confirm Your Password --}}
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Set Your Password <span class="required">*</span></label>
                <div class="input-pass-wrap">
                  <input type="password" name="password" id="signup-password" class="form-input{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Min. 6 characters" required>
                  <button class="password-toggle" type="button" onclick="jsaTogglePass('signup-password', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  </button>
                </div>
                @if($errors->has('password'))<div class="field-error">{{ $errors->first('password') }}</div>@endif
              </div>
              <div class="form-group">
                <label class="form-label">Confirm Your Password <span class="required">*</span></label>
                <div class="input-pass-wrap">
                  <input type="password" name="password_confirmation" id="signup-password-confirm" class="form-input{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="Re-enter password" required>
                  <button class="password-toggle" type="button" onclick="jsaTogglePass('signup-password-confirm', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  </button>
                </div>
                @if($errors->has('password_confirmation'))<div class="field-error">{{ $errors->first('password_confirmation') }}</div>@endif
              </div>
            </div>

            {{-- Terms & Conditions --}}
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
    var immWrap   = document.getElementById('nop-date-wrap');
    var lwdWrap   = document.getElementById('nop-lwd-wrap');
    var proofWrap = document.getElementById('nop-lwd-proof-wrap');

    // Set date constraints
    var today = new Date().toISOString().split('T')[0];
    var maxServing = new Date(Date.now() + 90 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];

    if (immWrap) {
      var immInput = document.getElementById('nop-immediate-date');
      if (val === 'Immediate Joiner') {
        immWrap.classList.add('visible');
        if (immInput) { immInput.max = today; immInput.min = ''; }
      } else {
        immWrap.classList.remove('visible');
      }
    }
    if (lwdWrap) {
      var lwdInput = document.getElementById('nop-lwd-date');
      if (val === 'Serving Notice') {
        lwdWrap.classList.add('visible');
        if (lwdInput) { lwdInput.min = today; lwdInput.max = maxServing; }
      } else {
        lwdWrap.classList.remove('visible');
      }
    }
    if (proofWrap) {
      if (val === 'Immediate Joiner' || val === 'Serving Notice') {
        proofWrap.classList.add('visible');
      } else {
        proofWrap.classList.remove('visible');
      }
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
      'Step 1 of 3 — Notice Period & Personal Info',
      'Step 2 of 3 — Work Profile & Experience',
      'Step 3 of 3 — Education & Account'
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
      var req = ['first_name', 'last_name', 'nop_days', 'email', 'phone'];
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
      var req2 = ['current_city', 'locality', 'mode_of_separation', 'work_option',
                  'gender_id', 'totalexp', 'totalexpmonth', 'latestcom', 'latestdesg',
                  'work_type', 'expect_ctc_lakhs', 'expect_ctc_lakhs3'];
      var ok2 = true;
      req2.forEach(function (name) {
        var el = document.querySelector('#step2 [name="' + name + '"]');
        if (el && !el.value.trim()) {
          el.classList.add('is-invalid');
          ok2 = false;
        } else if (el) {
          el.classList.remove('is-invalid');
        }
      });
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

  /* ── Degree change: show/hide course/spec/org rows + load courses via AJAX ── */
  window.jsaDegreeChange = function (val) {
    var show = val !== '' && ['1','5'].indexOf(val) === -1; // show for degrees that have courses
    var csRow  = document.getElementById('course-spec-row');
    var orgRow = document.getElementById('org-row');
    if (csRow)  csRow.style.display  = show ? '' : 'none';
    if (orgRow) orgRow.style.display = show ? '' : 'none';
    // Toggle required attributes
    ['course_select', 'specilation_select'].forEach(function (id) {
      var el = document.getElementById(id);
      if (el) el.required = show;
    });
    var orgInput = document.getElementById('jsa-university-input');
    if (orgInput) orgInput.required = show;

    if (!show) return;

    // Load courses for selected degree
    var csEl = document.getElementById('course_select');
    if (!csEl) return;
    csEl.innerHTML = '<option value="">Loading...</option>';
    $.ajax({
      type: 'POST',
      url: '{{ url("gety") }}',
      data: { degree: val, _token: '{{ csrf_token() }}' },
      success: function (data) {
        var html = '<option value="">Select Course</option>';
        $.each(data, function (i, item) {
          html += '<option value="' + item.id + '">' + item.course + '</option>';
        });
        csEl.innerHTML = html;
        // Clear specs
        var spEl = document.getElementById('specilation_select');
        if (spEl) spEl.innerHTML = '<option value="">Select Specialization</option>';
      },
      error: function () {
        csEl.innerHTML = '<option value="">Select Course</option>';
      }
    });
  };

  /* ── Course change: load specializations via AJAX ── */
  window.jsaCourseChange = function (courseId) {
    var spEl = document.getElementById('specilation_select');
    if (!spEl) return;
    if (!courseId) {
      spEl.innerHTML = '<option value="">Select Specialization</option>';
      return;
    }
    spEl.innerHTML = '<option value="">Loading...</option>';
    $.ajax({
      type: 'POST',
      url: '{{ url("getspecs") }}',
      data: { course: courseId, _token: '{{ csrf_token() }}' },
      success: function (data) {
        var html = '<option value="">Select Specialization</option>';
        $.each(data, function (i, item) {
          html += '<option value="' + item.id + '">' + item.specs + '</option>';
        });
        spEl.innerHTML = html;
      },
      error: function () {
        spEl.innerHTML = '<option value="">Select Specialization</option>';
      }
    });
  };

  /* ── Final submit validation ── */
  window.jsaHandleSignUp = function () {
    if (jsaSkills.length < 10) {
      document.getElementById('skills-error').style.display = 'block';
      jsaGoStep(2);
      return false;
    }
    var resumeInput = document.getElementById('resume-upload');
    if (resumeInput && !resumeInput.files.length) {
      alert('Please attach your resume before submitting.');
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
      @if ($errors->hasAny(['degree_title','education_status','course','specilation','organization','year_of_completion','resume','password','password_confirmation','terms_of_use']))
      jsaGoStep(3);
      @elseif ($errors->hasAny(['current_city','locality','mode_of_separation','work_option','gender_id','totalexp','totalexpmonth','latestcom','latestdesg','keyskills','work_type','expect_ctc_lakhs','expect_ctc_lakhs3']))
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

    // Restore degree-dependent fields (AJAX-driven, chain-load old values)
    var degSelect = document.getElementById('degree_title_select');
    @if(old('degree_title'))
    if (degSelect) {
      // jsaDegreeChange triggers AJAX for courses; we override success to also restore old course/spec
      (function () {
        var oldCourse = '{{ old('course') }}';
        var oldSpec   = '{{ old('specilation') }}';
        degSelect.value = '{{ old('degree_title') }}';
        // Show rows immediately
        var show = ['2','3','4'].indexOf('{{ old('degree_title') }}') !== -1;
        var csRow  = document.getElementById('course-spec-row');
        var orgRow = document.getElementById('org-row');
        if (csRow)  csRow.style.display  = show ? '' : 'none';
        if (orgRow) orgRow.style.display = show ? '' : 'none';
        if (!show) return;
        // Load courses then restore selection
        $.ajax({
          type: 'POST',
          url: '{{ url("gety") }}',
          data: { degree: '{{ old('degree_title') }}', _token: '{{ csrf_token() }}' },
          success: function (data) {
            var csEl = document.getElementById('course_select');
            if (!csEl) return;
            var html = '<option value="">Select Course</option>';
            $.each(data, function (i, item) {
              html += '<option value="' + item.id + '"' + (oldCourse == item.id ? ' selected' : '') + '>' + item.course + '</option>';
            });
            csEl.innerHTML = html;
            if (!oldCourse) return;
            // Load specs for restored course
            $.ajax({
              type: 'POST',
              url: '{{ url("getspecs") }}',
              data: { course: oldCourse, _token: '{{ csrf_token() }}' },
              success: function (sData) {
                var spEl = document.getElementById('specilation_select');
                if (!spEl) return;
                var sHtml = '<option value="">Select Specialization</option>';
                $.each(sData, function (i, item) {
                  sHtml += '<option value="' + item.id + '"' + (oldSpec == item.id ? ' selected' : '') + '>' + item.specs + '</option>';
                });
                spEl.innerHTML = sHtml;
              }
            });
          }
        });
      }());
    }
    @else
    if (degSelect && degSelect.value) {
      jsaDegreeChange(degSelect.value);
    }
    @endif

    // Restore pre-checked city chips
    document.querySelectorAll('.znp-jobseeker-auth .city-chip.selected').forEach(function () {
      jsaSyncPreferredCities();
    });
  }());

})();
</script>

<script>
$(function () {

  /* ─── helper for text highlight in dropdown ─── */
  function jsaAcHighlight($menu, term) {
    $menu.find('li').each(function () {
      var item = $(this).data('ui-autocomplete-item');
      if (item) {
        var hl = item.label.replace(
          new RegExp($.ui.autocomplete.escapeRegex(term), 'gi'),
          '<span class="highlight">$&</span>'
        );
        $(this).find('.ui-menu-item-wrapper').html(hl);
      }
    });
  }

  /* ─── 1. Current City ─────────────────────────────────────── */
  $('#jsa-city-input').autocomplete({
    minLength: 1,
    appendTo: '.znp-jobseeker-auth',
    source: function (req, res) {
      $.ajax({
        url: '{{ url("autocomplete/search-location-job1") }}',
        dataType: 'json',
        data: { query: req.term },
        success: function (data) {
          res($.map(data, function (v) { return { label: v, value: v }; }));
        }
      });
    },
    focus: function () { return false; },
    open: function () { jsaAcHighlight($(this).autocomplete('widget'), this.value); },
    select: function (e, ui) { this.value = ui.item.value; return false; }
  });

  /* ─── 2. Latest Company ───────────────────────────────────── */
  $('#jsa-company-input').autocomplete({
    minLength: 1,
    appendTo: '.znp-jobseeker-auth',
    source: function (req, res) {
      $.ajax({
        url: '{{ url("search-companies") }}',
        dataType: 'json',
        data: { q: req.term },
        success: function (data) {
          res($.map(data, function (c) { return { label: c.name, value: c.name, id: c.id }; }));
        }
      });
    },
    focus: function () { return false; },
    open: function () { jsaAcHighlight($(this).autocomplete('widget'), this.value); },
    select: function (e, ui) { this.value = ui.item.value; return false; }
  });

  /* ─── 3. Jobseeker Privacy (hide from companies) — multi-value ─ */
  function splitIgnore(val) { return val.split(/,\s*/); }
  function extractLastIgnore(term) { return splitIgnore(term).pop(); }

  $('#jsa-ignore-input')
    .on('keydown', function (e) {
      if (e.keyCode === $.ui.keyCode.TAB && $(this).autocomplete('instance').menu.active) {
        e.preventDefault();
      }
    })
    .autocomplete({
      minLength: 1,
      appendTo: '.znp-jobseeker-auth',
      source: function (req, res) {
        $.ajax({
          url: '{{ url("search-companies") }}',
          dataType: 'json',
          data: { q: extractLastIgnore(req.term) },
          success: function (data) {
            res($.map(data, function (c) { return { label: c.name, value: c.name }; }));
          }
        });
      },
      focus: function () { return false; },
      open: function () {
        jsaAcHighlight($(this).autocomplete('widget'), extractLastIgnore(this.value));
      },
      select: function (e, ui) {
        var terms = splitIgnore(this.value);
        terms.pop();
        terms.push(ui.item.value);
        terms.push('');
        this.value = terms.join(', ');
        return false;
      }
    });

  /* ─── 4. Key Skills ──────────────────────────────────────── */
  $('#skill-input').autocomplete({
    minLength: 2,
    appendTo: '.znp-jobseeker-auth',
    source: function (req, res) {
      $.ajax({
        url: '{{ url("autocomplete/cvskills") }}',
        dataType: 'json',
        data: { query: req.term },
        success: function (data) {
          res($.map(data, function (v) { return { label: v, value: v }; }));
        }
      });
    },
    focus: function () { return false; },
    open: function () { jsaAcHighlight($(this).autocomplete('widget'), this.value); },
    select: function (e, ui) {
      jsaAddSkill(ui.item.value);
      this.value = '';
      $(this).autocomplete('close');
      return false;
    }
  });

  /* ─── 5. University / College ─────────────────────────────── */
  $('#jsa-university-input').autocomplete({
    minLength: 2,
    appendTo: '.znp-jobseeker-auth',
    source: function (req, res) {
      $.ajax({
        url: '{{ url("search-university") }}',
        dataType: 'json',
        data: { q: req.term },
        success: function (data) {
          res($.map(data, function (u) { return { label: u.educations, value: u.educations }; }));
        }
      });
    },
    focus: function () { return false; },
    open: function () { jsaAcHighlight($(this).autocomplete('widget'), this.value); },
    select: function (e, ui) { this.value = ui.item.value; return false; }
  });

});
</script>

<script>
// ── Success modal (shown when session('new_message') exists) ──
document.addEventListener('DOMContentLoaded', function () {
  var AUTOCLOSE_MS = 6000;
  var modal = document.getElementById('znp-success-modal');
  if (!modal) return;

  // Force Sign In tab to show behind the modal
  var tabSignin = document.getElementById('tab-signin');
  var tabSignup  = document.getElementById('tab-signup');
  if (tabSignin) { tabSignin.classList.add('active');   tabSignup.classList.remove('active'); }
  var secSignin = document.getElementById('section-signin');
  var secSignup  = document.getElementById('section-signup');
  if (secSignin) { secSignin.classList.add('active');   secSignup.classList.remove('active'); }

  // Set auto-close bar duration
  var content = modal.querySelector('.znp-modal-content');
  if (content) content.style.setProperty('--znp-bar-dur', (AUTOCLOSE_MS / 1000) + 's');

  // Open with tiny delay so CSS transition fires
  setTimeout(function () { modal.classList.add('open'); }, 16);

  var prevFocus = document.activeElement;
  var autoCloseTimer = null;

  function jsaClose () {
    modal.classList.remove('open');
    if (autoCloseTimer) { clearTimeout(autoCloseTimer); autoCloseTimer = null; }
    if (prevFocus && prevFocus.focus) prevFocus.focus();
  }
  window.jsaCloseSuccessModal = jsaClose;

  // "Continue to Sign In" button
  var cta = document.getElementById('jsa-success-close');
  if (cta) { cta.focus(); cta.addEventListener('click', jsaClose); }

  // Auto-close
  autoCloseTimer = setTimeout(jsaClose, AUTOCLOSE_MS);

  // Pause on hover
  modal.addEventListener('mouseenter', function () {
    modal.classList.add('paused');
    if (autoCloseTimer) { clearTimeout(autoCloseTimer); autoCloseTimer = null; }
  });
  modal.addEventListener('mouseleave', function () {
    modal.classList.remove('paused');
    if (!autoCloseTimer) autoCloseTimer = setTimeout(jsaClose, 2500);
  });

  // ESC key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') jsaClose();
  });
});
</script>
@endpush
