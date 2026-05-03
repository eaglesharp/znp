@extends('layouts.znp')

@section('page_title', 'Employer sign in & registration | ZeroNoticePeriod')

@push('styles')
<style>
/* ── ZNP EMPLOYER-AUTH: SCOPE & RESET ── */
.znp-employer-auth,
.znp-employer-auth * {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}
.znp-employer-auth { background: var(--bg); color: var(--text); font-size: 12px; }
.znp-employer-auth a   { color: inherit; text-decoration: none; }
.znp-employer-auth p   { margin: 0; }
.znp-employer-auth ul  { list-style: none; padding: 0; margin: 0; }
.znp-employer-auth button { font-family: inherit !important; }

/* ── MAIN CONTENT WRAPPER ── */
.znp-employer-auth {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
}

/* ── AUTH CONTAINER ── */
.znp-employer-auth .auth-container {
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
.znp-employer-auth .info-panel {
    background: linear-gradient(135deg, #1a3faa 0%, #152f85 100%);
    padding: 28px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}
.znp-employer-auth .info-panel::before {
    content: '';
    position: absolute;
    top: -100px; right: -100px;
    width: 300px; height: 300px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}
.znp-employer-auth .info-panel::after {
    content: '';
    position: absolute;
    bottom: -120px; left: -80px;
    width: 280px; height: 280px;
    background: rgba(249,115,22,0.15);
    border-radius: 50%;
}
.znp-employer-auth .info-content {
    position: relative;
    z-index: 1;
}
.znp-employer-auth .logo-section { margin-bottom: 20px; }
.znp-employer-auth .logo-section .logo-text {
    font-size: 14px !important;
    font-weight: 800 !important;
    color: var(--white);
    display: flex;
    flex-wrap: wrap;
    line-height: 1.3;
}
.znp-employer-auth .logo-section .logo-blue,
.znp-employer-auth .logo-section .logo-part-3 { color: var(--white) !important; }
.znp-employer-auth .logo-section .logo-orange { color: var(--orange) !important; }

.znp-employer-auth .info-headline {
    font-size: 16px !important;
    font-weight: 600 !important;
    color: var(--white) !important;
    line-height: 1.3;
    margin-bottom: 8px;
    letter-spacing: -0.3px;
}
.znp-employer-auth .info-headline .highlight { color: var(--orange) !important; }

.znp-employer-auth .info-desc {
    font-size: 10px !important;
    color: rgba(255,255,255,0.9) !important;
    line-height: 1.5;
    margin-bottom: 16px;
}

.znp-employer-auth .info-features {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.znp-employer-auth .feature-item {
    display: flex;
    align-items: flex-start;
    gap: 8px;
}
.znp-employer-auth .feature-icon {
    width: 24px; height: 24px;
    background: rgba(255,255,255,0.15);
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.znp-employer-auth .feature-icon svg {
    width: 12px !important; height: 12px !important;
    stroke: var(--white) !important; color: var(--white) !important;
}
.znp-employer-auth .feature-title {
    font-size: 10px !important;
    font-weight: 700 !important;
    color: var(--white) !important;
    margin-bottom: 1px;
}
.znp-employer-auth .feature-desc {
    font-size: 9px !important;
    color: rgba(255,255,255,0.8) !important;
    line-height: 1.4;
}

/* ── ROLES CAROUSEL ── */
.znp-employer-auth .info-stats {
    position: relative;
    z-index: 1;
    margin-top: 10px;
    overflow: hidden;
}
.znp-employer-auth .rc-label {
    font-size: 8px !important;
    font-weight: 700 !important;
    color: var(--orange) !important;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    text-align: center;
    margin-bottom: 8px;
    opacity: 0.9;
}
.znp-employer-auth .roles-carousel {
    display: flex;
    flex-direction: column;
    gap: 6px;
    position: relative;
}
.znp-employer-auth .roles-carousel::before,
.znp-employer-auth .roles-carousel::after {
    content: '';
    position: absolute;
    top: 0; bottom: 0;
    width: 30px;
    z-index: 2;
    pointer-events: none;
}
.znp-employer-auth .roles-carousel::before {
    left: 0;
    background: linear-gradient(to right, #152f85 0%, transparent 100%);
}
.znp-employer-auth .roles-carousel::after {
    right: 0;
    background: linear-gradient(to left, #152f85 0%, transparent 100%);
}
.znp-employer-auth .roles-carousel:hover .rc-row {
    animation-play-state: paused;
}

@keyframes znpScrollLeft  { 0% { transform: translateX(0); }    100% { transform: translateX(-50%); } }
@keyframes znpScrollRight { 0% { transform: translateX(-50%); } 100% { transform: translateX(0); } }

.znp-employer-auth .rc-row {
    display: flex;
    gap: 6px;
    width: max-content;
    animation: znpScrollLeft 20s linear infinite;
}
.znp-employer-auth .rc-row.reverse { animation: znpScrollRight 16s linear infinite; }
.znp-employer-auth .rc-row:nth-child(3) { animation-duration: 24s; }

.znp-employer-auth .rc-pill {
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    border-radius: 100px;
    cursor: default;
    line-height: 1;
    font-size: 9px !important;
    padding: 4px 10px;
    transition: all 0.2s;
}
.znp-employer-auth .rc-pill:hover { transform: scale(1.05); }
.znp-employer-auth .rc-pill.bold  { background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.22); color: #fff !important; font-weight: 700 !important; }
.znp-employer-auth .rc-pill.light { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.55) !important; font-weight: 400 !important; }
.znp-employer-auth .rc-pill.ghost { background: transparent; border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.28) !important; font-weight: 400 !important; }
.znp-employer-auth .rc-pill.accent{ background: rgba(249,115,22,0.18); border: 1px solid rgba(249,115,22,0.5); color: #ffb07a !important; font-weight: 700 !important; }

.znp-employer-auth .rc-pill .pulse {
    width: 4px; height: 4px;
    border-radius: 50%;
    background: #4ade80;
    display: inline-block;
    margin-right: 4px;
    flex-shrink: 0;
    animation: znpRcpulse 2s ease-in-out infinite;
}
@keyframes znpRcpulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50%      { opacity: 0.35; transform: scale(0.7); }
}

/* ── RIGHT FORM PANEL ── */
.znp-employer-auth .form-panel {
    padding: 36px 42px;
    display: flex;
    flex-direction: column;
    background: var(--white);
}
/* .znp-employer-auth .form-header { margin-bottom: 24px; } */

.znp-employer-auth .tab-switcher {
    display: flex;
    background: #f3f4f8;
    border-radius: 10px;
    padding: 3px;
    /* margin-bottom: 20px; */
}
.znp-employer-auth .tab-btn {
    flex: 1;
    padding: 10px 16px;
    /* mild blue border identical to Find Jobs button — keeps layout stable */
    border: 2px solid rgba(26,90,203,0.18);
    background: transparent;
    color: var(--text-muted);
    font-size: 13px !important;
    font-weight: 700 !important;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}
.znp-employer-auth .tab-btn.active {
    background: var(--white);
    color: var(--blue) !important;
    box-shadow: 0 1px 2px rgba(0,0,0,0.08);
    /* solid brand border on active */
    border-color: #cbdeff;
}
.znp-employer-auth .tab-btn:hover:not(.active) { color: var(--text) !important; }
.znp-employer-auth .tab-btn:focus { outline: none; box-shadow: 0 0 0 2px rgba(26,63,170,0.08); }
.znp-employer-auth .tab-btn.active:focus { border-color: #cbdeff; }

.znp-employer-auth .form-section { display: none; }
.znp-employer-auth .form-section.active { display: block; }
.znp-employer-auth .form-content { flex: 1; }
/* Fixed panel height so Sign-In and Sign-Up tabs never resize the card.
   min-height is set to accommodate the tallest step (Sign Up step 1).
   overflow-y: auto handles if content ever exceeds this on small screens. */
.znp-employer-auth .form-panel {
    min-height: 500px;
    overflow-y: auto;
}

.znp-employer-auth .form-title {
    font-size: 20px !important;
    font-weight: 800 !important;
    color: var(--text) !important;
    margin-bottom: 6px;
    letter-spacing: -0.5px;
}
.znp-employer-auth .form-subtitle {
    font-size: 12px !important;
    color: var(--text-muted) !important;
    line-height: 1.6;
}

/* ── Progress bar ── */
.znp-employer-auth .znp-step-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
}
.znp-employer-auth .znp-step-seg {
    height: 3px;
    flex: 1;
    background: var(--border);
    border-radius: 2px;
    transition: background 0.3s;
}
.znp-employer-auth .znp-step-seg.active { background: var(--blue); }
.znp-employer-auth .znp-step-label {
    font-size: 11px !important;
    color: var(--text-muted) !important;
    font-weight: 600 !important;
    text-align: center;
    margin-top: 6px;
}

/* ── Form elements ── */
.znp-employer-auth .form-group { margin-bottom: 14px; }
.znp-employer-auth .form-label {
    display: block;
    font-size: 12px !important;
    font-weight: 600 !important;
    color: var(--text) !important;
    margin-bottom: 5px;
}
/* ── Validation error state ── */
.znp-employer-auth .form-input.is-invalid,
.znp-employer-auth .form-select.is-invalid {
    border-color: #dc2626 !important;
    box-shadow: 0 0 0 3px rgba(220,38,38,0.1);
}
.znp-employer-auth .znp-fe-err {
    display: block;
    color: #dc2626 !important;
    font-size: 11px !important;
    margin-top: 4px;
    line-height: 1.4;
}
.znp-employer-auth .required { color: #dc2626 !important; margin-left: 2px; }

.znp-employer-auth .form-input,
.znp-employer-auth .form-select {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    font-size: 13px !important;
    color: var(--text) !important;
    background: var(--white);
    transition: all 0.2s;
    outline: none;
}
.znp-employer-auth .form-input:focus,
.znp-employer-auth .form-select:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 4px rgba(26,63,170,0.08);
}
.znp-employer-auth .form-input::placeholder { color: var(--text-light) !important; }
.znp-employer-auth .form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 40px;
    cursor: pointer;
}
.znp-employer-auth .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

/* ── Input with icon ── */
.znp-employer-auth .input-with-icon { position: relative; }
.znp-employer-auth .input-icon-left {
    position: absolute;
    left: 12px; top: 50%;
    transform: translateY(-50%);
    color: var(--text-light);
    width: 14px !important; height: 14px !important;
    pointer-events: none;
}
.znp-employer-auth .input-with-icon .form-input { padding-left: 38px; }
#signup-password { padding-left: 14px !important; }
#signup-password,#signup-password-confirm { padding-left: 14px !important; }

.znp-employer-auth .password-toggle {
    position: absolute;
    right: 14px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none;
    color: var(--text-light);
    cursor: pointer; padding: 4px;
    display: flex; align-items: center; justify-content: center;
    transition: color 0.2s;
}
.znp-employer-auth .password-toggle:hover { color: var(--text-muted); }
.znp-employer-auth .password-toggle svg { width: 18px !important; height: 18px !important; }

/* ── Form options ── */
.znp-employer-auth .form-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}
.znp-employer-auth .checkbox-label {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px !important;
    color: var(--text-muted) !important;
    cursor: pointer;
}
.znp-employer-auth .checkbox-label input[type="checkbox"] {
    width: 14px; height: 14px;
    accent-color: var(--blue); cursor: pointer;
}
.znp-employer-auth .forgot-link {
    font-size: 12px !important;
    font-weight: 600 !important;
    color: var(--blue) !important;
    text-decoration: none;
    transition: color 0.2s;
}
.znp-employer-auth .forgot-link:hover { color: var(--blue-dark) !important; text-decoration: underline; }

/* ── Buttons ── */
.znp-employer-auth .btn-primary {
    width: 100%;
    padding: 11px 20px;
    background: #eef2ff;
    border: none;
    border-radius: 8px;
    color: var(--blue) !important;
    font-weight: 600 !important;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(26,63,170,0.2);
}
.znp-employer-auth .btn-primary:hover {
    background: #eef2ff;
    box-shadow: 0 6px 16px rgba(26,63,170,0.3);
    transform: translateY(-1px);
}
.znp-employer-auth .btn-secondary {
    width: 100%;
    padding: 11px 20px;
    background: transparent;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    color: var(--text) !important;
    font-size: 13px !important; font-weight: 700 !important;
    cursor: pointer;
    transition: all 0.2s;
}
.znp-employer-auth .btn-secondary:hover {
    border-color: var(--blue);
    color: var(--blue) !important;
    background: #f0f5ff;
}
.znp-employer-auth .step-nav { display: flex; gap: 10px; margin-top: 18px; }
.znp-employer-auth .step-nav .btn-secondary { flex: 0 0 100px; }
.znp-employer-auth .step-nav .btn-primary   { flex: 1; }

/* ── Alt action ── */
.znp-employer-auth .alt-action {
    text-align: center;
    font-size: 12px !important;
    color: var(--text-muted) !important;
    margin-top: 18px;
}
.znp-employer-auth .alt-action a {
    color: var(--blue) !important;
    font-weight: 600 !important;
    cursor: pointer; text-decoration: none;
}
.znp-employer-auth .alt-action a:hover { text-decoration: underline; }

/* ── Info note (step 3) ── */
.znp-employer-auth .info-note {
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 8px;
    padding: 10px 12px;
    margin-bottom: 16px;
    display: flex; gap: 8px; align-items: flex-start;
}
.znp-employer-auth .info-note svg {
    width: 14px !important; height: 14px !important;
    color: #0284c7 !important;
    flex-shrink: 0; margin-top: 2px;
}
.znp-employer-auth .info-note-text {
    font-size: 11px !important;
    color: #0c4a6e !important;
    line-height: 1.6;
}

/* ── File upload ── */
.znp-employer-auth .file-upload { position: relative; }
.znp-employer-auth .file-upload-label {
    display: flex; align-items: center; justify-content: center;
    gap: 6px; padding: 10px 16px;
    border: 2px dashed var(--border);
    border-radius: 8px; background: #fafafa;
    cursor: pointer; transition: all 0.2s;
    font-size: 12px !important; font-weight: 600 !important;
    color: var(--text-muted) !important;
}
.znp-employer-auth .file-upload-label:hover {
    border-color: var(--blue); background: #f0f5ff;
    color: var(--blue) !important;
}
.znp-employer-auth .file-upload-label svg { width: 14px !important; height: 14px !important; }
.znp-employer-auth .file-upload input[type="file"] {
    position: absolute; opacity: 0; width: 0; height: 0;
}
.znp-employer-auth .file-name {
    font-size: 11px !important;
    color: var(--text-muted) !important;
    margin-top: 5px; font-style: italic;
}

/* ── Checkbox group (step 3) ── */
.znp-employer-auth .checkbox-group {
    display: flex; flex-direction: column; gap: 10px; margin-bottom: 18px;
}
.znp-employer-auth .checkbox-item {
    display: flex; align-items: flex-start; gap: 8px;
    font-size: 11px !important; color: var(--text-muted) !important; line-height: 1.6;
}
.znp-employer-auth .checkbox-item input[type="checkbox"] {
    margin-top: 2px; width: 14px; height: 14px;
    accent-color: var(--blue); cursor: pointer; flex-shrink: 0;
}
.znp-employer-auth .checkbox-item a {
    color: var(--blue) !important; font-weight: 600 !important; text-decoration: none;
}
.znp-employer-auth .checkbox-item a:hover { text-decoration: underline; }

/* ── Alerts ── */
.znp-employer-auth .znp-alert {
    padding: 10px 14px; border-radius: 8px;
    font-size: 12px !important; margin-bottom: 16px;
    display: flex; align-items: flex-start; gap: 8px;
}
.znp-employer-auth .znp-alert-error  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626 !important; }
.znp-employer-auth .znp-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a !important; }
/* ── Success modal ── */
/* ── Success modal ── */
.znp-employer-auth .znp-modal {
    display: none;
    position: fixed; inset: 0;
    z-index: 9999;
    align-items: center; justify-content: center;
    padding: 20px;
}
.znp-employer-auth .znp-modal.open { display: flex; }
.znp-employer-auth .znp-modal-overlay {
    position: absolute; inset: 0;
    background: rgba(10,18,50,0.55);
    backdrop-filter: blur(3px);
    opacity: 0; transition: opacity 280ms ease;
}
.znp-employer-auth .znp-modal.open .znp-modal-overlay { opacity: 1; }

.znp-employer-auth .znp-modal-content {
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
.znp-employer-auth .znp-modal.open .znp-modal-content {
    transform: translateY(0) scale(1);
    opacity: 1;
}

/* top-right × */
.znp-employer-auth .znp-modal-topclose {
    position: absolute; right: 14px; top: 14px;
    width: 28px; height: 28px;
    border-radius: 50%; background: #f3f4f6; border: none;
    cursor: pointer; color: #6b7280;
    font-size: 16px; line-height: 28px; text-align: center;
    display: flex; align-items: center; justify-content: center;
    transition: background 150ms;
}
.znp-employer-auth .znp-modal-topclose:hover { background: #e5e7eb; color: #111827; }
.znp-employer-auth .znp-modal-topclose:focus { outline: none; }

/* icon ring */
.znp-employer-auth .znp-modal-icon-wrap {
    width: 76px; height: 76px;
    border-radius: 50%;
    background: linear-gradient(135deg,#e8effe,#dbeafe);
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 18px;
    position: relative;
}
.znp-employer-auth .znp-modal-icon-wrap::before {
    content: '';
    position: absolute; inset: -6px;
    border-radius: 50%;
    border: 2px solid rgba(59,130,246,0.18);
}
.znp-employer-auth .znp-check {
    width: 52px; height: 52px; border-radius: 50%;
    background: linear-gradient(135deg,#2563eb,#1a3faa);
    box-shadow: 0 8px 24px rgba(37,99,235,0.30);
    display: inline-grid; place-items: center;
}
.znp-employer-auth .znp-check svg {
    width: 26px; height: 26px;
    stroke: #fff; stroke-width: 2.5;
    stroke-linecap: round; stroke-linejoin: round; fill: none;
}
.znp-employer-auth .znp-check .chkpath {
    stroke-dasharray: 48; stroke-dashoffset: 48;
    animation: znpChkDraw 400ms ease forwards 200ms;
}
@keyframes znpChkDraw { to { stroke-dashoffset: 0; } }

/* text */
.znp-employer-auth .znp-modal-content h3 {
    margin: 0 0 8px; font-size: 20px; font-weight: 800;
    color: #0f172a;
}
.znp-employer-auth .znp-modal-content .znp-modal-msg {
    font-size: 13.5px; color: #475569; line-height: 1.6;
    margin: 0 0 24px;
}

/* CTA */
.znp-employer-auth .znp-modal-cta {
    display: block; width: 100%;
    padding: 13px 0;
    background: linear-gradient(135deg,#2563eb,#1a3faa);
    color: #fff !important; font-weight: 700; font-size: 14px;
    border: none; border-radius: 12px;
    cursor: pointer; margin-bottom: 20px;
    transition: opacity 150ms;
}
.znp-employer-auth .znp-modal-cta:hover { opacity: 0.9; }
.znp-employer-auth .znp-modal-cta:focus { outline: none; box-shadow: 0 0 0 4px rgba(37,99,235,0.18); }

/* auto-close progress bar */
.znp-employer-auth .znp-modal-bar-wrap {
    height: 3px; background: #f1f5f9;
    position: absolute; bottom: 0; left: 0; right: 0;
}
.znp-employer-auth .znp-modal-bar {
    height: 100%;
    background: linear-gradient(90deg,#2563eb,#60a5fa);
    width: 100%;
    transform-origin: left;
    animation: znpBarShrink var(--znp-bar-dur,6s) linear forwards;
}
@keyframes znpBarShrink { to { transform: scaleX(0); } }
.znp-employer-auth .znp-modal.paused .znp-modal-bar { animation-play-state: paused; }

/* ── RESPONSIVE ── */
@media (max-width: 968px) {
    .znp-employer-auth .auth-container { grid-template-columns: 1fr; }
    .znp-employer-auth .info-panel { display: none; }
    .znp-employer-auth .form-panel { padding: 40px 32px; }
}
@media (max-width: 640px) {
    .znp-employer-auth { padding: 0; }
    .znp-employer-auth .auth-container { border-radius: 0; box-shadow: none; }
    .znp-employer-auth .form-panel { padding: 32px 24px; }
    .znp-employer-auth .form-row { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
@include('znp.header')

<div class="znp-employer-auth">
  <div class="auth-container">

    {{-- ══════════ LEFT PANEL ══════════ --}}
    <div class="info-panel">
      <div class="info-content">
        <div class="logo-section">
          <div class="logo-text">
            <span class="logo-blue">Zero</span><span class="logo-orange">Notice</span><span class="logo-part-3">Period</span>
          </div>
        </div>

        <h1 class="info-headline">
          Stop losing time chasing<br>candidates with <span class="highlight">notice periods</span>
        </h1>

        <p class="info-desc">
          Find verified immediate joiners today. No waiting, no delays—just instant access to ready talent.
        </p>

        <div class="info-features">
          <div class="feature-item">
            <div class="feature-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
              </svg>
            </div>
            <div class="feature-text">
              <div class="feature-title">Verified Zero-Notice Database</div>
              <div class="feature-desc">Pre-screened candidates confirmed to join immediately</div>
            </div>
          </div>

          <div class="feature-item">
            <div class="feature-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              </svg>
            </div>
            <div class="feature-text">
              <div class="feature-title">Immediate Joiners Only</div>
              <div class="feature-desc">Get applications only from candidates ready to start now</div>
            </div>
          </div>

          <div class="feature-item">
            <div class="feature-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
              </svg>
            </div>
            <div class="feature-text">
              <div class="feature-title">Contractors &amp; Permanent Hires</div>
              <div class="feature-desc">Find both contract workers and full-time employees</div>
            </div>
          </div>

          <div class="feature-item">
            <div class="feature-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
              </svg>
            </div>
            <div class="feature-text">
              <div class="feature-title">Bulk Job Posts Available</div>
              <div class="feature-desc">Save more with our cost-effective bulk posting packages</div>
            </div>
          </div>
        </div>
      </div>

      <div class="info-stats">
        <div class="rc-label">⚡ Available immediately</div>
        <div class="roles-carousel">
          {{-- Row 1 --}}
          <div class="rc-row">
            <span class="rc-pill bold"><span class="pulse"></span>Data Scientist</span>
            <span class="rc-pill light">SEO Executive</span>
            <span class="rc-pill bold">Sr. .NET Dev</span>
            <span class="rc-pill ghost">HR Coordinator</span>
            <span class="rc-pill bold">DevOps Engineer</span>
            <span class="rc-pill light">Product Manager</span>
            <span class="rc-pill ghost">Scrum Master</span>
            <span class="rc-pill bold">Full Stack Dev</span>
            <span class="rc-pill light">Business Analyst</span>
            <span class="rc-pill bold"><span class="pulse"></span>Data Scientist</span>
            <span class="rc-pill light">SEO Executive</span>
            <span class="rc-pill bold">Sr. .NET Dev</span>
            <span class="rc-pill ghost">HR Coordinator</span>
            <span class="rc-pill bold">DevOps Engineer</span>
          </div>
          {{-- Row 2 (reverse) --}}
          <div class="rc-row reverse">
            <span class="rc-pill light">Sales Manager</span>
            <span class="rc-pill bold">Java Developer</span>
            <span class="rc-pill accent">Financial Analyst</span>
            <span class="rc-pill bold">UI/UX Designer</span>
            <span class="rc-pill light">Talent Acquisition</span>
            <span class="rc-pill bold"><span class="pulse"></span>Tech Architect</span>
            <span class="rc-pill ghost">Content Writer</span>
            <span class="rc-pill bold">React Developer</span>
            <span class="rc-pill light">Sales Manager</span>
            <span class="rc-pill bold">Java Developer</span>
            <span class="rc-pill accent">Financial Analyst</span>
            <span class="rc-pill bold">UI/UX Designer</span>
            <span class="rc-pill light">Talent Acquisition</span>
          </div>
          {{-- Row 3 --}}
          <div class="rc-row">
            <span class="rc-pill bold">SAP Consultant</span>
            <span class="rc-pill ghost">Executive Asst</span>
            <span class="rc-pill light">BPO Operations</span>
            <span class="rc-pill bold"><span class="pulse"></span>Cloud Architect</span>
            <span class="rc-pill accent">HR Manager</span>
            <span class="rc-pill bold">Biz Dev Manager</span>
            <span class="rc-pill ghost">QA Engineer</span>
            <span class="rc-pill light">Graphic Designer</span>
            <span class="rc-pill bold"><span class="pulse"></span>Python Dev</span>
            <span class="rc-pill bold">SAP Consultant</span>
            <span class="rc-pill ghost">Executive Asst</span>
            <span class="rc-pill light">BPO Operations</span>
          </div>
        </div>
      </div>
    </div>

    {{-- ══════════ RIGHT FORM PANEL ══════════ --}}
    <div class="form-panel">
      <div class="form-header">
        <div class="tab-switcher">
          <button class="tab-btn active" onclick="znpSwitchTab('signin')" id="tab-signin">Employer Sign In</button>
          <button class="tab-btn" onclick="znpSwitchTab('signup')" id="tab-signup">Employer Sign Up</button>
        </div>
      </div>

      <div class="form-content">

        {{-- Success modal (shown when session('success') exists) --}}
        @if(session('success'))
          <div id="znp-success-modal" class="znp-modal" role="dialog" aria-modal="true">
            <div class="znp-modal-overlay" onclick="znpCloseSuccessModal()"></div>
            <div class="znp-modal-content" role="document">

              <button class="znp-modal-topclose" aria-label="Close" onclick="znpCloseSuccessModal()">
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
              <p class="znp-modal-msg">{{ session('success') }}</p>

              <button id="znp-success-close" class="znp-modal-cta">Continue to Sign In</button>

              <div class="znp-modal-bar-wrap">
                <div class="znp-modal-bar" id="znp-modal-bar"></div>
              </div>
            </div>
          </div>
        @endif

        {{-- ═══ SIGN IN FORM ═══ --}}
        <div class="form-section{{ (session('signup_errors') || (old('_signup_submitted') == '1')) ? '' : ' active' }}" id="section-signin">
          {{-- <h2 class="form-title">Welcome back</h2>
          <p class="form-subtitle">Sign in to access your employer dashboard and manage your job postings.</p> --}}

          @if(session('error_message'))
            <div class="znp-alert znp-alert-error" style="margin-top:16px;">{{ session('error_message') }}</div>
          @endif
          @if ($errors->has('email') && !session('signup_errors'))
            <div class="znp-alert znp-alert-error" style="margin-top:16px;">{{ $errors->first('email') }}</div>
          @endif

          <form method="POST" action="{{ route('company.login.new') }}" style="margin-top:20px;">
            @csrf
            <div class="form-group">
              <label class="form-label" for="signin-email">Email Address <span class="required">*</span></label>
              <div class="input-with-icon">
                <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                  <polyline points="22,6 12,13 2,6"/>
                </svg>
                <input type="email" name="email" id="signin-email" class="form-input has-toggle"
                       placeholder="your.email@company.com"
                       value="{{ old('email') }}" autocomplete="email" required>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="signin-password">Password <span class="required">*</span></label>
              <div class="input-with-icon">
                <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input type="password" name="password" id="signin-password" class="form-input has-toggle"
                       placeholder="Enter your password" autocomplete="current-password" required>
                <button type="button" class="password-toggle" onclick="znpTogglePassword('signin-password', this)" aria-label="Toggle password visibility">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                </button>
              </div>
            </div>

            <div class="form-options">
              <label class="checkbox-label">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                Remember me
              </label>
              <a href="{{ route('company.password.request') }}" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-primary">Sign In</button>

            <div class="alt-action">
              Don't have an account? <a onclick="znpSwitchTab('signup')">Create one now</a>
            </div>
          </form>
        </div>

        {{-- ═══ SIGN UP FORM (MULTI-STEP) ═══ --}}
        <div class="form-section{{ session('signup_errors') || (old('_signup_submitted') == '1') ? ' active' : '' }}" id="section-signup">
          {{-- <h2 class="form-title">Create your account</h2>
          <p class="form-subtitle">Join us &amp; hire top talent with zero notice period.</p> --}}

          @if(session('success'))
            <div class="znp-alert znp-alert-success" style="margin-top:16px;">{{ session('success') }}</div>
          @endif

          {{-- Progress bar --}}
          <div style="margin-top: 22px;">
            <div class="znp-step-bar">
              <div class="znp-step-seg active" id="ps1"></div>
              <div class="znp-step-seg" id="ps2"></div>
              <div class="znp-step-seg" id="ps3"></div>
            </div>
            {{-- <div class="znp-step-label" id="progress-label">Step 1 of 3 — Company Information</div> --}}
          </div>

          <form method="POST" action="{{ route('company.register.page.store') }}"
                enctype="multipart/form-data" id="signup-form">
            @csrf
            <input type="hidden" name="_signup_submitted" value="1">

            {{-- ── STEP 1: Company Information ── --}}
            <div id="step1" style="margin-top: 22px;">
              @if(session('signup_errors'))
                <div class="znp-alert znp-alert-error">Please fix the errors below and resubmit.</div>
              @endif

              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="company_name">Company Name <span class="required">*</span></label>
                  <input type="text" name="company_name" id="company_name" class="form-input"
                         placeholder="Your Company Ltd."
                         value="{{ old('company_name') }}" required>
                  @if($errors->has('company_name'))
                    <div style="color:#dc2626;font-size:11px;margin-top:4px;">{{ $errors->first('company_name') }}</div>
                  @endif
                </div>
                <div class="form-group">
                  <label class="form-label" for="signup-email">Official Email <span class="required">*</span></label>
                  <input type="email" name="email" id="signup-email" class="form-input"
                           placeholder="you@company.com"
                           value="{{ old('email') }}" autocomplete="email" required oninput="znpChkEm(this)">
                    <div id="signup-emst" style="margin-top:6px"></div>
                  @if($errors->has('email'))
                    <div style="color:#dc2626;font-size:11px;margin-top:4px;">{{ $errors->first('email') }}</div>
                  @endif
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="signup-password">Password <span class="required">*</span></label>
                  <div class="input-with-icon">
                    <input type="password" name="password" id="signup-password" class="form-input has-toggle"
                           placeholder="Create password" autocomplete="new-password" required>
                    <button type="button" class="password-toggle" onclick="znpTogglePassword('signup-password', this)" aria-label="Toggle password visibility">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                      </svg>
                    </button>
                  </div>
                  @if($errors->has('password'))
                    <div style="color:#dc2626;font-size:11px;margin-top:4px;">{{ $errors->first('password') }}</div>
                  @endif
                </div>
                <div class="form-group">
                  <label class="form-label" for="signup-password-confirm">Confirm Password <span class="required">*</span></label>
                  <div class="input-with-icon">
                    <input type="password" name="confirm_password" id="signup-password-confirm" class="form-input has-toggle"
                           placeholder="Re-enter password" autocomplete="new-password" required>
                    <button type="button" class="password-toggle" onclick="znpTogglePassword('signup-password-confirm', this)" aria-label="Toggle password visibility">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                      </svg>
                    </button>
                  </div>
                  @if($errors->has('confirm_password'))
                    <div style="color:#dc2626;font-size:11px;margin-top:4px;">{{ $errors->first('confirm_password') }}</div>
                  @endif
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="mobile">Mobile Number <span class="required">*</span></label>
                  <input type="tel" name="mobile" id="mobile" class="form-input"
                         placeholder="9876543210"
                         value="{{ old('mobile') }}" required>
                  @if($errors->has('mobile'))
                    <div style="color:#dc2626;font-size:11px;margin-top:4px;">{{ $errors->first('mobile') }}</div>
                  @endif
                </div>
                <div class="form-group">
                  <label class="form-label" for="person_name">Contact Person <span class="required">*</span></label>
                  <input type="text" name="person_name" id="person_name" class="form-input"
                         placeholder="Hiring Manager"
                         value="{{ old('person_name') }}" required>
                  @if($errors->has('person_name'))
                    <div style="color:#dc2626;font-size:11px;margin-top:4px;">{{ $errors->first('person_name') }}</div>
                  @endif
                </div>
              </div>

              <div class="step-nav">
                <button type="button" class="btn-primary" onclick="znpGoStep(2)">Continue</button>
              </div>

              <div class="alt-action">
                Already have an account? <a onclick="znpSwitchTab('signin')">Sign in</a>
              </div>
            </div>

            {{-- ── STEP 2: Business Details ── --}}
            <div id="step2" style="display:none; margin-top: 22px;">
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="designation">Designation <span class="required">*</span></label>
                  <input type="text" name="designation" id="designation" class="form-input"
                         placeholder="e.g. HR Manager"
                         value="{{ old('designation') }}" required>
                  @if($errors->has('designation'))
                    <div style="color:#dc2626;font-size:11px;margin-top:4px;">{{ $errors->first('designation') }}</div>
                  @endif
                </div>
                <div class="form-group">
                  <label class="form-label" for="company_type">Business Entity Type <span class="required">*</span></label>
                  <select name="company_type" id="company_type" class="form-select" required>
                    <option value="">Select Type</option>
                    <option value="pvt_ltd" {{ old('company_type') == 'pvt_ltd' ? 'selected' : '' }}>Private Limited</option>
                    <option value="llp"     {{ old('company_type') == 'llp'     ? 'selected' : '' }}>LLP</option>
                    <option value="partnership" {{ old('company_type') == 'partnership' ? 'selected' : '' }}>Partnership</option>
                    <option value="sole"    {{ old('company_type') == 'sole'    ? 'selected' : '' }}>Sole Proprietorship</option>
                    <option value="public"  {{ old('company_type') == 'public'  ? 'selected' : '' }}>Public Limited</option>
                    <option value="other"   {{ old('company_type') == 'other'   ? 'selected' : '' }}>Other</option>
                  </select>
                  @if($errors->has('company_type'))
                    <div style="color:#dc2626;font-size:11px;margin-top:4px;">{{ $errors->first('company_type') }}</div>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <label class="form-label" for="size">Company Headcount <span class="required">*</span></label>
                <select name="size" id="size" class="form-select" required>
                  <option value="">Select Company Size</option>
                  <option value="1-10"         {{ old('size') == '1-10'         ? 'selected' : '' }}>1–10 employees</option>
                  <option value="11-50"        {{ old('size') == '11-50'        ? 'selected' : '' }}>11–50 employees</option>
                  <option value="51-200"       {{ old('size') == '51-200'       ? 'selected' : '' }}>51–200 employees</option>
                  <option value="201-500"      {{ old('size') == '201-500'      ? 'selected' : '' }}>201–500 employees</option>
                  <option value="501-1000"     {{ old('size') == '501-1000'     ? 'selected' : '' }}>501–1,000 employees</option>
                  <option value="1001-5000"    {{ old('size') == '1001-5000'    ? 'selected' : '' }}>1,001–5,000 employees</option>
                  <option value="5001-10000"   {{ old('size') == '5001-10000'   ? 'selected' : '' }}>5,001–10,000 employees</option>
                  <option value="10001-25000"  {{ old('size') == '10001-25000'  ? 'selected' : '' }}>10,001–25,000 employees</option>
                  <option value="25001-50000"  {{ old('size') == '25001-50000'  ? 'selected' : '' }}>25,001–50,000 employees</option>
                  <option value="50001-75000"  {{ old('size') == '50001-75000'  ? 'selected' : '' }}>50,001–75,000 employees</option>
                  <option value="75001-100000" {{ old('size') == '75001-100000' ? 'selected' : '' }}>75,001–1,00,000 employees</option>
                  <option value="100000+"      {{ old('size') == '100000+'      ? 'selected' : '' }}>1,00,000+ employees</option>
                </select>
                @if($errors->has('size'))
                  <div style="color:#dc2626;font-size:11px;margin-top:4px;">{{ $errors->first('size') }}</div>
                @endif
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="gstin">GSTIN <span style="color:var(--text-muted);font-weight:400;">(Optional)</span></label>
                  <input type="text" name="gstin" id="gstin" class="form-input"
                         placeholder="22AAAAA0000A1Z5"
                         value="{{ old('gstin') }}" maxlength="15">
                  @if($errors->has('gstin'))
                    <div style="color:#dc2626;font-size:11px;margin-top:4px;">{{ $errors->first('gstin') }}</div>
                  @endif
                </div>
                <div class="form-group">
                  <label class="form-label" for="pincode">PIN Code <span class="required">*</span></label>
                  <input type="text" name="pincode" id="pincode" class="form-input"
                         placeholder="560001"
                         value="{{ old('pincode') }}" maxlength="6" required>
                  @if($errors->has('pincode'))
                    <div style="color:#dc2626;font-size:11px;margin-top:4px;">{{ $errors->first('pincode') }}</div>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <label class="form-label" for="linkedin">LinkedIn Profile</span><span class="required">*</span></label>
                <input type="url" name="linkedin" id="linkedin" class="form-input"
                       placeholder="https://linkedin.com/company/your-company"
                       value="{{ old('linkedin') }}">
                @if($errors->has('linkedin'))
                  <div style="color:#dc2626;font-size:11px;margin-top:4px;">{{ $errors->first('linkedin') }}</div>
                @endif
              </div>

              <div class="step-nav">
                <button type="button" class="btn-secondary" onclick="znpGoStep(1)">← Back</button>
                <button type="button" class="btn-primary" onclick="znpGoStep(3)">Continue</button>
              </div>
            </div>

            {{-- ── STEP 3: Upload & Confirm ── --}}
            <div id="step3" style="display:none; margin-top: 22px;">
              <!--<div class="info-note">-->
              <!--  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">-->
              <!--    <circle cx="12" cy="12" r="10"/>-->
              <!--    <line x1="12" y1="16" x2="12" y2="12"/>-->
              <!--    <line x1="12" y1="8" x2="12.01" y2="8"/>-->
              <!--  </svg>-->
              <!--  <div class="info-note-text">-->
              <!--    Your account will be reviewed within 24 hours. You'll receive a confirmation email once approved.-->
              <!--  </div>-->
              <!--</div>-->

              <div class="form-group">
                <label class="form-label">Company Logo</label>
                <div class="file-upload">
                  <label for="logo-upload" class="file-upload-label" id="file-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                      <polyline points="17 8 12 3 7 8"/>
                      <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    Choose File
                  </label>
                  <input type="file" name="logo" id="logo-upload" accept="image/jpeg,image/jpg,image/png"
                         onchange="znpUpdateFileName(this)">
                  <div class="file-name" id="file-name">Accepts JPEG, JPG, PNG (max 2 MB)</div>
                </div>
              </div>

              {{-- ── Company Highlights ── --}}
              <div style="margin-bottom: 18px;">
                <div class="form-label" style="margin-bottom: 10px; font-weight: 600;">Company Highlights <span style="color:var(--text-muted);font-weight:400;font-size:11px;">(shown on your job listings)</span></div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                  <label class="checkbox-item" style="padding: 8px 12px; background: #f8f9ff; border: 1px solid var(--border); border-radius: 8px;">
                    <input type="checkbox" name="is_gptw_certified" value="1" {{ old('is_gptw_certified') ? 'checked' : '' }}>
                    <span>Great Place to Work Certification</span>
                  </label>
                  <label class="checkbox-item" style="padding: 8px 12px; background: #f8f9ff; border: 1px solid var(--border); border-radius: 8px;">
                    <input type="checkbox" name="is_top_employer" value="1" {{ old('is_top_employer') ? 'checked' : '' }}>
                    <span>Linkedln Top Companies</span>
                  </label>
                  <label class="checkbox-item" style="padding: 8px 12px; background: #f8f9ff; border: 1px solid var(--border); border-radius: 8px;">
                    <input type="checkbox" name="is_disability_hiring" value="1" {{ old('is_disability_hiring') ? 'checked' : '' }}>
                    <span>Disability Hiring</span>
                  </label>
                  <label class="checkbox-item" style="padding: 8px 12px; background: #f8f9ff; border: 1px solid var(--border); border-radius: 8px;">
                    <input type="checkbox" name="is_women_friendly" value="1" {{ old('is_women_friendly') ? 'checked' : '' }}>
                    <span>Women Friendly</span>
                  </label>
                </div>
              </div>

              <div class="checkbox-group">
                <label class="checkbox-item">
                  <input type="checkbox" name="promotional" value="1" {{ old('promotional') ? 'checked' : '' }}>
                  I agree to receive promotional communications from ZeroNoticePeriod
                </label>
                <label class="checkbox-item">
                  <input type="checkbox" name="terms" value="1" {{ old('terms') ? 'checked' : '' }}>
                  I have read and agree to the
                  <a href="{{ url('/terms-and-conditons') }}" target="_blank">Terms &amp; Conditions</a>
                  and <a href="{{ url('/privacy-policy') }}" target="_blank">Privacy Policy</a>
                </label>
                @if($errors->has('terms'))
                  <div style="color:#dc2626;font-size:11px;">{{ $errors->first('terms') }}</div>
                @endif
              </div>

              <div class="step-nav">
                <button type="button" class="btn-secondary" onclick="znpGoStep(2)">← Back</button>
                <button type="submit" class="btn-primary">Create Account</button>
              </div>
            </div>

          </form>{{-- end signup-form --}}
        </div>{{-- end section-signup --}}

      </div>{{-- end form-content --}}
    </div>{{-- end form-panel --}}

  </div>{{-- end auth-container --}}
</div>{{-- end znp-employer-auth --}}

@include('znp.footer')
@endsection

@push('scripts')
<script>
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    'X-Requested-With': 'XMLHttpRequest',
    Accept: 'application/json'
  }
});
// ── Tab switcher ──
function znpSwitchTab(tab) {
    document.querySelectorAll('.tab-btn').forEach(function(btn) {
        btn.classList.remove('active');
    });
    document.getElementById('tab-' + tab).classList.add('active');

    document.querySelectorAll('.form-section').forEach(function(section) {
        section.classList.remove('active');
    });
    document.getElementById('section-' + tab).classList.add('active');

    if (tab === 'signup') {
        znpGoStep(1);
    }
}

// ── Password toggle ──
function znpTogglePassword(inputId, button) {
    var input = document.getElementById(inputId);
    var isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    button.style.color = isPassword ? 'var(--blue)' : 'var(--text-light)';
}

// ── File name display ──
function znpUpdateFileName(input) {
    var label = document.getElementById('file-name');
    if (input.files && input.files[0]) {
        label.textContent = input.files[0].name;
        label.style.fontStyle = 'normal';
        label.style.color = 'var(--blue)';
    }
}

// ─────────────────────────────────────────
// ── Validation helpers ──
// ─────────────────────────────────────────
var znpCurrentStep = 1;
// Real-time email check state for employer signup
var znpEmailCheckTimer = null;
var znpEmailCheckXhr = null;
var znpEmailExists = false;

function znpMarkInvalid(el, msg) {
    el.classList.add('is-invalid');
    var fg = el.closest('.form-group');
    if (!fg) return;
    var existing = fg.querySelector('.znp-fe-err');
    if (existing) {
        existing.textContent = msg;
    } else {
        var err = document.createElement('span');
        err.className = 'znp-fe-err';
        err.textContent = msg;
        fg.appendChild(err);
    }
}

function znpMarkValid(el) {
    el.classList.remove('is-invalid');
    var fg = el.closest('.form-group');
    if (!fg) return;
    var existing = fg.querySelector('.znp-fe-err');
    if (existing) existing.remove();
}

// Clear error on input/change
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#signup-form .form-input, #signup-form .form-select').forEach(function(el) {
        el.addEventListener('input', function() { znpMarkValid(this); });
        el.addEventListener('change', function() { znpMarkValid(this); });
    });
});

/* ─── znpChkEm: realtime email check for employer signup ─── */
function znpChkEm(inp) {
  var el = document.getElementById('signup-emst');
  if (!el) return;
  var v = (inp.value || '').trim();
  znpEmailExists = false;
  if (znpEmailCheckTimer) clearTimeout(znpEmailCheckTimer);
  if (znpEmailCheckXhr && znpEmailCheckXhr.abort) znpEmailCheckXhr.abort();
  if (!v) { el.innerHTML = ''; inp.classList.remove('is-invalid'); return; }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) {
    inp.classList.add('is-invalid');
    el.innerHTML = '<div style="color:#dc2626;font-size:11px">Invalid email format</div>';
    return;
  }
  inp.classList.remove('is-invalid');
  el.innerHTML = '<div style="color:#94a3b8;font-size:11px">Checking email…</div>';
  znpEmailCheckTimer = setTimeout(function () {
    znpEmailCheckXhr = $.ajax({
      type: 'POST',
      url: '{{ url("check-email") }}',
      dataType: 'json',
      data: { email: v, account_type: 'employer', _token: '{{ csrf_token() }}' },
      success: function (data) {
        znpEmailExists = !!(data && data.exists);
        if (znpEmailExists) {
          inp.classList.add('is-invalid');
          el.innerHTML = '<div style="color:#dc2626;font-size:11px">This email is already registered. Please sign in.</div>';
        } else {
          inp.classList.remove('is-invalid');
          el.innerHTML = '<div style="color:#16a34a;font-size:11px">✓ Looks good</div>';
        }
      },
      error: function () {
        el.innerHTML = '<div style="color:#94a3b8;font-size:11px">Could not verify email right now</div>';
      }
    });
  }, 350);
}

function znpValidateStep(step) {
    var valid = true;
    var firstInvalid = null;

    function check(id, msg, extraFn) {
        var el = document.getElementById(id);
        if (!el) return;
        var val = el.value.trim();
        var fail = !val || (extraFn && !extraFn(val));
        if (fail) {
            znpMarkInvalid(el, msg);
            if (!firstInvalid) firstInvalid = el;
            valid = false;
        } else {
            znpMarkValid(el);
        }
    }

    if (step === 1) {
        check('company_name', 'Company Name is required');
        check('signup-email', 'Enter a valid email address', function(v) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
        });
      // prevent proceeding if email was detected as already registered
      var emEl = document.getElementById('signup-email');
      if (emEl && znpEmailExists) {
        znpMarkInvalid(emEl, 'This email is already registered. Please sign in.');
        if (!firstInvalid) firstInvalid = emEl;
        valid = false;
      }
        check('signup-password', 'Password must be at least 6 characters', function(v) {
            return v.length >= 6;
        });
        // Confirm password
        var pw  = document.getElementById('signup-password');
        var cpw = document.getElementById('signup-password-confirm');
        if (cpw) {
            var cpwVal = cpw.value.trim();
            if (!cpwVal) {
                znpMarkInvalid(cpw, 'Please confirm your password');
                if (!firstInvalid) firstInvalid = cpw;
                valid = false;
            } else if (pw && cpwVal !== pw.value) {
                znpMarkInvalid(cpw, 'Passwords do not match');
                if (!firstInvalid) firstInvalid = cpw;
                valid = false;
            } else {
                znpMarkValid(cpw);
            }
        }
        check('mobile', 'Enter a valid 10-digit mobile number', function(v) {
            return /^\d{10}$/.test(v);
        });
        check('person_name', 'Contact Person name is required');
    }

    if (step === 2) {
        check('designation', 'Designation is required');
        check('company_type', 'Business Entity Type is required');
        check('size', 'Company Headcount is required');
        check('pincode', 'Enter a valid 6-digit PIN code', function(v) {
            return /^\d{6}$/.test(v);
        });
    }

    if (!valid && firstInvalid) {
        firstInvalid.focus();
        var fg = firstInvalid.closest('.form-group') || firstInvalid;
        fg.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    return valid;
}

function znpValidateStep3() {
    var termsEl = document.querySelector('#signup-form input[name="terms"]');
    if (termsEl && !termsEl.checked) {
        var fg = termsEl.closest('.checkbox-group');
        var existing = fg ? fg.querySelector('.znp-fe-err') : null;
        if (!existing && fg) {
            var err = document.createElement('span');
            err.className = 'znp-fe-err';
            err.textContent = 'You must accept the Terms & Conditions to continue';
            fg.appendChild(err);
        }
        return false;
    }
    // Clear terms error if checked
    var fg = termsEl ? termsEl.closest('.checkbox-group') : null;
    if (fg) {
        var ex = fg.querySelector('.znp-fe-err');
        if (ex) ex.remove();
    }
    return true;
}

// Also clear the terms error when user checks the box
document.addEventListener('DOMContentLoaded', function() {
    var termsEl = document.querySelector('#signup-form input[name="terms"]');
    if (termsEl) {
        termsEl.addEventListener('change', function() {
            if (this.checked) {
                var fg = this.closest('.checkbox-group');
                if (fg) { var e = fg.querySelector('.znp-fe-err'); if (e) e.remove(); }
            }
        });
    }
});

// ── Multi-step navigation ──
function znpGoStep(step) {
    // Validate current step before going forward
    if (step > znpCurrentStep) {
        if (!znpValidateStep(znpCurrentStep)) return;
    }
    znpCurrentStep = step;

    [1, 2, 3].forEach(function(i) {
        document.getElementById('step' + i).style.display = (i === step) ? 'block' : 'none';
    });
    [1, 2, 3].forEach(function(i) {
        var el = document.getElementById('ps' + i);
        if (i <= step) { el.classList.add('active'); }
        else           { el.classList.remove('active'); }
    });
    var labels = [
        'Step 1 of 3 — Company Information',
        'Step 2 of 3 — Business Details',
        'Step 3 of 3 — Upload & Confirm'
    ];
    document.getElementById('progress-label').textContent = labels[step - 1];
    document.querySelector('.form-panel').scrollTo({ top: 0, behavior: 'smooth' });
}

// ── Form submit: validate step 3 terms ──
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('signup-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!znpValidateStep3()) {
                e.preventDefault();
            }
        });
    }
});

// ── On page load: open Sign Up tab if there were signup validation errors ──
(function() {
    var signupSection = document.getElementById('section-signup');
    if (signupSection && signupSection.classList.contains('active')) {
        document.getElementById('tab-signin').classList.remove('active');
        document.getElementById('tab-signup').classList.add('active');
    }
})();

// ── Show success modal (if present) and keep Sign In as default behind it ──
document.addEventListener('DOMContentLoaded', function() {
    var AUTOCLOSE_MS = 6000;
    var modal = document.getElementById('znp-success-modal');
    if (!modal) return;

    // hide inline alert if somehow present
    var inline = document.querySelector('.znp-alert-success');
    if (inline) inline.style.display = 'none';

    // force Sign In tab behind the modal
    var tabSignin = document.getElementById('tab-signin');
    var tabSignup = document.getElementById('tab-signup');
    var secSignin = document.getElementById('section-signin');
    var secSignup = document.getElementById('section-signup');
    if (tabSignin) { tabSignin.classList.add('active');    tabSignup.classList.remove('active'); }
    if (secSignin) { secSignin.classList.add('active');    secSignup.classList.remove('active'); }

    // set CSS variable so bar animation matches timer
    var content = modal.querySelector('.znp-modal-content');
    if (content) content.style.setProperty('--znp-bar-dur', (AUTOCLOSE_MS / 1000) + 's');

    // open (tiny delay so transition fires)
    setTimeout(function() { modal.classList.add('open'); }, 16);

    var znpPrevFocus = document.activeElement;
    var autoCloseTimer = null;

    function znpClose() {
        modal.classList.remove('open');
        if (autoCloseTimer) { clearTimeout(autoCloseTimer); autoCloseTimer = null; }
        if (znpPrevFocus && znpPrevFocus.focus) znpPrevFocus.focus();
    }
    window.znpCloseSuccessModal = znpClose;

    // wire "Continue to Sign In" button
    var cta = document.getElementById('znp-success-close');
    if (cta) { cta.focus(); cta.addEventListener('click', znpClose); }

    // auto-close timer
    autoCloseTimer = setTimeout(znpClose, AUTOCLOSE_MS);

    // pause bar on hover
    modal.addEventListener('mouseenter', function() {
        modal.classList.add('paused');
        if (autoCloseTimer) { clearTimeout(autoCloseTimer); autoCloseTimer = null; }
    });
    modal.addEventListener('mouseleave', function() {
        modal.classList.remove('paused');
        if (!autoCloseTimer) autoCloseTimer = setTimeout(znpClose, 2500);
    });

    // ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') znpClose();
    });
});
</script>
@endpush
